-- phpMyAdmin SQL Dump
-- version 4.2.0-dev
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 07, 2014 at 02:31 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ams_v0.3`
--

--
-- Dumping data for table `user_master`
--

INSERT INTO `User_Master` (`user_name`, `email_id`, `enc_algo`, `salt_type`, `salt`, `user_password`, `user_status`, `user_creation_date`, `user_update_date`, `faculty_id`, `privilege_id`) VALUES
('admin', 'admin@salam.com', 1, 1, '1024823780535d64ce7fd332.53283497', '9eb62f5887240a9bd354d1a8a5d7d5ff863158184282c655c5334b7cf500e40b81cd46f7c6d808fb13b03c2bb04bfba0b55896f9c98931fab39cb2bd34b5c10e', 1, '2014-04-28 01:43:02', '2014-04-27 20:13:02', NULL, 1),
('developer', 'chirayu.chiripal@gmail.com', 1, 1, '5502270520611a146ed63.60627028', '5bfa6548ed74bfe9bb8396e52d10222ca274eb8376a2b24d323a7a5a7cd5c368f1f1c2163cca172a6f836d727c7a77fa4e7ced9ff0a53caf120071f15604ed75', 0, '2013-09-22 00:00:00', '2014-02-07 11:32:25', NULL, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
