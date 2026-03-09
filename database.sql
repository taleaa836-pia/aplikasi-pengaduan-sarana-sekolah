-- Database: `sopia_db`

CREATE DATABASE IF NOT EXISTS `sopia_db`;
USE `sopia_db`;

-- Table structure for table `users`
CREATE TABLE `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL, -- MD5 hash
  `role` enum('admin','siswa') NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table `users`
-- password: admin (MD5: 21232f297a57a5a743894a0e4a801fc3)
INSERT INTO `users` (`nama`, `username`, `password`, `role`) VALUES
('Administrator', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
('Siswa Satu', 'siswa', '21232f297a57a5a743894a0e4a801fc3', 'siswa');

-- Table structure for table `kategori`
CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) NOT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table `kategori`
INSERT INTO `kategori` (`nama_kategori`) VALUES
('Sarana Prasarana'),
('Kebersihan'),
('Keamanan'),
('Lainnya');

-- Table structure for table `pengaduan`
CREATE TABLE `pengaduan` (
  `id_pengaduan` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi_pengaduan` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('baru','diproses','selesai') NOT NULL DEFAULT 'baru',
  PRIMARY KEY (`id_pengaduan`),
  KEY `id_user` (`id_user`),
  KEY `id_kategori` (`id_kategori`),
  CONSTRAINT `fk_pengaduan_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  CONSTRAINT `fk_pengaduan_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `tanggapan`
CREATE TABLE `tanggapan` (
  `id_tanggapan` int(11) NOT NULL AUTO_INCREMENT,
  `id_pengaduan` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `isi_tanggapan` text NOT NULL,
  `tanggal_tanggapan` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_tanggapan`),
  KEY `id_pengaduan` (`id_pengaduan`),
  KEY `id_admin` (`id_admin`),
  CONSTRAINT `fk_tanggapan_pengaduan` FOREIGN KEY (`id_pengaduan`) REFERENCES `pengaduan` (`id_pengaduan`) ON DELETE CASCADE,
  CONSTRAINT `fk_tanggapan_admin` FOREIGN KEY (`id_admin`) REFERENCES `users` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
