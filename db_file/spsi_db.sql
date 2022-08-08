-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Agu 2022 pada 11.36
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spsi_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User');

-- --------------------------------------------------------

--
-- Struktur dari tabel `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_jabatan_org`
--

CREATE TABLE `m_jabatan_org` (
  `id` int(11) NOT NULL,
  `nama` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `m_jabatan_org`
--

INSERT INTO `m_jabatan_org` (`id`, `nama`) VALUES
(1, 'KETUA'),
(2, 'WAKIL KETUA'),
(3, 'SEKERTARIS'),
(4, 'BENDAHARA'),
(7, 'SEKSI KEAMANAN'),
(8, 'SEKSI KEROHANIAN'),
(9, 'SEKSI HUMAS');

-- --------------------------------------------------------

--
-- Struktur dari tabel `struktur_org`
--

CREATE TABLE `struktur_org` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `jabatan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `struktur_org`
--

INSERT INTO `struktur_org` (`id`, `user_id`, `jabatan_id`) VALUES
(1, 10, 1),
(2, 3, 2),
(3, 6, 3),
(4, 11, 4),
(9, 12, 7),
(10, 5, 8);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_berita`
--

CREATE TABLE `tbl_berita` (
  `id` int(11) NOT NULL,
  `tgl_post` date NOT NULL,
  `judul` text NOT NULL,
  `isi` text NOT NULL,
  `gambar` text NOT NULL,
  `pembuat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_berita`
--

INSERT INTO `tbl_berita` (`id`, `tgl_post`, `judul`, `isi`, `gambar`, `pembuat`) VALUES
(24, '2022-08-08', 'Demo Buruh Longmarch Bandung – Jakarta, Tuntut Penghapusan Omnibus Law', '<h1><span style=\"font-family:Comic Sans MS,cursive\"><em><strong>Demo Buruh Longmarch Bandung &ndash; Jakarta, Tuntut Penghapusan Omnibus Law</strong></em></span></h1>\r\n\r\n<p>Ratusan massa buruh menggelar longmarch Bandung &ndash; Jakarta. Sekitar 200 peserta aksi berangkat dari Gedung Sate Bandung, Jawa Barat. Rencananya mereka akan berjalan kaki selama 5 hari hingga tiba di Gedung DPR RI Jakarta pada 10/8/2022.<br />\r\n<br />\r\nNantinya mereka akan menggelar demo di DPR RI menuntut penghapusan Omnibus Law. Peserta aksi akan melewati jalur Kab. Bandung Barat, Purwakarta, Karawang, Bekasi, hingga Jakarta. Diperkirakan peserta aksi akan terus bertambah di setiap kota.<br />\r\n&nbsp;</p>\r\n', 'test.jpg', 1),
(25, '2022-08-08', 'Aksi Unjuk Rasa Buruh Tuntut Ratifikasi Konvensi ILO', '<p><img alt=\"\" src=\"https://pict.sindonews.net/webp/1280/salsabila/photo/2022/06/21/1/30539/G-aksi-unjuk-rasa-buruh-tuntut-ratifikasi-konvensi-ilo-tyb.webp\" style=\"height:333px; width:500px\" /></p>\r\n\r\n<p>Sejumlah buruh perwakilan dari beberapa organisasi pekerja berunjuk rasa di depan Kantor kementerian Tenaga Kerja (Kemenaker), Jakarta, Selasa (210/6/2022).</p>\r\n\r\n<p>Mereka meminta pemerintah untuk dapat segera meratifikasi konvensi Organisasi Perburuhan Internasional (ILO) Nomor 190 tahun 2019 tentang Penghapusan Kekerasan dan Pelecehan di Dunia Kerja. ANTARA FOTO/Aditya Pradana Putra/tom.</p>\r\n', 'test.jpg', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_kegiatan`
--

CREATE TABLE `tbl_kegiatan` (
  `id` int(11) NOT NULL,
  `tgl` date NOT NULL,
  `jam` time NOT NULL,
  `desc` text NOT NULL,
  `lokasi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_kegiatan`
--

INSERT INTO `tbl_kegiatan` (`id`, `tgl`, `jam`, `desc`, `lokasi`) VALUES
(2, '2022-08-10', '20:38:00', 'RAPAT KORDIANASI PUK BULANAN', 'Hotel Harper'),
(3, '2022-08-01', '15:35:00', 'RAKERNAS SPSI SEINDONESIA', 'Plaza Hotel JAKARTA');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pengunduran_diri`
--

CREATE TABLE `tbl_pengunduran_diri` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `alasan_pengunduran_diri` text NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_pengunduran_diri`
--

INSERT INTO `tbl_pengunduran_diri` (`id`, `user_id`, `alasan_pengunduran_diri`, `status`) VALUES
(1, 14, 'Akan Bekerja Keluar Negri.', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(254) NOT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_selector` varchar(255) DEFAULT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL COMMENT '0=not active, 1=active, 2=mengundurkan diri',
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `departemen` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `user_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `email`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `departemen`, `phone`, `user_img`) VALUES
(1, '127.0.0.1', 'administrator', '5f4dcc3b5aa765d61d8327deb882cf99', 'admin@admin.com', NULL, '', NULL, NULL, NULL, NULL, NULL, 1268889823, 1659421843, 1, 'Admin', 'istrator', 'ADMIN', '0', 'default_profile.svg'),
(3, '::1', 'rizkyokt', 'f9e94b28c1f37bef7f57e9715a9c3b90', 'rizkyokt1994@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1659421925, 1659422017, 1, 'Rizky', 'Ardiansyah', 'OKTAN TECH. Inc', '087790001615', 'default_profile.svg'),
(5, '::1', 'Rizky', '202cb962ac59075b964b07152d234b70', 'rz.oktan@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1659683587, NULL, 1, 'Rizky', 'Oktan', 'OKTAN TECH. Inc', '087790001615', 'default_profile.svg'),
(6, '::1', 'Bayu', '482c811da5d5b4bc6d497ffa98491e38', 'bayu@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1659685660, NULL, 1, 'Bayu', 'Prasetio', 'GALUDRA TBK', '087790001615', 'default_profile.svg'),
(10, '::1', 'Irsan', '482c811da5d5b4bc6d497ffa98491e38', 'irsan@stt-wastukancana.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1659755273, NULL, 1, 'Irsan', 'Jaelani', 'KAOS DISABLON', '087790001615', 'default_profile.svg'),
(11, '::1', 'Wulan', '482c811da5d5b4bc6d497ffa98491e38', 'wulan@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1659768118, NULL, 1, 'Wulan', 'Dari', 'MAKAN MAKAN TBK', '087790001615', 'default_profile.svg'),
(12, '::1', 'TATANG', '482c811da5d5b4bc6d497ffa98491e38', 'tatang@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1659768166, NULL, 1, 'TATANG', 'KULINTANG', 'OKTAN TECH. Inc', '087790001615', 'default_profile.svg'),
(13, '::1', 'Asep', '482c811da5d5b4bc6d497ffa98491e38', 'asep@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1659930113, NULL, 1, 'Asep', 'Gir', 'Warehouse', '087790001615', 'default_profile.svg'),
(14, '::1', 'WIWIN', '202cb962ac59075b964b07152d234b70', 'wiwin@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1659930218, NULL, 1, 'WIWIN', 'WNI', 'ASSEMBING', '087790001615', 'default_profile.svg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(14, 3, 2),
(6, 5, 2),
(7, 6, 2),
(11, 10, 2),
(12, 11, 2),
(13, 12, 2),
(15, 13, 2),
(16, 14, 2);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `m_jabatan_org`
--
ALTER TABLE `m_jabatan_org`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `struktur_org`
--
ALTER TABLE `struktur_org`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `jabaran_id` (`jabatan_id`);

--
-- Indeks untuk tabel `tbl_berita`
--
ALTER TABLE `tbl_berita`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_kegiatan`
--
ALTER TABLE `tbl_kegiatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_pengunduran_diri`
--
ALTER TABLE `tbl_pengunduran_diri`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_email` (`email`),
  ADD UNIQUE KEY `uc_activation_selector` (`activation_selector`),
  ADD UNIQUE KEY `uc_forgotten_password_selector` (`forgotten_password_selector`),
  ADD UNIQUE KEY `uc_remember_selector` (`remember_selector`);

--
-- Indeks untuk tabel `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `m_jabatan_org`
--
ALTER TABLE `m_jabatan_org`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `struktur_org`
--
ALTER TABLE `struktur_org`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tbl_berita`
--
ALTER TABLE `tbl_berita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `tbl_kegiatan`
--
ALTER TABLE `tbl_kegiatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tbl_pengunduran_diri`
--
ALTER TABLE `tbl_pengunduran_diri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
