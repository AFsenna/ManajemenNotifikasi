-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Sep 2021 pada 14.06
-- Versi server: 10.1.40-MariaDB
-- Versi PHP: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `notifbell`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `aplikasi`
--

CREATE TABLE `aplikasi` (
  `id_aplikasi` int(11) NOT NULL,
  `nama_aplikasi` varchar(30) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `aplikasi`
--

INSERT INTO `aplikasi` (`id_aplikasi`, `nama_aplikasi`, `user_id`, `status`) VALUES
(1, 'Cabriz', 2, 1),
(2, 'Naest', 2, 1),
(3, 'sa', 2, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_notifikasi`
--

CREATE TABLE `detail_notifikasi` (
  `pengguna_id` int(11) NOT NULL,
  `notifikasi_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `detail_notifikasi`
--

INSERT INTO `detail_notifikasi` (`pengguna_id`, `notifikasi_id`, `status`) VALUES
(1, 2, 1),
(9, 2, 1),
(10, 2, 1),
(11, 2, 1),
(12, 4, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id_notifikasi` int(11) NOT NULL,
  `aplikasi_id` int(11) NOT NULL,
  `judul` varchar(128) NOT NULL,
  `isi` longtext NOT NULL,
  `status` int(11) NOT NULL,
  `tanggalDibuat` date NOT NULL,
  `tanggalTerkirim` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `notifikasi`
--

INSERT INTO `notifikasi` (`id_notifikasi`, `aplikasi_id`, `judul`, `isi`, `status`, `tanggalDibuat`, `tanggalTerkirim`) VALUES
(2, 1, 'testing', '<p><b>haloo</b></p>', 1, '2021-09-16', '2021-09-02'),
(3, 1, 'Pemotongan Gaji', '<p>dassa</p>', 0, '2021-08-03', '0000-00-00'),
(4, 2, 'Pembayaran Uang Kas', '<p><b>Selamat siang, </b></p><ul><li><u>diharapkan untuk segera membayar kas karena akan segera diadakan pembukuan</u></li></ul>', 0, '2021-09-02', '0000-00-00'),
(5, 3, 'Pengumpulan Laporan PJK', 'Deadline pengumpulan PJK : Senin <br>\r\nHarap segera dikumpulkan!!!!!', 0, '2021-09-01', '0000-00-00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna_aplikasi`
--

CREATE TABLE `pengguna_aplikasi` (
  `id_pengguna` int(11) NOT NULL,
  `aplikasi_id` int(11) NOT NULL,
  `nama_pengguna` varchar(30) NOT NULL,
  `email_pengguna` varchar(30) NOT NULL,
  `notelp_pengguna` varchar(18) NOT NULL,
  `status_pengguna` int(11) NOT NULL,
  `tanggal_dibuat` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengguna_aplikasi`
--

INSERT INTO `pengguna_aplikasi` (`id_pengguna`, `aplikasi_id`, `nama_pengguna`, `email_pengguna`, `notelp_pengguna`, `status_pengguna`, `tanggal_dibuat`) VALUES
(1, 1, 'Senna', 'sagoliacais@gmail.com', '+62822853122960', 1, '2021-08-11'),
(9, 1, 'Felicia Seanne', 'Fgelicia@gmail.com', '+62822853122960', 1, '2021-09-01'),
(10, 1, 'Hoshi', 'horange@gmail.com', '089907212341', 1, '2021-09-02'),
(11, 1, 'Woozi', 'woahe@gmail.com', '085156084242', 1, '2021-09-01'),
(12, 2, 'Senna', 'senna@gmail.com', '085156084243', 1, '2021-09-01'),
(13, 1, 'Senna', 'senna@gmail.com', '085156084243', 1, '2021-09-01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `nama` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`id_role`, `nama`) VALUES
(1, 'Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Struktur dari tabel `token`
--

CREATE TABLE `token` (
  `id_token` int(11) NOT NULL,
  `token` varchar(15) NOT NULL,
  `date` int(11) NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama_lengkap` varchar(128) NOT NULL,
  `username` varchar(15) NOT NULL,
  `notelp` varchar(18) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama_lengkap`, `username`, `notelp`, `email`, `password`, `role_id`, `status`) VALUES
(1, 'Admin Notifbell', 'senna', '082285132960', 'fgelicia@gmail.com', '$2y$10$kKAVgxSgiz4XMrxlvSPLVu7m.tAje1tXkB074JWp/BBx1uGdlkg9C', 1, 1),
(2, 'Michael Araona Wily', 'Michael', '089912347653', 'araona@gmail.com', '$2y$10$dtpCI5WXuC3yhluu0S1Y0eF9HiNFDKfqHqooQqHAOmnf7MFDLTsy2', 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `aplikasi`
--
ALTER TABLE `aplikasi`
  ADD PRIMARY KEY (`id_aplikasi`),
  ADD KEY `aplikasi_ibfk_1` (`user_id`);

--
-- Indeks untuk tabel `detail_notifikasi`
--
ALTER TABLE `detail_notifikasi`
  ADD KEY `detail_notifikasi_ibfk_1` (`pengguna_id`),
  ADD KEY `detail_notifikasi_ibfk_2` (`notifikasi_id`);

--
-- Indeks untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id_notifikasi`),
  ADD KEY `notifikasi_ibfk_1` (`aplikasi_id`);

--
-- Indeks untuk tabel `pengguna_aplikasi`
--
ALTER TABLE `pengguna_aplikasi`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD KEY `pengguna_aplikasi_ibfk_1` (`aplikasi_id`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indeks untuk tabel `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`id_token`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `user_ibfk_1` (`role_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `aplikasi`
--
ALTER TABLE `aplikasi`
  MODIFY `id_aplikasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id_notifikasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pengguna_aplikasi`
--
ALTER TABLE `pengguna_aplikasi`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `token`
--
ALTER TABLE `token`
  MODIFY `id_token` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `aplikasi`
--
ALTER TABLE `aplikasi`
  ADD CONSTRAINT `aplikasi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `detail_notifikasi`
--
ALTER TABLE `detail_notifikasi`
  ADD CONSTRAINT `detail_notifikasi_ibfk_1` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna_aplikasi` (`id_pengguna`),
  ADD CONSTRAINT `detail_notifikasi_ibfk_2` FOREIGN KEY (`notifikasi_id`) REFERENCES `notifikasi` (`id_notifikasi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_ibfk_1` FOREIGN KEY (`aplikasi_id`) REFERENCES `aplikasi` (`id_aplikasi`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengguna_aplikasi`
--
ALTER TABLE `pengguna_aplikasi`
  ADD CONSTRAINT `pengguna_aplikasi_ibfk_1` FOREIGN KEY (`aplikasi_id`) REFERENCES `aplikasi` (`id_aplikasi`);

--
-- Ketidakleluasaan untuk tabel `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
