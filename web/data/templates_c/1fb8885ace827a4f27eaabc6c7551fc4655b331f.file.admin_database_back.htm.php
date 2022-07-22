<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 16:10:02
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_database_back.htm" */ ?>
<?php /*%%SmartyHeaderCode:1134762d909dab73524-09407281%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1fb8885ace827a4f27eaabc6c7551fc4655b331f' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_database_back.htm',
      1 => 1634883865,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1134762d909dab73524-09407281',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'sqlarr' => 0,
    'v' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d909dabde2a5_20172820',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d909dabde2a5_20172820')) {function content_62d909dabde2a5_20172820($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
		<title>后台管理</title>
	</head>

	<body class="body_ifm">

		<div class="infoboxp">
			<div class="tty-tishi_top">
				<div class="tabs_info">
					<ul>
						<li><a href="index.php?m=database">备份数据</a></li>
						<li class="curr"><a href="index.php?m=database&c=backin">恢复数据</a></li>
						<li><a href="index.php?m=database&c=optimizing">优化数据</a></li>
						<li><a href="index.php?m=database&c=clearList">数据清理</a></li>
					</ul>
				</div>

				<div class="admin_new_tip">
					<a href="javascript:;" class="admin_new_tip_close"></a>
					<a href="javascript:;" class="admin_new_tip_open" style="display:none;"></a>
					<div class="admin_new_tit"><i class="admin_new_tit_icon"></i>操作提示</div>
					<div class="admin_new_tip_list_cont">
						<div class="admin_new_tip_list">该页面展示了网站数据信息，可对数据进行编辑修改操作。</div>
					</div>
				</div>

				<div class="clear"></div>
				
				<div class="table-list mt10">
					<div class="admin_table_border">

						<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>

						<table width="100%">
							<thead>
								<tr class="admin_table_top">
									<th align="left">文件名</th>
									<th align="left">时间</th>
									<th align="left">数据库名称</th>
									<th align="left" class="admin_table_th_bg">操作</th>
								</tr>
							</thead>
							<tbody>
								<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['sqlarr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
								<tr align="left">
									<td align="left" class="td1"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</td>
									<td class="ud" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['time'];?>
</td>
									<td class="od" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['dbname'];?>
</td>
									<td>
										<a href="javascript:void(0);" onclick="backin('index.php?m=database&c=backincheck&ver=<?php echo $_smarty_tpl->tpl_vars['v']->value['version'];?>
&mypath=<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
')"
										 class="admin_new_c_bth">导入</a>
										<a href="javascript:void(0)" onclick="layer_del('确定要删除？', 'index.php?m=database&c=del&sql=<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
');"
										 class="admin_new_c_bth admin_new_c_bth admin_new_c_bth_sc">删除</a>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">

		<?php echo '<script'; ?>
>
			function backin(url) {
				var pytoken = $('#pytoken').val();
				parent.layer.confirm("确定导入数据？", function() {
					parent.layer.closeAll();
					location.href = url + '&pytoken=' + pytoken;
				});
			}
		<?php echo '</script'; ?>
>
	</body>
</html>
<?php }} ?>
