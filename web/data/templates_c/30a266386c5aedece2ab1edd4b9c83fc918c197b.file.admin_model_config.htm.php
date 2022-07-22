<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-08 16:09:13
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_model_config.htm" */ ?>
<?php /*%%SmartyHeaderCode:513262c7e629800b99-41740271%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '30a266386c5aedece2ab1edd4b9c83fc918c197b' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_model_config.htm',
      1 => 1634883865,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '513262c7e629800b99-41740271',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'newModel' => 0,
    'mconfig' => 0,
    'key' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c7e6298f9d34_47268012',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c7e6298f9d34_47268012')) {function content_62c7e6298f9d34_47268012($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
		<title>后台管理</title>
		<?php echo '<script'; ?>
>
			function tip(id){
				layer.tips('关闭模块后请在导航设置中对相应导航作隐藏或删除处理！', '#'+id,{time:2,guide: 2,style: ['background-color:#5EA7DC; color:#fff;top:-7px', '#5EA7DC']});
				$(".xubox_layer").addClass("xubox_tips_border");
			}
		<?php echo '</script'; ?>
>
	</head>
	<style>
		.table_border{
			border-collapse: separate;
			border-spacing: 0px 0px;
			margin-top: 5px;
		}
		.table_form tr{
			display: block;
			height: 56px;
			line-height: 56px;
			border-bottom: 1px solid #e8eaec;
		}
		.table_border input{
			height: 32px;
		}
		.table_form tbody td{
		}
		.navset{width: 74px;height: 22px;border: 1px solid #dcdee2;color: #515a6e;border-radius: 2px;background: #fff;}
	</style>
	<body class="body_ifm">
		<div class="infoboxp">
			<div class="tty-tishi_top">
				<div class="admin_new_tip">
					<a href="javascript:;" class="admin_new_tip_close"></a>
					<a href="javascript:;" class="admin_new_tip_open" style="display:none;"></a>
					<div class="admin_new_tit"><i class="admin_new_tit_icon"></i>操作提示</div>
					<div class="admin_new_tip_list_cont">
						<div class="admin_new_tip_list">如果关闭模块，请对系统->导航管理里面删除或取消显示！</div>
					</div>
				</div>
				<div class="clear"></div>

				<div class="tag_box">
					<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
					<form name="myform" target="supportiframe" action="index.php?m=model_config&c=save" method="post" onsubmit="return checkForm()" class="layui-form">
						<table width="100%" class="table_form table_border">
							<tr class="admin_table_trbg" bgcolor="#f8f8f9" style="height: 44px;line-height: 44px;color: #515a6e;">
								<td width="160" bgcolor="#f0f6fb" align="left"><span class="">模块名称</span></td>
								<td width="170" bgcolor="#f0f6fb" align="left"><span class="">状态</span></td>
								<td width="450" bgcolor="#f0f6fb" align="left"><span class="">二级域名（默认HTTP，未绑定则留空）</span></td>
								<td width="230" bgcolor="#f0f6fb" align="left"><span class="">指向目录</span></td>
								<td width="250" bgcolor="#f0f6fb" align="left"><span class="">综合设置</span></td>
							</tr>
							<?php  $_smarty_tpl->tpl_vars['mconfig'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['mconfig']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['newModel']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['mconfig']->key => $_smarty_tpl->tpl_vars['mconfig']->value) {
$_smarty_tpl->tpl_vars['mconfig']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['mconfig']->key;
?>
							<tr class="admin_com_td_bg">
								<td width="160"><?php echo $_smarty_tpl->tpl_vars['mconfig']->value['value'];?>
：</td>
								<td width="153">
									<div class="layui-input-inline">
										<input type="checkbox"  lay-skin="primary" lay-filter="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" title="开启" <?php if ($_smarty_tpl->tpl_vars['mconfig']->value['web']=="1") {?>checked<?php }?> value='1' />
										<input type="hidden" name="sy_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
_web" id="sy_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
_web" value='<?php echo $_smarty_tpl->tpl_vars['mconfig']->value['web'];?>
' />
									</div>
								</td>
								<td width="450">

									<div class="layui-input-inline">
										<div class="layui-input-inline" style="float:left;width: 94px;margin-right: 5px;">
										    <select name="sy_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
ssl">
										        <option value="1" <?php if ($_smarty_tpl->tpl_vars['mconfig']->value['ssl']=="1") {?>selected<?php }?>>https://</option>
										        <option value="0" <?php if ($_smarty_tpl->tpl_vars['mconfig']->value['ssl']!="1") {?>selected<?php }?>>http://</option>
										    </select>
										</div>
										
										<div class="layui-input-inline">
											<input name="sy_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
domain" autocomplete="off" class="layui-input" type="text" value="<?php echo $_smarty_tpl->tpl_vars['mconfig']->value['domain'];?>
"
											 size="30" maxlength="255" />
										</div>
									</div>
								</td>

								<td width="230">
									<div class="layui-input-inline">
										<input name="sy_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
dir" autocomplete="off" class="layui-input" type="text" value="<?php echo $_smarty_tpl->tpl_vars['mconfig']->value['dir'];?>
" size="20" maxlength="255" />
									</div>
								</td>
								<td width="250">
									<?php if ($_smarty_tpl->tpl_vars['key']->value!='error') {?>
									<input type='button' value='导航设置' class='navset btn_nav' data-config='<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
' data-name='<?php echo $_smarty_tpl->tpl_vars['mconfig']->value['value'];?>
'>
									<input type='button' value='SEO设置' class="navset btn_seo" data-config='<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
'>
									<?php }?>
								</td>
							</tr>
							<?php } ?>
							<input type="hidden" value="company" name="sy_companydir">
							<tr class="admin_com_td_bg">
								<th>&nbsp;</th>
								<td colspan="3" align="left">
									<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
									<input class="tty_sub" type="submit" name="config" value="保存" />&nbsp;&nbsp;
									<input class="tty_cz" type="reset" value="重置" />
								</td>
							</tr>
						</table>
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
				
					'<?php  $_smarty_tpl->tpl_vars['mconfig'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['mconfig']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['newModel']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['mconfig']->key => $_smarty_tpl->tpl_vars['mconfig']->value) {
$_smarty_tpl->tpl_vars['mconfig']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['mconfig']->key;
?>'
						form.on('checkbox(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
)', function(data){
							if(data.elem.checked){
								$("#sy_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
_web").val('1');
 							}else{
								$("#sy_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
_web").val('2');
							}
						});
					'<?php } ?>'
			});

			$(function() {
				$('.btn_nav').click(function() {
					var config = $(this).attr('data-config');
					var name = $(this).attr('data-name');
					layer.open({
						type: 2,
						title: '设置导航',
						content: 'index.php?m=model_config&c=setnav&config=' + config + '&name=' + name,
						skin: 'layui-layer-molv',
						maxmin: true,
						area: ['900px', '450px']
					});
				}); 

				$('.btn_seo').click(function() {
					var config = $(this).attr('data-config');
					layer.open({
						type: 2,
						title: '设置SEO',
						content: 'index.php?m=model_config&c=setseo&config=' + config,
						skin: 'layui-layer-lan',
						maxmin: true,
						area: ['900px', '450px'],
						moveOut: true
					});
				}); 
			});
			function checkForm(){
				loadlayer();
			}
		<?php echo '</script'; ?>
>

	</body>
</html>
<?php }} ?>
