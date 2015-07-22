<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<!-- Set render engine for 360 browser -->
	<meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->

	<link href="/statics/simpleboot/themes/<?php echo C('SP_ADMIN_STYLE');?>/theme.min.css" rel="stylesheet">
    <link href="/statics/simpleboot/css/simplebootadmin.css" rel="stylesheet">
    <link href="/statics/js/artDialog/skins/default.css" rel="stylesheet" />
    <link href="/statics/simpleboot/font-awesome/4.2.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
    <style>
		.length_3{width: 180px;}
		form .input-order{margin-bottom: 0px;padding:3px;width:40px;}
		.table-actions{margin-top: 5px; margin-bottom: 5px;padding:0px;}
		.table-list{margin-bottom: 0px;}
	</style>
	<!--[if IE 7]>
	<link rel="stylesheet" href="/statics/simpleboot/font-awesome/4.2.0/css/font-awesome-ie7.min.css">
	<![endif]-->
<script type="text/javascript">
//全局变量
var GV = {
    DIMAUB: "/",
    JS_ROOT: "statics/js/",
    TOKEN: ""
};
</script>
<!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/statics/js/jquery.js"></script>
    <script src="/statics/js/wind.js"></script>
    <script src="/statics/simpleboot/bootstrap/js/bootstrap.min.js"></script>
<?php if(APP_DEBUG): ?><style>
		#think_page_trace_open{
			z-index:9999;
		}
	</style><?php endif; ?>
<body class="J_scroll_fixed">
	<div class="wrap J_check_wrap">
		<ul class="nav nav-tabs">
			<li class="active"><a href="<?php echo U('Index/desList');?>">所有震后感</a></li>
			<li><a href="<?php echo U('Index/desAdd',array('lsttype'=>'years'));?>" target="_self"></a></li>
		</ul>
		<form class="well form-search" method="post" action="<?php echo U('Index/desList');?>">
			<div class="search_type cc mb10">
				<div class="mb10">
					<span class="mr20">
					品牌：<select id="logo" name="search[logo]" onchange="selectLogoOnChange('logo','series','model')" style="width:200px;">
								<option value="--请选择品牌--">--请选择品牌--</option>
							</select>
							车系：<select id="series" name="search[series]" onchange="selectSeriesOnChange('series','model')">
								<option value="--请选择车系--">--请选择车系--</option>
							</select>
							<div style="display:none">年款：<select id="model" name="search[model]" class="easyui-combobox">
								<option value="--请选择车型--">--请选择车型--</option>
							</select></div>&nbsp; &nbsp;
						<input type="submit" class="btn btn-primary" value="搜索" />
					</span>
				</div>
			</div>
		</form>

		

		<form class="J_ajaxForm" action="<?php echo U('Index/listdesorders');?>" method="post">
			
			<table class="table table-hover table-bordered table-list">
				<thead>
					<tr align=center>
						<th width="15"><label><input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x"></label></th>
						<th width="15">序号</th>
						<th width="50">品牌</th>
						<th width="50">车系</th>
						<th width="50">年款</th>
						<th width="80">最后添加时间</th>
						<th width="80">最后添加</th>
						<th width="80">评论数(条)</th>
						<th width="50">状态</th>
						<th width="60">操作</th>
					</tr>
				</thead>
				
				<?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
					<td><input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="ids[]" value="<?php echo ($vo["id"]); ?>" title="ID:<?php echo ($vo["id"]); ?>"></td>
					<td><?php echo ($vo["id"]); ?></td>
					<td><?php echo ($vo["logo_name"]); ?></td>
					<td><?php echo ($vo["series_name"]); ?></td>
					<td><?php echo ($vo["years"]); ?></td>
					<td><?php echo ($vo["addtime"]); ?></td>
					<td><?php echo ($vo["adduser"]); ?></td>
					<td><?php echo ($vo["sum"]); ?></td>
					<td>显示</td>
					<td>
						<a href="<?php echo U('Index/veList',array('lsttype'=>$vo['modelid']>0 ? 'model' : 'years', 'info_id'=>$vo['id'], 'step'=>1, 'act'=>'edit'));?>">查看</a> | 
						<a href="<?php echo U('Index/veAdd',array('info_id'=>$vo['id']));?>" class="">添加</a></td>
				</tr><?php endforeach; endif; ?>
				
			</table>
			<div class="table-actions">
				
				<button class="btn btn-primary btn-small J_ajax_submit_btn" type="submit" data-action="<?php echo U('Index/delete');?>" data-subcheck="true" data-msg="你确定删除吗？">删除</button>
				<button class="btn btn_submit btn-primary btn-small J_ajax_submit_btn" type="submit">排序</button>
			</div>
			<div class="pagination"><?php echo ($Page); ?></div>

		</form>
	</div>
	<script src="/statics/js/common.js"></script>
	<script type="text/javascript" src="/statics/js/content_addtop.js"></script>
	<script src="/statics/js/product/select_logo_data_json.js"></script>
	<script src="/statics/js/product/select_logo_series.js"></script>
	
	<script>
		function refersh_window() {
			var refersh_time = getCookie('refersh_time');
			if (refersh_time == 1) {
				window.location = "<?php echo U('AdminPost/index',$formget);?>";
			}
		}
		

		setInterval(function() {
			refersh_window();
		}, 2000);
		
		$(function() {
			//初始车型联动
			initSelectLogo('logo','series','model','<?php echo ($post_info["logo"]); ?>','<?php echo ($post_info["series"]); ?>','<?php echo ($post_info["model"]); ?>');
			setCookie("refersh_time", 0);

			
		});
	</script>
</body>
</html>