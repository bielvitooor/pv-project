-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30/07/2024 às 00:29
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `pv`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `admin`
--

--

INSERT INTO `admin` (`idadmin`, `login`, `password`, `name`) VALUES
(1, '2020', '1234', 'Gabriel');

-- --------------------------------------------------------

--
-- Despejando dados para a tabela `guest`
--

INSERT INTO `guest` (`idguest`, `name`, `cpf`) VALUES
(1, 'João', 12345678900),
(2, 'João', 12345678900),
(3, 'João', 12345678900),
(4, 'João', 12345678900),
(5, 'João', 12345678900),
(6, 'João', 12345678900),
(7, 'João', 12345678900),
(8, 'João', 12345678900),
(9, 'João', 12345678900),
(10, 'João Silva', 12345678901),
(11, 'João Silva', 1234567897654);

-- --------------------------------------------------------

--
-- Despejando dados para a tabela `payment`
--

INSERT INTO `payment` (`idpayment`, `tipo`) VALUES
(1, 'Dinheiro'),
(2, 'Cartão'),
(3, 'Pix');



INSERT INTO `product` (`idproduct`, `name_product`, `price`, `quantity`) VALUES
(7, 'Laranja', 32.00, 9.00),
(8, 'Ovo Branco', 7.00, 5.00);




INSERT INTO `status` (`idstatus`, `description`) VALUES
(1, 'Em espera'),
(2, 'Em seperação'),
(3, 'Pronto');

