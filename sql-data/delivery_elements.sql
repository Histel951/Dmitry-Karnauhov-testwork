-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 12 2022 г., 05:03
-- Версия сервера: 8.0.24
-- Версия PHP: 8.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `delivery`
--

-- --------------------------------------------------------

--
-- Структура таблицы `delivery_elements`
--

CREATE TABLE `delivery_elements` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` float DEFAULT '0',
  `date` date DEFAULT NULL,
  `company_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `delivery_elements`
--

INSERT INTO `delivery_elements` (`id`, `name`, `price`, `date`, `company_id`) VALUES
(1, 'el 1', 10, '2022-04-23', 1),
(2, 'el 2', 15, '2022-04-22', 2),
(3, 'el 3', 25, '2022-04-29', 1),
(4, 'el 4', 90, '2022-04-25', 2),
(5, 'el 5', 90, '2022-04-25', 2),
(6, 'el 6', 90, '2022-04-25', 1),
(7, 'el 7', 90, '2022-04-14', 1),
(8, 'el 8', 90, '2022-04-13', 1),
(9, 'el 9', 10, '2022-04-12', 1),
(10, 'el 10', 0, '2022-04-12', 2);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `delivery_elements`
--
ALTER TABLE `delivery_elements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `delivery_elements`
--
ALTER TABLE `delivery_elements`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `delivery_elements`
--
ALTER TABLE `delivery_elements`
  ADD CONSTRAINT `delivery_elements_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
