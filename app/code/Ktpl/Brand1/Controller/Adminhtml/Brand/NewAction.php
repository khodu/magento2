<?php
namespace Ktpl\Brand\Controller\Adminhtml\Brand;
use Ktpl\Brand\Controller\Adminhtml\News;
 
class NewAction extends \Magento\Backend\App\Action
{
   /**
     * Create new news action
     *
     * @return void
     */
   public function execute()
   {
      $this->_forward('edit');
   }
}
