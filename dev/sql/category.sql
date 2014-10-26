-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2014-10-23 13:37:44
-- 服务器版本： 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `yincart`
--

-- --------------------------------------------------------

--
-- 表的结构 `category`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=132 ;

--
-- 转存表中的数据 `category`
--

INSERT INTO `category` (`category_id`, `left`, `right`, `root`, `level`, `name`, `label`, `url`, `pic`, `is_show`) VALUES
(1, 1, 32, 1, 1, '内容分类', 0, '', '', 1),
(3, 1, 300, 3, 1, '商品分类', 0, '', '', 1),
(4, 2, 15, 1, 2, '单页分类', 0, '', '', 1),
(5, 16, 19, 1, 2, '文章分类', 0, '', '', 1),
(11, 17, 18, 1, 3, '最新公告', 0, '', '', 1),
(13, 3, 12, 1, 3, '帮助中心', 0, '', '', 0),
(32, 4, 5, 1, 4, '新手上路', 0, '', '', 0),
(33, 6, 7, 1, 4, '购物指南', 0, '', '', 0),
(34, 8, 9, 1, 4, '支付/配送方式', 0, '', '', 0),
(35, 10, 11, 1, 4, '购物条款', 0, '', '', 0),
(40, 1, 2, 40, 1, '商品类型', 0, '', '', 1),
(104, 20, 25, 1, 2, '客服分类', 0, '', '', 0),
(105, 21, 22, 1, 3, '售前咨询', 0, '', '', 0),
(106, 23, 24, 1, 3, '售后咨询', 0, '', '', 0),
(107, 26, 31, 1, 2, '友情链接', 0, '', '', 0),
(108, 27, 28, 1, 3, '国内站', 0, '', '', 0),
(109, 29, 30, 1, 3, '国际站', 0, '', '', 0),
(110, 2, 110, 3, 2, '国内旅游', 1, 'domestic', '/upload/image/20131223/20131223174212_92702.jpg', 0),
(111, 120, 220, 3, 2, '境外旅游', 1, 'inter', '/upload/image/20131223/20131223174212_92702.jpg', 0),
(112, 3, 4, 3, 3, '浪漫海岛', 0, '', '/upload/category/20130429/20130429112344_22142.jpg', 0),
(113, 5, 6, 3, 3, '风情城市', 0, '', '/upload/category/20130429/20130429112353_21672.jpg', 0),
(114, 121, 122, 3, 3, '欧式风情', 0, '', '', 0),
(115, 123, 124, 3, 3, '美洲探险', 0, '', '', 0),
(116, 125, 126, 3, 3, '非洲考古', 0, '', '', 0),
(117, 127, 128, 3, 3, '澳洲徒步', 0, '', '', 0),
(118, 129, 130, 3, 3, '海岛漫步', 0, '', '', 0),
(119, 131, 132, 3, 3, '都市购物', 0, '', '', 0),
(124, 9, 10, 3, 3, '古镇寻缘', 0, '', '/upload/category/20130614/20130614183555_21640.jpg', 0),
(125, 7, 8, 3, 3, '名山大川', 0, '', '/upload/category/20130429/20130429112402_42198.jpg', 0),
(126, 230, 250, 3, 2, '跟团游', 1, 'group', '/upload/item/image/20130623/20130623071018_84506.jpg', 1),
(127, 231, 232, 3, 3, '团队建设', 0, '', '/upload/image/20131223/20131223174212_92702.jpg', 1),
(129, 260, 270, 3, 2, '定制旅游', 2, 'customize', '/upload/page/3/image/20130415/20130415110344_38558.jpg', 1),
(130, 280, 290, 3, 2, '我游我记', 2, 'notebook', '/upload/page/3/image/20130415/20130415110344_32145.png', 1),
(131, 13, 14, 1, 3, '售后服务', 0, '', '', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
