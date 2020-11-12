<?php
/*
 Plugin Name: 新浪外链上传工具
 Version: 1.4
 Plugin URL: http://www.youngxj.cn
 Description: 这是一个新浪外链上传工具，免费新浪图床
 ForEmlog:5.3
 Author: 杨小杰
 Author Email: blog@youngxj.cn
 Author URL: http://www.youngxj.cn
*/
 !defined('EMLOG_ROOT') && exit('access deined!');
 function yxjsinaimg(){
   include 'yxjsinaimg_config.php';?>
   <?php if($config['jq']==1){?><script src="<?php echo BLOG_URL;?>content/plugins/yxjsinaimg/jquery.min.js"></script><?php }?>
   <script type="text/javascript">
    $(document).ready(function(){
      $("#imgboxs #insert_img").click(function(){
        if($('#img_title').val()){
          var img_title=$('#img_title').val();
        }else{
          var img_title=$('#title').val();
        }
        if($('#img_alt').val()){
          var img_alt=$('#img_alt').val();

        }else{
          var img_alt=$('#title').val();
        }
        if($('#url').val()){
          smms_cpave("<a target='_blank' href='"+($('#url').val())+"'><img src='"+($('#url').val())+"' title='"+img_title+"' alt='"+img_alt+"' border='0' width='"+($('#img_width').val())+"' height='"+($('#img_height').val())+"' /></a>");}
          else{alert('未上传图片');}
        });
      $("#close_gj").click(function(){
        $("#img_cons").slideUp(200);}); 
      $("#img_titles").click(function(){
        $("#img_cons").toggle();}); 
      $("#clear_img").click(function(){
        $("#img").hide();
        $("#more").hide();
        $('.mselector > button')[0].innerHTML = '选择本地图片';
      });
    });
    function smms_cpave(html){
      if(typeof(KindEditor)!='undefined'){KindEditor.insertHtml('#content',html);}
      else if(typeof(UE)!='undefined'){UE.getEditor('content').execCommand('insertHtml',html);}
      else if(typeof(UM)!='undefined'){UM.getEditor('content').execCommand('insertHtml',html);}
      else{var msg=document.getElementById('content');if(document.selection){this.focus();var sel=document.selection.createRange();sel.text=html;this.focus();}else if(msg.selectionStart||msg.selectionStart=='0'){var startPos=msg.selectionStart;var endPos=msg.selectionEnd;var scrollTop=msg.scrollTop;msg.value=msg.value.substring(0,startPos)+html+msg.value.substring(endPos, msg.value.length);this.focus();msg.selectionStart=startPos+html.length;msg.selectionEnd=startPos+html.length;msg.scrollTop=scrollTop;}else{this.value+=html;this.focus();};};
    };
  </script>
  <style type="text/css">
  #img_boxs{font-weight:bold; font-family:Arial;font-size:12px; cursor:pointer;clears:both;}
  #img_boxs #img_titles{background:#5bc0de;float:left;padding:5px 10px;margin-bottom:5px;float:left;clears:both;color:#fff;border-radius:4px;font-weight:normal;font-family:"Microsoft Yahei";font-size:14px;background-image: linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);background-size: 30px 30px;box-shadow: 0 0 4px 1px rgba(16, 160, 249, 0.3);}
  #img_boxs #img_titles:hover{background-color:#00aff0;}
  #img_boxs #img_cons{z-index:9999;clears:both;float:left;font-weight:normal;margin:5px auto 10px;display:none;border: 1px solid #ccc;padding: 10px;width:300px;border-radius:4px;position: fixed;background: white;top: 20px; }
  #img_boxs #img_cons p{margin:0 0 10px 0;font-size:14px;}
  #img_boxs #img_cons input{width:300px;font-size:12px;padding:5px;border-radius:4px;outline:none;border: 1px solid #ccc;}
  #img_boxs #img_cons input:-webkit-autofill{background:#fff;}
  #img_boxs #img_cons span{float:left;cursor:pointer;border:0;padding:5px 10px;font-size: 12px;margin: 10px;border-radius:4px;color:#fff;background-image: linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);background-size: 30px 30px;box-shadow: 0 0 4px 1px rgba(16, 160, 249, 0.3);}
  #img_boxs #img_cons span:hover{background:#00aff0 !important;color:#fff !important;}
  #img_boxs #img_cons select{padding:5px;border-radius:4px;outline:none;border: 1px solid #ccc;}
</style>
<div id="img_boxs">
  <div id="img_titles" title="点击打开或关闭功能界面">新浪图床上传</div>
  <br/>
  <div id="img_cons">
    <div id="imgboxs">
      <div class="jm">
        <div class="momll" style="text-align:center;">
          <style>
          momll-img{max-width:80%;display:block}
          #choiceimg{position:absolute;z-index:1;cursor:pointer;opacity:0}
          #box,#choiceimg{color:#FFF;display:block;height:40px;line-height:30px;text-align:center}
        </style>
        <div id="box">
          <div class="mselector">
            <input type="file" accept="image/*" style="display:none;" id="file">
            <button type="button" class="btn btn-primary btn-sm" onclick="file.click()" style="width:100%">选择本地图片</button>
          </div>
          <div class="mselector_get">
            <input type="text" id="img_url" style="width: 70%;float: left;" /><input type="button" style="width: 20%;float: right;" onclick="imgGet()" value="远程上传">
          </div>
        </div>
        <img id="img" style="width:30%;margin-top:10px">
        <p id="texts" style="word-wrap:break-word"></p>
        <div id="more" style="display:none;">
          <input type="text" id="img_width" name="img_width" placeholder="宽度" style="width:100%" >
          <input type="text" id="img_height" name="img_height" placeholder="高度" style="width:100%">
          <input type="text" id="img_alt" name="img_alt" placeholder="图片描述" style="width:100%">
          <input type="text" id="img_title" name="img_title" placeholder="这是图片title" style="width:100%"></div>
          <script>
            $(document).ready(function() {
              $('.picurl > input').bind('focus mouseover', function() {
                if (this.value) {
                  this.select()
                }
              });
              $("input[type='file']").change(function(e) {
                images_upload(this.files)
              });
              var obj = $('body');
              obj.on('dragenter', function(e) {
                e.stopPropagation();
                e.preventDefault()
              });
              obj.on('dragover', function(e) {
                e.stopPropagation();
                e.preventDefault()
              });
              obj.on('drop', function(e) {
                e.preventDefault();
                images_upload(e.originalEvent.dataTransfer.files)
              })
            });
            var images_upload = function(files) {
              var flag = 0;
              $('textarea').empty();
              $(files).each(function(key, value) {
                $('.mselector > button')[0].innerHTML = '上传中';
                image_form = new FormData();
                image_form.append('file', value);
                console.log(image_form);
                $.ajax({
                  url: 'https://api.top15.cn/picbed/picApi.php?type=multipart',
                  type: 'POST',
                  data: image_form,
                  mimeType: 'multipart/form-data',
                  contentType: false,
                  cache: false,
                  processData: false,
                  dataType: 'json',
                  success: function(data) {
                    if(data.code=='200'){
                      flag++;
                      if (typeof data.pid != 'null') {
                        $("#img").show();
                        $("#more").show();
                        $("#texts").html('<input type="text" id="url" value="https://ww2.sinaimg.cn/large/'+data['pid']+ '.jpg" style="width:100%;float: left;padding: 5px;line-height: 31px;border: 1px solid #ddd;color: #999;border-bottom-left-radius: 5px;border-top-left-radius: 5px;">');
                        $("#img").attr('src','https://ww2.sinaimg.cn/large/'+data['pid']+ '.jpg');
                        $("#img_width").val(data['width']+'px');
                        $("#img_height").val(data['height']+'px');
                      }
                      if (flag == $("input[type='file']")[0].files.length) {
                        if (typeof data.pid != 'null') {
                          $('.mselector > button')[0].innerHTML = '上传成功'
                        } else {
                          $('.mselector > button')[0].innerHTML = '上传失败';
                          alert('上传出错，请联系QQ1170535111');
                        }
                      }
                    }else{
                      alert(data.msg);
                      $('.mselector > button')[0].innerHTML = '上传失败';
                    }
                  },
                  error: function(XMLResponse) {
                    $('.mselector > button')[0].innerHTML = '上传失败';
                    alert("error:" + XMLResponse.responseText);
                  }
                })
              })
            };
            document.onpaste = function(e) {
              var data = e.clipboardData;
              for (var i = 0; i < data.items.length; i++) {
                var item = data.items[i];
                if (item.kind == 'file' && item.type.match(/^image\//i)) {
                  var blob = item.getAsFile();
                  images_upload(blob)
                }
              }
            }
            function imgGet(){
              $('.mselector > button')[0].innerHTML = '上传中';
              var img_url = $('#img_url').val();
              if(img_url==''||!img_url){
                alert('请填写远程图片完整地址');
                return false;
              }
              $.ajax({
                url: '<?php echo BLOG_URL;?>content/plugins/yxjsinaimg/yxjsinaimg_up.php?img='+img_url+'&token=<?php echo $config['token'];?>',
                type: 'GET',
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                  if(data.code=='200'){
                    if (typeof data.pid != 'null') {
                      $("#img").show();
                      $("#more").show();
                      $("#texts").html('<input type="text" id="url" value="https://ww2.sinaimg.cn/large/'+data['pid']+ '.jpg" style="width:100%;float: left;padding: 5px;line-height: 31px;border: 1px solid #ddd;color: #999;border-bottom-left-radius: 5px;border-top-left-radius: 5px;">');
                      $("#img").attr('src','https://ww2.sinaimg.cn/large/'+data['pid']+ '.jpg');
                      $("#img_width").val(data['width']+'px');
                      $("#img_height").val(data['height']+'px');
                    }
                    $('.mselector > button')[0].innerHTML = '上传成功'
                  }else{
                    alert(data.msg);
                    $('.mselector > button')[0].innerHTML = '上传失败';
                  }
                },
                error: function(XMLResponse) {
                  $('.mselector > button')[0].innerHTML = '上传失败';
                  alert("error:" + XMLResponse.responseText);
                }
              })

              
            }
          </script>
        </div>
      </div>
      <p style="margin:10px 0 0 5px;"><span id="insert_img" style="background-color:#337ab7;">插入图片</span> <span id="close_gj" style="background-color:#5cb85c">关闭工具</span> <span id="clear_img" style="background-color:#f0ad4e">清除图片</span></p>
    </div>
  </div>
</div>
<?php }
addAction('adm_writelog_head', 'yxjsinaimg');
?>
<?php
function sina_img(){
  echo '<div class="sidebarsubmenu" id="yxjsinaimg"><a href="./plugin.php?plugin=yxjsinaimg">新浪图床</a></div>';
}
addAction('adm_sidebar_ext', 'sina_img');
?>