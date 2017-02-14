<?php
namespace Ktpl\Brand\Model\ResourceModel\Brand;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Ktpl\Brand\Model\Brand','Ktpl\Brand\Model\ResourceModel\Brand');
    }
}
