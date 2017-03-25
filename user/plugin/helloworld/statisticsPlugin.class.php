<?php
ob_start();
class statisticsPlugin extends common_pluginMod
{
    public function callback()
    {
		$status=$this->plugin_status();
		if($status){
			$this->record_visits();  // 记录访问数
			$sum=$this->get_visits();
			$sum_ip=$this->get_ip_visits();
			$month=$this->get_visits("DATE_FORMAT(date,'%Y-%m') = '".substr(date('Y-m-d'),0,7)."'"); 
			$month_ip=$this->get_ip_visits("DATE_FORMAT(date,'%Y-%m') = '".substr(date('Y-m-d'),0,7)."'");
			$day=$this->get_visits("DATE_FORMAT(date,'%Y-%m-%d') = '".date('Y-m-d')."'");
			$day_ip=$this->get_ip_visits("DATE_FORMAT(date,'%Y-%m-%d') = '".date('Y-m-d')."'"); 
			$info="{'sum':'$sum','sum_ip':'$sum_ip','month':'$month','month_ip':'$month_ip','day':'$day','day_ip':'$day_ip'}";
		}else{
			$info='插件未安装或未开启！';
		}
		echo $info;
    }
	//获取插件信息
	public function plugin_info(){
        return $info=$this->model->table('plugin')->where('file="statistics"')->find();
    }
	
	//获取插件信息
	public function plugin_status(){
        $info=$this->plugin_info();
		return $info['status'];
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
	foreach ($query as $value) {
		$ip_visits_arr[] = $value['ip'];
	}
	$ip_visits = count($ip_visits_arr);

   return $ip_visits;
  }
}

?>