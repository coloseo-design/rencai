<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:10:03
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\member\user\headnav.htm" */ ?>
<?php /*%%SmartyHeaderCode:3182162d8fbcb0db8f6-99824957%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '02d5c20ae03af527439982956725417d62d5cc89' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\member\\user\\headnav.htm',
      1 => 1634883848,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3182162d8fbcb0db8f6-99824957',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'resume' => 0,
    'statis' => 0,
    'member' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d8fbcb15d6c2_30419712',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d8fbcb15d6c2_30419712')) {function content_62d8fbcb15d6c2_30419712($_smarty_tpl) {?><?php if (!is_callable('smarty_function_sign')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.sign.php';
if (!is_callable('smarty_function_url')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.url.php';
?><body>

<div class="user_header">
    <div class="w1200">
        <div class="user_headerlogo ">
            <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
" target="_blank" title='返回网站首页'>
                <img alt="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_member_logo'];?>
">
            </a>
        </div>

        <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
" target="_blank" title='返回网站首页' class="user_m_fanh">返回首页</a>

        <div class="yun_m_headermsg" onMouseOver="tzmsgNumShow('show')" onMouseOut="tzmsgNumShow('hide')">
            <i class="yun_m_headermsg_icon"></i>通知中心<span class="yun_m_headermsg_n" id="msgNum" style="display:none">0</span>
            <div class="yun_m_headermsg_box" style="display:none">
                <div class="yun_m_headermsg_list">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php?c=invite">面试通知 <em class="yun_m_headermsg_list_n" id="userid_msgNum"></em></a>
                </div>
                <div class="yun_m_headermsg_list">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php?c=sysnews">系统消息 <em class="yun_m_headermsg_list_n" id="sysmsgNum"></em></a>
                </div>
                <div class="yun_m_headermsg_list">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php?c=commsg">企业回复咨询 <em class="yun_m_headermsg_list_n" id="usermsgNum"></em></a>
                </div>
            </div>
        </div>
        <div class="header_m_navright">

            <div class="header_m_navright_tip" style="display:none;">
                <div class="header_m_navright_tip_box">7 项资料未完善, <a href="###" class="cblue">立即完善</a><a href="###" class="header_m_navright_tip_close"></a></div>
            </div>
            <div class="yun_m_indexinfo_user_qd"><i class="yun_m_indexinfo_user_qd_icon"></i><?php echo smarty_function_sign(array(),$_smarty_tpl);?>
</div>
            <div class="yun_m_headertx">
                <a href="index.php?c=uppic" class="yun_m_headertxa">
                    <?php if ($_smarty_tpl->tpl_vars['resume']->value['sex']==1) {?>
                    <img src="<?php echo $_smarty_tpl->tpl_vars['resume']->value['photo'];?>
" border="0" height="30" width="30" onerror="showImgDelay(this,'<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_member_icon'];?>
',2);"/>
                    <?php } else { ?>
                    <img src="<?php echo $_smarty_tpl->tpl_vars['resume']->value['photo'];?>
" border="0" height="30" width="30" onerror="showImgDelay(this,'<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_member_iconv'];?>
',2);"/>
                    <?php }?>
                </a>

                <div class="yun_m_headertx_hi"><?php echo $_smarty_tpl->tpl_vars['resume']->value['name'];?>
</div>

                <div class="yun_m_header_info" style="display:none;">

                    <div class="user_tc_tit">我的<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
</div>
                    <div class="user_t_jf">
                        <span class="yun_m_index_pay_n"><?php echo $_smarty_tpl->tpl_vars['statis']->value['integral'];?>
</span>
                        <?php echo $_smarty_tpl->tpl_vars['config']->value['integral_priceunit'];
echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>

                        <a href="index.php?c=pay" class="yun_m_index_pay_a">充值</a>
                        <a href="<?php echo smarty_function_url(array('m'=>'redeem'),$_smarty_tpl);?>
" class="yun_m_index_pay_a" target="_blank">兑换礼品</a>
                        <a href="index.php?c=integral" class="yun_m_index_pay_a">赚<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
</a>
                    </div>

                    <div class="user_tc_tit">我的认证</div>
                    <div class="yun_m_indexinfo_user_bding">
                        <div class="yun_m_indexinfo_user_bding_p">
                            <a href="index.php?c=passwd">
                                <?php if ($_smarty_tpl->tpl_vars['resume']->value['moblie_status']!='1') {?>
                                <span class="yun_user_rz_box yun_user_rz_sj"><i class="yun_user_rz_no_icon"></i><em class="yun_user_rz_no">手机未认证</em></span>
                                <?php } else { ?>
                                <span class="yun_user_rz_box yun_user_rz_sj"><i class="yun_user_rz_yes_icon"></i><em class="yun_user_rz_yes">手机已认证</em></span>
                                <?php }?>
                            </a>
                        </div>
                        <div class="yun_m_indexinfo_user_bding_p">
                            <a href="index.php?c=passwd">
                                <?php if ($_smarty_tpl->tpl_vars['resume']->value['idcard_status']!='1') {?>
                                    <span class="yun_user_rz_box yun_user_rz_sf"><i class="yun_user_rz_no_icon"></i><em class="yun_user_rz_no">身份未认证</em></span>
                                <?php } else { ?>
                                    <span class="yun_user_rz_box yun_user_rz_sf"><i class="yun_user_rz_yes_icon"></i><em class="yun_user_rz_yes">身份已认证</em></span>
                                <?php }?>
                            </a>
                        </div>

                        <?php if ($_smarty_tpl->tpl_vars['config']->value['wx_author']=='1') {?>
                        <div class="yun_m_indexinfo_user_bding_p">
                            <a href="index.php?c=binding">
                                <?php if ($_smarty_tpl->tpl_vars['member']->value['unionid']!=''||$_smarty_tpl->tpl_vars['member']->value['wxid']!='') {?>
                                    <span class="yun_user_rz_box yun_user_rz_wx"><i class="yun_user_rz_yes_icon"></i><em class="yun_user_rz_yes">微信认证</em></span>
                                <?php } else { ?>
                                    <span class="yun_user_rz_box yun_user_rz_wx"><i class="yun_user_rz_no_icon"></i><em class="yun_user_rz_no">微信未认证</em></span>
                                <?php }?>
                            </a>
                        </div>
                        <?php }?>
                        <div class="yun_m_indexinfo_user_bding_p">
                            <a href="index.php?c=passwd">
                                <?php if ($_smarty_tpl->tpl_vars['resume']->value['email_status']!='1') {?>
                                    <span class="yun_user_rz_box yun_user_rz_yx"><i class="yun_user_rz_no_icon"></i><em class="yun_user_rz_no">邮箱未认证</em></span>
                                <?php } else { ?>
                                    <span class="yun_user_rz_box yun_user_rz_yx"><i class="yun_user_rz_yes_icon"></i><em class="yun_user_rz_yes">邮箱认证</em></span>
                                <?php }?>
                            </a>
                        </div>

                    </div>

                    <div class="user_tc_tit">其他设置</div>
                    <div class="user_tc_tset">
                        <a href="index.php?c=passwd" class="user_set_bth"><i class="user_set_icon user_set_icon1"></i>账户设置</a>
                        <a href="index.php?c=transfer" target="_blank" class="user_set_bth"><i class="user_set_icon user_set_icon2"></i>账户分离</a>
                        <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_user_change']==1) {?><a href="javascript:void(0)" onclick="changeutype();" class="user_set_bth"><i class="user_set_icon user_set_icon3"></i>切换身份</a> <?php }?>
                        <a href="index.php?c=logout" class="user_set_bth"><i class="user_set_icon user_set_icon4"></i>账户注销</a>
                    </div>
                    <div class="user_tcdl">
                        <a href="javascript:void(0)" onClick="logout('index.php?act=logout')" title="退出登录" class="user_tcdlbth" style="border:none;">退出登录</a>
                    </div>
                </div>
            </div>
            <span class="user_headertel">求职咨询电话：<span class="user_headertel_n"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_freewebtel'];?>
</span></span>
        </div>
    </div>
</div>
<div class="clear"></div>

<?php echo '<script'; ?>
>
    $(".yun_m_headertx").hover(function () {
        $(".yun_m_header_info").show();
    }, function () {
        $(".yun_m_header_info").hide();
    });
<?php echo '</script'; ?>
>
<div class="clear"></div><?php }} ?>
