<?php defined('PX') or die('PXCMS');

class indexController extends baseController {
    public function index(){
		print_r(model('test')->test());
		$test = controller('test')->index();
		$this->assign('test',$test);
        $this->display('index');
    }
}
