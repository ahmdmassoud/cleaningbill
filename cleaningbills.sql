-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2018 at 08:40 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cleaningbills`
--

-- --------------------------------------------------------

--
-- Table structure for table `billpayers`
--

CREATE TABLE `billpayers` (
  `id` int(200) NOT NULL,
  `billerName` text NOT NULL,
  `billerAddress` text NOT NULL,
  `billerPost` int(200) NOT NULL,
  `billerCity` text NOT NULL,
  `customerId` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `billpayers`
--

INSERT INTO `billpayers` (`id`, `billerName`, `billerAddress`, `billerPost`, `billerCity`, `customerId`) VALUES
(7, 'Anie Mosrak', 'kolkaska 22', 20122, 'Alexandria', 21),
(8, 'Mynlslibla nolmak', 'Barbara 6', 7505, 'alexand', 23),
(9, 'Ulla West', 'Husstigen 6', 2400, 'Kirkkonummi', 25),
(10, 'Anie asdfgh', 'asdf', 99, 'asd', 27);

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` int(200) NOT NULL,
  `customerId` int(200) NOT NULL,
  `dates` text NOT NULL,
  `payType` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `customerId`, `dates`, `payType`) VALUES
(25, 20, '18.08.2018', 0),
(26, 22, '19.08.2018', 0),
(27, 23, '19.08.2018', 1),
(28, 23, '19.08.2018', 1),
(29, 21, '19.08.2018', 1),
(30, 24, '19.08.2018', 1),
(31, 25, '19.08.2018', 1),
(32, 26, '19.08.2018', 1),
(33, 27, '19.08.2018', 1),
(34, 24, '28.12.2018', 1),
(35, 24, '28.12.2018', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(250) NOT NULL,
  `name` text NOT NULL,
  `address` text NOT NULL,
  `post` int(250) NOT NULL,
  `city` text NOT NULL,
  `billPayer` int(2) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `address`, `post`, `city`, `billPayer`) VALUES
(20, 'Ahmed Khairy', 'beer saba street from 20 street', 21616, 'Alexandria', 1),
(21, 'Marina Korrelef', 'kyrkvalla 23', 2015, 'kirkkonummi', 0),
(22, 'Anna Koralline', 'Kolbalksa 55', 9999, 'Helisinki', 1),
(23, 'Kirisban nasroly', 'Liverboolklas', 5210, 'Livervool', 0),
(24, 'Eva Berg', 'Kalasaari 54 A 12', 510, 'Helsinki', 1),
(25, 'Anders West', 'Husstigen 5', 2400, 'Kirkkonummi', 0),
(26, 'Ahmed kioookk', 'beer saba street from 20 street', 21616, 'Alexandria', 1),
(27, 'Mrom doen', 'ookkh', 1000, 'kirkkonummi', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(200) NOT NULL,
  `billid` int(200) NOT NULL,
  `taskName` text NOT NULL,
  `unit` text NOT NULL,
  `unitPrice` int(200) NOT NULL,
  `amount` int(200) NOT NULL,
  `taxPercentage` int(200) NOT NULL,
  `dates` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `billid`, `taskName`, `unit`, `unitPrice`, `amount`, `taxPercentage`, `dates`) VALUES
(62, 25, 'cleaning', 'h', 20, 3, 24, '2018-08-14'),
(63, 25, 'cleaning', 'h', 20, 3, 24, '2018-08-14'),
(64, 26, 'Cleaning', 'h', 20, 2, 24, '2018-08-14'),
(65, 26, 'Cleaning', 'h', 20, 2, 24, '2018-08-14'),
(66, 27, 'cleaning', 'h', 20, 2, 24, '2018-08-14'),
(67, 28, 'casing', 'h', 20, 5, 24, '2018-08-08'),
(68, 28, 'helbing', 'h', 12, 2, 24, '2018-08-06'),
(69, 29, 'Städning', 'h', 20, 5, 24, '2018-08-08'),
(70, 29, 'helbing', 'h', 20, 2, 24, '2018-08-10'),
(71, 30, 'Städning', 'h', 20, 1, 24, '2018-08-15'),
(72, 30, 'Städning', 'h', 20, 2, 24, '2018-08-15'),
(73, 30, 'Städning', 'h', 20, 5, 24, '2018-08-21'),
(74, 31, 'Städning', 'h', 20, 5, 24, '2018-08-15'),
(75, 32, 'Städning', 'h', 20, 2, 24, '2018-08-01'),
(76, 32, 'Städning', 'h', 20, 3, 24, '2018-08-08'),
(77, 33, 'Städning', 'h', 20, 5, 24, '2018-08-02'),
(78, 34, 'Städning', 'h', 20, 2, 24, '2018-12-19'),
(79, 35, 'Städning', 'h', 20, 2, 24, '2018-12-19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `billpayers`
--
ALTER TABLE `billpayers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`,`billid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `billpayers`
--
ALTER TABLE `billpayers`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
