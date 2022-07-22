<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:10:03
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\member\user\footer.htm" */ ?>
<?php /*%%SmartyHeaderCode:2607962d8fbcb29b3b3-21232059%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c41e7cc47f1c80daf8a29c6970d2acba40c1dd6b' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\member\\user\\footer.htm',
      1 => 1645271398,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2607962d8fbcb29b3b3-21232059',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d8fbcb2ba842_50224306',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d8fbcb2ba842_50224306')) {function content_62d8fbcb2ba842_50224306($_smarty_tpl) {?><div class="clear"></div>

<div class=foot>
    <div class="footernav">
		<div class="footer_bot_p"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webcopyright'];
echo $_smarty_tpl->tpl_vars['config']->value['sy_webrecord'];?>
</div>
        <div class="footer_bot_p">地址:<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webadd'];?>
 电话(Tel):<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_freewebtel'];?>
 EMAIL:<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webemail'];?>
</div>
	</div>
</div>

<div id="uclogin" style="display:none"></div>

<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['temstyle']->value)."/chat/webim.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- layui 当前显示弹出框index-->
<input type='hidden' id="layindex" value="">
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['temstyle']->value)."/member/public/changeutype.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!--邀请好友注册海报-->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['temstyle']->value)."/member/public/invite_reg_hb.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</body>
</html>
<?php }} ?>
