# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.42)
# Database: Cleanify
# Generation Time: 2015-05-02 07:13:48 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table submission_data
# ------------------------------------------------------------

DROP TABLE IF EXISTS `submission_data`;

CREATE TABLE `submission_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(64) NOT NULL DEFAULT '',
  `last_name` varchar(64) NOT NULL DEFAULT '',
  `email` varchar(320) NOT NULL DEFAULT '',
  `city` varchar(128) NOT NULL,
  `state` varchar(8) NOT NULL,
  `zip` varchar(11) NOT NULL,
  `phone` varchar(32) NOT NULL DEFAULT '',
  `fax` varchar(32) NOT NULL DEFAULT '',
  `best_time_to_contact` varchar(32) NOT NULL DEFAULT '',
  `best_day_to_contact` varchar(32) NOT NULL,
  `tos` tinyint(1) NOT NULL DEFAULT '0',
  `added` int(128) NOT NULL,
  `modified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `last_name` (`last_name`),
  KEY `modified` (`modified`),
  KEY `added` (`added`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `submission_data` WRITE;
/*!40000 ALTER TABLE `submission_data` DISABLE KEYS */;

INSERT INTO `submission_data` (`id`, `first_name`, `last_name`, `email`, `city`, `state`, `zip`, `phone`, `fax`, `best_time_to_contact`, `best_day_to_contact`, `tos`, `added`, `modified`)
VALUES
	(79,'Thanh','Pham','fff','asfd','CA','asdf','asdfasdf','n/a','2 PM','Wed',1,1430436550,'2015-05-02 00:13:34'),
	(80,'Thanh','Pham','asdf','asf','asdf','asdf','asdf','asdf','asdf','asdf',1,1430437562,NULL),
	(81,'move','the','email','to ','config','test','asfd','asdf','asdf','asdf',1,1430437865,NULL),
	(82,'two','emails','asf','asf','asfd','asfd','asfd','asf','asfd','sdf',1,1430438099,NULL),
	(83,'asdf','asfd','j','j','j','j','j','j','j','j',1,1430439570,NULL),
	(84,'ok','robot','k','k','k','k','k','','k','k',1,1430439675,NULL),
	(85,'ok','robot','k','k','k','k','k','','k','k',1,1430439824,NULL),
	(86,'Thanh','Submission','for','asdf','I','hope','you','','like','this!',1,1430441420,'2015-05-02 00:13:27'),
	(87,'Thanh','Yo','dude','asdf','asdff','j','asf','jk','jk','kj',1,1430547211,NULL),
	(88,'Thanh','Pham','yo','man','asdf','asdf','asdf','asdf','asdf','asdf',1,1430547236,NULL),
	(89,'Thanh','Pham','asdf','asdf','CA','asdf','asdfasf','asdf','asf','asf',1,1430550469,'2015-05-02 00:13:35');

/*!40000 ALTER TABLE `submission_data` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table submission_form_contents
# ------------------------------------------------------------

DROP TABLE IF EXISTS `submission_form_contents`;

CREATE TABLE `submission_form_contents` (
  `order` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `field_name` varchar(64) NOT NULL DEFAULT '',
  `field_value` varchar(64) NOT NULL DEFAULT '',
  `input_type` varchar(64) NOT NULL DEFAULT '',
  `required` tinyint(1) NOT NULL DEFAULT '1',
  `form_value` varchar(64) DEFAULT '',
  `required_html` varchar(8) DEFAULT '',
  UNIQUE KEY `order` (`order`),
  KEY `field_name` (`field_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `submission_form_contents` WRITE;
/*!40000 ALTER TABLE `submission_form_contents` DISABLE KEYS */;

INSERT INTO `submission_form_contents` (`order`, `field_name`, `field_value`, `input_type`, `required`, `form_value`, `required_html`)
VALUES
	(1,'first_name','First Name','input',1,'','required'),
	(2,'last_name','Last Name','input',1,'','required'),
	(3,'email','Email','input',1,'','required'),
	(4,'city','City','input',1,'','required'),
	(5,'state','State','input',1,'','required'),
	(6,'zip','Zip Code','input',1,'','required'),
	(7,'phone','Phone','input',1,'','required'),
	(8,'fax','Fax','input',0,'',''),
	(9,'best_time_to_contact','Best Time to Contact','input',1,'','required'),
	(10,'best_day_to_contact','Best Day to Contact You','input',1,'','required'),
	(11,'tos','','hidden',0,'0',''),
	(12,'tos','Do you agree to the terms of serivce?','checkbox',1,'1','required');

/*!40000 ALTER TABLE `submission_form_contents` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
