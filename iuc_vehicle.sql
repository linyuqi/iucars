/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : iucars

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2015-07-22 13:23:00
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `iuc_vehicle`
-- ----------------------------
DROP TABLE IF EXISTS `iuc_vehicle`;
CREATE TABLE `iuc_vehicle` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `info_id` int(10) NOT NULL COMMENT '主表id',
  `author` varchar(20) NOT NULL,
  `avatar` varchar(200) DEFAULT NULL,
  `stat` tinyint(4) NOT NULL DEFAULT '1',
  `content` text NOT NULL,
  `adduser` varchar(30) NOT NULL,
  `addtime` char(11) CHARACTER SET latin1 NOT NULL,
  `edtime` char(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of iuc_vehicle
-- ----------------------------
