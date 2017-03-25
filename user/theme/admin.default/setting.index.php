<?php defined('PX') or die('PXCMS');
/* 
	登录页面
*/
$this->need('header');
?>

<form action="" method="post">

<li>调试：<input name="DEBUG" type="text" value="<?=$config['DEBUG']; ?>"></li>
<li>静态：<input name="URL_REWRITE_ON" type="text" value="<?=$config['URL_REWRITE_ON']; ?>"></li>
<li>会话：<input name="USE_SESSION" type="text" value="<?=$config['USE_SESSION']; ?>"></li>
<li>域名：<input name="APP_DOMAIN" type="text" value="<?=$config['APP_DOMAIN']; ?>"></li>
<li>后缀：<input name="URL_HTML_SUFFIX" type="text" value="<?=$config['URL_HTML_SUFFIX']; ?>"></li>
<li>主题：<input name="THEME" type="text" value="<?=$config['THEME']; ?>"></li>
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

<?php $this->need('footer');?>