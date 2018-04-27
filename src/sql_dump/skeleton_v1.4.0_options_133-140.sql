/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 100122
Source Host           : localhost:3306
Source Database       : skeleton

Target Server Type    : MYSQL
Target Server Version : 100122
File Encoding         : 65001

Date: 2018-04-27 07:49:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for options
-- ----------------------------
SET sql_notes = 0;
CREATE TABLE IF NOT EXISTS `options` (
  `name` varchar(100) NOT NULL,
  `value` longtext NOT NULL,
  `tab` varchar(50) NOT NULL DEFAULT '',
  `field_type` varchar(50) NOT NULL DEFAULT 'text',
  `options` varchar(255) NOT NULL DEFAULT '',
  `required` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SET sql_notes = 1;

-- ----------------------------
-- Records of options
-- ----------------------------
INSERT INTO `options` VALUES ('image_large_h', '1024', 'upload', 'number', '', '1');
INSERT INTO `options` VALUES ('image_large_w', '1024', 'upload', 'number', '', '1');
INSERT INTO `options` VALUES ('image_medium_h', '300', 'upload', 'number', '', '1');
INSERT INTO `options` VALUES ('image_medium_w', '300', 'upload', 'number', '', '1');
INSERT INTO `options` VALUES ('image_thumbnail_crop', 'true', 'upload', 'dropdown', 'a:2:{s:4:\"true\";s:8:\"lang:yes\";s:5:\"false\";s:7:\"lang:no\";}', '1');
INSERT INTO `options` VALUES ('image_thumbnail_h', '150', 'upload', 'number', '', '1');
INSERT INTO `options` VALUES ('image_thumbnail_w', '150', 'upload', 'number', '', '1');
INSERT INTO `options` VALUES ('max_height', '0', 'upload', 'number', '', '1');
INSERT INTO `options` VALUES ('max_size', '0', 'upload', 'number', '', '1');
INSERT INTO `options` VALUES ('max_width', '0', 'upload', 'number', '', '1');
INSERT INTO `options` VALUES ('min_height', '0', 'upload', 'number', '', '1');
INSERT INTO `options` VALUES ('min_width', '0', 'upload', 'number', '', '1');
INSERT INTO `options` VALUES ('plugins', 'a:0:{}', 'plugin', 'text', '', '1');
INSERT INTO `options` VALUES ('upload_year_month', 'true', 'upload', 'dropdown', 'a:2:{s:4:\"true\";s:8:\"lang:yes\";s:5:\"false\";s:7:\"lang:no\";}', '1');
