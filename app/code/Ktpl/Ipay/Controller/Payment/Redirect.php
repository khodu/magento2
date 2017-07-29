<?php

namespace Ktpl\Ipay\Controller\Payment;
use \Ktpl\Ipay\Model\Ipay\PayPlugin;
//use lib\Ipay;

class Redirect extends \Magento\Framework\App\Action\Action
{
    protected $_checkoutSession;
    protected $_orderFactory;
    
    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession, 
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Magento\Framework\App\Action\Context $context   
            )
       {
        $this->_checkoutSession = $checkoutSession;
        $this->_orderFactory = $orderFactory;
        return parent::__construct($context);
    }
    
    public function execute()
    {
        //$_order = new \Magento\Sales\Model\Order();
        $_order = $this->getOrder();
        $orderId =  $this->_checkoutSession->getLastRealOrderId();
        //$_order->loadByIncrementId($orderId);
        //require_once ('.php');
        $Pay = new PayPlugin('ini.properties');
        $request = $_POST;
        $currency = "480";
        $amount = $_order->getBaseGrandTotal();
        $url_arr = pathinfo("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME']);
        $returnurl = $url_arr["dirname"] . "/ipay/payment/response/"; // Your URL to going back from payment gate

        try {
            $response_reg = $Pay->registerRequest(array("orderNumber" => $orderId, "amount" => $amount, "currency" => $currency, "returnUrl" => $returnurl));
        } catch (\Exception $e) {
            echo $e->getMessage();
            die();
        }
        header('Location: ' . $response_reg["formUrl"]);
        die;
    }
        
    
    public function getOrder()
    {
        if ($this->_checkoutSession->getLastRealOrderId()) {
             $order = $this->_orderFactory->create()->loadByIncrementId($this->_checkoutSession->getLastRealOrderId());
        return $order;
        }
        return false;
    }
}
