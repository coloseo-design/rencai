<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-06 16:22:13
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\crm_manage.htm" */ ?>
<?php /*%%SmartyHeaderCode:1498762c54635e0a1c6-13196043%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ea7af08f0558d100bb2b3dd902467ca5e60bfff5' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\crm_manage.htm',
      1 => 1643012867,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1498762c54635e0a1c6-13196043',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'rows' => 0,
    'v' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c54635e594b4_40680719',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c54635e594b4_40680719')) {function content_62c54635e594b4_40680719($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>

    <link href="images/reset.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css"/>
    <link href="images/system.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css"/>
    <link href="images/table_form.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css"/>
    <link href="images/workspace.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/css/layui.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet"/>

    <?php echo '<script'; ?>
 src="../js/jquery-1.8.0.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="js/admin_public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="js/crm.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>

    <title>后台管理</title>

</head>

<body style="overflow:auto">

<div class="infoboxp">


    <form class='layui-form'>

        <div style="display: flex; justify-content: space-between;">

            <div class="crm_mypre" style="width: 58%;">
                <div class="crm_newly_build_tit_news">
                    <span class="crm_newly_build_tit_n">最新数据</span>
                </div>
                <div class="crm_mypre_datalist_boxn capacity_new">
                    <div class="crm_mypre_datalist">
                        <div class="fz14 panel-banner-box-title"></i>总客户数</div>
                        <div class="fz20"><a href="index.php?m=crm_salesman_list&c=customer_list" class='allNum'>0</a></div>
                    </div>
                    <div class="crm_mypre_datalist">
                      
                        <div class="fz14 panel-banner-box-title"></i>今日新增客户数</div>
                        <div class="fz20"><a href="index.php?m=crm_salesman_list&c=customer_list&reg=1"  class='newNum'>0</a></div>
                    </div>
                    <div class="crm_mypre_datalist">
                       
                        <div class="fz14 panel-banner-box-title"></i>已分配客户数</div>
                        <div class="fz20"><a href="index.php?m=crm_salesman_list&c=customer_list&iscrm=1" class='crmNum'>0</a></div>
                    </div>
                    <div class="crm_mypre_datalist">
                       
                        <div class="fz14 panel-banner-box-title">客户公海</div>
                        <div class="fz20"><a href="index.php?m=crm_customer" class='noCrmNum'>0</a></div>
                    </div>
                    <div class="crm_mypre_datalist">
                      
                        <div class="fz14 panel-banner-box-title">总成交金额</div>
                        <div class="fz20"><a href="index.php?m=crm_audit" class='allPrice'>0</a> </div>
                    </div>
                    <div class="crm_mypre_datalist">
                       
                        <div class="fz14 panel-banner-box-title">今日成交金额</div>
                        <div class="fz20"><a href="index.php?m=crm_audit&time=-1" class='newPrice'>0</a></div>
                    </div>
                    <div class="crm_mypre_datalist">
                        <div class="fz14 panel-banner-box-title">今日跟进</div>
                        <div class="fz20"><a href="index.php?m=crm_concernall&day=1" class='newFollow'>0</a></div>
                    </div>
                </div>
            </div>

            <div class="crm_mypre" style="width:35% ">
                <div class="crm_newly_build_tit_news">
                    <span class="crm_newly_build_tit_n">信息提醒</span>
                </div>
                <div class="crm_mypre_datalist_boxn capacity_new">
                    <div class="crm_mypre_datalist">
                        <div class="fz14 panel-banner-box-title"></i>15天内到期</div>
                        <div class="fz20"><a href="index.php?m=crm_salesman_list&c=customer_list&vipetime=5" class='willDone'>0</a></div>
                    </div>
                    <div class="crm_mypre_datalist">
                        <div class="fz14 panel-banner-box-title">到期未续费</div>
                        <div class="fz20"><a href="index.php?m=crm_salesman_list&c=customer_list&vipetime=4" class='vipDone'>0</a></div>
                    </div>
                    <div class="crm_mypre_datalist">
                      
                        <div class="fz14 panel-banner-box-title">30天未跟进</div>
                        <div class="fz20"><a href="index.php?m=crm_salesman_list&c=customer_list&lastFtime=5" class='needFollow'>0</a></div>
                    </div>

                    <div class="crm_mypre_datalist">
                       
                        <div class="fz14 panel-banner-box-title">从未跟进</div>
                        <div class="fz20"><a href="index.php?m=crm_salesman_list&c=customer_list&lastFtime=1" class='noFollow'>0</a></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="crm_mypre">
            <div class="crm_newly_build_tit">
                <span class="crm_newly_build_tit_n">业务数据</span>
            </div>
            <table width="100%" class="table_form table_form_thr">
                <tr class="admin_comclass_add_list">
                    <td align="left">ID</td>
                    <td align="left">姓名</td>
                    <td align="left">总客户数</td>
                    <td align="left">今日新增</td>
                    <td align="left">今日跟进</td>
                    <td align="left">15日内到期</td>
                    <td align="left">七天内跟进</td>
                    <td align="left">成交客户</td>
                    <td align="left">体验会员</td>
                    <td align="left">到期会员</td>
                </tr>

                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                <tr class="admin_comclass_add_list">
                    <td><?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</td>
                    <td><a href="index.php?m=crm_salesman_list&c=customer_list&auid=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['allNum'];?>
</a></td>
                    <td><a href="index.php?m=crm_salesman_list&c=customer_list&auid=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
&reg=1"><?php echo $_smarty_tpl->tpl_vars['v']->value['newNum'];?>
</a></td>
                    <td><a href="index.php?m=crm_salesman_list&c=customer_list&auid=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
&newF=1"><?php echo $_smarty_tpl->tpl_vars['v']->value['newFollowNum'];?>
</a></td>
                    <td><a href="index.php?m=crm_salesman_list&c=customer_list&auid=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
&vipetime=5"><?php echo $_smarty_tpl->tpl_vars['v']->value['willDoneNum'];?>
</a></td>
                    <td><a href="index.php?m=crm_salesman_list&c=customer_list&auid=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
&recent=1"><?php echo $_smarty_tpl->tpl_vars['v']->value['recentFollowNum'];?>
</a></td>
                    <td><a href="index.php?m=crm_salesman_list&c=customer_list&auid=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
&vip=1"><?php echo $_smarty_tpl->tpl_vars['v']->value['vipNum'];?>
</a></td>
                    <td><a href="index.php?m=crm_salesman_list&c=customer_list&auid=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
&rating=<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_free_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['freeNum'];?>
</a></td>
                    <td><a href="index.php?m=crm_salesman_list&c=customer_list&auid=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
&vipetime=4"><?php echo $_smarty_tpl->tpl_vars['v']->value['vipDoneNum'];?>
</a></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </form>

</div>

<input type="hidden" name="pytoken" id="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
"/>


<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>

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

<?php echo '<script'; ?>
 type="text/javascript">

    var weburl = "<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
";
    var pytoken = $('#pytoken').val();

    layui.use(['form', 'laydate', 'element'], function () {
        var form = layui.form
            , laydate = layui.laydate
            , $ = layui.$
            , element = layui.element;

        $.post('index.php?m=crm_manage&c=getData', {pytoken: pytoken, time: 4}, function (data) {
            if (data) {
                var data = eval('(' + data + ')');

                if(data.allNum){
                    $('.allNum').html(data.allNum);
                }
                if(data.newNum){
                    $('.newNum').html(data.newNum);
                }
                if(data.crmNum){
                    $('.crmNum').html(data.crmNum);
                }
                if(data.noCrmNum){
                    $('.noCrmNum').html(data.noCrmNum);
                }
                if(data.allPrice){
                    $('.allPrice').html(data.allPrice);
                }
                if(data.newPrice){
                    $('.newPrice').html(data.newPrice);
                }
                if(data.newFollow){
                    $('.newFollow').html(data.newFollow);
                }
                if(data.willDone){
                    $('.willDone').html(data.willDone);
                }
                if(data.vipDone){
                    $('.vipDone').html(data.vipDone);
                }
                if(data.needFollow){
                    $('.needFollow').html(data.needFollow);
                }
                if(data.noFollow){
                    $('.noFollow').html(data.noFollow);
                }
            }
        });
    });
<?php echo '</script'; ?>
>

</body>
</html><?php }} ?>
