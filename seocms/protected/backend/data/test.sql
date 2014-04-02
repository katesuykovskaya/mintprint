-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 15 2013 г., 16:59
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
-- Структура таблицы `AuthAssignment`
--

CREATE TABLE IF NOT EXISTS `AuthAssignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `AuthAssignment`
--

INSERT INTO `AuthAssignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('admin', '1', NULL, 'N;'),
('Authenticated', '2', NULL, 'N;'),
('overAllManager', '1', NULL, 'N;'),
('overAllManager', '3', NULL, 'N;');

-- --------------------------------------------------------

--
-- Структура таблицы `AuthItem`
--

CREATE TABLE IF NOT EXISTS `AuthItem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `AuthItem`
--

INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('admin', 2, NULL, NULL, 'N;'),
('Authenticated', 2, NULL, NULL, 'N;'),
('Backendmenu.Default.Create', 0, NULL, NULL, 'N;'),
('Backendmenu.Default.CreateRoot', 0, NULL, NULL, 'N;'),
('Backendmenu.Default.FetchTree', 0, NULL, NULL, 'N;'),
('Backendmenu.Default.Index', 0, NULL, NULL, 'N;'),
('Backendmenu.Default.MenuGen', 0, NULL, NULL, 'N;'),
('Backendmenu.Default.MoveCopy', 0, NULL, NULL, 'N;'),
('Backendmenu.Default.Remove', 0, NULL, NULL, 'N;'),
('Backendmenu.Default.Rename', 0, NULL, NULL, 'N;'),
('Backendmenu.Default.ReturnForm', 0, NULL, NULL, 'N;'),
('Backendmenu.Default.ReturnView', 0, NULL, NULL, 'N;'),
('Backendmenu.Default.Update', 0, NULL, NULL, 'N;'),
('backendMenuAdmin', 2, 'Админка меню бекенда', NULL, 'N;'),
('Feedback.Feedback.Admin', 0, NULL, NULL, 'N;'),
('Feedback.Feedback.Create', 0, NULL, NULL, 'N;'),
('Feedback.Feedback.Delete', 0, NULL, NULL, 'N;'),
('Feedback.Feedback.Index', 0, NULL, NULL, 'N;'),
('Feedback.Feedback.MailList', 0, NULL, NULL, 'N;'),
('Feedback.Feedback.Update', 0, NULL, NULL, 'N;'),
('Feedback.Feedback.View', 0, NULL, NULL, 'N;'),
('feedbackAdmin', 2, 'Администрирование почты', NULL, 'N;'),
('Guest', 2, 'Незалогиненный пользователь', NULL, 'N;'),
('multilangAdmin', 2, 'Администрирование мультиязычности', NULL, 'N;'),
('Multilanguage.Message.Admin', 0, NULL, NULL, 'N;'),
('Multilanguage.Message.Create', 0, NULL, NULL, 'N;'),
('Multilanguage.Message.Delete', 0, NULL, NULL, 'N;'),
('Multilanguage.Message.Index', 0, NULL, NULL, 'N;'),
('Multilanguage.Message.Update', 0, NULL, NULL, 'N;'),
('Multilanguage.Message.View', 0, NULL, NULL, 'N;'),
('Multilanguage.Source.Admin', 0, NULL, NULL, 'N;'),
('Multilanguage.Source.Create', 0, NULL, NULL, 'N;'),
('Multilanguage.Source.Delete', 0, NULL, NULL, 'N;'),
('Multilanguage.Source.Index', 0, NULL, NULL, 'N;'),
('Multilanguage.Source.Relational', 0, NULL, NULL, 'N;'),
('Multilanguage.Source.Update', 0, NULL, NULL, 'N;'),
('Multilanguage.Source.View', 0, NULL, NULL, 'N;'),
('overAllManager', 2, 'Менеджер проекта', NULL, 'N;'),
('Pages.Pages.Admin', 0, NULL, NULL, 'N;'),
('Pages.Pages.Create', 0, NULL, NULL, 'N;'),
('Pages.Pages.Delete', 0, NULL, NULL, 'N;'),
('Pages.Pages.FetchTree', 0, NULL, NULL, 'N;'),
('Pages.Pages.Grid', 0, NULL, NULL, 'N;'),
('Pages.Pages.GridSave', 0, NULL, NULL, 'N;'),
('Pages.Pages.Index', 0, NULL, NULL, 'N;'),
('Pages.Pages.PageTree', 0, NULL, NULL, 'N;'),
('Pages.Pages.Update', 0, NULL, NULL, 'N;'),
('Pages.Pages.View', 0, NULL, NULL, 'N;'),
('pagesAdmin', 2, 'Администрирование страниц', NULL, 'N;'),
('Users.Users.Admin', 0, NULL, NULL, 'N;'),
('Users.Users.Adminka', 0, NULL, NULL, 'N;'),
('Users.Users.Confirm', 0, NULL, NULL, 'N;'),
('Users.Users.Create', 0, NULL, NULL, 'N;'),
('Users.Users.Deactivate', 0, NULL, NULL, 'N;'),
('Users.Users.Delete', 0, NULL, NULL, 'N;'),
('Users.Users.Index', 0, NULL, NULL, 'N;'),
('Users.Users.Login', 0, NULL, NULL, 'N;'),
('Users.Users.Logout', 0, NULL, NULL, 'N;'),
('Users.Users.Permissions', 0, NULL, NULL, 'N;'),
('Users.Users.RenewPassword', 0, NULL, NULL, 'N;'),
('Users.Users.Update', 0, NULL, NULL, 'N;'),
('Users.Users.View', 0, NULL, NULL, 'N;'),
('Users.Users.VkLogin', 0, NULL, NULL, 'N;'),
('usersAdmin', 2, 'Администрирование пользователей', NULL, 'N;');

-- --------------------------------------------------------

--
-- Структура таблицы `AuthItemChild`
--

CREATE TABLE IF NOT EXISTS `AuthItemChild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `AuthItemChild`
--

INSERT INTO `AuthItemChild` (`parent`, `child`) VALUES
('backendMenuAdmin', 'Authenticated'),
('overAllManager', 'Authenticated'),
('pagesAdmin', 'Authenticated'),
('backendMenuAdmin', 'Backendmenu.Default.Create'),
('backendMenuAdmin', 'Backendmenu.Default.CreateRoot'),
('backendMenuAdmin', 'Backendmenu.Default.FetchTree'),
('backendMenuAdmin', 'Backendmenu.Default.Index'),
('backendMenuAdmin', 'Backendmenu.Default.MenuGen'),
('backendMenuAdmin', 'Backendmenu.Default.MoveCopy'),
('backendMenuAdmin', 'Backendmenu.Default.Remove'),
('backendMenuAdmin', 'Backendmenu.Default.Rename'),
('backendMenuAdmin', 'Backendmenu.Default.ReturnForm'),
('backendMenuAdmin', 'Backendmenu.Default.ReturnView'),
('backendMenuAdmin', 'Backendmenu.Default.Update'),
('feedbackAdmin', 'Feedback.Feedback.Admin'),
('feedbackAdmin', 'Feedback.Feedback.Create'),
('feedbackAdmin', 'Feedback.Feedback.Delete'),
('feedbackAdmin', 'Feedback.Feedback.Index'),
('feedbackAdmin', 'Feedback.Feedback.MailList'),
('feedbackAdmin', 'Feedback.Feedback.Update'),
('feedbackAdmin', 'Feedback.Feedback.View'),
('backendMenuAdmin', 'feedbackAdmin'),
('overAllManager', 'feedbackAdmin'),
('backendMenuAdmin', 'Guest'),
('pagesAdmin', 'Guest'),
('overAllManager', 'multilangAdmin'),
('multilangAdmin', 'Multilanguage.Message.Admin'),
('multilangAdmin', 'Multilanguage.Message.Create'),
('multilangAdmin', 'Multilanguage.Message.Delete'),
('multilangAdmin', 'Multilanguage.Message.Index'),
('multilangAdmin', 'Multilanguage.Message.Update'),
('multilangAdmin', 'Multilanguage.Message.View'),
('multilangAdmin', 'Multilanguage.Source.Admin'),
('multilangAdmin', 'Multilanguage.Source.Create'),
('multilangAdmin', 'Multilanguage.Source.Delete'),
('multilangAdmin', 'Multilanguage.Source.Index'),
('multilangAdmin', 'Multilanguage.Source.Relational'),
('multilangAdmin', 'Multilanguage.Source.Update'),
('multilangAdmin', 'Multilanguage.Source.View'),
('pagesAdmin', 'Pages.Pages.Admin'),
('pagesAdmin', 'Pages.Pages.Create'),
('pagesAdmin', 'Pages.Pages.Delete'),
('pagesAdmin', 'Pages.Pages.FetchTree'),
('pagesAdmin', 'Pages.Pages.Grid'),
('pagesAdmin', 'Pages.Pages.GridSave'),
('pagesAdmin', 'Pages.Pages.Index'),
('pagesAdmin', 'Pages.Pages.PageTree'),
('pagesAdmin', 'Pages.Pages.Update'),
('pagesAdmin', 'Pages.Pages.View'),
('overAllManager', 'pagesAdmin'),
('usersAdmin', 'Users.Users.Admin'),
('usersAdmin', 'Users.Users.Adminka'),
('usersAdmin', 'Users.Users.Confirm'),
('usersAdmin', 'Users.Users.Create'),
('usersAdmin', 'Users.Users.Deactivate'),
('usersAdmin', 'Users.Users.Delete'),
('usersAdmin', 'Users.Users.Index'),
('Guest', 'Users.Users.Login'),
('Authenticated', 'Users.Users.Logout'),
('overAllManager', 'usersAdmin');

-- --------------------------------------------------------

--
-- Структура таблицы `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` varchar(64) NOT NULL,
  `sender_name` varchar(128) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `Message`
--

CREATE TABLE IF NOT EXISTS `Message` (
  `translation_id` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `language` varchar(16) NOT NULL DEFAULT '',
  `translation` text,
  UNIQUE KEY `translation_id` (`translation_id`),
  UNIQUE KEY `id` (`id`,`language`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

--
-- Дамп данных таблицы `Message`
--

INSERT INTO `Message` (`translation_id`, `id`, `language`, `translation`) VALUES
(7, 6, 'ru', 'Опции'),
(8, 6, 'en', 'Options'),
(9, 6, 'uk', 'Перевод'),
(10, 7, 'ru', 'Перевод'),
(11, 7, 'en', 'Translation'),
(12, 7, 'uk', 'Переклад'),
(13, 8, 'ru', 'Действия'),
(14, 8, 'en', 'Actions'),
(15, 8, 'uk', 'Перевод'),
(16, 9, 'ru', 'Операции'),
(17, 9, 'en', 'Actions'),
(18, 9, 'uk', 'Перевод'),
(19, 10, 'ru', 'Администрирование почты'),
(20, 10, 'en', 'Feedback admin'),
(21, 10, 'uk', 'Налаштування пошти'),
(22, 11, 'ru', 'Русский'),
(23, 11, 'en', 'Russian'),
(24, 11, 'uk', 'Росийська'),
(25, 12, 'ru', 'Блин'),
(26, 12, 'en', 'www'),
(27, 12, 'uk', 'regergesr'),
(28, 13, 'ru', 'Настройки почты'),
(29, 13, 'en', 'Feedback admin'),
(30, 13, 'uk', 'Налаштування пошти'),
(31, 14, 'ru', 'Мультиязычность'),
(32, 14, 'en', 'Multilanguage admin'),
(33, 14, 'uk', 'Багатомовнисть'),
(34, 15, 'ru', 'Страницы сайта'),
(35, 15, 'en', 'Pages admin'),
(36, 15, 'uk', 'Сторинкы сайту'),
(37, 16, 'ru', 'Пользователи'),
(38, 16, 'en', 'Users'),
(39, 16, 'uk', 'Користувачи');

-- --------------------------------------------------------

--
-- Структура таблицы `oppa_table`
--

CREATE TABLE IF NOT EXISTS `oppa_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text,
  `yes_no` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `Rights`
--

CREATE TABLE IF NOT EXISTS `Rights` (
  `itemname` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`itemname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `seotm_users`
--

CREATE TABLE IF NOT EXISTS `seotm_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(64) NOT NULL,
  `pass` varchar(60) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `email` varchar(64) NOT NULL,
  `reg_date` datetime NOT NULL,
  `login_numbs` int(11) NOT NULL DEFAULT '0',
  `last_login` datetime NOT NULL,
  `last_action_time` datetime NOT NULL,
  `token` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `seotm_users`
--

INSERT INTO `seotm_users` (`user_id`, `login`, `pass`, `active`, `email`, `reg_date`, `login_numbs`, `last_login`, `last_action_time`, `token`) VALUES
(1, 'admin', '$2a$12$rA2f1M.5WiFhLtSzDgQ6GuqbSD8nw7S3iuJS/hPnJfg.qESXX174.', 1, 'info@root.zt.ua', '0000-00-00 00:00:00', 37, '2013-04-15 13:08:33', '2013-04-15 13:08:33', '$2a$12$rA2f1M.5WiFhLtSzDgQ6GuqbSD8nw7S3iuJS/hPnJfg.qESXX174.'),
(3, 'root', '$2a$12$LFDGPgXSceDlyduCQG0cgej6h0C7ZBfZ1HGZgW46cKuRo8VvLwb2.', 1, 'info@root.zt.ua', '2013-03-25 12:35:02', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '$2a$12$hVQTUeqXdGHBjlkH0iTm8OEvUEgHG7jc4KDxdrFmwROBy0I5OkZri');

-- --------------------------------------------------------

--
-- Структура таблицы `SourceMessage`
--

CREATE TABLE IF NOT EXISTS `SourceMessage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(32) DEFAULT NULL,
  `message` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Дамп данных таблицы `SourceMessage`
--

INSERT INTO `SourceMessage` (`id`, `category`, `message`) VALUES
(6, 'main', 'Options'),
(7, 'main', 'Перевод'),
(8, 'permissions', 'Actions'),
(9, 'permissions', 'Operations'),
(10, 'permissions', 'Feedback.Feedback.Admin'),
(11, 'language', 'Русский'),
(12, 'main', 'Блин'),
(13, 'backMenu', 'module Feedback'),
(14, 'backMenu', 'module Multilanguage'),
(15, 'backMenu', 'module Pages'),
(16, 'backMenu', 'module Users');

-- --------------------------------------------------------

--
-- Структура таблицы `static_pages`
--

CREATE TABLE IF NOT EXISTS `static_pages` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `published` tinyint(4) NOT NULL DEFAULT '0',
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `static_pages`
--

INSERT INTO `static_pages` (`page_id`, `published`, `lft`, `rgt`, `level`) VALUES
(1, 0, 1, 2, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_migration`
--

CREATE TABLE IF NOT EXISTS `tbl_migration` (
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tbl_migration`
--

INSERT INTO `tbl_migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1365501619),
('m130409_120302_oppa_table', 1365508999);

-- --------------------------------------------------------

--
-- Структура таблицы `translate_pages`
--

CREATE TABLE IF NOT EXISTS `translate_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `t_title` varchar(512) NOT NULL,
  `t_lang` char(2) NOT NULL,
  `t_desc` varchar(512) NOT NULL,
  `t_h1` varchar(255) NOT NULL,
  `t_content` text NOT NULL,
  `t_translit` varchar(255) NOT NULL,
  `t_mtitle` varchar(512) NOT NULL,
  `t_mdesc` varchar(1024) NOT NULL,
  `t_mkeywords` varchar(1024) NOT NULL,
  `published` tinyint(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `translate_pages`
--

INSERT INTO `translate_pages` (`id`, `page_id`, `t_title`, `t_lang`, `t_desc`, `t_h1`, `t_content`, `t_translit`, `t_mtitle`, `t_mdesc`, `t_mkeywords`, `published`) VALUES
(1, 1, 'Главный раздел', 'ru', 'описание', 'заголовок', '<p>содержимое</p>', 'glavnyi-razdel', '', '', '', 1),
(2, 1, '', 'en', '', '', '', '', '', '', '', 1),
(3, 1, '', 'uk', '', '', '', '', '', '', '', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `user_menu`
--

CREATE TABLE IF NOT EXISTS `user_menu` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `root` int(11) NOT NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=78 ;

--
-- Дамп данных таблицы `user_menu`
--

INSERT INTO `user_menu` (`item_id`, `user_id`, `name`, `root`, `lft`, `rgt`, `level`, `url`) VALUES
(1, 3, 'module Feedback', 1, 1, 18, 1, '/feedback'),
(2, 3, 'controller Feedback', 1, 2, 17, 2, '/feedback/feedback'),
(3, 3, 'action Admin', 1, 3, 4, 3, '/feedback/feedback/admin'),
(4, 3, 'action Create', 1, 5, 6, 3, '/feedback/feedback/create'),
(5, 3, 'action Delete', 1, 7, 8, 3, '/feedback/feedback/delete'),
(6, 3, 'action Index', 1, 9, 10, 3, '/feedback/feedback/index'),
(7, 3, 'action MailList', 1, 11, 12, 3, '/feedback/feedback/maillist'),
(8, 3, 'action Update', 1, 13, 14, 3, '/feedback/feedback/update'),
(9, 3, 'action View', 1, 15, 16, 3, '/feedback/feedback/view'),
(10, 3, 'module Pages', 10, 1, 22, 1, '/pages'),
(11, 3, 'controller Pages', 10, 2, 21, 2, '/pages/pages'),
(12, 3, 'action Admin', 10, 3, 4, 3, '/pages/pages/admin'),
(13, 3, 'action Create', 10, 5, 6, 3, '/pages/pages/create'),
(14, 3, 'action Delete', 10, 7, 8, 3, '/pages/pages/delete'),
(15, 3, 'action FetchTree', 10, 9, 10, 3, '/pages/pages/fetchtree'),
(16, 3, 'action Grid', 10, 11, 12, 3, '/pages/pages/grid'),
(17, 3, 'action GridSave', 10, 13, 14, 3, '/pages/pages/gridsave'),
(18, 3, 'action Index', 10, 15, 16, 3, '/pages/pages/index'),
(19, 3, 'action PageTree', 10, 17, 18, 3, '/pages/pages/pagetree'),
(20, 3, 'action Update', 10, 19, 20, 3, '/pages/pages/update'),
(21, 3, 'module Users', 21, 1, 18, 1, '/users'),
(22, 3, 'controller Users', 21, 2, 17, 2, '/users/users'),
(23, 3, 'action Admin', 21, 3, 4, 3, '/users/users/admin'),
(24, 3, 'action Adminka', 21, 5, 6, 3, '/users/users/adminka'),
(25, 3, 'action Confirm', 21, 7, 8, 3, '/users/users/confirm'),
(26, 3, 'action Create', 21, 9, 10, 3, '/users/users/create'),
(27, 3, 'action Deactivate', 21, 11, 12, 3, '/users/users/deactivate'),
(28, 3, 'action Delete', 21, 13, 14, 3, '/users/users/delete'),
(29, 3, 'action Index', 21, 15, 16, 3, '/users/users/index'),
(30, 1, 'module Feedback', 30, 1, 18, 1, '/feedback'),
(31, 1, 'controller Feedback', 30, 2, 17, 2, '/feedback/feedback'),
(32, 1, 'action Admin', 30, 3, 4, 3, '/feedback/feedback/admin'),
(33, 1, 'action Create', 30, 5, 6, 3, '/feedback/feedback/create'),
(34, 1, 'action Delete', 30, 7, 8, 3, '/feedback/feedback/delete'),
(35, 1, 'action Index', 30, 9, 10, 3, '/feedback/feedback/index'),
(36, 1, 'action MailList', 30, 11, 12, 3, '/feedback/feedback/maillist'),
(37, 1, 'action Update', 30, 13, 14, 3, '/feedback/feedback/update'),
(38, 1, 'action View', 30, 15, 16, 3, '/feedback/feedback/view'),
(39, 1, 'module Pages', 39, 1, 24, 1, '/pages'),
(40, 1, 'controller Pages', 39, 2, 23, 2, '/pages/pages'),
(41, 1, 'action Admin', 39, 3, 4, 3, '/pages/pages/admin'),
(42, 1, 'action Create', 39, 5, 6, 3, '/pages/pages/create'),
(43, 1, 'action Delete', 39, 7, 8, 3, '/pages/pages/delete'),
(44, 1, 'action FetchTree', 39, 9, 10, 3, '/pages/pages/fetchtree'),
(45, 1, 'action Grid', 39, 11, 12, 3, '/pages/pages/grid'),
(46, 1, 'action GridSave', 39, 13, 14, 3, '/pages/pages/gridsave'),
(47, 1, 'action Index', 39, 15, 16, 3, '/pages/pages/index'),
(48, 1, 'action PageTree', 39, 17, 18, 3, '/pages/pages/pagetree'),
(49, 1, 'action Update', 39, 19, 20, 3, '/pages/pages/update'),
(50, 1, 'module Users', 50, 1, 22, 1, '/users'),
(51, 1, 'controller Users', 50, 2, 21, 2, '/users/users'),
(52, 1, 'action Admin', 50, 3, 4, 3, '/users/users/admin'),
(53, 1, 'action Adminka', 50, 5, 6, 3, '/users/users/adminka'),
(54, 1, 'action Confirm', 50, 7, 8, 3, '/users/users/confirm'),
(55, 1, 'action Create', 50, 9, 10, 3, '/users/users/create'),
(56, 1, 'action Deactivate', 50, 11, 12, 3, '/users/users/deactivate'),
(57, 1, 'action Delete', 50, 13, 14, 3, '/users/users/delete'),
(58, 1, 'action Index', 50, 15, 16, 3, '/users/users/index'),
(59, 1, 'module Multilanguage', 59, 1, 32, 1, '/multilanguage'),
(60, 1, 'controller Source', 59, 2, 17, 2, '/multilanguage/source'),
(61, 1, 'action Admin', 59, 3, 4, 3, '/multilanguage/source/admin'),
(62, 1, 'action Create', 59, 5, 6, 3, '/multilanguage/source/create'),
(63, 1, 'action Delete', 59, 7, 8, 3, '/multilanguage/source/delete'),
(64, 1, 'action Index', 59, 9, 10, 3, '/multilanguage/source/index'),
(65, 1, 'action Relational', 59, 11, 12, 3, '/multilanguage/source/relational'),
(66, 1, 'action Update', 59, 13, 14, 3, '/multilanguage/source/update'),
(67, 1, 'action View', 59, 15, 16, 3, '/multilanguage/source/view'),
(68, 1, 'action Logout', 50, 17, 18, 3, '/users/users/logout'),
(69, 1, 'action Login', 50, 19, 20, 3, '/users/users/login'),
(70, 1, 'action View', 39, 21, 22, 3, '/pages/pages/view'),
(71, 1, 'controller Message', 59, 18, 31, 2, '/multilanguage/message'),
(72, 1, 'action Admin', 59, 19, 20, 3, '/multilanguage/message/admin'),
(73, 1, 'action Create', 59, 21, 22, 3, '/multilanguage/message/create'),
(74, 1, 'action Delete', 59, 23, 24, 3, '/multilanguage/message/delete'),
(75, 1, 'action Index', 59, 25, 26, 3, '/multilanguage/message/index'),
(76, 1, 'action Update', 59, 27, 28, 3, '/multilanguage/message/update'),
(77, 1, 'action View', 59, 29, 30, 3, '/multilanguage/message/view');

-- --------------------------------------------------------

--
-- Структура таблицы `YiiSession`
--

CREATE TABLE IF NOT EXISTS `YiiSession` (
  `id` char(32) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` longblob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `YiiSession`
--

INSERT INTO `YiiSession` (`id`, `expire`, `data`) VALUES
('1sc0kglelt49c5uuo712le1e32', 1365783240, ''),
('5j98u1r0u91jtrk7dsfn44hdq3', 1365578041, ''),
('6lqgiavqti4pro2o9nhtal7j45', 1366021954, 0x34353234663533653930653463353931383732343563396464353163646463325f5f69647c733a313a2231223b34353234663533653930653463353931383732343563396464353163646463325f5f6e616d657c733a353a2261646d696e223b34353234663533653930653463353931383732343563396464353163646463326e616d657c733a353a2261646d696e223b34353234663533653930653463353931383732343563396464353163646463327573657269647c733a313a2231223b34353234663533653930653463353931383732343563396464353163646463326c6173744c6f67696e7c733a31393a22323031332d30342d31352031333a30383a3333223b34353234663533653930653463353931383732343563396464353163646463325f5f7374617465737c613a333a7b733a343a226e616d65223b623a313b733a363a22757365726964223b623a313b733a393a226c6173744c6f67696e223b623a313b7d34353234663533653930653463353931383732343563396464353163646463325269676874735f69735375706572757365727c623a313b34353234663533653930653463353931383732343563396464353163646463325f5f74696d656f75747c693a313336363032373731333b),
('773964haafk48e69a4jer9f6g6', 1365609723, ''),
('7eb4ek5tad4e2rieuocfb3bro1', 1365578041, 0x34353234663533653930653463353931383732343563396464353163646463325f5f72657475726e55726c7c733a31323a222f66617669636f6e2e69636f223b),
('846lgf2n6jug0sbnsumnkdgfi0', 1365609720, 0x34353234663533653930653463353931383732343563396464353163646463325f5f72657475726e55726c7c733a31323a222f66617669636f6e2e69636f223b),
('ag2iaa3k28sbrpf32l3d7n3ab0', 1365581814, 0x34353234663533653930653463353931383732343563396464353163646463325f5f72657475726e55726c7c733a31323a222f66617669636f6e2e69636f223b),
('dnfb9u6rsdr7dog43mu82dvj82', 1365783240, 0x34353234663533653930653463353931383732343563396464353163646463325f5f72657475726e55726c7c733a31323a222f66617669636f6e2e69636f223b),
('dr7a091rj0o5h59iaavm1qtqo6', 1365763291, ''),
('eqvr4r3chaa661o34mviaorv94', 1365664413, 0x34353234663533653930653463353931383732343563396464353163646463325f5f72657475726e55726c7c733a31323a222f66617669636f6e2e69636f223b),
('gdhqdg35k7k2su3qe4pecrq2r3', 1365779542, 0x34353234663533653930653463353931383732343563396464353163646463325f5f72657475726e55726c7c733a31323a222f66617669636f6e2e69636f223b),
('gqhnlffrigavcn3bdscip3msn1', 1366010169, ''),
('j58jun285r4h73qua3m0atbnb0', 1366020240, 0x38363866363637366232386430333938306637613739633031626437626132385f5f72657475726e55726c7c733a32313a222f6261636b656e642f736974652f6d696772617465223b38363866363637366232386430333938306637613739633031626437626132385f5f69647c733a313a2231223b38363866363637366232386430333938306637613739633031626437626132385f5f6e616d657c733a353a2261646d696e223b38363866363637366232386430333938306637613739633031626437626132386e616d657c733a353a2261646d696e223b38363866363637366232386430333938306637613739633031626437626132387573657269647c733a313a2231223b38363866363637366232386430333938306637613739633031626437626132386c6173744c6f67696e7c733a31393a22323031332d30342d31352031323a33393a3538223b38363866363637366232386430333938306637613739633031626437626132385f5f7374617465737c613a333a7b733a343a226e616d65223b623a313b733a363a22757365726964223b623a313b733a393a226c6173744c6f67696e223b623a313b7d38363866363637366232386430333938306637613739633031626437626132385269676874735f69735375706572757365727c623a313b38363866363637366232386430333938306637613739633031626437626132385f5f74696d656f75747c693a313336363032353939393b),
('k4gs7ogf705clt6eb18ckrrl44', 1366021955, 0x34353234663533653930653463353931383732343563396464353163646463325f5f72657475726e55726c7c733a31323a222f66617669636f6e2e69636f223b),
('n32v3tbe55scltu7kmo3le2jn3', 1366017884, 0x34353234663533653930653463353931383732343563396464353163646463325f5f72657475726e55726c7c733a31323a222f66617669636f6e2e69636f223b),
('oi5vt67qn5g5oc19ms6rm3n193', 1366010167, 0x34353234663533653930653463353931383732343563396464353163646463325f5f72657475726e55726c7c733a31323a222f66617669636f6e2e69636f223b),
('outlhjdv4qrfrs0t5d14v34n27', 1365779542, ''),
('pub2g4fk1jg505seo1cvagude7', 1366017884, ''),
('q3uvdmu2eqsk62hgqbs0bm5ta1', 1365581815, ''),
('uipeeoeni6d2m60io4iu819lc0', 1366021956, ''),
('uoujc2116hp3f0fltc558q4sg7', 1365664421, ''),
('vn4jfkka8aivife2o0ierq8oi5', 1365763289, 0x34353234663533653930653463353931383732343563396464353163646463325f5f72657475726e55726c7c733a31323a222f66617669636f6e2e69636f223b);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `AuthAssignment`
--
ALTER TABLE `AuthAssignment`
  ADD CONSTRAINT `AuthAssignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `AuthItemChild`
--
ALTER TABLE `AuthItemChild`
  ADD CONSTRAINT `AuthItemChild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `AuthItemChild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `Rights`
--
ALTER TABLE `Rights`
  ADD CONSTRAINT `Rights_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
