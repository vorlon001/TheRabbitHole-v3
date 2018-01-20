<?php

$time_starti = microtime(true);
try {
    require_once ('System/loader.php');
    require_once ('System/global.php');
} catch(Throwable $e) {
    header('Location: /Public/500.html');
    exit();
}
// вынести в систем
try {
    require('System/error_handler.php');
    \Allice\INIT::LOAD( \Allice\System\PHP_MODULE::class, \Allice\Caterpillar\log::class );
} catch(Throwable $e) {
    error_exit($e,var_export(debug_backtrace(),true));
}


\Allice\INIT::GO(\Customer\CONFIG_SITE::class);
?>
