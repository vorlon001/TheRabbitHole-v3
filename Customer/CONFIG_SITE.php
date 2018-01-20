<?php

namespace Customer;

class CONFIG_SITE {
    const EventDispatcher = \Allice\Event\Dispatcher::class;
    const Event = \Allice\Event\ID::class;
    const CORE  = \Allice\CORE::class;
    const TheRabbitHole = \Allice\White_Rabbit\TheRabbitHole::class;
    const ROUTE_DNS = \Customer\Route\ROUTE_DNS::class;
    const Pudding = \Allice\Storage\Pudding::class;
    const Logger = \Allice\Caterpillar\log::class;
    const Frog_Footman = \Allice\Module\Frog_Footman::class;
};

?>