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
    <div class="side">
      <h4 class="title"><?php echo $title; ?></h4>
      <div class="bg-white padding radius radius-bottom">
          <div id="bloggerinfoimg">
          <?php if (!empty($user_cache[1]['photo']['src'])): ?>
          <img src="<?php echo BLOG_URL.$user_cache[1]['photo']['src']; ?>" width="<?php echo $user_cache[1]['photo']['width']; ?>" height="<?php echo $user_cache[1]['photo']['height']; ?>" alt="blogger" />
          <?php endif;?>
          </div>
          <p><b><?php echo $name; ?></b>
          <?php echo $user_cache[1]['des']; ?></p>
      </div>
    </div>
<?php }?>
<?php
//widget：日历
function widget_calendar($title){ ?>
  <div class="side">
    <h4 class="title"><?php echo $title; ?></h4>
    <div class="bg-white padding radius radius-bottom">
        <div id="calendar"></div>
        <script>sendinfo('<?php echo Calendar::url(); ?>','calendar');</script>
    </div>
  </div>
<?php }?>
<?php
//widget：标签
function widget_tag($title){
    global $CACHE;
    $tag_cache = $CACHE->readCache('tags');?>
    <div class="side">
      <h4 class="title"><?php echo $title; ?></h4>
      <div class="padding bg-white radius radius-bottom">
          <?php foreach($tag_cache as $value): ?>
              <span style="font-size:<?php echo $value['fontsize']; ?>pt; line-height:30px;">
              <a href="<?php echo Url::tag($value['tagurl']); ?>" title="<?php echo $value['usenum']; ?> 篇文章"><?php echo $value['tagname']; ?></a></span>
          <?php endforeach; ?>
      </div>
    </div>
<?php }?>
<?php
//widget：分类
function widget_sort($title){
    global $CACHE;
    $sort_cache = $CACHE->readCache('sort'); ?>
  <div class="side">
    <h4 class="title"><?php echo $title; ?></h4>
    <ul>
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
  </div>
<?php }?>
<?php
//widget：最新评论
function widget_newcomm($title){
    global $CACHE;
    $com_cache = $CACHE->readCache('comment');
    ?>
  <div class="side">
    <h4 class="title"><?php echo $title; ?></h4>
    <ul>
        <?php
        foreach($com_cache as $value):
        $url = Url::comment($value['gid'], $value['page'], $value['cid']);
        ?>
        <li id="comment"><?php echo $value['name']; ?>
        <br /><a href="<?php echo $url; ?>"><?php echo $value['content']; ?></a></li>
        <?php endforeach; ?>
    </ul>
  </div>
<?php }?>
<?php
//widget：最新文章
function widget_newlog($title){
    global $CACHE;
    $newLogs_cache = $CACHE->readCache('newlog');
    ?>
    <div class="side">
      <h4 class="title"><?php echo $title; ?></h4>
      <ul>
          <?php foreach($newLogs_cache as $value): ?>
          <li><a href="<?php echo Url::log($value['gid']); ?>"><?php echo $value['title']; ?></a></li>
          <?php endforeach; ?>
      </ul>
    </div>
<?php }?>
<?php
//widget：热门文章
function widget_hotlog($title){
    $index_hotlognum = Option::get('index_hotlognum');
    $Log_Model = new Log_Model();
    $hotLogs = $Log_Model->getHotLog($index_hotlognum);?>
    <div class="side">
      <h4 class="title"><?php echo $title; ?></h4>
      <ul>
          <?php foreach($hotLogs as $value): ?>
          <li><a href="<?php echo Url::log($value['gid']); ?>"><?php echo $value['title']; ?></a></li>
          <?php endforeach; ?>
      </ul>
    </div>
<?php }?>
<?php
//widget：搜索
function widget_search($title){ ?>
    <div class="search padding-large radius radius-top">
      <form name="keyform" method="get" action="<?php echo BLOG_URL; ?>index.php">
        <div class="input-inline input-radius">
          <div class="input-inline-auto input-icon">
            <span style="z-index:4"><i class="icon-search text-deep"></i></span>
            <input name="keyword" class="input radius-large bg-white" type="text" placeholder="搜索" data-form="clear" style="z-index:3;" />
            <span style="z-index:4"><i class="icon-danger-bg"></i></span>
          </div>
          <div class="addon"><input class="button border bg-black" type="submit" value="搜索" /></div>
        </div>
      </form>
    </div>
<?php } ?>
<?php
//widget：归档
function widget_archive($title){
    global $CACHE;
    $record_cache = $CACHE->readCache('record');
    ?>
    <div class="side">
      <h4 class="title"><?php echo $title; ?></h4>
      <ul>
      <?php foreach($record_cache as $value): ?>
      <li><a href="<?php echo Url::record($value['date']); ?>"><?php echo $value['record']; ?>(<?php echo $value['lognum']; ?>)</a></li>
      <?php endforeach; ?>
      </ul>
    </div>
<?php } ?>
<?php
//widget：自定义组件
function widget_custom_text($title, $content){ ?>
  <div class="side">
    <h4 class="title"><?php echo $title; ?></h4>
    <div class="bg-white radius radius-bottom"><?php echo $content; ?></div>
  </div>
<?php } ?>
<?php
//widget：链接
function widget_link($title){
    global $CACHE;
    $link_cache = $CACHE->readCache('link');
    //if (!blog_tool_ishome()) return;#只在首页显示友链去掉双斜杠注释即可
    ?>
    <div class="side">
      <h4 class="title"><?php echo $title; ?></h4>
      <ul>
          <?php foreach($link_cache as $value): ?>
          <li><a href="<?php echo $value['url']; ?>" title="<?php echo $value['des']; ?>" target="_blank"><?php echo $value['link']; ?></a></li>
          <?php endforeach; ?>
      </ul>
    </div>
<?php }?>
<?php
//blog：导航
function blog_navi(){
    global $CACHE;
    $navi_cache = $CACHE->readCache('navi');
    ?>
    <header class="navbar shadow" id="navbar">
      <!--<a class="navbar-logo size-big" href="https://www.pintuer.com/blog/"><img src="https://www.pintuer.com/static/images/logo.png" height="30" class="margin-right-small" /> <strong>拼图博客</strong></a>-->
      <nav class="navbar-body" id="navbody">
        <ul class="nav">
          <?php
          foreach($navi_cache as $value):
          if ($value['pid'] != 0) {
              continue;
          }
          if($value['url'] == ROLE_ADMIN && (ROLE == ROLE_ADMIN || ROLE == ROLE_WRITER)):
          ?>
              <li><a href="<?php echo BLOG_URL; ?>admin/">管理站点</a></li>
              <li><a href="<?php echo BLOG_URL; ?>admin/?action=logout">退出</a></li>
          <?php
              continue;
          endif;
          $newtab = $value['newtab'] == 'y' ? 'target="_blank"' : '';
          $value['url'] = $value['isdefault'] == 'y' ? BLOG_URL . $value['url'] : trim($value['url'], '/');
          $current_tab = BLOG_URL . trim(Dispatcher::setPath(), '/') == $value['url'] ? 'current' : 'common';
          ?>
          <?php if (!empty($value['children']) || !empty($value['childnavi'])) :?>
          <li>
              <?php if (!empty($value['children'])):?>
              <a href="<?php echo $value['url']; ?>" <?php echo $newtab;?>><?php echo $value['naviname']; ?></a>
              <ul class="nav nav-menu nav-divider nav-box bg-white radius-none">
                  <?php foreach ($value['children'] as $row){
                          echo '<li><a href="'.Url::sort($row['sid']).'">'.$row['sortname'].'</a></li>';
                  }?>
              </ul>
              <?php endif;?>
              <?php if (!empty($value['childnavi'])) :?>
              <a href="<?php echo $value['url']; ?>" <?php echo $newtab;?>><?php echo $value['naviname']; ?></a>
              <ul>
                  <?php foreach ($value['childnavi'] as $row){
                          $newtab = $row['newtab'] == 'y' ? 'target="_blank"' : '';
                          echo '<li><a href="' . $row['url'] . "\" $newtab >" . $row['naviname'].'</a></li>';
                  }?>
              </ul>
              <?php endif;?>
          </li>
          <?php else:?>
          <li><a href="<?php echo $value['url']; ?>" <?php echo $newtab;?>><?php echo $value['naviname']; ?></a></li>
          <?php endif;?>
          <?php endforeach; ?>
        </ul>
      </nav>
      <ul class="nav nav-switch size-mini" data-navswitch="#navbody"><li></li><li></li><li></li></ul>
    </header>
    <script>
      $(function(){
        $("#navbar").auto({
          "0":{"class":"navbar shadow"},
          "1024":{"class":"navbar navbar-head navbar-show shadow"},
        });
      })
    </script>
<?php }?>
<?php
//blog：置顶
function topflg($top, $sortop='n', $sortid=null){
    if(blog_tool_ishome()) {
       echo $top == 'y' ? "<i class=\"icon-heart text-danger\" title=\"首页置顶文章\"></i>" : '';
    } elseif($sortid){
       echo $sortop == 'y' ? "<i class=\"icon-heart text-main\" title=\"分类置顶文章\"></i>" : '';
    }
}
?>
<?php
//blog：编辑
function editflg($logid,$author){
    $editflg = ROLE == ROLE_ADMIN || $author == UID ? '<a class="margin-left-small text-gray" href="'.BLOG_URL.'admin/write_log.php?action=edit&gid='.$logid.'" target="_blank"><i class="icon-doc"></i> 编辑</a>' : '';
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
    <a class="margin-left-small text-gray" href="<?php echo Url::sort($log_cache_sort[$blogid]['id']); ?>"><i class="icon-nav"></i> <?php echo $log_cache_sort[$blogid]['name']; ?></a>
    <?php endif;?>
<?php }?>
<?php
//blog：分类名称
function blog_sort_name($sortid){
    global $CACHE;
    $log_cache_sortname = $CACHE->readCache('sort');
    ?>
    <?php if(!empty($log_cache_sortname[$sortid])): ?>
      <?php echo $log_cache_sortname[$sortid]['sortname']?>
    <?php else:?>
      首页
    <?php endif;?>
<?php }?>
<?php
//blog：文章标签
function blog_tag($blogid){
  global $CACHE;
	$log_cache_tags = $CACHE->readCache('logtags');
	if (!empty($log_cache_tags[$blogid])){
		$tag = '标签:';
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
    echo '<a class="text-gray" href="'.Url::author($uid)."\" $title><i class=\"icon-user\"></i> $author</a>";
}
?>
<?php
//blog：相邻文章
function neighbor_log($neighborLog){
    extract($neighborLog);?>
    <?php if($prevLog):?>
    <span>&laquo; <a class="text-gray" href="<?php echo Url::log($prevLog['gid']) ?>"><?php echo $prevLog['title'];?></a></span>
    <?php endif;?>
    <?php if($nextLog):?>
      <span><a class="text-gray" href="<?php echo Url::log($nextLog['gid']) ?>"><?php echo $nextLog['title'];?></a> &raquo;</span>
    <?php endif;?>
<?php }?>
<?php
//blog：评论列表
function blog_comments($comments){
    extract($comments);
    if($commentStacks): ?>
    <a name="comments"></a>
    <p class="title size">评论</p>
    <?php endif; ?>
    <?php
    $isGravatar = Option::get('isgravatar');
    foreach($commentStacks as $cid):
    $comment = $comments[$cid];
    $comment['poster'] = $comment['url'] ? '<a href="'.$comment['url'].'" target="_blank">'.$comment['poster'].'</a>' : $comment['poster'];
    ?>
    <div class="media blog-margin" id="comment-<?php echo $comment['cid']; ?>">
      <a name="<?php echo $comment['cid']; ?>"></a>
      <?php if($isGravatar == 'y'): ?><img src="<?php echo getGravatar($comment['mail']); ?>" class="blog-margin-right-small flex-self-start radius-circle" /><?php endif; ?>
      <div class="media-body">
        <strong>
          <span class="text-main"><?php echo $comment['poster']; ?></span>
          <span class="margin-left text-gray size-mini weight-small"><?php echo $comment['date']; ?></span>
          <a class="float-right text-gray size-mini weight" href="#comment-<?php echo $comment['cid']; ?>" onclick="commentReply(<?php echo $comment['cid']; ?>,this)">回复</a>
        </strong>
        <p class="size-small"><?php echo $comment['content']; ?></p>
        <?php blog_comments_children($comments, $comment['children']); ?>
      </div>
    </div>
    <?php endforeach; ?>
    <div id="pagenavi" class="review">
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
    <div class="media blog-padding-small radius bg" id="comment-<?php echo $comment['cid']; ?>">
      <a name="<?php echo $comment['cid']; ?>"></a>
      <?php if($isGravatar == 'y'): ?><img src="<?php echo getGravatar($comment['mail']); ?>" class="blog-margin-right-small flex-self-start radius-circle" /><?php endif; ?>
      <div class="media-body">
        <strong>
          <span class="text-sub"><?php echo $comment['poster']; ?></span>
          <span class="margin-left-small text-gray size-mini weight-small"><?php echo $comment['date']; ?></span>
          <?php if($comment['level'] < 4): ?>
            <a class="margin-left-small text-gray size-mini weight" href="#comment-<?php echo $comment['cid']; ?>" onclick="commentReply(<?php echo $comment['cid']; ?>,this)">回复</a>
          <?php endif; ?>
        </strong>
        <p><?php echo $comment['content']; ?></p>
        <?php blog_comments_children($comments, $comment['children']);?>
      </div>
    </div>
    <?php endforeach; ?>
<?php }?>
<?php
//blog：发表评论表单
function blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark){
    if($allow_remark == 'y'): ?>
    <div id="comment-place">
    <div class="padding" id="comment-post">
        <p class="hr"><span>发表评论<a name="respond"></a></span></p>
        <form class="form validate-tips" method="post" name="commentform" action="<?php echo BLOG_URL; ?>index.php?action=addcom" id="commentform">
          <input type="hidden" name="gid" value="<?php echo $logid; ?>" />
          <?php if(ROLE == ROLE_VISITOR): ?>
          <div class="input-group">
            <div class="input-block"><input type="text" name="comname" class="input" placeholder="昵称" data-validate='{"required":true,"invalid":"请填写昵称"}' maxlength="49" value="<?php echo $ckname; ?>" size="22" tabindex="1"></div>
          </div>
          <?php endif; ?>
          <div class="input-group">
            <div class="input-block"><textarea class="input" name="comment" id="comment" rows="3" tabindex="2" data-validate='{"required":true,"invalid":"请填写评论"}' placeholder="请开始您的演讲..."></textarea></div>
          </div>
          <?php if($verifyCode): ?>
          <div class="input-group">
            <div class="input-block verify"><?php echo $verifyCode; ?></div>
          </div>
          <?php endif; ?>
          <div class="form-button">
            <input type="submit" id="comment_submit" value="发表评论" class="button bg-main" tabindex="5" />
            <span class="cancel-reply margin-left" id="cancel-reply" style="display:none"><a href="javascript:void(0);" onclick="cancelReply()">取消回复</a></span>
          </div>
          <input type="hidden" name="pid" id="comment-pid" value="0" size="22" tabindex="1"/>
        </form>
        <script>
          $(function(){$("#commentform").validate();});
        </script>
    </div>
    </div>
    <?php endif; ?>
<?php }?>
<?php
//blog-tool:判断是否是首页
function blog_tool_ishome(){
    if (BLOG_URL . trim(Dispatcher::setPath(), '/') == BLOG_URL){
        return true;
    } else {
        return FALSE;
    }
}
?>
