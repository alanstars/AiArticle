/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : eyoucms_develop

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-09-13 14:30:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for #@__weapp_images_to_webp
-- ----------------------------
DROP TABLE IF EXISTS `#@__weapp_images_to_webp`;
CREATE TABLE `#@__weapp_images_to_webp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `originalUrl` varchar(150) DEFAULT NULL COMMENT '原图地址',
  `newUrl` varchar(150) DEFAULT NULL COMMENT '新图地址',
  `title` varchar(100) NOT NULL COMMENT '图片标题',
  `originalSize` bigint(20) NOT NULL COMMENT '原图大小 (字节)',
  `newSize` bigint(20) NOT NULL COMMENT '新图大小 (字节)',
  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  INDEX `idx_title` (`title`),
  INDEX `idx_originalSize` (`originalSize`),
  INDEX `idx_newSize` (`newSize`),
  INDEX `idx_add_time` (`add_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;