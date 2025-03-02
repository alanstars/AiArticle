SET FOREIGN_KEY_CHECKS=0;

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
  `publish_count` int(11) DEFAULT '1' COMMENT '每次发布的文章数量，默认为1',
  `created_time` int(11) NOT NULL COMMENT '创建时间',
  `updated_time` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='AI文章生成配置表';

DROP TABLE IF EXISTS `#@__weapp_ai_article_conf`;
CREATE TABLE `#@__weapp_ai_article_conf` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `ai_model_name` varchar(100) NOT NULL COMMENT 'AI模型名称',
  `ai_model_identifier` varchar(100) NOT NULL COMMENT 'AI模型标识',
  `ai_config_key` varchar(255) NOT NULL COMMENT 'AI配置Key',
  `translate_model_name` varchar(100) DEFAULT '' COMMENT '翻译模型名称',
  `translate_model_identifier` varchar(100) DEFAULT '' COMMENT '翻译模型标识',
  `translate_config_key` varchar(255) DEFAULT '' COMMENT '翻译配置Key',
  `created_time` int(11) NOT NULL COMMENT '创建时间',
  `updated_time` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='插件全局配置参数表';


DROP TABLE IF EXISTS `#@__weapp_ai_article_lists`;
CREATE TABLE `#@__weapp_ai_article_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `article_theme` varchar(255) NOT NULL DEFAULT '' COMMENT '关联的规则 ID，即 #@__weapp_ai_article 的主键ID',
  `ai_model_identifier` varchar(100) NOT NULL COMMENT 'AI模型标识',
  `typeid` int(11) DEFAULT NULL COMMENT '要发布的栏目 ID',
  `aid` int(11) DEFAULT NULL COMMENT '文章ID，如果已发布则更新该 ID',
  `title` varchar(255) NOT NULL COMMENT '发布的文章标题',
  `content` text COMMENT '发布的文章内容',
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