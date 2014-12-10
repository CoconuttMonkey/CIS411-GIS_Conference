-- phpMyAdmin SQL Dump
-- version 2.8.0.1
-- http://www.phpmyadmin.net
-- 
-- Host: custsql-ipg02.eigbox.net
-- Generation Time: Dec 03, 2014 at 12:37 PM
-- Server version: 5.5.32
-- PHP Version: 4.4.9
-- 
-- Database: `cis411_gisconference`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `attendee`
-- 

CREATE TABLE `attendee` (
  `user_id` int(11) NOT NULL,
  `address_1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `zip` int(10) NOT NULL,
  `country` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `phone` int(10) NOT NULL,
  `admission_type` int(11) NOT NULL,
  `paid` set('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Dumping data for table `attendee`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `attendee_conference_lookup`
-- 

CREATE TABLE `attendee_conference_lookup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `conference_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `conference_id` (`conference_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `attendee_conference_lookup`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `conference`
-- 

CREATE TABLE `conference` (
  `conf_id` int(4) NOT NULL COMMENT 'Year of conference',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prefix` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `theme` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reg_open_date` date NOT NULL,
  `reg_close_date` date NOT NULL,
  `frontpage_content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `banner` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `schedule` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`conf_id`),
  KEY `conf_id` (`conf_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Dumping data for table `conference`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `exhibit`
-- 

CREATE TABLE `exhibit` (
  `exhibit_id` int(11) NOT NULL AUTO_INCREMENT,
  `conference_id` int(11) NOT NULL,
  `company_profile` text COLLATE utf8_unicode_ci NOT NULL,
  `special_requests` text COLLATE utf8_unicode_ci NOT NULL,
  `paid` set('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `table_loc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`exhibit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

-- 
-- Dumping data for table `exhibit`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `exhibitor`
-- 

CREATE TABLE `exhibitor` (
  `user_id` int(11) NOT NULL,
  `exhibit_id` int(11) NOT NULL,
  `is_main` set('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  PRIMARY KEY (`user_id`),
  KEY `user_id` (`user_id`),
  KEY `exhibit_id` (`exhibit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Dumping data for table `exhibitor`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `groups`
-- 

CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `groups`
-- 

INSERT INTO `groups` VALUES (1, 'admin', 'Administrator');
INSERT INTO `groups` VALUES (2, 'members', 'General User');

-- --------------------------------------------------------

-- 
-- Table structure for table `login_attempts`
-- 

CREATE TABLE `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `login_attempts`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `presentation`
-- 

CREATE TABLE `presentation` (
  `presentation_id` int(11) NOT NULL AUTO_INCREMENT,
  `conference_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `abstract` text COLLATE utf8_unicode_ci NOT NULL,
  `track_id` int(11) NOT NULL,
  `scheduled` set('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `presentation_attachment` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `week_day` set('Thursday','Friday','nopref') COLLATE utf8_unicode_ci NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`presentation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

-- 
-- Dumping data for table `presentation`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `presenter`
-- 

CREATE TABLE `presenter` (
  `user_id` int(11) NOT NULL,
  `presentation_id` int(11) NOT NULL,
  `is_main` set('yes','no') COLLATE utf8_unicode_ci DEFAULT 'no',
  `biography` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`user_id`),
  KEY `presentation_id` (`presentation_id`),
  KEY `is_main` (`is_main`),
  KEY `presentation_id_2` (`presentation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Dumping data for table `presenter`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `room`
-- 

CREATE TABLE `room` (
  `room_id` int(11) NOT NULL AUTO_INCREMENT,
  `conference_id` int(11) NOT NULL,
  `room_number` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `building` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`room_id`),
  KEY `conference_id` (`conference_id`),
  KEY `conference_id_2` (`conference_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

-- 
-- Dumping data for table `room`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `settings`
-- 

CREATE TABLE `settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `active_conference` int(4) NOT NULL,
  `billing_email` varchar(255) NOT NULL DEFAULT '',
  `contact_email` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `settings`
-- 

INSERT INTO `settings` VALUES (0, 2014, 'gisconferencebilling@clarion.edu', 'gisconference@clarion.edu');

-- --------------------------------------------------------

-- 
-- Table structure for table `sponsor`
-- 

CREATE TABLE `sponsor` (
  `sponsor_id` int(11) NOT NULL AUTO_INCREMENT,
  `conference_id` int(11) NOT NULL,
  `main_contact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paid` set('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `sponsor_level` int(11) NOT NULL,
  PRIMARY KEY (`sponsor_id`),
  UNIQUE KEY `company_name` (`company_name`),
  KEY `conference_id` (`conference_id`),
  KEY `conference_id_2` (`conference_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

-- 
-- Dumping data for table `sponsor`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `track`
-- 

CREATE TABLE `track` (
  `track_id` int(11) NOT NULL AUTO_INCREMENT,
  `conference_id` int(11) NOT NULL,
  `acronym` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `full_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`track_id`),
  KEY `conference_id` (`conference_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

-- 
-- Dumping data for table `track`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- 
-- Dumping data for table `users`
-- 

INSERT INTO `users` VALUES (1, '127.0.0.1', 'administrator', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@admin.com', '', NULL, NULL, NULL, 1268889823, 1417627980, 1, 'Admin', 'istrator', 'ADMIN', '0');
INSERT INTO `users` VALUES (9, '207.68.114.79', 'adam wolbert', '$2y$08$dF5fwGzMF20/BRHlURRUIe0/DI9E336rAW4n7UWronHWzQB4qDtau', NULL, 'wolbert540@hotmail.com', NULL, NULL, NULL, NULL, 1417626489, 1417626507, 1, 'Adam', 'Wolbert', 'Clarion', '8142292761');

-- --------------------------------------------------------

-- 
-- Table structure for table `users_groups`
-- 

CREATE TABLE `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- 
-- Dumping data for table `users_groups`
-- 

INSERT INTO `users_groups` VALUES (1, 1, 1);
INSERT INTO `users_groups` VALUES (2, 1, 2);
INSERT INTO `users_groups` VALUES (13, 9, 2);

-- 
-- Constraints for dumped tables
-- 

-- 
-- Constraints for table `users_groups`
-- 
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
