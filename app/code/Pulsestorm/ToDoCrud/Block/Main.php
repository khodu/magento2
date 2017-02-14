<?php
namespace Pulsestorm\ToDoCrud\Block;
class Main extends \Magento\Framework\View\Element\Template
{
    protected $toDoFactory;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Pulsestorm\ToDoCrud\Model\TodoItemFactory $toDoFactory
    )
    {
        $this->toDoFactory = $toDoFactory;
        parent::__construct($context);
    }

    function _prepareLayout()
    {
      $todo = $this->toDoFactory->create();

    $collection = $todo->getCollection();
    $this->setCollection($collection);
//        echo '<pre />';
//    foreach($collection as $item)
//    {
//        print_r('Item ID: ' . $item->getTitle());
//        print_r($item->getData());
//    }
//        exit;
    }
}
