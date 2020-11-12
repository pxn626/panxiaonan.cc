<?php
!defined('EMLOG_ROOT') && exit('access deined!');
function plugin_setting_view() {
	include 'xjalert_config.php';
	echo '<div class=containertitle><b>搜索引擎交互</b>';
	if (isset($_GET['setting']))
		echo '<span class="actived">插件设置完成</span>';
	echo '</div><div class=line></div>';
?>
<div class="post">
  <div class="des" style="margin: 5px 0; width: 500px;background-color: #FFFFE5;padding: 5px 10px;border: 1px #CCCCCC solid;clear: both;border-radius: 4px;">如有问题联系<a href="http://www.youngxj.cn">杨小杰博客</a></div>
<form action="plugin.php?plugin=xjalert&action=setting" method="post">
    <div>
    ICO图片地址:<input type="text" name="ico" value='<?php echo $config["ico"];?>'><br/>
    layerjs开关:<input type="radio" name="layeron" value="1" <?php if ($config["layeron"] == 1) { echo 'checked'; } ?>>开
    <input type="radio" name="layeron" value="0" <?php if ($config["layeron"] != 1) { echo 'checked'; } ?>>关
      <p><small>主要是防止一些模版已经调入layerjs</small></p>
    layer自动退出时间:<input type="text" name="outtime" value='<?php echo $config["outtime"];?>'><small>1秒=1000</small>
    </div>
	<p><input type="submit" value="保存设置"  class="button"/></p>
</form>
</div>
<?php
}

function plugin_setting() {
	$newConfig = '<?php
$config = array(
	"ico" => "'.$_POST["ico"].'",
    "outtime" => "'.$_POST["outtime"].'",
    "layeron" => "'.$_POST['layeron'].'",
);';
	@file_put_contents(EMLOG_ROOT.'/content/plugins/xjalert/xjalert_config.php', $newConfig);
}
?>
