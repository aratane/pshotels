-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jan 31, 2018 at 08:46 AM
-- Server version: 5.6.28
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ps-foundation`
--

-- --------------------------------------------------------

--
-- Table structure for table `core_images`
--

CREATE TABLE `core_images` (
  `img_id` varchar(255) NOT NULL,
  `img_parent_id` varchar(255) NOT NULL,
  `img_type` varchar(100) NOT NULL,
  `img_path` varchar(255) NOT NULL,
  `Img_width` varchar(20) NOT NULL,
  `img_height` varchar(20) NOT NULL,
  `img_desc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `core_images`
--

INSERT INTO `core_images` (`img_id`, `img_parent_id`, `img_type`, `img_path`, `Img_width`, `img_height`, `img_desc`) VALUES
('img1dbbc76494f65bf5894fbf09a46e315a', 'abt1', 'about', 'cover1(2).png', '600', '400', 'test ');

-- --------------------------------------------------------

--
-- Table structure for table `core_menu_groups`
--

CREATE TABLE `core_menu_groups` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `group_icon` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `core_menu_groups`
--

INSERT INTO `core_menu_groups` (`group_id`, `group_name`, `group_icon`) VALUES
(1, 'Entry', 'fa-pencil-square-o'),
(2, 'Users Feedback', 'fa-list-alt'),
(3, 'Users Management', 'fa-users'),
(4, 'Miscellaneous', 'fa-cogs');

-- --------------------------------------------------------

--
-- Table structure for table `core_modules`
--

CREATE TABLE `core_modules` (
  `module_id` int(11) NOT NULL,
  `module_name` varchar(255) NOT NULL,
  `module_desc` text NOT NULL,
  `module_icon` varchar(100) NOT NULL,
  `ordering` int(3) NOT NULL,
  `is_show_on_menu` tinyint(1) NOT NULL,
  `group_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `core_modules`
--

INSERT INTO `core_modules` (`module_id`, `module_name`, `module_desc`, `module_icon`, `ordering`, `is_show_on_menu`, `group_id`) VALUES
(1, 'categories', 'Categories', '', 1, 1, 1),
(2, 'news', 'News', '', 2, 1, 1),
(3, 'likes', 'News Likes', '', 3, 1, 2),
(4, 'comments', 'News Comments', '', 4, 1, 2),
(5, 'favourites', 'News Favourites ', '', 5, 1, 2),
(8, 'system_users', 'System Users', '', 9, 1, 3),
(9, 'registered_users', 'Registered Users', '', 9, 1, 3),
(10, 'abouts', 'About & Setting', '', 10, 1, 4),
(11, 'notis', 'Push Notification', '', 11, 1, 4),
(12, 'analytics', 'Analytics', '', 12, 1, 4),
(13, 'dashboard/exports', 'Export Database', '', 13, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `core_permissions`
--

CREATE TABLE `core_permissions` (
  `user_id` varchar(255) NOT NULL,
  `module_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `core_permissions`
--

INSERT INTO `core_permissions` (`user_id`, `module_id`) VALUES
('c4ca4238a0b923820dcc509a6f75849b', '1'),
('c4ca4238a0b923820dcc509a6f75849b', '10'),
('c4ca4238a0b923820dcc509a6f75849b', '11'),
('c4ca4238a0b923820dcc509a6f75849b', '12'),
('c4ca4238a0b923820dcc509a6f75849b', '13'),
('c4ca4238a0b923820dcc509a6f75849b', '2'),
('c4ca4238a0b923820dcc509a6f75849b', '4'),
('c4ca4238a0b923820dcc509a6f75849b', '5'),
('c4ca4238a0b923820dcc509a6f75849b', '6'),
('c4ca4238a0b923820dcc509a6f75849b', '7'),
('c4ca4238a0b923820dcc509a6f75849b', '8'),
('c4ca4238a0b923820dcc509a6f75849b', '9'),
('usr4733875545bdfd6ecf65f963e5e0fa86', '2'),
('usr9f26d343918b5202c0f54377ed3d6882', '1'),
('usr9f26d343918b5202c0f54377ed3d6882', '10'),
('usr9f26d343918b5202c0f54377ed3d6882', '11'),
('usr9f26d343918b5202c0f54377ed3d6882', '12'),
('usr9f26d343918b5202c0f54377ed3d6882', '13'),
('usr9f26d343918b5202c0f54377ed3d6882', '2'),
('usr9f26d343918b5202c0f54377ed3d6882', '3'),
('usr9f26d343918b5202c0f54377ed3d6882', '4'),
('usr9f26d343918b5202c0f54377ed3d6882', '5'),
('usr9f26d343918b5202c0f54377ed3d6882', '7');

-- --------------------------------------------------------

--
-- Table structure for table `core_reset_codes`
--

CREATE TABLE `core_reset_codes` (
  `code_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `code` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `core_roles`
--

CREATE TABLE `core_roles` (
  `role_id` varchar(255) NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `role_desc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `core_roles`
--

INSERT INTO `core_roles` (`role_id`, `role_name`, `role_desc`) VALUES
('1', 'admin', 'Administrator'),
('2', 'editor', 'Editor'),
('3', 'author', 'Author'),
('4', 'normal', 'Normal');

-- --------------------------------------------------------

--
-- Table structure for table `core_role_access`
--

CREATE TABLE `core_role_access` (
  `role_id` varchar(255) NOT NULL,
  `action_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `core_role_access`
--

INSERT INTO `core_role_access` (`role_id`, `action_id`) VALUES
('1', 'add'),
('1', 'ban'),
('1', 'delete'),
('1', 'edit'),
('1', 'module'),
('1', 'publish'),
('2', 'add'),
('2', 'delete'),
('2', 'edit'),
('2', 'publish'),
('3', 'add'),
('3', 'edit');

-- --------------------------------------------------------

--
-- Table structure for table `core_sessions`
--

CREATE TABLE `core_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `core_users`
--

CREATE TABLE `core_users` (
  `user_id` varchar(255) NOT NULL,
  `user_is_sys_admin` int(11) NOT NULL DEFAULT '0',
  `facebook_id` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_phone` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_about_me` text NOT NULL,
  `user_cover_photo` varchar(255) NOT NULL,
  `user_profile_photo` varchar(255) NOT NULL,
  `role_id` varchar(255) NOT NULL DEFAULT '4',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=active, 0=inactive',
  `is_banned` tinyint(1) NOT NULL DEFAULT '0',
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `core_users`
--

INSERT INTO `core_users` (`user_id`, `user_is_sys_admin`, `facebook_id`, `user_name`, `user_email`, `user_phone`, `user_password`, `user_about_me`, `user_cover_photo`, `user_profile_photo`, `role_id`, `status`, `is_banned`, `added_date`) VALUES
('c4ca4238a0b923820dcc509a6f75849b', 1, '', 'PS News Admin', 'admin@psnews.com', '12345678', '21232f297a57a5a743894a0e4a801fc3', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur a dapibus justo. Pellentesque ultricies placerat velit, id vehicula arcu venenatis vel. Donec massa ante, blandit efficitur risus vel, euismod tempus mi. Aliquam porta ullamcorper venenatis. Ut elementum eu lacus lobortis hendrerit.', '', 'people_icon.jpg', '1', 1, 0, '2017-10-25 06:49:55'),
('usr4733875545bdfd6ecf65f963e5e0fa86', 0, '', 'PS News Author', 'author@psnews.com', '', '827ccb0eea8a706c4c34a16891f84e7b', '', '', '', '3', 1, 0, '2018-01-24 09:33:01'),
('usr9f26d343918b5202c0f54377ed3d6882', 0, '', 'PS News Editor', 'editor@psnews.com', '', '827ccb0eea8a706c4c34a16891f84e7b', '', '', '', '2', 1, 0, '2018-01-24 09:28:20'),
('usre705d0ab5a97983c3f1e81fe731774b0', 0, '', 'uaer1', 'user1@gmail.com', '', '827ccb0eea8a706c4c34a16891f84e7b', '', '', '', '4', 1, 0, '2018-01-19 14:05:10');

-- --------------------------------------------------------

--
-- Table structure for table `psn_about`
--

CREATE TABLE `psn_about` (
  `about_id` varchar(225) NOT NULL,
  `about_title` varchar(225) NOT NULL,
  `about_description` longtext NOT NULL,
  `about_email` varchar(255) NOT NULL,
  `about_phone` varchar(255) NOT NULL,
  `about_website` varchar(255) NOT NULL,
  `seo_title` varchar(255) NOT NULL,
  `seo_description` text NOT NULL,
  `seo_keywords` varchar(255) NOT NULL,
  `ads_on` tinyint(1) NOT NULL DEFAULT '0',
  `ads_client` text NOT NULL,
  `ads_slot` text NOT NULL,
  `analyt_on` tinyint(1) NOT NULL DEFAULT '0',
  `analyt_track_id` text NOT NULL,
  `facebook` text NOT NULL,
  `google_plus` text NOT NULL,
  `instagram` text NOT NULL,
  `youtube` text NOT NULL,
  `pinterest` text NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `theme_style` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `psn_about`
--

INSERT INTO `psn_about` (`about_id`, `about_title`, `about_description`, `about_email`, `about_phone`, `about_website`, `seo_title`, `seo_description`, `seo_keywords`, `ads_on`, `ads_client`, `ads_slot`, `analyt_on`, `analyt_track_id`, `facebook`, `google_plus`, `instagram`, `youtube`, `pinterest`, `twitter`, `theme_style`) VALUES
('abt1', 'Nice Product Powered By Panacea-Soft', 'Panacea-Soft is a software development team that focuses on helping your business with mobile and web technology.We tried our best to delivery quality product on time according clientâ€™s requirements and exceptions. We are technology oriented team so before we code, we analyse for your requirements and brain storm then start for development. We donâ€™t over promise to client and trying our best to deliver awesome product package. Thanks for reaching out to us. We are happy to listen your world and enjoy to solve the problem using technology.', 'teamps.is.cool@gmail.com', '+9592540942**', 'http://www.panacea-soft.com', 'Software Development', 'Panacea-Soft is a software development team that focuses on helping your business with mobile and web technology.', 'web, mobile, technology', 1, 'ca-pub-8907881762519005', '9078562335', 0, '', 'http://www.facebook.com', 'http://www.google.com', 'http://www.instagram.com', 'http://www.youtube.com', 'http://www.pinterest.com', 'http://www.twitter.com', 'default');

-- --------------------------------------------------------

--
-- Table structure for table `psn_comments`
--

CREATE TABLE `psn_comments` (
  `comment_id` varchar(255) NOT NULL,
  `news_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `comment_desc` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=active, 0=inactive',
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `psn_contact`
--

CREATE TABLE `psn_contact` (
  `contact_id` varchar(255) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `contact_phone` varchar(255) DEFAULT NULL,
  `contact_message` text NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `psn_contact`
--

INSERT INTO `psn_contact` (`contact_id`, `contact_name`, `contact_email`, `contact_phone`, `contact_message`, `added_date`) VALUES
('con0d43e8b9ab0e3ffde1d3d56ae819b3b1', 'ha ha', 'pphmit@gmail.com', '13123', 'this is msg.', '2017-12-05 18:34:14'),
('con3ae98b8a421bfb6e5fbfa67843a534ec', 'fokhwar', 'fokhwar@gmail.com', '96661094', 'testing', '2018-01-07 07:05:07'),
('con3ed59453322f9ed52faef12e66a4cb31', 'ha ha 2', 'pphmit@gmail.com', '13123', 'this is msg.', '2017-12-05 18:35:22');

-- --------------------------------------------------------

--
-- Table structure for table `psn_favourites`
--

CREATE TABLE `psn_favourites` (
  `favourite_id` varchar(255) NOT NULL,
  `news_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `psn_likes`
--

CREATE TABLE `psn_likes` (
  `like_id` varchar(255) NOT NULL,
  `news_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `psn_push_notification_messages`
--

CREATE TABLE `psn_push_notification_messages` (
  `noti_msg_id` varchar(255) NOT NULL,
  `noti_msg_desc` text NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `psn_push_notification_tokens`
--

CREATE TABLE `psn_push_notification_tokens` (
  `push_noti_token_id` varchar(255) NOT NULL,
  `device_id` text,
  `os_type` varchar(50) DEFAULT NULL,
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `psn_push_notification_tokens`
--

INSERT INTO `psn_push_notification_tokens` (`push_noti_token_id`, `device_id`, `os_type`, `added_date`) VALUES
('noti222c65d287f40170c9c90822906b0665', 'dGB2RL89mxo:APA91bF5LwpSBiRXaxwNtQ7TdUbSXNOMghmgLdmEuetTDRdXk5jRkptUs1WzbBybexuKoP9U9tfH-1E--UVF_81N4XiPboxm524Oo6IAuGmKoMBL_t66Cv2yyGlENK191Nhn_sD3wWjJ', 'ANDROID', '2018-01-25 10:09:48'),
('notidefbbc681508b005716e49087af1be6e', 'cd9ruJObbuQ:APA91bFQyfus5LuRtuJ1hrsPtIwbclQ9NY9i7AHqBT0dV99v1SOW7LZrPWgd9ONc5ryvVoLMzAaqR-3wvHkhtc78jNi9R-zY6NyWhdBReD0kdV9HOGyRY4uRfuH4OHi9U43bXyy8oNB9', 'ANDROID', '2018-01-19 15:45:21'),
('notie687e30967dd28f618e4782d895365c0', 'f4HsVGNLogE:APA91bEVLvpA3CqRRcrMnxoNVmK6STQbt-37WZvLe5SKrzL968H7pHnRLIpj-qYB8qOsp7gy3kaDvAOfXJFnTXhS_YFxSiIl-_8YPVpXZtVb3GdwutzhqviY6MKZR5LiaWD25dtLlpzS', 'ANDROID', '2018-01-17 10:43:15');

-- --------------------------------------------------------

--
-- Table structure for table `psn_touches`
--

CREATE TABLE `psn_touches` (
  `touch_id` varchar(255) NOT NULL,
  `news_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `core_images`
--
ALTER TABLE `core_images`
  ADD PRIMARY KEY (`img_id`);

--
-- Indexes for table `core_menu_groups`
--
ALTER TABLE `core_menu_groups`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `core_modules`
--
ALTER TABLE `core_modules`
  ADD PRIMARY KEY (`module_id`);

--
-- Indexes for table `core_permissions`
--
ALTER TABLE `core_permissions`
  ADD PRIMARY KEY (`user_id`,`module_id`);

--
-- Indexes for table `core_reset_codes`
--
ALTER TABLE `core_reset_codes`
  ADD PRIMARY KEY (`code_id`);

--
-- Indexes for table `core_roles`
--
ALTER TABLE `core_roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `core_role_access`
--
ALTER TABLE `core_role_access`
  ADD PRIMARY KEY (`role_id`,`action_id`);

--
-- Indexes for table `core_users`
--
ALTER TABLE `core_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `psn_about`
--
ALTER TABLE `psn_about`
  ADD PRIMARY KEY (`about_id`);

--
-- Indexes for table `psn_comments`
--
ALTER TABLE `psn_comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `psn_contact`
--
ALTER TABLE `psn_contact`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `psn_favourites`
--
ALTER TABLE `psn_favourites`
  ADD PRIMARY KEY (`favourite_id`);

--
-- Indexes for table `psn_likes`
--
ALTER TABLE `psn_likes`
  ADD PRIMARY KEY (`like_id`);

--
-- Indexes for table `psn_push_notification_messages`
--
ALTER TABLE `psn_push_notification_messages`
  ADD PRIMARY KEY (`noti_msg_id`);

--
-- Indexes for table `psn_push_notification_tokens`
--
ALTER TABLE `psn_push_notification_tokens`
  ADD PRIMARY KEY (`push_noti_token_id`);

--
-- Indexes for table `psn_touches`
--
ALTER TABLE `psn_touches`
  ADD PRIMARY KEY (`touch_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `core_modules`
--
ALTER TABLE `core_modules`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
