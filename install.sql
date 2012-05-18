# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.22-0ubuntu1)
# Database: pico
# Generation Time: 2012-05-07 11:41:05 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table cacheHeader
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cacheHeader`;

CREATE TABLE `cacheHeader` (
  `domainId` int(11) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `page` set('index','robot') NOT NULL DEFAULT '',
  `header` blob NOT NULL,
  PRIMARY KEY (`domainId`,`page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table cacheIndex
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cacheIndex`;

CREATE TABLE `cacheIndex` (
  `domainId` int(11) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `compressed` enum('Yes','No') NOT NULL DEFAULT 'No',
  `index` blob,
  PRIMARY KEY (`domainId`),
  KEY `date` (`date`,`domainId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table cacheLinks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cacheLinks`;

CREATE TABLE `cacheLinks` (
  `domainId` int(11) NOT NULL DEFAULT '0' COMMENT 'Domain which link was found.',
  `linkDomainId` int(11) NOT NULL DEFAULT '0' COMMENT 'Domain Id of the linked.',
  `rank` mediumint(9) NOT NULL DEFAULT '0',
  PRIMARY KEY (`domainId`,`linkDomainId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table cacheRobot
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cacheRobot`;

CREATE TABLE `cacheRobot` (
  `domainId` int(11) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `robot` blob NOT NULL,
  PRIMARY KEY (`domainId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table domain
# ------------------------------------------------------------

DROP TABLE IF EXISTS `domain`;

CREATE TABLE `domain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rank` smallint(6) NOT NULL DEFAULT '0',
  `status` set('queue','processing','stored','paused','blocked','useless') NOT NULL DEFAULT 'queue',
  `domain` varchar(255) NOT NULL DEFAULT '',
  `ip` int(10) unsigned NOT NULL,
  `nextindex` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastindex` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `domain` (`domain`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table error_sql
# ------------------------------------------------------------

DROP TABLE IF EXISTS `error_sql`;

CREATE TABLE `error_sql` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `sql` text NOT NULL,
  `error` text NOT NULL,
  `trace` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table keyword
# ------------------------------------------------------------

DROP TABLE IF EXISTS `keyword`;

CREATE TABLE `keyword` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `keyword` (`keyword`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table keyword2
# ------------------------------------------------------------

DROP TABLE IF EXISTS `keyword2`;

CREATE TABLE `keyword2` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(100) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `keyword` (`keyword`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 PACK_KEYS=0;



# Dump of table languages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `languages`;

CREATE TABLE `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cc` char(2) NOT NULL,
  `nameEng` char(58) NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cc` (`cc`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table logBlock
# ------------------------------------------------------------

DROP TABLE IF EXISTS `logBlock`;

CREATE TABLE `logBlock` (
  `domainId` int(11) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `reason` enum('none','robot','keyword','description','content','connection','meta') NOT NULL DEFAULT 'none',
  `info` text NOT NULL,
  PRIMARY KEY (`domainId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table logSearch
# ------------------------------------------------------------

DROP TABLE IF EXISTS `logSearch`;

CREATE TABLE `logSearch` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) NOT NULL DEFAULT '',
  `datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `q` varchar(255) NOT NULL DEFAULT '',
  `seek` float(5,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table metadata
# ------------------------------------------------------------

DROP TABLE IF EXISTS `metadata`;

CREATE TABLE `metadata` (
  `domainId` int(11) NOT NULL DEFAULT '0',
  `lang` varchar(2) NOT NULL DEFAULT '',
  `dialect` varchar(2) NOT NULL DEFAULT '',
  `extract` text NOT NULL,
  `thumbCreated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`domainId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table rank
# ------------------------------------------------------------

DROP TABLE IF EXISTS `rank`;

CREATE TABLE `rank` (
  `keyword_id` int(11) NOT NULL DEFAULT '0',
  `domainId` int(11) NOT NULL DEFAULT '0',
  `score` int(7) NOT NULL DEFAULT '2500',
  PRIMARY KEY (`keyword_id`,`domainId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table rank2
# ------------------------------------------------------------

DROP TABLE IF EXISTS `rank2`;

CREATE TABLE `rank2` (
  `keyword_id` int(11) NOT NULL DEFAULT '0',
  `domainId` int(11) NOT NULL DEFAULT '0',
  `score` int(7) NOT NULL DEFAULT '2500',
  PRIMARY KEY (`keyword_id`,`domainId`),
  KEY `domainId` (`domainId`,`keyword_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 PACK_KEYS=0;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
