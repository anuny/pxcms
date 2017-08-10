(function(w, undefined) {
	var $ = px.require('extend::dom');
	
	px.define('public',function(module){
		var exp = {
			'layout':function(options){
				var ele = options.ele;
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
				};
				function init(){
					var headerHeight = $('.header')[0].offsetHeight;
					var winHeight = winSize().height - headerHeight;
					var leftHeight = ele.offsetHeight;
					var rightHeight = $('.main-right')[0].offsetHeight;
					winHeight = (rightHeight > winHeight ? rightHeight : winHeight);
					if(leftHeight < winHeight) ele.style.height = winHeight + 'px';
				};
				$(document).ready(function(){init()})
				$(window).on('resize',function(){init()})
			},
			'notice':function(options){
				var info = options.config;
				var notice = px.require('plugin::notice');
				notice.tip(info);
			}
		};
		module.exports = exp
	});
	px.define('form',function(module){
		var ajax = px.require('plugin::ajax');
		var formData = px.require('plugin::formData');
		var notice = px.require('plugin::notice');
		var exp = {
			'submit':function(options){
				var submitBtn = options.ele;
				var thisForm = submitBtn.form;
				submitBtn.onclick = function(e){
					var array = formData(thisForm);
					var datas = array.datas;
					var thisData = {};
					for(var i in datas) thisData[i] = datas[i]['value'];
					ajax({
						url:array.action,
						type:array.method,
						data:thisData,
						dataType:'json',
						success:function(msg){
							console.log(notice)
							notice.tip(msg);
						},
						error:function(msg){
							notice.tip(msg);
						}
					});
					e.preventDefault();
				}
			}
		};
		return exp;
	})
	
	
	
})();