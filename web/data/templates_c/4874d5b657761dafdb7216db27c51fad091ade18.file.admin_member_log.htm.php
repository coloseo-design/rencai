<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:43:09
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_member_log.htm" */ ?>
<?php /*%%SmartyHeaderCode:1172162d9038d3d47e2-91952566%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4874d5b657761dafdb7216db27c51fad091ade18' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_member_log.htm',
      1 => 1643012867,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1172162d9038d3d47e2-91952566',
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
  'unifunc' => 'content_62d9038d4e6017_32927323',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d9038d4e6017_32927323')) {function content_62d9038d4e6017_32927323($_smarty_tpl) {?><?php if (!is_callable('smarty_function_searchurl')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.searchurl.php';
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
" rel="stylesheet" type="text/css" />
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
					<li <?php if ($_GET['utype']=='') {?>class="curr"<?php }?>> <a href="index.php?m=admin_memberlog">个人日志</a></li>
					<li <?php if ($_GET['utype']=="2") {?>class="curr"<?php }?>> <a href="index.php?m=admin_memberlog&utype=2">企业日志</a></li>
					<li <?php if ($_GET['utype']=="3") {?>class="curr"<?php }?>> <a href="index.php?m=admin_memberlog&utype=3">猎头日志</a></li>
					<li <?php if ($_GET['utype']=="4") {?>class="curr"<?php }?>> <a href="index.php?m=admin_memberlog&utype=4">培训日志</a></li>
					<li <?php if ($_GET['utype']=="5") {?>class="curr"<?php }?>> <a href="index.php?m=admin_memberlog&utype=5">供求日志</a></li>
				</ul>
			</div>

			<div class="clear"></div>
			<div class="admin_new_search_box">
				<form action="index.php" name="myform" method="get" onSubmit="return cktimesave()">
					<input name="m" value="admin_memberlog" type="hidden" />
					<input name="utype" value="<?php echo $_GET['utype'];?>
" type="hidden" />
					<div class="admin_Filter_text formselect" did='dkeytype'>
						<input type="button" <?php if ($_GET['type']==''||$_GET['type']=='1') {?> value="用户名" <?php } elseif ($_GET['type']=='3') {?> value="用户ID"<?php }?> class="admin_Filter_but" id="bkeytype">

						<input type="hidden" name="type" id="keytype" <?php if ($_GET['type']==''||$_GET['type']=='1') {?> value="1" <?php } elseif ($_GET['type']=='2') {?> value="2" <?php } elseif ($_GET['type']=='3') {?> value="3" <?php }?>/>
						<div class="admin_Filter_text_box" style="display:none" id="dkeytype">
							<ul>
								<li>
									<a href="javascript:void(0)" onClick="formselect('1','keytype','用户名')">用户名</a>
								</li>
								<li>
									<a href="javascript:void(0)" onClick="formselect('3','keytype','用户ID')">用户ID</a>
								</li>
							</ul>
						</div>
					</div>
					<input type="text" placeholder="请输入用户名 / ID" name='keyword' class="admin_Filter_search" value="<?php echo $_GET['keyword'];?>
" style="width: 150px;" />
					<div class="layui-input-inline" style="float: left;">
						<span class="admin_new_search_name">内容：</span>
						<input class="admin_Filter_search" type="text" value="<?php echo $_GET['content'];?>
" name="content" placeholder="请输入内容" autocomplete="off"  style="width: 150px;" />
					</div>
					<div class="layui-input-inline" style="float: left;">
						<span class="admin_new_search_name">时间段：</span>
						<input class="admin_Filter_search" type="text" id="time" value="<?php echo $_GET['time'];?>
" name="time" placeholder="请选择时段" autocomplete="off" />
						<i class="t_tc_icon_time"></i>
					</div>
					<input class="admin_Filter_bth" type="submit" value="搜索" />
				</form>
				<?php echo $_smarty_tpl->getSubTemplate ("admin/admin_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

			</div>
			<div class="clear"></div>
			</div>
			
			<div class="tty_table-bom">
			<div class="table-list">
				<div class="admin_table_border">
					<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
					<form action="index.php" name="myform" method="get" target="supportiframe" id='myform'>
						<input name="m" value="admin_memberlog" type="hidden" />
						<input name="c" value="dellog" type="hidden" />
						<table width="100%">
							<thead>
								<tr class="admin_table_top">
									<th style="width:20px;"><label for="chkall">
											<input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' />
										</label></th>
									<?php if ($_GET['t']=="id"&&$_GET['order']=="asc") {?>
									<th><a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'id','m'=>'admin_memberlog','untype'=>'order,t'),$_smarty_tpl);?>
">编号<img src="images/sanj.jpg" /></a></th>
									<?php } else { ?>
									<th><a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'id','m'=>'admin_memberlog','untype'=>'order,t'),$_smarty_tpl);?>
">编号<img src="images/sanj2.jpg" /></a></th>
									<?php }?>
									<th align="left">用户ID</th>
									<th align="left">用户名</th>
									
									<?php if ($_GET['utype']=='') {?>
									<th align="left" width="60">个人姓名</th>
									<?php } elseif ($_GET['utype']=="2") {?>
									<th align="left">企业名称</th>
									<?php } elseif ($_GET['utype']=="3") {?>
									<th align="left">猎头名称</th>
									<?php } elseif ($_GET['utype']=="4") {?>
									<th align="left">培训机构名称</th>
									<?php } elseif ($_GET['utype']=="5") {?>
									<th align="left">供求姓名</th>
									<?php }?>
									
									<th align="left">内容</th>
									<th width="120">IP</th>
									<?php if ($_GET['t']=="ctime"&&$_GET['order']=="asc") {?>
									<th width="140"><a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'ctime','m'=>'admin_memberlog','untype'=>'order,t'),$_smarty_tpl);?>
">时间<img src="images/sanj.jpg" /></a></th>
									<?php } else { ?>
									<th width="140"><a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'ctime','m'=>'admin_memberlog','untype'=>'order,t'),$_smarty_tpl);?>
">时间<img src="images/sanj2.jpg" /></a></th>
									<?php }?>
									<th class="admin_table_th_bg">操作</th>
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
" name='del[]' onclick='unselectall()' rel="del_chk" /></td>
									<td><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</td>
									<td align="left" class="td1" style="width:60px;">
										<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>

									</td>
									<td align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['username'];?>
</td>
									
									<?php if ($_GET['utype']=='') {?>
									<td align="left"><a class="admin_cz_sc resume-preview" href="javascript:void(0);" uid="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['rname'];?>
</a></td>
									<?php } elseif ($_GET['utype']=="2") {?>
									<td align="left"><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/company/index.php?c=show&look=admin&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" target="_blank" class="admin_cz_sc"><?php echo $_smarty_tpl->tpl_vars['v']->value['comname'];?>
</a></td>
									<?php } elseif ($_GET['utype']=="3") {?>
									<td align="left"><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/lietou/index.php?c=headhunter&look=admin&uid=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" target="_blank" class="admin_cz_sc"><?php echo $_smarty_tpl->tpl_vars['v']->value['ltname'];?>
</a></td>
									<?php } elseif ($_GET['utype']=="4") {?>
									<td align="left"><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/train/index.php?c=agencyshow&look=admin&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" target="_blank" class="admin_cz_sc"><?php echo $_smarty_tpl->tpl_vars['v']->value['pxname'];?>
</a></td>
									<?php } elseif ($_GET['utype']=="5") {?>
									<td align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['gqname'];?>
</td>
									<?php }?>
									
									
									
									<td align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['content'];?>
</td>
									<td width="120"><?php echo $_smarty_tpl->tpl_vars['v']->value['ip'];?>
</td>
									<td class="td"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['ctime'],"%Y-%m-%d %H:%M:%S");?>
</td>
									<td><a href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=admin_memberlog&c=dellog&del=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" class="admin_new_c_bth admin_new_c_bth_sc">删除</a></td>
								</tr>
								<?php } ?>
								<tr>
									<td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
									<td colspan="8">
										<label for="chkAll2">全选</label>&nbsp;
										<input class="admin_button" type="button" name="delsub" value="删除所选" onclick="return really('del[]')" />
										<?php if ($_GET['utype']=='') {?>
										<input class="admin_button" type="button"  value="一键删除"  onClick="layer_del('确定要清空个人日志？', 'index.php?m=admin_memberlog&c=dellog&del=alluser');"/>
										<?php } elseif ($_GET['utype']=="2") {?>
										<input class="admin_button" type="button" value="一键删除" onClick="layer_del('确定要清空企业日志？', 'index.php?m=admin_memberlog&c=dellog&del=allcom');" />
										<?php } elseif ($_GET['utype']=="3") {?>
										<input class="admin_button" type="button" value="一键删除" onClick="layer_del('确定要清空猎头日志？', 'index.php?m=admin_memberlog&c=dellog&del=alllt');" />
										<?php } elseif ($_GET['utype']=="4") {?>
										<input class="admin_button" type="button" value="一键删除" onClick="layer_del('确定要清空培训日志？', 'index.php?m=admin_memberlog&c=dellog&del=alltrain');" />
										<?php } elseif ($_GET['utype']=="5") {?>
										<input class="admin_button" type="button" value="一键删除" onClick="layer_del('确定要清空供求日志？', 'index.php?m=admin_memberlog&c=dellog&del=allgq');" />
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
										<td colspan="6" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
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
			layui.use(['laydate'], function() {
				var laydate = layui.laydate,
					$ = layui.$;
				laydate.render({
					elem: '#time',
					range: '~'
				});
			});

			$(".resume-preview").click(function() {
				var uid = $(this).attr("uid");
				$('body').css('overflow-y', 'hidden');
				$.layer({
					type: 2,
					shadeClose: true,
					title: '简历预览',
					area: ['755px', ($(window).height() - 30) +'px'],
					iframe: {src: 'index.php?m=admin_resume&c=resumePreview&uid='+uid},
					close: function(){
						$('body').css('overflow-y', '');
					}
				});
			});
		<?php echo '</script'; ?>
>
	</body>
</html>
<?php }} ?>
