/*
Navicat MySQL Data Transfer

Source Server         : 本地数据库
Source Server Version : 50726
Source Host           : 127.0.0.1:3306
Source Database       : eyou_000

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2023-11-27 08:47:32
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for #@__weapp_applets_ad_content
-- ----------------------------
DROP TABLE IF EXISTS `#@__weapp_applets_ad_content`;
CREATE TABLE `#@__weapp_applets_ad_content` (
  `content_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '广告内容ID',
  `position_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '广告位ID',
  `host_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '广告链接分组ID',
  `link_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '内置商城链接ID or 系统商品分类ID or 系统商品ID',
  `content_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '广告内容类型(1:图片类型)',
  `content_title` varchar(100) NOT NULL DEFAULT '' COMMENT '广告内容名称',
  `content_images` varchar(255) NOT NULL DEFAULT '' COMMENT '广告内容图片地址',
  `content_intro` text NOT NULL COMMENT '广告内容描述',
  `sort_order` int(10) DEFAULT '0' COMMENT '排序号',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '新增时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`content_id`),
  KEY `position_id` (`position_id`) USING BTREE,
  KEY `link_id` (`link_id`) USING BTREE,
  KEY `host_id` (`host_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='小程序插件-广告内容';

-- ----------------------------
-- Records of #@__weapp_applets_ad_content
-- ----------------------------
INSERT INTO `#@__weapp_applets_ad_content` VALUES ('1', '1', '0', '0', '1', '幻灯片', '/weapp/Suibian/template/skin/images/1-1.png', '', '0', '1700789503', '1700789503');
INSERT INTO `#@__weapp_applets_ad_content` VALUES ('2', '1', '0', '0', '1', '幻灯片', '/weapp/Suibian/template/skin/images/1-2.jpg', '', '0', '1700789503', '1700789503');
INSERT INTO `#@__weapp_applets_ad_content` VALUES ('3', '1', '0', '0', '1', '幻灯片', '/weapp/Suibian/template/skin/images/1-3.jpg', '', '0', '1700789503', '1700789503');
INSERT INTO `#@__weapp_applets_ad_content` VALUES ('4', '1', '0', '0', '1', '幻灯片', '/weapp/Suibian/template/skin/images/1-4.jpg', '', '0', '1700789503', '1700789503');
INSERT INTO `#@__weapp_applets_ad_content` VALUES ('5', '2', '0', '0', '1', '精品服饰', '/weapp/Suibian/template/skin/images/jingpinnanzhuang.png', '', '0', '1700789503', '1700789503');
INSERT INTO `#@__weapp_applets_ad_content` VALUES ('6', '2', '0', '0', '1', '精品家居', '/weapp/Suibian/template/skin/images/jiazhuangjiafang.png', '', '0', '1700789503', '1700789503');
INSERT INTO `#@__weapp_applets_ad_content` VALUES ('7', '2', '0', '0', '1', '生活家电', '/weapp/Suibian/template/skin/images/xuexiyongpin.png', '', '0', '1700789503', '1700789503');
INSERT INTO `#@__weapp_applets_ad_content` VALUES ('8', '2', '0', '0', '1', '节日礼物', '/weapp/Suibian/template/skin/images/jieqingliwu.png', '', '0', '1700789503', '1700789503');
INSERT INTO `#@__weapp_applets_ad_content` VALUES ('9', '2', '0', '0', '1', '家装建材', '/weapp/Suibian/template/skin/images/meishishengxian.png', '', '0', '1700789503', '1700789503');
INSERT INTO `#@__weapp_applets_ad_content` VALUES ('10', '2', '0', '0', '1', '手机数码', '/weapp/Suibian/template/skin/images/shumachanpin.png', '', '0', '1700789503', '1700789503');
INSERT INTO `#@__weapp_applets_ad_content` VALUES ('11', '2', '0', '0', '1', '个人洗护', '/weapp/Suibian/template/skin/images/meizhuangbaojian.png', '', '0', '1700789503', '1700789503');
INSERT INTO `#@__weapp_applets_ad_content` VALUES ('12', '2', '0', '0', '1', '母婴用品', '/weapp/Suibian/template/skin/images/muyingyongpin.png', '', '0', '1700789503', '1700789503');
INSERT INTO `#@__weapp_applets_ad_content` VALUES ('13', '3', '0', '0', '1', 'banner', '/weapp/Suibian/template/skin/images/banner.jpg', '', '0', '1700789503', '1700789503');

-- ----------------------------
-- Table structure for #@__weapp_applets_ad_link
-- ----------------------------
DROP TABLE IF EXISTS `#@__weapp_applets_ad_link`;
CREATE TABLE `#@__weapp_applets_ad_link` (
  `link_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `host_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '广告链接主体ID',
  `host_title` varchar(60) NOT NULL DEFAULT '' COMMENT '广告链接主体标题',
  `link_names` varchar(60) NOT NULL DEFAULT '' COMMENT '广告链接名称',
  `link_paths` varchar(60) NOT NULL DEFAULT '' COMMENT '广告链接路径',
  `link_url` varchar(150) DEFAULT '' COMMENT 'h5端URL',
  `sort_order` int(10) DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态(1:启用; 2:禁用)',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '新增时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='小程序插件-广告链接';

-- ----------------------------
-- Records of #@__weapp_applets_ad_link
-- ----------------------------
INSERT INTO `#@__weapp_applets_ad_link` VALUES ('1', '1', '基础链接', '主页', '/pages/index/index', '', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_ad_link` VALUES ('2', '1', '基础链接', '购物车', '/pages/flow/index', '', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_ad_link` VALUES ('3', '1', '基础链接', '商品分类', '/pages/category/index', '', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_ad_link` VALUES ('4', '1', '基础链接', '领券中心', '/otherpages/mall/coupon/index', '', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_ad_link` VALUES ('5', '1', '基础链接', '积分商城', '/otherpages/points_shop/index', '', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_ad_link` VALUES ('6', '2', '会员中心', '会员中心', '/pages/user/index', '', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_ad_link` VALUES ('7', '2', '会员中心', '全部订单', '/otherpages/mall/order/index', '', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_ad_link` VALUES ('8', '2', '会员中心', '待付款订单', '/otherpages/mall/order/index?type=payment', '', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_ad_link` VALUES ('9', '2', '会员中心', '待发货订单', '/otherpages/mall/order/index?type=delivery', '', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_ad_link` VALUES ('10', '2', '会员中心', '待收货订单', '/otherpages/mall/order/index?type=received', '', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_ad_link` VALUES ('11', '2', '会员中心', '已完成订单', '/otherpages/mall/order/index?type=complete', '', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_ad_link` VALUES ('12', '2', '会员中心', '退款订单', '/otherpages/mall/order/service/index', '', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_ad_link` VALUES ('13', '2', '会员中心', '个人资料', '/otherpages/user/edit/index', '', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_ad_link` VALUES ('14', '2', '会员中心', '我的余额', '/otherpages/user/wallet/withdrawal/index', '', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_ad_link` VALUES ('15', '2', '会员中心', '我的积分', '/otherpages/user/pointsDetail', '', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_ad_link` VALUES ('16', '2', '会员中心', '我的优惠券', '/otherpages/user/coupon/index', '', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_ad_link` VALUES ('17', '2', '会员中心', '收货地址', '/otherpages/mall/address/index', '', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_ad_link` VALUES ('18', '3', '商品列表', '商品列表', '', '', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_ad_link` VALUES ('19', '4', '分类管理', '分类管理', '', '', '100', '1', '0', '0');

-- ----------------------------
-- Table structure for #@__weapp_applets_ad_position
-- ----------------------------
DROP TABLE IF EXISTS `#@__weapp_applets_ad_position`;
CREATE TABLE `#@__weapp_applets_ad_position` (
  `position_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '广告位ID',
  `position_title` varchar(100) NOT NULL DEFAULT '' COMMENT '广告位名称',
  `position_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '广告位类型(1:图片类型)',
  `position_intro` text NOT NULL COMMENT '广告位描述',
  `system` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否系统广告位(0:否; 1:是)',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '广告位状态(0:关闭; 1:开启)',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '新增时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`position_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='小程序插件-广告位';

-- ----------------------------
-- Records of #@__weapp_applets_ad_position
-- ----------------------------
INSERT INTO `#@__weapp_applets_ad_position` VALUES ('1', '幻灯片', '1', 'aaaaaaaaaaaaaaaaaaa', '1', '1', '1700789503', '1700789503');
INSERT INTO `#@__weapp_applets_ad_position` VALUES ('2', '金刚位', '1', '', '1', '1', '1700789503', '1700789503');
INSERT INTO `#@__weapp_applets_ad_position` VALUES ('3', 'banner', '1', '', '1', '1', '1700789503', '1700789503');

-- ----------------------------
-- Table structure for #@__weapp_applets_bottom_nav
-- ----------------------------
DROP TABLE IF EXISTS `#@__weapp_applets_bottom_nav`;
CREATE TABLE `#@__weapp_applets_bottom_nav` (
  `nav_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `host_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '广告链接分组ID',
  `link_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '内置商城链接ID or 系统商品分类ID or 系统商品ID',
  `nav_title` varchar(100) NOT NULL DEFAULT '' COMMENT '导航标题',
  `default_pic` varchar(100) NOT NULL DEFAULT '' COMMENT '默认图标',
  `selected_pic` varchar(100) NOT NULL DEFAULT '' COMMENT '选中图标',
  `sort_order` int(10) unsigned NOT NULL DEFAULT '100' COMMENT '排序',
  `system` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否系统默认导航(0:否; 1:是)',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态(1:启用; 2:禁用)',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '新增时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`nav_id`),
  KEY `host_id` (`host_id`) USING BTREE,
  KEY `link_id` (`link_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='小程序插件-底部导航';

-- ----------------------------
-- Records of #@__weapp_applets_bottom_nav
-- ----------------------------
INSERT INTO `#@__weapp_applets_bottom_nav` VALUES ('1', '1', '1', '首页', '/weapp/Suibian/template/skin/images/icon_index.png', '/weapp/Suibian/template/skin/images/icon_index_fill.png', '100', '1', '1', '1700812473', '1700812473');
INSERT INTO `#@__weapp_applets_bottom_nav` VALUES ('2', '1', '3', '分类', '/weapp/Suibian/template/skin/images/icon_classify.png', '/weapp/Suibian/template/skin/images/icon_classify_fill.png', '100', '1', '1', '1700812473', '1700811389');
INSERT INTO `#@__weapp_applets_bottom_nav` VALUES ('3', '1', '2', '购物车', '/weapp/Suibian/template/skin/images/icon_cart.png', '/weapp/Suibian/template/skin/images/icon_cart_fill.png', '100', '1', '1', '1700812473', '1700807843');
INSERT INTO `#@__weapp_applets_bottom_nav` VALUES ('4', '2', '6', '我的', '/weapp/Suibian/template/skin/images/icon_my.png', '/weapp/Suibian/template/skin/images/icon_my_fill.png', '100', '1', '1', '1700812473', '1700807842');
INSERT INTO `#@__weapp_applets_bottom_nav` VALUES ('5', '0', '0', '', '', '', '100', '0', '1', '1700812473', '1700817507');

-- ----------------------------
-- Table structure for #@__weapp_applets_config_list
-- ----------------------------
DROP TABLE IF EXISTS `#@__weapp_applets_config_list`;
CREATE TABLE `#@__weapp_applets_config_list` (
  `applets_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增',
  `applets_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '小程序类型(1:微信; 2:百度; 3:抖音; 4:待添加)',
  `applets_mark` varchar(50) NOT NULL DEFAULT '' COMMENT '小程序标识(1:微信(weixin); 2:百度(baidu); 3:抖音(toutiao); 4:待添加)',
  `applets_name` varchar(50) NOT NULL DEFAULT '' COMMENT '小程序名称',
  `applets_config` text NOT NULL COMMENT '小程序配置信息，数组以(serialize)序列化存储',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态(0:关闭; 1:开启)',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`applets_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='小程序信息配置';

-- ----------------------------
-- Table structure for #@__weapp_applets_page_paths
-- ----------------------------
DROP TABLE IF EXISTS `#@__weapp_applets_page_paths`;
CREATE TABLE `#@__weapp_applets_page_paths` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '页面路径标题',
  `paths` varchar(100) NOT NULL DEFAULT '' COMMENT '页面路径标题',
  `sort_order` int(10) unsigned NOT NULL DEFAULT '100' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态(1:启用; 2:禁用)',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '新增时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COMMENT='小程序插件-页面路径';

-- ----------------------------
-- Records of #@__weapp_applets_page_paths
-- ----------------------------
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('1', '主页', '/pages/index/index', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('2', '商品分类', '/pages/category/index', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('3', '商品列表', '/pages/category/list', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('4', '购物车', '/pages/flow/index', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('5', '会员中心', '/pages/user/index', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('6', '全部订单', '/otherpages/mall/order/index', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('7', '待付款订单', '/otherpages/mall/order/index?type=payment', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('8', '待发货订单', '/otherpages/mall/order/index?type=delivery', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('9', '待收货订单', '/otherpages/mall/order/index?type=received', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('10', '已完成订单', '/otherpages/mall/order/index?type=complete', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('11', '退款订单', '/otherpages/mall/order/service/index', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('12', '个人资料', '/otherpages/user/edit/index', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('13', '收货地址', '/otherpages/mall/address/index', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('14', '我的余额', '/otherpages/user/wallet/withdrawal/index', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('15', '消费明细', '/otherpages/user/wallet/withdrawal/record', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('16', '会员等级', '/otherpages/user/upgradeMember/upgradeMember', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('17', '领券中心', '/otherpages/mall/coupon/index', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('18', '我的优惠券', '/otherpages/user/coupon/index', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('19', '秒杀列表', '/otherpages/seckill/index', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('20', '签到', '/pages/user/index', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('21', '分销商申请', '/otherpages/dealer/apply', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('22', '分销中心', '/otherpages/dealer/index', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('23', '分销提现', '/otherpages/dealer/withdraw/apply', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('24', '提现明细', '/otherpages/dealer/withdraw/index', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('25', '分销订单', '/otherpages/dealer/order', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('26', '分销商客户', '/otherpages/dealer/subcustomer', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('27', '分销我的下级', '/otherpages/dealer/subordinate', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('28', '推广海报', '/otherpages/dealer/qrcode', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('29', '分销佣金明细', '/otherpages/dealer/money', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('30', '积分商城', '/otherpages/points_shop/index', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('31', '积分明细', '/otherpages/points_shop/pointsDetails', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('32', '积分规则', '/otherpages/points_shop/rule', '100', '1', '0', '0');
INSERT INTO `#@__weapp_applets_page_paths` VALUES ('33', '核销台', '/otherpages/mall/order/verification', '100', '1', '0', '0');
