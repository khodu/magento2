<?php
namespace Ktpl\Ipay\Model;
class Standard extends \Magento\Payment\Model\Method\AbstractMethod
{
    protected $_code = 'ipay';
	
    protected $_isInitializeNeeded      = true;
    protected $_canUseInternal          = true;
    protected $_canUseForMultishipping  = false;
        
//	public function getOrderPlaceRedirectUrl() {
//		return $this->getUrl('ipay/payment/redirect', array('_secure' => true));
//	}
     protected $_urlBuilder;
    
    public function __construct(
       \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory,
        \Magento\Payment\Helper\Data $paymentData,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Payment\Model\Method\Logger $logger,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []  
            )
       {
            parent::__construct(
                $context,
                $registry,
                $extensionFactory,
                $customAttributeFactory,
                $paymentData,
                $scopeConfig,
                $logger,
                $resource,
                $resourceCollection,
                $data
            );
            $this->_urlBuilder = $urlBuilder;
    }    
        public function getCheckoutRedirectUrl()
    {
        return $this->_urlBuilder->getUrl('ipay/payment/redirect');
    }

}
