<?php
!defined('EMLOG_ROOT') && exit('出错了！！！!');
function plugin_setting_view(){
    include 'yxjsinaimg_config.php';
    ?>
    <span style=" font-size:18px; font-weight:bold;">新浪图床设置</span><?php if(isset($_GET['setting'])){echo "<span class='actived'>设置保存成功!</span>";}?><br /><br />
    <form action="plugin.php?plugin=yxjsinaimg&action=setting" method="post">
        <table style="width:100%">
            <thead>
                <tr>
                    <td width="30%" valign="top" style="word-break: break-all;">
                        账号设置
                    </td>
                    <td width="70%" valign="top" style="word-break: break-all;">
                        选项
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="30%" valign="top" style="word-break: break-all;">
                        新浪登录账号：
                    </td>
                    <td width="70%" valign="top" style="word-break: break-all;">
                        <input type="text" name="sinauser" value="<?php echo $config['sinauser'];?>">
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" style="word-break: break-all;">
                        新浪登录密码：
                    </td>
                    <td width="70%" valign="top" style="word-break: break-all;">
                        <input type="text" name="sinapwd" value="<?php echo $config['sinapwd'];?>">
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" style="word-break: break-all;">
                        是否引入juqery.js
                    </td>
                    <td width="70%" valign="top" style="word-break: break-all;">
                        <input type="radio" name="jq" value="1" <?php if ($config["jq"] == 1) { echo 'checked'; } ?>>开
                        <input type="radio" name="jq" value="0" <?php if ($config["jq"] != 1) { echo 'checked'; } ?>>关
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" style="word-break: break-all;">
                        上传接口token:
                    </td>
                    <td width="70%" valign="top" style="word-break: break-all;">
                        <input type="text" name="token" value="<?php echo $config['token'];?>">
                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
        <table style="width:100%">
            <thead>
                <tr>
                    <td width="30%" valign="top" style="word-break: break-all;">
                        水印设置
                    </td>
                    <td width="70%" valign="top" style="word-break: break-all;">
                        选项
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="30%" valign="top" style="word-break: break-all;">
                        是否开启水印上传
                    </td>
                    <td width="70%" valign="top" style="word-break: break-all;">
                        <input type="radio" name="wate" value="1" <?php if ($config["wate"] == 1) { echo 'checked'; } ?>>开启
                        <input type="radio" name="wate" value="0" <?php if ($config["wate"] != 1) { echo 'checked'; } ?>>关闭
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" style="word-break: break-all;">
                        水印类型选择
                    </td>
                    <td width="70%" valign="top" style="word-break: break-all;">
                        <input type="radio" name="type" value="img" <?php if ($config["type"] == 'img') { echo 'checked'; } ?>>图片水印
                        <input type="radio" name="type" value="text" <?php if ($config["type"] != 'img') { echo 'checked'; } ?>>文字水印
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" style="word-break: break-all;">
                        是否本地留存(如有需要可在本地存储一份)
                    </td>
                    <td width="70%" valign="top" style="word-break: break-all;">
                        <input type="radio" name="copy" value="1" <?php if ($config["copy"] == '1') { echo 'checked'; } ?>>是
                        <input type="radio" name="copy" value="0" <?php if ($config["copy"] != '1') { echo 'checked'; } ?>>否
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" style="word-break: break-all;">
                        水印透明度(图片水印由于个别原因不支持透明度)
                    </td>
                    <td width="70%" valign="top" style="word-break: break-all;">
                        <input type="number" name="wateAlpha" value="<?php echo $config['wateAlpha'];?>">
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" style="word-break: break-all;">
                        文字水印内容(支持使用\r\n换行浮)
                    </td>
                    <td width="70%" valign="top" style="word-break: break-all;">
                        <input type="text" name="wateContent" value="<?php echo $config['wateContent'];?>">
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" style="word-break: break-all;">
                        文字水印字体文件(需要将字体文件上传到插件目录中，并填写文件名全名)
                    </td>
                    <td width="70%" valign="top" style="word-break: break-all;">
                        <input type="text" name="wateFont" value="<?php echo $config['wateFont'];?>">
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" style="word-break: break-all;">
                        文字水印字体大小
                    </td>
                    <td width="70%" valign="top" style="word-break: break-all;">
                        <input type="number" name="wateSize" value="<?php echo $config['wateSize'];?>">
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" style="word-break: break-all;">
                        文字水印字体角度(默认为0)
                    </td>
                    <td width="70%" valign="top" style="word-break: break-all;">
                        <input type="number" name="wateAngle" value="<?php echo $config['wateAngle'];?>">
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" style="word-break: break-all;">
                        文字水印字体颜色(请将rgb色值拆分为三段分别填写到文本框中)
                    </td>
                    <td width="70%" valign="top" style="word-break: break-all;">
                        <input type="text" name="wateColor1" value="<?php echo $config['wateColor1'];?>">
                        <input type="text" name="wateColor2" value="<?php echo $config['wateColor2'];?>">
                        <input type="text" name="wateColor3" value="<?php echo $config['wateColor3'];?>">
                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
        <table style="width:100%" border="0">
            <thead>
                <tr>
                    <td width="30%" valign="top" style="word-break: break-all;">
                        水印位置
                    </td>
                    <td width="70%" valign="top" style="word-break: break-all;">
                        选项
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><label><input type="radio" name="watePositon" id="radio" value="1"  <?php if ($config["watePositon"] == '1') { echo 'checked'; } ?>/>左上</label></td>
                    <td><label><input type="radio" name="watePositon" id="radio" value="2"  <?php if ($config["watePositon"] == '2') { echo 'checked'; } ?>/>右上</label></td>
                </tr>
                <tr>
                    <td colspan="3"><label><input type="radio" name="watePositon" id="radio" value="5"  <?php if ($config["watePositon"] == '3') { echo 'checked'; } ?>/>中间</label></td>
                </tr>
                <tr>
                    <td><label><input type="radio" name="watePositon" id="radio" value="4"  <?php if ($config["watePositon"] == '4') { echo 'checked'; } ?>/>左下</label></td>
                    <td><label><input type="radio" name="watePositon" id="radio" value="5"   <?php if ($config["watePositon"] == '5') { echo 'checked'; } ?>/>右下</label></td>
                </tr>
                <tr>
                    <td><label><input type="radio" name="watePositon" id="radio" value="7" <?php if ($config["watePositon"] == '7') { echo 'checked'; } ?>/>随机</label></td>
                    <td><label><input type="radio" name="watePositon" id="radio" value="6"  <?php if ($config["watePositon"] == '6') { echo 'checked'; } ?>/>全图</label></td>
                </tr>
            </tbody>
            
        </table>
        <input type="submit" class="button" name="submit" value="保存设置" />
    </form>
    <h3>jquery说明</h3>
    <p>因为有些后台模版是没有引入jquery.js的，所以添加了这一功能</p>
    <p>jquery版本:2.1.4</p>
    <p>默认关闭，如果出现报错或者功能不能正常使用，请开启</p>
    <h3>新浪账号说明</h3>
    <p>账号为必填，不填将上传失败</p>
    <p>账号必须支持图片上传(如果上传出错请查看这项)</p>
    <p>账号必须是有效账号(如果获取不到cookie查看这项)</p>
    <h3>插件说明</h3>
    <p>图片尽量别太大,会导致上传速度慢,最大上传限制由新浪接口规定</p>
    <p>如有问题请联系QQ：<a href="http://wpa.qq.com/msgrd?v=3&uin=1170535111&site=qq&menu=yes" target="_blank">1170535111</a></p>

    <?php }?>
    <?php 
    function plugin_setting(){
        include 'yxjsinaimg_config.php';
        $newConfig = '<?php
        $config = array(
            "jq" => "'.$_POST["jq"].'",
            "sinauser" => "'.$_POST["sinauser"].'",
            "sinapwd" => "'.$_POST["sinapwd"].'",
            "cookie" => "'.$config['cookie'].'",
            "time" => "'.$config["time"].'",
            "token" => "'.$_POST["token"].'",
            "wate" => "'.$_POST["wate"].'",
            "type" => "'.$_POST["type"].'",
            "watePositon" => "'.$_POST["watePositon"].'",
            "wateAlpha" => "'.$_POST["wateAlpha"].'",
            "wateContent" => "'.$_POST["wateContent"].'",
            "wateSize" => "'.$_POST["wateSize"].'",
            "wateAngle" => "'.$_POST["wateAngle"].'",
            "wateFont" => "'.$_POST["wateFont"].'",
            "wateColor1" => "'.$_POST["wateColor1"].'",
            "wateColor2" => "'.$_POST["wateColor2"].'",
            "wateColor3" => "'.$_POST["wateColor3"].'",
            "copy" => "'.$_POST["copy"].'",
        );';
        echo $newConfig;
        @file_put_contents(EMLOG_ROOT.'/content/plugins/yxjsinaimg/yxjsinaimg_config.php', $newConfig);
    }
    ?>