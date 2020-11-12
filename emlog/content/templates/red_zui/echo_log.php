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
	<?php doAction('down_log',$logid); ?>  
     <div class="bqsm">
     <i class="fa fa-tag"></i><?php blog_tag($logid); ?>     
    <br />
     <i class="fa fa-share-alt-square"></i>转载声明：本文为<a href="<?php echo BLOG_URL; ?>"><?php echo $blogname; ?></a>的原创文章，转载请注明原文地址，谢谢合作
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
 <img src="https://tu/zfbgg1.png" width="100%">
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