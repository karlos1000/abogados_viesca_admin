-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-12-2020 a las 02:14:52
-- Versión del servidor: 5.7.17
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `abogadosviesca_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accion_gastos`
--

CREATE TABLE `accion_gastos` (
  `idGasto` int(11) NOT NULL,
  `casoId` int(11) DEFAULT NULL COMMENT 'identificador del caso',
  `accionId` int(11) DEFAULT NULL COMMENT 'identificador de la accion',
  `conceptoId` int(11) DEFAULT NULL COMMENT 'identificador del concepto',
  `monto` double DEFAULT '0',
  `fechaAlta` date DEFAULT NULL COMMENT 'fecha alta del gasto',
  `fechaAct` datetime DEFAULT NULL COMMENT 'fecha cuando se actualizo',
  `fechaCreacion` datetime DEFAULT NULL COMMENT 'fecha en que fue dado de alta'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `casos`
--

CREATE TABLE `casos` (
  `idCaso` int(11) NOT NULL,
  `clienteId` int(11) DEFAULT NULL COMMENT 'identificador del cliente',
  `tipoId` int(11) DEFAULT NULL COMMENT 'identificador del tipo de caso',
  `titularId` int(11) DEFAULT NULL COMMENT 'identificador del titular (usuarios)',
  `autorizadosIds` text COMMENT 'identificadores de los usuarios autorizados',
  `fechaAlta` date DEFAULT NULL COMMENT 'fecha alta del caso',
  `fechaAct` datetime DEFAULT NULL COMMENT 'fecha cuando se actualizo el cliente',
  `fechaCreacion` datetime DEFAULT NULL COMMENT 'fecha en que fue dado de alta'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caso_acciones`
--

CREATE TABLE `caso_acciones` (
  `idAccion` int(11) NOT NULL,
  `casoId` int(11) DEFAULT NULL COMMENT 'identificador del caso',
  `nombre` varchar(150) DEFAULT NULL COMMENT 'nombre de la accion',
  `comentarios` text COMMENT 'Comentarios',
  `fechaAlta` date DEFAULT NULL COMMENT 'fecha alta del caso',
  `fechaAct` datetime DEFAULT NULL COMMENT 'fecha cuando se actualizo el cliente',
  `fechaCreacion` datetime DEFAULT NULL COMMENT 'fecha en que fue dado de alta'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_ayudas`
--

CREATE TABLE `cat_ayudas` (
  `idAyuda` int(11) NOT NULL,
  `alias` varchar(50) DEFAULT NULL,
  `titulo` varchar(150) DEFAULT NULL,
  `descripcion` text,
  `fechaCreacion` datetime DEFAULT NULL,
  `tipo` int(1) NOT NULL DEFAULT '1' COMMENT '0 = ayuda app, 1 = ayuda web'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_ayudas`
--

INSERT INTO `cat_ayudas` (`idAyuda`, `alias`, `titulo`, `descripcion`, `fechaCreacion`, `tipo`) VALUES
(1, 'web_inicio', 'Inicio', '<h1>Inicio</h1>\n<p style=\"text-align: justify;\">Se muestran los accesos a los m&oacute;dulos del sistema que tiene permiso de visualizar.</p>\n<p style=\"text-align: justify;\">Dar clic en cualquier a de ellos para ir a la vista correspondiente.</p>', '2018-10-09 00:00:00', 1),
(2, 'catalogo_usuarios', 'Catalogo usuarios', '<p>En este cat&aacute;logo se muestran los usuarios que pueden acceder al sistema.</p>\n<p><strong>Nuevo</strong></p>\n<p>Abre una vista para agregar un nuevo usuario</p>\n<p>&nbsp;</p>\n<p><strong>Opciones en cada registro</strong></p>\n<ul>\n<li style=\"text-align: justify;\"><strong>Editar</strong>: Abre una vista donde se podr&aacute;n editar los datos del usuario.</li>\n<li style=\"text-align: justify;\"><strong>Eliminar</strong>: Elimina el usuario del sistema.</li>\n</ul>\n<p>&nbsp;</p>', '2018-10-09 00:00:00', 1),
(3, 'catalogo_roles', 'Catalogo roles', '<p>Se muestran los <strong>roles</strong> determinados en el sistema.</p>\n<p>Puede dar clic en <strong>Editar</strong> para cambiar el nombre de cada Rol.</p>', '2018-10-09 00:00:00', 1),
(4, 'catalogo_ayudas', 'Catalogo Ayudas', '<p>En este cat&aacute;logo se pueden editar la informaci&oacute;n que contienen las ayudas.</p>\n<p>Seleccionar la Ayuda que se desea visualizar.</p>\n<p>En el editor de texto, escribir el contenido de la ayuda que se desea editar.</p>\n<p>Dar clic en <strong>Guardar</strong> para guardar los cambios.</p>', '2018-10-09 00:00:00', 1),
(5, 'web_usuario', 'Usuario', '<p>En esta vista se puede agregar o editar un usuario.</p>\n<p>Deber&aacute; llenar los datos del formulario:</p>\n<ul>\n<li><strong>Rol</strong>: El tipo de usuario con el que ingresa al sistema, de este depende las pantallas que el usuario podr&aacute; visualizar.</li>\n<li><strong>Nombre</strong>: Escribir el nombre del usuario.</li>\n<li><strong>E-mail</strong>: Escribir el correo del usuario, no se puede repetir dos veces el mismo correo en el sistema.</li>\n<li><strong>Contrase&ntilde;a</strong>: La contrase&ntilde;a de acceso al sistema del usuario.</li>\n<li><strong>Activo</strong>: Determina si el usuario se encuentra activo en el sistema y por lo tanto si puede ingresar cuando inicie sesi&oacute;n.</li>\n</ul>\n<p>Dar clic en <strong>Guardar</strong> para salvar los cambios o agregar el usuario si se trata de uno nuevo.</p>', '2018-10-09 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_conceptos`
--

CREATE TABLE `cat_conceptos` (
  `idConcepto` int(11) NOT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `activo` char(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_configuraciones`
--

CREATE TABLE `cat_configuraciones` (
  `idConfiguracion` int(11) NOT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `valor` text,
  `fechaCreacion` datetime DEFAULT NULL COMMENT 'fecha en que fue dado de alta',
  `fechaAct` datetime DEFAULT NULL COMMENT 'fecha en que fue actualizada'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_tipo_casos`
--

CREATE TABLE `cat_tipo_casos` (
  `idTipo` int(11) NOT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `activo` char(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_tipo_casos`
--

INSERT INTO `cat_tipo_casos` (`idTipo`, `nombre`, `activo`) VALUES
(1, 'Tipo 1', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `idCliente` int(11) NOT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(20) DEFAULT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `fechaAct` datetime DEFAULT NULL COMMENT 'fecha cuando se actualizo el cliente',
  `fechaCreacion` datetime DEFAULT NULL COMMENT 'fecha en que fue dado de alta'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`idCliente`, `nombre`, `telefono`, `email`, `direccion`, `fechaAct`, `fechaCreacion`) VALUES
(1, 'Luis', '8542121222', 'luis@test.com.mx', 'Dir de prueba', '2020-12-09 00:00:00', '2020-12-09 00:00:00'),
(2, 'Mario', '2225748596', 'mario.0@test.com.mx', 'Dir de prueba', '2020-12-09 00:00:00', '2020-12-09 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comunicados`
--

CREATE TABLE `comunicados` (
  `idComunicado` int(11) NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `descripcionCorta` text,
  `contenido` text,
  `urlComunicado` varchar(250) DEFAULT NULL,
  `urlVideo` varchar(250) DEFAULT NULL COMMENT 'Url video',
  `imgComunicado` varchar(100) DEFAULT NULL,
  `opcVisto` char(1) DEFAULT NULL,
  `vistoPor` text,
  `opcTipo` char(1) DEFAULT '0' COMMENT '0=capsulas',
  `compartir` char(1) DEFAULT NULL,
  `activo` char(1) DEFAULT NULL,
  `fechaPublicacion` datetime DEFAULT NULL,
  `fechaDespublicacion` datetime DEFAULT NULL,
  `fechaCreacion` datetime DEFAULT NULL,
  `idUsuarioCmb` int(11) DEFAULT NULL,
  `fechaUltCambio` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `idRol` int(11) NOT NULL COMMENT 'identificador',
  `rol` varchar(30) DEFAULT NULL COMMENT 'nombre del rol',
  `fechaCreacion` datetime DEFAULT NULL COMMENT 'fecha en que se dio de alta'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`idRol`, `rol`, `fechaCreacion`) VALUES
(1, 'Super Administrador', '2017-02-20 05:01:29'),
(2, 'Administrador', '2017-02-20 05:02:05'),
(3, 'Cliente', '2017-02-20 17:05:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL COMMENT 'identificador',
  `idRol` int(11) DEFAULT NULL COMMENT 'identificador del rol',
  `nombre` varchar(150) DEFAULT NULL COMMENT 'nombre del usuario',
  `email` varchar(100) DEFAULT NULL COMMENT 'correo del usuario',
  `password` varchar(50) DEFAULT NULL COMMENT 'contraseña',
  `activo` int(1) NOT NULL DEFAULT '1' COMMENT '1 usuario activo, 0 inactivo',
  `fechaCreacion` datetime DEFAULT NULL COMMENT 'fecha en que fue dado de alta',
  `fechaAct` datetime DEFAULT NULL COMMENT 'fecha en que fue actualizada'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `idRol`, `nombre`, `email`, `password`, `activo`, `fechaCreacion`, `fechaAct`) VALUES
(1, 1, 'Super Administrador', 'superadmin@framelova.com', 'superadmin_pass', 1, '2017-02-20 17:00:00', NULL),
(2, 2, 'Administrador', 'admin@framelova.com', 'admin_pass', 1, '2017-02-20 17:00:00', NULL),
(3, 3, 'Cliente', 'cliente@framelova.com', 'cliente_pass', 1, '2017-02-20 17:00:00', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accion_gastos`
--
ALTER TABLE `accion_gastos`
  ADD PRIMARY KEY (`idGasto`);

--
-- Indices de la tabla `casos`
--
ALTER TABLE `casos`
  ADD PRIMARY KEY (`idCaso`);

--
-- Indices de la tabla `caso_acciones`
--
ALTER TABLE `caso_acciones`
  ADD PRIMARY KEY (`idAccion`);

--
-- Indices de la tabla `cat_ayudas`
--
ALTER TABLE `cat_ayudas`
  ADD PRIMARY KEY (`idAyuda`);

--
-- Indices de la tabla `cat_conceptos`
--
ALTER TABLE `cat_conceptos`
  ADD PRIMARY KEY (`idConcepto`);

--
-- Indices de la tabla `cat_configuraciones`
--
ALTER TABLE `cat_configuraciones`
  ADD PRIMARY KEY (`idConfiguracion`);

--
-- Indices de la tabla `cat_tipo_casos`
--
ALTER TABLE `cat_tipo_casos`
  ADD PRIMARY KEY (`idTipo`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idCliente`);

--
-- Indices de la tabla `comunicados`
--
ALTER TABLE `comunicados`
  ADD PRIMARY KEY (`idComunicado`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idRol`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `idRol` (`idRol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accion_gastos`
--
ALTER TABLE `accion_gastos`
  MODIFY `idGasto` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `casos`
--
ALTER TABLE `casos`
  MODIFY `idCaso` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `caso_acciones`
--
ALTER TABLE `caso_acciones`
  MODIFY `idAccion` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cat_ayudas`
--
ALTER TABLE `cat_ayudas`
  MODIFY `idAyuda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `cat_conceptos`
--
ALTER TABLE `cat_conceptos`
  MODIFY `idConcepto` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cat_configuraciones`
--
ALTER TABLE `cat_configuraciones`
  MODIFY `idConfiguracion` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cat_tipo_casos`
--
ALTER TABLE `cat_tipo_casos`
  MODIFY `idTipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `comunicados`
--
ALTER TABLE `comunicados`
  MODIFY `idComunicado` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `idRol` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador', AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador', AUTO_INCREMENT=4;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
