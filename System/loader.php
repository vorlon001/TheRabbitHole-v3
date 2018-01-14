<?php

spl_autoload_register(function ($class) {
//    echo '<<<<<<<<<<<'.$class.PHP_EOL;
    $class = '' . str_replace('\\', '/', $class) . '.php';
//    echo '>>>>>>>>>>>'.$class.PHP_EOL;
    require_once($class);
});

?>