<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-08 16:14:58
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_evaluate_group.htm" */ ?>
<?php /*%%SmartyHeaderCode:1537562c7e78272c050-49331593%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1c6ab15163a3db66a5b23398a0cb009dd4d0b70c' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_evaluate_group.htm',
      1 => 1634883866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1537562c7e78272c050-49331593',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
    'evaluate_group' => 0,
    'v' => 0,
    'key' => 0,
    'total' => 0,
    'pagenum' => 0,
    'pages' => 0,
    'pagenav' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c7e7827ca522_11282186',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c7e7827ca522_11282186')) {function content_62c7e7827ca522_11282186($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
 src="js/admin_public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
>
			function check_form(){
	var classname = $.trim($("#classname").val());
	if(classname==""){ 
		parent.layer.msg("类别名称不能为空！",2,8);
		return false; 
	}
}	 
function change_f(){
	var f_id=$("#f_id").val();
	if(f_id=='0'){
		$("#is_rec").show();
	}else{$("#is_rec").hide();} 
}

<?php echo '</script'; ?>
>
		<title>后台管理-测评类别管理</title>
	</head>
	<body class="body_ifm">
		<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>


		<div id="houtai_div" style="display:none;margin-top: 10px;">
			<form name="myform" target="supportiframe" action="index.php?m=admin_evaluate&c=addgroup" method="post" onSubmit="return check_form();">
				<table class="admin_examine_table" style="width:100%">
					<tbody>
						<tr class="ui_td_11">
							<th>类别名称：</th>
							<td>
								<input type="text" name="classname" value="" id="classname" class="layui-input t_w200"/>
							</td>
						</tr>
						<tr class="ui_td_11">
							<td class="ui_content_wrap" colspan='2' style="border-bottom:none">
								<input class="admin_Filter_bth" type="submit" name="sub" value=" 添加 " style="float: none;"/>
							</td>
						</tr>
					</tbody>
				</table>
				<input type="hidden" name="pytoken" id="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
			</form>
		</div>

		<div class="infoboxp">
			
			<div class="tty-tishi_top">

			<div class="admin_new_search_box">
				<a href="index.php?m=admin_evaluate" class="admin_new_cz_tj" style="width:98px; margin-left:0px;">+ 测评试卷列表</a>
				<a href="index.php?m=admin_evaluate&c=examup" class="admin_new_cz_tj">+ 添加试卷</a>
				<a href="javascript:void(0);" onClick="add_class('添加类别','300','auto','#houtai_div','')" class="admin_new_cz_tj">+
					添加类别</a>
			</div>
			<div class="clear"></div>
			</div>

			<div class="tty_table-bom">
			<div class="table-list" style="min-height:300px;">
				<div class="admin_table_border">
					<?php if (empty($_GET['id'])) {?>

					<form action="index.php" name="myform" method="get" target="supportiframe" id='myform'>
						<input name="m" value="admin_evaluate" type="hidden" />
						<input name="c" value="delgroup" type="hidden" />

						<table width="100%" style="text-align: center;">
							<thead>
								<tr class="admin_table_top">
									<th>编号</th>
									<th align="left" width="200">类别名称<span class="clickup">(点击修改)</span></th>
									<th>记录数</th>
									<th>排序<span class="clickup">(点击修改)</span></th>
									<th width="80" class="admin_table_th_bg">操作</th>
								</tr>
							</thead>
							<tbody>

								<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['evaluate_group']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
								<?php if ($_smarty_tpl->tpl_vars['v']->value['keyid']==0) {?>
								<tr align="center" <?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg"<?php }?>> <td><span><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</span></td>
									<td class="ud" align="left"><span onClick="checkname('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" id="name<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</span>
										<input class="input-text hidden" type="text" id="inputname<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
"
										 onBlur="subname('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','index.php?m=admin_evaluate&c=ajax');" />
										<img class="" style="padding-left:5px;cursor:pointer;" title="" src="images/xg.png" onClick="checkname('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" />
									</td>
									<td class="od">
										共有试卷 <font color="#0033FF">
											<?php if ($_smarty_tpl->tpl_vars['v']->value['count']!=0) {?>
											<?php echo $_smarty_tpl->tpl_vars['v']->value['count'];?>

											<?php } else { ?>
											0
											<?php }?></font> 篇</td>
									<td><span onClick="checksort('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" id="sort<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['v']->value['sort'];?>
</span>
										<input class="input-text hidden" type="text" id="input<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" size="10" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['sort'];?>
"
										 onBlur="subsort('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" />
										<img class="" style="padding-left:5px;cursor:pointer;" title="" src="images/xg.png" onClick="checksort('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" />
									</td>
									<td><a href="javascript:void(0)" class="admin_new_c_bth admin_new_c_bth_sc" onClick="layer_del('删除该分组，将删除该分组下的所有的试卷，确定要删除吗？', 'index.php?m=admin_evaluate&c=delgroup&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');">删除</a></td>
								</tr>
								<?php }?>
								<?php } ?>
								<?php if ($_smarty_tpl->tpl_vars['total']->value>$_smarty_tpl->tpl_vars['config']->value['sy_listnum']) {?>
								<tr>
									<?php if ($_smarty_tpl->tpl_vars['pagenum']->value==1) {?>
									<td colspan="3"> 从 1 到 <?php echo $_smarty_tpl->tpl_vars['config']->value['sy_listnum'];?>
 ，总共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</td>
									<?php } elseif ($_smarty_tpl->tpl_vars['pagenum']->value>1&&$_smarty_tpl->tpl_vars['pagenum']->value<$_smarty_tpl->tpl_vars['pages']->value) {?> <td colspan="3"> 从 <?php echo ($_smarty_tpl->tpl_vars['pagenum']->value-1)*$_smarty_tpl->tpl_vars['config']->value['sy_listnum']+1;?>
 到 <?php echo $_smarty_tpl->tpl_vars['pagenum']->value*$_smarty_tpl->tpl_vars['config']->value['sy_listnum'];?>
 ，总共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</td>
										<?php } elseif ($_smarty_tpl->tpl_vars['pagenum']->value==$_smarty_tpl->tpl_vars['pages']->value) {?>
										<td colspan="3"> 从 <?php echo ($_smarty_tpl->tpl_vars['pagenum']->value-1)*$_smarty_tpl->tpl_vars['config']->value['sy_listnum']+1;?>
 到 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 ，总共
											<?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</td>
										<?php }?>
										<td colspan="5" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</td>
								</tr>
								<?php }?>
						</table>

					</form>
					<?php }?>


				</div>
				<style>
					.admin_new_c_bth {
						color: #999;
						font-size: 12px;
					}
				</style>
			</div>
		</div>
	</body>
</html>
<?php }} ?>
