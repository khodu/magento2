<?php
namespace Ktpl\Brand\Model;
class Brandproduct extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'brand_product';

    protected function _construct()
    {
        $this->_init('Ktpl\Brand\Model\ResourceModel\Brandproduct');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
