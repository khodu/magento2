<?php
namespace Ktpl\Brand\Model\ResourceModel;
class Brand extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('brand','brand_id');
    }
}
