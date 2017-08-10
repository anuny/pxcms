<?php defined('PX') or die('PXCMS');
/* 
	登录控制器
*/

class loginController extends baseController {
	
	public function index(){
		if($this->user){
			$this->redirect(config::get('URL_MODULE'));
		}else{
			if(isAjax() && isPost()){
				$this->submit();
			}
			$this->display('login.index');
		}
    }
	
	public function submit(){

		if(empty($_POST['name'])||empty($_POST['password'])){
			$this->msg(false,'帐号信息输入错误!',false);
        }

        //获取帐号信息
        $info=model('user')->getUser($_POST['name']);

        //进行帐号验证
        if(empty($info)){
			$this->msg(false,'登录失败,无此管理员帐号!',false);
        }

        if($info['password']<>md5($_POST['password'])){
			$this->msg(false,'登录失败,密码错误!',false);
        }
		
        if($info['status']=='disable'){
			$this->msg(false,'登录失败,帐号已禁用!',false);
        }
		
        //更新帐号信息
        $data['activated']=time();
        $data['lastip']=get_client_ip();
        $data['loginnum']=intval($info['loginnum'])+1;
		$this->save($data, intval($info['id']));
        //设置登录信息
        $_SESSION['user']=$info['name'];
		$this->msg(true,'登录成功!',config::get('URL_MODULE'));
    }
	
	//更新用户信息
    public function save($data,$id) {
    	$condition['id']=$id;
        $this->model->table('user')->data($data)->where($condition)->update();
    }
	
	//退出
     public function logout(){
        unset($_SESSION['user']);
		$this->redirect(config::get('URL_MODULE'));
     }
}
