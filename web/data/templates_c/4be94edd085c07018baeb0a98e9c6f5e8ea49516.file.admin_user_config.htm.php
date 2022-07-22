<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:16:03
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_user_config.htm" */ ?>
<?php /*%%SmartyHeaderCode:2492862d8fd3376d2d3-70184624%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4be94edd085c07018baeb0a98e9c6f5e8ea49516' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_user_config.htm',
      1 => 1635304534,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2492862d8fd3376d2d3-70184624',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'userdata' => 0,
    'v' => 0,
    'userclass_name' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d8fd3388aea1_32132445',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d8fd3388aea1_32132445')) {function content_62d8fd3388aea1_32132445($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
		<title>后台管理</title>
	</head>

	<style>
		.layui-form-radio{
			margin-top: 4px;
		}
	</style>
	
	<body class="body_ifm">
		<form class="layui-form">

			<div id="subboxdiv" style="width:100%;height:100%;display:none;position:absolute;"></div>
		
			<div class="infoboxp">
				<div class="tty-tishi_top">
			
				<div class="tabs_info">
					<ul>
						<li class="curr">
							<a href="index.php?m=admin_userset">个人设置</a>
						</li>
						<li>
							<a href="index.php?m=admin_userset&c=logo">头像设置</a>
						</li>
						<li>
							<a href="index.php?m=admin_userset&c=userspend">消费设置</a>
						</li>
					</ul>
				</div>
				
				<div class="admin_new_tip">
					<a href="javascript:;" class="admin_new_tip_close"></a>
					<a href="javascript:;" class="admin_new_tip_open" style="display:none;"></a>
					<div class="admin_new_tit"><i class="admin_new_tit_icon"></i>操作提示</div>
					<div class="admin_new_tip_list_cont">
						<div class="admin_new_tip_list">通过个人设置，可以实现“简历审核、个人身份证认证”等设置。管理员根据自己运营需求自由设置。</div>
					</div>
				</div>

				<div class="clear"></div>

					<div class="tag_box">
						<div class="">
							<table width="100%" class="table_form">
								<tr>
									<th width="220" style="float: left;">审核信息：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
												<input name="user_state" title="会员审核" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['user_state']=='0') {?>checked<?php }?> />
											</div>
											<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
												<input name="resume_status" title="简历审核" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['resume_status']=='0') {?>checked<?php }?> />
											</div>
											<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
												<input name="user_revise_state" title="简历修改审核" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['user_revise_state']=='0') {?>checked<?php }?> />
											</div>


											<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
												<input name="user_height_resume" title="优质简历审核" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['user_height_resume']=='1') {?>checked<?php }?> />
											</div>

											<div class="layui-input-block">
												<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
													<input name="user_photo_status" title="头像审核" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['user_photo_status']=='1') {?>checked<?php }?> />
												</div>
												<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
													<input name="rshow_photo_status" title="作品审核" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['rshow_photo_status']=='1') {?>checked<?php }?> />
												</div>
												<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
													<input name="user_trust_status" title="委托简历审核" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['user_trust_status']=='0') {?>checked<?php }?> />
												</div>
											</div>
											<div class="layui-input-block">
												<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
													<input name="user_idcard_status" title="身份证审核" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['user_idcard_status']=='1') {?>checked<?php }?>/>
												</div>
												<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
													<input name="user_msg_status" title="求职咨询审核" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['user_msg_status']=='0') {?>checked<?php }?>/>
												</div>
											</div>
											
										</div>
									</td>
								</tr>

								<tr>
									<th width="220" style="float: left;">强制操作：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
												<input name="user_resume_status" title="创建简历" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['user_resume_status']=='1') {?>checked<?php }?> />
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<th width="220">拥有简历才可报名兼职：</th>
									<td>
										<div class="layui-input-block">
											<input type="checkbox" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_resume_partapply']=='1') {?>checked<?php }?> name="com_resume_partapply" lay-skin="switch" lay-filter="switchTest" lay-text="开启|关闭">
											<div class="layui-unselect layui-form-switch layui-form-onswitch" lay-skin="_switch">
												<em>开启</em><i></i>
											</div>
										</div>
									</td>
								</tr>
					 
								<tr class="admin_table_trbg">
									<th width="220" style="float: left;">简历创建必填项：</th>
									<td>
										
										<div class="layui-input-block">
											<input name="resume_create_exp" title="工作经历" <?php if ($_smarty_tpl->tpl_vars['config']->value['resume_create_exp']==1) {?> checked <?php }?> type="checkbox" lay-skin="primary" lay-filter="resume_create_exp"/>
											<input name="resume_create_edu" title="教育经历" <?php if ($_smarty_tpl->tpl_vars['config']->value['resume_create_edu']==1) {?> checked <?php }?> type="checkbox" lay-skin="primary" lay-filter="resume_create_edu"/>
											<input name="resume_create_project" title="项目经历" <?php if ($_smarty_tpl->tpl_vars['config']->value['resume_create_project']==1) {?> checked <?php }?> type="checkbox" lay-skin="primary"/>
										</div>

										<div id="expshow" <?php if ($_smarty_tpl->tpl_vars['config']->value['resume_create_exp']!=1) {?>style="display:none;"<?php }?>>  
											<div class="admin_tj_xz">
												<div class="layui-input-block">
													<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_word']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
													<div class="layui-input-inline" style="margin-top: 16px;">
														<input name="expcreate" title="<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
" value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if (in_array($_smarty_tpl->tpl_vars['v']->value,explode(',',$_smarty_tpl->tpl_vars['config']->value['expcreate']))!==false) {?> checked <?php }?> type="checkbox" lay-skin="primary"/>
													</div>
													<?php } ?>
												</div>
												<span class="admin_web_tip" style="padding-top: 15px;">工作经历非必填条件选择 &nbsp; 根据求职者填写基本信息时选择的工作经验，创建简历时可不强制填写工作经历</span>
											</div>
										</div> 
                                        <div id="edushow" <?php if ($_smarty_tpl->tpl_vars['config']->value['resume_create_edu']!=1) {?>style="display:none;"<?php }?>>
											<div class="admin_tj_xz">
												<div class="layui-input-block">
													<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_edu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
													<div class="layui-input-inline" style="margin-top: 16px;">
														<input name="educreate" title="<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
" value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if (in_array($_smarty_tpl->tpl_vars['v']->value,explode(',',$_smarty_tpl->tpl_vars['config']->value['educreate']))!==false) {?> checked <?php }?> type="checkbox" lay-skin="primary"/>
													</div>
													<?php } ?>
												</div>
												<span class="admin_web_tip" style="padding-top: 15px;">教育经历非必填条件选择 &nbsp; 根据求职者填写基本信息时选择的学历，创建简历时可不强制填写教育经历</span>
											</div>
                                        </div>
									</td>
								</tr>
                              
								<tr class="admin_table_trbg">
									<th width="220">简历置顶要求：</th>
									<td>
										<div class="layui-input-inline">
											<input name="user_work_regiser" title="工作经历" <?php if ($_smarty_tpl->tpl_vars['config']->value['user_work_regiser']==1) {?> checked <?php }?> type="checkbox" lay-skin="primary"/>
											<input name="user_edu_regiser" title="教育经历" <?php if ($_smarty_tpl->tpl_vars['config']->value['user_edu_regiser']==1) {?> checked <?php }?> type="checkbox" lay-skin="primary"/>
											<input name="user_project_regiser" title="项目经历" <?php if ($_smarty_tpl->tpl_vars['config']->value['user_project_regiser']==1) {?> checked <?php }?> type="checkbox" lay-skin="primary"/>
										</div>
									</td>
								</tr>
								<tr class="admin_table_trbg">
									<th width="220" class="t_fl">简历求职意向字数：</th>
									<td>
										<div class="layui-input-block ">
											<input class="tty_input t_w480" type="text" name="sy_rname_num" id="sy_rname_num" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_rname_num'];?>
" size="20" maxlength="2" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'')" />字
										</div>
									</td>
								</tr>
								<tr class="admin_table_trbg">
									<th width="220" class="t_fl">个人搜索器数量：</th>
									<td>
										<div class="layui-input-block ">
											<input class="tty_input t_w480" type="text" name="user_finder" id="user_finder" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['user_finder'];?>
" size="20" maxlength="255" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'')" />个
										</div>
										<span class="admin_web_tip">提示：数量太多，发送订阅邮件会很慢，为空则不限</span>
									</td>
								</tr>
								<tr>
									<th width="220" class="t_fl">个人会员发布简历数：</th>
									<td>
										<div class="layui-input-block">
											<input class="tty_input t_w480" type="text" name="user_number" id="user_number" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['user_number'];?>
" size="20" maxlength="255" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'')" />份
										</div>
										<span class="admin_web_tip">提示：为空则不限</span>
									</td>
								</tr>
								<tr class="admin_table_trbg">
									<th width="220" class="t_fl">个人会员向网站委托简历数：</th>
									<td>
										<div class="layui-input-block">
											<input class="tty_input t_w480" type="text" name="user_trust_number" id="user_trust_number" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['user_trust_number'];?>
" size="20" maxlength="255" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'')" />份
										</div>
										<span class="admin_web_tip">提示：为空或0则关闭委托</span>
									</td>
								</tr>
								<tr class="admin_table_trbg">
									<th width="220">姓名展示：</th>
									<td>
										<div class="layui-input-block">
											<input type="radio" name="user_name" value="1" title="用户自定义" <?php if ($_smarty_tpl->tpl_vars['config']->value['user_name']==1) {?>checked<?php }?>/>
											<input type="radio" name="user_name" value="2" title="编号" <?php if ($_smarty_tpl->tpl_vars['config']->value['user_name']==2) {?>checked<?php }?>/>
											<input type="radio" name="user_name" value="3" title="性别称呼" <?php if ($_smarty_tpl->tpl_vars['config']->value['user_name']==3) {?>checked<?php }?>/>
											<input type="radio" name="user_name" value="4" title="真实姓名" <?php if ($_smarty_tpl->tpl_vars['config']->value['user_name']==4) {?>checked<?php }?>/>
											<span class="admin_web_tip">编号：如NO.12，性别称呼：如冯先生/女士，真实姓名：如冯云鹏</span>
										</div>
									</td>
								</tr>
								<tr>
									<th width="220">个人简历头像：</th>
									<td>
										<div class="layui-input-block">
											<input type="radio" name="user_pic" value="1" title="用户自定义" <?php if ($_smarty_tpl->tpl_vars['config']->value['user_pic']==1) {?>checked<?php }?>/>
											<input type="radio" name="user_pic" value="2" title="显示" <?php if ($_smarty_tpl->tpl_vars['config']->value['user_pic']==2) {?>checked<?php }?>/>
											<input type="radio" name="user_pic" value="3" title="不显示" <?php if ($_smarty_tpl->tpl_vars['config']->value['user_pic']==3) {?>checked<?php }?>/>
										</div>
									</td>
								</tr>
								<tr>
									<th width="220" class="t_fl">申请职位要求简历完整度达到：</th>
									<td>
										<div class="layui-input-block">
											<input class="tty_input t_w480" type="text" name="user_sqintegrity" id="user_sqintegrity" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['user_sqintegrity'];?>
" size="20" maxlength="255" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'')" />%
										</div>
									</td>
								</tr>
								<tr>
									<th width="220">个人简历刷新类型：</th>
									<td>
										<div class="layui-input-block">
											<input type="radio" name="resume_sx" value="1" title="登录后自动刷新" <?php if ($_smarty_tpl->tpl_vars['config']->value['resume_sx']==1) {?>checked<?php }?>/>
											<input type="radio" name="resume_sx" value="2" title="弹出框手动刷新" <?php if ($_smarty_tpl->tpl_vars['config']->value['resume_sx']==2) {?>checked<?php }?>/>
										</div>
									</td>
								</tr>
								<tr class="admin_table_trbg">
                                    <th width="220" class="t_fl">简历模糊化：</th>
                                    <td>
										<div class="layui-input-block">
											<input type="radio" name="resume_open_check" lay-filter="type" value="1" title="开放" <?php if ($_smarty_tpl->tpl_vars['config']->value['resume_open_check']==1) {?>checked<?php }?>>
											<input type="radio" name="resume_open_check" lay-filter="type" value="2" title="企业登录" <?php if ($_smarty_tpl->tpl_vars['config']->value['resume_open_check']==2) {?>checked<?php }?>>
											<input type="radio" name="resume_open_check" lay-filter="type" value="3" title="发布职位" <?php if ($_smarty_tpl->tpl_vars['config']->value['resume_open_check']==3) {?>checked<?php }?>>
											<input type="radio" name="resume_open_check" lay-filter="type" value="4" title="下载简历(查看联系方式)" <?php if ($_smarty_tpl->tpl_vars['config']->value['resume_open_check']==4) {?>checked<?php }?>>
										</div>
										<span class="admin_web_tip">提示：若选择“开放”，任何人都可以查看具体的工作经历等内容</span>
                                    </td>
                                </tr>
								<tr class="admin_table_trbg">
									<th width="220">个人用户访问简历权限：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline fl">
												<input type="checkbox" name="sy_user_visit_resume" lay-skin="switch" lay-text="开启|关闭" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_user_visit_resume']=="1") {?> checked <?php }?> />
											</div>
											<span class="admin_web_tip fl ml30">
												提示：若选择"关闭"，个人用户将无法直接访问简历信息
											</span>
										</div>
									</td>
								</tr>
								<tr class="admin_table_trbg">
									<th width="220">待审核简历可以投递：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline fl">
												<input type="checkbox" name="sy_shresume_applyjob" lay-skin="switch" lay-text="开启|关闭" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_shresume_applyjob']=="1") {?> checked <?php }?> />
											</div>
											<span class="admin_web_tip fl ml30">
												提示：若选择"关闭"，待审核简历将无法投递
											</span>
										</div>
									</td>
								</tr>
								<tr class="admin_table_trbg">
									<th width="220">简历姓名限制：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline fl">
												<input type="checkbox" name="sy_resumename_num" lay-skin="switch" lay-text="开启|关闭" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_resumename_num']=="1") {?> checked <?php }?> />
											</div>
											<span class="admin_web_tip fl ml30">
												提示：若选择"开启"，简历姓名不少于2个汉字,不大于6个汉字,只能是汉字禁止其他字符
											</span>
										</div>
									</td>
								</tr>
								<tr class="">
									<th>&nbsp;</th>
									<td align="left">
										<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
"/>
										<input class="tty_sub" id="config" type="button" name="config" value="提交"/>&nbsp;&nbsp;
										<input class="tty_cz" type="reset" value="重置" />
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<?php echo '<script'; ?>
>
					layui.use(['layer', 'form'], function() {
						var layer = layui.layer,
							form = layui.form,
							$ = layui.$;
						form.on('checkbox(resume_create_edu)', function(data) {
							if(data.elem.checked) {
								$('#edushow').show();
							}else{
								$('#edushow').hide();
							}
						});
						form.on('checkbox(resume_create_exp)', function(data) {
							if(data.elem.checked) {
								$('#expshow').show();
							}else{
								$('#expshow').hide();
							}
						});
					});
					$(function() {
						$("#config").click(function() {
							var educreate	= "";
                        	$('input[name="educreate"]:checked').each(function() {
                                if(educreate == "") {
                                	educreate = $(this).val();
                                } else {
                                	educreate = educreate + "," + $(this).val();
                                }
                            });
							var expcreate	= "";
                        	$('input[name="expcreate"]:checked').each(function() {
                                if(expcreate == "") {
                                	expcreate = $(this).val();
                                } else {
                                	expcreate = expcreate + "," + $(this).val();
                                }
                            });
							loadlayer();
							$.post("index.php?m=admin_userset&c=save", {
								config: $("#config").val(),
								user_number: $("#user_number").val(),
								user_finder: $("#user_finder").val(),
								sy_rname_num: parseInt($('#sy_rname_num').val())>0 ? $('#sy_rname_num').val() : 10,
								user_work_regiser: $("input[name=user_work_regiser]").is(":checked") ? 1 : 0,
								user_edu_regiser: $("input[name=user_edu_regiser]").is(":checked") ? 1 : 0,
								user_project_regiser: $("input[name=user_project_regiser]").is(":checked") ? 1 : 0,
								//简历完善度达到80%以上验证，是否开启 1是开启 0是关闭  暂时不需要
								//简历完整度字段名称为：user_integrity_eighty
								user_integrity_eighty: $("input[name=user_integrity_eighty]:checked").val(),
								user_trust_number: $("#user_trust_number").val(),
								
								// 审核信息
								user_state: $("input[name=user_state]").is(":checked") ? 0 : 1,
								user_revise_state: $("input[name=user_revise_state]").is(":checked") ? 0 : 1,
								resume_status: $("input[name=resume_status]").is(":checked") ? 0 : 1,
								user_height_resume: $("input[name=user_height_resume]").is(":checked") ? 1 : 2,
								user_idcard_status: $("input[name=user_idcard_status]").is(":checked") ? 1 : 0,
								user_msg_status: $("input[name=user_msg_status]").is(":checked") ? 0 : 1,
								user_trust_status: $("input[name=user_trust_status]").is(":checked") ? 0 : 1,
								user_photo_status: $("input[name=user_photo_status]").is(":checked") ? 1 : 2,
								rshow_photo_status: $("input[name=rshow_photo_status]").is(":checked") ? 1 : 0,

								// 强制操作
								user_resume_status: $("input[name=user_resume_status]").is(":checked") ? 1 : 0,

								user_gzgzh: $("input[name=user_gzgzh]").is(":checked") ? 1 : 0,

								com_resume_partapply: $("input[name=com_resume_partapply]").is(":checked") ? 1 : 0,
								
								resume_open_check: $("input[name=resume_open_check]:checked").val(),

								resume_sx: $("input[name=resume_sx]:checked").val(),
								
								pytoken: $("#pytoken").val(),

								user_name: $("input[name=user_name]:checked").val(),
								//个人简历头像是否显示，1是用户自定义 2是显示 3是不显示
								user_pic: $("input[name=user_pic]:checked").val(),
								user_sqintegrity: $("#user_sqintegrity").val(),
								//简历创建必填项
								resume_create_edu: $("input[name=resume_create_edu]").is(":checked") ? 1 : 0,
								resume_create_exp: $("input[name=resume_create_exp]").is(":checked") ? 1 : 0,
								resume_create_project: $("input[name=resume_create_project]").is(":checked") ? 1 : 0,
								educreate:educreate,
								expcreate:expcreate,
								sy_user_visit_resume: $("input[name=sy_user_visit_resume]").is(":checked") ? 1 : 0,
								sy_shresume_applyjob: $("input[name=sy_shresume_applyjob]").is(":checked") ? 1 : 0,
								sy_resumename_num: $("input[name=sy_resumename_num]").is(":checked") ? 1 : 0,
							}, function(data, textStatus) {
								parent.layer.closeAll('loading');
								config_msg(data);
							});
						});
					})
				<?php echo '</script'; ?>
>
			</div>
		</form>
	</body>

</html>
<?php }} ?>
