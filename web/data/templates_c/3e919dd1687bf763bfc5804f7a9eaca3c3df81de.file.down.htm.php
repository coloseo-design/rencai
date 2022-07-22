<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:15:59
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\down.htm" */ ?>
<?php /*%%SmartyHeaderCode:2730862d8fd2fc29427-53638269%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3e919dd1687bf763bfc5804f7a9eaca3c3df81de' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\down.htm',
      1 => 1643012867,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2730862d8fd2fc29427-53638269',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'list' => 0,
    'key' => 0,
    'v' => 0,
    'total' => 0,
    'pagenum' => 0,
    'pages' => 0,
    'pagenav' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d8fd2fd30757_22443038',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d8fd2fd30757_22443038')) {function content_62d8fd2fd30757_22443038($_smarty_tpl) {?><?php if (!is_callable('smarty_function_searchurl')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.searchurl.php';
if (!is_callable('smarty_function_url')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.url.php';
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
		<title>后台管理</title>
	</head>

	<body class="body_ifm">
		<div class="infoboxp">

			<div class="tty-tishi_top">
			<div class="tabs_info">
				<ul>
					<li <?php if ($_GET['c']=='') {?>class="curr"<?php }?>> <a href="index.php?m=admin_userlog&comid=<?php echo $_GET['comid'];?>
">简历下载记录</a>
					</li>
					<li <?php if ($_GET['c']=="trust") {?>class="curr"<?php }?>> <a href="index.php?m=admin_userlog&c=trust&comid=<?php echo $_GET['comid'];?>
">简历推送记录</a>
					</li>
					<li <?php if ($_GET['c']=="lookresume") {?>class="curr"<?php }?>> <a href="index.php?m=admin_userlog&c=lookresume&comid=<?php echo $_GET['comid'];?>
">简历浏览记录</a>
					</li>
					<li <?php if ($_GET['c']=="favjob") {?>class="curr"<?php }?>> <a href="index.php?m=admin_userlog&c=favjob">职位收藏记录</a>
					</li>
				</ul>
			</div>


			<div class="clear"></div>

			<div class="admin_new_search_box">
				<form action="index.php" name="myform" method="get">
					<input name="m" value="admin_userlog" type="hidden" />
					<input name="comid" value="<?php echo $_GET['comid'];?>
" type="hidden" />
					<div class="admin_new_search_name">搜索类型：</div>

					<div class="admin_Filter_text formselect" did='dtype'>
						<input type="button" value="<?php if ($_GET['type']=='1'||$_GET['type']=='') {?>企业用户名<?php } elseif ($_GET['type']=='2') {?>公司名称<?php } elseif ($_GET['type']=='3') {?>个人用户名<?php } else { ?>简历名称<?php }?>" class="admin_Filter_but" id="btype"/>
						<input type="hidden" id='type' value="<?php if ($_GET['type']) {
echo $_GET['type'];
} else { ?>1<?php }?>" name='type'/>
						<div class="admin_Filter_text_box" style="display:none" id='dtype'>
							<ul>
								<li><a href="javascript:void(0)" onClick="formselect('1','type','企业用户名')">企业用户名</a></li>
								<li><a href="javascript:void(0)" onClick="formselect('2','type','公司名称')">公司名称</a></li>
								<li><a href="javascript:void(0)" onClick="formselect('3','type','个人用户名')">个人用户名</a></li>
								<li><a href="javascript:void(0)" onClick="formselect('4','type','简历名称')">简历名称</a></li>
							</ul>
						</div>
					</div>

					<input class="admin_new_text" type="text" name="keyword" value="<?php echo $_GET['keyword'];?>
" size="25" placeholder="请输入你要搜索的关键字"/>
					<input class="admin_new_bth" type="submit" name="search" value="检索" />
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
					<form action="index.php?m=admin_userlog&c=deldown" name="myform" id="myform" method="post" target="supportiframe">
						<table width="100%">
							<thead>
								<tr class="admin_table_top">
									<th style="width:20px;">
										<label for="chkall">
											<input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' />
										</label>
									</th>
									<th>
										<?php if ($_GET['t']=="id"&&$_GET['order']=="asc") {?>
										<a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'id','m'=>'admin_userlog','untype'=>'order,t'),$_smarty_tpl);?>
">编号<img src="images/sanj.jpg" /></a>
										<?php } else { ?>
										<a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'id','m'=>'admin_userlog','untype'=>'order,t'),$_smarty_tpl);?>
">编号<img src="images/sanj2.jpg" /></a>
										<?php }?>
									</th>
									<th align="left">联系人/手机号</th>
									<th align="left">企业/猎头名称</th>
									<th align="left">姓名/手机号</th>
									<th align="left">简历名称</th>
									<th>
										<?php if ($_GET['t']=="downtime"&&$_GET['order']=="asc") {?>
										<a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'downtime','m'=>'admin_userlog','untype'=>'order,t'),$_smarty_tpl);?>
">下载时间<img src="images/sanj.jpg" /></a>
										<?php } else { ?>
										<a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'downtime','m'=>'admin_userlog','untype'=>'order,t'),$_smarty_tpl);?>
">下载时间<img src="images/sanj2.jpg" /></a>
										<?php }?>
									</th>
									<th align="left">状态</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
								<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
								<tr align="center" <?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg"<?php }?> id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
									<td><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name='del[]' onclick='unselectall()' rel="del_chk" /></td>
									<td align="left" class="td1" style="text-align:center;"><span><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</span></td>
									<?php if ($_smarty_tpl->tpl_vars['v']->value['usertype']==3) {?>
									<td align="left">
										<a href="<?php echo smarty_function_url(array('m'=>'lietou','c'=>'headhunter','uid'=>$_smarty_tpl->tpl_vars['v']->value['comid']),$_smarty_tpl);?>
" target="_blank" class="admin_cz_sc"><?php echo $_smarty_tpl->tpl_vars['v']->value['com_username'];?>
</a>
										<div >
											<?php echo $_smarty_tpl->tpl_vars['v']->value['telPho'];?>

										</div>
									</td>
									<td align="left"><a href="<?php echo smarty_function_url(array('m'=>'lietou','c'=>'headhunter','uid'=>$_smarty_tpl->tpl_vars['v']->value['comid']),$_smarty_tpl);?>
" target="_blank" class="admin_cz_sc"><?php echo $_smarty_tpl->tpl_vars['v']->value['com_name'];?>
</a></td>
									<?php } else { ?>
									<td align="left">
										<a href="<?php echo smarty_function_url(array('m'=>'company','c'=>'show','id'=>$_smarty_tpl->tpl_vars['v']->value['comid']),$_smarty_tpl);?>
" target="_blank" class="admin_cz_sc"><?php echo $_smarty_tpl->tpl_vars['v']->value['com_username'];?>
</a>
										<div >
											<?php echo $_smarty_tpl->tpl_vars['v']->value['telPho'];?>

										</div>
									</td>
									<td align="left"><a href="<?php echo smarty_function_url(array('m'=>'company','c'=>'show','id'=>$_smarty_tpl->tpl_vars['v']->value['comid']),$_smarty_tpl);?>
" target="_blank" class="admin_cz_sc"><?php echo $_smarty_tpl->tpl_vars['v']->value['com_name'];?>
</a></td>
									<?php }?>
									<td align="left">
										<a class="admin_cz_sc resume-preview" href="javascript:void(0);" pid="<?php echo $_smarty_tpl->tpl_vars['v']->value['eid'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['username'];?>
</a>
										<div >
											<?php echo $_smarty_tpl->tpl_vars['v']->value['telMob'];?>

										</div>
									</td>
									<td align="left"><a class="admin_cz_sc resume-preview" href="javascript:void(0);" pid="<?php echo $_smarty_tpl->tpl_vars['v']->value['eid'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['resume'];?>
</a></td>
									<td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['downtime'],"%Y-%m-%d %H:%M");?>
</td>
									<td align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['isdel_n'];?>
</td>
									<td>
										<a href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=admin_userlog&c=deldown&del=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" class="admin_new_c_bth admin_new_c_bth_sc">删除</a>
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
 ，总共<?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</td>
									<?php }?>
									<td colspan="6" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
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
	<?php echo '<script'; ?>
 type="text/javascript">
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
	<?php echo '</script'; ?>
>
	</body>
</html>
<?php }} ?>
