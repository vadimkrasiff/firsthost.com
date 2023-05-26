-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 26 2023 г., 17:00
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
(1, 2, 'Средство дезинфицирующее (кожный антисептик) Перекись водорода 3 % 100 мл', 'Средство дезинфицирующее (кожный антисептик) «Перекись водорода 3 %». Обладает бактерицидной, туберкулоцидной, вирулицидной, фунгицидной и спороцидной активностью.', 1000, '2023-05-18 17:26:20', '2023-05-18 14:27:47', NULL, 'ЭКОТЕКС'),
(6, 2, 'Хлоргексидина биглюконат раствор дезинфицирующий 0.05% 100 мл', 'Дезинфицирующее средство (кожный антисептик).\r\n\r\nСредство проявляет бактерицидное в отношении грамположительных и грамотрицательных бактерий (в том числе в отношении возбудителей внутрибольничных инфекций), туберкулоцидное, вирулицидное (острые респираторные вирусные инфекции, герпес, полиомиелит, гепатиты всех видов, включая гепатиты А, В и С, ВИЧ-инфекция, аденовирус и др.) и фунгицидное (в отношении грибов родов Кандида и трихофитон) действие.', 20, '2023-05-18 17:33:04', '2023-05-18 14:33:58', NULL, NULL),
(7, 3, 'Фурацилин Авексима таб.шип. 20мг', 'Таблетки шипучие для приготовления раствора для местного и наружного применения от светло-желтого до желтого цвета, с вкраплениями, плоскоцилиндрической формы, с фаской на обеих сторонах.', 140, '2023-05-18 17:35:27', '2023-05-18 14:38:42', NULL, NULL),
(8, 3, 'Амоксициллин экспресс таб.дисперг. 1000мг', 'Дозировки 125 мг, 500 мг, 1000 мг: овальные двояковыпуклые таблетки от белого до светло-желтого цвета.\r\nДозировка 250 мг: овальные двояковыпуклые таблетки от белого до светло-желтого цвета с риской на одной стороне. Препарат принимают при остром бактериальном синусите, остром среднем отите, остром стрептококковом тонзиллите и фарингите, обострении хронического бронхита, внебольничной пневмонии, остром цистите, остром пиелонефрите, инфекциях протезированных суставов, болезни Лайма.', 500, '2023-05-18 17:35:27', '2023-05-18 14:38:42', NULL, NULL),
(9, 4, 'Азитромицин форте-obl таб п/об пленочной 500мг 3 шт', 'Таблетки, покрытые пленочной оболочкой светло-голубого цвета, двояковыпуклые, продолговатой формы, с риской. На поперечном разрезе видны два слоя, внутренний слой белого или почти белого цвета.\r\nВспомогательные вещества:\r\n[целлюлоза микрокристаллическая, натрия лаурилсульфат, кросповидон, гипролоза (гидроксипропилцеллюлоза), магния стеарат]; вспомогательные вещества для оболочки Опадрай II (серия 85): [спирт поливиниловый; макрогол (полиэтиленгликоль); тальк; титана диоксид; алюминиевый лак на основе красителя индигокармина; железа оксид желтый].', 120, '2023-05-18 17:55:26', '2023-05-18 15:01:43', NULL, NULL),
(10, 4, 'Флемоксин солютаб таб дисперг. 1000мг 20 шт', 'Антибиотик, пенициллин полусинтетический.\r\nВспомогательные вещества:\r\nДиспергируемая целлюлоза, микрокристаллическая целлюлоза, кросповидон, ванилин, ароматизатор мандариновый, ароматизатор лимонный, сахарин, магния стеарат.', 550, '2023-05-18 17:55:26', '2023-05-18 15:01:43', NULL, NULL),
(11, 5, 'Пенталгин обезболивающее таб. 24 шт.', 'Обойдемся без боли! Пенталгин® — запатентованный обезболивающий пятикомпонентный препарат, обладающий выраженным анальгетическим действием, избавляющий от спазма и снимающий воспаление.\r\n\r\nУсиливает обезболивающий эффект за счет комбинации действующих компонентов;\r\nОдновременно воздействует на различные этапы формирования болевого синдрома;\r\nСниженные дозы основных обезболивающих компонентов по сравнению с монопрепаратами;\r\nОбладает комплексным действием: это одновременно обезболивающее, противовоспалительное, спазмолитическое и жаропонижающее;\r\nКупирует боль различного генеза;\r\nТаблетки в пленочной оболочке удобнее проглатывать, обеспечивается лучшая стабильность действующих веществ.\r\n\r\nТаблетки, покрытые пленочной оболочкой от светло-зеленого до зеленого цвета, двояковыпуклые в форме капсулы со скошенными краями, с риской на одной стороне и тиснением PENTALGIN на другой. На поперечном разрезе ядро светло-зеленого цвета с белыми вкраплениями\r\n', 170, '2023-05-18 18:02:02', '2023-05-18 15:04:53', NULL, NULL),
(12, 5, 'Нурофен Экспресс Форте капс 400мг 10 шт', 'Капсула с жидким действующим веществом в двойной концентрации*, которое всасывается быстрее**, чем обычные таблетки**. Воздействует прямо на источник боли, помогая избавиться от нее.\r\n\r\n*По сравнению с Нурофен® Экспресс в форме капсул (200мг), РУ № П N014560/01;** Максимальная концентрация ибупрофена в плазме крови достигается быстрее, чем после приема эквивалентной дозы препарата Нурофен®, таблетки, покрытые оболочкой, 400 мг. Инструкция по применению Нурофен® Экспресс Форте, капсулы 400 мг, РУ П N0 ЛСР-005587/10;**Обычные таблетки – Нурофен® Форте в форме таблеток, покрытых оболочкой (400 мг), РУ, № П N016033/01.\r\n\r\nКапсулы мягкие желатиновые, овальные, полупрозрачные, красного цвета, с идентифицирующей надписью \"NUROFEN\" белого цвета; содержимое капсул - прозрачная жидкость от бесцветного до светло-розового цвета.', 150, '2023-05-18 18:02:02', '2023-05-18 15:04:53', NULL, NULL),
(13, 2, 'Гель для рук с антибактериальными компонентами 96 мл Spring', 'Гель для рук гигиенический с антибактериальными компонентами со смягчающим эффектом. Незаменимое средство для очистки рук при отсутствии воды: в транспорте, магазинах, учебных заведениях, спортзалах, предприятиях общепита, путешествиях, после контакта с животными.', 75, '2023-05-21 23:23:53', '2023-05-21 20:23:53', NULL, 'СПРИНГ ГРУП'),
(14, 2, 'Средство дезинфицирующее (кожный антисептик) Перекись водорода 3 % 100 мл', 'Средство дезинфицирующее (кожный антисептик) «Перекись водорода 3 %». Обладает бактерицидной, туберкулоцидной, вирулицидной, фунгицидной и спороцидной активностью.', 1000, '2023-05-22 17:12:47', '2023-05-22 14:12:47', NULL, 'ЭКОТЕКС');

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
  `worker_id` int(11) DEFAULT NULL,
  `date_create` datetime DEFAULT CURRENT_TIMESTAMP,
  `sum` float DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `worker_id`, `date_create`, `sum`) VALUES
(1, 1, '2023-05-25 17:41:25', 2200),
(14, 1, '2023-05-26 16:55:04', 120),
(15, 1, '2023-05-26 16:57:42', 1180);

--
-- Триггеры `orders`
--
DELIMITER $$
CREATE TRIGGER `delete_orders` BEFORE DELETE ON `orders` FOR EACH ROW DELETE from sub_order
WHERE order_id = old.id
$$
DELIMITER ;

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
  `count` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `storage`
--

INSERT INTO `storage` (`id`, `item_id`, `pharmacy_id`, `count`) VALUES
(5, 8, 1, 99),
(6, 8, 2, 100),
(7, 9, 1, 85),
(8, 9, 2, 100),
(9, 12, 1, 100),
(10, 12, 2, 100),
(11, 11, 1, 100),
(12, 11, 2, 100),
(13, 1, 1, 0),
(14, 1, 2, 100),
(15, 10, 1, 100),
(16, 10, 2, 100),
(17, 7, 1, 94),
(18, 7, 2, 100),
(19, 6, 1, 98),
(20, 6, 2, 100),
(21, 13, 1, 99),
(22, 13, 2, 100),
(23, 14, 1, 100),
(24, 14, 2, 100);

-- --------------------------------------------------------

--
-- Структура таблицы `sub_order`
--

CREATE TABLE `sub_order` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `count` int(11) NOT NULL,
  `sum` float DEFAULT '0',
  `pharmacy_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `sub_order`
--

INSERT INTO `sub_order` (`id`, `item_id`, `order_id`, `count`, `sum`, `pharmacy_id`) VALUES
(2, 8, 1, 2, 1000, 1),
(3, 9, 1, 10, 1200, 1),
(8, 9, 14, 1, 120, 1),
(9, 7, 15, 5, 700, 1),
(10, 9, 15, 4, 480, 1);

--
-- Триггеры `sub_order`
--
DELIMITER $$
CREATE TRIGGER `insert_sub_order` BEFORE INSERT ON `sub_order` FOR EACH ROW BEGIN
UPDATE orders
set sum = sum + new.sum
where id = new.order_id;
UPDATE storage
set count= count - new.count
WHERE pharmacy_id = new.pharmacy_id AND
item_id = new.item_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `users_cpoy`
--

CREATE TABLE `users_cpoy` (
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
-- Дамп данных таблицы `users_cpoy`
--

INSERT INTO `users_cpoy` (`id`, `login`, `password`, `user_hash`, `ip`, `fio`, `num_phone`, `image`, `rol`) VALUES
(4, 'krasilkoff', '0773f7e5d21714681d9ff4394c6d4997', '8ee9573ce4ab9bd401d2c77c72411f81', 2130706433, 'dsda', '233232', NULL, 'admin'),
(7, 'test', 'e08a7c49d96c2b475656cc8fe18cee8e', '', 0, 'Vadim', '123323', NULL, 'worker');

-- --------------------------------------------------------

--
-- Структура таблицы `worker`
--

CREATE TABLE `worker` (
  `id` int(11) NOT NULL,
  `login` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `user_hash` varchar(32) NOT NULL DEFAULT '',
  `ip` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `fio` varchar(50) NOT NULL,
  `num_phone` varchar(50) DEFAULT NULL,
  `image` text,
  `rol` varchar(10) DEFAULT 'worker',
  `pharmacy_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `worker`
--

INSERT INTO `worker` (`id`, `login`, `password`, `user_hash`, `ip`, `fio`, `num_phone`, `image`, `rol`, `pharmacy_id`) VALUES
(1, 'krasilkoff', '0773f7e5d21714681d9ff4394c6d4997', 'b9cad2d9be87b52c04f120384623dd1b', 2130706433, 'Красильников В. И.', '89504677438', NULL, 'admin', 1),
(2, 'test', 'e08a7c49d96c2b475656cc8fe18cee8e', '', 0, 'Красильников В. И.', '89504677438', NULL, 'worker', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `worker1`
--

CREATE TABLE `worker1` (
  `id` int(11) NOT NULL,
  `login` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `user_hash` varchar(32) NOT NULL DEFAULT '',
  `ip` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `fio` varchar(50) NOT NULL,
  `num_phone` varchar(50) DEFAULT NULL,
  `image` text,
  `rol` varchar(10) DEFAULT 'worker',
  `pharmacy_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

--
-- Дамп данных таблицы `worker1`
--

INSERT INTO `worker1` (`id`, `login`, `password`, `user_hash`, `ip`, `fio`, `num_phone`, `image`, `rol`, `pharmacy_id`) VALUES
(1, 'krasilkoff', '0773f7e5d21714681d9ff4394c6d4997', '929dfef4255d228509b12f471eff646f', 2130706433, 'dsda', '233232', NULL, 'admin', 1),
(2, 'test', 'e08a7c49d96c2b475656cc8fe18cee8e', '3b221f23659e62c672acd12f8f31a6a5', 2130706433, 'Vadim', '123323', NULL, 'worker', 2);

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
  ADD KEY `items_ibfk_1` (`category_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `user_id` (`worker_id`);

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
-- Индексы таблицы `sub_order`
--
ALTER TABLE `sub_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_order_ibfk_1` (`item_id`),
  ADD KEY `sub_order_ibfk_2` (`order_id`),
  ADD KEY `pharmacy_id` (`pharmacy_id`);

--
-- Индексы таблицы `users_cpoy`
--
ALTER TABLE `users_cpoy`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `worker`
--
ALTER TABLE `worker`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pharmacy_id` (`pharmacy_id`);

--
-- Индексы таблицы `worker1`
--
ALTER TABLE `worker1`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pharmacy_id` (`pharmacy_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `pharmacy`
--
ALTER TABLE `pharmacy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `storage`
--
ALTER TABLE `storage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `sub_order`
--
ALTER TABLE `sub_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `users_cpoy`
--
ALTER TABLE `users_cpoy`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `worker`
--
ALTER TABLE `worker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `worker1`
--
ALTER TABLE `worker1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`worker_id`) REFERENCES `worker` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `storage`
--
ALTER TABLE `storage`
  ADD CONSTRAINT `storage_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `storage_ibfk_2` FOREIGN KEY (`pharmacy_id`) REFERENCES `pharmacy` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `sub_order`
--
ALTER TABLE `sub_order`
  ADD CONSTRAINT `sub_order_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sub_order_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sub_order_ibfk_3` FOREIGN KEY (`pharmacy_id`) REFERENCES `pharmacy` (`id`);

--
-- Ограничения внешнего ключа таблицы `worker`
--
ALTER TABLE `worker`
  ADD CONSTRAINT `worker_ibfk_1` FOREIGN KEY (`pharmacy_id`) REFERENCES `pharmacy` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
