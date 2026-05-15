<?php

use Picqer\Barcode\BarcodeGeneratorPNG;

function gerarBarcode($chave){

$generator = new BarcodeGeneratorPNG();

return base64_encode(
$generator->getBarcode($chave,$generator::TYPE_CODE_128)
);

}