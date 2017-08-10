
(function(files) {
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
})({
	icon    : '//at.alicdn.com/t/font_8uhz5i5ljs7l23xr.css',
	style   : '{@path}/static/css/style.css',
	
	riot    : '{@path}/static/lib/riot/riot.min.js',
	route   : '{@path}/static/lib/riot/riot-route.min.js',
	plugins : '{@path}/static/js/plugins.js',
	app     : '{@path}/static/js/app.js'	
});