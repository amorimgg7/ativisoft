
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `fl_ponto` (
  `token_alter` int(11) NOT NULL,
  `cdcolab_ponto` int(11) DEFAULT NULL,
  `cdempresa_ponto` int(11) DEFAULT NULL,
  `pais_ponto` varchar(40) DEFAULT NULL,
  `estado_ponto` varchar(40) DEFAULT NULL,
  `cidade_ponto` varchar(40) DEFAULT NULL,
  `bairro_ponto` varchar(40) DEFAULT NULL,
  `data_ponto` varchar(40) DEFAULT NULL,
  `hora_ponto` varchar(40) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



CREATE TABLE `rel_user` (
  `token_alter` int(11) NOT NULL,
  `cd_seg` int(11) DEFAULT NULL,
  `cd_colab` int(11) DEFAULT NULL,
  `cd_estilo` int(11) DEFAULT NULL,
  `cd_funcao` int(11) DEFAULT NULL,
  `cd_empresa` int(11) DEFAULT NULL,
  `cd_status` int(11) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



INSERT INTO `rel_user` (`token_alter`, `cd_seg`, `cd_colab`, `cd_estilo`, `cd_funcao`, `cd_empresa`, `cd_status`) VALUES
(1, 1, 1, 1, 5, 1, 1),
(2, 1, 2, 1, 5, 1, 1);


CREATE TABLE `tb_entidade_financeira` (
  `cd_entidade_financeira` int(11) NOT NULL,
  `titulo_entidade_financeira` varchar(10) DEFAULT NULL,
  `obs_entidade_financeira` varchar(10) DEFAULT NULL,
  `rsocial_entidade_financeira` varchar(10) DEFAULT NULL,
  `cnpj_entidade_financeira` varchar(10) DEFAULT NULL,
  `chave_client_id_entidade_financeira` varchar(10) DEFAULT NULL,
  `chave_client_secret_entidade_financeira` varchar(10) DEFAULT NULL,
  `integra_pix_entidade_financeira` varchar(10) DEFAULT NULL,
  `Integra_boleto_secret_entidade_financeira` varchar(10) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

ALTER TABLE `tb_entidade_financeira`
  ADD PRIMARY KEY (`cd_entidade_financeira`);

ALTER TABLE `tb_entidade_financeira`
  MODIFY `cd_entidade_financeira` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;



CREATE TABLE `tb_atividade` (
  `cd_atividade` int(11) NOT NULL,
  `cd_servico` int(11) DEFAULT NULL,
  `titulo_atividade` varchar(10) DEFAULT NULL,
  `obs_atividade` varchar(1000) DEFAULT NULL,
  `cd_colab` int(11) DEFAULT NULL,
  `inicio_atividade` varchar(40) DEFAULT NULL,
  `fim_atividade` varchar(40) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



CREATE TABLE `tb_caixa` (
  `cd_caixa` int(11) NOT NULL,
  `dt_abertura` datetime NOT NULL,
  `dt_fechamento` datetime DEFAULT NULL,
  `cd_colab_abertura` int(11) DEFAULT NULL,
  `cd_colab_fechamento` int(11) DEFAULT NULL,
  `saldo_abertura` decimal(10,2) DEFAULT NULL,
  `total_movimento` decimal(10,2) DEFAULT NULL,
  `saldo_fechamento` decimal(10,2) DEFAULT NULL,
  `diferenca_caixa` decimal(10,2) DEFAULT NULL,
  `fpag_dinheiro` decimal(10,2) DEFAULT NULL,
  `fpag_debito` decimal(10,2) DEFAULT NULL,
  `fpag_credito` decimal(10,2) DEFAULT NULL,
  `fpag_pix` decimal(10,2) DEFAULT NULL,
  `fpag_cofre` decimal(10,2) DEFAULT NULL,
  `fpag_boleto` decimal(10,2) DEFAULT NULL,
  `status_caixa` int(11) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



CREATE TABLE `tb_caixa_conferido` (
  `cd_caixa_conferido` int(11) NOT NULL,
  `cd_caixa_analitico` int(11) DEFAULT NULL,
  `dt_conferencia` datetime DEFAULT NULL,
  `cd_colab_conferencia` int(11) DEFAULT NULL,
  `obs_conferencia` varchar(999) DEFAULT NULL,
  `saldo_abertura_conferido` decimal(10,2) DEFAULT NULL,
  `saldo_fechamento_conferido` decimal(10,2) DEFAULT NULL,
  `diferenca_caixa_conferido` decimal(10,2) DEFAULT NULL,
  `saldo_movimento_conferido` decimal(10,2) DEFAULT NULL,
  `fpag_dinheiro_conferido` decimal(10,2) DEFAULT NULL,
  `fpag_debito_conferido` decimal(10,2) DEFAULT NULL,
  `fpag_credito_conferido` decimal(10,2) DEFAULT NULL,
  `fpag_pix_conferido` decimal(10,2) DEFAULT NULL,
  `fpag_cofre_conferido` decimal(10,2) DEFAULT NULL,
  `fpag_boleto_conferido` decimal(10,2) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


CREATE TABLE `tb_caixa_dia_fiscal` (
  `cd_caixa_dia_fiscal` int(11) NOT NULL,
  `dt_abertura_dia_fiscal` datetime NOT NULL,
  `dt_fechamento_dia_fiscal` datetime DEFAULT NULL,
  `movimento_analitico_dia_fiscal` decimal(10,2) DEFAULT NULL,
  `movimento_conferido_dia_fiscal` decimal(10,2) DEFAULT NULL,
  `total_analitico_dia_fiscal` decimal(10,2) DEFAULT NULL,
  `total_conferido_dia_fiscal` decimal(10,2) DEFAULT NULL,
  `diferenca_caixa_dia_fiscal` decimal(10,2) DEFAULT NULL,
  `status_caixa_dia_fiscal` int(11) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


CREATE TABLE `tb_cliente` (
  `cd_cliente` int(11) NOT NULL,
  `pnome_cliente` varchar(40) DEFAULT NULL,
  `snome_cliente` varchar(40) DEFAULT NULL,
  `cpf_cliente` varchar(40) DEFAULT NULL,
  `dtnasc_cliente` varchar(40) DEFAULT NULL,
  `sexo_cliente` varchar(40) DEFAULT NULL,
  `obs_cliente` varchar(40) DEFAULT NULL,
  `tel_cliente` varchar(40) DEFAULT NULL,
  `obs_tel_cliente` varchar(40) DEFAULT NULL,
  `email_cliente` varchar(40) DEFAULT NULL,
  `foto_cliente` varchar(1000) DEFAULT NULL,
  `senha_cliente` varchar(40) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



CREATE TABLE `tb_colab` (
  `cd_colab` int(11) NOT NULL,
  `pnome_colab` varchar(40) DEFAULT NULL,
  `snome_colab` varchar(40) DEFAULT NULL,
  `cpf_colab` varchar(40) DEFAULT NULL,
  `dtnasc_colab` varchar(40) DEFAULT NULL,
  `sexo_colab` varchar(40) DEFAULT NULL,
  `obs_colab` varchar(40) DEFAULT NULL,
  `tel_colab` varchar(40) DEFAULT NULL,
  `obs_tel_colab` varchar(40) DEFAULT NULL,
  `email_colab` varchar(40) DEFAULT NULL,
  `foto_colab` varchar(1000) DEFAULT NULL,
  `senha_colab` varchar(40) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



INSERT INTO `tb_colab` (`cd_colab`, `pnome_colab`, `snome_colab`, `cpf_colab`, `dtnasc_colab`, `sexo_colab`, `obs_colab`, `tel_colab`, `obs_tel_colab`, `email_colab`, `foto_colab`, `senha_colab`) VALUES
(1, 'erp-Nuvemsoft', '', '1', NULL, NULL, NULL, '', NULL, 'suporte@ativisoft.com.br', NULL, 'asd,123'),
(2, 'Aloisio', 'Gomes', '', '', '', NULL, '5521975836725', NULL, 'reidasinstalacaoe@gmail.com', NULL, '1'),
(3, 'Marissol', 'Ramalho', '', '', '', NULL, '5521964367149', NULL, 'marissolcriz23@gmail.com', NULL, '1');


CREATE TABLE `tb_empresa` (
  `cd_empresa` int(11) NOT NULL,
  `rsocial_empresa` varchar(100) DEFAULT NULL,
  `nfantasia_empresa` varchar(100) DEFAULT NULL,
  `cnpj_empresa` int(100) DEFAULT NULL,
  `cd_ceo` int(11) DEFAULT NULL,
  `chave_auth` varchar(1000) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



INSERT INTO `tb_empresa` (`cd_empresa`, `rsocial_empresa`, `nfantasia_empresa`, `cnpj_empresa`, `cd_ceo`, `chave_auth`) VALUES
(1, 'ALOISIO FRANCISCO GOMES', 'ALOISIO FRANCISCO GOMES', 27910715000138, 2, 'AUTH');



CREATE TABLE `tb_estilo` (
  `cd_estilo` int(11) NOT NULL,
  `titulo_estilo` varchar(40) DEFAULT NULL,
  `t_sidebar` varchar(200) DEFAULT NULL,
  `c_sidebar` varchar(200) DEFAULT NULL,
  `t_navbar` varchar(200) DEFAULT NULL,
  `c_navbar` varchar(200) DEFAULT NULL,
  `t_font` varchar(200) DEFAULT NULL,
  `c_font` varchar(200) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `tb_estilo` (`cd_estilo`, `titulo_estilo`, `t_sidebar`, `c_sidebar`, `t_navbar`, `c_navbar`, `t_font`, `c_font`) VALUES
(1, 'Light-blue', 'padrão', 'style=\"background-color: #a7dbfb; color: #044167;\"', 'padrão', 'style=\"background-color: #23a5f6;\"', 'padrão', 'padrão'),
(2, 'Dark-blue', 'padrão', 'style=\"background-color: #191970; color: #8b8bbb;\"', 'padrão', 'style=\"background-color: #2727ec;\"', 'padrão', 'padrão');


CREATE TABLE `tb_estilo_site` (
  `cd_estilo` int(11) NOT NULL,
  `titulo_estilo` varchar(40) DEFAULT NULL,
  `t_sidebar` varchar(200) DEFAULT NULL,
  `c_sidebar` varchar(200) DEFAULT NULL,
  `t_navbar` varchar(200) DEFAULT NULL,
  `c_navbar` varchar(200) DEFAULT NULL,
  `t_font` varchar(200) DEFAULT NULL,
  `c_font` varchar(200) DEFAULT NULL,
  `saudacao_inicial` varchar(999) DEFAULT NULL,
  `saudacao_final` varchar(999) DEFAULT NULL,
  `modelo_site` varchar(999) DEFAULT NULL,
  `cabecalho_site` varchar(999) DEFAULT NULL,
  `apresentacao_site` varchar(999) DEFAULT NULL,
  `apresentacao_site_txt` varchar(999) DEFAULT NULL,
  `apresentacao_site_html` varchar(9999) DEFAULT NULL,
  `rodape_site` boolean DEFAULT false,
  `apresentacao_site_html` varchar(9999) DEFAULT NULL,
  `modelo_impressao` varchar(99) DEFAULT NULL,
  `modelo_site` varchar(99) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `tb_estilo_impressao` (`cd_estilo`, `titulo_estilo`, `t_sidebar`, `c_sidebar`, `t_navbar`, `c_navbar`, `t_font`, `c_font`) VALUES
(1, 'Versão 1', 'padrão', 'style=\"background-color: #a7dbfb; color: #044167;\"', 'padrão', 'style=\"background-color: #23a5f6;\"', 'padrão', 'padrão', 'saudacao inicial', 'saudacao final', 'modelo site', 'cabecalho site', 'apresentacao site', 'apresentacao site txt', 'apresentacao site html', false, 'apresentacao site html', 'modelo impressao', 'modelo site'),
(2, 'Versão 2', 'padrão', 'style=\"background-color: #a7dbfb; color: #044167;\"', 'padrão', 'style=\"background-color: #23a5f6;\"', 'padrão', 'padrão', 'saudacao inicial', 'saudacao final', 'modelo site', 'cabecalho site', 'apresentacao site', 'apresentacao site txt', 'apresentacao site html', false, 'apresentacao site html', 'modelo impressao', 'modelo site');


CREATE TABLE `tb_estilo_impressao` (
  `cd_estilo` int(11) NOT NULL,
  `titulo_estilo` varchar(40) DEFAULT NULL,
  `saudacao_inicial` varchar(999) DEFAULT NULL,
  `saudacao_final` varchar(999) DEFAULT NULL,
  `modelo_impressao` varchar(99) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `tb_estilo_impressao` (`cd_estilo`, `titulo_estilo`, `t_sidebar`, `c_sidebar`, `t_navbar`, `c_navbar`, `t_font`, `c_font`) VALUES
(1, 'Light-blue', 'padrão', 'style=\"background-color: #a7dbfb; color: #044167;\"', 'padrão', 'style=\"background-color: #23a5f6;\"', 'padrão', 'padrão'),
(2, 'Dark-blue', 'padrão', 'style=\"background-color: #191970; color: #8b8bbb;\"', 'padrão', 'style=\"background-color: #2727ec;\"', 'padrão', 'padrão');


CREATE TABLE tb_seguranca(
    `cd_seg` int(11) NOT NULL,	
    `titulo_seg` varchar(200),
    `obs_seg` varchar(40),
    `cd_colab` varchar(40),
	`empresa` varchar(40)
);

INSERT INTO tb_seguranca (titulo_seg,obs_seg, cd_colab, empresa)
VALUES ('master', 'User Master', '1', '1');


CREATE TABLE `tb_servico` (
  `cd_servico` int(11) PRIMARY KEY,
  `cd_cliente` int(11) DEFAULT NULL,
  `titulo_servico` varchar(100) DEFAULT NULL,
  `obs_servico` varchar(1000) DEFAULT NULL,
  `prioridade_servico` varchar(10) DEFAULT NULL,
  `entrada_servico` varchar(40) NOT NULL,
  `prazo_servico` varchar(40) DEFAULT NULL,
  `orcamento_servico` decimal(10,2) DEFAULT NULL,
  `vpag_servico` decimal(10,2) DEFAULT NULL,
  `status_servico` varchar(10) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


CREATE TABLE `tb_filial` (
  `cd_filial` int(11) NOT NULL,
  `cd_empresa` int(11) DEFAULT NULL,
  `cd_responsavel` int(11) DEFAULT NULL,
  `rsocial_filial` varchar(999) DEFAULT NULL,
  `nfantasia_filial` varchar(999) DEFAULT NULL,
  `cnpj_filial` varchar(40) DEFAULT NULL,
  `endereco_filial` varchar(999) DEFAULT NULL,
  `saudacoes_filial` varchar(999) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


INSERT INTO `tb_filial` (`cd_filial`, `cd_empresa`, `cd_responsavel`, `rsocial_filial`, `nfantasia_filial`, `cnpj_filial`, `endereco_filial`, `saudacoes_filial`) VALUES
(1, 1, 1, 'ALOISIO FRANCISCO GOMES', 'ALOISIO FRANCISCO GOMES', '27910715000138', 'Rua..., Número, Cidade, RJ horário de - a - das - as - e - de - as -', 'Saudações.');



CREATE TABLE `tb_funcao` (
  `cd_funcao` int(11) NOT NULL,
  `titulo_funcao` varchar(200) DEFAULT NULL,
  `obs_funcao` varchar(200) DEFAULT NULL,
  `md_patrimonio` varchar(200) DEFAULT NULL,
  `md_fponto` varchar(200) DEFAULT NULL,
  `md_assistencia` varchar(200) DEFAULT NULL,
  `md_cliente` varchar(200) DEFAULT NULL,
  `md_fornecedor` varchar(200) DEFAULT NULL,
  `md_clientefornecedor` varchar(200) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


INSERT INTO `tb_funcao` (`cd_funcao`, `titulo_funcao`, `obs_funcao`, `md_patrimonio`, `md_fponto`, `md_assistencia`, `md_cliente`, `md_fornecedor`, `md_clientefornecedor`) VALUES
(5, 'Assistente', 'observações', 'style=\"display: none;\"', 'style=\"display: none;\"', 'style=\"display: block;\"', 'style=\"display: none;\"', 'style=\"display: none;\"', 'style=\"display: none;\"');



CREATE TABLE `tb_movimento_financeiro` (
  `cd_movimento` int(11) NOT NULL,
  `cd_caixa_movimento` int(11) DEFAULT NULL,
  `cd_colab_movimento` int(11) DEFAULT NULL,
  `cd_cliente_movimento` int(11) DEFAULT NULL,
  `tipo_movimento` int(11) DEFAULT NULL,
  `cd_os_movimento` int(11) DEFAULT NULL,
  `fpag_movimento` varchar(999) DEFAULT NULL,
  `valor_movimento` decimal(10,2) DEFAULT NULL,
  `data_movimento` datetime DEFAULT NULL,
  `obs_movimento` varchar(999) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `tb_orcamento_servico` (
  `cd_orcamento` int(11) ,
  `cd_servico` int(11) DEFAULT NULL,
  `cd_cliente` int(11) DEFAULT NULL,
  `cd_produto` int(11) DEFAULT NULL,
  `titulo_orcamento` varchar(999) DEFAULT NULL,
  `vcusto_orcamento` varchar(40) DEFAULT NULL,
  `qtd_orcamento` int(11) DEFAULT NULL,
  `vtotal_orcamento` int(11) DEFAULT NULL,
  `vpag_orcamento` varchar(40) DEFAULT NULL,
  `tipo_orcamento` varchar(40) DEFAULT NULL,
  `status_orcamento` int(11) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


CREATE TABLE tb_filme(
    cd_filme integer PRIMARY KEY AUTO_INCREMENT,
    titulo_filme varchar(99),
    sinopse_filme varchar(9999),
    lancamento_filme varchar(40),
    genero_filme varchar(40),
    classificacao_filme varchar(40),
    duracao_filme varchar(40),
    pontuacao_filme varchar(40),
    magnect_link_720p_filme varchar(9999),
    magnect_link_1080p_filme varchar(9999),
);

INSERT INTO tb_filme (titulo_filme, lancamento_filme, duracao_filme, classificacao_filme)
VALUES ('Jungle Fever (1991)', '1991', '1H', '+14');

ALTER TABLE `tb_filme` ADD PRIMARY KEY (`cd_filme`),

ALTER TABLE `tb_filme` MODIFY `cd_filme` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


CREATE TABLE tb_casa(
  cd_casa integer PRIMARY KEY AUTO_INCREMENT,
  cd_cliente int(11) DEFAULT NULL,
  cd_anfitriao int(11) DEFAULT NULL,
  titulo_casa varchar(100) DEFAULT NULL,
  obs_casa varchar(1000) DEFAULT NULL,
  iptu_casa varchar(100) DEFAULT NULL,
  valor_venda decimal(10,2) DEFAULT NULL,
  valor_aluga decimal(10,2) DEFAULT NULL,
  tipo_exercicio varchar(40) DEFAULT NULL,
  cd_endereco int(11) DEFAULT NULL,
  status_casa varchar(10) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO tb_casa (titulo_casa, obs_casa, valor_venda, valor_aluga, tipo_exercicio, status_casa)
VALUES ('Casa teste', 'Testes', '100', '100','A', '0');

CREATE TABLE tb_dispositivo(
    cd_dispositivo integer PRIMARY KEY AUTO_INCREMENT,
    cd_casa_dispositivo integer,
    mac_dispositivo varchar(99),
    ip_dispositivo varchar(9999),
    mascara_dispositivo varchar(40),
    gateway_dispositivo varchar(40),
    marca_dispositivo varchar(40),
    modelo_dispositivo varchar(40),
    versao_dispositivo varchar(40),
    titulo_dispositivo varchar(40),
    local_dispositivo varchar(40),
    status_dispositivo varchar(40),
    dt_status_dispositivo DATETIME NOT NULL,
    canal_1 varchar(40),
    canal_2 varchar(40),
    canal_3 varchar(40),
    canal_4 varchar(40),
    canal_5 varchar(40),
    canal_6 varchar(40),
    canal_7 varchar(40),
    canal_8 varchar(40)
);

INSERT INTO tb_dispositivo (
    cd_casa_dispositivo, 
    mac_dispositivo, 
    ip_dispositivo, 
    mascara_dispositivo, 
    gateway_dispositivo, 
    marca_dispositivo, 
    modelo_dispositivo, 
    versao_dispositivo, 
    titulo_dispositivo, 
    local_dispositivo, 
    status_dispositivo,
    dt_status_dispositivo,
    canal_1, 
    canal_2, 
    canal_3, 
    canal_4, 
    canal_5, 
    canal_6, 
    canal_7, 
    canal_8
) VALUES
(1, '00:1A:2B:3C:4D:5E', '192.168.1.2', '255.255.255.0', '192.168.1.1', 'MarcaA', 'ModeloA', '1.0', 'Dispositivo 1', 'Sala', 'Ativo', '13-07-2024T17:10', 'Canal 1A', 'Canal 2A', 'Canal 3A', 'Canal 4A', 'Canal 5A', 'Canal 6A', 'Canal 7A', 'Canal 8A'),
(1, '11:2B:3C:4D:5E:6F', '192.168.1.3', '255.255.255.0', '192.168.1.1', 'MarcaB', 'ModeloB', '2.0', 'Dispositivo 2', 'Quarto', 'Inativo', '13-07-2024T17:10', 'Canal 1B', 'Canal 2B', 'Canal 3B', 'Canal 4B', 'Canal 5B', 'Canal 6B', 'Canal 7B', 'Canal 8B'),
(1, '22:3C:4D:5E:6F:7G', '192.168.1.4', '255.255.255.0', '192.168.1.1', 'MarcaC', 'ModeloC', '3.0', 'Dispositivo 3', 'Cozinha', 'Ativo', '13-07-2024T17:10', 'Canal 1C', 'Canal 2C', 'Canal 3C', 'Canal 4C', 'Canal 5C', 'Canal 6C', 'Canal 7C', 'Canal 8C'),
(1, '33:4D:5E:6F:7G:8H', '192.168.1.5', '255.255.255.0', '192.168.1.1', 'MarcaD', 'ModeloD', '4.0', 'Dispositivo 4', 'Escritório', 'Manutenção', '13-07-2024T17:10', 'Canal 1D', 'Canal 2D', 'Canal 3D', 'Canal 4D', 'Canal 5D', 'Canal 6D', 'Canal 7D', 'Canal 8D');


CREATE TABLE tb_endereco(
  cd_endereco integer PRIMARY KEY AUTO_INCREMENT,
  cep_endereco varchar(100) DEFAULT NULL,
  pais_endereco varchar(100) DEFAULT NULL,
  estado_endereco varchar(100) DEFAULT NULL,
  municipio_endereco varchar(100) DEFAULT NULL,
  bairro_endereco varchar(100) DEFAULT NULL,
  logradouro_endereco varchar(100) DEFAULT NULL,
  complemento_endereco varchar(100) DEFAULT NULL,
  tipo_endereco varchar(100) DEFAULT NULL,
  status_endereco varchar(100) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO tb_endereco(cep_endereco, pais_endereco, estado_endereco, municipio_endereco, bairro_endereco, logradouro_endereco, complemento_endereco, tipo_endereco, status_endereco)
VALUES ('22780805', 'BRASIL', 'RJ', 'RIO DE JANEIRO', 'CURICICA', 'RUA JOÃO BRUNO LOBO, 291', 'LOTE A, CASA 1', 'RESIDENCIAL', '0');



ALTER TABLE `fl_ponto`
  ADD PRIMARY KEY (`token_alter`),
  ADD KEY `fk_fl_ponto1` (`cdcolab_ponto`),
  ADD KEY `fk_fl_ponto2` (`cdempresa_ponto`);


ALTER TABLE `rel_user`
  ADD PRIMARY KEY (`token_alter`),
  ADD KEY `fk_rel_user1` (`cd_seg`),
  ADD KEY `fk_rel_user2` (`cd_colab`),
  ADD KEY `fk_rel_user3` (`cd_estilo`),
  ADD KEY `fk_rel_user4` (`cd_funcao`),
  ADD KEY `fk_rel_user5` (`cd_empresa`);


ALTER TABLE `tb_atividade`
  ADD PRIMARY KEY (`cd_atividade`),
  ADD KEY `fk_rel_colab1` (`cd_servico`),
  ADD KEY `fk_rel_colab2` (`cd_colab`);


ALTER TABLE `tb_caixa`
  ADD PRIMARY KEY (`cd_caixa`),
  ADD KEY `fk_tb_caixa1` (`cd_colab_abertura`),
  ADD KEY `fk_tb_caixa2` (`cd_colab_fechamento`);


ALTER TABLE `tb_caixa_conferido`
  ADD PRIMARY KEY (`cd_caixa_conferido`),
  ADD KEY `fk_tb_caixa_conferido1` (`cd_caixa_analitico`),
  ADD KEY `fk_tb_caixa_conferido2` (`cd_colab_conferencia`);


ALTER TABLE `tb_caixa_dia_fiscal`
  ADD PRIMARY KEY (`cd_caixa_dia_fiscal`);


ALTER TABLE `tb_cliente`
  ADD PRIMARY KEY (`cd_cliente`);


ALTER TABLE `tb_colab`
  ADD PRIMARY KEY (`cd_colab`);


ALTER TABLE `tb_empresa`
  ADD PRIMARY KEY (`cd_empresa`),
  ADD KEY `fk_rel_empresa1` (`cd_ceo`);


ALTER TABLE `tb_estilo`
  ADD PRIMARY KEY (`cd_estilo`);


ALTER TABLE `tb_filial`
  ADD PRIMARY KEY (`cd_filial`),
  ADD KEY `fk_rel_filial1` (`cd_empresa`),
  ADD KEY `fk_rel_filial2` (`cd_responsavel`);


ALTER TABLE `tb_funcao`
  ADD PRIMARY KEY (`cd_funcao`);


ALTER TABLE `tb_movimento_financeiro`
  ADD PRIMARY KEY (`cd_movimento`),
  ADD KEY `fk_tb_movimento_financeiro1` (`cd_caixa_movimento`),
  ADD KEY `fk_tb_movimento_financeiro2` (`cd_colab_movimento`),
  ADD KEY `fk_tb_movimento_financeiro3` (`cd_cliente_movimento`),
  ADD KEY `fk_tb_movimento_financeiro4` (`cd_os_movimento`);


ALTER TABLE `tb_orcamento_servico`
  ADD PRIMARY KEY (`cd_orcamento`),
  ADD KEY `fk_rel_orcamento1` (`cd_servico`),
  ADD KEY `fk_rel_orcamento2` (`cd_cliente`);


ALTER TABLE `tb_seguranca`
  ADD PRIMARY KEY (`cd_seg`);


ALTER TABLE `tb_servico`
  ADD KEY `fk_rel_cliente` (`cd_cliente`);




ALTER TABLE `fl_ponto`
  MODIFY `token_alter` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `rel_user`
  MODIFY `token_alter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


ALTER TABLE `tb_atividade`
  MODIFY `cd_atividade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


ALTER TABLE `tb_caixa`
  MODIFY `cd_caixa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


ALTER TABLE `tb_caixa_conferido`
  MODIFY `cd_caixa_conferido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


ALTER TABLE `tb_caixa_dia_fiscal`
  MODIFY `cd_caixa_dia_fiscal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


ALTER TABLE `tb_cliente`
  MODIFY `cd_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


ALTER TABLE `tb_colab`
  MODIFY `cd_colab` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


ALTER TABLE `tb_empresa`
  MODIFY `cd_empresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `tb_estilo`
  MODIFY `cd_estilo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


ALTER TABLE `tb_filial`
  MODIFY `cd_filial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `tb_funcao`
  MODIFY `cd_funcao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;


ALTER TABLE `tb_movimento_financeiro`
  MODIFY `cd_movimento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


ALTER TABLE `tb_orcamento_servico`
  MODIFY `cd_orcamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


ALTER TABLE `tb_seguranca`
  MODIFY `cd_seg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `tb_servico`
  MODIFY `cd_servico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;


