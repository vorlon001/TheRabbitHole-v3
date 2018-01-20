<?php

namespace Customer\Model\DNS_HOST_2;

class Rabbit extends \Allice\Model\BASE {

    public function __construct(String $_CONFIG)
    {
        parent::__construct($_CONFIG);
    }

    function run ($req) { 
	try { 
	    $s = var_export("<br>START RUN MODEL...<br> args: url:".json_encode($req->VALUE)." dns_arg:".json_encode($req->VALUE_DNS),true); 
	    if(debug_mode==TRUE) $this->EventDispatcher::getInstance()->dispatch(
									$this->Event::LOG,
									'CUSTOM_LOG exec MODEL...',
									\Allice\Module\Cloud::newObject(TRUE)->addArray([
													    'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
													    'value' => [
	    														$req,
													    ]
													])
									);
							
	    $s .= "<br>END RUN MODEL...<br>";
	    return [
		    'dns'	=> $req->DNS,
		    'url'	=> $req->req,
	    	    'id'	=> 2345234,
		    'html'	=> $s,
		    'txt'	=> [
				    'a1'	=> 1234123,
				    'a2'	=> 'dsgfsdfg'
				    ]
		    ]; 
    
	} catch(Throwable $e) {
	    $this->EventDispatcher::getInstance()->dispatch(
		$this->Event::LOG,
		'MODEL ERROR...',
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
