<?php
/*
ForEmlog: 5.2.0+
Author: 奇遇
Author URL: http://www.qiyuuu.com
*/
!defined('EMLOG_ROOT') && exit('access deined!');

if (!class_exists('CommentPush', false)) {
	include dirname(__FILE__) . '/comment_push.php';
}

//插件激活回调函数
function callback_init() {
	$commentPush = CommentPush::getInstance();
	$table = $commentPush->getPluginTable('device');
	$dbcharset = 'utf8';
	$type = 'MYISAM';
	$add = $commentPush->getDb()->getMysqlVersion() > '4.1' ? "ENGINE=$type DEFAULT CHARSET=$dbcharset;" : "TYPE=$type;";
	$sql = "
	CREATE TABLE IF NOT EXISTS `$table` (
		`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		`name` VARCHAR(256) NOT NULL DEFAULT '',
		`iden` char(32) NOT NULL,
		`push` tinyint(1) unsigned NOT NULL DEFAULT 1,
		PRIMARY KEY (`id`),
		UNIQUE KEY `iden` (`iden`)
	)" . $add;
	$commentPush->getDb()->query($sql);
	$option = $commentPush->query('options', array(
		'option_name'=>$commentPush->getId() . '_key',
	));
	if ($option === false) {
		$commentPush->insert('options', array(
			'option_name'=>$commentPush->getId() . '_key',
			'option_value'=>'',
		));
	}
}
