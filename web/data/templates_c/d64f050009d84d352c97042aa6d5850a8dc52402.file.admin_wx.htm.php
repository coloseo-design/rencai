<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-06 16:41:16
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_wx.htm" */ ?>
<?php /*%%SmartyHeaderCode:2321462c54aac1fba25-30953069%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd64f050009d84d352c97042aa6d5850a8dc52402' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_wx.htm',
      1 => 1636333429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2321462c54aac1fba25-30953069',
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
  'unifunc' => 'content_62c54aac272970_52672218',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c54aac272970_52672218')) {function content_62c54aac272970_52672218($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
		<link href="images/reset.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
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
		<?php echo '<script'; ?>
>
			var weburl = '<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
';
		<?php echo '</script'; ?>
>
		<link href="images/system.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
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
						<div class="admin_new_tip_list">公众号为认证服务号，到微信公众号平台设置服务器IP白名单</div>
					</div>
				</div>
				<div class="clear"></div>

				<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
				<form name="myform" target="supportiframe" action="index.php?m=wx&c=save" method="post" enctype="multipart/form-data" class="layui-form list_border">
					
					<div class="layui-form-item">
						<div class="list_border_tit">微信公众号设置</div>
					</div>
					
					<div class="layui-form-item">
						<label class="layui-form-label">公众号名称：</label>
						<div class="layui-input-inline t_w480">
							<input class="layui-input" type="text" name="wx_name" id="wx_name" size="30" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['wx_name'];?>
" maxlength="255">
						</div>
						<span class="admin_web_tip">在微信公众平台获取</span>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">URL：</label>
						<div class="layui-input-inline t_w480">
							<input class="layui-input" type="text" disabled="disabled" style="background: #f5f7fb;" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/weixin/index.php">
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">Token：</label>
						<div class="layui-input-inline t_w480">
							<input class="layui-input" type="text" name="wx_token" id="wx_token" size="30" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['wx_token'];?>
" maxlength="255">
						</div>
						<span class="admin_web_tip">自定义填写，需和微信公众平台一致</span>
					</div>
					<div class="layui-form-item pdleft180">
						<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
" />
						<input class="layui-btn tty_sub" id="wxconfig" type="submit" name="msgconfig" value="提交" />&nbsp;&nbsp;
						<input class="layui-btn tty_cz" type="reset" value="重置" />
					</div>

				</form>

				<form name="myform" target="supportiframe" action="index.php?m=wx&c=save" method="post" enctype="multipart/form-data" class="list_border">
					
					<div class="layui-form-item">
						<div class="list_border_tit">开发者凭据</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">AppId：</label>
						<div class="layui-input-inline t_w480">
							<input class="layui-input" type="text" name="wx_appid" id="wx_appid" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['wx_appid'];?>
" size="30" maxlength="255" />
						</div>
						<span class="admin_web_tip">如：1002478x</span>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">AppSecret：</label>
						<div class="layui-input-inline t_w480">
							<input class="layui-input" type="text" name="wx_appsecret" id="wx_appsecret" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['wx_appsecret'];?>
" size="30" maxlength="255" />
						</div>
						<span class="admin_web_tip">如：4dd1c30d472676914f2fbfbnjt</span>
					</div>
					<div class="layui-form-item pdleft180">
						<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
" />
						<input class="layui-btn tty_sub" id="wxconfig" type="submit" name="msgconfig" value="提交" />&nbsp;&nbsp;
						<input class="layui-btn tty_cz" type="reset" value="重置" />
					</div>
					
				</form>

				<form name="myform" target="supportiframe" action="index.php?m=wx&c=save" method="post" enctype="multipart/form-data" class="layui-form list_border">
					<div class="layui-form-item">
						<div class="list_border_tit">体验设置</div>
					</div>
					
					<div class="layui-form-item wx_com wx_com_1">
						<label class="layui-form-label">关注欢迎语：</label>
						<div class="layui-input-inline t_w480">
							<textarea name="wx_welcom" rows="10" cols='40' maxlength="255" class="wx_search_textarea web_text_textarea"><?php echo $_smarty_tpl->tpl_vars['config']->value['wx_welcom'];?>
</textarea>
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">增加欢迎形式：</label>
						<div class="layui-input-block">
							<div class="layui-input-inline t_w480">
								<input type="radio" checked name="wx_welcom_type" value='nowxcom' title="不增加" lay-filter="wxcom">
								<input type="radio" <?php if ($_smarty_tpl->tpl_vars['config']->value['wx_welcom_type']=='wxcompic') {?>checked<?php }?> name="wx_welcom_type" value='wxcompic' title="图片" lay-filter="wxcom">
								<input type="radio" <?php if ($_smarty_tpl->tpl_vars['config']->value['wx_welcom_type']=='wxcomxcx') {?>checked<?php }?> name="wx_welcom_type" value='wxcomxcx' title="小程序" lay-filter="wxcom">
							</div>
							<div class="admin_uppicts">选择小程序，需要在工具-移动端-微信小程序配置封面图、路径等参数，公众号必须关联小程序。</div>
						</div>
					</div>
					<div class="layui-form-item <?php if ($_smarty_tpl->tpl_vars['config']->value['wx_welcom_type']!='wxcompic') {?>none<?php }?>  wxcom wxcompic">
						<label class="layui-form-label">欢迎图：</label>
						<div class="layui-input-inline t_w480">
							<div <?php if (!$_smarty_tpl->tpl_vars['config']->value['sy_wxcom_pic']) {?> class="admin_uppicbox adminupload" lay-data="{name: 'sy_wxcom_pic',imgid: 'imgwxcompic',path:'logo'}"  <?php } else { ?>class="admin_uppicbox " style="width: 200px;height: 300px;" <?php }?>>
								<div class="admin_uppicimg">
									<img width="200" height="300" id="imgwxcompic" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_wxcom_pic'];?>
"
									<?php if (!$_smarty_tpl->tpl_vars['config']->value['sy_wxcom_pic']) {?>class="none"<?php }?>> 
								</div>
								<span <?php if (!$_smarty_tpl->tpl_vars['config']->value['sy_wxcom_pic']) {?>class="none"<?php }?>>
									<button type="button" class="adminupbtn adminupload" lay-data="{name: 'sy_wxcom_pic',imgid: 'imgwxcompic',path:'logo'}">重新上传图片</button>
									
								</span>
							</div>
							<div class="admin_uppicts">图片大小900px * 500px</div>
						</div>
					</div>
					
					<div class="layui-form-item">
						<label class="layui-form-label">搜索提示：</label>
						<div class="layui-input-inline t_w480">
							<textarea name="wx_search" rows="10" cols='40' maxlength="255" class="wx_search_textarea web_text_textarea"><?php echo $_smarty_tpl->tpl_vars['config']->value['wx_search'];?>
</textarea>
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">公众号二维码：</label>
						<div class="layui-input-inline t_w480">
							<div class="admin_uppicbox">
								<input type="hidden" id="layupload_type" value="2" class="admin_uppic_bth2" />
								<div class="admin_uppicimg">
									<img width="140" height="140" id="imgqcode" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_wx_qcode'];?>
"
									<?php if (!$_smarty_tpl->tpl_vars['config']->value['sy_wx_qcode']) {?>class="none"<?php }?>> 
								</div>
								<span <?php if (!$_smarty_tpl->tpl_vars['config']->value['sy_wx_qcode']) {?>class="none"<?php }?>>
									<button type="button" class="adminupbtn adminupload" lay-data="{name: 'sy_wx_qcode',imgid: 'imgqcode',path:'logo'}">重新上传</button>
								</span>
							</div> 
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">微信封面：</label>
						<div class="layui-input-inline t_w480">
							<div class="admin_uppicbox" style="width: 300px;height: 160px;">
								<div class="admin_uppicimg">
									<img width="300" height="160" id="imglogo" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_wx_logo'];?>
"
									<?php if (!$_smarty_tpl->tpl_vars['config']->value['sy_wx_logo']) {?>class="none"<?php }?>> 
								</div>
								<span <?php if (!$_smarty_tpl->tpl_vars['config']->value['sy_wx_logo']) {?>class="none"<?php }?>>
									<button type="button" class="adminupbtn adminupload" lay-data="{name: 'sy_wx_logo',imgid: 'imglogo',path:'logo'}">重新上传封面</button>
									
								</span>
							</div>
							<div class="admin_uppicts">图片大小900px * 500px</div>
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">微信分享图片：</label>
						<div class="layui-input-inline t_w480">
							<div class="admin_uppicbox" style="width:80px;height:80px">
								<div class="admin_uppicimg">
									<img width="80" height="80" id="imgshare" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_wx_sharelogo'];?>
"
									<?php if (!$_smarty_tpl->tpl_vars['config']->value['sy_wx_sharelogo']) {?>class="none"<?php }?>> 
								</div>
								<span <?php if (!$_smarty_tpl->tpl_vars['config']->value['sy_wx_sharelogo']) {?>class="none"<?php }?>>
									<button type="button" class="adminupbtn adminupload" lay-data="{name: 'sy_wx_sharelogo',imgid: 'imgshare',path:'logo'}">重新上传</button>
								</span>
							</div>
							<div class="admin_uppicts">图片大小300px * 300px</div>
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">微信手机登录：</label>
						<div class="layui-input-inline t_w480">
							<div class="layui-input-block">
								<div class="layui-input-inline fl">
									<input type="radio" name="wx_rz" checked value='0' id="wx_rz_11" title="否">
									<input type="radio" <?php if ($_smarty_tpl->tpl_vars['config']->value['wx_rz']=='1') {?>checked<?php }?> name="wx_rz" value='1' id="wx_rz_12"
									 title="是">
								</div>
								<div class="layui-form-mid layui-word-aux" style="margin-left: 20px;">说明：必须为已认证的服务号</div>
							</div>
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">微信PC扫码登录：</label>
						<div class="layui-input-block">
							<div class="layui-input-inline fl">
								<input type="radio" name="wx_author" <?php if ($_smarty_tpl->tpl_vars['config']->value['wx_author']!='1') {?>checked<?php }?> value='0'
								 id="RadioGroup1_11" title="否">
								<input type="radio" <?php if ($_smarty_tpl->tpl_vars['config']->value['wx_author']=='1') {?>checked<?php }?> name="wx_author" value='1'
								 id="RadioGroup1_12" title="是">
							</div>
							<div class="layui-form-mid layui-word-aux" style="margin-left: 20px;">说明：必须为已认证的服务号</div>
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">会员中心二维码弹窗：</label>
						<div class="layui-input-block">
							<div class="layui-input-inline fl">
								<input type="radio" name="wx_popWin" <?php if ($_smarty_tpl->tpl_vars['config']->value['wx_popWin']!='1') {?>checked<?php }?> value='0'
								id="wx_tc_11" title="否">
								<input type="radio" <?php if ($_smarty_tpl->tpl_vars['config']->value['wx_popWin']=='1') {?>checked<?php }?> name="wx_popWin" value='1'
								id="wx_tc_12" title="是">
							</div>
							<div class="layui-form-mid layui-word-aux" style="margin-left: 20px;">说明：必须为已认证的服务号</div>
						</div>
					</div>
					<div class="layui-form-item pdleft180">
						<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
" />
						<input class="tty_sub" id="wxconfig" type="submit" name="msgconfig" value="提交" />&nbsp;&nbsp;
						<input class="tty_cz" type="reset" value="重置" />
					</div>
					
				</form>

			</div>
			<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui.upload.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type='text/javascript'><?php echo '</script'; ?>
>
			<?php echo '<script'; ?>
>
				layui.use(['layer', 'form'], function() {
					var layer = layui.layer,
						form = layui.form,
						$ = layui.$;
						
						form.on('radio(wxcom)', function(data){
						 
						  $('.wxcom').hide();
						  var typeid = data.value;
							$('.'+typeid).show();
						  
						}); 
						
				});
			<?php echo '</script'; ?>
>
	</body>
</html>
<?php }} ?>
