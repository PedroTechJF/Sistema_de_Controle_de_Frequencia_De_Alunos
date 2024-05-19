SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

DROP DATABASE IF EXISTS `sis_control_freq_alu`;
CREATE DATABASE IF NOT EXISTS `sis_control_freq_alu` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `sis_control_freq_alu`;

CREATE TABLE `empresas` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cnpj` varchar(14) NOT NULL,
  `telefone` varchar(14) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cep` varchar(8) NOT NULL,
  `logradouro` varchar(100) NOT NULL,
  `num` varchar(10) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `escolas` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cnpj` varchar(14) NOT NULL,
  `telefone` varchar(14) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cep` varchar(8) NOT NULL,
  `logradouro` varchar(100) NOT NULL,
  `num` varchar(10) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `relatorios` (
  `id` int(11) NOT NULL,
  `mes` int(11) NOT NULL,
  `ano` int(11) NOT NULL,
  `local_arquivo` varchar(100) NOT NULL,
  `data_criacao` date NOT NULL,
  `empresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `usuarios_empresas` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `senha` varchar(32) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `empresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `usuarios_escolas` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `senha` varchar(32) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `escola_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cnpj` (`cnpj`),
  ADD UNIQUE KEY `telefone` (`telefone`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `escolas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cnpj` (`cnpj`),
  ADD UNIQUE KEY `telefone` (`telefone`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `relatorios`
  ADD PRIMARY KEY (`id`,`empresa_id`),
  ADD KEY `fk_relatorio_empresa1_idx` (`empresa_id`);

ALTER TABLE `usuarios_empresas`
  ADD PRIMARY KEY (`id`,`empresa_id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `fk_usuarios_empresa_empresa1_idx` (`empresa_id`);

ALTER TABLE `usuarios_escolas`
  ADD PRIMARY KEY (`id`,`escola_id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `fk_usuarios_escola_escola_idx` (`escola_id`);


ALTER TABLE `empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `escolas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `relatorios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `usuarios_empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `usuarios_escolas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `relatorios`
  ADD CONSTRAINT `fk_relatorio_empresa1` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `usuarios_empresas`
  ADD CONSTRAINT `fk_usuarios_empresa_empresa1` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `usuarios_escolas`
  ADD CONSTRAINT `fk_usuarios_escola_escola` FOREIGN KEY (`escola_id`) REFERENCES `escolas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
