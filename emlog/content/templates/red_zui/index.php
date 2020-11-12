
<?php 
/**
 * 站点首页模板
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>

<main class="container">
<section class="wrapper">
  
<article class="gxing" data-aos="fade-up"> 
<center class="gxing1">
<b><?php $Log_Model = new Log_Model(); 
$today = strtotime(date('Y-m-d'));//今天凌晨时间戳 
$threeday = strtotime(date('Y-m-d',strtotime('-3 day')));//3天前凌晨时间戳 
$tenday = strtotime(date('Y-m-d',strtotime('-10 day')));//10天前凌晨时间戳 
$today_sql = "and date>$today"; 
$today_num = $Log_Model->getLogNum('n', $today_sql); 
$threeday_sql = "and date>$threeday"; 
$threeday_num = $Log_Model->getLogNum('n', $threeday_sql); 
$tenday_sql = "and date>$tenday"; 
$tenday_num = $Log_Model->getLogNum('n', $tenday_sql); 
if($tenday_num=='0'){echo '这资源网已经废了 都10几天了 没有更新内容     |     ';} 												
elseif($threeday_num=='0'){echo '这资源网快要荒废了 连续3天都没有更新文章了   |   ';} 
elseif($today_num=='0'){echo '今日站长很懒 一篇文章都没更新   |   ';} 
else{echo ' <b>今日已更新</b> <b style="color:red">'.$today_num.'</b>个资源   |   ';} 
?>本站共分享了<b style="color:red"><?php echo $sta_cache['lognum'];?>个资源</b></b> 
</center> 
</article> 
  
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
				<p>抱歉，本破站没有</p>
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
 <so2>   
  <a class="so-search" href="javascript:;"><i class="fa fa-search"></i></a>
  <form method="get" action="<?php echo BLOG_URL;?>" class="search">
  <input type="text" placeholder="每天搜一搜！" value="" name="keyword">
  <button type="submit"><i class="fa fa-search"></i></button>
  </form>
   </so2>
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
</section></section>
  

  
    <div class="friends">
	<div class="links_title">
		<div class="links_left">
			<a href="/" title="友情链接">友情链接</a>
		</div>
	</div>      
            <?php pages_links();?>  	
      </div>   
</main>

<?php
 include View::getView('footer');
?>