-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Янв 21 2014 г., 00:29
-- Версия сервера: 5.5.31
-- Версия PHP: 5.4.4-14+deb7u5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `sc-olympiec`
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
  `hidden` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`attachment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='прикрепленный контент' AUTO_INCREMENT=1 ;

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
('overAllManager', '5', NULL, 'N;'),
('overAllManager', '6', NULL, 'N;');

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
('Feedback.Feedback.GetFiles', 0, NULL, NULL, 'N;'),
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
('Guest', 'Feedback.Feedback.DeleteFile'),
('Guest', 'Feedback.Feedback.GetFiles'),
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
-- Структура таблицы `Feedback`
--

CREATE TABLE IF NOT EXISTS `Feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_mail` varchar(64) NOT NULL,
  `sender_name` varchar(128) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `phone` varchar(255) NOT NULL,
  `files` blob NOT NULL,
  `ip` bigint(20) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- Дамп данных таблицы `Message`
--

INSERT INTO `Message` (`translation_id`, `id`, `language`, `translation`) VALUES
(1, 1, 'ru', 'Пользователи'),
(2, 1, 'en', 'Users'),
(3, 1, 'uk', 'Користувачі'),
(4, 2, 'ru', 'Управление Бэк-енд меню'),
(5, 2, 'en', 'Back-end menu'),
(6, 2, 'uk', 'Управління Бек-енд меню'),
(7, 3, 'ru', 'Мультиязычность'),
(8, 3, 'en', 'Multilanguage'),
(9, 3, 'uk', 'Багатомовність'),
(10, 4, 'ru', 'Статические страницы'),
(11, 4, 'en', 'Static Pages'),
(12, 4, 'uk', 'Статичні сторінки'),
(13, 5, 'ru', 'Управление Меню сайта'),
(14, 5, 'en', 'Site Menu Control'),
(15, 5, 'uk', 'Управління Меню сайту'),
(16, 6, 'ru', 'Новая страница'),
(17, 6, 'en', 'Create Page'),
(18, 6, 'uk', 'Нова сторінка'),
(19, 7, 'ru', 'Управление пользователями'),
(20, 7, 'en', 'Users Control'),
(21, 7, 'uk', 'Управління користувачами'),
(22, 8, 'ru', 'Новый пользователь'),
(23, 8, 'en', 'New user'),
(24, 8, 'uk', 'Новий користувач'),
(25, 9, 'ru', 'Создание пользователя'),
(26, 9, 'en', 'Create User'),
(27, 9, 'uk', 'Створення користувача'),
(31, 11, 'ru', 'Привет!'),
(32, 11, 'en', 'Hello!'),
(33, 11, 'uk', 'Привiт!'),
(34, 12, 'ru', 'Управление языками'),
(35, 12, 'en', 'Managing languages'),
(36, 12, 'uk', 'Управлiння мовами');

-- --------------------------------------------------------

--
-- Структура таблицы `News`
--

CREATE TABLE IF NOT EXISTS `News` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `short_text` text COLLATE utf8_unicode_ci NOT NULL,
  `full_text` text COLLATE utf8_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('Публикация','Черновик') COLLATE utf8_unicode_ci NOT NULL,
  `category` enum('Новости футбола','Новости клуба') COLLATE utf8_unicode_ci NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `due_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `News`
--

INSERT INTO `News` (`id`, `title`, `short_text`, `full_text`, `img`, `url`, `status`, `category`, `create_date`, `due_date`) VALUES
(1, 'Вечурко: "Все время работал по программе Арсенала"', 'Николай Вечурко, находящийся на просмотре в Говерле, поделился впечатлениями о работе в составе закарпатцев.', '<div><strong>- Николай, как вам в Говерле? Наверное, еще не приходилось встречать таких нагрузок вперемешку с частыми спаррингами (напомним, что закарпатцы выходили на поле в товарищеских матчах три дня подряд. &mdash; прим. М.С.)?</strong></div>\r\n<div>&nbsp;</div>\r\n<div>- Как по мне, то это хорошо, когда команда проводит много спаррингов. За счет матчей можно быстро набрать игровую форму.</div>\r\n<div>&nbsp;</div>\r\n<div><strong>- В Арсенале доводилось сталкиваться с подобным, когда приходилось играть четыре матча за пять дней?</strong></div>\r\n<div>&nbsp;</div>\r\n<div>- Всякое бывало, но в каждой команде подход к рабочему процессу совершенно разный. Однако вначале, на первых сборах, все настраиваются на тяжелую работу, чтобы заложить основы для хорошей физической готовности. На вторых же сборах делается упор на тактику, а третьи &mdash; сугубо игровые, чтобы как можно в лучшем состоянии подойти к официальным матчам.</div>\r\n<div>&nbsp;</div>\r\n<div><strong>- Вы не выходили на поле долгое время, когда Арсенал перестал играть в УПЛ. Как сами поддерживали форму в тот период и во время отпуска?</strong></div>\r\n<div>&nbsp;</div>\r\n<div>- Тренировался самостоятельно, тем более у меня осталась индивидуальная программа, которую нам давали еще в Арсенале. По ней и трудился: тренажерный зал, пробежки и все остальное.</div>\r\n<div>&nbsp;</div>\r\n<div><strong>- Некоторые нанимают себе тренера для индивидуальной работы...</strong></div>\r\n<div>&nbsp;</div>\r\n<div>- Нет, я обходился без этого, все выполнял самостоятельно. Надо же держать себя в форме!</div>\r\n<div>&nbsp;</div>\r\n<div><strong>- Как вообще попали на просмотр в Говерлу? Такой вариант образовался весьма неожиданно?</strong></div>\r\n<div>&nbsp;</div>\r\n<div>- Если можно, этот вопрос хотелось бы оставить без ответа.</div>\r\n<div>&nbsp;</div>\r\n<div><strong>- Что Грозный в первую очередь требует от вас?</strong></div>\r\n<div>&nbsp;</div>\r\n<div>- Это быстрый переход из обороны в атаку. Команда должна молниеносно перестраиваться и резко выходить вперед. Также Вячеслав Викторович просит, чтобы мы действовали более плотно, не растягивались широко, и обязательно были первыми на мяче.</div>\r\n<div>&nbsp;</div>\r\n<div><strong>- Наблюдая за спаррингами, мне показалось, что вас тянет в атаку, но тренер возлагает на вас только функции опорного полузащитника...</strong></div>\r\n<div>&nbsp;</div>\r\n<div>- Есть немного, ведь раньше я постоянно играл под нападающими, но потом стал выходить в роли опорного хавбека. И все равно бывают моменты, когда хочется подключиться и помочь партнерам впереди. Однако сейчас моя главная функция &mdash; это оборонительные действия. Сначала я отвечаю за сохранность своих ворот, а потом уже за атаку. Хотя порой можно и рискнуть (улыбается). Но главное, чтобы риск оправдался.</div>\r\n<div>&nbsp;</div>\r\n<div><strong>- Сейчас вы трудитесь с Говерлой на первом сборе. А что дальше?</strong></div>\r\n<div>&nbsp;</div>\r\n<div>- А дальше &mdash; как карта ляжет (улыбается). Пока работаю с ужгородцами, и очень доволен как коллективом, так и тренерским штабом. Здесь очень хорошее отношение к игрокам. Тем более, в Говерле сейчас много знакомых мне футболистов по Арсеналу: Максим Шацких, Олег Герасимюк, Вячеслав Сердюк... Это хорошо, когда есть такие люди &mdash; тогда работается гораздо лучше.</div>\r\n<div>&nbsp;</div>\r\n<div><strong>- Тот же Герасимюк говорил, что юридические проблемы с Арсеналом мешают оформить полноценное соглашение с Говерлой. А как у вас обстоят дела в этом вопросе?</strong></div>', 'vechyrko.jpg', 'vechurko-vse-vremya-rabotal-po-programme-arsenala', 'Публикация', 'Новости футбола', '2014-01-16 22:00:00', '0000-00-00 00:00:00'),
(2, 'Гармаш: "Если забили один мяч — не надо отходить назад"', 'Полузащитник Динамо, восстановившись после травмы, возлагает большие надежды на вторую часть сезона. Об этом он поведал в эксклюзивном интервью корреспонденту нашего сайта.', '<div><strong>- Иногда складывается впечатление, что футбольная судьба испытывает тебя на прочность. Несправедливое удаление в ключевом матче чемпионата, теперь тяжелая травма перед важным отрезком в еврокубках и национальном первенстве. Насколько тяжело психологически справляться с этим и что помогает больше всего?</strong></div>\r\n<div>&nbsp;</div>\r\n<div>- Конечно, ничего хорошего в этом нет, и положительных эмоций от этого не добавляется. В то же время, это помогает мне становиться еще сильнее. В частности, сейчас я восстановился после травмы, и приложу максимум усилий, чтобы вернуться на свой прежний уровень.</div>\r\n<div>&nbsp;</div>\r\n<div><strong>- Практически полгода без футбола. На что было потрачено освободившееся время, и было ли оно в принципе?</strong></div>\r\n<div>&nbsp;</div>\r\n<div>- Практически все свободное время уходило на реабилитацию. Первые три месяца мне довелось ходить с помощью костылей, а когда уже мог передвигаться самостоятельно, все равно много времени проводил на реабилитационных процедурах.</div>\r\n<div>&nbsp;</div>\r\n<div><strong>- За минувший год стал ли ты сильнее как футболист и личность?</strong></div>\r\n<div>&nbsp;</div>\r\n<div>- Что касается футбольной стороны вопроса, то вырасти в профессиональном плане мне помешала травма, после которой длительное время ушло на реабилитацию. А вот что касается личных качеств, то за себя судить не буду &ndash; пускай оценивают окружающие меня люди.</div>\r\n<div>&nbsp;</div>\r\n<div><strong>- Раньше Динамо боролось только за первое место, но вот уже второй сезон команда сражается лишь за вторую позицию. Давит ли это на футболистов команды и на тебя в частности?</strong></div>\r\n<div>&nbsp;</div>\r\n<div>- Динамо, независимо от турнира, ставит перед собой всегда максимальные цены и нацеливается только на первые места. Но сейчас многие команды в Украине подтянулись, и уже не две команды, как раньше, а четыре-пять сражаются за самые высокие места. Думаю, это идет лишь на пользу украинскому футболу.</div>\r\n<div>&nbsp;</div>\r\n<div><strong>- Будем откровенны &ndash; сейчас в Украине Динамо уже никто не боится. Это плюс для команды, ведь надо выкладываться в каждом матче, или минус, поскольку раньше многие морально сдавались еще до выхода на поле?</strong></div>\r\n<div>&nbsp;</div>\r\n<div>- В этом вопросе я с вами не соглашусь. Каждая команда, выходя на поле против Динамо, максимально заряжена на борьбу и готова выложиться на сто процентов. Соответственно, боязнь никуда не делась, просто соперники стали больше выкладываться на поле.</div>', 'garmash.jpg', 'garmash-esli-zabili-odin-myach-ne-nado-othodit-nazad', 'Публикация', 'Новости клуба', '2014-01-19 22:00:00', '0000-00-00 00:00:00'),
(3, 'Шахтер минимально одолел корейцев', 'В спарринге между Горняками и Пхохан Стилерс победу одержали подопечные Мирчи Луческу.', '<div>Единственный гол в этой встрече на исходе первого тайма провел Луис Адриано. После прострела Алекса Тейшейры с правого фланга нападающий Шахтера переправил мяч в ворота.</div>\r\n<div>&nbsp;</div>\r\n<div><strong>Шахтер</strong>&nbsp;&ndash; Пхохан Стилерс 1:0</div>\r\n<div><strong>Гол</strong>: Адриано, 45</div>\r\n<div>&nbsp;</div>\r\n<div><strong>Шахтер (1-й тайм):</strong>&nbsp;Пятов, Кобин, Кучер, Хюбшман, Соболь, Степаненко, Илсиньо, Тейшейра, Тайсон, Бернард, Феррейра (Адриано, 21)</div>\r\n<div>&nbsp;</div>\r\n<div><strong>Шахтер (2-й тайм):</strong>&nbsp;Каниболоцкий, Срна, Кривцов, Ракицкий, Шевчук, Веллингтон Нем, Фред, Коста, Эдуардо, Дентиньо, Адриано</div>', 'shakhtar.jpg', 'shahter-minimalno-odolel-koreicev', 'Публикация', 'Новости футбола', '2014-01-19 22:00:00', '0000-00-00 00:00:00'),
(4, 'Барселона останется на Ноу Камп', 'Каталонцы отказались от идеи строительства нового стадиона.', '<div>На сегодняшнем заседании совета директоров Барселоны было принято важное решение: вместо прежде обсуждавшегося варианта строительства новой арены будет реконструирован легендарный Ноу Камп.</div>\r\n<div>&nbsp;</div>\r\n<div>Работа по модернизации арены начнется с 2017 году и продлится до начала 2021 года. Согласно плану, принятому еще в апреле, вместительность стадиона увеличится с 98-ми тысяч до 105-ти.</div>\r\n<div>&nbsp;</div>\r\n<div>Важно отметить, что проект включает в себя также постройку баскетбольной арены. Ожидается, что все это обойдется блаугранас приблизительно в 495 миллионов фунтов.</div>', 'stadium.jpg', 'barselona-ostanetsya-na-nou-kamp', 'Публикация', 'Новости футбола', '2014-01-20 22:00:00', '0000-00-00 00:00:00'),
(5, 'Днепр отклонил предложение Сельты по Калиничу', 'Днепропетровский Днепр не устроило предложение испанской Сельты о покупке хорватского нападающего Николы Калинича.', '<div>Испанцы хотели на полгода арендовать футболиста и платить ему лишь половину зарплаты, однако руководство Днепра посчитало это неприемлемым, сообщает&nbsp;<em>slobodnadalmacija.hr.</em></div>\r\n<div>&nbsp;</div>\r\n<div>Контракт Калинича с Днепром действует до середины 2015 года.</div>\r\n<div>&nbsp;</div>\r\n<div>Сельта сейчас борется за выживание, находясь после 20-ти туров лишь на 16-й ступеньке.</div>', 'kalinich.jpg', 'dnepr-otklonil-predlozhenie-selty-po-kalinichu', 'Публикация', 'Новости футбола', '2014-01-20 22:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `Players`
--

CREATE TABLE IF NOT EXISTS `Players` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fio` varchar(255) NOT NULL,
  `country` varchar(50) NOT NULL,
  `birth_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `player_role` enum('ВРАТАРИ','ЗАЩИТНИКИ','ПОЛУЗАЩИТНИКИ','НАПАДАЮЩИЕ','ТРЕНЕРЫ') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `Players`
--

INSERT INTO `Players` (`id`, `fio`, `country`, `birth_date`, `player_role`) VALUES
(1, 'Ivanov', 'Ukraine', '2007-01-20 12:00:00', 'ЗАЩИТНИКИ'),
(12, 'Petrov Petya', 'Russia', '2014-01-19 17:18:41', 'ЗАЩИТНИКИ'),
(13, 'Sidorov Sidor', 'Russia', '2014-01-19 17:18:41', 'ПОЛУЗАЩИТНИКИ'),
(14, 'Denisoc', 'Italy', '2014-01-19 17:27:11', 'ВРАТАРИ');

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
  `role` varchar(255) NOT NULL DEFAULT 'Guest',
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `email` varchar(64) NOT NULL,
  `reg_date` datetime NOT NULL,
  `login_numbs` int(11) NOT NULL DEFAULT '0',
  `last_login` datetime NOT NULL,
  `last_action_time` datetime NOT NULL,
  `token` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `role` (`role`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `seotm_users`
--

INSERT INTO `seotm_users` (`user_id`, `login`, `pass`, `role`, `active`, `email`, `reg_date`, `login_numbs`, `last_login`, `last_action_time`, `token`) VALUES
(1, 'admin', '$2a$12$rA2f1M.5WiFhLtSzDgQ6GuqbSD8nw7S3iuJS/hPnJfg.qESXX174.', 'admin', 1, 'info@root.zt.ua', '0000-00-00 00:00:00', 358, '2014-01-20 23:38:48', '2014-01-20 23:38:50', '$2a$12$rA2f1M.5WiFhLtSzDgQ6GuqbSD8nw7S3iuJS/hPnJfg.qESXX174.'),
(3, 'root', '$2a$12$3qsto85PS0qN2h.hTPCUduXQtgAIZvQs20K2qTDoLJQ2s/WeexFA6', 'overAllManager', 1, 'info@root.zt.ua', '2013-03-25 12:35:02', 3, '2013-08-06 17:39:52', '2013-08-06 17:40:28', NULL),
(5, 'test', '$2a$12$Fh/1NhPuD3fpevthS6nahe8LvPFmFOHsnJ8QQ1YGTLvU1gXz72Etu', 'overAllManager', 1, 'blog@root.zt.ua', '2013-05-13 12:04:56', 3, '2014-01-20 10:32:35', '2014-01-20 10:35:16', NULL),
(6, 'ihor', '$2a$12$4CGi/BbnOon7Z57HJCOlzOHJkuy6PhkqeahCetEZvsbmWsQtcBgu2', 'Guest', 1, 'ihor@seotm.com', '2013-08-06 17:41:00', 1, '2013-08-06 17:41:49', '2013-08-06 18:53:19', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=36 ;

--
-- Дамп данных таблицы `SiteConfig`
--

INSERT INTO `SiteConfig` (`id`, `param`, `value`, `default`, `label`, `type`, `data_type`, `status`, `position`) VALUES
(1, 'language', 'ru', 'ru', 'Project language', 'project parameter', 'string', 'enabled', 14),
(2, 'db', 'array(\n            ''connectionString'' => ''mysql:host=localhost;dbname=seotm_ru'',\n            ''emulatePrepare'' => true,\n            ''username'' => ''seotm_ru'',\n            ''password'' => ''seotm_ru'',\n            ''charset'' => ''utf8'',\n            ''tablePrefix''=>'''', // needs to be set up for multilingual behavior, or we''ll get an error which is in code of ext (usin table prefixes)\n            ''enableParamLogging''=>true,\n            ''enableProfiling''=>true,\n        )', 'array(            \r\n        )', 'Database Connection', 'component', 'array', 'enabled', 35),
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
(31, 'import', 'array(\n            ''backend.models.*'',\n        ''backend.components.*'',\n//        ''application.models.*'',\n//        ''application.components.*'',\n        ''backend.vendors.*'',\n        ''backend.modules.users.models.*'',\n        ''backend.modules.rights.*'',\n        ''backend.modules.rights.models.*'',\n//        ''backend.modules.backendmenu.models.*'',\n//        ''backend.modules.rights.components.*'',\n//            loading swift mailer extension yii-mail\n        ''application.extensions.yii-mail.YiiMailMessage'',\n        ''ext.easyimage.EasyImage'',\n)', '\narray(\n)\n', 'import', 'project parameter', 'array', 'enabled', 21),
(32, 'onBeginRequest', 'array(\n    ''ModuleUrlManager'',''collectRules''\n)', '\narray(\n    ''ModuleUrlManager'',''collectRules''\n)\n', 'onBeginRequest', 'project parameter', 'array', 'enabled', 30),
(33, 'errorHandler', 'array(\n     ''errorAction''=>''site/error'',\n)', '\narray(\n     ''errorAction''=>''site/error'',\n)\n', 'errorHandler', 'component', 'array', 'enabled', 36),
(34, 'aliases', 'array(\n    //If you manually installed it\n    ''xupload'' => ''application.backend.extensions.xupload'',\n)', '''aliases'' => array(\n    //If you used composer your path should be\n    ''xupload'' => ''ext.vendor.asgaroth.xupload''\n    //If you manually installed it\n    ''xupload'' => ''ext.xupload''\n),', 'aliases', 'project parameter', 'array', 'enabled', 22),
(35, 'easyImage', 'array(\n    ''class'' => ''application.extensions.easyimage.EasyImage'',\n    ''driver'' => ''Imagick'',\n    ''quality'' => 100,\n    //''cachePath'' => ''/assets/easyimage/'',\n    //''cacheTime'' => 2592000,\n    //''retinaSupport'' => false,\n  )', 'array(\n    ''easyImage'' => array(\n    ''class'' => ''application.extensions.easyimage.EasyImage'',\n    //''driver'' => ''GD'',\n    //''quality'' => 100,\n    //''cachePath'' => ''/assets/easyimage/'',\n    //''cacheTime'' => 2592000,\n    //''retinaSupport'' => false,\n  )\n)', 'easyImage', 'component', 'array', 'enabled', 71);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

--
-- Дамп данных таблицы `site_menu`
--

INSERT INTO `site_menu` (`id`, `root`, `lft`, `rgt`, `level`, `link_type`, `type`) VALUES
(42, 42, 1, 6, 1, 'url', 'Новое меню'),
(43, 42, 4, 5, 2, 'page', 'Новое меню'),
(44, 42, 2, 3, 2, 'page', 'Новое меню');

-- --------------------------------------------------------

--
-- Структура таблицы `SourceMessage`
--

CREATE TABLE IF NOT EXISTS `SourceMessage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` enum('frontend','backend') DEFAULT NULL,
  `message` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Дамп данных таблицы `SourceMessage`
--

INSERT INTO `SourceMessage` (`id`, `category`, `message`) VALUES
(1, 'backend', 'Users.Users.Admin'),
(2, 'backend', 'Menugen.Default.Usermenu'),
(3, 'backend', 'Multilanguage'),
(4, 'backend', 'Pages.Pages.Grid'),
(5, 'backend', 'Menugen.Sitemenu.Index'),
(6, 'backend', 'Create Static Page'),
(7, 'backend', 'Manage Users'),
(8, 'backend', 'Create user'),
(9, 'backend', 'Create Users'),
(11, 'frontend', 'Привет!'),
(12, 'backend', 'Multilanguage.Source.Manage');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_migration`
--

CREATE TABLE IF NOT EXISTS `tbl_migration` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `tbl_migration`
--

INSERT INTO `tbl_migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1375369218),
('m130415_140239_auth_item', 1375369224),
('m130801_142644_sourceMessage_enum_category', 1375369224),
('m130801_143044_sourceMessage_update_all_to_backend', 1375369224),
('m130802_093950_SourceMessage_id_fk_to_source_id_Messages', 1375801573);

-- --------------------------------------------------------

--
-- Структура таблицы `Teams`
--

CREATE TABLE IF NOT EXISTS `Teams` (
  `id` varchar(20) NOT NULL,
  `season` varchar(50) NOT NULL,
  `photo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Teams`
--

INSERT INTO `Teams` (`id`, `season`, `photo`) VALUES
('u-10', '2014', 'tumblr_mpfk36f2EX1qc2goao1_500.jpg'),
('u-18', '2013', ''),
('u-8', '2014', '14_3590_oboi_lesnoj_pejzazh_1366x768.jpg'),
('u-9', '2014', '');

-- --------------------------------------------------------

--
-- Структура таблицы `TeamsPlayers`
--

CREATE TABLE IF NOT EXISTS `TeamsPlayers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `player_id` int(11) NOT NULL,
  `team_id` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `TeamsPlayers`
--

INSERT INTO `TeamsPlayers` (`id`, `player_id`, `team_id`) VALUES
(1, 1, 'q-12'),
(3, 1, 'u-18'),
(4, 12, 'u-18'),
(5, 13, 'u-8'),
(6, 14, 'u-18');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
(1, 1, 'overAllManager', 1, 54, 1, NULL, 'overAllManager', 1),
(3, 1, 'Feedback.Feedback.Admin', 4, 5, 2, 'backend/feedback/feedback/admin', 'overAllManager', 1),
(6, 1, 'Feedback.Feedback.Index', 6, 7, 2, 'backend/feedback/feedback/index', 'overAllManager', 0),
(7, 1, 'Feedback.Feedback.MailList', 8, 9, 2, 'backend/feedback/feedback/maillist', 'overAllManager', 1),
(8, 1, 'Feedback.Feedback.Update', 10, 11, 2, 'backend/feedback/feedback/update', 'overAllManager', 0),
(11, 1, 'Menugen.Default.Usermenu', 12, 13, 2, 'backend/menugen/default/usermenu', 'overAllManager', 1),
(12, 1, 'Multilanguage.Message.Admin', 17, 18, 3, 'backend/multilanguage/message/admin', 'overAllManager', 0),
(13, 1, 'Multilanguage.Message.Create', 19, 20, 3, 'backend/multilanguage/message/create', 'overAllManager', 0),
(14, 1, 'Multilanguage.Message.Delete', 21, 22, 3, 'backend/multilanguage/message/delete', 'overAllManager', 0),
(15, 1, 'Multilanguage.Message.Index', 23, 24, 3, 'backend/multilanguage/message/index', 'overAllManager', 0),
(16, 1, 'Multilanguage.Message.Update', 25, 26, 3, 'backend/multilanguage/message/update', 'overAllManager', 0),
(17, 1, 'Multilanguage.Message.View', 27, 28, 3, 'backend/multilanguage/message/view', 'overAllManager', 0),
(18, 1, 'Multilanguage.Source.Admin', 29, 30, 3, 'backend/multilanguage/source/admin', 'overAllManager', 1),
(19, 1, 'Multilanguage.Source.Create', 31, 32, 3, 'backend/multilanguage/source/create', 'overAllManager', 0),
(20, 1, 'Multilanguage.Source.Delete', 33, 34, 3, 'backend/multilanguage/source/delete', 'overAllManager', 0),
(21, 1, 'Multilanguage.Source.Index', 35, 36, 3, 'backend/multilanguage/source/index', 'overAllManager', 0),
(22, 1, 'Multilanguage.Source.Relational', 37, 38, 3, 'backend/multilanguage/source/relational', 'overAllManager', 0),
(23, 1, 'Multilanguage.Source.Update', 39, 40, 3, 'backend/multilanguage/source/update', 'overAllManager', 0),
(24, 1, 'Multilanguage.Source.View', 15, 16, 3, 'backend/multilanguage/source/view', 'overAllManager', 0),
(29, 1, 'Pages.Pages.Grid', 44, 45, 2, 'backend/pages/pages/grid', 'overAllManager', 1),
(35, 1, 'Users.Users.Admin', 2, 3, 2, 'backend/users/users/admin', 'overAllManager', 1),
(42, 1, 'Feedback.Feedback.Create', 46, 47, 2, '/backend/feedback/feedback/create', 'overAllManager', 0),
(45, 1, 'Multilanguage', 14, 43, 2, NULL, 'overAllManager', 1),
(49, 1, 'Users.Users.Logout', 48, 49, 2, '/backend/users/users/logout', 'overAllManager', 0),
(50, 50, 'usersAdmin', 1, 16, 1, NULL, 'usersAdmin', 1),
(51, 50, 'Users.Users.Admin', 2, 3, 2, 'backend/users/users/admin', 'usersAdmin', 1),
(52, 50, 'Users.Users.Adminka', 4, 5, 2, 'backend/users/users/adminka', 'usersAdmin', 1),
(53, 50, 'Users.Users.Confirm', 6, 7, 2, 'backend/users/users/confirm', 'usersAdmin', 1),
(54, 50, 'Users.Users.Create', 8, 9, 2, 'backend/users/users/create', 'usersAdmin', 1),
(55, 50, 'Users.Users.Deactivate', 10, 11, 2, 'backend/users/users/deactivate', 'usersAdmin', 1),
(56, 50, 'Users.Users.Delete', 12, 13, 2, 'backend/users/users/delete', 'usersAdmin', 1),
(57, 50, 'Users.Users.Index', 14, 15, 2, 'backend/users/users/index', 'usersAdmin', 1),
(58, 1, 'Menugen.Sitemenu.Mainmenu', 50, 51, 2, '/backend/menugen/sitemenu/mainmenu', 'overAllManager', 0),
(59, 1, 'Menugen.Sitemenu.Index', 52, 53, 2, '/backend/menugen/sitemenu/index', 'overAllManager', 1),
(60, 1, 'Multilanguage.Source.Manage', 41, 42, 3, '/backend/multilanguage/source/manage', 'overAllManager', 1);

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
('d8tln68t4qqa38prs5imjhju55', 1390257112, 0x32663037396436303235633136326337346466386135643565633637616230615f5f69647c733a313a2231223b32663037396436303235633136326337346466386135643565633637616230615f5f6e616d657c733a353a2261646d696e223b3266303739643630323563313632633734646638613564356563363761623061726f6c657c733a353a2261646d696e223b32663037396436303235633136326337346466386135643565633637616230616c6f67696e7c733a353a2261646d696e223b32663037396436303235633136326337346466386135643565633637616230616c6173744c6f67696e7c733a31393a22323031342d30312d32302032333a33383a3438223b32663037396436303235633136326337346466386135643565633637616230615f5f7374617465737c613a333a7b733a343a22726f6c65223b623a313b733a353a226c6f67696e223b623a313b733a393a226c6173744c6f67696e223b623a313b7d32663037396436303235633136326337346466386135643565633637616230615269676874735f69735375706572757365727c623a313b32663037396436303235633136326337346466386135643565633637616230615f5f74696d656f75747c693a313339303236323837313b);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
