<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-08 16:19:59
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_cron_list.htm" */ ?>
<?php /*%%SmartyHeaderCode:2078062c7e8af07e668-94501527%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b81fb667b41b58b85a28807c3527c95eb38a7d3c' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_cron_list.htm',
      1 => 1634883866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2078062c7e8af07e668-94501527',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
    'rows' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c7e8af0fa7c9_29306166',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c7e8af0fa7c9_29306166')) {function content_62c7e8af0fa7c9_29306166($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\modifier.date_format.php';
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
		<link href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/css/layui.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet"
		 type="text/css" />
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
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
		<div id="wname" style="display:none; width: 350px; ">
			<div style="height: 160px;" class="job_box_div">
				<div class="job_box_inp">
					<table class="table_form " style="width:100%">
						<tr>
							<td class='ui_content_wrap'>复制(CTRL+C)以下內容并添加到服务器配置中</td>
						</tr>
						<tr>
							<td><input type="text" name="position" id='copy_url' class="input-text" size='45' style="width:310px;" /></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="infoboxp">
			<div class="tty-tishi_top">
				<div class="tabs_info">
					<ul>
						<li class="curr"> <a href="index.php?m=cron">计划任务</a></li>
						<li> <a href="index.php?m=cron&c=cronLog">任务日志</a></li>
					</ul>
				</div>
				<div class="admin_new_tip">
					<a href="javascript:;" class="admin_new_tip_close"></a>
					<a href="javascript:;" class="admin_new_tip_open" style="display:none;"></a>
					<div class="admin_new_tit"><i class="admin_new_tit_icon"></i>操作提示</div>
					<div class="admin_new_tip_list_cont">
						<div class="admin_new_tip_list">
							管理员可以通过“计划任务”实现自动刷新职位、简历刷新和生成XML操作。计划任务可以设置计划类型按“天、周、月”方式去执行！
						</div>
					</div>
				</div>

				<div class="clear"></div>

				<div class="admin_new_search_box">
					
						<a href="index.php?m=cron&c=add" class="admin_new_cz_tj" style="margin-left:0px;">+ 添加任务</a>
					<div class="clear"></div>
				</div>
			</div>
				
				<div class="tty_table-bom">
					<div class="table-list">
						<div class="admin_table_border">
							<form action="" name="myform" method="get">
								<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">

								<table width="100%">
									<thead>
										<tr class="admin_table_top">
											<th align="left">ID</th>
											<th align="left">
												<div style="padding-left:10px;">任务名称</div>
											</th>
											<th align="left">执行文件</th>
											<th align="left">执行类型</th>
											<th align="left">是否启用</th>
											<th align="left">上次执行时间</th>
											<th align="left">下次执行时间</th>
											<th align="left">外部调用</th>
											<th width="180">操作</th>
										</tr>
									</thead>
									<tbody>
										<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
										<tr align="left">
											<td align="left" class="ud">
												<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>

											</td>
											<td align="left" class="td1">
												<div style="padding-left:10px;"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</div>
											</td>
											<td align="left" class="ud"><?php echo $_smarty_tpl->tpl_vars['v']->value['dir'];?>
</td>
											<td class="ud" align="left">
												<?php if ($_smarty_tpl->tpl_vars['v']->value['type']==1) {?>每周<?php }?>
												<?php if ($_smarty_tpl->tpl_vars['v']->value['type']==2) {?>每月<?php }?>
												<?php if ($_smarty_tpl->tpl_vars['v']->value['type']==3) {?>每天<?php }?>
												<?php if ($_smarty_tpl->tpl_vars['v']->value['type']==4) {?>每隔N秒<?php }?>
												<?php if ($_smarty_tpl->tpl_vars['v']->value['type']==5) {?>每隔N分钟<?php }?>
											</td>
											<td class="od" align="left">
												<?php if ($_smarty_tpl->tpl_vars['v']->value['display']==1) {?>是<?php }?>
												<?php if ($_smarty_tpl->tpl_vars['v']->value['display']==2) {?>否<?php }?>
											</td>
											<td align="left" class="ud">
												<?php if ($_smarty_tpl->tpl_vars['v']->value['nowtime']) {
echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['nowtime'],"%Y-%m-%d %H:%M");
} else { ?>-
												-<?php }?>
											</td>
											<td align="left" class="ud">
												<?php if ($_smarty_tpl->tpl_vars['v']->value['nexttime']) {
echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['nexttime'],"%Y-%m-%d %H:%M");
} else { ?>-
												-<?php }?>
											</td>
											<td class="ud" align="center">
												<a href="javascript:void(0);" onclick="copy_url('调用地址','<?php echo $_smarty_tpl->tpl_vars['v']->value['src'];?>
')" class="admin_cz_yl">调用</a>
											</td>
											<td align="center">

												<?php if ($_smarty_tpl->tpl_vars['v']->value['display']==1) {?>
												<a href="javascript:void(0)" onclick="layer_del('确定现在执行该任务？', 'index.php?m=cron&c=run&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');"
												 class="admin_new_c_bth">执行</a>
												<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['display']==2) {?>
												<a href="javascript:void(0)" onclick="layer_del('该任务尚未启用！', 'index.php?m=cron');" class="admin_new_c_bth">执行</a>
												<?php }?>
												<a href="index.php?m=cron&c=add&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="admin_new_c_bth">修改</a>
												<a href="javascript:void(0)" onclick="layer_del('确定要删除？', 'index.php?m=cron&c=del&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');"
												 class="admin_new_c_bth admin_new_c_bth_sc">删除</a>
											</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<?php }} ?>
