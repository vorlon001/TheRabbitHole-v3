<?php

namespace Customer\Dns\DNS_HOST_1\API\V1;

class PROFILE extends \Allice\Route\BASE {
    const API_IMAGE	= 2;
    const API_FILE	= 3;
    const API_404	= 404;
    protected $route 	= [
	self::API_IMAGE => [
    	    'path'	=> '/image/{command}/id_{request_name}-{request_id}',
	    'route'	=> [
    	    			'method'	=> [
				    'class'	=> \Customer\Model\DNS_HOST_1\Rabbit::class,
				    'method'	=>'run'
				],
				'view' 		=> [
				    'class'	=> \Customer\View\DNS_HOST_1\View_Rabbit::class,
				    'method'	=> 'run'
				]
    			    ],
	],
	self::API_FILE => [
	    'path'	=> '/file/{command}/{request}',
	    'route'	=> [
    	    		    'method'	=> [
					    'class'	=> \Customer\Model\DNS_HOST_1\Rabbit_JSON::class, 
					    'method'	=> 'run'
					    ],
			    'view' 	=> [
					    'class'	=> \Customer\View\DNS_HOST_1\View_Rabbit_JSON::class,
					    'method'	=> 'run'
					    ]
	    		    ],
	],
	// id 404 зарезервинован системой!!!
	self::API_404 => [
	    'path'	=> '/404',
	    'route'	=> [
	    			'method'	=> [
				    'class'	=> \Customer\Model\DNS_HOST_1\Route_404::class, 
				    'method'	=> 'run'
				],

				'view' 		=> [
				    'class'	=> \Customer\View\DNS_HOST_1\V404::class,
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