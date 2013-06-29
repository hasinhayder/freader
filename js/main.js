(function($){
	//var $=jQuery;
	$(document).ready(function(){
		var w = $(window).width();
		var h = $(window).height();
		var feed_width = w-280;
		var content_width = feed_width-20-100-20-220;
		var feeds_height = h-205;
		$(".feed").css("width",feed_width);
		$(".feeds").css("height",feeds_height);
		$(".feed .content").css("width",content_width);
	});
}(jQuery));