<?php defined('PX') or die('PXCMS');
/* 
	登录页面
*/
$this->need('header');
?>
用户名：<?php echo $user['nickname']; ?>

<a href="<?php echo $system['url']['this']?>">退出</a>


<?php $this->need('footer');?>