<?php

namespace Mymodule\SEO\Block\Adminhtml\Subscription;

use Magento\Backend\Block\Widget\Grid as WidgetGrid;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended {

    /**     * 	@var	\Packt\HelloWorld\Model\Resource\Subscription\Collection
     */
    protected $_subscriptionCollection;

    /**
     * 	@param	\Magento\Backend\Block\Template\Context	$context
     * 	@param	\Magento\Backend\Helper\Data	$backendHelper
     * 	@param	
      \Packt\HelloWorld\Model\ResourceModel\Subscription\Collection
      $subscriptionCollection
     * 	@param	array	$data
     */
    public function __construct(
    \Magento\Backend\Block\Template\Context $context, \Magento\Backend\Helper\Data $backendHelper, \Pulsestorm\ToDoCrud\Model\ResourceModel\TodoItem\Collection
    $subscriptionCollection, array $data = []
    ) {
        $this->_subscriptionCollection = $subscriptionCollection;
        parent::__construct($context, $backendHelper, $data);
        $this->setEmptyText(__('No Subscriptions Found'));
    }

    /**
     * 	Initialize	the	subscription	collection
     *
     * 	@return	WidgetGrid
     */
    protected function _prepareCollection() {
        $this->setCollection($this->_subscriptionCollection);
        return parent::_prepareCollection();
    }

    /**
     * 	Prepare	grid	columns
     *
     * 	@return	$this
     */
    protected function _prepareColumns() {
        $this->addColumn(
                'id', array(
            'header' => __('ID'),
            'index' => 'pulsestorm_todocrud_todoitem_id',
                )
        );
        $this->addColumn(
                'title', [
            'header' => __('Title'),
            'index' => 'title',
                ]
        );
        $this->addColumn(
                'Active', [
            'header' => __('Status'),
            'index' => 'is_active',
                ]
        );
        
        return $this;
    }

}
