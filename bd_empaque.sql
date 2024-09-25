-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-09-2024 a las 21:16:21
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_empaque`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

CREATE TABLE `asistencia` (
  `num_empleado` varchar(100) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `fecha` varchar(100) NOT NULL,
  `hora_entrada` varchar(100) NOT NULL,
  `hora_salida` varchar(100) NOT NULL,
  `semana` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asistencia`
--

INSERT INTO `asistencia` (`num_empleado`, `nombre_completo`, `fecha`, `hora_entrada`, `hora_salida`, `semana`) VALUES
('dswd', 'dw', '2024-03-07', '12:52:01', '12:51:37', '10'),
('0709', 'Eren Jeager', '2024-03-07', '15:45:07', '15:48:41', '10'),
('fdg', 'gfdg', '2024-03-07', '16:00:12', '', '10'),
('0709', 'Eren Jeager', '2024-03-08', '08:36:55', '08:36:56', '10'),
('fdg', 'gfdg', '2024-03-08', '12:26:44', '12:26:48', '10'),
('0709', 'Eren Jeager', '2024-03-11', '09:07:08', '09:07:12', '11'),
('U-43', 'Mickasa Ackerman', '2024-03-11', '14:03:30', '14:03:32', '11'),
('0709', 'Eren Jeager', '2024-04-01', '09:57:37', '10:30:04', '14'),
('U-42', 'Eren Jeager', '2024-04-02', '07:40:54', '07:40:57', '14'),
('U-43', '', '', 'PERMISO CON GOCE', 'PERMISO CON GOCE', ''),
('U-43', 'Mickasa Ackerman', '2024-04-02', 'FALTA', 'FALTA', '14'),
('U-43', 'Mickasa Ackerman', '2024-04-02', 'PERMISO CON GOCE', 'PERMISO CON GOCE', '14'),
('U-43', 'Mickasa Ackerman', '2024-04-02', 'INCAPACIDAD', 'INCAPACIDAD', '14'),
('U-43', 'Mickasa Ackerman', '2024-04-02', 'PERMISO SIN GOCE', 'PERMISO SIN GOCE', '14'),
('U-42', 'Eren Jeager', '2024-04-03', '07:58:17', '07:59:31', '14'),
('U-43', 'Mickasa Ackerman', '2024-04-03', 'VACACIONES', 'VACACIONES', '14'),
('U-42', 'Eren Jeager', '2024-04-05', '09:27:25', '09:27:27', '14'),
('U-43', 'Mickasa Ackerman', '2024-04-05', 'PERMISO SIN GOCE', 'PERMISO SIN GOCE', '14'),
('U-43', 'Mickasa Ackerman', '2024-04-10', 'PERMISO SIN GOCE', 'PERMISO SIN GOCE', '15'),
('U-42', 'Eren Jeager', '2024-04-10', '14:29:23', '14:29:24', '15'),
('U-44', 'Armin Arlert', '2024-04-10', '14:29:59', '14:31:12', '15'),
('U-42', 'Eren Jeager', '2024-04-11', '07:59:27', '07:59:28', '15'),
('U-43', 'Mickasa Ackerman', '2024-04-11', 'PERMISO SIN GOCE', 'PERMISO SIN GOCE', '15'),
('U-42', 'Eren Jeager', '2024-04-12', '16:01:47', '16:01:50', '15'),
('U-43', 'Mickasa Ackerman', '2024-04-12', 'VACACIONES', 'VACACIONES', '15'),
('U-43', 'Mickasa Ackerman', '2024-04-12', 'VACACIONES', 'VACACIONES', '15'),
('U-44', 'Armin Arlert', '2024-04-12', 'PERMISO CON GOCE', 'PERMISO CON GOCE', '15'),
('U-43', 'Mickasa Ackerman', '2024-04-16', '14:18:30', '14:18:33', '16'),
('U-42', 'Eren Jeager', '2024-04-16', '14:21:14', '', '16'),
('U-44', 'Armin Arlert', '2024-04-16', '14:21:55', '', '16'),
('20071', 'TREJO HERNANDEZ SOFIA', '2024-07-17', '07:03:34', '', '29'),
('20140', 'NIEVES HERNANDEZ MARIA ISABEL', '2024-07-17', '07:41:31', '', '29'),
('20071', 'TREJO HERNANDEZ SOFIA', '2024-08-08', '15:34:04', '15:34:09', '32'),
('20071', 'TREJO HERNANDEZ SOFIA', '2024-08-12', '10:13:52', '10:13:57', '33'),
('20071', 'TREJO HERNANDEZ SOFIA', '2024-08-27', 'VACACIONES', 'VACACIONES', '35'),
('20071', 'TREJO HERNANDEZ SOFIA', '2024-08-27', 'VACACIONES', 'VACACIONES', '35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja_bola`
--

CREATE TABLE `caja_bola` (
  `tipo_caja` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `caja_bola`
--

INSERT INTO `caja_bola` (`tipo_caja`) VALUES
('15 Lb'),
('Clam de 6pz'),
('12x1.5 Lb'),
('Nacional 10 Kg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja_racimo`
--

CREATE TABLE `caja_racimo` (
  `tipo_caja` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `caja_racimo`
--

INSERT INTO `caja_racimo` (`tipo_caja`) VALUES
('11 lb'),
('4 Lb Ns Costco'),
('4 Lb Ns Sam\'s'),
('8x1.5 Lb Ns'),
('Nacional 11Kg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja_racimo_org`
--

CREATE TABLE `caja_racimo_org` (
  `tipo_caja` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `caja_racimo_org`
--

INSERT INTO `caja_racimo_org` (`tipo_caja`) VALUES
('11 lb'),
('4 Lb Ns Costco'),
('4 Lb Ns Sam\'s'),
('8x1.5 Lb Ns'),
('Nacional 11Kg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `captura_dia`
--

CREATE TABLE `captura_dia` (
  `num_empleado` varchar(200) NOT NULL,
  `nombre_completo` varchar(300) NOT NULL,
  `fecha` varchar(150) NOT NULL,
  `semana` varchar(100) NOT NULL,
  `tipo_caja` varchar(100) NOT NULL,
  `cantidad` varchar(100) NOT NULL,
  `linea` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `num_empleado` varchar(50) NOT NULL,
  `nombre_completo` varchar(50) NOT NULL,
  `jefe_directo` varchar(50) NOT NULL,
  `area` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`num_empleado`, `nombre_completo`, `jefe_directo`, `area`) VALUES
('20071', 'TREJO HERNANDEZ SOFIA', 'Default', 'Línea Bola'),
('20140', 'NIEVES HERNANDEZ MARIA ISABEL', 'Default', 'Linea Racimo'),
('20164', 'TREJO HERNANDEZ MARGARITA', 'Default', 'Línea Bola'),
('20595', 'MAQUEDA HERNANDEZ SUSANA', 'Default', 'Línea Bola'),
('20615', 'HERNANDEZ HERNANDEZ MARICELA', 'Default', 'Línea Racimo'),
('20713', 'BARRERA LOPEZ PATRICIA', 'Default', 'Línea Racimo'),
('21008', 'REYES CHINDO TERESA', 'Default', 'Línea Bola'),
('21642', 'DE LEON RESENDIZ VICTOR MANUEL', 'Default', 'Abastecimientos'),
('22045', 'BARRERA LOPEZ ANA KAREN', 'Default', 'Línea Bola'),
('22158', 'RESENDIZ SANCHEZ FABIOLA', 'Default', 'Capitana Bola'),
('22549', 'ARTEAGA VARGAS JOSE GERARDO', 'Default', 'Captan Cuarto Frio'),
('22592', 'NIEVES NIEVES ESTELA', 'Default', 'Línea Racimo'),
('22787', 'LOPEZ HERNANDEZ JOSE GUADALUPE', 'Default', 'Supervisor '),
('22829', 'RESENDIZ HERNANDEZ ANA KAREN', 'Default', 'Línea Racimo'),
('22948', 'HERNANDEZ MARTINEZ MA. FRANCISCA', 'Default', 'Línea Bola'),
('23161', 'HERNANDEZ RAMOS ARTURO', 'Default', 'Abastecimientos'),
('23410', 'RINCON SANCHEZ LUIS ALFREDO', 'Default', 'Capitan abastecimeitno'),
('23663', 'HERNANDEZ LOPEZ ANGELICA', 'Default', 'Línea Racimo'),
('23673', 'RESENDIZ HERNANDEZ MARIA CECILIA', 'Default', 'Línea Racimo'),
('23890', 'GOMEZ LIRA ANGEL ADOLFO', 'Default', 'Cuarto Frio'),
('23986', 'SALINAS MAQUEDA JOSE JUAN', 'Default', 'Cuarto Frio'),
('23991', 'TREJO HERNANDEZ MARIELA', 'Default', 'Línea Bola'),
('24141', 'HERNANDEZ ENGAVI ELIZABETH', 'Default', 'Línea Racimo'),
('24324', 'ZARRAGA RESENDIZ JOSE ADRIAN', 'Default', 'Abastecimientos'),
('24380', 'RESENDIZ MORALES ERICK', 'Default', 'Cuarto Frio'),
('24500', 'DE LEON HERNANDEZ ANA KAREN', 'Default', 'Capitana Bola'),
('24659', 'HERNANDEZ ZARRAGA LUZ CLARITA', 'Default', 'Línea Bola'),
('24694', 'ANGELES GUTIERREZ MARIA MIRIAM', 'Default', 'Línea Bola'),
('24717', 'LOPEZ NIEVES ANGELICA', 'Default', 'Aux de Empaque'),
('24760', 'HERNANDEZ HERNANDEZ JENNIFER CAROLINA', 'Default', 'Calidad'),
('24872', 'SALINAS MAQUEDA JOSE MIGUEL', 'Default', 'Cuarto Frio'),
('24938', 'RESENDIZ HERNANDEZ LUCIA JULIETA', 'Default', 'Línea Bola'),
('25223', 'RESENDIZ HERNANDEZ DANIELA', 'Default', 'Línea Racimo'),
('25329', 'MORENO CORNELIO FERNANDA', 'Default', 'Línea Racimo'),
('25350', 'BARRERA MARTINEZ JOSE FRANCISCO', 'Default', 'Cuarto Frio'),
('25356', 'IBARRA DE SANTIAGO JULIO CESAR', 'Default', 'Cuarto Frio'),
('25381', 'GALLEGOS MORALES MARIA BELEN', 'Default', 'Línea Bola'),
('25403', 'TREJO HERNANDEZ FIDEL ANGEL', 'Default', 'Abastecimientos'),
('25435', 'SANCHEZ ARTEAGA MARTIN', 'Default', 'Abastecimientos'),
('25592', 'SALINAS CASAS MARY CARMEN', 'Default', 'Aux'),
('25600', 'MARTINEZ RESENDIZ MARIA DE LA CRUZ', 'Default', 'Línea Racimo'),
('25642', 'RESENDIZ SANCHEZ ISAURA JUDITH', 'Default', 'Línea Racimo'),
('25763', 'DE SANTIAGO DE SANTIAGO MONTSERRAT ESTEFANIA', 'Default', 'Línea Bola'),
('25772', 'GONZALEZ MARTINEZ VIRGINIA', 'Default', 'Línea Bola'),
('25773', 'SANCHEZ GONZALEZ PATRICIO', 'Default', 'Abastecimientos'),
('25784', 'MARTINEZ GUDI?O LAURA', 'Default', 'Línea Bola'),
('25795', 'LUNA PEREZ CATALINA', 'Default', 'Línea Bola'),
('25846', 'GUILLERMO HERNANDEZ CAMACHO', 'Default', 'Abastecimientos'),
('23329', 'PEREZ MARTINEZ DIEGA', 'Default', 'Línea Bola'),
('25854', 'DE SANTIAGO GUDI?O MA.LUISA', 'Default', 'Línea Bola'),
('25855', 'RESENDIZ MARTINEZ MARIA GUADALUPE', 'Default', 'Línea Bola'),
('25857', 'ARACELI RESENDIZ RESENDIZ', 'Default', 'Línea Bola'),
('25527', 'JOSE MIGUEL PACHECO CASTILLO', 'Default', 'Abastecimientos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invitado`
--

CREATE TABLE `invitado` (
  `usuario` varchar(500) NOT NULL,
  `password` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `invitado`
--

INSERT INTO `invitado` (`usuario`, `password`) VALUES
('invitado', 'invitado123');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ip_permitidas`
--

CREATE TABLE `ip_permitidas` (
  `ip` varchar(500) NOT NULL,
  `nombre` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ip_permitidas`
--

INSERT INTO `ip_permitidas` (`ip`, `nombre`) VALUES
('10.36.6.47', 'Eren'),
('10.36.6.135', 'Jesse'),
('10.36.5.86', 'Jesse Laptop');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_entrada`
--

CREATE TABLE `registro_entrada` (
  `num_empleado` varchar(100) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `fecha` varchar(100) NOT NULL,
  `hora_entrada` varchar(50) NOT NULL,
  `semana` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `registro_entrada`
--

INSERT INTO `registro_entrada` (`num_empleado`, `nombre_completo`, `fecha`, `hora_entrada`, `semana`) VALUES
('0709', '', '2024-03-27', '15:37:21', '13'),
('U-43', 'Mickasa Ackerman', '2024-03-26', '11:51:30', '13'),
('dswd', 'dw', '2024-03-08', '12:16:30', '10'),
('fdg', 'gfdg', '2024-03-08', '15:15:26', '10'),
('U-42', 'Eren Jeager', '2024-04-24', '14:45:09', '17'),
('20140', 'NIEVES HERNANDEZ MARIA ISABEL', '2024-08-12', '10:28:35', '33'),
('20071', 'TREJO HERNANDEZ SOFIA', '2024-08-27', '10:23:41', '35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_salida`
--

CREATE TABLE `registro_salida` (
  `num_empleado` varchar(100) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `fecha` varchar(100) NOT NULL,
  `hora_salida` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `registro_salida`
--

INSERT INTO `registro_salida` (`num_empleado`, `nombre_completo`, `fecha`, `hora_salida`) VALUES
('0709', '', '2024-03-27', '15:37:21'),
('U-43', 'Mickasa Ackerman', '2024-03-26', '11:51:39'),
('dswd', 'dw', '2024-03-08', '12:16:31'),
('fdg', 'gfdg', '2024-03-08', '15:15:27'),
('U-42', 'Eren Jeager', '2024-04-24', '14:45:11'),
('20140', 'NIEVES HERNANDEZ MARIA ISABEL', '2024-08-12', '10:28:37'),
('20071', 'TREJO HERNANDEZ SOFIA', '2024-08-12', '10:18:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_trabajo`
--

CREATE TABLE `registro_trabajo` (
  `num_empleado` varchar(50) NOT NULL,
  `nombre_completo` varchar(50) NOT NULL,
  `fecha` varchar(50) NOT NULL,
  `semana` varchar(50) NOT NULL,
  `tarea_inicio` varchar(50) NOT NULL,
  `tarea_terminada` varchar(50) NOT NULL,
  `tipo_caja` varchar(50) NOT NULL,
  `cantidad` int(50) NOT NULL,
  `linea` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `registro_trabajo`
--

INSERT INTO `registro_trabajo` (`num_empleado`, `nombre_completo`, `fecha`, `semana`, `tarea_inicio`, `tarea_terminada`, `tipo_caja`, `cantidad`, `linea`) VALUES
('0709', 'Eren Jeager', '2024-03-22', '12', '15:40:22', '15:40:22', '11 lb', 0, 'Línea Racimo'),
('0709', 'Eren Jeager', '2024-03-22', '12', '15:40:22', '15:40:22', '4 Lb Ns Costco', 0, 'Línea Racimo'),
('0709', 'Eren Jeager', '2024-03-22', '12', '15:40:22', '15:40:22', '8x1.5 Lb Ns', 0, 'Línea Racimo'),
('0709', 'Eren Jeager', '2024-03-22', '12', '15:40:22', '15:40:22', 'Nacional 11Kg', 0, 'Línea Racimo'),
('0709', 'Eren Jeager', '2024-03-26', '13', '11:42:13', '11:42:13', '15 Lb', 1, 'Línea Bola'),
('0709', 'Eren Jeager', '2024-03-26', '13', '11:42:13', '11:42:13', 'Clam de 6pz', 1, 'Línea Bola'),
('0709', 'Eren Jeager', '2024-03-26', '13', '11:42:13', '11:42:13', '12x1.5 Lb', 1, 'Línea Bola'),
('0709', 'Eren Jeager', '2024-03-26', '13', '11:42:13', '11:42:13', 'Nacional 10 Kg', 1, 'Línea Bola'),
('0709', 'Eren Jeager', '2024-03-26', '13', '11:42:38', '11:42:38', '11 lb', 1, 'Línea Racimo'),
('0709', 'Eren Jeager', '2024-03-26', '13', '11:42:38', '11:42:38', '4 Lb Ns Costco', 1, 'Línea Racimo'),
('0709', 'Eren Jeager', '2024-03-26', '13', '11:42:38', '11:42:38', '8x1.5 Lb Ns', 1, 'Línea Racimo'),
('0709', 'Eren Jeager', '2024-03-26', '13', '11:42:38', '11:42:38', 'Nacional 11Kg', 1, 'Línea Racimo'),
('0709', 'Eren Jeager', '2024-03-26', '13', '11:42:52', '11:42:52', '11 lb', 1, 'Línea Racimo Org'),
('0709', 'Eren Jeager', '2024-03-26', '13', '11:42:52', '11:42:52', '4 Lb Ns Costco', 1, 'Línea Racimo Org'),
('0709', 'Eren Jeager', '2024-03-26', '13', '11:42:52', '11:42:52', '8x1.5 Lb Ns', 1, 'Línea Racimo Org'),
('0709', 'Eren Jeager', '2024-03-26', '13', '11:42:52', '11:42:52', 'Nacional 11Kg', 1, 'Línea Racimo Org'),
('0709', 'Eren Jeager', '2024-03-26', '13', '11:44:40', '11:44:40', '15 Lb', 1, 'Línea Bola'),
('0709', 'Eren Jeager', '2024-03-26', '13', '11:44:40', '11:44:40', 'Clam de 6pz', 1, 'Línea Bola'),
('0709', 'Eren Jeager', '2024-03-26', '13', '11:44:40', '11:44:40', '12x1.5 Lb', 1, 'Línea Bola'),
('0709', 'Eren Jeager', '2024-03-26', '13', '11:44:40', '11:44:40', 'Nacional 10 Kg', 1, 'Línea Bola'),
('U-43', 'Mickasa Ackerman', '2024-03-26', '13', '11:51:21', '11:51:21', '15 Lb', 1, 'Línea Bola'),
('U-43', 'Mickasa Ackerman', '2024-03-26', '13', '11:51:21', '11:51:21', 'Clam de 6pz', 1, 'Línea Bola'),
('U-43', 'Mickasa Ackerman', '2024-03-26', '13', '11:51:21', '11:51:21', '12x1.5 Lb', 1, 'Línea Bola'),
('U-43', 'Mickasa Ackerman', '2024-03-26', '13', '11:51:21', '11:51:21', 'Nacional 10 Kg', 1, 'Línea Bola'),
('U-43', 'Mickasa Ackerman', '2024-03-26', '13', '11:51:44', '11:51:44', '11 lb', 1, 'Línea Racimo'),
('U-43', 'Mickasa Ackerman', '2024-03-26', '13', '11:51:44', '11:51:44', '4 Lb Ns Costco', 1, 'Línea Racimo'),
('U-43', 'Mickasa Ackerman', '2024-03-26', '13', '11:51:44', '11:51:44', '8x1.5 Lb Ns', 1, 'Línea Racimo'),
('U-43', 'Mickasa Ackerman', '2024-03-26', '13', '11:51:44', '11:51:44', 'Nacional 11Kg', 1, 'Línea Racimo'),
('U-43', 'Mickasa Ackerman', '2024-03-26', '13', '11:52:00', '11:52:00', '11 lb', 1, 'Línea Racimo Org'),
('U-43', 'Mickasa Ackerman', '2024-03-26', '13', '11:52:00', '11:52:00', '4 Lb Ns Costco', 1, 'Línea Racimo Org'),
('U-43', 'Mickasa Ackerman', '2024-03-26', '13', '11:52:00', '11:52:00', '8x1.5 Lb Ns', 1, 'Línea Racimo Org'),
('U-43', 'Mickasa Ackerman', '2024-03-26', '13', '11:52:00', '11:52:00', 'Nacional 11Kg', 1, 'Línea Racimo Org'),
('0709', 'Eren Jeager', '2024-03-27', '13', '15:37:25', '15:37:25', '15 Lb', 1, 'Línea Bola'),
('0709', 'Eren Jeager', '2024-03-27', '13', '15:37:25', '15:37:25', 'Clam de 6pz', 1, 'Línea Bola'),
('0709', 'Eren Jeager', '2024-03-27', '13', '15:37:25', '15:37:25', '12x1.5 Lb', 1, 'Línea Bola'),
('0709', 'Eren Jeager', '2024-03-27', '13', '15:37:25', '15:37:25', 'Nacional 10 Kg', 1, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-02', '14', '09:26:25', '09:26:25', '15 Lb', 1, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-02', '14', '09:26:25', '09:26:25', 'Clam de 6pz', 1, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-02', '14', '09:26:25', '09:26:25', '12x1.5 Lb', 1, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-02', '14', '09:26:25', '09:26:25', 'Nacional 10 Kg', 1, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-02', '14', '09:26:48', '09:26:48', '11 lb', 1, 'Línea Racimo'),
('U-42', 'Eren Jeager', '2024-04-02', '14', '09:26:48', '09:26:48', '4 Lb Ns Costco', 1, 'Línea Racimo'),
('U-42', 'Eren Jeager', '2024-04-02', '14', '09:26:48', '09:26:48', '8x1.5 Lb Ns', 1, 'Línea Racimo'),
('U-42', 'Eren Jeager', '2024-04-02', '14', '09:26:48', '09:26:48', 'Nacional 11Kg', 1, 'Línea Racimo'),
('U-42', 'Eren Jeager', '2024-04-03', '14', '08:23:18', '08:23:18', '15 Lb', 1, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-03', '14', '08:23:18', '08:23:18', 'Clam de 6pz', 1, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-03', '14', '08:23:18', '08:23:18', '12x1.5 Lb', 1, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-03', '14', '08:23:18', '08:23:18', 'Nacional 10 Kg', 1, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-03', '14', '08:27:46', '08:27:46', '11 lb', 1, 'Línea Racimo'),
('U-42', 'Eren Jeager', '2024-04-03', '14', '08:27:46', '08:27:46', '4 Lb Ns Costco', 1, 'Línea Racimo'),
('U-42', 'Eren Jeager', '2024-04-03', '14', '08:27:46', '08:27:46', '8x1.5 Lb Ns', 0, 'Línea Racimo'),
('U-42', 'Eren Jeager', '2024-04-03', '14', '08:27:46', '08:27:46', 'Nacional 11Kg', 0, 'Línea Racimo'),
('U-42', 'Eren Jeager', '2024-04-03', '14', '09:35:25', '09:35:25', '11 lb', 1, 'Línea Racimo'),
('U-42', 'Eren Jeager', '2024-04-03', '14', '09:35:25', '09:35:25', '4 Lb Ns Costco', 1, 'Línea Racimo'),
('U-42', 'Eren Jeager', '2024-04-03', '14', '09:35:25', '09:35:25', '8x1.5 Lb Ns', 0, 'Línea Racimo'),
('U-42', 'Eren Jeager', '2024-04-03', '14', '09:35:25', '09:35:25', 'Nacional 11Kg', 0, 'Línea Racimo'),
('U-42', 'Eren Jeager', '2024-04-05', '14', '10:19:53', '10:19:53', '15 Lb', 1, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-05', '14', '10:19:53', '10:19:53', 'Clam de 6pz', 1, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-05', '14', '10:19:53', '10:19:53', '12x1.5 Lb', 1, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-05', '14', '10:19:53', '10:19:53', 'Nacional 10 Kg', 1, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-05', '14', '10:21:02', '10:21:02', '15 Lb', 1, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-05', '14', '10:21:02', '10:21:02', 'Clam de 6pz', 1, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-05', '14', '10:21:02', '10:21:02', '12x1.5 Lb', 1, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-05', '14', '10:21:02', '10:21:02', 'Nacional 10 Kg', 1, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-10', '15', '14:24:58', '14:24:58', '15 Lb', 1, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-10', '15', '14:24:58', '14:24:58', 'Clam de 6pz', 1, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-10', '15', '14:24:58', '14:24:58', '12x1.5 Lb', 1, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-10', '15', '14:24:58', '14:24:58', 'Nacional 10 Kg', 1, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-10', '15', '14:26:04', '14:26:04', '11 lb', 1, 'Línea Racimo'),
('U-42', 'Eren Jeager', '2024-04-10', '15', '14:26:04', '14:26:04', '4 Lb Ns Costco', 1, 'Línea Racimo'),
('U-42', 'Eren Jeager', '2024-04-10', '15', '14:26:04', '14:26:04', '8x1.5 Lb Ns', 1, 'Línea Racimo'),
('U-42', 'Eren Jeager', '2024-04-10', '15', '14:26:04', '14:26:04', 'Nacional 11Kg', 1, 'Línea Racimo'),
('U-42', 'Eren Jeager', '2024-04-10', '15', '14:26:30', '14:26:30', '15 Lb', 1, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-10', '15', '14:26:30', '14:26:30', 'Clam de 6pz', 1, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-10', '15', '14:26:30', '14:26:30', '12x1.5 Lb', 1, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-10', '15', '14:26:30', '14:26:30', 'Nacional 10 Kg', 1, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-10', '15', '14:50:16', '14:50:16', '15 Lb', 1, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-10', '15', '14:50:16', '14:50:16', 'Clam de 6pz', 1, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-10', '15', '14:50:16', '14:50:16', '12x1.5 Lb', 1, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-10', '15', '14:50:16', '14:50:16', 'Nacional 10 Kg', 1, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-11', '15', '07:59:21', '07:59:21', '11 lb', 1, 'Línea Racimo'),
('U-42', 'Eren Jeager', '2024-04-11', '15', '07:59:21', '07:59:21', '4 Lb Ns Costco', 1, 'Línea Racimo'),
('U-42', 'Eren Jeager', '2024-04-11', '15', '07:59:21', '07:59:21', '8x1.5 Lb Ns', 1, 'Línea Racimo'),
('U-42', 'Eren Jeager', '2024-04-11', '15', '07:59:21', '07:59:21', 'Nacional 11Kg', 1, 'Línea Racimo'),
('U-42', 'Eren Jeager', '2024-04-16', '16', '09:14:32', '09:14:32', '15 Lb', 8, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-16', '16', '09:14:32', '09:14:32', 'Clam de 6pz', 3, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-16', '16', '09:14:32', '09:14:32', '12x1.5 Lb', 2, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-16', '16', '09:14:32', '09:14:32', 'Nacional 10 Kg', 0, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-24', '17', '14:45:02', '14:45:02', '15 Lb', 2, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-24', '17', '14:45:02', '14:45:02', 'Clam de 6pz', 4, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-24', '17', '14:45:02', '14:45:02', '12x1.5 Lb', 1, 'Línea Bola'),
('U-42', 'Eren Jeager', '2024-04-24', '17', '14:45:02', '14:45:02', 'Nacional 10 Kg', 0, 'Línea Bola'),
('20140', 'NIEVES HERNANDEZ MARIA ISABEL', '2024-07-17', '29', '07:46:32', '07:46:32', '15 Lb', 3, 'Línea Bola'),
('20140', 'NIEVES HERNANDEZ MARIA ISABEL', '2024-07-17', '29', '07:46:32', '07:46:32', 'Clam de 6pz', 3, 'Línea Bola'),
('20140', 'NIEVES HERNANDEZ MARIA ISABEL', '2024-07-17', '29', '07:46:32', '07:46:32', '12x1.5 Lb', 2, 'Línea Bola'),
('20140', 'NIEVES HERNANDEZ MARIA ISABEL', '2024-07-17', '29', '07:46:32', '07:46:32', 'Nacional 10 Kg', 1, 'Línea Bola'),
('20071', 'TREJO HERNANDEZ SOFIA', '2024-08-12', '33', '10:18:33', '10:18:33', '15 Lb', 5, 'Línea Bola'),
('20071', 'TREJO HERNANDEZ SOFIA', '2024-08-12', '33', '10:18:33', '10:18:33', 'Clam de 6pz', 10, 'Línea Bola'),
('20071', 'TREJO HERNANDEZ SOFIA', '2024-08-12', '33', '10:18:33', '10:18:33', '12x1.5 Lb', 11, 'Línea Bola'),
('20071', 'TREJO HERNANDEZ SOFIA', '2024-08-12', '33', '10:18:33', '10:18:33', 'Nacional 10 Kg', 4, 'Línea Bola'),
('20140', 'NIEVES HERNANDEZ MARIA ISABEL', '2024-08-12', '33', '10:29:04', '10:29:04', '11 lb', 4, 'Línea Racimo'),
('20140', 'NIEVES HERNANDEZ MARIA ISABEL', '2024-08-12', '33', '10:29:04', '10:29:04', '4 Lb Ns Costco', 3, 'Línea Racimo'),
('20140', 'NIEVES HERNANDEZ MARIA ISABEL', '2024-08-12', '33', '10:29:04', '10:29:04', '8x1.5 Lb Ns', 4, 'Línea Racimo'),
('20140', 'NIEVES HERNANDEZ MARIA ISABEL', '2024-08-12', '33', '10:29:04', '10:29:04', 'Nacional 11Kg', 5, 'Línea Racimo'),
('20071', 'TREJO HERNANDEZ SOFIA', '2024-08-27', '35', '10:24:01', '10:24:01', '15 Lb', 2, 'Línea Bola'),
('20071', 'TREJO HERNANDEZ SOFIA', '2024-08-27', '35', '10:24:01', '10:24:01', 'Clam de 6pz', 3, 'Línea Bola'),
('20071', 'TREJO HERNANDEZ SOFIA', '2024-08-27', '35', '10:24:01', '10:24:01', '12x1.5 Lb', 8, 'Línea Bola'),
('20071', 'TREJO HERNANDEZ SOFIA', '2024-08-27', '35', '10:24:01', '10:24:01', 'Nacional 10 Kg', 10, 'Línea Bola');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesion`
--

CREATE TABLE `sesion` (
  `password` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sesion`
--

INSERT INTO `sesion` (`password`) VALUES
('agros123'),
('eren123');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_cajas`
--

CREATE TABLE `tipo_cajas` (
  `tipo_caja` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_cajas`
--

INSERT INTO `tipo_cajas` (`tipo_caja`) VALUES
('15 Lb'),
('Clam de 6pz'),
('12x1.5 Lb'),
('Nacional 10 Kg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usuario`, `password`) VALUES
('administrador', '12345'),
('admin\r\n', '827ccb0eea8a706c4c34a16891f84e7b'),
('admin', 'admin123');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD KEY `num_empleado` (`num_empleado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
