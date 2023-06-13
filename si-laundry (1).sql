-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2023 at 03:28 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `si-laundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun`
--

CREATE TABLE `akun` (
  `id_akun` int(5) NOT NULL,
  `no_akun` varchar(20) NOT NULL,
  `nama_akun` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `akun`
--

INSERT INTO `akun` (`id_akun`, `no_akun`, `nama_akun`) VALUES
(6, 'Adfasdkfjsa', 'Khairul Abidin');

-- --------------------------------------------------------

--
-- Table structure for table `costumers`
--

CREATE TABLE `costumers` (
  `id_costumer` int(5) UNSIGNED NOT NULL,
  `kode_costumer` varchar(30) NOT NULL,
  `nama_costumer` varchar(50) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `no_telp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `costumers`
--

INSERT INTO `costumers` (`id_costumer`, `kode_costumer`, `nama_costumer`, `alamat`, `no_telp`) VALUES
(2, 'P00001', 'Aira ', 'Pekanbaru', '082382182139');

-- --------------------------------------------------------

--
-- Table structure for table `journals`
--

CREATE TABLE `journals` (
  `id_journal` int(5) UNSIGNED NOT NULL,
  `no_journal` varchar(20) NOT NULL,
  `no_akun` varchar(20) NOT NULL,
  `no_trx` varchar(20) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `debit` varchar(10) NOT NULL,
  `kredit` varchar(10) NOT NULL,
  `tanggal_jurnal` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `journals`
--

INSERT INTO `journals` (`id_journal`, `no_journal`, `no_akun`, `no_trx`, `keterangan`, `debit`, `kredit`, `tanggal_jurnal`) VALUES
(5, 'No12321', 'Adfasdkfjsa', 'TRX20230608175514', 'Transaksi Selesai', '123', '24', '2023-06-10'),
(6, 'No123213``', 'Adfasdkfjsa', 'TRX20230608175514', 'dfadsf', '8', '', '2023-06-10');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2023-06-03-182643', 'App\\Database\\Migrations\\Users', 'default', 'App', 1686242234, 1),
(2, '2023-06-04-162535', 'App\\Database\\Migrations\\Services', 'default', 'App', 1686242234, 1),
(3, '2023-06-04-172405', 'App\\Database\\Migrations\\Costumers', 'default', 'App', 1686242234, 1),
(4, '2023-06-04-181828', 'App\\Database\\Migrations\\Transactions', 'default', 'App', 1686242234, 1),
(5, '2023-06-08-064318', 'App\\Database\\Migrations\\Journals', 'default', 'App', 1686242234, 1),
(6, '2023-06-08-064942', 'App\\Database\\Migrations\\Akun', 'default', 'App', 1686242234, 1);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id_service` int(5) UNSIGNED NOT NULL,
  `kode_service` varchar(7) NOT NULL,
  `nama_service` varchar(100) NOT NULL,
  `harga_service` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id_service`, `kode_service`, `nama_service`, `harga_service`) VALUES
(2, 'L00002', 'Cuci ', '4000'),
(3, 'L00003', 'Setrikas', '3000');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id_transaction` int(5) UNSIGNED NOT NULL,
  `transaction_number` varchar(20) NOT NULL,
  `service_code` varchar(7) NOT NULL,
  `costumer_code` varchar(7) NOT NULL,
  `berat_pakaian` int(5) NOT NULL,
  `total` varchar(7) NOT NULL,
  `jumlah_bayar` varchar(7) DEFAULT NULL,
  `kembalian` varchar(7) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id_transaction`, `transaction_number`, `service_code`, `costumer_code`, `berat_pakaian`, `total`, `jumlah_bayar`, `kembalian`, `status`, `created_at`, `updated_at`) VALUES
(1, 'TRX20230608175514', 'L00002', '0', 3, '12000', '15000', '3000', 1, '2023-06-09 00:55:14', '2023-06-08 17:57:55'),
(2, 'kajsfkda', 'sdfjalk', 'sdafjk', 5, '29000', '123121', '12312', 1, '2023-06-10 17:53:16', '2023-06-10 17:53:16'),
(3, 'TRX20230610123650', 'L00003', 'P00001', 12, '36000', NULL, NULL, 1, '2023-06-10 19:36:50', '2023-06-10 19:36:50'),
(5, 'TRX-10-06-2023-0004', 'L00003', 'P00001', 2, '6000', NULL, NULL, 0, '2023-06-10 23:27:22', '2023-06-10 23:27:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(5) UNSIGNED NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `tempat_lahir` varchar(30) DEFAULT NULL,
  `tanggal_lahir` varchar(11) DEFAULT NULL,
  `role` tinyint(1) NOT NULL DEFAULT 1,
  `isLogin` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `username`, `email`, `password`, `no_telp`, `alamat`, `tempat_lahir`, `tanggal_lahir`, `role`, `isLogin`) VALUES
(1, 'Pemilik', 'pemilik', 'pemilik@mail.com', '$2y$10$.R3HeA9rWlNpjXcsaljMjOSRdAEp7VcD6g.mK10F5mT7.SwH4gLR.', NULL, NULL, NULL, NULL, 0, 1),
(2, 'admin', 'admin', 'admin@mail.com', '$2y$10$gi7JPefsXSzQz97ChSGboOegIOJnqXGBQkydKogRU/X0R7NIOtQ1.', NULL, NULL, NULL, NULL, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`id_akun`);

--
-- Indexes for table `costumers`
--
ALTER TABLE `costumers`
  ADD PRIMARY KEY (`id_costumer`);

--
-- Indexes for table `journals`
--
ALTER TABLE `journals`
  ADD PRIMARY KEY (`id_journal`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id_service`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id_transaction`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akun`
--
ALTER TABLE `akun`
  MODIFY `id_akun` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `costumers`
--
ALTER TABLE `costumers`
  MODIFY `id_costumer` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `journals`
--
ALTER TABLE `journals`
  MODIFY `id_journal` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id_service` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id_transaction` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
