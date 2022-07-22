<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-08 16:17:40
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_zhaopinhui_add.htm" */ ?>
<?php /*%%SmartyHeaderCode:2505762c7e824432ab1-22114264%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bde3db80297375e0cda4eb8304eeddd355161952' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_zhaopinhui_add.htm',
      1 => 1642672635,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2505762c7e824432ab1-22114264',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'info' => 0,
    'space' => 0,
    'v' => 0,
    'Dname' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c7e824527842_22532955',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c7e824527842_22532955')) {function content_62c7e824527842_22532955($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
		<link href="images/reset.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
		<link href="images/system.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
		<link href="images/table_form.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="js/admin_public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
>var weburl = '<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
';<?php echo '</script'; ?>
>
		<link href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/css/layui.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet"
		 type="text/css" />
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/layui.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/phpyun_layer.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>


		<?php echo '<script'; ?>
 language="javascript">

			function checkform(){
	if($("#title").val()=="") {
      	parent.layer.msg('请填写招聘会标题！', 2, 8);
      	return (false);
      }
	var time = $("#time").val();
	if(time==""){
		parent.layer.msg('举办时间不能为空！', 2, 8);
		return false
	}
	$("#zphform").submit();
}
function setStandaside(){
	var zid='<?php echo $_smarty_tpl->tpl_vars['info']->value['id'];?>
';
	var sid=$("#sid").val();
	var pytoken=$("#pytoken").val();
	if(sid==""){
		parent.layer.msg("请先选择场地！",2,8);
	}else{
		$.post("index.php?m=zhaopinhui&c=getzhanwei",{sid:sid,zid:zid,pytoken:pytoken},function(data){
			$("#zhanwei").html(data);
			$.layer({
				type : 1,
				title : '设置预留展位',
				offset: ['100px', ''],
				closeBtn : [0 , true],
				border : [10 , 0.3 , '#000', true],
				area : ['400px','340px'],
				page : {dom : '#Standaside'}
			});
		})

	}
}
function check_zhanwei(){
	var chk_value =[];
	$('input[name="zhanwei"]:checked').each(function(){
		chk_value.push($(this).val());
	});
	$("#reserved").val(chk_value);
	layer.closeAll();
}
function news_preview(url){
	$(".job_box_div").html("<img src='"+url+"' style='max-width:500px' />");//
 	$.layer({
		type : 1,
		title : '查看图片',
		closeBtn : [0 , true],
		offset : ['20%' , '30%'],
		border : [10 , 0.3 , '#000', true],
		area : ['560px','auto'],
		page : {dom : '#news_preview'}
	});
}
<?php echo '</script'; ?>
>

		<style>
			* {margin: 0 ;padding: 0;}
body,div{ margin: 0 ;padding: 0;}
</style>
		<title>后台管理</title>
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/ueditor/ueditor.config.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/ueditor/ueditor.all.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
	</head>
	<body class="body_ifm">
		<div class="infoboxp">
			<div class="tty-tishi_top">
				<div class="admin_new_tip">
					<a href="javascript:;" class="admin_new_tip_close"></a>
					<a href="javascript:;" class="admin_new_tip_open" style="display:none;"></a>
					<div class="admin_new_tit"><i class="admin_new_tit_icon"></i>操作提示</div>
					<div class="admin_new_tip_list_cont">
						<div class="admin_new_tip_list">管理员根据自己需求，填写该场招聘会常规设置！招聘会名称、日期、举办方、招聘会地址和参与说明等设置。还可以上传招聘会的现场图片等个性化设置。</div>
					</div>
				</div>
				<div class="clear"></div>
				<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
				<form id="zphform" name="myform" target="supportiframe" action="index.php?m=zhaopinhui&c=save" method="post"
				 encType="multipart/form-data" class="layui-form">
					<table width="100%" class="table_form" style="background:#fff;">
						<tr class="admin_table_trbg">
							<th colspan="4"><span class="admin_bold">添加招聘会信息</span></th>
						</tr>
						<tr>
							<th width="120">招聘会标题：</th>
							<td>
								<div class="layui-form-item">
									<div class="layui-input-block">
										<div class="layui-input-inline t_w480">
											<input type="text" name="title" id="title" lay-verify="required" placeholder="请输入招聘会标题" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['title'];?>
"
											 size="60" autocomplete="off" class="layui-input input-text">
										</div>
									</div>
								</div>
							</td>
						</tr>

						<tr class="vip_type_2 admin_table_trbg">
							<th width="120">举办场地：</th>
							<td>
								<?php if ($_smarty_tpl->tpl_vars['space']->value) {?>


								<div class="layui-input-inline" style='float:left'>
									<select name="sid" id='sid'>
										<?php if ($_smarty_tpl->tpl_vars['info']->value['sid']) {?>
										<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['space']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
										<?php if ($_smarty_tpl->tpl_vars['v']->value['id']==$_smarty_tpl->tpl_vars['info']->value['sid']) {?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" selected><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
										<?php } else { ?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
										<?php }?>
										<?php } ?>
										<?php } else { ?>
										<option value="">请选择</option>
										<?php }?>

										<?php if (!$_smarty_tpl->tpl_vars['info']->value['sid']) {?>
										<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['space']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
										<?php } ?>
										<?php }?>

									</select>
								</div>
								<a href="javascript:void(0);" onClick="setStandaside()" class="zph_sz_b">设置预留展位</a>
								<a href="index.php?m=zph_space" class="zph_sz_b_tjcd">添加场地</a>

								<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['reserved'];?>
" id="reserved" name="reserved">
								<?php } else { ?>
								<span class="admin_web_tip">
									当前暂无可选场地
								</span>

								<a href="index.php?m=zph_space" class="zph_sz_b_tjcd">添加场地</a>
								<?php }?>
							</td>
						</tr>

						<tr>
							<th>使用范围：</th>
							<td><input type="button" value="<?php if ($_smarty_tpl->tpl_vars['info']->value['did']) {
echo $_smarty_tpl->tpl_vars['Dname']->value[$_smarty_tpl->tpl_vars['info']->value['did']];
} else { ?>总站<?php }?>"
								 class="city_news_but" onClick="add_site('<?php echo $_smarty_tpl->tpl_vars['info']->value['did'];?>
','<?php echo $_smarty_tpl->tpl_vars['Dname']->value[$_smarty_tpl->tpl_vars['info']->value['did']];?>
');">
								<input id="did" type="hidden" name="did" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['did'];?>
" />
							</td>
						</tr>
						<tr class="admin_table_trbg">
							<th width="120">开始时间：</th>
							<td>
								<div class="layui-input-inline t_w480">
									<input type="text" class="layui-input input-text" id="starttime" name="starttime" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['starttime'];?>
"
									 placeholder="yyyy-MM-dd HH:mm:ss" size="60" autocomplete="off">
								</div>
							</td>
						</tr>
						<tr class="admin_table_trbg">
							<th width="120">结束时间：</th>
							<td>
								<div class="layui-input-inline t_w480">
									<input type="text" class="layui-input input-text" id="endtime" name="endtime" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['endtime'];?>
"
									 placeholder="yyyy-MM-dd HH:mm:ss" size="60" autocomplete="off">
								</div>
							</td>
						</tr>
						<tr>
							<th width="120">举办地点：</th>
							<td>
								<div class="layui-form-item">
									<div class="layui-input-block">
										<div class="layui-input-inline t_w480">
											<input type="text" name="address" id="address" lay-verify="required" placeholder="请输入举办会场" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['address'];?>
"
											 size="60" autocomplete="off" class="layui-input">
										</div>
									</div>
								</div>
							</td>
						</tr>
						<tr class="admin_table_trbg">
							<th width="120" class="t_fl">交通路线：</th>
							<td>

								<div class="layui-form-item">
									<div class="layui-input-block">
										<div class="layui-input-inline t_w480">
											<textarea name="traffic" cols="59" rows="3" placeholder="请输入交通路线" lay-verify="required" class="layui-textarea"
											 autocomplete="off"><?php echo $_smarty_tpl->tpl_vars['info']->value['traffic'];?>
</textarea>
										</div>
									</div>
								</div>

							</td>
						</tr>
						<tr>
							<th width="120">联系电话：</th>
							<td>

								<div class="layui-form-item">
									<div class="layui-input-block">
										<div class="layui-input-inline t_w480">
											<input type="text" name="phone" id="phone" lay-verify="required" placeholder="请输入联系电话" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['phone'];?>
"
											 size="60" autocomplete="off" class="layui-input" onkeyup="this.value=this.value.replace(/[^0-9-,， ]/g,'')">
										</div>
									</div>
								</div>

							</td>
						</tr>
						<tr class="admin_table_trbg">
							<th width="120">主办方：</th>
							<td>

								<div class="layui-form-item">
									<div class="layui-input-block">
										<div class="layui-input-inline t_w480">
											<input type="text" name="organizers" id="organizers" lay-verify="required" placeholder="请输入主办方" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['organizers'];?>
"
											 size="60" autocomplete="off" class="layui-input">
										</div>
									</div>
								</div>

							</td>
						</tr>
						<tr>
							<th width="120">联系人：</th>
							<td>
								<div class="layui-form-item">
									<div class="layui-input-block">
										<div class="layui-input-inline t_w480">
											<input type="text" name="user" id="user" lay-verify="required" placeholder="请输入联系人" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['user'];?>
"
											 size="60" autocomplete="off" class="layui-input">
										</div>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<th width="120">显示状态：</th>
							<td>
								<div class="layui-input-inline t_w480">
									<input name="is_open" value="1" id="is_open1" <?php if (!isset($_smarty_tpl->tpl_vars['info']->value)||$_smarty_tpl->tpl_vars['info']->value['is_open']==1) {?>checked<?php }?> title="开启" type="radio" lay-filter="is_open" />
									<input name="is_open" value="0" id="is_open0" <?php if (isset($_smarty_tpl->tpl_vars['info']->value)&&$_smarty_tpl->tpl_vars['info']->value['is_open']!=1) {?>checked<?php }?> title="隐藏" type="radio" lay-filter="is_open" />
								</div>
							</td>
						</tr>
						<tr>
							<th width="120" class="t_fr">PC缩略图：</th>
							<td>

								<button type="button" class="yun_bth_pic noupload" lay-data="{imgid: 'imgicon'}">上传图片</button>
								<input type="hidden" id="laynoupload" value="1" />
								<input type="hidden" name="is_themb" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['is_themb'];?>
"/>
								<img id="imgicon" src="<?php echo $_smarty_tpl->tpl_vars['info']->value['is_themb_n'];?>
" width="195px" height="120px" <?php if (!$_smarty_tpl->tpl_vars['info']->value['is_themb']) {?>class="none"<?php }?>>

								<span class="admin_web_tip" style="margin-left: 10px;">尺寸：200px*120px</span>
							</td>
						</tr>

						<tr>
							<th width="120" class="t_fr">PC横幅：</th>
							<td>

								<button type="button" class="yun_bth_pic noupload2" lay-data="{imgid: 'imgbanner'}">上传图片</button>
								<input type="hidden" name="banner" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['banner'];?>
"/>
								<img id="imgbanner" src="<?php echo $_smarty_tpl->tpl_vars['info']->value['banner_n'];?>
" width="384px" height="60px" <?php if (!$_smarty_tpl->tpl_vars['info']->value['banner']) {?>class="none"<?php }?>>

								<span class="admin_web_tip" style="margin-left: 10px;">尺寸：1920px*300px</span>
							</td>
						</tr>
						<tr>
							<th width="120" class="t_fr">移动端缩略图：</th>
							<td>

								<button type="button" class="yun_bth_pic noupload3" lay-data="{imgid: 'imgwapicon'}">上传图片</button>
								<input type="hidden" name="is_themb_wap" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['is_themb_wap'];?>
"/>
								<img id="imgwapicon" src="<?php echo $_smarty_tpl->tpl_vars['info']->value['is_themb_wap_n'];?>
" width="156px" height="100px" <?php if (!$_smarty_tpl->tpl_vars['info']->value['is_themb_wap_n']) {?>class="none"<?php }?>>

								<span class="admin_web_tip" style="margin-left: 10px;">尺寸：250px*160px</span>
							</td>
						</tr>

						<tr>
							<th width="120" class="t_fr">移动端横幅：</th>
							<td>

								<button type="button" class="yun_bth_pic noupload4" lay-data="{imgid: 'imgwapbanner'}">上传图片</button>
								<input type="hidden" name="banner_wap" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['banner_wap'];?>
"/>
								<img id="imgwapbanner" src="<?php echo $_smarty_tpl->tpl_vars['info']->value['banner_wap_n'];?>
" width="195px" height="120px" <?php if (!$_smarty_tpl->tpl_vars['info']->value['banner_wap']) {?>class="none"<?php }?>>

								<span class="admin_web_tip" style="margin-left: 10px;">尺寸：830px*510px</span>
							</td>
						</tr>
						<tr>
							<th width="120" class="t_fr">招聘会介绍：</th>
							<td>
								<?php echo '<script'; ?>
 id="content" name="body" type="text/plain" style="width:820px;height:300px;"><?php echo $_smarty_tpl->tpl_vars['info']->value['body'];?>
<?php echo '</script'; ?>
>
							</td>
						</tr>
						<tr class="admin_table_trbg">
							<th width="120" class="t_fr">媒体宣传：</th>
							<td>
								<?php echo '<script'; ?>
 id="media" name="media" type="text/plain" style="width:820px;height:300px;"><?php echo $_smarty_tpl->tpl_vars['info']->value['media'];?>
<?php echo '</script'; ?>
>
							</td>
						</tr>
						<tr>
							<th width="120" class="t_fr">服务套餐：</th>
							<td>
								<?php echo '<script'; ?>
 id="packages" name="packages" type="text/plain" style="width:820px;height:300px;"><?php echo $_smarty_tpl->tpl_vars['info']->value['packages'];?>
<?php echo '</script'; ?>
>
							</td>
						</tr>
						<tr class="admin_table_trbg">
							<th width="120" class="t_fr">展位设置方案：</th>
							<td>
								<?php echo '<script'; ?>
 id="booth" name="booth" type="text/plain" style="width:820px;height:300px;"><?php echo $_smarty_tpl->tpl_vars['info']->value['booth'];?>
<?php echo '</script'; ?>
>
							</td>
						</tr>
						<tr>
							<th width="120" class="t_fr">参与办法：</th>
							<td>
								<?php echo '<script'; ?>
 id="participate" name="participate" type="text/plain" style="width:820px;height:300px;"><?php echo $_smarty_tpl->tpl_vars['info']->value['participate'];?>
<?php echo '</script'; ?>
>
							</td>
						</tr>

						<tr class="admin_table_trbg">
							<td align="center" colspan="2">
								<?php if (is_array($_smarty_tpl->tpl_vars['info']->value)) {?>
								<input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['id'];?>
" />
								<input class="layui-btn tty_sub" type="button" onclick="checkform()" value="&nbsp;修 改&nbsp;" />
								<?php } else { ?>
								<input class="layui-btn tty_sub" type="button" onclick="checkform()" value="&nbsp;添 加&nbsp;" />
								<?php }?>
								<input class="layui-btn tty_cz" type="reset" name="reset" value="&nbsp;重 置 &nbsp;" /></td>
						</tr>
					</table>
					<input type="hidden" name="pytoken" id="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
				</form>
			</div>
		</div>
		<div id="news_preview" style="display:none;width:560px ">
			<div style="height:300px; overflow:auto;width:560px;">
				<div class="job_box_div" style="text-align:center;margin-top:10px;"></div>
			</div>
		</div>
		<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['adminstyle']->value)."/checkdomain.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


		<div id="Standaside" style="display:none;">
			<div style=" margin-top:10px;">
				<div id="zhanwei"></div>
			</div>
		</div>
		<style>
			.layui-form-item {
				margin-bottom: 0px;
				clear: both;
			}
			.layui-form-label {
				width: 60px;
				padding: 9px 1px;
			}
			</style>

		<?php echo '<script'; ?>
 language="javascript">
			layui.use(['layer', 'form', 'element', 'laydate'], function() {
				var layer = layui.layer,
					form = layui.form,
					element = layui.element,
					laydate = layui.laydate,
					$ = layui.$;
				//时间选择器
				laydate.render({
					elem: '#starttime',
					type: 'datetime'
				});
				laydate.render({
					elem: '#endtime',
					type: 'datetime'
				});
			});
			UE.getEditor('content', {
				toolbars: [
					['Source', '|', 'Undo', 'Redo', 'Bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'fontfamily',
						'fontsize', 'forecolor', 'backcolor', 'removeformat', 'autotypeset', 'pasteplain', '|', 'insertorderedlist',
						'insertunorderedlist', 'selectall', 'cleardoc', '|', 'simpleupload', '|', 'link', 'unlink', 'indent', '|',
						'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify'
					]
				],
				wordCount: false,
				elementPathEnabled: false,
				initialFrameHeight: 300
			});
			UE.getEditor('booth', {
				toolbars: [
					['Source', '|', 'Undo', 'Redo', 'Bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'fontfamily',
						'fontsize', 'forecolor', 'backcolor', 'removeformat', 'autotypeset', 'pasteplain', '|', 'insertorderedlist',
						'insertunorderedlist', 'selectall', 'cleardoc', '|', 'simpleupload', '|', 'link', 'unlink', 'indent', '|',
						'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify'
					]
				],
				wordCount: false,
				elementPathEnabled: false,
				initialFrameHeight: 300
			});
			UE.getEditor('media', {
				toolbars: [
					['Source', '|', 'Undo', 'Redo', 'Bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'fontfamily',
						'fontsize', 'forecolor', 'backcolor', 'removeformat', 'autotypeset', 'pasteplain', '|', 'insertorderedlist',
						'insertunorderedlist', 'selectall', 'cleardoc', '|', 'simpleupload', '|', 'link', 'unlink', 'indent', '|',
						'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify'
					]
				],
				wordCount: false,
				elementPathEnabled: false,
				initialFrameHeight: 300
			});
			UE.getEditor('packages', {
				toolbars: [
					['Source', '|', 'Undo', 'Redo', 'Bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'fontfamily',
						'fontsize', 'forecolor', 'backcolor', 'removeformat', 'autotypeset', 'pasteplain', '|', 'insertorderedlist',
						'insertunorderedlist', 'selectall', 'cleardoc', '|', 'simpleupload', '|', 'link', 'unlink', 'indent', '|',
						'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify'
					]
				],
				wordCount: false,
				elementPathEnabled: false,
				initialFrameHeight: 300
			});
			UE.getEditor('participate', {
				toolbars: [
					['Source', '|', 'Undo', 'Redo', 'Bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'fontfamily',
						'fontsize', 'forecolor', 'backcolor', 'removeformat', 'autotypeset', 'pasteplain', '|', 'insertorderedlist',
						'insertunorderedlist', 'selectall', 'cleardoc', '|', 'simpleupload', '|', 'link', 'unlink', 'indent', '|',
						'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify'
					]
				],
				wordCount: false,
				elementPathEnabled: false,
				initialFrameHeight: 300
			});
		<?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 type="text/javascript">
			layui.use('upload', function() {
				var $ = layui.$,
					upload = layui.upload,
					layer = layui.layer,
					device = layui.device();

				var laynoupload = $("#laynoupload").val(); //1、选完不上传
				//选完不上传，url暂未用到，只是需要其样式

				if (laynoupload == 1) {
					var layfiletype = $("#layfiletype").val();
					//上传文件类型
					if (layfiletype == 2) {
						var layaccept = 'file',
							layexts = 'doc|docx|rar|zip|pdf';
					} else {
						var layaccept = 'images',
							layexts = 'jpg|png|gif|bmp|jpeg';
					}
					upload.render({
						elem: '.noupload',
						auto: false,
						bindAction: '#test9' //触发上传的对象，暂未用到
							,
						accept: layaccept,
						exts: layexts,
						field: 'sl',
						choose: function(obj) {
							if (this.imgid) {
								//预读本地文件示例，不支持ie8/9
								var imgid = null,
									parentid = null;
								if (this.imgid) {
									imgid = this.imgid;
								}
								if (this.parentid) {
									parentid = this.parentid;
								}
								obj.preview(function(index, file, result) {
									if (parentid && $('#' + parentid).length > 0) {
										$('#' + parentid).removeClass('none');
										$('#' + imgid).attr('src', result);
									} else if (imgid && $('#' + imgid).length > 0) {
										$('#' + imgid).removeClass('none');
										$('#' + imgid).attr('src', result); //图片链接（base64）
									}

								});
							}
						}
					});
					upload.render({
						elem: '.noupload2',
						auto: false,
						bindAction: '#test9', //触发上传的对象，暂未用到
						accept: layaccept,
						exts: layexts,
						field: 'hf',
						choose: function(obj) {
							if (this.imgid) {
								//预读本地文件示例，不支持ie8/9
								var imgid = null,
									parentid = null;
								if (this.imgid) {
									imgid = this.imgid;
								}
								if (this.parentid) {
									parentid = this.parentid;
								}
								obj.preview(function(index, file, result) {
									if (parentid && $('#' + parentid).length > 0) {
										$('#' + parentid).removeClass('none');
										$('#' + imgid).attr('src', result);
									} else if (imgid && $('#' + imgid).length > 0) {
										$('#' + imgid).removeClass('none');
										$('#' + imgid).attr('src', result); //图片链接（base64）
									}

								});
							}
						}
					});
					upload.render({
						elem: '.noupload3',
						auto: false,
						bindAction: '#test9', //触发上传的对象，暂未用到
						accept: layaccept,
						exts: layexts,
						field: 'wapsl',
						choose: function(obj) {
							if (this.imgid) {
								//预读本地文件示例，不支持ie8/9
								var imgid = null,
									parentid = null;
								if (this.imgid) {
									imgid = this.imgid;
								}
								if (this.parentid) {
									parentid = this.parentid;
								}
								obj.preview(function(index, file, result) {
									if (parentid && $('#' + parentid).length > 0) {
										$('#' + parentid).removeClass('none');
										$('#' + imgid).attr('src', result);
									} else if (imgid && $('#' + imgid).length > 0) {
										$('#' + imgid).removeClass('none');
										$('#' + imgid).attr('src', result); //图片链接（base64）
									}

								});
							}
						}
					});
					upload.render({
						elem: '.noupload4',
						auto: false,
						bindAction: '#test9', //触发上传的对象，暂未用到
						accept: layaccept,
						exts: layexts,
						field: 'waphf',
						choose: function(obj) {
							console.info(this.imgid);
							if (this.imgid) {
								//预读本地文件示例，不支持ie8/9
								var imgid = null,
									parentid = null;
								if (this.imgid) {
									imgid = this.imgid;
								}
								if (this.parentid) {
									parentid = this.parentid;
								}
								obj.preview(function(index, file, result) {
									if (parentid && $('#' + parentid).length > 0) {
										$('#' + parentid).removeClass('none');
										$('#' + imgid).attr('src', result);
									} else if (imgid && $('#' + imgid).length > 0) {
										$('#' + imgid).removeClass('none');
										$('#' + imgid).attr('src', result); //图片链接（base64）
									}

								});
							}
						}
					});
				}

			});
		<?php echo '</script'; ?>
>
	</body>
</html>
<?php }} ?>
