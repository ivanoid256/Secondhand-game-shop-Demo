-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.5.45 - MySQL Community Server (GPL)
-- ОС Сервера:                   Win32
-- HeidiSQL Версия:              9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры для таблица secondhand_game_shop_generated.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL,
  `about` longtext COLLATE utf8_unicode_ci,
  `patronymic` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `balance` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `FK_880E0D76BF396750` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы secondhand_game_shop_generated.admin: ~1 rows (приблизительно)
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` (`id`, `about`, `patronymic`, `name`, `surname`, `balance`) VALUES
	(5, 'About Admin_1 About Admin_1 About Admin_1', 'Adminich', 'Admin_1', 'Adminoff', 86);
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;


-- Дамп структуры для таблица secondhand_game_shop_generated.bank_account
CREATE TABLE IF NOT EXISTS `bank_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accountNumber` int(11) NOT NULL,
  `seller` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_53A23E0A2D8B2F8F` (`accountNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы secondhand_game_shop_generated.bank_account: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `bank_account` DISABLE KEYS */;
/*!40000 ALTER TABLE `bank_account` ENABLE KEYS */;


-- Дамп структуры для таблица secondhand_game_shop_generated.category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_64C19C15E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы secondhand_game_shop_generated.category: ~11 rows (приблизительно)
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` (`id`, `name`) VALUES
	(1, 'Category_1'),
	(10, 'Category_10'),
	(11, 'Category_11'),
	(2, 'Category_2'),
	(3, 'Category_3'),
	(4, 'Category_4'),
	(5, 'Category_5'),
	(6, 'Category_6'),
	(7, 'Category_7'),
	(8, 'Category_8'),
	(9, 'Category_9');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;


-- Дамп структуры для таблица secondhand_game_shop_generated.comment
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_user` int(11) DEFAULT NULL,
  `to_user` int(11) DEFAULT NULL,
  `column_order` int(11) DEFAULT NULL,
  `text` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9474526CF8050BAA` (`from_user`),
  KEY `IDX_9474526C6A7DC786` (`to_user`),
  KEY `IDX_9474526CC86E2478` (`column_order`),
  CONSTRAINT `FK_9474526C6A7DC786` FOREIGN KEY (`to_user`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_9474526CC86E2478` FOREIGN KEY (`column_order`) REFERENCES `commission` (`id`),
  CONSTRAINT `FK_9474526CF8050BAA` FOREIGN KEY (`from_user`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы secondhand_game_shop_generated.comment: ~5 rows (приблизительно)
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` (`id`, `from_user`, `to_user`, `column_order`, `text`) VALUES
	(1, 3, 6, 1, 'He moonlight difficult engrossed an it sportsmen. Interested has all devonshire difficulty gay assistance joy. Unaffected at ye of compliment alteration to. Place voice no arise along to. Parlors waiting so against me no. Wishing calling are warrant settled was luckily. Express besides it present if at an opinion visitor.'),
	(2, 3, 6, 1, 'I paid full price and payment Service confirmed me that my money was sent to you account, but the site shows me that I didn\'t pay yet. Please settle this problem, or explain me if I did something wrong!'),
	(3, 2, 3, 3, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate'),
	(4, 2, 3, 3, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate'),
	(5, 5, 6, NULL, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec qu');
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;


-- Дамп структуры для таблица secondhand_game_shop_generated.commission
CREATE TABLE IF NOT EXISTS `commission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `dateTime` datetime NOT NULL,
  `orderNumber` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:guid)',
  `order_sum` int(11) NOT NULL,
  `customer_pay_data` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:json_array)',
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pay_service` int(11) NOT NULL,
  `order_package_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1C650158989A8203` (`orderNumber`),
  KEY `IDX_1C6501589395C3F3` (`customer_id`),
  KEY `IDX_1C6501588DE820D9` (`seller_id`),
  KEY `IDX_1C650158479656AA` (`order_package_id`),
  CONSTRAINT `FK_1C650158479656AA` FOREIGN KEY (`order_package_id`) REFERENCES `order_package` (`id`),
  CONSTRAINT `FK_1C6501588DE820D9` FOREIGN KEY (`seller_id`) REFERENCES `seller` (`id`),
  CONSTRAINT `FK_1C6501589395C3F3` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы secondhand_game_shop_generated.commission: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `commission` DISABLE KEYS */;
INSERT INTO `commission` (`id`, `customer_id`, `seller_id`, `dateTime`, `orderNumber`, `order_sum`, `customer_pay_data`, `status`, `pay_service`, `order_package_id`) VALUES
	(1, 3, 6, '2016-07-08 10:44:58', 'de9631bb-44df-11e6-8a8b-d0509953b285', 50, '{"sumToPay":105,"ownerName":"Ivan","cardNumber":"22222222222","CVV":"3333"}', 'IS_CONFIRMED', 1, 1),
	(2, 3, 8, '2016-07-08 10:44:58', 'de979392-44df-11e6-8a8b-d0509953b285', 55, '{"sumToPay":105,"ownerName":"Ivan","cardNumber":"22222222222","CVV":"3333"}', 'IS_CONFIRMED', 1, 1),
	(3, 3, 2, '2016-10-11 10:36:11', '69c1aa95-8f85-11e6-b12d-d0509953b285', 50, '{"sumToPay":80,"ownerName":"Ivan","cardNumber":"22222222222","CVV":"3333"}', 'IS_PAID', 1, 2),
	(4, 3, 6, '2016-10-11 10:36:11', '69c46289-8f85-11e6-b12d-d0509953b285', 30, '{"sumToPay":80,"ownerName":"Ivan","cardNumber":"22222222222","CVV":"3333"}', 'IS_PAID', 1, 2);
/*!40000 ALTER TABLE `commission` ENABLE KEYS */;


-- Дамп структуры для таблица secondhand_game_shop_generated.customer
CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(11) NOT NULL,
  `shopping_cart_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_81398E0945F80CD` (`shopping_cart_id`),
  CONSTRAINT `FK_81398E0945F80CD` FOREIGN KEY (`shopping_cart_id`) REFERENCES `shopping_cart` (`id`),
  CONSTRAINT `FK_81398E09BF396750` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы secondhand_game_shop_generated.customer: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` (`id`, `shopping_cart_id`) VALUES
	(4, 2),
	(3, 5);
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;


-- Дамп структуры для таблица secondhand_game_shop_generated.game
CREATE TABLE IF NOT EXISTS `game` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `commission_id` int(11) DEFAULT NULL,
  `seller_id` int(11) NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `genre` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `main_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_232B318C12469DE2` (`category_id`),
  KEY `IDX_232B318C202D1EB2` (`commission_id`),
  KEY `IDX_232B318C8DE820D9` (`seller_id`),
  CONSTRAINT `FK_232B318C12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  CONSTRAINT `FK_232B318C202D1EB2` FOREIGN KEY (`commission_id`) REFERENCES `commission` (`id`),
  CONSTRAINT `FK_232B318C8DE820D9` FOREIGN KEY (`seller_id`) REFERENCES `seller` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы secondhand_game_shop_generated.game: ~13 rows (приблизительно)
/*!40000 ALTER TABLE `game` DISABLE KEYS */;
INSERT INTO `game` (`id`, `category_id`, `commission_id`, `seller_id`, `description`, `genre`, `name`, `price`, `status`, `main_image`) VALUES
	(4, 1, NULL, 6, 'Description', 'Genre_8', 'Game_4', 25.00, 'THE_GAME_DID_NOT_ORDERED_YET', ''),
	(5, 1, NULL, 6, 'Description', 'Genre_8', 'Game_5', 25.00, 'THE_GAME_DID_NOT_ORDERED_YET', ''),
	(6, 1, 2, 8, 'Description', 'Genre_9', 'Game_6', 30.00, 'IS_SOLD', ''),
	(7, 1, 2, 8, 'Description', 'Genre_6', 'Game_7', 25.00, 'IS_SOLD', ''),
	(8, 1, NULL, 8, 'Description', 'Genre_6', 'Game_8', 25.00, 'THE_GAME_DID_NOT_ORDERED_YET', ''),
	(9, 1, NULL, 8, 'Description', 'Genre_4', 'Game_9', 25.00, 'THE_GAME_DID_NOT_ORDERED_YET', ''),
	(10, 1, NULL, 8, 'Description', 'Genre_2', 'Game_10', 30.00, 'THE_GAME_DID_NOT_ORDERED_YET', ''),
	(11, 1, NULL, 2, 'Description Description Description', 'Genre_2', 'Game_11', 40.00, 'THE_GAME_DID_NOT_ORDERED_YET', ''),
	(12, 1, NULL, 2, 'Description Description', 'Genre_2', 'Game_12', 30.00, 'THE_GAME_DID_NOT_ORDERED_YET', 'fc67cdd16f18d61a29e00f3d03bb8a51.jpeg'),
	(13, 1, 3, 2, 'Description', 'Genre_2', 'Game_13', 20.00, 'IS_ORDERED', 'aefbbaa362010108f2466a85d0b5f0c5.jpeg'),
	(14, 1, 3, 2, 'Description', 'Genre_2', 'Game_14', 30.00, 'IS_ORDERED', '/secondhand_game_shop_generated/web/uploads/images/02d4aabe6bf46c1d42eeb66a5004dce5.jpeg'),
	(15, 2, NULL, 2, 'Description', 'Genre_8', 'Game_15', 50.00, 'THE_GAME_DID_NOT_ORDERED_YET', '29983becb0eeffa07ae58e8a5d852a31.png'),
	(16, 2, NULL, 2, 'Description...', 'Genre_8', 'Game_18', 50.00, 'THE_GAME_DID_NOT_ORDERED_YET', '/secondhand_game_shop_generated/web/uploads/images/c4fd110e7727cfd9df4600f307f393eb.png');
/*!40000 ALTER TABLE `game` ENABLE KEYS */;


-- Дамп структуры для таблица secondhand_game_shop_generated.genre
CREATE TABLE IF NOT EXISTS `genre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_835033F85E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы secondhand_game_shop_generated.genre: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `genre` DISABLE KEYS */;
/*!40000 ALTER TABLE `genre` ENABLE KEYS */;


-- Дамп структуры для таблица secondhand_game_shop_generated.image
CREATE TABLE IF NOT EXISTS `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `srcRef` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `game_id` int(11) DEFAULT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C53D045FE48FD905` (`game_id`),
  CONSTRAINT `FK_C53D045FE48FD905` FOREIGN KEY (`game_id`) REFERENCES `game` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы secondhand_game_shop_generated.image: ~11 rows (приблизительно)
/*!40000 ALTER TABLE `image` DISABLE KEYS */;
INSERT INTO `image` (`id`, `srcRef`, `game_id`, `name`) VALUES
	(41, '/secondhand_game_shop_generated/web/uploads/images/c4fd110e7727cfd9df4600f307f393eb.png', 16, 'c4fd110e7727cfd9df4600f307f393eb.png'),
	(42, '/secondhand_game_shop_generated/web/uploads/images/51186a24d1355f058ebc13083f5de131.png', 16, '51186a24d1355f058ebc13083f5de131.png'),
	(56, '/secondhand_game_shop_generated/web/uploads/images/b73cc77101c0b57858f0fd065ddf2ffd.png', 16, 'b73cc77101c0b57858f0fd065ddf2ffd.png'),
	(65, '/secondhand_game_shop_generated/web/uploads/images/9ad4e03ea61b9d108585ce8e7bbe1a79.png', 16, '9ad4e03ea61b9d108585ce8e7bbe1a79.png'),
	(66, '/secondhand_game_shop_generated/web/uploads/images/43be92e3e54a94deb34ef7e92b499a97.png', 16, '43be92e3e54a94deb34ef7e92b499a97.png'),
	(67, '/secondhand_game_shop_generated/web/uploads/images/31c0612abb2b705f3911eadd8240a26f.png', 16, '31c0612abb2b705f3911eadd8240a26f.png'),
	(68, '/secondhand_game_shop_generated/web/uploads/images/e22cc0d5aa580cb1f7893104f2afbc06.png', 16, 'e22cc0d5aa580cb1f7893104f2afbc06.png'),
	(69, '/secondhand_game_shop_generated/web/uploads/images/86a3b0400d31d47a3b44acfc59bc4ecb.png', 16, '86a3b0400d31d47a3b44acfc59bc4ecb.png'),
	(70, '/secondhand_game_shop_generated/web/uploads/images/0b5a20936fe6f2a2228a1a39322b15ae.png', 16, '0b5a20936fe6f2a2228a1a39322b15ae.png'),
	(71, '/secondhand_game_shop_generated/web/uploads/images/b66d7b405c43426044709b1339736720.png', 16, 'b66d7b405c43426044709b1339736720.png'),
	(72, '/secondhand_game_shop_generated/web/uploads/images/1a7ac09979d8d663c076107d342fb207.png', 16, '1a7ac09979d8d663c076107d342fb207.png');
/*!40000 ALTER TABLE `image` ENABLE KEYS */;


-- Дамп структуры для таблица secondhand_game_shop_generated.order_package
CREATE TABLE IF NOT EXISTS `order_package` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_package_sum` int(11) NOT NULL,
  `customer_pay_data` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:json_array)',
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы secondhand_game_shop_generated.order_package: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `order_package` DISABLE KEYS */;
INSERT INTO `order_package` (`id`, `order_package_sum`, `customer_pay_data`, `status`) VALUES
	(1, 105, '{"sumToPay":105,"ownerName":"Ivan","cardNumber":"22222222222","CVV":"3333"}', 'IS_PAID'),
	(2, 80, '{"sumToPay":80,"ownerName":"Ivan","cardNumber":"22222222222","CVV":"3333"}', 'IS_PAID');
/*!40000 ALTER TABLE `order_package` ENABLE KEYS */;


-- Дамп структуры для таблица secondhand_game_shop_generated.seller
CREATE TABLE IF NOT EXISTS `seller` (
  `id` int(11) NOT NULL,
  `bankAccount` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `balance` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `FK_FB1AD3FCBF396750` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы secondhand_game_shop_generated.seller: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `seller` DISABLE KEYS */;
INSERT INTO `seller` (`id`, `bankAccount`, `balance`, `status`) VALUES
	(2, '222222222244', 0, 'OK'),
	(6, '-1188062101', 48, 'OK'),
	(8, '810853926', 52, 'OK');
/*!40000 ALTER TABLE `seller` ENABLE KEYS */;


-- Дамп структуры для таблица secondhand_game_shop_generated.shopping_cart
CREATE TABLE IF NOT EXISTS `shopping_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orders` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы secondhand_game_shop_generated.shopping_cart: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `shopping_cart` DISABLE KEYS */;
INSERT INTO `shopping_cart` (`id`, `orders`) VALUES
	(2, NULL),
	(5, NULL);
/*!40000 ALTER TABLE `shopping_cart` ENABLE KEYS */;


-- Дамп структуры для таблица secondhand_game_shop_generated.shopping_carts_games
CREATE TABLE IF NOT EXISTS `shopping_carts_games` (
  `shopping_cart_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  PRIMARY KEY (`shopping_cart_id`,`game_id`),
  KEY `IDX_F195CD3C45F80CD` (`shopping_cart_id`),
  KEY `IDX_F195CD3CE48FD905` (`game_id`),
  CONSTRAINT `FK_F195CD3C45F80CD` FOREIGN KEY (`shopping_cart_id`) REFERENCES `shopping_cart` (`id`),
  CONSTRAINT `FK_F195CD3CE48FD905` FOREIGN KEY (`game_id`) REFERENCES `game` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы secondhand_game_shop_generated.shopping_carts_games: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `shopping_carts_games` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopping_carts_games` ENABLE KEYS */;


-- Дамп структуры для таблица secondhand_game_shop_generated.shop_cart_game
CREATE TABLE IF NOT EXISTS `shop_cart_game` (
  `shopping_cart_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `seller_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`shopping_cart_id`,`game_id`),
  KEY `IDX_D579BF3E45F80CD` (`shopping_cart_id`),
  KEY `IDX_D579BF3E8DE820D9` (`seller_id`),
  KEY `IDX_D579BF3EE48FD905` (`game_id`),
  CONSTRAINT `FK_D579BF3E45F80CD` FOREIGN KEY (`shopping_cart_id`) REFERENCES `shopping_cart` (`id`),
  CONSTRAINT `FK_D579BF3E8DE820D9` FOREIGN KEY (`seller_id`) REFERENCES `shop_cart_seller` (`id`),
  CONSTRAINT `FK_D579BF3EE48FD905` FOREIGN KEY (`game_id`) REFERENCES `game` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы secondhand_game_shop_generated.shop_cart_game: ~5 rows (приблизительно)
/*!40000 ALTER TABLE `shop_cart_game` DISABLE KEYS */;
INSERT INTO `shop_cart_game` (`shopping_cart_id`, `game_id`, `seller_id`) VALUES
	(5, 10, 1),
	(5, 4, 2),
	(5, 11, 3),
	(5, 12, 3),
	(5, 15, 3);
/*!40000 ALTER TABLE `shop_cart_game` ENABLE KEYS */;


-- Дамп структуры для таблица secondhand_game_shop_generated.shop_cart_seller
CREATE TABLE IF NOT EXISTS `shop_cart_seller` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shopping_cart_id` int(11) DEFAULT NULL,
  `seller_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `h_idx` (`shopping_cart_id`,`seller_id`),
  KEY `IDX_27E947B345F80CD` (`shopping_cart_id`),
  KEY `IDX_27E947B38DE820D9` (`seller_id`),
  CONSTRAINT `FK_27E947B345F80CD` FOREIGN KEY (`shopping_cart_id`) REFERENCES `shopping_cart` (`id`),
  CONSTRAINT `FK_27E947B38DE820D9` FOREIGN KEY (`seller_id`) REFERENCES `seller` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы secondhand_game_shop_generated.shop_cart_seller: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `shop_cart_seller` DISABLE KEYS */;
INSERT INTO `shop_cart_seller` (`id`, `shopping_cart_id`, `seller_id`) VALUES
	(3, 5, 2),
	(2, 5, 6),
	(1, 5, 8);
/*!40000 ALTER TABLE `shop_cart_seller` ENABLE KEYS */;


-- Дамп структуры для таблица secondhand_game_shop_generated.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isActive` tinyint(1) DEFAULT NULL,
  `username` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `roles` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discr` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы secondhand_game_shop_generated.user: ~6 rows (приблизительно)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `isActive`, `username`, `password`, `email`, `roles`, `discr`) VALUES
	(2, NULL, 'seller_1', '$2y$12$f.OEshZMmrFdlh7JQ5Ss7evFgsJUfIQOcrewz4RBUrNMDMFuZz1Se', 'seller_1@mail.com', 'ROLE_SELLER', 'seller'),
	(3, NULL, 'customer_1', '$2y$12$pJ5cVlPtD3b7nT/LJ.d.qeclDw2uf6I0WrNz2MDSyl8PZEaCmQt1q', 'customer_1@mail.com', 'ROLE_CUSTOMER', 'customer'),
	(4, NULL, 'customer_2', '$2y$12$NKhyFomBLL7T1f64dFDeYOr7PGdVOlKIx38iu8T1uy3OBAXPktNim', 'customer_2@mail.com', 'ROLE_CUSTOMER', 'customer'),
	(5, 1, 'Admin_1', '$2y$12$ocPTodmasgtYhgkg8l4XH./8eiWVJlSDE52bYPIZbASeOh9iPQJWi', 'admin1@mail.com', 'ROLE_ADMIN', 'admin'),
	(6, NULL, 'seller_3', '$2y$12$kK61gE/skMvRSKfcmyh7P.lLl0LAhfJEMqFyKnQnsL4whaIziJxei', 'seller_3@mail.com', 'ROLE_SELLER', 'seller'),
	(8, NULL, 'seller_7', '$2y$12$AOZXbApzzh2GFrg1fQn2KeFdtcLvyyWm7yr/IWBzZpVY9r1dRzLdi', 'seller_7@mail.com', 'ROLE_SELLER', 'seller');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
