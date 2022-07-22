<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-08 16:15:12
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_hr_adddoc.htm" */ ?>
<?php /*%%SmartyHeaderCode:3175362c7e790e224a2-24874165%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a08a2bd01ecf22346e394e367eb4712ac71b8553' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_hr_adddoc.htm',
      1 => 1634883866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3175362c7e790e224a2-24874165',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
    'row' => 0,
    't_class' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c7e790eaf266_78244105',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c7e790eaf266_78244105')) {function content_62c7e790eaf266_78244105($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
		<link href="images/reset.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
		<link href="images/system.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
		<link href="images/table_form.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
		<link href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/css/layui.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
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
		<?php echo '<script'; ?>
> var weburl = '<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
';<?php echo '</script'; ?>
>

		<title>后台管理</title>
		
		<style>
		* {margin: 0 ;padding: 0;}
		body,div{ margin: 0 ;padding: 0;}

		.layui-form-item {
			margin-bottom: 0px;
			clear: both;
		}
		</style>
	</head>

	<body class="body_ifm">
		<div class="infoboxp"> 
			<div class="tty-tishi_top">
			<div class="admin_new_tip">
				<a href="javascript:;" class="admin_new_tip_close"></a>
				<a href="javascript:;" class="admin_new_tip_open" style="display:none;"></a>
				<div class="admin_new_tit"><i class="admin_new_tit_icon"></i>操作提示</div>
				<div class="admin_new_tip_list_cont">
					<div class="admin_new_tip_list">管理员可以上传企业HR相关常用文档表格，提供用户下载使用！可以提升网站用户粘贴性。</div>
				</div>
			</div>

				<iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe> 
				<form name="myform" target="supportiframe" action="index.php?m=hr&c=save" method="post" onSubmit="return cksubmit()" class="layui-form" enctype="multipart/form-data">
					<table width="100%" class="table_form" style="background:#fff;">
						<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
						<input class="input-text" name="yurl" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['url'];?>
"/> 
						<input class="input-text" name="url" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['url'];?>
" id='url'/> 
						
						<tr class="admin_table_trbg">
							<th colspan="4" class="admin_bold_box">
								<div class="admin_bold">添加文档</div>
							</th>
						</tr>
						
						<tr>
							<th>文档名称：</th>
							<td>
								<div class="layui-input-block t_w480">
								  <input type="text" name="name" id="name"  lay-verify="required" placeholder="请输入文档名称" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
" autocomplete="off" class="layui-input">
								</div>
							</td>
						</tr>

						<tr>
							<th>文档类别：</th>
							<td>
								<div class="layui-input-inline t_w480">
									<select name="cid">
										<?php if ($_smarty_tpl->tpl_vars['row']->value['cid']) {?>
											<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['t_class']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
												<?php if ($_smarty_tpl->tpl_vars['v']->value['id']==$_smarty_tpl->tpl_vars['row']->value['cid']) {?>
													<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" selected><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
												<?php } else { ?>
													<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" ><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
												<?php }?>
											<?php } ?>
										<?php } else { ?>
											<option value="">请选择</option>
										<?php }?>
										
										<?php if (!$_smarty_tpl->tpl_vars['row']->value['cid']) {?>
											<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['t_class']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
												<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
											<?php } ?>
										<?php }?>
									</select>
								</div>
							</td>
						</tr>

						<tr>
							<th>是否显示：</th>
							<td>
								<div class="layui-form-item">
									<div class="layui-input-block">
										<input type="hidden" name="is_show" id="is_show" value="<?php if ($_smarty_tpl->tpl_vars['row']->value['is_show']) {?>1<?php } else { ?>0<?php }?>"/>
										<input type="checkbox" lay-skin="switch" lay-text="是|否" lay-filter="swiId" <?php if ($_smarty_tpl->tpl_vars['row']->value['is_show']=="1") {?>checked<?php }?> />
									</div>
								</div> 
							</td>
						</tr>

						<tr>
							<th>上传文档：</th>
							<td>
 								<button type="button" class="layui-btn layui-btn-normal noupload">选择文档</button>
								<input type="hidden" id="laynoupload" value="1"/> 
								<input type="hidden" id="layfiletype" value="2"/>
							</td>
						</tr>

						<tr>
                        <th>&nbsp;</th>
							<td align="left" >
								<?php if (is_array($_smarty_tpl->tpl_vars['row']->value)) {?> 
									<input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
">	
									<input class="layui-btn tty_sub" type="submit" name="submit" value="&nbsp;修 改&nbsp;" />
								<?php } else { ?>
									<input class="layui-btn tty_sub" type="submit" name="submit" value="&nbsp;添 加&nbsp;" />
								<?php }?>

								<input class="layui-btn tty_cz" type="reset" name="reset" value="&nbsp;重 置 &nbsp;" />
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>

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
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui.upload.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type='text/javascript'><?php echo '</script'; ?>
>
 

		<?php echo '<script'; ?>
 language="javascript">
			layui.use(['layer', 'form','element'], function(){
				var layer = layui.layer
					,form = layui.form
					,element = layui.element
					,$ = layui.$;

				form.on('switch(swiId)', function(data){
					if(this.checked){
						$('#is_show').val(1);
					}else{
						$('#is_show').val(0);
					}
				});
			});
		 
			function cksubmit(){
				var name=$.trim($("#name").val());
 				if(name==''){parent.layer.msg("文档名称不能为空！",2,8);return false;}


 			}
		<?php echo '</script'; ?>
>

	</body>

</html><?php }} ?>
