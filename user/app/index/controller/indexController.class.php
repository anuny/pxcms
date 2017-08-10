<?php defined('PX') or die('PXCMS');

class indexController extends baseController {
    public function index(){
		$test = controller('test')->index();
		$this->assign('test',$test);
        $this->display('index');
    }
}
