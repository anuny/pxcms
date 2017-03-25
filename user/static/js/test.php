<?php defined('PX') or die('PXCMS');

/* 
	公共类
*/

class baseController extends Controller{

	// admin模块前置hook
    protected function hook(){
		$config = config::get();
		$dbpre = $config['DB_PREFIX'];
		$userName = $_SESSION['user'];
		if($userName){
			$this->user = $this->getUser($userName);
		}else{
			if($config['CONTROLLER'] != 'login'){
				$this->redirect(config::get('URL_THIS').'login');
			}
		}
    }
	
	// 消息提示
	protected function msg($msg){
		echo ('<script>alert("'. $msg .'")</script>');
	}
	
	
	// 获取用户信息
	protected function getUser($userName){
		$dbpre = config::get('DB_PREFIX');
		$sql="
		SELECT A.*,CONCAT(B.folder,'/',B.file) AS {$dbpre}avatar
		FROM {$dbpre}user A
		LEFT JOIN {$dbpre}upload B ON B.pid=A.id
		WHERE A.name='{$userName}' AND B.type='avatar'
		";
		$data= $this->model->query($sql); 
		return isset($data[0]) ? $data[0] : false;
	}

} 
