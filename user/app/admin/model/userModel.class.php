<?php defined('PX') or die('PXCMS');

/* 
	会员数据模型
*/

class userModel extends baseModel{

    //保存配置
    public function current() {
	   $userName = $_SESSION['user'];
	   return $this->getUser($userName);
    }
	
	// 获取用户信息
	public function getUser($userName=''){
		$user = $this->model->table('user')->where("name='$userName'")->find();
		if($user){
			if($user['rid']){
				// 获取角色
				$role= $this->model->table('role')->where('id='.$user[rid])->find();
				if($role){
					$user['role'] = $role;
				}
			}
			// 获取头像
			$avatar = $this->model->table('upload')->where('id='.$user['id'])->find();
			if($avatar){
				$user['avatar'] = $this->config['URL_UPLOAD'].$avatar['folder'].'/'.$avatar['file'];
			}else{
				$user['avatar'] = $this->config['URL_STATIC'].'images/'.$this->config['NOAVATAR'];
			}
		}
		return $user;	
	}

	

} 
