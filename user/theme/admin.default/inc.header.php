<?php defined('PX') or die('PXCMS');
/* 
	header
*/
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>Login - YangFei’s Favorite</title>
<link href="//at.alicdn.com/t/font_8uhz5i5ljs7l23xr.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo $config['URL_THEME'].'static/css/style.css';?>">
</head>
<body>
<!-- header -->
<?php if($this->data['config']['CONTROLLER'] !=='login'){ ?>
<div class="header">
  <div class="logo"><img src="<?=$this->data['config']['URL_THEME'].'static/images/logo.png"'?> /></div>
  <div class="menu">
  <?php foreach ($menu as $key => $v){ ?>
	<?php if ($v['pid']==0){ ?>
    <li><a href="<?=$v['url']?>" <?php if ($v['current']){ echo 'class="current"';}?>><?=$v['name']?></a></li>
	<?php }?>
  <?php }?>
	<li class="icon"><a href="<?=$this->data['config']['URL_APP']?>" title="网站首页" target="_blank"><i class="iconfont icon-shouyeshouye"></i></a></li>
    <li class="icon"><a href="<?=$this->data['config']['URL_THIS'].'login/logout"'?>" title="安全退出"><i class="iconfont icon-tuichu"></i></a></li>
  </div>
</div>
<!-- /header --> 
<?php }?>