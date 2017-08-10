<?php defined('PX') or die('PXCMS');
/* 
	会员控制器
*/

class userController extends baseController {
	
	public function index(){
		$this->menuFirst();
    }
	
	public function profile(){
		$this->display('user.profile');
		
		if(isPost() && isset($_POST['profile'])){
			$status = $this->submit();
			if($status){
				$this->msg($status,true);
			}else{
				$this->msg($status,false);
			}
		}
		
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
