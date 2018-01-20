<?php

namespace Allice\Module;

class Frog_Footman {
    private $_header	= NULL;
    private $_add_cookie= NULL;
    private $_rem_cookie = NULL;
    private $_data	= NULL;
    function _header(String $_header) {
	$this->_header[] = $_header;
    }
    function _cookie(...$arg) {
	$this->_add_cookie[] = $arg;
    }
    function _rem_cookie($a) {
	$this->_rem_cookie[] = $a;
    }
    function _data(String $_data) {
	$this->_data = $_data;
    }
    private function _set_cookie($a,$b,$c,$d,$e) {
        setcookie($a,$b,$c,$d,$e);
    }
    private function _del_cookie($a) {
        unset($_COOKIE[$a]);
    }
    private function _set_header($a) {
	header($a);
    }
    function send() {
	if(is_array($this->_header)) {
	    if(count($this->_header)>0) {
		foreach($this->_header as $i => $value) {	
		    $this->_header($value);    
		}
	    }
	}
	if(is_array($this->_rem_cookie)) {
	    if(count($this->_rem_cookie)) {
		foreach($this->_rem_cookie as $i => $value) {
		    $this->_del_cookie($value);
		}
	    }
	}
	if(is_array($this->_add_cookie)) {
	    if(count($this->_add_cookie)) {
		foreach ($this->_add_cookie as $i => $value) {
		    $this->_set_cookie(...$value);
		}
	    }
	}
	print($this->_data);
    }
}

?>