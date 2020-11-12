<?php 
/**
 * 侧边栏组件、页面模块
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<?php
//widget：blogger
function widget_blogger($title){
	global $CACHE;
	$user_cache = $CACHE->readCache('user');
	$name = $user_cache[1]['mail'] != '' ? "<a href=\"mailto:".$user_cache[1]['mail']."\">".$user_cache[1]['name']."</a>" : $user_cache[1]['name'];?>
	<li>
	<h3><span><?php echo $title; ?></span></h3>
	<ul id="bloggerinfo">
	<div id="bloggerinfoimg">
	<?php if (!empty($user_cache[1]['photo']['src'])): ?>
	<img src="<?php echo BLOG_URL.$user_cache[1]['photo']['src']; ?>" width="<?php echo $user_cache[1]['photo']['width']; ?>" height="<?php echo $user_cache[1]['photo']['height']; ?>" alt="blogger" />
	<?php endif;?>
	</div>
	<p><b><?php echo $name; ?></b>
	<?php echo $user_cache[1]['des']; ?></p>
	</ul>
	</li>
<?php }?>
<?php
//widget：日历
function widget_calendar($title){ ?>
	<li>
	<h3><span><?php echo $title; ?></span></h3>
	<div id="calendar">
	</div>
	<script>sendinfo('<?php echo Calendar::url(); ?>','calendar');</script>
	</li>
<?php }?>
<?php
//widget：标签
function widget_tag($title){
	global $CACHE;
	$tag_cache = $CACHE->readCache('tags');?>
	<li>
	<h3><span><?php echo $title; ?></span></h3>
	<ul id="blogtags">
	<?php foreach($tag_cache as $value): ?>
		<span style="font-size:<?php echo $value['fontsize']; ?>pt; line-height:30px;">
		<a href="<?php echo Url::tag($value['tagurl']); ?>" title="<?php echo $value['usenum']; ?> 篇文章"><?php echo $value['tagname']; ?></a></span>
	<?php endforeach; ?>
	</ul>
	</li>
<?php }?>
<?php
//widget：分类
function widget_sort($title){
	global $CACHE;
	$sort_cache = $CACHE->readCache('sort'); ?>
	<li>
	<h3><span><?php echo $title; ?></span></h3>
	<ul id="blogsort">
	<?php
	foreach($sort_cache as $value):
		if ($value['pid'] != 0) continue;
	?>
	<li>
	<a href="<?php echo Url::sort($value['sid']); ?>"><?php echo $value['sortname']; ?>(<?php echo $value['lognum'] ?>)</a>
	<?php if (!empty($value['children'])): ?>
		<ul>
		<?php
		$children = $value['children'];
		foreach ($children as $key):
			$value = $sort_cache[$key];
		?>
		<li>
			<a href="<?php echo Url::sort($value['sid']); ?>"><?php echo $value['sortname']; ?>(<?php echo $value['lognum'] ?>)</a>
		</li>
		<?php endforeach; ?>
		</ul>
	<?php endif; ?>
	</li>
	<?php endforeach; ?>
	</ul>
	</li>
<?php }?>
<?php
/*
* 主题相关功能
*/

if(isset($_GET['qqnum'])){
    if($_GET['qqnum']){
        header("Content-type: text/json; charset=UTF-8;API-FROM:DYBOY.CN;"); 
        echo trim(@file_get_contents('https://api.top15.cn/qqinfo/?qq='.intval($_GET['qqnum'])));
        exit(0);
    }
}

// 返回Gravtar头像
function myGravatar($email,$role='' ,$s = 50, $d = 'wavatar', $g = 'g') {
    if(!empty($role)){ return $role; }
    $hash = md5($email);
    $avatar = "https://secure.gravatar.com/avatar/$hash?s=$s&d=$d&r=$g";
    return $avatar;
}

//获取QQ头像
function getqqtx($qq){
    $url="//q.qlogo.cn/headimg_dl?dst_uin=$qq&spec=3";
    return $url;
}

//获取QQ信息
function getqqxx($qq,$role=''){if(!empty($role)){ return $role; }
    $ssud=explode("@",$qq,2);
    if($ssud[1]=='qq.com'){ return getqqtx($ssud[0]); }else{ return MyGravatar($qq,$role); }
}

//URL规范化-SEO
function gf_url($id){
	if ($id){
		echo '<link rel="canonical" href="'.Url::log($id)."\" />";
	}
}


//页面源码压缩
function em_compress_html_main($buffer){
    $initial=strlen($buffer);
    $buffer=explode("<!--dy-html-->", $buffer);
    $count=count ($buffer);
    for ($i = 0; $i <= $count; $i++){
        if (stristr($buffer[$i], '<!--dy-html no compression-->')){
            $buffer[$i]=(str_replace("<!--dy-html no compression-->", " ", $buffer[$i]));
        }else{
            $buffer[$i]=(str_replace("\t", " ", $buffer[$i]));
            $buffer[$i]=(str_replace("\n\n", "\n", $buffer[$i]));
            $buffer[$i]=(str_replace("\n", "", $buffer[$i]));
            $buffer[$i]=(str_replace("\r", "", $buffer[$i]));
            while (stristr($buffer[$i], '  '))
            {
            $buffer[$i]=(str_replace("  ", " ", $buffer[$i]));
            }
        }
        $buffer_out.=$buffer[$i];
    }
    $final=strlen($buffer_out);
    $savings=($initial-$final)/$initial*100;
    $savings=round($savings, 2);
    $buffer_out.="<!--Tips:压缩前: $initial bytes; 压缩后: $final bytes; 节约：$savings% -->";
    return $buffer_out;
}

//内容页面PRE禁止压缩
function unCompress($content){
    if(preg_match_all('/(crayon-|<\/pre>)/i', $content, $matches)) {
        $content = '<!--dy-html--><!--dy-html no compression-->'.$content;
        $content.= '<!--dy-html no compression--><!--dy-html-->';
    }
    return $content;
}

//获取系统随机图片URL
function getrandomim(){ 
	$imgsrc = TEMPLATE_URL."images/random/".rand(1,35).".jpg";
	return $imgsrc; 
}

//获取文章中图片数量
function pic_num($content){
    if(preg_match_all("/<img.*src=[\"'](.*)[\"']/Ui", $content, $img) && !empty($img[1])){
        $imgNum = count($img[1]);
    }else{
        $imgNum = "0";
    }
    return $imgNum;
}

//从文章中获取缩略图URL
function GetThumFromContent($content){
    preg_match_all("|<img[^>]+src=\"([^>\"]+)\"?[^>]*>|is", $content, $img);
    $imgsrc = '';
    if(!empty($img[1])){ $imgsrc = $img[1][0]; } else{  $imgsrc =getrandomim(); }
    return $imgsrc;
}


//翻页
function sheli_fy($count,$perlogs,$page,$url,$anchor=''){
    $pnums = @ceil($count / $perlogs);
    $page = @min($pnums,$page);
    $prepg=$page-1;                
    $nextpg=($page==$pnums ? 0 : $page+1); 
    $urlHome = preg_replace("|[\?&/][^\./\?&=]*page[=/\-]|","",$url);
    $re = "";
    if($pnums<=1) return false;
    if($prepg) $re .=" <li class='prev'><a href=\"$url$prepg$anchor\" >←</a></li> ";
    for ($i = $page-1;$i <= $page+1 && $i <= $pnums; $i++){
        if ($i > 0){
            if ($i == $page){$re .= " <li class='current'><a href='javascript:;'>$i</a></li> ";
        }
        elseif($i == 1){
            $re .= " <li><a href=\"$urlHome$anchor\">$i</a></li> ";
            }
            else{
                $re .= " <li><a href=\"$url$i$anchor\">$i</a></li> ";}
            }
    }
    if($nextpg) $re .=" <li class='next'><a href=\"$url$nextpg$anchor\" class='nextpages'>→</a></li> "; 
    return $re;
}

//输出作者名字
function author_name($uid){
    global $CACHE;
    $user_cache = $CACHE->readCache('user');
    $author = $user_cache[$uid]['name'];
    echo '<a title="了解更多" href="'.BLOG_URL.'resume.html" >'.htmlspecialchars($author)."</a>";
}

//输出作者信息
function author_des($uid){
    global $CACHE;
    $user_cache = $CACHE->readCache('user');
    $des = $user_cache[$uid]['des'];
    if($des) return $des;
    else{
        return "这个家伙很懒什么也没说...";
    }
}

//输出作者头像URL
function author_head($uid){
    global $CACHE;
    $user_cache = $CACHE->readCache('user');
    if($user_cache[$uid]['photo']['src']){
        $head_url = BLOG_URL.$user_cache[$uid]['photo']['src'];
    }
    else{
        $head_url = BLOG_URL."content/templates/dy_monkey/img/noAvator.jpg";
    }
    return $head_url;
}

//相关文章推荐
function related_logs($logData = []) {
    $related_log_type = 'sort';
    $related_log_sort = 'rand';
    $related_log_num = '5'; 
    $related_inrss = 'y'; 
    
    global $value;
    $DB = MySqlii::getInstance();
    $CACHE = Cache::getInstance();
    extract($logData);
    if($value)
    {
        global $abstract;
    }
    $sql = "SELECT * FROM ".DB_PREFIX."blog WHERE hide='n' AND type='blog'";
    if($related_log_type == 'tag')
    {
        $log_cache_tags = $CACHE->readCache('logtags');
        $Tag_Model = new Tag_Model();
        $related_log_id_str = '0';
        foreach($log_cache_tags[$logid] as $key => $val)
        {
            $related_log_id_str .= ','.$Tag_Model->getTagByName($val['tagname']);
        }
        $sql .= " AND gid!=$logid AND gid IN ($related_log_id_str)";
    }else{
        $sql .= " AND gid!=$logid AND sortid=$sortid";
    }
    switch ($related_log_sort)
    {
        case 'views_desc':
        {
            $sql .= " ORDER BY views DESC";
            break;
        }
        case 'views_asc':
        {
            $sql .= " ORDER BY views ASC";
            break;
        }
        case 'comnum_desc':
        {
            $sql .= " ORDER BY comnum DESC";
            break;
        }
        case 'comnum_asc':
        {
            $sql .= " ORDER BY comnum ASC";
            break;
        }
        case 'rand':
        {
            $sql .= " ORDER BY rand()";
            break;
        }
    }
    $sql .= " LIMIT 0,$related_log_num";
    $related_logs = [];
    $query = $DB->query($sql);
    while($row = $DB->fetch_array($query)){
        array_push($related_logs, $row);
    }
    $out = '';
    if(!empty($related_logs))
    {
        $out.='<div class="title"><h3 style="font-size: 1.2em;color: #444;border-left: 5px solid #fc8d0c;margin-right: 15px;padding-left: 5px;margin-bottom: 8px;" class="menuexcept">相关推荐</h3>';
        foreach($related_logs as $val)
        {
            $out .= '<div class="single-item"><div class="image" style="background-image:url('.GetThumFromContent($val['content']).')"><a href="'.Url::log($val['gid']).'"><div class="overlay"></div><div class="title"><span> '.$val['views'].'人看过</span><h3 class="menuexcept">'.$val['title'].'</h3></div></a></div> </div>';
        }
        $out.='</div>';
    }
    if(!empty($value['content']))
    {
        if($related_inrss == 'y')
        {
            $abstract .= $out;
        }
    }else{
        echo $out;
    }
}

//判断当前页面是否为首页
function blog_tool_ishome(){
    $self_domain = explode("/",BLOG_URL);
    if (($_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"] == $self_domain[2]."/index.php") || ($_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"] == $self_domain[2]."/") || ($_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"]== $self_domain[2]."/?_pjax=%23dyblog_pjax")){
        return TRUE;
    } else {
        return FALSE;
    }
}

//page-tags：搜索页面输出热门标签
function page_tags(){
    global $CACHE;
    $tag_cache = $CACHE->readCache('tags');
    $count = 0;
    $hot_num = 5;       // 可修改，定义变量
    foreach ($tag_cache as $value){
        if($value['usenum'] < $hot_num) {continue;}
        echo '<a href="'.Url::tag($value['tagurl']).'" target="_blank" class="bg-white"><i class="fa fa-tags"></i> '.$value['tagname'].'('.$value['usenum'].')</a>';
        $count += 1;
        if($count == 30){
            break;
        }
    }
}

//输出友情链接: 友情链接单页输出友情链接
function friends_links(){
    global $CACHE; 
    $link_cache = $CACHE->readCache('link');
    echo '<ul class="flinks" style="text-align: center; display: inline-block; width: 100%; border: 1px solid #ececec; padding: 10px;">';
    foreach ($link_cache as $value) {
        echo '<li title="'.$value['des'].'" style="float: left;width: 33%;"><span><img src="https://api.top15.cn/favicon/?url='.$value['url'].'" width="16px" height="16px" style="vertical-align: middle;display: inline-block;padding-right: 2px;"><a href="'.$value['url'].'" target="_blank">'.$value['link'].'</a></span></li>';
    }
    echo '</ul><p></p>';
}

// 输出微语
function admin_talk(){
    $db = Mysqlii::getInstance();
    $result = $db->query("SELECT * FROM ".DB_PREFIX."twitter ORDER BY id DESC LIMIT 0,5");
    while($row = $result->fetch_array()){
        echo '<li><a href="/t">'.$row['content'].'</a></li>';
    }
}
?>

<?php
//widget：最新微语
function widget_twitter($title){
	global $CACHE; 
	$newtws_cache = $CACHE->readCache('newtw');
	$istwitter = Option::get('istwitter');
	?>
	<li>
	<h3><span><?php echo $title; ?></span></h3>
	<ul id="twitter">
	<?php foreach($newtws_cache as $value): ?>
	<?php $img = empty($value['img']) ? "" : '<a title="查看图片" class="t_img" href="'.BLOG_URL.str_replace('thum-', '', $value['img']).'" target="_blank">&nbsp;</a>';?>
	<li><?php echo $value['t']; ?><?php echo $img;?><p><?php echo smartDate($value['date']); ?></p></li>
	<?php endforeach; ?>
    <?php if ($istwitter == 'y') :?>
	<p><a href="<?php echo BLOG_URL . 't/'; ?>">更多&raquo;</a></p>
	<?php endif;?>
	</ul>
	</li>
<?php }?>
<?php
//widget：最新评论
function widget_newcomm($title){
	global $CACHE; 
	$com_cache = $CACHE->readCache('comment');
	?>
	<li>
	<h3><span><?php echo $title; ?></span></h3>
	<ul id="newcomment">
	<?php
	foreach($com_cache as $value):
	$url = Url::comment($value['gid'], $value['page'], $value['cid']);
	?>
	<li id="comment"><?php echo $value['name']; ?>
	<br /><a href="<?php echo $url; ?>"><?php echo $value['content']; ?></a></li>
	<?php endforeach; ?>
	</ul>
	</li>
<?php }?>
<?php
//widget：最新文章
function widget_newlog($title){
	global $CACHE; 
	$newLogs_cache = $CACHE->readCache('newlog');
	?>
	<li>
	<h3><span><?php echo $title; ?></span></h3>
	<ul id="newlog">
	<?php foreach($newLogs_cache as $value): ?>
	<li><a href="<?php echo Url::log($value['gid']); ?>"><?php echo $value['title']; ?></a></li>
	<?php endforeach; ?>
	</ul>
	</li>
<?php }?>
<?php
//widget：热门文章
function widget_hotlog($title){
	$index_hotlognum = Option::get('index_hotlognum');
	$Log_Model = new Log_Model();
	$randLogs = $Log_Model->getHotLog($index_hotlognum);?>
	<li>
	<h3><span><?php echo $title; ?></span></h3>
	<ul id="hotlog">
	<?php foreach($randLogs as $value): ?>
	<li><a href="<?php echo Url::log($value['gid']); ?>"><?php echo $value['title']; ?></a></li>
	<?php endforeach; ?>
	</ul>
	</li>
<?php }?>
<?php
//widget：随机文章
function widget_random_log($title){
	$index_randlognum = Option::get('index_randlognum');
	$Log_Model = new Log_Model();
	$randLogs = $Log_Model->getRandLog($index_randlognum);?>
	<li>
      <div class="new-title"><?php echo $title; ?></div>
	<ul>
	<?php foreach($randLogs as $value): ?>
	<li><a href="<?php echo Url::log($value['gid']); ?>"><?php echo $value['title']; ?></a></li>
	<?php endforeach; ?>
	</ul>
	</li>
<?php }?>
<?php
//widget：搜索
function widget_search($title){ ?>
	<li>
	<h3><span><?php echo $title; ?></span></h3>
	<ul id="logsearch">
	<form name="keyform" method="get" action="<?php echo BLOG_URL; ?>index.php">
	<input name="keyword" class="search" type="text" />
	</form>
	</ul>
	</li>
<?php } ?>
<?php
//widget：归档
function widget_archive($title){
	global $CACHE; 
	$record_cache = $CACHE->readCache('record');
	?>
	<li>
	<h3><span><?php echo $title; ?></span></h3>
	<ul id="record">
	<?php foreach($record_cache as $value): ?>
	<li><a href="<?php echo Url::record($value['date']); ?>"><?php echo $value['record']; ?>(<?php echo $value['lognum']; ?>)</a></li>
	<?php endforeach; ?>
	</ul>
	</li>
<?php } ?>
<?php
//widget：自定义组件
function widget_custom_text($title, $content){ ?>
	<li>
	<h3><span><?php echo $title; ?></span></h3>
	<ul>
	<?php echo $content; ?>
	</ul>
	</li>
<?php } ?>
<?php
//widget：链接
function widget_link($title){
	global $CACHE; 
	$link_cache = $CACHE->readCache('link');
    //if (!blog_tool_ishome()) return;#只在首页显示友链去掉双斜杠注释即可
	?>
	<li>
	<h3><span><?php echo $title; ?></span></h3>
	<ul id="link">
	<?php foreach($link_cache as $value): ?>
	<li><a href="<?php echo $value['url']; ?>" title="<?php echo $value['des']; ?>" target="_blank"><?php echo $value['link']; ?></a></li>
	<?php endforeach; ?>
	</ul>
	</li>
<?php }?> 

<?php
//blog：一级导航，暂时不支持二级菜单
function blog_navi(){
	global $CACHE; 
	$navi_cache = $CACHE->readCache('navi');
	?>
	<?php
	foreach($navi_cache as $value):
        if ($value['pid'] != 0) { continue; }
		if($value['url'] == ROLE_ADMIN && (ROLE == ROLE_ADMIN || ROLE == ROLE_WRITER)):
	?>
			<a href="<?php echo BLOG_URL; ?>admin/">管理站点</a>
			<a href="<?php echo BLOG_URL; ?>admin/?action=logout">退出</a>
	<?php
			continue;
		endif;
		$newtab = $value['newtab'] == 'y' ? 'target="_blank"' : '';
        $value['url'] = $value['isdefault'] == 'y' ? BLOG_URL . $value['url'] : trim($value['url'], '/');
        $current_tab = BLOG_URL . trim(Dispatcher::setPath(), '/') == $value['url'] ? 'current' : '';
		?>
			<a href="<?php echo $value['url']; ?>" <?php echo $newtab;?> class="<?php echo $current_tab;?>"><?php echo $value['naviname']; ?></a>
	<?php endforeach; ?>
<?php }?>
<?php //判断是否百度收录
function baidu($url){
$url='http://www.baidu.com/s?wd='.$url;
$curl=curl_init();curl_setopt($curl,CURLOPT_URL,$url);curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);$rs=curl_exec($curl);curl_close($curl);if(!strpos($rs,'没有找到')){return 1;}else{return 0;}}
function logurl($id){$url=Url::log($id);
if(baidu($url)==1){echo "百度已收录";
}else{echo "<a style=\"color:red;\" rel=\"external nofollow\" title=\"提交收录！\" target=\"_blank\" href=\"http://zhanzhang.baidu.com/sitesubmit/index?sitename=$url\">百度未收录</a>";}}
?>
<?php // 随机云标签
function yun_tags(){
global $CACHE;$tag_cache = $CACHE->readCache('tags');
$num = 6;
shuffle($tag_cache); 
foreach($tag_cache as $key => $value):if($key < $num):?>
<a href="<?php echo Url::tag($value['tagurl']); ?>" title="<?php echo $value['usenum']; ?>篇"><?php echo $value['tagname']; ?></a>
<?php endif;endforeach;}?>



<?php
//mobile：一级导航，暂时不支持二级菜单
function mobile_blog_navi(){
	global $CACHE; 
	$navi_cache = $CACHE->readCache('navi');
	?>
	<?php
	foreach($navi_cache as $value):
        if ($value['pid'] != 0) { continue; }
		if($value['url'] == ROLE_ADMIN && (ROLE == ROLE_ADMIN || ROLE == ROLE_WRITER)):
	?>
			<li><a href="<?php echo BLOG_URL; ?>admin/">管理站点</a></li>
			<li><a href="<?php echo BLOG_URL; ?>admin/?action=logout">退出</a></li>
	<?php
			continue;
		endif;
		$newtab = $value['newtab'] == 'y' ? 'target="_blank"' : '';
        $value['url'] = $value['isdefault'] == 'y' ? BLOG_URL . $value['url'] : trim($value['url'], '/');
        $current_tab = BLOG_URL . trim(Dispatcher::setPath(), '/') == $value['url'] ? 'current' : '';
		?>
		<li>
			<a href="<?php echo $value['url']; ?>" <?php echo $newtab;?> class="<?php echo $current_tab;?>"><?php echo $value['naviname']; ?></a>
		</li>
	<?php endforeach; ?>
<?php }?>

<?php
//blog：置顶
function topflg($top, $sortop='n', $sortid=null){
    if(blog_tool_ishome()) {
       echo $top == 'y' ? "<img src=\"".TEMPLATE_URL."/images/top.png\" title=\"首页置顶文章\" /> " : '';
    } elseif($sortid){
       echo $sortop == 'y' ? "<img src=\"".TEMPLATE_URL."/images/sortop.png\" title=\"分类置顶文章\" /> " : '';
    }
}
?>

<?php 
//判断置顶文章
if($value['top']=='y'):?>
<i class="top-mark  article-mark"></i>
<?php endif; ?>

<?php
//blog：编辑
function editflg($logid,$author){
	$editflg = ROLE == ROLE_ADMIN || $author == UID ? '<a href="'.BLOG_URL.'admin/write_log.php?action=edit&gid='.$logid.'" target="_blank">编辑</a>' : '';
	echo $editflg;
}
?>


<?php
//blog：分类
function blog_sort($blogid){
	global $CACHE; 
	$log_cache_sort = $CACHE->readCache('logsort');
	?>
	<?php if(!empty($log_cache_sort[$blogid])): ?>
    	<a href="<?php echo Url::sort($log_cache_sort[$blogid]['id']); ?>"><?php echo $log_cache_sort[$blogid]['name']; ?></a>
	<?php else:?>
		<a href="javascript:;">未分类</a>
	<?php endif;?>
<?php }?>

<?php
//blog：文章标签
function blog_tag($blogid){
	global $CACHE;
	$log_cache_tags = $CACHE->readCache('logtags');
	if (!empty($log_cache_tags[$blogid])){
		$tag = '本文标签：';
		foreach ($log_cache_tags[$blogid] as $value){
			$tag .= "	<a href=\"".Url::tag($value['tagurl'])."\">".$value['tagname'].'</a>';
		}
		echo $tag;
	}
}
?>
<?php
//blog：文章作者
function blog_author($uid){
	global $CACHE;
	$user_cache = $CACHE->readCache('user');
	$author = $user_cache[$uid]['name'];
	$mail = $user_cache[$uid]['mail'];
	$des = $user_cache[$uid]['des'];
	$title = !empty($mail) || !empty($des) ? "title=\"$des $mail\"" : '';
	echo '<a href="'.Url::author($uid)."\" $title>$author</a>";
}
?>
<?php
//blog：相邻文章
function neighbor_log($neighborLog){
	extract($neighborLog);?>
	<?php if($prevLog):?>
	&laquo; <a href="<?php echo Url::log($prevLog['gid']) ?>"><?php echo $prevLog['title'];?></a>
	<?php endif;?>
	<?php if($nextLog && $prevLog):?>
		|
	<?php endif;?>
	<?php if($nextLog):?>
		 <a href="<?php echo Url::log($nextLog['gid']) ?>"><?php echo $nextLog['title'];?></a>&raquo;
	<?php endif;?>
<?php }?>



<?php
//blog：评论列表
function blog_comments($comments){
    extract($comments);
    if($commentStacks): ?>
	<a name="comments"></a>
	<p class="comment-header"><b>评论：</b></p>
	<?php endif; ?>
	<?php
	$isGravatar = Option::get('isgravatar');
	foreach($commentStacks as $cid):
    $comment = $comments[$cid];
	$comment['poster'] = $comment['url'] ? '<a href="'.$comment['url'].'" target="_blank">'.$comment['poster'].'</a>' : $comment['poster'];
	?>
	<div class="topx comment" id="comment-<?php echo $comment['cid']; ?>">
		<a name="<?php echo $comment['cid']; ?>"></a>
		<?php if($isGravatar == 'y'): ?><div class="avatar"><img src="<?php echo TEMPLATE_URL; ?>/images/tx.jpg" /></div><?php endif; ?>
		<div class="comment-info">
			<b><?php echo $comment['poster']; ?> </b><br /><span class="comment-time"><?php echo $comment['date']; ?></span>
			<div class="comment-content"><?php echo $comment['content']; ?></div>
			<div class="comment-reply"><a href="#comment-<?php echo $comment['cid']; ?>" onclick="commentReply(<?php echo $comment['cid']; ?>,this)">回复</a></div>
		</div>
		<?php blog_comments_children($comments, $comment['children']); ?>
	</div>
	<?php endforeach; ?>
    <div id="pagenavi">
	    <?php echo $commentPageUrl;?>
    </div>
<?php }?>
<?php
//blog：子评论列表
function blog_comments_children($comments, $children){
	$isGravatar = Option::get('isgravatar');
	foreach($children as $child):
	$comment = $comments[$child];
	$comment['poster'] = $comment['url'] ? '<a href="'.$comment['url'].'" target="_blank">'.$comment['poster'].'</a>' : $comment['poster'];
	?>
	<div class="comment comment-children" id="comment-<?php echo $comment['cid']; ?>">
		<a name="<?php echo $comment['cid']; ?>"></a>
		<?php if($isGravatar == 'y'): ?><div class="avatar"><img src="<?php echo TEMPLATE_URL; ?>/images/tx.jpg" /></div><?php endif; ?>
		<div class="comment-info">
			<b><?php echo $comment['poster']; ?> </b><br /><span class="comment-time"><?php echo $comment['date']; ?></span>
			<div class="comment-content"><?php echo $comment['content']; ?></div>
			<?php if($comment['level'] < 4): ?><div class="comment-reply"><a href="#comment-<?php echo $comment['cid']; ?>" onclick="commentReply(<?php echo $comment['cid']; ?>,this)">回复</a></div><?php endif; ?>
		</div>
		<?php blog_comments_children($comments, $comment['children']);?>
	</div>
	<?php endforeach; ?>
<?php }?>

<?php
//blog：发表评论表单
function blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark){
	if($allow_remark == 'y'): ?>
	<div id="comment-place">
	<div class="comment-post" id="comment-post">
		<div class="cancel-reply" id="cancel-reply" style="display:none"><a href="javascript:void(0);" onclick="cancelReply()">取消回复</a></div>
		<p class="comment-header"><b>发表评论：</b><a name="respond"></a></p>
		<form method="post" name="commentform" action="<?php echo BLOG_URL; ?>index.php?action=addcom" id="commentform">
			<input type="hidden" name="gid" value="<?php echo $logid; ?>" />
			<?php if(ROLE == ROLE_VISITOR): ?>
			<p>
				<input type="text" name="comname" maxlength="49" value="<?php echo $ckname; ?>" size="22" tabindex="1">
				<label for="author"><small>昵称</small></label>
			</p>
			<p>
				<input type="text" name="commail"  maxlength="128"  value="<?php echo $ckmail; ?>" size="22" tabindex="2">
				<label for="email"><small>邮件地址 (选填)</small></label>
			</p>
			<p>
				<input type="text" name="comurl" maxlength="128"  value="<?php echo $ckurl; ?>" size="22" tabindex="3">
				<label for="url"><small>个人主页 (选填)</small></label>
			</p>
			<?php endif; ?>
			<p><textarea name="comment" id="comment" rows="10" tabindex="4"></textarea></p>
			<p><?php echo $verifyCode; ?> <input type="submit" id="comment_submit" onclick="location.reload()"  value="发表评论" tabindex="6" /></p>
			<input type="hidden" name="pid" id="comment-pid" value="0" size="22" tabindex="1"/>
		</form>
	</div>
	</div>
	<?php endif; ?>
<?php }?>


<?php
//search：搜索框 核心代码
function search_tag($title){
    global $CACHE;
    $tag_cache = $CACHE->readCache('tags');?>
        <?php shuffle ($tag_cache);
		$tag_cache = array_slice($tag_cache,0,15);foreach($tag_cache as $value): ?>
			<li class="search-go"><a href="<?php echo BLOG_URL; ?>tag/<?php echo $value['tagname']; ?>"><?php echo $value['tagname']; ?></a></li>
        <?php endforeach; ?>
<?php }?>

<?php
//友情链接
function pages_links(){
	global $CACHE; 
	$link_cache = $CACHE->readCache('link');
	echo '<ul class="friend_links">';
    foreach($link_cache as $value): ?>
	<li><a href="<?php echo $value['url']; ?>" title="<?php echo $value['des']; ?>" target="_blank" ><?php echo $value['link']; ?></a></li>
	<?php endforeach;
	echo "</ul>";
	}
?>