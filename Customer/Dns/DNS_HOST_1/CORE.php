<?php

namespace Customer\Dns\DNS_HOST_1;

class CORE extends \Allice\Route\BASE {
    const PAGE_INDEX	= 1;
    const PAGE_PROFILE	= 2;
    const PAGE_ABOUT	= 3;
    const PAGE_API_V1	= 4;
    const PAGE_404	= 404;
    protected $route = [
	self::PAGE_INDEX => [
    	    'path'	=> '/',
	    'route'	=> [
			    'method'	=> [
					    'class'	=> \Customer\Model\DNS_HOST_1\Rabbit::class,
					    'method'	=>'run'
					    ],
			    'view' 	=> [
					    'class'	=> \Customer\View\DNS_HOST_1\View_Rabbit::class,
					    'method'	=> 'run',
					    'JSON'	=> FALSE,
					    'TPL'	=> '{{ include("../tpl/admin/class.post.1.tpl") }}'
					    ]
			    ],
	],
	self::PAGE_ABOUT => [
    	    'path'	=> '/about/{user_name}',
	    'route'	=> [
			    'method'	=> [
					    'class'	=> \Customer\Model\DNS_HOST_1\Rabbit::class,
					    'method'	=>'run'
					    ],
			    'view' 	=> [
					    'class'	=> \Customer\View\DNS_HOST_1\View_Rabbit::class,
					    'method'	=> 'run',
					    'JSON'	=> FALSE,
					    'TPL'	=> '{{ include("../tpl/admin/class.post.1.tpl") }}'
					    ]
			    ],
	],
	self::PAGE_PROFILE => [
    	    'path'	=> '/profile/{user_login}-{vvv}',
            'route'	=> [
			    'method'	=> [
					    'class'	=> \Customer\Model\DNS_HOST_1\Rabbit::class,
					    'method'	=>'run'
					    ],
			    'view' 	=> [
					    'class'	=> \Customer\View\DNS_HOST_1\View_Rabbit::class,
					    'method'	=> 'run',
					    'JSON'	=> FALSE,
					    'TPL'	=> '{{ include("../tpl/admin/class.post.1.tpl") }}'
					    ]
			    ],
	],
	self::PAGE_API_V1 => [
	    'path'	=> '/api/v1{command}', //для АПИ только тип переменной command
    	    'route'	=> [
	    		    'class'	=> \Customer\Dns\DNS_HOST_1\API\V1\CORE::class,
	    		    ],
	],
	// id 404 зарезервинован системой!!!
	self::PAGE_404 => [
    	    'path'	=> '/404',
	    'route'	=> [
			    'method'	=> [
					    'class'	=> \Customer\Model\DNS_HOST_1\Route_404::class, 
					    'method'	=> 'run'
					    ],
			    'view' 	=> [
					    'class'	=> \Customer\View\DNS_HOST_1\View_Rabbit::class,
					    'method'	=> 'run',
					    'JSON'	=> FALSE,
					    'TPL'	=> '{{ include("../tpl/admin/class.post.2.tpl") }}'
					    ]
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
