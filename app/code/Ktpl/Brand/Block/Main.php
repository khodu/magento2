<?php
namespace Ktpl\Brand\Block;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\Template\Context;



class Main extends \Magento\Framework\View\Element\Template
{
    protected $request;
    protected $_productFactory;
    protected $_productAttributeRepository;
    protected $_productloader; 
    /**
     * @param RequestInterface $request
     */
    public function __construct(RequestInterface $request,Context $context,
            \Magento\Catalog\Model\Product\Attribute\Repository $productAttributeRepository,
            \Magento\Catalog\Model\ProductFactory $_productloader,
   \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,array $data = []
   )
    {
        $this->request = $request; 
        $this->_productAttributeRepository = $productAttributeRepository;
        $this->_productloader = $_productloader;
        $this->_productFactory   = $productCollectionFactory;
        parent::__construct($context,$data);
        //echo '<pre />'; print_r($this->request->getParam('attribute')); 
    }
//    public function _prepareLayout() {
//        $todo = $this->_productFactory->create();
//        $collection = $todo->getCollection();
//        $this->setCollection($collection);
//        
//      
//    }
    public function getPCollection()
    {
       // echo 'afsh'; exit;
        $attr = $this->request->getParam('attribute');
        $manufacturerOptions = $this->_productAttributeRepository->get('manufacturer')->getOptions();
        foreach ($manufacturerOptions as $manufacturerOption) {
            if($attr ==$manufacturerOption->getLabel()){
                $atid = $manufacturerOption->getValue();  // Value
            }
        }
        //get values of current page
        $page=($this->getRequest()->getParam('p'))? $this->getRequest()->getParam('p') : 1;
    //get values of current limit
        $pageSize=($this->getRequest()->getParam('limit'))? $this->getRequest()->getParam('limit') : 1;
        //echo 'afsh'; exit;
            $collection = $this->_productFactory->create();
            $collection->addAttributeToSelect('*');
           // $collection->addAttributeToFilter('visibility', \Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH);
           // $collection->addAttributeToFilter('status',\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED);
           $collection->setPageSize($pageSize);
           $collection->setCurPage($page);
            $collection->addAttributeToFilter('manufacturer', ['eq' => $atid])
                    ;
        
        return $collection;
    }

     public function getLoadProduct($id)
    {
        return $this->_productloader->create()->load($id);
    }
    
    protected function _prepareLayout()
{
    parent::_prepareLayout();
    $this->pageConfig->getTitle()->set(__('Brand'));


    if ($this->getPCollection()) {
        $pager = $this->getLayout()->createBlock(
            'Magento\Theme\Block\Html\Pager',
            'fme.news.pager'
        )->setAvailableLimit(array(1=>1,2=>2,15=>15))->setShowPerPage(true)->setCollection(
            $this->getPCollection()
        );
        $this->setChild('pager', $pager);
        $this->getPCollection()->load();
    }
    return $this;
}
    public function getPagerHtml()
{
    return $this->getChildHtml('pager');
}
    
}
