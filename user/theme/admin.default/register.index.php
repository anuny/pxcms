<?php defined('PX') or die('PXCMS');

/* 
	注册
*/


?>
<div class="login-header m-4">PX CMS</div>    
<form class="login-container container border p-4" id="form" action="" method="post" onsubmit="return checkForm();">
  <dl class="form-group">
    <dt><label>用户名</label></dt>
    <dd><input name="name" id="name" class="form-control input-block" type="text" placeholder="username/email" value="<?=$user['name']?>"></dd>
  </dl>
  <dl class="form-group">
    <dt><label>密码</label></dt>
    <dd><input name="password" id="password" class="form-control input-block" type="password" placeholder="password" value="<?=$user['password']?>"></dd>
  </dl>
  <dl class="form-group">
    <dt><label>重复密码</label></dt>
    <dd><input name="repassword" id="repassword" class="form-control input-block" type="password" placeholder="password" value="<?=$user['repassword']?>"></dd>
  </dl>
  <dl class="form-group">
    <div class="form-actions">
      <button name="register" id="generate" type="submit" class="btn btn-primary btn-block" >注册</button>
    </div>
  </dl>
  <div id="tip"></div>
</form> 
<script>
	function $(id){
	   return document.getElementById(id);	
	}
	function tip(msg,type){
		$('tip').innerHTML = '<div class="flash flash-'+(type||"error")+'">'+msg+'</div>';
		return false;
	}
	function checkForm(){
	   if($('name').value == ""){
		   return tip('用户名不能为空','error');
	   }
	   if($('password').value == ""){
		   return tip('密码不能为空','error');
	   }
	   if($('password').value !== $('repassword').value){
		   return tip('两次输入密码不一致','error');
	   }
	}
	var error = "<?=$error?>";
	if(error != '') tip(error,'error');
</script>
<?php $this->need('inc.footer');?>

