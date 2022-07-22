<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-08 16:22:39
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_resumetpl_add.htm" */ ?>
<?php /*%%SmartyHeaderCode:1104162c7e94f51d8c5-90335841%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8b5966fa93e90a845776367e23f668c15ef57708' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_resumetpl_add.htm',
      1 => 1634883865,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1104162c7e94f51d8c5-90335841',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c7e94f58bb04_28217252',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c7e94f58bb04_28217252')) {function content_62c7e94f58bb04_28217252($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
	<body class="body_ifm">
		<div id="subboxdiv" style="width:100%;height:100%;display:none;position:absolute;"></div>
		<div class="infoboxp">
			<div class="tty-tishi_top">


				<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
				<form action="index.php?m=admin_tpl&c=resumetplsave" method="post" class="layui-form" enctype="multipart/form-data"
				 target="supportiframe">
					<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
					<table width="100%" class="table_form">
						<tr>
							<th colspan="2" class="admin_bold_box">
								<div class="admin_bold">添加简历模板</div>
							</th>
						</tr>
						<tr class="admin_table_trbg">
							<th width="140" class="t_fr">模板名称：</th>
							<td>
								<input class="layui-input t_w480" type="text" name="name" id="sy_qqappid" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
" size="30" maxlength="255" />
								<span class="admin_web_tip">如：经典红色</span>
							</td>
						</tr>
						<tr>
							<th width="140">状态：</th>
							<td>
								<div class="layui-input-inline">
									<input lay-skin="switch" name="status_switch" lay-filter="status" lay-text="开启|关闭" <?php if ($_smarty_tpl->tpl_vars['row']->value['status']=="1") {?> checked <?php }?> type="checkbox" />
									<input type="hidden" name="status" id="status" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['status'];?>
" />
								</div>
							</td>
						</tr>
						<tr class="admin_table_trbg">
							<th width="140" class="t_fr">模板路径：</th>
							<td>
								<input class="layui-input t_w480" type="text" name="url" id="sy_qqappid" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['url'];?>
" size="30" maxlength="255" <?php if ($_smarty_tpl->tpl_vars['row']->value['url']) {?>readonly<?php }?>/> 
								<span class="admin_web_tip">如：default。注意：简历模板放在app/template/resume下面，不存在系统将自动建立</span>
							</td>
						</tr>
						<tr>
							<th width="140" class="t_fr"><?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
：</th>
							<td>
								<input class="layui-input t_w480" type="text" name="price" id="sy_qqappid" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['price'];?>
" size="30" maxlength="255" />
								<span class="admin_web_tip">如：100，0或空为免费</span>
							</td>
						</tr>
						<tr class="admin_table_trbg">
							<th width="140" class="t_fr">缩略图：</th>
							<td>
								<div class="admin_uppicbox" style="width: 238px; height: 315px;">
									<input type="hidden" id="laynoupload" value="1">
								
									<div class="admin_uppicimg">
										<img id="imgicon" src="<?php echo $_smarty_tpl->tpl_vars['row']->value['pic_n'];?>
" width="238" height="315" <?php if (!$_smarty_tpl->tpl_vars['row']->value['pic']) {?>class="none"<?php }?>>
									</div>
								
									<span>
										<button type="button" class="noupload adminupbtn" lay-data="{imgid: 'imgicon'}">重新上传</button>	
										<input type="hidden" name="pic" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['pic'];?>
" />
									</span>
								</div>
								

							</td> 
						</tr> 
						<tr>
							<th width="140" class="t_fr"> 针对用户：</th>
							<td>
								<input class="layui-input t_w480" type="text" name="service_uid" id="service_uid" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['service_uid'];?>
" size="30" maxlength="255" />
								<span class="admin_web_tip">可以直接填写用户ID，多个以（半角逗号,）隔开</span>
							</td>
						</tr>
						<tr class="admin_table_trbg">
							<th class="t_fr">&nbsp;</th>
							<td align="left">
								<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
" name="id">
								<input class="tty_sub" id="qqconfig" type="submit" name="msgconfig" value="提交" />&nbsp;&nbsp;
								<input class="tty_cz" type="reset" value="重置" />
							</td>
						</tr>

					</table>
				</form>
			</div>
			<?php echo '<script'; ?>
 type="text/javascript">
				var weburl = '<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
';
				layui.use(['form'], function() {
					var form = layui.form,
						$ = layui.$;

					form.on('switch(status)', function(data) {
						var v = this.checked ? 1 : 0;
						$("#status").val(v);
					});
				});
			<?php echo '</script'; ?>
>
			<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui.upload.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type='text/javascript'><?php echo '</script'; ?>
>
	</body>
</html>
<?php }} ?>
