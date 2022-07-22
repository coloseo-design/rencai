<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-08 16:18:51
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_list_seo.htm" */ ?>
<?php /*%%SmartyHeaderCode:2262362c7e86b173c19-21496783%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '838cbe18781812a9df991a73f548bbd4e6ecb9ad' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_list_seo.htm',
      1 => 1634883866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2262362c7e86b173c19-21496783',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'arr_data' => 0,
    'key' => 0,
    'row' => 0,
    'pytoken' => 0,
    'seolist' => 0,
    'list' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c7e86b1ed427_04485470',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c7e86b1ed427_04485470')) {function content_62c7e86b1ed427_04485470($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\modifier.date_format.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
			function check_type(id,value){
	var val = value=="1"?"0":"1";
	var pytoken=$("#pytoken").val();
	$.post("index.php?m=advertise&c=ajax_check",{id:id,val:val,pytoken:pytoken},function(data){
		html = "<a href=\"javascript:void(0);\" onClick=\"check_type("+id+","+val+");\" >"+data+"</a>";
		$("#"+id).html(html);
	});
}
<?php echo '</script'; ?>
>
		<title>后台管理</title>
	</head>

	<body class="body_ifm">
		<div class="infoboxp">
			<div class="tty-tishi_top">
		 <div class="admin_new_tip " style=" margin-bottom:0px;">
				<div class="admin_new_tit"><i class="admin_new_tit_icon"></i>操作提示</div>
				<div class="admin_new_tip_list_cont">
					<div class="admin_new_tip_list">标题，关键词，网站描述的设置可以使您的网页更容易被搜索到哦~</div>
				</div>
			</div>
			<div class="clear"></div> 

			<div class="admin_new_search_box">
			<div class="seo_sx">
				<span class="seo_sx_name">SEO页面：		</span>
				<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['arr_data']->value['seomodel']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['row']->key;
?>
				<span class="seo_sx_a  <?php if ($_GET['action']==$_smarty_tpl->tpl_vars['key']->value||($_GET['action']==''&&$_smarty_tpl->tpl_vars['key']->value=='index')) {?>seo_sx_cur <?php }?>">
					<a href="index.php?m=seo&action=<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value;?>
</a></span>
				<?php } ?><a href="index.php?m=seo&c=SeoAdd" class="seotj">+ 添加SEO</a>
					</div>
				<div class="clear"></div>
			
			</div>
			<div class="clear"></div>
			</div>

			<div class="tty_table-bom">
			<div class="table-list">

				<div class="tag_box">
					<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
					<form action="index.php" name="myform" method="get" id='myform' target="supportiframe">
						<input type="hidden" name="m" value="seo">
						<input type="hidden" name="c" value="del">
						<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
						<table width="100%">
							<thead>
								<tr class="admin_table_trbg">
									<th bgcolor="#f0f6fb">
										<label for="chkall">
											<input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' />
										</label>
									</th>
									<th bgcolor="#f0f6fb" width="200" align="left">名称</th>
									<th bgcolor="#f0f6fb" align="left">SEO标识符</th>
									<th bgcolor="#f0f6fb" align="left">网页标题</th>
									<th bgcolor="#f0f6fb">更新时间</th>
									<th bgcolor="#f0f6fb">操作</th>
								</tr>
							</thead>
							<tbody>
								<?php  $_smarty_tpl->tpl_vars['list'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['list']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['seolist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['list']->key => $_smarty_tpl->tpl_vars['list']->value) {
$_smarty_tpl->tpl_vars['list']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['list']->key;
?>
								<tr align="left" <?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg"<?php }?> id="list<?php echo $_smarty_tpl->tpl_vars['list']->value['id'];?>
">
									<td align="center"><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['list']->value['id'];?>
" name='del[]' onclick='unselectall()'
										 rel="del_chk" /></td>
									<td width="100px" align="left" class="td1"><span><?php echo $_smarty_tpl->tpl_vars['list']->value['seoname'];?>
</span></td>
									<td align="left" class="ud"><?php echo $_smarty_tpl->tpl_vars['list']->value['ident'];?>
</td>
									<td width="400px" align="left" class="ud"><?php echo $_smarty_tpl->tpl_vars['list']->value['title'];?>
</td>
									<td width="100px" class="ud" align="center"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['list']->value['time'],"%Y-%m-%d");?>
</td>
									<td width="150px" align="center"> <a href="index.php?m=seo&c=SeoAdd&id=<?php echo $_smarty_tpl->tpl_vars['list']->value['id'];?>
" class="admin_new_c_bth">修改</a>
										<a href="javascript:;" onClick="layer_del('确定要删除？','index.php?m=seo&c=del&del=<?php echo $_smarty_tpl->tpl_vars['list']->value['id'];?>
');" class="admin_new_c_bth admin_new_c_bth_sc">删除</a></td>
								</tr>
								<?php } ?>

							</tbody>
						</table>
					</form>
				</div>
			</div>
			</div>
		</div>

	</body>
</html>
<?php }} ?>
