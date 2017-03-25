<?php defined('PX') or die('PXCMS');

class testController extends baseController {
    public function index(){
		return serialize(array('edit'=>1,'del'=>1,'view'=>0));
    }
}
