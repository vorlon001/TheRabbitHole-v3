<?php

namespace Customer\Dns\DNS_HOST_2;

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
					    'class'	=> \Customer\Model\DNS_HOST_2\Rabbit::class,
					    'method'	=>'run'
					    ],
			    'view' 	=> [
					    'class'	=> \Customer\View\DNS_HOST_2\View_Rabbit::class,
					    'method'	=> 'run'
					    ]
			    ],
	],
	self::PAGE_ABOUT => [
    	    'path'	=> '/about/{user_name}',
	    'route'	=> [
			    'method'	=> [
					    'class'	=> \Customer\Model\DNS_HOST_2\Rabbit::class,
					    'method'	=>'run'
					    ],
			    'view' 	=> [
					    'class'	=> \Customer\View\DNS_HOST_2\View_Rabbit::class,
					    'method'	=> 'run'
					    ]
			    ],
	],
	self::PAGE_PROFILE => [
    	    'path'	=> '/profile/{user_login}-{vvv}',
            'route'	=> [
			    'method'	=> [
					    'class'	=> \Customer\Model\DNS_HOST_2\Rabbit::class,
					    'method'	=>'run'
					    ],
			    'view' 	=> [
					    'class'	=> \Customer\View\DNS_HOST_2\View_Rabbit::class,
					    'method'	=> 'run'
					    ]
			    ],
	],
	// id 404 зарезервинован системой!!!
	self::PAGE_404 => [
    	    'path'	=> '/404',
	    'route'	=> [
			    'method'	=> [
					    'class'	=> \Customer\Model\DNS_HOST_2\Route_404::class, 
					    'method'	=> 'run'
					    ],
			    'view' 	=> [
					    'class'	=> \Customer\View\DNS_HOST_2\V404::class,
					    'method'	=> 'run'
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
