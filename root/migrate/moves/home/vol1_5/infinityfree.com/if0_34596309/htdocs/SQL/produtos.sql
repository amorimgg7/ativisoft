-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29-Set-2022 às 02:06
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 7.4.29

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
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id_prod` integer PRIMARY KEY AUTO_INCREMENT,
  `nome_prod` char(40) DEFAULT NULL,
  `obs_prod` char(100) DEFAULT NULL,
  `val_prod` char(10) DEFAULT NULL,
  `ft_prod` char(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id_prod`, `nome_prod`, `obs_prod`, `val_prod`, `ft_prod`) VALUES
(0, 'Produto um', 'Este é o primeiro produto do meu site!', '60,00', 'https://lh3.googleusercontent.com/pw/AL9nZEXZ-JzGGHj9AMS0wCkTnXEVE3xvMq9kccrXImkej82q9gAt4RdtZ7LUXe8Tcg1qIOnK2juVpQ7qeHQ7xw3-AadCxwpRIGq_3LW4ry5r940B1ArdZ6jovOZOdOn4olJYGUdTJbn1fAw5z-cWYjcxlaZT0Q=w272-h273-no?authuser=0');

INSERT INTO `produtos` (`id_prod`, `nome_prod`, `obs_prod`, `val_prod`, `ft_prod`) VALUES
(1, 'Produto dois', 'Este é o segundo produto do meu catálogo, espero que goste. Fique a vontade para entrar em contato e tirar suas dúvidas!', '150,00', 'https://lh3.googleusercontent.com/pw/AL9nZEXZ-JzGGHj9AMS0wCkTnXEVE3xvMq9kccrXImkej82q9gAt4RdtZ7LUXe8Tcg1qIOnK2juVpQ7qeHQ7xw3-AadCxwpRIGq_3LW4ry5r940B1ArdZ6jovOZOdOn4olJYGUdTJbn1fAw5z-cWYjcxlaZT0Q=w272-h273-no?authuser=0');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id_prod`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
