-- MySQL dump 10.13  Distrib 8.0.26, for Linux (x86_64)
--
-- Host: localhost    Database: MagentoProject
-- ------------------------------------------------------
-- Server version	8.0.26-0ubuntu0.20.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `shopsmanage_shops_table`
--

DROP TABLE IF EXISTS `shopsmanage_shops_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsmanage_shops_table` (
  `image` varchar(255) NOT NULL,
  `shop_id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'Shop ID',
  `title` varchar(100) NOT NULL COMMENT 'Shop Title',
  `address` varchar(255) NOT NULL COMMENT 'Shop Address',
  `open_time` varchar(5) NOT NULL COMMENT 'Shop Open Time',
  `town` varchar(50) NOT NULL COMMENT 'Shop Town',
  `content` text COMMENT 'Shop Description',
  `creation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Shop Creation Time',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Shop Modification Time',
  `is_active` smallint NOT NULL DEFAULT '0' COMMENT 'Is Shop Active',
  `meta_title` varchar(70) DEFAULT NULL COMMENT 'Shop Meta Title',
  `meta_keys` varchar(255) DEFAULT NULL COMMENT 'Shop Meta Keywords',
  `meta_descr` varchar(255) DEFAULT NULL COMMENT 'Shop Meta description',
  `close_time` varchar(5) NOT NULL COMMENT 'Shop Close Time',
  `tel` varchar(16) NOT NULL COMMENT 'Shop Telephone',
  PRIMARY KEY (`shop_id`),
  FULLTEXT KEY `SHOPSMANAGE_SHOPS_TABLE_TITLE_ADDRESS_TOWN_CONTENT` (`title`,`address`,`town`,`content`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3 COMMENT='Shops Manage Table';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsmanage_shops_table`
--

LOCK TABLES `shopsmanage_shops_table` WRITE;
/*!40000 ALTER TABLE `shopsmanage_shops_table` DISABLE KEYS */;
INSERT INTO `shopsmanage_shops_table` VALUES ('photo_2022-05-17_19-17-19.jpg',1,'ReaSon Сочи',' 567344 Краснодарский край, г.Сочи , пл. Театральная 32','12:00','Сочи','<p>Современный брендовый магазин&nbsp; модной молодежной одежды представляет коолецию товаров совсего света. Идеальное сочетание практичности, модных тенденций, надежности и незабываемого облика предлагает вам ReaSon. Мужская одежда, женская одежда, детская одежда, молодежная одежда. В этом сезоне широкий ассортимент расцветок и моделей фасонов и направлений.</p>','2021-09-05 09:43:49','2021-09-05 09:43:49',1,'Title','Some intersting keyword tifht thtere ','Some description','17:00','+74426783423'),('photo_2022-05-17_19-28-12.jpg',2,'Luma REAL wear','г. Волгодонск, ул. Некрасовская 17','13:00','Волгодонск','<p>Luma REAL wear - это нечто новое и грандиозное в мире моды и одежды. Современнная коллекция для женщин и их детей. Детская одежда, женская одежда, парфюмерия и косметика.&nbsp;</p>','2021-09-05 09:49:45','2021-09-05 09:49:45',1,NULL,NULL,NULL,'17:00','88005553535'),('photo_2022-05-17_18-39-46.jpg',4,'Luma INCITY','г. Ростов-на-Дону, проспект Михаила Нагибина 32/2, ТРЦ \"Горизонт\"','13:00','Ростов-на-Дону','<p style=\"text-align: center;\"><strong><span style=\"font-size: 24px;\"><span style=\"color: #800080;\">INCITY</span> — мода большого города!</span></strong></p>\r\n<p><span style=\"font-size: 16px;\">Многообразие коллекций бренда позволяет подобрать подходящий стиль для любого случая по доступным ценам: будь то блузка и юбка для делового дресс-кода или футерные костюмы для занятий спортом и прогулок по городу, платья на каждый день и для особого случая.</span></p>\r\n<p><span style=\"font-size: 16px;\">Имеется в наличии:</span></p>\r\n<table style=\"border-collapse: collapse; width: 100%; height: 127px;\" border=\"1\">\r\n<tbody>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 50%; height: 19px; text-align: center; background-color: #dcb5e8;\"><strong>Название категории</strong></td>\r\n<td style=\"width: 25%; text-align: center; height: 19px; background-color: #dcb5e8;\"><strong>Доступные размеры</strong></td>\r\n<td style=\"width: 25%; text-align: center; height: 19px; background-color: #dcb5e8;\"><strong>Материалы</strong></td>\r\n</tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 50%; height: 18px; vertical-align: middle; background-color: #ebebeb;\">\r\n<p><span style=\"font-size: 16px;\">Женская одежда</span></p>\r\n</td>\r\n<td style=\"width: 25%; height: 18px; vertical-align: middle; background-color: #ebebeb;\">От XS до XLL</td>\r\n<td style=\"width: 25%; vertical-align: middle; height: 18px; background-color: #ebebeb;\">Хлопок, ситец, шёлк</td>\r\n</tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 50%; height: 18px; vertical-align: middle; background-color: #ebebeb;\">\r\n<p><span style=\"font-size: 16px;\">Мужская одежда</span></p>\r\n</td>\r\n<td style=\"width: 25%; height: 18px; vertical-align: middle; background-color: #ebebeb;\">От S до XL&nbsp;</td>\r\n<td style=\"width: 25%; vertical-align: middle; height: 18px; background-color: #ebebeb;\">Хлопок, ситец</td>\r\n</tr>\r\n<tr style=\"height: 72px;\">\r\n<td style=\"width: 50%; vertical-align: middle; height: 72px; background-color: #ebebeb;\">\r\n<p><span style=\"font-size: 16px;\">Аксессуары</span></p>\r\n</td>\r\n<td style=\"width: 25%; vertical-align: middle; height: 72px; background-color: #ebebeb;\">Любые</td>\r\n<td style=\"width: 25%; vertical-align: middle; height: 72px; background-color: #ebebeb;\">Кожа, Эко-кожа, Стекло, Искуственный драг. камень</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>\r\n<p><span style=\"font-size: 16px;\">INCITY следует мировым трендам, использует современные материалы и натуральные ткани, ведет постоянный контроль качества.</span></p>\r\n<h3 style=\"text-align: center;\"><span style=\"font-size: 20px;\">Всё ради вас - дорогие покупатели!</span></h3>\r\n<p style=\"text-align: center;\"><span style=\"font-size: 16px;\"><img src=\"{{media url=&quot;wysiwyg/rejting-top-10-internet-magazinov-odezhdy.jpg&quot;}}\" alt=\"\" width=\"417\" height=\"222\"> &nbsp;<img src=\"{{media url=&quot;wysiwyg/female-customer-standing-racks-clothes-800054.jpg&quot;}}\" alt=\"\" width=\"333\" height=\"222\"></span></p>\r\n<p>&nbsp;</p>','2022-04-22 09:59:53','2022-05-20 07:11:48',1,'Luma INCITY','мода платья блузки юбки INCITY стиль','Luma INCITY — мода большого города!','22:00','+78612042565'),('photo_2022-05-17_17-31-10.jpg',6,'LUMA-BonPrix','г.Воронеж, 390013, Москоское шоссе 21, ТРЦ \"Премьер\"','10:00','Воронеж','<p>Этот филиал прелагает <strong>качественную одежду</strong> для женщин, мужчин и детей.</p>\r\n<p>Работает с 1999 года. Предлагает свои услуги для миллионов счасливых покупателей.</p>\r\n<p><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"{{media url=&quot;wysiwyg/bp-logo.png&quot;}}\" alt=\"\" width=\"113\" height=\"104\"></p>','2022-04-30 13:37:12','2022-04-30 13:37:12',1,NULL,'Сумки',NULL,'22:00','+74912575468'),('photo_2022-05-17_19-08-26.jpg',7,'ReaSon','312333  г.Воронеж, Литейная улица, 17','09:00','Воронеж','<p>Современный брендовый магазин&nbsp; модной молодежной одежды представляет коолецию товаров совсего света. Идеальное сочетание практичности, модных тенденций, надежности и незабываемого облика предлагает вам ReaSon. Мужская одежда, женская одежда, молодежная одежда. В этом сезоне широкий ассортимент расцветок и моделей</p>','2022-04-30 13:37:58','2022-04-30 13:37:58',1,'Some new interesting shop',NULL,NULL,'20:00','+79515026699'),('photo_2022-05-17_19-39-44.jpg',8,'Luma Pony','г.Таганрог, ул. Дзержинского, 45','09:00','Таганрог','<p>Одежда детская для мальчиков и девочек,&nbsp; игрушки, детская косметика, товары для дом и сладости, кондитерские изделя.</p>','2022-05-02 14:23:28','2022-05-02 17:03:05',1,NULL,NULL,NULL,'16:00','84235313245'),('photo_2022-05-17_17-56-46.jpg',11,'Luma INCITY','г. Краснодар, Октябрьской революции ул., дом 362','10:00','Краснодар','<p>Luma INCITY Краснодар - новейший филиал, центр притяения всех горожан и гостей региона.</p>\r\n<p>Многообразие коллекций бренда позволяет подобрать подходящий стиль для любого случая по доступным ценам: будь то блузка и юбка для делового дресс-кода или футерные костюмы для занятий спортом и прогулок по городу, платья на каждый день и для особого случая.<br>INCITY следует мировым трендам, использует современные материалы и натуральные ткани, ведет постоянный контроль качества.</p>','2022-05-17 14:57:13','2022-05-20 07:11:48',1,NULL,NULL,NULL,'19:00','+79192344571'),('photo_2022-05-17_18-54-52.jpg',12,'Luma Wear aii','г. Рязань, Больших Просторов ул., дом 2','00:00','Рязань','<p>&nbsp;Wear aii филиал Рязань прелагает&nbsp; <strong>качественную одежду</strong>&nbsp; <strong>и аксессуары</strong> для женщин, мужчин и детей.&nbsp;</p>\r\n<p>Работает с 2000 года. Предлагает свои услуги круглосуточно для миллионов счасливых покупателей и туристов.</p>','2022-05-17 15:03:53','2022-05-17 15:03:53',1,NULL,NULL,NULL,'23:59','+79655344571'),('photo_2022-05-17_19-03-26.jpg',13,'Luma Women\'s world','Ростовская обл., г.Таганрог, пл.Мира 54','09:00','Таганрог','<p>Women\'s world — мода большого города! Здесь представленная широчайшая коллекция всех товаров Luma. Женская одежда, , аксессуары, обувь и головные уборы, мужская одежда&nbsp; и детска одежда. Все найдется здесь</p>','2022-05-17 15:13:46','2022-05-17 15:13:46',1,NULL,NULL,NULL,'19:00','+76505334590'),('',14,'Luma INCITY','г. Краснодар, Октябрьской революции ул., дом 362','10:00','Краснодар','<p>Luma INCITY Краснодар - новейший филиал, центр притяения всех горожан и гостей региона.</p>\r\n<p>Многообразие коллекций бренда позволяет подобрать подходящий стиль для любого случая по доступным ценам: будь то блузка и юбка для делового дресс-кода или футерные костюмы для занятий спортом и прогулок по городу, платья на каждый день и для особого случая.<br>INCITY следует мировым трендам, использует современные материалы и натуральные ткани, ведет постоянный контроль качества.</p>','2022-05-18 13:51:04','2022-05-18 18:03:14',0,NULL,NULL,NULL,'19:00','+79192344571'),('',15,'Новый филиал','г. Краснодар, Октябрьской революции ул., дом 362','13:00','Краснодар',NULL,'2022-05-18 19:13:49','2022-05-18 19:13:49',1,NULL,NULL,NULL,'19:00','+79192344571');
/*!40000 ALTER TABLE `shopsmanage_shops_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsmanage_shop_product`
--

DROP TABLE IF EXISTS `shopsmanage_shop_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsmanage_shop_product` (
  `shop_id` int unsigned NOT NULL DEFAULT '0' COMMENT 'Shop ID',
  `product_id` int unsigned NOT NULL DEFAULT '0' COMMENT 'Product ID',
  PRIMARY KEY (`shop_id`,`product_id`),
  KEY `SHOPSMANAGE_SHOP_PRODUCT_PRODUCT_ID` (`product_id`),
  CONSTRAINT `SHOPSMANAGE_SHOP_PRD_PRD_ID_CAT_PRD_ENTT_ENTT_ID` FOREIGN KEY (`product_id`) REFERENCES `catalog_product_entity` (`entity_id`) ON DELETE CASCADE,
  CONSTRAINT `SHOPSMANAGE_SHOP_PRODUCT_SHOP_ID_SHOPSMANAGE_SHOPS_TABLE_SHOP_ID` FOREIGN KEY (`shop_id`) REFERENCES `shopsmanage_shops_table` (`shop_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Catalog Product To Shop Linkage Table';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsmanage_shop_product`
--

LOCK TABLES `shopsmanage_shop_product` WRITE;
/*!40000 ALTER TABLE `shopsmanage_shop_product` DISABLE KEYS */;
INSERT INTO `shopsmanage_shop_product` VALUES (6,1),(1,2),(2,2),(6,2),(1,3),(2,3),(1,4),(2,4),(6,4),(4,6),(4,10),(4,11),(4,13),(4,14);
/*!40000 ALTER TABLE `shopsmanage_shop_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsmanage_shop_store`
--

DROP TABLE IF EXISTS `shopsmanage_shop_store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsmanage_shop_store` (
  `shop_id` int unsigned NOT NULL,
  `store_id` smallint unsigned NOT NULL COMMENT 'Store ID',
  PRIMARY KEY (`shop_id`,`store_id`),
  KEY `SHOPSMANAGE_SHOP_STORE_STORE_ID` (`store_id`),
  CONSTRAINT `SHOPSMANAGE_SHOP_STORE_SHOP_ID_SHOPSMANAGE_SHOPS_TABLE_SHOP_ID` FOREIGN KEY (`shop_id`) REFERENCES `shopsmanage_shops_table` (`shop_id`) ON DELETE CASCADE,
  CONSTRAINT `SHOPSMANAGE_SHOP_STORE_STORE_ID_STORE_STORE_ID` FOREIGN KEY (`store_id`) REFERENCES `store` (`store_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Shop To Store Linkage Table';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsmanage_shop_store`
--

LOCK TABLES `shopsmanage_shop_store` WRITE;
/*!40000 ALTER TABLE `shopsmanage_shop_store` DISABLE KEYS */;
INSERT INTO `shopsmanage_shop_store` VALUES (1,1),(2,1),(6,1),(7,1),(11,1),(12,1),(13,1),(14,1),(15,1),(4,1),(8,2);
/*!40000 ALTER TABLE `shopsmanage_shop_store` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsmanage_review`
--

DROP TABLE IF EXISTS `shopsmanage_review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsmanage_review` (
  `review_id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'Review ID',
  `shop_id` int unsigned NOT NULL DEFAULT '0' COMMENT 'Shop ID',
  `title` varchar(255) NOT NULL COMMENT 'Title',
  `detail` text NOT NULL COMMENT 'Detail description',
  `nickname` varchar(100) NOT NULL COMMENT 'User nickname',
  `customer_id` int unsigned DEFAULT NULL COMMENT 'Customer ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Review Creation Time',
  `is_approved` smallint NOT NULL DEFAULT '0' COMMENT 'Is Review Approved',
  PRIMARY KEY (`review_id`),
  KEY `SHOPSMANAGE_REVIEW_CUSTOMER_ID_CUSTOMER_ENTITY_ENTITY_ID` (`customer_id`),
  KEY `SHOPSMANAGE_REVIEW_SHOP_ID_SHOPSMANAGE_SHOPS_TABLE_SHOP_ID` (`shop_id`),
  CONSTRAINT `SHOPSMANAGE_REVIEW_CUSTOMER_ID_CUSTOMER_ENTITY_ENTITY_ID` FOREIGN KEY (`customer_id`) REFERENCES `customer_entity` (`entity_id`) ON DELETE SET NULL,
  CONSTRAINT `SHOPSMANAGE_REVIEW_SHOP_ID_SHOPSMANAGE_SHOPS_TABLE_SHOP_ID` FOREIGN KEY (`shop_id`) REFERENCES `shopsmanage_shops_table` (`shop_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3 COMMENT='Shops Reviews';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsmanage_review`
--

LOCK TABLES `shopsmanage_review` WRITE;
/*!40000 ALTER TABLE `shopsmanage_review` DISABLE KEYS */;
INSERT INTO `shopsmanage_review` VALUES (3,1,'awd','awdwd','Rodion',2,'2022-04-17 20:55:46',0),(4,1,'hihlh','hipnbhin\r\nihnpohjpo\r\njpohnpihnp\r\n\'\r\n\r\nkinhiphnp\r\njpojnj','Rodion',2,'2022-04-17 21:00:01',0),(5,1,'awdwd','awdawd','awdwad',2,'2022-04-17 21:07:41',0),(6,1,'awdawd','awd','awdwad',2,'2022-04-17 21:08:51',1),(7,1,'awdawd','awd','awdwad',2,'2022-04-17 21:13:07',0),(8,1,'awdawd','awd','awdwad',2,'2022-04-17 21:13:37',1),(9,1,'awd','awdwd','awd',2,'2022-04-17 21:14:25',1),(10,2,'Cool stuff','Ok','Rodion',2,'2022-04-18 19:17:18',0),(11,2,'ANother ','Another review','Rodion',2,'2022-04-18 19:18:04',0),(12,4,'Отличный магазин','Великолепный магазин, рекомендую','Rodion',2,'2022-05-02 13:37:28',0),(13,4,'Великолпно','Великолепный магазин, классные товары','Rodion',2,'2022-05-02 21:27:59',0),(14,4,'Ну такое','Ну такое себе','Rodion',2,'2022-05-02 21:28:27',0),(15,1,'Суммора','фцвфцвцфв','Rodion',2,'2022-05-04 20:18:21',1),(16,1,'Классный магазин','Супер крутой магазин','Rodion',2,'2022-05-08 08:29:48',0),(17,1,'Великолепный филиал','Самый лучший филиал!','Rodion',2,'2022-05-08 16:26:00',0),(18,4,'Классный филиал','Классный филиал','Rodion',NULL,'2022-05-08 18:53:30',0),(19,4,'Хорошее обслуживание, но мало товаров','Мне понравился сервис этого филиала - заботливый и ответственный.  Но к сожалению выбор товаров небольшой.','Антон Зотов',2,'2022-05-18 14:29:12',1),(21,4,'Все товары - есть!','Все товары, данного филиала, объявленные на сайте - действительно были в наличии - ставлю +.','Сёмен Иванович',2,'2022-05-18 14:32:08',1),(22,4,'Не увидела здесь ничего нового','Искала целый час - не нашла ничего интересного для себя','Мария',2,'2022-05-18 14:34:34',0),(23,4,'Нормальное соотношение цены и качества','Ну что обычный магазин одежды - нормально соотношение цены и качества','Сергей',2,'2022-05-18 14:36:35',1),(24,4,'Неплохой выбор товаров','Нашёл здесь, то что хотел - хороший выбор!','Антон',2,'2022-05-18 16:58:33',0);
/*!40000 ALTER TABLE `shopsmanage_review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsmanage_rating`
--

DROP TABLE IF EXISTS `shopsmanage_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsmanage_rating` (
  `rating_id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'Rating ID',
  `name` varchar(100) NOT NULL COMMENT 'Rating Name',
  `stars_num` int unsigned NOT NULL COMMENT 'Rating Num Starts',
  PRIMARY KEY (`rating_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COMMENT='Shops Rating Types';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsmanage_rating`
--

LOCK TABLES `shopsmanage_rating` WRITE;
/*!40000 ALTER TABLE `shopsmanage_rating` DISABLE KEYS */;
INSERT INTO `shopsmanage_rating` VALUES (2,'Разнообразие товаров',5),(3,'Качество обслуживания',6),(8,'Скорость обслуживания',5);
/*!40000 ALTER TABLE `shopsmanage_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsmanage_review_rating`
--

DROP TABLE IF EXISTS `shopsmanage_review_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsmanage_review_rating` (
  `review_id` int unsigned NOT NULL DEFAULT '0' COMMENT 'Review ID',
  `rating_id` int unsigned NOT NULL DEFAULT '0' COMMENT 'Rating ID',
  `value` int unsigned NOT NULL DEFAULT '0' COMMENT 'Vote Rating Value',
  `entity_id` int NOT NULL AUTO_INCREMENT COMMENT 'Entity ID',
  PRIMARY KEY (`entity_id`),
  UNIQUE KEY `SHOPSMANAGE_REVIEW_RATING_REVIEW_ID_RATING_ID` (`review_id`,`rating_id`),
  KEY `SHOPSMANAGE_REVIEW_RATING_RATING_ID_SHOPSMANAGE_RATING_RATING_ID` (`rating_id`),
  CONSTRAINT `SHOPSMANAGE_REVIEW_RATING_RATING_ID_SHOPSMANAGE_RATING_RATING_ID` FOREIGN KEY (`rating_id`) REFERENCES `shopsmanage_rating` (`rating_id`) ON DELETE CASCADE,
  CONSTRAINT `SHOPSMANAGE_REVIEW_RATING_REVIEW_ID_SHOPSMANAGE_REVIEW_REVIEW_ID` FOREIGN KEY (`review_id`) REFERENCES `shopsmanage_review` (`review_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb3 COMMENT='Shops Reviews Rating';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsmanage_review_rating`
--

LOCK TABLES `shopsmanage_review_rating` WRITE;
/*!40000 ALTER TABLE `shopsmanage_review_rating` DISABLE KEYS */;
INSERT INTO `shopsmanage_review_rating` VALUES (3,2,4,1),(3,3,6,2),(4,2,4,3),(4,3,5,4),(5,2,1,5),(5,3,4,6),(6,2,4,7),(6,3,5,8),(7,2,4,9),(7,3,5,10),(8,2,4,11),(8,3,5,12),(9,2,5,13),(9,3,5,14),(10,2,4,15),(10,3,5,16),(11,2,1,18),(11,3,3,19),(12,2,4,21),(12,3,3,22),(13,2,4,23),(13,3,5,24),(14,2,4,25),(14,3,3,26),(15,2,3,39),(15,3,4,40),(16,2,4,41),(16,3,3,42),(16,8,5,43),(17,3,4,44),(17,2,4,45),(17,8,4,46),(18,3,4,47),(18,2,4,48),(18,8,4,49),(19,3,6,50),(19,2,2,51),(19,8,3,52),(21,3,4,56),(21,2,5,57),(21,8,3,58),(22,3,2,59),(22,2,2,60),(22,8,3,61),(23,3,5,62),(23,2,4,63),(23,8,3,64),(24,3,3,65),(24,2,5,66),(24,8,4,67);
/*!40000 ALTER TABLE `shopsmanage_review_rating` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-05-20 10:17:53
