-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 18-Jan-2020 às 22:54
-- Versão do servidor: 5.7.28-cll-lve
-- versão do PHP: 7.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `hotel`
--

-- --------------------------------------------------------

CREATE TABLE `chat` (
  `id_chat` int(11) NOT NULL,
  `id_remetente` int(11) NOT NULL,
  `id_destinatario` int(11) NOT NULL,
  `is_media` int(1) DEFAULT '0',
  `caminho_media` varchar(1000) DEFAULT NULL,
  `mensagem` varchar(500) DEFAULT NULL,
  `data_envio` datetime DEFAULT CURRENT_TIMESTAMP,
  `visualizado` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `codigoconfirmacao`
--

CREATE TABLE `codigoconfirmacao` (
  `id_codigo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `tipo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `contato`
--

CREATE TABLE `contato` (
  `id_contato` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `motivo` varchar(50) DEFAULT NULL,
  `mensagem` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `destinatarionotificacao`
--

CREATE TABLE `destinatarionotificacao` (
  `id_dest_not` int(11) NOT NULL,
  `id_notificacao` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `notificacao`
--

CREATE TABLE `notificacao` (
  `id_notificacao` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `body` varchar(500) DEFAULT NULL,
  `imageUrl` varchar(150) DEFAULT NULL,
  `id_agendamento` int(11) DEFAULT NULL,
  `urlDestino` varchar(150) DEFAULT NULL,
  `prioridade` int(11) DEFAULT '0',
  `mensagemGeral` int(11) DEFAULT '0',
  `data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `enviado` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



--
-- Estrutura da tabela `trocasenha`
--

CREATE TABLE `trocasenha` (
  `id_troSenha` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `hora` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(70) NOT NULL,
  `senha` varchar(100) DEFAULT NULL,
  `cpf` varchar(15) DEFAULT NULL,
  `email` varchar(70) DEFAULT NULL,
  `telefone` varchar(50) DEFAULT NULL,
  `data_nasc` date DEFAULT NULL,
  `foto` varchar(150) DEFAULT NULL,
  `token` varchar(500) DEFAULT NULL,
  `data_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `email_confirmado` int(1) NOT NULL DEFAULT '1',
  `telefone_confirmado` int(1) NOT NULL DEFAULT '1',
  `administrador` int(1) NOT NULL,
  `ativo` int(1) NOT NULL,
  `deletado` int(1) NOT NULL,
  `facebook_id` varchar(150) NOT NULL,
  `is_foto_url` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




--
-- Índices para tabela `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id_chat`),
  ADD KEY `id_remetente` (`id_remetente`),
  ADD KEY `id_destinatario` (`id_destinatario`);

--
-- Índices para tabela `codigoconfirmacao`
--
ALTER TABLE `codigoconfirmacao`
  ADD PRIMARY KEY (`id_codigo`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices para tabela `contato`
--
ALTER TABLE `contato`
  ADD PRIMARY KEY (`id_contato`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices para tabela `destinatarionotificacao`
--
ALTER TABLE `destinatarionotificacao`
  ADD PRIMARY KEY (`id_dest_not`),
  ADD KEY `id_notificacao` (`id_notificacao`),
  ADD KEY `id_usuario` (`id_usuario`);

-- Índices para tabela `notificacao`
--
ALTER TABLE `notificacao`
  ADD PRIMARY KEY (`id_notificacao`);



--
-- Índices para tabela `trocasenha`
--
ALTER TABLE `trocasenha`
  ADD PRIMARY KEY (`id_troSenha`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `cpf` (`cpf`,`email`,`telefone`);





-- AUTO_INCREMENT de tabela `chat`
--
ALTER TABLE `chat`
  MODIFY `id_chat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `codigoconfirmacao`
--
ALTER TABLE `codigoconfirmacao`
  MODIFY `id_codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `contato`
--
ALTER TABLE `contato`
  MODIFY `id_contato` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `destinatarionotificacao`
--
ALTER TABLE `destinatarionotificacao`
  MODIFY `id_dest_not` int(11) NOT NULL AUTO_INCREMENT;



-- AUTO_INCREMENT de tabela `notificacao`
--
ALTER TABLE `notificacao`
  MODIFY `id_notificacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `trocasenha`
--
ALTER TABLE `trocasenha`
  MODIFY `id_troSenha` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
