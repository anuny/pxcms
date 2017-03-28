<?php defined('PX') or die('PXCMS');
/* 
	登录控制器
*/

class loginController extends baseController {
	
	public function index(){
		if($this->user){
			$this->redirect(config::get('URL_THIS'));
		}else{
			if(isPost() && isset($_POST['login'])){
				$user = array('name'=>$_POST['name'],'password'=>$_POST['password']);
				$this->assign('user',$user);
				$msg = $this->submit();
				if($msg['status']){
					$this->redirect(config::get('URL_THIS'));
				}else{
					$this->assign('error',$msg['msg']);
				}
			} 
			$this->display('login.index');
		}
    }
	
	public function submit(){
		
		if(empty($_POST['name'])||empty($_POST['password'])){
			return array('msg'=>'帐号信息输入错误!','status'=>0);
        }

        //获取帐号信息
        $info=model('user')->getUser($_POST['name']);

        //进行帐号验证
        if(empty($info)){
			return array('msg'=>'登录失败! 无此管理员帐号!','status'=>0);
        }

        if($info['password']<>md5($_POST['password'])){
			return array('msg'=>'登录失败! 密码错误!','status'=>0);
        }
		
        if($info['status']=='disable'){
			return array('msg'=>'登录失败! 帐号已禁用!','status'=>0);
        }
		
        //更新帐号信息
        $data['activated']=time();
        $data['lastip']=get_client_ip();
        $data['loginnum']=intval($info['loginnum'])+1;
		$this->save($data, intval($info['id']));
        //设置登录信息
        $_SESSION['user']=$info['name'];
		return array('msg'=>'登录成功!','status'=>1); 
    }
	
	//更新用户信息
    public function save($data,$id) {
    	$condition['id']=$id;
        $this->model->table('user')->data($data)->where($condition)->update();
    }
	
	//退出
     public function logout(){
        unset($_SESSION['user']);
		$this->redirect(config::get('URL_THIS'));
     }
}
