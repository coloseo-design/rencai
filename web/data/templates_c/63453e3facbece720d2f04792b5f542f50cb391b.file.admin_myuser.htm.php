<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-06 16:22:08
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_myuser.htm" */ ?>
<?php /*%%SmartyHeaderCode:3052762c54630297a99-72407920%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '63453e3facbece720d2f04792b5f542f50cb391b' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_myuser.htm',
      1 => 1634883865,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3052762c54630297a99-72407920',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
    'pass_div' => 0,
    'adminuser' => 0,
    'user_group' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c546302de472_32966559',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c546302de472_32966559')) {function content_62c546302de472_32966559($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\modifier.date_format.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
		<link href="./images/reset.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
		<link href="./images/system.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
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
		<link href="./images/table_form.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />

		<?php echo '<script'; ?>
 type="text/javascript">
			function getcode() {
				var setval;
				var pytoken = '<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
';
				$.post('index.php?m=index&c=wxbind', {
					pytoken: pytoken
				}, function(data) {
					status_div('扫描二维码', '320', '260');
					if (data == 0) {
						$('#wx_login_qrcode').html('二维码获取失败..');
					} else {
						$('#wx_login_qrcode').html('<img src="' + data + '" width="140" height="140">');
						setval = setInterval("wxorderstatus()", 2000);
					}
				});
			}

			function wxorderstatus() {
				var pytoken = '<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
';
				$.post('index.php?m=index&c=getwxbindstatus', {
					pytoken: pytoken
				}, function(data) {

					if (data == 1) {
						$('#status_div').hide();
						layer.msg('绑定成功', 2, 9, function() {
							window.location.reload();
							return;
						});
					}

				});
			}

			function delwxid() {
				var pytoken = '<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
';
				$.post('index.php?m=index&c=delAdminWxBind', {
					pytoken: pytoken
				}, function(data) {

					if (data == 1) {
						layer.msg('解绑成功', 2, 9, function() {
							window.location.reload();
							return;
						});
					}

				});
			}
		<?php echo '</script'; ?>
>
		<title></title>
	</head>
	<body class="body_ifm">
		<div class="infoboxp">
			<div class="tty-tishi_top">
				
				<div class="tabs_info">
					<ul>
						<li <?php if ($_smarty_tpl->tpl_vars['pass_div']->value!='1') {?>class="curr"<?php }?>>基本信息</li>
						<li <?php if ($_smarty_tpl->tpl_vars['pass_div']->value=='1') {?>class="curr"<?php }?>>修改密码</li>
					</ul>
				</div>
				
				<div class="admin_new_tip">
					<a href="javascript:;" class="admin_new_tip_close"></a>
					<a href="javascript:;" class="admin_new_tip_open" style="display:none;"></a>
					<div class="admin_new_tit"><i class="admin_new_tit_icon"></i>操作提示</div>
					<div class="admin_new_tip_list_cont">
						
						<div class="admin_new_tip_list">我的帐号主要显示网站当前的管理员帐号信息，如用户名、姓名和管理员姓名参数！</div>

						<div class="admin_new_tip_list">当前管理员还可以修改自己的密码操作,修改成功以后，需重新登录。</div>
					</div>
				</div>
				<div class="clear"></div>

				<div class="con_form">

					<form action="" class="layui-form" <?php if ($_smarty_tpl->tpl_vars['pass_div']->value=='1') {?>style="display: none;"<?php }?>>
						<table width="100%" class="table_form ">
							<tr>
								<th width="150">用户名：</th>
								<td>
									<div class="admin_td_h"><?php echo $_smarty_tpl->tpl_vars['adminuser']->value['username'];?>
</div>
								</td>
							</tr>
							<tr class="admin_table_trbg">
								<th>真实姓名：</th>
								<td>
									<div class="admin_td_h"><?php echo $_smarty_tpl->tpl_vars['adminuser']->value['name'];?>
</div>
								</td>
							</tr>
							<tr>
								<th>权限：</th>
								<td>
									<div class="admin_td_h"><?php echo $_smarty_tpl->tpl_vars['user_group']->value['group_name'];?>
</div>
								</td>
							</tr>
							<tr class="admin_table_trbg">
								<th>微信绑定：</th>
								<td>
									<div class="admin_td_h">
										<?php if ($_smarty_tpl->tpl_vars['adminuser']->value['wxid']=='') {?>
											<a href="javascript:void(0)" onclick="getcode();"class="admin_logout_bth">绑定</a>
										<?php } else { ?>
											<a href="javascript:void(0)" onclick="delwxid()" class="admin_logout_bth">解除绑定</a>
										<?php }?>
									</div>
								</td>
							</tr>
							<tr class="admin_table_trbg">
								<th>上一次登录时间：</th>
								<td>
									<div class="admin_td_h"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['adminuser']->value['lasttime'],'%Y-%m-%d %H:%M:%S');?>
</div>
								</td>
							</tr>
						
							<div id="status_div" style="display:none; width: 320px; ">
								<div id="wx_login_qrcode" class="admin_census">正在获取二维码...</div>
								<div class="admin_census_bd">请使用微信扫描二维码绑定</div>
							</div>
						
						</table>
					</form>

					<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
					<form action="index.php?m=admin_user&c=savePass" class="layui-form" target="supportiframe" method="post" id="myform" <?php if ($_smarty_tpl->tpl_vars['pass_div']->value!='1') {?>style="display: none;"<?php }?>>
						<table width="100%" class="table_form table_form_thr" style="background:#fff;">
							<tr>
								<th width="140">原始密码：</th>
								<td width="100%">
									<div class="layui-input-inline t_w480">
										<input type="password" value="" name="oldpass" class="layui-input" placeholder="请输入原始密码">
									</div>
								</td>
							</tr>
							<tr>
								<th width="140">新密码：</th>
								<td width="100%">
									<div class="layui-input-inline t_w480">
										<input type="password" value="" name="password" class="layui-input" placeholder="请输入新密码">
									</div>
								</td>
							</tr>
							<tr>
								<th width="140">确认密码：</th>
								<td width="100%">
									<div class="layui-input-inline t_w480">
										<input type="password" value="" name="okpassword" class="layui-input" placeholder="确认密码">
									</div>
								</td>
							</tr>
								
							<tr>
								<th></th>
								<td colspan="3">
									<input class="tty_sub" type="submit" name="useradd" value="&nbsp;修 改&nbsp;" />
									<input class="tty_cz" type="reset" name="reset" value="&nbsp;重 置 &nbsp;" />
								</td>
							</tr>
						</table>
						<input type="hidden" name="pytoken" id="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
					</form>
				</div>
			</div>
		</div>
		<?php echo '<script'; ?>
>
			
			var ah2 = $(".tabs_info li")
			var ap = $(".con_form form")
			
			for (var i = 0; i < ah2.length; i++) {
			    ah2[i].index = i;
				
			    ah2[i].onclick = function () {
			        for (var j = 0; j < ap.length; j++) {
			            ap[j].style.display = "none"
			        }
			        ap[this.index].style.display = "block";
			    }
			}
			ah2.each(function(){
				
				$(this).click(function(){
					ah2.removeClass("curr")
					$(this).addClass("curr")
				})
			})
			
		<?php echo '</script'; ?>
>
	</body>
</html>
<?php }} ?>
