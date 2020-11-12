<?php
/**
 * 自建页面模板
 */
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div class="container grid-large"><div class="grid">

	<div class="big-x8">
		<div class="bg-white radius">
			<div class="article">
				<h2 class="weight"><?php echo $log_title; ?></h2>
			</div>
			<div class="detail padding-big">
				<?php echo $log_content; ?>
			</div>
		</div>
		<div class="bg-white radius margin-top comments">
			<?php blog_comments($comments); ?>
			<?php blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark); ?>
		</div>
	</div>

<?php include View::getView('side');?>
</div></div>
<?php include View::getView('footer');?>
