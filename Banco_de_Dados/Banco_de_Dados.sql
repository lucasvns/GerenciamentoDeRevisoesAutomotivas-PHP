-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 11-Dez-2021 às 02:54
-- Versão do servidor: 10.1.38-MariaDB
-- versão do PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projeto`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `taddress`
--

CREATE TABLE `taddress` (
  `id` int(10) UNSIGNED NOT NULL,
  `tuser_id` int(11) DEFAULT NULL,
  `tempresa_id` int(11) DEFAULT NULL,
  `taddress_district_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `street` varchar(120) DEFAULT NULL,
  `number` varchar(20) DEFAULT NULL,
  `reference` varchar(150) DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `taddress_city`
--

CREATE TABLE `taddress_city` (
  `id` int(10) UNSIGNED NOT NULL,
  `taddress_state_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `taddress_country`
--

CREATE TABLE `taddress_country` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(120) DEFAULT NULL,
  `iso_code` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `taddress_district`
--

CREATE TABLE `taddress_district` (
  `id` int(10) UNSIGNED NOT NULL,
  `taddress_city_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `taddress_state`
--

CREATE TABLE `taddress_state` (
  `id` int(10) UNSIGNED NOT NULL,
  `taddress_country_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(120) DEFAULT NULL,
  `abrev` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tadmin`
--

CREATE TABLE `tadmin` (
  `id` int(11) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `hash_pass` varchar(250) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `last_access` datetime DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `image` text,
  `session_id` varchar(200) DEFAULT NULL,
  `AdminToken` text,
  `device_token` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;

--
-- Extraindo dados da tabela `tadmin`
--

INSERT INTO `tadmin` (`id`, `name`, `hash_pass`, `date_created`, `last_access`, `email`, `birth_date`, `image`, `session_id`, `AdminToken`, `device_token`) VALUES
(15, 'Lucas Vinicius ', '29a5641eaa0c01abe5749608c8232806', '2020-04-14 11:44:12', '2020-04-14 11:44:12', 'lucas@gmail.com', NULL, NULL, '9bf31c7ff062936a96d3c8bd1f8f2ff3', '9bf31c7ff062936a96d3c8bd1f8f2ff3', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tadmin_permission`
--

CREATE TABLE `tadmin_permission` (
  `id` int(11) NOT NULL,
  `tadmin_id` int(11) DEFAULT NULL,
  `tpermission_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tadmin_permission`
--

INSERT INTO `tadmin_permission` (`id`, `tadmin_id`, `tpermission_id`) VALUES
(496, 15, 18),
(495, 8, 30),
(494, 8, 29),
(483, 16, 31),
(493, 8, 28),
(482, 16, 30),
(522, 10, 31),
(521, 10, 30),
(445, 11, 31),
(492, 8, 27),
(520, 10, 29),
(444, 11, 30),
(443, 11, 29),
(442, 11, 28),
(441, 11, 27),
(50, 13, 12),
(51, 13, 10),
(52, 13, 11),
(53, 13, 14),
(54, 13, 13),
(55, 13, 15),
(56, 13, 1),
(491, 8, 32),
(536, 15, 1),
(481, 16, 29),
(519, 10, 28),
(535, 15, 31),
(534, 15, 30),
(533, 15, 29),
(532, 15, 28),
(531, 15, 27),
(530, 15, 32),
(529, 15, 25),
(528, 15, 24),
(480, 16, 28),
(479, 16, 27),
(478, 16, 32),
(518, 10, 27),
(517, 10, 32),
(516, 10, 25),
(515, 10, 24),
(514, 10, 23),
(477, 16, 25),
(476, 16, 24),
(440, 11, 25),
(439, 11, 24),
(438, 11, 23),
(437, 11, 20),
(475, 16, 23),
(527, 15, 23),
(526, 15, 20),
(513, 10, 20),
(512, 10, 21),
(474, 16, 20),
(436, 11, 21),
(435, 11, 22),
(473, 16, 21),
(490, 8, 25),
(489, 8, 24),
(488, 8, 23),
(487, 8, 20),
(486, 8, 21),
(525, 15, 21),
(472, 16, 22),
(509, 18, 31),
(508, 18, 30),
(507, 18, 29),
(506, 18, 28),
(505, 18, 27),
(504, 18, 32),
(503, 18, 25),
(502, 18, 24),
(501, 18, 23),
(500, 18, 20),
(499, 18, 21),
(498, 18, 22),
(485, 8, 22),
(446, 11, 1),
(511, 10, 22),
(524, 15, 22),
(484, 16, 1),
(497, 8, 1),
(510, 18, 1),
(523, 10, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tclientes`
--

CREATE TABLE `tclientes` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `cpf` int(15) NOT NULL,
  `endereco` text NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tclientes`
--

INSERT INTO `tclientes` (`id`, `nome`, `telefone`, `cpf`, `endereco`, `date_created`) VALUES
(1, 'Lucas', '11212121212', 2147483647, 'teste', '2021-12-10 21:09:33'),
(2, 'Gerson', '12919221212', 2147483647, 'Centro', '2021-12-10 23:43:01');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tparameter`
--

CREATE TABLE `tparameter` (
  `id` int(11) NOT NULL,
  `val` text,
  `keyword` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;

--
-- Extraindo dados da tabela `tparameter`
--

INSERT INTO `tparameter` (`id`, `val`, `keyword`) VALUES
(14, 'CAEEP', 'site-title'),
(15, 'http://localhost/projeto/', 'site-url'),
(16, 'http://localhost/projeto/admin/', 'admin-url'),
(24, 'http://localhost/projeto/admin/', 'app-url'),
(25, 'http://localhost/projeto/api/', 'api-url');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tpermission`
--

CREATE TABLE `tpermission` (
  `id` int(11) NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `tpermission_title_id` int(11) DEFAULT NULL,
  `keyword` varchar(200) DEFAULT NULL,
  `list` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `icon` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tpermission`
--

INSERT INTO `tpermission` (`id`, `title`, `tpermission_title_id`, `keyword`, `list`, `position`, `icon`) VALUES
(1, 'Administradores', 1, 'admin', 1, 1, 'fas fa-list'),
(18, 'Listar', 14, 'cliente', 1, 5, 'fal fa-list'),
(28, 'Listar', 13, 'revisao', 1, 5, 'fal fa-list');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tpermission_title`
--

CREATE TABLE `tpermission_title` (
  `id` int(11) NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `icon` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tpermission_title`
--

INSERT INTO `tpermission_title` (`id`, `title`, `position`, `icon`) VALUES
(1, 'Configurações', 100, 'fa fa-cog'),
(14, 'Clientes', 55, 'fas fa-users'),
(13, 'Revisao', 45, 'fas fa-calendar-alt');

-- --------------------------------------------------------

--
-- Estrutura da tabela `trevisao`
--

CREATE TABLE `trevisao` (
  `id` int(11) NOT NULL,
  `veiculo_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `data` varchar(20) NOT NULL,
  `horario` varchar(20) NOT NULL,
  `date_created` datetime NOT NULL,
  `status` int(3) NOT NULL COMMENT '1 = pendente / 2 = executando / 3 = concluído / 4 = cancelado ',
  `servicos` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `trevisao`
--

INSERT INTO `trevisao` (`id`, `veiculo_id`, `cliente_id`, `data`, `horario`, `date_created`, `status`, `servicos`) VALUES
(1, 4, 1, '10/12/2021', '20:20', '2021-12-10 23:06:37', 3, 'Troca de Pneus');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tveiculos`
--

CREATE TABLE `tveiculos` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `numero_placa` varchar(20) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `ano_fabricacao` int(10) NOT NULL,
  `valor` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tveiculos`
--

INSERT INTO `tveiculos` (`id`, `cliente_id`, `numero_placa`, `modelo`, `ano_fabricacao`, `valor`) VALUES
(3, 1, 'awdawdawdaw', 'hb200', 2019, '20.000,00'),
(4, 1, 'aaaaa', 'versa', 2020, '60.000,00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `taddress`
--
ALTER TABLE `taddress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `taddress_FKIndex1` (`taddress_district_id`);

--
-- Indexes for table `taddress_city`
--
ALTER TABLE `taddress_city`
  ADD PRIMARY KEY (`id`),
  ADD KEY `taddress_city_FKIndex1` (`taddress_state_id`);

--
-- Indexes for table `taddress_country`
--
ALTER TABLE `taddress_country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taddress_district`
--
ALTER TABLE `taddress_district`
  ADD PRIMARY KEY (`id`),
  ADD KEY `taddress_district_FKIndex1` (`taddress_city_id`);

--
-- Indexes for table `taddress_state`
--
ALTER TABLE `taddress_state`
  ADD PRIMARY KEY (`id`),
  ADD KEY `taddress_state_FKIndex1` (`taddress_country_id`);

--
-- Indexes for table `tadmin`
--
ALTER TABLE `tadmin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tadmin_permission`
--
ALTER TABLE `tadmin_permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tclientes`
--
ALTER TABLE `tclientes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tparameter`
--
ALTER TABLE `tparameter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tpermission`
--
ALTER TABLE `tpermission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tpermission_title`
--
ALTER TABLE `tpermission_title`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trevisao`
--
ALTER TABLE `trevisao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tveiculos`
--
ALTER TABLE `tveiculos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `taddress`
--
ALTER TABLE `taddress`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `taddress_city`
--
ALTER TABLE `taddress_city`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `taddress_country`
--
ALTER TABLE `taddress_country`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `taddress_district`
--
ALTER TABLE `taddress_district`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `taddress_state`
--
ALTER TABLE `taddress_state`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tadmin`
--
ALTER TABLE `tadmin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tadmin_permission`
--
ALTER TABLE `tadmin_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=537;

--
-- AUTO_INCREMENT for table `tclientes`
--
ALTER TABLE `tclientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tparameter`
--
ALTER TABLE `tparameter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tpermission`
--
ALTER TABLE `tpermission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `tpermission_title`
--
ALTER TABLE `tpermission_title`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `trevisao`
--
ALTER TABLE `trevisao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tveiculos`
--
ALTER TABLE `tveiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
