-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 21 2023 г., 23:28
-- Версия сервера: 5.7.39-log
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `data_base`
--

DELIMITER $$
--
-- Процедуры
--
CREATE DEFINER=`root`@`%` PROCEDURE `my_now` ()   BEGIN
  DECLARE i INT DEFAULT 3;
  WHILE i > 0 DO
	SELECT NOW();
	SET i = i - 1;
  END WHILE;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created`, `modified`) VALUES
(2, 'Антисептики', 'Вещества, способные предупредить или\r\nприостановить развитие микроорганизмов (бактерий, грибов), но не разрушающие их. (йод, фурацилин, перманганат калия)', '2023-05-18 17:13:45', '2023-05-18 14:19:49'),
(3, 'Противомикробные препараты', 'Лекарственные средства природного или полусинтетического происхождения, подавляющие рост и развитие или вызывающие гибель различных видов бактерий, хламидий, грибов, простейших, вирусов и т.д.', '2023-05-18 17:13:45', '2023-05-18 14:19:49'),
(4, 'Антибиотики', 'Органические вещества, образуемые микробами и другими более высокоразвитыми растительными веществами и организмами, обладающие способностью угнетать или убивать микробы. Получают антибиотики из культурной жидкости, в которой находятся образующие их микроорганизмы, а также синтетическим путем. Антибиотики понижают жизнеспособность микробов, нарушая у них обмен веществ.', '2023-05-18 17:13:45', '2023-05-18 14:19:49'),
(5, 'Анальгетики', 'Лекарственные препараты, которые избирательно подавляют болевые ощущения. Они способны временно снять не только боль, но и жар, мышечное напряжение. Причем, анальгетики не воздействуют на причину недомогания, а лишь облегчают состояние человека, если боль нестерпима или нарушает его жизненный ритм. Различают наркотические и ненаркотические анальгетики', '2023-05-18 17:13:45', '2023-05-18 14:19:49');

--
-- Триггеры `categories`
--
DELIMITER $$
CREATE TRIGGER `delete_category` BEFORE DELETE ON `categories` FOR EACH ROW BEGIN
	DELETE FROM items WHERE category_id=old.id; 
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `cost` float NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `image` text COLLATE utf8_unicode_ci,
  `manufacturer` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `items`
--

INSERT INTO `items` (`id`, `category_id`, `name`, `description`, `cost`, `created`, `modified`, `image`, `manufacturer`) VALUES
(1, 2, 'Средство дезинфицирующее (кожный антисептик) Перекись водорода 3 % 100 мл', 'Средство дезинфицирующее (кожный антисептик) «Перекись водорода 3 %». Обладает бактерицидной, туберкулоцидной, вирулицидной, фунгицидной и спороцидной активностью.', 1000, '2023-05-18 17:26:20', '2023-05-18 14:27:47', NULL, NULL),
(6, 2, 'Хлоргексидина биглюконат раствор дезинфицирующий 0.05% 100 мл', 'Дезинфицирующее средство (кожный антисептик).\r\n\r\nСредство проявляет бактерицидное в отношении грамположительных и грамотрицательных бактерий (в том числе в отношении возбудителей внутрибольничных инфекций), туберкулоцидное, вирулицидное (острые респираторные вирусные инфекции, герпес, полиомиелит, гепатиты всех видов, включая гепатиты А, В и С, ВИЧ-инфекция, аденовирус и др.) и фунгицидное (в отношении грибов родов Кандида и трихофитон) действие.', 20, '2023-05-18 17:33:04', '2023-05-18 14:33:58', NULL, NULL),
(7, 3, 'Фурацилин Авексима таб.шип. 20мг', 'Таблетки шипучие для приготовления раствора для местного и наружного применения от светло-желтого до желтого цвета, с вкраплениями, плоскоцилиндрической формы, с фаской на обеих сторонах.', 140, '2023-05-18 17:35:27', '2023-05-18 14:38:42', NULL, NULL),
(8, 3, 'Амоксициллин экспресс таб.дисперг. 1000мг', 'Дозировки 125 мг, 500 мг, 1000 мг: овальные двояковыпуклые таблетки от белого до светло-желтого цвета.\r\nДозировка 250 мг: овальные двояковыпуклые таблетки от белого до светло-желтого цвета с риской на одной стороне. Препарат принимают при остром бактериальном синусите, остром среднем отите, остром стрептококковом тонзиллите и фарингите, обострении хронического бронхита, внебольничной пневмонии, остром цистите, остром пиелонефрите, инфекциях протезированных суставов, болезни Лайма.', 500, '2023-05-18 17:35:27', '2023-05-18 14:38:42', NULL, NULL),
(9, 4, 'Азитромицин форте-obl таб п/об пленочной 500мг 3 шт', 'Таблетки, покрытые пленочной оболочкой светло-голубого цвета, двояковыпуклые, продолговатой формы, с риской. На поперечном разрезе видны два слоя, внутренний слой белого или почти белого цвета.\r\nВспомогательные вещества:\r\n[целлюлоза микрокристаллическая, натрия лаурилсульфат, кросповидон, гипролоза (гидроксипропилцеллюлоза), магния стеарат]; вспомогательные вещества для оболочки Опадрай II (серия 85): [спирт поливиниловый; макрогол (полиэтиленгликоль); тальк; титана диоксид; алюминиевый лак на основе красителя индигокармина; железа оксид желтый].', 120, '2023-05-18 17:55:26', '2023-05-18 15:01:43', NULL, NULL),
(10, 4, 'Флемоксин солютаб таб дисперг. 1000мг 20 шт', 'Антибиотик, пенициллин полусинтетический.\r\nВспомогательные вещества:\r\nДиспергируемая целлюлоза, микрокристаллическая целлюлоза, кросповидон, ванилин, ароматизатор мандариновый, ароматизатор лимонный, сахарин, магния стеарат.', 550, '2023-05-18 17:55:26', '2023-05-18 15:01:43', NULL, NULL),
(11, 5, 'Пенталгин обезболивающее таб. 24 шт.', 'Обойдемся без боли! Пенталгин® — запатентованный обезболивающий пятикомпонентный препарат, обладающий выраженным анальгетическим действием, избавляющий от спазма и снимающий воспаление.\r\n\r\nУсиливает обезболивающий эффект за счет комбинации действующих компонентов;\r\nОдновременно воздействует на различные этапы формирования болевого синдрома;\r\nСниженные дозы основных обезболивающих компонентов по сравнению с монопрепаратами;\r\nОбладает комплексным действием: это одновременно обезболивающее, противовоспалительное, спазмолитическое и жаропонижающее;\r\nКупирует боль различного генеза;\r\nТаблетки в пленочной оболочке удобнее проглатывать, обеспечивается лучшая стабильность действующих веществ.\r\n\r\nТаблетки, покрытые пленочной оболочкой от светло-зеленого до зеленого цвета, двояковыпуклые в форме капсулы со скошенными краями, с риской на одной стороне и тиснением PENTALGIN на другой. На поперечном разрезе ядро светло-зеленого цвета с белыми вкраплениями\r\n', 170, '2023-05-18 18:02:02', '2023-05-18 15:04:53', NULL, NULL),
(12, 5, 'Нурофен Экспресс Форте капс 400мг 10 шт', 'Капсула с жидким действующим веществом в двойной концентрации*, которое всасывается быстрее**, чем обычные таблетки**. Воздействует прямо на источник боли, помогая избавиться от нее.\r\n\r\n*По сравнению с Нурофен® Экспресс в форме капсул (200мг), РУ № П N014560/01;** Максимальная концентрация ибупрофена в плазме крови достигается быстрее, чем после приема эквивалентной дозы препарата Нурофен®, таблетки, покрытые оболочкой, 400 мг. Инструкция по применению Нурофен® Экспресс Форте, капсулы 400 мг, РУ П N0 ЛСР-005587/10;**Обычные таблетки – Нурофен® Форте в форме таблеток, покрытых оболочкой (400 мг), РУ, № П N016033/01.\r\n\r\nКапсулы мягкие желатиновые, овальные, полупрозрачные, красного цвета, с идентифицирующей надписью \"NUROFEN\" белого цвета; содержимое капсул - прозрачная жидкость от бесцветного до светло-розового цвета.', 150, '2023-05-18 18:02:02', '2023-05-18 15:04:53', NULL, NULL),
(13, 2, 'Гель для рук с антибактериальными компонентами 96 мл Spring', 'Гель для рук гигиенический с антибактериальными компонентами со смягчающим эффектом. Незаменимое средство для очистки рук при отсутствии воды: в транспорте, магазинах, учебных заведениях, спортзалах, предприятиях общепита, путешествиях, после контакта с животными.', 75, '2023-05-21 23:23:53', '2023-05-21 20:23:53', NULL, 'СПРИНГ ГРУП');

--
-- Триггеры `items`
--
DELIMITER $$
CREATE TRIGGER `delete_item` BEFORE DELETE ON `items` FOR EACH ROW BEGIN
	DELETE FROM storage WHERE item_id = old.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_create` datetime DEFAULT CURRENT_TIMESTAMP,
  `items` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `pharmacy`
--

CREATE TABLE `pharmacy` (
  `id` int(11) NOT NULL,
  `city` varchar(30) NOT NULL,
  `street` varchar(50) NOT NULL,
  `num_house` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pharmacy`
--

INSERT INTO `pharmacy` (`id`, `city`, `street`, `num_house`) VALUES
(1, 'Пермь', 'Пушкина', '10'),
(2, 'Пермь', 'Ленина', '101');

-- --------------------------------------------------------

--
-- Структура таблицы `storage`
--

CREATE TABLE `storage` (
  `id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `pharmacy_id` int(11) NOT NULL,
  `count` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `storage`
--

INSERT INTO `storage` (`id`, `item_id`, `pharmacy_id`, `count`) VALUES
(5, 8, 1, 100),
(6, 8, 2, 100),
(7, 9, 1, 100),
(8, 9, 2, 100),
(9, 12, 1, 100),
(10, 12, 2, 100),
(11, 11, 1, 100),
(12, 11, 2, 100),
(13, 1, 1, NULL),
(14, 1, 2, 100),
(15, 10, 1, 100),
(16, 10, 2, 100),
(17, 7, 1, 100),
(18, 7, 2, 100),
(19, 6, 1, 100),
(20, 6, 2, 100),
(21, 13, 1, 100),
(22, 13, 2, 100);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `login` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `user_hash` varchar(32) NOT NULL DEFAULT '',
  `ip` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `fio` varchar(50) NOT NULL,
  `num_phone` varchar(50) DEFAULT NULL,
  `image` text,
  `rol` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `user_hash`, `ip`, `fio`, `num_phone`, `image`, `rol`) VALUES
(4, 'krasilkoff', '0773f7e5d21714681d9ff4394c6d4997', '4fffda4d8a3a18d5d24a311dd72fdc11', 2130706433, 'dsda', '233232', '', 'admin'),
(7, 'test', 'e08a7c49d96c2b475656cc8fe18cee8e', '', 0, 'Vadim', '123323', NULL, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `pharmacy`
--
ALTER TABLE `pharmacy`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `storage`
--
ALTER TABLE `storage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `storage_ibfk_2` (`pharmacy_id`),
  ADD KEY `item_id` (`item_id`) USING BTREE;

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `pharmacy`
--
ALTER TABLE `pharmacy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `storage`
--
ALTER TABLE `storage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Ограничения внешнего ключа таблицы `storage`
--
ALTER TABLE `storage`
  ADD CONSTRAINT `storage_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `storage_ibfk_2` FOREIGN KEY (`pharmacy_id`) REFERENCES `pharmacy` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
