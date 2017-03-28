<?php defined('PX') or die('PXCMS');

/* 
	配置模型
*/

class userModel extends baseModel{

    //保存配置
    public function current() {
	   $userName = $_SESSION['user'];
	   return $this->getUser($userName);
    }
	
	// 获取用户信息
	public function getUser($userName){
		$dbpre = $this->config['DB_PREFIX'];
		$sql="
		SELECT A.*,CONCAT(B.folder,'/',B.file) AS {$dbpre}avatar
		FROM {$dbpre}user A
		LEFT JOIN {$dbpre}upload B ON B.pid=A.id
		WHERE A.name='{$userName}' AND B.type='avatar'
		";
		$data= $this->model->query($sql);
		
		$user = $this->model->table('user')->where('name='.$userName)->find();
		if($user){
			$user['role'] = $this->model->table('role')->where('id='.$user['rid'])->find();
			$user['avatar'] = $this->model->table('avatar')->where('id='.$user['id'])->find();
			return $user;
		}
		return false;
		
		
		
	}

	

} 
