<?php defined('PX') or die('PXCMS');

/* 
	会员数据模型
*/

class menuModel extends baseModel{

	
	// 获取用户信息
	public function get($id='',$menuArr=array()){
		foreach ($menuArr as $key => $value) {
			if($value['id'] == $id){
				return $value;
			}
		}
		
	}

	

} 
