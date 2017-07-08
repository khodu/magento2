<?php
       
namespace  Ktpl\Brand\Controller\Adminhtml\Index;

class Grid extends \Ktpl\Brand\Controller\Adminhtml\Products\Product
{
    /**
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    protected $resultRawFactory;

    /**
     * @var \Magento\Framework\View\LayoutFactory
     */
    protected $layoutFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\RawFactory $resultRawFactory
     * @param \Magento\Framework\View\LayoutFactory $layoutFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
        \Magento\Framework\View\LayoutFactory $layoutFactory
    ) {
        
        $this->resultRawFactory = $resultRawFactory;
        $this->layoutFactory = $layoutFactory;
        parent::__construct($context);
    }

    /**
     * Grid Action
     * Display list of products related to current category
     *
     * @return \Magento\Framework\Controller\Result\Raw
     */
    public function execute()
    {
        $item = $this->_initItem(true);
        if (!$item) {
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('module/item/new', ['_current' => true, 'id' => null]);
        }
        /** @var \Magento\Framework\Controller\Result\Raw $resultRaw */
        $resultRaw = $this->resultRawFactory->create();
        return $resultRaw->setContents(
            $this->layoutFactory->create()->createBlock(
                'Ktpl\Brand\Block\Adminhtml\Products\Edit\Tab\Product',
                'category.product.grid'
            )->toHtml()
        );
    }

     protected function _initItem($getRootInstead = false)
    {
        $id = (int)$this->getRequest()->getParam('id', false);
        $myModel = $this->_objectManager->create('Ktpl\Brand\Model\Brandproduct');

        if ($id) {
            $myModel->load($id);            
        }
        echo 'sdghs'; exit;
        $this->_objectManager->get('Magento\Framework\Registry')->register('item', $myModel);
        $this->_objectManager->get('Magento\Framework\Registry')->register('my_item', $myModel);
        $this->_objectManager->get('Magento\Cms\Model\Wysiwyg\Config');
        return $storeModel;
    }   


}