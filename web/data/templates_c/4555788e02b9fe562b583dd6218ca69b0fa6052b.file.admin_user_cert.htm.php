<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:15:50
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_user_cert.htm" */ ?>
<?php /*%%SmartyHeaderCode:3191162d8fd26131bb2-62973275%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4555788e02b9fe562b583dd6218ca69b0fa6052b' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_user_cert.htm',
      1 => 1634883865,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3191162d8fd26131bb2-62973275',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'total' => 0,
    'rows' => 0,
    'key' => 0,
    'v' => 0,
    'pagenum' => 0,
    'pages' => 0,
    'pagenav' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d8fd26234393_96951601',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d8fd26234393_96951601')) {function content_62d8fd26234393_96951601($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\modifier.date_format.php';
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
		<div class="infoboxp">
			<div class="tty-tishi_top">


				<div class="clear"></div>

				<div class="admin_new_search_box">
					<form action="index.php" name="myform" method="get">
						<input name="m" value="usercert" type="hidden" />
						<div class="admin_new_search_name">关键字：</div>
						<input type="text" placeholder="输入你要搜索的关键字" value="<?php echo $_GET['keyword'];?>
" name='keyword' class="admin_new_text">
						<input type="submit" name='search' value="搜索" class="admin_new_bth">

						<a href="javascript:void(0)" onclick="$('.admin_screenlist_box').toggle();" class="admin_new_search_gj">高级搜索</a>
					</form>

					<?php echo $_smarty_tpl->getSubTemplate ("admin/admin_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

				</div>
				<div class="clear"></div>
			</div>
			<div class="tty_table-bom">
				<div class="admin_statistics">
					<span class="tty_sjtj_color">数据统计：</span>
					<em class="admin_statistics_s">总数：<a href="index.php?m=usercert" class="ajaxIdCardAll">0</a></em>
					<em class="admin_statistics_s">未审核：<a href="index.php?m=usercert&status=2" class="ajaxIdCardNum1">0</a></em>
					<em class="admin_statistics_s">未通过：<a href="index.php?m=usercert&status=3" class="ajaxIdCardNum2">0</a></em>
					搜索结果：<span><?php echo $_smarty_tpl->tpl_vars['total']->value;?>
</span>；
				</div>

				<div class="table-list">
					<div class="admin_table_border">
						<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
						<form action="index.php?m=usercert&c=del" name="myform" id='myform' method="post" target="supportiframe">
							<table width="100%">
								<thead>
									<tr class="admin_table_top">
										<th style="width:20px;"> <label for="chkall">
												<input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' />
											</label>
										</th>
										<th>
											<?php if ($_GET['t']=="uid"&&$_GET['order']=="asc") {?>
											<a href="index.php?m=usercert&order=desc&t=uid">UID<img src="images/sanj.jpg" /></a>
											<?php } else { ?>
											<a href="index.php?m=usercert&order=asc&t=uid">UID<img src="images/sanj2.jpg" /></a>
											<?php }?>
										</th>
										<th align="left">认证人</th>
										<th align="left">身份证号</th>
										<th>查看</th>
										<th>
											<?php if ($_GET['t']=="cert_time"&&$_GET['order']=="asc") {?>
											<a href="index.php?m=usercert&order=desc&t=cert_time">申请时间<img src="images/sanj.jpg" /></a>
											<?php } else { ?>
											<a href="index.php?m=usercert&order=asc&t=cert_time">申请时间<img src="images/sanj2.jpg" /></a>
											<?php }?>
										</th>
										<th>状态</th>
										<th width="150" class="admin_table_th_bg">操作</th>
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
									<tr align="center" <?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?> class="admin_com_td_bg" <?php }?> id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
">
										<td><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" name='del[]' class="check_all" onclick='unselectall()'
											 rel="del_chk" /></td>
										<td align="left" class="td1" style="text-align:center;"><span><?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
</span></td>
										<td class="ud" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['username_n'];?>
</td>
										<td align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['idcard'];?>
</td>
										<td class="gd">
											<a href="javascript:void(0)" onClick="preview('<?php echo $_smarty_tpl->tpl_vars['v']->value['idcard_pic'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['idcard_status'];?>
')"
											 class="admin_cz_sc admin_n_img"></a></td>
										<td class="td"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['cert_time'],"%Y-%m-%d %H:%M");?>
</td>
										<td>
											<?php if ($_smarty_tpl->tpl_vars['v']->value['idcard_status']==1) {?>
											<span class="admin_com_Audited">已审核</span>
											<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['idcard_status']==0) {?>
											<span class="admin_com_noAudited">未审核</span>
											<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['idcard_status']==2) {?>
											<span class="admin_com_tg">未通过</span>
											<?php }?>
										</td>
										<td>
											<a href="javascript:;" uid="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" url="<?php echo $_smarty_tpl->tpl_vars['v']->value['idcard_pic'];?>
" status="<?php echo $_smarty_tpl->tpl_vars['v']->value['idcard_status'];?>
"
											 class="admin_new_c_bth admin_new_c_bthsh status">审核</a>
											<a href="javascript:void(0)" onclick="layer_del('确定要删除？', 'index.php?m=usercert&c=del&del=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
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
											<input class="admin_button" type="button" name="delsub" value="批量取消审核" onClick="audall('0');" /></td>
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
											<td colspan="12" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
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
		<div id="preview" style="display:none;">
			<div style="overflow:auto;">
				<form class="layui-form" action="index.php?m=usercert&c=status" target="supportiframe" method="post" onsubmit="return htStatus()">
					<table cellspacing='1' cellpadding='1' class="admin_examine_table" style="border-collapse: separate;border-spacing: 5px 8px;">
						<tr>
							<th width="80" class="t_fr">认证图片：</th>
							<td align="left">
								<div class="job_box_div" style="float:left;border:1px solid #eee;"></div> <a href="javascript:;" onclick="showpic(this)"
								 id='preview_url' data_url='' style="line-height:70px; padding-left:10px;">查看原图</a>
							</td>
						</tr>
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
							<td align="left"> <textarea id="alertcontent" name="statusbody" class="admin_explain_textarea"></textarea></td>
						</tr>
						<tr>
							<td colspan='2' align="center">
								<div>
									<input type="submit" value='确认' class="admin_examine_bth">
									<input type="button" onClick="layer.closeAll();" class="admin_examine_bth_qx" value='取消'>
								</div>
							</td>
						</tr>
					</table>
					<input name="uid" value="0" type="hidden">
					<input type="hidden" name="pytoken" id="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
				</form>
			</div>
		</div>
		<?php echo '<script'; ?>
 type="text/javascript">
			var form = null;
			layui.use(['layer', 'form'], function() {
				var layer = layui.layer,
					$ = layui.$;
				form = layui.form;
			});
			$(function() {
				$(".status").click(function() {
					var uid = $(this).attr("uid");
					var url = $(this).attr("url");
					var status = $(this).attr("status");
					var pytoken = $("#pytoken").val();
					$("#status" + status).attr("checked", true);
					$("input[name=uid]").val(uid);

					form.render();

					if (url) {
						preview(url, uid, status);
					} else {
						$.post("index.php?m=usercert&c=sbody", {
							uid: uid,
							pytoken: pytoken
						}, function(msg) {
							$("#alertcontent").val(msg);
							status_div('用户认证审核', '390', '240');
						});
					}
				});
				$.get("index.php?m=usercert&c=idCardNum", function(data) {
					var datas = eval('(' + data + ')');
					if (datas.idCardAll) {
						$('.ajaxIdCardAll').html(datas.idCardAll);
					}
					if (datas.idCardNum1) {
						$('.ajaxIdCardNum1').html(datas.idCardNum1);
					}
					if (datas.idCardNum2) {
						$('.ajaxIdCardNum2').html(datas.idCardNum2);
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
					parent.layer.msg('您还未选择任何信息！', 2, 8);
					return false;
				} else {
					var pytoken = $("#pytoken").val();
					loadlayer();
					$.post("index.php?m=usercert&c=status", {
						uid: codewebarr,
						status: status,
						type: 1,
						pytoken: pytoken
					}, function(data) {

						parent.layer.closeAll('loading');
						if (data) {
							var data = eval('(' + data + ')');
							if (data.errcode == 9) {
								if (status == '1') {
									parent.layer.msg('批量审核成功！', 2, 9, function() {
										window.location.reload();
									});
								} else if (status == '0') {
									parent.layer.msg('批量取消审核成功！', 2, 9, function() {
										window.location.reload();
									});
								}
							} else {
								parent.layer.msg('操作失败', 2, 8, function() {
									window.location.reload();
								});
							}
						}
					});
				}
			}

			function preview(url, uid, status) {
				$(".job_box_div").html("<img src='" + url + "' style='width:180px;height:70px' />");
				$("#preview_url").attr("data_url", url);
				var pytoken = $('#pytoken').val();
				$("#status" + status).attr("checked", true);
				layui.use(['form'], function() {
					var form = layui.form;
					form.render();
				});
				$("input[name=uid]").val(uid);
				$.post("index.php?m=usercert&c=sbody", {
					uid: uid,
					pytoken: pytoken
				}, function(msg) {
					$("#alertcontent").val(msg);
				});
				$.layer({
					type: 1,
					title: '查看图片',
					offset: ['80px', ''],
					closeBtn: [0, true],
					border: [10, 0.3, '#000', true],
					area: ['370px', '350px'],
					page: {
						dom: '#preview'
					}
				});
			}

			function showpic(obj) {
				var url = $(obj).attr('data_url');
				var picjson = {
					"data": [{
						"src": url, //原图地址
						"thumb": url //缩略图地址
					}]
				}
				layer.photos({
					photos: picjson
					,shade: 0.3
					,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
				});
			}
		<?php echo '</script'; ?>
>
	</body>
</html>
<?php }} ?>
