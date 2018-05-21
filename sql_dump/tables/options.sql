SET FOREIGN_KEY_CHECKS=0;

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
