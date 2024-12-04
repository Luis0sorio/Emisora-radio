CREATE DATABASE IF NOT EXISTS `emisoradb3` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `emisoradb3`;

-- Tabla de usuarios
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `usuarioId` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(30) NOT NULL,
  `apellido` VARCHAR(30) NOT NULL,
  `email` VARCHAR(200) NOT NULL,
  `usuario` VARCHAR(30) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `admin` TINYINT(1) NOT NULL DEFAULT 0,
  `fecha_creacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`usuarioId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de grupos musicales
DROP TABLE IF EXISTS `grupos`;
CREATE TABLE `grupos` (
  `grupoId` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `creacion` YEAR NOT NULL,
  `origen` VARCHAR(45) NOT NULL,
  `genero` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`grupoId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de relación entre usuarios y grupos añadidos
DROP TABLE IF EXISTS `usuarios_grupos`;
CREATE TABLE usuarios_grupos (
  id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  usuarioId INT(10) UNSIGNED NOT NULL,
  grupoId INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (id),
  UNIQUE (usuarioId, grupoId), -- Restricción única compuesta
  FOREIGN KEY (usuarioId) REFERENCES usuarios(usuarioId) ON DELETE CASCADE,
  FOREIGN KEY (grupoId) REFERENCES grupos(grupoId) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Inserción de un usuario administrador por defecto
INSERT INTO `usuarios` (`nombre`, `apellido`, `email`, `usuario`, `password`, `admin`)
VALUES ('Admin', 'Default', 'admin@emisoradb.com', 'admin', 'admin_password_hash', 1);


/****************************************************************************************/
/****************************************************************************************/
/*
-- Tabla de eventos
DROP TABLE IF EXISTS `eventos`;
CREATE TABLE `eventos` (
  `eventoId` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `lugar` VARCHAR(45) NOT NULL,
  `duracion` VARCHAR(45) NOT NULL,
  `tipoEvento` VARCHAR(45) NOT NULL,
  `asientosDisp` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`eventoId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de registro de eventos
DROP TABLE IF EXISTS `registroEventos`;
CREATE TABLE `registroEventos` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `eventoId` INT(10) UNSIGNED NOT NULL,
  `usuarioId` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`eventoId`) REFERENCES `eventos`(`eventoId`) ON DELETE CASCADE,
  FOREIGN KEY (`usuarioId`) REFERENCES `usuarios`(`usuarioId`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
*/

/*
DROP TABLE IF EXISTS `canciones`;
CREATE TABLE canciones (
  cancionId INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  titulo VARCHAR(255) NOT NULL,
  grupoId INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (cancionId),
  FOREIGN KEY (grupoId) REFERENCES grupos(grupoId) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `usuarios_canciones`;
CREATE TABLE usuarios_canciones (
  id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  usuarioId INT(10) UNSIGNED NOT NULL,
  cancionId INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (id),
  UNIQUE (usuarioId, cancionId), -- Restricción única compuesta
  FOREIGN KEY (usuarioId) REFERENCES usuarios(usuarioId) ON DELETE CASCADE,
  FOREIGN KEY (cancionId) REFERENCES canciones(cancionId) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
*/

/*
-- Tabla de componentes de los grupos
DROP TABLE IF EXISTS `componentes`;
CREATE TABLE `componentes` (
  `componenteId` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(30) NOT NULL,
  `grupoId` INT(10) UNSIGNED NOT NULL,
  `instrumento` VARCHAR(25) NOT NULL,
  PRIMARY KEY (`componenteId`),
  FOREIGN KEY (`grupoId`) REFERENCES `grupos`(`grupoId`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
*/