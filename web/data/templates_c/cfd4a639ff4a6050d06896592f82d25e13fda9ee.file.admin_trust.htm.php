<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:15:51
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_trust.htm" */ ?>
<?php /*%%SmartyHeaderCode:68862d8fd27824294-14609076%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cfd4a639ff4a6050d06896592f82d25e13fda9ee' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_trust.htm',
      1 => 1643012867,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '68862d8fd27824294-14609076',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
    'total' => 0,
    'rows' => 0,
    'key' => 0,
    'v' => 0,
    'pagenum' => 0,
    'pages' => 0,
    'pagenav' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d8fd2791aec7_23396244',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d8fd2791aec7_23396244')) {function content_62d8fd2791aec7_23396244($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\modifier.date_format.php';
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
		<title>后台管理</title>
	</head>

	<body class="body_ifm">
		<div id="status_div" style="display:none;">
			<div class="">
				<form class="layui-form" action="index.php?m=admin_trust&c=status" target="supportiframe" method="post" id="formstatus">
					<table cellspacing='1' cellpadding='1' class="admin_examine_table">
						<tr>
							<th width="100">审核操作：</th>
							<td align="left">
								<div class="layui-input-block">
									<input name="status" id="status1" value="1" title="接受" type="radio" />
									<input name="status" id="status2" value="2" title="不接受" type="radio" />
								</div>
							</td>
						</tr>
						<tr>
							<th>审核说明：</th>
							<td align="left">
								<div class="admin_examine_trust"> 设定“未接受”时，将会退还金额。</div>
							</td>
						</tr>
						<tr>
							<td colspan='2' align="center">
								<input type="submit" value='确认' class="admin_examine_bth">
								<input type="button" id="zxxCancelBtn" onClick="layer.closeAll();" class="admin_examine_bth_qx" value='取消'>
							</td>
						</tr>
					</table>
					<input name="pid" value="0" type="hidden">
					<input type="hidden" name="pytoken" id="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
				</form>
			</div>
		</div>

		<div class="infoboxp">
			<div class="tty-tishi_top">


			<div class="clear"></div>

			<div class="admin_new_search_box">
				<form action="index.php" name="myform" method="get">
					<input name="m" value="admin_trust" type="hidden" />
					<div class="admin_new_search_name">检索类型：</div>
					<div class="admin_Filter_text formselect" did='dtype'>
						<input type="button" value="<?php if ($_GET['type']=='2') {?>简历名<?php } else { ?>姓名<?php }?>" class="admin_Filter_but"
						 id="btype">
						<input type="hidden" name="type" id="type" value="<?php if ($_GET['type']) {
echo $_GET['type'];
} else { ?>1<?php }?>" />
						<div class="admin_Filter_text_box" style="display:none" id='dtype'>
							<ul>
								<li><a href="javascript:void(0)" onClick="formselect('1','type','姓名')">姓名</a></li>
								<li><a href="javascript:void(0)" onClick="formselect('2','type','简历名')">简历名</a></li>
							</ul>
						</div>
					</div>
					<input type="text" placeholder="输入你要搜索的关键字" value="<?php echo $_GET['keyword'];?>
" name='keyword' class="admin_new_text">
					<input type="submit" name='search' value="搜索" class="admin_new_bth">
					<a href="javascript:void(0)" onclick="$('.admin_screenlist_box').toggle();" class="admin_new_search_gj">高级搜索</a>
					<?php echo $_smarty_tpl->getSubTemplate ("admin/admin_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

				</form>
			</div>

			<div class="clear"></div>
			</div>
			
			
			<div class="tty_table-bom">
			<div class="admin_statistics">
				<span class="tty_sjtj_color">数据统计：</span>
				<a href="index.php?m=admin_trust" class="ajaxresumeall">0</a>；
				未审核：<a href="index.php?m=admin_trust&status=3" class="ajaxresumestatus1">0</a>；
				未接受：<a href="index.php?m=admin_trust&status=2" class="ajaxresumestatus2">0</a>；
				搜索结果：<span><?php echo $_smarty_tpl->tpl_vars['total']->value;?>
</span>；
			</div>

			<div class="table-list">
				<div class="admin_table_border">
					<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
					<form action="index.php?m=admin_trust&c=del" name="myform" id='myform' method="post" target="supportiframe">
						<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">

						<table width="100%">
							<thead>
								<tr class="admin_table_top">
									<th style="width:40px;">
										<label for="chkall"><input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' /></label>
									</th>
									<th>
										<?php if ($_GET['order']=='uid'&&$_GET['desc']=='asc') {?>
										<a href="index.php?m=admin_trust&order=uid&desc=desc">UID<img src="images/sanj.jpg"></a>
										<?php } else { ?>
										<a href="index.php?m=admin_trust&order=uid&desc=asc">UID<img src="images/sanj2.jpg"></a>
										<?php }?>
									</th>
									<th align="left">姓名</th>
									<th align="left">简历名</th>
									<th>价格(元)</th>
									<th>
										<?php if ($_GET['order']=='add_time'&&$_GET['desc']=='asc') {?>
										<a href="index.php?m=admin_trust&order=add_time&desc=desc">申请时间<img src="images/sanj.jpg"></a>
										<?php } else { ?>
										<a href="index.php?m=admin_trust&order=add_time&desc=asc">申请时间<img src="images/sanj2.jpg"></a>
										<?php }?>
									</th>
									<th>状态</th>
									<th width="180" class="admin_table_th_bg">操作</th>
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
									<td align="left" class="td1" style="text-align:center;"><span><?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
</span></td>
									<td class="ud" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['uname'];?>
</td>
									<td class="ud" align="left">
										<?php if ($_smarty_tpl->tpl_vars['v']->value['name']) {
echo $_smarty_tpl->tpl_vars['v']->value['name'];
} else { ?><font color="#FF0000">简历已删除</font><?php }?>
									</td>
									<td class="gd" width="60"><span class="amount-pay-out"><?php echo $_smarty_tpl->tpl_vars['v']->value['price'];?>
</span></td>
									<td class="td" width="200"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['add_time'],"%Y-%m-%d %H:%M");?>
</td>
									<td>
										<?php if ($_smarty_tpl->tpl_vars['v']->value['status']==1) {?><span class="admin_com_Audited">已接受</span>
										<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['status']==0) {?><span class="admin_com_noAudited">未审核</span>
										<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['status']==2) {?><span class="admin_com_tg">不接受</span>
										<?php }?>
									</td>
									<td>
										<?php if ($_smarty_tpl->tpl_vars['v']->value['name']) {?>
										<a class="admin_new_c_bth admin_new_c_bth_yl resume-preview" href="javascript:void(0);" pid="<?php echo $_smarty_tpl->tpl_vars['v']->value['eid'];?>
">预览</a>
											<?php if ($_smarty_tpl->tpl_vars['v']->value['status']==1) {?>
											<a class="admin_new_c_bth " href="index.php?m=admin_trust&c=recom&eid=<?php echo $_smarty_tpl->tpl_vars['v']->value['eid'];?>
&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">推荐</a>
											<?php }?>
											<?php if ($_smarty_tpl->tpl_vars['v']->value['status']==0) {?>
											<a href="javascript:void(0);" class="admin_new_c_bth admin_new_c_bthsh status" status="<?php echo $_smarty_tpl->tpl_vars['v']->value['status'];?>
"
											 pid="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">审核</a>
											<?php }?>
										<?php }?>

										<?php if ($_smarty_tpl->tpl_vars['v']->value['status']!=0) {?>
										<a href="javascript:void(0)" onclick="layer_del('确定要删除？', 'index.php?m=admin_trust&c=del&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" class="admin_new_c_bth admin_new_c_bth_sc">删除</a>
										<?php }?>
									</td>
								</tr>
								<?php } ?>
								<tr>
									<td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
									<td colspan="7">
										<label for="chkAll2">全选</label>&nbsp;
										<input class="admin_button" type="button" name="delsub" value="删除所选" onClick="return really('del[]')" />
									</td>
								</tr>
								<?php if ($_smarty_tpl->tpl_vars['total']->value>$_smarty_tpl->tpl_vars['config']->value['sy_listnum']) {?>
									<tr>
										<?php if ($_smarty_tpl->tpl_vars['pagenum']->value==1) {?>
											<td colspan="3"> 从 1 到 <?php echo $_smarty_tpl->tpl_vars['config']->value['sy_listnum'];?>
 ，总共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</td>
										<?php } elseif ($_smarty_tpl->tpl_vars['pagenum']->value>1&&$_smarty_tpl->tpl_vars['pagenum']->value<$_smarty_tpl->tpl_vars['pages']->value) {?>
											<td colspan="3"> 从 <?php echo ($_smarty_tpl->tpl_vars['pagenum']->value-1)*$_smarty_tpl->tpl_vars['config']->value['sy_listnum']+1;?>
 到 <?php echo $_smarty_tpl->tpl_vars['pagenum']->value*$_smarty_tpl->tpl_vars['config']->value['sy_listnum'];?>
 ，总共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</td>
										<?php } elseif ($_smarty_tpl->tpl_vars['pagenum']->value==$_smarty_tpl->tpl_vars['pages']->value) {?>
											<td colspan="3"> 从 <?php echo ($_smarty_tpl->tpl_vars['pagenum']->value-1)*$_smarty_tpl->tpl_vars['config']->value['sy_listnum']+1;?>
 到 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 ，总共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
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
		</div>
		<?php echo '<script'; ?>
 type="text/javascript">
			layui.use(['layer', 'form'], function() {
				var layer = layui.layer,
					form = layui.form,
					$ = layui.$;
			});

			$(function() {
				$(".status").click(function() {
					$("input[name=pid]").val($(this).attr("pid"));
					var pid = $(this).attr("pid");
					var status = $(this).attr("status");
					$("#status" + status).attr("checked", true);
					layui.use(['form'], function() {
						var form = layui.form;
						form.render();
					});
					$("input[name=pid]").val(pid);
					status_div('委托简历管理', '390', '230');
				});
				$.get("index.php?m=admin_trust&c=trustNum", function(data) {
					var datas = eval('(' + data + ')');
					if (datas.resumeAllNum) {
						$('.ajaxresumeall').html(datas.resumeAllNum);
					}
					if (datas.resumeStatusNum1) {
						$('.ajaxresumestatus1').html(datas.resumeStatusNum1);
					}
					if (datas.resumeStatusNum2) {
						$('.ajaxresumestatus2').html(datas.resumeStatusNum2);
					}
				});

				$(".resume-preview").click(function() {
					var id = $(this).attr("pid");
					$('body').css('overflow-y', 'hidden');
					$.layer({
						type: 2,
						shadeClose: true,
						title: '简历预览',
						area: ['755px', ($(window).height() - 30) +'px'],
						iframe: {src: 'index.php?m=admin_resume&c=resumePreview&id='+id},
						close: function(){
							$('body').css('overflow-y', '');
						}
					});
				});
			});
		<?php echo '</script'; ?>
>
	</body>
</html>
<?php }} ?>
