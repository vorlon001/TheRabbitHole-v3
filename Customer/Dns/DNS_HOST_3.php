<?php

namespace Customer\Dns;

class DNS_HOST_3 {
    static function run ($req) { var_dump($req); echo 'DNS HOST 3'.PHP_EOL; return ['id'=>2345234,'txt'=>['a1'=>1234123,'a2'=>'DNS HOST 3']]; }
}
?>
