<?php
/*
Plugin Name: 整站变灰
Version: 1.0
Plugin URL:
Description: 使整个网站变成灰色
ForEmlog:all version
Author: sinkery
Author URL: http://sinkery.com
*/
function grayer(){
	echo "<link href='".BLOG_URL."content/plugins/grayer/grayer.css' rel='stylesheet' type='text/css' />";
}
addAction('index_head', 'grayer');