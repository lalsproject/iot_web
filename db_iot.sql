-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versi server:                 10.4.24-MariaDB - mariadb.org binary distribution
-- OS Server:                    Win64
-- HeidiSQL Versi:               12.5.0.6702
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- membuang struktur untuk table db_iot.tbl_login
CREATE TABLE IF NOT EXISTS `tbl_login` (
  `IdLogin` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `Role` set('admin') NOT NULL DEFAULT 'admin',
  `LastLogin` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `StatusLogin` varchar(4) NOT NULL DEFAULT 'OFF',
  PRIMARY KEY (`IdLogin`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Membuang data untuk tabel db_iot.tbl_login: ~1 rows (lebih kurang)
DELETE FROM `tbl_login`;
INSERT INTO `tbl_login` (`IdLogin`, `username`, `password`, `Role`, `LastLogin`, `StatusLogin`) VALUES
	(1, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 'admin', '2024-02-26 12:56:31', 'OFF');

-- membuang struktur untuk table db_iot.tbl_relay
CREATE TABLE IF NOT EXISTS `tbl_relay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `relay1` enum('1','0') NOT NULL DEFAULT '0',
  `relay2` enum('1','0') NOT NULL DEFAULT '0',
  `regdate` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Membuang data untuk tabel db_iot.tbl_relay: ~0 rows (lebih kurang)
DELETE FROM `tbl_relay`;

-- membuang struktur untuk table db_iot.tbl_sensor
CREATE TABLE IF NOT EXISTS `tbl_sensor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `suhu` int(11) NOT NULL DEFAULT 0,
  `kelembapan` int(11) NOT NULL DEFAULT 0,
  `batas_suhu` int(11) NOT NULL DEFAULT 0,
  `regdate` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Membuang data untuk tabel db_iot.tbl_sensor: ~0 rows (lebih kurang)
DELETE FROM `tbl_sensor`;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
