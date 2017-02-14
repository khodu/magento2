<?php
namespace Ktpl\Brand\Controller\Adminhtml\Index\Image;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class Upload
 */
class Upload extends \Magento\Backend\App\Action
{
    /**
     * Image uploader
     *
     * @var \[Namespace]\[Module]\Model\ImageUploader
     */
    protected $imageUploader;
    protected $dataProcessor;
    protected $appEmulation;
    protected $filterProvider;


public function __construct(
    \Magento\Store\Model\App\Emulation $appEmulation, 
     \Ktpl\Brand\Model\ImageUploader $imageUploader,   
    \Magento\Cms\Model\Template\FilterProvider $filterProvider,      
    Action\Context $context 
    )
{
    
    $this->filterProvider = $filterProvider; 
    $this->appEmulation = $appEmulation;    
     $this->imageUploader = $imageUploader;
    parent::__construct($context);        
}
    /**
     * Check admin permissions for this controller
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return true;
    }

    /**
     * Upload file controller action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try {
            $result = $this->imageUploader->saveFileToTmpDir('brand_image');

            $result['cookie'] = [
                'name' => $this->_getSession()->getName(),
                'value' => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path' => $this->_getSession()->getCookiePath(),
                'domain' => $this->_getSession()->getCookieDomain(),
            ];
        } catch (Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}