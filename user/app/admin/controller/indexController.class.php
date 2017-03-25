<?php defined('PX') or die('PXCMS');

class indexController extends baseController {
	
    public function index(){
		echo '<a href="'.config::get('URL_THIS').'login/logout">退出</a>';
    }

}
