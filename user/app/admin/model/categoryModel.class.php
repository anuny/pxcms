<?php defined('PX') or die('PXCMS');

/* 
	会员数据模型
*/

class categoryModel extends baseModel{

    // 获取菜单
    public function lists($moduleName='') {
		$data = $this->model->table('category')->where("module='".$moduleName."'")->order('sequence asc')->select();
		$cat = new Category(array('id', 'pid', 'name', 'cname'));
		$tree = $cat->getTree($data, 0);
		$ret = array();
		foreach ($tree as $key=>$value){
			if($value['url'] == ''){
				$value['_url'] = '';
				// 获取链接
				$value['url'] = $this->getUrl($value);
			}
			
			// 获取高亮
			$value = $this->getCur($value);
			$ret[] = $value;
		}
        return $ret;
    }
	
	
	
	protected function getUrl($value){
		$depr = $this->config['URL_DEPR'];
		$url = $value['url'];
		if($url == ''){
			$url = $value['module'].$depr.$value['controller'].$depr.$value['action'].$depr;
			$url = str_replace('index'.$depr,'',$url);
		}
		$url = $this->config['URL_APP'].$url;
		return $url;
	}
	
	protected function getCur($value){
		$thisController = $value['controller'] == $this->config['CONTROLLER'];
		$thisIndex = $value['controller'] == 'index' || $value['controller'] == '';
		$thisAction = $value['action'] == $this->config['ACTION'];
		$isAction = $value['action'] == 'index'||$value['action'] == '';
		
		// 首页
		if($thisIndex && $thisController){
			$value['current'] = true;
		}
		
		// 当前控制器
		if($thisController && !$thisIndex && $isAction){
			$value['current'] = true;
		}
		// 当前方法
		if($thisAction && $thisController){
			$value['current'] = true;
		}
		return $value;
	}

	

} 
