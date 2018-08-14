-- phpMyAdmin SQL Dump
-- version 4.7.8
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Авг 14 2018 г., 16:46
-- Версия сервера: 5.7.22-log
-- Версия PHP: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `ourcrm`
--

-- --------------------------------------------------------

--
-- Структура таблицы `client`
--

CREATE TABLE `client` (
  `id_client` bigint(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `comment` text NOT NULL,
  `id_manager` bigint(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `client`
--

INSERT INTO `client` (`id_client`, `name`, `created`, `comment`, `id_manager`) VALUES
(1, 'Николай', NULL, 'Встретил во дворе', 1),
(2, 'Вова', NULL, 'познакомился на конференции', 2),
(3, 'Сергей', '2018-07-25 21:15:11', 'Встретил в кафе', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `department`
--

CREATE TABLE `department` (
  `id_department` bigint(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `department`
--

INSERT INTO `department` (`id_department`, `name`) VALUES
(1, 'Отдел продаж'),
(3, 'отдел тестирования'),
(4, 'отдел разработки');

-- --------------------------------------------------------

--
-- Структура таблицы `event`
--

CREATE TABLE `event` (
  `id_event` bigint(11) UNSIGNED NOT NULL,
  `message` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `assignment` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link` tinyint(3) UNSIGNED DEFAULT NULL,
  `id_link` bigint(11) UNSIGNED DEFAULT NULL,
  `id_manager` bigint(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `event`
--

INSERT INTO `event` (`id_event`, `message`, `created`, `assignment`, `link`, `id_link`, `id_manager`) VALUES
(1, 'cofee', '2018-08-09 15:32:19', '2018-08-10 07:00:00', 1, 2, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `manager`
--

CREATE TABLE `manager` (
  `id_manager` bigint(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `id_department` bigint(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `manager`
--

INSERT INTO `manager` (`id_manager`, `name`, `id_department`) VALUES
(1, 'Вася', 1),
(2, 'Петя', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `project`
--

CREATE TABLE `project` (
  `id_project` bigint(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `id_client` bigint(11) UNSIGNED NOT NULL,
  `id_manager` bigint(11) UNSIGNED NOT NULL,
  `comment` text NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `project`
--

INSERT INTO `project` (`id_project`, `name`, `id_client`, `id_manager`, `comment`, `is_active`) VALUES
(1, 'написать сайт для Вовы', 2, 1, 'че-нить придумать', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `service`
--

CREATE TABLE `service` (
  `id_service` bigint(11) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `cost` float(8,2) DEFAULT NULL,
  `is_enable` tinyint(3) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `servicelist`
--

CREATE TABLE `servicelist` (
  `id_servicelist` bigint(11) UNSIGNED NOT NULL,
  `id_serviceset` bigint(11) UNSIGNED NOT NULL,
  `id_service` bigint(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `serviceset`
--

CREATE TABLE `serviceset` (
  `id_serviceset` bigint(11) UNSIGNED NOT NULL,
  `id_project` bigint(11) UNSIGNED NOT NULL,
  `id_state` bigint(11) UNSIGNED NOT NULL,
  `delivery` date NOT NULL,
  `payment` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `state`
--

CREATE TABLE `state` (
  `id_state` bigint(11) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` bigint(11) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `auth_key` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`) VALUES
(3, 'admin', 'kFmKfzdkSt6ocjVu2iTWGJpnF_cnyvrV', '$2y$13$eC8indj0TKQfwWmsDqGfXemXJfTjL97BNb9nqLxfSsAXKjLAw83LK', NULL, 'admin@ourcrm.ru', 10, 1534264094, 1534264094);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id_client`),
  ADD KEY `id_manager` (`id_manager`);

--
-- Индексы таблицы `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id_department`);

--
-- Индексы таблицы `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id_event`),
  ADD KEY `fk_id_manager3` (`id_manager`);

--
-- Индексы таблицы `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`id_manager`),
  ADD KEY `id_department` (`id_department`);

--
-- Индексы таблицы `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id_project`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `id_manager` (`id_manager`);

--
-- Индексы таблицы `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id_service`);

--
-- Индексы таблицы `servicelist`
--
ALTER TABLE `servicelist`
  ADD PRIMARY KEY (`id_servicelist`),
  ADD KEY `id_service` (`id_serviceset`),
  ADD KEY `fk_id_service` (`id_service`);

--
-- Индексы таблицы `serviceset`
--
ALTER TABLE `serviceset`
  ADD PRIMARY KEY (`id_serviceset`),
  ADD KEY `fk_id_project` (`id_project`),
  ADD KEY `fk_id_state` (`id_state`);

--
-- Индексы таблицы `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`id_state`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `client`
--
ALTER TABLE `client`
  MODIFY `id_client` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `department`
--
ALTER TABLE `department`
  MODIFY `id_department` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `event`
--
ALTER TABLE `event`
  MODIFY `id_event` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `manager`
--
ALTER TABLE `manager`
  MODIFY `id_manager` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `project`
--
ALTER TABLE `project`
  MODIFY `id_project` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `service`
--
ALTER TABLE `service`
  MODIFY `id_service` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `servicelist`
--
ALTER TABLE `servicelist`
  MODIFY `id_servicelist` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `serviceset`
--
ALTER TABLE `serviceset`
  MODIFY `id_serviceset` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `state`
--
ALTER TABLE `state`
  MODIFY `id_state` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `fk_id_manager` FOREIGN KEY (`id_manager`) REFERENCES `manager` (`id_manager`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `fk_id_manager3` FOREIGN KEY (`id_manager`) REFERENCES `manager` (`id_manager`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `manager`
--
ALTER TABLE `manager`
  ADD CONSTRAINT `fk_id_department` FOREIGN KEY (`id_department`) REFERENCES `department` (`id_department`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `fk_id_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_manager2` FOREIGN KEY (`id_manager`) REFERENCES `manager` (`id_manager`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `servicelist`
--
ALTER TABLE `servicelist`
  ADD CONSTRAINT `fk_id_service` FOREIGN KEY (`id_service`) REFERENCES `service` (`id_service`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_serviceset` FOREIGN KEY (`id_serviceset`) REFERENCES `serviceset` (`id_serviceset`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `serviceset`
--
ALTER TABLE `serviceset`
  ADD CONSTRAINT `fk_id_project` FOREIGN KEY (`id_project`) REFERENCES `project` (`id_project`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_state` FOREIGN KEY (`id_state`) REFERENCES `state` (`id_state`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
