<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 16:00:54
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\member\user\resume.htm" */ ?>
<?php /*%%SmartyHeaderCode:24562d907b649e022-02819067%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2850a4ecf7f4edd8f5685edd09d54031295a8c5c' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\member\\user\\resume.htm',
      1 => 1643012866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '24562d907b649e022-02819067',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'expectnum' => 0,
    'def_job' => 0,
    'maxnum' => 0,
    'uid' => 0,
    'rows' => 0,
    'expect' => 0,
    'resume' => 0,
    'expectStatus' => 0,
    'heightone' => 0,
    'heighttwo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d907b6626083_40883932',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d907b6626083_40883932')) {function content_62d907b6626083_40883932($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.url.php';
?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['userstyle']->value)."/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div class="yun_w1200">
    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['userstyle']->value)."/left.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <div class="yun_m_rightsidebar">

        <div class="user_czbth">
            <?php if ($_smarty_tpl->tpl_vars['config']->value['user_number']>$_smarty_tpl->tpl_vars['expectnum']->value||$_smarty_tpl->tpl_vars['config']->value['user_number']=='') {?>
                <a href="index.php?c=expect&act=add" class="user_cjbth">创建简历</a>
            <?php } else { ?>
                <a href="javascript:void(0)" onclick="layer.msg('你的简历数已经达到系统设置的简历数了',2,8);return false;" class="user_cjbth">创建简历</a>
            <?php }?>

            <div class="user_czbth_r">
                <a href="index.php?c=privacy" class="user_czbth_ys user_czbth_line">隐私设置 </a>
                <a href="index.php?c=likejob&id=<?php echo $_smarty_tpl->tpl_vars['def_job']->value;?>
" class="user_czbth_pp user_czbth_line" resumeid="<?php echo $_smarty_tpl->tpl_vars['def_job']->value;?>
" type='pipei'>匹配职位</a>
                <a href="javascript:reply_height_status('<?php echo $_smarty_tpl->tpl_vars['def_job']->value;?>
');" type='height' rid="<?php echo $_smarty_tpl->tpl_vars['def_job']->value;?>
" class="user_czbth_yz user_czbth_line">优质简历</a>
                <a href="javascript:com_res();" type='entrust' class="user_czbth_wt user_czbth_line">委托简历</a>
                <?php if ($_smarty_tpl->tpl_vars['maxnum']->value>0) {?>
                    <a href="index.php?c=expectq&add=<?php echo $_smarty_tpl->tpl_vars['uid']->value;?>
" title="直接粘贴已有的个人简历" class="user_czbth_zt">在线粘贴简历</a>
                <?php } else { ?>
                    <a href="javascript:void(0)" onclick="layer.msg('你的简历数已经达到系统设置的简历数了',2,8);return false;" title="直接粘贴已有的个人简历" class="user_czbth_zt">在线粘贴简历</a>
                <?php }?>
            </div>
        </div>

        <div class="yun_m_rightbox fltR mt20 re">
            <div class="user_resume_list">
                <div class="yun_m_index_resume_tit"><span class="yun_m_index_resume_span ">我的简历</span></div>
                <div class="">
                    <div class="clear"></div>
                    <?php  $_smarty_tpl->tpl_vars['expect'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['expect']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['expect']->key => $_smarty_tpl->tpl_vars['expect']->value) {
$_smarty_tpl->tpl_vars['expect']->_loop = true;
?>

                        <?php if ($_smarty_tpl->tpl_vars['expect']->value['id']==$_smarty_tpl->tpl_vars['def_job']->value) {?>
                            <div class="user_resume_box">
                                <div class="user_resume_photo">
                                    <a href="index.php?c=uppic">
                                        <?php if ($_smarty_tpl->tpl_vars['resume']->value['sex']==1) {?>
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['resume']->value['photo'];?>
" border="0" onerror="showImgDelay(this,'<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_member_icon'];?>
',2);"/>
                                        <?php } else { ?>
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['resume']->value['photo'];?>
" border="0" onerror="showImgDelay(this,'<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_member_iconv'];?>
',2);"/>
                                        <?php }?>
                                    </a>
                                </div>
                                <div class="user_resume_info">
                                    <div class="user_resume_name"><?php echo $_smarty_tpl->tpl_vars['resume']->value['name'];?>
<span class="user_resume_job"><?php echo $_smarty_tpl->tpl_vars['expect']->value['name'];?>
</span><span class="user_resume_mr">默认</span></div>
                                    <div class="user_resume_p">
                                        <?php if ($_smarty_tpl->tpl_vars['resume']->value['age']) {
echo $_smarty_tpl->tpl_vars['resume']->value['age'];?>
岁<span class="user_resume_line">|</span><?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['resume']->value['exp_n']) {
echo $_smarty_tpl->tpl_vars['resume']->value['exp_n'];?>
<span class="user_resume_line">|</span><?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['resume']->value['edu_n']) {
echo $_smarty_tpl->tpl_vars['resume']->value['edu_n'];
}?>
                                    </div>
                                    <div class="user_resume_p2">
                                        <?php echo $_smarty_tpl->tpl_vars['expectStatus']->value['jobstatus_n'];?>
 - <?php echo $_smarty_tpl->tpl_vars['expectStatus']->value['report_n'];?>

                                    </div>
                                </div>
                                <div class="user_resume_c">
                                    <div class="user_resume_wzd " id="tipid" rid="<?php echo $_smarty_tpl->tpl_vars['expect']->value['id'];?>
">
                                        <span class="user_resume_wzd_name">简历完整度：</span>
                                        <div class="user_resume_wzd_b"><span class="user_resume_wzd_c" style="width:<?php echo $_smarty_tpl->tpl_vars['expect']->value['integrity'];?>
% "></span></div>
                                        <span class="user_resume_wzd_r"><?php echo $_smarty_tpl->tpl_vars['expect']->value['integrity'];?>
% </span>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="user_resume_p user_resume_pd">更新日期：<?php echo $_smarty_tpl->tpl_vars['expect']->value['lastupdate'];?>
</div>
                                    <div class="user_resume_p">被浏览：<?php echo $_smarty_tpl->tpl_vars['expect']->value['hits'];?>
</div>
                                </div>
                                <div class="user_resume_cz">
                                    <?php if ($_smarty_tpl->tpl_vars['expect']->value['state']=='1') {?>
                                        <div class="user_resume_cz_p">
                                            <a href="javascript:void(0)" onclick="resumetop('<?php echo $_smarty_tpl->tpl_vars['expect']->value['id'];?>
','<?php if ($_smarty_tpl->tpl_vars['expect']->value['topdatetime']>0) {
echo $_smarty_tpl->tpl_vars['expect']->value['topdate'];
}?>','<?php echo $_smarty_tpl->tpl_vars['expect']->value['name'];?>
')" class="user_resume_cz_a user_resume_cz_icon1">简历置顶</a>
                                        </div>
                                        <div class="user_resume_cz_p">
                                            <a href="index.php?c=expect<?php if ($_smarty_tpl->tpl_vars['expect']->value['doc']) {?>q<?php }?>&e=<?php echo $_smarty_tpl->tpl_vars['expect']->value['id'];?>
" class="user_resume_cz_a user_resume_cz_icon3">修改简历</a>
                                        </div>
                                        <div class="user_resume_cz_p">
                                            <a href="<?php echo smarty_function_url(array('m'=>'resume','c'=>'show','id'=>$_smarty_tpl->tpl_vars['expect']->value['id']),$_smarty_tpl);?>
" target="_blank" class="user_resume_cz_a user_resume_cz_icon4">预览简历</a>
                                        </div>
                                        <div class="user_resume_cz_p">
                                        <a onclick="layer_del('确定要刷新？', 'index.php?c=resume&act=refresh&id=<?php echo $_smarty_tpl->tpl_vars['expect']->value['id'];?>
');" href="javascript:void(0)" class="user_resume_cz_a user_resume_cz_icon2">刷新简历</a>
                                    </div>
                                    <?php } else { ?>
                                        <div class="user_resume_cz_p">
                                            <a href="javascript:void(0)" onclick="layer_del('确定要删除？', 'index.php?c=resume&act=del&id=<?php echo $_smarty_tpl->tpl_vars['expect']->value['id'];?>
');" class="user_resume_cz_a user_resume_cz_icon5"> 删除简历</a>
                                        </div>
                                        <div class="user_resume_cz_p">
                                            <a href="index.php?c=expect<?php if ($_smarty_tpl->tpl_vars['expect']->value['doc']) {?>q<?php }?>&e=<?php echo $_smarty_tpl->tpl_vars['expect']->value['id'];?>
" class="user_resume_cz_a user_resume_cz_icon3">修改简历</a>
                                        </div>
                                        <div class="user_resume_cz_p">
                                            <a href="<?php echo smarty_function_url(array('m'=>'resume','c'=>'show','id'=>$_smarty_tpl->tpl_vars['expect']->value['id']),$_smarty_tpl);?>
" target="_blank" class="user_resume_cz_a user_resume_cz_icon4">预览简历</a>
                                        </div>
                                        <div class="user_resume_cz_p">
                                            <a onclick="layer_del('确定要刷新？', 'index.php?c=resume&act=refresh&id=<?php echo $_smarty_tpl->tpl_vars['expect']->value['id'];?>
');" href="javascript:void(0)" class="user_resume_cz_a user_resume_cz_icon2">刷新简历</a>
                                        </div>
                                    <?php }?>
                                </div>
                            </div>
                            <?php if ($_smarty_tpl->tpl_vars['expect']->value['state']==3) {?>
                            <div class="user_resume_boxtip">
                                <div class="user_resume_boxtip_c">
                                    <div class="user_resume_boxtip_h1">你的简历审核未通过！</div>
                                    <?php if ($_smarty_tpl->tpl_vars['expect']->value['statusbody']) {?><div class="user_resume_boxtip_p">原因：<?php echo $_smarty_tpl->tpl_vars['expect']->value['statusbody'];?>
</div><?php }?>
                                    <div class="user_resume_boxtip_p">请修改简历信息，提交管理员审核</div>
                                    <a href="index.php?c=expect&e=<?php echo $_smarty_tpl->tpl_vars['expect']->value['id'];?>
" class="user_resume_boxtip_bth" <?php if ($_smarty_tpl->tpl_vars['expect']->value['statusbody']) {?>style="margin-top: 15px;"<?php }?>>完善信息 </a>
                                </div>
                            </div>
                            <!--未完善情况提示-->
                            <?php } elseif ($_smarty_tpl->tpl_vars['expectStatus']->value['integrity']<100) {?>
                            <div class="user_resume_boxtip">
                                <div class="user_resume_boxtip_c">
                                    <div class="user_resume_boxtip_h1">
                                        你的简历缺少<?php echo $_smarty_tpl->tpl_vars['expectStatus']->value['wstitle'];?>
，会极大影响求职成功率哦！
                                    </div>
                                    <div class="user_resume_boxtip_p">
                                        完善<?php echo $_smarty_tpl->tpl_vars['expectStatus']->value['wstitle'];?>
，可以有效提高求职成功率
                                    </div>
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['expectStatus']->value['wspcurl'];?>
" class="user_resume_boxtip_bth">完善<?php echo $_smarty_tpl->tpl_vars['expectStatus']->value['wstitle'];?>
 </a>
                                </div>
                            </div>
                            <!--未开启情况提示-->
                            <?php } elseif ($_smarty_tpl->tpl_vars['expectStatus']->value['status']==2||$_smarty_tpl->tpl_vars['expectStatus']->value['status']==3) {?>
                            <div class="user_resume_boxtip">
                                <div class="user_resume_boxtip_c">
                                    <div class="user_resume_boxtip_h1">你的简历已隐藏，企业无法主动发现你！</div>
                                    <div class="user_resume_boxtip_p">开启简历，好工作快速找你</div>
                                    <a href="index.php?c=privacy" class="user_resume_boxtip_bth">公开简历 </a>
                                </div>
                            </div>
                            <?php }?>
                        <?php } else { ?>
                            <!--  备用简历-->
                            <div class="myresume mt20" style="margin-left: 0px;">
                                <span class="myresume_by">备用</span>
                                <div class="myresume_left ">
                                    <div class="myresume_name">
                                        <a href="<?php echo smarty_function_url(array('m'=>'resume','c'=>'show','id'=>$_smarty_tpl->tpl_vars['expect']->value['id']),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['expect']->value['name'];?>
</a>
                                    </div>
                                    <div class="user_resume_wzd " id="tipid" rid="1044751">
                                        <span class="user_resume_wzd_name">简历完整度：</span>
                                        <div class="user_resume_wzd_b"><span class="user_resume_wzd_c" style="width:<?php echo $_smarty_tpl->tpl_vars['expect']->value['integrity'];?>
%"></span></div>
                                        <span class="user_resume_wzd_r"><?php echo $_smarty_tpl->tpl_vars['expect']->value['integrity'];?>
% </span>
                                    </div>

                                    <div class="myresume_type">
                                        <span class="myresume_type_s">类型：<?php if ($_smarty_tpl->tpl_vars['expect']->value['doc']=='1') {?>粘贴简历<?php } else { ?>标准简历<?php }?></span>
                                        <span class="myresume_type_s">更新时间：<?php echo $_smarty_tpl->tpl_vars['expect']->value['lastupdate'];?>
</span>
                                        <span class="myresume_type_s">被浏览：<?php echo $_smarty_tpl->tpl_vars['expect']->value['hits'];?>
</span>
                                        <span class="myresume_type_s">
                                    状态：<?php if ($_smarty_tpl->tpl_vars['expect']->value['state']=='1') {?>
                                    <span class="myresume_state_ysh">已审核</span><?php } elseif ($_smarty_tpl->tpl_vars['expect']->value['state']=='0') {?>
                                    <span class="myresume_state_dsh">审核中</span><?php } elseif ($_smarty_tpl->tpl_vars['expect']->value['state']=='3') {?>
                                    <span class="myresume_state_btg">审核不通过</span> <?php if ($_smarty_tpl->tpl_vars['expect']->value['statusbody']) {?>原因：<?php echo $_smarty_tpl->tpl_vars['expect']->value['statusbody'];
}
}?>
                                </span>
                                    </div>
                                </div>
                                <div class="myresume_right ">
                                    <a href="javascript:void(0);" class="myresume_right_cz_fmr_a" onclick="layer_del('确定要执行？', 'index.php?c=resume&act=defaultresume&id=<?php echo $_smarty_tpl->tpl_vars['expect']->value['id'];?>
');">设为默认</a>
                                    <span class="myresume_right_cz_fmr_line">|</span>
                                    <a href="index.php?c=expect<?php if ($_smarty_tpl->tpl_vars['expect']->value['doc']) {?>q<?php }?>&e=<?php echo $_smarty_tpl->tpl_vars['expect']->value['id'];?>
" class="myresume_right_cz_fmr_a">修改简历 </a>
                                    <span class="myresume_right_cz_fmr_line">|</span>
                                    <a href="<?php echo smarty_function_url(array('m'=>'resume','c'=>'show','id'=>$_smarty_tpl->tpl_vars['expect']->value['id']),$_smarty_tpl);?>
" target="_blank" class="myresume_right_cz_fmr_a">预览简历</a>
                                    <span class="myresume_right_cz_fmr_line">|</span>
                                    <a href="javascript:void(0)" onclick="layer_del('确定要删除？', 'index.php?c=resume&act=del&id=<?php echo $_smarty_tpl->tpl_vars['expect']->value['id'];?>
');" class="myresume_right_cz_fmr_a">删除简历 </a>
                                </div>
                            </div>
                        <?php }?>
                    <?php }
if (!$_smarty_tpl->tpl_vars['expect']->_loop) {
?>
                        <div class="msg_no">您还没有简历。</div>
                    <?php } ?>
                </div>
            </div>
            <div class="clear"></div>
            <div class="myresume_cj"></div>
            <div class="clear"></div>
        </div>
    </div>
</div>
<div id="wname" style="display:none; width: 380px; ">

    <div class="myresume_senior">
        <div class="sq_gjresume_hi">尊敬的用户你好！</div>
        <div class="sq_gjresume_hi_t">申请优质人才你的简历需具备以下条件：</div>
        <div class="">
            <?php if ($_smarty_tpl->tpl_vars['heightone']->value==1) {?>
            <div class="sq_gjresume_tj">本科以上学历</div>
            <?php } else { ?>
            <div class="sq_gjresume_tjno">本科以上学历<span class="sq_gjresume_tjno_tip">(暂不符合)</span></div>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['heighttwo']->value==2) {?>
            <div class="sq_gjresume_tj">两年以上工作经验或三项以上工作经历</div>
            <?php } else { ?>
            <div class="sq_gjresume_tjno">两年以上工作经验或三项以上工作经历<span class="sq_gjresume_tjno_tip">(暂不符合)</span></div>
            <?php }?>
        </div>
        <span class="myresume_button"><a class="myresume_senior_bth" href="javascript:void(0);">申请优质简历</a></span>
        <span class="myresume_senior_tj mt10">温馨提示：</span>
        <div class="myresume_senior_sm">成为优质人才以后，会有猎头中介主动联系您，请保持电话通畅。</div>
    </div>
</div>

<div id="showmsg" style="display:none; width: 400px;">
    <div id="infobox">
        <div class="admin_Operating_sh" style="padding:10px; ">
            <div class="admin_Operating_sh_h1" style="padding:5px;">审核说明：
                <div class="user_Audit_box" id="msgs"></div>
            </div>
            <div class="admin_Operating_sub" style="margin-top:10px;">
                &nbsp;&nbsp;<input type="button" onclick="layer.close($('#layindex').val());" class="com_pop_bth" value='确认'>
            </div>
        </div>
    </div>
</div>
<?php echo '<script'; ?>
>
    layui.use(['layer', 'form', 'laydate'], function () {
        var layer = layui.layer,
            form = layui.form,
            $ = layui.$;
    });

    function gourl() {
        layer.confirm('确定要创建新的简历吗？', function () {
            window.location.href = 'index.php?c=expect&act=add';
            window.event.returnValue = false;
            return false;
        });
    }

    function reply_height_status(id) {
        $("#wname .myresume_button").html(
            "<a class=\"myresume_senior_bth\" href=\"javascript:void(0);\" onclick=\"layer_del('','index.php?c=resume&act=height&id=" +
            id + "');\">申请</a>");
        var layindex = $.layer({
            type: 1,
            title: '申请优质简历',
            closeBtn: [0, true],
            border: [10, 0.3, '#000', true],
            area: ['380px', '350px'],
            page: {
                dom: '#wname'
            }
        });
        $("#layindex").val(layindex);
    }

    function exite_height_status(id) {
        var pytoken = $.trim($("#pytoken").val());
        layer.confirm('确定要取消优质简历吗？', function () {
            loadlayer();
            $.post('index.php?c=resume&act=exite_height', {
                id: id,
                pytoken: pytoken
            }, function (data) {
                parent.layer.closeAll('loading');
                if (data == "1") {
                    layer.msg('取消成功！', 2, 9, function () {
                        window.location.href = 'index.php?c=resume';
                    });
                } else {
                    layer.msg('取消失败！', 2, 9, function () {
                        window.location.href = 'index.php?c=resume';
                    });
                }
            });

        })
    }

    function app_height_status(id) {
        $("#wname .myresume_button").html(
            "<a class=\"myresume_senior_bth\" href=\"javascript:void(0);\" onclick=\"layer_del('','index.php?c=resume&act=height&id=" +
            id + "');\">申请</a>");
        $.layer({
            type: 1,
            title: '申请优质简历',
            closeBtn: [0, true],
            border: [10, 0.3, '#000', true],
            area: ['380px', '360px'],
            page: {
                dom: '#wname'
            }
        });
    }

    function showmsg(msg) {
        $("#msgs").html(msg);
        $.layer({
            type: 1,
            title: '查看原因',
            closeBtn: [0, true],
            border: [10, 0.3, '#000', true],
            area: ['400px', '200px'],
            page: {
                dom: "#showmsg"
            }
        });
    }

    function com_res() {
        var loadi = layer.load('加载中…', 0);
        $.get("index.php?c=com_res", function (msg) {
            layer.closeAll();
            if (msg == 1) {
                layer.msg('您暂无公开简历！', 2, 8);
                return false;
            } else {
                layer.close(loadi);
                $(".result_class").remove();
                $(".Commissioned_table").append(msg);
                $.layer({
                    type: 1,
                    title: '委托简历',
                    closeBtn: [0, true],
                    border: [10, 0.3, '#000', true],
                    area: ['548px', 'auto'],
                    page: {
                        dom: '.Commissioned_Resume_box'
                    },
                    close: function (index) {
                        layer.close(index);
                        $(".result_class").remove();
                    }
                });
            }
        });
    }

    function entr_resume_free(id) {
        $.post("index.php?c=com_res&act=canceltrust", {
            id: id
        }, function (data) {
            var data = eval('(' + data + ')');
            if (data.url) {
                layer.msg(data.msg, 2, Number(data.type), function () {
                    window.location.href = data.url;
                    window.event.returnValue = false;
                    return false;
                });
                return false;
            } else {
                layer.msg(data.msg, 2, Number(data.type), function () {
                    window.location.reload();
                    window.event.returnValue = false;
                    return false;
                });
                return false;
            }
        });
    }

    function entr_resume(id) {
        layer.closeAll();
        $("#server_eid").val(id);

        $("#server").val('mywt');
        $("#resumetop").hide();
        $("#server_name").text('购买委托简历');
        $("#server_name").show();
        var price = $("#mywt").val();
        $("#server_price").text(price);
        $("#server_subject").val('委托简历金额');
        $(".admin_Operating_sh").attr('style', 'padding-left:80px;');
        $.layer({
            type: 1,
            title: '委托简历',
            closeBtn: [0, true],
            border: [10, 0.3, '#000', true],
            area: ['500px', '320px'],
            page: {
                dom: '#user_server'
            }
        });
    }

    function entrust(msg, id) {
        wait_result();
        if (msg) {
            layer.confirm(msg, {
                    end: function () {
                        layer.closeAll('loading');
                    }
                },
                function () {
                    $.post("index.php?c=com_res&act=canceltrust", {
                        id: id
                    }, function (data) {
                        layer.closeAll('loading');
                        var data = eval('(' + data + ')');
                        if (data.url) {
                            layer.msg(data.msg, 2, Number(data.type), function () {
                                window.location.href = data.url;
                                window.event.returnValue = false;
                                return false;
                            });
                            return false;
                        } else {
                            layer.msg(data.msg, 2, Number(data.type), function () {
                                window.location.reload();
                                window.event.returnValue = false;
                                return false;
                            });
                            return false;
                        }
                    });
                }
            );
        } else {
            $.post("index.php?c=com_res&act=canceltrust", {
                id: id
            }, function (data) {
                layer.closeAll('loading');
                var data = eval('(' + data + ')');
                if (data.url) {
                    layer.msg(data.msg, 2, Number(data.type), function () {
                        window.location.href = data.url;
                        window.event.returnValue = false;
                        return false;
                    });
                    return false;
                } else {
                    layer.msg(data.msg, 2, Number(data.type), function () {
                        window.location.reload();
                        window.event.returnValue = false;
                        return false;
                    });
                    return false;
                }
            });
        }
    }
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['userstyle']->value)."/server.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['userstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }} ?>
