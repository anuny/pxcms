(function(w, undefined) {
	// 系统配置
	px.define("ui::config", {
		cookieName:'__px_notice_msg'
	});
	
	// 调用dom操作
	var $ = px.require('extend::dom');
	
	// 页面布局
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
			if(subMenu){
				var winHeight = winSize().height;
				var headerHeight = $('.header')[0].offsetHeight;
				bodyHeight = document.body.scrollHeight;
				winHeight = (bodyHeight > winHeight ? bodyHeight : winHeight) - headerHeight;
				if(subMenu.offsetHeight < winHeight) subMenu.style.height = winHeight + 'px';
			}
			
		}
		mod.exports.init = init
	});
	
	
	// 定义cookie操作模块
	px.define("extend::cookie", function(require, mod) {
		function setCookie(name, value , time) {
		  time = time ? parseFloat(time) : 0 ;
		  var exp = new Date();
		  exp.setTime(exp.getTime() + time);
		  document.cookie = name + "=" + encodeURIComponent(value) + ";expires=" + (time ? exp.toGMTString() : 'session');
		}
		function getCookie(name) {
		  var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
		  return (arr = document.cookie.match(reg)) ? decodeURIComponent(arr[2]) : null;
		}
		
		function delCookie(name) {
		  var exp = new Date();
		  exp.setTime(exp.getTime() - 1);
		  var cval = getCookie(name);
		  if (cval != null)
			document.cookie = name + "=" + cval + ";expires=" + exp.toGMTString();
		}
		return {set:setCookie,get:getCookie,del:delCookie}
	});
	
	// 定义提示模块
	px.define("ui::notice", function(require, mod) {
		var cookie = px.require('extend::cookie');
		var config = px.require('ui::config');
		function tipMsg(msg,callback){
			var type = msg.status ? 'notice-success' : 'notice-error';
			$('body').append('<div class="notice '+ type +'">'+ msg.msg +'</div>');
			setTimeout(function(){
				$('.notice').remove();
				callback && 'function' == typeof callback && callback();
			},3000);
			return msg.status ? true : false;
		}

		function notice(msg){
			if(msg.reload){
				cookie.set(config.cookieName,msg.status+"||"+msg.msg)
				location.replace(location.href);
			}else{
				tipMsg(msg);
			}	
		}
		return {init:notice,tip:tipMsg};
	});
	
	// 获取表单数据模块
	px.define("extend::getData", function(require, mod) {
		function init(form){
			var data = {};
			$(form).each(function(index, tag) {
				var tagName = tag.tagName.toUpperCase();
				var $tag = $(tag);
				
				switch(tagName){
				case 'INPUT':
					var name = $tag.attr("name"),
					type = $tag.attr("type"),
					value = $tag.val(),
					checked = $tag.attr("checked");
					checked = checked == "true" || ($tag.hasAttr('checked') && checked !='false');
					
					switch(type){
						case 'radio':
							if(checked) data[name] = {value:value,ele:$tag,type:type};
							break;
						case 'checkbox':	
							var cname = name.replace('[]','');
							if(checked){
								if(data[cname]){
									data[cname]['value'].push(value)
								}else{
									data[cname] = {value:[value],ele:$tag,type:type}
								}
							}
							break;
						default:data[name] = {value:value,ele:$tag,type:type};
					}
					break;
				case 'SELECT':	
					var name = $tag.selector.name;
					$tag.each(function(i,e) {
						var $option = $(this);
						var selected = $option.attr("selected");
						var $value = $option.val();
						selected = selected == "true" || ($option.hasAttr('selected') && selected !='false');
						if(selected)data[name] = {value:$value,ele:$tag,type:type};
					});
					break;
				default:
					var name = $tag.attr("name");
					var type = $tag.attr("type");
					var value = $tag.val();
					data[name] = {value:value,ele:$tag,type:type};
				}
			});
			return data;
		}
        return init;
	});
	
	px.define("extend::ajax",function(require, mod) {
		function ajax(obj) {
			if(!obj.url)return;
			var xmlhttp=new XMLHttpRequest()||new ActiveXObject('Microsoft.XMLHTTP');    //这里扩展兼容性
			var type=(obj.type||'POST').toUpperCase();
			xmlhttp.onreadystatechange=function(){    //这里扩展ajax回调事件
				if (xmlhttp.readyState == 4&&xmlhttp.status == 200&&!!obj.success){
					var result = xmlhttp.responseText;
					result = obj.dataType == 'json' ? eval("("+result+")") : result;
					obj.success(result); 
				}
					
				if(xmlhttp.readyState == 4&&xmlhttp.status != 200&&!!obj.error)
					obj.error();
			};
			if(type=='POST'){
				xmlhttp.open(type, obj.url, obj.async||true);
				xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
				xmlhttp.setRequestHeader("request-type","xmlhttprequest");
				xmlhttp.send(_params(obj.data||null));
			}
			else if(type=='GET'){
				xmlhttp.open(type, obj.url+'?'+_params(obj.data||null), obj.async||true);
				xmlhttp.send(null);
			}
		};
		//_params函数解析发送的data数据，对其进行URL编码并返回
		function _params(data,key) {
			var params = '';
			key=key||'';
			var type={'string':true,'number':true,'boolean':true};
			if(type[typeof(data)])
				params = data;
			else
				for(var i in data) {
					params+= type[typeof(data[i])] ? ("&" + key + (!key?i:('['+i+']')) + "=" +data[i]) : _params(data[i],key+(!key?i:('['+i+']')));
				}
			return !key?encodeURI(params).replace(/%5B/g,'[').replace(/%5D/g,']'):params;
		};
		return ajax
	})
	
	// 表单提交模块
	px.define("extend::form", function(require, mod) {
		var ajax = px.require('extend::ajax');
		var getData = px.require('extend::getData');
		var notice = px.require('ui::notice');
		function init(type){
			var forms  = getForm();
			for(var i=0,len=forms.length;i<len;i++){
				var form = forms[i];
				submit(form);
			}
		}
		function submit(form){
			var thisSubmit = form.submit;
			if(thisSubmit.length){
				thisSubmit.on('click',function(e){
					var thisData = {};
					var data = getData(form.ele);
					for(var i in data) thisData[i] = data[i]['value'];
					ajax({
						url:form.action,
						type:form.method,
						data:thisData,
						dataType:'json',
						success:function(msg){
							console.log(msg.status)
							if(msg.status){
								notice.init({status:msg.status,msg:msg.msg,reload:true});
							}
							
						},
						error:function(msg){
						}
					});
					e.preventDefault();
					
				})
			}
		};
		function attr(node, key, value) {
			return value?node.setAttribute(key, value):node.getAttribute(key);
        }
		
		function getForm(){
			var  forms = $('form');
			var ret=[];
			forms.each(function(i,e){
				var form = $(this);
				var method = attr(e,'method') || 'post';
				var action = attr(e,'action') || ''; 
				form.each(function(_i,_e){
					var type = $(this).attr('type');
					if(type == 'submit') ret.push({ele:form,method:method,action:action,submit:$(this)});
				})
			})
			return ret;
		}
		
		return {submit:init};
	});
	

	
	
	var layuot = px.require('ui::layuot');
	
	$(document).ready(function(){
		layuot.init();
	})
	
	$(window).on('resize',function(){
		layuot.init();
	})
	
	

	// 刷新页面显示提示
	var cookie = px.require('extend::cookie');
	var config = px.require('ui::config');
	var notice = px.require('ui::notice');
	var msg_cookie = cookie.get(config.cookieName);
	if(msg_cookie){
		var msgArr = msg_cookie.split('||');
		notice.tip({status:msgArr[0],msg:msgArr[1]});
		cookie.del(config.cookieName);
	}
})();