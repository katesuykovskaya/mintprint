-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июн 17 2013 г., 18:20
-- Версия сервера: 5.5.31
-- Версия PHP: 5.4.4-14+deb7u2

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
  PRIMARY KEY (`itemname`,`userid`),
  UNIQUE KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `AuthAssignment`
--

INSERT INTO `AuthAssignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('admin', '1', NULL, 'N;'),
('Authenticated', '2', NULL, 'N;'),
('overAllManager', '3', NULL, 'N;'),
('overAllManager', '4', NULL, 'N;'),
('overAllManager', '5', NULL, 'N;');

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
('Feedback.Feedback.Admin', 0, NULL, NULL, 'N;'),
('Feedback.Feedback.Create', 0, NULL, NULL, 'N;'),
('Feedback.Feedback.Delete', 0, NULL, NULL, 'N;'),
('Feedback.Feedback.Index', 0, NULL, NULL, 'N;'),
('Feedback.Feedback.MailList', 0, NULL, NULL, 'N;'),
('Feedback.Feedback.Update', 0, NULL, NULL, 'N;'),
('Feedback.Feedback.View', 0, NULL, NULL, 'N;'),
('feedbackAdmin', 2, 'Администрирование почты', NULL, 'N;'),
('Guest', 2, 'Незалогиненный пользователь', NULL, 'N;'),
('menuAdmin', 2, 'Администратор бекенд меню', NULL, 'N;'),
('Menugen.Default.AjaxUserItems', 0, NULL, NULL, 'N;'),
('Menugen.Default.Create', 0, NULL, NULL, 'N;'),
('Menugen.Default.FetchTree', 0, NULL, NULL, 'N;'),
('Menugen.Default.Footermenu', 0, NULL, NULL, 'N;'),
('Menugen.Default.Index', 0, NULL, NULL, 'N;'),
('Menugen.Default.Mainmenu', 0, NULL, NULL, 'N;'),
('Menugen.Default.MenuGen', 0, NULL, NULL, 'N;'),
('Menugen.Default.MoveCopy', 0, NULL, NULL, 'N;'),
('Menugen.Default.PreviewMenu', 0, NULL, NULL, 'N;'),
('Menugen.Default.Remove', 0, NULL, NULL, 'N;'),
('Menugen.Default.Rename', 0, NULL, NULL, 'N;'),
('Menugen.Default.ReturnForm', 0, NULL, NULL, 'N;'),
('Menugen.Default.ReturnView', 0, NULL, NULL, 'N;'),
('Menugen.Default.Sidemenu', 0, NULL, NULL, 'N;'),
('Menugen.Default.TranslateActions', 0, NULL, NULL, 'N;'),
('Menugen.Default.Update', 0, NULL, NULL, 'N;'),
('Menugen.Default.Usermenu', 0, NULL, NULL, 'N;'),
('Menugen.Sitemenu.Ajax', 0, NULL, NULL, 'N;'),
('Menugen.Sitemenu.ChangeType', 0, NULL, NULL, 'N;'),
('Menugen.Sitemenu.Create', 0, NULL, NULL, 'N;'),
('Menugen.Sitemenu.Createitem', 0, NULL, NULL, 'N;'),
('Menugen.Sitemenu.Createmenu', 0, NULL, NULL, 'N;'),
('Menugen.Sitemenu.Dropdown', 0, NULL, NULL, 'N;'),
('Menugen.Sitemenu.FetchTree', 0, NULL, NULL, 'N;'),
('Menugen.Sitemenu.Footermenu', 0, NULL, NULL, 'N;'),
('Menugen.Sitemenu.GetTranslit', 0, NULL, NULL, 'N;'),
('Menugen.Sitemenu.Index', 0, NULL, NULL, 'N;'),
('Menugen.Sitemenu.Mainmenu', 0, NULL, NULL, 'N;'),
('Menugen.Sitemenu.MoveCopy', 0, NULL, NULL, 'N;'),
('Menugen.Sitemenu.Remove', 0, NULL, NULL, 'N;'),
('Menugen.Sitemenu.Rename', 0, NULL, NULL, 'N;'),
('Menugen.Sitemenu.ReturnForm', 0, NULL, NULL, 'N;'),
('Menugen.Sitemenu.ReturnView', 0, NULL, NULL, 'N;'),
('Menugen.Sitemenu.Sidemenu', 0, NULL, NULL, 'N;'),
('Menugen.Sitemenu.Test', 0, NULL, NULL, 'N;'),
('Menugen.Sitemenu.Toglemenu', 0, NULL, NULL, 'N;'),
('Menugen.Sitemenu.TranslateActions', 0, NULL, NULL, 'N;'),
('Menugen.Sitemenu.Update', 0, NULL, NULL, 'N;'),
('Menugen.Sitemenu.Updategrid', 0, NULL, NULL, 'N;'),
('Menugen.Sitemenu.Updatemenu', 0, NULL, NULL, 'N;'),
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
('overAllManager', 'Authenticated'),
('pagesAdmin', 'Authenticated'),
('feedbackAdmin', 'Feedback.Feedback.Admin'),
('feedbackAdmin', 'Feedback.Feedback.Create'),
('feedbackAdmin', 'Feedback.Feedback.Delete'),
('feedbackAdmin', 'Feedback.Feedback.Index'),
('feedbackAdmin', 'Feedback.Feedback.MailList'),
('feedbackAdmin', 'Feedback.Feedback.Update'),
('feedbackAdmin', 'Feedback.Feedback.View'),
('overAllManager', 'feedbackAdmin'),
('overAllManager', 'Guest'),
('pagesAdmin', 'Guest'),
('overAllManager', 'menuAdmin'),
('menuAdmin', 'Menugen.Default.AjaxUserItems'),
('menuAdmin', 'Menugen.Default.Create'),
('menuAdmin', 'Menugen.Default.FetchTree'),
('menuAdmin', 'Menugen.Default.Footermenu'),
('menuAdmin', 'Menugen.Default.Index'),
('menuAdmin', 'Menugen.Default.Mainmenu'),
('menuAdmin', 'Menugen.Default.MenuGen'),
('menuAdmin', 'Menugen.Default.MoveCopy'),
('menuAdmin', 'Menugen.Default.PreviewMenu'),
('menuAdmin', 'Menugen.Default.Remove'),
('menuAdmin', 'Menugen.Default.Rename'),
('menuAdmin', 'Menugen.Default.ReturnForm'),
('menuAdmin', 'Menugen.Default.ReturnView'),
('menuAdmin', 'Menugen.Default.Sidemenu'),
('menuAdmin', 'Menugen.Default.TranslateActions'),
('menuAdmin', 'Menugen.Default.Update'),
('menuAdmin', 'Menugen.Default.Usermenu'),
('menuAdmin', 'Menugen.Sitemenu.Ajax'),
('menuAdmin', 'Menugen.Sitemenu.ChangeType'),
('menuAdmin', 'Menugen.Sitemenu.Create'),
('menuAdmin', 'Menugen.Sitemenu.Createitem'),
('menuAdmin', 'Menugen.Sitemenu.Createmenu'),
('menuAdmin', 'Menugen.Sitemenu.Dropdown'),
('menuAdmin', 'Menugen.Sitemenu.FetchTree'),
('menuAdmin', 'Menugen.Sitemenu.Footermenu'),
('menuAdmin', 'Menugen.Sitemenu.GetTranslit'),
('menuAdmin', 'Menugen.Sitemenu.Index'),
('menuAdmin', 'Menugen.Sitemenu.Mainmenu'),
('menuAdmin', 'Menugen.Sitemenu.MoveCopy'),
('menuAdmin', 'Menugen.Sitemenu.Remove'),
('menuAdmin', 'Menugen.Sitemenu.Rename'),
('menuAdmin', 'Menugen.Sitemenu.ReturnForm'),
('menuAdmin', 'Menugen.Sitemenu.ReturnView'),
('menuAdmin', 'Menugen.Sitemenu.Sidemenu'),
('menuAdmin', 'Menugen.Sitemenu.Test'),
('menuAdmin', 'Menugen.Sitemenu.Toglemenu'),
('menuAdmin', 'Menugen.Sitemenu.TranslateActions'),
('menuAdmin', 'Menugen.Sitemenu.Update'),
('menuAdmin', 'Menugen.Sitemenu.Updategrid'),
('menuAdmin', 'Menugen.Sitemenu.Updatemenu'),
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=97 ;

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
(39, 16, 'uk', 'Користувачи'),
(40, 17, 'ru', 'Почта create'),
(41, 17, 'en', 'Feedback Create'),
(42, 17, 'uk', 'Почта криейт (укр)'),
(43, 20, 'ru', 'Перевод'),
(44, 20, 'en', 'Перевод'),
(45, 20, 'uk', 'Перевод'),
(46, 21, 'ru', 'Перевод'),
(47, 21, 'en', 'Перевод'),
(48, 21, 'uk', 'Перевод'),
(49, 22, 'ru', 'Логаут'),
(50, 22, 'en', 'Log_out'),
(51, 22, 'uk', 'Logout_ua'),
(52, 23, 'ru', 'Перевод'),
(53, 23, 'en', 'Перевод1'),
(54, 23, 'uk', 'Перевод'),
(73, 30, 'ru', 'Генератор меню'),
(74, 30, 'en', 'Menu generator'),
(75, 30, 'uk', 'UA menu gen'),
(76, 31, 'ru', 'Администрирование пользователей'),
(77, 31, 'en', 'Users admin'),
(78, 31, 'uk', 'Users admin _ ua'),
(79, 32, 'ru', 'Редактирование меню'),
(80, 32, 'en', 'Edit menu '),
(81, 32, 'uk', 'Редактирование меню UA'),
(82, 33, 'ru', 'Администрирование проекта'),
(83, 33, 'en', 'Project backend'),
(84, 33, 'uk', 'Project backend УКР'),
(85, 34, 'ru', 'Генератор меню'),
(86, 34, 'en', 'Menu generator'),
(87, 34, 'uk', 'Генератор меню'),
(88, 35, 'ru', 'Генератор меню'),
(89, 35, 'en', 'Menu generator'),
(90, 35, 'uk', 'Генератор меню'),
(91, 36, 'ru', 'Перевод'),
(92, 36, 'en', 'Перевод'),
(93, 36, 'uk', 'Перевод'),
(94, 37, 'ru', 'Перевод'),
(95, 37, 'en', 'Перевод'),
(96, 37, 'uk', 'Перевод');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `seotm_users`
--

INSERT INTO `seotm_users` (`user_id`, `login`, `pass`, `active`, `email`, `reg_date`, `login_numbs`, `last_login`, `last_action_time`, `token`) VALUES
(1, 'admin', '$2a$12$rA2f1M.5WiFhLtSzDgQ6GuqbSD8nw7S3iuJS/hPnJfg.qESXX174.', 1, 'info@root.zt.ua', '0000-00-00 00:00:00', 252, '2013-06-17 18:00:05', '2013-06-17 18:19:10', '$2a$12$rA2f1M.5WiFhLtSzDgQ6GuqbSD8nw7S3iuJS/hPnJfg.qESXX174.'),
(3, 'root', '$2a$12$3qsto85PS0qN2h.hTPCUduXQtgAIZvQs20K2qTDoLJQ2s/WeexFA6', 1, 'info@root.zt.ua', '2013-03-25 12:35:02', 2, '2013-04-26 11:22:17', '2013-04-26 11:22:43', NULL),
(5, 'test', '$2a$12$Fh/1NhPuD3fpevthS6nahe8LvPFmFOHsnJ8QQ1YGTLvU1gXz72Etu', 1, 'blog@root.zt.ua', '2013-05-13 12:04:56', 1, '2013-05-13 12:06:08', '2013-05-13 12:16:50', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `sitemenu_translate`
--

CREATE TABLE IF NOT EXISTS `sitemenu_translate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source_id` int(11) NOT NULL,
  `t_lang` varchar(2) NOT NULL,
  `t_text` varchar(255) NOT NULL,
  `t_hide` tinyint(4) NOT NULL DEFAULT '0',
  `t_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `source_id` (`source_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=85 ;

--
-- Дамп данных таблицы `sitemenu_translate`
--

INSERT INTO `sitemenu_translate` (`id`, `source_id`, `t_lang`, `t_text`, `t_hide`, `t_url`) VALUES
(1, 1, 'ru', '', 0, NULL),
(2, 1, 'en', '', 0, NULL),
(3, 1, 'uk', '', 0, NULL),
(61, 21, 'ru', 'cat_rus', 0, NULL),
(62, 21, 'en', '', 0, NULL),
(63, 21, 'uk', '', 0, NULL),
(64, 22, 'ru', 'google', 0, 'http://google.com'),
(65, 22, 'en', '', 0, '11-'),
(66, 22, 'uk', '', 0, '12-'),
(70, 24, 'ru', 'Новая страница', 0, 'novaya-stranica'),
(71, 24, 'en', '', 0, ''),
(72, 24, 'uk', '', 0, ''),
(73, 25, 'ru', 'Новая страница', 0, '8-novaya-stranica'),
(74, 25, 'en', '', 0, ''),
(75, 25, 'uk', '', 0, ''),
(82, 28, 'ru', 'Самый главный раздел', 0, 'samyi-glavnyi-razdel'),
(83, 28, 'en', '', 0, ''),
(84, 28, 'uk', '', 0, '');

-- --------------------------------------------------------

--
-- Структура таблицы `site_menu`
--

CREATE TABLE IF NOT EXISTS `site_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `root` int(11) NOT NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `link_type` enum('page','category','url') NOT NULL DEFAULT 'url',
  `type` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Дамп данных таблицы `site_menu`
--

INSERT INTO `site_menu` (`id`, `root`, `lft`, `rgt`, `level`, `link_type`, `type`) VALUES
(1, 1, 1, 12, 1, 'url', 'mainmenu'),
(21, 1, 8, 9, 2, 'category', 'mainmenu'),
(22, 1, 10, 11, 2, 'url', 'mainmenu'),
(24, 1, 6, 7, 2, 'page', 'mainmenu'),
(25, 1, 4, 5, 2, 'page', 'mainmenu'),
(28, 1, 2, 3, 2, 'page', 'mainmenu');

-- --------------------------------------------------------

--
-- Структура таблицы `SourceMessage`
--

CREATE TABLE IF NOT EXISTS `SourceMessage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(32) DEFAULT NULL,
  `message` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

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
(16, 'backMenu', 'module Users'),
(17, 'backend', 'Feedback.Feedback.Create'),
(20, 'backend', 'Authenticated2'),
(21, 'backend', 'Users.Users.Logout2'),
(22, 'backend', 'Users.Users.Logout'),
(23, 'backend', 'Feedback.Feedback.View'),
(30, 'backend', 'Menugen.Default.Usermenu'),
(31, 'backend', 'Users.Users.Admin'),
(32, 'backend', 'Редактирование меню'),
(33, 'backend', 'Администрирование проекта'),
(35, 'backend', 'menugen'),
(36, 'backend', 'Multilanguage.Message.Admin'),
(37, 'backend', 'Menugen.Sitemenu.Mainmenu');

-- --------------------------------------------------------

--
-- Структура таблицы `static_pages`
--

CREATE TABLE IF NOT EXISTS `static_pages` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `static_pages`
--

INSERT INTO `static_pages` (`page_id`, `lft`, `rgt`, `level`) VALUES
(1, 1, 16, 1),
(2, 4, 5, 2),
(3, 2, 3, 2),
(4, 6, 7, 2),
(5, 8, 9, 2),
(6, 10, 11, 2),
(7, 12, 13, 2),
(8, 14, 15, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `translate_pages`
--

CREATE TABLE IF NOT EXISTS `translate_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `published` tinyint(4) NOT NULL DEFAULT '1',
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Дамп данных таблицы `translate_pages`
--

INSERT INTO `translate_pages` (`id`, `published`, `page_id`, `t_title`, `t_lang`, `t_desc`, `t_h1`, `t_content`, `t_translit`, `t_mtitle`, `t_mdesc`, `t_mkeywords`) VALUES
(1, 1, 1, 'Самый главный раздел', 'ru', 'описание', 'заголовок', '<p>содержимое</p>', 'samyi-glavnyi-razdel', '', '', ''),
(2, 1, 1, 'Main razdel', 'en', '', '', '', 'main-razdel', '', '', ''),
(3, 1, 1, 'Головный', 'uk', '', '', '', 'golovnyi', '', '', ''),
(4, 1, 2, 'хороший тайтлл', 'ru', 'хорошее описание', 'заголовок H1', '<p>цупцупцуп</p>', 'horoshii-taitll', '', '', ''),
(5, 1, 2, 'good title', 'en', 'nice description', 'best h1', '', 'good-title', '', '', ''),
(6, 1, 2, 'крутый тайтл', 'uk', 'файна информация', 'кращий h1', '', 'krutyi-taitl', '', '', ''),
(7, 1, 3, 'erhgersh', 'ru', 'erherh', 'aerhareh', '<p>aerhewrhera</p>', 'erhgersh', '', '', ''),
(8, 1, 3, '', 'en', '', '', '', '', '', '', ''),
(9, 1, 3, '', 'uk', '', '', '', '', '', '', ''),
(10, 1, 4, 'Новая страница', 'ru', '', '', '', 'novaya-stranica', '', '', ''),
(11, 1, 4, '', 'en', '', '', '', '', '', '', ''),
(12, 1, 4, '', 'uk', '', '', '', '', '', '', ''),
(13, 1, 5, 'Новая страница 2', 'ru', '', '', '', 'novaya-stranica-2', '', '', ''),
(14, 1, 5, '', 'en', '', '', '', '', '', '', ''),
(15, 1, 5, '', 'uk', '', '', '', '', '', '', ''),
(16, 1, 6, 'Новая страница 3-beta', 'ru', '', '', '<p>цупцфупфцуп</p>', 'novaya-stranica-3-beta', '', '', ''),
(17, 1, 6, '', 'en', '', '', '', '', '', '', ''),
(18, 1, 6, '', 'uk', '', '', '', '', '', '', ''),
(19, 1, 7, '1242352345', 'ru', '', '', '', '1242352345', '', '', ''),
(20, 1, 7, '', 'en', '', '', '', '', '', '', ''),
(21, 1, 7, '', 'uk', '', '', '', '', '', '', ''),
(22, 1, 8, 'Новая страница', 'ru', '', '', '<p>купрыукорыкеоке</p>', '8-novaya-stranica', '', '', ''),
(23, 1, 8, '', 'en', '', '', '', '8-', '', '', ''),
(24, 1, 8, '', 'uk', '', '', '', '8-', '', '', '');

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
  `url` varchar(128) DEFAULT NULL,
  `role` varchar(64) NOT NULL,
  `visible` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=59 ;

--
-- Дамп данных таблицы `usermenu`
--

INSERT INTO `usermenu` (`id`, `root`, `text`, `lft`, `rgt`, `level`, `url`, `role`, `visible`) VALUES
(1, 1, 'overAllManager', 1, 86, 1, NULL, 'overAllManager', 1),
(3, 1, 'Feedback.Feedback.Admin', 4, 5, 2, 'backend/feedback/feedback/admin', 'overAllManager', 0),
(6, 1, 'Feedback.Feedback.Index', 6, 7, 2, 'backend/feedback/feedback/index', 'overAllManager', 0),
(7, 1, 'Feedback.Feedback.MailList', 8, 9, 2, 'backend/feedback/feedback/maillist', 'overAllManager', 0),
(8, 1, 'Feedback.Feedback.Update', 10, 11, 2, 'backend/feedback/feedback/update', 'overAllManager', 0),
(10, 1, 'Users.Users.Login', 27, 28, 3, 'backend/users/users/login', 'overAllManager', 1),
(11, 1, 'Menugen.Default.Usermenu', 12, 13, 2, 'backend/menugen/default/usermenu', 'overAllManager', 1),
(12, 1, 'Multilanguage.Message.Admin', 55, 56, 3, 'backend/multilanguage/message/admin', 'overAllManager', 1),
(13, 1, 'Multilanguage.Message.Create', 57, 58, 3, 'backend/multilanguage/message/create', 'overAllManager', 1),
(14, 1, 'Multilanguage.Message.Delete', 59, 60, 3, 'backend/multilanguage/message/delete', 'overAllManager', 0),
(15, 1, 'Multilanguage.Message.Index', 61, 62, 3, 'backend/multilanguage/message/index', 'overAllManager', 0),
(16, 1, 'Multilanguage.Message.Update', 63, 64, 3, 'backend/multilanguage/message/update', 'overAllManager', 0),
(17, 1, 'Multilanguage.Message.View', 65, 66, 3, 'backend/multilanguage/message/view', 'overAllManager', 0),
(18, 1, 'Multilanguage.Source.Admin', 67, 68, 3, 'backend/multilanguage/source/admin', 'overAllManager', 1),
(19, 1, 'Multilanguage.Source.Create', 69, 70, 3, 'backend/multilanguage/source/create', 'overAllManager', 1),
(20, 1, 'Multilanguage.Source.Delete', 71, 72, 3, 'backend/multilanguage/source/delete', 'overAllManager', 0),
(21, 1, 'Multilanguage.Source.Index', 73, 74, 3, 'backend/multilanguage/source/index', 'overAllManager', 0),
(22, 1, 'Multilanguage.Source.Relational', 75, 76, 3, 'backend/multilanguage/source/relational', 'overAllManager', 1),
(23, 1, 'Multilanguage.Source.Update', 77, 78, 3, 'backend/multilanguage/source/update', 'overAllManager', 0),
(24, 1, 'Multilanguage.Source.View', 53, 54, 3, 'backend/multilanguage/source/view', 'overAllManager', 0),
(25, 1, 'Pages.Pages.Admin', 31, 32, 3, 'backend/pages/pages/admin', 'overAllManager', 1),
(26, 1, 'Pages.Pages.Create', 33, 34, 3, 'backend/pages/pages/create', 'overAllManager', 1),
(27, 1, 'Pages.Pages.Delete', 35, 36, 3, 'backend/pages/pages/delete', 'overAllManager', 1),
(28, 1, 'Pages.Pages.FetchTree', 37, 38, 3, 'backend/pages/pages/fetchtree', 'overAllManager', 1),
(29, 1, 'Pages.Pages.Grid', 39, 40, 3, 'backend/pages/pages/grid', 'overAllManager', 1),
(30, 1, 'Pages.Pages.GridSave', 41, 42, 3, 'backend/pages/pages/gridsave', 'overAllManager', 0),
(31, 1, 'Pages.Pages.Index', 43, 44, 3, 'backend/pages/pages/index', 'overAllManager', 1),
(32, 1, 'Pages.Pages.PageTree', 45, 46, 3, 'backend/pages/pages/pagetree', 'overAllManager', 1),
(33, 1, 'Pages.Pages.Update', 47, 48, 3, 'backend/pages/pages/update', 'overAllManager', 1),
(34, 1, 'Pages.Pages.View', 49, 50, 3, 'backend/pages/pages/view', 'overAllManager', 1),
(35, 1, 'Users.Users.Admin', 2, 3, 2, 'backend/users/users/admin', 'overAllManager', 1),
(36, 1, 'Users.Users.Adminka', 23, 24, 3, 'backend/users/users/adminka', 'overAllManager', 1),
(37, 1, 'Users.Users.Confirm', 25, 26, 3, 'backend/users/users/confirm', 'overAllManager', 1),
(38, 1, 'Users.Users.Create', 21, 22, 3, 'backend/users/users/create', 'overAllManager', 1),
(39, 1, 'Users.Users.Deactivate', 19, 20, 3, 'backend/users/users/deactivate', 'overAllManager', 1),
(40, 1, 'Users.Users.Delete', 17, 18, 3, 'backend/users/users/delete', 'overAllManager', 1),
(41, 1, 'Users.Users.Index', 15, 16, 3, 'backend/users/users/index', 'overAllManager', 1),
(42, 1, 'Feedback.Feedback.Create', 80, 81, 2, '/backend/feedback/feedback/create', 'overAllManager', 0),
(45, 1, 'Multilanguage', 52, 79, 2, NULL, 'overAllManager', 1),
(46, 1, 'Pages', 30, 51, 2, NULL, 'overAllManager', 1),
(47, 1, 'Users', 14, 29, 2, NULL, 'overAllManager', 1),
(49, 1, 'Users.Users.Logout', 82, 83, 2, '/backend/users/users/logout', 'overAllManager', 1),
(50, 50, 'usersAdmin', 1, 16, 1, NULL, 'usersAdmin', 1),
(51, 50, 'Users.Users.Admin', 2, 3, 2, 'backend/users/users/admin', 'usersAdmin', 1),
(52, 50, 'Users.Users.Adminka', 4, 5, 2, 'backend/users/users/adminka', 'usersAdmin', 1),
(53, 50, 'Users.Users.Confirm', 6, 7, 2, 'backend/users/users/confirm', 'usersAdmin', 1),
(54, 50, 'Users.Users.Create', 8, 9, 2, 'backend/users/users/create', 'usersAdmin', 1),
(55, 50, 'Users.Users.Deactivate', 10, 11, 2, 'backend/users/users/deactivate', 'usersAdmin', 1),
(56, 50, 'Users.Users.Delete', 12, 13, 2, 'backend/users/users/delete', 'usersAdmin', 1),
(57, 50, 'Users.Users.Index', 14, 15, 2, 'backend/users/users/index', 'usersAdmin', 1),
(58, 1, 'Menugen.Sitemenu.Mainmenu', 84, 85, 2, '/backend/menugen/sitemenu/mainmenu', 'overAllManager', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=81 ;

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
(31, 1, 'controller Feedback', 30, 2, 15, 2, '/feedback/feedback'),
(32, 1, 'Настройки почты', 30, 16, 17, 2, '/feedback/feedback/admin'),
(33, 1, 'action Create', 30, 3, 4, 3, '/feedback/feedback/create'),
(34, 1, 'action Delete', 30, 5, 6, 3, '/feedback/feedback/delete'),
(35, 1, 'action Index', 30, 7, 8, 3, '/feedback/feedback/index'),
(36, 1, 'action MailList', 30, 9, 10, 3, '/feedback/feedback/maillist'),
(37, 1, 'action Update', 30, 11, 12, 3, '/feedback/feedback/update'),
(38, 1, 'action View', 30, 13, 14, 3, '/feedback/feedback/view'),
(39, 1, 'module Pages', 39, 1, 24, 1, '/pages'),
(40, 1, 'контроллер Pages', 39, 2, 23, 2, '/pages/pages'),
(41, 1, 'action Admin', 39, 3, 4, 3, '/pages/pages/admin'),
(42, 1, 'action Create', 39, 5, 6, 3, '/pages/pages/create'),
(43, 1, 'action Delete', 39, 7, 8, 3, '/pages/pages/delete'),
(44, 1, 'action FetchTree', 39, 9, 10, 3, '/pages/pages/fetchtree'),
(45, 1, 'action Grid', 39, 11, 12, 3, '/pages/pages/grid'),
(47, 1, 'action Index', 39, 13, 14, 3, '/pages/pages/index'),
(48, 1, 'action PageTree', 39, 15, 16, 3, '/pages/pages/pagetree'),
(49, 1, 'action Update', 39, 17, 18, 3, '/pages/pages/update'),
(50, 1, 'module Users', 50, 1, 54, 1, '/users'),
(51, 1, 'controller Users', 50, 2, 21, 2, '/users/users'),
(52, 1, 'action Admin', 50, 3, 4, 3, '/users/users/admin'),
(53, 1, 'action Adminka', 50, 5, 6, 3, '/users/users/adminka'),
(54, 1, 'action Confirm', 50, 7, 8, 3, '/users/users/confirm'),
(55, 1, 'action Create', 50, 9, 10, 3, '/users/users/create'),
(56, 1, 'action Deactivate', 50, 11, 12, 3, '/users/users/deactivate'),
(57, 1, 'action Delete', 50, 13, 14, 3, '/users/users/delete'),
(58, 1, 'action Index', 50, 15, 16, 3, '/users/users/index'),
(59, 1, 'module Multilanguage', 50, 22, 53, 2, '/multilanguage'),
(60, 1, 'Сообщения', 50, 23, 38, 3, '/multilanguage/source'),
(61, 1, 'action Admin', 50, 26, 27, 4, '/multilanguage/source/admin'),
(62, 1, 'action Create', 50, 24, 25, 4, '/multilanguage/source/create'),
(63, 1, 'action Delete', 50, 28, 29, 4, '/multilanguage/source/delete'),
(64, 1, 'action Index', 50, 30, 31, 4, '/multilanguage/source/index'),
(65, 1, 'action Relational', 50, 32, 33, 4, '/multilanguage/source/relational'),
(66, 1, 'action Update', 50, 34, 35, 4, '/multilanguage/source/update'),
(67, 1, 'action View', 50, 36, 37, 4, '/multilanguage/source/view'),
(68, 1, 'action Logout', 50, 17, 18, 3, '/users/users/logout'),
(70, 1, 'action View', 39, 19, 20, 3, '/pages/pages/view'),
(71, 1, 'controller Message', 50, 39, 52, 3, '/multilanguage/message'),
(72, 1, 'action Admin', 50, 40, 41, 4, '/multilanguage/message/admin'),
(73, 1, 'action Create', 50, 42, 43, 4, '/multilanguage/message/create'),
(74, 1, 'action Delete', 50, 44, 45, 4, '/multilanguage/message/delete'),
(75, 1, 'action Index', 50, 46, 47, 4, '/multilanguage/message/index'),
(76, 1, 'action Update', 50, 48, 49, 4, '/multilanguage/message/update'),
(77, 1, 'action View', 50, 50, 51, 4, '/multilanguage/message/view'),
(78, 1, 'action Login', 50, 19, 20, 3, '/users/users/login'),
(80, 1, 'action GridSave', 39, 21, 22, 3, '/pages/pages/gridsave');

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
('rch0kvuu3r38ic44rhj68bd741', 1371483790, 0x38363866363637366232386430333938306637613739633031626437626132385f5f72657475726e55726c7c733a32353a222f6261636b656e642f70616765732f70616765732f67726964223b38363866363637366232386430333938306637613739633031626437626132385f5f69647c733a313a2231223b38363866363637366232386430333938306637613739633031626437626132385f5f6e616d657c733a353a2261646d696e223b3836386636363736623238643033393830663761373963303162643762613238726f6c657c733a353a2261646d696e223b38363866363637366232386430333938306637613739633031626437626132386c6173744c6f67696e7c733a31393a22323031332d30362d31372031383a30303a3035223b38363866363637366232386430333938306637613739633031626437626132385f5f7374617465737c613a323a7b733a343a22726f6c65223b623a313b733a393a226c6173744c6f67696e223b623a313b7d38363866363637366232386430333938306637613739633031626437626132385269676874735f69735375706572757365727c623a313b38363866363637366232386430333938306637613739633031626437626132385f5f74696d656f75747c693a313337313438393535303b);

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

--
-- Ограничения внешнего ключа таблицы `sitemenu_translate`
--
ALTER TABLE `sitemenu_translate`
  ADD CONSTRAINT `sitemenu_translate_ibfk_1` FOREIGN KEY (`source_id`) REFERENCES `site_menu` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
