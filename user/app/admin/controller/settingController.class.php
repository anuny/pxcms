<?php defined('PX') or die('PXCMS');

class settingController extends baseController {
	
	public function index(){
		$this->menuFirst();
    }
	
	// 菜单设置
	public function menu(){
		if($_GET[0] == 'add'){
			$this->display('setting.menu.edit');
			exit;
		}
		
		if(isset($_GET['edit'])){
			$id = $_GET['edit'];
			if($id){
				$menuArr = $this->menu;
				$menu = model('menu')->get($id,$menuArr);
				$this->assign('info',$menu);
				$this->display('setting.menu.edit');
				if(isPost()){
					$status = $this->submitMenu();
					if($status){
						$this->msg(array('status'=>1,'msg'=>'菜单修改成功！'),true);
					}else{	
						$this->msg(array('status'=>0,'msg'=>'菜单修改失败！'),false);
					}
				}
			}
			exit;
		}
		$this->display('setting.menu');
    }
	
	// 系统设置
	public function system(){
		$this->display('setting.system');
	
		if(isPost()){
			$status = $this->submit();
			if($status){
				$this->msg(true,'系统设置成功！',true);
			}else{
				$this->msg(false,'系统设置失败，请检查config目录是否有写入权限！',false);
			}
		}
		
    }
	
	// 数据库设置
	public function database(){
		$this->display('setting.database');
		
		if(isPost()){
			$status = $this->submit();
			if($status){
				$this->msg(true,'数据库设置成功！',true);
			}else{
				$this->msg(false,'数据库设置失败，请检查config目录是否有写入权限！',false);
			}
		}
    }
	
	// 站点设置
	public function site(){
		echo '站点设置';
    }
	
	// 评论设置
	public function comment(){
		echo '评论设置';
    }
	
	protected function submitMenu(){
		$data = $_POST;
		return $this->model->table('category')->data($data)->where('id='.$data['id'])->update();
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
