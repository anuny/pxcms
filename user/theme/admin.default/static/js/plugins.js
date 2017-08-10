(function(w, undefined) {
	// 系统配置
	px.define("plugin::config", {
		cookieName:'__px_notice_msg'
	});
	
	// 调用dom操作
	var $ = px.require('extend::dom');
	
	// 定义cookie操作模块
	px.define("plugin::cookie", function(module) {
		function set(name, value , time) {
		  time = time ? parseFloat(time) : 0 ;
		  var exp = new Date();
		  exp.setTime(exp.getTime() + time);
		  document.cookie = name + "=" + encodeURIComponent(value) + ";expires=" + (time ? exp.toGMTString() : 'session');
		}
		function get(name) {
		  var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
		  return (arr = document.cookie.match(reg)) ? decodeURIComponent(arr[2]) : null;
		}
		
		function del(name) {
		  var exp = new Date();
		  exp.setTime(exp.getTime() - 1);
		  var cval = get(name);
		  if (cval != null)
			document.cookie = name + "=" + cval + ";expires=" + exp.toGMTString();
		}
		return {set:set,get:get,del:del}
	});
	
	// 定义提示模块
	px.define("plugin::notice", function(module) {
		var cookie = px.require('plugin::cookie');
		var config = px.require('plugin::config');
		function tipMsg(msg,callback){
			var type = msg.status ? 'notice-success' : 'notice-error';
			var hasHeader = $('.header').length;
			var toped = hasHeader ?'':'notice-top';
			$('body').append('<div class="notice '+ type + ' ' +toped+'">'+ msg.msg +'</div>');
			setTimeout(function(){
				if(msg.isAjax){
					
				}
				if(msg.url){
					if('string' != typeof msg.url){
						msg.url = location.href;
					};
					location.replace(msg.url)
				}
				$('.notice').remove();
				callback && 'function' == typeof callback && callback(msg.status ? true : false);
			},3000);
		}
		return {tip:tipMsg};
	});
	// 定义提示模块
	px.define("plugin::ajax", function(module) {
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
		return ajax;
	});
	// 获取表单数据模块
	px.define("plugin::formData", function(module) {
		function init(form){
			var ret = {
				method:form.getAttribute('method'),
				action:form.getAttribute('action'),
				datas:{}
			};
			$(form).each(function(index, tag) {
				var tagName = tag.tagName.toUpperCase();
				var $tag = $(tag);
				
				switch(tagName){
				case 'INPUT':
					var name = $tag.attr("name"),
					type = $tag.attr("type"),
					value = $tag.val(),
					required= $tag.attr("required"),
					checked = $tag.attr("checked");
					checked = checked == "true" || ($tag.hasAttr('checked') && checked !='false');
					
					switch(type){
						case 'radio':
							if(checked) ret.datas[name] = {value:value,ele:$tag,type:type};
							break;
						case 'checkbox':	
							var cname = name.replace('[]','');
							if(checked){
								if(ret.datas[cname]){
									ret.datas[cname]['value'].push(value)
								}else{
									ret.datas[cname] = {value:[value],ele:$tag,type:type,required:required}
								}
							}
							break;
						default:ret.datas[name] = {value:value,ele:$tag,type:type,required:required};
					}
					break;
				case 'SELECT':	
					var name = $tag.selector.name;
					var required= $tag.selector.getAttribute("required");
					$tag.each(function(i,e) {
						var $option = $(this);
						var selected = $option.attr("selected");
						var $value = $option.val();
						selected = selected == "true" || ($option.hasAttr('selected') && selected !='false');
						if(selected)ret.datas[name] = {value:$value,ele:$tag,type:type,required:required};
					});
					break;
				default:
					var name = $tag.attr("name");
					var type = $tag.attr("type");
					var value = $tag.val();
					var required= $tag.attr("required");
					ret.datas[name] = {value:value,ele:$tag,type:type,required:required};
				}
			});
			return ret;
		}
        return init;
	});
})();