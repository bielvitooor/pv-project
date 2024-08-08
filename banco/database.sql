SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- Schema pv
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS pv DEFAULT CHARACTER SET utf8;
USE pv;

-- -----------------------------------------------------
-- Table pv.status
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS pv.status (
  idstatus INT NOT NULL AUTO_INCREMENT,
  description VARCHAR(45) NOT NULL,
  PRIMARY KEY (idstatus))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table pv.admin
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS pv.admin (
  idadmin INT(11) NOT NULL AUTO_INCREMENT,
  login VARCHAR(45) NOT NULL,
  password VARCHAR(45) NOT NULL,
  name VARCHAR(45) NOT NULL,
  PRIMARY KEY (idadmin))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table pv.guest
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS pv.guest (
  idguest INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(45) NOT NULL,
  cpf BIGINT(11) NOT NULL,
  PRIMARY KEY (idguest))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table pv.payment
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS pv.payment (
  idpayment INT(11) NOT NULL AUTO_INCREMENT,
  tipo VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (idpayment))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table pv.orders
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS pv.orders (
  idorder INT(11) NOT NULL AUTO_INCREMENT,
  totalvalue DECIMAL(10,2) NOT NULL,
  payment_idpayment INT(11) NOT NULL,
  guest_idguest INT(11) NOT NULL,
  dateorder DATETIME,
  status_idstatus INT NOT NULL,
  PRIMARY KEY (idorder),
  INDEX fk_orders_payment1_idx (payment_idpayment ASC),
  INDEX fk_orders_guest1_idx (guest_idguest ASC),
  INDEX fk_orders_status1_idx (status_idstatus ASC),
  CONSTRAINT fk_orders_guest1
    FOREIGN KEY (guest_idguest)
    REFERENCES pv.guest (idguest)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT fk_orders_payment1
    FOREIGN KEY (payment_idpayment)
    REFERENCES pv.payment (idpayment)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT fk_orders_status1
    FOREIGN KEY (status_idstatus)
    REFERENCES pv.status (idstatus)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table pv.product
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS pv.product (
  idproduct INT(11) NOT NULL AUTO_INCREMENT,
  name_product VARCHAR(45) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  quantity DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (idproduct),
  UNIQUE INDEX idproduct_UNIQUE (idproduct ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table pv.order_items
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS pv.order_items (
  idorder_items INT(11) NOT NULL AUTO_INCREMENT,
  order_id INT(11) NOT NULL,
  product_id INT(11) NOT NULL,
  quantity DECIMAL(10,2) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (idorder_items),
  INDEX fk_order_items_orders1_idx (order_id ASC),
  INDEX fk_order_items_product1_idx (product_id ASC),
  CONSTRAINT fk_order_items_orders1
    FOREIGN KEY (order_id)
    REFERENCES pv.orders (idorder)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT fk_order_items_product1
    FOREIGN KEY (product_id)
    REFERENCES pv.product (idproduct)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;
select * from order_items;
select * from orders;
CREATE VIEW myorder AS
SELECT
  o.idorder AS idorder,
  g.name AS nome_cliente,
  GROUP_CONCAT(p.name_product SEPARATOR ', ') AS produtos,
  GROUP_CONCAT(oi.quantity SEPARATOR ', ') AS quantidades,
  GROUP_CONCAT(p.price SEPARATOR ', ') AS precos_unitarios,
  SUM(oi.quantity * p.price) AS totalvalor_produto,
  o.dateorder,
  o.totalvalue AS totalcompra,
  g.cpf AS cpf
FROM
  pv.orders o
  INNER JOIN pv.guest g ON o.guest_idguest = g.idguest
  INNER JOIN pv.order_items oi ON o.idorder = oi.order_id
  INNER JOIN pv.product p ON oi.product_id = p.idproduct
GROUP BY
  o.idorder, g.name, g.cpf;
-- Restaurar verificações
-- SET SQL_MODE=@OLD_SQL_MODE;
-- SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
-- SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
CREATE VIEW myorder AS 
SELECT
  o.idorder AS idorder,
  g.name AS nameguest,
  GROUP_CONCAT(p.name_product SEPARATOR ', ') AS products,
  GROUP_CONCAT(oi.quantity SEPARATOR ', ') AS quantities,
  GROUP_CONCAT(p.price SEPARATOR ', ') AS uniprice,
  GROUP_CONCAT(oi.quantity * p.price SEPARATOR ', ') AS subtotal,
  o.totalvalue AS total,
  s.description AS statusoder,
  m.tipo as payment,
  g.cpf AS cpf
  
FROM
  pv.orders o
  INNER JOIN pv.guest g ON o.guest_idguest = g.idguest
  INNER JOIN pv.order_items oi ON o.idorder = oi.order_id
  INNER JOIN pv.product p ON oi.product_id = p.idproduct
  INNER JOIN pv.status s ON o.status_idstatus= s.idstatus
  INNER JOIN pv.payment m ON o.payment_idpayment = m.idpayment
GROUP BY
  o.idorder, g.name, g.cpf, o.totalvalue;
  SELECT * FROM myorder;
SELECT idorder,nameguest,products,quantities,uniprice,subtotal,total FROM myorder WHERE cpf="71173068155";
