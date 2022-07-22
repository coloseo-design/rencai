<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:40:18
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_industry.htm" */ ?>
<?php /*%%SmartyHeaderCode:3203362d902e28b74c1-82389910%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8e4f5f0e2ba9956bcb2bd552e37f1ba37832e84e' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_industry.htm',
      1 => 1634883866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3203362d902e28b74c1-82389910',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
    'list' => 0,
    'key' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d902e29732a2_56148620',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d902e29732a2_56148620')) {function content_62d902e29732a2_56148620($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
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
 src="js/admin_public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="js/show_pub.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
		<title>后台管理</title>
	</head>
	<?php echo '<script'; ?>
 type="text/javascript">
		$(document).ready(function() {
			$(".imghide").hover(function() {
				$(this).find('.class_xg').show();
			}, function() {
				$(this).find('.class_xg').hide();
			});
		})
	<?php echo '</script'; ?>
>
	<link href="images/reset.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
	<link href="images/system.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
	<link href="images/table_form.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />

	<body class="body_ifm">
		<span id="temp"></span>
		<div class="infoboxp">
			<div class="tty-tishi_top">
			<div class="admin_new_search_box">
				<a href="javascript:void(0)" onClick="add_class('添加类别','450','250','#houtai_div','')" class="admin_new_cz_tj" style="margin-left:0px;">+
					添加类别</a>
			</div>
			<div class="clear"></div>
			</div>
			
			<div class="tty_table-bom">
			<div class="table-list">
				<div class="admin_table_border">
					<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
					<form action="index.php?m=admin_industry&c=del" method="post" target="supportiframe" id='myform'>
						<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
						<table width="100%" id="table_industry">
							<thead>
								<tr class="admin_table_top">
									<th width="50"><label for="chkall"> <input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' /></label></th>
									<th width="60">行业编号</th>
									<th align="left">行业名称<span class="clickup">(点击修改)</span></th>
									<th>排序（越大越靠前）</th>
									<th width="180" class="admin_table_th_bg">操作</th>
								</tr>
							</thead>
							<tbody>
								<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>

								<tr align="center" <?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg"<?php }?> id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
									<td width="50"><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name='del[]' onclick='unselectall()' rel="del_chk" /></td>
									<td class="ud"><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</td>
									<td class="ud imghide" align="left">
										<span onClick="checkname('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" id="name<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</span>
										<input class="input-text hidden" type="text" id="inputname<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
"
										 onBlur="subname('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','index.php?m=admin_industry&c=ajax');">
										<img class="" src="images/xg.png" onClick="checkname('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" style="padding-left:5px;cursor:pointer;" />
									</td>
									<td class="imghide"><span onClick="checksort('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" id="sort<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['v']->value['sort'];?>
</span>
										<input class="input-text hidden citysort" type="text" id="input<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" size="10" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['sort'];?>
"
										 onBlur="subsort('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','index.php?m=admin_industry&c=ajax');">
										<img class="" src="images/xg.png" onClick="checksort('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" style="padding-left:5px;cursor:pointer;" />
									</td>
									<td class="ud">

										<a href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=admin_industry&c=del&delid=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');"
										 class="admin_new_c_bth admin_new_c_bth_sc">删除</a></td>
								</tr>

								<?php } ?>
								<tr>
									<td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
									<td colspan="4">
										<label for="chkAll2">全选</label>&nbsp;
										<input class="admin_button" type="button" name="delsub" value="删除所选" onclick="return really('del[]')" /></td>
								</tr>
							</tbody>
						</table>
					</form>
				</div>
			</div>
			</div>
		</div>
		<div id="houtai_div" style=" display:none;margin-top: 10px;">
			<div class="admin_mt10">
				<table cellspacing='1' cellpadding='1' class="admin_examine_table">
					<tbody>
						<tr>
							<th width="90" class="t_fr">类别名称：</th>
							<td><textarea id='position' class="add_class_textarea"></textarea></td>
						</tr>
						<tr class="ui_td_11">
							<th width="90"></th>
							<td>
								<span class="admin_web_tip" style="padding-top: 0;">说明：可以添加多条分类（请按回车键换行，一行一个）</span>
							</td>
						</tr>
						<tr class="ui_td_11">
							<td class="ui_content_wrap" align="center" style="border-bottom:none" colspan='2'>
								<input class="admin_examine_bth" type="button" name="add" value=" 添加 " onClick="save_dclass('index.php?m=admin_industry&c=add')" /></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>
<?php }} ?>
