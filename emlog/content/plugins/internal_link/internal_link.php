<?php
/*
Plugin Name: 文章自定义关键词内外链
Version: 1.0
Plugin URL: https://www.youngxj.cn
Description: 将文章内部指定关键词转为指定链接，从而实现seo优化
ForEmlog:5.3.x
Author: 杨小杰
Author Email: blog@youngxj.cn
Author URL: https://www.youngxj.cn
 */
!defined('EMLOG_ROOT') && exit('access deined!');

function link_list()
{
    $DB     = Database::getInstance();
    $result = $DB->query("SELECT * FROM  `" . DB_PREFIX . "internal_link` WHERE `status` = '1'");
    $row    = $DB->fetch_array($result);
    return $row;
}

function content_replace($logData)
{
    $DB          = Database::getInstance();
    $result      = $DB->query("SELECT * FROM  `" . DB_PREFIX . "internal_link` WHERE `status` = '1'");
    $log_content = $logData;
    while ($row = $DB->fetch_array($result)) {
        $link = $row['url'];
        $key  = $row['keyword'];
        if ($_SERVER["REQUEST_URI"] == "/" . $link) {
            $link = "<a title='" . $key . "'>" . $key . "</a>"; //判断是否链接指向本页面，本页面就别跳出去啦。
        } else {
            //不是本页面就用下面开始链接吧，target打开方式，color链接颜色,title链接文字
            $link = "<a href='" . $link . "' target=_blank title='进入" . $key . "相关页面' style='color:#6F8EC5;font-weight: bold;padding: 0 3px 0 3px;'>" . $key . "</a>";
        }
        $link        = preg_replace("/\\\\/", '', $link); //去掉转义用的杠杠
        $log_content = preg_replace("/$key/", $link, $log_content, 1); //开始链接吧，替换内容中关键词
    }
    echo $log_content;
}
