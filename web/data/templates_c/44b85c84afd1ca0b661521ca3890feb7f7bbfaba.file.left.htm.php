<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 16:00:40
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\member\user\left.htm" */ ?>
<?php /*%%SmartyHeaderCode:1068662d907a882d9f9-16088531%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '44b85c84afd1ca0b661521ca3890feb7f7bbfaba' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\member\\user\\left.htm',
      1 => 1640333832,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1068662d907a882d9f9-16088531',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'msgnum' => 0,
    'uid' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d907a88d4851_14370329',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d907a88d4851_14370329')) {function content_62d907a88d4851_14370329($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.url.php';
?><?php echo '<script'; ?>
>
    $(document).ready(function () {
        $(".left_sidebar_icon").click(function () {
            var aid = $(this).attr("aid");
            var style = $("#leftlist" + aid).attr("style");
            if ($(this).hasClass("left_sidebar_icon")) {
                $(this).parent().prev().find('li.overflow').show();
                $(this).attr("class", "left_sidebar_icon1");
                $(this).parent().prev().prev().height($(this).parent().prev().find('ul li').length * 30);
            } else {
                $(this).parent().prev().find('li.overflow').hide();
                $(this).attr("class", "left_sidebar_icon");
                $(this).parent().prev().prev().height(($(this).parent().prev().find('ul li').length - $(this).parent().prev().find('ul li.overflow').length) * 30);
            }
        })
    });
<?php echo '</script'; ?>
>
<div class="yun_m_leftsidebar">
<div class="yun_m_leftsidebar_box">
	<ul class="yun_m_leftsidebar_list">
		    <li  <?php if ($_GET['c']=='') {?>class="yun_m_left_cur"<?php }?>><a href="index.php" class="nava"><i class="left_navicon left_navicon_i1"></i><span>个人中心</span><b></b></a></li>
		  <li  <?php if ($_GET['c']=='resume') {?>class="yun_m_left_cur"<?php }?>><a href="index.php?c=resume" class="nava"><i class="left_navicon left_navicon_i2"></i><span>我的简历</span><b></b></a></li>
		 	  <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_chat_open']==1) {?> 
		 	  <li  <?php if ($_GET['c']=="chat") {?>class="yun_m_left_cur"<?php }?>>
		
			  <a href="index.php?c=chat" class="nava"><i class="left_navicon left_navicon_i3"></i><span>互动沟通</span><i class="left_sidebar_msg_icon" id="leftMemberChatNum"></i><b></b></a></li>
		    <?php }?>
					
						
			 <li <?php if ($_GET['c']=='invite') {?>class="yun_m_left_cur"<?php }?>><a  href="index.php?c=invite" class="nava"><i class="left_navicon left_navicon_i4"></i><span>面试通知</span><b></b><?php if ($_smarty_tpl->tpl_vars['msgnum']->value) {?><i class="left_sidebar_msg_icon"><?php echo $_smarty_tpl->tpl_vars['msgnum']->value;?>
</i><?php }?></a></li>
		        <li  <?php if ($_GET['c']=='spview') {?>class="yun_m_left_cur"<?php }?>><a href="index.php?c=spview" class="nava"><i class="left_navicon left_navicon_i10"></i><span>视频面试</span><b></b></a></li>
			<li <?php if ($_GET['c']=='job') {?>class="yun_m_left_cur"<?php }?>><a href="index.php?c=job" class="nava"><i class="left_navicon left_navicon_i5"></i><span>申请的职位</span><b></b></a></li>
		   <li <?php if ($_GET['c']=='look') {?>class="yun_m_left_cur"<?php }?>><a href="index.php?c=look" class="nava"><i class="left_navicon left_navicon_i6"></i><span>对我感兴趣</span><b></b></a></li>
			
		    <li  <?php if ($_GET['c']=='favorite') {?>class="yun_m_left_cur"<?php }?>><a href="index.php?c=favorite" class="nava"><i class="left_navicon left_navicon_i7"></i><span>我的收藏</span><b></b></a></li>
			 
			 <li  <?php if ($_GET['c']=='look_job') {?>class="yun_m_left_cur"<?php }?>><a href="index.php?c=look_job"class="nava" ><i class="left_navicon left_navicon_i8"></i><span>我的足迹</span><b></b></a></li>
			 					    <li  <?php if ($_GET['c']=='xjhlive') {?>class="yun_m_left_cur"<?php }?>><a href="index.php?c=xjhlive" class="nava"><i class="left_navicon left_navicon_i11"></i><span>直播预约</span><b></b></a></li>
			  <li style="position: relative; z-index: 100;" onMouseOver="leftmoreShow('show')" onMouseOut="leftmoreShow('hide')"><a href="###" class="nava"><i class="left_navicon left_navicon_i9"></i><span>更多功能</span><b></b></a>
			  <div class="user_more" style="display: none;">
			  <div class="user_more_list"><span class="user_more_name">简历管理</span>    
			    <a  href="index.php?c=resumeout" class="user_more_a">简历外发</a>
			   <a href="index.php?c=resumetpl" class="user_more_a">简历模板</a></div>
			   <div class="user_more_list"><span class="user_more_name">求职管理 </span> 
			   <a href="index.php?c=partapply" class="user_more_a">我的兼职</a> 
			   
			   <a href="index.php?c=subscribe" class="user_more_a">职位订阅</a>
			   <a  href="index.php?c=finder" class="user_more_a">职位搜索器</a> 
			   </div>
			   <div class="user_more_list"><span class="user_more_name">财务管理</span>  
			   <a href="index.php?c=jobpack&act=loglist" class="user_more_a">红包收益</a>
			   <a href="index.php?c=integral" class="user_more_a"><?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
管理</a>
			   
			   <a  href="javascript:void(0);" onclick="getInviteRegHb(0);" class="user_more_a">邀请注册</a>
			   <a  href="index.php?c=paylist" class="user_more_a"> 财务明细 </a> </div>
			   <div class="user_more_list"><span class="user_more_name">其他管理</span>  
			   <a href="index.php?c=baoming_subject" class="user_more_a">培训</a> 
			   <a  href="index.php?c=rebates" class="user_more_a">悬赏</a>
				<a href="<?php echo smarty_function_url(array('m'=>'ask','c'=>'friend','a'=>'myquestion','uid'=>$_smarty_tpl->tpl_vars['uid']->value),$_smarty_tpl);?>
" target="_blank"class="user_more_a">我的提问</a></div>
			  </div>
			  
			  
			  </li>
		 </ul>
</div>
<?php if ($_smarty_tpl->tpl_vars['config']->value['sy_wx_qcode']!='') {?>
<div class="left_wx_box">
<div class="left_wx_box_tip">简历投递实时追踪</div>
<dl class="left_wx_box_dl">
<dt><img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_wx_qcode'];?>
" width="150" height="150"></dt>
<dd class="left_wx_box_tit">关注公众号</dd>
</dl>

</div>
<?php }?>


</div><?php }} ?>
