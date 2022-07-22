<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-06 16:20:18
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_right.htm" */ ?>
<?php /*%%SmartyHeaderCode:1446862c545c2b6d114-01616235%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1afc66e4bcddfe5d0cde4d61548682ff77bfa9b7' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_right.htm',
      1 => 1645285932,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1446862c545c2b6d114-01616235',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'index_lookstatistc' => 0,
    'dirname' => 0,
    'mruser' => 0,
    'power' => 0,
    'soft' => 0,
    'kongjian' => 0,
    'banben' => 0,
    'phpbanben' => 0,
    'yonghu' => 0,
    'server' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c545c2bf7615_49753784',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c545c2bf7615_49753784')) {function content_62c545c2bf7615_49753784($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	
	<link href="images/reset.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" /> 
	
	<?php echo '<script'; ?>
 src="../js/jquery-1.8.0.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="js/admin_public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
> 
	
	<title>后台管理</title>
	
	<?php echo '<script'; ?>
> 
		/*屏蔽所有的js错误*/ 
		function killerrors() {return true;}
		window.onerror = killerrors;
		function logout(){
			if (confirm("您确定要退出控制面板吗？"))
			top.location = 'index.php?c=logout';
			return false;
		}
		var integral_pricename='<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
';  
	<?php echo '</script'; ?>
>
	
	<!--[if IE 6]>
	<?php echo '<script'; ?>
 src="./js/png.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
>
	  DD_belatedPNG.fix('.png,.header .logo,.header .nav li a,.header .nav li.on,.left_menu h3 span.on');
	<?php echo '</script'; ?>
>
	<![endif]-->
	
</head>
<?php if ($_smarty_tpl->tpl_vars['index_lookstatistc']->value==2) {?>
<body style="font-size:14px; padding-bottom:0; ">
	
	<div id="yunshengji"></div>
	
	<div class="clear"></div>
	
	<?php if (($_smarty_tpl->tpl_vars['dirname']->value||$_smarty_tpl->tpl_vars['mruser']->value==1)&&in_array('161',$_smarty_tpl->tpl_vars['power']->value)) {?>
		<div class="admin_indextip">
			<?php if ($_smarty_tpl->tpl_vars['dirname']->value) {?>为了您的网站安全考虑，强烈建议将 admin,install 文件夹名改为其它名称！<?php }?> 
			<?php if ($_smarty_tpl->tpl_vars['mruser']->value==1) {?>您还没有更改默认的管理员用户名和密码!<a href="index.php?m=admin_user&c=pass" class="admin_index_info_box_a">【马上修改】</a><?php }?>
		</div>
	<?php }?>
	 
	
	<div class="adminR_profit">
		<div class="adminR_profit_r">
			<div class="adminR_profit_r_box">
				<div class="adminR_profit_r_todayuser">
					<div class="adminR_profit_r_todayuser_name">今日新增会员总数</div>
					<div class="adminR_profit_r_todayuser_n" id="ajax_new_member_num">0</div>
				</div>
				<div class="adminR_profit_r_todaymoney">				
					<div class="adminR_profit_r_todayuser_name">今日总收益</div>
					<?php if (!in_array('161',$_smarty_tpl->tpl_vars['power']->value)) {?>
						<div class="admin_index_today_sy_tip">您的权限未能查看，请联系管理员开通财务权限。</div>
					<?php } else { ?>
					<div class="adminR_profit_r_todayuser_n" id="ajax_money_total">0</div>
					<?php }?>
				</div>
*			</div>
		</div>
		
		<div class="adminR_profit_m">
			<div class="adminR_profit_m_box">
				<div class="adminR_profit_m_todayqy">
					<div class="adminR_profit_tit"><i class="adminR_profit_todayqy_i3 adminR_profit_todayqy_i"></i>今日新增企业</div>
					<div class="adminR_profit_m_con">
						<div class="d_con">
							<div class="d_con_c_box">
								<i class="adminR_profit_m_con_i1"></i>
								<div class="d_con_c">
									<div class="nub" id='ajax_new_company_num'>0</div>
									<a href="index.php?m=admin_company&adtime=1" class="name">新增企业会员</a>
								</div>
							</div>
						</div>
						<div class="d_con">
							<div class="d_con_c_box">
								<i class="adminR_profit_m_con_i2"></i>
								<div class="d_con_c">
									<div class="nub" id="ajax_new_job_num">0</div>
									<a href="index.php?m=admin_company_job&adtime=1" class="name">新增职位</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="adminR_profit_m_todayqy" style="margin-top: 15px;">
				<div class="adminR_profit_tit"><i class="adminR_profit_todauser_i5 adminR_profit_todauser_i"></i>今日新增人才</div>
				<div class="adminR_profit_m_con">
					<div class="d_con">
						<div class="d_con_c_box">
							<i class="adminR_profit_m_con_i3"></i>
							<div class="d_con_c">
								<div class="nub" id="ajax_new_user_num">0</div>
								<a href="index.php?m=user_member&adtime=1" class="name">新增个人会员</a>
							</div>
						</div>
					</div>
					<div class="d_con">
						<div class="d_con_c_box">
							<i class="adminR_profit_m_con_i4"></i>
							<div class="d_con_c">
								<div class="nub" id="ajax_new_resume_num">0</div>
								<a href="index.php?m=admin_resume&adtime=1" class="name">新增个人简历</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			</div>
		</div>
		
		<div class="adminR_profit_l">
			<div class="adminR_profit_l_box">
				<div class="adminR_profit_tit"><i class="adminR_profit_qk_i adminR_profit_qk_i"></i>今日收益情况</div>
				<div class="adminR_profit_l_con">
				<div class="d_con">
					<div class="d_con_box">
						<i class="adminR_profit_l_i1"></i>
						<div class="nub" id="ajax_money_vip">￥0.00</div>
						<a href="index.php?m=company_order&typedd=1&order_state=2&time=1" class="name">会员套餐</a>
					</div>
				</div>
				<div class="d_con">
					<div class="d_con_box">
						<i class="adminR_profit_l_i2"></i>
						<div class="nub" id="ajax_money_service">￥0.00</div>
						<a href="index.php?m=company_order&typedd=5&order_state=2&time=1" class="name">增值服务</a>
					</div>
				</div>
				<div class="d_con">
					<div class="d_con_box">
						<i class="adminR_profit_l_i3"></i>
						<div class="nub" id="ajax_money_integral">￥0.00</div>
						<a href="index.php?m=company_order&order_state=2&time=1" class="name">其他服务</a>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
	
	<div class="clear"></div>

	<div class="adminR_tj">
		<div class="adminR_tj_Data_cont" style=" position:relative">
		    <div class="admin_index_Data_cont_box">
				
				<div class="adminR_profit_tit"><i class="adminR_profit_todayqy_i adminR_profit_todayqy_i4"></i>月数据统计</div>
		        
		        <div class="admin_index_date_list">
		            <ul style="width: 100.1%;">
		         		<li class="admin_index_tj_gr admin_index_date_list_cur"><a href="javascript:clicktb('getweb');"><div class="admin_tj_n"><span class="ajax_user">0</span></div>个人注册统计</a><i class="tj_line"></i></li>
		                <li class="admin_index_tj_jl"><a href="javascript:clicktb('resumetj');"><div class="admin_tj_n"><span class="ajax_resume">0</span></div>简历统计</a><i class="tj_line"></i></li>
		              	<li class="admin_index_tj_qy"><a href="javascript:clicktb('comtj');"><div class="admin_tj_n"><span class="ajax_company">0</span></div>企业注册统计</a><i class="tj_line"></i></li>
		                <li class="admin_index_tj_zw"><a href="javascript:clicktb('jobtj');"><div class="admin_tj_n"><span class="ajax_job">0</span></div>职位统计</a><i class="tj_line"></i></li>		                	                
		                <li class="admin_index_tj_ujob"><a href="javascript:clicktb('ujobtj');"><div class="admin_tj_n"><span class="ajax_uj">0</span></div>简历投递统计</a><i class="tj_line"></i></li>		                                
		                <li class="admin_index_tj_yqms"><a href="javascript:clicktb('yqmstj');"><div class="admin_tj_n"><span class="ajax_yqms">0</span></div>邀请面试统计</a><i class="tj_line"></i></li>
		                <li class="admin_index_tj_downresume"><a href="javascript:clicktb('downresumetj');"><div class="admin_tj_n"><span class="ajax_downresume">0</span></div>简历下载统计</a><i class="tj_line"></i></li>		                
						<?php if ($_smarty_tpl->tpl_vars['config']->value['sy_chat_open']==1) {?>
						<li class="admin_index_tj_pg"><a href="javascript:clicktb('chattj');"><div class="admin_tj_n"><span class="ajax_chat">0</span></div>聊天统计</a></li>
						<?php } else { ?>
						<li class="admin_index_tj_gg"><a href="javascript:clicktb('adtj');"><div class="admin_tj_n"><span class="ajax_gg">0</span></div>广告点击统计</a></li>
						<?php }?>
		            </ul>
		        </div>
				
				<div class="admin_index_Data_cont_left">
				    <div class="admin_index_fw" id="main22">
				        <iframe name="right" id="tbrightMain" src="index.php?m=admin_right&c=getweb" frameborder="false" scrolling="auto" style="border:none;" width="100%" height="350" allowtransparency="true"></iframe>
				    </div>
				</div>
		    </div>
		</div>
		
		
		<div class="admin_index_bgboxpd">
		
			<div class="admin_index_bgbox">
				<div class="adminR_profit_tit"><i class="adminR_profit_todayqy_i adminR_profit_todayqy_i5"></i>待处理事项</div>
				<div class="ajax_msgnum">
				<?php if (in_array('999',$_smarty_tpl->tpl_vars['power']->value)) {?>
				<div class="admin_index_dshbox">
				<a href="index.php?m=admin_message&status=1" class="admin_index_dsh_xw ajaxhandle_hide"><div class="admin_index_db_n"><span class="ajaxhandle" >0</span></div>待处理意见反馈</a>
				<a href="index.php?m=admin_userchange&status=3" class="admin_index_dsh_xw ajaxuserchange_hide"><div class="admin_index_db_n"><span class="ajaxuserchange" >0</span></div>待审核身份转换会员</a>
				<a href="index.php?m=admin_company&status=4" class="admin_index_dsh_qy ajaxcompany_hide"><div class="admin_index_db_n"><span class="ajaxcompany" >0</span></div>待审核企业会员</a>
				<a href="index.php?m=admin_company_job&state=4" class="admin_index_dsh_zw ajaxjob_hide"><div class="admin_index_db_n"><span class="ajaxjob" >0</span></div>待审核职位</a>
				<a href="index.php?m=admin_partjob&state=4" class="admin_index_dsh_jz ajaxpartjob_hide"><div class="admin_index_db_n"><span class="ajaxpartjob" >0</span></div>待审核兼职</a>
				<a href="index.php?m=productnews&status=3" class="admin_index_dsh_cp ajaxcomproduct_hide"><div class="admin_index_db_n"><span class="ajaxcomproduct" >0</span></div>待审核企业产品</a>
				<a href="index.php?m=productnews&c=comnews&status=3" class="admin_index_dsh_xw ajaxcomnews_hide"><div class="admin_index_db_n"><span class="ajaxcomnews" >0</span></div>待审核企业新闻</a>
				<a href="index.php?m=comcert&status=3" class="admin_index_dsh_rz ajaxcomcert_hide"><div class="admin_index_db_n"><span class="ajaxcomcert" >0</span></div>待审核企业资质</a>
				<a href="index.php?m=admin_company_pic&status=1" class="admin_index_dsh_logo ajaxcomlogo_hide"><div class="admin_index_db_n"><span class="ajaxcomlogo" >0</span></div>待审核企业LOGO</a>
				<a href="index.php?m=admin_company_pic&c=show&status=1" class="admin_index_dsh_logo ajaxcomshow_hide"><div class="admin_index_db_n"><span class="ajaxcomshow" >0</span></div>待审核企业环境</a>
				<a href="index.php?m=admin_company_pic&c=banner&status=1" class="admin_index_dsh_logo ajaxcombanner_hide"><div class="admin_index_db_n"><span class="ajaxcombanner" >0</span></div>待审核企业横幅</a>
				<a href="index.php?m=user_member&status=4" class="admin_index_dsh_user ajaxuser_hide"><div class="admin_index_db_n"><span class="ajaxuser" >0</span></div>待审核个人会员</a>
				<a href="index.php?m=admin_resume&status=4" class="admin_index_dsh_jl ajaxresume_hide"><div class="admin_index_db_n"><span class="ajaxresume" >0</span></div>待审核简历</a>
				<a href="index.php?m=usercert&status=2" class="admin_index_dsh_rz ajaxusercert_hide"><div class="admin_index_db_n"><span class="ajaxusercert" >0</span></div>待审核个人认证</a>
				<a href="index.php?m=admin_trust&status=3" class="admin_index_dsh_wt ajaxresumetrust_hide"><div class="admin_index_db_n"><span class="ajaxresumetrust" >0</span></div>待审核委托简历</a>
				<a href="index.php?m=admin_user_pic&status=1" class="admin_index_dsh ajaxuserpic_hide"><div class="admin_index_db_n"><span class="ajaxuserpic" >0</span></div>待审核个人头像</a>
				<a href="index.php?m=admin_user_pic&c=show&status=1" class="admin_index_dsh ajaxusershow_hide"><div class="admin_index_db_n"><span class="ajaxusershow" >0</span></div>待审核个人作品</a>
				<a href="index.php?m=admin_lt_member&status=4" class="admin_index_dsh_lt ajaxlt_hide"><div class="admin_index_db_n"><span class="ajaxlt" >0</span></div>待审核猎头会员</a>
				<a href="index.php?m=admin_lt_job&status=4" class="admin_index_dsh_ltzw ajaxltjob_hide"><div class="admin_index_db_n"><span class="ajaxltjob" >0</span></div>待审核猎头职位</a>
				<a href="index.php?m=height_user&status=1" class="admin_index_dsh_gjrc ajaxheightuser_hide"><div class="admin_index_db_n"><span class="ajaxheightuser" >0</span></div>待审核优质人才简历</a>
				<a href="index.php?m=admin_lt_cert&status=0" class="admin_index_dsh_rz ajaxltcert_hide"><div class="admin_index_db_n"><span class="ajaxltcert" >0</span></div>待审核猎头认证</a>
				<a href="index.php?m=admin_lt_pic&status=1" class="admin_index_dsh_rz ajaxltlogo_hide"><div class="admin_index_db_n"><span class="ajaxltlogo" >0</span></div>待审核猎头LOGO</a>
				<a href="index.php?m=train_member&status=4" class="admin_index_dsh_px ajaxtrain_hide"><div class="admin_index_db_n"><span class="ajaxtrain" >0</span></div>待审核培训会员</a>
				<a href="index.php?m=teacher&status=3" class="admin_index_dsh_pxs ajaxteacher_hide"><div class="admin_index_db_n"><span class="ajaxteacher" >0</span></div>待审核培训师</a>
				<a href="index.php?m=admin_subject&status=3" class="admin_index_dsh_pxkc ajaxsubject_hide"><div class="admin_index_db_n"><span class="ajaxsubject" >0</span></div>待审核培训课程</a>
				<a href="index.php?m=traincert&status=3" class="admin_index_dsh_rz ajaxtraincert_hide"><div class="admin_index_db_n"><span class="ajaxtraincert" >0</span></div>待审核培训认证</a>
				<a href="index.php?m=trainnews&status=3" class="admin_index_dsh_xw ajaxtrainnews_hide"><div class="admin_index_db_n"><span class="ajaxtrainnews" >0</span></div>待审核培训新闻</a>
				<a href="index.php?m=admin_px_pic&status=1" class="admin_index_dsh_xw ajaxtrainlogo_hide"><div class="admin_index_db_n"><span class="ajaxtrainlogo" >0</span></div>待审核培训LOGO</a>
				<a href="index.php?m=admin_px_pic&c=show&status=1" class="admin_index_dsh_xw ajaxtrainbanner_hide"><div class="admin_index_db_n"><span class="ajaxtrainshow" >0</span></div>待审核培训环境</a>
				<a href="index.php?m=admin_px_pic&c=banner&status=1" class="admin_index_dsh_xw ajaxtrainbanner_hide"><div class="admin_index_db_n"><span class="ajaxtrainbanner" >0</span></div>待审核培训横幅</a>
				<a href="index.php?m=admin_once&status=3" class="admin_index_dsh_dp ajaxonce_hide"><div class="admin_index_db_n"><span class="ajaxonce" >0</span></div>待审核店铺招聘</a>
				<a href="index.php?m=admin_tiny&status=2" class="admin_index_dsh_pg ajaxtiny_hide"><div class="admin_index_db_n"><span class="ajaxtiny" >0</span></div>待审核普工简历</a>
				<a href="index.php?m=admin_school_graduate&state=4" class="admin_index_dsh_yjs ajaxschoolgraduate_hide"><div class="admin_index_db_n"><span class="ajaxschoolgraduate" >0</span></div>待审核应届毕业生职位</a>
				<a href="index.php?m=admin_school_xjh&status=3" class="admin_index_dsh_xjh ajaxschoolxjh_hide"><div class="admin_index_db_n"><span class="ajaxschoolxjh" >0</span></div>待审核校招宣讲会</a>
				<a href="index.php?m=zhaopinhui&c=com&status=3" class="admin_index_dsh_ch ajaxzphcom_hide"><div class="admin_index_db_n"><span class="ajaxzphcom" >0</span></div>待审核参会企业</a>
				<a href="index.php?m=admin_question&status=0" class="admin_index_dsh_wd ajaxask_hide"><div class="admin_index_db_n"><span class="ajaxask" >0</span></div>待审核问答</a>
				<a href="index.php?m=reward_list&status=-1" class="admin_index_dsh_dh ajaxredeem_hide"><div class="admin_index_db_n"><span class="ajaxredeem" >0</span></div>待审核商品兑换</a>
				<a href="index.php?m=invoice&status=0" class="admin_index_dsh_fp ajaxinvoice_hide"><div class="admin_index_db_n"><span class="ajaxinvoice" >0</span></div>待审核发票</a>
				<a href="index.php?m=company_order&order_state=1" class="admin_index_dsh_cz ajaxorder_hide"><div class="admin_index_db_n"><span class="ajaxorder" >0</span></div>待处理充值订单</a>
				<a href="index.php?m=admin_withdraw&order_state=0" class="admin_index_dsh_tx ajaxwithdraw_hide"><div class="admin_index_db_n"><span class="ajaxwithdraw" >0</span></div>待审核赏金提现</a>
				<a href="index.php?m=ad_order&status=-1" class="admin_index_dsh_gg ajaxadorder_hide"><div class="admin_index_db_n"><span class="ajaxadorder" >0</span></div>待审核广告订单</a>
				<a href="index.php?m=special" class="admin_index_dsh_qyzt ajaxspecialcom_hide"><div class="admin_index_db_n"><span class="ajaxspecialcom" >0</span></div>待审核企业专题</a>
				
				<a href="index.php?m=report" class="admin_index_dsh_jb ajaxreportjob_hide"><div class="admin_index_db_n"><span class="ajaxreportjob" >0</span></div>待处理举报职位</a>
				<a href="index.php?m=report&ut=2" class="admin_index_dsh_jb ajaxreportresume_hide"><div class="admin_index_db_n"><span class="ajaxreportresume" >0</span></div>待处理举报简历</a>
				<a href="index.php?m=report&type=1 "class="admin_index_dsh_jb ajaxreportask_hide"><div class="admin_index_db_n"><span class="ajaxreportask" >0</span></div>待处理举报问答</a>
				<a href="index.php?m=admin_appeal" class="admin_index_dsh_ss ajaxappeal_hide"><div class="admin_index_db_n"><span class="ajaxappeal" >0</span></div>待处理账号申诉</a>
				<a href="index.php?m=report&type=2" class="admin_index_dsh_ts ajaxreportgw_hide"><div class="admin_index_db_n"><span class="ajaxreportgw" >0</span></div>待处理投诉顾问</a>
				<a href="index.php?m=report&type=3" class="admin_index_dsh_jb ajaxreportxjh_hide"><div class="admin_index_db_n"><span class="ajaxreportxjh" >0</span></div>待处理举报校招宣讲会</a>
				<a href="index.php?m=admin_zphnet" class="admin_index_dsh_jb ajaxzphnetcom_hide"><div class="admin_index_db_n"><span class="ajaxzphnetcom" >0</span></div>待处理网络招聘会报名</a>
				<a href="index.php?m=link&state=2" class="admin_index_dsh_lj ajaxlink_hide"><div class="admin_index_db_n"><span class="ajaxlink" >0</span></div>待审核友情链接</a>
				<a href="index.php?m=admin_gqmember&status=4" class="admin_index_dsh_jb ajaxgq_hide"><div class="admin_index_db_n"><span class="ajaxgq" >0</span></div>待审核供求会员</a>
				<a href="index.php?m=admin_gqtask&status=3" class="admin_index_dsh_qyzt ajaxgqtask_hide"><div class="admin_index_db_n"><span class="ajaxgqtask" >0</span></div>待审核供求项目任务</a>
				<a href="index.php?m=admin_gqinfo_pic&status=1" class="admin_index_dsh_pg ajaxgqphoto_hide"><div class="admin_index_db_n"><span class="ajaxgqphoto" >0</span></div>待审核供求会员头像</a>
				
				<a href="index.php?m=admin_member_logout&status=1" class="admin_index_dsh_pg ajaxlogout_hide"><div class="admin_index_db_n"><span class="ajaxlogout" >0</span></div>待处理注销账号</a>
				<a href="index.php?m=admin_spview&status=3" class="admin_index_dsh_xw ajaxspview_hide"><div class="admin_index_db_n"><span class="ajaxspview" >0</span></div>待审核视频面试</a>
				<a href="index.php?m=com_pl&status=0" class="admin_index_dsh_xw ajaxcomment_hide"><div class="admin_index_db_n"><span class="ajaxcomment" >0</span></div>待审核面试评价</a>
				<a href="index.php?m=admin_yqmb&status=0" class="admin_index_dsh_xw ajaxyqmb_hide"><div class="admin_index_db_n"><span class="ajaxyqmb" >0</span></div>待审核面试模板</a>
				<a href="index.php?m=admin_msg&status=0" class="admin_index_dsh_xw ajaxusermsg_hide"><div class="admin_index_db_n"><span class="ajaxusermsg" >0</span></div>待审核求职咨询</a>
				<a href="index.php?m=admin_question&c=getanswer&status=0" class="admin_index_dsh_xw ajaxanswer_hide"><div class="admin_index_db_n"><span class="ajaxanswer" >0</span></div>待审核问答回复</a>
				<a href="index.php?m=admin_question&c=getcomment&status=0" class="admin_index_dsh_xw ajaxanswerreview_hide"><div class="admin_index_db_n"><span class="ajaxanswerreview" >0</span></div>待审核问答评论</a>
				<a href="index.php?m=admin_concheck_log&status=0" class="admin_index_dsh_xw ajaxconcheck_hide"><div class="admin_index_db_n"><span class="ajaxconcheck" >0</span></div>待处理内容检测</a>
			</div>
			
			<?php }?>	
		</div>
		<div class="zwtip">暂时没有待处理事项哦</div>
		
			</div>
	</div>
		
	</div>

	<div class="admin_index_center">
		<div class="admin_index_Data">
			<div class="admin_index_Data_bor">
				<div class="admin_message_h1">
					<div class="admin_message_h1_tit">
					    <span class="admin_message_h1_s admin_message_h1_cur" data-a="index_dt">网站动态</span>
					    <span class="admin_message_h1_s" data-a="index_rz">会员日志</span>
					    </div>
					</div>
					
		    		<div class="admin_index_Data_cont" style="position:relative; display:block" id="index_dt">
		   
			 			<div class="admin_index_Data_cont_rz">
			 				
			 				<div class="admin_index_Data_cont_rz_tit admin_dt1">
		         				<ul>
					                <li><a href="javascript:clicktbdt('downresumedt');" class="admin_index_Data_cont_rz_tit_li">下载简历动态</a></li>
					                <li><a href="javascript:clicktbdt('useridjobdt');">职位申请动态</a></li>
					                <li><a href="javascript:clicktbdt('lookjobdt');" >职位浏览动态</a></li>
					                <li><a href="javascript:clicktbdt('lookresumedt');" >简历浏览动态</a></li>
					                <li><a href="javascript:clicktbdt('favjobdt');" >职位收藏动态</a></li>
					                <li><a href="javascript:clicktbdt('payorderdt');" >充值动态</a></li>
					            </ul> 
		            		</div>
		      
					        <div class="admin_index_Data_cont_left">
					            <div class="" id="main22">
					                <iframe name="right" id="tbrightMaindt" src="index.php?m=admin_right&c=downresumedt" frameborder="false" scrolling="auto" style="border:none;" width="100%" height="300" allowtransparency="true"></iframe>
					            </div>
					        </div>
					
						</div>
		    		</div>
		   
					<div class="admin_index_Data_cont" style="position:relative; display:none" id="index_rz">
						<div class="admin_index_Data_cont_rz">
					   		<div class="admin_index_Data_cont_rz_tit admin_dt2">
					       		<ul>
					            	<li><a href="javascript:clicktbrz('userrz');" class="admin_index_Data_cont_rz_tit_li">个人会员日志</a></li>
					                <li><a href="javascript:clicktbrz('comrz');">企业会员日志</a></li>
					                <li><a href="javascript:clicktbrz('lietoutz');">猎头会员日志</a></li>
					                <li><a href="javascript:clicktbrz('traintz');">培训会员日志</a></li>
									<li><a href="javascript:clicktbrz('gqtz');">供求会员日志</a></li>
					            </ul>
					 		</div>
					 		
					        <div class="admin_index_Data_cont_left" >
					            <div class="" id="main22">
					                <iframe name="right" id="tbrightMainrz" src="index.php?m=admin_right&c=userrz" frameborder="false" scrolling="auto" style="border:none;" width="100%" height="300" allowtransparency="true"></iframe>
					            </div>
					        </div>
					    </div>
				    </div>
				</div>
		</div>
	</div>

	<div class="mainindex_box">
		<div class="mainindex_box_cont_c">
	 		<div class="mainindex_box_cont">
	 			
	 			
	 			<div class="mainleft">
	 				<div class="maininfo" style="margin: 0;">
	              		<div class="admin_indexdt">
							<div class="mainboxtop">
								<i class="admin_index_bgbox_tit_icon"></i>
								<h6>服务信息</h6>
							</div>
							<div class="maincontent">
								<p>系统名称：6.03VIP人才招聘系统</p>
								<p>技术支持：维特网络</p>
								<p>联系电话：18668215192微信同号</p>
								<p>维特官网：<a href="http://www.weitenet.com/" target="_blank">http://www.weitenet.com/</a></p>
								<p>咨询QQ：360222653</p>
							</div>
						</div>
	      			</div>
	  			</div>                                
	 
	  			<div class="mainright">
	    			<div class="maininfo">
						<div class="admin_indexdt">
							<div class="mainboxtop">
								<i class="admin_index_bgbox_tit_icon"></i>
								<h6>更多服务</h6>
							</div>
							<div class="maincontent">
								<p>网站建设、仿站开发、服务器空间租售、网站维护</p>
								<p>网站托管、网站优化、百度推广、自媒体营销</p>
								<p>微信公众号分销商城、如有意向-联系我们</p>
								<p>联系电话：18668215192 （微信同号）</p>
								<p>咨询QQ：360222653</p>
							</div>
				        </div>
				    </div>
	  			</div> 
	  		</div> 
	 	</div>
	</div> 

	<div class="mainindex_box" style="margin-top:20px;">
		<div class="mainindex_box_cont_c">
			<div class="mainindex_box_cont">
				<div class="mainmsg">
					<div class="mainboxtop">
						<i class="admin_index_bgbox_tit_icon"></i>
						<h6>系统信息</h6>
					</div>
						
					<div class="" style="padding-left: 15px;">
						<span class="mainmsg_list">程序版本： 6.03VIP版本</span>
						<span class="mainmsg_list">服务器软件：<?php echo $_smarty_tpl->tpl_vars['soft']->value;?>
</span>
						<span class="mainmsg_list">可用空间(磁盘区)：<?php echo $_smarty_tpl->tpl_vars['kongjian']->value;?>
&nbsp;M</span>
						<span class="mainmsg_list">MySQL 版本：<?php echo $_smarty_tpl->tpl_vars['banben']->value;?>
</span>
						<span class="mainmsg_list">PHP 版本：<?php echo $_smarty_tpl->tpl_vars['phpbanben']->value;?>
</span>
						<span class="mainmsg_list">用户 - 服务器：<?php echo $_smarty_tpl->tpl_vars['yonghu']->value;?>
 - <?php echo $_smarty_tpl->tpl_vars['server']->value;?>
</span>
					</div>   
				</div>
			</div> 
		</div>
	</div>

	<input type="hidden" name="pytoken" id="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
"/>
	
	<?php echo '<script'; ?>
>
		var pytoken	=	$('#pytoken').val();
		function dk(){$("#edition_box_yun").show();$(".edition_box_bg").show();}
		function gb(){$("#edition_box_yun").hide();$(".edition_box_bg").hide();}
		function clicktb(name){
			$("#tbrightMain").attr("src","index.php?m=admin_right&c="+name);
		}
		function clicktbdt(name){
			$("#tbrightMaindt").attr("src","index.php?m=admin_right&c="+name);
		}
		function clicktbrz(name){
			$("#tbrightMainrz").attr("src","index.php?m=admin_right&c="+name);
		}
		$(document).ready(function(){
			$(".admin_message_h1_s").click(function(){
				$(".admin_message_h1_s").attr("class","admin_message_h1_s");
				$(this).attr("class","admin_message_h1_s admin_message_h1_cur");
				var a=$(this).attr("data-a");
				$(".admin_index_Data_cont").hide();
				$("#"+a).show();
			});
		})
	<?php echo '</script'; ?>
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

	<?php echo '<script'; ?>
 type="text/javascript">

		$(document).ready(function(){
			$.post("index.php?m=admin_right&c=ajax_statis", {pytoken: '<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
'}, function(data){
				var o = eval( '(' + data + ')' );
		   
				$('#ajax_new_member_num').html(o.memberNum);

				if(o.moneyTotal){
					$('#ajax_money_total').html(o.moneyTotal);
				}
				
				$('#ajax_new_company_num').html(o.companyNum);
				$('#ajax_new_job_num').html(o.jobNum);

				$('#ajax_new_user_num').html(o.userNum);
				$('#ajax_new_resume_num').html(o.resumeNum);
				
				if(o.moneyVip){
					$('#ajax_money_vip').html('￥'+o.moneyVip);
				}
				if(o.moneyService){
					$('#ajax_money_service').html('￥'+o.moneyService);
				}
				if(o.moneyIntegral){
				  $('#ajax_money_integral').html('￥'+o.moneyIntegral);
				}
				 
				if(o.resumeNumMon) {
					$('.ajax_resume').html(o.resumeNumMon);
				}
				if(o.jobNumMon) {
					$('.ajax_job').html(o.jobNumMon);
				}
				if(o.companyNumMon) {
					$('.ajax_company').html(o.companyNumMon);
				}
				if(o.userNumMon) {
					$('.ajax_user').html(o.userNumMon);
				}
				if(o.newsNumMon) {
					$('.ajax_news').html(o.newsNumMon);
				}
				if(o.userjobNumMon){
					$('.ajax_uj').html(o.userjobNumMon);
				}
				if(o.ggNumMon) {
					$('.ajax_gg').html(o.ggNumMon);
				}
				if(o.onceNumMon) {
					$('.ajax_once').html(o.onceNumMon);
				}
				if(o.yqmsNumMon){
					$('.ajax_yqms').html(o.yqmsNumMon);
				}
				if(o.downreusmeNumMon){
					$('.ajax_downresume').html(o.downreusmeNumMon);
				}
				if(o.tinyNumMon) {
					$('.ajax_tiny').html(o.tinyNumMon);
				}
				if(o.chatNumMon){
					$('.ajax_chat').html(o.chatNumMon);
				}
			});
			
			$.get("index.php?c=msgNum", function(data) {
				var datas = eval('(' + data + ')');
				if(datas.handlenum > 0){
					$('.ajaxhandle').html(datas.handlenum);
				}else{
					$('.ajaxhandle_hide').hide();
				}
				
				if(datas.msgNum > 0){
					$('.ajax_msgnum').show();
				}else{
					$('.ajax_msgnum').hide();
				}
				
				if(datas.company_job) {
					$('.ajaxjob').html(datas.company_job);
				}else{
					$('.ajaxjob_hide').hide();
				}
				if(datas.userchangenum){
					$('.ajaxuserchange').html(datas.userchangenum);
				}else{
					$('.ajaxuserchange_hide').hide();
				}
				if(datas.company) {
					$('.ajaxcompany').html(datas.company);
				}else{
					$('.ajaxcompany_hide').hide();
				}
				
				if(datas.partjob) {
					$('.ajaxpartjob').html(datas.partjob);
				}else{
					$('.ajaxpartjob_hide').hide();
				}
				
				if(datas.company_product) {
					$('.ajaxcomproduct').html(datas.company_product);
				}else{
					$('.ajaxcomproduct_hide').hide();
				}
				
				if(datas.company_news) {
					$('.ajaxcomnews').html(datas.company_news);
				}else{
					$('.ajaxcomnews_hide').hide();
				}
				
				if(datas.company_cert) {
					$('.ajaxcomcert').html(datas.company_cert);
				}else{
					$('.ajaxcomcert_hide').hide();
				}
				
				if(datas.comlogo) {
					$('.ajaxcomlogo').html(datas.comlogo);
				}else{
					$('.ajaxcomlogo_hide').hide();
				}
				
				if(datas.comshow) {
					$('.ajaxcomshow').html(datas.comshow);
				}else{
					$('.ajaxcomshow_hide').hide();
				}
				
				if(datas.combanner) {
					$('.ajaxcombanner').html(datas.combanner);
				}else{
					$('.ajaxcombanner_hide').hide();
				}
				
				if(datas.userNum) {
					$('.ajaxuser').html(datas.userNum);
				}else{
					$('.ajaxuser_hide').hide();
				}
				
				if(datas.resume_expect) {
					$('.ajaxresume').html(datas.resume_expect);
				}else{
					$('.ajaxresume_hide').hide();
				}
				
				if(datas.usercertNum) {
					$('.ajaxusercert').html(datas.usercertNum);
				}else{
					$('.ajaxusercert_hide').hide();
				}
				
				if(datas.resumetrust) {
					$('.ajaxresumetrust').html(datas.resumetrust);
				}else{
					$('.ajaxresumetrust_hide').hide();
				}
				
				if(datas.userpic) {
					$('.ajaxuserpic').html(datas.userpic);
				}else{
					$('.ajaxuserpic_hide').hide();
				}
				
				if(datas.usershow) {
					$('.ajaxusershow').html(datas.usershow);
				}else{
					$('.ajaxusershow_hide').hide();
				}
				
				if(datas.ltNum) {
					$('.ajaxlt').html(datas.ltNum);
				}else{
					$('.ajaxlt_hide').hide();
				}
				
				if(datas.ltjob) {
					$('.ajaxltjob').html(datas.ltjob);
				}else{
					$('.ajaxltjob_hide').hide();
				}
				
				if(datas.ltheightuser) {
					$('.ajaxheightuser').html(datas.ltheightuser);
				}else{
					$('.ajaxheightuser_hide').hide();
				}
				
				if(datas.ltcert) {
					$('.ajaxltcert').html(datas.ltcert);
				}else{
					$('.ajaxltcert_hide').hide();
				}
				
				if(datas.ltlogo) {
					$('.ajaxltlogo').html(datas.ltlogo);
				}else{
					$('.ajaxltlogo_hide').hide();
				}
				
				if(datas.trainNum) {
					$('.ajaxtrain').html(datas.trainNum);
				}else{
					$('.ajaxtrain_hide').hide();
				}
				if(datas.teacher) {
					$('.ajaxteacher').html(datas.teacher);
				}else{
					$('.ajaxteacher_hide').hide();
				}
				if(datas.subject) {
					$('.ajaxsubject').html(datas.subject);
				}else{
					$('.ajaxsubject_hide').hide();
				}
				if(datas.traincert) {
					$('.ajaxtraincert').html(datas.traincert);
				}else{
					$('.ajaxtraincert_hide').hide();
				}
				if(datas.trainnews) {
					$('.ajaxtrainnews').html(datas.trainnews);
				}else{
					$('.ajaxtrainnews_hide').hide();
				}
				if(datas.pxlogo) {
					$('.ajaxtrainlogo').html(datas.pxlogo);
				}else{
					$('.ajaxtrainlogo_hide').hide();
				}
				if(datas.pxshow) {
					$('.ajaxtrainshow').html(datas.pxshow);
				}else{
					$('.ajaxtrainshow_hide').hide();
				}
				if(datas.pxbanner) {
					$('.ajaxtrainbanner').html(datas.pxbanner);
				}else{
					$('.ajaxtrainbanner_hide').hide();
				}
				if(datas.once_job) {
					$('.ajaxonce').html(datas.once_job);
				}else{
					$('.ajaxonce_hide').hide();
				}
				if(datas.tiny) {
					$('.ajaxtiny').html(datas.tiny);
				}else{
					$('.ajaxtiny_hide').hide();
				}
				if(datas.schooljob) {
					$('.ajaxschoolgraduate').html(datas.schooljob);
				}else{
					$('.ajaxschoolgraduate_hide').hide();
				}
				if(datas.schoolxjh) {
					$('.ajaxschoolxjh').html(datas.schoolxjh);
				}else{
					$('.ajaxschoolxjh_hide').hide();
				}
				if(datas.zphcom) {
					$('.ajaxzphcom').html(datas.zphcom);
				}else{
					$('.ajaxzphcom_hide').hide();
				}
				if(datas.ask) {
					$('.ajaxask').html(datas.ask);
				}else{
					$('.ajaxask_hide').hide();
				}
				if(datas.redeem) {
					$('.ajaxredeem').html(datas.redeem);
				}else{
					$('.ajaxredeem_hide').hide();
				}
				if(datas.invoiceNum) {
					$('.ajaxinvoice').html(datas.invoiceNum);
				}else{
					$('.ajaxinvoice_hide').hide();
				}
				if(datas.order) {
					$('.ajaxorder').html(datas.order);
				}else{
					$('.ajaxorder_hide').hide();
				}
				if(datas.withdrawNum) {
					$('.ajaxwithdraw').html(datas.withdrawNum);
				}else{
					$('.ajaxwithdraw_hide').hide();
				}
				if(datas.adorder) {
					$('.ajaxadorder').html(datas.adorder);
				}else{
					$('.ajaxadorder_hide').hide();
				}
				if(datas.specialcom) {
					$('.ajaxspecialcom').html(datas.specialcom);
				}else{
					$('.ajaxspecialcom_hide').hide();
				}
				if(datas.reportjob) {
					$('.ajaxreportjob').html(datas.reportjob);
				}else{
					$('.ajaxreportjob_hide').hide();
				}
				if(datas.reportresume) {
					$('.ajaxreportresume').html(datas.reportresume);
				}else{
					$('.ajaxreportresume_hide').hide();
				}
				if(datas.reportask) {
					$('.ajaxreportask').html(datas.reportask);
				}else{
					$('.ajaxreportask_hide').hide();
				}
				if(datas.reportgw) {
					$('.ajaxreportgw').html(datas.reportgw);
				}else{
					$('.ajaxreportgw_hide').hide();
				}
				if(datas.reportxjh) {
					$('.ajaxreportxjh').html(datas.reportxjh);
				}else{
					$('.ajaxreportxjh_hide').hide();
				}
				if(datas.zphnetcomtrust) {
					$('.ajaxzphnetcom').html(datas.zphnetcomtrust);
				}else{
					$('.ajaxzphnetcom_hide').hide();
				}
				
		  
				if(datas.appealnum) {
					$('.ajaxappeal').html(datas.appealnum);
				}else{
					$('.ajaxappeal_hide').hide();
				}
				if(datas.linkNum) {
					$('.ajaxlink').html(datas.linkNum);
				}else{
					$('.ajaxlink_hide').hide();
				}
				
				if(datas.gqNum) {
					$('.ajaxgq').html(datas.gqNum);
				}else{
					$('.ajaxgq_hide').hide();
				}
				if(datas.gqpic) {
					$('.ajaxgqphoto').html(datas.gqpic);
				}else{
					$('.ajaxgqphoto_hide').hide();
				}
				if(datas.gqtask) {
					$('.ajaxgqtask').html(datas.gqtask);
				}else{
					$('.ajaxgqtask_hide').hide();
				}
				if(datas.logout) {
					$('.ajaxlogout').html(datas.logout);
				}else{
					$('.ajaxlogout_hide').hide();
				}
				if(datas.spview) {
					$('.ajaxspview').html(datas.spview);
				}else{
					$('.ajaxspview_hide').hide();
				}
				if(datas.company_msg) {
					$('.ajaxcomment').html(datas.company_msg);
				}else{
					$('.ajaxcomment_hide').hide();
				}
				if(datas.yqmb_msg) {
					$('.ajaxyqmb').html(datas.yqmb_msg);
				}else{
					$('.ajaxyqmb_hide').hide();
				}
				if(datas.usermsg_msg) {
					$('.ajaxusermsg').html(datas.usermsg_msg);
				}else{
					$('.ajaxusermsg_hide').hide();
				}
				if(datas.answer_msg) {
					$('.ajaxanswer').html(datas.answer_msg);
				}else{
					$('.ajaxanswer_hide').hide();
				}
				if(datas.answerreview_msg) {
					$('.ajaxanswerreview').html(datas.answerreview_msg);
				}else{
					$('.ajaxanswerreview_hide').hide();
				}
				if(datas.concheck_msg) {
					$('.ajaxconcheck').html(datas.concheck_msg);
				}else{
					$('.ajaxconcheck_hide').hide();
				}
				
			});
		});


		$('.admin_index_date_list li').each(function(){
			$(this).click(function(){
				$('.admin_index_date_list li').removeClass("admin_index_date_list_cur")
				$(this).addClass("admin_index_date_list_cur")
			})
		})

		$('.admin_dt1 li a').each(function(){
			$(this).click(function(){
				$('.admin_dt1 li a').removeClass("admin_index_Data_cont_rz_tit_li")
				$(this).addClass("admin_index_Data_cont_rz_tit_li")
			})
		})
		$('.admin_dt2 li a').each(function(){
			$(this).click(function(){
				$('.admin_dt2 li a').removeClass("admin_index_Data_cont_rz_tit_li")
				$(this).addClass("admin_index_Data_cont_rz_tit_li")
			})
		})


	<?php echo '</script'; ?>
>
</body>
<?php } else { ?>
<body style="font-size:14px; padding-bottom:0; ">
	<div class="layui-form-item">
	 	<div class="zwtip">可点击所需栏目，开启工作哟~ </div>
		
	</div>
</body>
<?php }?>

</html><?php }} ?>
