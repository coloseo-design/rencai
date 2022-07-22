<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-06 16:40:28
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_xml.htm" */ ?>
<?php /*%%SmartyHeaderCode:2145862c54a7c5018d3-86578238%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5c32e62170b527c788b9b8ec0e400c00f47989ee' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_xml.htm',
      1 => 1634883866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2145862c54a7c5018d3-86578238',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c54a7c5326e2_06673242',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c54a7c5326e2_06673242')) {function content_62c54a7c5326e2_06673242($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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

		<title></title>
	</head>
	<body class="body_ifm">
		<div class="infoboxp">
			<div class="tty-tishi_top">
				<div class="admin_new_tip">
					<a href="javascript:;" class="admin_new_tip_close"></a>
					<a href="javascript:;" class="admin_new_tip_open" style="display:none;"></a>
					<div class="admin_new_tit"><i class="admin_new_tit_icon"></i>操作提示</div>
					<div class="admin_new_tip_list_cont">
						<div class="admin_new_tip_list">生成请确保目录有可写权限，否则无法生成。</div>
						<div class="admin_new_tip_list">添加数量时，请勿填写太大数值</div>
					</div>
				</div>
				<div class="clear"></div>

				<form class="layui-form">
					<table width="100%" class="table_form ">
						<tr>
							<th width="120">数据类型：</th>
							<td>
								<div class="layui-input-inline t_w480">
									<select name="" id="datetype_val">
										<option value="sitemap">全部</option>
										<option value="company">企业</option>
										<option value="job">职位</option>
										<option value="resume">简历</option>
										<option value="ask">问答</option>
										<option value="news">新闻</option>
									</select>
								</div>


							</td>
						</tr>
						<tr class="admin_table_trbg">
							<th width="120">数据排序：</th>
							<td>
								<div class="layui-input-inline t_w480">
									<select name="" id="order_val">
										<option value="uptime">更新时间</option>
										<option value="addtime">添加时间</option>
									</select>
								</div>
							</td>
						</tr>
						<tr>
							<th width="120">更新频率：</th>
							<td>
								<div class="layui-input-inline t_w480">
									<select name="" id="frequency_val">
										<option value="always">总是</option>
										<option value="hourly">每小时</option>
										<option value="daily">每天</option>
										<option value="weekly">每周</option>
										<option value="monthly">每月</option>
										<option value="yearly">每年</option>
										<option value="never">从不</option>
									</select>

								</div>
							</td>
						</tr>
						<tr class="admin_table_trbg">
							<th width="120">获取数量：</th>
							<td>
								<div class="layui-input-block">
									<div class="layui-input-inline t_w480">
										<input type="text" id="limit" lay-verify="required" placeholder="请输入获取数量" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"
										 value="100" size="30" autocomplete="off" class="layui-input"> 
									</div>
									<span class="admin_web_tip">请谨慎填写数量</span>
								</div>
							</td>
						</tr>
						<tr>
							<th width="120">文件名称：</th>
							<td>
								<div class="layui-input-block">
									<div class="layui-input-inline t_w480">
										<input type="text" id="xfilename" lay-verify="required" placeholder="请输入文件名称" value="sitemap" size="30"
										 autocomplete="off" class="layui-input">
									</div>
									<span class="admin_web_tip">如：sitemap，请勿带后缀</span>
								</div>
							</td>
						</tr>
						<tr class="admin_table_trbg">
							<th width="120"></th>
							<td>
								<input class="layui-btn tty_sub" type="button" id="archive" value="更新内容" />&nbsp;&nbsp;
							</td>
						</tr>
					</table>
					<input type="hidden" id="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
				</form>
			</div>
		</div>
		<?php echo '<script'; ?>
 language="javascript">
			layui.use(['layer', 'form', 'element'], function() {
				var layer = layui.layer,
					form = layui.form,
					element = layui.element,
					$ = layui.$;
			}); //end layui.use()

			$(document).ready(function() {
				dchange();
				$("#archive").click(function() {
					var pytoken = $("#pytoken").val();
					var datetype = $("#datetype_val").val();
					var order = $("#order_val").val();
					var limit = $.trim($("#limit").val());
					var filename = $("#xfilename").val();
					var frequency = $("#frequency_val").val();
					if (limit < 1 || limit == '') {
						parent.layer.msg('请输入获取数量', 2, 8);
						return false;
					}
					parent.layer.load('正在生成文件……', 0);
					$.post("index.php?m=admin_xml&c=archive", {
						type: datetype,
						order: order,
						limit: limit,
						name: filename,
						frequency: frequency,
						pytoken: pytoken
					}, function(data) {
						parent.layer.closeAll('loading');
						var data = eval('(' + data + ')');
						parent.layer.msg(data.msg, Number(data.tm), Number(data.st), function() {
							location.reload();
						});
						return false;
					})
				})
			})
			
			function dchange(){
				var datetype=$("#datetype").val();
				$("#filename").val(datetype);
			}
		<?php echo '</script'; ?>
>
	</body>
</html>
<?php }} ?>
