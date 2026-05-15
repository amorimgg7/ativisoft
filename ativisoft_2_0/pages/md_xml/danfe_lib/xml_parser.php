<?php

function lerNFe($xmlFile){

$xml = simplexml_load_file($xmlFile);

$ns = $xml->getNamespaces(true);
$xml->registerXPathNamespace('nfe',$ns['']);

$inf = $xml->xpath('//nfe:infNFe')[0];

$emit = $inf->emit;
$dest = $inf->dest;
$ide  = $inf->ide;
$total = $inf->total->ICMSTot;

$dados = [];

$dados["emitente"] = [
"nome" => (string)$emit->xNome,
"cnpj" => (string)$emit->CNPJ,
"endereco" =>
$emit->enderEmit->xLgr." ".
$emit->enderEmit->nro." - ".
$emit->enderEmit->xBairro." - ".
$emit->enderEmit->xMun."/".$emit->enderEmit->UF
];

if(isset($inf->dest->xNome)){

$nome = (string)$inf->dest->xNome;

}else{

$nome = "CONSUMIDOR NÃO IDENTIFICADO";

}

if(isset($inf->dest->CNPJ)){

$doc = (string)$inf->dest->CNPJ;

}elseif(isset($inf->dest->CPF)){

$doc = (string)$inf->dest->CPF;

}else{

$doc = "NÃO INFORMADO";

}

$dados["dest"] = [
"nome"=>$nome,
"doc"=>$doc
];

$dados["nota"] = [
"numero" => (string)$ide->nNF,
"serie" => (string)$ide->serie,
"data" => substr((string)$ide->dhEmi,0,10),
"chave" => str_replace("NFe","",(string)$inf['Id'])
];

$dados["totais"] = [
"produtos" => (string)$total->vProd,
"icms" => (string)$total->vICMS,
"pis" => (string)$total->vPIS,
"cofins" => (string)$total->vCOFINS,
"nf" => (string)$total->vNF
];

$dados["produtos"] = [];

foreach($inf->det as $det){

$p=$det->prod;

$dados["produtos"][] = [

"codigo" => (string)$p->cProd,
"descricao" => (string)$p->xProd,
"ncm" => (string)$p->NCM,
"cfop" => (string)$p->CFOP,
"qtd" => (string)$p->qCom,
"valor" => (string)$p->vUnCom,
"total" => (string)$p->vProd

];

}

return $dados;

}