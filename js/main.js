(function($){
	//var $=jQuery;
	$(document).ready(function(){
		var w = $(window).width();
		var fw = w-280;
		var cw = fw-20-100-20-220;
		$(".feed").css("width",fw);
		$(".feed .content").css("width",cw);
	});
}(jQuery));