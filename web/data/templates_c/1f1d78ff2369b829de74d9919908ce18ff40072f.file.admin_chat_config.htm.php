<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 16:11:56
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_chat_config.htm" */ ?>
<?php /*%%SmartyHeaderCode:2812562d90a4c143d50-89858309%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1f1d78ff2369b829de74d9919908ce18ff40072f' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_chat_config.htm',
      1 => 1645279779,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2812562d90a4c143d50-89858309',
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
  'unifunc' => 'content_62d90a4c1fd6e8_79549711',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d90a4c1fd6e8_79549711')) {function content_62d90a4c1fd6e8_79549711($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
	<style type="text/css">
		.layui-form-radio {
			margin-top: 0;
		}
	</style>
	<body class="body_ifm">
		<div class="infoboxp">

			<div class="tty-tishi_top">
				<div class="tag_box">
					<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
					<form id="chatform" class="layui-form" action="index.php?m=admin_chat_config&c=save" method="post" onsubmit="return ckchat()"
					 enctype="multipart/form-data" target="supportiframe">
						<table width="100%" class="table_form">
							<tr>
								<th width="160">聊天开放：待开发</th>
								<td>
									<div class="layui-input-block">
										<input type="checkbox" name="sy_chat_open" lay-skin="switch" lay-text="开放|关闭" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_chat_open']=="1") {?> checked <?php }?> />
									</div>
								</td>
							</tr>
							<!--
							<tr class="admin_table_trbg">
								<th width="160">聊天图标：</th>
								<td>
									<button type="button" class="yun_bth_pic adminupload" lay-data="{name: 'sy_chat_logo',imgid: 'imgicon',path: 'logo',source:'back'}" style="float: none;">上传图片</button>
									<input type="hidden" id="layupload_type" value="2" />
									<img id="imgicon" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_chat_logo'];?>
" style="max-width:100px;width:100px;" <?php if (!$_smarty_tpl->tpl_vars['config']->value['sy_chat_logo']) {?>class="none"<?php }?>> 

								</td> 
							</tr> 
							<tr class="admin_table_trbg">
								<th width="160">个人使用条件：</th>
								<td>
									<div class="layui-input-block">
										<input name="sy_chat_limit" value="1" title="拥有简历" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_chat_limit']=="1") {?> checked <?php }?> type="radio" />
										<input name="sy_chat_limit" value="2" title="申请职位" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_chat_limit']=="2") {?> checked <?php }?> type="radio" />
									</div>
								</td>
							</tr>
							<tr class="admin_table_trbg">
								<th width="160">消费模式：</th>
								<td>
									<div class="layui-input-block">
										<input name="sy_chat_rates" value="1" title="完全免费" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_chat_rates']=="1") {?> checked <?php }?> type="radio" />
										<input name="sy_chat_rates" value="2" title="回复免费" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_chat_rates']=="2") {?> checked <?php }?> type="radio" />
										<input name="sy_chat_rates" value="3" title="回复收费" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_chat_rates']=="3") {?> checked <?php }?> type="radio" />
									</div>
								</td>
							</tr>
							<tr class="admin_table_trbg">
								<th width="160">模式说明：</th>
								<td>
									<div class="layui-input-block">
										<span class="admin_web_tip">完全免费：企业主动发起、回复聊天都免费</span>
										<span class="admin_web_tip">回复免费：企业主动发起聊天要付费，回复聊天免费</span>
										<span class="admin_web_tip">回复收费：企业主动发起、回复聊天都要付费</span>
									</div>
								</td>
							</tr>
							<tr class="admin_table_trbg">
								<th width="160">聊天代替词：</th>
								<td>
									<input name="sy_chat_name" id="sy_chat_name" autocomplete="off" class="tty_input t_w250" type="text" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_chat_name'];?>
" size="20" maxlength="20" />
									<span class="admin_web_tip">如直聊、云聊、沟通</span>
								</td>
							</tr>
							<tr class="admin_table_trbg">
								<th width="160">前端记录展示天数：</th>
								<td>
									<input name="sy_chat_day" id="sy_chat_day" autocomplete="off" class="tty_input t_w250" type="text" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_chat_day'];?>
" size="20" maxlength="20" />
									<span class="admin_web_tip">前端展示聊天历史记录天数，默认30天</span>
								</td>
							</tr>
							<tr class="admin_table_trbg">
								<th width="160">App Key：</th>
								<td>
									<input name="sy_chat_appkey" id="sy_chat_appkey" autocomplete="off" class="tty_input t_w250" type="text" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_chat_appkey'];?>
" size="60" maxlength="50" />
									<span class="admin_web_tip"><a href="https://u.phpyun.com" target="_blank">前往申请聊天秘钥</a></span>
								</td>
							</tr>
							<tr class="admin_table_trbg">
								<th width="160">App Secret：</th>
								<td>
									<input name="sy_chat_appsecret" id="sy_chat_appsecret" autocomplete="off" class="tty_input t_w250" type="text" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_chat_appsecret'];?>
" size="60" maxlength="50" />
								</td>
							</tr>
							<tr class="admin_table_trbg">
								<th width="160">发送位置Key：</th>
								<td>
									<input name="sy_chat_mapkey" id="sy_chat_mapkey" autocomplete="off" class="tty_input t_w250" type="text" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_chat_mapkey'];?>
" size="60" maxlength="50" />
									<span class="admin_web_tip">App和小程序支持发送位置。<span style="color: red">高德地图，添加Key时请选择Web服务，其他Key无效！！！</span><a href="https://lbs.amap.com/api/webservice/guide/create-project/get-key" target="_blank">前往申请</a></span>
								</td>
							</tr>
							<tr>
								<th width="150">服务状态：</th>
								<td>
									<input class="tty_input t_w160" type="text" id="rest_num" value="" readonly="readonly" size="10" />
								</td>
							</tr>
							<tr>
								<th width="160">换电话/微信：</th>
								<td>
									<div class="layui-input-block">
										<input type="checkbox" name="sy_chat_exphone" lay-skin="switch" lay-text="开启|关闭" <?php if (!$_smarty_tpl->tpl_vars['config']->value['sy_chat_exphone']||$_smarty_tpl->tpl_vars['config']->value['sy_chat_exphone']=="2") {?> checked <?php }?> />
									</div>
								</td>
							</tr>
							<tr>
								<th width="160">内容安全检测：</th>
								<td>
									<div class="layui-input-block">
										<input type="checkbox" name="sy_chat_concheck" lay-skin="switch" lay-text="开启|关闭" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_chat_concheck']=="2") {?> checked <?php }?> />
									</div>
								</td>
							</tr>
							<tr class="admin_table_trbg">
								<th width="160"></th>
								<td>
									<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
									<input class="layui-btn tty_sub" id="chatconfig" type="submit" value="提交" />&nbsp;&nbsp;
									<input class="layui-btn tty_cz" type="reset" value="重置" />
								</td>
							</tr>
							-->
						</table>
					</form>
				</div>
			</div>
		</div>
		<?php echo '<script'; ?>
 type="text/javascript">
			var weburl = '<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
';
			layui.use(['layer', 'form'], function() {
				var layer = layui.layer,
					form = layui.form,
					$ = layui.$;
			});
			$(function(){
				var pytoken = $("#pytoken").val();
					$.post("index.php?m=admin_chat_config&c=get_restnum",{pytoken : pytoken},function(data){
						if(data){
							var res = eval('('+data+')');
							if(res.error){
								$("#rest_num").val('不可用');
							}else{
								$("#rest_num").val('可用');
							}
						}
					});
			})
			
			function ckchat() {
				var sy_chat_open = $("input[name=sy_chat_open]").is(":checked") ? 1 : 2,
					sy_chat_name = $("#sy_chat_name").val(),
					sy_chat_day = $("#sy_chat_day").val(),
					sy_chat_appkey = $("#sy_chat_appkey").val(),
					sy_chat_appsecret = $("#sy_chat_appsecret").val();
				if (sy_chat_open == 1) {
					if (sy_chat_name == '') {
						parent.layer.msg("请填写聊天代替词！", 2, 8);
						return false;
					}
					var regPos = /^[0-9]+.?[0-9]*$/;
					if(!regPos.test(sy_chat_day)){
						parent.layer.msg("请填写正确的展示天数！", 2, 8);
						return false;
					}
					if (sy_chat_appkey == '') {
						parent.layer.msg("请填写appkey！", 2, 8);
						return false;
					}
					if (sy_chat_appsecret == '') {
						parent.layer.msg("请填写appsecret！", 2, 8);
						return false;
					}
				}
				loadlayer();
			}
		<?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui.upload.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type='text/javascript'><?php echo '</script'; ?>
>
	</body>
</html>
<?php }} ?>
