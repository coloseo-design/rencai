<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-22 10:11:14
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\sysnews.htm" */ ?>
<?php /*%%SmartyHeaderCode:39962da0742ae1401-79172331%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '59377c3ae5b6fb83fb50bb3b00265646b4c758b1' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\sysnews.htm',
      1 => 1634883866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '39962da0742ae1401-79172331',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'rows' => 0,
    'key' => 0,
    'v' => 0,
    'total' => 0,
    'pagenum' => 0,
    'pages' => 0,
    'pagenav' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62da0742bd7384_94055810',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62da0742bd7384_94055810')) {function content_62da0742bd7384_94055810($_smarty_tpl) {?><?php if (!is_callable('smarty_function_searchurl')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.searchurl.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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

<div class="admin_new_search_box"> 
 <form action="index.php" name="myform" method="get">
        <input name="m" value="sysnews" type="hidden"/>
	<div class="admin_new_search_name">搜索类型：</div>
    <div class="admin_Filter_text formselect" did='dtype'>
          <input type="button" value="<?php if ($_GET['type']=='2') {?>内容 <?php } else { ?>用户名<?php }?>" class="admin_Filter_but" id="btype">
         <input type="hidden" name="type" id="type" value="<?php if ($_GET['type']) {
echo $_GET['type'];
} else { ?>1<?php }?>"/>
          <div class="admin_Filter_text_box" style="display:none" id='dtype'>
            <ul> 
              <li><a href="javascript:void(0)" onClick="formselect('1','type','用户名')">用户名</a></li>
              <li><a href="javascript:void(0)" onClick="formselect('2','type','内容')">内容</a></li>
            </ul>
          </div>
        </div>
        <input type="text" placeholder="输入你要搜索的关键字" value="<?php echo $_GET['keyword'];?>
" name='keyword' class="admin_Filter_search">
        <input type="submit" name='search'  value="搜索" class="admin_Filter_bth">
	<a  href="javascript:void(0)" onclick="$('.admin_screenlist_box').toggle();"   class="admin_new_search_gj">高级搜索</a>
     <a href="index.php?m=sysnews&c=add" class="admin_new_cz_tj">发送系统消息</a>
     </form>
    <?php echo $_smarty_tpl->getSubTemplate ("admin/admin_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

  </div>
<div class="clear"></div> 
</div>

<div class="tty_table-bom">
  <div class="table-list">
    <div class="admin_table_border">
      <iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
      <form action="index.php" name="myform" method="get" target="supportiframe" id='myform'>
        <input name="m" value="sysnews" type="hidden"/>
        <input name="c" value="del" type="hidden"/>
        <table width="100%">
          <thead>
            <tr class="admin_table_top">
              <th style="width:20px;"><label for="chkall">
                  <input type="checkbox" id='chkAll'  onclick='CheckAll(this.form)'/>
                </label></th>
             
              <th style="width:80px;">
			   <?php if ($_GET['t']=="id"&&$_GET['order']=="asc") {?>
			  <a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'id','m'=>'sysnews','untype'=>'order,t'),$_smarty_tpl);?>
">编号<img src="images/sanj.jpg"/></a>
              <?php } else { ?>
              <a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'id','m'=>'sysnews','untype'=>'order,t'),$_smarty_tpl);?>
">编号<img src="images/sanj2.jpg"/></a>
              <?php }?>
			  </th>
              <th align="left" style="width:150px;">用户名</th>
              <th align="left">内容</th>
              
              <th style="width:150px;">
			  <?php if ($_GET['t']=="ctime"&&$_GET['order']=="asc") {?>
			  <a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'ctime','m'=>'sysnews','untype'=>'order,t'),$_smarty_tpl);?>
">发布时间<img src="images/sanj.jpg"/></a>
              <?php } else { ?>
              <a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'ctime','m'=>'sysnews','untype'=>'order,t'),$_smarty_tpl);?>
">发布时间<img src="images/sanj2.jpg"/></a>
              <?php }?>
			  </th>
              <th style="width:80px;">操作</th>
            </tr>
          </thead>
          <tbody>
          
          <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
          <tr align="center"<?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg"<?php }?> id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
            <td><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"  name='del[]' onclick='unselectall()' rel="del_chk" /></td>
            <td align="left" class="td1" style="text-align:center;"><span><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</span></td>
            <td class="ud" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['username'];?>
</td>
            <td class="td admin_f_state" style="width:750px"align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['content'];?>
</td>
            <td class="td"><?php echo $_smarty_tpl->tpl_vars['v']->value['ctime_n'];?>
</td>
            <td><a href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=sysnews&c=del&del=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" class="admin_new_c_bth admin_new_c_bth_sc">删除</a></td>
          </tr>
          <?php } ?>
          <tr>
          <td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
          <td colspan="6">
          <label for="chkAll2">全选</label>&nbsp;
            <input class="admin_button" type="button" name="delsub" value="删除所选" onClick="return really('del[]')" /></td>
           </tr>
		   <?php if ($_smarty_tpl->tpl_vars['total']->value>$_smarty_tpl->tpl_vars['config']->value['sy_listnum']) {?>
							<tr>
								<?php if ($_smarty_tpl->tpl_vars['pagenum']->value==1) {?>
									<td colspan="3"> 从 1 到 <?php echo $_smarty_tpl->tpl_vars['config']->value['sy_listnum'];?>
 ，总共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</td>
								<?php } elseif ($_smarty_tpl->tpl_vars['pagenum']->value>1&&$_smarty_tpl->tpl_vars['pagenum']->value<$_smarty_tpl->tpl_vars['pages']->value) {?>
									<td colspan="3"> 从 <?php echo ($_smarty_tpl->tpl_vars['pagenum']->value-1)*$_smarty_tpl->tpl_vars['config']->value['sy_listnum']+1;?>
 到 <?php echo $_smarty_tpl->tpl_vars['pagenum']->value*$_smarty_tpl->tpl_vars['config']->value['sy_listnum'];?>
 ，总共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</td>
								<?php } elseif ($_smarty_tpl->tpl_vars['pagenum']->value==$_smarty_tpl->tpl_vars['pages']->value) {?>
									<td colspan="3"> 从 <?php echo ($_smarty_tpl->tpl_vars['pagenum']->value-1)*$_smarty_tpl->tpl_vars['config']->value['sy_listnum']+1;?>
 到 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 ，总共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</td>
								<?php }?>
								<td colspan="3" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</td>
							</tr>
						<?php }?>
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
