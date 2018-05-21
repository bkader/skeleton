SET FOREIGN_KEY_CHECKS=0;

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
