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
		$module = USER_ROOT . 'app' .DS. $MCA['module'] . DS;	

		// 加载类
		$this->requireClass();
		
		
		
		// 检测模块
		if(!file_exists($module)) new Error('模块:"'.$MCA['module'].'"不存在',404) ;
		
		// 检测控制器
        if(!class_exists($MCA['controller'].'Controller')) new Error('控制器:"'.$MCA['controller'].'"不存在',404) ; 
		
        $controllerClass = $MCA['controller'].'Controller';
				
        $controller = new $controllerClass();
		
		// 检测方法
        if(!method_exists($controller, $MCA['action'])) new Error('方法:"'.$MCA['action'].'"不存在',404) ;

        call_user_func(array($controller,$MCA['action']));
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

		$root =  $protocol.rtrim($root,'/') . '/';
		$realRoot = $root;
		
		
		//当前入口文件
		if (!$config['URL_REWRITE']) {
			$root .= basename($_SERVER["SCRIPT_NAME"]).'/';
		}

		$theme =  isset($config['THEME']) ? trim( $config['THEME'] ) : 'default';
		$url_module = $root . $config['MODULE'] . '/';
		$url_controller = $url_module . $config['CONTROLLER'] . '/';
		$url_action = $url_controller . $config['ACTION'] . '/';
		
		config::set('URL_APP', $root);
		config::set('URL_MODULE', $url_module);
		config::set('URL_CONTROLLER', $url_controller);
		config::set('URL_ACTION', $url_action);
		config::set('URL_USER', $realRoot . 'user/');
		config::set('URL_THEME', $realRoot . 'user/theme/' . $config['MODULE'] . '.' . $theme . '/');
		config::set('URL_STATIC', $realRoot . 'user/static/');
		config::set('URL_UPLOAD', $realRoot . 'user/upload/');
		config::set('URL_PLUGIN', $root . 'user/plugin/');
		config::set('URL_DATA', $realRoot . 'user/data/');
    }
	
	//网址解析
    private function getMCA(){
		$config =config::get();

		$script_name = $_SERVER["SCRIPT_NAME"];//获取当前文件的路径
		$url = $_SERVER["REQUEST_URI"];//获取完整的路径，包含"?"之后的字符串
		
		//去除url包含的当前文件的路径信息
		if ( $url && @strpos($url,$script_name,0) !== false ){
			$url = substr($url, strlen($script_name));
		} else {
			$script_name = str_replace(basename($_SERVER["SCRIPT_NAME"]), '', $_SERVER["SCRIPT_NAME"]);
			if ( $url && @strpos($url, $script_name, 0) !== false ){
				$url = substr($url, strlen($script_name));
			}
		}
	
		//第一个字符是'/'，则去掉
		if ($url[0] == '/') {
			$url = substr($url, 1);
		}		
		
		//去除问号后面的查询字符串
		if ( $url && false !== ($pos = @strrpos($url, '?')) ) {
			$url = substr($url,0,$pos);
		}

		//去除后缀
		if ($url&&($pos = strrpos($url,$config['URL_HTML_SUFFIX'])) > 0) {
			$url = substr($url,0,$pos);
		}
		
		
		
		$flag=0;
		//获取模块名称
		if ( $url && ($pos = @strpos($url, $config['URL_DEPR'], 1) )>0 ) {
			$module = substr($url,0,$pos);//模块
			$url = substr($url,$pos+1);//除去模块名称，剩下的url字符串
			$flag = 1;//标志可以正常查找到模块
		} else {	//如果找不到模块分隔符，以当前网址为模块名
			$module = $url;
		}
		
		$flag2=0;//用来表示是否需要解析参数
		//获取操作方法名称
		if($url&&($pos=@strpos($url,$config['URL_DEPR'],1))>0) {
			$controller = substr($url, 0, $pos);//模块
			$url = substr($url, $pos+1);
			$flag2 = 1;//表示需要解析参数
		} else {
			//只有可以正常查找到模块之后，才能把剩余的当作操作来处理
			//因为不能找不到模块，已经把剩下的网址当作模块处理了
			if($flag){
				$controller=$url;
			}
		}
		
		
		$flag3=0;//用来表示是否需要解析参数
		//获取操作方法名称
		if($url&&($pos=@strpos($url,$config['URL_DEPR'],1))>0) {
			$action = substr($url, 0, $pos);//模块
			$url = substr($url, $pos+1);
			$flag3 = 1;//表示需要解析参数
		} else {
			//只有可以正常查找到模块之后，才能把剩余的当作操作来处理
			//因为不能找不到模块，已经把剩下的网址当作模块处理了
			if($flag2){
				$action=$url;
			}
		}
		
		

		//解析参数
		if($flag3) {
			$param = explode($config['URL_PARAM_DEPR'], $url);
			$param_count = count($param);
			for($i=0; $i<$param_count; $i=$i+2) {			
				$_GET[$i] = $param[$i];
				if(isset($param[$i+1])) {
					if( !is_numeric($param[$i]) ){
						$_GET[$param[$i]] = $param[$i+1];
					}
					$_GET[$i+1] = $param[$i+1];
				}
			}	
		}
			
		
		$module = $module !='' ? $module : 'index';
		$controller = $controller !='' ? $controller : 'index';
		$action = $action !='' ? $action : 'index';

		// 设置当前模块名
		config::set('MODULE', $module );
		
		// 设置当前控制器名
		config::set('CONTROLLER', $controller);
		
		// 设置当前方法名
		config::set('ACTION', $action);
		
		return array('module'=>$module,'controller'=>$controller,'action'=>$action);	
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
