<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:09:11
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_lt_xuanshang.htm" */ ?>
<?php /*%%SmartyHeaderCode:803562d8fb97268805-18588912%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '34dd9e53c44cb60267d11bc218bca63e72735584' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_lt_xuanshang.htm',
      1 => 1634883865,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '803562d8fb97268805-18588912',
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
    'total' => 0,
    'pagenum' => 0,
    'pages' => 0,
    'pagenav' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d8fb973701b2_30201209',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d8fb973701b2_30201209')) {function content_62d8fb973701b2_30201209($_smarty_tpl) {?><?php if (!is_callable('smarty_function_searchurl')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.searchurl.php';
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
						<input name="m" value="admin_lt_xuanshang" type="hidden" />
						<input type="hidden" name="look" value="<?php echo $_GET['look'];?>
" />
						<div class="admin_new_search_name">搜索类型：</div>
						<div class="admin_Filter_text formselect" did='dtype'>
							<input type="button" value="<?php if ($_GET['type']=='1'||$_GET['type']=='') {?>推荐人<?php } elseif ($_GET['type']=='4') {?>接收人<?php }?>"
							 class="admin_Filter_but" id="btype">
							<input type="hidden" id='type' value="<?php if ($_GET['type']) {
echo $_GET['type'];
} else { ?>1<?php }?>"
							 name='type'>
							<div class="admin_Filter_text_box" style="display:none" id='dtype'>
								<ul>
									<li><a href="javascript:void(0)" onClick="formselect('1','type','推荐人')">推荐人</a></li>
									<li><a href="javascript:void(0)" onClick="formselect('4','type','接收人')">接收人</a></li>
								</ul>
							</div>
						</div>
						<input class="admin_Filter_search" type="text" name="keyword" size="25" placeholder="请输入您要搜索的关键字"/>
						<input class="admin_Filter_bth" type="submit" name="search" value="检索" />
					</form>
					<a href="javascript:void(0)" onclick="$('.admin_screenlist_box').toggle();" class="admin_new_search_gj">高级搜索</a>



					<?php echo $_smarty_tpl->getSubTemplate ("admin/admin_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

				</div>
				<div class="clear"></div>
			</div>

			<div class="tty_table-bom">
				<div class="table-list">
					<div class="admin_table_border">
						<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
						<form action="index.php" name="myform" method="get" target="supportiframe" id='myform'>
							<input type="hidden" id='pytoken' name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
							<input name="m" value="admin_lt_xuanshang" type="hidden" />
							<input name="c" value="del" type="hidden" />
							<table width="100%">
								<thead>
									<tr class="admin_table_top">
										<th style="width:20px;"><label for="chkall">
												<input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' />
											</label></th>
										<th width="5%"> <?php if ($_GET['t']=="id"&&$_GET['order']=="asc") {?> <a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'id','m'=>'admin_lt_xuanshang','untype'=>'order,t'),$_smarty_tpl);?>
">编号
												<img src="images/sanj.jpg" /></a> <?php } else { ?> <a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'id','m'=>'admin_lt_xuanshang','untype'=>'order,t'),$_smarty_tpl);?>
">编号
												<img src="images/sanj2.jpg" /></a> <?php }?></th>
										<th align="left">推荐人</th>
										<th align="left">接收人</th>
										<th align="left">悬赏职位</th>
										<th align="left">需求单位</th>
										<th align="left">悬赏金额</th>
										<th align="left">人才姓名</th>
										<th align="left"> <?php if ($_GET['t']=="datetime"&&$_GET['order']=="asc") {?> <a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'datetime','m'=>'admin_lt_xuanshang','untype'=>'order,t'),$_smarty_tpl);?>
">推荐时间
												<img src="images/sanj.jpg" /></a> <?php } else { ?> <a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'datetime','m'=>'admin_lt_xuanshang','untype'=>'order,t'),$_smarty_tpl);?>
">推荐时间
												<img src="images/sanj2.jpg" /></a> <?php }?></th>

										<th align="left"> <?php if ($_GET['t']=="reply_time"&&$_GET['order']=="asc") {?> <a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'reply_time','m'=>'admin_lt_xuanshang','untype'=>'order,t'),$_smarty_tpl);?>
">回复时间
												<img src="images/sanj.jpg" /></a> <?php } else { ?> <a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'reply_time','m'=>'admin_lt_xuanshang','untype'=>'order,t'),$_smarty_tpl);?>
">回复时间
												<img src="images/sanj2.jpg" /></a> <?php }?></th>
										<th>状态</th>
										<th class="admin_table_th_bg">操作</th>
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
										<td><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="check_all" name='del[]' onclick='unselectall()'
											 rel="del_chk" /></td>
										<td class="td1" style="text-align:center;"><span><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</span></td>
										<td class="ud" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['username'];?>
</td>
										<td class="ud" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['rname'];?>
</td>
										<td class="ud" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['job_name'];?>
</td>
										<td class="ud" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['com_name'];?>
</td>
										<td class="ud" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['rebates'];
if ($_smarty_tpl->tpl_vars['config']->value['lt_rebates_name']) {?>
											<?php echo $_smarty_tpl->tpl_vars['config']->value['lt_rebates_name'];?>
 <?php } else { ?>元<?php }?></td>
										<td class="ud" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</td>
										<td align="left"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['datetime'],"%Y-%m-%d %H:%M");?>
</td>
										<td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['reply_time'],"%Y-%m-%d %H:%M");?>
</td>
										<td><?php if ($_smarty_tpl->tpl_vars['v']->value['status']==4) {?><span class="admin_com_fl">已返利</span><?php } elseif ($_smarty_tpl->tpl_vars['v']->value['status']==1) {?><span
											 class="admin_com_Audited">已查看</span><?php } elseif ($_smarty_tpl->tpl_vars['v']->value['status']==2) {?><span class="admin_com_Lock">已试用</span><?php } elseif ($_smarty_tpl->tpl_vars['v']->value['status']==0) {?><span class="admin_com_noAudited">未查看</span><?php } elseif ($_smarty_tpl->tpl_vars['v']->value['status']==3) {?><span class="admin_com_tg">未通过</span><?php }?></td>
										<td>
											<a href="index.php?m=admin_lt_xuanshang&c=show&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="admin_new_c_bth admin_new_c_bth_yl">查看</a>
											<a href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=admin_lt_xuanshang&c=del&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');"
											 class="admin_new_c_bth admin_new_c_bth_sc">删除</a></td>
									</tr>
									<?php } ?>
									<tr>
										<td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
										<td colspan="11"><label for="chkAll2">全选</label>
											&nbsp;
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
											<td colspan="9" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
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
