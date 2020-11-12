<?php
/**
 * 微语部分
 */
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div class="container grid-large"><div class="grid">

<div class="big-x8">
  <div class="bg-white radius">
    <h2 class="title">微语</h2>
    <div class="padding weiyu">
    <?php
    foreach($tws as $val):
    $author = $user_cache[$val['author']]['name'];
    $avatar = empty($user_cache[$val['author']]['avatar']) ?
                BLOG_URL . 'admin/views/images/avatar.jpg' :
                BLOG_URL . $user_cache[$val['author']]['avatar'];
    $tid = (int)$val['id'];
    $img = empty($val['img']) ? "" : '<a title="查看图片" href="'.BLOG_URL.str_replace('thum-', '', $val['img']).'" target="_blank"><img style="border: 1px solid #EFEFEF;" src="'.BLOG_URL.$val['img'].'"/></a>';
    ?>
      <div class="media">
        <div align="center" class="margin-right size-mini">
          <img src="<?php echo $avatar; ?>" width="32px" height="32px" class="radius-circle" />
          <br />
          <?php echo $author; ?>
        </div>
        <div class="media-body">
          <p class="margin-bottom-small"><?php echo $val['t'].'<br/>'.$img;?></p>
          <time class="text-gray size-mini"><?php echo $val['date'];?></time> <a class="text-gray size-mini" href="javascript:loadr('<?php echo DYNAMIC_BLOGURL; ?>?action=getr&tid=<?php echo $tid;?>','<?php echo $tid;?>');">回复(<span id="rn_<?php echo $tid;?>"><?php echo $val['replynum'];?></span>)</a>

          <ul class="size-small list-unstyle" id="r_<?php echo $tid;?>" class="r"></ul>
          <?php if ($istreply == 'y'):?>
            <div class="huifu size-small margin-top" id="rp_<?php echo $tid;?>">
              <textarea class="input" rows="2" id="rtext_<?php echo $tid; ?>"></textarea>
              <div class="tbutton margin-top-small">
                <div class="tinfo" style="display:<?php if(ROLE == ROLE_ADMIN || ROLE == ROLE_WRITER){echo 'none';}?>">
                昵称：<input type="text" class="input input-auto" size="10" id="rname_<?php echo $tid; ?>" value="" />
                <span class="margin-left" style="display:<?php if($reply_code == 'n'){echo 'none';}?>">验证码：<input type="text" class="input input-auto" size="10" id="rcode_<?php echo $tid; ?>" value="" /><?php echo $rcode; ?></span>
                </div>
                <input class="button bg-main size-small margin-top-small" type="button" onclick="reply('<?php echo DYNAMIC_BLOGURL; ?>index.php?action=reply',<?php echo $tid;?>);" value="回复" />
                <span id="rmsg_<?php echo $tid; ?>" style="color:#FF0000"></span>
              </div>
            </div>
          <?php endif;?>
        </div>
      </div>
    <?php endforeach;?>
    </div>
  </div>

  <div id="pagenavi">
    <?php echo $page_url; ?>
  </div>
</div>

<?php include View::getView('side');?>
</div></div>
<?php include View::getView('footer');?>
