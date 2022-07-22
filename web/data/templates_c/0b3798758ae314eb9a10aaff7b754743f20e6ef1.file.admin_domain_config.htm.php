<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:30:22
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_domain_config.htm" */ ?>
<?php /*%%SmartyHeaderCode:152662d9008ec38bc3-60618205%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0b3798758ae314eb9a10aaff7b754743f20e6ef1' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_domain_config.htm',
      1 => 1645272363,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '152662d9008ec38bc3-60618205',
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
  'unifunc' => 'content_62d9008ec97f40_88348140',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d9008ec97f40_88348140')) {function content_62d9008ec97f40_88348140($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
 src="../js/jquery-1.8.0.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="js/admin_public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/javascript"><?php echo '</script'; ?>
>
		<link href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/css/layui.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" />
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/layui.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/phpyun_layer.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
		<title>后台管理</title>
	</head>
	<body class="body_ifm">
		<div class="infoboxp">
			<div class="tty-tishi_top">
			<div class="admin_new_tip">
				<a href="javascript:;" class="admin_new_tip_close"></a>
				<a href="javascript:;" class="admin_new_tip_open" style="display:none;"></a>
				<div class="admin_new_tit"><i class="admin_new_tit_icon"></i>操作提示</div>
				<div class="admin_new_tip_list_cont">
					<div class="admin_new_tip_list">分站列表，主要显示已添加成功的分站列表。管理员通过分站列表轻松查询到网站开通多少家分站。同时根据运营情况也可以自由调整设置。</div>
				</div>
			</div>
			<div class="clear"></div>
			
				<div class="tag_box">
					<div>
						<form class="layui-form">
							<table width="100%" class="table_form">
								<tr class="admin_table_trbg">
									<th width="160" class="t_fr">开启分站：</th>
									<td>
										<div class="layui-input-block t_w480">
											<input name="sy_web_site" lay-filter="sy_web_site" lay-skin="switch" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_web_site']=="1") {?>
											 checked<?php }?> lay-text="开启|关闭" type="checkbox">
										</div>
										<span class="admin_web_tip">
											提示：开启多城市并且绑定域名不支持2级目录，本地测试如 http://localhost/weitenet 请解析测试域名
										</span>
									</td>
								</tr>

								<tr class="admin_table_trbg">
									<th width="160" class="t_fr">分站根据IP自动跳转：</th>
									<td>
										<div class="layui-input-block">
											<input name="sy_gotocity" lay-filter="sy_gotocity" lay-skin="switch" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_gotocity']=="1") {?>
											 checked<?php }?> lay-text="开启|关闭" type="checkbox">
										</div>
									</td>
								</tr>
								<tr>
									<th width="160" class="t_fr">设定默认城市：</th>
									<td>
										<div class="layui-input-block t_w480">
											<input class="layui-input" type="text" name="sy_indexcity" id="sy_indexcity" size="40" maxlength="255" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_indexcity'];?>
" />
										</div>
										<span class="admin_web_tip">提示：开启分站后默认城市 如：全国、总站</span></td>

								</tr>
								<tr class="admin_table_trbg">
									<th width="160" class="t_fr">一级域名：</th>
									<td>
										<div class="layui-input-block t_w480">
											<input class="layui-input" type="text" name="sy_onedomain" id="sy_onedomain" size="40" maxlength="255" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_onedomain'];?>
" />
										</div>
										<span class="admin_web_tip">提示：如果默认域名为二级域名，则请填写一级域名</span>
									</td>

								</tr>

								<tr>
									<th width="160" class="t_fr">默认域名：</th>
									<td>
										<div class="layui-input-block t_w480">
										<input class="layui-input" type="text" name="sy_indexdomain" id="sy_indexdomain" size="40" maxlength="255" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_indexdomain'];?>
" />
										</div>
										<span class="admin_web_tip">提示：默认城市对应的域名 如全站对应域名	http://www.weitenet.com 而不是 beijing.weitenet.com</span>
									</td>

								</tr>
								<tr>
									<th style="border-bottom:none;">&nbsp;</th>
									<td align="left" style="border-bottom:none;">
										<input class="tty_sub" id="config" type="button" name="config" value="提交">
										<input class="tty_cz" type="reset" value="重置" />
										<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
									</td>
								</tr>
							</table>
						</form>
					</div>

				</div>
			</div>
			<?php echo '<script'; ?>
>
				$(function() {
					$("#config").click(function() {
						loadlayer();
						$.post("index.php?m=admin_domain&c=savecf", {
							config: $("#config").val(),
							sy_indexcity: $("#sy_indexcity").val(),
							sy_gotocity: $("input[name=sy_gotocity]").is(":checked") ? 1 : 0,
							sy_onedomain: $("#sy_onedomain").val(),
							sy_indexdomain: $("#sy_indexdomain").val(),
							pytoken: $("#pytoken").val(),
							sy_web_site: $("input[name=sy_web_site]").is(":checked") ? 1 : 0
						}, function(data, textStatus) {
							parent.layer.closeAll('loading');
							config_msg(data);
						});
					});
				});

				layui.use(['form'], function() {});
			<?php echo '</script'; ?>
>
		</div>
	</body>
</html>
<?php }} ?>
