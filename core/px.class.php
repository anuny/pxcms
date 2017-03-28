<?php defined('PX') or die('PXCMS');

/**
 * 总控类
 */
class Px {
	
	// 单列模式
	private static $instance; 
    
    // 构造函数，初始化配置
    private function __construct(){

		//框架版本号
		define('PX_VER', '1.0.2017.0123');	
		
		//加载默认配置类
        require_once(CORE_ROOT . 'config.class.php');

		//加载配置文件
        require_once(USER_ROOT . 'config' . DS .'config.inc.php');
		
		//参数配置
		$config = array_merge(config::get(), $config);

		defined('DEBUG') or define('DEBUG', $config['DEBUG']);

		// 错误屏蔽
		ini_set("display_errors", DEBUG ? 1 : 0);
		error_reporting( DEBUG ? E_ALL ^ E_NOTICE : 0 );
		
		// 编码
		header("content-type:text/html; charset=$config[CHARSET]");

		// 时区
		@date_default_timezone_set($config['TIMEZONE']);
		
		// 启用session会话
        if($config['USE_SESSION']) session_start();
		
		//参数配置
		config::set($config);
		
		// 加载常用函数库
		require_once(CORE_ROOT . 'function.class.php');

		//注册类的自动加载
		spl_autoload_register( array($this, 'autoload') );	 
    }

	// 初始化
	public static function init(){
        if(!(self::$instance instanceof self)) self::$instance = new self($config);
        return self::$instance;
    }
	

    // 实例化
    public function run(){
		
		// 获取 模块名、控制器名、方法名
		$MCA = $this->getMCA();

		// 设置页面地址
		$this->setUrl();
		
		// 获取模块路径
		$module = USER_ROOT . 'app' .DS. $MCA['m'] . DS;	

		// 加载类
		$this->requireClass();
		
		// 检测模块
		if(!file_exists($module)) new Error('模块:"'.$MCA['m'].'"不存在',404) ;
		
		// 检测控制器
        if(!class_exists($MCA['c'].'Controller')) new Error('控制器:"'.$MCA['c'].'"不存在',404) ; 
		
        $controllerClass = $MCA['c'].'Controller';
				
        $controller = new $controllerClass();
		
		// 检测方法
        if(!method_exists($controller, $MCA['a'])) new Error('方法:"'.$MCA['a'].'"不存在',404) ;

        call_user_func(array($controller,$MCA['a']));
    }
	
	protected function setUrl(){
		$config = config::get();

		// 获取协议
		$protocol = 'http'.($_SERVER['HTTPS'] == "on" ? 's' : '').'://';
		
		// 模块域名
		if( isset($config['APP_DOMAIN']) ){
			$root = trim( $config['APP_DOMAIN'] );
		}else{
			$root = $_SERVER['HTTP_HOST'] . str_replace(basename($_SERVER["SCRIPT_NAME"]), '', $_SERVER["SCRIPT_NAME"]);
		}
		
		$root = $protocol . rtrim($root,'/') . '/';

		if (!$config['URL_REWRITE_ON']) {
			//当前入口文件
			$root = basename($_SERVER["SCRIPT_NAME"]);
		}
		
		$theme =  isset($config['THEME']) ? trim( $config['THEME'] ) : 'default';
		config::set('URL_APP', $root);
		config::set('URL_THIS', $root . $config['MODULE'] . '/');
		config::set('URL_THEME', $root . 'user/theme/' . $config['MODULE'] . '.' . $theme . '/');
		config::set('URL_STATIC', $root . 'user/static/');
		config::set('URL_UPLOAD', $root . 'user/upload/');
    }

	protected function getMCA(){
		$config = config::get();
        // 没有开启伪静态或服务器不支持PATH_INFO
        if(!$config['URL_REWRITE_ON'] || !isset($_SERVER['PATH_INFO'])){
			$M = isset($_GET['m']) ? $_GET['m'] : 'index';	
            $C = isset($_GET['c']) ? $_GET['c'] : 'index';
            $A = isset($_GET['a']) ? $_GET['a'] : 'index';
        }else{
			$pathInfo = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
            $pathInfoArr = explode('/',trim($pathInfo,'/'));
			$M = isset($pathInfoArr[0]) ? $pathInfoArr[0] : 'index';
			$C = isset($pathInfoArr[1]) && $pathInfoArr[0] !== '' ? $pathInfoArr[1] : 'index';
			$A = isset($pathInfoArr[2]) ? $pathInfoArr[2] : 'index';
			$_GET = array_slice($pathInfoArr, 3);
        }
		// 设置当前模块名
		config::set('MODULE', $M );
		
		// 设置当前控制器名
		config::set('CONTROLLER', $C);
		
		// 设置当前方法名
		config::set('ACTION', $A);
		
		
		
		return array('m'=>$M, 'c'=>$C, 'a'=>$A);
    }
	
	protected function requireClass(){
		
        // 载入控制类
		require_once(CORE_ROOT . 'controller.class.php');
		
		// 载入模型类
		require_once(CORE_ROOT . 'model.class.php');

		// 载入视图类
		require_once(CORE_ROOT . 'view.class.php');

		// 载入错误类
		require_once(CORE_ROOT . 'error.class.php');
		
		// 载入错误类
		require_once(CORE_ROOT . 'category.class.php');
    }

	
    // 自动加载函数
    public function autoload($class){
		$module = config::get('MODULE');
		// 加载模型
		if(substr($class, -5) == 'Model'){
			$classPath = 'app' .DS. $module .DS. 'model';
		// 加载控制器
		}else if(substr($class, -10) == 'Controller' ){
			$classPath = 'app' .DS. $module .DS. 'controller';
		}else{
		// 加载扩展类库
			$classPath = 'lib';
		}
		$classPath = USER_ROOT . $classPath. DS .$class. '.class.php';
		file_exists($classPath) ? require_once($classPath) : new Error($module . DS . $class . '"不存在', 404) ;
    }
}
