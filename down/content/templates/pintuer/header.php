<?php
/*
Template Name:拼图2.0
Description:默认模板，简洁优雅
Author:pintuer
Author Url:http://www.pintuer.com
*/
if(!defined('EMLOG_ROOT')) {exit('error!');}
require_once View::getView('module');
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $site_title; ?></title>
<meta name="keywords" content="<?php echo $site_key; ?>" />
<meta name="description" content="<?php echo $site_description; ?>" />
<meta name="generator" content="emlog" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo BLOG_URL; ?>rss.php" />
<link rel="stylesheet" href="<?php echo TEMPLATE_URL; ?>pintuer-2.0.custom.min.css">
<link rel="stylesheet" href="<?php echo TEMPLATE_URL; ?>main.css" />
<script src="<?php echo BLOG_URL; ?>include/lib/js/common_tpl.js" type="text/javascript"></script>
<script src="<?php echo TEMPLATE_URL; ?>jquery-3.4.1.min.js"></script>
<?php doAction('index_head'); ?>
</head>
<body>
<!--导航-->
<?php blog_navi();?>
