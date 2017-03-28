<?php defined('PX') or die('PXCMS');

/* 
	登录
*/

$this->need('inc.header');
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
    <div class="form-actions">
      <button name="login" id="generate" type="submit" class="btn btn-primary btn-block" >登录</button>
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
	}
	var error = "<?=$error?>";
	if(error != '') tip(error,'error');
</script>
<?php $this->need('inc.footer');?>

