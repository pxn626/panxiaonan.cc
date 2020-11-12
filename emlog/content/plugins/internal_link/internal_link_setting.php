<?php
!defined('EMLOG_ROOT') && exit('error');
function plugin_setting_view()
{
    $DB     = Database::getInstance();
    $result = $DB->query("SELECT * FROM  `" . DB_PREFIX . "internal_link`");
    ?>

<!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<!-- jQuery (Bootstrap 的所有 JavaScript 插件都依赖 jQuery，所以必须放在前边) -->
<script src="https://cdn.bootcss.com/jquery/2.2.2/jquery.min.js"></script>
<style type="text/css">
	.alert{
		position: fixed;
	    top: 100px;
	    width: 280px;
	    z-index: 999;
	    display: none;
	}
</style>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-info">
		  <div class="panel-heading">插件介绍</div>
		  <div class="panel-body">
		    <p>插件名：文章自定义关键词内外链</p>
		    <p>插件作者：Youngxj</p>
		    <p>插件介绍：快速方便自定义文章中指定关键词的指向链接，能有效优化蜘蛛爬取及用户快速获取相关信息</p>
		    <p>作者博客：<a href="https://www.youngxj.cn">杨小杰博客</a></p>
		  </div>
		</div>
	</div>
	<div class="col-lg-12">
		<div class="alert alert-warning alert-dismissible" role="alert">
		  消息提示
		</div>
	</div>
	<div class="col-lg-12">
		<div class="panel panel-default">
		  <div class="panel-heading">新增规则</div>
			  <div class="panel-body">
			<form action="plugin.php?plugin=internal_link&action=setting" method="post" id="internal">
			  <div class="form-group">
			    <label for="keyword">关键词</label>
			    <input type="text" class="form-control" id="keyword" name="keyword" placeholder="文章关键词">
			  </div>
			  <div class="form-group">
			    <label for="url">链接地址</label>
			    <input type="text" class="form-control" id="url" name="url" placeholder="指定链接">
			  </div>
			  <button type="button" class="btn btn-default" onclick="inc()">添加</button>
			</form>
			</div>
		</div>
	</div>
	<div class="col-lg-12">
		<div class="panel panel-default">
		  <div class="panel-heading">规则列表</div>
		  <div class="panel-body">
		    <table class="table table-hover table-responsive">
			  <thead>
		        <tr>
		          <th>#</th>
		          <th>关键词</th>
		          <th>链接</th>
		          <th>添加时间</th>
		          <th>状态</th>
		          <th>操作</th>
		        </tr>
		      </thead>
		      <tbody>
		      	<?php while ($row = $DB->fetch_array($result)) {$id = $row['id'];?>
		        <tr>
		          <th scope="row"><?=$id;?></th>
		          <td><?=$row['keyword'];?></td>
		          <td><?=$row['url'];?></td>
		          <td><?=date("Y/m/d H:i:s", $row['time']);?></td>
		          <td>
		          	<?php 
		          	if($row['status']){
		          		echo "<a href='javascript:status($id,0)' title='点击禁用' class='btn btn-success btn-sm'>已启用</a>";
		          	}else{
		          		echo "<a href='javascript:status($id,1)' title='点击启用' class='btn btn-info btn-sm'>已禁用</a>";
		          	}
		          	?>
		          </td>
		          
		          <td><a href="javascript:del('<?=$row['id'];?>')" class="btn btn-danger btn-sm">删除</a></td>
		        </tr>
		    <?php }?>
		      </tbody>
			</table>
		  </div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function inc(){
		data = $('#internal').serialize();
		$.post('plugin.php?plugin=internal_link&action=setting', data, function(res, textStatus, xhr) {
			if(res.code==1){
				$('.alert').attr('class','alert alert-success alert-dismissible');
			}else{
				$('.alert').attr('class','alert alert-warning alert-dismissible');
			}
			$('.alert').show();
			$('.alert').html(res.msg);
			setTimeout("$('.alert').hide()",3000);
		});
	}
	function del(id){
		$.post('plugin.php?plugin=internal_link&action=setting&type=del',{id:id}, function(res, textStatus, xhr) {
			if(res.code==1){
				$('.alert').attr('class','alert alert-success alert-dismissible');
			}else{
				$('.alert').attr('class','alert alert-warning alert-dismissible');
			}
			$('.alert').show();
			$('.alert').html(res.msg);
			setTimeout("$('.alert').hide()",3000);
		});
	}
	function status(id,status){
		$.post('plugin.php?plugin=internal_link&action=setting&type=status',{id:id,status:status}, function(res, textStatus, xhr) {
			if(res.code==1){
				$('.alert').attr('class','alert alert-success alert-dismissible');
			}else{
				$('.alert').attr('class','alert alert-warning alert-dismissible');
			}
			$('.alert').show();
			$('.alert').html(res.msg);
			setTimeout("$('.alert').hide()",3000);
		});
	}
</script>


<?php }?>
<?php
function plugin_setting()
{
    header('content-type:application/json;charset=utf-8');
    $type = isset($_GET['type']) ? $_GET['type'] : '';
    $DB  = Database::getInstance();
    if ($type == 'del') {
        $id = (int) $_POST['id'];
        if (!$id) {
            exit(json_encode(['code' => '0', 'msg' => '异常请求']));
        }
        
        $del = $DB->query("DELETE FROM `" . DB_PREFIX . "internal_link` WHERE id=$id");
        if ($del) {
            exit(json_encode(['code' => '1', 'msg' => '删除成功']));
        } else {
            exit(json_encode(['code' => '0', 'msg' => '删除失败']));
        }
    } elseif ($type == 'status') {
        $id     = (int) $_POST['id'];
        $status = (int) $_POST['status'];
        if (!$id) {
            exit(json_encode(['code' => '0', 'msg' => '异常请求']));
        }
        $del = $DB->query("UPDATE `" . DB_PREFIX . "internal_link` SET status='$status' WHERE id=$id");
        if ($del) {
            exit(json_encode(['code' => '1', 'msg' => '修改成功']));
        } else {
            exit(json_encode(['code' => '0', 'msg' => '修改失败']));
        }
    } else {
        $url     = addslashes($_POST['url']);
        $keyword = addslashes($_POST['keyword']);
        if (!$url || !$keyword) {
            exit(json_encode(['code' => '0', 'msg' => '关键词或链接都不能为空']));
        }
        $inc = $DB->query("INSERT INTO `" . DB_PREFIX . "internal_link` (url,keyword,time,status) VALUES ('$url','$keyword','" . time() . "','1')");
        if ($inc) {
            exit(json_encode(['code' => '1', 'msg' => '添加成功']));
        } else {
            exit(json_encode(['code' => '0', 'msg' => '添加失败']));
        }
    }

}
