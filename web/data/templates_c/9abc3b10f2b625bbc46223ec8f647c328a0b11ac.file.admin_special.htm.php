<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-08 16:17:51
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_special.htm" */ ?>
<?php /*%%SmartyHeaderCode:83262c7e82f6103b9-48680803%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9abc3b10f2b625bbc46223ec8f647c328a0b11ac' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_special.htm',
      1 => 1634883866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '83262c7e82f6103b9-48680803',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
    'rows' => 0,
    'key' => 0,
    'v' => 0,
    'total' => 0,
    'pagenum' => 0,
    'pages' => 0,
    'pagenav' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c7e82f6bd7d1_77472765',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c7e82f6bd7d1_77472765')) {function content_62c7e82f6bd7d1_77472765($_smarty_tpl) {?><?php if (!is_callable('smarty_function_searchurl')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.searchurl.php';
if (!is_callable('smarty_function_url')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.url.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="js/admin_public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
		<link href="images/reset.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
		<link href="images/system.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
		<link href="images/table_form.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
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
	</head>
	<body class="body_ifm">
		<div class="infoboxp">
			<div class="tty-tishi_top">
			<div class="admin_new_search_box">
				<form action="index.php" name="myform" method="get">
					<input name="m" value="special" type="hidden" />
					<div class="admin_new_search_name">搜索专题：</div>
					<input class="admin_Filter_search" placeholder="输入你要搜索的关键字" type="text" name="keyword" size="25" style=" float:left">
					<input class="admin_Filter_bth" type="submit" name="news_search" value="检索" />
				</form>
				<a href="index.php?m=special&c=add" class="admin_new_cz_tj" style=" margin-left:10px;">+ 添加专题</a>
				<?php echo $_smarty_tpl->getSubTemplate ("admin/admin_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

			</div>
			<div class="clear"></div>
			</div>

			<div class="tty_table-bom">
			<div class="table-list">
				<div class="admin_table_border">
					<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
					<form action="index.php" name="myform" method="get" id='myform' target="supportiframe">
						<input name="m" value="special" type="hidden" />
						<input name="c" value="del" type="hidden" />
						<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
						<table width="100%">
							<thead>
								<tr class="admin_table_top">
									<th style="width:20px;"><label for="chkall"><input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' /></label></th>
									<th>编号</th>
									<th align="left">专题名称</th>
									<th align="left">企业数量</th>
									<th align="left">模板</th>
									<th>状态</th>

									<th width="100">
										<?php if ($_GET['t']=="sort"&&$_GET['order']=="asc") {?> 
										<a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'sort','m'=>'special','untype'=>'order,t'),$_smarty_tpl);?>
">排序(大在前)<img src="images/sanj.jpg" /></a> 
										<?php } else { ?> 
										<a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'sort','m'=>'special','untype'=>'order,t'),$_smarty_tpl);?>
">排序(大在前)<img src="images/sanj2.jpg" /></a> 
										<?php }?> 
									</th>
									<th>待审核企业数/企业总数</th>
									<th width="180">操作</th>
								</tr>
							</thead>
							<tbody>

								<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
								<tr align="center" <?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg"<?php }?> id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
									<td><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name='del[]' onclick='unselectall()' rel="del_chk" /></td>

									<td><span><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</span></td>
									<td align="left"><a href="<?php echo smarty_function_url(array('m'=>'special','c'=>'show','id'=>$_smarty_tpl->tpl_vars['v']->value['id']),$_smarty_tpl);?>
" target="_blank" style="color:#01AAED"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</a></td>
									<td align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['limit'];?>
</td>
									<td align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['tpl'];?>
</td>
									<td>
										<div class="admin_new_t_j" id="rec_display<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
											<?php if ($_smarty_tpl->tpl_vars['v']->value['display']=="1") {?>
											<a href="javascript:void(0);" onClick="rec_display('index.php?m=special&c=recommend','<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','0','rec_display');">
												<img src="../config/ajax_img/doneico.gif"></a>
											<?php } else { ?>
											<a href="javascript:void(0);" onClick="rec_display('index.php?m=special&c=recommend','<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','1','rec_display');">
												<img src="../config/ajax_img/errorico.gif"></a>
											<?php }?>
										</div>
									</td>

									<td class="ud"><input class="layui-input" style="width:50px;" type="text" name="sort" id="sort" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['sort'];?>
" onblur="setOrder(<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
,this.value)"></td>
									<td>
										<font color="red"><?php if ($_smarty_tpl->tpl_vars['v']->value['booking']) {
echo $_smarty_tpl->tpl_vars['v']->value['booking'];
} else { ?>0<?php }?></font>/<?php if ($_smarty_tpl->tpl_vars['v']->value['comnum']) {
echo $_smarty_tpl->tpl_vars['v']->value['comnum'];
} else { ?>0<?php }?>
										<div class="mt5"><a href='index.php?m=special&c=com&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
' class="admin_company_xg_icon">查看</a></div>
									</td>
									<td>
										<a href="index.php?m=special&c=add&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="admin_new_c_bth ">编辑</a>
										<a href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=special&c=del&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');"
										 class="admin_new_c_bth admin_new_c_bth_sc"> 删除</a></td>

								</tr>
								<?php } ?>
								<tr>
									<td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
									<td>
										<label for="chkAll2">全选</label>&nbsp;
										<input class="admin_button" type="button" name="delsub" value="删除所选" onclick="return really('del[]')" /></td>
								</tr>
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
							</tbody>

						</table>
					</form>
				</div>
			</div>
			</div>
			<?php echo '<script'; ?>
>
				function rec_display(url, id, rec, type) {
					var pytoken = $("#pytoken").val();
					$.get(url + "&id=" + id + "&rec=" + rec + "&type=" + type + "&pytoken=" + pytoken, function(data) {
						if (data == 1) {
							if (rec == "1") {
								$("#" + type + id).html("<a href=\"javascript:void(0);\" onClick=\"rec_display('" + url + "','" + id +
									"','0','" + type + "');\"><img src=\"../config/ajax_img/doneico.gif\"></a>");
							} else {
								$("#" + type + id).html("<a href=\"javascript:void(0);\" onClick=\"rec_display('" + url + "','" + id +
									"','1','" + type + "');\"><img src=\"../config/ajax_img/errorico.gif\"></a>");
							}
						}
					});
				}


				//排序设置
				function setOrder(id,sort){
					var pytoken=$("#pytoken").val();

					$.post("index.php?m=special&c=setOrder",{id:id,sort:sort,pytoken:pytoken},function(data){


					});


				}

			<?php echo '</script'; ?>
>
	</body>
</html>
<?php }} ?>
