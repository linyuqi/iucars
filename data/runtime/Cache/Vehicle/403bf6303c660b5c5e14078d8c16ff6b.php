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
	        <li><a href="<?php echo U('Index/desList');?>">所有震后感</a></li>
	        <li class="active"><a href="#">添加震后感</a></li>
	    </ul>
		<form class="form-horizontal J_ajaxForm" name="myform" id="myform" method="post">
			<div class="tabbable">
		        <div class="tab-content">

		          <div class="tab-pane active" id="A">
		          		<table cellpadding="2" cellspacing="2" width="100%">
							<tbody>
								<tr>
									<td width="140">说明书ID:</td>
									<td><input type="hidden" class="input" name="info_id" id="info_id" value="<?php echo ($info_id); ?>"><?php echo ($info_id); ?></td>
								</tr>
								<tr width="140">
									<td>评论者:</td>
									<td><input type="text" class="input" name="author" id="author" value=""><span class="must_red">*</span></td>
								</tr>

						        <tr>
						          <td>评论者头像:</td>
						          <td>
						          	<div><input type='hidden' name='avatar' id='class' value=''>
									<a href='javascript:void(0);' onclick="flashupload('class_images', '附件上传','class',thumb_images,'1,jpg|jpeg|gif|png|bmp,1,,,1','','','');return false;">
									<img src='/statics/images/icon/upload-pic.png' id='class_preview' width='135' height='113' style='cursor:hand' /></a>
						            <input type="button"  class="btn" onclick="$('#class_preview').attr('src','/statics/images/icon/upload-pic.png');$('#class').val('');return false;" value="取消图片">
						            </div>
									</td>
						        </tr>
								<tr>
								 <td>是否显示</td>
								 <td>
								 	<input value="1" type="radio" name="stat" class="stat" checked>是&nbsp;&nbsp;&nbsp;&nbsp;
								 	<input value="0" type="radio" name="stat" class="stat">否	
								 </td>
								</tr>
								<tr>
									<td>评论内容:</td>
									<td><textarea name="content" id="content" rows="5" cols="57"></textarea><span class="must_red">*</span>
									<input type="hidden" name="info_id" id="info_id" value="<?php echo ($info_id); ?>">
									</td>
								</tr>
								<!--<tr>
									<td>是否启用:</td>
									<td><select name="disabled">
											<?php if(is_array($disabled)): foreach($disabled as $key=>$vo): ?><option value="<?php echo ($key); ?>"><?php echo ($vo); ?></option><?php endforeach; endif; ?>
									</select></td>-->
								</tr>
							</tbody>
						</table>
		          </div>

 				</div>

		    </div>
		     <div class="form-actions">
		           <button class="btn btn-primary btn_submit" type="button">提交</button>
		     </div>
		</form>
	</div>
	<script type="text/javascript" src="/statics/js/common.js"></script>
	<script type="text/javascript" src="/statics/js/content_addtop.js"></script>
	<script>
		$().ready(function(){
			$(".btn_submit").click(function(){
				var author = $("#author").val();
				var avatar = $("#class_preview").attr('src');
				var content = $("#content").val();
				var stat = $("input[name=stat]").val();
				var info_id = $("#info_id").val();
				
				//console.log(parentid+'_'+classname+'_'+imgurl+'_'+description);
				if(avatar != '/statics/images/icon/upload-pic.png' && author != '' && content != ''){
					$.ajax({
						url:'/index.php?g=Vehicle&m=Index&a=veAdd',
						type:'post',
						data:{"author":author, "avatar":avatar,"content":content, "info_id":info_id,"stat":stat},
						success:function(msg){
							var content = '';
							
							if(msg){
								content = '自定义添加成功！';
							}else{
								content = '自定义添加失败！';
							}
							
							Wind.use("artDialog",function(){
								art.dialog({
									title: '提示信息',
									fixed: true,
									id:"classself_priviews",
									lock: true,
									background:"#CCCCCC",
									opacity:0,
									content: content,
									cancelVal: '确定',
									cancel: function(){
										art.dialog({id : "add_self"}).close();
									}
								});
								
							});
						}
					});
				}else{
					art.dialog({
						title: '提示信息',
						fixed: true,
						id:"cc_priviews",
						lock: true,
						background:"#CCCCCC",
						opacity:0,
						content: "请填写必填项！",
						cancelVal: '确定',
						cancel: true
					});
				}
			})
		})
	</script>
</body>
</html>