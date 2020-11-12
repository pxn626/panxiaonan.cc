<?php
/**
 * 页面底部信息
 */
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<footer class="bg-deep">
	<div class="container padding-top padding-bottom">
		<div class="grid text-gray size-mini">
			<div class="big-x6">
				Copyright &copy; 2020 <a class="text-main" href=""><?php echo $blogname; ?></a>
				<a href="http://www.miibeian.gov.cn" target="_blank"><?php echo $icp; ?></a> <?php echo $footer_info; ?>
			</div>
			<div class="big-x6 big-align-right">
				Powered by <a href="http://www.panxiaonan.cc" title="" class="text-dark">panxiaonan.cc</a>
			</div>
		<?php doAction('index_footer'); ?>
		</div>
	</div>
</footer>
<script src="<?php echo TEMPLATE_URL; ?>pintuer-2.0.min.js"></script>
</body>
</html>
