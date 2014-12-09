-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 28, 2014 at 05:12 PM
-- Server version: 5.5.33
-- PHP Version: 5.4.4-14+deb7u7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `leaderboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `changelog`
--

CREATE TABLE IF NOT EXISTS `changelog` (
  `time_gained` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `profile_number` varchar(50) NOT NULL DEFAULT '',
  `score` int(11) NOT NULL,
  `map_id` varchar(6) NOT NULL DEFAULT '',
  `wr_gain` int(1) NOT NULL DEFAULT '0',
  `previous_score` int(11) DEFAULT NULL,
  KEY `profile_number` (`profile_number`),
  KEY `map_id` (`map_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `changelog`
--

INSERT INTO `changelog` (`time_gained`, `profile_number`, `score`, `map_id`, `wr_gain`, `previous_score`) VALUES
('2013-07-30 09:23:45', '76561198026851335', 4271, '52740', 1, 0),
('2013-07-30 09:23:45', '76561198043899549', 4271, '52740', 1, 4348),
('2013-07-30 09:23:45', '76561198043899549', 2936, '49347', 1, 3026),
('2013-07-30 09:23:45', '76561198048636382', 2936, '49347', 1, 3026),
('2013-07-30 09:23:45', '76561198026851335', 2253, '49351', 0, 2295),
('2013-07-30 09:23:45', '76561198043899549', 2253, '49351', 0, 2295),
('2013-07-30 09:23:45', '76561198026851335', 3555, '48287', 1, 0),
('2013-07-30 09:23:45', '76561198043899549', 3555, '48287', 1, 5981),
('2014-03-27 17:41:03', '76561198045034733', 828, '52671', 1, 833),
('2014-03-27 18:03:03', '76561198039230536', 1440, '52665', 0, 1446),
('2014-03-27 18:03:03', '76561198045034733', 1440, '52665', 0, 1446),
('2014-03-27 18:26:02', '76561198035130516', 4556, '47798', 0, 4598);

-- --------------------------------------------------------

--
-- Table structure for table `chapters`
--

CREATE TABLE IF NOT EXISTS `chapters` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `chapter_name` varchar(50) DEFAULT NULL,
  `is_multiplayer` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `chapters`
--

INSERT INTO `chapters` (`id`, `chapter_name`, `is_multiplayer`) VALUES
(1, 'Team Building', 1),
(2, 'Mass and Velocity', 1),
(3, 'Hard Light', 1),
(4, 'Excursion Funnels', 1),
(5, 'Mobility Gels', 1),
(6, 'Art Therapy', 1),
(7, 'The Courtesy Call', 0),
(8, 'The Cold Boot', 0),
(9, 'The Return', 0),
(10, 'The Surprise', 0),
(11, 'The Escape', 0),
(12, 'The Fall', 0),
(13, 'The Reunion', 0),
(14, 'The Itch', 0),
(15, 'The Part Where...', 0);

-- --------------------------------------------------------

--
-- Table structure for table `exceptions`
--

CREATE TABLE IF NOT EXISTS `exceptions` (
  `map_id` varchar(5) NOT NULL,
  `legit_score` int(11) NOT NULL,
  `curl` int(3) NOT NULL DEFAULT '18'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `exceptions`
--

INSERT INTO `exceptions` (`map_id`, `legit_score`, `curl`) VALUES
('52663', 1929, 18),
('47808', 2053, 18),
('47744', 3838, 35);

-- --------------------------------------------------------

--
-- Table structure for table `leastportals`
--

CREATE TABLE IF NOT EXISTS `leastportals` (
  `steam_id` varchar(6) NOT NULL,
  `portals` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leastportals`
--

INSERT INTO `leastportals` (`steam_id`, `portals`) VALUES
('47459', 0),
('47454', 1),
('47451', 1),
('47107', 3),
('47734', 0),
('47737', 2),
('47739', 2),
('47743', 0),
('47745', 2),
('47466', 0),
('47747', 2),
('47749', 3),
('47750', 2),
('47753', 4),
('47754', 2),
('47757', 0),
('47758', 2),
('47761', 0),
('47762', 0),
('47765', 2),
('47767', 2),
('47769', 2),
('47771', 0),
('47772', 2),
('47775', 0),
('47777', 6),
('47778', 5),
('47781', 3),
('47782', 4),
('47785', 5),
('47786', 0),
('47467', 3),
('47470', 4),
('47471', 5),
('47792', 2),
('47794', 2),
('47796', 12),
('47799', 7),
('47801', 2),
('47803', 0),
('47805', 2),
('47807', 0),
('47809', 2),
('47812', 0),
('47814', 0),
('47816', 4),
('47818', 2),
('47820', 4),
('47822', 2),
('47823', 6),
('47457', 6),
('47740', 0),
('47826', 2),
('47827', 4),
('47830', 2),
('45466', 0),
('46361', 0),
('47832', 4),
('47834', 2),
('47836', 0),
('47838', 2),
('47839', 7),
('47842', 2),
('47843', 2),
('47846', 0),
('47847', 3),
('47850', 4),
('47855', 2),
('47857', 4),
('47859', 5),
('47860', 4),
('52641', 0),
('52659', 2),
('52661', 0),
('52664', 0),
('52666', 2),
('52668', 0),
('52672', 0),
('52688', 2),
('52690', 0),
('52692', 0),
('52778', 0),
('52693', 0),
('52712', 2),
('52713', 2),
('52716', 4),
('52718', 0),
('52736', 2),
('52737', 0),
('52739', 2),
('49342', 0),
('49344', 0),
('49346', 0),
('49348', 4),
('49350', 0),
('49352', 2),
('52758', 0),
('52760', 0),
('48288', 2);

-- --------------------------------------------------------

--
-- Table structure for table `leastportals_exceptions`
--

CREATE TABLE IF NOT EXISTS `leastportals_exceptions` (
  `map_id` varchar(6) NOT NULL,
  `profile_number` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leastportals_exceptions`
--

INSERT INTO `leastportals_exceptions` (`map_id`, `profile_number`) VALUES
('47754', '76561198015995629'),
('47765', '76561197996355226'),
('47765', '76561198000992420'),
('47765', '76561198040483651'),
('47765', '76561198043196429'),
('47765', '76561198048252922'),
('47765', '76561198054566481'),
('47765', '76561198057072625'),
('47765', '76561198069533158'),
('47765', '76561198074525881'),
('47801', '76561197994202252'),
('47801', '76561197996355226'),
('47801', '76561198048252922');

-- --------------------------------------------------------

--
-- Table structure for table `maps`
--

CREATE TABLE IF NOT EXISTS `maps` (
  `id` int(5) NOT NULL,
  `steam_id` varchar(6) NOT NULL DEFAULT '',
  `lp_id` varchar(6) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `type` set('portals','time') NOT NULL DEFAULT 'time',
  `chapter_id` int(11) unsigned DEFAULT NULL,
  `is_coop` int(1) NOT NULL DEFAULT '0',
  `is_public` int(1) NOT NULL DEFAULT '1',
  UNIQUE KEY `steam_id` (`steam_id`),
  KEY `chapter_id` (`chapter_id`),
  KEY `is_public` (`is_public`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `maps`
--

INSERT INTO `maps` (`id`, `steam_id`, `lp_id`, `name`, `type`, `chapter_id`, `is_coop`, `is_public`) VALUES
(5, '45467', '45466', 'Laser Crusher', 'time', 1, 1, 1),
(6, '46362', '46361', 'Behind the Scenes', 'time', 1, 1, 1),
(54, '47106', '47107', 'Future Starter', 'time', 7, 0, 1),
(53, '47452', '47451', 'Cube Momentum', 'time', 7, 0, 1),
(52, '47455', '47454', 'Smooth Jazz', 'time', 7, 0, 1),
(108, '47456', '47457', 'Finale 4', 'time', 15, 0, 1),
(51, '47458', '47459', 'Portal Gun', 'time', 7, 0, 1),
(64, '47465', '47466', 'Pit Flings', 'time', 8, 0, 1),
(87, '47468', '47467', 'Bomb Flings', 'time', 12, 0, 1),
(88, '47469', '47470', 'Crazy Box', 'time', 12, 0, 1),
(89, '47472', '47471', 'PotatOS', 'time', 12, 0, 1),
(57, '47735', '47734', 'Incinerator', 'time', 7, 0, 1),
(59, '47736', '47737', 'Laser Stairs', 'time', 8, 0, 1),
(60, '47738', '47739', 'Dual Lasers', 'time', 8, 0, 1),
(1, '47741', '47740', 'Doors', 'time', 1, 1, 1),
(61, '47742', '47743', 'Laser Over Goo', 'time', 8, 0, 1),
(63, '47744', '47745', 'Trust Fling', 'time', 8, 0, 1),
(65, '47746', '47747', 'Fizzler Intro', 'time', 8, 0, 1),
(66, '47748', '47749', 'Ceiling Catapult', 'time', 9, 0, 1),
(67, '47751', '47750', 'Ricochet', 'time', 9, 0, 1),
(68, '47752', '47753', 'Bridge Intro', 'time', 9, 0, 1),
(69, '47755', '47754', 'Bridge the Gap', 'time', 9, 0, 1),
(70, '47756', '47757', 'Turret Intro', 'time', 9, 0, 1),
(71, '47759', '47758', 'Laser Relays', 'time', 9, 0, 1),
(72, '47760', '47761', 'Turret Blocker', 'time', 9, 0, 1),
(73, '47763', '47762', 'Laser vs. Turret', 'time', 9, 0, 1),
(74, '47764', '47765', 'Pull the Rug', 'time', 9, 0, 1),
(75, '47766', '47767', 'Column Blocker', 'time', 10, 0, 1),
(76, '47768', '47769', 'Laser Chaining', 'time', 10, 0, 1),
(77, '47770', '47771', 'Triple Laser', 'time', 10, 0, 1),
(78, '47773', '47772', 'Jail Break', 'time', 10, 0, 1),
(79, '47774', '47775', 'Escape', 'time', 10, 0, 1),
(80, '47776', '47777', 'Turret Factory', 'time', 11, 0, 1),
(81, '47779', '47778', 'Turret Sabotage', 'time', 11, 0, 1),
(82, '47780', '47781', 'Neurotoxin Sabotage', 'time', 11, 0, 1),
(84, '47783', '47782', 'Underground', 'time', 12, 0, 1),
(85, '47784', '47785', 'Cave Johnson', 'time', 12, 0, 1),
(86, '47787', '47786', 'Repulsion Intro', 'time', 12, 0, 1),
(90, '47791', '47792', 'Propulsion Intro', 'time', 13, 0, 1),
(91, '47793', '47794', 'Propulsion Flings', 'time', 13, 0, 1),
(92, '47795', '47796', 'Conversion Intro', 'time', 13, 0, 1),
(93, '47798', '47799', 'Three Gels', 'time', 13, 0, 1),
(95, '47800', '47801', 'Funnel Intro', 'time', 14, 0, 1),
(96, '47802', '47803', 'Ceiling Button', 'time', 14, 0, 1),
(97, '47804', '47805', 'Wall Button', 'time', 14, 0, 1),
(98, '47806', '47807', 'Polarity', 'time', 14, 0, 1),
(99, '47808', '47809', 'Funnel Catch', 'time', 14, 0, 1),
(100, '47811', '47812', 'Stop the Box', 'time', 14, 0, 1),
(101, '47813', '47814', 'Laser Catapult', 'time', 14, 0, 1),
(102, '47815', '47816', 'Laser Platform', 'time', 14, 0, 1),
(103, '47817', '47818', 'Propulsion Catch', 'time', 14, 0, 1),
(104, '47819', '47820', 'Repulsion Polarity', 'time', 14, 0, 1),
(106, '47821', '47822', 'Finale 2', 'time', 15, 0, 1),
(107, '47824', '47823', 'Finale 3', 'time', 15, 0, 1),
(2, '47825', '47826', 'Buttons', 'time', 1, 1, 1),
(3, '47828', '47827', 'Lasers', 'time', 1, 1, 1),
(4, '47829', '47830', 'Rat Maze', 'time', 1, 1, 1),
(7, '47831', '47832', 'Flings', 'time', 2, 1, 1),
(8, '47833', '47834', 'Infinifling', 'time', 2, 1, 1),
(9, '47835', '47836', 'Team Retrieval', 'time', 2, 1, 1),
(10, '47837', '47838', 'Vertical Flings', 'time', 2, 1, 1),
(11, '47840', '47839', 'Catapults', 'time', 2, 1, 1),
(12, '47841', '47842', 'Multifling', 'time', 2, 1, 1),
(13, '47844', '47843', 'Fling Crushers', 'time', 2, 1, 1),
(14, '47845', '47846', 'Industrial Fan', 'time', 2, 1, 1),
(15, '47848', '47847', 'Cooperative Bridges', 'time', 3, 1, 1),
(16, '47849', '47850', 'Bridge Swap', 'time', 3, 1, 1),
(17, '47854', '47855', 'Fling Block', 'time', 3, 1, 1),
(18, '47856', '47857', 'Catapult Block', 'time', 3, 1, 1),
(19, '47858', '47859', 'Bridge Fling', 'time', 3, 1, 1),
(20, '47861', '47860', 'Turret Walls', 'time', 3, 1, 1),
(48, '48287', '48288', 'Crazier Box', 'time', 6, 1, 1),
(40, '49341', '49342', 'Separation', 'time', 6, 1, 1),
(41, '49343', '49344', 'Triple Axis', 'time', 6, 1, 1),
(42, '49345', '49346', 'Catapult Catch', 'time', 6, 1, 1),
(43, '49347', '49348', 'Bridge Gels', 'time', 6, 1, 1),
(44, '49349', '49350', 'Maintenance', 'time', 6, 1, 1),
(45, '49351', '49352', 'Bridge Catch', 'time', 6, 1, 1),
(21, '52642', '52641', 'Turret Assassin', 'time', 3, 1, 1),
(22, '52660', '52659', 'Bridge Testing', 'time', 3, 1, 1),
(23, '52662', '52661', 'Cooperative Funnels', 'time', 4, 1, 1),
(24, '52663', '52664', 'Funnel Drill', 'time', 4, 1, 1),
(25, '52665', '52666', 'Funnel Catch', 'time', 4, 1, 1),
(26, '52667', '52668', 'Funnel Laser', 'time', 4, 1, 1),
(27, '52671', '52672', 'Cooperative Polarity', 'time', 4, 1, 1),
(28, '52687', '52688', 'Funnel Hop', 'time', 4, 1, 1),
(29, '52689', '52690', 'Advanced Polarity', 'time', 4, 1, 1),
(30, '52691', '52692', 'Funnel Maze', 'time', 4, 1, 1),
(32, '52694', '52693', 'Repulsion Jumps', 'time', 5, 1, 1),
(33, '52711', '52712', 'Double Bounce', 'time', 5, 1, 1),
(34, '52714', '52713', 'Bridge Repulsion', 'time', 5, 1, 1),
(35, '52715', '52716', 'Wall Repulsion', 'time', 5, 1, 1),
(36, '52717', '52718', 'Propulsion Crushers', 'time', 5, 1, 1),
(37, '52735', '52736', 'Turret Ninja', 'time', 5, 1, 1),
(38, '52738', '52737', 'Propulsion Retrieval', 'time', 5, 1, 1),
(39, '52740', '52739', 'Vault Entrance', 'time', 5, 1, 1),
(46, '52757', '52758', 'Double Lift', 'time', 6, 1, 1),
(47, '52759', '52760', 'Gel Maze', 'time', 6, 1, 1),
(31, '52777', '52778', 'Turret Warehouse', 'time', 4, 1, 1),
(50, '62758', '', 'Portal Carousel', 'time', 7, 0, 0),
(56, '62759', '', 'Wakeup', 'time', 7, 0, 0),
(49, '62761', '', 'Container Ride', 'time', 7, 0, 0),
(55, '62763', '', 'Secret Panel', 'time', 7, 0, 0),
(58, '62765', '', 'Laser Intro', 'time', 8, 0, 0),
(62, '62767', '', 'Catapult Intro', 'time', 8, 0, 0),
(83, '62771', '', 'Core', 'time', 11, 0, 0),
(105, '62776', '', 'Finale 1', 'time', 15, 0, 0),
(94, '88350', '', 'Test', 'time', 14, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

CREATE TABLE IF NOT EXISTS `scores` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `profile_number` varchar(50) NOT NULL DEFAULT '',
  `score` int(11) NOT NULL,
  `legit` int(1) NOT NULL DEFAULT '1',
  `map_id` varchar(6) NOT NULL,
  `last_edit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `map_id` (`map_id`),
  KEY `profile_number` (`profile_number`),
  KEY `score` (`score`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4659 ;

--
-- Dumping data for table `scores`
--

INSERT INTO `scores` (`id`, `profile_number`, `score`, `legit`, `map_id`, `last_edit_time`) VALUES
(1, '76561197999028024', 103, 1, '47741', '2013-07-14 15:45:47'),
(2, '76561198006021316', 103, 1, '47741', '2013-07-14 15:45:47'),
(3, '76561198014521173', 895, 1, '47741', '2013-07-14 15:45:47'),
(4, '76561198046780305', 895, 1, '47741', '2013-07-14 15:45:47'),
(5, '76561197984513422', 980, 1, '47741', '2013-07-14 15:45:47'),
(6, '76561198042995537', 1016, 1, '47741', '2013-07-14 15:45:47'),
(7, '76561198045034733', 1009, 1, '47741', '2013-07-16 17:47:04'),
(8, '76561197974616889', 1048, 1, '47741', '2013-07-14 15:45:47'),
(9, '76561198015678746', 998, 1, '47741', '2013-10-29 18:14:02'),
(10, '76561198048636382', 1054, 1, '47741', '2013-07-14 15:45:47');


-- --------------------------------------------------------

--
-- Table structure for table `singlesegment`
--

CREATE TABLE IF NOT EXISTS `singlesegment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `updated` varchar(250) NOT NULL COMMENT 'Last updated',
  `datatable` mediumtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `singlesegment`
--

INSERT INTO `singlesegment` (`id`, `updated`, `datatable`) VALUES
(1, '03/04/2014 01:31:08 pm GMT+0', 'a:2:{s:8:"Portal 1";a:3:{s:21:"Beat the game, No OOB";a:78:{i:0;a:3:{s:6:"Player";s:8:"SullyJHF";s:15:"Time(w/o Loads)";s:12:"00:13:09.345";s:14:"Time(w/ Loads)";s:8:"00:13:33";}i:1;a:3:{s:6:"Player";s:6:"Blizik";s:15:"Time(w/o Loads)";s:12:"00:13:09.435";s:14:"Time(w/ Loads)";s:8:"00:13:39";}i:2;a:3:{s:6:"Player";s:9:"Norferzlo";s:15:"Time(w/o Loads)";s:12:"00:13:31.785";s:14:"Time(w/ Loads)";s:11:"00:13:47.71";}i:3;a:3:{s:6:"Player";s:8:"ThisBlue";s:15:"Time(w/o Loads)";s:12:"00:13:36.030";s:14:"Time(w/ Loads)";s:7:"13:51.6";}i:4;a:3:{s:6:"Player";s:9:"Spyrunite";s:15:"Time(w/o Loads)";s:12:"00:13:42.450";s:14:"Time(w/ Loads)";s:8:"00:14:14";}i:5;a:3:{s:6:"Player";s:6:"Azorae";s:15:"Time(w/o Loads)";s:12:"00:13:50.625";s:14:"Time(w/ Loads)";s:10:"00:14:05.1";}i:6;a:3:{s:6:"Player";s:6:"Imanex";s:15:"Time(w/o Loads)";s:12:"00:13:53.565";s:14:"Time(w/ Loads)";s:8:"00:14:18";}i:7;a:3:{s:6:"Player";s:8:"Isolitic";s:15:"Time(w/o Loads)";s:12:"00:13:56.145";s:14:"Time(w/ Loads)";s:8:"00:14:10";}i:8;a:3:{s:6:"Player";s:7:"NoirCat";s:15:"Time(w/o Loads)";s:8:"00:14:02";s:14:"Time(w/ Loads)";s:0:"";}i:9;a:3:{s:6:"Player";s:4:"Yeti";s:15:"Time(w/o Loads)";s:8:"00:14:05";s:14:"Time(w/ Loads)";s:0:"";}i:10;a:3:{s:6:"Player";s:9:"Znernicus";s:15:"Time(w/o Loads)";s:12:"00:14:15.070";s:14:"Time(w/ Loads)";s:8:"00:14:38";}i:11;a:3:{s:6:"Player";s:7:"Phantom";s:15:"Time(w/o Loads)";s:12:"00:14:45.255";s:14:"Time(w/ Loads)";s:11:"00:15:10.56";}i:12;a:3:{s:6:"Player";s:9:"Jodmangel";s:15:"Time(w/o Loads)";s:12:"00:14:45.645";s:14:"Time(w/ Loads)";s:0:"";}i:13;a:3:{s:6:"Player";s:8:"Cubeface";s:15:"Time(w/o Loads)";s:12:"00:14:50.385";s:14:"Time(w/ Loads)";s:8:"00:15:24";}i:14;a:3:{s:6:"Player";s:7:"Maggg0t";s:15:"Time(w/o Loads)";s:12:"00:14:50.955";s:14:"Time(w/ Loads)";s:8:"00:15:12";}i:15;a:3:{s:6:"Player";s:6:"7thAce";s:15:"Time(w/o Loads)";s:12:"00:14:51.150";s:14:"Time(w/ Loads)";s:10:"00:15:20.0";}i:16;a:3:{s:6:"Player";s:11:"gmansoliver";s:15:"Time(w/o Loads)";s:12:"00:14:52.445";s:14:"Time(w/ Loads)";s:11:"00:15:09.41";}i:17;a:3:{s:6:"Player";s:8:"TheAsuro";s:15:"Time(w/o Loads)";s:12:"00:14:53.430";s:14:"Time(w/ Loads)";s:8:"00:15:13";}i:18;a:3:{s:6:"Player";s:7:"Tomsk45";s:15:"Time(w/o Loads)";s:12:"00:14:56.700";s:14:"Time(w/ Loads)";s:8:"00:15:21";}i:19;a:3:{s:6:"Player";s:10:"Ace Rimmer";s:15:"Time(w/o Loads)";s:12:"00:14:56.760";s:14:"Time(w/ Loads)";s:8:"00:15:19";}i:20;a:3:{s:6:"Player";s:5:"Xebaz";s:15:"Time(w/o Loads)";s:12:"00:15:04.065";s:14:"Time(w/ Loads)";s:8:"00:15:26";}i:21;a:3:{s:6:"Player";s:4:"xify";s:15:"Time(w/o Loads)";s:12:"00:15:08.205";s:14:"Time(w/ Loads)";s:11:"00:15:54.57";}i:22;a:3:{s:6:"Player";s:5:"Lange";s:15:"Time(w/o Loads)";s:11:"00:15:09.42";s:14:"Time(w/ Loads)";s:11:"00:15:30.50";}i:23;a:3:{s:6:"Player";s:21:"Jacethewalletsculptor";s:15:"Time(w/o Loads)";s:8:"00:15:16";s:14:"Time(w/ Loads)";s:8:"00:15:43";}i:24;a:3:{s:6:"Player";s:7:"SirAMPR";s:15:"Time(w/o Loads)";s:8:"00:15:22";s:14:"Time(w/ Loads)";s:8:"00:15:35";}i:25;a:3:{s:6:"Player";s:7:"Maxxuss";s:15:"Time(w/o Loads)";s:8:"00:15:25";s:14:"Time(w/ Loads)";s:8:"00:15:44";}i:26;a:3:{s:6:"Player";s:11:"Inexistence";s:15:"Time(w/o Loads)";s:8:"00:15:26";s:14:"Time(w/ Loads)";s:0:"";}i:27;a:3:{s:6:"Player";s:8:"Cirno_TV";s:15:"Time(w/o Loads)";s:8:"00:15:35";s:14:"Time(w/ Loads)";s:8:"00:15:51";}i:28;a:3:{s:6:"Player";s:9:"WonderJ13";s:15:"Time(w/o Loads)";s:12:"00:15:41.745";s:14:"Time(w/ Loads)";s:8:"00:16:13";}i:29;a:3:{s:6:"Player";s:6:"Imanex";s:15:"Time(w/o Loads)";s:8:"00:15:44";s:14:"Time(w/ Loads)";s:8:"00:16:14";}i:30;a:3:{s:6:"Player";s:5:"nudge";s:15:"Time(w/o Loads)";s:12:"00:15:45.885";s:14:"Time(w/ Loads)";s:8:"00:16:35";}i:31;a:3:{s:6:"Player";s:6:"Colfra";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:15:47";}i:32;a:3:{s:6:"Player";s:12:"GrieveNoMore";s:15:"Time(w/o Loads)";s:8:"00:15:47";s:14:"Time(w/ Loads)";s:8:"00:16:05";}i:33;a:3:{s:6:"Player";s:8:"wakecold";s:15:"Time(w/o Loads)";s:8:"00:15:50";s:14:"Time(w/ Loads)";s:8:"00:16:13";}i:34;a:3:{s:6:"Player";s:9:"z1mb0bw4y";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:16:13";}i:35;a:3:{s:6:"Player";s:7:"Fatalis";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:16:14";}i:36;a:3:{s:6:"Player";s:13:"Blood_Thunder";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:16:22";}i:37;a:3:{s:6:"Player";s:5:"cuppo";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:16:23";}i:38;a:3:{s:6:"Player";s:10:"Noobbuster";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:16:25";}i:39;a:3:{s:6:"Player";s:12:"Shickodabaka";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:16:27";}i:40;a:3:{s:6:"Player";s:6:"ColumW";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:16:37";}i:41;a:3:{s:6:"Player";s:8:"Toad1750";s:15:"Time(w/o Loads)";s:12:"00:16:38.100";s:14:"Time(w/ Loads)";s:8:"00:17:41";}i:42;a:3:{s:6:"Player";s:5:"Salty";s:15:"Time(w/o Loads)";s:8:"00:16:41";s:14:"Time(w/ Loads)";s:0:"";}i:43;a:3:{s:6:"Player";s:10:"SuprCookie";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:16:43";}i:44;a:3:{s:6:"Player";s:3:"Fog";s:15:"Time(w/o Loads)";s:8:"00:16:44";s:14:"Time(w/ Loads)";s:8:"00:17:36";}i:45;a:3:{s:6:"Player";s:6:"E-thug";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:16:46";}i:46;a:3:{s:6:"Player";s:9:"mcplaya27";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:11:"00:16:46.97";}i:47;a:3:{s:6:"Player";s:8:"Jesustf2";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:17:04";}i:48;a:3:{s:6:"Player";s:8:"Gijs123a";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:17:10";}i:49;a:3:{s:6:"Player";s:6:"Tlozsr";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:17:51";}i:50;a:3:{s:6:"Player";s:8:"DeaD MaN";s:15:"Time(w/o Loads)";s:12:"00:17:27.945";s:14:"Time(w/ Loads)";s:0:"";}i:51;a:3:{s:6:"Player";s:7:"Klooger";s:15:"Time(w/o Loads)";s:8:"00:18:10";s:14:"Time(w/ Loads)";s:8:"00:18:33";}i:52;a:3:{s:6:"Player";s:9:"Failfixer";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:10:"00:18:21.0";}i:53;a:3:{s:6:"Player";s:16:"CriminallyVulgar";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:18:25";}i:54;a:3:{s:6:"Player";s:10:"Jonese1234";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:18:38";}i:55;a:3:{s:6:"Player";s:5:"stalk";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:18:46";}i:56;a:3:{s:6:"Player";s:7:"OK_Rick";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:18:53";}i:57;a:3:{s:6:"Player";s:9:"Mr_Carter";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:18:54";}i:58;a:3:{s:6:"Player";s:8:"TechTony";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:18:58";}i:59;a:3:{s:6:"Player";s:9:"SalamalaS";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:18:59";}i:60;a:3:{s:6:"Player";s:7:"TPorter";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:19:17";}i:61;a:3:{s:6:"Player";s:2:"S.";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:19:21";}i:62;a:3:{s:6:"Player";s:12:"TheGaspNinja";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:19:22";}i:63;a:3:{s:6:"Player";s:7:"Abahbob";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:19:22";}i:64;a:3:{s:6:"Player";s:6:"noiniM";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:19:33";}i:65;a:3:{s:6:"Player";s:8:"HeXeRMaN";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:19:35";}i:66;a:3:{s:6:"Player";s:9:"Cronikeys";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:19:42";}i:67;a:3:{s:6:"Player";s:6:"Draiku";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:19:46";}i:68;a:3:{s:6:"Player";s:15:"ThePsychoTurtle";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:19:53";}i:69;a:3:{s:6:"Player";s:4:"Pykn";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:20:06";}i:70;a:3:{s:6:"Player";s:10:"CanviSionZ";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:20:18";}i:71;a:3:{s:6:"Player";s:11:"ArcaneZaros";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:22:00";}i:72;a:3:{s:6:"Player";s:13:"TheCuteFennec";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:22:11";}i:73;a:3:{s:6:"Player";s:8:"Link2006";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:22:41";}i:74;a:3:{s:6:"Player";s:9:"Anubisbro";s:15:"Time(w/o Loads)";s:8:"00:23:23";s:14:"Time(w/ Loads)";s:8:"00:24:00";}i:75;a:3:{s:6:"Player";s:5:"Hooky";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:23:36";}i:76;a:3:{s:6:"Player";s:5:"Zypeh";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:26:11";}i:77;a:3:{s:6:"Player";s:7:"blha303";s:15:"Time(w/o Loads)";s:12:"00:23:26.085";s:14:"Time(w/ Loads)";s:8:"00:26:38";}}s:13:"Beat the game";a:27:{i:0;a:3:{s:6:"Player";s:9:"Norferzlo";s:15:"Time(w/o Loads)";s:12:"00:09:18.201";s:14:"Time(w/ Loads)";s:8:"00:09:32";}i:1;a:3:{s:6:"Player";s:9:"Spyrunite";s:15:"Time(w/o Loads)";s:12:"00:09:41.685";s:14:"Time(w/ Loads)";s:8:"00:10:21";}i:2;a:3:{s:6:"Player";s:6:"Azorae";s:15:"Time(w/o Loads)";s:12:"00:09:47.160";s:14:"Time(w/ Loads)";s:8:"00:10:00";}i:3;a:3:{s:6:"Player";s:9:"Znernicus";s:15:"Time(w/o Loads)";s:12:"00:09:50.610";s:14:"Time(w/ Loads)";s:8:"00:10:08";}i:4;a:3:{s:6:"Player";s:9:"Jodmangel";s:15:"Time(w/o Loads)";s:12:"00:09:58.875";s:14:"Time(w/ Loads)";s:0:"";}i:5;a:3:{s:6:"Player";s:8:"ThisBlue";s:15:"Time(w/o Loads)";s:12:"00:10:05.025";s:14:"Time(w/ Loads)";s:8:"00:10:18";}i:6;a:3:{s:6:"Player";s:10:"Capslocked";s:15:"Time(w/o Loads)";s:12:"00:10:09.990";s:14:"Time(w/ Loads)";s:8:"00:10:43";}i:7;a:3:{s:6:"Player";s:5:"Wshaf";s:15:"Time(w/o Loads)";s:11:"00:10:24.00";s:14:"Time(w/ Loads)";s:8:"00:10:47";}i:8;a:3:{s:6:"Player";s:7:"Tomsk45";s:15:"Time(w/o Loads)";s:12:"00:10:26.340";s:14:"Time(w/ Loads)";s:8:"00:10:53";}i:9;a:3:{s:6:"Player";s:5:"iVerb";s:15:"Time(w/o Loads)";s:12:"00:10:28.500";s:14:"Time(w/ Loads)";s:8:"00:11:19";}i:10;a:3:{s:6:"Player";s:8:"SullyJHF";s:15:"Time(w/o Loads)";s:12:"00:10:36.285";s:14:"Time(w/ Loads)";s:8:"00:11:19";}i:11;a:3:{s:6:"Player";s:8:"Gijs123a";s:15:"Time(w/o Loads)";s:11:"00:10:51.90";s:14:"Time(w/ Loads)";s:8:"00:11:13";}i:12;a:3:{s:6:"Player";s:4:"Xiah";s:15:"Time(w/o Loads)";s:11:"00:10:52.86";s:14:"Time(w/ Loads)";s:8:"00:11:39";}i:13;a:3:{s:6:"Player";s:6:"Imanex";s:15:"Time(w/o Loads)";s:12:"00:11:08.145";s:14:"Time(w/ Loads)";s:8:"00:11:54";}i:14;a:3:{s:6:"Player";s:13:"Blood_Thunder";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:11:19";}i:15;a:3:{s:6:"Player";s:12:"Chinese_soup";s:15:"Time(w/o Loads)";s:12:"00:11:20.775";s:14:"Time(w/ Loads)";s:8:"00:11:45";}i:16;a:3:{s:6:"Player";s:5:"Kenji";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:11:43";}i:17;a:3:{s:6:"Player";s:8:"Flatezer";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:11:56";}i:18;a:3:{s:6:"Player";s:9:"z1mb0bw4y";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:11:59";}i:19;a:3:{s:6:"Player";s:9:"SalamalaS";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:12:08";}i:20;a:3:{s:6:"Player";s:6:"Colfra";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:12:09";}i:21;a:3:{s:6:"Player";s:8:"Betsuner";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:12:27";}i:22;a:3:{s:6:"Player";s:9:"Mcplaya27";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:12:56";}i:23;a:3:{s:6:"Player";s:5:"Xebaz";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:13:32";}i:24;a:3:{s:6:"Player";s:3:"ZFG";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:14:29";}i:25;a:3:{s:6:"Player";s:2:"S.";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:16:41";}i:26;a:3:{s:6:"Player";s:11:"gmansoliver";s:15:"Time(w/o Loads)";s:8:"00:27:06";s:14:"Time(w/ Loads)";s:8:"00:27:50";}}s:25:"Beat the game, Glitchless";a:12:{i:0;a:3:{s:6:"Player";s:9:"Norferzlo";s:15:"Time(w/o Loads)";s:9:"18:51.060";s:14:"Time(w/ Loads)";s:5:"19:06";}i:1;a:3:{s:6:"Player";s:8:"ThisBlue";s:15:"Time(w/o Loads)";s:9:"18:52.545";s:14:"Time(w/ Loads)";s:7:"19:10.9";}i:2;a:3:{s:6:"Player";s:5:"Stalk";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:20:30";}i:3;a:3:{s:6:"Player";s:13:"Blood_thunder";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:20:50";}i:4;a:3:{s:6:"Player";s:8:"Gijs123a";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:21:25";}i:5;a:3:{s:6:"Player";s:10:"Jonese1234";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:22:00";}i:6;a:3:{s:6:"Player";s:6:"Colfra";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:22:01";}i:7;a:3:{s:6:"Player";s:6:"IanVal";s:15:"Time(w/o Loads)";s:8:"00:23:12";s:14:"Time(w/ Loads)";s:8:"00:24:48";}i:8;a:3:{s:6:"Player";s:15:"ThePsychoTurtle";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:27:52";}i:9;a:3:{s:6:"Player";s:7:"Zephyrz";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:31:58";}i:10;a:3:{s:6:"Player";s:5:"Stalk";s:15:"Time(w/o Loads)";s:8:"00:18:23";s:14:"Time(w/ Loads)";s:8:"00:18:57";}i:11;a:3:{s:6:"Player";s:13:"Blood_Thunder";s:15:"Time(w/o Loads)";s:8:"00:18:47";s:14:"Time(w/ Loads)";s:8:"00:19:10";}}}s:8:"Portal 2";a:3:{s:13:"Beat the game";a:28:{i:0;a:3:{s:6:"Player";s:9:"Znernicus";s:15:"Time(w/o Loads)";s:8:"01:07:28";s:14:"Time(w/ Loads)";s:8:"01:17:29";}i:1;a:3:{s:6:"Player";s:8:"Isolitic";s:15:"Time(w/o Loads)";s:8:"01:08:22";s:14:"Time(w/ Loads)";s:8:"01:16:10";}i:2;a:3:{s:6:"Player";s:9:"Spyrunite";s:15:"Time(w/o Loads)";s:8:"01:09:28";s:14:"Time(w/ Loads)";s:8:"01:19:36";}i:3;a:3:{s:6:"Player";s:8:"Jesustf2";s:15:"Time(w/o Loads)";s:8:"01:10:24";s:14:"Time(w/ Loads)";s:8:"01:18:52";}i:4;a:3:{s:6:"Player";s:9:"PerOculos";s:15:"Time(w/o Loads)";s:10:"1:12:49.33";s:14:"Time(w/ Loads)";s:10:"01:23:06.3";}i:5;a:3:{s:6:"Player";s:6:"Azorae";s:15:"Time(w/o Loads)";s:8:"01:15:06";s:14:"Time(w/ Loads)";s:8:"01:23:45";}i:6;a:3:{s:6:"Player";s:8:"ThisBlue";s:15:"Time(w/o Loads)";s:7:"1:15:12";s:14:"Time(w/ Loads)";s:8:"01:23:42";}i:7;a:3:{s:6:"Player";s:7:"Tapping";s:15:"Time(w/o Loads)";s:8:"01:16:09";s:14:"Time(w/ Loads)";s:19:"01:29:22 (w/ crash)";}i:8;a:3:{s:6:"Player";s:4:"Phui";s:15:"Time(w/o Loads)";s:8:"01:18:09";s:14:"Time(w/ Loads)";s:8:"01:28:28";}i:9;a:3:{s:6:"Player";s:5:"Xebaz";s:15:"Time(w/o Loads)";s:8:"01:18:48";s:14:"Time(w/ Loads)";s:8:"01:28:43";}i:10;a:3:{s:6:"Player";s:10:"Jonese1234";s:15:"Time(w/o Loads)";s:8:"01:19:01";s:14:"Time(w/ Loads)";s:8:"01:29:55";}i:11;a:3:{s:6:"Player";s:7:"TPorter";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"01:25:03";}i:12;a:3:{s:6:"Player";s:4:"Pykn";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"01:26:26";}i:13;a:3:{s:6:"Player";s:11:"Undeadgamer";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"01:29:39";}i:14;a:3:{s:6:"Player";s:6:"Colfra";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"01:30:10";}i:15;a:3:{s:6:"Player";s:7:"Tomsk45";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:11:"01:31:31.31";}i:16;a:3:{s:6:"Player";s:9:"Norferzlo";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"01:34:54";}i:17;a:3:{s:6:"Player";s:5:"iVerb";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"01:35:21";}i:18;a:3:{s:6:"Player";s:7:"Phantom";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"01:35:30";}i:19;a:3:{s:6:"Player";s:6:"Draiku";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"01:38:50";}i:20;a:3:{s:6:"Player";s:15:"ThePsychoTurtle";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"01:40:14";}i:21;a:3:{s:6:"Player";s:9:"mcplaya27";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"01:40:44";}i:22;a:3:{s:6:"Player";s:8:"Toad1750";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"01:43:02";}i:23;a:3:{s:6:"Player";s:8:"Portvakt";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"01:45:50";}i:24;a:3:{s:6:"Player";s:2:"S.";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"01:49:16";}i:25;a:3:{s:6:"Player";s:11:"Yoshipro101";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:7:"1:51:05";}i:26;a:3:{s:6:"Player";s:8:"Limehawk";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"01:56:53";}i:27;a:3:{s:6:"Player";s:9:"WonderJ13";s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"04:43:01";}}s:9:"Beat COOP";a:68:{i:0;a:3:{s:15:"Time(w/o Loads)";s:12:"00:30:32.833";s:14:"Time(w/ Loads)";s:8:"00:40:19";s:6:"Player";s:16:"Imanex & Klooger";}i:1;a:3:{s:15:"Time(w/o Loads)";s:8:"00:32:14";s:14:"Time(w/ Loads)";s:8:"00:46:41";s:6:"Player";s:17:"Phantom & Klooger";}i:2;a:3:{s:15:"Time(w/o Loads)";s:8:"00:33:04";s:14:"Time(w/ Loads)";s:8:"00:42:21";s:6:"Player";s:16:"Hexerman & iVerb";}i:3;a:3:{s:15:"Time(w/o Loads)";s:8:"00:33:24";s:14:"Time(w/ Loads)";s:8:"00:41:41";s:6:"Player";s:14:"Znernicus & S.";}i:4;a:3:{s:15:"Time(w/o Loads)";s:8:"00:33:33";s:14:"Time(w/ Loads)";s:8:"00:44:36";s:6:"Player";s:20:"Znernicus & Isolitic";}i:5;a:3:{s:15:"Time(w/o Loads)";s:8:"00:33:49";s:14:"Time(w/ Loads)";s:8:"00:42:30";s:6:"Player";s:14:"Colfra & Xebaz";}i:6;a:3:{s:15:"Time(w/o Loads)";s:8:"00:33:54";s:14:"Time(w/ Loads)";s:8:"00:44:04";s:6:"Player";s:19:"z1mb0bw4y & Klooger";}i:7;a:3:{s:15:"Time(w/o Loads)";s:8:"00:34:04";s:14:"Time(w/ Loads)";s:8:"00:44:28";s:6:"Player";s:19:"Spyrunite & Klooger";}i:8;a:3:{s:15:"Time(w/o Loads)";s:8:"00:34:12";s:14:"Time(w/ Loads)";s:8:"00:42:49";s:6:"Player";s:20:"Znernicus & ZeroCool";}i:9;a:3:{s:15:"Time(w/o Loads)";s:8:"00:34:13";s:14:"Time(w/ Loads)";s:8:"00:46:04";s:6:"Player";s:19:"Betsruner & Klooger";}i:10;a:3:{s:15:"Time(w/o Loads)";s:8:"00:34:23";s:14:"Time(w/ Loads)";s:8:"00:44:26";s:6:"Player";s:17:"Klooger & Phantom";}i:11;a:3:{s:15:"Time(w/o Loads)";s:8:"00:34:51";s:14:"Time(w/ Loads)";s:8:"00:46:19";s:6:"Player";s:16:"Gocnak & Klooger";}i:12;a:3:{s:15:"Time(w/o Loads)";s:8:"00:34:57";s:14:"Time(w/ Loads)";s:8:"00:44:32";s:6:"Player";s:16:"Phantom & Draiku";}i:13;a:3:{s:15:"Time(w/o Loads)";s:8:"00:35:18";s:14:"Time(w/ Loads)";s:8:"00:44:40";s:6:"Player";s:11:"Gocnak & S.";}i:14;a:3:{s:15:"Time(w/o Loads)";s:8:"00:35:27";s:14:"Time(w/ Loads)";s:8:"00:47:46";s:6:"Player";s:20:"Spyrunite & Flatezer";}i:15;a:3:{s:15:"Time(w/o Loads)";s:8:"00:36:26";s:14:"Time(w/ Loads)";s:8:"00:46:14";s:6:"Player";s:22:"Jonese1234 & AJspartan";}i:16;a:3:{s:15:"Time(w/o Loads)";s:8:"00:36:26";s:14:"Time(w/ Loads)";s:8:"00:47:55";s:6:"Player";s:18:"SullyJHF & Tomsk45";}i:17;a:3:{s:15:"Time(w/o Loads)";s:8:"00:36:35";s:14:"Time(w/ Loads)";s:8:"00:48:02";s:6:"Player";s:16:"Klooger & Imanex";}i:18;a:3:{s:15:"Time(w/o Loads)";s:8:"00:37:24";s:14:"Time(w/ Loads)";s:8:"00:46:24";s:6:"Player";s:19:"Phantom & Spyrunite";}i:19;a:3:{s:15:"Time(w/o Loads)";s:8:"00:37:34";s:14:"Time(w/ Loads)";s:8:"00:50:16";s:6:"Player";s:19:"Phantom & Swagatron";}i:20;a:3:{s:15:"Time(w/o Loads)";s:8:"00:37:38";s:14:"Time(w/ Loads)";s:8:"00:49:47";s:6:"Player";s:15:"Lemon & Klooger";}i:21;a:3:{s:15:"Time(w/o Loads)";s:8:"00:37:55";s:14:"Time(w/ Loads)";s:8:"00:49:05";s:6:"Player";s:16:"SullyJHF & Xebaz";}i:22;a:3:{s:15:"Time(w/o Loads)";s:8:"00:37:59";s:14:"Time(w/ Loads)";s:8:"00:48:08";s:6:"Player";s:16:"Colfra & Tomsk45";}i:23;a:3:{s:15:"Time(w/o Loads)";s:8:"00:37:59";s:14:"Time(w/ Loads)";s:8:"00:49:31";s:6:"Player";s:17:"SullyJHF & Azorae";}i:24;a:3:{s:15:"Time(w/o Loads)";s:8:"00:38:15";s:14:"Time(w/ Loads)";s:8:"00:47:30";s:6:"Player";s:14:"Whac & Sweeney";}i:25;a:3:{s:15:"Time(w/o Loads)";s:8:"00:38:17";s:14:"Time(w/ Loads)";s:8:"00:49:19";s:6:"Player";s:15:"Xebaz & Klooger";}i:26;a:3:{s:15:"Time(w/o Loads)";s:8:"00:38:21";s:14:"Time(w/ Loads)";s:8:"00:48:06";s:6:"Player";s:11:"D4rw1n & S.";}i:27;a:3:{s:15:"Time(w/o Loads)";s:8:"00:38:27";s:14:"Time(w/ Loads)";s:8:"00:50:13";s:6:"Player";s:12:"Gig & Colfra";}i:28;a:3:{s:15:"Time(w/o Loads)";s:8:"00:38:47";s:14:"Time(w/ Loads)";s:8:"00:50:08";s:6:"Player";s:15:"Zypeh & Klooger";}i:29;a:3:{s:15:"Time(w/o Loads)";s:8:"00:38:50";s:14:"Time(w/ Loads)";s:8:"00:49:12";s:6:"Player";s:16:"Phantom & Imanex";}i:30;a:3:{s:15:"Time(w/o Loads)";s:8:"00:39:04";s:14:"Time(w/ Loads)";s:8:"00:49:36";s:6:"Player";s:17:"Msushi & Tanger2b";}i:31;a:3:{s:15:"Time(w/o Loads)";s:8:"00:39:10";s:14:"Time(w/ Loads)";s:8:"00:49:30";s:6:"Player";s:16:"Markel & Klooger";}i:32;a:3:{s:15:"Time(w/o Loads)";s:8:"00:39:54";s:14:"Time(w/ Loads)";s:8:"00:57:44";s:6:"Player";s:13:"Gig & Phantom";}i:33;a:3:{s:15:"Time(w/o Loads)";s:8:"00:39:59";s:14:"Time(w/ Loads)";s:8:"00:50:39";s:6:"Player";s:17:"Spyrunite & Xebaz";}i:34;a:3:{s:15:"Time(w/o Loads)";s:8:"00:40:59";s:14:"Time(w/ Loads)";s:8:"00:49:45";s:6:"Player";s:17:"Jetwash & Klooger";}i:35;a:3:{s:15:"Time(w/o Loads)";s:8:"00:41:02";s:14:"Time(w/ Loads)";s:8:"00:52:20";s:6:"Player";s:21:"Impossibear & Klooger";}i:36;a:3:{s:15:"Time(w/o Loads)";s:8:"00:41:17";s:14:"Time(w/ Loads)";s:8:"00:52:04";s:6:"Player";s:17:"Klooger & eTholon";}i:37;a:3:{s:15:"Time(w/o Loads)";s:8:"00:42:07";s:14:"Time(w/ Loads)";s:8:"00:53:16";s:6:"Player";s:19:"Z1mb0bw4y & Phantom";}i:38;a:3:{s:15:"Time(w/o Loads)";s:8:"00:42:30";s:14:"Time(w/ Loads)";s:8:"00:51:56";s:6:"Player";s:19:"Phantom & Betsruner";}i:39;a:3:{s:15:"Time(w/o Loads)";s:8:"00:42:30";s:14:"Time(w/ Loads)";s:8:"00:52:46";s:6:"Player";s:13:"S. & Isolitic";}i:40;a:3:{s:15:"Time(w/o Loads)";s:8:"00:43:35";s:14:"Time(w/ Loads)";s:8:"00:54:18";s:6:"Player";s:22:"Chinese_soup & Tomsk45";}i:41;a:3:{s:15:"Time(w/o Loads)";s:8:"00:43:52";s:14:"Time(w/ Loads)";s:8:"00:54:30";s:6:"Player";s:21:"Drunkguy101 & Klooger";}i:42;a:3:{s:15:"Time(w/o Loads)";s:8:"00:44:07";s:14:"Time(w/ Loads)";s:0:"";s:6:"Player";s:18:"Jonese1234 & Qqzzy";}i:43;a:3:{s:15:"Time(w/o Loads)";s:8:"00:47:55";s:14:"Time(w/ Loads)";s:8:"00:58:20";s:6:"Player";s:20:"Chinese_soup & Elgu_";}i:44;a:3:{s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:48:17";s:6:"Player";s:18:"Gocnak & z1mb0bw4y";}i:45;a:3:{s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:48:32";s:6:"Player";s:13:"SullyJHF & S.";}i:46;a:3:{s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:48:36";s:6:"Player";s:11:"Colfra & S.";}i:47;a:3:{s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:48:58";s:6:"Player";s:22:"Undeadgamer & Jesustf2";}i:48;a:3:{s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:49:04";s:6:"Player";s:16:"Xebaz & Jesustf2";}i:49;a:3:{s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:49:32";s:6:"Player";s:15:"Colfra & D4rw1n";}i:50;a:3:{s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:50:18";s:6:"Player";s:17:"Colfra & Jesustf2";}i:51;a:3:{s:15:"Time(w/o Loads)";s:8:"00:50:25";s:14:"Time(w/ Loads)";s:8:"01:04:18";s:6:"Player";s:19:"mcplaya27 & Sweeney";}i:52;a:3:{s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:50:54";s:6:"Player";s:12:"S. & Tomsk45";}i:53;a:3:{s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:51:00";s:6:"Player";s:14:"Azorae & Xebaz";}i:54;a:3:{s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:51:32";s:6:"Player";s:18:"eclpsN & Freechips";}i:55;a:3:{s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:52:03";s:6:"Player";s:17:"Chubfish & Exhale";}i:56;a:3:{s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:52:43";s:6:"Player";s:14:"z1mb0bw4y & S.";}i:57;a:3:{s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:53:13";s:6:"Player";s:19:"Phantom & Uscobra11";}i:58;a:3:{s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:53:32";s:6:"Player";s:17:"Znernicus & Xebaz";}i:59;a:3:{s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:53:47";s:6:"Player";s:17:"Chubfish & Colfra";}i:60;a:3:{s:15:"Time(w/o Loads)";s:12:"00:55:03.267";s:14:"Time(w/ Loads)";s:8:"01:05:06";s:6:"Player";s:15:"Qqzzy & Arstigr";}i:61;a:3:{s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:55:39";s:6:"Player";s:17:"SullyJHF & Colfra";}i:62;a:3:{s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:55:52";s:6:"Player";s:15:"Imanex & Draiku";}i:63;a:3:{s:15:"Time(w/o Loads)";s:12:"00:56:02.819";s:14:"Time(w/ Loads)";s:10:"01:06:58.4";s:6:"Player";s:14:"TPorter & Luke";}i:64;a:3:{s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:57:10";s:6:"Player";s:12:"S. & eTholon";}i:65;a:3:{s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"01:02:49";s:6:"Player";s:19:"Tomsk45 & Norferzlo";}i:66;a:3:{s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"01:12:45";s:6:"Player";s:17:"Tomsk45 & Whimsey";}i:67;a:3:{s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"01:18:56";s:6:"Player";s:12:"RNELord & S.";}}s:14:"Beat COOP Solo";a:16:{i:0;a:3:{s:15:"Time(w/o Loads)";s:12:"00:39:41.783";s:14:"Time(w/ Loads)";s:8:"00:43:20";s:6:"Player";s:7:"Klooger";}i:1;a:3:{s:15:"Time(w/o Loads)";s:8:"00:40:52";s:14:"Time(w/ Loads)";s:8:"00:46:07";s:6:"Player";s:7:"Phantom";}i:2;a:3:{s:15:"Time(w/o Loads)";s:12:"00:42:28.200";s:14:"Time(w/ Loads)";s:8:"00:46:11";s:6:"Player";s:6:"Azorae";}i:3;a:3:{s:15:"Time(w/o Loads)";s:10:"00:43:56.9";s:14:"Time(w/ Loads)";s:8:"00:47:49";s:6:"Player";s:8:"Isolitic";}i:4;a:3:{s:15:"Time(w/o Loads)";s:12:"00:47:27.567";s:14:"Time(w/ Loads)";s:8:"00:53:38";s:6:"Player";s:5:"Xebaz";}i:5;a:3:{s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:52:55";s:6:"Player";s:9:"Spyrunite";}i:6;a:3:{s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:53:49";s:6:"Player";s:6:"Msushi";}i:7;a:3:{s:15:"Time(w/o Loads)";s:12:"00:53:32.633";s:14:"Time(w/ Loads)";s:8:"00:58:33";s:6:"Player";s:2:"S.";}i:8;a:3:{s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:55:07";s:6:"Player";s:8:"Jesustf2";}i:9;a:3:{s:15:"Time(w/o Loads)";s:12:"00:56:19.000";s:14:"Time(w/ Loads)";s:8:"01:00:50";s:6:"Player";s:8:"Toad1750";}i:10;a:3:{s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:57:11";s:6:"Player";s:11:"Drunkguy101";}i:11;a:3:{s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"00:58:49";s:6:"Player";s:8:"SullyJHF";}i:12;a:3:{s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"01:12:41";s:6:"Player";s:12:"Chinese_soup";}i:13;a:3:{s:15:"Time(w/o Loads)";s:8:"01:13:45";s:14:"Time(w/ Loads)";s:8:"01:18:18";s:6:"Player";s:10:"Jonese1234";}i:14;a:3:{s:15:"Time(w/o Loads)";s:0:"";s:14:"Time(w/ Loads)";s:8:"01:58:19";s:6:"Player";s:9:"Norferzlo";}i:15;a:3:{s:15:"Time(w/o Loads)";s:8:"01:53:07";s:14:"Time(w/ Loads)";s:8:"01:58:43";s:6:"Player";s:7:"TPorter";}}}}');

-- --------------------------------------------------------


-- --------------------------------------------------------

--
-- Table structure for table `usersnew`
--

CREATE TABLE IF NOT EXISTS `usersnew` (
  `profile_number` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `boardname` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `steamname` varchar(100) CHARACTER SET ucs2 DEFAULT NULL,
  `donator` int(1) NOT NULL DEFAULT '0',
  `banned` int(1) NOT NULL DEFAULT '0',
  `registered` int(1) NOT NULL DEFAULT '0',
  `avatar` varchar(200) CHARACTER SET utf32 DEFAULT NULL,
  `twitch` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `youtube` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `title` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`profile_number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usersnew`
--

INSERT INTO `usersnew` (`profile_number`, `boardname`, `steamname`, `donator`, `banned`, `registered`, `avatar`, `twitch`, `youtube`, `title`) VALUES
('76561197960366637', NULL, 'Test', 0, 0, 1, 'http://media.steampowered.com/steamcommunity/public/images/avatars/fe/fef49eff8dc1cdfeb_full.jpg', NULL, NULL, NULL),
('76561197960403893', NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `maps`
--
ALTER TABLE `maps`
  ADD CONSTRAINT `maps_ibfk_1` FOREIGN KEY (`chapter_id`) REFERENCES `chapters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;