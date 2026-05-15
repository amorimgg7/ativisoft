<?php

require 'vendor/autoload.php';

require 'danfe_lib/xml_parser.php';
require 'danfe_lib/danfe_layout.php';
require 'danfe_lib/barcode.php';
require 'danfe_lib/qrcode.php';

use Dompdf\Dompdf;
use Dompdf\Options;

/* =============================
   PEGAR ARQUIVO
============================= */

$arquivo = $_GET["xml"] ?? "";

if(!$arquivo){
    die("XML não informado");
}

/* segurança básica */

$arquivo = str_replace("..","",$arquivo);

/* caminho correto */

$xmlFile = __DIR__."/temp/".$arquivo;

if(!file_exists($xmlFile)){
    die("XML não encontrado: ".$xmlFile);
}

/* =============================
   LER XML
============================= */

$dados = lerNFe($xmlFile);

/* =============================
   GERAR BARCODE
============================= */

$barcode = gerarBarcode($dados["nota"]["chave"]);

/* =============================
   CONFIGURAÇÃO NFC-e
============================= */

$CSC   = "SEU_CSC_AQUI";
$idCSC = "1";

/* =============================
   DADOS DA NOTA
============================= */

$chave = $dados["nota"]["chave"] ?? "";
$versao = "2";
$ambiente = "1";
$valor = number_format($dados["totais"]["nf"] ?? 0,2,'.','');
$tpEmis = "1";

$digest = $dados["digest"] ?? "";

/* =============================
   GERAR STRING QR CODE
============================= */

$string = $chave."|".$versao."|".$ambiente."|".$idCSC."|".$valor."|".$digest."|".$tpEmis;

/* HASH */

$hash = sha1($string.$CSC);

/* =============================
   LINKS
============================= */

$linkQRCode = "https://consultadfe.fazenda.rj.gov.br/consultaNFCe/QRCode?p=".$string."|".$hash;

$linkConsulta = "https://www.fazenda.rj.gov.br/nfce/consulta?p=".$chave;

/* =============================
   GERAR QRCODE
============================= */

$qrCode = gerarQRCodeBase64($linkQRCode);

/* =============================
   GERAR HTML
============================= */

$html = montarDanfeHTML($dados,$barcode,$qrCode,$linkQRCode);

/* =============================
   GERAR PDF
============================= */

$options = new Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

$dompdf->loadHtml($html,'UTF-8');

$dompdf->setPaper("A4","portrait");

$dompdf->render();

$dompdf->stream("danfe.pdf",["Attachment"=>false]);