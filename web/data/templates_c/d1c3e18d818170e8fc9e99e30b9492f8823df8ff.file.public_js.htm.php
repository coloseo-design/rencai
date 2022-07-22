<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-06 16:37:48
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\wap\publichtm\public_js.htm" */ ?>
<?php /*%%SmartyHeaderCode:382262c549dc0631d8-44515518%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd1c3e18d818170e8fc9e99e30b9492f8823df8ff' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\wap\\publichtm\\public_js.htm',
      1 => 1638002046,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '382262c549dc0631d8-44515518',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'wap_style' => 0,
    'config' => 0,
    'config_wapdomain' => 0,
    'uid' => 0,
    'usertype' => 0,
    'navlist' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c549dc08b0f2_46795172',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c549dc08b0f2_46795172')) {function content_62c549dc08b0f2_46795172($_smarty_tpl) {?><?php if (!is_callable('smarty_function_tongji')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.tongji.php';
?><?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['wap_style']->value;?>
/js/jquery.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['wap_style']->value;?>
/js/vue.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
> 
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config_wapdomain']->value;?>
/js/vant/lib/vant.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
> 
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config_wapdomain']->value;?>
/js/vant/phpyun_vant.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
> 
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['wap_style']->value;?>
/js/public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['wapstyle']->value)."/nativeshare.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php if ($_smarty_tpl->tpl_vars['config']->value['sy_spview_web']==1&&$_smarty_tpl->tpl_vars['uid']->value&&($_smarty_tpl->tpl_vars['usertype']->value==1||$_smarty_tpl->tpl_vars['usertype']->value==2)) {?>
<!--邀请视频面试   start-->
<div id="spviewModal" class="none">
	<div class="wapspms_bg"></div>
	<div class="wapspms_show">
		<div class="wapspms_com">
			<div class="wapspms_comlogo"><img id="modalLogo" src=""></div>
			<div class="wapspms_comname" id="modalName"></div>
			<div>邀请你进行视频面试</div>
		</div>
		<div class="wapspms_cz">
			<a href="javascript:void(0);" onclick="closeSp()" class="wapspms_cz_a"><i class="wapspms_cz_icon"></i><div class="wapspms_cz_p">拒绝</div></a>
			<a href="javascript:void(0);" onclick="allowSp()" class="wapspms_cz_a wapspms_cz_aml"><i class="wapspms_cz_icon wapspms_cz_icon_js"></i><div class="wapspms_cz_p">接受</div></a>
		</div>
	</div>
</div>
<!--邀请视频面试   end-->
<?php }?>

<!--底部导航弹出-->
<div id="footerVue" class="none">
	<van-popup v-model="yunfoot" position="bottom" round>
		<footer>
		    <div class="footerbox">
				 <div class="footerbox_tit">
		        <div class="foot_nav_close" @click="yunfoot = false"></div>
		        
		            <div class="foot_nav_chiose_t">请选择</div>
		        </div>
		        <div class="foot_nav_box">
		
		            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['navlist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
					<dl class="index_navlist" style="height:70px;">
						<a href="<?php echo $_smarty_tpl->tpl_vars['v']->value['url_n'];?>
">
							<dt class="index_nav_icon"><image src="<?php echo $_smarty_tpl->tpl_vars['v']->value['pic_n'];?>
" ></image></dt>
							<dd><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</dd>
						</a>
					</dl>
					<?php } ?>
		                        
		        </div>
		    </div>
		</footer>
	</van-popup>
</div>
<?php echo '<script'; ?>
>
var footerVue = new Vue({
        el: '#footerVue',
        data: {
			yunfoot: false
		},
		mounted(){
			document.getElementById('footerVue').style.display = 'block';
		}
	});
<?php echo '</script'; ?>
>

<?php if (!empty($_GET['c'])&&(!in_array($_GET['c'],array('job','resume'))||!empty($_GET['a']))) {?>
<div class='none'><?php echo smarty_function_tongji(array(),$_smarty_tpl);?>
</div>
<?php }?><?php }} ?>
