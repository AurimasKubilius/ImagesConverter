-- phpMyAdmin SQL Dump
-- version 3.3.7deb7
-- http://www.phpmyadmin.net
--
-- Darbinė stotis: localhost
-- Atlikimo laikas:  2012 m. Kovo 01 d.  00:21
-- Serverio versija: 5.1.49
-- PHP versija: 5.3.3-7+squeeze8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

--
-- Structure for `active_guests` table
--

CREATE TABLE IF NOT EXISTS `active_guests` (
  `ip` varchar(15) NOT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Data copy for `active_guests`
--


-- --------------------------------------------------------

--
-- Structure for `active_users` table
--

CREATE TABLE IF NOT EXISTS `active_users` (
  `username` varchar(30) NOT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Data dopy for `active_users`
--


-- --------------------------------------------------------

--
-- Structure for `banned_users` table
--

CREATE TABLE IF NOT EXISTS `banned_users` (
  `username` varchar(30) NOT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Data dopy for `banned_users`
--


-- --------------------------------------------------------

--
-- Structure for `users` table
--

CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(30) NOT NULL,
  `password` varchar(32) DEFAULT NULL,
  `userid` varchar(32) DEFAULT NULL,
  `userlevel` tinyint(1) unsigned NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Data dopy for `users` created
--

INSERT INTO `users` (`username`, `password`, `userid`, `userlevel`, `email`, `timestamp`) VALUES
('VIP', 'fe01ce2a7fbac8fafaed7c982a04e229', '7ed2b87b255a0348b61226bd7c2ed5b4', 5, 'vip@email.com', 1330553708),
('Admin', '21232f297a57a5a743894a0e4a801fc3', 'a2fe399900de341c39c632244eaf8483', 9, 'admin@email.com', 1330553956),
('Vartotojas', 'fe01ce2a7fbac8fafaed7c982a04e229', '9a47f4552955b91bcd8850d73b00e703', 1, 'user@email.com', 1330553730);
