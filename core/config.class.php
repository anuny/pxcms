<?php defined('PX') or die('PXCMS');

//配置类
class config{
	static public $config=array(	
		// 开启调试模式
		'DEBUG' => true,	

		// 开启伪静态重写
		'URL_REWRITE_ON' => true,

		// 开启SESSION会话
		'USE_SESSION' => true,

		// 设置域名	
		'APP_DOMAIN' => '',

		// 伪静态后缀设置
		'URL_HTML_SUFFIX' => '.html',
		
		// 默认主题
		'THEME' => 'default',

		// 设置编码
		'CHARSET' => 'UTF-8',

		// 设置时区
		'TIMEZONE' => 'PRC',

		// 数据库主机
		'DB_HOST' => '127.0.0.1', 

		// 数据库用户名
		'DB_USER' => 'root', 

		// 数据库密码
		'DB_PWD' => 'root', 

		// 数据库端口
		'DB_PORT' => 3306, 

		// 数据库名
		'DB_NAME' => 'feicms', 

		// 数据库前缀
		'DB_PREFIX' => '', 

		// 数据库编码
		'DB_CHARSET' => 'utf8'
	);
	
	//获取默认配置
	static public function get( $key = '' ) {
		return (isset($key) && $key !='') ? self::$config[$key] : self::$config;
	}
	
	//设置参数
	static public function set( $key , $value='') {
		return (isset($value) && !empty($value)) ? self::$config[$key] = $value : self::$config = $key;
	}
}