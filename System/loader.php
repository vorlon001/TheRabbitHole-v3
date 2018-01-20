<?php

spl_autoload_register(function ($class) {
    $file_class = '' . str_replace('\\', '/', $class) . '.php';
    if(is_file($file_class)) {
	require_once($file_class);
	if (!class_exists($class)) {
	    header('Location: /Public/500.html');
	    exit();
	}
    } else {
	header('Location: /Public/500.html');
	exit();
    }
});

?>