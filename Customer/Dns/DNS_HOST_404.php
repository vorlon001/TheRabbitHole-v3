<?php

namespace Customer\Dns;

class DNS_HOST_404 extends \Allice\Route\BASE {
    const PAGE_INDEX	= 1;
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
	// id 404 зарезервинован системой!!!
	self::PAGE_404 => [
	    'path'	=> '/404',
    	    'route'	=> [
	    		    'method'	=> [
		    			    'class'	=> \Customer\Model\DNS_HOST_1\Route_404::class, 
		    			    'method'	=> 'run'
		    			    ],
	    		    'view' 	=> [
		    			'class'		=> \Customer\View\DNS_HOST_1\View_Rabbit::class,
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
