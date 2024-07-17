-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: db
-- Время создания: Май 01 2022 г., 15:39
-- Версия сервера: 10.3.13-MariaDB-1:10.3.13+maria~bionic
-- Версия PHP: 7.2.14

INSERT INTO `categories` (`id`, `name`, `bbk`, `name_url`, `parent_id`, `directory`, `position`, `block`) VALUES
(9, 'Наука и образование', '72', 'nauka-i-obrazovanie', null, 'nauka_obrazoanie', 3, 2),
(7, 'Литература', '84', 'literatura', null, 'literatura', 3, 2),
(45, 'Журналы', '111', 'zhurnaly', null, 'gazeta', 3, 2),
(46, 'Газеты', '95', 'gazety', null, 'gazety_jurnaly', 3, 2),
(43, 'История Чечни с древнейших времен до наших дней', '63.3.1', 'istoriya', null, 'history', 3, 2),
(17, 'Медицина', '5', 'meditsina', null, 'medicina', 3, 2),
(20, 'Экономика', '65', 'ekonomika', null, 'ekonomika', 3, 2),
(21, 'Политика. Политические науки', '66', 'politika-politicheskie-nauki', null, 'politika_politologiya', 3, 2),
(22, 'Культура', '71', 'kultura', null, 'kultura', 3, 2),
(23, 'Юриспруденция', '67', 'yurisprudentsiya', null, 'yurisprudenciya', 3, 2),
(24, 'Педагогика', '74', 'pedagogika', null, 'pedagogika', 3, 2),
(25, 'Средства массовой информации', '76', 'sredstva-massovoj-informatsii', null, 'sredstvo_massovoy_informacii', 3, 2),
(26, 'Технические науки', '3', 'tehnicheskie-nauki', null, 'tehnicheskie_nauki', 3, 2),
(27, 'Фольклор', '82', 'folklor', null, 'falklor', 3, 2),
(28, 'Религия', '86', 'religiya', null, 'religiya', 3, 2),
(38, 'Естественные науки', '28', 'estestvennye-nauki', null, 'estestvoznanie', 3, 2),
(32, 'Языкознание', '81', 'yazykoznanie', null, 'yazikoznanie', 3, 2),
(40, 'Этнография', '63.5', 'etnografiya', null, 'etnografiya', 3, 2),
(48, 'Сельское хозяйство', '4', 'selskoe-hozyajstvo', null, 'selskoe_hozaystvo', 3, 2),
(42, 'История Кавказа в целом', '63.3', 'istoriya-kavkaza-v-tselom', null, 'history_caucas', 3, 2),
(47, 'Литературоведение', '83', 'literaturovedenie', null, 'literaturovedenie', 3, 2),
(37, 'Искусство', '85', 'iskuvstvo', null, 'iscuvstvo', 3, 2),
(39, 'Археология', '63.4', 'arheologiya', null, 'arheologiya', 3, 2),
(49, 'Социальные науки в целом', '60', 'sotsialnye-nauki-v-tselom', null, 'socialnie_nauki', 3, 2),
(54, 'Архивное дело. Архивоведение', '79.3', 'arhivnoe_delo', null, 'arhivnoe_d', 3, 2),
(57, 'Всемирная история', '63', 'vsemirnaya_istoriya', null, 'vsemirnaya', 3, 2),
(56, 'Сборники цитат, мыслей, афоризмов', '94.8', 'sborniki_tsitat,_myslej,_aforizmov', null, 'sborniki_t', 3, 2),
(58, 'Транспорт', '39', 'transport', null, 'transport', 3, 2),
(59, 'Философия', '87', 'filosofiya', null, 'filosofiya', 3, 2),
(60, 'Психология', '88', 'psihologiya', null, 'psihologiy', 3, 2),
(61, 'Химическая технология. Химические производства', '35', 'himicheskaya_tehnologiya_himicheskie_proizvodstva', null, 'himicheska', 3, 2),
(62, 'Горное дело', '33', 'gornoe_delo', null, 'gornoe_del', 3, 2),
(63, 'Физическая культура и спорт', '75', 'fizicheskaya_kultura_i_sport', null, 'fizicheska', 3, 2),
(64, 'Сериальные издания', '95', 'serialnye_izdaniya', null, 'serialnye_', 3, 2),
(65, 'Библиографические ресурсы', '91', 'bibliograficheskie_resursy', null, 'bibliograf', 3, 2),
(66, 'Охрана памятников истории и культуры', '79', 'ohrana_pamyatnikov_istorii_i_kultury', null, 'ohrana_pam', 3, 2),
(67, 'Общее растениеводство', '41', 'obschee_rastenievodstvo', null, 'obschee_ra', 3, 2),
(69, 'Пищевые производства', '36', 'pischevye_proizvodstva', null, 'pischevye_', 3, 2),
(72, 'История России с древнейших времен', '63.3.2', 'istoriya_rossii_s_drevnejshih_vremen', null, 'istoriya_r', 3, 2),
(1, 'ВРЕМЕННАЯ КАТЕГОРИЯ', '63.3.2', 'tmp_category', null, 'cat', 3, 2),
(73, 'Диссертации', '1', 'dissertatsii', null, 'dissertats', 4, 2);

INSERT INTO `categories` (`id`, `name`, `name_url`, `bbk`, `directory`, `position`, `tree_root`, `parent_id`, `lft`, `lvl`, `rgt`, `block`) VALUES
(74, 'Главная', '/', NULL, NULL, 0, 74, NULL, 1, 0, 2, 1),
(75, 'Разделы', '/books', NULL, NULL, 0, 75, NULL, 1, 0, 2, 1),
(76, 'О нас', '/page/about', NULL, NULL, 0, 76, NULL, 1, 0, 2, 1),
(77, 'Контакты', '/page/contacts', NULL, NULL, 0, 77, NULL, 1, 0, 2, 1);