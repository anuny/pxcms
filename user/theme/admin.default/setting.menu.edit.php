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
	  <form action="" method="post" onsubmit="return checkForm();" class="form-group">
	    <li>
          <label class="label" for="name">菜单名称</label>
		  <input id="name" name="name" type="text" class="input" value="<?php echo $info['name']; ?>">
        </li>
		
		<li>
          <label class="label" for="pid">上级栏目</label>
		  <select name="pid">
		    <option value="0">顶级栏目</option>
		    <?php foreach ($menu as $key=>$v){ ?>
			  <?php if (!$v['pid']){ ?>
                <option value="<?php echo $v['id']; ?>" <?php if($v['id'] == $info['pid']){echo 'selected="true"';}?> <?php if($v['id'] == $info['id']){echo 'disabled="disabled"';}?>><?php echo $v['cname']; ?></option>
			  <?php } ?>
			<?php } ?>
		  </select>
        </li>
		<li>
          <label class="label" for="module">模块名称</label>
		  <input id="module" name="module" type="text" class="input" value="<?php echo $info['module']; ?>">
          <p class="description">对应 app/* 目录.</p>
        </li>
		
		<li>
          <label class="label" for="controller">控制器名称</label>
		  <input id="controller" name="controller" type="text" class="input" value="<?php echo $info['controller']; ?>">
          <p class="description">对应 app/*/*Controller.class.php 文件.</p>
        </li>
		
		<li>
          <label class="label" for="action">方法名称</label>
		  <input id="action" name="action" type="text" class="input" value="<?php echo $info['action']; ?>">
          <p class="description">对应 app/*/*Controller.class.php 文件的*方法.</p>
        </li>
		
		<li>
          <label class="label" for="slug">别名</label>
		  <input id="slug" name="slug" type="text" class="input" value="<?php echo $info['slug']; ?>">
          <p class="description">英文或数字.</p>
        </li>
		
		<li>
          <label class="label" for="sequence">排序</label>
		  <input id="sequence" name="sequence" type="text" class="input" value="<?php echo $info['sequence']; ?>">
          <p class="description">数字越大越靠前.</p>
        </li>
		<li>
          <label class="label">状态</label>
		  <span>
            <input name="status" type="radio" value="1" id="status-1" <?php if($info['status']) echo 'checked="true"'; ?>>
            <label for="status-1">显示</label>
          </span>
          <span>
            <input name="status" type="radio" value="0" id="status-0" <?php if(!$info['status']) echo 'checked="true"'; ?>>
            <label for="status-0">隐藏</label>
          </span>
        </li>
		
		<li>
          <label class="label" for="url">URL</label>
		  <input id="url" name="url" type="text" class="input" value="<?php echo $info['_url']; ?>">
          <p class="description">跳转地址，为空时自动生成.</p>
        </li>
		<input name="id" type="hidden" value="<?php echo $info['id']; ?>">
		<li><button name="edit" type="submit" class="btn" >保存设置</button></li>
      </form> 
    </div>
	<?php $this->need('inc.runtime');?>
  </div>
</div>
<?php $this->need('inc.footer');?>