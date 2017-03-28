<?php defined('PX') or die('PXCMS');
/* 
	注册控制器
*/

class profileController extends baseController {
	
	public function index(){
		if(isPost() && isset($_POST['profile'])){
			$user = array('nickname'=>$_POST['nickname'],'mail'=>$_POST['mail'],'url'=>$_POST['url'],'description'=>$_POST['description']);
			$this->assign('user',$user);
			$msg = $this->submit();
			if($msg['status']){
				$this->redirect(config::get('URL_THIS').'profile');
			}else{
				$this->assign('error',$msg['msg']);
			}
		} 
		
		$this->display('profile.index');
    }
	
	public function submit(){
		$data = array('nickname'=>$_POST['nickname'],'mail'=>$_POST['mail'],'url'=>$_POST['url'],'description'=>$_POST['description']);
		$status = $this->save($data);
		
        //设置登录信息
		return $status ? array('msg'=>'修改成功!','status'=>$status) : array('msg'=>'修改失败!','status'=>0); 
    }
	
	//更新用户信息
    public function save($data) {
		$condition['id']=$this->user['id'];
        return $this->model->table('user')->data($data)->where($condition)->update();
    }
}
