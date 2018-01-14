<?php

namespace Allice\View;

class BASE {

    public $EventDispatcher 	= NULL;
    public $Event		= NULL;
    public function __construct(String $_CONFIG) {
        $this->EventDispatcher 	= $_CONFIG::EventDispatcher;
	$this->Event		= $_CONFIG::Event;
    }
}
?>
