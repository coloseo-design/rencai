<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-06 16:21:09
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\login.htm" */ ?>
<?php /*%%SmartyHeaderCode:3203062c545f5f18ee8-62728994%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ad7e2f28bec2047413c578f9043debd600511ecf' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\login.htm',
      1 => 1634883865,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3203062c545f5f18ee8-62728994',
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
  'unifunc' => 'content_62c545f60135d0_78802012',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c545f60135d0_78802012')) {function content_62c545f60135d0_78802012($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<link href="images/admin.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
	<link href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/css/layui.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />

	<title><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
 - 后台管理中心</title>
</head>

<body>
	<div class="admin_logo_bg">
		<div class="logoin_top"></div>
		<div class="logoin_cont">
			<div class="login_box">
				<div class="logoin_c">
					<div class="logoin_logo"><img src="images/logoin_logo.png"></div>
					<div class="logoin_title"><div class=""><img src="images/logo_t.png?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"></div></div>
					<div id="bind-captcha" data-id='sublogin' data-type='submit'></div>
					<div class="login_iptbox">
						<form action="" method="post" target="supportiframe" autocomplete="off" id='sublogin' onsubmit='return checkform();'>
							<ul class="logoin_list">
								<li><span class="admin_login_s"><label for="username">用户名：</label></span><input type="text" class="ipt" size="10" name="username" id="username" value="" /></li>
								<li><span class="admin_login_s"><label for="password">密&nbsp; 码：</label></span><input type="password" class="ipt" name="password" id="password" value="" /></li>
								
								<?php if (strpos($_smarty_tpl->tpl_vars['config']->value['code_web'],"后台登录")!==false) {?>
								<li>
									<?php if ($_smarty_tpl->tpl_vars['config']->value['code_kind']>2) {?>
									<div class="gtdx-captcha">
										<div id="bind-captcha" data-id='subreg' data-type='click'></div>
										<input type='hidden' id="verify_token"  name="verify_token" value="">
										<input type='hidden' id="popup-submit">	
										<input type='hidden' id="bind-submit">
									</div>
									<?php } else { ?>
									<span class="admin_login_s"><label for="code">验证码：</label></span>
									<input type="text" id="ipt_code" class="ipt" style="width:125px;" name="authcode" value="" />
									<img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/app/include/authcode.inc.php" align="absmiddle" id='vcode_imgs' onclick="checkCode('vcode_imgs');">
									<?php }?>
								</li>
								<?php }?>

								<li><span class="admin_login_s">&nbsp;</span><input type="submit" class="admin_login_sub" name="login_sub"  value="登录" /><input type="reset" class="admin_login_sub admin_login_sub1" name="login_sub" value="重置" /></li>
							</ul>
							<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php echo '<script'; ?>
 src="../js/jquery-1.8.0.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
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
	<iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
	
	
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/verify/verify_js.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	<?php echo '<script'; ?>
>
	var weburl="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
",code_web='<?php echo $_smarty_tpl->tpl_vars['config']->value['code_web'];?>
',code_kind='<?php echo $_smarty_tpl->tpl_vars['config']->value['code_kind'];?>
';
	function checkform(){
		if($('#username').val()==''){
			layer.msg('请填写管理员账户！', 2, 8);return false;  
		}
	
		if($('#password').val()==''){
			layer.msg('请填写登录密码！', 2, 8);return false;  
		}
	
		var codesear=new RegExp('后台登录');
		if(codesear.test(code_web)){
			if(code_kind==1){
				authcode=$("#ipt_code").val();
				if(authcode==''){
					layer.msg('请填写验证码！', 2, 8);return false;  
				}
			}else if(code_kind > 2){
				var verify_token = $('input[name="verify_token"]').val();
				
				if(verify_token ==''){
					$("#bind-submit").trigger("click");
					return false;  
				}
			}
		}
		return true;
	}

	function checkCode(id){
		if(document.getElementById(id)){
			document.getElementById(id).src=weburl+"/app/include/authcode.inc.php?"+Math.random();
		}
	}
	<?php echo '</script'; ?>
>
</body>
</html><?php }} ?>
