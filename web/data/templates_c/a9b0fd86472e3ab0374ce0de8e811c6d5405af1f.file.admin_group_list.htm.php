<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:41:06
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_group_list.htm" */ ?>
<?php /*%%SmartyHeaderCode:1856462d90312966bc1-96080895%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a9b0fd86472e3ab0374ce0de8e811c6d5405af1f' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_group_list.htm',
      1 => 1634883865,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1856462d90312966bc1-96080895',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'adminusergroup' => 0,
    'v' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d903129d2874_54040694',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d903129d2874_54040694')) {function content_62d903129d2874_54040694($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
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
<?php echo '<script'; ?>
 src="js/admin_public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
<title>后台管理</title>
</head>
<body class="body_ifm">
<div class="infoboxp"> 
<div class="tty-tishi_top"> 
<div class="admin_new_tip">
<a href="javascript:;" class="admin_new_tip_close"></a>
<a href="javascript:;" class="admin_new_tip_open" style="display:none;"></a>
<div class="admin_new_tit"><i class="admin_new_tit_icon"></i>操作提示</div>
<div class="admin_new_tip_list_cont">
<div class="admin_new_tip_list">管理员类型列表：是管理员添加某个网站管理员、分站和CRM用户组后显示在“管理员类型”列表中。</div>
</div>
</div>
<div class="clear"></div>
<div class="admin_new_search_box">
<a href="index.php?m=admin_user&c=addgroup" class="admin_new_cz_tj">+ 添加类型</a>
</div>
<div class="clear"></div>

</div>


<div class="tty_table-bom">
  <div class="table-list">
    <div class="admin_table_border">
      <table width="100%">
        <thead>
          <tr class="admin_table_top">
            <th width="7%">编号</th>
            <th width="12%">类型名称</th>
            <th width="12%">所属分站</th>
            <th width="12%">管理员数</th>
            <th width="12%" class="admin_table_th_bg">操作</th>
          </tr>
        </thead>
        <tbody>
        
        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['adminusergroup']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
        <tr>
          <td align="center" style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</td>
          <td align="center" style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['v']->value['group_name'];?>
</td>
          <td align="center" style="cursor:pointer;"><?php if ($_smarty_tpl->tpl_vars['v']->value['group_type']=='1') {?>普通分组<?php } else { ?>分站管理组<?php }?></td>
           <td align="center" style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['v']->value['num'];?>
</td>
          <td align="center">
			<a href="index.php?m=admin_user&c=addgroup&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="admin_new_c_bth">修改</a>
		    <a href="javascript:void(0);" onClick="layer_del('确定要删除？','index.php?m=admin_user&c=delgroup&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" class="admin_new_c_bth admin_new_c_bth_sc">删除</a>
			</td>
        </tr>
        <?php } ?>
          </tbody>
        
      </table>
    </div>
  </div>
</div>
</div>
	<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
</body>
</html><?php }} ?>
