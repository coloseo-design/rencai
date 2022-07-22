<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-08 16:17:38
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_zphnet_list.htm" */ ?>
<?php /*%%SmartyHeaderCode:918962c7e822a93299-75757957%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9c4798732904049dc24018246a0fa8ed9fbf505e' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_zphnet_list.htm',
      1 => 1640333834,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '918962c7e822a93299-75757957',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
    'rows' => 0,
    'v' => 0,
    'area' => 0,
    'Dname' => 0,
    'total' => 0,
    'pagenum' => 0,
    'pages' => 0,
    'pagenav' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c7e822b55318_43109797',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c7e822b55318_43109797')) {function content_62c7e822b55318_43109797($_smarty_tpl) {?><?php if (!is_callable('smarty_function_searchurl')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.searchurl.php';
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
		<!-- 招聘会开启/隐藏弹框 -->
		<div id="upisopen" style="display:none;width:450px;padding: 10px 0;">
			<div style="overflow:auto;width:450px;">
				<form class="layui-form" name="formstatus" action="index.php?m=admin_zphnet&c=upisopen" target="supportiframe" method="post">
					<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
					<table cellspacing='1' cellpadding='1' class="admin_examine_table">
						<tr>
							<th>招聘会标题：</th>
							<td align="left"><span id="zphtitle"></span></td>
						</tr>						
						<tr>
							<th class="t_fr">招聘会显示状态：</th>
							<td align="left">
								<div class="layui-input-block">
									<input name="is_open" value="1" id="is_open1" title="开启" type="radio" lay-filter="is_open" />
									<input name="is_open" value="0" id="is_open0" title="隐藏" type="radio" lay-filter="is_open" />
								</div>
							</td>
						</tr>
						<tr>
							<td colspan='2' align="center">
								<input name="pid" value="0" type="hidden">
								<input type="submit" value='确认' class="admin_examine_bth"> 
								<input type="button" onClick="layer.closeAll();" class="admin_examine_bth_qx" value='取消'>
							</td>
						</tr>
					</table>					
				</form>
			</div>
		</div>
		<div class="infoboxp">
			<div class="tty-tishi_top">


				<div class="clear"></div>

				<div class="admin_new_search_box">
					<form action="index.php" name="myform" method="get">
						<input name="m" value="admin_zphnet" type="hidden" />
						<input type="hidden" name="status" value="<?php echo $_GET['status'];?>
" />
						<div class="admin_new_search_name">招聘会名称:</div>
						<input class="admin_Filter_search" type="text" name="keyword" maxlength="25" placeholder="请输入您要搜索的关键字">
						<input class="admin_Filter_bth" type="submit" value="搜索" />
						<a href="javascript:void(0)" onclick="$('.admin_screenlist_box').toggle();" class="admin_new_search_gj">高级搜索</a>
						<a href="index.php?m=admin_zphnet&c=add" class="admin_new_cz_tj" style="width:120px">+ 添加网络招聘会</a>
						<a href="index.php?m=admin_zphnet&c=getClass" class="admin_new_cz_tj" style="width:120px">展会区域管理</a>
					</form>
					<?php echo $_smarty_tpl->getSubTemplate ("admin/admin_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

				</div>
				<div class="clear"></div>
			</div>

			<div class="tty_table-bom">
				<div class="table-list">
					<div class="admin_table_border">
						<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
						<form action="index.php?m=admin_zphnet&c=del" name="myform" method="post" target="supportiframe" id='myform'>
							<table width="100%">
								<thead>
									<tr class="admin_table_top">
										<th style="width:20px;">
											<label for="chkall">
												<input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' />
											</label>
										</th>
										<th width="70"> <?php if ($_GET['t']=="id"&&$_GET['order']=="asc") {?> <a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'id','m'=>'admin_zphnet','untype'=>'order,t'),$_smarty_tpl);?>
">编号<img
											 src="images/sanj.jpg" /></a> <?php } else { ?> <a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'id','m'=>'admin_zphnet','untype'=>'order,t'),$_smarty_tpl);?>
">编号<img
											 src="images/sanj2.jpg" /></a> <?php }?> </th>
										<th align="left" >招聘会名称</th>
										 
										<th align="center">开始/结束时间</th>
										<th>展会区域</th>
										<th>浏览数量</th>
										<th>参会企业</th>
										<th>参会个人</th>
										<th>视频面试</th>
										<th>分站</th>
										<th>显示状态</th>
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
										<td style="width:20px;">
											<input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="check_all" name='del[]' onclick='unselectall()' rel="del_chk" />
										</td>
										<td class="ud"><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</td>
										<td class="ud" align="left">
									<div style="width:200px;"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</div>
										</td>

										<td class="od" align="center"><?php echo $_smarty_tpl->tpl_vars['v']->value['starttime'];?>
 <br/> <?php echo $_smarty_tpl->tpl_vars['v']->value['endtime'];?>
</td>
										<td>
											<div><?php echo $_smarty_tpl->tpl_vars['area']->value[$_smarty_tpl->tpl_vars['v']->value['zw']];?>
</div>
										</td>
										<td>
											<div><?php echo $_smarty_tpl->tpl_vars['v']->value['hits'];?>
</div>
										</td>
										<td>
											<div class="admin_zph_ch_p">
												<?php echo $_smarty_tpl->tpl_vars['v']->value['comnum']+$_smarty_tpl->tpl_vars['v']->value['pnum'];?>

												<?php if ($_smarty_tpl->tpl_vars['v']->value['booking']!=0) {?>
												<a href="index.php?m=admin_zphnet&c=com&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
&status=3" class="admin_zph_ch_p_n" title="待审核企业"><?php echo $_smarty_tpl->tpl_vars['v']->value['booking'];?>
</a>
												<?php }?>
											</div>
											<div class="mt5"><a href='index.php?m=admin_zphnet&c=com&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
' class="admin_company_xg_icon">查看</a></div>
										</td>
										<td>
											<div class="admin_zph_ch_p">
												<?php if ($_smarty_tpl->tpl_vars['v']->value['usernum']!='') {
echo $_smarty_tpl->tpl_vars['v']->value['usernum'];?>

												<?php } else { ?>
												0
												<?php }?>
											</div>
											<div class="mt5"><a href='index.php?m=admin_zphnet&c=user&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
' class="admin_company_xg_icon">查看</a></div>											
										</td>
										<td>
										<div class="admin_zph_ch_p">
											<?php if ($_smarty_tpl->tpl_vars['v']->value['spnum']) {
echo $_smarty_tpl->tpl_vars['v']->value['spnum'];
} else { ?>0<?php }?>次/<?php if ($_smarty_tpl->tpl_vars['v']->value['sptime_total']) {
echo $_smarty_tpl->tpl_vars['v']->value['sptime_total'];
} else { ?>0<?php }?>分钟
										</div>
										<div class="mt5"><a href='index.php?m=admin_splog&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
' class="admin_company_xg_icon">查看</a></div>
 									</td>
										<td>
											<div><?php echo $_smarty_tpl->tpl_vars['Dname']->value[$_smarty_tpl->tpl_vars['v']->value['did']];?>
</div>
											<div>
												<a href="javascript:;" onclick="checksite('<?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','index.php?m=admin_zphnet&c=checksitedid');"
												 class="admin_company_xg_icon">重新分配</a>
											</div>
										</td>
										<td>
											<?php if ($_smarty_tpl->tpl_vars['v']->value['is_open']==1) {?>
											<span>显示</span>
											<?php } else { ?>
											<span>隐藏</span>
											<?php }?>
										</td>
										<td>
										<div class="admin_new_bth_c">
											<a href="<?php echo smarty_function_url(array('m'=>'zphnet','c'=>'show','id'=>$_smarty_tpl->tpl_vars['v']->value['id']),$_smarty_tpl);?>
" target="_blank" class="admin_new_c_bth admin_new_c_bth_yl">预览</a>
											<a href="index.php?m=admin_zphnet&c=add&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="admin_new_c_bth ">修改</a>
										</div>	
										<div class="admin_new_bth_c">
											<a href="javascript:void(0)" onClick="layer_del('确定要删除？','index.php?m=admin_zphnet&c=del&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');"
											 class="admin_new_c_bth admin_new_c_bth_sc">删除</a>
											<a href="javascript:;" pid='<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
' ptitle='<?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
' pis='<?php echo $_smarty_tpl->tpl_vars['v']->value['is_open'];?>
' class="is_open" style="display:inline-block;width:56px;border:1px solid #e9e9e9;height:22px; line-height:22px; text-align:center;color:#999;border-radius: 3px; background:#fff; font-size:12px;">显示/隐藏</a>
										</div>		
										</td>
									</tr>
									<?php } ?>
									<tr>
										<td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
										<td colspan="12">
											<label for="chkAll2">全选</label>&nbsp;
											<input class="admin_button" type="button" name="delsub" value="删除所选" onclick="return really('del[]')" />
											<input class="admin_button" type="button" name="delsub" value="批量选择分站" onClick="checksiteall('index.php?m=admin_zphnet&c=checksitedid');" />
										</td>
									</tr>
									<?php if ($_smarty_tpl->tpl_vars['total']->value>$_smarty_tpl->tpl_vars['config']->value['sy_listnum']) {?>
									<tr>
										<?php if ($_smarty_tpl->tpl_vars['pagenum']->value==1) {?>
										<td colspan="3"> 从 1 到 <?php echo $_smarty_tpl->tpl_vars['config']->value['sy_listnum'];?>
 ，总共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</td>
										<?php } elseif ($_smarty_tpl->tpl_vars['pagenum']->value>1&&$_smarty_tpl->tpl_vars['pagenum']->value<$_smarty_tpl->tpl_vars['pages']->value) {?> <td colspan="3">
											从 <?php echo ($_smarty_tpl->tpl_vars['pagenum']->value-1)*$_smarty_tpl->tpl_vars['config']->value['sy_listnum']+1;?>
 到 <?php echo $_smarty_tpl->tpl_vars['pagenum']->value*$_smarty_tpl->tpl_vars['config']->value['sy_listnum'];?>
 ，总共
											<?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条
											</td>
											<?php } elseif ($_smarty_tpl->tpl_vars['pagenum']->value==$_smarty_tpl->tpl_vars['pages']->value) {?>
											<td colspan="3">
												从 <?php echo ($_smarty_tpl->tpl_vars['pagenum']->value-1)*$_smarty_tpl->tpl_vars['config']->value['sy_listnum']+1;?>
 到 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 ，总共<?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条
											</td>
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

		<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['adminstyle']->value)."/checkdomain.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


		<?php echo '<script'; ?>
 type="text/javascript">
			layui.use(['layer', 'form'], function() {
				var layer = layui.layer,
					form = layui.form,
					$ = layui.$;
			});
			/* 开启/隐藏 */
			$(".is_open").click(function(){
				var id = $(this).attr("pid");
				$("input[name=pid]").val($(this).attr("pid"));
				var zphtitle = $(this).attr("ptitle");
				$("#zphtitle").html(zphtitle);
				var pis = $(this).attr("pis");
				if (pis == 1){					
					$("#is_open1").attr("checked", true);
				}else{
					$("#is_open0").attr("checked", true);
				}
				$.layer({
					type: 1,
					title: '开启/隐藏操作',
					closeBtn: [0, true],
					offset: ['80px', ''],
					border: [10, 0.3, '#000', true],
					area: ['450px', 'auto'],
					page: {
						dom: '#upisopen'
					}
				});
				layui.use(['form'], function() {
					var form = layui.form;
					form.render();
				});
			})
		<?php echo '</script'; ?>
>
	</body>
</html>
<?php }} ?>
