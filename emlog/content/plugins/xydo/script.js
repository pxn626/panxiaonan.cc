
$(function(){
	$('#close_im').bind('click',function(){
		$('#main-im').css("height","0");
		$('#im_main').hide();
		$('#open_im').show();
	});
	$('#open_im').bind('click',function(e){
		$('#main-im').css("height","272");
		$('#im_main').show();
		$(this).hide();
	});
	$('.fhdb').bind('click',function(){
		$(window).scrollTop(0);
	});
	$(".weixing-container").bind('mouseenter',function(){
		$('.weixing-show').show();
	})
	$(".weixing-container").bind('mouseleave',function(){        
		$('.weixing-show').hide();
	});
});
	$(document).ready(function(){
var min_height = 2200;
		var max_he =1000;
$(window).scroll(function(){
var s =$(window).scrollTop();	
if(s>max_he & s < min_height ){
$("#open_im").show()
}else{
$("#open_im").hide();
	$("#im_main").hide()
}
	setTimeout("$('#open_im').hide()",10000,20000,60000);
});
})
