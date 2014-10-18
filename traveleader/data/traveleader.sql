-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2014-04-22 07:38:48
-- 服务器版本： 5.5.36
-- PHP Version: 5.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `traveleader`
--
CREATE DATABASE IF NOT EXISTS `traveleader` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `traveleader`;

--
-- 表的结构 `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE IF NOT EXISTS `item` (
  `item_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Item ID',
  `category_id` int(10) unsigned NOT NULL COMMENT 'Category ID',
  `outer_id` varchar(45) DEFAULT NULL,
  `title` varchar(255) NOT NULL COMMENT '名称',
  `stock` int(10) unsigned NOT NULL COMMENT '库存',
  `min_number` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '最少订货量',
  `price` decimal(10,2) unsigned NOT NULL COMMENT '价格',
  `currency` varchar(20) NOT NULL COMMENT '币种',
  `props` longtext NOT NULL COMMENT '商品属性 格式：pid:vid;pid:vid',
  `props_name` longtext NOT NULL COMMENT '商品属性名称。标识着props内容里面的pid和vid所对应的名称。格式为：pid1:vid1:pid_name1:vid_name1;pid2:vid2:pid_name2:vid_name2……(注：属性名称中的冒号":"被转换为："#cln#"; 分号";"被转换为："#scln#" )',
  `desc` longtext NOT NULL COMMENT '描述',
  `cost_intro` longtext NOT NULL COMMENT '旅行费用描述',
  `schedule` longtext NOT NULL COMMENT '行程描述',
  `shipping_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '运费',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否显示',
  `is_promote` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否促销',
  `is_new` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否新品',
  `is_hot` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否热销',
  `is_best` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否精品',
  `click_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击量',
  `wish_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收藏数',
  `review_count` int(10) NOT NULL,
  `deal_count` int(10) NOT NULL,
  `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL COMMENT '更新时间',
  `language` varchar(45) NOT NULL,
  `country` int(10) unsigned NOT NULL,
  `state` int(10) unsigned NOT NULL,
  `city` int(10) unsigned NOT NULL,
  PRIMARY KEY (`item_id`),
  KEY `fk_item_category1_idx` (`category_id`),
  KEY `fk_item_area1_idx` (`country`),
  KEY `fk_item_area2_idx` (`state`),
  KEY `fk_item_area3_idx` (`city`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=61 ;

--
-- 转存表中的数据 `item`
--

INSERT INTO `item` (`item_id`, `category_id`, `outer_id`, `title`, `stock`, `min_number`, `price`, `currency`, `props`, `props_name`, `desc`, `cost_intro`, `schedule`, `shipping_fee`, `is_show`, `is_promote`, `is_new`, `is_hot`, `is_best`, `click_count`, `wish_count`, `review_count`, `deal_count`, `create_time`, `update_time`, `language`, `country`, `state`, `city`) VALUES
(28, 110, '123456', '乐不思蜀家纺新品波点素色双拼三、四件套天丝棉磨毛不掉色不起球', 443, 1, '86.00', '￥', '{"1":"1:2","2":["2:4","2:5"],"3":["3:8"]}', '{"\\u54c1\\u724c":"\\u54c1\\u724c:jackjones","\\u5c3a\\u5bf8":["\\u5c3a\\u5bf8:L","\\u5c3a\\u5bf8:XL"],"\\u989c\\u8272":["\\u989c\\u8272:\\u9ec4\\u8272"]}', '<p>这是个美丽的地方</p>\r\n', '<p>费用包含住宿等</p>\r\n', '{"1":"<p>玩杀人游戏</p>\r\n","2":"<p>玩狼人</p>\r\n","3":"<p>打酱油</p>\r\n"}','0.01', 1, 1, 1, 1, 1, 421, 0, 0, 1, 1388133167, 1398063611, 'zh_cn', 100000, 370000, 371400),
(31, 110, '123456', '特价正品 床上用品四件套 家纺四件套 全棉加厚活性磨毛四件套', 56858, 1, '156.00', '￥', '{"1":"1:1","2":["2:5","2:6"],"3":["3:8","3:9"]}', '{"\\u54c1\\u724c":"\\u54c1\\u724c:GXG","\\u5c3a\\u5bf8":["\\u5c3a\\u5bf8:XL","\\u5c3a\\u5bf8:XXL"],"\\u989c\\u8272":["\\u989c\\u8272:\\u9ec4\\u8272","\\u989c\\u8272:\\u84dd\\u8272"]}', '<p>这是个美丽的地方</p>\r\n', '<p>费用包含住宿等</p>\r\n', '{"1":"<p>玩杀人游戏</p>\r\n","2":"<p>玩狼人</p>\r\n","3":"<p>打酱油</p>\r\n"}', '0.01', 1, 1, 1, 1, 1, 513, 0, 0, 4, 1388133378, 1397711098, 'zh_cn', 100000, 130000, 130700),

-- --------------------------------------------------------
--
-- 表的结构 `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `root` int(10) unsigned DEFAULT NULL,
  `lft` int(10) unsigned NOT NULL,
  `rgt` int(10) unsigned NOT NULL,
  `level` smallint(5) unsigned NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `position` varchar(45) DEFAULT NULL,
  `if_show` tinyint(1) DEFAULT NULL,
  `memo` text,
  PRIMARY KEY (`id`),
  KEY `root` (`root`),
  KEY `lft` (`lft`),
  KEY `rgt` (`rgt`),
  KEY `level` (`level`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- 转存表中的数据 `menu`
--

INSERT INTO `menu` (`id`, `root`, `lft`, `rgt`, `level`, `name`, `url`, `pic`, `position`, `if_show`, `memo`) VALUES
(1, 1, 1, 40, 1, '前台菜单', '', '', '', 1, ''),
(2, 2, 1, 2, 1, '后台菜单', '', '', '', 1, ''),
(3, 1, 2, 3, 2, '顶部导航', '', '', '', 1, ''),
(4, 1, 20, 39, 2, '主目录菜单', '', '', '', 1, ''),
(5, 1, 4, 19, 2, '底部导航', '', '', '', 1, ''),
(6, 1, 21, 22, 3, '首页', 'index.php', '', '', 1, ''),
(7, 1, 23, 24, 3, '上海周边旅游', 'catalog/index?cat=110', '', '', 1, ''),
(8, 1, 25, 26, 3, '国内长线', 'catalog/index?cat=111', NULL, NULL, 1, ''),
(9, 1, 27, 28, 3, '出境旅游', 'catalog/index?cat=112', NULL, NULL, 0, ''),
(10, 1, 29, 30, 3, '跟团游', 'catalog/index?cat=113', NULL, NULL, 0, ''),
(12, 1, 31, 32, 3, '定制旅游', 'catalog/index?cat=114', NULL, NULL, 0, ''),
(13, 1, 33, 34, 3, '新闻', 'post/index', NULL, NULL, 1, ''),
(15, 1, 5, 6, 3, '关于我们', 'page/about', NULL, NULL, 1, ''),
(17, 1, 9, 10, 3, '品质保证', 'page/qualityAssurance', NULL, NULL, 1, ''),
(18, 1, 11, 12, 3, '业务合作', 'page/coop', NULL, NULL, 1, ''),
(19, 1, 13, 14, 3, '隐私声明', 'page/privacy', NULL, NULL, 1, ''),
(20, 1, 15, 16, 3, '加入我们', 'page/join', NULL, NULL, 1, ''),
(21, 1, 17, 18, 3, '联系我们', 'page/contact', NULL, NULL, 1, ''),
(22, 1, 37, 38, 3, '留言', 'feedback/index', NULL, NULL, 1, '');

-- --------------------------------------------------------

--
-- 表的结构 `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `left` int(10) unsigned NOT NULL,
  `right` int(10) unsigned NOT NULL,
  `root` int(10) unsigned NOT NULL,
  `level` int(10) unsigned NOT NULL,
  `name` varchar(200) NOT NULL COMMENT '分类名',
  `label` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `url` varchar(200) NOT NULL COMMENT '分类的url显示',
  `pic` varchar(255) NOT NULL COMMENT '分类图片',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=133 ;

--
-- 转存表中的数据 `category`
--
-- 内容目录结构
-- 商品分类 1 [1,100]
  -- 上海周边旅游（110）[2,20]
     -- 名山胜水（115）[3,4]
     -- 城市风光（116）[5,6]
     -- 古镇休闲（117）[7,8]
     -- 海岛掠影（118）[9,10]
  -- 国内长线（111）[21,40]
  -- 出境旅游（112）[41,60]
  -- 跟团游（113）[61,80]
  -- 订制旅游（113）[81,99]
  
INSERT INTO `category` (`category_id`, `left`, `right`, `root`, `level`, `name`, `label`, `url`, `pic`, `is_show`) VALUES
(1, 1, 32, 1, 1, '内容分类', 0, '', '', 1),
(3, 1, 100, 3, 1, '商品分类', 0, '', '', 1),
(4, 2, 15, 1, 2, '单页分类', 0, '', '', 1),
(5, 16, 19, 1, 2, '文章分类', 0, '', '', 1),
(11, 17, 18, 1, 3, '最新公告', 0, '', '', 1),
(13, 3, 12, 1, 3, '帮助中心', 0, '', '', 0),
(32, 4, 5, 1, 4, '新手上路', 0, '', '', 0),
(33, 6, 7, 1, 4, '旅游指南', 0, '', '', 0),
(34, 8, 9, 1, 4, '支付/配送方式', 0, '', '', 0),
(35, 10, 11, 1, 4, '购物条款', 0, '', '', 0),
(104, 20, 25, 1, 2, '客服分类', 0, '', '', 0),
(107, 26, 31, 1, 2, '友情链接', 0, '', '', 0),
(108, 27, 28, 1, 3, '国内站', 0, '', '', 0),
(109, 29, 30, 1, 3, '国际站', 0, '', '', 0),
(110, 2, 20, 3, 2, '上海周边旅游', 1, 'shanghai', '', 0),
(111, 21, 40, 3, 2, '国内长线', 1, 'guonei', '', 0),
(112, 41, 60, 3, 2, '出境旅游', 1, 'chujing', '', 0),
(113, 61, 80, 3, 2, '跟团游', 1, 'gentuan', '', 0),
(114, 81, 99, 3, 2, '定制旅游', 1, 'dingzhi', '', 0),
(115, 3, 4, 3, 3, '名山胜水', 0, 'mingshan', '', 0),
(116, 5, 6, 3, 3, '城市风光', 0, 'chengshi', '', 0),
(117, 7, 8, 3, 3, '古镇休闲', 0, 'guzhen', '', 0),
(118, 9, 10, 3, 3, '海岛掠影', 0, 'haidao', '', 0);

-- --------------------------------------------------------
--
-- 表的结构 `area`
--

DROP TABLE IF EXISTS `area`;
CREATE TABLE IF NOT EXISTS `area` (
  `area_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `path` varchar(255) NOT NULL,
  `grade` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(45) NOT NULL,
  `language` varchar(20) NOT NULL,
  PRIMARY KEY (`area_id`),
  KEY `fk_area_area1_idx` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=990101 ;

--
-- 转存表中的数据 `area`
--

INSERT INTO `area` (`area_id`, `parent_id`, `path`, `grade`, `name`, `language`) VALUES
(100000, 100000, '100000', 0, '中国', 'mainland'),
(110000, 100000, ',110000', 1, '北京', 'mainland'),
(110001, 110000, ',110000,110001', 2, '坝上草原', 'mainland'),
(110002, 110000, ',110000,110002', 2, '北戴河', 'mainland'),
(110003, 110000, ',110000,110003', 2, '承德', 'mainland'),
(110004, 110000, ',110000,110004', 2, '秦皇岛', 'mainland'),
(110005, 110000, ',110000,110005', 2, '天津', 'mainland'),
(120000, 100000, ',120000', 1, '海南', 'mainland'),
(120001, 120000, ',120000,120001', 2, '海口', 'mainland'),
(120002, 120000, ',120000,120002', 2, '三亚', 'mainland'),
(120003, 120000, ',120000,120003', 2, '西沙', 'mainland'),
(130000, 100000, ',130000', 1, '云南', 'mainland'),
(130001, 130000, ',130000,130001', 2, '昆明', 'mainland'),
(130002, 130000, ',130000,130002', 2, '丽江', 'mainland'),
(130003, 130000, ',130000,130003', 2, '大理', 'mainland'),
(130004, 130000, ',130000,130004', 2, '香格里拉', 'mainland'),
(130005, 130000, ',130000,130005', 2, '西双版纳', 'mainland'),
(130006, 130000, ',130000,130006', 2, '洱海', 'mainland'),
(140000, 100000, ',140000', 1, '福建', 'mainland'),
(140001, 140000, ',140000,140001', 2, '厦门', 'mainland'),
(140002, 140000, ',140000,140002', 2, '武夷山', 'mainland'),
(140003, 140000, ',140000,140003', 2, '大金湖', 'mainland'),
(140004, 140000, ',140000,140004', 2, '永定土楼', 'mainland'),
(140005, 140000, ',140000,140005', 2, '宁德', 'mainland'),
(150000, 100000, ',150000', 1, '四川', 'mainland'),
(150001, 150000, ',150000,150001', 2, '成都', 'mainland'),
(150002, 150000, ',150000,150002', 2, '康定', 'mainland'),
(150003, 150000, ',150000,150003', 2, '峨眉乐山', 'mainland'),
(150004, 150000, ',150000,150004', 2, '九寨沟', 'mainland'),
(150005, 150000, ',150000,150005', 2, '四姑娘山', 'mainland'),
(150006, 150000, ',150000,150006', 2, '黄龙', 'mainland'),

--
-- 表的结构 `payment_method`
--

DROP TABLE IF EXISTS `payment_method`;
CREATE TABLE IF NOT EXISTS `payment_method` (
  `payment_method_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(45) NOT NULL,
  `name` varchar(120) NOT NULL,
  `desc` text NOT NULL,
  `config` text NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_cod` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_online` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '255',
  PRIMARY KEY (`payment_method_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;



--
-- 转存表中的数据 `payment_method`
--

INSERT INTO `payment_method` (`payment_method_id`, `code`, `name`, `desc`, `config`, `enabled`, `is_cod`, `is_online`, `sort_order`) VALUES
(0, '', '货到付款', '', '', 1, 0, 0, 255),
(1, '', '支付宝', '', '', 1, 0, 0, 255),
(2, '', '财付通', '', '', 1, 0, 0, 255);

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- 表的结构 `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL,
  `language` varchar(16) NOT NULL,
  `translation` text,
  PRIMARY KEY (`id`,`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `message`
--

INSERT INTO `message` (`id`, `language`, `translation`) VALUES
(1, 'zh_cn', '注册'),
(2, 'zh_cn', '注册'),
(3, 'zh_cn', '带有星号 * 的是必须的。'),
(4, 'zh_cn', '带有星号 * 的是必须的。'),
(5, 'zh_cn', '不正确的会员名（长度3至20个字符）.'),
(7, 'zh_cn', '不正确的密码（最小长度为4个字符）。'),
(8, 'zh_cn', '不正确的密码（最小长度为4个字符）.'),
(9, 'zh_cn', '会员名已经存在。'),
(10, 'zh_cn', '会员名已经存在。'),
(11, 'zh_cn', 'Email地址已经存在.'),
(13, 'zh_cn', '不正确的符号。（A - Z0- 9）'),
(14, 'zh_cn', '不正确的符号。（A - Z0- 9）'),
(15, 'zh_cn', '重复密码不正确。'),
(16, 'zh_cn', '重复密码不正确。'),
(17, 'zh_cn', 'Id'),
(18, 'zh_cn', 'Id'),
(19, 'zh_cn', '会员名'),
(20, 'zh_cn', '会员名'),
(21, 'zh_cn', '密码'),
(22, 'zh_cn', '密码'),
(23, 'zh_cn', '重复密码'),
(25, 'zh_cn', 'E-mail'),
(26, 'zh_cn', 'E-mail'),
(27, 'zh_cn', '验证码'),
(28, 'zh_cn', '验证码'),
(29, 'zh_cn', '激活码'),
(31, 'zh_cn', '注册日期'),
(32, 'zh_cn', '注册日期'),
(33, 'zh_cn', '上次访问'),
(34, 'zh_cn', '上次访问'),
(35, 'zh_cn', '超级会员'),
(37, 'zh_cn', '状态'),
(38, 'zh_cn', '状态'),
(39, 'zh_cn', '最小密码长度为4的符号。'),
(40, 'zh_cn', '最小密码长度为4的符号。'),
(43, 'zh_cn', '会员ID'),
(44, 'zh_cn', '会员ID'),
(47, 'zh_cn', '请输入上图所显示的字母。'),
(49, 'zh_cn', '字母不区分大小写。'),
(50, 'zh_cn', '字母不区分大小写。'),
(51, 'zh_cn', '注册'),
(52, 'zh_cn', '注册'),
(71, 'zh_cn', '登录'),
(72, 'zh_cn', '登录'),
(73, 'zh_cn', '请填写您的登录凭据，格式如下：'),
(74, 'zh_cn', '请填写您的登录凭据，格式如下：'),
(75, 'zh_cn', '下次记住我'),
(76, 'zh_cn', '下次记住我'),
(77, 'zh_cn', '会员名或邮箱'),
(78, 'zh_cn', '会员名或邮箱'),
(79, 'zh_cn', '忘记密码？'),
(80, 'zh_cn', ' 忘记密码？'),
(84, 'zh_cn', '恢复'),
(85, 'zh_cn', '恢复'),
(86, 'zh_cn', '请输入您的账号或电子邮件地址。'),
(87, 'zh_cn', '请输入您的账号或电子邮件地址。'),
(94, 'zh_cn', '修改密码'),
(95, 'zh_cn', '修改密码'),
(96, 'zh_cn', '旧密码'),
(97, 'zh_cn', '旧密码'),
(98, 'zh_cn', '保存'),
(99, 'zh_cn', '保存');


