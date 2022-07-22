<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:07:17
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_spview_list.htm" */ ?>
<?php /*%%SmartyHeaderCode:1387562d8fb2569b4c3-27698623%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ceb1b54545b8ad97ee82d0fffe3318c6c2f8d9c2' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_spview_list.htm',
      1 => 1634883866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1387562d8fb2569b4c3-27698623',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'rows' => 0,
    'v' => 0,
    'total' => 0,
    'pagenum' => 0,
    'pages' => 0,
    'pagenav' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d8fb2586c152_10546059',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d8fb2586c152_10546059')) {function content_62d8fb2586c152_10546059($_smarty_tpl) {?><?php if (!is_callable('smarty_function_searchurl')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.searchurl.php';
if (!is_callable('smarty_function_url')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.url.php';
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

				<div class="clear"></div>

				<div class="admin_new_search_box">
					<form action="index.php" name="myform" method="get">
						<input name="m" value="admin_spview" type="hidden" />
						<input type="hidden" name="status" value="<?php echo $_GET['status'];?>
" />
						<div class="admin_new_search_name">搜索类型：</div>
						<div class="admin_Filter_text formselect" did='dtype'>
							<input type="button" value="<?php if ($_GET['type']=='1'||$_GET['type']=='') {?>用户ID<?php } else { ?>企业名称<?php }?>"
							 class="admin_Filter_but" id="btype">
							<input type="hidden" id='type' value="<?php if ($_GET['type']) {
echo $_GET['type'];
} else { ?>1<?php }?>"
							 name='type'>
							<div class="admin_Filter_text_box" style="display:none" id='dtype'>
								<ul>
									<li><a href="javascript:void(0)" onClick="formselect('1','type','用户ID')">用户ID</a></li>
									<li><a href="javascript:void(0)" onClick="formselect('2','type','企业名称')">企业名称</a></li>
								</ul>
							</div>
						</div>
						<input class="admin_Filter_search" type="text" name="keyword" maxlength="25" placeholder="请输入您要搜索的关键字">
						<input class="admin_Filter_bth" type="submit" name="news_search" value="搜索" />
						<a href="javascript:void(0)" onclick="$('.admin_screenlist_box').toggle();" class="admin_new_search_gj">高级搜索</a>
					</form>
					<?php echo $_smarty_tpl->getSubTemplate ("admin/admin_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

				</div>
				<div class="clear"></div>
			</div>

			<div class="tty_table-bom">
				<div class="table-list">
					<div class="admin_table_border">
						<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
						<form action="index.php?m=admin_spview&c=del" name="myform" method="post" target="supportiframe" id='myform'>
							<table width="100%">
								<thead>
									<tr class="admin_table_top">
										<th>
											<label for="chkall">
												<input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' />
											</label>
										</th>
										<th> <?php if ($_GET['t']=="id"&&$_GET['order']=="asc") {?> <a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'id','m'=>'admin_spview','untype'=>'order,t'),$_smarty_tpl);?>
">ID<img
											 src="images/sanj.jpg" /></a> <?php } else { ?> <a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'id','m'=>'admin_spview','untype'=>'order,t'),$_smarty_tpl);?>
">ID<img
											 src="images/sanj2.jpg" /></a> <?php }?> </th>
										<th> <?php if ($_GET['t']=="uid"&&$_GET['order']=="asc") {?> <a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'uid','m'=>'admin_spview','untype'=>'order,t'),$_smarty_tpl);?>
">用户ID<img
											 src="images/sanj.jpg" /></a> <?php } else { ?> <a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'uid','m'=>'admin_spview','untype'=>'order,t'),$_smarty_tpl);?>
">用户ID<img
											 src="images/sanj2.jpg" /></a> <?php }?> </th>
										<th align="left">企业名称</th>
										<th align="center">
											<?php if ($_GET['t']=="starttime"&&$_GET['order']=="asc") {?>
												<a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'starttime','m'=>'admin_spview','untype'=>'order,t'),$_smarty_tpl);?>
">开始时间
													<img src="images/sanj.jpg" /></a>
											<?php } else { ?>
												<a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'starttime','m'=>'admin_spview','untype'=>'order,t'),$_smarty_tpl);?>
">开始时间<img src="images/sanj2.jpg" /></a>
											<?php }?>
										</th>
										
										<th width="200" align="left">参与职位</th>
										<th width="70" align="center">预约简历</th>
										
										<th width="70">审核状态</th>
										<th width="70">房间状态</th>

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
									<tr align="center" id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
										<td >
											<input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="check_all" name='del[]' onclick='unselectall()' rel="del_chk" />
										</td>
										<td class="ud">	<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</td>
										<td class="ud">	<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
</td>
										<td class="ud" align="left">
										
											<div class="mt10"><?php echo $_smarty_tpl->tpl_vars['v']->value['name_n'];?>
</div>
										</td>
										
										<td class="od" align="center"><?php echo $_smarty_tpl->tpl_vars['v']->value['sdate_n'];?>
</td>
										
										<td align="left" ><?php echo $_smarty_tpl->tpl_vars['v']->value['jobname'];?>
</td>
										<td align="center" >
											<?php if ($_smarty_tpl->tpl_vars['v']->value['subnum']) {
echo $_smarty_tpl->tpl_vars['v']->value['subnum'];
} else { ?>0<?php }?> 

											<div><a href="index.php?m=admin_spview&c=spresume&sid=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="color: #03A9F4;">查看</a></div>
										</td>
										
										<td align="center" >
											<?php if ($_smarty_tpl->tpl_vars['v']->value['status']==1) {?>
												<span class="admin_com_Audited">已审核</span>
											<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['status']==0) {?>
												<span class="admin_com_noAudited">未审核</span>
											<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['status']==2) {?>
												<span class="admin_com_tg">未通过</span>
											<?php }?>
										</td>
										<td align="center" >
											<?php if ($_smarty_tpl->tpl_vars['v']->value['roomstatus']==1) {?>
												<span class="admin_com_tg">关闭</span>
											<?php } else { ?>
												<span class="admin_com_Audited">启用</span>
											<?php }?>
										</td>
										<td>
											<a href="<?php echo smarty_function_url(array('m'=>'spview','c'=>'show','id'=>$_smarty_tpl->tpl_vars['v']->value['id'],'look'=>'admin'),$_smarty_tpl);?>
" target="_blank" class="admin_new_c_bth admin_new_c_bth_yl">预览</a>
											<a href="javascript:;" class="status admin_new_c_bth admin_new_c_bthsh" pid="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" status='<?php echo $_smarty_tpl->tpl_vars['v']->value['status'];?>
'>审核</a>
											<br/>
											<a href="index.php?m=admin_spview&c=add&uid=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="admin_new_c_bth mt5">修改</a>
											<a href="javascript:void(0)" onClick="layer_del('确定要删除？','index.php?m=admin_spview&c=del&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');"
											 class="admin_new_c_bth admin_new_c_bth_sc mt5">删除</a>
										</td>
									</tr>
									<?php } ?>
									<tr>
										<td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
										<td colspan="9">
											<label for="chkAll2">全选</label>&nbsp;
											<input class="admin_button" type="button" name="delsub" value="删除所选" onclick="return really('del[]')" />
										</td>
									</tr>
									<?php if ($_smarty_tpl->tpl_vars['total']->value>$_smarty_tpl->tpl_vars['config']->value['sy_listnum']) {?>
									<tr>
										<?php if ($_smarty_tpl->tpl_vars['pagenum']->value==1) {?>
										<td colspan="5"> 从 1 到 <?php echo $_smarty_tpl->tpl_vars['config']->value['sy_listnum'];?>
 ，总共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</td>
										<?php } elseif ($_smarty_tpl->tpl_vars['pagenum']->value>1&&$_smarty_tpl->tpl_vars['pagenum']->value<$_smarty_tpl->tpl_vars['pages']->value) {?> <td colspan="5">
											从 <?php echo ($_smarty_tpl->tpl_vars['pagenum']->value-1)*$_smarty_tpl->tpl_vars['config']->value['sy_listnum']+1;?>
 到 <?php echo $_smarty_tpl->tpl_vars['pagenum']->value*$_smarty_tpl->tpl_vars['config']->value['sy_listnum'];?>
 ，总共
											<?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条
											</td>
											<?php } elseif ($_smarty_tpl->tpl_vars['pagenum']->value==$_smarty_tpl->tpl_vars['pages']->value) {?>
											<td colspan="5">
												从 <?php echo ($_smarty_tpl->tpl_vars['pagenum']->value-1)*$_smarty_tpl->tpl_vars['config']->value['sy_listnum']+1;?>
 到 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 ，总共<?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条
											</td>
											<?php }?>
											<td colspan="7" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</td>
									</tr>
									<?php }?>
								</tbody>
							</table>
							<input type="hidden" name="pytoken" id="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
						</form>
					</div>
				</div>
			</div>
		</div>
		
		<div id="status_div" style="display:none; ">
			<form action="index.php?m=admin_spview&c=status" target="supportiframe" method="post" class="layui-form" onsubmit="return htStatus()">
				<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
				<table cellspacing='1' cellpadding='1' class="admin_examine_table">
					<tr>
						<th width="100">审核操作：</th>
						<td align="left">
								<div class="layui-input-block">
									<input type="radio" name="status" id="status1" value="1" title="正常">
									<div class="layui-unselect layui-form-radio"><i class="layui-anim layui-icon"></i><span>正常</span></div>
									<input type="radio" name="status" id="status2" value="2" title="未通过">
									<div class="layui-unselect layui-form-radio"><i class="layui-anim layui-icon"></i><span>未通过</span></div>
								</div>
						</td>
					</tr>
					<tr>
						<th class="t_fr">审核说明：</th>
						<td align="left"> <textarea id="alertcontent" name="statusbody" class="admin_explain_textarea"></textarea></td>
					</tr>
					<tr>
						<td colspan='2' align="center">
							<div class="admin_Operating_sub" style="padding-bottom:20px;">
								<input name="pid" value="0" type="hidden">
								<input type="submit" value='确认' class="admin_examine_bth">
								<input type="button" onClick="layer.closeAll();" class="admin_examine_bth_qx" value='取消'>
							</div>
						</td>
					</tr>
				</table>
			</form>
		</div>

		<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['adminstyle']->value)."/checkdomain.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


		<?php echo '<script'; ?>
 type="text/javascript">
			layui.use(['layer', 'form'], function() {
				var layer = layui.layer,
					form = layui.form,
					$ = layui.$;
			});

			$(function() {
				$(".status").click(function() {
					var id = $(this).attr("pid");
					$("input[name=pid]").val($(this).attr("pid"));
					var status = $(this).attr("status");
					

					if (status != '1') {

						var pytoken = $("#pytoken").val();
						$.post("index.php?m=admin_spview&c=lockinfo", {
							id: id,
							pytoken: pytoken
						}, function(msg) {
							$("#alertcontent").val(msg);
						});
					}
					
					$("#status" + status).attr("checked", true);
					add_class('视频面试审核', '380', 'auto', '#status_div', '');
					layui.use(['form'], function() {
						form = layui.form;
						form.render();
					});
				});
			});
		
		<?php echo '</script'; ?>
>
		<style>
			.admin_new_c_bth {
				color: #999;
				font-size: 12px;
			}
		</style>
	</body>
</html>
<?php }} ?>
