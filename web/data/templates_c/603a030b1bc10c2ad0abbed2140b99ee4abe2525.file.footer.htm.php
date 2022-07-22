<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-06 16:37:48
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\wap\footer.htm" */ ?>
<?php /*%%SmartyHeaderCode:3156562c549dc3acd49-41214746%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '603a030b1bc10c2ad0abbed2140b99ee4abe2525' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\wap\\footer.htm',
      1 => 1634883862,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3156562c549dc3acd49-41214746',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'indexnav' => 0,
    'wap_style' => 0,
    'usertype' => 0,
    'username' => 0,
    'membernav' => 0,
    'config' => 0,
    'uid' => 0,
    'fabu_resume_maxnum' => 0,
    'resume_num' => 0,
    'addltjobnum' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c549dc416c38_78721063',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c549dc416c38_78721063')) {function content_62c549dc416c38_78721063($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.url.php';
if (!is_callable('smarty_function_tongji')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.tongji.php';
?>

		<!-- 固定的手机底部 -->
		
		<div class="wap_footer">
			<div class="wap_footerfixd">
				<div class="wap_footerbox">
					<a class="wap_footernav" href="<?php echo smarty_function_url(array('m'=>'wap'),$_smarty_tpl);?>
">
						<div class="wap_footericon">
							<?php if (isset($_smarty_tpl->tpl_vars['indexnav']->value)) {?>
							<img src="<?php echo $_smarty_tpl->tpl_vars['wap_style']->value;?>
/images/tab_icon_home_s.png" alt="" style="width: 100%;">
							<?php } else { ?>
							<img src="<?php echo $_smarty_tpl->tpl_vars['wap_style']->value;?>
/images/tab_icon_home_n.png" alt="" style="width: 100%;">
							<?php }?>
						</div>
						<div class="wap_footer_name">首页</div>
					</a>
					<?php if ($_smarty_tpl->tpl_vars['usertype']->value==1||!$_smarty_tpl->tpl_vars['usertype']->value) {?>
					<a class="wap_footernav" href="<?php echo smarty_function_url(array('m'=>'wap','c'=>'job'),$_smarty_tpl);?>
">
						<div class="wap_footericon">
							<?php if ($_GET['c']=='job') {?>
							<img src="<?php echo $_smarty_tpl->tpl_vars['wap_style']->value;?>
/images/tab_icon_position_s.png" alt="" style="width: 100%;">
							<?php } else { ?>
							<img src="<?php echo $_smarty_tpl->tpl_vars['wap_style']->value;?>
/images/tab_icon_position_n.png" alt="" style="width: 100%;">
							<?php }?>
						</div>
						<div class="wap_footer_name">职位</div>
					</a>
					<?php } else { ?>
					<a class="wap_footernav" href="<?php echo smarty_function_url(array('m'=>'wap','c'=>'resume'),$_smarty_tpl);?>
">
						<div class="wap_footericon">
							<?php if ($_GET['c']=='resume') {?>
							<img src="<?php echo $_smarty_tpl->tpl_vars['wap_style']->value;?>
/images/tab_icon_jl_n.png" alt="" style="width: 100%;">
							<?php } else { ?>
							<img src="<?php echo $_smarty_tpl->tpl_vars['wap_style']->value;?>
/images/tab_icon_jl.png" alt="" style="width: 100%;">
							<?php }?>
						</div>
						<div class="wap_footer_name">简历</div>
					</a>
					<?php }?>

					<div class="wap_footernav" onclick="fabu();">
						<div class="wap_footer_fb ">
							<img src="<?php echo $_smarty_tpl->tpl_vars['wap_style']->value;?>
/images/home_icon_release_default.png" alt=""
								style="width: 100%;">
						</div>	
						<div class="wap_footer_name"><?php if ($_smarty_tpl->tpl_vars['usertype']->value=='1') {?>发布简历<?php } elseif ($_smarty_tpl->tpl_vars['usertype']->value=='2') {?>发布职位<?php } else { ?>发布<?php }?></div>
					</div>

					<a class="wap_footernav" href="<?php if (!$_smarty_tpl->tpl_vars['username']->value) {
echo smarty_function_url(array('m'=>'wap','c'=>'login'),$_smarty_tpl);
} else {
echo smarty_function_url(array('m'=>'wap'),$_smarty_tpl);?>
member/index.php?c=sysnews<?php }?>">
						<div class="wap_footericon">
							<!--未读消息数量-->
						    <div id="tzmsgNum" class="none  Unread_message"></div>
							<?php if ($_GET['c']=='sysnews') {?>
							<img src="<?php echo $_smarty_tpl->tpl_vars['wap_style']->value;?>
/images/tab_icon_news_s.png" alt="" style="width: 100%;">
							<?php } else { ?>
							<img src="<?php echo $_smarty_tpl->tpl_vars['wap_style']->value;?>
/images/tab_icon_news_n.png" alt="" style="width: 100%;">
							<?php }?>
						</div>
						<div class="wap_footer_name">消息</div>
					</a>
					<a class="wap_footernav" href="<?php if (!$_smarty_tpl->tpl_vars['username']->value) {
echo smarty_function_url(array('m'=>'wap','c'=>'login'),$_smarty_tpl);
} else {
echo smarty_function_url(array('m'=>'wap'),$_smarty_tpl);?>
member/<?php }?>">
						<div class="wap_footericon">
							<?php if ($_GET['c']=='login'||isset($_smarty_tpl->tpl_vars['membernav']->value)) {?>
							<img src="<?php echo $_smarty_tpl->tpl_vars['wap_style']->value;?>
/images/tab_icon_me_s.png" alt="" style="width: 100%;">
							<?php } else { ?>
							<img src="<?php echo $_smarty_tpl->tpl_vars['wap_style']->value;?>
/images/tab_icon_me_n.png" alt="" style="width: 100%;">
							<?php }?>
						</div>
						<div class="wap_footer_name">我的</div>
					</a>
				</div>
			</div>
		</div>


		<!--企业点击发布-->
		<?php if ($_smarty_tpl->tpl_vars['usertype']->value=='2'&&!$_smarty_tpl->tpl_vars['membernav']->value) {?>
			<!-- 余额不足提示 -->
			<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['wapstyle']->value)."/publichtm/yun_modal.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

			<!-- 强制操作提醒弹出框 -->
			<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['wapstyle']->value)."/publichtm/yun_cert.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

			<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['wap_style']->value;?>
/js/com.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
		<?php } elseif ($_smarty_tpl->tpl_vars['usertype']->value=='3'&&!$_smarty_tpl->tpl_vars['membernav']->value) {?>
			<style type="text/css">
				.yun_prompt_release_ws_a {
				    color: #5183ff;
				    display: inline-block;
				    margin-left: 10px;
				    position: absolute;
				    right: 0px;
				    top: 10px;
				    font-weight: normal;
				}
				.yun_prompt_release_ws {
				    line-height: 25px;
				    font-size: 14px;
				    color: #333;
				    padding: 8px 0px 8px 25px;
				    border-bottom: 1px solid #eee;
				    position: relative;
				    font-weight: bold;
				    text-align: left;
				}
				.tjwmz {
				    padding-top: 15px;
				    text-align: left;
				    color: #999;
				}
			</style>
			<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['wap_style']->value;?>
/js/lt_public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
		<?php }?>

		<?php echo '<script'; ?>
 type="text/javascript">
			var wapurl   = '<?php echo smarty_function_url(array('m'=>'wap'),$_smarty_tpl);?>
';
			var uid  = '<?php echo $_smarty_tpl->tpl_vars['uid']->value;?>
';
			var usertype  = '<?php echo $_smarty_tpl->tpl_vars['usertype']->value;?>
';
			var fabu_resume_maxnum = '<?php echo $_smarty_tpl->tpl_vars['fabu_resume_maxnum']->value;?>
';
			var resume_num = '<?php echo $_smarty_tpl->tpl_vars['resume_num']->value;?>
';
			function fabu(){

				if(parseInt(uid)>0){
					if(usertype=='1'){
						if(resume_num>0){
							location.href = wapurl+"member/index.php?c=resume";
						}else if(fabu_resume_maxnum >0 || fabu_resume_maxnum == ''){
			      			location.href = wapurl+"member/index.php?c=addresume";
			      		}else{
			      			showToast("你的简历数已经达到系统设置的简历数了");
			      		}
					}else if(usertype=='2'){
		                var url = "<?php echo smarty_function_url(array('d'=>'wxapp','h'=>'com','m'=>'index','c'=>'addCheck'),$_smarty_tpl);?>
";
		                comjobAdd(url, { job: 'job' }, function (res) {
							if(res.msg){
								// 套餐不足
								modalVue.$data.mb_content = res.msg;
								modalVue.$data.cancelText = '不用了';
								modalVue.$data.confirmText = '去购买';
								modalVue.$data.yunModal = true;
								modalType = 'job';
							}else{
								// 强制操作
								certVue.$data.checked = res;
								certVue.$data.yunCert = true;
							}
		                });
					}else if(usertype=='3'){
						jobadd_url('<?php echo $_smarty_tpl->tpl_vars['addltjobnum']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_job'];?>
','lietou','<?php echo $_smarty_tpl->tpl_vars['config']->value['com_integral_online'];?>
','<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_proportion'];?>
');
					}else if(usertype=='4'){
						location.href = wapurl+'member/index.php?c=addsubject';
					}else{
						location.href = "<?php echo smarty_function_url(array('m'=>'wap','c'=>'register','a'=>'ident'),$_smarty_tpl);?>
";
					}
				}else{
					navigateTo('<?php echo smarty_function_url(array('m'=>'wap','c'=>'login'),$_smarty_tpl);?>
');
				}
			}
		<?php echo '</script'; ?>
>
 
		<div id='uclogin' class='none'></div>
		<div class='none'><?php echo smarty_function_tongji(array(),$_smarty_tpl);?>
</div>
		<?php if ($_smarty_tpl->tpl_vars['config']->value['sy_chat_open']==1&&$_smarty_tpl->tpl_vars['uid']->value&&($_smarty_tpl->tpl_vars['usertype']->value&&$_smarty_tpl->tpl_vars['usertype']->value!=4)&&$_GET['c']!='xjhlive') {?>
		<!--获取直聊新增数量-->
		<?php echo '<script'; ?>
>
			var socketUrl = "<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_chat_weburl'];?>
",
				chat_name = "<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_chat_name'];?>
";
		<?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['wap_style']->value;?>
/chat/yunliao/socket.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
		<?php }?>
		
		<?php echo '<script'; ?>
>

			var wapurl   = '<?php echo smarty_function_url(array('m'=>'wap'),$_smarty_tpl);?>
';
			$(function(){

				'<?php if ($_smarty_tpl->tpl_vars['usertype']->value) {?>'
				$.get(wapurl + "index.php?c=ajax&a=msgNum", function(datas) {
					if(datas.usertype == 1) {
						if(datas.msgNum) {
							$('#tzmsgNum').css('display','block');
							$('#tzmsgNum').text(datas.msgNum);
						}
					}
					if(datas.usertype == 2) {
						if(datas.msgNum) {
							$('#tzmsgNum').css('display','block');
							$('#tzmsgNum').text(datas.msgNum);
						}
					}
					if(datas.usertype == 3) {
						if(datas.msgNum) {
							$('#sysmsgnum').text(datas.msgNum);
							$('#tzmsgNum').text(datas.msgNum);
							$('#tzmsgNum').show();
						}
						$('#ypnum').text(datas.ypnum);
						$('#jobnum').text(datas.jobnum);
						$('#downnum').text(datas.downnum);
						if(datas.couponNum>0) {
							$('#couponNum').text(datas.couponNum+'张优惠券快过期');
							$('#couponNum').show();
						}
					}
					if(datas.usertype == 4) {
						if(datas.msgNum) {
							$('#sysmsgnum').text(datas.msgNum);
							$('#tzmsgNum').text(datas.msgNum);
							$('#tzmsgNum').show();
						}
						$('#baoming_num').text(datas.baoming_num);
						$('#zixun_num').text(datas.zixun_num);
						$('#subject_num').text(datas.subject_num);
					}
				}, 'json');
				'<?php }?>'
			})

			
		<?php echo '</script'; ?>
>
	</body>
</html><?php }} ?>
