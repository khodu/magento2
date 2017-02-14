<?php
namespace Ktpl\Brand\Controller;

class Router implements \Magento\Framework\App\RouterInterface
{
    protected $actionFactory;
    protected $_response;
 
    /**
     * @param \Magento\Framework\App\ActionFactory $actionFactory
     * @param \Magento\Framework\App\ResponseInterface $response
     */
    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory,
        \Magento\Framework\App\ResponseInterface $response
    ) {
        $this->actionFactory = $actionFactory;
        $this->_response = $response;
    }
 
    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        $identifier = trim($request->getPathInfo(), '/'); 
        $at=explode('/',$identifier);
      
       // exit;
        if(strpos($identifier, 'brand') !== false) {
            $request->setModuleName('brand')->setControllerName('index')->setActionName('index')->setParam('attribute', $at[1]);
        } else if(strpos($identifier, 'pepe') !== false) {
            //$request->setModuleName('inchootest')->setControllerName('test')->setActionName('test');
        } else {
            //There is no match
            return;
        }
      
        return $this->actionFactory->create(
            'Magento\Framework\App\Action\Forward',
            ['request' => $request]
        );
    }
}