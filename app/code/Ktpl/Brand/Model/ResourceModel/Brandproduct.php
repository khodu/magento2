<?php
namespace Ktpl\Brand\Model\ResourceModel;
class Brandproduct extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('brand_product','rel_id');
    }
}
