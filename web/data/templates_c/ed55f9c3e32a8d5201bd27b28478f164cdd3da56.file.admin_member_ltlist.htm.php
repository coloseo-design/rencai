<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-06 16:40:57
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_member_ltlist.htm" */ ?>
<?php /*%%SmartyHeaderCode:2972562c54a99ddb569-30194186%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ed55f9c3e32a8d5201bd27b28478f164cdd3da56' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_member_ltlist.htm',
      1 => 1634883865,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2972562c54a99ddb569-30194186',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'ratingarr' => 0,
    'key' => 0,
    'ratlist' => 0,
    'pytoken' => 0,
    'total' => 0,
    'rows' => 0,
    'v' => 0,
    'Dname' => 0,
    'pagenum' => 0,
    'pages' => 0,
    'pagenav' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c54a99ed4033_28739592',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c54a99ed4033_28739592')) {function content_62c54a99ed4033_28739592($_smarty_tpl) {?><?php if (!is_callable('smarty_function_searchurl')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.searchurl.php';
if (!is_callable('smarty_modifier_date_format')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\modifier.date_format.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8">

		<link href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/css/layui.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet">
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

		<div id="comrating" style="display:none; width: 600px; ">
			<form class="layui-form" action="index.php?m=admin_lt_member&c=uprating" target="supportiframe" method="post" id="formstatus">
				<table cellspacing='1' cellpadding='1' class="admin_company_table">
					<tr>
						<td align="right"><span style="font-weight:bold;">会员等级：</span></td>
						<td align="left">
							<div class="layui-input-block" style="width: 162px;">
								<select name="rating" id="lt_rating_val" lay-filter="rating">
									<option value="">请选择</option>
									<?php  $_smarty_tpl->tpl_vars['ratlist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['ratlist']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['ratingarr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['ratlist']->key => $_smarty_tpl->tpl_vars['ratlist']->value) {
$_smarty_tpl->tpl_vars['ratlist']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['ratlist']->key;
?>
									<option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['ratlist']->value;?>
</option>
									<?php } ?>
								</select>
							</div>
						</td>
						<td align="right">账户<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
：</td>
						<td><input type="text" name="integral" id="integral" size="15" class="tty_input t_w150" value="" /></td>
					</tr>
					<tr class="admin_table_trbg">
						<td align="right"><span style="font-weight:bold;">会员到期时间：</span></td>
						<td>
							<p id="vipetime"></p>
						</td>
						<td align="right">延长会员有效期：</td>
						<td>
							<div class="layui-input-block">
 								<div class="layui-input-inline" style="width: 120px" id="timeInput">
                                	<input type="text" name="delaytime" id="delaytime" lay-verify="required" autocomplete="off" class="tty_input t_w150">
                                </div>
                            </div>
						</td>
					</tr>
					<tr>
						<td align="right">发布职位数：</td>
						<td>
							<input type="text" name="lt_job_num" id="lt_job_num" size="15" class="tty_input t_w150" value="" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'')" />
						</td>
						<td align="right">简历下载数：</td>
						<td><input type="text" name="lt_down_resume" id="lt_down_resume" size="15" class="tty_input t_w150" value="" /></td>
					</tr>
					<tr class="admin_table_trbg">
						<td align="right">刷新职位：</td>
						<td><input type="text" name="lt_breakjob_num" id="lt_breakjob_num" size="15" class="tty_input t_w150" value="" /></td>
						<td align="right"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_chat_name'];?>
对象数：</td>
						<td><input type="text" name="chat_num" id="chat_num" size="15" class="tty_input t_w150" value="" /></td>
					</tr>
					<tr style="text-align:center;margin-top:10px">
						<td colspan='4'>
							<input type="submit" value='确认' onclick="loadlayer();" class="submit_btn"> &nbsp;&nbsp;
							<input type="button" onClick="layer.closeAll();" class="cancel_btn" value='取消'>
						</td>
					</tr>
				</table>
				<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
				<input type="hidden" name="rating_name" id="rating_name" value="">
				<input type="hidden" name="oldetime" id="oldetime" value="">
				<input name="ratuid" id="ratuid" value="0" type="hidden">
			</form>
		</div>

		<div id="infobox2" style="display:none; width: 390px; ">
			<form class="layui-form" action="index.php?m=admin_lt_member&c=status" target="supportiframe" method="post" onsubmit="return htStatus()">
				<table cellspacing='1' cellpadding='1' class="admin_examine_table">
					<tr>
						<th width="80">审核操作：</th>
						<td align="left">
							<div class="layui-input-block">
								<input name="status" id="status1" value="1" title="已审核" type="radio" />
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
					<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
					<input name="uid" value="0" type="hidden">
				</table>
			</form>
		</div>
		<!---------邮箱认证----->
		<div id="ltrenemail" style="display:none;">
			<div class="mt10">
				<form class="layui-form" action="index.php?m=admin_lt_member&c=emailstatus" target="supportiframe" method="post">
					<table cellspacing='1' cellpadding='1' class="admin_examine_table">

						<tr>
							<th width="80">邮箱：</th>
							<td align="left">
								<div class="layui-input-block">
									<input type="text" class="input-text" id="ltemailmail" name="ltemailmail" value="">
								</div>
							</td>
						</tr>
						<tr>
							<th width="80">认证操作：</th>
							<td align="left">
								<div class="layui-input-block">
									<input name="estatus" id="ltestatus0" value="0" title="待认证" type="radio" />
									<input name="estatus" id="ltestatus1" value="1" title="已认证" type="radio" />
								</div>
							</td>
						</tr>
						<tr>
							<td colspan='2' align="center">
								<input type="submit" value='确认' onclick="loadlayer();" class="admin_examine_bth">
								<input type="button" onClick="layer.closeAll();" class="admin_examine_bth_qx" value='取消'>
							</td>
						</tr>
						<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
						<input name="uid" id="ltemailuid" value="0" type="hidden">
					</table>
				</form>
			</div>
		</div>

		<!---------手机认证----->
		<div id="ltrenphone" style="display:none;">
			<div class="mt10">
				<form class="layui-form" action="index.php?m=admin_lt_member&c=mobliestatus" target="supportiframe" method="post">
					<table cellspacing='1' cellpadding='1' class="admin_examine_table">

						<tr>
							<th width="80">手机号码：</th>
							<td align="left">
								<div class="layui-input-block">
									<input type="text" class="tty_input t_w200" id="ltphonemoblie" name="ltphonemoblie" value="">
								</div>
							</td>
						</tr>
						<tr>
							<th width="80">认证操作：</th>
							<td align="left">
								<div class="layui-input-block">
									<input name="mstatus" id="ltpstatus0" value="0" title="待认证" type="radio" />
									<input name="mstatus" id="ltpstatus1" value="1" title="已认证" type="radio" />
								</div>
							</td>
						</tr>
						<tr>
							<td colspan='2' align="center">
								<input type="submit" value='确认' onclick="loadlayer();" class="admin_examine_bth">
								<input type="button" onClick="layer.closeAll();" class="admin_examine_bth_qx" value='取消'>
							</td>
						</tr>
						<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
						<input name="uid" id="ltphoneuid" value="0" type="hidden">
					</table>
				</form>
			</div>
		</div>
		<div id="preview" style="display:none;">
			<div>
				<form class="layui-form" action="index.php?m=admin_lt_member&c=ltstatus" target="supportiframe" method="post"
				 onsubmit="return tcdiv();">
					<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
					<table cellspacing='1' cellpadding='1' class="admin_examine_table">
						<tr>
							<th class="t_fr">认证执照：</th>
							<td align="left">
								<div class="job_box_div" style="float:left;border:1px solid #eee;"></div> <a target="_blank" href="" id='preview_url'
								 style="line-height:70px; padding-left:10px;">查看原图</a>
								<div id="zwyyzz" style="line-height:70px; padding-left:10px;display: none">暂无营业执照</div>
							</td>
						</tr>
						<tr>
							<th width="80">审核操作：</th>
							<td>
								<div class="layui-input-block">
									<input name="r_status" id="ltstatus0" value="0" title="待认证" type="radio" />
									<input name="r_status" id="ltstatus1" value="1" title="已认证" type="radio" />
								</div>
							</td>
						</tr>
						<tr>
							<th class="t_fr">审核说明：</th>
							<td><textarea id="ltcontent" name="statusbody" class="admin_explain_textarea"></textarea></td>
						</tr>
						<tr style="text-align:center;">
							<td colspan='2' align="center">
								<div> 
									<input type="submit" onclick="loadlayer();" value='确认' class="admin_examine_bth">
									<input type="button" onClick="layer.closeAll();" class="admin_examine_bth_qx" value='取消'>
								</div>
							</td>
						</tr>
					</table>
					<input name="uid" id="ltyyzzuid" value="0" type="hidden">
				</form>

			</div>
		</div>
		<div id="batchrezhen" style="display:none;width:360px ">
			<div style="overflow:auto;width:360px;">
				<form class="layui-form" action="index.php?m=admin_lt_member&c=batchfirm" target="supportiframe" method="post">
					<table cellspacing='1' cellpadding='1' class="admin_examine_table">
						<tr>
							<th width="80">认证类型：</th>
							<td align="left">
								<div class="layui-input-block">
									<input name="ltname_email" title="邮箱" type="checkbox" lay-skin="primary" />
									<input name="ltname_moblie" title="手机" type="checkbox" lay-skin="primary" />
									<input name="ltname_yyzz" title="营业执照" type="checkbox" lay-skin="primary" />
								</div>
							</td>
						</tr>
						<tr>
							<th width="80">认证操作：</th>
							<td align="left">
								<div class="layui-input-block">
									<input name="plstatus" id="batchstatis0" value="0" title="待认证" type="radio" />
									<input name="plstatus" id="batchstatis1" value="1" title="已认证" type="radio" />
								</div>
							</td>
						</tr>

						<tr>
							<td colspan='2' align="center">
								<div class="admin_Operating_sub">
									<input type="submit" onclick="loadlayer();" value='确认' class="admin_examine_bth">
									<input type="button" onClick="layer.closeAll();" class="admin_examine_bth_qx" value='取消'></div>
							</td>
						</tr>
					</table>
					<input name="uid" id="btachuid" value="0" type="hidden">
					<input type="hidden" name="pytoken" id="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
				</form>
			</div>
		</div>
		<div class="infoboxp">

			<div class="tty-tishi_top"> 
			<div class="tabs_info">
				<ul>
					<li class="curr">
						<a href="index.php?m=admin_lt_member">全部猎头</a>
					</li>
					<li>
						<a href="index.php?m=user_member&c=writtenOffLog&utype=3">解绑记录</a>
					</li>
					<li>
						<a href="index.php?m=admin_lt_member&c=member_log&uid=<?php echo $_GET['uid'];?>
">会员日志</a>
					</li>

				</ul>
			</div>


			<div class="clear"></div>
			<div class="admin_new_search_box">
				<form action="index.php" name="myform" method="get">
					<input name="m" value="admin_lt_member" type="hidden" />
					<input type="hidden" name="status" value="<?php echo $_GET['status'];?>
" />
					<div class="admin_new_search_name">搜索类型：</div>
					<div class="admin_Filter_text formselect" did='dtype'>
						<input type="button" value="<?php if ($_GET['type']=='1'||$_GET['type']=='') {?>用户名<?php } elseif ($_GET['type']=='2') {?>公司名称<?php } elseif ($_GET['type']=='3') {?>EMAIL<?php } else { ?>手机号<?php }?>"
						 class="admin_Filter_but" id="btype">
						<input type="hidden" id='type' value="<?php if ($_GET['type']) {
echo $_GET['type'];
} else { ?>1<?php }?>"
						 name='type'>

						<div class="admin_Filter_text_box" style="display:none" id='dtype'>
							<ul>
								<li>
									<a href="javascript:void(0)" onClick="formselect('1','type','用户名')">用户名</a>
								</li>
								<li>
									<a href="javascript:void(0)" onClick="formselect('2','type','公司名称')">公司名称</a>
								</li>
								<li>
									<a href="javascript:void(0)" onClick="formselect('3','type','EMAIL')">EMAIL</a>
								</li>
								<li>
									<a href="javascript:void(0)" onClick="formselect('4','type','手机号')">手机号</a>
								</li>
							</ul>
						</div>
					</div>
					<input type="text" placeholder="输入你要搜索的关键字" value="<?php echo $_GET['keyword'];?>
" name='keyword' class="admin_Filter_search"
					 size="25">
					<input type="submit" name='search' value="搜索" class="admin_Filter_bth">
					<a href="javascript:void(0)" onclick="$('.admin_screenlist_box').toggle();" class="admin_new_search_gj">高级搜索</a>
				</form>
				<?php echo $_smarty_tpl->getSubTemplate ("admin/admin_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

			</div>

			<div class="clear"></div>
			</div>

			<div class="tty_table-bom">
			<div class="admin_statistics">
				<span class="tty_sjtj_color">数据统计：</span>
				<em class="admin_statistics_s">总数：<a href="index.php?m=admin_lt_member" class="ajaxltall">0</a></em>
				<em class="admin_statistics_s">未审核：<a href="index.php?m=admin_lt_member&status=4" class="ltStatusNum1">0</a></em>
				<em class="admin_statistics_s">未通过：<a href="index.php?m=admin_lt_member&status=3" class="ltStatusNum2">0</a></em>
				<em class="admin_statistics_s">已锁定：<a href="index.php?m=admin_lt_member&status=2" class="ltStatusNum3">0</a></em>
				搜索结果：<span><?php echo $_smarty_tpl->tpl_vars['total']->value;?>
</span>；
			</div>

			<div class="table-list">
				<div class="admin_table_border">
					<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
					<form action="index.php" name="myform" method="get" target="supportiframe" id='myform'>
						<input name="m" value="admin_lt_member" type="hidden" />
						<input name="c" value="del" type="hidden" />
						<table width="100%">
							<thead>
								<tr class="admin_table_top">
									<th style="width:20px;"><label for="chkall"><input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' /></label></th>
									<th>
										<?php if ($_GET['t']=="uid"&&$_GET['order']=="asc") {?>
										<a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'uid','m'=>'admin_lt_member','untype'=>'order,t'),$_smarty_tpl);?>
">用户ID<img src="images/sanj.jpg" /></a>
										<?php } else { ?>
										<a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'uid','m'=>'admin_lt_member','untype'=>'order,t'),$_smarty_tpl);?>
">用户ID<img src="images/sanj2.jpg" /></a>
										<?php }?>
									</th>

									<th align="left">用户名/公司名称</th>
									<th>会员等级</th>
									<th>企业认证</th>
									<th align="left">手机号/EMAIL</th>
									<th>登录/注册</th>
									<th>状态</th>
									<th>站点</th>
									<th>推荐</th>
									<th width="200">操作</th>
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
								<tr align="center" <?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg" <?php }?> id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
">
									<td><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" name='del[]' onclick='unselectall()' rel="del_chk" /></td>
									<td class="td1" style="text-align:center;">
										<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>

									</td>
									<td class="ud" align="left">
										<a href="javascript:void(0)" onclick="toMember('index.php?m=admin_lt_member&c=Imitate&uid=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['usertype'];?>
')"
										 class="admin_lt_username"><?php echo $_smarty_tpl->tpl_vars['v']->value['username'];?>
</a>
										<?php if ($_smarty_tpl->tpl_vars['v']->value['status']==2) {?><img src="../config/ajax_img/suo.png" alt="已锁定"><?php }?>
										<div class="mt8"><?php echo $_smarty_tpl->tpl_vars['v']->value['com_name'];?>
</div>
									</td>
									<td class="td1" style="text-align:center;">

										<?php if (time()<=$_smarty_tpl->tpl_vars['v']->value['vip_etime']) {?> <?php echo $_smarty_tpl->tpl_vars['v']->value['rating_name'];?>
 <?php } else { ?> <b style="color:red;"><?php echo $_smarty_tpl->tpl_vars['v']->value['rating_name'];?>
</b>
											<?php }?>
											<a data-uid="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" href="javascript:void(0);" class="comrating">
												<span class="admin_company_xg_icon">[修改]</span>
											</a>
											<?php if ($_smarty_tpl->tpl_vars['v']->value['vip_etime']) {?>
											<?php if (time()<=$_smarty_tpl->tpl_vars['v']->value['vip_etime']) {?> <div class="mt5"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['vip_etime'],"%Y-%m-%d %H:%M");?>

				</div>
				<?php } else { ?>
				<div class="mt5" style="color:red;"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['vip_etime'],"%Y-%m-%d %H:%M");?>
</div>
				<?php }?>
				<?php }?>
				</td>

				<td>
					<?php if ($_smarty_tpl->tpl_vars['v']->value['email_status']==1) {?>
					<img src="../config/ajax_img/1-1.png" alt="邮箱已认证" data-status="<?php echo $_smarty_tpl->tpl_vars['v']->value['email_status'];?>
" data-url="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
"
					 data-mail="<?php echo $_smarty_tpl->tpl_vars['v']->value['email'];?>
" width="20" height="20" class="lt_email">
					<?php } else { ?>
					<img src="../config/ajax_img/1-2.png" alt="邮箱未认证" data-status="<?php echo $_smarty_tpl->tpl_vars['v']->value['email_status'];?>
" data-url="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
"
					 data-mail="<?php echo $_smarty_tpl->tpl_vars['v']->value['email'];?>
" width="20" height="20" class="lt_email">
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['v']->value['moblie_status']==1) {?>
					<img src="../config/ajax_img/2-1.png" title="手机已认证" data-status="<?php echo $_smarty_tpl->tpl_vars['v']->value['moblie_status'];?>
" data-url="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
"
					 data-moblie="<?php echo $_smarty_tpl->tpl_vars['v']->value['moblie'];?>
" width="20" height="20" class="lt_moblie">
					<?php } else { ?>
					<img src="../config/ajax_img/2-2.png" alt="手机未认证" data-status="<?php echo $_smarty_tpl->tpl_vars['v']->value['moblie_status'];?>
" data-url="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
"
					 data-moblie="<?php echo $_smarty_tpl->tpl_vars['v']->value['moblie'];?>
" width="20" height="20" class="lt_moblie">
					<?php }?>

					<?php if ($_smarty_tpl->tpl_vars['v']->value['wxid']!='') {?>
					<img src="../config/ajax_img/4-1.png" title="微信已绑定<?php if ($_smarty_tpl->tpl_vars['v']->value['unionid']!='') {?>，已绑定微信开放平台<?php }?>"  width="20" height="20" class="lt_wx">
					<?php } else { ?>
					<img src="../config/ajax_img/4-2.png" title="微信未绑定"    width="20" height="20" class="lt_wx">
					<?php }?>

					<?php if ($_smarty_tpl->tpl_vars['v']->value['yyzz_status']==1) {?>
					<img src="../config/ajax_img/3-1.png" alt="营业执照已认证" data-url="<?php echo $_smarty_tpl->tpl_vars['v']->value['check'];?>
" data-uid="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
"
					 data-status="<?php echo $_smarty_tpl->tpl_vars['v']->value['yyzz_status'];?>
" width="20" height="20" class="lt_check">
					<?php } else { ?>
					<img src="../config/ajax_img/3-2.png" alt="营业执照未认证" data-url="<?php echo $_smarty_tpl->tpl_vars['v']->value['check'];?>
" data-uid="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
"
					 data-status="<?php echo $_smarty_tpl->tpl_vars['v']->value['yyzz_status'];?>
" width="20" height="20" class="lt_check">
					<?php }?>
				</td>

				<td class="od" align="left">
					<span class="admin_new_sj"><?php echo $_smarty_tpl->tpl_vars['v']->value['moblie'];?>
</span>
					<div class=" mt8"><span class="admin_new_yx"> <?php echo $_smarty_tpl->tpl_vars['v']->value['email'];?>
</span></div>
				</td>

				<td class="td">
					<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['login_date'],"%Y-%m-%d %H:%M");?>

					<div class=" mt8"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['reg_date'],"%Y-%m-%d %H:%M");?>
</div>
				</td>

				<td>
					<?php if ($_smarty_tpl->tpl_vars['v']->value['r_status']=='1') {?>
					<span class="admin_com_Audited">已审核</span> <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['r_status']=='2') {?>
					<span class="admin_com_Lock">已锁定</span> <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['r_status']=='3') {?>
					<span class="admin_com_tg">未通过</span> <?php } else { ?>
					<span class="admin_com_noAudited">未审核</span> <?php }?>
				</td>
				<td>
					<div><?php echo $_smarty_tpl->tpl_vars['Dname']->value[$_smarty_tpl->tpl_vars['v']->value['did']];?>
</div>
					<div>
						<a href="javascript:;" onclick="checksite('<?php echo $_smarty_tpl->tpl_vars['v']->value['username'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
','index.php?m=admin_lt_member&c=checksitedid');"
						 class="admin_company_xg_icon">分配</a>
					</div>
				</td>

				<td id="rec<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
">
					<?php if ($_smarty_tpl->tpl_vars['v']->value['rec']=="1") {?>
					<a href="javascript:void(0);" onClick="rec_up('index.php?m=admin_lt_member&c=lt_rec','<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
','0','rec');">
						<img src="../config/ajax_img/doneico.gif">
					</a>
					<?php } else { ?>
					<a href="javascript:void(0);" onClick="rec_up('index.php?m=admin_lt_member&c=lt_rec','<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
','1','rec');">
						<img src="../config/ajax_img/errorico.gif">
					</a>
					<?php }?>
				</td>
				<td>
					<a href="javascript:void(0);" class="admin_new_c_bth admin_new_c_bthsh user_status" pid="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
"
					 status="<?php echo $_smarty_tpl->tpl_vars['v']->value['r_status'];?>
">审核</a>

					<a href="javascript:void(0);" onClick="resetpw('<?php echo $_smarty_tpl->tpl_vars['v']->value['username'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
');" class="admin_new_c_bth admin_new_c_mmcz">密码</a>

					<a href="index.php?m=admin_lt_member&c=edit&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
&rating=<?php echo $_smarty_tpl->tpl_vars['v']->value['rating'];?>
" class="admin_new_c_bth mt5">修改</a>
					<a href="index.php?m=admin_lt_member&c=member_log&uid=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" class="admin_new_c_bth admin_new_c_rz mt5">日志
					</a>
					<a href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=admin_lt_member&c=del&del=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
');"
					 class="admin_new_c_bth admin_new_c_bth_sc mt5">删除</a>

				</td>
				</tr>
				<?php } ?>
				<tr>
					<td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
					<td colspan="14">
						<label for="chkAll2">全选</label>&nbsp;
						<input class="admin_button" type="button" name="delsub" value="删除所选" onclick="return really('del[]')" />
						<input class="admin_button" type="button" name="delsub" value="批量审核" onclick="return statusAll('del[]')" />
						<input class="admin_button" type="button" name="delsub" value="批量认证" onclick="return batch('del[]')" />
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
 ，总共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>

							条</td>
						<?php }?>
						<td colspan="12" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
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
			$(function() {
				$(".user_status").click(function() {
					var uid = $(this).attr("pid");
					var status = $(this).attr("status");
					if (status == 2) {
						parent.layer.msg('当前用户为已锁定状态，无法进行审核操作', 2, 8);
						return false;
					}
					$("#status" + status).attr("checked", true);
					layui.use(['form'], function() {
						var form = layui.form;
						form.render();
					});
					$("input[name=uid]").val(uid);
					var pytoken = $("#pytoken").val();
					$.post("index.php?m=admin_lt_member&c=lockinfo", {
						pytoken: pytoken,
						uid: uid
					}, function(msg) {
						$("#statusbody").val(msg);
						$.layer({
							type: 1,
							title: '猎头用户审核',
							closeBtn: [0, true],
							border: [10, 0.3, '#000', true],
							area: ['390px', '240px'],
							page: {
								dom: "#infobox2"
							}
						});
					});
				});
				$(".comrating").click(function() {
					var uid = $(this).attr("data-uid");
					var pytoken = $("#pytoken").val();
					$.post("index.php?m=admin_lt_member&c=getstatis", {
						uid: uid,
						pytoken: pytoken
					}, function(data) {
						if (data) {
							var dataJson = eval("(" + data + ")");
							$('#lt_job_num').val(dataJson.lt_job_num);
							$('#lt_down_resume').val(dataJson.lt_down_resume);
							$('#lt_breakjob_num').val(dataJson.lt_breakjob_num);
							$('#chat_num').val(dataJson.chat_num);
							$('#oldetime').val(dataJson.vip_etime);
							$('#vipetime').text(dataJson.vipetime);
							$('#pay').val(dataJson.pay);
							$('#integral').val(dataJson.integral);
							$('#ratuid').val(uid);
							$("#lt_rating_val").val(dataJson.rating);

							layui.use(['laydate'], function() {
								var laydate = layui.laydate;
								$("#delaytime").remove();
								$("#timeInput").html('<input type="text" name="delaytime" id="delaytime" lay-verify="required" autocomplete="off" class="layui-input">');
								laydate.render({
									elem: '#delaytime',
									min: dataJson.vip_etime*1000,
									value:dataJson.vipetime,
									isInitValue:false,
								});
							});
							
							layui.use(['form'], function() {
								var f = layui.form;
								f.render();
							});
							var ratingname = $("#lt_rating_val").find("option:selected").text();
							$('#rating_name').val(ratingname);

							$.layer({
								type: 1,
								title: '猎头会员等级修改',
								closeBtn: [0, true],
								border: [10, 0.3, '#000', true],
								area: ['600px', '300px'],
								page: {
									dom: "#comrating"
								}
							});
						} else {
							parent.layer.msg('用户信息获取失败！', 2, 8);
							return false;
						}
					});
				});
			});
			/*邮件认证*/
			$(".lt_email").click(function(data) {
				var status = $(this).attr("data-status");

				var uid = $(this).attr("data-url");
				var email = $(this).attr("data-mail");
				$('#ltemailmail').val(email);
				$('#ltemailuid').val(uid);
				$("#ltestatus" + status).attr("checked", true);
				layui.use(['form'], function() {
					var form = layui.form;
					form.render();
				});
				$.layer({
					type: 1,
					title: '邮箱认证',
					closeBtn: [0, true],
					offset: ['80px', ''],
					border: [10, 0.3, '#000', true],
					area: ['350px', '220px'],
					page: {
						dom: '#ltrenemail'
					}
				});
			})

			/*手机认证*/
			$(".lt_moblie").click(function(data) {
				var status = $(this).attr("data-status");
				var uid = $(this).attr("data-url");
				var moblie = $(this).attr("data-moblie");
				$('#ltphonemoblie').val(moblie);
				$('#ltphoneuid').val(uid);
				$("#ltpstatus" + status).attr("checked", true);
				layui.use(['form'], function() {
					var form = layui.form;
					form.render();
				});
				$.layer({
					type: 1,
					title: '手机认证',
					closeBtn: [0, true],
					offset: ['80px', ''],
					border: [10, 0.3, '#000', true],
					area: ['350px', '220px'],
					page: {
						dom: '#ltrenphone'
					}
				});
			})
			/**猎头营业执照认证**/
			$(".lt_check").click(function(data) {
				var ltstatus = $(this).attr("data-status"); //状态
				var ltcheck = $(this).attr("data-url"); //图片
				var ltuid = $(this).attr("data-uid"); //uid
				var pytoken = $('#pytoken').val();
				$(".job_box_div").html("<img src='" + ltcheck + "' style='width:150px;height:80px' />");
				if (ltcheck) {
					$("#preview_url").attr("href", ltcheck);
					$("#zwyyzz").hide();
					$("#preview_url").show();
				} else {
					$("#preview_url").hide();
					$("#zwyyzz").show();
				}

				$('#ltyyzzuid').val(ltuid);
				$("#ltstatus" + ltstatus).attr("checked", true);
				layui.use(['form'], function() {
					var form = layui.form;
					form.render();
				});
				$.post("index.php?m=admin_lt_member&c=yyzzlockinfo", {
					uid: ltuid,
					pytoken: pytoken
				}, function(msg) {
					$("#ltcontent").val(msg);
				});
				$.layer({
					type: 1,
					title: '营业执照认证',
					closeBtn: [0, true],
					offset: ['80px', ''],
					border: [10, 0.3, '#000', true],
					area: ['380px', '340px'],
					page: {
						dom: '#preview'
					}
				});

			})



			layui.use(['layer', 'form'], function() {
				var layer = layui.layer,
					form = layui.form,
					$ = layui.$,
					url = "index.php?m=admin_lt_member&c=getrating";

				var pytoken = $("#pytoken").val();

				form.on('select(rating)', function(data) {
					$.post(url, {
						id: data.value,
						uid:$('#ratuid').val(),
						pytoken: pytoken
					}, function(htm) {
						if (htm) {
							var dataJson = eval("(" + htm + ")");
							$('#lt_job_num').val(dataJson.lt_job_num);
							$('#lt_down_resume').val(dataJson.lt_down_resume);
							$('#lt_breakjob_num').val(dataJson.lt_breakjob_num);
							$('#chat_num').val(dataJson.chat_num);
							$('#vipetime').text(dataJson.vipetime);
							$('#oldetime').val(dataJson.oldetime);
							$('#rating_name').val(dataJson.rating_name);

							layui.use(['laydate'], function() {
								var laydate = layui.laydate;
								$("#delaytime").remove();
								$("#timeInput").html('<input type="text" name="delaytime" id="delaytime" lay-verify="required" autocomplete="off" class="layui-input">');
								laydate.render({
									elem: '#delaytime',
									min: dataJson.oldetime*1000,
									value:dataJson.vipetime,
								});
							});
							
						} else {
							layer.msg('请选择会员等级');
						}
						form.render('select');
					});
				});
			});

			$(document).ready(function() {
				$.get("index.php?m=admin_lt_member&c=ltNum", function(data) {
					var datas = eval('(' + data + ')');
					if (datas.ltAllNum) {
						$('.ajaxltall').html(datas.ltAllNum);
					}
					if (datas.ltStatusNum1) {
						$('.ltStatusNum1').html(datas.ltStatusNum1);
					}
					if (datas.ltStatusNum2) {
						$('.ltStatusNum2').html(datas.ltStatusNum2);
					}
					if (datas.ltStatusNum3) {
						$('.ltStatusNum3').html(datas.ltStatusNum3);
					}
				});
			});

			function statusAll(name) {
				var chk_value = [];

				$('input[name="' + name + '"]:checked').each(function() {
					chk_value.push($(this).val());
				});

				if (chk_value.length == 0) {
					layer.msg("请选择要批量审核的数据！", 2, 8);
					return false;
				} else {
					$("input[name=uid]").val(chk_value);
					$("#statusbody").val('');
					$("input[name='status']").attr('checked', false);
					$.layer({
						type: 1,
						title: '猎头用户审核',
						closeBtn: [0, true],
						border: [10, 0.3, '#000', true],
						area: ['390px', '240px'],
						page: {
							dom: "#infobox2"
						}
					});
				}
			}

			//批量认证
			function batch(name) {
				var chk_value = [];
				$('input[name="' + name + '"]:checked').each(function() {
					chk_value.push($(this).val());
				});

				if (chk_value.length == 0) {
					layer.msg("请选择要批量认证的数据！", 2, 8);
					return false;
				} else {

					$('#btachuid').val(chk_value);
					$.layer({
						type: 1,
						title: '批量认证',
						closeBtn: [0, true],
						offset: ['80px', ''],
						border: [10, 0.3, '#000', true],
						area: ['350px', '235px'],
						page: {
							dom: '#batchrezhen'
						}
					});
				}
			}

			function toMember(url, usertype) {
				if (usertype != '3') {
					if (usertype == '0') {
						parent.layer.confirm("该账户当前没有设置身份，以猎头身份模拟进入可能导致部分功能无法正常使用，是否确认进入？", function() {
							parent.layer.closeAll();
							window.open(url);
						});
					} else {
						if (usertype == '1') {
							var u = '求职者';
						} else if (usertype == '2') {
							var u = '招聘者';
						} else if (usertype == '4') {
							var u = '培训';
						}
						parent.layer.confirm("该账户当前身份为" + u + "，以猎头身份模拟进入可能导致部分功能无法正常使用，是否确认进入？", function() {
							parent.layer.closeAll();
							window.open(url);
						});
					}
				} else {
					window.open(url);
				}
			}
		<?php echo '</script'; ?>
>
		<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['adminstyle']->value)."/checkdomain.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	</body>
</html>
<?php }} ?>
