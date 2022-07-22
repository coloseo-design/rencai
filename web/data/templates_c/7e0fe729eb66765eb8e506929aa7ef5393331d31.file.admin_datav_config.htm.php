<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 17:28:49
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_datav_config.htm" */ ?>
<?php /*%%SmartyHeaderCode:2287962d91c51389a62-21764305%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7e0fe729eb66765eb8e506929aa7ef5393331d31' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_datav_config.htm',
      1 => 1634883865,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2287962d91c51389a62-21764305',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'url' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d91c5140cec4_60331650',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d91c5140cec4_60331650')) {function content_62d91c5140cec4_60331650($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
 src="../js/jquery-1.8.0.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
		<link href="../js/layui/css/layui.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
		<?php echo '<script'; ?>
 src="../js/layui/layui.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="../js/layui/phpyun_layer.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="js/admin_public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/javascript"><?php echo '</script'; ?>
>
		<title>后台管理</title>
	</head>
	<body class="body_ifm">
		<div class="infoboxp">
			<div class="tty-tishi_top">

				<div class="clear"></div>

				<style type="text/css">
					.layui-form-switch {
						margin-top: 0;
					}
				</style>

				<div>
					<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
					<div class="datav_tit">实时数据大屏</div>
					<form  class="layui-form">
						<div class="datav_box">
							<div class="datav_list"><span class="datav_list_name">大屏域名 </span><div class="datav_list_in">
							
						<input name="sy_datavurl" id="sy_datavurl" autocomplete="off" class="layui-input" type="text" value="<?php if ($_smarty_tpl->tpl_vars['config']->value['sy_datavurl']) {
echo $_smarty_tpl->tpl_vars['config']->value['sy_datavurl'];
} else {
echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/datav<?php }?>" size="50" />	
						</div><div class=""><span class="admin_web_tip">默认为网站域名用于生成预览连接</span></div>
						</div> 
						<div class="datav_list"><span class="datav_list_name">预览地址 </span>
						<div class="datav_list_in_n">
							<input name="datavurl" id="datavurl" autocomplete="off" value="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
" readonly class="datav_list_in_ninput" type="text" />	<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
							<input class="datav_list_bth " type="button" onclick="seturl();"  value="生成地址" style="right: -295px;" />
							<input class="datav_list_bth " type="button" onclick="toDatav();"  value="预览" />
							<input class="datav_list_bth_fz " type="button" onclick="copyurl();" value="复制链接" /> 
						</div>
							
								
									</div>
						<div class="datav_list">
						<div class="datav_list_zdy">
							<div class="datav_list_zdy_name">可自定义大屏数据</div>
							<div class="datav_list_zdy_p">大屏数据=网站数据+自定义基数</div>
							<input class="datav_list_zdy_bth" type="button" onclick="diydatav();" value="自定义大屏数据" />	
						</div>
						<div class=""><span class="admin_web_tip">注：建议屏幕分辨率不低于1920*1080</span></div>
						
						 </div><div class="datav_list"><div class="datav_box_img"></div>	</div>
							</div>
					</form>
				</div>
			</div>
		</div>
		<?php echo '<script'; ?>
>
			layui.use(['layer', 'form'], function() {
				var layer = layui.layer,
					form = layui.form,
					$ = layui.$;
			});
			function copyurl() {
				var value = document.querySelector('#datavurl');
				value.select(); // 选择对象

				if (document.execCommand("copy")) {
					document.execCommand("copy");
					layer.msg('已复制');
				};
			}
			function seturl(mode){
				parent.layer.confirm("生成新地址将导致原地址失效，继续生成？", function() {
					
					var pytoken = $("#pytoken").val();
					var url = $("#sy_datavurl").val();
					loadlayer();
					$.post('index.php?m=admin_datav_config&c=seturl', {
						url: url,
						pytoken: pytoken
					}, function(data) {
						parent.layer.closeAll();
						var data = eval('(' + data + ')');
						if(data.err=='1'){
							var _url = data.url;
							$('#datavurl').val(_url);
							if(mode=='todatav'){
								window.open(_url);
							}
						}else{
							parent.layer.msg('参数错误！', 2, 8);
							return false;
						}
					});
				});
			}
			function toDatav(){
				var url = $('#datavurl').val();
				if(url){
					window.open(url);
				}else{
					seturl('todatav');
					
				}

			}
			function diydatav(){
				$.layer({
					type: 2,
					shadeClose: true,
					title: '自定义基数',
					area: [($(window).width() - 30) +'px', ($(window).height() - 30) +'px'],
					iframe: {src: 'index.php?m=admin_datav_config&c=diyData'},
					close: function(){
						
						$('body').css('overflow-y', '');
						
					}
				});
			}
		<?php echo '</script'; ?>
>

	</body>
</html>
<?php }} ?>
