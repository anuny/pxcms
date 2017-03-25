<!-- base -->
<!doctype html>
<html lang="zh-cmn-Hans">
<head>
<meta charset="utf-8">
<title>{%- if info.title %}{{info.title}}{%- endif %}{%- if sitename %} - {{sitename}}{%- endif %}</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
{%- if author %}
<meta name="author" content="{{author}}" />
{%- endif %}
{%- if siteurl %}
<meta name="copyright" content="{{siteurl}}" />
{%- endif %}
{%- if keywords %}
<meta name="keywords" content="{{keywords}}" />
{%- endif %}
{%- if description %}
<meta name="description" content="{{description}}" />
{%- endif %}
{%- if favicon %}
<link rel="shortcut icon" href="{{favicon}}"/>
{%- endif %}

<link href="//at.alicdn.com/t/font_8uhz5i5ljs7l23xr.css" rel="stylesheet" type="text/css">
<link href="static/css/style.css" rel="stylesheet" type="text/css">
</head>
<!-- /base -->
<body>
{{local}}
<!-- header -->
<div class="header">
  <div class="logo"><img src="static/images/logo.png"/></div>
  <div class="menu">
    <li><a href="index.html"  class="current">首页</a></li>
    <li><a href="content.html">内容</a></li>
    <li><a href="#">用户</a></li>
	<li><a href="#">扩展</a></li>
    <li><a href="#">设置</a></li>
	<li class="icon"><a href="#" title="网站首页"><i class="iconfont icon-shouyeshouye"></i></a></li>
    <li class="icon"><a href="javascript:firm('确定退出系统吗？')" title="安全退出"><i class="iconfont icon-tuichu"></i></a></li>
  </div>
</div>
<!-- /header --> 

<!-- container --> 
{%- block page %}
{%- endblock %} 
<!-- /container --> 
<!-- footer -->
<script src="static/lib/px.js" type="text/javascript" ></script>
<script src="static/js/main.js" type="text/javascript" ></script>
{%- block script %}
{% endblock %} 
<!-- /footer -->
</body>
</html>