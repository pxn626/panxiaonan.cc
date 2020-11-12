<?php 
/**
 * 自定义 留言板界面
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>

<main class="container">
<section class="wrapper">
<section class="content" id="scroll">
<section class="liuyan">
  <article class="entry">
    <header class="post_header">
      <h1><?php echo $log_title; ?></h1>
    </header>
<div class="content_post"> 
<p style="text-align:center;"> <span style="font-size:18px;color:#E53333;">感谢各位对本站长久以来的支持</span> </p>
<p style="text-align:center;"> <span style="font-size:18px;color:#00D5FF;">没人各位的支持就没有本站的今天</span> </p>
  <p style="text-align:center;"> <span style="font-size:18px;color:#60D978;">如果你们对本站的意见的话，欢迎在评论区留言</span> </p>
  <p style="text-align:center;"> <span style="font-size:18px;color:#60D978;"><br></span> </p>
  <p style="text-align:center;"> <span style="font-size:18px;color:#337FE5;">如果你们有什么需要的资源找不到</span> </p>
  <p style="text-align:center;"> <span style="font-size:18px;color:#FF9900;">也可以在评论区留言告诉我们</span> </p>
  <p style="text-align:center;"> <span style="font-size:18px;color:#EE33EE;">我们会在第一时间帮你找到你所需的资源</span> </p>
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
</section>
</section>
</main>

<?php
 include View::getView('footer');
?>