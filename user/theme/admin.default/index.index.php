<?php defined('PX') or die('PXCMS');
/* 
	登录页面
*/
$this->need('inc.header');
?>


<div class="container index">
  <div class="main-left" app-ctrl="public.layout">
  <div class="user-info">
    <img src="<?=$user['avatar']?>" class="avatar"/>
	<h3><?=$user['nickname']?></h3>
	<p> <?=$user['name']?> - <?=$user['role']['name']?></p>
	<p><?=$user['description']?></p>
	<p>创建时间: <?=date("Y-m-d H:i",$user['created'])?><br>登录时间: <?=date("Y-m-d H:i",$user['activated'])?></p>
	<p> <a href="<?=$config['URL_THIS'].'user/profile'?>" class="btn">编辑资料</a></p>
  </div>
  
  </div>
  <div class="main-right">
    <div class="content">
	  <div class="info-group">
	    <h3>网站标题</h3>
	    <p>贵州锋华正道科技发展有限公司 <span class="badge b-green">正常运行</span></p>
	  </div>
	  <div class="info-group">
	    <h3>网站地址</h3>
	    <p><a href="#"> http://www.gzhttp.com/</a></p>
	  </div>
	  <div class="info-group">
	    <h3>网站功能</h3>
	    <p>多站点：未启用，手机版：未启用，伪静态：未启用，防火墙:已启用</p>
	  </div>
	  <div class="info-group">
	    <h3>信息统计</h3>
	    <p>栏目：9，内容：34，TAG：0，附件：164，用户：5，评论：5</p>
	  </div>
	  
	  <div class="info-group">
	    <h3>存储空间</h3>
	    <p>共：1 GB ，已使用：61.95 MB，剩余：962.05 MB</p>
	  </div>
	  <div class="info-group">
	    <h3>当前主题</h3>
	    <p><a href="#">default</a></p>
	  </div>
	  <hr>
	  <div class="info-group">
	    <h3>授权用户</h3>
	    <p>贵州锋华正道科技发展有限公司 <span class="badge b-green">正常</span></p>
	  </div>

	  <div class="info-group">
	    <h3>授权域名</h3>
	    <p><a href="#">gzhttp.com </a> <a href="#">www.gzhttp.com </a></p>
	  </div>
	  
	  <div class="info-group">
	    <h3>授权周期</h3>
	    <p>2015-07-19 - 2017-07-19</p>
	  </div>
	  <hr>
	  
	  <div class="info-group">
	    <h3>程序版本</h3>
	    <p>PXPOOL 稳定版 5.8.0</p>
	  </div>

	  <div class="info-group">
	    <h3>官方主页</h3>
	    <p><a href="#">www.gzhttp.com</a></p>
	  </div>
      
	  <div class="info-group">
	    <h3>服务电话</h3>
	    <p>18285090704</p>
	  </div>
	  <div class="info-group">
	    <h3>QQ客服</h3>
	    <p>2904403581</p>
	  </div>
	  <div class="info-group">
	    <h3>BUG反馈:</h3>
	    <p><a href="#">www.gzhttp.com</a></p>
	  </div>
	  <hr>
	  <div class="info-group">
	    <h3>实用工具</h3>
	    <p><a href="javascript:getSystem()">环境信息</a>  <a href="#">BOM清除</a></p>
	  </div>
	  
    </div>
	<?php $this->need('inc.runtime');?>
  </div>
</div>
<?php $this->need('inc.footer');?>