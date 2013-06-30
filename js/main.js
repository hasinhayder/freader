(function($){
	//var $=jQuery;
	var admin_url = "/wp-admin/admin-ajax.php";
	$(document).ready(function(){
		var w = $(window).width();
		var h = $(window).height();
		var feed_width = w-280;
		var content_width = feed_width-20-100-20-220;
		var feeds_height = h-205;
		$(".feed").css("width",feed_width);
		$(".feeds").css("height",feeds_height);
		$(".feed .content").css("width",content_width);


		$("#subscribe").bind("click",function(){
			//alert("2");
			var params = {
				action:"subscribe_feed",
				"feed":"http://feeds2.feedburner.com/webresourcesdepot"
			}
			$.post(admin_url,params,function(data){
				alert(data);
			})
		});
	});
}(jQuery));