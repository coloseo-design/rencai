<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-08 16:23:01
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_height_user.htm" */ ?>
<?php /*%%SmartyHeaderCode:677562c7e9655c8400-61552855%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a740730348f3258a0c8d103a7aa9d58619c8ee73' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_height_user.htm',
      1 => 1643012867,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '677562c7e9655c8400-61552855',
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
  'unifunc' => 'content_62c7e9656d0183_21503605',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c7e9656d0183_21503605')) {function content_62c7e9656d0183_21503605($_smarty_tpl) {?><?php if (!is_callable('smarty_function_searchurl')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.searchurl.php';
if (!is_callable('smarty_function_url')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.url.php';
if (!is_callable('smarty_modifier_date_format')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\modifier.date_format.php';
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
		<div id="preview" style="display:none;width:450px ">
			<div style="height:400px; overflow:auto;width:450px;">

				<form class="layui-form" name="formstatus" action="index.php?m=height_user&c=heightuserstatus" target="supportiframe"
				 method="post" onSubmit="return tcdiv();">
					<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">

					<table cellspacing='1' cellpadding='1' class="admin_examine_table">
						<tr>
							<th>用户名：</th>
							<td align="left"><span id="username"></span></td>
						</tr>
						<tr>
							<th width="100">个人审核：</th>
							<td align="left">
								<div class="layui-form-item">
									<div class="layui-input-block">
										<input name="r_status" id="prstatus1" value="1" title="正常" type="radio" lay-filter="prstatus" />
										<input name="r_status" id="prstatus3" value="3" title="未通过" type="radio" lay-filter="prstatus" />
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<th></th>
							<td align="left">
								<div class="sh_sm">当前优质人才根据个人审核状态（除了未通过）同步审核</div>
							</td>
						</tr>

						<tr>
							<th width="100">优质人才审核：</th>
							<td align="left">
								<div class="layui-form-item">
									<div class="layui-input-block">
										<input name="height_status" id="height_status" value="1" title="同步" type="checkbox" lay-skin="primary"
										 checked="checked" disabled="disabled" />
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<th>审核说明：</th>
							<td align="left"> <textarea id="statusbody" name="statusbody" class="shsm_textarea"></textarea></td>
						</tr>
						<tr>
							<td colspan='2' align="center">
								<div class="admin_Operating_sub">
									<input type="submit" value='确认' class="admin_examine_bth">
									<input type="button" onClick="layer.closeAll();" class="admin_examine_bth_qx" value='取消'>
								</div>
							</td>
						</tr>

					</table>
					<input name="cid" value="0" type="hidden">
					<input name="cuid" value="0" type="hidden">
				</form>

			</div>
		</div>
		<div id="infobox2" style="display:none; width: 390px; ">

			<form class="layui-form" action="index.php?m=height_user&c=status" target="supportiframe" method="post" onsubmit="return htStatus()">
				<table cellspacing='1' cellpadding='1' class="admin_examine_table">
					<tr>
						<th width="80">审核操作：</th>
						<td align="left">
							<div class="layui-input-block">
								<input name="status" id="status2" value="2" title="正常" type="radio" />
								<input name="status" id="status3" value="3" title="未通过" type="radio" />
							</div>
						</td>
					</tr>
					<tr>
						<th class="t_fr">审核说明：</th>
						<td><textarea id="statusbody" name="statusbody" class="admin_explain_textarea"></textarea></td>
					</tr>
					<tr>
						<td colspan='2' align="center">
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

		<div class="infoboxp">

			<div class="tty-tishi_top">
				<div class="admin_new_tip">
					<a href="javascript:;" class="admin_new_tip_close"></a>
					<a href="javascript:;" class="admin_new_tip_open" style="display:none;"></a>
					<div class="admin_new_tit"><i class="admin_new_tit_icon"></i>操作提示</div>
					<div class="admin_new_tip_list_cont">
						<div class="admin_new_tip_list">对优质人才进行审核操作</div>
						<div class="admin_new_tip_list">当前用户除了已锁定状态，可以正常审核。</div>
						<div class="admin_new_tip_list">当前除了已审核状态显示已锁定，显示其他状态（未审核，未通过）。</div>
					</div>
				</div>

				<div class="clear"></div>

				<div class="admin_new_search_box">
					<form action="index.php" name="myform" method="get">
						<input name="m" value="height_user" type="hidden" />
						<input type="hidden" name="searchsalary" value="<?php echo $_GET['searchsalary'];?>
" />
						<input type="hidden" name="searchtype" value="<?php echo $_GET['searchtype'];?>
" />
						<input type="hidden" name="searchreport" value="<?php echo $_GET['searchreport'];?>
" />
						<input type="hidden" name="rec" value="<?php echo $_GET['rec'];?>
" />
						<input type="hidden" name="status" value="<?php echo $_GET['status'];?>
" />
						<div class="admin_new_search_name">搜索类型：</div>
						<div class="admin_Filter_text formselect" did='dsearchrname'>
							<input type="button" value="<?php if ($_GET['searchrname']=='1'||$_GET['searchrname']=='') {?>用户名<?php } else { ?>简历名称<?php }?>"
							 class="admin_Filter_but" id="bsearchrname">
							<input type="hidden" id='searchrname' value="<?php if ($_GET['searchrname']) {
echo $_GET['searchrname'];
} else { ?>1<?php }?>"
							 name='searchrname'>
							<div class="admin_Filter_text_box" style="display:none" id='dsearchrname'>
								<ul>
									<li>
										<a href="javascript:void(0)" onClick="formselect('1','searchrname','用户名')">用户名</a>
									</li>
									<li>
										<a href="javascript:void(0)" onClick="formselect('2','searchrname','简历名称')">简历名称</a>
									</li>
								</ul>
							</div>
						</div>
						<input class="admin_Filter_search" type="text" name="keyword" size="25" placeholder="请输入您要搜索的关键字"/>
						<input class="admin_Filter_bth" type="submit" name="news_search" value="检索" />

						<a href="javascript:void(0)" onclick="$('.admin_screenlist_box').toggle();" class="admin_new_search_gj">高级搜索</a>
					</form>

					<?php echo $_smarty_tpl->getSubTemplate ("admin/admin_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

				</div>
				<div class="clear"></div>
			</div>

			<div class="tty_table-bom">
				<div class="admin_statistics">
					<span class="tty_sjtj_color">数据统计：</span>
					<a href="index.php?m=height_user" class="ajaxresumeall">0</a>；
					未审核：<a href="index.php?m=height_user&status=1" class="ajaxresumestatus1">0</a>；
					未通过：<a href="index.php?m=height_user&status=3" class="ajaxresumestatus2">0</a>；
					已锁定：<a href="index.php?m=height_user&status=4" class="ajaxresumestatus3">0</a>；
					搜索结果：<span><?php echo $_smarty_tpl->tpl_vars['total']->value;?>
</span>；
				</div>

				<div class="table-list">
					<div class="admin_table_border">
						<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
						<form action="index.php" name="myform" method="get" target="supportiframe" id='myform'>
							<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
							<input name="m" value="height_user" type="hidden" />
							<input name="c" value="del" type="hidden" />
							<table width="100%">
								<thead>
									<tr class="admin_table_top">
										<th width="3%">
											<label for="chkall"><input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' /></label>
										</th>
										<th width="8%"> <?php if ($_GET['t']=="id"&&$_GET['order']=="asc") {?>
											<a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'id','m'=>'height_user','untype'=>'order,t'),$_smarty_tpl);?>
">简历编号<img src="images/sanj.jpg" /></a>
											<?php } else { ?>
											<a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'id','m'=>'height_user','untype'=>'order,t'),$_smarty_tpl);?>
">简历编号<img src="images/sanj2.jpg" /></a>
											<?php }?> </th>
										<th align="left" width="8%">用户名</th>
										<th align="left" width="150">简历名称</th>
										<th align="left" width="200">意向职位</th>
										<th>工作地点</th>
										<th>待遇要求</th>
										<th>工作性质</th>
										<th>到岗时间</th>
										<th>审核状态</th>
										<th>推荐</th>
										<th> <?php if ($_GET['t']=="time"&&$_GET['order']=="asc") {?>
											<a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'time','m'=>'height_user','untype'=>'order,t'),$_smarty_tpl);?>
">审核时间<img src="images/sanj.jpg" /></a>
											<?php } else { ?>
											<a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'time','m'=>'height_user','untype'=>'order,t'),$_smarty_tpl);?>
">审核时间<img src="images/sanj2.jpg" /></a>
											<?php }?> </th>
										<th class="admin_table_th_bg">操作</th>
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
									<tr align="center" <?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg" <?php }?> id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
										<td><input type="checkbox" class="check_all" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name='del[]' onclick='unselectall()'
											 rel="del_chk" /></td>
										<td align="left" class="td1" style="text-align:center;"><span><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</span></td>
										<td class="gd" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['username'];?>
</td>
										<td class="ud" align="left">
											<!--<a href="<?php echo smarty_function_url(array('m'=>'resume','c'=>'show','id'=>'`$v.id`','type'=>2,'look'=>'admin'),$_smarty_tpl);?>
" target="_blank" class="admin_cz_sc"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</a>-->
											<a class="admin_cz_sc resume-preview" href="javascript:void(0);" pid="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</a>
										</td>
										<td class="od" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['job_classname'];?>
</td>
										<td class="gd"><?php if ($_smarty_tpl->tpl_vars['v']->value['city_n']) {
echo $_smarty_tpl->tpl_vars['v']->value['city_n'];
} else {
echo $_smarty_tpl->tpl_vars['v']->value['city_classname'];
}?></td>
										<td class="td"><?php if ($_smarty_tpl->tpl_vars['v']->value['minsalary']&&$_smarty_tpl->tpl_vars['v']->value['maxsalary']) {?>￥<?php echo $_smarty_tpl->tpl_vars['v']->value['minsalary'];?>
-<?php echo $_smarty_tpl->tpl_vars['v']->value['maxsalary'];
} elseif ($_smarty_tpl->tpl_vars['v']->value['minsalary']) {?>￥<?php echo $_smarty_tpl->tpl_vars['v']->value['minsalary'];?>
以上<?php } else { ?>面议<?php }?></td>
										<td><?php echo $_smarty_tpl->tpl_vars['v']->value['type_n'];?>
</td>
										<td><?php echo $_smarty_tpl->tpl_vars['v']->value['report_n'];?>
</td>
										<td>
											<?php if ($_smarty_tpl->tpl_vars['v']->value['r_status']==1) {?>
											<?php if ($_smarty_tpl->tpl_vars['v']->value['height_status']==2) {?><span class="admin_com_Audited">已审核</span><?php } elseif ($_smarty_tpl->tpl_vars['v']->value['height_status']==1) {?><span class="admin_com_noAudited">未审核</span><?php } else { ?><span class="admin_com_tg">未通过</span><?php }?></td>
										<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['r_status']==2) {?>
										<?php if ($_smarty_tpl->tpl_vars['v']->value['height_status']==1) {?>
										<span class="admin_com_noAudited">未审核</span>
										<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['height_status']==2) {?>
										<span class="admin_com_Lock">已锁定</span>
										<?php } else { ?>
										<span class="admin_com_tg">未通过</span>
										<?php }?>
										<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['r_status']==3) {?>
										<?php if ($_smarty_tpl->tpl_vars['v']->value['height_status']==1) {?>
										<span class="admin_com_noAudited">未审核</span>
										<?php } else { ?>
										<span class="admin_com_tg">未通过</span>
										<?php }?>
										<?php } else { ?>
										<span class="admin_com_noAudited">未审核</span>
										<?php }?>
										<td id="rec<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php if ($_smarty_tpl->tpl_vars['v']->value['rec']=="1") {?>
											<a href="javascript:void(0);" onClick="rec_up('index.php?m=height_user&c=recommend','<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','0','rec');"><img
												 src="../config/ajax_img/doneico.gif"></a><?php } else { ?>
											<a href="javascript:void(0);" onClick="rec_up('index.php?m=height_user&c=recommend','<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','1','rec');"><img
												 src="../config/ajax_img/errorico.gif"></a><?php }?> </td>
										<td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['status_time'],"%Y-%m-%d");?>
</td>
										<td>
											<a href="javascript:void(0);" class="status admin_new_c_bth admin_new_c_bthsh" pid="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" uid="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
"
											 rstatus="<?php echo $_smarty_tpl->tpl_vars['v']->value['r_status'];?>
" username="<?php echo $_smarty_tpl->tpl_vars['v']->value['username'];?>
" status="<?php echo $_smarty_tpl->tpl_vars['v']->value['height_status'];?>
">审核</a>
											<div class=" mt5">
												<!--<a href="<?php echo smarty_function_url(array('m'=>'resume','c'=>'show','id'=>'`$v.id`','type'=>2,'look'=>'admin'),$_smarty_tpl);?>
" class="admin_new_c_bth admin_new_c_bth_yl"-->
												<!-- target="_blank"> 预览</a>-->
												<a class="admin_new_c_bth admin_new_c_bth_yl resume-preview" href="javascript:void(0);" pid="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"> 预览</a>
											</div>
											<div class=" mt5">
												<a href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=height_user&c=del&del=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');"
												 class="admin_new_c_bth admin_new_c_bth_sc">删除</a>
											</div>
										</td>
									</tr>
									<?php } ?>
									<tr>
										<td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
										<td colspan="13">
											<label for="chkAll2">全选</label>&nbsp;
											<input class="admin_button" type="button" name="delsub" value="删除所选" onClick="return really('del[]')" />
											&nbsp;&nbsp;
											<input class="admin_button" type="button" name="delsub" value="批量审核" onClick="audall();" /></td>
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
											<td colspan="11" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
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
				form.on('radio(prstatus)', function(data) {
					if (data.value == 1) {
						$("#height_status").attr("checked", true);
					} else {
						$("#height_status").attr("checked", false);
					}
					form.render('checkbox');
				});
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
					layui.use('form', function() {
						var form = layui.form;
						form.render();
					});
					$.layer({
						type: 1,
						title: '批量审核',
						closeBtn: [0, true],
						border: [10, 0.3, '#000', true],
						area: ['390px', '240px'],
						page: {
							dom: "#infobox2"
						}
					});
				}
			}
			$(function() {
				$(".status").click(function() {
					var pid = $(this).attr("pid");
					var rstatus = $(this).attr("rstatus");
					if (rstatus != 1) {
						if (rstatus == 2) {
							parent.layer.msg('用户已锁定,无法审核相关信息', 2, 8);
							return false;
						} else {
							var uid = $(this).attr("uid");
							$("input[name=cuid]").val(uid);
							$("input[name=cid]").val(pid);
							var username = $(this).attr("username");
							$("#username").html(username);
							$("#prstatus" + rstatus).attr("checked", true);
							$("#height_status").attr("checked", false);
							$.layer({
								type: 1,
								title: '审核操作',
								closeBtn: [0, true],
								offset: ['80px', ''],
								border: [10, 0.3, '#000', true],
								area: ['450px', '450px'],
								page: {
									dom: '#preview'
								}
							});
						}

					} else {
						var status = $(this).attr("status");
						$("#status" + status).attr("checked", true);
						$("input[name=pid]").val(pid);
						var pytoken = $("#pytoken").val();
						$.post("index.php?m=height_user&c=lockinfo", {
							pytoken: pytoken,
							pid: pid
						}, function(msg) {
							$("#statusbody").val(msg);
							$.layer({
								type: 1,
								title: '审核',
								closeBtn: [0, true],
								border: [10, 0.3, '#000', true],
								area: ['390px', '240px'],
								page: {
									dom: "#infobox2"
								}
							});
						});

					}

					layui.use(['form'], function() {
						var form = layui.form;
						form.render();
					});

				});
			});
			$(document).ready(function() {
				$.get("index.php?m=height_user&c=gresumeNum", function(data) {
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
					if (datas.resumeStatusNum3) {
						$('.ajaxresumestatus3').html(datas.resumeStatusNum3);
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
