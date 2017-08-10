<?php defined('PX') or die('PXCMS');

/* 
	注册
*/

$this->need('inc.header');
?>

<!-- container -->
<div class="container">
  <div class="main-left" app-ctrl="public.layout">
    <?php $this->need('inc.sub');?>
  </div>
  <div class="main-right">
    <div class="content">
	  <form action="" method="post" onsubmit="return checkForm();" class="form-group">
	    <li>
         <label class="label" for="name">用户名</label>
		 <input id="name" name="name" type="text" class="input" value="<?=$user['name']; ?>" readonly>
         <p class="description">注册后不可更改，如需更改，请联系管理员.</p>
        </li>
		
		<li>
         <label class="label" for="nickname">昵称</label>
		 <input id="nickname" name="nickname" type="text" class="input" value="<?=$user['nickname']; ?>">
         <p class="description">请使用文明的称呼.</p>
        </li>
		
		<li>
         <label class="label" for="mail">邮箱</label>
		 <input id="mail" name="mail" type="text" class="input" value="<?=$user['mail']; ?>">
         <p class="description">用于收取消息提示.</p>
        </li>
		
		<li>
         <label class="label" for="url">网站</label>
		 <input id="url" name="url" type="text" class="input" value="<?=$user['url']; ?>">
         <p class="description">个人网站或博客地址.</p>
        </li>
		
		<li>
         <label class="label" for="description">简介</label>
		 <textarea name="description" id="description" placeholder="description" class="input"><?=$user['description']?></textarea>
         <p class="description">100-200字的个人简介.</p>
        </li>
		
		<li><button name="profile" type="submit" class="btn" >保存设置</button></li>
		</form> 
    </div>
	<?php $this->need('inc.runtime');?>
  </div>
</div>
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

