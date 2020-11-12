<?php 
/**
 * 页面底部信息
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div style="clear:both;"></div>

<footer id="footer" class="footer"> 
	<div class="footer-meta" style="text-align:center;"> 
		<!--Powered by <a href="http://www.emlog.net" title="Emlog系统强力驱动">Emlog</a> | Theme：<a href="https://"></a>-->
	<br/><a href="http://www.miibeian.gov.cn" rel="nofollow" target="_blank"><?php echo $icp; ?></a> <br/> <?php echo $footer_info; ?>
		<?php doAction('index_footer'); ?>
	</div> 
</footer>

<!-- end #dyblog -->

<!-- 自动目录 -->


<!-- 到顶部 -->
<div id="scroll-to-top" title="返回顶部" class="headroom show" style="z-index: 9">
	<i class="fa fa-chevron-up"></i>
</div>

<!-- pjax 动画 -->
<div class="loading">
	<div id="loader"></div>
</div>
<meta name="wlhlauth" content="9da9f1a956d732824444013bcc8d3aaf"/>
<!-- JavaScript -->
<script src="//libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<script src="//cdn.bootcss.com/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<script src="//api.top15.cn/static/script/jquery.prettify.js"></script>
<script src="<?php echo TEMPLATE_URL?>script/main.js?v1.0.3"></script>
</body>
</html>
<?php $html=ob_get_contents();ob_get_clean();echo em_compress_html_main($html); ?>