# ************************************************************
# Sequel Pro SQL dump
# Version 4135
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.5.38)
# Database: curriculum
# Generation Time: 2015-04-24 01:22:17 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table people
# ------------------------------------------------------------

DROP VIEW IF EXISTS `people`;

CREATE TABLE `people` (
   `individuals_id` VARCHAR(256) NOT NULL,
   `display_name` VARCHAR(50) NULL DEFAULT NULL,
   `first_name` VARCHAR(64) NULL DEFAULT NULL,
   `middle_name` VARCHAR(64) NULL DEFAULT NULL,
   `last_name` VARCHAR(64) NULL DEFAULT NULL,
   `common_name` VARCHAR(64) NULL DEFAULT NULL,
   `email` VARCHAR(256) NULL DEFAULT NULL
) ENGINE=MyISAM;





# Replace placeholder table for people with correct view syntax
# ------------------------------------------------------------

DROP TABLE `people`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dba_ptg`@`ssh.grid.csun.edu` SQL SECURITY INVOKER VIEW `people`
AS SELECT
   `nemo`.`individuals`.`individuals_id` AS `individuals_id`,
   `nemo`.`entities`.`display_name` AS `display_name`,
   `nemo`.`individuals`.`first_name` AS `first_name`,
   `nemo`.`individuals`.`middle_name` AS `middle_name`,
   `nemo`.`individuals`.`last_name` AS `last_name`,
   `nemo`.`individuals`.`common_name` AS `common_name`,
   `bedrock`.`registry`.`email` AS `email`
FROM ((`nemo`.`individuals` join `nemo`.`entities` on((`nemo`.`individuals`.`individuals_id` = `nemo`.`entities`.`entities_id`))) join `bedrock`.`registry` on((`nemo`.`entities`.`entities_id` = `bedrock`.`registry`.`entities_id`)));

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
