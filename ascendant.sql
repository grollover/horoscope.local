-- phpMyAdmin SQL Dump
-- version 2.6.1
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Фев 16 2011 г., 19:23
-- Версия сервера: 5.0.45
-- Версия PHP: 5.2.4
-- 
-- БД: `ascendant`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `test`
-- 

CREATE TABLE `test` (
  `word` varchar(150) NOT NULL,
  `frequency` int(11) NOT NULL default '1',
  PRIMARY KEY  (`word`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Дамп данных таблицы `test`
-- 

