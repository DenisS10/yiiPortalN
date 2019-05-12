-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 13 2019 г., 00:10
-- Версия сервера: 5.6.41
-- Версия PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `portal_notary`
--

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL,
  `creation_date` int(10) NOT NULL,
  `modify_date` int(10) NOT NULL,
  `is_notary` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `creation_date`, `modify_date`, `is_notary`) VALUES
(14, 'fad', '$2y$13$Lkbpm1.hjkPkXaP2Q8tP4u8JH1GlB9UlL0Zd64CKmWYTl6dhL0z2u', 1557069513, 0, 0),
(15, 'das', '$2y$13$JyAvs.t4C7KBmAcVinSq7elEksNp6wx345VtU7DvPbMzzcC2vyTrK', 1557069529, 0, 1),
(16, 'den', '$2y$13$e2pIxGgB3zZBD7prKSQSeelmciK72QVO5v6EnmVaPG37guurhoS/a', 1557141817, 0, 1),
(17, 'das', '$2y$13$9RhcyGdUpHlM6e1fV0suEui8gDxky3RB7NxKz4Tmq4i8TR3n5LxSa', 1557409286, 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `work_list`
--

CREATE TABLE `work_list` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_key` varchar(10) NOT NULL,
  `file_link` varchar(250) NOT NULL,
  `name` varchar(50) NOT NULL,
  `sur_name` varchar(50) NOT NULL,
  `creation_date` int(10) NOT NULL,
  `modify_date` int(10) NOT NULL,
  `deadline_date` int(10) NOT NULL,
  `notary_name` varchar(50) NOT NULL,
  `is_accepted` int(1) NOT NULL,
  `extension` varchar(10) NOT NULL,
  `is_deleted` int(1) NOT NULL,
  `notary_id` int(11) NOT NULL,
  `is_ready` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `work_list`
--

INSERT INTO `work_list` (`id`, `user_id`, `file_key`, `file_link`, `name`, `sur_name`, `creation_date`, `modify_date`, `deadline_date`, `notary_name`, `is_accepted`, `extension`, `is_deleted`, `notary_id`, `is_ready`) VALUES
(48, 15, 'b43ad22a', '../uploads/b/4/b43ad22a6cd350ca052d7c2ac741e357', 'dasdsa', 'dasdasd', 1557657521, 1557657613, 1636618260, 'no notary', 0, 'pdf', 1, 0, 0),
(49, 15, 'ecb9c216', '../uploads/e/c/ecb9c216909de8d7cbd9a8c13c029d59', 'Alex', 'abd', 1557657597, 1557659594, 1636618260, 'das', 1, 'pdf', 0, 15, 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`,`login`);

--
-- Индексы таблицы `work_list`
--
ALTER TABLE `work_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_list_users_id_fk` (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `work_list`
--
ALTER TABLE `work_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `work_list`
--
ALTER TABLE `work_list`
  ADD CONSTRAINT `work_list_users_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
