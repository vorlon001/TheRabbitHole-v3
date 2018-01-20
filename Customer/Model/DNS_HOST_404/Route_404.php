<?php

namespace Customer\Model\DNS_HOST_404;

class Route_404 extends \Allice\Model\BASE {
    public function __construct(String $_CONFIG)
    {
        parent::__construct($_CONFIG);
    }
    // конструктор добавления event eventdist
    function run ($req) { 
	return [
		'dns'	=> $req->DNS,
		'url'	=> $req->req
		]; 
    }
}

?>
