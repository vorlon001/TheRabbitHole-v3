<?php
namespace Customer\Route;

class ROUTE_DNS extends \Allice\Route\BASE {
    const DNS_ONE	= 1;
    const DNS_TWO	= 2;
    const DNS_THREE	= 3;
    protected $route = [
	self::DNS_ONE => [
    	    'path' => 'x{val}.xyz.ru',
            'route' => [
			    'class'	=> \Customer\Dns\DNS_HOST_1\CORE::class, 
			],
	],
        self::DNS_TWO => [
	    'path' => 'd{user_name}.xyz.ru',
    	    'route' => [
			    'class'	=> \Customer\Dns\DNS_HOST_2::class,
			],
	],
        self::DNS_THREE => [
	    'path' => '{user_login}-{vvv}.xyz.ru',
    	    'route' => [
			    'class'	=> \Customer\Dns\DNS_HOST_3::class,
			],
	],
        // id 404 зарезервинован системой!!!
	self::DNS_404 => [
    	    'path'	=> '404.xyz.ru',
            'route' => [
			    'class'	=> \Customer\Dns\DNS_HOST_404::class,
			],
	],
    ];

    public function __construct(String $_event_bus) 
    {
	parent::__construct($_event_bus);
	$this->paths = $this->route;
    }
};

?>
