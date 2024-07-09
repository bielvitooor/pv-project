-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

CREATE SCHEMA IF NOT EXISTS postovendas DEFAULT CHARACTER SET utf8 ;
USE postovendas ;

CREATE TABLE IF NOT EXISTS postovendas.`product` (
  `idproduct` INT NOT NULL,
  `name_product` VARCHAR(45) NOT NULL,
  `price` DECIMAL NOT NULL,
  `quantity` DECIMAL NOT NULL,
  PRIMARY KEY (`idproduct`),
  UNIQUE INDEX `idproduct_UNIQUE` (`idproduct` ASC) VISIBLE)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS postovendas.`payment` (
  `idpayment` INT NOT NULL AUTO_INCREMENT,
  `tipo` VARCHAR(45) NULL,
  PRIMARY KEY (`idpayment`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS postovendas.`guest` (
  `idguest` INT NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `cpf` BIGINT(11) NULL,
  PRIMARY KEY (`idguest`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS postovendas.`orders` (
  `idorders` INT NOT NULL,
  `status_order` VARCHAR(45) NOT NULL,
  `totalvalue` VARCHAR(45) NOT NULL,
  `payment_idpayment` INT NOT NULL,
  `product_idproduct` INT NOT NULL,
  `guest_idguest` INT NOT NULL,
  PRIMARY KEY (`idorders`),
  INDEX `fk_orders_payment1_idx` (`payment_idpayment` ASC) VISIBLE,
  INDEX `fk_orders_product1_idx` (`product_idproduct` ASC) VISIBLE,
  INDEX `fk_orders_guest1_idx` (`guest_idguest` ASC) VISIBLE,
  CONSTRAINT `fk_orders_payment1`
    FOREIGN KEY (`payment_idpayment`)
    REFERENCES postovendas.`payment` (`idpayment`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_orders_product1`
    FOREIGN KEY (`product_idproduct`)
    REFERENCES postovendas.`product` (`idproduct`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_orders_guest1`
    FOREIGN KEY (`guest_idguest`)
    REFERENCES postovendas.`guest` (`idguest`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS postovendas.`admin` (
  `idadmin` INT NOT NULL,
  `login` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `` VARCHAR(45) NULL,
  PRIMARY KEY (`idadmin`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
