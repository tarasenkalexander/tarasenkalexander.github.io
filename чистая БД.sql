-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Май 04 2020 г., 15:54
-- Версия сервера: 10.3.22-MariaDB-cll-lve
-- Версия PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `wswby_asabliva`
--

-- --------------------------------------------------------

--
-- Структура таблицы `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `authors` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `data` varchar(4) DEFAULT NULL,
  `lang` int(1) DEFAULT NULL,
  `class` int(2) DEFAULT NULL,
  `category` int(2) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `addon` varchar(255) DEFAULT NULL,
  `fix` int(1) NOT NULL DEFAULT 0,
  `note` varchar(255) DEFAULT NULL,
  `on` tinyint(1) NOT NULL DEFAULT 0,
  `dcount` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- --------------------------------------------------------

--
-- Структура таблицы `books_backup`
--

CREATE TABLE `books_backup` (
  `id` int(11) NOT NULL,
  `authors` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `data` varchar(4) DEFAULT NULL,
  `lang` int(1) DEFAULT NULL,
  `class` int(2) DEFAULT NULL,
  `category` int(2) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `addon` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `on` tinyint(1) NOT NULL DEFAULT 0,
  `dcount` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `path` (`path`);

--
-- Индексы таблицы `books_backup`
--
ALTER TABLE `books_backup`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `path` (`path`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=811;

--
-- AUTO_INCREMENT для таблицы `books_backup`
--
ALTER TABLE `books_backup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=719;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
