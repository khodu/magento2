<?php
namespace Ktpl\Brand\Controller\Adminhtml\Brand;

use Magento\Backend\App\Action;

class Delete extends \Magento\Backend\App\Action
{
   public function execute()
   {
      $newsId = (int) $this->getRequest()->getParam('id');
 
      if ($newsId) {
         /** @var $newsModel \Mageworld\SimpleNews\Model\News */
         $newsModel = $this->_newsFactory->create();
         $newsModel->load($newsId);
 
         // Check this news exists or not
         if (!$newsModel->getId()) {
            $this->messageManager->addError(__('This Brand no longer exists.'));
         } else {
               try {
                  // Delete news
                  $newsModel->delete();
                  $this->messageManager->addSuccess(__('The Brand has been deleted.'));
 
                  // Redirect to grid page
                  $this->_redirect('*/*/');
                  return;
               } catch (\Exception $e) {
                   $this->messageManager->addError($e->getMessage());
                   $this->_redirect('*/*/edit', ['id' => $newsModel->getId()]);
               }
            }
      }
   }
}