{%- extends "@layout.tpl" %}
{%- set info = {"url":"index.html","title":"首页"} %}

{%- block page %}
<div class="container">
  <div class="main-left">
    <ul class="sub-menu">
      <li><a href="#">分类管理</a></li>
  	  <li><a href="#" class="current">文章管理</a></li>
  	  <li><a href="#">标签管理</a></li>
  	  <li><a href="#">评论管理</a></li>
  	  <li><a href="#">文件管理</a></li>
    </ul>
  </div>
  <div class="main-right">
    <div class="content">
	  ...
    </div>
	<div class="runtime">Done in 0.0287 second(s)    2017-03-25 9:03 CST</div>
  </div>
</div>
{% endblock -%}
