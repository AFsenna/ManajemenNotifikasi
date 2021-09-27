-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Sep 2021 pada 00.08
-- Versi server: 10.4.20-MariaDB
-- Versi PHP: 7.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
(2, 'APK 1', 3, 1);

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
(6, 2, 0),
(6, 10, 1),
(15, 11, 1),
(6, 12, 1),
(13, 12, 1),
(6, 13, 1),
(13, 13, 1),
(14, 13, 0),
(15, 13, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `media`
--

CREATE TABLE `media` (
  `id_media` int(11) NOT NULL,
  `nama_media` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `media`
--

INSERT INTO `media` (`id_media`, `nama_media`) VALUES
(1, 'email'),
(2, 'telegram');

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id_notifikasi` int(11) NOT NULL,
  `aplikasi_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `judul` varchar(128) NOT NULL,
  `isi` longtext NOT NULL,
  `status` int(11) NOT NULL,
  `tanggalDibuat` date NOT NULL,
  `tanggalTerkirim` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `notifikasi`
--

INSERT INTO `notifikasi` (`id_notifikasi`, `aplikasi_id`, `media_id`, `judul`, `isi`, `status`, `tanggalDibuat`, `tanggalTerkirim`) VALUES
(10, 2, 2, 'aku', '<p>kamu</p>', 1, '2021-09-28', '2021-09-28'),
(11, 2, 1, 'axz', '<p>asa</p>', 1, '2021-09-28', '2021-09-28'),
(12, 2, 2, 'haloo', 'dsbgsidjbgisd', 1, '2021-09-28', '2021-09-28'),
(13, 2, 2, 'coba', '<p>ada</p>', 1, '2021-09-28', '2021-09-28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna_aplikasi`
--

CREATE TABLE `pengguna_aplikasi` (
  `id_pengguna` int(11) NOT NULL,
  `aplikasi_id` int(11) NOT NULL,
  `nama_pengguna` varchar(30) NOT NULL,
  `username_telegram` varchar(30) DEFAULT NULL,
  `userid_telegram` varchar(30) DEFAULT NULL,
  `email_pengguna` varchar(30) NOT NULL,
  `notelp_pengguna` varchar(18) NOT NULL,
  `status_pengguna` int(11) NOT NULL,
  `tanggal_dibuat` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengguna_aplikasi`
--

INSERT INTO `pengguna_aplikasi` (`id_pengguna`, `aplikasi_id`, `nama_pengguna`, `username_telegram`, `userid_telegram`, `email_pengguna`, `notelp_pengguna`, `status_pengguna`, `tanggal_dibuat`) VALUES
(6, 2, 'Sennana', 'seennaa', '1626261247', 'Fgelicia@gmail.com', '+6282285132960', 1, '2021-09-27'),
(13, 2, 'Hoshi', 'hodsiador', '654321', 'horange@gmail.com', '+6289907212341', 1, '2021-09-27'),
(14, 2, 'Woozi', NULL, '', 'woahe@gmail.com', '+6285156084242', 1, '2021-09-27'),
(15, 2, 'Haruka', 'harugpa', '', 'haruna@gmail.com', '+6282456084203', 1, '2021-09-27');

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
(1, 'admin notifbell', 'admin', '+628232653623', 'admin@gmail.com', 'admin', 1, 1),
(3, 'user notifbell', 'testing', '+6289912347652', 'testing@gmail.com', 'testing', 2, 1);

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
-- Indeks untuk tabel `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id_media`);

--
-- Indeks untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id_notifikasi`),
  ADD KEY `notifikasi_ibfk_1` (`aplikasi_id`),
  ADD KEY `notifikasi_ibfk_2` (`media_id`);

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
  MODIFY `id_aplikasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `media`
--
ALTER TABLE `media`
  MODIFY `id_media` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id_notifikasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `pengguna_aplikasi`
--
ALTER TABLE `pengguna_aplikasi`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  ADD CONSTRAINT `notifikasi_ibfk_1` FOREIGN KEY (`aplikasi_id`) REFERENCES `aplikasi` (`id_aplikasi`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifikasi_ibfk_2` FOREIGN KEY (`media_id`) REFERENCES `media` (`id_media`) ON DELETE CASCADE;

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
