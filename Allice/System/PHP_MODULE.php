<?php

namespace Allice\System;

class PHP_MODULE {

    public $module = [
//	    'xdebug',
	    'redis',
	    'tarantool',
	    'pdo_mysql',
	    'json',
	    'geoip',
	    'argon2',
	    'BLITZ'
	    ];

    private static $instance = null;
    private function __clone() {}
    private function __sleep(){}
    private function __wakeup(){}
    public function __isset($name) {}
    public function __unset($name) {}
    public function __set($name, $value) {}
    public function __get($name) {}
    public static function getInstance() {
    if (null === self::$instance) {
        try {
	    self::$instance =  new self();
        } catch(Throwable $e) {
	throw new \Exception("PHP_MODULE Fail:".__NAMESPACE__."/".__METHOD__." L:".__LINE__." logfile:".$this->log_filename);
	header('Location: /500.html');
	die();
        }
    }
    return self::$instance;
    }
    public function verify() {
	foreach($this->module as $key => $value)  {
    	    if (!extension_loaded($value)) {
		throw new \Exception($value." PHP EXT. NOT FOUND");
		header('Location: /500.html');
		die();
    	    } 
	}
    }
}

?>