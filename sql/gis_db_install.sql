-- phpMyAdmin SQL Dump
-- version 2.8.0.1
-- http://www.phpmyadmin.net
-- 
-- Host: custsql-ipg02.eigbox.net
-- Generation Time: Dec 09, 2014 at 09:57 PM
-- Server version: 5.5.32
-- PHP Version: 4.4.9
-- 
-- Database: `cis411_gisconference`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `admission_type`
-- 

CREATE TABLE `admission_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `group` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group` (`group`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `attendee`
-- 

CREATE TABLE `attendee` (
  `user_id` int(11) unsigned NOT NULL,
  `address_1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `zip` int(10) NOT NULL,
  `country` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `phone` int(10) NOT NULL,
  `admission_type` int(11) NOT NULL,
  `paid` set('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  PRIMARY KEY (`user_id`),
  KEY `admission_type` (`admission_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- Table structure for table `attendee_conference_lookup`
-- 

CREATE TABLE `attendee_conference_lookup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `conference_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `conference_id` (`conference_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

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
  `agenda_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`conf_id`),
  KEY `conf_id` (`conf_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  PRIMARY KEY (`exhibit_id`),
  KEY `conference_id` (`conference_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `exhibitor`
-- 

CREATE TABLE `exhibitor` (
  `user_id` int(11) unsigned NOT NULL,
  `exhibit_id` int(11) NOT NULL,
  `is_main` set('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  PRIMARY KEY (`user_id`),
  KEY `user_id` (`user_id`),
  KEY `exhibit_id` (`exhibit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- Table structure for table `groups`
-- 

CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

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
  `time_request` set('No Preference','Morning','Afternoon') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No Preference',
  PRIMARY KEY (`presentation_id`),
  KEY `conference_id` (`conference_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `presenter`
-- 

CREATE TABLE `presenter` (
  `user_id` int(11) unsigned NOT NULL,
  `presentation_id` int(11) NOT NULL,
  `is_main` set('yes','no') COLLATE utf8_unicode_ci DEFAULT 'no',
  `biography` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`user_id`),
  KEY `presentation_id` (`presentation_id`),
  KEY `is_main` (`is_main`),
  KEY `presentation_id_2` (`presentation_id`),
  KEY `user_id` (`user_id`),
  KEY `presentation_id_3` (`presentation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  KEY `conference_id_2` (`conference_id`),
  KEY `conference_id_3` (`conference_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `sponsor`
-- 

CREATE TABLE `sponsor` (
  `sponsor_id` int(11) NOT NULL AUTO_INCREMENT,
  `conference_id` int(11) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `company_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paid` set('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `sponsor_level` int(11) NOT NULL,
  PRIMARY KEY (`sponsor_id`),
  UNIQUE KEY `company_name` (`company_name`),
  KEY `conference_id` (`conference_id`),
  KEY `conference_id_2` (`conference_id`),
  KEY `conference_id_3` (`conference_id`),
  KEY `conference_id_4` (`conference_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

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
  KEY `conference_id` (`conference_id`),
  KEY `conference_id_2` (`conference_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

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
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

-- 
-- Constraints for dumped tables
-- 

-- 
-- Constraints for table `admission_type`
-- 
ALTER TABLE `admission_type`
  ADD CONSTRAINT `admissionType_group_FK` FOREIGN KEY (`group`) REFERENCES `groups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

-- 
-- Constraints for table `attendee`
-- 
ALTER TABLE `attendee`
  ADD CONSTRAINT `users_attendee_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `admissionType_attendee_FK` FOREIGN KEY (`admission_type`) REFERENCES `admission_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

-- 
-- Constraints for table `attendee_conference_lookup`
-- 
ALTER TABLE `attendee_conference_lookup`
  ADD CONSTRAINT `attendee_conf_look1_FK` FOREIGN KEY (`user_id`) REFERENCES `attendee` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attendee_conf_look2_FK` FOREIGN KEY (`conference_id`) REFERENCES `conference` (`conf_id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- 
-- Constraints for table `exhibit`
-- 
ALTER TABLE `exhibit`
  ADD CONSTRAINT `conference_exhibit_FK` FOREIGN KEY (`conference_id`) REFERENCES `conference` (`conf_id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- 
-- Constraints for table `exhibitor`
-- 
ALTER TABLE `exhibitor`
  ADD CONSTRAINT `attendee_exhibitor_FK` FOREIGN KEY (`user_id`) REFERENCES `attendee` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exhibit_exhibitor_FK` FOREIGN KEY (`exhibit_id`) REFERENCES `exhibit` (`exhibit_id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- 
-- Constraints for table `presentation`
-- 
ALTER TABLE `presentation`
  ADD CONSTRAINT `conference_presentation_FK` FOREIGN KEY (`conference_id`) REFERENCES `conference` (`conf_id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- 
-- Constraints for table `presenter`
-- 
ALTER TABLE `presenter`
  ADD CONSTRAINT `attendee_presenter_FK` FOREIGN KEY (`user_id`) REFERENCES `attendee` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `presentation_presenter_FK` FOREIGN KEY (`presentation_id`) REFERENCES `presentation` (`presentation_id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- 
-- Constraints for table `room`
-- 
ALTER TABLE `room`
  ADD CONSTRAINT `conference_room_id` FOREIGN KEY (`conference_id`) REFERENCES `conference` (`conf_id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- 
-- Constraints for table `sponsor`
-- 
ALTER TABLE `sponsor`
  ADD CONSTRAINT `users_sponsor_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `conference_sponsor_FK` FOREIGN KEY (`conference_id`) REFERENCES `conference` (`conf_id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- 
-- Constraints for table `track`
-- 
ALTER TABLE `track`
  ADD CONSTRAINT `conference_track_FK` FOREIGN KEY (`conference_id`) REFERENCES `conference` (`conf_id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- 
-- Constraints for table `users_groups`
-- 
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

-- 
-- Dumping data for table `admission_type`
-- 

INSERT INTO `admission_type` VALUES (1, '1 Day', 25, 'For those attending only 1 day. ', 7);
INSERT INTO `admission_type` VALUES (2, 'Full ', 35, 'Full admittance to all events', 7);
INSERT INTO `admission_type` VALUES (3, 'CUP Student / Faculty', 0, 'Free admission: must have *clarion*.edu email address', 7);
INSERT INTO `admission_type` VALUES (4, 'Presenter', 0, 'Free admission, may bring 3 co-presenters', 4);
INSERT INTO `admission_type` VALUES (5, 'Exhibitor', 125, '$125.00 + 2 free admissions', 5);
INSERT INTO `admission_type` VALUES (6, 'Sponsor', 0, 'Sponsor price found on sponser_level table', 6);
INSERT INTO `admission_type` VALUES (7, 'By Invitation', 0, 'This alerts to the administrator there is a person requesting an invitation for free admission', 7);

-- 
-- Dumping data for table `groups`
-- 

INSERT INTO `groups` VALUES (1, 'admin', 'Administrator');
INSERT INTO `groups` VALUES (2, 'user', 'General User');
INSERT INTO `groups` VALUES (3, 'secretary', 'For updating payments and typos');
INSERT INTO `groups` VALUES (4, 'presenter', 'Those who are presenting');
INSERT INTO `groups` VALUES (5, 'exhibitor', 'Those who feature an exhibition');
INSERT INTO `groups` VALUES (6, 'sponsor', 'Sponsors of the event');
INSERT INTO `groups` VALUES (7, 'attendee', 'Attendees of the event');

-- 
-- Dumping data for table `settings`
-- 

INSERT INTO `settings` VALUES (1, 2014, 'gisconferencebilling@clarion.edu', 'gisconference@clarion.edu');

