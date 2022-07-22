<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 17:32:55
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_company_pay.htm" */ ?>
<?php /*%%SmartyHeaderCode:2839262d91d471b3718-68012265%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e4b712608e962941a7ff0ed9d4ef8fe094a18102' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_company_pay.htm',
      1 => 1638002046,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2839262d91d471b3718-68012265',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
    'rows' => 0,
    'key' => 0,
    'v' => 0,
    'total' => 0,
    'pagenum' => 0,
    'pages' => 0,
    'pagenav' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d91d472921e6_41208835',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d91d472921e6_41208835')) {function content_62d91d472921e6_41208835($_smarty_tpl) {?><?php if (!is_callable('smarty_function_searchurl')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.searchurl.php';
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
						<input name="m" value="company_pay" type="hidden" />
						<div class="admin_new_search_name">搜索类型：</div>
						<div class="admin_Filter_text formselect" did='dtype'>
							<input type="button" value="<?php if ($_GET['type']=='1'||$_GET['type']=='') {?>消费单号<?php } elseif ($_GET['type']=='2') {?>用户名<?php } elseif ($_GET['type']=='3') {?>备注说明<?php }?>"
							 class="admin_Filter_but" id="btype">
							<input type="hidden" id='type' value="<?php if ($_GET['type']) {
echo $_GET['type'];
} else { ?>1<?php }?>"
							 name='type'>
							<div class="admin_Filter_text_box" style="display:none" id='dtype'>
								<ul>
									<li><a href="javascript:void(0)" onClick="formselect('1','type','消费单号')">消费单号</a></li>
									<li><a href="javascript:void(0)" onClick="formselect('2','type','用户名')">用户名</a></li>
									<li><a href="javascript:void(0)" onClick="formselect('3','type','备注说明')">备注说明</a></li>
								</ul>
							</div>
						</div>
						<input class="admin_Filter_search" placeholder="输入你要搜索的关键字" type="text" name="keyword" size="25" />
						<input class="admin_Filter_bth" type="submit" name="news_search" value="检索" />
						<a href="javascript:void(0)" onclick="$('.admin_screenlist_box').toggle();" class="admin_new_search_gj">高级搜索</a>
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
							<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
							<input name="m" value="company_pay" type="hidden" />
							<input name="c" value="del" type="hidden" />
							<table width="100%">
								<thead>
									<tr class="admin_table_top">
										<th style="width:20px;"><label for="chkall">
												<input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' />
											</label></th>
										<th> 
										<?php if ($_GET['t']=="id"&&$_GET['order']=="asc") {?> 
										<a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'id','m'=>'company_pay','untype'=>'order,t'),$_smarty_tpl);?>
">编号<img src="images/sanj.jpg" /></a> 
										<?php } else { ?> 
										<a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'id','m'=>'company_pay','untype'=>'order,t'),$_smarty_tpl);?>
">编号<img src="images/sanj2.jpg" /></a> 
										<?php }?> 
										</th>
										<th>消费单号</th>
										<th align="left">用户名 / 企业名称(姓名)</th>
										<th align="left">金额</th>
										<th align="left">备注说明</th>
										<th> <?php if ($_GET['t']=="pay_time"&&$_GET['order']=="asc") {?> <a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'pay_time','m'=>'company_pay','untype'=>'order,t'),$_smarty_tpl);?>
">时间<img
												 src="images/sanj.jpg" /></a> <?php } else { ?> <a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'pay_time','m'=>'company_pay','untype'=>'order,t'),$_smarty_tpl);?>
">时间<img
												 src="images/sanj2.jpg" /></a> <?php }?> </th>
										<th>状态</th>
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
									<tr align="center" <?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg"<?php }?> id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
										<td><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name='del[]' onclick='unselectall()' rel="del_chk" /></td>
										<td align="left" class="td1" style="text-align:center;"><span><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</span></td>
										<td><?php echo $_smarty_tpl->tpl_vars['v']->value['order_id'];?>
</td>
										<td align="left"><span style="color:#009688"><?php echo $_smarty_tpl->tpl_vars['v']->value['username'];?>
</span><div><?php echo $_smarty_tpl->tpl_vars['v']->value['comname'];?>
</div></td>
										<td align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['order_price'];
if ($_smarty_tpl->tpl_vars['v']->value['type']==1) {
echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];
} else { ?>元<?php }?> </td>
										<td align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['pay_remark'];?>
</td>
										<td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['pay_time'],"%Y-%m-%d %H:%M");?>
</td>
										<td><?php echo $_smarty_tpl->tpl_vars['v']->value['pay_state_n'];?>
</td>
										<td><a href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=company_pay&c=del&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');"
											 class="admin_new_c_bth admin_new_c_bth_sc">删除</a></td>
									</tr>
									<?php } ?>
									<tr>
										<td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
										<td colspan="9">
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
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<?php }} ?>
