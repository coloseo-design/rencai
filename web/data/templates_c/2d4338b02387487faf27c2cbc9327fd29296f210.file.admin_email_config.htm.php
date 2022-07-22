<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:17:19
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_email_config.htm" */ ?>
<?php /*%%SmartyHeaderCode:515862d8fd7f7c5824-63841994%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2d4338b02387487faf27c2cbc9327fd29296f210' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_email_config.htm',
      1 => 1645275258,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '515862d8fd7f7c5824-63841994',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'emailconfig' => 0,
    'eclist' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d8fd7f876d90_22016994',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d8fd7f876d90_22016994')) {function content_62d8fd7f876d90_22016994($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<meta http-equiv="Pragma" content="no-cache" /> 
	<meta http-equiv="Cache-Control" content="no-cache" /> 
	<meta http-equiv="Expires" content="0" />
	
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
				<div class="admin_new_tip_list">可以使用QQ/163等邮箱，465端口需要开启SSL服务，注意邮箱密码不是账户密码一般是独立授权密码</div>
			</div>
		</div>

		<div class="clear"></div>

			<div class="tag_box">

				<iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
				<form  target="supportiframe" name="myform" action="index.php?m=emailconfig&c=save" method="post"  onSubmit="return checkform(this);" class="layui-form">

					<table width="100%" class="table_form">
						<tr>
							<th width="200">邮件发送方式：</th>
							<td>
								<div class="layui-input-block">
									<input type="radio" name="sy_email_online" value="1" lay-filter="type" id="sy_email_online_1" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_email_online']=="1") {?>checked<?php }?> title="SMTP服务器发送邮件" >
									<input type="radio" name="sy_email_online" value="2" lay-filter="type" id="sy_email_online_2" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_email_online']=="2") {?>checked<?php }?> title="阿里云DirectMail" >
								</div>
							</td>
						</tr>
					</table> 

					<div id="emailtable" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_email_online']=="2") {?>style="display:none;"<?php }?>>
						<?php  $_smarty_tpl->tpl_vars['eclist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['eclist']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['emailconfig']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['eclist']->key => $_smarty_tpl->tpl_vars['eclist']->value) {
$_smarty_tpl->tpl_vars['eclist']->_loop = true;
?>
							<table width="100%" class="table_form">
								<tr class="email admin_table_trbg">
									<th width="200">SMTP服务器：</th>
									<td><input class="tty_input t_w480" type="text" name="smtpserver_<?php echo $_smarty_tpl->tpl_vars['eclist']->value['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['eclist']->value['smtpserver'];?>
" size="30" maxlength="255"/><span class="admin_web_tip">如：smtp.qq.com</span></td>
								</tr>
								<tr class="email">
									<th width="200">SMTP服务器的用户邮箱：</th>
									<td><input class="tty_input t_w480" type="text" name="smtpuser_<?php echo $_smarty_tpl->tpl_vars['eclist']->value['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['eclist']->value['smtpuser'];?>
" size="30" maxlength="255"/><span class="admin_web_tip">如：360222653@qq.com</span></td>
								</tr>
								<tr class="email">
									<th width="200" class="t_fr">邮箱密码：</th>
									<td><input class="tty_input t_w480" type="password" name="smtppass_<?php echo $_smarty_tpl->tpl_vars['eclist']->value['id'];?>
"  value="<?php echo $_smarty_tpl->tpl_vars['eclist']->value['smtppass'];?>
" size="30" maxlength="255"/><span class="admin_web_tip">注：此处密码一般为邮箱独立的授权密码而并非原始邮箱密码，具体可查看各邮箱设置详细信息</span></td>
								</tr>
								<tr class="email admin_table_trbg">
									<th width="200" class="t_fr">SMTP服务器端口: </th>
									<td><input class="tty_input t_w480" type="text" name="smtpport_<?php echo $_smarty_tpl->tpl_vars['eclist']->value['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['eclist']->value['smtpport'];?>
" size="30" maxlength="255"/><span class="admin_web_tip">注：普通邮箱端口为25 企业邮箱端口为465，如使用465端口 请确保服务器开启SSL服务</span></td>
								</tr>
								<tr>
									<th width="200">发件人昵称: </th>
									<td><input class="tty_input t_w480" type="text" name="smtpnick_<?php echo $_smarty_tpl->tpl_vars['eclist']->value['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['eclist']->value['smtpnick'];?>
" size="30" maxlength="255"/></td>
								</tr>
								
								<tr class="admin_table_trbg">
										<th width="200" class="t_fr">启用邮箱：</th>
										<td>
										  <div class="layui-input-block">
											 <div class="layui-input-inline">
											   <input id="default_<?php echo $_smarty_tpl->tpl_vars['eclist']->value['id'];?>
_0" type="radio" <?php if ($_smarty_tpl->tpl_vars['eclist']->value['default']!='1') {?>checked=""<?php }?> value="0" name="default_<?php echo $_smarty_tpl->tpl_vars['eclist']->value['id'];?>
" title="关闭" >
											   <input id="default_<?php echo $_smarty_tpl->tpl_vars['eclist']->value['id'];?>
_1" type="radio" <?php if ($_smarty_tpl->tpl_vars['eclist']->value['default']=='1') {?>checked=""<?php }?> value="1" name="default_<?php echo $_smarty_tpl->tpl_vars['eclist']->value['id'];?>
" title="开启" >
											 </div>
										   </div>
										</td>
									</tr>
								<input type='hidden' name='emailid[]' value='<?php echo $_smarty_tpl->tpl_vars['eclist']->value['id'];?>
'>
								<tr class="email admin_table_trbg">
									<th width="200">&nbsp;</th>
									<td align="left">
										<input class="admin_submit_bthy deleteconfig" data-id='<?php echo $_smarty_tpl->tpl_vars['eclist']->value['id'];?>
' type="button" value="删除" >&nbsp;&nbsp;
										<input class="admin_submit_bthy testconfig"  data-id='<?php echo $_smarty_tpl->tpl_vars['eclist']->value['id'];?>
' type="button"  value="测试">
									</td>
								</tr>
							</table>
						<?php }
if (!$_smarty_tpl->tpl_vars['eclist']->_loop) {
?>
							<?php echo '<script'; ?>
>
								$(function(){  
									$('#emailtable').append($('#appendconfig').html());
								});   
							<?php echo '</script'; ?>
>
						<?php } ?>
					</div>

					<table width="100%" class="table_form emailtable" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_email_online']=="2") {?>style="display:none;"<?php }?>>
						<tr class="email admin_table_trbg">
						 <th width="200">&nbsp;</th>
							<td align="left">
								<input class="layui-btn tty_sub"  type="submit" name="config" value="保存" />&nbsp;&nbsp;
								<input class="layui-btn tty_cz" type="button" value="新增" onclick="javascript:$('#emailtable').append($('#appendconfig').html());" />
							</td>
						</tr>
					</table>




					<div id="aliyunemail" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_email_online']=="1") {?>style="display:none;"<?php }?>>
						<table width="100%" class="table_form">
							<tr class="email admin_table_trbg">
								<th width="200">AccessKey ID：</th>
								<td><input class="tty_input t_w480" type="text" name="accesskey" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['accesskey'];?>
" size="30" maxlength="255"/><span class="admin_web_tip">如：js4Blub11sd14BwQEe</span></td>
							</tr>
							<tr class="email">
								<th width="200">Access Key Secret：</th>
								<td><input class="tty_input t_w480" type="text" name="accesssecret" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['accesssecret'];?>
" size="30" maxlength="255"/><span class="admin_web_tip">如：360222653@qq.com</span></td>
							</tr>
							<tr class="email">
								<th width="200">发信地址：</th>
								<td><input class="tty_input t_w480" type="text" name="ali_email"  value="<?php echo $_smarty_tpl->tpl_vars['config']->value['ali_email'];?>
" size="30" maxlength="255"/></td>
							</tr>
							<tr class="email admin_table_trbg">
								<th width="200">标签: </th>
								<td><input class="tty_input t_w480" type="text" name="ali_tag" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['ali_tag'];?>
" size="30" maxlength="255"/></td>
							</tr>
							<tr>
								<th width="200">发件人昵称: </th>
								<td><input class="tty_input t_w480" type="text" name="ali_name" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['ali_name'];?>
" size="30" maxlength="255"/></td>
							</tr>
						</table>
					</div>

					<table width="100%" class="table_form aliyunemail" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_email_online']=="1") {?>style="display:none;"<?php }?>>
						<tr class="email admin_table_trbg">
							<th width="200">&nbsp;</th>
							<td align="left">
								<input class="layui-btn tty_sub"  type="submit" name="aliconfig" value="保存" />&nbsp;&nbsp;
								<input class="layui-btn tty_cz testconfig" data-id="aliyun" type="button" value="测试" />
							</td>
						</tr>
					</table>
				<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
"> 
			</form>
		</div>
	</div>






<div style="display:none;" id="appendconfig">
	<table width="100%" class="table_form">
		<tr class="email admin_table_trbg">
			<th width="200">SMTP服务器：</th>
			<td><input class="tty_input t_w480" type="text" name="smtpserver[]"  value="" size="30" maxlength="255"/><span class="admin_web_tip">如：smtp.qq.com</span></td>
		</tr>
		<tr class="email">
			<th width="200">SMTP服务器的用户邮箱：</th>
			<td><input class="tty_input t_w480" type="text" name="smtpuser[]"  value="" size="30" maxlength="255"/><span class="admin_web_tip">如：360222653@qq.com</span></td>
		</tr>
		<tr class="email">
			<th width="200" style="float: left;margin-top: 10px;">邮箱密码：</th>
			<td><input class="tty_input t_w480" type="password" name="smtppass[]"  value="" size="30" maxlength="255"/><span class="admin_web_tip">注：此处密码一般为邮箱独立的授权密码而并非原始邮箱密码，具体可查看各邮箱设置详细信息</span></td>
		</tr>
		<tr class="email admin_table_trbg">
			<th width="200" style="float: left;margin-top: 10px;">SMTP服务器端口: </th>
			<td><input class="tty_input t_w480" type="text" name="smtpport[]"  value="" size="30" maxlength="255"/><span class="admin_web_tip">注：普通邮箱端口为25 企业邮箱端口为465，如使用465端口 请确保服务器开启SSL服务</span></td>
		</tr>
		<tr>
			<th width="200">发件人昵称: </th>
			<td><input class="tty_input t_w480" type="text" name="smtpnick[]"  value="" size="30" maxlength="255"/></td>
		</tr>
		
	</table>
</div>

<?php echo '<script'; ?>
> 
	layui.use(['layer', 'form'], function(){
		var layer = layui.layer
		,form = layui.form
		,$ = layui.$;
		form.on('radio(type)', function(data){
			if(data.value=='1'){
				$('#aliyunemail').hide();
				$('#emailtable').show();
				$('.aliyunemail').hide();
				$('.emailtable').show();
			}else{
				$('#aliyunemail').show();
				$('#emailtable').hide();
				$('.aliyunemail').show();
				$('.emailtable').hide();
			}
			form.render();
		}); 
	});
	$(function(){  
		$('.testconfig').click(function(){
			var id = $(this).attr('data-id');
			if(!id){
				layer.msg('请选择需要测试的邮件服务器！',2,8);
			}else{
				layer.prompt({height:'20px',title: '填写测试邮箱',top:'50px'}, function(value){ 
					if(value){
						var myreg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((.[a-zA-Z0-9_-]{2,3}){1,2})$/;
						var pytoken=$("#pytoken").val();
						if(!myreg.test(value)){
							parent.layer.msg('邮箱格式不正确，请重新输入！', 2, 8);return false;
						}else{ 
							var ii = parent.layer.load('发送中…',0);
							$.post("index.php?m=emailconfig&c=ceshi",{ceshi_email:value,id:id,pytoken:pytoken},function(data){
								var data=eval('('+data+')');
								parent.layer.close(ii);
								parent.layer.msg(data.msg, 2, Number(data.type));return false; 
							}); 
						}
					}else{
						parent.layer.msg('请输入邮箱！',2,8);return false; 
					} 
				})
			}
		});
		$('.deleteconfig').click(function(){
			var id = $(this).attr('data-id');
			if(!id){
				layer.msg('请选择需要删除的邮件服务器！',2,8);
			}else{
				var pytoken=$("#pytoken").val();
				layer.confirm("确定删除吗？",function(){
					var ii = layer.load('执行中…',0);
					$.post('index.php?m=emailconfig&c=delconfig',{id:id,pytoken:pytoken},function(data){
						parent.layer.close(ii);
						var data=eval('('+data+')');
						layer.msg(data.msg, 2, Number(data.type),function(){location.reload();});
					})
				});
			}
		});
	});  
	
	function checkform(){

		var sy_email_online = $("input:radio[name='sy_email_online']:checked").val();
		if(sy_email_online==''){
			layer.msg('请选择邮件发送方式！',2,8);
		}
 		
	}
<?php echo '</script'; ?>
>
</div>
</body>
</html><?php }} ?>
