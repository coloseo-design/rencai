<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:17:26
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_msg_config.htm" */ ?>
<?php /*%%SmartyHeaderCode:318462d8fd86d29819-77308132%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ee0ee4be2780be877e1f18acd632100ac7cb0751' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_msg_config.htm',
      1 => 1645278804,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '318462d8fd86d29819-77308132',
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
  'unifunc' => 'content_62d8fd86ddd459_33876430',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d8fd86ddd459_33876430')) {function content_62d8fd86ddd459_33876430($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
<div class="admin_new_tip_list">请先注册帐户 短信内容支持长短信，最多500个字，65个字按一条短信计费。</div>
</div>
</div>
<div class="clear"></div>

<div class="tag_box">
 <div>
    <form action="" method="post" class="layui-form">
    <table width="100%" class="table_form" >
		<tr class="admin_table_trbg">
            <th width="220">是否开启：</th>
            <td> 
              <div class="layui-input-block">
                 <div class="layui-input-inline">
                   <input id="sy_msg_isopen_1" type="radio" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_msg_isopen']=='1') {?>checked=""<?php }?> value="1" name="sy_msg_isopen" title="开启" >
                   <input id="sy_msg_isopen_2" type="radio" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_msg_isopen']!='1') {?>checked=""<?php }?> value="2" name="sy_msg_isopen" title="关闭" >
                 </div>
               </div>
			</td>
        </tr>
      
 		<tr>
            <th width="220">短信宝账号：</th>
            <td><input class="tty_input t_w250" type="text" name="sy_msg_appkey" id="sy_msg_appkey" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_msg_appkey'];?>
" size="30"/>  
        </tr>
        <tr class="admin_table_trbg">
            <th width="220">短信宝密码：</th>
            <td><input class="tty_input t_w250" type="password" name="sy_msg_appsecret" id="sy_msg_appsecret" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_msg_appsecret'];?>
" size="50"/>    
        </tr>
        <tr>
            <th width="220">短信宝签名：</th>
            <td><input class="tty_input t_w250" type="text" name="sy_msg_appsing" id="sy_msg_appsing" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_msg_appsing'];?>
" size="50"/>
        </tr>
 		<tr  class="admin_table_trbg">
            <th width="220">单IP每日最大发信：</th>
            <td><input class="tty_input t_w250" type="text" name="ip_msgnum" id="ip_msgnum" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['ip_msgnum'];?>
" size="30" />条</td>
        </tr>
 		
		<tr>
            <th width="220">单手机号每日最大发信：</th>
            <td><input class="tty_input t_w250" type="text" name="moblie_msgnum" id="moblie_msgnum" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['moblie_msgnum'];?>
" size="30" />条</td>
        </tr>
		<tr>
            <th width="220">单手机号认证类短信发送频率：</th>
            <td><input class="tty_input t_w250" type="text" name="cert_msgtime" id="cert_msgtime" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['cert_msgtime'];?>
" size="30"/>分钟</td>
        </tr>
		<tr  class="admin_table_trbg">
            <th width="220" class="t_fr">短信验证码时效：</th>
           	<td>
				<div class="layui-input-block">
					<input class="tty_input t_w250" type="text" name="moblie_codetime" id="moblie_codetime" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['moblie_codetime'];?>
" size="30" maxlength="60"/>分钟 <span class="admin_web_tip">验证码类短信有效时长，建议大于两分钟。</span>
				</div>
				</td>
         </tr>
		 <tr>
            <th width="220">剩余短信数量：</th>
            <td><input class="tty_input t_w250" type="text" name="rest_msgnum" id="rest_msgnum" value="0" disabled="disabled"/>条</td>
        </tr>
		 
         <tr  class="admin_table_trbg">
            <th width="220">购买短信：</th>
            <td><div class="yun_admin_divh"><a href="http://www.smsbao.com/reg?r=11641" target="_blank" style=" color:#CC3300; text-decoration:underline; "> 短信购买地址</a></div></td>
         </tr>
        <!-- 
        <tr>
			 <th colspan="2" class="admin_bold_box">
			 	<div class="admin_bold">空号检测</div>
			 </th>
          </tr>
		  <tr class="admin_table_trbg">
            <th width="220">是否开启：</th>
            <td>
              <div class="layui-input-block">
                 <div class="layui-input-inline">
                   <input id="sy_kh_isopen_1" type="radio" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_kh_isopen']=='1') {?>checked=""<?php }?> value="1" name="sy_kh_isopen" title="开启" >
                   <input id="sy_kh_isopen_2" type="radio" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_kh_isopen']!='1') {?>checked=""<?php }?> value="2" name="sy_kh_isopen" title="关闭" >
				   <span class="admin_web_tip">无效手机号、空号禁止注册发送验证码</span>
                 </div>
               </div>
			</td>
        </tr>
          <tr>
            <th width="220">appKey：</th>
            <td><input class="tty_input t_w250" type="text" name="sy_kh_appkey" id="sy_kh_appkey" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_kh_appkey'];?>
" size="30" maxlength="255"/>  
        </tr>
        <tr class="admin_table_trbg">
            <th width="220">appSecret：</th>
            <td><input class="tty_input t_w250" type="text" name="sy_kh_appsecret" id="sy_kh_appsecret" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_kh_appsecret'];?>
" size="50" maxlength="255"/>    
        </tr>
		<tr  class="admin_table_trbg">
            <th width="220">手机归属地限制：</th>
            <td><input class="tty_input t_w250" type="text" name="sy_kh_city" id="sy_kh_city" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_kh_city'];?>
" size="30"/>
			<span class="admin_web_tip">归属地以外的手机号禁止注册,省市以 / 分隔，多个地区以英文逗号 , 分隔，如：北京,江苏/南京,浙江/杭州  留空则不限制</span>
			</td>

         </tr>
		  <tr>
            <th width="220">剩余检测量：</th>
            <td><input class="tty_input t_w250" type="text" name="rest_khnum" id="rest_khnum" value="0" disabled="disabled"/>条</td>
        </tr>
		 <tr>
			 <th colspan="2" class="admin_bold_box">
			 	<div class="admin_bold">天眼查</div>
			 </th>
          </tr>
		  
          <tr>
            <th width="220">appKey：</th>
            <td><input class="tty_input t_w250" type="text" name="sy_tyc_appkey" id="sy_tyc_appkey" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_tyc_appkey'];?>
" size="30" maxlength="255"/>  
        </tr>
        <tr class="admin_table_trbg">
            <th width="220">appSecret：</th>
            <td><input class="tty_input t_w250" type="text" name="sy_tyc_appsecret" id="sy_tyc_appsecret" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_tyc_appsecret'];?>
" size="50" maxlength="255"/>    
        </tr>
		<tr>
            <th width="220">天眼查数量：</th>
            <td><input class="tty_input t_w250" type="text" name="rest_businessnum" id="rest_businessnum" value="0" disabled="disabled"/>条</td>
        </tr>
		<tr  class="admin_table_trbg">
            <th width="220">购买天眼查：</th>
            <td><div class="yun_admin_divh"><a href="https://u.phpyun.com/" target="_blank" style=" color:#CC3300; text-decoration:underline; "> 购买地址</a></div></td>
         </tr>
  		 <tr>
			<th width="220"></th>
            <td>
				<input class="layui-btn tty_sub" id="config" type="button" name="msgconfig" value="提交" />&nbsp;&nbsp;
				<input class="layui-btn tty_cz" type="reset" value="重置" />
			</td>
        </tr>
		-->
        
    </table>
    <input type="hidden" id="pytoken" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
    </form>

</div>

</div>
</div>
<?php echo '<script'; ?>
> 
layui.use(['layer', 'form'], function(){
    var layer = layui.layer
    ,form = layui.form
    ,$ = layui.$;
});

$(function(){
	$("#config").click(function(){
	
		var msgtime = $("#moblie_codetime").val();
		
		if(parseInt(msgtime) < 2){
			
			parent.layer.msg('短信验证时效因大于两分钟！',2,8); return false;
			
		}else{
			
			loadlayer();
			
			$.post("index.php?m=msgconfig&c=save",{
				config : $("#config").val(),
				sy_msg_isopen : $("input[name=sy_msg_isopen]:checked").val(), 
				sy_msg_appkey :$("#sy_msg_appkey").val(),
				sy_msg_appsecret : $("#sy_msg_appsecret").val(),
				sy_msg_appsing : $("#sy_msg_appsing").val(),


				sy_kh_isopen : $("input[name=sy_kh_isopen]:checked").val(), 
				sy_kh_appkey :$("#sy_kh_appkey").val(),
				sy_kh_appsecret : $("#sy_kh_appsecret").val(),
				sy_kh_city : $("#sy_kh_city").val(),

				sy_tyc_appkey :$("#sy_tyc_appkey").val(),
				sy_tyc_appsecret : $("#sy_tyc_appsecret").val(),
			
				pytoken : $("#pytoken").val(),
				
				sy_msgsendnum : $("#sy_msgsendnum").val(),
				ip_msgnum : $("#ip_msgnum").val(),
				moblie_msgnum : $("#moblie_msgnum").val(),
				cert_msgtime : $("#cert_msgtime").val(),
				moblie_codetime : $("#moblie_codetime").val(),
				integral_msg_proportion : $("#integral_msg_proportion").val()
			},function(data,textStatus){
				parent.layer.closeAll('loading');
				config_msg(data);
			});
			
		}
	});
	
	$.post("index.php?m=msgconfig&c=get_restnums",{pytoken : $("#pytoken").val(),msguser : $("#sy_msguser").val()},function(data){
		data = eval('('+data+')');
	    if(data){
			if(data){
                $("#rest_msgnum").val(data);
			}else{
				$("#rest_msgnum").val(0);
			}
			$("#rest_khnum").val(data.khnum);
			$("#rest_businessnum").val(data.businessnum);
	    }
	});


})
<?php echo '</script'; ?>
>
</div>
</body>
</html>
<?php }} ?>
