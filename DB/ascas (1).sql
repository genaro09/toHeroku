-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2017 at 12:09 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ascas`
--

-- --------------------------------------------------------

--
-- Table structure for table `cargos`
--

CREATE TABLE `cargos` (
  `idCargos` int(11) NOT NULL,
  `idDepartamento` int(11) DEFAULT NULL,
  `NombreCargo` varchar(155) NOT NULL,
  `Descripcion` varchar(255) NOT NULL,
  `PEmpleado` int(11) DEFAULT NULL,
  `PPlanilla` int(11) DEFAULT NULL,
  `PJefe` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16le;

--
-- Dumping data for table `cargos`
--

INSERT INTO `cargos` (`idCargos`, `idDepartamento`, `NombreCargo`, `Descripcion`, `PEmpleado`, `PPlanilla`, `PJefe`) VALUES
(1, 1, 'DEFAULT', 'Cargo generado por DEFAULT', 0, 0, 0),
(2, 2, 'TODOS_LOS_PERMISOS', 'USUARIO QUE TIENE TODOS LOS PERMISOS', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cod_departamento`
--

CREATE TABLE `cod_departamento` (
  `idCod_Departamento` int(11) NOT NULL,
  `idCod_Pais` int(11) NOT NULL,
  `Nombre_Departamento` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16le;

--
-- Dumping data for table `cod_departamento`
--

INSERT INTO `cod_departamento` (`idCod_Departamento`, `idCod_Pais`, `Nombre_Departamento`) VALUES
(1, 222, 'AHUACHAPAN'),
(2, 222, 'SANTA ANA'),
(3, 222, 'SONSONATE'),
(4, 222, 'CHALATENANGO'),
(5, 222, 'LA LIBERTAD'),
(6, 222, 'SAN SALVADOR'),
(7, 222, 'CUSCATLAN'),
(8, 222, 'LA PAZ'),
(9, 222, 'CABAÑAS'),
(10, 222, 'SAN VICENTE'),
(11, 222, 'USULUTAN'),
(12, 222, 'SAN MIGUEL'),
(13, 222, 'MORAZAN'),
(14, 222, 'LA UNION');

-- --------------------------------------------------------

--
-- Table structure for table `cod_municipio`
--

CREATE TABLE `cod_municipio` (
  `idCod_Municipio` int(11) NOT NULL,
  `idCod_Departamento` int(11) NOT NULL,
  `Nombre_Municipio` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16le;

--
-- Dumping data for table `cod_municipio`
--

INSERT INTO `cod_municipio` (`idCod_Municipio`, `idCod_Departamento`, `Nombre_Municipio`) VALUES
(101, 1, 'AHUACHAPAN'),
(102, 1, 'APANECA'),
(103, 1, 'ATIQUIZAYA'),
(104, 1, 'CONCEPCION DE ATACO'),
(105, 1, 'EL REFUGIO'),
(106, 1, 'GUAYMANGO'),
(107, 1, 'JUJUTLA'),
(108, 1, 'SAN FRANCISCO MENENDEZ'),
(109, 1, 'SAN LORENZO'),
(110, 1, 'SAN PEDRO PUXTLA'),
(111, 1, 'TACUBA'),
(112, 1, 'TURIN'),
(201, 2, 'CANDELARIA DE LA FRONTERA'),
(202, 2, 'COATEPEQUE'),
(203, 2, 'CHALCHUAPA'),
(204, 2, 'EL CONGO'),
(205, 2, 'EL PORVENIR'),
(206, 2, 'MASAHUAT'),
(207, 2, 'METAPAN'),
(208, 2, 'SAN ANTONIO PAJONAL'),
(209, 2, 'SAN SEBASTIAN SALITRILLO'),
(210, 2, 'SANTA ANA'),
(211, 2, 'SANTA ROSA GUACHIPILIN'),
(212, 2, 'SANTIAGO DE LA FRONTERA'),
(213, 2, 'TEXISTEPEQUE'),
(301, 3, 'ACAJUTLA'),
(302, 3, 'ARMENIA'),
(303, 3, 'CALUCO'),
(304, 3, 'CUISNAHUAT'),
(305, 3, 'SANTA ISABEL ISHUATAN'),
(306, 3, 'IZALCO'),
(307, 3, 'JUAYUA'),
(308, 3, 'NAHUIZALCO'),
(309, 3, 'NAHUILINGO'),
(310, 3, 'SALCOATITAN'),
(311, 3, 'SAN ANTONIO DEL MONTE'),
(312, 3, 'SAN JULIAN'),
(313, 3, 'SANTA CATARINA MASAHUAT'),
(314, 3, 'SANTO DOMINGO DE GUZMAN'),
(315, 3, 'SONSONATE'),
(316, 3, 'SONZACATE'),
(401, 4, 'AGUA CALIENTE'),
(402, 4, 'ARCATAO'),
(403, 4, 'AZACUALPA'),
(404, 4, 'CITALA'),
(405, 4, 'COMALAPA'),
(406, 4, 'CONCEPCION QUEZALTEPEQUE'),
(407, 4, 'CHALATENANGO'),
(408, 4, 'DULCE NOMBRE DE MARIA'),
(409, 4, 'EL CARRIZAL'),
(410, 4, 'EL PARAISO'),
(411, 4, 'LA LAGUNA'),
(412, 4, 'LA PALMA'),
(413, 4, 'LA REINA'),
(414, 4, 'LAS VUELTAS'),
(415, 4, 'NOMBRE DE JESUS'),
(416, 4, 'NUEVA CONCEPCION'),
(417, 4, 'NUEVA TRINIDAD'),
(418, 4, 'OJOS DE AGUA'),
(419, 4, 'POTONICO'),
(420, 4, 'SAN ANTONIO DE LA CRUZ'),
(421, 4, 'SAN ANTONIO DE LOS RANCHOS'),
(422, 4, 'SAN FERNANDO'),
(423, 4, 'SAN FRANCISCO LEMPA'),
(424, 4, 'SAN FRANCISCO MORAZAN'),
(425, 4, 'SAN IGNACIO'),
(426, 4, 'SAN ISIDRO LABRADOR'),
(427, 4, 'SAN JOSE CANCASQUE'),
(428, 4, 'SAN JOSE LAS FLORES'),
(429, 4, 'SAN LUIS DEL CARMEN'),
(430, 4, 'SAN MIGUEL DE MERCEDES'),
(431, 4, 'SAN RAFAEL'),
(432, 4, 'SANTA RITA'),
(433, 4, 'TEJUTLA'),
(501, 5, 'ANTIGUO CUSCATLAN'),
(502, 5, 'CIUDAD ARCE'),
(503, 5, 'COLON'),
(504, 5, 'COMASAGUA'),
(505, 5, 'CHILTIUPAN'),
(506, 5, 'HUIZUCAR'),
(507, 5, 'JAYAQUE'),
(508, 5, 'JICALAPA'),
(509, 5, 'LA LIBERTAD'),
(510, 5, 'NUEVO CUSCATLAN'),
(511, 5, 'SANTA TECLA'),
(512, 5, 'QUEZALTEPEQUE'),
(513, 5, 'SACACOYO'),
(514, 5, 'SAN JOSE VILLANUEVA'),
(515, 5, 'SAN JUAN OPICO'),
(516, 5, 'SAN MATIAS'),
(517, 5, 'SAN PABLO TACACHICO'),
(518, 5, 'TAMANIQUE'),
(519, 5, 'TALNIQUE'),
(520, 5, 'TEOTEPEQUE'),
(521, 5, 'TEPECOYO'),
(522, 5, 'ZARAGOZA'),
(601, 6, 'AGUILARES'),
(602, 6, 'APOPA'),
(603, 6, 'AYUTUXTEPEQUE'),
(604, 6, 'CUSCATANCINGO'),
(605, 6, 'EL PAISNAL'),
(606, 6, 'GUAZAPA'),
(607, 6, 'ILOPANGO'),
(608, 6, 'MEJICANOS'),
(609, 6, 'NEJAPA'),
(610, 6, 'PANCHIMALCO'),
(611, 6, 'ROSARIO DE MORA'),
(612, 6, 'SAN MARCOS'),
(613, 6, 'SAN MARTIN'),
(614, 6, 'SAN SALVADOR'),
(615, 6, 'SANTIAGO TEXACUANGOS'),
(616, 6, 'SANTO TOMAS'),
(617, 6, 'SOYAPANGO'),
(618, 6, 'TONACATEPEQUE'),
(619, 6, 'CIUDAD DELGADO'),
(701, 7, 'CANDELARIA'),
(702, 7, 'COJUTEPEQUE'),
(703, 7, 'EL CARMEN'),
(704, 7, 'EL ROSARIO'),
(705, 7, 'MONTE SAN JUAN'),
(706, 7, 'ORATORIO DE CONCEPCION'),
(707, 7, 'SAN BARTOLOME PERULAPIA'),
(708, 7, 'SAN CRISTOBAL'),
(709, 7, 'SAN JOSE GUAYABAL'),
(710, 7, 'SAN PEDRO PERULAPAN'),
(711, 7, 'SAN RAFAEL CEDROS'),
(712, 7, 'SAN RAMON'),
(713, 7, 'SANTA CRUZ ANALQUITO'),
(714, 7, 'SANTA CRUZ MICHAPA'),
(715, 7, 'SUCHITOTO'),
(716, 7, 'TENANCINGO'),
(801, 8, 'CUYULTITAN'),
(802, 8, 'EL ROSARIO'),
(803, 8, 'JERUSALEN'),
(804, 8, 'MERCEDES LA CEIBA'),
(805, 8, 'OLOCUILTA'),
(806, 8, 'PARAISO DE OSORIO'),
(807, 8, 'SAN ANTONIO MASAHUAT'),
(808, 8, 'SAN EMIGDIO'),
(809, 8, 'SAN FRANCISCO CHINAMECA'),
(810, 8, 'SAN JUAN NONUALCO'),
(811, 8, 'SAN JUAN TALPA'),
(812, 8, 'SAN JUAN TEPEZONTES'),
(813, 8, 'SAN LUIS TALPA'),
(814, 8, 'SAN MIGUEL TEPEZONTES'),
(815, 8, 'SAN PEDRO MASAHUAT'),
(816, 8, 'SAN PEDRO NONUALCO'),
(817, 8, 'SAN RAFAEL OBRAJUELO'),
(818, 8, 'SANTA MARIA OSTUMA'),
(819, 8, 'SANTIAGO NONUALCO'),
(820, 8, 'TAPALHUACA'),
(821, 8, 'ZACATECOLUCA'),
(822, 8, 'SAN LUIS LA HERRADURA'),
(901, 9, 'CINQUERA'),
(902, 9, 'GUACOTECTI'),
(903, 9, 'ILOBASCO'),
(904, 9, 'JUTIAPA'),
(905, 9, 'SAN ISIDRO'),
(906, 9, 'SENSUNTEPEQUE'),
(907, 9, 'TEJUTEPEQUE'),
(908, 9, 'VICTORIA'),
(909, 9, 'VILLA DOLORES'),
(1001, 10, 'APASTEPEQUE'),
(1002, 10, 'GUADALUPE'),
(1003, 10, 'SAN CAYETANO ISTEPEQUE'),
(1004, 10, 'SANTA CLARA'),
(1005, 10, 'SANTO DOMINGO'),
(1006, 10, 'SAN ESTEBAN CATARINA'),
(1007, 10, 'SAN ILDEFONSO'),
(1008, 10, 'SAN LORENZO'),
(1009, 10, 'SAN SEBASTIAN'),
(1010, 10, 'SAN VICENTE'),
(1011, 10, 'TECOLUCA'),
(1012, 10, 'TEPETITAN'),
(1013, 10, 'VERAPAZ'),
(1101, 11, 'ALEGRIA'),
(1102, 11, 'BERLIN'),
(1103, 11, 'CALIFORNIA'),
(1104, 11, 'CONCEPCION BATRES'),
(1105, 11, 'EL TRIUNFO'),
(1106, 11, 'EREGUAYQUIN'),
(1107, 11, 'ESTANZUELAS'),
(1108, 11, 'JIQUILISCO'),
(1109, 11, 'JUCUAPA'),
(1110, 11, 'JUCUARAN'),
(1111, 11, 'MERCEDES UMA?A'),
(1112, 11, 'NUEVA GRANADA'),
(1113, 11, 'OZATLAN'),
(1114, 11, 'PUERTO EL TRIUNFO'),
(1115, 11, 'SAN AGUSTIN'),
(1116, 11, 'SAN BUENAVENTURA'),
(1117, 11, 'SAN DIONISIO'),
(1118, 11, 'SANTA ELENA'),
(1119, 11, 'SAN FRANCISCO JAVIER'),
(1120, 11, 'SANTA MARIA'),
(1121, 11, 'SANTIAGO DE MARIA'),
(1122, 11, 'TECAPAN'),
(1123, 11, 'USULUTAN'),
(1201, 12, 'CAROLINA'),
(1202, 12, 'CIUDAD BARRIOS'),
(1203, 12, 'COMACARAN'),
(1204, 12, 'CHAPELTIQUE'),
(1205, 12, 'CHINAMECA'),
(1206, 12, 'CHIRILAGUA'),
(1207, 12, 'EL TRANSITO'),
(1208, 12, 'LOLOTIQUE'),
(1209, 12, 'MONCAGUA'),
(1210, 12, 'NUEVA GUADALUPE'),
(1211, 12, 'NUEVO EDEN DE SAN JUAN'),
(1212, 12, 'QUELEPA'),
(1213, 12, 'SAN ANTONIO DEL MOSCO'),
(1214, 12, 'SAN GERARDO'),
(1215, 12, 'SAN JORGE'),
(1216, 12, 'SAN LUIS DE LA REINA'),
(1217, 12, 'SAN MIGUEL'),
(1218, 12, 'SAN RAFAEL ORIENTE'),
(1219, 12, 'SESORI'),
(1220, 12, 'ULUAZAPA'),
(1301, 13, 'ARAMBALA'),
(1302, 13, 'CACAOPERA'),
(1303, 13, 'CORINTO'),
(1304, 13, 'CHILANGA'),
(1305, 13, 'DELICIAS DE CONCEPCION'),
(1306, 13, 'EL DIVISADERO'),
(1307, 13, 'EL ROSARIO'),
(1308, 13, 'GUALOCOCTI'),
(1309, 13, 'GUATAJIAGUA'),
(1310, 13, 'JOATECA'),
(1311, 13, 'JOCOAITIQUE'),
(1312, 13, 'JOCORO'),
(1313, 13, 'LOLOTIQUILLO'),
(1314, 13, 'MEANGUERA'),
(1315, 13, 'OSICALA'),
(1316, 13, 'PERQUIN'),
(1317, 13, 'SAN CARLOS'),
(1318, 13, 'SAN FERNANDO'),
(1319, 13, 'SAN FRANCISCO GOTERA'),
(1320, 13, 'SAN ISIDRO'),
(1321, 13, 'SAN SIMON'),
(1322, 13, 'SENSEMBRA'),
(1323, 13, 'SOCIEDAD'),
(1324, 13, 'TOROLA'),
(1325, 13, 'YAMABAL'),
(1326, 13, 'YOLOAIQUIN'),
(1401, 14, 'ANAMOROS'),
(1402, 14, 'BOLIVAR'),
(1403, 14, 'CONCEPCION DE ORIENTE'),
(1404, 14, 'CONCHAGUA'),
(1405, 14, 'EL CARMEN'),
(1406, 14, 'EL SAUCE'),
(1407, 14, 'INTIPUCA'),
(1408, 14, 'LA UNION'),
(1409, 14, 'LISLIQUE'),
(1410, 14, 'MEANGUERA DEL GOLFO'),
(1411, 14, 'NUEVA ESPARTA'),
(1412, 14, 'PASAQUINA'),
(1413, 14, 'POLOROS'),
(1414, 14, 'SAN ALEJO'),
(1415, 14, 'SAN JOSE LAS FUENTES'),
(1416, 14, 'SANTA ROSA DE LIMA'),
(1417, 14, 'YAYANTIQUE'),
(1418, 14, 'YUCUAIQUIN');

-- --------------------------------------------------------

--
-- Table structure for table `cod_pais`
--

CREATE TABLE `cod_pais` (
  `idCod_Pais` int(11) NOT NULL,
  `Nombre_Pais` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16le;

--
-- Dumping data for table `cod_pais`
--

INSERT INTO `cod_pais` (`idCod_Pais`, `Nombre_Pais`) VALUES
(222, 'EL SALVADOR');

-- --------------------------------------------------------

--
-- Table structure for table `col_semanal`
--

CREATE TABLE `col_semanal` (
  `idCol_Semanal` int(11) NOT NULL,
  `idSemanal` int(11) NOT NULL,
  `NumeroDocumento` varchar(50) NOT NULL,
  `Lunes` varchar(50) NOT NULL,
  `Martes` varchar(50) NOT NULL,
  `Miercoles` varchar(50) NOT NULL,
  `Jueves` varchar(50) NOT NULL,
  `Viernes` varchar(50) NOT NULL,
  `Sabado` varchar(50) NOT NULL,
  `Domingo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16le;

--
-- Dumping data for table `col_semanal`
--

INSERT INTO `col_semanal` (`idCol_Semanal`, `idSemanal`, `NumeroDocumento`, `Lunes`, `Martes`, `Miercoles`, `Jueves`, `Viernes`, `Sabado`, `Domingo`) VALUES
(1, 1, '26569', '1', '1', '1', '1', '1', '3', '3'),
(2, 1, '1856632', '1', '1', '1', '1', '1', '3', '3'),
(3, 1, '4537499', '1', '1', '1', '1', '1', '3', '3'),
(4, 1, '5008142', '1', '1', '1', '1', '1', '3', '3'),
(5, 1, '5205176', '1', '1', '1', '1', '1', '3', '3'),
(6, 1, '9121031', '1', '1', '1', '1', '1', '3', '3'),
(7, 1, '12039366', '1', '1', '1', '1', '1', '3', '3'),
(8, 1, '13816559', '1', '1', '1', '1', '1', '3', '3'),
(9, 1, '14809872', '1', '1', '1', '1', '1', '3', '3'),
(10, 1, '15226035', '1', '1', '1', '1', '1', '3', '3'),
(11, 1, '16721999', '1', '1', '1', '1', '1', '3', '3'),
(12, 1, '19045033', '1', '1', '1', '1', '1', '3', '3'),
(13, 1, '23036151', '1', '1', '1', '1', '1', '3', '3'),
(14, 1, '25465136', '1', '1', '1', '1', '1', '3', '3'),
(15, 1, '999999999', '1', '1', '1', '1', '1', '3', '3'),
(16, 1, '999999999', '1', '1', '1', '1', '1', '3', '3');

-- --------------------------------------------------------

--
-- Table structure for table `departamento`
--

CREATE TABLE `departamento` (
  `idDepartamento` int(11) NOT NULL,
  `NitEmpresa` varchar(14) DEFAULT NULL,
  `NombreDepartamento` varchar(255) NOT NULL,
  `idSalario_Minimo` int(11) NOT NULL,
  `CuentaContable` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16le;

--
-- Dumping data for table `departamento`
--

INSERT INTO `departamento` (`idDepartamento`, `NitEmpresa`, `NombreDepartamento`, `idSalario_Minimo`, `CuentaContable`) VALUES
(1, '222', 'DEFAULT', 1, ''),
(2, '222', 'TODOS_LOS_PERMISOS', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `empleado`
--

CREATE TABLE `empleado` (
  `NumeroDocumento` varchar(50) NOT NULL,
  `TipoDocumento` varchar(50) NOT NULL,
  `idCargos` int(11) NOT NULL,
  `Pass` varchar(150) NOT NULL,
  `Activo` tinyint(1) NOT NULL,
  `Nup` varchar(150) NOT NULL,
  `InstitucionPrevisional` varchar(150) NOT NULL,
  `PrimerNombre` varchar(150) NOT NULL,
  `SegundoNombre` varchar(150) NOT NULL,
  `PrimerApellido` varchar(150) NOT NULL,
  `SegundoApellido` varchar(150) NOT NULL,
  `ApellidoCasada` varchar(150) NOT NULL,
  `ConocidoPor` varchar(150) NOT NULL,
  `Nit` varchar(50) NOT NULL,
  `NumeroIsss` varchar(150) NOT NULL,
  `NumeroInpep` varchar(150) NOT NULL,
  `Genero` varchar(10) NOT NULL,
  `Nacionalidad` varchar(150) NOT NULL,
  `SalarioNominal` varchar(11) NOT NULL,
  `FechaNacimiento` varchar(150) NOT NULL,
  `EstadoCivil` varchar(150) NOT NULL,
  `Direccion` varchar(255) NOT NULL,
  `Departamento` varchar(10) NOT NULL,
  `Municipio` varchar(10) NOT NULL,
  `NumeroTelefonico` varchar(150) NOT NULL,
  `CorreoElectronico` varchar(255) NOT NULL,
  `TipoEmpleado` varchar(150) NOT NULL,
  `FechaIngreso` varchar(150) NOT NULL,
  `FechaRetiro` varchar(150) NOT NULL,
  `FechaFallecimiento` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16le;

--
-- Dumping data for table `empleado`
--

INSERT INTO `empleado` (`NumeroDocumento`, `TipoDocumento`, `idCargos`, `Pass`, `Activo`, `Nup`, `InstitucionPrevisional`, `PrimerNombre`, `SegundoNombre`, `PrimerApellido`, `SegundoApellido`, `ApellidoCasada`, `ConocidoPor`, `Nit`, `NumeroIsss`, `NumeroInpep`, `Genero`, `Nacionalidad`, `SalarioNominal`, `FechaNacimiento`, `EstadoCivil`, `Direccion`, `Departamento`, `Municipio`, `NumeroTelefonico`, `CorreoElectronico`, `TipoEmpleado`, `FechaIngreso`, `FechaRetiro`, `FechaFallecimiento`) VALUES
('10611950', 'DUI', 1, '', 1, '3.00928E+11', 'MAX', 'YANCY               ', 'MARICELA                      ', 'PAYAN               ', 'SOTO                ', '                    ', '', '6.14E+12', '         ', '          ', 'F', '222', '', '23/05/1982', 'S', 'COLONIA SAN FRANCISCO CALLE PRINCIPAL CASA 6      ', '6', '605', '22868468', '', 'P', '', '', ''),
('1123518', 'DUI', 1, '', 1, '2.55712E+11', 'COF', 'ERNESTO', '', 'PALACIOS', 'CRUZ', '', '', '', '101701362', '', 'M', '222', '319.52', '05/01/1970', 'S', 'URB. LOS NOGALES CL. PPL. BLOCK B CASA #4 SAN MARCOS TEL. 22370211', '6', '612', '22208414', '', 'P', '15/11/2007', '', ''),
('12039366', 'DUI', 1, '', 1, '2.38442E+11', 'MAX', 'MISAEL              ', '                              ', 'MARTINEZ            ', 'MORENO              ', '                    ', '', '1.12E+13', '385651442', '          ', 'M', '222', '', '14/04/1965', 'C', 'COL. JARD. DEL SELSUTT POLG. F-2 PJE. 18 CASA ?10 ', '6', '609', '            ', '', 'P', '', '', ''),
('13519864', 'DUI', 1, '', 1, '2.94273E+11', 'MAX', 'CHRISTIAN           ', 'ENRIQUE                       ', 'GUZMAN              ', 'HERNANDEZ           ', '                    ', '', '              ', '         ', '          ', 'M', '222', '', '27/07/1980', 'S', 'CIUD FUTURA POLIG 26 PJE 28 A CASA ? 2            ', '6', '605', '            ', '', 'P', '', '', ''),
('13816559', 'DUI', 1, '', 1, '2.46202E+11', 'MAX', 'TRINIDAD            ', 'DE JESUS                      ', 'AVALOS              ', 'RIVERA              ', '                    ', '', '6.04E+12', '383670258', '          ', 'M', '222', '', '30/05/1967', 'C', 'URB. AN LUIS TALPA POL. 5 PJE. 13 ? 122, SAN LUIS ', '8', '814', '23348431', '', 'P', '', '', ''),
('14809872', 'DUI', 1, '', 1, '2.31912E+11', 'MAX', 'MIGUEL              ', 'ANGEL                         ', 'RAMIREZ             ', 'HERNANDEZ           ', '                    ', '', '6.04E+12', '393631658', '          ', 'M', '222', '', '01/07/1963', 'S', 'C. IBA#EZ CASA ?71 AQUIPO 9 POPOTLAN , APOPA      ', '6', '603', '            ', '', 'P', '', '', ''),
('1509112', 'DUI', 1, '', 1, '2.73766E+11', 'MAX', 'LIDIA               ', 'YECENIA                       ', 'ORDO?EZ             ', '                    ', 'DOMINGUEZ           ', '', '              ', '         ', '          ', 'F', '222', '', '15/12/1974', 'C', 'RESIDENCIAL SAN LUIS PASAJE 3 CASA 48             ', '8', '814', '            ', '', 'P', '', '', ''),
('15226035', 'DUI', 1, '', 1, '2.06572E+11', 'MAX', 'CARLOS              ', 'EDUARDO                       ', 'LOBO                ', 'SOTO                ', '                    ', '', '1210-230756-001-1', '479561812', '          ', 'M', '222', '500.00', '23/07/1956', 'C', 'REPARTO SN. BARTOLO LOT. SN. ANTONIO              ', '6', '609', '            ', '', 'P', '06/01/1993', '', ''),
('16721999', 'DUI', 1, '', 1, '2.24962E+11', 'MAX', 'NASARIO             ', 'INOSENCIO                     ', 'PAYAN               ', 'COREA               ', '                    ', '', '1.41E+13', '989611063', '          ', 'M', '222', '', '05/08/1961', 'C', 'AV. SANTA MARGARITA PJE CRESPIN 2 CASA 5B EL ROSA ', '6', '605', '22761035', '', 'P', '', '', ''),
('169112', 'CMI', 1, '', 1, '3.43738E+11', 'MAX', 'JOSSELYN            ', 'MAGALY                        ', 'DURAN               ', 'DE PAZ              ', '                    ', '', '              ', '         ', '          ', 'F', '222', '', '10/02/1994', 'S', 'BARRIO EL CALVARIO CALLE PRINCIPAL                ', '8', '812', '75829286', '', 'P', '', '', ''),
('18133922', 'DUI', 1, '', 1, '2.99123E+11', 'COF', 'RENE', 'MAURICIO', 'RAUDA', 'HERNANDEZ', '', '', '', '100817502', '', 'M', '222', '947.08', '24/11/1981', 'S', 'JARD. DE LA HCDA. PJE.1 SU BLK.E NO.46 CDAD. MERLIOT', '5', '501', '22781902', 'mauriciorauda_12@hotmail.com', 'P', '03/10/2014', '', ''),
('1856632', 'DUI', 1, '', 1, '2.00472E+11', 'MAX', 'MAURICIO            ', 'ENRIQUE                       ', 'GONZALEZ            ', 'MEJIA               ', '                    ', '', '              ', '173542555', '          ', 'M', '222', '', '21/11/1954', 'U', 'COL. MONTE CARMELO ?1 C. PPAL. PJE. "D" CASA ?13  ', '6', '618', '21241518', '', 'P', '', '', ''),
('18838166', 'DUI', 1, '', 1, '2.98362E+11', 'COF', 'PEDRO', 'ANTONIO', 'QUINTANILLA', 'GONZALEZ', '', '', '', '', '', 'M', '222', '201.26', '09/09/1981', 'S', 'CAS LOS ARTIGA HDA STO TOMAS, CALLE CENTRAL', '8', '805', '', '', 'P', '01/04/2013', '', ''),
('19045033', 'DUI', 1, '', 1, '2.61332E+11', 'MAX', 'JOSE                ', 'DANIEL                        ', 'ORELLANA            ', '                    ', '                    ', '', '3.15E+12', '891712188', '          ', 'M', '222', '', '21/07/1971', 'C', 'URB. LAS BRISAS ? 2 PJE. 7 BLOCK "G" ? 8          ', '6', '618', '            ', '', 'P', '', '', ''),
('19622259', 'DUI', 1, '', 1, '2.87662E+11', 'COF', 'JULIO', 'ALBERTO', 'JUAREZ', 'CRUZ', '', '', '', '106781118', '', 'M', '222', '260.02', '05/10/1978', 'C', 'CANTON LOS LAURELES CALLE PPAL', '8', '812', '79173134', '', 'P', '01/08/2006', '', ''),
('22330780', 'DUI', 1, '', 1, '3.09542E+11', 'COF', 'OSCAR', 'ANTONIO', 'GUEVARA', 'ORTIZ', '', '', '', '107843109', '', 'M', '222', '255.67', '01/10/1984', 'S', 'COLONIA SAN LUIS CALLE LUIS RIVAS VIDES CASA 28', '8', '813', '75374531', 'oscar_or991@hotmail.com', 'P', '01/06/2007', '', ''),
('22933253', 'DUI', 1, '', 1, '2.63142E+11', 'MAX', 'FRANCISCO           ', 'ALBERTO                       ', 'ZAMORA              ', '                    ', '                    ', '', '4.33E+12', '493727094', '          ', 'M', '222', '', '18/01/1972', 'C', 'RES. VALLE LOURDES BLOCK 2 SENDA 2 CASA #3 LOURDES', '6', '603', '            ', '', 'P', '', '', ''),
('23036151', 'DUI', 1, '', 1, '1.90651E+11', 'MAX', 'ALFREDO             ', '                              ', 'VENTURA             ', '                    ', '                    ', '', '              ', '170501146', '          ', 'M', '222', '', '14/03/1952', 'S', 'AV. Y COL. LISBOA ? 10                            ', '6', '601', '22743487', '', 'P', '', '', ''),
('23177630', 'DUI', 1, '', 1, '3.00887E+11', 'MAX', 'ANA                 ', 'ISABEL                        ', 'GOMEZ               ', 'MARIN               ', '                    ', '', '6.14E+12', '107828934', '          ', 'F', '222', '', '19/05/1982', 'S', 'BARRIO LOURDES CALLE DELGADO Y 34 AVENIDA SUR CASA', '6', '601', '22226386', '', 'P', '', '', ''),
('25465136', 'DUI', 1, '', 1, '2.00861E+11', 'MAX', 'VALENTIN            ', 'ALFREDO                       ', 'HERNANDEZ           ', '                    ', '                    ', '', '1.01E+13', '493540403', '          ', 'M', '222', '', '30/12/1954', 'C', 'FINAL 1A AVENIDA SUR, COLONIA JOSE SIMEON CA?AS SI', '8', '801', '23340848', '', 'P', '', '', ''),
('26569', 'DUI', 1, '', 1, '2.07652E+11', 'MAX', 'JOSE                ', 'ARMANDO                       ', 'ESCOBAR             ', '                    ', '                    ', '', '2.10E+12', '778562694', '          ', 'M', '222', '', '08/11/1956', 'C', 'URB. LOS NOGALES BLOCK B ? 12 CARRE AUTOPISTA COMA', '6', '601', '22803614', '', 'P', '', '', ''),
('2923490', 'DUI', 1, '', 1, '2.84407E+11', 'COF', 'EDIS', 'MAYRA', 'PINEDA', 'FLORES', '', '', '', '', '', 'F', '222', '257.47', '13/11/1977', 'S', 'COLONIA. LAS BRISAS DEL BARRIO EL CALVARIO  NO TIENE  NUMERO  DE  CASA', '8', '813', '79544047', '', 'P', '01/05/2011', '', ''),
('31079317', 'DUI', 1, '', 1, '2.78782E+11', 'MAX', 'JOSE                ', 'WILLIAM                       ', 'SALMERON            ', '                    ', '                    ', '', '              ', '895768248', '          ', 'M', '222', '', '30/04/1976', 'C', 'COMPLEJO HABITACIONAL MONTELIMAR POL. 4 PJE. 4 BLO', '8', '806', '            ', '', 'P', '', '', ''),
('33510652', 'DUI', 1, '', 1, '3.12657E+11', 'COF', 'REINA', 'BEATRIZ', 'RODAS', 'MONTOYA', '', '', '', '104851983', '', 'F', '222', '236.32', '08/08/1985', 'S', 'LOTIF. EL PORVENIR, DESVIO AGUACAYALA CASA 18', '8', '821', '', '', 'P', '16/11/2011', '', ''),
('33784578', 'DUI', 1, '', 1, '3.13421E+11', 'COF', 'FABIO', 'ROBERTO', 'BONILLA', 'FLORES', '', '', '', '105857294', '', 'M', '222', '150.22', '24/10/1985', 'S', 'HACIENDA SANTA CLARA, LOTIFICACION ORO ARRIBA, BLOKC "G" CASA # 7', '8', '813', '63100612', '', 'P', '', '', ''),
('33915894', 'DUI', 1, '', 1, '3.13017E+11', 'COF', 'BLANCA', 'DEL ROSARIO', 'CRUZ', 'ALBERTO', '', '', '', '107851491', '', 'F', '222', '26.35', '13/09/1985', 'S', 'BARRIO EL CENTRO CL. LUIS RIVAS VIDES # 207', '8', '813', '23348702', '', 'P', '01/10/2015', '', ''),
('34292558', 'DUI', 1, '', 1, '3.12308E+11', 'MAX', 'PATRICIA            ', 'DE JESUS                      ', 'SENSENTE            ', 'VELASQUEZ           ', '                    ', '', '              ', '108852208', '          ', 'F', '222', '', '04/07/1985', 'S', 'LOTIFICACION MARISCAL PASAJE 3 CASA # 64          ', '8', '814', '            ', '', 'P', '', '', ''),
('34494702', 'DUI', 1, '', 1, '3.10342E+11', 'MAX', 'ENRIQUE             ', 'ALEJANDRO                     ', 'MORALES             ', '                    ', '                    ', '', '              ', '         ', '          ', 'M', '222', '', '20/12/1984', 'S', 'BARRIO EL CALVARIO CALLE AL CEMENTERIO            ', '8', '818', '            ', '', 'P', '', '', ''),
('34631401', 'DUI', 1, '', 1, '3.14107E+11', 'MAX', 'SILVIA              ', 'YANETH                        ', 'HERNANDEZ           ', 'CASTRO              ', '                    ', '', '              ', '         ', '          ', 'F', '222', '', '31/12/1985', 'S', 'BO EL CALVARIO                                    ', '8', '812', '23305366', '', 'P', '', '', ''),
('35267904', 'DUI', 1, '', 1, '3.15152E+11', 'MAX', 'ALEXIS              ', 'LEONEL                        ', 'RAMIREZ             ', '                    ', '                    ', '', '              ', '         ', '          ', 'M', '222', '', '15/04/1986', 'S', 'CASERIO EL SALAMAR                                ', '8', '814', '            ', '', 'P', '', '', ''),
('35442075', 'DUI', 1, '', 1, '3.15448E+11', 'MAX', 'SONIA               ', 'LORENA                        ', 'MARTINEZ            ', 'MARTINEZ            ', '                    ', '', '              ', '         ', '          ', 'F', '222', '', '14/05/1986', 'S', 'CANTON CANGREJERA PLAYA CANGREJERA                ', '5', '510', '            ', '', 'P', '', '', ''),
('35867259', 'DUI', 1, '', 1, '3.16343E+11', 'COF', 'JEOVANNY', 'ROMEO', 'TEJADA', 'VALLADARES', '', '', '', '106865552', '', 'M', '222', '282.16', '12/08/1986', 'S', 'DESVIO  DE OJO DE AGUA SAN  JOSE ABAJO  CAS SAN  JOSE ABAJO', '8', '819', '23231665', '', 'P', '', '', ''),
('36075724', 'DUI', 1, '', 1, '3.16742E+11', 'COF', 'MELVIN', 'OSMIN', 'GOMEZ', 'GONZALEZ', '', '', '', '110862647', '', 'M', '222', '293.27', '21/09/1986', 'S', 'CANTON EL ZARZAL', '1', '106', '', '', 'P', '01/06/2013', '', ''),
('36383541', 'DUI', 1, '', 1, '3.15802E+11', 'COF', 'JOSE', 'DANIEL', 'AVALOS', 'CORNEJO', '', '', '', '', '', 'M', '222', '390.24', '19/06/1986', 'S', 'RES SAN LUIS PJE 13 CASA#122', '8', '813', '23348431', 'dani_avalos@hotmail.com', 'P', '01/11/2013', '', ''),
('36462387', 'DUI', 1, '', 1, '3.14932E+11', 'MAX', 'RICARDO             ', '                              ', 'MARMOL              ', 'QUINTANILLA         ', '                    ', '', '              ', '         ', '          ', 'M', '222', '', '24/03/1986', 'S', 'COL. JARDINES DEL REY PJE. LOS CRISANTEMOS CASA 8 ', '5', '501', '22288752', '', 'P', '', '', ''),
('36482450', 'DUI', 1, '', 1, '3.15837E+11', 'COF', 'REYNA', 'ELIZABETH', 'CHICAS', '', '', '', '', '', '', 'F', '222', '243.31', '22/06/1986', 'S', 'CL.  A  LA ZUNGANERA TECUALUYA CAS. SANTA CLARA', '8', '813', '', '', 'P', '08/12/2010', '', ''),
('36803876', 'DUI', 1, '', 1, '3.17772E+11', 'COF', 'MARVIN', 'MANZUR', 'PEREZ', '', '', '', '', '', '', 'M', '222', '229.15', '02/01/1987', 'S', 'AUT A COMALAPA KM 24 LA ESPERANZA CASERIO SANTA MARIA', '8', '805', '23574131', 'marvinmanzur@hotmail.com', 'P', '05/06/2013', '', ''),
('36867503', 'DUI', 1, '', 1, '3.13472E+11', 'MAX', 'VICTOR              ', 'MANUEL                        ', 'LOPEZ               ', 'HERNANDEZ           ', '                    ', '', '8.05E+12', '106855920', '          ', 'M', '222', '', '29/10/1985', 'S', 'CANTON LA ESPERANZA CASERIO EL SALAMO CASA 19     ', '8', '806', '23672402', '', 'P', '', '', ''),
('36886515', 'DUI', 1, '', 1, '3.14572E+11', 'MAX', 'NESTOR              ', 'IVAN                          ', 'CORTEZ              ', 'MARTINEZ            ', '                    ', '', '              ', '105864131', '          ', 'M', '222', '', '16/02/1986', 'S', 'COL NUEVA ESPERANZA PJE 8 LOTE #4                 ', '8', '806', '25314022', '', 'P', '', '', ''),
('38249696', 'DUI', 1, '', 1, '3.18158E+11', 'MAX', 'VERONICA            ', 'YAMILET                       ', 'VASQUEZ             ', 'SOLANO              ', '                    ', '', '              ', '107879626', '          ', 'F', '222', '', '09/02/1987', 'S', 'CANTON CANGREJERA CASERIO CORDONSILLO             ', '5', '510', '            ', '', 'P', '', '', ''),
('38866278', 'DUI', 1, '', 1, '3.21752E+11', 'COF', 'MARVIN', 'ALBERTO', 'GOMEZ', 'GONZALEZ', '', '', '', '', '', 'M', '222', '277.93', '04/02/1988', 'S', 'CANTON EL ZARZAL, CASERIO LOS ASCENCIO', '1', '106', '', '', 'P', '01/03/2007', '', ''),
('39383516', 'DUI', 1, '', 1, '3.22542E+11', 'COF', 'MELVIN', 'TOMAS', 'CRUZ', 'DURAN', '', '', '', '111885407', '', 'M', '222', '101.42', '23/04/1988', 'S', 'COLONIA SANTA SABINA PJE. JOSE SIMEON CA?AS # 26', '6', '604', '76053967', 'mt_once@hotmail.com', 'P', '10/10/2016', '', ''),
('39427417', 'DUI', 1, '', 1, '3.23097E+11', 'MAX', 'VANIA               ', 'MARILY                        ', 'PEREZ               ', 'ESCOBAR             ', '                    ', '', '              ', '109881824', '          ', 'F', '222', '', '17/06/1988', 'S', 'LOTIFICACION CASA LOMA CARRETERA ANTIGUA A        ', '8', '806', '            ', '', 'P', '', '', ''),
('40063844', 'DUI', 1, '', 1, '3.24497E+11', 'MAX', 'ALBA                ', 'VERONICA                      ', 'CORNEJO             ', 'AYALA               ', '                    ', '', '              ', '107883823', '          ', 'F', '222', '', '04/11/1988', 'S', 'COLONIA TORRES DE GUADALUPE, PASAJE 5, POLIGONO D,', '8', '802', '25171021', '', 'P', '', '', ''),
('40445151', 'DUI', 1, '', 1, '3.25242E+11', 'COF', 'MARIO', 'ALFREDO', 'AYALA', 'GOMEZ', '', '', '', '108894734', '', 'M', '222', '213.5', '18/01/1989', 'S', 'BO. EL CENTO CL PPAL A LA FINCA', '8', '822', '61348165', '', 'P', '03/07/2010', '', ''),
('40797590', 'DUI', 1, '', 1, '3.25942E+11', 'MAX', 'JOSE                ', '                              ', 'DURAN               ', 'AYALA               ', '                    ', '', '              ', '109896340', '          ', 'M', '222', '', '29/03/1989', 'S', 'CASERIO LA ESMERALDA CALLE A LA ZUNGANERA         ', '8', '814', '23138591', '', 'P', '', '', ''),
('40823901', 'DUI', 1, '', 1, '3.26057E+11', 'COF', 'ALBA', 'ROCIO', 'RUBIO', 'VELASQUEZ', '', '', '', '', '', 'F', '222', '31.47', '09/04/1989', 'S', 'COL.  ALCAINE 2 CALLE  BENITO JUAREZ PASAJE 2 CASA NO  22.', '6', '612', '22207778', 'bonita1rubio@hotmail.com', 'P', '25/10/2016', '', ''),
('40848422', 'DUI', 1, '', 1, '3.26193E+11', 'COF', 'HENRY', 'ANTONIO', 'OLMEDO', 'ROMERO', '', '', '', '', '', 'M', '222', '261.39', '23/04/1989', 'S', 'CANTON LAS DELICIAS CALLE LITORAL POR EL CEMENTERIO DE SAN JUAN NONUALCO', '8', '810', '', 'curlydark_henrock69@hotmail.com', 'P', '09/03/2015', '', ''),
('40901767', 'DUI', 1, '', 1, '3.26266E+11', 'MAX', 'ADA                 ', 'ESMERALDA                     ', 'AREVALO             ', 'JOVEL               ', '                    ', '', '8.13E+12', '108893300', '          ', 'F', '222', '', '30/04/1989', 'S', 'LOTIFICACION SANTA CRISTINA CALLE PRINCIPAL       ', '8', '814', '            ', '', 'P', '', '', ''),
('41316428', 'DUI', 1, '', 1, '3.26132E+11', 'COF', 'CARLOS', 'ALBERTO', 'MARROQUIN', 'REYES', '', '', '', '', '', 'M', '222', '204.89', '17/04/1989', 'S', 'TECUALUYA', '8', '813', '70606803', '', 'P', '18/11/2011', '', ''),
('41511052', 'DUI', 1, '', 1, '3.26167E+11', 'COF', 'GLENDA', 'ARELY', 'ROMERO', 'PORTILLO', '', '', '', '109893778', '', 'F', '222', '251.7', '20/04/1989', 'S', 'CL  PPAL STA LUCIA LOTIFICACION ORCOYO', '8', '813', '77474986', 'arely_garp@yahoo.es', 'P', '01/02/2016', '', ''),
('42462997', 'DUI', 1, '', 1, '3.27273E+11', 'MAX', 'EDWIN               ', 'HERIBERTO                     ', 'SUAREZ              ', 'LEIVA               ', '                    ', '', '              ', '111894220', '          ', 'M', '222', '', '09/08/1989', 'S', 'LOTIFICACION LAS BRISAS                           ', '8', '814', '            ', '', 'P', '', '', ''),
('425933', 'DUI', 1, '', 1, '1.86003E+11', 'MAX', 'JOSE                ', 'MAURICIO                      ', 'SOLORZANO           ', 'LANDAVERDE          ', '                    ', '', '4.13E+12', '880500638', '          ', 'M', '222', '', '15/12/1950', 'C', 'JNES. DEL VOLCAN ? 2 PJE. 24 OTE. POL. C-13 ? 30, ', '5', '501', '22786043', '', 'P', '', '', ''),
('42817061', 'DUI', 1, '', 1, '3.27467E+11', 'COF', 'BEATRIZ', 'YAMILETH', 'LOPEZ', 'AGUILERA', '', '', '', '', '', 'F', '222', '141.39', '28/08/1989', 'S', 'COL. ENCARNACION 2 PJE L POLG  L # 6', '6', '612', '22188109', '', 'P', '03/10/2016', '', ''),
('4296556', 'DUI', 1, '', 1, '1.90253E+11', 'MAX', 'JOSE                ', 'LEONIDAS                      ', 'MARTINEZ            ', 'MORENO              ', '                    ', '', '1.12E+13', '693520287', '          ', 'M', '222', '', '03/02/1952', 'C', 'URBANIZACION PRADOS DE SAN BARTOLO CALLE PRINCIPAL', '6', '609', '22961828', '', 'P', '', '', ''),
('43004718', 'DUI', 1, '', 1, '3.32227E+11', 'MAX', 'KARLA               ', 'MARIELA                       ', 'RAMIREZ             ', 'FIGUEROA            ', '                    ', '', '              ', '         ', '          ', 'F', '222', '', '17/12/1990', 'S', 'URBANIZACION LOS NOGALES CALLE PRINCIPAL BLOCK A  ', '6', '614', '            ', '', 'P', '', '', ''),
('43508013', 'DUI', 1, '', 1, '3.30997E+11', 'COF', 'CARMEN', 'ELENA', 'BERMUDEZ', 'UMANZOR', '', '', '', '110901479', '', 'F', '222', '340.11', '16/08/1990', 'S', 'URB MONTES DE SAN BARTOLO 4 PJE 7 POL 11 CASA 16', '6', '617', '22927587', 'carmen_elena18@hotmail.com', 'P', '01/01/2013', '', ''),
('43751250', 'DUI', 1, '', 1, '3.31642E+11', 'COF', 'CRISTOBAL', 'DE JESUS', 'GONZALEZ', 'LOPEZ', '', '', '', '111903433', '', 'M', '222', '254.85', '20/10/1990', 'S', 'HACIENDA. SANTO TOMAS', '8', '813', '72098816', '', 'P', '01/04/2011', '', ''),
('44754382', 'DUI', 1, '', 1, '3.34122E+11', 'MAX', 'JUAN                ', 'CARLOS                        ', 'BONILLA             ', 'MARTINEZ            ', '                    ', '', '8.15E+12', '109912696', '          ', 'M', '222', '', '25/06/1991', 'S', 'BARRIO EL CALVARIO CALLE DARIO LUNA CASA 32       ', '8', '817', '            ', '', 'P', '', '', ''),
('44878225', 'DUI', 1, '', 1, '3.33347E+11', 'COF', 'IRIS', 'MAGDALENA', 'GARCIA', 'BA?OS', '', '', '8.05E+12', '', '', 'F', '222', '432.85', '08/04/1991', 'S', 'URBANIZACION MONTELIMAR PASAJE 4 POLGIONO 3 BLOCK B CASA 4', '8', '805', '23153694', 'nenagar_8491@hotmail.com', 'P', '01/10/2016', '', ''),
('45141582', 'DUI', 1, '', 1, '3.33738E+11', 'COF', 'SILVIA', 'PATRICIA', 'MARTINEZ', 'MARTINEZ', '', '', '', '', '', 'F', '222', '242.13', '17/05/1991', 'S', 'COL. CALIFORNIA, PJE. 2, KM. 3, CALLE. LOS PLANES DE RENDEROS CASA #18', '6', '614', '73751533', '', 'P', '01/11/2012', '', ''),
('4537499', 'DUI', 1, '', 1, '2.11342E+11', 'MAX', 'PEDRO               ', '                              ', 'FLORES              ', 'MENDOZA             ', '                    ', '', '              ', '777572930', '          ', 'M', '222', '', '12/11/1957', 'C', 'RES. SANTA LUCIA NTE. CALLE CIRCUNVALACION CASA ? ', '6', '609', '22541284', '', 'P', '', '', ''),
('45547762', 'DUI', 1, '', 1, '3.35458E+11', 'COF', 'ERICA', 'SARAI', 'VASQUEZ', 'RIVERA', '', '', '', '111914054', '', 'F', '222', '268.5', '05/11/1991', 'S', 'EL CHAGUITON', '8', '813', '73621686', '', 'P', '07/05/2011', '', ''),
('45711549', 'DUI', 1, '', 1, '3.36427E+11', 'COF', 'ELISA', 'JUDIT', 'QUINTANILLA', 'MONTES', '', '', '', '', '', 'F', '222', '257.21', '10/02/1992', 'S', 'CALLE PRINCIPAL DE SAN LUIS TALPA HACIENDA SANTA CLARA CANTON TECUALUYA', '8', '813', '72588667', 'elisaquintanilla@yahoo.com', 'P', '01/01/2013', '', ''),
('45940821', 'DUI', 1, '', 1, '3.33898E+11', 'MAX', 'SARA                ', 'MARINA                        ', 'RAMOS               ', 'HERNANDEZ           ', '                    ', '', '              ', '         ', '          ', 'F', '222', '', '02/06/1991', 'S', 'CANTON COMALAPA CASERIO LOS HUEZOS                ', '8', '812', '            ', '', 'P', '', '', ''),
('46036861', 'DUI', 1, '', 1, '3.37147E+11', 'MAX', 'JOSELIN             ', 'GABRIELA                      ', 'FLORES              ', 'ESPERANZA           ', '                    ', '', '              ', '111923849', '          ', 'F', '222', '', '22/04/1992', 'S', 'BARRIO SAN ISIDRO CALLE JULIO CESAR GALLARDO      ', '8', '802', '            ', '', 'P', '', '', ''),
('46243044', 'DUI', 1, '', 1, '3.33657E+11', 'MAX', 'ANA                 ', 'GLORIA                        ', 'HERNANDEZ           ', 'HERNANDEZ           ', '                    ', '', '              ', '         ', '          ', 'F', '222', '', '09/05/1991', 'S', 'LOTIFICACION CASA LOMA CARRETEA ANTIGUA A         ', '8', '806', '72130998', '', 'P', '', '', ''),
('46249773', 'DUI', 1, '', 1, '3.36323E+11', 'COF', 'JOSE', 'NICOLAS', 'CORTES', 'DE PAZ', '', '', '', '111923470', '', 'M', '222', '302.88', '31/01/1992', 'S', 'BARRIO LA CRUZ CALLE PPAL', '8', '811', '23305037', 'josenicolascortesdepaz6@gmail.com', 'P', '09/03/2015', '', ''),
('46352615', 'DUI', 1, '', 1, '3.37167E+11', 'COF', 'LAURA', 'LUCRECIA', 'CANTOR', 'MEJIA', '', '', '8.05E+12', '', '', 'F', '222', '88.91', '24/04/1992', 'S', 'KM 25 C A COMALAPA EL SALAMO', '8', '805', '77537812', 'laura_cantor93@yahoo.com', 'P', '12/10/2016', '', ''),
('46453851', 'DUI', 1, '', 1, '3.35872E+11', 'MAX', 'JOSE                ', 'YONATAN                       ', 'ALEMAN              ', 'GARAY               ', '                    ', '', '              ', '         ', '          ', 'M', '222', '', '17/12/1991', 'S', 'LOTIFICACION SANTA CRISTINA                       ', '8', '814', '            ', '', 'P', '', '', ''),
('46732954', 'DUI', 1, '', 1, '3.38307E+11', 'COF', 'VICTORIA', 'YAMILETH', 'HERNANDEZ', 'HERNANDEZ', '', '', '', '', '', 'F', '222', '306.08', '16/08/1992', 'S', 'AEROPUERTO INETERNACIONAL DE EL SALVADOR LOCAL 18 ENTRADA DE LA CASETA', '8', '811', '74137160', 'vickylinda1702_09@hotmail.com', 'P', '10/11/2013', '', ''),
('46772899', 'DUI', 1, '', 1, '3.37763E+11', 'MAX', 'JAVIER              ', 'ANTONIO                       ', 'RIVAS               ', 'FLORES              ', '                    ', '', '              ', '111922369', '          ', 'M', '222', '', '23/06/1992', 'S', 'COLONIA EL MILAGRO                                ', '8', '802', '23676729', '', 'P', '', '', ''),
('47272583', 'DUI', 1, '', 1, '3.32778E+11', 'MAX', 'AMANDA              ', 'MARIBEL                       ', 'RIVAS               ', 'TORRES              ', '                    ', '', '              ', '         ', '          ', 'F', '222', '', '10/02/1991', 'S', 'CANTON CANGREJERA CALLE PRINCIPAL PLAYA CANGREJERA', '5', '510', '75500052', '', 'P', '', '', ''),
('47497484', 'DUI', 1, '', 1, '3.39888E+11', 'MAX', 'LILIANA             ', 'LISBETH                       ', 'FUNES               ', 'VASQUEZ             ', '                    ', '', '5.18E+12', '111930260', '          ', 'F', '222', '', '21/01/1993', 'S', 'BARRIO CONCEPCION CALLE LA RONDA                  ', '5', '519', '            ', '', 'P', '', '', ''),
('47563968', 'DUI', 1, '', 1, '3.35062E+11', 'MAX', 'CARLOS              ', 'FRANCISCO                     ', 'SUAREZ              ', 'LEIVA               ', '                    ', '', '              ', '         ', '          ', 'M', '222', '', '27/09/1991', 'S', 'COLONIA LAS BRISAS LOTE 6                         ', '8', '814', '72721437', '', 'P', '', '', ''),
('47670480', 'DUI', 1, '', 1, '3.40163E+11', 'MAX', 'JOSE                ', 'DAVID                         ', 'ESPERANZA           ', 'MOLINA              ', '                    ', '', '              ', '         ', '          ', 'M', '222', '', '18/02/1993', 'S', 'LOTIFICACION JIBOA CALLE PRINCIPAL LOTE 34        ', '10', '1001', '70950136', '', 'P', '', '', ''),
('47723259', 'DUI', 1, '', 1, '3.40217E+11', 'MAX', 'TANIA               ', 'RAQUEL                        ', 'GUEVARA             ', 'MARTINEZ            ', '                    ', '', '              ', '         ', '          ', 'F', '222', '', '23/02/1993', 'S', 'BARRIO EL CALVARIO CALLE 2 DE NOVIEMBRE 1 CUADRA  ', '8', '810', '23621345', '', 'P', '', '', ''),
('47740015', 'DUI', 1, '', 1, '3.40223E+11', 'MAX', 'LUIS                ', 'HUMBERTO                      ', 'MURILLO             ', 'GIRON               ', '                    ', '', '              ', '         ', '          ', 'M', '222', '', '24/02/1993', 'S', 'COLONIA LAS FLORES DE SAN LUIS AVENIDA LOS COCOS  ', '8', '814', '            ', '', 'P', '', '', ''),
('48406630', 'DUI', 1, '', 1, '3.34372E+11', 'MAX', 'MAURICIO            ', 'ERNESTO                       ', 'RODRIGUEZ           ', 'HERNANDEZ           ', '                    ', '', '              ', '         ', '          ', 'M', '222', '', '20/07/1991', 'S', 'URBANIZACION SIERRA MORENA 1 PASAJE 3 POLIGONO 20 ', '6', '618', '22955248', '', 'P', '', '', ''),
('48453394', 'DUI', 1, '', 1, '3.42257E+11', 'MAX', 'ANA                 ', 'CONCEPCION                    ', 'CERON               ', 'OSORIO              ', '                    ', '', '              ', '         ', '          ', 'F', '222', '', '15/09/1993', 'S', 'COLONIA MONTELIMAR PASAJE 4 POLIGONO 5 BLOCK H    ', '8', '806', '79143852', '', 'P', '', '', ''),
('48604238', 'DUI', 1, '', 1, '3.40662E+11', 'COF', 'RAUL', 'ANTONIO', 'MEDRANO', 'ACOSTA', '', '', '', '', '', 'M', '222', '245.41', '09/04/1993', 'S', 'CANTON EL CARMEN CASERIO PORTILLO EL CABRAL', '8', '815', '', '', 'P', '01/12/2011', '', ''),
('48649026', 'DUI', 1, '', 1, '3.42077E+11', 'COF', 'ALEJANDRA', 'VANESSA', 'DE LEON', 'SALVADOR', '', '', '', '', '', 'F', '222', '206.1', '28/08/1993', 'S', 'LOTIFICACION CASA BLANCA PJE 1', '8', '805', '79691129', '', 'P', '16/01/2014', '', ''),
('48714253', 'DUI', 1, '', 1, '3.42942E+11', 'MAX', 'JAVIER              ', 'ATILIO                        ', 'RAMIREZ             ', 'FUENTES             ', '                    ', '', '              ', '         ', '          ', 'M', '222', '', '23/11/1993', 'S', 'BARRIO CELIS CARRETERA ANTIGUA A ZACATECOLUCA     ', '8', '802', '77308543', '', 'P', '', '', ''),
('48855821', 'DUI', 1, '', 1, '3.42297E+11', 'COF', 'CLAUDIA', 'BEATRIZ', 'RUBIO', 'PEREZ', '', '', '', '', '', 'F', '222', '271.48', '19/09/1993', 'S', 'COLONIA SAN LUIS CALLE PRINCIPAL CASA 9', '6', '616', '70074707', 'claudia27perez6@gmail.com', 'P', '23/11/2013', '', ''),
('48903234', 'DUI', 1, '', 1, '3.42497E+11', 'MAX', 'JENNIFER            ', 'NOHEMY                        ', 'DE LEON             ', 'HERNANDEZ           ', '                    ', '', '              ', '         ', '          ', 'F', '222', '', '09/10/1993', 'S', 'RECIDENCIAL PARAISOS DE LA ESCALON SENDA MAQUILIHU', '6', '601', '22609643', '', 'P', '', '', ''),
('49038642', 'DUI', 1, '', 1, '3.42557E+11', 'MAX', 'TERESA              ', 'DEL CARMEN                    ', 'GOMEZ               ', 'ARGUETA             ', '                    ', '', '              ', '         ', '          ', 'F', '222', '', '15/10/1993', 'S', 'CANTON SAN ANTONIO PANCHIMILAMA CASERIO EL COPINOL', '8', '810', '            ', '', 'P', '', '', ''),
('49139367', 'DUI', 1, '', 1, '3.42853E+11', 'MAX', 'EMERSON             ', 'JOSE                          ', 'VASQUEZ             ', 'SOLANO              ', '                    ', '', '              ', '         ', '          ', 'M', '222', '', '14/11/1993', 'S', 'CANTON CANGREJERA CASERIO CORDONCILLO             ', '5', '510', '71955975', '', 'P', '', '', ''),
('49173612', 'DUI', 1, '', 1, '3.42876E+11', 'COF', 'DIANA', 'IVETTE', 'MENDOZA', 'BARRERA', '', '', '', '', '', 'F', '222', '86', '16/11/1993', 'S', 'BO SN JACINTO  COL LAS CONCHAS  AV LAS CONCHAS  PJE 10  BK P  CASA 11', '6', '614', '22800540', '', 'P', '12/10/2016', '', ''),
('49304687', 'DUI', 1, '', 1, '3.42107E+11', 'COF', 'MARIA', 'GUADALUPE', 'BONILLA', 'RODRIGUEZ', '', '', '', '', '', 'F', '222', '256.01', '31/08/1993', 'S', 'LOT MIRAFLORES 1 POL 45 LOTE 3-4', '8', '815', '23013278', 'guadalupecastro2011@hotmail.es', 'P', '01/04/2013', '', ''),
('49313343', 'DUI', 1, '', 1, '3.42537E+11', 'MAX', 'LIDIA               ', 'IVANIA                        ', 'CAMPOS              ', 'POSADA              ', '                    ', '', '              ', '         ', '          ', 'F', '222', '', '13/10/1993', 'S', 'COLONIA NUEVO MONTECRISTO 1 PASAJE A CASA 31      ', '6', '614', '            ', '', 'P', '', '', ''),
('49325578', 'DUI', 1, '', 1, '3.41892E+11', 'COF', 'EDWIN', 'OMAR', 'ORELLANA', 'FLORES', '', '', '6.14E+12', '', '', 'M', '222', '95.06', '10/08/1993', 'S', 'LOT LAS BRUMAS CL PPAL N 17', '7', '702', '61165829', 'orellana_10@yahoo.com', 'P', '12/10/2016', '', ''),
('49436638', 'DUI', 1, '', 1, '3.43037E+11', 'COF', 'CLAUDIA', 'GUADALUPE', 'GARCIA', 'MARINERO', '', '', '', '', '', 'F', '222', '33.39', '02/12/1993', 'S', 'COL LA ILUSION POLG E CASA 9', '10', '1011', '73878430', '', 'P', '25/10/2016', '', ''),
('49578105', 'DUI', 1, '', 1, '3.40228E+11', 'COF', 'SUSANA', 'DEL CARMEN', 'GONZALEZ', 'PINEDA', '', '', '', '', '', 'F', '222', '192.23', '24/02/1993', 'S', 'BARRIO SAN FRANCISCO', '8', '809', '74502481', 'susanagba_13@hotmail.com', 'P', '03/10/2016', '', ''),
('49783190', 'DUI', 1, '', 1, '3.44387E+11', 'MAX', 'OLGA                ', 'GUADALUPE                     ', 'MERCADO             ', 'CRUZ                ', '                    ', '', '              ', '         ', '          ', 'F', '222', '', '16/04/1994', 'S', 'LOTIFICACION LA MARTINA CALLE PRINCIPAL CASA 6    ', '6', '614', '70879146', '', 'P', '', '', ''),
('49936955', 'DUI', 1, '', 1, '3.44762E+11', 'COF', 'RODOLFO', 'ARIEL', 'ESCOBAR', 'MIRANDA', '', '', '', '', '', 'M', '222', '93.06', '24/05/1994', 'S', 'REPARTO SAN JOSE 2 CALLE  B BLOCK  C CASA  92', '6', '617', '22901218', 'rodolfoariel94@hotmail.com', 'P', '12/10/2016', '', ''),
('50006064', 'DUI', 1, '', 1, '3.44771E+11', 'MAX', 'MAGDIEL             ', 'ELIUD                         ', 'BARRERA             ', 'HENRIQUEZ           ', '                    ', '', '              ', '         ', '          ', 'M', '222', '', '25/05/1994', 'S', 'BARRIO ANALCO 10A CALLE PONIENTE CASA 19          ', '8', '801', '            ', '', 'P', '', '', ''),
('5008142', 'DUI', 1, '', 1, '2.62922E+11', 'MAX', 'JUAN                ', 'FRANCISCO                     ', 'GONZALEZ            ', 'GOMEZ               ', '                    ', '', '1.00E+13', '693716283', '          ', 'M', '222', '', '27/12/1971', 'S', 'COLONIA SAN NICOLAS CALLE PRINCIPAL POLIGONO B CAS', '6', '618', '22080732', '', 'P', '', '', ''),
('50156916', 'DUI', 1, '', 1, '3.45212E+11', 'MAX', 'WILFREDO            ', 'ALEXANDER                     ', 'CRUZ                ', 'CLARO               ', '                    ', '', '              ', '         ', '          ', 'M', '222', '', '08/07/1994', 'S', 'COLONIA SANTA MARTA CALLE AL VOLCAN CASA 15       ', '8', '801', '73291700', '', 'P', '', '', ''),
('50167226', 'DUI', 1, '', 1, '3.45256E+11', 'MAX', 'JOCELINE            ', 'ALEJANDRA                     ', 'ALARCON             ', 'FIGUEROA            ', '                    ', '', '              ', '         ', '          ', 'F', '222', '', '12/07/1994', 'S', 'CENTRO URBANO LOURDES EDIFIO Y APARTAMENTO 31 3A  ', '6', '601', '            ', '', 'P', '', '', ''),
('50195669', 'DUI', 1, '', 1, '3.45142E+11', 'COF', 'GUILLERMO', 'VLADIMIR', 'LOPEZ', 'CRUZ', '', '', '', '', '', 'M', '222', '130.05', '01/07/1994', 'S', 'COL ESPERANZA 2 CL AL PUENTE CASA 7', '6', '615', '74119212', 'guivlad22@gmail.com', 'P', '03/10/2016', '', ''),
('50416641', 'DUI', 1, '', 1, '3.45087E+11', 'COF', 'ANA', 'LORENA', 'MARTINEZ', 'FLORES', '', '', '', '', '', 'F', '222', '238.82', '25/06/1994', 'S', 'EL CHILAMATE LA CIMA', '8', '805', '71029323', 'lorenamartinez@yahoo.com', 'P', '25/11/2013', '', ''),
('50517146', 'DUI', 1, '', 1, '3.45997E+11', 'COF', 'ANDREA', 'BEATRIZ', 'TOMASINO', 'MEJIA', '', '', '', '', '', 'F', '222', '125.85', '24/09/1994', 'S', 'HACIENDA ASTORIA LAS FLORES', '8', '815', '61419464', '', 'P', '01/09/2016', '', ''),
('50778263', 'DUI', 1, '', 1, '3.44157E+11', 'COF', 'MONICA', 'ABIGAIL', 'ALVARENGA', 'LARA', '', '', '', '', '', 'F', '222', '48.21', '24/03/1994', 'S', 'RES SANTORINI SENDA 2 CASA 10', '6', '612', '21243611', 'monika_lara24@hotmail.com', 'P', '21/10/2016', '', ''),
('50810617', 'DUI', 1, '', 1, '3.45843E+11', 'COF', 'LUIS', 'ALEXANDER', 'URIAS', 'YANES', '', '', '', '', '', 'M', '222', '234.4', '09/09/1994', 'S', 'LOT MIRAFLORES 5 POL 67 PJE 2 CASA 12', '8', '815', '71210431', 'luisyanesurias175@gmail.com', 'P', '08/11/2013', '', ''),
('50845997', 'DUI', 1, '', 1, '3.46057E+11', 'COF', 'SAHYRA', 'LISSETH', 'GONZALEZ', 'LOPEZ', '', '', '', '', '', 'F', '222', '241.21', '30/09/1994', 'S', 'CANTON EL COMALAPA CASERIO LOS HUEZOS CALLE EL NISPERO', '8', '813', '73355901', 'sahyralopez3094@gmail.com', 'P', '01/04/2013', '', ''),
('51131105', 'DUI', 1, '', 1, '3.47182E+11', 'MAX', 'VICTOR              ', 'HUGO                          ', 'DURAN               ', 'LEIVA               ', '                    ', '', '              ', '         ', '          ', 'M', '222', '', '21/01/1995', 'S', 'COLONIA ENCARNACION 1 3A CALLE ORIENTE CASA 47 BIS', '6', '614', '73538699', '', 'P', '', '', ''),
('51197020', 'DUI', 1, '', 1, '3.47297E+11', 'MAX', 'SARA                ', 'ELIZABETH                     ', 'ALVARENGA           ', 'VIDES               ', '                    ', '', '              ', '         ', '          ', 'F', '222', '', '01/02/1995', 'S', 'COLONIA LAS HADAS PASAJE 2 CASA 12                ', '6', '617', '78201470', '', 'P', '', '', ''),
('51208059', 'DUI', 1, '', 1, '3.43283E+11', 'MAX', 'GERARDO             ', 'JAVIER                        ', 'ORTIZ               ', 'HERNANDEZ           ', '                    ', '', '              ', '         ', '          ', 'M', '222', '', '27/12/1993', 'S', 'CANTON SANTA CRUZ CALLE ROSARIO DE MORA PASAJE    ', '5', '510', '            ', '', 'P', '', '', ''),
('51281811', 'DUI', 1, '', 1, '3.47531E+11', 'MAX', 'ABEL                ', 'FERNANDO                      ', 'MELARA              ', 'DIAZ                ', '                    ', '', '              ', '         ', '          ', 'M', '222', '', '25/02/1995', 'S', 'COLONIA ESCALON CALLE AL CARMEN 75 AVENIDA NORTE  ', '6', '601', '73474397', '', 'P', '', '', ''),
('51340681', 'DUI', 1, '', 1, '3.47627E+11', 'COF', 'WENDY', 'JAMILETH', 'BOLA?OS', 'CHAVEZ', '', '', '', '', '', 'F', '222', '130.11', '06/03/1995', 'S', 'COLONIA MONTELIMAR POLIGONO 3 BLOCK F CASA 18', '8', '805', '74629651', 'wendyjamilethchavez@hotmail.com', 'P', '01/11/2013', '', ''),
('51389017', 'DUI', 1, '', 1, '3.47642E+11', 'MAX', 'JOSE                ', 'ALFREDO                       ', 'RAMOS               ', 'CARRILLO            ', '                    ', '', '              ', '         ', '          ', 'M', '222', '', '08/03/1995', 'S', 'CANTON AMATE BLANCO BARRIO EL CENTRO              ', '6', '613', '61541178', '', 'P', '', '', ''),
('51568611', 'DUI', 1, '', 1, '3.47958E+11', 'COF', 'WENDI', 'YANET', 'RUANO', 'OSTORGA', '', '', '', '113953026', '', 'F', '222', '261.09', '08/04/1995', 'S', 'C LA CUCHILLA COMALAPA', '8', '813', '77512791', 'wendyruano2@gmail.com', 'P', '01/01/2014', '', ''),
('51665984', 'DUI', 1, '', 1, '3.48067E+11', 'MAX', 'MARIA               ', 'BEATRIZ                       ', 'SANCHEZ             ', 'MARTINEZ            ', '                    ', '', '              ', '         ', '          ', 'F', '222', '', '19/04/1995', 'S', 'LOTIFICACION CHALTEPE CASA 2                      ', '6', '617', '77722045', '', 'P', '', '', ''),
('51696537', 'DUI', 1, '', 1, '3.48327E+11', 'COF', 'FATIMA', 'LISSETH', 'GARCIA', 'AREVALO', '', '', '', '', '', 'F', '222', '142.15', '15/05/1995', 'S', 'COLONIA  MONTELIMAR BLOCK B POLIGONO 10 PASAJE 10 CASA 21', '8', '805', '73379040', 'fatimalissethgarcia@hotmail.com', 'P', '04/11/2013', '', ''),
('51886661', 'DUI', 1, '', 1, '3.47468E+11', 'COF', 'BRENDA', 'ELIZABETH', 'REYES', 'RECINOS', '', '', '', '', '', 'F', '222', '25.03', '18/02/1995', 'S', 'SAN PEDRO LA PALMA', '8', '820', '74464065', 'elyzabeth_down95@hotmail.com', 'P', '27/10/2016', '', ''),
('51961788', 'DUI', 1, '', 1, '3.50073E+11', 'COF', 'MANUEL', 'ANTONIO', 'ZEPEDA', 'RAMIREZ', '', '', '', '', '', 'M', '222', '29.37', '06/11/1995', 'S', 'BO LA ESPERANZA CL AAL SICAHUITE', '8', '802', '74458782', '', 'P', '25/10/2016', '', ''),
('51982386', 'DUI', 1, '', 1, '3.48477E+11', 'MAX', 'KARLA               ', 'NOHEMY                        ', 'HERNANDEZ           ', 'ROJAS               ', '                    ', '', '              ', '         ', '          ', 'F', '222', '', '30/05/1995', 'S', 'COLONIA SAN NICOLAS CALLE PRINCIPAL POLIGONO B    ', '6', '618', '72943079', '', 'P', '', '', ''),
('52009929', 'DUI', 1, '', 1, '3.43712E+11', 'COF', 'DAVID', 'ADALBERTO', 'MELARA', 'FLORES', '', '', '', '', '', 'M', '222', '223.86', '08/02/1994', 'S', 'BO SAN MIGUELITO 23 CALLE OTE CASA 228', '6', '614', '22359583', 'adalberto.melara@gmail.com', 'P', '01/09/2016', '', ''),
('52024246', 'DUI', 1, '', 1, '3.48591E+11', 'MAX', 'GABRIEL             ', 'ALEJANDRO                     ', 'MASIN               ', 'CHAVEZ              ', '                    ', '', '              ', '         ', '          ', 'M', '222', '', '11/06/1995', 'S', 'URBANIZACION NUEVOS HORIZONTES PASAJE 15 NORTE 3A ', '6', '609', '            ', '', 'P', '', '', ''),
('5205176', 'DUI', 1, '', 1, '2.29102E+11', 'MAX', 'MARIO               ', 'JAIME                         ', 'HERNANDEZ           ', 'TOMASINO            ', '                    ', '', '6.07E+12', '293621485', '          ', 'M', '222', '', '23/09/1962', 'C', 'REPARTO. STA. LUCIA ZONA. 6 PJE 26 PASARELA "H"   ', '6', '610', '22762326', '', 'P', '', '', ''),
('52080543', 'DUI', 1, '', 1, '3.49788E+11', 'MAX', 'KEYLA               ', 'LISSETTE                      ', 'RAMIREZ             ', 'CASTRO              ', '                    ', '', '6.14E+12', '         ', '          ', 'F', '222', '', '08/10/1995', 'S', 'BARRIO EL CALVARIO CALLE MEXICO CASA 4            ', '6', '616', '74617203', '', 'P', '', '', ''),
('52111239', 'DUI', 1, '', 1, '3.49422E+11', 'COF', 'GERSON', 'ABDIEL', 'MARTINEZ', 'SALMERON', '', '', '', '', '', 'M', '222', '319', '02/09/1995', 'S', 'COLONIA JARDINES DE SLSUTT PASAJE 18 POLIGONO I 2 CASA 10', '6', '607', '22050128', 'germarti@hotmail.com', 'P', '01/11/2013', '', ''),
('52145678', 'DUI', 1, '', 1, '3.49786E+11', 'COF', 'ELIZABETH', 'ALEJANDRA', 'BERDUGO', 'BARRERA', '', '', '', '', '', 'F', '222', '136.95', '08/10/1995', 'S', 'COL SAN ANTONIO 2 BLOCK D CASA 2', '6', '612', '22203190', 'z.ale09@hotmail.com', 'P', '03/10/2016', '', ''),
('52297027', 'DUI', 1, '', 1, '3.49358E+11', 'MAX', 'MIRNA               ', 'ARELY                         ', 'SANCHEZ             ', 'SANCHEZ             ', '                    ', '', '              ', '         ', '          ', 'F', '222', '', '26/08/1995', 'S', 'COLONIA EL CHACO 2 PASAJE 1 CASA 1                ', '6', '617', '70611313', '', 'P', '', '', ''),
('52307733', 'DUI', 1, '', 1, '3.49398E+11', 'MAX', 'JULIA               ', 'RAQUEL                        ', 'PEREZ               ', 'MARTINEZ            ', '                    ', '', '              ', '         ', '          ', 'F', '222', '', '30/08/1995', 'S', 'COLONIA SANTA MARIA CARRETERA A COMALAPA KILOMETRO', '8', '806', '72178840', '', 'P', '', '', ''),
('52370574', 'DUI', 1, '', 1, '3.49147E+11', 'COF', 'ANA', 'MARIA', 'MALDINERA', 'LOPEZ', '', '', '', '', '', 'F', '222', '121.6', '05/08/1995', 'S', 'CARRETERA TRONCAL DEL NORTE COLONIA SAN ANTONIO CASA 5', '6', '602', '25436982', '', 'P', '05/10/2016', '', ''),
('52568355', 'DUI', 1, '', 1, '3.49952E+11', 'MAX', 'ARNOLDO             ', 'VLADIMIR                      ', 'GUEVARA             ', 'LOPEZ               ', '                    ', '', '              ', '         ', '          ', 'M', '222', '', '25/10/1995', 'S', 'CANTON SAN JOSE ARRIBA                            ', '8', '821', '            ', '', 'P', '', '', ''),
('52585072', 'DUI', 1, '', 1, '3.47713E+11', 'MAX', 'JOSE                ', 'RAFAEL                        ', 'ZALDA?A             ', 'VALENCIA            ', '                    ', '', '              ', '         ', '          ', 'M', '222', '', '15/03/1995', 'S', 'BARRIO EL ANGEL CALLE PRINCIPAL CASA 1            ', '8', '803', '76169874', '', 'P', '', '', ''),
('52694368', 'DUI', 1, '', 1, '3.50217E+11', 'MAX', 'DAYSI               ', 'GUADALUPE                     ', 'MERCADO             ', 'BAYONA              ', '                    ', '', '              ', '         ', '          ', 'F', '222', '', '20/11/1995', 'S', 'COLONIA SAN JOSE 2 POLIGONO 9 CASA 11             ', '6', '617', '73254975', '', 'P', '', '', ''),
('52784286', 'DUI', 1, '', 1, '3.50351E+11', 'MAX', 'WALNER              ', 'ALEXANDER                     ', 'CHACON              ', 'LOPEZ               ', '                    ', '', '              ', '         ', '          ', 'M', '222', '', '04/12/1995', 'S', 'COLONIA DALMACIA 2 CALLE AL PUENTE POLIGONO 5 CASA', '6', '616', '70471616', '', 'P', '', '', ''),
('53117199', 'DUI', 1, '', 1, '3.50267E+11', 'MAX', 'WENDI               ', 'MAGDALENA                     ', 'ORELLANA            ', 'LANDAVERDE          ', '                    ', '', '              ', '         ', '          ', 'F', '222', '', '25/11/1995', 'S', 'BARRIO EL CALVARIO LOTIFICACION ZAPOTITAN CASA 1  ', '8', '816', '76399255', '', 'P', '', '', ''),
('53200798', 'DUI', 1, '', 1, '3.51257E+11', 'MAX', 'MONICA              ', 'DANIELA                       ', 'MERCADO             ', 'CRUZ                ', '                    ', '', '              ', '         ', '          ', 'F', '222', '', '03/03/1996', 'S', 'COLONIA MARTINA 1 CALLE PRINCIPAL POLIGONO 7 CASA ', '6', '614', '75034120', '', 'P', '', '', ''),
('53376905', 'DUI', 1, '', 1, '3.51637E+11', 'MAX', 'ELSI                ', 'ISABEL                        ', 'MUNGUIA             ', 'CRUZ                ', '                    ', '', '              ', '         ', '          ', 'F', '222', '', '10/04/1996', 'S', 'URBANIZACION SAN HENRIQUEZ CALLE DIEGO DE HOLGUIN ', '6', '618', '63080004', '', 'P', '', '', ''),
('53533777', 'DUI', 1, '', 1, '3.45808E+11', 'COF', 'ROXANA', 'MAYARITH', 'CHANCHAN', 'VIGIL', '', '', '', '', '', 'F', '222', '86.14', '05/09/1994', 'S', 'HACIENDA ASTORIA LAS FLORES', '8', '815', '71911709', '', 'P', '12/10/2016', '', ''),
('53638925', 'DUI', 1, '', 1, '3.50063E+11', 'MAX', 'RAUL                ', 'JOSUE                         ', 'RIVAS               ', 'FRANCO              ', '                    ', '', '              ', '         ', '          ', 'M', '222', '', '05/11/1995', 'S', 'COLONIA MONTELIMAR PASAJE 5 POLIGONO 4 BLOCK D    ', '8', '806', '            ', '', 'P', '', '', ''),
('53672979', 'DUI', 1, '', 1, '3.52247E+11', 'MAX', 'RAQUEL              ', 'ELIZABETH                     ', 'LEBRON              ', 'LOPEZ               ', '                    ', '', '              ', '         ', '          ', 'F', '222', '', '10/06/1996', 'S', 'RESIDENCIAL JARDINES DE SAN MARCOS PASAJE 1 BLOCK ', '6', '614', '75422001', '', 'P', '', '', ''),
('53861146', 'DUI', 1, '', 1, '3.52618E+11', 'MAX', 'FERNANDA            ', 'ROXANA                        ', 'GARCIA              ', 'VELASQUEZ           ', '                    ', '', '              ', '         ', '          ', 'F', '222', '', '17/07/1996', 'S', 'URBANIZACION MONTES DE SAN BARTOLO 5 CALLE ACCESO ', '6', '618', '71688952', '', 'P', '', '', ''),
('54045418', 'DUI', 1, '', 1, '3.54108E+11', 'MAX', 'YULISSA             ', 'SARAHI                        ', 'URRUTIA             ', 'ERAZO               ', '                    ', '', '              ', '         ', '          ', 'F', '222', '', '13/12/1996', 'S', 'COMUNIDAD IBERIA PASAJE LAS AZUCENAS BLOCK 7      ', '6', '601', '76407290', '', 'P', '', '', ''),
('54534255', 'DUI', 1, '', 1, '3.47547E+11', 'MAX', 'KARLA               ', 'ESTEPHANIE                    ', 'RAMIREZ             ', 'EDUARDO             ', '                    ', '', '8.05E+12', '         ', '          ', 'F', '222', '', '26/02/1995', 'S', 'BARRIO EL CARMEN                                  ', '8', '806', '71875478', '', 'P', '', '', ''),
('54568335', 'DUI', 1, '', 1, '3.54057E+11', 'MAX', 'KARLA               ', 'VANESSA                       ', 'GOMEZ               ', 'MEJIA               ', '                    ', '', '              ', '         ', '          ', 'F', '222', '', '08/12/1996', 'S', 'URBANIZACION SIERRA MORENA 2 PASAJE 8 POLIGONO 6  ', '6', '618', '76383927', '', 'P', '', '', ''),
('54669995', 'DUI', 1, '', 1, '3.53793E+11', 'COF', 'ERNESTO', 'JAVIER', 'VILLALOBOS', 'MARTINEZ', '', '', '', '', '', 'M', '222', '151.19', '12/11/1996', 'S', 'COLONIA CIUDAD PACIFICA IV ETAPA SENDA BUGAMBILIA D-64 CASA NO 21', '12', '1217', '75615280', 'martinezernesto1996@gmail.com', 'P', '03/10/2016', '', ''),
('54799407', 'DUI', 1, '', 1, '3.51352E+11', 'MAX', 'MANUEL              ', 'ISAI                          ', 'CRUZ                ', 'HERNANDEZ           ', '                    ', '', '              ', '         ', '          ', 'M', '222', '', '13/03/1996', 'S', 'URBANIZACION LIRIOS DEL NORTE 1 CALLE PRINCIPAL   ', '6', '605', '77880409', '', 'P', '', '', ''),
('55034410', 'DUI', 1, '', 1, '3.54938E+11', 'COF', 'MELANIE', 'ASTRID', 'PORTILLO', 'TOBAR', '', '', '', '', '', 'F', '222', '192.53', '06/03/1997', 'S', 'COL EL MILAGRO FNL 1 CL OTE PJE 4 CASA 6', '6', '612', '74815677', 'melanie2531tobat@gmail.com', 'P', '01/09/2016', '', ''),
('56171281', 'DUI', 1, '', 1, '3.57462E+11', 'MAX', 'MAUDIEL             ', 'EDGARDO                       ', 'CAMPOS              ', 'PEREZ               ', '                    ', '', '              ', '         ', '          ', 'M', '222', '', '14/11/1997', 'S', 'BARRIO EL CALVARIO                                ', '8', '806', '71925441', '', 'P', '', '', ''),
('56814415', 'DUI', 1, '', 1, '3.58748E+11', 'COF', 'ANA', 'MILAGRO', 'REYES', 'PEREZ', '', '', '', '', '', 'F', '222', '29.95', '22/03/1998', 'S', 'B? EL CARMEN CL ANTIGUA AL SEMENTERIO LOTE # 8', '8', '805', '78660334', 'reyesperezanamilagro@gmail.com', 'P', '25/10/2016', '', ''),
('56818207', 'DUI', 1, '', 1, '3.58788E+11', 'MAX', 'HAZEL               ', 'MARISOL                       ', 'DE LA O             ', 'SOLORZANO           ', '                    ', '', '              ', '         ', '          ', 'F', '222', '', '26/03/1998', 'S', 'BARRIO SAN ISIDRO CALLE ANTIGUA A ZACATECOLUCA    ', '8', '802', '            ', '', 'P', '', '', ''),
('56956364', 'DUI', 1, '', 1, '3.59041E+11', 'COF', 'ABRAHAM', 'ALEXANDER', 'ESCOBAR', 'CUELLAR', '', '', '', '', '', 'M', '222', '29.37', '21/04/1998', 'S', 'COL COSTA RICA AC IRAZU 124A', '6', '614', '72348126', 'alexandercuellar182@gmail.com', 'P', '25/10/2016', '', ''),
('791481', 'DUI', 1, '', 1, '2.99193E+11', 'MAX', 'HERBERT             ', 'ORLANDO                       ', 'MENJIVAR            ', 'SARCO               ', '                    ', '', '6.14E+12', '         ', '          ', 'M', '222', '', '01/12/1981', 'S', 'RPTO. SAN BARTOLO TICSA LOT. SAN ANTONIO PJE 2    ', '6', '609', '22963679', '', 'P', '', '', ''),
('8919855', 'DUI', 1, '', 1, '2.68071E+11', 'MAX', 'CESAR               ', 'ALBERTO                       ', 'APARICIO            ', 'ALARCON             ', '                    ', '', '              ', '197732889', '          ', 'M', '222', '', '25/05/1973', 'C', 'COL POPOTLAN 3 1 PJE ZACATECOLUCA EQ 34 CASA ? 16 ', '6', '603', '            ', '', 'P', '', '', ''),
('9121031', 'DUI', 1, '', 1, '1.99322E+11', 'MAX', 'ALFREDO             ', '                              ', 'HERNANDEZ           ', 'RUIZ                ', '                    ', '', '9.09E+12', '193540395', '          ', 'M', '222', '', '29/07/1954', 'C', 'CARRET.TRONCAL NORTE KILO 11 COLONIA SAN ANTONIO  ', '6', '603', '22770528', '', 'P', '', '', ''),
('999999999', 'DUI', 2, '123456', 1, '999999999', '', 'Genaro', 'Alberto', 'Alvarenga', 'Rodriguez', '', 'Genaro', '999999999', '999999999', '', 'M', '222', '350.00', '', 'S', 'Ciudad Merliot', '5', '511', '76334114', '00093512@uca', 'P', '09/02/2017', '', '');

--
-- Triggers `empleado`
--
DELIMITER $$
CREATE TRIGGER `empleado_after_insert` AFTER INSERT ON `empleado` FOR EACH ROW INSERT INTO htrabajo (NumeroDocumento,idTurno) VALUES (NEW.NumeroDocumento,'24')
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `empresa`
--

CREATE TABLE `empresa` (
  `NitEmpresa` varchar(14) NOT NULL,
  `NombreEmpresa` varchar(255) NOT NULL,
  `Direccion` varchar(255) NOT NULL,
  `Telefono` varchar(80) NOT NULL,
  `Telefono2` varchar(30) NOT NULL,
  `NRegistro` varchar(40) NOT NULL,
  `Giro` varchar(255) NOT NULL,
  `NPatronalSS` varchar(13) NOT NULL,
  `NPatronalAFP` varchar(30) NOT NULL,
  `RepresentanteLegal` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16le;

--
-- Dumping data for table `empresa`
--

INSERT INTO `empresa` (`NitEmpresa`, `NombreEmpresa`, `Direccion`, `Telefono`, `Telefono2`, `NRegistro`, `Giro`, `NPatronalSS`, `NPatronalAFP`, `RepresentanteLegal`) VALUES
('222', 'DEFAULT', 'Ciudad Merliot Calle Tepeagua', '7633-4114', '', '', '', '', '', ''),
('admin', 'admin', 'admin', 'admin', 'admin', 'admin', 'admin', 'admin', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `htrabajo`
--

CREATE TABLE `htrabajo` (
  `idHTrabajo` int(11) NOT NULL,
  `NumeroDocumento` varchar(50) NOT NULL,
  `Desde` varchar(150) NOT NULL,
  `Hasta` varchar(150) NOT NULL,
  `idTurno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16le;

--
-- Dumping data for table `htrabajo`
--

INSERT INTO `htrabajo` (`idHTrabajo`, `NumeroDocumento`, `Desde`, `Hasta`, `idTurno`) VALUES
(1, '26569', '04:45:00', '21:15:00', 1),
(2, '169112', '08:00:00', '17:00:00', 13),
(3, '425933', '08:00:00', '17:00:00', 13),
(4, '791481', '06:30:00', '14:30:00', 11),
(5, '1123518', '08:00:00', '17:00:00', 13),
(6, '1509112', '12:30:00', '20:30:00', 18),
(7, '1856632', '04:45:00', '21:15:00', 1),
(8, '2923490', '05:00:00', '13:00:00', 5),
(9, '4296556', '08:00:00', '17:00:00', 13),
(10, '4537499', '04:45:00', '21:15:00', 1),
(11, '5008142', '04:45:00', '21:15:00', 1),
(12, '5205176', '04:45:00', '21:15:00', 1),
(13, '8919855', '04:45:00', '12:45:00', 2),
(14, '9121031', '04:45:00', '21:15:00', 1),
(15, '10611950', '04:45:00', '13:45:00', 3),
(16, '12039366', '04:45:00', '21:15:00', 1),
(17, '13519864', '04:45:00', '12:45:00', 2),
(18, '13816559', '04:45:00', '21:15:00', 1),
(19, '14809872', '04:45:00', '21:15:00', 1),
(20, '15226035', '04:45:00', '21:15:00', 1),
(21, '16721999', '04:45:00', '21:15:00', 1),
(22, '18133922', '12:15:00', '21:15:00', 17),
(23, '18838166', '05:00:00', '13:00:00', 5),
(24, '19045033', '04:45:00', '21:15:00', 1),
(25, '19622259', '06:00:00', '14:00:00', 8),
(26, '22330780', '12:30:00', '20:30:00', 18),
(27, '22933253', '08:00:00', '17:00:00', 13),
(28, '23036151', '04:45:00', '21:15:00', 1),
(29, '23177630', '04:45:00', '13:45:00', 3),
(30, '25465136', '04:45:00', '21:15:00', 1),
(31, '31079317', '04:45:00', '12:45:00', 2),
(32, '33510652', '06:00:00', '14:00:00', 8),
(33, '33784578', '13:15:00', '21:15:00', 20),
(34, '33915894', '12:30:00', '20:30:00', 18),
(35, '34292558', '07:00:00', '15:00:00', 12),
(36, '34494702', '12:30:00', '20:30:00', 18),
(37, '34631401', '05:00:00', '13:00:00', 5),
(38, '35267904', '06:00:00', '14:00:00', 8),
(39, '35442075', '08:00:00', '17:00:00', 13),
(40, '35867259', '05:00:00', '13:00:00', 5),
(41, '36075724', '08:00:00', '17:00:00', 13),
(42, '36383541', '12:00:00', '21:00:00', 16),
(43, '36462387', '06:00:00', '14:00:00', 8),
(44, '36482450', '06:00:00', '14:00:00', 8),
(45, '36803876', '10:00:00', '18:00:00', 14),
(46, '36867503', '13:15:00', '21:15:00', 20),
(47, '36886515', '13:00:00', '21:00:00', 19),
(48, '38249696', '06:00:00', '14:00:00', 8),
(49, '38866278', '12:30:00', '20:30:00', 18),
(50, '39383516', '08:00:00', '17:00:00', 13),
(51, '39427417', '06:00:00', '14:00:00', 8),
(52, '40063844', '06:00:00', '14:00:00', 8),
(53, '40445151', '06:00:00', '14:00:00', 8),
(54, '40797590', '13:00:00', '21:00:00', 19),
(55, '40823901', '08:00:00', '17:00:00', 13),
(56, '40848422', '05:00:00', '14:00:00', 6),
(57, '40901767', '12:30:00', '20:30:00', 18),
(58, '41316428', '05:00:00', '13:00:00', 5),
(59, '41511052', '06:00:00', '14:00:00', 8),
(60, '42462997', '12:30:00', '20:30:00', 18),
(61, '42817061', '08:00:00', '17:00:00', 13),
(62, '43004718', '17:15:00', '21:15:00', 23),
(63, '43508013', '04:45:00', '13:45:00', 3),
(64, '43751250', '06:00:00', '14:00:00', 8),
(65, '44754382', '05:00:00', '14:00:00', 6),
(66, '44878225', '08:00:00', '17:00:00', 13),
(67, '45141582', '04:45:00', '12:45:00', 2),
(68, '45547762', '06:00:00', '14:00:00', 8),
(69, '45711549', '12:30:00', '20:30:00', 18),
(70, '45940821', '12:30:00', '20:30:00', 18),
(71, '46036861', '12:30:00', '20:30:00', 18),
(72, '46243044', '04:45:00', '08:45:00', 4),
(73, '46249773', '17:00:00', '01:00:00', 21),
(74, '46352615', '08:00:00', '17:00:00', 13),
(75, '46453851', '12:30:00', '20:30:00', 18),
(76, '46732954', '13:00:00', '21:00:00', 19),
(77, '46772899', '06:00:00', '14:00:00', 8),
(78, '47272583', '11:00:00', '15:00:00', 15),
(79, '47497484', '04:45:00', '13:45:00', 3),
(80, '47563968', '06:00:00', '14:00:00', 8),
(81, '47670480', '17:00:00', '01:00:00', 21),
(82, '47723259', '08:00:00', '17:00:00', 13),
(83, '47740015', '08:00:00', '17:00:00', 13),
(84, '48406630', '11:00:00', '15:00:00', 15),
(85, '48453394', '04:45:00', '13:45:00', 3),
(86, '48604238', '13:00:00', '21:00:00', 19),
(87, '48649026', '04:45:00', '13:45:00', 3),
(88, '48714253', '08:00:00', '17:00:00', 13),
(89, '48855821', '12:00:00', '21:00:00', 16),
(90, '48903234', '08:00:00', '17:00:00', 13),
(91, '49038642', '06:00:00', '15:00:00', 9),
(92, '49139367', '06:00:00', '15:00:00', 9),
(93, '49173612', '08:00:00', '17:00:00', 13),
(94, '49304687', '06:30:00', '14:30:00', 11),
(95, '49313343', '04:45:00', '13:45:00', 3),
(96, '49325578', '08:00:00', '17:00:00', 13),
(97, '49436638', '08:00:00', '17:00:00', 13),
(98, '49578105', '05:15:00', '09:15:00', 7),
(99, '49783190', '04:45:00', '13:45:00', 3),
(100, '49936955', '08:00:00', '17:00:00', 13),
(101, '50006064', '04:45:00', '08:45:00', 4),
(102, '50156916', '08:00:00', '17:00:00', 13),
(103, '50167226', '08:00:00', '17:00:00', 13),
(104, '50195669', '08:00:00', '17:00:00', 13),
(105, '50416641', '04:45:00', '13:45:00', 3),
(106, '50517146', '11:00:00', '15:00:00', 15),
(107, '50778263', '08:00:00', '17:00:00', 13),
(108, '50810617', '08:00:00', '17:00:00', 13),
(109, '50845997', '12:30:00', '20:30:00', 18),
(110, '51131105', '11:00:00', '15:00:00', 15),
(111, '51197020', '17:00:00', '21:00:00', 22),
(112, '51208059', '06:00:00', '15:00:00', 9),
(113, '51281811', '04:45:00', '12:45:00', 2),
(114, '51340681', '04:45:00', '12:45:00', 2),
(115, '51389017', '08:00:00', '17:00:00', 13),
(116, '51568611', '13:00:00', '21:00:00', 19),
(117, '51665984', '13:00:00', '21:00:00', 19),
(118, '51696537', '04:45:00', '12:45:00', 2),
(119, '51886661', '08:00:00', '17:00:00', 13),
(120, '51961788', '08:00:00', '17:00:00', 13),
(121, '51982386', '04:45:00', '13:45:00', 3),
(122, '52009929', '17:15:00', '21:15:00', 23),
(123, '52024246', '11:00:00', '15:00:00', 15),
(124, '52080543', '06:00:00', '10:00:00', 10),
(125, '52111239', '04:45:00', '13:45:00', 3),
(126, '52145678', '08:00:00', '17:00:00', 13),
(127, '52297027', '12:00:00', '21:00:00', 16),
(128, '52307733', '08:00:00', '17:00:00', 13),
(129, '52370574', '04:45:00', '08:45:00', 4),
(130, '52568355', '04:45:00', '13:45:00', 3),
(131, '52585072', '06:00:00', '15:00:00', 9),
(132, '52694368', '12:00:00', '21:00:00', 16),
(133, '52784286', '08:00:00', '17:00:00', 13),
(134, '53117199', '08:00:00', '17:00:00', 13),
(135, '53200798', '17:15:00', '21:15:00', 23),
(136, '53376905', '08:00:00', '17:00:00', 13),
(137, '53533777', '08:00:00', '17:00:00', 13),
(138, '53638925', '08:00:00', '17:00:00', 13),
(139, '53672979', '04:45:00', '08:45:00', 4),
(140, '53861146', '08:00:00', '17:00:00', 13),
(141, '54045418', '04:45:00', '13:45:00', 3),
(142, '54534255', '08:00:00', '17:00:00', 13),
(143, '54568335', '08:00:00', '17:00:00', 13),
(144, '54669995', '08:00:00', '17:00:00', 13),
(145, '54799407', '08:00:00', '17:00:00', 13),
(146, '55034410', '17:15:00', '21:15:00', 23),
(147, '56171281', '08:00:00', '17:00:00', 13),
(148, '56814415', '08:00:00', '17:00:00', 13),
(149, '56818207', '17:15:00', '21:15:00', 23),
(150, '56956364', '08:00:00', '17:00:00', 13),
(151, '999999999', '07:00:00', '17:00:00', 1),
(152, '999999999', '07:00:00', '17:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pagos_empleados`
--

CREATE TABLE `pagos_empleados` (
  `idPagos_Empleados` int(11) NOT NULL,
  `Tipo_Pago` int(11) NOT NULL,
  `idRecibo` int(11) NOT NULL,
  `Desde` date NOT NULL,
  `Hasta` date NOT NULL,
  `Monto` double NOT NULL,
  `ISS` double NOT NULL,
  `AFP` double NOT NULL,
  `Renta` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16le;

--
-- Dumping data for table `pagos_empleados`
--

INSERT INTO `pagos_empleados` (`idPagos_Empleados`, `Tipo_Pago`, `idRecibo`, `Desde`, `Hasta`, `Monto`, `ISS`, `AFP`, `Renta`) VALUES
(3, 1, 4, '2017-02-09', '2017-02-15', 4.42, 0.13, 0.28, 0);

-- --------------------------------------------------------

--
-- Table structure for table `recibo`
--

CREATE TABLE `recibo` (
  `idRecibo` int(11) NOT NULL,
  `Fecha_Generado` datetime NOT NULL,
  `NumeroDocumento_Para` varchar(50) NOT NULL,
  `NumeroDocumento_Por` varchar(50) NOT NULL,
  `Vacacion` int(11) NOT NULL,
  `Indemnizacion` int(11) NOT NULL,
  `Aguinaldo` int(11) NOT NULL,
  `Salario` int(11) NOT NULL,
  `Retiro_Voluntario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16le;

--
-- Dumping data for table `recibo`
--

INSERT INTO `recibo` (`idRecibo`, `Fecha_Generado`, `NumeroDocumento_Para`, `NumeroDocumento_Por`, `Vacacion`, `Indemnizacion`, `Aguinaldo`, `Salario`, `Retiro_Voluntario`) VALUES
(4, '2017-02-18 12:04:17', '999999999', '999999999', 1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `renta`
--

CREATE TABLE `renta` (
  `id_renta` int(11) NOT NULL,
  `tipo_pago` int(11) NOT NULL,
  `nombre_tramo` varchar(150) NOT NULL,
  `Desde` double NOT NULL,
  `Hasta` float NOT NULL,
  `porcentaje_aplicar` float NOT NULL,
  `sobre_exceso` double NOT NULL,
  `Cuota_fija` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16le;

--
-- Dumping data for table `renta`
--

INSERT INTO `renta` (`id_renta`, `tipo_pago`, `nombre_tramo`, `Desde`, `Hasta`, `porcentaje_aplicar`, `sobre_exceso`, `Cuota_fija`) VALUES
(1, 1, 'I Tramo', 0.01, 472, 0, 0, 0),
(2, 1, 'II Tramo', 472.01, 895.24, 0.1, 472, 17.67),
(3, 1, 'III Tramo', 895.25, 2038.1, 0.2, 895.239990234375, 60),
(4, 1, 'IV Tramo', 2038.11, 0, 0.3, 2038.0999755859375, 288.57),
(5, 2, 'I Tramo', 0.01, 236, 0, 0, 0),
(6, 2, 'II Tramo', 236.01, 447.62, 0.1, 236, 8.83),
(7, 2, 'III Tramo', 447.63, 1019.05, 0.2, 447.6199951171875, 30),
(8, 2, 'IV Tramo', 1019.06, 0, 0.3, 1019.0499877929688, 144.28),
(9, 3, 'I Tramo', 0.01, 118, 0, 0, 0),
(10, 3, 'II Tramo', 118.01, 223.81, 0.1, 118, 4.42),
(11, 3, 'III Tramo', 223.82, 509.52, 0.2, 223.80999755859375, 15),
(12, 3, 'IV Tramo', 509.53, 0, 0.3, 509.5199890136719, 72.14),
(13, 4, 'I Tramo', 0.01, 2832, 0, 0, 0),
(14, 4, 'II Tramo', 2832.01, 5371.44, 0.1, 2832, 106.2),
(15, 4, 'III Tramo', 5371.45, 12228.6, 0.2, 5371.43994140625, 360),
(16, 4, 'IV Tramo', 12228.61, 0, 0.3, 12228.599609375, 1731.42),
(17, 5, 'I Tramo', 0.01, 5664, 0, 0, 0),
(18, 5, 'II Tramo', 5664.01, 10742.9, 0.1, 5664, 212.12),
(19, 5, 'III Tramo', 10742.87, 24457.1, 0.2, 10742.8603515625, 720),
(20, 5, 'IV Tramo', 24457.15, 0, 0.3, 24457.140625, 3462.86),
(21, 6, 'I Tramo', 0.01, 4064, 0, 0, 0),
(22, 6, 'II Tramo', 4064.01, 9142.86, 0.1, 4064, 212.12),
(23, 6, 'III Tramo', 9142.87, 22857.1, 0.2, 9142.8603515625, 720),
(24, 6, 'IV Tramo', 22857.15, 0, 0.3, 22857.140625, 3462.86);

-- --------------------------------------------------------

--
-- Table structure for table `salarios_minimos`
--

CREATE TABLE `salarios_minimos` (
  `idSalario_Minimo` int(11) NOT NULL,
  `NombreRubro` varchar(150) NOT NULL,
  `Salario_Dia` float NOT NULL,
  `Salario_Hora` float NOT NULL,
  `Salario_Mes` float NOT NULL,
  `Salario_Otro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16le;

--
-- Dumping data for table `salarios_minimos`
--

INSERT INTO `salarios_minimos` (`idSalario_Minimo`, `NombreRubro`, `Salario_Dia`, `Salario_Hora`, `Salario_Mes`, `Salario_Otro`) VALUES
(1, 'COMERCIO Y SERVICIOS', 10, 1.25, 300, 0),
(2, 'INDUSTRIA', 10, 1.25, 300, 0),
(3, 'INGENIOS AZUCAREROS', 10, 1.25, 300, 0),
(4, 'MAQUILA TEXTIL Y CONFECCION', 9.84, 1.23, 295.2, 0),
(5, 'TRABAJADORES AGROPECUARIOS', 6.67, 0.834, 200.1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `semanal`
--

CREATE TABLE `semanal` (
  `idSemanal` int(11) NOT NULL,
  `idTurno` int(11) NOT NULL,
  `NitEmpresa` varchar(14) NOT NULL,
  `nSemana` int(11) NOT NULL,
  `anno` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16le;

--
-- Dumping data for table `semanal`
--

INSERT INTO `semanal` (`idSemanal`, `idTurno`, `NitEmpresa`, `nSemana`, `anno`) VALUES
(1, 1, '222', 7, 2017);

-- --------------------------------------------------------

--
-- Table structure for table `turno`
--

CREATE TABLE `turno` (
  `idTurno` int(11) NOT NULL,
  `NitEmpresa` varchar(14) NOT NULL,
  `nombreTurno` varchar(150) NOT NULL,
  `Desde` varchar(150) NOT NULL,
  `Hasta` varchar(150) NOT NULL,
  `Descanso` int(11) NOT NULL,
  `H_Descanso` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16le;

--
-- Dumping data for table `turno`
--

INSERT INTO `turno` (`idTurno`, `NitEmpresa`, `nombreTurno`, `Desde`, `Hasta`, `Descanso`, `H_Descanso`) VALUES
(1, '222', 'T01', '04:45:00', '21:15:00', 1, '2:00'),
(2, '222', 'T02', '04:45:00', '12:45:00', 0, '0:00'),
(3, '222', 'T03', '04:45:00', '13:45:00', 1, '1:00'),
(4, '222', 'T04', '04:45:00', '08:45:00', 0, '0:00'),
(5, '222', 'T05', '05:00:00', '13:00:00', 0, '0:00'),
(6, '222', 'T06', '05:00:00', '14:00:00', 1, '1:00'),
(7, '222', 'T07', '05:15:00', '09:15:00', 0, '0:00'),
(8, '222', 'T08', '06:00:00', '14:00:00', 0, '0:00'),
(9, '222', 'T09', '06:00:00', '15:00:00', 1, '1:00'),
(10, '222', 'T10', '06:00:00', '10:00:00', 0, '0:00'),
(11, '222', 'T11', '06:30:00', '14:30:00', 0, '0:00'),
(12, '222', 'T12', '07:00:00', '15:00:00', 0, '0:00'),
(13, '222', 'T13', '08:00:00', '17:00:00', 1, '1:00'),
(14, '222', 'T14', '10:00:00', '18:00:00', 0, '0:00'),
(15, '222', 'T15', '11:00:00', '15:00:00', 0, '0:00'),
(16, '222', 'T16', '12:00:00', '21:00:00', 1, '1:00'),
(17, '222', 'T17', '12:15:00', '21:15:00', 1, '1:00'),
(18, '222', 'T18', '12:30:00', '20:30:00', 0, '0:00'),
(19, '222', 'T19', '13:00:00', '21:00:00', 0, '0:00'),
(20, '222', 'T20', '13:15:00', '21:15:00', 0, '0:00'),
(21, '222', 'T21', '17:00:00', '01:00:00', 0, '0:00'),
(22, '222', 'T22', '17:00:00', '21:00:00', 0, '0:00'),
(23, '222', 'T23', '17:15:00', '21:15:00', 0, '0:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cargos`
--
ALTER TABLE `cargos`
  ADD PRIMARY KEY (`idCargos`),
  ADD KEY `idDepartamento` (`idDepartamento`);

--
-- Indexes for table `cod_departamento`
--
ALTER TABLE `cod_departamento`
  ADD PRIMARY KEY (`idCod_Departamento`),
  ADD KEY `idCod_Pais` (`idCod_Pais`);

--
-- Indexes for table `cod_municipio`
--
ALTER TABLE `cod_municipio`
  ADD PRIMARY KEY (`idCod_Municipio`),
  ADD KEY `idCod_Departamento` (`idCod_Departamento`);

--
-- Indexes for table `cod_pais`
--
ALTER TABLE `cod_pais`
  ADD PRIMARY KEY (`idCod_Pais`);

--
-- Indexes for table `col_semanal`
--
ALTER TABLE `col_semanal`
  ADD PRIMARY KEY (`idCol_Semanal`),
  ADD KEY `idSemanal` (`idSemanal`),
  ADD KEY `NumeroDocumento` (`NumeroDocumento`),
  ADD KEY `NumeroDocumento_2` (`NumeroDocumento`);

--
-- Indexes for table `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`idDepartamento`),
  ADD KEY `NitEmpresa` (`NitEmpresa`),
  ADD KEY `salarios_minimos` (`idSalario_Minimo`),
  ADD KEY `idSalario_Minimo` (`idSalario_Minimo`);

--
-- Indexes for table `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`NumeroDocumento`),
  ADD KEY `idCargos` (`idCargos`);

--
-- Indexes for table `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`NitEmpresa`),
  ADD UNIQUE KEY `NitEmpresa_3` (`NitEmpresa`),
  ADD KEY `NitEmpresa` (`NitEmpresa`),
  ADD KEY `NitEmpresa_2` (`NitEmpresa`),
  ADD KEY `NitEmpresa_4` (`NitEmpresa`);

--
-- Indexes for table `htrabajo`
--
ALTER TABLE `htrabajo`
  ADD PRIMARY KEY (`idHTrabajo`),
  ADD KEY `NumeroDocumento` (`NumeroDocumento`),
  ADD KEY `idTurno` (`idTurno`);

--
-- Indexes for table `pagos_empleados`
--
ALTER TABLE `pagos_empleados`
  ADD PRIMARY KEY (`idPagos_Empleados`),
  ADD KEY `NumeroDocumento` (`idRecibo`);

--
-- Indexes for table `recibo`
--
ALTER TABLE `recibo`
  ADD PRIMARY KEY (`idRecibo`),
  ADD KEY `NumeroDocumento_Para` (`NumeroDocumento_Para`),
  ADD KEY `NumeroDocumento_Por` (`NumeroDocumento_Por`);

--
-- Indexes for table `renta`
--
ALTER TABLE `renta`
  ADD PRIMARY KEY (`id_renta`);

--
-- Indexes for table `salarios_minimos`
--
ALTER TABLE `salarios_minimos`
  ADD PRIMARY KEY (`idSalario_Minimo`);

--
-- Indexes for table `semanal`
--
ALTER TABLE `semanal`
  ADD PRIMARY KEY (`idSemanal`),
  ADD KEY `NitEmpresa_4` (`NitEmpresa`),
  ADD KEY `idTurno` (`idTurno`);

--
-- Indexes for table `turno`
--
ALTER TABLE `turno`
  ADD PRIMARY KEY (`idTurno`),
  ADD KEY `NitEmpresa` (`NitEmpresa`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cargos`
--
ALTER TABLE `cargos`
  MODIFY `idCargos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `col_semanal`
--
ALTER TABLE `col_semanal`
  MODIFY `idCol_Semanal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `departamento`
--
ALTER TABLE `departamento`
  MODIFY `idDepartamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `htrabajo`
--
ALTER TABLE `htrabajo`
  MODIFY `idHTrabajo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;
--
-- AUTO_INCREMENT for table `pagos_empleados`
--
ALTER TABLE `pagos_empleados`
  MODIFY `idPagos_Empleados` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `recibo`
--
ALTER TABLE `recibo`
  MODIFY `idRecibo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `renta`
--
ALTER TABLE `renta`
  MODIFY `id_renta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `salarios_minimos`
--
ALTER TABLE `salarios_minimos`
  MODIFY `idSalario_Minimo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `semanal`
--
ALTER TABLE `semanal`
  MODIFY `idSemanal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `turno`
--
ALTER TABLE `turno`
  MODIFY `idTurno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `cargos`
--
ALTER TABLE `cargos`
  ADD CONSTRAINT `FK_3C3760F61E7A331A` FOREIGN KEY (`idDepartamento`) REFERENCES `departamento` (`idDepartamento`);

--
-- Constraints for table `cod_departamento`
--
ALTER TABLE `cod_departamento`
  ADD CONSTRAINT `cod_departamento_ibfk_1` FOREIGN KEY (`idCod_Pais`) REFERENCES `cod_pais` (`idCod_Pais`);

--
-- Constraints for table `cod_municipio`
--
ALTER TABLE `cod_municipio`
  ADD CONSTRAINT `cod_municipio_ibfk_1` FOREIGN KEY (`idCod_Departamento`) REFERENCES `cod_departamento` (`idCod_Departamento`);

--
-- Constraints for table `col_semanal`
--
ALTER TABLE `col_semanal`
  ADD CONSTRAINT `col_semanal_ibfk_1` FOREIGN KEY (`idSemanal`) REFERENCES `semanal` (`idSemanal`) ON UPDATE CASCADE,
  ADD CONSTRAINT `col_semanal_ibfk_2` FOREIGN KEY (`NumeroDocumento`) REFERENCES `empleado` (`NumeroDocumento`) ON UPDATE CASCADE;

--
-- Constraints for table `departamento`
--
ALTER TABLE `departamento`
  ADD CONSTRAINT `FK_40E497EB51254B42` FOREIGN KEY (`NitEmpresa`) REFERENCES `empresa` (`NitEmpresa`),
  ADD CONSTRAINT `departamento_ibfk_1` FOREIGN KEY (`idSalario_Minimo`) REFERENCES `salarios_minimos` (`idSalario_Minimo`);

--
-- Constraints for table `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `empleado_ibfk_1` FOREIGN KEY (`idCargos`) REFERENCES `cargos` (`idCargos`);

--
-- Constraints for table `pagos_empleados`
--
ALTER TABLE `pagos_empleados`
  ADD CONSTRAINT `FK_R_PE` FOREIGN KEY (`idRecibo`) REFERENCES `recibo` (`idRecibo`) ON UPDATE CASCADE;

--
-- Constraints for table `recibo`
--
ALTER TABLE `recibo`
  ADD CONSTRAINT `FK_1_RECIBO` FOREIGN KEY (`NumeroDocumento_Para`) REFERENCES `empleado` (`NumeroDocumento`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_2_RECIBO` FOREIGN KEY (`NumeroDocumento_Por`) REFERENCES `empleado` (`NumeroDocumento`) ON UPDATE CASCADE;

--
-- Constraints for table `semanal`
--
ALTER TABLE `semanal`
  ADD CONSTRAINT `semanal_ibfk_1` FOREIGN KEY (`NitEmpresa`) REFERENCES `empresa` (`NitEmpresa`),
  ADD CONSTRAINT `semanal_ibfk_2` FOREIGN KEY (`idTurno`) REFERENCES `turno` (`idTurno`);

--
-- Constraints for table `turno`
--
ALTER TABLE `turno`
  ADD CONSTRAINT `turno_ibfk_1` FOREIGN KEY (`NitEmpresa`) REFERENCES `empresa` (`NitEmpresa`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
