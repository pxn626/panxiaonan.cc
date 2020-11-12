<?php
/**
 * 阅读文章页面
 */
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div class="container grid-large"><div class="grid">

	<div class="big-x8">
		<div class="bg-white radius">
			<div class="article">
				<h1 class="weight"><?php topflg($top); ?><?php echo $log_title; ?></h1>
				<p class="text-gray size-mini"><i class="icon-clock"></i> <?php echo gmdate('Y-n-j', $date); ?>  &nbsp;&nbsp; <?php blog_author($author); ?> <?php blog_sort($logid); ?> <?php editflg($logid,$author); ?></p>
			</div>
			<div class="detail padding-big">
				<?php doAction('down_log',$logid); ?>
				<?php doAction('log_related', $logData); ?>
				<?php echo $log_content; ?>
				<p class="text-gray size-mini"><?php blog_tag($logid); ?></p>
				<?php doAction('log_related', $logData); ?>
				<div class="nextlog clearfix"><?php neighbor_log($neighborLog); ?></div>
			</div>
		</div>
		<div class="bg-white radius margin-top">
			<p class="title size">赞赏</p>
			<div class="padding-large radius radius-top">
				<div class="grid">
					<div class="x6 big-x3 big-move1 order0 text-gray size-small" align="center"><img src="http://www.panxiaonan.cc/image/weixin.jpg" width="128" class="margin-top" /><br />微信</div>
					<div class="x6 big-x3 big-order2 text-gray size-small" align="center"><img src="http://www.panxiaonan.cc/image/zhifubao.jpg" width="128" class="margin-top" /><br />支付宝</div>
					<div class="x12 big-x4 big-order1" align="center"><span class="size-mini text-gray margin-top block">拼图有真情 / 人间有真爱</span><strong class="h4 weight">您的赞赏将被用于</strong><br /><ul class="text-dark inline"><li>持续深入的开发</li><li>提供更多的风格</li><li>租用更好的带宽</li></ul></div>
				</div>
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
