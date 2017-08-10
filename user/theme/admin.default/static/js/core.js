(function(files) {
    var win = window;
    var doc = win.document;
	var module = {};
	var px={};
	

	// 构造模块
	function Module(id, factory) {
		this.id      = id;
		this.factory = factory;
		this.exports = {};
		module [id]  = this;
		
	}
	
	//获取模块返回值
	function getExp(id) {
		var mod = module[id];
		return mod ? ("function" == typeof mod.factory ? mod.factory(mod) ? mod.factory(mod) :mod.exports :mod.factory):id + ' is not define';
	}
	
	//定义模块
	px.define = function (id,factory){
		if(!id||'string' !== typeof id) return  id + ' is not string';
		new Module(id,factory);
	}
	
	//获取模块
	px.require = function (id,callback){
		if('function' == typeof id) return id();
		Array == id.constructor||(id = [id]);
		var exports=[];
		for(var i=0,len=id.length;i<len;i++){
			var exp = getExp(id[i])
			exports.push(exp)
		}
		
		if('function' == typeof callback){
			callback.apply(null,exports)
		}else{
			return exports[0]
		}	
	};
	win['px'] = px;
	
	// 加载文件
	function loadFile(uri, callback) {
        var status,isCss = /\.css(?:\?|$)/i.test(uri), node = document.createElement(isCss ? "link" :"script"),
		head = document.getElementsByTagName('head')[0];
        isCss ? (node.rel = "stylesheet", node.href = uri) :(node.type="text/javascript", node.async = true, node.src = uri);
		
		if ('onload' in node) {
            node.onload = function(){
				cbk('load')
			};
            node.onerror = function(){
				cbk('error')
			};
        } else {
          node.onreadystatechange = function() {
            if (/loaded|complete|undefined/.test(node.readyState)) {
                cbk('load');
            }
          }
        }
		function cbk(status){
			callback && callback(status);
			if (!isCss && node.parentNode) node.parentNode.removeChild(node);
			node.onload = node.onerror = node.onreadystatechange = null;
			node = null;
		}
		head.appendChild(node);
    };
	var PATH = (function () {
		var js=document.scripts;
		var thisJs = js[js.length-1].src;
		return thisJs.substring(0,thisJs.lastIndexOf("/")+1);
	})();
	for (var alias in files) loadFile(files[alias].replace('{@path}/',PATH));
	
	
	
	function addEventListener(target, eventName, handler) {
		if (target.addEventListener) {
			target.addEventListener(eventName, handler, false);
		} else {
			target.attachEvent("on" + eventName, function(e) {
				handler.call(target, e);
			});
		} 
	};
	
	// 执行模块
	function init(){
		var allEle = document.getElementsByTagName('*');
		for(var i=0,len=allEle.length;i<len;i++){
			var This = allEle[i];
			var modData = This.getAttribute('app-ctrl');
			if(modData){
				var configStr = This.getAttribute('app-config');
				var config =configStr && JSON.parse(configStr);
				var funs = modData.split('.');
				var mod = funs[0];
				var fun = funs[1];
				px.require(mod,function(exp){
					exp && exp[fun] && 'function' == typeof exp[fun] && exp[fun]({module:modData,ele:This,config:config||{}});
				})
			}
			
		};
	};
	addEventListener(win,'load',init);
})({
	px : "{@path}/px.js",
	plugins : "{@path}/plugins.js",
	json2 : "{@path}/json2.min.js",
	app : "{@path}/app.js"
});