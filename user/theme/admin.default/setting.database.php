<?php defined('PX') or die('PXCMS');
/* 
	登录页面
*/
$this->need('inc.header');
?>

<div class="container">
  <div class="main-left" app-ctrl="public.layout">
    <?php $this->need('inc.sub');?>
  </div>
  <div class="main-right">
    <div class="content">
	  <form action="" method="post" class="form-group">
		
		<li>
         <label class="label" for="domain">主机地址</label>
		 <input id="domain" name="DB_HOST" type="text" class="input" value="<?=$config['DB_HOST']; ?>">
         <p class="description">本地连接一般为 localhost 或 127.0.0.1</p>
        </li>
		
		<li>
         <label class="label" for="domain">数据库用户名</label>
		 <input id="domain" name="DB_USER" type="text" class="input" value="<?=$config['DB_USER']; ?>">
         <p class="description">站点域名主要用于生成内容的永久链接.</p>
        </li>
		
		<li>
         <label class="label" for="domain">数据库密码</label>
		 <input id="domain" name="DB_PWD" type="password" class="input" value="<?=$config['DB_PWD']; ?>">
         <p class="description">站点域名主要用于生成内容的永久链接.</p>
        </li>

		
		<li>
         <label class="label" for="secretkey">数据库端口</label>
		 <input id="secretkey" name="DB_PORT" type="text" class="input" value="<?=$config['DB_PORT']; ?>">
         <p class="description">一般为3306.</p>
        </li>

		<li>
         <label class="label" for="secretkey">数据库名称</label>
		 <input id="secretkey" name="DB_NAME" type="text" class="input" value="<?=$config['DB_NAME']; ?>">
         <p class="description">站点域名主要用于生成内容的永久链接.</p>
        </li>
		<li>
         <label class="label" for="secretkey">数据表前缀</label>
		 <input id="secretkey" name="DB_PREFIX" type="text" class="input" value="<?=$config['DB_PREFIX']; ?>">
         <p class="description">站点域名主要用于生成内容的永久链接.</p>
        </li>
		<li>
         <label class="label" for="secretkey">数据库编码</label>
		 <input id="secretkey" name="DB_CHARSET" type="text" class="input" value="<?=$config['DB_CHARSET']; ?>">
         <p class="description">站点域名主要用于生成内容的永久链接.</p>
        </li>
		<li><button type="submit" class="btn">保存设置</button></li>
		

		
		</form>
    </div>
	<?php $this->need('inc.runtime');?>
  </div>
</div>



<?php $this->need('inc.footer');?>