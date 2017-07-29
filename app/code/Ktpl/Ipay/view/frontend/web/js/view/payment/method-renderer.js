define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'ipay',
                component: 'Ktpl_Ipay/js/view/payment/ipay'
            }
        );
        return Component.extend({});
    }
);