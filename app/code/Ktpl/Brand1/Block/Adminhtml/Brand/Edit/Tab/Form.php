<?php
namespace Ktpl\Brand\Block\Adminhtml\Brand\Edit\Tab;
 
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Cms\Model\Wysiwyg\Config;
use Ktpl\Brand\Model\Status;
 
class Form extends Generic implements TabInterface
{
    /**
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    protected $_wysiwygConfig;
 
    /**
     * @var \Tutorial\SimpleNews\Model\Config\Status
     */
    protected $_newsStatus;
 
   /**
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param Config $wysiwygConfig
     * @param Status $newsStatus
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Config $wysiwygConfig,
        Status $newsStatus,
        array $data = []
    ) {
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_newsStatus = $newsStatus;
        parent::__construct($context, $registry, $formFactory, $data);
    }
 
    /**
     * Prepare form fields
     *
     * @return \Magento\Backend\Block\Widget\Form
     */
    protected function _prepareForm()
    {
      
        $model = $this->_coreRegistry->registry('brand_grid');
       // print_r($model); exit;
  
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('brand_');
        $form->setFieldNameSuffix('brand');
 
        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('General')]
        );
 
        if ($model->getId()) {
            $fieldset->addField(
                'brand_id',
                'hidden',
                ['name' => 'id']
            );
        }
        $fieldset->addField(
            'brand_title',
            'text',
            [
                'name'        => 'brand_title',
                'label'    => __('Title'),
                'required'     => true
            ]
        );
        $fieldset->addField(
            'brand_url',
            'text',
            [
                'name'        => 'brand_url',
                'label'    => __('Url'),
                'required'     => true
            ]
        );
        $fieldset->addField(
            'is_active',
            'select',
            [
                'name'      => 'status',
                'label'     => __('is_active'),
                'options' => ['1' => __('Enabled'), '0' => __('Disabled')],
               // 'options'   => $this->_newsStatus->toOptionArray()
            ]
        );
       
 
        $data = $model->getData();
        $form->setValues($data);
        $this->setForm($form);
 
        return parent::_prepareForm();
    }
 
    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Brand Info');
    }
 
    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Brand Info');
    }
 
    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }
 
    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }
}
 
 
