<?php
namespace Ktpl\Brand\Model\ResourceModel\Brandproduct;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'brand_id';
    protected function _construct()
    {
        $this->_init('Ktpl\Brand\Model\Brandproduct','Ktpl\Brand\Model\ResourceModel\Brandproduct');
    }
}
