<?php
namespace Ktpl\Brand\Controller\Adminhtml\Brand;

use Magento\Backend\App\Action;

class Edit extends \Magento\Backend\App\Action
{
    public function execute()
   {
      $newsId = $this->getRequest()->getParam('brand_id');
        /** @var \Tutorial\SimpleNews\Model\News $model */
        $model = $this->_newsFactory->create();
 
        if ($newsId) {
            $model->load($newsId);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This Brand no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }
 
        // Restore previously entered form data from session
        $data = $this->_session->getNewsData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        $this->_coreRegistry->register('ktpl_brand', $model);
 
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Ktpl_Brand::main_menu');
        $resultPage->getConfig()->getTitle()->prepend(__('Simple Brand'));
 
        return $resultPage;
   }
}
 