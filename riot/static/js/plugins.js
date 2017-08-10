(function(w, undefined) {
	var ajax = function(config) {
		return new ajax.fn.init(config);
	};
	ajax.fn = ajax.prototype = {
		constructor:ajax,
		init:function(config) {
			if(!config.url)return;
			var xmlhttp=new XMLHttpRequest()||new ActiveXObject('Microsoft.XMLHTTP');    //这里扩展兼容性
			var type=(config.type||'POST').toUpperCase();
			xmlhttp.onreadystatechange=function(){    //这里扩展ajax回调事件
				if (xmlhttp.readyState == 4&&xmlhttp.status == 200&&!!config.success){
					var result = xmlhttp.responseText;
					result = config.dataType == 'json' ? eval("("+result+")") : result;
					config.success(result); 
				}
					
				if(xmlhttp.readyState == 4&&xmlhttp.status != 200&&!!config.error)
					config.error();
			};
			if(type=='POST'){
				xmlhttp.open(type, config.url, config.async||true);
				xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
				xmlhttp.setRequestHeader("request-type","xmlhttprequest");
				xmlhttp.send(_params(config.data||null));
			}
			else if(type=='GET'){
				xmlhttp.open(type, config.url+'?'+_params(config.data||null), config.async||true);
				xmlhttp.send(null);
			}
		}
	};
	ajax.fn.init.prototype = ajax.fn;
	w['ajax'] = ajax;
})(this);