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
        return $this->_authorization->isAllowed('Ktpl_Brand::save_brand');
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
      //  $resultPage->setActiveMenu('Ktpl_Brand::amrita_manufacturergrid')
       // ->addBreadcrumb(__('Manufacturers'), __('Manufacturers'))
       // ->addBreadcrumb(__('Manage Manufacturers'), __('Manage Manufacturers'));
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
        //echo 'asdg'; exit;
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

        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        $this->_coreRegistry->register('brand_grid', $model);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Brand') : __('New Brand'),
            $id ? __('Edit Brand') : __('New Brand')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Brand'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('New Brand'));

        return $resultPage;
    }
}
 