<?php defined('PX') or die('PXCMS');

class settingController extends baseController {
	
	public function index(){	
		if(isPost()){
			$this->submit();
		}
		$this->config = config::get();
		$this->display('setting.index');
    }
	
	// 修改系统设置
    public function submit()
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
        $status=model('setting')->save($config_array,$file);
        if($status){
            $this->msg('网站配置成功！');
        }else{
            $this->msg('网站配置失败，请建站多语言文件夹与inc目录文件是否有写入权限！');
        }
    }
}
