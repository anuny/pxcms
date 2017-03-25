-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017 年 03 月 25 日 17:55
-- 服务器版本: 5.5.53
-- PHP 版本: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `feicms`
--

-- --------------------------------------------------------

--
-- 表的结构 `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned DEFAULT NULL COMMENT '父ID',
  `title` varchar(255) DEFAULT NULL COMMENT '名称',
  `keywords` varchar(255) DEFAULT NULL COMMENT '关键词',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `slug` varchar(255) DEFAULT NULL COMMENT '别名',
  `order` int(10) unsigned DEFAULT '0' COMMENT '排序',
  `status` varchar(16) DEFAULT 'show' COMMENT '状态',
  `type` varchar(16) DEFAULT 'index' COMMENT '类型',
  `thumbnail` varchar(255) DEFAULT NULL COMMENT '缩略图',
  `page` int(11) unsigned DEFAULT '10' COMMENT '页码',
  `list_template` varchar(32) DEFAULT 'list' COMMENT '列表模板',
  `content_template` varchar(32) DEFAULT 'content' COMMENT '内容模板',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(10) unsigned DEFAULT '0' COMMENT '所属页面',
  `pid` int(10) unsigned DEFAULT '0' COMMENT '父ID',
  `author` varchar(255) DEFAULT NULL COMMENT '作者',
  `authorId` int(10) unsigned DEFAULT '0' COMMENT '作者ID',
  `created` int(10) unsigned DEFAULT '0' COMMENT '发布日期',
  `type` varchar(16) DEFAULT 'comment' COMMENT '类型',
  `content` text COMMENT '内容',
  `mail` varchar(255) DEFAULT NULL COMMENT '邮箱',
  `url` varchar(255) DEFAULT NULL COMMENT '主页',
  `ip` varchar(64) DEFAULT NULL COMMENT 'IP地址',
  `agent` varchar(255) DEFAULT NULL COMMENT '浏览器',
  `status` varchar(16) DEFAULT 'approved' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `content`
--

CREATE TABLE IF NOT EXISTS `content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(10) unsigned DEFAULT '0' COMMENT '所属栏目',
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `keywords` varchar(255) DEFAULT NULL COMMENT '关键词',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `slug` varchar(255) DEFAULT NULL COMMENT '别名',
  `order` int(10) unsigned DEFAULT '0' COMMENT '排序',
  `created` int(10) unsigned DEFAULT '0' COMMENT '发布日期',
  `modified` int(10) unsigned DEFAULT '0' COMMENT '更新日期',
  `authorId` int(10) unsigned DEFAULT '0' COMMENT '更新日期',
  `template` varchar(32) DEFAULT NULL COMMENT '模板',
  `type` varchar(16) DEFAULT 'post' COMMENT '类型',
  `content` text COMMENT '内容',
  `status` varchar(16) DEFAULT 'publish' COMMENT '状态',
  `comment` int(10) unsigned DEFAULT '0' COMMENT '评论数',
  `view` int(10) DEFAULT '0' COMMENT '浏览次数',
  `url` varchar(255) DEFAULT NULL COMMENT '跳转链接',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `plugin`
--

CREATE TABLE IF NOT EXISTS `plugin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL COMMENT '名称',
  `status` int(10) unsigned DEFAULT '1',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `mid` int(11) DEFAULT NULL,
  `ver` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL COMMENT '名称',
  `power` text,
  `status` int(10) unsigned DEFAULT '1',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `upload`
--

CREATE TABLE IF NOT EXISTS `upload` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned DEFAULT '0' COMMENT '父ID',
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `file` varchar(255) DEFAULT NULL,
  `authorId` int(10) unsigned DEFAULT '0' COMMENT '作者ID',
  `type` varchar(16) DEFAULT 'content' COMMENT '类型',
  `folder` varchar(255) DEFAULT NULL COMMENT '文件夹',
  `ext` varchar(16) DEFAULT NULL COMMENT '文件格式',
  `size` int(10) unsigned DEFAULT '0' COMMENT '大小',
  `created` int(10) unsigned DEFAULT '0' COMMENT '日期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `upload`
--

INSERT INTO `upload` (`id`, `pid`, `title`, `file`, `authorId`, `type`, `folder`, `ext`, `size`, `created`) VALUES
(1, 1, NULL, 'ee11cbb19052e40b07aac0ca060c23ee.jpg', 1, 'avatar', 'avatar', '.jpg', 2366, 1490231175),
(3, 2, NULL, 'ee11cbb19052e40b07aac0ca060c23ee.jpg', 1, 'avatar', 'avatar', '.jpg', 2366, 1490231175);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL COMMENT '用户名',
  `nickname` varchar(32) DEFAULT NULL COMMENT '昵称',
  `password` varchar(64) DEFAULT NULL COMMENT '密码',
  `mail` varchar(200) DEFAULT NULL COMMENT '邮件地址',
  `url` varchar(200) DEFAULT NULL COMMENT '网址',
  `created` int(11) unsigned DEFAULT '0' COMMENT '创建时间',
  `activated` int(11) unsigned DEFAULT '0' COMMENT '最后登录',
  `role` varchar(16) DEFAULT 'visitor' COMMENT '会员组',
  `status` varchar(16) DEFAULT 'approved' COMMENT '状态',
  `power` text COMMENT '权限',
  `sex` varchar(16) DEFAULT NULL COMMENT '性别',
  `description` varchar(255) DEFAULT NULL COMMENT '简介',
  `loginnum` int(10) unsigned DEFAULT '0' COMMENT '登录次数',
  `lastip` varchar(255) DEFAULT NULL COMMENT '最后登录IP',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `name`, `nickname`, `password`, `mail`, `url`, `created`, `activated`, `role`, `status`, `power`, `sex`, `description`, `loginnum`, `lastip`) VALUES
(1, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'yangfei88@live.cn', 'http://yangfei.name', 1430457620, 1490431367, 'admin', 'approved', NULL, NULL, NULL, 9, '127.0.0.1'),
(2, 'anuny', 'anuny', '21232f297a57a5a743894a0e4a801fc3', 'yangfei88@live.cn', 'http://yangfei.name', 1430457620, 1490342921, 'visitor', 'approved', NULL, NULL, NULL, 1, '127.0.0.1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
