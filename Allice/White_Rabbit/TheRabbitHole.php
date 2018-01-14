<?php

namespace Allice\White_Rabbit;

class TheRabbitHole {

    const match = '/{[a-zA-Z\_]*?}/';
    private $routes = NULL;
    private $_class_routes_name = NULL;
    private $code_404;
    private $EventDispatcher = NULL;
    private $_class_routes = NULL;

    private function __clone() {}
    private function __construct(String $_event_bus, String $_routes) {
	$this->EventDispatcher = $_event_bus::getInstance(); 
	$this->_class_routes = new $_routes($_event_bus);
	$this->_class_routes_name = $_routes;
	$this->code_404 = $this->_class_routes->get_404();
	$this->add_routes($this->_class_routes->get_Routes());
	$this->builder_regex();
    }
    private function __sleep(){}
    private function __wakeup(){}
    public function __isset($name) {}
    public function __unset($name) {}
    public function __set($name, $value) {}
    public function __get($name) {}

    public static function getInstance(String $_event_bus, String $_routes)
    {	
	    $_class = __CLASS__;
            return new $_class($_event_bus, $_routes);
    }


    private function add_routes(Array $routes) {
	if(debug_trace==TRUE) $this->EventDispatcher->dispatch(
								$this->EventDispatcher->Event::SYSTEM_LOG,
								'add routes',
								\Allice\Module\Cloud::newObject(TRUE)->addArray([
								    'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
								    'value' => $routes
								    ])
								);
	$this->routes = $routes;
    }
    

    private function compiler_regex (String $r): String {
	if($r == '/') return '/^(\/)$/';
	return  '/^'.preg_replace('/\//', '\/',  preg_replace(self::match, '(.*)', $r)).'$/';
    }

    private function compiler_vars(String $r): Array {
	preg_match_all(self::match, $r, $vars, PREG_SET_ORDER, 0);
	$vars_name = [];
	foreach($vars as $id => $value) {
	    $vars_name[] = preg_replace('/[{}]/', '', $value){0};
	}
	if(debug_trace==TRUE) $this->EventDispatcher->dispatch(
								$this->EventDispatcher->Event::SYSTEM_LOG,
								'compiler_vars',
								\Allice\Module\Cloud::newObject(TRUE)->addArray([
								    'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
								    'value' => [
									count($vars_name),$vars_name
									]
								    ])
								);
	return [
		    count($vars_name),
		    $vars_name
		];
    }
    private function compiler(String $r): Array {
	list ($vars_count, $vars_name) = $this->compiler_vars($r);
	return [
		    $this->compiler_regex($r),
		    $vars_count, 
		    ($vars_count>0)?$vars_name:NULL
		];
    }
    public function builder_regex() {
	foreach($this->routes as $id => &$value) {
	    $value{'compiler'} = $this->compiler($value{'path'});
	}
	if(debug_trace==TRUE) $this->EventDispatcher->dispatch(
								$this->EventDispatcher->Event::SYSTEM_LOG,
								'builder_regex',
								\Allice\Module\Cloud::newObject(TRUE)->addArray([
								    'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
								    'value' => $this->routes
								    ])
								);
    }
    function get_vars(Int $vars_count,Array $vars_name, Array $vars_data): \Allice\Module\Cloud {
	$req = new \Allice\Module\Cloud(TRUE); 
	for($id = --$vars_count, $var_name = $vars_name[$id]; $id>=0; --$id, $var_name = $vars_name[(($id<0)?0:$id)]) {
    	    $req->addItem($var_name,$vars_data[$id]);
	}
	if(debug_trace==TRUE) $this->EventDispatcher->dispatch(
								$this->EventDispatcher->Event::SYSTEM_LOG,
								'get_vars',
								\Allice\Module\Cloud::newObject(TRUE)->addArray([
									'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
									'value' => [$req]
								    ])
								);
	return $req;
    }
    function verify_Item(Array $z,String $route): \Allice\Module\Cloud {
	list ($e, $vars_count, $vars_name) = $z;
        preg_match_all($e, $route, $vars_data, PREG_SET_ORDER, 0);
	if(count($vars_data)==0) { return new \Allice\Module\Cloud(FALSE); }
	array_shift($vars_data{0});
	$req = new \Allice\Module\Cloud(TRUE);
	if($vars_count>0) $req = $this->get_vars($vars_count,$vars_name,$vars_data{0});
	return $req;
    }
    function matchItem(\Allice\Module\Cloud $_route): \Allice\Module\Cloud { 
	if(isset($_route->DNS,$_route->req)) $route = $_route->req;
	else if(isset($_route->DNS)) $route = $_route->DNS;
//	else ERROR
	foreach($this->routes as $id => &$value) {
	    $match = $this->verify_Item($value{'compiler'},$route);
	    if($match->type == TRUE) { 
    		$match->delItem('type');
		$_route->VALUE = $match;
		$_route->CLASS_ID_METHOD = $id;
		$_route->CLASS_LOG[] = [ $this -> _class_routes_name, $id];
		if(debug_trace==TRUE) $this->EventDispatcher->dispatch(
									$this->EventDispatcher->Event::SYSTEM_LOG,
									'matchItem',
									\Allice\Module\Cloud::newObject(TRUE)->addArray([
									    'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
									    'value' =>[
										    $id,
										    $value{'route'},
										    $match,
										    $route
										]
									    ])
									);
		return \Allice\Module\Cloud::newObject(TRUE)->addArray([
						    'id' 	=> $id,
						    'path' 	=> \Allice\Module\Cloud::newObject(TRUE)->addArray($value{'route'}),
//						    'value' 	=> $match,
						    'request' 	=> $_route
						    ]);
	    }
	} 
	if(debug_trace==TRUE) $this->EventDispatcher->dispatch(
								$this->EventDispatcher->Event::SYSTEM_LOG,
								'matchItem',
								\Allice\Module\Cloud::newObject(TRUE)->addArray([
								    'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
								    'value' => [	
									    $this->code_404,
									    \Allice\Module\Cloud::newObject(TRUE)->addArray($this->routes{$this->code_404}{'route'}),
									    NULL,
									    $route
									]
								    ])
								);
	$_route -> VALUE =[];
	return \Allice\Module\Cloud::newObject(TRUE)->addArray([ 
					    'id'	=> $this->code_404,
					    'path'	=> \Allice\Module\Cloud::newObject(TRUE)->addArray($this->routes{$this->code_404}{'route'}),
//					    'value'	=> NULL, 
					    'request'	=> $_route
					    ]);
    }
    function get_pages(Int $code): Array { 
	$id = $code;
	$action = $this->routes{$code}{'route'}; 
	if(debug_trace==TRUE) $this->EventDispatcher->dispatch(
								$this->EventDispatcher->Event::SYSTEM_LOG,
								'run 404...',
								\Allice\Module\Cloud::newObject(TRUE)->addArray([
								    'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
								    'VALUE' => [
									    $id,
									    $action
									]
								    ])
								);
	return $action;
    }
}

?>