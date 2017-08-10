<?php defined('PX') or die('PXCMS');

/* 
	配置模型
*/

class settingModel extends baseModel{

    //保存配置
    public function save($array,$file) {
        if (empty($array) || !is_array($array)) {
            return false;
        }
        $config = @file_get_contents($file); //读取配置
        foreach ($array as $name => $value) {
			//转义特殊字符，再传给正则替换
            $name = str_replace(array("'", '"', '[','*'), array("\\'", '\"', '\[','\*'), $name); 
            if (is_string($value) && !in_array($value, array('true', 'false', '3306'))) {
                if(!is_numeric($value)){
					//如果是字符串，加上单引号
                    $value = "'" . $value . "'"; 
                }
            }
			//查找替换
            $config = preg_replace("/(\\$" . $name . ")\s*=\s*(.*?);/i", "$1={$value};", $config); 
        }
        // 写入配置
		return @file_put_contents($file, $config);
    }
	
	//禁用菜单
    public function save_edit($data){
        $data['status']=$status;
        $this->model->table('admin_menu')->data($data)->where('id='.$id)->update(); 
    }

} 
