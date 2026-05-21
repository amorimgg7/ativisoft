CREATE TABLE tb_dados_nfse (
    aliquota_cofins DECIMAL(9,6) NULL,
    aliquota_inss DECIMAL(9,6) NULL,
    aliquota_ir DECIMAL(9,6) NULL,
    aliquota_csll DECIMAL(9,6) NULL,

    -- Retenções
    iss_retido TINYINT(1) NULL,
    pis_retido TINYINT(1) NULL,
    cofins_retido TINYINT(1) NULL,
    inss_retido TINYINT(1) NULL,
    ir_retido TINYINT(1) NULL,
    csll_retido TINYINT(1) NULL,

    -- Tributos federais
    codigo_nbs VARCHAR(20) NULL,
    codigo_cest VARCHAR(20) NULL,

    -- Construção civil
    obra_codigo VARCHAR(50) NULL,
    obra_art VARCHAR(50) NULL,

    -- Cancelamento
    cancelada TINYINT(1) NOT NULL DEFAULT 0,
    motivo_cancelamento LONGTEXT NULL,
    codigo_cancelamento VARCHAR(50) NULL,
    protocolo_cancelamento VARCHAR(100) NULL,

    -- Substituição
    numero_nfse_substituida VARCHAR(50) NULL,
    numero_nfse_substituta VARCHAR(50) NULL,

    -- URL e documentos
    url_consulta VARCHAR(500) NULL,
    url_pdf VARCHAR(500) NULL,
    url_xml VARCHAR(500) NULL,

    -- Arquivos locais
    caminho_xml VARCHAR(500) NULL,
    caminho_pdf VARCHAR(500) NULL,
    caminho_retorno VARCHAR(500) NULL,

    -- Conteúdo armazenado
    xml_dps LONGTEXT NULL,
    xml_nfse LONGTEXT NULL,
    xml_cancelamento LONGTEXT NULL,
    json_retorno LONGTEXT NULL,
    retorno_completo LONGTEXT NULL,

    -- Assinatura digital
    certificado_serie VARCHAR(100) NULL,
    certificado_emitente VARCHAR(255) NULL,
    certificado_validade DATETIME NULL,

    -- Auditoria
    usuario_emissao VARCHAR(100) NULL,
    maquina_emissao VARCHAR(100) NULL,
    ip_emissao VARCHAR(45) NULL,

    -- Integração externa
    id_externo VARCHAR(100) NULL,
    token_transacao VARCHAR(200) NULL,
    gateway VARCHAR(100) NULL,

    PRIMARY KEY (id_nfse),

    UNIQUE KEY ux_tb_dados_nfse_chave_acesso (chave_acesso),

    KEY ix_tb_dados_nfse_numero_nfse (numero_nfse),
    KEY ix_tb_dados_nfse_protocolo (protocolo),
    KEY ix_tb_dados_nfse_prestador_cnpj (prestador_cnpj),
    KEY ix_tb_dados_nfse_tomador_cpf (tomador_cpf),
    KEY ix_tb_dados_nfse_tomador_cnpj (tomador_cnpj),
    KEY ix_tb_dados_nfse_data_emissao (data_emissao),
    KEY ix_tb_dados_nfse_status (status_nfse)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;