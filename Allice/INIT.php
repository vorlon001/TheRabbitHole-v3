<?php
namespace Allice;

class INIT {
    static function LOAD($_PHP_MODULE,$_LOGGER) {
	$_PHP_MODULE::getInstance()->verify();
	$_LOGGER::initInstance();
    }
    static function GO($_CONFIG) {
	$p = ($_CONFIG::Pudding)::getInstance($_CONFIG);

	($_CONFIG::EventDispatcher)::initInstance($_CONFIG,$p->_server('HTTP_HOST'))->dispatch(
					($_CONFIG::Event)::SYSTEM_LOG,
					'init CORE...',
				            \Allice\Module\Cloud::newObject(TRUE)->addArray([
					    		    'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
							    'value' => [
							            "[URL:".$p->_server('REQUEST_URI')."] [CLIENT:".$p->_get_host()."] [UA:".$p->_ua()."]",
								]
							    ])
					);

	$p = ($_CONFIG::Pudding)::getInstance($_CONFIG);

	$url = explode("?", $p->_server('REQUEST_URI'))[0];
	$dns = $p->_server('HTTP_HOST');

	$p->_unset_get('url');
	$p->_unset_get('dns');
	$p->_unset_server('QUERY_STRING');


	($_CONFIG::EventDispatcher)::getInstance()->dispatch(
		        ($_CONFIG::Event)::DOMAIN_FOUND,
		        'run found route/method...',
		        \Allice\Module\Cloud::newObject(TRUE)->addArray([
					'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
					'value' => [
						    $dns,	// 'wdx123.xyz.ru',
					    	    $url	// '/api/v1/profile/image/get/id_vorlon-256'
					        ]
					])
	);

    }
}

?>