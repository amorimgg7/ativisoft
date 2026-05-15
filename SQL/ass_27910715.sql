-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 179.188.16.96
-- Generation Time: 07-Out-2025 às 11:22
-- Versão do servidor: 5.7.32-35-log
-- PHP Version: 5.6.40-0+deb8u12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ass_27910715`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `fl_ponto`
--

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `rel_user`
--

CREATE TABLE `rel_user` (
  `token_alter` int(11) NOT NULL,
  `cd_seg` int(11) DEFAULT NULL,
  `cd_colab` int(11) DEFAULT NULL,
  `cd_estilo` int(11) DEFAULT NULL,
  `cd_funcao` int(11) DEFAULT NULL,
  `cd_empresa` int(11) DEFAULT NULL,
  `cd_status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `rel_user`
--

INSERT INTO `rel_user` (`token_alter`, `cd_seg`, `cd_colab`, `cd_estilo`, `cd_funcao`, `cd_empresa`, `cd_status`) VALUES
(1, 1, 1, 3, 5, 1, 1),
(2, 1, 2, 1, 5, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_atividade`
--

CREATE TABLE `tb_atividade` (
  `cd_atividade` int(11) NOT NULL,
  `cd_servico` int(11) DEFAULT NULL,
  `titulo_atividade` varchar(10) DEFAULT NULL,
  `obs_atividade` varchar(1000) DEFAULT NULL,
  `cd_colab` int(11) DEFAULT NULL,
  `inicio_atividade` varchar(40) DEFAULT NULL,
  `fim_atividade` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_atividade`
--

INSERT INTO `tb_atividade` (`cd_atividade`, `cd_servico`, `titulo_atividade`, `obs_atividade`, `cd_colab`, `inicio_atividade`, `fim_atividade`) VALUES
(1, 1, 'A', 'InstalaÃ§Ã£o ', 2, '2025-04-29T20:51', '2025-04-29T20:51');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_caixa`
--

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
  `fpag_vale` decimal(10,2) DEFAULT NULL,
  `status_caixa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_caixa`
--

INSERT INTO `tb_caixa` (`cd_caixa`, `dt_abertura`, `dt_fechamento`, `cd_colab_abertura`, `cd_colab_fechamento`, `saldo_abertura`, `total_movimento`, `saldo_fechamento`, `diferenca_caixa`, `fpag_dinheiro`, `fpag_debito`, `fpag_credito`, `fpag_pix`, `fpag_cofre`, `fpag_boleto`, `fpag_vale`, `status_caixa`) VALUES
(1, '2025-04-29 20:50:00', NULL, 2, NULL, 50.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_caixa_conferido`
--

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_caixa_dia_fiscal`
--

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_caixa_dia_fiscal`
--

INSERT INTO `tb_caixa_dia_fiscal` (`cd_caixa_dia_fiscal`, `dt_abertura_dia_fiscal`, `dt_fechamento_dia_fiscal`, `movimento_analitico_dia_fiscal`, `movimento_conferido_dia_fiscal`, `total_analitico_dia_fiscal`, `total_conferido_dia_fiscal`, `diferenca_caixa_dia_fiscal`, `status_caixa_dia_fiscal`) VALUES
(1, '2025-04-29 20:50:00', NULL, NULL, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_carrinho`
--

CREATE TABLE `tb_carrinho` (
  `cd_carrinho` int(11) NOT NULL,
  `cd_prod_serv_carrinho` int(11) DEFAULT NULL,
  `qtd_prod_serv_carrinho` int(11) DEFAULT NULL,
  `cd_cliente_carrinho` int(11) DEFAULT NULL,
  `dt_add_carrinho` datetime DEFAULT NULL,
  `dt_status_carrinho` datetime DEFAULT NULL,
  `dt_compra_carrinho` datetime DEFAULT NULL,
  `status_carrinho` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_classe_fiscal`
--

CREATE TABLE `tb_classe_fiscal` (
  `cd_classe_fiscal` int(11) NOT NULL,
  `titulo_classe_fiscal` varchar(100) DEFAULT NULL,
  `obs_classe_fiscal` varchar(100) DEFAULT NULL,
  `ncm_classe_fiscal` int(11) DEFAULT NULL,
  `csosn_classe_fiscal` int(11) DEFAULT NULL,
  `cst_classe_fiscal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_cliente`
--

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_cliente`
--

INSERT INTO `tb_cliente` (`cd_cliente`, `pnome_cliente`, `snome_cliente`, `cpf_cliente`, `dtnasc_cliente`, `sexo_cliente`, `obs_cliente`, `tel_cliente`, `obs_tel_cliente`, `email_cliente`, `foto_cliente`, `senha_cliente`) VALUES
(1, 'Joyce ', 'Santos ', NULL, NULL, NULL, NULL, '5521992308203', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_colab`
--

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_colab`
--

INSERT INTO `tb_colab` (`cd_colab`, `pnome_colab`, `snome_colab`, `cpf_colab`, `dtnasc_colab`, `sexo_colab`, `obs_colab`, `tel_colab`, `obs_tel_colab`, `email_colab`, `foto_colab`, `senha_colab`) VALUES
(1, 'erp-Nuvemsoft', '', '1', NULL, NULL, NULL, '', NULL, 'suporte@ativisoft.com.br', NULL, 'asd,123'),
(2, 'Aloisio', 'Gomes', '', '', '', NULL, '21975836725', NULL, 'ALOISIOGOMES25@GMAIL.COM', NULL, '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_empresa`
--

CREATE TABLE `tb_empresa` (
  `cd_empresa` int(11) NOT NULL,
  `rsocial_empresa` varchar(40) DEFAULT NULL,
  `nfantasia_empresa` varchar(40) DEFAULT NULL,
  `cnpj_empresa` varchar(40) DEFAULT NULL,
  `cd_ceo` int(11) DEFAULT NULL,
  `chave_auth` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_empresa`
--

INSERT INTO `tb_empresa` (`cd_empresa`, `rsocial_empresa`, `nfantasia_empresa`, `cnpj_empresa`, `cd_ceo`, `chave_auth`) VALUES
(1, 'ALOISIO FRANCISCO GOMES', 'REI DAS INSTALAÇÕES', '27910715000138', 1, 'AUTH');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_entidade_financeira`
--

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_estilo`
--

CREATE TABLE `tb_estilo` (
  `cd_estilo` int(11) NOT NULL,
  `titulo_estilo` varchar(40) DEFAULT NULL,
  `t_sidebar` varchar(200) DEFAULT NULL,
  `c_sidebar` varchar(200) DEFAULT NULL,
  `t_navbar` varchar(200) DEFAULT NULL,
  `c_navbar` varchar(200) DEFAULT NULL,
  `t_font` varchar(200) DEFAULT NULL,
  `c_font` varchar(200) DEFAULT NULL,
  `c_body` varchar(200) NOT NULL,
  `c_card` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_estilo`
--

INSERT INTO `tb_estilo` (`cd_estilo`, `titulo_estilo`, `t_sidebar`, `c_sidebar`, `t_navbar`, `c_navbar`, `t_font`, `c_font`, `c_body`, `c_card`) VALUES
(1, 'Light-blue', 'padrão', 'style=\"background-color: #a7dbfb; color: #044167;\"', 'padrão', 'style=\"background-color: #23a5f6;\"', 'padrão', 'padrão', '', ''),
(2, 'Dark-blue', 'padrão', 'style=\"background-color: #191970; color: #ffffff;\"', 'padrão', 'style=\"background-color: #2727ec;\"', 'padrão', 'padrão', 'style=\"background-color: #363672; color:#BDBDEF;border: 0px solid;\"', 'style=\"background-color: #4C4C70; color:#BDBDEF; border: 0px solid;\"'),
(3, 'Grafite', 'padrão', 'style=\"background-color: #a0a0a0; color: #fff;\"', 'padrão', 'style=\"background-color: #808080; color: #fff;\"', 'padrão', 'padrão', '', ''),
(4, 'Rosa-Pastel', 'padrão', 'style=\"background-color: #d88cc8; color: #000;\"', 'padrão', 'style=\"background-color: #b168a2; color: #000;\"', 'padrão', 'padrão', '', ''),
(5, 'Verde-Pastel', 'padrão', 'style=\"background-color: #9dbf5c; color: #000;\"', 'padrão', 'style=\"background-color: #5d7f1f; color: #000;\"', 'padrão', 'padrão', '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_filial`
--

CREATE TABLE `tb_filial` (
  `cd_filial` int(11) NOT NULL,
  `cd_empresa` int(11) DEFAULT NULL,
  `cd_responsavel` int(11) DEFAULT NULL,
  `rsocial_filial` varchar(999) DEFAULT NULL,
  `nfantasia_filial` varchar(999) DEFAULT NULL,
  `cnpj_filial` varchar(40) DEFAULT NULL,
  `endereco_filial` varchar(999) DEFAULT NULL,
  `saudacoes_filial` varchar(999) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_filial`
--

INSERT INTO `tb_filial` (`cd_filial`, `cd_empresa`, `cd_responsavel`, `rsocial_filial`, `nfantasia_filial`, `cnpj_filial`, `endereco_filial`, `saudacoes_filial`) VALUES
(1, 1, 1, 'ALOISIO FRANCISCO GOMES', 'REI DAS INSTALACOES', '27910715000138', 'R BELARMINO DE MATOS, 10, LOJA A, RIO DE JANEIRO, RJ(21) 9 9999 9999 horário de seg a sex (X:XX) as (XX:XX) e sab de (X:XX) as (XX:XX)', 'Prezado cliente, toda mercadoria disponivel aos nossos servicos terão o prazo de 30 dias para serem retirados.');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_funcao`
--

CREATE TABLE `tb_funcao` (
  `cd_funcao` int(11) NOT NULL,
  `titulo_funcao` varchar(200) DEFAULT NULL,
  `obs_funcao` varchar(200) DEFAULT NULL,
  `md_patrimonio` varchar(200) DEFAULT NULL,
  `md_fponto` varchar(200) DEFAULT NULL,
  `md_assistencia` varchar(200) DEFAULT NULL,
  `md_cliente` varchar(200) DEFAULT NULL,
  `md_fornecedor` varchar(200) DEFAULT NULL,
  `md_clientefornecedor` varchar(200) DEFAULT NULL,
  `md_hospedagem` varchar(200) DEFAULT 'style="display: none;"'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_funcao`
--

INSERT INTO `tb_funcao` (`cd_funcao`, `titulo_funcao`, `obs_funcao`, `md_patrimonio`, `md_fponto`, `md_assistencia`, `md_cliente`, `md_fornecedor`, `md_clientefornecedor`, `md_hospedagem`) VALUES
(5, 'Assistente', 'observações', 'style=\"display: none;\"', 'style=\"display: none;\"', 'style=\"display: block;\"', 'style=\"display: none;\"', 'style=\"display: none;\"', 'style=\"display: none;\"', 'style=\"display: none;\"');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_grupo`
--

CREATE TABLE `tb_grupo` (
  `cd_grupo` int(11) NOT NULL,
  `titulo_grupo` varchar(40) DEFAULT NULL,
  `obs_grupo` varchar(999) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_movimento_financeiro`
--

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_movimento_financeiro`
--

INSERT INTO `tb_movimento_financeiro` (`cd_movimento`, `cd_caixa_movimento`, `cd_colab_movimento`, `cd_cliente_movimento`, `tipo_movimento`, `cd_os_movimento`, `fpag_movimento`, `valor_movimento`, `data_movimento`, `obs_movimento`) VALUES
(1, 1, 2, 1, 1, 1, 'credito', 1.00, '2025-04-29 21:53:00', 'PAGAMENTO DA OS: 1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_orcamento_servico`
--

CREATE TABLE `tb_orcamento_servico` (
  `cd_orcamento` int(11) NOT NULL,
  `cd_servico` int(11) DEFAULT NULL,
  `cd_cliente` int(11) DEFAULT NULL,
  `titulo_orcamento` varchar(999) DEFAULT NULL,
  `vcusto_orcamento` varchar(40) DEFAULT NULL,
  `vpag_orcamento` varchar(40) DEFAULT NULL,
  `status_orcamento` int(11) DEFAULT NULL,
  `cd_produto` int(11) DEFAULT NULL,
  `qtd_orcamento` int(11) DEFAULT NULL,
  `vtotal_orcamento` int(11) DEFAULT NULL,
  `tipo_orcamento` varchar(40) DEFAULT 'AVULSO',
  `vprod_orcamento` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_orcamento_servico`
--

INSERT INTO `tb_orcamento_servico` (`cd_orcamento`, `cd_servico`, `cd_cliente`, `titulo_orcamento`, `vcusto_orcamento`, `vpag_orcamento`, `status_orcamento`, `cd_produto`, `qtd_orcamento`, `vtotal_orcamento`, `tipo_orcamento`, `vprod_orcamento`) VALUES
(1, 1, 1, 'InstalaÃ§Ã£o ', NULL, NULL, 0, NULL, 1, 1, 'AVULSO', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_prod_serv`
--

CREATE TABLE `tb_prod_serv` (
  `cd_prod_serv` int(11) NOT NULL,
  `cd_classe_fiscal` int(11) DEFAULT NULL,
  `cd_grupo` int(11) DEFAULT NULL,
  `cdbarras_prod_serv` varchar(999) DEFAULT NULL,
  `titulo_prod_serv` varchar(100) DEFAULT NULL,
  `obs_prod_serv` varchar(999) DEFAULT NULL,
  `estoque_prod_serv` int(11) NOT NULL,
  `tipo_prod_serv` int(11) DEFAULT NULL,
  `preco_prod_serv` decimal(10,2) DEFAULT NULL,
  `custo_prod_serv` decimal(10,2) DEFAULT NULL,
  `status_prod_serv` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_reserva`
--

CREATE TABLE `tb_reserva` (
  `cd_reserva` int(11) NOT NULL,
  `cd_cliente` int(11) DEFAULT NULL,
  `cd_servico` int(11) DEFAULT NULL,
  `cd_orcamento` int(11) DEFAULT NULL,
  `cd_venda` int(11) DEFAULT NULL,
  `cd_prod_serv` int(11) DEFAULT NULL,
  `qtd_reservado` int(11) DEFAULT NULL,
  `qtd_efetivado` int(11) DEFAULT NULL,
  `dt_reservado` varchar(40) DEFAULT NULL,
  `dt_efetivado` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_seguranca`
--

CREATE TABLE `tb_seguranca` (
  `cd_seg` int(11) NOT NULL,
  `titulo_seg` varchar(200) DEFAULT NULL,
  `obs_seg` varchar(40) DEFAULT NULL,
  `cd_colab` varchar(40) DEFAULT NULL,
  `empresa` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_seguranca`
--

INSERT INTO `tb_seguranca` (`cd_seg`, `titulo_seg`, `obs_seg`, `cd_colab`, `empresa`) VALUES
(1, 'master', 'User Master', '1', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_servico`
--

CREATE TABLE `tb_servico` (
  `cd_servico` int(11) NOT NULL,
  `cd_cliente` int(11) DEFAULT NULL,
  `titulo_servico` varchar(100) DEFAULT NULL,
  `obs_servico` varchar(1000) DEFAULT NULL,
  `prioridade_servico` varchar(10) DEFAULT NULL,
  `entrada_servico` varchar(40) NOT NULL,
  `prazo_servico` varchar(40) DEFAULT NULL,
  `orcamento_servico` decimal(10,2) DEFAULT NULL,
  `vpag_servico` decimal(10,2) DEFAULT NULL,
  `status_servico` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_servico`
--

INSERT INTO `tb_servico` (`cd_servico`, `cd_cliente`, `titulo_servico`, `obs_servico`, `prioridade_servico`, `entrada_servico`, `prazo_servico`, `orcamento_servico`, `vpag_servico`, `status_servico`) VALUES
(1, 1, NULL, 'InstalaÃ§Ã£o ', 'B', '2025-04-29T20:51', '2025-04-29T10:00', 1.00, 1.00, '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fl_ponto`
--
ALTER TABLE `fl_ponto`
  ADD PRIMARY KEY (`token_alter`),
  ADD KEY `fk_fl_ponto1` (`cdcolab_ponto`),
  ADD KEY `fk_fl_ponto2` (`cdempresa_ponto`);

--
-- Indexes for table `rel_user`
--
ALTER TABLE `rel_user`
  ADD PRIMARY KEY (`token_alter`),
  ADD KEY `fk_rel_user1` (`cd_seg`),
  ADD KEY `fk_rel_user2` (`cd_colab`),
  ADD KEY `fk_rel_user3` (`cd_estilo`),
  ADD KEY `fk_rel_user4` (`cd_funcao`),
  ADD KEY `fk_rel_user5` (`cd_empresa`);

--
-- Indexes for table `tb_atividade`
--
ALTER TABLE `tb_atividade`
  ADD PRIMARY KEY (`cd_atividade`),
  ADD KEY `fk_rel_colab1` (`cd_servico`),
  ADD KEY `fk_rel_colab2` (`cd_colab`);

--
-- Indexes for table `tb_caixa`
--
ALTER TABLE `tb_caixa`
  ADD PRIMARY KEY (`cd_caixa`),
  ADD KEY `fk_tb_caixa1` (`cd_colab_abertura`),
  ADD KEY `fk_tb_caixa2` (`cd_colab_fechamento`);

--
-- Indexes for table `tb_caixa_conferido`
--
ALTER TABLE `tb_caixa_conferido`
  ADD PRIMARY KEY (`cd_caixa_conferido`),
  ADD KEY `fk_tb_caixa_conferido1` (`cd_caixa_analitico`),
  ADD KEY `fk_tb_caixa_conferido2` (`cd_colab_conferencia`);

--
-- Indexes for table `tb_caixa_dia_fiscal`
--
ALTER TABLE `tb_caixa_dia_fiscal`
  ADD PRIMARY KEY (`cd_caixa_dia_fiscal`);

--
-- Indexes for table `tb_carrinho`
--
ALTER TABLE `tb_carrinho`
  ADD PRIMARY KEY (`cd_carrinho`);

--
-- Indexes for table `tb_classe_fiscal`
--
ALTER TABLE `tb_classe_fiscal`
  ADD PRIMARY KEY (`cd_classe_fiscal`);

--
-- Indexes for table `tb_cliente`
--
ALTER TABLE `tb_cliente`
  ADD PRIMARY KEY (`cd_cliente`);

--
-- Indexes for table `tb_colab`
--
ALTER TABLE `tb_colab`
  ADD PRIMARY KEY (`cd_colab`);

--
-- Indexes for table `tb_empresa`
--
ALTER TABLE `tb_empresa`
  ADD PRIMARY KEY (`cd_empresa`),
  ADD KEY `fk_rel_empresa1` (`cd_ceo`);

--
-- Indexes for table `tb_entidade_financeira`
--
ALTER TABLE `tb_entidade_financeira`
  ADD PRIMARY KEY (`cd_entidade_financeira`);

--
-- Indexes for table `tb_estilo`
--
ALTER TABLE `tb_estilo`
  ADD PRIMARY KEY (`cd_estilo`);

--
-- Indexes for table `tb_filial`
--
ALTER TABLE `tb_filial`
  ADD PRIMARY KEY (`cd_filial`),
  ADD KEY `fk_rel_filial1` (`cd_empresa`),
  ADD KEY `fk_rel_filial2` (`cd_responsavel`);

--
-- Indexes for table `tb_funcao`
--
ALTER TABLE `tb_funcao`
  ADD PRIMARY KEY (`cd_funcao`);

--
-- Indexes for table `tb_grupo`
--
ALTER TABLE `tb_grupo`
  ADD PRIMARY KEY (`cd_grupo`);

--
-- Indexes for table `tb_movimento_financeiro`
--
ALTER TABLE `tb_movimento_financeiro`
  ADD PRIMARY KEY (`cd_movimento`),
  ADD KEY `fk_tb_movimento_financeiro1` (`cd_caixa_movimento`),
  ADD KEY `fk_tb_movimento_financeiro2` (`cd_colab_movimento`),
  ADD KEY `fk_tb_movimento_financeiro3` (`cd_cliente_movimento`),
  ADD KEY `fk_tb_movimento_financeiro4` (`cd_os_movimento`);

--
-- Indexes for table `tb_orcamento_servico`
--
ALTER TABLE `tb_orcamento_servico`
  ADD PRIMARY KEY (`cd_orcamento`),
  ADD KEY `fk_rel_orcamento1` (`cd_servico`),
  ADD KEY `fk_rel_orcamento2` (`cd_cliente`),
  ADD KEY `fk_rel_orcamento3` (`cd_produto`);

--
-- Indexes for table `tb_prod_serv`
--
ALTER TABLE `tb_prod_serv`
  ADD PRIMARY KEY (`cd_prod_serv`);

--
-- Indexes for table `tb_reserva`
--
ALTER TABLE `tb_reserva`
  ADD PRIMARY KEY (`cd_reserva`);

--
-- Indexes for table `tb_seguranca`
--
ALTER TABLE `tb_seguranca`
  ADD PRIMARY KEY (`cd_seg`);

--
-- Indexes for table `tb_servico`
--
ALTER TABLE `tb_servico`
  ADD PRIMARY KEY (`cd_servico`),
  ADD KEY `fk_rel_cliente` (`cd_cliente`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fl_ponto`
--
ALTER TABLE `fl_ponto`
  MODIFY `token_alter` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rel_user`
--
ALTER TABLE `rel_user`
  MODIFY `token_alter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_atividade`
--
ALTER TABLE `tb_atividade`
  MODIFY `cd_atividade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_caixa`
--
ALTER TABLE `tb_caixa`
  MODIFY `cd_caixa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_caixa_conferido`
--
ALTER TABLE `tb_caixa_conferido`
  MODIFY `cd_caixa_conferido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_caixa_dia_fiscal`
--
ALTER TABLE `tb_caixa_dia_fiscal`
  MODIFY `cd_caixa_dia_fiscal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_carrinho`
--
ALTER TABLE `tb_carrinho`
  MODIFY `cd_carrinho` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_classe_fiscal`
--
ALTER TABLE `tb_classe_fiscal`
  MODIFY `cd_classe_fiscal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_cliente`
--
ALTER TABLE `tb_cliente`
  MODIFY `cd_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_colab`
--
ALTER TABLE `tb_colab`
  MODIFY `cd_colab` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_empresa`
--
ALTER TABLE `tb_empresa`
  MODIFY `cd_empresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_entidade_financeira`
--
ALTER TABLE `tb_entidade_financeira`
  MODIFY `cd_entidade_financeira` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_estilo`
--
ALTER TABLE `tb_estilo`
  MODIFY `cd_estilo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_filial`
--
ALTER TABLE `tb_filial`
  MODIFY `cd_filial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_funcao`
--
ALTER TABLE `tb_funcao`
  MODIFY `cd_funcao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_grupo`
--
ALTER TABLE `tb_grupo`
  MODIFY `cd_grupo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_movimento_financeiro`
--
ALTER TABLE `tb_movimento_financeiro`
  MODIFY `cd_movimento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_orcamento_servico`
--
ALTER TABLE `tb_orcamento_servico`
  MODIFY `cd_orcamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_prod_serv`
--
ALTER TABLE `tb_prod_serv`
  MODIFY `cd_prod_serv` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_reserva`
--
ALTER TABLE `tb_reserva`
  MODIFY `cd_reserva` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_seguranca`
--
ALTER TABLE `tb_seguranca`
  MODIFY `cd_seg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_servico`
--
ALTER TABLE `tb_servico`
  MODIFY `cd_servico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `tb_orcamento_servico`
--
ALTER TABLE `tb_orcamento_servico`
  ADD CONSTRAINT `fk_rel_orcamento3` FOREIGN KEY (`cd_produto`) REFERENCES `tb_prod_serv` (`cd_prod_serv`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
