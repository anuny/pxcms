
(function (riot) {
	'use strict';
	
	riot = 'default' in riot ? riot['default'] : riot;
	
	var app = {
		name : 'app',
		title: 'PXCMS - 纯粹的内容管理系统',
		ids:{
			'header': 'app-header',
			'menu'  : 'app-menu',
			'left'  : 'app-left',
			'right' : 'app-right',
			'content':'app-content'
		},
		tpl:'<div class="header" id="{ id.header }"><div class="logo"><img src="http://pxcms.com/user/theme/admin.default/static/images/logo.png" /></div><div id="{ id.menu }" class="menu"><li each="{ menu }"><a href="#{ controller }" class="{ current: parent.controller === controller }">{ name }</a></li><li class="icon"><a href="http://pxcms.com/" title="网站首页" target="_blank"><i class="iconfont icon-shouyeshouye"></i></a></li><li class="icon"><a href="login/logout" title="安全退出"><i class="iconfont icon-tuichu"></i></a></li></div></div> <div class="container { controller }"><div id="{ id.left }" class="main-left">  <div if="{controller == \'index\'}" class="user-info"><img src="{ user.avatar }" class="avatar"/><h3>{ user.nickname }</h3><p> { user.name } - { user.role.name }</p><p>{ user.description }</p><p>创建时间: { user.created }<br>登录时间: { user.activated }</p><p> <a href="user/profile" class="btn">编辑资料</a></p></div> <ul if="{controller !== \'index\'}" class="sub-menu"><li each="{ submenu }"><a href="#{ controller }/{ action }" class="{ current: parent.action === action }">{ name }</a></li></ul>   </div>       <div id="{ id.right }" class="main-right"><div class="content" id="{ id.content }"></div><div class="runtime">2017-03-31 17:13 CST,Powered by</span> <a class="link-blue" href="http://yesji.com">pxcms</a></div></div></div>',
		uid :function() {
			return "0101100101011010".replace(/[01]/g, function (c) {
				var r = Math.random() * 16 | 0, v = c == '0' ? r : (r & 0x3 | 0x8);
				return v.toString(16);
			});
		},
		setTitle: function (title){
			document.title = title +' - ' + app.title;
		},
		layout:function(){
			function winSize(){
				var winWidth,winHeight
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
			function $(id){
				return document.getElementById(id);
			};
			function init(){
				var leftEle = $(app.ids.left);
				var headerHeight = $(app.ids.header).offsetHeight;
				var winHeight = winSize().height - headerHeight;
				var leftHeight = leftEle.offsetHeight;
				var rightHeight = $(app.ids.right).offsetHeight;
				winHeight = (rightHeight > winHeight ? rightHeight : winHeight);
				if(leftHeight < winHeight) leftEle.style.height = winHeight + 'px';
			};
			init() , window.onresize = function(){init()};
		},
		ajax:function(config){
			if(!config.url)return;
			var xmlhttp=new XMLHttpRequest()||new ActiveXObject('Microsoft.XMLHTTP');
			var type=(config.type||'POST').toUpperCase();
			xmlhttp.onreadystatechange=function(){
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
				xmlhttp.setRequestHeader("request-type","xmlhttprequest");
				xmlhttp.send(null);
			};
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
		},
		getData:function(controller,action,callback){
			app.ajax({
				url:'http://pxcms.com/admin/'+controller+'/'+action,
				data: {timemap:app.uid()},
				type:'GET',
				dataType:'json',
				success:function(ret){
					callback && 'function' ==typeof callback && callback(ret);
				},
				error:function(ret){
				}
			});
		},
		createForm:function(list){
			var tpl = '';
			tpl += '<form action="" method="post" class="form-group">';
			for(var i=0, len=list.length; i<len; i++){
				var self = list[i];
				tpl += '<li>';
				if(self.title){
					tpl += '<label class="label" for="'+ self.name +'">'+self.title+'</label>';
				}
				tpl += '<input id="'+ self.name +'" name="'+ self.name +'" type="'+ self.type +'" class="input" value="{ opts.'+ self.name +' }">';
				if(self.description){
					tpl += '<p class="description">'+ self.description +'</p>'
				}
				tpl += '</li>';
			};
			tpl += '</form>';
			return tpl;
		},
		getTpl:function(controller,action){
			var list=[
				{title: "主机地址",name : "DB_HOST",type : "text",description:"本地连接一般为 localhost 或 127.0.0.1"}
			]
			return app.createForm(list);
	
		},
		renderContent:function(controller,action){
			var content = document.getElementById('app-content');
			content.innerHTML = '';
			var contentTpl = app.getTpl(controller,action);
			riot.tag( 'content', contentTpl,function(){});
			
			app.getData(controller,action,function(data){
				if(data.status){
					riot.mountTo( content,'content',data.config);
				}
			});
		},
		router:function(self){
			var menus = app.data.menu;
			
			route(function(controller,action) {
				
				// 控制器名称
				self.controller = controller || 'index';
				
				// 方法名称
				self.action = action || 'index';

				// 当前页
				self.page = self.menu.filter(function(r) { return r.controller == self.controller })[0] || {};
				
				// 子菜单
				self.submenu = [];
				for(var i = 0, len = menus.length; i < len; i++){
					if(menus[i].pid== self.page.id )self.submenu.push(menus[i]);
				};
				
				// 更新渲染
				self.update();
				
				// 渲染内容
				app.renderContent(self.controller,self.action);
				
				app.setTitle(self.page.name);
				app.layout();
				
			});	
		},
		run:function(opts){
			var self = this;
			
			// 主菜单
			var menu=[];
			
			var menus = app.data.menu;
			for(var i = 0, len = menus.length; i < len; i++){
				if(menus[i].pid<=0)menu.push(menus[i]);
			};

			self.menu = menu;
			
			// 各模块ID名
			self.id = app.ids;

			// 首页
			self.page = self.menu[0];
			
			// 用户
			self.user = app.data.user;

			// 路由
			app.router(self);
		},
		mount:function(data){
			riot.tag( app.name, app.tpl, app.run );
			riot.mount( app.name );
			route.start( true );
		}
	};
	app.ajax({
		url:'http://pxcms.com/admin/',
		data: {timemap:app.uid()},
		type:'GET',
		dataType:'json',
		success:function(ret){
			app.data = ret;
			app.mount();
		},
		error:function(ret){
			
			app.router(ret,opts)
		}
	});
	
})(riot);
