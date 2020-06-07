-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2020 at 12:18 AM
-- Server version: 5.7.20
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `increase_decrease_delete_BasketItems` (`inid` INT, `instatus` INT) RETURNS INT(11) NO SQL
begin
if(instatus = 1) THEN
          IF  ((select qty from basket_items where basket_items.id= inid) > 1 ) THEN
            update basket_items set basket_items.qty = (basket_items.qty - 1)  where basket_items.id= inid;
RETURN -1;
          ELSE 
            DELETE from basket_items WHERE basket_items.id= inid;
RETURN 0;
          END IF;
ELSE 
    update basket_items set basket_items.qty = (basket_items.qty + 1) where basket_items.id= inid;
RETURN +1;
END IF;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `attribute`
--

CREATE TABLE `attribute` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attribute`
--

INSERT INTO `attribute` (`id`, `name`, `date`) VALUES
(1, 'اللون', '2020-05-21 00:59:20'),
(2, 'القياس', '2020-05-21 01:20:46'),
(3, 'التصميم', '2020-05-22 00:32:22');

-- --------------------------------------------------------

--
-- Table structure for table `attribute_config`
--

CREATE TABLE `attribute_config` (
  `id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `value` varchar(200) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attribute_config`
--

INSERT INTO `attribute_config` (`id`, `attribute_id`, `value`, `date`) VALUES
(1, 1, 'أحمر', '2020-05-24 19:06:54'),
(2, 1, 'اخضر', '2020-05-24 19:06:57'),
(3, 1, 'اصفر', '2020-05-24 19:07:02'),
(4, 1, 'ازرق', '2020-05-24 19:07:06'),
(5, 1, 'اسود', '2020-05-24 19:07:09'),
(6, 1, 'رصاصي', '2020-05-24 19:07:14'),
(7, 1, 'ارجواني', '2020-05-24 19:07:19'),
(8, 1, 'ابيض', '2020-05-24 19:07:25'),
(9, 2, '34', '2020-05-24 19:07:45'),
(10, 2, '36', '2020-05-24 19:07:48'),
(11, 2, '38', '2020-05-24 19:07:53'),
(12, 2, '40', '2020-05-24 19:07:55'),
(13, 2, '42', '2020-05-24 19:08:10'),
(14, 2, '44', '2020-05-24 19:08:11'),
(15, 2, '46', '2020-05-24 19:08:13'),
(16, 2, '48', '2020-05-24 19:08:16'),
(17, 2, '50', '2020-05-24 19:08:21'),
(18, 2, '52', '2020-05-24 19:08:24'),
(19, 2, '56', '2020-05-24 19:08:28'),
(20, 2, '58', '2020-05-24 19:08:32'),
(21, 2, '60', '2020-05-24 19:08:34'),
(22, 3, 'كلاسك', '2020-05-24 19:08:47'),
(23, 3, 'ضيق', '2020-05-24 19:09:26'),
(24, 3, 'واسع', '2020-05-24 19:09:32');

-- --------------------------------------------------------

--
-- Table structure for table `basket`
--

CREATE TABLE `basket` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(200) DEFAULT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `city_id` int(11) DEFAULT '0',
  `town_id` int(11) DEFAULT '0',
  `address` varchar(250) DEFAULT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  `note` varchar(250) DEFAULT NULL,
  `staff_id` int(11) NOT NULL,
  `status` int(11) DEFAULT '0' COMMENT '0 emty 1 fulling  2 ready 3 prepared',
  `total_price` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `basket`
--

INSERT INTO `basket` (`id`, `customer_name`, `customer_phone`, `city_id`, `town_id`, `address`, `date`, `note`, `staff_id`, `status`, `total_price`) VALUES
(5, 'ahmed', '07822877759', 3, 37, '60 street', '2020-06-02 15:53:25', '', 1, 2, 0),
(8, 'محمد علي', '07822816693', 1, 19, NULL, '2020-06-05 16:55:59', '', 40, 0, 0),
(9, 'محمد علي', '07822816693', 1, 19, 'Hillah - 30st - Al Gadeer District', '2020-06-05 16:56:35', '', 40, 0, 0),
(10, 'محمد علي', '07822816693', 1, 19, 'Hillah - 30st - Al Gadeer District', '2020-06-05 16:57:00', '', 40, 0, 0),
(11, 'محمد علي', '07822816693', 1, 19, 'Hillah - 30st - Al Gadeer District', '2020-06-05 16:57:05', '', 40, 0, 0),
(12, 'محمد علي', '07822816693', 1, 19, 'Hillah - 30st - Al Gadeer District', '2020-06-05 16:57:07', '', 40, 0, 0),
(13, 'محمد علي', '07822816693', 1, 19, 'Hillah - 30st - Al Gadeer District', '2020-06-05 16:57:09', '', 40, 0, 0),
(14, '', '', 0, 19, '', '2020-06-07 01:30:55', '', 28, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `basket_items`
--

CREATE TABLE `basket_items` (
  `id` int(11) NOT NULL,
  `configurable_product_id` int(11) NOT NULL,
  `basket_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `qty` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `storage_manager_id` int(11) NOT NULL DEFAULT '0',
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `basket_items`
--

INSERT INTO `basket_items` (`id`, `configurable_product_id`, `basket_id`, `date`, `qty`, `status`, `storage_manager_id`, `staff_id`) VALUES
(46, 1, 5, '2020-06-08 00:03:50', 1, 1, 1, 1),
(47, 62, 5, '2020-06-08 00:04:28', 1, 1, 1, 1),
(48, 62, 14, '2020-06-08 00:41:53', 1, 0, 0, 28);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `des` varchar(500) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `note` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `title`, `parent_id`, `des`, `date`, `note`) VALUES
(1, 'الحاسبات', -1, '', '2019-12-26 10:24:01', ''),
(2, 'الشبكات', 1, '', '2019-12-26 10:57:04', ''),
(3, 'البرامجيات', 1, '', '2019-12-26 10:57:16', ''),
(4, 'تطبيقات الويب', 3, '', '2019-12-26 10:59:31', ''),
(5, 'الهندسة', -1, '', '2019-12-29 09:59:53', ''),
(6, 'ملابس', 3, NULL, '2020-06-08 01:13:28', NULL),
(7, 'بناطيل', 1, NULL, '2020-06-08 01:14:02', NULL),
(8, 'فساتين', 6, NULL, '2020-06-08 01:14:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cites`
--

CREATE TABLE `cites` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `note` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cites`
--

INSERT INTO `cites` (`id`, `name`, `note`) VALUES
(1, 'بغداد', NULL),
(2, 'البصرة', NULL),
(3, 'نينوى', NULL),
(4, 'أربيل', NULL),
(5, 'النجف', NULL),
(6, 'ذي قار', NULL),
(7, 'كركوك', NULL),
(8, 'الأنبار', NULL),
(9, 'ديالى', NULL),
(10, 'المثنى', NULL),
(11, 'القادسية', NULL),
(12, 'ميسان', NULL),
(13, 'واسط', NULL),
(14, 'صلاح الدين', NULL),
(15, 'دهوك', NULL),
(16, 'السليمانية', NULL),
(17, 'بابل', NULL),
(18, 'كربلاء', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `phone` varchar(18) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT '1',
  `password` varchar(250) NOT NULL,
  `token` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `phone`, `email`, `branch_id`, `password`, `token`) VALUES
(1, 'صلاح الدين', '09876544423', NULL, 1, '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `client_dev_price`
--

CREATE TABLE `client_dev_price` (
  `id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `client_dev_price`
--

INSERT INTO `client_dev_price` (`id`, `city_id`, `client_id`, `price`) VALUES
(26, 8, 2, 7000),
(27, 9, 2, 7000),
(28, 10, 2, 7000),
(29, 11, 2, 7000),
(30, 12, 2, 7000),
(31, 13, 2, 7000),
(32, 14, 2, 7000),
(33, 15, 2, 7000),
(34, 16, 2, 7000),
(35, 17, 2, 7000),
(36, 18, 2, 7000),
(55, 1, 4, 5000),
(56, 2, 4, 10000),
(57, 3, 4, 10000),
(58, 4, 4, 10000),
(59, 5, 4, 10000),
(60, 6, 4, 10000),
(61, 7, 4, 10000),
(62, 8, 4, 10000),
(63, 9, 4, 10000),
(64, 10, 4, 10000),
(65, 11, 4, 10000),
(66, 12, 4, 10000),
(67, 13, 4, 10000),
(68, 14, 4, 10000),
(69, 15, 4, 10000),
(70, 16, 4, 10000),
(71, 17, 4, 10000),
(72, 18, 4, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `configurable_product`
--

CREATE TABLE `configurable_product` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `buy_price` double NOT NULL,
  `price` int(11) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `sku` varchar(250) NOT NULL,
  `location` varchar(200) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT '0',
  `sub_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `configurable_product`
--

INSERT INTO `configurable_product` (`id`, `product_id`, `buy_price`, `price`, `image_id`, `qty`, `sku`, `location`, `stock`, `sub_name`) VALUES
(1, 1, 500000, 700000, NULL, 4, '3322143', NULL, 0, ''),
(2, 1, 500000, 700000, NULL, 4, '3322143', NULL, 0, ''),
(3, 1, 500000, 700000, NULL, 4, '3322143', NULL, 0, ''),
(4, 1, 500000, 700000, NULL, 4, '3322143', NULL, 0, ''),
(5, 1, 500000, 700000, NULL, 4, '3322143', NULL, 0, ''),
(6, 1, 500000, 700000, NULL, 4, '3322143', NULL, 0, ''),
(7, 1, 500000, 700000, NULL, 4, '3322143', NULL, 0, ''),
(8, 1, 500000, 700000, NULL, 4, '3322143', NULL, 0, ''),
(9, 1, 500000, 700000, NULL, 4, '3322143', NULL, 0, ''),
(10, 1, 500000, 700000, NULL, 4, '3322143', NULL, 0, ''),
(11, 2, 120000, 150000, NULL, 6, '12324', NULL, 0, ''),
(12, 2, 120000, 150000, NULL, 6, '12324', NULL, 0, ''),
(13, 2, 120000, 150000, NULL, 6, '12324', NULL, 0, ''),
(14, 2, 120000, 150000, NULL, 6, '12324', NULL, 0, ''),
(15, 2, 120000, 150000, NULL, 6, '12324', NULL, 0, ''),
(16, 2, 120000, 150000, NULL, 6, '12324', NULL, 0, ''),
(17, 2, 120000, 150000, NULL, 6, '12324', NULL, 0, ''),
(18, 2, 120000, 150000, NULL, 6, '12324', NULL, 0, ''),
(19, 2, 120000, 150000, NULL, 6, '12324', NULL, 0, ''),
(20, 2, 120000, 150000, NULL, 6, '12324', NULL, 0, ''),
(21, 2, 120000, 150000, NULL, 6, '12324', NULL, 0, ''),
(22, 2, 120000, 150000, NULL, 6, '12324', NULL, 0, ''),
(23, 2, 120000, 150000, NULL, 6, '12324', NULL, 0, ''),
(24, 2, 120000, 150000, NULL, 6, '12324', NULL, 0, ''),
(25, 2, 120000, 150000, NULL, 6, '12324', NULL, 0, ''),
(26, 2, 120000, 150000, NULL, 6, '12324', NULL, 0, ''),
(27, 2, 120000, 150000, NULL, 6, '12324', NULL, 0, ''),
(28, 2, 120000, 150000, NULL, 6, '12324', NULL, 0, ''),
(29, 3, 25, 30, NULL, 4, '25522', NULL, 0, ''),
(30, 3, 25, 30, NULL, 4, '25552', NULL, 0, ''),
(31, 3, 25, 30, NULL, 4, '2522', NULL, 0, ''),
(32, 7, 150000, 120000, NULL, 34, 'Printer-كلاسك', 'A1', 1, 'Printer-كلاسك'),
(33, 7, 150000, 120000, NULL, 34, 'Printer-ضيق', 'A1', 1, 'Printer-ضيق'),
(34, 7, 150000, 120000, NULL, 34, 'Printer-واسع', 'A1', 1, 'Printer-واسع'),
(35, 8, 30000, 18000, NULL, 2, 'Dress-أحمر-34', 'A1', 1, 'Dress-أحمر-34'),
(36, 8, 30000, 18000, NULL, 2, 'Dress-اخضر-34', 'A1', 1, 'Dress-اخضر-34'),
(37, 8, 30000, 18000, NULL, 2, 'Dress-اصفر-34', 'A1', 1, 'Dress-اصفر-34'),
(38, 8, 30000, 18000, NULL, 2, 'Dress-أحمر-36', 'A1', 1, 'Dress-أحمر-36'),
(39, 8, 30000, 18000, NULL, 2, 'Dress-اخضر-36', 'A1', 1, 'Dress-اخضر-36'),
(40, 8, 30000, 18000, NULL, 2, 'Dress-اصفر-36', 'A1', 1, 'Dress-اصفر-36'),
(41, 8, 30000, 18000, NULL, 2, 'Dress-أحمر-38', 'A1', 1, 'Dress-أحمر-38'),
(42, 8, 30000, 18000, NULL, 2, 'Dress-اخضر-38', 'A1', 1, 'Dress-اخضر-38'),
(43, 8, 30000, 18000, NULL, 2, 'Dress-اصفر-38', 'A1', 1, 'Dress-اصفر-38'),
(44, 9, 12000, 24000, NULL, 2, 'Php course-اسود-38', 'a1', 1, 'Php course-اسود-38'),
(45, 9, 12000, 24000, NULL, 2, 'Php course-رصاصي-38', 'a1', 1, 'Php course-رصاصي-38'),
(46, 9, 12000, 24000, NULL, 2, 'Php course-ارجواني-38', 'a1', 1, 'Php course-ارجواني-38'),
(47, 9, 12000, 24000, NULL, 2, 'Php course-اسود-40', 'a1', 1, 'Php course-اسود-40'),
(48, 9, 12000, 24000, NULL, 2, 'Php course-رصاصي-40', 'a1', 1, 'Php course-رصاصي-40'),
(49, 9, 12000, 24000, NULL, 2, 'Php course-ارجواني-40', 'a1', 1, 'Php course-ارجواني-40'),
(50, 9, 12000, 24000, NULL, 2, 'Php course-اسود-42', 'a1', 1, 'Php course-اسود-42'),
(51, 9, 12000, 24000, NULL, 2, 'Php course-رصاصي-42', 'a1', 1, 'Php course-رصاصي-42'),
(52, 9, 12000, 24000, NULL, 2, 'Php course-ارجواني-42', 'a1', 1, 'Php course-ارجواني-42'),
(53, 9, 12000, 24000, NULL, 2, 'Php course-اسود-44', 'a1', 1, 'Php course-اسود-44'),
(54, 9, 12000, 24000, NULL, 2, 'Php course-رصاصي-44', 'a1', 1, 'Php course-رصاصي-44'),
(55, 9, 12000, 24000, NULL, 2, 'Php course-ارجواني-44', 'a1', 1, 'Php course-ارجواني-44'),
(56, 9, 12000, 24000, NULL, 2, 'Php course-اسود-46', 'a1', 1, 'Php course-اسود-46'),
(57, 9, 12000, 24000, NULL, 2, 'Php course-رصاصي-46', 'a1', 1, 'Php course-رصاصي-46'),
(58, 9, 12000, 24000, NULL, 2, 'Php course-ارجواني-46', 'a1', 1, 'Php course-ارجواني-46'),
(59, 9, 12000, 24000, NULL, 2, 'Php course-اسود-48', 'a1', 1, 'Php course-اسود-48'),
(60, 9, 12000, 24000, NULL, 2, 'Php course-رصاصي-48', 'a1', 1, 'Php course-رصاصي-48'),
(61, 9, 12000, 24000, NULL, 1, 'Php course-ارجواني-48', 'a1', 1, 'Php course-ارجواني-48'),
(62, 11, 30000, 40000, NULL, -1, 'Office ', 'A5', 0, 'Office ');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `path` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `product_id`, `path`) VALUES
(1, 12, '12/5ec52e8f0cb41.png'),
(2, 12, '12/5ec52e8f0d87c.png'),
(3, 13, '13/5ec52ea77027c.png'),
(4, 13, '13/5ec52ea77134d.png'),
(5, 14, '14/5eca9b1096f51.png'),
(6, 1, '1/5eca9da7f2403.jpg'),
(7, 2, '2/5ecada231fd6c.jpg'),
(8, 3, '3/5ed3b864710be.png'),
(9, 4, '4/5ed78dbb5a4dc.png'),
(10, 4, '4/5ed78dbb5b33d.png'),
(11, 4, '4/5ed78dbb5bd4e.png'),
(12, 4, '4/5ed78dbb5cf12.png'),
(13, 4, '4/5ed78dbb5da57.png'),
(14, 5, '5/5ed78dc8b82b8.png'),
(15, 5, '5/5ed78dc8b924b.png'),
(16, 5, '5/5ed78dc8b9d98.png'),
(17, 5, '5/5ed78dc8bad77.png'),
(18, 5, '5/5ed78dc8bb8ea.png'),
(19, 6, '6/5ed78ddc590fe.png'),
(20, 6, '6/5ed78ddc5a069.png'),
(21, 6, '6/5ed78ddc5aca8.png'),
(22, 6, '6/5ed78ddc5baac.png'),
(23, 6, '6/5ed78ddc5c4ad.png'),
(24, 7, '7/5ed78e255b9b1.png'),
(25, 7, '7/5ed78e255c3b9.png'),
(26, 7, '7/5ed78e255ce94.png'),
(27, 7, '7/5ed78e255db0c.png'),
(28, 7, '7/5ed78e255e593.png'),
(29, 8, '8/5ed7aa20d309f.png'),
(30, 8, '8/5ed7aa20d3c06.png'),
(31, 9, '9/5ed7ae9d0247d.png'),
(32, 10, '10/5edbc9024f3bd.png'),
(33, 10, '10/5edbc9025003b.png'),
(34, 10, '10/5edbc90250ccb.png'),
(35, 10, '10/5edbc90251a7c.png'),
(36, 10, '10/5edbc902525fc.png'),
(37, 11, '11/5edbc953d12c7.png'),
(38, 11, '11/5edbc953d1e1d.png'),
(39, 11, '11/5edbc953d298b.png'),
(40, 11, '11/5edbc953d3b47.png'),
(41, 11, '11/5edbc953d4700.png');

-- --------------------------------------------------------

--
-- Table structure for table `mandop_stores`
--

CREATE TABLE `mandop_stores` (
  `id` int(11) NOT NULL,
  `mandop_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `manager_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mandop_stores`
--

INSERT INTO `mandop_stores` (`id`, `mandop_id`, `store_id`, `date`, `manager_id`) VALUES
(5, 28, 9, '2020-06-07 00:40:23', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `total_price` int(11) NOT NULL DEFAULT '0',
  `delivery_company_id` int(11) NOT NULL DEFAULT '0',
  `city_id` int(11) NOT NULL,
  `town_id` int(11) NOT NULL,
  `address` varchar(250) DEFAULT NULL,
  `customer_phone` varchar(18) NOT NULL,
  `customer_name` varchar(250) NOT NULL,
  `note` varchar(250) NOT NULL,
  `order_status_id` int(11) NOT NULL DEFAULT '1',
  `money_status` int(11) NOT NULL DEFAULT '0',
  `manager_id` int(11) NOT NULL,
  `order_no` bigint(20) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `confirm` int(11) NOT NULL DEFAULT '1',
  `dev_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `discount` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `total_price`, `delivery_company_id`, `city_id`, `town_id`, `address`, `customer_phone`, `customer_name`, `note`, `order_status_id`, `money_status`, `manager_id`, `order_no`, `staff_id`, `confirm`, `dev_date`, `date`, `discount`) VALUES
(11, 0, 0, 1, 19, 'الكرادة خارج ', '07822816693', 'حسن جاسم', '', 1, 0, 1, 9906986, 1, 1, '2020-06-05 18:44:29', '2020-06-05 19:02:23', 0),
(12, 0, 0, 1, 19, 'المنصور', '07822816693', 'حسن جاسم', '', 1, 0, 1, 3453, 1, 1, '2020-06-05 18:44:29', '2020-06-05 19:02:23', 0),
(13, 0, 0, 1, 19, NULL, '07822816693', 'محمد علي', '', 1, 0, 40, 9906986, 40, 1, '2020-06-05 18:44:29', '2020-06-05 19:02:23', 0),
(14, 0, 0, 1, 19, NULL, '07822816693', 'محمد علي', '', 1, 0, 40, 9906986, 40, 1, '2020-06-05 18:44:29', '2020-06-05 19:02:23', 0),
(15, 0, 0, 9, 42, NULL, '', 'ali', '', 1, 0, 1, 378, 1, 1, '2020-06-05 23:26:30', '2020-06-05 23:26:30', 0),
(16, 0, 0, 6, 40, NULL, '', 'Hasan', '', 1, 0, 1, 797, 1, 1, '2020-06-05 23:31:59', '2020-06-05 23:31:59', 0),
(17, 0, 0, 17, 12, 'Hillah - 30st - Al Gadeer District', '07822816693', 'محمد رضا', '', 1, 0, 1, 1050, 28, 1, '2020-06-07 01:42:30', '2020-06-07 01:42:30', 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `configurable_product_id` int(11) NOT NULL,
  `price` double DEFAULT '0',
  `discount` double DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_id` int(11) NOT NULL,
  `storage_manager_id` int(11) DEFAULT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `configurable_product_id`, `price`, `discount`, `qty`, `date`, `order_id`, `storage_manager_id`, `staff_id`) VALUES
(1, 1, 0, NULL, 3, '2020-06-05 00:50:19', 11, NULL, 0),
(2, 1, 1, NULL, 2, '2020-06-05 00:55:10', 12, NULL, 0),
(3, 3, 40, NULL, 1, '2020-06-05 18:30:21', 13, NULL, 40),
(4, 3, 40, NULL, 1, '2020-06-05 18:30:21', 13, NULL, 40),
(5, 1, 40, NULL, 1, '2020-06-05 18:33:19', 14, NULL, 40),
(6, 1, 1, NULL, 1, '2020-06-05 23:26:30', 15, NULL, 1),
(7, 2, 1, NULL, 1, '2020-06-05 23:26:30', 15, NULL, 1),
(8, 2, 1, NULL, 1, '2020-06-05 23:26:31', 15, NULL, 1),
(9, 2, 1, NULL, 1, '2020-06-05 23:26:31', 15, NULL, 1),
(10, 2, 1, NULL, 1, '2020-06-05 23:26:31', 15, NULL, 1),
(11, 2, 1, NULL, 1, '2020-06-05 23:26:31', 15, NULL, 1),
(12, 2, 1, NULL, 1, '2020-06-05 23:26:31', 15, NULL, 1),
(13, 2, 1, NULL, 1, '2020-06-05 23:26:31', 15, NULL, 1),
(14, 2, 1, NULL, 1, '2020-06-05 23:26:31', 15, NULL, 1),
(15, 2, 1, NULL, 1, '2020-06-05 23:26:31', 15, NULL, 1),
(16, 60, 1, NULL, 1, '2020-06-05 23:26:31', 15, NULL, 1),
(17, 60, 1, NULL, 1, '2020-06-05 23:26:31', 15, NULL, 1),
(18, 60, 1, NULL, 1, '2020-06-05 23:26:31', 15, NULL, 1),
(19, 60, 1, NULL, 1, '2020-06-05 23:26:31', 15, NULL, 1),
(20, 60, 1, NULL, 1, '2020-06-05 23:26:31', 15, NULL, 1),
(21, 61, 1, NULL, 1, '2020-06-05 23:31:59', 16, NULL, 1),
(22, 62, 28, NULL, 1, '2020-06-07 01:42:30', 17, NULL, 1),
(23, 62, 28, NULL, 1, '2020-06-07 01:42:30', 17, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `id` int(11) NOT NULL,
  `status` varchar(200) NOT NULL,
  `note` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`id`, `status`, `note`) VALUES
(1, 'تم تسجيل الطلب', '/'),
(2, 'جاهز للارسال', ''),
(3, 'بالطريق مع المندوب', ''),
(4, 'تم تسليم الطلب', ''),
(5, 'استبدال الطلب', ''),
(6, 'راجع جزئي', ''),
(7, 'مؤجل ', ''),
(8, 'تغير عنوان', ''),
(9, 'راحع كلي', 'لن تكون هناك اجرة توصيل'),
(10, 'راجع بمخزن المحافظه', ''),
(11, 'راجع بالمخزن الرئيسي', ''),
(12, 'راجع للعميل', ''),
(13, 'واصل جزئي', ''),
(14, 'واصل جزئي', '');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `type` int(1) NOT NULL COMMENT '1 simple 2 configurable',
  `des` varchar(3000) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `simple_des` varchar(250) DEFAULT NULL,
  `store_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `type`, `des`, `category_id`, `simple_des`, `store_id`) VALUES
(1, 'HP Computer', 2, NULL, 1, 'Good Quality ', 0),
(2, 'Dell', 2, NULL, 1, '', 0),
(3, 'lklkl', 2, NULL, 3, 'kjlkj', 0),
(4, 'Printer', 2, NULL, 1, '', 0),
(5, 'Printer', 2, NULL, 1, '', 0),
(6, 'Printer', 2, NULL, 1, '', 0),
(7, 'Printer', 2, NULL, 1, '', 0),
(8, 'Dress', 2, NULL, 1, '', 0),
(9, 'Php course', 2, NULL, 2, 'this course is going to be provided for advances web developers', 0),
(10, 'Office ', 1, 'some data', 3, 'word Excel', 9),
(11, 'Office ', 1, 'some data', 3, 'word Excel', 9);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'مدير الشركة'),
(2, 'محاسب'),
(3, 'موظف'),
(4, 'مندوب'),
(5, 'مدير مخزن'),
(6, 'موظف طؤرئ');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `phone` varchar(18) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `id_copy` varchar(100) NOT NULL DEFAULT 'defult.png',
  `employee_id` int(11) DEFAULT NULL,
  `phone_2` varchar(18) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(250) DEFAULT ' ',
  `account_type` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1',
  `token` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `name`, `phone`, `branch_id`, `id_copy`, `employee_id`, `phone_2`, `role_id`, `password`, `email`, `account_type`, `status`, `token`) VALUES
(1, 'Mohammed Mohammed', '07822816693', 1, '1/5e56c045a3ef7.jpg', NULL, NULL, 1, '$2a$07$7hbl9LryvI8nNRgpADKis.zCWKu7x4VkqMlVXYvTxOz1R8YwOI1Ya', 'mohammed.mrm4@gmail.com', 0, 1, 'dARV6p02B97sZVZdnTLg4v:APA91bEfrRQ_P84hwuR5Ba0lo4aukuGaiJBsNrV9VH-90OnEsJ3qkuANEC8pHXpktMbOU-wjCCpbyaWFoBjka18AQ7VDQ7ad03HlfF_rX-NOi5fGn4Ap2bBxtifpgs59SY1P-tiq8SgZ'),
(6, 'Ali Mohammed Redha', '07822816695', 1, 'defult.png	', NULL, NULL, 6, '$2a$07$ABkq4GIgHOksKNa0LULD6.GoyLRv6Y4htk7IFECi/HFaiD7AKbhNy', '', 2, 0, NULL),
(7, 'مرتضى عباس', '07822816694', 1, 'defult.png', NULL, NULL, 6, '$2a$07$ASDiur1hLSVGu3DGEervgOe2nltbk4ocXWUdiZRDcOOcbknoh/rgq', ' ', 2, 0, NULL),
(25, 'محمد حمزه', '07804006681', 1, '1/5eb3b18f74146.jpg', NULL, NULL, 5, '$2a$07$e3rDm740vOhPyZ8isRniKONKgKhfy2WKrOTALqEt9IfxV6CwkdnSW', '', 1, 1, 'cQSurNQNS2qMfoHozAMchV:APA91bG1WxW6PEqrNklRwKqwrJ5RxnviPlzRPwKFaSdzjpNVcUOJShBP2xJFRfOajGE2KKMQmC66KllRoah7hgY4HD8LShe2U0idbxX2_cZnb5b2VKD_YcgdisH4_B_zIgqaArTXFn6S'),
(27, 'غفران ', '07715880358', 1, '1/5eb7f7be00ff4.jpg', NULL, NULL, 1, '$2a$07$3T4HJQbdKCWeGblUkdCn2uU6dkAD3GQDdGADiM.s1Jy/doS.bdRka', '', 1, 1, NULL),
(28, 'سائق بغداد', '1234567890', 1, '1/5eb81362b8013.jpg', NULL, NULL, 4, '$2a$07$VjkBWXmoWnc28EvWqCY98ukrW0VZAhBThmZRpgYi9yquksqpeOYjC', '', 1, 1, NULL),
(29, 'صادق', '07723456734', 3, '3/5eb81391d84e6.jpg', NULL, NULL, 4, '$2a$07$TbhrtRXA1QR2XxBFT40viuDhOU7RMMSIv1lsLP69lvTCngom0/y7K', '', 1, 1, NULL),
(30, 'Yousif Ayad', '07721415720', 1, '1/5ebbac36f1f01.jpg', NULL, NULL, 5, '$2a$07$lCYyUeXAHTONlD0764IKh.MCixrSThkbTfojXTUkONzTjixHT3Fl2', '', 1, 1, 'cm0p8R_x4tXOf4HYf6-wdW:APA91bGhb-gStV6EpfkKXK0c0CghXNrHSBZO0mRh2vmVErCOAUsWsZW78RIv5zkQd8xZS5XpTtqqSVEIV4d2l-LYpcYHUwRDIcbSlyikru6WI72UXmJzoyzJnp1hsLzv8bakKjNWPVmT'),
(31, 'علي حسن', '07827134799', 1, '1/5ebbaf3f103a3.jpg', NULL, NULL, 5, '$2a$07$nFTHmgEYcr7YBYNVWiTT6unPgU1Czx6Kl9KpAr37gg6R8Hd1SIEAi', '', 1, 1, NULL),
(32, 'حازم ناظم', '07828899415', 1, '1/5ebbb26d5fc33.jpg', NULL, NULL, 5, '$2a$07$AEJ8CCfx67Cy5nZMlae2zenL4lOV9x/n10AmBdRqHQQzG00ZpI2Du', '', 1, 1, NULL),
(33, 'مصطفى ستور078', '07700770949', 1, '1/5ebbb79b7843f.jpg', NULL, NULL, 5, '$2a$07$fKVGSkt7zkJ6d20ddA0x8ufLhOc3OdY4nfi7bjvqS4bVZkOw8URyS', '', 1, 1, NULL),
(34, 'Ahmed Altememi', '07737725580', 1, '1/5ebbb9b38bbe1.jpg', NULL, NULL, 1, '$2a$07$qS8SVzxVtBeKdMXNrSPfUOtjZcRWOtOU0G2yPOCdvhPU7KQXuj/Dq', '', 1, 1, 'fSUh_hzEAZS5palJ_erFjQ:APA91bHa6w_-IBcWxsKExUXgG_swgxp3YQueE_BpBq-0wskLWRTYh13bMk3OgQp1W2pv_a0EdpmDKWkD68dHK2ixnmUf-UGQHSFDDxZo0XeBJyD7G4ZXYJ0RHQZnlEeE9gn99Ggo-7Fh');

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `note` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `client_id`, `name`, `date`, `note`) VALUES
(9, 1, 'Samrt ', '2020-05-15 16:03:24', '');

-- --------------------------------------------------------

--
-- Table structure for table `sub_option`
--

CREATE TABLE `sub_option` (
  `id` int(11) NOT NULL,
  `configurable_product_id` int(11) NOT NULL,
  `attribute_id` int(11) DEFAULT NULL,
  `attribute_config_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sub_option`
--

INSERT INTO `sub_option` (`id`, `configurable_product_id`, `attribute_id`, `attribute_config_id`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 9),
(3, 2, 1, 2),
(4, 2, 2, 9),
(5, 3, 1, 3),
(6, 3, 2, 9),
(7, 4, 1, 4),
(8, 4, 2, 9),
(9, 5, 1, 5),
(10, 5, 2, 9),
(11, 6, 1, 1),
(12, 6, 2, 10),
(13, 7, 1, 2),
(14, 7, 2, 10),
(15, 8, 1, 3),
(16, 8, 2, 10),
(17, 9, 1, 4),
(18, 9, 2, 10),
(19, 10, 1, 5),
(20, 10, 2, 10),
(21, 11, 1, 1),
(22, 11, 2, 10),
(23, 11, 3, 22),
(24, 12, 1, 2),
(25, 12, 2, 10),
(26, 12, 3, 22),
(27, 13, 1, 3),
(28, 13, 2, 10),
(29, 13, 3, 22),
(30, 14, 1, 1),
(31, 14, 2, 11),
(32, 14, 3, 22),
(33, 15, 1, 2),
(34, 15, 2, 11),
(35, 15, 3, 22),
(36, 16, 1, 3),
(37, 16, 2, 11),
(38, 16, 3, 22),
(39, 17, 1, 1),
(40, 17, 2, 12),
(41, 17, 3, 22),
(42, 18, 1, 2),
(43, 18, 2, 12),
(44, 18, 3, 22),
(45, 19, 1, 3),
(46, 19, 2, 12),
(47, 19, 3, 22),
(48, 20, 1, 1),
(49, 20, 2, 10),
(50, 20, 3, 23),
(51, 21, 1, 2),
(52, 21, 2, 10),
(53, 21, 3, 23),
(54, 22, 1, 3),
(55, 22, 2, 10),
(56, 22, 3, 23),
(57, 23, 1, 1),
(58, 23, 2, 11),
(59, 23, 3, 23),
(60, 24, 1, 2),
(61, 24, 2, 11),
(62, 24, 3, 23),
(63, 25, 1, 3),
(64, 25, 2, 11),
(65, 25, 3, 23),
(66, 26, 1, 1),
(67, 26, 2, 12),
(68, 26, 3, 23),
(69, 27, 1, 2),
(70, 27, 2, 12),
(71, 27, 3, 23),
(72, 28, 1, 3),
(73, 28, 2, 12),
(74, 28, 3, 23),
(75, 29, 1, 1),
(76, 29, 2, 10),
(77, 29, NULL, 1),
(78, 29, NULL, 10),
(79, 30, 1, 1),
(80, 30, 2, 11),
(81, 30, NULL, 1),
(82, 30, NULL, 11),
(83, 31, 1, 1),
(84, 31, 2, 12),
(85, 31, NULL, 1),
(86, 31, NULL, 12),
(87, 32, 3, 22),
(88, 33, 3, 23),
(89, 34, 3, 24),
(90, 35, 1, 1),
(91, 35, 2, 9),
(92, 36, 1, 2),
(93, 36, 2, 9),
(94, 37, 1, 3),
(95, 37, 2, 9),
(96, 38, 1, 1),
(97, 38, 2, 10),
(98, 39, 1, 2),
(99, 39, 2, 10),
(100, 40, 1, 3),
(101, 40, 2, 10),
(102, 41, 1, 1),
(103, 41, 2, 11),
(104, 42, 1, 2),
(105, 42, 2, 11),
(106, 43, 1, 3),
(107, 43, 2, 11),
(108, 44, 1, 5),
(109, 44, 2, 11),
(110, 45, 1, 6),
(111, 45, 2, 11),
(112, 46, 1, 7),
(113, 46, 2, 11),
(114, 47, 1, 5),
(115, 47, 2, 12),
(116, 48, 1, 6),
(117, 48, 2, 12),
(118, 49, 1, 7),
(119, 49, 2, 12),
(120, 50, 1, 5),
(121, 50, 2, 13),
(122, 51, 1, 6),
(123, 51, 2, 13),
(124, 52, 1, 7),
(125, 52, 2, 13),
(126, 53, 1, 5),
(127, 53, 2, 14),
(128, 54, 1, 6),
(129, 54, 2, 14),
(130, 55, 1, 7),
(131, 55, 2, 14),
(132, 56, 1, 5),
(133, 56, 2, 15),
(134, 57, 1, 6),
(135, 57, 2, 15),
(136, 58, 1, 7),
(137, 58, 2, 15),
(138, 59, 1, 5),
(139, 59, 2, 16),
(140, 60, 1, 6),
(141, 60, 2, 16),
(142, 61, 1, 7),
(143, 61, 2, 16);

-- --------------------------------------------------------

--
-- Table structure for table `towns`
--

CREATE TABLE `towns` (
  `id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `center` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `towns`
--

INSERT INTO `towns` (`id`, `city_id`, `name`, `center`) VALUES
(3, 8, 'الفلوجة', 0),
(4, 8, 'عانة', 0),
(5, 8, 'حديثة', 0),
(6, 8, 'الرطبة', 0),
(7, 8, 'القائم', 0),
(8, 8, 'راوة', 0),
(9, 8, 'الخالدية', 0),
(10, 8, 'العامرية', 0),
(11, 8, 'الكرمة', 0),
(12, 17, 'الحلة', 0),
(13, 17, 'المحاويل', 0),
(14, 17, 'الهاشمية', 0),
(15, 17, 'المسيب', 0),
(16, 17, 'الحمزة الغربي (المدحتية)', 0),
(17, 17, 'القاسم', 0),
(18, 17, 'كوثى  (ناحية المشروع)', 0),
(19, 1, 'الشعب شارع الصحة ', 0),
(20, 1, 'الأعظمية', 0),
(21, 1, 'الشعب', 0),
(24, 1, ' المدائن  ', 0),
(25, 1, ' الحسينية ', 0),
(26, 1, ' المعامل  ', 0),
(27, 1, 'حي الخظراء', 0),
(28, 1, ' الكاظمية  ', 0),
(29, 1, ' المحمودية  ', 0),
(31, 1, ' الطارمية    ', 0),
(34, 4, 'اربيل', 0),
(36, 14, 'تكريت', 1),
(37, 3, 'الموصل', 1),
(38, 4, 'عين كاوة', 1),
(39, 5, 'نجف', 1),
(40, 6, 'الناصرية', 1),
(41, 7, 'كركوك', 1),
(42, 9, 'ديالى', 1),
(43, 10, 'السماوة', 1),
(44, 11, 'الديوانية', 1),
(45, 12, 'العمارة', 1),
(46, 13, 'الكوت', 1),
(48, 15, 'دهوك', 1),
(49, 16, 'سليمانية', 1),
(50, 18, 'كربلاء', 1),
(52, 2, 'كرمة', 0),
(53, 2, 'الزبير', 0),
(54, 2, 'ابو الخصيب', 0),
(55, 2, 'سفوان', 0),
(56, 2, 'الطويسة', 0),
(57, 2, 'المدينة', 0),
(58, 2, 'القبلة', 0),
(59, 2, 'الكزيزة', 0),
(60, 2, 'القرنة', 0),
(61, 2, 'تنومة', 0),
(62, 2, 'الاصمعي', 0),
(63, 14, 'بلد', 0),
(64, 14, 'سامراء', 0),
(65, 14, 'سامراء', 0),
(66, 14, 'الضلوعيه', 0),
(67, 14, 'سامراء', 0),
(68, 14, 'سامراء', 0),
(69, 8, 'الانبار', 0),
(70, 8, 'الفلوجه', 0),
(71, 8, 'الفلوجه', 0),
(72, 14, 'صلاح الدين', 0),
(73, 14, 'مشاهده', 0),
(74, 14, 'مشاهده', 0),
(75, 2, 'الاحياء', 0),
(76, 2, 'دور النفط', 0),
(77, 2, 'حي الجمهورية ', 0),
(78, 2, 'التحسينية', 0),
(79, 2, 'خمسة ميل', 0),
(80, 2, 'البريهة', 0),
(81, 2, 'الحكيمية', 0),
(82, 2, 'الطويسة', 0),
(83, 2, 'الاصمعي', 0),
(84, 2, 'الطليعة', 0),
(85, 2, 'حي الخليج', 0),
(86, 2, 'الكفائات', 0),
(87, 2, 'العشار', 0),
(88, 1, 'الشعلة', 0),
(89, 1, 'الحرية', 0),
(90, 1, 'الكاظمية', 0),
(91, 1, 'التاجي', 0),
(94, 1, 'الغزالية', 0),
(95, 1, 'العامرية', 0),
(96, 1, 'مطار المثنى', 0),
(97, 1, 'ابو غريب', 0),
(98, 1, 'البكرية', 0),
(99, 1, 'حي الحسين', 0),
(100, 1, 'حي العامل', 0),
(101, 1, 'مجمع الاياد', 0),
(102, 1, 'حي الجهاد', 0),
(103, 1, 'البياع', 0),
(104, 1, 'شهداء البياع', 0),
(105, 1, 'شرطة الخامسة', 0),
(106, 1, 'شرطة الرابعة', 0),
(107, 1, 'الرسالة', 0),
(108, 1, 'السيدية', 0),
(109, 1, 'كفائات السيدية', 0),
(110, 1, 'الدورة', 0),
(111, 1, 'المهدية ', 0),
(112, 1, 'المهدية الثانية ', 0),
(113, 1, 'الدوره شارع الصحة', 0),
(114, 1, 'الدوره شارع ستين', 0),
(115, 1, 'الدوره ابو طيارة', 0),
(116, 1, 'الدوره طعمة', 0),
(117, 1, 'علوة الرشيد', 0),
(118, 1, 'محمودية ', 0),
(119, 1, 'يوسفية', 0),
(120, 1, 'عويريج', 0),
(121, 1, 'مصفى الدوره', 0),
(122, 1, 'اليرموك', 0),
(123, 1, 'القادسية', 0),
(124, 1, 'اربع شوارع', 0),
(125, 1, 'المنصور', 0),
(126, 1, 'الوشاش', 0),
(127, 1, 'علي الصالح', 0),
(128, 1, 'الاسكان', 0),
(129, 1, 'حي الجامعة', 0),
(130, 1, 'حي العدل', 0),
(131, 1, 'ساحة عدن', 0),
(132, 1, 'العطيفية', 0),
(133, 1, 'رحمانية الجعيفر ', 0),
(134, 1, 'الجعيفر', 0),
(135, 1, 'شيخ معروف', 0),
(136, 1, 'العلاوي', 0),
(137, 1, 'الصالحية', 0),
(138, 1, 'شقق الصالحية', 0),
(139, 1, 'كرادة مريم', 0),
(140, 1, 'الزوراء', 0),
(141, 1, 'مطار المثنى', 0),
(142, 1, 'مطار بغداد', 0),
(143, 1, 'مستشفى الهلال الاحمر', 0),
(144, 1, 'مدينة الطب', 0),
(145, 1, 'الحارثية', 0),
(146, 1, 'شارع الكندي', 0),
(147, 1, 'معرض بغداد', 0),
(148, 1, 'الرواد', 0),
(149, 1, 'الطوبجي', 0),
(150, 1, 'حي السلام', 0),
(151, 1, 'الاعظمية', 0),
(152, 1, 'مستشفى النعمان', 0),
(153, 1, 'شارع سهام', 0),
(154, 1, 'باب المعظم', 0),
(155, 1, 'شارع المغرب', 0),
(156, 1, 'الكسره', 0),
(157, 1, 'الشورجة', 0),
(158, 1, 'الرصافي', 0),
(159, 1, 'باب الشرجي', 0),
(160, 1, 'الكرادة', 0),
(161, 1, 'مجمع مشن', 0),
(162, 1, 'الجادرية', 0),
(163, 1, 'الزعفرانية ', 0),
(164, 1, 'جسر ديالة', 0),
(165, 1, 'نهروان', 0),
(166, 1, 'بسماية', 0),
(167, 1, 'الامين', 0),
(168, 1, 'الامين الثانية', 0),
(169, 1, 'بغداد الجديدة', 0),
(170, 1, 'المشتل', 0),
(171, 1, 'كم ساره', 0),
(172, 1, 'زيونة', 0),
(173, 1, 'شارع الربيعي', 0),
(174, 1, 'ساحة ميسلون', 0),
(175, 1, 'الغدير ', 0),
(176, 1, 'البلديات', 0),
(177, 1, 'العبيدي', 0),
(178, 1, 'شهداء العبيدي', 0),
(179, 1, 'الثعالبة', 0),
(180, 1, 'شارع فلسطين', 0),
(181, 1, 'النهضة', 0),
(182, 1, 'مدينة الصدر', 0),
(183, 1, 'الحبيبية', 0),
(184, 1, 'ام الكبر', 0),
(185, 1, 'الاورفلي', 0),
(186, 1, 'جميلة', 0),
(187, 1, 'حبيبية', 0),
(188, 1, 'طالبية', 0),
(189, 1, 'البنوك', 0),
(190, 1, 'حي البنوك', 0),
(191, 1, 'شعب', 0),
(192, 1, 'حي اور', 0),
(193, 1, 'الحسينية', 0),
(194, 1, 'الراشدية', 0),
(195, 1, 'السريدات', 0),
(196, 1, 'حي النصر', 0),
(197, 1, 'القاهره', 0),
(198, 1, 'حي البساتين', 0),
(199, 1, 'المستنصرية', 0),
(200, 1, 'الوزيرية', 0),
(201, 1, 'الكفاح', 0),
(202, 1, 'شارع حيفا', 0),
(203, 1, 'الفضل', 0),
(204, 1, 'الكريعات', 0),
(205, 1, 'حي تونس', 0),
(206, 1, 'القناة', 0),
(207, 1, 'جسر المثنى', 0),
(208, 1, 'الجزيره السياحية', 0),
(209, 1, 'المشاهدة', 0),
(210, 1, 'الطارمية', 0),
(211, 1, 'ام عظام', 0),
(212, 1, 'ام الجدايل', 0),
(213, 1, 'القرية الذهبية', 0),
(214, 1, 'صليخ', 0),
(215, 1, 'صيطره الشعب', 0),
(216, 1, 'شيخ عمر', 0),
(217, 1, 'شقق صدام', 0),
(218, 1, 'حي التراث', 0),
(219, 1, 'الشالجية', 0),
(220, 1, 'الرحمانيه', 0),
(221, 2, 'مركز', 0),
(222, 16, 'كلار', 0),
(223, 3, 'حي الزهور', 0),
(224, 3, 'تلعفر ', 0),
(225, 3, 'حي الوحدة', 0),
(226, 3, 'شارع كركوك', 0),
(227, 3, 'تكليف', 0),
(228, 3, 'مخمور', 0),
(229, 3, 'مخيم حسن', 0),
(230, 3, '17 تموز', 0),
(231, 3, 'حي المعارف', 0),
(232, 3, 'الكيارة', 0),
(233, 3, 'نبي شيت', 0),
(234, 3, 'الساحل الايسر', 0),
(235, 2, 'جمعيات', 0),
(236, 3, 'قرية اسكي', 0),
(237, 3, 'حي المنصور', 0),
(238, 3, 'حي الفلاح', 0),
(239, 3, 'حي النور ', 0),
(240, 3, 'حي البعث', 0),
(241, 3, 'حي الحدباء', 0),
(242, 3, 'ربيعة', 0),
(243, 2, 'الهارثه', 0),
(244, 3, 'حي سومر', 0),
(245, 9, 'المقدادية', 0),
(246, 2, 'الساعي', 0),
(247, 9, 'مستشفلى خانقين', 0),
(248, 9, 'مستشفلى بالدروز', 0),
(249, 9, 'مستشفلى بعقوبة', 0),
(250, 9, 'مستشفلى الخالص', 0),
(251, 9, 'مستشفلى حان بني سعد', 0),
(252, 9, 'مستشفلى خان بني سعد', 0),
(253, 9, 'بهرز', 0),
(254, 9, 'دلي عباس', 0),
(255, 9, 'شهربان', 0),
(256, 9, 'مندلي', 0),
(257, 9, 'بني سعد', 0),
(258, 9, 'تحرير', 0),
(259, 2, 'مستشفى الجمهوريه ', 0),
(260, 9, 'بعقوبة', 0),
(261, 2, 'جبيله', 0),
(262, 2, 'الجنينه', 0),
(263, 2, 'دور المطار', 0),
(264, 2, 'الجزائر', 0),
(265, 2, 'المعقل', 0),
(266, 2, 'الداخل', 0),
(267, 2, 'ام قصر', 0),
(268, 2, 'شقق الموقفيه', 0),
(269, 2, 'المشراق', 0),
(270, 18, 'ميثم التمار', 0),
(271, 1, 'الاعلام', 0),
(272, 8, 'الحبانيه', 0),
(273, 13, 'صويره', 0),
(274, 8, 'هيت', 0),
(275, 8, 'البغداديه الدولاب', 0),
(276, 13, 'النعمانيه', 0),
(277, 13, 'الحفريه', 0),
(278, 13, 'عزيزيه', 0),
(279, 5, 'كوفه', 0),
(280, 5, 'حي العسكري', 0),
(281, 5, 'قرب الغدير', 0),
(282, 5, 'حي الانصار', 0),
(283, 5, 'حي انيلاد', 0),
(284, 5, 'قرب شارع كربلاء', 0),
(285, 5, 'حي المهندسين', 0),
(286, 5, 'عباسيه', 0),
(287, 7, 'حي الواسطي', 0),
(288, 5, 'شارع المطار', 0),
(289, 5, 'حيدريه', 0),
(290, 5, 'منطقه الجديده', 0),
(291, 5, 'دورهنديه', 0),
(292, 5, 'حي السواق', 0),
(293, 5, 'ابو صخرين', 0),
(294, 5, 'حي سلام', 0),
(295, 1, 'سبع ابكار', 0),
(296, 1, 'اليوسفيه', 0),
(297, 1, 'سبع البور', 0),
(298, 1, 'الكماليه', 0),
(299, 1, 'مشفى الكرخ', 0),
(300, 1, 'الدهاليك ', 0),
(301, 1, 'كراده خارج', 0),
(302, 1, 'كراده داخل', 0),
(303, 1, 'الكرخ', 0),
(304, 1, 'مجمع الاطباء', 0),
(305, 1, 'بوب الشام', 0),
(306, 1, 'شارع النضال', 0),
(307, 1, 'القوس', 0),
(308, 1, 'سيطرة الرشيد', 0),
(309, 1, 'مستشفى الطفل', 0),
(310, 1, 'سلمان باك', 0),
(311, 1, 'حي الاطباء', 0),
(312, 1, 'الشرطه الرابعه', 0),
(313, 1, 'شارع المشجر', 0),
(314, 9, 'خانقين', 0),
(315, 17, 'شارع الدولي', 0),
(316, 17, 'بابل', 0),
(317, 17, 'الكفل', 0),
(318, 17, 'حي بكري', 0),
(319, 7, 'طوز خرماتو', 0),
(320, 2, 'خور الزبير', 0),
(321, 2, 'البراضعيه', 0),
(322, 2, 'شارع السايلو', 0),
(323, 2, 'دور الظباط', 0),
(324, 2, 'لحبانيه', 0),
(325, 2, 'حي الاصدقاء', 0),
(326, 2, 'الدير', 0),
(327, 2, 'التشوه', 0),
(328, 2, 'حي لحسين', 0),
(329, 2, 'مناوي', 0),
(330, 2, 'التنومه', 0),
(331, 8, 'امركز', 0),
(332, 8, 'حي الشرطه', 0),
(333, 6, 'الشطره', 0),
(334, 6, 'ثوره', 0),
(335, 6, 'الفهود', 0),
(336, 6, 'شارع ابراهيم الخليل', 0),
(337, 6, 'اريدو', 0),
(338, 6, 'الغراف', 0),
(339, 6, 'الاسكان الصناعي', 0),
(340, 6, 'سوق الشيوخ', 0),
(341, 6, 'قضاء الوفود', 0),
(342, 6, 'حي البقاع', 0),
(343, 6, 'شطره', 0),
(344, 6, 'الرفاعي', 0),
(345, 6, 'حمام العليل', 0),
(346, 6, 'الجبايش', 0),
(347, 6, 'الفجر', 0),
(348, 6, 'قلعه سكر', 0),
(349, 6, 'النصر', 0),
(350, 6, 'شارع النصر', 0),
(351, 17, 'ابو غرق', 0),
(352, 17, 'حي حسين', 0),
(353, 17, 'شارع الكرامه', 0),
(354, 17, 'حله', 0),
(355, 17, 'الاسكندريه', 1),
(356, 17, 'سيطرة الاثار', 0),
(357, 17, 'ام الهوى', 0),
(358, 17, 'جفل', 0),
(359, 17, 'النيل', 0),
(360, 17, 'الشوملي', 0),
(361, 17, 'المركز', 1),
(362, 17, 'حي نادر', 0),
(363, 17, 'سياحي', 0),
(364, 17, 'الخضر', 0),
(365, 17, 'طهمازيه', 0),
(366, 17, 'حي الجزائر', 0),
(367, 17, 'باب مشهد', 0),
(368, 17, 'حي الامام علي', 0),
(369, 17, 'جامعه بابل', 0),
(370, 17, 'حي الكرامه', 0),
(371, 9, 'الخالص', 0),
(372, 9, 'حي المعلمين', 0),
(373, 9, 'المقداديه', 0),
(374, 9, 'الفلاحه', 0),
(375, 9, 'بغقوبه', 0),
(376, 9, 'جلولاء', 0),
(377, 9, 'دوله عباس', 0),
(378, 9, 'هربانش', 0),
(379, 9, 'قريه نبه', 0),
(380, 9, 'بلدروز', 0),
(381, 9, 'سرجق', 0),
(382, 9, 'التحرير', 0),
(383, 9, 'المنصوريه', 0),
(384, 7, 'حي عدن', 0),
(385, 2, 'بصره', 0),
(386, 10, 'ميسان', 0),
(387, 10, 'عماره', 0),
(388, 10, 'حي الرحمه', 0),
(389, 10, 'حي جمعيات', 0),
(390, 10, 'كميت', 0),
(391, 10, 'العزيزيه', 0),
(392, 10, 'قلعه صالح', 0),
(393, 10, 'ابو رمانه', 0),
(394, 10, 'جسر بوعيه', 0),
(395, 10, 'رميثه', 0),
(396, 10, 'جامعه المثنى', 0),
(397, 10, 'المجر الكبير', 0),
(398, 10, 'الماجديه', 0),
(399, 10, 'ميمونه', 0),
(400, 10, 'مشفى شهيد الصدر', 0),
(401, 10, 'المدى', 0),
(402, 12, 'حي الجمعيات', 0),
(403, 12, 'اعماره', 0),
(404, 12, 'االرحمه', 0),
(405, 12, 'قلعة صالح', 0),
(406, 12, 'كحلاء', 0),
(407, 12, 'حي لمعلمين', 0),
(408, 12, 'ابو ارمانه', 0),
(409, 12, 'المجر لكبير', 0),
(410, 12, 'ماجديه', 0),
(411, 18, 'حي الايمان', 0),
(412, 18, 'شارع ميثم', 0),
(413, 18, 'حي لسلام', 0),
(414, 18, 'حي الظباط', 0),
(415, 18, 'كنطرة السلام', 0),
(416, 18, 'حي الغدير', 0),
(417, 18, 'حي التعاون', 0),
(418, 18, 'حي الرساله', 0),
(419, 18, 'طريق بغداد', 0),
(420, 18, 'شارع الادريس', 0),
(421, 18, 'عين تمر', 0),
(422, 18, 'ناحيه الحر', 0),
(423, 18, 'مشتفى الحسين', 0),
(424, 18, 'حي االسلام', 0),
(425, 11, 'دور سيد محمد', 0),
(426, 11, 'ام النخيل', 0),
(427, 11, 'االاسكان', 0),
(428, 11, 'حي الزعيم', 0),
(429, 11, 'الحمزه الشرقي', 0),
(430, 11, 'مشقى الحسين', 0),
(431, 11, 'خماس', 0),
(432, 11, 'عفك', 0),
(433, 11, 'الحمزه', 0),
(434, 11, 'شاميه', 0),
(435, 11, 'دغاره', 0),
(436, 11, 'البدير', 0),
(437, 11, 'قضاء الشافعيه', 0),
(438, 11, 'ناحيه نفر ', 0),
(439, 11, 'سيطره النسيج', 0),
(440, 3, 'حي البكر', 0),
(441, 3, 'حمدانيه', 0),
(442, 3, 'حي 17 تموز', 0),
(443, 3, 'حي الانصاري', 0),
(444, 3, 'جانب الايمن', 0),
(445, 3, 'جامب الايسر', 0),
(446, 3, 'جانب الايسر', 0),
(447, 3, 'برطله', 0),
(448, 3, 'موصل', 0),
(449, 3, 'حي االكرامه', 0),
(450, 4, 'عين كاوه', 0),
(451, 4, 'مطار اربيل', 0),
(452, 4, 'كزمزال ميدان الرمي', 0),
(453, 4, 'شقق تيو اسكان', 0),
(454, 7, 'تبه', 0),
(455, 7, 'عرقه', 0),
(456, 7, 'حي الايسر', 0),
(457, 7, 'ساحه الامتنالات', 0),
(458, 7, 'مركز العروبه', 0),
(459, 7, 'حويجه', 0),
(460, 7, 'حي الاسره', 0),
(461, 7, 'كيوان', 0),
(462, 7, 'اتبه', 0),
(463, 12, 'دور االنفط', 0),
(464, 12, 'قضاء الكحلاء', 0),
(465, 12, 'حي االجهاد', 0),
(466, 12, 'عواشه', 0),
(467, 5, 'المناذره', 0),
(468, 5, 'حي القدس', 0),
(469, 5, 'قريه الغدير', 0),
(470, 5, 'اكوفه', 0),
(471, 5, 'حي الانصر', 0),
(472, 5, 'حي الانصا', 0),
(473, 5, 'الفحل', 0),
(474, 5, 'حي الغربي', 0),
(475, 13, 'الصويره', 0),
(476, 13, 'انوار الصدر', 0),
(477, 13, 'دجيلي', 0),
(478, 13, 'شارع الزهراء', 0),
(479, 13, 'قضاء الحي', 0),
(480, 13, 'حي الزهراء', 0),
(481, 13, 'ناحيه جصان', 0),
(482, 13, 'الحي', 0),
(483, 13, 'الكفاءات', 0),
(484, 10, 'حي الصدر', 0),
(485, 10, 'السوير', 0),
(486, 10, 'الغربي الثاني ', 0),
(487, 10, 'اقضاء الخضر', 0),
(488, 10, 'قشله', 0),
(489, 10, 'الرميثه', 0),
(490, 10, 'ام العصافير', 0),
(491, 14, 'ناحيه العلم', 0),
(492, 14, 'الدجيل', 0),
(493, 14, 'ناحية زور الجيش', 0),
(494, 7, 'طريق لبغداد', 0),
(495, 2, 'المعارض', 0),
(496, 2, 'شط العرب', 0),
(497, 2, 'الامن الداخلي', 0),
(498, 2, 'حي مهندسين', 0),
(499, 3, 'حي زهراء', 0),
(500, 3, 'حي المدائن', 0),
(501, 10, 'حي لعسكري', 0),
(502, 1, 'ابو تشير', 0),
(503, 1, 'ابو دشير', 0),
(504, 1, 'حي البتول', 0),
(505, 1, 'الصابئات', 0),
(506, 1, 'الرشيد', 0),
(507, 1, 'السعدون', 0),
(508, 12, 'العدير', 0),
(509, 12, 'لغدير', 0),
(510, 6, 'حي ااور', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attribute`
--
ALTER TABLE `attribute`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attribute_config`
--
ALTER TABLE `attribute_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `basket`
--
ALTER TABLE `basket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `basket_items`
--
ALTER TABLE `basket_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cites`
--
ALTER TABLE `cites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_dev_price`
--
ALTER TABLE `client_dev_price`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `configurable_product`
--
ALTER TABLE `configurable_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mandop_stores`
--
ALTER TABLE `mandop_stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_option`
--
ALTER TABLE `sub_option`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `towns`
--
ALTER TABLE `towns`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attribute`
--
ALTER TABLE `attribute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `attribute_config`
--
ALTER TABLE `attribute_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `basket`
--
ALTER TABLE `basket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `basket_items`
--
ALTER TABLE `basket_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `client_dev_price`
--
ALTER TABLE `client_dev_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `configurable_product`
--
ALTER TABLE `configurable_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `mandop_stores`
--
ALTER TABLE `mandop_stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sub_option`
--
ALTER TABLE `sub_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT for table `towns`
--
ALTER TABLE `towns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=511;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
