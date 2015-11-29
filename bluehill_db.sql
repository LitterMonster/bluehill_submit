-- MySQL dump 10.13  Distrib 5.6.27, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: bluehill_db
-- ------------------------------------------------------
-- Server version	5.6.27-0ubuntu1

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
-- Table structure for table `tblAttendance`
--

DROP TABLE IF EXISTS `tblAttendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblAttendance` (
  `AttendID` int(11) NOT NULL AUTO_INCREMENT,
  `EmployeeID` int(11) NOT NULL,
  `BreachTime` datetime DEFAULT NULL,
  `RecorderID` int(11) DEFAULT NULL,
  `Type` varchar(4) NOT NULL,
  `AskReview` tinyint(4) DEFAULT NULL,
  `Date` datetime NOT NULL,
  PRIMARY KEY (`AttendID`),
  KEY `EmployeeID` (`EmployeeID`),
  KEY `RecorderID` (`RecorderID`),
  CONSTRAINT `tblAttendance_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `tblEmployee` (`EmployeeID`),
  CONSTRAINT `tblAttendance_ibfk_2` FOREIGN KEY (`RecorderID`) REFERENCES `tblEmployee` (`EmployeeID`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblAttendance`
--

LOCK TABLES `tblAttendance` WRITE;
/*!40000 ALTER TABLE `tblAttendance` DISABLE KEYS */;
INSERT INTO `tblAttendance` VALUES (1,4,'2007-09-18 00:00:00',1,'迟到',1,'2007-09-18 00:00:00'),(2,4,'2007-09-16 00:00:00',2,'早退',1,'2007-09-16 00:00:00'),(3,3,'2007-09-18 00:00:00',5,'缺勤',1,'2007-09-18 00:00:00'),(4,4,'2007-09-13 00:00:00',6,'缺勤',1,'2007-09-13 00:00:00'),(5,1,'2007-09-13 00:00:00',10,'缺勤',1,'2007-09-15 00:00:00'),(6,2,'2007-09-15 00:00:00',3,'迟到',0,'2007-09-15 00:00:00'),(7,3,'2007-09-13 00:00:00',4,'缺勤',1,'2007-09-18 00:00:00'),(8,4,'2007-09-12 00:00:00',1,'迟到',1,'2007-09-12 00:00:00'),(9,5,'2007-09-14 00:00:00',1,'早退',1,'2007-09-14 00:00:00'),(10,6,'2007-09-11 00:00:00',1,'缺勤',0,'2007-09-11 00:00:00'),(11,2,'2007-09-13 00:00:00',1,'早退',0,'2007-09-13 00:00:00'),(12,2,'2007-09-15 00:00:00',1,'早退',1,'2007-09-15 00:00:00'),(13,3,'2007-09-15 00:00:00',1,'迟到',0,'2007-09-15 00:00:00'),(14,5,'2007-09-11 00:00:00',1,'缺勤',1,'2007-09-11 00:00:00'),(15,7,'2007-09-17 00:00:00',1,'缺勤',0,'2007-09-17 00:00:00'),(16,8,'2007-09-17 00:00:00',1,'迟到',0,'2007-09-17 00:00:00'),(17,9,'2007-09-17 00:00:00',1,'早退',0,'2007-09-29 00:00:00'),(19,11,'2007-09-17 00:00:00',1,'早退',0,'2007-09-29 00:00:00');
/*!40000 ALTER TABLE `tblAttendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblConfig`
--

DROP TABLE IF EXISTS `tblConfig`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblConfig` (
  `ConfigID` int(11) NOT NULL AUTO_INCREMENT,
  `Type` char(10) DEFAULT NULL,
  `Name` char(50) NOT NULL,
  `Data` char(50) DEFAULT NULL,
  PRIMARY KEY (`ConfigID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblConfig`
--

LOCK TABLES `tblConfig` WRITE;
/*!40000 ALTER TABLE `tblConfig` DISABLE KEYS */;
INSERT INTO `tblConfig` VALUES (1,'Policy','NormalLeaveDays','5');
/*!40000 ALTER TABLE `tblConfig` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblDepartment`
--

DROP TABLE IF EXISTS `tblDepartment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblDepartment` (
  `DeptID` int(11) NOT NULL AUTO_INCREMENT,
  `DeptName` char(10) DEFAULT NULL,
  `Desciption` char(50) DEFAULT NULL,
  `ManagerID` int(11) DEFAULT NULL,
  PRIMARY KEY (`DeptID`),
  KEY `ManagerID` (`ManagerID`),
  CONSTRAINT `tblDepartment_ibfk_1` FOREIGN KEY (`ManagerID`) REFERENCES `tblEmployee` (`EmployeeID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblDepartment`
--

LOCK TABLES `tblDepartment` WRITE;
/*!40000 ALTER TABLE `tblDepartment` DISABLE KEYS */;
INSERT INTO `tblDepartment` VALUES (1,'人事部','管理公司员工各项信息',1),(2,'财务部','管理公司财务',2),(3,'行政部','管理公司行政',3),(4,'销售部','销售公司产品',4),(5,'研发部','研发公司产品',5),(6,'信息部','处理公司公关问题',6);
/*!40000 ALTER TABLE `tblDepartment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblEmployee`
--

DROP TABLE IF EXISTS `tblEmployee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblEmployee` (
  `EmployeeID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Sex` char(2) NOT NULL,
  `LoginName` varchar(20) NOT NULL,
  `Password` varchar(20) DEFAULT NULL,
  `Email` varchar(50) NOT NULL,
  `DeptID` int(11) DEFAULT NULL,
  `BasicSalary` int(11) DEFAULT NULL,
  `Title` varchar(50) DEFAULT NULL,
  `Telephone` varchar(50) DEFAULT NULL,
  `OnboardDate` datetime NOT NULL,
  `SelfIntro` varchar(200) DEFAULT NULL,
  `VacationRemain` int(11) DEFAULT NULL,
  `EmployeeLevel` int(11) DEFAULT NULL,
  `PhotoImage` blob,
  PRIMARY KEY (`EmployeeID`),
  UNIQUE KEY `Name` (`Name`),
  UNIQUE KEY `LoginName` (`LoginName`),
  KEY `DeptID` (`DeptID`),
  CONSTRAINT `tblEmployee_ibfk_1` FOREIGN KEY (`DeptID`) REFERENCES `tblDepartment` (`DeptID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblEmployee`
--

LOCK TABLES `tblEmployee` WRITE;
/*!40000 ALTER TABLE `tblEmployee` DISABLE KEYS */;
INSERT INTO `tblEmployee` VALUES (1,'曹操','男','admin','1234567','hangwang@bluehill.com',1,6000,'President&CEO','8888','2002-07-15 00:00:00','我是曹操！！！！',43,1,NULL),(2,'刘备','男','gwshangsdf','1234567','gwshang@bluehill.com',2,2000,'FinanceManager','85111111','2002-05-22 00:00:00',NULL,77,1,NULL),(3,'诸葛亮','男','tchen','1234567','tchen@bluehill.com',3,3000,'Accountant','8533','2003-01-27 00:00:00',NULL,66,1,NULL),(4,'孙权','男','ychen','1234567','ychen@bluehill.com',4,1000,'Accountant','8515','2002-07-10 00:00:00',NULL,47,1,NULL),(5,'张飞','男','yqi','1234567','yqi@bluehill.com',5,1000,'啊啊啊','8517','2002-08-26 00:00:00',NULL,57,1,NULL),(6,'赵子龙','女','jcao','1234567','jcao@bluehill.com',6,1000,'Receptionist','8505','2002-10-08 00:00:00',NULL,47,1,''),(7,'黄忠','男','lsa','1234567','lsa@bluehill.com',6,1500,'HR Assistant','8518','2002-12-02 00:00:00',NULL,37,1,NULL),(8,'鲁肃','男','mchen','1234567','mchen@bluehill.com',5,1000,'Accountant','8547 ','2003-05-06 00:00:00',NULL,80,1,NULL),(9,'小乔','女','tyu','1234567','tyu@bluehill.com',1,500,'Senior CoursewareDeveloper','8478','2003-05-08 00:00:00',NULL,34,1222,''),(10,'孙夫人','女','jhe','1234567','jhe@bluehill.com',2,500,'Senior CoursewareDeveloper','8456','2003-06-02 00:00:00',NULL,43,NULL,NULL),(11,'姜维','男','qjiang','1234567','qjiang@bluehill.com',3,500,'LocalizationManager','8961','2003-04-17 00:00:00',NULL,46,1,NULL),(12,'周瑜','男','22tzhang','1234567','tzhang@bluehill.com',4,1233,'Director ','8900','2003-05-16 00:00:00',NULL,53,1,NULL),(13,'夏侯渊','男','cwu','1234567','cwu@bluehill.com',5,4000,'HR Manager','8516','2002-06-01 00:00:00','gfh',41,1,NULL),(16,'司马昭','男','mzhang','1234567','mzhang@bluehill.com',2,1000,'Employee','1111111123','2003-10-27 00:00:00',NULL,63,NULL,NULL),(17,'司马师','男','jwang','1234567','jwang@bluehill.com',3,1500,'Employee','8865','2003-10-27 00:00:00',NULL,53,1,'');
/*!40000 ALTER TABLE `tblEmployee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblHoliday`
--

DROP TABLE IF EXISTS `tblHoliday`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblHoliday` (
  `HolidayID` int(11) NOT NULL AUTO_INCREMENT,
  `HolidayDate` datetime NOT NULL,
  `HolidayName` varchar(50) NOT NULL,
  `IsNationalHoliday` tinyint(1) NOT NULL,
  PRIMARY KEY (`HolidayID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblHoliday`
--

LOCK TABLES `tblHoliday` WRITE;
/*!40000 ALTER TABLE `tblHoliday` DISABLE KEYS */;
INSERT INTO `tblHoliday` VALUES (1,'2007-10-01 00:00:00','国庆节',1),(2,'2007-05-01 00:00:00','五一劳动节',0),(3,'2007-10-03 00:00:00','建军节',0),(4,'2007-05-04 00:00:00','青年节',0),(5,'2007-06-01 00:00:00','儿童节',1),(6,'2007-04-05 00:00:00','清明节',1);
/*!40000 ALTER TABLE `tblHoliday` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblLeave`
--

DROP TABLE IF EXISTS `tblLeave`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblLeave` (
  `LeaveID` int(11) NOT NULL AUTO_INCREMENT,
  `EmployeeID` int(11) NOT NULL,
  `SubmitTime` datetime NOT NULL,
  `StartTime` datetime NOT NULL,
  `EndTime` datetime NOT NULL,
  `Reason` varchar(100) DEFAULT NULL,
  `TypeID` int(11) DEFAULT NULL,
  `Hours` float NOT NULL,
  `Status` varchar(20) DEFAULT NULL,
  `ApproverID` int(11) DEFAULT NULL,
  `DenyReason` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`LeaveID`),
  KEY `EmployeeID` (`EmployeeID`),
  KEY `ApproverID` (`ApproverID`),
  CONSTRAINT `tblLeave_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `tblEmployee` (`EmployeeID`),
  CONSTRAINT `tblLeave_ibfk_2` FOREIGN KEY (`ApproverID`) REFERENCES `tblEmployee` (`EmployeeID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblLeave`
--

LOCK TABLES `tblLeave` WRITE;
/*!40000 ALTER TABLE `tblLeave` DISABLE KEYS */;
INSERT INTO `tblLeave` VALUES (1,4,'2007-09-15 00:00:00','2007-09-15 00:00:00','2007-09-16 00:00:00','有事',NULL,8,'已取消',1,NULL),(2,3,'2007-09-15 00:00:00','2007-09-16 00:00:00','2007-09-17 00:00:00','有事',NULL,16,'已否决',2,NULL),(3,2,'2007-09-15 00:00:00','2007-08-16 00:00:00','2007-08-18 00:00:00','有事',NULL,24,'已批准',3,NULL),(4,1,'2007-09-15 00:00:00','2007-09-16 00:00:00','2007-09-17 00:00:00','有事',NULL,8,'已提交',1,NULL),(5,5,'2007-09-15 00:00:00','2007-09-16 00:00:00','2007-09-17 00:00:00','有事',NULL,8,'已否决',2,NULL),(6,6,'2007-09-15 00:00:00','2007-09-16 00:00:00','2007-09-17 00:00:00','有事',NULL,8,'已批准',1,NULL),(7,7,'2007-09-15 00:00:00','2007-09-15 00:00:00','2007-09-16 00:00:00','有事',NULL,8,'已取消',1,NULL),(8,8,'2007-09-15 00:00:00','2007-09-16 00:00:00','2007-09-17 00:00:00','有事',NULL,16,'已否决',2,NULL),(9,9,'2007-09-15 00:00:00','2007-08-16 00:00:00','2007-08-18 00:00:00','有事',NULL,24,'已批准',3,NULL),(10,10,'2007-09-15 00:00:00','2007-09-16 00:00:00','2007-09-17 00:00:00','有事',NULL,8,'已提交',1,NULL),(11,11,'2007-09-15 00:00:00','2007-09-16 00:00:00','2007-09-17 00:00:00','有事',NULL,8,'已否决',2,NULL),(12,12,'2007-09-15 00:00:00','2007-09-16 00:00:00','2007-09-17 00:00:00','有事',NULL,8,'已批准',1,NULL),(13,13,'2007-09-15 00:00:00','2007-09-15 00:00:00','2007-09-16 00:00:00','有事',NULL,8,'已取消',1,NULL),(16,16,'2007-09-15 00:00:00','2007-09-16 00:00:00','2007-09-17 00:00:00','有事',NULL,8,'已提交',1,NULL),(17,17,'2007-09-15 00:00:00','2007-09-16 00:00:00','2007-09-17 00:00:00','有事',NULL,8,'已否决',2,NULL);
/*!40000 ALTER TABLE `tblLeave` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblOverTime`
--

DROP TABLE IF EXISTS `tblOverTime`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblOverTime` (
  `OvertimeID` int(11) NOT NULL AUTO_INCREMENT,
  `EmployeeID` int(11) NOT NULL,
  `ApproverID` int(11) DEFAULT NULL,
  `SubmitTime` datetime NOT NULL,
  `StartTime` datetime NOT NULL,
  `EndTime` datetime NOT NULL,
  `Reason` varchar(100) NOT NULL,
  `Status` varchar(10) NOT NULL,
  `Type` tinyint(4) DEFAULT NULL,
  `Denyreason` varchar(100) DEFAULT NULL,
  `Hours` int(11) DEFAULT NULL,
  PRIMARY KEY (`OvertimeID`),
  KEY `Type` (`Type`),
  KEY `EmployeeID` (`EmployeeID`),
  KEY `ApproverID` (`ApproverID`),
  CONSTRAINT `tblOverTime_ibfk_1` FOREIGN KEY (`Type`) REFERENCES `tblOverTimeType` (`Type`),
  CONSTRAINT `tblOverTime_ibfk_2` FOREIGN KEY (`EmployeeID`) REFERENCES `tblEmployee` (`EmployeeID`),
  CONSTRAINT `tblOverTime_ibfk_3` FOREIGN KEY (`ApproverID`) REFERENCES `tblEmployee` (`EmployeeID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblOverTime`
--

LOCK TABLES `tblOverTime` WRITE;
/*!40000 ALTER TABLE `tblOverTime` DISABLE KEYS */;
INSERT INTO `tblOverTime` VALUES (1,2,1,'2007-09-16 00:00:00','2007-09-19 00:00:00','2007-09-19 00:00:00','有事','已否决',1,'该时间段不能加班',NULL),(2,3,1,'2007-09-16 00:00:00','2007-09-19 00:00:00','2007-09-19 00:00:00','评比','已批准',1,'评比',4),(3,4,1,'2007-09-16 00:00:00','2007-09-19 00:00:00','2007-09-19 00:00:00','有事','已否决',1,'要休息',NULL),(4,5,1,'2007-09-16 00:00:00','2007-09-19 00:00:00','2007-09-19 00:00:00','有事','已否决',1,'放假了',NULL),(5,6,1,'2007-09-16 00:00:00','2007-09-19 00:00:00','2007-09-19 00:00:00','有事','已批准',1,'写报告',8);
/*!40000 ALTER TABLE `tblOverTime` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblOverTimeType`
--

DROP TABLE IF EXISTS `tblOverTimeType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblOverTimeType` (
  `Type` tinyint(4) NOT NULL AUTO_INCREMENT,
  `Description` varchar(10) NOT NULL,
  PRIMARY KEY (`Type`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblOverTimeType`
--

LOCK TABLES `tblOverTimeType` WRITE;
/*!40000 ALTER TABLE `tblOverTimeType` DISABLE KEYS */;
INSERT INTO `tblOverTimeType` VALUES (1,'折算成年假'),(2,'折算成津贴');
/*!40000 ALTER TABLE `tblOverTimeType` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblPerformItem`
--

DROP TABLE IF EXISTS `tblPerformItem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblPerformItem` (
  `PerformItemID` int(11) NOT NULL AUTO_INCREMENT,
  `PerformID` int(11) NOT NULL,
  `ObjectContent` varchar(100) NOT NULL,
  `SelfScore` tinyint(4) DEFAULT NULL,
  `ReviewScore` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`PerformItemID`),
  KEY `PerformID` (`PerformID`),
  CONSTRAINT `tblPerformItem_ibfk_1` FOREIGN KEY (`PerformID`) REFERENCES `tblPerformance` (`PerformID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblPerformItem`
--

LOCK TABLES `tblPerformItem` WRITE;
/*!40000 ALTER TABLE `tblPerformItem` DISABLE KEYS */;
INSERT INTO `tblPerformItem` VALUES (1,1,'Learn XML',1,1),(2,2,'Learn ADO.NET',2,2),(3,3,'learn Com+',4,2),(4,4,'learn C# ',2,2),(5,4,'learn Java',2,1);
/*!40000 ALTER TABLE `tblPerformItem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblPerformStatus`
--

DROP TABLE IF EXISTS `tblPerformStatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblPerformStatus` (
  `Type` tinyint(4) NOT NULL,
  `Name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblPerformStatus`
--

LOCK TABLES `tblPerformStatus` WRITE;
/*!40000 ALTER TABLE `tblPerformStatus` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblPerformStatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblPerformance`
--

DROP TABLE IF EXISTS `tblPerformance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblPerformance` (
  `PerformID` int(11) NOT NULL AUTO_INCREMENT,
  `EmployeeID` int(11) NOT NULL,
  `ReviewerID` int(11) DEFAULT NULL,
  `SubmitTime` datetime NOT NULL,
  `PerformYear` int(11) NOT NULL,
  `PerformSeason` tinyint(4) NOT NULL,
  `Status` tinyint(4) DEFAULT NULL,
  `LastEditTime` datetime DEFAULT NULL,
  `SelfScore` tinyint(4) DEFAULT NULL,
  `ReviewScore` tinyint(4) DEFAULT NULL,
  `SelfComment` varchar(200) DEFAULT NULL,
  `ReviewComment` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`PerformID`),
  KEY `EmployeeID` (`EmployeeID`),
  KEY `ReviewerID` (`ReviewerID`),
  CONSTRAINT `tblPerformance_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `tblEmployee` (`EmployeeID`),
  CONSTRAINT `tblPerformance_ibfk_2` FOREIGN KEY (`ReviewerID`) REFERENCES `tblEmployee` (`EmployeeID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblPerformance`
--

LOCK TABLES `tblPerformance` WRITE;
/*!40000 ALTER TABLE `tblPerformance` DISABLE KEYS */;
INSERT INTO `tblPerformance` VALUES (1,2,1,'2006-09-25 00:00:00',2006,3,0,'2007-09-28 00:00:00',NULL,NULL,NULL,NULL),(2,3,1,'2007-01-25 00:00:00',2007,1,0,'2007-09-28 00:00:00',NULL,NULL,NULL,NULL),(3,4,1,'2004-06-25 00:00:00',2004,2,0,'2004-06-28 00:00:00',NULL,NULL,NULL,NULL),(4,5,1,'2007-09-25 00:00:00',2007,3,0,'2007-09-28 00:00:00',NULL,NULL,NULL,NULL),(5,6,1,'2007-09-25 00:00:00',2006,3,0,'2007-09-28 00:00:00',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `tblPerformance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblSalary`
--

DROP TABLE IF EXISTS `tblSalary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblSalary` (
  `SalaryID` int(11) NOT NULL AUTO_INCREMENT,
  `EmployeeID` int(11) NOT NULL,
  `SalaryTime` datetime NOT NULL,
  `BasicSalary` int(11) DEFAULT NULL,
  `OvertimeSalary` int(11) DEFAULT NULL,
  `AbsenceSalary` int(11) DEFAULT NULL,
  `OtherSalary` int(11) DEFAULT NULL,
  PRIMARY KEY (`SalaryID`),
  KEY `EmployeeID` (`EmployeeID`),
  CONSTRAINT `tblSalary_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `tblEmployee` (`EmployeeID`)
) ENGINE=InnoDB AUTO_INCREMENT=205 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblSalary`
--

LOCK TABLES `tblSalary` WRITE;
/*!40000 ALTER TABLE `tblSalary` DISABLE KEYS */;
INSERT INTO `tblSalary` VALUES (1,1,'2015-01-31 00:00:00',10001,2000,-100,100),(2,1,'2015-02-28 00:00:00',10002,2000,-100,100),(3,1,'2015-03-31 00:00:00',10003,2000,-100,100),(4,1,'2015-04-30 00:00:00',10004,2000,-100,100),(5,1,'2015-05-31 00:00:00',10005,2000,-100,100),(6,1,'2015-06-30 00:00:00',10006,2000,-100,100),(7,1,'2015-07-31 00:00:00',10007,2000,-100,100),(8,1,'2015-08-31 00:00:00',10008,2000,-100,100),(9,1,'2015-09-30 00:00:00',10009,2000,-100,100),(10,1,'2015-10-31 00:00:00',10010,2000,-100,100),(11,1,'2015-11-30 00:00:00',10011,2000,-100,100),(12,1,'2015-12-31 00:00:00',10012,2000,-100,100),(13,2,'2015-01-31 00:00:00',10001,4000,-200,100),(14,2,'2015-02-28 00:00:00',10002,4000,-200,100),(15,2,'2015-03-31 00:00:00',10003,4000,-200,100),(16,2,'2015-04-30 00:00:00',10004,4000,-200,100),(17,2,'2015-05-31 00:00:00',10005,4000,-200,100),(18,2,'2015-06-30 00:00:00',10006,4000,-200,100),(19,2,'2015-07-31 00:00:00',10007,4000,-200,100),(20,2,'2015-08-31 00:00:00',10008,4000,-200,100),(21,2,'2015-09-30 00:00:00',10009,4000,-200,100),(22,2,'2015-10-31 00:00:00',10010,4000,-200,100),(23,2,'2015-11-30 00:00:00',10011,4000,-200,100),(24,2,'2015-12-31 00:00:00',10012,4000,-200,100),(25,3,'2015-01-31 00:00:00',4001,2000,-300,200),(26,3,'2015-02-28 00:00:00',4002,2000,-300,200),(27,3,'2015-03-31 00:00:00',4003,2000,-300,200),(28,3,'2015-04-30 00:00:00',4004,2000,-300,200),(29,3,'2015-05-31 00:00:00',4005,2000,-300,200),(30,3,'2015-06-30 00:00:00',4006,2000,-300,200),(31,3,'2015-07-31 00:00:00',4007,2000,-300,200),(32,3,'2015-08-31 00:00:00',4008,2000,-300,200),(33,3,'2015-09-30 00:00:00',4009,2000,-300,200),(34,3,'2015-10-31 00:00:00',4010,2000,-300,200),(35,3,'2015-11-30 00:00:00',4011,2000,-300,200),(36,3,'2015-12-31 00:00:00',4012,2000,-300,200),(37,4,'2015-01-31 00:00:00',5001,2000,-400,220),(38,4,'2015-02-28 00:00:00',5002,2000,-400,220),(39,4,'2015-03-31 00:00:00',5003,2000,-400,220),(40,4,'2015-04-30 00:00:00',5004,2000,-400,220),(41,4,'2015-05-31 00:00:00',5005,2000,-400,220),(42,4,'2015-06-30 00:00:00',5006,2000,-400,220),(43,4,'2015-07-31 00:00:00',5007,2000,-400,220),(44,4,'2015-08-31 00:00:00',5008,2000,-400,220),(45,4,'2015-09-30 00:00:00',5009,2000,-400,220),(46,4,'2015-10-31 00:00:00',5010,2000,-400,220),(47,4,'2015-11-30 00:00:00',5011,2000,-400,220),(48,4,'2015-12-31 00:00:00',5012,2000,-400,220),(49,5,'2015-01-31 00:00:00',6001,2000,-500,330),(50,5,'2015-02-28 00:00:00',6002,2000,-500,330),(51,5,'2015-03-31 00:00:00',6003,2000,-500,330),(52,5,'2015-04-30 00:00:00',6004,2000,-500,330),(53,5,'2015-05-31 00:00:00',6005,2000,-500,330),(54,5,'2015-06-30 00:00:00',6006,2000,-500,330),(55,5,'2015-07-31 00:00:00',6007,2000,-500,330),(56,5,'2015-08-31 00:00:00',6008,2000,-500,330),(57,5,'2015-09-30 00:00:00',6009,2000,-500,330),(58,5,'2015-10-31 00:00:00',6010,2000,-500,330),(59,5,'2015-11-30 00:00:00',6011,2000,-500,330),(60,5,'2015-12-31 00:00:00',6012,2000,-500,330),(61,6,'2015-01-31 00:00:00',7001,2000,-600,330),(62,6,'2015-02-28 00:00:00',7002,2000,-600,330),(63,6,'2015-03-31 00:00:00',7003,2000,-600,330),(64,6,'2015-04-30 00:00:00',7004,2000,-600,330),(65,6,'2015-05-31 00:00:00',7005,2000,-600,330),(66,6,'2015-06-30 00:00:00',7006,2000,-600,330),(67,6,'2015-07-31 00:00:00',7007,2000,-600,330),(68,6,'2015-08-31 00:00:00',7008,2000,-600,330),(69,6,'2015-09-30 00:00:00',7009,2000,-600,330),(70,6,'2015-10-31 00:00:00',7010,2000,-600,330),(71,6,'2015-11-30 00:00:00',7011,2000,-600,330),(72,6,'2015-12-31 00:00:00',7012,2000,-600,330),(73,7,'2015-01-31 00:00:00',10001,2000,-100,100),(74,7,'2015-02-28 00:00:00',10002,2000,-100,100),(75,7,'2015-03-31 00:00:00',10003,2000,-100,100),(76,7,'2015-04-30 00:00:00',10004,2000,-100,100),(77,7,'2015-05-31 00:00:00',10005,2000,-100,100),(78,7,'2015-06-30 00:00:00',10006,2000,-100,100),(79,7,'2015-07-31 00:00:00',10007,2000,-100,100),(80,7,'2015-08-31 00:00:00',10008,2000,-100,100),(81,7,'2015-09-30 00:00:00',10009,2000,-100,100),(82,7,'2015-10-31 00:00:00',10010,2000,-100,100),(83,7,'2015-11-30 00:00:00',10011,2000,-100,100),(84,7,'2015-12-31 00:00:00',10012,2000,-100,100),(85,8,'2015-01-31 00:00:00',7001,2000,-600,330),(86,8,'2015-02-28 00:00:00',7002,2000,-600,330),(87,8,'2015-03-31 00:00:00',7003,2000,-600,330),(88,8,'2015-04-30 00:00:00',7004,2000,-600,330),(89,8,'2015-05-31 00:00:00',7005,2000,-600,330),(90,8,'2015-06-30 00:00:00',7006,2000,-600,330),(91,8,'2015-07-31 00:00:00',7007,2000,-600,330),(92,8,'2015-08-31 00:00:00',7008,2000,-600,330),(93,8,'2015-09-30 00:00:00',7009,2000,-600,330),(94,8,'2015-10-31 00:00:00',7010,2000,-600,330),(95,8,'2015-11-30 00:00:00',7011,2000,-600,330),(96,8,'2015-12-31 00:00:00',7012,2000,-600,330),(97,9,'2015-01-31 00:00:00',6001,2000,-500,330),(98,9,'2015-02-28 00:00:00',6002,2000,-500,330),(99,9,'2015-03-31 00:00:00',6003,2000,-500,330),(100,9,'2015-04-30 00:00:00',6004,2000,-500,330),(101,9,'2015-05-31 00:00:00',6005,2000,-500,330),(102,9,'2015-06-30 00:00:00',6006,2000,-500,330),(103,9,'2015-07-31 00:00:00',6007,2000,-500,330),(104,9,'2015-08-31 00:00:00',6008,2000,-500,330),(105,9,'2015-09-30 00:00:00',6009,2000,-500,330),(106,9,'2015-10-31 00:00:00',6010,2000,-500,330),(107,9,'2015-11-30 00:00:00',6011,2000,-500,330),(108,9,'2015-12-31 00:00:00',6012,2000,-500,330),(109,10,'2015-01-31 00:00:00',5001,2000,-400,220),(110,10,'2015-02-28 00:00:00',5002,2000,-400,220),(111,10,'2015-03-31 00:00:00',5003,2000,-400,220),(112,10,'2015-04-30 00:00:00',5004,2000,-400,220),(113,10,'2015-05-31 00:00:00',5005,2000,-400,220),(114,10,'2015-06-30 00:00:00',5006,2000,-400,220),(115,10,'2015-07-31 00:00:00',5007,2000,-400,220),(116,10,'2015-08-31 00:00:00',5008,2000,-400,220),(117,10,'2015-09-30 00:00:00',5009,2000,-400,220),(118,10,'2015-10-31 00:00:00',5010,2000,-400,220),(119,10,'2015-11-30 00:00:00',5011,2000,-400,220),(120,10,'2015-12-31 00:00:00',5012,2000,-400,220),(121,11,'2015-01-31 00:00:00',4001,2000,-300,200),(122,11,'2015-02-28 00:00:00',4002,2000,-300,200),(123,11,'2015-03-31 00:00:00',4003,2000,-300,200),(124,11,'2015-04-30 00:00:00',4004,2000,-300,200),(125,11,'2015-05-31 00:00:00',4005,2000,-300,200),(126,11,'2015-06-30 00:00:00',4006,2000,-300,200),(127,11,'2015-07-31 00:00:00',4007,2000,-300,200),(128,11,'2015-08-31 00:00:00',4008,2000,-300,200),(129,11,'2015-09-30 00:00:00',4009,2000,-300,200),(130,11,'2015-10-31 00:00:00',4010,2000,-300,200),(131,11,'2015-11-30 00:00:00',4011,2000,-300,200),(132,11,'2015-12-31 00:00:00',4012,2000,-300,200),(133,12,'2015-01-31 00:00:00',10001,4000,-200,100),(134,12,'2015-02-28 00:00:00',10002,4000,-200,100),(135,12,'2015-03-31 00:00:00',10003,4000,-200,100),(136,12,'2015-04-30 00:00:00',10004,4000,-200,100),(137,12,'2015-05-31 00:00:00',10005,4000,-200,100),(138,12,'2015-06-30 00:00:00',10006,4000,-200,100),(139,12,'2015-07-31 00:00:00',10007,4000,-200,100),(140,12,'2015-08-31 00:00:00',10008,4000,-200,100),(141,12,'2015-09-30 00:00:00',10009,4000,-200,100),(142,12,'2015-10-31 00:00:00',10010,4000,-200,100),(143,12,'2015-11-30 00:00:00',10011,4000,-200,100),(144,12,'2015-12-31 00:00:00',10012,4000,-200,100),(145,13,'2015-01-31 00:00:00',10001,4000,-200,100),(146,13,'2015-02-28 00:00:00',10002,4000,-200,100),(147,13,'2015-03-31 00:00:00',10003,4000,-200,100),(148,13,'2015-04-30 00:00:00',10004,4000,-200,100),(149,13,'2015-05-31 00:00:00',10005,4000,-200,100),(150,13,'2015-06-30 00:00:00',10006,4000,-200,100),(151,13,'2015-07-31 00:00:00',10007,4000,-200,100),(152,13,'2015-08-31 00:00:00',10008,4000,-200,100),(153,13,'2015-09-30 00:00:00',10009,4000,-200,100),(154,13,'2015-10-31 00:00:00',10010,4000,-200,100),(155,13,'2015-11-30 00:00:00',10011,4000,-200,100),(156,13,'2015-12-31 00:00:00',10012,4000,-200,100),(181,16,'2015-01-31 00:00:00',10001,4000,-200,100),(182,16,'2015-02-28 00:00:00',10002,4000,-200,100),(183,16,'2015-03-31 00:00:00',10003,4000,-200,100),(184,16,'2015-04-30 00:00:00',10004,4000,-200,100),(185,16,'2015-05-31 00:00:00',10005,4000,-200,100),(186,16,'2015-06-30 00:00:00',10006,4000,-200,100),(187,16,'2015-07-31 00:00:00',10007,4000,-200,100),(188,16,'2015-08-31 00:00:00',10008,4000,-200,100),(189,16,'2015-09-30 00:00:00',10009,4000,-200,100),(190,16,'2015-10-31 00:00:00',10010,4000,-200,100),(191,16,'2015-11-30 00:00:00',10011,4000,-200,100),(192,16,'2015-12-31 00:00:00',10012,4000,-200,100),(193,17,'2015-01-31 00:00:00',10001,4000,-200,100),(194,17,'2015-02-28 00:00:00',10002,4000,-200,100),(195,17,'2015-03-31 00:00:00',10003,4000,-200,100),(196,17,'2015-04-30 00:00:00',10004,4000,-200,100),(197,17,'2015-05-31 00:00:00',10005,4000,-200,100),(198,17,'2015-06-30 00:00:00',10006,4000,-200,100),(199,17,'2015-07-31 00:00:00',10007,4000,-200,100),(200,17,'2015-08-31 00:00:00',10008,4000,-200,100),(201,17,'2015-09-30 00:00:00',10009,4000,-200,100),(202,17,'2015-10-31 00:00:00',10010,4000,-200,100),(203,17,'2015-11-30 00:00:00',10011,4000,-200,100),(204,17,'2015-12-31 00:00:00',10012,4000,-200,100);
/*!40000 ALTER TABLE `tblSalary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblSystemEvent`
--

DROP TABLE IF EXISTS `tblSystemEvent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblSystemEvent` (
  `EventID` int(11) NOT NULL AUTO_INCREMENT,
  `EventTime` datetime NOT NULL,
  `EventMessage` varchar(100) NOT NULL,
  PRIMARY KEY (`EventID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblSystemEvent`
--

LOCK TABLES `tblSystemEvent` WRITE;
/*!40000 ALTER TABLE `tblSystemEvent` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblSystemEvent` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-11-29 21:45:11
