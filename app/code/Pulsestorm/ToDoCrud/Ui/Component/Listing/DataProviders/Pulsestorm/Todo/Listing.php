<?php
namespace Pulsestrom\ToDoCrud\Ui\Component\Listing\DataProviders\Pulsestorm\Todo;

class Listing extends \Magento\Ui\DataProvider\AbstractDataProvider
{    
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Pulsestorm\ToDoCrud\Model\ResourceModel\TodoItem\CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }
}
