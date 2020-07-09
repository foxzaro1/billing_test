-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jul 08, 2020 at 10:42 PM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `avito-billing`
--

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` int(11) NOT NULL,
  `fio` varchar(120) NOT NULL,
  `card_number` bigint(19) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `fio`, `card_number`, `time`) VALUES
(33, 'Сергей', 2202201490783756, '2020-07-08 19:41:22');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `nomitation` varchar(55) NOT NULL,
  `status` varchar(55) NOT NULL,
  `amount` double NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `backRef` varchar(500) NOT NULL,
  `hash` varchar(100) NOT NULL,
  `sessionID` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `nomitation`, `status`, `amount`, `time`, `backRef`, `hash`, `sessionID`) VALUES
(31, 'nav12', 'N', 2500, '2020-07-08 19:36:18', 'https://yandex.ru/payments/', 'c5db582602ebf36b5f51a35a99dbcb85', 'c5db582602ebf36b5f51a35a99dbcb85-1594236978'),
(32, 'test', 'W', 12500, '2020-07-08 19:38:09', 'https://yandex.ru/payments/', '66ea05bb038d4eac46768e96663e5947', '66ea05bb038d4eac46768e96663e5947-1594237089'),
(33, 'test', 'Y', 52500, '2020-07-08 19:38:35', 'https://yandex.ru/payments/', '10b19f5d3b24621cc5313c5260dedead', '10b19f5d3b24621cc5313c5260dedead-1594237115');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
