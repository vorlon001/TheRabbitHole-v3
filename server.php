<?php
$time_starti = microtime(true);
require_once ('System/loader.php');

// режим вывода с отладкой пространства model/view
define('debug_mode',TRUE);
// вывод трейсов Ядра
define('debug_trace',TRUE);

//file name log php
define('FILE_EVENT_LOG','Log/event.log');
//file name logs php error_log
define('FILE_ERROR_LOG','Log/php.log');

try {
    require('System/error_handler.php');
    require('Pudding.php');

    $class_log = \Allice\Caterpillar\log::getInstance();
} catch(Throwable $e) {
    error_exit($e,var_export(debug_backtrace(),true)); 
}

class CONFIG_SITE {
    const EventDispatcher = \Allice\Event\Dispatcher::class;
    const Event = \Allice\Event\ID::class;
    const CORE  = \Allice\CORE::class;
    const TheRabbitHole = \Allice\White_Rabbit\TheRabbitHole::class;
    const ROUTE_DNS = \Customer\Route\ROUTE_DNS::class;
};


(\CONFIG_SITE::EventDispatcher)::initInstance(\CONFIG_SITE::class)->dispatch(
					    (\CONFIG_SITE::Event)::DOMAIN_FOUND,
					    'run found route/method...',
					    \Allice\Module\Cloud::newObject(TRUE)->addArray([
										'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
										'value' => [
		    									    'wdx123.xyz.ru',
											    '/api/v1/profile/image/get/id_vorlon-256'
											    ]
										])
					);


//function div (Int $a,Int $b): Int {
//    if($b==0) throw new Cheshire_Cat_Say('Dev zero. P:'.__METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' ARG:'.json_encode(func_get_args()));
//    return $a / $b;
//}

/*

try {
    $d = div(1,0);
} catch(Throwable $e) {
    EventDispatcher::getInstance()->dispatch(
						Event::ERROR,
						'ERROR EXCEPTION ...',
						\Allice\Module\Cloud::newObject(TRUE)->addArray([
						    				    'id' => __METHOD__.' L:'.__LINE__.' MU:'.memory_get_usage().' MP:'.memory_get_peak_usage(),
						    				    'value' => [
    												    $e,
						    						]
										])
						);
}
*/
//$d = 0;
//if ($d == 0) {
//    trigger_error("Не могу поделить на ноль", E_USER_ERROR);
//}

//run_found_domain('x123.xyz.ru','/api/v1/profile/image/get/id_vorlon-256')
//run_found_route($route,'/api/v1/profile/image/get/id_vorlon-256');
//var_dump(($a=$r->path->method{'class'}),($b=$r->path->method{'method'}),$a::$b($r->request));
//var_dump($RT->matchItem('sdfdfgsd-23452345.xyz.ru'));
//var_dump($RT->matchItem('www.xyz.ru'));
//var_dump($RT->matchItem('xyz.ru'));
    $time_endi = microtime(true);
    $timei = ($time_endi - $time_starti)*1000;
    echo "!!!!!!";
    echo " Ничего не делал $timei ms\n";


?>
