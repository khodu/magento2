<?php

namespace Ktpl\Brand\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Ktpl\Brand\Model\Brand;
use Magento\Framework\App\Request\DataPersistorInterface;

class Save extends \Magento\Backend\App\Action {

    protected $_newsFactory;
    protected $_coreRegistry;
    protected $_resultPageFactory;
    protected $_objectManager1;
    protected $dataPersistor;
    protected $_logger;
    protected $_attributeRepository;
    protected $_attributeOptionManagement;
    protected $_option;
    protected $tableFactory;
  
    protected $_attributeOptionLabel;
    protected $_attribute;
    public function __construct(
            Action\Context $context, DataPersistorInterface $dataPersistor,
            \Psr\Log\LoggerInterface $logger, 
            \Magento\Eav\Model\Entity\Attribute\Source\TableFactory $tableFactory,
            \Magento\Eav\Model\AttributeRepository $attributeRepository, 
            \Magento\Eav\Api\AttributeOptionManagementInterface $attributeOptionManagement, 
            \Magento\Eav\Api\Data\AttributeOptionLabelInterface $attributeOptionLabel, 
            \Magento\Eav\Model\Entity\Attribute\Option $option//,
           // \Magento\Catalog\Model\Resource\Eav\Attribute $attribute
    ) {
        $this->_logger = $logger;
        $this->_attributeRepository = $attributeRepository;
        $this->_attributeOptionManagement = $attributeOptionManagement;
        $this->_option = $option;
        $this->tableFactory = $tableFactory;
//       $this->_attribute = $attribute;
        $this->_attributeOptionLabel = $attributeOptionLabel;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    protected function _filterPostData(array $rawData) {
        $data = $rawData;
        // @todo It is a workaround to prevent saving this data in category model and it has to be refactored in future
        if (isset($data['brand_image']) && is_array($data['brand_image'])) {
            if (!empty($data['brand_image']['delete'])) {
                $data['brand_image'] = null;
            } else {
                if (isset($data['brand_image'][0]['name']) && isset($data['brand_image'][0]['tmp_name'])) {
                    $data['brand_image'] = $data['brand_image'][0]['name'];
                } else {
                    unset($data['brand_image']);
                }
            }
        }
        return $data;
    }
    
     public function getOptionId($attributeCode, $label, $force = false)
    {
        /** @var \Magento\Catalog\Model\ResourceModel\Eav\Attribute $attribute */
        //$attribute = $this->getAttribute($attributeCode);
        $attribute = $this->_attributeRepository->get('catalog_product', 'manufacturer');

        // Build option array if necessary
        if ($force === true || !isset($this->attributeValues[ $attribute->getAttributeId() ])) {
            $this->attributeValues[ $attribute->getAttributeId() ] = [];

            // We have to generate a new sourceModel instance each time through to prevent it from
            // referencing its _options cache. No other way to get it to pick up newly-added values.

            /** @var \Magento\Eav\Model\Entity\Attribute\Source\Table $sourceModel */
            $sourceModel = $this->tableFactory->create();
            $sourceModel->setAttribute($attribute);

            foreach ($sourceModel->getAllOptions() as $option) {
                $this->attributeValues[ $attribute->getAttributeId() ][ $option['label'] ] = $option['value'];
            }
        }

        // Return option ID if exists
        if (isset($this->attributeValues[ $attribute->getAttributeId() ][ $label ])) {
            return $this->attributeValues[ $attribute->getAttributeId() ][ $label ];
        }

        // Return false if does not exist
        return false;
    }

    public function execute() {
        // print_r($_POST); exit;
        $mid = $this->getRequest()->getPostValue('manufacture_id');
        $name = $this->getRequest()->getPostValue('brand_title');
               
        $data1 = $this->getRequest()->getPostValue();

        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data1) {
            $data = $this->_filterPostData($data1);
            if (empty($data['brand_id'])) {
                $data['brand_id'] = null;
            }
            $attribute = $this->_attributeRepository->get('catalog_product', 'manufacturer');
            //$attribute_id = $this->_attributeRepository->get('catalog_product', 'manufacturer')->getAttributeId();
            /* new attribute option */ 
            if($mid){
                
                $values = array(
                    $mid => array(
                       0 => $name
                   )
                );
               $data['option']['value'] = $values;
               $attribute ->addData($data);
               $attribute->save();
            }else{
                $this->_option->setValue($name);
                $this->_attributeOptionLabel->setStoreId(0);
                $this->_attributeOptionLabel->setLabel($name);
                $this->_option->setLabel($this->_attributeOptionLabel);
                $this->_option->setStoreLabels([$this->_attributeOptionLabel]);
                $this->_option->setSortOrder(0);
                $this->_option->setIsDefault(false);
                $this->_attributeOptionManagement->add('catalog_product', $attribute->getAttributeId(), $this->_option);
               
                $attribute_id = $this->_attributeRepository->get('catalog_product', 'manufacturer')->getAttributeId();
                $options = $this->_attributeOptionManagement->getItems('catalog_product', $attribute_id);
                
               $mid = $this->getOptionId('manufacturer', $name);
                /*foreach($options as $option) {
                        print_r($option->getData()); exit;
                    if ($option->getLabel() == $name) {
                        $_POST['manufacture_id']=$option->getValue(); 
                    } print_r($_POST); exit;
                } */

            }


                
                //echo '<pre />'; print_r( $this->_attributeOptionManagement->getId()); exit;
           // }
            /** @var \Magento\Cms\Model\Page $model */
            $model = $this->_objectManager->create('Ktpl\Brand\Model\Brand');
            
            $id = $this->getRequest()->getParam('brand_id');
            if ($id) {
                $model->load($id);
            }

            $model->setData($data);
            $model->setManufactureId($mid);
            try {
                $model->save();
                $this->messageManager->addSuccess(__('The Brand has been saved.'));
                $this->dataPersistor->clear('brandgrid');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getBrandId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the Brand.'));
            }

            $this->dataPersistor->set('brandgrid', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

}
