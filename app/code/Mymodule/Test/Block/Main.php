<?php
namespace Mymodule\Test\Block;
class Main extends \Magento\Framework\View\Element\Template
{
    //function _prepareLayout(){}
     public $assetRepository;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context, 
        array $data = [],    
        \Magento\Framework\View\Asset\Repository $assetRepository
    )
    {
        $this->assetRepository = $assetRepository;
        return parent::__construct($context, $data);
    }
}
