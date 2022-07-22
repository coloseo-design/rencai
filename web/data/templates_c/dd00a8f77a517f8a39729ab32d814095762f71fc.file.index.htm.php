<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-22 10:13:53
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\resume\jianli1\index.htm" */ ?>
<?php /*%%SmartyHeaderCode:2502962da07e1df9f78-43234772%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dd00a8f77a517f8a39729ab32d814095762f71fc' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\resume\\jianli1\\index.htm',
      1 => 1643012865,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2502962da07e1df9f78-43234772',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'keywords' => 0,
    'description' => 0,
    'resumestyle' => 0,
    'config' => 0,
    'style' => 0,
    'Info' => 0,
    'pre' => 0,
    'usertype' => 0,
    'uid' => 0,
    'UserMember' => 0,
    'key' => 0,
    'v' => 0,
    'resumeCkeck' => 0,
    'one' => 0,
    'tj' => 0,
    'tplurl' => 0,
    'paytpls' => 0,
    'eid' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62da07e211bad7_54238983',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62da07e211bad7_54238983')) {function content_62da07e211bad7_54238983($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.url.php';
if (!is_callable('smarty_modifier_date_format')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\modifier.date_format.php';
?><!DOCtYPE html PUBLIC "-//W3C//DtD XHtML 1.0 transitional//EN" "http://www.w3.org/tR/xhtml1/DtD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
		<meta name=keywords content="<?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
" />
		<meta name=description content="<?php echo $_smarty_tpl->tpl_vars['description']->value;?>
" />
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['resumestyle']->value;?>
/css/resume.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/css" />
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/style/tips.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/css" />
		<link href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/datetimepicker/jquery.datetimepicker.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
		<?php echo '<script'; ?>
>
			var weburl = "<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
";
		<?php echo '</script'; ?>
>
		<style type="text/css" media=print>
			.noprint {
				display: none
			}
		</style>

		<body class="resume_bg_c">
			<div class="yun_resume_content" style="<?php if ($_GET['see']=='member') {?>width:850px<?php }?>">
				<?php if ($_GET['see']!='member') {?>
				<!--header-->
				<div class="yun_resume_header noprint">
					<div class="yun_resume_logo">
						<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_logo'];?>
" class="png" style=" border:none;"></a>
					</div>
					<div class="yun_resume_logo_zt">
						编号：<span class="yun_resume_logo_zt_n"><?php echo $_smarty_tpl->tpl_vars['Info']->value['id'];?>
</span>
						<em class="yun_resume_logo_zt_list"> 简历更新：<span class="yun_resume_logo_zt_n"><?php echo $_smarty_tpl->tpl_vars['Info']->value['lastupdate'];?>
  </span>  </em> 
						浏览：<span class="yun_resume_logo_zt_n"><?php echo '<script'; ?>
 language="javascript" src="<?php echo smarty_function_url(array('m'=>'resume','c'=>'show','a'=>'GetHits','id'=>'`$Info.id`'),$_smarty_tpl);?>
"><?php echo '</script'; ?>
> 次 </span> 
						<em class="yun_resume_logo_zt_list">两周内简历回复率：<span class="yun_resume_logo_zt_n"><?php echo $_smarty_tpl->tpl_vars['pre']->value;?>
%</span></em>
					</div>
				</div>
				<!--header end-->
				<?php }?>
				<div class="yun_resume_left">
					<?php if ($_smarty_tpl->tpl_vars['Info']->value['sqInfo']) {?>
					<div class="yun_resume_sq_job">
						<ul>
							<li>投递职位：<?php echo $_smarty_tpl->tpl_vars['Info']->value['sqInfo']['sq_job_name'];?>
</li>
							<li>投递时间：<?php echo $_smarty_tpl->tpl_vars['Info']->value['sqInfo']['sq_job_time'];?>
</li>
							<li>最近登录：<?php echo $_smarty_tpl->tpl_vars['Info']->value['login_date_n'];?>
</li>
						</ul>
					</div>
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['Info']->value['info_status']=="1"||$_smarty_tpl->tpl_vars['usertype']->value=="2"||$_smarty_tpl->tpl_vars['Info']->value['uid']==$_smarty_tpl->tpl_vars['uid']->value) {?>
					<div class="one_vita_content">
						<div class="one_vita_Basic">
							<div class="one_vita_Basic_photo"><img src="<?php echo $_smarty_tpl->tpl_vars['Info']->value['photo'];?>
" onerror="showImgDelay(this,'<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_member_icon'];?>
',2);" width="120" height="120"></div>
							<div class="one_vita_Basic_info">
								<i class="one_vita_Basic_info_bg"></i>
								<div class="one_vita_name">
									<?php if ($_smarty_tpl->tpl_vars['Info']->value['m_status']=="1") {
echo $_smarty_tpl->tpl_vars['Info']->value['name'];
} else {
echo $_smarty_tpl->tpl_vars['Info']->value['username_n'];
}?> 
									<?php if ($_smarty_tpl->tpl_vars['Info']->value['idcard_status']==1&&$_smarty_tpl->tpl_vars['Info']->value['idcard']) {?><span class="one_vita_name_yrz"><img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/app/template/resume/images/three_sf.png" title="身份已认证"> 已认证</span><?php }?> 
									<?php if ($_smarty_tpl->tpl_vars['UserMember']->value['source']==6&&$_smarty_tpl->tpl_vars['UserMember']->value['claim']==0&&$_smarty_tpl->tpl_vars['UserMember']->value['email']!='') {?>
									<a class="resume_rz " href="javascript:void(0);" onClick="claim('<?php echo smarty_function_url(array('m'=>'ajax','c'=>'claim','uid'=>$_smarty_tpl->tpl_vars['Info']->value['uid']),$_smarty_tpl);?>
')">认领</a>
									<?php }?>
									
	       		<!-- 优质人才标识   ------------------------------------------------------------------>
			<?php if ($_smarty_tpl->tpl_vars['Info']->value['height_status']==2) {?> <i class="yun_newedition_resume_good" style="right:-55px;top:20px;"></i><?php }?>
									
								</div>
								
								<div class="one_vita_line "></div>
								
								
								<div class="one_vita_Basic_info_t">
									<span class="one_vita_Basic_icon one_vita_Basic_Sex  png"><?php echo $_smarty_tpl->tpl_vars['Info']->value['job_sex'];?>
</span>
									<span class="one_vita_Basic_icon one_vita_Basic_Age png"><?php echo $_smarty_tpl->tpl_vars['Info']->value['age'];?>
岁</span>
									<span class="one_vita_Basic_icon one_vita_Basic_Exp png"><?php echo $_smarty_tpl->tpl_vars['Info']->value['user_exp'];?>
</span>
									<span class="one_vita_Basic_icon one_vita_Basic_Edu png">学历：<?php echo $_smarty_tpl->tpl_vars['Info']->value['useredu'];?>
</span>
									<span class="one_vita_Basic_icon one_vita_Basic_add png"><?php echo $_smarty_tpl->tpl_vars['Info']->value['living'];?>
</span>
								</div>
								<?php if ($_smarty_tpl->tpl_vars['Info']->value['basic_info']=='1') {?>
								<div class="one_vita_Basic_info_c">
									<?php if ($_smarty_tpl->tpl_vars['Info']->value['user_marriage']) {?><span class="one_vita_Identity"><?php echo $_smarty_tpl->tpl_vars['Info']->value['user_marriage'];?>
</span><span class="one_vita_line_jg">|</span><?php }?> 
									<?php if ($_smarty_tpl->tpl_vars['Info']->value['domicile']) {?><span class="one_vita_Identity">户籍：<?php echo $_smarty_tpl->tpl_vars['Info']->value['domicile'];?>
 </span><span class="one_vita_line_jg">|</span><?php }?>
									<?php if ($_smarty_tpl->tpl_vars['Info']->value['weight']||$_smarty_tpl->tpl_vars['Info']->value['height']) {?>
								    <span class="one_vita_Identity">
								    	<?php if ($_smarty_tpl->tpl_vars['Info']->value['height']) {
echo $_smarty_tpl->tpl_vars['Info']->value['height'];?>
cm<?php }?>
								    	<?php if ($_smarty_tpl->tpl_vars['Info']->value['weight']&&$_smarty_tpl->tpl_vars['Info']->value['height']) {?>/<?php }?>
								    	<?php if ($_smarty_tpl->tpl_vars['Info']->value['weight']) {?> <?php echo $_smarty_tpl->tpl_vars['Info']->value['weight'];?>
kg<?php }?> 
								    </span>
								    <span class="one_vita_line_jg">|</span>
								    <?php }?> 
									<?php if ($_smarty_tpl->tpl_vars['Info']->value['nationality']) {?><span class="one_vita_Identity"><?php echo $_smarty_tpl->tpl_vars['Info']->value['nationality'];?>
</span><?php }?>
								</div>
								<?php }?>
							</div>
						</div>
						<?php }?>

						<div class="one_vita_list_cont">
							<div class="one_vita_list">
								<div class="one_vita_list_h1"><span class="one_vita_list_h1_span">求职意向</span></div>
								<i class="one_vita_list_h1_iconbg"></i>
								<i class="one_vita_list_h1_icon reaume_iconyx"></i>
								<div class="one_vita_list_line">
									<div class="one_vita_Intention "><i class="one_vita_Intention_i one_vita_red"></i>意向岗位：<?php echo $_smarty_tpl->tpl_vars['Info']->value['customjob'];?>
 </div>
									<div class="one_vita_Intention"><i class="one_vita_Intention_i one_vita_red"></i>工作地点： 
										<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['Info']->value['expectcity']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?> 
											<?php if ($_smarty_tpl->tpl_vars['key']->value<5) {?> 
												<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
&nbsp; 
											<?php }?>
										<?php } ?> 
									</div>

									<div class="one_vita_Intention "><i class="one_vita_Intention_i one_vita_red"></i>期望行业：<?php echo $_smarty_tpl->tpl_vars['Info']->value['hy'];?>
 </div>
									<div class="one_vita_Intention"><i class="one_vita_Intention_i one_vita_red"></i>待遇要求：<?php echo $_smarty_tpl->tpl_vars['Info']->value['salary'];?>
</div>
									<?php if ($_smarty_tpl->tpl_vars['Info']->value['report']) {?><div class="one_vita_Intention "><i class="one_vita_Intention_i one_vita_red"></i>到职时间：<?php echo $_smarty_tpl->tpl_vars['Info']->value['report'];?>
</div><?php }?> 
									<?php if ($_smarty_tpl->tpl_vars['Info']->value['type']) {?><div class="one_vita_Intention "><i class="one_vita_Intention_i one_vita_red"></i>职位性质：<?php echo $_smarty_tpl->tpl_vars['Info']->value['type'];?>
</div><?php }?> 
									<?php if ($_smarty_tpl->tpl_vars['Info']->value['jobstatus']) {?><div class="one_vita_Intention "><i class="one_vita_Intention_i one_vita_red"></i>求职状态：<?php echo $_smarty_tpl->tpl_vars['Info']->value['jobstatus'];?>
</div> <?php }?>
									<div class="one_vita_Intention" style="width:600px;">
										<i class="one_vita_Intention_i one_vita_red" style="top:18"></i>工作职能： 
										<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['Info']->value['expectjob']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?> 
											<?php if ($_smarty_tpl->tpl_vars['key']->value<5) {?><span class=""><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</span><?php }?> 
										<?php } ?>
									</div>
								</div>
							</div>
							<?php if ($_smarty_tpl->tpl_vars['resumeCkeck']->value==1) {?>
								<?php if (!empty($_smarty_tpl->tpl_vars['Info']->value['description'])) {?>
								<div class="one_vita_list">

									<div class="one_vita_list_h1"><span class="one_vita_list_h1_span">自我评价</span></div>
									<i class="one_vita_list_h1_iconbg"></i>
									<i class="one_vita_list_h1_icon reaume_iconpj"></i>

									<div class="one_vita_list_line">
										<div class="one_vita_skill">
											<div class="one_vita_skill_Intention"><i class="one_vita_Intention_i one_vita_red"></i>自我评价：<?php echo $_smarty_tpl->tpl_vars['Info']->value['description'];?>
 </div>
											<?php if ($_smarty_tpl->tpl_vars['Info']->value['arrayTag']) {?>
											<div class="one_vita_skill_Intention" style="padding-top:15px;">
												<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Info']->value['arrayTag']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
													<span class="resume_user_bq"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</span> 
												<?php } ?>
											</div>
											<?php }?>
										</div>
									</div>
								</div>
								<?php }?> 
								
								
								<?php if (is_array($_smarty_tpl->tpl_vars['Info']->value['user_work'])&&!empty($_smarty_tpl->tpl_vars['Info']->value['user_work'])) {?>
								<div class="one_vita_list" id="m3">
									<div class="one_vita_list_h1"><span class="one_vita_list_h1_span">工作经历</span>
									</div>
									<i class="one_vita_list_h1_iconbg"></i>
									<i class="one_vita_list_h1_icon reaume_iconjl"></i>
									
									<div class="one_vita_list_line">
										<?php if ($_smarty_tpl->tpl_vars['Info']->value['avghour']>0) {?><span class="yun_resume_jobtime">平均工作时长：<?php echo $_smarty_tpl->tpl_vars['Info']->value['avghourInfo'];?>
</span><?php }?>
										<?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['one']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Info']->value['user_work']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value) {
$_smarty_tpl->tpl_vars['one']->_loop = true;
?>
										<div class="one_vita_skill">
											<div class="one_vita_skill_Intention">
												<?php if ($_smarty_tpl->tpl_vars['one']->value['sdate']!=0) {?><div class="one_vita_introduction_a one_vita_date"><i class="one_vita_Intention_i one_vita_red"></i><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['one']->value['sdate'],"%Y年%m月");?>
 - <?php if ($_smarty_tpl->tpl_vars['one']->value['edate']) {
echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['one']->value['edate'],"%Y年%m月");
} else { ?>至今<?php }?> </div><span style="color: red;">【<?php echo $_smarty_tpl->tpl_vars['one']->value['time_n'];?>
】</span><?php }?>
												<div class="one_vita_introduction_a one_vita_dw_name bold"><?php echo $_smarty_tpl->tpl_vars['one']->value['name'];?>
</div>
												<?php if ($_smarty_tpl->tpl_vars['one']->value['title']) {?>
												<div class="one_vita_introduction_a one_vita_dw_zw bold">担任：<?php echo $_smarty_tpl->tpl_vars['one']->value['title'];?>
</div>
												<?php }?>
											</div>
											<?php if ($_smarty_tpl->tpl_vars['one']->value['content']) {?>
											<div class="one_vita_skill_Intention">工作职责：<?php echo $_smarty_tpl->tpl_vars['one']->value['content'];?>
 </div>
											<?php }?>
										</div>
										<?php } ?>
									</div>
								</div>
								<?php }?> 
								<?php if (is_array($_smarty_tpl->tpl_vars['Info']->value['user_edu'])&&!empty($_smarty_tpl->tpl_vars['Info']->value['user_edu'])) {?>
								<div class="one_vita_list" id="m0">
									<div class="one_vita_list_h1"><span class="one_vita_list_h1_span">教育经历</span></div>
									<i class="one_vita_list_h1_iconbg"></i>
									<i class="one_vita_list_h1_icon reaume_iconjy"></i>
									
									<div class="one_vita_list_line">
										<?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['one']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Info']->value['user_edu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value) {
$_smarty_tpl->tpl_vars['one']->_loop = true;
?>
										<div class="one_vita_skill">
											<div class="one_vita_skill_Intention">
												<?php if ($_smarty_tpl->tpl_vars['one']->value['sdate']>0) {?><div class="one_vita_introduction_a one_vita_date"><i class="one_vita_Intention_i one_vita_red"></i><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['one']->value['sdate'],"%Y年%m月");?>
 - <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['one']->value['edate'],"%Y年%m月");?>
 </div><?php }?>
												<div class="one_vita_introduction_a one_vita_jy_x bold"><?php echo $_smarty_tpl->tpl_vars['one']->value['name'];?>
 </div>
												<?php if ($_smarty_tpl->tpl_vars['one']->value['education_n']) {?><div class="one_vita_introduction_a one_vita_dw_jydr ">学历：<?php echo $_smarty_tpl->tpl_vars['one']->value['education_n'];?>
</div><?php }?>
												<?php if ($_smarty_tpl->tpl_vars['one']->value['title']) {?><div class="one_vita_introduction_a one_vita_dw_jydr ">职务：<?php echo $_smarty_tpl->tpl_vars['one']->value['title'];?>
</div><?php }?>
												<?php if ($_smarty_tpl->tpl_vars['one']->value['specialty']) {?><div class="one_vita_introduction_a one_vita_dw_jydr ">主修专业：<?php echo $_smarty_tpl->tpl_vars['one']->value['specialty'];?>
</div><?php }?>
											</div>
										</div>
										<?php } ?>
									</div>
								</div>
								<?php }?>
								<?php if ($_smarty_tpl->tpl_vars['Info']->value['m_status']=="1") {?> <?php if (is_array($_smarty_tpl->tpl_vars['Info']->value['user_skill'])&&!empty($_smarty_tpl->tpl_vars['Info']->value['user_skill'])) {?>
								<div class="one_vita_list" id="m2">
									<div class="one_vita_list_h1"><span class="one_vita_list_h1_span">职业技能</span></div>
									<i class="one_vita_list_h1_iconbg"></i>
									<i class="one_vita_list_h1_icon reaume_iconjn"></i>
									<div class="one_vita_list_line" id="skill_photos">
										<?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['one']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Info']->value['user_skill']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value) {
$_smarty_tpl->tpl_vars['one']->_loop = true;
?>
										<div class="one_vita_skill">
											<div class="one_vita_skill_Intention"> <i class="one_vita_Intention_i one_vita_red"></i>
												<div class=" ">技能名称：<?php echo $_smarty_tpl->tpl_vars['one']->value['name'];?>
</div>
												<div class=" ">熟练程度：<?php echo $_smarty_tpl->tpl_vars['one']->value['ing_n'];?>
</div>
												<?php if ($_smarty_tpl->tpl_vars['one']->value['longtime']) {?><div class=" ">掌握时间：<?php echo $_smarty_tpl->tpl_vars['one']->value['longtime'];?>
年 </div><?php }?>
												<?php if ($_smarty_tpl->tpl_vars['one']->value['picurl']) {?>
												<div class="zs_imgbox ">技能证书：
												<?php if ($_smarty_tpl->tpl_vars['one']->value['picurl']) {?>
													<img src="<?php echo $_smarty_tpl->tpl_vars['one']->value['picurl'];?>
" lay-src="<?php echo $_smarty_tpl->tpl_vars['one']->value['picurl'];?>
" width="210" height="153" />
												<?php }?> 
												</div>
												<?php }?>
											</div>
										</div>
										<?php } ?>
									</div>
									
								</div>
								<?php }?>
								<?php }?> <?php if (is_array($_smarty_tpl->tpl_vars['Info']->value['user_xm'])&&!empty($_smarty_tpl->tpl_vars['Info']->value['user_xm'])) {?>
								<div class="one_vita_list" id="m4">
									<div class="one_vita_list_h1"><span class="one_vita_list_h1_span">项目经历</span></div>
									<i class="one_vita_list_h1_iconbg"></i>
									<i class="one_vita_list_h1_icon reaume_iconxm"></i>
									
									<div class="one_vita_list_line">
										<?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['one']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Info']->value['user_xm']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value) {
$_smarty_tpl->tpl_vars['one']->_loop = true;
?>
										<div class="one_vita_skill">
											<div class="one_vita_skill_Intention"><i class="one_vita_Intention_i one_vita_red"></i>
												<?php if ($_smarty_tpl->tpl_vars['one']->value['sdate']>0) {?><div class="one_vita_introduction_a one_vita_date"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['one']->value['sdate'],"%Y年%m月");?>
 - <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['one']->value['edate'],"%Y年%m月");?>
 </div><?php }?>
												<div class="one_vita_introduction_a one_vita_dw_name bold"><?php echo $_smarty_tpl->tpl_vars['one']->value['name'];?>
</div>
												<?php if ($_smarty_tpl->tpl_vars['one']->value['title']) {?><div class="one_vita_introduction_a one_vita_dw_zw  bold">担任：<?php echo $_smarty_tpl->tpl_vars['one']->value['title'];?>
</div><?php }?>
												<?php if ($_smarty_tpl->tpl_vars['one']->value['content']) {?><div class="vita_skill_Intention_xmms">项目描述：<?php echo $_smarty_tpl->tpl_vars['one']->value['content'];?>
 </div><?php }?>
											</div>
										</div>
										<?php } ?>
									</div>
									
								</div>
								<?php }?>
								<?php if (is_array($_smarty_tpl->tpl_vars['Info']->value['user_tra'])&&!empty($_smarty_tpl->tpl_vars['Info']->value['user_tra'])) {?>
								<div class="one_vita_list" id="m1">
									<div class="one_vita_list_h1"><span class="one_vita_list_h1_span">培训经历</span></div>
									<i class="one_vita_list_h1_iconbg"></i>
									<i class="one_vita_list_h1_icon reaume_iconpx"></i>
									<div class="one_vita_list_line">
										<?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['one']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Info']->value['user_tra']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value) {
$_smarty_tpl->tpl_vars['one']->_loop = true;
?>
										<div class="one_vita_skill">
											<div class="one_vita_skill_Intention"><i class="one_vita_Intention_i one_vita_red"></i>
												<?php if ($_smarty_tpl->tpl_vars['one']->value['sdate']>0) {?><div class="one_vita_introduction_a one_vita_date"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['one']->value['sdate'],"%Y年%m月");?>
 - <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['one']->value['edate'],"%Y年%m月");?>
 </div><?php }?>
												<div class="one_vita_introduction_a one_vita_dw_name bold"><?php echo $_smarty_tpl->tpl_vars['one']->value['name'];?>
 </div>
												<?php if ($_smarty_tpl->tpl_vars['one']->value['title']) {?><div class="one_vita_introduction_a one_vita_dw_bm bold">培训方向：<?php echo $_smarty_tpl->tpl_vars['one']->value['title'];?>
</div><?php }?>
												<?php if ($_smarty_tpl->tpl_vars['one']->value['content']) {?><div class="vita_skill_Intention_xmms">培训内容：<?php echo $_smarty_tpl->tpl_vars['one']->value['content'];?>
 </div><?php }?>
											</div>
										</div>
										<?php } ?>
									</div>
								</div>
								<?php }?>
								
								<?php if (is_array($_smarty_tpl->tpl_vars['Info']->value['user_other'])&&!empty($_smarty_tpl->tpl_vars['Info']->value['user_other'])) {?>
								<div class="one_vita_list" id="m6">
									<div class="one_vita_list_h1"><span class="one_vita_list_h1_span">其他信息</span></div>
									<i class="one_vita_list_h1_iconbg"></i>
									<i class="one_vita_list_h1_icon reaume_iconqt"></i>
									<div class="one_vita_list_line">
										<?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['one']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Info']->value['user_other']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value) {
$_smarty_tpl->tpl_vars['one']->_loop = true;
?>
										<div class="one_vita_skill">
											<div class="one_vita_skill_Intention"><i class="one_vita_Intention_i one_vita_red"></i>
												<div class="vita_skill_Intention_xmms">其他标题：<?php echo $_smarty_tpl->tpl_vars['one']->value['name'];?>
 </div>
												<?php if ($_smarty_tpl->tpl_vars['one']->value['content']) {?>
												<div class="vita_skill_Intention_xmms">其他描述：<?php echo $_smarty_tpl->tpl_vars['one']->value['content'];?>
 </div><?php }?>
											</div>
										</div>
										<?php } ?>
									</div>
								</div>
								<?php }?>
								<?php if (is_array($_smarty_tpl->tpl_vars['Info']->value['user_show'])&&!empty($_smarty_tpl->tpl_vars['Info']->value['user_show'])) {?>
									<?php if (($_smarty_tpl->tpl_vars['Info']->value['uid']==$_smarty_tpl->tpl_vars['uid']->value&&$_smarty_tpl->tpl_vars['usertype']->value==1)||$_smarty_tpl->tpl_vars['Info']->value['m_status']==1) {?>
									<div class="one_vita_list">
										<div class="one_vita_list_h1"><span class="one_vita_list_h1_span">我的作品</span></div>
										<i class="one_vita_list_h1_iconbg"></i>
										<i class="one_vita_list_h1_icon reaume_iconzp"></i>
										<div class="one_vita_list_line">
											<div class="fairs_introduction_p">
												<ul class="fairs_introduction_img" id="rolling_img1">
													<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Info']->value['user_show']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
													<li>
														<a class="image_gall" href="javascript:;">
															<img src="<?php echo $_smarty_tpl->tpl_vars['v']->value['picurl'];?>
" lay-src="<?php echo $_smarty_tpl->tpl_vars['v']->value['picurl'];?>
" />
														</a>
													</li>
													<?php } ?>
												</ul>
											</div>
										</div>
									</div>
									<?php }?>
								<?php }?> 
								

								<?php if ($_smarty_tpl->tpl_vars['Info']->value['doc']&&$_smarty_tpl->tpl_vars['Info']->value['user_doc']['doc']) {?>
								<!--粘贴简历-->
								<div class="one_vita_list">
									<div class="one_vita_list_h1"><span class="one_vita_list_h1_span">简历内容</span></div>
									<i class="one_vita_list_h1_iconbg"></i>
									<i class="one_vita_list_h1_icon reaume_iconzt"></i>
									<div class="one_vita_skill">
										<div class="one_vita_skill_Intention"><i class="one_vita_Intention_i one_vita_red"></i><?php echo $_smarty_tpl->tpl_vars['Info']->value['user_doc']['doc'];?>
 </div>
									</div>
								</div>
								<?php }?>

								<div class="one_vita_list">
									<div class="one_vita_list_h1"><span class="one_vita_list_h1_span">联系方式</span></div>
									<i class="one_vita_list_h1_iconbg"></i>
									<i class="one_vita_list_h1_icon reaume_iconlx"></i>
									<div class="one_vita_list_line" style="position:relative; min-height:200px">
										<?php if ($_smarty_tpl->tpl_vars['Info']->value['m_status']=="1") {?>
											<?php if ($_smarty_tpl->tpl_vars['Info']->value['telphone']) {?>
											<div class="one_vita_Intention"><i class="one_vita_Intention_i one_vita_red"></i>联系手机：<?php echo $_smarty_tpl->tpl_vars['Info']->value['telphone'];?>
</div>
											<?php }?>
											<?php if ($_smarty_tpl->tpl_vars['Info']->value['telhome']) {?>
											<div class="one_vita_Intention"><i class="one_vita_Intention_i one_vita_red"></i>联系座机：<?php echo $_smarty_tpl->tpl_vars['Info']->value['telhome'];?>
 </div>
											<?php }?>
											<?php if ($_smarty_tpl->tpl_vars['Info']->value['email']) {?>
											<div class="one_vita_Intention"><i class="one_vita_Intention_i one_vita_red"></i>电子邮箱：<?php echo $_smarty_tpl->tpl_vars['Info']->value['email'];?>
 </div>
											<?php }?>
											<?php if ($_smarty_tpl->tpl_vars['Info']->value['qq']) {?>
											<div class="one_vita_Intention"><i class="one_vita_Intention_i one_vita_red"></i> 联系Q Q：<?php echo $_smarty_tpl->tpl_vars['Info']->value['qq'];?>
</div>
											<?php }?>
											<?php if ($_smarty_tpl->tpl_vars['Info']->value['address']) {?>
											<div class="one_vita_Intention"><i class="one_vita_Intention_i one_vita_red"></i>详细地址：<?php echo mb_substr($_smarty_tpl->tpl_vars['Info']->value['address'],0,16,'utf-8');?>
</div>
											<?php }?>
											<?php if ($_smarty_tpl->tpl_vars['Info']->value['homepage']) {?>
		
											<div class="one_vita_Intention"><i class="one_vita_Intention_i one_vita_red"></i>个人主页：<?php echo $_smarty_tpl->tpl_vars['Info']->value['homepage'];?>
</div>
											<?php }?> 
											<?php if ($_smarty_tpl->tpl_vars['Info']->value['idcard']) {?>
											<div class="one_vita_Intention"><i class="one_vita_Intention_i one_vita_red"></i><span>身份证号：</span>
												<span class="one_vita_Identity">
												<?php echo $_smarty_tpl->tpl_vars['Info']->value['idcard'];?>

												<?php if ($_smarty_tpl->tpl_vars['Info']->value['idcard_status']==1&&$_smarty_tpl->tpl_vars['Info']->value['idcard']) {?>已认证<?php }?>
												</span> 
											</div>
											<?php }?>
											<?php if ($_smarty_tpl->tpl_vars['Info']->value['wxewm']) {?>
											<div class="" style="position:absolute;right:20px;top:20px;width:120px;"><img src="<?php echo $_smarty_tpl->tpl_vars['Info']->value['wxewm'];?>
" width="120" height="120">
												<div class="one_vita_ewm_box_p">个人二维码</div>
											</div>
											<?php }?>
										<?php } else { ?>
											<div class="re_touch"><?php echo $_smarty_tpl->tpl_vars['Info']->value['link_msg'];?>
</div>
										<?php }?>
									</div>
								</div>
							<?php } else { ?>
								<div class="one_vita_list" >
									<div class="one_vita_list_h1"><span class="one_vita_list_h1_span">个人资料</span></div>	<div class="resume_bg">
									<i class="one_vita_list_h1_iconbg"></i>
									<i class="one_vita_list_h1_icon reaume_iconjy"></i>
									<div class="one_vita_list_line">
                                    	
										<?php if ($_smarty_tpl->tpl_vars['tj']->value['education']) {?>
										<div class="yun_newedition_resume_nologin_list">
											<?php echo $_smarty_tpl->tpl_vars['tj']->value['edumin'];?>
-<?php echo $_smarty_tpl->tpl_vars['tj']->value['edumax'];?>
 已完成<?php echo $_smarty_tpl->tpl_vars['tj']->value['education'];?>
段学业
										</div>
										<?php }?>
										<?php if ($_smarty_tpl->tpl_vars['tj']->value['worknum']>0) {?>
                                         <div class="yun_newedition_resume_nologin_list">
											<?php echo $_smarty_tpl->tpl_vars['tj']->value['workmin'];?>
-<?php echo $_smarty_tpl->tpl_vars['tj']->value['workmax'];?>
 参加过<?php echo $_smarty_tpl->tpl_vars['tj']->value['worknum'];?>
份工作，平均工作时长<?php echo $_smarty_tpl->tpl_vars['tj']->value['workavg'];?>
个月，涉及<?php echo $_smarty_tpl->tpl_vars['tj']->value['worktit'];?>
等岗位
										</div>
										<?php }?>
										<?php if ($_smarty_tpl->tpl_vars['tj']->value['xmnum']>0) {?>
                                         <div class="yun_newedition_resume_nologin_list">
											<?php echo $_smarty_tpl->tpl_vars['tj']->value['xmmin'];?>
-<?php echo $_smarty_tpl->tpl_vars['tj']->value['xmmax'];?>
 独自完成或参与过<?php echo $_smarty_tpl->tpl_vars['tj']->value['xmnum'];?>
个项目，并在其中担任过<?php echo $_smarty_tpl->tpl_vars['tj']->value['xmtit'];?>
等职务
										</div>
										<?php }?>
										<?php if ($_smarty_tpl->tpl_vars['tj']->value['trainnum']>0) {?>
                                         <div class="yun_newedition_resume_nologin_list">
											<?php echo $_smarty_tpl->tpl_vars['tj']->value['trainmin'];?>
-<?php echo $_smarty_tpl->tpl_vars['tj']->value['trainmax'];?>
 参加过<?php echo $_smarty_tpl->tpl_vars['tj']->value['trainnum'];?>
次培训，进行自我充电，能力提升
										</div>
										<?php }?>
										<?php if ($_smarty_tpl->tpl_vars['tj']->value['skillnum']>0) {?>
										<div class="yun_newedition_resume_nologin_list">
											目前已掌握<?php echo $_smarty_tpl->tpl_vars['tj']->value['skillnum'];?>
项技能，其中<?php echo $_smarty_tpl->tpl_vars['tj']->value['skillpic'];?>
项拥有技能证书
										</div>
										<?php }?>
										<?php if ($_smarty_tpl->tpl_vars['tj']->value['shownum']>0) {?>
										 <div class="yun_newedition_resume_nologin_list">
											已上传<?php echo $_smarty_tpl->tpl_vars['tj']->value['shownum'];?>
份作品案例给招聘企业提前预览
										</div>
										<?php }?>
										<div class="yun_newedition_resume_nologin_tip">
											<?php echo $_smarty_tpl->tpl_vars['Info']->value['link_res'];?>

										 </div>
									</div>
								</div>	</div>	
							<?php }?>
						</div>
					</div>
				</div>
				<!-- 右侧操作区域 -->
				<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['temstyle']->value)."/resume/resume_right.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


			</div>
	
	<!-- 联系方式弹出框 -->
	<div style="width:450px; display:none" id='link_style_div'>
		<div class="tcktouch_box">
			<?php if ($_smarty_tpl->tpl_vars['Info']->value['m_status']==1) {?>
			<div class="tcktouch_box_username"><?php echo $_smarty_tpl->tpl_vars['Info']->value['name'];?>
</div>
			
			<div class="tcktouch_box_tip">联系我时请说是在<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
上看到的</div>
			<div class="tcktouch_box_p">手机：<span class="tcktouch_box_p_sj"><?php echo $_smarty_tpl->tpl_vars['Info']->value['telphone'];?>
</span></div>
			<?php if ($_smarty_tpl->tpl_vars['Info']->value['email']) {?> <div class="tcktouch_box_p">邮箱：<?php echo $_smarty_tpl->tpl_vars['Info']->value['email'];?>
 </div><?php }?> 
			<?php if ($_smarty_tpl->tpl_vars['Info']->value['qq']) {?><div class="tcktouch_box_p">Q Q：<?php echo $_smarty_tpl->tpl_vars['Info']->value['qq'];?>
</div> <?php }?> 
			<?php if ($_smarty_tpl->tpl_vars['Info']->value['homepage']) {?> <div class="tcktouch_box_p">主页：<?php echo $_smarty_tpl->tpl_vars['Info']->value['homepage'];?>
</div> <?php }?> 
			<?php if ($_smarty_tpl->tpl_vars['Info']->value['wxewm']) {?> <div class="tcktouch_box_ewm"><img src="<?php echo $_smarty_tpl->tpl_vars['Info']->value['wxewm'];?>
" width="100" height="100"><div class="tcktouch_box_ewm_p">个人二维码</div></div> <?php }?>
			<?php }?>
		</div>
	</div>
	<!-- 联系方式弹出框 end -->
			<!--  企业查看简历 end----------------------------------------------------------------------------------------->
			<?php if ($_GET['see']=='member') {?>
			<!--使用该模板 预览时隐藏  -->
			<div class="expext_yl_box_bth">
				<?php if (in_array($_smarty_tpl->tpl_vars['tplurl']->value['id'],$_smarty_tpl->tpl_vars['paytpls']->value)) {?>
				<a href="javascript:;" onClick="settemplate('确定使用该模板？', '<?php echo smarty_function_url(array('m'=>'ajax','c'=>'settpl','id'=>$_smarty_tpl->tpl_vars['tplurl']->value['id'],'eid'=>$_smarty_tpl->tpl_vars['Info']->value['id']),$_smarty_tpl);?>
');" class="expext_yl_box_sub">使用该模板</a>				
				<?php } else { ?>
				<a href="javascript:void(0);" onClick="settemplate('购买模版将花费<?php echo $_smarty_tpl->tpl_vars['tplurl']->value['price'];
echo $_smarty_tpl->tpl_vars['config']->value['integral_priceunit'];
echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
，是否继续？', '<?php echo smarty_function_url(array('m'=>'ajax','c'=>'pay','id'=>$_smarty_tpl->tpl_vars['tplurl']->value['id'],'eid'=>$_smarty_tpl->tpl_vars['Info']->value['id']),$_smarty_tpl);?>
');" class="expext_yl_box_sub">购买并使用该模板</a>
				<?php }?>
				<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/resume/index.php?c=show&id=<?php echo $_smarty_tpl->tpl_vars['eid']->value;?>
&tmp=<?php echo $_smarty_tpl->tpl_vars['tplurl']->value['id'];?>
" target="_blank" class="expext_yl_box_sub">预览</a>
			</div>
			<?php }?> 
			
			<!--footer-->
			<div class="clear"></div>
			<?php if ($_GET['see']!='member') {?>
			<div class="yun_resume_foot noprint">
				<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
</a> &copy; 版权所有 <?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
 本网招聘及简历信息等 ,未经书面授权不得转载 <br />
				<div id="uclogin" class="none"></div>
			</div>
			<?php }?>
			<div id="uclogin" class="none"></div>
			<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
			<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
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
 src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/js/resume.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
			<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/js/pay.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
			<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/js/ScrollPic.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
			<?php echo '<script'; ?>
 src='<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/datetimepicker/jquery.datetimepicker.full.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
'><?php echo '</script'; ?>
> 
			<?php echo '<script'; ?>
>
				layui.use(['form', 'layer'], function() {
					var $ = layui.$,
						form = layui.form,
						layer = layui.layer;
					layer.photos({
						photos: '#rolling_img1',
						anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
					});
					layer.photos({
					  photos: '#skill_photos',
					  anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
					}); 
				});
				var integral_pricename = '<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
';
				var isHeight = "<?php echo $_smarty_tpl->tpl_vars['Info']->value['height_status'];?>
";

				<!--//--><![CDATA[//><!--
				var li_num = $("#rolling_img1 li").length;
				if(li_num > 3) { //如果图片数量不足，就不执行切换
					var scrollPic_02 = new ScrollPic();
					scrollPic_02.scrollContId = "rolling_img1"; //内容容器ID
					scrollPic_02.arrLeftId = "LeftArr"; //左箭头ID
					scrollPic_02.arrRightId = "RightArr"; //右箭头ID
					scrollPic_02.frameWidth = 640; //显示框宽度
					scrollPic_02.pageWidth = 225; //翻页宽度
					scrollPic_02.speed = 10; //移动速度(单位毫秒，越小越快)
					scrollPic_02.space = 10; //每次移动像素(单位px，越大越快)
					scrollPic_02.autoPlay = true; //自动播放
					scrollPic_02.autoPlayTime = 2; //自动播放间隔时间(秒)
					scrollPic_02.initialize(); //初始化
				}
				//--><!]]>
			<?php echo '</script'; ?>
>
			<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
			<!--[if IE 6]>
				<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/png.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
				<?php echo '<script'; ?>
>
				DD_belatedPNG.fix('.png,.one_vita_Basic_photo_bg');
				<?php echo '</script'; ?>
>
			<![endif]-->
			<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/public_search/public_tips.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

			<?php if (!$_GET['see']) {?> 
			<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['temstyle']->value)."/chat/webim.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

			<?php }?> 
			<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['temstyle']->value)."/resume/resume_include.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

			<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/public_search/login.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	</body>

</html><?php }} ?>
