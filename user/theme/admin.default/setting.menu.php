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
	<b>菜单管理</b>
	  <a href="<?=$config['URL_ACTION'].'add'?>" class="btn" style="float:right">添加</a>
	  <hr>
	  <table>
        <thead>
          <tr>
          <th style="text-align:center;">ID</th>
          <th style="text-align:center;">名称</th>
          <th style="text-align:center;">顺序</th>
          <th style="text-align:center;">模块名</th>
          <th style="text-align:center;">控制器</th>
          <th style="text-align:center;">方法</th>
          <th style="text-align:center;">显示</th>
          <th style="text-align:center;">操作</th>	
          </tr>
        </thead>
        <tbody>
	      <?php foreach ($menu as $key=>$v){ ?>
          <tr>
          <td style="text-align:center;"><?=$v['id']?></td>
          <td <?php if(!$v['pid']){echo 'style="font-weight: bold"';}?>><?=$v['cname']?></td>
          <td style="text-align:center;"><?=$v['sequence']?></td>
          <td style="text-align:center;"><?=$v['module']?></td>
          <td style="text-align:center;"><?=$v['controller']?></td>
          <td style="text-align:center;"><?=$v['action']?></td>
          <td style="text-align:center;"><?php echo $v['status']?'<font color=green><b>√</b></font>':'<font color=red><b>x</b></font>';?></td>
          <td style="text-align:center;"><a href="<?=$config['URL_ACTION'].'edit'.$config['URL_PARAM_DEPR'].$v['id']?>" class=".btm">编辑</a> | <a href="<?=$config['URL_ACTION'].'del'.$config['URL_PARAM_DEPR'].$v['id']?>" class=".btm">删除</a></td>
          </tr>
	  	<?php } ?>
        </tbody>
      </table>
    </div>
	<?php $this->need('inc.runtime');?>
  </div>
</div>
<?php $this->need('inc.footer');?>
