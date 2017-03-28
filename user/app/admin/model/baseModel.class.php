<?php defined('PX') or die('PXCMS');

/* 
	公共类
*/

class baseModel extends Controller{
	protected function hook(){
		$this->config = config::get();
	}
} 
