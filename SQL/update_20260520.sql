

CREATE TABLE tb_dados_nfse (
    -- Identificação interna
    id_nfse BIGINT NOT NULL AUTO_INCREMENT,
    dt_cadastro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    dt_atualizacao DATETIME NULL DEFAULT NULL,

    -- Controle interno
    cd_filial INT NULL,
    cd_empresa INT NULL,
    cd_cliente INT NULL,
    cd_ordem_servico INT NULL,
    cd_orcamento INT NULL,
    cd_venda INT NULL,
    cd_usuario INT NULL,

    -- Ambiente
    ambiente VARCHAR(20) NULL,
    sistema_origem VARCHAR(100) NULL,
    versao_sistema VARCHAR(50) NULL,

    -- Situação
    status_nfse VARCHAR(50) NULL,
    situacao_lote VARCHAR(50) NULL,
    sucesso TINYINT(1) NOT NULL DEFAULT 0,

    -- Mensagens e erros
    mensagem LONGTEXT NULL,
    codigo_erro VARCHAR(50) NULL,
    descricao_erro LONGTEXT NULL,
    observacoes LONGTEXT NULL,

    -- Protocolo e recibos
    protocolo VARCHAR(100) NULL,
    numero_lote VARCHAR(50) NULL,
    numero_rps VARCHAR(50) NULL,
    serie_rps VARCHAR(20) NULL,
    tipo_rps VARCHAR(10) NULL,
    numero_dps VARCHAR(50) NULL,
    numero_recibo VARCHAR(50) NULL,

    -- Identificação da NFS-e
    numero_nfse VARCHAR(50) NULL,
    codigo_verificacao VARCHAR(100) NULL,
    chave_acesso VARCHAR(100) NULL,
    hash_documento VARCHAR(256) NULL,

    -- Datas
    data_emissao DATETIME NULL,
    data_competencia DATE NULL,
    data_processamento DATETIME NULL,
    data_autorizacao DATETIME NULL,
    data_cancelamento DATETIME NULL,

    -- Prestador de Serviço
    prestador_cnpj VARCHAR(14) NULL,
    prestador_cpf VARCHAR(11) NULL,
    prestador_inscricao_municipal VARCHAR(30) NULL,
    prestador_inscricao_estadual VARCHAR(30) NULL,
    prestador_razao_social VARCHAR(255) NULL,
    prestador_nome_fantasia VARCHAR(255) NULL,
    prestador_regime_tributario VARCHAR(50) NULL,
    prestador_optante_simples TINYINT(1) NULL,
    prestador_incentivador_cultural TINYINT(1) NULL,

    -- Endereço do Prestador
    prestador_cep VARCHAR(8) NULL,
    prestador_logradouro VARCHAR(255) NULL,
    prestador_numero VARCHAR(20) NULL,
    prestador_complemento VARCHAR(255) NULL,
    prestador_bairro VARCHAR(100) NULL,
    prestador_codigo_municipio VARCHAR(10) NULL,
    prestador_municipio VARCHAR(100) NULL,
    prestador_uf CHAR(2) NULL,
    prestador_pais VARCHAR(100) NULL,
    prestador_codigo_pais VARCHAR(10) NULL,
    prestador_telefone VARCHAR(20) NULL,
    prestador_email VARCHAR(255) NULL,

    -- Tomador de Serviço
    tomador_tipo_documento VARCHAR(10) NULL,
    tomador_cnpj VARCHAR(14) NULL,
    tomador_cpf VARCHAR(11) NULL,
    tomador_inscricao_municipal VARCHAR(30) NULL,
    tomador_inscricao_estadual VARCHAR(30) NULL,
    tomador_razao_social VARCHAR(255) NULL,
    tomador_nome_fantasia VARCHAR(255) NULL,
    tomador_telefone VARCHAR(20) NULL,
    tomador_email VARCHAR(255) NULL,

    -- Endereço do Tomador
    tomador_cep VARCHAR(8) NULL,
    tomador_logradouro VARCHAR(255) NULL,
    tomador_numero VARCHAR(20) NULL,
    tomador_complemento VARCHAR(255) NULL,
    tomador_bairro VARCHAR(100) NULL,
    tomador_codigo_municipio VARCHAR(10) NULL,
    tomador_municipio VARCHAR(100) NULL,
    tomador_uf CHAR(2) NULL,
    tomador_pais VARCHAR(100) NULL,
    tomador_codigo_pais VARCHAR(10) NULL,

    -- Intermediário
    intermediario_cnpj VARCHAR(14) NULL,
    intermediario_cpf VARCHAR(11) NULL,
    intermediario_razao_social VARCHAR(255) NULL,
    intermediario_inscricao_municipal VARCHAR(30) NULL,

    -- Serviço
    codigo_servico VARCHAR(20) NULL,
    item_lista_servico VARCHAR(10) NULL,
    cnae VARCHAR(10) NULL,
    codigo_tributacao_municipio VARCHAR(30) NULL,
    discriminacao LONGTEXT NULL,
    descricao_servico LONGTEXT NULL,
    municipio_prestacao_codigo VARCHAR(10) NULL,
    municipio_prestacao_nome VARCHAR(100) NULL,
    uf_prestacao CHAR(2) NULL,
    pais_prestacao VARCHAR(100) NULL,

    -- Natureza da operação
    natureza_operacao VARCHAR(50) NULL,
    exigibilidade_iss VARCHAR(50) NULL,
    local_incidencia VARCHAR(100) NULL,

    -- Valores
    valor_servicos DECIMAL(18,2) NULL,
    valor_deducoes DECIMAL(18,2) NULL,
    valor_pis DECIMAL(18,2) NULL,
    valor_cofins DECIMAL(18,2) NULL,
    valor_inss DECIMAL(18,2) NULL,
    valor_ir DECIMAL(18,2) NULL,
    valor_csll DECIMAL(18,2) NULL,
    valor_outras_retencoes DECIMAL(18,2) NULL,
    valor_iss DECIMAL(18,2) NULL,
    valor_iss_retido DECIMAL(18,2) NULL,
    valor_desconto_condicionado DECIMAL(18,2) NULL,
    valor_desconto_incondicionado DECIMAL(18,2) NULL,
    valor_credito DECIMAL(18,2) NULL,
    valor_liquido_nfse DECIMAL(18,2) NULL,
    valor_total DECIMAL(18,2) NULL,
    valor_aproximado_tributos DECIMAL(18,2) NULL,

    -- Alíquotas
    aliquota_iss DECIMAL(9,6) NULL,
    aliquota_pis DECIMAL(9,6) NULL,
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
    caminho_xml_cancelamento VARCHAR(500) NULL,
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





ALTER TABLE `tb_empresa` ADD `regime_fiscal` integer NULL AFTER `imunicipal_empresa`;
ALTER TABLE `tb_empresa` ADD `ambiente_fiscal` integer NULL AFTER `imunicipal_empresa`;
ALTER TABLE `tb_empresa` ADD `csc_nfce` varchar(99) NULL AFTER `imunicipal_empresa`;
ALTER TABLE `tb_empresa` ADD `id_csc_nfce` varchar(99) NULL AFTER `imunicipal_empresa`;
ALTER TABLE `tb_empresa` ADD `cnae_fiscal` varchar(99) NULL AFTER `imunicipal_empresa`;
ALTER TABLE `tb_empresa` ADD `senha_certificado` varchar(99) NULL AFTER `imunicipal_empresa`;
ALTER TABLE `tb_empresa` ADD `certificado_digital` varchar(99) NULL AFTER `imunicipal_empresa`;







 UPDATE rel_master
 SET acesso_assistencia_0002 = JSON_ARRAY_APPEND(
    acesso_assistencia_0002,
    '$',
    JSON_ARRAY("211", "Emitir NFSE", "N")
 );
