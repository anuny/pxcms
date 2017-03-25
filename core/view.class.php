<?php defined('PX') or die('PXCMS');

/**
 * 视图类
 */
class View {
    /**
     * 视图文件目录
     * @var string
     */
    private $tplDir = '';
    /**
     * 视图文件路径
     * @var string
     */
    private $viewPath = '';
    /**
     * 视图变量列表
     * @var array
     */
    private $data = array();	

    /**
     * @param string $tplDir
     */
    public function __construct(){
		$config = config::get();
        $this->tplDir = USER_ROOT . 'theme' . DS . $config['MODULE'] . '.'  . $config['THEME'] . DS;
    }
    /**
     * 为视图引擎设置一个模板变量
     * @param string $key 要在模板中使用的变量名
     * @param mixed $value 模板中该变量名对应的值
     * @return void
     */
    public function assign($key, $value) {
        $this->data[$key] = $value;
    }
    /**
     * 渲染模板并输出
     * @param null|string $tplFile 模板文件路径，相对于app/theme/文件的相对路径，不包含后缀名，例如index.index
     * @return void
     */
    public function display($tplFile) {
		$tplFile = trim($tplFile);
		$config = config::get();
		$c = $config['MODULE'];
		$a = $config['CONTROLLER'];
		if(!$tplFile){
			$tplFile = $c . '.' . $a;
		};
        $viewPath = $this->tplDir . $tplFile. '.php';
		$this->assign('config', $config);
        unset($tplFile);
        extract($this->data);
		file_exists($viewPath) ? include($viewPath) : new Error('模板:"' . $viewPath . '"不存在', 500) ;
		
    }
    /**
     * 用于在模板文件中包含其他模板
     * @param string $path 相对于View目录的路径
     * @param array $data 传递给子模板的变量列表，key为变量名，value为变量值
     * @return void
     */
    public function need($path){
		$path = trim($path);
		if($path){
			$tplDir = $this->tplDir.$path. '.php';
			unset($path);
			extract($this->data);
			file_exists($tplDir) ? include($tplDir) : new Error($tplDir . '"不存在', 500) ;
		};	
    }
}