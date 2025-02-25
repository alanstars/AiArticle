/*
Navicat MySQL Data Transfer
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for #@__weapp_ai_article
-- 表字段说明:文章规则生成配置表
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
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `ai_model_name` varchar(100) NOT NULL COMMENT 'AI模型名称',
  `ai_model_identifier` varchar(100) NOT NULL COMMENT 'AI模型标识',
  `article_theme` varchar(255) DEFAULT NULL COMMENT '生成文章主题',
  `status` tinyint(1) unsigned zerofill NOT NULL DEFAULT '0' COMMENT '生成状态：1=>已完成；0=>未完成',
  `article_language` varchar(50) DEFAULT 'zh' COMMENT '文章语言',
  `article_count` int(11) DEFAULT '1' COMMENT '生成文章数量',
  `bind_column_id` int(11) DEFAULT NULL COMMENT '要绑定的栏目ID',
  `bind_column_id_lang` varchar(20) DEFAULT NULL COMMENT '绑定的中文栏目ID,逗号或者序列化格式:ID-语言标识',
  `is_translate` tinyint(1) DEFAULT '0' COMMENT '是否翻译并发布到其他语言',
  `publish_schedule` text COMMENT '定时发布规则（序列化格式）',
  `publish_count` int(11) DEFAULT '1' COMMENT '每次发布的文章数量，默认为 1',
  `created_time` int(11) NOT NULL COMMENT '创建时间',
  `updated_time` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='AI文章生成配置表';

-- ----------------------------------
-- Table structure for #@__weapp_ai_article_conf
-- 表字段说明:插件全局配置参数
-- ai_model_name: AI 模型的名称。
-- ai_model_identifier: AI 模型的标识符。
-- ai_config_key: AI 配置的密钥。
-- translate_model_name: 翻译模型的名称。
-- translate_model_identifier: 翻译模型的标识符。
-- translate_config_key: 翻译配置的密钥。
-- ----------------------------------
DROP TABLE IF EXISTS `#@__weapp_ai_article_conf`;
CREATE TABLE `#@__weapp_ai_article_conf` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `ai_model_name` varchar(100) NOT NULL COMMENT 'AI模型名称',
  `ai_model_identifier` varchar(100) NOT NULL COMMENT 'AI模型标识',
  `ai_config_key` varchar(255) NOT NULL COMMENT 'AI配置Key',
  `translate_model_name` varchar(100) DEFAULT NULL COMMENT '翻译模型名称',
  `translate_model_identifier` varchar(100) DEFAULT NULL COMMENT '翻译模型标识',
  `translate_config_key` varchar(255) DEFAULT NULL COMMENT '翻译配置Key',
  `created_time` int(11) NOT NULL COMMENT '创建时间',
  `updated_time` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='插件全局配置参数表';

-- ----------------------------
-- Records of #@__weapp_ai_article_lists
-- 生成文章的记录表
-- ----------------------------
-- config_id: 关联的规则 ID，即 #@__weapp_ai_article 的主键ID
-- ai_model_identifier: AI 模型的标识符。
-- category_id: 栏目ID。
-- article_id: 文章ID，如果已发布则更新该 ID。
-- title: 文章标题。
-- content: 文章内容。
-- seo_title: SEO标题。
-- seo_keywords: SEO关键词。
-- seo_description: SEO描述。
-- status: 发布状态(1=已发布，0=未发布)。
-- publish_time: 发布时间。
------------------------------------
DROP TABLE IF EXISTS `#@__weapp_ai_article_lists`;
CREATE TABLE `#@__weapp_ai_article_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `article_theme` varchar(255) NOT NULL DEFAULT '' COMMENT '关联的规则 ID，即 #@__weapp_ai_article 的主键ID',
  `ai_model_identifier` varchar(100) NOT NULL COMMENT 'AI模型标识',
  `typeid` int(11) DEFAULT NULL COMMENT '要发布的栏目 ID',
  `aid` int(11) DEFAULT NULL COMMENT '文章ID，如果已发布则更新该 ID',
  `title` varchar(255) NOT NULL COMMENT '发布的文章标题',
  `content` text NOT NULL COMMENT '发布的文章内容',
  `seo_title` varchar(255) DEFAULT NULL COMMENT '发布的SEO标题',
  `seo_keywords` varchar(255) DEFAULT NULL COMMENT '发布的SEO关键词',
  `seo_description` text COMMENT '发布的SEO描述',
  `status` tinyint(1) DEFAULT '0' COMMENT ' 发布状态(1=已发布，0=未发布)',
  `publish_time` int(11) DEFAULT NULL COMMENT '发布时间',
  `created_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `updated_time` int(11) DEFAULT '0' COMMENT '更新时间',
  `ai_created_time` int(11) DEFAULT '0' COMMENT '调用 ai 的时间',
  `ai_total_tokens` int(10) DEFAULT '0' COMMENT '调用 AI 消耗的 token 数',
  `ai_id` varchar(100) DEFAULT '' COMMENT '调用 AI 的 id，方便查找',
  `finish_reason` varchar(100) DEFAULT '' COMMENT '结束原因：stop 正常',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='AI文章列表';