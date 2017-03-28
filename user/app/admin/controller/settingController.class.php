<?php defined('PX') or die('PXCMS');

class settingController extends baseController {
	
	public function index(){
		$module = $this->config['MODULE'];
		$controller = $this->config['CONTROLLER'];
		foreach ($this->menu as $key=>$v){
			if($v['pid'] && $v['module'] == $module && $v['controller'] == $controller ){
				$this->redirect($v['url']);	
				continue;
			}
		}
    }
	
	public function menu(){
		$action = isset($_GET[0]) ? $_GET[0]:false;
		if($action){
			$controller = controller('menu');
			if($controller){
				if(method_exists($controller, $action)){
					$_GET = array_slice($_GET, 1);
					$controller->$action();
				}else{
					new Error('方法:"'.$action.'"不存在',404);
				}
			}else{
				new Error('控制器:"menu"不存在',404) ; 
			}	
		}else{
			$this->display('setting.menu');
		}
		
    }
	
	public function system(){
		if(isPost()){
			$status = $this->submit();
			if($status){
				$this->msg(array('status'=>1,'msg'=>'系统设置成功！'),true);
			}else{
				$this->msg(array('status'=>0,'msg'=>'系统设置失败，请检查config目录是否有写入权限！'),false);
			}
		}
		$this->display('setting.system');
    }
	
	public function database(){
		if(isPost()){
			$status = $this->submit();
			if($status){
				$this->msg(array('status'=>1,'msg'=>'数据库设置成功！'),true);
			}else{
				$this->msg(array('status'=>0,'msg'=>'数据库设置失败，请检查config目录是否有写入权限！'),false);
			}
		}
		$this->display('setting.database');
    }

	// 修改系统设置
    protected function submit()
    {
		// 接收表单数据
        $config = $_POST;
		// 格式化数据
        $config_array = array();
        foreach ($config as $key => $value) {
            if(!strpos($key,'|')){
                $config_array["config['" . $key . "']"] = $value;
            }else{
                $strarray=explode('|', $key);
                $str="config['" . $strarray[0] . "']";
                foreach ($strarray as $keys=>$values) {
                    if($keys<>0){
                    $str.="['".$values."']";
                    }
                }
                unset($strarrays);
                $config_array[$str] = $value;
            }
        }
		
        $file=USER_ROOT.'config'.DS.'config.inc.php';
        return model('setting')->save($config_array,$file);
       
    }
}
