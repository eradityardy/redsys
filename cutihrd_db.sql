-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2019 at 06:19 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cutihrd_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `dt_keluarga`
--

CREATE TABLE `dt_keluarga` (
  `id_keluarga` int(11) NOT NULL,
  `nip` text NOT NULL,
  `nama_pasangan` text NOT NULL,
  `tgl_lahir_pasangan` date NOT NULL,
  `jml_anak` int(11) NOT NULL,
  `telp_pasangan` text NOT NULL,
  `alamat_pasangan` text NOT NULL,
  `pekerjaan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dt_keluarga`
--

INSERT INTO `dt_keluarga` (`id_keluarga`, `nip`, `nama_pasangan`, `tgl_lahir_pasangan`, `jml_anak`, `telp_pasangan`, `alamat_pasangan`, `pekerjaan`) VALUES
(9, 'PEG-1910-0001', 'Angel Karamoy', '2006-12-12', 0, '0812256789', 'Singocandi RT/RW : 03/01', 'wiraswasta'),
(10, 'PEG-1910-0002', 'Siti Rohmah', '1972-05-12', 3, '081234567', 'Singocandi RT/RW : 03/01', 'Karyawan Swasta'),
(11, 'PEG-1911-0005', 'Vanessa May', '1995-02-17', 1, '085226435113', 'Sluke rt/rw : 03/01', 'Karyawan Swasta'),
(12, 'PEG-1910-0004', 'Siti Fatimah', '1991-07-13', 3, '085226987456', 'Singocandi RT/RW : 03/01', 'wiraswasta');

-- --------------------------------------------------------

--
-- Table structure for table `mst_divisi`
--

CREATE TABLE `mst_divisi` (
  `id_divisi` int(11) NOT NULL,
  `kode_divisi` text NOT NULL,
  `divisi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_divisi`
--

INSERT INTO `mst_divisi` (`id_divisi`, `kode_divisi`, `divisi`) VALUES
(1, 'DEP-1910-0001', 'Keuangan'),
(2, 'DEP-1910-0002', 'Gudang'),
(3, 'DEP-1910-0003', 'HRD'),
(4, 'DEP-1911-0004', 'Marketing');

-- --------------------------------------------------------

--
-- Table structure for table `mst_gaji`
--

CREATE TABLE `mst_gaji` (
  `id_gaji` int(11) NOT NULL,
  `gol_gaji` text NOT NULL,
  `nom_gaji` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_gaji`
--

INSERT INTO `mst_gaji` (`id_gaji`, `gol_gaji`, `nom_gaji`) VALUES
(1, 'Kepala Bagian', 6000000),
(2, 'Staf ', 2500000),
(3, 'Direktur', 7500000),
(4, 'Supervisor', 4000000);

-- --------------------------------------------------------

--
-- Table structure for table `mst_jabatan`
--

CREATE TABLE `mst_jabatan` (
  `id_jabatan` int(11) NOT NULL,
  `kode_jabatan` text NOT NULL,
  `jabatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_jabatan`
--

INSERT INTO `mst_jabatan` (`id_jabatan`, `kode_jabatan`, `jabatan`) VALUES
(1, 'JAB-1910-0001', 'Staf Gudang'),
(2, 'JAB-1910-0002', 'Kepala Gudang'),
(3, 'JAB-1910-0003', 'Staf HRD'),
(4, 'JAB-1911-0004', 'Staf Keuangan'),
(5, 'JAB-1911-0005', 'Staf Marketing');

-- --------------------------------------------------------

--
-- Table structure for table `mst_pegawai`
--

CREATE TABLE `mst_pegawai` (
  `id_pegawai` int(11) NOT NULL,
  `kode_pegawai` text NOT NULL,
  `nama_lengkap` text NOT NULL,
  `sex` text NOT NULL,
  `kota_lahir` text NOT NULL,
  `tgl_lahir` date NOT NULL,
  `alamat_skrg` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `agama` text NOT NULL,
  `no_ktp` int(11) NOT NULL,
  `status` text NOT NULL,
  `pend_akhir` text NOT NULL,
  `image` varchar(250) NOT NULL,
  `pegawai_created` date NOT NULL,
  `pegawai_active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_pegawai`
--

INSERT INTO `mst_pegawai` (`id_pegawai`, `kode_pegawai`, `nama_lengkap`, `sex`, `kota_lahir`, `tgl_lahir`, `alamat_skrg`, `email`, `agama`, `no_ktp`, `status`, `pend_akhir`, `image`, `pegawai_created`, `pegawai_active`) VALUES
(8, 'PEG-1910-0001', 'Donny Kurniawan', 'Pria', 'Kudus', '1979-05-14', 'Singocandi Rt/Rw : 03/01', 'adonia_ata@yahoo.com', 'Kristen', 2147483647, 'Menikah', 'S1', 'default.jpg', '2019-10-30', 1),
(9, 'PEG-1910-0002', 'Ratna Damayanti', 'Wanita', 'Magelang', '1982-12-13', 'Singocandi Rt/Rw : 03/01', 'admin@gmail.com', 'Kristen', 2147483647, 'Menikah', 'S1', 'user7-128x128.jpg', '2019-10-30', 1),
(10, 'PEG-1910-0003', 'Adonia Vincent Natanael', 'Pria', 'Magelang', '2003-01-02', 'Singocandi Rt/Rw : 03/01', 'adonia.service@gmail.com', 'Kristen', 2147483647, 'Belum Menikah', 'S2', 'default.jpg', '2019-10-30', 1),
(11, 'PEG-1910-0004', 'Kusyadi Jayadi', 'Pria', 'Magelang', '2019-10-01', 'Singocandi Rt/Rw : 03/01', 'adonia.service@gmail.com', 'Islam', 2147483647, 'Menikah', 'SMA', 'user6-128x128.jpg', '2019-10-30', 1),
(12, 'PEG-1911-0005', 'Arnold Jumangin', 'Pria', 'Rembang', '1992-06-13', 'Sluke rt/rw : 05/06', 'adonia@gmail.com', 'Islam', 2147483647, 'Menikah', 'D3', 'user1-128x128.jpg', '2019-11-01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mst_user`
--

CREATE TABLE `mst_user` (
  `id_user` int(11) NOT NULL,
  `nama` text NOT NULL,
  `pegawai_kd` text NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` text NOT NULL,
  `level` text NOT NULL,
  `image` varchar(250) NOT NULL,
  `date_created` date NOT NULL,
  `is_active` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_user`
--

INSERT INTO `mst_user` (`id_user`, `nama`, `pegawai_kd`, `username`, `password`, `level`, `image`, `date_created`, `is_active`) VALUES
(24, 'Donny Kurniawan', 'PEG-1910-0001', 'admin', '$2y$10$NBc.y9a47JeDxhuJQlbhne.7LjbskoOtKmEuZupfN.M88Dto/AC8i', 'Admin', 'avatar041.png', '2019-10-30', 1),
(25, 'Ratna Damayanti', 'PEG-1910-0002', 'staf', '$2y$10$1OYKctLn1ssmXumP..y/IOUKWZxkYkKjb7H3uZ6yY2p8ofSaXvL/m', 'Staf', 'avatar2.png', '2019-10-30', 1),
(26, 'Adonia Vincent Natanael', 'PEG-1910-0003', 'ata', '$2y$10$D23DdIAr9bDgcp0h4.uG6OkfQea1whL.3NDhywf9mP7VxDoyWaHj.', 'Staf', 'user8-128x128.jpg', '2019-10-30', 1),
(27, 'Arnold Jumangin', 'PEG-1911-0005', 'arnold', '$2y$10$sVoqV.NudFK9qesYe809lu7xOnomrXP00TrgNTBN8.BlJLSQ5I14q', 'Staf', 'avatar04.png', '2019-11-01', 1),
(28, 'Kusyadi Jayadi', 'PEG-1910-0004', 'kusyadi', '$2y$10$DLH7RKpYQMfvHO6Wrjo8nutuqNoHDj/3qvVYIq9LkjJAvRG1mwN2C', 'Admin', 'user1-128x1281.jpg', '2019-11-01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_cuti`
--

CREATE TABLE `tb_cuti` (
  `id_cuti` int(11) NOT NULL,
  `sess_id` int(11) NOT NULL,
  `kd_pegawai` text NOT NULL,
  `tgl_input` date NOT NULL,
  `jenis_cuti` text NOT NULL,
  `keterangan` text NOT NULL,
  `jml_cuti` int(11) NOT NULL,
  `sisa_cuti` int(11) NOT NULL,
  `tgl_cuti` date NOT NULL,
  `tgl_cuti2` date NOT NULL,
  `tgl_masuk` date NOT NULL,
  `alamat` varchar(150) NOT NULL,
  `telp` varchar(30) NOT NULL,
  `alasan_ditolak` text NOT NULL,
  `atasan` text NOT NULL,
  `is_approve` int(1) NOT NULL COMMENT '0 = Terima, 1 = Tunggu, 2 = Tolak'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_cuti`
--

INSERT INTO `tb_cuti` (`id_cuti`, `sess_id`, `kd_pegawai`, `tgl_input`, `jenis_cuti`, `keterangan`, `jml_cuti`, `sisa_cuti`, `tgl_cuti`, `tgl_cuti2`, `tgl_masuk`, `alamat`, `telp`, `alasan_ditolak`, `atasan`, `is_approve`) VALUES
(58, 25, 'PEG-1910-0002', '2019-12-16', 'Cuti Tahunan', 'acara keluarga', 2, 10, '2019-12-17', '2019-12-19', '2019-12-20', 'Singocandi RT/RW:05/01', '08995625604', '', 'Donny Kurniawan', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_cuti_lain`
--

CREATE TABLE `tb_cuti_lain` (
  `id_cuti_lain` int(11) NOT NULL,
  `sess_id` int(11) NOT NULL,
  `kd_pegawai` text NOT NULL,
  `tgl_input` date NOT NULL,
  `keterangan` text NOT NULL,
  `alamat` text NOT NULL,
  `jenis_cuti` text NOT NULL,
  `telp` text NOT NULL,
  `tgl_cuti` date NOT NULL,
  `tgl_cuti2` date NOT NULL,
  `tgl_masuk` date NOT NULL,
  `alasan_ditolak` text NOT NULL,
  `atasan` text NOT NULL,
  `is_approve` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_cuti_lain`
--

INSERT INTO `tb_cuti_lain` (`id_cuti_lain`, `sess_id`, `kd_pegawai`, `tgl_input`, `keterangan`, `alamat`, `jenis_cuti`, `telp`, `tgl_cuti`, `tgl_cuti2`, `tgl_masuk`, `alasan_ditolak`, `atasan`, `is_approve`) VALUES
(8, 25, 'PEG-1910-0002', '2019-12-16', 'acara keluarga', 'Singocandi RT/RW:05/01', 'Cuti Diluar Tanggungan', '08995625604', '2019-12-16', '2019-12-23', '2019-12-24', '', 'Donny Kurniawan', 0),
(9, 27, 'PEG-1911-0005', '2019-12-15', 'Cuti diluar tanggungan', 'Jl. Dewi Sartika', 'Cuti Lain-lain', '0812286093', '2019-12-03', '2019-12-03', '2019-12-05', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_gaji`
--

CREATE TABLE `tb_gaji` (
  `id_tb_gaji` int(11) NOT NULL,
  `pegawai_kd` text NOT NULL,
  `nominal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_gaji`
--

INSERT INTO `tb_gaji` (`id_tb_gaji`, `pegawai_kd`, `nominal`) VALUES
(1, 'PEG-1910-0001', 6000000),
(2, 'PEG-1910-0002', 2500000),
(3, 'PEG-1910-0004', 4000000),
(4, 'PEG-1910-0003', 2500000),
(5, 'PEG-1911-0005', 2500000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_info`
--

CREATE TABLE `tb_info` (
  `id_info` int(11) NOT NULL,
  `tgl_info` date NOT NULL,
  `info` text NOT NULL,
  `kirim` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_info`
--

INSERT INTO `tb_info` (`id_info`, `tgl_info`, `info`, `kirim`) VALUES
(1, '2019-11-01', 'Pemberitahuan\r\n1. Gaji Awal Tahun ada kenaikan\r\n2. Bonus tahun ini sedikit berkurang\r\n3. Pemenuhan Target Penjualan ada Kenaikan\r\n', 0),
(2, '2019-11-01', 'Lowongan Pekerjaan:\r\nDibutuhkan Programmer Junior untuk mengisi kekurangan pegawai  di bagian Teknik Informatika\r\nKualifikasi:\r\n1.....\r\n2....\r\n3.....', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_informasi`
--

CREATE TABLE `tb_informasi` (
  `id_berita` int(11) NOT NULL,
  `sess_id` int(11) NOT NULL,
  `pegawai_kd` text NOT NULL,
  `tgl_berita` date NOT NULL,
  `isi_berita` text NOT NULL,
  `kirim` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_informasi`
--

INSERT INTO `tb_informasi` (`id_berita`, `sess_id`, `pegawai_kd`, `tgl_berita`, `isi_berita`, `kirim`) VALUES
(1, 26, 'PEG-1910-0003', '2019-10-22', 'Tes4321-edit', 0),
(2, 27, 'PEG-1911-0005', '2019-11-09', 'Pemenuhan Target dan Penjualan Bulan ini harus berkurang karena banyak Customer masih menyimpan stock\r\n\r\nTerima Kasih', 0),
(3, 26, 'PEG-1910-0003', '2019-11-01', 'Mohon untuk Penilaian Ulang karyawan lebih diperhatikan lagi\r\n\r\nTerima Kasih', 0),
(4, 25, 'PEG-1910-0002', '2019-11-01', 'Stok Barang kita kelebihan.. Mohon kepada pesanan ke supplier dikurangi\r\n\r\nTerima Kasih', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_insentif`
--

CREATE TABLE `tb_insentif` (
  `id_insentif` int(11) NOT NULL,
  `pegawai_kd` text NOT NULL,
  `nama_insentif` text NOT NULL,
  `insentif` int(11) NOT NULL,
  `tgl_insentif` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_insentif`
--

INSERT INTO `tb_insentif` (`id_insentif`, `pegawai_kd`, `nama_insentif`, `insentif`, `tgl_insentif`) VALUES
(1, 'PEG-1910-0002', 'Bonus Akhir Tahun', 1500000, '2019-10-22'),
(2, 'PEG-1910-0004', 'Bonus Akhir Tahun', 1500000, '2019-11-01'),
(3, 'PEG-1911-0005', 'Target Penjualan', 4000000, '2019-11-01'),
(4, 'PEG-1910-0003', 'Bonus Akhir Tahun', 1500000, '2019-11-01');

-- --------------------------------------------------------

--
-- Table structure for table `tb_nilai`
--

CREATE TABLE `tb_nilai` (
  `id_nilai` int(11) NOT NULL,
  `peg_kd` text NOT NULL,
  `rapi` text NOT NULL,
  `tanggung` text NOT NULL,
  `disiplin` text NOT NULL,
  `inisiatif` text NOT NULL,
  `kesimpulan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_nilai`
--

INSERT INTO `tb_nilai` (`id_nilai`, `peg_kd`, `rapi`, `tanggung`, `disiplin`, `inisiatif`, `kesimpulan`) VALUES
(1, 'PEG-1910-0002', 'Kurang', 'Cukup', 'Baik', 'Kurang', 'Kurang Baik'),
(2, 'PEG-1910-0001', 'Baik', 'Cukup', 'Baik', 'Kurang', 'Cukup Baik'),
(3, 'PEG-1910-0004', 'Baik', 'Baik', 'Cukup', 'Kurang', 'Cukup Baik'),
(4, 'PEG-1910-0003', 'Kurang', 'Cukup', 'Baik', 'Kurang', 'Kurang Baik'),
(5, 'PEG-1911-0005', 'Baik', 'Baik', 'Baik', 'Baik', 'Sangat Baik');

-- --------------------------------------------------------

--
-- Table structure for table `tb_prestasi`
--

CREATE TABLE `tb_prestasi` (
  `id_prestasi` int(11) NOT NULL,
  `pegawai_kd` text NOT NULL,
  `prestasi` text NOT NULL,
  `tgl_prestasi` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_prestasi`
--

INSERT INTO `tb_prestasi` (`id_prestasi`, `pegawai_kd`, `prestasi`, `tgl_prestasi`) VALUES
(1, 'PEG-1910-0002', 'Disiplin dalam absensi', '2019-10-22'),
(2, 'PEG-1910-0001', 'Kejuaraan Bulu Tangkis Kabupaten', '2019-10-08'),
(3, 'PEG-1911-0005', 'Pelaporan dan Target Penjualan selalu tercapai', '2019-10-15');

-- --------------------------------------------------------

--
-- Table structure for table `tb_struktural`
--

CREATE TABLE `tb_struktural` (
  `id_struktural` int(11) NOT NULL,
  `kode_struktural` text NOT NULL,
  `pegawai_kode` text NOT NULL,
  `divisi_kode` text NOT NULL,
  `jabatan_kode` text NOT NULL,
  `tgl_input` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_struktural`
--

INSERT INTO `tb_struktural` (`id_struktural`, `kode_struktural`, `pegawai_kode`, `divisi_kode`, `jabatan_kode`, `tgl_input`) VALUES
(3, '201910150947100003', 'PEG-1910-0002', 'DEP-1910-0002', 'JAB-1910-0001', '2019-10-15'),
(5, '201910301346520004', 'PEG-1910-0001', 'DEP-1910-0002', 'JAB-1910-0002', '2019-10-30'),
(6, '201910301349330005', 'PEG-1910-0003', 'DEP-1910-0003', 'JAB-1910-0003', '2019-10-30'),
(8, '201911010132450006', 'PEG-1910-0004', 'DEP-1910-0002', 'JAB-1910-0001', '2019-11-01'),
(10, '201911010134080007', 'PEG-1911-0005', 'DEP-1911-0004', 'JAB-1911-0005', '2019-11-01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dt_keluarga`
--
ALTER TABLE `dt_keluarga`
  ADD PRIMARY KEY (`id_keluarga`);

--
-- Indexes for table `mst_divisi`
--
ALTER TABLE `mst_divisi`
  ADD PRIMARY KEY (`id_divisi`);

--
-- Indexes for table `mst_gaji`
--
ALTER TABLE `mst_gaji`
  ADD PRIMARY KEY (`id_gaji`);

--
-- Indexes for table `mst_jabatan`
--
ALTER TABLE `mst_jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indexes for table `mst_pegawai`
--
ALTER TABLE `mst_pegawai`
  ADD PRIMARY KEY (`id_pegawai`);

--
-- Indexes for table `mst_user`
--
ALTER TABLE `mst_user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `tb_cuti`
--
ALTER TABLE `tb_cuti`
  ADD PRIMARY KEY (`id_cuti`);

--
-- Indexes for table `tb_cuti_lain`
--
ALTER TABLE `tb_cuti_lain`
  ADD PRIMARY KEY (`id_cuti_lain`);

--
-- Indexes for table `tb_gaji`
--
ALTER TABLE `tb_gaji`
  ADD PRIMARY KEY (`id_tb_gaji`);

--
-- Indexes for table `tb_info`
--
ALTER TABLE `tb_info`
  ADD PRIMARY KEY (`id_info`);

--
-- Indexes for table `tb_informasi`
--
ALTER TABLE `tb_informasi`
  ADD PRIMARY KEY (`id_berita`);

--
-- Indexes for table `tb_insentif`
--
ALTER TABLE `tb_insentif`
  ADD PRIMARY KEY (`id_insentif`);

--
-- Indexes for table `tb_nilai`
--
ALTER TABLE `tb_nilai`
  ADD PRIMARY KEY (`id_nilai`);

--
-- Indexes for table `tb_prestasi`
--
ALTER TABLE `tb_prestasi`
  ADD PRIMARY KEY (`id_prestasi`);

--
-- Indexes for table `tb_struktural`
--
ALTER TABLE `tb_struktural`
  ADD PRIMARY KEY (`id_struktural`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dt_keluarga`
--
ALTER TABLE `dt_keluarga`
  MODIFY `id_keluarga` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `mst_divisi`
--
ALTER TABLE `mst_divisi`
  MODIFY `id_divisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mst_gaji`
--
ALTER TABLE `mst_gaji`
  MODIFY `id_gaji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mst_jabatan`
--
ALTER TABLE `mst_jabatan`
  MODIFY `id_jabatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `mst_pegawai`
--
ALTER TABLE `mst_pegawai`
  MODIFY `id_pegawai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `mst_user`
--
ALTER TABLE `mst_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tb_cuti`
--
ALTER TABLE `tb_cuti`
  MODIFY `id_cuti` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `tb_cuti_lain`
--
ALTER TABLE `tb_cuti_lain`
  MODIFY `id_cuti_lain` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_gaji`
--
ALTER TABLE `tb_gaji`
  MODIFY `id_tb_gaji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_info`
--
ALTER TABLE `tb_info`
  MODIFY `id_info` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_informasi`
--
ALTER TABLE `tb_informasi`
  MODIFY `id_berita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_insentif`
--
ALTER TABLE `tb_insentif`
  MODIFY `id_insentif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_nilai`
--
ALTER TABLE `tb_nilai`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_prestasi`
--
ALTER TABLE `tb_prestasi`
  MODIFY `id_prestasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_struktural`
--
ALTER TABLE `tb_struktural`
  MODIFY `id_struktural` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
