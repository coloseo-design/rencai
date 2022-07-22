<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-06 16:33:55
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_resume.htm" */ ?>
<?php /*%%SmartyHeaderCode:2232362c548f3c52bf6-00538946%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '72ebfcfefdbdb03109c19dc96b9868d86d0b7f98' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_resume.htm',
      1 => 1643012867,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2232362c548f3c52bf6-00538946',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
    'userdata' => 0,
    'v' => 0,
    'resume' => 0,
    'userclass_name' => 0,
    'total' => 0,
    'rows' => 0,
    'key' => 0,
    'source' => 0,
    'pagenum' => 0,
    'pages' => 0,
    'pagenav' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c548f3d92217_60385064',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c548f3d92217_60385064')) {function content_62c548f3d92217_60385064($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\modifier.date_format.php';
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

		<div id="export" style="display:none;">
			<div style=" margin-top:10px;">
				<div>
					<form action="index.php?m=admin_resume&c=xls" target="supportiframe" method="post" class="myform">
						<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
						<input type="hidden" name="ids">
						<div class="admin_resume_dc">
							<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="rtype[]" value="id"> 简历ID</span></label>
							<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="rtype[]" value="name"> 简历名称</span></label>
							<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="rtype[]" value="uid"> 用户UID</span></label>
							<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="rtype[]" value="uname"> 姓名</span></label>
							<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="rtype[]" value="sex"> 性别</span></label>
							<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="rtype[]" value="birthday"> 生日</span></label>
							<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="type[]" value="marriage"> 婚姻</span></label>
							<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="type[]" value="height"> 身高</span></label>
							<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="type[]" value="nationality"> 民族</span></label>
							<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="type[]" value="weight"> 体重</span></label>
							<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="type[]" value="idcard"> 身份证</span></label>
							<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="type[]" value="telphone"> 手机</span></label>
							<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="type[]" value="telhome"> 座机</span></label>
							<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="type[]" value="email"> 邮件</span></label>
							<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="rtype[]" value="edu"> 教育程度</span></label>
							<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="type[]" value="homepage"> 个人主页</span></label>
							<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="type[]" value="address"> 详细地址</span></label>
							<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="rtype[]" value="exp"> 工作经验</span></label>
							<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="type[]" value="domicile"> 户籍</span></label>
							<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="type[]" value="living"> 现居住地</span></label>
							<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="type[]" value="description">
									个人说明</span></label>
							<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="rtype[]" value="hy"> 意向行业</span></label>
							<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="rtype[]" value="job_classid">
									意向职位</span></label>
							<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="rtype[]" value="city_classid">
									城市</span></label>
							<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="rtype[]" value="minsalary,maxsalary">
									薪水</span></label>
							<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="rtype[]" value="type"> 工作性质</span></label>
							<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="rtype[]" value="report"> 到岗时间</span></label>
							<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="rtype[]" value="lastdate"> 更新时间</span></label>
							<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" id="xlsAllCheck" onclick="xlsAll(this.form)">
									全选</span></label>
						</div>

						<div class="admin_resume_dc_p" style=" padding:10px 0;">
							<span class="admin_resume_dc_n">导出数量：</span>
							<input name='limit' type='text' class="admin_resume_dc_ntext">
							<span class="admin_web_tip admin_resume_dc_tip">数字太大会导致运行缓慢，请慎重填写</span>
						</div>
						<div class="admin_resume_dc_p" style=" padding:10px 0;">
							<span class="admin_resume_dc_n">导出区段：</span>
							<input name='section' type='text' class="admin_resume_dc_ntext">
							<span class="admin_web_tip admin_resume_dc_tip">例如101,100  从101条开始导出100条</span>
						</div>
						<div class="admin_resume_dc_sub" style=" padding-top:10px;">
							<input type="button" onClick="check_xls();" value='确认' class="admin_resume_dc_bth1"> &nbsp;&nbsp;
							<input type="button" onClick="layer.closeAll();" class="admin_resume_dc_bth2" value='取消'>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div id="resumttop" style="display:none; ">
			<div class="admin_com_t_box">
				<form action="index.php?m=admin_resume&c=top" target="supportiframe" method="post">
					<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">

					<div class=" admin_com_smbox_list_pd">
						<span class="admin_com_smbox_span">置顶天数：</span>
						<input class="admin_com_smbox_text" value="" name="addday" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'')"><span
						 class="admin_com_smbox_list_s">天</span> </div>
					<div class="topdiv" style="display:none">
						<span class="admin_com_smbox_span">当前结束日期：</span>
						<span class="admin_com_smbox_list_s top" style="color:#f60"></span>
					</div>
					<div class="admin_com_smbox_qx_box"> 如需取消置顶简历请单击 <input type="checkbox" name="s" value="1"> 点击确认即可</div>

					<div class="admin_com_smbox_opt admin_com_smbox_opt_mt"><input type="submit" onclick="loadlayer();" value='确认' id='topsubmit'
						 class="admin_examine_bth"><input type="button" onClick="layer.closeAll();" class="admin_examine_bth_qx" value='取消'></div>

					<input name="eid" type="hidden" value="" />
				</form>
			</div>
		</div>

		<div id="info_div" style="display:none; width: 390px; ">
			<div class="" style=" margin-top:10px; ">
				<form class="layui-form" action="index.php?m=admin_resume&c=status" target="supportiframe" method="post" onsubmit="return htStatus()">
					<table cellspacing='1' cellpadding='1' class="admin_examine_table">
						<tr>
							<th width="80">审核操作：</th>
							<td align="left">
								<div class="layui-input-block">
									<input name="status" id="status1" value="1" title="正常" type="radio" />
									<input name="status" id="status3" value="3" title="未通过" type="radio" />
								</div>
							</td>
						</tr>
						<tr>
							<th class="t_fr">审核说明：</th>
							<td align="left"> <textarea id="alertcontent" name="statusbody" class="admin_explain_textarea"></textarea> </td>
						</tr>
						<tr>
							<td colspan='2' align="center"><input type="submit" value='确认' class="admin_examine_bth">
								<input type="button" onClick="layer.closeAll();" class="admin_examine_bth_qx" value='取消'>
							</td>
						</tr>
					</table>
					<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
					<input name="id" value="0" type="hidden">
				</form>
			</div>
		</div>

		<div id="label_div" style="display:none;">
			<div class="" style="margin-top: 10px;">
				<form class="layui-form" action="index.php?m=admin_resume&c=label" target="supportiframe" method="post" id="formlabel">
					<table cellspacing='1' cellpadding='1' class="admin_examine_table" align="center">
						<tr>
							<th>姓名：</th>
							<td align="left">
								<div id="labelname" style="font-weight:bold;"></div>
							</td>
						</tr>
						<tr>
							<th>简历标签：</th>
							<td align="left">
								<div class="layui-input-block t_w250">
									<select name="label" lay-filter="" id="labels">
										<option value="">请选择标签</option>
										<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_label']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['resume']->value['report']==$_smarty_tpl->tpl_vars['v']->value) {?>selected="selected" <?php }?>><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>

										</option> <?php } ?>
									</select>
								</div>
							</td>
						</tr>
						<tr>
							<th class="t_fr">客服评价：</th>
							<td align="left">
								<textarea id="content" name="content" class="admin_explain_textarea" style="width:238px;height:100px;"></textarea>
							</td>
						</tr>
						<tr height="50px">
							<td colspan='2' align="center"><input type="submit" onclick="loadlayer();" value='确认' class="admin_examine_bth">
								<input type="button" onClick="layer.closeAll();" class="admin_examine_bth_qx" value='取消'></td>
						</tr>
					</table>
					<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
					<input name="id" id="labelid" value="0" type="hidden">
				</form>
			</div>
		</div>

		<div id="deleS_div" style="display:none; width: 390px; ">
			<div class="" style=" margin-top:10px; ">
				<form class="layui-form" action="index.php?m=admin_resume&c=delResume" target="supportiframe" method="post" onsubmit="return loadlayer();">
					<table cellspacing='1' cellpadding='1' class="admin_examine_table">
						<tr>
							<td align="center">
								<input type="checkbox" value='1' name="delAccount" title="同步删除账号" lay-skin="primary" />
							</td>
						</tr>
						<tr>
							<td align="center">
								<span class="admin_web_tip">勾选删除账号所有数据信息</span>
							</td>
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
					<input name="del" value="0" type="hidden">
				</form>
			</div>
		</div>

		<div class="infoboxp">
			<div class="tty-tishi_top">

				<div class="tabs_info">
					<ul>
						<li class="curr"><a href="index.php?m=admin_resume">全部简历</a></li>
						<li><a href="index.php?m=admin_resume&c=sxLog">刷新日志</a></li>
					</ul>
				</div>

				<div class="clear"></div>

				<div class="admin_new_search_box">

					<form id="resumeFormSearch" action="index.php" name="myform" method="get">
						<input name="m" value="admin_resume" type="hidden" />
						<?php if ($_GET['status']) {?>
						<input name="status" value="<?php echo $_GET['status'];?>
" type="hidden" />
						<?php }?>
						<?php if ($_GET['uptime']) {?>
						<input name="uptime" value="<?php echo $_GET['uptime'];?>
" type="hidden" />
						<?php }?>
						<?php if ($_GET['source']) {?>
						<input name="source" value="<?php echo $_GET['source'];?>
" type="hidden" />
						<?php }?>
						<?php if ($_GET['service']) {?>
						<input name="service" value="<?php echo $_GET['service'];?>
" type="hidden" />
						<?php }?>
						<?php if ($_GET['adtime']) {?>
						<input name="adtime" value="<?php echo $_GET['adtime'];?>
" type="hidden" />
						<?php }?>
						<?php if ($_GET['type']) {?>
						<input name="type" value="<?php echo $_GET['type'];?>
" type="hidden" />
						<?php }?>
						<?php if ($_GET['integrity']) {?>
						<input name="integrity" value="<?php echo $_GET['integrity'];?>
" type="hidden" />
						<?php }?>
						<?php if ($_GET['edu']) {?>
						<input type="hidden" name="edu" value="<?php echo $_GET['edu'];?>
" />
						<?php }?>
						<?php if ($_GET['exp']) {?>
						<input type="hidden" name="exp" value="<?php echo $_GET['exp'];?>
" />
						<?php }?>
						<div class="admin_new_search_name">搜索类型：</div>

						<div class="admin_Filter_text formselect" did='dkeytype'>
							<input type="button" <?php if ($_GET['keytype']==''||$_GET['keytype']=='1') {?> value="简历名称"
							 <?php } elseif ($_GET['keytype']=='2') {?> value="姓名" <?php } elseif ($_GET['keytype']=='3') {?> value="简历ID" <?php } elseif ($_GET['keytype']=='4') {?> value="用户名" <?php } elseif ($_GET['keytype']=='5') {?> value="手机号"<?php } elseif ($_GET['keytype']=='6') {?> value="教育经历" <?php } elseif ($_GET['keytype']=='7') {?> value="工作经历" <?php } elseif ($_GET['keytype']=='8') {?> value="项目经历" <?php } elseif ($_GET['keytype']=='9') {?> value="项目经历" <?php } elseif ($_GET['keytype']=='10') {?> value="职业技能" <?php }?> class="admin_Filter_but" id="bkeytype" />
							<input type="hidden" name="keytype" id="keytype" <?php if ($_GET['keytype']=='') {?> value="1" <?php } else { ?> value="<?php echo $_GET['keytype'];?>
" <?php }?>/>

							<div class="admin_Filter_text_box" style="display:none" id="dkeytype">
								<ul>
									<li><a href="javascript:void(0)" onClick="formselect('1','keytype','简历名称')">简历名称</a></li>
									<li><a href="javascript:void(0)" onClick="formselect('2','keytype','姓名')">姓名</a></li>
									<li><a href="javascript:void(0)" onClick="formselect('3','keytype','简历ID')">简历ID</a></li>
									<li><a href="javascript:void(0)" onClick="formselect('4','keytype','用户名')">用户名</a></li>
									<li><a href="javascript:void(0)" onClick="formselect('5','keytype','手机号')">手机号</a></li>
									<li><a href="javascript:void(0)" onClick="formselect('6','keytype','教育经历')">教育经历</a></li>
									<li><a href="javascript:void(0)" onClick="formselect('7','keytype','工作经历')">工作经历</a></li>
									<li><a href="javascript:void(0)" onClick="formselect('8','keytype','项目经历')">项目经历</a></li>
									<li><a href="javascript:void(0)" onClick="formselect('9','keytype','培训经历')">培训经历</a></li>
									<li><a href="javascript:void(0)" onClick="formselect('10','keytype','职业技能')">职业技能</a></li>
								</ul>
							</div>
						</div>
						<input type="text" value="" placeholder="请输入你要搜索的关键字" name='keyword' class="admin_new_text">
						<input type="button" onclick="resumeFormSearch()" value="搜索" class="admin_new_bth">
						<a href="javascript:void(0)" onclick="$('.admin_screenlist_box').toggle();" class="admin_new_search_gj">高级搜索</a>
						<a href="index.php?m=admin_resume&c=addResume" class="admin_new_cz_tj"> + 添加简历</a>
					</form>
					<?php echo $_smarty_tpl->getSubTemplate ("admin/admin_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

				</div>

				<div class="clear"></div>

			</div>

			<div class="tty_table-bom">

				<div class="admin_statistics">
					<span class="tty_sjtj_color">数据统计：</span>
					<em class="admin_statistics_s">总数：<a href="index.php?m=admin_resume" class="ajaxresumeall">0</a></em>
					<em class="admin_statistics_s">未审核：<a href="index.php?m=admin_resume&status=4" class="ajaxresumestatus1">0</a></em>
					<em class="admin_statistics_s">未通过：<a href="index.php?m=admin_resume&status=3" class="ajaxresumestatus2">0</a></em>
					<em class="admin_statistics_s">已锁定：<a href="index.php?m=admin_resume&status=2" class="ajaxresumestatus3">0</a></em>
					<em class="admin_statistics_s">未成年：<a href="index.php?m=admin_resume&teen=1" class="ajaxresumeteen">0</a></em>
					搜索结果：<span><?php echo $_smarty_tpl->tpl_vars['total']->value;?>
</span>；
				</div>

				<div class="table-list">
					<div class="admin_table_border">
						<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
						<form action="index.php?m=admin_resume&c=delResume" target="supportiframe" name="myform" method="post" id='myform'>
							<table width="100%">
								<thead>
									<tr class="admin_table_top">
										<th width="20">
											<label for="chkall"><input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' /></label>
										</th>
										<th width="65">
											<?php if ($_GET['t']=="id"&&$_GET['order']=="asc") {?>
											<a href="index.php?m=admin_resume&order=desc&t=id">简历ID<img src="images/sanj.jpg" /></a>
											<?php } else { ?>
											<a href="index.php?m=admin_resume&order=asc&t=id">简历ID<img src="images/sanj2.jpg" /></a>
											<?php }?>
										</th>
										<th width="120" align="left">姓名/用户名</th>
										<th align="left">基本信息</th>

										<th width="135">完整度/更新时间</th>
										<th width="135">来源/发布时间</th>
										<th width="80">简历状态</th>
										<th width="80">审核状态</th>
										<th width="90">推广</th>
										<th align="center" width="80">投递职位</th>
										<th width="120" class="admin_table_th_bg">操作</th>
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
									<tr <?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg" <?php }?> id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
										<td width="20"><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="check_all" name='del[]' onclick='unselectall()'
											 rel="del_chk" /></td>
										<td align="center" class="td1" width="65"><span><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</span></td>
										<td class="gd" align="left" width="120">
											<div class="">
												<?php echo $_smarty_tpl->tpl_vars['v']->value['uname'];?>

												<?php if ($_smarty_tpl->tpl_vars['v']->value['r_status']!=1) {?>
												<a href="javascript:void(0)" class="job_name_all" v="<?php if ($_smarty_tpl->tpl_vars['v']->value['r_status']==0) {?>个人身份未审核<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['r_status']==3) {?>个人身份审核未通过<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['r_status']==2) {?>用户已锁定<?php }?>">
													<img src="images/bg_wechat_help.png">
												</a>
												<?php }?>
											</div>

											<div class="mt8">
												<a href="index.php?m=user_member&c=Imitate&uid=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" target="_blank" class="admin_com_name" ><?php echo $_smarty_tpl->tpl_vars['v']->value['username'];?>
</a>
											</div>
										</td>

										<td class="od" align="left">
                                        <div class="">
											<div class="">
												<span class="admin_resume_yx" style="color:#5fb878"><?php echo mb_substr($_smarty_tpl->tpl_vars['v']->value['name'],0,12);?>
</span>
												<?php if ($_smarty_tpl->tpl_vars['v']->value['defaults']==1) {?>
												<a href="javascript:void(0)" class="job_name_all" v="默认简历" style="display: inline-block; font-size: 12px;border-radius:4px; padding:0px 3px;color:#fff; background-color: #2d8cf0;">默认</a>
												<?php }?>
											</div>
											<div class="mt5">
												<?php echo $_smarty_tpl->tpl_vars['v']->value['age_n'];?>
岁<span class="reline">|</span><?php if ($_smarty_tpl->tpl_vars['v']->value['sex_n']) {
echo $_smarty_tpl->tpl_vars['v']->value['sex_n'];?>
<span class="reline">|</span><?php }
if ($_smarty_tpl->tpl_vars['v']->value['edu_n']) {?>
													<?php echo $_smarty_tpl->tpl_vars['v']->value['edu_n'];?>
学历<span class="reline">|</span><?php }
if ($_smarty_tpl->tpl_vars['v']->value['exp_n']) {?> <?php echo $_smarty_tpl->tpl_vars['v']->value['exp_n'];?>
经验<?php }?>

												<div class="mt5">
												<?php if ($_smarty_tpl->tpl_vars['v']->value['city_n']) {?>
													<?php echo $_smarty_tpl->tpl_vars['v']->value['city_n'];?>

													<?php if ($_smarty_tpl->tpl_vars['v']->value['citynum']>1) {?>
													<a href="javascript:void(0)" class="city_name_all" v="<?php echo $_smarty_tpl->tpl_vars['v']->value['cityall'];?>
"><img src="images/bg_wechat_help.png" width="12"></a>
													<?php }?>
												<?php }?>
													<span class="reline">|</span>
													<span><?php echo $_smarty_tpl->tpl_vars['v']->value['salary'];?>
</span><span class="reline">|</span><?php echo $_smarty_tpl->tpl_vars['v']->value['report_n'];?>
<span class="reline">|</span><?php echo $_smarty_tpl->tpl_vars['v']->value['type_n'];?>

												</div>
											</div>
										</div>

										</td>
										<td align="center" width="135">
											<div class="layui-progress layui-progress-big" lay-showpercent="true">
												<div class="layui-progress-bar" lay-percent="<?php echo $_smarty_tpl->tpl_vars['v']->value['integrity'];?>
%"></div>
											</div>
											<div class="mt5"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['lastupdate'],"%Y-%m-%d %H:%M");?>
</div>
										</td>
										<td align="center" width="135"><?php echo $_smarty_tpl->tpl_vars['source']->value[$_smarty_tpl->tpl_vars['v']->value['source']];
if ($_smarty_tpl->tpl_vars['v']->value['doc']==1) {?>粘贴<?php }?>
											<div class="mt5">
												<?php if ($_smarty_tpl->tpl_vars['v']->value['ctime']) {?>
												<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['ctime'],"%Y-%m-%d %H:%M");?>

												<?php } else { ?>
												<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['lastupdate'],"%Y-%m-%d %H:%M");?>

												<?php }?>
											</div>
										</td>
										<td align="center" width="80"><?php if ($_smarty_tpl->tpl_vars['v']->value['status']=='1') {?>公开<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['status']=='3') {?>投递企业可见<?php } else { ?>隐藏<?php }?></td>
										<td align="center" width="80">
											<?php if ($_smarty_tpl->tpl_vars['v']->value['state']==1) {?>
											<span class="admin_com_Audited">已审核</span>
											<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['state']==3) {?>
											<span class="admin_com_tg">未通过</span>
											<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['state']==0) {?>
											<span class="admin_com_noAudited">未审核</span>
											<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['state']==2) {?>
											<span class="admin_com_tg">被举报</span>
											<?php }?>
										</td>

										<td align="center" width="90"><div style="width:90px;">推荐：
											<div class="admin_new_t_j" style="display:inline;" id="rec_resume<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
												<?php if ($_smarty_tpl->tpl_vars['v']->value['rec_resume']=="1") {?>
												<a href="javascript:void(0);" onClick="rec_up('index.php?m=admin_resume&c=rec','<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','0','rec_resume');">
													<img src="../config/ajax_img/doneico.gif"></a>
												<?php } else { ?>
												<a href="javascript:void(0);" onClick="rec_up('index.php?m=admin_resume&c=rec','<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','1','rec_resume');">
													<img src="../config/ajax_img/errorico.gif"></a>
												<?php }?>
											</div>
											<div class="admin_new_t_j" id="top<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">置顶：
												<?php if ($_smarty_tpl->tpl_vars['v']->value['top']=="1"&&$_smarty_tpl->tpl_vars['v']->value['topdate']>time()) {?>
												<a href="javascript:void(0);" onClick="resumttop('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['top_day'];?>
','<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['topdate'],'%Y-%m-%d');?>
')">
													<img src="../config/ajax_img/doneico.gif"></a>
												<?php } else { ?>
												<a href="javascript:void(0);" onClick="resumttop('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['top_day'];?>
')">
													<img src="../config/ajax_img/errorico.gif"></a>
												<?php }?>
											</div>	</div>
										</td>
										<td align="center" width="80">
											<?php if ($_smarty_tpl->tpl_vars['v']->value['sq_num']>0) {?>
												<?php echo $_smarty_tpl->tpl_vars['v']->value['sq_num'];?>
<br>
												<a href="index.php?m=admin_comlog&eid=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="blue">查看</a>
											<?php } else { ?>
												0
											<?php }?>
										</td>
										<td width="120">

											<a href="javascript:void(0);" class="admin_new_c_bth admin_new_c_bth_yl resume-preview" pid="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">预览</a>
											<a href="javascript:;" class="admin_new_c_bth admin_new_c_bthsh status" pid="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" rstatus='<?php echo $_smarty_tpl->tpl_vars['v']->value['r_status'];?>
'>审核</a>
											<a href="index.php?m=admin_resume&c=editResume&uid=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="admin_new_c_bth">修改</a>

											<a href="javascript:;" class="admin_new_c_bth admin_new_c_bth_sc mt5 deleS" pid="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">删除</a>

											<a href="javascript:void(0)" onClick="layer_del('确认刷新简历？', 'index.php?m=admin_resume&c=refresh&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');"

											 title="刷新简历" class="admin_new_c_bth mt5" >刷新</a>
											<?php if ($_smarty_tpl->tpl_vars['v']->value['label']||$_smarty_tpl->tpl_vars['v']->value['content']) {?>
											<a href="javascript:;" class="admin_new_c_bth admin_new_c_bth_pp label mt5" pid="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" names="<?php echo $_smarty_tpl->tpl_vars['v']->value['uname'];?>
"
												 status1="<?php echo $_smarty_tpl->tpl_vars['v']->value['label'];?>
" status2="<?php echo $_smarty_tpl->tpl_vars['v']->value['content'];?>
">查备</a>
											<?php } else { ?>
											<a href="javascript:;" class="admin_new_c_bth admin_new_c_bth_pp label mt5" pid="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" names="<?php echo $_smarty_tpl->tpl_vars['v']->value['uname'];?>
"
												 status1="<?php echo $_smarty_tpl->tpl_vars['v']->value['label'];?>
" status2="<?php echo $_smarty_tpl->tpl_vars['v']->value['content'];?>
">备注</a>
											<?php }?>
										</td>
									</tr>
									<?php } ?>
									<tr>
										<td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
										<td colspan="14">
											<label for="chkAll2">全选</label>&nbsp;

											<input class="admin_button" type="button" value="删除" onClick="return delUser('del[]')" />
											<input class="admin_button" type="button" value="审核" onClick="audall('1');" />
											<input class="admin_button" type="button" value="刷新" onClick="Refreshs();" />
											<input class="admin_button" type="button" value="推荐" onClick="checkdel('rec_resume','1');" />
											<input class="admin_button" type="button" value="取消推荐" onClick="checkdel('rec_resume','0');" />
											<input class="admin_button" type="button" value="置顶" onClick="checkdel('top','1');" />
											<input class="admin_button" type="button" value="取消置顶" onClick="checkdel('top','0');" />
											<input class="admin_button" type="button" value="导出" onClick="Export();" />
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
>
			var needLoad = false;
			layui.use(['layer', 'form', 'element'], function() {
				var layer = layui.layer,
					form = layui.form,
					$ = layui.$,
					element = layui.element;
				form.on('radio(userstatus)', function(data) {
					if (data.value == 1) {
						$("#istb").attr("checked", true);
						$("#istb").attr("disabled", true);
						$(".tbcss").show();
					} else {
						$(".tbcss").hide();
					}
					form.render('checkbox');
				});
			});

			$(document).ready(function() {
				$(".job_name_all").hover(function() {
					var rstatus = $(this).attr('v');
					if ($.trim(rstatus) != '') {
						layer.tips(rstatus, this, {
							guide: 1,
							style: ['background-color:#5EA7DC; color:#fff;top:-7px', '#5EA7DC']
						});
						$(".xubox_layer").addClass("xubox_tips_border");
					}
				}, function() {
					layer.closeAll('tips');
				});
				$.get("index.php?m=admin_resume&c=resumeNum", function(data) {
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
					if (datas.resumeTeenNum) {
						$('.ajaxresumeteen').html(datas.resumeTeenNum);
					}
				});

				$(".city_name_all").hover(function() {
					var city_name = $(this).attr('v');
					if ($.trim(city_name) != '') {
						layer.tips(city_name, this, {
							guide: 1,
							style: ['background-color:#5EA7DC; color:#fff;top:-7px', '#5EA7DC']
						});
						$(".xubox_layer").addClass("xubox_tips_border");
					}
				}, function() {
					var city_name = $(this).attr('v');
					if ($.trim(city_name) != '') {
						layer.closeAll('tips');
					}
				});

				$(".status").click(function() {
					if ($(this).attr("rstatus") == 2) {
						parent.layer.msg("用户已锁定,无法审核相关信息", 2, 8);
						return false;
					}
					var id = $(this).attr("pid");
					$('body').css('overflow-y', 'hidden');
					$.layer({
						type: 2,
						shadeClose: true,
						title: '简历审核',
						area: ['1220px', ($(window).height() - 30) +'px'],
						iframe: {src: 'index.php?m=admin_resume&c=resumeAudit&id='+id},
						close: function(){
							if(needLoad){
								window.location.reload();
							}else{
								$('body').css('overflow-y', '');
							}
						}
					});
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

				$(".deleS").click(function() {

					var id	= $(this).attr("pid");

					layui.use(['form'], function() {
						var form = layui.form;
						form.render();
					});

					$("input[name=del]").val(id);

					$.layer({
						type: 1,
						title: '删除简历数据',
						closeBtn: [0, true],
						border: [10, 0.3, '#000', true],
						area: ['390px', '240px'],
						page: {
							dom: "#deleS_div"
						}
					});

				});


				$(".label").click(function() {
					var id = $(this).attr("pid");
					var lable = $(this).attr("status1");
					var content = $(this).attr("status2");
					var name = $(this).attr("names");
					$("#labelid").val(id);
					$("#labels").val(lable);
					$("#content").text(content);
					$("#labelname").text(name);
					layui.use(['form'], function() {
						var form = layui.form;
						form.render();
					});
					$.layer({
						type: 1,
						title: '简历备注',
						closeBtn: [0, true],
						border: [10, 0.3, '#000', true],
						area: ['380px', 'auto'],
						page: {
							dom: "#label_div"
						}
					});
				});
			});

			function Refreshs() {
				var codewebarr = "";
				$(".check_all:checked").each(function() {
					if (codewebarr == "") {
						codewebarr = $(this).val();
					} else {
						codewebarr = codewebarr + "," + $(this).val();
					}
				});
				if (codewebarr == "") {
					parent.layer.msg("请选择要刷新的简历！", 2, 8);
					return false;
				} else {
					loadlayer();
					$.post("index.php?m=admin_resume&c=refresh", {
						ids: codewebarr,
						pytoken: $('#pytoken').val()
					}, function(data) {
						parent.layer.closeAll('loading');
						parent.layer.msg("批量刷新成功！", 2, 9, function() {
							window.location.reload();
						});
					})
				}
			}

			function Export() {
				var codewebarr = "";
				$(".check_all:checked").each(function() {
					if (codewebarr == "") {
						codewebarr = $(this).val();
					} else {
						codewebarr = codewebarr + "," + $(this).val();
					}
				});
				$("input[name='ids']").val(codewebarr);
				add_class('选择导出字段', '650', '450', '#export', '');
			}

            // 获取cookie值
            function getCookie(name) {
                var prefix = name + "="
                var start = document.cookie.indexOf(prefix)
                if (start == -1) {
                    return null;
                }
                var end = document.cookie.indexOf(";", start + prefix.length)
                if (end == -1) {
                    end = document.cookie.length;
                }
                var value = document.cookie.substring(start + prefix.length, end)
                return decodeURI(value);
            }

            function check_xls() {
                var all_type = "",type = [], rtype = [];
                $(".type:checked").each(function() {
                    if(type == "") {
                        all_type = $(this).val();
                    } else {
                        all_type = all_type + "," + $(this).val();
                    }

                    if ($(this).attr('name') == 'rtype[]') {
                        rtype.push($(this).val())
                    } else if ($(this).attr('name') == 'type[]') {
                        type.push($(this).val())
                    }

                });
                if(all_type == "") {
                    layer.msg("请选择导出字段！", 2, 8);
                    return false;
                }
                var params = {
                    pytoken: $( "input[name='pytoken']").val(),
                    ids: $( "input[name='ids']").val(),
                    limit: $( "input[name='limit']").val(),
					section: $( "input[name='section']").val(),
                    type: type,
                    rtype: rtype
                }
                $.post("index.php?m=admin_resume&c=export_check",params,function(data){
                    var rt = JSON.parse(data)
                    if (rt.code == '400') {
                        layer.msg("暂无要导出的数据！", 2, 8);
                        return false;
                    } else {
                        layer.load();
                        var elemIF = document.createElement('iframe');
                        elemIF.src = "index.php?m=admin_resume&c=xls"
                        elemIF.style.display = 'none';
                        document.body.appendChild(elemIF)
                        // 获取到后台设置的cookie值后关闭加载动画
                        var time = setInterval(function(){
                            if (getCookie('resumeXls')) {
                                layer.closeAll('loading');
                                clearInterval(time)
                            }
                        },1000);
                    }
                })
                layer.closeAll();
            }

			function checkdel(type, status) {
				var codewebarr = "";
				$(".check_all:checked").each(function() {
					if (codewebarr == "") {
						codewebarr = $(this).val();
					} else {
						codewebarr = codewebarr + "," + $(this).val();
					}
				});
				if (codewebarr == "") {
					parent.layer.msg("请选择简历！", 2, 8);
					return false;
				} else if (type == 'top') {
					if (status != '1') {
						$('input[name=s]').attr('checked', 'true');
					}
					resumttop(codewebarr, 0);
				} else {
					loadlayer();
					$.post("index.php?m=admin_resume&c=rec", {
						ids: codewebarr,
						pytoken: $('#pytoken').val(),
						type: type,
						rec_resume: status
					}, function(data) {
						parent.layer.closeAll('loading');
						if (data == 0) {
							parent.layer.msg("操作出错，请稍后再试！", 2, 8);
						} else {
							parent.layer.msg("设置成功！", 2, 9, function() {
								window.location.reload();
							});
						}
					})
				}
			}

			function resumttop(id, topday, topdate) {
				if (topdate) {
					$(".top").html(topdate);
					$(".topdiv").show();
					$("input[name='eid']").val(id);
					add_class('简历置顶', '290', '280', '#resumttop', '');
				} else {
					$("input[name='eid']").val(id);
					add_class('简历置顶', '290', '250', '#resumttop', '');
				}
			}

			function audall() {
				var codewebarr = "";
				$(".check_all:checked").each(function() {
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
					$("input[name=id]").val(codewebarr);
					$("#alertcontent").val('');
					$("input[name=status]").attr("checked", false);
					add_class('批量审核', '390', '250', '#info_div', '');
				}
			}

			function xlsAll(form) {
				for (var i = 0; i < form.elements.length; i++) {
					var e = form.elements[i];
					if (e.name == 'type[]' && e.disabled == false) {
						e.checked = form.xlsAllCheck.checked;
					}
				}
				for (var i = 0; i < form.elements.length; i++) {
					var e = form.elements[i];
					if (e.name == 'rtype[]' && e.disabled == false) {
						e.checked = form.xlsAllCheck.checked;
					}
				}
			}
			function resumeFormSearch(){
				parent.layer.load('执行中，请稍候...', 0);

				var job_class = $("#job_class").val(),
					city_class = $("#city_class").val();

				if($("#form_job_class").length > 0){
					$("#form_job_class").val(job_class);
				}else if(job_class){
					$("#resumeFormSearch").prepend('<input type="hidden" id="form_job_class" name="job_class" value="'+job_class+'" />');
				}
				if($("#form_city_class").length > 0){
					$("#form_city_class").val(city_class);
				}else if(city_class){
					$("#resumeFormSearch").prepend('<input type="hidden" id="form_city_class" name="city_class" value="'+city_class+'" />');
				}
				$("#resumeFormSearch").submit();
			}
		<?php echo '</script'; ?>
>
	</body>
</html>
<?php }} ?>
