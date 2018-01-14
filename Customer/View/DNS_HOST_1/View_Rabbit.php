<?php

namespace Customer\View\DNS_HOST_1;

class View_Rabbit extends \Allice\View\BASE {
    public function __construct(String $_CONFIG)
    {
        parent::__construct($_CONFIG);
    }
    // конструктор добавления event eventdist
    function run ($req) { 
	try {
	    var_dump("START RUN MODEL ########################################",json_encode($req)); 
	    echo 'RENDER PAGE'.PHP_EOL; 
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
	    var_dump("END RUN MODEL ########################################");
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
