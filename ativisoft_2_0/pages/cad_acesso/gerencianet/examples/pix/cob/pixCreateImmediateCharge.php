<?php

/**
 * Detailed endpoint documentation
 * https://dev.efipay.com.br/docs/api-pix/cobrancas-imediatas#criar-cobrança-imediata-sem-txid
 */

$autoload = realpath(__DIR__ . "/../../../vendor/autoload.php");
if (!file_exists($autoload)) {
	die("Autoload file not found or on path <code>$autoload</code>.");
}
require_once $autoload;

use Efi\Exception\EfiException;
use Efi\EfiPay;

$optionsFile = __DIR__ . "/../../credentials/options.php";
if (!file_exists($optionsFile)) {
	die("Options file not found or on path <code>$options</code>.");
}
$options = include $optionsFile;

$body = [
	"calendario" => [
		"expiracao" => 3600 // Charge lifetime, specified in seconds from creation date
	],
	"devedor" => [
		"cnpj" => "".$_POST['cnpj']."",
		"nome" => "".$_POST['nome'].""
	],
	"valor" => [
		//"original" => "0.01"
		"original" => "".$_POST['valor'].""
	],
	"chave" => "ae95d0a9-5571-4ffd-b8cb-539def1e495c", // Pix key registered in the authenticated Efí account
	"solicitacaoPagador" => "Descreva seu pagamento.",
	"infoAdicionais" => [
		[
			"nome" => "Contrato",
			"valor" => "ID: ".$_POST['contrato'].""
		],[
			"nome" => "Vigência",
			"valor" => ": ".$_POST['dt_validade'].""
		],[
			"nome" => "Licença",
			"valor" => "R$: ".$_POST['licenca'].""
		],
		[
			"nome" => "Multa acumulada",
			"valor" => "R$: ".$_POST['multa'].""
		],
		[
			"nome" => "Valor total",
			"valor" => "R$: ".$_POST['valor'].""
		]
	]
];

try {
	$api = new EfiPay($options);
	$pix = $api->pixCreateImmediateCharge($params = [], $body); // Using this function the txid will be generated automatically by Efí API

	if ($pix["txid"]) {
		$params = [
			"id" => $pix["loc"]["id"]
		];

		try {
			//$qrcode = $api->pixGenerateQRCode($params);
			//echo "<tr><td><img style='width:200px; height:200px; border-radius: 0; ' src='" . $qrcode["imagemQrcode"] . "' /></td></tr>";
			//echo "<tr><td><button style='width: 200px; height: 200px;' class='btn btn-outline-success' onclick='copiarTexto1()'>Copiar QR code</button></td></tr>";
			//$qrcode_value = trim($qrcode['qrcode'], '"');
    		//echo "<tr><td><textarea id='link1' rows='5' cols='50' readonly>".$qrcode_value."</textarea></td></tr>";//$pix["txid"]
    		//echo "<tr><td><textarea rows='5' cols='50' readonly>".$pix["txid"]."</textarea></td></tr>";
			$_SESSION['txid'] = $pix["txid"];
			include 'pixDetailCharge.php';
		} catch (EfiException $e) {
			print_r($e->code . "<br>");
			print_r($e->error . "<br>");
			print_r($e->errorDescription . "<br>");
		} catch (Exception $e) {
			print_r($e->getMessage());
		}
	} else {
		echo "<pre>" . json_encode($pix, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>";
	}
} catch (EfiException $e) {
	print_r($e->code . "<br>");
	print_r($e->error . "<br>");
	print_r($e->errorDescription . "<br>");
} catch (Exception $e) {
	print_r($e->getMessage());
}
