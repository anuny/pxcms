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
					$this->redirect($this->config['URL_MODULE'].'login');
				}
				
			}
		}
    }
	
	// 消息提示
	public function menuFirst(){
		$module = $this->config['MODULE'];
		$controller = $this->config['CONTROLLER'];
		foreach ($this->menu as $key=>$v){
			if($v['pid'] && $v['module'] == $module && $v['controller'] == $controller ){
				$url = $v['url'];
				break;
			}	
		}
		if($url){
			$this->redirect($url);	
		}else{
			$this->assign('msg','此模块没有更多操作！');
			$this->display('index.error');
		}

    }
	
	
	// 消息提示
	public function msg($ststus=0,$msg='',$url=''){
		$msg = array('status'=>$ststus,'msg'=>$msg,'url'=>$url);
		if(isAjax()){
			header("Content-type:text/json"); 
			$msg['isAjax'] = true;
			$msg = $this->ajaxReturn($msg);
			exit ($msg);
		}
		$msg = $this->ajaxReturn($msg);
		exit ("<script app-ctrl='public.notice' app-config='$msg'></script>");	
    }
} 
