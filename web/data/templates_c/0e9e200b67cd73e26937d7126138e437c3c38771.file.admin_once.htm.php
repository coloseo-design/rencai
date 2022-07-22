<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-06 16:22:20
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_once.htm" */ ?>
<?php /*%%SmartyHeaderCode:2010462c5463ccf25b3-01959969%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0e9e200b67cd73e26937d7126138e437c3c38771' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_once.htm',
      1 => 1634883865,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2010462c5463ccf25b3-01959969',
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
    'Dname' => 0,
    'pagenum' => 0,
    'pages' => 0,
    'pagenav' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c5463cda6955_13283746',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c5463cda6955_13283746')) {function content_62c5463cda6955_13283746($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.url.php';
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
		<div id="infobox2" style="display:none;">
			<div class="admin_com_t_box">
				<form action="index.php?m=admin_once&c=ctime" target="supportiframe" method="post" id="formstatus">
					<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
					<div class="admin_com_smbox_list"><span class="admin_com_smbox_span">延长时间：</span>
						<input class="admin_com_smbox_text" value="" name="endtime" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'')">
						<span class="admin_com_smbox_list_s">天</span>
					</div>
					<div class="admin_com_smbox_opt">
						<input type="submit" onclick="loadlayer();" value='确认' class="admin_examine_bth">
						<input type="button" onClick="layer.closeAll();" class="admin_examine_bth_qx" value='取消'>
					</div>
					<input name="onceids" value="0" type="hidden">
				</form>
			</div>
		</div>

		<div class="infoboxp">
			
			<div class="tty-tishi_top">
			<div class="tabs_info">
				<ul>
					<li class="curr"><a href="index.php?m=admin_once">店铺招聘</a></li>
					<li><a href="index.php?m=admin_once&c=set">店铺设置</a></li>
				</ul>
			</div>

			<div class="clear"></div>

			<div class="admin_new_search_box">
				<form method="get" action="index.php" name="myform">
					<input type="hidden" name="m" value="admin_once" />
					<input type="hidden" name="status" value="<?php echo $_GET['status'];?>
" />
					<div class="admin_new_search_name">搜索类型：</div>
					<div class="admin_Filter_text formselect" did="dtype">
						<input type="button" <?php if ($_GET['type']==''||$_GET['type']=='2') {?> value="职位名称" <?php } elseif ($_GET['type']=='3') {?> value="联系电话" <?php } elseif ($_GET['type']=='4') {?> value="联系人" <?php } elseif ($_GET['type']=='5') {?> value="店铺名" <?php }?> class="admin_Filter_but" id="btype">
						<input type="hidden" name="type" id="type" value="<?php if ($_GET['type']) {
echo $_GET['type'];
} else { ?>2<?php }?>" />
						<div class="admin_Filter_text_box" style="display:none" id="dtype">
							<ul>
								<li><a href="javascript:void(0)" onClick="formselect('2','type','职位名称')">职位名称</a></li>
								<li><a href="javascript:void(0)" onClick="formselect('3','type','联系电话')">联系电话</a></li>
								<li><a href="javascript:void(0)" onClick="formselect('4','type','联系人')">联系人</a></li>
								<li><a href="javascript:void(0)" onClick="formselect('5','type','店铺名')">店铺名</a></li>
							</ul>
						</div>
					</div>
					<input type="text" placeholder="输入你要搜索的关键字" name="keyword" class="admin_Filter_search" value="<?php echo $_GET['keyword'];?>
">
					<input type="submit" value="搜索" class="admin_Filter_bth">
					<a href="javascript:void(0)" onclick="$('.admin_screenlist_box').toggle();" class="admin_new_search_gj">高级搜索</a>
				</form>

				<?php echo $_smarty_tpl->getSubTemplate ("admin/admin_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

			</div>
			<div class="clear"></div>
			</div>
			
			<div class="tty_table-bom">
			<div class="admin_statistics">
				<span class="tty_sjtj_color">数据统计：</span>
				<em class="admin_statistics_s">总数：<a href="index.php?m=admin_once" class="ajaxonceall">0</a></em>
				<em class="admin_statistics_s">未审核：<a href="index.php?m=admin_once&status=3" class="onceStatusNum1">0</a></em>
				<em class="admin_statistics_s">已过期：<a href="index.php?m=admin_once&status=2" class="onceStatusNum2">0</a></em>
				搜索结果：<span><?php echo $_smarty_tpl->tpl_vars['total']->value;?>
</span>；
			</div>
			<div class="table-list">
				<div class="admin_table_border">
					<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
					<form action="index.php" target="supportiframe" name="myform" id='myform' method="get">
						<input name="m" value="admin_once" type="hidden" />
						<input name="c" value="del" type="hidden" />
						<table width="100%">
							<thead>
								<tr class="admin_table_top">
									<th><label for="chkall">
											<input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' />
										</label></th>
									<th> <?php if ($_GET['t']=="id"&&$_GET['order']=="asc") {?> <a href="index.php?m=admin_once&order=desc&t=id">编号<img
											 src="images/sanj.jpg" /></a> <?php } else { ?> <a href="index.php?m=admin_once&order=asc&t=id">编号<img src="images/sanj2.jpg" /></a>
										<?php }?> </th>

									<th align="left">职位名称/店铺名</th>
									<th align="left">店铺形象</th>
									<th align="left">联系电话</th>
									<th align="left">联系人</th>
									<th> <?php if ($_GET['t']=="ctime"&&$_GET['order']=="asc") {?> <a href="index.php?m=admin_once&order=desc&t=ctime">发布时间<img
											 src="images/sanj.jpg" /></a> <?php } else { ?> <a href="index.php?m=admin_once&order=asc&t=ctime">发布时间 <img
											 src="images/sanj2.jpg" /></a> <?php }?> </th>
									<th> <?php if ($_GET['t']=="edate"&&$_GET['order']=="asc") {?> <a href="index.php?m=admin_once&order=desc&t=edate">结束时间<img
											 src="images/sanj.jpg" /></a> <?php } else { ?> <a href="index.php?m=admin_once&order=asc&t=edate">结束时间 <img
											 src="images/sanj2.jpg" /></a> <?php }?> </th>
									<th>状态</th>
									<th>站点</th>
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
								<tr align="center" <?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg"<?php }?> id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
									<td><input type="checkbox" class="check_all" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name='del[]' onclick='unselectall()'
										 rel="del_chk" /></td>
									<td align="left" class="td1" style="text-align:center;"><span><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</span></td>
									<td class="od" align="left">
										<a class="admin_cz_sc" href="<?php echo smarty_function_url(array('m'=>'once','c'=>'show','id'=>$_smarty_tpl->tpl_vars['v']->value['id']),$_smarty_tpl);?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</a>
										<div class="mt8"><?php echo $_smarty_tpl->tpl_vars['v']->value['companyname'];?>
</div>
									</td>
									<td align="left">
										<?php if ($_smarty_tpl->tpl_vars['v']->value['pic']) {?>
										<img src="<?php echo $_smarty_tpl->tpl_vars['v']->value['pic_n'];?>
" width='50' height='50'>
										<?php } else { ?>无
										<?php }?>
									</td>
									<td align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['phone'];?>
</td>
									<td align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['linkman'];?>
</td>
									<td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['ctime'],"%Y-%m-%d");?>
</td>
									<td><?php if ($_smarty_tpl->tpl_vars['v']->value['edate']<=time()) {?> <font color="orange"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['edate'],"%Y-%m-%d");?>
</font><?php } else {
echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['edate'],"%Y-%m-%d");
}?></td>
									<td>
										<?php if ($_smarty_tpl->tpl_vars['v']->value['edate']<=time()) {?> <span class="admin_com_Lock">已过期</span>
											<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['status']==1) {?>
											<span class="admin_com_Audited">已审核</span>
											<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['status']==0) {?>
											<span class="admin_com_noAudited">未审核</span>
											<?php }?>

											<?php if ($_smarty_tpl->tpl_vars['v']->value['pay']>0) {?>
											<?php if ($_smarty_tpl->tpl_vars['v']->value['pay']==1) {?>
											<span class="admin_com_Lock">未付款</span>
											<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['pay']==2) {?>
											<span class="admin_com_Audited">已付款</span>
											<?php }?>
											<?php }?>

									</td>
									<td align="center">
										<div><?php echo $_smarty_tpl->tpl_vars['Dname']->value[$_smarty_tpl->tpl_vars['v']->value['did']];?>
</div>
										<div>
											<a href="javascript:;" onclick="checksite('<?php echo $_smarty_tpl->tpl_vars['v']->value['companyname'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','index.php?m=admin_once&c=checksitedid');"
											 class="admin_company_xg_icon">
												<span class="admin_company_xg_icon">重新分配</span>
											</a>
										</div>
									</td>
									<td>
										<div class="admin_new_bth_c">
											<a href="javascript:void(0)" class="admin_new_c_bth admin_new_c_bthsh" onClick="show_status('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');">审核</a>
											<a href="index.php?m=admin_once&c=show&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="admin_new_c_bth admin_new_c_bth_yl">查看</a>
										</div>
										<a href="index.php?m=admin_once&c=edit&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="admin_new_c_bth ">修改</a>
										<a href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=admin_once&c=del&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');"
										 class="admin_new_c_bth admin_new_c_bth_sc">删除</a>
									</td>
								</tr>
								<?php } ?>
								<tr>
									<td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
									<td colspan="10"><label for="chkAll2">全选</label>
										&nbsp;
										<input class="admin_button" type="button" name="delsub" value="删除所选" onClick="return really('del[]')" />
										&nbsp;&nbsp;
										<input class="admin_button" type="button" name="delsub" value="批量审核" onClick="audall('1');" />
										&nbsp;&nbsp;
										<input class="admin_button" type="button" name="delsub" value="批量取消审核" onClick="audall('0');" />
										&nbsp;&nbsp;
										<input class="admin_button" type="button" onClick="audall2();" value="批量延期">
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
										<td colspan="8" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
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
		<div id="preview" style="display:none;width:460px">
			<div style="overflow:auto;width:430px;padding: 0 15px 15px 15px;">
				<form method="post" class="layui-form">
					<input id="statusid" type="hidden">
					<div class="adminonce_list_box">
						
						<div class="adminonce_list_tit">招聘内容</div>
						
						<div class="adminonce_list_p">
							<div class="adminonce_list">
								<span class="adminonce_name">职位名称：</span>
								<span class="adminonce_p" id="title"></span>
								<span class="adminonce_name_r">工 资：<em class="" id="salary"></em></span>
							</div>
							<div class="adminonce_list">
								<span class="adminonce_name">店面名称：</span>
								<span class="adminonce_p" id="companyname"></span>
							</div>
							<div class="adminonce_list">
								<span class="adminonce_name">具体要求：</span>
								<span class="adminonce_p">
									<div style="max-height:70px;_height:70px; overflow:hidden; overflow-y:auto;word-break:break-all; ">
										<div class="" id="require"></div>
									</div>
								</span>
							</div>
							<div class="adminonce_list"> <span class="adminonce_name">发布时间：</span>
								<span class="adminonce_p" id="time"></span>
								<span class="adminonce_name_r">有效期：</span>
								<span class="adminonce_p" id="edate"></span>
							</div>
						</div>
						<div class="adminonce_list_tit">联系方式</div>
						
						<div class="adminonce_list_p">
							<div class="adminonce_list">
								<span class="adminonce_name">联系电话：</span>
								<span class="adminonce_p" id="phone"></span>
								<span class="adminonce_name_r">联系人：</span>
								<span class="adminonce_p" id="linkman"></span>
							</div>
							<div class="adminonce_list">
								<span class="adminonce_name">工作地点：</span>
								<span class="adminonce_p" id="address"></span>

							</div>
						</div>

						<div style="padding:5px 5px 5px 20px;border-top:1px solid #eee;margin-top:10px;">
							<div class="adminonce_list">
								<span class="adminonce_name" style="top: 14px;">具体要求：</span>
								<div class="layui-input-block">
									<input name="status" id="status_1" value="1" title="已审核" type="radio" />
									<input name="status" id="status_2" value="2" title="审核并确认订单" type="radio" />
								</div>

							</div>
						</div>
						<div class="layui-input-block">
							<div class="layui-input-block" style="text-align: center;">
								<input class="adminonce_list_bth" type="button" onClick="check_status();" value="提交">
							</div>
						</div>
						
						<div>
							<div>
								<div class="adminonce_list_bthbox"> </div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<?php echo '<script'; ?>
 type="text/javascript">
			layui.use(['layer', 'form'], function() {
				var layer = layui.layer,
					form = layui.form,
					$ = layui.$;
			});

			$(document).ready(function() {
				$(".preview").hover(
					function() {
						var pic_url = $(this).attr('url');
						layer.tips("<img src=" + pic_url + " style='width:180px;height:180px;' >", this);
					},
					function() {
						layer.closeAll('tips');
					}
				);
				$.get("index.php?m=admin_once&c=onceNum", function(data) {
					var datas = eval('(' + data + ')');
					if (datas.onceAllNum) {
						$('.ajaxonceall').html(datas.onceAllNum);
					}
					if (datas.onceStatusNum1) {
						$('.onceStatusNum1').html(datas.onceStatusNum1);
					}
					if (datas.onceStatusNum2) {
						$('.onceStatusNum2').html(datas.onceStatusNum2);
					}

				});
			});

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
					parent.layer.msg("您还未选择任何信息！", 2, 8);
					return false;
				} else {
					var pytoken = $("#pytoken").val();
					loadlayer();
					$.post("index.php?m=admin_once&c=status", {
						allid: codewebarr,
						status: status,
						pytoken: pytoken
					}, function(data) {
						parent.layer.closeAll('loading');
						if (data == "1") {
							parent.layer.msg("批量审核成功！", 2, 9, function() {
								window.location.reload();
							});
						} else if (data == "3") {
							parent.layer.msg('店铺未付款！', 2, 8, function() {
								window.location.reload();
							});
						} else {
							parent.layer.msg('取消审核成功！', 2, 9, function() {
								window.location.reload();
							});
						}
					});
				}
			}

			function audall2() {
				var codewebarr = "";
				$(".check_all:checked").each(function() { //由于复选框一般选中的是多个,所以可以循环输出 
					if (codewebarr == "") {
						codewebarr = $(this).val();
					} else {
						codewebarr = codewebarr + "," + $(this).val();
					}
				});
				if (codewebarr == "") {
					parent.layer.msg("您还未选择任何信息！", 2, 8);
					return false;
				} else {
					$("input[name=onceids]").val(codewebarr);
					$.layer({
						type: 1,
						title: '批量延期',
						closeBtn: [0, true],
						border: [10, 0.3, '#000', true],
						area: ['290px', '180px'],
						offset: ['60px', ''],
						page: {
							dom: "#infobox2"
						}
					});
				}
			}

			function show_status(id) {
				$.get("index.php?m=admin_once&c=ajax&id=" + id, function(data) {
					var data = eval('(' + data + ')');
					$("#title").html(data.title);
					$("#companyname").html(data.companyname);
					$("#require").html(data.require_n);
					$("#address").html(data.address);
					$("#phone").html(data.phone);
					$("#salary").html(data.salary);
					$("#linkman").html(data.linkman);
					$("#city").html(data.city);
					$("#time").html(data.ctime_n);
					$("#edate").html(data.edate_n);

					$("#status_" + data.status).attr("checked", "checked");
					layui.use(['form'], function() {
						var form = layui.form;
						form.render();
					});
					$("#statusid").val(id);
					$.layer({
						type: 1,
						title: '审核操作',
						closeBtn: [0, true],
						offset: ['20%', '30%'],
						border: [10, 0.3, '#000', true],
						area: ['460px', '440px'],
						page: {
							dom: '#preview'
						}
					});
				})
			}

			function check_status() {
				var id = $("#statusid").val();
				var pytoken = $("#pytoken").val();
				var status = $("input[name='status']:checked").val();
				loadlayer();
				$.post("index.php?m=admin_once&c=status", {
					allid: id,
					status: status,
					pytoken: pytoken
				}, function(data) {
					parent.layer.closeAll('loading');
					if (data == "1") {
						parent.layer.msg('审核成功！', 2, 9, function() {
							window.location.reload();
						});
					} else if (data == "3") {
						parent.layer.msg('店铺未付款！', 2, 8, function() {
							window.location.reload();
						});
					} else {
						parent.layer.msg('取消审核成功！', 2, 9, function() {
							window.location.reload();
						});
					}
				});
			}
		<?php echo '</script'; ?>
>
		<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['adminstyle']->value)."/checkdomain.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	</body>
</html>
<?php }} ?>
