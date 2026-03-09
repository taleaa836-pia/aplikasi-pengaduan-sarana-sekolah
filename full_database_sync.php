<?php
include "config/koneksi.php";
$sql = <<<'SQL'
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','siswa') NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id_user`,`nama`,`username`,`password`,`role`) VALUES ('1','Administrator','admin','21232f297a57a5a743894a0e4a801fc3','admin');
INSERT INTO `users` (`id_user`,`nama`,`username`,`password`,`role`) VALUES ('3','Tiara Putri','tiara','202cb962ac59075b964b07152d234b70','siswa');
INSERT INTO `users` (`id_user`,`nama`,`username`,`password`,`role`) VALUES ('4','Agnes Permatasari','agnes','202cb962ac59075b964b07152d234b70','siswa');
INSERT INTO `users` (`id_user`,`nama`,`username`,`password`,`role`) VALUES ('5','Ahmad Abdul Azis','azis','202cb962ac59075b964b07152d234b70','siswa');
INSERT INTO `users` (`id_user`,`nama`,`username`,`password`,`role`) VALUES ('6','Aufa Aulya','aufa','202cb962ac59075b964b07152d234b70','siswa');
INSERT INTO `users` (`id_user`,`nama`,`username`,`password`,`role`) VALUES ('7','Ayuni Ardiyanti','ayuni','202cb962ac59075b964b07152d234b70','siswa');
INSERT INTO `users` (`id_user`,`nama`,`username`,`password`,`role`) VALUES ('9','Fitri Lina Ramadani','fitri','202cb962ac59075b964b07152d234b70','siswa');
INSERT INTO `users` (`id_user`,`nama`,`username`,`password`,`role`) VALUES ('11','Muhamad Zainul Milah','zainul','202cb962ac59075b964b07152d234b70','siswa');
INSERT INTO `users` (`id_user`,`nama`,`username`,`password`,`role`) VALUES ('12','Nandhia Aprilianti Putri','nandhia','202cb962ac59075b964b07152d234b70','siswa');

DROP TABLE IF EXISTS `kategori`;
CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) NOT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `kategori` (`id_kategori`,`nama_kategori`) VALUES ('1','Ruang Kelas');
INSERT INTO `kategori` (`id_kategori`,`nama_kategori`) VALUES ('2','Toilet');
INSERT INTO `kategori` (`id_kategori`,`nama_kategori`) VALUES ('3','Laboratorium');
INSERT INTO `kategori` (`id_kategori`,`nama_kategori`) VALUES ('4','Perpustakaan');
INSERT INTO `kategori` (`id_kategori`,`nama_kategori`) VALUES ('5','Sarana Olahraga');
INSERT INTO `kategori` (`id_kategori`,`nama_kategori`) VALUES ('6','Fasilitas IT');
INSERT INTO `kategori` (`id_kategori`,`nama_kategori`) VALUES ('7','Gedung & Infrastruktur');
INSERT INTO `kategori` (`id_kategori`,`nama_kategori`) VALUES ('8','Listrik & Air');
INSERT INTO `kategori` (`id_kategori`,`nama_kategori`) VALUES ('9','Lainnya');

DROP TABLE IF EXISTS `pengaduan`;
CREATE TABLE `pengaduan` (
  `id_pengaduan` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi_pengaduan` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('baru','diproses','selesai') NOT NULL DEFAULT 'baru',
  PRIMARY KEY (`id_pengaduan`),
  KEY `id_user` (`id_user`),
  KEY `id_kategori` (`id_kategori`),
  CONSTRAINT `fk_pengaduan_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE,
  CONSTRAINT `fk_pengaduan_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `pengaduan` (`id_pengaduan`,`id_user`,`id_kategori`,`judul`,`isi_pengaduan`,`gambar`,`tanggal`,`status`) VALUES ('3','3','1','Kipas kelas XII PPLG 1 mati','Kipas mati','704460480_ChatGPT Image Feb 25, 2026, 10_02_52 AM.png','2026-02-26 04:41:20','diproses');
INSERT INTO `pengaduan` (`id_pengaduan`,`id_user`,`id_kategori`,`judul`,`isi_pengaduan`,`gambar`,`tanggal`,`status`) VALUES ('4','3','6','komputer tidak menyala','komputer tidak menyala','376243360_logo bi.jpg','2026-02-26 04:54:25','baru');
INSERT INTO `pengaduan` (`id_pengaduan`,`id_user`,`id_kategori`,`judul`,`isi_pengaduan`,`gambar`,`tanggal`,`status`) VALUES ('6','4','2','kamar mandi bau','bau jengkol','994006844_ERD pia.drawio.png','2026-02-27 01:35:40','selesai');

DROP TABLE IF EXISTS `tanggapan`;
CREATE TABLE `tanggapan` (
  `id_tanggapan` int(11) NOT NULL AUTO_INCREMENT,
  `id_pengaduan` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `isi_tanggapan` text NOT NULL,
  `tanggal_tanggapan` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_tanggapan`),
  KEY `id_pengaduan` (`id_pengaduan`),
  KEY `id_admin` (`id_admin`),
  CONSTRAINT `fk_tanggapan_admin` FOREIGN KEY (`id_admin`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  CONSTRAINT `fk_tanggapan_pengaduan` FOREIGN KEY (`id_pengaduan`) REFERENCES `pengaduan` (`id_pengaduan`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tanggapan` (`id_tanggapan`,`id_pengaduan`,`id_admin`,`isi_tanggapan`,`tanggal_tanggapan`) VALUES ('3','3','1','kipasnya sedang dibeli belum datang','2026-02-26 04:43:06');
INSERT INTO `tanggapan` (`id_tanggapan`,`id_pengaduan`,`id_admin`,`isi_tanggapan`,`tanggal_tanggapan`) VALUES ('4','6','1','sudah dibersihkan dan diberi pewangi','2026-02-27 01:38:14');

SET FOREIGN_KEY_CHECKS = 1;

SQL;

echo "<h2>Full Database Synchronization</h2>";
if (mysqli_multi_query($koneksi, $sql)) {
    do {
        if ($result = mysqli_store_result($koneksi)) {
            mysqli_free_result($result);
        }
    } while (mysqli_next_result($koneksi));
    echo "<p style='color:green;'>✅ Semua tabel (users, kategori, pengaduan, tanggapan) berhasil disinkronkan!</p>";
} else {
    echo "<p style='color:red;'>❌ Gagal sinkronisasi: " . mysqli_error($koneksi) . "</p>";
}
echo "<a href='index.php'>Kembali ke Dashboard</a>";
?>