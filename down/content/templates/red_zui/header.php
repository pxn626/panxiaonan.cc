<?php

if(!defined('EMLOG_ROOT')) {exit('Hacker!');}
require_once View::getView('module');
?>
<!DOCTYPE html>
<html>
    <head lang="zh-CN">
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="renderer" content="webkit">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta http-equiv="Cache-Control" content="no-transform">
        <meta http-equiv="Cache-Control" content="no-siteapp">

        <title><?php echo $site_title; ?></title>
      <meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0, user-scalable=no" />
        <meta name="keywords" content="<?php echo $site_key; ?>" />
        <meta name="description" content="<?php echo $site_description; ?>" />
        <meta name="generator" content="red_zui" />

        <!-- 外部样式 -->
        <link href="<?php echo TEMPLATE_URL; ?>images/favicon.ico" rel="shortcut icon">
        <link href="<?php echo TEMPLATE_URL; ?>style/main.css" rel="stylesheet" />
        <link href="<?php echo TEMPLATE_URL; ?>style/hongchen.css" rel="stylesheet" />
        <link href="<?php echo TEMPLATE_URL; ?>style/font-awesome.min.css" rel="stylesheet">	
        <link href="<?php echo TEMPLATE_URL; ?>style/riki.css" rel="stylesheet">

        <!-- 链接信息 -->
        <link rel="EditURI" type="application/rsd+xml" title="RSD" href="<?php echo BLOG_URL; ?>xmlrpc.php?rsd" />
        <link rel="wlwmanifest" type="application/wlwmanifest+xml" href="<?php echo BLOG_URL; ?>wlwmanifest.xml" />
        <link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo BLOG_URL; ?>rss.php" />

        <!--[if lt IE 9]>
            <script src="//cdn.bootcss.com/html5shiv/r29/html5.min.js"></script>
            <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <?php doAction('index_head'); ?>
        <?php doAction('baidu_xz_echo',$logid, $log_title, $log_content, $date); ?>
    </head>
    <body>
        <!-- 导航栏 -->
        <header>
            <div id="header" class="header bg-white">
                <div class="navbar-container">
                    <a href="<?php echo BLOG_URL; ?>" class="navbar-logo">
                        <!--<img src="<?php echo TEMPLATE_URL.'images/logo.png'; ?>" alt="<?php echo $blogname; ?>" title="<?php echo $bloginfo;?>" />-->
                    </a>
                    <div class="navbar-menu">
                        <?php blog_navi();?>
                    </div>

                    <!-- 移动端 -->
                    <div class="navbar-mobile-menu" >
                        <div class="burger">
                            <div class="x"></div>
                            <div class="y"></div>
                            <div class="z"></div>
                        </div>
                        <ul class="bar">
                            <?php mobile_blog_navi();?>
                        </ul>
                    </div>
                </div>
            </div>
        </header>