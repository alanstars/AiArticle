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
-- Table structure for #@__weapp_ai_article
-- 表字段说明:
-- ai_model_name: AI 模型的名称。
-- ai_model_identifier: AI 模型的标识符。
-- ai_config_key: AI 配置的密钥。
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
DROP TABLE IF EXISTS `#@__weapp_ai_article`;
CREATE TABLE `#@__weapp_ai_article` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `ai_model_name` VARCHAR(100) NOT NULL COMMENT 'AI模型名称',
  `ai_model_identifier` VARCHAR(100) NOT NULL COMMENT 'AI模型标识',
  `ai_config_key` VARCHAR(255) NOT NULL COMMENT 'AI配置Key',
  `article_theme` VARCHAR(255) DEFAULT NULL COMMENT '生成文章主题',
  `seo_parameters` TEXT DEFAULT NULL COMMENT 'SEO参数',
  `article_language` VARCHAR(50) DEFAULT 'zh' COMMENT '文章语言',
  `article_count` INT(11) DEFAULT 1 COMMENT '生成文章数量',
  `bind_column_id` INT(11) DEFAULT NULL COMMENT '要绑定的栏目ID',
  `publish_schedule` TEXT DEFAULT NULL COMMENT '定时发布规则（序列化格式）',
  `publish_count` INT(11) DEFAULT 1 COMMENT '每次发布的文章数量，默认为 1',
  `created_time` INT(11) NOT NULL COMMENT '创建时间',
  `updated_time` INT(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='AI文章和配置表';

-- ----------------------------
-- Records of #@__weapp_ai_article_lists
-- 生成文章的记录表
-- ----------------------------
-- 
DROP TABLE IF EXISTS `#@__weapp_ai_article_lists`;
CREATE TABLE `#@__weapp_ai_article_lists` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `config_id` INT(11) NOT NULL COMMENT '配置ID，关联主配置表',
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
  FOREIGN KEY (`config_id`) REFERENCES `#@__weapp_ai_article`(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='生成的文章信息表';