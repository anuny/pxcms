<?php defined('PX') or die('PXCMS');

// 控制器之间相互调用
function  controller($module){
	static $module_obj=array();
	if(isset($module_obj[$module])){
		return $module_obj[$module];
	}	
	$modulePath = USER_ROOT .'app' .DS. config::get('MODULE') .DS.'controller' . DS . $module .'Controller.class.php';
	if(file_exists($modulePath)){
			require_once($modulePath);
			$classname=$module.'Controller';
			if(class_exists($classname)){
				return  $module_obj[$module]=new $classname();
			}
	}else{
		return false;
	}
}


//模型调用函数
if(!function_exists('model')){
	function  model($model){
		static $model_obj=array();
		if(isset($model_obj[$model])){
			return $model_obj[$model];
		}
		$modelPath = USER_ROOT .'app' .DS. config::get('MODULE') .DS.'model'.DS. $model . 'Model.class.php';
		if(file_exists($modelPath)){
				require_once($modelPath);
				$classname=$model.'Model';
				if(class_exists($classname)){
					return  $model_obj[$model]=new $classname();
				}
		}
		return false;
	}
}


/**
 * 是否是AJAx提交的
 * @return bool
 */
function isAjax(){
    if(isset($_SERVER['HTTP_REQUEST_TYPE']) && strtolower($_SERVER['HTTP_REQUEST_TYPE']) == 'xmlhttprequest'){
        return true;
    }else{
        return false;
    }
}

/**
 * 是否是GET提交的
 */
function isGet(){
    return $_SERVER['REQUEST_METHOD'] == 'GET' ? true : false;
}


//脚本运行时间
function runtime(){
	define('ETIME', microtime(true));
	$runTime = number_format(ETIME - STIME, 4);
	return $runTime;
}
	

/**
 * 是否是POST提交
 * @return int
 */
function isPost() {
    return $_SERVER['REQUEST_METHOD'] == 'POST'  ? 1 : 0;
}

// 获取客户端IP地址
function get_client_ip(){
   if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")){
       $ip = getenv("HTTP_CLIENT_IP");
   }else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")){
       $ip = getenv("HTTP_X_FORWARDED_FOR");
   }else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")){
       $ip = getenv("REMOTE_ADDR");
   }else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")){
       $ip = $_SERVER['REMOTE_ADDR'];
   }else{
       $ip = "unknown";
	}
	if (preg_match('#^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$#', $ip)) {
		$ip_array = explode('.', $ip);	
		if($ip_array[0]<=255 && $ip_array[1]<=255 && $ip_array[2]<=255 && $ip_array[3]<=255){
			return $ip;
		}			
	}		
   return "unknown";
}

// 获取当前网页地址
function getThisURL(){	
	$pageURL = 'http';
	if ($_SERVER["HTTPS"] == "on") {
		$pageURL .= "s";
	}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}