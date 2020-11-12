<link href="http://cdn.bootcss.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<?php $this->assets('main'); ?>
<div id="comment-push-main">
  <div id="comment-push-header">
    <h2>评论推送</h2>
  </div>
  <div id="comment-push-message"></div>
  <div id="comment-push-setting-box">
    <div id="comment-push-apikey">
      <div class="comment-push-label">
        <label for="apikey">API Key <a href="https://www.pushbullet.com/" target="_blank">获取API</a></label>
      </div>
      <input id="comment-push-apikey-input" type="text" class="form-control" name="apikey" value="<?php echo htmlspecialchars($key); ?>">
      <button id="comment-push-apikey-btn" class="btn btn-default comment-push-listen">保存</button>
    </div>
    <div id="comment-push-devices">
      <div class="comment-push-label">
        设备管理
        <a href="javascript:void(0);" id="comment-push-refresh-devices" class="comment-push-listen"><i class="fa fa-refresh"></i></a>
      </div>
      <ol id="comment-push-devices-list">
        <?php foreach ($devices as $device): ?>
        <li class="item" data-iden="<?php echo $device['iden']; ?>">
          <div class="devicesname">
            <?php echo htmlspecialchars($device['name']); ?> <span class="right toggle fa fa-<?php echo $device['push'] == 1 ? 'check' : 'times'; ?>"></span>
          </div>
        </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </div>
  <div id="comment-push-testbox">
    <div class="comment-push-label">
      <label for="apikey">测试推送</label>
    </div>
    <input type="text" class="form-control" placeholder="标题" id="comment-push-testbox-title"/>
    <textarea name="" id="comment-push-testbox-content" cols="30" rows="10" class="form-control" placeholder="推送内容"></textarea>
    <button id="comment-push-testbox-submit" class="btn btn-default comment-push-listen">提交推送</button>
  </div>
</div>
<script>
  $(function() {
    $(document).on('click', '.comment-push-listen', function() {
      var that = $(this), id = that.attr('id');
      switch (id) {
        case 'comment-push-apikey-btn':
          var apikey = $('#comment-push-apikey-input').val();
          that.html('<i class="fa fa-spinner fa-spin"></i>');
          $.ajax({
            url: '',
            type: 'post',
            data: {
              action: 'save_key',
              key: apikey
            },
            dataType: 'json',
            success: function(data) {
              showMsg(data.code, data.msg);
            },
            complete: function() {
              that.html('保存');
            }
          });
          break;
        case 'comment-push-refresh-devices':
          that.children('i').addClass('fa-spin');
          $.ajax({
            url: '',
            type: 'post',
            data: {
              action: 'refresh_devices'
            },
            dataType: 'json',
            success: function(data) {
              if (data.code == 0) {
                var list = $('#comment-push-devices-list').empty();
                $.each(data.devices, function(i, device) {
                  $('<li class="item" />').data('iden', device.iden).append(
                    $('<div class="devicesname" />').append(
                      device.name,
                      $('<span class="right toggle fa" />').addClass(device.push ? 'fa-check' : 'fa-times')
                    )
                  ).appendTo(list);
                });
                $('#comment-push-testbox').height($('#comment-push-setting-box').height());
              }
              showMsg(data.code, data.msg);
            },
            complete: function() {
              that.children('i').removeClass('fa-spin');
            }
          });
          break;
        case 'comment-push-testbox-submit':
          var title = $('#comment-push-testbox-title').val();
          var content = $('#comment-push-testbox-content').val();
          that.html('<i class="fa fa-spinner fa-spin"></i>');
          $.ajax({
            url: '',
            type: 'post',
            data: {
              action: 'test_push',
              title: title,
              content: content
            },
            dataType: 'json',
            success: function(data) {
              showMsg(data.code, data.msg);
            },
            complete: function() {
              that.html('提交推送');
            }
          });
          break;
      }
    }).on('click', 'span.toggle', function() {
      var that = $(this),
        enable = that.hasClass('fa-times'),
        iden = that.parent().parent().data('iden');
      $.ajax({
        url: '',
        type: 'post',
        data: {
          action: 'toggle_device',
          enable: enable,
          iden: iden
        },
        dataType: 'json',
        success: function(data) {
          if (data.code == 0) {
            that.removeClass(enable ? 'fa-times' : 'fa-check').addClass(!enable ? 'fa-times' : 'fa-check');
          }
          showMsg(data.code, data.msg);
        },
      })
    });
    var message = $('#comment-push-message'), timer;
    function showMsg(code, msg) {
      message.text(msg).css('display', '');
      if (code == 0) {
        message.attr('class', 'success');
        if (timer) {
          window.clearTimeout(timer);
        }
        timer = window.setTimeout(function() {
          message.hide();
        }, 2600);
      } else {
        message.attr('class', 'fail');
      }
    }
    $('#comment-push-testbox').height($('#comment-push-setting-box').height());
  });
</script>