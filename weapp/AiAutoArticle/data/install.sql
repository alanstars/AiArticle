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
-- Table structure for #@__weapp_ai_auto_article
-- ----------------------------
DROP TABLE IF EXISTS `#@__weapp_ai_auto_article`;
CREATE TABLE `#@__weapp_ai_auto_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT '' COMMENT '网站标题',
  `url` varchar(100) DEFAULT '' COMMENT '网站地址',
  `logo` varchar(255) DEFAULT '' COMMENT '网站LOGO',
  `sort_order` int(11) DEFAULT '0' COMMENT '排序号',
  `target` tinyint(1) DEFAULT '0' COMMENT '是否开启浏览器新窗口',
  `intro` text COMMENT '网站简况',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态(1=显示，0=屏蔽)',
  `add_time` int(11) DEFAULT '0' COMMENT '新增时间',
  `update_time` int(11) DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of #@__weapp_ai_auto_article
-- ----------------------------
INSERT INTO `#@__weapp_ai_auto_article` VALUES ('1', '百度', 'http://www.baidu.com', '', '100', '1', '', '1', '1524975826', '1537585074');
INSERT INTO `#@__weapp_ai_auto_article` VALUES ('2', '腾讯', 'http://www.qq.com', '', '100', '1', '', '1', '1524976095', '1537585061');
INSERT INTO `#@__weapp_ai_auto_article` VALUES ('3', '新浪', 'http://www.sina.com.cn', '', '100', '1', '', '1', '1532414285', '1537585047');
INSERT INTO `#@__weapp_ai_auto_article` VALUES ('4', '小程序开发教程', 'http://www.yiyongtong.com', '', '100', '1', '', '1', '1532414529', '1537585013');
INSERT INTO `#@__weapp_ai_auto_article` VALUES ('5', '素材58', 'http://www.sucai58.com', '', '100', '1', '', '1', '1532414726', '1537585146');



/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : eyoucms_develop

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2023-10-10
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for #@__weapp_ai_auto_article
-- 表字段说明:文章生成规则表
-- ai_model_name: AI 模型的名称。
-- ai_model_identifier: AI 模型的标识符。
-- article_theme: AI 生成的文章的主题。
-- seo_parameters: SEO 参数。
-- article_language: 文章的语言。默认为 'zh'。
-- article_count: 生成的文章数量。默认为 1。
-- bind_column_id: 要绑定的栏目 ID。
-- publish_schedule: 定时发布规则（序列化格式）。如serialize([
--    'interval_days' => 2, -- 发布间隔天数（每隔 2 天）
--    'time' => '15:00',    -- 发布时间（每天 15:00）
--    ]);  
-- publish_count: 每次发布的文章数量，默认为 1。

-- ----------------------------
DROP TABLE IF EXISTS `#@__weapp_ai_auto_article`;
CREATE TABLE `#@__weapp_ai_auto_article` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `ai_model_name` VARCHAR(100) NOT NULL COMMENT 'AI模型名称',
  `ai_model_identifier` VARCHAR(100) NOT NULL COMMENT 'AI模型标识',
  `article_theme` VARCHAR(255) DEFAULT NULL COMMENT '生成文章主题',
  `seo_parameters` TEXT DEFAULT NULL COMMENT 'SEO参数',
  `article_language` VARCHAR(50) DEFAULT 'zh' COMMENT '文章语言',
  `article_count` INT(11) DEFAULT 1 COMMENT '生成文章数量',
  `bind_column_id` INT(11) DEFAULT NULL COMMENT '要绑定的栏目ID',
  --如果多语言，需绑定其他语言对应栏目 ID
  `bind_column_id_lang` VARCHAR(20) DEFAULT NULL COMMENT '绑定的中文栏目ID,逗号或者序列化格式:ID-语言标识',
  --是否翻译并发布到其他语言
  `is_translate` TINYINT(1) DEFAULT 0 COMMENT '是否翻译并发布到其他语言',
  `publish_schedule` TEXT DEFAULT NULL COMMENT '定时发布规则（序列化格式）',
  `publish_count` INT(11) DEFAULT 1 COMMENT '每次发布的文章数量，默认为 1',
  `created_time` INT(11) NOT NULL COMMENT '创建时间',
  `updated_time` INT(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='AI文章和配置表';

-- ----------------------------------
-- Table structure for #@__weapp_ai_auto_article_conf
-- 表字段说明:插件全局配置参数
-- ai_model_name: AI 模型的名称。
-- ai_model_identifier: AI 模型的标识符。
DROP TABLE IF EXISTS `#@_weapp_ai_auto_article_conf`;
CREATE TABLE `#@_weapp_ai_auto_article_conf` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `ai_model_name` VARCHAR(100) NOT NULL COMMENT 'AI模型名称',
  `ai_model_identifier` VARCHAR(100) NOT NULL COMMENT 'AI模型标识',
  `ai_config_key` VARCHAR(255) NOT NULL COMMENT 'AI配置Key',
  --翻译模型名称
  `translate_model_name` VARCHAR(100) DEFAULT NULL COMMENT '翻译模型名称',
  --翻译模型标识
  `translate_model_identifier` VARCHAR(100) DEFAULT NULL COMMENT '翻译模型标识',
  --翻译配置Key
  `translate_config_key` VARCHAR(255) DEFAULT NULL COMMENT '翻译配置Key',
)
-- ----------------------------
-- Records of #@__weapp_ai_auto_article_lists
-- 生成文章的记录表
-- ----------------------------
-- 
DROP TABLE IF EXISTS `#@__weapp_ai_auto_article_lists`;
CREATE TABLE `#@__weapp_ai_auto_article_lists` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `config_id` INT(11) NOT NULL COMMENT '关联的规则 ID，即 #@__weapp_ai_auto_article 的主键ID',
  `ai_model_identifier` VARCHAR(100) NOT NULL COMMENT 'AI模型标识',
  `category_id` INT(11) DEFAULT NULL COMMENT '栏目ID',
  `article_id` INT(11) DEFAULT NULL COMMENT '文章ID，如果已发布则更新该 ID',
  `title` VARCHAR(255) NOT NULL COMMENT '文章标题',
  `content` TEXT NOT NULL COMMENT '文章内容',
  `seo_title` VARCHAR(255) DEFAULT NULL COMMENT 'SEO标题',
  `seo_keywords` VARCHAR(255) DEFAULT NULL COMMENT 'SEO关键词',
  `seo_description` TEXT DEFAULT NULL COMMENT 'SEO描述',
  `status` TINYINT(1) DEFAULT '1' COMMENT ' 发布状态(1=已发布，0=未发布)',
  `publish_time` INT(11) DEFAULT NULL COMMENT '发布时间',
  `created_time` INT(11) NOT NULL COMMENT '创建时间',
  `updated_time` INT(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  FOREIGN KEY (`config_id`) REFERENCES `#@__weapp_ai_auto_article`(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='AI文章和配置表';