<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
function callback_init(){
  $DB = Database::getInstance();
  $check_table_exist = $DB->query("show tables like '".DB_PREFIX."internal_link'");
  if($DB->num_rows($check_table_exist) == 0){
    $dbcharset = 'utf8';
    $type = 'MYISAM';
    $add = $DB->getMysqlVersion() > '4.1' ? "ENGINE=".$type." DEFAULT CHARSET=".$dbcharset.";":"TYPE=".$type.";";
    $sql = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."internal_link` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `keyword` varchar(128) NOT NULL,
    `url` varchar(128) NOT NULL,
    `status` int(11) NOT NULL,
    `time` int(11) NOT NULL,
    PRIMARY KEY (`id`)
  )".$add;
  $sqlquery = $DB->query($sql);
  if(!$sqlquery){
    emMsg('新建数据表失败，请检查数据库');
  }
}
}
// 插件禁用执行删除数据表
// function callback_rm(){
//   $DB = Database::getInstance();
//   $query = $DB->query("DROP TABLE IF EXISTS ".DB_PREFIX."internal_link");
// }
?>