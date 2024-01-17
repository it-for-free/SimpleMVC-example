-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 11, 2024 at 07:12 AM
-- Server version: 8.0.35-0ubuntu0.22.04.1
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE `articles` (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `categoryId` smallint(5) UNSIGNED NOT NULL,
  `subcategoryId` smallint(5) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `summary` text NOT NULL,
  `content` mediumtext NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `publicationDate` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `publicationDate`, `categoryId`, `subcategoryId`, `title`, `summary`, `content`, `active`) VALUES
(1, '2017-06-21', 1, 1, 'Первопроходцы ', 'Это статья - первопроходец', 'Первопроходец - человек(или статья), проложивший новые пути, открывший новые земли', 1),
(2, '2017-06-21', 1, NULL, 'Неведомые земли', 'Каждый человек хотя бы раз просыпался с утра с будоражащим чувством, что сегодня он не вернётся домой. ', 'Не так сложно отправиться в путь, как решиться на это. Лишь немногие посвятили свою жизнь познанию, изучению тайн нашей планеты. И ещё меньше тех, о ком мы знаем это наверняка. Но несмотря на это, они шли вперёд, и вклад их в общее дело велик. ', 1),
(3, '2017-06-21', 1, NULL, 'Х. Колумб', 'Это итальянский мореплаватель, в 1492 году открывший для европейцев Америку, благодаря снаряжению экспедиций католическими королями.', 'Колумб первым из достоверно известных путешественников пересёк Атлантический океан в субтропической и тропической полосе северного полушария и первым из европейцев ходил в Карибском море и Саргассово море [2]. Он открыл и положил начало исследованию Южной и Центральной Америки, включая их континентальные части и близлежащие архипелаги — Большие Антильские (Куба, Гаити, Ямайка и Пуэрто-Рико), Малые Антильские (от Доминики до Виргинских островов, а также Тринидад) и Багамские острова.\r\n\r\nПервооткрывателем Америки Колумба можно назвать с оговорками, ведь ещё в Средние века на территории Северной Америки бывали европейцы в лице исландских викингов (см. Винланд). Но, поскольку за пределами Скандинавии сведений об этих походах не было, именно экспедиции Колумба впервые сделали сведения о землях на западе всеобщим достоянием и положили начало колонизации Америки европейцами.\r\n\r\nВсего Колумб совершил 4 плавания к Америке:\r\n\r\n    Первое плавание (3 августа 1492 — 15 марта 1493).\r\n    Второе плавание (25 сентября 1493 — 11 июня 1496).\r\n    Третье плавание (30 мая 1498 — 25 ноября 1500).\r\n    Четвёртое плавание (9 мая 1502 — 7 ноября 1504).\r\n', 1),
(4, '2017-06-21', 1, NULL, ' В. Янсзон и А.Тасман', ' Голландский мореплаватель и губернатор Виллем Янсзон стал первым европейцем, увидевшим побережье Австралии.', 'Янсзон отправился в своё третье плавание из Нидерландов к Ост-Индии 18 декабря 1603 года в качестве капитана Duyfken, одного из двенадцати судов большого флота Стивена ван дер Хагена (англ.)русск..[113] Уже в Ост-Индии Янсзон получил приказ отправиться на поиски новых торговых возможностей, в том числе в «к большой земле Новой Гвинеи и другим восточным и южным землям.» 18 ноября 1605 года Duyfken вышел из Бантама к западному берегу Новой Гвинеи. Янсзон пересёк восточную часть Арафурского моря, и, не увидев Торресов пролив, вошёл в залив Карпентария. 26 февраля 1606 года он высадился у реки Пеннефазер (англ.)русск. на западном берегу полуострова Кейп-Йорк в Квинсленде, рядом с современным городом Уэйпа. Это была первая задокументированная высадка европейцев на австралийский континент. Янсзон нанёс на карту около 320 км побережья, полагая, что это южное продолжение Новой Гвинеи. В 1615 году Якоб Лемер и Виллем Корнелис Схаутен, обойдя мыс Горн, доказали, что Огненная Земля является островом и не может быть северной частью неизвестного южного континента.\r\n\r\nВ 1642—1644 годах Абель Тасман, также голландский исследователь и купец на службе VOC, обошёл вокруг Новой Голландии, доказав, что Австралия не является частью мифического южного континента. Он стал первым европейцем, достигшим острова Земля Ван-Димена (сегодня Тасмания) и Новой Зеландии, а также в 1643 году наблюдал острова Фиджи. Тасман, его капитан Вискер и купец Гилсманс также нанесли на карту отдельные участки Австралии, Новой Зеландии и тихоокеанских островов.', 1),
(5, '2017-06-21', 2, NULL, 'Description ', 'Выполняет поиск и замену по регулярному выражению  ', ' mixed preg_replace ( mixed $pattern , mixed $replacement , mixed $subject [, int $limit = -1 [, int &$count ]] )\r\n\r\nВыполняет поиск совпадений в строке subject с шаблоном pattern и заменяет их на replacement. \r\n\r\n preg_replace() возвращает массив, если параметр subject является массивом, иначе возвращается строка. Если найдены совпадения, возвращается новая версия subject, иначе subject возвращается нетронутым, в случае ошибки возвращается NULL.\r\n\r\nС версии PHP 5.5.0, если передается модификатор \"\\e\", вызывается ошибка уровня E_DEPRECATED. С версии PHP 7.0.0 в этом случае выдается E_WARNING и сам модификатор игнорируется.\r\n\r\nPHP 7.0.0: Удалена поддержка модификатора /e. Вместо него используйте preg_replace_callback(). ', 1),
(6, '2017-06-21', 1, NULL, 'С.И. Дежнёв', 'Искони известна тяга русского человека к неизведанным местам. Казак Семен Дежнев первым из европейцев отделил Евразию от Америки, вышел в Тихий океан. Он и его собратья бродили на утлых лодьях по Великому океану вдоль Курильской гряды. Эти люди, их спутники и последователи не искали славы и золота, они были подвижниками, следопытами.', 'Семён Иванович Дежнёв (ок. 1605, Великий Устюг — нач. 1673, Москва) — выдающийся русский мореход, землепроходец, путешественник, исследователь Северной и Восточной Сибири, казачий атаман, а также торговец пушниной, первый из известных европейских мореплавателей, в 1648 году, на 80 лет раньше, чем Витус Беринг, прошёл Берингов пролив, отделяющий Аляску от Чукотки.\r\nПримечательно, что Берингу не удалось пройти весь пролив целиком, а пришлось ограничиться плаванием только в его южной части, тогда как Дежнёв прошёл пролив с севера на юг, по всей его длине.\r\nЗа 40 лет пребывания в Сибири Дежнев участвовал в многочисленных боях и стычках, имел не менее 13 ранений, включая три тяжелых. Судя по письменным свидетельствам, его отличали надежность, честность и миролюбие, стремление исполнить дело без кровопролития.\r\nИменем Дежнева названы мыс, остров, бухта, полуостров и село. В центре Великого Устюга в 1972 году ему установлен памятник.', 1),
(7, '2023-12-26', 2, NULL, 'Черновик', 'Это черновик', 'Это черновик новой статьи про preg_replace', 0),
(8, '2023-12-26', 0, NULL, 'Джеймс Кук', 'Британский военный моряк, возглавивший три кругосветные экспедиции по исследованию Мирового океана.', 'Британский военный моряк, путешественник-исследователь, картограф и первооткрыватель, член Королевского общества (1776) и капитан Королевских ВМС. Возглавлял три кругосветные экспедиции по исследованию Мирового океана (в 1768—1771, 1772—1775 и 1776—1779 годах). Во время этих экспедиций совершил ряд географических открытий. Обследовал и нанёс на карту малоизвестные и редко посещавшиеся до него части Ньюфаундленда и восточного побережья Канады, Австралии, Новой Зеландии, западного побережья Северной Америки, Тихого, Индийского и Атлантического океанов. Благодаря тому вниманию, которое Кук уделял картографии, многие из составленных им карт по своей точности и аккуратности не имели аналогов на протяжении многих десятилетий и служили мореплавателям вплоть до второй половины XIX века.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'Первый сорт', 'Это первая созданная категория, она была отредактирована после отладки ошибок'),
(2, 'Статьи про preg_replace', 'Здесь будут сохранены факты о функции preg_replace с целью понять, зачем же она понадобилась создателю сайта');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

DROP TABLE IF EXISTS `subcategories`;
CREATE TABLE `subcategories` (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `categoryId` smallint(5) UNSIGNED NOT NULL,
  `subname` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `subcategories_ibfk_1` (`categoryId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `categoryId`, `subname`) VALUES
(1, 1, 'некоторая подкатегория'),
(2, 1, 'другая подкатегория'),
(3, 2, 'ещё подкатегория');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `login` varchar(32) NOT NULL,
  `pass` varchar(64) NOT NULL,
  `salt` int NOT NULL,
  `email` varchar(32) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `role` varchar(32) NOT NULL,
  `timestamp` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `pass`, `salt`, `email`, `active`, `role`, `timestamp`) VALUES
(1, 'admin', '$2y$10$pZFOjksKoy9zS0T.6w3Ll.07kvWgaV6qSXr/n5V0cu5HHR6TkXy9i', 716953, 'admin@admin.admin', 1, 'admin', '2018-07-04'),
(2, 'Mery', '$2y$10$YyvPebNkLg90fkx1w/NIdOF62nJ.LgOU5VhcL4LPDd/hvXmOg0NKG', 426915, 'email@rrt', 0, 'auth_user', '2017-08-01'),
(3, 'Вова', '$2y$10$rz37i/3sVtKLQkwdFpoI1eawGROeEZGSRtgCyA3thsBXXYSxA/ekm', 219773, 'email@ya.ru', 1, 'auth_user', '2023-12-19');

-- --------------------------------------------------------

--
-- Table structure for table `user_articles`
--

DROP TABLE IF EXISTS `user_articles`;
CREATE TABLE `user_articles` (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `loginId` smallint UNSIGNED NOT NULL,
  `articleId` smallint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `relation_row_unique` (`loginId`,`articleId`),
  KEY `subcategories_ibfk_1` (`loginId`),
  KEY `subcategories_ibfk_2` (`articleId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_articles`
--

INSERT INTO `user_articles` (`id`, `loginId`, `articleId`) VALUES
(1, 3, 1),
(2, 1, 8),
(3, 2, 8);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_articles`
--
ALTER TABLE `user_articles`
  ADD CONSTRAINT `user_articles_ibfk_1` FOREIGN KEY (`loginId`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_articles_ibfk_2` FOREIGN KEY (`articleId`) REFERENCES `articles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
