<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 16:04:10
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\member\user\index.htm" */ ?>
<?php /*%%SmartyHeaderCode:783762d9087abebc65-10773313%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5888889ce9d90f1504584d6c0b689063cf7ae8d5' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\member\\user\\index.htm',
      1 => 1640333832,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '783762d9087abebc65-10773313',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'resume' => 0,
    'msgnum' => 0,
    'yqnum' => 0,
    'statis' => 0,
    'atnnum' => 0,
    'rlist' => 0,
    'config' => 0,
    'expectInfo' => 0,
    'wxbindshow' => 0,
    'lunbo' => 0,
    'ainfo' => 0,
    'alist' => 0,
    'canroom' => 0,
    'time' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d9087aef2e01_10565771',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d9087aef2e01_10565771')) {function content_62d9087aef2e01_10565771($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\modifier.date_format.php';
if (!is_callable('smarty_function_url')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.url.php';
?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['userstyle']->value)."/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div id="bg" <?php if ($_smarty_tpl->tpl_vars['resume']->value['name']=='') {?>style="display:block" <?php }?>></div>
<div class="yun_w1200">
    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['userstyle']->value)."/left.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <div class="yun_m_rightsidebar">
        <div class="yun_m_index_date_box">
            <div class="yun_m_index_date_box_c">
                <div class="yun_m_index_date_list">
                    <a href="index.php?c=invite">
                        <i class="yun_m_index_date_icon1"></i><?php if ($_smarty_tpl->tpl_vars['msgnum']->value) {?><span class="yun_m_n"><?php echo $_smarty_tpl->tpl_vars['msgnum']->value;?>
</span><?php }?>
                        <div class="yun_m_index_datename">面试通知</div>
                        <div class="yun_m_index_date_n">
                            <span class="yun_m_index_d_c"><?php echo $_smarty_tpl->tpl_vars['yqnum']->value;?>
</span>
                        </div>
                    </a>
                </div>
                <div class="yun_m_index_date_list">
                    <a href="index.php?c=job">
                        <i class="yun_m_index_date_icon2"></i>
                        <div class="yun_m_index_datename">申请记录</div>
                        <div class="yun_m_index_date_n"> <?php echo $_smarty_tpl->tpl_vars['statis']->value['sq_jobnum'];?>
</div>
                    </a>
                </div>
                <div class="yun_m_index_date_list">
                    <a href="index.php?c=favorite">
                        <i class="yun_m_index_date_icon3"></i>
                        <div class="yun_m_index_datename">收藏记录</div>
                        <div class="yun_m_index_date_n"> <?php echo $_smarty_tpl->tpl_vars['statis']->value['fav_jobnum'];?>
</div>
                    </a>
                </div>
                <div class="yun_m_index_date_list yun_m_index_date_list_end">
                    <a href="index.php?c=atn">
                        <i class="yun_m_index_date_icon4"></i>
                        <div class="yun_m_index_datename">我的关注</div>
                        <div class="yun_m_index_date_n"> <?php echo $_smarty_tpl->tpl_vars['atnnum']->value;?>
</div>
                    </a>
                </div>
            </div>
 
            <div class="yun_m_index_resume">
                <div class="yun_m_index_resume_tit">
                    <div class="yun_m_index_resume_span">我的简历</div>
                    <?php if (!empty($_smarty_tpl->tpl_vars['rlist']->value)) {?>
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
<span class="user_resume_job"><?php echo $_smarty_tpl->tpl_vars['expectInfo']->value['name'];?>
</span></div>
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
                                <?php echo $_smarty_tpl->tpl_vars['expectInfo']->value['jobstatus_n'];?>
-<?php echo $_smarty_tpl->tpl_vars['expectInfo']->value['report_n'];?>

                            </div>
                        </div>
                        <div class="user_resume_c">
                            <div class="user_resume_wzd">
                                <span class="user_resume_wzd_name">简历完整度：</span>
                                <div class="user_resume_wzd_b"><span class="user_resume_wzd_c" style="width:<?php echo $_smarty_tpl->tpl_vars['expectInfo']->value['integrity'];?>
%"></span></div>
                                <span class="user_resume_wzd_r"><?php echo $_smarty_tpl->tpl_vars['expectInfo']->value['integrity'];?>
%</span>
                            </div>
                            <div class="clear"></div>
                            <div class="user_resume_p user_resume_pd">更新日期：<?php if ($_smarty_tpl->tpl_vars['resume']->value['lastupdate']) {
echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['resume']->value['lastupdate'],'%Y-%m-%d %H:%M:%S');
} else { ?>未更新<?php }?></div>
                            <div class="user_resume_p">被浏览：<?php echo $_smarty_tpl->tpl_vars['expectInfo']->value['hits'];?>
</div>
                        </div>
                        <div class="user_resume_cz">
                            <div class="user_resume_cz_p">
                                <a onclick="layer_del('确定要刷新？', 'index.php?c=resume&act=refresh&id=<?php echo $_smarty_tpl->tpl_vars['expectInfo']->value['id'];?>
');" href="javascript:void(0)" class="user_resume_cz_a user_resume_cz_icon2">刷新简历</a>
                            </div>
                            <div class="user_resume_cz_p"><a href="<?php echo smarty_function_url(array('m'=>'resume','c'=>'show','id'=>$_smarty_tpl->tpl_vars['expectInfo']->value['id']),$_smarty_tpl);?>
" class="user_resume_cz_a user_resume_cz_icon4">预览简历</a></div>
                            <?php if ($_smarty_tpl->tpl_vars['expectInfo']->value['state']==1) {?>
                                <?php if ($_smarty_tpl->tpl_vars['expectInfo']->value['top_day']) {?>
                                    <div class="user_resume_cz_p">
                                        <a href="javascript:void(0)" onclick="resumetop('<?php echo $_smarty_tpl->tpl_vars['expectInfo']->value['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['expectInfo']->value['top_day'];?>
','<?php echo $_smarty_tpl->tpl_vars['expectInfo']->value['name'];?>
')" class="user_resume_cz_a user_resume_cz_icon1">简历置顶 <span class="user_resume_cz_yzd">置顶</span>
                                        </a>
                                    </div>
                            <?php } else { ?>
                            <div class="user_resume_cz_p">
                                <a href="javascript:void(0)" onclick="resumetop('<?php echo $_smarty_tpl->tpl_vars['expectInfo']->value['id'];?>
','','<?php echo $_smarty_tpl->tpl_vars['expectInfo']->value['name'];?>
')" class="user_resume_cz_a user_resume_cz_icon1">简历置顶 </a>
                            </div>
                            <?php }?>

                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['expectInfo']->value['doc']>0) {?>
                            <div class="user_resume_cz_p">
                                <a href="index.php?c=expectq&e=<?php echo $_smarty_tpl->tpl_vars['expectInfo']->value['id'];?>
" class="user_resume_cz_a user_resume_cz_icon3">修改简历</a>
                            </div>
                            <?php } else { ?>
                            <div class="user_resume_cz_p">
                                <a href="index.php?c=expect&e=<?php echo $_smarty_tpl->tpl_vars['expectInfo']->value['id'];?>
" class="user_resume_cz_a user_resume_cz_icon3">修改简历</a>
                            </div>
                            <?php }?>
                        </div>
                    </div>
                    <?php if ($_smarty_tpl->tpl_vars['expectInfo']->value['state']==3) {?>
                    <div class="user_resume_boxtip">
                        <div class="user_resume_boxtip_c">
                            <div class="user_resume_boxtip_h1">你的简历审核未通过！</div>
                            <?php if ($_smarty_tpl->tpl_vars['expectInfo']->value['statusbody']) {?><div class="user_resume_boxtip_p">原因：<?php echo $_smarty_tpl->tpl_vars['expectInfo']->value['statusbody'];?>
</div><?php }?>
                            <div class="user_resume_boxtip_p">请修改简历信息，提交管理员审核</div>
                            <a href="index.php?c=expect&e=<?php echo $_smarty_tpl->tpl_vars['expectInfo']->value['id'];?>
" class="user_resume_boxtip_bth" <?php if ($_smarty_tpl->tpl_vars['expectInfo']->value['statusbody']) {?>style="margin-top: 15px;"<?php }?>>完善信息 </a>
                        </div>
                    </div>
                    <?php } elseif ($_smarty_tpl->tpl_vars['expectInfo']->value['integrity']<100) {?>
                        <div class="user_resume_boxtip">
                            <div class="user_resume_boxtip_c">
                                <div class="user_resume_boxtip_h1">你的简历缺少<?php echo $_smarty_tpl->tpl_vars['expectInfo']->value['wstitle'];?>
，会极大影响求职成功率哦！</div>
                                <div class="user_resume_boxtip_p">完善<?php echo $_smarty_tpl->tpl_vars['expectInfo']->value['wstitle'];?>
，可以有效提高求职成功率</div>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['expectInfo']->value['wspcurl'];?>
" class="user_resume_boxtip_bth">完善<?php echo $_smarty_tpl->tpl_vars['expectInfo']->value['wstitle'];?>
 </a>
                            </div>
                        </div>
                    <!--未开启情况提示-->
                    <?php } elseif ($_smarty_tpl->tpl_vars['expectInfo']->value['status']==2||$_smarty_tpl->tpl_vars['expectInfo']->value['status']==3) {?>
                    <div class="user_resume_boxtip">
                        <div class="user_resume_boxtip_c">
                            <div class="user_resume_boxtip_h1">你的简历已隐藏，企业无法主动发现你！</div>
                            <div class="user_resume_boxtip_p">开启简历，好工作快速找你</div>
                            <a href="index.php?c=privacy" class="user_resume_boxtip_bth">公开简历 </a>
                        </div>
                    </div>
                    <?php }?>

                    <div class="yun_wtbd_tip <?php if (!$_smarty_tpl->tpl_vars['wxbindshow']->value) {?>none<?php }?>">
                        <div class="yun_wtbd_tip_p"> 绑定微信，可便捷操作职位搜索、创建管理求职简历、简历投递实时追踪，投递进度快速提醒...等，随时随地轻松找工作<a href="javascript:;" class="wxtitle yun_wtbd_tip_bth">绑定微信</a></div>
                    </div>
                    <?php } else { ?>
                    <div class="member_right_no_job">
                        <div class="member_right_no_job_box ">
                            <div class="yun_m_index_job_icon"></div>
                            <div class="member_right_no_jobr"> 你还没有创建简历，无法申请职位<br>
                                <a href="index.php?c=expect&act=add" class="member_right_no_jobr_bth" style="text-decoration:underline">创建简历</a>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
			<!-- 广告位放这-->
			<?php  $_smarty_tpl->tpl_vars["lunbo"] = new Smarty_Variable; $_smarty_tpl->tpl_vars["lunbo"]->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
global $db,$db_config,$config;$AdArr=array();$paramer=array();$attr=array("classid"=>"510","item"=>"\"lunbo\"","key"=>"'key'","random"=>"1","nocache"=>"")
;
			include(PLUS_PATH.'pimg_cache.php');$add_arr = $ad_label[510];if(is_array($add_arr) && !empty($add_arr)){
				$i=0;$limit = 0;$length = 0;
				foreach($add_arr as $key=>$value){
					if($config['did']){
						if(($value['did']==$config['did']|| $value['did']==-1)&&$value['start']<time()&&$value['end']>time()){
							if($i>0 && $limit==$i){
								break;
							}
							if($length>0){
								$value['name'] = mb_substr($value['name'],0,$length);
							}
							if($paramer['type']!=""){
								if($paramer['type'] == $value['type']){
									$AdArr[] = $value;
								}
							}else{
								$AdArr[] = $value;
							}
							$i++;
						}
						
					}else{
						if(($value['did']==-1 || !$value['did']) && $value['start']<time()&&$value['end']>time()){
							if($i>0 && $limit==$i){
								break;
							}
							if($length>0){
								$value['name'] = mb_substr($value['name'],0,$length);
							}
							if($paramer['type']!=""){
								if($paramer['type'] == $value['type']){
									$AdArr[] = $value;
								}
							}else{
								$AdArr[] = $value;
							}
							$i++;
						}
						
					}
				}
				if (isset($attr['random']) && $attr['random'] && count($AdArr) > $attr['random']) {
			        $temp = [];
			        $random_keys = array_rand($AdArr, $attr['random']);

			        if($attr['random'] == 1) {
			            $temp[] = $AdArr[$attr['random']];
			        } else {
			            foreach ($AdArr as $key => $value) {
			                if (in_array($key, $random_keys)) {
			                    $temp[$key] = $value;
			                }
			            }
			        }
			        $AdArr = $temp;
		        }
			}$AdArr = $AdArr; if (!is_array($AdArr) && !is_object($AdArr)) { settype($AdArr, 'array');}
foreach ($AdArr as $_smarty_tpl->tpl_vars["lunbo"]->key => $_smarty_tpl->tpl_vars["lunbo"]->value) {
$_smarty_tpl->tpl_vars["lunbo"]->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars["lunbo"]->key;
?>
			<div class="yun_combanner"><?php echo $_smarty_tpl->tpl_vars['lunbo']->value['html'];?>
</div>
			<?php } ?>
			<!-- 广告位放这 end-->
            <?php if ($_smarty_tpl->tpl_vars['ainfo']->value) {?>
            <div class="yun_user_index_jobmsg_gz  sxl">
                <span class="yun_user_index_jobmsg_gz_name"> 企业动态</span>
                <ul class="user_in_gz sxlist">
                    <?php  $_smarty_tpl->tpl_vars['alist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['alist']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ainfo']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['alist']->key => $_smarty_tpl->tpl_vars['alist']->value) {
$_smarty_tpl->tpl_vars['alist']->_loop = true;
?>
                    <li>你关注的<a href="<?php echo smarty_function_url(array('m'=>'company','c'=>'show','id'=>$_smarty_tpl->tpl_vars['alist']->value['sc_uid']),$_smarty_tpl);?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['alist']->value['com_name'];?>
</a>发布了<a href="<?php echo smarty_function_url(array('m'=>'job','c'=>'comapply','id'=>$_smarty_tpl->tpl_vars['alist']->value['id']),$_smarty_tpl);?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['alist']->value['jobname'];?>
</a>职位</li>
                    <?php } ?>
                </ul>
            </div>
            <?php }?>
        </div>

        <div class="member_right_box_banner fltL" style="width:100%; overflow:hidden"></div>

        <div class="yun_m_index_job mt20 fltL">
            <div class="yun_m_index_job_tit"><span class="yun_m_index_job_tit_s">也许适合你的岗位</span></div>
            <?php if (empty($_smarty_tpl->tpl_vars['rlist']->value)) {?>
            <div class="member_right_no_job">
                <div class="member_right_no_job_box ">
                    <div class="yun_m_index_job_icon"></div>
                    <div class="member_right_no_jobr">
                        创建简历以后，系统会根据您的简历，<br>
                        通过后台算法为您匹配最适合您的招聘职位<br>
                        <a href="index.php?c=expect&act=add" class="member_right_no_jobr_bth" style="text-decoration:underline">创建简历</a>
                    </div>
                </div>
            </div>
            <?php } else { ?>
            <div id="joblist" class="member_right_job_box">
                <div id="nojoblist" class="member_right_no_job none">
                    <div class="member_right_no_job_box ">
                        <div class="yun_m_index_job_icon"></div>
                        <div class="yun_m_index_job_tip"> 没有适合的职位</div>
                    </div>
                </div>
            </div>
            <?php }?>
        </div>
    </div>
    <div class="clear"></div>
</div>
<!--fristtck start-->
<div class="index_no_resume_box" id="yingdao" style="display:none;">
    <div class="yun_prompt_writingicon" style="padding-top:0px"><i class="yun_prompt_writingicon_cj"></i></div>
    <div class="yun_prompt_writing">亲，您还没有简历</div>
    <div class="yun_prompt_writing_obtain">简历是求职第一步，优质的简历助您找到满意工作！</div>
    <div class="yun_prompt_writing_tip">创建简历请认真填写</div>
    <div class="yun_prompt_writing_operation">
        <a href="index.php?c=expect&act=add" class="yun_prompt_writing_operation_bth">立即创建简历</a>
        <a class="close_yd" href="javascript:void(0)">暂不创建</a>
    </div>
</div>
<!--fristtck end-->

<div id="bdwx" style="display:none;">
    <div class="yun_wxbd_tit">关注微信公众号，手机轻松求职</div>
    <div class="yun_wxbd_box">
        <div class="yun_wxbd_img_c">
            <div class="yun_wxbd_img" id="wx_login_qrcode"></div>
        </div>
        <div id="wx_sx" class="none">
            <div class="wx_login_show_sxbox"><a href="javascript:void(0);" onclick="getwxbindcode()" class="wx_login_show_sxicon"></a>二维码已失效点击刷新</div>
        </div>
        <div class="yun_wxbd_p"> 扫码关注公众号</div>
        <div class="yun_wxbd_ok">
            <a class="close_yd" href="javascript:void(0)">好，知道了</a>
        </div>
    </div>
</div>

<!--   Refresh  tck-->
<div id="shuaxin" class="" style="display:none;">

    <div class="yun_prompt_writingicon" style="padding-top:0px"><i class="yun_prompt_writingicon_pm"></i></div>
    <div class="yun_prompt_writing">刷新简历 , 提升排名</div>
    <div class="yun_prompt_writing_obtain">刷新简历引起企业的关注，提高邀请率</div>
    <div class="yun_prompt_writing_tip">刷新简历，可提升简历的显示排名，从而提高简历的曝光率</div>
    <div class="yun_prompt_writing_operation">
        <a href="javascript:void(0)" onclick="resumerefresh(<?php echo $_smarty_tpl->tpl_vars['rlist']->value['id'];?>
);" class="yun_prompt_writing_operation_bth">立即刷新简历</a>
        <a class="sx_bot_qx" href="javascript:void(0)">暂不刷新</a>
    </div>
</div>

<!--Refresh end-->
<div class="index_no_resume_box" id="spview" style="display:none;">
    <div class="yun_prompt_writingicon" style="padding-top:0px"><i class="yun_prompt_writingicon_cj"></i></div>
    <div class="yun_prompt_writing">您预约的视频面试</div>
    <div class="yun_prompt_writing_obtain"><?php if ($_smarty_tpl->tpl_vars['canroom']->value['sptime']!='') {
echo $_smarty_tpl->tpl_vars['canroom']->value['sptime'];
} else { ?>已开始，请及时参加！<?php }?></div>
    <div class="yun_prompt_writing_operation">
        <a href="index.php?c=spview" class="yun_prompt_writing_operation_bth">立即前往</a>
        <a class="close_yd" href="javascript:void(0)">暂不参加</a>
    </div>
</div>
<?php echo '<script'; ?>
 type="text/javascript">

    var setval = null,
        setwout = null;

    layui.use(['layer', 'form'], function () {
        var layer = layui.layer,
            form = layui.form,
            $ = layui.$;

        '<?php if ($_smarty_tpl->tpl_vars['rlist']->value['name']=='') {?>'
        var rlayer = layer.open({
            type: 1,
            title: '温馨提示',
            closeBtn: 0,
            area: ['400px', '330px'],
            content: $("#yingdao"),

        });
        $(".close_yd").click(function () {
            layer.close(rlayer);
        })
        '<?php } elseif ($_smarty_tpl->tpl_vars['rlist']->value['name']!=''&&$_smarty_tpl->tpl_vars['rlist']->value['lastupdate']<$_smarty_tpl->tpl_vars['time']->value&&$_COOKIE['exprefresh']!="1"&&$_smarty_tpl->tpl_vars['config']->value["resume_sx"]==2) {?>'
        var shuaxinlayer = layer.open({
            type: 1,
            title: '刷新简历',
            closeBtn: 0,
            area: ['500px', '330px'],
            content: $("#shuaxin")
        });
        $(".sx_bot_qx").click(function () {
            layer.close(shuaxinlayer);
        })
        '<?php } elseif ($_smarty_tpl->tpl_vars['rlist']->value['name']!=''&&$_smarty_tpl->tpl_vars['config']->value['wx_popWin']==1&&$_COOKIE['exprefresh']=="1"&&$_COOKIE['wxbd']!="1"&&$_smarty_tpl->tpl_vars['wxbindshow']->value) {?> '
        getwxbindcode();
        '<?php } elseif ($_smarty_tpl->tpl_vars['rlist']->value['name']!=''&&$_COOKIE['exprefresh']=="1"&&$_COOKIE['wxbd']=="1"&&$_COOKIE['spview']!="1"&&!empty($_smarty_tpl->tpl_vars['canroom']->value)) {?> '
        var slayer = layer.open({
            type: 1,
            title: '温馨提示',
            closeBtn: 0,
            area: ['400px', '260px'],
            content: $("#spview"),
        });
        $(".close_yd").click(function () {
            layer.close(slayer);
        })
        '<?php }?>'
    });

    //在本页面进行求职状态信息修改和保存
    $(document).ready(function () {
        setTimeout(function () {
            showresumelist('<?php echo $_smarty_tpl->tpl_vars['rlist']->value['id'];?>
');
            hsjoblist('<?php echo $_smarty_tpl->tpl_vars['rlist']->value['id'];?>
');
        }, 200);

        $("#jobstatuslist").show();
        $("#jobstatusupadte").hide();
        $(".sx_top_t_xg").click(function () {
            $("#jobstatuslist").hide();
            $("#jobstatusupadte").show();
        });
        $('#show_resume').delegate('span', 'click', function () {
            $(this).parent().click();
        });

        $('.wxtitle').click(function () {
            getwxbindcode();
        });
        marquee("3000", ".sxl .sxlist");
    });


    function getwxbindcode() {
        var wxlayer = layer.open({
            type: 1,
            title: false,
            closeBtn: 0,
            area: ['350px', '330px'],
            content: $("#bdwx"),
            end: function () {
                if (setval) {
                    clearInterval(setval);
                    setval = null;
                }
                if (setwout) {
                    clearTimeout(setwout);
                    setwout = null;
                }
            }
        });

        $.post('<?php echo smarty_function_url(array('m'=>'login','c'=>'wxlogin'),$_smarty_tpl);?>
', {t: 1}, function (data) {
            if (data == 0) {
                $('#wx_login_qrcode').html('二维码获取失败..');
            } else {
                $('#wx_login_qrcode').html('<img src="' + data + '" width="180" height="180">');
                setval = setInterval(function () {
                    $.post('<?php echo smarty_function_url(array('m'=>'login','c'=>'getwxloginstatus'),$_smarty_tpl);?>
', {t: 1}, function (data) {
                        var data = eval('(' + data + ')');
                        if (data.url != '' && data.msg != '') {
                            clearInterval(setval);
                            setval = null;
                            layer.msg(data.msg, 2, 9, function () {
                                window.location.href = data.url;
                            });
                        } else if (data.url) {
                            window.location.href = data.url;
                        }
                    });
                }, 2000);
                if (setwout) {
                    clearTimeout(setwout);
                    setwout = null;
                }
                setwout = setTimeout(function () {
                    clearInterval(setval);
                    setval = null;
                    var wx_sx = $("#wx_sx").html();
                    $('#wx_login_qrcode').html(wx_sx);
                }, 300 * 1000);
            }
        });

        $(".close_yd").click(function () {
            clearInterval(setval);
            layer.close(wxlayer);
        })
    }

    function show_resume(id) {
        if ($(".index_resume_my_n #" + id).is(':hidden')) {
            $(".index_resume_my_n #" + id).css('display', 'block');
        } else {
            $(".index_resume_my_n #" + id).css('display', 'none');
        }
    }

    function showresumelist(id) {
        if (id != '') {
            $.get('index.php?c=index&act=resumeajax', {
                rand: Math.random(),
                id: id
            }, function (data) {
                var data = eval("(" + data + ")");

                var $html = '<div class="member_index_resume_box" id="resumelist' + data.id + '" ><div class="member_index_resume_t"> <div class="yun_m_index_resume_QQ">';

                if (data.state == 1) {
                    $html += '<font color="green">简历<br>已审核</font>';
                } else if (data.state == 0) {
                    $html += '<font color="#f00">简历<br>审核中</font></span>';
                } else if (data.state == 3) {
                    $html += '<font color="#f00">未通过<br>审核</font></span>';
                }
                $html += '</div>' +
                    '<div class="member_index_resume_t_left">' +
                    '<div class="member_index_resume_t_name fltL">' +
                    '<div class="member_index_resume_t_name_l member_index_resume_t_name_w80 fltL"> 简历名称：</div>' +
                    '<div class="index_resume_my_n" id="show_resume" onclick="show_resume(\'resume_expect' + data.id + '\')"> ' + data.resumelist + ' </div>' +
                    '<div class="index_resume_my_ll">被浏览：' + data.hits + ' 次 </div></div>' +
                    ' <div class="member_index_resume_t_wz fltL">' +
                    ' <div class="member_index_resume_t_name_l fltL"> 完整度 <span class="member_index_resume_t_wz_n">' + data.integrity + '%</span></div>' +
                    ' <div class="member_index_resume_t_wzd"> ' +
                    '<span class="member_index_resume_t_wz_b"> ' +
                    '<em class="member_index_resume_t_wz_c" style="width:' + data.integrity + '%"><i class="ember_index_resume_t_wz_c_q"></i></em></span> ' +
                    ' </div></div>' +
                    '<div class="member_index_resume_job fltL"><span class="member_index_resume_t_name_l member_index_resume_t_name_w80 fltL">期望职位：</span>' +
                    '<span class="member_index_resume_jobname">' + data.jobname + '</span><span class="member_index_resume_jobxz">期望薪资：' + data.salary + '</span><span class="member_index_resume_time">更新时间：' + data.lastupdate + '</span> </div></div><div class="member_index_resume_t_cz fltR"><div  class="member_index_resume_set">';
                if (data.status == 1) {
                    $resume_status = '简历已公开';
                } else if (data.status == 3) {
                    $resume_status = '仅对投递企业可见';
                } else {
                    $resume_status = '简历已保密';
                }
                $html += '<a href="index.php?c=privacy"> <div class="yun_user_index_set_name">' + $resume_status + '</div></a>';

                $html += '</div><div class="member_index_resume_t_cz_b">';
                if (data.state == 1) {
                    if (data.topdatetime > 0) {
                        $html += '<a href="javascript:void(0)" onclick="resumetop(\'' + data.id + '\',\'' + data.topdate + '\',\'' + data.name + '\')" class="member_index_resume_t_cz_bth ">简历置顶</a>';
                    } else {
                        $html += '<a href="javascript:void(0)" onclick="resumetop(\'' + data.id + '\',\'\',\'' + data.name + '\')" class="member_index_resume_t_cz_bth ">简历置顶</a>';
                    }
                }

                if (data.doc > 0) {
                    $html += ' <a href="index.php?c=expectq&e=' + data.id + '" class="member_index_resume_t_cz_bth ">修改简历</a> ';
                } else {
                    $html += ' <a href="index.php?c=expect&e=' + data.id + '" class="member_index_resume_t_cz_bth ">修改简历</a> ';
                }

                $html += '<a href="' + data.url + '" target="_blank" class="member_index_resume_t_cz_bth mt15">预览简历</a> <a onclick="layer_del(\'确定要刷新？\', \'index.php?c=resume&act=refresh&id=' + data.id + '\');" href="javascript:void(0)" class="member_index_resume_t_cz_bth member_index_resume_t_cz_bth_hover mt15">刷新简历</a></div> <div class="member_index_resume_t_cz_tip" id="re' + data.id + '"> 刷新简历可提升排名，每天一刷，提高求职成功率！<i class="member_index_resume_t_cz_tip_lt"></i><a href="javascript:;" onclick="$(\'#re' + data.id + '\').hide();" class="member_index_resume_t_cz_tip_close"></a></div></div></div>';
                if ((data.edu == 0 || data.training == 0 || data.skill == 0 || data.work == 0 || data.project == 0 || data.other == 0) && data.doc == 0) {
                    $html += '<div class="member_index_resume_msg"><div class="member_index_resume_msg_r"><div class="member_index_resume_msg_r_t"> 您还有以下资料没有填写 <span class="member_index_resume_msg_span">（为了更快的找到工作，建议您立即完善简历！）</span> </div>';
                    if (data.work == 0) {
                        $html += '<a href="index.php?c=expect&e=' + data.id + '#work_upbox" class="member_index_resume_msg_a">+ 工作经历</a>';
                    }
                    if (data.edu == 0) {
                        $html += '<a href="index.php?c=expect&e=' + data.id + '#edu_upbox" class="member_index_resume_msg_a">+ 教育经历</a>';
                    }
                    if (data.training == 0) {
                        $html += '<a href="index.php?c=expect&e=' + data.id + '#training_upbox" class="member_index_resume_msg_a">+ 培训经历</a>';
                    }
                    if (data.skill == 0) {
                        $html += '<a href="index.php?c=expect&e=' + data.id + '#skill_upbox" class="member_index_resume_msg_a">+ 职业技能</a>';
                    }
                    if (data.project == 0) {
                        $html += '<a href="index.php?c=expect&e=' + data.id + '#project_upbox" class="member_index_resume_msg_a">+ 项目经历</a>';
                    }
                    if (data.other == 0) {
                        $html += '<a href="index.php?c=expect&e=' + data.id + '#other_upbox" class="member_index_resume_msg_a">+ 其他信息</a>';
                    }
                    if (!data.description) {
                        $html += '<a href="index.php?c=expect&e=' + data.id + '#description_upbox" class="member_index_resume_msg_a">+ 自我评价</a>';
                    }
                    $html += '</div></div>';
                }
                $html += ' </div>'

                $("#myresumelist").html($html);
            })
        }
    }

    function hsjoblist(id) {
        if (id != '') {
            $.get('index.php?c=index&act=jobajax', {
                rand: Math.random()
            }, function (data) {
                var res = JSON.parse(data);
                if (res.isnew == 1) {
                    $('.yun_m_index_job_tit_s').html('最新岗位');
                } else {
                    $('.yun_m_index_job_tit_s').html('也许适合你的岗位');
                }
                if (res.list.length > 0) {
                    var html = '';
                    for (var i = 0; i < res.list.length; i++) {
                        html += '<ul><li class="yun_index_joblist"><div class="yun_index_joblist_jobname">';
                        html += '<a href="' + res.list[i].joburl + '" class="member_right_job_box_name cblue" target="_blank">' + res.list[i].name + '</a></div>';
                        html += '<div class="yun_index_joblist_comname"><a href="' + res.list[i].comurl + '" target="_blank">' + res.list[i].com_name + '</a></div>';
                        html += '<div class="yun_index_joblist_xz"><span class="member_right_job_xz">' + res.list[i].jobsalary + '</span></div>';
                        html += '<div class="yun_index_joblist_yq nowrap">' + res.list[i].citytwo + ' | ' + res.list[i].edu_n + ' | ' + res.list[i].exp_n + '经验</div></li></ul>';
                    }
                    $("#joblist").prepend(html);
                } else {
                    $("#nojoblist").removeClass('none');
                }
            })
        }
    }

    function marquee(time, id) {
        $(function () {
            var _wrap = $(id);
            var _interval = time;
            var _moving;
            _wrap.hover(function () {
                clearInterval(_moving);
            }, function () {
                _moving = setInterval(function () {
                    var _field = _wrap.find('li:first');
                    var _h = _field.height();
                    _field.animate({
                        marginTop: -_h + 'px'
                    }, 800, function () {
                        _field.css('marginTop', 0).appendTo(_wrap);
                    })
                }, _interval)
            }).trigger('mouseleave');
        });
    }

    function resumerefresh(id) {
        var jobstatus = $.trim($("#jobstatusid").val());
        $.post("index.php?c=resume&act=resumerefresh", {jobstatus: jobstatus, id: id}, function (data) {
            if (data == "1") {
                layer.msg("刷新成功！", 2, 9, function () {
                    window.location.reload();
                });
                return false;
            }
        });
    }
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['userstyle']->value)."/server.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['userstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
