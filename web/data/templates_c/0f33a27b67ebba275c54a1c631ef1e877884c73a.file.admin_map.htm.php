<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 14:52:48
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_map.htm" */ ?>
<?php /*%%SmartyHeaderCode:273762d8f7c01b4080-78187900%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0f33a27b67ebba275c54a1c631ef1e877884c73a' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_map.htm',
      1 => 1634883866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '273762d8f7c01b4080-78187900',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'navigation' => 0,
    'v' => 0,
    'one_menu' => 0,
    'val' => 0,
    'two_menu' => 0,
    'value' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d8f7c070cc92_47154996',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d8f7c070cc92_47154996')) {function content_62d8f7c070cc92_47154996($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<link href="images/reset.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
<link href="images/system.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
<link href="images/table_form.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
<?php echo '<script'; ?>
 language="javascript" type="text/javascript" src="../js/jquery-1.8.0.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
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
<style type="text/css">
.ui_dialog_wrap {
	visibility:hidden
}
.ui_title_icon, .ui_content, .ui_dialog_icon, .ui_btns span {
	display:inline-block;
*zoom:1;
*display:inline
}
.ui_dialog {
	text-align:left;
	position:absolute;
	top:0;
	 background:#fff;
}
.ui_dialog table {
	border:0;
	margin:0;
	border-collapse:collapse
}
.ui_dialog td {
	padding:0
}
.ui_title_icon, .ui_dialog_icon {
	vertical-align:middle;
	_font-size:0
}
.ui_title_text {
	overflow:hidden;
	cursor:default
}
.ui_close {
	display:block;
	position:absolute;
	outline:none
}
.ui_content_wrap {
	text-align:center
}
.ui_content {
	margin:10px;
	text-align:left
}
.ui_iframe .ui_content {
	margin:0;
*padding:0;
	display:block;
	height:100%;
	position:relative
}
.ui_iframe .ui_content iframe {
	border:none;
	overflow:auto
}
.ui_content_mask {
	visibility:hidden;
	width:100%;
	height:100%;
	position:absolute;
	top:0;
	left:0;
	background:#FFF;
	filter:alpha(opacity=0);
	opacity:0
}
.ui_bottom {
	position:relative
}
.ui_resize {
	position:absolute;
	right:0;
	bottom:0;
	z-index:1;
	cursor:nw-resize;
	_font-size:0
}
.ui_btns {
	text-align:right;
	white-space:nowrap
}
.ui_btns span {
	margin:5px 10px
}
.ui_btns button {
	cursor:pointer
}
* .ui_ie6_select_mask {
	position:absolute;
	top:0;
	left:0;
	z-index:-1;
	filter:alpha(opacity=0)
}
.ui_loading .ui_content_wrap {
	position:relative;
	min-width:9em;
	min-height:3.438em
}
.ui_loading .ui_btns {
	display:none
}
.ui_loading_tip {
	visibility:hidden;
	width:5em;
	height:1.2em;
	text-align:center;
	line-height:1.2em;
	position:absolute;
	top:50%;
	left:50%;
	margin:-0.6em 0 0 -2.5em
}
.ui_loading .ui_loading_tip, .ui_loading .ui_content_mask {
	visibility:visible
}
.ui_loading .ui_content_mask {
	filter:alpha(opacity=100);
	opacity:1
}
.ui_move .ui_title_text {
	cursor:move
}
.ui_page_move .ui_content_mask {
	visibility:visible
}
.ui_move_temp {
	visibility:hidden;
	position:absolute;
	cursor:move
}
.ui_move_temp div {
	height:100%
}
html>body .ui_fixed .ui_move_temp {
	position:fixed
}
html>body .ui_fixed .ui_dialog {
	position:fixed
}
* .ui_ie6_fixed {
	background:url(*) fixed
}
* .ui_ie6_fixed body {
	height:100%
}
* html .ui_fixed {
	width:100%;
	height:100%;
	position:absolute;
left:expression(documentElement.scrollLeft+documentElement.clientWidth-this.offsetWidth);
top:expression(documentElement.scrollTop+documentElement.clientHeight-this.offsetHeight)
}
* .ui_page_lock select, * .ui_page_lock .ui_ie6_select_mask {
	visibility:hidden
}
* .ui_page_lock .ui_content select {
	visibility:visible;
}
.ui_overlay {
	visibility:hidden;
	_display:none;
	position:fixed;
	top:0;
	left:0;
	width:100%;
	height:100%;
	filter:alpha(opacity=0);
	opacity:0;
	_overflow:hidden
}
.ui_lock .ui_overlay {
	visibility:visible;
	_display:block
}
.ui_overlay div {
	height:100%
}
* html body {
	margin:0
}
.ui_title{ position:relative}
</style> 
<title></title>
</head>
<body class="body_ifm">
<div class="infoboxp"> 
<div class="infoboxp_top_bg"></div>
  <div class="common-form"> <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['navigation']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
    <table width="100%" bgcolor="#dfdfdf">
      <tr>
        <td height="30" style="padding-left:10px"><strong><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</strong></td>
      </tr>
      <tr>
        <td> <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['one_menu']->value[$_smarty_tpl->tpl_vars['v']->value['id']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
          <table width="100%" bgcolor="#f7f7f7">
            <tr>
              <td height="30" style="padding-left:40px;"><strong><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
</strong></td>
            </tr>
            <tr>
              <td bgcolor="#fdfeff" height="30" style="padding-left:70px;"> <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['two_menu']->value[$_smarty_tpl->tpl_vars['val']->value['id']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
                <div style="float:left; width:100px; height:30px; line-height:30px; "> <a href="javascript:go('<?php echo $_smarty_tpl->tpl_vars['value']->value['url'];?>
')"><?php echo $_smarty_tpl->tpl_vars['value']->value['name'];?>
</a> </div>
                <?php } ?> </td>
            </tr>
            <?php } ?>
          </table></td>
      </tr>
    </table>
    <?php } ?> </div>
</div> 
<?php echo '<script'; ?>
>
function go(url) { 
	window.top.document.getElementById('rightMain').src=url; 
	parent.layer.closeAll();
}
<?php echo '</script'; ?>
>
</body>
</html><?php }} ?>
