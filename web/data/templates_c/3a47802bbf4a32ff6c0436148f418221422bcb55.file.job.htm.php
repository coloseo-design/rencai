<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 16:00:50
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\member\user\job.htm" */ ?>
<?php /*%%SmartyHeaderCode:2991562d907b23fbe88-51962245%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3a47802bbf4a32ff6c0436148f418221422bcb55' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\member\\user\\job.htm',
      1 => 1634883848,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2991562d907b23fbe88-51962245',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'total' => 0,
    'StateList' => 0,
    'key' => 0,
    'v' => 0,
    'search_list' => 0,
    'rows' => 0,
    'job' => 0,
    'pagenav' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d907b2554f79_57005186',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d907b2554f79_57005186')) {function content_62d907b2554f79_57005186($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.url.php';
if (!is_callable('smarty_modifier_date_format')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\modifier.date_format.php';
?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['userstyle']->value)."/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div class="yun_w1200">
    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['userstyle']->value)."/left.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <div class="yun_m_rightsidebar">
        <div class="user_new_tit">
            <span class="user_new_tit_n">申请的职位</span><span class="user_new_tit_r">您已申请 <span style="color:red;"><?php echo $_smarty_tpl->tpl_vars['total']->value;?>
</span> 条职位,请耐心等待企业回复！</span>
            <div class="job_td_list_box">
                <div class="job_td_list">
                    投递反馈：
                    <a href="index.php?c=job" class="<?php if (!$_GET['browse']) {?>job_td_list_cur<?php } else { ?>job_td_list_a<?php }?>">不限</a>
                    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['StateList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                    <a href="index.php?c=job&browse=<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" class="<?php if ($_GET['browse']==$_smarty_tpl->tpl_vars['key']->value) {?>job_td_list_cur<?php } else { ?>job_td_list_a<?php }?>"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</a>
                    <?php } ?>
                </div>
                <div class="job_td_list ">
                    投递时间：
                    <a href="index.php?c=job" class="<?php if (!$_GET['datetime']) {?>job_td_list_cur<?php } else { ?>job_td_list_a<?php }?>">不限</a>
                    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['search_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                    <a href="index.php?c=job&datetime=<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" class="<?php if ($_GET['datetime']==$_smarty_tpl->tpl_vars['key']->value) {?>job_td_list_cur<?php } else { ?>job_td_list_a<?php }?>"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="yun_m_rightbox fltR mt20 re">

            <div class="clear"></div>

            <div class="resume_box_list">

                <div class="clear"></div>

                <div id="gms_showclew"></div>

                <form action="index.php" method="get" target="supportiframe" id='myform'>
                    <input type="hidden" name="c" value="job"/>
                    <input type="hidden" name="act" value="del"/>
                    <?php if (!empty($_smarty_tpl->tpl_vars['rows']->value)) {?>
                    <div class="user_new_listtit">
                        <div class=" user_new_job" style="width:260px;">岗位</div>
                        <div class=" user_new_time">投递时间</div>
                        <div class=" user_new_tdzt">状态</div>
                        <div class=" user_new_yqh">招聘状态</div>
                        <div class=" user_new_cz">操作</div>
                    </div>
                    <?php }?>
                    <?php  $_smarty_tpl->tpl_vars['job'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['job']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['job']->key => $_smarty_tpl->tpl_vars['job']->value) {
$_smarty_tpl->tpl_vars['job']->_loop = true;
?>

                    <div class="jobnotice_list">
                        <div class=" user_new_job" style="width:260px;">
                            <div class="">
                                <?php if ($_smarty_tpl->tpl_vars['job']->value['type']==1) {?>

                                    <a href="<?php echo smarty_function_url(array('m'=>'job','c'=>'comapply','id'=>'`$job.job_id`'),$_smarty_tpl);?>
" target="_blank" title="<?php echo $_smarty_tpl->tpl_vars['job']->value['job_name'];?>
" class="user_new_jobname"><?php echo $_smarty_tpl->tpl_vars['job']->value['job_name'];?>
</a>
                                <?php } elseif ($_smarty_tpl->tpl_vars['job']->value['type']==2) {?>

                                    <a href="<?php echo smarty_function_url(array('m'=>'lietou','c'=>'jobcomshow','id'=>'`$job.job_id`'),$_smarty_tpl);?>
" target="_blank" class="user_new_jobname" title="<?php echo $_smarty_tpl->tpl_vars['job']->value['job_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['job']->value['job_name'];?>
</a>
                                    <span class="user_new_jobzt">高级</span>
                                <?php } elseif ($_smarty_tpl->tpl_vars['job']->value['type']==3) {?>

                                    <a href="<?php echo smarty_function_url(array('m'=>'lietou','c'=>'jobshow','id'=>'`$job.job_id`'),$_smarty_tpl);?>
" target="_blank" class="user_new_jobname" title="<?php echo $_smarty_tpl->tpl_vars['job']->value['job_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['job']->value['job_name'];?>
</a>
                                    <span class="user_new_jobzt">猎头</span>
                                <?php }?>
                            </div>

                            <div class="user_new_jobxz"><?php echo $_smarty_tpl->tpl_vars['job']->value['job_salary'];?>
</div>

                            <div class="user_new_comname">
                                <?php if ($_smarty_tpl->tpl_vars['job']->value['type']==3) {?>
                                    <a href="<?php echo smarty_function_url(array('m'=>'lietou','c'=>'headhunter','uid'=>'`$job.com_id`'),$_smarty_tpl);?>
" target="_blank" title="<?php echo $_smarty_tpl->tpl_vars['job']->value['com_name'];?>
" class=""><?php echo $_smarty_tpl->tpl_vars['job']->value['com_name'];?>
 </a>
                                <?php } else { ?>
                                    <a href="<?php echo smarty_function_url(array('m'=>'company','c'=>'show','id'=>'`$job.com_id`'),$_smarty_tpl);?>
" target="_blank" title="<?php echo $_smarty_tpl->tpl_vars['job']->value['com_name'];?>
" class=""><?php echo $_smarty_tpl->tpl_vars['job']->value['com_name'];?>
 </a>
                                <?php }?>
                            </div>
                        </div>

                        <div class="user_new_time"><span class="msg_zt_s"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['job']->value['datetime'],'%Y-%m-%d');?>
</span></div>

                        <div class="user_new_tdzt">
                            <?php if ($_smarty_tpl->tpl_vars['job']->value['invited']==1) {?>
                                <span class="td_zt"><i class="td_zt_y"></i>已投递<i class="td_zt_q"></i><i class="td_zt_q2"></i><i class="td_zt_q3"></i><i class="td_zt_q4"></i></span>
                                <span class="td_zt"><i class="td_zt_y"></i>已查看<i class="td_zt_q"></i><i class="td_zt_q2"></i><i class="td_zt_q3"></i><i class="td_zt_q4"></i></span>
                                <span class="td_zt"><i class="td_zt_y"></i>已沟通<i class="td_zt_q"></i><i class="td_zt_q2"></i><i class="td_zt_q3"></i><i class="td_zt_q4"></i></span>
                                <span class="td_zt"><i class="td_zt_xz"></i>邀面试</span>

                            <?php } elseif ($_smarty_tpl->tpl_vars['job']->value['is_browse']==1) {?>

                                <?php if ($_smarty_tpl->tpl_vars['job']->value['body']!='') {?>

                                    <span class="td_zt"><i class="td_zt_y"></i>已投递<i class="td_zt_q"></i><i class="td_zt_q2"></i><i class="td_zt_q3"></i><i class="td_zt_q4"></i></span>
                                    <span class="td_zt"><i class="td_zt_xz"></i>已撤销</span>
                                <?php } else { ?>

                                    <span class="td_zt"><i class="td_zt_xz"></i>已投递<i class="td_zt_q"></i><i class="td_zt_q2"></i><i class="td_zt_q3"></i><i class="td_zt_q4"></i></span>
                                    <span class="td_zt td_ztmy"><i class="td_zt_w"></i>待查看<i class="td_zt_q"></i><i class="td_zt_q2"></i><i class="td_zt_q3"></i><i class="td_zt_q4"></i></span>
                                    <span class="td_zt td_ztmy"><i class="td_zt_w"></i>待沟通<i class="td_zt_q"></i><i class="td_zt_q2"></i><i class="td_zt_q3"></i><i class="td_zt_q4"></i></span>
                                    <span class="td_zt "><i class="td_zt_w"></i>邀面试</span>
                                <?php }?>
                            <?php } elseif ($_smarty_tpl->tpl_vars['job']->value['is_browse']==2) {?>

                                <span class="td_zt"><i class="td_zt_y"></i>已投递<i class="td_zt_q"></i><i class="td_zt_q2"></i><i class="td_zt_q3"></i><i class="td_zt_q4"></i></span>
                                <span class="td_zt td_ztmy"><i class="td_zt_xz"></i>已查看<i class="td_zt_q"></i><i class="td_zt_q2"></i><i class="td_zt_q3"></i><i class="td_zt_q4"></i></span>
                                <span class="td_zt td_ztmy"><i class="td_zt_w"></i>待沟通<i class="td_zt_q"></i><i class="td_zt_q2"></i><i class="td_zt_q3"></i><i class="td_zt_q4"></i></span>
                                <span class="td_zt "><i class="td_zt_w"></i>邀面试</span>
                            <?php } elseif ($_smarty_tpl->tpl_vars['job']->value['is_browse']==3) {?>

                                <span class="td_zt"><i class="td_zt_y"></i>已投递<i class="td_zt_q"></i><i class="td_zt_q2"></i><i class="td_zt_q3"></i><i class="td_zt_q4"></i></span>
                                <span class="td_zt"><i class="td_zt_y"></i>已查看<i class="td_zt_q"></i><i class="td_zt_q2"></i><i class="td_zt_q3"></i><i class="td_zt_q4"></i></span>
                                <span class="td_zt td_ztmy"><i class="td_zt_xz"></i>等通知<i class="td_zt_q"></i><i class="td_zt_q2"></i><i class="td_zt_q3"></i><i class="td_zt_q4"></i></span>
                                <span class="td_zt "><i class="td_zt_w"></i>邀面试</span>
                            <?php } elseif ($_smarty_tpl->tpl_vars['job']->value['is_browse']==4) {?>

                                <span class="td_zt"><i class="td_zt_y"></i>已投递<i class="td_zt_q"></i><i class="td_zt_q2"></i><i class="td_zt_q3"></i><i class="td_zt_q4"></i></span>
                                <span class="td_zt"><i class="td_zt_y"></i>已查看<i class="td_zt_q"></i><i class="td_zt_q2"></i><i class="td_zt_q3"></i><i class="td_zt_q4"></i></span>
                                <span class="td_zt td_ztmy"><i class="td_zt_xz"></i>不符合<i class="td_zt_q"></i><i class="td_zt_q2"></i><i class="td_zt_q3"></i><i class="td_zt_q4"></i></span>
                                <span class="td_zt "><i class="td_zt_w"></i>邀面试</span>
                            <?php } elseif ($_smarty_tpl->tpl_vars['job']->value['is_browse']==5) {?>

                                <span class="td_zt"><i class="td_zt_y"></i>已投递<i class="td_zt_q"></i><i class="td_zt_q2"></i><i class="td_zt_q3"></i><i class="td_zt_q4"></i></span>
                                <span class="td_zt "><i class="td_zt_y"></i>已查看<i class="td_zt_q"></i><i class="td_zt_q2"></i><i class="td_zt_q3"></i><i class="td_zt_q4"></i></span>
                                <span class="td_zt td_ztmy"><i class="td_zt_xz"></i>未接通<i class="td_zt_q"></i><i class="td_zt_q2"></i><i class="td_zt_q3"></i><i class="td_zt_q4"></i></span>
                                <span class="td_zt "><i class="td_zt_w"></i>邀面试</span>

                            <?php }?>
                        </div>
                        <div class=" user_new_yqh">
                            <?php if ($_smarty_tpl->tpl_vars['job']->value['id']) {?>
                                <?php if ($_smarty_tpl->tpl_vars['job']->value['status']==0) {?>
                                    <span class="">招聘中</span>
                                <?php } else { ?>
                                    <span class=" ">已下架</span>
                                <?php }?>
                            <?php } else { ?>
                                <span class=" ">已下架</span>
                            <?php }?>
                        </div>
                        <div class=" user_new_cz">
                            <?php if ($_smarty_tpl->tpl_vars['job']->value['body']!='') {?> <span class="List_dete" style="color:#999;"></span><?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['job']->value['is_browse']=='1'&&$_smarty_tpl->tpl_vars['job']->value['body']=='') {?>

                                <a href="javascript:void(0)" onclick="canceljob(<?php echo $_smarty_tpl->tpl_vars['job']->value['id'];?>
);" class="user_new_yqh_ch">撤回</a>
                            <?php } else { ?>

                                <a href="javascript:void(0)" onclick="layer_del('确定要删除？','index.php?c=job&act=del&id=<?php echo $_smarty_tpl->tpl_vars['job']->value['id'];?>
');" class="user_new_yqh_sc">删除</a>
                            <?php }?>
                        </div>
                    </div>

                    <!--
                    <div class="interview_application_list">
                        <div class="interview_application_span interview_application_jobname"></div>
                        <div class="interview_application_span interview_application_jobname">
                            <?php if ($_smarty_tpl->tpl_vars['job']->value['type']==3) {?>
                                <a href="<?php echo smarty_function_url(array('m'=>'lietou','c'=>'headhunter','uid'=>'`$job.com_id`'),$_smarty_tpl);?>
" target="_blank" title="<?php echo $_smarty_tpl->tpl_vars['job']->value['com_name'];?>
" class="interview_application_comname"><?php echo $_smarty_tpl->tpl_vars['job']->value['com_name'];?>
 </a>
                            <?php } else { ?>
                                <a href="<?php echo smarty_function_url(array('m'=>'company','c'=>'show','id'=>'`$job.com_id`'),$_smarty_tpl);?>
" target="_blank" title="<?php echo $_smarty_tpl->tpl_vars['job']->value['com_name'];?>
" class="interview_application_comname"><?php echo $_smarty_tpl->tpl_vars['job']->value['com_name'];?>
 </a>
                            <?php }?>
                        </div>

                        <div class="interview_application_span interview_application_jobzt "></div>
                        <div class="interview_application_span interview_application_tdfk "></div>
                        <div class="interview_application_span interview_application_tdtime ">
                            <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['job']->value['datetime'],'%Y-%m-%d');?>

                        </div>
                        <div class="interview_application_span interview_application_tdjlmc "><?php echo $_smarty_tpl->tpl_vars['job']->value['rname'];?>
&nbsp;</div>
                        <div class="interview_application_span interview_application_cz ">
                            <?php if ($_smarty_tpl->tpl_vars['job']->value['body']!='') {?> <span class="List_dete" style="color:#999;">已取消</span><?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['job']->value['is_browse']=='1'&&$_smarty_tpl->tpl_vars['job']->value['body']=='') {?>
                                <a href="javascript:void(0)" onclick="canceljob(<?php echo $_smarty_tpl->tpl_vars['job']->value['id'];?>
);" class="List_dete cblue">取消申请</a>
                            <?php } else { ?>
                                <a href="javascript:void(0)" onclick="layer_del('确定要删除？','index.php?c=job&act=del&id=<?php echo $_smarty_tpl->tpl_vars['job']->value['id'];?>
');" class="List_dete cblue">删除</a>
                            <?php }?>
                        </div>
                    </div>
                    -->

                    <div class="clear"></div>
                    <?php }
if (!$_smarty_tpl->tpl_vars['job']->_loop) {
?>
                    <div class="msg_no">
                        <p>亲爱的用户，您还没有申请过职位，想要获得更多工作机会</p>
                        <p>立即搜索您感兴趣的职位并申请吧！</p>
                        <a href="<?php echo smarty_function_url(array('m'=>'job'),$_smarty_tpl);?>
" target="_blank" class="msg_no_sq uesr_submit">搜索职位</a>
                    </div>
                    <?php } ?>
                </form>

                <?php if ($_smarty_tpl->tpl_vars['rows']->value) {?>
                <div class="diggg" style="margin-top:10px; float:right"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</div>
                <?php }?>
            </div>
        </div>
    </div>
</div>

<div style="padding:10px;display:none;" id='blackdiv'>
    <div class="Blacklist_box">
        <form action="index.php?c=job&act=qs" target="supportiframe" method="post" class="layui-form">
            <input type="hidden" value="" name="id" id="qsid">
            <div class="qxsq_box">
                <div class="Blacklist_box_qx" style="padding:10px 0; ">选择合适的取消原因</div>
                <select name="body" style="width:160px;">
                    <option value="已经找到工作">已经找到工作</option>
                    <option value="想休息一段时间">想休息一段时间</option>
                    <option value="生病了">生病了</option>
                    <option value="看错信息了">看错信息了</option>
                    <option value="很长时间没有查看">很长时间没有查看</option>
                    <option value="其它原因">其它原因</option>
                </select>
            </div>
            <div class="qxsq_box_bth" style="padding:10px 0; ">
                <input type="submit" value="确定" class="layui-btn layui-btn-normal" style="width:264px;">
            </div>
        </form>
    </div>
    <div class="clear"></div>
</div>
<?php echo '<script'; ?>
 type="text/javascript">
    layui.use(['layer', 'form'], function () {
        var layer = layui.layer,
            form = layui.form,
            $ = layui.$;
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['userstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }} ?>
