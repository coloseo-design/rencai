<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-06 16:41:03
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_concheck_config.htm" */ ?>
<?php /*%%SmartyHeaderCode:505762c54a9f3a9815-87681271%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '15df6f3f949990e948744f068b79b157a7bc09d9' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_concheck_config.htm',
      1 => 1645367048,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '505762c54a9f3a9815-87681271',
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
  'unifunc' => 'content_62c54a9f3df383_74670626',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c54a9f3df383_74670626')) {function content_62c54a9f3df383_74670626($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
" rel="stylesheet">
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
	<style type="text/css">
		.layui-form-radio {
			margin-top: 0;
		}
	</style>
	<body class="body_ifm">
		<div class="infoboxp">

			<div class="tty-tishi_top">
				<div class="tag_box">
					<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
					<form id="concheckform" class="layui-form" action="index.php?m=admin_concheck_config&c=save" method="post" onsubmit="return ckconcheck()"
					 enctype="multipart/form-data" target="supportiframe">
						<table width="100%" class="table_form">
							<tr>
								<th width="160">内容检测：功能待开发</th>
								<td>
									<!--<div class="layui-input-block">
										<input type="checkbox" name="sy_concheck_open" lay-skin="switch" lay-text="开放|关闭" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_concheck_open']=="1") {?> checked <?php }?> />
									</div>-->
								</td>
							</tr>
							
							<!--<tr class="admin_table_trbg">
								<th width="160">App Key：</th>
								<td>
									<input name="sy_concheck_appkey" id="sy_concheck_appkey" autocomplete="off" class="tty_input t_w480" type="text" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_concheck_appkey'];?>
" size="60" maxlength="50" />
									<span class="admin_web_tip"><a href="https://www.wanxiangku" target="_blank">前往申请内容安全检测秘钥</a></span>
								</td>
							</tr>
							<tr class="admin_table_trbg">
								<th width="160">App Secret：</th>
								<td>
									<input name="sy_concheck_appsecret" id="sy_concheck_appsecret" autocomplete="off" class="tty_input" type="text" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_concheck_appsecret'];?>
" size="60" maxlength="50" />
								</td>
							</tr>
							<tr>
								<th width="150">剩余检测量：</th>
								<td>
									<input class="tty_input t_w160" type="text" id="rest_num" value="" readonly="readonly" size="10" />
								</td>
							</tr>
							
							<tr class="admin_table_trbg">
								<th width="160"></th>
								<td>
									<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
									<input class="layui-btn tty_sub" id="concheckconfig" type="submit" value="提交" />&nbsp;&nbsp;
									<input class="layui-btn tty_cz" type="reset" value="重置" />
								</td>
							</tr>-->
						</table>
					</form>
				</div>
			</div>
		</div>
		<?php echo '<script'; ?>
 type="text/javascript">
			var weburl = '<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
';
			layui.use(['layer', 'form'], function() {
				var layer = layui.layer,
					form = layui.form,
					$ = layui.$;
			});
			$(function(){
				var pytoken = $("#pytoken").val();
					$.post("index.php?m=admin_concheck_config&c=get_restnum",{pytoken : pytoken},function(data){
						if(data){
							var res = eval('('+data+')');
							$("#rest_num").val(res.num);
						}
					});
			})
			
			function ckconcheck() {
				var sy_concheck_open = $("input[name=sy_concheck_open]").is(":checked") ? 1 : 2,
					sy_concheck_appkey = $("#sy_concheck_appkey").val(),
					sy_concheck_appsecret = $("#sy_concheck_appsecret").val();
				if (sy_concheck_open == 1) {
					
					if (sy_concheck_appkey == '') {
						parent.layer.msg("请填写appkey！", 2, 8);
						return false;
					}
					if (sy_concheck_appsecret == '') {
						parent.layer.msg("请填写appsecret！", 2, 8);
						return false;
					}
				}
				loadlayer();
			}
		<?php echo '</script'; ?>
>
		
	</body>
</html>
<?php }} ?>
