<?php
/*
Plugin Name: 贴图库云存储
Version: 1.1.0
Plugin URL:http://open.tietuku.com/plugins#emlog
Description: 将您博客上传的图片存储在贴图库云存储中并返回外链，无限空间、无限流量、无限数量、无水印、永久保存、高速cdn外链。。。  
ForEmlog:5.2.0
Author: tietuku.com
Author URL: http://tietuku.com
*/
!defined('EMLOG_ROOT') && exit('access deined!');
function plugin_setting_view(){
	require_once 'tietuku_config.php';
	?>
	<link href="<?php echo BLOG_URL ;?>content/plugins/tietuku/template/style.css?v=1.0.0" type="text/css" rel="stylesheet" />
	<div class="com-hd">
		<b>贴图库图床插件设置</b>
		<?php
		if(isset($_GET['setting'])){
			echo "<span class='actived'>设置保存成功!</span>";
		}
		?>
	</div>
	<form action="plugin.php?plugin=tietuku&action=setting" method="post">
		<table class="tb-set">
			<tr>
				<td align="right"><b>accesskey：</b></td>
				<td><input type="text" class="txt txt-sho" name="accesskey" value="<?php echo $tietuku_config["accesskey"]; ?>" /></td>
				<td align="right"></td>
			</tr>
			<tr>
				<td align="right"><b>secretkey：</b></td>
				<td><input type="text" class="txt txt-sho" name="secretkey" value="<?php echo $tietuku_config["secretkey"]; ?>" /></td>
				<td align="right"></td>
			</tr>
			<tr>
				<td align="right"><b>相册ID：</b></td>
				<td><input type="text" class="txt txt-sho" name="album" value="<?php echo $tietuku_config["album"]; ?>" /></td>
				<td align="right"></td>
			</tr>
			<tr>
				<td align="right"><b>返回图片方式:</b></td>
				<td><input type="text" class="txt txt-sho" name="r_url" value="<?php echo $tietuku_config["r_url"]; ?>" /></td>
				<td align="right">1缩略图 2展示图 3原图</td>
			</tr>
			<tr>
				<td align="right"><b>是否去掉图片外链:</b></td>
				<td><input type="text" class="txt txt-sho" name="wailian" value="<?php echo $tietuku_config["wailian"]; ?>" /></td>
				<td align="right">1不去掉外链 2去掉外链</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" name="submit" value="保存" />
				<td align="right"></td>
				</td>
			</tr>
		</table>
	</form>
1、accesskey、secretkey、相册ID 这三项如果不填写（三项必须全部留空），将以游客的形式上传，您将无法管理上传的图片；<br>
2、如果需要管理上传的图片，请将以上三项全部填写无误，获取地址：<a href="http://open.tietuku.com/manager" target="_blank">贴图库开放平台</a>；<br>
3、返回图片方式如果留空则默认返回展示图；<br>
返回图片方式说明：<br>
1缩略图：宽度不超过300<br>
2展示图：宽度不超过800（建议选择，避免超大图片导致网页撑破或者网页卡顿）<br>
3原图：不进行任何压缩<br>
返回图片方式填写方式：请直接填写 1/2/3，分别对应 缩略图/展示图/原图
</div>
	<?php
}

function plugin_setting(){
	$accesskey = addslashes($_POST["accesskey"]);
	$secretkey = addslashes($_POST["secretkey"]);
	$album = addslashes($_POST["album"]);
	$r_url = addslashes($_POST["r_url"]);
	$wailian = addslashes($_POST["wailian"]);
	$newConfig = '<?php
$tietuku_config = array(
	"accesskey" => "'.$accesskey.'",
	"secretkey" => "'.$secretkey.'",
	"album" => "'.$album.'",
	"r_url" => "'.$r_url.'",
	"wailian" => "'.$wailian.'",
);';
	echo $newConfig;
	@file_put_contents(EMLOG_ROOT.'/content/plugins/tietuku/tietuku_config.php', $newConfig);
}
?>