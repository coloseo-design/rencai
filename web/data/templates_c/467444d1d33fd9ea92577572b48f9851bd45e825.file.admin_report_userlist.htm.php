<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-08 16:17:52
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_report_userlist.htm" */ ?>
<?php /*%%SmartyHeaderCode:2477162c7e8308a3ae8-25423928%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '467444d1d33fd9ea92577572b48f9851bd45e825' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_report_userlist.htm',
      1 => 1643012867,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2477162c7e8308a3ae8-25423928',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
    'type' => 0,
    'ut' => 0,
    'userrows' => 0,
    'user' => 0,
    'total' => 0,
    'pagenum' => 0,
    'pages' => 0,
    'pagenav' => 0,
    'q_report' => 0,
    'r' => 0,
    'chat_report' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c7e830b263d7_63529518',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c7e830b263d7_63529518')) {function content_62c7e830b263d7_63529518($_smarty_tpl) {?><?php if (!is_callable('smarty_function_searchurl')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.searchurl.php';
if (!is_callable('smarty_modifier_date_format')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\modifier.date_format.php';
if (!is_callable('smarty_function_url')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.url.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <link href="images/reset.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css"/>
    <link href="images/system.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css"/>
    <link href="images/table_form.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css"/>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
    <link href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/css/layui.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css"/>
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

    <?php echo '<script'; ?>
 type="text/javascript">

        function resultReport(pid, eid, c_uid, result, ut) {

            $("#eid").val(eid);
            $("#c_uid").val(c_uid);
            $("#result").val(result)

            if (parseInt(ut) == 2){
                $("#u_type").val(2);
            }else if(parseInt(ut) == 4){
                $("#u_type").val(4);

            }else{
                $("#u_type").val(1);
            }
            $("#id").val(pid);
            if(ut != 4){
                $(".chatresult").hide();
            }
            if (ut != 2) {
                document.getElementById("ut").style.display = "none";
                $(".plresume").hide();

                add_class('处理结果', '380','auto', '#status_div', '');
            } else {

                add_class('处理结果', '380', '320', '#status_div', '');
            }
        }

        function showbox(title, msg) {
            var pytoken = $("#pytoken").val();
            $.post("index.php?m=report&c=show", {
                id: msg,
                pytoken: pytoken
            }, function (data) {
                data = eval('(' + data + ')');
                $('#showboxmsg').html(data.r_reason);
                $.layer({
                    type: 1,
                    title: title,
                    closeBtn: [0, true],
                    border: [10, 0.3, '#000', true],
                    area: ['350px', '210px'],
                    page: {
                        dom: "#showbox"
                    }
                });
            });
        }

        function resultall() {
            var codewebarr = "";

            $(".check_all:checked").each(function () { //由于复选框一般选中的是多个,所以可以循环输出
                if (codewebarr == "") {
                    codewebarr = $(this).val();
                } else {
                    codewebarr = codewebarr + "," + $(this).val();
                }
            });
            if (codewebarr == "") {
                parent.layer.msg('您还未选择任何信息！', 2, 8);
                return false;
            } else {
                $("input[name=rid]").val(codewebarr);
                $("#result").val('');
                layui.use(['form', 'layer'], function () {
                    var layer = layui.layer,
                        form = layui.form;
                    form.render();
                });
                $.layer({
                    type: 1,
                    title: '批量处理',
                    closeBtn: [0, true],
                    offset: ['100px', ''],
                    border: [10, 0.3, '#000', true],
                    area: ['420px', '250px'],
                    page: {
                        dom: "#status_div2"
                    }
                });
            }
        }

        function resumeall() {
            var codewebarr = "";

            $(".check_all:checked").each(function () { //由于复选框一般选中的是多个,所以可以循环输出
                if (codewebarr == "") {
                    codewebarr = $(this).val();
                } else {
                    codewebarr = codewebarr + "," + $(this).val();
                }
            });
            if (codewebarr == "") {
                parent.layer.msg('您还未选择任何信息！', 2, 8);
                return false;
            } else {
                var pytoken = $("#pytoken").val();
                parent.layer.confirm('删除后将返还回数据或者下载花费，确定要删除吗？', function () {
                    loadlayer();
                    $.post('index.php?m=report&c=delresumeall', {
                        rid: codewebarr,
                        pytoken: pytoken
                    }, function (data) {
                        parent.layer.closeAll();
                        var data = eval('(' + data + ')');
                        parent.layer.msg(data.msg, 2, data.errcode, function () {
                            location.reload();
                        });
                        return false;
                    });
                });
            }
        }
    <?php echo '</script'; ?>
>

    <title>后台管理</title>

</head>
<style>
    .oneLine{
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        line-height: 25px;
        max-height: 25px;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
    }
</style>
<body class="body_ifm">

    <div id="returndiv" style="display:none; width: 350px;">
        <table cellspacing='1' cellpadding='1' class="admin_examine_table">
            <tr>
                <th width='80'>操作人：</th>
                <td align="left" id='returnadmin'></td>
            </tr>
            <tr>
                <th width='80'>操作时间：</th>
                <td align="left" id='returnrtime'></td>
            </tr>
            <tr>
                <th width='80'>处理结果：</th>
                <td align="left" id='returnresult'></td>
            </tr>
        </table>
    </div>

    <div id="status_div" style="display:none;">
        <form action="index.php?m=report&c=saveresult" target="supportiframe" method="post" id="formstatus" name="myform" class="layui-form">
            <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
            <table cellspacing='1' cellpadding='1' class="admin_examine_table">
                <tr id="ut">
                    <th width='80'>返还<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
：</th>
                    <td align="left">
                        <div class="layui-input-block">
                            <input name="datafh" value="1" title="是" type="radio"/>
                            <input name="datafh" value="2" title="否" type="radio"/>
                        </div>
                    </td>
                </tr>
                <tr class="plresume">
                    <th width='80' style="float: right;margin-top: 16px;">批量处理：</th>
                    <td align="left">
                        <div class="layui-input-block">
                            <input name="tongbu" value="1" title="是" type="radio"/>
                            <input name="tongbu" value="2" title="否" type="radio"/>
                        </div>
                        <span class="admin_web_tip">批量处理将同时处理该简历的其他举报信息</span>
                    </td>
                </tr>
                <tr class="chatresult">
                    <th width='80' style="float: right;margin-top: 16px;">解除好友：</th>
                    <td align="left">
                        <div class="layui-input-block">
                            <input name="chatresult" value="1" title="是" type="radio"/>
                            <input name="chatresult" value="2" title="否" type="radio"/>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th width='80' class="t_fl">处理结果：</th>
                    <td align="left"><textarea id="result" name="result" class="admin_explain_textarea"></textarea></td>
                </tr>
                <tr>
                    <td colspan='2' align="center">
                        <div class="mt5">
                            <input name="pid" value="0" id='id' type="hidden">
                            <input name="eid" value="" id='eid' type="hidden">
                            <input name="uid" value="" id='c_uid' type="hidden">
                            <input name="ut" value="" id='u_type' type="hidden">
                            <input type="submit" value='确认' class="admin_examine_bth">
                            <input type="button" onClick="layer.closeAll();" class="admin_examine_bth_qx" value='取消'>
                        </div>
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <div id="status_div2" style="display:none; width: 360px;">
        <form action="index.php?m=report&c=saveresultall" target="supportiframe" method="post" id="formstatus" name="myform" class="layui-form">
            <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
            <table cellspacing='1' cellpadding='1' class="admin_examine_table">
                <tr id="ut">
                    <th width='80'>返还<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
：</th>
                    <td align="left">
                        <div class="layui-input-block">
                            <input name="datafh" value="1" title="是" type="radio"/>
                            <input name="datafh" value="2" title="否" type="radio"/>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th width='80'>处理结果：</th>
                    <td align="left"><textarea id="result" name="result" class="admin_explain_textarea"></textarea></td>
                </tr>
                <tr>
                    <td colspan='2' align="center">
                        <div class="admin_Operating_sub">
                            <input name="rid" value="" id='rid' type="hidden">
                            <input type="submit" value='确认' class="admin_examine_bth">
                            <input type="button" onClick="layer.closeAll();" class="admin_examine_bth_qx" value='取消'>
                        </div>
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <div class="infoboxp">

        <div class="tty-tishi_top">

            <div class="tabs_info">
                <ul>
                    <li <?php if ($_smarty_tpl->tpl_vars['type']->value==0&&$_smarty_tpl->tpl_vars['ut']->value!=2) {?> class="curr" <?php }?>> <a href="index.php?m=report">被举报职位</a></li>
                    <li <?php if ($_smarty_tpl->tpl_vars['type']->value==0&&$_smarty_tpl->tpl_vars['ut']->value==2) {?> class="curr" <?php }?>> <a href="index.php?m=report&ut=2">被举报简历</a></li>
                    <li <?php if ($_smarty_tpl->tpl_vars['type']->value=='1') {?> class="curr" <?php }?>> <a href="index.php?m=report&type=1">被举报问答</a> </li>
                    <li <?php if ($_smarty_tpl->tpl_vars['type']->value=='2') {?> class="curr" <?php }?>> <a href="index.php?m=report&type=2">被投诉顾问</a> </li>
                    <li <?php if ($_smarty_tpl->tpl_vars['type']->value=='3') {?> class="curr" <?php }?>> <a href="index.php?m=report&type=3">校招宣讲会</a> </li>
                    <li <?php if ($_smarty_tpl->tpl_vars['type']->value=='4') {?> class="curr" <?php }?>> <a href="index.php?m=report&type=4">聊天举报</a> </li>
                </ul>
            </div>

            <?php if ($_smarty_tpl->tpl_vars['type']->value==0) {?>

            <div class="admin_new_search_box">
                <form action="index.php" name="myform" method="get">

                    <input name="m" value="report" type="hidden"/>
                    <input name="ut" value="<?php echo $_smarty_tpl->tpl_vars['ut']->value;?>
" type="hidden"/>

                    <div class="admin_new_search_name">搜索类型：</div>

                    <div class="admin_Filter_text formselect" did='df_type'>

                        <input type="button" value="<?php if ($_GET['f_type']=='1'||$_GET['f_type']=='') {
if ($_smarty_tpl->tpl_vars['ut']->value=='2') {?>简历名称<?php } else { ?>职位名称 <?php }
} elseif ($_GET['f_type']=='2') {
if ($_smarty_tpl->tpl_vars['ut']->value=='2') {?>个人姓名<?php } else { ?>企业名称 <?php }
} elseif ($_GET['f_type']=='3') {
if ($_smarty_tpl->tpl_vars['ut']->value=='2') {?>举报企业<?php } else { ?>举报个人<?php }
}?>" class="admin_Filter_but" id="bf_type">

                        <input type="hidden" id='f_type' value="<?php if ($_GET['f_type']) {
echo $_GET['f_type'];
} else { ?>1<?php }?>" name='f_type'>

                        <div class="admin_Filter_text_box" style="display:none" id='df_type'>
                            <ul>
                                <?php if ($_smarty_tpl->tpl_vars['ut']->value=='2') {?>
                                <li><a href="javascript:void(0)" onClick="formselect('1','f_type','简历名称')">简历名称</a></li>
                                <li><a href="javascript:void(0)" onClick="formselect('2','f_type','个人姓名')">个人姓名</a></li>
                                <li><a href="javascript:void(0)" onClick="formselect('3','f_type','举报企业')">举报企业</a></li>
                                <?php } else { ?>
                                <li><a href="javascript:void(0)" onClick="formselect('1','f_type','职位名称')">职位名称</a></li>
                                <li><a href="javascript:void(0)" onClick="formselect('2','f_type','企业名称')">企业名称</a></li>
                                <li><a href="javascript:void(0)" onClick="formselect('3','f_type','举报个人')">举报个人</a></li>
                                <?php }?>
                            </ul>
                        </div>
                    </div>
                    <input class="admin_Filter_search" placeholder="输入你要搜索的关键字" type="text" name="keyword" size="25" style="float:left">
                    <input class="admin_Filter_bth" type="submit" name="qysearch" value="搜索"/>
                </form>
            </div>

            <?php } elseif ($_smarty_tpl->tpl_vars['type']->value=='1') {?>

            <div class="admin_new_search_box">
                <form action="index.php" name="myforms" method="get" id='myforms'>

                    <input name="m" value="report" type="hidden"/>
                    <input name="type" value="1" type="hidden"/>

                    <div class="admin_new_search_name">搜索类型：</div>

                    <div class="admin_Filter_text formselect" did='dp_type'>

                        <input type="button" value="<?php if ($_GET['p_type']=='1'||$_GET['p_type']=='') {?>被举报者<?php } else { ?>举报者<?php }?>" class="admin_Filter_but" id="bp_type">
                        <input type="hidden" id='p_type' value="<?php if ($_GET['p_type']) {
echo $_GET['p_type'];
} else { ?>1<?php }?>" name='p_type'>

                        <div class="admin_Filter_text_box" style="display:none" id='dp_type'>
                            <ul>
                                <li><a href="javascript:void(0)" onClick="formselect('1','p_type','被举报者')">被举报者</a></li>
                                <li><a href="javascript:void(0)" onClick="formselect('2','p_type','举报者')">举报者</a></li>
                            </ul>
                        </div>
                    </div>

                    <input class="admin_Filter_search" placeholder="输入你要搜索的关键字" type="text" name="keyword" size="25" style="float:left">
                    <input class="admin_Filter_bth" type="submit" name="comquestion" value="检索"/>
                    <input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
                </form>
            </div>

            <?php } elseif ($_smarty_tpl->tpl_vars['type']->value=='2') {?>

            <div class="admin_new_search_box">
                <form action="index.php" name="myforms" method="get" id='myforms'>

                    <input name="m" value="report" type="hidden"/>
                    <input name="type" value="2" type="hidden"/>

                    <div class="admin_new_search_name">搜索类型：</div>

                    <div class="admin_Filter_text formselect" did='dp_type'>
                        <input type="button"
                               value="<?php if ($_GET['p_type']=='1'||$_GET['p_type']=='') {?>被投诉者<?php } else { ?>投诉者<?php }?>"
                               class="admin_Filter_but" id="bp_type">
                        <input type="hidden" id='p_type'
                               value="<?php if ($_GET['p_type']) {
echo $_GET['p_type'];
} else { ?>1<?php }?>"
                               name='p_type'>
                        <div class="admin_Filter_text_box" style="display:none" id='dp_type'>
                            <ul>
                                <li><a href="javascript:void(0)" onClick="formselect('1','p_type','被投诉者')">被投诉者</a></li>
                                <li><a href="javascript:void(0)" onClick="formselect('2','p_type','投诉者')">投诉者</a></li>
                            </ul>
                        </div>
                    </div>
                    <input class="admin_Filter_search" placeholder="输入你要搜索的关键字" type="text" name="keyword" size="25"
                           style="float:left">
                    <input class="admin_Filter_bth" type="submit" name="comquestion" value="检索"/>
                    <input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
                </form>
            </div>

            <?php } elseif ($_smarty_tpl->tpl_vars['type']->value=='3') {?>

            <div class="admin_new_search_box">
                <form action="index.php" name="myforms" method="get" id='myforms'>
                    <input name="m" value="report" type="hidden"/>
                    <input name="type" value="3" type="hidden"/>
                    <input class="admin_Filter_search" placeholder="输入你要搜索的关键字" type="text" name="keyword" size="25" style="float:left">
                    <input class="admin_Filter_bth" type="submit" value="检索"/>
                    <input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
                </form>
            </div>
            <?php } elseif ($_smarty_tpl->tpl_vars['type']->value=='4') {?>

            <div class="admin_new_search_box">
                <form action="index.php" name="myforms" method="get" id='myforms'>

                    <input name="m" value="report" type="hidden"/>
                    <input name="type" value="4" type="hidden"/>

                    <div class="admin_new_search_name">搜索类型：</div>

                    <div class="admin_Filter_text formselect" did='dp_type'>

                        <input type="button" value="<?php if ($_GET['p_type']=='1'||$_GET['p_type']=='') {?>被举报者<?php } else { ?>举报者<?php }?>" class="admin_Filter_but" id="bp_type">
                        <input type="hidden" id='p_type' value="<?php if ($_GET['p_type']) {
echo $_GET['p_type'];
} else { ?>1<?php }?>" name='p_type'>

                        <div class="admin_Filter_text_box" style="display:none" id='dp_type'>
                            <ul>
                                <li><a href="javascript:void(0)" onClick="formselect('1','p_type','被举报者')">被举报者</a></li>
                                <li><a href="javascript:void(0)" onClick="formselect('2','p_type','举报者')">举报者</a></li>
                            </ul>
                        </div>
                    </div>

                    <input class="admin_Filter_search" placeholder="输入你要搜索的关键字" type="text" name="keyword" size="25" style="float:left">
                    <input class="admin_Filter_bth" type="submit" name="comquestion" value="检索"/>
                    <input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
                </form>
            </div>
            <?php }?>
        </div>

        <div class="clear"></div>

        <?php if ($_smarty_tpl->tpl_vars['type']->value==0) {?>
        <div class="tty_table-bom">
            <div class="table-list">
                <div class="admin_table_border">
                    <form action="index.php" name="myform" method="get" target="supportiframe" id='myform'>

                        <input name="m" value="report" type="hidden"/>
                        <input name="c" value="del" type="hidden"/>

                        <table width="100%">
                            <thead>
                            <tr class="admin_table_top">
                                <th style="width:20px;">
                                    <label for="chkall"><input type="checkbox" id='chkAll' onclick='CheckAll(this.form)'/></label>
                                </th>
                                <?php if ($_GET['t']=="id"&&$_GET['order']=="asc") {?>
                                <th align="left"><a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'id','m'=>'report','untype'=>'order,t'),$_smarty_tpl);?>
">ID<img src="images/sanj.jpg"/></a></th>
                                <?php } else { ?>
                                <th align="left"><a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'id','m'=>'report','untype'=>'order,t'),$_smarty_tpl);?>
">ID<img src="images/sanj2.jpg"/></a></th>
                                <?php }?>

                                <th align="left" style="width:180px;"><?php if ($_smarty_tpl->tpl_vars['ut']->value==2) {?>简历名称<?php } else { ?>职位名称<?php }?></th>

                                <th align="left" style="width:150px;"><?php if ($_smarty_tpl->tpl_vars['ut']->value==2) {?>被举报个人<?php } else { ?>被举报企业<?php }?></th>

                                <th align="left" style="width:150px;"><?php if ($_smarty_tpl->tpl_vars['ut']->value==2) {?>举报企业<?php } else { ?>举报个人<?php }?></th>

                                <?php if ($_GET['t']=="inputtime"&&$_GET['order']=="asc") {?>
                                <th align="left"><a href="<?php echo smarty_function_searchurl(array('order'=>'desc','ut'=>$_smarty_tpl->tpl_vars['ut']->value,'t'=>'inputtime','m'=>'report','untype'=>'order,t,ut'),$_smarty_tpl);?>
">举报时间<img src="images/sanj.jpg"/></a></th>
                                <?php } else { ?>
                                <th align="left"><a href="<?php echo smarty_function_searchurl(array('order'=>'asc','ut'=>$_smarty_tpl->tpl_vars['ut']->value,'t'=>'inputtime','m'=>'report','untype'=>'order,t,ut'),$_smarty_tpl);?>
">举报时间<img src="images/sanj2.jpg"/></a></th>
                                <?php }?>
                                <th align="left" style="width:150px;">举报理由</th>
                                <th align="center" style="width: 100px;">状态</th>
                                <th class="admin_table_th_bg" style="width:230px;">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php  $_smarty_tpl->tpl_vars['user'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['user']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['userrows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['user']->key => $_smarty_tpl->tpl_vars['user']->value) {
$_smarty_tpl->tpl_vars['user']->_loop = true;
?>
                            <tr align="center" id="list<?php echo $_smarty_tpl->tpl_vars['user']->value['id'];?>
">
                                <td><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['user']->value['id'];?>
" class="check_all" name='del[]' onclick='unselectall()' rel="del_chk"/></td>
                                <td align="left"><?php echo $_smarty_tpl->tpl_vars['user']->value['id'];?>
</td>
                                <td align="left">
									<?php if ($_smarty_tpl->tpl_vars['ut']->value==2) {?>
									<a class="admin_cz_sc resume-preview" href="javascript:void(0);" pid="<?php echo $_smarty_tpl->tpl_vars['user']->value['eid'];?>
"><?php echo mb_substr($_smarty_tpl->tpl_vars['user']->value['name'],0,20,'utf-8');?>
</a>
									<div>
                                        简历编号：<?php echo $_smarty_tpl->tpl_vars['user']->value['eid'];?>

                                    </div>
									<?php } else { ?>
									<a href="<?php echo $_smarty_tpl->tpl_vars['user']->value['url'];?>
&look=admin" target="_blank" class="admin_cz_sc"><?php echo mb_substr($_smarty_tpl->tpl_vars['user']->value['name'],0,20,'utf-8');?>
</a>
									<div>
										职位编号：<?php echo $_smarty_tpl->tpl_vars['user']->value['eid'];?>

									</div>
									<?php }?>
                                </td>

                                <td align="left">
                                    <div class="admin_new_sj"><?php echo $_smarty_tpl->tpl_vars['user']->value['c_mobile'];?>
</div>
                                    <div class="oneLine" title="<?php echo $_smarty_tpl->tpl_vars['user']->value['r_name'];?>
"><?php echo mb_substr($_smarty_tpl->tpl_vars['user']->value['r_name'],0,20,'utf-8');?>
</div>
                                    <div>UID：<?php echo $_smarty_tpl->tpl_vars['user']->value['c_uid'];?>
</div>
                                </td>
                                <td align="left">
                                    <div class="admin_new_sj"><?php echo $_smarty_tpl->tpl_vars['user']->value['p_mobile'];?>
</div>
                                    <div class="oneLine" title="<?php echo $_smarty_tpl->tpl_vars['user']->value['p_name'];?>
"><?php echo mb_substr($_smarty_tpl->tpl_vars['user']->value['p_name'],0,20,'utf-8');?>
</div>
                                    <div>UID：<?php echo $_smarty_tpl->tpl_vars['user']->value['p_uid'];?>
</div>
                                </td>
                                <td align="left"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['user']->value['inputtime'],"%Y-%m-%d %H:%M");?>
</td>
                                <td align="left">
                                    <div><?php echo $_smarty_tpl->tpl_vars['user']->value['r_reason'];?>
</div>
                                </td>

                                <td align="center">
                                    <?php echo $_smarty_tpl->tpl_vars['user']->value['status_n'];?>

                                </td>

                                <td width="180">
                                    <a href="javascript:void(0)" onclick="resultReport('<?php echo $_smarty_tpl->tpl_vars['user']->value['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['user']->value['eid'];?>
','<?php echo $_smarty_tpl->tpl_vars['user']->value['c_uid'];?>
','<?php echo $_smarty_tpl->tpl_vars['user']->value['result'];?>
','<?php echo $_GET['ut'];?>
')" class="admin_new_c_bth check">处理</a>
                                    <a href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=report&c=del&del=<?php echo $_smarty_tpl->tpl_vars['user']->value['id'];?>
');" class="admin_new_c_bth admin_new_c_bth_sc mt5">删除</a>

                                    <?php if ($_smarty_tpl->tpl_vars['ut']->value==2) {?>
                                    <br>
                                    <a href="javascript:void(0)" onClick="layer_del('删除后将返还回数据或者下载花费，确定要删除吗？', 'index.php?m=report&c=delresume&id=<?php echo $_smarty_tpl->tpl_vars['user']->value['id'];?>
&eid=<?php echo $_smarty_tpl->tpl_vars['user']->value['eid'];?>
&uid=<?php echo $_smarty_tpl->tpl_vars['user']->value['c_uid'];?>
');" class="admin_new_c_bth admin_new_c_bth_sc">简历</a>
                                    <a href="javascript:void(0)" onClick="layer_del('批量删除将会删除该简历的所有举报 , 确定要删除吗？', 'index.php?m=report&c=del&type=pldel&del=<?php echo $_smarty_tpl->tpl_vars['user']->value['id'];?>
');" class="admin_new_c_bth admin_new_c_bth_sc mt5">批量</a>
                                    <?php }?>
                                </td>
                            </tr>
                            <?php } ?>

                            <tr>
                                <td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)'/></td>
                                <td colspan="9">
                                    <label for="chkAll2">全选</label>
                                    <input class="admin_button" type="button" name="delsub" value="删除所选" onclick="return really('del[]')"/>
                                    <?php if ($_smarty_tpl->tpl_vars['ut']->value==2) {?>
                                    <input class="admin_button" type="button" name="delsub" value="批量处理" onclick="resultall()"/>
                                    <input class="admin_button" type="button" name="delsub" value="批量简历" onclick="resumeall()"/>
                                    <?php }?>
                                </td>
                            </tr>
                            <?php if ($_smarty_tpl->tpl_vars['total']->value>$_smarty_tpl->tpl_vars['config']->value['sy_listnum']) {?>
                            <tr>
                                <?php if ($_smarty_tpl->tpl_vars['pagenum']->value==1) {?>
                                <td colspan="3"> 从 1 到 <?php echo $_smarty_tpl->tpl_vars['config']->value['sy_listnum'];?>
 ，总共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</td><?php } elseif ($_smarty_tpl->tpl_vars['pagenum']->value>1&&$_smarty_tpl->tpl_vars['pagenum']->value<$_smarty_tpl->tpl_vars['pages']->value) {?>
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
                                <td colspan="6" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</td>
                            </tr>
                            <?php }?>
                            </tbody>
                        </table>
                        <input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
                    </form>
                </div>
            </div>
        </div>

        <?php } elseif ($_smarty_tpl->tpl_vars['type']->value=='1') {?>

        <div class="tty_table-bom">
            <div class="table-list">
                <div class="admin_table_border">
                    <form action="index.php" name="myform" method="get" id='myform' target="supportiframe">

                        <input name="m" value="report" type="hidden"/>
                        <input name="c" value="del" type="hidden"/>

                        <table width="100%">
                            <thead>
                            <tr class="admin_table_top">
                                <th><label for="chkall"><input type="checkbox" id='chkAll' onclick='CheckAll(this.form)'/></label></th>
                                <th align="left">
                                    <?php if ($_GET['t']=="id"&&$_GET['order']=="asc") {?>
                                    <a href="<?php echo smarty_function_searchurl(array('type'=>1,'order'=>'desc','t'=>'id','m'=>'report','untype'=>'order,t,type'),$_smarty_tpl);?>
">编号<img src="images/sanj.jpg"/></a>
                                    <?php } else { ?>
                                    <a href="<?php echo smarty_function_searchurl(array('type'=>1,'order'=>'asc','t'=>'id','m'=>'report','untype'=>'order,t,type'),$_smarty_tpl);?>
">编号<img src="images/sanj2.jpg"/></a>
                                    <?php }?>
                                </th>
                                <th align="left">被举报者</th>
                                <th align="left">举报者</th>
                                <th align="left">举报问题</th>
                                <th align="left">举报原因</th>
                                <th>
                                    <?php if ($_GET['t']=="inputtime"&&$_GET['order']=="asc") {?>
                                    <a href="<?php echo smarty_function_searchurl(array('type'=>1,'order'=>'desc','t'=>'inputtime','m'=>'report','untype'=>'order,t,type'),$_smarty_tpl);?>
">举报时间<img src="images/sanj.jpg"/></a>
                                    <?php } else { ?>
                                    <a href="<?php echo smarty_function_searchurl(array('type'=>1,'order'=>'asc','t'=>'inputtime','m'=>'report','untype'=>'order,t,type'),$_smarty_tpl);?>
">举报时间<img src="images/sanj2.jpg"/></a>
                                    <?php }?>
                                </th>
                                <th>状态</th>

                                <th class="admin_table_th_bg">操作</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['q_report']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value) {
$_smarty_tpl->tpl_vars['r']->_loop = true;
?>
                            <tr align="center" id="list<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
">
                                <td><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
" name='del[]' onclick='unselectall()' rel="del_chk"/></td>
                                <td align="left" ><span><?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
</span></td>
                                <td align="left"><?php echo $_smarty_tpl->tpl_vars['r']->value['r_name'];?>
</td>
                                <td align="left"><?php echo $_smarty_tpl->tpl_vars['r']->value['username'];?>
</td>
                                <td align="left">
                                    <?php if ($_smarty_tpl->tpl_vars['r']->value['is_del']) {?>
                                    <font color="red"><?php echo $_smarty_tpl->tpl_vars['r']->value['is_del'];?>
</font>
                                    <?php } elseif ($_smarty_tpl->tpl_vars['r']->value['status']!=1) {?>
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['r']->value['url'];?>
" target="_blank"><?php echo mb_substr($_smarty_tpl->tpl_vars['r']->value['title'],0,20,'utf-8');?>
</a>
                                    <?php } else { ?>
                                    <a href="<?php echo smarty_function_url(array('m'=>'ask','c'=>'content','id'=>$_smarty_tpl->tpl_vars['r']->value['eid']),$_smarty_tpl);?>
" target="_blank"><?php echo mb_substr($_smarty_tpl->tpl_vars['r']->value['title'],0,20,'utf-8');?>
</a>
                                    <?php }?>
                                </td>

                                <td align="left"><?php echo $_smarty_tpl->tpl_vars['r']->value['reason'];?>
</td>
                                <td class="td"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['r']->value['inputtime'],"%Y-%m-%d %H:%M");?>
</td>
                                <td>
                                    <?php echo $_smarty_tpl->tpl_vars['r']->value['status_n'];?>

                                </td>
                                <td>
                                    <?php if (!$_smarty_tpl->tpl_vars['r']->value['is_del']) {?>
                                    <a href="index.php?m=admin_question&c=<?php echo $_smarty_tpl->tpl_vars['r']->value['c'];?>
&id=<?php echo $_smarty_tpl->tpl_vars['r']->value['eid'];?>
&back_url=1" class="admin_new_c_bth">修改</a>
                                    <?php }?>
                                    <a href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=report&c=del&del=<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
');" class="admin_new_c_bth admin_new_c_bth_sc">问答</a>
                                    <br>
                                    <a href="javascript:void(0)" onclick="resultReport('<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['r']->value['result'];?>
')" class="admin_new_c_bth admin_new_c_bthsh check mt5">处理</a>
                                    <?php if (!$_smarty_tpl->tpl_vars['r']->value['is_del']) {?>
                                    <a href="javascript:void(0)" onClick="layer_del('确定要删除问答？', 'index.php?m=report&c=delquestion&del=<?php echo $_smarty_tpl->tpl_vars['r']->value['eid'];?>
');" class="admin_new_c_bth admin_new_c_bth_sc">删除</a>
                                    <?php }?>
                                </td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)'/></td>
                                <td colspan="9">
                                    <label for="chkAll2">全选</label>&nbsp;
                                    <input class="admin_button" type="button" name="delsub" value="删除所选" onClick="return really('del[]')"/>
                                </td>
                            </tr>
                            <?php if ($_smarty_tpl->tpl_vars['total']->value>$_smarty_tpl->tpl_vars['config']->value['sy_listnum']) {?>
                            <tr>
                                <?php if ($_smarty_tpl->tpl_vars['pagenum']->value==1) {?>
                                <td colspan="3"> 从 1 到 <?php echo $_smarty_tpl->tpl_vars['config']->value['sy_listnum'];?>
 ，总共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</td><?php } elseif ($_smarty_tpl->tpl_vars['pagenum']->value>1&&$_smarty_tpl->tpl_vars['pagenum']->value<$_smarty_tpl->tpl_vars['pages']->value) {?>
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
                                <td colspan="7" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</td>
                            </tr>
                            <?php }?>

                            </tbody>
                        </table>
                        <input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
                    </form>
                </div>
            </div>
        </div>

        <?php } elseif ($_smarty_tpl->tpl_vars['type']->value=='2') {?>

        <div class="tty_table-bom">
            <div class="table-list">
                <div class="admin_table_border">
                    <form action="index.php" name="myform" method="get" id='myform' target="supportiframe">

                        <input name="m" value="report" type="hidden"/>
                        <input name="c" value="del" type="hidden"/>

                        <table width="100%">
                            <thead>
                            <tr class="admin_table_top">
                                <th><label for="chkall"><input type="checkbox" id='chkAll' onclick='CheckAll(this.form)'/></label></th>
                                <th align="left">
                                    <?php if ($_GET['t']=="id"&&$_GET['order']=="asc") {?>
                                    <a href="<?php echo smarty_function_searchurl(array('type'=>2,'order'=>'desc','t'=>'id','m'=>'report','untype'=>'order,t,type'),$_smarty_tpl);?>
">编号<img src="images/sanj.jpg"/></a>
                                    <?php } else { ?>
                                    <a href="<?php echo smarty_function_searchurl(array('type'=>2,'order'=>'asc','t'=>'id','m'=>'report','untype'=>'order,t,type'),$_smarty_tpl);?>
">编号<img src="images/sanj2.jpg"/></a>
                                    <?php }?>
                                </th>
                                <th align="left">顾问信息</th>
                                <th align="left">企业信息</th>
                                <th align="left">投诉内容</th>
                                <th>
                                    <?php if ($_GET['t']=="inputtime"&&$_GET['order']=="asc") {?>
                                    <a href="<?php echo smarty_function_searchurl(array('type'=>2,'order'=>'desc','t'=>'inputtime','m'=>'report','untype'=>'order,t,type'),$_smarty_tpl);?>
">投诉时间<img src="images/sanj.jpg"/></a>
                                    <?php } else { ?>
                                    <a href="<?php echo smarty_function_searchurl(array('type'=>2,'order'=>'asc','t'=>'inputtime','m'=>'report','untype'=>'order,t,type'),$_smarty_tpl);?>
">投诉时间<img src="images/sanj2.jpg"/></a>
                                    <?php }?>
                                </th>
                                <th align="left">状态</th>

                                <th width="150" class="admin_table_th_bg">操作</th>
                            </tr>
                            </thead>

                            <tbody>

                            <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['q_report']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value) {
$_smarty_tpl->tpl_vars['r']->_loop = true;
?>
                            <tr align="center" id="list<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
">
                                <td><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
" name='del[]' onclick='unselectall()' rel="del_chk"/></td>
                                <td align="left" class="td1"><span><?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
</span></td>
                                <td align="left"><?php echo $_smarty_tpl->tpl_vars['r']->value['r_name'];?>
</td>
                                <td align="left"><?php echo $_smarty_tpl->tpl_vars['r']->value['username'];?>
</td>
                                <td align="left">
                                    <?php echo mb_substr($_smarty_tpl->tpl_vars['r']->value['r_reason'],0,45,"utf-8");?>

                                    <?php if (strlen($_smarty_tpl->tpl_vars['r']->value['r_reason'])>45) {?>
                                    <a href="javascript:void(0);" onclick="showbox('评论内容','<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
')" class="admin_cz_sc">[更多]</a>
                                    <?php }?>
                                </td>
                                <td class="td"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['r']->value['inputtime'],"%Y-%m-%d %H:%M");?>
</td>
                                <td align="left"><?php echo $_smarty_tpl->tpl_vars['r']->value['status_n'];?>
</td>
                                <td>
                                    <a href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=report&c=del&del=<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
');" class="admin_new_c_bth admin_new_c_bth_sc">删除</a>
                                    <a href="javascript:void(0)" onclick="resultReport('<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['r']->value['result'];?>
')" class="admin_new_c_bth admin_new_c_bthsh check">处理</a>
                                </td>

                            </tr>
                            <?php } ?>
                            <tr>
                                <td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)'/></td>
                                <td colspan="9">
                                    <label for="chkAll2">全选</label>&nbsp;
                                    <input class="admin_button" type="button" name="delsub" value="删除所选" onClick="return really('del[]')"/>
                                </td>
                            </tr>
                            <?php if ($_smarty_tpl->tpl_vars['total']->value>$_smarty_tpl->tpl_vars['config']->value['sy_listnum']) {?>
                            <tr>
                                <?php if ($_smarty_tpl->tpl_vars['pagenum']->value==1) {?>
                                <td colspan="3"> 从 1 到 <?php echo $_smarty_tpl->tpl_vars['config']->value['sy_listnum'];?>
 ，总共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</td><?php } elseif ($_smarty_tpl->tpl_vars['pagenum']->value>1&&$_smarty_tpl->tpl_vars['pagenum']->value<$_smarty_tpl->tpl_vars['pages']->value) {?>
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
                                <td colspan="5" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</td>
                            </tr>
                            <?php }?>
                            </tbody>
                        </table>
                        <input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
                    </form>
                </div>
            </div>
        </div>

        <?php } elseif ($_smarty_tpl->tpl_vars['type']->value=='3') {?>

        <div class="tty_table-bom">
            <div class="table-list">
                <div class="admin_table_border">
                    <form action="index.php" name="myform" method="get" id='myform' target="supportiframe">

                        <input name="m" value="report" type="hidden"/>
                        <input name="c" value="del" type="hidden"/>

                        <table width="100%">
                            <thead>
                            <tr class="admin_table_top">
                                <th><label for="chkall"><input type="checkbox" id='chkAll' onclick='CheckAll(this.form)'/></label></th>
                                <th width="60">
                                    <?php if ($_GET['t']=="id"&&$_GET['order']=="asc") {?>
                                    <a href="<?php echo smarty_function_searchurl(array('type'=>3,'order'=>'desc','t'=>'id','m'=>'report','untype'=>'order,t,type'),$_smarty_tpl);?>
">编号<img src="images/sanj.jpg"/></a>
                                    <?php } else { ?>
                                    <a href="<?php echo smarty_function_searchurl(array('type'=>3,'order'=>'asc','t'=>'id','m'=>'report','untype'=>'order,t,type'),$_smarty_tpl);?>
">编号<img src="images/sanj2.jpg"/></a>
                                    <?php }?>
                                </th>
                                <th align="left">纠错者</th>
                                <th align="left">纠错内容</th>
                                <th align="left">纠错时间</th>
                                <th align="left">处理结果</th>
                                <th width="150" class="admin_table_th_bg">操作</th>
                            </tr>
                            </thead>

                            <tbody>

                            <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['q_report']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value) {
$_smarty_tpl->tpl_vars['r']->_loop = true;
?>
                            <tr align="center" id="list<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
">
                                <td><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
" name='del[]' onclick='unselectall()' rel="del_chk"/></td>
                                <td align="center" class="td1"><span><?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
</span></td>
                                <td align="left"><?php echo $_smarty_tpl->tpl_vars['r']->value['username'];?>
</td>
                                <td align="left">
                                    <div>原始数据：<?php echo $_smarty_tpl->tpl_vars['r']->value['ereason'];?>
</div>
                                    <div>纠错数据：<?php echo $_smarty_tpl->tpl_vars['r']->value['rreason'];?>
</div>
                                </td>
                                <td align="left" class="td"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['r']->value['inputtime'],"%Y-%m-%d %H:%M");?>
</td>
                                <td align="left"><?php echo mb_substr($_smarty_tpl->tpl_vars['r']->value['result'],0,45,"utf-8");?>
</td>
                                <td>
                                    <a href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=report&c=del&del=<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
');" class="admin_new_c_bth admin_new_c_bth_sc">删除</a>
                                    <a href="javascript:void(0)" onclick="resultReport('<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['r']->value['result'];?>
')" class="admin_new_c_bth admin_new_c_bthsh check">处理</a>
                                </td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)'/></td>
                                <td colspan="9">
                                    <label for="chkAll2">全选</label>&nbsp;
                                    <input class="admin_button" type="button" name="delsub" value="删除所选" onClick="return really('del[]')"/>
                                </td>
                            </tr>
                            <?php if ($_smarty_tpl->tpl_vars['total']->value>$_smarty_tpl->tpl_vars['config']->value['sy_listnum']) {?>
                            <tr>
                                <?php if ($_smarty_tpl->tpl_vars['pagenum']->value==1) {?>
                                <td colspan="3"> 从 1 到 <?php echo $_smarty_tpl->tpl_vars['config']->value['sy_listnum'];?>
 ，总共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</td><?php } elseif ($_smarty_tpl->tpl_vars['pagenum']->value>1&&$_smarty_tpl->tpl_vars['pagenum']->value<$_smarty_tpl->tpl_vars['pages']->value) {?>
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
                                <td colspan="4" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</td>
                            </tr>
                            <?php }?>
                            </tbody>
                        </table>
                        <input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
                    </form>
                </div>
            </div>
        </div>
        <?php } elseif ($_smarty_tpl->tpl_vars['type']->value=='4') {?>

        <div class="tty_table-bom">
            <div class="table-list">
                <div class="admin_table_border">
                    <form action="index.php" name="myform" method="get" id='myform' target="supportiframe">

                        <input name="m" value="report" type="hidden"/>
                        <input name="c" value="del" type="hidden"/>

                        <table width="100%">
                            <thead>
                            <tr class="admin_table_top">
                                <th><label for="chkall"><input type="checkbox" id='chkAll' onclick='CheckAll(this.form)'/></label></th>
                                <th align="left">
                                    <?php if ($_GET['t']=="id"&&$_GET['order']=="asc") {?>
                                    <a href="<?php echo smarty_function_searchurl(array('type'=>4,'order'=>'desc','t'=>'id','m'=>'report','untype'=>'order,t,type'),$_smarty_tpl);?>
">编号<img src="images/sanj.jpg"/></a>
                                    <?php } else { ?>
                                    <a href="<?php echo smarty_function_searchurl(array('type'=>4,'order'=>'asc','t'=>'id','m'=>'report','untype'=>'order,t,type'),$_smarty_tpl);?>
">编号<img src="images/sanj2.jpg"/></a>
                                    <?php }?>
                                </th>
                                <th align="left">被举报者</th>
                                <th align="left">举报者</th>
                                <th align="left">举报原因</th>
                                <th>
                                    <?php if ($_GET['t']=="inputtime"&&$_GET['order']=="asc") {?>
                                    <a href="<?php echo smarty_function_searchurl(array('type'=>4,'order'=>'desc','t'=>'inputtime','m'=>'report','untype'=>'order,t,type'),$_smarty_tpl);?>
">举报时间<img src="images/sanj.jpg"/></a>
                                    <?php } else { ?>
                                    <a href="<?php echo smarty_function_searchurl(array('type'=>4,'order'=>'asc','t'=>'inputtime','m'=>'report','untype'=>'order,t,type'),$_smarty_tpl);?>
">举报时间<img src="images/sanj2.jpg"/></a>
                                    <?php }?>
                                </th>
                                <th>状态</th>

                                <th class="admin_table_th_bg">操作</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['chat_report']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value) {
$_smarty_tpl->tpl_vars['r']->_loop = true;
?>
                            <tr align="center" id="list<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
">
                                <td><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
" name='del[]' onclick='unselectall()' rel="del_chk"/></td>
                                <td align="left" ><span><?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
</span></td>
                                <td align="left"><?php echo $_smarty_tpl->tpl_vars['r']->value['r_name'];?>
</td>
                                <td align="left"><?php echo $_smarty_tpl->tpl_vars['r']->value['username'];?>
</td>
                                
                                <td align="left"><?php echo $_smarty_tpl->tpl_vars['r']->value['r_reason'];?>
</td>
                                <td class="td"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['r']->value['inputtime'],"%Y-%m-%d %H:%M");?>
</td>
                                <td>
                                    <?php echo $_smarty_tpl->tpl_vars['r']->value['status_n'];?>

                                </td>
                                <td>
                                    <a href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=report&c=del&del=<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
');" class="admin_new_c_bth admin_new_c_bth_sc">删除</a>
                                    <a href="javascript:void(0)" onclick="resultReport('<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
','','<?php echo $_smarty_tpl->tpl_vars['r']->value['c_uid'];?>
','<?php echo $_smarty_tpl->tpl_vars['r']->value['result'];?>
',4)" class="admin_new_c_bth admin_new_c_bthsh check">处理</a>
                                </td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)'/></td>
                                <td colspan="9">
                                    <label for="chkAll2">全选</label>&nbsp;
                                    <input class="admin_button" type="button" name="delsub" value="删除所选" onClick="return really('del[]')"/>
                                </td>
                            </tr>
                            <?php if ($_smarty_tpl->tpl_vars['total']->value>$_smarty_tpl->tpl_vars['config']->value['sy_listnum']) {?>
                            <tr>
                                <?php if ($_smarty_tpl->tpl_vars['pagenum']->value==1) {?>
                                <td colspan="3"> 从 1 到 <?php echo $_smarty_tpl->tpl_vars['config']->value['sy_listnum'];?>
 ，总共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 条</td><?php } elseif ($_smarty_tpl->tpl_vars['pagenum']->value>1&&$_smarty_tpl->tpl_vars['pagenum']->value<$_smarty_tpl->tpl_vars['pages']->value) {?>
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
                                <td colspan="7" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</td>
                            </tr>
                            <?php }?>

                            </tbody>
                        </table>
                        <input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
                    </form>
                </div>
            </div>
        </div>
        <?php }?>

        <div id="showbox" style="display:none; width: 340px; overflow:hidden ">
        <div id="showboxmsg" style="width:320px; padding:10px;height:150px; line-height:25px; font-size:14px; overflow:auto"></div>
    </div>

    <?php echo '<script'; ?>
>
        layui.use(['layer', 'form', 'element'], function () {
            var layer = layui.layer,
                form = layui.form,
                element = layui.element,
                $ = layui.$;
        });

        $(".resume-preview").click(function() {
            var id = $(this).attr("pid");
            $('body').css('overflow-y', 'hidden');
            $.layer({
                type: 2,
                shadeClose: true,
                title: '简历预览',
                area: ['755px', ($(window).height() - 30) +'px'],
                iframe: {src: 'index.php?m=admin_resume&c=resumePreview&id='+id},
                close: function(){
                    $('body').css('overflow-y', '');
                }
            });
        });
    <?php echo '</script'; ?>
>
    <iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
</body>
</html>
<?php }} ?>
