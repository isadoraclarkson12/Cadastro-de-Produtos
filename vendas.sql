-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2020 at 06:52 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vendas`
--

-- --------------------------------------------------------

--
-- Table structure for table `cadastro`
--

CREATE TABLE `cadastro` (
  `id_cadastro` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `endereco` varchar(100) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cep` varchar(100) DEFAULT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `cpf` varchar(100) DEFAULT NULL,
  `rg` varchar(100) DEFAULT NULL,
  `data_nasc` date DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cadastro`
--

INSERT INTO `cadastro` (`id_cadastro`, `nome`, `endereco`, `bairro`, `cep`, `complemento`, `cpf`, `rg`, `data_nasc`, `cidade`, `uf`) VALUES
(2, 'Maria Oliveira', '', '', '2323354', '', '2483474747574', '353432423424', '1996-03-01', '', 'MT'),
(3, 'Jose faria', '', '', '', '', '', '', '1996-02-02', '', NULL),
(4, 'Maria Oliveira', '', '', '', '', '', '', '2002-03-01', 'Uberaba', NULL),
(5, 'Maria Oliveira', '', '', '', '', '', '', '2002-03-01', '', NULL),
(7, 'Master User', '', '', '', '', '', '', '2020-04-14', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `produto`
--

CREATE TABLE `produto` (
  `id_produto` int(11) NOT NULL,
  `descricao` varchar(100) DEFAULT NULL,
  `variacao_cor` char(1) NOT NULL,
  `valor` decimal(5,2) DEFAULT NULL,
  `id_situacao` int(11) DEFAULT NULL,
  `cor` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `produto`
--

INSERT INTO `produto` (`id_produto`, `descricao`, `variacao_cor`, `valor`, `id_situacao`, `cor`) VALUES
(4, 'Calça Jeans', 'N', '30.00', 1, 'aqua'),
(5, 'Moletom', 'N', '30.00', 1, NULL),
(8, 'MACACÃO', 'S', '32.00', 1, 'blueviolet'),
(9, 'CAMISETA JEANS', 'S', '50.00', 1, 'pink'),
(10, 'CAMISETA JEANS', 'S', '33.00', 1, NULL),
(11, 'Papel celofane', 'S', '5.00', 1, NULL),
(12, 'MOLETOM CINZA', 'N', '30.00', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `produto_cor`
--

CREATE TABLE `produto_cor` (
  `id_produto_cor` bigint(20) NOT NULL,
  `descricao` varchar(100) DEFAULT NULL,
  `id_produto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `produto_cor`
--

INSERT INTO `produto_cor` (`id_produto_cor`, `descricao`, `id_produto`) VALUES
(1, 'green', 5),
(5, 'aqua', 10),
(6, 'white', 10),
(7, 'gray', 10),
(8, 'white', 9),
(9, 'brown', 9),
(10, 'beige', 8),
(11, 'orange', 8),
(12, 'maroon', 8),
(13, 'aqua', 11),
(14, 'yellow', 11),
(15, 'brown', 11),
(16, 'lightsalmon', 11);

-- --------------------------------------------------------

--
-- Table structure for table `situacao`
--

CREATE TABLE `situacao` (
  `id_situacao` int(11) NOT NULL,
  `descricao` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `situacao`
--

INSERT INTO `situacao` (`id_situacao`, `descricao`) VALUES
(1, 'Ativo'),
(2, 'Inativo'),
(3, 'Em falta');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `id_tipo_usuario` int(11) NOT NULL,
  `descricao` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id_tipo_usuario`, `descricao`) VALUES
(1, 'Master'),
(2, 'Comum');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` bigint(20) NOT NULL,
  `id_cadastro` int(11) DEFAULT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `senha` varchar(200) DEFAULT NULL,
  `id_situacao` int(11) DEFAULT NULL,
  `id_tipo_usuario` int(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `id_cadastro`, `usuario`, `senha`, `id_situacao`, `id_tipo_usuario`, `email`) VALUES
(2, 2, 'maria13', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 1, 1, 'maria@teste.com'),
(3, 3, 'jose123', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 1, 1, 'teste@teste.com'),
(7, 7, 'master', 'fc613b4dfd6736a7bd268c8a0e74ed0d1c04a959f59dd74ef2874983fd443fc9', 1, 1, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cadastro`
--
ALTER TABLE `cadastro`
  ADD PRIMARY KEY (`id_cadastro`);

--
-- Indexes for table `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id_produto`),
  ADD KEY `produto_situacao_pk` (`id_situacao`);

--
-- Indexes for table `produto_cor`
--
ALTER TABLE `produto_cor`
  ADD PRIMARY KEY (`id_produto_cor`),
  ADD KEY `fk_produto` (`id_produto`);

--
-- Indexes for table `situacao`
--
ALTER TABLE `situacao`
  ADD PRIMARY KEY (`id_situacao`);

--
-- Indexes for table `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`id_tipo_usuario`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `usuario_situacao_pk` (`id_situacao`),
  ADD KEY `usuario_tipo_usuario` (`id_tipo_usuario`),
  ADD KEY `usuario_cadastro_pk` (`id_cadastro`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cadastro`
--
ALTER TABLE `cadastro`
  MODIFY `id_cadastro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `produto`
--
ALTER TABLE `produto`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `produto_cor`
--
ALTER TABLE `produto_cor`
  MODIFY `id_produto_cor` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `situacao`
--
ALTER TABLE `situacao`
  MODIFY `id_situacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `id_tipo_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `produto_situacao_pk` FOREIGN KEY (`id_situacao`) REFERENCES `situacao` (`id_situacao`);

--
-- Constraints for table `produto_cor`
--
ALTER TABLE `produto_cor`
  ADD CONSTRAINT `fk_produto` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`);

--
-- Constraints for table `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_cadastro_pk` FOREIGN KEY (`id_cadastro`) REFERENCES `cadastro` (`id_cadastro`),
  ADD CONSTRAINT `usuario_situacao_pk` FOREIGN KEY (`id_situacao`) REFERENCES `situacao` (`id_situacao`),
  ADD CONSTRAINT `usuario_tipo_usuario` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipo_usuario` (`id_tipo_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
