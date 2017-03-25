<?php defined('PX') or die('PXCMS');
/* 
	登录页面
*/
?>


<?php foreach ($list as $key=>$plugin){ ?>
<form action="" method="post">
  <li>插件名：<?=$plugin['NAME']?></li>
  <li>文件名：<?=$plugin['FILE']?></li>
  <li>版本号：<?=$plugin['VER']?></li>
  <li>作者：<?=$plugin['AUTHOR']?></li>
  <li>简介：<?=$plugin['DESCRIPTION']?></li>
  <?php if(empty($plugin['id'])) { ?>
  <li><button type="submit" >安装</button></li>
  <?php } ?>
</form>
<?php } ?>
