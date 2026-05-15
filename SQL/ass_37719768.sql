-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 186.202.152.127
-- Generation Time: 07-Out-2025 às 11:24
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
-- Database: `ass_37719768`
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
(8, 1, 1, 5, 5, 1, 1),
(10, 1, 3, 1, 5, 1, 1);

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
(2, 2, 'A', 'Notebook esquentando e travando', 3, '2024-01-05T15:51', '2024-01-05T15:51'),
(3, 3, 'A', 'PC nÃ£o liga', 3, '2024-01-09T12:49', '2024-01-09T12:49'),
(4, 2, 'E', 'ServiÃ§o nÃ£o realizado', 3, '2024-01-09T11:18', '2024-01-09T11:18'),
(5, 3, 'C', 'ServiÃ§o realizado e entregue ao cliente', 3, '2024-01-09T12:12', '2024-01-10T11:32'),
(6, 3, 'D', 'Devolvido ao cliente', 3, '2024-01-10T11:32', '2024-01-10T11:32'),
(7, 4, 'A', 'Impressora diebold LPT', 3, '2024-01-10T14:38', '2024-01-10T14:38'),
(8, 5, 'A', 'Reparo kodak', 3, '2024-01-15T21:25', '2024-01-15T21:25'),
(9, 6, 'A', 'ALL IN ONE LG 22V24 ANALISE PLACA PRINCIPAL, POSSIVEL MOSFET OU RESET BIOS', 3, '2024-01-15T21:26', '2024-01-15T21:26'),
(10, 7, 'A', 'Gabinete padrÃ£o, analisar defeito', 3, '2024-01-15T21:27', '2024-01-15T21:27'),
(11, 5, 'C', 'ServiÃ§o realizado, tudo funcionando e testado', 3, '2024-01-15T20:23', '2024-01-15T20:23'),
(12, 5, 'D', 'Testado e entregue com sucesso', 3, '2024-01-15T20:24', '2024-01-15T20:24'),
(13, 7, 'C', 'Atividade finalizada com sucesso', 3, '2024-01-16T21:12', '2024-01-16T21:12'),
(14, 7, 'D', 'Devolvido,l e testado', 3, '2024-01-16T21:12', '2024-01-16T21:12'),
(15, 6, 'C', '', 3, '2024-01-16T21:12', '2024-01-16T21:13'),
(16, 6, 'E', 'NÃ£o reparado, possÃ­vel necessidade de regravar a duas EPROM necessarias', 3, '2024-01-16T21:14', '2024-01-16T21:14'),
(17, 4, 'C', 'ServiÃ§o finalizado', 3, '2024-01-22T08:54', '2024-01-22T08:54'),
(18, 4, 'D', 'Foi entregue ao cliente e aguardo apenas o pagamento da Ãºltima parcela devida', 3, '2024-01-22T08:55', '2024-01-22T08:55'),
(19, 8, 'A', 'InicializaÃ§Ã£o do windows corrompida', 1, '2024-02-15T11:10', '2024-02-15T11:10'),
(20, 8, 'C', 'ServiÃ§o finalizado com sucesso', 1, '2024-02-15T12:56', '2024-02-15T12:56'),
(21, 8, 'D', 'Entregue', 1, '2024-02-15T12:56', '2024-02-15T12:56'),
(22, 9, 'A', 'Nobreaks APC UPS 2200, TROCAR BATERIAS', 3, '2024-02-19T11:38', '2024-02-19T11:38'),
(23, 9, 'C', 'ServiÃ§o finalizado com sucesso', 3, '2024-02-23T13:31', '2024-02-23T13:31'),
(24, 9, 'D', 'Feito', 3, '2024-02-23T13:32', '2024-02-23T13:32'),
(25, 10, 'A', 'SN: 41885. NecessÃ¡ria esterilizaÃ§Ã£o da placa e retrabalho de solda', 3, '2024-03-26T12:20', '2024-03-26T12:20'),
(26, 11, 'A', 'SN: 13095. NecessÃ¡rio retrabalho de solda.', 3, '2024-03-26T12:24', '2024-03-26T12:24'),
(27, 10, 'C', '', 3, '2024-03-26T13:56', '2024-03-26T13:56'),
(28, 10, 'D', '', 3, '2024-03-26T13:56', '2024-03-26T13:56'),
(29, 11, 'C', '', 3, '2024-03-26T13:57', '2024-03-26T13:57'),
(30, 11, 'D', '', 3, '2024-03-26T13:57', '2024-03-26T13:57'),
(31, 12, 'A', 'Retrabalho em solda cabo par traÃ§ado adaptado. Ponta a reparar DB-9 Pinagem | 2=Branco-Laranja | 3=Laranja | 5=Azul  ', 1, '2024-03-27T11:54', '2024-03-27T11:54'),
(32, 13, 'A', 'Detector veicular DV-10. NECESSARIO REPARO EM PLACA DE FORÃ‡A ', 1, '2024-03-27T22:31', '2024-03-27T22:31'),
(33, 14, 'A', 'Detector veicular DV-10. NÃ£o liga, necessÃ¡rio reparo. Placa fonte danificada', 1, '2024-03-27T22:35', '2024-03-27T22:35'),
(34, 14, 'C', '', 1, '2024-03-28T12:14', '2024-03-28T12:14'),
(35, 14, 'D', '', 1, '2024-03-28T12:14', '2024-03-28T12:14'),
(36, 13, 'E', 'Equipamento deu pt', 1, '2024-04-25T23:09', '2024-04-25T23:09'),
(37, 12, 'C', 'ServiÃ§o realizado', 1, '2024-04-25T23:09', '2024-04-29T10:40'),
(38, 15, 'A', 'Retrabalho em placa NS: 17301', 1, '2024-04-29T11:26', '2024-04-29T11:26'),
(39, 15, 'E', 'Cliente alega nÃ£o ter funcionado', 1, '2024-04-29T10:38', '2024-04-29T10:38'),
(40, 15, 'C', 'ServiÃ§o finalizado, entregue e o cliente pagou', 1, '2024-04-29T10:39', '2024-04-29T10:52'),
(41, 12, 'E', 'Cliente alega nÃ£o ter funcionado', 1, '2024-04-29T10:40', '2024-04-29T10:40'),
(42, 12, 'C', 'ServiÃ§o pago', 1, '2024-04-29T10:48', '2024-04-29T10:50'),
(43, 15, 'D', 'Cli nte pagou', 1, '2024-04-29T10:53', '2024-04-29T10:53'),
(44, 12, 'D', 'Cliente pagou', 1, '2024-04-29T10:53', '2024-04-29T10:53'),
(45, 16, 'A', 'Teste', 1, '2024-05-01T14:51', '2024-05-01T14:51'),
(46, 16, 'E', 'Teste', 1, '2024-05-01T20:58', '2024-05-01T20:58'),
(47, 17, 'A', 'ManutenÃ§Ã£o para impressora M2020 Samsung. Imprimindo tudo preto', 3, '2024-06-10T09:45', '2024-06-10T09:45'),
(48, 17, 'C', 'ServiÃ§o foi finalizado dia 9/6/2024', 3, '2024-06-10T09:24', '2024-06-10T09:24'),
(49, 17, 'D', 'ServiÃ§o realizado no dia 9/6/2024', 3, '2024-06-10T09:26', '2024-06-10T09:26'),
(50, 18, 'A', 'CÃ¢meras e mais', 1, '2024-07-23T20:32', '2024-07-23T20:32'),
(51, 19, 'A', 'Configurar cÃ¢meras e alterar cadastro de produtos', 1, '2024-07-23T20:39', '2024-07-23T20:39'),
(52, 20, 'A', 'Configurar cÃ¢meras', 1, '2024-07-23T20:46', '2024-07-23T20:46'),
(53, 20, 'C', 'Reiniciei o moldem e as cÃ¢meras voltaram a se comunicar com o servidor', 1, '2024-07-23T20:48', '2024-07-23T20:48'),
(54, 18, 'C', 'Foi feita abertura do chamado com a TESA  e alteraÃ§Ã£o do cadastro e preÃ§os de produtos', 1, '2024-07-23T20:49', '2024-07-23T20:49'),
(55, 19, 'C', 'Finalizado', 1, '2024-07-23T20:50', '2024-07-23T20:50'),
(56, 20, 'D', 'Feito,revisado', 1, '2024-07-23T20:51', '2024-07-23T20:51'),
(57, 18, 'D', 'Feito,revisado', 1, '2024-07-23T20:52', '2024-07-23T20:52'),
(58, 19, 'D', 'ServiÃ§o realizado e pago', 1, '2024-07-26T10:47', '2024-07-26T10:47'),
(59, 21, 'A', 'ManutenÃ§Ã£o de mÃ¡quina Kodak', 1, '2024-08-31T22:46', '2024-08-31T22:46'),
(60, 21, 'C', 'Atendimento finalizado sem atrasos e sem acionamento de garantia', 1, '2024-09-25T10:29', '2024-09-25T10:29'),
(61, 21, 'D', 'Feito', 1, '2024-09-25T10:30', '2024-09-25T10:30'),
(62, 22, 'A', 'InstalaÃ§Ã£o de impressora', 1, '2024-09-29T12:22', '2024-09-29T12:22'),
(63, 22, 'C', 'Atendimento finalizado com sucesso', 1, '2024-09-29T13:10', '2024-09-29T13:10'),
(64, 22, 'D', '', 1, '2024-09-29T13:10', '2024-09-29T13:10'),
(65, 23, 'A', 'PC APAGOU', 1, '2024-09-29T13:19', '2024-09-29T13:19'),
(66, 23, 'C', 'Feitas atividades e entregue', 1, '2024-09-29T13:23', '2024-10-08T12:07'),
(67, 23, 'D', '', 1, '2024-10-08T12:08', '2024-10-08T12:08'),
(68, 24, 'A', 'Deixar computador rapido', 1, '2024-10-08T12:09', '2024-10-08T12:09'),
(69, 25, 'A', 'Instalar cÃ¢meras MIBO', 1, '2024-10-10T11:37', '2024-10-10T11:37'),
(70, 24, 'C', 'Finalizado e entregue com sucesso', 1, '2024-10-10T11:40', '2024-10-10T11:40'),
(71, 24, 'D', '', 1, '2024-10-10T11:41', '2024-10-10T11:41'),
(72, 26, 'A', 'Reparo Kodak, sensor tampa papel', 1, '2024-10-10T14:14', '2024-10-10T14:14'),
(73, 26, 'C', 'Foi colada haste e acionador do sensor da tampa trazeira', 1, '2024-10-10T14:16', '2024-10-10T14:16'),
(74, 26, 'D', '', 1, '2024-10-10T15:18', '2024-10-10T15:18'),
(75, 25, 'C', '', 1, '2024-10-13T14:55', '2024-10-13T14:57'),
(76, 25, 'D', 'O serviÃ§o foi realizado e entregue funcionando', 1, '2024-10-13T14:57', '2024-10-13T14:57'),
(77, 27, 'A', 'PC LENTO', 1, '2024-11-13T14:40', '2024-11-13T14:40'),
(78, 28, 'A', 'Hastes quebradas/tela solta', 1, '2024-11-13T14:44', '2024-11-13T14:44'),
(79, 29, 'A', 'CarcaÃ§a danificada', 1, '2024-11-13T15:50', '2024-11-13T15:50'),
(80, 29, 'C', 'ServiÃ§o finalizado com sucesso', 1, '2024-11-13T15:57', '2024-11-13T15:57'),
(81, 28, 'C', 'Finalizado com sucesso', 1, '2024-11-13T15:57', '2024-11-13T15:57'),
(82, 28, 'D', 'JÃ¡ foi entregue ao cliente', 1, '2024-11-13T15:57', '2024-11-13T15:57'),
(83, 27, 'C', 'ServiÃ§o finalizado com sucesso', 1, '2024-11-18T11:32', '2024-11-18T11:32'),
(84, 27, 'D', 'Entregue para a cliente', 1, '2024-11-18T15:16', '2024-11-18T15:16'),
(85, 29, 'D', 'Devolvido em mÃ£os na estaÃ§Ã£o jardim oceÃ¢nico para a Marcia', 1, '2024-11-26T10:09', '2024-11-26T10:09'),
(86, 30, 'A', 'Instalar impressora', 1, '2024-12-05T19:51', '2024-12-05T19:51'),
(87, 30, 'C', '', 1, '2024-12-05T21:10', '2024-12-05T21:10'),
(88, 31, 'A', 'Alterar preÃ§os, verificar PDV', 1, '2024-12-06T23:30', '2024-12-06T23:30'),
(89, 31, 'C', '', 1, '2024-12-06T23:31', '2025-01-03T10:29'),
(90, 30, 'D', 'Finalizado', 1, '2024-12-06T23:33', '2024-12-06T23:33'),
(91, 32, 'A', '21983250275', 1, '2025-01-03T09:39', '2025-01-03T09:39'),
(92, 32, 'C', '', 1, '2025-01-03T10:27', '2025-01-03T10:27'),
(93, 32, 'D', '', 1, '2025-01-03T10:27', '2025-01-03T10:27'),
(94, 33, 'A', 'Sem internet', 1, '2025-01-03T10:30', '2025-01-03T10:30'),
(95, 33, 'C', '', 1, '2025-01-03T10:34', '2025-01-03T10:34'),
(96, 33, 'D', '', 1, '2025-01-03T10:35', '2025-01-03T10:35'),
(97, 34, 'A', 'Corda quebrou', 1, '2025-01-06T18:42', '2025-01-06T18:42'),
(98, 34, 'C', '', 1, '2025-01-06T18:47', '2025-01-06T18:47'),
(99, 34, 'E', '', 1, '2025-01-07T13:16', '2025-01-07T13:16'),
(100, 31, 'D', '', 1, '2025-01-13T15:53', '2025-01-13T15:53'),
(101, 35, 'A', 'Instalar impressora compartilhada', 1, '2025-01-13T15:53', '2025-01-13T15:53'),
(102, 36, 'A', 'ServiÃ§os diversos', 1, '2025-01-13T15:55', '2025-01-13T15:55'),
(103, 36, 'C', 'ServiÃ§o finalizado dentro do prazo', 1, '2025-01-13T20:00', '2025-01-30T15:55'),
(104, 37, 'A', 'Teste', 1, '2025-01-21T09:07', '2025-01-21T09:07'),
(105, 37, 'E', '', 1, '2025-01-21T12:06', '2025-01-21T12:06'),
(106, 38, 'A', 'Teste', 1, '2025-01-21T12:06', '2025-01-21T12:06'),
(107, 38, 'E', '', 1, '2025-01-21T12:07', '2025-01-21T12:07'),
(108, 36, 'D', '', 1, '2025-01-31T01:35', '2025-01-31T01:35'),
(109, 38, 'C', '', 1, '2025-01-31T01:35', '2025-01-31T01:36'),
(110, 38, 'D', '', 1, '2025-01-31T01:36', '2025-01-31T01:36'),
(111, 38, 'E', '', 1, '2025-01-31T01:39', '2025-01-31T01:39'),
(112, 35, 'C', '', 1, '2025-01-31T12:44', '2025-01-31T12:44'),
(113, 35, 'D', '', 1, '2025-01-31T12:45', '2025-01-31T12:45'),
(114, 39, 'A', 'Check-up geral', 1, '2025-03-01T11:11', '2025-03-01T11:11'),
(115, 39, 'C', 'Feita correÃ§Ã£o do windows no caixa 2, feita configuraÃ§Ã£o no roteador para cÃ¢meras mibo, feita limpeza de cabeÃ§a de impressÃ£o no caixa 1, cÃ¢meras isic com fonte de cÃ¢meras queimada. NecessÃ¡ria troca de fonte de cÃ¢meras isic', 1, '2025-03-01T11:51', '2025-03-01T11:51'),
(116, 39, 'D', 'Atividade realizada', 1, '2025-03-12T18:29', '2025-03-12T18:29'),
(117, 40, 'A', 'Recondicionamento de computador', 1, '2025-03-12T18:33', '2025-03-12T18:33'),
(118, 40, 'C', '', 1, '2025-03-12T18:40', '2025-03-12T18:40'),
(119, 40, 'D', '', 1, '2025-03-12T18:40', '2025-03-12T18:40'),
(120, 41, 'A', 'Instalar virtual box com imagem de backup institucional', 1, '2025-03-14T14:11', '2025-03-14T14:11'),
(121, 41, 'C', '', 1, '2025-03-14T14:19', '2025-03-14T14:19'),
(122, 41, 'D', '', 1, '2025-03-14T14:22', '2025-03-14T14:22'),
(123, 42, 'A', 'Cameras', 1, '2025-04-03T20:22', '2025-04-03T20:22'),
(124, 42, 'C', '', 1, '2025-04-05T22:34', '2025-04-05T22:34'),
(125, 42, 'D', '', 1, '2025-04-05T22:34', '2025-04-05T22:34'),
(126, 43, 'A', 'ManutenÃ§Ã£o preventiva/ corretiva avulsa', 1, '2025-04-09T12:52', '2025-04-09T12:52'),
(127, 44, 'A', 'CONFIGURAR AMBIENTE VIRTUAL (remotamente)', 1, '2025-04-14T14:56', '2025-04-14T14:56'),
(128, 45, 'A', 'Servico teste', 1, '2025-04-22T14:24', '2025-04-22T14:24'),
(129, 45, 'C', 'Finalizado na ocasia', 1, '2025-04-22T14:26', '2025-04-22T14:26'),
(130, 45, 'D', 'Entregue e revisado', 1, '2025-04-22T14:27', '2025-04-22T14:27'),
(131, 44, 'C', '', 1, '2025-05-05T17:07', '2025-05-05T17:07'),
(132, 44, 'D', '', 1, '2025-05-05T17:07', '2025-05-05T17:07'),
(133, 43, 'C', '', 1, '2025-05-05T17:07', '2025-05-05T17:07'),
(134, 43, 'D', '', 1, '2025-05-05T17:08', '2025-05-05T17:08');

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
  `status_caixa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_caixa`
--

INSERT INTO `tb_caixa` (`cd_caixa`, `dt_abertura`, `dt_fechamento`, `cd_colab_abertura`, `cd_colab_fechamento`, `saldo_abertura`, `total_movimento`, `saldo_fechamento`, `diferenca_caixa`, `fpag_dinheiro`, `fpag_debito`, `fpag_credito`, `fpag_pix`, `fpag_cofre`, `fpag_boleto`, `status_caixa`) VALUES
(1, '2024-01-05 14:48:00', '2024-01-05 14:59:00', 3, 3, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1),
(2, '2024-01-09 12:02:00', '2024-01-10 12:34:00', 3, 3, 0.00, 422.90, 422.90, 0.00, 0.00, 0.00, 0.00, 422.90, 0.00, NULL, 1),
(3, '2024-01-11 13:06:00', '2024-01-15 20:24:00', 3, 3, 0.00, 284.31, 284.31, 0.00, 0.00, 0.00, 0.00, 750.00, NULL, NULL, 1),
(4, '2024-01-15 21:23:00', '2024-01-16 22:06:00', 3, 3, 0.00, 150.00, 150.00, 0.00, 0.00, 0.00, 0.00, 150.00, 0.00, NULL, 1),
(5, '2024-01-16 22:06:00', '2024-01-22 09:54:00', 3, 3, 0.00, 120.00, 120.00, 0.00, 120.00, 0.00, 0.00, 0.00, NULL, NULL, 1),
(6, '2024-01-16 22:06:00', '2024-01-16 22:06:00', 3, 3, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1),
(7, '2024-01-25 18:24:00', '2024-01-25 18:27:00', 3, 3, 0.00, 238.00, 238.00, 0.00, 0.00, 0.00, 0.00, 238.00, NULL, NULL, 1),
(8, '2024-02-15 10:09:00', '2024-02-15 14:00:00', 1, 1, 0.00, 120.00, 120.00, 0.00, 0.00, 0.00, 0.00, 120.00, NULL, NULL, 1),
(9, '2024-02-19 10:37:00', '2024-02-23 14:31:00', 3, 3, 0.00, 526.84, 526.84, 0.00, 466.84, 0.00, 0.00, 60.00, NULL, NULL, 1),
(10, '2024-03-26 14:56:00', '2024-03-26 18:32:00', 3, 3, 0.00, 180.00, 180.00, 0.00, 180.00, 0.00, 0.00, 0.00, NULL, NULL, 1),
(11, '2024-03-28 13:13:00', '2024-03-28 18:34:00', 3, 3, 0.00, 180.00, 180.00, 0.00, 180.00, 0.00, 0.00, 0.00, NULL, NULL, 1),
(12, '2024-04-29 11:50:00', '2024-05-01 14:51:00', 1, 1, 0.00, 90.00, 90.00, 0.00, 90.00, 0.00, 0.00, 0.00, NULL, NULL, 1),
(13, '2024-05-10 12:00:00', '2024-05-10 12:00:00', 1, 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1),
(14, '2024-05-18 15:29:00', '2024-05-28 19:19:00', 1, 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1),
(15, '2024-06-15 16:33:00', '2024-07-23 21:30:00', 1, 1, 0.00, 150.00, 150.00, 0.00, 0.00, 0.00, 0.00, 150.00, NULL, NULL, 1),
(16, '2024-07-23 20:38:00', '2024-07-24 00:34:00', 1, 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1),
(17, '2024-07-23 20:38:00', '2024-07-24 00:33:00', 1, 1, 0.00, 300.00, 300.00, 0.00, 150.00, 0.00, 0.00, 150.00, NULL, NULL, 1),
(18, '2024-07-26 10:47:00', '2024-08-31 23:45:00', 1, 1, 0.00, 150.00, 150.00, 0.00, 0.00, 0.00, 0.00, 150.00, NULL, NULL, 1),
(19, '2024-08-31 22:45:00', '2024-09-09 19:08:00', 1, 1, 0.00, 150.00, 150.00, 0.00, 150.00, 0.00, 0.00, 0.00, NULL, NULL, 1),
(20, '2024-09-09 18:08:00', '2024-09-25 11:29:00', 1, 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1),
(21, '2024-09-27 15:07:00', '2024-09-29 13:21:00', 1, 1, 10.00, 0.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1),
(22, '2024-09-29 12:26:00', '2024-09-29 14:09:00', 1, 1, 0.00, 899.81, 899.81, 0.00, 0.00, 0.00, 899.81, 0.00, 0.00, NULL, 1),
(23, '2024-09-29 13:21:00', '2024-10-02 08:53:00', 1, 1, 0.00, 130.00, 130.00, 0.00, 10.00, 0.00, 0.00, 120.00, NULL, NULL, 1),
(24, '2024-10-08 12:07:00', '2024-10-10 12:36:00', 1, 1, 0.00, 120.00, 120.00, 0.00, 120.00, 0.00, 0.00, 0.00, NULL, NULL, 1),
(25, '2024-10-10 11:36:00', '2024-10-14 23:58:00', 1, 1, 0.00, 518.00, 518.00, 0.00, 120.00, 0.00, 0.00, 398.00, NULL, NULL, 1),
(26, '2024-10-26 09:36:00', '2024-10-26 10:38:00', 1, 1, 0.00, 195.00, 195.00, 0.00, 0.00, 0.00, 0.00, 195.00, 0.00, NULL, 1),
(27, '2024-11-13 14:39:00', '2024-11-14 13:15:00', 1, 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1),
(28, '2024-11-18 11:30:00', '2024-11-19 20:54:00', 1, 1, 0.00, 519.00, 519.00, 0.00, 0.00, 0.00, 0.00, 519.00, 0.00, NULL, 1),
(29, '2024-11-26 10:06:00', '2024-11-26 18:21:00', 1, 1, 0.00, 356.00, 356.00, 0.00, 0.00, 0.00, 0.00, 356.00, NULL, NULL, 1),
(30, '2024-12-05 19:50:00', '2024-12-05 22:52:00', 1, 1, 0.00, 180.00, 180.00, 0.00, 0.00, 0.00, 0.00, 180.00, NULL, NULL, 1),
(31, '2024-12-06 23:31:00', '2024-12-07 00:33:00', 1, 1, 0.00, 150.00, 150.00, 0.00, 0.00, 0.00, 0.00, 150.00, NULL, NULL, 1),
(32, '2024-12-10 12:18:00', '2024-12-21 10:05:00', 1, 1, 0.00, 50.00, 50.00, 0.00, 0.00, 0.00, 0.00, 50.00, NULL, NULL, 1),
(33, '2025-01-03 09:44:00', '2025-01-06 19:42:00', 1, 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1),
(34, '2025-01-06 18:44:00', '2025-01-08 09:57:00', 1, 1, 0.00, 120.00, 120.00, 0.00, 0.00, 0.00, 0.00, 120.00, NULL, NULL, 1),
(35, '2025-01-10 22:47:00', '2025-01-13 16:52:00', 1, 1, 0.00, 50.00, 50.00, 0.00, 0.00, 0.00, 0.00, 50.00, NULL, NULL, 1),
(36, '2025-01-13 19:59:00', '2025-01-21 10:07:00', 1, 1, 0.00, 100.00, 100.00, 0.00, 0.00, 0.00, 0.00, 100.00, NULL, NULL, 1),
(37, '2025-01-21 09:07:00', '2025-01-30 16:55:00', 1, 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1),
(38, '2025-01-31 12:43:00', '2025-02-03 10:13:00', 1, 1, 0.00, 350.00, 350.00, 0.00, 0.00, 0.00, 0.00, 350.00, NULL, NULL, 1),
(39, '2025-03-01 11:11:00', '2025-03-12 19:37:00', 1, 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1),
(40, '2025-03-17 13:13:00', '2025-03-24 22:27:00', 1, 1, 0.00, 120.00, 120.00, 0.00, 0.00, 0.00, 0.00, 120.00, NULL, NULL, 1),
(41, '2025-04-03 20:19:00', '2025-04-05 23:31:00', 1, 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1),
(42, '2025-04-09 12:52:00', '2025-04-11 13:44:00', 1, 1, 0.00, 425.00, 425.00, 0.00, 0.00, 0.00, 0.00, 425.00, NULL, NULL, 1),
(43, '2025-04-11 12:46:00', '2025-04-14 15:56:00', 1, 1, 0.00, 120.00, 120.00, 0.00, 0.00, 0.00, 0.00, 120.00, NULL, NULL, 1),
(44, '2025-04-22 14:23:00', '2025-05-05 18:05:00', 1, 1, 50.00, 405.00, 455.00, 0.00, 155.00, 0.00, 0.00, 250.00, NULL, NULL, 1),
(45, '2025-05-05 17:06:00', NULL, 1, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);

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

--
-- Extraindo dados da tabela `tb_caixa_conferido`
--

INSERT INTO `tb_caixa_conferido` (`cd_caixa_conferido`, `cd_caixa_analitico`, `dt_conferencia`, `cd_colab_conferencia`, `obs_conferencia`, `saldo_abertura_conferido`, `saldo_fechamento_conferido`, `diferenca_caixa_conferido`, `saldo_movimento_conferido`, `fpag_dinheiro_conferido`, `fpag_debito_conferido`, `fpag_credito_conferido`, `fpag_pix_conferido`, `fpag_cofre_conferido`, `fpag_boleto_conferido`) VALUES
(1, 1, '2024-01-05 14:59:00', 3, 'Fechamento de Caixa (Normal)', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(2, 2, '2024-01-10 12:34:00', 3, 'Fechamento de Caixa (Auditoria do dia anterior)', 0.00, 422.90, 0.00, 422.90, 0.00, 0.00, 0.00, 422.90, 0.00, NULL),
(3, 3, '2024-01-15 20:24:00', 3, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 0.00, 284.31, 0.00, 284.31, 0.00, 0.00, 0.00, 750.00, NULL, NULL),
(4, 4, '2024-01-16 22:06:00', 3, 'Fechamento de Caixa (Auditoria do dia anterior)', 0.00, 150.00, 0.00, 150.00, 0.00, 0.00, 0.00, 150.00, 0.00, NULL),
(5, 6, '2024-01-16 22:06:00', 3, 'Fechamento de Caixa (Normal)', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(6, 5, '2024-01-22 09:54:00', 3, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 0.00, 120.00, 0.00, 120.00, 120.00, 0.00, 0.00, 0.00, NULL, NULL),
(7, 7, '2024-01-25 18:27:00', 3, 'Fechamento de Caixa (Normal)', 0.00, 238.00, 0.00, 238.00, 0.00, 0.00, 0.00, 238.00, 0.00, NULL),
(8, 8, '2024-02-15 14:00:00', 1, 'Fechamento de Caixa (Normal)', 0.00, 120.00, 0.00, 120.00, 0.00, 0.00, 0.00, 120.00, 0.00, NULL),
(9, 9, '2024-02-23 14:31:00', 3, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 0.00, 526.84, 0.00, 526.84, 466.84, 0.00, 0.00, 60.00, NULL, NULL),
(10, 10, '2024-03-26 18:32:00', 3, 'Fechamento de Caixa (Normal)', 0.00, 180.00, 0.00, 180.00, 180.00, 0.00, 0.00, 0.00, 0.00, NULL),
(11, 11, '2024-03-28 18:34:00', 3, 'Fechamento de Caixa (Normal)', 0.00, 180.00, 0.00, 180.00, 180.00, 0.00, 0.00, 0.00, 0.00, NULL),
(12, 12, '2024-05-01 14:51:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 0.00, 90.00, 0.00, 90.00, 90.00, 0.00, 0.00, 0.00, NULL, NULL),
(13, 13, '2024-05-10 12:00:00', 1, 'Fechamento de Caixa (Normal)', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(14, 14, '2024-05-28 19:19:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(15, 15, '2024-07-23 21:30:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 0.00, 150.00, 0.00, 150.00, 0.00, 0.00, 0.00, 150.00, NULL, NULL),
(16, 17, '2024-07-24 00:33:00', 1, 'Fechamento de Caixa (Normal)', 0.00, 300.00, 0.00, 300.00, 150.00, 0.00, 0.00, 150.00, 0.00, NULL),
(17, 16, '2024-07-24 00:34:00', 1, 'Fechamento de Caixa (Normal)', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(18, 18, '2024-08-31 23:45:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 0.00, 150.00, 0.00, 150.00, 0.00, 0.00, 0.00, 150.00, NULL, NULL),
(19, 19, '2024-09-09 19:08:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 0.00, 150.00, 0.00, 150.00, 150.00, 0.00, 0.00, 0.00, NULL, NULL),
(20, 20, '2024-09-25 11:29:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(21, 21, '2024-09-29 13:21:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 10.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(22, 22, '2024-09-29 14:09:00', 1, 'Fechamento de Caixa (Normal)', 0.00, 899.81, 0.00, 899.81, 0.00, 0.00, 899.81, 0.00, 0.00, NULL),
(23, 23, '2024-10-02 08:53:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 0.00, 130.00, 0.00, 130.00, 10.00, 0.00, 0.00, 120.00, NULL, NULL),
(24, 24, '2024-10-10 12:36:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 0.00, 120.00, 0.00, 120.00, 120.00, 0.00, 0.00, 0.00, NULL, NULL),
(25, 25, '2024-10-14 23:58:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 0.00, 518.00, 0.00, 518.00, 120.00, 0.00, 0.00, 398.00, NULL, NULL),
(26, 26, '2024-10-26 10:38:00', 1, 'Fechamento de Caixa (Normal)', 0.00, 195.00, 0.00, 195.00, 0.00, 0.00, 0.00, 195.00, 0.00, NULL),
(27, 27, '2024-11-14 13:15:00', 1, 'Fechamento de Caixa (Auditoria do dia anterior)', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(28, 28, '2024-11-19 20:54:00', 1, 'Fechamento de Caixa (Auditoria do dia anterior)', 0.00, 519.00, 0.00, 519.00, 0.00, 0.00, 0.00, 519.00, 0.00, NULL),
(29, 29, '2024-11-26 18:21:00', 1, 'Fechamento de Caixa (Normal)', 0.00, 356.00, 0.00, 356.00, 0.00, 0.00, 0.00, 356.00, 0.00, NULL),
(30, 30, '2024-12-05 22:52:00', 1, 'Fechamento de Caixa (Normal)', 0.00, 180.00, 0.00, 180.00, 0.00, 0.00, 0.00, 180.00, 0.00, NULL),
(31, 31, '2024-12-07 00:33:00', 1, 'Fechamento de Caixa (Normal)', 0.00, 150.00, 0.00, 150.00, 0.00, 0.00, 0.00, 150.00, 0.00, NULL),
(32, 32, '2024-12-21 10:05:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 0.00, 50.00, 0.00, 50.00, 0.00, 0.00, 0.00, 50.00, NULL, NULL),
(33, 33, '2025-01-06 19:42:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(34, 34, '2025-01-08 09:57:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 0.00, 120.00, 0.00, 120.00, 0.00, 0.00, 0.00, 120.00, NULL, NULL),
(35, 35, '2025-01-13 16:52:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 0.00, 50.00, 0.00, 50.00, 0.00, 0.00, 0.00, 50.00, NULL, NULL),
(36, 36, '2025-01-21 10:07:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 0.00, 100.00, 0.00, 100.00, 0.00, 0.00, 0.00, 100.00, NULL, NULL),
(37, 37, '2025-01-30 16:55:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(38, 38, '2025-02-03 10:13:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 0.00, 350.00, 0.00, 350.00, 0.00, 0.00, 0.00, 350.00, NULL, NULL),
(39, 39, '2025-03-12 19:37:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(40, 40, '2025-03-24 22:27:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 0.00, 120.00, 0.00, 120.00, 0.00, 0.00, 0.00, 120.00, NULL, NULL),
(41, 41, '2025-04-05 23:31:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(42, 42, '2025-04-11 13:44:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 0.00, 425.00, 0.00, 425.00, 0.00, 0.00, 0.00, 425.00, NULL, NULL),
(43, 43, '2025-04-14 15:56:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 0.00, 120.00, 0.00, 120.00, 0.00, 0.00, 0.00, 120.00, NULL, NULL),
(44, 44, '2025-05-05 18:05:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 50.00, 455.00, 0.00, 405.00, 155.00, 0.00, 0.00, 250.00, NULL, NULL);

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
(1, '2024-01-05 14:48:00', '2024-01-05 14:59:00', 0.00, 0.00, 0.00, 0.00, 0.00, 2),
(2, '2024-01-09 12:02:00', '2024-01-10 12:34:00', 422.90, 422.90, 422.90, 422.90, 0.00, 2),
(3, '2024-01-11 13:06:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(4, '2024-01-15 21:23:00', '2024-01-16 22:06:00', 150.00, 150.00, 150.00, 150.00, 0.00, 2),
(5, '2024-01-16 22:06:00', NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 1),
(6, '2024-01-25 18:24:00', '2024-01-25 18:27:00', 238.00, 238.00, 238.00, 238.00, 0.00, 2),
(7, '2024-02-15 10:09:00', '2024-02-15 14:00:00', 120.00, 120.00, 120.00, 120.00, 0.00, 2),
(8, '2024-02-19 10:37:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(9, '2024-03-26 14:56:00', '2024-03-26 18:32:00', 180.00, 180.00, 180.00, 180.00, 0.00, 2),
(10, '2024-03-28 13:13:00', '2024-03-28 18:34:00', 180.00, 180.00, 180.00, 180.00, 0.00, 2),
(11, '2024-04-29 11:50:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(12, '2024-05-10 12:00:00', NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 1),
(13, '2024-05-18 15:29:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(14, '2024-06-15 16:33:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(15, '2024-07-23 20:38:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(16, '2024-07-23 20:38:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(17, '2024-07-23 20:38:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(18, '2024-07-26 10:47:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(19, '2024-08-31 22:45:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(20, '2024-09-09 18:08:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(21, '2024-09-27 15:07:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(22, '2024-09-29 12:26:00', NULL, 899.81, 899.81, 899.81, 899.81, 0.00, 1),
(23, '2024-10-08 12:07:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(24, '2024-10-10 11:36:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(25, '2024-10-26 09:36:00', NULL, 195.00, 195.00, 195.00, 195.00, 0.00, 1),
(26, '2024-11-13 14:39:00', '2024-11-14 13:15:00', 0.00, 0.00, 0.00, 0.00, 0.00, 2),
(27, '2024-11-18 11:30:00', '2024-11-19 20:54:00', 519.00, 519.00, 519.00, 519.00, 0.00, 2),
(28, '2024-11-26 10:06:00', '2024-11-26 18:21:00', 356.00, 356.00, 356.00, 356.00, 0.00, 2),
(29, '2024-12-05 19:50:00', '2024-12-05 22:52:00', 180.00, 180.00, 180.00, 180.00, 0.00, 2),
(30, '2024-12-06 23:31:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(31, '2024-12-06 23:31:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(32, '2024-12-10 12:18:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(33, '2025-01-03 09:44:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(34, '2025-01-06 18:44:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(35, '2025-01-10 22:47:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(36, '2025-01-13 19:59:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(37, '2025-01-21 09:07:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(38, '2025-01-31 12:43:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(39, '2025-03-01 11:11:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(40, '2025-03-17 13:13:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(41, '2025-04-03 20:19:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(42, '2025-04-09 12:52:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(43, '2025-04-11 12:46:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(44, '2025-04-22 14:23:00', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(45, '2025-05-05 17:06:00', NULL, NULL, NULL, NULL, NULL, NULL, 0);

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
(1, 'Gabriel', 'Amorim', NULL, NULL, NULL, NULL, '5521965543094', NULL, NULL, NULL, NULL),
(2, 'Josue', 'Freitas', NULL, NULL, NULL, NULL, '5521983250275', NULL, NULL, NULL, NULL),
(3, 'Rodrigo', 'Demenech', NULL, NULL, NULL, NULL, '5521964894374', NULL, NULL, NULL, NULL),
(4, 'Sergio', '', '', NULL, NULL, NULL, '5521999861909', NULL, '', NULL, NULL),
(5, 'Uilian', 'Jardim', NULL, NULL, NULL, NULL, '5521965775019', NULL, NULL, NULL, NULL),
(6, 'Alan', 'Lemos', NULL, NULL, NULL, NULL, '5521964080423', NULL, NULL, NULL, NULL),
(7, 'Alessandra', '', NULL, NULL, NULL, NULL, '5521964244181', NULL, NULL, NULL, NULL),
(8, 'Anderson', '', NULL, NULL, NULL, NULL, '5521996131852', NULL, NULL, NULL, NULL),
(9, 'Top 13 - Marcia', '', NULL, NULL, NULL, NULL, '5521993491499', NULL, NULL, NULL, NULL),
(10, 'Alecsandro', '', NULL, NULL, NULL, NULL, '5521988850047', NULL, NULL, NULL, NULL),
(11, 'Paulo', 'Coelho', NULL, NULL, NULL, NULL, '5521982935408', NULL, NULL, NULL, NULL),
(12, 'Alexandre', 'Emanuel', NULL, NULL, NULL, NULL, '5521976052325', NULL, NULL, NULL, NULL),
(13, 'Diego', '', NULL, NULL, NULL, NULL, '5521994193770', NULL, NULL, NULL, NULL),
(14, 'Felipe', 'Duarte', '', NULL, NULL, NULL, '5521974843550', NULL, '', NULL, NULL),
(15, 'Henrique', '', NULL, NULL, NULL, NULL, '5511999533341', NULL, NULL, NULL, NULL),
(16, 'Cliente novo', 'Teste', NULL, NULL, NULL, NULL, '5521965543096', NULL, NULL, NULL, NULL);

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
(1, 'Gabriel', 'Gomes Amorim', '1', NULL, NULL, NULL, '', NULL, 'suporte@ativisoft.com.br', NULL, 'asd,123'),
(3, 'Gabriel', 'Amorim', NULL, NULL, NULL, 'Ggg', '21965543094', NULL, 'amorimgg7@gmail.com', NULL, 'asd,123');

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
(1, 'AMORIMFOR TEC', 'AMORIMFOR TEC', '37719768000120', 1, 'AUTH');

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
  `c_body` varchar(200) DEFAULT NULL,
  `c_card` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_estilo`
--

INSERT INTO `tb_estilo` (`cd_estilo`, `titulo_estilo`, `t_sidebar`, `c_sidebar`, `t_navbar`, `c_navbar`, `t_font`, `c_font`, `c_body`, `c_card`) VALUES
(1, 'Light-blue', 'padrão', 'style=\"background-color: #a7dbfb; color: #044167;\"', 'padrão', 'style=\"background-color: #23a5f6;\"', 'padrão', 'padrão', NULL, ''),
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
(1, 1, 1, 'AMORIMFOR TEC', 'AMORIMFOR TEC', '37719768000120', '...', 'Prezado cliente, o prazo para garantia do serviço prestado é de 30 dias.');

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

--
-- Extraindo dados da tabela `tb_grupo`
--

INSERT INTO `tb_grupo` (`cd_grupo`, `titulo_grupo`, `obs_grupo`) VALUES
(1, 'Geral', '');

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
  `cd_venda_movimento` int(11) DEFAULT NULL,
  `fpag_movimento` varchar(999) DEFAULT NULL,
  `valor_movimento` decimal(10,2) DEFAULT NULL,
  `data_movimento` datetime DEFAULT NULL,
  `obs_movimento` varchar(999) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_movimento_financeiro`
--

INSERT INTO `tb_movimento_financeiro` (`cd_movimento`, `cd_caixa_movimento`, `cd_colab_movimento`, `cd_cliente_movimento`, `tipo_movimento`, `cd_os_movimento`, `cd_venda_movimento`, `fpag_movimento`, `valor_movimento`, `data_movimento`, `obs_movimento`) VALUES
(3, 2, 3, 2, 1, 3, NULL, 'pix', 250.00, '2024-01-09 12:31:00', 'PAGAMENTO DA OS: 3'),
(4, 2, 3, 2, 1, 3, NULL, 'pix', 172.90, '2024-01-10 12:31:00', 'PAGAMENTO DA OS: 3'),
(5, 3, 3, 2, 1, 4, NULL, 'pix', 300.00, '2024-01-11 13:06:00', 'PAGAMENTO DA OS: 4'),
(6, 3, 3, 2, 1, 4, NULL, 'pix', 450.00, '2024-01-11 13:07:00', 'PAGAMENTO DA OS: 4'),
(7, 3, 3, NULL, 3, NULL, NULL, 'DINHEIRO', 425.00, '2024-01-11 13:17:00', 'SANGRIA: Compra de impressora para cliente'),
(8, 3, 3, NULL, 3, NULL, NULL, 'DINHEIRO', 40.69, '2024-01-11 13:19:00', 'SANGRIA: Compra de teclado e mouse para cliente'),
(9, 4, 3, 3, 1, 5, NULL, 'pix', 150.00, '2024-01-15 21:23:00', 'PAGAMENTO DA OS: 5'),
(10, 5, 3, 3, 1, 7, NULL, 'dinheiro', 120.00, '2024-01-16 22:07:00', 'PAGAMENTO DA OS: 7'),
(11, 7, 3, 2, 1, 4, NULL, 'pix', 238.00, '2024-01-25 18:24:00', 'PAGAMENTO DA OS: 4'),
(12, 8, 1, 2, 1, 8, NULL, 'pix', 120.00, '2024-02-15 13:39:00', 'PAGAMENTO DA OS: 8'),
(13, 9, 3, 2, 1, 9, NULL, 'pix', 60.00, '2024-02-19 11:03:00', 'PAGAMENTO DA OS: 9'),
(15, 9, 3, 2, 1, 9, NULL, 'dinheiro', 466.84, '2024-02-19 11:33:00', 'PAGAMENTO DA OS: 9'),
(16, 10, 3, 2, 1, 10, NULL, 'dinheiro', 130.00, '2024-03-26 14:56:00', 'PAGAMENTO DA OS: 10'),
(17, 10, 3, 2, 1, 11, NULL, 'dinheiro', 50.00, '2024-03-26 14:57:00', 'PAGAMENTO DA OS: 11'),
(18, 11, 3, 2, 1, 14, NULL, 'dinheiro', 180.00, '2024-03-28 13:13:00', 'PAGAMENTO DA OS: 14'),
(19, 12, 1, 2, 1, 12, NULL, 'dinheiro', 60.00, '2024-04-29 11:50:00', 'PAGAMENTO DA OS: 12'),
(20, 12, 1, 2, 1, 15, NULL, 'dinheiro', 30.00, '2024-04-29 11:51:00', 'PAGAMENTO DA OS: 15'),
(21, 15, 1, 4, 1, 17, NULL, 'pix', 150.00, '2024-06-15 16:33:00', 'PAGAMENTO DA OS: 17'),
(24, 17, 1, 5, 1, 20, NULL, 'dinheiro', 150.00, '2024-07-23 21:47:00', 'PAGAMENTO DA OS: 20'),
(25, 17, 1, 5, 1, 18, NULL, 'pix', 150.00, '2024-07-23 21:47:00', 'PAGAMENTO DA OS: 18'),
(26, 18, 1, 5, 1, 19, NULL, 'pix', 150.00, '2024-07-26 11:47:00', 'PAGAMENTO DA OS: 19'),
(27, 19, 1, 3, 1, 21, NULL, 'dinheiro', 150.00, '2024-08-31 23:47:00', 'PAGAMENTO DA OS: 21'),
(31, 22, 1, 6, 1, 22, NULL, 'credito', 670.00, '2024-09-29 14:06:00', 'PAGAMENTO DA OS: 22'),
(32, 22, 1, 6, 1, 22, NULL, 'credito', 229.81, '2024-09-29 14:06:00', 'PAGAMENTO DA OS: 22'),
(33, 23, 1, 2, 1, 23, NULL, 'dinheiro', 10.00, '2024-09-29 14:22:00', 'PAGAMENTO DA OS: 23'),
(34, 23, 1, 2, 1, 23, NULL, 'pix', 120.00, '2024-09-29 14:22:00', 'PAGAMENTO DA OS: 23'),
(35, 24, 1, 2, 1, 23, NULL, 'dinheiro', 120.00, '2024-10-08 13:07:00', 'PAGAMENTO DA OS: 23'),
(36, 25, 1, 5, 1, 25, NULL, 'pix', 248.00, '2024-10-10 12:39:00', 'PAGAMENTO DA OS: 25'),
(37, 25, 1, 2, 1, 24, NULL, 'dinheiro', 120.00, '2024-10-10 12:40:00', 'PAGAMENTO DA OS: 24'),
(38, 25, 1, 3, 1, 26, NULL, 'pix', 150.00, '2024-10-10 16:18:00', 'PAGAMENTO DA OS: 26'),
(39, 26, 1, 5, 1, 25, NULL, 'pix', 195.00, '2024-10-26 10:36:00', 'PAGAMENTO DA OS: 25'),
(40, 28, 1, 8, 1, 28, NULL, 'pix', 150.00, '2024-11-18 12:30:00', 'PAGAMENTO DA OS: 28'),
(41, 28, 1, 7, 1, 27, NULL, 'pix', 369.00, '2024-11-18 16:16:00', 'PAGAMENTO DA OS: 27'),
(42, 29, 1, 9, 1, 29, NULL, 'pix', 356.00, '2024-11-26 11:06:00', 'PAGAMENTO DA OS: 29'),
(43, 30, 1, 8, 1, 28, NULL, 'pix', 100.00, '2024-12-05 20:51:00', 'PAGAMENTO DA OS: 28'),
(44, 30, 1, 10, 1, 30, NULL, 'pix', 80.00, '2024-12-05 22:09:00', 'PAGAMENTO DA OS: 30'),
(45, 31, 1, 5, 1, 31, NULL, 'pix', 150.00, '2024-12-07 00:31:00', 'PAGAMENTO DA OS: 31'),
(46, 32, 1, 8, 1, 28, NULL, 'pix', 50.00, '2024-12-10 13:19:00', 'PAGAMENTO DA OS: 28'),
(47, 34, 1, 2, 1, 32, NULL, 'pix', 120.00, '2025-01-07 14:17:00', 'PAGAMENTO DA OS: 32'),
(48, 35, 1, 8, 1, 28, NULL, 'pix', 50.00, '2025-01-10 23:47:00', 'PAGAMENTO DA OS: 28'),
(49, 36, 1, 12, 1, 36, NULL, 'pix', 100.00, '2025-01-13 20:59:00', 'PAGAMENTO DA OS: 36'),
(52, 38, 1, 5, 1, 33, NULL, 'pix', 150.00, '2025-01-31 13:43:00', 'PAGAMENTO DA OS: 33'),
(53, 38, 1, 2, 1, 35, NULL, 'pix', 200.00, '2025-01-31 13:43:00', 'PAGAMENTO DA OS: 35'),
(54, 40, 1, 2, 1, 41, NULL, 'pix', 120.00, '2025-03-17 14:13:00', 'PAGAMENTO DA OS: 41'),
(55, 42, 1, 5, 1, 39, NULL, 'pix', 150.00, '2025-04-09 14:06:00', 'PAGAMENTO DA OS: 39'),
(56, 42, 1, 5, 1, 42, NULL, 'pix', 227.00, '2025-04-09 14:06:00', 'PAGAMENTO DA OS: 42'),
(57, 42, 1, 8, 1, 28, NULL, 'pix', 48.00, '2025-04-10 14:01:00', 'PAGAMENTO DA OS: 28'),
(58, 43, 1, 2, 1, 43, NULL, 'pix', 120.00, '2025-04-11 13:47:00', 'PAGAMENTO DA OS: 43'),
(59, 44, 1, 16, 1, 45, NULL, 'pix', 250.00, '2025-04-22 15:25:00', 'PAGAMENTO DA OS: 45'),
(60, 44, 1, 16, 1, 45, NULL, 'dinheiro', 155.00, '2025-04-22 15:25:00', 'PAGAMENTO DA OS: 45'),
(61, 45, 1, 15, 1, 44, NULL, 'pix', 120.00, '2025-05-05 18:07:00', 'PAGAMENTO DA OS: 44');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_orcamento_servico`
--

CREATE TABLE `tb_orcamento_servico` (
  `cd_orcamento` int(11) NOT NULL,
  `cd_servico` int(11) DEFAULT NULL,
  `cd_venda` int(11) DEFAULT NULL,
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

INSERT INTO `tb_orcamento_servico` (`cd_orcamento`, `cd_servico`, `cd_venda`, `cd_cliente`, `titulo_orcamento`, `vcusto_orcamento`, `vpag_orcamento`, `status_orcamento`, `cd_produto`, `qtd_orcamento`, `vtotal_orcamento`, `tipo_orcamento`, `vprod_orcamento`) VALUES
(1, 1, NULL, 1, 'Teste', '50', NULL, 0, NULL, NULL, 50, 'AVULSO', 0),
(2, 2, NULL, 2, 'Limpeza preventiva', '120', NULL, 0, NULL, NULL, 120, 'AVULSO', 0),
(3, 2, NULL, 2, 'SSD KINGSTON 240GB', '145', NULL, 0, NULL, NULL, 145, 'AVULSO', 0),
(5, 2, NULL, 2, 'Clonagem de HD para SSD (BONUS)', '1', NULL, 0, NULL, NULL, 1, 'AVULSO', 0),
(6, 2, NULL, 2, 'Reparo em circuito cooler', '50', NULL, 0, NULL, NULL, 50, 'AVULSO', 0),
(9, 3, NULL, 2, 'Kit teclado + mouse + cabos(alimentacao + VGA)', '75', NULL, 0, NULL, NULL, 75, 'AVULSO', 0),
(10, 3, NULL, 2, 'MÃ£o de obra completa', '150', NULL, 0, NULL, NULL, 150, 'AVULSO', 0),
(11, 3, NULL, 2, 'Fonte ATX 200W', '162.90', NULL, 0, NULL, NULL, 163, 'AVULSO', 0),
(12, 3, NULL, 2, 'Base monitor universaliversal', '35', NULL, 0, NULL, NULL, 35, 'AVULSO', 0),
(14, 4, NULL, 2, 'MÃ£o de obra', '150', NULL, 0, NULL, NULL, 150, 'AVULSO', 0),
(15, 4, NULL, 2, 'Kit teclado + mouse usb', '50', NULL, 0, NULL, NULL, 50, 'AVULSO', 0),
(16, 4, NULL, 2, 'Ssd 240gb', '168', NULL, 0, NULL, NULL, 168, 'AVULSO', 0),
(17, 4, NULL, 2, 'Monitor FLATRON L1530S Usado', '200', NULL, 0, NULL, NULL, 200, 'AVULSO', 0),
(18, 4, NULL, 2, 'Deskjet Ink Advantage 2774', '420', NULL, 0, NULL, NULL, 420, 'AVULSO', 0),
(19, 5, NULL, 3, 'Reparo em solda capacitores em curto', '150', NULL, 0, NULL, NULL, 150, 'AVULSO', 0),
(21, 7, NULL, 3, 'ManutenÃ§Ã£o preventiva', '100', NULL, 0, NULL, NULL, 100, 'AVULSO', 0),
(22, 7, NULL, 3, 'Colar tela de celular', '20', NULL, 0, NULL, NULL, 20, 'AVULSO', 0),
(23, 8, NULL, 2, 'Formatar', '120', NULL, 0, NULL, NULL, 120, 'AVULSO', 0),
(24, 9, NULL, 2, 'Kit 4 baterias 12v 5ah', '526.84', NULL, 0, NULL, NULL, 527, 'AVULSO', 0),
(25, 10, NULL, 2, 'EsterilizaÃ§Ã£o de placa e componentes', '50', NULL, 0, NULL, NULL, 50, 'AVULSO', 0),
(26, 10, NULL, 2, 'Retrabalho de solda em componentes danificados e troca de conector', '80', NULL, 0, NULL, NULL, 80, 'AVULSO', 0),
(27, 11, NULL, 2, 'Ressoldar componentes soltos da placa', '50', NULL, 0, NULL, NULL, 50, 'AVULSO', 0),
(28, 12, NULL, 2, 'Retrabalho ponta DB-9', '30', NULL, 0, NULL, NULL, 30, 'AVULSO', 0),
(29, 12, NULL, 2, 'Cabo Custom DB-9 para RJ-45', '30', NULL, 0, NULL, NULL, 30, 'AVULSO', 0),
(30, 13, NULL, 2, 'Fonte 12v 1.5A', '60', NULL, 0, NULL, NULL, 60, 'AVULSO', 0),
(31, 13, NULL, 2, 'MÃ£o de obra', '120', NULL, 0, NULL, NULL, 120, 'AVULSO', 0),
(32, 14, NULL, 2, 'Fonte 12v 1.5A', '60', NULL, 0, NULL, NULL, 60, 'AVULSO', 0),
(33, 14, NULL, 2, 'MÃ£o de obra', '120', NULL, 0, NULL, NULL, 120, 'AVULSO', 0),
(36, 15, NULL, 2, 'Retrabalho de cabo COM', '30', NULL, 0, NULL, NULL, 30, 'AVULSO', 0),
(37, 16, NULL, 1, 'Teste', '50', NULL, 0, NULL, NULL, 50, 'AVULSO', 0),
(39, 17, NULL, 4, 'Limpeza preventiva', '0.01', NULL, 0, NULL, NULL, 0, 'AVULSO', 0),
(40, 17, NULL, 4, 'Visita', '0.01', NULL, 0, NULL, NULL, 0, 'AVULSO', 0),
(41, 17, NULL, 4, 'Reparo em conectores entre placa alimentaÃ§Ã£o e toner.', '149.98', NULL, 0, NULL, NULL, 150, 'AVULSO', 0),
(45, 18, NULL, 5, 'Visita tÃ©cnica e realizaÃ§Ã£o de servicos', '150', NULL, 0, NULL, NULL, 150, 'AVULSO', 0),
(46, 19, NULL, 5, 'Visita tÃ©cnica e realizaÃ§Ã£o de servicos', '150', NULL, 0, NULL, NULL, 150, 'AVULSO', 0),
(47, 20, NULL, 5, 'Visita tÃ©cnica ', '150', NULL, 0, NULL, NULL, 150, 'AVULSO', 0),
(48, 21, NULL, 3, 'Preventiva / Corretiva', '150', NULL, 0, NULL, NULL, 150, 'AVULSO', 0),
(49, 22, NULL, 6, 'Servico', '150', NULL, 0, NULL, NULL, 150, 'AVULSO', 0),
(50, 22, NULL, 6, 'Cabo par traÃ§ado 15M', '79.81', NULL, 0, NULL, NULL, 80, 'AVULSO', 0),
(51, 22, NULL, 6, 'Inpressora', '670', NULL, 0, NULL, NULL, 670, 'AVULSO', 0),
(52, 23, NULL, 2, 'ServiÃ§os geral', '120', NULL, 0, NULL, NULL, 120, 'AVULSO', 0),
(53, 23, NULL, 2, 'Cabo VGA', '10', NULL, 0, NULL, NULL, 10, 'AVULSO', 0),
(54, 23, NULL, 2, 'ServiÃ§o adicional', '120', NULL, 0, NULL, NULL, 120, 'AVULSO', 0),
(56, 24, NULL, 2, 'Colocar ssd', '120', NULL, 0, NULL, NULL, 120, 'AVULSO', 0),
(57, 25, NULL, 5, 'ServiÃ§o', '150', NULL, 0, NULL, NULL, 150, 'AVULSO', 0),
(58, 25, NULL, 5, 'CartÃ£o de memÃ³ria 32gb WD', '45', NULL, 0, NULL, NULL, 45, 'AVULSO', 0),
(59, 25, NULL, 5, 'Camera 360', '248', NULL, 0, NULL, NULL, 248, 'AVULSO', 0),
(60, 26, NULL, 3, 'Servico', '150', NULL, 0, NULL, NULL, 150, 'AVULSO', 0),
(63, 28, NULL, 8, 'MÃ£o de obra + entrega/visita', '200', NULL, 0, NULL, NULL, 200, 'AVULSO', 0),
(66, 28, NULL, 8, 'PeÃ§as para troca', '218', NULL, 0, NULL, NULL, 218, 'AVULSO', 0),
(67, 28, NULL, 8, 'Desconto', '-20', NULL, 0, NULL, NULL, -20, 'AVULSO', 0),
(71, 27, NULL, 7, 'SSD KINGSTON 240GB', '219', NULL, 0, NULL, NULL, 219, 'AVULSO', 0),
(72, 29, NULL, 9, 'MÃ£o de obra', '200', NULL, 0, NULL, NULL, 200, 'AVULSO', 0),
(73, 29, NULL, 9, 'CarcaÃ§a Seminova', '206,90', NULL, 0, NULL, NULL, 206, 'AVULSO', 0),
(74, 29, NULL, 9, 'Desconto', '-50', NULL, 0, NULL, NULL, -50, 'AVULSO', 0),
(75, 27, NULL, 7, 'MÃ£o de obra', '150', NULL, 0, NULL, NULL, 150, 'AVULSO', 0),
(76, 30, NULL, 10, 'Acesso remoto atÃ© 1H', '80', NULL, 0, NULL, NULL, 80, 'AVULSO', 0),
(77, 31, NULL, 5, 'Visita', '150', NULL, 0, NULL, NULL, 150, 'AVULSO', 0),
(78, 32, NULL, 2, 'Trocar fonte', '120', NULL, 0, NULL, NULL, 120, 'AVULSO', 0),
(79, 33, NULL, 5, 'Reestabelecer internet, configurar roteador, revisar conexÃ£o de cameras', '150', NULL, 0, NULL, NULL, 150, 'AVULSO', 0),
(82, 35, NULL, 2, 'Instalar impressora compartilhada, erro b0011 e Explorer em erro', '120', NULL, 0, NULL, NULL, 120, 'AVULSO', 0),
(83, 36, NULL, 12, 'Configurar impressora, revisar rede wi-fi e conectar cameras', '80', NULL, 0, NULL, NULL, 80, 'AVULSO', 0),
(84, 36, NULL, 12, 'Extra', '20', NULL, 0, NULL, NULL, 20, 'AVULSO', 0),
(89, 35, NULL, 2, 'Adicional, clonagem de disco e troca HD para SSD', NULL, NULL, 0, NULL, 1, 80, 'AVULSO', 0),
(90, 39, NULL, 5, 'Check-up geral', NULL, NULL, 0, NULL, 1, 150, 'AVULSO', 0),
(91, 40, NULL, 14, 'Analise, limpeza e correcao de windows 7', NULL, NULL, 0, NULL, 1, 120, 'AVULSO', 0),
(92, 41, NULL, 2, 'Suporte prestado em backup e instalaÃ§Ã£o ', NULL, NULL, 0, NULL, 1, 120, 'AVULSO', 0),
(94, 42, NULL, 5, 'Visita + servico 1h', NULL, NULL, 0, NULL, 1, 150, 'AVULSO', 0),
(95, 42, NULL, 5, 'Cabo usb+fonte12v8A', NULL, NULL, 0, NULL, 1, 100, 'AVULSO', 0),
(97, 43, NULL, 2, 'Servicos prestados', NULL, NULL, 0, NULL, 1, 120, 'AVULSO', 0),
(98, 44, NULL, 15, 'Suporte remoto teamviewer', NULL, NULL, 0, NULL, 1, 120, 'AVULSO', 0),
(99, 45, NULL, 16, 'Trocar ...', NULL, NULL, 0, NULL, 1, 65, 'AVULSO', 0),
(100, 45, NULL, 16, 'Pneu', NULL, NULL, 0, NULL, 1, 90, 'AVULSO', 0),
(101, 45, NULL, 16, 'Mao de obra', NULL, NULL, 0, NULL, 1, 250, 'AVULSO', 0);

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

--
-- Extraindo dados da tabela `tb_prod_serv`
--

INSERT INTO `tb_prod_serv` (`cd_prod_serv`, `cd_classe_fiscal`, `cd_grupo`, `cdbarras_prod_serv`, `titulo_prod_serv`, `obs_prod_serv`, `estoque_prod_serv`, `tipo_prod_serv`, `preco_prod_serv`, `custo_prod_serv`, `status_prod_serv`) VALUES
(1, NULL, 1, '789', 'SSD 120GB', '.', 1, NULL, 120.00, 100.00, 1);

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
  `entrada_servico` varchar(40) DEFAULT NULL,
  `prazo_servico` varchar(40) DEFAULT NULL,
  `orcamento_servico` varchar(40) DEFAULT NULL,
  `vpag_servico` varchar(40) DEFAULT NULL,
  `status_servico` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_servico`
--

INSERT INTO `tb_servico` (`cd_servico`, `cd_cliente`, `titulo_servico`, `obs_servico`, `prioridade_servico`, `entrada_servico`, `prazo_servico`, `orcamento_servico`, `vpag_servico`, `status_servico`) VALUES
(2, 2, NULL, 'Notebook esquentando e travando', 'A', '2024-01-05T15:51', '2024-01-08T20:00', '316', NULL, '4'),
(3, 2, NULL, 'PC nÃ£o liga', 'A', '2024-01-09T12:49', '2024-01-11T16:00', '422.9', '422.9', '3'),
(4, 2, NULL, 'PC GAMER nÃ£o liga', 'M', '2024-01-10T14:38', '2024-01-15T16:00', '988', '988', '3'),
(5, 3, NULL, 'Reparo kodak', 'U', '2024-01-15T21:25', '2024-01-15T22:00', '150', '150', '3'),
(6, 3, NULL, 'ALL IN ONE LG 22V24 ANALISE PLACA PRINCIPAL, POSSIVEL MOSFET OU RESET BIOS', 'A', '2024-01-15T21:26', '2024-01-20T16:00', NULL, NULL, '4'),
(7, 3, NULL, 'Gabinete padrÃ£o, analisar defeito', 'A', '2024-01-15T21:27', '2024-01-20T16:00', '120', '120', '3'),
(8, 2, NULL, 'InicializaÃ§Ã£o do windows corrompida', 'U', '2024-02-15T11:10', '2024-02-15T16:00', '120', '120', '3'),
(9, 2, NULL, 'Nobreaks APC UPS 2200, TROCAR BATERIAS', 'U', '2024-02-19T11:38', '2024-02-22T16:00', '526.84', '526.84', '3'),
(10, 2, NULL, 'SN: 41885. NecessÃ¡ria esterilizaÃ§Ã£o da placa e retrabalho de solda', 'M', '2024-03-26T12:20', '2024-03-26T16:00', '130', '130', '3'),
(11, 2, NULL, 'SN: 13095. NecessÃ¡rio retrabalho de solda.', 'M', '2024-03-26T12:24', '2024-03-26T16:00', '50', '50', '3'),
(12, 2, NULL, 'Retrabalho em solda cabo par traÃ§ado adaptado. Ponta a reparar DB-9 Pinagem | 2=Branco-Laranja | 3=Laranja | 5=Azul  ', 'U', '2024-03-27T11:54', '2024-05-29T16:00', '60', '60', '3'),
(13, 2, NULL, 'Detector veicular DV-10. NECESSARIO REPARO EM PLACA DE FORÃ‡A ', 'M', '2024-03-27T22:31', '2024-03-28T16:00', '180', NULL, '4'),
(14, 2, NULL, 'Detector veicular DV-10. NÃ£o liga, necessÃ¡rio reparo. Placa fonte danificada', 'M', '2024-03-27T22:35', '2024-03-28T16:00', '180', '180', '3'),
(15, 2, NULL, 'Retrabalho em placa NS: 17301', 'U', '2024-04-29T11:26', '2024-05-29T16:00', '30', '30', '3'),
(16, 1, NULL, 'Teste', 'A', '2024-05-01T14:51', '2024-05-06T16:00', '50', NULL, '4'),
(17, 4, NULL, 'ManutenÃ§Ã£o para impressora M2020 Samsung. Imprimindo tudo preto', 'M', '2024-06-10T09:45', '2024-06-09T13:00', '150', '150', '3'),
(18, 5, NULL, 'Abrir chamado com TESA, alterar cadastro de produtos e preÃ§os ', 'U', '2024-07-23T20:32', '2024-07-20T18:00', '150', '150', '3'),
(19, 5, NULL, 'Configurar cÃ¢meras e alterar cadastro de produtos', 'U', '2024-07-23T20:39', '2024-07-21T18:00', '150', '150', '3'),
(20, 5, NULL, 'Configurar cÃ¢meras', 'U', '2024-07-23T20:46', '2024-07-16T18:00', '150', '150', '3'),
(21, 3, NULL, 'ManutenÃ§Ã£o de mÃ¡quina Kodak', 'M', '2024-08-31T22:46', '2024-08-31T16:00', '150', '150', '3'),
(22, 6, NULL, 'InstalaÃ§Ã£o de impressora', 'U', '2024-09-29T12:22', '2024-10-04T16:00', '899.81', '899.81', '3'),
(23, 2, NULL, 'PC APAGOU', 'U', '2024-09-29T13:19', '2024-09-25T16:00', '250', '250', '3'),
(24, 2, NULL, 'Deixar computador rapido', 'A', '2024-10-08T12:09', '2024-10-08T16:00', '120', '120', '3'),
(25, 5, NULL, 'Instalar cÃ¢meras MIBO', 'A', '2024-10-10T11:37', '2024-10-10T16:00', '443', '443', '3'),
(26, 3, NULL, 'Reparo Kodak, sensor tampa papel', 'U', '2024-10-10T14:14', '2024-10-10T16:00', '150', '150', '3'),
(27, 7, NULL, 'PC LENTO', 'M', '2024-11-13T14:40', '2024-11-15T16:00', '369', '369', '3'),
(28, 8, NULL, 'Hastes quebradas/tela solta', 'M', '2024-11-13T14:44', '2024-10-31T16:00', '398', '398', '3'),
(29, 9, NULL, 'CarcaÃ§a danificada', 'M', '2024-11-13T15:50', '2024-11-18T16:00', '356', '356', '3'),
(30, 10, NULL, 'Instalar impressora', 'U', '2024-12-05T19:51', '2024-12-10T16:00', '80', '80', '3'),
(31, 5, NULL, 'Alterar preÃ§os, verificar PDV', 'U', '2024-12-06T23:30', '2024-12-06T19:00', '150', '150', '3'),
(32, 2, NULL, 'Pc do Felipe nÃ£o liga', 'U', '2025-01-03T09:39', '2025-01-02T16:00', '120', '120', '3'),
(33, 5, NULL, 'Sem internet', 'U', '2025-01-03T10:30', '2024-12-26T16:00', '150', '150', '3'),
(34, 11, NULL, 'Corda quebrou', 'U', '2025-01-06T18:42', '2025-01-06T20:00', '0', NULL, '4'),
(35, 2, NULL, 'Instalar impressora compartilhada', 'U', '2025-01-13T15:53', '2025-01-14T16:00', '200', '200', '3'),
(36, 12, NULL, 'ServiÃ§os diversos', 'U', '2025-01-13T15:55', '2025-01-13T16:00', '100', '100', '3'),
(37, 13, NULL, 'Teste', 'M', '2025-01-21T09:07', '2025-01-26T16:00', '0', '0', '4'),
(38, 1, NULL, 'Teste', 'U', '2025-01-21T12:06', '2025-03-02T16:00', '0', NULL, '4'),
(39, 5, NULL, 'CAIXA 2 sem rede, cÃ¢meras mibo off, impressÃ£o falhada no cx1, cÃ¢meras isic off', 'M', '2025-03-01T11:11', '2025-03-01T16:00', '150', '150', '3'),
(40, 14, NULL, 'Recondicionamento de computador', 'M', '2025-03-12T18:33', '2025-02-09T16:00', '120', NULL, '3'),
(41, 2, NULL, 'Instalar virtual box com imagem de backup institucional', 'A', '2025-03-14T14:11', '2025-03-14T16:00', '120', '120', '3'),
(42, 5, NULL, 'Cameras', 'M', '2025-04-03T20:22', '2025-04-08T16:00', '250', '227', '3'),
(43, 2, NULL, 'ManutenÃ§Ã£o preventiva/ corretiva avulsa', 'U', '2025-04-09T12:52', '2025-04-09T16:00', '120', '120', '3'),
(44, 15, NULL, 'CONFIGURAR AMBIENTE VIRTUAL (remotamente)', 'U', '2025-04-14T14:56', '2025-04-14T16:00', '120', '120', '3'),
(45, 16, NULL, 'Servico teste', 'U', '2025-04-22T14:24', '2025-04-22T16:00', '250', '405', '3');

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
  ADD PRIMARY KEY (`cd_atividade`);

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
-- Indexes for table `tb_estilo`
--
ALTER TABLE `tb_estilo`
  ADD PRIMARY KEY (`cd_estilo`);

--
-- Indexes for table `tb_filial`
--
ALTER TABLE `tb_filial`
  ADD PRIMARY KEY (`cd_filial`);

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
  ADD PRIMARY KEY (`cd_servico`);

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
  MODIFY `token_alter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_atividade`
--
ALTER TABLE `tb_atividade`
  MODIFY `cd_atividade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `tb_caixa`
--
ALTER TABLE `tb_caixa`
  MODIFY `cd_caixa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `tb_caixa_conferido`
--
ALTER TABLE `tb_caixa_conferido`
  MODIFY `cd_caixa_conferido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `tb_caixa_dia_fiscal`
--
ALTER TABLE `tb_caixa_dia_fiscal`
  MODIFY `cd_caixa_dia_fiscal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

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
  MODIFY `cd_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tb_colab`
--
ALTER TABLE `tb_colab`
  MODIFY `cd_colab` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_empresa`
--
ALTER TABLE `tb_empresa`
  MODIFY `cd_empresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `cd_grupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_movimento_financeiro`
--
ALTER TABLE `tb_movimento_financeiro`
  MODIFY `cd_movimento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `tb_orcamento_servico`
--
ALTER TABLE `tb_orcamento_servico`
  MODIFY `cd_orcamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `tb_prod_serv`
--
ALTER TABLE `tb_prod_serv`
  MODIFY `cd_prod_serv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `cd_servico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `fl_ponto`
--
ALTER TABLE `fl_ponto`
  ADD CONSTRAINT `fk_fl_ponto1` FOREIGN KEY (`cdcolab_ponto`) REFERENCES `tb_colab` (`cd_colab`),
  ADD CONSTRAINT `fk_fl_ponto2` FOREIGN KEY (`cdempresa_ponto`) REFERENCES `tb_empresa` (`cd_empresa`);

--
-- Limitadores para a tabela `rel_user`
--
ALTER TABLE `rel_user`
  ADD CONSTRAINT `fk_rel_user1` FOREIGN KEY (`cd_seg`) REFERENCES `tb_seguranca` (`cd_seg`),
  ADD CONSTRAINT `fk_rel_user2` FOREIGN KEY (`cd_colab`) REFERENCES `tb_colab` (`cd_colab`),
  ADD CONSTRAINT `fk_rel_user3` FOREIGN KEY (`cd_estilo`) REFERENCES `tb_estilo` (`cd_estilo`),
  ADD CONSTRAINT `fk_rel_user4` FOREIGN KEY (`cd_funcao`) REFERENCES `tb_funcao` (`cd_funcao`),
  ADD CONSTRAINT `fk_rel_user5` FOREIGN KEY (`cd_empresa`) REFERENCES `tb_empresa` (`cd_empresa`);

--
-- Limitadores para a tabela `tb_caixa`
--
ALTER TABLE `tb_caixa`
  ADD CONSTRAINT `fk_tb_caixa1` FOREIGN KEY (`cd_colab_abertura`) REFERENCES `tb_colab` (`cd_colab`),
  ADD CONSTRAINT `fk_tb_caixa2` FOREIGN KEY (`cd_colab_fechamento`) REFERENCES `tb_colab` (`cd_colab`);

--
-- Limitadores para a tabela `tb_caixa_conferido`
--
ALTER TABLE `tb_caixa_conferido`
  ADD CONSTRAINT `fk_tb_caixa_conferido1` FOREIGN KEY (`cd_caixa_analitico`) REFERENCES `tb_caixa` (`cd_caixa`),
  ADD CONSTRAINT `fk_tb_caixa_conferido2` FOREIGN KEY (`cd_colab_conferencia`) REFERENCES `tb_colab` (`cd_colab`);

--
-- Limitadores para a tabela `tb_empresa`
--
ALTER TABLE `tb_empresa`
  ADD CONSTRAINT `fk_rel_empresa1` FOREIGN KEY (`cd_ceo`) REFERENCES `tb_colab` (`cd_colab`);

--
-- Limitadores para a tabela `tb_movimento_financeiro`
--
ALTER TABLE `tb_movimento_financeiro`
  ADD CONSTRAINT `fk_tb_movimento_financeiro1` FOREIGN KEY (`cd_caixa_movimento`) REFERENCES `tb_caixa` (`cd_caixa`),
  ADD CONSTRAINT `fk_tb_movimento_financeiro2` FOREIGN KEY (`cd_colab_movimento`) REFERENCES `tb_colab` (`cd_colab`),
  ADD CONSTRAINT `fk_tb_movimento_financeiro3` FOREIGN KEY (`cd_cliente_movimento`) REFERENCES `tb_cliente` (`cd_cliente`),
  ADD CONSTRAINT `fk_tb_movimento_financeiro4` FOREIGN KEY (`cd_os_movimento`) REFERENCES `tb_servico` (`cd_servico`);

--
-- Limitadores para a tabela `tb_orcamento_servico`
--
ALTER TABLE `tb_orcamento_servico`
  ADD CONSTRAINT `fk_rel_orcamento3` FOREIGN KEY (`cd_produto`) REFERENCES `tb_prod_serv` (`cd_prod_serv`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
