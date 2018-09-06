CREATE DATABASE  IF NOT EXISTS `incloud_chmeier` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `incloud_chmeier`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win64 (x86_64)
--
-- Host: localhost    Database: incloud_chmeier
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.33-MariaDB

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
-- Table structure for table `story`
--

DROP TABLE IF EXISTS `story`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `story` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(80) NOT NULL,
  `book_time` time NOT NULL,
  `submit_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `story`
--

LOCK TABLES `story` WRITE;
/*!40000 ALTER TABLE `story` DISABLE KEYS */;
INSERT INTO `story` VALUES (1,'First timer test','01:21:19','2018-09-05 17:27:19'),(2,'First timer test','01:21:19','2018-09-05 17:28:46'),(3,'Third test, checking regex','06:56:56','2018-09-05 17:34:12'),(4,'filler task','05:55:55','2018-09-05 20:41:20'),(5,'Getting coffee for more task tracking','01:23:45','2018-09-05 20:41:53'),(6,'Apocalypse prevention','06:06:06','2018-09-05 20:42:14'),(7,'New distinct task ideas','00:00:05','2018-09-05 20:42:40'),(8,'Customer query from 1 minute before the shift ends','00:42:42','2018-09-05 20:43:39'),(9,'Defuse an elf strike','00:12:25','2018-09-05 20:44:23'),(10,'Fresh start','00:01:31','2018-09-05 20:44:47'),(11,'Task that will reach a third page unfiltered','00:03:33','2018-09-05 20:45:16'),(12,'Checking template JS adjustments','00:00:42','2018-09-05 23:39:58'),(13,'Date test entry','00:04:30','2018-09-06 06:01:12');
/*!40000 ALTER TABLE `story` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-09-06  6:50:34
