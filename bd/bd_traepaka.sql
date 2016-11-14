-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema traepaka
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `traepaka`;

-- -----------------------------------------------------
-- Schema traepaka
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `traepaka` DEFAULT CHARACTER SET utf8;
USE `traepaka` ;

-- -----------------------------------------------------
-- Table `traepaka`.`Usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `traepaka`.`Usuario`;

CREATE TABLE IF NOT EXISTS `traepaka`.`Usuario` (
  `dni` VARCHAR(9) NOT NULL,
  `password` VARCHAR(45) NULL,
  `nombre_usuario` VARCHAR(45) NULL,
  `correo_usuario` VARCHAR(45) NULL,
  `tipo_usuario` VARCHAR(15) NULL,
  `idioma` VARCHAR(3) NULL,
  PRIMARY KEY (`dni`))
ENGINE = InnoDB;

    
-- -----------------------------------------------------
-- INSERTS USUARIO
-- -----------------------------------------------------

INSERT INTO `usuario` (`dni`, `password`, `nombre_usuario`,`correo_usuario`, `tipo_usuario`, `idioma`) VALUES 
('53613886N', '81dc9bdb52d04dc20036dbd8313ed055', 'moncho', 'moncho@gmail.com', 'admin', 'esp');
INSERT INTO `usuario` (`dni`, `password`, `nombre_usuario`,`correo_usuario`, `tipo_usuario`, `idioma`) VALUES 
('39463709P', '81dc9bdb52d04dc20036dbd8313ed055', 'joshua', 'joshua@gmail.com', 'admin', 'esp');
INSERT INTO `usuario` (`dni`, `password`, `nombre_usuario`,`correo_usuario`, `tipo_usuario`, `idioma`) VALUES 
('11111111X', '81dc9bdb52d04dc20036dbd8313ed055', 'usuario1', 'usuario1@gmail.com', 'usuario', 'eng');
INSERT INTO `usuario` (`dni`, `password`, `nombre_usuario`,`correo_usuario`, `tipo_usuario`, `idioma`) VALUES 
('22222222Z', '81dc9bdb52d04dc20036dbd8313ed055', 'usuario2', 'usuario2@gmail.com', 'usuario', 'eng');

-- -----------------------------------------------------
-- Table `traepaka`.`Producto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `traepaka`.`Producto`;

CREATE TABLE IF NOT EXISTS `traepaka`.`Producto` (
  `id_producto` INT NOT NULL,
  `fecha` DATE NULL,
  `nombre_producto` VARCHAR(45) NULL,
  `descripcion_producto` VARCHAR(200) NULL,
  `precio` INT (9) NULL,
  `Usuario_dni` VARCHAR(9) NOT NULL,
  PRIMARY KEY (`id_producto`, `Usuario_dni`))
ENGINE = InnoDB;

CREATE INDEX `fk_Producto_Usuario1_idx` ON `traepaka`.`Producto` (`Usuario_dni` ASC);

-- -----------------------------------------------------
-- INSERTS PRODUCTO
-- -----------------------------------------------------

INSERT INTO `producto` (`id_producto`, `fecha`, `nombre_producto`, `descripcion_producto`, `precio`, `Usuario_dni`) VALUES 
('111111', '2016-11-01', 'mando', 'Vendo mando ps4', '30', '12345678Z');
INSERT INTO `producto` (`id_producto`, `fecha`, `nombre_producto`, `descripcion_producto`, `precio`, `Usuario_dni`) VALUES 
('222222', '2016-11-02', 'escopeta', 'Vendo escopeta gamo', '80', '39463709P');
INSERT INTO `producto` (`id_producto`, `fecha`, `nombre_producto`, `descripcion_producto`, `precio`, `Usuario_dni`) VALUES 
('333333', '2016-11-03', 'bolso', 'Vendo bolso mk', '100', '12345678Z');
INSERT INTO `producto` (`id_producto`, `fecha`, `nombre_producto`, `descripcion_producto`, `precio`, `Usuario_dni`) VALUES 
('444444', '2016-11-04', 'moto', 'Vendo moto ducati', '4800', '39463709P');


-- -----------------------------------------------------
-- Table `traepaka`.`Chat`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `traepaka`.`Chat`;

CREATE TABLE IF NOT EXISTS `traepaka`.`Chat` (
  `id_chat` INT NOT NULL,
  `fecha` DATETIME NULL,
  `nombre_chat` VARCHAR(45) NULL,
  `mensaje` VARCHAR(200) NULL,
  `Usuario_Dni` VARCHAR(9) NOT NULL,
  PRIMARY KEY (`id_chat`, `Usuario_Dni`))
ENGINE = InnoDB;

CREATE INDEX `fk_Chat_Usuario1_idx` ON `traepaka`.`Chat` (`Usuario_dni` ASC);

-- -----------------------------------------------------
-- Table `traepaka`.`Producto`
-- -----------------------------------------------------
INSERT INTO `chat` (`id_chat`, `fecha`, `nombre_chat`, `mensaje`, `Usuario_Dni`) VALUES 
('666666', 'diegochat', 'Hola que tal', '2016-11-01 18:00:00', '12345678Z');
INSERT INTO `chat` (`id_chat`, `fecha`,  `nombre_chat`, `mensaje`, `Usuario_Dni`) VALUES 
('777777', 'marcoschat', 'Hola que tal', '2016-11-02 19:00:00', '39463709P');
INSERT INTO `chat` (`id_chat`, `fecha`, `nombre_chat`, `mensaje`, `Usuario_Dni`) VALUES 
('888888', 'lorenachat', 'Hola que tal', '2016-11-03 20:00:00', '12345678Z');
INSERT INTO `chat` (`id_chat`, `fecha`,  `nombre_chat`, `mensaje`, `Usuario_Dni`) VALUES 
('999999', 'josechat', 'Hola que tal', '2016-11-04 21:00:00', '39463709P');

-- -----------------------------------------------------
-- Table `traepaka`.`Categoria`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `traepaka`.`Categoria`;

CREATE TABLE IF NOT EXISTS `traepaka`.`Categoria` (
  `id_categoria` INT NOT NULL,
  `nombre_categoria` VARCHAR(45) NULL,
  `Producto_id_producto` INT NOT NULL,
  PRIMARY KEY (`id_categoria`, `Producto_id_producto`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- INSETTS CATEGORIA
-- -----------------------------------------------------

INSERT INTO `categoria` (`id_categoria`, `nombre_categoria`, `Producto_id_producto`) VALUES ('0', 'Tecnologia', '111111');
INSERT INTO `categoria` (`id_categoria`, `nombre_categoria`, `Producto_id_producto`) VALUES ('1', 'Caza y Pesca', '222222');
INSERT INTO `categoria` (`id_categoria`, `nombre_categoria`, `Producto_id_producto`) VALUES ('2', 'Moda', '333333');
INSERT INTO `categoria` (`id_categoria`, `nombre_categoria`, `Producto_id_producto`) VALUES ('3', 'Motor', '444444');

CREATE INDEX `fk_Categoria_Producto1_idx` ON `traepaka`.`Categoria` (`Producto_id_producto` ASC);

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
