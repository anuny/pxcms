<?php defined('PX') or die('PXCMS');

class indexController extends baseController {
	
    public function index(){
		if(isAjax()){
			$msg = $this->ajaxReturn(array('config'=>$this->config,'user'=>$this->user,'menu'=>$this->menu,'status'=>1));
			if(isAjax()){
				exit ($msg);
			}
		}else{
			$this->display('index.index');
		}
		
    }

}
