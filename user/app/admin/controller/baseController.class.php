<?php defined('PX') or die('PXCMS');

/* 
	公共类
*/

class baseController extends Controller{

	// admin模块前置hook
    protected function hook(){
		$this->config = config::get();
		$this->user = model('user')->current();
		$this->assign('config',$this->config);
		$controller = $this->config['CONTROLLER'];
		if($this->user['id']){
			$this->assign('user',$this->user);
			$list=model('category')->lists($this->config['MODULE']);
			$this->menu = $list;
			$this->assign('menu',$list);
			// 登录状态禁止注册
			if($controller == 'register'){
				$this->redirect($this->config['URL_THIS']);
			}
		}else{
			// 登录页面或注册页面不跳转登录界面
			if($controller != 'login'){
				if($controller != 'register'){
					$this->redirect($this->config['URL_THIS'].'login');
				}
				
			}
		}
    }

	// 消息提示
	public function msg($msg,$reload=false){
		$msg = $msg['status'].'||'.$msg['msg'];
		setcookie("__px_notice_msg",urlencode($msg));
		if($reload){
			echo "<script language=javascript> location.replace(location.href);</script>";
		}
    }
	
	
	

} 
