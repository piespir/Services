<?php

function __autoload($class)
{
    require_once $class.'.php';
}
echo '<pre>';
$start = microtime(true);
$t = new Teste();
//$t->setId(12);
$t->setvar1('123');
;
//print_r( $t->getId());

print_r( $t->getvar1());
$fim = microtime(true);
$tempo = $fim - $start;
echo "<br/>finalizado em {$tempo}";
