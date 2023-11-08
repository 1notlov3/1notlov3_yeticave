-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 12 2023 г., 00:35
-- Версия сервера: 8.0.30
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `yeti321`
--

-- --------------------------------------------------------

--
-- Структура таблицы `bets`
--

CREATE TABLE `bets` (
  `id` bigint NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` bigint NOT NULL,
  `lot_id` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` bigint NOT NULL,
  `title` varchar(255) NOT NULL,
  `code` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `title`, `code`) VALUES
(1, 'Доски и лыжи', 'boards'),
(2, 'Крепления', 'attachment'),
(3, 'Ботинки', 'boots'),
(4, 'Одежда', 'clothing'),
(5, 'Инструменты', 'tools'),
(6, 'Разное', 'other');

-- --------------------------------------------------------

--
-- Структура таблицы `lots`
--

CREATE TABLE `lots` (
  `id` bigint NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `img_url` varchar(255) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `step` decimal(10,0) NOT NULL,
  `date_end` datetime NOT NULL,
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author_id` bigint NOT NULL,
  `category_id` bigint NOT NULL,
  `winner_id` bigint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `lots`
--

INSERT INTO `lots` (`id`, `title`, `description`, `img_url`, `price`, `step`, `date_end`, `date_create`, `author_id`, `category_id`, `winner_id`) VALUES
(1, '2014 Rossignol District Snowboard\"', '', 'img/lot-1.jpg', '120000', '1000', '2023-10-12 20:10:00', '2023-09-30 21:00:00', 1, 1, 2),
(2, 'DC Ply Mens 2016/2017 Snowboard', '', 'img/lot-2.jpg', '159999', '1000', '2023-10-13 21:20:00', '2023-10-03 17:19:41', 1, 1, 2),
(3, 'Крепления Union Contact Pro 2015 года размер L/XL', '', 'img/lot-3.jpg', '8000', '1000', '2023-10-14 22:10:00', '2023-10-03 17:19:41', 1, 2, 2),
(4, 'Ботинки для сноуборда DC Mutiny Charocal', '', 'img/lot-4.jpg', '10999', '1000', '2023-10-13 23:11:00', '2023-10-03 17:19:41', 1, 3, 2),
(5, 'Куртка для сноуборда DC Mutiny Charocal', '', 'img/lot-5.jpg', '7500', '1000', '2023-10-15 03:10:00', '2023-10-03 17:19:41', 1, 4, 2),
(6, 'Маска Oakley Canopy', '', 'img/lot-6.jpg', '5400', '1000', '2023-10-16 17:00:00', '2023-10-03 20:20:00', 1, 6, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contacts` text NOT NULL,
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `password`, `contacts`, `date_create`) VALUES
(1, 'lolxd@gmail.com', 'maxon', 'admin', '79998887967', '2023-10-03 16:22:13'),
(2, 'puriruri@gmail.com', 'sevka', 'bezdar', '86769979793', '2023-10-03 16:22:13');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `bets`
--
ALTER TABLE `bets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bets_users1_idx` (`user_id`),
  ADD KEY `fk_bets_lots1_idx` (`lot_id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title_UNIQUE` (`title`);

--
-- Индексы таблицы `lots`
--
ALTER TABLE `lots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_lots_users_idx` (`author_id`),
  ADD KEY `fk_lots_categories1_idx` (`category_id`),
  ADD KEY `fk_lots_users1_idx` (`winner_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `lots`
--
ALTER TABLE `lots`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `bets`
--
ALTER TABLE `bets`
  ADD CONSTRAINT `fk_bets_lots1` FOREIGN KEY (`lot_id`) REFERENCES `lots` (`id`),
  ADD CONSTRAINT `fk_bets_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `lots`
--
ALTER TABLE `lots`
  ADD CONSTRAINT `fk_lots_categories1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `fk_lots_users` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_lots_users1` FOREIGN KEY (`winner_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
