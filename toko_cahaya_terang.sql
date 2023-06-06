-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2022 at 04:35 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko_cahaya_terang`
--

-- --------------------------------------------------------

--
-- Table structure for table `barangkeluar`
--

CREATE TABLE `barangkeluar` (
  `tanggal` date NOT NULL,
  `produkid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `barangkeluarid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barangkeluar`
--

INSERT INTO `barangkeluar` (`tanggal`, `produkid`, `quantity`, `barangkeluarid`) VALUES
('2021-01-16', 7, 11, 16),
('2022-09-11', 11, 10, 17),
('2022-09-12', 13, 10, 18),
('2022-09-16', 11, 15, 19);

-- --------------------------------------------------------

--
-- Table structure for table `barangmasuk`
--

CREATE TABLE `barangmasuk` (
  `tanggal` date NOT NULL,
  `produkid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `barangmasukid` int(11) NOT NULL,
  `expire` date DEFAULT NULL,
  `hargabeli` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barangmasuk`
--

INSERT INTO `barangmasuk` (`tanggal`, `produkid`, `quantity`, `barangmasukid`, `expire`, `hargabeli`) VALUES
('2021-01-16', 7, 10, 18, '2023-01-04', NULL),
('2021-01-16', 7, 1, 19, '2022-12-31', NULL),
('2021-01-18', 8, 100, 20, '2023-02-01', NULL),
('2021-01-18', 7, 100, 21, '2023-02-28', NULL),
('2021-01-18', 2, 100, 22, '2023-03-15', NULL),
('2021-01-18', 1, 100, 23, '2023-09-04', NULL),
('2021-01-18', 6, 100, 24, '2023-09-04', NULL),
('2021-01-18', 3, 100, 25, '2023-09-04', NULL),
('2021-01-18', 5, 100, 26, '2022-09-27', NULL),
('2021-01-18', 4, 100, 28, '2023-12-20', NULL),
('2022-09-11', 11, 20, 29, '2023-09-04', NULL),
('2022-09-11', 11, 50, 30, '2023-01-01', NULL),
('2022-09-11', 13, 10, 31, '2023-08-01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categori`
--

CREATE TABLE `categori` (
  `categoriid` int(11) NOT NULL,
  `categori` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categori`
--

INSERT INTO `categori` (`categoriid`, `categori`) VALUES
(1, 'ATK'),
(2, 'Bahan Bangunan'),
(3, 'Bahan Kue'),
(4, 'Health n Beauty'),
(5, 'Pakan Ternak'),
(6, 'Sembako'),
(7, 'Snack n Minuman'),
(8, 'Lain-lain'),
(9, 'Makanan'),
(10, 'Pakaian'),
(11, 'Mie Instan');

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `idlevel` int(3) NOT NULL,
  `namalevel` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`idlevel`, `namalevel`) VALUES
(1, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `level_menuadmin`
--

CREATE TABLE `level_menuadmin` (
  `id` int(3) NOT NULL,
  `idlevel` int(3) NOT NULL,
  `idadminmenu` int(3) NOT NULL,
  `cancreate` enum('0','1') NOT NULL DEFAULT '0',
  `canread` enum('0','1') NOT NULL DEFAULT '0',
  `canupdate` enum('0','1') NOT NULL DEFAULT '0',
  `candelete` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `level_menuadmin`
--

INSERT INTO `level_menuadmin` (`id`, `idlevel`, `idadminmenu`, `cancreate`, `canread`, `canupdate`, `candelete`) VALUES
(1, 1, 1, '1', '1', '1', '1'),
(2, 1, 5, '1', '1', '1', '1'),
(3, 1, 6, '1', '1', '1', '1'),
(4, 1, 7, '1', '1', '1', '1'),
(5, 1, 8, '1', '1', '1', '1'),
(6, 1, 9, '1', '1', '1', '1'),
(7, 1, 10, '1', '1', '1', '1'),
(8, 1, 11, '1', '1', '1', '1'),
(9, 1, 12, '1', '1', '1', '1'),
(10, 1, 13, '1', '1', '1', '1'),
(11, 2, 5, '1', '1', '1', '1'),
(12, 2, 6, '1', '1', '1', '1'),
(14, 2, 8, '1', '1', '1', '1'),
(15, 2, 9, '1', '1', '1', '1'),
(20, 3, 5, '1', '1', '1', '0'),
(21, 3, 6, '0', '1', '1', '0'),
(22, 3, 7, '0', '1', '1', '0'),
(23, 3, 8, '0', '1', '1', '0'),
(24, 3, 9, '0', '1', '1', '0'),
(25, 3, 10, '0', '1', '1', '0'),
(26, 3, 11, '0', '1', '1', '0'),
(27, 3, 12, '0', '1', '1', '0'),
(28, 3, 13, '0', '1', '1', '0'),
(29, 1, 19, '1', '1', '1', '1'),
(31, 1, 21, '1', '1', '1', '1'),
(32, 1, 14, '1', '1', '1', '1'),
(33, 2, 20, '1', '1', '1', '1'),
(34, 2, 21, '1', '1', '1', '1'),
(35, 2, 14, '1', '1', '1', '1'),
(36, 2, 10, '1', '1', '1', '1'),
(37, 1, 20, '1', '1', '1', '1'),
(38, 1, 22, '1', '1', '1', '1'),
(39, 1, 3, '1', '1', '1', '1'),
(40, 1, 4, '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `idlevel` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`username`, `password`, `nama`, `email`, `idlevel`) VALUES
('admin', '171852795695163624615230f364e59f', 'Administrator', 'admin@localhost.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `menuadmin`
--

CREATE TABLE `menuadmin` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `parent` int(10) UNSIGNED DEFAULT 0,
  `create` char(1) COLLATE utf8_unicode_ci DEFAULT '1' COMMENT '1 = aktif',
  `read` char(1) COLLATE utf8_unicode_ci DEFAULT '1' COMMENT '1 = aktif',
  `update` char(1) COLLATE utf8_unicode_ci DEFAULT '1' COMMENT '1 = aktif',
  `del` char(1) COLLATE utf8_unicode_ci DEFAULT '1' COMMENT '1 = aktif',
  `active` char(50) COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '1 = aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `menuadmin`
--

INSERT INTO `menuadmin` (`id`, `name`, `url`, `parent`, `create`, `read`, `update`, `del`, `active`) VALUES
(1, 'Master', '#', 0, '0', '0', '0', '0', '1'),
(3, 'Laporan', '#', 0, '0', '0', '0', '0', '1'),
(4, 'Setting', '#', 0, '0', '0', '0', '0', '1'),
(5, 'Produk', 'produk', 1, '1', '1', '1', '1', '1'),
(6, 'Kategori Produk', 'kategori', 1, '1', '1', '1', '1', '1'),
(10, 'User Level', 'Level', 4, '1', '1', '1', '1', '1'),
(12, 'Menu', 'Menu', 4, '1', '1', '1', '1', '1'),
(13, 'Menu Level Access', 'Levelmenu', 4, '1', '1', '1', '1', '1'),
(14, 'Cek Barang Expire', 'expire', 3, '1', '1', '1', '1', '1'),
(20, 'Barang Masuk', 'barangmasuk', 1, '1', '1', '1', '1', '1'),
(21, 'Barang Keluar', 'barangkeluar', 1, '1', '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `produkid` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `categoriid` int(11) NOT NULL,
  `stok` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`produkid`, `nama`, `categoriid`, `stok`) VALUES
(1, 'Kopi Kapal Api', 7, 96),
(2, 'Gudang Garam', 8, 98),
(3, 'Semen', 2, 99),
(4, 'Tepung Mila', 3, 100),
(5, 'Sunsilk 100ml', 4, 100),
(6, 'Pakan Ayam', 5, 100),
(7, 'Beras 50kg', 6, 100),
(8, 'Aqua 330ml', 7, 100),
(9, 'Daster Ibu Hamil', 10, 0),
(10, 'Celana Jeans', 10, 0),
(11, 'Pop Mie', 11, 45),
(12, 'Indomie', 11, 0),
(13, 'Sarimi', 11, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barangkeluar`
--
ALTER TABLE `barangkeluar`
  ADD PRIMARY KEY (`barangkeluarid`),
  ADD KEY `produkid` (`produkid`);

--
-- Indexes for table `barangmasuk`
--
ALTER TABLE `barangmasuk`
  ADD PRIMARY KEY (`barangmasukid`),
  ADD KEY `produkid` (`produkid`);

--
-- Indexes for table `categori`
--
ALTER TABLE `categori`
  ADD PRIMARY KEY (`categoriid`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`idlevel`);

--
-- Indexes for table `level_menuadmin`
--
ALTER TABLE `level_menuadmin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menuadmin`
--
ALTER TABLE `menuadmin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`produkid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barangkeluar`
--
ALTER TABLE `barangkeluar`
  MODIFY `barangkeluarid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `barangmasuk`
--
ALTER TABLE `barangmasuk`
  MODIFY `barangmasukid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `categori`
--
ALTER TABLE `categori`
  MODIFY `categoriid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `idlevel` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `level_menuadmin`
--
ALTER TABLE `level_menuadmin`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `menuadmin`
--
ALTER TABLE `menuadmin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `produkid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barangkeluar`
--
ALTER TABLE `barangkeluar`
  ADD CONSTRAINT `barangkeluar_ibfk_1` FOREIGN KEY (`produkid`) REFERENCES `produk` (`produkid`);

--
-- Constraints for table `barangmasuk`
--
ALTER TABLE `barangmasuk`
  ADD CONSTRAINT `barangmasuk_ibfk_1` FOREIGN KEY (`produkid`) REFERENCES `produk` (`produkid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
