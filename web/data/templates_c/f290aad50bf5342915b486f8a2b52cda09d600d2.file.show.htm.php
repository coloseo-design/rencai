<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-08 16:16:51
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\default\announcement\show.htm" */ ?>
<?php /*%%SmartyHeaderCode:1513062c7e7f322ace7-33342720%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f290aad50bf5342915b486f8a2b52cda09d600d2' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\default\\announcement\\show.htm',
      1 => 1634883835,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1513062c7e7f322ace7-33342720',
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
    'Info' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c7e7f32a7791_35307254',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c7e7f32a7791_35307254')) {function content_62c7e7f32a7791_35307254($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.url.php';
if (!is_callable('smarty_modifier_date_format')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\modifier.date_format.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
<META name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
">
<META name="description" content="<?php echo $_smarty_tpl->tpl_vars['description']->value;?>
">
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/style/css.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/css">
<!--[if IE 6]>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/png.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
DD_belatedPNG.fix('.png');
<?php echo '</script'; ?>
>
<![endif]--> 
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/style/yun_job_fairs.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/css">
<link href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/style/news.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
</head>
<style>
table[align="center"] { margin: 0 auto; }
table,table tr th, table tr td { border:1px solid #666; }
</style>
<body class="body_bg">
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	<!--content  start-->
	<div class="yun_content">
		<div class="current_Location icon"> 
			您当前的位置：<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
">首页</a> > <a href="<?php echo smarty_function_url(array('m'=>'announcement'),$_smarty_tpl);?>
">网站公告</a> 
		</div>
		<div class="announcement_box">
			<h1 class="announcement_show_tit">
				<?php echo $_smarty_tpl->tpl_vars['Info']->value['title'];?>
<a href="<?php echo smarty_function_url(array('m'=>'announcement'),$_smarty_tpl);?>
" class="announcement_fh">返回公告列表 >></a>
			</h1>
			<div class="announcement_showtime">    <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['Info']->value['startime'],"%Y-%m-%d");?>
 </div>
			
			<div class="announcement_showbox">
				
				<div class="announcement_showp"><?php echo $_smarty_tpl->tpl_vars['Info']->value['content'];?>
</div>
    <div class="zx_ewm" >
          <div class="zx_ewm_img"><img src="<?php echo smarty_function_url(array('m'=>'ajax','c'=>'pubqrcode','toc'=>'announcement','toid'=>$_smarty_tpl->tpl_vars['Info']->value['id']),$_smarty_tpl);?>
" width="150" height="150"></div>
          <div class="zx_ewm_p">微信扫一扫分享资讯</div>
          </div>
			</div>
			
			<div class="announcement_sp">
				<?php if (!empty($_smarty_tpl->tpl_vars['Info']->value['last'])) {?> 
					<div>上一篇： <a title="<?php echo $_smarty_tpl->tpl_vars['Info']->value['last']['title'];?>
" href="<?php echo $_smarty_tpl->tpl_vars['Info']->value['last']['url'];?>
"><?php echo mb_substr($_smarty_tpl->tpl_vars['Info']->value['last']['title'],0,20,'utf-8');?>
</a></div> 
				<?php }?>
				<?php if (!empty($_smarty_tpl->tpl_vars['Info']->value['next'])) {?> 
					<div>下一篇： <a title="<?php echo $_smarty_tpl->tpl_vars['Info']->value['next']['title'];?>
" href="<?php echo $_smarty_tpl->tpl_vars['Info']->value['next']['url'];?>
"><?php echo mb_substr($_smarty_tpl->tpl_vars['Info']->value['next']['title'],0,20,'utf-8');?>
</a> </div>
				<?php }?>
			</div>
		</div>
	</div>
	<!--content  end--> 
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
	<link href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/css/layui.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" /><?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/layui.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
><?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/phpyun_layer.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
> 
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/lazyload.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/public_search/login.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
