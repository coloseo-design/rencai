<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-08 16:09:14
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\web_config.htm" */ ?>
<?php /*%%SmartyHeaderCode:2386462c7e62a962985-45551228%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c1519e3c0151471ef4d2e8b07caa2b0a11af4005' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\web_config.htm',
      1 => 1640333834,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2386462c7e62a962985-45551228',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'cache' => 0,
    'v' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c7e62aa4f8b0_86608013',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c7e62aa4f8b0_86608013')) {function content_62c7e62aa4f8b0_86608013($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
		<div class="infoboxp">
			<div class="tty-tishi_top">
				<div class="admin_new_tip">
					<a href="javascript:;" class="admin_new_tip_close"></a>
					<a href="javascript:;" class="admin_new_tip_open" style="display:none;"></a>
					<div class="admin_new_tit"><i class="admin_new_tit_icon"></i>操作提示</div>
					<div class="admin_new_tip_list_cont">
						<div class="admin_new_tip_list">页面设置功能：实现“伪静态设置、前台列表最大展示数量、外部链接”等进行设置！伪静态可以增强网站收录友好度！运营者大部分都是开启的！</div>
					</div>
				</div>
				<div class="clear"></div>

				<div class="tag_box">
					<div>
						<form method="post" class="layui-form">
							<table width="100%" class="table_form">

								<tr class="admin_table_trbg">
									<th width="270">伪静态设置：</th>
									<td>
										<div class="layui-input-inline fl">
											<input type="checkbox" name="sy_seo_rewrite" lay-skin="switch" lay-text="开启|关闭" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_seo_rewrite']=="1") {?> checked <?php }?> />
										</div>
										<span class="admin_web_tip fl ml30">修改伪静态之前要先根据服务器添加伪静态规则</span>
									</td>
								</tr>

								<tr>
									<th width="270">头部浮动导航：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline">
												<input type="checkbox" name="sy_header_fix" lay-skin="switch" lay-text="开启|关闭" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_header_fix']=="1") {?> checked <?php }?> />
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<th width="270">首页底部浮动提示条：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline">
												<input type="checkbox" name="sy_footer_fix" lay-skin="switch" lay-text="开启|关闭" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_footer_fix']=="1") {?> checked <?php }?> />
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<th width="270">友情链接申请：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline">
												<input type="checkbox" name="sy_linksq" lay-skin="switch" lay-text="开启|关闭" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_linksq']=="1") {?> checked <?php }?> />
											</div>
										</div>
									</td>
								</tr>
								<tr class="admin_table_trbg">
									<th width="270">切换身份类型：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline">
												<input type="checkbox" name="sy_user_change" lay-skin="switch" lay-text="开启|关闭" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_user_change']=="1") {?> checked <?php }?> />
											</div>
										</div>
									</td>
								</tr>
								<tr class="admin_table_trbg">
									<th width="270">切换身份免审核：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline">
												<input type="checkbox" name="sy_change_noshen" lay-skin="switch" lay-text="开启|关闭" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_change_noshen']=="1") {?> checked <?php }?> />
											</div>
										</div>
									</td>
								</tr>
								
								<tr class="admin_table_trbg">
									<th width="270">手机端自动跳转到wap：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline">
												<input type="checkbox" name="sy_wap_jump" lay-skin="switch" lay-text="开启|关闭" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_wap_jump']=="1") {?> checked <?php }?> />
											</div>
										</div>
									</td>
								</tr>

								<tr class="admin_table_trbg">
									<th width="270">PC端允许访问WAP端：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline">
												<input type="checkbox" name="sy_pc_jump_wap" lay-skin="switch" lay-text="开启|关闭" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_pc_jump_wap']=="1") {?> checked <?php }?> />
											</div>
										</div>
									</td>
								</tr>

								<tr class="admin_table_trbg">
									<th width="270">h5分享：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline">
												<input type="checkbox" name="sy_h5_share" lay-skin="switch" lay-text="开启|关闭" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_h5_share']=="1") {?> checked <?php }?> />
											</div>
										</div>
									</td>
								</tr>
								<tr class="admin_table_trbg">
									<th width="270">意见反馈手机号验证：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline">
												<input type="checkbox" name="sy_advice_mobilecode" lay-skin="switch" lay-text="开启|关闭" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_advice_mobilecode']=="1") {?> checked <?php }?> />
											</div>
										</div>
									</td>
								</tr>
								<tr class="admin_table_trbg">
									<th width="270">竞争力分析：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline">
												<input type="checkbox" name="sy_job_lookfx" lay-skin="switch" lay-text="开启|关闭" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_job_lookfx']=="1") {?> checked <?php }?> />
											</div>
										</div>
									</td>
								</tr>
								<tr class="admin_table_trbg">
									<th width="270">微信浏览器列表形式：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline fl">
												<input name="sy_wxwap_list" value="1" title="分页" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_wxwap_list']=="1") {?> checked
												 <?php }?> type="radio" />
												<input name="sy_wxwap_list" value="2" title="上拉加载" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_wxwap_list']=="2") {?> checked
												 <?php }?> type="radio" />
											</div>
										</div>
									</td>
								</tr>
								<tr class="admin_table_trbg">
									<th width="270">新闻显示形式：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline fl">
												<input name="sy_news_rewrite" value="1" title="动态" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_news_rewrite']=="1") {?> checked
												 <?php }?> type="radio" />
												<input name="sy_news_rewrite" value="2" title="静态" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_news_rewrite']=="2") {?> checked
												 <?php }?> type="radio" />
											</div>
											<span class="admin_web_tip fl ml30">修改为静态，访问时显示静态页内容，提升效率</span>
										</div>
									</td>
								</tr>
								<tr class="admin_table_trbg">
									<th width="270">数据分享二维码形式：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline fl">
												<input name="sy_ewm_type" value="wap" title="默认" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_ewm_type']=="wap") {?> checked
												 <?php }?> type="radio" />
												<input name="sy_ewm_type" value="weixin" title="场景码（公众号图文）" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_ewm_type']=="weixin") {?> checked
												 <?php }?> type="radio" />

												 <input name="sy_ewm_type" value="xcx" title="场景码（公众号小程序）" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_ewm_type']=="xcx") {?> checked
												 <?php }?> type="radio" />
											</div>
											
										</div>
										<span class="admin_web_tip">功能支持：海报、职位、简历、企业、兼职、资讯、公告、公招。</span>
										<span class="admin_web_tip">默认：扫码打开WAP链接 公众号：关注公众号自动回复图文 小程序：关注公众号自动推荐小程序（30天有效期，公众号必须关联小程序）</span>
									</td>
								</tr>
								<tr>
									<th width="270">找人才页面默认显示类别：
									</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline fl">
												<input name="sy_default_userclass" value="1" title="是" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_default_userclass']=="1") {?>
												 checked <?php }?> type="radio" />
												<input name="sy_default_userclass" value="2" title="否" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_default_userclass']=="2") {?>
												 checked <?php }?> type="radio" />
											</div>
											<span class="admin_web_tip fl ml30">
												若选择"否"，则直接显示简历列表
											</span>
										</div>
									</td>
								</tr>

								<tr class="admin_table_trbg">
									<th width="270">找工作页面默认显示类别：
									</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline fl">
												<input name="sy_default_comclass" value="1" title="是" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_default_comclass']=="1") {?>
												 checked <?php }?> type="radio" />
												<input name="sy_default_comclass" value="2" title="否" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_default_comclass']=="2") {?>
												 checked <?php }?> type="radio" />
											</div>
											<span class="admin_web_tip fl ml30">
												若选择"否"，则直接显示职位列表
											</span>
										</div>
									</td>
								</tr>
								<tr>
									<th width="270" class="t_fr">薪资单位：
									</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline">
												<select name="resume_salarytype" id="resume_salarytype">
													<option value="1" <?php if ($_smarty_tpl->tpl_vars['config']->value['resume_salarytype']==1) {?> selected<?php }?>>元</option>
													<option value="2" <?php if ($_smarty_tpl->tpl_vars['config']->value['resume_salarytype']==2) {?> selected<?php }?>>千元</option>
													<option value="3" <?php if ($_smarty_tpl->tpl_vars['config']->value['resume_salarytype']==3) {?> selected<?php }?>>K</option>
													<option value="4" <?php if ($_smarty_tpl->tpl_vars['config']->value['resume_salarytype']==4) {?> selected<?php }?>>k</option>
												</select> 
											</div> 
										</div>
										<span class="admin_web_tip">提示：薪资单位，该设置可以改变薪资显示单位</span>
									</td>
								</tr>

								<tr class="admin_table_trbg">
									<th width="270" class="t_fr">前台列表最大展示数量：</th>
									<td>
										<div class="layui-input-block t_w480">
											<input name="sy_indexpage" id="sy_indexpage" lay-verify="required|number" placeholder="请输入" autocomplete="off"
											 class="layui-input" type="text" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_indexpage'];?>
" size="30" maxlength="255" />
										</div>
										<span class="admin_web_tip">
											提示：0为不限
										</span>
									</td>
								</tr>
								<tr>
									<th width="270" class="t_fr">数据周期：</th>
									<td>
									<div class="layui-input-block">
											<div class="layui-input-inline t_w480">
												<input name="sy_datacycle" id="sy_datacycle" lay-verify="required|number" placeholder="请输入" autocomplete="off" class="layui-input" type="text" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_datacycle'];?>
" size="30" maxlength="255" />
											</div>&nbsp;&nbsp;天
										</div>
										<span class="admin_web_tip">
											提示：职位、简历仅展示N天内更新的数据，以解决数据冗余问题，0为不限；
										</span>
									</td>
								</tr>
								<tr>
									<th width="270" class="t_fr">登录时长：</th>

									<td>
									<div class="layui-input-block">
											<div class="layui-input-inline t_w480">
												<input name="sy_logintime" id="sy_logintime" placeholder="请输入" autocomplete="off" class="layui-input"
												 type="text" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_logintime'];?>
" size="30" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" />
											</div>&nbsp;&nbsp;天
										</div>
										<span class="admin_web_tip">
											提示：登录状态保持天数，默认1天
										</span>
									</td>
								</tr>

								<tr class="admin_table_trbg">
									<th width="270">默认登录方式：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline fl">
												<input name="sy_login_type" value="1" title="用户名登录" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_login_type']!="2") {?> checked
												 <?php }?> type="radio" />
												<input name="sy_login_type" value="2" title="短信登录" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_login_type']=="2") {?> checked
												 <?php }?> type="radio" />
											</div>
											<span class="admin_web_tip fl ml30">短信登录需要在短信设置中开启短信功能，并在短信模板设置中开启短信验证码登录。</span>
										</div>
									</td>
								</tr>

								
								<tr>
									<th width="270" class="t_fr">未登录用户可访问简历数量：</th>
									<td>
										<div class="layui-input-block t_w480">
											<input name="sy_resume_visitors" id="sy_resume_visitors" placeholder="请输入" autocomplete="off" class="layui-input"
											 type="text" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_resume_visitors'];?>
" size="30" maxlength="255" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" />
										</div>
										<span class="admin_web_tip">
											提示：0为不限
										</span>
									</td>
								</tr>

								<tr>
									<th width="270" class="t_fr">同一IP点击广告记录间隔：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline t_w480">
												<input name="sy_adclick" id="sy_adclick" placeholder="请输入" autocomplete="off" class="tty_input" type="text"
												 value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_adclick'];?>
" size="30" maxlength="255" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" />
											</div>&nbsp;&nbsp;小时
										</div>
										<span class="admin_web_tip">提示：0为不限，其他数字为期限内只记录一次</span>
									</td>
								</tr>
								<tr class="admin_table_trbg">
									<th width="270" class="t_fr">每天推荐职位/简历最大次数：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline t_w480">
												<input name="sy_recommend_day_num" id="sy_recommend_day_num" placeholder="请输入" autocomplete="off" class="layui-input"
												 type="text" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_recommend_day_num'];?>
" size="30" maxlength="255" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" />
											</div>&nbsp;&nbsp;次
										</div>
										<span class="admin_web_tip">
											提示：0为关闭
										</span>
									</td>
								</tr>
								<tr class="admin_table_trbg">
									<th width="270" class="t_fr">推荐职位/简历最小时间间隔(单位：秒)：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline t_w480">
												<input name="sy_recommend_interval" id="sy_recommend_interval" placeholder="请输入" autocomplete="off" class="layui-input"
												 type="text" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_recommend_interval'];?>
" size="30" maxlength="255" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" />
											</div>&nbsp;&nbsp;秒
										</div>
										<span class="admin_web_tip">
											提示：0为不限
										</span>
									</td>
								</tr>


								<tr class="admin_table_trbg">
									<th width="270" class="t_fr">每天简历外发最大次数：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline t_w480">
												<input name="sy_resumeout_day_num" id="sy_resumeout_day_num" placeholder="请输入" autocomplete="off" class="layui-input"
												 type="text" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_resumeout_day_num'];?>
" size="30" maxlength="255" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" />
											</div>&nbsp;&nbsp;次
										</div>
										<span class="admin_web_tip">
											提示：0为关闭
										</span>
									</td>
								</tr>

								<tr class="admin_table_trbg">
									<th width="270" class="t_fr">简历外发最小时间间隔(单位：秒)：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline t_w480">
												<input name="sy_resumeout_interval" id="sy_resumeout_interval" placeholder="请输入" autocomplete="off" class="layui-input"
												 type="text" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_resumeout_interval'];?>
" size="30" maxlength="255" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" />
											</div>&nbsp;&nbsp;秒
										</div>
										<span class="admin_web_tip">
											提示：0为不限
										</span>
									</td>
								</tr>


								<tr>
									<th width="270">
										<font>百度自动推送功能</font>：
									</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline">
												<input name="sy_zhanzhang_baidu" value="1" title="是" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_zhanzhang_baidu']=="1") {?>
												 checked <?php }?> type="radio" />
												<input name="sy_zhanzhang_baidu" value="2" title="否" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_zhanzhang_baidu']=="2") {?>
												 checked <?php }?> type="radio" />
											</div>
										</div>
									</td>
								</tr>

								<tr class="admin_table_trbg">
									<th width="270">新闻内链（职位关键字）：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline">
												<input name="sy_outlinks" value="1" title="是" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_outlinks']=="1") {?> checked <?php }?>
												 type="radio" />
												<input name="sy_outlinks" value="2" title="否" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_outlinks']=="2") {?> checked <?php }?>
												 type="radio" />
											</div>
											<span class="admin_web_tip">
												提示：该设置可以改变新闻内容信息，涉及网站职位关键字内容添加链接
											</span>
										</div>
									</td>
								</tr>

								<tr>
									<th width="270" class="t_fr">特别申明：</th>
									<td>
										<div class="layui-input-block">
											<textarea type="radio" name="sy_shenming" id="sy_shenming" class="web_text_textarea"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_shenming'];?>
 </textarea>
										</div>
										<span class="admin_web_tip">如：用人单位不得以任何名义收取求职者任何形式的费用</span>
									</td>
								</tr>
								<tr class="admin_table_trbg">
									<th width="270" class="t_fr">职位简历点击器：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline">
												<input class="layui-input" type="text" value="1" size="10" disabled="disabled" style="width: 80px; background: #f5f7fb;"/>
											</div>&nbsp;&nbsp;-<div class="layui-input-inline">
												<input class="layui-input" style='margin-left: 10px;width: 80px;' type="text" name="sy_job_hits" id="sy_job_hits" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_job_hits'];?>
" size="10"/>
											</div>
										</div>
										<span class="admin_web_tip">提示：最小为1，最大为100，每次在1-X范围随机增加</span>
									</td>
								</tr>
								<tr class="admin_table_trbg">
									<th width="270" class="t_fr">列表页区域默认设置：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline" style="width: 238px;">
												<select name="sy_web_city_one" id="sy_web_city_one" lay-filter="citys">
													<option value="">请选择</option>
													<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['cache']->value['city_index']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
													<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_web_city_one']==$_smarty_tpl->tpl_vars['v']->value) {?> selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['cache']->value['city_name'][$_smarty_tpl->tpl_vars['v']->value];?>

												</option> <?php } ?>
												</select> 
											</div> 
											<div class="layui-input-inline" style="width: 238px;">
												<select name="sy_web_city_two" id="sy_web_city_two" lay-filter="citys">
													<option value="">请选择</option>
													<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['cache']->value['city_type'][$_smarty_tpl->tpl_vars['config']->value['sy_web_city_one']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
													<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_web_city_two']==$_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['cache']->value['city_name'][$_smarty_tpl->tpl_vars['v']->value];?>

													</option> <?php } ?> 
												</select> 
											</div> 
										</div> 
										<span class="admin_web_tip">如：前台职位、简历、企业列表区域默认查询设置</span>
									</td>
								</tr>

								<tr class="admin_table_trbg">
									<th width="270">刷新时间格式：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline fl">

												<input name="sy_updates_set" value="1" title="xx时xx分" <?php if (!$_smarty_tpl->tpl_vars['config']->value['sy_updates_set']||$_smarty_tpl->tpl_vars['config']->value['sy_updates_set']=="1") {?> checked
												<?php }?>  type="radio" />
												<input name="sy_updates_set" value="2" title="xx小时前(小于一小时：xx分钟前)" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_updates_set']=="2") {?> checked
												<?php }?> type="radio" />

											</div>
											<span class="admin_web_tip fl ml30">设置 人才/职位（详情页/列表页）刷新时间格式，仅当天可用</span>
										</div>
									</td>
								</tr>

								<tr>
									<th width="270" class="t_fr">充值订单超时自动关闭：</th>

									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline t_w480">
												<input name="sy_closeOrder" id="sy_closeOrder" placeholder="请输入" autocomplete="off" class="layui-input"
													   type="text" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_closeOrder'];?>
" size="30" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" />
											</div>&nbsp;&nbsp;天
										</div>
										<span class="admin_web_tip">
											提示：充值订单超时天数，默认15天
										</span>
									</td>
								</tr>


								<th>&nbsp;</th>
								<td align="left">
									<input class="tty_sub" id="config" lay-submit="" lay-filter="demo1" type="button" name="config" value="提交" />&nbsp;&nbsp;
									<input class="tty_cz" type="reset" value="重置" /></td>
								</tr>
							</table>
						</form>
					</div>
				</div>
			</div>
		</div>

		<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
		<?php echo '<script'; ?>
 language=javascript src='<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/data/plus/city.cache.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
'><?php echo '</script'; ?>
>

		<?php echo '<script'; ?>
 type="text/javascript">
			var weburl = "<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
";
			var form, url = weburl + "/index.php?m=ajax&c=get_city_option";
			layui.use(['layer', 'form'], function() {
				var layer = layui.layer,
					form = layui.form,
					$ = layui.$;

				form.on('select(citys)', function(data) {
					var html = "<option value=''>请选择</option>";
					if (data.value) {
						$.each(ct[data.value], function(k, v) {
							html += "<option value='" + v + "'>" + cn[v] + "</option>";
						});
					}
					if (data.elem.name == 'sy_web_city_one') {

						$("#sy_web_city_two").html(html);
					}
					form.render('select');
				});

			});

			$(function() {
				$(".tips_class").hover(function() {
					var msg_id = $(this).attr('id');
					var msg = $('#' + msg_id + ' + font').html();
					if ($.trim(msg) != '') {
						layer.tips(msg, this, {
							guide: 1,
							style: ['background-color:#5EA7DC; color:#fff;top:-7px', '#5EA7DC']
						});
						$(".xubox_layer").addClass("xubox_tips_border");
					}
				}, function() {
					var msg_id = $(this).attr('id');
					var msg = $('#' + msg_id + ' + font').html();
					if ($.trim(msg) != '') {
						layer.closeAll('tips');
					}
				});

				$("#config").click(function() {
					loadlayer();
					$.post("index.php?m=web_config&c=save", {
						config: $("#config").val(),
						sy_seo_rewrite: $("input[name=sy_seo_rewrite]").is(":checked") ? 1 : 0,
						sy_header_fix: $("input[name=sy_header_fix]").is(":checked") ? 1 : 0,
						sy_footer_fix: $("input[name=sy_footer_fix]").is(":checked") ? 1 : 0,
						sy_news_rewrite: $("input[name=sy_news_rewrite]:checked").val(),
						sy_linksq: $("input[name=sy_linksq]").is(":checked") ? 1 : 0,
						sy_wap_jump: $("input[name=sy_wap_jump]").is(":checked") ? 1 : 0,
						sy_user_change: $("input[name=sy_user_change]").is(":checked") ? 1 : 0,
						sy_change_noshen : $("input[name=sy_change_noshen]").is(":checked") ? 1 : 0,
						sy_pc_jump_wap: $("input[name=sy_pc_jump_wap]").is(":checked") ? 1 : 0,
						sy_default_comclass: $("input[name=sy_default_comclass]:checked").val(),
						sy_zhanzhang_baidu: $("input[name=sy_zhanzhang_baidu]:checked").val(),
						sy_default_userclass: $("input[name=sy_default_userclass]:checked").val(),
						sy_ewm_type: $("input[name=sy_ewm_type]:checked").val(),
						sy_job_hits: $("input[name=sy_job_hits]").val(),
						sy_indexpage: $("#sy_indexpage").val(),
						sy_resume_visitors: $("#sy_resume_visitors").val(),
						sy_datacycle: $("#sy_datacycle").val()?$("#sy_datacycle").val():0,
						sy_logintime: $("#sy_logintime").val()?$("#sy_logintime").val():1,
						sy_login_type:$("input[name=sy_login_type]:checked").val(),
						sy_closeOrder: $("#sy_closeOrder").val()?$("#sy_closeOrder").val():15,
						sy_h5_share: $("input[name=sy_h5_share]").is(":checked") ? 1 : 0,
						sy_advice_mobilecode:$("input[name=sy_advice_mobilecode]").is(":checked") ? 1 : 0,
						sy_job_lookfx:$("input[name=sy_job_lookfx]").is(":checked") ? 1 : 0,
						sy_wxwap_list:$("input[name=sy_wxwap_list]:checked").val(),
						sy_adclick: $("#sy_adclick").val(),
						sy_outlinks: $("input[name=sy_outlinks]:checked").val(),
						sy_shenming: $("#sy_shenming").val(),
						sy_autoref: $("#sy_autoref").val(),
						sy_autorefrand: $("input[name=sy_autorefrand]:checked").val(),
						sy_recommend_day_num: $("#sy_recommend_day_num").val(),
						sy_recommend_interval: $("#sy_recommend_interval").val(),
						sy_resumeout_day_num: $("#sy_resumeout_day_num").val(),
						sy_resumeout_interval: $("#sy_resumeout_interval").val(),
						sy_web_city_one: $("#sy_web_city_one").find("option:selected").val(),
						sy_web_city_two: $("#sy_web_city_two").find("option:selected").val(),
						resume_salarytype: $("#resume_salarytype").find("option:selected").val(),
						pytoken: $("#pytoken").val(),
						sy_updates_set:$("input[name=sy_updates_set]:checked").val()
					}, function(data, textStatus) {
						parent.layer.closeAll('loading');
						config_msg(data);
					});
				});
			});
		<?php echo '</script'; ?>
>
	</body>
</html>
<?php }} ?>
