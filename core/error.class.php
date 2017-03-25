<?php defined('PX') or die('PXCMS');

//错误类
class Error extends Exception {
    private $errorMessage = '';
    private $errorFile = '';
    private $errorLine = 0;
    private $errorCode = '';
	private $errorLevel = '';
 	private $trace = '';

    public function __construct($errorMessage, $errorCode = 0, $errorFile = '', $errorLine = 0) {
        parent::__construct($errorMessage, $errorCode);
        $this->errorMessage = $errorMessage;
		$this->errorCode = $errorCode == 0?$this->getCode() : $errorCode;
        $this->errorFile = $errorFile == ''?$this->getFile() : $errorFile;
        $this->errorLine = $errorLine == 0?$this->getLine() : $errorLine;
      	$this->errorLevel = $this->getLevel();
 	    $this->trace = $this->trace();
        $this->showError();
    }
	
	//获取trace信息
	protected function trace() {
        $trace = $this->getTrace();

        $traceInfo='';
        $time = date("Y-m-d H:i:s");
        foreach($trace as $t) {
            $traceInfo .= '['.$time.'] ' . $t['file'] . ' (' . $t['line'] . ') ';
            $traceInfo .= $t['class'] . $t['type'] . $t['function'] . '(';
            $traceInfo .= ")<br />\r\n";
        }
		return $traceInfo ;
    }
	
	//错误等级
	protected function getLevel() {
	  $Level_array = array(	1=> '致命错误(E_ERROR)',
			2 => '警告(E_WARNING)',
			4 => '语法解析错误(E_PARSE)',  
			8 => '提示(E_NOTICE)',  
			16 => 'E_CORE_ERROR',  
			32 => 'E_CORE_WARNING',  
			64 => '编译错误(E_COMPILE_ERROR)', 
			128 => '编译警告(E_COMPILE_WARNING)',  
			256 => '致命错误(E_USER_ERROR)',  
			512 => '警告(E_USER_WARNING)', 
			1024 => '提示(E_USER_NOTICE)',  
			2047 => 'E_ALL', 
			2048 => 'E_STRICT'
		 );
		return isset( $Level_array[$this->errorCode] ) ? $Level_array[$this->errorCode] : $this->errorCode;
	}
	
	//抛出错误信息，用于外部调用
	static public function show($message="", $code=0) {
		if( function_exists('cp_error_ext') ){
			cp_error_ext($message, $code);
		}else{
			new cpError($message, $code);
		}
    }
		
	

	//判断ajax提交
	protected function isAjax() {
    	if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') return true;
    	if (isset($_POST['ajax']) || isset($_GET['ajax'])) return true; //程序中自定义AJAX标识
    	return false;
	}
	
	//输出错误信息
     protected function showError(){
		//错误页面重定向
		if($error_url != ''){
			echo '<script language="javascript">
				if(self!=top){
				  parent.location.href="'.$error_url.'";
				} else {
				 window.location.href="'.$error_url.'";
				}
				</script>';
			exit;
		}
		
		
	
		if( !defined('__APP__') ) define( '__APP__' , '/');

		if($this->isAjax()){
			$arr = array('status' => 0, 'message' => 'ERROR:'.$this->message.
				'<br>FILE:'.$this->errorFile.
				'<br>LINE:'.$this->errorLine.
				'<br>LEVEL:'.$this->errorLevel.
				'<br>TRACE:'.$this->trace
				);
			@header("Content-type:text/plain");
			echo json_encode($arr);
		}else{
			
			@header("HTTP/1.1 $this->errorCode Not Found");
		
			echo 
			'<!DOCTYPE html>
			<html>
			<head>
			<title>错误提示!</title>
			<meta charset="utf-8" />
			<style>
			body, h1, h2, p,dl,dd,dt{margin: 0;padding: 0;font: 12px/1.5 微软雅黑,tahoma,arial;}
			body{background:#efefef;}
			h1, h2, h3, h4, h5, h6 {font-size: 100%;cursor:default;}
			ul, ol {list-style: none outside none;}
			a {text-decoration: none;color:#447BC4}
			a:hover {text-decoration: underline;}
			.ip-attack{width:600px; margin:200px auto 0;}
			.ip-attack dl{ background:#fff; padding:30px; border-radius:10px;border: 1px solid #CDCDCD;-webkit-box-shadow: 0 0 8px #CDCDCD;-moz-box-shadow: 0 0 8px #cdcdcd;box-shadow: 0 0 8px #CDCDCD;}
			.ip-attack dt{text-align:center;}
			.ip-attack dd{font-size:16px; color:#f00; text-align:center;}
			.tips{text-align:center; font-size:14px; line-height:50px; color:#f00;}
			</style>
			</head>
			<body>
			<div class="ip-attack">
			  <dl>
				<dt style="font-size:18px">';
				echo (($this->errorCode==404 && !DEBUG) ? '404 Not Found!' : $this->message);
			    echo '</dt>';
				
			//开启调试模式之后，显示详细信息
			if($this->errorCode>0 && DEBUG){
				echo  '<div class="error_box">出错文件：'.$this->errorFile.'</div>
				<div class="error_box">错误行：'.$this->errorLine.'</div>
				<div class="error_box">错误级别：'.$this->errorLevel.'</div>
				<div class="error_box">Trace信息：<br>'.$this->trace.'</div>';	
			}

			echo ' 				
			<dt><a href="'.$_SERVER['PHP_SELF'].'"></a>&nbsp;&nbsp;<a href="javascript:history.back()" >返回</a>&nbsp;&nbsp;<a href="'.__APP__.'"></a></dt>
			  </dl>
			</div>
			</body>
			</html>';
		}
		exit;
    }
}