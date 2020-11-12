<?php
	//rootread  qaz123wsx456QAZ123WSX456 bFAXXijtwlEc7YNj
	//rootwrite  WSX123QAZ456wsx123qaz456 zPfuYWopO13S2Cyu
?>
<!DOCTYPE html>
<?php
$interval=120; //2分钟
if(isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])){
    // HTTP_IF_MODIFIED_SINCE即下面的: Last-Modified,文档缓存时间.
    // 缓存时间+时长.
    $c_time = strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE'])+$interval;
    // 当大于当前时间时, 表示还在缓存中... 释放304
    if($c_time > time()){
        header('HTTP/1.1 304 Not Modified');
        exit();
    }
}
header('Cache-Control:max-age='.$interval);
header("Expires: " . gmdate("D, d M Y H:i:s",time()+$interval)." GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
?>
<html lang="zh-CN">	
	<head> 
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
		<link rel='stylesheet' id='nav-css' href='/css/nav.css?ver=2020.2.18' type='text/css' />
		<link rel='stylesheet' id='nav-css' href='/css/footer.css?ver=2020.2.18' type='text/css' />
		<meta name="wlhlauth" content="386539aa9d1708270970c42ca2f1208e"/>
		<title>网中小南-关注网络技术及绿色软件</title>
		<meta name="keywords" content="网中小南,网络技术,电子书,pdf" />
		<meta name="description" content="网中小南是一个关注网络技术及提供电子书下载的网站。" />
		<script type="text/javascript" src="/js/jquery-3.4.1.min.js"> </script>
		<script>
			var _hmt = _hmt || [];
			(function() {
				var hm = document.createElement("script");
				hm.src = "https://hm.baidu.com/hm.js?d3d6396965ad0ab0942122ad7a95e23c";
				var s = document.getElementsByTagName("script")[0]; 
				s.parentNode.insertBefore(hm, s);
			})();
		</script>
        <script data-ad-client="ca-pub-6466638002070963" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-161721772-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());
		  gtag('config', 'UA-161721772-1');
		  gtag('config', 'UA-161688504-1');
		</script>
		<script type="text/javascript">document.write(unescape("%3Cspan id='cnzz_stat_icon_1278713540'%3E%3C/span%3E%3Cscript src='https://v1.cnzz.com/z_stat.php%3Fid%3D1278713540%26online%3D1%26show%3Dline' type='text/javascript'%3E%3C/script%3E"));</script>
		<!--<script src="js/base-loading.js" ></script>-->
	</head>
	<body class="blog">
	<div class="header">
		<div>
			<div>
				<nav class="navbar">
					<ul class="menu" >
						<li><a href="/emlog/">博客</a></li>
					</ul>
                    <ul class="menu" >
						<li><a href="/down/">下载</a></li>
					</ul>
				</nav>
			</div>
			<!--<div id="shortweb">
			<iframe id="shortwebh" src="https://apis.eps.gs/dwz.php" width="500px" height="250px;" background-color="#fff;" scrolling="no" style="border:0px;"></iframe>
			</div>-->
		</div>
	</div>
		<p class="link" >
		友情链接：
		<a href="https://www.coderocku.com" target="_blank" title="coderocku博客">coderocku博客</a>
		<a href="https://blog.cnyouhui.com" target="_blank" title="优汇网博客">优汇网博客</a>
		  
			<?php
	//注意自己网站编码，如果前面已经定义，下面这行可以删除
  		header('Content-Type:text/html; charset=utf-8');
		$testurl = "http://auto.link.2898.com/index/Autochain/AutoChainYL?sign=f9cfad122b7e44df4db7f2c13a56a433&id=284771&dtype=json&text=false&code=utf-8";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $testurl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER,0);
		$output = curl_exec($ch);
		curl_close($ch);
		if($output){
		    $json = json_decode($output,true);
			foreach($json as $valpen){
				$tmp2898[] = '<a href="'.$valpen['reurl'].'" target="_blank">'.$valpen['reurl_title'].'</a>';
			}
			echo implode(' | ',$tmp2898);
		}
	?>
		</p>
		<div id="footer"></div>
	</body>
	<script type='text/javascript' src='/js/header.js?ver=2020.4.4'></script>
	<?php include_once("baidu_js_push.php") ?>
</html>