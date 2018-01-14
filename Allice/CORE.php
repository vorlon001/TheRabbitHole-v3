<?php

namespace Allice;



class CORE {
    static function ERROR_LOG(String $sms) {
	error_log($sms);
    }

    static function run_found_route(String $_CONFIG, $route, $url = NULL) {
	//try catch
	$EventDispatcher= $_CONFIG::EventDispatcher;
	$Event		= $_CONFIG::Event;
	$TheRabbitHole	= $_CONFIG::TheRabbitHole;

	if($route->path->class!=NULL) {
	    try {

		$RT = $TheRabbitHole::getInstance($EventDispatcher, $route->getItem('path')->class);

		$route_new=$RT->matchItem(\Allice\Module\Cloud::newObject(TRUE)->addArray([
			    						    'DNS'	=> $route->getItem('request')->DNS,
									    'VALUE_DNS' => $route->getItem('request')->getItem('VALUE_DNS'),
									    'CLASS_LOG' => $route->getItem('request')->CLASS_LOG,
									    'CLASS'	=> $route->getItem('path')->class,
									    'req'	=> ( $url == NULL ) ? $route->request->VALUE->command : $url
									    ])
					    );
	    
		if(debug_trace==TRUE) $EventDispatcher::getInstance()->dispatch(
										$Event::SYSTEM_LOG,
										'run found route/method...',
									        \Allice\Module\Cloud::newObject(TRUE)->addArray([
											    			    'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
														    'value' => [
															        $route_new,
																]
														    ])
										);
		$EventDispatcher::getInstance()->dispatch(
							    $Event::ROUTE_FOUND,
							    'run found route/method...',
							    \Allice\Module\Cloud::newObject(TRUE)->addArray([
												'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
												'value' => [
													    $route_new,
													    ]
											        ])
						    );
	    } catch(Throwable $e) {
    		$EventDispatcher::getInstance()->dispatch(
	    	    $Event::CORE_ERROR,
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
	    return TRUE;
	} else if($route->path->method!=NULL) {
	    try {
		if(debug_trace==TRUE) $EventDispatcher::getInstance()->dispatch(
										$Event::SYSTEM_LOG,
										'model found, running method...',
										\Allice\Module\Cloud::newObject(TRUE)->addArray([
														    'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
														    'value' => [
																$route,
																]
														    ])
    										);
		$EventDispatcher::getInstance()->dispatch(
							    $Event::MODEL_RUN,
					    		    'model found, running method...',
							    \Allice\Module\Cloud::newObject(TRUE)->addArray([
												'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
												'value' => [
														$route,
													    ]
												])
							    );
	    } catch(Throwable $e) {
    		$EventDispatcher::getInstance()->dispatch(
	    	    $Event::CORE_ERROR,
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

	    return TRUE;
	}  else {
	    try {
		if(debug_trace==TRUE) $EventDispatcher::getInstance()->dispatch(
    										$Event::SYSTEM_LOG,
										'class/method not found...',
										\Allice\Module\Cloud::newObject(TRUE)->addArray([
	    						    							    'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
														    'value' => [
						    				    						$route,
																]
														    ])
										);
		$EventDispatcher::getInstance()->dispatch(
							    $Event::MODEL_FOUND,
							    'class/method not found...',
							    \Allice\Module\Cloud::newObject(TRUE)->addArray([
    			    									'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
												'value' => [
					    								    $route,
													    ]
												])
							);
	    } catch(Throwable $e) {
    		$EventDispatcher::getInstance()->dispatch(
	    	    $Event::CORE_ERROR,
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
	    return NULL;    
	}
    }

    static function run_method(String $_CONFIG, $event) {
	// try catch
	    $EventDispatcher	= $_CONFIG::EventDispatcher;
	    $Event		= $_CONFIG::Event;

	try {

	    $request = $event->value{0};
	    $c=$request->path->method{'class'};
	    $m=$request->path->method{'method'};

	    $view = $event->value{0}->path->view;

	    $o = new $c($_CONFIG);
	    $render = $o->$m($event->value{0}->request);
	    $o = NULL;

	    if(debug_trace==TRUE) $EventDispatcher::getInstance()->dispatch(
									    $Event::SYSTEM_LOG,
		    	    						    'run VIEW...',
									    \Allice\Module\Cloud::newObject(TRUE)->addArray([
														'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
														'value' => [
				    		    									    $render,
															    $view
															    ]
														])
									    );
	    $EventDispatcher::getInstance()->dispatch(
							$Event::RENDER_VIEW,
	    						'run VIEW...',
							\Allice\Module\Cloud::newObject(TRUE)->addArray([
											    'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
											    'value' => [
		    						    				        $render,
													$view
													]
											    ])
						    );

        } catch(Throwable $e) {
	    $EventDispatcher::getInstance()->dispatch(
    		$Event::CORE_ERROR,
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

	return TRUE;
    }
    static function run_render_view(String $_CONFIG, $event) {
	try {

	    $EventDispatcher	= $_CONFIG::EventDispatcher;
	    $Event		= $_CONFIG::Event;

	    $c = $event->value{1}{'class'};
	    $m = $event->value{1}{'method'};
	    $o = new $c($_CONFIG);
	    $o->$m($event->value);
	    $o = NULL;
        } catch(Throwable $e) {
	    $EventDispatcher::getInstance()->dispatch(
    		$Event::CORE_ERROR,
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
    }
    static function run_found_domain(String $_CONFIG, String $_dns_url, String $_request_url) {
	// try catch
	    $EventDispatcher	= $_CONFIG::EventDispatcher;
	    $Event		= $_CONFIG::Event;
	    $TheRabbitHole	= $_CONFIG::TheRabbitHole;
	    $ROUTE_DNS		= $_CONFIG::ROUTE_DNS;

	try {

	    $RT = $TheRabbitHole::getInstance($EventDispatcher, $ROUTE_DNS);
	    $route = $RT->matchItem(\Allice\Module\Cloud::newObject(TRUE)->addArray([
									'DNS'	=> $_dns_url,
									'CLASS_LOG' => [],
									'CLASS'	=> ROUTE_DNS::class,
									])
				    );

	    $route->getItem('request')->VALUE_DNS = $route->getItem('request')->getItem('VALUE');

	    if(debug_trace==TRUE) $EventDispatcher::getInstance()->dispatch(
									    $Event::SYSTEM_LOG,
									    'run found route/method...',
									    \Allice\Module\Cloud::newObject(TRUE)->addArray([
														'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
														'value' => [
															    $route,
															    $_request_url
															    ]
														])
									    );
	    $EventDispatcher::getInstance()->dispatch(
							$Event::ROUTE_FOUND,
							'run found route/method...',
							\Allice\Module\Cloud::newObject(TRUE)->addArray([
											    'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
											    'value' => [
					    							        $route,
													$_request_url
													]
											    ])
		);;
    	} catch(Throwable $e) {
	    $EventDispatcher::getInstance()->dispatch(
    		$Event::CORE_ERROR,
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
    }
}

?>
