<?php
 namespace Ktpl\Brand\Ui\Component\Listing\Column;
 
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Store\Model\StoreManagerInterface;
 


class Images extends \Magento\Ui\Component\Listing\Columns\Column
{
    
    protected $_storeManager;
 
    /**
     * @param ContextInterface      $context
     * @param UiComponentFactory    $uiComponentFactory
     * @param StoreManagerInterface $storemanager
     * @param array                 $components
     * @param array                 $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        StoreManagerInterface $storemanager,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->_storeManager = $storemanager;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
   public function prepareDataSource(array $dataSource)
    {
        $mediaDirectory = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        if (isset($dataSource['data']['items'])) {  
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $badgeArray=array();
                    $imagesContainer='';
                        //imagesArray contain images
                        $imagesArray = array(
                            [
                                'image_url' => $item[$fieldName]
                            ]
                            );
                        foreach ($imagesArray as $image) {
                            $imageUrl = $mediaDirectory.'catalog/tmp/category1/'.$item[$fieldName];
                            $imagesContainer = $imagesContainer."<img src=". $imageUrl ." width='50px' height='50px' style='display:inline-block;margin:2px'/>";
                        }
                    $item[$fieldName]=$imagesContainer;
 
            }
        }
        return $dataSource;
    }

    
}