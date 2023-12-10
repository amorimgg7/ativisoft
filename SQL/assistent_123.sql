
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `rel_user` (
  `token_alter` int(11) NOT NULL,
  `cd_seg` int(11) DEFAULT NULL,
  `cd_colab` int(11) DEFAULT NULL,
  `cd_estilo` int(11) DEFAULT NULL,
  `cd_funcao` int(11) DEFAULT NULL,
  `cd_empresa` int(11) DEFAULT NULL,
  `cd_status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `rel_user` (`token_alter`, `cd_seg`, `cd_colab`, `cd_estilo`, `cd_funcao`, `cd_empresa`, `cd_status`) VALUES
(1, 1, 1, 1, 1, 1, 1),
(4, 1, 9, 1, 1, 1, 1),
(5, 1, 10, 1, 1, 1, 1),
(6, 1, 11, 1, 1, 1, 1),
(7, 1, 12, 1, 1, 1, 1);


CREATE TABLE `tb_atividade` (
  `cd_atividade` int(11) NOT NULL,
  `cd_servico` int(11) DEFAULT NULL,
  `titulo_atividade` varchar(10) DEFAULT NULL,
  `obs_atividade` varchar(1000) DEFAULT NULL,
  `cd_colab` int(11) DEFAULT NULL,
  `inicio_atividade` varchar(40) DEFAULT NULL,
  `fim_atividade` varchar(40) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



INSERT INTO `tb_atividade` (`cd_atividade`, `cd_servico`, `titulo_atividade`, `obs_atividade`, `cd_colab`, `inicio_atividade`, `fim_atividade`) VALUES
(1, 1, 'A', 'Ggg', 1, '2023-08-22T17:14', '2023-08-22T17:14'),
(2, 1, 'C', '', 1, '2023-08-22T17:31', '2023-08-22T17:34'),
(3, 2, 'A', 'Ggdd', 1, '2023-08-22T17:31', '2023-08-22T17:31'),
(4, 3, 'A', 'Hvjvkhpiouiturhcjvojpj', 1, '2023-08-22T17:32', '2023-08-22T17:32'),
(5, 1, 'D', 'Devolver', 1, '2023-08-22T22:33', '2023-08-22T22:33'),
(6, 2, 'C', '', 1, '2023-08-22T22:35', '2023-08-22T22:35'),
(7, 2, 'D', '', 1, '2023-08-22T22:35', '2023-08-22T22:35'),
(8, 3, 'C', '', 1, '2023-08-22T22:36', '2023-08-22T22:36'),
(9, 4, 'A', 'Gfddthjj', 10, '2023-08-23T02:44', '2023-08-23T02:44'),
(10, 2, 'A', '', 1, '2023-08-23T04:51', NULL),
(11, 1, 'A', '', 1, '2023-08-23T04:52', NULL),
(12, 3, 'A', '', 1, '2023-08-23T04:52', NULL),
(13, 1, 'C', '', 1, '2023-08-23T05:29', '2023-08-23T05:29'),
(14, 1, 'D', '', 1, '2023-08-23T05:29', '2023-08-23T05:29'),
(15, 2, 'C', '', 1, '2023-08-23T05:29', '2023-08-23T05:29'),
(16, 2, 'D', '', 1, '2023-08-23T05:29', '2023-08-23T05:29'),
(17, 3, 'C', '', 1, '2023-08-23T05:29', '2023-08-23T05:30'),
(18, 3, 'D', '', 1, '2023-08-23T05:30', '2023-08-23T05:30'),
(19, 4, 'C', '', 10, '2023-08-23T05:30', '2023-08-23T05:30'),
(20, 4, 'D', '', 10, '2023-08-23T05:30', '2023-08-23T05:30'),
(21, 5, 'A', 'Fazer crochÃª ', 11, '2023-08-23T14:13', '2023-08-23T14:13'),
(22, 5, 'C', '', 11, '2023-08-23T14:20', '2023-08-23T14:21'),
(23, 5, 'A', '', 11, '2023-08-23T14:23', NULL),
(24, 6, 'A', 'Ddghg', 9, '2023-08-23T17:07', '2023-08-23T17:07'),
(25, 7, 'A', 'Consertos', 9, '2023-08-23T20:24', '2023-08-23T20:24'),
(26, 2, 'A', '', 1, '2023-08-23T22:21', NULL),
(27, 8, 'A', 'teste', 9, '2023-08-24T05:48', '2023-08-24T05:48'),
(28, 9, 'A', 'FormataÃ§Ã£o pc', 12, '2023-08-24T16:30', '2023-08-24T16:30'),
(29, 10, 'A', 'DescriÃ§Ã£o geral', 12, '2023-08-24T16:40', '2023-08-24T16:40'),
(30, 7, 'C', '', 9, '2023-08-24T16:49', '2023-08-24T16:49'),
(31, 7, 'D', 'Telefone devolvido ao MÃ¡rcio, primo do cliente', 9, '2023-08-24T16:50', '2023-08-24T16:50'),
(32, 2, 'C', '', 1, '2023-08-24T20:33', '2023-08-24T20:33'),
(33, 2, 'C', '', 1, '2023-08-24T20:33', '2023-08-24T20:34'),
(34, 2, 'D', '', 1, '2023-08-24T20:35', '2023-08-24T20:35'),
(35, 5, 'C', '', 11, '2023-08-24T20:35', '2023-08-24T20:35'),
(36, 5, 'D', '', 11, '2023-08-24T20:35', '2023-08-24T20:35'),
(37, 6, 'C', '', 9, '2023-08-24T20:36', '2023-08-24T20:36'),
(38, 6, 'D', '', 9, '2023-08-24T20:36', '2023-08-24T20:36'),
(39, 10, 'C', '', 12, '2023-08-24T20:36', '2023-08-24T20:36'),
(40, 10, 'D', '', 12, '2023-08-24T20:36', '2023-08-24T20:36'),
(41, 8, 'C', '', 9, '2023-08-24T20:36', '2023-08-24T20:36'),
(42, 8, 'D', '', 9, '2023-08-24T20:38', '2023-08-24T20:38'),
(43, 9, 'C', '', 12, '2023-08-24T20:39', '2023-08-24T20:39'),
(44, 9, 'D', '', 12, '2023-08-24T20:39', '2023-08-24T20:39'),
(45, 11, 'C', 'Teste', 1, '2023-08-25T14:40', '2023-08-26T01:56'),
(46, 12, 'A', 'Jajsjdkck', 1, '2023-08-26T00:48', '2023-08-26T00:48'),
(47, 11, 'D', 'Jvjvjchchv', 1, '2023-08-26T01:56', '2023-08-26T01:56'),
(48, 13, 'A', '', 1, '2023-08-26T01:59', '2023-08-26T01:59'),
(60, 13, 'C', '', 1, '2023-08-26T02:22', '2023-08-26T02:22'),
(61, 12, 'C', '', 1, '2023-08-26T02:24', '2023-08-26T02:24'),
(62, 12, 'A', '', 1, '2023-08-26T02:24', NULL),
(63, 13, 'C', '', 1, '2023-08-26T02:25', '2023-08-26T02:25'),
(64, 13, 'A', '', 1, '2023-08-26T02:26', NULL),
(65, 13, 'C', '', 1, '2023-08-26T02:26', '2023-08-26T02:26'),
(66, 13, 'A', '', 1, '2023-08-26T02:26', NULL),
(67, 13, 'C', '', 1, '2023-08-26T02:26', '2023-08-26T02:26'),
(68, 13, 'D', '', 1, '2023-08-26T02:27', '2023-08-26T02:27'),
(69, 14, 'A', 'Hfufufhc', 1, '2023-08-26T02:27', '2023-08-26T02:27'),
(80, 14, 'C', 'Jcjcjcjfhdfsfafafarafa', 1, '2023-08-26T02:45', '2023-08-26T02:45'),
(79, 14, 'A', '', 1, '2023-08-26T02:42', NULL),
(78, 14, 'D', '', 1, '2023-08-26T02:42', '2023-08-26T02:42'),
(77, 14, 'C', 'Jhljljlmlmlmlmlmlml', 1, '2023-08-26T02:41', '2023-08-26T02:42'),
(82, 14, 'D', 'Entregue para zuleide', 1, '2023-08-26T02:47', '2023-08-26T02:47'),
(84, 14, 'A', 'Refazer depois', 1, '2023-08-26T02:48', NULL),
(85, 14, 'C', '', 1, '2023-08-26T02:49', '2023-08-26T02:49'),
(86, 12, 'C', '', 1, '2023-08-26T03:15', '2023-08-26T03:15'),
(87, 14, 'D', '', 1, '2023-08-26T03:15', '2023-08-26T03:15'),
(88, 12, 'D', '', 1, '2023-08-26T03:15', '2023-08-26T03:15'),
(89, 12, 'A', '', 1, '2023-08-26T03:15', NULL),
(90, 1, 'A', '', 1, '2023-08-26T03:16', NULL),
(91, 9, 'A', '', 12, '2023-08-26T03:16', NULL),
(92, 13, 'A', '', 1, '2023-08-26T03:16', NULL),
(93, 8, 'A', '', 9, '2023-08-26T03:16', NULL),
(94, 14, 'A', '', 1, '2023-08-26T03:17', NULL),
(95, 11, 'A', '', 1, '2023-08-26T03:17', NULL),
(96, 7, 'A', '', 9, '2023-08-26T03:17', NULL),
(97, 10, 'A', '', 12, '2023-08-26T03:17', NULL),
(98, 6, 'C', '', 9, '2023-08-26T03:17', '2023-08-26T03:19'),
(99, 3, 'A', '', 1, '2023-08-26T03:18', NULL),
(100, 3, 'C', '', 1, '2023-08-26T03:18', '2023-08-26T03:18'),
(101, 5, 'A', '', 11, '2023-08-26T03:18', NULL),
(102, 2, 'A', '', 1, '2023-08-26T03:18', NULL),
(103, 4, 'A', '', 10, '2023-08-26T03:18', NULL),
(104, 3, 'A', '', 1, '2023-08-26T03:19', NULL),
(105, 6, 'A', '', 9, '2023-08-26T03:19', NULL),
(106, 1, 'C', '', 1, '2023-08-28T21:25', '2023-08-28T21:25'),
(107, 2, 'C', '', 1, '2023-08-28T21:26', '2023-08-28T21:26'),
(108, 3, 'C', '', 1, '2023-08-28T21:26', '2023-08-28T21:26'),
(109, 14, 'C', 'Feito', 1, '2023-08-30T00:43', '2023-08-30T00:43'),
(110, 15, 'A', 'Servidor queimou', 12, '2023-09-01T12:38', '2023-09-01T12:38'),
(111, 15, 'C', '', 12, '2023-09-01T12:44', '2023-09-01T12:46'),
(112, 15, 'D', 'Hahaha', 12, '2023-09-01T12:46', '2023-09-01T12:46'),
(113, 15, 'C', '', 12, '2023-09-01T12:47', '2023-09-01T12:47'),
(114, 15, 'D', 'Haha', 12, '2023-09-01T12:47', '2023-09-01T12:47'),
(115, 16, 'A', 'PC parou', 1, '2023-09-01T18:13', '2023-09-01T18:13'),
(116, 1, 'A', 'Aaaaaaaaaaaaaaaaaa', 1, '2023-09-01T18:16', NULL),
(117, 1, 'C', 'Feito', 1, '2023-09-01T18:22', '2023-09-01T18:22'),
(118, 1, 'D', 'Entregar', 1, '2023-09-01T18:24', '2023-09-01T18:24'),
(119, 1, 'C', 'Finalizado agora', 1, '2023-09-01T18:25', '2023-09-01T18:26'),
(120, 1, 'D', '', 1, '2023-09-01T18:27', '2023-09-01T18:27'),
(121, 1, 'A', 'Refazer depois', 1, '2023-09-01T18:28', NULL),
(122, 4, 'B', 'Cleide estÃ¡ fazendo', 10, '2023-09-08T12:54', NULL),
(123, 7, 'C', '', 9, '2023-09-08T12:55', '2023-09-08T13:11'),
(124, 1, 'C', 'Feito', 1, '2023-09-08T13:05', '2023-11-10T15:49'),
(125, 6, 'B', '', 9, '2023-09-08T13:05', NULL),
(126, 9, 'B', '', 12, '2023-09-08T13:06', NULL),
(127, 12, 'B', '', 1, '2023-09-08T13:06', NULL),
(128, 11, 'B', '', 1, '2023-09-08T13:06', NULL),
(129, 13, 'B', '', 1, '2023-09-08T13:06', NULL),
(130, 16, 'B', '', 1, '2023-09-08T13:06', NULL),
(131, 5, 'B', '', 11, '2023-09-08T13:06', NULL),
(132, 10, 'B', '', 12, '2023-09-08T13:07', NULL),
(133, 8, 'B', '', 9, '2023-09-08T13:07', NULL),
(134, 2, 'A', '', 1, '2023-09-08T13:09', NULL),
(135, 7, 'A', '', 9, '2023-09-08T13:11', NULL),
(136, 17, 'A', 'Formatar', 1, '2023-09-08T14:53', '2023-09-08T14:53'),
(137, 18, 'A', 'Queimou', 12, '2023-09-13T12:42', '2023-09-13T12:42'),
(138, 18, 'B', '', 12, '2023-09-13T12:46', NULL),
(139, 17, 'C', 'finalizado', 1, '2023-09-20T09:54', '2023-09-20T09:54'),
(140, 7, 'E', 'Cliente desistiu do servico', 9, '2023-09-20T18:03', '2023-09-20T18:03'),
(141, 19, 'A', 'Jzbzabzkwbxkqd', 1, '2023-09-20T18:09', '2023-09-20T18:09'),
(142, 19, 'E', 'Cliente desistiu', 1, '2023-09-20T18:11', '2023-09-20T18:11'),
(143, 20, 'A', 'teste1', 1, '2023-10-01T10:49', '2023-10-01T10:49'),
(144, 21, 'A', 'teste 2', 1, '2023-10-01T10:51', '2023-10-01T10:51'),
(145, 22, 'A', 'Teste', 1, '2023-10-11T09:51', '2023-10-11T09:51'),
(146, 23, 'A', 'Teste', 1, '2023-10-17T22:42', '2023-10-17T22:42'),
(147, 24, 'A', 'TESTEEER', 1, '2023-10-19T19:16', '2023-10-19T19:16'),
(148, 25, 'A', 'teste 1', 1, '2023-10-23T19:01', '2023-10-23T19:01'),
(149, 26, 'A', 'teste 2', 1, '2023-10-23T19:03', '2023-10-23T19:03'),
(150, 27, 'A', 'teste 3', 1, '2023-10-23T19:26', '2023-10-23T19:26'),
(151, 28, 'A', 'teste 4', 1, '2023-10-23T19:33', '2023-10-23T19:33'),
(152, 29, 'A', 'teste 5', 1, '2023-10-23T19:37', '2023-10-23T19:37'),
(153, 30, 'A', 'Teste 10', 1, '2023-10-26T08:45', '2023-10-26T08:45'),
(154, 31, 'A', 'Teste de hora', 1, '2023-10-30T14:05', '2023-10-30T14:05'),
(155, 32, 'A', 'Ttt', 1, '2023-10-30T15:31', '2023-10-30T15:31'),
(156, 33, 'A', 'Ttt', 1, '2023-10-30T19:17', '2023-10-30T19:17'),
(157, 34, 'A', 'Tt', 1, '2023-10-30T19:25', '2023-10-30T19:25'),
(158, 35, 'A', 'teste', 1, '2023-10-30T20:06', '2023-10-30T20:06'),
(159, 29, 'C', 'Feito', 1, '2023-10-31T19:51', '2023-10-31T19:51'),
(160, 30, 'E', 'Tt', 1, '2023-10-31T19:51', '2023-10-31T19:51'),
(161, 35, 'C', 'Ff', 1, '2023-10-31T19:52', '2023-10-31T19:52'),
(162, 1, 'D', 'Cliente retirou com sucesso', 1, '2023-11-10T15:49', '2023-11-10T15:49'),
(163, 34, 'A', 'Tt', 1, '2023-11-13T08:39', '2023-11-13T08:39'),
(164, 36, 'A', 'aaa', 1, '2023-11-21T11:41', '2023-11-21T11:41'),
(165, 37, 'A', 'Teste', 1, '2023-11-28T08:32', '2023-11-28T08:32'),
(166, 38, 'A', 'Teste', 1, '2023-11-28T08:33', '2023-11-28T08:33'),
(167, 39, 'A', 'Tt', 1, '2023-11-28T08:33', '2023-11-28T08:33'),
(168, 40, 'A', 'Teste', 1, '2023-11-28T08:34', '2023-11-28T08:34'),
(169, 41, 'A', 'Teste', 1, '2023-11-28T18:38', '2023-11-28T18:38');



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



INSERT INTO `tb_caixa` (`cd_caixa`, `dt_abertura`, `dt_fechamento`, `cd_colab_abertura`, `cd_colab_fechamento`, `saldo_abertura`, `total_movimento`, `saldo_fechamento`, `diferenca_caixa`, `fpag_dinheiro`, `fpag_debito`, `fpag_credito`, `fpag_pix`, `fpag_cofre`, `fpag_boleto`, `status_caixa`) VALUES
(17, '2023-08-24 16:28:00', '2023-08-25 05:24:00', 12, 1, 100.00, 100.00, 200.00, 0.00, 100.00, 0.00, 0.00, 0.00, NULL, NULL, 1),
(16, '2023-08-23 00:00:00', '2023-08-24 07:46:00', 9, 9, 5.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1),
(15, '2023-08-23 00:00:00', '2023-08-24 07:46:00', 1, 9, 20.00, 30.00, 50.00, 0.00, 30.00, 0.00, 0.00, 0.00, NULL, NULL, 1),
(14, '2023-08-23 05:33:00', '2023-08-24 07:45:00', 9, 9, 8.00, 30.00, 38.00, 15.00, 30.00, 0.00, 0.00, 0.00, NULL, NULL, 1),
(12, '2023-08-23 04:55:00', '2023-08-24 07:45:00', 9, 9, 5.00, 939.00, 944.00, 10.00, 120.00, 0.00, 481.00, 338.00, NULL, NULL, 1),
(18, '2023-08-24 20:30:00', '2023-08-24 20:40:00', 1, 1, 3.00, 201.00, 204.00, 0.00, 36.00, 0.00, 0.00, 165.00, NULL, NULL, 1),
(19, '2023-08-24 14:40:00', '2023-08-25 15:29:00', 1, 1, 5.00, 50.00, 105.00, 10.00, 0.00, 0.00, 0.00, 0.00, 50.00, NULL, 1),
(20, '2023-08-25 15:33:00', '2023-08-25 15:41:00', 1, 1, 4.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 90.00, NULL, 1),
(21, '2023-08-26 03:59:00', '2023-08-28 21:25:00', 1, 1, 30.00, 30.00, 60.00, 0.00, 30.00, 0.00, 0.00, 0.00, NULL, NULL, 1),
(22, '2023-08-28 21:25:00', '2023-08-28 22:31:00', 1, 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1),
(23, '2023-08-30 00:47:00', '2023-08-31 17:15:00', 12, 1, 39.00, 0.00, 39.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1),
(24, '2023-08-30 00:47:00', '2023-08-31 17:15:00', 12, 1, 23.00, 0.00, 23.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1),
(25, '2023-08-31 17:19:00', '2023-09-01 10:36:00', 1, 1, 50.00, 0.00, 50.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1),
(26, '2023-09-01 12:34:00', '2023-09-01 12:49:00', 12, 12, 100.00, 1155.50, 1255.50, 0.00, 950.00, 0.00, 0.00, 200.00, NULL, NULL, 1),
(27, '2023-09-04 14:58:00', '2023-09-08 13:30:00', 1, 1, 50.00, 0.00, 50.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1),
(28, '2023-09-08 13:30:00', '2023-09-09 02:21:00', 1, 1, 10.00, 140.00, 150.00, 0.00, 100.00, 40.00, 0.00, 0.00, 0.00, NULL, 1),
(29, '2023-09-10 02:21:00', '2023-09-12 09:23:00', 1, 1, 0.00, 339.00, 339.00, 0.00, 50.00, 0.00, 246.00, 43.00, 0.00, NULL, 1),
(30, '2023-10-01 10:49:00', '2023-10-04 08:38:00', 1, 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1),
(31, '2023-10-11 09:51:00', '2023-10-13 09:03:00', 1, 1, 10.00, 45.00, 55.00, 0.00, 45.00, 0.00, 0.00, 0.00, NULL, NULL, 1),
(32, '2023-10-19 19:14:00', '2023-10-20 16:15:00', 1, 1, 30.00, 3.00, 33.00, 0.00, 3.00, 0.00, 0.00, 0.00, 0.00, NULL, 1),
(33, '2023-10-23 19:00:00', '2023-10-26 08:44:00', 1, 1, 10.00, 0.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1),
(34, '2023-10-29 10:26:00', '2023-10-30 20:47:00', 1, 1, 0.00, 6.00, 6.00, 0.00, 0.00, 0.00, 3.00, 3.00, 0.00, NULL, 1),
(35, '2023-10-30 20:47:00', '2023-10-31 06:54:00', 1, 1, 10.00, 0.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1),
(36, '2023-10-31 19:50:00', '2023-10-31 19:56:00', 1, 1, 10.00, 5.00, 15.00, 0.00, 0.00, 5.00, 0.00, 0.00, NULL, NULL, 1),
(37, '2023-11-03 09:24:00', '2023-11-03 09:45:00', 1, 1, 50.00, 0.00, 50.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1),
(38, '2023-11-03 14:27:00', '2023-11-03 14:30:00', 1, 1, 30.00, 109.00, 139.00, 0.00, 100.00, 0.00, 0.00, 9.00, 0.00, NULL, 1),
(39, '2023-11-03 16:05:00', '2023-11-03 23:30:00', 1, 1, 30.00, 29.00, 59.00, 0.00, 2.00, 0.00, 0.00, 30.00, NULL, NULL, 1),
(40, '2023-11-07 17:24:00', '2023-11-10 14:47:00', 1, 1, 3.00, 0.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1),
(41, '2023-11-10 14:48:00', '2023-11-16 06:53:00', 1, 1, 0.00, 50.00, 50.00, 0.00, 0.00, 0.00, 50.00, 0.00, NULL, NULL, 1),
(42, '2023-11-16 06:53:00', '2023-11-18 19:25:00', 1, 1, 2.00, 0.00, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1),
(43, '2023-11-18 19:25:00', '2023-11-18 19:30:00', 1, 1, 50.00, 0.00, 50.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1),
(44, '2023-11-18 19:31:00', '2023-11-19 09:55:00', 1, 12, 10.00, 0.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 1),
(45, '2023-11-19 11:48:00', '2023-11-21 10:41:00', 1, 1, 10.00, 0.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1),
(46, '2023-11-21 10:41:00', '2023-11-27 10:10:00', 1, 1, 10.00, 0.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1),
(47, '2023-11-28 07:27:00', NULL, 1, NULL, 3.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);


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
(76, 46, '2023-11-27 10:10:00', 1, 'Fechamento de Caixa (Auditoria por vÃ¡rios dias aberto)', 10.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL);



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
(32, '2023-11-28 07:27:00', NULL, NULL, NULL, NULL, NULL, NULL, 0);



CREATE TABLE `tb_classe_fiscal` (
  `cd_classe_fiscal` int(11) NOT NULL,
  `titulo_classe_fiscal` varchar(100) DEFAULT NULL,
  `obs_classe_fiscal` varchar(100) DEFAULT NULL,
  `ncm_classe_fiscal` int(11) DEFAULT NULL,
  `csosn_classe_fiscal` int(11) DEFAULT NULL,
  `cst_classe_fiscal` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



INSERT INTO `tb_classe_fiscal` (`cd_classe_fiscal`, `titulo_classe_fiscal`, `obs_classe_fiscal`, `ncm_classe_fiscal`, `csosn_classe_fiscal`, `cst_classe_fiscal`) VALUES
(1, 'Classe Geral', 'Classe fiscal para coisas em geral', 0, 105, 500);



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
(14, 'Teste', 'Teste', NULL, NULL, NULL, NULL, '5544444444444', NULL, NULL, NULL, NULL);



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



INSERT INTO `tb_colab` (`cd_colab`, `pnome_colab`, `snome_colab`, `cpf_colab`, `dtnasc_colab`, `sexo_colab`, `obs_colab`, `tel_colab`, `obs_tel_colab`, `email_colab`, `foto_colab`, `senha_colab`) VALUES
(1, 'Suporte', 'erp-Nuvemsoft', '1', NULL, NULL, NULL, '21960150200', NULL, 'suporte@ativisoft.com.br', NULL, 'asd,123'),
(9, 'Gabriel', 'Amorim', NULL, NULL, NULL, NULL, '21965543094', NULL, 'amorimgg7@gmail.com', NULL, '1'),
(10, 'Gabriel', 'Amorim', NULL, NULL, NULL, NULL, '21965543094', NULL, 'gabriel@newchoice.com.br', NULL, '1'),
(11, 'Marissol', 'Ramalho ', NULL, NULL, NULL, NULL, '964367149', NULL, 'marissolcriz23@gmail.com', NULL, '1'),
(12, 'Testador', '.', NULL, NULL, NULL, NULL, '21965543094', NULL, 'testador@testador.com.br', NULL, '1');



CREATE TABLE `tb_empresa` (
  `cd_empresa` int(11) NOT NULL,
  `rsocial_empresa` varchar(40) DEFAULT NULL,
  `nfantasia_empresa` varchar(40) DEFAULT NULL,
  `cnpj_empresa` int(11) DEFAULT NULL,
  `cd_ceo` int(11) DEFAULT NULL,
  `chave_auth` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `tb_empresa` (`cd_empresa`, `rsocial_empresa`, `nfantasia_empresa`, `cnpj_empresa`, `cd_ceo`, `chave_auth`) VALUES
(1, 'ERP NUVEMSOFT', 'ERP NUVEMSOFT', 123, 1, 'AUTH');



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



INSERT INTO `tb_estilo` (`cd_estilo`, `titulo_estilo`, `t_sidebar`, `c_sidebar`, `t_navbar`, `c_navbar`, `t_font`, `c_font`, `c_body`, `c_card`) VALUES
(1, 'Light-blue', 'padrão', 'style=\"background-color: #a7dbfb; color: #044167;\"', 'padrão', 'style=\"background-color: #23a5f6;\"', 'padrão', 'padrão', '', ''),
(2, 'Dark-blue', 'padrão', 'style=\"background-color: #191970; color: #ffffff;\"', 'padrão', 'style=\"background-color: #2727ec;\"', 'padrão', 'padrão', 'style=\"background-color: #363672; color:#BDBDEF;border: 0px solid;\"', 'style=\"background-color: #4C4C70; color:#BDBDEF; border: 0px solid;\"');


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



INSERT INTO `tb_filial` (`cd_filial`, `cd_empresa`, `cd_responsavel`, `rsocial_filial`, `nfantasia_filial`, `cnpj_filial`, `endereco_filial`, `saudacoes_filial`) VALUES
(1, 1, 1, 'ERP NUVEMSOFT', 'ERP NUVEMSOFT', '123', 'Rua João Bruno Lobo 291A Casa 1, Curicica', 'Você só vence amanhã se não desistir hoje Edna Frigato');

-- --------------------------------------------------------



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



INSERT INTO `tb_funcao` (`cd_funcao`, `titulo_funcao`, `obs_funcao`, `md_patrimonio`, `md_fponto`, `md_assistencia`, `md_cliente`, `md_fornecedor`, `md_clientefornecedor`) VALUES
(1, 'MASTER', 'observações', 'style=\"display: block;\"', 'style=\"display: block;\"', 'style=\"display: block;\"', 'style=\"display: block;\"', 'style=\"display: block;\"', 'style=\"display: block;\"'),
(2, 'Cliente', 'observações', 'style=\"display: none;\"', 'style=\"display: none;\"', 'style=\"display: none;\"', 'style=\"display: block;\"', 'style=\"display: none;\"', 'style=\"display: none;\"'),
(3, 'Fornecedor', 'observações', 'style=\"display: none;\"', 'style=\"display: none;\"', 'style=\"display: none;\"', 'style=\"display: none;\"', 'style=\"display: block;\"', 'style=\"display: none;\"'),
(4, 'Cliente / Fornecedor', 'observações', 'style=\"display: none;\"', 'style=\"display: none;\"', 'style=\"display: none;\"', 'style=\"display: none;\"', 'style=\"display: none;\"', 'style=\"display: block;\"'),
(5, 'Assistente', 'observações', 'style=\"display: block;\"', 'style=\"display: block;\"', 'style=\"display: block;\"', 'style=\"display: none;\"', 'style=\"display: none;\"', 'style=\"display: none;\"');



CREATE TABLE `tb_grupo` (
  `cd_grupo` int(11) NOT NULL,
  `titulo_grupo` varchar(40) DEFAULT NULL,
  `obs_grupo` varchar(999) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



INSERT INTO `tb_grupo` (`cd_grupo`, `titulo_grupo`, `obs_grupo`) VALUES
(1, 'Grupo 1', 'Grupo destinado as primeiras coisas'),
(2, 'Grupo 2', 'Grupo destinado as segundas coisas'),
(3, 'Grupo 3', 'Grupo destinado as terceiras coisas');

-- --------------------------------------------------------



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



INSERT INTO `tb_movimento_financeiro` (`cd_movimento`, `cd_caixa_movimento`, `cd_colab_movimento`, `cd_cliente_movimento`, `tipo_movimento`, `cd_os_movimento`, `fpag_movimento`, `valor_movimento`, `data_movimento`, `obs_movimento`) VALUES
(36, 18, 1, 3, 1, 8, 'DINHEIRO', 36.00, '2023-08-24 20:36:00', 'PAGAMENTO DA OS: 8'),
(35, 18, 1, 4, 1, 9, 'PIX', 165.00, '2023-08-24 20:32:00', 'PAGAMENTO DA OS: 9'),
(34, 17, 12, 3, 1, 10, 'DINHEIRO', 100.00, '2023-08-24 16:41:00', 'PAGAMENTO DA OS: 10'),
(33, 15, 9, 3, 1, 8, 'DINHEIRO', 30.00, '2023-08-24 05:53:00', 'PAGAMENTO DA OS: 8'),
(32, 14, 9, 3, 1, 8, 'DINHEIRO', 30.00, '2023-08-24 05:49:00', 'PAGAMENTO DA OS: 8'),
(31, 12, 9, 1, 1, 1, 'CREDITO', 143.00, '2023-08-24 04:58:00', 'PAGAMENTO DA OS: 1'),
(30, 12, 9, 1, 1, 3, 'PIX', 199.00, '2023-08-24 04:57:00', 'PAGAMENTO DA OS: 3'),
(26, 12, 9, 1, 1, 2, 'PIX', 139.00, '2023-08-24 04:56:00', 'PAGAMENTO DA OS: 2'),
(29, 12, 9, 3, 1, 7, 'CREDITO', 80.00, '2023-08-24 04:57:00', 'PAGAMENTO DA OS: 7'),
(28, 12, 9, 1, 1, 6, 'DINHEIRO', 120.00, '2023-08-24 04:57:00', 'PAGAMENTO DA OS: 6'),
(27, 12, 9, 2, 1, 5, 'CREDITO', 258.00, '2023-08-24 04:56:00', 'PAGAMENTO DA OS: 5'),
(38, 19, 1, 3, 1, 11, 'COFRE', 50.00, '2023-08-25 14:49:00', 'PAGAMENTO DA OS: 11'),
(39, 19, 1, NULL, 2, NULL, 'DINHEIRO', 50.00, '2023-08-25 14:53:00', 'SANGRIA: Teste'),
(40, 20, 1, 3, 1, 11, 'COFRE', 90.00, '2023-08-25 15:34:00', 'PAGAMENTO DA OS: 11'),
(41, 21, 1, 1, 1, 1, 'dinheiro', 30.00, '2023-08-26 04:27:00', 'PAGAMENTO DA OS: 1'),
(43, 26, 12, NULL, 3, NULL, 'DINHEIRO', 4.50, '2023-09-01 12:35:00', 'SANGRIA: Passagem '),
(44, 26, 12, NULL, 2, NULL, 'DINHEIRO', 10.00, '2023-09-01 12:35:00', 'SANGRIA: Fundo'),
(45, 26, 12, 6, 1, 15, 'pix', 200.00, '2023-09-01 12:40:00', 'PAGAMENTO DA OS: 15'),
(46, 26, 12, 6, 1, 15, 'dinheiro', 950.00, '2023-09-01 12:44:00', 'PAGAMENTO DA OS: 15'),
(47, 28, 1, 7, 1, 17, 'DINHEIRO', 100.00, '2023-09-08 14:54:00', 'PAGAMENTO DA OS: 17'),
(48, 28, 1, 7, 1, 17, 'debito', 40.00, '2023-09-08 14:54:00', 'PAGAMENTO DA OS: 17'),
(49, 29, 1, 1, 1, 2, 'dinheiro', 50.00, '2023-09-09 02:23:00', 'PAGAMENTO DA OS: 2'),
(50, 29, 1, 1, 1, 2, 'pix', 43.00, '2023-09-09 02:23:00', 'PAGAMENTO DA OS: 2'),
(51, 29, 1, 3, 1, 7, 'credito', 246.00, '2023-09-11 17:24:00', 'PAGAMENTO DA OS: 7'),
(52, 31, 1, 3, 1, 22, 'dinheiro', 45.00, '2023-10-11 09:52:00', 'PAGAMENTO DA OS: 22'),
(53, 32, 1, 3, 1, 24, 'dinheiro', 3.00, '2023-10-19 19:16:00', 'PAGAMENTO DA OS: 24'),
(54, 34, 1, 3, 1, 32, 'credito', 3.00, '2023-10-30 15:31:00', 'PAGAMENTO DA OS: 32'),
(55, 34, 1, 3, 1, 32, 'pix', 3.00, '2023-10-30 15:31:00', 'PAGAMENTO DA OS: 32'),
(56, 36, 1, 1, 1, 29, 'debito', 5.00, '2023-10-31 19:51:00', 'PAGAMENTO DA OS: 29'),
(57, 36, 1, 3, 1, 25, 'cofre', 1.00, '2023-10-31 19:52:00', 'PAGAMENTO DA OS: 25'),
(58, 38, 1, 1, 1, 1, 'dinheiro', 100.00, '2023-11-03 14:27:00', 'PAGAMENTO DA OS: 1'),
(59, 38, 1, 1, 1, 1, 'pix', 9.00, '2023-11-03 14:28:00', 'PAGAMENTO DA OS: 1'),
(60, 39, 1, 3, 1, 31, 'pix', 30.00, '2023-11-03 16:12:00', 'PAGAMENTO DA OS: 31'),
(61, 39, 1, 3, 1, 31, 'dinheiro', 2.00, '2023-11-03 16:12:00', 'PAGAMENTO DA OS: 31'),
(62, 39, 1, NULL, 3, NULL, 'DINHEIRO', 3.00, '2023-11-03 23:30:00', 'SANGRIA: teste'),
(63, 39, 1, NULL, 2, NULL, 'DINHEIRO', 5.00, '2023-11-03 23:40:00', 'SANGRIA: teste suprimento'),
(64, 39, 1, NULL, 3, NULL, 'DINHEIRO', 5.00, '2023-11-03 23:41:00', 'SANGRIA: teste sangria'),
(65, 41, 1, 1, 1, 1, 'credito', 50.00, '2023-11-10 14:49:00', 'PAGAMENTO DA OS: 1');



CREATE TABLE `tb_orcamento_servico` (
  `cd_orcamento` int(11) NOT NULL,
  `cd_servico` int(11) DEFAULT NULL,
  `cd_cliente` int(11) DEFAULT NULL,
  `titulo_orcamento` varchar(999) DEFAULT NULL,
  `vcusto_orcamento` varchar(40) DEFAULT NULL,
  `vpag_orcamento` varchar(40) DEFAULT NULL,
  `status_orcamento` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



INSERT INTO `tb_orcamento_servico` (`cd_orcamento`, `cd_servico`, `cd_cliente`, `titulo_orcamento`, `vcusto_orcamento`, `vpag_orcamento`, `status_orcamento`) VALUES
(37, 1, 1, 'Jacarre', '43', NULL, 0),
(3, 1, 1, 'Jaqueta', '58', NULL, 0),
(4, 1, 1, 'CarrÃ© ', '42', NULL, 0),
(5, 3, 1, 'Ydydhcjg', '50', NULL, 0),
(6, 3, 1, 'Ggghkk', '60', NULL, 0),
(7, 3, 1, 'Hjjjgdd', '65', NULL, 0),
(8, 3, 1, 'Dhfjbljlj', '24', NULL, 0),
(36, 4, 1, 'Teste', '2', NULL, 0),
(58, 8, 3, 'asasasasasasa', '10', NULL, 0),
(39, 2, 1, 'Vsvsbcm', '25', NULL, 0),
(41, 5, 2, 'Coruja de crochÃª ', '60', NULL, 0),
(42, 5, 2, 'Top de crochÃª cores mistas', '98', NULL, 0),
(43, 4, 1, 'Ncjcjcjfjf', '22', NULL, 0),
(51, 7, 3, 'Bainha de calca', '65', NULL, 0),
(46, 6, 1, 'Sfgbv', '2', NULL, 0),
(47, 6, 1, 'Wsdggh', '50', NULL, 0),
(48, 6, 1, 'Aasdvvhu', '36', NULL, 0),
(49, 6, 1, 'Ssrfg', '8', NULL, 0),
(50, 6, 1, 'Wsfgccg', '24', NULL, 0),
(52, 7, 3, 'BotÃ£o da camisa', '15', NULL, 0),
(53, 2, 1, 'Hdhdhfh', '50', NULL, 0),
(54, 2, 1, 'Hhgdddhhf', '58', NULL, 0),
(55, 2, 1, 'Jhhj', '6', NULL, 0),
(56, 0, 0, 'Hhgdddhhf', '58', NULL, 0),
(57, 5, 2, 'Hsggdv', '100', NULL, 0),
(59, 8, 3, 'asasasasasssssssssssss', '1', NULL, 0),
(60, 8, 3, 'rrrrrrrrrrrrrrrrrrrrrrrrrr', '50', NULL, 0),
(61, 8, 3, 'tttttttttttttttttttttttttt', '35', NULL, 0),
(62, 10, 3, 'Trocar tela', '250', NULL, 0),
(63, 10, 3, 'Trocar conector de carga', '25', NULL, 0),
(64, 10, 3, 'Trocar bateria', '89', NULL, 0),
(66, 9, 4, 'Formatar', '100', NULL, 0),
(67, 9, 4, 'Trocar memoria', '65', NULL, 0),
(68, 11, 3, 'Bgffg', '50', NULL, 0),
(69, 11, 3, 'Uijh', '55', NULL, 0),
(70, 11, 3, 'Gghjj', '45', NULL, 0),
(71, 13, 3, 'Fufjf', '3', NULL, 0),
(72, 13, 3, 'Hcbcncjfjf', '2', NULL, 0),
(73, 14, 3, 'Hchcncjvjgkhlho', '25', NULL, 0),
(74, 14, 3, 'Jvkljljljljl', '15', NULL, 0),
(75, 1, 1, 'Gggg', '69', NULL, 0),
(76, 1, 1, 'Dddd', '70', NULL, 0),
(77, 12, 5, 'ssdssdfsdfsdfsdf', '12', NULL, 0),
(78, 12, 5, 'qweqweqweqweqweqwe', '50', NULL, 0),
(79, 15, 6, 'Troca de fonte', '500', NULL, 0),
(80, 15, 6, 'Hm', '250', NULL, 0),
(81, 15, 6, 'MemÃ³ria ', '400', NULL, 0),
(82, 16, 3, 'Trocar memlria', '120', NULL, 0),
(83, 17, 7, 'Backup detalhado', '90', NULL, 0),
(84, 17, 7, 'Formatar', '50', NULL, 0),
(85, 17, 7, 'Sdfg', '3', NULL, 0),
(86, 2, 1, 'Ggg', '35', NULL, 0),
(87, 2, 1, 'Gagagaghas', '58', NULL, 0),
(88, 7, 3, 'Cbcncncbcb', '123', NULL, 0),
(89, 7, 3, 'Cbcncncbcb', '123', NULL, 0),
(90, 18, 6, 'Troca de placa', '300000', NULL, 0),
(91, 18, 6, 'MemÃ³ria ', '150000000000', NULL, 0),
(92, 19, 3, 'Ojzowhdwkhdkq', '58', NULL, 0),
(93, 19, 3, 'Ghjj', '60', NULL, 0),
(94, 20, 3, 'teste 1', '50', NULL, 0),
(95, 20, 3, 'teste1', '33', NULL, 0),
(96, 21, 1, 'teste 2', '56', NULL, 0),
(97, 21, 1, 'teste 2s', '52', NULL, 0),
(98, 22, 3, 'Trocar rolamento', '30', NULL, 0),
(99, 22, 3, 'LubrificaÃ§Ã£o ', '15', NULL, 0),
(100, 23, 3, 'NakaldltjfndhziLebfnfjflslsmsvdvdycycizlLamavebdhcycuslsle dbcyv', '150', NULL, 0),
(101, 24, 3, 'Agagagaga', '30', NULL, 0),
(102, 24, 3, 'Ggagaahaaaha', '50', NULL, 0),
(103, 25, 3, 'os 25 teste 1', '1', NULL, 0),
(104, 26, 1, 'os 26 teste 2', '2', NULL, 0),
(105, 27, 1, 'teste 3', '3', NULL, 0),
(108, 29, 1, 'teste 5 os 29', '5', NULL, 0),
(107, 28, 3, 'teste 4 os 28', '4', NULL, 0),
(109, 30, 3, 'Teste 10 os 30', '30', NULL, 0),
(110, 32, 3, 'Testeeee', '6', NULL, 0),
(111, 31, 3, 'Ubuvuvu', '38', NULL, 0),
(112, 31, 3, 'Hhjjl', '1', NULL, 0),
(113, 1, 1, 'Ttt', '50', NULL, 0),
(114, 2, 1, 'Ttt', '3', NULL, 0),
(115, 36, 10, 'asasasasas', '111', NULL, 0);



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



INSERT INTO `tb_prod_serv` (`cd_prod_serv`, `cd_classe_fiscal`, `cd_grupo`, `cdbarras_prod_serv`, `titulo_prod_serv`, `obs_prod_serv`, `tipo_prod_serv`, `preco_prod_serv`, `custo_prod_serv`, `status_prod_serv`) VALUES
(1, 1, 1, '789123123789', 'produto 1', 'primeira linha de produto', 1, 50.00, 25.00, 1),
(2, 1, 1, '789123123790', 'produto 2', 'primeira linha de produto', 1, 20.00, 10.00, 1),
(3, 1, 2, '789123123791', 'produto 3', 'Segunda linha de produto', 1, 40.00, 20.00, 1),
(4, 1, 2, '789123123792', 'produto 4', 'Segunda linha de produto', 1, 80.00, 40.00, 1),
(5, 0, 0, '789123123793', 'produto', 'Terceira linha de produto', 0, 90.00, 45.00, 0),
(6, 1, 3, '789123123794', 'produto 6', 'Terceira linha de Servico', 2, 30.00, 15.00, 1);



CREATE TABLE `tb_seguranca` (
  `cd_seg` int(11) NOT NULL,
  `titulo_seg` varchar(200) DEFAULT NULL,
  `obs_seg` varchar(40) DEFAULT NULL,
  `cd_colab` varchar(40) DEFAULT NULL,
  `empresa` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `tb_seguranca` (`cd_seg`, `titulo_seg`, `obs_seg`, `cd_colab`, `empresa`) VALUES
(1, 'master', 'User Master', '1', '1');



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



INSERT INTO `tb_servico` (`cd_servico`, `cd_cliente`, `titulo_servico`, `obs_servico`, `prioridade_servico`, `entrada_servico`, `prazo_servico`, `orcamento_servico`, `vpag_servico`, `status_servico`) VALUES
(1, 1, '', 'Ggg', 'U', '2023-08-22T17:14', '2023-09-03T18:28', '332', 332.00, '3'),
(2, 1, '', 'Ggdd', 'U', '2023-08-22T17:31', '2024-01-30T13:09', '235', 232.00, '0'),
(3, 1, '', 'Hvjvkhpiouiturhcjvojpj', 'U', '2023-08-22T17:32', '2023-09-01T12:47', '199', 199.00, '2'),
(4, 1, '', 'Fazer pururuca', 'U', '2023-08-23T02:44', '2023-08-31T23:39', '24', NULL, '1'),
(5, 2, '', 'Fazer crochÃª ', 'B', '2023-08-23T14:13', '2023-08-30T03:18', '258', 258.00, '1'),
(6, 1, '', 'Ddghg', 'U', '2023-08-23T17:07', '2023-12-24T23:40', '120', 120.00, '1'),
(7, 3, '', 'Consertos', 'U', '2023-08-23T20:24', '2023-09-09T14:11', '326', 326.00, '3'),
(8, 3, '', 'teste', 'B', '2023-08-24T05:48', '2023-08-31T23:43', '96', 96.00, '1'),
(9, 4, '', 'FormataÃ§Ã£o pc', 'U', '2023-08-24T16:30', '2023-09-01T12:44', '165', 165.00, '1'),
(10, 3, '', 'DescriÃ§Ã£o J5 pro', 'B', '2023-08-24T16:40', '2023-09-01T23:41', '364', 100.00, '1'),
(11, 3, '', 'Ggg', 'U', '2023-08-25T14:40', '2023-11-19T12:46', '150', 140.00, '1'),
(12, 5, '', 'Jajsjdkck', 'U', '2023-08-26T00:48', '2023-09-01T12:46', '62', 0.00, '1'),
(13, 3, '', 'Hchchxbcb', 'U', '2023-08-26T01:59', '2023-09-01T12:43', '5', 0.00, '1'),
(14, 3, '', 'Hfufufhc', 'U', '2023-08-26T02:27', '', '40', 0.00, '2'),
(15, 6, '', 'Servidor queimou', 'U', '2023-09-01T12:38', '2023-09-01T12:47', '1150', 1150.00, '3'),
(16, 3, '', 'PC parou', 'U', '2023-09-01T18:13', '2023-09-01T16:00', '120', 0.00, '1'),
(17, 7, '', 'Formatar', 'U', '2023-09-08T14:53', '2023-09-13T16:00', '143', 140.00, '2'),
(18, 6, '', 'Queimou', 'A', '2023-09-13T12:42', '2023-09-18T16:00', '150000300000', 0.00, '1'),
(19, 3, '', 'Jzbzabzkwbxkqd', 'U', '2023-09-20T18:09', '2023-09-25T16:00', '118', 0.00, '4'),
(20, 3, '', 'teste1', 'B', '2023-10-01T10:49', '2023-12-07T16:00', '83', 0.00, '0'),
(21, 1, '', 'teste 2', 'M', '2023-10-01T10:51', '2023-11-26T16:00', '108', 0.00, '0'),
(22, 3, '', 'Teste', 'B', '2023-10-11T09:51', '2023-10-16T16:00', '45', 45.00, '0'),
(23, 3, '', 'Teste', 'U', '2023-10-17T22:42', '2023-11-22T16:00', '150', 0.00, '0'),
(24, 3, '', 'TESTEEER', 'U', '2023-10-19T19:16', '2023-12-24T16:00', '80', 3.00, '0'),
(25, 3, '', 'teste 1', 'B', '2023-10-23T19:01', '2024-10-24T16:00', '1', 1.00, '0'),
(26, 1, '', 'teste 2', 'M', '2023-10-23T19:03', '2023-10-25T16:00', '2', 0.00, '0'),
(27, 1, '', 'teste 3', 'A', '2023-10-23T19:26', '2023-11-19T16:00', '3', 0.00, '0'),
(28, 3, '', 'teste 4', 'U', '2023-10-23T19:33', '2023-11-18T16:00', '4', 0.00, '0'),
(29, 1, '', 'teste 5', 'B', '2023-10-23T19:37', '2023-10-28T16:00', '5', 5.00, '2'),
(30, 3, '', 'Teste 10', 'U', '2023-10-26T08:45', '2023-10-31T16:00', '30', 0.00, '4'),
(31, 3, '', 'Teste de hora', 'U', '2023-10-30T14:05', '2024-10-30T14:05', '39', 32.00, '0'),
(32, 3, '', 'Ttt', 'A', '2023-10-30T15:31', '2023-11-30T15:31', '6', 6.00, '0'),
(33, 3, '', 'Ttt', 'M', '2023-10-30T19:17', '2023-10-30T19:45', '', 0.00, '0'),
(34, 3, '', 'Tt', 'M', '2023-10-30T19:25', '2023-12-08T20:51', '', 0.00, '0'),
(35, 3, '', 'teste', 'A', '2023-10-30T20:06', '2023-11-05T16:00', '', 0.00, '2'),
(36, 10, '', 'aaa', 'M', '2023-11-21T11:41', '2023-11-26T16:00', '111', 0.00, '0'),
(37, 11, '', 'Teste', 'A', '2023-11-28T08:32', '2023-12-05T16:00', '', 0.00, '0'),
(38, 11, '', 'Teste', 'U', '2023-11-28T08:33', '2023-12-05T16:00', '', 0.00, '0'),
(39, 12, '', 'Tt', 'A', '2023-11-28T08:33', '2023-12-05T16:00', '', 0.00, '0'),
(40, 13, '', 'Teste', 'B', '2023-11-28T08:34', '2023-12-05T16:00', '', 0.00, '0'),
(41, 14, '', 'Teste', 'M', '2023-11-28T18:38', '2023-12-05T16:00', '', 0.00, '0');


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


ALTER TABLE `tb_classe_fiscal`
  ADD PRIMARY KEY (`cd_classe_fiscal`);


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


ALTER TABLE `tb_grupo`
  ADD PRIMARY KEY (`cd_grupo`);


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


ALTER TABLE `tb_prod_serv`
  ADD PRIMARY KEY (`cd_prod_serv`),
  ADD KEY `fk_tb_prod_serv1` (`cd_classe_fiscal`),
  ADD KEY `fk_tb_prod_serv2` (`cd_grupo`);


ALTER TABLE `tb_seguranca`
  ADD PRIMARY KEY (`cd_seg`);


ALTER TABLE `tb_servico`
  ADD PRIMARY KEY (`cd_servico`),
  ADD KEY `fk_rel_cliente` (`cd_cliente`);


ALTER TABLE `fl_ponto`
  MODIFY `token_alter` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `rel_user`
  MODIFY `token_alter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;


ALTER TABLE `tb_atividade`
  MODIFY `cd_atividade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;


ALTER TABLE `tb_caixa`
  MODIFY `cd_caixa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;


ALTER TABLE `tb_caixa_conferido`
  MODIFY `cd_caixa_conferido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;


ALTER TABLE `tb_caixa_dia_fiscal`
  MODIFY `cd_caixa_dia_fiscal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;


ALTER TABLE `tb_classe_fiscal`
  MODIFY `cd_classe_fiscal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `tb_cliente`
  MODIFY `cd_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;


ALTER TABLE `tb_colab`
  MODIFY `cd_colab` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;


ALTER TABLE `tb_empresa`
  MODIFY `cd_empresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `tb_estilo`
  MODIFY `cd_estilo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


ALTER TABLE `tb_filial`
  MODIFY `cd_filial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `tb_funcao`
  MODIFY `cd_funcao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;


ALTER TABLE `tb_grupo`
  MODIFY `cd_grupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


ALTER TABLE `tb_movimento_financeiro`
  MODIFY `cd_movimento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;


ALTER TABLE `tb_orcamento_servico`
  MODIFY `cd_orcamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;


ALTER TABLE `tb_prod_serv`
  MODIFY `cd_prod_serv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;


ALTER TABLE `tb_seguranca`
  MODIFY `cd_seg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `tb_servico`
  MODIFY `cd_servico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;


ALTER TABLE `fl_ponto`
  ADD CONSTRAINT `fk_fl_ponto1` FOREIGN KEY (`cdcolab_ponto`) REFERENCES `tb_colab` (`cd_colab`),
  ADD CONSTRAINT `fk_fl_ponto2` FOREIGN KEY (`cdempresa_ponto`) REFERENCES `tb_empresa` (`cd_empresa`);


ALTER TABLE `rel_user`
  ADD CONSTRAINT `fk_rel_user1` FOREIGN KEY (`cd_seg`) REFERENCES `tb_seguranca` (`cd_seg`),
  ADD CONSTRAINT `fk_rel_user2` FOREIGN KEY (`cd_colab`) REFERENCES `tb_colab` (`cd_colab`),
  ADD CONSTRAINT `fk_rel_user3` FOREIGN KEY (`cd_estilo`) REFERENCES `tb_estilo` (`cd_estilo`),
  ADD CONSTRAINT `fk_rel_user4` FOREIGN KEY (`cd_funcao`) REFERENCES `tb_funcao` (`cd_funcao`),
  ADD CONSTRAINT `fk_rel_user5` FOREIGN KEY (`cd_empresa`) REFERENCES `tb_empresa` (`cd_empresa`);


ALTER TABLE `tb_empresa`
  ADD CONSTRAINT `fk_rel_empresa1` FOREIGN KEY (`cd_ceo`) REFERENCES `tb_colab` (`cd_colab`);
COMMIT;

