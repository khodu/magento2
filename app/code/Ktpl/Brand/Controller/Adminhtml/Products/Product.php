<?php

namespace  Ktpl\Brand\Controller\Adminhtml\Products;

abstract class Product extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Ktpl_Brand::item_list';


}