<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:39:42
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_appeal.htm" */ ?>
<?php /*%%SmartyHeaderCode:3197962d902beb30a99-87019668%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c9a14d7073ee30f44d9d992f5a22c3e1a039c6eb' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_appeal.htm',
      1 => 1634883866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3197962d902beb30a99-87019668',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'rows' => 0,
    'key' => 0,
    'v' => 0,
    'moblie_promiss' => 0,
    'email_promiss' => 0,
    'total' => 0,
    'pagenum' => 0,
    'pages' => 0,
    'pagenav' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d902bec23703_57690164',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d902bec23703_57690164')) {function content_62d902bec23703_57690164($_smarty_tpl) {?><?php if (!is_callable('smarty_function_searchurl')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.searchurl.php';
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
				<span class="complay_top_span fl">申诉记录</span>
				<form action="index.php" name="myform" method="get" style="float:left">
					<span class="company_m6" style="float:left;">
						<input name="m" value="admin_appeal" type="hidden" />
						<span class="admin_Filter_span"> 申诉账号：</span>
						<input class="admin_Filter_search" type="text" name="keyword" size="25" style="float:left;margin-top: 5px;" placeholder="请输入你要搜索的关键字">
						<input class="admin_Filter_bth" type="submit" name="news_search" value="检索" style="margin-top: 5px;"/>
						<span class='admin_search_div'>
							<div class="admin_adv_search">
								<div class="admin_adv_search_bth">高级选项</div>
							</div>
						</span>
					</span>
				</form>
				<div class="clear"></div>
			</div>
			
			<?php echo $_smarty_tpl->getSubTemplate ("admin/admin_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

			<div class="tty_table-bom">
				<div class="table-list">
				<div class="admin_table_border">
					<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
					<form action="index.php?m=admin_appeal&c=del" target="supportiframe" name="myform" method="post" id='myform'>
						<table width="100%">
							<thead>
								<tr class="admin_table_top">
									<th><label for="chkall">
											<input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' />
										</label></th>
									<th align="left"> <?php if ($_GET['t']=="uid"&&$_GET['order']=="asc") {?> <a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'uid','m'=>'admin_appeal','untype'=>'order,t'),$_smarty_tpl);?>
">编号<img
											 src="images/sanj.jpg" /></a> <?php } else { ?> <a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'uid','m'=>'admin_appeal','untype'=>'order,t'),$_smarty_tpl);?>
">编号<img
											 src="images/sanj2.jpg" /></a> <?php }?> </th>
									<th align="left">申诉账号</th>
									<th align="left">申诉信息</th>
									<th align="left">联系电话/用户邮箱</th>
									<th> <?php if ($_GET['t']=="appealtime"&&$_GET['order']=="asc") {?> <a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'appealtime','m'=>'admin_appeal','untype'=>'order,t'),$_smarty_tpl);?>
">时间<img
											 src="images/sanj.jpg" /></a> <?php } else { ?> <a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'appealtime','m'=>'admin_appeal','untype'=>'order,t'),$_smarty_tpl);?>
">时间<img
											 src="images/sanj2.jpg" /></a> <?php }?> </th>
									<th>状态</th>
									<th>重置密码</th>
									<th class="admin_table_th_bg">操作</th>
								</tr>
							</thead>
							<tbody>

								<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
								<tr align="center" <?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg"<?php }?> id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
">
									<td><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" name='del[]' onclick='unselectall()' rel="del_chk" /></td>
									<td align="left" class="td1" style="text-align:center;"><span><?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
</span></td>
									<td align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['username'];?>
</td>
									<td align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['appeal'];?>
</td>
									<td align="left">
										<div style="width:170px;"><?php echo $_smarty_tpl->tpl_vars['v']->value['moblie'];
if ($_smarty_tpl->tpl_vars['v']->value['moblie']&&$_smarty_tpl->tpl_vars['moblie_promiss']->value) {?><a href="javascript:void(0);"
											 class="admin_com_send" onClick="send_moblie('<?php echo $_smarty_tpl->tpl_vars['v']->value['moblie'];?>
');">发信息</a><?php }?></div>

										<div style="width:170px;"><?php echo $_smarty_tpl->tpl_vars['v']->value['email'];
if ($_smarty_tpl->tpl_vars['v']->value['email']&&$_smarty_tpl->tpl_vars['email_promiss']->value) {?><a href="javascript:void(0);"
											 class="admin_com_send" onClick="send_email('<?php echo $_smarty_tpl->tpl_vars['v']->value['email'];?>
');">发邮件</a><?php }?></div>
									</td>
									<td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['appealtime'],"%Y-%m-%d %H:%M");?>
</td>
									<td><?php if ($_smarty_tpl->tpl_vars['v']->value['appealstate']==1) {?><font color="red">未完成</font><?php } else { ?><font color="green">已完成</font><?php }?></td>
									<td><a href="javascript:void(0)" class="admin_com_cz" onClick="resetpw('<?php echo $_smarty_tpl->tpl_vars['v']->value['username'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
');">重置密码</a></td>
									<td>
										<a href="index.php?m=admin_appeal&c=info&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" class="admin_cz_sc">用户信息</a>
										| <?php if ($_smarty_tpl->tpl_vars['v']->value['appealstate']==1) {?><a href="javascript:void(0)" onClick="layer_del('确定申诉已完成？', 'index.php?m=admin_appeal&c=success&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
');"
										 class="admin_cz_sc">确认</a> | <?php }?><a href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=admin_appeal&c=del&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
');"
										 class="admin_cz_sc">删除</a>
									</td>
								</tr>
								<?php } ?>
								<tr>
									<td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
									<td colspan="8">
										<label for="chkAll2">全选</label>&nbsp;
										<input class="admin_button" type="button" name="delsub" value="删除所选" onClick="return really('del[]')" /></td>
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
										<td colspan="6" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
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
		<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['adminstyle']->value)."/member_send_email.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	</body>
</html>
<?php }} ?>
