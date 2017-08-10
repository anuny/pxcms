<?php defined('PX') or die('PXCMS');

/* 
	登录
*/

$this->need('inc.header');
?>
<div class="login-header m-4">PX CMS</div> 

<form id="form-login" action="<?php echo $config['URL_CONTROLLER'];?>" method="post">
  <dl class="form-group">
    <dt><label>用户名</label></dt>
    <dd><input name="name" id="name" class="form-control input-block" type="text" placeholder="username/email" required="required"></dd>
  </dl>
  <dl class="form-group">
    <dt><label>密码</label></dt>
    <dd><input name="password" id="password" class="form-control input-block" type="password" placeholder="password" required="required"></dd>
  </dl>
  <dl class="form-group">
    <div class="form-actions">
      <button name="login" type="submit" app-ctrl="form.submit" >登录</button>
    </div>
  </dl>
</form> 
<?php $this->need('inc.footer');?>


