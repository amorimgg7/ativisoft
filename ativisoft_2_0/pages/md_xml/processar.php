<?php

session_start();

$usuario = "guest";

if(isset($_SESSION['google_id'])){
    $usuario = $_SESSION['google_id'];
}

$dir = "temp/".$usuario."/";

if(!is_dir($dir)){
    mkdir($dir,0777,true);
}


/* libera a sessão para não travar outras requisições */
session_write_close();

$resultados = [];

if(isset($_FILES['xml'])){

for($i=0; $i<count($_FILES['xml']['tmp_name']); $i++){

$tmp = $_FILES['xml']['tmp_name'][$i];

if(!file_exists($tmp)) continue;

/* LER XML PRIMEIRO */

$xml = simplexml_load_file($tmp);

$ns = $xml->getNamespaces(true);
$xml->registerXPathNamespace('nfe', $ns['']);

$inf = $xml->xpath('//nfe:infNFe')[0];

$emit = $inf->emit;
$ide = $inf->ide;
$total = $inf->total->ICMSTot;

/* PEGAR CHAVE DE ACESSO */

$chave = str_replace("NFe","",(string)$inf['Id']);

/* NOME DO ARQUIVO */

$nomeArquivo = $chave.".xml";

$destino = $dir.$nomeArquivo;

/* SALVAR XML */

move_uploaded_file($tmp,$destino);

/* RESULTADO */

$resultados[] = [

"empresa" => (string)$emit->xNome,
"cnpj" => (string)$emit->CNPJ,
"numero" => (string)$ide->nNF,

"valor_nota" => (float)$total->vNF,
"icms_total" => (float)$total->vICMS,
"pis_total" => (float)$total->vPIS,
"cofins_total" => (float)$total->vCOFINS,
"ipi_total" => (float)$total->vIPI,
"fecp_total" => (float)($total->vFCP ?? 0),

"arquivo" => $usuario."/".$nomeArquivo,
"chave" => $chave

];

}

}

echo json_encode($resultados);
