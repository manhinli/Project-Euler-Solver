-- MySQL dump 10.13  Distrib 5.6.29, for linux-glibc2.5 (x86_64)
--
-- Host: localhost    Database: uq498819
-- ------------------------------------------------------
-- Server version	5.6.29

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES UTF8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `problems`
--

DROP TABLE IF EXISTS `problems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `problems` (
  `id` int(11) NOT NULL COMMENT 'Equal to Project Euler Problem ID',
  `title` varchar(255) NOT NULL,
  `statement` text NOT NULL COMMENT 'The full problem statement to be displayed, with HTML',
  `input_label` varchar(255) NOT NULL COMMENT 'Label to be displayed for the input to the solver',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `problems`
--

LOCK TABLES `problems` WRITE;
/*!40000 ALTER TABLE `problems` DISABLE KEYS */;
INSERT INTO `problems` VALUES (3,'Largest prime factor','<p>The prime factors of 13195 are 5, 7, 13 and 29.</p>\r\n<p>Use this solver to find the largest prime factor for a given positive integer.</p>','Number to find the largest prime factor of'),(5,'Smallest multiple','<p>2520 is the smallest number that can be divided by each of the numbers from 1 to 10 without any remainder.</p>\r\n<p>Use this solver to find the smallest positive number that is <dfn title=\"divisible with no remainder\">evenly divisible</dfn> by all integers between 1 and a given positive integer.</p>','Upper limit to search even divisibility by'),(57,'Square root convergents','<p>It is possible to show that the square root of two can be expressed as an infinite continued fraction.</p>\r\n<p style=\"text-align: center;\">√ 2 = 1 + 1/(2 + 1/(2 + 1/(2 + ... ))) = 1.414213...</p>\r\n<p>By expanding this for the first four iterations, we get:</p>\r\n<p>1 + 1/2 = 3/2 = 1.5<br />\r\n1 + 1/(2 + 1/2) = 7/5 = 1.4<br />\r\n1 + 1/(2 + 1/(2 + 1/2)) = 17/12 = 1.41666...<br />\r\n1 + 1/(2 + 1/(2 + 1/(2 + 1/2))) = 41/29 = 1.41379...<br /></p>\r\n<p>The next three expansions are 99/70, 239/169, and 577/408, but the eighth expansion, 1393/985, is the first example where the number of digits in the numerator exceeds the number of digits in the denominator.</p>\r\n<p>Use this solver to find the number of expansions where the number of digits in the numerator is greater than that of the denominator, for some given number of iterations.</p>','Number of iterations to run the search for');
/*!40000 ALTER TABLE `problems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `solutions`
--

DROP TABLE IF EXISTS `solutions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `solutions` (
  `problem_id` int(11) NOT NULL,
  `test_number` text NOT NULL COMMENT 'Input value into the solver',
  `test_answer` text NOT NULL COMMENT 'Output value from the solver',
  `total_runs` int(11) NOT NULL DEFAULT '0' COMMENT 'Total number of runs on this input-output pair',
  KEY `problem_id` (`problem_id`),
  CONSTRAINT `ProblemID` FOREIGN KEY (`problem_id`) REFERENCES `problems` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solutions`
--

LOCK TABLES `solutions` WRITE;
/*!40000 ALTER TABLE `solutions` DISABLE KEYS */;
INSERT INTO `solutions` VALUES (3,'35664','743',12),(3,'999999999','333667',5),(5,'20','232792560',25),(3,'45678912','237911',1),(3,'446','223',2),(5,'21','232792560',3),(5,'22','232792560',2),(5,'23','5354228880',6),(5,'24','5354228880',2),(3,'600851475143','6857',3),(3,'13195','29',5),(3,'50','5',1),(5,'3','6',3),(5,'5','60',5),(5,'8','840',4),(5,'9','2520',3),(3,'8851','167',1),(3,'5645645','30517',1),(3,'22','11',1),(3,'3','3',2),(3,'2','2',3),(5,'15','360360',5),(5,'13','360360',2),(5,'4','12',5),(5,'6','60',2),(5,'7','420',4),(5,'10','2520',5),(5,'11','27720',2),(5,'12','27720',2),(5,'14','360360',2),(5,'16','720720',3),(5,'17','12252240',1),(5,'18','12252240',1),(5,'19','232792560',1),(3,'235897','563',1),(3,'2984768934','1512041',1),(3,'3497598576343','40360477',1),(5,'2','2',3),(3,'498593475','82073',1),(3,'39867897689734987','39867897689734987',1),(3,'9999999942014077477','649657',1),(3,'9999999942014077476','649657',1),(3,'9223372036854775807','649657',1),(3,'92233720368547758','1321',1),(3,'9999986200004761','99999931',1),(3,'665654658','110942443',1),(3,'435','29',1),(3,'23423','397',1),(3,'5','5',2),(3,'65856','7',1),(3,'474585','1091',1),(3,'2869875','2551',2),(3,'23785328','212369',1),(3,'2384726','70139',1),(3,'747','83',1),(3,'4','2',2),(3,'6','3',1),(3,'7','7',2),(3,'8','2',1),(3,'29878375','239027',1),(3,'345728','73',1),(3,'238975823','2467',1),(3,'2345728','17',1),(3,'656','41',2),(3,'54','3',1),(3,'5689879879','49307',2),(3,'2439875','149',3),(3,'3234','11',1),(3,'345345','23',1),(3,'7657657','1093951',5),(3,'7657','31',6),(3,'23876482365624','248900033',6),(3,'435345345345','29023023023',5),(3,'24438973894693723','146309743',6),(3,'325897','53',1),(3,'348957','191',1),(3,'349875934537','349875934537',6),(3,'4475664','31081',1),(3,'24566347','2383',2),(3,'7655648456','956956057',7),(3,'2349875','1709',1),(5,'1','1',1),(3,'4354378','311027',1),(3,'9876834','601',1),(3,'239875829','239875829',1),(3,'35245','53',1),(3,'786','131',1),(3,'8566756643','8566756643',1),(3,'344634534','6382121',1),(3,'95735739859238','10504027',1),(3,'3453252','26161',1),(3,'23532453245','9467',1),(3,'325235','2243',1),(3,'2345345','469069',1),(3,'34879','2683',1),(3,'23','23',3),(3,'377','29',1),(3,'67','67',1),(3,'8656','541',1),(3,'643754327','5906003',1),(3,'23597','3371',1),(3,'78485643','8720627',1),(3,'87577565767','14100397',2),(3,'76465','373',1),(3,'765','17',2),(3,'56','7',1),(3,'7546','11',1),(3,'65','13',1),(3,'85','17',1),(3,'76','19',2),(3,'46','23',1),(3,'6.2','3',1),(3,'546','13',2),(3,'6465145613','11819279',1),(3,'681351','1877',1),(3,'289456781','289456781',1),(3,'345','23',1),(3,'346','173',1),(3,'34734','827',1),(3,'2345','67',1),(3,'34535','6907',1),(3,'6567','199',1),(3,'5341','109',1),(3,'878675675675','167663',1),(3,'764564','191141',1),(3,'235','47',1),(3,'64536','2689',1),(3,'2352346','1176173',1),(3,'47457347','1889',1),(3,'3462571','461',1),(3,'2348957','1789',2),(57,'1000','153',11),(57,'7654','1150',1),(57,'6455','972',1),(57,'8998','1355',1),(57,'1001','153',1),(57,'99999','15052',1),(57,'5','0',1),(57,'999','153',1),(57,'1002','153',1),(57,'1003','154',1),(3,'1227568','1051',1);
/*!40000 ALTER TABLE `solutions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-04-27  4:05:22
