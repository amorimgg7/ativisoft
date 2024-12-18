<?php

/**
 * Detailed endpoint documentation
 * https://dev.efipay.com.br/docs/api-pix/cobrancas-imediatas#criar-cobrança-imediata-com-txid
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

$params = [
	"txid" => "0000000000000000000000000000000006" // Transaction unique identifier
];

$body = [
	"calendario" => [
		"expiracao" => 3600 // Charge lifetime, specified in seconds from creation date
	],
	"devedor" => [
		
		"cpf" => "05185255544",
		//"cnpj" => "08057969000100",
		"nome" => "Gabriel Amorim"
	],
	"valor" => [
		"original" => "90.00"
	],
	"chave" => "ae95d0a9-5571-4ffd-b8cb-539def1e495c", // Pix key registered in the authenticated Efí account
	"solicitacaoPagador" => "Realize o pagamento da licença para liberar o acesso ao sistema.",
	"infoAdicionais" => [
		[
			"nome" => "Licença R$",
			"valor" => "80.00"
		],
		[
			"nome" => "Multa acumulada em 10 dias R$",
			"valor" => "10.00"
		],
		[
			"nome" => "Valor total R$",
			"valor" => "90"
		]
	]
];

try {
	$api = new EfiPay($options);
	$pix = $api->pixCreateCharge($params, $body);

	if ($pix["txid"]) {
		$params = [
			"id" => $pix["loc"]["id"]
		];

		try {
			$qrcode = $api->pixGenerateQRCode($params);

			echo "<b>Detalhes da cobrança:</b>";
			echo "<pre>" . json_encode($pix, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>";

			echo "<b>QR Code:</b>";
			echo "<pre>" . json_encode($qrcode, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>";

			echo "<b>Imagem:</b><br>";
			echo "<img src='" . $qrcode["imagemQrcode"] . "' />";
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
