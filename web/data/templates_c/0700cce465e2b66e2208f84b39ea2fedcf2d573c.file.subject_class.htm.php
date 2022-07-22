<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:41:01
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\subject_class.htm" */ ?>
<?php /*%%SmartyHeaderCode:3023962d9030d8a3713-53557353%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0700cce465e2b66e2208f84b39ea2fedcf2d573c' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\subject_class.htm',
      1 => 1634883865,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3023962d9030d8a3713-53557353',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'id' => 0,
    'position' => 0,
    'key' => 0,
    'v' => 0,
    'onejob' => 0,
    'twojob' => 0,
    'two' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d9030d977837_26345002',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d9030d977837_26345002')) {function content_62d9030d977837_26345002($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
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
<link href="images/reset.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
<link href="images/system.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" /> 
<link href="images/table_form.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
 <title>后台管理</title>
</head>
<body class="body_ifm">
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['adminstyle']->value)."/add_class.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<span id="temp"></span>
<div class="infoboxp">
<div class="tty-tishi_top">	
  <div class="admin_new_search_box">
  <a  href="javascript:void(0)" onClick="add_class('课程分类','450','320','#bname','index.php?m=subject_class&c=save')"  class="admin_new_cz_tj" style="margin-left:0px;">+ 添加类别</a>
	  <?php if ($_smarty_tpl->tpl_vars['id']->value) {?>
	  <a href=" javascript:history.back(-1);" class="admin_new_cz_tj" style="margin-left:0px;"> 返回</a>
	  <?php }?>
  </div>
  <div class="clear"></div></div>

<iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe> 
<div class="tty_table-bom">
<div class="table-list">
<div class="admin_table_border">
<form action="index.php?m=subject_class&c=del" method="post" id='myform' target="supportiframe">  
<table width="100%">
	<thead>
		<tr class="admin_table_top">
		<th width="50"><label for="chkall"> <input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' /></label></th>
		<th>编号</th>
		<th align="left">类别名称<span class="clickup">(点击修改)</span></th>
        <th width="100">类别排序</th>
		<th width="180" class="admin_table_th_bg">操作</th>
	</tr>
	</thead>
	<tbody>	
    <?php if (empty($_smarty_tpl->tpl_vars['id']->value)) {?>
	<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['position']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
	<tr align="center"<?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg"<?php }?> id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
   		<td width="50"><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name='del[]' onclick='unselectall()' rel="del_chk" /></td>
		<td class="ud"><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</td>
		<td class="ud imghide" align="left">一级分类：
        <span onClick="checkname('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" id="name<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</span>
        <input class="input-text hidden" type="text" id="inputname<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"value="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" onBlur="subname('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','index.php?m=subject_class&c=ajax');">
        <img class="" style="padding-left:5px;cursor:pointer;" title="" src="images/xg.png" onClick="checkname('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');"/>
        </td>
        <td class="imghide"><span onClick="checksort('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" id="sort<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['v']->value['sort'];?>
</span>
        <input class="input-text hidden citysort" type="text" id="input<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" size="10" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['sort'];?>
" onBlur="subsort('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','index.php?m=subject_class&c=ajax');"/>
        <img class="" style="padding-left:5px;cursor:pointer;" title="" src="images/xg.png" onClick="checksort('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');"/></td>
		<td class="ud">
            <A href="index.php?m=subject_class&c=up&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="admin_new_c_bth">管理</A>
            <A href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=subject_class&c=del&delid=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" class="admin_new_c_bth admin_new_c_bth_sc">删除</a>
        </td>
	</tr>
    <?php } ?>
    <?php }?>
	<?php if ($_smarty_tpl->tpl_vars['id']->value) {?>
	<tr align="center" id="list<?php echo $_smarty_tpl->tpl_vars['onejob']->value['id'];?>
">
   		<td width="50"><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['onejob']->value['id'];?>
" name='del[]' onclick='unselectall()' rel="del_chk" /></td>
		<td class="ud" width="60"><?php echo $_smarty_tpl->tpl_vars['onejob']->value['id'];?>
</td>
		<td  align="left" class="imghide">一级分类：<span onClick="checkname('<?php echo $_smarty_tpl->tpl_vars['onejob']->value['id'];?>
');" id="name<?php echo $_smarty_tpl->tpl_vars['onejob']->value['id'];?>
" style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['onejob']->value['name'];?>
</span><input class="input-text hidden" type="text" id="inputname<?php echo $_smarty_tpl->tpl_vars['onejob']->value['id'];?>
"value="<?php echo $_smarty_tpl->tpl_vars['onejob']->value['name'];?>
" onBlur="subname('<?php echo $_smarty_tpl->tpl_vars['onejob']->value['id'];?>
','index.php?m=subject_class&c=ajax');">
        <img class="" style="padding-left:5px;cursor:pointer;" title="" src="images/xg.png" onClick="checkname('<?php echo $_smarty_tpl->tpl_vars['onejob']->value['id'];?>
');"/>
        </td>
        <td><span onClick="checksort('<?php echo $_smarty_tpl->tpl_vars['onejob']->value['id'];?>
');" id="sort<?php echo $_smarty_tpl->tpl_vars['onejob']->value['id'];?>
" style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['onejob']->value['sort'];?>
</span><input class="input-text hidden citysort" type="text" id="input<?php echo $_smarty_tpl->tpl_vars['onejob']->value['id'];?>
" size="10" value="<?php echo $_smarty_tpl->tpl_vars['onejob']->value['sort'];?>
" onBlur="subsort('<?php echo $_smarty_tpl->tpl_vars['onejob']->value['id'];?>
','index.php?m=subject_class&c=ajax');"/>
		<img class="" style="padding-left:5px;cursor:pointer;" title="" src="images/xg.png" onClick="checksort('<?php echo $_smarty_tpl->tpl_vars['onejob']->value['id'];?>
');"/>
		</td>
		<td class="ud" width="180"><A href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=subject_class&c=del&delid=<?php echo $_smarty_tpl->tpl_vars['onejob']->value['id'];?>
');" class="admin_new_c_bth admin_new_c_bth_sc">删除</a></td>
	</tr>
	<?php  $_smarty_tpl->tpl_vars['two'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['two']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['twojob']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['two']->key => $_smarty_tpl->tpl_vars['two']->value) {
$_smarty_tpl->tpl_vars['two']->_loop = true;
?>
	<tr align="center" id="list<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
">
    	<td width="50"><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
" name='del[]' onclick='unselectall()' rel="del_chk" /></td>
		<td class="ud"><?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
</td>
		<td  align="left" class="imghide">&nbsp;
       ┗<span onClick="checkname('<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
');" id="name<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
" style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['two']->value['name'];?>
</span>
        <input class="input-text hidden" type="text" id="inputname<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
"value="<?php echo $_smarty_tpl->tpl_vars['two']->value['name'];?>
" onBlur="subname('<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
','index.php?m=subject_class&c=ajax');"/>
		<img class="" style="padding-left:5px;cursor:pointer;" title="" src="images/xg.png" onClick="checkname('<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
');"/>
		</td>
        <td><span onClick="checksort('<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
');" id="sort<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
" style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['two']->value['sort'];?>
</span>
        <input class="input-text hidden citysort" type="text" id="input<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
" size="10" value="<?php echo $_smarty_tpl->tpl_vars['two']->value['sort'];?>
" onBlur="subsort('<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
','index.php?m=subject_class&c=ajax');"/>
		<img class="" style="padding-left:5px;cursor:pointer;" title="" src="images/xg.png" onClick="checksort('<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
');"/>
		</td>
		<td class="ud"><A href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=subject_class&c=del&delid=<?php echo $_smarty_tpl->tpl_vars['two']->value['id'];?>
');"class="admin_new_c_bth admin_new_c_bth_sc">删除</a> </td>
	</tr>
	
	<?php } ?>
	<?php }?>
    <tr>
     <td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
      <td colspan="4">
      <label for="chkAll2">全选</label>&nbsp;
      <input class="admin_button"  type="button" name="delsub" value="删除所选"  onclick="return really('del[]')"/></td>
    </tr>
	</tbody>
</table>
<input type="hidden" name="pytoken" id="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
</form>
</div>
</div>
</div> 
</div> 
</body>
</html><?php }} ?>
