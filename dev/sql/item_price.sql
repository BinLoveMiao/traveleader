-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2014-10-24 11:27:55
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
-- 表的结构 `item_price`
--

CREATE TABLE IF NOT EXISTS `item_price` (
  `item_price_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Item Price ID',
  `item_id` int(10) unsigned NOT NULL COMMENT 'Item ID',
  `date` date NOT NULL COMMENT 'Date of Price',
  `price_adult` int(10) unsigned NOT NULL COMMENT '成人价格',
  `price_child` int(10) unsigned NOT NULL,
  `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`item_price_id`),
  KEY `fk_item_price_item1_idx` (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=68 ;

--
-- 转存表中的数据 `item_price`
--

INSERT INTO `item_price` (`item_price_id`, `item_id`, `date`, `price_adult`, `price_child`, `create_time`) VALUES
(60, 28, '2014-10-04', 2800, 2600, 1),
(61, 28, '2014-10-11', 2800, 2600, 2),
(62, 28, '2014-10-18', 2900, 2700, 3),
(63, 28, '2014-10-25', 3000, 2900, 4),
(64, 28, '2014-10-21', 2800, 2600, 6),
(65, 28, '2014-10-22', 2800, 2700, 6),
(66, 28, '2014-10-23', 2800, 2700, 7),
(67, 28, '2014-10-24', 2800, 2700, 8),
(68, 28, '2014-10-25', 2800, 2700, 7),
(69, 28, '2014-10-26', 2800, 2700, 7),
(70, 28, '2014-10-27', 2800, 2700, 7),
(71, 28, '2014-10-28', 2800, 2700, 7),
(72, 28, '2014-10-29', 2800, 2700, 7),
(73, 28, '2014-10-30', 2800, 2700, 7),
(74, 28, '2014-10-31', 2800, 2700, 7),
(75, 28, '2014-11-01', 2800, 2700, 7),
(76, 28, '2014-11-02', 2800, 2700, 7),
(77, 28, '2014-11-03', 2800, 2700, 7),
(78, 28, '2014-11-04', 2800, 2700, 7),
(79, 28, '2014-11-05', 2800, 2700, 7),
(80, 28, '2014-11-06', 2800, 2700, 7),
(81, 28, '2014-11-07', 2800, 2700, 7),
(82, 28, '2014-11-08', 2800, 2700, 7),
(83, 28, '2014-11-09', 2800, 2700, 7),
(84, 28, '2014-11-10', 2800, 2700, 7),
(85, 28, '2014-11-11', 2800, 2700, 7),
(86, 28, '2014-11-12', 2800, 2700, 7);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
