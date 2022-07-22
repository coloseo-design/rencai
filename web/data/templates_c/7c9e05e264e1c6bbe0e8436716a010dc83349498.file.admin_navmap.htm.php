<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-08 16:19:47
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_navmap.htm" */ ?>
<?php /*%%SmartyHeaderCode:912262c7e8a382ccc4-62159444%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7c9e05e264e1c6bbe0e8436716a010dc83349498' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_navmap.htm',
      1 => 1634883865,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '912262c7e8a382ccc4-62159444',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'nav' => 0,
    'key' => 0,
    'v' => 0,
    'total' => 0,
    'pagenum' => 0,
    'pages' => 0,
    'pagenav' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c7e8a38ca6e4_04091165',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c7e8a38ca6e4_04091165')) {function content_62c7e8a38ca6e4_04091165($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
				<div class="admin_new_search_box">
					<form action="index.php" name="myform" method="get">
						<input name="m" value="navmap" type="hidden" />
						<div class="admin_new_search_name">搜索类型：</div>
						<div class="admin_Filter_text formselect" did='dtype'>
							<input type="button" value="<?php if ($_GET['type']=='2') {?>链接地址<?php } else { ?>网站名称<?php }?>" class="admin_Filter_but"
							 id="btype">
							<input type="hidden" id='type' value="<?php echo $_GET['type'];?>
" name='type'>
							<div class="admin_Filter_text_box" style="display:none" id='dtype'>
								<ul>
									<li><a href="javascript:void(0)" onClick="formselect('1','type','网站名称')">网站名称</a></li>
									<li><a href="javascript:void(0)" onClick="formselect('2','type','链接地址')">链接地址</a></li>
								</ul>
							</div>
						</div>
						<input class="admin_Filter_search" type="text" name="keyword" size="25" style="float:left" placeholder="请输入你要搜索的关键字">
						<input class="admin_Filter_bth" type="submit" name="news_search" value="搜索" />
						<a href="javascript:void(0)" onclick="$('.admin_screenlist_box').toggle();" class="admin_new_search_gj">高级搜索</a>
						<a href="index.php?m=navmap&c=add" class="admin_new_cz_tj">添加网站地图</a>
					</form>



					<?php echo $_smarty_tpl->getSubTemplate ("admin/admin_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

				</div>
				<div class="clear"></div>
			</div>


			<div class="tty_table-bom">
				<div class="table-list">
					<div class="admin_table_border">
						<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
						<form action="index.php" name="myform" id='myform' method="get" target="supportiframe">
							<input name="m" value="navmap" type="hidden" />
							<input name="c" value="del" type="hidden" />
							<table width="100%">
								<thead>
									<tr class="admin_table_top">
										<th><label for="chkall"><input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' /></label></th>
										<th>编号</th>
										<th align="left">名称</th>
										<th align="left">类别</th>
										<th align="left">连接地址</th>
										<th align="left">类型</th>
										<th>排序</th>
										<th>弹出窗口</th>
										<th>显示</th>
										<th width="140">操作</th>
									</tr>
								</thead>
								<tbody>
									<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['nav']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
									<tr align="center" <?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg"<?php }?> id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
										<td><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name='del[]' onclick='unselectall()' rel="del_chk" /></td>
										<td align="left" class="td1" style="text-align:center;"><span><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</span></td>
										<td class="od" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</td>
										<td class="ud" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['typename'];?>
</td>
										<td class="gd" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['url'];?>
</td>
										<td class="td" align="left"><?php if ($_smarty_tpl->tpl_vars['v']->value['type']=='1') {?>站内链接<?php } else { ?>原链接<?php }?></td>
										<td class="td"><?php echo $_smarty_tpl->tpl_vars['v']->value['sort'];?>
</td>
										<td class="td" id="eject<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
											<?php if ($_smarty_tpl->tpl_vars['v']->value['eject']=='1') {?>
											<a href="javascript:void(0);" onClick="tanchu('index.php?m=navmap&c=nav_xianshi','<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','0','eject');">新窗口</a>
											<?php } else { ?>
											<a href="javascript:void(0);" onClick="tanchu('index.php?m=navmap&c=nav_xianshi','<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','1','eject');">原窗口</a>
											<?php }?>
										</td>
										<td class="td" id="display<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
											<?php if ($_smarty_tpl->tpl_vars['v']->value['display']=='1') {?>
											<a href="javascript:void(0);" onClick="rec_up('index.php?m=navmap&c=nav_xianshi','<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','0','display');"><img
												 src="../config/ajax_img/doneico.gif"></a>
											<?php } else { ?>
											<a href="javascript:void(0);" onClick="rec_up('index.php?m=navmap&c=nav_xianshi','<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','1','display');"><img
												 src="../config/ajax_img/errorico.gif"></a>
											<?php }?>
										</td>


										<td><a href="index.php?m=navmap&c=add&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="admin_new_c_bth">修改</a>
											<a href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=navmap&c=del&del=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');"
											 class="admin_new_c_bth admin_new_c_bth_sc">删除</a></td>
									</tr>
									<?php } ?>
									<tr>
										<td align="center"><label for="chkall2"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></label></td>
										<td colspan="9"><label for="chkAll2">全选</label>
											<input class="admin_button" type="button" name="delsub" value="删除所选" onclick="return really('del[]')" /></td>
									</tr>
									<?php if ($_smarty_tpl->tpl_vars['total']->value>$_smarty_tpl->tpl_vars['config']->value['sy_listnum']) {?>
									<tr>
										<?php if ($_smarty_tpl->tpl_vars['pagenum']->value==1) {?>
										<td colspan="3"> 从 1 到 <?php echo $_smarty_tpl->tpl_vars['config']->value['sy_listnum'];?>
 ，总共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</td>
										<?php } elseif ($_smarty_tpl->tpl_vars['pagenum']->value>1&&$_smarty_tpl->tpl_vars['pagenum']->value<$_smarty_tpl->tpl_vars['pages']->value) {?> <td colspan="3"> 从 <?php echo ($_smarty_tpl->tpl_vars['pagenum']->value-1)*$_smarty_tpl->tpl_vars['config']->value['sy_listnum']+1;?>
 到 <?php echo $_smarty_tpl->tpl_vars['pagenum']->value*$_smarty_tpl->tpl_vars['config']->value['sy_listnum'];?>
 ，总共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</td>
											<?php } elseif ($_smarty_tpl->tpl_vars['pagenum']->value==$_smarty_tpl->tpl_vars['pages']->value) {?>
											<td colspan="3"> 从 <?php echo ($_smarty_tpl->tpl_vars['pagenum']->value-1)*$_smarty_tpl->tpl_vars['config']->value['sy_listnum']+1;?>
 到 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 ，总共
												<?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</td>
											<?php }?>
											<td colspan="7" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</td>
									</tr>
									<?php }?>
								</tbody>
							</table>
							<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php echo '<script'; ?>
>
			function tanchu(url, id, rec, type) {
				var pytoken = $("#pytoken").val();
				$.get(url + "&id=" + id + "&rec=" + rec + "&type=" + type + "&pytoken=" + pytoken, function(data) {
					if (data == 1) {
						if (rec == "1") {
							$("#" + type + id).html("<a href=\"javascript:void(0);\" onClick=\"tanchu('" + url + "','" + id + "','0','" +
								type + "');\">新窗口</a>");
						} else {
							$("#" + type + id).html("<a href=\"javascript:void(0);\" onClick=\"tanchu('" + url + "','" + id + "','1','" +
								type + "');\">原窗口</a>");
						}
					}
				});
			}
		<?php echo '</script'; ?>
>
	</body>
</html>
<?php }} ?>
