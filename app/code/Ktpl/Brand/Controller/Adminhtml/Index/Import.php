<?php

namespace Ktpl\Brand\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Ktpl\Brand\Model\Brand;
use Magento\Framework\App\Request\DataPersistorInterface;

class Import extends \Magento\Backend\App\Action {

    protected $_newsFactory;
    protected $_coreRegistry;
    protected $_resultPageFactory;
    protected $_objectManager1;
    protected $dataPersistor;
    protected $_logger;
    protected $_attributeRepository;
    protected $_attributeOptionManagement;
    protected $_option;
    protected $_attributeOptionLabel;

    public function __construct(
            Action\Context $context, DataPersistorInterface $dataPersistor,
            \Psr\Log\LoggerInterface $logger, 
            \Magento\Eav\Model\AttributeRepository $attributeRepository, 
            \Magento\Eav\Api\AttributeOptionManagementInterface $attributeOptionManagement, 
            \Magento\Eav\Api\Data\AttributeOptionLabelInterface $attributeOptionLabel, 
            \Magento\Eav\Model\Entity\Attribute\Option $option
    ) {
        $this->_logger = $logger;
        $this->_attributeRepository = $attributeRepository;
        $this->_attributeOptionManagement = $attributeOptionManagement;
        $this->_option = $option;
        $this->_attributeOptionLabel = $attributeOptionLabel;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    
    public function execute() {
             $resultRedirect = $this->resultRedirectFactory->create();
            $attribute_id = $this->_attributeRepository->get('catalog_product', 'manufacturer')->getAttributeId();
            $options = $this->_attributeOptionManagement->getItems('catalog_product', $attribute_id);
            /* if attribute option already exists, remove it */
            foreach ($options as $a=>$option) { 
            
         
               // if ($option->getLabel() == $name) {
                    $models = $this->_objectManager->create('Ktpl\Brand\Model\Brand')->getCollection();
                    $mo = $this->_objectManager->create('Ktpl\Brand\Model\Brand');
                    
                    foreach ($models as $model){
                        if($model->getManufactureId()==$option->getValue()){
                            $mo->load($model->getId());
                        }
                    }
                    if($a){
                        $mo->setManufactureId($option->getValue());
                        $mo->setBrandTitle($option->getLabel());
                        $mo->save(); 
                    } 
            }
            return $resultRedirect->setPath('*/*/');        
                    
    }

}
