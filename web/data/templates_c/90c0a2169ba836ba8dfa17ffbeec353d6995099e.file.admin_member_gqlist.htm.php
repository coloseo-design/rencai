<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-06 16:33:54
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_member_gqlist.htm" */ ?>
<?php /*%%SmartyHeaderCode:643262c548f2d2c665-57096213%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '90c0a2169ba836ba8dfa17ffbeec353d6995099e' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_member_gqlist.htm',
      1 => 1634883866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '643262c548f2d2c665-57096213',
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
  'unifunc' => 'content_62c548f2dbce88_28629901',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c548f2dbce88_28629901')) {function content_62c548f2dbce88_28629901($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
		<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['adminstyle']->value)."/member_send_email.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


		<div id="info_div" style="display:none; width: 390px; ">
			<div class="">
				<form class="layui-form" action="index.php?m=admin_gqmember&c=statis" target="supportiframe" method="post" onsubmit="return htStatus()">
					<table cellspacing='1' cellpadding='1' class="admin_examine_table">
						<tr>
							<th width="80">审核操作：</th>
							<td align="left">
								<div class="layui-input-block">
									<input name="status" id="state1" value="1" title="正常" type="radio" />
									<input name="status" id="state3" value="3" title="未通过" type="radio" />
								</div>
							</td>
						</tr>
						<tr>
							<th class="t_fr">审核说明：</th>
							<td align="left"> <textarea id="statusbody" name="statusbody" class="admin_explain_textarea"></textarea> </td>
						</tr>
						<tr>
							<td colspan='2' align="center">
								<input type="submit" value='确认' class="admin_examine_bth">
								<input type="button" id="zxxCancelBtn" onClick="layer.closeAll();" class="admin_examine_bth_qx" value='取消'>
							</td>
						</tr>
					</table>
					<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
					<input name="uid" value="0" type="hidden">
				</form>
			</div>
		</div>
		<div class="infoboxp">
			<div class="tty-tishi_top">
			<div class="tabs_info">
				<ul>
					<li class="curr">
						<a href="index.php?m=admin_gqmember">全部会员</a>
					</li>
					<li <?php if ($_GET['c']) {?>class="curr" <?php }?>> <a href="index.php?m=admin_gqmember&c=member_log">会员日志</a>
					</li>
				</ul>
			</div>
			
			<div class="clear"></div>
			<div class="admin_new_search_box">
				<form action="index.php" name="myform" method="get">
					<input name="m" value="admin_gqmember" type="hidden" />
					<div class="admin_new_search_name">搜索类型：</div>
					<div class="admin_Filter_text formselect" did='dkeytype'>
						<input type="button" <?php if ($_GET['keytype']==''||$_GET['keytype']=='1') {?> value="姓名" <?php } elseif ($_GET['keytype']=='2') {?> value="手机号" <?php } elseif ($_GET['keytype']=='3') {?> value="用户ID" <?php }?>
						 class="admin_Filter_but" id="bkeytype">

						<input type="hidden" name="type" id="keytype" <?php if ($_GET['keytype']==''||$_GET['keytype']=='1') {?>
						 value="1" <?php } elseif ($_GET['keytype']=='2') {?> value="2" <?php } elseif ($_GET['keytype']=='3') {?>
						 value="3" <?php }?>/> <div class="admin_Filter_text_box" style="display:none" id="dkeytype">
						<ul>
							<li>
								<a href="javascript:void(0)" onClick="formselect('1','keytype','姓名')">姓名</a>
							</li>
							<li>
								<a href="javascript:void(0)" onClick="formselect('2','keytype','手机号')">手机号</a>
							</li>
							<li>
								<a href="javascript:void(0)" onClick="formselect('3','keytype','用户ID')">用户ID</a>
							</li>
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
		<div class="admin_statistics">
			<span class="tty_sjtj_color">数据统计：</span>
			<em class="admin_statistics_s">总数：<a href="index.php?m=admin_gqmember" class="ajaxgqall">0</a></em>
			<em class="admin_statistics_s">未审核：<a href="index.php?m=admin_gqmember&status=4" class="gqStatusNum1">0</a></em>
			<em class="admin_statistics_s">未通过：<a href="index.php?m=admin_gqmember&status=3" class="gqStatusNum2">0</a></em>
			<em class="admin_statistics_s">已锁定：<a href="index.php?m=admin_gqmember&status=2" class="gqStatusNum3">0</a></em>
			搜索结果：<span><?php echo $_smarty_tpl->tpl_vars['total']->value;?>
</span>；
		</div>
		<div class="clear"></div>

		<div class="table-list">
			<div class="admin_table_border">
				<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
				<form action="index.php?m=admin_gqmember&c=delqgInfo" target="supportiframe" name="myform" method="post" id='myform'>
					<table width="100%">
						<thead>
							<tr class="admin_table_top">
								<th style="width:20px;">
									<label for="chkall"><input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' /></label>
								</th>
								<th align="left">
									<?php if ($_GET['t']=="uid"&&$_GET['order']=="asc") {?>
									<a href="index.php?m=admin_gqmember&order=desc&t=uid">用户ID<img src="images/sanj.jpg" /></a>
									<?php } else { ?>
									<a href="index.php?m=admin_gqmember&order=asc&t=uid">用户ID<img src="images/sanj2.jpg" /></a>
									<?php }?>
								</th>
								<th align="left">姓名</th>
								<th align="left">性别</th>
								<th align="left">手机号</th>
								<th align="left">所在城市</th>
								<th>审核状态</th>
								<th>操作</th>
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
							<tr <?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg" <?php }?> id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
">
								<td width="20"><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" class="check_all" name='del[]' onclick='unselectall()'
									 rel="del_chk" email="<?php echo $_smarty_tpl->tpl_vars['v']->value['email'];?>
" moblie="<?php echo $_smarty_tpl->tpl_vars['v']->value['telphone'];?>
" style="margin-left:5px;;" /></td>

								<td align="left" class="td1" style="width:60px;">
									<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>

								</td>
								<td align="left">
									<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>

								</td>
								<td align="left">
									<div>
										<span class="mt5"><?php echo $_smarty_tpl->tpl_vars['v']->value['sex_n'];?>
</span>
									</div>

								</td>

								<td align="left">
									<div>
										<span class="admin_new_sj"><?php echo $_smarty_tpl->tpl_vars['v']->value['moblie'];?>
</span>
									</div>

								</td>
								<td align="left">
									<div>
										<span class="mt5"><?php echo $_smarty_tpl->tpl_vars['v']->value['provinceid_n'];?>
-<?php echo $_smarty_tpl->tpl_vars['v']->value['cityid_n'];
if ($_smarty_tpl->tpl_vars['v']->value['three_cityid_n']) {?>-<?php echo $_smarty_tpl->tpl_vars['v']->value['three_cityid_n'];
}?></span>
									</div>

								</td>
								<td align="center">
									<?php if ($_smarty_tpl->tpl_vars['v']->value['status']==1) {?> <span class="admin_com_Audited">已审核</span>
									<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['status']==0) {?> <span class="admin_com_noAudited">未审核</span>

									<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['status']==3) {?> <span class="admin_com_tg">未通过</span> <?php }?>
									<a href="javascript:;" class=" admin_company_xg_icon check" pid="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" status="<?php echo $_smarty_tpl->tpl_vars['v']->value['status'];?>
">审核</a>

								</td>


								<td width="120">
									<a href="index.php?m=admin_gqmember&c=member_log&uid=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" class="admin_new_c_bth admin_new_c_rz">日志</a>
									<a href="index.php?m=admin_gqmember&c=edit&uid=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" class="admin_new_c_bth admin_n_sc mt5">修改</a>

									<a href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=admin_gqmember&c=delqgInfo&del=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
');"
									 class="admin_new_c_bth admin_new_c_bth_sc">删除</a>
									<a href="index.php?m=admin_gqmember&c=details&uid=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" class="admin_new_c_bth admin_new_c_rz">详情</a>
								</td>
							</tr>
							<?php } ?>
							<tr>
								<td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
								<td colspan="12"><label for="chkAll2">全选</label> &nbsp;
									<input class="admin_button" type="button" name="delsub" value="删除所选" onclick="return really('del[]')" />
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
									<td colspan="10" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
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
			$(document).ready(function() {
				$.get("index.php?m=admin_gqmember&c=gqNum", function(data) {
					var datas = eval('(' + data + ')');
					if (datas.gqAllNum) {
						$('.ajaxgqall').html(datas.gqAllNum);
					}
					if (datas.gqStatusNum1) {
						$('.gqStatusNum1').html(datas.gqStatusNum1);
					}
					if (datas.gqStatusNum2) {
						$('.gqStatusNum2').html(datas.gqStatusNum2);
					}
					if (datas.gqStatusNum3) {
						$('.gqStatusNum3').html(datas.gqStatusNum3);
					}
				});
				$(".check").click(function() {
					$("input[name=pid]").val($(this).attr("pid"));
					var uid = $(this).attr("pid");
					var status = $(this).attr("status");
					$("#state" + status).attr("checked", true);
					layui.use(['form'], function() {
						var form = layui.form;
						form.render();
					});
					$("input[name=uid]").val(uid);
					$.get("index.php?m=admin_gqmember&c=lockinfo&uid=" + uid, function(msg) {
						$("#statusbody").val($.trim(msg));
						$.layer({
							type: 1,
							title: '供求用户审核',
							closeBtn: [0, true],
							border: [10, 0.3, '#000', true],
							area: ['390px', '240px'],
							page: {
								dom: "#info_div"
							}
						});
					});
				});
			});
		<?php echo '</script'; ?>
>
		<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['adminstyle']->value)."/checkdomain.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	</body>

</html>
<?php }} ?>
