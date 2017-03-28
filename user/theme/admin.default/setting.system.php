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
           <input name="DEBUG" type="radio" value="1" id="debug-1" <?php if($config['DEBUG'])echo 'checked="true"' ?>>
           <label for="debug-1">开启</label>
         </span>
         <span>
           <input name="DEBUG" type="radio" value="0" id="debug-0" <?php if(!$config['DEBUG'])echo 'checked="true"' ?>>
           <label for="debug-0">关闭</label>
         </span>
         <p class="description">地址重写即 rewrite 功能是某些服务器软件提供的优化内部连接的功能.<br>打开此功能可以让你的链接看上去完全是静态地址.</p>
        </li>
		
		<li>
         <label class="label">是否开启地址重写功能</label>
		 <span>
           <input name="URL_REWRITE" type="radio" value="1" id="rewrite-1" <?php if($config['URL_REWRITE'])echo 'checked="true"' ?>>
           <label for="rewrite-1">开启</label>
         </span>
         <span>
           <input name="URL_REWRITE" type="radio" value="0" id="rewrite-0" <?php if(!$config['URL_REWRITE'])echo 'checked="true"' ?>>
           <label for="rewrite-0">关闭</label>
         </span>
         <p class="description">地址重写即 rewrite 功能是某些服务器软件提供的优化内部连接的功能.<br>打开此功能可以让你的链接看上去完全是静态地址.</p>
        </li>
		
		<li>
         <label class="label">是否开启Session功能</label>
		 <span>
           <input name="USE_SESSION" type="radio" value="1" id="session-1" <?php if($config['USE_SESSION'])echo 'checked="true"' ?>>
           <label for="session-1">开启</label>
         </span>
         <span>
           <input name="USE_SESSION" type="radio" value="0" id="session-0" <?php if(!$config['USE_SESSION'])echo 'checked="true"' ?>>
           <label for="session-0">关闭</label>
         </span>
         <p class="description">地址重写即 session 功能是某些服务器软件提供的优化内部连接的功能.<br>打开此功能可以让你的链接看上去完全是静态地址.</p>
        </li>
		
		<li>
         <label class="label" for="domain">站点域名</label>
		 <input id="domain" name="APP_DOMAIN" type="text" class="input" value="<?=$config['APP_DOMAIN']; ?>">
         <p class="description">站点域名主要用于生成内容的永久链接.</p>
        </li>
		
		<li>
         <label class="label" for="domain">网址后缀</label>
		 <input id="domain" name="URL_HTML_SUFFIX" type="text" class="input" value="<?=$config['URL_HTML_SUFFIX']; ?>">
         <p class="description">站点域名主要用于生成内容的永久链接.</p>
        </li>
		
		<li>
         <label class="label" for="domain">后台主题</label>
		 <select name="THEME">
            <option value="<?=$config['THEME']; ?>" selected="true"><?=$config['THEME']; ?></option>
		 </select>
         <p class="description">站点域名主要用于生成内容的永久链接.</p>
        </li>
		
		<li>
         <label class="label" for="secretkey">授权密匙</label>
		 <input id="secretkey" name="SECRETKEY" type="text" class="input" value="<?=$config['SECRETKEY']; ?>">
         <p class="description">站点域名主要用于生成内容的永久链接.</p>
        </li>
		
		<li>
         <label class="label" for="timezone">时区设置</label>
		 <input id="timezone" name="TIMEZONE" type="text" class="input" value="<?=$config['TIMEZONE']; ?>">
         <p class="description">站点域名主要用于生成内容的永久链接.</p>
        </li>
		
		<li>
         <label class="label" for="charset">编码设置</label>
		 <input id="charset" name="CHARSET" type="text" class="input" value="<?=$config['CHARSET']; ?>">
         <p class="description">站点域名主要用于生成内容的永久链接.</p>
        </li>
		<li><button type="submit" class="btn" >保存设置</button></li>
		</form>
    </div>
	<?php $this->need('inc.runtime');?>
  </div>
</div>
<?php $this->need('inc.footer');?>