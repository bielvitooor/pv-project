

INSERT INTO `admin` (`idadmin`, `login`, `password`, `name`) VALUES
(1, '2020', '1234', 'Gabriel');


INSERT INTO `guest` (`idguest`, `name`, `cpf`) VALUES
(1, 'João', 12345678900),
(2, 'João', 12345678900),
(3, 'João', 12345678900),
(4, 'João', 12345678900),
(5, 'João', 12345678900),
(6, 'João', 12345678900),
(7, 'João', 12345678900),
(8, 'João', 12345678900),
(9, 'João', 12345678900),
(10, 'João Silva', 12345678901),
(11, 'João Silva', 1234567897654);


INSERT INTO `payment` (`idpayment`, `tipo`) VALUES
(1, 'Dinheiro'),
(2, 'Cartão'),
(3, 'Pix');



INSERT INTO `product` (`idproduct`, `name_product`, `price`, `quantity`) VALUES
(7, 'Laranja', 32.00, 9.00),
(8, 'Ovo Branco', 7.00, 5.00);




INSERT INTO `status` (`idstatus`, `description`) VALUES
(1, 'Em espera'),
(2, 'Em seperação'),
(3, 'Pronto');

