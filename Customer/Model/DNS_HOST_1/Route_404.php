<?php

namespace Customer\Model\DNS_HOST_1;

class Route_404 extends \Allice\Model\BASE {
    public function __construct(String $_CONFIG)
    {
        parent::__construct($_CONFIG);
    }
    // конструктор добавления event eventdist
    function run ($req) { var_dump($req); echo '404 not found '.PHP_EOL; return []; }
}

?>
