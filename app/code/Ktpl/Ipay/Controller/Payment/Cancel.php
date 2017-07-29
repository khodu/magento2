<?php
namespace Ktpl\Ipay\Controller\Payment;
class Cancel extends \Magento\Framework\App\Action\Action
{
    protected $_checkoutSession;
    
    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession, 
        \Magento\Framework\App\Action\Context $context    
            )
       {
        $this->_checkoutSession = $checkoutSession;
        return parent::__construct($context);
    }
    
    public function execute()
    {
       if ($this->_checkoutSession->getLastRealOrderId()) {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $order = $objectManager->create('\Magento\Sales\Model\order')->loadByIncrementId($this->_checkoutSession->getLastRealOrderId());
            if ($order->getId()) {
                // Flag the order as 'cancelled' and save it
                $order->cancel()->setState(\Magento\Sales\Model\Order::STATE_CANCELED, true, 'Gateway has declined the payment.')->save();
            }
        }
    }
       
}
