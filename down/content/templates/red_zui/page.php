
<!--自建独立页面-->

<main class="container">
<section class="wrapper">
<section class="content" id="scroll"><section class="content_left">
  <article class="entry">
    <header class="post_header">
      <h1><?php echo $log_title; ?></h1>
      <div class="postinfo">
        <div class="left">
          <span class="comment">
          <i class="fa fa-user"></i> 作者：&nbsp;<?php echo blog_author($author); ?></span>
          <span class="comment">
          <i class="fa fa-folder"></i>分类：&nbsp;<?php blog_sort($logid); ?></span>
          <span class="comment">
            <i class="fa fa-calendar fa-fw"></i>发布时间：&nbsp;<?php echo gmdate('Y-n-j', $date); ?></span>
          <span class="comment">
            <i class="fa fa-fire fa-fw"></i>热度&nbsp;<?php echo $views; ?></span>
        </div>
      </div>
    </header>
    <div class="content_post">
	<?php doAction('log_related', $logData); ?>
    <?php echo unCompress($log_content); ?>
	
    </div>
</article> 
 <!-- 评论列表 -->     
 <div class="comment-container">
	<div id="comments1" class="clearfix">
		<?php blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark); ?>
      
		<?php blog_comments($comments); ?>
	</div>
</div> 
</section>
<!-- 边栏 -->
</section>
</section>
</main>

<?php
 include View::getView('footer');
?>