(function(w, undefined) {
    "use strict";
    var module = {};
    function Module(id, factory) {
        this.id = id;
        this.factory = factory;
        this.exports = {};
        module[id] = this;
    }
    function getExp(id) {
        var mod = module[id];
        return mod ? "function" == typeof mod.factory ? mod.factory(require, mod) ? mod.factory(require, mod) :mod.exports :mod.factory :id + " is not define";
    }
    function define(id, factory) {
        if (!id || "string" !== typeof id) return;
        new Module(id, factory);
    };
    function require(id, callback) {
        if ("function" == typeof id) return id();
        Array == id.constructor || (id = [ id ]);
        var exports = [];
        for (var i = 0, len = id.length; i < len; i++) {
            var exp = getExp(id[i]);
            exports.push(exp);
        }
        if ("function" == typeof callback) {
            callback.apply(null, exports);
        } else {
            return exports[0];
        }
    };
	w.px = {define:define,require:require};
})(window);

(function(px){
	px.define("plugins::highlight", function() {
		var highlight = function(options) {
			return new highlight.fn.config(options);
		};
		var hasClass = function(node, className) {
			return new RegExp("(\\s|^)" + className + "(\\s|$)").test(node.className);
		};
		var addClass = function(node, className) {
			if (!hasClass(node, className)) node.className = [ node.className, className ].join(" ").replace(/(^\s+)|(\s+$)/g, "");
		};
		var removeClass = function(node, className) {
			if (hasClass(node, className)) node.className = node.className.replace(new RegExp("(\\s|^)" + className + "(\\s|$)", "g"), " ").replace(/(^\s+)|(\s+$)/g, "");
		};
		var attr = function(node,key, value) {
			if(value){
				node.setAttribute(key, value);
			}else{
				return node.getAttribute(key);
			}
        };
		var parseHTML = function(source) {
            return source.replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/(\r?\n)$/g, "");
        };
		
		function htmlEntities(source) {
			return source.replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/&(?![\w\#]+;)/g, '&amp;');
		};
		function addLineNumber(html) {
            var newHtml = '<ol start="1">', htmls = html.split("\n");
            for (var i = 0, len = htmls.length; i < len; i++) {
                newHtml += '<li>' + htmls[i] + '</li>';
            }
            newHtml += "</ol>";
            return newHtml;
		}
		highlight.fn = highlight.prototype = {
			constructor:highlight,
			config:function(options) {
				this.options = options;
				this.data = this._getPre();
				this.language = {
					generic : {
						comment: { pattern: /(\/\/.*|\/\*([\s\S]*?)\*\/)/g, style: 'comment' },
						string: { pattern: /((\'.*?\')|(\".*?\"))/g, style: 'string' },
						numbers: { pattern: /(\-?(\d+|\d+\.\d+|\.\d+))/g, style: 'number' },
						regex: { pattern: /([^\/]\/[^\/].+\/(g|i|m)*)/g, style: 'number' },
						keywords: { pattern: /(?:\b)(function|for|foreach|while|if|else|elseif|switch|break|as|return|this|class|self|default|var|false|true|null|undefined)(?:\b)/gi, style: 'keyword' },
						operators: { pattern: /(\+|\-|\/|\*|\%|\=|\&lt;|\&gt;|\||\?|\.)/g, style: 'operators' }
					}
				};
				return this;
			},
			_getPre:function(){
				var node = [];
				var parents = document.getElementsByTagName('pre');
				var pattern  = /\blang(?:uage)?-(\w+)\b/i;
				for(var i=0,len = parents.length;i<len;i++){
					var parent = parents[i];
					var children = parent.getElementsByTagName('code')[0];				
					var className = attr(parent,'class');
					var source='';
					var language = null;
					if(children){
						source = children.innerText;
						className = attr(children,'class');
					}else{
						source = parent.innerText;
					};
					
					if(className){
						language = getLang(className);
					};
					node.push({element:{pre:parent,code:children},language:language,source:source})	
				};
				function getLang (className){
					var match = className.match(pattern);
					if (match) {
						var language = match[1];
					};
					if (language) {
						language = language.toLowerCase();
					};
					return language;
				};
				return node;
			},
			extend:function(options){
				var language = options.language,
				suffix=options.suffix,
				rule = options.rule;
				this.language[language] = rule;	
				if(suffix && Array == suffix.constructor){
					for(var i=0,len=suffix.length;i<len;i++){
						this.language[suffix[i]] = rule;	
					}
				};
			},
			init:function(){
				var pres = this.data;
				for(var i=0,len=pres.length;i<len;i++){
					var pre = pres[i].element.pre,code = pres[i].element.code,language = pres[i].language,source = pres[i].source;
					
					if(this.options.warp){
						var style = 'white-space:pre-wrap;word-wrap:break-word';
						pre.style.cssText= style;
						if(code){
							code.style.cssText= style;
						}
					};
					source = htmlEntities(source);
					if(language){
						html = this._highlight(source,language);
						addClass(pre,'px-highlight');
					}
					
					if(this.options.line){
						html = addLineNumber(html)
					}
					

					if (code) {
						code.innerHTML = html;
					} else {
						pre.innerHTML = html;
					};
						
					
					
				}
			},
			_highlight:function(source,lang){
				var This = this,sublangsi = 0,sublangs = [],lang = This.language[lang];
				
				if(!lang) return source;
				for(var i in lang){
					if(lang.hasOwnProperty(i) && lang[i].language && This.language[lang[i].language]){	
						source = source.replace(lang[i].pattern, function($1, $2, $3){
							sublangs[sublangsi++] = This._highlight($2, lang[i].language);
							return $1.replace($2, '___subtmpl'+ (sublangsi-1) +'___');
						});
					}
				}
				
				
				
				for(var i in lang){
					if(lang.hasOwnProperty(i) && lang[i].language === undefined){
						source = source.replace(lang[i].pattern, "___"+ i +"___$1___end"+ i +"___");
					}
				}

				var lvls = [];
				source = source.replace(/___(?!subtmpl)\w+?___/g, function($0){
					var end = ($0.substr(3,3)=='end')? true:false,
						tag = (!end? $0.substr(3):$0.substr(6)).replace(/_/g,''),
						lastTag = lvls.length>0? lvls[lvls.length-1] : null;
					if(!end && (lastTag == null || tag == lastTag || (lastTag != null && lang[lastTag].embed != undefined && lang[lastTag].embed.indexOf(tag)>=0 ))){
						lvls.push(tag);return $0;
					}else if(end && tag == lastTag){
						lvls.pop();return $0;
					}
					return "";
				});
				for(var i in lang){
					if(lang.hasOwnProperty(i)){
						source = source.replace(new RegExp('___end'+ i +'___','g'), '</span>').replace(new RegExp('___'+ i +'___','g'), '<span class="'+lang[i].style +'">');
					}
				}

				for(var i in lang){
					if(lang.hasOwnProperty(i) && lang[i].language !== undefined && This.language[lang[i].language] !== undefined){
						source = source.replace(/___subtmpl\d+___/g, function($tmpl){
							var i = parseInt($tmpl.replace(/___subtmpl(\d+)___/, "$1"), 10);
							return sublangs[i];
						});
					}
				}
				
				return source;
			}
		};
		
		

		highlight.fn.config.prototype = highlight.fn;
		return highlight;
	});
})(px)

px.define("extend::dom", function() {
    var w = window, doc = w.document, handlerMap = {}, parentsExp = /(?:[\w\-\\.#]+)+(?:\[\w+?=([\'"])?(?:\\\1|.)+?\1\])?|\*|>/gi, simpleExp = /^[\w\-_#]+$/, trimExp = /^\s*|\s*$/g, classExp = /^(?:[\w\-_]+)?\.([\w\-_]+)/, idExp = /^(?:[\w\-_]+)?#([\w\-_]+)/, tagExp = /^([\w\*\-_]+)/, NAN = [ null, null ];
    var dom = function(selector, context) {
        return new dom.fn.init(selector, context);
    };
    dom.fn = dom.prototype = {
        constructor:dom,
        init:function(selector, context) {
            var elements = query(selector, context);
            this.length = 0;
            this.context = context || doc;
            this.selector = selector;
            [].push.apply(this, elements);
            return this;
        },
        each:function(callback) {
            return each(this, callback);
        },
        on:function(eventType, handler) {
            return "function" == typeof handler ? this.each(function(i, ele) {
                ele && on(ele, eventType, handler);
            }) :this;
        },
        off:function(eventType) {
            return this.each(function(i, ele) {
                ele && ele.handlerMap && ele.handlerMap[eventType] && off(ele, eventType);
            });
        },
        getData:function() {
            var This = this;
            var tags = [ "input", "textarea" ];
            var data = {};
            each(tags, function(i, tag) {
                var ele = This.find(tag);
                ele.each(function() {
                    var name = dom(this).attr("name");
                    if (name !== "") {
                        data[name] = dom(this).val();
                    }
                });
            });
            return data;
        },
        find:function(selector) {
            var ele = [];
            this.each(function(i, _ele) {
                _ele = _ele.nodeType == 1 ? _ele :_ele[0];
                ele.push(dom(selector, _ele));
            });
            return dom(ele[0]);
        },
        data:function(name, value) {
            var node = this[0];
            return value ? node && node.dataset && node.dataset[name] ? (node.dataset[name] = value, 
            this) :this.attr("data-" + name, value) :node && node.dataset ? node.dataset[name] :this.attr("data-" + name);
        },
        eq:function(i) {
            return dom([ this[i] ]);
        },
        first:function() {
            return this.eq(0);
        },
        last:function() {
            return this.eq(this.length - 1);
        },
        attr:function(key, value) {
            return value ? this.each(function(k, v) {
                v.setAttribute(key, value);
            }) :this[0].getAttribute(key);
        },
        html:function(html) {
            return html ? this.each(function(k, v) {
                v.innerHTML = html;
            }) :this[0].innerHTML;
        },
        text:function(text) {
            return text ? this[0].innerText ? this.each(function(k, v) {
                v.innerText = text;
            }) :this.each(function(k, v) {
                v.textContent = text;
            }) :this[0].hasOwnProperty("innerText") ? this[0].innerText :this[0].textContent;
        },
        val:function(val) {
            return val ? this.each(function(k, v) {
                v.value = val;
            }) :this[0].value;
        },
        css:function(prop, val) {
            var self = this;
            ('string' == typeof prop && val) ? this.each(function(i, ele) {
                ele.style[prop] = val;
            }) :each(prop, function(k, key) {
                self.css(k, key);
            });
            return this;
        },
        hasClass:function(className) {
            return hasClass(className, this[0]);
        },
        addClass:function(className) {
            return this.each(function(i, ele) {
                if (!dom(this).hasClass(className)) {
                    ele.className = [ ele.className, className ].join(' ').replace(/(^\s+)|(\s+$)/g, '');
                }
            });
        },
        removeClass:function(className) {
            return this.each(function(i, ele) {
                var $this = dom(this);
                if ($this.hasClass(className)) {
                    ele.className = ele.className.replace(new RegExp("(\\s|^)" + className + "(\\s|$)", "g"), " ").replace(/(^\s+)|(\s+$)/g, "");
                }
            });
        },
        hide:function() {
            return this.each(function(i, ele) {
                ele.style.display = 'none';
            });
        },
        show:function() {
            return this.each(function(i, ele) {
                this.style.display = ' ';
            });
        },
        create:function(html) {
            var div = document.createElement("div"), els = [];
            div.innerHTML = html;
            ele = div.childNodes;
            div = null;
            return ele.length == 1 ? ele[0] :ele;
        },
        append:function(elem) {
            elem = this.create(elem);
			return this.each(function(i,ele){
				ele.appendChild(elem);
			});
        },
		remove:function(){
			var _parentElement = this[0].parentNode;
			 if(_parentElement){
					_parentElement.removeChild(this[0]);
			 }
			 return this;
		},
        scrollTop:function() {
            if (this.selector == window) {
                return window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop;
            }
        },
		height:function(val){
			return val?(this[0].style.height = val+'px',this):this[0].offsetHeight;
		},
		width:function(){
			return this[0].offsetWidth;
		},
        ready:function(callback) {
            /in/.test(doc.readyState) ? setTimeout(callback, 9) :callback();
        }
    };
    function on(ele, eventType, handler) {
        ele["handlerMap"] = {};
        ele["handlerMap"][eventType] = handler;
        doc.addEventListener ? ele.addEventListener(eventType, handler) :ele.attachEvent("on" + eventType, handler);
    }
    function off(ele, eventType) {
        var handler = ele["handlerMap"][eventType];
        doc.removeEventListener ? ele.removeEventListener(eventType, handler) :ele.detachEvent("on" + eventType, handler);
        delete ele["handlerMap"][eventType];
    }
    function getIdName(node) {
        return (node.match(idExp) || NAN)[1];
    }
    function getClassName(node) {
        return (node.match(classExp) || NAN)[1];
    }
    function getTagName(node) {
        return (node.match(tagExp) || NAN)[1];
    }
    function each(object, callback) {
        var name, i = 0, length = object.length;
        if (length == undefined) {
            for (name in object) {
                if (callback.call(object[name], name, object[name]) === false) {
                    break;
                }
            }
        } else {
            for (var value = object[0]; i < length && callback.call(value, i, value) !== false; value = object[++i]) {}
        }
        return object;
    }
    function hasClass(className, node) {
        return new RegExp("(\\s|^)" + className + "(\\s|$)").test(node.className);
    }
    function getByClassName(className, context) {
        var ele, temps = [];
        if (context.getElementsByClassName) {
            ele = context.getElementsByClassName(className);
        } else {
            var nodes = context.getElementsByTagName("*");
            for (var i = 0, len = nodes.length; i < len; i++) {
                var hasclass = hasClass(className, nodes[i]);
                if (hasclass) {
                    temps.push(nodes[i]);
                }
            }
            ele = temps;
            temps = null;
        }
        return ele;
    }
    function getElement(selector, context) {
        var IdName = getIdName(selector), TagName = getTagName(selector), ClassName = getClassName(selector), ele;
        if (selector === "body") {
            ele = doc.body;
        } else {
            if (IdName && context === doc) {
                ele = [ context.getElementById(IdName) ];
            } else {
                if (ClassName && TagName) {
                    var _node = getByClassName(ClassName, context);
                    var classEle = [];
                    each(_node, function(i, ele) {
                        if (ele.tagName.toLowerCase() == TagName) {
                            classEle.push(ele);
                        }
                    });
                    ele = classEle;
                    classEle = null;
                    _node = null;
                } else {
                    if (ClassName) {
                        ele = getByClassName(ClassName, context);
                    } else {
                        if (TagName) {
                            ele = context.getElementsByTagName(TagName);
                        }
                    }
                }
            }
        }
        return ele;
    }
    function makeArray(array) {
        var ret = [];
        if (array != null) {
            var len = array.length;
            if (len == null || array.split || array.setInterval || array.call) {
                ret[0] = array;
            } else {
                each(array, function(i, arr) {
                    ret[i] = arr;
                });
            }
        }
        return ret;
    }
    function query(selector, context) {
        var ele;
        selector = selector || doc;
        context = context || doc;
        (selector === w || selector === doc) && (context = selector);
        if ("string" == typeof selector) {
            selector = selector.replace(trimExp, "");
            var simple = simpleExp.test(selector);
            if (simple) {
                ele = getElement(selector, context);
            } else {
                if (context.querySelectorAll) {
                    ele = context.querySelectorAll(selector);
                } else {
                    selector = selector.match(parentsExp);
                    var node = [ context ], _ele = [];
                    each(selector, function(i, selector) {
                        var IdName = getIdName(selector);
                        _ele = [];
                        if (IdName) {
                            _ele.push(getElement(selector, document)[0]);
                        } else {
                            each(node, function(i, node) {
                                var temps = getElement(selector, node);
                                each(temps, function(i, temp) {
                                    _ele.push(temp);
                                });
                            });
                        }
                        node = _ele;
                    });
                    ele = _ele;
                    node = null;
                    _ele = null;
                }
            }
        } else {
            ele = selector;
        }
        return makeArray(ele);
    }
    dom.fn.init.prototype = dom.fn;
    return dom;
});