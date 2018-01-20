<?php

namespace Customer\View\DNS_HOST_404;

class View_Rabbit extends \Allice\View\BASE {
    public function __construct(String $_CONFIG)
    {
        parent::__construct($_CONFIG);
    }
    // конструктор добавления event eventdist
    function run ($req) { 
	try {  

	    $View = new \Blitz();
	    $View->load('{{ include("Customer/TPL/DNS_HOST_404/View_Rabbit/run.tpl") }}');
	    $s = $View->parse(array('DNS_404' => array( 'DNS' => $req['dns'] , 'URL' => $req['url'] )));

	    if(debug_mode==TRUE) $this->EventDispatcher::getInstance()->dispatch(
										    $this->Event::LOG,
										    'CUSTOM_LOG exec  VIEW RENDER...',
										    \Allice\Module\Cloud::newObject(TRUE)->addArray([
						    					'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
						    					'value' => [
    												    $req,
						    						    ]
										    ])
										);
	    $f = new $this->Frog_Footman();	
	    $f->_data($s);
	    return $f;
	} catch(Throwable $e) {
    	    $this->EventDispatcher::getInstance()->dispatch(
		$this->Event::LOG,
		'VIEW ERROR...',
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
