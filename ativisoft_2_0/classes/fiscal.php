<?php

$u = new Usuario; 

class Fiscal
{
    private $certificado;         // Arquivo .pfx
    private $senhaCertificado;    // Senha do certificado
    private $certPem;             // Certificado convertido para PEM
    private $keyPem;              // Chave privada convertida para PEM

    public function __construct($certPath, $senha)
    {
        $this->certificado = $certPath;
        $this->senhaCertificado = $senha;

        // Converte o PFX para arquivos PEM temporários
        $this->gerarArquivosPEM();
    }

    /*
    =========================
    CONVERTER PFX PARA PEM
    =========================
    */
    private function gerarArquivosPEM()
    {
        if (!file_exists($this->certificado)) {
            throw new Exception("Certificado não encontrado: " . $this->certificado);
        }

        $pfx = file_get_contents($this->certificado);

        if ($pfx === false) {
            throw new Exception("Não foi possível ler o arquivo do certificado.");
        }

        $certs = [];

        if (!openssl_pkcs12_read($pfx, $certs, $this->senhaCertificado)) {
            throw new Exception(
                "Erro ao ler o certificado PFX. Verifique se a senha está correta."
            );
        }

        $tmpDir = sys_get_temp_dir();
        $prefix = 'nfse_' . md5($this->certificado . microtime(true));

        $this->certPem = $tmpDir . DIRECTORY_SEPARATOR . $prefix . '_cert.pem';
        $this->keyPem  = $tmpDir . DIRECTORY_SEPARATOR . $prefix . '_key.pem';

        // Salva o certificado
        if (file_put_contents($this->certPem, $certs['cert']) === false) {
            throw new Exception("Não foi possível criar o arquivo PEM do certificado.");
        }

        // Salva a chave privada
        if (file_put_contents($this->keyPem, $certs['pkey']) === false) {
            throw new Exception("Não foi possível criar o arquivo PEM da chave privada.");
        }
    }

    /*
    =========================
    GERAR XML DPS (MODELO SIMPLIFICADO)
    =========================
    */
    private function gerarDPS($cnpj, $cpf_cliente, $descricao, $valor)
    {
        $xml = new DOMDocument("1.0", "utf-8");
        $xml->formatOutput = true;

        $DPS = $xml->createElement("DPS");
        $xml->appendChild($DPS);

        $inf = $xml->createElement("infDPS");
        $DPS->appendChild($inf);

        // Prestador
        $prestador = $xml->createElement("prestador");
        $prestador->appendChild(
            $xml->createElement(
                "CNPJ",
                preg_replace('/\D/', '', $cnpj)
            )
        );
        $inf->appendChild($prestador);

        // Tomador
        $tomador = $xml->createElement("tomador");
        $tomador->appendChild(
            $xml->createElement(
                "CPF",
                preg_replace('/\D/', '', $cpf_cliente)
            )
        );
        $inf->appendChild($tomador);

        // Serviço
        $servico = $xml->createElement("servico");
        $servico->appendChild(
            $xml->createElement("descricao", $descricao)
        );
        $servico->appendChild(
            $xml->createElement(
                "valor",
                number_format((float)$valor, 2, '.', '')
            )
        );
        $inf->appendChild($servico);

        return $xml->saveXML();
    }

    /*
    =========================
    ASSINAR XML (SIMPLIFICADO)
    =========================
    */
    private function assinarXML($xml)
    {
        $certs = [];
        $pfx = file_get_contents($this->certificado);

        if (!openssl_pkcs12_read($pfx, $certs, $this->senhaCertificado)) {
            throw new Exception("Erro ao ler certificado.");
        }

        $privateKey = $certs['pkey'];

        if (!openssl_sign($xml, $assinatura, $privateKey, OPENSSL_ALGO_SHA256)) {
            throw new Exception("Erro ao assinar o XML.");
        }

        return [
            'xml'        => $xml,
            'assinatura' => base64_encode($assinatura)
        ];
    }

    /*
    =========================
    ENVIAR DPS
    =========================
    */
    
    public function emitirNFSE($empresa, $filial, $cnpj, $cpf_cliente, $os, $descricao, $valor)
{
    global $conn;

    // 1. Gera o XML
    $xml = $this->gerarDPS($cnpj, $cpf_cliente, $descricao, $valor);

    // 2. Assina o XML
    $assinatura = $this->assinarXML($xml);

    // 3. Salva arquivos para depuração
    file_put_contents(__DIR__ . '/xml_enviado.xml', $assinatura['xml']);
    file_put_contents(__DIR__ . '/assinatura.txt', $assinatura['assinatura']);

    // 4. Simula uma resposta da API
    $respostaSimulada = [
        'sucesso' => true,
        'mensagem' => 'DPS processado com sucesso (SIMULAÇÃO).',
        'protocolo' => 'TESTE' . date('YmdHis'),
        'numero_nfse' => rand(1000, 9999),
        'codigo_verificacao' => strtoupper(substr(md5(uniqid()), 0, 8)),
        'data_emissao' => date('Y-m-d H:i:s'),
        'prestador' => [
            'cnpj' => preg_replace('/\D/', '', $cnpj)
        ],
        'tomador' => [
            'cpf' => preg_replace('/\D/', '', $cpf_cliente)
        ],
        'servico' => [
            'descricao' => $descricao,
            'valor' => number_format((float)$valor, 2, '.', '')
        ]
    ];

    // 5. Converte para JSON formatado
    $json = json_encode(
        $respostaSimulada,
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
    );

    // 6. Salva retorno simulado
    file_put_contents(__DIR__ . '/retorno_nfse.json', $json);

    /*
    =====================================================
    INSERT NO BANCO
    =====================================================
    */

    $sql = "
        INSERT INTO tb_dados_nfse (
            cd_empresa,
            cd_filial,
            prestador_cnpj,
            tomador_cpf,
            cd_ordem_servico,
            descricao_servico,
            valor_servicos,
            numero_nfse,
            protocolo,
            codigo_verificacao,
            data_emissao,
            status_nfse,
            sucesso,
            json_retorno
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        )
    ";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Erro no prepare: " . $conn->error);
    }

    $cd_empresa = preg_replace('/\D/', '', $empresa);
    $cd_filial = preg_replace('/\D/', '', $filial);
    $prestador_cnpj = preg_replace('/\D/', '', $cnpj);
    $tomador_cpf    = preg_replace('/\D/', '', $cpf_cliente);
    $valor_servico  = number_format((float)$valor, 2, '.', '');

    $numero_nfse        = $respostaSimulada['numero_nfse'];
    $protocolo          = $respostaSimulada['protocolo'];
    $codigo_verificacao = $respostaSimulada['codigo_verificacao'];
    $data_emissao       = $respostaSimulada['data_emissao'];
    $status_nfse        = 'AUTORIZADA';
    $sucesso            = 1;

    $stmt->bind_param(
        "ssssssssssssis",
        $cd_empresa,
        $cd_filial,
        $prestador_cnpj,
        $tomador_cpf,
        $os,
        $descricao,
        $valor_servico,
        $numero_nfse,
        $protocolo,
        $codigo_verificacao,
        $data_emissao,
        $status_nfse,
        $sucesso,
        $json
    );

    if (!$stmt->execute()) {

        file_put_contents(
            __DIR__ . '/erro_insert.txt',
            date('Y-m-d H:i:s') . PHP_EOL .
            $stmt->error . PHP_EOL . PHP_EOL,
            FILE_APPEND
        );

        echo 'Erro ao inserir: ' . $stmt->error;

    } else {

        echo 'Registro salvo com sucesso!';

    }

    $stmt->close();

    /*
    =====================================================
    RETORNO
    =====================================================
    */

    return [
        'http_code' => 200,
        'url' => 'SIMULACAO_LOCAL',
        'content_type' => 'application/json',
        'resposta' => $json
    ];
}

    public function atualizarNFSE(
        $cd_ordem_servico,
        $dados = []
    )
    {
        global $conn;
    
        /*
        |--------------------------------------------------------------------------
        | CAMPOS ACEITOS PARA UPDATE
        |--------------------------------------------------------------------------
        */
        $camposPermitidos = [
    
            'status_nfse',
            'situacao_lote',
            'mensagem',
            'codigo_erro',
            'descricao_erro',
            'protocolo',
            'numero_lote',
            'numero_rps',
            'numero_dps',
            'numero_recibo',
    
            'numero_nfse',
            'codigo_verificacao',
            'chave_acesso',
    
            'data_emissao',
            'data_processamento',
            'data_autorizacao',
            'data_cancelamento',
    
            'valor_servicos',
            'valor_iss',
            'valor_liquido_nfse',
            'valor_total',
    
            'url_consulta',
            'url_pdf',
            'url_xml',
    
            'caminho_xml',
            'caminho_pdf',
            'caminho_retorno',
    
            'xml_dps',
            'xml_nfse',
            'xml_cancelamento',
    
            'json_retorno',
            'retorno_completo',
    
            'sucesso',
            'cancelada',
    
            'motivo_cancelamento',
            'codigo_cancelamento',
            'protocolo_cancelamento',
    
            'hash_documento',
            'token_transacao',
            'gateway',
    
            'dt_atualizacao'
        ];
    
        /*
        |--------------------------------------------------------------------------
        | MONTA UPDATE DINAMICAMENTE
        |--------------------------------------------------------------------------
        */
        $updates = [];
        $values = [];
        $types = '';
    
        foreach ($dados as $campo => $valor) {
    
            if (in_array($campo, $camposPermitidos)) {
    
                $updates[] = "{$campo} = ?";
    
                $values[] = $valor;
    
                /*
                |--------------------------------------------------------------------------
                | DEFINE TIPO MYSQLI
                |--------------------------------------------------------------------------
                */
                if (is_int($valor)) {
                    $types .= 'i';
                } elseif (is_float($valor) || is_double($valor)) {
                    $types .= 'd';
                } else {
                    $types .= 's';
                }
            }
        }
    
        /*
        |--------------------------------------------------------------------------
        | ADICIONA DATA DE ATUALIZAÇÃO
        |--------------------------------------------------------------------------
        */
        $updates[] = "dt_atualizacao = NOW()";
    
        if (empty($updates)) {
            return [
                'sucesso' => false,
                'mensagem' => 'Nenhum campo válido informado.'
            ];
        }
    
        /*
        |--------------------------------------------------------------------------
        | SQL
        |--------------------------------------------------------------------------
        */
        $sql = "
            UPDATE tb_dados_nfse
            SET " . implode(', ', $updates) . "
            WHERE cd_ordem_servico = ?
            ORDER BY id_nfse DESC
            LIMIT 1
        ";
    
        $stmt = $conn->prepare($sql);
    
        if (!$stmt) {
    
            return [
                'sucesso' => false,
                'mensagem' => $conn->error
            ];
        }
    
        /*
        |--------------------------------------------------------------------------
        | ADICIONA O WHERE
        |--------------------------------------------------------------------------
        */
        $types .= 'i';
        $values[] = $cd_ordem_servico;
    
        /*
        |--------------------------------------------------------------------------
        | BIND DINÂMICO
        |--------------------------------------------------------------------------
        */
        $stmt->bind_param($types, ...$values);
    
        /*
        |--------------------------------------------------------------------------
        | EXECUTA
        |--------------------------------------------------------------------------
        */
        if (!$stmt->execute()) {
    
            file_put_contents(
                __DIR__ . '/erro_update_nfse.txt',
                date('Y-m-d H:i:s') . PHP_EOL .
                $stmt->error . PHP_EOL . PHP_EOL,
                FILE_APPEND
            );
    
            return [
                'sucesso' => false,
                'mensagem' => $stmt->error
            ];
        }
    
        $stmt->close();
    
        return [
            'sucesso' => true,
            'mensagem' => 'NFS-e atualizada com sucesso.'
        ];
    }

    /*
    =========================
    CONSULTAR NFSE
    =========================
    */
    public function consultarNFSE($chave)
    {
        $endpoint = "https://adn.nfse.gov.br/nfse/" . urlencode($chave);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);

        // Certificado e chave
        curl_setopt($ch, CURLOPT_SSLCERT, $this->certPem);
        curl_setopt($ch, CURLOPT_SSLKEY, $this->keyPem);

        // SSL
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

        // Executa
        $resposta = curl_exec($ch);

        if ($resposta === false) {
            $erro = curl_error($ch);
            curl_close($ch);
            throw new Exception("Erro no cURL: " . $erro);
        }

        // Informações da resposta
        $httpCode    = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $urlFinal    = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

        curl_close($ch);

        return [
            'http_code'    => $httpCode,
            'url'          => $urlFinal,
            'content_type' => $contentType,
            'resposta'     => $resposta
        ];
    }

    /*
    =========================
    LIMPEZA DOS ARQUIVOS TEMPORÁRIOS
    =========================
    */
    public function __destruct()
    {
        if (!empty($this->certPem) && file_exists($this->certPem)) {
            @unlink($this->certPem);
        }

        if (!empty($this->keyPem) && file_exists($this->keyPem)) {
            @unlink($this->keyPem);
        }
    }
}
?>