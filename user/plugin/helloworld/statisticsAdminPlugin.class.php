<?php

class statisticsAdminPlugin extends common_pluginMod
{
    public function __construct()
    {
        $_GET['_module']='statistics';
        parent::__construct();
    }
    
    //插件附加表信息
    public function plugin_ini_data()
    {
        return array(
            'plugin_statistics',
        );
    }


   
    //首页    
    public function index()
    {
        //模板内赋值		
		$this->sum=$this->get_visits();   //获取总访问量
		$this->sum_ip=$this->get_ip_visits();  // 获取总IP访问量
		$this->month=$this->get_visits("DATE_FORMAT(date,'%Y-%m') = '".substr(date('Y-m-d'),0,7)."'");  //获取当月访问量
		$this->month_ip=$this->get_ip_visits("DATE_FORMAT(date,'%Y-%m') = '".substr(date('Y-m-d'),0,7)."'"); //获取当月IP访问量
		$this->day=$this->get_visits("DATE_FORMAT(date,'%Y-%m-%d') = '".date('Y-m-d')."'");   //获取当日访问量
		$this->day_ip=$this->get_ip_visits("DATE_FORMAT(date,'%Y-%m-%d') = '".date('Y-m-d')."'");  // 获取当日IP访问量
		//$this->record_visits();  // 记录访问数

        $this->show('admin_index.html');
    }
	
	
	 public function reset_visits()
    {
        if($this->reset_fun()){
            $this->msg('统计数据已重置！');
        }else{
            $this->msg('统计数据重置失败！');
        }
    }
	
	 public function reset_fun()
    {
		$delete=$this->model->query("truncate table qnyz.gzhttp_plugin_statistics");
		$this->model->table('plugin_statistics')->truncate();
		if(!$delete){
			return false;
		}else{
			return true;
		}
    }


    
   //获得客户端真实的IP地址
  public function getip(){
   if(getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")){
    $ip = getenv("HTTP_CLIENT_IP");
   }else if(getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")){
    $ip = getenv("HTTP_X_FORWARDED_FOR");
   }else if(getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")){
    $ip = getenv("REMOTE_ADDR");
   }else if(isset ($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")){
    $ip = $_SERVER['REMOTE_ADDR'];
   }else{
    $ip = "unknown";
   }
   return ($ip);
  }
  
  //记录访问数
  public function record_visits(){
	  $ip = $this->getip(); //获得客户端真实的IP地址
    $row = $this->model->table('plugin_statistics')->where('ip="$ip"')->find();
    if(is_array($row)){
     if(!$_COOKIE['visits']){
		$data['counts']=$row['counts']+1;
        $this->model->table('plugin_statistics')->data($data)->where('ip="$ip"')->update();
     }
    }else{
		$data['id']=NULL;
		$data['ip']=$ip;
		$data['counts']=1;
		$data['date']=date('Y-m-d H:i',time());
		$this->model->table('plugin_statistics')->data($data)->insert();
     	setcookie('visits',$ip,time()+3600*24);
    }
  }
  
  //获取总访问量、月访问量、日访问量的共有方法
  private function get_visits($condition = ''){
	  if($condition == ''){
		  $count= $this->model->table('plugin_statistics')->count();
	  }else{
		  $count= $this->model->table('plugin_statistics')->where($condition)->count();
	  }
	  return $count;
  }
  
  //获取IP访问量的共有方法
  private function get_ip_visits($condition = ''){
   	if($condition == ''){
		$query=$this->model->table('plugin_statistics')->field('distinct ip')->select();
   	}else{
		$query=$this->model->table('plugin_statistics')->field('distinct ip')->where($condition)->select();
   	}
	if($query){
		foreach ($query as $value) {
			$ip_visits_arr[] = $value['ip'];
		}
		$ip_visits = count($ip_visits_arr);
	}else{
		$ip_visits = 0;
	}
   return $ip_visits;
  }


 

  


}

?>