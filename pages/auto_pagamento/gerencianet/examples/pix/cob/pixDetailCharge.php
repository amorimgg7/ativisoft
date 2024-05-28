<?php

/**
 * Detailed endpoint documentation
 * https://dev.efipay.com.br/docs/api-pix/cobrancas-imediatas#consultar-cobrança
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
	//"txid" => "757843dd97e5428aa76d2b6b0ce19813"
	"txid" => "".$_SESSION['txid'].""//757843dd97e5428aa76d2b6b0ce19813
];

try {
	$api = new EfiPay($options);
	$response = $api->pixDetailCharge($params);

	/*if ($_SESSION["txid"]) {
		$params = [
			"id" => $pix["loc"]["id"]
		];
	}*/
	//$qrcode = $api->pixGenerateQRCode($_SESSION["txid"]);
	if($response['status'] == "ATIVA"){
		//echo "<tr><td><img style='width:200px; height:200px; border-radius: 0;' src='" . $qrcode["imagemQrcode"] . "' /></td></tr>";
		echo "<tr><td><button style='width: 200px; height: 200px;' class='btn btn-outline-success' onclick='copiarTexto1()'>Copiar QR code</button></td></tr>";
		$qrcode_value = trim($response["pixCopiaECola"], '"');
    	echo "<tr><td><textarea id='link1' rows='5' cols='50' readonly>".$response["pixCopiaECola"]."</textarea></td></tr>";//$pix["txid"]
		echo "<tr><td><h4>Aguardando Pagamento</h4></td></tr>";//pixCopiaECola
	}else {
		echo "<tr><td><h4>Pagamento Realizado</h4></td></tr>";

		$update_orcamento = "UPDATE tb_orcamento_servico SET
        vpag_orcamento = '".$_SESSION['fatura_prevista']."',
		status_orcamento = '1'
        WHERE cd_orcamento = ".$_SESSION['cd_orcamento'];
        if(mysqli_query($conn_revenda, $update_orcamento)){
          //echo "<script>window.alert('Orçamento Baixado!');</script>";
        }else{
          echo "<script>window.alert('Erro ao Baixar o Orcamento!');</script>";
        }

		$update_movimento_financeiro = "UPDATE tb_movimento_financeiro SET
        status_movimento = 1
        WHERE cd_movimento = ".$_SESSION['cd_movimento'];
        if(mysqli_query($conn_revenda, $update_movimento_financeiro)){
          //echo "<script>window.alert('Movimento Financeiro Liquidado!');</script>";
        }else{
          echo "<script>window.alert('Erro ao Liquidar o Movimento Financeiro!');</script>";
        }

		//$_SESSION['dtvalidlicenca_cliente_comercial'] = date('Y-m-d', strtotime($_SESSION['dtvalidlicenca_cliente_comercial'] . ' +1 month'));

		$update_cliente_comercial = "UPDATE tb_cliente_comercial SET
        dtvalidlicenca_cliente_comercial = '".date('Y-m-d', strtotime($_SESSION['dtvalidlicenca_cliente_comercial'] . ' +1 month'))."',
		fatura_devida_cliente_fiscal = '0'
        WHERE cd_cliente_comercial = ".$_SESSION['cd_cliente_comercial'];
        if(mysqli_query($conn_revenda, $update_cliente_comercial)){
			$_SESSION['txid'] = "null";
			echo "<script>window.alert('Licença liberada com validade até ".date('Y-m-d', strtotime($_SESSION['dtvalidlicenca_cliente_comercial'] . ' +1 month'))."!');</script>";
			echo '<script>location.href="'.$_SESSION['dominio'].'pages/dashboard/index.php";</script>';             
		}else{
          echo "<script>window.alert('Erro na Liberação da Licença!');</script>";
        }
	}
	//print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
} catch (EfiException $e) {
	print_r($e->code . "<br>");
	print_r($e->error . "<br>");
	print_r($e->errorDescription) . "<br>";
} catch (Exception $e) {
	print_r($e->getMessage());
}
