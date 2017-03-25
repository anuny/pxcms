<?php defined('PX') or die('PXCMS');
/* 
	登录页面
*/
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>Login - YangFei’s Favorite</title>
<link rel="stylesheet" href="<?php echo $config['URL_STATIC'].'css/primer.css';?>">
<link rel="stylesheet" href="<?php echo $config['URL_STATIC'].'css/style.css';?>">
<link rel="stylesheet" href="<?php echo $config['URL_THEME'].'static/css/style.css';?>">
</head>
<body class="login">
<div class="header m-4">YangFei’s Favorite</div>    
<form class="container border p-4" id="form" action="" method="post" onsubmit="return checkForm();">
  <dl class="form-group">
    <dt><label>User Name</label></dt>
    <dd><input name="name" id="name" class="form-control input-block" type="text" placeholder="username/email"></dd>
  </dl>
  <dl class="form-group">
    <dt><label>Password</label></dt>
    <dd><input name="password" id="password" class="form-control input-block" type="password" placeholder="password"></dd>
  </dl>
  <dl class="form-group">
    <div class="form-actions">
      <button name="login" id="generate" type="submit" class="btn btn-primary btn-block" >login</button>
    </div>
  </dl>
  <div id="tip"></div>
  <input name="referer" type="hidden" value="<?php echo $referer;?>">
</form>

<div class="footer m-4"><span class="text-gray">Powered by</span> <a class="link-blue" href="http://yesji.com">Anuny</a></div>
<script>
function $(id){
   return document.getElementById(id);	
}
function tip(msg,type){
	$('tip').innerHTML = '<div class="flash flash-'+(type||"error")+'">'+msg+'</div>'
}
function checkForm(){
   if($('name').value == ""){
	   tip('用户名不能为空','error');
	   return false;
   }
   if($('password').value == ""){
	   tip('密码不能为空','error');
	return false;
   }
}
</script>
</body>
</html>
