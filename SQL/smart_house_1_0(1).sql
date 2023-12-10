-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 14-Out-2022 às 21:20
-- Versão do servidor: 8.0.31
-- versão do PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `smart_house_1_0`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `casas`
--

CREATE TABLE `casas` (
  `id_casa` int NOT NULL,
  `endereco_casa` varchar(40) DEFAULT NULL,
  `cep_casa` varchar(40) DEFAULT NULL,
  `bairro_casa` varchar(40) DEFAULT NULL,
  `rua_casa` varchar(40) DEFAULT NULL,
  `numero_casa` varchar(40) DEFAULT NULL,
  `complemento_casa` varchar(40) DEFAULT NULL,
  `senha_casa` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `casas`
--

INSERT INTO `casas` (`id_casa`, `endereco_casa`, `cep_casa`, `bairro_casa`, `rua_casa`, `numero_casa`, `complemento_casa`, `senha_casa`) VALUES
(1, 'Curicica', '22780805', 'Curicica', 'João Bruno Lobo', '291A', 'Casa 1', 'asd'),
(2, 'Recreio dos Bandeirantes', '22790495', 'Recreio dos Bandeirantes', 'Rua da servidão G7', '8', '301', 'asd'),
(3, 'TURIAÇU', '21540000', 'TURIAÇU', 'TURIAÇU', '22', '1A', 'carlos94'),
(5, 'Pechincha', '22743050', 'Pechincha', 'Estrada do Pau-Ferro', '103', 'APT 108', 'TESTE123'),
(6, 'Barra da Tijuca', '22631003', 'Barra da Tijuca', 'Avenida das américas', '3959', 'LJ 122', 'asd');

-- --------------------------------------------------------

--
-- Estrutura da tabela `casa_morador`
--

CREATE TABLE `casa_morador` (
  `id_casa` int DEFAULT NULL,
  `id_morador` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `casa_morador`
--

INSERT INTO `casa_morador` (`id_casa`, `id_morador`) VALUES
(5, 21),
(1, 21),
(1, 22),
(1, 23),
(6, 22),
(1, 25),
(1, 24),
(2, 24);

-- --------------------------------------------------------

--
-- Estrutura da tabela `dispositivos`
--

CREATE TABLE `dispositivos` (
  `id_dispositivo` int NOT NULL,
  `mac_dispositivo` varchar(40) DEFAULT NULL,
  `ip_dispositivo` varchar(40) DEFAULT NULL,
  `grupo_dispositivo` varchar(40) DEFAULT NULL,
  `modelo_dispositivo` varchar(40) DEFAULT NULL,
  `comodo_dispositivo` varchar(40) DEFAULT NULL,
  `id_casa` int DEFAULT NULL,
  `status_dispositivo1` int DEFAULT NULL,
  `status_dispositivo2` int DEFAULT NULL,
  `status_dispositivo3` int DEFAULT NULL,
  `status_dispositivo4` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `dispositivos`
--

INSERT INTO `dispositivos` (`id_dispositivo`, `mac_dispositivo`, `ip_dispositivo`, `grupo_dispositivo`, `modelo_dispositivo`, `comodo_dispositivo`, `id_casa`, `status_dispositivo1`, `status_dispositivo2`, `status_dispositivo3`, `status_dispositivo4`) VALUES
(506, '30:83:98:A2:27:3E', '192.168.1.6', 'NULL', 'LV2', 'NULL', 1, 1, 1, NULL, NULL),
(507, '30:83:98:A2:53:2A', '192.168.1.2', 'NULL', 'LV2', 'NULL', 1, 1, 1, NULL, NULL),
(508, 'C8:C9:A3:69:9D:02', '192.168.1.7', 'NULL', 'LV2', 'NULL', NULL, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `moradores`
--

CREATE TABLE `moradores` (
  `id_morador` int NOT NULL,
  `fnome_morador` varchar(40) DEFAULT NULL,
  `cpf_morador` varchar(40) DEFAULT NULL,
  `email_morador` varchar(40) DEFAULT NULL,
  `tel_morador` varchar(40) DEFAULT NULL,
  `dt_nasc_morador` varchar(40) DEFAULT NULL,
  `senha_morador` varchar(40) DEFAULT NULL,
  `id_casa_morador` int DEFAULT NULL,
  `snome_morador` varchar(40) DEFAULT NULL,
  `foto_morador` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `moradores`
--

INSERT INTO `moradores` (`id_morador`, `fnome_morador`, `cpf_morador`, `email_morador`, `tel_morador`, `dt_nasc_morador`, `senha_morador`, `id_casa_morador`, `snome_morador`, `foto_morador`) VALUES
(20, 'Wesley', 'NULL', 'wesleyromaodossantos@gmail.com', 'NULL', 'NULL', 'NULL', NULL, 'Romão dos Santos', 'https://lh3.googleusercontent.com/a-/ACNPEu_yzRLwi-Gvpr7ZqJQEmIoxSPbk6ara5E6OGpx4UYE=s96-c'),
(21, 'João', 'NULL', 'vitor12822@gmail.com', 'NULL', 'NULL', 'NULL', NULL, 'vitor', 'https://lh3.googleusercontent.com/a/ALm5wu2P6ZQRsLElItYCWUU_JHIuwI94aPReB5miwGWrVA=s96-c'),
(22, 'Gabriel', '05185255544', 'amorimgg7@gmail.com', '21965543094', '27/09/2000', 'asd,123', NULL, 'Amorim', 'https://lh3.googleusercontent.com/a-/ACNPEu_16EHFuoKR4OZJfJ9uOWfcPq_tDF7xIR4YHcL4eo8=s96-c'),
(23, 'newchoice', 'NULL', 'newchoicemanut@gmail.com', 'NULL', 'NULL', 'NULL', NULL, 'manutenção', 'https://lh3.googleusercontent.com/a/ALm5wu1YXX6lvdKMCBTV0BkFdk0bOq_PSDw902mStUG6=s96-c'),
(24, 'Gabriel', 'NULL', 'amorinfor@gmail.com', 'NULL', 'NULL', 'NULL', NULL, 'Amorim', 'https://lh3.googleusercontent.com/a-/ACNPEu8X7q7HNAiKMaYdjuLpwAb2fHJFwB4HoEBE46pL=s96-c'),
(25, 'Maria da Luz', '96300736504', 'malu.atelie.moda.praia@gmail.com', '21981256308', '02/02/1977', '123', NULL, 'Gomes da Silva', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id_prod` int NOT NULL,
  `nome_prod` char(40) DEFAULT NULL,
  `obs_prod` char(100) DEFAULT NULL,
  `val_prod` char(10) DEFAULT NULL,
  `ft_prod` char(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id_prod`, `nome_prod`, `obs_prod`, `val_prod`, `ft_prod`) VALUES
(0, 'Produto um', 'Este é o primeiro produto do meu site!', '60,00', 'https://lh3.googleusercontent.com/pw/AL9nZEXZ-JzGGHj9AMS0wCkTnXEVE3xvMq9kccrXImkej82q9gAt4RdtZ7LUXe8Tcg1qIOnK2juVpQ7qeHQ7xw3-AadCxwpRIGq_3LW4ry5r940B1ArdZ6jovOZOdOn4olJYGUdTJbn1fAw5z-cWYjcxlaZT0Q=w272-h273-no?authuser=0'),
(1, 'Produto dois', 'Este é o segundo produto do meu catálogo!', '150,00', 'https://lh3.googleusercontent.com/pw/AL9nZEXZ-JzGGHj9AMS0wCkTnXEVE3xvMq9kccrXImkej82q9gAt4RdtZ7LUXe8Tcg1qIOnK2juVpQ7qeHQ7xw3-AadCxwpRIGq_3LW4ry5r940B1ArdZ6jovOZOdOn4olJYGUdTJbn1fAw5z-cWYjcxlaZT0Q=w272-h273-no?authuser=0');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `casas`
--
ALTER TABLE `casas`
  ADD PRIMARY KEY (`id_casa`);

--
-- Índices para tabela `casa_morador`
--
ALTER TABLE `casa_morador`
  ADD KEY `id_casa` (`id_casa`),
  ADD KEY `id_morador` (`id_morador`);

--
-- Índices para tabela `dispositivos`
--
ALTER TABLE `dispositivos`
  ADD PRIMARY KEY (`id_dispositivo`),
  ADD KEY `fk_casaDispositivos` (`id_casa`);

--
-- Índices para tabela `moradores`
--
ALTER TABLE `moradores`
  ADD PRIMARY KEY (`id_morador`);

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id_prod`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `casas`
--
ALTER TABLE `casas`
  MODIFY `id_casa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `dispositivos`
--
ALTER TABLE `dispositivos`
  MODIFY `id_dispositivo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=509;

--
-- AUTO_INCREMENT de tabela `moradores`
--
ALTER TABLE `moradores`
  MODIFY `id_morador` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id_prod` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `casa_morador`
--
ALTER TABLE `casa_morador`
  ADD CONSTRAINT `casa_morador_ibfk_1` FOREIGN KEY (`id_casa`) REFERENCES `casas` (`id_casa`) ON DELETE CASCADE,
  ADD CONSTRAINT `casa_morador_ibfk_2` FOREIGN KEY (`id_morador`) REFERENCES `moradores` (`id_morador`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `dispositivos`
--
ALTER TABLE `dispositivos`
  ADD CONSTRAINT `dispositivos_ibfk_1` FOREIGN KEY (`id_casa`) REFERENCES `casas` (`id_casa`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
