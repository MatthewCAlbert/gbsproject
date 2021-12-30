-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2019 at 07:52 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gbsmoneydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(16) NOT NULL,
  `name` varchar(32) NOT NULL,
  `level` int(1) NOT NULL,
  `status` varchar(8) NOT NULL,
  `password` char(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `name`, `level`, `status`, `password`) VALUES
('booth_1', 'Booth 1', 3, 'active', '$2y$10$x5L3zmhT.Pa3cxOZILdsLuxPMKsZ.MLPokwIQaw90DKayy/88a7XS'),
('help_1', 'Help 1', 1, 'banned', '$2y$10$MEr88oiMBwoorhf9ohVf.uemf5ts6dTzcHvV2Rg2tsIYGm30x5AQy'),
('root', 'Root', 5, 'active', '$2y$10$MfKLi1dmpDsNuO82sbM.Y.TbZ2rib8b.VYLsa2FJaM0oSKxguW/5m'),
('test', 'test', 1, 'active', '$2y$10$gZ9Lmy18DxqgW8ruOUXnButpJUBOG2Xrgh5Oc8SSkVMQtB5Y60bSa');

-- --------------------------------------------------------

--
-- Table structure for table `api`
--

CREATE TABLE `api` (
  `username` varchar(50) NOT NULL,
  `api_key` varchar(64) NOT NULL,
  `status` varchar(10) NOT NULL,
  `access` text NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `api`
--

INSERT INTO `api` (`username`, `api_key`, `status`, `access`, `type`) VALUES
('analytics', '597YnJrZCMX7nIqP', 'active', '1', 'web'),
('edc-01', 'iYazfICM9FUF74Yx', 'active', '1,3,4', 'device'),
('edc-02', '4BTntf1xeZUgRwwI', 'active', '1', 'device'),
('gbsapp', 'pw2nbm9mKie8pW2O', 'active', '1', 'web');

-- --------------------------------------------------------

--
-- Table structure for table `balance_history`
--

CREATE TABLE `balance_history` (
  `id` varchar(5016) NOT NULL,
  `balance` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `balance_history`
--

INSERT INTO `balance_history` (`id`, `balance`, `time`) VALUES
('0049119379', 970000, '2018-06-17 05:26:33'),
('161710218', 870000, '2018-06-17 05:30:49'),
('161710218', 920000, '2018-06-17 05:31:18'),
('161710218', 910000, '2018-06-17 05:34:29'),
('161701', 110000, '2018-06-17 05:34:29'),
('161710218', 900000, '2018-06-17 05:36:28'),
('161701', 0, '2018-06-17 05:36:28'),
('161710218', 800000, '2018-06-17 05:37:29'),
('161701', 220000, '2018-06-17 05:37:29'),
('161710218', 790000, '2018-06-17 06:29:30'),
('161701', 230000, '2018-06-17 06:29:30'),
('161710218', 780000, '2018-06-17 06:58:28'),
('161701', 240000, '2018-06-17 06:58:28'),
('161710218', 880000, '2018-06-18 14:24:01'),
('161710218', 875000, '2018-08-19 13:36:32'),
('171802', 105000, '2018-08-19 13:36:32'),
('161710218', 870000, '2018-08-19 13:41:22'),
('171802', 110000, '2018-08-19 13:41:22'),
('161710218', 865000, '2018-08-19 13:43:18'),
('171802', 115000, '2018-08-19 13:43:18'),
('161710218', 860000, '2018-08-19 14:45:53'),
('171802', 120000, '2018-08-19 14:45:53'),
('161710218', 855000, '2018-08-19 14:52:47'),
('171802', 125000, '2018-08-19 14:52:47'),
('161710218', 850000, '2018-08-19 15:31:48'),
('171802', 130000, '2018-08-19 15:31:48'),
('161710218', 845000, '2018-08-19 15:32:59'),
('171802', 135000, '2018-08-19 15:32:59'),
('161710218', 840000, '2018-08-19 15:38:18'),
('171802', 140000, '2018-08-19 15:38:18'),
('161710218', 835000, '2018-08-19 16:26:16'),
('171802', 145000, '2018-08-19 16:26:16'),
('161710218', 830000, '2018-08-23 12:00:20'),
('171802', 150000, '2018-08-23 12:00:20'),
('161710218', 820000, '2018-08-23 12:02:36'),
('171802', 160000, '2018-08-23 12:02:36'),
('161710218', 815000, '2018-08-23 12:46:01'),
('171802', 165000, '2018-08-23 12:46:01'),
('161710218', 810000, '2018-08-23 12:47:10'),
('171802', 170000, '2018-08-23 12:47:10'),
('161710218', 805000, '2018-08-23 13:07:40'),
('171802', 175000, '2018-08-23 13:07:40'),
('161710218', 800000, '2018-08-23 14:54:49'),
('171802', 180000, '2018-08-23 14:54:49'),
('161710218', 795000, '2018-08-24 19:39:57'),
('171802', 185000, '2018-08-24 19:39:57'),
('161710218', 790000, '2018-08-24 19:42:19'),
('171802', 190000, '2018-08-24 19:42:19'),
('161710218', 785000, '2018-08-24 19:47:09'),
('171802', 195000, '2018-08-24 19:47:09'),
('161710218', 780000, '2018-08-24 19:50:16'),
('171802', 200000, '2018-08-24 19:50:16'),
('161710218', 775000, '2018-08-26 08:57:53'),
('171802', 205000, '2018-08-26 08:57:54'),
('161710218', 770000, '2018-08-26 09:03:51'),
('171802', 210000, '2018-08-26 09:03:51'),
('161710218', 768000, '2018-08-26 09:53:15'),
('171802', 212000, '2018-08-26 09:53:15'),
('161710218', 766000, '2018-08-28 10:13:23'),
('171802', 214000, '2018-08-28 10:13:23'),
('161710218', 761000, '2018-08-28 10:42:22'),
('171802', 219000, '2018-08-28 10:42:22'),
('161710218', 756000, '2018-08-28 11:21:24'),
('171802', 224000, '2018-08-28 11:21:24'),
('161710218', 1000, '2018-10-12 14:30:15'),
('161710218', 747000, '2019-01-25 16:12:44'),
('161710010', 110000, '2019-01-25 16:12:44'),
('161710218', 742000, '2019-01-25 16:16:52'),
('161710010', 115000, '2019-01-25 16:16:52'),
('161710218', 732000, '2019-01-26 13:43:32'),
('161710010', 125000, '2019-01-26 13:43:32'),
('161710218', 729500, '2019-01-26 14:24:37'),
('161710010', 127500, '2019-01-26 14:24:37'),
('161710218', 719500, '2019-01-26 19:15:41'),
('161710010', 137500, '2019-01-26 19:15:41'),
('161710218', 709500, '2019-01-26 20:38:06'),
('161710010', 147500, '2019-01-26 20:38:06');

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `id` int(11) NOT NULL,
  `code` varchar(25) NOT NULL,
  `value` int(11) NOT NULL,
  `description` varchar(50) NOT NULL,
  `valid` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `help`
--

CREATE TABLE `help` (
  `id` int(11) NOT NULL,
  `type` varchar(16) NOT NULL,
  `title` varchar(32) NOT NULL,
  `description` varchar(300) NOT NULL,
  `account_id` varchar(32) NOT NULL,
  `email` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `help`
--

INSERT INTO `help` (`id`, `type`, `title`, `description`, `account_id`, `email`, `status`, `time`) VALUES
(1, 'Complaint', 'Cannot Check My Balance', 'today recently blabla', '161710218', 'your_name@gmail.com', 'unread', '0000-00-00 00:00:00'),
(2, 'Complaint', 'Cannot Login', 'Shieet', '123456789', 'emoney.gbs@gmail.com', 'replied', '0000-00-00 00:00:00'),
(3, 'Ask', 'How to basic', 'dasdasdas', '161710218', 'matthewmcavaio@gmail.com', 'unread', '0000-00-00 00:00:00'),
(4, 'Help', 'How to basic', '11111', '161710218', 'matthewmcavaio@gmail.com', 'unread', '0000-00-00 00:00:00'),
(5, 'Help', 'asdasd', 'asdasdasd', '161710218', 'matthewmcavaio@gmail.com', 'unread', '2018-06-12 18:34:28'),
(6, 'Help', 'asfafasf', 'affafasfa', '161710218', 'matthewmcavaio@gmail.com', 'unread', '2018-06-12 18:36:04'),
(7, 'Help', 'dasdasdad', 'dasdasdas', '161710218', 'matthewmcavaio@gmail.com', 'unread', '2019-01-25 17:55:18'),
(8, 'Request', 'dsadasfasf', 'fafasdfadas', '161710218', 'matthewmcavaio@gmail.com', 'unread', '2019-01-25 18:04:20');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` varchar(16) NOT NULL,
  `card_id` varchar(32) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `status` varchar(16) NOT NULL,
  `name` varchar(64) NOT NULL,
  `balance` int(11) NOT NULL,
  `password` char(64) NOT NULL,
  `pin` char(64) NOT NULL,
  `token` char(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `card_id`, `email`, `phone`, `status`, `name`, `balance`, `password`, `pin`, `token`) VALUES
('121321', '2759563248', '', '', 'active', 'Alpha', 0, '$2y$10$Zbh9tGEKV16chHMdj/mfx.zEEkO5I/qBRTOXhVVC66Lpwb6Nz6dWG', '', ''),
('123213', '4', '', '', 'active', 'Lingga', 0, '', '', ''),
('123456789', '1', '', '', 'active', 'John Doe', 160000, '1', '', ''),
('161710005', '5', '', '', 'active', 'Patrick', 0, '$2y$10$uI/5tfuoK0dbpyyWyedWHOCo5H.D/RoFTXqQPjxW3OhnJFW8ted/m', '', ''),
('161710006', '6', '', '', 'active', 'Michelle', 0, '$2y$10$qIA0kqwI5bR9HqO96ej3VeZN4XmBak1yjVj6SNZ.QhjTPoSsFqiCK', '', ''),
('161710007', '7', '', '', 'active', 'Dariel', 0, '$2y$10$rymPLJInIWiBkiqoYujK9O3pImtFC.WLr/DYiFnwUWeM6V.542Wcy', '', ''),
('161710008', '8', '', '', 'active', 'Boi', 0, '$2y$10$I3UFYnKwZtRm3fGvdDot5./QaC3zjJM4QXJoZTU0Snxu6dIJL9nZ.', '', ''),
('161710009', '9', '', '', 'active', 'Revel', 0, '$2y$10$SK08f0zh5NXvt.suZ3jJWulDrKGydMOcMrZFWN0xGeZkqGk9IiWoi', '', ''),
('161710010', '10', '', '', 'active', 'Alma', 147500, '$2y$10$IGxh0b1ICak2RCq/Vdm1u.oAXdln01R.q8fDNW2Q3BUQSWl0/tOMK', '', ''),
('161710011', '12341654', '', '', 'active', 'a', 0, '$2y$10$QRFgtD4ZobqBLu4VblxxpOhfEWn3XALKaRxteH7LFRdVUP4kBWqxS', '', ''),
('161710013', '13', '', '', 'active', 'c', 0, '$2y$10$pRLgDIsKdnAMD0V/MyLIherBobC5tQ7gQoPpr37Y.WbIzdWuCGDjW', '', ''),
('161710014', '14', '', '', 'active', 'd', 0, '$2y$10$rhHUrNPfC9O/fvpDHewSoux5up9pQHanB57rXn1AxszE77Kzj481.', '', ''),
('161710015', '15', '', '', 'active', 'e', 0, '$2y$10$kQ/.R1vFQgvO4z9F8D5xj.huCPBw9bMb6PZEkgTwB3BjgkNGFkHJu', '', ''),
('161710016', '16', '', '', 'active', 'f', 0, '$2y$10$EuXE1xs5cB2yQLpXj5qBEOXMteX.eSRsiXR8wPjToZjxOVyZW2p.W', '', ''),
('161710017', '17', '', '', 'active', 'g', 0, '$2y$10$pmItPNS1.u2KGFF.wj1Mue4dOIu4jEqkiEK4ECW307l3tZPZP48Eu', '', ''),
('161710018', '18', '', '', 'active', 'h', 0, '$2y$10$dtMcfgVV.Fikfr3L0Jdpgea2VYE6Kq..8zvuH.kDhRjFbJpmfaJUO', '', ''),
('161710020', '20', '', '', 'active', 'j', 0, '$2y$10$UkE5N0qVnmuSvhTCnC4cFu1vHwyHskfHS70G455w8/qb0Ferq3Oty', '', ''),
('161710021', '21', '', '', 'active', 'k', 0, '$2y$10$Ym8mrguY7rYnX.wsMUUmz.U1R.2xtpLCNIFPfulZtF9qbJVNv0xMO', '', ''),
('161710022', '22', '', '', 'active', 'l', 0, '$2y$10$DTSc5.x8WDn8RzCvTYTLse.7SNzgbz7X4L6BIjog1pYZpb34m2/E6', '', ''),
('161710024', '24', '', '', 'active', 'n', 0, '$2y$10$uflXHqE9huY4mKxsfiVXHeaXEMuSdlI0hX4AY5Ap9kSLm.582MgpO', '', ''),
('161710025', '25', '', '', 'active', 'o', 0, '$2y$10$Fr.JTml1cI/YD1b7Up3EceSp8qHM81xrn9I8qaqam3vZTj/ae1cQm', '', ''),
('161710026', '26', '', '', 'active', 'pj', 0, '$2y$10$hcmVxuVeDGtpDIZ3MeZZ1.24XWVBHaM4RjZz5aqyFRIT9p3ZeKPXS', '', ''),
('161710027', '27', '', '', 'active', 'q', 0, '$2y$10$wLSa5yMVLBjQJFhkJsi.Y.oD3/00aRDh.yGM8eJ/6Udflluz/bdie', '', ''),
('161710028', '28', '', '', 'active', 'r', 0, '$2y$10$o.6bojtwo6XTPK9L8RqbKePgM.vPhz9LMewi2qIC/3xIbj727Pwxu', '', ''),
('161710029', '29', '', '', 'active', 's', 0, '$2y$10$v2QK2xrk50W5yKJpHb6n7OTjm3ooDdseFn0NJrVlgAbNDRe1/MLfe', '', ''),
('161710030', '30', '', '', 'active', 't', 0, '$2y$10$NHTbyO/JqMhsDumzMqRqJuxLwE1bivyCCwI/jP/s/UUAi/LtGIBfu', '', ''),
('161710031', '31', '', '', 'active', 'u', 0, '$2y$10$9i30xJxYQl6ExIDUeMM6SuRJPC74Kfh..LNgJuzrdkR8i.ON5n1hy', '', ''),
('161710032', '32', '', '', 'active', 'v', 0, '$2y$10$YbWFZ34NwHbPjiGovn8Bue3STsKvTTQZBvALc7CKfQn1Tm/AS.rA2', '', ''),
('161710033', '33', '', '', 'active', 'w', 0, '$2y$10$yU/ivRi/9JnZULsgxqZXlO3WMoovF3GJpkTEFItVfQhT8weBJ.CIy', '', ''),
('161710034', '34', '', '', 'active', 'x', 0, '$2y$10$snHtHruhQJu4xYaofyXSr.X1wVcvzMcvwyQ4tNmMQ0a72DHh5hY/C', '', ''),
('161710035', '35', '', '', 'active', 'y', 0, '$2y$10$yVBRghGy6phpi0yFP531d.udSLgOZHgUmlGbnIuyYLXyPazQ4gpHq', '', ''),
('161710036', '36', '', '', 'active', 'z', 0, '$2y$10$oFdB7ebaYd.5yzRC2TZRPu4u16lyZqnIsJ3Eh8yq3Q8W2GvIiBp.6', '', ''),
('161710037', '37', '', '', 'active', 'aa', 0, '$2y$10$Ay1bGRCgYcsdnegaSmknluSSudfYkYavjj0n86zt4A60AwSayPrtG', '', ''),
('161710038', '38', '', '', 'active', 'ab', 0, '$2y$10$d5C9/AVf7pT5owe0img/JewjemU840ur.RjrMKx54AEH7mc6T7SlW', '', ''),
('161710039', '39', '', '', 'active', 'ac', 0, '$2y$10$vsiMLRl7gpjZG2iolhSU5ufbGnzWRIDG1OXeecyD7IioAtDnTAQAa', '', ''),
('161710040', '40', '', '', 'active', 'ad', 0, '$2y$10$H34ELCmK3rDaSUlx4IhlAu596Owt84S6l580.xwy8DM/BzglE9Gjq', '', ''),
('161710041', '41', '', '', 'active', 'ae', 0, '$2y$10$hy7gaTNScbZ/EWUQr4G7LOapvNGufyovHdq.M3V4T1ipDo3M5Jch6', '', ''),
('161710042', '42', '', '', 'active', 'af', 0, '$2y$10$rn/7CqtnT.PgD8bI9snqeeZeNd0O4zh0zOHBPIy2VE6fE8l49V.ou', '', ''),
('161710043', '43', '', '', 'active', 'ag', 0, '$2y$10$mok1XFajRFB0UjS5TacC5uzJ0hbb8jnfsvuwI50.CvjiT6ueGuBI2', '', ''),
('161710044', '44', '', '', 'active', 'ah', 0, '$2y$10$4tX6ABCS8EWwmu9qWn.P/OA5PLo96iFZ0PBuAofKQUFz5AIwlET4e', '', ''),
('161710045', '45', '', '', 'active', 'aj', 0, '$2y$10$yHN3FkuvioZJkV4I7pVsPO.c4gTC/Ho5IhqXd2VF6qO/kYmPONAfe', '', ''),
('161710046', '46', '', '', 'active', 'ak', 0, '$2y$10$2SIY5UVtoH8hZbUgxaUiEe7zvDjj/LL1oRGZ1heniRRFzRltUMxCm', '', ''),
('161710047', '47', '', '', 'active', 'al', 0, '$2y$10$T.fySW15/yAgvDjvlyeGYurR80Q67b/y7ivPFFwIIOdEZDNqlCb6S', '', ''),
('161710048', '48', '', '', 'active', 'am', 0, '$2y$10$j15noZJ8oGb89APq2fFmlebs/XUnkNM.BBP5sJY6YxzPjAY9Kg.vG', '', ''),
('161710049', '49', '', '', 'active', 'an', 0, '$2y$10$pM/yrNTXED1goLvCa43Nye8qn3LcGTRe.1d6BHjSJlLzhvVEHomom', '', ''),
('161710050', '50', '', '', 'active', 'ao', 0, '$2y$10$0etC/iAGUizzLxd29cQtzu9xjrrsDZvYioIyeh4gKHMhIGc1Se1i2', '', ''),
('161710051', '51', '', '', 'active', 'ap', 0, '$2y$10$l1QeprvWP84E1r9wVE4Wm.thKB7/NgDQtOaBqknOn4iFS6CCcTTAu', '', ''),
('161710052', '52', '', '', 'active', 'aq', 0, '$2y$10$kxpoAAC2yhkDOkapeJanDuYLfbKKa/h5tR9Kfrjrq/b2REqJ3gGfK', '', ''),
('161710053', '53', '', '', 'active', 'ar', 0, '$2y$10$Gf70uDOq8qEMs8O1Xqtg.eNHUM4BLClMu0dOZBp5dXy3yGK6YQ8Ci', '', ''),
('161710054', '54', '', '', 'active', 'as', 0, '$2y$10$mQ8Ut8UxQQ2camkfL14l5.CjEnJZi1MgOBicDzQQPBPNbtnVpW/gW', '', ''),
('161710055', '55', '', '', 'active', 'at', 0, '$2y$10$N/AvW5nmwbQ2c1FvkZXkNO2c5zJcc5CETVaFOb10.tE7L.Mhh1oOa', '', ''),
('161710056', '56', '', '', 'active', 'au', 0, '$2y$10$Ok9W9H//gZ5.hrlAERKJfOhVGRtDlG8oFyj/aSJR/eBrzZfii7kvC', '', ''),
('161710057', '57', '', '', 'active', 'av', 0, '$2y$10$jH5QZEAtj2xAxL5La..s7ePQQlS8cLCr.HqXKr6hcIn8D.XTRcxtW', '', ''),
('161710058', '58', '', '', 'active', 'aw', 0, '$2y$10$ATOoe.HHzq1Wnwf54M13yeHUQU.0WwSpCKUkpJIZRmDeBzmcXOsqe', '', ''),
('161710059', '59', '', '', 'active', 'ax', 0, '$2y$10$edamOwPhvBaZeQKtbTVwculbNOPJnGnbDGCP1vqPd01M7rmrhH6L2', '', ''),
('161710060', '60', '', '', 'active', 'ay', 0, '$2y$10$ZhgEsS8GsNQJ3ZDrbRFYTu1XasYI7l4NN59Ay8hGxjEVswumgYllO', '', ''),
('161710061', '61', '', '', 'active', 'az', 0, '$2y$10$d9.N2g6FfgMiahSWQso0F.9dFLCJwihvOEOjhDoV1sJ7Y98g7QMsa', '', ''),
('161710062', '62', '', '', 'active', 'a', 0, '$2y$10$JyuPpHzCL3tJU5S1ecGeK.I5y9GbxqlEGTbmMZSfwlbIrjhNjVli6', '', ''),
('161710063', '63', '', '', 'active', 'aa', 0, '$2y$10$.aSD.fDxef1NY1giRBk.Cef20cLGDxtSRVHbUoWG.I7n8SfMYxJ.G', '', ''),
('161710064', '64', '', '', 'active', 'aaa', 0, '$2y$10$D.6lcKWjDpHqt0lcRUAcRuGpdcBbrHpP37nHlwz9K8STqZB/Tif0q', '', ''),
('161710065', '65', '', '', 'active', 'aaaa', 0, '$2y$10$IY485NyrHJZ22Juzs9peMObprGvg8JUGaIHYw/k2Bac1MMdVd5msu', '', ''),
('161710066', '66', '', '', 'active', 'aaaaa', 0, '$2y$10$i2nUs0X6kKJ1QP39gavKNuUgV2Enfgws56hbn0ofk6v9/SzSJjk5.', '', ''),
('161710067', '67', '', '', 'active', 'aaaaaa', 0, '$2y$10$/XKg7NiHNHpm8rtDrUnYCul.oLKHI5CEPPrhWj07o5FTQFxblZ5/G', '', ''),
('161710068', '68', '', '', 'active', 'b', 0, '$2y$10$FY2LGeuJ6ep.SYAtPjVhVODSkoWsMaunsjgIZDWeJl1FvzKcvckai', '', ''),
('161710069', '69', '', '', 'active', 'bb', 0, '$2y$10$P8O3ZfeW3hBdYsoCRjIJQOZjrn7EKvCVx2vuPL17AChYpZB6/4LnK', '', ''),
('161710070', '70', '', '', 'active', 'bbb', 0, '$2y$10$UKk8NIQxN330T/22v0LHUuQ0/Cn7yVovWhfpPumt1TzewvkCI1aNC', '', ''),
('161710071', '71', '', '', 'active', 'bbbb', 0, '$2y$10$rFJYAnANGJyLeisif2AgMeIog0IXOpWbCjlanie3zOk0dxQCjWpkS', '', ''),
('161710072', '72', '', '', 'active', 'bbbbb', 0, '$2y$10$TRetEp4gfRMt3zf61jIc8OcImuGzSfzXNXZ.k0jlVx5KH1K1CHfd6', '', ''),
('161710073', '73', '', '', 'active', 'bbbbbb', 0, '$2y$10$5fC1pXJ075weepMoMFnutOL.RXIA47M/Z2Uk8B4ieNFmCiP.DqlX2', '', ''),
('161710074', '74', '', '', 'active', 'c', 0, '$2y$10$E9fWlaPObZ.thv9.ALPFhO071XZb.2fugtIMIxQRdrSuJM.MAxBFe', '', ''),
('161710075', '75', '', '', 'active', 'cc', 0, '$2y$10$cbG1f0fHt1U1Ro3.AL0px.MIHtSsxydDnY.eYuKYQyoRTda14fbhS', '', ''),
('161710076', '76', '', '', 'active', 'ccc', 0, '$2y$10$4Arfl6AsKdaA744PBL.mBex5iv.IIcfcEDi8jyOPVIKBJzcYL7D1K', '', ''),
('161710077', '77', '', '', 'active', 'cccc', 0, '$2y$10$renvbm4F0EAmiQrDejJJ6O.QT4M2N3PGUTu1Ou7fSnq2m0SZj6NGm', '', ''),
('161710078', '78', '', '', 'active', 'ccccc', 0, '$2y$10$8Qsz.WgkqHn4eKeTCeRrNO62A1IZfLJb0alC9UxWfPYrZjvvBhFf2', '', ''),
('161710079', '79', '', '', 'active', 'cccccc', 0, '$2y$10$y4W/xfwzQuYe20OE5OpOVeYGPj2yarYLVeqBAhJBmcXyy.tGuuIBm', '', ''),
('161710080', '80', '', '', 'active', 'ccccccc', 0, '$2y$10$aAzRGMRHr7Z9LmdCB6JVle5x9vW8/qSRcSowCTzMjKgo2KtdGVhoy', '', ''),
('161710081', '81', '', '', 'active', 'd', 0, '$2y$10$.nNQuLX/lLEjaJgd7qQFguepIr2eFotdp0Av9mDMMgEuEkc/SH5Ye', '', ''),
('161710082', '82', '', '', 'active', 'dd', 0, '$2y$10$mq0BjumHQMhRWXxUe3SLYepF6SpN5J5NfTgOtx4Iek2u9GzN3RsiW', '', ''),
('161710083', '83', '', '', 'active', 'ddd', 0, '$2y$10$WLi7Or6ItRLZJmZBVGkGw.T6lzFRB8.82N/LuNvbaOHL6EPZjPTK.', '', ''),
('161710084', '84', '', '', 'active', 'dddd', 0, '$2y$10$0.eLoXC/vozKWwzlJilxGe1Fr7evtCCvxfXyhl9AQQ1D8.U44AFUK', '', ''),
('161710085', '85', '', '', 'active', 'ddddd', 0, '$2y$10$5cmb/4gugRsiyJEX1LP6mefbNMEXke0TOWCA9Bh9T198MHX6o9hbS', '', ''),
('161710086', '86', '', '', 'active', 'dddddd', 0, '$2y$10$5t.dTMoqOYiX0LtDO6vVWua2S.3AT00bGKvyrvxmdpxZYtscIpYyO', '', ''),
('161710087', '87', '', '', 'active', 'e', 0, '$2y$10$Vez7ecNyyukWI0BkVmzxoOKvB8.7BQOa4P.10IAJds9IrylAn9aR2', '', ''),
('161710088', '88', '', '', 'active', 'ee', 0, '$2y$10$tlef5OXTNsGI5ekERS.qTOWFHnBnzeLLOo5jII2xDNzKne5sT319C', '', ''),
('161710089', '89', '', '', 'active', 'eee', 0, '$2y$10$Fb9yiuAaajK8VBrMySpmHeai4Humt1NBSAZDMXEAptpttHRmMUVd2', '', ''),
('161710090', '90', '', '', 'active', 'eeee', 0, '$2y$10$hnpAms1c28GQiW4NAtqlG.ff/jLJEstQGlMvSMjTRXeacr7gLOHmi', '', ''),
('161710091', '91', '', '', 'active', 'eeeee', 0, '$2y$10$Snm4.vOiRQCpYzX9nW3X.u2DYCc/8l6Hd1WXrk9Nmojfm6MnJKNNW', '', ''),
('161710092', '92', '', '', 'active', 'eeeeee', 0, '$2y$10$gUrRVL12lAdIvHoGKCo86.wLHqdX3TmGSKlrfTuNwvHgxPU3j15ei', '', ''),
('161710093', '93', '', '', 'active', 'f', 0, '$2y$10$nXWo9/TOJO1yqQbNWNQmWuL.EssT28MFkZqrlGXFgOsu/th0Zc0oO', '', ''),
('161710094', '94', '', '', 'active', 'ff', 0, '$2y$10$TJweSULt6FeQB.AniGbYMOUB5m89pzp.fjpOXrRVuCUSzkzy.0qbG', '', ''),
('161710095', '95', '', '', 'active', 'fff', 0, '$2y$10$Ll3FYlfobIIN9a6VQnc6R.HAMXZqJ.ssejZT.pOWFs2.ZZYX84.QS', '', ''),
('161710096', '96', '', '', 'active', 'ffff', 0, '$2y$10$68lWh78iFCtc0lESRqEapeQO4NVFKq5bVPq28PLj0HPZffTepthPe', '', ''),
('161710097', '97', '', '', 'active', 'fffff', 0, '$2y$10$cPNyaX.5N/P9cgKuFphRXe3wo/cWFC20BiqKcfpwvVnBGdbQomve2', '', ''),
('161710098', '98', '', '', 'active', 'ffffff', 0, '$2y$10$w373TIyIUr0kPvJ46W.mJO56dqMcrSHWBPSyhcnb5lUdQppZlxXpW', '', ''),
('161710099', '99', '', '', 'active', 'g', 0, '$2y$10$F4CoJWnIzU2xe7cLGAuH.eCLO1L4kHzkpLN.XOpK5Q88FjLalLGcS', '', ''),
('161710218', '0049119379', 'matthewmcavaio@gmail.com', '0888888881270', 'active', 'Matthew Christopher Albert', 709500, '$2y$10$xAhN7wj80xQ0CXIfNlYEBe7tR/RaC13cOileEaZwi0.UoeI6eyMTG', '$2y$10$p4dpbLufIXeeX.ZDrhUJAOqzilu5lzliw0cJhxKF6qxdUrkN2.Po.', 'dadasd'),
('234567890', '2', '', '', 'banned', 'Lorem Ipsum', 150000, '', '', ''),
('321312', '3', '', '', 'active', 'Matthew', 310000, '', '', ''),
('45325234', '212421455212', '', '', 'active', 'Lores', 0, '$2y$10$e9vz.rgfiSTvikK7dtUh9.6gZc6YIgYeJKUNfJOLnVndvH3cD03D2', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `id` varchar(16) NOT NULL,
  `card_id` varchar(32) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `status` varchar(16) NOT NULL,
  `name` varchar(64) NOT NULL,
  `balance` int(11) NOT NULL,
  `password` char(64) NOT NULL,
  `pin` char(64) NOT NULL,
  `token` char(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`id`, `card_id`, `email`, `phone`, `status`, `name`, `balance`, `password`, `pin`, `token`) VALUES
('123456777', '1', '', '', 'active', 'Leo', 50000, '', '', ''),
('12424141', '241414125', '', '', 'active', 'Nia', 0, '$2y$10$gbLmcPJmXVA/pd5n67NYfOmw30NNXNhObve7gWk6eGyEgcOJeZ8um', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `machine_id` varchar(32) NOT NULL,
  `sender` varchar(32) NOT NULL,
  `receiver` varchar(32) NOT NULL,
  `type` varchar(16) NOT NULL,
  `value` int(11) NOT NULL,
  `description` varchar(64) NOT NULL,
  `status` varchar(10) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `machine_id`, `sender`, `receiver`, `type`, `value`, `description`, `status`, `time`) VALUES
(1, 'admin_terminal_01', '1', '0', 'Top Up', 100000, 'Transaction Succesful!', '', '2018-05-03 08:15:34'),
(2, 'admin_terminal_01', '1', '0', 'Top Up', 10000, 'Transaction Succesful!', '', '2018-05-07 09:30:47'),
(3, 'admin_terminal_01', '1', '0', 'Top Up', 10000, 'Transaction Succesful!', '', '2018-05-07 09:32:13'),
(4, 'admin_terminal_01', '3', '0', 'Top Up', 10000, 'Transaction Succesful!', '', '2018-05-07 16:11:03'),
(5, 'admin_terminal_01', '1', '0', 'Top Up', 10000, 'Transaction Succesful!', '', '2018-05-07 16:12:01'),
(6, 'admin_terminal_01', '3', '1', 'Pay', 10000, 'Transaction Succesful!', '', '2018-05-07 16:17:11'),
(7, 'admin_terminal_01', '1', '0', 'Top Up', 10000, 'Transaction Succesful!', '', '2018-05-08 07:14:40'),
(8, 'admin_terminal_01', '1', '0', 'Top Up', 10000, 'Transaction Succesful!', '', '2018-05-08 07:17:31'),
(9, 'admin_terminal_01', '1', '0', 'Withdraw', 10000, 'Transaction Succesful!', '', '2018-05-12 03:56:05'),
(10, 'admin_terminal_01', '49119379', '0', 'Top Up', 1000000, 'Top Up Successful', '', '2018-05-12 09:32:20'),
(11, 'admin_terminal_01', '49119379', '0', 'Top Up', 100000, 'Top Up Successful', '', '2018-05-12 09:34:27'),
(12, 'admin_terminal_01', '1', '0', 'Top Up', 34, 'Top Up Successful', '', '2018-05-12 18:49:02'),
(13, 'admin_terminal_01', '1', '0', 'Withdraw', 2, 'Withdraw Succesful!', '', '2018-05-12 18:57:31'),
(14, 'admin_terminal_01', '1', '0', 'Withdraw', 10000, 'Withdraw Succesful!', '', '2018-05-12 18:58:42'),
(15, 'admin_terminal_01', '1', '0', 'Withdraw', 10000, 'Withdraw Succesful!', '', '2018-05-12 18:58:56'),
(16, 'admin_terminal_01', '1', '0', 'Withdraw', 10000, 'Withdraw Succesful!', '', '2018-05-12 18:59:11'),
(17, 'admin_terminal_01', '1', '0', 'Withdraw', 100000000, 'Transaction Failed!', '', '2018-05-12 18:59:19'),
(18, 'admin_terminal_01', '1', '0', 'Withdraw', 100000000, 'Transaction Failed!', '', '2018-05-12 19:00:10'),
(19, 'admin_terminal_01', '1', '0', 'Withdraw', 100000000, 'Transaction Failed!', '', '2018-05-12 19:00:36'),
(20, 'admin_terminal_01', '1', '0', 'Withdraw', 100000000, 'Transaction Failed!', '', '2018-05-12 19:01:33'),
(21, 'admin_terminal_01', '1', '0', 'Withdraw', 100000000, 'Transaction Failed!', '', '2018-05-12 19:03:29'),
(22, 'admin_terminal_01', '1', '0', 'Withdraw', 100000000, 'Transaction Failed!', '', '2018-05-12 19:04:20'),
(23, 'admin_terminal_01', '1', '0', 'Withdraw', 100000000, 'Transaction Failed!', '', '2018-05-12 19:04:38'),
(24, 'admin_terminal_01', '49119379', '0', 'Withdraw', 100000, 'Withdraw Succesful!', '', '2018-05-18 14:50:00'),
(25, 'root', 'booth', '161710218', 'Withdraw', 100000, 'Top Up Success (Rp 100,000) ( Matthew Christopher Albert )', '', '2018-06-06 12:45:56'),
(26, 'root', 'booth', '161710218', 'Withdraw', 10000, 'Top Up Success!', '', '2018-06-06 12:49:49'),
(27, 'root', '161710218', '161710010', 'Transfer', 100000, 'Transfer Success!', '', '2018-06-06 13:05:02'),
(28, 'root', 'admin-site', '161710218', 'Top Up', 1000000, 'Top Up Success!', '', '2018-06-06 13:06:01'),
(29, 'root', '161710218', '161710010', 'Transfer', 100000, 'Transfer Success!', '', '2018-06-06 13:06:22'),
(30, 'root', '161710218', '161701', 'Transfer', 100000, 'Pay Success!', '', '2018-06-06 13:10:58'),
(31, 'website-app-161710218', '161710218', '123456789', 'Transfer', 10000, 'Transfer Success! (Matthew Christopher Albert to John Doe)', 'success', '2018-06-12 16:14:01'),
(32, 'website-app-161710218', '161710218', '123456789', 'Transfer', 10000, 'Transfer Success! (Matthew Christopher Albert to John Doe)', 'success', '2018-06-12 16:39:21'),
(33, 'website-app-161710218', '161710218', '123456789', 'Transfer', 10000, 'Transfer Success! (Matthew Christopher Albert to John Doe)', 'success', '2018-06-12 16:41:47'),
(34, 'website-app-161710218', '161710218', '123456789', 'Transfer', 1000000, 'Balance not Enough!', 'failed', '2018-06-12 19:10:36'),
(35, 'website-app-161701', '161701', '161710218', 'Transfer', 100000, 'Transfer Success! (Sour Sally to Matthew Christopher Albert)', 'success', '2018-06-13 11:00:32'),
(36, 'root', '161710218', 'admin-site', 'Top Up', 100000, 'Top Up Success!', 'success', '2018-06-13 17:42:50'),
(37, 'root', 'admin-site', '161710218', 'Withdraw', 100000, 'Withdrawal Success!', 'success', '2018-06-13 17:43:36'),
(38, 'root', '161710218', 'admin-site', 'Top Up', 100000, 'Top Up Success!', 'success', '2018-06-13 18:11:40'),
(39, 'root', 'admin-site', '161710218', 'Withdraw', 100000, 'Withdrawal Success!', 'success', '2018-06-13 18:12:12'),
(40, 'root', '161710218', 'admin-site', 'Top Up', 100000, 'Top Up Success!', 'success', '2018-06-17 05:26:33'),
(41, 'root', 'admin-site', '161710218', 'Withdraw', 100000, 'Withdrawal Success!', 'success', '2018-06-17 05:30:49'),
(42, 'root', '161710218', 'admin-site', 'Top Up', 50000, 'Top Up Success!', 'success', '2018-06-17 05:31:18'),
(43, 'root', '161710218', '161701', 'Transfer', 10000, 'Pay Success!', 'success', '2018-06-17 05:34:29'),
(44, 'website-app-161710218', '161710218', '161701', 'Transfer', 10000, 'Transfer Success! (Matthew Christopher Albert to Sour Sally)', 'success', '2018-06-17 05:36:28'),
(45, 'website-app-161710218', '161710218', '161701', 'Transfer', 100000, 'Transfer Success! (Matthew Christopher Albert to Sour Sally)', 'success', '2018-06-17 05:37:29'),
(46, 'website-app-161710218', '161710218', '161701', 'Transfer', 10000, 'Transfer Success! (Matthew Christopher Albert to Sour Sally)', 'success', '2018-06-17 06:29:30'),
(47, 'website-app-161710218', '161710218', '161701', 'Transfer', 10000, 'Transfer Success! (Matthew Christopher Albert to Sour Sally)', 'success', '2018-06-17 06:58:28'),
(48, 'root', '161710218', 'admin-site', 'Top Up', 100000, 'Top Up Success!', 'success', '2018-06-18 14:24:01'),
(49, 'EDC_Machine-171802', '161710218', '171802', 'Transfer', 5000, '', 'success', '2018-08-19 13:36:32'),
(50, 'EDC_Machine-171802', '161710218', '171802', 'Transfer', 5000, '', 'success', '2018-08-19 13:41:22'),
(51, 'EDC_Machine-171802', '161710218', '171802', 'Transfer', 5000, '', 'success', '2018-08-19 13:43:18'),
(52, 'EDC_Machine-171802', '161710218', '171802', 'Transfer', 5000, '', 'success', '2018-08-19 14:45:53'),
(53, 'EDC_Machine-171802', '161710218', '171802', 'Transfer', 5000, '', 'success', '2018-08-19 14:52:47'),
(54, 'EDC_Machine-171802', '161710218', '171802', 'Pay', 5000, '', 'success', '2018-08-19 15:31:48'),
(55, 'EDC_Machine-171802', '161710218', '171802', 'Pay', 5000, '', 'success', '2018-08-19 15:32:59'),
(56, 'EDC_Machine-171802', '161710218', '171802', 'Pay', 5000, '', 'success', '2018-08-19 15:38:18'),
(57, 'EDC_Machine-171802', '161710218', '171802', 'Pay', 5000, '', 'success', '2018-08-19 16:26:16'),
(58, 'EDC_Machine-171802', '161710218', '171802', 'Pay', 5000, '', 'success', '2018-08-23 12:00:20'),
(59, 'EDC_Machine-171802', '161710218', '171802', 'Pay', 10000, '', 'success', '2018-08-23 12:02:36'),
(60, 'EDC-edc01-171802', '161710218', '171802', 'Pay', 5000, '', 'success', '2018-08-23 12:46:01'),
(61, 'EDC-edc01-171802', '161710218', '171802', 'Pay', 5000, '', 'success', '2018-08-23 12:47:10'),
(62, 'EDC-edc01-171802', '161710218', '171802', 'Pay', 5000, '', 'success', '2018-08-23 13:07:40'),
(63, 'EDC-edc01-171802', '161710218', '171802', 'Pay', 5000, '', 'success', '2018-08-23 14:54:49'),
(64, 'EDC-edc01-171802', '161710218', '171802', 'Pay', 5000, '', 'success', '2018-08-24 19:39:57'),
(65, 'EDC-edc01-171802', '161710218', '171802', 'Pay', 5000, '', 'success', '2018-08-24 19:42:19'),
(66, 'EDC-edc01-171802', '161710218', '171802', 'Pay', 5000, '', 'success', '2018-08-24 19:47:09'),
(67, 'EDC-edc01-171802', '161710218', '171802', 'Pay', 5000, '', 'success', '2018-08-24 19:50:16'),
(68, 'EDC-edc01-171802', '161710218', '171802', 'Pay', 5000, '', 'success', '2018-08-26 08:57:54'),
(69, 'EDC-edc01-171802', '161710218', '171802', 'Pay', 5000, '', 'success', '2018-08-26 09:03:51'),
(70, 'EDC-edc01-171802', '161710218', '171802', 'Pay', 2000, '', 'success', '2018-08-26 09:53:15'),
(71, 'EDC-edc01-171802', '161710218', '171802', 'Pay', 2000, '', 'success', '2018-08-28 10:13:23'),
(72, 'EDC-edc01-171802', '161710218', '171802', 'Pay', 5000, '', 'success', '2018-08-28 10:42:22'),
(73, 'EDC-edc01-171802', '161710218', '171802', 'Pay', 5000, '', 'success', '2018-08-28 11:21:24'),
(74, 'veritrans_bot', '161710218', 'Veritrans Pay', 'Top Up', 1000, 'Top Up via ', 'success', '2018-10-12 14:30:15'),
(75, 'webapp-161710218', '161710218', '161710010', 'Transfer', 10000, 'Transfer Success! (Matthew Christopher Albert to Alma)', 'success', '2019-01-25 16:12:44'),
(76, 'webapp-161710218', '161710218', '161710010', 'Transfer', 5000, 'Transfer Success! (Matthew Christopher Albert to Alma)', 'success', '2019-01-25 16:16:52'),
(77, 'webapp-161710218', '161710218', '161710010', 'Transfer', 10000, 'Transfer Success! (Matthew Christopher Albert to Alma)', 'success', '2019-01-26 13:43:32'),
(78, 'webapp-161710218', '161710218', '161710010', 'Transfer', 2500, 'Transfer Success! (Matthew Christopher Albert to Alma)', 'success', '2019-01-26 14:24:37'),
(79, 'webapp-161710218', '161710218', '161710010', 'Transfer', 10000, 'Transfer Success! (Matthew Christopher Albert to Alma)', 'success', '2019-01-26 19:15:41'),
(80, 'webapp-161710218', '161710218', '161710010', 'Transfer', 10000, 'Transfer Success! (Matthew Christopher Albert to Alma)', 'success', '2019-01-26 20:38:06');

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `id` varchar(16) NOT NULL,
  `card_id` varchar(32) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `status` varchar(16) NOT NULL,
  `name` varchar(64) NOT NULL,
  `balance` int(11) NOT NULL,
  `password` char(64) NOT NULL,
  `pin` char(64) NOT NULL,
  `token` char(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`id`, `card_id`, `email`, `phone`, `status`, `name`, `balance`, `password`, `pin`, `token`) VALUES
('161701', '1', '', '', 'active', 'Sour Sally', 240000, '$2y$10$6qHGwXaV7xvmZG.ctANR3uO/1yBeIgYiEJVpg/lbJCCUnBuTNu.xW', '', ''),
('171802', '2', '', '', 'active', 'Si Tante', 224000, '$2y$10$ZW5omvpzYuh/nxvFc33GxOop8JORMR29cVllIo84r03YSA8opxIoq', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `veritrans`
--

CREATE TABLE `veritrans` (
  `id` varchar(50) NOT NULL,
  `type` varchar(20) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `value` int(11) NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `veritrans`
--

INSERT INTO `veritrans` (`id`, `type`, `user_id`, `value`, `status`) VALUES
('1083838509', 'Top Up', '161710218', 100000, 'expire'),
('T-1539252465', 'Top Up', '161710218', 1000, 'finished'),
('T-1548574445619', 'Top Up', '161710218', 12000, 'pending');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `api`
--
ALTER TABLE `api`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `api_key` (`api_key`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `help`
--
ALTER TABLE `help`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `card_id` (`card_id`),
  ADD UNIQUE KEY `nis` (`id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nis` (`id`),
  ADD UNIQUE KEY `card_id` (`card_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `card_id` (`card_id`);

--
-- Indexes for table `veritrans`
--
ALTER TABLE `veritrans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `help`
--
ALTER TABLE `help`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
