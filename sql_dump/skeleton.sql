/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 100122
Source Host           : localhost:3306
Source Database       : skeleton

Target Server Type    : MYSQL
Target Server Version : 100122
File Encoding         : 65001

Date: 2018-05-14 01:18:16
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for activities
-- ----------------------------
DROP TABLE IF EXISTS `activities`;
CREATE TABLE `activities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `module` varchar(100) DEFAULT NULL,
  `controller` varchar(100) DEFAULT NULL,
  `method` varchar(100) DEFAULT NULL,
  `activity` varchar(255) DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `created_at` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of activities
-- ----------------------------

-- ----------------------------
-- Table structure for entities
-- ----------------------------
DROP TABLE IF EXISTS `entities`;
CREATE TABLE `entities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `owner_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `type` enum('user','group','object') NOT NULL,
  `subtype` varchar(50) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `language` varchar(50) DEFAULT NULL,
  `privacy` tinyint(1) NOT NULL DEFAULT '2',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `created_at` int(11) unsigned NOT NULL DEFAULT '0',
  `updated_at` int(11) unsigned NOT NULL DEFAULT '0',
  `deleted_at` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of entities
-- ----------------------------
INSERT INTO `entities` VALUES ('1', '0', '0', 'user', 'administrator', 'admin', null, '2', '1', '0', '1525741827', '0', '0');

-- ----------------------------
-- Table structure for groups
-- ----------------------------
DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `guid` bigint(20) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` longtext,
  PRIMARY KEY (`guid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of groups
-- ----------------------------

-- ----------------------------
-- Table structure for metadata
-- ----------------------------
DROP TABLE IF EXISTS `metadata`;
CREATE TABLE `metadata` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `guid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL DEFAULT '',
  `value` longtext,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_values` (`guid`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of metadata
-- ----------------------------

-- ----------------------------
-- Table structure for objects
-- ----------------------------
DROP TABLE IF EXISTS `objects`;
CREATE TABLE `objects` (
  `guid` bigint(20) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` longtext,
  `content` longtext,
  PRIMARY KEY (`guid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of objects
-- ----------------------------

-- ----------------------------
-- Table structure for options
-- ----------------------------
DROP TABLE IF EXISTS `options`;
CREATE TABLE `options` (
  `name` varchar(100) NOT NULL,
  `value` longtext NOT NULL,
  `tab` varchar(50) NOT NULL DEFAULT '',
  `field_type` varchar(50) NOT NULL DEFAULT 'text',
  `options` varchar(255) NOT NULL DEFAULT '',
  `required` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of options
-- ----------------------------
INSERT INTO `options` VALUES ('active_plugins', 'a:0:{}', 'plugins', 'text', '', '1');
INSERT INTO `options` VALUES ('admin_email', 'admin@localhost', 'email', 'text', '', '1');
INSERT INTO `options` VALUES ('allowed_types', 'gif|png|jpeg|jpg|pdf|doc|txt|docx|xls|zip|rar|xls|mp4', 'upload', 'text', '', '1');
INSERT INTO `options` VALUES ('allow_multi_session', 'true', 'users', 'dropdown', 'a:2:{s:4:\"true\";s:8:\"lang:yes\";s:5:\"false\";s:7:\"lang:no\";}', '1');
INSERT INTO `options` VALUES ('allow_registration', 'true', 'users', 'dropdown', 'a:2:{s:4:\"true\";s:8:\"lang:yes\";s:5:\"false\";s:7:\"lang:no\";}', '1');
INSERT INTO `options` VALUES ('base_controller', 'welcome', 'general', 'dropdown', '', '1');
INSERT INTO `options` VALUES ('email_activation', 'true', 'users', 'dropdown', 'a:2:{s:4:\"true\";s:8:\"lang:yes\";s:5:\"false\";s:7:\"lang:no\";}', '1');
INSERT INTO `options` VALUES ('google_analytics_id', 'UA-XXXXX-Y', 'general', 'text', '', '0');
INSERT INTO `options` VALUES ('google_site_verification', '', 'general', 'text', '', '0');
INSERT INTO `options` VALUES ('image_large_h', '1024', 'upload', 'number', '', '1');
INSERT INTO `options` VALUES ('image_large_w', '1024', 'upload', 'number', '', '1');
INSERT INTO `options` VALUES ('image_medium_h', '300', 'upload', 'number', '', '1');
INSERT INTO `options` VALUES ('image_medium_w', '300', 'upload', 'number', '', '1');
INSERT INTO `options` VALUES ('image_thumbnail_crop', 'true', 'upload', 'dropdown', 'a:2:{s:4:\"true\";s:8:\"lang:yes\";s:5:\"false\";s:7:\"lang:no\";}', '1');
INSERT INTO `options` VALUES ('image_thumbnail_h', '150', 'upload', 'number', '', '1');
INSERT INTO `options` VALUES ('image_thumbnail_w', '150', 'upload', 'number', '', '1');
INSERT INTO `options` VALUES ('language', 'english', 'language', 'dropdown', 'a:2:{s:7:\"english\";s:7:\"english\";s:6:\"french\";s:6:\"french\";}', '1');
INSERT INTO `options` VALUES ('languages', 'a:1:{i:0;s:7:\"english\";}', 'language', 'dropdown', '', '1');
INSERT INTO `options` VALUES ('login_type', 'both', 'users', 'dropdown', 'a:3:{s:4:\"both\";s:9:\"lang:both\";s:8:\"username\";s:13:\"lang:username\";s:5:\"email\";s:18:\"lang:email_address\";}', '1');
INSERT INTO `options` VALUES ('mail_protocol', 'mail', 'email', 'dropdown', 'a:3:{s:4:\"mail\";s:4:\"Mail\";s:4:\"smtp\";s:4:\"SMTP\";s:8:\"sendmail\";s:8:\"Sendmail\";}', '1');
INSERT INTO `options` VALUES ('manual_activation', 'false', 'users', 'dropdown', 'a:2:{s:4:\"true\";s:8:\"lang:yes\";s:5:\"false\";s:7:\"lang:no\";}', '1');
INSERT INTO `options` VALUES ('max_height', '0', 'upload', 'number', '', '1');
INSERT INTO `options` VALUES ('max_size', '0', 'upload', 'number', '', '1');
INSERT INTO `options` VALUES ('max_width', '0', 'upload', 'number', '', '1');
INSERT INTO `options` VALUES ('min_height', '0', 'upload', 'number', '', '1');
INSERT INTO `options` VALUES ('min_width', '0', 'upload', 'number', '', '1');
INSERT INTO `options` VALUES ('per_page', '10', 'general', 'dropdown', 'a:3:{i:10;i:10;i:20;i:20;i:30;i:30;}', '1');
INSERT INTO `options` VALUES ('recaptcha_private_key', '', 'captcha', 'text', '', '0');
INSERT INTO `options` VALUES ('recaptcha_site_key', '', 'captcha', 'text', '', '0');
INSERT INTO `options` VALUES ('sendmail_path', '/usr/sbin/sendmail', 'email', 'text', '', '0');
INSERT INTO `options` VALUES ('server_email', 'noreply@localhost', 'email', 'text', '', '1');
INSERT INTO `options` VALUES ('site_author', 'Kader Bouyakoub', 'general', 'text', '', '0');
INSERT INTO `options` VALUES ('site_description', 'A skeleton application for building CodeIgniter application.', 'general', 'text', '', '0');
INSERT INTO `options` VALUES ('site_favicon', '', 'general', 'text', '', '0');
INSERT INTO `options` VALUES ('site_keywords', 'these, are, site, keywords', 'general', 'text', '', '0');
INSERT INTO `options` VALUES ('site_name', 'Skeleton', 'general', 'text', '', '1');
INSERT INTO `options` VALUES ('smtp_crypto', 'none', 'email', 'dropdown', 'a:3:{s:4:\"none\";s:9:\"lang:none\";s:3:\"ssl\";s:3:\"SSL\";s:3:\"tls\";s:3:\"TLS\";}', '1');
INSERT INTO `options` VALUES ('smtp_host', '', 'email', 'text', '', '0');
INSERT INTO `options` VALUES ('smtp_pass', '', 'email', 'password', '', '0');
INSERT INTO `options` VALUES ('smtp_port', '', 'email', 'text', '', '0');
INSERT INTO `options` VALUES ('smtp_user', '', 'email', 'text', '', '0');
INSERT INTO `options` VALUES ('theme', 'default', 'theme', 'text', '', '1');
INSERT INTO `options` VALUES ('themes', 'a:1:{s:7:\"default\";a:15:{s:4:\"name\";s:7:\"Default\";s:9:\"theme_uri\";s:65:\"https://goo.gl/wGXHO9/skeleton/tree/develop/public/content/themes\";s:11:\"description\";s:59:\"The default theme that comes with the CodeIgniter Skeleton.\";s:7:\"version\";s:5:\"1.0.0\";s:7:\"license\";s:3:\"MIT\";s:11:\"license_uri\";s:35:\"https://opensource.org/licenses/MIT\";s:6:\"author\";s:15:\"Kader Bouyakoub\";s:10:\"author_uri\";s:22:\"https://goo.gl/wGXHO9/\";s:12:\"author_email\";s:15:\"bkader@mail.com\";s:4:\"tags\";s:52:\"codeigniter, skeleton, bkader, bootstrap, bootstrap3\";s:10:\"screenshot\";s:66:\"http://localhost/skeleton-v2/content/themes/default/screenshot.jpg\";s:8:\"language\";s:8:\"language\";s:5:\"index\";s:7:\"default\";s:6:\"folder\";s:7:\"default\";s:8:\"full_pah\";s:51:\"D:\\xampp\\htdocs\\skeleton-v2\\content\\themes\\default\\\";}}', 'theme', 'text', '', '1');
INSERT INTO `options` VALUES ('theme_images_default', 'a:2:{s:5:\"thumb\";a:3:{s:5:\"width\";i:260;s:6:\"height\";i:180;s:4:\"crop\";b:1;}s:6:\"avatar\";a:3:{s:5:\"width\";i:100;s:6:\"height\";i:100;s:4:\"crop\";b:1;}}', 'theme', 'text', '', '0');
INSERT INTO `options` VALUES ('theme_menus_default', 'a:3:{s:11:\"header-menu\";s:14:\"lang:main_menu\";s:11:\"footer-menu\";s:16:\"lang:footer_menu\";s:12:\"sidebar-menu\";s:17:\"lang:sidebar_menu\";}', 'menus', '0', '', '1');
INSERT INTO `options` VALUES ('upload_path', 'content/uploads', 'upload', 'text', '', '0');
INSERT INTO `options` VALUES ('upload_year_month', 'true', 'upload', 'dropdown', 'a:2:{s:4:\"true\";s:8:\"lang:yes\";s:5:\"false\";s:7:\"lang:no\";}', '1');
INSERT INTO `options` VALUES ('use_captcha', 'true', 'captcha', 'dropdown', 'a:2:{s:4:\"true\";s:8:\"lang:yes\";s:5:\"false\";s:7:\"lang:no\";}', '1');
INSERT INTO `options` VALUES ('use_gravatar', 'false', 'users', 'dropdown', 'a:2:{s:4:\"true\";s:8:\"lang:yes\";s:5:\"false\";s:7:\"lang:no\";}', '1');
INSERT INTO `options` VALUES ('use_recaptcha', 'false', 'captcha', 'dropdown', 'a:2:{s:4:\"true\";s:8:\"lang:yes\";s:5:\"false\";s:7:\"lang:no\";}', '1');

-- ----------------------------
-- Table structure for relations
-- ----------------------------
DROP TABLE IF EXISTS `relations`;
CREATE TABLE `relations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `guid_from` bigint(20) unsigned NOT NULL DEFAULT '0',
  `guid_to` bigint(20) unsigned NOT NULL DEFAULT '0',
  `relation` varchar(100) NOT NULL,
  `created_at` int(11) unsigned NOT NULL DEFAULT '0',
  `updated_at` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of relations
-- ----------------------------

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(11) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of sessions
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `guid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `gender` enum('unspecified','male','female') NOT NULL DEFAULT 'unspecified',
  `online` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`guid`),
  UNIQUE KEY `unique_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'admin@skeleton.io', '$2y$10$7uGxbijTiPfVvoTRZ1L2wuY5I7g6SxN8Yep4XbMFhDASy5tOBLo.i', 'Admin', 'Skeleton', 'male', '0');

-- ----------------------------
-- Table structure for variables
-- ----------------------------
DROP TABLE IF EXISTS `variables`;
CREATE TABLE `variables` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `guid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL,
  `value` longtext,
  `params` longtext,
  `created_at` int(11) unsigned NOT NULL DEFAULT '0',
  `updated_at` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_values` (`guid`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of variables
-- ----------------------------
