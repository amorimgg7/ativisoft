<?php

function auditar($inf){

$alertas = [];

$total = $inf->total->ICMSTot;

$icms = (float)$total->vICMS;
$pis = (float)$total->vPIS;
$cofins = (float)$total->vCOFINS;
$ipi = (float)$total->vIPI;

if($icms == 0){

$alertas[] = "ICMS zerado";

}

if($pis == 0){

$alertas[] = "Possível crédito PIS";

}

if($cofins == 0){

$alertas[] = "Possível crédito COFINS";

}

if($ipi > 0){

$alertas[] = "Verificar crédito IPI";

}

foreach($inf->det as $det){

$prod = $det->prod;

$cfop = (string)$prod->CFOP;

if(substr($cfop,0,1) == "6"){

$alertas[] = "Operação interestadual CFOP ".$cfop;

}

}

return $alertas;

}