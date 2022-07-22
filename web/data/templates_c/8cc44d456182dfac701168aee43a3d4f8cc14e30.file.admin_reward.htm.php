<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-06 16:22:01
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_reward.htm" */ ?>
<?php /*%%SmartyHeaderCode:2171162c54629735be9-21688619%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8cc44d456182dfac701168aee43a3d4f8cc14e30' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_reward.htm',
      1 => 1634883866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2171162c54629735be9-21688619',
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
  'unifunc' => 'content_62c54629836c97_24716865',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c54629836c97_24716865')) {function content_62c54629836c97_24716865($_smarty_tpl) {?><?php if (!is_callable('smarty_function_searchurl')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.searchurl.php';
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
		<title>后台管理</title>
	</head>
	<body class="body_ifm">
		<div class="infoboxp">
			
			<div class="tty-tishi_top">
			<div class="admin_new_search_box">
				<form action="index.php" name="myform" method="get">
					<input name="m" value="reward" type="hidden" />
					<div class="admin_new_search_name">搜索类型：</div>

					<div class="admin_Filter_text formselect" did="dctype">
						<input type="button" <?php if ($_GET['ctype']=='2') {?> value="兑换<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
"
						 <?php } else { ?> value="商品名称" <?php }?> class="admin_Filter_but" id="bctype">
						<input type="hidden" name="ctype" id="ctype" />
						<div class="admin_Filter_text_box" style="display:none" id="dctype">
							<ul>
								<li><a href="javascript:void(0)" onClick="formselect('1','ctype','商品名称')">商品名称</a></li>
								<li><a href="javascript:void(0)" onClick="formselect('2','ctype','兑换<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
')">兑换<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
</a></li>
							</ul>
						</div>
					</div>
					<input type="text" placeholder="输入你要搜索的关键字" value="<?php echo $_GET['keyword'];?>
" name='keyword' class="admin_Filter_search">
					<input type="submit" name='search' value="搜索" class="admin_Filter_bth">
					<a href="javascript:void(0)" onclick="$('.admin_screenlist_box').toggle();" class="admin_new_search_gj">高级搜索</a>
					<a href="index.php?m=reward&c=add" class="admin_new_cz_tj">+ 添加商品</a>
				</form>
				<?php echo $_smarty_tpl->getSubTemplate ("admin/admin_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

			</div>
			<div class="clear"></div>
			</div>

			<div class="tty_table-bom">
			<div class="table-list">
				<div class="admin_table_border">
					<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
					<form action="index.php" name="myform" method="get" id='myform' target="supportiframe">
						<input type="hidden" name="m" value="reward">
						<input type="hidden" name="c" value="del">
						<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
						<table width="100%">
							<thead>
								<tr class="admin_table_top">
									<th width="5%"><label for="chkall">
											<input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' />
										</label></th>
									<th> <?php if ($_GET['t']=="id"&&$_GET['order']=="asc") {?> <a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'id','m'=>'reward','untype'=>'order,t'),$_smarty_tpl);?>
">编号<img
											 src="images/sanj.jpg" /></a> <?php } else { ?> <a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'id','m'=>'reward','untype'=>'order,t'),$_smarty_tpl);?>
">编号<img
											 src="images/sanj2.jpg" /></a> <?php }?> </th>
									<th align="left">商品名称</th>
									<th>类别</th>
									<th>兑换<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
</th>
									<th>限购数量</th>
									<th>库存</th>
									<th>排序</th>
									<th>状态</th>
									<th>推荐</th>
									<th>热门</th>
									<th class="admin_table_th_bg" width="120">操作</th>
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
									<td align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</td>
									<td><?php echo $_smarty_tpl->tpl_vars['v']->value['classname'];?>
</td>
									<td><?php echo $_smarty_tpl->tpl_vars['v']->value['integral'];?>
</td>
									<td><?php if ($_smarty_tpl->tpl_vars['v']->value['restriction']=="0") {?>不限<?php } else {
echo $_smarty_tpl->tpl_vars['v']->value['restriction'];
}?></td>
									<td><?php echo $_smarty_tpl->tpl_vars['v']->value['stock'];?>
</td>
									<td><?php echo $_smarty_tpl->tpl_vars['v']->value['sort'];?>
</td>
									<td id="status<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php if ($_smarty_tpl->tpl_vars['v']->value['status']=="1") {?><a href="javascript:void(0);" onClick="rec_up('index.php?m=reward&c=status','<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','0','status');"><img
											 src="../config/ajax_img/doneico.gif"></a><?php } else { ?><a href="javascript:void(0);" onClick="rec_up('index.php?m=reward&c=status','<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','1','status');"><img
											 src="../config/ajax_img/errorico.gif"></a><?php }?></td>
									<td id="rec<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php if ($_smarty_tpl->tpl_vars['v']->value['rec']=="1") {?><a href="javascript:void(0);" onClick="rec_up('index.php?m=reward&c=rec','<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','0','rec');"><img
											 src="../config/ajax_img/doneico.gif"></a><?php } else { ?><a href="javascript:void(0);" onClick="rec_up('index.php?m=reward&c=rec','<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','1','rec');"><img
											 src="../config/ajax_img/errorico.gif"></a><?php }?></td>
									<td id="hot<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php if ($_smarty_tpl->tpl_vars['v']->value['hot']=="1") {?><a href="javascript:void(0);" onClick="rec_up('index.php?m=reward&c=hot','<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','0','hot');"><img
											 src="../config/ajax_img/doneico.gif"></a><?php } elseif ($_smarty_tpl->tpl_vars['v']->value['hot']=="0") {?><a href="javascript:void(0);"
										 onClick="rec_up('index.php?m=reward&c=hot','<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','1','hot');"><img src="../config/ajax_img/errorico.gif"></a><?php }?></td>
									<td><a href="index.php?m=reward&c=add&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="admin_new_c_bth admin_n_sc mt5">修改</a> <a
										 href="javascript:void(0)" class="admin_new_c_bth admin_new_c_bth_sc" onClick="layer_del('确定要删除？', 'index.php?m=reward&c=del&del=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');">删除</a></td>
								</tr>
								<?php } ?>
								<tr>
									<td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
									<td colspan="11"><label for="chkAll2">全选</label>
										&nbsp;
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
										<td colspan="9" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</td>
								</tr>
								<?php }?>
							</tbody>
						</table>
					</form>
				</div>
			</div>
			</div>
		</div>
		</div>
		<div id="bg" class="admin_bg"></div>
	</body>
</html>
<?php }} ?>
