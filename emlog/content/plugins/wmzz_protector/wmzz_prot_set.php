<?php
//用户唯一key
define('WMZZ_PROT_U_KEY', '20785cd3f5eef99876b612e98df5ee9d');
//数据回调统计地址
define('WMZZ_PROT_LOG', 1);
//版本更新地址
define('WMZZ_PROT_UPDATE_FILE','http://safe.wmzz_prot.360.cn/papi/update/?key='.WMZZ_PROT_U_KEY);
//拦截开关(1为开启，0关闭)
$wmzz_prot_switch=1;
//提交方式拦截(1开启拦截,0关闭拦截,post,get,cookie,referre选择需要拦截的方式)
$wmzz_prot_post=1;
$wmzz_prot_get=1;
$wmzz_prot_cookie=1;
$wmzz_prot_referre=1;
//后台白名单,后台操作将不会拦截,添加"|"隔开白名单目录下面默认是网址带 admin  /dede/ 放行
$wmzz_prot_white_directory='admin|\/dede\/';
//url白名单,可以自定义添加url白名单,默认是对phpcms的后台url放行
//写法：比如phpcms 后台操作url index.php?m=admin php168的文章提交链接post.php?job=postnew&step=post ,dedecms 空间设置edit_space_info.php
$wmzz_prot_white_url = array('index.php' => 'm=admin','post.php' => 'job=postnew&step=post','edit_space_info.php'=>'');
?>