<?php

namespace Mymodule\SEO\Block\Adminhtml;

class Subscription extends \Magento\Backend\Block\Widget\Grid\Container {

    protected function _construct() {
        $this->_blockGroup = 'Mymodule_SEO';
        $this->_controller = 'adminhtml_subscription';
        parent::_construct();
    }

}
