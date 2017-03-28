<?php defined('PX') or die('PXCMS');
/* 
	注册控制器
*/

class registerController extends baseController {
	
	public function index(){
		if(isPost() && isset($_POST['register'])){
			$user = array('name'=>$_POST['name'],'password'=>$_POST['password'],'repassword'=>$_POST['repassword']);
			$this->assign('user',$user);
			$msg = $this->submit();
			if($msg['status']){
				$_SESSION['user']=$_POST['name'];
				$this->redirect(config::get('URL_THIS'));
			}else{
				$this->assign('error',$msg['msg']);
			}
		} 
		$this->display('register.index');
    }
	
	public function submit(){
		
		if(empty($_POST['name'])){
			return array('msg'=>'注册账号不能为空!','status'=>0);
        }
		
		if(empty($_POST['password'])){
			return array('msg'=>'注册密码不能为空!','status'=>0);
        }
		
		if(empty($_POST['repassword'])){
			return array('msg'=>'重复密码不能为空!','status'=>0);
        }
		
		if($_POST['password'] != $_POST['repassword']){
			return array('msg'=>'两次输入密码不一致!','status'=>0);
        }

        //获取帐号信息
        $info=model('user')->getUser($_POST['name']);

        //进行帐号验证
		if($info['id']){
			return array('msg'=>'帐号已经存在!','status'=>0);
        }

		$data = array(
			'name' => $_POST['name'],
			'password' => md5($_POST['password']),
			'activated' => time(),
			'lastip' => get_client_ip()
		);

		$status = $this->save($data);
		
        //设置登录信息
		return $status ? array('msg'=>'注册成功!','status'=>$status) : array('msg'=>'注册失败!','status'=>0); 
    }
	
	//更新用户信息
    public function save($data) {
        return $this->model->table('user')->data($data)->insert();
    }
}
