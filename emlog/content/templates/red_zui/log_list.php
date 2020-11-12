<?php 
/**
 * 站点首页模板
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
if($pageurl == Url::logPage()){include View::getView('index');exit;}
?>

<main class="container">
<section class="wrapper">
<section class="content" id="scroll">																		
<section class="content_left">
<section class="sidebar_widget widget_post_author">
<section class="author_post">
<div class="title">
<h4 style="width: 100%;">
<i class="fa fa-refresh fa-spin"></i>&nbsp;&nbsp;&nbsp;最近更新 
</h4></div>
  
  <?php 
  if (!empty($logs)):
  foreach($logs as $value):
  $flag = pic_num($value['content']);?>
  
<ul id="rikilist">
<li>

<font style="float: right;" <?php if(((date('Ymd',time())-date('Ymd',$value['date']))< 1)){?>class="new-time"<?php }?>><?php echo gmdate('m月d日', $value['date']); ?></font>
  <a href="<?php echo $value['log_url']; ?>">
			<?php if(((date('Ymd',time())-date('Ymd',$value['date']))< 1)){?> <c style="color:red">
                  <?php }?><?php echo $value['log_title']; ?></c></a>
  </li>
        <?php 
			endforeach;
			else:
		?>
			<!-- 预留给系统搜索 -->
			<div style="margin-top: 20px;text-align: center;">
				<h1>Not Found</h1>
				<p>抱歉，没有找到你想找的内容</p>
				<img src="<?php echo TEMPLATE_URL?>images/404.jpg">
				
			</div>
			
		<?php endif;?>
   </ul>
  </section>
    <!-- 分页 -->
    <div id="pagenavi">
    	<div class="lists-navigator clearfix">
    		<ol class="page-navigator">
    			<?php echo sheli_fy($lognum,$index_lognum,$page,$pageurl);?>
    		</ol>
    	</div>
	</div>

</section>
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
</main>

<?php
 include View::getView('footer');
?>