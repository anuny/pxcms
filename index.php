<?php

/**
 * PX Content Management System
 * http://pxcms.yangfei.name
 * @copyright  Copyright (c) 2017 Anuny 
 * @license    pxcms is opensource software licensed under the MIT license.
 */

// Security constant
define('PX', true);

// 目录分割符号
define('DS', DIRECTORY_SEPARATOR);

// 根目录
define('PATH_ROOT', dirname(__FILE__).DS);

// 框架目录
define('CORE_ROOT', PATH_ROOT.'core'.DS);

// USER目录
define('USER_ROOT', PATH_ROOT.'user'.DS);

// 载入框架
require(CORE_ROOT.'px.class.php');

// 运行系统
Px::init()->run(); 