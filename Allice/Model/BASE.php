<?php

namespace Allice\Model;

class BASE {

    public $EventDispatcher 	= NULL;
    public $Event		= NULL;
    public $Frog_Footman	= NULL;
    public $Pudding		= NULL;
    public function __construct(String $_CONFIG) {
	$this->EventDispatcher 	= $_CONFIG::EventDispatcher;
	$this->Event		= $_CONFIG::Event;
	$this->Frog_Footman	= $_CONFIG::Frog_Footman;
	$this->Pudding		= ($_CONFIG::Pudding)::getInstance($_CONFIG);
    }
}

?>
