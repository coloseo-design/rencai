<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-08 16:17:12
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_hrclass.htm" */ ?>
<?php /*%%SmartyHeaderCode:1771262c7e80880e677-25734789%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3a2154486299c8593dffee21f877ebc3bf10a081' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_hrclass.htm',
      1 => 1634883865,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1771262c7e80880e677-25734789',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'rows' => 0,
    'key' => 0,
    'v' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c7e808876060_09000678',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c7e808876060_09000678')) {function content_62c7e808876060_09000678($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
>
			function checked_name(){
	var name=$.trim($("#name").val()); 
	if(name==''){ 
		parent.layer.msg('文档类别名称不能为空！', 2, 8);
		return false;
	}
}
<?php echo '</script'; ?>
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
					<div class="admin_new_tip_list">工具箱类别：按企业HR人力资源类别进行分类，如考勤、请假和行政等分类。多参考国内知名网站进行设置。</div>
				</div>
			</div>
			<div class="clear"></div>
			<div class="admin_new_search_box">
				<a href="index.php?m=hrclass&c=add" class="admin_new_cz_tj">+ 添加类别</a>
			</div>
			<div class="clear"></div>
		</div>

		<div class="tty_table-bom">
			<div class="table-list">
				<div class="admin_table_border">
					<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
					<form action="index.php?m=hrclass&c=del" name="myform" method="post" id='myform' target="supportiframe">
						<input type="hidden" name="m" value="hrclass">
						<input type="hidden" name="c" value="del">
						<table width="100%">
							<thead>
								<tr class="admin_table_top">
									<th width="60"><label for="chkall"><input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' /></label></th>
									<th width="120">编号</th>
									<th align="left">名称</th>
									<th align="center">缩略图</th>
									<th width="140" class="admin_table_th_bg">操作</th>
								</tr>
							</thead>
							<tbody>
								<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
								<tr align="center" <?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg"<?php }?> id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
									<td><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name='del[]' onclick='unselectall()' rel="del_chk" /></td>
									<td align="left" class="td1" style="text-align:center;"><span><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</span></td>
									<td class="od" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</td>
									<td class="od" align="center"><img src="<?php echo $_smarty_tpl->tpl_vars['v']->value['pic'];?>
" width="40" height="40"></td>
									<td><a href="index.php?m=hrclass&c=add&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="admin_new_c_bth admin_n_sc status">编辑</a>
										<a href="javascript:void(0);" onClick="layer_del('删除该类别同时也会删除该类别下所有工具文档？','index.php?m=hrclass&c=del&del=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')"
										 class="admin_new_c_bth admin_new_c_bth_sc">删除</a>
									</td>
								</tr>
								<?php } ?>
								<tr style="background:#f1f1f1;">
									<td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
									<td colspan="4">
										<label for="chkAll2">全选</label>&nbsp;
										<input class="admin_button" type="button" name="delsub" value="删除所选" onClick="return really('del[]')" /></td>
								</tr>
							</tbody>
						</table>
						<input type="hidden" name="pytoken" id="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
					</form>
				</div>
			</div>
		</div>
		</div>
		<style>
			.admin_new_c_bth {
				color: #999;
				font-size: 12px;
			}
		</style>
	</body>
</html>
<?php }} ?>
