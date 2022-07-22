<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:39:39
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_loginlog.htm" */ ?>
<?php /*%%SmartyHeaderCode:873362d902bbc7cb52-71170964%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '77c9b1bc9669c780785b369172a0313992881103' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_loginlog.htm',
      1 => 1640333834,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '873362d902bbc7cb52-71170964',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'total' => 0,
    'rows' => 0,
    'v' => 0,
    'pagenum' => 0,
    'pages' => 0,
    'pagenav' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d902bbdfd695_00998652',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d902bbdfd695_00998652')) {function content_62d902bbdfd695_00998652($_smarty_tpl) {?><?php if (!is_callable('smarty_function_searchurl')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.searchurl.php';
if (!is_callable('smarty_modifier_date_format')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\modifier.date_format.php';
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
 type="text/javascript">
			function cktimesave() {
				var stime = $("#stime").val();
				var etime = $("#etime").val();
				if (stime && etime && toDate(stime) > toDate(etime)) {
					layer.msg("结束时间必须大于开始时间！", 2, 8);
					return false;
				}
			}
		<?php echo '</script'; ?>
>
		<title>后台管理</title>
	</head>
	<body class="body_ifm">
		<div class="infoboxp">

			<div class="tty-tishi_top">
			<div class="tabs_info">
				<ul>
					<li <?php if ($_GET['utype']=='') {?>class="curr"<?php }?>> <a href="index.php?m=admin_loginlog">个人日志</a></li>
					<li <?php if ($_GET['utype']=="2") {?>class="curr"<?php }?>> <a href="index.php?m=admin_loginlog&utype=2">企业日志</a></li>
					<li <?php if ($_GET['utype']=="3") {?>class="curr"<?php }?>> <a href="index.php?m=admin_loginlog&utype=3">猎头日志</a></li>
					<li <?php if ($_GET['utype']=="4") {?>class="curr"<?php }?>> <a href="index.php?m=admin_loginlog&utype=4">培训日志</a></li>

				</ul>
			</div>
			<div class="clear"></div>
			<div class="admin_new_search_box">
				<form action="index.php" name="myform" method="get" onSubmit="return cktimesave()">
					<input name="utype" value="<?php echo $_GET['utype'];?>
" type="hidden" />
					<input name="m" value="admin_loginlog" type="hidden" />

					<div class="admin_new_search_name">搜索类型：</div>
					<div class="admin_Filter_text formselect" did="dtype">
						<input type="button" <?php if ($_GET['type']=='1'||$_GET['type']=='') {?> value="用户名" <?php } elseif ($_GET['type']=='2') {?> value="内容"<?php } elseif ($_GET['type']=='3') {?> value="用户ID"<?php }?>
						 class="admin_Filter_but" id="btype">
						<input type="hidden" name="type" id="type" <?php if ($_GET['type']==''||$_GET['type']=='1') {?> value="1" <?php } elseif ($_GET['type']=='2') {?> value="2" <?php } elseif ($_GET['type']=='3') {?> value="3" <?php }?>/>
						<div class="admin_Filter_text_box" style="display:none" id="dtype">

							<ul>
								<li>
									<a href="javascript:void(0)" onClick="formselect('1','type','用户名')">用户名</a>
								</li>
								<li>
									<a href="javascript:void(0)" onClick="formselect('2','type','内容')">内容</a>
								</li>
								<li>
									<a href="javascript:void(0)" onClick="formselect('3','type','用户ID')">用户ID</a>
								</li>

							</ul>
						</div>
					</div>
					<input type="text"  placeholder="请输入你要搜索的关键字" name='keyword' class="admin_Filter_search" value="<?php echo $_GET['keyword'];?>
">
					<div class="layui-input-inline" style="float: left;">
						<span class="admin_new_search_name" >时间段：</span>
						<input class="admin_Filter_search t_w200" type="text" autocomplete="off" id="time" value="<?php echo $_GET['time'];?>
" name="time" placeholder="选择时段"/>
						<i class="t_tc_icon_time"></i>
					</div>
					<input class="admin_Filter_bth" type="submit" name="qysearch" value="搜索" />

				

				</form>
				<?php echo $_smarty_tpl->getSubTemplate ("admin/admin_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

			</div>
			<div class="clear"></div>
			</div>

			<div class="tty_table-bom">
			<div class="admin_statistics">
				<span class="tty_sjtj_color">数据统计：</span>
				<em class="admin_statistics_s">总数：<a href="index.php?m=admin_loginlog" class="ajaxloginlogall">0</a></em>				
				搜索结果：<span><?php echo $_smarty_tpl->tpl_vars['total']->value;?>
</span>；
			</div>

			<div class="clear"></div>
			<div class="table-list">
				<div class="admin_table_border">
					<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
					<form action="index.php?m=admin_loginlog" name="myform" method="get" target="supportiframe" id='myform'>

						<input name="m" value="admin_loginlog" type="hidden" />
						<input name="c" value="dellog" type="hidden" />

						<table width="100%">
							<thead>
								<tr class="admin_table_top">
									<th style="width:50px;"><label for="chkall">
											<input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' />
										</label></th>
									<?php if ($_GET['t']=="id"&&$_GET['order']=="asc") {?>
									<th style="width:100px;"><a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'id','m'=>'admin_loginlog','untype'=>'order,t'),$_smarty_tpl);?>
">编号<img
											 src="images/sanj.jpg" /></a></th>
									<?php } else { ?>
									<th style="width:100px;"><a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'id','m'=>'admin_loginlog','untype'=>'order,t'),$_smarty_tpl);?>
">编号<img
											 src="images/sanj2.jpg" /></a></th>
									<?php }?>
									<th style="width:170px;">用户ID</th>
									<th style="width:170px;">用户名</th>
									
									<?php if ($_GET['utype']=='') {?>
										<th style="width:170px;">个人姓名</th>
									<?php } elseif ($_GET['utype']=="2") {?>
										<th style="width:170px;">企业名称</th>
									<?php } elseif ($_GET['utype']=="3") {?>
										<th style="width:170px;">猎头名称</th>
									<?php } elseif ($_GET['utype']=="4") {?>
										<th style="width:170px;">培训机构名称</th>
									<?php }?>
									
									<th style="width:170px;">内容</th>
									<th style="width:170px;">IP</th>
									<th style="width:170px;">端口</th>

									<?php if ($_GET['t']=="ctime"&&$_GET['order']=="asc") {?>
									<th style="width:170px;"><a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'ctime','m'=>'admin_loginlog','untype'=>'order,t'),$_smarty_tpl);?>
">时间<img
											 src="images/sanj.jpg" /></a></th>
									<?php } else { ?>
									<th style="width:170px;"><a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'ctime','m'=>'admin_loginlog','untype'=>'order,t'),$_smarty_tpl);?>
">时间<img
											 src="images/sanj2.jpg" /></a></th>
									<?php }?>
									<th style="width:170px;" class="admin_table_th_bg">操作</th>
								</tr>
							</thead>
							<tbody>
								<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
								<tr align="center" id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
									<td><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="check_all" name='del[]' onclick='unselectall()'
										 rel="del_chk" /></td>
									<td><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</td>
									<td><?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
</td>
									<td><?php echo $_smarty_tpl->tpl_vars['v']->value['username'];?>
</td>
									
									<?php if ($_GET['utype']=='') {?>
									<td><?php echo $_smarty_tpl->tpl_vars['v']->value['rname'];?>
</td>
									<?php } elseif ($_GET['utype']=="2") {?>
									<td><?php echo $_smarty_tpl->tpl_vars['v']->value['comname'];?>
</td>
									<?php } elseif ($_GET['utype']=="3") {?>
									<td><?php echo $_smarty_tpl->tpl_vars['v']->value['ltname'];?>
</td>
									<?php } elseif ($_GET['utype']=="4") {?>
									<td><?php echo $_smarty_tpl->tpl_vars['v']->value['pxname'];?>
</td>
									<?php }?>
									
									<td><?php echo $_smarty_tpl->tpl_vars['v']->value['content'];?>
</td>
									<td><?php echo $_smarty_tpl->tpl_vars['v']->value['ip'];?>
</td>
									<td><?php echo $_smarty_tpl->tpl_vars['v']->value['remoteport'];?>
</td>

									<td class="td"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['ctime'],"%Y-%m-%d %H:%M:%S");?>
</td>
									<td><a href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=admin_loginlog&c=dellog&del=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');"
										 class="admin_new_c_bth admin_new_c_bth_sc">删除</a></td>
								</tr>
								<?php } ?>
								<tr>
									<td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)'/></td>
									<td colspan="9">
										<label for="chkAll2">全选</label>&nbsp;
										<input class="admin_button" type="button" name="delsub" value="删除所选" onclick="return really('del[]')" />
										<?php if ($_GET['utype']=='') {?>
										<input class="admin_submit8" type="button" value="一键删除" onClick="layer_del('确定要清空个人日志？', 'index.php?m=admin_loginlog&c=dellog&del=alluser');" />
										<?php } elseif ($_GET['utype']=="2") {?>
										<input class="admin_submit8" type="button" value="一键删除" onClick="layer_del('确定要清空企业日志？', 'index.php?m=admin_loginlog&c=dellog&del=allcom');" />
										<?php } elseif ($_GET['utype']=="3") {?>
										<input class="admin_submit8" type="button" value="一键删除" onClick="layer_del('确定要清空猎头日志？', 'index.php?m=admin_loginlog&c=dellog&del=alllt');" />
										<?php } elseif ($_GET['utype']=="4") {?>
										<input class="admin_submit8" type="button" value="一键删除" onClick="layer_del('确定要清空培训日志？', 'index.php?m=admin_loginlog&c=dellog&del=alltrain');" />
										<?php }?>
									</td>
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
										<td colspan="7" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</td>
								</tr>
								<?php }?>
							</tbody>
						</table>
						<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
					</form>
				</div>
			</div>
			</div>
		</div>
		<?php echo '<script'; ?>
>
			layui.use(['laydate', 'form'], function() {
				var laydate = layui.laydate,
					form = layui.form,
					$ = layui.$;
				laydate.render({
					elem: '#time',
					range: '~'
				});
			});
			$(document).ready(function(){

				$.get("index.php?m=admin_loginlog&c=loginlogNum&usertype=<?php if ($_GET['utype']) {
echo $_GET['utype'];
} else { ?>1<?php }?>", function(data) {
					console.log(data);
					if(data){
						$('.ajaxloginlogall').html(data);
					}
				});
			});
		<?php echo '</script'; ?>
>
	</body>
</html>
<?php }} ?>
