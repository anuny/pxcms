<?php defined('PX') or die('PXCMS');
/* 
	登录页面
*/
$this->need('inc.header');
?>

<div class="container">
  <div class="main-left">
    <?php $this->need('inc.sub');?>
  </div>
  <div class="main-right">
    <div class="content">
	  <form action="" method="post" class="form-group">

	    <li>
         <label class="label">是否开启调试模式</label>
         <span>
           <input name="DEBUG" type="radio" value="0" id="debug-0">
           <label for="debug-0">关闭</label>
         </span>
         <span>
           <input name="DEBUG" type="radio" value="1" id="debug-1" checked="true">
           <label for="debug-1">开启</label>
         </span>
         <p class="description">地址重写即 rewrite 功能是某些服务器软件提供的优化内部连接的功能.<br>打开此功能可以让你的链接看上去完全是静态地址.</p>
        </li>
		<li>调试：<input name="DEBUG" type="text" value="<?=$config['DEBUG']; ?>"></li>
		<li>静态：<input name="URL_REWRITE_ON" type="text" value="<?=$config['URL_REWRITE_ON']; ?>"></li>
		<li>会话：<input name="USE_SESSION" type="text" value="<?=$config['USE_SESSION']; ?>"></li>
		<li>域名：<input name="APP_DOMAIN" type="text" value="<?=$config['APP_DOMAIN']; ?>"></li>
		<li>后缀：<input name="URL_HTML_SUFFIX" type="text" value="<?=$config['URL_HTML_SUFFIX']; ?>"></li>
		<li>主题：<input name="THEME" type="text" value="<?=$config['THEME']; ?>"></li>
		<li>密匙：<input name="SECRETKEY" type="text" value="<?=$config['SECRETKEY']; ?>"></li>

		<li>时区：<input name="TIMEZONE" type="text" value="<?=$config['TIMEZONE']; ?>"></li>
		<li>编码：<input name="CHARSET" type="text" value="<?=$config['CHARSET']; ?>"></li>
		<h3>数据库设置</h3>
		<li>主机：<input name="DB_HOST" type="text" value="<?=$config['DB_HOST']; ?>"></li>
		<li>用户：<input name="DB_USER" type="text" value="<?=$config['DB_USER']; ?>"></li>
		<li>密码：<input name="DB_PWD" type="text" value="<?=$config['DB_PWD']; ?>"></li>
		<li>端口：<input name="DB_PORT" type="text" value="<?=$config['DB_PORT']; ?>"></li>
		<li>名称：<input name="DB_NAME" type="text" value="<?=$config['DB_NAME']; ?>"></li>
		<li>前缀：<input name="DB_PREFIX" type="text" value="<?=$config['DB_PREFIX']; ?>"></li>
		<li>编码：<input name="DB_CHARSET" type="text" value="<?=$config['DB_CHARSET']; ?>"></li>
		<li><button type="submit" >修改</button></li>
		</form>
    </div>
	<?php $this->need('inc.runtime');?>
  </div>
</div>



<?php $this->need('inc.footer');?>