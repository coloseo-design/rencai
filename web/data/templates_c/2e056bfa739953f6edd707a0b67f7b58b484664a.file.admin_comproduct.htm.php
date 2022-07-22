<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:39:48
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_comproduct.htm" */ ?>
<?php /*%%SmartyHeaderCode:2194662d902c405d0f6-60241113%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2e056bfa739953f6edd707a0b67f7b58b484664a' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_comproduct.htm',
      1 => 1634883866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2194662d902c405d0f6-60241113',
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
  'unifunc' => 'content_62d902c4131ee8_54964150',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d902c4131ee8_54964150')) {function content_62d902c4131ee8_54964150($_smarty_tpl) {?><?php if (!is_callable('smarty_function_searchurl')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.searchurl.php';
if (!is_callable('smarty_modifier_date_format')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\modifier.date_format.php';
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
 type="text/javascript" src="js/admin_public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
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
		<title>后台管理</title>
	</head>
	<body class="body_ifm">
	
		<div id="status_div" style="display:none; ">
			<div>
				<form class="layui-form" action="index.php?m=productnews&c=prostatus" target="supportiframe" method="post" onsubmit="return htStatus()">
					<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
					<table cellspacing='1' cellpadding='1' class="admin_examine_table">
						<tr>
							<th width="80">审核操作：</th>
							<td align="left">
								<div class="layui-input-block">
									<input name="status" id="status1" value="1" title="正常" type="radio" />
									<input name="status" id="status2" value="2" title="未通过" type="radio" />
								</div>
							</td>
						</tr>
						<tr>
							<th class="t_fr">审核说明：</th>
							<td><textarea id="alertcontent" name="statusbody" class="admin_explain_textarea"></textarea></td>
						</tr>
						<tr>
							<td colspan='2' align="center">
								<input type="submit" value='确认' class="admin_examine_bth">
								<input type="button" onClick="layer.closeAll();" class="admin_examine_bth_qx" value='取消'>
							</td>
						</tr>
					</table>
					<input name="id" value="0" type="hidden">
				</form>
			</div>
		</div>
		<div class="infoboxp">
			<div class="tabs_info">
				<ul>
					<li class="curr"> <a href="index.php?m=productnews" class="report_uaer_list_on">企业产品</a></li>
					<li ><a href="index.php?m=productnews&c=comnews" >企业新闻</a></li>
				</ul>
			</div>
			
			<div class="tty-tishi_top">
			<div class="clear"></div>
			<div class="admin_new_search_box">
				<form action="index.php" name="myform" method="get">
					<input name="m" value="productnews" type="hidden" />
					<input type="hidden" name="status" value="<?php echo $_GET['status'];?>
" />
					<div class="admin_new_search_name">搜索类型：</div>
					<div class="admin_Filter_text formselect" did='dtype'>
						<input type="button" value="<?php if ($_GET['type']==''||$_GET['type']=='1') {?>公司名称 <?php } elseif ($_GET['type']=='2') {?>产品名称<?php }?>"
						 class="admin_new_select_text" id="btype">
						<input type="hidden" id='type' value="<?php if ($_GET['type']) {
echo $_GET['type'];
} else { ?>1<?php }?>"
						 name='type' value='1'>
						<div class="admin_Filter_text_box" style="display:none" id='dtype'>
							<ul>
								<li><a href="javascript:void(0)" onClick="formselect('1','type','公司名称')">公司名称</a></li>
								<li><a href="javascript:void(0)" onClick="formselect('2','type','产品名称')">产品名称</a></li>
							</ul>
						</div>
					</div>
					<input type="text" value="" placeholder="请输入你要搜索的关键字" name='keyword' class="admin_new_text">
					<input type="submit" value="搜索" name='search' class="admin_new_bth">
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
					<form action="index.php?m=productnews&c=prodel" target="supportiframe" name="myform" id='myform' method="post">
						<table width="100%">
							<thead>
								<tr class="admin_table_top">
									<th style="width:20px;"><label for="chkall">
											<input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' />
										</label></th>
									<th> <?php if ($_GET['order']=="asc") {?> <a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'id','m'=>'productnews','untype'=>'order,t'),$_smarty_tpl);?>
">编号<img
											 src="images/sanj.jpg" /></a> <?php } else { ?> <a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'id','m'=>'productnews','untype'=>'order,t'),$_smarty_tpl);?>
">编号<img
											 src="images/sanj2.jpg" /></a> <?php }?> </th>
									<th align="left">公司名称</th>
									<th width="260" align="left">产品名称</th>
									<th>时间</th>
									<th>状态</th>
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
									<td style="width:20px;"><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="check_all" name='del[]'
										 onclick='unselectall()' rel="del_chk" /></td>
									<td align="left" class="td1" style="text-align:center;"><span><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</span></td>
									<td class="ud" align="left"><a href="index.php?m=admin_company&c=Imitate&uid=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</a></td>
									<td width="260px" class="ud" align="left"><?php echo mb_substr($_smarty_tpl->tpl_vars['v']->value['title'],0,20,'utf-8');?>
</td>
									<td class="ud" align="center"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['ctime'],"%Y-%m-%d %H:%M");?>
</td>
									<td><?php if ($_smarty_tpl->tpl_vars['v']->value['status']==1) {?><span class="admin_com_Audited">已审核</span><?php } elseif ($_smarty_tpl->tpl_vars['v']->value['status']==0) {?><span
										 class="admin_com_noAudited">未审核</span><?php } elseif ($_smarty_tpl->tpl_vars['v']->value['status']==2) {?><span class="admin_com_tg">未通过</span><?php }?></td>
									<td><a href="javascript:void(0);" class="admin_new_c_bth admin_new_c_bthsh status" status="<?php echo $_smarty_tpl->tpl_vars['v']->value['status'];?>
"
										 pid="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">审核</a> <a href="<?php echo smarty_function_url(array('m'=>'company','id'=>$_smarty_tpl->tpl_vars['v']->value['uid'],'c'=>'productshow','pid'=>$_smarty_tpl->tpl_vars['v']->value['id']),$_smarty_tpl);?>
" target="_blank"
										 class="admin_new_c_bth admin_new_c_bth_yl">预览</a> <a href="javascript:void(0)" onclick="layer_del('确定要删除？', 'index.php?m=productnews&c=prodel&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');"
										 class="admin_new_c_bth  admin_new_c_bth_sc">删除</a></td>
								</tr>
								<?php } ?>
								<tr>
									<td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
									<td colspan="6"><label for="chkAll2">全选</label>
										<input class="admin_button" type="button" name="delsub" value="删除所选" onClick="return really('del[]')" />
										&nbsp;&nbsp;
										<input class="admin_button" type="button" name="delsub" value="批量审核" onClick="audall('');" />
										&nbsp;&nbsp;
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
										<td colspan="4" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
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
 type="text/javascript">
			layui.use(['layer', 'form'], function() {
				var layer = layui.layer,
					form = layui.form,
					$ = layui.$;
			});
		<?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
>
			function audall(status) {
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
					$("input[name=id]").val(codewebarr);
					$("#alertcontent").val('');
					$("input[name=status]").attr("checked", false);
					status_div('产品审核', '390', '240');
				}
			}
			$(function() {
				$(".status").click(function() {
					$("input[name=pid]").val($(this).attr("pid"));
					var id = $(this).attr("pid");
					var status = $(this).attr("status");
					$("#status" + status).attr("checked", true);
					layui.use(['form'], function() {
						var form = layui.form;
						form.render();
					});
					$("input[name=id]").val(id);
					$.get("index.php?m=productnews&c=prostatusbody&id=" + id, function(msg) {
						$("#alertcontent").val(msg);
						status_div('产品审核', '390', '240');
					});
				});
			});
		<?php echo '</script'; ?>
>
	</body>
</html>
<?php }} ?>
