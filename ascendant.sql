-- phpMyAdmin SQL Dump
-- version 2.6.1
-- http://www.phpmyadmin.net
-- 
-- ����: localhost
-- ����� ��������: ��� 16 2011 �., 19:23
-- ������ �������: 5.0.45
-- ������ PHP: 5.2.4
-- 
-- ��: `ascendant`
-- 

-- --------------------------------------------------------

-- 
-- ��������� ������� `test`
-- 

CREATE TABLE `test` (
  `word` varchar(150) NOT NULL,
  `frequency` int(11) NOT NULL default '1',
  PRIMARY KEY  (`word`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- ���� ������ ������� `test`
-- 

