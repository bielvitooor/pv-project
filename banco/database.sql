-- Desabilitar verificações temporariamente
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- Criar schema se não existir
CREATE SCHEMA IF NOT EXISTS pv DEFAULT CHARACTER SET utf8;
USE pv;

-- Tabela product
CREATE TABLE IF NOT EXISTS product (
  idproduct INT NOT NULL AUTO_INCREMENT,
  name_product VARCHAR(45) NOT NULL,
  price DECIMAL(10, 2) NOT NULL,
  quantity DECIMAL(10, 2) NOT NULL,
  PRIMARY KEY (idproduct),
  UNIQUE INDEX idproduct_UNIQUE (idproduct ASC))
ENGINE = InnoDB;

-- Tabela payment
CREATE TABLE IF NOT EXISTS payment (
  idpayment INT NOT NULL AUTO_INCREMENT,
  tipo VARCHAR(45) NULL,
  PRIMARY KEY (idpayment))
ENGINE = InnoDB;

-- Tabela guest
CREATE TABLE IF NOT EXISTS guest (
  idguest INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(45) NOT NULL,
  cpf BIGINT(11) NULL,
  PRIMARY KEY (idguest))
ENGINE = InnoDB;

-- Tabela orders
CREATE TABLE IF NOT EXISTS orders (
  idorder INT NOT NULL AUTO_INCREMENT,
  status_order VARCHAR(45) NOT NULL,
  totalvalue DECIMAL(10, 2) NOT NULL,
  payment_idpayment INT NOT NULL,
  guest_idguest INT NOT NULL,
  PRIMARY KEY (idorder),
  INDEX fk_orders_payment1_idx (payment_idpayment ASC),
  INDEX fk_orders_guest1_idx (guest_idguest ASC),
  CONSTRAINT fk_orders_payment1
    FOREIGN KEY (payment_idpayment)
    REFERENCES payment (idpayment)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT fk_orders_guest1
    FOREIGN KEY (guest_idguest)
    REFERENCES guest (idguest)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- Tabela order_items
CREATE TABLE IF NOT EXISTS order_items (
  idorder_items INT NOT NULL AUTO_INCREMENT,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  quantity DECIMAL(10, 2) NOT NULL,
  price DECIMAL(10, 2) NOT NULL,
  PRIMARY KEY (idorder_items),
  INDEX fk_order_items_orders1_idx (order_id ASC),
  INDEX fk_order_items_product1_idx (product_id ASC),
  CONSTRAINT fk_order_items_orders1
    FOREIGN KEY (order_id)
    REFERENCES orders (idorder)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT fk_order_items_product1
    FOREIGN KEY (product_id)
    REFERENCES product (idproduct)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- Tabela admin
CREATE TABLE IF NOT EXISTS admin (
  idadmin INT NOT NULL AUTO_INCREMENT,
  login VARCHAR(45) NOT NULL,
  password VARCHAR(45) NOT NULL,
  name VARCHAR(45) NOT NULL,
  PRIMARY KEY (idadmin))
ENGINE = InnoDB;
INSERT INTO admin (login, password, name) VALUES
('admin', 'admin', 'admin-teste');
INSERT INTO payment (tipo) VALUES ("Pix"),("Dinheiro");

SELECT * from payment;

-- Restaurar verificações
-- SET SQL_MODE=@OLD_SQL_MODE;
-- SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
-- SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
