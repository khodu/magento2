<?php
namespace Ktpl\Ipay\Controller\Payment;
use \Ktpl\Ipay\Model\Ipay\PayPlugin;
class Response extends \Magento\Framework\App\Action\Action
{
    protected $_orderFactory;
    protected $_storeManager;    
    protected $_logger;
    protected $_urlBuilder;
    
    public function __construct(
        \Magento\Sales\Api\Data\OrderInterface  $orderFactory,
        \Psr\Log\LoggerInterface $logger,    
        \Magento\Framework\UrlInterface $urlBuilder,    
        \Magento\Store\Model\StoreManagerInterface $storeManager,      
        \Magento\Framework\App\Action\Context $context)    
    {
        $this->_storeManager = $storeManager;      
        $this->_logger = $logger;
        $this->_urlBuilder = $urlBuilder;
        $this->_orderFactory = $orderFactory;
        return parent::__construct($context);
    }
    
    public function execute()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
       // require_once ('PayPlugin.php');
	try {
            $Pay = new PayPlugin ();
            $request = $_GET;
            $orderId = $request ['orderId'];
	
            $status = $Pay->StatusRequest ( array (
		"orderId" => $orderId 
            ) );
	
            $order = $this->_orderFactory;
            $order->loadByIncrementId ( $status ['OrderNumber'] );
            $orderId1 = $order->getId ();
	// Getting order status code from ipay response
            $pay_status = $status ['OrderStatus'];
            $actioncode = $status ['ActionCode'];
            if ($actioncode==0 ) {
                //Mage::register('isSecureArea', 1);
                $storeId = $this->_storeManager->getStore()->getId();
                $this->_storeManager->setCurrentStore(0);
                //Mage::app()->setCurrentStore(\Magento_Core_Model_App::ADMIN_STORE_ID);
                    //this will be orderstatus is 2
                    // Order amount is fully authorized.
		$order->setState ( \Magento\Sales\Model\Order::STATE_PROCESSING, true, $status ['ActionCodeDescription'] );
		$order->save ();
		$items = $order->getAllItems ();
		foreach ( $items as $item ) {
                    $items_qty_ordered = floor ( $item->getQtyOrdered () );
                    $itemid = $item->getProductId ();
		}
		$product =  $objectManager->create('Magento\Catalog\Model\Product')->load ( $itemid );
                $this->_storeManager->setCurrentStore(0);
		$num =  $objectManager->create('Magento\CatalogInventory\Model\Stock\Item') ->loadByProduct ( $product )->getQty ();
		$product_qty_before = floor ( $num );
		$product_qty_after = ( int ) ($product_qty_before - $items_qty_ordered);
		$stockData ['qty'] = $product_qty_after;
		$product->setStockData ( $stockData );
		$product->save ();
		$order->sendNewOrderEmail ();
		$order->setEmailSent ( true );
		$return_url = $this->_urlBuilder->getUrl('checkout/onepage/success', array('_secure' => true));
		$this->_redirectUrl ( $return_url );
                $this->_storeManager->setCurrentStore($storeId);
            }
            else {		
                 $level = 'DEBUG';
                // saved in var/log/debug.log
                $this->_logger->log($level,'SBM', [$status]); 
		//Mage::log(var_export($status, true), null, 'SBM.log');
		//this will be orderstatus is 3 or 6
		// Authorization canceled/declined.
		if($pay_status==3 ||  $pay_status==6)
		{
                    $order->setState (\Magento\Sales\Model\Order::STATE_CANCELED, true, $status ['ActionCodeDescription'] );
                    $order->save ();										
                    $return_url = $this->_urlBuilder->getUrl('checkout/onepage/failure',array('_secure' => true));
                    $this->_redirect ( $return_url );									
                }
                else {
                    $order->setState ( \Magento\Sales\Model\Order::STATE_CANCELED, true, $status ['ActionCodeDescription'] );
                    $order->save ();
                    $return_url = $this->_urlBuilder->getUrl('checkout/onepage/failure', array('_secure' => true));
                    $this->_redirect ( $return_url );
                }
            }
	} catch (\Exception $e ) {
            echo $e->getMessage ();
            die ();
	}
    }
        
}
