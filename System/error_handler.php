<?php
define('SITE_ROOT_PATH','');
error_reporting(E_ALL);
ini_set('display_errors','On');

ini_set('error_log',SITE_ROOT_PATH.FILE_ERROR_LOG);
$STDERR = fopen(SITE_ROOT_PATH.FILE_ERROR_LOG, 'ab');
if( !is_resource($STDERR) ) {
//    header('Location: /500.html');
    die();
}
// функция обработки ошибок
function CoreErrorHandler($errno, 	$errstr, 	$errfile,    $errline, $error_context)
{
    error_log("Code:$errno,Name:$errstr,File:$errfile,Line:$errline,Context:". var_export($error_context,true));
    if (!(error_reporting() & $errno)) {
        // Этот код ошибки не включен в error_reporting
        error_log("ERROR - Неизвестная ошибка.....");
        return;
    }

    switch ($errno) {
	case E_ERROR:
	case E_CORE_ERROR:
	case E_COMPILE_ERROR:
        case E_PARSE:
            error_log("Фатальная ошибка в строке $errline файла $errfile");
    	    error_log("PHP " . PHP_VERSION . " (" . PHP_OS . ")");
	    error_log("Завершение работы...");
	    exit(1);
    	    break;
	case E_USER_ERROR:
            error_log("Фатальная ошибка в строке $errline файла $errfile");
	    error_log("PHP " . PHP_VERSION . " (" . PHP_OS . ")");
	    error_log("Завершение работы...");
    	    exit(1);
	    break;
        case E_USER_ERROR:
	case E_RECOVERABLE_ERROR:
    	    error_log("ERROR USER: [$errno] $errstr");
	    exit(1);
	    break;
        case E_WARNING:
	case E_CORE_WARNING:
        case E_COMPILE_WARNING:
	case E_USER_WARNING:
	    error_log("!!!!!WARNING: [$errno] $errstr");
    	    exit(1);
            break;
        case E_NOTICE:
        case E_USER_NOTICE:
    	    error_log("ERROR NOTICE: [$errno] $errstr");
	    exit(1);
            break;
	case E_STRICT:
    	    error_log("DEBUG: [$errno] $errstr");
	    exit(1);
            break;
	default:
    	     error_log("ERROR - Неизвестная ошибка: [$errno] $errstr");
    }

    return true;
}
// переключаемся на пользовательский обработчик
$old_error_handler = set_error_handler("CoreErrorHandler", E_ALL );

function fatal_error_handler() {
    if (@is_array($e = @error_get_last())) {
	$code = isset($e['type']) ? $e['type'] : 0;
	$msg = isset($e['message']) ? $e['message'] : '';
        $file = isset($e['file']) ? $e['file'] : '';
	$line = isset($e['line']) ? $e['line'] : '';
	if ($code>0) CoreErrorHandler($code,$msg,$file,$line,'ФАТАЛЬНАЯ ОШИБКА');
    }
}
register_shutdown_function('fatal_error_handler');

function error_exit ($e,$dmp) {
    error_log('STACK:'.var_export($dmp,true));
    error_log('$_SERVER'.var_export($_SERVER,true));    
    error_log('$_GET:'.var_export($_GET,true));
    error_log('$_POST:'.var_export($_POST,true));
    error_log("Message : " . $e->getMessage());
    error_log("Code : " . $e->getCode());
    error_log("File : " . $e->getFile());
    error_log("Line : " . $e->getLine());
    error_log("Dump : " . $e->getTraceAsString());
    header('Location: /500.html');
    exit;
}

?>