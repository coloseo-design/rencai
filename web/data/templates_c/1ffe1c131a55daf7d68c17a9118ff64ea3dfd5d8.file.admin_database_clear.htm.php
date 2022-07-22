<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 16:10:05
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_database_clear.htm" */ ?>
<?php /*%%SmartyHeaderCode:1589362d909dd608236-58078566%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1ffe1c131a55daf7d68c17a9118ff64ea3dfd5d8' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_database_clear.htm',
      1 => 1643012867,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1589362d909dd608236-58078566',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d909dd662564_85915023',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d909dd662564_85915023')) {function content_62d909dd662564_85915023($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
						<li>
							<a href="index.php?m=database">备份数据</a>
						</li>
						<li>
							<a href="index.php?m=database&c=backin">恢复数据</a>
						</li>
						<li>
							<a href="index.php?m=database&c=optimizing">优化数据</a>
						</li>
						<li class="curr">
							<a href="index.php?m=database&c=clearList">数据清理</a>
						</li>
					</ul>
				</div>

				<div class="admin_new_tip">
					<a href="javascript:;" class="admin_new_tip_close"></a>
					<a href="javascript:;" class="admin_new_tip_open" style="display:none;"></a>
					<div class="admin_new_tit"><i class="admin_new_tit_icon"></i>操作提示</div>
					<div class="admin_new_tip_list_cont">
						<div class="admin_new_tip_list">定期清理数据表碎片可以提升数据库的查询速度。</div>
						<div class="admin_new_tip_list">从而提升用户体验度，站长可自行选择老数据清理。</div>
					</div>
				</div>
				<div class="clear"></div>

				<div class="table-list mt10" id="databaseshow">
					<div class="admin_table_border">
						<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
						<form class="layui-form" action="index.php?m=database&c=clear" target="supportiframe" method="post" onSubmit="return check_form()">
							<input type="hidden" name="pytoken" id="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
							<table width="100%">
								<thead>
									<tr class="admin_table_top">
										<th colspan="4" align="left"><span style="padding-left:10px;">清理内容</span></th>
									</tr>
								</thead>
								<tr>
									<td colspan="4">
										<div class="layui-input-block">
											<input type="checkbox" name="clear_data[]" value="userid_job" lay-skin="primary" title="职位申请记录">
											<input type="checkbox" name="clear_data[]" value="userid_msg" lay-skin="primary" title="面试邀请记录">
											<input type="checkbox" name="clear_data[]" value="down_resume" lay-skin="primary" title="下载简历记录">
											<input type="checkbox" name="clear_data[]" value="talent_pool" lay-skin="primary" title="收藏简历记录">
											<input type="checkbox" name="clear_data[]" value="look_resume" lay-skin="primary" title="浏览简历记录">
											<input type="checkbox" name="clear_data[]" value="look_job" lay-skin="primary" title="浏览职位记录">
											<input type="checkbox" name="clear_data[]" value="chat_log" lay-skin="primary" title="聊天记录">
											<input type="checkbox" name="clear_data[]" value="web_log" lay-skin="primary" title="行为轨迹">
										</div>
										<div class="layui-input-block">
											<input type="checkbox" name="clear_data[]" value="email_msg" lay-skin="primary" title="邮件发送记录">
											<input type="checkbox" name="clear_data[]" value="moblie_msg" lay-skin="primary" title="短信发送记录">
											<input type="checkbox" name="clear_data[]" value="member_log" lay-skin="primary" title="会员日志记录">
											<input type="checkbox" name="clear_data[]" value="admin_log" lay-skin="primary" title="管理员日志">
											<input type="checkbox" name="clear_data[]" value="recycle" lay-skin="primary" title="回收站">
										</div>
									</td>
								</tr>
								<thead>
									<tr class="admin_table_top">
										<th colspan="4" align="left"><span style="padding-left:10px;">清理时间</span></th>
									</tr>
								</thead>
								<tr>
									<td colspan="3">
										<div class="layui-input-block">
											<input type="radio" name="clear_time" value="730" title="两年前">
											<input type="radio" name="clear_time" value="365" title="一年前">
											<input type="radio" name="clear_time" value="180" title="半年前">
											<input type="radio" name="clear_time" value="90" title="三个月前">
											<input type="radio" name="clear_time" value="60" title="两个月前">
											<input type="radio" name="clear_time" value="30" title="一个月前">
										</div>
									</td>
								</tr>

								<tr align="center">
									<td colspan="4"><button class="layui-btn tty_sub" lay-submit="" lay-filter="clear">清除</button></td>
								</tr>

							</table>
						</form>
					</div>
				</div>
			</div>
			<div class="table-list mt10" style="display:none" id="success">
				<div class="admin_table_border">
					<div class="layui-progress layui-progress-big" lay-showpercent="true" lay-filter="demo">
						<div class="layui-progress-bar layui-bg-red" lay-percent="0%"></div>
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

			function check_form() {

				var clearData = $("input(name='clear_data[]')");

				var checkNum = 0;

				for (var i = 0; i < clearData.length; i++) {

					if (clearData[i].checked) {
						checkNum++;
					}
				}

				if (checkNum == 0) {
					parent.layer.msg('请选择需要清理的数据！', 2, 8);
					return false;
				}
				var clearTime = $("input[name='clear_time']:checked").val();
				if (!clearTime) {
					parent.layer.msg('请选择清理时间！', 2, 8);
					return false;
				}
			}
		<?php echo '</script'; ?>
>
	</body>

</html>
<?php }} ?>
