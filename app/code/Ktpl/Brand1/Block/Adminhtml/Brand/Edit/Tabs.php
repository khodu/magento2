<?php
namespace Ktpl\Brand\Block\Adminhtml\Brand\Edit;
use \Magento\Backend\Block\Widget\Form\Generic;

use Magento\Backend\Block\Widget\Tabs as WidgetTabs;
 
class Tabs extends WidgetTabs
{
    /**
     * Class constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('brand_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Brand Information'));
    }
 
    /**
     * @return $this
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'brand_info',
            [
                'label' => __('General'),
                'title' => __('General'),
                'content' => $this->getLayout()->createBlock(
                    'Ktpl\Brand\Block\Adminhtml\Brand\Edit\Tab\Form'
                )->toHtml(),
                'active' => true
            ]
        );
 
        return parent::_beforeToHtml();
    }
}
 
