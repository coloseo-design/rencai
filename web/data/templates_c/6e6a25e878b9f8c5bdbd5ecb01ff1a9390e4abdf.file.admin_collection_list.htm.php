<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 16:10:09
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_collection_list.htm" */ ?>
<?php /*%%SmartyHeaderCode:880462d909e102c963-29187568%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6e6a25e878b9f8c5bdbd5ecb01ff1a9390e4abdf' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_collection_list.htm',
      1 => 1634883865,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '880462d909e102c963-29187568',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
    'locoyinfo' => 0,
    'industry_index' => 0,
    'v' => 0,
    'industry_name' => 0,
    'job_index' => 0,
    'job_name' => 0,
    'job_type' => 0,
    'city_index' => 0,
    'city_name' => 0,
    'city_type' => 0,
    'comdata' => 0,
    'comclass_name' => 0,
    'com_sex' => 0,
    'j' => 0,
    'userdata' => 0,
    'userclass_name' => 0,
    'qy_rows' => 0,
    'row' => 0,
    'partdata' => 0,
    'partclass_name' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d909e1271d25_39419707',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d909e1271d25_39419707')) {function content_62d909e1271d25_39419707($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/member_public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"></SCRIPT>
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
		<style>
			* {
			margin: 0;
			padding: 0;
		}
		body, div {
			margin: 0;
			padding: 0;
		}
		</style>
	</head>
	<?php echo '<script'; ?>
>var weburl="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
";<?php echo '</script'; ?>
>
	<body class="body_ifm">
		<div class="infoboxp" style="position:relative;">

			<div class="main_tag" style="padding: 0;background: none;">
				<div class="tty-tishi_top">
				<div class="tabs_info">
					<ul>
						<li class="on">采集设置</li>
						<li>新闻设置</li>
						<li>职位设置</li>
						<li>公司设置</li>
						<li>个人设置</li>
						<li>简历设置</li>
						<li>帐号设置</li>
						<li>兼职设置</li>
					</ul>
				</div>
				<div class="admin_new_tip">
					<a href="javascript:;" class="admin_new_tip_close"></a>
					<a href="javascript:;" class="admin_new_tip_open" style="display:none;"></a>
					<div class="admin_new_tit"><i class="admin_new_tit_icon"></i>操作提示</div>
					<div class="admin_new_tip_list_cont">
						<div class="admin_new_tip_list"><b>提示：</b>采集前务必设置自己的接口密码，以免被其他人利用。</div>
						<div class="admin_new_tip_list"><b>注意：</b>这里所设置的参数，只作为没有值的情况下使用，若采集软件有值传输，会优先使用传输值。</div>
					</div>
				</div>
				<div class="clear"></div>
				<div id="subboxdiv" style="width:100%;height:100%;display:none;position:absolute; z-index:10000"></div>

				<div class="clear"></div>
				<div class="tty_table-bom">
					<div class="tag_box">
						<div>
							<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
							<form action="index.php?m=collection&c=save" method="post" enctype="multipart/form-data" target="supportiframe"
							 class="layui-form">
								<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
								<table width="99%" class="table_form">
									<tr>
										<th width="200">采集状态：</th>
										<td>
											<div class="layui-input-block">
												<div class="layui-input-inline">
													<input type="radio" name="locoy_online" value="1" id="online_1" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_online']=="1") {?>checked<?php }?>
													 title="开启">
													<input type="radio" name="locoy_online" value="2" id="online_2" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_online']=="2") {?>checked<?php }?>
													 title="关闭">
												</div>
											</div>
										</td>
									</tr>
									<tr class="admin_table_trbg">
										<th width="200">接口密码：</th>
										<td>
											<input type="text" class="tty_input t_w480" name="locoy_key" id='locoy_key' value="<?php echo $_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_key'];?>
">
											<span class="admin_web_tip">如：123qwe123</span></td>
									</tr>
									<tr>
										<th width="200">匹配精准度：</th>
										<td><input type="text" class="tty_input t_w480" name="locoy_rate" id='locoy_rate' value="<?php echo $_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_rate'];?>
">
											<span class="admin_web_tip">如：60</span></td>
									</tr>
									<tr class="admin_table_trbg">
										<th width="200"></th>
										<td>
											<input class="layui-btn tty_sub" id="config" type="submit" name="config" value="提交">
											&nbsp;&nbsp;
											<input class="layui-btn tty_cz" type="reset" value="重置" /></td>
									</tr>
								</table>
							</form>
						</div>
						<div class="hiddendiv">
							<form action="index.php?m=collection&c=save" method="post" target="supportiframe" class="layui-form">
								<table width="100%" class="table_form">
									<tr>
										<th width="200">自动提动关键字：</th>
										<td>
											<div class="layui-input-block">
												<div class="layui-input-inline fl">
													<input type="radio" name="locoy_keyword" value="1" id="key_1" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_keyword']=="1") {?>checked<?php }?>
													 title="是">
													<input type="radio" name="locoy_keyword" value="2" id="key_2" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_keyword']=="2") {?>checked<?php }?>
													 title="否">
												</div>
												<div class="layui-form-mid layui-word-aux">注：只有在没有参数传输的才起作用</div>
											</div>
										</td>
									</tr>
									<tr class="admin_table_trbg">
										<th width="200">浏览数随机范围：</th>
										<td>
											<input type="text" class="tty_input t_w480" id='locoy_rand' name="locoy_rand" value="<?php echo $_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_rand'];?>
">
											<span class="admin_web_tip">如：0-100，默认为0</span></td>
									</tr>
									<tr>
										<th width="200">排序随机范围：</th>
										<td>
											<input type="text" class="tty_input t_w480" name="locoy_sort" id='locoy_sort' value="<?php echo $_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_sort'];?>
">
											<span class="admin_web_tip">如：0-100，默认为0</span></td>
									</tr>
									<tr class="admin_table_trbg">
										<th width="200"></th>
										<td>
											<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
											<input class="layui-btn tty_sub" id="otherconfig" type="submit" name="otherconfig" value="提交" />
											&nbsp;&nbsp;
											<input class="layui-btn tty_cz" type="reset" value="重置" />
										</td>
									</tr>
								</table>
							</form>
						</div>
						<div class="hiddendiv">
							<form action="index.php?m=collection&c=save" method="post" target="supportiframe" class="layui-form">
								<table width="100%" class="table_form">
									<tr>
										<th width="200">职位状态：</th>
										<td>
											<div class="layui-input-block">
												<div class="layui-input-inline">
													<input type="radio" name="locoy_job_status" value="1" id="key_1" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_job_status']=="1") {?>checked<?php }?> title="已通过">
													<input type="radio" name="locoy_job_status" value="0" id="key_2" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_job_status']!="1") {?>checked<?php }?> title="未审核">
												</div>
											</div>
										</td>
									</tr>
									<tr class="admin_table_trbg">
										<th width="200">职位发布日期：</th>
										<td>
											<div class="layui-input-block">
												<div class="layui-input-inline t_w480">
													<input id="ad_start" class="layui-input" type="text" readonly size="20" value="<?php echo $_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_job_sdate'];?>
"
													 name="locoy_job_sdate">
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<th width="200">从事行业无法匹配为：</th>
										<td>
												<div class="layui-input-block">
													<div class="layui-input-inline t_w480">
														<select name="locoy_job_hy" lay-filter="" id="locoy_job_hy_val">
															<option value="">请选择</option>
															<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['industry_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
															<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_job_hy']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['industry_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>

															 </option> <?php } ?> 
														</select> 
													</div> 
												</div> 
										</td> 
									</tr> 
									
									<tr class="admin_table_trbg">
										<th width="200">职位类别无法匹配为：</th>
										<td>
											<div class="layui-input-block">
												<div class="layui-input-inline t_w157">
													<select name="locoy_job_job1" lay-filter="jobclass" id="locoy_job_job1_val">
														<option value="">请选择</option>
														<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['job_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
														<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_job_job1']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['job_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>

														</option> <?php } ?> 
													</select> 
												</div> 
												<div class="layui-input-inline t_w157">
													<select name="locoy_job1_son" lay-filter="jobclass" id="locoy_job1_son_val">
														<option value="">请选择</option>
														<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['job_type']->value[$_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_job_job1']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
														<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_job1_son']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['job_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>

														</option> <?php } ?> 
													</select> 
												</div> 
												<div class="layui-input-inline t_w157">
													<select name="locoy_job_post" lay-filter="" id="locoy_job_post_val">
														<option value="">请选择</option>
														<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['job_type']->value[$_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_job1_son']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
														<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_job_post']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['job_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>

														</option> <?php } ?> 
													</select> 
												</div> 
											</div> 
										</td> 
									</tr> 
									<tr>
										<th width="200">地区无法匹配为：</th>
										<td>
											<div class="layui-input-block">
												<div class="layui-input-inline t_w157">
													<select name="locoy_job_province" lay-filter="citys" id="locoy_job_province_val">
														<option value="">请选择</option>
														<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['city_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
														<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_job_province']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>

														</option> <?php } ?> 
													</select> 
												</div> 
												<div class="layui-input-inline t_w157">
													<select name="locoy_job_city" lay-filter="citys" id="locoy_job_city_val">
														<option value="">请选择</option>
														<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_job_province']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
														<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_job_city']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>

														</option> <?php } ?> 
													</select> 
												</div> 
												<div class="layui-input-inline t_w157">
													<select name="locoy_job_three" lay-filter="" id="locoy_job_three_val">
														<option value="">请选择</option>
														<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_job_city']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
														<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_job_three']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>

														</option> <?php } ?> 
													</select> 
												</div> 
											</div> 
										</td> 
									</tr> 
									<tr class="admin_table_trbg">
										<th width="200">招聘人数无法匹配为：</th>
										<td>
											<div class="layui-input-block">
												<div class="layui-input-inline t_w480">
													<select name="locoy_com_number" lay-filter="" id="locoy_com_number_val">
														<option value="">请选择</option>
														<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['comdata']->value['job_number']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
														<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_com_number']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>

														</option> <?php } ?> 
													</select> 
												</div>
											</div> 
										</td> 
									</tr> 
									<tr>
										<th width="200">薪水待遇无法匹配为：</th>
										<td>
											<input type="text" class="input-text tips_class" id='locoy_minsalary' name="locoy_minsalary" value="<?php echo $_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_minsalary'];?>
" style="width: 216px;">
											<span> - &nbsp;</span>
											<input type="text" class="input-text tips_class" id='locoy_maxsalary' name="locoy_maxsalary" value="<?php echo $_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_maxsalary'];?>
" style="width: 216px;">
										</td>
									</tr>
									<tr class="admin_table_trbg">
										<th width="200">工作经验无法匹配为：</th>
										<td>
												<div class="layui-input-block">
													<div class="layui-input-inline t_w480">
														<select name="locoy_job_exp" lay-filter="" id="locoy_job_exp_val">
															<option value="">请选择</option>
															<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['comdata']->value['job_exp']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
															<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_job_exp']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>

															 </option> <?php } ?> </select> </div> </div> </td> </tr> <tr>
										<th width="200">到岗时间无法匹配为：</th>
										<td>
												<div class="layui-input-block">
													<div class="layui-input-inline t_w480">
														<select name="locoy_job_report" lay-filter="" id="locoy_job_report_val">
															<option value="">请选择</option>
															<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['comdata']->value['job_report']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
															<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_job_report']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>

															 </option> <?php } ?> </select> </div> </div></td> </tr> <tr class="admin_table_trbg">
										<th width="200">年龄要求无法匹配为：</th>
										<td>
												<div class="layui-input-block">
													<div class="layui-input-inline t_w480">
														<select name="locoy_job_age" lay-filter="" id="locoy_job_age_val">
															<option value="">请选择</option>
															<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['comdata']->value['job_age']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
															<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_job_age']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>

															 </option> <?php } ?> </select> </div> </div> </td> </tr> <tr class="admin_table_trbg">
										<th width="200">性别无法匹配为：</th>
										<td>
												<div class="layui-input-block">
													<div class="layui-input-inline t_w480">
														<select name="locoy_job_sexs" lay-filter="" id="locoy_job_sexs_val">
															<option value="">请选择</option>
															<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['com_sex']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
															<option value="<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_job_sexs']==$_smarty_tpl->tpl_vars['j']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value;?>

															 </option> <?php } ?> </select> </div> </div> </td> </tr> <tr>
										<th width="200">教育程度无法匹配为：</th>
										<td>
												<div class="layui-input-block">
													<div class="layui-input-inline t_w480">
														<select name="locoy_job_edu" lay-filter="" id="locoy_job_edu_val">
															<option value="">请选择</option>
															<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['comdata']->value['job_edu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
															<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_job_edu']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>

															 </option> <?php } ?> </select> </div> </div></td> </tr> <tr class="admin_table_trbg">
										<th width="200">婚姻状况无法匹配为：</th>
										<td>
												<div class="layui-input-block">
													<div class="layui-input-inline t_w480">
														<select name="locoy_job_marriage" lay-filter="" id="locoy_job_marriage_val">
															<option value="">请选择</option>
															<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['comdata']->value['job_marriage']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
															<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_job_marriage']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>

															 </option> <?php } ?> </select> </div> </div> </td> 
									</tr> 
									
									<tr>
										<th width="200"></th>
										<td>
											<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
											<input class="layui-btn tty_sub" id="codeconfig" type="submit" name="codeconfig" value="提交" />
											&nbsp;&nbsp;
											<input class="layui-btn tty_cz" type="reset" value="重置" /></td>
									</tr>
								</table>
							</form>
						</div>
						<div class="hiddendiv">
							<form action="index.php?m=collection&c=save" method="post" enctype="multipart/form-data" target="supportiframe" class="layui-form">
								<table width="100%" class="table_form">
									<tr>
										<th width="200">从事行业无法匹配为：</th>
										<td>
												<div class="layui-input-block">
													<div class="layui-input-inline t_w480">
														<select name="locoy_com_hy" lay-filter="" id="locoy_com_hy_val">
															<option value="">请选择</option>
															<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['industry_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
															<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_com_hy']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['industry_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>

															 </option> <?php } ?> </select> </div> </div> </td> </tr> <tr class="admin_table_trbg">
										<th width="200">企业性质无法匹配为：</th>
										<td>
												<div class="layui-input-block">
													<div class="layui-input-inline t_w480">
														<select name="locoy_job_pr" lay-filter="" id="locoy_job_pr_val">
															<option value="">请选择</option>
															<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['comdata']->value['job_pr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
															<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_job_pr']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>

															 </option> <?php } ?> </select> </div> </div> </td> </tr> 
										<tr>
											<th width="200">企业地址无法匹配为：</th>
											<td>
												<div class="layui-input-block">
													<div class="layui-input-inline" style="width: 238px;">
														<select name="locoy_com_province" lay-filter="citys" id="locoy_com_province_val">
															<option value="">请选择</option>
															<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['city_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
															<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_com_province']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>

															</option> <?php } ?> 
														</select> 
													</div> 
													<div class="layui-input-inline" style="width: 238px;">
														<select name="locoy_com_city" lay-filter="citys" id="locoy_com_city_val">
															<option value="">请选择</option>
															<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_com_province']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
															<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_com_city']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>

															</option> <?php } ?> 
														</select> 
													</div> 
												</div> 
											</td> 
										</tr> 
										<tr class="admin_table_trbg">
										<th width="200">企业规模无法匹配为：</th>
										<td>
												<div class="layui-input-block">
													<div class="layui-input-inline t_w480">
														<select name="locoy_job_mun" lay-filter="" id="locoy_job_mun_val">
															<option value="">请选择</option>
															<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['comdata']->value['job_mun']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
															<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_job_mun']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>

															 </option> <?php } ?> </select> </div> </div> </td> </tr> 
									<tr>
										<th width="200" class="t_fr">注册资金无值为：</th>
										<td>
											<div class="layui-input-block">
												<input type="text" class="tty_input t_w480" name="locoy_com_money" value="<?php echo $_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_com_money'];?>
">万元 
											</div>
											<span class="admin_web_tip">如：0-10000，默认为0</span>
										</td>
									</tr>
									<tr class="admin_table_trbg">
										<th width="200"></th>
										<td>
											<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
											<input class="layui-btn tty_sub" type="submit" name="waterconfig" value="提交" />
											&nbsp;&nbsp;
											<input class="layui-btn tty_cz" type="reset" value="重置" /></td>
									</tr>
								</table>
							</form>
						</div>
						<div class="hiddendiv">
							<form action="index.php?m=collection&c=save" method="post" target="supportiframe" class="layui-form">
								<table width="100%" class="table_form">
									<tr>
										<th width="200">性别无法匹配为：</th>
										<td>
												<div class="layui-input-block">
													<div class="layui-input-inline t_w480">
														<select name="locoy_user_sexs" lay-filter="" id="locoy_user_sexs_val">
															<option value="">请选择</option>
															<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['com_sex']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
															<option value="<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_user_sexs']==$_smarty_tpl->tpl_vars['j']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value;?>

															 </option> <?php } ?> </select> </div> </div> </td> </tr> <tr class="admin_table_trbg">
										<th width="200">婚姻无法匹配为：</th>
										<td>
												<div class="layui-input-block">
													<div class="layui-input-inline t_w480">
														<select name="locoy_user_marriage" lay-filter="" id="locoy_user_marriage_val">
															<option value="">请选择</option>
															<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_marriage']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
															<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_user_marriage']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>

															 </option> <?php } ?> </select> </div> </div> </td> </tr> <tr>
										<th width="200">教育程度无法匹配为：</th>
										<td>
												<div class="layui-input-block">
													<div class="layui-input-inline t_w480">
														<select name="locoy_user_edu" lay-filter="" id="locoy_user_edu_val">
															<option value="">请选择</option>
															<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_edu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
															<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_user_edu']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>

															 </option> <?php } ?> </select> </div> </div> </td> </tr> <tr class="admin_table_trbg">
										<th width="200">工作经验无法匹配为：</th>
										<td>
												<div class="layui-input-block">
													<div class="layui-input-inline t_w480">
														<select name="locoy_user_exp" lay-filter="" id="locoy_user_exp_val">
															<option value="">请选择</option>
															<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_word']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
															<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_user_exp']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>

															 </option> <?php } ?> </select> </div> </div> </td> </tr> <tr>
										<th width="200">民族无法匹配为：</th>
										<td>
											<input type="text" class="tty_input t_w480" name="locoy_user_nationality" id='locoy_user_nationality' value="<?php echo $_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_user_nationality'];?>
">
											<span class="admin_web_tip">如：汉族</span>
										</td>
									</tr>
									<tr class="admin_table_trbg">
										<th width="200"></th>
										<td><input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
											<input class="layui-btn tty_sub" id="mapconfig" type="submit" name="userconfig" value="提交" />
											&nbsp;&nbsp;
											<input class="layui-btn tty_cz" type="reset" value="重置" /></td>
									</tr>
								</table>
							</form>
						</div>
						<div class="hiddendiv">
							<form action="index.php?m=collection&c=save" method="post" target="supportiframe" class="layui-form">
								<table width="100%" class="table_form">
									<tr>
										<th width="200">简历状态：</th>
										<td>
												<div class="layui-input-block">
													<div class="layui-input-inline">
														<input type="radio" name="locoy_resume_status" value="1" id="key_1" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_resume_status']=="1") {?>checked<?php }?> title="已通过">
														<input type="radio" name="locoy_resume_status" value="0" id="key_2" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_resume_status']!="1") {?>checked<?php }?> title="未审核">
													</div>
												</div>
										</td>
									</tr>
									<tr>
										<th>期望从事行业无法匹配为：</th>
										<td>
												<div class="layui-input-block">
													<div class="layui-input-inline">
														<select name="locoy_resume_hy" lay-filter="" id="locoy_resume_hy_val">
															<option value="">请选择</option>
															<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['industry_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
															<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_resume_hy']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['industry_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>

															 </option> <?php } ?> </select> </div> </div> </td> </tr> <tr class="admin_table_trbg">
										<th width="180">期望从事职位无法匹配为：</th>
										<td>
											<div class="layui-input-block">
												<div class="layui-input-inline t_w157">
													<select name="locoy_resume_job1" lay-filter="jobclass" id="locoy_resume_job1_val">
														<option value="">请选择</option>
														<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['job_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
														<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_resume_job1']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['job_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>

														</option> <?php } ?> 
													</select> 
												</div> 
												<div class="layui-input-inline t_w157">
													<select name="locoy_resume_son" lay-filter="jobclass" id="locoy_resume_son_val">
														<option value="">请选择</option>
														<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['job_type']->value[$_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_resume_job1']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
														<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_resume_son']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['job_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>

														</option> <?php } ?> 
													</select> 
												</div> 
												<div class="layui-input-inline t_w157">
													<select name="locoy_resume_post" lay-filter="" id="locoy_resume_post_val">
														<option value="">请选择</option>
														<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['job_type']->value[$_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_resume_son']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
														<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_resume_post']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['job_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>

														</option> <?php } ?> 
													</select> 
												</div>
											</div> 
										</td> 
									</tr> 
									<tr>
										<th width="180">期望工作地点无法匹配为：</th>
										<td>
											<div class="layui-input-block">
												<div class="layui-input-inline t_w157">
													<select name="locoy_resume_province" lay-filter="citys" id="locoy_resume_province_val">
														<option value="">请选择</option>
														<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['city_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
														<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_resume_province']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>

														</option> <?php } ?> 
													</select> 
												</div> 
												<div class="layui-input-inline t_w157">
													<select name="locoy_resume_city" lay-filter="citys" id="locoy_resume_city_val">
														<option value="">请选择</option>
														<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_resume_province']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
														<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_resume_city']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>

														</option> <?php } ?> 
													</select> 
												</div> 
												<div class="layui-input-inline t_w157">
													<select name="locoy_resume_three" lay-filter="" id="locoy_resume_three_val">
														<option value="">请选择</option>
														<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_resume_city']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
														<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_resume_three']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>

														</option> <?php } ?> 
													</select> 
												</div> 
											</div> 
										</td> 
									</tr> 
									<tr class="admin_table_trbg">
										<th>期望月薪无法匹配为：</th>
										<td>
											<input type="text" class="input-text tips_class" id='locoy_user_minsalary' name="locoy_user_minsalary" value="<?php echo $_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_user_minsalary'];?>
" style="width: 216px;">
											<span> - &nbsp;</span>
											<input type="text" class="input-text tips_class" id='locoy_user_maxsalary' name="locoy_user_maxsalary" value="<?php echo $_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_user_maxsalary'];?>
" style="width: 216px;">
										</td>
									</tr>
									<tr>
										<th>到岗时间无法匹配为：</th>
										<td>
											<div class="layui-input-block">
												<div class="layui-input-inline t_w480">
													<select name="locoy_user_report" lay-filter="" id="locoy_user_report_val">
														<option value="">请选择</option>
														<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_report']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
														<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_user_report']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>

														</option> <?php } ?> 
													</select> 
												</div> 
											</div> 
										</td> 
									</tr> 
									<tr class="admin_table_trbg">
										<th width="200">浏览数随机范围：</th>
										<td>
											<input type="text" class="tty_input t_w480" id='locoy_resume_rand' name="locoy_resume_rand" value="<?php echo $_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_resume_rand'];?>
">
											<span class="admin_web_tip">如：0-100，默认为0</span>
										</td>
									</tr>
									<tr>
										<th width="200"></th>
										<td>
											<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
											<input class="layui-btn tty_sub" id="mapconfig" type="submit" name="resumeconfig" value="提交" />
											&nbsp;&nbsp;
											<input class="layui-btn tty_cz" type="reset" value="重置" />
										</td>
									</tr>
								</table>
							</form>
						</div>
						<div class="hiddendiv">
							<form action="index.php?m=collection&c=save" method="post" target="supportiframe" class="layui-form">
								<table width="100%" class="table_form">
									<tr>
										<th width="200">生成用户名长度：</th>
										<td>
											<input type="text" class="tty_input t_w480" name="locoy_length" id='locoy_length' value="<?php echo $_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_length'];?>
">
											<span class="admin_web_tip">如：8</span>
										</td>
									</tr>
									<tr class="admin_table_trbg">
										<th>生成用户名前缀：</th>
										<td><input type="text" class="tty_input t_w480" name="locoy_name" id='locoy_name' value="<?php echo $_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_name'];?>
">
											<span class="admin_web_tip">如：user 加随机字符</span></td>
									</tr>
									<tr>
										<th>生成指定密码：</th>
										<td><input type="text" class="tty_input t_w480" name="locoy_pwd" id='locoy_pwd' value="<?php echo $_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_pwd'];?>
">
											<span class="admin_web_tip">如：123456</span></td>
									</tr>
									<tr class="admin_table_trbg">
										<th>用户状态：</th>
										<td>
												<div class="layui-input-block">
													<div class="layui-input-inline">
														<input type="radio" name="locoy_user_status" value="1" id="user_1" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_user_status']=="1") {?>checked<?php }?> title="已审核">
														<input type="radio" name="locoy_user_status" value="2" id="user_2" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_user_status']=="2") {?>checked<?php }?> title="未审核">
													</div>
												</div>
										</td>
									</tr>
									<tr>
										<th style="float: right;margin-top: 10px;">企业会员等级：</th>
										<?php if (is_array($_smarty_tpl->tpl_vars['qy_rows']->value)) {?>
										<td>
												<div class="layui-input-block">
													<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['qy_rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
													<input type="radio" name="locoy_rating" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
" id="rating_<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
"
													 <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_rating']==$_smarty_tpl->tpl_vars['row']->value['id']) {?>checked<?php }?> title="<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
">
													<?php } ?>
												</div>
										</td>
										<?php } else { ?>
										<td> 暂无等级，<a href="index.php?m=userconfig&c=comclass" style="color:red;">添加会员等级</a>
											<input type="hidden" name="locoy_rating" value="0"></td>
										<?php }?>
									</tr>
									<tr class="admin_table_trbg">
										<th></th>
										<td>
											<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
											<input class="layui-btn tty_sub" id="mapconfig" type="submit" name="mapconfig" value="提交" />
											&nbsp;&nbsp;
											<input class="layui-btn tty_cz" type="reset" value="重置" /></td>
									</tr>
								</table>
							</form>
						</div>
						<div class="hiddendiv">
							<form action="index.php?m=collection&c=save" method="post" target="supportiframe" class="layui-form">
								<table width="100%" class="table_form">
									<tr>
										<th width="200">职位状态：</th>
										<td>
												<div class="layui-input-block">
													<input type="radio" name="locoy_partjob_status" value="1" id="key_1" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_partjob_status']=="1") {?>checked<?php }?> title="已通过">
													<input type="radio" name="locoy_partjob_status" value="0" id="key_2" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_partjob_status']!="1") {?>checked<?php }?> title="未审核">
												</div>
										</td>
									</tr>
									<tr>
										<th>工作类型无法匹配为：</th>
										<td>
												<div class="layui-input-block">
													<div class="layui-input-inline t_w480">
														<select name="locoy_part_type" lay-filter="" id="locoy_part_type_val">
															<option value="">请选择</option>
															<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['partdata']->value['part_type']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
															<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_part_type']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['partclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>

															 </option> <?php } ?> </select></div> </div> </td>
									</tr>
									
									<tr class="admin_table_trbg">
										<th width="180">薪水无法匹配为：</th>
										<td>
											<input type="text" class="tty_input t_w480" id='locoy_part_salary' name="locoy_part_salary" value="<?php echo $_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_part_salary'];?>
">
											元/天 
											<span class="admin_web_tip" style="margin-left: 10px;">如：15</span>
										</td>
									</tr>
									<tr>
										<th width="180">结算周期无法匹配为：</th>
										<td>
												<div class="layui-input-block">
													<div class="layui-input-inline t_w480">
														<select name="locoy_part_billing" lay-filter="" id="locoy_part_billing_val">
															<option value="">请选择</option>
															<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['partdata']->value['part_billing_cycle']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
															<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_part_billing']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['partclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>

															 </option> <?php } ?> </select> 
													</div> 
												</div> 
										</td> 
									</tr> 
									<tr class="admin_table_trbg">
										<th width="200">浏览数随机范围：</th>
										<td>
											<input type="text" class="tty_input t_w480" id='locoy_part_hits' name="locoy_part_hits" value="<?php echo $_smarty_tpl->tpl_vars['locoyinfo']->value['locoy_part_hits'];?>
">
											<span class="admin_web_tip">如：0-100，默认为0</span>
										</td>
									</tr>
									<tr>
										<th width="200"></th>
										<td>
											<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
											<input class="layui-btn tty_sub" id="partconfig" type="submit" name="partconfig" value="提交" />
											&nbsp;&nbsp;
											<input class="layui-btn tty_cz" type="reset" value="重置" /></td>
									</tr>
								</table>
							</form>
						</div>
					</div>
				</div>
			</div>

		</div>

		<?php echo '<script'; ?>
>
			var $switchtag = $("div.main_tag ul li");
			$switchtag.click(function() {
				$(this).addClass("on").siblings().removeClass("on");
				var index = $switchtag.index(this);
				$("div.tag_box > div").eq(index).show().siblings().hide();
			});

			layui.use(['layer', 'form', 'laydate'], function() {
				var layer = layui.layer,
					form = layui.form,
					laydate = layui.laydate,
					$ = layui.$;
				laydate.render({
					elem: '#ad_start'
				});
				laydate.render({
					elem: '#ad_end'
				});
				form.on('select(jobclass)', function(data) {
					$.post(weburl + "/index.php?m=ajax&c=ajax_job", {
						str: data.value
					}, function(htm) {
						if (data.elem.name == 'locoy_job_job1') {
							$("#locoy_job1_son_val").html(htm);
							$("#locoy_job_post_val").html("<option value=''>请选择</option>");
						} else if (data.elem.name == 'locoy_job1_son') {
							$("#locoy_job_post_val").html(htm);
						} else if (data.elem.name == 'locoy_resume_job1') {
							$("#locoy_resume_son_val").html(htm);
							$("#locoy_resume_post_val").html("<option value=''>请选择</option>");
						} else if (data.elem.name == 'locoy_resume_son') {
							$("#locoy_resume_post_val").html(htm);
						}
						form.render('select');
					});
				});
				form.on('select(citys)', function(data) {
					$.post(weburl + "/index.php?m=ajax&c=ajax", {
						str: data.value
					}, function(htm) {
						if (data.elem.name == 'locoy_job_province') {
							$("#locoy_job_city_val").html(htm);
							$("#locoy_job_three_val").html("<option value=''>请选择</option>");
						} else if (data.elem.name == 'locoy_job_city') {
							$("#locoy_job_three_val").html(htm);
						} else if (data.elem.name == 'locoy_resume_province') {
							$("#locoy_resume_city_val").html(htm);
							$("#locoy_resume_three_val").html("<option value=''>请选择</option>");
						} else if (data.elem.name == 'locoy_resume_city') {
							$("#locoy_resume_three_val").html(htm);
						} else if (data.elem.name == 'locoy_com_province') {
							$("#locoy_com_city_val").html(htm);
						} else if (data.elem.name == 'locoy_com_city') {
							$("#locoy_com_three_val").html(htm);
						}
						form.render('select');
					});
				});
			});
		<?php echo '</script'; ?>
>
	</body>
</html>
<?php }} ?>
