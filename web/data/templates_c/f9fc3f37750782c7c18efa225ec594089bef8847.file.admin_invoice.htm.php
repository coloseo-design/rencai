<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-08 16:17:49
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_invoice.htm" */ ?>
<?php /*%%SmartyHeaderCode:384662c7e82d8e20b3-46682011%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f9fc3f37750782c7c18efa225ec594089bef8847' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_invoice.htm',
      1 => 1634883865,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '384662c7e82d8e20b3-46682011',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
    'rows' => 0,
    'key' => 0,
    'job' => 0,
    'total' => 0,
    'pagenum' => 0,
    'pages' => 0,
    'pagenav' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c7e82d9a2c75_98086878',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c7e82d9a2c75_98086878')) {function content_62c7e82d9a2c75_98086878($_smarty_tpl) {?><?php if (!is_callable('smarty_function_searchurl')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.searchurl.php';
if (!is_callable('smarty_modifier_date_format')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\modifier.date_format.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

	<head>
		<title>后台管理</title>
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
		<link href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/css/layui.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet">
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/layui.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/phpyun_layer.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>

		<link href="images/reset.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
		<link href="images/system.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
		<link href="images/table_form.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
	</head>

	<body class="body_ifm">
		<div id="infobox2" style="display:none; width: 500px; ">
			<div id="infobox">
				<form action="index.php?m=invoice&c=status" target="supportiframe" method="post" class="layui-form" onsubmit="return htStatus()">
					<table class="admin_examine_table" cellspacing="1" cellpadding="1" style="width:500px;">
						<tr>
							<th width="80" align="right">状态：</th>
							<td>
								<div class="layui-input-block">
									<div class="layui-input-inline">
										<input type="radio" name="status" value="1" id="status1" title="已审核">
										<input type="radio" name="status" value="2" id="status2" title="未通过">
										<input type="radio" name="status" value="3" id="status3" title="已打印">
										<input type="radio" name="status" value="4" id="status4" title="已邮寄">
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<th width="80" class="t_fr">审核说明：</th>
							<td><textarea id="statusbody" name="statusbody" class="admin_intextarea"></textarea></td>
						</tr>
						<tr align="center">
							<td colspan="2">
								<input type="submit" value='确认' class="admin_examine_bth">
								<input type="button" onClick="layer.closeAll();" class="admin_examine_bth_qx" value='取消'>
							</td>
						</tr>
					</table>
					<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
					<input name="pid" value="0" type="hidden">
				</form>
			</div>
		</div>
		<div class="infoboxp">
			<div class="tty-tishi_top">
				<div class="admin_new_search_box">
					<form action="index.php" name="myform" method="get">
						<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
						<input name="m" value="invoice" type="hidden" />
						<input name="status" value="<?php echo $_GET['status'];?>
" type="hidden" />
						<div class="admin_new_search_name">充值单号：</div>
						<input class="admin_new_text" placeholder="输入你要搜索的关键字" type="text" name="keyword" size="25">
						<input class="admin_Filter_bth" type="submit" name="news_search" value="检索" />
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
						<form action="index.php" name="myform" id='myform' method="get" target="supportiframe">
							<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
							<input name="m" value="invoice" type="hidden" />
							<input name="c" value="del" type="hidden" />
							<table width="100%">
								<thead>
									<tr class="admin_table_top">

										<th style="width:20px;"><label for="chkall"><input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' /></label></th>
										<th> <?php if ($_GET['t']=="id"&&$_GET['order']=="asc") {?>
											<a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'id','m'=>'invoice','untype'=>'order,t'),$_smarty_tpl);?>
">编号<img src="images/sanj.jpg" /></a>
											<?php } else { ?>
											<a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'id','m'=>'invoice','untype'=>'order,t'),$_smarty_tpl);?>
">编号<img src="images/sanj2.jpg" /></a>
											<?php }?>
										</th>

										<th align="left">
											<?php if ($_GET['t']=="addtime"&&$_GET['order']=="asc") {?>
											<a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'addtime','m'=>'invoice','untype'=>'order,t'),$_smarty_tpl);?>
">申请时间<img src="images/sanj.jpg" /></a>
											<?php } else { ?>
											<a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'addtime','m'=>'invoice','untype'=>'order,t'),$_smarty_tpl);?>
">申请时间<img src="images/sanj2.jpg" /></a>
											<?php }?>
										</th>

										<th align="left" width="230">发票抬头</th>
										<th>开票总额 </th>
										<th>开票性质 </th>
										<th align="left">发票申请人</th>
										<th>联系电话</th>
										<th>电子邮箱</th>
										<th>发票状态</th>
										<th>操作</th>
									</tr>
								</thead>
								<tbody>

									<?php  $_smarty_tpl->tpl_vars['job'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['job']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['job']->key => $_smarty_tpl->tpl_vars['job']->value) {
$_smarty_tpl->tpl_vars['job']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['job']->key;
?>
									<tr align="center" <?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg" <?php }?> id="list<?php echo $_smarty_tpl->tpl_vars['job']->value['id'];?>
">
										<td><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['job']->value['id'];?>
" name='del[]' onclick='unselectall()' class="check_all"
											 rel="del_chk" /></td>
										<td align="left" class="td1" style="text-align:center;"><span><?php echo $_smarty_tpl->tpl_vars['job']->value['id'];?>
</span></td>

										<td align="left"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['job']->value['addtime'],"%Y-%m-%d");?>
</td>

										<td align="left">
											<?php echo mb_substr($_smarty_tpl->tpl_vars['job']->value['title'],0,20,"utf-8");?>
 <?php if (strlen($_smarty_tpl->tpl_vars['job']->value['title'])>20) {?>
											<a href="index.php?m=invoice&c=show&id=<?php echo $_smarty_tpl->tpl_vars['job']->value['id'];?>
" class="admin_cz_sc">[查看]</a>
											<?php }?>
										</td>

										<td>￥<?php echo $_smarty_tpl->tpl_vars['job']->value['price'];?>
</td>

										<td><?php if ($_smarty_tpl->tpl_vars['job']->value['style']!='2') {?>纸质（快递）<?php } elseif ($_smarty_tpl->tpl_vars['job']->value['style']=='2') {?>电子（邮箱）<?php }?></td>

										<td align="left"><?php echo $_smarty_tpl->tpl_vars['job']->value['comname'];?>
</td>

										<td><?php echo $_smarty_tpl->tpl_vars['job']->value['link_moblie'];?>
</td>

										<td><?php echo $_smarty_tpl->tpl_vars['job']->value['email'];?>
</td>


										<td><?php if ($_smarty_tpl->tpl_vars['job']->value['status']==1) {?><span class="admin_com_Audited">已审核</span><?php } elseif ($_smarty_tpl->tpl_vars['job']->value['status']=='2') {?><span class="admin_com_tg">未通过</span><?php } elseif ($_smarty_tpl->tpl_vars['job']->value['status']=='3') {?><span class="admin_com_Lock">已打印</span><?php } elseif ($_smarty_tpl->tpl_vars['job']->value['status']=='4') {?><span class="admin_com_Lock">已邮寄</span><?php } elseif ($_smarty_tpl->tpl_vars['job']->value['status']=='0') {?><span class="admin_com_noAudited">未审核</span><?php }?></td>
										<td>
											<a href="index.php?m=invoice&c=show&id=<?php echo $_smarty_tpl->tpl_vars['job']->value['id'];?>
" class="admin_new_c_bth admin_new_c_bth_yl">查看</a>
											<a href="javascript:void(0);" class="status admin_new_c_bth admin_new_c_bthsh" pid="<?php echo $_smarty_tpl->tpl_vars['job']->value['id'];?>
"
											 status="<?php echo $_smarty_tpl->tpl_vars['job']->value['status'];?>
">审核</a>
										</td>
									</tr>
									<?php } ?>
									<tr>
										<td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
										<td colspan="12"><label for="chkAll2">全选</label> &nbsp;
											<input class="admin_button" type="button" name="delsub" value="批量审核" onClick="audall();" />
											<input class="admin_button" type="button" name="delsub" value="批量删除" onClick="return really('del[]')" /></td>
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
											<td colspan="10" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
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
		<div id="showbox" style="display:none; width: 340px; overflow:hidden ">
			<div id="showboxmsg" style="width:320px; padding:10px;height:150px; line-height:25px; font-size:14px; overflow:auto">
			</div>
		</div>
		<?php echo '<script'; ?>
>
			layui.use(['layer', 'form'], function() {
				var layer = layui.layer,
					form = layui.form,
					$ = layui.$;
			});

			function audall() {
				var codewebarr = "";
				$(".check_all:checked").each(function() { //由于复选框一般选中的是多个,所以可以循环输出
					if (codewebarr == "") {
						codewebarr = $(this).val();
					} else {
						codewebarr = codewebarr + "," + $(this).val();
					}
				});
				if (codewebarr == "") {
					parent.layer.msg('您还未选择任何信息！', 2, 8);
					return false;
				} else {
					$("input[name=pid]").val(codewebarr);
					$("#statusbody").val('');
					$("input[name='status']").attr('checked', false);
					$.layer({
						type: 1,
						title: '发票状态审核',
						closeBtn: [0, true],
						border: [10, 0.3, '#000', true],
						area: ['515px', '300px'],
						page: {
							dom: "#infobox2"
						}
					});
				}
			}
			$(function() {
				$(".status").click(function() {
					var pid = $(this).attr("pid");
					var status = $(this).attr("status");
					$("#status" + status).attr("checked", true);
					layui.use(['form'], function() {
						var form = layui.form;
						form.render();
					});
					var pytoken = $("#pytoken").val();
					$("input[name=pid]").val(pid);
					$.post("index.php?m=invoice&c=statusbody", {
						id: pid,
						pytoken: pytoken
					}, function(msg) {
						$("#statusbody").val(msg);
						$.layer({
							type: 1,
							title: '发票状态审核',
							closeBtn: [0, true],
							border: [10, 0.3, '#000', true],
							area: ['515px', '265px'],
							page: {
								dom: "#infobox2"
							}
						});
					});
				});
			});

			function showbox(title, msg) {
				$('#showboxmsg').html(msg);
				$.layer({
					type: 1,
					title: title,
					closeBtn: [0, true],
					border: [10, 0.3, '#000', true],
					area: ['350px', '210px'],
					page: {
						dom: "#showbox"
					}
				});
			}
		<?php echo '</script'; ?>
>
	</body>

</html>
<?php }} ?>
