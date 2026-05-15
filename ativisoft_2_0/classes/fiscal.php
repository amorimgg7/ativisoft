<?php
    $u = new Usuario;
    class Fiscal
{

    private $certificado;
    private $senhaCertificado;

    public function __construct($certPath,$senha)
    {
        $this->certificado = $certPath;
        $this->senhaCertificado = $senha;
    }

    /*
    =========================
    GERAR XML DPS
    =========================
    */

    private function gerarDPS($cnpj,$cpf_cliente,$descricao,$valor)
    {

        $xml = new DOMDocument("1.0","utf-8");

        $DPS = $xml->createElement("DPS");
        $xml->appendChild($DPS);

        $inf = $xml->createElement("infDPS");
        $DPS->appendChild($inf);

        $prestador = $xml->createElement("prestador");

        $cnpjNode = $xml->createElement("CNPJ",$cnpj);
        $prestador->appendChild($cnpjNode);

        $inf->appendChild($prestador);


        $tomador = $xml->createElement("tomador");

        $cpfNode = $xml->createElement("CPF",$cpf_cliente);
        $tomador->appendChild($cpfNode);

        $inf->appendChild($tomador);


        $servico = $xml->createElement("servico");

        $desc = $xml->createElement("descricao",$descricao);
        $servico->appendChild($desc);

        $valorNode = $xml->createElement("valor",$valor);
        $servico->appendChild($valorNode);

        $inf->appendChild($servico);

        return $xml->saveXML();
    }

    /*
    =========================
    ASSINAR XML
    =========================
    */

    private function assinarXML($xml)
    {

        $pfx = file_get_contents($this->certificado);

        if(!openssl_pkcs12_read($pfx,$certs,$this->senhaCertificado)){
            throw new Exception("Erro ao ler certificado");
        }

        $privateKey = $certs['pkey'];

        openssl_sign($xml,$assinatura,$privateKey,OPENSSL_ALGO_SHA256);

        $assinatura64 = base64_encode($assinatura);

        return [
            "xml"=>$xml,
            "assinatura"=>$assinatura64
        ];
    }


    /*
    =========================
    ENVIAR DPS
    =========================
    */

    public function emitirNFSE($cnpj,$cpf_cliente,$descricao,$valor)
    {

        $xml = $this->gerarDPS($cnpj,$cpf_cliente,$descricao,$valor);

        $assinatura = $this->assinarXML($xml);

        $endpoint = "https://adn.nfse.gov.br/dps";

        $ch = curl_init();

        curl_setopt($ch,CURLOPT_URL,$endpoint);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_POST,true);

        curl_setopt($ch,CURLOPT_HTTPHEADER,[
            "Content-Type: application/xml"
        ]);

        curl_setopt($ch,CURLOPT_POSTFIELDS,$assinatura['xml']);

        curl_setopt($ch,CURLOPT_SSLCERT,$this->certificado);
        curl_setopt($ch,CURLOPT_SSLCERTPASSWD,$this->senhaCertificado);

        $resposta = curl_exec($ch);

        if(curl_errno($ch)){
            throw new Exception(curl_error($ch));
        }

        curl_close($ch);

        return $resposta;
    }

    /*
    =========================
    CONSULTAR NFSE
    =========================
    */

    public function consultarNFSE($chave)
    {

        $endpoint = "https://adn.nfse.gov.br/nfse/".$chave;

        $ch = curl_init();

        curl_setopt($ch,CURLOPT_URL,$endpoint);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

        curl_setopt($ch,CURLOPT_SSLCERT,$this->certificado);
        curl_setopt($ch,CURLOPT_SSLCERTPASSWD,$this->senhaCertificado);

        $resposta = curl_exec($ch);

        if(curl_errno($ch)){
            throw new Exception(curl_error($ch));
        }

        curl_close($ch);

        return $resposta;
    }

}