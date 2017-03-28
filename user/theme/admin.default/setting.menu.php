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
	  <?php foreach ($menu as $key=>$v){ ?>
		<li <?php if(!$v['pid']){echo 'style="margin-top:20px"';}?>><?=$v['cname']?><?=$v['url']?><a href="">编辑</a></li>
		<?php } ?>
    </div>
	<?php $this->need('inc.runtime');?>
  </div>
</div>




<?php $this->need('inc.footer');?>