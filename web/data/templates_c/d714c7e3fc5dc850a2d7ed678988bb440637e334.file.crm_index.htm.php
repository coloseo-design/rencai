<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-06 16:22:11
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\crm_index.htm" */ ?>
<?php /*%%SmartyHeaderCode:2329562c546339893f9-34872829%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd714c7e3fc5dc850a2d7ed678988bb440637e334' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\crm_index.htm',
      1 => 1643012867,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2329562c546339893f9-34872829',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'month' => 0,
    'pytoken' => 0,
    'time' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c546339defa3_14292997',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c546339defa3_14292997')) {function content_62c546339defa3_14292997($_smarty_tpl) {?><!DOCTYPE htmlPUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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

        <div class="crm_newly_build">
            <div class="crm_newly_build_tit"><span class="crm_newly_build_tit_n">快速新建</span></div>
            <table class="crm_newly_build_table">
                <tr>
                    <td>
                        <div class="crm_newly_build_list crm_newly_build_listkh" id="newCustomer"><i class="crm_newly_build_icon"></i>录用户</div>
                    </td>
                    <td>
                        <div class="crm_newly_build_list crm_newly_build_listgj CrmnewFollow"><i class="crm_newly_build_icon"></i>写跟进</div>
                    </td>
                    <td>
                        <div class="crm_newly_build_list crm_newly_build_listdd" id="newDeal"><i class="crm_newly_build_icon"></i>录订单</div>
                    </td>
                    <td>
                        <div class="crm_newly_build_list crm_newly_build_listrw CrmnewTask"><i class="crm_newly_build_icon"></i>建任务</div>
                    </td>
                    <td>
                        <div class="crm_newly_build_list crm_newly_build_listrz" id="newWorkLog"><i class="crm_newly_build_icon"></i>写日志</div>
                    </td>
                </tr>
            </table>
        </div>

        <div style="display: flex;">
            <div class="crm_left">

                <div class="crm_mypre">
                    <div class="crm_newly_build_tit_news">
                        <span class="crm_newly_build_tit_n">消息提醒</span>
                    </div>

                    <div class="crm_newly_build_body">
                        <div class="crm_msg_tx">
                            <div class="crm_msg_tx_c"><span>今日待跟进</span>
                                <a href="index.php?m=crm_customer&self=1&nextFtime=1" class="crm_msg_tx_n"><span id="todayFollowNum">0</span></a>
                            </div>
                        </div>

                        <div class="crm_msg_tx">
                            <div class="crm_msg_tx_c"><span>过期未续费</span>
                                <a href="index.php?m=crm_customer&self=1&vipetime=5" class="crm_msg_tx_n"><span id="vipedNum">0</span></a>
                            </div>
                        </div>

                        <div class="crm_msg_tx">
                            <div class="crm_msg_tx_c">
                                <span>15天内到期</span>
                                <a href="index.php?m=crm_customer&self=1&vipetime=3" class="crm_msg_tx_n"><span id="willDownNum">0</span></a>
                            </div>
                        </div>

                        <div class="crm_msg_tx">
                            <div class="crm_msg_tx_c"><span>从未跟进</span>
                                <a href="index.php?m=crm_customer&self=1&lastFtime=1" class="crm_msg_tx_n"><span id="noFollowNum">0</span></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="crm_mypre">
                    <div class="crm_newly_build_tit_news">
                        <span class="crm_newly_build_tit_n">释放客户提醒</span>
                    </div>
                    <div class="crm_mytx">
                        <div id="crmHtml"></div>
                    </div>
                </div>

                <div class="crm_mypre">
                    <div class="crm_newly_build_tit_news">
                        <span class="crm_newly_build_tit_n">我的简报</span>

                        <div class="layui-input-inline">
                            <select name="jbtime" lay-filter='jbtime'>
                                <option value="1" <?php if ($_GET['jbtime']==1) {?>selected<?php }?>>今天</option>
                                <option value="2" <?php if ($_GET['jbtime']==2) {?>selected<?php }?>>昨天</option>
                                <option value="3" <?php if ($_GET['jbtime']==3) {?>selected<?php }?>>本周</option>
                                <option value="4" <?php if ($_GET['jbtime']==4||!$_GET['jbtime']) {?>selected<?php }?>>本月</option>
                            </select>
                        </div>
                    </div>

                    <div class="crm_newly_build_body">
                        <div class="crm_mypre_datalist">
                            <div class="fz14 panel-banner-box-title"></i>新增客户</div>
                            <div class="fz20">
                                <?php if ($_GET['jbtime']) {?>
                                    <a href="index.php?m=crm_customer&self=1&jbtime=<?php echo $_GET['jbtime'];?>
" class='newKh'>0</a>
                                <?php } else { ?>
                                    <a href="index.php?m=crm_customer&self=1&jbtime=4" class='newKh'>0</a>
                                <?php }?>
                            </div>
                        </div>
                        <div class="crm_mypre_datalist">
                            <div class="fz14 panel-banner-box-title">联系跟进</div>
                            <div class="fz20">
                                <?php if ($_GET['jbtime']) {?>
                                    <a href="index.php?m=crm_concern&day=<?php echo $_GET['jbtime'];?>
" class='newFollow'>0</a>
                                <?php } else { ?>
                                    <a href="index.php?m=crm_concern&day=4" class='newFollow'>0</a>
                                <?php }?>
                            </div>
                        </div>
                        <div class="crm_mypre_datalist">
                            <div class="fz14 panel-banner-box-title">成交金额</div>
                            <div class="fz20">
                                <a href="index.php?m=crm_my_performance&c=amount" class='totalDealPrice'>0</a>
                            </div>
                        </div>
                        <div class="crm_mypre_datalist">
                            <div class="fz14 panel-banner-box-title">成交订单</div>
                            <div class="fz20">
                                <a href="index.php?m=crm_my_performance&c=amount" class='orderNum'>0</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="crm_right">
                <div class="crm_mypre_ranking_list" style="position: relative; padding-bottom:30px;">
                    <div class="crm_newly_build_tit" style="padding:0px 0px 5px 10px">
                        <span class="crm_newly_build_tit_n">新增客户排行榜<span id="khM" class="data_box"><?php echo $_smarty_tpl->tpl_vars['month']->value;?>
</span></span>
                        <span class="data_boxtime" id="khTime" style="cursor:pointer;"><input type="text" autocomplete="false" placeholder="年月" style="cursor:pointer;"/></span>
                    </div>
                    <div class="crm_space_box crm_space_box_ml">
                        <div class="crm_space_boxtableall" id="khTable">
                            <table class="crm_space_boxtablelist">
                            </table>
                        </div>
                    </div>
                </div>
                <div class="crm_mypre_ranking_list" style="position: relative; padding-bottom:30px;">
                    <div class="crm_newly_build_tit" style="padding:0px 0px 5px 10px">
                        <span class="crm_newly_build_tit_n">月成交金额榜<span id="jeM" class="data_box"><?php echo $_smarty_tpl->tpl_vars['month']->value;?>
</span></span>
                        <span class="data_boxtime" id="jeTime" style="cursor:pointer;"> <input type="text" autocomplete="false" placeholder="年月" style="cursor:pointer;"/></span>
                    </div>
                    <div class="crm_space_box crm_space_box_ml">
                        <div class="crm_space_boxtableall" id="jeTable">
                            <table class="crm_space_boxtablelist">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>

<input type="hidden" name="pytoken" id="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
"/>
<input type="hidden" id="handel_status" value=""/>

<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');"
        style="display:none"></iframe>

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

    var xxUrl = "index.php?m=crm_index&c=getNotice";
    var jbUrl = "index.php?m=crm_index&c=getWorkReport";
    var khbUrl = "index.php?m=crm_index&c=getKhb";
    var jebUrl = "index.php?m=crm_index&c=getJeb";

    var Ytime  = "<?php echo $_smarty_tpl->tpl_vars['time']->value;?>
";

    layui.use(['form', 'laydate', 'element'], function () {
        var form = layui.form
            , element = layui.element
            , laydate = layui.laydate
            , $ = layui.$;

        laydate.render({
            elem: '#khTime'
            , type: 'month'
            , value: Ytime
            , done: function (value, date) {
                $('#khM').html('（'+date.month+'月）');
                Ytime = value;
                $.post(khbUrl, {pytoken: pytoken, time: Ytime}, function (result) {
                    if (result) {
                        var result = eval('(' + result + ')');
                        var data = result.data;
                        var khbHtml = '<table class="crm_space_boxtablelist">';

                        if (data.length > 0) {

                            for (var i = 0; i < data.length; i++) {
                                if(i < 10) {
                                    var j = i + 1;
                                    khbHtml += '<tr>';
                                    khbHtml += '<td style="width: 5%;"> ' + j + '</td>';
                                    khbHtml += '<td> ' + data[i].name + '</td>';
                                    khbHtml += '<td style="width: 10%; text-align: right;"><a href="'+data[i].url+'">' + data[i].khnum + '</a></td>';
                                    khbHtml += '</tr>';
                                }
                            }
                        }
                        khbHtml += '<table>';
                        khbHtml += '<div>';
                        khbHtml += '<span style="color: #707070;position: absolute;right: 20;bottom: 20px;">总计 : '+result.total+'</span>';
                        khbHtml += '</div>';

                        $('#khTable').html(khbHtml);
                    }
                });
            }
        });
        laydate.render({
            elem: '#jeTime'
            , type: 'month'
            , value: Ytime
            , done: function (value, date) {
                $('#jeM').html('（'+date.month+'月）');
                Ytime = value;
                $.post(jebUrl, {pytoken: pytoken, time: Ytime}, function (result) {

                    if (result) {
                        var result = eval('(' + result + ')');
                        var data = result.data;

                        var jebHtml = '<table class="crm_space_boxtablelist">';

                        if (data.length > 0) {

                            for (var i = 0; i < data.length; i++) {
                                if(i < 10) {
                                    var j = i + 1;
                                    jebHtml += '<tr>';
                                    jebHtml += '<td style="width: 5%;"> ' + j + '</td>';
                                    jebHtml += '<td> ' + data[i].name + '</td>';
                                    jebHtml += '<td style="width: 10%; text-align: right;"><a href="'+data[i].url+'">' + data[i].total + '</a></td>';
                                    jebHtml += '</tr>';
                                }
                            }
                        }
                        jebHtml += '</table>';
                        jebHtml += '<div>';
                        jebHtml += '<span style="color: #707070;position: absolute;right: 20;bottom: 20px;">总计 : '+result.total+'</span>';
                        jebHtml += '</div>';

                        $('#jeTable').html(jebHtml);
                    }
                });
            }
        });

        form.on('select(jbtime)', function (data) {
            $.post(jbUrl, {pytoken: pytoken, time: data.value}, function (data) {
                if (data) {
                    var data = eval('(' + data + ')');

                    $('.newFollow').html(data.followNum);
                    $('.newKh').html(data.khNum);
                    $('.totalDealPrice').html(data.orderDealPrice);
                    $('.orderNum').html(data.orderNum);
                }
            });
        });
        $.post(jbUrl, {pytoken: pytoken, time: 4}, function (data) {
            if (data) {
                var data = eval('(' + data + ')');

                $('.newFollow').html(data.followNum);
                $('.newKh').html(data.khNum);
                $('.totalDealPrice').html(data.orderDealPrice);
                $('.orderNum').html(data.orderNum);
            }
        });

        $.post(xxUrl, {pytoken: pytoken}, function (data) {
            if (data) {
                var data = eval('(' + data + ')');


                $('#todayFollowNum').html(data.todayFollowNum);
                $('#vipedNum').html(data.vipedNum);
                $('#willDownNum').html(data.willDoneNum);
                $('#noFollowNum').html(data.noFollowNum);

                if (data.html) {
                    $('#crmHtml').html(data.html);
                }
            }
        });

        $.post(khbUrl, {pytoken: pytoken, time: Ytime}, function (result) {
            if (result) {
                var result = eval('(' + result + ')');
                var data = result.data;
                var khbHtml = '<table class="crm_space_boxtablelist">';

                if (data.length > 0) {

                    for (var i = 0; i < data.length; i++) {
                        if(i < 10) {
                            var j = i + 1;
                            khbHtml += '<tr>';
                            khbHtml += '<td style="width: 5%;"> ' + j + '</td>';
                            khbHtml += '<td> ' + data[i].name + '</td>';
                            khbHtml += '<td style="width: 10%; text-align: right;"><a href="'+data[i].url+'">' + data[i].khnum + '</a></td>';
                            khbHtml += '</tr>';
                        }
                    }
                }
                khbHtml += '</table>';
                khbHtml += '<div>';
                khbHtml += '<span style="color: #707070;position: absolute;right: 20;bottom: 20px;">总计 : '+result.total+'</span>';
                khbHtml += '</div>';

                $('#khTable').html(khbHtml);
            }
        });

        $.post(jebUrl, {pytoken: pytoken, time: Ytime}, function (result) {
            if (result) {
                var result = eval('(' + result + ')');
                var data = result.data;

                var jebHtml = '<table class="crm_space_boxtablelist">';

                if (data.length > 0) {

                    for (var i = 0; i < data.length; i++) {
                        if(i < 10) {
                            var j = i + 1;
                            jebHtml += '<tr>';
                            jebHtml += '<td style="width: 5%;"> ' + j + '</td>';
                            jebHtml += '<td> ' + data[i].name + '</td>';
                            jebHtml += '<td style="width: 10%; text-align: right;"><a href="'+data[i].url+'">' + data[i].total + '</a></td>';
                            jebHtml += '</tr>';
                        }
                    }
                    jebHtml += '</table>';
                    jebHtml += '<div>';
                    jebHtml += '<span style="color: #707070;position: absolute;right: 20;bottom: 20px;">总计 : '+result.total+'</span>';
                    jebHtml += '</div>';
                }

                $('#jeTable').html(jebHtml);
            }
        });

    });
<?php echo '</script'; ?>
>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['adminstyle']->value)."/crm_public.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


</body>

</html><?php }} ?>
