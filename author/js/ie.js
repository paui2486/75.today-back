$(document).ready(function(){
	$.each($(".nav menu li .sub"), function(){
		var w = $(".left", this).outerWidth() + $(".right", this).outerWidth();
		$(".left li", this).width($(".left", this).width());
		$(this).width(w+100).hide();
	});
	
	$(".nav menu li").hover(function(){
		$(".sub", this).show();	
	}, function(){
		$(".sub", this).hide();
	});
});