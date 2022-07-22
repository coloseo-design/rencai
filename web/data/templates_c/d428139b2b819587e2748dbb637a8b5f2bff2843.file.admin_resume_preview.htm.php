<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:43:54
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_resume_preview.htm" */ ?>
<?php /*%%SmartyHeaderCode:1607962d903bad49294-57926971%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd428139b2b819587e2748dbb637a8b5f2bff2843' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_resume_preview.htm',
      1 => 1640333834,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1607962d903bad49294-57926971',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'style' => 0,
    'resumeinfo' => 0,
    'matching' => 0,
    'expect' => 0,
    'work' => 0,
    'work_l' => 0,
    'edu' => 0,
    'edu_l' => 0,
    'training' => 0,
    'training_l' => 0,
    'skill' => 0,
    'skill_l' => 0,
    'project' => 0,
    'project_l' => 0,
    'other' => 0,
    'other_l' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d903bae425a1_99931100',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d903bae425a1_99931100')) {function content_62d903bae425a1_99931100($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/data/plus/job.cache.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/javascript"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/data/plus/jobparent.cache.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/javascript"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src='<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/data/plus/city.cache.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
'><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/data/plus/cityparent.cache.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/javascript"><?php echo '</script'; ?>
>
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/style/newclass.public.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/css" />
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/newclass.public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/javascript"><?php echo '</script'; ?>
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
		<style type="text/css">
			
			.chat_addresume{width:100%; font-family: "microsoft yahei";}
			.chat_resumetit{ width:100%; position: relative; margin-top: 20px; padding-bottom: 20px;}
			.chat_resumetit_n{ font-weight: bold; font-size: 16px;color:#333;;}
			.chat_resume_listbox{
			    padding: 20px 20px;
			    background: #f9fbfd;
			    border-radius: 8px;
			}
			.chat_resume_list{ padding-left: 80px; position: relative; min-height: 36px; margin-top: 10px;;}
			.chat_resume_list_name{width:80px; position: absolute;left:0px;top:0px;line-height: 38px}
			.chat_resume_list .layui-form-item{ margin-bottom: 0px;;}
			.chat_user_hy{color:#999;padding:10px 0;}
			.chat_user_xz{color:#2d8cf0; font-size: 16px;}
			.chat_user_info{ font-size: 14px; padding-top: 10px;color:#666;font-family: "microsoft yahei";}
			.chat_user_p{color:#999; line-height: 25px;}
			.admin_yunnew_user_name_c{ position: relative;}

			.admin_saversume_tit{color:#333}
			.chat_addresume::-webkit-scrollbar {
				/*滚动条整体样式*/
				width: 6px;
				/*高宽分别对应横竖滚动条的尺寸*/
				height: 1px;
			}
			.chat_addresume::-webkit-scrollbar-thumb {
				/*滚动条里面小方块*/
				border-radius: 10px;	
				background: #ccc9c7;
			}
			.chat_addresume::-webkit-scrollbar-track {
				/*滚动条里面轨道*/
				border-radius: 10px;
				background: #fff;
			}
		</style>
	</head>

	<body class="body_ifm">
		<div class="infoboxp">
			<div id="leftbox" class="admin_jobleft" style="width:700px; padding-right: 30px; height: auto;">
				<div class="chat_addresume">
					<div class="addresume_box  " style="border:none;padding:0px 20px 0px 0px">
						<div id="info" class="admin_yunnew_user_show">
							<div class="admin_yunnew_user_img">
								<img src="<?php echo $_smarty_tpl->tpl_vars['resumeinfo']->value['photo'];?>
">
							</div>
							<div class="admin_yunnew_user_name_c">
								<div class="admin_yunnew_user_name"><?php echo $_smarty_tpl->tpl_vars['resumeinfo']->value['name'];?>
</div>
							</div>
							<div class="admin_yunnew_user_info">
								<?php echo $_smarty_tpl->tpl_vars['resumeinfo']->value['exp_n'];?>
经验 · <?php echo $_smarty_tpl->tpl_vars['resumeinfo']->value['edu_n'];?>
 · <?php echo $_smarty_tpl->tpl_vars['resumeinfo']->value['age'];?>
岁
							
							</div>
							<div style="padding-bottom: 10px">
								<?php if (!$_smarty_tpl->tpl_vars['matching']->value) {?>
								<?php if ($_smarty_tpl->tpl_vars['resumeinfo']->value['telphone']) {?>
								手机号：<?php echo $_smarty_tpl->tpl_vars['resumeinfo']->value['telphone'];?>

								<?php }?>
								<?php if ($_smarty_tpl->tpl_vars['resumeinfo']->value['email']) {?>
								· 邮箱：<?php echo $_smarty_tpl->tpl_vars['resumeinfo']->value['email'];?>

								<?php }?>
								<?php }?>
							</div>

							<div class="admin_yunnew_user_ah"><?php echo $_smarty_tpl->tpl_vars['resumeinfo']->value['description'];?>
</div>
						</div>
						 
						
						<div class="chat_resumetit"><span class="chat_resumetit_n">求职意向</span>
						</div>
					</div>

					<div>
						
						<div class="chat_user_info"><span class=""> <?php echo $_smarty_tpl->tpl_vars['expect']->value['name'];?>
 </span> · <span> <?php echo $_smarty_tpl->tpl_vars['expect']->value['city_classname'];?>
</span>  · <span> <?php echo $_smarty_tpl->tpl_vars['expect']->value['report_n'];?>
 </span>
						  · <span> <?php echo $_smarty_tpl->tpl_vars['expect']->value['type_n'];?>
</span>
						  · <span> <?php echo $_smarty_tpl->tpl_vars['expect']->value['jobstatus_n'];?>
</span></div>
						<div class="chat_user_hy"> <?php echo $_smarty_tpl->tpl_vars['expect']->value['hy_n'];?>
</div> 
						<span class="chat_user_xz"> <?php echo $_smarty_tpl->tpl_vars['expect']->value['salary'];?>
</span>
					</div>
			
					<?php if ($_smarty_tpl->tpl_vars['work']->value) {?>
						<div class="chat_resumetit"><span class="chat_resumetit_n">工作经历</span>  </div>
						<?php  $_smarty_tpl->tpl_vars['work_l'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['work_l']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['work']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['work_l']->key => $_smarty_tpl->tpl_vars['work_l']->value) {
$_smarty_tpl->tpl_vars['work_l']->_loop = true;
?>
						<div class="admin_saversume_list">
							<div class="admin_saversume_pd"> <i class="admin_saversume_pd_icon"></i>
								<div class="admin_saversume_tit">
									<span class="admin_saversume_tit_b"><?php echo $_smarty_tpl->tpl_vars['work_l']->value['name'];?>
</span>
									<?php if ($_smarty_tpl->tpl_vars['work_l']->value['title']) {?><span class="admin_saversume_tit_b"><?php echo $_smarty_tpl->tpl_vars['work_l']->value['title'];?>
</span><?php }?>
								</div>
								<div><?php echo $_smarty_tpl->tpl_vars['work_l']->value['sdate_n'];?>
 ~ <?php echo $_smarty_tpl->tpl_vars['work_l']->value['edate_n'];?>
</div>
								<div class="chat_user_p"><?php echo $_smarty_tpl->tpl_vars['work_l']->value['content'];?>
</div>
								<div class="admin_saversume_cz">
								</div>
							</div>
						</div>
						<?php } ?>
					<?php }?>

					<?php if ($_smarty_tpl->tpl_vars['edu']->value) {?>
						<div class="chat_resumetit"><span class="chat_resumetit_n">教育经历</span></div>
						<?php  $_smarty_tpl->tpl_vars['edu_l'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['edu_l']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['edu']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['edu_l']->key => $_smarty_tpl->tpl_vars['edu_l']->value) {
$_smarty_tpl->tpl_vars['edu_l']->_loop = true;
?>
						<div class="admin_saversume_list">
							<div class="admin_saversume_pd">
								<i class="admin_saversume_pd_icon"></i>
								<div class="admin_saversume_tit">
									<span class="admin_saversume_tit_b"><?php echo $_smarty_tpl->tpl_vars['edu_l']->value['name'];?>
</span>
								</div>
								<div><?php echo $_smarty_tpl->tpl_vars['edu_l']->value['sdate_n'];?>
 ~ <?php echo $_smarty_tpl->tpl_vars['edu_l']->value['edate_n'];?>
</div>
								<div class="chat_user_p">
									最高学历：<?php echo $_smarty_tpl->tpl_vars['edu_l']->value['education_n'];?>
 
									&nbsp;
									<?php if ($_smarty_tpl->tpl_vars['edu_l']->value['specialty']) {?>
									所学专业：<?php echo $_smarty_tpl->tpl_vars['edu_l']->value['specialty'];?>

									<?php }?>
								</div>
							</div>
							<div class="admin_saversume_cz">
							</div>
						</div>
						<?php } ?>
					<?php }?>
			
					<?php if ($_smarty_tpl->tpl_vars['training']->value) {?>
						<div class="chat_resumetit"><span class="chat_resumetit_n">培训经历</span></div>
						<?php  $_smarty_tpl->tpl_vars['training_l'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['training_l']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['training']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['training_l']->key => $_smarty_tpl->tpl_vars['training_l']->value) {
$_smarty_tpl->tpl_vars['training_l']->_loop = true;
?>
						<div class="admin_saversume_list">
							<div class="admin_saversume_pd"> <i class="admin_saversume_pd_icon"></i>
								<div class="admin_saversume_tit"><span class="admin_saversume_tit_b"><?php echo $_smarty_tpl->tpl_vars['training_l']->value['name'];?>
</span>
									<?php if ($_smarty_tpl->tpl_vars['training_l']->value['title']) {?>培训方向： <span class="admin_saversume_tit_b"><?php echo $_smarty_tpl->tpl_vars['training_l']->value['title'];?>
</span><?php }?>
								</div>
								<div><?php echo $_smarty_tpl->tpl_vars['training_l']->value['sdate_n'];?>
 ~ <?php echo $_smarty_tpl->tpl_vars['training_l']->value['edate_n'];?>
</div>
								<div class="chat_user_p"><?php echo $_smarty_tpl->tpl_vars['training_l']->value['content'];?>
</div>
								<div class="admin_saversume_cz">
								</div>
							</div>
						</div>
						<?php } ?>
					<?php }?>

					<?php if ($_smarty_tpl->tpl_vars['skill']->value) {?>
						<div class="chat_resumetit"><span class="chat_resumetit_n">职业技能</span></div>
						<?php  $_smarty_tpl->tpl_vars['skill_l'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['skill_l']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['skill']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['skill_l']->key => $_smarty_tpl->tpl_vars['skill_l']->value) {
$_smarty_tpl->tpl_vars['skill_l']->_loop = true;
?>
						<div class="admin_saversume_list">
							<div class="admin_saversume_pd"> <i class="admin_saversume_pd_icon"></i>
								<div class="admin_saversume_tit"><span class="admin_saversume_tit_b"><?php echo $_smarty_tpl->tpl_vars['skill_l']->value['name'];?>
</span>
									<?php if ($_smarty_tpl->tpl_vars['skill_l']->value['longtime']) {?>掌握时间：<span class="admin_saversume_tit_b"><?php echo $_smarty_tpl->tpl_vars['skill_l']->value['longtime'];?>
年</span><?php }?> </div>
									
								<div>
									熟练程度：<?php echo $_smarty_tpl->tpl_vars['skill_l']->value['ing_n'];?>
 
									&nbsp;
								</div>	
								<div> <?php if ($_smarty_tpl->tpl_vars['skill_l']->value['pic']) {?>
									技能证书：<img src="<?php echo $_smarty_tpl->tpl_vars['skill_l']->value['pic'];?>
" width="95" height="70">
									<?php }?></div>
								<div class="admin_saversume_cz">
								</div>
							</div>
						</div>
						<?php } ?>
					<?php }?> 

					<?php if ($_smarty_tpl->tpl_vars['project']->value) {?>
						<div class="chat_resumetit"><span class="chat_resumetit_n">项目经历</span></div>
						<?php  $_smarty_tpl->tpl_vars['project_l'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['project_l']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['project']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['project_l']->key => $_smarty_tpl->tpl_vars['project_l']->value) {
$_smarty_tpl->tpl_vars['project_l']->_loop = true;
?>
						<div class="admin_saversume_list">
							<div class="admin_saversume_pd"> <i class="admin_saversume_pd_icon"></i>
								<div class="admin_saversume_tit">
									<span class="admin_saversume_tit_b"><?php echo $_smarty_tpl->tpl_vars['project_l']->value['name'];?>
</span>
									<?php if ($_smarty_tpl->tpl_vars['project_l']->value['title']) {?><span class="admin_saversume_tit_b"><?php echo $_smarty_tpl->tpl_vars['project_l']->value['title'];?>
</span><?php }?>
								</div>
								<div><?php echo $_smarty_tpl->tpl_vars['project_l']->value['sdate_n'];?>
 ~ <?php echo $_smarty_tpl->tpl_vars['project_l']->value['edate_n'];?>

								</div>
								<div class="chat_user_p"><?php echo $_smarty_tpl->tpl_vars['project_l']->value['content'];?>
</div>
								<div class="admin_saversume_cz">
								</div>
							</div>
						</div>
						<?php } ?>
					<?php }?> 
					
					<?php if ($_smarty_tpl->tpl_vars['other']->value) {?>
						<div class="chat_resumetit"><span class="chat_resumetit_n">其他描述</span></div>
						<?php  $_smarty_tpl->tpl_vars['other_l'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['other_l']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['other']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['other_l']->key => $_smarty_tpl->tpl_vars['other_l']->value) {
$_smarty_tpl->tpl_vars['other_l']->_loop = true;
?>
						<div class="admin_saversume_list">
							<div class="admin_saversume_pd"> 
								<i class="admin_saversume_pd_icon"></i>
								<div class="admin_saversume_tit">
									<span class="admin_saversume_tit_b"><?php echo $_smarty_tpl->tpl_vars['other_l']->value['name'];?>
</span>
								</div>
								<div class="chat_user_p"><?php echo $_smarty_tpl->tpl_vars['other_l']->value['content'];?>
</div>
								<div class="admin_saversume_cz">
								</div>
							</div>
						</div>
						<?php } ?>
					<?php }?> 
				</div>
			</div>
		</div>
	</body>
</html>
<?php }} ?>
