<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:40:59
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_reason_list.htm" */ ?>
<?php /*%%SmartyHeaderCode:1635862d9030b0f6813-76578844%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '20e84872944518095a343ce0137a2c6a8a0be65e' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_reason_list.htm',
      1 => 1634883865,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1635862d9030b0f6813-76578844',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'reason' => 0,
    'key' => 0,
    'v' => 0,
    'total' => 0,
    'pagenum' => 0,
    'pages' => 0,
    'pagenav' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d9030b1b6277_12789953',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d9030b1b6277_12789953')) {function content_62d9030b1b6277_12789953($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
" language="javascript"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
>
			function addreason(){
				$.layer({
					type : 1,
					title :'举报原因', 
					closeBtn : [0 , true],
					border : [10 , 0.3 , '#000', true],
					area : ['320px','auto'],
					offset: ['110px', '35%'],
					page : {dom :"#addreason"}
				});
			}
			function checked_name(){
				var name=$.trim($("#name").val()); 
				if(name==''){ 
					parent.layer.msg('举报原因不能为空！', 2, 8);return false;
				}
			}
			$(document).ready(function(){
				$(".imghide").hover(function(){
					$(this).find('.class_xg').show();
				},function(){
					$(this).find('.class_xg').hide();
				});
			})
		<?php echo '</script'; ?>
>
		<title>后台管理</title>
	</head>
	<body class="body_ifm">
		<div class="infoboxp">
			<div class="tty-tishi_top">
				<div class="admin_new_search_box">
					<a href="javascript:void(0)" onClick="addreason()" class="admin_new_cz_tj" style="margin-left:0px;">+ 添加类别</a>
				</div>
				<div class="clear"></div>
			</div>
			<div class="tty_table-bom">
				<div class="table-list">
					<div class="admin_table_border">
						<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
						<form action="index.php" name="myform" method="get" id='myform' target="supportiframe">
							<table width="100%">
								<thead>
									<tr class="admin_table_top">
										<th style="width:60px;"><label for="chkall"><input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' /></label></th>
										<th style="width:120px;">编号</th>
										<th align="left">标题(点击修改)</th>
										<th class="admin_table_th_bg">操作</th>
									</tr>
								</thead>
								<tbody>
									<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['reason']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
									<tr align="center" <?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg"<?php }?> id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
										<td><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name='del[]' onclick='unselectall()' rel="del_chk" /></td>
										<td align="left" class="td1" style="text-align:center;"><span><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</span></td>
										<td class="od imghide" align="left">
											<span onClick="checkname('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" id="name<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</span>
											<input class="input-text hidden" type="text" id="inputname<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
"
											 onBlur="subname('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','index.php?m=admin_reason&c=ajax');" />
											<img class="" style="padding-left:5px;cursor:pointer;" src="images/xg.png" onClick="checkname('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" />

										</td>
										<td><a href="javascript:void(0)" onClick="layer_del('确定要删除？','index.php?m=admin_reason&c=del&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')"
											 class="admin_new_c_bth admin_new_c_bth_sc">删除</a>
										</td>
									</tr>
									<?php } ?>
									<tr>
										<td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' />
										</td>
										<td colspan="3"><label for="chkAll2">全选</label>&nbsp;
											<input class="admin_button" type="button" name="delsub" value="删除所选" onClick="return really('del[]')" /></td>
									</tr>
									<?php if ($_smarty_tpl->tpl_vars['total']->value>$_smarty_tpl->tpl_vars['config']->value['sy_listnum']) {?>
									<tr>
										<?php if ($_smarty_tpl->tpl_vars['pagenum']->value==1) {?>
										<td colspan="1"> 从 1 到 <?php echo $_smarty_tpl->tpl_vars['config']->value['sy_listnum'];?>
 ，总共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</td>
										<?php } elseif ($_smarty_tpl->tpl_vars['pagenum']->value>1&&$_smarty_tpl->tpl_vars['pagenum']->value<$_smarty_tpl->tpl_vars['pages']->value) {?> <td colspan="1"> 从 <?php echo ($_smarty_tpl->tpl_vars['pagenum']->value-1)*$_smarty_tpl->tpl_vars['config']->value['sy_listnum']+1;?>
 到 <?php echo $_smarty_tpl->tpl_vars['pagenum']->value*$_smarty_tpl->tpl_vars['config']->value['sy_listnum'];?>
 ，总共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</td>
											<?php } elseif ($_smarty_tpl->tpl_vars['pagenum']->value==$_smarty_tpl->tpl_vars['pages']->value) {?>
											<td colspan="1"> 从 <?php echo ($_smarty_tpl->tpl_vars['pagenum']->value-1)*$_smarty_tpl->tpl_vars['config']->value['sy_listnum']+1;?>
 到 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 ，总共
												<?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</td>
											<?php }?>
											<td colspan="3" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</td>
									</tr>
									<?php }?>
								</tbody>
							</table>
							<input type="hidden" name="m" value="admin_reason">
							<input type="hidden" name="c" value="del">
							<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
						</form>
					</div>
				</div>
			</div>
		</div>
		<div id="addreason" style="display:none;margin-top: 10px;">

			<div class="job_box_div">
				<div class="job_box_inp">
					<form action="index.php" name="myform" method="get" onSubmit="return checked_name();" target="supportiframe">
						<input name="m" value="admin_reason" type="hidden" />
						<input name="c" value="save" type="hidden" />
						<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
						<table cellspacing='1' cellpadding='1' class="admin_examine_table">
							<tr>
								<th width="80">原因：</th>
								<td>
									<input class="layui-input t_w200" type="text" name="name" id='name' size="55" style="float:left" value="">
								</td>
							</tr>
							<tr>
								<td colspan='2' align="center" class='ui_content_wrap'><input class="admin_examine_bth" type="submit" value="添加 " /></td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
<?php }} ?>
