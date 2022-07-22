<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:28:37
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_model_config_nav.htm" */ ?>
<?php /*%%SmartyHeaderCode:2677862d9002519c647-51136216%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '777c865b4a8e652d964c81cb4ba0ff4e7ad30135' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_model_config_nav.htm',
      1 => 1634883865,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2677862d9002519c647-51136216',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'type' => 0,
    'v' => 0,
    'types' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d90025227b44_00200133',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d90025227b44_00200133')) {function content_62d90025227b44_00200133($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
		<title>后台管理</title>
		<style>
			.table_form th{
  width: 150px !important;
}
.table_form td{
  width: 750px !important;
}
</style>
	</head>
	<body class="body_ifm">
		<div class="admin_table_border">
			<form class="layui-form">
				<table width="100%" class="table_form" style="background:#fff;">
					<tr>
						<th width="120">导航类别：</th>
						<td>
							<div class="layui-input-inline">
								<select name="nid" lay-filter="nid">
									<option value="">请选择</option>
									<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['type']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
									<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['types']->value['nid']&&$_smarty_tpl->tpl_vars['v']->value['id']==$_smarty_tpl->tpl_vars['types']->value['nid']) {?> selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['typename'];?>
</option>
									<?php } ?>
								</select>
							</div>
						</td>
					</tr>
					<tr class="admin_table_trbg">
						<th>导航名称：</th>
						<td>
							<input class="layui-input t_w480" type="text" name="name" id="name" size="40" value="<?php echo $_smarty_tpl->tpl_vars['types']->value['name'];?>
" />
						</td>
					</tr>
					<tr>
						<th>排　　序：</th>
						<td><input class="layui-input t_w480" type="text" name="sort" size="5" id="sort" value="<?php echo $_smarty_tpl->tpl_vars['types']->value['sort'];?>
" /></td>
					</tr>
					<tr class="admin_table_trbg">
						<th>弹出窗口：</th>
						<td>
							<div class="layui-input-block">
								<input name="eject" value="1" title="新窗口" <?php if ($_smarty_tpl->tpl_vars['types']->value['eject']=="1") {?> checked <?php }?> type="radio" />
								<input name="eject" value="0" title="原窗口" <?php if ($_smarty_tpl->tpl_vars['types']->value['eject']=="0") {?> checked <?php }?> type="radio" />
							</div>
						</td>
					</tr>
					<tr>
						<th>状　　态：</th>
						<td>
							<div class="layui-input-block">
								<input name="model" value="hot" title="热" <?php if ($_smarty_tpl->tpl_vars['types']->value['model']=="hot") {?> checked <?php }?> type="radio" />
								<input name="model" value="new" title="新" <?php if ($_smarty_tpl->tpl_vars['types']->value['model']=="new") {?> checked <?php }?> type="radio" />
								<input name="model" value="" title="无" <?php if ($_smarty_tpl->tpl_vars['types']->value['model']=='') {?> checked <?php }?> type="radio" />
							</div>
						</td>
					</tr>
					<tr>
						<th>加　　粗：</th>
						<td>
							<div class="layui-input-block">
								<input name="bold" value="1" title="是" <?php if ($_smarty_tpl->tpl_vars['types']->value['bold']=="1") {?> checked <?php }?> type="radio" />
								<input name="bold" value="0" title="否" <?php if ($_smarty_tpl->tpl_vars['types']->value['bold']=="0") {?> checked <?php }?> type="radio" />
							</div>
						</td>
					</tr>
					<tr>
						<th>显　　示：</th>
						<td>
							<div class="layui-input-block">
								<input name="display" value="1" title="是" <?php if ($_smarty_tpl->tpl_vars['types']->value['display']=="1") {?> checked <?php }?> type="radio" />
								<input name="display" value="0" title="否" <?php if ($_smarty_tpl->tpl_vars['types']->value['display']=="0") {?> checked <?php }?> type="radio" />
							</div>
						</td>
					</tr>
					<tr class="admin_table_trbg">
						<th>&nbsp;</th>
						<td align="left">
							<input class="layui-btn layui-btn-normal" type="button" onclick="setsave('<?php echo $_smarty_tpl->tpl_vars['types']->value['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['types']->value['config'];?>
');" name="update" value="&nbsp;保存&nbsp;" />
						</td>
					</tr>
				</table>
			</form>
		</div>

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
>
			layui.use(['layer', 'form'], function() {});

			function setsave(id, pytoken, config) {
				var nid = $('select[name=nid]').val();
				var name = $('#name').val();
				var sort = $('#sort').val();
				var eject = $("input[name='eject']:checked").val();
				var model = $("input[name='model']:checked").val();
				var bold = $("input[name='bold']:checked").val();
				var display = $("input[name='display']:checked").val();
				if (name == "") {
					layer.msg('请填写导航名称！', 2, 8);
					return false;
				}
				$.post('index.php?m=model_config&c=setnav', {
					nid: nid,
					name: name,
					sort: sort,
					eject: eject,
					model: model,
					bold: bold,
					display: display,
					id: id,
					config: config,
					pytoken: pytoken
				}, function(data) {
					var data = eval('(' + data + ')');

					parent.layer.msg(data.msg, Number(data.tm), Number(data.st), function() {
						parent.layer.closeAll();
					});

					// parent.layer.msg(data.msg,{
					//   time : 1500,
					//   icon : 1, //1 打勾，2打叉，5伤心，6笑脸，7感叹号
					// }, function (){
					//   parent.layer.closeAll();
					// });
					return false;
				});
			}
		<?php echo '</script'; ?>
>
	</body>
</html>
<?php }} ?>
