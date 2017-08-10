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
	  <? echo $msg; ?>
    </div>
	<?php $this->need('inc.runtime');?>
  </div>
</div>



<?php $this->need('inc.footer');?>