<?php
/**
 * 站点首页模板
 */
if (!defined('EMLOG_ROOT')) {
    exit('error!');
}
?>
<div class="container grid-large"><div class="grid">

<div class="big-x8">
  <?php if (empty($_GET["sort"])):?>
  <div class="flip margin-bottom" id="slider">
    <div class="flip-body" align="center">
      <a class="flip-item" href="http://www.panxiaonan.cc" target="_blank">
        <picture>
          <source media="(max-width: 1279px)" srcset="https://www.pintuer.com/static/images/banner1x.jpg">
          <source media="(min-width: 1280px)" srcset="https://www.pintuer.com/static/images/banner1.jpg">
          <img src="https://www.pintuer.com/static/images/banner1x.jpg" class="img-auto radius" alt="" />
        </picture>
      </a>
      <a class="flip-item effect-hover" href="http://www.panxiaonan.cc" target="_blank">
        <picture>
          <source media="(max-width: 1279px)" srcset="https://www.pintuer.com/static/images/banner2x.jpg">
          <source media="(min-width: 1280px)" srcset="https://www.pintuer.com/static/images/banner2.jpg">
          <img src="https://www.pintuer.com/static/images/banner2x.jpg" class="img-auto radius" alt="" />
        </picture>
      </a>
    </div>
    <div class="flip-prev text-white" id="slider-prev"></div>
    <div class="flip-next text-white" id="slider-next"></div>
  </div>
  <script>
    $(function(){
      $('#slider').flip({
        "page":true,
        "prev":"#slider-prev",
        "next":"#slider-next",
      });
    });
  </script>
  <?php endif; ?>
  <div class="bg-white radius">
    <h2 class="title text-main"><?php blog_sort_name(intval($_GET["sort"])); ?></h2>
    <?php
    if (!empty($logs)):
        foreach ($logs as $value):
            ?>
          <div class="blog">
            <time class="float-right"><?php if(intval(gmdate('j',$value['date'])<10)){echo "0";}echo gmdate('j', $value['date']); ?><span class="block"><?php echo gmdate('Y-n', $value['date']); ?></span></time>
            <h3><a href="<?php echo $value['log_url']; ?>"><?php echo $value['log_title']; ?></a><?php topflg($value['top'], $value['sortop'], isset($sortid) ? $sortid : ''); ?></h3>
            <p class="size-mini text-gray margin-bottom-small">
              <?php blog_author($value['author']); ?>
              <?php blog_sort($value['logid']); ?>
              <?php editflg($value['logid'], $value['author']); ?>
            </p>
            <div class="size-small text-dark description"><?php echo $value['log_description']; ?></div>
            <div class="clearfix text-gray size-mini margin-top-small">
              <span class="float-right">
                <a class="text-gray margin-right-small" href="<?php echo $value['log_url']; ?>#comments">评论(<?php echo $value['comnum']; ?>)</a>
                <a class="text-gray" href="<?php echo $value['log_url']; ?>">浏览(<?php echo $value['views']; ?>)</a>
              </span>
              <?php blog_tag($value['logid']); ?>
            </div>
          </div>
            <?php
        endforeach;
    else:
        ?>
      <div class="padding-large">
        <strong>未找到</strong>
        <p>抱歉，没有符合您查询条件的结果。</p>
      </div>
    <?php endif; ?>
  </div>

  <div id="pagenavi">
    <?php echo $page_url; ?>
  </div>
</div>

<?php include View::getView('side');?>
</div></div>
<?php include View::getView('footer');?>
