<?php
namespace Ktpl\Brand\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;

class Edit extends \Magento\Backend\App\Action
{
   protected $_coreRegistry = null;

    protected $resultPageFactory;

    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return true;//$this->_authorization->isAllowed('Ktpl_Brand::save_brand');
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    { 
         $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Ktpl_Brand::menu_2')
            ->addBreadcrumb(__('Brand'), __('Brand'))
            ->addBreadcrumb(__('Manage Brand'), __('Manage Brand'));
        return $resultPage;
    }

    /**
     * Edit Blog post
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {

         $id = $this->getRequest()->getParam('id'); 
        $model = $this->_objectManager->create('Ktpl\Brand\Model\Brand');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This Brand no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        } 

//        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
//        if (!empty($data)) {
//            $model->setData($data);
//        }

        $this->_coreRegistry->register('brandgrid', $model);
        
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction(); //echo 'asdg'; exit;
        $resultPage->addBreadcrumb(
            $id ? __('Edit Brand') : __('New Brand'),
            $id ? __('Edit Brand') : __('New Brand')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Brand'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getBrandId() ? $model->getTitle() : __('New Brand'));
       // echo 'dfha'; exit;
        return $resultPage;
    }
}
 