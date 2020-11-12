<?php
/**
 * Plugin Name:小洋fy导航V1.2
 * Version:1.0
 * Plugin URL:http://www.wuiso.com/admin/
 * Description:温馨提示：插件设置里面可以自定义任何内容，插件部分bug后续升级处理。<br />注意：插件上传后首先点下设置里面的保存设置然后再修改内容，否则容易出错。。
 * Author:小洋
 * Author Email:wuiso@vip.qq.com
 * Author URL:http://www.wuiso.com
 */
!defined('EMLOG_ROOT') && exit('access deined!');
addAction('index_footer', 'xydo_show');

//插件核心配置  修改整站出错
function xydo_show(){
 include 'xydo_config.php';
if($config["show"]==0){$sltznr;}else{if(BLOG_URL.trim(Dispatcher::setPath(),'/')==BLOG_URL){$sltznr;}}
if($config["callt"]=='wy'){echo '<script src="'.BLOG_URL.'include/lib/js/jquery/jquery-1.7.1.js" type="text/javascript"></script>';}
if($config["callt"]=='wy'){echo '<link href="'.BLOG_URL.'content/plugins/xydo/style.css" type="text/css" />';}
;?>
<link href="<?php echo $config["tub"];?>" rel="stylesheet" />
<div class="main-im">
  <div id="open_im" class="open-im"><?php echo $config["name"];?><img src="<?php echo $config["imul"];?>" style="position:absolute;top:100px;right:-3px;<?php if($config["type"] == '2')echo "display:none";?>" title="返回顶部" alt="返回顶部"></div>  
  <div class="im_main" id="im_main">
    <div class="kfbox" id="kfbox" >
<div class="kf_qq"><a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $config["qq"];?>&site=qq&menu=yes" title="点击联系站长" target="_blank"></a></div><div id="close_im" class="close-im"><a href="javascript:void(0);" title="点击关闭">&nbsp;</a></div>
<div style="<?php if($config["num"] == '2')echo "display:none" ;?>">
<div class="kf_diy">
	<a style="color:red;" href="<?php echo $config["log1"];?>"><i class="fa fa-lightbulb-o fa-1" style="margin-right:3px;"></i><?php echo $config["name1"];?></a> 
</div>
<div style="<?php if($config["num"] == '1')echo "display:none" ;?>">
<div class="kf_diy"><a href="<?php echo $config["log2"];?>" target="_blank" rel="nofollow"><i class="fa fa-qq fa-1" style="margin-right:1px;"></i><?php echo $config["name2"];?></a></div>
<div class="kf_wx" ><a href="<?php echo $config["log3"];?>" target="_blank" rel="nofollow" class="thumbnail"><?php echo $config["name3"];?><span><img src="<?php echo $config["wx"];?>" alt="微信二维码图片" width="110" border="0"></span></a></div>
<div style="<?php if($config["num"] == '4')echo "display:none" ;?>">
<div style="<?php if($config["num"] == '3')echo "display:none" ;?>">
<div class="kf_diy"><a style="color:red" href="<?php echo $config["log4"];?>"><i class="fa fa-phone-square fa-1" style="margin-right:3px;"></i><?php echo $config["name4"];?></a></div>
<div style="<?php if($config["num"] == '6')echo "display:none" ;?>">
<div style="<?php if($config["num"] == '5')echo "display:none" ;?>">
<div class="kf_diy" ><a style="color:#F90" href="<?php echo $config["log5"];?>" target="_blank"><i class="fa fa-music fa-1" style="margin-right:3px;"></i><?php echo $config["name5"];?></a></div>
<div class="kf_diy" ><a href="<?php echo $config["log6"];?>" title="所有友情链接页面"><i class="fa fa-globe" style="margin-right:3px;"></i><?php echo $config["name6"];?></a></div></div></div></div>
<div class="kf_diy"><x href="#" style="color:#f90"><a href="<?php echo $config["log7"];?>" target="_blank" title="将网页保存到桌面"><i class="fa fa-desktop fa-1" style="margin-right:3px;"></i><?php echo $config["name7"];?></a></x></div><div style="<?php if($config["num"] == '4')echo "display:none" ;?>">
<div class="kf_diy"><a href="<?php echo $config["log8"];?>" target="_blank"><i class="fa fa-comments fa-1" style="margin-right:3px;"></i><?php echo $config["name8"];?></a></div></div></div></div>
<div class="kf_diy color2"><a class="fhdb"  href="javascript:;" title="返回顶部"><i class="fa fa-paper-plane-o fa-1" style="margin-right:3px;"></i>返回顶部</a></div><div>
</div>
      
    </div>
  </div>
  <?php if($config["wap"]=='n')echo"<style>@media screen and (max-width:800px){.main-im{display:none;}}</style>" ;?>
  <style >
/*main css*/
.main-im{ position:fixed; right: 10px; top:300px;  width: 110px; height: 272px; }
.main-im .img-qq {display: block; }
.main-im .im_main {display:none;}
.main-im .im_main .go-top a { display: block; }
.main-im .close-im {background:url(http://lanyes.org/content/templates/lanye2015/images/kfclose.png) no-repeat; position:absolute;right:0;top:0;width:26px;height:26px;cursor:pointer; }
.main-im .close-im a { display: block;}
.main-im .close-im a:hover { text-decoration: none; }
.main-im .open-im {position:fixed;right:0;bottom:50%;z-index:999;width:15px;background-color:#4FC0EA;background:rgba(79, 192, 234, 0.5215686274509804);color:#fff;font-size:14px;padding:8px 22px 8px 8px;cursor:pointer; }
a{TEXT-DECORATION:none}
#kfopen{position:fixed;right:0;bottom:50%;z-index:999;width:15px;background-color:#8AA653;background:rgba(138, 166, 83, 0.8);color:#fff;font-size:14px;padding:10px;cursor:pointer;}
#kfopen img{position:absolute;top:100px;right:-3px}
#kfopen:hover{background:#f44336}
.kfbox{ position:fixed;right:10px;bottom:20px;z-index:999;width:94px;}
.kfbox .color1{background:#2ecc71;}
.kfbox .color2{background:#e67e22;}
.kfbox .color3{background:#e74c3c;}
.kfbox .color4{background:#3498db;}
.kfbox .color5{background:#1abc9c;}
.kfbox .color6{background:#34495e;}
.kfbox .color7{background:#fff;}
.thumbnail{
position: relative;
z-index: 0;
}
.thumbnail:hover{
background-color: transparent;
z-index: 50;
}
.thumbnail span{ 
position: absolute;
background-color: lightyellow;
padding: 1px;
right: -1000px;
border: 1px dashed gray;
visibility: hidden;
color: black;
text-decoration: none;
}
.thumbnail span img{ 
border-width: 0;
padding: 2px;
}
.thumbnail:hover span{ 
visibility: visible;
top: 0;
right: 88px; 
}
.kf_wx{height:28px;margin-bottom:8px;font-size:14px;text-align:center;line-height:28px;background:#fff;border-radius:4px;box-shadow:0px 1px 1px 0px rgba(0,0,0,0.3);color:#666;}
.kf_wx:hover{background:#f90;}
.kf_wx a:hover{text-decoration:none;color:#fff;}
.color1 a,.color2 a,.color3 a,.color4 a,.color5 a,.color6 a{color:#fff !important;}
.kf_qq{background:url(<?php echo $config["qqimg"];?>) no-repeat;}
.kf_qq {height:80px; background-position:0 0; position:relative;}
.kf_qq .kfclose{background:url(http://lanyes.org/content/templates/lanye2015/images/kfclose.png) no-repeat; position:absolute;right:0;top:0;width:26px;height:26px;cursor:pointer;}
.kf_qq a{ position:absolute;width:94px;height:80px;top:0;left:0;}
.kf_diy{height:28px;margin-bottom:8px;font-size:14px;text-align:center;line-height:28px;background:#fff;border-radius:4px;box-shadow:0px 1px 1px 0px rgba(0,0,0,0.3);color:#666;}
.kf_diy a{color:#666;}
.kf_diy a:hover{text-decoration:none;}
.kf_diy:hover{background:#8aa653}
.kf_diy:hover a{color:#fff;}
.kfbox{position: absolute;top:expression(eval(document.documentElement.scrollTop));}
 </style>
  <script type="text/javascript">
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
		var max_he =<?php echo $config["height"];?>;
$(window).scroll(function(){
var s =$(window).scrollTop();	
if(s>max_he & s < min_height ){
$("#open_im").show()
}else{
$("#open_im").hide();
	$("#im_main").hide()
}setTimeout("$('#<?php if($config["jquery"] == 'y')echo "open" ;else echo"f8899";?>_im').hide()",2000,6000);

});
})
</script>
<script>
function fake_click(obj) {
    var ev = document.createEvent("MouseEvents");
    ev.initMouseEvent(
        "click", true, false, window, 0, 0, 0, 0, 0
        , false, false, false, false, 0, null
        );
    obj.dispatchEvent(ev);
}
 
function export_raw(name, data) {
   var urlObject = window.URL || window.webkitURL || window;
 
   var export_blob = new Blob([data]);
 
   var save_link = document.createElementNS("http://www.w3.org/1999/xhtml", "a")
   save_link.href = urlObject.createObjectURL(export_blob);
   save_link.download = name;
   fake_click(save_link);
}
var test=document.getElementsByTagName('html')[0].outerHTML;
console.log(test);
$('x').click(function() {
export_raw('<?php echo $config["nam"];?>.html', test);
});
</script>
<?php
}
function xydo_side() 
{echo '<div class="sidebarsubmenu" id="xydo"><a href="./plugin.php?plugin=xydo">小洋fy导航设置</a></div>';}
addAction('adm_sidebar_ext', 'xydo_side');