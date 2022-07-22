<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:14:16
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_resume_add.htm" */ ?>
<?php /*%%SmartyHeaderCode:1105362d8fcc8606f51-22729359%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c2762749ebdafa5f0a8fbc1fd8eda5e59d3bfc83' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_resume_add.htm',
      1 => 1634883865,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1105362d8fcc8606f51-22729359',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
    'row' => 0,
    'user_sex' => 0,
    'j' => 0,
    'v' => 0,
    'userdata' => 0,
    'userclass_name' => 0,
    'user_style' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d8fcc86c9ed9_67278474',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d8fcc86c9ed9_67278474')) {function content_62d8fcc86c9ed9_67278474($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
		<title>后台管理</title>
	</head>
	
	<body class="body_ifm">
		<div class="infoboxp">
			<div class="tty-tishi_top">
				<div class="admin_new_tip">
					<a href="javascript:;" class="admin_new_tip_close"></a>
					<a href="javascript:;" class="admin_new_tip_open" style="display:none;"></a>
					<div class="admin_new_tit"><i class="admin_new_tit_icon"></i>操作提示</div>
					<div class="admin_new_tip_list_cont">
						<div class="admin_new_tip_list">该页面用来创建简历信息。</div>
					</div>
				</div>
			</div>
			<div class="clear"></div>
			<div class="">
				<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
				<form class="layui-form" action="index.php?m=admin_resume&c=saveResume" method="post" onSubmit="return addresume()" target="supportiframe">
					<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
					<div class="tty_table-bom">
						
						<?php if ($_smarty_tpl->tpl_vars['row']->value['uid']=='') {?>
						<div class="admin_add_tit"><span class="admin_add_tit_s"><i class="admin_add_tit_s_icon admin_add_tit_s_icon_zh"></i>账户信息</span></div>
						<div class="admin_add_list">
							<div class="admin_add_list_name">登录账户</div>
							<div class="admin_add_list_right">
								<input type="text" name="username" id="username" class="layui-input t_w480" value="" onblur="check_username();">
							</div>
						</div>
						<div class="admin_add_list">
							<div class="admin_add_list_name">密码</div>
							<div class="admin_add_list_right">
								<input type="password" name="password" id="password" class="layui-input t_w480" value="">
							</div>
						</div>

						<div class="admin_add_list">
							<div class="admin_add_list_name">确认密码</div>
							<div class="admin_add_list_right">
								<input type="password" name="passconfirm" id="passconfirm" class="layui-input t_w480"value="">
							</div>
						</div>
						<?php }?>
						<div class="admin_add_tit" style="padding-top: 10px;">
							<span class="admin_add_tit_s"><i class="admin_add_tit_s_icon admin_add_tit_s_icon_info"></i>基本资料</span>
						</div>
						<div class="admin_add_list">
							<div class="admin_add_list_name"><font color="#FF0000">*</font> 用户姓名</div>
							<div class="admin_add_list_right">
								<input type="text" name="resume_name" id="resume_name" class="layui-input t_w480" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
">
							</div>
						</div>
						<div class="admin_add_list">
							<div class="admin_add_list_name"><font color="#FF0000">*</font> 性 别</div>
							<div class="admin_add_list_right">
								<div class="layui-form-item">
									<div class="layui-input-block">
										<div class="layui-input-inline">
											<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['user_sex']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
											<input id="sex<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
" type="radio" <?php if ($_smarty_tpl->tpl_vars['row']->value['sex']==$_smarty_tpl->tpl_vars['j']->value) {?>checked="checked"<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" name="sex">
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="admin_add_list">
							<div class="admin_add_list_name"><font color="#FF0000">*</font> 教育程度</div>
							<div class="admin_add_list_right">
									<div class="layui-input-block">
										<div class="layui-input-inline t_w480">
											<select name="edu" id="edu" lay-verify="">
												<option>请选择</option>
												<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_edu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
												<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['row']->value['edu']==$_smarty_tpl->tpl_vars['v']->value) {?> selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
 </option> 
												<?php } ?> 
											</select>
										</div> 
									</div> 
							</div> 
						</div>
						<div class="admin_add_list">
							<div class="admin_add_list_name"><font color="#FF0000">*</font> 现居住地</div>
							<div class="admin_add_list_right">
								<input type="text" name="living" id="living" class="layui-input t_w480" size="30" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['living'];?>
">
							</div>
						</div>
						<div class="admin_add_list">
							<div class="admin_add_list_name"><font color="#FF0000">*</font> 工作经验</div>
							<div class="admin_add_list_right">
								<div class="layui-input-block">
									<div class="layui-input-inline t_w480">
										<select name="exp" id="exp" lay-verify="">
											<option>请选择</option>
											<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_word']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
											<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['row']->value['exp']==$_smarty_tpl->tpl_vars['v']->value) {?> selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
 </option> 
											<?php } ?> 
										</select> 
									</div> 
								</div> 
							</div> 
						</div>
						<div class="admin_add_list">
							<div class="admin_add_list_name"><font color="#FF0000">*</font> 出生年月</div>
							<div class="admin_add_list_right">
								<input name="birthday" id="birthday" type="text" maxlength="50" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['birthday'];?>
" class="layui-input t_w480" />
							</div>
						</div>
						<div class="admin_add_list">
							<div class="admin_add_list_name"><font color="#FF0000">*</font> 手机</div>
							<div class="admin_add_list_right">
								<input type="text" name="moblie" id='telphone' onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" class="layui-input t_w480" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['telphone'];?>
">
							</div>
						</div>
						<div class="admin_add_list">
							<div class="admin_add_list_name">邮箱</div>
							<div class="admin_add_list_right">
								<input type="text" name="email" id="email" class="layui-input t_w480" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['email'];?>
">
							</div>
						</div>
						<div class="admin_add_list">
							<div class="admin_add_list_name"><font color="#FF0000">*</font> 自我评价</div>
							<div class="admin_add_list_right">
								<textarea id="description" class="layui-textarea t_w480" name="description"><?php echo $_smarty_tpl->tpl_vars['row']->value['description'];?>
</textarea>
							</div>
						</div>
						<div class="admin_add_list">
							<div class="admin_add_list_right">
								<input id="uid" name='uid' type='hidden' value='<?php echo $_smarty_tpl->tpl_vars['row']->value['uid'];?>
'>
								<input class="tty_sub" type="submit" name="next" value="&nbsp;下一步&nbsp;" />
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<?php echo '<script'; ?>
 type="text/javascript">
			layui.use(['layer', 'form', 'laydate'], function() {
				var layer = layui.layer,
					form = layui.form,
					laydate = layui.laydate,
					$ = layui.$;
					laydate.render({
						elem: '#birthday',
						max: '2018-12-31',
						value: '<?php if ($_smarty_tpl->tpl_vars['row']->value['birthday']) {
echo $_smarty_tpl->tpl_vars['row']->value['birthday'];
} else { ?>1988-08-08<?php }?>'
					});
			});
			var userstyle = "<?php echo $_smarty_tpl->tpl_vars['user_style']->value;?>
";
			var weburl = "<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
";

			function addresume() {
				var uid = $.trim($("#uid").val());
				var username = $.trim($("#username").val());
				var password = $.trim($("#password").val());
				var passconfirm = $.trim($("#passconfirm").val());
				var resume_name = $.trim($("#resume_name").val());
				var sex = $.trim($("input[name='sex']:checked").val());
				var living = $.trim($("#living").val());
				var birthday = $.trim($("#birthday").val());
				var telphone = $.trim($("#telphone").val());
				var email = $.trim($("#email").val());
				var description = $.trim($("#description").val());
				var myreg = /^([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9\-]+@([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
				if (uid == '') {
					if (username == '') {
						parent.layer.msg("登录账户不能为空！", 2, 8);
						return false;
					}
					if (password.length < 6) {
						parent.layer.msg("密码长度错误！", 2, 8);
						return false;
					}
					if (password != passconfirm) {
						parent.layer.msg("两次密码不一致！", 2, 8);
						return false;
					}
				}
				if (resume_name == '') {
					parent.layer.msg("用户姓名不能为空！", 2, 8);
					return false;
				}
				if (sex == '') {
					parent.layer.msg("性别不能为空！", 2, 8);
					return false;
				}
				if (living == '') {
					parent.layer.msg("现居住地不能为空！", 2, 8);
					return false;
				}
				if (birthday == '') {
					parent.layer.msg("出生年月不能为空！", 2, 8);
					return false;
				}
				if (telphone == '') {
					parent.layer.msg("手机号码不能为空！", 2, 8);
					return false;
				} else if (!isjsMobile(telphone)) {
					parent.layer.msg("手机号码格式错误！", 2, 8);
					return false;
				}
				if (email != '' && !myreg.test(email)) {
					parent.layer.msg("邮箱格式错误！", 2, 8);
					return false;
				}
				if (description == '') {
					parent.layer.msg("自我评价不能为空！", 2, 8);
					return false;
				}
			}
		<?php echo '</script'; ?>
>
	</body>
</html>
<?php }} ?>
