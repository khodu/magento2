<?php

namespace Mymodule\SEO\Model;

class Cron {

    /** 	@var	\Psr\Log\LoggerInterface	$logger	 */
    protected $logger;

    /** 	@var	\Magento\Framework\ObjectManagerInterface	 */
    protected $objectManager;

    public function __construct(
    \Psr\Log\LoggerInterface
    $logger, \Magento\Framework\ObjectManagerInterface$objectManager
    ) {
        $this->logger = $logger;
        $this->objectManager = $objectManager;
    }

    public function checkSubscriptions() {
        $subscription = $this->objectManager->create('Pulsestorm\ToDoCrud\Model\TodoItem');
        $subscription->setTitle('this is from Cron');
        $subscription->setIs(1);
        
        $subscription->save();
        $this->logger->debug('Test subscription added');
    }

}
