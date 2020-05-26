-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2020 at 09:57 PM
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
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `des` varchar(500) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `title`, `parent_id`, `des`, `date`) VALUES
(1, 'الحاسبات', -1, '', '2019-12-26 10:24:01'),
(2, 'الشبكات', 1, '', '2019-12-26 10:57:04'),
(3, 'البرامجيات', 1, '', '2019-12-26 10:57:16'),
(4, 'تطبيقات الويب', 3, '', '2019-12-26 10:59:31'),
(5, 'الهندسة', -1, '', '2019-12-29 09:59:53');

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
  `branch_id` int(11) NOT NULL,
  `password` varchar(250) NOT NULL,
  `token` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `phone`, `email`, `branch_id`, `password`, `token`) VALUES
(1, 'محمد رضا', '07822816655', '', 1, '$2a$07$OlqxKlucht0iv5EaM26OfOEoE31drZDHMH7NQOv2KaitI.w9D44OG', NULL);

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
  `option_id` int(11) DEFAULT NULL,
  `buy_price` double NOT NULL,
  `price` int(11) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `sku` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `configurable_product`
--

INSERT INTO `configurable_product` (`id`, `product_id`, `option_id`, `buy_price`, `price`, `image_id`, `qty`, `sku`) VALUES
(1, 1, NULL, 500000, 700000, NULL, 4, '3322143'),
(2, 1, NULL, 500000, 700000, NULL, 4, '3322143'),
(3, 1, NULL, 500000, 700000, NULL, 4, '3322143'),
(4, 1, NULL, 500000, 700000, NULL, 4, '3322143'),
(5, 1, NULL, 500000, 700000, NULL, 4, '3322143'),
(6, 1, NULL, 500000, 700000, NULL, 4, '3322143'),
(7, 1, NULL, 500000, 700000, NULL, 4, '3322143'),
(8, 1, NULL, 500000, 700000, NULL, 4, '3322143'),
(9, 1, NULL, 500000, 700000, NULL, 4, '3322143'),
(10, 1, NULL, 500000, 700000, NULL, 4, '3322143'),
(11, 2, NULL, 120000, 150000, NULL, 6, '12324'),
(12, 2, NULL, 120000, 150000, NULL, 6, '12324'),
(13, 2, NULL, 120000, 150000, NULL, 6, '12324'),
(14, 2, NULL, 120000, 150000, NULL, 6, '12324'),
(15, 2, NULL, 120000, 150000, NULL, 6, '12324'),
(16, 2, NULL, 120000, 150000, NULL, 6, '12324'),
(17, 2, NULL, 120000, 150000, NULL, 6, '12324'),
(18, 2, NULL, 120000, 150000, NULL, 6, '12324'),
(19, 2, NULL, 120000, 150000, NULL, 6, '12324'),
(20, 2, NULL, 120000, 150000, NULL, 6, '12324'),
(21, 2, NULL, 120000, 150000, NULL, 6, '12324'),
(22, 2, NULL, 120000, 150000, NULL, 6, '12324'),
(23, 2, NULL, 120000, 150000, NULL, 6, '12324'),
(24, 2, NULL, 120000, 150000, NULL, 6, '12324'),
(25, 2, NULL, 120000, 150000, NULL, 6, '12324'),
(26, 2, NULL, 120000, 150000, NULL, 6, '12324'),
(27, 2, NULL, 120000, 150000, NULL, 6, '12324'),
(28, 2, NULL, 120000, 150000, NULL, 6, '12324');

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
(7, 2, '2/5ecada231fd6c.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `delivery_company_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `town_id` int(11) NOT NULL,
  `address` varchar(250) NOT NULL,
  `customer_phone` varchar(18) NOT NULL,
  `customer_name` varchar(250) NOT NULL,
  `note` varchar(250) NOT NULL,
  `order_status_id` int(11) NOT NULL,
  `money_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `order_itmes`
--

CREATE TABLE `order_itmes` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` double NOT NULL,
  `discount` double NOT NULL,
  `qty` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `simple_des` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `type`, `des`, `category_id`, `simple_des`) VALUES
(1, 'HP Computer', 2, NULL, 1, 'Good Quality '),
(2, 'Dell', 2, NULL, 1, '');

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
(74, 28, 3, 23);

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
(51, 1, 'الكرادة', 0);

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
-- Indexes for table `order_itmes`
--
ALTER TABLE `order_itmes`
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
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_itmes`
--
ALTER TABLE `order_itmes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `towns`
--
ALTER TABLE `towns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
