<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-06 16:20:21
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\default\ajax\login.htm" */ ?>
<?php /*%%SmartyHeaderCode:122362c545c58d1264-38059229%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '51c541b7c913fe9109fb9b71439aadda6305b797' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\default\\ajax\\login.htm',
      1 => 1643012866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '122362c545c58d1264-38059229',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'usertype' => 0,
    'member' => 0,
    'config' => 0,
    'username' => 0,
    'yqnum' => 0,
    'lookNum' => 0,
    'expectnum' => 0,
    'company' => 0,
    'addjobnum' => 0,
    'lt' => 0,
    'reg_com_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c545c5a33f58_51445920',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c545c5a33f58_51445920')) {function content_62c545c5a33f58_51445920($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.url.php';
?><?php if ($_smarty_tpl->tpl_vars['usertype']->value=="1") {?>  
<div class="login_ok">
	<div class="login_ok_user">
		<div class="login_ok_user_photo"><img width="60" height="60" src="<?php echo $_smarty_tpl->tpl_vars['member']->value['photo'];?>
" onerror="showImgDelay(this,'<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_member_icon'];?>
',2);"> </div>
		<?php if ($_smarty_tpl->tpl_vars['member']->value['name']) {?>
		<div class="login_ok_username">hi , <?php echo $_smarty_tpl->tpl_vars['member']->value['name'];?>
</div>
		<?php } else { ?>
		<div class="login_ok_username">hi , <?php echo $_smarty_tpl->tpl_vars['username']->value;?>
</div>
		<?php }?>
		<div class="login_ok_hi">欢迎回来</div>
	</div>
	<div class="login_ok_n_list"><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php?c=invite"><span class="login_ok_n"><?php if ($_smarty_tpl->tpl_vars['yqnum']->value=='') {?>0<?php } else {
echo $_smarty_tpl->tpl_vars['yqnum']->value;
}?></span><div class="login_ok_name">面试通知</div></a></div>
	<div class="login_ok_n_list"><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php?c=favorite"><span class="login_ok_n"><?php if ($_smarty_tpl->tpl_vars['member']->value['fav_jobnum']<1) {?>0<?php } else {
echo $_smarty_tpl->tpl_vars['member']->value['fav_jobnum'];
}?></span><div class="login_ok_name">收藏记录</div></a></div>
	<div class="login_ok_n_list"><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php?c=look"><span class="login_ok_n"><?php echo $_smarty_tpl->tpl_vars['lookNum']->value;?>
 </span><div class="login_ok_name">企业看过</div></a></div>
	<div class="login_ok_mune"><div class="login_ok_mune_list"><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php?c=resume"><i class="login_ok_mune_icon"></i>我的简历</a></div><div class="login_ok_mune_list"><a <?php if ($_smarty_tpl->tpl_vars['config']->value['user_number']>$_smarty_tpl->tpl_vars['expectnum']->value||$_smarty_tpl->tpl_vars['config']->value['user_number']=='') {?>href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php?c=expect&act=add"<?php } else { ?>href="javascript:void(0)" onclick="layer.msg('你的简历数已经达到系统设置的简历数了',2,8);return false;"<?php }?>><i class="login_ok_mune_icon login_ok_mune_icon_cj"></i>创建简历</a></div><div class="login_ok_mune_list"><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php?c=atn"><i class="login_ok_mune_icon login_ok_mune_icon_gz"></i>关注记录</a></div>
		<div class="login_ok_member"><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php" class="login_ok_member_bth">进入管理中心</a>
			<a href="javascript:void(0);" onclick="logout('<?php echo smarty_function_url(array('c'=>'logout'),$_smarty_tpl);?>
');" class="login_ok_member_bthtc">退出登录</a>
		</div>
	</div>
</div>

<?php } elseif ($_smarty_tpl->tpl_vars['usertype']->value=="2") {?>
<div class="login_ok">
	<div class="login_ok_user">
		<div class="login_ok_user_photo"><img width="60" height="60" src="<?php echo $_smarty_tpl->tpl_vars['company']->value['logo'];?>
"  onerror="showImgDelay(this,'<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_unit_icon'];?>
',2);"> </div>
		<?php if ($_smarty_tpl->tpl_vars['company']->value['name']) {?>
		<div class="login_ok_username">hi , <?php echo $_smarty_tpl->tpl_vars['company']->value['name'];?>
</div>
		<?php } else { ?>
		<div class="login_ok_username">hi , <?php echo $_smarty_tpl->tpl_vars['username']->value;?>
</div>
		<?php }?>
		<div class="login_ok_hi">欢迎登录</div>
	</div>
	<div class="login_ok_n_list"><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php?c=hr"><span class="login_ok_n"><?php echo $_smarty_tpl->tpl_vars['company']->value['sq_job'];?>
</span><div class="login_ok_name">收到简历</div></a></div>
	<div class="login_ok_n_list"><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php?c=msg"><span class="login_ok_n"><?php echo $_smarty_tpl->tpl_vars['company']->value['msgnum'];?>
</span><div class="login_ok_name">求职咨询</div></a></div>
	<div class="login_ok_n_list"><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php?c=look_job"><span class="login_ok_n"><?php echo $_smarty_tpl->tpl_vars['company']->value['look_jobnum'];?>
</span><div class="login_ok_name">谁看过我</div></a></div>

	<div class="login_ok_mune">
		<div class="login_ok_mune_list"><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php?c=job&w=1"><i class="login_ok_mune_icon"></i>职位管理</a></div>
		<div class="login_ok_mune_list"><a href="javascript:void(0)"  onclick="addJobIndex('<?php echo $_smarty_tpl->tpl_vars['addjobnum']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_job'];?>
','<?php echo $_smarty_tpl->tpl_vars['config']->value['com_integral_online'];?>
','<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_proportion'];?>
');return false;"><i class="login_ok_mune_icon login_ok_mune_icon_cj"></i>发布职位</a></div><div class="login_ok_mune_list"><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php?c=attention_me"><i class="login_ok_mune_icon login_ok_mune_icon_gz"></i>关注记录</a></div>
		<div class="login_ok_member">
			<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php" class="login_ok_member_bth">进入管理中心</a>
			<a href="javascript:void(0);" onclick="logout('<?php echo smarty_function_url(array('c'=>'logout'),$_smarty_tpl);?>
');" class="login_ok_member_bthtc">退出登录</a>
		</div>
	</div>
</div>

<?php } elseif ($_smarty_tpl->tpl_vars['usertype']->value=="3") {?>
<div class="login_ok">
	<div class="login_ok_user">
		<div class="login_ok_user_photo"><img width="60" height="60"  src="<?php echo $_smarty_tpl->tpl_vars['lt']->value['photo'];?>
" onerror="showImgDelay(this,'<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_lt_icon'];?>
',2);"> </div>
		<?php if ($_smarty_tpl->tpl_vars['lt']->value['realname']) {?>
		<div class="login_ok_username">hi , <?php echo $_smarty_tpl->tpl_vars['lt']->value['realname'];?>
</div>
		<?php } else { ?>
		<div class="login_ok_username">hi , <?php echo $_smarty_tpl->tpl_vars['username']->value;?>
</div>
		<?php }?>
		<div class="login_ok_hi">欢迎登录</div>
	</div>
	<div class="login_ok_n_listbox">
		<div class="login_ok_n_list"><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php?c=entrust_resume"><span class="login_ok_n"><?php echo $_smarty_tpl->tpl_vars['lt']->value['entrust'];?>
</span><div class="login_ok_name">委托简历</div></a></div>
		<div class="login_ok_n_list"><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php?c=down_resume"><span class="login_ok_n"><?php echo $_smarty_tpl->tpl_vars['lt']->value['lt_status2'];?>
</span><div class="login_ok_name">下载简历</div></a></div>
	</div>
	<div class="login_ok_mune">
		<div class="login_ok_mune_list"><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php?c=job&s=1"><i class="login_ok_mune_icon"></i>职位管理</a></div><div class="login_ok_mune_list"><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php?c=search_resume"><i class="login_ok_mune_icon login_ok_mune_icon_cj"></i>搜索简历</a></div>
		<div class="login_ok_mune_list"><a href="javascript:void(0)"  onclick="addJobIndex('<?php echo $_smarty_tpl->tpl_vars['addjobnum']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_job'];?>
','<?php echo $_smarty_tpl->tpl_vars['config']->value['com_integral_online'];?>
','<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_proportion'];?>
');return false;"><i class="login_ok_mune_icon login_ok_mune_icon_cj"></i>发布职位</a></div>
		<div class="login_ok_member">
			<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php" class="login_ok_member_bth">进入管理中心</a>
			<a href="javascript:void(0);" onclick="logout('<?php echo smarty_function_url(array('c'=>'logout'),$_smarty_tpl);?>
');" class="login_ok_member_bthtc">退出登录</a>
		</div>
	</div>
</div>

<?php } elseif ($_smarty_tpl->tpl_vars['usertype']->value=="4") {?>

<div class="login_ok">
	<div class="login_ok_user">
		<div class="login_ok_user_photo"><img width="60" height="60"  src="<?php echo $_smarty_tpl->tpl_vars['member']->value['logo'];?>
" onerror="showImgDelay(this,'<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_member_icon'];?>
',2);"> </div>
		<?php if ($_smarty_tpl->tpl_vars['member']->value['name']) {?>
		<div class="login_ok_username">hi , <?php echo $_smarty_tpl->tpl_vars['member']->value['name'];?>
</div>
		<?php } else { ?>
		<div class="login_ok_username">hi , <?php echo $_smarty_tpl->tpl_vars['username']->value;?>
</div>
		<?php }?>
		<div class="login_ok_hi">欢迎登录</div>
	</div>
	<div class="login_ok_n_listbox">
		<div class="login_ok_n_list"><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php?c=sign_up&status=2"><span class="login_ok_n"><?php echo $_smarty_tpl->tpl_vars['member']->value['baoming'];?>
</span><div class="login_ok_name">待联系</div></a></div>
		<div class="login_ok_n_list"><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php?c=message&status=1"><span class="login_ok_n"><?php echo $_smarty_tpl->tpl_vars['member']->value['zixun'];?>
</span><div class="login_ok_name">待回复</div></a></div>
	</div>
	
	<div class="login_ok_mune">
		<div class="login_ok_mune_list" style="width:32%"><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php?c=subject"><i class="login_ok_mune_icon"></i>课程管理</a></div><div class="login_ok_mune_list" style="width:32%"><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php?c=team"><i class="login_ok_mune_icon login_ok_mune_icon_cj"></i>讲师管理</a></div>
		<div class="login_ok_mune_list" style="width:32%"><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php?c=sign_up"><i class="login_ok_mune_icon login_ok_mune_icon_gz"></i>预约名单</a></div>
		<div class="login_ok_member"><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php" class="login_ok_member_bth">管理中心</a><a href="javascript:void(0);" onclick="logout('<?php echo smarty_function_url(array('c'=>'logout'),$_smarty_tpl);?>
');" class="login_ok_member_bthtc">退出登录</a></div>
	</div>
</div>
<?php } else { ?>
	
	<!--登录-->
	<div class="hp_login_tit">
	
		<input type="hidden" name="act" id="ajaxact_login" value="0"/>
		
		<ul class="login_box_h_list">
			<?php if ($_smarty_tpl->tpl_vars['config']->value['sy_msg_isopen']==1&&$_smarty_tpl->tpl_vars['config']->value['sy_msg_login']==1) {?>
			<li id="ajaxmobile_login" class="">手机登录<i></i></li>
			<?php }?>
			<li id="ajaxacount_login" class="login_box_h_list_cur"><i></i>账号登录</li>
			
		</ul>
		
		<?php if ($_smarty_tpl->tpl_vars['config']->value['wx_author']=='1') {?>
		<div class="indexwxcode_login" id="ajaxindexwxcode_login" title="微信扫一扫登录" style="display:block;"></div>
		<div class="indexnormal_login none" title="普通登录"></div>
		<?php }?>
	</div>
	
	<!--微信登录-->
	<div class="indexwx_login_show none">
		<div style="padding-top:40px;">
			<div class="fast_login_index">
			 	<div id="ajaxwx_login_qrcode" class="indexwxlogintext">正在获取二维码...</div>
				<div id="ajaxwx_sx" class="none">
					<div class="fast_login_index_sxbox"><a href="javascript:void(0);" onclick="ajaxgetwxcode()" class="fast_login_index_sxicon"></a>二维码失效点击刷新</div>
				</div>
			</div>
		 	<div class="indexwxlogintxt">请使用微信扫一扫登录</div>
		</div>
	</div>	
	<!--微信登录 end-->
	
	<!--账号登录-->
	<div id="login_normal">
		<div class="login_normal_box" id="ajaxlogin_normal_box">
			<div class="hp_login_hy"> <i class="hp_login_hy_icon fl"></i><i class="hp_login_line"></i>
			  	<input class="hp_login_hy_but fl" type="text" id="ajaxusername" name="ajaxusername" value="邮箱/手机号/用户名" placeholder="邮箱/手机号/用户名" autocomplete="off"/>
			  	<div class="index_logoin_msg none" id="ajaxshow_name">
			    	<div class="index_logoin_msg_tx">请填写用户名</div>
			    	<div class="index_logoin_msg_icon"></div>
			  	</div>
			</div>
			<div class="hp_login_hy"> 
				<i class="hp_login_mm_icon fl"></i> <i class="hp_login_line"></i>
				<input type="text" id="password2" value="请输入密码" class="hp_login_hy_but fl">
				<input type="password" id="ajaxpassword" name="ajaxpassword" class="hp_login_hy_but fl none" value="" placeholder="请输入密码">
			  	<div class="index_logoin_msg none" id="ajaxshow_pass">
			    	<div class="index_logoin_msg_tx">请填写密码</div>
			    	<div class="index_logoin_msg_icon"></div>
			  	</div>
			</div>
		</div>
		
		<div class="clear"></div>
		
		<!--手机动态码登录-->
		<?php if ($_smarty_tpl->tpl_vars['config']->value['sy_msg_isopen']==1&&$_smarty_tpl->tpl_vars['config']->value['sy_msg_login']==1) {?>
		<div class="login_sj_box none" id="ajaxlogin_sj_box">
		  	<div class="hp_login_hy">
	        	<i class="hp_login_sj_icon fl"></i><i class="hp_login_line"></i>
		  		<input name="username" id="ajaxusermoblie" type="text" class="hp_login_hy_but hp_login_mm_but" value="请输入手机号码" autocomplete="off"/>
		  		<div class="index_logoin_msg none" id="ajaxshow_mobile">
			  		<div class="index_logoin_msg_tx" >请填写正确手机号</div>
			  		<div class="index_logoin_msg_icon"></div>
			  	</div>
		  	</div>
		</div>
		<div class="clear"></div>
		<?php }?>
		
		
		
		<div class="clear"></div>
		<div class="login_sj_box none" id="ajaxlogin_sjyz_box">
			<div class="hp_login_hy">
	         	<i class="hp_login_mm_icon fl"></i><i class="hp_login_line"></i>
		  		<input name="password" type="text" class="login_m_text" id="ajaxdynamiccode" value="短信动态码" autocomplete="off"/>
		  		<div class="index_logoin_msg none" id="ajaxshow_dynamiccode">
			  		<div class="index_logoin_msg_tx" >请填写短信动态码</div>
			  		<div class="index_logoin_msg_icon"></div>
			  	</div>
			  	<?php if ($_smarty_tpl->tpl_vars['config']->value['code_kind']==1&&strpos($_smarty_tpl->tpl_vars['config']->value['code_web'],"前台登录")!==false) {?>
			  	<a href="javascript:void(0);" class=" hp_login_hy_send" id="ajaxsend_msg_tip" onclick="imgCodeShow('2');">发送动态码</a>
			  	<?php } else { ?>
			  	<a href="javascript:void(0);" class=" hp_login_hy_send" id="ajaxsend_msg_tip" onclick="ajaxsend_msg('<?php echo smarty_function_url(array('m'=>'login','c'=>'sendmsg'),$_smarty_tpl);?>
');">发送动态码</a>
			  	<?php }?>
		  	</div>
		</div>
		<div class="hp_login_lg">
			<?php if ($_smarty_tpl->tpl_vars['config']->value['code_kind']==1&&strpos($_smarty_tpl->tpl_vars['config']->value['code_web'],"前台登录")!==false) {?>
		  		<input class="hp_login_lg_but" type="button" value="立即登录" onclick="imgCodeShow('1');"/>
		  	<?php } else { ?>
		  		<input class="hp_login_lg_but" type="button" id="check_ajaxlogin" value="立即登录" onclick="check_ajaxlogin('<?php echo smarty_function_url(array('m'=>'login','c'=>'loginsave'),$_smarty_tpl);?>
','vcode_imgs');"/>
		  	<?php }?>
		</div>
		<div class="clear"></div>
		<div class="hp_login_rg fl"> 
		
	   		
	    	<a href="<?php echo smarty_function_url(array('m'=>'forgetpw'),$_smarty_tpl);?>
" class="hp_login_rg_r fl">忘记密码</a>
			<span class="hp_login_rg_l fr"  ><a href="<?php echo $_smarty_tpl->tpl_vars['reg_com_url']->value;?>
">注册账号</a></span>
		</div>	
		
		<?php if ($_smarty_tpl->tpl_vars['config']->value['sy_qqlogin']==1||$_smarty_tpl->tpl_vars['config']->value['sy_sinalogin']==1||$_smarty_tpl->tpl_vars['config']->value['wx_author']==1) {?>
		 
			<?php if ($_smarty_tpl->tpl_vars['config']->value['sy_qqlogin']==1) {?>
				<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/qqlogin.php" class="frist_loginqq">QQ登录</a>
			<?php }?> 
			<?php if ($_smarty_tpl->tpl_vars['config']->value['sy_sinalogin']==1) {?>
				<a href="<?php echo smarty_function_url(array('m'=>'sinaconnect'),$_smarty_tpl);?>
" class=" frist_loginsl">新浪登录</a>
			<?php }?> 
		<?php }?>
	
	</div>
	
<?php }?>
 
<style>#label{height:34px; line-height:34px;border:1px solid #e6e6e6}</style>


<!-- -----------------图片验证码弹框  Start-------------------- -->
<div class="" id="imgCodeDiv" style="display:none;">
<div style="width:300px; padding-top:10px; padding-bottom:30px;">
	<div class="tw_yz_box">请输入图片验证码</div>
	<div class="tw_yz_c">
		<div class="tw_yz_boxtext"><input type="text" id="ajaxtxt_CheckCode" name="authcode" value="验证码" class="tw_yz_boxinp" maxlength="6" autocomplete="off"/></div>
		<div class="tw_yz_boximg"><a href="javascript:void(0);" onclick="checkCode('vcode_imgs');"><img id="vcode_imgs" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/app/include/authcode.inc.php" class=""> 换一张</a></div>
		<div class="index_logoin_msg none" id="ajaxshow_code">
			<div class="index_logoin_msg_tx">请填写验证码</div>
			<div class="index_logoin_msg_icon"></div>
	  	</div>
	  	<div id="btnDiv"></div> 		
	</div>
</div>
</div>
<!-- -----------------图片验证码弹框  End-------------------- -->

<?php echo '<script'; ?>
>
var ajaxsetval,
	ajaxsetwout;
var sy_login_type = '<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_login_type'];?>
';
$(document).ready(function(){
	//账号登录和手机登录tab选择
	$('#ajaxacount_login').click(function(data){
		$('#ajaxacount_login').removeClass().addClass('login_box_h_list_cur');
		$('#ajaxmobile_login').removeClass();
		$('#ajaxlogin_normal_box').show();
		$('#ajaxlogin_sj_box').hide();
		$('#ajaxlogin_sjyz_box').hide();
		$('#ajaxact_login').val('0');
		$('#bind-captcha').attr('data-id','sublogin');
	});
	$('#ajaxmobile_login').click(function(data){
		$('#ajaxmobile_login').removeClass().addClass('login_box_h_list_cur');
		$('#ajaxacount_login').removeClass();
		$('#ajaxlogin_sj_box').show();
		$('#ajaxlogin_sjyz_box').show();
		$('#ajaxlogin_normal_box').hide();
		$('#ajaxact_login').val('1');
		$('#bind-captcha').attr('data-id','ajaxsend_msg_tip');
	});
	$("#ajaxusername,#ajaxtxt_CheckCode,#ajaxusermoblie,#ajaxdynamiccode").focus(function(){
		var txAreaVal = $(this).val();
		if( txAreaVal == this.defaultValue){$(this).val("");}
	}).blur(function(){
		var txAreaVal = $(this).val();
		if( txAreaVal == this.defaultValue||$(this).val()==""){$(this).val(this.defaultValue);}
	}).keydown(function (e) {
	    var ev = document.all ? window.event : e;
	    if (ev.keyCode == 13) {
	        check_ajaxlogin('<?php echo smarty_function_url(array('m'=>'login','c'=>'loginsave'),$_smarty_tpl);?>
','vcode_imgs');
	    } else { return;}
	});
	$("#password2").focus(function(){
		$("#ajaxpassword").show();
		$("#ajaxpassword").focus();
		$("#password2").hide();
	})
	$("#ajaxpassword").blur(function(){
		if($("#ajaxpassword").val()==""){
			$("#password2").show();
			$("#ajaxpassword").hide();
		}
	}).keydown(function (e) {
	    var ev = document.all ? window.event : e;
	    if (ev.keyCode == 13) {
	        check_ajaxlogin('<?php echo smarty_function_url(array('m'=>'login','c'=>'loginsave'),$_smarty_tpl);?>
','vcode_imgs');
	    } else { return; }
	});
	
    $('#ajaxindexwxcode_login').click(function(data){
		$('#ajaxindexwxcode_login').hide();
		$('.indexnormal_login').show();
		$('#login_normal').hide();
		$('.login_box_h_list').hide();
		$('.indexwx_login_show').show();
		ajaxgetwxcode();
	});
	$('.indexnormal_login').click(function(data){
		$('#ajaxindexwxcode_login').show();
		$('.indexnormal_login').hide();
		$('#login_normal').show();
		$('.login_box_h_list').show();
		$('.indexwx_login_show').hide();
		if(ajaxsetval){
			clearInterval(ajaxsetval);
			ajaxsetval = null;
		}
		if(ajaxsetwout){
			clearTimeout(ajaxsetwout);
			ajaxsetwout = null;
		}
	});

	if(sy_login_type=='2' && $('#ajaxmobile_login')){
        $('#ajaxmobile_login').trigger("click");
    }
});
function ajaxgetwxcode(){
	$.post('<?php echo smarty_function_url(array('m'=>'login','c'=>'wxlogin'),$_smarty_tpl);?>
',{t:1},function(data){
		if(data==0){
			$('#ajaxwx_login_qrcode').html('二维码获取失败..');
		}else{
			$('#ajaxwx_login_qrcode').html('<img src="'+data+'" width="100" height="100">');
			ajaxsetval = setInterval("ajaxwxorderstatus()", 2000); 
			ajaxsetwout = setTimeout(function(){
				clearInterval(ajaxsetval);
				ajaxsetval = null;
				var ajaxwx_sx = $("#ajaxwx_sx").html();
				$('#ajaxwx_login_qrcode').html(ajaxwx_sx);
			},300*1000);
		}
	});
}
function ajaxwxorderstatus() { 
	$.post('<?php echo smarty_function_url(array('m'=>'login','c'=>'getwxloginstatus'),$_smarty_tpl);?>
',{t:1},function(data){
		
		var data=eval('('+data+')');
		if(data.url!='' && data.msg!=''){
			clearInterval(ajaxsetval);
			ajaxsetval = null;
			layer.msg(data.msg, 2, 9,function(){window.location.href=data.url;});
		}else if(data.url){
			window.location.href=data.url;
		}
	});
}
function jobaddurl(num,integral_job){ 
	var gourl= weburl+'/member/index.php?c=jobadd';
		checkType = 'addjob';

	var url = weburl + '/index.php?m=ajax&c=ajax_day_action_check';
		$.post(url,
			{'type': checkType},
			function(data){
				data = eval('(' + data + ')');
				if(data.status == -1){
					layer.msg(data.msg, 2, 8);
				}else if(data.status == 1){
					if(num==1){
						window.location.href=gourl;
						window.event.returnValue = false;
						return false;
					}else if(num==2){
						var msg='套餐已用完，您可以<a href="'+weburl+'/member/index.php?c=right&act=added" style="color:red;">购买增值包</a>！是否继续？';
						layer.confirm(msg, function(){
							layer.closeAll();
							window.location.href=weburl+"/member/index.php?c=right&act=added"; 
							
						});
					}else if(num==0){
						var msg='会员已到期，您可以<a href="'+weburl+'/member/index.php?c=right" style="color:red">购买会员</a>！是否继续？';

						layer.confirm(msg, function(){
							window.location.href=weburl+"/member/index.php?c=right"; 
						});  
 						
 					}
				}
			}
		);
	 
}

function imgCodeShow(type){
	var act_login=$("#ajaxact_login").val();
	var username='';
	var password='';
	if (act_login==0) {
		username=$("#ajaxusername").val();
		if(username=="" || username=="用户名"|| username=="邮箱/手机号/用户名"){ 
			$("#ajaxshow_name").show();
			$("#ajaxusername").focus(
			    function(){
			       $("#ajaxshow_name").hide();
			    }
			);
			return false;
		}else{
		    $("#ajaxshow_name").hide();
		}
		password=$("#ajaxpassword").val();
		if(password==""){
			$("#ajaxshow_pass").show();
			$("#ajaxpassword").focus(
			    function(){
				    $("#ajaxshow_pass").hide();
				}
			);
			return false;
		}else{
		    $("#ajaxshow_pass").hide();
		}
 
	}else{
		username = $('#ajaxusermoblie').val();
		ajaxcheckmoblie(username);
	}

	if(type == '1'){
		 $("#btnDiv").html("<input type='submit' value='确定' class='yz_bth' onclick='check_ajaxlogin(\"<?php echo smarty_function_url(array('m'=>'login','c'=>'loginsave'),$_smarty_tpl);?>
\", \"vcode_imgs\");' />");
	}else if(type == '2'){
		$("#btnDiv").html("<input type='submit' value='确定'class='yz_bth'  onclick='ajaxsend_msg(\"<?php echo smarty_function_url(array('m'=>'login','c'=>'sendmsg'),$_smarty_tpl);?>
\");' />");
	}
	checkCode('vcode_imgs');
	layer.open({
		type: 1,
		title: '安全验证',
		closeBtn: 1,
		border: [10, 0.3, '#000', true],
		area: ['auto', 'auto'],
		content: $("#imgCodeDiv"),
		cancel: function(){
			window.location.reload();
		}
	});
 }

function check_ajaxlogin(url,img,num){

	var act_login=$("#ajaxact_login").val();
  	var referurl=$("#referurl").val();
	var username='';
	var password='';
	
	if (act_login==0) {
		username=$("#ajaxusername").val();
		if(username=="" || username=="用户名"|| username=="邮箱/手机号/用户名"){ 
			$("#ajaxshow_name").show();
			$("#ajaxusername").focus(
			    function(){
			       $("#ajaxshow_name").hide();
			    }
			);
			return false;
		}else{
		    $("#ajaxshow_name").hide();
		}
		password=$("#ajaxpassword").val();
		if(password==""){
			$("#ajaxshow_pass").show();
			$("#ajaxpassword").focus(
			    function(){
				    $("#ajaxshow_pass").hide();
				}
			);
			return false;
		}else{
		    $("#ajaxshow_pass").hide();
		}


	}else{
		
		username = $('#ajaxusermoblie').val();
		ajaxcheckmoblie(username);
		password= $('#ajaxdynamiccode').val();
		if(password=="" || password=="短信动态码"){
			
			$("#ajaxshow_dynamiccode").show();
			$("#ajaxdynamiccode").focus(
			    function(){
				    $("#ajaxshow_dynamiccode").hide();
				}
			);
			return false;
		}else{
		    $("#ajaxshow_dynamiccode").hide();
		}
	}

	
	var verify_token = '';
	var authcode = '';
	var codesear=new RegExp('前台登录');
	if(codesear.test(code_web) && act_login==0){
		if(code_kind==1){
			if(exitsid("ajaxtxt_CheckCode")){
				authcode=$("#ajaxtxt_CheckCode").val();
				if(authcode==""||authcode=="验证码"){
					$("#ajaxshow_code").show();
					$("#ajaxtxt_CheckCode").focus(
						function(){
							$("#ajaxshow_code").hide();
						}
					);
					return false;
				}else{
					$("#ajaxshow_code").hide();
				}
			}
		}else if(code_kind > 2){
			verify_token = $('input[name="verify_token"]').val();
			$('#bind-captcha').attr('data-id','check_ajaxlogin');
			if(verify_token ==''){
				$("#bind-submit").trigger("click");
				
				
				return false;
			}
		}
	}
	if($("input[name=loginname]").attr("checked")=='checked'){
		var loginname=7;
	}else{
		var loginname=0;
	}
	var path=$("#path").val();
	var loadIndex = layer.load('登录中,请稍候...');
	$.post(url,{act_login:act_login,num:num,referurl:referurl,username:username,password:password,path:path,loginname:loginname,authcode:authcode,verify_token:verify_token},function(data){ 
    layer.close(loadIndex);
		
		var jsonObject = eval("(" + data + ")"); 
		if(jsonObject.error == '3'){
			$('#uclogin').html(jsonObject.msg);
			setTimeout("window.location.href='"+jsonObject.url+"';",500); 
		}else if(jsonObject.error == '2'){
			$('#uclogin').html(jsonObject.msg); 
			setTimeout("window.location.href='"+jsonObject.url+"';",500); 
		}else if(jsonObject.error == '1'){ 			
			window.location.href=jsonObject.url; window.event.returnValue = false;return false;
		}else if(jsonObject.error == '0'){
			layer.msg(jsonObject.msg, 2, 8,function(){ 
				if(jsonObject.url){
					window.location.href=jsonObject.url; 
					window.event.returnValue = false;return false;
				}else{
					if(code_kind==1){
						checkCode(img);
						return false;
					}else if(code_kind>2){
 						$("#popup-submit").trigger("click");
						return false;
					
					}
				}
			}); 
			
		}
	});
	$("#ajaxtxt_CheckCode").val('');
}
function ajaxcheckmoblie(moblie){
	if(!checkmoblie(moblie)){ 
		$("#ajaxshow_mobile").show();
		$("#ajaxusermobile").focus(
		    function(){
		       $("#ajaxshow_mobile").hide();
		    }
		);
		return false;
	}else{
	    $("#ajaxshow_mobile").hide();
	    return true;
	}
}

//发送手机短信
function ajaxsend_msg(url) {
	parent.layer.closeAll();
	var moblie = $('#ajaxusermoblie').val();
	if (!ajaxcheckmoblie(moblie)) {
		return false;
	}
	var verify_token = '';
	var code = '';

	var showCodeCheck = code_web.indexOf('前台登录');
	if (showCodeCheck >= 0) {
		if (code_kind == 1) {
			if ($("#ajaxtxt_CheckCode").length > 0) {

				code = $.trim($("#ajaxtxt_CheckCode").val());
				if (!code || code == '验证码') {
					layer.msg('图片验证码不能为空！', 2, 8);
					return false;
				}
			}
		} else if (code_kind > 2) {
			verify_token = $('input[name="verify_token"]').val();

			if (verify_token == '') {

				$("#bind-submit").trigger("click");
				return false;
			}
		}
	}
	if (smsTimer_time == smsTimer_flag) {
		Timer = setInterval("smsTimer($('#ajaxsend_msg_tip'))", smsTime_speed);
		layer.load('执行中，请稍候...', 0);
		$.post(url, {
			moblie: moblie, code: code,
			verify_token: verify_token
		}, function (data) {
			layer.closeAll('loading');
			if (data) {
				var res = JSON.parse(data);
				if (res.error != 1) {
					clearInterval(Timer);
				}
				var icon = res.error == 1 ? 9 : 8;
				layer.msg(res.msg, 2, icon, function () {
					if (res.error != 1) {
						clearInterval(Timer);
						if (code_kind == 1) {
							checkCode('vcode_imgs');
						} else if (code_kind > 2) {
							$("#popup-submit").trigger("click");
						}
					} else {
						if (code_kind == 1 && showCodeCheck >= 0) {
							$('.hp_login_lg_but').attr('onclick', "check_ajaxlogin('<?php echo smarty_function_url(array('m'=>'login','c'=>'loginsave'),$_smarty_tpl);?>
','vcode_imgs');");
						}
					}
				});
			}
		})
	} else {
		layer.msg('请勿重复发送！', 2, 8);
		return false;
	}
}
<?php echo '</script'; ?>
><?php }} ?>
