-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 22/03/2024 às 19:14
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ativisoft_123`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `fl_ponto`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `rel_user`
--

CREATE TABLE `rel_user` (
  `token_alter` int(11) NOT NULL,
  `cd_seg` int(11) DEFAULT NULL,
  `cd_colab` int(11) DEFAULT NULL,
  `cd_estilo` int(11) DEFAULT NULL,
  `cd_funcao` int(11) DEFAULT NULL,
  `cd_empresa` int(11) DEFAULT NULL,
  `cd_status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `rel_user`
--

INSERT INTO `rel_user` (`token_alter`, `cd_seg`, `cd_colab`, `cd_estilo`, `cd_funcao`, `cd_empresa`, `cd_status`) VALUES
(1, 1, 1, 1, 5, 1, 1),
(4, 1, 9, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_atividade`
--

CREATE TABLE `tb_atividade` (
  `cd_atividade` int(11) NOT NULL,
  `cd_servico` int(11) DEFAULT NULL,
  `titulo_atividade` varchar(10) DEFAULT NULL,
  `obs_atividade` varchar(1000) DEFAULT NULL,
  `cd_colab` int(11) DEFAULT NULL,
  `inicio_atividade` varchar(40) DEFAULT NULL,
  `fim_atividade` varchar(40) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_caixa`
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
  `status_caixa` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_caixa_conferido`
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `tb_caixa_conferido`
--

INSERT INTO `tb_caixa_conferido` (`cd_caixa_conferido`, `cd_caixa_analitico`, `dt_conferencia`, `cd_colab_conferencia`, `obs_conferencia`, `saldo_abertura_conferido`, `saldo_fechamento_conferido`, `diferenca_caixa_conferido`, `saldo_movimento_conferido`, `fpag_dinheiro_conferido`, `fpag_debito_conferido`, `fpag_credito_conferido`, `fpag_pix_conferido`, `fpag_cofre_conferido`, `fpag_boleto_conferido`) VALUES
(37, 18, '2023-08-24 20:40:00', 1, 'Fechamento de Caixa (Normal)', 3.00, 204.00, 0.00, 201.00, 36.00, 0.00, 0.00, 165.00, NULL, NULL),
(38, 17, '2023-08-25 05:24:00', 1, 'Fechamento de Caixa (Auditoria do dia anterior)', 100.00, 200.00, 0.00, 100.00, 100.00, 0.00, 0.00, 0.00, NULL, NULL),
(33, 12, '2023-08-24 07:45:00', 9, 'Fechamento de Caixa (Auditoria do dia anterior)', 5.00, 954.00, 10.00, 939.00, 130.00, 0.00, 481.00, 338.00, NULL, NULL),
(34, 14, '2023-08-24 07:45:00', 9, 'Fechamento de Caixa (Auditoria do dia anterior)', 8.00, 53.00, 15.00, 30.00, 45.00, 0.00, 0.00, 0.00, NULL, NULL),
(35, 15, '2023-08-24 07:46:00', 9, 'Fechamento de Caixa (Auditoria do dia anterior)', 20.00, 50.00, 0.00, 30.00, 30.00, 0.00, 0.00, 0.00, NULL, NULL),
(36, 16, '2023-08-24 07:46:00', 9, 'Fechamento de Caixa (Auditoria do dia anterior)', 5.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 50.00, NULL),
(39, 19, '2023-08-25 15:24:00', 1, 'Fechamento de Caixa (Auditoria do dia anterior)', 5.00, 55.00, 0.00, 50.00, 0.00, 0.00, 0.00, 0.00, 50.00, NULL),
(40, 19, '2023-08-25 15:27:00', 1, 'Fechamento de Caixa (Auditoria do dia anterior)', 5.00, 55.00, 0.00, 50.00, 0.00, 0.00, 0.00, 0.00, 50.00, NULL),
(41, 19, '2023-08-25 15:28:00', 1, 'Fechamento de Caixa (Auditoria do dia anterior)', 5.00, 110.00, 5.00, 50.00, 0.00, 0.00, 0.00, 0.00, 55.00, NULL),
(42, 19, '2023-08-25 15:29:00', 1, 'Fechamento de Caixa (Auditoria do dia anterior)', 5.00, 115.00, 10.00, 50.00, 0.00, 0.00, 0.00, 0.00, 60.00, NULL),
(43, 20, '2023-08-25 15:34:00', 1, 'Fechamento de Caixa (Auditoria do dia anterior)', 4.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 90.00, NULL),
(44, 20, '2023-08-25 15:35:00', 1, 'Fechamento de Caixa (Auditoria do dia anterior)', 4.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 90.00, NULL),
(45, 20, '2023-08-25 15:38:00', 1, 'Fechamento de Caixa (Normal)', 4.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(46, 20, '2023-08-25 15:41:00', 1, 'Fechamento de Caixa (Normal)', 4.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 90.00, NULL),
(47, 21, '2023-08-28 21:25:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 30.00, 60.00, 0.00, 30.00, 30.00, 0.00, 0.00, 0.00, NULL, NULL),
(48, 22, '2023-08-28 22:31:00', 1, 'Fechamento de Caixa (Normal)', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(49, 24, '2023-08-31 17:15:00', 1, 'Fechamento de Caixa (Auditoria do dia anterior)', 23.00, 23.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(50, 23, '2023-08-31 17:15:00', 1, 'Fechamento de Caixa (Auditoria do dia anterior)', 39.00, 39.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(51, 25, '2023-09-01 10:36:00', 1, 'Fechamento de Caixa (Auditoria do dia anterior)', 50.00, 50.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(52, 26, '2023-09-01 12:49:00', 12, 'Fechamento de Caixa (Normal)', 100.00, 1255.50, 0.00, 1155.50, 950.00, 0.00, 0.00, 200.00, 0.00, NULL),
(53, 27, '2023-09-08 13:30:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 50.00, 50.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(54, 28, '2023-09-09 02:21:00', 1, 'Fechamento de Caixa (Auditoria do dia anterior)', 10.00, 150.00, 0.00, 140.00, 100.00, 40.00, 0.00, 0.00, 0.00, NULL),
(55, 29, '2023-09-10 15:40:00', 1, 'Fechamento de Caixa (Auditoria do dia anterior)', 0.00, 93.00, 0.00, 93.00, 50.00, 0.00, 0.00, 43.00, 0.00, NULL),
(56, 29, '2023-09-12 09:23:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 0.00, 339.00, 0.00, 339.00, 50.00, 0.00, 246.00, 43.00, NULL, NULL),
(57, 29, '2023-09-12 09:23:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 0.00, 339.00, 0.00, 339.00, 50.00, 0.00, 246.00, 43.00, NULL, NULL),
(58, 30, '2023-10-04 08:38:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(59, 31, '2023-10-13 09:03:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 10.00, 55.00, 0.00, 45.00, 45.00, 0.00, 0.00, 0.00, NULL, NULL),
(60, 32, '2023-10-20 16:15:00', 1, 'Fechamento de Caixa (Auditoria do dia anterior)', 30.00, 33.00, 0.00, 3.00, 3.00, 0.00, 0.00, 0.00, 0.00, NULL),
(61, 33, '2023-10-26 08:44:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 10.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(62, 34, '2023-10-30 20:47:00', 1, 'Fechamento de Caixa (Auditoria do dia anterior)', 0.00, 6.00, 0.00, 6.00, 0.00, 0.00, 3.00, 3.00, 0.00, NULL),
(63, 35, '2023-10-31 06:54:00', 1, 'Fechamento de Caixa (Auditoria do dia anterior)', 10.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(64, 36, '2023-10-31 19:56:00', 1, 'Fechamento de Caixa (Normal)', 10.00, 15.00, 0.00, 5.00, 0.00, 5.00, 0.00, 0.00, 1.00, NULL),
(65, 37, '2023-11-03 09:45:00', 1, 'Fechamento de Caixa (Normal)', 50.00, 50.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(66, 38, '2023-11-03 14:28:00', 1, 'Fechamento de Caixa (Normal)', 30.00, 139.00, 0.00, 109.00, 100.00, 0.00, 0.00, 9.00, 0.00, NULL),
(67, 38, '2023-11-03 14:30:00', 1, 'Fechamento de Caixa (Normal)', 30.00, 139.00, 0.00, 109.00, 100.00, 0.00, 0.00, 9.00, 0.00, NULL),
(68, 39, '2023-11-03 23:30:00', 1, 'Fechamento de Caixa (Normal)', 30.00, 59.00, 0.00, 29.00, 2.00, 0.00, 0.00, 30.00, 0.00, NULL),
(69, 39, '2023-11-03 23:30:00', 1, 'Fechamento de Caixa (Normal)', 30.00, 59.00, 0.00, 29.00, 2.00, 0.00, 0.00, 30.00, 0.00, NULL),
(70, 40, '2023-11-10 14:47:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 3.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(71, 41, '2023-11-16 06:53:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 0.00, 50.00, 0.00, 50.00, 0.00, 0.00, 50.00, 0.00, NULL, NULL),
(72, 42, '2023-11-18 19:25:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 2.00, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(73, 43, '2023-11-18 19:30:00', 1, 'Fechamento de Caixa (Normal)', 50.00, 50.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(74, 44, '2023-11-19 09:55:00', 12, 'Fechamento de Caixa (Auditoria do dia anterior)', 10.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(75, 45, '2023-11-21 10:41:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 10.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(76, 46, '2023-11-27 10:10:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 10.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(77, 47, '2023-12-11 15:28:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 3.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(78, 48, '2023-12-13 21:07:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 2.00, 4.00, 0.00, 2.00, 0.00, 2.00, 0.00, 0.00, NULL, NULL),
(79, 49, '2023-12-17 17:27:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 8.00, 9.00, 0.00, 1.00, 1.00, 0.00, 0.00, 0.00, NULL, NULL),
(80, 50, '2023-12-27 18:45:00', 1, 'Fechamento de Caixa (Normal)', 2.00, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(81, 51, '2023-12-29 09:26:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 50.00, 50.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(82, 53, '2024-01-11 09:23:00', 9, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 0.00, 50.00, 0.00, 50.00, 0.00, 0.00, 0.00, 50.00, NULL, NULL),
(83, 52, '2024-01-11 09:23:00', 9, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 80.00, 95.00, 0.00, 15.00, 0.00, 5.00, 0.00, 10.00, NULL, NULL),
(84, 54, '2024-02-08 12:32:00', 1, 'Fechamento de Caixa (Normal)', 0.00, 0.00, 0.00, 0.00, 1.00, 2.00, 3.00, 4.00, 5.00, NULL),
(85, 55, '2024-02-08 14:48:00', 1, 'Fechamento de Caixa (Normal)', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(86, 56, '2024-03-12 19:21:00', 1, 'Fechamento de Caixa (Normal)', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(87, 57, '2024-03-12 20:45:00', 12, 'Fechamento de Caixa (Normal)', 0.00, 685.50, 11.00, 674.50, 10.00, 0.00, 0.00, 501.00, 0.00, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_caixa_dia_fiscal`
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `tb_caixa_dia_fiscal`
--

INSERT INTO `tb_caixa_dia_fiscal` (`cd_caixa_dia_fiscal`, `dt_abertura_dia_fiscal`, `dt_fechamento_dia_fiscal`, `movimento_analitico_dia_fiscal`, `movimento_conferido_dia_fiscal`, `total_analitico_dia_fiscal`, `total_conferido_dia_fiscal`, `diferenca_caixa_dia_fiscal`, `status_caixa_dia_fiscal`) VALUES
(7, '2023-08-24 16:28:00', '2023-08-25 15:35:00', 501.00, 501.00, 732.00, 747.00, 15.00, 2),
(6, '2023-08-23 04:55:00', '2023-08-24 07:46:00', 999.00, 999.00, 1037.00, 1062.00, 25.00, 2),
(8, '2023-08-25 14:40:00', '2023-08-25 15:41:00', 501.00, 501.00, 740.00, 755.00, 15.00, 2),
(9, '2023-08-26 03:59:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(10, '2023-08-28 21:25:00', NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 1),
(11, '2023-08-30 00:47:00', '2023-08-31 17:15:00', 0.00, 0.00, 62.00, 62.00, 0.00, 2),
(12, '2023-08-30 00:47:00', '2023-08-31 17:15:00', 0.00, 0.00, 62.00, 62.00, 0.00, 2),
(13, '2023-08-31 17:19:00', '2023-09-01 10:36:00', 0.00, 0.00, 50.00, 50.00, 0.00, 2),
(14, '2023-09-01 12:34:00', '2023-09-01 12:49:00', 1155.50, 1155.50, 1255.50, 1255.50, 0.00, 2),
(15, '2023-09-04 14:58:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(16, '2023-09-08 13:30:00', '2023-09-09 02:21:00', 140.00, 140.00, 150.00, 150.00, 0.00, 2),
(17, '2023-09-09 02:21:00', '2023-09-10 15:40:00', 93.00, 93.00, 93.00, 93.00, 0.00, 2),
(18, '2023-10-01 10:49:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(19, '2023-10-11 09:51:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(20, '2023-10-19 19:14:00', '2023-10-20 16:15:00', 3.00, 3.00, 33.00, 33.00, 0.00, 2),
(21, '2023-10-23 19:00:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(22, '2023-10-29 10:26:00', '2023-10-30 20:47:00', 6.00, 6.00, 6.00, 6.00, 0.00, 2),
(23, '2023-10-30 20:47:00', '2023-10-31 06:54:00', 0.00, 0.00, 10.00, 10.00, 0.00, 2),
(24, '2023-10-31 19:50:00', '2023-10-31 19:56:00', 5.00, 5.00, 15.00, 15.00, 0.00, 2),
(25, '2023-11-03 09:24:00', '2023-11-03 23:30:00', 276.00, 276.00, 446.00, 446.00, 0.00, 2),
(26, '2023-11-07 17:24:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(27, '2023-11-10 14:48:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(28, '2023-11-16 06:53:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(29, '2023-11-18 19:25:00', '2023-11-19 09:55:00', 0.00, 0.00, 60.00, 60.00, 0.00, 2),
(30, '2023-11-19 11:48:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(31, '2023-11-21 10:41:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(32, '2023-11-28 07:27:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(33, '2023-12-11 15:29:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(34, '2023-12-13 22:42:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(35, '2023-12-27 17:42:00', NULL, 0.00, 0.00, 2.00, 2.00, 0.00, 1),
(36, '2023-12-29 09:26:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(37, '2024-02-08 12:27:00', NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 1),
(38, '2024-03-12 19:21:00', NULL, 674.50, 674.50, 674.50, 685.50, 11.00, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_classe_fiscal`
--

CREATE TABLE `tb_classe_fiscal` (
  `cd_classe_fiscal` int(11) NOT NULL,
  `titulo_classe_fiscal` varchar(100) DEFAULT NULL,
  `obs_classe_fiscal` varchar(100) DEFAULT NULL,
  `ncm_classe_fiscal` int(11) DEFAULT NULL,
  `csosn_classe_fiscal` int(11) DEFAULT NULL,
  `cst_classe_fiscal` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `tb_classe_fiscal`
--

INSERT INTO `tb_classe_fiscal` (`cd_classe_fiscal`, `titulo_classe_fiscal`, `obs_classe_fiscal`, `ncm_classe_fiscal`, `csosn_classe_fiscal`, `cst_classe_fiscal`) VALUES
(1, 'Classe Geral', 'Classe fiscal para coisas em geral', 0, 105, 500);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_cliente`
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `tb_cliente`
--

INSERT INTO `tb_cliente` (`cd_cliente`, `pnome_cliente`, `snome_cliente`, `cpf_cliente`, `dtnasc_cliente`, `sexo_cliente`, `obs_cliente`, `tel_cliente`, `obs_tel_cliente`, `email_cliente`, `foto_cliente`, `senha_cliente`) VALUES
(1, 'Gabriel', 'Amorim', NULL, NULL, NULL, NULL, '5521960150200', NULL, 'amorimgg7@gmail.com', NULL, NULL),
(3, 'Gabriel', 'Amorim', NULL, NULL, NULL, NULL, '5521965543094', NULL, NULL, NULL, NULL),
(2, 'Marissol', 'Ramalho', NULL, NULL, NULL, NULL, '5521964367149', NULL, NULL, NULL, NULL),
(4, 'Jack', 'Mach', NULL, NULL, NULL, NULL, '5521998850083', NULL, NULL, NULL, NULL),
(5, 'Teste', 'Teste', NULL, NULL, NULL, NULL, '447999386132', NULL, NULL, NULL, NULL),
(6, 'FÃ¡bio', 'Souza de Medeiros', NULL, NULL, NULL, NULL, '5521980317038', NULL, NULL, NULL, NULL),
(7, 'Carlos', 'Alexandre', NULL, NULL, NULL, NULL, '5521987480619', NULL, NULL, NULL, NULL),
(8, 'Teste', 'Desconhecido', NULL, NULL, NULL, NULL, '5521965543095', NULL, NULL, NULL, NULL),
(9, 'Teste2', 'Desconhecido', NULL, NULL, NULL, NULL, '5521965543096', NULL, NULL, NULL, NULL),
(10, 'desconhecido', 'desconhecido', NULL, NULL, NULL, NULL, '5521965543092', NULL, NULL, NULL, NULL),
(11, 'Teste', 'Teste', NULL, NULL, NULL, NULL, '5511111111111', NULL, NULL, NULL, NULL),
(12, 'Teste', 'Teste', NULL, NULL, NULL, NULL, '5522222222222', NULL, NULL, NULL, NULL),
(13, 'Teste', 'Teste', NULL, NULL, NULL, NULL, '5533333333333', NULL, NULL, NULL, NULL),
(14, 'Teste', 'Teste', NULL, NULL, NULL, NULL, '5544444444444', NULL, NULL, NULL, NULL),
(15, 'ttt', 'yyy', NULL, NULL, NULL, NULL, '5521965543333', NULL, NULL, NULL, NULL),
(16, 'Maria', 'Da Luz', NULL, NULL, NULL, NULL, '5521982803278', NULL, NULL, NULL, NULL),
(17, 'Breno', 'Ventura', NULL, NULL, NULL, NULL, '5521987839142', NULL, NULL, NULL, NULL),
(18, 'JoÃ£o ', 'Vitor', NULL, NULL, NULL, NULL, '5521973192617', NULL, '', NULL, NULL),
(19, 'JoÃ£o', 'Neto', NULL, NULL, NULL, NULL, '5521912345123', NULL, 'joaoneto@gmail.com', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_colab`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_colab`
--

INSERT INTO `tb_colab` (`cd_colab`, `pnome_colab`, `snome_colab`, `cpf_colab`, `dtnasc_colab`, `sexo_colab`, `obs_colab`, `tel_colab`, `obs_tel_colab`, `email_colab`, `foto_colab`, `senha_colab`) VALUES
(1, 'Suporte', 'erp-Nuvemsoft', '1', NULL, NULL, NULL, '21960150200', NULL, 'suporte@ativisoft.com.br', NULL, 'asd,123'),
(9, 'Consultor Gabriel', 'Amorim', NULL, NULL, NULL, '', '21965543094', NULL, 'amorimgg7@gmail.com', NULL, '1');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_empresa`
--

CREATE TABLE `tb_empresa` (
  `cd_empresa` int(11) NOT NULL,
  `rsocial_empresa` varchar(40) DEFAULT NULL,
  `nfantasia_empresa` varchar(40) DEFAULT NULL,
  `cnpj_empresa` int(11) DEFAULT NULL,
  `cd_ceo` int(11) DEFAULT NULL,
  `chave_auth` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_empresa`
--

INSERT INTO `tb_empresa` (`cd_empresa`, `rsocial_empresa`, `nfantasia_empresa`, `cnpj_empresa`, `cd_ceo`, `chave_auth`) VALUES
(1, 'ERP NUVEMSOFT', 'ERP NUVEMSOFT', 123, 1, 'AUTH');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_estilo`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_estilo`
--

INSERT INTO `tb_estilo` (`cd_estilo`, `titulo_estilo`, `t_sidebar`, `c_sidebar`, `t_navbar`, `c_navbar`, `t_font`, `c_font`, `c_body`, `c_card`) VALUES
(1, 'Light-blue', 'padrão', 'style=\"background-color: #a7dbfb; color: #044167;\"', 'padrão', 'style=\"background-color: #23a5f6;\"', 'padrão', 'padrão', '', ''),
(2, 'Dark-blue', 'padrão', 'style=\"background-color: #191970; color: #ffffff;\"', 'padrão', 'style=\"background-color: #2727ec;\"', 'padrão', 'padrão', 'style=\"background-color: #363672; color:#BDBDEF;border: 0px solid;\"', 'style=\"background-color: #4C4C70; color:#BDBDEF; border: 0px solid;\"');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_filial`
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `tb_filial`
--

INSERT INTO `tb_filial` (`cd_filial`, `cd_empresa`, `cd_responsavel`, `rsocial_filial`, `nfantasia_filial`, `cnpj_filial`, `endereco_filial`, `saudacoes_filial`) VALUES
(1, 1, 1, 'ERP NUVEMSOFT', 'ERP NUVEMSOFT', '123', 'Rua João Bruno Lobo 291A Casa 1, Curicica', 'Você só vence amanhã se não desistir hoje Edna Frigato');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_funcao`
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
  `md_clientefornecedor` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_funcao`
--

INSERT INTO `tb_funcao` (`cd_funcao`, `titulo_funcao`, `obs_funcao`, `md_patrimonio`, `md_fponto`, `md_assistencia`, `md_cliente`, `md_fornecedor`, `md_clientefornecedor`) VALUES
(1, 'MASTER', 'observações', 'style=\"display: block;\"', 'style=\"display: block;\"', 'style=\"display: block;\"', 'style=\"display: block;\"', 'style=\"display: block;\"', 'style=\"display: block;\"'),
(2, 'Cliente', 'observações', 'style=\"display: none;\"', 'style=\"display: none;\"', 'style=\"display: none;\"', 'style=\"display: block;\"', 'style=\"display: none;\"', 'style=\"display: none;\"'),
(3, 'Fornecedor', 'observações', 'style=\"display: none;\"', 'style=\"display: none;\"', 'style=\"display: none;\"', 'style=\"display: none;\"', 'style=\"display: block;\"', 'style=\"display: none;\"'),
(4, 'Cliente / Fornecedor', 'observações', 'style=\"display: none;\"', 'style=\"display: none;\"', 'style=\"display: none;\"', 'style=\"display: none;\"', 'style=\"display: none;\"', 'style=\"display: block;\"'),
(5, 'Assistente', 'observações', 'style=\"display: block;\"', 'style=\"display: block;\"', 'style=\"display: block;\"', 'style=\"display: none;\"', 'style=\"display: none;\"', 'style=\"display: none;\"');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_grupo`
--

CREATE TABLE `tb_grupo` (
  `cd_grupo` int(11) NOT NULL,
  `titulo_grupo` varchar(40) DEFAULT NULL,
  `obs_grupo` varchar(999) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `tb_grupo`
--

INSERT INTO `tb_grupo` (`cd_grupo`, `titulo_grupo`, `obs_grupo`) VALUES
(1, 'Grupo 1', 'Grupo destinado as primeiras coisas'),
(2, 'Grupo 2', 'Grupo destinado as segundas coisas'),
(3, 'Grupo 3', 'Grupo destinado as terceiras coisas'),
(4, 'Teste', 'Grupo de teste'),
(5, 'Ttt', 'Ttt');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_movimento_financeiro`
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_orcamento_servico`
--

CREATE TABLE `tb_orcamento_servico` (
  `cd_orcamento` int(11) NOT NULL,
  `cd_servico` int(11) DEFAULT NULL,
  `cd_cliente` int(11) DEFAULT NULL,
  `titulo_orcamento` varchar(999) DEFAULT NULL,
  `vcusto_orcamento` varchar(40) DEFAULT NULL,
  `vpag_orcamento` varchar(40) DEFAULT NULL,
  `status_orcamento` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_prod_serv`
--

CREATE TABLE `tb_prod_serv` (
  `cd_prod_serv` int(11) NOT NULL,
  `cd_classe_fiscal` int(11) DEFAULT NULL,
  `cd_grupo` int(11) DEFAULT NULL,
  `cdbarras_prod_serv` varchar(999) DEFAULT NULL,
  `titulo_prod_serv` varchar(100) DEFAULT NULL,
  `obs_prod_serv` varchar(999) DEFAULT NULL,
  `tipo_prod_serv` int(11) DEFAULT NULL,
  `preco_prod_serv` decimal(10,2) DEFAULT NULL,
  `custo_prod_serv` decimal(10,2) DEFAULT NULL,
  `status_prod_serv` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `tb_prod_serv`
--

INSERT INTO `tb_prod_serv` (`cd_prod_serv`, `cd_classe_fiscal`, `cd_grupo`, `cdbarras_prod_serv`, `titulo_prod_serv`, `obs_prod_serv`, `tipo_prod_serv`, `preco_prod_serv`, `custo_prod_serv`, `status_prod_serv`) VALUES
(1, 1, 1, '789123123789', 'produto 1', 'primeira linha de produto', 1, 50.00, 25.00, 1),
(2, 0, 0, '789123123790', 'produto 2', 'primeira linha de produto', 0, 20.00, 10.00, 0),
(3, 1, 2, '789123123791', 'produto 3', 'Segunda linha de produto', 1, 40.00, 20.00, 1),
(4, 1, 2, '789123123792', 'produto 4', 'Segunda linha de produto', 1, 80.00, 40.00, 1),
(5, 0, 0, '789123123793', 'produto', 'Terceira linha de produto', 0, 90.00, 45.00, 0),
(6, 1, 3, '789123123794', 'produto 6', 'Terceira linha de Servico', 2, 30.00, 15.00, 1),
(7, NULL, 1, '123', 'Ttt', 'Ttt', NULL, 10.00, 5.00, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_seguranca`
--

CREATE TABLE `tb_seguranca` (
  `cd_seg` int(11) NOT NULL,
  `titulo_seg` varchar(200) DEFAULT NULL,
  `obs_seg` varchar(40) DEFAULT NULL,
  `cd_colab` varchar(40) DEFAULT NULL,
  `empresa` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_seguranca`
--

INSERT INTO `tb_seguranca` (`cd_seg`, `titulo_seg`, `obs_seg`, `cd_colab`, `empresa`) VALUES
(1, 'master', 'User Master', '1', '1');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_servico`
--

CREATE TABLE `tb_servico` (
  `cd_servico` int(11) NOT NULL,
  `cd_cliente` int(11) DEFAULT NULL,
  `titulo_servico` varchar(100) DEFAULT NULL,
  `obs_servico` varchar(1000) DEFAULT NULL,
  `prioridade_servico` varchar(10) DEFAULT NULL,
  `entrada_servico` varchar(40) DEFAULT NULL,
  `prazo_servico` varchar(40) DEFAULT NULL,
  `orcamento_servico` varchar(40) DEFAULT NULL,
  `vpag_servico` decimal(10,2) DEFAULT NULL,
  `status_servico` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `fl_ponto`
--
ALTER TABLE `fl_ponto`
  ADD PRIMARY KEY (`token_alter`),
  ADD KEY `fk_fl_ponto1` (`cdcolab_ponto`),
  ADD KEY `fk_fl_ponto2` (`cdempresa_ponto`);

--
-- Índices de tabela `rel_user`
--
ALTER TABLE `rel_user`
  ADD PRIMARY KEY (`token_alter`),
  ADD KEY `fk_rel_user1` (`cd_seg`),
  ADD KEY `fk_rel_user2` (`cd_colab`),
  ADD KEY `fk_rel_user3` (`cd_estilo`),
  ADD KEY `fk_rel_user4` (`cd_funcao`),
  ADD KEY `fk_rel_user5` (`cd_empresa`);

--
-- Índices de tabela `tb_atividade`
--
ALTER TABLE `tb_atividade`
  ADD PRIMARY KEY (`cd_atividade`),
  ADD KEY `fk_rel_colab1` (`cd_servico`),
  ADD KEY `fk_rel_colab2` (`cd_colab`);

--
-- Índices de tabela `tb_caixa`
--
ALTER TABLE `tb_caixa`
  ADD PRIMARY KEY (`cd_caixa`),
  ADD KEY `fk_tb_caixa1` (`cd_colab_abertura`),
  ADD KEY `fk_tb_caixa2` (`cd_colab_fechamento`);

--
-- Índices de tabela `tb_caixa_conferido`
--
ALTER TABLE `tb_caixa_conferido`
  ADD PRIMARY KEY (`cd_caixa_conferido`),
  ADD KEY `fk_tb_caixa_conferido1` (`cd_caixa_analitico`),
  ADD KEY `fk_tb_caixa_conferido2` (`cd_colab_conferencia`);

--
-- Índices de tabela `tb_caixa_dia_fiscal`
--
ALTER TABLE `tb_caixa_dia_fiscal`
  ADD PRIMARY KEY (`cd_caixa_dia_fiscal`);

--
-- Índices de tabela `tb_classe_fiscal`
--
ALTER TABLE `tb_classe_fiscal`
  ADD PRIMARY KEY (`cd_classe_fiscal`);

--
-- Índices de tabela `tb_cliente`
--
ALTER TABLE `tb_cliente`
  ADD PRIMARY KEY (`cd_cliente`);

--
-- Índices de tabela `tb_colab`
--
ALTER TABLE `tb_colab`
  ADD PRIMARY KEY (`cd_colab`);

--
-- Índices de tabela `tb_empresa`
--
ALTER TABLE `tb_empresa`
  ADD PRIMARY KEY (`cd_empresa`),
  ADD KEY `fk_rel_empresa1` (`cd_ceo`);

--
-- Índices de tabela `tb_estilo`
--
ALTER TABLE `tb_estilo`
  ADD PRIMARY KEY (`cd_estilo`);

--
-- Índices de tabela `tb_filial`
--
ALTER TABLE `tb_filial`
  ADD PRIMARY KEY (`cd_filial`),
  ADD KEY `fk_rel_filial1` (`cd_empresa`),
  ADD KEY `fk_rel_filial2` (`cd_responsavel`);

--
-- Índices de tabela `tb_funcao`
--
ALTER TABLE `tb_funcao`
  ADD PRIMARY KEY (`cd_funcao`);

--
-- Índices de tabela `tb_grupo`
--
ALTER TABLE `tb_grupo`
  ADD PRIMARY KEY (`cd_grupo`);

--
-- Índices de tabela `tb_movimento_financeiro`
--
ALTER TABLE `tb_movimento_financeiro`
  ADD PRIMARY KEY (`cd_movimento`),
  ADD KEY `fk_tb_movimento_financeiro1` (`cd_caixa_movimento`),
  ADD KEY `fk_tb_movimento_financeiro2` (`cd_colab_movimento`),
  ADD KEY `fk_tb_movimento_financeiro3` (`cd_cliente_movimento`),
  ADD KEY `fk_tb_movimento_financeiro4` (`cd_os_movimento`);

--
-- Índices de tabela `tb_orcamento_servico`
--
ALTER TABLE `tb_orcamento_servico`
  ADD PRIMARY KEY (`cd_orcamento`),
  ADD KEY `fk_rel_orcamento1` (`cd_servico`),
  ADD KEY `fk_rel_orcamento2` (`cd_cliente`);

--
-- Índices de tabela `tb_prod_serv`
--
ALTER TABLE `tb_prod_serv`
  ADD PRIMARY KEY (`cd_prod_serv`),
  ADD KEY `fk_tb_prod_serv1` (`cd_classe_fiscal`),
  ADD KEY `fk_tb_prod_serv2` (`cd_grupo`);

--
-- Índices de tabela `tb_seguranca`
--
ALTER TABLE `tb_seguranca`
  ADD PRIMARY KEY (`cd_seg`);

--
-- Índices de tabela `tb_servico`
--
ALTER TABLE `tb_servico`
  ADD PRIMARY KEY (`cd_servico`),
  ADD KEY `fk_rel_cliente` (`cd_cliente`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `fl_ponto`
--
ALTER TABLE `fl_ponto`
  MODIFY `token_alter` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `rel_user`
--
ALTER TABLE `rel_user`
  MODIFY `token_alter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `tb_atividade`
--
ALTER TABLE `tb_atividade`
  MODIFY `cd_atividade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT de tabela `tb_caixa`
--
ALTER TABLE `tb_caixa`
  MODIFY `cd_caixa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de tabela `tb_caixa_conferido`
--
ALTER TABLE `tb_caixa_conferido`
  MODIFY `cd_caixa_conferido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT de tabela `tb_caixa_dia_fiscal`
--
ALTER TABLE `tb_caixa_dia_fiscal`
  MODIFY `cd_caixa_dia_fiscal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de tabela `tb_classe_fiscal`
--
ALTER TABLE `tb_classe_fiscal`
  MODIFY `cd_classe_fiscal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tb_cliente`
--
ALTER TABLE `tb_cliente`
  MODIFY `cd_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `tb_colab`
--
ALTER TABLE `tb_colab`
  MODIFY `cd_colab` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `tb_empresa`
--
ALTER TABLE `tb_empresa`
  MODIFY `cd_empresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tb_estilo`
--
ALTER TABLE `tb_estilo`
  MODIFY `cd_estilo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tb_filial`
--
ALTER TABLE `tb_filial`
  MODIFY `cd_filial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tb_funcao`
--
ALTER TABLE `tb_funcao`
  MODIFY `cd_funcao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tb_grupo`
--
ALTER TABLE `tb_grupo`
  MODIFY `cd_grupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tb_movimento_financeiro`
--
ALTER TABLE `tb_movimento_financeiro`
  MODIFY `cd_movimento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT de tabela `tb_orcamento_servico`
--
ALTER TABLE `tb_orcamento_servico`
  MODIFY `cd_orcamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT de tabela `tb_prod_serv`
--
ALTER TABLE `tb_prod_serv`
  MODIFY `cd_prod_serv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `tb_seguranca`
--
ALTER TABLE `tb_seguranca`
  MODIFY `cd_seg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tb_servico`
--
ALTER TABLE `tb_servico`
  MODIFY `cd_servico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `fl_ponto`
--
ALTER TABLE `fl_ponto`
  ADD CONSTRAINT `fk_fl_ponto1` FOREIGN KEY (`cdcolab_ponto`) REFERENCES `tb_colab` (`cd_colab`),
  ADD CONSTRAINT `fk_fl_ponto2` FOREIGN KEY (`cdempresa_ponto`) REFERENCES `tb_empresa` (`cd_empresa`);

--
-- Restrições para tabelas `rel_user`
--
ALTER TABLE `rel_user`
  ADD CONSTRAINT `fk_rel_user1` FOREIGN KEY (`cd_seg`) REFERENCES `tb_seguranca` (`cd_seg`),
  ADD CONSTRAINT `fk_rel_user2` FOREIGN KEY (`cd_colab`) REFERENCES `tb_colab` (`cd_colab`),
  ADD CONSTRAINT `fk_rel_user3` FOREIGN KEY (`cd_estilo`) REFERENCES `tb_estilo` (`cd_estilo`),
  ADD CONSTRAINT `fk_rel_user4` FOREIGN KEY (`cd_funcao`) REFERENCES `tb_funcao` (`cd_funcao`),
  ADD CONSTRAINT `fk_rel_user5` FOREIGN KEY (`cd_empresa`) REFERENCES `tb_empresa` (`cd_empresa`);

--
-- Restrições para tabelas `tb_empresa`
--
ALTER TABLE `tb_empresa`
  ADD CONSTRAINT `fk_rel_empresa1` FOREIGN KEY (`cd_ceo`) REFERENCES `tb_colab` (`cd_colab`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
