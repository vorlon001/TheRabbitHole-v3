<?php

namespace Customer\Dns\DNS_HOST_1\API\V1;

class CORE extends \Allice\Route\BASE {
    const API_IMAGE	= 2;
    const API_FILE	= 3;
    const API_PROFILE	= 4;
    const API_404	= 404;
    protected $route 	= [
	self::API_IMAGE => [
	    'path'	=> '/image/{command}/{request}',
    	    'route'	=> [
	    		    'method'	=> [
		    			    'class'	=> \Customer\Model\DNS_HOST_1\Rabbit::class,
		    			    'method'	=>'run'
		    			    ],
			    'view' 	=> [
					    'class'	=> \Customer\View\DNS_HOST_1\View_Rabbit::class,
					    'method'	=> 'run',
					    'JSON'	=> FALSE,
					    'TPL'	=> '{{ include("../tpl/admin/class.post.2.tpl") }}'
					    ]
			    ],
	],
	self::API_FILE => [
	    'path'	=> '/file/{command}/{request}',
	    'route'	=> [
	    		    'method'	=> [
		    			    'class'	=> \Customer\Model\DNS_HOST_1\Rabbit::class, 
		    			    'method'	=> 'run'
		    			    ],
			    'view' 	=> [
					    'class'	=> \Customer\View\DNS_HOST_1\View_Rabbit::class,
					    'method'	=> 'run',
					    'JSON'	=> FALSE,
					    'TPL'	=> '{{ include("../tpl/admin/class.post.3.tpl") }}'
					    ]
			    ],
	],
	self::API_PROFILE => [
    	    'path'	=> '/profile{command}',
	    'route'	=> [
	    		    'class'	=> \Customer\Dns\DNS_HOST_1\API\V1\PROFILE::class,
		    	    ]
			],
	// id 404 зарезервинован!!!
	self::API_404 => [
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
