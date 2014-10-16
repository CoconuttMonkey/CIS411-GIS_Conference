-- phpMyAdmin SQL Dump
-- version 4.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Oct 15, 2014 at 05:08 PM
-- Server version: 5.5.38
-- PHP Version: 5.5.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `cis411_gisconference`
--

-- --------------------------------------------------------

--
-- Table structure for table `conf_addmission_type`
--

CREATE TABLE `conf_addmission_type` (
`id` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `conf_attendee`
--

CREATE TABLE `conf_attendee` (
  `user_id` int(11) NOT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `address_1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address_2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zip` int(5) NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `attendee_type` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conf_exhibit`
--

CREATE TABLE `conf_exhibit` (
`exhibit_id` int(11) NOT NULL,
  `table_number` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `table_location` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `conf_exhibitor`
--

CREATE TABLE `conf_exhibitor` (
`exhibitor_id` int(11) NOT NULL,
  `company_profile` longtext COLLATE utf8_unicode_ci NOT NULL,
  `special_request` longtext COLLATE utf8_unicode_ci NOT NULL,
  `paidStatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `conf_gallery`
--

CREATE TABLE `conf_gallery` (
`gallery_id` int(11) NOT NULL,
  `presentation_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `biography` longtext COLLATE utf8_unicode_ci NOT NULL,
  `critique` tinyint(1) NOT NULL,
  `expertise_level` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `conf_presentation`
--

CREATE TABLE `conf_presentation` (
`presentation_id` int(11) NOT NULL,
  `title` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `abstract` longtext COLLATE utf8_unicode_ci NOT NULL,
  `session_id` int(11) NOT NULL,
  `track_id` int(11) NOT NULL,
  `gallery_id` int(11) DEFAULT NULL,
  `active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `conf_presenter`
--

CREATE TABLE `conf_presenter` (
  `user_id` int(11) NOT NULL,
  `presentation_id` int(11) NOT NULL,
  `biography` longtext COLLATE utf8_unicode_ci,
  `is_main` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conf_room`
--

CREATE TABLE `conf_room` (
  `room_number` int(3) NOT NULL,
  `building` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conf_session`
--

CREATE TABLE `conf_session` (
`session_id` int(11) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `conf_settings`
--

CREATE TABLE `conf_settings` (
`conf_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tagline` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `conf_startDate` date NOT NULL,
  `conf_endDate` date NOT NULL,
  `reg_openDate` date NOT NULL,
  `reg_closeDate` date NOT NULL,
  `abstract` int(11) NOT NULL,
  `banner_img` int(11) NOT NULL,
  `schedule_pdf` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `conf_sponsors`
--

CREATE TABLE `conf_sponsors` (
`conf_id` int(11) NOT NULL,
  `company` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `address_1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address_2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zip` int(5) NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `logo_location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sponsor_type` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `conf_sponsor_levels`
--

CREATE TABLE `conf_sponsor_levels` (
`id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` int(5) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `conf_track`
--

CREATE TABLE `conf_track` (
`track_id` int(11) NOT NULL,
  `short_name` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_configuration`
--

CREATE TABLE `user_configuration` (
`id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `value` varchar(150) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `user_configuration`
--

INSERT INTO `user_configuration` (`id`, `name`, `value`) VALUES
(1, 'website_name', 'GIS Conference'),
(2, 'website_url', 'gisconference.local/'),
(3, 'email', 'noreply@ILoveUserCake.com'),
(4, 'activation', 'false'),
(5, 'resend_activation_threshold', '0'),
(6, 'language', 'models/languages/en.php'),
(7, 'template', 'models/site-templates/default.css');

-- --------------------------------------------------------

--
-- Table structure for table `user_pages`
--

CREATE TABLE `user_pages` (
`id` int(11) NOT NULL,
  `page` varchar(150) NOT NULL,
  `private` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `user_pages`
--

INSERT INTO `user_pages` (`id`, `page`, `private`) VALUES
(1, 'account.php', 1),
(2, 'activate-account.php', 0),
(3, 'admin_configuration.php', 1),
(4, 'admin_page.php', 1),
(5, 'admin_pages.php', 1),
(6, 'admin_permission.php', 1),
(7, 'admin_permissions.php', 1),
(8, 'admin_user.php', 1),
(9, 'admin_users.php', 1),
(10, 'forgot-password.php', 0),
(11, 'index.php', 0),
(12, 'left-nav.php', 0),
(13, 'login.php', 0),
(14, 'logout.php', 1),
(15, 'register.php', 0),
(16, 'resend-activation.php', 0),
(17, 'user_settings.php', 1),
(18, 'construction.php', 0),
(19, 'contact.php', 0),
(20, 'schedule.php', 0),
(21, 'presentations.php', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_permissions`
--

CREATE TABLE `user_permissions` (
`id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user_permissions`
--

INSERT INTO `user_permissions` (`id`, `name`) VALUES
(1, 'New Member'),
(2, 'Administrator'),
(3, 'Secretary'),
(4, 'Web Master');

-- --------------------------------------------------------

--
-- Table structure for table `user_permission_page_matches`
--

CREATE TABLE `user_permission_page_matches` (
`id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `user_permission_page_matches`
--

INSERT INTO `user_permission_page_matches` (`id`, `permission_id`, `page_id`) VALUES
(1, 1, 1),
(2, 1, 14),
(3, 1, 17),
(4, 2, 1),
(5, 2, 8),
(6, 2, 9),
(7, 2, 14),
(8, 2, 17),
(9, 4, 1),
(10, 4, 3),
(11, 4, 4),
(12, 4, 5),
(13, 4, 6),
(14, 4, 7),
(15, 4, 8),
(16, 4, 9),
(17, 4, 14),
(18, 4, 17),
(19, 3, 8),
(20, 3, 9),
(21, 3, 14),
(22, 3, 1),
(23, 3, 17),
(24, 2, 24),
(25, 4, 24),
(26, 2, 21),
(27, 4, 21);

-- --------------------------------------------------------

--
-- Table structure for table `user_users`
--

CREATE TABLE `user_users` (
`id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `password` varchar(225) NOT NULL,
  `email` varchar(150) NOT NULL,
  `activation_token` varchar(225) NOT NULL,
  `last_activation_request` int(11) NOT NULL,
  `lost_password_request` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `title` varchar(150) NOT NULL,
  `sign_up_stamp` int(11) NOT NULL,
  `last_sign_in_stamp` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user_users`
--

INSERT INTO `user_users` (`id`, `first_name`, `last_name`, `password`, `email`, `activation_token`, `last_activation_request`, `lost_password_request`, `active`, `title`, `sign_up_stamp`, `last_sign_in_stamp`) VALUES
(1, 'Matt', 'Ondo', '14cc9e4213b88deb05dbc5243a6941c230990fb12f01a5dcb4e9b3256f63e319f', 'webmaster@nowhere.com', '8ffd879a044139c4fccecaf33fe0f3dd', 1413380300, 0, 1, 'Web Master', 1413380300, 1413405008),
(2, 'Jon', '', '26fc86f27d82a8d1bc180d4204711d508b48f5d858ce6c040a5636ff320a67744', 'jon@doe.com', 'd891af975c3c99b394a878d5979943cd', 1413380487, 0, 1, 'New Member', 1413380487, 1413380494),
(3, 'Ayad', 'Lastname', 'ace137783d431d40c62fc9c64f679e348c8e37379dad2571b427bc1ad7a3ee44a', 'ayad@nowhere.com', 'eeb3b0e711f254f13363be8894763de3', 1413400904, 0, 1, 'Administrator', 1413400904, 1413401006);

-- --------------------------------------------------------

--
-- Table structure for table `user_user_permission_matches`
--

CREATE TABLE `user_user_permission_matches` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `user_user_permission_matches`
--

INSERT INTO `user_user_permission_matches` (`id`, `user_id`, `permission_id`) VALUES
(1, 1, 4),
(2, 1, 1),
(7, 3, 1),
(8, 3, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `conf_addmission_type`
--
ALTER TABLE `conf_addmission_type`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conf_attendee`
--
ALTER TABLE `conf_attendee`
 ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `conf_exhibit`
--
ALTER TABLE `conf_exhibit`
 ADD PRIMARY KEY (`exhibit_id`);

--
-- Indexes for table `conf_exhibitor`
--
ALTER TABLE `conf_exhibitor`
 ADD PRIMARY KEY (`exhibitor_id`);

--
-- Indexes for table `conf_gallery`
--
ALTER TABLE `conf_gallery`
 ADD PRIMARY KEY (`gallery_id`), ADD UNIQUE KEY `presentation_id` (`presentation_id`);

--
-- Indexes for table `conf_presentation`
--
ALTER TABLE `conf_presentation`
 ADD PRIMARY KEY (`presentation_id`);

--
-- Indexes for table `conf_presenter`
--
ALTER TABLE `conf_presenter`
 ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `conf_room`
--
ALTER TABLE `conf_room`
 ADD PRIMARY KEY (`room_number`);

--
-- Indexes for table `conf_session`
--
ALTER TABLE `conf_session`
 ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `conf_settings`
--
ALTER TABLE `conf_settings`
 ADD PRIMARY KEY (`conf_id`);

--
-- Indexes for table `conf_sponsors`
--
ALTER TABLE `conf_sponsors`
 ADD PRIMARY KEY (`conf_id`);

--
-- Indexes for table `conf_sponsor_levels`
--
ALTER TABLE `conf_sponsor_levels`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conf_track`
--
ALTER TABLE `conf_track`
 ADD PRIMARY KEY (`track_id`);

--
-- Indexes for table `user_configuration`
--
ALTER TABLE `user_configuration`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_pages`
--
ALTER TABLE `user_pages`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_permissions`
--
ALTER TABLE `user_permissions`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_permission_page_matches`
--
ALTER TABLE `user_permission_page_matches`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_users`
--
ALTER TABLE `user_users`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_user_permission_matches`
--
ALTER TABLE `user_user_permission_matches`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `conf_addmission_type`
--
ALTER TABLE `conf_addmission_type`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `conf_exhibit`
--
ALTER TABLE `conf_exhibit`
MODIFY `exhibit_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `conf_exhibitor`
--
ALTER TABLE `conf_exhibitor`
MODIFY `exhibitor_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `conf_gallery`
--
ALTER TABLE `conf_gallery`
MODIFY `gallery_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `conf_presentation`
--
ALTER TABLE `conf_presentation`
MODIFY `presentation_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `conf_session`
--
ALTER TABLE `conf_session`
MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `conf_settings`
--
ALTER TABLE `conf_settings`
MODIFY `conf_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `conf_sponsors`
--
ALTER TABLE `conf_sponsors`
MODIFY `conf_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `conf_sponsor_levels`
--
ALTER TABLE `conf_sponsor_levels`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `conf_track`
--
ALTER TABLE `conf_track`
MODIFY `track_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_configuration`
--
ALTER TABLE `user_configuration`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `user_pages`
--
ALTER TABLE `user_pages`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `user_permissions`
--
ALTER TABLE `user_permissions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user_permission_page_matches`
--
ALTER TABLE `user_permission_page_matches`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `user_users`
--
ALTER TABLE `user_users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user_user_permission_matches`
--
ALTER TABLE `user_user_permission_matches`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;