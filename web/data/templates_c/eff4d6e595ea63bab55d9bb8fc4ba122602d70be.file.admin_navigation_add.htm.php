<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:22:08
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_navigation_add.htm" */ ?>
<?php /*%%SmartyHeaderCode:2949862d8fea09c2d13-64999993%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'eff4d6e595ea63bab55d9bb8fc4ba122602d70be' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_navigation_add.htm',
      1 => 1634883865,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2949862d8fea09c2d13-64999993',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'type' => 0,
    'v' => 0,
    'types' => 0,
    'lasturl' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d8fea0aa08f9_62266283',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d8fea0aa08f9_62266283')) {function content_62d8fea0aa08f9_62266283($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
		<?php echo '<script'; ?>
 language="javascript">
			function checkform(myform){
  if (myform.name.value=="") {
    parent.layer.msg('请填写导航名称！', 2,8); 
      myform.name.focus();
      return (false);
  }
   if (myform.url.value=="") { 
    parent.layer.msg('请填写链接地址！', 2,8); 
      myform.url.focus();
      return (false);
  }
  if (myform.sort.value=="") { 
     parent.layer.msg('请填写导航排序！', 2,8); 
      myform.sort.focus();
      return (false);
  }
}
<?php echo '</script'; ?>
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
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui.upload.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type='text/javascript'><?php echo '</script'; ?>
>

		<title>后台管理</title>
	</head>
	<body class="body_ifm">
		<div class="infoboxp">
			<div class="tty-tishi_top">
				<div class="admin_new_search_box">
					<a href=" javascript:history.back(-1);" class="admin_new_cz_tj" style="margin-left:0px;">导航列表</a>
				</div>
			</div>

			<div class="tty_table-bom">
				<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
				<form name="myform" target="supportiframe" action="index.php?m=navigation&c=save" method="post" encType="multipart/form-data"
				 onSubmit="return checkform(this);" class="layui-form">
					<table width="100%" class="table_form" style="background:#fff;">
						<tr>
							<th colspan="2" class="admin_bold_box">
								<div class="admin_bold">添加导航</div>
							</th>
						</tr>
						<tr>
							<th width="120">导航类别：</th>
							<td>
								<div class="layui-input-inline t_w480 fl">
									<select name="nid" lay-filter="nid">
										<option value="">请选择</option>
										<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['type']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['types']->value['nid']&&$_smarty_tpl->tpl_vars['v']->value['id']==$_smarty_tpl->tpl_vars['types']->value['nid']) {?> selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['typename'];?>

										</option> <?php } ?> 
									</select> 
								</div> 
								<a href="index.php?m=navigation&c=group" class="admin_nav_fl">添加分类</a>
							</td>
						</tr>
						<tr class="admin_table_trbg">
							<th>导航名称：</th>
							<td>
								<input class="tty_input t_w480" type="text" name="name" size="40" value="<?php echo $_smarty_tpl->tpl_vars['types']->value['name'];?>
" placeholder="请输入导航名称"/>
								<input type="hidden" name='color' id="color" value="" />
							</td>
						</tr>
						<tr class="admin_table_trbg">
							<th>导航链接：</th>
							<td>
								<input class="tty_input t_w480" type="text" name="url" size="50" value="<?php echo $_smarty_tpl->tpl_vars['types']->value['url'];?>
"  placeholder="请输入导航链接"/>
							</td>
						</tr>
						<tr>
							<th>伪静态链接：</th>
							<td>
								<input class="tty_input t_w480" type="text" name="furl" size="50" value="<?php echo $_smarty_tpl->tpl_vars['types']->value['furl'];?>
"  placeholder="请输入伪静态链接"/>
							</td>
						</tr>
						<tr class="admin_table_trbg">
							<th class="t_fr">导航类型：</th>
							<td>
								<div class="layui-input-block t_w480">
									<select name="type" lay-filter="type">
										<option value="1" <?php if ($_smarty_tpl->tpl_vars['types']->value['type']==1) {?> selected <?php }?>>站内链接 </option> 
										<option value="2" <?php if ($_smarty_tpl->tpl_vars['types']->value['type']==2) {?> selected <?php }?>>外部链接 </option> 
									</select> 
								</div> 
								<span class="admin_web_tip">站内链接如：job/ 外部链接如：http://www.phpyun.com/job/</span>
							</td>
						</tr>
						<tr>
							<th class="t_fl">导航图标：</th>
							<td>
								<div class="layui-input-block">
									<div class="admin_uppicbox">
										<input type="hidden" id="laynoupload" value="1">
									
										<div class="admin_uppicimg">
											<img id="imgicon" src="<?php echo $_smarty_tpl->tpl_vars['types']->value['pic_n'];?>
" class="<?php if (!$_smarty_tpl->tpl_vars['types']->value['pic_n']) {?>none<?php }?>"
											 width="140" height="140" />
										</div>
									
										<span>
											<button type="button" class="noupload adminupbtn" lay-data="{imgid: 'imgicon'}">重新上传</button>		
										</span>
									</div>

								</div>
								<span class="admin_web_tip">仅限于wap端首页导航展示</span>
							</td>
						</tr>
						<tr>
							<th>排　　序：</th>
							<td>
								<input class="tty_input t_w480" type="text" name="sort" size="5" value="<?php echo $_smarty_tpl->tpl_vars['types']->value['sort'];?>
" placeholder="排列顺序"/>
							</td>
						</tr>
						<tr class="admin_table_trbg">
							<th>弹出窗口：</th>
							<td>
								<div class="layui-input-block">
									<input name="eject" value="1" title="新窗口" <?php if ($_smarty_tpl->tpl_vars['types']->value['eject']=="1") {?> checked <?php }?> type="radio" />
									<input name="eject" value="0" title="原窗口" <?php if ($_smarty_tpl->tpl_vars['types']->value['eject']!="1") {?> checked <?php }?> type="radio" />
								</div>
							</td>
						</tr>
						<tr>
							<th>状　　态：</th>
							<td>
								<div class="layui-input-block">
									<input name="model" value="hot" title="热" <?php if ($_smarty_tpl->tpl_vars['types']->value['model']=="hot") {?> checked <?php }?> type="radio" />
									<input name="model" value="new" title="新" <?php if ($_smarty_tpl->tpl_vars['types']->value['model']=="new") {?> checked <?php }?> type="radio" />
									<input name="model" value="" title="无" <?php if ($_smarty_tpl->tpl_vars['types']->value['model']=='') {?> checked <?php }?> type="radio" />
								</div>
							</td>
						</tr>

						<tr>
							<th>显　　示：</th>
							<td>
								<div class="layui-input-block">
									<input name="display" value="1" title="是" <?php if ($_smarty_tpl->tpl_vars['types']->value['display']=="1") {?> checked <?php }?> type="radio" />
									<input name="display" value="0" title="否" <?php if ($_smarty_tpl->tpl_vars['types']->value['display']!="1") {?> checked <?php }?> type="radio" />
								</div>
							</td>
						</tr>
						<tr class="admin_table_trbg">
							<th></th>
							<td> <?php if ($_smarty_tpl->tpl_vars['types']->value['id']) {?>
								<input type="hidden" name="id" size="40" value="<?php echo $_smarty_tpl->tpl_vars['types']->value['id'];?>
" />
								<input type="hidden" name="lasturl" value="<?php echo $_smarty_tpl->tpl_vars['lasturl']->value;?>
">
								<input class="tty_sub" type="submit" name="update" value="&nbsp;更 新&nbsp;" />
								<?php } else { ?>
								<input class="tty_sub" type="submit" name="add" value="&nbsp;添 加&nbsp;" />&nbsp;&nbsp;&nbsp;
								<?php }?>
								<input class="tty_cz" type="reset" name="reset" value="&nbsp;重 置 &nbsp;" /></td>
						</tr>
					</table>
					<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
				</form>
			</div>
		</div>
		<?php echo '<script'; ?>
 type="text/javascript">
			layui.use(['layer', 'form'], function() {
				var layer = layui.layer,
					form = layui.form,
					$ = layui.$;
			});
		<?php echo '</script'; ?>
>
	</body>
</html>
<?php }} ?>
