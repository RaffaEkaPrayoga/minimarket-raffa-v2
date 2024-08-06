-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2024 at 04:01 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasir_opp`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `idkategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `tgl_dibuat` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`idkategori`, `nama_kategori`, `tgl_dibuat`) VALUES
(1, 'Shampoo', '2024-07-30 03:42:28'),
(2, 'Mie Instan', '2024-07-30 03:42:09'),
(3, 'Minuman', '2024-07-30 03:42:00'),
(4, 'Minyak Goreng', '2024-07-30 03:41:53'),
(8, 'Buah', '2024-07-30 03:41:42');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `idcart` int(11) NOT NULL,
  `no_nota` varchar(100) NOT NULL,
  `idproduk` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id_laporan` int(11) NOT NULL,
  `no_nota` varchar(50) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `catatan` text NOT NULL,
  `totalbeli` int(11) NOT NULL,
  `pembayaran` int(11) NOT NULL,
  `kembalian` int(11) NOT NULL,
  `tgl_sub` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`id_laporan`, `no_nota`, `id_pelanggan`, `catatan`, `totalbeli`, `pembayaran`, `kembalian`, `tgl_sub`) VALUES
(1, 'AD912231123001', 6, 'Terima Kasih', 3000, 5000, 2000, '2023-12-09 04:31:13'),
(2, 'AD912231130231', 3, 'Terima Kasih', 29000, 30000, 1000, '2023-12-09 04:30:35'),
(3, 'AD912231132303', 1, 'Terima Kasih', 16000, 20000, 4000, '2023-12-09 04:33:00'),
(4, 'AD912231145324', 2, 'Terima Kasih', 23000, 25000, 2000, '2023-12-09 04:45:50'),
(6, 'AD18241013454', 1, 'Terima Kasih', 24000, 30000, 6000, '2024-08-01 08:13:36'),
(7, 'AD18241016454', 11, 'Terima Kasih', 20000, 20000, 0, '2024-08-01 08:16:50'),
(8, 'AD18241130454', 6, 'Terima Kasih', 13000, 15000, 2000, '2024-08-01 09:30:25'),
(9, 'AD18241150454', 1, 'Terima Kasih', 20000, 20000, 0, '2024-08-01 09:50:32'),
(10, 'AD18241152454', 2, 'Terima Kasih', 16000, 20000, 4000, '2024-08-01 09:52:39'),
(11, 'AD4824531454', 11, 'Terima Kasih', 16000, 20000, 4000, '2024-08-04 03:31:32');

-- --------------------------------------------------------

--
-- Table structure for table `nota`
--

CREATE TABLE `nota` (
  `idnota` int(11) NOT NULL,
  `no_nota` varchar(100) NOT NULL,
  `idproduk` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nota`
--

INSERT INTO `nota` (`idnota`, `no_nota`, `idproduk`, `quantity`) VALUES
(1, 'AD912231123001', 2, 1),
(2, 'AD912231130231', 1, 1),
(3, 'AD912231130231', 5, 1),
(4, 'AD912231130231', 2, 3),
(5, 'AD912231132303', 5, 1),
(6, 'AD912231145324', 1, 1),
(7, 'AD912231145324', 2, 1),
(8, 'AD912231145324', 5, 1),
(40, 'AD18241003454', 5, 1),
(41, 'AD18241003454', 1, 2),
(49, 'AD18241013454', 5, 1),
(50, 'AD18241013454', 1, 2),
(52, 'AD18241016454', 1, 1),
(53, 'AD18241016454', 5, 1),
(55, 'AD18241130454', 2, 1),
(56, 'AD18241130454', 13, 1),
(58, 'AD18241150454', 13, 2),
(59, 'AD18241152454', 5, 1),
(60, 'AD4824531454', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_pelanggan` varchar(30) NOT NULL,
  `telepon_pelanggan` varchar(15) NOT NULL,
  `alamat_pelanggan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `telepon_pelanggan`, `alamat_pelanggan`) VALUES
(1, 'Reihan', '087965756545', 'Jalan Melati'),
(2, 'Diwa', '081234766545', 'Jalan Teratai'),
(3, 'Melani', '084676543457', 'Jalan Rafflesia'),
(6, 'Merlin', '083296532890', 'Jalan Amal'),
(11, 'Raffa', '08127723443', 'Jalan Karya');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` int(11) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `idproduk` int(11) NOT NULL,
  `jumlah_pembelian` int(11) NOT NULL,
  `tgl_pembelian` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`id_pembelian`, `id_supplier`, `idproduk`, `jumlah_pembelian`, `tgl_pembelian`) VALUES
(1, 9, 2, 40, '2023-11-30 22:57:33'),
(2, 1, 1, 40, '2023-11-30 23:01:16'),
(9, 2, 5, 20, '2023-12-03 08:35:46');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `idproduk` int(11) NOT NULL,
  `idkategori` int(11) NOT NULL,
  `kode_produk` varchar(100) NOT NULL,
  `nama_produk` varchar(150) NOT NULL,
  `harga_modal` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `tgl_input` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `gambar` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`idproduk`, `idkategori`, `kode_produk`, `nama_produk`, `harga_modal`, `harga_jual`, `stock`, `tgl_input`, `gambar`) VALUES
(1, 2, 'BRG001', 'Indomie', 3000, 4000, 87, '2024-08-05 07:09:50', '66b07abee8233.png'),
(2, 1, 'BRG002', 'Lifeboy', 2000, 3000, 54, '2024-08-05 07:10:10', '66b07ad2390a3.png'),
(5, 4, 'BRG003', 'Minyak Kita', 14000, 16000, 46, '2024-08-05 07:12:44', '66b07b6cab24b.png'),
(7, 3, 'BRG004', 'Teh Gelas', 1000, 2000, 100, '2024-08-05 07:11:29', '66b07b21ba4bc.png'),
(13, 8, 'BRG005', 'Apel', 5000, 10000, 47, '2024-08-05 07:12:58', '66b07b7a29703.png'),
(19, 3, 'BRG006', 'Golda Coffee', 3000, 5000, 50, '2024-08-06 01:47:31', '66b07b8a2d36e.png');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama_supplier` varchar(100) NOT NULL,
  `telepon_supplier` varchar(15) NOT NULL,
  `alamat_supplier` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `telepon_supplier`, `alamat_supplier`) VALUES
(1, 'Rangga', '0864456784248', 'Jalan Merpati'),
(2, 'Rian Deo', '0893243565343', 'Jalan Tamtama'),
(9, 'Fathir', '0834567845547', 'Jalan Mawar'),
(12, 'Reza', '0876445699675', 'Jalan Karya');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `level` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `alamat`, `username`, `password`, `level`) VALUES
(1, 'Raffa Eka Prayoga', 'Jalan Bakti', 'SuperAdmin', '$2y$10$kLYaluLEySs0SERg2axEFuzXSKbQKKUCDBmCN2dip08bsbt5tiUy2', 1),
(2, 'Reihan Firmansyah', 'Jalan Mawar', 'Admin', '$2y$10$G5VsUituhNuo1zbetoXNqu3WaiqtVmMvp4Uo96vK4GIVUYhn3XQJu', 2),
(3, 'Rian Deo', 'Jalan Patin', 'User', '$2y$10$EgRUOf3DTCW/0p5N8atoOuvKHceP./6oJj7SMBeBVZNqjE2/gkkCC', 3),
(17, 'Reihan', 'Jalan Riau', 'reihan', '$2y$10$6NvVA4wwu2UGjika0wF5SehSmMtjCbqkpGONe2yy6Z6k4b83GD.JC', 3),
(25, 'Geo', 'Jalan Dutamas', 'gek', '$2y$10$Yvl2zgBD8LgseWa7VqIzMuRwey3JDnrYE1YoevN4HQKTCA8.li/n.', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`idkategori`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`idcart`),
  ADD KEY `fk_keranjang_produk` (`idproduk`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `fk_laporan_pelanggan` (`id_pelanggan`);

--
-- Indexes for table `nota`
--
ALTER TABLE `nota`
  ADD PRIMARY KEY (`idnota`),
  ADD KEY `fk_nota_produk` (`idproduk`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_pembelian`),
  ADD KEY `fk_pembelian_supplier` (`id_supplier`),
  ADD KEY `idproduk` (`idproduk`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`idproduk`),
  ADD KEY `fk_produk_kategori` (`idkategori`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `idkategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `idcart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `nota`
--
ALTER TABLE `nota`
  MODIFY `idnota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `idproduk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `fk_keranjang_produk` FOREIGN KEY (`idproduk`) REFERENCES `produk` (`idproduk`);

--
-- Constraints for table `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `fk_laporan_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`);

--
-- Constraints for table `nota`
--
ALTER TABLE `nota`
  ADD CONSTRAINT `fk_nota_produk` FOREIGN KEY (`idproduk`) REFERENCES `produk` (`idproduk`);

--
-- Constraints for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `fk_pembelian_supplier` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`),
  ADD CONSTRAINT `pembelian_ibfk_1` FOREIGN KEY (`idproduk`) REFERENCES `produk` (`idproduk`) ON UPDATE CASCADE;

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`idkategori`) REFERENCES `kategori` (`idkategori`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
