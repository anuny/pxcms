<?php exit;?>DROP TABLE IF EXISTS dc_plugin_statistics
CREATE TABLE `dc_plugin_statistics` ( `id` int(11) NOT NULL auto_increment,`ip` varchar(50) NOT NULL COMMENT 'IP地址',`counts` varchar(50) NOT NULL COMMENT '统计访问次数',`date` datetime NOT NULL COMMENT '访问时间',PRIMARY KEY  (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8;