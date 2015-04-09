-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Hoszt: localhost:8889
-- Létrehozás ideje: 2015. Ápr 09. 20:50
-- Szerver verzió: 5.5.38
-- PHP verzió: 5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Adatbázis: `pulzar`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `banners`
--

CREATE TABLE `banners` (
`id` int(5) NOT NULL,
  `unique_id` varchar(20) NOT NULL,
  `title` varchar(25) NOT NULL,
  `line1` varchar(35) NOT NULL,
  `line2` varchar(35) NOT NULL,
  `file` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `type` enum('text','image','flash') NOT NULL DEFAULT 'image',
  `source` enum('unique','adsense') NOT NULL DEFAULT 'unique',
  `zone` int(3) NOT NULL,
  `target` varchar(255) NOT NULL,
  `appearance` int(10) NOT NULL DEFAULT '0',
  `clicks` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `banners_zones`
--

CREATE TABLE `banners_zones` (
`id` int(3) NOT NULL,
  `title` varchar(50) NOT NULL,
  `width` int(3) NOT NULL,
  `height` int(3) NOT NULL,
  `price` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `company` varchar(100) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(50) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `city` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `mobile` varchar(30) NOT NULL,
  `fax` varchar(30) NOT NULL,
  `google` varchar(100) NOT NULL,
  `facebook` varchar(100) NOT NULL,
  `twitter` varchar(100) NOT NULL,
  `linkedin` varchar(100) NOT NULL,
  `skype` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `meta`
--

CREATE TABLE `meta` (
`id` int(11) NOT NULL,
  `language` varchar(2) NOT NULL DEFAULT 'en',
  `url_module` varchar(50) NOT NULL,
  `url_id` varchar(50) NOT NULL,
  `prefix` varchar(50) NOT NULL,
  `keywords` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `pages`
--

CREATE TABLE `pages` (
`id` int(10) NOT NULL,
  `url_id` varchar(50) NOT NULL,
  `language` varchar(2) NOT NULL DEFAULT 'en',
  `category` int(3) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `pages_categories`
--

CREATE TABLE `pages_categories` (
`id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `pages_categories`
--

INSERT INTO `pages_categories` (`id`, `title`) VALUES
(1, '~ No category ~'),
(2, 'Website Content');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
`id` int(7) unsigned zerofill NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `avatar` varchar(50) NOT NULL DEFAULT 'default.jpg',
  `email` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL DEFAULT 'users',
  `access` varchar(200) NOT NULL DEFAULT '#public',
  `status` enum('inactive','active','muted','banned') NOT NULL DEFAULT 'inactive',
  `reg_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `reg_ip` varchar(20) NOT NULL,
  `reg_type` varchar(50) NOT NULL DEFAULT 'site',
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `nick` varchar(50) NOT NULL,
  `gender` enum('male','female','other','not-set') NOT NULL DEFAULT 'not-set',
  `birthday` date NOT NULL DEFAULT '0000-00-00',
  `mailing_name` varchar(50) NOT NULL,
  `mailing_zip` varchar(20) NOT NULL,
  `mailing_city` varchar(50) NOT NULL,
  `mailing_address` varchar(50) NOT NULL,
  `mailing_country` varchar(3) NOT NULL DEFAULT 'HU',
  `billing_name` varchar(50) NOT NULL,
  `billing_zip` varchar(20) NOT NULL,
  `billing_city` varchar(50) NOT NULL,
  `billing_address` varchar(50) NOT NULL,
  `billing_country` varchar(3) NOT NULL DEFAULT 'HU',
  `phone` varchar(20) NOT NULL,
  `facebook_id` varchar(20) NOT NULL,
  `newsletter` tinyint(1) NOT NULL DEFAULT '1',
  `confirm_code` varchar(50) NOT NULL,
  `ip_validating` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners_zones`
--
ALTER TABLE `banners_zones`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meta`
--
ALTER TABLE `meta`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages_categories`
--
ALTER TABLE `pages_categories`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `banners_zones`
--
ALTER TABLE `banners_zones`
MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `meta`
--
ALTER TABLE `meta`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pages_categories`
--
ALTER TABLE `pages_categories`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(7) unsigned zerofill NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
