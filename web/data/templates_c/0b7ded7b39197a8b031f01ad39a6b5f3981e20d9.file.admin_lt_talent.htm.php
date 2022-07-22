<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:09:01
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_lt_talent.htm" */ ?>
<?php /*%%SmartyHeaderCode:3038962d8fb8dd99ed1-62162487%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0b7ded7b39197a8b031f01ad39a6b5f3981e20d9' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_lt_talent.htm',
      1 => 1635727956,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3038962d8fb8dd99ed1-62162487',
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
  'unifunc' => 'content_62d8fb8de4e770_28030919',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d8fb8de4e770_28030919')) {function content_62d8fb8de4e770_28030919($_smarty_tpl) {?><?php if (!is_callable('smarty_function_searchurl')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.searchurl.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
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

		<link href="images/reset.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
		<link href="images/system.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
		<link href="images/table_form.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
		<title>后台管理</title>
	</head>
	<body class="body_ifm">

		<div class="infoboxp">
			<div class="tty-tishi_top">


			<div class="clear"></div>

			<div class="admin_new_search_box">
				<form action="index.php" name="myform" method="get">
					<input name="m" value="lt_talent" type="hidden" />

					<input type="hidden" name="searchtype" value="<?php echo $_GET['searchtype'];?>
" />



					<div class="admin_new_search_name">搜索类型：</div>
					<div class="admin_Filter_text formselect" did='dsearchrname'>
						<input type="button" value="<?php if ($_GET['searchrname']=='1'||$_GET['searchrname']=='') {?>用户名<?php } else { ?>简历名称<?php }?>"
						 class="admin_Filter_but" id="bsearchrname">
						<input type="hidden" id='searchrname' value="<?php if ($_GET['searchrname']) {
echo $_GET['searchrname'];
} else { ?>1<?php }?>"
						 name='searchrname'>
						<div class="admin_Filter_text_box" style="display:none" id='dsearchrname'>
							<ul>
								<li><a href="javascript:void(0)" onClick="formselect('1','searchrname','猎头中介用户名')">猎头中介用户名</a></li>
								<li><a href="javascript:void(0)" onClick="formselect('2','searchrname','姓名')">姓名</a></li>
								<li><a href="javascript:void(0)" onClick="formselect('3','searchrname','意向岗位')">意向岗位</a></li>
							</ul>
						</div>
					</div>
					<input class="admin_Filter_search" type="text" name="keyword" size="25" placeholder="请输入您要搜索的关键字"/>
					<input class="admin_Filter_bth" type="submit" name="news_search" value="检索" />
				</form>
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
						<input name="m" value="lt_talent" type="hidden" />
						<input name="c" value="del" type="hidden" />
						<table width="100%">
							<thead>
								<tr class="admin_table_top">
									<th width="3%"><label for="chkall">
											<input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' />
										</label></th>

									<th width="8%"> <?php if ($_GET['t']=="uid"&&$_GET['order']=="asc") {?> <a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'uid','m'=>'lt_talent','untype'=>'order,t'),$_smarty_tpl);?>
">猎头编号<img
											 src="images/sanj.jpg" /></a> <?php } else { ?> <a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'uid','m'=>'lt_talent','untype'=>'order,t'),$_smarty_tpl);?>
">猎头编号<img
											 src="images/sanj2.jpg" /></a> <?php }?> </th>
									<th align="left" width="100">拥有者</th>
									<th align="left" width="100">姓名</th>
									<th align="left" width="8%">意向职位</th>
									<th align="left" width="100">学历</th>
									<th align="left" width="100">工作经验</th>
									<th>工作地点</th>
									<th>待遇要求</th>
									<th>联系手机</th>
									<th>状态</th>
									<th>授权状态</th>

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
									<td><input type="checkbox" class="check_all" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name='del[]' onclick='unselectall()'
										 rel="del_chk" /></td>
									<td align="left" class="td1" style="text-align:center;"><span><?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
</span></td>
									<td class="gd" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['user'];?>
</td>
									<td class="ud" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</td>
									<td class="od" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['jobname'];?>
</td>
									<td class="od" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['edu_n'];?>
</td>
									<td class="od" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['exp_n'];?>
</td>
									<td class="gd"><?php echo $_smarty_tpl->tpl_vars['v']->value['city_one'];?>
 <?php echo $_smarty_tpl->tpl_vars['v']->value['city_two'];?>
 <?php echo $_smarty_tpl->tpl_vars['v']->value['city_three'];?>
</td>
									<td class="td"><?php echo $_smarty_tpl->tpl_vars['v']->value['salary'];?>
</td>
									<td><?php echo $_smarty_tpl->tpl_vars['v']->value['linktel'];?>
</td>
									<td><?php if ($_smarty_tpl->tpl_vars['v']->value['rewardstatus']=='1') {?>推荐中<?php } else { ?>空闲<?php }?></td>
									<td><?php if ($_smarty_tpl->tpl_vars['v']->value['telstatus']=='1') {?>已授权<?php } else { ?>未授权<?php }?></td>

									<td>
										<div class=" mt5"> <a href="index.php?m=lt_talent&c=show&uid=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="admin_new_c_bth admin_new_c_bth_yl">
												预览</a> </div>
										<div class=" mt5"> <a href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=lt_talent&c=del&del=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');"
											 class="admin_new_c_bth admin_new_c_bth_sc">删除</a></div>
									</td>
								</tr>
								<?php } ?>
								<tr>
									<td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
									<td colspan="13">
										<label for="chkAll2">全选</label>&nbsp;
										<input class="admin_button" type="button" name="delsub" value="删除所选" onClick="return really('del[]')" />
										&nbsp;&nbsp;
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
										<td colspan="11" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
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
		<?php echo '<script'; ?>
 type="text/javascript">
			layui.use(['layer', 'form'], function() {
				var layer = layui.layer,
					form = layui.form,
					$ = layui.$;
			});
		<?php echo '</script'; ?>
>
	</body>
</html>
<?php }} ?>
