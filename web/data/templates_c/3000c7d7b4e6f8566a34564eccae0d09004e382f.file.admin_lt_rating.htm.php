<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-08 16:23:03
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_lt_rating.htm" */ ?>
<?php /*%%SmartyHeaderCode:3239162c7e967b73794-89279035%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3000c7d7b4e6f8566a34564eccae0d09004e382f' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_lt_rating.htm',
      1 => 1634883866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3239162c7e967b73794-89279035',
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
  'unifunc' => 'content_62c7e967bf06d2_12614711',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c7e967bf06d2_12614711')) {function content_62c7e967bf06d2_12614711($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
						<li class="curr"><a href="index.php?m=admin_lt_rating">等级设置</a></li>
						<li><a href="index.php?m=admin_lt_rating&c=server" class="report_uaer_list_on">增值服务</a> </li>
					</ul>
				</div>
				<div class="admin_new_tip">
					<a href="javascript:;" class="admin_new_tip_close"></a>
					<a href="javascript:;" class="admin_new_tip_open" style="display:none;"></a>
					<div class="admin_new_tit"><i class="admin_new_tit_icon"></i>操作提示</div>
					<div class="admin_new_tip_list_cont">
						<div class="admin_new_tip_list">猎头可设置的等级包括：普通会员，高级会员，钻石会员等等，按照实际情况去设置等级的区分，会员等级需满足的条件和享受的优惠</div>
					</div>
				</div>
				<div class="clear"></div>
				<div class="admin_new_search_box"> <a href="index.php?m=admin_lt_rating&c=rating" class="admin_new_cz_tj" style="margin-left:0px;width:110px;">
						设置会员等级</a> </div>
				<div class="clear"></div>
			</div>

			<div class="tty_table-bom">
				<div class="table-list">
					<div class="admin_table_border">
						<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
						<form action="index.php?m=admin_lt_rating&c=delrating" name="myform" method="post" id='myform' target="supportiframe">
							<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
							<table width="100%">
								<thead>
									<tr class="admin_table_top">
										<th width="40"><label for="chkall">
												<input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' />
											</label></th>
										<th>编号</th>
										<th align="left">会员名称</th>
										<th>会员模式</th>
										<th>购买金额</th>
										<th>服务时间</th>
										<th align="left">套餐信息</th>
										<th>状态</th>
										<th width="150">操作</th>
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
" name='del[]' onclick='unselectall()' rel="del_chk" /></td>
										<td><span><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</span></td>
										<td align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</td>
										<td><?php echo $_smarty_tpl->tpl_vars['v']->value['type_n'];?>
</td>
										<td><?php echo $_smarty_tpl->tpl_vars['v']->value['service_price'];?>
元</td>
										<td><?php if ($_smarty_tpl->tpl_vars['v']->value['service_time']!='') {
echo $_smarty_tpl->tpl_vars['v']->value['service_time'];?>
天<?php } else { ?>不限<?php }?></td>
										<td align="left">
											<?php if ($_smarty_tpl->tpl_vars['v']->value['type']==1) {?>
												发布职位：<?php echo $_smarty_tpl->tpl_vars['v']->value['lt_job_num'];?>
份<br>
												刷新职位：<?php echo $_smarty_tpl->tpl_vars['v']->value['lt_breakjob_num'];?>
份<br>
												下载简历：<?php echo $_smarty_tpl->tpl_vars['v']->value['lt_resume'];?>
份<br>
												<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_chat_name'];?>
：<?php echo $_smarty_tpl->tpl_vars['v']->value['chat_num'];?>
位
											<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['type']==2) {?>
												发布职位：<?php if ($_smarty_tpl->tpl_vars['v']->value['lt_job_num']==0) {?>不限<?php } else { ?>每日<?php echo $_smarty_tpl->tpl_vars['v']->value['lt_job_num'];?>
份<?php }?><br>
												刷新职位：<?php if ($_smarty_tpl->tpl_vars['v']->value['lt_breakjob_num']==0) {?>不限<?php } else { ?>每日<?php echo $_smarty_tpl->tpl_vars['v']->value['lt_breakjob_num'];?>
份<?php }?><br>
												下载简历：<?php if ($_smarty_tpl->tpl_vars['v']->value['lt_resume']==0) {?>不限<?php } else { ?>每日<?php echo $_smarty_tpl->tpl_vars['v']->value['lt_resume'];?>
份<?php }?><br>
												<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_chat_name'];?>
：<?php if ($_smarty_tpl->tpl_vars['v']->value['chat_num']==0) {?>不限<?php } else { ?>每日<?php echo $_smarty_tpl->tpl_vars['v']->value['chat_num'];?>
位<?php }?>
											<?php }?>
										</td>
										<td>
											<?php if ($_smarty_tpl->tpl_vars['v']->value['display']==1) {?><span class="admin_com_Audited">已启用</span><?php } else { ?><span class="admin_com_tg">未启用</span><?php }?>
										</td>
										<td>
											<a href="index.php?m=admin_lt_rating&c=rating&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="admin_new_c_bth ">编辑</a>

											<a href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=admin_lt_rating&c=delrating&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');"
											 class="admin_new_c_bth admin_new_c_bth_sc"> 删除</a>
										</td>
									</tr>
									<?php } ?>
									<tr style="background: #f1f1f1;">
										<td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
										<td colspan="8">
											<label for="chkAll2">全选</label>&nbsp;
											<input class="admin_button" type="button" name="delsub" value="删除所选" onclick="return really('del[]')" /></td>
									</tr>
								</tbody>

							</table>
						</form>
					</div>
				</div>
			</div>
	</body>
</html>
<?php }} ?>
