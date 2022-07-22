<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-22 10:13:54
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\\resume\resume_right.htm" */ ?>
<?php /*%%SmartyHeaderCode:2898062da07e28326f6-06110300%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1a7f9d04c37ca139816f8829ac3f4ecdc62748fd' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\\\resume\\resume_right.htm',
      1 => 1643012865,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2898062da07e28326f6-06110300',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'Info' => 0,
    'usertype' => 0,
    'usermsgnum' => 0,
    'talent_pool' => 0,
    'uid' => 0,
    'username' => 0,
    'config' => 0,
    'userdata' => 0,
    'uesrv' => 0,
    'userclass_name' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62da07e28a19d7_70962198',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62da07e28a19d7_70962198')) {function content_62da07e28a19d7_70962198($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.url.php';
?><?php if ($_GET['see']!='member') {?> 
	<div class="yun_resume_ylcz noprint" style="text-align: center;margin-bottom:10px;" >
		<div class="yun_resume_czewm">
		<div>微信扫一扫：分享</div>
		<img src="<?php echo smarty_function_url(array('m'=>'ajax','c'=>'pubqrcode','toc'=>'resume','toa'=>'show','toid'=>$_smarty_tpl->tpl_vars['Info']->value['id']),$_smarty_tpl);?>
" width="160" height="160">
		<div class="yun_resume_cz_tit" style="color:red;">↑微信扫上方二维码↑</br>便可将此简历分享至朋友圈</div>
		</div>
	</div>
	<!-- 企业查看简历 -->
	<?php if ($_smarty_tpl->tpl_vars['usertype']->value!=1) {?>

	<div class="yun_resume_cz  noprint" id="operation_box">
		
		<?php if ($_smarty_tpl->tpl_vars['usertype']->value==2) {?> 
			<?php if ($_smarty_tpl->tpl_vars['usermsgnum']->value) {?> 
				<input class="yun_resume_cz_a" type="button" value="已邀请面试 ">
			<?php } else { ?>
				<input class="yun_resume_cz_a" onclick="sq_resume(this)" type="button" value="邀请面试 " username="<?php echo $_smarty_tpl->tpl_vars['Info']->value['name'];?>
"  uid="<?php echo $_smarty_tpl->tpl_vars['Info']->value['uid'];?>
">
			<?php }?>
		<?php }?>
		
		<div>
	
			<?php if ($_smarty_tpl->tpl_vars['talent_pool']->value) {?> 
				<input class="yun_resume_cz_bth fl" type="button" onClick="layer.msg('该简历已加入到人才库！',2,8);" value="已收藏">
			<?php } else { ?> 
				<input class="yun_resume_cz_bth fl" type="button" onClick="add_user_talent('<?php echo $_smarty_tpl->tpl_vars['Info']->value['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['usertype']->value;?>
')" value="收藏"> 
			<?php }?>
	
			<div class="yun_resume_cz_bth_xz_box"> <?php echo $_smarty_tpl->tpl_vars['Info']->value['link_msg_right'];?>
 </div>
	
			<input class="yun_resume_cz_bth  yun_resume_cz_bth_dy fl" type="button" onClick="dayin()" value="打印 " name="button">
			
			<?php if (!$_smarty_tpl->tpl_vars['uid']->value&&!$_smarty_tpl->tpl_vars['username']->value) {?> 
				
				<?php if ($_smarty_tpl->tpl_vars['Info']->value['height_status']==2) {?> 
				
					<input class="yun_resume_cz_bth yun_resume_cz_bth_fx fr" type="button" onClick="showlogin('3');" value="分享" name="submit">
				<?php } else { ?> 
					
					<input class="yun_resume_cz_bth yun_resume_cz_bth_fx fr" type="button" onClick="showlogin('2');" value="分享" name="submit">
				<?php }?>
				
			<?php } else { ?> 
			
				<input class="yun_resume_cz_bth yun_resume_cz_bth_fx fr" type="button" onClick="recommendInterval('<?php echo $_smarty_tpl->tpl_vars['uid']->value;?>
','<?php echo smarty_function_url(array('m'=>'resume','c'=>'resumeshare','id'=>'`$Info.id`'),$_smarty_tpl);?>
');" value="分享" name="submit"> 
			<?php }?> 
			
			<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['Info']->value['id'];?>
" id="eid">
		</div>
	
		<?php if ($_smarty_tpl->tpl_vars['config']->value['sy_chat_open']==1) {?>
		<div class="vita_Opera_cz_chat">
			<input type="button"  onClick="resumeChat('<?php echo $_smarty_tpl->tpl_vars['Info']->value['uid'];?>
','<?php echo $_smarty_tpl->tpl_vars['Info']->value['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['usertype']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_chat_name'];?>
')" value="和TA直接聊" class="vita_Opera_cz_chat_a">
		</div>
		<?php }?>
	
		<form action="index.php?m=resume&c=show&a=report" method="post" id='myform' target="supportiframe" class="layui-form">
			<input type="hidden" name="r_uid" value="<?php echo $_smarty_tpl->tpl_vars['Info']->value['uid'];?>
">
			<input type="hidden" name="r_eid" value="<?php echo $_smarty_tpl->tpl_vars['Info']->value['id'];?>
">
			<input type="hidden" name="r_name" value="<?php echo $_smarty_tpl->tpl_vars['Info']->value['name'];?>
">
			
			<div class="yun_resume_ts_tit">简历投诉</div>
			
			<div class="yun_resume_cz_dt">若该简历为无效简历，您可以在此举报：</div>
			
			<div class="yun_resume_cz_dt">
			
				<?php  $_smarty_tpl->tpl_vars['uesrv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['uesrv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_reporting']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['uesrv']->key => $_smarty_tpl->tpl_vars['uesrv']->value) {
$_smarty_tpl->tpl_vars['uesrv']->_loop = true;
?>
				<input type="checkbox" name="reason[]" id="reason_<?php echo $_smarty_tpl->tpl_vars['uesrv']->value;?>
" lay-skin="primary" title="<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['uesrv']->value];?>
" value="<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['uesrv']->value];?>
" />
				<?php } ?>
			</div>
			
			<div class="yun_resume_cz_dt">
				
				<?php if (!$_smarty_tpl->tpl_vars['uid']->value&&!$_smarty_tpl->tpl_vars['username']->value) {?> 
				
					<input type="button" name="submit" value="举报" onClick="showlogin('2');" class="yun_resume_cz_jb_a">
				<?php } elseif ($_smarty_tpl->tpl_vars['usertype']->value!=2) {?> 
					
					<input class="yun_resume_cz_jb_a" onClick="layer.msg('只有企业用户才可以举报！',2,8);" type="button" name="submit" value="举报 "> 
				<?php } else { ?>
				
				 	<input type="submit" name="submit" value="举报" class="yun_resume_cz_jb_a">
				<?php }?>
			</div>
		</form>
	</div>

	<?php }?>
	
	<!-- 自己预览简历 -->
	<?php if ($_smarty_tpl->tpl_vars['uid']->value==$_smarty_tpl->tpl_vars['Info']->value['uid']&&$_smarty_tpl->tpl_vars['usertype']->value==1) {?>
		<div class="yun_resume_ylcz noprint">
			<?php if ($_smarty_tpl->tpl_vars['usertype']->value==1) {?>
				<div class="yun_resume_cz ">
					<a href="<?php echo smarty_function_url(array('m'=>'member','c'=>'expect','e'=>$_smarty_tpl->tpl_vars['Info']->value['id']),$_smarty_tpl);?>
" class="yun_resume_cz_xg">修改简历</a>
					<div class="">
						<input class="yun_resume_cz_bc yun_resume_cz_bth_xz fl " onClick="for_link('<?php echo $_smarty_tpl->tpl_vars['Info']->value['id'];?>
','<?php echo smarty_function_url(array('m'=>'ajax','c'=>'for_link'),$_smarty_tpl);?>
','<?php echo smarty_function_url(array('m'=>'ajax','c'=>'resume_word','id'=>$_smarty_tpl->tpl_vars['Info']->value['id']),$_smarty_tpl);?>
');" type="submit" name="submit" value="保存到电脑 "> 
						<div class="yun_resume_cz_gz">如需手机上传或修改个人形象照，请关注微信进行操作</div>
					</div>
				</div>
			<?php }?>
			 
			<div class="yun_resume_czewm">
				<div class="yun_resume_czewmpic">
					<img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_wx_qcode'];?>
" width="150" height="150">
				</div>
				<div class="yun_resume_cz_tit">扫一扫手机上也可以编辑简历了</div>
			</div>
		</div>
	<?php }?> 
<?php }?>
<?php }} ?>
