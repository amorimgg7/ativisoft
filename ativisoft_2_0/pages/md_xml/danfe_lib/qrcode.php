<?php

require_once __DIR__ . '/qrcode/qrlib.php';

function gerarQRCodeBase64($texto)
{

ob_start();

QRcode::png($texto, null, QR_ECLEVEL_L, 4);

$imageString = ob_get_contents();

ob_end_clean();

return base64_encode($imageString);

}