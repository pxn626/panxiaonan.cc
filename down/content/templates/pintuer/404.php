<?php
/**
 * 自定义404页面
 */
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>错误提示-页面未找到</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="/versions/pintuer/2.0/pintuer-custom.css">
<script src="/static/js/baidu.tongji.js"></script>
<?php doAction('index_head'); ?>
</head>
<body>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>错误提示-页面未找到</title>
</head>
<body>
	<div align="center" style="padding-top:100px;">
		<i class="icon-warning-bg text-danger" style="font-size:64px;"></i>
		<div class="margin-top" style="margin-bottom:80px;">
		  <strong>错误提示</strong>
		  <p class="size-small text-gray">抱歉，你所请求的页面不存在！</p>
		</div>
		<a class="button border-main size-small" href="javascript:history.back(-1);">点击返回</a>
	</div>
</body>
</html>
