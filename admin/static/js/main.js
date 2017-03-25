(function(w, undefined) {
	var $ = px.require('extend::dom');
	
	px.define("ui::layuot", function(require, mod) {
		function winSize(){
			if (window.innerWidth) 
			winWidth = window.innerWidth; 
			else if ((document.body) && (document.body.clientWidth)) 
			winWidth = document.body.clientWidth; 
			if (window.innerHeight) 
			winHeight = window.innerHeight; 
			else if ((document.body) && (document.body.clientHeight)) 
			winHeight = document.body.clientHeight; 
			if (document.documentElement && document.documentElement.clientHeight && document.documentElement.clientWidth) {
				winHeight = document.documentElement.clientHeight;
				winWidth = document.documentElement.clientWidth; 
			} 
			return {width:winWidth,height:winHeight}
		} 

		function init(){
			var subMenu= $('.main-left')[0];
			var winHeight = winSize().height;
			var headerHeight = $('.header')[0].offsetHeight;
			bodyHeight = document.body.scrollHeight;
			winHeight = (bodyHeight > winHeight ? bodyHeight : winHeight) - headerHeight;
			if(subMenu.offsetHeight < winHeight) subMenu.style.height = winHeight + 'px';
		}
		mod.exports.init = init
	});
	
	var layuot = px.require('ui::layuot');
	
	$(document).ready(function(){
		layuot.init();
	})
	
	$(window).on('resize',function(){
		layuot.init();
	})
	
	function prom() {  
        //这里需要注意的是，prompt有两个参数，前面是提示的话，后面是当对话框出来后，在对话框里的默认值  
        if (prompt("请输入您的名字", "yyyy"))//如果返回的有内容  
        {  
            alert("欢迎您：" + name)  
        }  
  
    }  
	
	function firm(msg){
		if(confirm(msg)){
			alert(1)
			//window.location.reload();
		}
	}
	
	function art(msg){
		alert(msg)
	}
	
	function getSystem(){
		var msg = '';
		msg += '操作系统：Linux \n';
		msg += '服务器地址：111.67.192.14:80 \n';
		msg += '服务器时间:	2017-03-25 11:27 CST \n';
		msg += 'WEB服务器:	nginx/1.10.3 \n';
		msg += '服务器语言:	zh-CN,zh;q=0.8,zh-TW;q=0.6 \n';
		msg += 'PHP版本:	5.3.29 \n';
		msg += '图像处理支持:	支持 \n';
		msg += 'Session支持:	支持 \n';
		msg += '脚本运行内存:	128M \n';
		msg += '上传大小限制:	50M \n';
		msg += 'POST提交限制:	50M \n';
		msg += '脚本超时时间:	300 s \n';
		msg += '被屏蔽的函数:	passthru,exec,system,chroot,scandir,chgrp,chown,shell_exec,proc_open,proc_get_status,popen,ini_alter,ini_restore,dl,openlog,syslog,readlink,symlink,popepassthru,stream_socket_server \n';
		alert(msg);
	}
	
	window.firm = firm;
	window.prom = prom;
	window.getSystem = getSystem;

})();