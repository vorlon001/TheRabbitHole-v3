<?php

namespace Allice\Event;

class Dispatcher {
    private static $instance = null;
    private function __clone() {}
    private function __sleep(){}
    private function __wakeup(){}
    public function __isset($name) {}
    public function __unset($name) {}
    public function __set($name, $value) {}
    public function __get($name) {}
    

    private $_domain_request = NULL;
    
    private $_CONFIG		= NULL;
    public $EventDispatcher 	= NULL;
    public $Event		= NULL;
    private $CORE		= NULL;
    private $TheRabbitHole	= NULL;
    private $ROUTE_DNS		= NULL;


    private $view   = [];
    private $model  = [];
    private $routes = [];
    private $route  = [];
    private    function __construct(String $_CONFIG) {
	$this->_CONFIG 		= $_CONFIG;
	$this->EventDispatcher 	= $_CONFIG::EventDispatcher;
	$this->Event		= $_CONFIG::Event;
	$this->CORE  		= $_CONFIG::CORE;
	$this->TheRabbitHole 	= $_CONFIG::TheRabbitHole;
	$this->ROUTE_DNS 	= $_CONFIG::ROUTE_DNS;
    }
    public static function initInstance(String $_CONFIG) {
	if (null === self::$instance)
	{
    	    $_class = __CLASS__;
    	    self::$instance = new $_class($_CONFIG);
	    return self::$instance;
	}
	return self::$instance;
    }
    public static function getInstance() {
	if (self::$instance == NULL)
	{
	    error_log('[{Code:ZERO} {Event: CONFIG NOT YET SET} {Initiator: '
					.__METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage().
					' {Value: NOT YET  SET}]');
	    // header 500!
	    die(); 
	}
	return self::$instance;
    }

    function dispatch(Int $code, String $eventName, \Allice\Module\Cloud $event) { 
	switch($code) {
	    case $this->Event::CORE_ERROR:
		$this->CORE::ERROR_LOG('[{Code:' . $code . '} {Event:' . $eventName . '} {Initiator:' . $event->id .'} {Value:' . json_encode($event->value).'}]');
    		$this->dispatch(
	    		$this->Event::SYSTEM_CORE_LOG,
			'ERROR CORE...',
    	    		\Allice\Module\Cloud::newObject(TRUE)->addArray([
							    'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
							    'value' => [
									 $event->value
									]
	    						])
		    );
		
		break;
	    case $this->Event::ERROR:
		try {
		    $m = ($e = $event->value{0})->getMessage();
		    $c = $e->getCode();
		    $f = $e->getFile();
		    $l = $e->getLine();
		    $t = json_encode($e->getTrace());
		    $sms = 'Cheshire Cat Say:'.$m.' C:'.$c.' F:'.$f.' L:'.$l.' T:'.$t;
		    print('[{Code:' . $code . '} {Event:' . $eventName . '} {Initiator:' . $event->id .'} {Value:"' . $sms .'"}]'.PHP_EOL);
		    global $class_log;
		    $class_log->write_message(
						$this->_domain_request,
						$code,
						$eventName,
						$event->id,
						json_encode($sms)
		    				); 
		} catch(Throwable $e) {
	    	    $this->dispatch(
		        $this->Event::CORE_ERROR,
			'ERROR CORE...',
	    	        \Allice\Module\Cloud::newObject(TRUE)->addArray([
		    	    				'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
		    	    				'value' => [
								    "POINT:[".
				    					"Message :{" . $e->getMessage()."}".
				    					"Code :{" . $e->getCode()."}".
				    					"File :{" . $e->getFile()."}".
				    					"Line :{" . $e->getLine()."}".
				    					"Dump :{" . $e->getTraceAsString()."}".
								    "]"
								    ]
			    				])
			);
		}

        	break;
	    case $this->Event::LOG: 
		print('[{Code:' . $code . '} {Event:' . $eventName . '} {Initiator:' . $event->id .'} {Value:' . json_encode($event->value).'}]'.PHP_EOL);
		try {
		    global $class_log;
		    $class_log->write_message(
						$this->_domain_request,
						$code,
						$eventName,
						$event->id,
						json_encode($event->value)
					    ); 
		} catch(Throwable $e) {
		    $this->dispatch(
			$this->Event::CORE_ERROR,
			'ERROR CORE...',
			\Allice\Module\Cloud::newObject(TRUE)->addArray([
					    		    'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
					    		    'value' => [
						    			    "POINT:[".
									    "Message :{" . $e->getMessage()."}".
									    "Code :{" . $e->getCode()."}".
									    "File :{" . $e->getFile()."}".
									    "Line :{" . $e->getLine()."}".
									    "Dump :{" . $e->getTraceAsString()."}".
		    							    "]"
									]
							    ])
		    );
		}

        	break;
	    case $this->Event::SYSTEM_CORE_LOG:
    	    case $this->Event::SYSTEM_LOG:
		print('[{Code:' . $code . '} {Event:' . $eventName . '} {Initiator:' . $event->id .'} {Value:' . json_encode($event->value).'}]'.PHP_EOL);
		try {
	    	    global $class_log; 
		    $class_log->write_message(
		    			    ((isset($this->_domain_request))?$this->_domain_request:'NOT YET SET'),
					    $code,
		    			    $eventName,
					    $event->id,
					    json_encode($event->value)
		    			); 
		} catch(Throwable $e) {
		    $this->dispatch(
								$this->Event::CORE_ERROR,
								'ERROR CORE...',
								\Allice\Module\Cloud::newObject(TRUE)->addArray([
		    	    									    'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
		    	    									    'value' => [
														"POINT:[".
				    										"Message :{" . $e->getMessage()."}".
				    										"Code :{" . $e->getCode()."}".
				    										"File :{" . $e->getFile()."}".
				    										"Line :{" . $e->getLine()."}".
				    										"Dump :{" . $e->getTraceAsString()."}".
					    									"]"
														]
			    									    ])
							    );
		}
	        break;
	    case $this->Event::DOMAIN_FOUND:
		$this->_domain_request = (isset($event->value{0}))?$event->value{0}:NULL;
		if(debug_trace==TRUE) $this->dispatch(
										$this->Event::SYSTEM_LOG,
										'exec ROUTE FOUND...',
										\Allice\Module\Cloud::newObject(TRUE)->addArray([
														    'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
														    'value' => [
	    															$event,
																]
														    ]
														)
										);
		
		$this->CORE::run_found_domain($this->_CONFIG,$event->value{0},$event->value{1});
		break;
	    case $this->Event::ROUTE_FOUND: 
		if(debug_trace==TRUE) $this->dispatch(
										$this->Event::SYSTEM_LOG,
										'exec ROUTE FOUND...',
										\Allice\Module\Cloud::newObject(TRUE)->addArray([
														    'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
														    'value' => [
			    			    										$event,
																]
														    ]
														)
										);
		$this->CORE::run_found_route($this->_CONFIG,$event->value{0},(isset($event->value{1}))?$event->value{1}:NULL);
            break;
	    case $this->Event::MODEL_RUN:
		if(debug_trace==TRUE) $this->dispatch(
										$this->Event::SYSTEM_LOG,
										'exec MODEL RUN...',
										\Allice\Module\Cloud::newObject(TRUE)->addArray([
														    'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
														    'value' => [
	    															$event,
																]
														    ]
														)
										);
		$this->CORE::run_method($this->_CONFIG,$event);
		break;
    	    case $this->Event::RENDER_VIEW:
		if(debug_trace==TRUE) $this->dispatch(
										$this->Event::SYSTEM_LOG,
										'exec VIEW RENDER...',
										\Allice\Module\Cloud::newObject(TRUE)->addArray([
														    'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
														    'value' => [
	    															$event,
																]
														    ]
														)
										);
		$this->CORE::run_render_view($this->_CONFIG,$event);
		break;
    	    default:
		if(debug_trace==TRUE) $this->dispatch(
										$this->Event::SYSTEM_LOG,
										'CODE EVENT NOT FOUND...',
										\Allice\Module\Cloud::newObject(TRUE)->addArray([
	    													    'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
														    'value' => [
	    															$event,
																]
														    ]
														)
										);
	    break;
	}
    }
}

?>
