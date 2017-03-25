<?php defined('PX') or die('PXCMS');

class baseController extends Controller{
	
	// index模块前置hook
    protected function hook(){
        header("Content-Type:text/html; charset=utf-8");
    }
	
	protected function checkUser(){
		$username = $_SESSION['username'];
		$user = $this->model->table('user')->where("name = '$username'")->find();
		return $user;
	}


} 
