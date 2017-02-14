<?php
 
namespace Mymodule\Test\Plugin;
 
use Magento\Framework\Message\ManagerInterface as MessageManager;
 
class Myplugin {
	private $messageManager;
 
	public function __construct(MessageManager $messageManager){
 
    	$this->messageManager = $messageManager;
	}

	public function afterSetCustomerDataAsLoggedIn(\Magento\Customer\Model\Session $session, $result){
    	$this->messageManager->addSuccessMessage("Welocme To myplugin");
    	return $result;
	}
 
}
