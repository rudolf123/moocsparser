-- phpMyAdmin SQL Dump
-- version 3.3.7deb7
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Май 29 2014 г., 18:08
-- Версия сервера: 5.1.73
-- Версия PHP: 5.3.3-7+squeeze19

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `moocs`
--

-- --------------------------------------------------------

--
-- Структура таблицы `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `schoolname` varchar(255) NOT NULL,
  `platform` varchar(255) NOT NULL,
  `start` varchar(200) NOT NULL,
  `length` varchar(50) NOT NULL,
  `estimate` varchar(255) NOT NULL,
  `language` varchar(100) NOT NULL,
  `subtitles` varchar(100) NOT NULL,
  `about` text NOT NULL,
  `staff` text NOT NULL,
  `staff_profile` text NOT NULL,
  `info` text NOT NULL,
  `similar` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Courseid` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3049 ;

-- --------------------------------------------------------

--
-- Структура таблицы `courses_moodle`
--

CREATE TABLE IF NOT EXISTS `courses_moodle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `moodle_id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1929 ;

-- --------------------------------------------------------

--
-- Структура таблицы `requests`
--

CREATE TABLE IF NOT EXISTS `requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `instructor_name_rus` varchar(255) NOT NULL,
  `instructor_name_eng` varchar(255) NOT NULL,
  `course_name_rus` varchar(255) NOT NULL,
  `course_name_eng` varchar(255) NOT NULL,
  `course_tags_rus` text NOT NULL,
  `course_tags_eng` text NOT NULL,
  `outcomes_rus` text NOT NULL,
  `outcomes_eng` text NOT NULL,
  `date` date NOT NULL,
  `instructor_email` varchar(100) NOT NULL,
  `url` varchar(255) NOT NULL,
  `creator_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL,
  `passwd` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `secondname` varchar(30) NOT NULL,
  `role` varchar(15) NOT NULL,
  `sessionstart` datetime NOT NULL,
  `sessionend` datetime NOT NULL,
  `autologin` tinyint(1) NOT NULL,
  `online` tinyint(1) NOT NULL DEFAULT '0',
  `regdate` datetime NOT NULL,
  `email` varchar(50) NOT NULL,
  `approved` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;
