<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-06 16:22:02
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_announcement_list.htm" */ ?>
<?php /*%%SmartyHeaderCode:1973762c5462a334cc3-33130739%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ebfae8a6b347a369a2bca690a02b2ab180af0980' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_announcement_list.htm',
      1 => 1634883865,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1973762c5462a334cc3-33130739',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
    'announcement' => 0,
    'key' => 0,
    'v' => 0,
    'Dname' => 0,
    'total' => 0,
    'pagenum' => 0,
    'pages' => 0,
    'pagenav' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c5462a3cb6f4_72851219',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c5462a3cb6f4_72851219')) {function content_62c5462a3cb6f4_72851219($_smarty_tpl) {?><?php if (!is_callable('smarty_function_searchurl')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.searchurl.php';
if (!is_callable('smarty_modifier_date_format')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\modifier.date_format.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
		<title>后台管理</title>
	</head>
	<body class="body_ifm">
		<div class="infoboxp">

			<div class="tty-tishi_top">
				<div class="admin_new_search_box">
					<form action="index.php" name="myform" method="get">
						<input name="m" value="admin_announcement" type="hidden" />
						<div class="admin_new_search_name">关键字：</div>
						<input class="admin_Filter_search" placeholder="输入你要搜索的关键字" type="text" name="keyword" size="25" style="float:left">
						<input class="admin_Filter_bth" type="submit" name="news_search" value="搜索" />
						<a href="javascript:void(0)" onclick="$('.admin_screenlist_box').toggle();" class="admin_new_search_gj">高级搜索</a>
						<a href="index.php?m=admin_announcement&c=add" class="admin_new_cz_tj">+ 添加公告</a>
					</form>
					<?php echo $_smarty_tpl->getSubTemplate ("admin/admin_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

				</div>
				<div class="clear"></div>
			</div>

			<div class="tty_table-bom">
				<div class="table-list">
					<div class="admin_table_border">
						<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
						<form action="index.php" name="myform" method="get" target="supportiframe" id='myform'>
							<input name="m" value="admin_announcement" type="hidden" />
							<input type="hidden" name="pytoken" id="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">

							<input name="c" value="del" type="hidden" />
							<table width="100%">
								<thead>
									<tr class="admin_table_top">
										<th style="width:20px;"><label for="chkall">
												<input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' />
											</label></th>

										<th width="60">
											<?php if ($_GET['t']=="id"&&$_GET['order']=="asc") {?>
											<a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'id','m'=>'admin_announcement','untype'=>'order,t'),$_smarty_tpl);?>
">编号<img src="images/sanj.jpg" /></a>
											<?php } else { ?>
											<a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'id','m'=>'admin_announcement','untype'=>'order,t'),$_smarty_tpl);?>
">编号<img src="images/sanj2.jpg" /></a>
											<?php }?>
										</th>
										<th align="left" width="40%">公告标题</th>
										<th>
											<?php if ($_GET['t']=="datetime"&&$_GET['order']=="asc") {?>
											<a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'datetime','m'=>'admin_announcement','untype'=>'order,t'),$_smarty_tpl);?>
">发布时间<img src="images/sanj.jpg" /></a>
											<?php } else { ?>
											<a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'datetime','m'=>'admin_announcement','untype'=>'order,t'),$_smarty_tpl);?>
">发布时间<img src="images/sanj2.jpg" /></a>
											<?php }?>
										</th>

                                        <th>开始时间</th>

										<th> <?php if ($_GET['t']=="endtime"&&$_GET['order']=="asc") {?>
											<a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'endtime','m'=>'admin_announcement','untype'=>'order,t'),$_smarty_tpl);?>
">结束时间<img src="images/sanj.jpg" /></a>
											<?php } else { ?>
											<a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'endtime','m'=>'admin_announcement','untype'=>'order,t'),$_smarty_tpl);?>
">结束时间<img src="images/sanj2.jpg" /></a>
											<?php }?>
										<th width="60">分站</th>
										<th class="admin_table_th_bg">操作</th>

										</th>
									</tr>
								</thead>
								<tbody>

									<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['announcement']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
									<tr align="center" <?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg"<?php }?> id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
										<td><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="check_all" name='del[]' onclick='unselectall()'
											 rel="del_chk" /></td>
										<td align="left" class="td1" style="text-align:center;"><span><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</span></td>
										<td class="od" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</td>
										<td class="td"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['datetime'],"%Y-%m-%d");?>
</td>

                                        <td class="td"><?php if ($_smarty_tpl->tpl_vars['v']->value['startime']==0) {?>永久显示<?php } else {
echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['startime'],"%Y-%m-%d");
}?></td>

										<td class="td"><?php if ($_smarty_tpl->tpl_vars['v']->value['endtime']==0) {?>永久显示<?php } else {
echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['endtime'],"%Y-%m-%d");
}?></td>
										<td>
											<div><?php if ($_smarty_tpl->tpl_vars['v']->value['did']>0) {
echo $_smarty_tpl->tpl_vars['Dname']->value[$_smarty_tpl->tpl_vars['v']->value['did']];
} elseif ($_smarty_tpl->tpl_vars['v']->value['did']==-1) {?>全站<?php } else { ?>主站<?php }?></div>
											<div><a href="javascript:;" onclick="checksite('<?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','index.php?m=admin_announcement&c=checksitedid');"
												 class="admin_company_xg_icon">重新分配</a></div>
										</td>
										<td><a href="index.php?m=admin_announcement&c=add&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="status admin_new_c_bth admin_n_sc">修改</a>
											<a href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=admin_announcement&c=del&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');"
											 class="admin_new_c_bth admin_new_c_bth_sc">删除</a></td>

									</tr>
									<?php } ?>
									<tr>
										<td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
										<td colspan="5">
											<label for="chkAll2">全选</label>&nbsp;
											<input class="admin_button" type="button" name="delsub" value="删除所选" onClick="return really('del[]')" />
											<input class="admin_button" type="button" name="delsub" value="批量选择分站" onClick="checksiteall('index.php?m=admin_announcement&c=checksitedid');" /></td>
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
											<td colspan="5" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</td>
									</tr>
									<?php }?>
								</tbody>
							</table>
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
		<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['adminstyle']->value)."/checkdomain.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	</body>
</html>
<?php }} ?>
