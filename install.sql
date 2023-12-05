-- MySQL dump 10.13  Distrib 5.1.48, for unknown-linux-gnu (x86_64)
--
-- Host: localhost    Database: qdm170255639_db
-- ------------------------------------------------------
-- Server version	5.1.48-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cmsx_admin`
--

DROP TABLE IF EXISTS `cmsx_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmsx_admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `user_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户名',
  `nickname` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户昵称',
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '密码',
  `isvalid` tinyint(1) NOT NULL COMMENT '是否启用',
  `add_time` datetime NOT NULL COMMENT '添加账号时间',
  `last_login_time` datetime NOT NULL COMMENT '上次登录时间',
  `ip_address` varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_master` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmsx_admin`
--

LOCK TABLES `cmsx_admin` WRITE;
/*!40000 ALTER TABLE `cmsx_admin` DISABLE KEYS */;
INSERT INTO `cmsx_admin` VALUES (1,'hnek2017','管理员','4412806616abc58f5eb4c1d6f2182d76',1,'2016-03-01 00:00:00','2023-01-31 15:50:28','222.137.24.224',1),(3,'lingpao','操作员','a6e78d7fbd3906b0daccfaf2ba4255e4',1,'2020-03-23 09:07:55','2023-01-30 15:42:11','182.119.37.225',0);
/*!40000 ALTER TABLE `cmsx_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmsx_admin_site`
--

DROP TABLE IF EXISTS `cmsx_admin_site`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmsx_admin_site` (
  `rele_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  PRIMARY KEY (`rele_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmsx_admin_site`
--

LOCK TABLES `cmsx_admin_site` WRITE;
/*!40000 ALTER TABLE `cmsx_admin_site` DISABLE KEYS */;
INSERT INTO `cmsx_admin_site` VALUES (1,3,1);
/*!40000 ALTER TABLE `cmsx_admin_site` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmsx_attachment`
--

DROP TABLE IF EXISTS `cmsx_attachment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmsx_attachment` (
  `attachment_id` int(11) NOT NULL AUTO_INCREMENT,
  `catid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `path` varchar(200) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`attachment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=741 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmsx_attachment`
--

LOCK TABLES `cmsx_attachment` WRITE;
/*!40000 ALTER TABLE `cmsx_attachment` DISABLE KEYS */;
INSERT INTO `cmsx_attachment` VALUES (9,0,'kf_logo.jpg','data/hnek/Upload/201802/25/5a922d8a2b6e2.jpg',1519529354),(10,0,'guandian_07.jpg','data/hnek/Upload/201802/25/5a9256cc3b926.jpg',1519539916),(11,0,'anli_03.jpg','data/hnek/Upload/201802/25/5a925a41359e8.jpg',1519540801),(12,0,'1520238247(1).png','data/hnek/Upload/201803/05/5a9d0182b736d.png',1520238978),(13,0,'1520238370(1).png','data/hnek/Upload/201803/05/5a9d04ffb7bc0.png',1520239871),(14,0,'1520238391(1).png','data/hnek/Upload/201803/05/5a9d056ab94f5.png',1520239978),(15,0,'1520238445(1).png','data/hnek/Upload/201803/05/5a9d0621c50a8.png',1520240161),(16,0,'1520238515(1).png','data/hnek/Upload/201803/05/5a9d06954ea21.png',1520240277),(17,0,'banenr.jpg','data/hnek/Upload/201803/09/5aa1dbcf1e6d6.jpg',1520557007),(18,0,'top_bj.jpg','data/hnek/Upload/201803/09/5aa1dbdeb7a3c.jpg',1520557022),(19,0,'banenr.jpg','data/hnek/Upload/201803/09/5aa1dbebb8bac.jpg',1520557035),(20,0,'top.jpg','data/hnek/Upload/201803/12/5aa621dc4afbf.jpg',1520837084),(21,0,'333.jpg','data/hnek/Upload/201803/12/5aa6232f2d39c.jpg',1520837423),(22,0,'34f0e6353a79e98ca0d865c00c5a295e.jpg','data/hnek//Upload/201803/12/5aa65a69d97e3.jpg',1520851561),(23,0,'986cf18187c0c63ec9fb3920c63fae07.jpg','data/hnek//Upload/201803/12/5aa65bb29e56c.jpg',1520851890),(24,0,'设计案例头.jpg','data/hnek//Upload/201803/12/5aa65bdd53704.jpg',1520851933),(25,0,'34f0e6353a79e98ca0d865c00c5a295e.jpg','data/hnek//Upload/201803/12/5aa65c5e10ead.jpg',1520852062),(26,0,'986cf18187c0c63ec9fb3920c63fae07.jpg','data/hnek//Upload/201803/12/5aa65c683ac2a.jpg',1520852072),(27,0,'34f0e6353a79e98ca0d865c00c5a295e.jpg','data/hnek//Upload/201803/12/5aa65d7b07523.jpg',1520852347),(28,0,'8.jpg','data/hnek/Upload/201803/17/5aace73bcf035.jpg',1521280827),(29,0,'12.jpg','data/hnek/Upload/201803/17/5aace76b78721.jpg',1521280875),(30,0,'11.jpg','data/hnek/Upload/201803/17/5aace77eb0954.jpg',1521280894),(31,0,'9.jpg','data/hnek/Upload/201803/17/5aace790161a3.jpg',1521280912),(32,0,'17.jpg','data/hnek/Upload/201803/17/5aace7d184d75.jpg',1521280977),(33,0,'13.jpg','data/hnek/Upload/201803/17/5aace7e409908.jpg',1521280996),(34,0,'19.jpg','data/hnek/Upload/201803/17/5aace7f86f4f8.jpg',1521281016),(35,0,'4.jpg','data/hnek/Upload/201803/17/5aace80e1abae.jpg',1521281038),(36,0,'6.jpg','data/hnek/Upload/201803/17/5aace83f39895.jpg',1521281087),(37,0,'2.jpg','data/hnek/Upload/201803/17/5aace8509a460.jpg',1521281104),(38,0,'1.jpg','data/hnek/Upload/201803/17/5aace87f2347d.jpg',1521281151),(39,0,'14.jpg','data/hnek/Upload/201803/17/5aace8c77e76e.jpg',1521281223),(40,0,'5.jpg','data/hnek/Upload/201803/17/5aace8dc770ed.jpg',1521281244),(41,0,'7.jpg','data/hnek/Upload/201803/17/5aace8f9bcb99.jpg',1521281273),(42,0,'10.jpg','data/hnek/Upload/201803/17/5aace911caecb.jpg',1521281297),(43,0,'3.jpg','data/hnek/Upload/201803/17/5aace93e4bb5e.jpg',1521281342),(44,0,'4.jpg','data/hnek/Upload/201803/20/5ab08537eb093.jpg',1521517879),(45,0,'timg (4).jpeg','data/hnek/Upload/201803/20/5ab08576e1c15.jpeg',1521517942),(46,0,'timg (2).jpeg','data/hnek/Upload/201803/20/5ab085bbcb4d9.jpeg',1521518011),(47,0,'timg (5).jpeg','data/hnek/Upload/201803/20/5ab085d43f325.jpeg',1521518036),(48,0,'timg (6).jpeg','data/hnek/Upload/201803/20/5ab086c3c8dc0.jpeg',1521518275),(49,0,'timg (6).jpeg','data/hnek/Upload/201803/20/5ab0870522066.jpeg',1521518341),(50,0,'timg (7).jpeg','data/hnek/Upload/201803/20/5ab087f569bfc.jpeg',1521518581),(51,0,'timg (8).jpeg','data/hnek/Upload/201803/20/5ab088c0790f4.jpeg',1521518784),(52,0,'4.jpg','data/hnek/Upload/201803/20/5ab08926a81e0.jpg',1521518886),(53,0,'timg (4).jpeg','data/hnek/Upload/201803/20/5ab0897532912.jpeg',1521518965),(54,0,'timg.jpeg','data/hnek/Upload/201803/20/5ab089945d8cd.jpeg',1521518996),(55,0,'中金汇融logo.jpg','data/hnek/Upload/201803/20/5ab08a9772014.jpg',1521519255),(56,0,'中金汇融logo.jpg','data/hnek/Upload/201803/20/5ab08ac4da714.jpg',1521519300),(57,0,'3333.jpg','data/hnek/Upload/201803/20/5ab0b258db1e5.jpg',1521529432),(58,0,'3333.jpg','data/hnek/Upload/201803/20/5ab0b2aee10d9.jpg',1521529518),(59,0,'ti未完成mg.jpeg','data/hnek/Upload/201803/20/5ab0b37ca454a.jpeg',1521529724),(60,0,'timg (9).jpeg','data/hnek/Upload/201803/20/5ab0b38f0e731.jpeg',1521529743),(61,0,'999.jpg','data/hnek/Upload/201803/20/5ab0bc82d1a61.jpg',1521532034),(62,0,'999.jpg','data/hnek/Upload/201803/20/5ab0bcd26fd4a.jpg',1521532114),(63,0,'timg (3).jpeg','data/hnek/Upload/201803/20/5ab0bd17be705.jpeg',1521532183),(64,0,'关于领跑_01.jpg','data/hnek//Upload/201803/22/5ab2c5e224c62.jpg',1521665506),(65,0,'关于领跑_02.jpg','data/hnek//Upload/201803/22/5ab2c5e25a79e.jpg',1521665506),(66,0,'关于领跑_03.jpg','data/hnek//Upload/201803/22/5ab2c5e27ca6a.jpg',1521665506),(67,0,'关于领跑_04.jpg','data/hnek//Upload/201803/22/5ab2c5e29aacd.jpg',1521665506),(68,0,'关于领跑_05.jpg','data/hnek//Upload/201803/22/5ab2c5e2bba5a.jpg',1521665506),(69,0,'关于领跑_06.jpg','data/hnek//Upload/201803/22/5ab2c5e2dc183.jpg',1521665506),(70,0,'关于领跑_07.jpg','data/hnek//Upload/201803/22/5ab2c5e31848e.jpg',1521665507),(71,0,'关于领跑_08.jpg','data/hnek//Upload/201803/22/5ab2c5e33bec9.jpg',1521665507),(72,0,'关于领跑_09.jpg','data/hnek//Upload/201803/22/5ab2c5e35e966.jpg',1521665507),(73,0,'关于领跑_10.jpg','data/hnek//Upload/201803/22/5ab2c5e37be83.jpg',1521665507),(74,0,'关于领跑_11.jpg','data/hnek//Upload/201803/22/5ab2c5e3a7d17.jpg',1521665507),(75,0,'关于领跑_01.jpg','data/hnek//Upload/201803/22/5ab2c65b0e804.jpg',1521665627),(76,0,'关于领跑_01.jpg','data/hnek//Upload/201803/22/5ab2c69e5d2fc.jpg',1521665694),(77,0,'关于领跑_02.jpg','data/hnek//Upload/201803/22/5ab2c79c26282.jpg',1521665948),(78,0,'5aa6232f2d39c.jpg','data/hnek/Upload/201804/13/5ad084c8d72b1.jpg',1523614920),(79,0,'关于领跑_01.jpg','data/hnek//Upload/201804/16/5ad4849803136.jpg',1523877016),(80,0,'关于领跑_02.jpg','data/hnek//Upload/201804/16/5ad484985ab42.jpg',1523877016),(81,0,'关于领跑_03.jpg','data/hnek//Upload/201804/16/5ad4849891625.jpg',1523877016),(82,0,'关于领跑_04.jpg','data/hnek//Upload/201804/16/5ad48498b3cd8.jpg',1523877016),(83,0,'关于领跑_05.jpg','data/hnek//Upload/201804/16/5ad48499141f0.jpg',1523877017),(84,0,'关于领跑_06.jpg','data/hnek//Upload/201804/16/5ad484994f31a.jpg',1523877017),(85,0,'关于领跑_01.jpg','data/hnek//Upload/201804/17/5ad5bcf66febe.jpg',1523956982),(86,0,'关于领跑_02.jpg','data/hnek//Upload/201804/17/5ad5bcf6a3abb.jpg',1523956982),(87,0,'关于领跑_03.jpg','data/hnek//Upload/201804/17/5ad5bcf6d5395.jpg',1523956982),(88,0,'关于领跑_04.jpg','data/hnek//Upload/201804/17/5ad5bcf729181.jpg',1523956983),(89,0,'关于领跑_05.jpg','data/hnek//Upload/201804/17/5ad5bcf74b848.jpg',1523956983),(90,0,'关于领跑_06.jpg','data/hnek//Upload/201804/17/5ad5bcf7a1312.jpg',1523956983),(91,0,'关于领跑_07.jpg','data/hnek//Upload/201804/17/5ad5bcf816bf6.jpg',1523956984),(92,0,'关于领跑_04.jpg','data/hnek//Upload/201804/17/5ad5c10d5dbc8.jpg',1523958029),(93,0,'xg0.jpg','data/hnek//Upload/201804/19/5ad7f46f92ca0.jpg',1524102255),(94,0,'xg1.jpg','data/hnek//Upload/201804/19/5ad7f490dbb6d.jpg',1524102288),(95,0,'4.jpg','data/hnek/Upload/201805/25/5b07d92f195d5.jpg',1527241007),(96,0,'1.jpg','data/hnek/Upload/201805/29/5b0ca9a524420.jpg',1527556517),(97,0,'2.jpg','data/hnek/Upload/201805/29/5b0caab8af7b6.jpg',1527556792),(98,0,'33.jpg','data/hnek/Upload/201805/29/5b0cab41ad134.jpg',1527556929),(99,0,'33.jpg','data/hnek/Upload/201805/29/5b0caba8343f8.jpg',1527557032),(100,0,'4.jpg','data/hnek/Upload/201805/29/5b0cacb2e0ebc.jpg',1527557298),(101,0,'5.jpg','data/hnek/Upload/201805/29/5b0cb0517fbba.jpg',1527558225),(102,0,'2.jpg','data/hnek/Upload/201805/29/5b0cb22309311.jpg',1527558691),(103,0,'1.jpg','data/hnek/Upload/201805/29/5b0cb2592835c.jpg',1527558745),(104,0,'3.jpg','data/hnek/Upload/201805/29/5b0cb2716e0a5.jpg',1527558769),(105,0,'4.jpg','data/hnek/Upload/201805/29/5b0cb287250ca.jpg',1527558791),(106,0,'5.jpg','data/hnek/Upload/201805/29/5b0cb2b1e5af7.jpg',1527558833),(107,0,'6.jpg','data/hnek/Upload/201805/29/5b0cb2c82c632.jpg',1527558856),(108,0,'7.jpg','data/hnek/Upload/201805/29/5b0cb2dd77198.jpg',1527558877),(109,0,'8.jpg','data/hnek/Upload/201805/29/5b0cb2ff3d548.jpg',1527558911),(110,0,'13.jpg','data/hnek/Upload/201805/29/5b0cb3379c79a.jpg',1527558967),(111,0,'12.jpg','data/hnek/Upload/201805/29/5b0cb36a9f2cc.jpg',1527559018),(112,0,'6.jpg','data/hnek/Upload/201805/29/5b0cb3757ce6f.jpg',1527559029),(113,0,'14.jpg','data/hnek/Upload/201805/29/5b0cb3b1c6031.jpg',1527559089),(114,0,'15.jpg','data/hnek/Upload/201805/29/5b0cb3c714478.jpg',1527559111),(115,0,'7.jpg','data/hnek/Upload/201805/29/5b0cb4395dcc5.jpg',1527559225),(116,0,'9.jpg','data/hnek/Upload/201805/29/5b0cb58cba236.jpg',1527559564),(117,0,'16.jpg','data/hnek/Upload/201805/29/5b0cb5ac6ad31.jpg',1527559596),(118,0,'11.jpg','data/hnek/Upload/201805/29/5b0cb5ee5466e.jpg',1527559662),(119,0,'10.jpg','data/hnek/Upload/201805/29/5b0cb631824ad.jpg',1527559729),(120,0,'8.jpg','data/hnek/Upload/201805/29/5b0cb8e9f10eb.jpg',1527560425),(121,0,'2017领跑logo.jpg','data/hnek/Upload/201805/29/5b0d03788cb26.jpg',1527579512),(122,0,'2017领跑logo.jpg','data/hnek//Upload/201805/29/5b0d045fab843.jpg',1527579743),(123,0,'2017领跑logo22.jpg','data/hnek//Upload/201805/29/5b0d06275188c.jpg',1527580199),(124,0,'2017领跑logo22.jpg','data/hnek/Upload/201805/29/5b0d063bb3afc.jpg',1527580219),(125,0,'2017领跑名片333.jpg','data/hnek/Upload/201805/29/5b0d075459aaf.jpg',1527580500),(126,0,'2018领跑logo.jpg','data/hnek/Upload/201805/30/5b0df25ac294c.jpg',1527640666),(127,0,'领跑—简介.jpg','data/hnek//Upload/201805/30/5b0df26dd7162.jpg',1527640685),(128,0,'领跑—简介.jpg','data/hnek//Upload/201805/30/5b0df2b8bdf56.jpg',1527640760),(129,0,'2018领跑logo22.jpg','data/hnek/Upload/201805/30/5b0df476e1b5e.jpg',1527641206),(130,0,'领跑—简介.jpg','data/hnek//Upload/201805/30/5b0df49084b2c.jpg',1527641232),(131,0,'2018领跑logo72.jpg','data/hnek/Upload/201805/30/5b0df4c2abc63.jpg',1527641282),(132,0,'2018领跑logo150.jpg','data/hnek/Upload/201805/30/5b0df500ad026.jpg',1527641344),(133,0,'2018领跑logo22.jpg','data/hnek/Upload/201805/30/5b0df5227f5d0.jpg',1527641378),(134,0,'lingpao10年.png','data/hnek/Upload/201805/30/5b0df6f922f2a.png',1527641849),(135,0,'324324.jpg','data/hnek/Upload/201805/30/5b0e5b8d4e83c.jpg',1527667597),(136,0,'324455.jpg','data/hnek/Upload/201805/30/5b0e5c0392e75.jpg',1527667715),(137,0,'0941564a5-0.jpg','data/hnek//Upload/201805/30/5b0e6546e92ae.jpg',1527670086),(138,0,'0941563502-1.jpg','data/hnek//Upload/201805/30/5b0e664fc2ab1.jpg',1527670351),(139,0,'0941562320-2.jpg','data/hnek//Upload/201805/30/5b0e66774e75b.jpg',1527670391),(140,0,'500053134.jpg','data/hnek/Upload/201805/30/5b0e67a81e6f1.jpg',1527670696),(141,0,'1.jpg','data/hnek/Upload/201805/30/5b0e6e4289c71.jpg',1527672386),(142,0,'1.jpg','data/hnek/Upload/201805/30/5b0e6e954a61c.jpg',1527672469),(143,0,'1.jpg','data/hnek/Upload/201805/31/5b0f942f541bd.jpg',1527747631),(144,0,'123.jpg','data/hnek/Upload/201805/31/5b0fac90d54dc.jpg',1527753872),(145,0,'214K92451-0.jpg','data/hnek/Upload/201805/31/5b0fb758ea7a4.jpg',1527756632),(146,0,'214K913b-1.jpg','data/hnek//Upload/201805/31/5b0fb795810ac.jpg',1527756693),(147,0,'214K941I-2.jpg','data/hnek//Upload/201805/31/5b0fb7d8147a8.jpg',1527756760),(148,0,'214K96007-3.jpg','data/hnek//Upload/201805/31/5b0fb80f26f75.jpg',1527756815),(149,0,'214K93E8-4.jpg','data/hnek//Upload/201805/31/5b0fb86b0163f.jpg',1527756907),(150,0,'214K95229-5.jpg','data/hnek//Upload/201805/31/5b0fb89853301.jpg',1527756952),(151,0,'2018领跑logo150.jpg','data/hnek/Upload/201805/31/5b0fe1f5b91c2.jpg',1527767541),(152,0,'666.jpg','data/hnek/Upload/201805/31/5b0fe32796458.jpg',1527767847),(153,0,'2017领跑名片333.jpg','data/hnek/Upload/201805/31/5b0fe503ad942.jpg',1527768323),(154,0,'lingpaoad.jpg','data/hnek//Upload/201805/31/5b0fef191790f.jpg',1527770905),(155,0,'666.jpg','data/hnek/Upload/201805/31/5b0fef6e3e297.jpg',1527770990),(156,0,'001_Casas-SP-Mexico-by-S-AR-Marisol-Gonzalez.jpg','data/hnek//Upload/201806/01/5b10ef2c39bff.jpg',1527836460),(157,0,'005-Ibenergi-Headquarters-by-Taller-Abierto.jpg','data/hnek//Upload/201806/01/5b10efb2ba7cb.jpg',1527836594),(158,0,'24334.jpg','data/hnek/Upload/201806/01/5b10f21bc2a5c.jpg',1527837211),(159,0,'8888.jpg','data/hnek//Upload/201806/01/5b10f343d871e.jpg',1527837507),(160,0,'999999999999.jpeg','data/hnek/Upload/201806/01/5b10f3b6d87b2.jpeg',1527837622),(161,0,'123.jpg','data/hnek/Upload/201806/02/5b12367899f48.jpg',1527920248),(162,0,'19163a640-0.jpg','data/hnek/Upload/201806/02/5b1247e9c061f.jpg',1527924713),(163,0,'1916396145-1.jpg','data/hnek//Upload/201806/02/5b1247fff234b.jpg',1527924735),(164,0,'1916393F4-2.jpg','data/hnek//Upload/201806/02/5b12482401f78.jpg',1527924772),(165,0,'19163a640-0.jpg','data/hnek//Upload/201806/02/5b12483e0e101.jpg',1527924798),(166,0,'1916394Z6-4.jpg','data/hnek//Upload/201806/02/5b1248b0465c5.jpg',1527924912),(167,0,'1916393127-5.jpg','data/hnek//Upload/201806/02/5b1248d17388f.jpg',1527924945),(168,0,'19163a640-0.jpg','data/hnek/Upload/201806/02/5b124a90f1dd1.jpg',1527925392),(169,0,'110500O13-1.jpg','data/hnek//Upload/201806/02/5b124b2ceb118.jpg',1527925548),(170,0,'110500D14-2.jpg','data/hnek//Upload/201806/02/5b124b532d615.jpg',1527925587),(171,0,'110500E54-3.jpg','data/hnek//Upload/201806/02/5b124b607eec9.jpg',1527925600),(172,0,'1105004T2-4.jpg','data/hnek//Upload/201806/02/5b124b86022de.jpg',1527925638),(173,0,'1105005229-5.jpg','data/hnek//Upload/201806/02/5b124b9185884.jpg',1527925649),(174,0,'11050042O-6.jpg','data/hnek//Upload/201806/02/5b124bb003a70.jpg',1527925680),(175,0,'110500MW-7.jpg','data/hnek//Upload/201806/02/5b124bc6008ab.jpg',1527925702),(176,0,'110500M25-8.jpg','data/hnek//Upload/201806/02/5b124be424de7.jpg',1527925732),(177,0,'1105002A0-9.jpg','data/hnek//Upload/201806/02/5b124bfdb5a65.jpg',1527925757),(178,0,'19163a640-0.jpg','data/hnek/Upload/201806/02/5b124c19b104c.jpg',1527925785),(179,0,'20121008130910474.jpg','data/hnek/Upload/201806/02/5b124cd27b5c6.jpg',1527925970),(180,0,'20121008130908767.jpg','data/hnek//Upload/201806/02/5b124cfdbec7c.jpg',1527926013),(181,0,'20121008130910207.jpg','data/hnek//Upload/201806/02/5b124d184db68.jpg',1527926040),(182,0,'20121008130910474.jpg','data/hnek/Upload/201806/02/5b124d68339c1.jpg',1527926120),(183,0,'20121008130908767.jpg','data/hnek//Upload/201806/02/5b124d72bf04a.jpg',1527926130),(184,0,'20121008130910207.jpg','data/hnek//Upload/201806/02/5b124d96e7904.jpg',1527926166),(185,0,'20121008130910567.jpg','data/hnek//Upload/201806/02/5b124d9f01533.jpg',1527926175),(186,0,'20121008130910474.jpg','data/hnek//Upload/201806/02/5b124db643029.jpg',1527926198),(187,0,'19163a640-0.jpg','data/hnek//Upload/201806/02/5b124ea654e3c.jpg',1527926438),(188,0,'印刷.jpg','data/hnek/Upload/201806/02/5b128321d7149.jpg',1527939873),(189,0,'印刷3.jpg','data/hnek/Upload/201806/02/5b1288f407ad4.jpg',1527941364),(190,0,'印刷3.jpg','data/hnek/Upload/201806/02/5b1293a50568c.jpg',1527944101),(191,0,'印刷5.jpg','data/hnek/Upload/201806/02/5b1299de5b61c.jpg',1527945694),(192,0,'观点.jpg','data/hnek/Upload/201806/02/5b129efa91073.jpg',1527947002),(193,0,'观点.jpg','data/hnek/Upload/201806/02/5b129fc1a97d4.jpg',1527947201),(194,0,'印刷5.jpg','data/hnek/Upload/201806/02/5b12a1980fcbc.jpg',1527947672),(195,0,'xin.jpg','data/hnek/Upload/201806/02/5b12a5dc857d6.jpg',1527948764),(196,0,'xi36999n.jpg','data/hnek/Upload/201806/02/5b12b39039ae2.jpg',1527952272),(197,0,'1544595145-0.jpg','data/hnek/Upload/201806/04/5b14aabe78ac3.jpg',1528081086),(198,0,'1544595145-0.jpg','data/hnek/Upload/201806/04/5b14ab98c1561.jpg',1528081304),(199,0,'京朗科技logo2.jpg','data/hnek/Upload/201806/04/5b14e0bcc967b.jpg',1528094908),(200,0,'24.jpg','data/hnek/Upload/201806/04/5b14e0f38f4f4.jpg',1528094963),(201,0,'19.jpg','data/hnek/Upload/201806/04/5b14e1254cefd.jpg',1528095013),(202,0,'20.jpg','data/hnek/Upload/201806/04/5b14e1479cc36.jpg',1528095047),(203,0,'21.jpg','data/hnek/Upload/201806/04/5b14e168a9c31.jpg',1528095080),(204,0,'22.jpg','data/hnek/Upload/201806/04/5b14e1938ebf4.jpg',1528095123),(205,0,'25.jpg','data/hnek/Upload/201806/04/5b14e1f85c9ad.jpg',1528095224),(206,0,'23.jpg','data/hnek/Upload/201806/04/5b14e22253d08.jpg',1528095266),(207,0,'18.jpg','data/hnek/Upload/201806/04/5b14e281a273d.jpg',1528095361),(208,0,'18.jpg','data/hnek/Upload/201806/04/5b14e28797374.jpg',1528095367),(209,0,'17.jpg','data/hnek/Upload/201806/04/5b14e2a379717.jpg',1528095395),(210,0,'28.jpg','data/hnek/Upload/201806/04/5b14e2d78d3b2.jpg',1528095447),(211,0,'29.jpg','data/hnek/Upload/201806/04/5b14e325d9e8f.jpg',1528095525),(212,0,'26.jpg','data/hnek/Upload/201806/04/5b14e34877c6b.jpg',1528095560),(213,0,'27.jpg','data/hnek/Upload/201806/04/5b14e35fbf8e6.jpg',1528095583),(214,0,'30.jpg','data/hnek/Upload/201806/04/5b14e38417d70.jpg',1528095620),(215,0,'31.jpg','data/hnek/Upload/201806/04/5b14e3a016620.jpg',1528095648),(216,0,'5b14e22253d08.jpg','data/hnek/Upload/201806/04/5b14e52728223.jpg',1528096039),(217,0,'21.jpg','data/hnek/Upload/201806/04/5b150e5b122f0.jpg',1528106587),(218,0,'160R961V-0.jpg','data/hnek/Upload/201806/06/5b173b5e32941.jpg',1528249182),(219,0,'1.jpg','data/hnek/Upload/201806/06/5b17b4b418e06.jpg',1528280244),(220,0,'21432.jpg','data/hnek/Upload/201806/07/5b18df6275f43.jpg',1528356706),(221,0,'321323.jpg','data/hnek/Upload/201806/07/5b18e068b2520.jpg',1528356968),(222,0,'未标题-1.jpg','data/hnek/Upload/201806/08/5b1a24be0c1ee.jpg',1528439998),(223,0,'224H01303-2.jpg','data/hnek//Upload/201806/08/5b1a27557551c.jpg',1528440661),(224,0,'224H0NY-3.jpg','data/hnek//Upload/201806/08/5b1a279d68539.jpg',1528440733),(225,0,'224H0J60-4.jpg','data/hnek//Upload/201806/08/5b1a27a74eb5d.jpg',1528440743),(226,0,'224H0A41-15.jpg','data/hnek//Upload/201806/08/5b1a284b1ee1f.jpg',1528440907),(227,0,'224H04K9-22.jpg','data/hnek//Upload/201806/08/5b1a2860950d1.jpg',1528440928),(228,0,'14045145I-0.jpg','data/hnek/Upload/201806/08/5b1a28df7ce9d.jpg',1528441055),(229,0,'213.jpg','data/hnek/Upload/201806/08/5b1a29e237e1e.jpg',1528441314),(230,0,'12434214.jpg','data/hnek/Upload/201806/14/5b224219df768.jpg',1528971801),(231,0,'kenya002.jpg','data/hnek//Upload/201806/15/5b23854be8467.jpg',1529054539),(232,0,'kenya004.jpg','data/hnek//Upload/201806/15/5b2385cf13a90.jpg',1529054671),(233,0,'1243.jpg','data/hnek/Upload/201806/15/5b2386f8d5566.jpg',1529054968),(234,0,'3213.jpg','data/hnek/Upload/201806/19/5b28a8459e5cc.jpg',1529391173),(235,0,'2133.jpg','data/hnek/Upload/201806/19/5b28ccfde0580.jpg',1529400573),(236,0,'639a360733a74f5597bd2c39bbe157e1.jpg','data/hnek//Upload/201807/02/5b39f2d5eefdf.jpg',1530524373),(237,0,'dbde8eb97ded4dc1ae9caa34b559816f.jpg','data/hnek//Upload/201807/02/5b39f2e66c61e.jpg',1530524390),(238,0,'555935c8ddfc41d08f3f1e8be030aa73.jpg','data/hnek//Upload/201807/02/5b39f315c3cbc.jpg',1530524437),(239,0,'4481ad1665a648469d4dc87a997bc0a8.jpg','data/hnek//Upload/201807/02/5b39f33ba1615.jpg',1530524475),(240,0,'bd077af3f70f4d0cb000691d13c00207.jpg','data/hnek//Upload/201807/02/5b39f3644c2f1.jpg',1530524516),(241,0,'47d7d179757549608c2a7c9e30bc1a9d.jpg','data/hnek//Upload/201807/02/5b39f39b71102.jpg',1530524571),(242,0,'23123.jpg','data/hnek/Upload/201807/02/5b39f64010c8c.jpg',1530525248),(243,0,'232.jpg','data/hnek/Upload/201807/14/5b495c0f77f32.jpg',1531534351),(244,0,'213.jpg','data/hnek/Upload/201807/14/5b495cec1b8f3.jpg',1531534572),(245,0,'21424.jpg','data/hnek/Upload/201807/16/5b4c6abd86dcb.jpg',1531734717),(246,0,'21343.jpg','data/hnek/Upload/201807/17/5b4dc17a396b1.jpg',1531822458),(247,0,'ccee01fbca76a9f029fe179b5e2ff1fe.png','data/hnek//Upload/201807/18/5b4f0c00d93c7.png',1531907072),(248,0,'17b79a3b53c2354374d0d0d66e02e89e.png','data/hnek//Upload/201807/18/5b4f0c32ea4ad.png',1531907122),(249,0,'213.jpg','data/hnek/Upload/201807/18/5b4f0cef5a0d2.jpg',1531907311),(250,0,'21323.jpg','data/hnek/Upload/201807/20/5b51b0e9247b0.jpg',1532080361),(251,0,'32.jpg','data/hnek/Upload/201808/10/5b6ce780bf922.jpg',1533863808),(252,0,'33.jpg','data/hnek/Upload/201808/10/5b6ce79aa3a94.jpg',1533863834),(253,0,'34.jpg','data/hnek/Upload/201808/10/5b6ce7ce234d7.jpg',1533863886),(254,0,'35.jpg','data/hnek/Upload/201808/10/5b6ce7e62b09d.jpg',1533863910),(255,0,'37.jpg','data/hnek/Upload/201808/10/5b6ce804d4da5.jpg',1533863940),(256,0,'36.jpg','data/hnek/Upload/201808/10/5b6ce8735c599.jpg',1533864051),(257,0,'38.jpg','data/hnek/Upload/201808/10/5b6ce8e2ca53d.jpg',1533864162),(258,0,'21.jpg','data/hnek/Upload/201808/10/5b6d4a64a95f2.jpg',1533889124),(259,0,'微信图片_20180814153051.jpg','data/hnek/Upload/201808/14/5b72854f75208.jpg',1534231887),(260,0,'432444.jpg','data/hnek/Upload/201808/20/5b7a730f76c28.jpg',1534751503),(261,0,'43545.jpg','data/hnek/Upload/201808/20/5b7a743bd5670.jpg',1534751803),(262,0,'3244.jpg','data/hnek/Upload/201808/20/5b7a7518b5269.jpg',1534752024),(263,0,'6248511.jpg','data/hnek//Upload/201808/29/5b86572633c5b.jpg',1535530790),(264,0,'3.jpg','data/hnek//Upload/201809/12/5b98b0b94b877.jpg',1536733369),(265,0,'12343.jpg','data/hnek/Upload/201809/12/5b98b895240ac.jpg',1536735381),(266,0,'12434.jpg','data/hnek/Upload/201809/12/5b98b8aae939d.jpg',1536735402),(267,0,'2145434.jpg','data/hnek/Upload/201809/12/5b98b8c87e323.jpg',1536735432),(268,0,'214444.jpg','data/hnek/Upload/201809/12/5b98b96b93d51.jpg',1536735595),(269,0,'13233.jpg','data/hnek/Upload/201809/13/5b9a075da45b5.jpg',1536821085),(270,0,'21424.jpg','data/hnek/Upload/201809/14/5b9b523d6bc56.jpg',1536905789),(271,0,'123424444.jpg','data/hnek/Upload/201809/17/5b9f5eb111b17.jpg',1537171121),(272,0,'banner1.jpg','data/hnek/Upload/201809/18/5ba059e15361f.jpg',1537235425),(273,0,'banner2.jpg','data/hnek/Upload/201809/18/5ba05a12ed96f.jpg',1537235474),(274,0,'banner2.jpg','data/hnek/Upload/201809/18/5ba05a1e7eba9.jpg',1537235486),(275,0,'banner2.jpg','data/hnek/Upload/201809/18/5ba05a28b1013.jpg',1537235496),(276,0,'banner2.jpg','data/hnek/Upload/201809/18/5ba05abdcc928.jpg',1537235645),(277,0,'banner2.jpg','data/hnek/Upload/201809/18/5ba05acdd3dda.jpg',1537235661),(278,0,'banner2.jpg','data/hnek/Upload/201809/18/5ba05ad4d938f.jpg',1537235668),(279,0,'banner2.jpg','data/hnek/Upload/201809/18/5ba05ae328ec5.jpg',1537235683),(280,0,'banner2.jpg','data/hnek/Upload/201809/18/5ba05aeeb5093.jpg',1537235694),(281,0,'1244.jpg','data/hnek/Upload/201809/18/5ba0bc63201d3.jpg',1537260643),(282,0,'124214.jpg','data/hnek/Upload/201809/21/5ba4519b0cea9.jpg',1537495451),(283,0,'123123.jpg','data/hnek/Upload/201809/25/5ba9f662388cc.jpg',1537865314),(284,0,'8.jpg','data/hnek//Upload/201809/28/5baddbbc12387.jpg',1538120636),(285,0,'33.jpg','data/hnek//Upload/201810/16/5bc58a52bd5c0.jpg',1539672658),(286,0,'43.jpg','data/hnek//Upload/201810/25/5bd18e063788e.jpg',1540460038),(287,0,'uisdc-sl-20181025-10.jpg','data/hnek/Upload/201811/03/5bdd06868b4d2.jpg',1541211782),(288,0,'木瓜葛根魔芋粉插画.jpg','data/hnek/Upload/201811/05/5bdfbed7eb3cc.jpg',1541390039),(289,0,'Big_city_guide_Stockholm_tubik.png','data/hnek/Upload/201811/07/5be24dbc45292.png',1541557692),(290,0,'016fa05be2e1b5a80121ab5d0a1e26.jpg','data/hnek/Upload/201811/09/5be4edfc213de.jpg',1541729788),(291,0,'013ec95be2e01ea80121ab5d00b0b4.jpg','data/hnek/Upload/201811/09/5be4ee4aee502.jpg',1541729866),(292,0,'0132da5be2cd3ba80120925235be07.jpg@1280w_1l_2o_100sh.jpg','data/hnek/Upload/201811/10/5be63009822e2.jpg',1541812233),(293,0,'0115495be2cd2fa80121ab5d5d60d0.jpg@1280w_1l_2o_100sh.jpg','data/hnek/Upload/201811/10/5be6356057821.jpg',1541813600),(294,0,'0160035be2cd34a80120925291c3ab.jpg@1280w_1l_2o_100sh.jpg','data/hnek/Upload/201811/10/5be637739534d.jpg',1541814131),(295,0,'7adeb4f976074944bb4d1831dfa00b0d.jpg','data/hnek/Upload/201811/10/5be638f5c3087.jpg',1541814517),(296,0,'01e41e5bdf9d47a80121ab5d638b61.jpg@1280w_1l_2o_100sh.jpg','data/hnek/Upload/201811/12/5be8e2980578e.jpg',1541989016),(297,0,'0105ed5bc1755da8012099c855ad69.jpg@1280w_1l_2o_100sh.jpg','data/hnek/Upload/201811/12/5be8ea2899c07.jpg',1541990952),(298,0,'5be677df539c4e7d88f4f7b4fc4e16c5.jpg','data/hnek/Upload/201811/12/5be8eb7b7d006.jpg',1541991291),(299,0,'345a5143c4734be49dcd57f7113e4ef7.jpg','data/hnek/Upload/201811/12/5be8f7756447c.jpg',1541994357),(300,0,'1.jpg','data/hnek//Upload/201811/12/5be9469f594b9.jpg',1542014623),(301,0,'30c14aef763b4abb8414297a30ba0f60.jpg','data/hnek/Upload/201811/13/5bea3791631ad.jpg',1542076305),(302,0,'daed52468c5c490493e0d18a726b8071.jpg','data/hnek/Upload/201811/13/5bea39c9e1f3e.jpg',1542076873),(303,0,'30c14aef763b4abb8414297a30ba0f60.jpg','data/hnek/Upload/201811/13/5bea3f98765de.jpg',1542078360),(304,0,'0247c66bf84143399d875190e2c1aba2.jpg','data/hnek/Upload/201811/13/5bea3fb0c813a.jpg',1542078384),(305,0,'bd58cb66478e4617b132e1f90dd29649.jpg','data/hnek/Upload/201811/13/5bea406b7f38a.jpg',1542078571),(306,0,'d0925e5c14894412b319d1e1a2801e17.jpg','data/hnek/Upload/201811/14/5beb766b07450.jpg',1542157931),(307,0,'9ad46d715e96423792c27f8cae09a928.jpg','data/hnek/Upload/201811/14/5beb77d1ddab9.jpg',1542158289),(308,0,'5de6d1c94eff4115b1fa5c3da6272495.jpg','data/hnek/Upload/201811/14/5beb8987f25cc.jpg',1542162823),(309,0,'a2b73427122d452193fb2a591ba9d726.jpg','data/hnek/Upload/201811/14/5beb8ab3a1151.jpg',1542163123),(310,0,'b965adae3c434b2180911b8f66a4fe28.jpg','data/hnek/Upload/201811/15/5becd372ac798.jpg',1542247282),(311,0,'058f6830fc3d4a2597e8ad0cd6fe7382.jpg','data/hnek/Upload/201811/15/5becd9f949d96.jpg',1542248953),(312,0,'1989c482190c459fbd12b41b1e7aa80f.jpg','data/hnek/Upload/201811/15/5becdbd79f785.jpg',1542249431),(313,0,'4cfa4c91a10c4ca08e2540e89f2bb820.jpg','data/hnek/Upload/201811/15/5bece663f1fd2.jpg',1542252131),(314,0,'f29be40c8825483c8aff1e183f9b3ede.jpg','data/hnek/Upload/201811/16/5bee19bdf042d.jpg',1542330813),(315,0,'34c7e4ccc91d41c0abaac31b6b641ee5.jpg','data/hnek/Upload/201811/16/5bee1ac5c5e62.jpg',1542331077),(316,0,'0856722f8456459b8c32dd3fc842b10b.jpg','data/hnek/Upload/201811/16/5bee1b888a675.jpg',1542331272),(317,0,'4339f2791725479b8d417508383be908.jpg','data/hnek/Upload/201811/16/5bee1c42558fb.jpg',1542331458),(318,0,'6a9713517d204be6abc25f1abce013dd.jpg','data/hnek/Upload/201811/16/5bee1d62201d8.jpg',1542331746),(319,0,'2c1da30a384b4a0fbc61f0d42d775429.jpg','data/hnek/Upload/201811/16/5bee1eb917aaa.jpg',1542332089),(320,0,'8d1d53ef6cf9446090ecd6d7b171f0a7.jpg','data/hnek/Upload/201811/17/5bef66108d030.jpg',1542415888),(321,0,'2fbf6f50c2be42f28a2e3a86173a0d25.jpg','data/hnek/Upload/201811/17/5bef66e3d77dc.jpg',1542416099),(322,0,'bf6362f68fb64638926aac5a375920cd.jpg','data/hnek/Upload/201811/17/5bef678508a2a.jpg',1542416261),(323,0,'baed0bd3b5f148b994e0472b6a7fefe9.jpg','data/hnek/Upload/201811/17/5bef68c1ed8c1.jpg',1542416577),(324,0,'b0d0faabe09c4c82967da271b1bbd7e1.jpg','data/hnek/Upload/201811/17/5bef6a15a9437.jpg',1542416917),(325,0,'1fd0e3ac1c584401b8dc6c177cf1d437.jpg','data/hnek/Upload/201811/17/5bef6b03a7b81.jpg',1542417155),(326,0,'586e11a7be1f473ea3781afe0cbc0603.jpg','data/hnek/Upload/201811/17/5bef6c0c437b8.jpg',1542417420),(327,0,'e1b30d15435e4591b42d33217c97d03d.jpg','data/hnek/Upload/201811/17/5bef6d585a08d.jpg',1542417752),(328,0,'307cb381511648d0ac5c11f882f5a9b1.jpg','data/hnek/Upload/201811/19/5bf21f494538d.jpg',1542594377),(329,0,'36c5241493b34d8ebcf919d9aef2748f.png','data/hnek/Upload/201811/19/5bf2211c16393.png',1542594844),(330,0,'fb381e05ac7444ef97147ee9b1f364e4.png','data/hnek/Upload/201811/19/5bf221ca78c82.png',1542595018),(331,0,'69c2e9aa8fa64f6cac11e48f7b0c8066.jpg','data/hnek/Upload/201811/19/5bf22289cc9be.jpg',1542595209),(332,0,'579568bf80af4f45973c92d10dfafbed.jpg','data/hnek/Upload/201811/19/5bf2234263bb8.jpg',1542595394),(333,0,'43cc92d6840d40f4b525727153b8dffd.jpg','data/hnek/Upload/201811/19/5bf2244c0a2eb.jpg',1542595660),(334,0,'fe6ba69044b84233906b38aa0b3adbc6.jpg','data/hnek/Upload/201811/19/5bf225f63cc4f.jpg',1542596086),(335,0,'f09dedf675254bc19ae229a83adb4a59.jpg','data/hnek/Upload/201811/19/5bf226efd7ea2.jpg',1542596335),(336,0,'6c0e37b67cb4419890eb263b12bc77eb.jpg','data/hnek/Upload/201811/20/5bf3635bb2ee1.jpg',1542677339),(337,0,'011efc00c2154919b39739911a93d58f.jpg','data/hnek/Upload/201811/20/5bf3635f9943e.jpg',1542677343),(338,0,'031ba39d9eb24fe38e1fbc0a2dc32800.jpg','data/hnek/Upload/201811/20/5bf365cb2c773.jpg',1542677963),(339,0,'6f3c22690dc14d9c9c0c0cee31a2a5a5.jpg','data/hnek/Upload/201811/20/5bf3684547e28.jpg',1542678597),(340,0,'2d298d7f6f954dc1a981b2d5b6df7a96.png','data/hnek/Upload/201811/20/5bf368b2e111a.png',1542678706),(341,0,'214b75b6f4884517a7cdd494134e52a7.png','data/hnek/Upload/201811/20/5bf369943181a.png',1542678932),(342,0,'a90f74d67f4b4b5e812ff6fdab30b081.jpg','data/hnek/Upload/201811/20/5bf36a6bdcaf5.jpg',1542679147),(343,0,'46e41bdd933c4fe3800081076d407783.jpg','data/hnek/Upload/201811/20/5bf37db9936bf.jpg',1542684089),(344,0,'c7725969af1b4295b80a4e709cf94737.jpg','data/hnek/Upload/201811/21/5bf4b6fc3bcd7.jpg',1542764284),(345,0,'7dc95af7ebc8420cb6508ae6e9e7b74e.jpg','data/hnek/Upload/201811/21/5bf4b8fb71b98.jpg',1542764795),(346,0,'35869d6235cf4aeca4d216314ffd53c6.jpg','data/hnek/Upload/201811/21/5bf4bbe3a04c2.jpg',1542765539),(347,0,'0976d472e90e43f1a3b552fc876b4957.jpg','data/hnek/Upload/201811/21/5bf4bc9941aac.jpg',1542765721),(348,0,'d0490920d9d94e40af2e2c2840382951.jpg','data/hnek/Upload/201811/21/5bf4bd6a9fb08.jpg',1542765930),(349,0,'d4e872d516dc4bae9fa9714209935d2c.jpg','data/hnek/Upload/201811/21/5bf4c126e5704.jpg',1542766886),(350,0,'74d16ab2cba64bc69e4b347598c4b43e.jpg','data/hnek/Upload/201811/21/5bf4c2c4d3346.jpg',1542767300),(351,0,'f2c5d232622c462696d8a207f891278f.jpg','data/hnek/Upload/201811/21/5bf4c587842ee.jpg',1542768007),(352,0,'d66135ee239443b2a3512de15b148692.jpg','data/hnek/Upload/201811/22/5bf606fd00928.jpg',1542850301),(353,0,'337b8da077e64243859a0b5a3ba69156.jpg','data/hnek/Upload/201811/22/5bf6076863132.jpg',1542850408),(354,0,'2a03a1ba36e9470abd94719d9ae7da4a.jpg','data/hnek/Upload/201811/22/5bf608f4aea2e.jpg',1542850804),(355,0,'6b61a6f2c7c140e2b402af349f6b6dc9.jpg','data/hnek/Upload/201811/22/5bf608f9d1868.jpg',1542850809),(356,0,'bc3cf92b404e4bb4840766ff8420544b.jpg','data/hnek/Upload/201811/22/5bf6092453a9a.jpg',1542850852),(357,0,'081864e7f36b4aed92c339fc9d2473ed.jpg','data/hnek/Upload/201811/22/5bf60927e0854.jpg',1542850855),(358,0,'10dbfee1de7c4e5b80bcbb8db7b8b7e8.jpg','data/hnek/Upload/201811/22/5bf60932f210f.jpg',1542850866),(359,0,'5388c641824746c38399607ae5bedf53.jpg','data/hnek/Upload/201811/22/5bf60a1c9cca3.jpg',1542851100),(360,0,'a9d547c5fac1418db51574c7bd893a78.jpg','data/hnek/Upload/201811/22/5bf60be2a8b37.jpg',1542851554),(361,0,'709cb5a4e0fd4ed28bb9211254d22384.jpg','data/hnek/Upload/201811/22/5bf60c74952c9.jpg',1542851700),(362,0,'36f15a2462a14be29625fd89485d36c0.jpg','data/hnek/Upload/201811/22/5bf60ccfcb4cf.jpg',1542851791),(363,0,'9252d2cd265242d1af6e5f51378894d4.jpg','data/hnek/Upload/201811/22/5bf60df3aff9c.jpg',1542852083),(364,0,'147df496fbc04e5ba67ff970d4863203.jpg','data/hnek/Upload/201811/23/5bf753fb25b99.jpg',1542935547),(365,0,'7590aaa8cc3546b1a41e32c1921258d7.jpg','data/hnek/Upload/201811/23/5bf754ef5e07b.jpg',1542935791),(366,0,'d9b4a5b2fdaa4bfca92f1c3488d13f1c.jpg','data/hnek/Upload/201811/23/5bf755dc7eb34.jpg',1542936028),(367,0,'28376a8b1e904862a3e316a5b963066f.jpg','data/hnek/Upload/201811/23/5bf7567563927.jpg',1542936181),(368,0,'97ae46b30486405e9951323620bb6312.jpg','data/hnek/Upload/201811/23/5bf757a835dd0.jpg',1542936488),(369,0,'fc64bc5c3fd14adabca426f13236f36f.jpg','data/hnek/Upload/201811/23/5bf758a1275c3.jpg',1542936737),(370,0,'9a61f36b2e7345fc83e36e2d542d178d.jpg','data/hnek/Upload/201811/23/5bf758c5c62c3.jpg',1542936773),(371,0,'c7f3ce232e554d92951875adf12e5bcf.jpg','data/hnek/Upload/201811/24/5bf8a767dc983.jpg',1543022439),(372,0,'87cb99dfd2c4463298aa300d20a354bf.jpg','data/hnek/Upload/201811/24/5bf8a82abf5d7.jpg',1543022634),(373,0,'a006ed760afe452d8ae0ef99116eb219.jpg','data/hnek/Upload/201811/24/5bf8a8b915376.jpg',1543022777),(374,0,'b07b5e1cd8df4263832f66bb06d9ec37.jpg','data/hnek/Upload/201811/24/5bf8aa6482933.jpg',1543023204),(375,0,'83679d7e3f42450dabbd94906d0be61b.png','data/hnek/Upload/201811/24/5bf8ace9a6829.png',1543023849),(376,0,'9559dea14e314807ad3143d155432bff.jpg','data/hnek/Upload/201811/24/5bf8add0aa66f.jpg',1543024080),(377,0,'e2ff4aa7d4ff4715aa89d384664775ab.png','data/hnek/Upload/201811/26/5bfb49862a5a6.png',1543195014),(378,0,'7cabd48e49dd4a37a3e399e4cca888c9.jpg','data/hnek/Upload/201811/26/5bfb498c04f96.jpg',1543195020),(379,0,'e2ff4aa7d4ff4715aa89d384664775ab.png','data/hnek/Upload/201811/26/5bfb49a0db3ff.png',1543195040),(380,0,'7703a4a1b75945e892b2afdcf4c9834b.jpg','data/hnek/Upload/201811/26/5bfb4a76a4d6e.jpg',1543195254),(381,0,'b16c8d9e3e46420794c91ef67fc44eb5.jpg','data/hnek/Upload/201811/26/5bfb60887d084.jpg',1543200904),(382,0,'99a53a2de0064b9e876b1cbe05787088.jpg','data/hnek/Upload/201811/26/5bfb641302dc1.jpg',1543201811),(383,0,'ba504699b5a64a0297ff76aad4fff06e.jpg','data/hnek/Upload/201811/26/5bfb653a71abe.jpg',1543202106),(384,0,'6995604644c142ab9c78e4d6a68a2f97.jpg','data/hnek/Upload/201811/27/5bfc9d5af17fb.jpg',1543282010),(385,0,'42cc2cdc58f24cf5bb7cbfbaf31d8e93.png','data/hnek/Upload/201811/27/5bfce4d6deb62.png',1543300310),(386,0,'d175a8bfdf9d44b6b3cf372bf9b2ec23.jpeg','data/hnek/Upload/201811/27/5bfce54f2ec2b.jpeg',1543300431),(387,0,'9b304df73fae47b7accc588a6f3509a0.jpg','data/hnek/Upload/201811/27/5bfce59f9606c.jpg',1543300511),(388,0,'4ffb25e095bf4a24881513489561990c.jpg','data/hnek/Upload/201811/27/5bfce610c7ad8.jpg',1543300624),(389,0,'建业 集团新生活logo提案2.jpg','data/hnek/Upload/201811/27/5bfce6f19de94.jpg',1543300849),(390,0,'df94c2bbec434f93b887d070e6d07ba6.jpg','data/hnek/Upload/201811/28/5bfdf26b36d82.jpg',1543369323),(391,0,'a4a67072abcc4cc98b55276a4e063691.jpg','data/hnek/Upload/201811/28/5bfdf2dfb0ffc.jpg',1543369439),(392,0,'1845f7b6254d4fd488249ac634be7443.jpg','data/hnek/Upload/201811/28/5bfdf41e9d5c1.jpg',1543369758),(393,0,'6e83e92ab0044ae689a86c851d10f457.jpeg','data/hnek/Upload/201811/28/5bfdf4e572343.jpeg',1543369957),(394,0,'58737ba5d5bc4443abf6a4efe3a230c2.jpg','data/hnek/Upload/201811/28/5bfdf5f3971da.jpg',1543370227),(395,0,'95a19c1dde8d4f49a53e8bfab65e1766.jpg','data/hnek/Upload/201811/28/5bfdf815d6343.jpg',1543370773),(396,0,'893b21ebbbe34cfc8b22336167b04a29.jpg','data/hnek/Upload/201811/29/5bff4672d2fe7.jpg',1543456370),(397,0,'a938ddf7806c41ba93db79930b765ccf.jpg','data/hnek/Upload/201811/29/5bff46dd50fe7.jpg',1543456477),(398,0,'c569dc8f2cbf48ce8c9f825d97eab5c3.jpg','data/hnek/Upload/201811/29/5bff47343aba6.jpg',1543456564),(399,0,'8fc7c4f536ca4bffb66a3bfe3c792861.jpg','data/hnek/Upload/201811/29/5bff4880bd394.jpg',1543456896),(400,0,'b7ab4d94426b42eaaee3ad46513de120.jpg','data/hnek/Upload/201811/29/5bff494d9dc5c.jpg',1543457101),(401,0,'8a1eeaf9b6ab4812a20958265d133896.jpg','data/hnek/Upload/201811/29/5bff4a799d7a6.jpg',1543457401),(402,0,'86c8c6b009b8480d858177adec3768f1.png.jpg','data/hnek/Upload/201811/29/5bff4b59e37d0.jpg',1543457625),(403,0,'cec9a74853df4c8b87ab01f0d2b87811.jpg','data/hnek/Upload/201811/29/5bff4bc75dcd8.jpg',1543457735),(404,0,'06379f99c02341cdb4c30c0b15e0ac67.jpg','data/hnek/Upload/201811/30/5c00a56538664.jpg',1543546213),(405,0,'16faba5f0b1c4a56b3cf99117b62dd8f.jpg','data/hnek/Upload/201811/30/5c00a9251f2c7.jpg',1543547173),(406,0,'ab2d866ec8e1443c8803e7fcbe838fc6.jpg','data/hnek/Upload/201811/30/5c00a98f56f67.jpg',1543547279),(407,0,'cf72a1286bd94a6dbacabcc328c63f22.jpg','data/hnek/Upload/201811/30/5c00a9dbdcf85.jpg',1543547355),(408,0,'a00039ce02c84ebdb780d544bd9326cc.jpg','data/hnek/Upload/201811/30/5c00ab276899a.jpg',1543547687),(409,0,'ececbd9021424dcd95e2527caa6e1f66.jpg','data/hnek/Upload/201812/01/5c01e437b11dd.jpg',1543627831),(410,0,'decb8864dd8843af89e42248d17970ec.png','data/hnek/Upload/201812/01/5c01e49519ab4.png',1543627925),(411,0,'f9faaa03f2014a5a8d82042edebefca1.jpg','data/hnek/Upload/201812/01/5c01e516bd0d8.jpg',1543628054),(412,0,'d58bac021c8b4480a98167551a7940ee.jpg','data/hnek/Upload/201812/01/5c01e56e06a15.jpg',1543628142),(413,0,'964e9159014c4350bc7ea1171cb00114.jpg','data/hnek/Upload/201812/03/5c04868991fa2.jpg',1543800457),(414,0,'c1a61e07cba7426485d2e6901f31d775.jpg','data/hnek/Upload/201812/03/5c04870714cc4.jpg',1543800583),(415,0,'d58bd2a96514402b97955f40da79bdaf.jpg','data/hnek/Upload/201812/03/5c04876cc1c79.jpg',1543800684),(416,0,'0df9442a3c4343978fb8ca11261cc39a.jpg','data/hnek/Upload/201812/03/5c0487c2afa8c.jpg',1543800770),(417,0,'1c5b9fdbfe1f45129472ae1704f27060.jpg','data/hnek/Upload/201812/03/5c04884153344.jpg',1543800897),(418,0,'343a47f841604551b41d47c71eb45ba2.png','data/hnek/Upload/201812/03/5c0488ae28993.png',1543801006),(419,0,'5f6accd2ade64f70b6043c3597415173.jpg','data/hnek/Upload/201812/03/5c049377301df.jpg',1543803767),(420,0,'uisdc-cy-20181128-2.gif','data/hnek/Upload/201812/04/5c05de5bec6dd.gif',1543888475),(421,0,'e671bfc721974bac91f9f29b739b7705.png','data/hnek/Upload/201812/04/5c05df571c498.png',1543888727),(422,0,'53d9bf64cc7a4b368b585ed94fc9936b.jpg','data/hnek/Upload/201812/04/5c05e15700a04.jpg',1543889239),(423,0,'b12f1aef039a4a649fdf9a19a7e1aef0.png','data/hnek/Upload/201812/04/5c05e1ad66220.png',1543889325),(424,0,'13d3e623713c4ccc9d7737ec46ee3e98.jpg','data/hnek/Upload/201812/04/5c05e25698183.jpg',1543889494),(425,0,'subtle.jpg','data/hnek/Upload/201812/04/5c05e2cda88b4.jpg',1543889613),(426,0,'2aa7396591384711b933fad9af69f085.jpg','data/hnek/Upload/201812/05/5c0728eb7e154.jpg',1543973099),(427,0,'6abb36a133ad43e3bf56358bf82397ea.jpg','data/hnek/Upload/201812/05/5c07731591a07.jpg',1543992085),(428,0,'48dd4d1c6cad4241ada98412e8f7a3dc.jpg','data/hnek/Upload/201812/05/5c07735556d2a.jpg',1543992149),(429,0,'1223f11385004af0bceda11ff1662c97.jpg','data/hnek/Upload/201812/05/5c0773d9287ab.jpg',1543992281),(430,0,'9ceaeb92280e48ef8ec167d88e995dc1.jpg','data/hnek/Upload/201812/05/5c07759c39780.jpg',1543992732),(431,0,'ff9ba47e279646f595e16f3456072122.jpg','data/hnek/Upload/201812/06/5c088572e1504.jpg',1544062322),(432,0,'0ce94a92f3e24f6ab3149de24ca4e138.jpeg','data/hnek/Upload/201812/06/5c0885be53752.jpeg',1544062398),(433,0,'5b14e325d9e8f.jpg','data/hnek//Upload/201812/06/5c08e6356f468.jpg',1544087093),(434,0,'pantone-color-of-the-year-2019-living-coral-banner-1.jpg','data/hnek/Upload/201812/07/5c09cb9c78c17.jpg',1544145820),(435,0,'uisdc-hb-20181122-1.jpg','data/hnek/Upload/201812/07/5c09cf3b4c140.jpg',1544146747),(436,0,'uisdc-vg-20181114-3.jpg','data/hnek/Upload/201812/07/5c0a25b4636e2.jpg',1544168884),(437,0,'uisdc-gj-20181113-21.jpg','data/hnek/Upload/201812/07/5c0a270d91984.jpg',1544169229),(438,0,'accessibility-in-mobile-app-design.png','data/hnek/Upload/201812/08/5c0b26b0d0999.png',1544234672),(439,0,'0_Qen7zHvr2uGbKpnZ.png','data/hnek/Upload/201812/10/5c0dd823580db.png',1544411171),(440,0,'uisdc-yh-20181209-2.jpg','data/hnek/Upload/201812/11/5c0f19924715b.jpg',1544493458),(441,0,'uisdc-ms-20181209-13.jpg','data/hnek/Upload/201812/11/5c0f1cc8dd58a.jpg',1544494280),(442,0,'uisdc-dd-20181210-2.jpg','data/hnek/Upload/201812/12/5c106bc74774e.jpg',1544580039),(443,0,'When-Squirrel-Hunting-Goes-Wrong-Its-No-Fun-When-The-Squirrel-Has-A-Gun-630x339.jpg','data/hnek/Upload/201812/12/5c106d1904e24.jpg',1544580377),(444,0,'uisdc-cy-20181211-3.jpg','data/hnek/Upload/201812/13/5c11bc4208b26.jpg',1544666178),(445,0,'uisdc-sj-20181119-3.jpg','data/hnek/Upload/201812/14/5c131787d7c93.jpg',1544755079),(446,0,'uisdc-rb-20181212-1.jpg','data/hnek/Upload/201812/14/5c131a5d20dd2.jpg',1544755805),(447,0,'uisdc-my-20181213-10.jpg','data/hnek/Upload/201812/15/5c1462b9b9f8b.jpg',1544839865),(448,0,'uisdc-of-20181213-43.jpg','data/hnek/Upload/201812/15/5c146313c80e5.jpg',1544839955),(449,0,'1.jpg','data/hnek//Upload/201812/15/5c14c74c6827c.jpg',1544865612),(450,0,'uisdc-xj-201812142.png','data/hnek/Upload/201812/17/5c173d2fcc2a7.png',1545026863),(451,0,'uisdc-my-20181026-1.jpg','data/hnek/Upload/201812/18/5c184c0cdc4b2.jpg',1545096204),(452,0,'Metal_movable_type.jpg','data/hnek/Upload/201812/18/5c184f9fa32bc.jpg',1545097119),(453,0,'uisdc-ex-20181216-3.jpg','data/hnek/Upload/201812/18/5c1854bc43c47.jpg',1545098428),(454,0,'uisdc-artgenre-20171229-5.jpg','data/hnek/Upload/201812/19/5c1a0c64c5a30.jpg',1545210980),(455,0,'uisdc-zh-20181217-31.jpg','data/hnek/Upload/201812/19/5c1a11d335829.jpg',1545212371),(456,0,'015cc15c18b909a801209252e1ac1f.png','data/hnek/Upload/201812/20/5c1af4b5d3dee.png',1545270453),(457,0,'xmas-wallpaper.jpg','data/hnek/Upload/201812/20/5c1b0baa4c2fc.jpg',1545276330),(458,0,'uisdc-zg-20181219-12.jpg','data/hnek/Upload/201812/21/5c1c464088c92.jpg',1545356864),(459,0,'1_i3rr_WGId_-7vNcEvwJx6A.jpeg','data/hnek/Upload/201812/21/5c1c48cc14ca6.jpeg',1545357516),(460,0,'0_uMpMVmAg_EXVewW2.png','data/hnek/Upload/201812/22/5c1d9bed2ada6.png',1545444333),(461,0,'uisdc-xw-20181221-3.jpg','data/hnek/Upload/201812/24/5c203db2d768e.jpg',1545616818),(462,0,'uisdc-jx-20181222-21.jpg','data/hnek/Upload/201812/24/5c207e6501229.jpg',1545633381),(463,0,'6eaa224fc193464f912e5039bc3feebf.jpg','data/hnek/Upload/201812/25/5c21929933f9a.jpg',1545704089),(464,0,'uisdc-jl-20181224-21.jpg','data/hnek/Upload/201812/25/5c2196a0816a5.jpg',1545705120),(465,0,'lf2016060930.jpg','data/hnek/Upload/201812/25/5c21985babf06.jpg',1545705563),(466,0,'uisdc-mo-20181224-8.jpg','data/hnek/Upload/201812/28/5c258bdbb6ba5.jpg',1545964507),(467,0,'01dd035c20c48ba8012029ac30a9c4.jpg','data/hnek/Upload/201812/28/5c258d7e044c9.jpg',1545964926),(468,0,'0168b35c209360a80121df9034d16b.jpg','data/hnek/Upload/201812/28/5c258e37105c6.jpg',1545965111),(469,0,'0-1.jpg','data/hnek/Upload/201812/29/5c26ce7bd3109.jpg',1546047099),(470,0,'uisdc-ps-20181229-30.jpg','data/hnek/Upload/201901/02/5c2c192dcaf3f.jpg',1546393901),(471,0,'uisdc-md—20181228-12.jpg','data/hnek/Upload/201901/02/5c2c1d1ed2783.jpg',1546394910),(472,0,'3ff85a82b22041f6ba239a775049ca78.jpg','data/hnek/Upload/201901/02/5c2c24339eb45.jpg',1546396723),(473,0,'1546480100(1).jpg','data/hnek/Upload/201901/03/5c2d6a2ade481.jpg',1546480170),(474,0,'e9f75648fe7c4b3b97e709d0a1945136.jpg','data/hnek/Upload/201901/03/5c2d7ae637dca.jpg',1546484454),(475,0,'1_CT8DbNwnpVpsLMRGkF-auA.png','data/hnek/Upload/201901/04/5c2f11a72b61a.png',1546588583),(476,0,'1546669889(1).jpg','data/hnek/Upload/201901/05/5c304f62d0a07.jpg',1546669922),(477,0,'6368220713743118113078113.jpg','data/hnek/Upload/201901/05/5c3059707abea.jpg',1546672496),(478,0,'6368221007467536875291195.jpg','data/hnek/Upload/201901/05/5c3059dd88fdf.jpg',1546672605),(479,0,'1546824909(1).jpg','data/hnek/Upload/201901/07/5c32ace8e6a6a.jpg',1546824936),(480,0,'1546825579(1).jpg','data/hnek/Upload/201901/07/5c32af862333d.jpg',1546825606),(481,0,'uisdc-kh-20190105-11.jpg','data/hnek/Upload/201901/07/5c32ffda59d0f.jpg',1546846170),(482,0,'1546824909(1).jpg','data/hnek/Upload/201901/08/5c3414d20563b.jpg',1546917074),(483,0,'1546917027(1).jpg','data/hnek/Upload/201901/08/5c3414da82d8c.jpg',1546917082),(484,0,'6368255281001943817334910.jpg','data/hnek/Upload/201901/08/5c34418112705.jpg',1546928513),(485,0,'6368247592892342674528298.jpg','data/hnek/Upload/201901/08/5c3441e6ca30e.jpg',1546928614),(486,0,'1547018680(1).jpg','data/hnek/Upload/201901/09/5c35a22dd30b3.jpg',1547018797),(487,0,'1547021262(1).jpg','data/hnek/Upload/201901/09/5c35ac055bf1f.jpg',1547021317),(488,0,'uisdc-hz-20190105-6.jpg','data/hnek/Upload/201901/10/5c36e816a9a07.jpg',1547102230),(489,0,'1547173814(1).jpg','data/hnek/Upload/201901/11/5c37ffe763b2a.jpg',1547173863),(490,0,'1547187639(1).jpg','data/hnek/Upload/201901/11/5c38360846469.jpg',1547187720),(491,0,'1547258080(1).jpg','data/hnek/Upload/201901/12/5c3948fd98d71.jpg',1547258109),(492,0,'1547274330(1).jpg','data/hnek/Upload/201901/12/5c3988be7cdea.jpg',1547274430),(493,0,'1547606553(1).jpg','data/hnek/Upload/201901/16/5c3e9e01a9f67.jpg',1547607553),(494,0,'1547606553(1).jpg','data/hnek/Upload/201901/16/5c3ed5abb7e1f.jpg',1547621803),(495,0,'1547621821(1).jpg','data/hnek/Upload/201901/16/5c3ed5ec9967d.jpg',1547621868),(496,0,'1_xailq-4ZEybNkj9xMAkdyw.png','data/hnek/Upload/201901/16/5c3ed659f2583.png',1547621977),(497,0,'1547776102(1).jpg','data/hnek/Upload/201901/18/5c4131cd43940.jpg',1547776461),(498,0,'1547862182.jpg','data/hnek/Upload/201901/19/5c4280e1ad3fe.jpg',1547862241),(499,0,'uisdc-mg-20190117-26.jpg','data/hnek/Upload/201901/19/5c4281e2070f6.jpg',1547862498),(500,0,'uisdc-bc-20190118-3.gif','data/hnek/Upload/201901/21/5c452cdf6b5c1.gif',1548037343),(501,0,'1548124938(1).jpg','data/hnek/Upload/201901/22/5c46832ca81dd.jpg',1548124972),(502,0,'07-87-bevys.gif','data/hnek/Upload/201901/23/5c47dd0ac69b3.gif',1548213514),(503,0,'uisdc-gj-20190121-2.jpg','data/hnek/Upload/201901/23/5c47dd7224230.jpg',1548213618),(504,0,'spacemarbles.jpg','data/hnek/Upload/201901/24/5c491dde0a43d.jpg',1548295646),(505,0,'uisdc-yx-20190121-15.jpg','data/hnek/Upload/201901/24/5c4929459d8c4.jpg',1548298565),(506,0,'uisdc-yx-20190122-68.jpg','data/hnek/Upload/201901/25/5c4a87e734b6d.jpg',1548388327),(507,0,'1550019945(1).jpg','data/hnek/Upload/201902/13/5c6370eb0aeff.jpg',1550020843),(508,0,'1550045684(1).jpg','data/hnek/Upload/201902/13/5c63d210a8f54.jpg',1550045712),(509,0,'1550123823(1).jpg','data/hnek/Upload/201902/14/5c65034ee7e3d.jpg',1550123854),(510,0,'uisdc-rz-20190126-13.jpg','data/hnek/Upload/201902/15/5c661bc68217c.jpg',1550195654),(511,0,'uisdc-rx-20190126-11.jpg','data/hnek/Upload/201902/15/5c66609bc398f.jpg',1550213275),(512,0,'uisdc-rj-20190126-7.jpg','data/hnek/Upload/201902/15/5c66653376836.jpg',1550214451),(513,0,'uisdc-fs-20190126-7.jpg','data/hnek/Upload/201902/15/5c66751dbccbb.jpg',1550218525),(514,0,'uisdc-fz-20190126-5.jpg','data/hnek/Upload/201902/16/5c677b33c7d38.jpg',1550285619),(515,0,'uisdc-fx-20190126-6.jpg','data/hnek/Upload/201902/16/5c67839ace4b5.jpg',1550287770),(516,0,'dw-details-1_4x.jpg','data/hnek/Upload/201902/18/5c6a8269f3f11.jpg',1550484073),(517,0,'1550484144(1).jpg','data/hnek/Upload/201902/18/5c6a82c121ac6.jpg',1550484161),(518,0,'uisdc-ll-20190214-38.jpg','data/hnek/Upload/201902/19/5c6b6ee994938.jpg',1550544617),(519,0,'1550654188(1).jpg','data/hnek/Upload/201902/20/5c6d1b0ea8e54.jpg',1550654222),(520,0,'1550818702(1).jpg','data/hnek/Upload/201902/22/5c6f9da8010e8.jpg',1550818728),(521,0,'photo-1494280257169-55829fedd76e.jpeg','data/hnek/Upload/201902/25/5c734a3185e35.jpeg',1551059505),(522,0,'photo-1467358895199-cd5d1847a7e4.jpeg','data/hnek/Upload/201902/25/5c734c58a26e4.jpeg',1551060056),(523,0,'photo-1518081461904-9d8f136351c2.jpeg','data/hnek/Upload/201902/26/5c7491733bf60.jpeg',1551143283),(524,0,'uisdc-tx-20190222-13.gif','data/hnek/Upload/201902/26/5c74e5b3e93dd.gif',1551164851),(525,0,'uisdc-yx-20190225-7.jpg','data/hnek/Upload/201903/01/5c788b759f5be.jpg',1551403893),(526,0,'1__hIc_YOPNCinIB-Zv2nOrw.jpeg','data/hnek/Upload/201903/02/5c79e4c343c42.jpeg',1551492291),(527,0,'uisdc-fz-20190301-25.jpg','data/hnek/Upload/201903/04/5c7c7b618f522.jpg',1551661921),(528,0,'photo-1457305237443-44c3d5a30b89.jpeg','data/hnek/Upload/201903/06/5c7f28beb0a8a.jpeg',1551837374),(529,0,'1_eYhZirQvHi-96wLNKVmSA.png','data/hnek/Upload/201903/07/5c80ce1923c94.png',1551945241),(530,0,'uisdc-yx-20190306-5.jpg','data/hnek/Upload/201903/08/5c81d4e438ccd.jpg',1552012516),(531,0,'uisdc-wr-20190307-4.jpg','data/hnek/Upload/201903/09/5c83186ce9eac.jpg',1552095340),(532,0,'uisdc-xz-20190309-21.jpg','data/hnek/Upload/201903/13/5c888041b78f6.jpg',1552449601),(533,0,'1552525975(1).jpg','data/hnek/Upload/201903/14/5c89aba4a8a4e.jpg',1552526244),(534,0,'1552547383(1).jpg','data/hnek/Upload/201903/14/5c89fe4c60fdf.jpg',1552547404),(535,0,'1_uHuKimObDPFEBMNYuM9jYQ.jpeg','data/hnek/Upload/201903/15/5c8afc3fd382b.jpeg',1552612415),(536,0,'1_RCb5pMTZtnqwjLy47qCxHw.jpeg','data/hnek/Upload/201903/18/5c8f1200018c2.jpeg',1552880128),(537,0,'1553153106(1).jpg','data/hnek/Upload/201903/21/5c933c92b6a40.jpg',1553153170),(538,0,'1.jpg','data/hnek/Upload/201903/30/5c9f3053a211a.jpg',1553936467),(539,0,'2.jpg','data/hnek/Upload/201903/30/5c9f309327c9d.jpg',1553936531),(540,0,'3.jpg','data/hnek/Upload/201903/30/5c9f30eb2b264.jpg',1553936619),(541,0,'u=2179834628,1828570270&fm=26&gp=0.jpg','data/hnek/Upload/201904/13/5cb14370e8905.jpg',1555121008),(542,0,'u=3045047282,1528797987&fm=26&gp=0.jpg','data/hnek/Upload/201904/13/5cb143804a8d9.jpg',1555121024),(543,0,'2018领跑logo22.jpg','data/hnek/Upload/202003/24/5e79b3873499b.jpg',1585034119),(544,0,'6371910700734616455857252.png','data/hnek/Upload/202003/24/5e79b46d89f9d.png',1585034349),(545,0,'LOGO.png','data/hnek/Upload/202003/24/5e79b55e1f2f5.png',1585034590),(546,0,'图形1.jpg','data/hnek/Upload/202003/24/5e79cf6d82e24.jpg',1585041261),(547,0,'2020.jpg','data/hnek/Upload/202003/24/5e79d0eae2fa3.jpg',1585041642),(548,0,'666666666.jpg','data/hnek/Upload/202003/24/5e79d17e4adcb.jpg',1585041790),(549,0,'666666666.jpg','data/hnek/Upload/202003/24/5e79d1cd89d18.jpg',1585041869),(550,0,'000000000.jpg','data/hnek/Upload/202003/24/5e79d713a6d78.jpg',1585043219),(551,0,'3333333.jpg','data/hnek/Upload/202003/24/5e79d78edd1b0.jpg',1585043342),(552,0,'8888888888.jpg','data/hnek/Upload/202003/24/5e79d84946cdb.jpg',1585043529),(553,0,'8888888888888.jpg','data/hnek/Upload/202003/24/5e7a163e80bf6.jpg',1585059390),(554,0,'8888888888888.jpg','data/hnek/Upload/202003/24/5e7a182ca5df3.jpg',1585059884),(555,0,'8888888888888.jpg','data/hnek/Upload/202003/24/5e7a18c9bdfed.jpg',1585060041),(556,0,'8888888888888.jpg','data/hnek/Upload/202003/24/5e7a1a49bfd8e.jpg',1585060425),(557,0,'8888888888888.jpg','data/hnek/Upload/202003/24/5e7a1a8da90bf.jpg',1585060493),(558,0,'8888888888888.jpg','data/hnek/Upload/202003/24/5e7a1af053dab.jpg',1585060592),(559,0,'8888888888888.jpg','data/hnek/Upload/202003/24/5e7a1b3083bad.jpg',1585060656),(560,0,'8888888888888.jpg','data/hnek/Upload/202003/24/5e7a1b849061c.jpg',1585060740),(561,0,'8888888888888.jpg','data/hnek/Upload/202003/24/5e7a1bcd50a7f.jpg',1585060813),(562,0,'8888888888888.jpg','data/hnek/Upload/202003/24/5e7a1c4770380.jpg',1585060935),(563,0,'8888888888888.jpg','data/hnek/Upload/202003/24/5e7a20a508c72.jpg',1585062053),(564,0,'8888888888888.jpg','data/hnek/Upload/202003/24/5e7a21e97b24b.jpg',1585062377),(565,0,'666.jpg','data/hnek/Upload/202003/25/5e7a977d6e69c.jpg',1585092477),(566,0,'666.jpg','data/hnek//Upload/202003/25/5e7a97ce56b3f.jpg',1585092558),(567,0,'666.jpg','data/hnek/Upload/202003/25/5e7a98504a49e.jpg',1585092688),(568,0,'1.jpg','data/hnek/Upload/202003/25/5e7abbd972ced.jpg',1585101785),(569,0,'2.jpg','data/hnek/Upload/202003/25/5e7abbe84ca94.jpg',1585101800),(570,0,'3.jpg','data/hnek/Upload/202003/25/5e7abbf6d0b19.jpg',1585101814),(571,0,'99999999999999.jpg','data/hnek/Upload/202003/25/5e7aca73cf2de.jpg',1585105523),(572,0,'99999999999999.jpg','data/hnek/Upload/202003/25/5e7acb22a493f.jpg',1585105698),(573,0,'99999999999999.jpg','data/hnek/Upload/202003/25/5e7acb65c1a50.jpg',1585105765),(574,0,'99999999999999.jpg','data/hnek/Upload/202003/25/5e7acbabb6cc2.jpg',1585105835),(575,0,'99999999999999.jpg','data/hnek/Upload/202003/25/5e7acc54087f9.jpg',1585106004),(576,0,'99999999999999.jpg','data/hnek/Upload/202003/25/5e7acc9b191a0.jpg',1585106075),(577,0,'99999999999999.jpg','data/hnek/Upload/202003/25/5e7acd28907c5.jpg',1585106216),(578,0,'99999999999999.jpg','data/hnek/Upload/202003/25/5e7acd7162177.jpg',1585106289),(579,0,'99999999999999.jpg','data/hnek/Upload/202003/25/5e7acdc220a18.jpg',1585106370),(580,0,'888889999.jpg','data/hnek/Upload/202003/25/5e7acdf490843.jpg',1585106420),(581,0,'888889999.jpg','data/hnek/Upload/202003/25/5e7ace783fbd8.jpg',1585106552),(582,0,'66666666666.jpg','data/hnek/Upload/202003/25/5e7b46989df73.jpg',1585137304),(583,0,'66666666666.jpg','data/hnek/Upload/202003/25/5e7b46d72ac37.jpg',1585137367),(584,0,'66666666666.jpg','data/hnek/Upload/202003/25/5e7b47446cc9a.jpg',1585137476),(585,0,'66666666666.jpg','data/hnek/Upload/202003/25/5e7b47b85acf5.jpg',1585137592),(586,0,'66666666666.jpg','data/hnek/Upload/202003/25/5e7b480c978e9.jpg',1585137676),(587,0,'888888888.jpg','data/hnek/Upload/202003/25/5e7b487660fdc.jpg',1585137782),(588,0,'77777.jpg','data/hnek/Upload/202003/25/5e7b49e8b42fe.jpg',1585138152),(589,0,'22222222222.jpg','data/hnek/Upload/202003/25/5e7b4da48fb0e.jpg',1585139108),(590,0,'15482315682027051.png','data/hnek/Upload/202003/25/5e7b4fc05b4d1.png',1585139648),(591,0,'33333.jpg','data/hnek/Upload/202003/25/5e7b5641633e7.jpg',1585141313),(592,0,'66666666.jpg','data/hnek/Upload/202003/25/5e7b57bfc50c6.jpg',1585141695),(593,0,'66666666.jpg','data/hnek/Upload/202003/25/5e7b59c637a48.jpg',1585142214),(594,0,'66666666.jpg','data/hnek/Upload/202003/25/5e7b61eb777f8.jpg',1585144299),(595,0,'77777.jpg','data/hnek/Upload/202003/25/5e7b63cff0873.jpg',1585144783),(596,0,'77777.jpg','data/hnek/Upload/202003/25/5e7b63fd52470.jpg',1585144829),(597,0,'888.jpg','data/hnek/Upload/202003/25/5e7b64de56e07.jpg',1585145054),(598,0,'666666.jpg','data/hnek/Upload/202003/26/5e7beef7d89c2.jpg',1585180407),(599,0,'88888888888888888.jpg','data/hnek/Upload/202003/26/5e7c1bbf993cd.jpg',1585191871),(600,0,'66666666.jpg','data/hnek/Upload/202003/26/5e7c1c2ece138.jpg',1585191982),(601,0,'66666666.jpg','data/hnek/Upload/202003/26/5e7c1e489fca3.jpg',1585192520),(602,0,'20202020.jpg','data/hnek/Upload/202003/26/5e7c26ce35a26.jpg',1585194702),(603,0,'f601b776d6c24c8faff43cc4a429a90f.jpg','data/hnek/Upload/202003/26/5e7c278b44d9e.jpg',1585194891),(604,0,'8ffda41396f741cd8b87ee408f264bef.png','data/hnek/Upload/202003/26/5e7c28195e7cf.png',1585195033),(605,0,'6372063813741455947573965.png','data/hnek/Upload/202003/26/5e7c28b4e99a8.png',1585195188),(606,0,'33333333333333.jpg','data/hnek/Upload/202003/26/5e7c4eac51442.jpg',1585204908),(607,0,'33333333333333.jpg','data/hnek/Upload/202003/26/5e7c5204402b3.jpg',1585205764),(608,0,'lead banner20200326 .jpg','data/hnek/Upload/202003/26/5e7c55936c87d.jpg',1585206675),(609,0,'999999999999999.jpg','data/hnek/Upload/202003/26/5e7c5d0de53db.jpg',1585208589),(610,0,'999999999999999.jpg','data/hnek/Upload/202003/26/5e7c5d15917a6.jpg',1585208597),(611,0,'66666.jpg','data/hnek/Upload/202003/26/5e7ca0c124ee6.jpg',1585225921),(612,0,'banner666.jpg','data/hnek/Upload/202003/26/5e7ca2c52f77f.jpg',1585226437),(613,0,'banner666.jpg','data/hnek/Upload/202003/26/5e7ca3c80d60c.jpg',1585226696),(614,0,'banner666.jpg','data/hnek/Upload/202003/26/5e7ca59061fe0.jpg',1585227152),(615,0,'banner666.jpg','data/hnek/Upload/202003/26/5e7ca6f2dd484.jpg',1585227506),(616,0,'222222.jpg','data/hnek/Upload/202003/26/5e7cb17e2ebc5.jpg',1585230206),(617,0,'000000000000000000000000000.jpg','data/hnek/Upload/202003/26/5e7cb2d3d124b.jpg',1585230547),(618,0,'000000000000000000000000000.jpg','data/hnek/Upload/202003/26/5e7cb3084b2b3.jpg',1585230600),(619,0,'000000000000000000000000000.jpg','data/hnek/Upload/202003/26/5e7cb39bc8649.jpg',1585230747),(620,0,'333333333333333333333333.jpg','data/hnek/Upload/202003/26/5e7cb539db3bd.jpg',1585231161),(621,0,'8ffda41396f741cd8b87ee408f264bef.png','data/hnek/Upload/202003/26/5e7cb5bdcb27d.png',1585231293),(622,0,'99999999.jpg','data/hnek/Upload/202003/26/5e7cb5d7e2fe3.jpg',1585231319),(623,0,'6371357544760428486342749.jpg','data/hnek/Upload/202003/27/5e7de96270cee.jpg',1585310050),(624,0,'6371357544760428486342749.jpg','data/hnek/Upload/202003/27/5e7de99a16490.jpg',1585310106),(625,0,'002.jpg','data/hnek/Upload/202003/27/5e7deac9da081.jpg',1585310409),(626,0,'006.jpg','data/hnek/Upload/202003/27/5e7df1f057038.jpg',1585312240),(627,0,'15837340703530805.png','data/hnek/Upload/202004/01/5e8497907ccb9.png',1585747856),(628,0,'logo_04.png','data/hnek/Upload/202004/02/5e85ed291eb39.png',1585835305),(629,0,'2ad6519f0a634d0692f7ebf7815026c0.jpg','data/hnek/Upload/202004/02/5e85f03f64844.jpg',1585836095),(630,0,'fb021ccaf7114b34a77d07224b372271.jpg','data/hnek/Upload/202004/02/5e85f4b17a022.jpg',1585837233),(631,0,'5e840a152f3f2.jpg','data/hnek/Upload/202004/02/5e85f58eec00d.jpg',1585837454),(632,0,'5e7de5ee59a39.jpg','data/hnek/Upload/202004/02/5e85f7ef61757.jpg',1585838063),(633,0,'5e6b8bd78106c.png','data/hnek/Upload/202004/02/5e85fb516da6e.png',1585838929),(634,0,'6372152421815575695632732.jpg','data/hnek/Upload/202004/06/5e8a8d4f325dd.jpg',1586138447),(635,0,'7-200405214945.jpg','data/hnek/Upload/202004/06/5e8a8ea208b7d.jpg',1586138786),(636,0,'ABUIABACGAAgqJzUugUotNSR8QQwtwQ4oAY.jpg','data/hnek//Upload/202004/06/5e8b2d0114f5f.jpg',1586179329),(637,0,'建业新生活.jpg','data/hnek/Upload/202004/06/5e8b2f991d177.jpg',1586179993),(638,0,'建业新生活.jpg','data/hnek//Upload/202004/06/5e8b2fe19ba54.jpg',1586180065),(639,0,'未标题-1.jpg','data/hnek/Upload/202004/06/5e8b31c73045e.jpg',1586180551),(640,0,'QQ图片20200406214659.png','data/hnek/Upload/202004/06/5e8b338455917.png',1586180996),(641,0,'QQ图片20200406220028.jpg','data/hnek/Upload/202004/06/5e8b368e0fc50.jpg',1586181774),(642,0,'mmexport1565922892732.jpg','data/hnek//Upload/202004/06/5e8b3742989d9.jpg',1586181954),(643,0,'mmexport1565922900819.jpg','data/hnek//Upload/202004/06/5e8b374523685.jpg',1586181957),(644,0,'QQ图片20200406220028.jpg','data/hnek//Upload/202004/06/5e8b37467c44e.jpg',1586181958),(645,0,'mmexport1565922850785.jpg','data/hnek/Upload/202004/06/5e8b37f7d7b42.jpg',1586182135),(646,0,'mmexport1565922825658.jpg','data/hnek//Upload/202004/06/5e8b383795528.jpg',1586182199),(647,0,'mmexport1565922831363 - 副本.jpg','data/hnek//Upload/202004/06/5e8b3838dbdfd.jpg',1586182200),(648,0,'mmexport1565922831363.jpg','data/hnek//Upload/202004/06/5e8b383a5c6e4.jpg',1586182202),(649,0,'mmexport1565922850785 - 副本.jpg','data/hnek//Upload/202004/06/5e8b383bd0252.jpg',1586182203),(650,0,'mmexport1565922850785.jpg','data/hnek//Upload/202004/06/5e8b383d9b679.jpg',1586182205),(651,0,'mmexport1565922825658.jpg','data/hnek//Upload/202004/06/5e8b386a10179.jpg',1586182250),(652,0,'mmexport1565922831363.jpg','data/hnek//Upload/202004/06/5e8b386b32c17.jpg',1586182251),(653,0,'mmexport1565922850785.jpg','data/hnek//Upload/202004/06/5e8b386c867e0.jpg',1586182252),(654,0,'mmexport1565922854383.jpg','data/hnek//Upload/202004/06/5e8b386dde9fa.jpg',1586182253),(655,0,'mmexport1565922857901.jpg','data/hnek//Upload/202004/06/5e8b386f4490b.jpg',1586182255),(656,0,'mmexport1565922863791.jpg','data/hnek//Upload/202004/06/5e8b3870bbb38.jpg',1586182256),(657,0,'mmexport1565922892732.jpg','data/hnek//Upload/202004/06/5e8b38e1b99aa.jpg',1586182369),(658,0,'mmexport1565922900819.jpg','data/hnek//Upload/202004/06/5e8b38e279a34.jpg',1586182370),(659,0,'QQ图片20200406220028.jpg','data/hnek//Upload/202004/06/5e8b38e2cb2dc.jpg',1586182370),(660,0,'建业新生活.jpg','data/hnek//Upload/202004/06/5e8b39441728a.jpg',1586182468),(661,0,'建业新生活.jpg','data/hnek//Upload/202004/06/5e8b397c5bd2b.jpg',1586182524),(662,0,'QQ图片20200407095525.png','data/hnek//Upload/202004/07/5e8bddbebee17.png',1586224574),(663,0,'QQ图片20200407095525.png','data/hnek//Upload/202004/07/5e8bdde999216.png',1586224617),(664,0,'QQ图片20200407095525.png','data/hnek//Upload/202004/07/5e8bde30972ad.png',1586224688),(665,0,'QQ图片20200407095525.png','data/hnek//Upload/202004/07/5e8bde55ea6c3.png',1586224725),(666,0,'1046101601-0.jpg','data/hnek/Upload/202004/07/5e8bfefb9b296.jpg',1586233083),(667,0,'河南资产.jpg','data/hnek/Upload/202004/07/5e8c8cd4add71.jpg',1586269396),(668,0,'河南资产.jpg','data/hnek/Upload/202004/07/5e8c8e065bbd9.jpg',1586269702),(669,0,'河南资产.jpg','data/hnek//Upload/202004/07/5e8c8e54ecbc2.jpg',1586269780),(670,0,'河南资产0.jpg','data/hnek/Upload/202004/07/5e8c8f877f87a.jpg',1586270087),(671,0,'河南资产0.jpg','data/hnek/Upload/202004/07/5e8c9075cd15c.jpg',1586270325),(672,0,'贝贝特logo.jpg','data/hnek/Upload/202004/07/5e8c963669b26.jpg',1586271798),(673,0,'贝贝特logo.jpg','data/hnek//Upload/202004/07/5e8c96e2a3518.jpg',1586271970),(674,0,'贝贝特logo.jpg','data/hnek//Upload/202004/07/5e8c9736e5ae3.jpg',1586272054),(675,0,'图形1.jpg','data/hnek/Upload/202004/09/5e8ea73c4dbbc.jpg',1586407228),(676,0,'7-20040Z10156.jpg','data/hnek/Upload/202004/09/5e8ed09fa88a8.jpg',1586417823),(677,0,'00.jpg','data/hnek/Upload/202004/09/5e8ed6105ef57.jpg',1586419216),(678,0,'5e92679b131de.jpg','data/hnek/Upload/202004/14/5e95ae33289e4.jpg',1586867763),(679,0,'5ea81597bf5e9.jpg','data/hnek/Upload/202005/01/5eab89be87f49.jpg',1588300222),(680,0,'5ea81597bf5e9.jpg','data/hnek/Upload/202005/01/5eab8a1f89930.jpg',1588300319),(681,0,'202004291155247589.jpg','data/hnek/Upload/202005/02/5eacb4909e704.jpg',1588376720),(682,0,'202004281934156292.jpg','data/hnek/Upload/202005/02/5eacb586b3ca8.jpg',1588376966),(683,0,'01.jpg','data/hnek/Upload/202005/10/5eb740e026d15.jpg',1589068000),(684,0,'464787dd31e64492aba01f75bd7c4884.jpg','data/hnek/Upload/202005/21/5ec5bed3db94f.jpg',1590017747),(685,0,'15837340837028166.png','data/hnek/Upload/202006/07/5edc50500d2ae.png',1591496784),(686,0,'5ed617f471c50.png','data/hnek/Upload/202006/07/5edc51081d1fc.png',1591496968),(687,0,'3f22916e4a8c49f4450341ff137432f7.jpg','data/hnek/Upload/202006/07/5edc525a9d568.jpg',1591497306),(688,0,'5ed0c66e7b2fd.jpg','data/hnek/Upload/202006/07/5edc593002e40.jpg',1591499056),(689,0,'5eb8b6d63b4bd.jpg','data/hnek/Upload/202006/07/5edc5a00d66ca.jpg',1591499264),(690,0,'6372238756127092569190776.png','data/hnek/Upload/202006/08/5ede3c22b663e.png',1591622690),(691,0,'df4513ac-136d-4ef8-854f-b36d1554bc2c.jpg','data/hnek/Upload/202006/11/5ee23a72ed4a8.jpg',1591884402),(692,0,'5efeab16c4581.jpeg','data/hnek/Upload/202007/04/5f0083967d968.jpeg',1593869206),(693,0,'5efd419bcae25.jpg','data/hnek/Upload/202007/04/5f008404b1eee.jpg',1593869316),(694,0,'5f19333963dbf.png','data/hnek/Upload/202007/26/5f1ce91461dad.png',1595730196),(695,0,'6373171924916897851246301.jpg','data/hnek/Upload/202008/16/5f387bec022e3.jpg',1597537260),(696,0,'5f32587d996e1.png','data/hnek/Upload/202008/16/5f387da5ac802.png',1597537701),(697,0,'6371453091571210373491699.jpg','data/hnek/Upload/202009/04/5f517f18c9d9b.jpg',1599176472),(698,0,'40466674bb8a44fca3a70bfe241fe429.jpg','data/hnek/Upload/202009/04/5f517f940792a.jpg',1599176596),(699,0,'56b71a627d3d4a91880e5bc4939bead5.png','data/hnek/Upload/202009/26/5f6f02b619289.png',1601110710),(700,0,'728b4652-9fc7-4e81-9113-104f34c45163.png','data/hnek/Upload/202009/26/5f6f05673b580.png',1601111399),(701,0,'20201118011815997.jpeg','data/hnek/Upload/202011/21/5fb90b37d9d78.jpeg',1605962551),(702,0,'56b71a627d3d4a91880e5bc4939bead5.png','data/hnek/Upload/202101/23/600c1c26b176f.png',1611406374),(703,0,'6370787189436702056429857.png','data/hnek/Upload/202101/23/600c1d9e89ad5.png',1611406750),(704,0,'QQ图片20200406214659.png','data/hnek/Upload/202101/27/60117289bf10f.png',1611756169),(705,0,'66.jpg','data/hnek/Upload/202101/27/60117415a4cf3.jpg',1611756565),(706,0,'666.jpg','data/hnek/Upload/202101/27/60117681e74ce.jpg',1611757185),(707,0,'77777.jpg','data/hnek/Upload/202101/27/60117be7ba4ca.jpg',1611758567),(708,0,'88.jpg','data/hnek/Upload/202101/27/60117d2f2c124.jpg',1611758895),(709,0,'7777.jpg','data/hnek/Upload/202101/27/60118117b48d2.jpg',1611759895),(710,0,'8911199efc7941c29ca5e3f9a651ec43.png','data/hnek/Upload/202107/31/610535f47d2d7.png',1627731444),(711,0,'lead banner20200326 .jpg','data/hnek/Upload/202108/18/611c5dbc63ab8.jpg',1629248956),(712,0,'lead banner20200326 .jpg','data/hnek/Upload/202108/18/611c5f9a2c600.jpg',1629249434),(713,0,'lead banner20200326 .jpg','data/hnek/Upload/202108/18/611c60271cf0c.jpg',1629249575),(714,0,'lead banner20200326 .jpg','data/hnek/Upload/202108/18/611c609eaa94c.jpg',1629249694),(715,0,'lead banner20200326 .jpg','data/hnek/Upload/202108/18/611c60c739654.jpg',1629249735),(716,0,'lingpao banna.jpg','data/hnek/Upload/202109/16/6142fbbf7efe6.jpg',1631779775),(717,0,'lingpao banna.jpg','data/hnek/Upload/202109/16/6142fc0f971a7.jpg',1631779855),(718,0,'fd2e2e74ef6442dfbf05824eafcaf046.jpg','data/hnek/Upload/202109/16/6142fcbf4cb37.jpg',1631780031),(719,0,'fd2e2e74ef6442dfbf05824eafcaf046.jpg','data/hnek/Upload/202109/16/6142fd3850e11.jpg',1631780152),(720,0,'02.jpg','data/hnek/Upload/202109/16/6142fe2dc32f8.jpg',1631780397),(721,0,'02.jpg','data/hnek/Upload/202109/16/6142fe5b40245.jpg',1631780443),(722,0,'72.jpg','data/hnek/Upload/202110/29/617b5f0e65010.jpg',1635475214),(723,0,'72.jpg','data/hnek/Upload/202110/29/617b5f3c2bb1f.jpg',1635475260),(724,0,'150.jpg','data/hnek/Upload/202110/29/617b5fa5c8672.jpg',1635475365),(725,0,'150.jpg','data/hnek/Upload/202110/29/617b5fc7c2081.jpg',1635475399),(726,0,'72.jpg','data/hnek/Upload/202110/29/617b5fe37b80a.jpg',1635475427),(727,0,'30000.jpg','data/hnek/Upload/202110/31/617e3c0ec4e99.jpg',1635662862),(728,0,'30000.jpg','data/hnek/Upload/202110/31/617e3c392803d.jpg',1635662905),(729,0,'150.jpg','data/hnek/Upload/202110/31/617e3c7c09401.jpg',1635662972),(730,0,'1200000.jpg','data/hnek/Upload/202110/31/617e3ce092d18.jpg',1635663072),(731,0,'1200000.jpg','data/hnek/Upload/202110/31/617e3d07615ca.jpg',1635663111),(732,0,'72.jpg','data/hnek/Upload/202110/31/617e3d3fe1146.jpg',1635663167),(733,0,'6378770816718960476241345.jpg','data/hnek/Upload/202205/16/6282079725379.jpg',1652688791),(734,0,'6378770816718960476241345.jpg','data/hnek/Upload/202205/16/628207fe38d97.jpg',1652688894),(735,0,'6378448777075153007142338.jpg','data/hnek/Upload/202205/16/6282098c0ab9b.jpg',1652689292),(736,0,'6378448777075153007142338.jpg','data/hnek/Upload/202205/16/628209cacecf0.jpg',1652689354),(737,0,'轮播图15周年.jpg','data/hnek/Upload/202212/09/6392a8ab009f7.jpg',1670555819),(738,0,'轮播图15周年.jpg','data/hnek/Upload/202212/09/6392a8d21d487.jpg',1670555858),(739,0,'轮播图15周年.jpg','data/hnek/Upload/202212/09/6392ab46bd4c7.jpg',1670556486),(740,0,'MAIN202212080925000584178865090.jpg','data/hnek/Upload/202212/09/6392b4762574e.jpg',1670558838);
/*!40000 ALTER TABLE `cmsx_attachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmsx_bbs`
--

DROP TABLE IF EXISTS `cmsx_bbs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmsx_bbs` (
  `bbs_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT '0',
  `title` text,
  `name` varchar(200) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  `is_show` int(1) DEFAULT '0',
  `ip` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`bbs_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmsx_bbs`
--

LOCK TABLES `cmsx_bbs` WRITE;
/*!40000 ALTER TABLE `cmsx_bbs` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmsx_bbs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmsx_cart`
--

DROP TABLE IF EXISTS `cmsx_cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmsx_cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL,
  `goods_attr` text NOT NULL,
  `goods_num` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `goods_type` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cart_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmsx_cart`
--

LOCK TABLES `cmsx_cart` WRITE;
/*!40000 ALTER TABLE `cmsx_cart` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmsx_cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmsx_goods`
--

DROP TABLE IF EXISTS `cmsx_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmsx_goods` (
  `goods_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT '0',
  `name` varchar(500) NOT NULL,
  `price` float(10,2) DEFAULT NULL,
  `point` int(11) NOT NULL,
  `is_pos` int(1) DEFAULT '0',
  `description` varchar(1500) DEFAULT NULL,
  `image` varchar(500) DEFAULT NULL,
  `shelf` int(1) DEFAULT NULL,
  `content` text,
  `goods_attr` varchar(2000) NOT NULL,
  `sales` int(11) NOT NULL,
  `add_time` int(11) DEFAULT NULL,
  `update_time` int(11) NOT NULL,
  `listorder` int(11) DEFAULT NULL,
  PRIMARY KEY (`goods_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmsx_goods`
--

LOCK TABLES `cmsx_goods` WRITE;
/*!40000 ALTER TABLE `cmsx_goods` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmsx_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmsx_goods_album`
--

DROP TABLE IF EXISTS `cmsx_goods_album`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmsx_goods_album` (
  `album_id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL,
  `image` varchar(500) NOT NULL,
  PRIMARY KEY (`album_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmsx_goods_album`
--

LOCK TABLES `cmsx_goods_album` WRITE;
/*!40000 ALTER TABLE `cmsx_goods_album` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmsx_goods_album` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmsx_guestbook`
--

DROP TABLE IF EXISTS `cmsx_guestbook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmsx_guestbook` (
  `guestbook_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `tel` varchar(200) DEFAULT NULL,
  `qq` varchar(200) DEFAULT NULL,
  `sex` int(1) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `introduce` text,
  `add_time` int(11) DEFAULT NULL,
  `reply` text,
  `is_show` int(1) DEFAULT NULL,
  `content_id` int(11) DEFAULT NULL,
  `title` varchar(500) NOT NULL,
  `url` varchar(200) NOT NULL,
  PRIMARY KEY (`guestbook_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmsx_guestbook`
--

--
-- Table structure for table `cmsx_job_position`
--

DROP TABLE IF EXISTS `cmsx_job_position`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmsx_job_position` (
  `position_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `type` varchar(200) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `number` varchar(200) DEFAULT NULL,
  `duties` text,
  `claim` text,
  `add_time` int(10) DEFAULT NULL,
  `update_time` int(10) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  PRIMARY KEY (`position_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmsx_job_position`
--

LOCK TABLES `cmsx_job_position` WRITE;
/*!40000 ALTER TABLE `cmsx_job_position` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmsx_job_position` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmsx_keywords`
--

DROP TABLE IF EXISTS `cmsx_keywords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmsx_keywords` (
  `keywords_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`keywords_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmsx_keywords`
--

LOCK TABLES `cmsx_keywords` WRITE;
/*!40000 ALTER TABLE `cmsx_keywords` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmsx_keywords` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmsx_keywords_category`
--

DROP TABLE IF EXISTS `cmsx_keywords_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmsx_keywords_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `need` enum('0','1') NOT NULL DEFAULT '0',
  `listorder` int(10) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmsx_keywords_category`
--

LOCK TABLES `cmsx_keywords_category` WRITE;
/*!40000 ALTER TABLE `cmsx_keywords_category` DISABLE KEYS */;
INSERT INTO `cmsx_keywords_category` VALUES (1,'品牌设计，logo设计，郑州画册设计，领跑广告','0',99);
/*!40000 ALTER TABLE `cmsx_keywords_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmsx_member`
--

DROP TABLE IF EXISTS `cmsx_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmsx_member` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL,
  `password` varchar(32) NOT NULL,
  `safe_code` varchar(8) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `point` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `add_time` int(11) NOT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmsx_member`
--

LOCK TABLES `cmsx_member` WRITE;
/*!40000 ALTER TABLE `cmsx_member` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmsx_member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmsx_member_address`
--

DROP TABLE IF EXISTS `cmsx_member_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmsx_member_address` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `username` varchar(500) NOT NULL,
  `province` int(11) NOT NULL,
  `city` int(11) NOT NULL,
  `district` int(11) NOT NULL,
  `address` varchar(1500) NOT NULL,
  `postcode` varchar(500) NOT NULL,
  `phone` varchar(500) NOT NULL,
  PRIMARY KEY (`address_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmsx_member_address`
--

LOCK TABLES `cmsx_member_address` WRITE;
/*!40000 ALTER TABLE `cmsx_member_address` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmsx_member_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmsx_member_point_log`
--

DROP TABLE IF EXISTS `cmsx_member_point_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmsx_member_point_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `point` int(11) NOT NULL,
  `description` varchar(1500) NOT NULL,
  `add_time` int(11) NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmsx_member_point_log`
--

LOCK TABLES `cmsx_member_point_log` WRITE;
/*!40000 ALTER TABLE `cmsx_member_point_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmsx_member_point_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmsx_orders`
--

DROP TABLE IF EXISTS `cmsx_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmsx_orders` (
  `orders_id` int(11) NOT NULL AUTO_INCREMENT,
  `trade_no` varchar(200) CHARACTER SET gbk DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `price` float(10,2) DEFAULT NULL,
  `original_price` float(10,2) NOT NULL,
  `change_price` float(10,2) DEFAULT '0.00',
  `point` int(11) NOT NULL,
  `point_price` float(10,2) NOT NULL,
  `payment_id` varchar(500) DEFAULT NULL,
  `nickname` varchar(500) DEFAULT NULL,
  `address` varchar(1500) DEFAULT NULL,
  `postcode` varchar(500) DEFAULT NULL,
  `phone` varchar(500) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  PRIMARY KEY (`orders_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmsx_orders`
--

LOCK TABLES `cmsx_orders` WRITE;
/*!40000 ALTER TABLE `cmsx_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmsx_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmsx_orders_goods`
--

DROP TABLE IF EXISTS `cmsx_orders_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmsx_orders_goods` (
  `relation_id` int(11) NOT NULL AUTO_INCREMENT,
  `orders_id` int(11) NOT NULL,
  `goods_id` int(11) NOT NULL,
  `goods_name` varchar(500) NOT NULL,
  `goods_image` varchar(500) NOT NULL,
  `goods_attr` varchar(1500) NOT NULL,
  `goods_num` int(11) NOT NULL,
  `price` float(10,2) NOT NULL,
  `goods_type` int(11) NOT NULL,
  `is_package` int(1) NOT NULL,
  `package_id` int(11) NOT NULL,
  PRIMARY KEY (`relation_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmsx_orders_goods`
--

LOCK TABLES `cmsx_orders_goods` WRITE;
/*!40000 ALTER TABLE `cmsx_orders_goods` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmsx_orders_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmsx_package`
--

DROP TABLE IF EXISTS `cmsx_package`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmsx_package` (
  `package_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `price` float(10,2) NOT NULL,
  `point` int(11) NOT NULL,
  `description` varchar(1500) NOT NULL,
  `sales` int(11) NOT NULL,
  `shelf` int(1) NOT NULL,
  `add_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`package_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmsx_package`
--

LOCK TABLES `cmsx_package` WRITE;
/*!40000 ALTER TABLE `cmsx_package` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmsx_package` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmsx_package_goods`
--

DROP TABLE IF EXISTS `cmsx_package_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmsx_package_goods` (
  `relation_id` int(11) NOT NULL AUTO_INCREMENT,
  `package_id` int(11) NOT NULL,
  `goods_id` int(11) NOT NULL,
  PRIMARY KEY (`relation_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmsx_package_goods`
--

LOCK TABLES `cmsx_package_goods` WRITE;
/*!40000 ALTER TABLE `cmsx_package_goods` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmsx_package_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmsx_region`
--

DROP TABLE IF EXISTS `cmsx_region`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmsx_region` (
  `region_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `region_name` varchar(120) NOT NULL DEFAULT '',
  `region_type` tinyint(1) NOT NULL DEFAULT '2',
  PRIMARY KEY (`region_id`),
  KEY `parent_id` (`parent_id`),
  KEY `region_type` (`region_type`)
) ENGINE=MyISAM AUTO_INCREMENT=3409 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmsx_region`
--

LOCK TABLES `cmsx_region` WRITE;
/*!40000 ALTER TABLE `cmsx_region` DISABLE KEYS */;
INSERT INTO `cmsx_region` VALUES (2,0,'北京',1),(3,0,'安徽',1),(4,0,'福建',1),(5,0,'甘肃',1),(6,0,'广东',1),(7,0,'广西',1),(8,0,'贵州',1),(9,0,'海南',1),(10,0,'河北',1),(11,0,'河南',1),(12,0,'黑龙江',1),(13,0,'湖北',1),(14,0,'湖南',1),(15,0,'吉林',1),(16,0,'江苏',1),(17,0,'江西',1),(18,0,'辽宁',1),(19,0,'内蒙古',1),(20,0,'宁夏',1),(21,0,'青海',1),(22,0,'山东',1),(23,0,'山西',1),(24,0,'陕西',1),(25,0,'上海',1),(26,0,'四川',1),(27,0,'天津',1),(28,0,'西藏',1),(29,0,'新疆',1),(30,0,'云南',1),(31,0,'浙江',1),(32,0,'重庆',1),(33,0,'香港',1),(34,0,'澳门',1),(35,0,'台湾',1),(36,3,'安庆',2),(37,3,'蚌埠',2),(38,3,'巢湖',2),(39,3,'池州',2),(40,3,'滁州',2),(41,3,'阜阳',2),(42,3,'淮北',2),(43,3,'淮南',2),(44,3,'黄山',2),(45,3,'六安',2),(46,3,'马鞍山',2),(47,3,'宿州',2),(48,3,'铜陵',2),(49,3,'芜湖',2),(50,3,'宣城',2),(51,3,'亳州',2),(52,2,'北京',2),(53,4,'福州',2),(54,4,'龙岩',2),(55,4,'南平',2),(56,4,'宁德',2),(57,4,'莆田',2),(58,4,'泉州',2),(59,4,'三明',2),(60,4,'厦门',2),(61,4,'漳州',2),(62,5,'兰州',2),(63,5,'白银',2),(64,5,'定西',2),(65,5,'甘南',2),(66,5,'嘉峪关',2),(67,5,'金昌',2),(68,5,'酒泉',2),(69,5,'临夏',2),(70,5,'陇南',2),(71,5,'平凉',2),(72,5,'庆阳',2),(73,5,'天水',2),(74,5,'武威',2),(75,5,'张掖',2),(76,6,'广州',2),(77,6,'深圳',2),(78,6,'潮州',2),(79,6,'东莞',2),(80,6,'佛山',2),(81,6,'河源',2),(82,6,'惠州',2),(83,6,'江门',2),(84,6,'揭阳',2),(85,6,'茂名',2),(86,6,'梅州',2),(87,6,'清远',2),(88,6,'汕头',2),(89,6,'汕尾',2),(90,6,'韶关',2),(91,6,'阳江',2),(92,6,'云浮',2),(93,6,'湛江',2),(94,6,'肇庆',2),(95,6,'中山',2),(96,6,'珠海',2),(97,7,'南宁',2),(98,7,'桂林',2),(99,7,'百色',2),(100,7,'北海',2),(101,7,'崇左',2),(102,7,'防城港',2),(103,7,'贵港',2),(104,7,'河池',2),(105,7,'贺州',2),(106,7,'来宾',2),(107,7,'柳州',2),(108,7,'钦州',2),(109,7,'梧州',2),(110,7,'玉林',2),(111,8,'贵阳',2),(112,8,'安顺',2),(113,8,'毕节',2),(114,8,'六盘水',2),(115,8,'黔东南',2),(116,8,'黔南',2),(117,8,'黔西南',2),(118,8,'铜仁',2),(119,8,'遵义',2),(120,9,'海口',2),(121,9,'三亚',2),(122,9,'白沙',2),(123,9,'保亭',2),(124,9,'昌江',2),(125,9,'澄迈县',2),(126,9,'定安县',2),(127,9,'东方',2),(128,9,'乐东',2),(129,9,'临高县',2),(130,9,'陵水',2),(131,9,'琼海',2),(132,9,'琼中',2),(133,9,'屯昌县',2),(134,9,'万宁',2),(135,9,'文昌',2),(136,9,'五指山',2),(137,9,'儋州',2),(138,10,'石家庄',2),(139,10,'保定',2),(140,10,'沧州',2),(141,10,'承德',2),(142,10,'邯郸',2),(143,10,'衡水',2),(144,10,'廊坊',2),(145,10,'秦皇岛',2),(146,10,'唐山',2),(147,10,'邢台',2),(148,10,'张家口',2),(149,11,'郑州',2),(150,11,'洛阳',2),(151,11,'开封',2),(152,11,'安阳',2),(153,11,'鹤壁',2),(154,11,'济源',2),(155,11,'焦作',2),(156,11,'南阳',2),(157,11,'平顶山',2),(158,11,'三门峡',2),(159,11,'商丘',2),(160,11,'新乡',2),(161,11,'信阳',2),(162,11,'许昌',2),(163,11,'周口',2),(164,11,'驻马店',2),(165,11,'漯河',2),(166,11,'濮阳',2),(167,12,'哈尔滨',2),(168,12,'大庆',2),(169,12,'大兴安岭',2),(170,12,'鹤岗',2),(171,12,'黑河',2),(172,12,'鸡西',2),(173,12,'佳木斯',2),(174,12,'牡丹江',2),(175,12,'七台河',2),(176,12,'齐齐哈尔',2),(177,12,'双鸭山',2),(178,12,'绥化',2),(179,12,'伊春',2),(180,13,'武汉',2),(181,13,'仙桃',2),(182,13,'鄂州',2),(183,13,'黄冈',2),(184,13,'黄石',2),(185,13,'荆门',2),(186,13,'荆州',2),(187,13,'潜江',2),(188,13,'神农架林区',2),(189,13,'十堰',2),(190,13,'随州',2),(191,13,'天门',2),(192,13,'咸宁',2),(193,13,'襄樊',2),(194,13,'孝感',2),(195,13,'宜昌',2),(196,13,'恩施',2),(197,14,'长沙',2),(198,14,'张家界',2),(199,14,'常德',2),(200,14,'郴州',2),(201,14,'衡阳',2),(202,14,'怀化',2),(203,14,'娄底',2),(204,14,'邵阳',2),(205,14,'湘潭',2),(206,14,'湘西',2),(207,14,'益阳',2),(208,14,'永州',2),(209,14,'岳阳',2),(210,14,'株洲',2),(211,15,'长春',2),(212,15,'吉林',2),(213,15,'白城',2),(214,15,'白山',2),(215,15,'辽源',2),(216,15,'四平',2),(217,15,'松原',2),(218,15,'通化',2),(219,15,'延边',2),(220,16,'南京',2),(221,16,'苏州',2),(222,16,'无锡',2),(223,16,'常州',2),(224,16,'淮安',2),(225,16,'连云港',2),(226,16,'南通',2),(227,16,'宿迁',2),(228,16,'泰州',2),(229,16,'徐州',2),(230,16,'盐城',2),(231,16,'扬州',2),(232,16,'镇江',2),(233,17,'南昌',2),(234,17,'抚州',2),(235,17,'赣州',2),(236,17,'吉安',2),(237,17,'景德镇',2),(238,17,'九江',2),(239,17,'萍乡',2),(240,17,'上饶',2),(241,17,'新余',2),(242,17,'宜春',2),(243,17,'鹰潭',2),(244,18,'沈阳',2),(245,18,'大连',2),(246,18,'鞍山',2),(247,18,'本溪',2),(248,18,'朝阳',2),(249,18,'丹东',2),(250,18,'抚顺',2),(251,18,'阜新',2),(252,18,'葫芦岛',2),(253,18,'锦州',2),(254,18,'辽阳',2),(255,18,'盘锦',2),(256,18,'铁岭',2),(257,18,'营口',2),(258,19,'呼和浩特',2),(259,19,'阿拉善盟',2),(260,19,'巴彦淖尔盟',2),(261,19,'包头',2),(262,19,'赤峰',2),(263,19,'鄂尔多斯',2),(264,19,'呼伦贝尔',2),(265,19,'通辽',2),(266,19,'乌海',2),(267,19,'乌兰察布市',2),(268,19,'锡林郭勒盟',2),(269,19,'兴安盟',2),(270,20,'银川',2),(271,20,'固原',2),(272,20,'石嘴山',2),(273,20,'吴忠',2),(274,20,'中卫',2),(275,21,'西宁',2),(276,21,'果洛',2),(277,21,'海北',2),(278,21,'海东',2),(279,21,'海南',2),(280,21,'海西',2),(281,21,'黄南',2),(282,21,'玉树',2),(283,22,'济南',2),(284,22,'青岛',2),(285,22,'滨州',2),(286,22,'德州',2),(287,22,'东营',2),(288,22,'菏泽',2),(289,22,'济宁',2),(290,22,'莱芜',2),(291,22,'聊城',2),(292,22,'临沂',2),(293,22,'日照',2),(294,22,'泰安',2),(295,22,'威海',2),(296,22,'潍坊',2),(297,22,'烟台',2),(298,22,'枣庄',2),(299,22,'淄博',2),(300,23,'太原',2),(301,23,'长治',2),(302,23,'大同',2),(303,23,'晋城',2),(304,23,'晋中',2),(305,23,'临汾',2),(306,23,'吕梁',2),(307,23,'朔州',2),(308,23,'忻州',2),(309,23,'阳泉',2),(310,23,'运城',2),(311,24,'西安',2),(312,24,'安康',2),(313,24,'宝鸡',2),(314,24,'汉中',2),(315,24,'商洛',2),(316,24,'铜川',2),(317,24,'渭南',2),(318,24,'咸阳',2),(319,24,'延安',2),(320,24,'榆林',2),(321,25,'上海',2),(322,26,'成都',2),(323,26,'绵阳',2),(324,26,'阿坝',2),(325,26,'巴中',2),(326,26,'达州',2),(327,26,'德阳',2),(328,26,'甘孜',2),(329,26,'广安',2),(330,26,'广元',2),(331,26,'乐山',2),(332,26,'凉山',2),(333,26,'眉山',2),(334,26,'南充',2),(335,26,'内江',2),(336,26,'攀枝花',2),(337,26,'遂宁',2),(338,26,'雅安',2),(339,26,'宜宾',2),(340,26,'资阳',2),(341,26,'自贡',2),(342,26,'泸州',2),(343,27,'天津',2),(344,28,'拉萨',2),(345,28,'阿里',2),(346,28,'昌都',2),(347,28,'林芝',2),(348,28,'那曲',2),(349,28,'日喀则',2),(350,28,'山南',2),(351,29,'乌鲁木齐',2),(352,29,'阿克苏',2),(353,29,'阿拉尔',2),(354,29,'巴音郭楞',2),(355,29,'博尔塔拉',2),(356,29,'昌吉',2),(357,29,'哈密',2),(358,29,'和田',2),(359,29,'喀什',2),(360,29,'克拉玛依',2),(361,29,'克孜勒苏',2),(362,29,'石河子',2),(363,29,'图木舒克',2),(364,29,'吐鲁番',2),(365,29,'五家渠',2),(366,29,'伊犁',2),(367,30,'昆明',2),(368,30,'怒江',2),(369,30,'普洱',2),(370,30,'丽江',2),(371,30,'保山',2),(372,30,'楚雄',2),(373,30,'大理',2),(374,30,'德宏',2),(375,30,'迪庆',2),(376,30,'红河',2),(377,30,'临沧',2),(378,30,'曲靖',2),(379,30,'文山',2),(380,30,'西双版纳',2),(381,30,'玉溪',2),(382,30,'昭通',2),(383,31,'杭州',2),(384,31,'湖州',2),(385,31,'嘉兴',2),(386,31,'金华',2),(387,31,'丽水',2),(388,31,'宁波',2),(389,31,'绍兴',2),(390,31,'台州',2),(391,31,'温州',2),(392,31,'舟山',2),(393,31,'衢州',2),(394,32,'重庆',2),(395,33,'香港',2),(396,34,'澳门',2),(397,35,'台湾',2),(398,36,'迎江区',3),(399,36,'大观区',3),(400,36,'宜秀区',3),(401,36,'桐城市',3),(402,36,'怀宁县',3),(403,36,'枞阳县',3),(404,36,'潜山县',3),(405,36,'太湖县',3),(406,36,'宿松县',3),(407,36,'望江县',3),(408,36,'岳西县',3),(409,37,'中市区',3),(410,37,'东市区',3),(411,37,'西市区',3),(412,37,'郊区',3),(413,37,'怀远县',3),(414,37,'五河县',3),(415,37,'固镇县',3),(416,38,'居巢区',3),(417,38,'庐江县',3),(418,38,'无为县',3),(419,38,'含山县',3),(420,38,'和县',3),(421,39,'贵池区',3),(422,39,'东至县',3),(423,39,'石台县',3),(424,39,'青阳县',3),(425,40,'琅琊区',3),(426,40,'南谯区',3),(427,40,'天长市',3),(428,40,'明光市',3),(429,40,'来安县',3),(430,40,'全椒县',3),(431,40,'定远县',3),(432,40,'凤阳县',3),(433,41,'蚌山区',3),(434,41,'龙子湖区',3),(435,41,'禹会区',3),(436,41,'淮上区',3),(437,41,'颍州区',3),(438,41,'颍东区',3),(439,41,'颍泉区',3),(440,41,'界首市',3),(441,41,'临泉县',3),(442,41,'太和县',3),(443,41,'阜南县',3),(444,41,'颖上县',3),(445,42,'相山区',3),(446,42,'杜集区',3),(447,42,'烈山区',3),(448,42,'濉溪县',3),(449,43,'田家庵区',3),(450,43,'大通区',3),(451,43,'谢家集区',3),(452,43,'八公山区',3),(453,43,'潘集区',3),(454,43,'凤台县',3),(455,44,'屯溪区',3),(456,44,'黄山区',3),(457,44,'徽州区',3),(458,44,'歙县',3),(459,44,'休宁县',3),(460,44,'黟县',3),(461,44,'祁门县',3),(462,45,'金安区',3),(463,45,'裕安区',3),(464,45,'寿县',3),(465,45,'霍邱县',3),(466,45,'舒城县',3),(467,45,'金寨县',3),(468,45,'霍山县',3),(469,46,'雨山区',3),(470,46,'花山区',3),(471,46,'金家庄区',3),(472,46,'当涂县',3),(473,47,'埇桥区',3),(474,47,'砀山县',3),(475,47,'萧县',3),(476,47,'灵璧县',3),(477,47,'泗县',3),(478,48,'铜官山区',3),(479,48,'狮子山区',3),(480,48,'郊区',3),(481,48,'铜陵县',3),(482,49,'镜湖区',3),(483,49,'弋江区',3),(484,49,'鸠江区',3),(485,49,'三山区',3),(486,49,'芜湖县',3),(487,49,'繁昌县',3),(488,49,'南陵县',3),(489,50,'宣州区',3),(490,50,'宁国市',3),(491,50,'郎溪县',3),(492,50,'广德县',3),(493,50,'泾县',3),(494,50,'绩溪县',3),(495,50,'旌德县',3),(496,51,'涡阳县',3),(497,51,'蒙城县',3),(498,51,'利辛县',3),(499,51,'谯城区',3),(500,52,'东城区',3),(501,52,'西城区',3),(502,52,'海淀区',3),(503,52,'朝阳区',3),(504,52,'崇文区',3),(505,52,'宣武区',3),(506,52,'丰台区',3),(507,52,'石景山区',3),(508,52,'房山区',3),(509,52,'门头沟区',3),(510,52,'通州区',3),(511,52,'顺义区',3),(512,52,'昌平区',3),(513,52,'怀柔区',3),(514,52,'平谷区',3),(515,52,'大兴区',3),(516,52,'密云县',3),(517,52,'延庆县',3),(518,53,'鼓楼区',3),(519,53,'台江区',3),(520,53,'仓山区',3),(521,53,'马尾区',3),(522,53,'晋安区',3),(523,53,'福清市',3),(524,53,'长乐市',3),(525,53,'闽侯县',3),(526,53,'连江县',3),(527,53,'罗源县',3),(528,53,'闽清县',3),(529,53,'永泰县',3),(530,53,'平潭县',3),(531,54,'新罗区',3),(532,54,'漳平市',3),(533,54,'长汀县',3),(534,54,'永定县',3),(535,54,'上杭县',3),(536,54,'武平县',3),(537,54,'连城县',3),(538,55,'延平区',3),(539,55,'邵武市',3),(540,55,'武夷山市',3),(541,55,'建瓯市',3),(542,55,'建阳市',3),(543,55,'顺昌县',3),(544,55,'浦城县',3),(545,55,'光泽县',3),(546,55,'松溪县',3),(547,55,'政和县',3),(548,56,'蕉城区',3),(549,56,'福安市',3),(550,56,'福鼎市',3),(551,56,'霞浦县',3),(552,56,'古田县',3),(553,56,'屏南县',3),(554,56,'寿宁县',3),(555,56,'周宁县',3),(556,56,'柘荣县',3),(557,57,'城厢区',3),(558,57,'涵江区',3),(559,57,'荔城区',3),(560,57,'秀屿区',3),(561,57,'仙游县',3),(562,58,'鲤城区',3),(563,58,'丰泽区',3),(564,58,'洛江区',3),(565,58,'清濛开发区',3),(566,58,'泉港区',3),(567,58,'石狮市',3),(568,58,'晋江市',3),(569,58,'南安市',3),(570,58,'惠安县',3),(571,58,'安溪县',3),(572,58,'永春县',3),(573,58,'德化县',3),(574,58,'金门县',3),(575,59,'梅列区',3),(576,59,'三元区',3),(577,59,'永安市',3),(578,59,'明溪县',3),(579,59,'清流县',3),(580,59,'宁化县',3),(581,59,'大田县',3),(582,59,'尤溪县',3),(583,59,'沙县',3),(584,59,'将乐县',3),(585,59,'泰宁县',3),(586,59,'建宁县',3),(587,60,'思明区',3),(588,60,'海沧区',3),(589,60,'湖里区',3),(590,60,'集美区',3),(591,60,'同安区',3),(592,60,'翔安区',3),(593,61,'芗城区',3),(594,61,'龙文区',3),(595,61,'龙海市',3),(596,61,'云霄县',3),(597,61,'漳浦县',3),(598,61,'诏安县',3),(599,61,'长泰县',3),(600,61,'东山县',3),(601,61,'南靖县',3),(602,61,'平和县',3),(603,61,'华安县',3),(604,62,'皋兰县',3),(605,62,'城关区',3),(606,62,'七里河区',3),(607,62,'西固区',3),(608,62,'安宁区',3),(609,62,'红古区',3),(610,62,'永登县',3),(611,62,'榆中县',3),(612,63,'白银区',3),(613,63,'平川区',3),(614,63,'会宁县',3),(615,63,'景泰县',3),(616,63,'靖远县',3),(617,64,'临洮县',3),(618,64,'陇西县',3),(619,64,'通渭县',3),(620,64,'渭源县',3),(621,64,'漳县',3),(622,64,'岷县',3),(623,64,'安定区',3),(624,64,'安定区',3),(625,65,'合作市',3),(626,65,'临潭县',3),(627,65,'卓尼县',3),(628,65,'舟曲县',3),(629,65,'迭部县',3),(630,65,'玛曲县',3),(631,65,'碌曲县',3),(632,65,'夏河县',3),(633,66,'嘉峪关市',3),(634,67,'金川区',3),(635,67,'永昌县',3),(636,68,'肃州区',3),(637,68,'玉门市',3),(638,68,'敦煌市',3),(639,68,'金塔县',3),(640,68,'瓜州县',3),(641,68,'肃北',3),(642,68,'阿克塞',3),(643,69,'临夏市',3),(644,69,'临夏县',3),(645,69,'康乐县',3),(646,69,'永靖县',3),(647,69,'广河县',3),(648,69,'和政县',3),(649,69,'东乡族自治县',3),(650,69,'积石山',3),(651,70,'成县',3),(652,70,'徽县',3),(653,70,'康县',3),(654,70,'礼县',3),(655,70,'两当县',3),(656,70,'文县',3),(657,70,'西和县',3),(658,70,'宕昌县',3),(659,70,'武都区',3),(660,71,'崇信县',3),(661,71,'华亭县',3),(662,71,'静宁县',3),(663,71,'灵台县',3),(664,71,'崆峒区',3),(665,71,'庄浪县',3),(666,71,'泾川县',3),(667,72,'合水县',3),(668,72,'华池县',3),(669,72,'环县',3),(670,72,'宁县',3),(671,72,'庆城县',3),(672,72,'西峰区',3),(673,72,'镇原县',3),(674,72,'正宁县',3),(675,73,'甘谷县',3),(676,73,'秦安县',3),(677,73,'清水县',3),(678,73,'秦州区',3),(679,73,'麦积区',3),(680,73,'武山县',3),(681,73,'张家川',3),(682,74,'古浪县',3),(683,74,'民勤县',3),(684,74,'天祝',3),(685,74,'凉州区',3),(686,75,'高台县',3),(687,75,'临泽县',3),(688,75,'民乐县',3),(689,75,'山丹县',3),(690,75,'肃南',3),(691,75,'甘州区',3),(692,76,'从化市',3),(693,76,'天河区',3),(694,76,'东山区',3),(695,76,'白云区',3),(696,76,'海珠区',3),(697,76,'荔湾区',3),(698,76,'越秀区',3),(699,76,'黄埔区',3),(700,76,'番禺区',3),(701,76,'花都区',3),(702,76,'增城区',3),(703,76,'从化区',3),(704,76,'市郊',3),(705,77,'福田区',3),(706,77,'罗湖区',3),(707,77,'南山区',3),(708,77,'宝安区',3),(709,77,'龙岗区',3),(710,77,'盐田区',3),(711,78,'湘桥区',3),(712,78,'潮安县',3),(713,78,'饶平县',3),(714,79,'南城区',3),(715,79,'东城区',3),(716,79,'万江区',3),(717,79,'莞城区',3),(718,79,'石龙镇',3),(719,79,'虎门镇',3),(720,79,'麻涌镇',3),(721,79,'道滘镇',3),(722,79,'石碣镇',3),(723,79,'沙田镇',3),(724,79,'望牛墩镇',3),(725,79,'洪梅镇',3),(726,79,'茶山镇',3),(727,79,'寮步镇',3),(728,79,'大岭山镇',3),(729,79,'大朗镇',3),(730,79,'黄江镇',3),(731,79,'樟木头',3),(732,79,'凤岗镇',3),(733,79,'塘厦镇',3),(734,79,'谢岗镇',3),(735,79,'厚街镇',3),(736,79,'清溪镇',3),(737,79,'常平镇',3),(738,79,'桥头镇',3),(739,79,'横沥镇',3),(740,79,'东坑镇',3),(741,79,'企石镇',3),(742,79,'石排镇',3),(743,79,'长安镇',3),(744,79,'中堂镇',3),(745,79,'高埗镇',3),(746,80,'禅城区',3),(747,80,'南海区',3),(748,80,'顺德区',3),(749,80,'三水区',3),(750,80,'高明区',3),(751,81,'东源县',3),(752,81,'和平县',3),(753,81,'源城区',3),(754,81,'连平县',3),(755,81,'龙川县',3),(756,81,'紫金县',3),(757,82,'惠阳区',3),(758,82,'惠城区',3),(759,82,'大亚湾',3),(760,82,'博罗县',3),(761,82,'惠东县',3),(762,82,'龙门县',3),(763,83,'江海区',3),(764,83,'蓬江区',3),(765,83,'新会区',3),(766,83,'台山市',3),(767,83,'开平市',3),(768,83,'鹤山市',3),(769,83,'恩平市',3),(770,84,'榕城区',3),(771,84,'普宁市',3),(772,84,'揭东县',3),(773,84,'揭西县',3),(774,84,'惠来县',3),(775,85,'茂南区',3),(776,85,'茂港区',3),(777,85,'高州市',3),(778,85,'化州市',3),(779,85,'信宜市',3),(780,85,'电白县',3),(781,86,'梅县',3),(782,86,'梅江区',3),(783,86,'兴宁市',3),(784,86,'大埔县',3),(785,86,'丰顺县',3),(786,86,'五华县',3),(787,86,'平远县',3),(788,86,'蕉岭县',3),(789,87,'清城区',3),(790,87,'英德市',3),(791,87,'连州市',3),(792,87,'佛冈县',3),(793,87,'阳山县',3),(794,87,'清新县',3),(795,87,'连山',3),(796,87,'连南',3),(797,88,'南澳县',3),(798,88,'潮阳区',3),(799,88,'澄海区',3),(800,88,'龙湖区',3),(801,88,'金平区',3),(802,88,'濠江区',3),(803,88,'潮南区',3),(804,89,'城区',3),(805,89,'陆丰市',3),(806,89,'海丰县',3),(807,89,'陆河县',3),(808,90,'曲江县',3),(809,90,'浈江区',3),(810,90,'武江区',3),(811,90,'曲江区',3),(812,90,'乐昌市',3),(813,90,'南雄市',3),(814,90,'始兴县',3),(815,90,'仁化县',3),(816,90,'翁源县',3),(817,90,'新丰县',3),(818,90,'乳源',3),(819,91,'江城区',3),(820,91,'阳春市',3),(821,91,'阳西县',3),(822,91,'阳东县',3),(823,92,'云城区',3),(824,92,'罗定市',3),(825,92,'新兴县',3),(826,92,'郁南县',3),(827,92,'云安县',3),(828,93,'赤坎区',3),(829,93,'霞山区',3),(830,93,'坡头区',3),(831,93,'麻章区',3),(832,93,'廉江市',3),(833,93,'雷州市',3),(834,93,'吴川市',3),(835,93,'遂溪县',3),(836,93,'徐闻县',3),(837,94,'肇庆市',3),(838,94,'高要市',3),(839,94,'四会市',3),(840,94,'广宁县',3),(841,94,'怀集县',3),(842,94,'封开县',3),(843,94,'德庆县',3),(844,95,'石岐街道',3),(845,95,'东区街道',3),(846,95,'西区街道',3),(847,95,'环城街道',3),(848,95,'中山港街道',3),(849,95,'五桂山街道',3),(850,96,'香洲区',3),(851,96,'斗门区',3),(852,96,'金湾区',3),(853,97,'邕宁区',3),(854,97,'青秀区',3),(855,97,'兴宁区',3),(856,97,'良庆区',3),(857,97,'西乡塘区',3),(858,97,'江南区',3),(859,97,'武鸣县',3),(860,97,'隆安县',3),(861,97,'马山县',3),(862,97,'上林县',3),(863,97,'宾阳县',3),(864,97,'横县',3),(865,98,'秀峰区',3),(866,98,'叠彩区',3),(867,98,'象山区',3),(868,98,'七星区',3),(869,98,'雁山区',3),(870,98,'阳朔县',3),(871,98,'临桂县',3),(872,98,'灵川县',3),(873,98,'全州县',3),(874,98,'平乐县',3),(875,98,'兴安县',3),(876,98,'灌阳县',3),(877,98,'荔浦县',3),(878,98,'资源县',3),(879,98,'永福县',3),(880,98,'龙胜',3),(881,98,'恭城',3),(882,99,'右江区',3),(883,99,'凌云县',3),(884,99,'平果县',3),(885,99,'西林县',3),(886,99,'乐业县',3),(887,99,'德保县',3),(888,99,'田林县',3),(889,99,'田阳县',3),(890,99,'靖西县',3),(891,99,'田东县',3),(892,99,'那坡县',3),(893,99,'隆林',3),(894,100,'海城区',3),(895,100,'银海区',3),(896,100,'铁山港区',3),(897,100,'合浦县',3),(898,101,'江州区',3),(899,101,'凭祥市',3),(900,101,'宁明县',3),(901,101,'扶绥县',3),(902,101,'龙州县',3),(903,101,'大新县',3),(904,101,'天等县',3),(905,102,'港口区',3),(906,102,'防城区',3),(907,102,'东兴市',3),(908,102,'上思县',3),(909,103,'港北区',3),(910,103,'港南区',3),(911,103,'覃塘区',3),(912,103,'桂平市',3),(913,103,'平南县',3),(914,104,'金城江区',3),(915,104,'宜州市',3),(916,104,'天峨县',3),(917,104,'凤山县',3),(918,104,'南丹县',3),(919,104,'东兰县',3),(920,104,'都安',3),(921,104,'罗城',3),(922,104,'巴马',3),(923,104,'环江',3),(924,104,'大化',3),(925,105,'八步区',3),(926,105,'钟山县',3),(927,105,'昭平县',3),(928,105,'富川',3),(929,106,'兴宾区',3),(930,106,'合山市',3),(931,106,'象州县',3),(932,106,'武宣县',3),(933,106,'忻城县',3),(934,106,'金秀',3),(935,107,'城中区',3),(936,107,'鱼峰区',3),(937,107,'柳北区',3),(938,107,'柳南区',3),(939,107,'柳江县',3),(940,107,'柳城县',3),(941,107,'鹿寨县',3),(942,107,'融安县',3),(943,107,'融水',3),(944,107,'三江',3),(945,108,'钦南区',3),(946,108,'钦北区',3),(947,108,'灵山县',3),(948,108,'浦北县',3),(949,109,'万秀区',3),(950,109,'蝶山区',3),(951,109,'长洲区',3),(952,109,'岑溪市',3),(953,109,'苍梧县',3),(954,109,'藤县',3),(955,109,'蒙山县',3),(956,110,'玉州区',3),(957,110,'北流市',3),(958,110,'容县',3),(959,110,'陆川县',3),(960,110,'博白县',3),(961,110,'兴业县',3),(962,111,'南明区',3),(963,111,'云岩区',3),(964,111,'花溪区',3),(965,111,'乌当区',3),(966,111,'白云区',3),(967,111,'小河区',3),(968,111,'金阳新区',3),(969,111,'新天园区',3),(970,111,'清镇市',3),(971,111,'开阳县',3),(972,111,'修文县',3),(973,111,'息烽县',3),(974,112,'西秀区',3),(975,112,'关岭',3),(976,112,'镇宁',3),(977,112,'紫云',3),(978,112,'平坝县',3),(979,112,'普定县',3),(980,113,'毕节市',3),(981,113,'大方县',3),(982,113,'黔西县',3),(983,113,'金沙县',3),(984,113,'织金县',3),(985,113,'纳雍县',3),(986,113,'赫章县',3),(987,113,'威宁',3),(988,114,'钟山区',3),(989,114,'六枝特区',3),(990,114,'水城县',3),(991,114,'盘县',3),(992,115,'凯里市',3),(993,115,'黄平县',3),(994,115,'施秉县',3),(995,115,'三穗县',3),(996,115,'镇远县',3),(997,115,'岑巩县',3),(998,115,'天柱县',3),(999,115,'锦屏县',3),(1000,115,'剑河县',3),(1001,115,'台江县',3),(1002,115,'黎平县',3),(1003,115,'榕江县',3),(1004,115,'从江县',3),(1005,115,'雷山县',3),(1006,115,'麻江县',3),(1007,115,'丹寨县',3),(1008,116,'都匀市',3),(1009,116,'福泉市',3),(1010,116,'荔波县',3),(1011,116,'贵定县',3),(1012,116,'瓮安县',3),(1013,116,'独山县',3),(1014,116,'平塘县',3),(1015,116,'罗甸县',3),(1016,116,'长顺县',3),(1017,116,'龙里县',3),(1018,116,'惠水县',3),(1019,116,'三都',3),(1020,117,'兴义市',3),(1021,117,'兴仁县',3),(1022,117,'普安县',3),(1023,117,'晴隆县',3),(1024,117,'贞丰县',3),(1025,117,'望谟县',3),(1026,117,'册亨县',3),(1027,117,'安龙县',3),(1028,118,'铜仁市',3),(1029,118,'江口县',3),(1030,118,'石阡县',3),(1031,118,'思南县',3),(1032,118,'德江县',3),(1033,118,'玉屏',3),(1034,118,'印江',3),(1035,118,'沿河',3),(1036,118,'松桃',3),(1037,118,'万山特区',3),(1038,119,'红花岗区',3),(1039,119,'务川县',3),(1040,119,'道真县',3),(1041,119,'汇川区',3),(1042,119,'赤水市',3),(1043,119,'仁怀市',3),(1044,119,'遵义县',3),(1045,119,'桐梓县',3),(1046,119,'绥阳县',3),(1047,119,'正安县',3),(1048,119,'凤冈县',3),(1049,119,'湄潭县',3),(1050,119,'余庆县',3),(1051,119,'习水县',3),(1052,119,'道真',3),(1053,119,'务川',3),(1054,120,'秀英区',3),(1055,120,'龙华区',3),(1056,120,'琼山区',3),(1057,120,'美兰区',3),(1058,137,'市区',3),(1059,137,'洋浦开发区',3),(1060,137,'那大镇',3),(1061,137,'王五镇',3),(1062,137,'雅星镇',3),(1063,137,'大成镇',3),(1064,137,'中和镇',3),(1065,137,'峨蔓镇',3),(1066,137,'南丰镇',3),(1067,137,'白马井镇',3),(1068,137,'兰洋镇',3),(1069,137,'和庆镇',3),(1070,137,'海头镇',3),(1071,137,'排浦镇',3),(1072,137,'东成镇',3),(1073,137,'光村镇',3),(1074,137,'木棠镇',3),(1075,137,'新州镇',3),(1076,137,'三都镇',3),(1077,137,'其他',3),(1078,138,'长安区',3),(1079,138,'桥东区',3),(1080,138,'桥西区',3),(1081,138,'新华区',3),(1082,138,'裕华区',3),(1083,138,'井陉矿区',3),(1084,138,'高新区',3),(1085,138,'辛集市',3),(1086,138,'藁城市',3),(1087,138,'晋州市',3),(1088,138,'新乐市',3),(1089,138,'鹿泉市',3),(1090,138,'井陉县',3),(1091,138,'正定县',3),(1092,138,'栾城县',3),(1093,138,'行唐县',3),(1094,138,'灵寿县',3),(1095,138,'高邑县',3),(1096,138,'深泽县',3),(1097,138,'赞皇县',3),(1098,138,'无极县',3),(1099,138,'平山县',3),(1100,138,'元氏县',3),(1101,138,'赵县',3),(1102,139,'新市区',3),(1103,139,'南市区',3),(1104,139,'北市区',3),(1105,139,'涿州市',3),(1106,139,'定州市',3),(1107,139,'安国市',3),(1108,139,'高碑店市',3),(1109,139,'满城县',3),(1110,139,'清苑县',3),(1111,139,'涞水县',3),(1112,139,'阜平县',3),(1113,139,'徐水县',3),(1114,139,'定兴县',3),(1115,139,'唐县',3),(1116,139,'高阳县',3),(1117,139,'容城县',3),(1118,139,'涞源县',3),(1119,139,'望都县',3),(1120,139,'安新县',3),(1121,139,'易县',3),(1122,139,'曲阳县',3),(1123,139,'蠡县',3),(1124,139,'顺平县',3),(1125,139,'博野县',3),(1126,139,'雄县',3),(1127,140,'运河区',3),(1128,140,'新华区',3),(1129,140,'泊头市',3),(1130,140,'任丘市',3),(1131,140,'黄骅市',3),(1132,140,'河间市',3),(1133,140,'沧县',3),(1134,140,'青县',3),(1135,140,'东光县',3),(1136,140,'海兴县',3),(1137,140,'盐山县',3),(1138,140,'肃宁县',3),(1139,140,'南皮县',3),(1140,140,'吴桥县',3),(1141,140,'献县',3),(1142,140,'孟村',3),(1143,141,'双桥区',3),(1144,141,'双滦区',3),(1145,141,'鹰手营子矿区',3),(1146,141,'承德县',3),(1147,141,'兴隆县',3),(1148,141,'平泉县',3),(1149,141,'滦平县',3),(1150,141,'隆化县',3),(1151,141,'丰宁',3),(1152,141,'宽城',3),(1153,141,'围场',3),(1154,142,'从台区',3),(1155,142,'复兴区',3),(1156,142,'邯山区',3),(1157,142,'峰峰矿区',3),(1158,142,'武安市',3),(1159,142,'邯郸县',3),(1160,142,'临漳县',3),(1161,142,'成安县',3),(1162,142,'大名县',3),(1163,142,'涉县',3),(1164,142,'磁县',3),(1165,142,'肥乡县',3),(1166,142,'永年县',3),(1167,142,'邱县',3),(1168,142,'鸡泽县',3),(1169,142,'广平县',3),(1170,142,'馆陶县',3),(1171,142,'魏县',3),(1172,142,'曲周县',3),(1173,143,'桃城区',3),(1174,143,'冀州市',3),(1175,143,'深州市',3),(1176,143,'枣强县',3),(1177,143,'武邑县',3),(1178,143,'武强县',3),(1179,143,'饶阳县',3),(1180,143,'安平县',3),(1181,143,'故城县',3),(1182,143,'景县',3),(1183,143,'阜城县',3),(1184,144,'安次区',3),(1185,144,'广阳区',3),(1186,144,'霸州市',3),(1187,144,'三河市',3),(1188,144,'固安县',3),(1189,144,'永清县',3),(1190,144,'香河县',3),(1191,144,'大城县',3),(1192,144,'文安县',3),(1193,144,'大厂',3),(1194,145,'海港区',3),(1195,145,'山海关区',3),(1196,145,'北戴河区',3),(1197,145,'昌黎县',3),(1198,145,'抚宁县',3),(1199,145,'卢龙县',3),(1200,145,'青龙',3),(1201,146,'路北区',3),(1202,146,'路南区',3),(1203,146,'古冶区',3),(1204,146,'开平区',3),(1205,146,'丰南区',3),(1206,146,'丰润区',3),(1207,146,'遵化市',3),(1208,146,'迁安市',3),(1209,146,'滦县',3),(1210,146,'滦南县',3),(1211,146,'乐亭县',3),(1212,146,'迁西县',3),(1213,146,'玉田县',3),(1214,146,'唐海县',3),(1215,147,'桥东区',3),(1216,147,'桥西区',3),(1217,147,'南宫市',3),(1218,147,'沙河市',3),(1219,147,'邢台县',3),(1220,147,'临城县',3),(1221,147,'内丘县',3),(1222,147,'柏乡县',3),(1223,147,'隆尧县',3),(1224,147,'任县',3),(1225,147,'南和县',3),(1226,147,'宁晋县',3),(1227,147,'巨鹿县',3),(1228,147,'新河县',3),(1229,147,'广宗县',3),(1230,147,'平乡县',3),(1231,147,'威县',3),(1232,147,'清河县',3),(1233,147,'临西县',3),(1234,148,'桥西区',3),(1235,148,'桥东区',3),(1236,148,'宣化区',3),(1237,148,'下花园区',3),(1238,148,'宣化县',3),(1239,148,'张北县',3),(1240,148,'康保县',3),(1241,148,'沽源县',3),(1242,148,'尚义县',3),(1243,148,'蔚县',3),(1244,148,'阳原县',3),(1245,148,'怀安县',3),(1246,148,'万全县',3),(1247,148,'怀来县',3),(1248,148,'涿鹿县',3),(1249,148,'赤城县',3),(1250,148,'崇礼县',3),(1251,149,'金水区',3),(1252,149,'邙山区',3),(1253,149,'二七区',3),(1254,149,'管城区',3),(1255,149,'中原区',3),(1256,149,'上街区',3),(1257,149,'惠济区',3),(1258,149,'郑东新区',3),(1259,149,'经济技术开发区',3),(1260,149,'高新开发区',3),(1261,149,'出口加工区',3),(1262,149,'巩义市',3),(1263,149,'荥阳市',3),(1264,149,'新密市',3),(1265,149,'新郑市',3),(1266,149,'登封市',3),(1267,149,'中牟县',3),(1268,150,'西工区',3),(1269,150,'老城区',3),(1270,150,'涧西区',3),(1271,150,'瀍河回族区',3),(1272,150,'洛龙区',3),(1273,150,'吉利区',3),(1274,150,'偃师市',3),(1275,150,'孟津县',3),(1276,150,'新安县',3),(1277,150,'栾川县',3),(1278,150,'嵩县',3),(1279,150,'汝阳县',3),(1280,150,'宜阳县',3),(1281,150,'洛宁县',3),(1282,150,'伊川县',3),(1283,151,'鼓楼区',3),(1284,151,'龙亭区',3),(1285,151,'顺河回族区',3),(1286,151,'金明区',3),(1287,151,'禹王台区',3),(1288,151,'杞县',3),(1289,151,'通许县',3),(1290,151,'尉氏县',3),(1291,151,'开封县',3),(1292,151,'兰考县',3),(1293,152,'北关区',3),(1294,152,'文峰区',3),(1295,152,'殷都区',3),(1296,152,'龙安区',3),(1297,152,'林州市',3),(1298,152,'安阳县',3),(1299,152,'汤阴县',3),(1300,152,'滑县',3),(1301,152,'内黄县',3),(1302,153,'淇滨区',3),(1303,153,'山城区',3),(1304,153,'鹤山区',3),(1305,153,'浚县',3),(1306,153,'淇县',3),(1307,154,'济源市',3),(1308,155,'解放区',3),(1309,155,'中站区',3),(1310,155,'马村区',3),(1311,155,'山阳区',3),(1312,155,'沁阳市',3),(1313,155,'孟州市',3),(1314,155,'修武县',3),(1315,155,'博爱县',3),(1316,155,'武陟县',3),(1317,155,'温县',3),(1318,156,'卧龙区',3),(1319,156,'宛城区',3),(1320,156,'邓州市',3),(1321,156,'南召县',3),(1322,156,'方城县',3),(1323,156,'西峡县',3),(1324,156,'镇平县',3),(1325,156,'内乡县',3),(1326,156,'淅川县',3),(1327,156,'社旗县',3),(1328,156,'唐河县',3),(1329,156,'新野县',3),(1330,156,'桐柏县',3),(1331,157,'新华区',3),(1332,157,'卫东区',3),(1333,157,'湛河区',3),(1334,157,'石龙区',3),(1335,157,'舞钢市',3),(1336,157,'汝州市',3),(1337,157,'宝丰县',3),(1338,157,'叶县',3),(1339,157,'鲁山县',3),(1340,157,'郏县',3),(1341,158,'湖滨区',3),(1342,158,'义马市',3),(1343,158,'灵宝市',3),(1344,158,'渑池县',3),(1345,158,'陕县',3),(1346,158,'卢氏县',3),(1347,159,'梁园区',3),(1348,159,'睢阳区',3),(1349,159,'永城市',3),(1350,159,'民权县',3),(1351,159,'睢县',3),(1352,159,'宁陵县',3),(1353,159,'虞城县',3),(1354,159,'柘城县',3),(1355,159,'夏邑县',3),(1356,160,'卫滨区',3),(1357,160,'红旗区',3),(1358,160,'凤泉区',3),(1359,160,'牧野区',3),(1360,160,'卫辉市',3),(1361,160,'辉县市',3),(1362,160,'新乡县',3),(1363,160,'获嘉县',3),(1364,160,'原阳县',3),(1365,160,'延津县',3),(1366,160,'封丘县',3),(1367,160,'长垣县',3),(1368,161,'浉河区',3),(1369,161,'平桥区',3),(1370,161,'罗山县',3),(1371,161,'光山县',3),(1372,161,'新县',3),(1373,161,'商城县',3),(1374,161,'固始县',3),(1375,161,'潢川县',3),(1376,161,'淮滨县',3),(1377,161,'息县',3),(1378,162,'魏都区',3),(1379,162,'禹州市',3),(1380,162,'长葛市',3),(1381,162,'许昌县',3),(1382,162,'鄢陵县',3),(1383,162,'襄城县',3),(1384,163,'川汇区',3),(1385,163,'项城市',3),(1386,163,'扶沟县',3),(1387,163,'西华县',3),(1388,163,'商水县',3),(1389,163,'沈丘县',3),(1390,163,'郸城县',3),(1391,163,'淮阳县',3),(1392,163,'太康县',3),(1393,163,'鹿邑县',3),(1394,164,'驿城区',3),(1395,164,'西平县',3),(1396,164,'上蔡县',3),(1397,164,'平舆县',3),(1398,164,'正阳县',3),(1399,164,'确山县',3),(1400,164,'泌阳县',3),(1401,164,'汝南县',3),(1402,164,'遂平县',3),(1403,164,'新蔡县',3),(1404,165,'郾城区',3),(1405,165,'源汇区',3),(1406,165,'召陵区',3),(1407,165,'舞阳县',3),(1408,165,'临颍县',3),(1409,166,'华龙区',3),(1410,166,'清丰县',3),(1411,166,'南乐县',3),(1412,166,'范县',3),(1413,166,'台前县',3),(1414,166,'濮阳县',3),(1415,167,'道里区',3),(1416,167,'南岗区',3),(1417,167,'动力区',3),(1418,167,'平房区',3),(1419,167,'香坊区',3),(1420,167,'太平区',3),(1421,167,'道外区',3),(1422,167,'阿城区',3),(1423,167,'呼兰区',3),(1424,167,'松北区',3),(1425,167,'尚志市',3),(1426,167,'双城市',3),(1427,167,'五常市',3),(1428,167,'方正县',3),(1429,167,'宾县',3),(1430,167,'依兰县',3),(1431,167,'巴彦县',3),(1432,167,'通河县',3),(1433,167,'木兰县',3),(1434,167,'延寿县',3),(1435,168,'萨尔图区',3),(1436,168,'红岗区',3),(1437,168,'龙凤区',3),(1438,168,'让胡路区',3),(1439,168,'大同区',3),(1440,168,'肇州县',3),(1441,168,'肇源县',3),(1442,168,'林甸县',3),(1443,168,'杜尔伯特',3),(1444,169,'呼玛县',3),(1445,169,'漠河县',3),(1446,169,'塔河县',3),(1447,170,'兴山区',3),(1448,170,'工农区',3),(1449,170,'南山区',3),(1450,170,'兴安区',3),(1451,170,'向阳区',3),(1452,170,'东山区',3),(1453,170,'萝北县',3),(1454,170,'绥滨县',3),(1455,171,'爱辉区',3),(1456,171,'五大连池市',3),(1457,171,'北安市',3),(1458,171,'嫩江县',3),(1459,171,'逊克县',3),(1460,171,'孙吴县',3),(1461,172,'鸡冠区',3),(1462,172,'恒山区',3),(1463,172,'城子河区',3),(1464,172,'滴道区',3),(1465,172,'梨树区',3),(1466,172,'虎林市',3),(1467,172,'密山市',3),(1468,172,'鸡东县',3),(1469,173,'前进区',3),(1470,173,'郊区',3),(1471,173,'向阳区',3),(1472,173,'东风区',3),(1473,173,'同江市',3),(1474,173,'富锦市',3),(1475,173,'桦南县',3),(1476,173,'桦川县',3),(1477,173,'汤原县',3),(1478,173,'抚远县',3),(1479,174,'爱民区',3),(1480,174,'东安区',3),(1481,174,'阳明区',3),(1482,174,'西安区',3),(1483,174,'绥芬河市',3),(1484,174,'海林市',3),(1485,174,'宁安市',3),(1486,174,'穆棱市',3),(1487,174,'东宁县',3),(1488,174,'林口县',3),(1489,175,'桃山区',3),(1490,175,'新兴区',3),(1491,175,'茄子河区',3),(1492,175,'勃利县',3),(1493,176,'龙沙区',3),(1494,176,'昂昂溪区',3),(1495,176,'铁峰区',3),(1496,176,'建华区',3),(1497,176,'富拉尔基区',3),(1498,176,'碾子山区',3),(1499,176,'梅里斯达斡尔区',3),(1500,176,'讷河市',3),(1501,176,'龙江县',3),(1502,176,'依安县',3),(1503,176,'泰来县',3),(1504,176,'甘南县',3),(1505,176,'富裕县',3),(1506,176,'克山县',3),(1507,176,'克东县',3),(1508,176,'拜泉县',3),(1509,177,'尖山区',3),(1510,177,'岭东区',3),(1511,177,'四方台区',3),(1512,177,'宝山区',3),(1513,177,'集贤县',3),(1514,177,'友谊县',3),(1515,177,'宝清县',3),(1516,177,'饶河县',3),(1517,178,'北林区',3),(1518,178,'安达市',3),(1519,178,'肇东市',3),(1520,178,'海伦市',3),(1521,178,'望奎县',3),(1522,178,'兰西县',3),(1523,178,'青冈县',3),(1524,178,'庆安县',3),(1525,178,'明水县',3),(1526,178,'绥棱县',3),(1527,179,'伊春区',3),(1528,179,'带岭区',3),(1529,179,'南岔区',3),(1530,179,'金山屯区',3),(1531,179,'西林区',3),(1532,179,'美溪区',3),(1533,179,'乌马河区',3),(1534,179,'翠峦区',3),(1535,179,'友好区',3),(1536,179,'上甘岭区',3),(1537,179,'五营区',3),(1538,179,'红星区',3),(1539,179,'新青区',3),(1540,179,'汤旺河区',3),(1541,179,'乌伊岭区',3),(1542,179,'铁力市',3),(1543,179,'嘉荫县',3),(1544,180,'江岸区',3),(1545,180,'武昌区',3),(1546,180,'江汉区',3),(1547,180,'硚口区',3),(1548,180,'汉阳区',3),(1549,180,'青山区',3),(1550,180,'洪山区',3),(1551,180,'东西湖区',3),(1552,180,'汉南区',3),(1553,180,'蔡甸区',3),(1554,180,'江夏区',3),(1555,180,'黄陂区',3),(1556,180,'新洲区',3),(1557,180,'经济开发区',3),(1558,181,'仙桃市',3),(1559,182,'鄂城区',3),(1560,182,'华容区',3),(1561,182,'梁子湖区',3),(1562,183,'黄州区',3),(1563,183,'麻城市',3),(1564,183,'武穴市',3),(1565,183,'团风县',3),(1566,183,'红安县',3),(1567,183,'罗田县',3),(1568,183,'英山县',3),(1569,183,'浠水县',3),(1570,183,'蕲春县',3),(1571,183,'黄梅县',3),(1572,184,'黄石港区',3),(1573,184,'西塞山区',3),(1574,184,'下陆区',3),(1575,184,'铁山区',3),(1576,184,'大冶市',3),(1577,184,'阳新县',3),(1578,185,'东宝区',3),(1579,185,'掇刀区',3),(1580,185,'钟祥市',3),(1581,185,'京山县',3),(1582,185,'沙洋县',3),(1583,186,'沙市区',3),(1584,186,'荆州区',3),(1585,186,'石首市',3),(1586,186,'洪湖市',3),(1587,186,'松滋市',3),(1588,186,'公安县',3),(1589,186,'监利县',3),(1590,186,'江陵县',3),(1591,187,'潜江市',3),(1592,188,'神农架林区',3),(1593,189,'张湾区',3),(1594,189,'茅箭区',3),(1595,189,'丹江口市',3),(1596,189,'郧县',3),(1597,189,'郧西县',3),(1598,189,'竹山县',3),(1599,189,'竹溪县',3),(1600,189,'房县',3),(1601,190,'曾都区',3),(1602,190,'广水市',3),(1603,191,'天门市',3),(1604,192,'咸安区',3),(1605,192,'赤壁市',3),(1606,192,'嘉鱼县',3),(1607,192,'通城县',3),(1608,192,'崇阳县',3),(1609,192,'通山县',3),(1610,193,'襄城区',3),(1611,193,'樊城区',3),(1612,193,'襄阳区',3),(1613,193,'老河口市',3),(1614,193,'枣阳市',3),(1615,193,'宜城市',3),(1616,193,'南漳县',3),(1617,193,'谷城县',3),(1618,193,'保康县',3),(1619,194,'孝南区',3),(1620,194,'应城市',3),(1621,194,'安陆市',3),(1622,194,'汉川市',3),(1623,194,'孝昌县',3),(1624,194,'大悟县',3),(1625,194,'云梦县',3),(1626,195,'长阳',3),(1627,195,'五峰',3),(1628,195,'西陵区',3),(1629,195,'伍家岗区',3),(1630,195,'点军区',3),(1631,195,'猇亭区',3),(1632,195,'夷陵区',3),(1633,195,'宜都市',3),(1634,195,'当阳市',3),(1635,195,'枝江市',3),(1636,195,'远安县',3),(1637,195,'兴山县',3),(1638,195,'秭归县',3),(1639,196,'恩施市',3),(1640,196,'利川市',3),(1641,196,'建始县',3),(1642,196,'巴东县',3),(1643,196,'宣恩县',3),(1644,196,'咸丰县',3),(1645,196,'来凤县',3),(1646,196,'鹤峰县',3),(1647,197,'岳麓区',3),(1648,197,'芙蓉区',3),(1649,197,'天心区',3),(1650,197,'开福区',3),(1651,197,'雨花区',3),(1652,197,'开发区',3),(1653,197,'浏阳市',3),(1654,197,'长沙县',3),(1655,197,'望城县',3),(1656,197,'宁乡县',3),(1657,198,'永定区',3),(1658,198,'武陵源区',3),(1659,198,'慈利县',3),(1660,198,'桑植县',3),(1661,199,'武陵区',3),(1662,199,'鼎城区',3),(1663,199,'津市市',3),(1664,199,'安乡县',3),(1665,199,'汉寿县',3),(1666,199,'澧县',3),(1667,199,'临澧县',3),(1668,199,'桃源县',3),(1669,199,'石门县',3),(1670,200,'北湖区',3),(1671,200,'苏仙区',3),(1672,200,'资兴市',3),(1673,200,'桂阳县',3),(1674,200,'宜章县',3),(1675,200,'永兴县',3),(1676,200,'嘉禾县',3),(1677,200,'临武县',3),(1678,200,'汝城县',3),(1679,200,'桂东县',3),(1680,200,'安仁县',3),(1681,201,'雁峰区',3),(1682,201,'珠晖区',3),(1683,201,'石鼓区',3),(1684,201,'蒸湘区',3),(1685,201,'南岳区',3),(1686,201,'耒阳市',3),(1687,201,'常宁市',3),(1688,201,'衡阳县',3),(1689,201,'衡南县',3),(1690,201,'衡山县',3),(1691,201,'衡东县',3),(1692,201,'祁东县',3),(1693,202,'鹤城区',3),(1694,202,'靖州',3),(1695,202,'麻阳',3),(1696,202,'通道',3),(1697,202,'新晃',3),(1698,202,'芷江',3),(1699,202,'沅陵县',3),(1700,202,'辰溪县',3),(1701,202,'溆浦县',3),(1702,202,'中方县',3),(1703,202,'会同县',3),(1704,202,'洪江市',3),(1705,203,'娄星区',3),(1706,203,'冷水江市',3),(1707,203,'涟源市',3),(1708,203,'双峰县',3),(1709,203,'新化县',3),(1710,204,'城步',3),(1711,204,'双清区',3),(1712,204,'大祥区',3),(1713,204,'北塔区',3),(1714,204,'武冈市',3),(1715,204,'邵东县',3),(1716,204,'新邵县',3),(1717,204,'邵阳县',3),(1718,204,'隆回县',3),(1719,204,'洞口县',3),(1720,204,'绥宁县',3),(1721,204,'新宁县',3),(1722,205,'岳塘区',3),(1723,205,'雨湖区',3),(1724,205,'湘乡市',3),(1725,205,'韶山市',3),(1726,205,'湘潭县',3),(1727,206,'吉首市',3),(1728,206,'泸溪县',3),(1729,206,'凤凰县',3),(1730,206,'花垣县',3),(1731,206,'保靖县',3),(1732,206,'古丈县',3),(1733,206,'永顺县',3),(1734,206,'龙山县',3),(1735,207,'赫山区',3),(1736,207,'资阳区',3),(1737,207,'沅江市',3),(1738,207,'南县',3),(1739,207,'桃江县',3),(1740,207,'安化县',3),(1741,208,'江华',3),(1742,208,'冷水滩区',3),(1743,208,'零陵区',3),(1744,208,'祁阳县',3),(1745,208,'东安县',3),(1746,208,'双牌县',3),(1747,208,'道县',3),(1748,208,'江永县',3),(1749,208,'宁远县',3),(1750,208,'蓝山县',3),(1751,208,'新田县',3),(1752,209,'岳阳楼区',3),(1753,209,'君山区',3),(1754,209,'云溪区',3),(1755,209,'汨罗市',3),(1756,209,'临湘市',3),(1757,209,'岳阳县',3),(1758,209,'华容县',3),(1759,209,'湘阴县',3),(1760,209,'平江县',3),(1761,210,'天元区',3),(1762,210,'荷塘区',3),(1763,210,'芦淞区',3),(1764,210,'石峰区',3),(1765,210,'醴陵市',3),(1766,210,'株洲县',3),(1767,210,'攸县',3),(1768,210,'茶陵县',3),(1769,210,'炎陵县',3),(1770,211,'朝阳区',3),(1771,211,'宽城区',3),(1772,211,'二道区',3),(1773,211,'南关区',3),(1774,211,'绿园区',3),(1775,211,'双阳区',3),(1776,211,'净月潭开发区',3),(1777,211,'高新技术开发区',3),(1778,211,'经济技术开发区',3),(1779,211,'汽车产业开发区',3),(1780,211,'德惠市',3),(1781,211,'九台市',3),(1782,211,'榆树市',3),(1783,211,'农安县',3),(1784,212,'船营区',3),(1785,212,'昌邑区',3),(1786,212,'龙潭区',3),(1787,212,'丰满区',3),(1788,212,'蛟河市',3),(1789,212,'桦甸市',3),(1790,212,'舒兰市',3),(1791,212,'磐石市',3),(1792,212,'永吉县',3),(1793,213,'洮北区',3),(1794,213,'洮南市',3),(1795,213,'大安市',3),(1796,213,'镇赉县',3),(1797,213,'通榆县',3),(1798,214,'江源区',3),(1799,214,'八道江区',3),(1800,214,'长白',3),(1801,214,'临江市',3),(1802,214,'抚松县',3),(1803,214,'靖宇县',3),(1804,215,'龙山区',3),(1805,215,'西安区',3),(1806,215,'东丰县',3),(1807,215,'东辽县',3),(1808,216,'铁西区',3),(1809,216,'铁东区',3),(1810,216,'伊通',3),(1811,216,'公主岭市',3),(1812,216,'双辽市',3),(1813,216,'梨树县',3),(1814,217,'前郭尔罗斯',3),(1815,217,'宁江区',3),(1816,217,'长岭县',3),(1817,217,'乾安县',3),(1818,217,'扶余县',3),(1819,218,'东昌区',3),(1820,218,'二道江区',3),(1821,218,'梅河口市',3),(1822,218,'集安市',3),(1823,218,'通化县',3),(1824,218,'辉南县',3),(1825,218,'柳河县',3),(1826,219,'延吉市',3),(1827,219,'图们市',3),(1828,219,'敦化市',3),(1829,219,'珲春市',3),(1830,219,'龙井市',3),(1831,219,'和龙市',3),(1832,219,'安图县',3),(1833,219,'汪清县',3),(1834,220,'玄武区',3),(1835,220,'鼓楼区',3),(1836,220,'白下区',3),(1837,220,'建邺区',3),(1838,220,'秦淮区',3),(1839,220,'雨花台区',3),(1840,220,'下关区',3),(1841,220,'栖霞区',3),(1842,220,'浦口区',3),(1843,220,'江宁区',3),(1844,220,'六合区',3),(1845,220,'溧水县',3),(1846,220,'高淳县',3),(1847,221,'沧浪区',3),(1848,221,'金阊区',3),(1849,221,'平江区',3),(1850,221,'虎丘区',3),(1851,221,'吴中区',3),(1852,221,'相城区',3),(1853,221,'园区',3),(1854,221,'新区',3),(1855,221,'常熟市',3),(1856,221,'张家港市',3),(1857,221,'玉山镇',3),(1858,221,'巴城镇',3),(1859,221,'周市镇',3),(1860,221,'陆家镇',3),(1861,221,'花桥镇',3),(1862,221,'淀山湖镇',3),(1863,221,'张浦镇',3),(1864,221,'周庄镇',3),(1865,221,'千灯镇',3),(1866,221,'锦溪镇',3),(1867,221,'开发区',3),(1868,221,'吴江市',3),(1869,221,'太仓市',3),(1870,222,'崇安区',3),(1871,222,'北塘区',3),(1872,222,'南长区',3),(1873,222,'锡山区',3),(1874,222,'惠山区',3),(1875,222,'滨湖区',3),(1876,222,'新区',3),(1877,222,'江阴市',3),(1878,222,'宜兴市',3),(1879,223,'天宁区',3),(1880,223,'钟楼区',3),(1881,223,'戚墅堰区',3),(1882,223,'郊区',3),(1883,223,'新北区',3),(1884,223,'武进区',3),(1885,223,'溧阳市',3),(1886,223,'金坛市',3),(1887,224,'清河区',3),(1888,224,'清浦区',3),(1889,224,'楚州区',3),(1890,224,'淮阴区',3),(1891,224,'涟水县',3),(1892,224,'洪泽县',3),(1893,224,'盱眙县',3),(1894,224,'金湖县',3),(1895,225,'新浦区',3),(1896,225,'连云区',3),(1897,225,'海州区',3),(1898,225,'赣榆县',3),(1899,225,'东海县',3),(1900,225,'灌云县',3),(1901,225,'灌南县',3),(1902,226,'崇川区',3),(1903,226,'港闸区',3),(1904,226,'经济开发区',3),(1905,226,'启东市',3),(1906,226,'如皋市',3),(1907,226,'通州市',3),(1908,226,'海门市',3),(1909,226,'海安县',3),(1910,226,'如东县',3),(1911,227,'宿城区',3),(1912,227,'宿豫区',3),(1913,227,'宿豫县',3),(1914,227,'沭阳县',3),(1915,227,'泗阳县',3),(1916,227,'泗洪县',3),(1917,228,'海陵区',3),(1918,228,'高港区',3),(1919,228,'兴化市',3),(1920,228,'靖江市',3),(1921,228,'泰兴市',3),(1922,228,'姜堰市',3),(1923,229,'云龙区',3),(1924,229,'鼓楼区',3),(1925,229,'九里区',3),(1926,229,'贾汪区',3),(1927,229,'泉山区',3),(1928,229,'新沂市',3),(1929,229,'邳州市',3),(1930,229,'丰县',3),(1931,229,'沛县',3),(1932,229,'铜山县',3),(1933,229,'睢宁县',3),(1934,230,'城区',3),(1935,230,'亭湖区',3),(1936,230,'盐都区',3),(1937,230,'盐都县',3),(1938,230,'东台市',3),(1939,230,'大丰市',3),(1940,230,'响水县',3),(1941,230,'滨海县',3),(1942,230,'阜宁县',3),(1943,230,'射阳县',3),(1944,230,'建湖县',3),(1945,231,'广陵区',3),(1946,231,'维扬区',3),(1947,231,'邗江区',3),(1948,231,'仪征市',3),(1949,231,'高邮市',3),(1950,231,'江都市',3),(1951,231,'宝应县',3),(1952,232,'京口区',3),(1953,232,'润州区',3),(1954,232,'丹徒区',3),(1955,232,'丹阳市',3),(1956,232,'扬中市',3),(1957,232,'句容市',3),(1958,233,'东湖区',3),(1959,233,'西湖区',3),(1960,233,'青云谱区',3),(1961,233,'湾里区',3),(1962,233,'青山湖区',3),(1963,233,'红谷滩新区',3),(1964,233,'昌北区',3),(1965,233,'高新区',3),(1966,233,'南昌县',3),(1967,233,'新建县',3),(1968,233,'安义县',3),(1969,233,'进贤县',3),(1970,234,'临川区',3),(1971,234,'南城县',3),(1972,234,'黎川县',3),(1973,234,'南丰县',3),(1974,234,'崇仁县',3),(1975,234,'乐安县',3),(1976,234,'宜黄县',3),(1977,234,'金溪县',3),(1978,234,'资溪县',3),(1979,234,'东乡县',3),(1980,234,'广昌县',3),(1981,235,'章贡区',3),(1982,235,'于都县',3),(1983,235,'瑞金市',3),(1984,235,'南康市',3),(1985,235,'赣县',3),(1986,235,'信丰县',3),(1987,235,'大余县',3),(1988,235,'上犹县',3),(1989,235,'崇义县',3),(1990,235,'安远县',3),(1991,235,'龙南县',3),(1992,235,'定南县',3),(1993,235,'全南县',3),(1994,235,'宁都县',3),(1995,235,'兴国县',3),(1996,235,'会昌县',3),(1997,235,'寻乌县',3),(1998,235,'石城县',3),(1999,236,'安福县',3),(2000,236,'吉州区',3),(2001,236,'青原区',3),(2002,236,'井冈山市',3),(2003,236,'吉安县',3),(2004,236,'吉水县',3),(2005,236,'峡江县',3),(2006,236,'新干县',3),(2007,236,'永丰县',3),(2008,236,'泰和县',3),(2009,236,'遂川县',3),(2010,236,'万安县',3),(2011,236,'永新县',3),(2012,237,'珠山区',3),(2013,237,'昌江区',3),(2014,237,'乐平市',3),(2015,237,'浮梁县',3),(2016,238,'浔阳区',3),(2017,238,'庐山区',3),(2018,238,'瑞昌市',3),(2019,238,'九江县',3),(2020,238,'武宁县',3),(2021,238,'修水县',3),(2022,238,'永修县',3),(2023,238,'德安县',3),(2024,238,'星子县',3),(2025,238,'都昌县',3),(2026,238,'湖口县',3),(2027,238,'彭泽县',3),(2028,239,'安源区',3),(2029,239,'湘东区',3),(2030,239,'莲花县',3),(2031,239,'芦溪县',3),(2032,239,'上栗县',3),(2033,240,'信州区',3),(2034,240,'德兴市',3),(2035,240,'上饶县',3),(2036,240,'广丰县',3),(2037,240,'玉山县',3),(2038,240,'铅山县',3),(2039,240,'横峰县',3),(2040,240,'弋阳县',3),(2041,240,'余干县',3),(2042,240,'波阳县',3),(2043,240,'万年县',3),(2044,240,'婺源县',3),(2045,241,'渝水区',3),(2046,241,'分宜县',3),(2047,242,'袁州区',3),(2048,242,'丰城市',3),(2049,242,'樟树市',3),(2050,242,'高安市',3),(2051,242,'奉新县',3),(2052,242,'万载县',3),(2053,242,'上高县',3),(2054,242,'宜丰县',3),(2055,242,'靖安县',3),(2056,242,'铜鼓县',3),(2057,243,'月湖区',3),(2058,243,'贵溪市',3),(2059,243,'余江县',3),(2060,244,'沈河区',3),(2061,244,'皇姑区',3),(2062,244,'和平区',3),(2063,244,'大东区',3),(2064,244,'铁西区',3),(2065,244,'苏家屯区',3),(2066,244,'东陵区',3),(2067,244,'沈北新区',3),(2068,244,'于洪区',3),(2069,244,'浑南新区',3),(2070,244,'新民市',3),(2071,244,'辽中县',3),(2072,244,'康平县',3),(2073,244,'法库县',3),(2074,245,'西岗区',3),(2075,245,'中山区',3),(2076,245,'沙河口区',3),(2077,245,'甘井子区',3),(2078,245,'旅顺口区',3),(2079,245,'金州区',3),(2080,245,'开发区',3),(2081,245,'瓦房店市',3),(2082,245,'普兰店市',3),(2083,245,'庄河市',3),(2084,245,'长海县',3),(2085,246,'铁东区',3),(2086,246,'铁西区',3),(2087,246,'立山区',3),(2088,246,'千山区',3),(2089,246,'岫岩',3),(2090,246,'海城市',3),(2091,246,'台安县',3),(2092,247,'本溪',3),(2093,247,'平山区',3),(2094,247,'明山区',3),(2095,247,'溪湖区',3),(2096,247,'南芬区',3),(2097,247,'桓仁',3),(2098,248,'双塔区',3),(2099,248,'龙城区',3),(2100,248,'喀喇沁左翼蒙古族自治县',3),(2101,248,'北票市',3),(2102,248,'凌源市',3),(2103,248,'朝阳县',3),(2104,248,'建平县',3),(2105,249,'振兴区',3),(2106,249,'元宝区',3),(2107,249,'振安区',3),(2108,249,'宽甸',3),(2109,249,'东港市',3),(2110,249,'凤城市',3),(2111,250,'顺城区',3),(2112,250,'新抚区',3),(2113,250,'东洲区',3),(2114,250,'望花区',3),(2115,250,'清原',3),(2116,250,'新宾',3),(2117,250,'抚顺县',3),(2118,251,'阜新',3),(2119,251,'海州区',3),(2120,251,'新邱区',3),(2121,251,'太平区',3),(2122,251,'清河门区',3),(2123,251,'细河区',3),(2124,251,'彰武县',3),(2125,252,'龙港区',3),(2126,252,'南票区',3),(2127,252,'连山区',3),(2128,252,'兴城市',3),(2129,252,'绥中县',3),(2130,252,'建昌县',3),(2131,253,'太和区',3),(2132,253,'古塔区',3),(2133,253,'凌河区',3),(2134,253,'凌海市',3),(2135,253,'北镇市',3),(2136,253,'黑山县',3),(2137,253,'义县',3),(2138,254,'白塔区',3),(2139,254,'文圣区',3),(2140,254,'宏伟区',3),(2141,254,'太子河区',3),(2142,254,'弓长岭区',3),(2143,254,'灯塔市',3),(2144,254,'辽阳县',3),(2145,255,'双台子区',3),(2146,255,'兴隆台区',3),(2147,255,'大洼县',3),(2148,255,'盘山县',3),(2149,256,'银州区',3),(2150,256,'清河区',3),(2151,256,'调兵山市',3),(2152,256,'开原市',3),(2153,256,'铁岭县',3),(2154,256,'西丰县',3),(2155,256,'昌图县',3),(2156,257,'站前区',3),(2157,257,'西市区',3),(2158,257,'鲅鱼圈区',3),(2159,257,'老边区',3),(2160,257,'盖州市',3),(2161,257,'大石桥市',3),(2162,258,'回民区',3),(2163,258,'玉泉区',3),(2164,258,'新城区',3),(2165,258,'赛罕区',3),(2166,258,'清水河县',3),(2167,258,'土默特左旗',3),(2168,258,'托克托县',3),(2169,258,'和林格尔县',3),(2170,258,'武川县',3),(2171,259,'阿拉善左旗',3),(2172,259,'阿拉善右旗',3),(2173,259,'额济纳旗',3),(2174,260,'临河区',3),(2175,260,'五原县',3),(2176,260,'磴口县',3),(2177,260,'乌拉特前旗',3),(2178,260,'乌拉特中旗',3),(2179,260,'乌拉特后旗',3),(2180,260,'杭锦后旗',3),(2181,261,'昆都仑区',3),(2182,261,'青山区',3),(2183,261,'东河区',3),(2184,261,'九原区',3),(2185,261,'石拐区',3),(2186,261,'白云矿区',3),(2187,261,'土默特右旗',3),(2188,261,'固阳县',3),(2189,261,'达尔罕茂明安联合旗',3),(2190,262,'红山区',3),(2191,262,'元宝山区',3),(2192,262,'松山区',3),(2193,262,'阿鲁科尔沁旗',3),(2194,262,'巴林左旗',3),(2195,262,'巴林右旗',3),(2196,262,'林西县',3),(2197,262,'克什克腾旗',3),(2198,262,'翁牛特旗',3),(2199,262,'喀喇沁旗',3),(2200,262,'宁城县',3),(2201,262,'敖汉旗',3),(2202,263,'东胜区',3),(2203,263,'达拉特旗',3),(2204,263,'准格尔旗',3),(2205,263,'鄂托克前旗',3),(2206,263,'鄂托克旗',3),(2207,263,'杭锦旗',3),(2208,263,'乌审旗',3),(2209,263,'伊金霍洛旗',3),(2210,264,'海拉尔区',3),(2211,264,'莫力达瓦',3),(2212,264,'满洲里市',3),(2213,264,'牙克石市',3),(2214,264,'扎兰屯市',3),(2215,264,'额尔古纳市',3),(2216,264,'根河市',3),(2217,264,'阿荣旗',3),(2218,264,'鄂伦春自治旗',3),(2219,264,'鄂温克族自治旗',3),(2220,264,'陈巴尔虎旗',3),(2221,264,'新巴尔虎左旗',3),(2222,264,'新巴尔虎右旗',3),(2223,265,'科尔沁区',3),(2224,265,'霍林郭勒市',3),(2225,265,'科尔沁左翼中旗',3),(2226,265,'科尔沁左翼后旗',3),(2227,265,'开鲁县',3),(2228,265,'库伦旗',3),(2229,265,'奈曼旗',3),(2230,265,'扎鲁特旗',3),(2231,266,'海勃湾区',3),(2232,266,'乌达区',3),(2233,266,'海南区',3),(2234,267,'化德县',3),(2235,267,'集宁区',3),(2236,267,'丰镇市',3),(2237,267,'卓资县',3),(2238,267,'商都县',3),(2239,267,'兴和县',3),(2240,267,'凉城县',3),(2241,267,'察哈尔右翼前旗',3),(2242,267,'察哈尔右翼中旗',3),(2243,267,'察哈尔右翼后旗',3),(2244,267,'四子王旗',3),(2245,268,'二连浩特市',3),(2246,268,'锡林浩特市',3),(2247,268,'阿巴嘎旗',3),(2248,268,'苏尼特左旗',3),(2249,268,'苏尼特右旗',3),(2250,268,'东乌珠穆沁旗',3),(2251,268,'西乌珠穆沁旗',3),(2252,268,'太仆寺旗',3),(2253,268,'镶黄旗',3),(2254,268,'正镶白旗',3),(2255,268,'正蓝旗',3),(2256,268,'多伦县',3),(2257,269,'乌兰浩特市',3),(2258,269,'阿尔山市',3),(2259,269,'科尔沁右翼前旗',3),(2260,269,'科尔沁右翼中旗',3),(2261,269,'扎赉特旗',3),(2262,269,'突泉县',3),(2263,270,'西夏区',3),(2264,270,'金凤区',3),(2265,270,'兴庆区',3),(2266,270,'灵武市',3),(2267,270,'永宁县',3),(2268,270,'贺兰县',3),(2269,271,'原州区',3),(2270,271,'海原县',3),(2271,271,'西吉县',3),(2272,271,'隆德县',3),(2273,271,'泾源县',3),(2274,271,'彭阳县',3),(2275,272,'惠农县',3),(2276,272,'大武口区',3),(2277,272,'惠农区',3),(2278,272,'陶乐县',3),(2279,272,'平罗县',3),(2280,273,'利通区',3),(2281,273,'中卫县',3),(2282,273,'青铜峡市',3),(2283,273,'中宁县',3),(2284,273,'盐池县',3),(2285,273,'同心县',3),(2286,274,'沙坡头区',3),(2287,274,'海原县',3),(2288,274,'中宁县',3),(2289,275,'城中区',3),(2290,275,'城东区',3),(2291,275,'城西区',3),(2292,275,'城北区',3),(2293,275,'湟中县',3),(2294,275,'湟源县',3),(2295,275,'大通',3),(2296,276,'玛沁县',3),(2297,276,'班玛县',3),(2298,276,'甘德县',3),(2299,276,'达日县',3),(2300,276,'久治县',3),(2301,276,'玛多县',3),(2302,277,'海晏县',3),(2303,277,'祁连县',3),(2304,277,'刚察县',3),(2305,277,'门源',3),(2306,278,'平安县',3),(2307,278,'乐都县',3),(2308,278,'民和',3),(2309,278,'互助',3),(2310,278,'化隆',3),(2311,278,'循化',3),(2312,279,'共和县',3),(2313,279,'同德县',3),(2314,279,'贵德县',3),(2315,279,'兴海县',3),(2316,279,'贵南县',3),(2317,280,'德令哈市',3),(2318,280,'格尔木市',3),(2319,280,'乌兰县',3),(2320,280,'都兰县',3),(2321,280,'天峻县',3),(2322,281,'同仁县',3),(2323,281,'尖扎县',3),(2324,281,'泽库县',3),(2325,281,'河南蒙古族自治县',3),(2326,282,'玉树县',3),(2327,282,'杂多县',3),(2328,282,'称多县',3),(2329,282,'治多县',3),(2330,282,'囊谦县',3),(2331,282,'曲麻莱县',3),(2332,283,'市中区',3),(2333,283,'历下区',3),(2334,283,'天桥区',3),(2335,283,'槐荫区',3),(2336,283,'历城区',3),(2337,283,'长清区',3),(2338,283,'章丘市',3),(2339,283,'平阴县',3),(2340,283,'济阳县',3),(2341,283,'商河县',3),(2342,284,'市南区',3),(2343,284,'市北区',3),(2344,284,'城阳区',3),(2345,284,'四方区',3),(2346,284,'李沧区',3),(2347,284,'黄岛区',3),(2348,284,'崂山区',3),(2349,284,'胶州市',3),(2350,284,'即墨市',3),(2351,284,'平度市',3),(2352,284,'胶南市',3),(2353,284,'莱西市',3),(2354,285,'滨城区',3),(2355,285,'惠民县',3),(2356,285,'阳信县',3),(2357,285,'无棣县',3),(2358,285,'沾化县',3),(2359,285,'博兴县',3),(2360,285,'邹平县',3),(2361,286,'德城区',3),(2362,286,'陵县',3),(2363,286,'乐陵市',3),(2364,286,'禹城市',3),(2365,286,'宁津县',3),(2366,286,'庆云县',3),(2367,286,'临邑县',3),(2368,286,'齐河县',3),(2369,286,'平原县',3),(2370,286,'夏津县',3),(2371,286,'武城县',3),(2372,287,'东营区',3),(2373,287,'河口区',3),(2374,287,'垦利县',3),(2375,287,'利津县',3),(2376,287,'广饶县',3),(2377,288,'牡丹区',3),(2378,288,'曹县',3),(2379,288,'单县',3),(2380,288,'成武县',3),(2381,288,'巨野县',3),(2382,288,'郓城县',3),(2383,288,'鄄城县',3),(2384,288,'定陶县',3),(2385,288,'东明县',3),(2386,289,'市中区',3),(2387,289,'任城区',3),(2388,289,'曲阜市',3),(2389,289,'兖州市',3),(2390,289,'邹城市',3),(2391,289,'微山县',3),(2392,289,'鱼台县',3),(2393,289,'金乡县',3),(2394,289,'嘉祥县',3),(2395,289,'汶上县',3),(2396,289,'泗水县',3),(2397,289,'梁山县',3),(2398,290,'莱城区',3),(2399,290,'钢城区',3),(2400,291,'东昌府区',3),(2401,291,'临清市',3),(2402,291,'阳谷县',3),(2403,291,'莘县',3),(2404,291,'茌平县',3),(2405,291,'东阿县',3),(2406,291,'冠县',3),(2407,291,'高唐县',3),(2408,292,'兰山区',3),(2409,292,'罗庄区',3),(2410,292,'河东区',3),(2411,292,'沂南县',3),(2412,292,'郯城县',3),(2413,292,'沂水县',3),(2414,292,'苍山县',3),(2415,292,'费县',3),(2416,292,'平邑县',3),(2417,292,'莒南县',3),(2418,292,'蒙阴县',3),(2419,292,'临沭县',3),(2420,293,'东港区',3),(2421,293,'岚山区',3),(2422,293,'五莲县',3),(2423,293,'莒县',3),(2424,294,'泰山区',3),(2425,294,'岱岳区',3),(2426,294,'新泰市',3),(2427,294,'肥城市',3),(2428,294,'宁阳县',3),(2429,294,'东平县',3),(2430,295,'荣成市',3),(2431,295,'乳山市',3),(2432,295,'环翠区',3),(2433,295,'文登市',3),(2434,296,'潍城区',3),(2435,296,'寒亭区',3),(2436,296,'坊子区',3),(2437,296,'奎文区',3),(2438,296,'青州市',3),(2439,296,'诸城市',3),(2440,296,'寿光市',3),(2441,296,'安丘市',3),(2442,296,'高密市',3),(2443,296,'昌邑市',3),(2444,296,'临朐县',3),(2445,296,'昌乐县',3),(2446,297,'芝罘区',3),(2447,297,'福山区',3),(2448,297,'牟平区',3),(2449,297,'莱山区',3),(2450,297,'开发区',3),(2451,297,'龙口市',3),(2452,297,'莱阳市',3),(2453,297,'莱州市',3),(2454,297,'蓬莱市',3),(2455,297,'招远市',3),(2456,297,'栖霞市',3),(2457,297,'海阳市',3),(2458,297,'长岛县',3),(2459,298,'市中区',3),(2460,298,'山亭区',3),(2461,298,'峄城区',3),(2462,298,'台儿庄区',3),(2463,298,'薛城区',3),(2464,298,'滕州市',3),(2465,299,'张店区',3),(2466,299,'临淄区',3),(2467,299,'淄川区',3),(2468,299,'博山区',3),(2469,299,'周村区',3),(2470,299,'桓台县',3),(2471,299,'高青县',3),(2472,299,'沂源县',3),(2473,300,'杏花岭区',3),(2474,300,'小店区',3),(2475,300,'迎泽区',3),(2476,300,'尖草坪区',3),(2477,300,'万柏林区',3),(2478,300,'晋源区',3),(2479,300,'高新开发区',3),(2480,300,'民营经济开发区',3),(2481,300,'经济技术开发区',3),(2482,300,'清徐县',3),(2483,300,'阳曲县',3),(2484,300,'娄烦县',3),(2485,300,'古交市',3),(2486,301,'城区',3),(2487,301,'郊区',3),(2488,301,'沁县',3),(2489,301,'潞城市',3),(2490,301,'长治县',3),(2491,301,'襄垣县',3),(2492,301,'屯留县',3),(2493,301,'平顺县',3),(2494,301,'黎城县',3),(2495,301,'壶关县',3),(2496,301,'长子县',3),(2497,301,'武乡县',3),(2498,301,'沁源县',3),(2499,302,'城区',3),(2500,302,'矿区',3),(2501,302,'南郊区',3),(2502,302,'新荣区',3),(2503,302,'阳高县',3),(2504,302,'天镇县',3),(2505,302,'广灵县',3),(2506,302,'灵丘县',3),(2507,302,'浑源县',3),(2508,302,'左云县',3),(2509,302,'大同县',3),(2510,303,'城区',3),(2511,303,'高平市',3),(2512,303,'沁水县',3),(2513,303,'阳城县',3),(2514,303,'陵川县',3),(2515,303,'泽州县',3),(2516,304,'榆次区',3),(2517,304,'介休市',3),(2518,304,'榆社县',3),(2519,304,'左权县',3),(2520,304,'和顺县',3),(2521,304,'昔阳县',3),(2522,304,'寿阳县',3),(2523,304,'太谷县',3),(2524,304,'祁县',3),(2525,304,'平遥县',3),(2526,304,'灵石县',3),(2527,305,'尧都区',3),(2528,305,'侯马市',3),(2529,305,'霍州市',3),(2530,305,'曲沃县',3),(2531,305,'翼城县',3),(2532,305,'襄汾县',3),(2533,305,'洪洞县',3),(2534,305,'吉县',3),(2535,305,'安泽县',3),(2536,305,'浮山县',3),(2537,305,'古县',3),(2538,305,'乡宁县',3),(2539,305,'大宁县',3),(2540,305,'隰县',3),(2541,305,'永和县',3),(2542,305,'蒲县',3),(2543,305,'汾西县',3),(2544,306,'离石市',3),(2545,306,'离石区',3),(2546,306,'孝义市',3),(2547,306,'汾阳市',3),(2548,306,'文水县',3),(2549,306,'交城县',3),(2550,306,'兴县',3),(2551,306,'临县',3),(2552,306,'柳林县',3),(2553,306,'石楼县',3),(2554,306,'岚县',3),(2555,306,'方山县',3),(2556,306,'中阳县',3),(2557,306,'交口县',3),(2558,307,'朔城区',3),(2559,307,'平鲁区',3),(2560,307,'山阴县',3),(2561,307,'应县',3),(2562,307,'右玉县',3),(2563,307,'怀仁县',3),(2564,308,'忻府区',3),(2565,308,'原平市',3),(2566,308,'定襄县',3),(2567,308,'五台县',3),(2568,308,'代县',3),(2569,308,'繁峙县',3),(2570,308,'宁武县',3),(2571,308,'静乐县',3),(2572,308,'神池县',3),(2573,308,'五寨县',3),(2574,308,'岢岚县',3),(2575,308,'河曲县',3),(2576,308,'保德县',3),(2577,308,'偏关县',3),(2578,309,'城区',3),(2579,309,'矿区',3),(2580,309,'郊区',3),(2581,309,'平定县',3),(2582,309,'盂县',3),(2583,310,'盐湖区',3),(2584,310,'永济市',3),(2585,310,'河津市',3),(2586,310,'临猗县',3),(2587,310,'万荣县',3),(2588,310,'闻喜县',3),(2589,310,'稷山县',3),(2590,310,'新绛县',3),(2591,310,'绛县',3),(2592,310,'垣曲县',3),(2593,310,'夏县',3),(2594,310,'平陆县',3),(2595,310,'芮城县',3),(2596,311,'莲湖区',3),(2597,311,'新城区',3),(2598,311,'碑林区',3),(2599,311,'雁塔区',3),(2600,311,'灞桥区',3),(2601,311,'未央区',3),(2602,311,'阎良区',3),(2603,311,'临潼区',3),(2604,311,'长安区',3),(2605,311,'蓝田县',3),(2606,311,'周至县',3),(2607,311,'户县',3),(2608,311,'高陵县',3),(2609,312,'汉滨区',3),(2610,312,'汉阴县',3),(2611,312,'石泉县',3),(2612,312,'宁陕县',3),(2613,312,'紫阳县',3),(2614,312,'岚皋县',3),(2615,312,'平利县',3),(2616,312,'镇坪县',3),(2617,312,'旬阳县',3),(2618,312,'白河县',3),(2619,313,'陈仓区',3),(2620,313,'渭滨区',3),(2621,313,'金台区',3),(2622,313,'凤翔县',3),(2623,313,'岐山县',3),(2624,313,'扶风县',3),(2625,313,'眉县',3),(2626,313,'陇县',3),(2627,313,'千阳县',3),(2628,313,'麟游县',3),(2629,313,'凤县',3),(2630,313,'太白县',3),(2631,314,'汉台区',3),(2632,314,'南郑县',3),(2633,314,'城固县',3),(2634,314,'洋县',3),(2635,314,'西乡县',3),(2636,314,'勉县',3),(2637,314,'宁强县',3),(2638,314,'略阳县',3),(2639,314,'镇巴县',3),(2640,314,'留坝县',3),(2641,314,'佛坪县',3),(2642,315,'商州区',3),(2643,315,'洛南县',3),(2644,315,'丹凤县',3),(2645,315,'商南县',3),(2646,315,'山阳县',3),(2647,315,'镇安县',3),(2648,315,'柞水县',3),(2649,316,'耀州区',3),(2650,316,'王益区',3),(2651,316,'印台区',3),(2652,316,'宜君县',3),(2653,317,'临渭区',3),(2654,317,'韩城市',3),(2655,317,'华阴市',3),(2656,317,'华县',3),(2657,317,'潼关县',3),(2658,317,'大荔县',3),(2659,317,'合阳县',3),(2660,317,'澄城县',3),(2661,317,'蒲城县',3),(2662,317,'白水县',3),(2663,317,'富平县',3),(2664,318,'秦都区',3),(2665,318,'渭城区',3),(2666,318,'杨陵区',3),(2667,318,'兴平市',3),(2668,318,'三原县',3),(2669,318,'泾阳县',3),(2670,318,'乾县',3),(2671,318,'礼泉县',3),(2672,318,'永寿县',3),(2673,318,'彬县',3),(2674,318,'长武县',3),(2675,318,'旬邑县',3),(2676,318,'淳化县',3),(2677,318,'武功县',3),(2678,319,'吴起县',3),(2679,319,'宝塔区',3),(2680,319,'延长县',3),(2681,319,'延川县',3),(2682,319,'子长县',3),(2683,319,'安塞县',3),(2684,319,'志丹县',3),(2685,319,'甘泉县',3),(2686,319,'富县',3),(2687,319,'洛川县',3),(2688,319,'宜川县',3),(2689,319,'黄龙县',3),(2690,319,'黄陵县',3),(2691,320,'榆阳区',3),(2692,320,'神木县',3),(2693,320,'府谷县',3),(2694,320,'横山县',3),(2695,320,'靖边县',3),(2696,320,'定边县',3),(2697,320,'绥德县',3),(2698,320,'米脂县',3),(2699,320,'佳县',3),(2700,320,'吴堡县',3),(2701,320,'清涧县',3),(2702,320,'子洲县',3),(2703,321,'长宁区',3),(2704,321,'闸北区',3),(2705,321,'闵行区',3),(2706,321,'徐汇区',3),(2707,321,'浦东新区',3),(2708,321,'杨浦区',3),(2709,321,'普陀区',3),(2710,321,'静安区',3),(2711,321,'卢湾区',3),(2712,321,'虹口区',3),(2713,321,'黄浦区',3),(2714,321,'南汇区',3),(2715,321,'松江区',3),(2716,321,'嘉定区',3),(2717,321,'宝山区',3),(2718,321,'青浦区',3),(2719,321,'金山区',3),(2720,321,'奉贤区',3),(2721,321,'崇明县',3),(2722,322,'青羊区',3),(2723,322,'锦江区',3),(2724,322,'金牛区',3),(2725,322,'武侯区',3),(2726,322,'成华区',3),(2727,322,'龙泉驿区',3),(2728,322,'青白江区',3),(2729,322,'新都区',3),(2730,322,'温江区',3),(2731,322,'高新区',3),(2732,322,'高新西区',3),(2733,322,'都江堰市',3),(2734,322,'彭州市',3),(2735,322,'邛崃市',3),(2736,322,'崇州市',3),(2737,322,'金堂县',3),(2738,322,'双流县',3),(2739,322,'郫县',3),(2740,322,'大邑县',3),(2741,322,'蒲江县',3),(2742,322,'新津县',3),(2743,322,'都江堰市',3),(2744,322,'彭州市',3),(2745,322,'邛崃市',3),(2746,322,'崇州市',3),(2747,322,'金堂县',3),(2748,322,'双流县',3),(2749,322,'郫县',3),(2750,322,'大邑县',3),(2751,322,'蒲江县',3),(2752,322,'新津县',3),(2753,323,'涪城区',3),(2754,323,'游仙区',3),(2755,323,'江油市',3),(2756,323,'盐亭县',3),(2757,323,'三台县',3),(2758,323,'平武县',3),(2759,323,'安县',3),(2760,323,'梓潼县',3),(2761,323,'北川县',3),(2762,324,'马尔康县',3),(2763,324,'汶川县',3),(2764,324,'理县',3),(2765,324,'茂县',3),(2766,324,'松潘县',3),(2767,324,'九寨沟县',3),(2768,324,'金川县',3),(2769,324,'小金县',3),(2770,324,'黑水县',3),(2771,324,'壤塘县',3),(2772,324,'阿坝县',3),(2773,324,'若尔盖县',3),(2774,324,'红原县',3),(2775,325,'巴州区',3),(2776,325,'通江县',3),(2777,325,'南江县',3),(2778,325,'平昌县',3),(2779,326,'通川区',3),(2780,326,'万源市',3),(2781,326,'达县',3),(2782,326,'宣汉县',3),(2783,326,'开江县',3),(2784,326,'大竹县',3),(2785,326,'渠县',3),(2786,327,'旌阳区',3),(2787,327,'广汉市',3),(2788,327,'什邡市',3),(2789,327,'绵竹市',3),(2790,327,'罗江县',3),(2791,327,'中江县',3),(2792,328,'康定县',3),(2793,328,'丹巴县',3),(2794,328,'泸定县',3),(2795,328,'炉霍县',3),(2796,328,'九龙县',3),(2797,328,'甘孜县',3),(2798,328,'雅江县',3),(2799,328,'新龙县',3),(2800,328,'道孚县',3),(2801,328,'白玉县',3),(2802,328,'理塘县',3),(2803,328,'德格县',3),(2804,328,'乡城县',3),(2805,328,'石渠县',3),(2806,328,'稻城县',3),(2807,328,'色达县',3),(2808,328,'巴塘县',3),(2809,328,'得荣县',3),(2810,329,'广安区',3),(2811,329,'华蓥市',3),(2812,329,'岳池县',3),(2813,329,'武胜县',3),(2814,329,'邻水县',3),(2815,330,'利州区',3),(2816,330,'元坝区',3),(2817,330,'朝天区',3),(2818,330,'旺苍县',3),(2819,330,'青川县',3),(2820,330,'剑阁县',3),(2821,330,'苍溪县',3),(2822,331,'峨眉山市',3),(2823,331,'乐山市',3),(2824,331,'犍为县',3),(2825,331,'井研县',3),(2826,331,'夹江县',3),(2827,331,'沐川县',3),(2828,331,'峨边',3),(2829,331,'马边',3),(2830,332,'西昌市',3),(2831,332,'盐源县',3),(2832,332,'德昌县',3),(2833,332,'会理县',3),(2834,332,'会东县',3),(2835,332,'宁南县',3),(2836,332,'普格县',3),(2837,332,'布拖县',3),(2838,332,'金阳县',3),(2839,332,'昭觉县',3),(2840,332,'喜德县',3),(2841,332,'冕宁县',3),(2842,332,'越西县',3),(2843,332,'甘洛县',3),(2844,332,'美姑县',3),(2845,332,'雷波县',3),(2846,332,'木里',3),(2847,333,'东坡区',3),(2848,333,'仁寿县',3),(2849,333,'彭山县',3),(2850,333,'洪雅县',3),(2851,333,'丹棱县',3),(2852,333,'青神县',3),(2853,334,'阆中市',3),(2854,334,'南部县',3),(2855,334,'营山县',3),(2856,334,'蓬安县',3),(2857,334,'仪陇县',3),(2858,334,'顺庆区',3),(2859,334,'高坪区',3),(2860,334,'嘉陵区',3),(2861,334,'西充县',3),(2862,335,'市中区',3),(2863,335,'东兴区',3),(2864,335,'威远县',3),(2865,335,'资中县',3),(2866,335,'隆昌县',3),(2867,336,'东  区',3),(2868,336,'西  区',3),(2869,336,'仁和区',3),(2870,336,'米易县',3),(2871,336,'盐边县',3),(2872,337,'船山区',3),(2873,337,'安居区',3),(2874,337,'蓬溪县',3),(2875,337,'射洪县',3),(2876,337,'大英县',3),(2877,338,'雨城区',3),(2878,338,'名山县',3),(2879,338,'荥经县',3),(2880,338,'汉源县',3),(2881,338,'石棉县',3),(2882,338,'天全县',3),(2883,338,'芦山县',3),(2884,338,'宝兴县',3),(2885,339,'翠屏区',3),(2886,339,'宜宾县',3),(2887,339,'南溪县',3),(2888,339,'江安县',3),(2889,339,'长宁县',3),(2890,339,'高县',3),(2891,339,'珙县',3),(2892,339,'筠连县',3),(2893,339,'兴文县',3),(2894,339,'屏山县',3),(2895,340,'雁江区',3),(2896,340,'简阳市',3),(2897,340,'安岳县',3),(2898,340,'乐至县',3),(2899,341,'大安区',3),(2900,341,'自流井区',3),(2901,341,'贡井区',3),(2902,341,'沿滩区',3),(2903,341,'荣县',3),(2904,341,'富顺县',3),(2905,342,'江阳区',3),(2906,342,'纳溪区',3),(2907,342,'龙马潭区',3),(2908,342,'泸县',3),(2909,342,'合江县',3),(2910,342,'叙永县',3),(2911,342,'古蔺县',3),(2912,343,'和平区',3),(2913,343,'河西区',3),(2914,343,'南开区',3),(2915,343,'河北区',3),(2916,343,'河东区',3),(2917,343,'红桥区',3),(2918,343,'东丽区',3),(2919,343,'津南区',3),(2920,343,'西青区',3),(2921,343,'北辰区',3),(2922,343,'塘沽区',3),(2923,343,'汉沽区',3),(2924,343,'大港区',3),(2925,343,'武清区',3),(2926,343,'宝坻区',3),(2927,343,'经济开发区',3),(2928,343,'宁河县',3),(2929,343,'静海县',3),(2930,343,'蓟县',3),(2931,344,'城关区',3),(2932,344,'林周县',3),(2933,344,'当雄县',3),(2934,344,'尼木县',3),(2935,344,'曲水县',3),(2936,344,'堆龙德庆县',3),(2937,344,'达孜县',3),(2938,344,'墨竹工卡县',3),(2939,345,'噶尔县',3),(2940,345,'普兰县',3),(2941,345,'札达县',3),(2942,345,'日土县',3),(2943,345,'革吉县',3),(2944,345,'改则县',3),(2945,345,'措勤县',3),(2946,346,'昌都县',3),(2947,346,'江达县',3),(2948,346,'贡觉县',3),(2949,346,'类乌齐县',3),(2950,346,'丁青县',3),(2951,346,'察雅县',3),(2952,346,'八宿县',3),(2953,346,'左贡县',3),(2954,346,'芒康县',3),(2955,346,'洛隆县',3),(2956,346,'边坝县',3),(2957,347,'林芝县',3),(2958,347,'工布江达县',3),(2959,347,'米林县',3),(2960,347,'墨脱县',3),(2961,347,'波密县',3),(2962,347,'察隅县',3),(2963,347,'朗县',3),(2964,348,'那曲县',3),(2965,348,'嘉黎县',3),(2966,348,'比如县',3),(2967,348,'聂荣县',3),(2968,348,'安多县',3),(2969,348,'申扎县',3),(2970,348,'索县',3),(2971,348,'班戈县',3),(2972,348,'巴青县',3),(2973,348,'尼玛县',3),(2974,349,'日喀则市',3),(2975,349,'南木林县',3),(2976,349,'江孜县',3),(2977,349,'定日县',3),(2978,349,'萨迦县',3),(2979,349,'拉孜县',3),(2980,349,'昂仁县',3),(2981,349,'谢通门县',3),(2982,349,'白朗县',3),(2983,349,'仁布县',3),(2984,349,'康马县',3),(2985,349,'定结县',3),(2986,349,'仲巴县',3),(2987,349,'亚东县',3),(2988,349,'吉隆县',3),(2989,349,'聂拉木县',3),(2990,349,'萨嘎县',3),(2991,349,'岗巴县',3),(2992,350,'乃东县',3),(2993,350,'扎囊县',3),(2994,350,'贡嘎县',3),(2995,350,'桑日县',3),(2996,350,'琼结县',3),(2997,350,'曲松县',3),(2998,350,'措美县',3),(2999,350,'洛扎县',3),(3000,350,'加查县',3),(3001,350,'隆子县',3),(3002,350,'错那县',3),(3003,350,'浪卡子县',3),(3004,351,'天山区',3),(3005,351,'沙依巴克区',3),(3006,351,'新市区',3),(3007,351,'水磨沟区',3),(3008,351,'头屯河区',3),(3009,351,'达坂城区',3),(3010,351,'米东区',3),(3011,351,'乌鲁木齐县',3),(3012,352,'阿克苏市',3),(3013,352,'温宿县',3),(3014,352,'库车县',3),(3015,352,'沙雅县',3),(3016,352,'新和县',3),(3017,352,'拜城县',3),(3018,352,'乌什县',3),(3019,352,'阿瓦提县',3),(3020,352,'柯坪县',3),(3021,353,'阿拉尔市',3),(3022,354,'库尔勒市',3),(3023,354,'轮台县',3),(3024,354,'尉犁县',3),(3025,354,'若羌县',3),(3026,354,'且末县',3),(3027,354,'焉耆',3),(3028,354,'和静县',3),(3029,354,'和硕县',3),(3030,354,'博湖县',3),(3031,355,'博乐市',3),(3032,355,'精河县',3),(3033,355,'温泉县',3),(3034,356,'呼图壁县',3),(3035,356,'米泉市',3),(3036,356,'昌吉市',3),(3037,356,'阜康市',3),(3038,356,'玛纳斯县',3),(3039,356,'奇台县',3),(3040,356,'吉木萨尔县',3),(3041,356,'木垒',3),(3042,357,'哈密市',3),(3043,357,'伊吾县',3),(3044,357,'巴里坤',3),(3045,358,'和田市',3),(3046,358,'和田县',3),(3047,358,'墨玉县',3),(3048,358,'皮山县',3),(3049,358,'洛浦县',3),(3050,358,'策勒县',3),(3051,358,'于田县',3),(3052,358,'民丰县',3),(3053,359,'喀什市',3),(3054,359,'疏附县',3),(3055,359,'疏勒县',3),(3056,359,'英吉沙县',3),(3057,359,'泽普县',3),(3058,359,'莎车县',3),(3059,359,'叶城县',3),(3060,359,'麦盖提县',3),(3061,359,'岳普湖县',3),(3062,359,'伽师县',3),(3063,359,'巴楚县',3),(3064,359,'塔什库尔干',3),(3065,360,'克拉玛依市',3),(3066,361,'阿图什市',3),(3067,361,'阿克陶县',3),(3068,361,'阿合奇县',3),(3069,361,'乌恰县',3),(3070,362,'石河子市',3),(3071,363,'图木舒克市',3),(3072,364,'吐鲁番市',3),(3073,364,'鄯善县',3),(3074,364,'托克逊县',3),(3075,365,'五家渠市',3),(3076,366,'阿勒泰市',3),(3077,366,'布克赛尔',3),(3078,366,'伊宁市',3),(3079,366,'布尔津县',3),(3080,366,'奎屯市',3),(3081,366,'乌苏市',3),(3082,366,'额敏县',3),(3083,366,'富蕴县',3),(3084,366,'伊宁县',3),(3085,366,'福海县',3),(3086,366,'霍城县',3),(3087,366,'沙湾县',3),(3088,366,'巩留县',3),(3089,366,'哈巴河县',3),(3090,366,'托里县',3),(3091,366,'青河县',3),(3092,366,'新源县',3),(3093,366,'裕民县',3),(3094,366,'和布克赛尔',3),(3095,366,'吉木乃县',3),(3096,366,'昭苏县',3),(3097,366,'特克斯县',3),(3098,366,'尼勒克县',3),(3099,366,'察布查尔',3),(3100,367,'盘龙区',3),(3101,367,'五华区',3),(3102,367,'官渡区',3),(3103,367,'西山区',3),(3104,367,'东川区',3),(3105,367,'安宁市',3),(3106,367,'呈贡县',3),(3107,367,'晋宁县',3),(3108,367,'富民县',3),(3109,367,'宜良县',3),(3110,367,'嵩明县',3),(3111,367,'石林县',3),(3112,367,'禄劝',3),(3113,367,'寻甸',3),(3114,368,'兰坪',3),(3115,368,'泸水县',3),(3116,368,'福贡县',3),(3117,368,'贡山',3),(3118,369,'宁洱',3),(3119,369,'思茅区',3),(3120,369,'墨江',3),(3121,369,'景东',3),(3122,369,'景谷',3),(3123,369,'镇沅',3),(3124,369,'江城',3),(3125,369,'孟连',3),(3126,369,'澜沧',3),(3127,369,'西盟',3),(3128,370,'古城区',3),(3129,370,'宁蒗',3),(3130,370,'玉龙',3),(3131,370,'永胜县',3),(3132,370,'华坪县',3),(3133,371,'隆阳区',3),(3134,371,'施甸县',3),(3135,371,'腾冲县',3),(3136,371,'龙陵县',3),(3137,371,'昌宁县',3),(3138,372,'楚雄市',3),(3139,372,'双柏县',3),(3140,372,'牟定县',3),(3141,372,'南华县',3),(3142,372,'姚安县',3),(3143,372,'大姚县',3),(3144,372,'永仁县',3),(3145,372,'元谋县',3),(3146,372,'武定县',3),(3147,372,'禄丰县',3),(3148,373,'大理市',3),(3149,373,'祥云县',3),(3150,373,'宾川县',3),(3151,373,'弥渡县',3),(3152,373,'永平县',3),(3153,373,'云龙县',3),(3154,373,'洱源县',3),(3155,373,'剑川县',3),(3156,373,'鹤庆县',3),(3157,373,'漾濞',3),(3158,373,'南涧',3),(3159,373,'巍山',3),(3160,374,'潞西市',3),(3161,374,'瑞丽市',3),(3162,374,'梁河县',3),(3163,374,'盈江县',3),(3164,374,'陇川县',3),(3165,375,'香格里拉县',3),(3166,375,'德钦县',3),(3167,375,'维西',3),(3168,376,'泸西县',3),(3169,376,'蒙自县',3),(3170,376,'个旧市',3),(3171,376,'开远市',3),(3172,376,'绿春县',3),(3173,376,'建水县',3),(3174,376,'石屏县',3),(3175,376,'弥勒县',3),(3176,376,'元阳县',3),(3177,376,'红河县',3),(3178,376,'金平',3),(3179,376,'河口',3),(3180,376,'屏边',3),(3181,377,'临翔区',3),(3182,377,'凤庆县',3),(3183,377,'云县',3),(3184,377,'永德县',3),(3185,377,'镇康县',3),(3186,377,'双江',3),(3187,377,'耿马',3),(3188,377,'沧源',3),(3189,378,'麒麟区',3),(3190,378,'宣威市',3),(3191,378,'马龙县',3),(3192,378,'陆良县',3),(3193,378,'师宗县',3),(3194,378,'罗平县',3),(3195,378,'富源县',3),(3196,378,'会泽县',3),(3197,378,'沾益县',3),(3198,379,'文山县',3),(3199,379,'砚山县',3),(3200,379,'西畴县',3),(3201,379,'麻栗坡县',3),(3202,379,'马关县',3),(3203,379,'丘北县',3),(3204,379,'广南县',3),(3205,379,'富宁县',3),(3206,380,'景洪市',3),(3207,380,'勐海县',3),(3208,380,'勐腊县',3),(3209,381,'红塔区',3),(3210,381,'江川县',3),(3211,381,'澄江县',3),(3212,381,'通海县',3),(3213,381,'华宁县',3),(3214,381,'易门县',3),(3215,381,'峨山',3),(3216,381,'新平',3),(3217,381,'元江',3),(3218,382,'昭阳区',3),(3219,382,'鲁甸县',3),(3220,382,'巧家县',3),(3221,382,'盐津县',3),(3222,382,'大关县',3),(3223,382,'永善县',3),(3224,382,'绥江县',3),(3225,382,'镇雄县',3),(3226,382,'彝良县',3),(3227,382,'威信县',3),(3228,382,'水富县',3),(3229,383,'西湖区',3),(3230,383,'上城区',3),(3231,383,'下城区',3),(3232,383,'拱墅区',3),(3233,383,'滨江区',3),(3234,383,'江干区',3),(3235,383,'萧山区',3),(3236,383,'余杭区',3),(3237,383,'市郊',3),(3238,383,'建德市',3),(3239,383,'富阳市',3),(3240,383,'临安市',3),(3241,383,'桐庐县',3),(3242,383,'淳安县',3),(3243,384,'吴兴区',3),(3244,384,'南浔区',3),(3245,384,'德清县',3),(3246,384,'长兴县',3),(3247,384,'安吉县',3),(3248,385,'南湖区',3),(3249,385,'秀洲区',3),(3250,385,'海宁市',3),(3251,385,'嘉善县',3),(3252,385,'平湖市',3),(3253,385,'桐乡市',3),(3254,385,'海盐县',3),(3255,386,'婺城区',3),(3256,386,'金东区',3),(3257,386,'兰溪市',3),(3258,386,'市区',3),(3259,386,'佛堂镇',3),(3260,386,'上溪镇',3),(3261,386,'义亭镇',3),(3262,386,'大陈镇',3),(3263,386,'苏溪镇',3),(3264,386,'赤岸镇',3),(3265,386,'东阳市',3),(3266,386,'永康市',3),(3267,386,'武义县',3),(3268,386,'浦江县',3),(3269,386,'磐安县',3),(3270,387,'莲都区',3),(3271,387,'龙泉市',3),(3272,387,'青田县',3),(3273,387,'缙云县',3),(3274,387,'遂昌县',3),(3275,387,'松阳县',3),(3276,387,'云和县',3),(3277,387,'庆元县',3),(3278,387,'景宁',3),(3279,388,'海曙区',3),(3280,388,'江东区',3),(3281,388,'江北区',3),(3282,388,'镇海区',3),(3283,388,'北仑区',3),(3284,388,'鄞州区',3),(3285,388,'余姚市',3),(3286,388,'慈溪市',3),(3287,388,'奉化市',3),(3288,388,'象山县',3),(3289,388,'宁海县',3),(3290,389,'越城区',3),(3291,389,'上虞市',3),(3292,389,'嵊州市',3),(3293,389,'绍兴县',3),(3294,389,'新昌县',3),(3295,389,'诸暨市',3),(3296,390,'椒江区',3),(3297,390,'黄岩区',3),(3298,390,'路桥区',3),(3299,390,'温岭市',3),(3300,390,'临海市',3),(3301,390,'玉环县',3),(3302,390,'三门县',3),(3303,390,'天台县',3),(3304,390,'仙居县',3),(3305,391,'鹿城区',3),(3306,391,'龙湾区',3),(3307,391,'瓯海区',3),(3308,391,'瑞安市',3),(3309,391,'乐清市',3),(3310,391,'洞头县',3),(3311,391,'永嘉县',3),(3312,391,'平阳县',3),(3313,391,'苍南县',3),(3314,391,'文成县',3),(3315,391,'泰顺县',3),(3316,392,'定海区',3),(3317,392,'普陀区',3),(3318,392,'岱山县',3),(3319,392,'嵊泗县',3),(3320,393,'衢州市',3),(3321,393,'江山市',3),(3322,393,'常山县',3),(3323,393,'开化县',3),(3324,393,'龙游县',3),(3325,394,'合川区',3),(3326,394,'江津区',3),(3327,394,'南川区',3),(3328,394,'永川区',3),(3329,394,'南岸区',3),(3330,394,'渝北区',3),(3331,394,'万盛区',3),(3332,394,'大渡口区',3),(3333,394,'万州区',3),(3334,394,'北碚区',3),(3335,394,'沙坪坝区',3),(3336,394,'巴南区',3),(3337,394,'涪陵区',3),(3338,394,'江北区',3),(3339,394,'九龙坡区',3),(3340,394,'渝中区',3),(3341,394,'黔江开发区',3),(3342,394,'长寿区',3),(3343,394,'双桥区',3),(3344,394,'綦江县',3),(3345,394,'潼南县',3),(3346,394,'铜梁县',3),(3347,394,'大足县',3),(3348,394,'荣昌县',3),(3349,394,'璧山县',3),(3350,394,'垫江县',3),(3351,394,'武隆县',3),(3352,394,'丰都县',3),(3353,394,'城口县',3),(3354,394,'梁平县',3),(3355,394,'开县',3),(3356,394,'巫溪县',3),(3357,394,'巫山县',3),(3358,394,'奉节县',3),(3359,394,'云阳县',3),(3360,394,'忠县',3),(3361,394,'石柱',3),(3362,394,'彭水',3),(3363,394,'酉阳',3),(3364,394,'秀山',3),(3365,395,'沙田区',3),(3366,395,'东区',3),(3367,395,'观塘区',3),(3368,395,'黄大仙区',3),(3369,395,'九龙城区',3),(3370,395,'屯门区',3),(3371,395,'葵青区',3),(3372,395,'元朗区',3),(3373,395,'深水埗区',3),(3374,395,'西贡区',3),(3375,395,'大埔区',3),(3376,395,'湾仔区',3),(3377,395,'油尖旺区',3),(3378,395,'北区',3),(3379,395,'南区',3),(3380,395,'荃湾区',3),(3381,395,'中西区',3),(3382,395,'离岛区',3),(3383,396,'澳门',3),(3384,397,'台北',3),(3385,397,'高雄',3),(3386,397,'基隆',3),(3387,397,'台中',3),(3388,397,'台南',3),(3389,397,'新竹',3),(3390,397,'嘉义',3),(3391,397,'宜兰县',3),(3392,397,'桃园县',3),(3393,397,'苗栗县',3),(3394,397,'彰化县',3),(3395,397,'南投县',3),(3396,397,'云林县',3),(3397,397,'屏东县',3),(3398,397,'台东县',3),(3399,397,'花莲县',3),(3400,397,'澎湖县',3),(3401,3,'合肥',2),(3402,3401,'庐阳区',3),(3403,3401,'瑶海区',3),(3404,3401,'蜀山区',3),(3405,3401,'包河区',3),(3406,3401,'长丰县',3),(3407,3401,'肥东县',3),(3408,3401,'肥西县',3);
/*!40000 ALTER TABLE `cmsx_region` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmsx_resume`
--

DROP TABLE IF EXISTS `cmsx_resume`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmsx_resume` (
  `resume_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `sex` int(1) DEFAULT NULL,
  `nation` varchar(200) DEFAULT NULL,
  `birthday` varchar(200) DEFAULT NULL,
  `birthplace` varchar(1500) DEFAULT NULL,
  `home_address` varchar(1500) DEFAULT NULL,
  `address` varchar(1500) DEFAULT NULL,
  `qq` varchar(200) DEFAULT NULL,
  `wechar` varchar(200) DEFAULT NULL,
  `tel` varchar(200) DEFAULT NULL,
  `degree` varchar(200) DEFAULT NULL,
  `school` varchar(500) DEFAULT NULL,
  `discipline` varchar(500) DEFAULT NULL,
  `graduation_time` varchar(200) DEFAULT NULL,
  `marital` varchar(200) DEFAULT NULL,
  `experience` text,
  `readme` text,
  `add_time` int(11) DEFAULT NULL,
  `mark` varchar(1500) DEFAULT NULL,
  `position_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`resume_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmsx_resume`
--

LOCK TABLES `cmsx_resume` WRITE;
/*!40000 ALTER TABLE `cmsx_resume` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmsx_resume` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmsx_sessions`
--

DROP TABLE IF EXISTS `cmsx_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmsx_sessions` (
  `session_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `session_expires` int(10) unsigned NOT NULL DEFAULT '0',
  `session_data` varchar(4096) DEFAULT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmsx_sessions`
--

LOCK TABLES `cmsx_sessions` WRITE;
/*!40000 ALTER TABLE `cmsx_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmsx_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmsx_shop_category`
--

DROP TABLE IF EXISTS `cmsx_shop_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmsx_shop_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `description` varchar(1500) NOT NULL,
  `is_show` enum('0','1') NOT NULL DEFAULT '1',
  `listorder` int(11) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmsx_shop_category`
--

LOCK TABLES `cmsx_shop_category` WRITE;
/*!40000 ALTER TABLE `cmsx_shop_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmsx_shop_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmsx_shop_config`
--

DROP TABLE IF EXISTS `cmsx_shop_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmsx_shop_config` (
  `config_name` varchar(500) NOT NULL,
  `config_value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmsx_shop_config`
--

LOCK TABLES `cmsx_shop_config` WRITE;
/*!40000 ALTER TABLE `cmsx_shop_config` DISABLE KEYS */;
INSERT INTO `cmsx_shop_config` VALUES ('site_name','易科商城'),('keywords','易科商城'),('description','易科商城'),('support_qq','10000'),('alipay_description','支付宝及时到账服务'),('alipay_account',''),('alipay_key',''),('alipay_partner',''),('point_price','1000'),('alipay_pay_method','2');
/*!40000 ALTER TABLE `cmsx_shop_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmsx_site`
--

DROP TABLE IF EXISTS `cmsx_site`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmsx_site` (
  `site_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int(10) unsigned NOT NULL,
  `name` char(30) DEFAULT '',
  `siteurl` char(255) DEFAULT '',
  `site_dir` varchar(500) NOT NULL,
  `site_title` char(255) DEFAULT '',
  `keywords` char(255) DEFAULT '',
  `description` char(255) DEFAULT '',
  `contacts` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `hotwords` varchar(500) NOT NULL,
  `site_code` varchar(4500) NOT NULL,
  `keyword` char(32) NOT NULL,
  `template` char(50) DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  `pass_time` datetime DEFAULT NULL,
  `qq` char(50) NULL COMMENT '在线qq',
  `telphone` char(15) NULL COMMENT '联系电话',
  `address` text  NULL COMMENT '地址',
  `icp` varchar(50)  NULL COMMENT '备案号',
  `email` varchar(80)  NULL COMMENT '邮箱',
  `fax` varchar(30)  NULL COMMENT '传真',
  `mb_site_code` text  NULL COMMENT '',
  `mb_address` text  NULL COMMENT '',
  `guard` tinyint(1)  NULL DEFAULT '1' COMMENT '防护开关',
  `white_list` text  NULL DEFAULT 'bd_vid,ivk,search' COMMENT '白名单',
  `status` int(1) NOT NULL,
  PRIMARY KEY (`site_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmsx_site`
--

LOCK TABLES `cmsx_site` WRITE;
/*!40000 ALTER TABLE `cmsx_site` DISABLE KEYS */;
INSERT INTO `cmsx_site` VALUES (1,1,'郑州领跑广告有限公司','/','hnek/','郑州领跑广告有限公司,品牌设计,VI,标志,logo设计,标识,画册设计,包装设计','品牌设计，logo设计，郑州画册设计，领跑广告，包装设计公司，印刷制作，商标设计，商标注册，VI设计','郑州领跑广告有限公司','','0371-65861326','品牌设计，logo设计，郑州画册设计，领跑广告，包装设计公司，印刷制作，商标设计，商标注册，VI设计','<script type=\"text/javascript\">var cnzz_protocol = ((\"https:\" == document.location.protocol) ? \" https://\" : \" http://\");document.write(unescape(\"%3Cspan id=''cnzz_stat_icon_1274745464''%3E%3C/span%3E%3Cscript src=''\" + cnzz_protocol + \"s19.cnzz.com/z_stat.php%3Fid%3D1274745464%26show%3Dpic'' type=''text/javascript''%3E%3C/script%3E\"));</script>\r\n<script type=\"text/javascript\">var cnzz_protocol = ((\"https:\" == document.location.protocol) ? \" https://\" : \" http://\");document.write(unescape(\"%3Cspan id=''cnzz_stat_icon_1275625160''%3E%3C/span%3E%3Cscript src=''\" + cnzz_protocol + \"s5.cnzz.com/z_stat.php%3Fid%3D1275625160%26show%3Dpic'' type=''text/javascript''%3E%3C/script%3E\"));</script>','','default','2017-03-29 00:00:00','2018-04-28 00:00:00',1);
/*!40000 ALTER TABLE `cmsx_site` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmsx_wechar_config`
--

DROP TABLE IF EXISTS `cmsx_wechar_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmsx_wechar_config` (
  `config_id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(200) DEFAULT NULL,
  `aeskey` varchar(200) DEFAULT NULL,
  `appid` varchar(200) DEFAULT NULL,
  `appsecret` varchar(200) DEFAULT NULL,
  `access_token` varchar(200) DEFAULT NULL,
  `expires_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`config_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmsx_wechar_config`
--

LOCK TABLES `cmsx_wechar_config` WRITE;
/*!40000 ALTER TABLE `cmsx_wechar_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmsx_wechar_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmsx_wechar_material`
--

DROP TABLE IF EXISTS `cmsx_wechar_material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmsx_wechar_material` (
  `material_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(1) DEFAULT NULL,
  `title` varchar(500) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `description` varchar(1500) DEFAULT NULL,
  `content` text,
  `link` varchar(200) DEFAULT NULL,
  `keyword1` varchar(200) DEFAULT NULL,
  `keyword2` varchar(200) DEFAULT NULL,
  `keyword` varchar(200) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `listorder` int(11) DEFAULT NULL,
  `subscribe` int(1) DEFAULT NULL,
  `default` int(1) DEFAULT NULL,
  PRIMARY KEY (`material_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmsx_wechar_material`
--

LOCK TABLES `cmsx_wechar_material` WRITE;
/*!40000 ALTER TABLE `cmsx_wechar_material` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmsx_wechar_material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmsx_wechar_member`
--

DROP TABLE IF EXISTS `cmsx_wechar_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmsx_wechar_member` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(500) DEFAULT NULL,
  `nickname` varchar(500) DEFAULT NULL,
  `sex` int(1) DEFAULT NULL,
  `city` varchar(200) DEFAULT NULL,
  `country` varchar(200) DEFAULT NULL,
  `province` varchar(200) DEFAULT NULL,
  `language` varchar(200) DEFAULT NULL,
  `headimgurl` varchar(200) DEFAULT NULL,
  `subscribe_time` int(11) DEFAULT NULL,
  `subscribe` int(1) DEFAULT NULL,
  `remark` varchar(500) DEFAULT NULL,
  `groupid` int(11) DEFAULT NULL,
  `tagid_list` varchar(500) DEFAULT NULL,
  `unionid` varchar(200) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `qrcode_id` int(11) NOT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmsx_wechar_member`
--

LOCK TABLES `cmsx_wechar_member` WRITE;
/*!40000 ALTER TABLE `cmsx_wechar_member` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmsx_wechar_member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmsx_wechar_menu`
--

DROP TABLE IF EXISTS `cmsx_wechar_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmsx_wechar_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(500) DEFAULT NULL,
  `event` varchar(500) DEFAULT NULL,
  `data_type` int(1) DEFAULT NULL,
  `data` varchar(500) DEFAULT NULL,
  `listorder` int(11) DEFAULT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmsx_wechar_menu`
--

LOCK TABLES `cmsx_wechar_menu` WRITE;
/*!40000 ALTER TABLE `cmsx_wechar_menu` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmsx_wechar_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmsx_wechar_message`
--

DROP TABLE IF EXISTS `cmsx_wechar_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmsx_wechar_message` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(500) DEFAULT NULL,
  `type` varchar(200) DEFAULT NULL,
  `data` text,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmsx_wechar_message`
--

LOCK TABLES `cmsx_wechar_message` WRITE;
/*!40000 ALTER TABLE `cmsx_wechar_message` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmsx_wechar_message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmsx_wechar_message_attachment`
--

DROP TABLE IF EXISTS `cmsx_wechar_message_attachment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmsx_wechar_message_attachment` (
  `attachment_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_id` int(11) DEFAULT NULL,
  `media_id` varchar(500) DEFAULT NULL,
  `url` varchar(500) DEFAULT NULL,
  `type` varchar(200) DEFAULT NULL,
  `size` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`attachment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmsx_wechar_message_attachment`
--

LOCK TABLES `cmsx_wechar_message_attachment` WRITE;
/*!40000 ALTER TABLE `cmsx_wechar_message_attachment` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmsx_wechar_message_attachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmsx_wechar_qrcode`
--

DROP TABLE IF EXISTS `cmsx_wechar_qrcode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmsx_wechar_qrcode` (
  `qrcode_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `ticket` varchar(1500) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`qrcode_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmsx_wechar_qrcode`
--

LOCK TABLES `cmsx_wechar_qrcode` WRITE;
/*!40000 ALTER TABLE `cmsx_wechar_qrcode` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmsx_wechar_qrcode` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'qdm170255639_db'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-01-31 16:26:46
