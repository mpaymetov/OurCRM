-- phpMyAdmin SQL Dump
-- version 4.7.8
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Сен 04 2018 г., 17:00
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
-- Структура таблицы `role`
--

CREATE TABLE `role` (
  `id_role` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_admin` tinyint(3) UNSIGNED NOT NULL,
  `user_read_all` tinyint(3) UNSIGNED NOT NULL,
  `user_self_dep` tinyint(3) UNSIGNED NOT NULL,
  `user_create` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `client_read_all` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `client_create` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `project_read_all` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `project_create` tinyint(3) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `role`
--

INSERT INTO `role` (`id_role`, `name`, `is_admin`, `user_read_all`, `user_self_dep`, `user_create`, `client_read_all`, `client_create`, `project_read_all`, `project_create`) VALUES
(1, 'Администратор', 1, 1, 0, 1, 1, 0, 0, 0),
(2, 'Менеджер продаж услуг', 0, 0, 1, 0, 0, 1, 0, 0),
(3, 'Старший менеджер', 0, 1, 0, 0, 1, 1, 0, 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `role`
--
ALTER TABLE `role`
  MODIFY `id_role` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
