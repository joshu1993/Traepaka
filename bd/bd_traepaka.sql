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
  `nombreusuario` VARCHAR(45) NULL,
  `idioma` VARCHAR(3) NULL,
  `correo` VARCHAR(45) NULL,
  `tipousuario` VARCHAR(15) NULL,
  PRIMARY KEY (`dni`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- INSERTS USUARIO
-- -----------------------------------------------------

INSERT INTO `usuario` (`dni`, `password`, `nombreusuario`, `idioma`, `correo`, `tipousuario`) VALUES 
('53613886N', '81dc9bdb52d04dc20036dbd8313ed055', 'moncho', 'esp', 'moncho@gmail.com', 'admin');
INSERT INTO `usuario` (`dni`, `password`, `nombreusuario`, `idioma`, `correo`, `tipousuario`) VALUES 
('12345678X', '81dc9bdb52d04dc20036dbd8313ed055', 'admin', 'eng', 'admin@gmail.com', 'admin');
INSERT INTO `usuario` (`dni`, `password`, `nombreusuario`, `idioma`, `correo`, `tipousuario`) VALUES 
('12345678Z', '81dc9bdb52d04dc20036dbd8313ed055', 'usuario', 'eng', 'usuario@gmail.com', 'usuario');
INSERT INTO `usuario` (`dni`, `password`, `nombreusuario`, `idioma`, `correo`, `tipousuario`) VALUES 
('39463709P', '81dc9bdb52d04dc20036dbd8313ed055', 'joshua', 'esp', 'joshua@gmail.com', 'usuario');

-- -----------------------------------------------------
-- Table `traepaka`.`Producto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `traepaka`.`Producto`;

CREATE TABLE IF NOT EXISTS `traepaka`.`Producto` (
  `idproducto` INT NOT NULL,
  `fecha` DATE NULL,
  `nombreproducto` VARCHAR(45) NULL,
  `descripcion` VARCHAR(200) NULL,
  `precio` INT (9) NULL,
  `Usuario_dni` VARCHAR(9) NOT NULL,
  PRIMARY KEY (`idproducto`, `Usuario_dni`))
ENGINE = InnoDB;

CREATE INDEX `fk_Producto_Usuario1_idx` ON `traepaka`.`Producto` (`Usuario_dni` ASC);

-- -----------------------------------------------------
-- INSERTS PRODUCTO
-- -----------------------------------------------------

INSERT INTO `producto` (`idproducto`, `fecha`, `nombreproducto`, `descripcion`, `precio`, `Usuario_dni`) VALUES 
('111111', '2016-11-01', 'mando', 'Vendo mando ps4', '30', '12345678Z');
INSERT INTO `producto` (`idproducto`, `fecha`, `nombreproducto`, `descripcion`, `precio`, `Usuario_dni`) VALUES 
('222222', '2016-11-02', 'escopeta', 'Vendo escopeta gamo', '80', '39463709P');
INSERT INTO `producto` (`idproducto`, `fecha`, `nombreproducto`, `descripcion`, `precio`, `Usuario_dni`) VALUES 
('333333', '2016-11-03', 'bolso', 'Vendo bolso mk', '100', '12345678Z');
INSERT INTO `producto` (`idproducto`, `fecha`, `nombreproducto`, `descripcion`, `precio`, `Usuario_dni`) VALUES 
('444444', '2016-11-04', 'moto', 'Vendo moto ducati', '4800', '39463709P');


-- -----------------------------------------------------
-- Table `traepaka`.`Chat`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `traepaka`.`Chat`;

CREATE TABLE IF NOT EXISTS `traepaka`.`Chat` (
  `idchat` INT NOT NULL,
  `nombrechat` VARCHAR(45) NULL,
  `mensaje` VARCHAR(200) NULL,
  `fecha` DATETIME NULL,
  `Usuario_Dni` VARCHAR(9) NOT NULL,
  PRIMARY KEY (`idchat`, `Usuario_Dni`))
ENGINE = InnoDB;

CREATE INDEX `fk_Chat_Usuario1_idx` ON `traepaka`.`Chat` (`Usuario_dni` ASC);

-- -----------------------------------------------------
-- Table `traepaka`.`Producto`
-- -----------------------------------------------------
INSERT INTO `chat` (`idchat`, `nombrechat`, `mensaje`, `fecha`, `Usuario_Dni`) VALUES 
('666666', 'diegochat', 'Hola que tal', '2016-11-01 18:00:00', '12345678Z');
INSERT INTO `chat` (`idchat`, `nombrechat`, `mensaje`, `fecha`, `Usuario_Dni`) VALUES 
('777777', 'marcoschat', 'Hola que tal', '2016-11-02 19:00:00', '39463709P');
INSERT INTO `chat` (`idchat`, `nombrechat`, `mensaje`, `fecha`, `Usuario_Dni`) VALUES 
('888888', 'lorenachat', 'Hola que tal', '2016-11-03 20:00:00', '12345678Z');
INSERT INTO `chat` (`idchat`, `nombrechat`, `mensaje`, `fecha`, `Usuario_Dni`) VALUES 
('999999', 'josechat', 'Hola que tal', '2016-11-04 21:00:00', '39463709P');

-- -----------------------------------------------------
-- Table `traepaka`.`Categoria`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `traepaka`.`Categoria`;

CREATE TABLE IF NOT EXISTS `traepaka`.`Categoria` (
  `idcategoria` INT NOT NULL,
  `nombrecategoria` VARCHAR(45) NULL,
  `Producto_idproducto` INT NOT NULL,
  PRIMARY KEY (`idcategoria`, `Producto_idproducto`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- INSETTS CATEGORIA
-- -----------------------------------------------------

INSERT INTO `categoria` (`idcategoria`, `nombrecategoria`, `Producto_idproducto`) VALUES ('0', 'Tecnologia', '111111');
INSERT INTO `categoria` (`idcategoria`, `nombrecategoria`, `Producto_idproducto`) VALUES ('1', 'Caza y Pesca', '222222');
INSERT INTO `categoria` (`idcategoria`, `nombrecategoria`, `Producto_idproducto`) VALUES ('2', 'Moda', '333333');
INSERT INTO `categoria` (`idcategoria`, `nombrecategoria`, `Producto_idproducto`) VALUES ('3', 'Motor', '444444');

CREATE INDEX `fk_Categoria_Producto1_idx` ON `traepaka`.`Categoria` (`Producto_idproducto` ASC);

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
