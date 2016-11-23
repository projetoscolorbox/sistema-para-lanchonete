-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 23-Nov-2016 às 14:11
-- Versão do servidor: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sistema_para_lanchonete`
--
CREATE DATABASE IF NOT EXISTS `sistema_para_lanchonete` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `sistema_para_lanchonete`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_categorias`
--

CREATE TABLE IF NOT EXISTS `tb_categorias` (
  `categoria_id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria_nome` varchar(255) NOT NULL,
  `categoria_apagado` tinyint(1) NOT NULL,
  PRIMARY KEY (`categoria_id`),
  UNIQUE KEY `categoria_id_UNIQUE` (`categoria_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `tb_categorias`
--

INSERT INTO `tb_categorias` (`categoria_id`, `categoria_nome`, `categoria_apagado`) VALUES
(1, 'Sem Categoria', 0),
(2, 'Pizza', 0),
(3, 'Bebida', 0),
(4, 'Sobremesa', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_configuracoes`
--

CREATE TABLE IF NOT EXISTS `tb_configuracoes` (
  `configuracao_id` int(11) NOT NULL AUTO_INCREMENT,
  `pedido` tinyint(1) NOT NULL,
  `pedido_abrir` tinyint(1) NOT NULL,
  `pedido_finalizar` tinyint(1) NOT NULL,
  `pedido_gerenciar` tinyint(1) NOT NULL,
  `categoria` tinyint(1) NOT NULL,
  `categoria_cadastrar` tinyint(1) NOT NULL,
  `categoria_editar` tinyint(1) NOT NULL,
  `categoria_excluir` tinyint(1) NOT NULL,
  `produto` tinyint(1) NOT NULL,
  `produto_cadastrar` tinyint(1) NOT NULL,
  `produto_editar` tinyint(1) NOT NULL,
  `produto_excluir` tinyint(1) NOT NULL,
  `usuario` tinyint(1) NOT NULL,
  `usuario_cadastrar` tinyint(1) NOT NULL,
  `usuario_editar` tinyint(1) NOT NULL,
  `usuario_excluir` tinyint(1) NOT NULL,
  `configuracao` tinyint(1) NOT NULL,
  `configuracao_apagado` tinyint(1) NOT NULL,
  `configuracao_nome` varchar(255) NOT NULL,
  PRIMARY KEY (`configuracao_id`),
  UNIQUE KEY `configuracao_id_UNIQUE` (`configuracao_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `tb_configuracoes`
--

INSERT INTO `tb_configuracoes` (`configuracao_id`, `pedido`, `pedido_abrir`, `pedido_finalizar`, `pedido_gerenciar`, `categoria`, `categoria_cadastrar`, `categoria_editar`, `categoria_excluir`, `produto`, `produto_cadastrar`, `produto_editar`, `produto_excluir`, `usuario`, `usuario_cadastrar`, `usuario_editar`, `usuario_excluir`, `configuracao`, `configuracao_apagado`, `configuracao_nome`) VALUES
(1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Cliente'),
(2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 'Administrador'),
(3, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Atendente');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_enderecos`
--

CREATE TABLE IF NOT EXISTS `tb_enderecos` (
  `endereco_cep` varchar(255) NOT NULL,
  `endereco_logradouro` varchar(255) DEFAULT NULL,
  `endereco_bairro` varchar(255) DEFAULT NULL,
  `endereco_localidade` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`endereco_cep`),
  UNIQUE KEY `endereco_cep_UNIQUE` (`endereco_cep`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_enderecos`
--

INSERT INTO `tb_enderecos` (`endereco_cep`, `endereco_logradouro`, `endereco_bairro`, `endereco_localidade`) VALUES
('24020-0', '32164654649', 'Mumbuca', 'Maricá'),
('24030030', 'Rua Dr Froés da Cruz', 'Centro', 'Niterói');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_itens`
--

CREATE TABLE IF NOT EXISTS `tb_itens` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `pedido_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `item_quantidade` int(10) unsigned NOT NULL,
  `produto_preco` decimal(5,2) NOT NULL,
  PRIMARY KEY (`item_id`),
  KEY `fk_tb_produtos_pedidos_tb_produtos1_idx` (`produto_id`),
  KEY `fk_tb_itens_tb_pedidos1_idx` (`pedido_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Extraindo dados da tabela `tb_itens`
--

INSERT INTO `tb_itens` (`item_id`, `pedido_id`, `produto_id`, `item_quantidade`, `produto_preco`) VALUES
(1, 1, 5, 2, '4.00'),
(2, 1, 3, 1, '19.90'),
(3, 2, 5, 1, '4.00'),
(4, 2, 1, 1, '19.90'),
(5, 2, 8, 1, '5.00'),
(6, 3, 5, 1, '4.00'),
(7, 3, 7, 1, '4.00'),
(8, 3, 6, 1, '4.00'),
(9, 3, 3, 2, '19.90'),
(10, 3, 1, 2, '19.90'),
(11, 3, 2, 2, '19.90'),
(12, 3, 4, 2, '19.90'),
(13, 3, 8, 1, '5.00'),
(14, 4, 5, 1, '4.00'),
(15, 5, 6, 9999, '4.00'),
(16, 6, 5, 2, '4.00'),
(17, 6, 3, 1, '19.90'),
(18, 6, 1, 1, '19.90');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_pedidos`
--

CREATE TABLE IF NOT EXISTS `tb_pedidos` (
  `pedido_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `pedido_apagado` tinyint(1) NOT NULL,
  `pedido_andamento` varchar(30) NOT NULL,
  `pedido_data` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`pedido_id`),
  UNIQUE KEY `pedido_id_UNIQUE` (`pedido_id`),
  KEY `fk_tb_pedidos_tb_usuarios1_idx` (`usuario_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `tb_pedidos`
--

INSERT INTO `tb_pedidos` (`pedido_id`, `usuario_id`, `pedido_apagado`, `pedido_andamento`, `pedido_data`) VALUES
(1, 1, 0, 'Finalizado', '2016-11-21 20:59:53'),
(2, 1, 0, 'Finalizado', '2016-11-21 21:12:35'),
(3, 1, 0, 'Finalizado', '2016-11-21 21:19:34'),
(4, 1, 0, 'Finalizado', '2016-11-21 21:20:14'),
(5, 5, 0, 'Finalizado', '2016-11-21 21:47:09'),
(6, 6, 0, 'Finalizado', '2016-11-22 22:05:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_produtos`
--

CREATE TABLE IF NOT EXISTS `tb_produtos` (
  `produto_id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria_id` int(11) NOT NULL,
  `produto_apagado` tinyint(1) NOT NULL,
  `produto_nome` varchar(255) NOT NULL,
  `produto_medida` varchar(255) DEFAULT NULL,
  `produto_preco` decimal(5,2) NOT NULL,
  `produto_imagem` varchar(255) DEFAULT NULL,
  `produto_detalhes` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`produto_id`),
  UNIQUE KEY `produtos_id_UNIQUE` (`produto_id`),
  KEY `fk_tb_produtos_tb_categorias1_idx` (`categoria_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Extraindo dados da tabela `tb_produtos`
--

INSERT INTO `tb_produtos` (`produto_id`, `categoria_id`, `produto_apagado`, `produto_nome`, `produto_medida`, `produto_preco`, `produto_imagem`, `produto_detalhes`) VALUES
(1, 2, 0, 'Muçarela Média', NULL, '19.90', NULL, NULL),
(2, 2, 0, 'Portuguesa Média', NULL, '19.90', NULL, NULL),
(3, 2, 0, 'Calabreza Média', NULL, '19.90', NULL, NULL),
(4, 2, 0, 'Quatro Queijos Média', NULL, '19.90', NULL, NULL),
(5, 3, 0, 'Coca Cola 350 ml', NULL, '4.00', NULL, NULL),
(6, 3, 0, 'Sprite 350 ml', NULL, '4.00', NULL, NULL),
(7, 3, 0, 'Guaraná 350 ml', NULL, '4.00', NULL, NULL),
(8, 4, 0, 'Torta de Morango Fatia', NULL, '5.00', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_usuarios`
--

CREATE TABLE IF NOT EXISTS `tb_usuarios` (
  `usuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `configuracao_id` int(11) NOT NULL,
  `endereco_cep` varchar(255) NOT NULL,
  `usuario_identidade` tinyint(1) NOT NULL,
  `usuario_login` varchar(255) NOT NULL,
  `usuario_senha` varchar(255) NOT NULL,
  `usuario_apagado` tinyint(1) NOT NULL,
  `usuario_telefone` varchar(255) NOT NULL,
  `usuario_complemento` varchar(255) NOT NULL,
  `usuario_data_cadastro` timestamp NULL DEFAULT NULL,
  `usuario_nome` varchar(255) DEFAULT NULL,
  `usuario_celular` varchar(255) DEFAULT NULL,
  `usuario_email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`usuario_id`),
  UNIQUE KEY `usuario_id_UNIQUE` (`usuario_id`),
  KEY `fk_tb_usuarios_tb_configuracao1_idx` (`configuracao_id`),
  KEY `fk_tb_usuarios_tb_enderecos1_idx` (`endereco_cep`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `tb_usuarios`
--

INSERT INTO `tb_usuarios` (`usuario_id`, `configuracao_id`, `endereco_cep`, `usuario_identidade`, `usuario_login`, `usuario_senha`, `usuario_apagado`, `usuario_telefone`, `usuario_complemento`, `usuario_data_cadastro`, `usuario_nome`, `usuario_celular`, `usuario_email`) VALUES
(1, 1, '24000830', 0, 'Cliente', 'cliente', 0, '26845169', 'Rua 5,Quadra 7, Lote A', NULL, 'Paulo', NULL, NULL),
(2, 2, '24000830', 1, 'Administrador', 'administrador', 0, '37319546', 'Rua Pascal de Souza, Quadra 3, Nº 7', NULL, 'Hugo', NULL, NULL),
(3, 3, '24000830', 1, 'Atendente', 'atendente', 0, '22559988', 'N definido', NULL, 'Marcos', NULL, NULL),
(5, 1, '24020-0', 0, 'mastermir', '990', 0, '26541235', 'N5, Q2, L3', '2016-11-21 21:46:45', 'Alfredo', NULL, 'alfredo@colorbox.art.br'),
(6, 1, '24030030', 0, 'Priscila', 'adminbrasil', 0, '38570409', '', '2016-11-22 22:03:01', 'Priscila', '996956243', 'prisoliver8@gmail.com');

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `tb_itens`
--
ALTER TABLE `tb_itens`
  ADD CONSTRAINT `fk_tb_produtos_pedidos_tb_produtos1` FOREIGN KEY (`produto_id`) REFERENCES `tb_produtos` (`produto_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tb_itens_tb_pedidos1` FOREIGN KEY (`pedido_id`) REFERENCES `tb_pedidos` (`pedido_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_pedidos`
--
ALTER TABLE `tb_pedidos`
  ADD CONSTRAINT `fk_tb_pedidos_tb_usuarios1` FOREIGN KEY (`usuario_id`) REFERENCES `tb_usuarios` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_produtos`
--
ALTER TABLE `tb_produtos`
  ADD CONSTRAINT `fk_tb_produtos_tb_categorias1` FOREIGN KEY (`categoria_id`) REFERENCES `tb_categorias` (`categoria_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_usuarios`
--
ALTER TABLE `tb_usuarios`
  ADD CONSTRAINT `fk_tb_usuarios_tb_configuracao1` FOREIGN KEY (`configuracao_id`) REFERENCES `tb_configuracoes` (`configuracao_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tb_usuarios_tb_enderecos1` FOREIGN KEY (`endereco_cep`) REFERENCES `tb_enderecos` (`endereco_cep`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
