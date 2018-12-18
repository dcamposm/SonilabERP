-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.1.36-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win32
-- HeidiSQL Versión:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura para tabla slb_db.slb_departaments
CREATE TABLE IF NOT EXISTS `slb_departaments` (
  `id_departament` int(11) NOT NULL AUTO_INCREMENT,
  `nom_departament` varchar(50) NOT NULL DEFAULT 'Nou rol',
  `descripcio_departament` varchar(200) NOT NULL DEFAULT 'Nova descripció',
  PRIMARY KEY (`id_departament`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla slb_db.slb_departaments: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `slb_departaments` DISABLE KEYS */;
/*!40000 ALTER TABLE `slb_departaments` ENABLE KEYS */;

-- Volcando estructura para tabla slb_db.slb_empleats_externs
CREATE TABLE IF NOT EXISTS `slb_empleats_externs` (
  `id_empleat` int(11) NOT NULL AUTO_INCREMENT,
  `nom_empleat` varchar(50) NOT NULL,
  `cognoms_empleat` varchar(100) NOT NULL,
  `sexe_empleat` varchar(10) NOT NULL,
  `nacionalitat_empleat` varchar(30) NOT NULL,
  `imatge_empleat` varchar(250) NOT NULL DEFAULT 'defecte.png',
  `email_empleat` varchar(100) NOT NULL,
  `dni_empleat` varchar(10) NOT NULL,
  `telefon_empleat` varchar(15) NOT NULL,
  `direccio_empleat` varchar(150) NOT NULL,
  `codi_postal` varchar(5) NOT NULL,
  `naixement_empleat` date NOT NULL,
  `nss_empleat` varchar(11) NOT NULL,
  `iban_empleat` varchar(34) NOT NULL,
  `actor` bit(1) NOT NULL DEFAULT b'0',
  `director` bit(1) NOT NULL DEFAULT b'0',
  `tecnic_sala` bit(1) NOT NULL DEFAULT b'0',
  `traductor` bit(1) NOT NULL DEFAULT b'0',
  `ajustador` bit(1) NOT NULL DEFAULT b'0',
  `linguista` bit(1) NOT NULL DEFAULT b'0',
  `preu_actor` double NOT NULL DEFAULT '0',
  `preu_director` double NOT NULL DEFAULT '0',
  `preu_tecnic_sala` double NOT NULL DEFAULT '0',
  `preu_traductor` double NOT NULL DEFAULT '0',
  `preu_ajustador` double NOT NULL DEFAULT '0',
  `preu_linguista` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_empleat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Empleats externs a l''empresa.';

-- Volcando datos para la tabla slb_db.slb_empleats_externs: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `slb_empleats_externs` DISABLE KEYS */;
/*!40000 ALTER TABLE `slb_empleats_externs` ENABLE KEYS */;

-- Volcando estructura para tabla slb_db.slb_idiomes
CREATE TABLE IF NOT EXISTS `slb_idiomes` (
  `id_idioma` int(11) NOT NULL,
  `idioma` varchar(50) NOT NULL,
  PRIMARY KEY (`id_idioma`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla slb_db.slb_idiomes: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `slb_idiomes` DISABLE KEYS */;
/*!40000 ALTER TABLE `slb_idiomes` ENABLE KEYS */;

-- Volcando estructura para tabla slb_db.slb_idiomes_empleats
CREATE TABLE IF NOT EXISTS `slb_idiomes_empleats` (
  `id_empleat` int(11) NOT NULL,
  `id_idioma` int(11) NOT NULL,
  `empleat_homologat` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id_empleat`,`id_idioma`),
  KEY `id_idioma` (`id_idioma`),
  KEY `id_empleat` (`id_empleat`),
  CONSTRAINT `slb_idi_emp_empleat` FOREIGN KEY (`id_empleat`) REFERENCES `slb_empleats_externs` (`id_empleat`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `slb_idi_emp_idioma` FOREIGN KEY (`id_idioma`) REFERENCES `slb_idiomes` (`id_idioma`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla slb_db.slb_idiomes_empleats: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `slb_idiomes_empleats` DISABLE KEYS */;
/*!40000 ALTER TABLE `slb_idiomes_empleats` ENABLE KEYS */;

-- Volcando estructura para tabla slb_db.slb_usuaris
CREATE TABLE IF NOT EXISTS `slb_usuaris` (
  `id_usuari` int(11) NOT NULL AUTO_INCREMENT,
  `nom_usuari` varchar(50) NOT NULL,
  `cognoms_usuari` varchar(100) NOT NULL,
  `email_usuari` varchar(100) NOT NULL,
  `alias_usuari` varchar(255) NOT NULL,
  `contrasenya_usuari` varchar(255) NOT NULL,
  `imatge_usuari` varchar(250) NOT NULL DEFAULT 'defecte.png',
  `token` varchar(100) NOT NULL DEFAULT '',
  `id_departament` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_usuari`),
  KEY `id_departament` (`id_departament`),
  CONSTRAINT `id_departament` FOREIGN KEY (`id_departament`) REFERENCES `slb_departaments` (`id_departament`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='- Usuaris de l''aplicació.\r\n- La contrasenya està encriptada amb bcrypt.';

-- Volcando datos para la tabla slb_db.slb_usuaris: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `slb_usuaris` DISABLE KEYS */;
INSERT INTO `slb_usuaris` (`id_usuari`, `nom_usuari`, `cognoms_usuari`, `email_usuari`, `alias_usuari`, `contrasenya_usuari`, `imatge_usuari`, `token`, `id_departament`) VALUES
	(1, 'Test', 'Tester', 'test@test.es', 'test', '$2y$10$vVP1TnX9SXrcPvVVQwVzdOlQ5dym730rUMxqgGGZZjWh7p1LdqWSa', 'defecte.png', '', NULL);
/*!40000 ALTER TABLE `slb_usuaris` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
