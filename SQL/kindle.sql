-- MySQL dump 10.13  Distrib 5.5.40, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: KINDLE
-- ------------------------------------------------------
-- Server version	5.5.40-0ubuntu0.14.04.1

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
-- Table structure for table `Department`
--

DROP TABLE IF EXISTS `Department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Department` (
  `Dept_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Dept_Name` varchar(40) NOT NULL,
  `Manager` int(11) DEFAULT NULL,
  PRIMARY KEY (`Dept_ID`),
  UNIQUE KEY `Dept_Name` (`Dept_Name`),
  KEY `Manager` (`Manager`),
  CONSTRAINT `Department_ibfk_1` FOREIGN KEY (`Manager`) REFERENCES `Employee` (`Emp_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Department`
--

LOCK TABLES `Department` WRITE;
/*!40000 ALTER TABLE `Department` DISABLE KEYS */;
INSERT INTO `Department` VALUES (2,'Sales',NULL),(3,'Products',NULL),(4,'Personnel',NULL),(5,'Administration',NULL);
/*!40000 ALTER TABLE `Department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Employee`
--

DROP TABLE IF EXISTS `Employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Employee` (
  `Emp_ID` int(11) NOT NULL,
  `Password` varchar(30) NOT NULL,
  `Sex` char(1) NOT NULL DEFAULT 'M',
  `Dob` date NOT NULL,
  `Maritial_Status` varchar(13) NOT NULL,
  `Department` varchar(40) DEFAULT NULL,
  `Account_No` bigint(20) DEFAULT NULL,
  `IFSC` char(11) NOT NULL,
  `Designation` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`Emp_ID`),
  UNIQUE KEY `Account_No` (`Account_No`),
  KEY `Department` (`Department`),
  CONSTRAINT `Employee_ibfk_2` FOREIGN KEY (`Emp_ID`) REFERENCES `Person` (`Person_Id`),
  CONSTRAINT `Employee_ibfk_3` FOREIGN KEY (`Department`) REFERENCES `Department` (`Dept_Name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Employee`
--

LOCK TABLES `Employee` WRITE;
/*!40000 ALTER TABLE `Employee` DISABLE KEYS */;
INSERT INTO `Employee` VALUES (24,'humdard','m','1987-12-13','y','Products',1234567890,'abcd1032456','Head'),(36,'aaaaaaa','m','2014-11-09','y','Administration',10100102020,'a102001','Head'),(37,'1234567','m','1987-11-09','y','Personnel',10100102038,'a102001','Head');
/*!40000 ALTER TABLE `Employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Kindle`
--

DROP TABLE IF EXISTS `Kindle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Kindle` (
  `Asin` varchar(13) NOT NULL DEFAULT '',
  `name` varchar(30) NOT NULL,
  `stock` int(11) NOT NULL,
  `weight` float NOT NULL,
  `dimension` varchar(10) NOT NULL,
  `resolution` varchar(30) NOT NULL,
  `battery` varchar(30) NOT NULL,
  `storage` varchar(10) NOT NULL,
  `wifi` varchar(30) NOT NULL,
  `4G` char(1) NOT NULL,
  `camera` varchar(10) NOT NULL,
  `customer_support` varchar(50) NOT NULL,
  PRIMARY KEY (`Asin`),
  UNIQUE KEY `name` (`name`),
  CONSTRAINT `Kindle_ibfk_1` FOREIGN KEY (`Asin`) REFERENCES `Product` (`Asin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Kindle`
--

LOCK TABLES `Kindle` WRITE;
/*!40000 ALTER TABLE `Kindle` DISABLE KEYS */;
INSERT INTO `Kindle` VALUES ('12234aaacd','Rokc',1000,10,'ajaj','1jaja','19','jaj','jsj','Y','sjs','sjsj'),('12234adacd','Rok',1000,10,'ajaj','1jaja','19','jaj','jsj','Y','sjs','sjsj'),('a12345678s','aa',0,0,'a','a','a','a','a','Y','a','a'),('aa12345890','rock',1000,100,'11','11','11','11','11','Y','11','112');
/*!40000 ALTER TABLE `Kindle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Person`
--

DROP TABLE IF EXISTS `Person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Person` (
  `Person_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Email` varchar(25) NOT NULL,
  `Contact_No` bigint(20) DEFAULT NULL,
  `First_Name` varchar(20) NOT NULL,
  `Middle_Name` varchar(20) DEFAULT NULL,
  `Last_Name` varchar(20) NOT NULL,
  `House_No` varchar(10) NOT NULL,
  `street` varchar(10) NOT NULL,
  `city` varchar(40) NOT NULL,
  `state` varchar(40) NOT NULL,
  `country` varchar(40) NOT NULL,
  `pin` int(11) NOT NULL,
  PRIMARY KEY (`Person_Id`),
  UNIQUE KEY `Person_Id` (`Person_Id`),
  UNIQUE KEY `Email` (`Email`),
  UNIQUE KEY `Contact_No` (`Contact_No`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Person`
--

LOCK TABLES `Person` WRITE;
/*!40000 ALTER TABLE `Person` DISABLE KEYS */;
INSERT INTO `Person` VALUES (2,'aa@yahoo.com',1234567890,'Noor','','Singh','11','aha','aha','ahah','hshs',123456),(3,'noorpratap@yahoo.com',9888643335,'Noor','Pratap','Singh','806','Sector-65','Mohali','Punjab','India',160062),(24,'amitkumar@yahoo.com',8120345678,'Amit','','Kumar','123','phase 3','Hyderabad','Telangana','India',1672777),(26,'rohit.roy@yaho.com',8128288098,'Rohit','','Roy','11','11','Mysore','Karn','India',600031),(28,'luv.ag@yahoo.com',6666666666,'Luv','','Agrawal','66','dalal','jaipur','Raj','Indi',7171771),(29,'jhd@mail.com',1009999999,'hjqwhedkjq','djkhsjdk','dkjash','10','xhjgsd','hdiauhas','dhak','dhak',203900),(30,'jd@gmail.com',90909090,'jcksh','hjfkwh','hkjfh','89','jcskh','hkjhk','hkj','hk',898989),(31,'h@jks.com',791739279,'djakjs','kjfjh','hf','hkda','ha','hk','hi','hk',989899),(32,'hhq@yaho.com',1818181818,'aahah','ahaha','ahaha','nsjsj','sjsj','sjsj','jsjs','sjsj',122929),(33,'hk@hk.com',9989988897,'hj','hk','hk','hksh','hkhk','hk','hk','hk',909090),(34,'rohit.roy@yahoo.com',9882822828,'Rohit','','Roy','717','Make','Mysore','Karn','India',162626),(35,'rh@res.com',8181818188,'Rohit','','Roy','17717','1717','Myso','Ka','Id',188181),(36,'aa@yaho.com',9888011828,'Adam','','Ever','801','ahah','Mys','AP','India',172727),(37,'per@yaho.com',8717172727,'Rahul','','Khanna','801','ahah','Mys','AP','India',172727);
/*!40000 ALTER TABLE `Person` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Product`
--

DROP TABLE IF EXISTS `Product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Product` (
  `Asin` varchar(13) NOT NULL DEFAULT '',
  `Price` float NOT NULL,
  `Description` text,
  `Rank` int(11) DEFAULT NULL,
  `Image` varchar(100) DEFAULT NULL,
  `Sold_By` varchar(20) DEFAULT NULL,
  `Rating` float DEFAULT NULL,
  PRIMARY KEY (`Asin`),
  UNIQUE KEY `Image` (`Image`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Product`
--

LOCK TABLES `Product` WRITE;
/*!40000 ALTER TABLE `Product` DISABLE KEYS */;
INSERT INTO `Product` VALUES ('12234aaacd',100,'aa',NULL,'images/10744758_1552','Dhrumil Patel',3),('12234adacd',100,'aa',NULL,'images/10736053_1552','Dhrumil Patel',NULL),('a12345678s',0,'aa',NULL,'images/images.jpeg','a',2),('aa12345890',100,'Very flexible',NULL,'images/10744927_1552','Amazon',4.19922),('B00977MRTE',3.72,'Thus begins Khushwant Singh’s vast, erotic, irrelevant magnum opus on the city of Delhi.The principal narrator of the saga, which extends over six hundred years, is a bawdy, ageing reprobate who loves Delhi as much as he does the hijda whore Bhagmati—half man, half woman with sexual inventiveness and energy of both the sexes.Travelling through time, space and history to ‘discover’ his beloved city, the narrator meets a myriad of people—poets and princes, saints and sultans, temptresses and traitors, emperors and eunuchs—who have shaped and endowed Delhi with its very special mystique… And as we accompany the narrator on his epic journey we find the city of emperors transformed and immortalized in our minds for ever. ',NULL,'images/delhi.jpg','amazon',3),('B00B1AHNVC',3.12,'Florence: Harvard symbologist Robert Langdon awakes in a hospital bed with no recollection of where he is or how he got there. Nor can he explain the origin of the macabre object that is found hidden in his belongings.',NULL,'images/inferno.jpg','amazon',NULL),('B00FH28N6E',1.38,'It is the summer of 1947. But Partition does not mean much to the Sikhs and Muslims of Mano Majra, a village on the border of India and Pakistan. Then, a local money-lender is murdered, and suspicion falls upon Juggut Singh, the village gangster who is in love with a Muslim girl.When a train arrives, carrying the bodies of dead Sikhs, the village is transformed into a battlefield, and neither the magistrate nor the police are able to stem the rising tide of violence. ',NULL,'images/traintopak.jpg','amazon',NULL);
/*!40000 ALTER TABLE `Product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Review`
--

DROP TABLE IF EXISTS `Review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Review` (
  `User_ID` int(11) NOT NULL,
  `Date` datetime DEFAULT NULL,
  `Title` varchar(30) NOT NULL,
  `Details` text NOT NULL,
  `Rating` int(11) DEFAULT NULL,
  `Asin` varchar(12) NOT NULL,
  KEY `User_ID` (`User_ID`),
  KEY `Asin` (`Asin`),
  CONSTRAINT `Review_ibfk_3` FOREIGN KEY (`Asin`) REFERENCES `Product` (`Asin`),
  CONSTRAINT `Review_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `Users` (`User_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Review`
--

LOCK TABLES `Review` WRITE;
/*!40000 ALTER TABLE `Review` DISABLE KEYS */;
INSERT INTO `Review` VALUES (2,'2014-11-08 23:53:34','aa','a',1,'12234aaacd'),(2,'2014-11-08 23:56:47','ahah','aaaa',3,'12234aaacd'),(2,'2014-11-09 00:08:50','aa','aaaa',3,'12234aaacd'),(2,'2014-11-09 00:17:07','ahah','sshsh',2,'12234aaacd'),(2,'2014-11-09 00:18:40','aha','aaa',3,'12234aaacd'),(2,'2014-11-09 00:25:31','dadasda','sadasaasd',5,'12234aaacd'),(2,'2014-11-09 00:29:09','dasd','sadasasda',5,'12234aaacd'),(2,'2014-11-09 00:32:29','aa','aaaa',2,'12234aaacd'),(2,'2014-11-09 00:34:11','qq','aa',3,'12234aaacd'),(2,'2014-11-09 00:35:38','aha','hzhzh',3,'12234aaacd'),(2,'2014-11-09 00:37:19','hum ','ajaja',2,'a12345678s'),(2,'2014-11-09 00:40:30','hum ','ajaja',2,'a12345678s'),(2,'2014-11-09 00:45:02','aa','aa',3,'B00977MRTE');
/*!40000 ALTER TABLE `Review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Sales`
--

DROP TABLE IF EXISTS `Sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Sales` (
  `Purchase_ID` int(11) NOT NULL,
  `Asin` varchar(13) DEFAULT NULL,
  `User_ID` int(11) NOT NULL,
  `Date_Time` datetime NOT NULL,
  `Amount` float DEFAULT NULL,
  `Mode` varchar(10) NOT NULL,
  `Bank` varchar(10) NOT NULL,
  `Transaction_ID` bigint(20) NOT NULL,
  PRIMARY KEY (`Purchase_ID`),
  UNIQUE KEY `Transaction_ID` (`Transaction_ID`),
  KEY `us` (`User_ID`),
  KEY `asin` (`Asin`),
  CONSTRAINT `Sales_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `Users` (`User_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Sales`
--

LOCK TABLES `Sales` WRITE;
/*!40000 ALTER TABLE `Sales` DISABLE KEYS */;
/*!40000 ALTER TABLE `Sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `User_Id` int(11) NOT NULL,
  `User_Name` varchar(30) NOT NULL,
  `Password` varchar(30) NOT NULL,
  `DateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`User_Id`),
  UNIQUE KEY `User_Name` (`User_Name`),
  CONSTRAINT `Users_ibfk_1` FOREIGN KEY (`User_Id`) REFERENCES `Person` (`Person_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES (2,'NoorPratap','aaaaaaa','2014-11-07 21:07:55'),(3,'Noor Pratap','1234567','2014-11-03 20:50:06'),(26,'RohitRoy','1234567','2014-11-05 19:54:03'),(28,'LuvAggrawal','1234567','2014-11-05 20:03:05'),(29,'ffrkjdh','123123123','2014-11-05 20:04:12'),(30,'kdfjkds','123123123','2014-11-05 20:06:02'),(31,'jsdka','123123123','2014-11-05 20:20:13'),(32,'hahhhh','1234567','2014-11-05 20:24:47'),(33,'dhkah','123123123','2014-11-05 20:29:41'),(35,'Rojorr','1234567','2014-11-05 20:35:55');
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `books` (
  `Asin` varchar(11) NOT NULL,
  `title` varchar(40) NOT NULL,
  `publisher` varchar(40) NOT NULL,
  `PubDate` date NOT NULL,
  `Filesize` int(11) NOT NULL,
  `language` varchar(30) NOT NULL,
  `genre` varchar(30) NOT NULL,
  `lending` varchar(3) NOT NULL,
  `length` int(11) DEFAULT NULL,
  `audio` char(3) NOT NULL DEFAULT 'No',
  `textspeech` char(3) DEFAULT NULL,
  `author` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`Asin`),
  CONSTRAINT `books_ibfk_1` FOREIGN KEY (`Asin`) REFERENCES `Product` (`Asin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `books`
--

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
INSERT INTO `books` VALUES ('B00977MRTE','Delhi: A Novel','Penguin','2012-09-01',616,'English','fiction','No',405,'No','Yes','Khushwant Singh'),('B00B1AHNVC','Inferno','Transworld','2013-03-14',2137,'English','fiction','No',626,'No','Yes','Dan Brown'),('B00FH28N6E','Train to Pakistan','Penguin','2009-02-10',514,'English','fiction','No',198,'No','Yes','Khushwant Singh');
/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-11-10 16:01:09
