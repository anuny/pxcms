<?php defined('PX') or die('PXCMS');
/* 
	header
*/
?>
    <ul class="sub-menu">
	  <?php foreach ($menu as $key => $v){ ?>
		<?php if ($v['controller'] == $config['CONTROLLER'] && $v['pid']){ ?>
		<li><a href="<?=$v['url']?>" <?php if ($v['current']){ echo 'class="current"';}?>><?=$v['name']?></a></li>
		<?php }?>
	  <?php }?>
    </ul>