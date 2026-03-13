-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: sopia_db
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `kategori`
--

DROP TABLE IF EXISTS `kategori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) NOT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori`
--

LOCK TABLES `kategori` WRITE;
/*!40000 ALTER TABLE `kategori` DISABLE KEYS */;
INSERT INTO `kategori` VALUES (1,'Ruang Kelas'),(2,'Toilet'),(3,'Laboratorium'),(4,'Perpustakaan'),(5,'Sarana Olahraga'),(6,'Fasilitas IT'),(7,'Gedung & Infrastruktur'),(8,'Listrik & Air'),(9,'Lainnya');
/*!40000 ALTER TABLE `kategori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengaduan`
--

DROP TABLE IF EXISTS `pengaduan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pengaduan` (
  `id_pengaduan` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi_pengaduan` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('baru','diproses','selesai','ditolak') NOT NULL DEFAULT 'baru',
  PRIMARY KEY (`id_pengaduan`),
  KEY `id_user` (`id_user`),
  KEY `id_kategori` (`id_kategori`),
  CONSTRAINT `fk_pengaduan_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE,
  CONSTRAINT `fk_pengaduan_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengaduan`
--

LOCK TABLES `pengaduan` WRITE;
/*!40000 ALTER TABLE `pengaduan` DISABLE KEYS */;
INSERT INTO `pengaduan` VALUES (3,3,1,'Kipas kelas XII PPLG 1 mati','Kipas mati','704460480_ChatGPT Image Feb 25, 2026, 10_02_52 AM.png','2026-02-26 04:41:20','diproses'),(4,3,6,'komputer tidak menyala','komputer tidak menyala','376243360_logo bi.jpg','2026-02-26 04:54:25','baru'),(6,4,2,'kamar mandi bau','bau jengkol','994006844_ERD pia.drawio.png','2026-02-27 01:35:40','selesai'),(7,6,6,'PC mati','PC mati','509198208_gedung.jpg','2026-03-12 04:51:34','ditolak');
/*!40000 ALTER TABLE `pengaduan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tanggapan`
--

DROP TABLE IF EXISTS `tanggapan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tanggapan`
--

LOCK TABLES `tanggapan` WRITE;
/*!40000 ALTER TABLE `tanggapan` DISABLE KEYS */;
INSERT INTO `tanggapan` VALUES (3,3,1,'kipasnya sedang dibeli belum datang','2026-02-26 04:43:06'),(4,6,1,'sudah dibersihkan dan diberi pewangi','2026-02-27 01:38:14'),(7,7,1,'belum bisa diproses, karena harus membeli yang baru tetapi biayanya belum ada ','2026-03-12 04:53:14'),(8,7,1,'butut','2026-03-12 05:23:03');
/*!40000 ALTER TABLE `tanggapan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','siswa') NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrator','admin','21232f297a57a5a743894a0e4a801fc3','admin'),(3,'Tiara Putri','tiara','202cb962ac59075b964b07152d234b70','siswa'),(4,'Agnes Permatasari','agnes','202cb962ac59075b964b07152d234b70','siswa'),(5,'Ahmad Abdul Azis','azis','202cb962ac59075b964b07152d234b70','siswa'),(6,'Aufa Aulya','aufa','202cb962ac59075b964b07152d234b70','siswa'),(7,'Ayuni Ardiyanti','ayuni','202cb962ac59075b964b07152d234b70','siswa'),(9,'Fitri Lina Ramadani','fitri','202cb962ac59075b964b07152d234b70','siswa'),(11,'Muhamad Zainul Milah','zainul','202cb962ac59075b964b07152d234b70','siswa'),(12,'Nandhia Aprilianti Putri','nandhia','202cb962ac59075b964b07152d234b70','siswa');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-13  6:55:49
