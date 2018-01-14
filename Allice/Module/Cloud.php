<?php

namespace Allice\Module;

class Cloud extends \stdClass{
    function __construct(Int $type) {
	$this->type = $type;
	return $this;
    }
    public function __set(String $name, $value) 
    {
	$this->$name = $value;
    }
    public function __get(String $name) 
    {
	return (isset($this->$name))?$this->$name:NULL;
    }
    public function __unset(String $name) {
	if(isset($this->$name)) unset($this->$name);
    }
    static function newObject($type) {
	return new Cloud($type);
    } 
    function addItem(String $name,$data) {
	$this->$name = $data;
	return $this;
    }
    function addArray(Array $args) {
	foreach($args as $id => $value) {
	    $this->$id = $value;
	}
	return $this;
    }
    function addObject(Cloud $args) {
	foreach($args as $id => $value) {
    	    $this->$id = $value;
	}
	return $this;
    }
    function getItem(String $name) {
	return (isset($this->$name))?$this->$name:NULL;
    }
    function delItem(String $name) {
	if(isset($this->$name)) unset($this->$name);
	return $this;
    }
};

?>
