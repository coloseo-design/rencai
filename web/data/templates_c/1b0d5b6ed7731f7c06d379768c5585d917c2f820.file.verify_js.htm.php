<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-06 16:20:20
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\default\verify\verify_js.htm" */ ?>
<?php /*%%SmartyHeaderCode:185862c545c4e2adf1-07388433%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1b0d5b6ed7731f7c06d379768c5585d917c2f820' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\default\\verify\\verify_js.htm',
      1 => 1634883836,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '185862c545c4e2adf1-07388433',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c545c4e43268_52305583',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c545c4e43268_52305583')) {function content_62c545c4e43268_52305583($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['config']->value['code_kind']==3) {?>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/geetest/gt.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/geetest/pc.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/javascript"><?php echo '</script'; ?>
>
<?php } elseif ($_smarty_tpl->tpl_vars['config']->value['code_kind']==4) {?>
<?php echo '<script'; ?>
 src="https://cdn.dingxiang-inc.com/ctu-group/captcha-ui/index.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>var dxappid = "<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_dxappid'];?>
";<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/dingxiang/pc.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/javascript"><?php echo '</script'; ?>
>
<?php } elseif ($_smarty_tpl->tpl_vars['config']->value['code_kind']==5) {?>
<?php echo '<script'; ?>
 src="https://v.vaptcha.com/v3.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>var vaptchaid = "<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_vaptcha_vid'];?>
";<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/vaptcha/pc.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/javascript"><?php echo '</script'; ?>
>
<?php }?><?php }} ?>
