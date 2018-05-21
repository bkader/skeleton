SET FOREIGN_KEY_CHECKS=0;

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
