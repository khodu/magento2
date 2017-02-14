<?php
namespace Ktpl\Brand\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Ktpl\Brand\Model\Brand;

class Save extends \Magento\Backend\App\Action
{
    protected $_newsFactory; 
    protected $_coreRegistry; 
    protected $_resultPageFactory; 
    protected $_objectManager1;
    
//    public function __construct()//\Magento\Framework\ObjectManagerInterface $objectManager) 
//  {
//    //$this->_objectManager = $objectManager;
//
//  }
//   
//   
    public function execute()
   {
       
      $isPost = $this->getRequest()->getPost();
     // print_r($this->getRequest()->getParams()); exit;
      if ($isPost) {
           $newsModel = $this->_objectManager->create('Ktpl\Brand\Model\Brand');

         //$newsModel = $this->_newsFactory->create();
         $newsId = $this->getRequest()->getParam('id');
 
         if ($newsId) {
            $newsModel->load($newsId);
         }
         $formData = $this->getRequest()->getParam('brand');
         $newsModel->setData($formData);
         
         try {
            // Save news
            $newsModel->save();
 
            // Display success message
            $this->messageManager->addSuccess(__('The Brand has been saved.'));
 
            // Check if 'Save and Continue'
            if ($this->getRequest()->getParam('back')) {
               $this->_redirect('*/*/edit', ['id' => $newsModel->getId(), '_current' => true]);
               return;
            }
 
            // Go to grid page
            $this->_redirect('*/*/');
            return;
         } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
         }
 
         $this->_getSession()->setFormData($formData);
         $this->_redirect('*/*/edit', ['id' => $newsId]);
      }
   }
}
 