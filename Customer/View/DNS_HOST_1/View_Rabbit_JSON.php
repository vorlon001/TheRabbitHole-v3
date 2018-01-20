<?php

namespace Customer\View\DNS_HOST_1;

class View_Rabbit_JSON extends \Allice\View\BASE {
    public function __construct(String $_CONFIG)
    {
        parent::__construct($_CONFIG);
    }
    // конструктор добавления event eventdist
    function run ($req) { 
	try {  

	    $s = 'CONTENT TEST:'.var_export("<br>START RUN VIEW... <br>args:".json_encode($req),true); 
    	    $s .= '<br>RENDER PAGE'.PHP_EOL; 
	    $s .= '<br>END RUN MODEL...';

    	    $s = array(	
			'DATA' => array( 
					'DNS' => $req['dns'] , 
					'URL' => $req['url'] 
					),
					'CONTENT' => array( 
							    'HTML' => $req
							    )
			);

	     if(debug_mode==TRUE) $this->EventDispatcher::getInstance()->dispatch(
										    $this->Event::LOG,
										    'CUSTOM_LOG exec  VIEW RENDER...',
										    \Allice\Module\Cloud::newObject(TRUE)->addArray([
						    					'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
						    					'value' => [
    												    $req,
												    $s
						    						    ]
										    ])
										);
	    $f = new $this->Frog_Footman();	
	    $f->_header('Content-type:application/json;charset=utf-8');
	    $f->_cookie("UUID"	, "32423423423423", time() + 10,"","");
	    $f->_data(json_encode($s));
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
