-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Ноя 18 2013 г., 18:04
-- Версия сервера: 5.5.34
-- Версия PHP: 5.5.5-1+debphp.org~precise+2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `seotm_cms`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Attachments`
--

CREATE TABLE IF NOT EXISTS `Attachments` (
  `attachment_id` int(11) NOT NULL AUTO_INCREMENT,
  `attachment_entity` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `entity_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`attachment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='прикрепленный контент' AUTO_INCREMENT=1144 ;

--
-- Дамп данных таблицы `Attachments`
--

INSERT INTO `Attachments` (`attachment_id`, `attachment_entity`, `entity_id`, `type`, `path`, `position`, `description`) VALUES
(1120, 'StaticPages', 1, '', '/var/www/seotm_cms/uploads/StaticPages/1/thumbnail/rukoyatka.png', 0, ''),
(1121, 'StaticPages', 1, '', '/var/www/seotm_cms/uploads/StaticPages/1/thumbnail/root.png', 0, ''),
(1122, 'StaticPages', 1, '', '/var/www/seotm_cms/uploads/StaticPages/1/thumbnail/Ni794616.jpg', 0, ''),
(1123, 'StaticPages', 1, '', '/var/www/seotm_cms/uploads/StaticPages/1/small/rukoyatka.png', 0, ''),
(1124, 'StaticPages', 1, '', '/var/www/seotm_cms/uploads/StaticPages/1/small/root.png', 0, ''),
(1125, 'StaticPages', 1, '', '/var/www/seotm_cms/uploads/StaticPages/1/small/Ni794616.jpg', 0, ''),
(1126, 'StaticPages', 1, '', '/var/www/seotm_cms/uploads/StaticPages/1/rukoyatka.png', 0, ''),
(1127, 'StaticPages', 1, '', '/var/www/seotm_cms/uploads/StaticPages/1/root.png', 0, ''),
(1128, 'StaticPages', 1, '', '/var/www/seotm_cms/uploads/StaticPages/1/Ni794616.jpg', 0, ''),
(1129, 'StaticPages', 1, '', '/var/www/seotm_cms/uploads/StaticPages/1/thumbnail/sql_joins.jpg', 0, ''),
(1130, 'StaticPages', 1, '', '/var/www/seotm_cms/uploads/StaticPages/1/thumbnail/shara.png', 0, ''),
(1131, 'StaticPages', 1, '', '/var/www/seotm_cms/uploads/StaticPages/1/thumbnail/rukoyatka.png', 0, ''),
(1132, 'StaticPages', 1, '', '/var/www/seotm_cms/uploads/StaticPages/1/thumbnail/root.png', 0, ''),
(1133, 'StaticPages', 1, '', '/var/www/seotm_cms/uploads/StaticPages/1/sql_joins.jpg', 0, ''),
(1134, 'StaticPages', 1, '', '/var/www/seotm_cms/uploads/StaticPages/1/small/sql_joins.jpg', 0, ''),
(1135, 'StaticPages', 1, '', '/var/www/seotm_cms/uploads/StaticPages/1/small/shara.png', 0, ''),
(1136, 'StaticPages', 1, '', '/var/www/seotm_cms/uploads/StaticPages/1/small/rukoyatka.png', 0, ''),
(1137, 'StaticPages', 1, '', '/var/www/seotm_cms/uploads/StaticPages/1/small/root.png', 0, ''),
(1138, 'StaticPages', 1, '', '/var/www/seotm_cms/uploads/StaticPages/1/shara.png', 0, ''),
(1139, 'StaticPages', 1, '', '/var/www/seotm_cms/uploads/StaticPages/1/rukoyatka.png', 0, ''),
(1140, 'StaticPages', 1, '', '/var/www/seotm_cms/uploads/StaticPages/1/root.png', 0, ''),
(1141, 'StaticPages', 1, '', '/var/www/seotm_cms/uploads/StaticPages/1/var_strusture.png', 0, ''),
(1142, 'StaticPages', 1, '', '/var/www/seotm_cms/uploads/StaticPages/1/thumbnail/var_strusture.png', 0, ''),
(1143, 'StaticPages', 1, '', '/var/www/seotm_cms/uploads/StaticPages/1/small/var_strusture.png', 0, '');

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
('Feedback.Feedback.DeleteFile', 0, NULL, NULL, 'N;'),
('Feedback.Feedback.Feedback', 0, NULL, NULL, 'N;'),
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
('Multilanguage.Source.Manage', 0, NULL, NULL, 'N;'),
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
  KEY `AuthItemChild_ibfk_2` (`child`)
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
('Guest', 'Feedback.Feedback.DeleteFile'),
('Guest', 'Feedback.Feedback.Feedback'),
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
('multilangAdmin', 'Multilanguage.Source.Manage'),
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
  `sender_mail` varchar(64) NOT NULL,
  `sender_name` varchar(128) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `phone` varchar(255) NOT NULL,
  `files` blob NOT NULL,
  `ip` bigint(11) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Дамп данных таблицы `feedback`
--

INSERT INTO `feedback` (`id`, `sender_mail`, `sender_name`, `subject`, `body`, `phone`, `files`, `ip`, `create_date`) VALUES
(15, 'info@root.zt.ua', 'Alexei Smolyanov', 'Test subject', 'Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text ', '+3 (8093) 150 8 051', 0x613a323a7b693a303b613a333a7b733a343a226e616d65223b733a31353a22696d61676573313131312e6a706567223b733a343a2274797065223b733a31303a22696d6167652f6a706567223b733a333a2275726c223b733a32343a222f75706c6f6164732f696d61676573313131312e6a706567223b7d693a313b613a333a7b733a343a226e616d65223b733a31313a2277656c636f6d652e706e67223b733a343a2274797065223b733a393a22696d6167652f706e67223b733a333a2275726c223b733a32303a222f75706c6f6164732f77656c636f6d652e706e67223b7d7d, 2130706433, '2013-08-20 08:42:00'),
(16, 'info@root.zt.ua', 'efgaweogh', 'fgiofgoifgoufg', 'guopgpiougipgpifgipfgpifig', '2349856938465', 0x613a323a7b693a303b613a333a7b733a343a226e616d65223b733a31313a22696d616765732e6a706567223b733a343a2274797065223b733a31303a22696d6167652f6a706567223b733a333a2275726c223b733a32303a222f75706c6f6164732f696d616765732e6a706567223b7d693a313b613a333a7b733a343a226e616d65223b733a31353a22313332337266776165662e6a706567223b733a343a2274797065223b733a31303a22696d6167652f6a706567223b733a333a2275726c223b733a32343a222f75706c6f6164732f313332337266776165662e6a706567223b7d7d, 2130706433, '2013-08-20 08:44:34'),
(18, '', 'regewrg', 'awegaweg', 'eargerawg', '+3 (8093) 1508051', 0x613a323a7b693a303b613a333a7b733a343a226e616d65223b733a383a225f3030332e706e67223b733a343a2274797065223b733a393a22696d6167652f706e67223b733a333a2275726c223b733a31373a222f75706c6f6164732f5f3030332e706e67223b7d693a313b613a333a7b733a343a226e616d65223b733a31353a2277656c636f6d65202831292e706e67223b733a343a2274797065223b733a393a22696d6167652f706e67223b733a333a2275726c223b733a32343a222f75706c6f6164732f77656c636f6d65202831292e706e67223b7d7d, 2130706433, '2013-08-20 15:36:34'),
(19, 'info@root.zt.ua', 'Alexei Smolyanov', 'Test', 'erpgjhpwoerjhoprtjh', '+3 (8093) 150-8-051', 0x613a323a7b693a303b613a333a7b733a343a226e616d65223b733a31353a2277656c636f6d65202832292e706e67223b733a343a2274797065223b733a393a22696d6167652f706e67223b733a333a2275726c223b733a32343a222f75706c6f6164732f77656c636f6d65202832292e706e67223b7d693a313b613a333a7b733a343a226e616d65223b733a31393a22696d6167657331313131202831292e6a706567223b733a343a2274797065223b733a31303a22696d6167652f6a706567223b733a333a2275726c223b733a32383a222f75706c6f6164732f696d6167657331313131202831292e6a706567223b7d7d, 2130706433, '2013-08-20 15:38:31'),
(20, 'info@root.zt.ua', 'wertgergh', 'erherh', 'erwhwerher', '567567856', 0x613a313a7b693a303b613a333a7b733a343a226e616d65223b733a31353a2277656c636f6d65202833292e706e67223b733a343a2274797065223b733a393a22696d6167652f706e67223b733a333a2275726c223b733a32343a222f75706c6f6164732f77656c636f6d65202833292e706e67223b7d7d, 2130706433, '2013-08-20 15:40:30'),
(21, 'info@root.zt.ua', 'ergersgserg', 'ergsergserg', 'sergsergesrg', '45677567856', 0x613a323a7b693a303b613a333a7b733a343a226e616d65223b733a31393a22696d6167657331313131202832292e6a706567223b733a343a2274797065223b733a31303a22696d6167652f6a706567223b733a333a2275726c223b733a32383a222f75706c6f6164732f696d6167657331313131202832292e6a706567223b7d693a313b613a333a7b733a343a226e616d65223b733a31353a2277656c636f6d65202834292e706e67223b733a343a2274797065223b733a393a22696d6167652f706e67223b733a333a2275726c223b733a32343a222f75706c6f6164732f77656c636f6d65202834292e706e67223b7d7d, 2130706433, '2013-08-27 08:48:37'),
(22, 'eruigheuir@mail.ru', 'wsgiohe', 'uiguigiug', 'iugiugiuguig', '679576', '', 2130706433, '2013-08-27 08:51:18');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=98 ;

--
-- Дамп данных таблицы `Message`
--

INSERT INTO `Message` (`translation_id`, `id`, `language`, `translation`) VALUES
(85, 6, 'ru', 'Опции'),
(89, 6, 'en', 'Options'),
(90, 6, 'uk', 'Опцii'),
(91, 9, 'ru', 'Операции'),
(92, 9, 'en', 'Operations'),
(93, 9, 'uk', 'Операцii'),
(94, 7, 'ru', 'Перевод'),
(95, 7, 'en', 'Translation'),
(96, 7, 'uk', 'Переклад'),
(97, 6, 'ro', 'rom options');

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
(1, 'admin', '$2a$12$rA2f1M.5WiFhLtSzDgQ6GuqbSD8nw7S3iuJS/hPnJfg.qESXX174.', 1, 'info@root.zt.ua', '0000-00-00 00:00:00', 610, '2013-11-18 16:17:26', '2013-11-18 17:11:50', '$2a$12$rA2f1M.5WiFhLtSzDgQ6GuqbSD8nw7S3iuJS/hPnJfg.qESXX174.'),
(3, 'root', '$2a$12$3qsto85PS0qN2h.hTPCUduXQtgAIZvQs20K2qTDoLJQ2s/WeexFA6', 1, 'info@root.zt.ua', '2013-03-25 12:35:02', 2, '2013-04-26 11:22:17', '2013-04-26 11:22:43', NULL),
(5, 'test', '$2a$12$Fh/1NhPuD3fpevthS6nahe8LvPFmFOHsnJ8QQ1YGTLvU1gXz72Etu', 1, 'blog@root.zt.ua', '2013-05-13 12:04:56', 2, '2013-08-16 10:01:33', '2013-08-16 10:02:52', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `SiteConfig`
--

CREATE TABLE IF NOT EXISTS `SiteConfig` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `param` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `default` text COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('project parameter','module','component','params') COLLATE utf8_unicode_ci NOT NULL,
  `data_type` enum('array','string','boolean') COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('enabled','disabled') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'disabled',
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `position` (`position`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=35 ;

--
-- Дамп данных таблицы `SiteConfig`
--

INSERT INTO `SiteConfig` (`id`, `param`, `value`, `default`, `label`, `type`, `data_type`, `status`, `position`) VALUES
(1, 'language', 'ru', 'ru', 'Project language', 'project parameter', 'string', 'enabled', 14),
(2, 'db', 'array(\n            ''connectionString'' => ''mysql:host=localhost;dbname=seotm_cms'',\n            ''emulatePrepare'' => true,\n            ''username'' => ''seotm_cms'',\n            ''password'' => ''1q2w3e'',\n            ''charset'' => ''utf8'',\n            ''tablePrefix''=>'''', // needs to be set up for multilingual behavior, or we''ll get an error which is in code of ext (usin table prefixes)\n            ''enableParamLogging''=>true,\n            ''enableProfiling''=>true,\n        )', 'array(            \r\n        )', 'Database Connection', 'component', 'array', 'enabled', 35),
(9, 'name', 'My Cool Project', 'My Cool Project', 'Project''s name', 'project parameter', 'string', 'enabled', 12),
(11, 'mail', 'require(dirname(__FILE__) . ''/mail.php'')', 'require(dirname(__FILE__) . ''/mail.php'')', 'Mail settings', 'component', 'string', 'enabled', 40),
(15, 'session', 'array(\n     ''class'' => ''system.web.CDbHttpSession'',\n     ''connectionID''=>''db'',\n     ''autoCreateSessionTable''=>false,\n     ''autoStart''=>true,\n     ''timeout''=>''1440'',\n)', '\narray(\n)\n', 'session settings', 'component', 'array', 'enabled', 37),
(16, 'messages', 'array(\n    ''class''=>''CDbMessageSource'',\n    ''forceTranslation''=>true,\n)', '\narray(\n)\n', 'translation config', 'component', 'array', 'enabled', 45),
(17, 'params', 'array(\n    ''languages''=>require(dirname(__FILE__) . ''/languages.php''),\n    ''defaultPageSize''=>25,\n    ''wysiwyg''=>''tinymce'',\n)', '\narray(\n)\n', 'project parameters', 'project parameter', 'array', 'enabled', 70),
(18, 'urlManager', 'array(\n    ''class'' => ''application.backend.components.UrlManager'',\n            ''urlFormat''=>''path'',\n            ''showScriptName''=>false,\n//            ''caseSensitive''=>false,\n            ''useStrictParsing''=>true,\n            ''matchValue''=>false,\n            ''rules''=>array(\n\n                /*gii*/\n\n                ''backend/gii''=>''gii/default/index'',\n\n                /*end of gii*/\n\n                /*test for organising breadcrumbs*/\n//                ''/backend/mainmenu-create''=>''menugen/sitemenu/mainmenu'',\n\n         ''<language:[a-zA-Z]{2}>/backend''=>''site/index'',\n                ''backend''=>''site/index'',\n                ''backend/restore''=>''siteconfig/default/restore'',\n                ''<language:[a-zA-Z]{2}>/backend/login''=>''users/users/login'',\n                ''backend/login''=>''users/users/login'',\n                ''<language:[a-zA-Z]{2}>/backend/logout''=>''users/users/logout'',\n                ''backend/logout''=>''users/users/logout'',\n//				''<controller:\\w+>/<id:\\d+>''=>''<controller>/view'',\n//				''<controller:\\w+>/<action:\\w+>/<id:\\d+>''=>''<controller>/<action>'',\n                ''<language:[a-zA-Z]{2}>/backend/<controller:\\w+>/<action:\\w+>''=>''<controller>/<action>'',\n                ''backend/<controller:\\w+>/<action:\\w+>''=>''<controller>/<action>'',\n\n                /*rules for rights*/\n                ''backend/rights''=>''rights/assignment/view'',\n                ''<language:[a-zA-Z]{2}>/backend/rights''=>''rights/assignment/view'',\n                ''backend/rights/<controller:\\w+>/<action:\\w+>''=>''rights/<controller>/<action>'',\n                ''<language:[a-zA-Z]{2}>/backend/rights/<controller:\\w+>/<action:\\w+>''=>''rights/<controller>/<action>'',\n                /*end of rights urls*/\n\n                /*modules section*/\n                ''<language:[a-zA-Z]{2}>/backend/<module>/<controller:\\w+>/<action:\\w+>/<id:\\d+>''=>''<module>/<controller>/view'',\n                ''backend/<module>/<controller:\\w+>/<action:\\w+>/<id:\\d+>''=>''<module>/<controller>/view'',\n                ''<language:[a-zA-Z]{2}>/backend/<module>/<controller:\\w+>/<action:\\w+>/*''=>''<module>/<controller>/<action>'',\n                ''backend/<module>/<controller:\\w+>/<action:\\w+>/*''=>''<module>/<controller>/<action>'',\n                ''<language:[a-zA-Z]{2}>/backend/<module>/<controller:\\w+>/<action:\\w+>''=>''<module>/<controller>/<action>'',\n                ''backend/<module>/<controller:\\w+>/<action:\\w+>''=>''<module>/<controller>/<action>'',\n\n\n//                array(''<module>/<controller>/<action>'',''pattern''=>''<language:[a-zA-Z]{2}>/backend/<module>/<controller:\\w >/<action:\\w >'',''matchValue''=>true,''parsingOnly''=>true),\n//                array(''<module>/<controller>/<action>'',''pattern''=>''backend/<module>/<controller:\\w >/<action:\\w >'',''matchValue''=>false),\n\n            ),\n)', '\narray(\n)\n', 'urlManager', 'component', 'array', 'enabled', 34),
(19, 'authManager', 'array(\n      ''class''=>''RDbAuthManager'', //used Rights''s class instead of basic CDbAuthManager\n      ''defaultRoles''=>array(''Guest''),\n      ''connectionID''=>''db'',\n)', '\narray(\n)\n', 'authManager', 'component', 'array', 'enabled', 33),
(20, 'user', 'array(\n  ''class''=>''RWebUser'', //used module Rights instead of basic class CWebUser\n   // enable cookie-based authentication\n  ''allowAutoLogin''=>true,\n  ''autoRenewCookie''=>true,\n  ''authTimeout''=>7200,\n)', '\narray(\n)\n', 'user', 'component', 'array', 'enabled', 32),
(21, 'bootstrap', 'array(\n    ''class'' => ''ext.bootstrap.components.Bootstrap'',\n    ''responsiveCss'' => true,\n)', '\narray(\n)\n', 'bootstrap', 'component', 'array', 'enabled', 31),
(22, 'modules', 'require(dirname(__FILE__) . ''/modules.php'')', 'require(dirname(__FILE__) . ''/modules.php'')', 'modules', 'project parameter', 'string', 'enabled', 23),
(23, 'basePath', 'dirname(dirname(dirname(__FILE__)))', 'dirname(dirname(dirname(__FILE__)))', 'basePath', 'project parameter', 'string', 'enabled', 16),
(24, 'controllerPath', 'dirname(dirname(__FILE__)).''/controllers''', 'dirname(dirname(__FILE__)).''/controllers''', 'controllerPath', 'project parameter', 'string', 'enabled', 17),
(25, 'viewPath', 'dirname(dirname(__FILE__)).''/views''', 'dirname(dirname(__FILE__)).''/views''', 'viewPath', 'project parameter', 'string', 'enabled', 18),
(26, 'runtimePath', 'dirname(dirname(__FILE__)).''/runtime''', 'dirname(dirname(__FILE__)).''/runtime''', 'runtimePath', 'project parameter', 'string', 'enabled', 19),
(27, 'sourceLanguage', 'ru', 'ru', 'sourceLanguage', 'project parameter', 'string', 'enabled', 13),
(28, 'theme', 'unicorn', 'unicorn', 'theme', 'project parameter', 'string', 'enabled', 15),
(30, 'preload', 'array(\n     ''log'',\n     ''bootstrap'',\n)', '\narray(\n)\n', 'preload', 'project parameter', 'array', 'enabled', 29),
(31, 'import', 'array(\n            ''backend.models.*'',\n        ''backend.components.*'',\n//        ''application.models.*'',\n//        ''application.components.*'',\n        ''backend.vendors.*'',\n        ''backend.modules.users.models.*'',\n        ''backend.modules.rights.*'',\n        ''backend.modules.rights.models.*'',\n//        ''backend.modules.backendmenu.models.*'',\n//        ''backend.modules.rights.components.*'',\n//            loading swift mailer extension yii-mail\n        ''application.extensions.yii-mail.YiiMailMessage'',\n)', '\narray(\n)\n', 'import', 'project parameter', 'array', 'enabled', 21),
(32, 'onBeginRequest', 'array(\n    ''ModuleUrlManager'',''collectRules''\n)', '\narray(\n    ''ModuleUrlManager'',''collectRules''\n)\n', 'onBeginRequest', 'project parameter', 'array', 'enabled', 30),
(33, 'errorHandler', 'array(\n     ''errorAction''=>''site/error'',\n)', '\narray(\n     ''errorAction''=>''site/error'',\n)\n', 'errorHandler', 'component', 'array', 'enabled', 36),
(34, 'aliases', 'array(\n    //If you manually installed it\n    ''xupload'' => ''application.backend.extensions.xupload'',\n)', '''aliases'' => array(\n    //If you used composer your path should be\n    ''xupload'' => ''ext.vendor.asgaroth.xupload''\n    //If you manually installed it\n    ''xupload'' => ''ext.xupload''\n),', 'aliases', 'project parameter', 'array', 'enabled', 22);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=194 ;

--
-- Дамп данных таблицы `sitemenu_translate`
--

INSERT INTO `sitemenu_translate` (`id`, `source_id`, `t_lang`, `t_text`, `t_hide`, `t_url`) VALUES
(151, 168, 'ru', 'На русском', 0, NULL),
(152, 168, 'en', 'On English', 0, NULL),
(153, 168, 'uk', 'Украiнська', 0, NULL),
(163, 172, 'ru', 'Самый главный раздел', 0, 'samyi-glavnyi-razdel'),
(164, 172, 'en', 'Main razdel', 0, 'main-razdel'),
(165, 172, 'uk', 'Головный', 0, 'golovnyi'),
(166, 173, 'ru', 'category_rus', 0, NULL),
(167, 173, 'en', 'category_eng', 0, NULL),
(168, 173, 'uk', '', 0, NULL),
(169, 174, 'ru', 'google', 0, 'http://seocms.com'),
(170, 174, 'en', '', 0, 'new-page-edited'),
(171, 174, 'uk', '', 0, ''),
(172, 175, 'ru', 'хороший тайтлл', 0, 'horoshii-taitll'),
(173, 175, 'en', 'good title', 0, 'good-title'),
(174, 175, 'uk', 'крутый тайтл', 0, 'krutyi-taitl'),
(175, 176, 'ru', 'Главное меню', 0, NULL),
(176, 176, 'en', 'Main menu', 0, NULL),
(177, 176, 'uk', 'Головне меню', 0, NULL),
(178, 177, 'ru', 'Самый главный раздел', 0, 'samyi-glavnyi-razdel'),
(179, 177, 'en', 'Main razdel', 0, 'main-razdel'),
(180, 177, 'uk', 'Головный', 0, 'golovnyi'),
(181, 178, 'ru', 'категория меню', 0, NULL),
(182, 178, 'en', 'menu category', 0, NULL),
(183, 178, 'uk', '', 0, NULL),
(184, 179, 'ru', 'ukrNet - cool', 0, 'http://ukr.net'),
(185, 179, 'en', '', 0, ''),
(186, 179, 'uk', '', 0, ''),
(187, 180, 'ru', 'хороший тайтлл', 0, 'horoshii-taitll'),
(188, 180, 'en', 'good title', 0, 'good-title'),
(189, 180, 'uk', 'крутый тайтл', 0, 'krutyi-taitl'),
(192, 175, 'au', 'good australian title', 0, 'good-australian-title'),
(193, 172, 'au', 'werfgerg', 0, '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=181 ;

--
-- Дамп данных таблицы `site_menu`
--

INSERT INTO `site_menu` (`id`, `root`, `lft`, `rgt`, `level`, `link_type`, `type`) VALUES
(168, 168, 1, 10, 1, 'url', 'Название Меню'),
(172, 168, 4, 5, 2, 'page', 'Название Меню'),
(173, 168, 6, 7, 2, 'category', 'Название Меню'),
(174, 168, 8, 9, 2, 'url', 'Название Меню'),
(175, 168, 2, 3, 2, 'page', 'Название Меню'),
(176, 176, 1, 10, 1, 'url', 'Главное меню'),
(177, 176, 2, 5, 2, 'page', 'Главное меню'),
(178, 176, 6, 7, 2, 'category', 'Главное меню'),
(179, 176, 8, 9, 2, 'url', 'Главное меню'),
(180, 176, 3, 4, 3, 'page', 'Главное меню');

-- --------------------------------------------------------

--
-- Структура таблицы `SourceMessage`
--

CREATE TABLE IF NOT EXISTS `SourceMessage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` enum('frontend','backend') DEFAULT NULL,
  `message` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

--
-- Дамп данных таблицы `SourceMessage`
--

INSERT INTO `SourceMessage` (`id`, `category`, `message`) VALUES
(6, 'frontend', 'Options'),
(7, 'frontend', 'Перевод'),
(9, 'backend', 'Operations'),
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
(37, 'backend', 'Menugen.Sitemenu.Mainmenu'),
(38, 'backend', 'Users'),
(39, 'backend', 'Multilanguage.Source.Create'),
(40, 'backend', 'Multilanguage'),
(41, 'backend', 'Multilanguage.Source.Admin'),
(42, 'backend', 'Pages'),
(43, 'backend', 'Pages.Pages.Grid'),
(44, 'backend', 'Генератор frontend меню');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Дамп данных таблицы `static_pages`
--

INSERT INTO `static_pages` (`page_id`, `lft`, `rgt`, `level`) VALUES
(1, 1, 14, 1),
(2, 4, 5, 2),
(3, 2, 3, 2),
(6, 6, 7, 2),
(8, 8, 9, 2),
(9, 10, 11, 2),
(18, 12, 13, 2);

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
('m000000_000000_base', 1375366319),
('m130415_140239_auth_item', 1375366323),
('m130801_142644_sourceMessage_enum_category', 1375367275),
('m130801_143044_sourceMessage_update_all_to_backend', 1375367832),
('m130802_093950_SourceMessage_id_fk_to_source_id_Messages', 1375436542);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

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
(7, 1, 3, 'edited_!', 'ru', 'erherh', 'aerhareh', '<p>aerhewrhera</p>', 'edited_', '', '', ''),
(8, 1, 3, '', 'en', '', '', '', '', '', '', ''),
(9, 1, 3, '', 'uk', '', '', '', '', '', '', ''),
(16, 1, 6, 'Новая страница 3-beta', 'ru', '', '', '<p>цупцфупфцуп</p>', 'novaya-stranica-3-beta', '', '', ''),
(17, 1, 6, '', 'en', '', '', '', '', '', '', ''),
(18, 1, 6, '', 'uk', '', '', '', '', '', '', ''),
(22, 0, 8, 'Новая страница', 'ru', '', '', '<p>купрыукорыкеоке</p>', '8-novaya-stranica', '', '', ''),
(23, 1, 8, '', 'en', '', '', '', '8-', '', '', ''),
(24, 1, 8, '', 'uk', '', '', '', '8-', '', '', ''),
(25, 1, 2, 'good australian title', 'au', '', '', '', 'good-australian-title', '', '', ''),
(26, 1, 9, 'Тест с бихейвиором Ред', 'ru', 'Тест с бихейвиором', 'Тест с бихейвиором', '<p>Тест с бихейвиором</p>', 'test-s-biheiviorom-red', '', '', ''),
(27, 1, 9, 'Test with behavior', 'en', 'Test with behavior', 'Test with behavior', '<p>Test with behavior</p>', 'test-with-behavior', 'Test with behavior', 'Test with behavior', 'Test with behavior'),
(28, 1, 9, '', 'uk', '', '', '', '', '', '', ''),
(29, 1, 18, 'новая страница, сегодня 16.10.13', 'ru', 'кеороуенолен', '', '<p>16.10.13</p>\r\n<p>кеоукоуе</p>\r\n<p>коуенленл</p>', 'novaya-stranica-segodnya-161013', '', '', ''),
(30, 1, 18, '', 'en', '', '', '', '', '', '', ''),
(31, 1, 18, '', 'uk', '', '', '', '', '', '', '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=61 ;

--
-- Дамп данных таблицы `usermenu`
--

INSERT INTO `usermenu` (`id`, `root`, `text`, `lft`, `rgt`, `level`, `url`, `role`, `visible`) VALUES
(1, 1, 'overAllManager', 1, 74, 1, NULL, 'overAllManager', 1),
(3, 1, 'Feedback.Feedback.Admin', 4, 5, 2, 'backend/feedback/feedback/admin', 'overAllManager', 1),
(6, 1, 'Feedback.Feedback.Index', 6, 7, 2, 'backend/feedback/feedback/index', 'overAllManager', 0),
(7, 1, 'Feedback.Feedback.MailList', 8, 9, 2, 'backend/feedback/feedback/maillist', 'overAllManager', 1),
(8, 1, 'Feedback.Feedback.Update', 10, 11, 2, 'backend/feedback/feedback/update', 'overAllManager', 0),
(11, 1, 'Menugen.Default.Usermenu', 12, 13, 2, 'backend/menugen/default/usermenu', 'overAllManager', 1),
(12, 1, 'Multilanguage.Message.Admin', 39, 40, 3, 'backend/multilanguage/message/admin', 'overAllManager', 0),
(13, 1, 'Multilanguage.Message.Create', 41, 42, 3, 'backend/multilanguage/message/create', 'overAllManager', 0),
(14, 1, 'Multilanguage.Message.Delete', 43, 44, 3, 'backend/multilanguage/message/delete', 'overAllManager', 0),
(15, 1, 'Multilanguage.Message.Index', 45, 46, 3, 'backend/multilanguage/message/index', 'overAllManager', 0),
(16, 1, 'Multilanguage.Message.Update', 47, 48, 3, 'backend/multilanguage/message/update', 'overAllManager', 0),
(17, 1, 'Multilanguage.Message.View', 49, 50, 3, 'backend/multilanguage/message/view', 'overAllManager', 0),
(18, 1, 'Multilanguage.Source.Admin', 51, 52, 3, 'backend/multilanguage/source/admin', 'overAllManager', 1),
(19, 1, 'Multilanguage.Source.Create', 53, 54, 3, 'backend/multilanguage/source/create', 'overAllManager', 0),
(20, 1, 'Multilanguage.Source.Delete', 55, 56, 3, 'backend/multilanguage/source/delete', 'overAllManager', 0),
(21, 1, 'Multilanguage.Source.Index', 57, 58, 3, 'backend/multilanguage/source/index', 'overAllManager', 0),
(22, 1, 'Multilanguage.Source.Relational', 59, 60, 3, 'backend/multilanguage/source/relational', 'overAllManager', 0),
(23, 1, 'Multilanguage.Source.Update', 61, 62, 3, 'backend/multilanguage/source/update', 'overAllManager', 0),
(24, 1, 'Multilanguage.Source.View', 37, 38, 3, 'backend/multilanguage/source/view', 'overAllManager', 0),
(25, 1, 'Pages.Pages.Admin', 15, 16, 3, 'backend/pages/pages/admin', 'overAllManager', 1),
(26, 1, 'Pages.Pages.Create', 17, 18, 3, 'backend/pages/pages/create', 'overAllManager', 1),
(27, 1, 'Pages.Pages.Delete', 19, 20, 3, 'backend/pages/pages/delete', 'overAllManager', 1),
(28, 1, 'Pages.Pages.FetchTree', 21, 22, 3, 'backend/pages/pages/fetchtree', 'overAllManager', 1),
(29, 1, 'Pages.Pages.Grid', 23, 24, 3, 'backend/pages/pages/grid', 'overAllManager', 1),
(30, 1, 'Pages.Pages.GridSave', 25, 26, 3, 'backend/pages/pages/gridsave', 'overAllManager', 0),
(31, 1, 'Pages.Pages.Index', 27, 28, 3, 'backend/pages/pages/index', 'overAllManager', 1),
(32, 1, 'Pages.Pages.PageTree', 29, 30, 3, 'backend/pages/pages/pagetree', 'overAllManager', 1),
(33, 1, 'Pages.Pages.Update', 31, 32, 3, 'backend/pages/pages/update', 'overAllManager', 1),
(34, 1, 'Pages.Pages.View', 33, 34, 3, 'backend/pages/pages/view', 'overAllManager', 1),
(35, 1, 'Users.Users.Admin', 2, 3, 2, 'backend/users/users/admin', 'overAllManager', 1),
(42, 1, 'Feedback.Feedback.Create', 66, 67, 2, 'backend/feedback/feedback/create', 'overAllManager', 0),
(45, 1, 'Multilanguage', 36, 65, 2, NULL, 'overAllManager', 1),
(46, 1, 'Pages', 14, 35, 2, NULL, 'overAllManager', 1),
(49, 1, 'Users.Users.Logout', 68, 69, 2, 'backend/users/users/logout', 'overAllManager', 1),
(50, 50, 'usersAdmin', 1, 16, 1, NULL, 'usersAdmin', 1),
(51, 50, 'Users.Users.Admin', 2, 3, 2, 'backend/users/users/admin', 'usersAdmin', 1),
(52, 50, 'Users.Users.Adminka', 4, 5, 2, 'backend/users/users/adminka', 'usersAdmin', 1),
(53, 50, 'Users.Users.Confirm', 6, 7, 2, 'backend/users/users/confirm', 'usersAdmin', 1),
(54, 50, 'Users.Users.Create', 8, 9, 2, 'backend/users/users/create', 'usersAdmin', 1),
(55, 50, 'Users.Users.Deactivate', 10, 11, 2, 'backend/users/users/deactivate', 'usersAdmin', 1),
(56, 50, 'Users.Users.Delete', 12, 13, 2, 'backend/users/users/delete', 'usersAdmin', 1),
(57, 50, 'Users.Users.Index', 14, 15, 2, 'backend/users/users/index', 'usersAdmin', 1),
(58, 1, 'Menugen.Sitemenu.Mainmenu', 70, 71, 2, 'backend/menugen/sitemenu/mainmenu', 'overAllManager', 0),
(59, 1, 'Menugen.Sitemenu.Index', 72, 73, 2, 'backend/menugen/sitemenu/index', 'overAllManager', 1),
(60, 1, 'Multilanguage.Source.Manage', 63, 64, 3, '/backend/multilanguage/source/manage', 'overAllManager', 1);

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
('nfskcgdu92gi54psbg3c22vlk6', 1384788952, 0x62376130313563363930626437336163643965336233626233666233356531395f5f72657475726e55726c7c733a383a222f6261636b656e64223b62376130313563363930626437336163643965336233626233666233356531395f5f69647c733a313a2231223b62376130313563363930626437336163643965336233626233666233356531395f5f6e616d657c733a353a2261646d696e223b6237613031356336393062643733616364396533623362623366623335653139726f6c657c733a353a2261646d696e223b62376130313563363930626437336163643965336233626233666233356531396c6f67696e7c733a353a2261646d696e223b62376130313563363930626437336163643965336233626233666233356531396c6173744c6f67696e7c733a31393a22323031332d31312d31382031363a31373a3236223b62376130313563363930626437336163643965336233626233666233356531395f5f7374617465737c613a333a7b733a343a22726f6c65223b623a313b733a353a226c6f67696e223b623a313b733a393a226c6173744c6f67696e223b623a313b7d62376130313563363930626437336163643965336233626233666233356531395269676874735f69735375706572757365727c623a313b62376130313563363930626437336163643965336233626233666233356531395f5f74696d656f75747c693a313338343739343731303b66696c65737c613a313a7b733a353a2266696c6573223b613a383a7b733a363a22656e74697479223b733a31313a225374617469635061676573223b733a393a22656e746974795f6964223b733a313a2231223b733a383a2276657273696f6e73223b613a333a7b693a303b733a353a22736d616c6c223b693a313b733a393a227468756d626e61696c223b693a323b733a303a22223b7d733a373a2274656d7055726c223b733a37323a222f7661722f7777772f73656f746d5f636d732f75706c6f6164732f746d702f373365343738646134303866623937663431663132643132353830653461646463396534623861652f223b733a393a2275706c6f616455726c223b733a32373a222f7661722f7777772f73656f746d5f636d732f75706c6f6164732f223b733a363a22776562546d70223b733a35343a222f75706c6f6164732f746d702f373365343738646134303866623937663431663132643132353830653461646463396534623861652f223b733a363a2277656255726c223b733a393a222f75706c6f6164732f223b733a383a2266696c6550617468223b733a34313a222f7661722f7777772f73656f746d5f636d732f75706c6f6164732f53746174696350616765732f312f223b7d7d);

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
-- Ограничения внешнего ключа таблицы `Message`
--
ALTER TABLE `Message`
  ADD CONSTRAINT `sourceMsgFK` FOREIGN KEY (`id`) REFERENCES `SourceMessage` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

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
