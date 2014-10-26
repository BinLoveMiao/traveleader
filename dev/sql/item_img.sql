-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2014-10-23 13:37:24
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
-- 表的结构 `item_img`
--

CREATE TABLE IF NOT EXISTS `item_img` (
  `item_img_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Item Img ID',
  `item_id` int(10) unsigned NOT NULL COMMENT 'Item ID',
  `pic` varchar(255) NOT NULL COMMENT '图片url',
  `position` tinyint(3) unsigned NOT NULL COMMENT '图片位置',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`item_img_id`),
  KEY `fk_item_img_item1_idx` (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100 ;

--
-- 转存表中的数据 `item_img`
--

INSERT INTO `item_img` (`item_img_id`, `item_id`, `pic`, `position`, `create_time`) VALUES
(6, 28, '/upload/item/travel/2014-10-211400638577_l.jpg', 0, 1397456645),
(7, 28, '/upload/item/travel/2014-10-141394765954_l.jpg', 1, 1397456645),
(8, 28, '/upload/item/travel/2014-05-111402478875_l.jpg', 2, 1397456645),
(9, 28, '/upload/item/travel/2012-09-211345555389_l.jpg', 3, 1397456645),
(10, 31, '/upload/item/manclothes/01.jpg', 0, 1397456751),
(12, 31, '/upload/item/manclothes/02.jpg', 2, 1397456751),
(13, 31, '/upload/item/manclothes/03.jpg', 3, 1397456751),
(14, 35, '/upload/item/manclothes/T1vyPGFhxeXXXXXXXX_!!0-item_pic.jpg_460x460q90.jpg', 0, 1397456918),
(15, 35, '/upload/item/manclothes/T20I8eXC4aXXXXXXXX_!!454291526.jpg_460x460.jpg', 1, 1397456918),
(16, 35, '/upload/item/manclothes/T2s6OgXAlaXXXXXXXX_!!454291526.jpg_460x460.jpg', 2, 1397456918),
(17, 35, '/upload/item/manclothes/T2UGNdXaxOXXXXXXXX_!!454291526.jpg_460x460.jpg', 3, 1397456918),
(18, 35, '/upload/item/manclothes/T2wWGPXihbXXXXXXXX_!!454291526.jpg_460x460.jpg', 4, 1397456918),
(21, 37, '/upload/item/manclothes/1015622205-1_u_1.jpg', 0, 1397456973),
(23, 37, '/upload/item/manclothes/1015622205-2_u_1.jpg', 1, 1397456973),
(24, 37, '/upload/item/manclothes/1015622205-3_u_1.jpg', 2, 1397456973),
(25, 37, '/upload/item/manclothes/1015622205-4_u_1.jpg', 3, 1397456973),
(26, 38, '/upload/item/manclothes/T2BcmrXutaXXXXXXXX-454291526.jpg', 0, 1397457072),
(27, 38, '/upload/item/manclothes/T2OBysXq0aXXXXXXXX-454291526.jpg', 1, 1397457072),
(28, 38, '/upload/item/manclothes/T2mL5ZXjhbXXXXXXXX-454291526.jpg', 2, 1397457072),
(29, 38, '/upload/item/manclothes/T2SjCoXtBXXXXXXXXX-454291526.jpg', 3, 1397457072),
(30, 49, '/upload/item/manclothes/1.jpg', 0, 1397457361),
(31, 49, '/upload/item/manclothes/2.jpg', 1, 1397457361),
(32, 49, '/upload/item/manclothes/3.jpg', 2, 1397457361),
(33, 49, '/upload/item/manclothes/4.jpg', 3, 1397457361),
(34, 31, '/upload/item/manclothes/04.jpg', 1, 1397456751),
(35, 50, '/upload/item/manclothes/11.jpeg', 0, 1397457375),
(36, 50, '/upload/item/manclothes/12.jpeg', 1, 1397457375),
(38, 50, '/upload/item/manclothes/13.jpeg', 2, 1397457375),
(39, 50, '/upload/item/manclothes/14.jpg', 3, 1397457375),
(41, 52, '/upload/item/manclothes/21.jpg', 0, 1397457413),
(42, 52, '/upload/item/manclothes/22.jpeg', 1, 1397457413),
(43, 52, '/upload/item/manclothes/23.jpeg', 2, 1397457413),
(44, 52, '/upload/item/manclothes/24.jpg', 3, 1397457413),
(45, 53, '/upload/item/manclothes/31.jpg', 0, 1397457433),
(46, 53, '/upload/item/manclothes/32.jpeg', 1, 1397457433),
(47, 53, '/upload/item/manclothes/33.jpg', 2, 1397457433),
(48, 53, '/upload/item/manclothes/34.jpg', 3, 1397457433),
(50, 57, '/upload/item/manclothes/gi1.jpg', 0, 1397457522),
(51, 57, '/upload/item/manclothes/gi2.jpg', 1, 1397457522),
(52, 57, '/upload/item/manclothes/gi3.jpg', 2, 1397457522),
(53, 57, '/upload/item/manclothes/gi4.jpg', 3, 1397457522),
(54, 58, '/upload/item/manclothes/vi1.jpg', 0, 1397457541),
(55, 58, '/upload/item/manclothes/vi2.jpg', 1, 1397457541),
(56, 58, '/upload/item/manclothes/vi3.jpg', 2, 1397457541),
(57, 58, '/upload/item/manclothes/vi4.jpg', 3, 1397457541),
(59, 59, '/upload/item/manclothes/i.jpg', 0, 1397457618),
(60, 59, '/upload/item/manclothes/ii.jpg', 1, 1397457618),
(61, 59, '/upload/item/manclothes/iii.jpg', 2, 1397457618),
(62, 59, '/upload/item/manclothes/iiii.jpg', 3, 1397457618),
(63, 43, '/upload/item/manclothes/wi1.jpg', 0, 1397457233),
(64, 43, '/upload/item/manclothes/wi2.jpg', 1, 1397457233),
(65, 43, '/upload/item/manclothes/wi3.jpg', 2, 1397457233),
(66, 43, '/upload/item/manclothes/wi4.jpg', 3, 1397457233),
(67, 44, '/upload/item/manclothes/xi1.jpg', 0, 1397457259),
(68, 44, '/upload/item/manclothes/xi2.jpg', 1, 1397457259),
(69, 44, '/upload/item/manclothes/xi3.jpg', 2, 1397457259),
(70, 44, '/upload/item/manclothes/xi4.jpg', 3, 1397457259),
(71, 45, '/upload/item/manclothes/yi1.jpg', 0, 1397457284),
(72, 45, '/upload/item/manclothes/yi2.jpg', 1, 1397457284),
(73, 45, '/upload/item/manclothes/yi3.jpg', 2, 1397457284),
(74, 45, '/upload/item/manclothes/yi4.jpg', 3, 1397457284),
(75, 46, '/upload/item/manclothes/zi1.jpg', 0, 1397457299),
(76, 46, '/upload/item/manclothes/zi2.jpg', 1, 1397457299),
(77, 46, '/upload/item/manclothes/zi3.jpg', 2, 1397457299),
(78, 46, '/upload/item/manclothes/zi4.jpg', 3, 1397457299),
(79, 47, '/upload/item/manclothes/001.jpg', 0, 1397457319),
(80, 47, '/upload/item/manclothes/002.jpg', 1, 1397457319),
(81, 47, '/upload/item/manclothes/003.jpg', 2, 1397457319),
(82, 47, '/upload/item/manclothes/004.jpg', 3, 1397457319),
(83, 48, '/upload/item/manclothes/111.jpg', 0, 1397457341),
(84, 48, '/upload/item/manclothes/112.jpg', 1, 1397457341),
(85, 48, '/upload/item/manclothes/113.jpg', 2, 1397457341),
(86, 48, '/upload/item/manclothes/114.jpg', 3, 1397457341),
(87, 40, '/upload/item/manclothes/301.jpg', 0, 1397457137),
(88, 40, '/upload/item/manclothes/302.jpg', 1, 1397457137),
(89, 40, '/upload/item/manclothes/304.jpg', 3, 1397457137),
(90, 40, '/upload/item/manclothes/303.jpg', 2, 1397457137),
(91, 41, '/upload/item/manclothes/401.jpg', 0, 1397457161),
(92, 41, '/upload/item/manclothes/402.jpg', 1, 1397457161),
(93, 41, '/upload/item/manclothes/403.jpg', 2, 1397457161),
(94, 41, '/upload/item/manclothes/404.jpg', 4, 1397457161),
(95, 42, '/upload/item/manclothes/501.jpg', 0, 1397457182),
(96, 42, '/upload/item/manclothes/502.jpg', 1, 1397457182),
(97, 41, '/upload/item/manclothes/503.jpg', 3, 1397457161),
(98, 42, '/upload/item/manclothes/504.jpg', 3, 1397457182),
(99, 42, '/upload/item/manclothes/503.jpg', 2, 1397457182);

--
-- 限制导出的表
--

--
-- 限制表 `item_img`
--
ALTER TABLE `item_img`
  ADD CONSTRAINT `fk_item_img_item1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
