<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:39:40
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_member_logout.htm" */ ?>
<?php /*%%SmartyHeaderCode:2255962d902bcdf9b51-76442438%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ae10f8a1ddc5f463a8aaa989dd2a85cc5bfcfe61' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_member_logout.htm',
      1 => 1640333834,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2255962d902bcdf9b51-76442438',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
    'rows' => 0,
    'key' => 0,
    'v' => 0,
    'total' => 0,
    'pagenum' => 0,
    'pages' => 0,
    'pagenav' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d902bcea8743_67498656',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d902bcea8743_67498656')) {function content_62d902bcea8743_67498656($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\modifier.date_format.php';
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
        <?php echo '<script'; ?>
 src="js/admin_public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
        <link href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/css/layui.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet">
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/layui.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/phpyun_layer.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
        <title>后台管理</title>
    </head>

    <body class="body_ifm">      
        <div class="infoboxp">
        <div class="tty-tishi_top">
            <div class="clear"></div>
            <div class="admin_new_search_box">
                <form action="index.php" name="myform" method="get">
                    <input name="m" value="admin_member" type="hidden" />
                    <div class="admin_new_search_name">搜索类型：</div>
                    <div class="admin_Filter_text formselect" did='dkeytype'>
                        <input type="button" <?php if ($_GET['keytype']==''||$_GET['keytype']=='1') {?> value="用户名" <?php } elseif ($_GET['keytype']=='2') {?> value="手机号"<?php } elseif ($_GET['keytype']=='3') {?> value="用户ID" <?php }?> class="admin_Filter_but" id="bkeytype">

                        <input type="hidden" name="type" id="keytype" <?php if ($_GET['keytype']==''||$_GET['keytype']=='1') {?> value="1" <?php } elseif ($_GET['keytype']=='2') {?> value="2" <?php } elseif ($_GET['keytype']=='3') {?> value="3" <?php }?>/>
                        <div class="admin_Filter_text_box" style="display:none" id="dkeytype">
                            <ul>
                                <li>
                                    <a href="javascript:void(0)" onClick="formselect('1','keytype','用户名')">用户名</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" onClick="formselect('2','keytype','手机号')">手机号</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" onClick="formselect('3','keytype','用户ID')">用户ID</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <input type="text" value="" placeholder="请输入你要搜索的关键字" name='keyword' class="admin_new_text">
                    <input type="submit" value="搜索" name='search' class="admin_new_bth">
                </form>
				<a href="javascript:void(0)" onclick="$('.admin_screenlist_box').toggle();" class="admin_new_search_gj">高级搜索</a>
				<?php echo $_smarty_tpl->getSubTemplate ("admin/admin_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

            </div>
            <div class="clear"></div>
		</div>

		<div class="tty_table-bom">
            <div class="table-list">
                <div class="admin_table_border">
                    <iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
                    <form action="index.php?m=admin_member_logout&c=del" target="supportiframe" name="myform" method="post" id='myform'>
						<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
                        <table width="100%">
                            <thead>
                                <tr class="admin_table_top">
                                    <th style="width:20px;">
                                      <label for="chkall"><input type="checkbox" id='chkAll'  onclick='CheckAll(this.form)' /></label>
                                    </th>
                                    <th align="left">用户ID</th>
                                    <th align="left">申请用户名</th>
                                    <th align="left">申请用户类型</th>
                                    <th align="left">申请手机号</th> 
                                    <th align="left">申请时间</th>
                                    <th>状态</th>
                                    <th>操作</th>
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
                                <tr <?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg" <?php }?> id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
                                    <td width="20"><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="check_all" name='del[]' onclick='unselectall()' rel="del_chk" /></td>
                                    <td align="left" class="td1" style="width:60px;"><?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
</td>
                                    <td align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['username'];?>
</td>
                                    <td align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['usertype_name'];?>
</td>
                                    <td align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['tel'];?>
</td>
                                    <td align="left"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['ctime'],"%Y-%m-%d %H:%M");?>
</td>
                                    <td align="center"><?php if ($_smarty_tpl->tpl_vars['v']->value['status']=='2') {?><span class="admin_com_Audited">已处理</span><?php } else { ?><span class="admin_com_Lock">未处理</span><?php }?>
                                    </td>
                                     
                                    <td align="center">
										<?php if ($_smarty_tpl->tpl_vars['v']->value['status']=='1') {?>
                                        <a href="javascript:void(0)" class="admin_new_c_bth admin_new_c_bthsd status" pid="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">处理</a>
										<?php }?>
                                        <a href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=admin_member_logout&c=del&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" class="admin_new_c_bth admin_new_c_bth_sc">删除</a>
                                    </td>
                                </tr>
                                <?php } ?>
                                <tr>
                                <td align="center"><label for="chkall2"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></label></td>
                                    <td colspan="12"><label for="chkAll2">全选</label> &nbsp;
                                        <input class="admin_button" type="button" name="delsub" value="删除所选" onclick="return really('del[]')" />
                                    </td>
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
										<td colspan="10" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</td>
									</tr>
								<?php }?>
                            </tbody>
                        </table>
                        
                    </form>
                </div>
            </div>
        </div>
		</div>
		
        <?php echo '<script'; ?>
 type="text/javascript">
            layui.use(['layer', 'form'], function() {
                var layer = layui.layer,
                    form = layui.form,
                    $ = layui.$;    
            });
            
            $(document).ready(function(){
                $(".status").click(function() {
					var id = $(this).attr("pid"),
						pytoken = $("#pytoken").val();
					layer.confirm("确定同意账号注销？",function(){
						layer.closeAll();
						loadlayer();
						$.post("index.php?m=admin_member_logout&c=status", {id:id,pytoken: pytoken}, function(data) {
							layer.closeAll();
							var data=eval('('+data+')');
							parent.layer.msg(data.msg, Number(data.tm), Number(data.st),function(){location.reload();});return false;
						});
					});
                });
            });
        <?php echo '</script'; ?>
>
    </body>

</html><?php }} ?>
