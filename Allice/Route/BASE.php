<?php

namespace Allice\Route;

class BASE {
    const DNS_404	= 404;
    protected $EventDispatcher = NULL;
    protected $Event = NULL;
    protected $paths = [];
    public function get_404() {
	 if(debug_trace==TRUE) $this->EventDispatcher->dispatch(
								    $this->EventDispatcher->Event::SYSTEM_LOG,
								    'get dns_404 code...',
								    \Allice\Module\Cloud::newObject(TRUE)->addArray([
									'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
									'value' => [
											self::DNS_404
										    ]
									])
								);
	return self::DNS_404;
    }
    public function get_Routes() {
        if(debug_trace==TRUE) $this->EventDispatcher->dispatch(
								$this->EventDispatcher->Event::SYSTEM_LOG,
								'get routes...',
								\Allice\Module\Cloud::newObject(TRUE)->addArray([
								    'id' =>__METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
								    'value' => []
								    ])
								);
	return $this->paths;
    }
    private function __clone() {}
    public function __construct(String $_event_bus) {
        $this->EventDispatcher = $_event_bus::getInstance();
        if(debug_trace==TRUE) $this->EventDispatcher->dispatch(
								$this->EventDispatcher->Event::SYSTEM_LOG,
								'run constructor routes...',
								\Allice\Module\Cloud::newObject(TRUE)->addArray([
												    'id' =>__METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
												    'value' => []
												])
								);
    }
    private function __sleep(){}
    private function __wakeup(){}
}
?>
