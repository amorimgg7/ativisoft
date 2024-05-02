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
		"original" => "".$_POST['valor'].""
	],
	"chave" => "ae95d0a9-5571-4ffd-b8cb-539def1e495c", // Pix key registered in the authenticated Efí account
	"solicitacaoPagador" => "Enter the order number or identifier.",
	"infoAdicionais" => [
		[
			"nome" => "Licença R$",
			"valor" => "".$_POST['licenca'].""
		],
		[
			"nome" => "Multa acumulada em 10 dias R$",
			"valor" => "".$_POST['multa'].""
		],
		[
			"nome" => "Valor total R$",
			"valor" => "".$_POST['valor'].""
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
			$qrcode = $api->pixGenerateQRCode($params);

			//echo "<b>Detalhes da cobrança:</b>";
			//echo "<pre>" . json_encode($pix, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>";

			//echo "<b>QR Code:</b>";
			//echo "<pre>" . json_encode($qrcode, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>";


			
			echo "<td><img style='width:200px; height:200px; border-radius: 0; ' src='" . $qrcode["imagemQrcode"] . "' /></td>";
			//echo "<td style='border-radius: 0;'><a style='border-radius: 0;' href='" . $qrcode["imagemQrcode"] . "' target='_blank'><img style='width:200px; height:200px border-radius: 0; 'src='" . $qrcode["imagemQrcode"] . "' /></a></td>";

			echo "<td><button style='width: 200px; height: 200px;' class='btn btn-outline-success' onclick='copiarTexto1()'>Copiar QR code</button>";
			$qrcode_value = trim($qrcode['qrcode'], '"');
    		echo "<textarea style='display: none;' id='link1' rows='5' cols='50'>".$qrcode_value."</textarea><br><td>";

			//echo "<button onclick='copiarTexto1()'>Copiar</button>";

			echo "<script>";
			echo "function copiarTexto1() {";
			echo "var textarea = document.getElementById('link1');";
			echo "textarea.select();";
			echo "document.execCommand('copy');";
			//echo "alert('Conteúdo copiado para a área de transferência!');";
			echo "}";
			echo "</script>";

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
