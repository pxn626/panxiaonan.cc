<?php
/*
Plugin Name: 搜索引擎来路交互
Version: 1.0
Plugin URL: http://www.youngxj.cn
Description:搜索引擎来路交互
ForEmlog:5.3.x
Author: 杨小杰
Author URL: http://www.youngxj.cn
*/

!defined('EMLOG_ROOT') && exit('access deined!');
function get_referer($referers='',$keyw=''){
	// 避免来路重复
	$localhost = $_SERVER['HTTP_HOST'];

	$keyword = '';

	/*获取网站来路*/
	$referer = $referers ? $referers : $_SERVER['HTTP_REFERER'];
	if(!$referer){
		return false;
	}

	/*获取网站host*/
	$str = parse_url($referer);
	if (!$str['host']||$str['host']==$localhost) {
		return false;
	}
	$url = $str['host'];

	/*关键词判断类型*/
	if(strpos($url,'baidu') !== false){
		$url_str = '百度搜索';
		//来路关键词不能正确识别
	}elseif (strpos($url,'sogou') !== false) {
		$url_str = '搜狗搜索';
		if (strpos($referer,'query=')) {
			//var_dump($referer);
			preg_match_all('/query=(.*)/',$referer,$kw);
			if ($kw[1][0]) {
				$keyword = urldecode($kw[1][0]);
			}
		}
	}elseif (strpos($url,'sm') !== false) {
		$url_str = '神马搜索';
		if (strpos($referer,'q=')) {
			//var_dump($referer);
			preg_match_all('/q=(.*)&from/',$referer,$kw);
			if ($kw[1][0]) {
				$keyword = urldecode($kw[1][0]);
			}
		}
	}elseif (strpos($url,'bing') !== false) {
		$url_str = '必应搜索';
		if (strpos($referer,'q=')) {
			//var_dump($referer);
			preg_match_all('/q=(.*)&qs/',$referer,$kw);
			if ($kw[1][0]) {
				$keyword = urldecode($kw[1][0]);
			}
		}
	}elseif (strpos($url,'google') !== false) {
		$url_str = '谷歌搜索';
		//获取不到来路关键词
	}elseif (strpos($url,'so.com') !== false) {
		$url_str = '360搜索';
		if (strpos($referer,'q=')) {
			//var_dump($referer);
			preg_match_all('/q=(.*)/',$referer,$kw);

			if ($kw[1][0]) {
				$keyword = urldecode($kw[1][0]);
			}
		}
	}elseif (strpos($url,'easou') !== false) {
		$url_str = '宜搜搜索';
		if (strpos($referer,'q=')) {
			preg_match_all('/q=(.*)&pre/',$referer,$kw);
			if ($kw[1][0]) {
				$keyword = urldecode($kw[1][0]);
			}
		}
	}elseif (strpos($url,'yahoo') !== false) {
		$url_str = '雅虎搜索';
		//来路关键词加密
	}else{
		/*如果以上都找不到则使用来路域名并截取字数*/
		if (strlen($url)>5) $url_str=substr($url,0,10) . '...';
	}
	if ($keyw==1) {
		if ($keyword!='') {
			return '您搜索了'.$keyword.'关键词,';
		}else{
			return '';
		}
	}else{
		return $url_str;
	}
	
}
function aler(){
  	include 'xjalert_config.php';
  	$ico = $config['ico'];
  	$outtime = $config['outtime'];
  	$layeron = $config['layeron'];
	if(empty($_COOKIE['xj_alert']) && $_COOKIE['xj_alert']!='1'){if($layeron==1){?>
	<script src="<?php echo BLOG_URL;?>content/plugins/xjalert/layui/layui.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo BLOG_URL;?>content/plugins/xjalert/layui/css/layui.css">
    <?php }?>
	<script>
	var popNotice = function() {
		/*获取用户授权状态*/
		if (Notification.permission == "granted") {  
			var notification = new Notification("<?php if(get_referer()){echo '欢迎来自'.get_referer().'的朋友';}else{echo '您好，欢迎访问我的博客';}?>", {  
                /*很明显这是正文*/
                body: '<?php if(get_referer()){echo get_referer("",1)."若当前文章未能解决您的问题,";}?>您可以先尝试站内搜索，当然也可以给我留言喔(^_^)!',
                /*很明显这是图标*/  
                icon: '<?php echo $ico;?>'  
            });  
            /*消息被点击事件*/
            notification.onclick = function() {  
            	/*window.open("<?php echo $_SERVER['HTTP_REFERER'];?>");*/  
            };  
			/*消息被关闭事件*/
			notification.onclose  = function() {
				notification.close();      
			};
			/*消息出现错误事件*/
			notification.onerror  = function() {  
				alert('上帝也不知道发生了什么');  
				notification.close();      
			};
		}      
	};  

	if (window.Notification) {
		if (Notification.permission == "granted") {
			popNotice();  

		}else if( Notification.permission != "denied"){
			Notification.requestPermission(function (permission) {  
				popNotice();  
			});  
		}  
	} else {
		echo_layer();
	}  
	function echo_layer(){
		layui.define(['layer', 'form'], function(exports){
			var layer = layui.layer
			,form = layui.form;

			layer.open({
				title: '<i class="layui-icon layui-icon-face-smile" style="color: #1E9FFF;"></i> <?php if(get_referer()){echo "欢迎来自".get_referer()."的朋友";}else{echo "您好，欢迎访问我的博客";}?>'
				,content: '<i class="layui-icon layui-icon-group" style="color: green;"></i> <?php if(get_referer()){echo get_referer("",1)."若当前文章未能解决您的问题,";}?>您可以先尝试站内搜索，当然也可以给我留言喔(^_^)!'
				,offset: 'rb'
				,time:<?php echo $outtime;?>
				,anim:2
				,moveOut: true
				,maxmin: true
				,shade: 0
				,btn: ['确认', '关闭']
				,yes: function(index, layero){
					/*window.open("<?php echo $_SERVER['HTTP_REFERER'];?>");*/  
				}
				,btn2: function(index, layero){
				}
				,cancel: function(){ 
				}
			}); 

			exports('index', {}); 
		});    
		
	}
	Notification.requestPermission().then(function(result) {
		if (result === 'denied') {
			echo_layer();
			console.log('许可不获批准。允许重试');
			return;
		}
		if (result === 'default') {
			echo_layer();
			console.log('许可请求被驳回。');
			return;
		}
	});
</script>
<?php } setcookie('xj_alert','1',time()+3600*24*30,'/');}?>
<?php addAction('index_footer','aler');?>