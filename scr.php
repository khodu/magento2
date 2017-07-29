<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require('vendor/zendframework/zend-server/src/Client.php');
require('vendor/zendframework/zend-soap/src/Client.php');
require('vendor/zendframework/zend-soap/src/Client/Common.php');

$wsdlurl = 'http://10.16.16.220/magento2/soap/default?wsdl&services=salesOrderRepositoryV1';

$token = 'bva0k8ingd9q5uo7tb4hvx8jbat6s3t3';


$opts = ['http' => ['header' => "Authorization: Bearer ".$token]];
$context = stream_context_create($opts);
//$arguments =
$serviceArgs = array('searchCriteria'=> 
        array('filterGroups' => 
            array ('filters' =>
                array('field' =>'increment_id',
                      'value' => '000000002' , 
                      'condition_type' => 'eq')
                )
         )
);
$soapClient = new \Zend\Soap\Client($wsdlurl);
$soapClient->setSoapVersion(SOAP_1_2);
$soapClient->setStreamContext($context);
$result = $soapClient->salesOrderRepositoryV1GetList($serviceArgs);//array('searchCriteria' => $serviceArgs));
//$result = $soapClient->customerCustomerRepositoryV1GetById(array('customerId' => 1));
/*'search_criteria'=> 
        array('filter_groups' => 
            array ('filters' =>
                array('field' =>'firstname',
                      'value' => 'Veronica' , 
                      'condition_type' => 'eq')
                )
         )
);*/
echo "<pre>"; print_r($result); 
?>