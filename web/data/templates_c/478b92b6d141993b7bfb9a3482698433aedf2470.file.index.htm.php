<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-08 09:20:47
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\default\login\index.htm" */ ?>
<?php /*%%SmartyHeaderCode:642262c7866f0fca47-06946522%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '478b92b6d141993b7bfb9a3482698433aedf2470' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\default\\login\\index.htm',
      1 => 1634883841,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '642262c7866f0fca47-06946522',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'keywords' => 0,
    'description' => 0,
    'style' => 0,
    'config' => 0,
    'loginname' => 0,
    'referurl' => 0,
    'lunbo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c7866f500058_13435463',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c7866f500058_13435463')) {function content_62c7866f500058_13435463($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.url.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
        <meta name=keywords content="<?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
" />
        <meta name=description content="<?php echo $_smarty_tpl->tpl_vars['description']->value;?>
" />
        <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/style/css.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/css" />
        <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/style/login.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/css" />
        <?php echo '<script'; ?>
>
            var weburl = "<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
",
                integral_pricename = '<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
',
                pricename = '<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
',
                code_web = '<?php echo $_smarty_tpl->tpl_vars['config']->value['code_web'];?>
',
                code_kind = '<?php echo $_smarty_tpl->tpl_vars['config']->value['code_kind'];?>
';
        <?php echo '</script'; ?>
>
    </head>

    <body style="background:#fff">

        <div class="login_cont">
            <div class="login_w960">
                <div class="login_header ">
                    <div class="logo fl" style="position:relative">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_logo'];?>
" class="png"></a>
                    </div>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
" class="logo_fh fr">返回网站首页>></a>
                </div>

            </div>
            <div class="clear"></div>

            <div class="logoin_cont_box">
                <div class="login_left ">
                    <div class="login_box_cont">
                        <!--登录方式选择-->
                        <div class="login_box_h1_d">
                            <input type="hidden" name="act" id="act_login" value="<?php echo $_GET['act'];?>
" />
                            <ul class="login_box_h_list">
                                <li id="acount_login" class="<?php if (!$_GET['act']) {?>login_box_h_list_cur<?php }?>">账号登录<i class="login_box_h_icon"></i></li>
                                <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_msg_isopen']==1&&$_smarty_tpl->tpl_vars['config']->value['sy_msg_login']==1) {?>
                                <li id="mobile_login" class="<?php if ($_GET['act']) {?>login_box_h_list_cur<?php }?>">手机号登录<i class="login_box_h_icon"></i></li>
                                <?php }?>
                            </ul>
                            <?php if ($_smarty_tpl->tpl_vars['config']->value['wx_author']=='1') {?>
                            <div class="wxcode_login" title="微信扫一扫登录" style="display:block;"></div>
                            <div class="normal_login none" title="普通登录"></div>
                            <?php }?>
                        </div>
                        <!--扫码登录页面-->
						
                        <div class="wx_login_show none">
							<div class="wx_login_show_new">
								<div id="wx_login_qrcode" class="wxlogintext">正在获取二维码...</div>
								<div class="wxlogintxt">请使用微信扫一扫登录</div>
								<div id="wx_sx" class="none">
									<div class="wx_login_show_sxbox"><a href="javascript:void(0);" onclick="getwxlogincode()" class="wx_login_show_sxicon"></a>二维码已失效点击刷新</div>
								</div>
							</div>
                        </div>

                        <!--普通登录-->
                        <div class="login_t_box">
                            <div class="login_box_cot" id="login_normal">
                                <!--账号登录-->
                                <div class="login_normal_box" id="login_normal_box">

                                    <div class="login_box_list">
                                        <i class="login_box_icon login_box_username"></i>
                                        <input type="text" class="login_box_bth placeholder loginname" value="<?php if ($_smarty_tpl->tpl_vars['loginname']->value) {
echo $_smarty_tpl->tpl_vars['loginname']->value;
} else { ?>用户名<?php }?>" name="username" id="username" autocomplete="off" />
                                        <div class="logoin_msg none" id="show_name">
                                            <div class="logoin_msg_tx">请填写用户名</div>
                                            <div class="logoin_msg_icon"></div>
                                        </div>

                                    </div>
                                    <div class="login_box_list">
                                        <i class="login_box_icon loginpwd"></i>
                                        <input type="text" id="password2" class="login_box_bth placeholder loginname " value="密码" autocomplete="off" />
                                        <input type="password" id="password" name="password" class="login_box_bth placeholder loginname  none " value="" />
                                        <div class="logoin_msg none" id="show_pass">
                                            <div class="logoin_msg_tx">请填写密码</div>
                                            <div class="logoin_msg_icon"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                <!--手机动态码登录-->
                                <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_msg_isopen']==1&&$_smarty_tpl->tpl_vars['config']->value['sy_msg_login']==1) {?>
                                <div class="login_sj_box none" id="login_sj_box">
                                    <div class="login_box_list">
                                        <i class="login_box_icon login_box_usersj"></i>
                                        <input name="username" id="usermoblie" type="text" class="loginname" value="请输入手机号码">
                                        <div class="logoin_msg none" id="show_mobile">
                                            <div class="logoin_msg_tx">请填写正确的手机号</div>
                                            <div class="logoin_msg_icon"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                <?php }?>

                                <!--验证码选择-->
								
                                <?php if (strpos($_smarty_tpl->tpl_vars['config']->value['code_web'],"前台登录")!==false) {?> 
								
								<?php if ($_smarty_tpl->tpl_vars['config']->value['code_kind']>2) {?>
                                <div class="gtdx-captcha">

									<input type='hidden' id="verify_token"  name="verify_token" value="">
                                    <input type='hidden' id="popup-submit">	
									<input type='hidden' id="bind-submit">
                                </div>
								
                                <?php } else { ?>
                                <div class="clear"></div>
                                <div class="login_box_list">
                                    <i class="login_box_icon loginpyz"></i>
                                    <input id="txt_CheckCode" type="text" class="login_box_bth_yz loginname " value="验证码" maxlength="6" name="authcode" autocomplete="off" />
                                    <div class="login_box_list_yzm"> <img id="vcode_imgs" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/app/include/authcode.inc.php" onclick="checkCode('vcode_imgs');" />
                                    </div>
                                    <div class="logoin_msg none" id="show_code">
                                        <div class="logoin_msg_tx">请输入验证码</div>
                                        <div class="logoin_msg_icon"></div>
                                    </div>
                                </div>
                                <?php }?> 
                                <?php }?> 
                                <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_msg_isopen']==1&&$_smarty_tpl->tpl_vars['config']->value['sy_msg_login']==1) {?>
                                <!--手机验证码输入框-->
                                <div class="login_sj_box none" id="login_sjyz_box">
                                    <div class="login_box_list">
                                        <i class="login_box_icon login_box_userdtm"></i>
                                        <i class="login_box_line"></i>
                                        <input name="password" type="text" class="login_m_text" id="dynamiccode" value="短信动态码" />
                                        <div class="logoin_msg none" id="show_dynamiccode">
                                            <div class="logoin_msg_tx">请填写短信动态码</div>
                                            <div class="logoin_msg_icon"></div>
                                        </div>
                                        <a href="javascript:void(0);" class="send_yzm" id="send_msg_tip" onclick="send_msg2('<?php echo smarty_function_url(array('m'=>'login','c'=>'sendmsg'),$_smarty_tpl);?>
');">发送动态码</a>
                                    </div>
                                </div>
                                <?php }?>

                                
                                <!--登录-->
                                <input type="hidden" id="referurl" name="referurl" value="<?php echo $_smarty_tpl->tpl_vars['referurl']->value;?>
">
                                <div class="clear"></div>
                                <div class="login_box_cz">
                                    <input type="button" value="登 录" id='sublogin' class="login_box_bth2" onclick="check_login('<?php echo smarty_function_url(array('m'=>'login','c'=>'loginsave'),$_smarty_tpl);?>
','vcode_imgs',2);" />
                                </div>
                                <div class="login_box_fw">
                                   <span class="fl">没有账号？ <a href="<?php echo smarty_function_url(array('m'=>'register'),$_smarty_tpl);?>
" class="">注册账号</a></span>
                                    <a href="<?php echo smarty_function_url(array('m'=>'forgetpw'),$_smarty_tpl);?>
" class="fr">忘记密码？</a>
                                </div>
                            </div>
                            <!--其他登录方式-->
                            <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_qqlogin']==1||$_smarty_tpl->tpl_vars['config']->value['sy_sinalogin']==1||$_smarty_tpl->tpl_vars['config']->value['wx_author']==1) {?>
                            <div class="login_other">
                                <div class="login_other_left"><span class="login_other_left_s">其他方式登录</span></div>
                                <div class="login_other_p">
									<?php if ($_smarty_tpl->tpl_vars['config']->value['wx_author']==1) {?>
                                    <a href="<?php echo smarty_function_url(array('m'=>'wxconnect'),$_smarty_tpl);?>
" class=""><i class="l-icon login_weixin-icon"></i></a>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_qqlogin']==1) {?>
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/qqlogin.php" class="png"><i class="l-icon login_qq-icon"></i></a>
                                    <?php }?> <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_sinalogin']==1) {?>
                                    <a href="<?php echo smarty_function_url(array('m'=>'sinaconnect'),$_smarty_tpl);?>
" class=" "><i class="l-icon login_sina-icon"></i></a>
                                    <?php }?> 
                                </div>
                            </div>
                            <?php }?>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <!--banner-->
            <div class="logoin_banner">
                <div class="flexslider">
                    <ul class="slides">
                        <?php  $_smarty_tpl->tpl_vars["lunbo"] = new Smarty_Variable; $_smarty_tpl->tpl_vars["lunbo"]->_loop = false;
global $db,$db_config,$config;$AdArr=array();$paramer=array();$attr=array("classid"=>"37","item"=>"\"lunbo\"","name"=>"'foo'","nocache"=>"")
;
			include(PLUS_PATH.'pimg_cache.php');$add_arr = $ad_label[37];if(is_array($add_arr) && !empty($add_arr)){
				$i=0;$limit = 0;$length = 0;
				foreach($add_arr as $key=>$value){
					if($config['did']){
						if(($value['did']==$config['did']|| $value['did']==-1)&&$value['start']<time()&&$value['end']>time()){
							if($i>0 && $limit==$i){
								break;
							}
							if($length>0){
								$value['name'] = mb_substr($value['name'],0,$length);
							}
							if($paramer['type']!=""){
								if($paramer['type'] == $value['type']){
									$AdArr[] = $value;
								}
							}else{
								$AdArr[] = $value;
							}
							$i++;
						}
						
					}else{
						if(($value['did']==-1 || !$value['did']) && $value['start']<time()&&$value['end']>time()){
							if($i>0 && $limit==$i){
								break;
							}
							if($length>0){
								$value['name'] = mb_substr($value['name'],0,$length);
							}
							if($paramer['type']!=""){
								if($paramer['type'] == $value['type']){
									$AdArr[] = $value;
								}
							}else{
								$AdArr[] = $value;
							}
							$i++;
						}
						
					}
				}
				if (isset($attr['random']) && $attr['random'] && count($AdArr) > $attr['random']) {
			        $temp = [];
			        $random_keys = array_rand($AdArr, $attr['random']);

			        if($attr['random'] == 1) {
			            $temp[] = $AdArr[$attr['random']];
			        } else {
			            foreach ($AdArr as $key => $value) {
			                if (in_array($key, $random_keys)) {
			                    $temp[$key] = $value;
			                }
			            }
			        }
			        $AdArr = $temp;
		        }
			}$AdArr = $AdArr; if (!is_array($AdArr) && !is_object($AdArr)) { settype($AdArr, 'array');}
foreach ($AdArr as $_smarty_tpl->tpl_vars["lunbo"]->key => $_smarty_tpl->tpl_vars["lunbo"]->value) {
$_smarty_tpl->tpl_vars["lunbo"]->_loop = true;
?>
                        <li style="background: url(<?php echo $_smarty_tpl->tpl_vars['lunbo']->value['pic'];?>
) 50% 0 no-repeat;">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['lunbo']->value['src'];?>
" target="_blank" style="display:block;width:100%;height:100%;"></a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="clear"></div>

             <div class="clear"></div>
        <div class="reg_footer">如果您有任何疑问或在登录过程中遇到任何困难，您都可以通过以下方式与我们联系
           <div class="">电话： <?php echo $_smarty_tpl->tpl_vars['config']->value['sy_freewebtel'];?>
 <span class="reg_footer_yz">客服QQ：<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_qq'];?>
</span> </div>
                     </div>
        </div>
        </div>
 		<div id="bind-captcha" data-id='sublogin' data-type='click'></div>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
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
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/js/reg_ajax.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/javascript"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/slides.jquery.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/javascript"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/js/jquery.flexslider.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/javascript"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/js/jcarousellite.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/javascript"><?php echo '</script'; ?>
>
		
		<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/verify/verify_js.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


        <!--[if IE 6]>
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/png.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
>
		DD_belatedPNG.fix('.png,.login_fast,.login_box_tit .login_cur');
		<?php echo '</script'; ?>
>
		<![endif]-->
        <?php echo '<script'; ?>
>
            var sy_login_type = '<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_login_type'];?>
';
			var setval,
				setwout;
            $(document).ready(function() {
                $("#slides").slides({
                    preload: true,
                    preloadImage: '<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/loading.gif',
                    play: 5000,
                    pause: 2500,
                    hoverPause: true
                });

                $("#username,#txt_CheckCode,#usermoblie,#dynamiccode").focus(function() {
                    var txAreaVal = $(this).val();
                    if(txAreaVal == this.defaultValue) {
                        $(this).val("");
                    }
                }).blur(function() {
                    var txAreaVal = $(this).val();
                    if(txAreaVal == this.defaultValue || $(this).val() == "") {
                        $(this).val(this.defaultValue);
                    }
                }).keydown(function(e) {
                    var ev = document.all ? window.event : e;
                    if(ev.keyCode == 13) {
                        check_login('<?php echo smarty_function_url(array('m'=>'login','c'=>'loginsave'),$_smarty_tpl);?>
', 'vcode_imgs');
                    } else {
                        return;
                    }
                });

                $("#password2").focus(function() {
                    $("#password").show();
                    $("#password").focus();
                    $("#password2").hide();
                })
                $("#password").blur(function() {
                    if($("#password").val() == "") {
                        $("#password2").show();
                        $("#password").hide();
                    }
                }).keydown(function(e) {
                    var ev = document.all ? window.event : e;
                    if(ev.keyCode == 13) {
                        check_login('<?php echo smarty_function_url(array('m'=>'login','c'=>'loginsave'),$_smarty_tpl);?>
', 'vcode_imgs');
                    } else {
                        return;
                    }
                });
                
                $('.wxcode_login').click(function(data) {
                    $('.wxcode_login').hide();
                    $('.normal_login').show();
                    $('#login_normal').hide();
                    $('.login_box_h_list').hide();
                    $('.wx_login_show').show();
                    getwxlogincode();
                });
                $('.normal_login').click(function(data) {
                    $('.wxcode_login').show();
                    $('.normal_login').hide();
                    $('#login_normal').show();
                    $('.login_box_h_list').show();
                    $('.wx_login_show').hide();
                    if(setval){
						clearInterval(setval);
						setval = null;
					}
					if(setwout){
						clearTimeout(setwout);
						setwout = null;
					}
                });
                //账号登录和手机登录tab选择
                $('#acount_login').click(function(data) {
                    $('#acount_login').removeClass().addClass('login_box_h_list_cur');
                    $('#mobile_login').removeClass();
                    $('#login_normal_box').show();
                    $('#login_sj_box').hide();
                    $('#login_sjyz_box').hide();
                    $('#act_login').val('0');
					$('#bind-captcha').attr('data-id','sublogin');
                });
                $('#mobile_login').click(function(data) {
                    $('#mobile_login').removeClass().addClass('login_box_h_list_cur');
                    $('#acount_login').removeClass();
                    $('#login_sj_box').show();
                    $('#login_sjyz_box').show();
                    $('#login_normal_box').hide();
                    $('#act_login').val('1');
					$('#bind-captcha').attr('data-id','send_msg_tip');
                });
                if(sy_login_type=='2' && $('#mobile_login')){
                    $('#mobile_login').trigger("click");
                }
            });

            $(window).load(function() {
                $('.flexslider').flexslider({
                    directionNav: true,
                    pauseOnAction: false
                });
            });
			function getwxlogincode(){
				$.post('<?php echo smarty_function_url(array('m'=>'login','c'=>'wxlogin'),$_smarty_tpl);?>
', {
					t: 1
				}, function(data) {
					if(data == 0) {
						$('#wx_login_qrcode').html('二维码获取失败..');
					} else {
						$('#wx_login_qrcode').html('<img src="' + data + '" width="100" height="100">');
						setval = setInterval(function(){
							$.post('<?php echo smarty_function_url(array('m'=>'login','c'=>'getwxloginstatus'),$_smarty_tpl);?>
', {
								t: 1
							}, function(data) {
								var data = eval('(' + data + ')');
								if(data.url != '' && data.msg != '') {
									clearInterval(setval);
									setval = null;
									layer.msg(data.msg, 2, 9, function() {
										window.location.href = data.url;
									});
								} else if(data.url) {
									window.location.href = data.url;
								}
							});
						}, 2000);
						if(setwout){
							clearTimeout(setwout);
							setwout = null;
						}
						setwout = setTimeout(function(){
							clearInterval(setval);
							setval = null;
							var wx_sx = $("#wx_sx").html();
							$('#wx_login_qrcode').html(wx_sx);
						},300*1000);
					}
				});
			}
            
        <?php echo '</script'; ?>
>
           <div style="display:none">   <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
</div><?php }} ?>
