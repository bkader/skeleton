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
INSERT INTO `entities` VALUES ('1', '0', '0', 'user', 'administrator', 'admin', 'english', '2', '1', '0', '1526871009', '0', '0');

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
INSERT INTO `options` VALUES ('active_modules', 'a:0:{}', 'modules', 'text', '', '1');
INSERT INTO `options` VALUES ('active_plugins', 'a:0:{}', 'plugins', 'text', '', '1');
INSERT INTO `options` VALUES ('admin_email', 'admin@localhost', 'email', 'text', '', '1');
INSERT INTO `options` VALUES ('allowed_types', 'gif|png|jpeg|jpg|pdf|doc|txt|docx|xls|zip|rar|xls|mp4', 'upload', 'text', '', '1');
INSERT INTO `options` VALUES ('allow_multi_session', 'true', 'users', 'dropdown', 'a:2:{s:4:\"true\";s:12:\"lang:CSK_YES\";s:5:\"false\";s:11:\"lang:CSK_NO\";}', '1');
INSERT INTO `options` VALUES ('allow_registration', 'true', 'users', 'dropdown', 'a:2:{s:4:\"true\";s:12:\"lang:CSK_YES\";s:5:\"false\";s:11:\"lang:CSK_NO\";}', '1');
INSERT INTO `options` VALUES ('base_controller', 'welcome', 'general', 'dropdown', '', '1');
INSERT INTO `options` VALUES ('email_activation', 'true', 'users', 'dropdown', 'a:2:{s:4:\"true\";s:12:\"lang:CSK_YES\";s:5:\"false\";s:11:\"lang:CSK_NO\";}', '1');
INSERT INTO `options` VALUES ('google_analytics_id', 'UA-XXXXX-Y', 'general', 'text', '', '0');
INSERT INTO `options` VALUES ('google_site_verification', '', 'general', 'text', '', '0');
INSERT INTO `options` VALUES ('language', 'english', 'language', 'dropdown', 'a:2:{s:7:\"english\";s:7:\"english\";s:6:\"french\";s:6:\"french\";}', '1');
INSERT INTO `options` VALUES ('languages', 'a:1:{i:0;s:7:\"english\";}', 'language', 'dropdown', '', '1');
INSERT INTO `options` VALUES ('login_type', 'both', 'users', 'dropdown', 'a:3:{s:4:\"both\";s:13:\"lang:CSK_BOTH\";s:8:\"username\";s:23:\"lang:CSK_INPUT_USERNAME\";s:5:\"email\";s:28:\"lang:CSK_INPUT_EMAIL_ADDRESS\";}', '1');
INSERT INTO `options` VALUES ('mail_protocol', 'mail', 'email', 'dropdown', 'a:3:{s:4:\"mail\";s:4:\"Mail\";s:4:\"smtp\";s:4:\"SMTP\";s:8:\"sendmail\";s:8:\"Sendmail\";}', '1');
INSERT INTO `options` VALUES ('manual_activation', 'false', 'users', 'dropdown', 'a:2:{s:4:\"true\";s:12:\"lang:CSK_YES\";s:5:\"false\";s:11:\"lang:CSK_NO\";}', '1');
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
INSERT INTO `options` VALUES ('smtp_crypto', 'none', 'email', 'dropdown', 'a:3:{s:4:\"none\";s:13:\"lang:CSK_NONE\";s:3:\"ssl\";s:3:\"SSL\";s:3:\"tls\";s:3:\"TLS\";}', '1');
INSERT INTO `options` VALUES ('smtp_host', '', 'email', 'text', '', '0');
INSERT INTO `options` VALUES ('smtp_pass', '', 'email', 'password', '', '0');
INSERT INTO `options` VALUES ('smtp_port', '', 'email', 'text', '', '0');
INSERT INTO `options` VALUES ('smtp_user', '', 'email', 'text', '', '0');
INSERT INTO `options` VALUES ('theme', 'default', 'theme', 'text', '', '1');
INSERT INTO `options` VALUES ('upload_path', 'content/uploads', 'upload', 'text', '', '0');
INSERT INTO `options` VALUES ('use_captcha', 'false', 'captcha', 'dropdown', 'a:2:{s:4:\"true\";s:12:\"lang:CSK_YES\";s:5:\"false\";s:11:\"lang:CSK_NO\";}', '1');
INSERT INTO `options` VALUES ('use_gravatar', 'false', 'users', 'dropdown', 'a:2:{s:4:\"true\";s:12:\"lang:CSK_YES\";s:5:\"false\";s:11:\"lang:CSK_NO\";}', '1');
INSERT INTO `options` VALUES ('use_recaptcha', 'false', 'captcha', 'dropdown', 'a:2:{s:4:\"true\";s:12:\"lang:CSK_YES\";s:5:\"false\";s:11:\"lang:CSK_NO\";}', '1');

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
INSERT INTO `users` VALUES ('1', 'admin@localhost', '$2a$08$MnCsgx3mmz3khvfFfDaEi.BaVS.gXVY/aQ1TmYEJVSAxm3cvfgtQO', 'Admin', 'Skeleton', 'male', '1');

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
