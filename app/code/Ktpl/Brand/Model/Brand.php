<?php
namespace Ktpl\Brand\Model;
class Brand extends \Magento\Framework\Model\AbstractModel implements BrandInterface, \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'brand';

    protected function _construct()
    {
        $this->_init('Ktpl\Brand\Model\ResourceModel\Brand');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
