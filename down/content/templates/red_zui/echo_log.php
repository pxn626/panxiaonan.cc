<?php 
/**
 * 阅读文章页面
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<main class="container">
<section class="wrapper">
<section class="content" id="scroll"><section class="content_left">
  <article class="entry">
    <header class="post_header">
      <h3><?php echo $log_title; ?></h3>
      <div class="postinfo">
        <div class="left">
          <span class="comment">
         作者：<?php echo blog_author($author); ?></span>
          <span class="comment">
        分类：<?php blog_sort($logid); ?></span>
          <span class="comment gun">
         时间：<?php echo gmdate('Y-m-d', $date); ?></span>
          <span class="comment">
         阅读：<?php echo $views; ?></span>
           <span class="comment gun">
         <?php echo logurl($logid);?></span>
        </div>
      </div>
    </header>
    <div class="content_post">
	
    <?php echo unCompress($log_content); ?>
    </div>

	<p>[cv]<?php doAction('down_log',$logid); ?>[/cv]</p>  
		<?php doAction('log_related', $logData); ?>
     <div class="bqsm">
     <i class="fa fa-tag"></i><?php blog_tag($logid); ?>     
     资源收集于网络，只做学习和交流使用，版权归原作者所有，本站发布的内容若侵犯到您的权益，请联系本站删除，我们将及时处理！
    <br />
     <i class="fa fa-share-alt-square"></i><a href="<?php echo BLOG_URL; ?>"><?php echo $blogname; ?></a>站长的QQ群：电子书pdf免费分享查找 374152070 群文件里有站长分享的文件目录<br/>因站长不慎没审查清楚误传敏感文件到诚通网盘<br/>有些文件如果没有链接请加QQ群
      </div>
    <!--上下篇文章-->
      <section class="prevnext">
	<div class="neigborhood">
			<?php 
				extract($neighborLog);
				if($prevLog){
					echo '<div class="prevlog">上一篇<br/><a href="'.Url::log($prevLog['gid']).'" title="'.$prevLog['title'].'">'.$prevLog['title'].'</a></div>';}
				else{
					echo '<div class="prevlog"><a href="#" title="没有上一篇了">没有上一篇了</a></div>';
				}
				if($nextLog){
					echo '<div class="nextlog">下一篇<br/><a href="'.Url::log($nextLog['gid']).'" title="'.$nextLog['title'].'">'.$nextLog['title'].'</a></div>';}
				else{
					echo '<div class="nextlog"><a href="#" title="没有下一篇了">没有下一篇了</a></div>';
				}
			?>
		</div> 
	</section> 
</article> 
   <!-- 广告位 -->  
  
 <div class="zdykj">
 <!--<img src="https://tu/zfbgg1.png" width="100%">-->
 <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 2 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6466638002070963"
     data-ad-slot="8945791427"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
 </div>
  
 <!-- 评论列表 -->     
 <div class="comment-container">
	<div id="comments1" class="clearfix">
		<?php blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark); ?>
      
		<?php blog_comments($comments); ?>
	</div>
</div> 
</section>
<!-- 边栏 -->
<so3>
<div class="sidebar-box" >
<?php widget_random_log(随机文章);?>
</div>  
<div class="new-tag">
<div class="new-title">随机云标签</div>
<div class="new-tags">
<?php yun_tags();?>				
</div>
</div>
</so3>
</section>
</section>  
  <?php
 include View::getView('footer');
?>
</main>