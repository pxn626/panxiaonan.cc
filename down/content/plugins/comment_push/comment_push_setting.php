<?php
/*
ForEmlog: 5.2.0+
Author: 奇遇
Author URL: http://www.qiyuuu.com
*/
!defined('EMLOG_ROOT') && exit('access deined!');

//插件设置页面
function plugin_setting_view() {
	CommentPush::getInstance()->setting();
}

//插件设置函数，不用
function plugin_setting() {
}