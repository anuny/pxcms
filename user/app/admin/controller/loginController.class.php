<?php defined('PX') or die('PXCMS');

class loginController extends baseController {
	
	public function index(){
		if($this->user){
			$this->redirect(config::get('URL_THIS'));
		}else{
			if(isPost()) $this->submit();
			$this->display('login.index');
		}

    }
	
	public function submit(){
		if(empty($_POST['name'])||empty($_POST['password'])){
            return $this->msg('帐号信息输入错误!');
        }
        //获取帐号信息
        $info=$this->getUser($_POST['name']);

        //进行帐号验证
        if(empty($info)){
            return $this->msg('登录失败! 无此管理员帐号!');
        }

        if($info['password']<>md5($_POST['password'])){
            return $this->msg('登录失败! 密码错误!');
        }
		
        if($info['status']=='disable'){
            return $this->msg('登录失败! 帐号已禁用!');
        }
		
        //更新帐号信息
        $data['activated']=time();
		
        $data['lastip']=get_client_ip();
		
        $data['loginnum']=intval($info['loginnum'])+1;
		
		$this->edit($data, intval($info['id']));

        //设置登录信息
        $_SESSION['user']=$info['name'];
        
        $this->msg('登录成功!');
		
		$this->redirect(config::get('URL_THIS'));
    }
	
	//更新用户信息
    public function edit($data,$id) {
    	$condition['id']=$id;
        $this->model->table('user')->data($data)->where($condition)->update();
    }
	
	//退出
     public function logout(){
        unset($_SESSION['user']);
        $this->msg('退出成功! ');
		$this->redirect(config::get('URL_THIS'));
     }
}
