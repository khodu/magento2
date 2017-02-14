<?php

/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Ktpl\Brand\Model;

use Ktpl\Brand\Model\ResourceModel\Brand\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;


class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider {

    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $pageCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $pageCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $pageCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
       
    }


    public function getData() {

        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();

        foreach ($items as $customRow) {
            $brand = $customRow->getData();

            if (isset($brand['brand_image'])) {
                $image = $brand['brand_image'];
                unset($brand['brand_image']);
                $brand['brand_image'][0]['name'] = $image;

                $brand['brand_image'][0]['url'] = 'http://localhost/magento2/pub/media/catalog/tmp/category1/'.$image;
            }
            
            $this->loadedData[$customRow->getId()] = $brand;
        }

       // $data = $this->dataPersistor->get('brandgrid');

//        if (!empty($data)) {
//            echo "dsa";exit;
//            $page = $this->collection->getNewEmptyItem();
//            $page->setData($data);
//            $page = $page->getData();
//            print_r($page);
//             
//            
//            
//            $this->loadedData[$page->getId()] = $page;
//            $this->dataPersistor->clear('brandgrid');
//        }
        
        return $this->loadedData;
    }

}
