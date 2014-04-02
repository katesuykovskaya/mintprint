-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 18 2013 г., 23:34
-- Версия сервера: 5.5.30
-- Версия PHP: 5.4.4-14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `usermenu`
--

CREATE TABLE IF NOT EXISTS `usermenu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `root` int(11) NOT NULL,
  `text` varchar(128) NOT NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `url` varchar(128) NOT NULL,
  `role` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50 ;

--
-- Дамп данных таблицы `usermenu`
--

INSERT INTO `usermenu` (`id`, `root`, `text`, `lft`, `rgt`, `level`, `url`, `role`) VALUES
(1, 1, 'Authenticated', 1, 4, 1, '', 'Authenticated'),
(2, 1, 'Users.Users.Logout', 2, 3, 2, '/backend/users/users/logout', 'Authenticated'),
(3, 3, 'overAllManager', 1, 90, 1, '', 'overAllManager'),
(4, 3, 'Users.Users.Logout', 81, 88, 3, '/backend/users/users/logout', 'overAllManager'),
(5, 3, 'Feedback.Feedback.Admin', 4, 5, 2, '/backend/feedback/feedback/admin', 'overAllManager'),
(6, 3, 'Feedback.Feedback.Create', 6, 7, 2, '/backend/feedback/feedback/create', 'overAllManager'),
(7, 3, 'Feedback.Feedback.Delete', 8, 9, 2, '/backend/feedback/feedback/delete', 'overAllManager'),
(8, 3, 'Feedback.Feedback.Index', 10, 11, 2, '/backend/feedback/feedback/index', 'overAllManager'),
(9, 3, 'Feedback.Feedback.MailList', 12, 13, 2, '/backend/feedback/feedback/maillist', 'overAllManager'),
(10, 3, 'Feedback.Feedback.Update', 14, 15, 2, '/backend/feedback/feedback/update', 'overAllManager'),
(11, 3, 'Feedback.Feedback.View', 16, 17, 2, '/backend/feedback/feedback/view', 'overAllManager'),
(12, 3, 'Multilanguage.Message.Admin', 18, 19, 2, '/backend/multilanguage/message/admin', 'overAllManager'),
(13, 3, 'Multilanguage.Message.Create', 20, 21, 2, '/backend/multilanguage/message/create', 'overAllManager'),
(14, 3, 'Multilanguage.Message.Delete', 22, 23, 2, '/backend/multilanguage/message/delete', 'overAllManager'),
(15, 3, 'Multilanguage.Message.Index', 24, 25, 2, '/backend/multilanguage/message/index', 'overAllManager'),
(16, 3, 'Multilanguage.Message.Update', 26, 27, 2, '/backend/multilanguage/message/update', 'overAllManager'),
(17, 3, 'Multilanguage.Message.View', 28, 29, 2, '/backend/multilanguage/message/view', 'overAllManager'),
(18, 3, 'Multilanguage.Source.Admin', 30, 31, 2, '/backend/multilanguage/source/admin', 'overAllManager'),
(19, 3, 'Multilanguage.Source.Create', 32, 33, 2, '/backend/multilanguage/source/create', 'overAllManager'),
(20, 3, 'Multilanguage.Source.Delete', 34, 35, 2, '/backend/multilanguage/source/delete', 'overAllManager'),
(21, 3, 'Multilanguage.Source.Index', 36, 37, 2, '/backend/multilanguage/source/index', 'overAllManager'),
(22, 3, 'Multilanguage.Source.Relational', 38, 39, 2, '/backend/multilanguage/source/relational', 'overAllManager'),
(23, 3, 'Multilanguage.Source.Update', 40, 41, 2, '/backend/multilanguage/source/update', 'overAllManager'),
(24, 3, 'Multilanguage.Source.View', 42, 43, 2, '/backend/multilanguage/source/view', 'overAllManager'),
(25, 3, 'Users.Users.Login', 79, 80, 3, '/backend/users/users/login', 'overAllManager'),
(26, 3, 'Pages.Pages.Admin', 44, 45, 2, '/backend/pages/pages/admin', 'overAllManager'),
(27, 3, 'Pages.Pages.Create', 46, 47, 2, '/backend/pages/pages/create', 'overAllManager'),
(28, 3, 'Pages.Pages.Delete', 48, 49, 2, '/backend/pages/pages/delete', 'overAllManager'),
(29, 3, 'Pages.Pages.FetchTree', 50, 51, 2, '/backend/pages/pages/fetchtree', 'overAllManager'),
(30, 3, 'Pages.Pages.Grid', 52, 53, 2, '/backend/pages/pages/grid', 'overAllManager'),
(31, 3, 'Pages.Pages.GridSave', 54, 55, 2, '/backend/pages/pages/gridsave', 'overAllManager'),
(32, 3, 'Pages.Pages.Index', 56, 57, 2, '/backend/pages/pages/index', 'overAllManager'),
(33, 3, 'Pages.Pages.PageTree', 58, 59, 2, '/backend/pages/pages/pagetree', 'overAllManager'),
(34, 3, 'Pages.Pages.Update', 60, 61, 2, '/backend/pages/pages/update', 'overAllManager'),
(35, 3, 'Pages.Pages.View', 62, 63, 2, '/backend/pages/pages/view', 'overAllManager'),
(36, 3, 'Users.Users.Admin', 77, 78, 3, '/backend/users/users/admin', 'overAllManager'),
(37, 3, 'Users.Users.Adminka', 75, 76, 3, '/backend/users/users/adminka', 'overAllManager'),
(38, 3, 'Users.Users.Confirm', 73, 74, 3, '/backend/users/users/confirm', 'overAllManager'),
(39, 3, 'Users.Users.Create', 71, 72, 3, '/backend/users/users/create', 'overAllManager'),
(40, 3, 'Users.Users.Deactivate', 69, 70, 3, '/backend/users/users/deactivate', 'overAllManager'),
(41, 3, 'Users.Users.Delete', 67, 68, 3, '/backend/users/users/delete', 'overAllManager'),
(42, 3, 'Users.Users.Index', 65, 66, 3, '/backend/users/users/index', 'overAllManager'),
(43, 43, 'Guest', 1, 4, 1, '', 'Guest'),
(44, 43, 'Users.Users.Login', 2, 3, 2, '/backend/users/users/login', 'Guest'),
(45, 3, 'new text', 82, 83, 4, '', ''),
(46, 3, 'fqwfqwf', 84, 85, 4, '', ''),
(47, 3, 'testtext', 86, 87, 4, '', ''),
(48, 3, 'roletest_renamed', 2, 3, 2, '', 'overAllManager'),
(49, 3, 'Users1', 64, 89, 2, '', 'overAllManager');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
