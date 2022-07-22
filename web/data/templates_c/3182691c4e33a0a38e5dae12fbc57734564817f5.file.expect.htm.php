<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 16:00:57
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\member\user\expect.htm" */ ?>
<?php /*%%SmartyHeaderCode:1602862d907b90d5d99-96854331%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3182691c4e33a0a38e5dae12fbc57734564817f5' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\member\\user\\expect.htm',
      1 => 1643012866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1602862d907b90d5d99-96854331',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'user_style' => 0,
    'config' => 0,
    'style' => 0,
    'userdata' => 0,
    'v' => 0,
    'userclass_name' => 0,
    'resume' => 0,
    'user_sex' => 0,
    'row' => 0,
    'work' => 0,
    'edu' => 0,
    'project' => 0,
    'training' => 0,
    'skill' => 0,
    'other' => 0,
    'show' => 0,
    'pic' => 0,
    'resume_row' => 0,
    'rows' => 0,
    'statis' => 0,
    'j' => 0,
    'jionly' => 0,
    'cionly' => 0,
    'industry_index' => 0,
    'industry_name' => 0,
    'data' => 0,
    'tv' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d907b96fed04_22103506',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d907b96fed04_22103506')) {function content_62d907b96fed04_22103506($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\modifier.date_format.php';
if (!is_callable('smarty_function_url')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.url.php';
?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['userstyle']->value)."/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/public_search/index_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<link href="<?php echo $_smarty_tpl->tpl_vars['user_style']->value;?>
/images/m_resume.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/css" rel="stylesheet"/>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/style/class.public.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/css"/>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['user_style']->value;?>
/js/resume.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/data/plus/job.cache.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/data/plus/jobparent.cache.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/data/plus/city.cache.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/data/plus/cityparent.cache.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/javascript"><?php echo '</script'; ?>
>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/style/newclass.public.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/css"/>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/newclass.public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/javascript"><?php echo '</script'; ?>
> 
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/class.public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/javascript"><?php echo '</script'; ?>
> 
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['user_style']->value;?>
/js/jquery.scrollto.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
<style>
	.layui-form-selectup dl {
	    bottom: auto;
	}
</style>
<?php echo '<script'; ?>
>

var user_sqintegrity = '<?php echo $_smarty_tpl->tpl_vars['config']->value['user_sqintegrity'];?>
';
var rname_num = '<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_rname_num'];?>
';
var sy_resumename_num = '<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_resumename_num'];?>
';
function addEdu(){
	$("#addedu").append(function(){
		$(".lastupbox").removeClass("lastupbox");
		var randnum='e'+parseInt(Math.random()*1000); 
		var html="<li class='yun_resume_popup newresumebox lastupbox' id='"+randnum+"'><i class='yun_resume_popup_del showedunum' id='ie"+randnum+"' onclick=\"deleteupbox('"+randnum+"','ie"+randnum+"','showedunum','edu')\">删除</i><input type='hidden' name='id[]' value='' class='"+randnum+"'/><input type='hidden' name='nameid[]' value='n"+randnum+"'><input type='hidden' name='eduid[]' value='e"+randnum+"'><input type='hidden' name='specid[]' value='sp"+randnum+"'><input type='hidden' name='sdateid[]' value='s"+randnum+"'><input type='hidden' name='edateid[]' value='ed"+randnum+"'><input type='hidden' name='timeid[]' value='ie"+randnum+"'><input type='hidden' class='usededu' name='usedid[]' value=''><div class='yun_resume_popup_list'><span class='yun_resume_popup_name'><i class='yun_resume_popup_bt'>*</i>学校名称：</span><div class='yun_resume_popup_qyname'><input type='text' name='name[]' id='edu_name' value=''placeholder='必填' onfocus=\"hidemsg('medun"+randnum+"')\" onblur=\"hidemsg('medun"+randnum+"')\" class='yun_resume_popup_text'><i class='yun_resume_popup_qyname_tip' id='medun"+randnum+"' style='display:none'>请填写学校名称</i></div></div><div class='yun_resume_popup_list'><span class='yun_resume_popup_name'><i class='yun_resume_popup_bt'>*</i>在校时间：</span><div class='yun_resume_popup_list_box'><input type='text' id='edu_sdate"+randnum+"' name='sdate[]' value=''placeholder='选择开始时间' onfocus=\"hidemsg('medus"+randnum+"','meduie"+randnum+"')\" onblur=\"hidemsg('medus"+randnum+"','meduie"+randnum+"')\" class='yun_resume_popup_text yun_resume_popup_textw90'><?php echo '<script'; ?>
>layui.use(['laydate'], function(){var laydate = layui.laydate;monthclick(laydate,'#edu_sdate"+randnum+"');monthclick(laydate,'#edu_edate"+randnum+"');});<\/script><i class='yun_resume_popup_list_box_tip' id='medus"+randnum+"' style='display:none'>请选择开始日期</i></div><span class='yun_resume_popup_time'>至</span><div class='yun_resume_popup_list_box'><input type='text' id='edu_edate"+randnum+"' name='edate[]' value='' placeholder='选择结束时间'onfocus=\"hidemsg('meduie"+randnum+"','medued"+randnum+"')\" onblur=\"hidemsg('meduie"+randnum+"','medued"+randnum+"')\" class='yun_resume_popup_text yun_resume_popup_textw90'><i class='yun_resume_popup_list_box_tip' id='meduie"+randnum+"' style='display:none'>请确认日期先后顺序</i><i class='yun_resume_popup_list_box_tip' id='medued"+randnum+"' style='display:none'>请选择结束日期</i></div></div><div class='yun_resume_popup_list'><span class='yun_resume_popup_name'><i class='yun_resume_popup_bt'>*</i>学历：</span><div class='yun_resume_popup_chose_box '><div class='layui-form-item'><div class='layui-input-inline' style='width:384px; height:30px;'><select name='education[]' lay-filter='education' data-id='medue"+randnum+"' id='educationc"+randnum+"id'><option value=''>请选择最高学历</option><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_edu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?><option value='<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
'><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</option><?php } ?></select></div></div><i class='yun_resume_popup_qyname_tip' id='medue"+randnum+"' style='display:none'>请选择最高学历</i></div></div><div class='yun_resume_popup_list'><span class='yun_resume_popup_name'>所学专业：</span><div class='yun_resume_popup_qyname'><input type='text'  placeholder='请填写所学专业' name='specialty[]' id='edu_specialty' value='' class='yun_resume_popup_text'  onfocus=\"hidemsg('medusp"+randnum+"')\" onblur=\"hidemsg('medusp"+randnum+"')\"><i class='yun_resume_popup_qyname_tip' id='medusp"+randnum+"' style='display:none'>请填写所学专业</i></div></div></li>";
		
        return html;
    });
    layui.use(['form'], function(){
      layui.form.render();
    });
	$(".showedunum").show();
	var div = document.getElementById('edu_div');
	$("#edu_div").animate({scrollTop:div.scrollHeight},1000);
}
function addSkill(){
	var randnum='s'+parseInt(Math.random()*1000);
	$("#addskill").append(function(){
		$(".lastupbox").removeClass("lastupbox");
		var sfile = 'sfile'+randnum, simg = 'simg'+randnum ,sparent = 'sparent'+randnum;
		var html="<li class='yun_resume_popup newresumebox lastupbox' id='"+randnum+"'><i class='yun_resume_popup_del showskillnum' id='is"+randnum+"' onclick=\"deleteupbox('"+randnum+"','is"+randnum+"','showskillnum','skill')\">删除</i><input type='hidden' name='id[]' class='"+randnum+"' value=''/><input type='hidden' name='nameid[]' value='n"+randnum+"'><input type='hidden' name='timeid[]' value='is"+randnum+"'><input type='hidden' class='usedskill' name='usedid[]' value=''><input type='hidden' name='ingid[]' value='i"+randnum+"'><div class='yun_resume_popup_list'><span class='yun_resume_popup_name'><i class='yun_resume_popup_bt'>*</i>技能名称：</span><div class='yun_resume_popup_qyname'><input type='text' name='name[]' id='skill_name"+randnum+"' value='' placeholder='必填'onfocus=\"hidemsg('mskilln"+randnum+"')\" onblur=\"hidemsg('mskilln"+randnum+"')\" class='yun_resume_popup_text'><i class='yun_resume_popup_qyname_tip' id='mskilln"+randnum+"' style='display:none'>请填写技能名称</i></div></div><div class='yun_resume_popup_list'><span class='yun_resume_popup_name'>掌握时间：</span><input style='width:240px;' type='text' name='longtime[]' id='skill_longtime"+randnum+"' value='' onkeyup='this.value=this.value.replace(/[^0-9.]/g,'')' class='yun_resume_popup_text'><span style='line-height:30px;padding-left:10px;'>年</span></div><div class='yun_resume_popup_list'><span class='yun_resume_popup_name'><i class='yun_resume_popup_bt'>*</i>熟练程度：</span><div class='yun_resume_popup_chose_box'> <div class='layui-form-item'><div class='layui-input-inline' style='width:170px; height:32px;'><select name='ing[]' lay-filter='ingrand' id='ing"+randnum+"id' data-rand='"+randnum+"'><option value=''>请选择熟练程度</option><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_ing']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?><option value='<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
'><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</option><?php } ?></select><i class='yun_resume_popup_qyname_tip' id='mskilli"+randnum+"' style='display:none'>请选择熟练程度</i></div></div></div></div><div class='yun_resume_popup_list'><span class='yun_resume_popup_name'>上传证书：</span> <div class='photo_submit fl'><button type='button' class='yun_bth_pic skillupload"+randnum+"' lay-data=\"{fileid: '"+sfile+"',imgid: '"+simg+"',parentid: '"+sparent+"'}\">上传图片</button><input id='sfile"+randnum+"' type='hidden' name='cert[]' value=''/><div id='sparent"+randnum+"' class='photo_submit_pic none'> <img id='simg"+randnum+"' src='' width='38' height='38'></div></div></div></div></li>";
		return html;
    });
    layui.use(['form'], function(){
      layui.form.render();
    });
	
	layui.use('upload', function(){
		var upload = layui.upload;
		var layaccept = 'images', layexts = 'jpg|png|gif|bmp|jpeg';
		upload.render({
			elem: '.skillupload'+randnum+'' 
			//,url: weburl+'/index.php?m=ajax&c=layui_upload'
			,field: 'skillfile[]'
			,auto: false
			,bindAction: '#test9'   //触发上传的对象，暂未用到
			,accept: layaccept
			,exts: layexts
			,choose: function(obj){
				if(this.imgid){
					//预读本地文件示例，不支持ie8/9
					var imgid = null,
						parentid = null;
					if(this.imgid){
						imgid = this.imgid;
					}
					if(this.parentid){
						parentid = this.parentid;
					}
					obj.preview(function(index, file, result){
						if (parentid && $('#'+parentid).length>0){
							$('#'+parentid).removeClass('none');
							$('#'+imgid).attr('src', result); 
						}else if(imgid && $('#'+imgid).length>0){
							$('#'+imgid).removeClass('none');
							$('#'+imgid).attr('src', result); //图片链接（base64）
						}
						
					});
				}
			}
		});
	});
	
	$(".showskillnum").show();
	var div = document.getElementById('skill_div');
	$("#skill_div").animate({scrollTop:div.scrollHeight},1000);
}
 
$(window).load(function(){ 
	if($("#work_have").val()!=1){
		$("#work_empty").show();
	}
	if($("#edu_have").val()!=1){
		$("#edu_empty").show();
	}
	if($("#training_have").val()!=1){
		$("#training_empty").show();
	}
	if($("#skill_have").val()!=1){
		$("#skill_empty").show();
	}
	if($("#project_have").val()!=1){
		$("#project_empty").show();
	}
	if($("#other_have").val()!=1){
		$("#other_empty").show();
	}
	$(".yun_resume_select_box").hover(function(){ 
		$(this).find(".yun_resume_select_list").show();
	},function(){ 
		$(this).find(".yun_resume_select_list").hide();
	});
});  
$(document).ready(function (e) {
$(".warn").text("overflow:" + document.body.style.overflow + "， scroll:" + document.body.scroll + ",scrollHeight:" + document.body.scrollHeight + ",offsetHeight:" + document.body.offsetHeight);
    var scrollbottom = $(document).height() - $(window).height() - $(window).scrollTop();
    if (parseInt(scrollbottom) < 200) {
        $("#right_box").parent().css("bottom", (350 - (parseInt(scrollbottom))) + "px");
    } else if ($(window).scrollTop() < 200) {
        $("#right_box").parent().css("top", "200px");
    } else {
        $("#right_box").parent().css("bottom", "150px");
    }
    if ($(window).scrollTop() < 83) {
        $("#right_box").css("position", "");
    }
    $("#right_box").parent().slideDown();
    if (document.body.style.overflow != "hidden" && document.body.scroll != "no" && document.body.scrollHeight < document.body.offsetHeight) {
        $("#right_box").hide();
    } else {
        $(window).scroll(function () {
            var scrolltop = $(this).scrollTop();
            var scrollbottom = $(document).height() - $(this).height() - $(this).scrollTop();
            if (parseInt(scrolltop) > 83) {
                $("#right_box").css("position", "fixed");
                $("#right_box").css("top", "0px");
            } else {
                $("#right_box").css("position", "");
                $("#right_box").css("top", parseInt(scrolltop) + "px");
            }
            if (parseInt(scrollbottom) < 200) {
                $("#right_box").parent().css("bottom", ((200 - scrollbottom) + 150) + "px");
            } else {
                $("#right_box").parent().css("bottom", "150px");
            }
        });
    }
});

<?php echo '</script'; ?>
>
<div class="yun_resume_content">
<div class="yun_resume_left_box mt20">

<!--/*简历开始*/-->
<div class="yun_resume_box"> 
  <!--基本信息-->
  <div class="yun_resume_info ">
  <div class="yun_resume_info_bj " id="info_upbox" onclick="showMore('info','720','580','基本信息');" onmousemove="movelook('info');" onmouseout="outlook('info');">
	<div id="compile_info" class="yun_resume_handle" style="display:none">编辑</div>
    <div class="yun_resume_name"><?php echo $_smarty_tpl->tpl_vars['resume']->value['name'];?>
</div>
    <div class="yun_resume_p">    
    <?php echo $_smarty_tpl->tpl_vars['user_sex']->value[$_smarty_tpl->tpl_vars['resume']->value['sex']];?>
<span class="yun_resume_info_line">|</span>    
  <?php if ($_smarty_tpl->tpl_vars['resume']->value['age']) {
echo $_smarty_tpl->tpl_vars['resume']->value['age'];?>
岁<span class="yun_resume_info_line">|</span><?php }
if ($_smarty_tpl->tpl_vars['resume']->value['living']) {
echo $_smarty_tpl->tpl_vars['resume']->value['living'];?>
 <span class="yun_resume_info_line">|</span><?php }
if ($_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['resume']->value['edu']]) {
echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['resume']->value['edu']];?>
学历<span class="yun_resume_info_line">|</span><?php }
if ($_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['resume']->value['exp']]) {
echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['resume']->value['exp']];?>
经验<?php }?></div>
    <div class="yun_resume_p"><?php if ($_smarty_tpl->tpl_vars['resume']->value['marriage']) {
echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['resume']->value['marriage']];?>
<span class="yun_resume_info_line">|</span><?php }?> <?php if ($_smarty_tpl->tpl_vars['resume']->value['height']) {
echo $_smarty_tpl->tpl_vars['resume']->value['height'];?>
cm<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['resume']->value['height']&&$_smarty_tpl->tpl_vars['resume']->value['weight']) {?>/<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['resume']->value['weight']) {
echo $_smarty_tpl->tpl_vars['resume']->value['weight'];?>
kg<?php }?> <?php if ($_smarty_tpl->tpl_vars['resume']->value['weight']||$_smarty_tpl->tpl_vars['resume']->value['height']) {?><span class="yun_resume_info_line">|</span><?php }?> <?php if ($_smarty_tpl->tpl_vars['resume']->value['nationality']) {
echo $_smarty_tpl->tpl_vars['resume']->value['nationality'];?>
<span class="yun_resume_info_line">|</span><?php }?> <?php if ($_smarty_tpl->tpl_vars['resume']->value['domicile']) {
echo $_smarty_tpl->tpl_vars['resume']->value['domicile'];?>
<span class="yun_resume_info_line">|</span><?php }?> <?php if ($_smarty_tpl->tpl_vars['resume']->value['telphone']) {
echo $_smarty_tpl->tpl_vars['resume']->value['telphone'];
}
if ($_smarty_tpl->tpl_vars['resume']->value['email']) {?><span class="yun_resume_info_line">|</span><?php echo $_smarty_tpl->tpl_vars['resume']->value['email'];
}?></div>
    </div>
    <div class="expect_photo_box">
    <div class="expect_photo">
   
     <?php if ($_smarty_tpl->tpl_vars['row']->value['sex']==1) {?>
    <img src="<?php echo $_smarty_tpl->tpl_vars['resume']->value['photo'];?>
" width="80" height="80" id="logo" onerror="showImgDelay(this,'<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_member_icon'];?>
',2);">
    <?php } else { ?>
    <img src="<?php echo $_smarty_tpl->tpl_vars['resume']->value['photo'];?>
" width="80" height="80" id="logo" onerror="showImgDelay(this,'<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_member_iconv'];?>
',2);">
     <?php }?>       
      
	</div>
   	<div>
		<button type="button" class="yun_bth_pic mt10 adminupload" lay-data="{imgid: 'logo',path: 'user',uid: '<?php echo $_smarty_tpl->tpl_vars['resume']->value['uid'];?>
',usertype: '1'}">上传头像</button>
		<input type="hidden" id="layupload_type" value="2"/>
	 </div>
    </div>
  </div>
  
  <!--求职意向-->
  <div class="yun_resume_job_intention" style="display:block;" id="expect_upbox" onclick="showMore('expect','660','590','求职意向');" onmousemove="movelook('expect');" onmouseout="outlook('expect');">
    <div class="yun_resume_h1" ><span class="yun_resume_h1_s"><i class="yun_resume_h1_icon yun_resume_h1_iconyx"></i>求职意向</span></div>
    <div id="compile_expect" class="yun_resume_handle" style="dispaly:none">编辑</div>
    <ul class="yun_resume_job_intention_list " id="expect">
		<li>期望职位：<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
</li>
	
		<li>期望工作地点：<?php echo $_smarty_tpl->tpl_vars['row']->value['city_classname'];?>
</li>
		<li>期望从事行业：<?php echo $_smarty_tpl->tpl_vars['row']->value['hy_n'];?>
</li>
		<li>期望薪资：<?php echo $_smarty_tpl->tpl_vars['row']->value['salary'];?>
</li>
		<li>到岗时间：<?php echo $_smarty_tpl->tpl_vars['row']->value['report_n'];?>
</li>
		<li>期望工作性质：<?php echo $_smarty_tpl->tpl_vars['row']->value['type_n'];?>
</li>
		<li>求职状态：<?php echo $_smarty_tpl->tpl_vars['row']->value['jobstatus_n'];?>
</li>
        <li style="width:100%;">工作职能：<?php echo $_smarty_tpl->tpl_vars['row']->value['job_classname'];?>
</li>
    </ul>
  </div>
  <!--工作经历-->
  <div class="yun_resume_joblist" style="display: block;" id="work_upbox"  onclick="showMore('work','520','487','工作经历');" onmousemove="movelook('work');" onmouseout="outlook('work');">
    <div class="yun_resume_h1" ><span class="yun_resume_h1_s"><i class="yun_resume_h1_icon yun_resume_h1_iconjl"></i>工作经历</span></div>
    <div id="compile_work" class="yun_resume_handle" style="dispaly:none" >编辑</div>
    <ul class="yun_resume_tabulation" id="work">
    <?php if (is_array($_smarty_tpl->tpl_vars['work']->value)&&!empty($_smarty_tpl->tpl_vars['work']->value)) {?>
     <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['work']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
      <li class="yun_resume_exp_list" id="work<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
        <input type="hidden" id="work_have" value="1">
        <div class="yun_resume_exp_timt"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['sdate'],"%Y.%m");?>
-<?php if ($_smarty_tpl->tpl_vars['v']->value['edate']) {
echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['edate'],"%Y.%m");
} else { ?>&nbsp;&nbsp;至今<?php }?></div>
        <div class="yun_resume_exp_r">
          <div class="yun_resume_exp_name"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
<span class="yun_resume_exp_name_job"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</span></div>
          <div class="yun_resume_exp_p"><?php echo nl2br($_smarty_tpl->tpl_vars['v']->value['content']);?>
</div>
        </div>
		<a href="javascript:;" onclick="deleteTeam('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['eid'];?>
','work')" class="compile_delete">删除</a>
      </li>
      <?php } ?>
      <?php }?>
    </ul>
    <ul id="work_empty" style="display:none">
     <li class="yun_resume_exp_list  yun_resume_exp_list_color">
        <div class="yun_resume_exp_timt">2009.8-至今</div>
        <div class="yun_resume_exp_r">
          <div class="yun_resume_exp_name">XXX有限公司<span class="yun_resume_exp_name_job">产品研发</span></div>
          <div class="yun_resume_exp_p">
          1、主导XXX的版本迭代，并负责主要需求，协调开发、设计资源，推动项目进度，保证产品质量，打磨细节体验<br/>
          2、参与讨论及制订XXX的各版本需求，根据行业热点及用户反馈，提出有效的产品方案<br/>
          3、负责版本上线后的推广工作，通过官方网站和论坛等渠道将新功能触达用户<br/>
          4、跟进用户反馈并分析数据，持续优化已有功能
          </div>
        </div>
      </li>
    </ul>
  </div>
    <!--教育经历-->
    <div class="yun_resume_joblist" style="display: block;" id="edu_upbox" onclick="showMore('edu','520','451','教育经历');"  onmousemove="movelook('edu');" onmouseout="outlook('edu');">
      <div class="yun_resume_h1" ><span class="yun_resume_h1_s"><i class="yun_resume_h1_icon yun_resume_h1_iconjy"></i>教育经历</span></div><div id="compile_edu" style="dispaly:none" class="yun_resume_handle">编辑</div>
      <ul class="yun_resume_tabulation" id="edu">
      <?php if (is_array($_smarty_tpl->tpl_vars['edu']->value)&&!empty($_smarty_tpl->tpl_vars['edu']->value)) {?>
      <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['edu']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
        <li class="yun_resume_exp_list " id="edu<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
          <input type="hidden" id="edu_have" value="1">
          <div class="yun_resume_exp_timt"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['sdate'],"%Y.%m");?>
-<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['edate'],"%Y.%m");?>
</div>
          <div class="yun_resume_exp_r">
             <div class="yun_resume_exp_name"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
<span class="yun_resume_exp_name_job"><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value['education']];?>
</span></div>
            <div class="yun_resume_exp_p"><?php echo $_smarty_tpl->tpl_vars['v']->value['specialty'];?>
</div>
          </div>
		  <a href="javascript:;" onclick="deleteTeam('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['eid'];?>
','edu')" class="compile_delete">删除</a>
        </li>
       <?php } ?>
       <?php }?>
      </ul>
      <ul id="edu_empty" style="display:none">
       <li class="yun_resume_exp_list  yun_resume_exp_list_color" >
          <div class="yun_resume_exp_timt">2009.8-2013.6</div>
          <div class="yun_resume_exp_r">
             <div class="yun_resume_exp_name">XXX大学<span class="yun_resume_exp_name_job">本科</span></div>
            <div class="yun_resume_exp_p">计算机</div>
          </div>
        </li>
      </ul>
    </div>
	 <!--项目经历-->
    <div class="yun_resume_joblist" style="display: block;" id="project_upbox" onclick="showMore('project','520','480','项目经历');" onmousemove="movelook('project');" onmouseout="outlook('project');">
      <div class="yun_resume_h1" ><span class="yun_resume_h1_s"><i class="yun_resume_h1_icon yun_resume_h1_iconxm"></i>项目经历</span></div>
      <div id="compile_project" class="yun_resume_handle" style="dispaly:none" >编辑</div>
      <ul class="yun_resume_tabulation" id="project">
      <?php if (is_array($_smarty_tpl->tpl_vars['project']->value)&&!empty($_smarty_tpl->tpl_vars['project']->value)) {?>
      <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['project']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
        <li class="yun_resume_exp_list " id="project<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
          <input type="hidden" id="project_have" value="1">
          <div class="yun_resume_exp_timt"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['sdate'],"%Y.%m");?>
-<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['edate'],"%Y.%m");?>
</div>
          <div class="yun_resume_exp_r">
            <div class="yun_resume_exp_name"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
<span class="yun_resume_exp_name_job"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</span></div>
            <div class="yun_resume_exp_p"><?php echo $_smarty_tpl->tpl_vars['v']->value['content'];?>
</div>
          </div>
		  <a href="javascript:;" onclick="deleteTeam('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['eid'];?>
','project')" class="compile_delete">删除</a>
        </li>
        <?php } ?>
        <?php }?>
      </ul>
      <ul id="project_empty" style="display:none">
       <li class="yun_resume_exp_list  yun_resume_exp_list_color">
          <div class="yun_resume_exp_timt">2013.8-2015.8</div>
          <div class="yun_resume_exp_r">
            <div class="yun_resume_exp_name">“温暖明天”爱护行动<span class="yun_resume_exp_name_job">项目设计</span></div>
            <div class="yun_resume_exp_p">
            1、引导用户爱护身边每一样东西，倡导资源节约和合理利用。将节约下来的运营成本投入公益项目，帮助有困难的人<br/>
            2、项目上线期间，参与用户超过60万，引发了社会热议，许多网友对项目创意给予了高度的肯定<br/>
            3、项目获得XXX大学求是杯“云文化奖”金奖和XXX大学创新大赛微创新奖
            </div>
          </div>
        </li>
      </ul>
    </div>
    <!--培训经历-->
    <div class="yun_resume_joblist" style="display: block;" id="training_upbox" onclick="showMore('training','520','480','培训经历');" onmousemove="movelook('training');" onmouseout="outlook('training');">
      <div class="yun_resume_h1" ><span class="yun_resume_h1_s"><i class="yun_resume_h1_icon yun_resume_h1_iconpx"></i>培训经历</span></div>
      <div id="compile_training" class="yun_resume_handle"  style="dispaly:none" >编辑</div>
      <ul class="yun_resume_tabulation" id="training">
        <?php if (is_array($_smarty_tpl->tpl_vars['training']->value)&&!empty($_smarty_tpl->tpl_vars['training']->value)) {?>
        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['training']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
        <li class="yun_resume_exp_list" id="training<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
          <input type="hidden" id="training_have" value="1">
          <div class="yun_resume_exp_timt"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['sdate'],"%Y.%m");?>
-<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['edate'],"%Y.%m");?>
</div>
          <div class="yun_resume_exp_r ">
            <div class="yun_resume_exp_name"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
<span class="yun_resume_exp_name_job"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</span></div>
            <div class="yun_resume_exp_p"><?php echo $_smarty_tpl->tpl_vars['v']->value['content'];?>
</div>
          </div>
		  <a href="javascript:;" onclick="deleteTeam('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['eid'];?>
','training')" class="compile_delete">删除</a>
        </li>
        <?php } ?>
        <?php }?>
      </ul>
      <ul id="training_empty" style="display:none">
        <li class="yun_resume_exp_list yun_resume_exp_list_color">
          <div class="yun_resume_exp_timt">2009.8-2010.8</div>
          <div class="yun_resume_exp_r ">
            <div class="yun_resume_exp_name">XXX培训中心<span class="yun_resume_exp_name_job">XXX系统培训</span></div>
            <div class="yun_resume_exp_p">
            1、XXX的各方面功能培训<br/>
            2、XXX培训<br/>
            3、美工培训
            </div>
          </div>
        </li>
      </ul>
    </div>
    <!--专业技能-->
    <div class="yun_resume_joblist" style="display: block;" id="skill_upbox" onclick="showMore('skill','520','350','职业技能');" onmousemove="movelook('skill');" onmouseout="outlook('skill');">
      <div class="yun_resume_h1" ><span class="yun_resume_h1_s"><i class="yun_resume_h1_icon yun_resume_h1_iconjn"></i>职业技能</span></div>
      <div id="compile_skill" class="yun_resume_handle" style="dispaly:none">编辑</div>
      <ul class="resume_skill" id="skill">
       <?php if (is_array($_smarty_tpl->tpl_vars['skill']->value)&&!empty($_smarty_tpl->tpl_vars['skill']->value)) {?>
       <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['skill']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
       <li class="yun_resume_exp_list" id="skill<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
       <input type="hidden" id="skill_have" value="1">
          <i class="resume_skill_icon"></i>
          技能名称：<span class="resume_table_blod"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</span> 
          <?php if ($_smarty_tpl->tpl_vars['v']->value['longtime']) {?><span class="yun_resume_exp_name_job">掌握时间：<?php echo $_smarty_tpl->tpl_vars['v']->value['longtime'];?>
年</span><?php }?>
          <span class="yun_resume_exp_name_job">熟练程度：<?php echo $_smarty_tpl->tpl_vars['v']->value['ing_n'];?>
</span>
          <?php if ($_smarty_tpl->tpl_vars['v']->value['pic']) {?>
          <div class="zs_imgbox">技能证书： <img src="<?php echo $_smarty_tpl->tpl_vars['v']->value['pic'];?>
"  style="vertical-align:middle"> </div>
          <?php }?>
		  <a href="javascript:;" onclick="deleteTeam('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['eid'];?>
','skill')" class="compile_delete">删除</a>
          </li>
        <?php } ?>
        <?php }?>
      </ul>
      <ul id="skill_empty" style="display:none">
      <li class="yun_resume_exp_list  yun_resume_exp_list_color">
          <i class="resume_skill_icon"></i>技能名称：<span class="resume_table_blod">英语CET6、粤语</span> <span class="yun_resume_exp_name_job">掌握时间：3年</span>
            <div class="zs_imgbox">技能证书： <img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_member_skill'];?>
"  style="vertical-align:middle"> </div>
      </li>
      </ul>
    </div>
   
    <!--其他信息-->
    <div class="yun_resume_joblist" style="display: block;" id="other_upbox" onclick="showMore('other','540','380','其他信息');" onmousemove="movelook('other');" onmouseout="outlook('other');">
      <div class="yun_resume_h1" ><span class="yun_resume_h1_s"><i class="yun_resume_h1_icon yun_resume_h1_iconqt"></i>其他信息</span></div>
      <div id="compile_other" class="yun_resume_handle" style="dispaly:none" >编辑</div>
      <ul class="resume_skill" id="other">
      <?php if (is_array($_smarty_tpl->tpl_vars['other']->value)&&!empty($_smarty_tpl->tpl_vars['other']->value)) {?>
      <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['other']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
        <li class="yun_resume_exp_list" id="other<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
         <input type="hidden" id="other_have" value="1">
          <i class="resume_skill_icon"></i><span class="resume_table_blod">标题：<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</span>
           <?php if ($_smarty_tpl->tpl_vars['v']->value['content']) {?><div class="yun_resume_exp_p">内容：
            <?php echo $_smarty_tpl->tpl_vars['v']->value['content'];?>
</div> <?php }?>
			<a href="javascript:;" onclick="deleteTeam('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['eid'];?>
','other')" class="compile_delete">删除</a>
        </li>
        <?php } ?>
        <?php }?>
      </ul>
      <ul  id="other_empty" style="display:none">
        <li class="yun_resume_exp_list yun_resume_exp_list_color">
          <i class="resume_skill_icon"></i><span class="resume_table_blod">标题：校内经历</span>
          <div class="yun_resume_exp_p">内容：
          1、主导的多个版本的立项、资源协调、进度管理和对外合作工作。
          2、负责XXX网页版、XXX手机客户端、XXX版等项目，运营了XXX--“温暖明天”爱护行动
            </div>
        </li>
      </ul>
    </div>
    <!--自我评价-->
    <div class="yun_resume_joblist" style="display: block;" id="description_upbox" onclick="showMore('description','550','<?php if (count($_smarty_tpl->tpl_vars['resume']->value['arrayTag'])>3) {?>500<?php } else { ?>485<?php }?>','自我评价');" onmousemove="movelook('description');" onmouseout="outlook('description');">
      <div class="yun_resume_h1" ><span class="yun_resume_h1_s"><i class="yun_resume_h1_icon yun_resume_h1_iconpj"></i>自我评价</span></div>
      <div id="compile_description" class="yun_resume_handle"  style="dispaly:none">编辑</div>
      <ul class="resume_skill" id="description">
      <?php if ($_smarty_tpl->tpl_vars['resume']->value['description']) {?>
        <li class=" yun_resume_exp_list"><i class="resume_skill_icon"></i>
          <div class="yun_resume_exp_p">
            <em><?php echo nl2br($_smarty_tpl->tpl_vars['resume']->value['description']);?>
</em>
          </div>
        </li>
		<?php if ($_smarty_tpl->tpl_vars['resume']->value['arrayTag']) {?>
		<li class=" yun_resume_exp_list"><i class="resume_skill_icon"></i>
          <div class="yun_resume_p_bbq" >
		    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['resume']->value['arrayTag']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
            <span><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</span> 
			<?php } ?>
          </div>
        </li>
		<?php }?>
        <?php } else { ?>
        <li class=" yun_resume_exp_list yun_resume_exp_list_color"><i class="resume_skill_icon"></i>
          <div class="yun_resume_exp_p">
            <em>
            热爱XXX行业，关注行业动态<br/>
                                 学习能力强，对新事物充满好奇<br/>
                                工作态度认真负责，具有团队合作精神</em>
          </div>
        </li>
            <?php }?>
      </ul>
    </div>
    
     <!--作品案例--> 
      <div class="yun_resume_zpbox" >
      <div class="yun_resume_h1" ><span class="yun_resume_h1_s"><i class="yun_resume_h1_icon yun_resume_h1_iconzp"></i>作品案例</span></div>
     <ul class="resume_skill" id="description"> 
        <li class=" yun_resume_exp_list yun_resume_exp_list_color"><i class="resume_skill_icon"></i>
          <div class="yun_resume_exp_p">
            <em>PS：上传作品更受企业青睐，可提升5倍面试邀约率！<a href="index.php?c=show&eid=<?php echo $_GET['e'];?>
" class="yun_resume_zpbox_bth">上传作品案例</a></em>
          </div>
        </li> 

		<li class=" yun_resume_exp_list yun_resume_exp_list_color" style="width:840px;" ><i class="resume_skill_icon"></i>
        <div style="width:840px; float:left; overflow:hidden">
          <div class="yun_resume_zp">
            <?php  $_smarty_tpl->tpl_vars['pic'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['pic']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['show']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['pic']->key => $_smarty_tpl->tpl_vars['pic']->value) {
$_smarty_tpl->tpl_vars['pic']->_loop = true;
?>
            <div class="yun_resume_zp_list">
				<img src="<?php echo $_smarty_tpl->tpl_vars['pic']->value['picurl'];?>
" />
                </div>
			<?php } ?>
          </div> </div>
        </li>
      </ul>
      </div>
  <!--作品案例--> 
  </div>
  <!--/*简历结束*/--> 
 
</div>
<!--  右侧开始-->


<div class="resume_right_fixedcont" style="margin-top:20px;">
<div class="" id="right_box">
<div class="resume_right_box">
<div class="resume_right_box_tit">
  <ul>
    <li class="resume_right_box_tit_cur" id="module"><a href="javascript:;" style="text-decoration:none;" onclick="checkModel('1')">我的简历</a></li>
    <li class="" id="template"><a href="javascript:;" style="text-decoration:none;" onclick="checkModel('2')">简历模板</a></li>
  </ul>
</div>
<div class="yun_integrity_box" id="resume_module">
  <div class="yun_resume_integrity_box mt8">
    <div class="cont">
    <div class="yun_resume_wzd_name">简历完整度：</div>
      <div id="_ctl0_UserManage_LeftTree1_progressDiv" class="bar" style="width:140px">
        <div class="play" style="width:<?php echo $_smarty_tpl->tpl_vars['row']->value['integrity'];?>
%"></div>
      </div>
      <div class="value"><b id="numresume"><?php echo $_smarty_tpl->tpl_vars['row']->value['integrity'];?>
%</b></div>
      <div id="_ctl0_UserManage_LeftTree1_msnInfo" class="yun_resume_wzdintro"> 
      <?php if ($_smarty_tpl->tpl_vars['row']->value['integrity']<$_smarty_tpl->tpl_vars['config']->value['user_sqintegrity']) {?>  您现在的简历完整度太低，还不能够使用此简历应聘!
      <?php } else { ?>  您的简历已符合要求！<?php }?>
      </div>
    </div>
  </div>
  <ul class="yun_integrity_degree_list">
    <li class=" <?php if ($_smarty_tpl->tpl_vars['resume']->value['name']!='') {?> state_done <?php }?>"><a href="javascript:;" onclick="showMore('info','750','580','基本信息');">
    <em class="integrity_degree_name">基本信息<span class="integrity_degree">+20%</span></em>
<i class="yun_yt_icon"></i></a></li>
    <li class="<?php if ($_smarty_tpl->tpl_vars['resume_row']->value['expect']==1) {?> state_done resume_expect<?php }?>"><a href="javascript:;" onclick="showMore('expect','650','auto','求职意向');"><em class="integrity_degree_name">求职意向<span class="integrity_degree">+35%</span></em><i class="yun_yt_icon"></i><i class="yun_yt_icon"></i></a>
    </li>
    <li id="m_right3" class=" <?php if (count($_smarty_tpl->tpl_vars['work']->value)>=1) {?> state_done resume_work<?php }?>"><a href="javascript:;" onclick="showMore('work','520','487','工作经历');"><em class="integrity_degree_name">工作经历<span class="integrity_degree">+10%</span></em><i class="yun_yt_icon"></i><i class="yun_jl_tj">添加</i></a></li>
    <li id="m_right4" class="<?php if (count($_smarty_tpl->tpl_vars['edu']->value)>=1) {?> state_done resume_edu<?php }?>"><a href="javascript:;" onclick="showMore('edu','520','451','教育经历');"><em class="integrity_degree_name">教育经历<span class="integrity_degree">+10%</span></em><i class="yun_yt_icon"></i><i class="yun_jl_tj">添加</i></a></li>
    <li id="m_right5" class="<?php if (count($_smarty_tpl->tpl_vars['training']->value)>=1) {?> state_done resume_training<?php }?>"><a href="javascript:;" onclick="showMore('training','520','480','培训经历');"><em class="integrity_degree_name">培训经历<span class="integrity_degree">+7%</span></em><i class="yun_yt_icon"></i><i class="yun_jl_tj">添加</i></a></li>
    <li id="m_right6" class="<?php if (count($_smarty_tpl->tpl_vars['skill']->value)>=1) {?> state_done <?php }?>"><a href="javascript:;" onclick="showMore('skill','520','350','职业技能');"><em class="integrity_degree_name">职业技能<span class="integrity_degree">+10%</span></em><i class="yun_yt_icon"></i><i class="yun_jl_tj">添加</i></a></li>
  
    <li id="m_right7" class="<?php if (count($_smarty_tpl->tpl_vars['project']->value)>=1) {?> state_done resume_project<?php }?>"><a href="javascript:;" onclick="showMore('project','520','480','项目经历');"><em class="integrity_degree_name">项目经历<span class="integrity_degree ">+8%</span></em><i class="yun_yt_icon"></i><i class="yun_jl_tj">添加</i></a></li>
    <li class="<?php if (count($_smarty_tpl->tpl_vars['other']->value)>=1) {?> state_done resume_other<?php }?>"><a href="javascript:;" onclick="showMore('other','540','380','其他信息');"><em class="integrity_degree_name">其他信息</em><i class="yun_yt_icon"></i><i class="yun_yt_icon"></i><i class="yun_jl_tj">添加</i></a></li>
    
    <li  class="<?php if ($_smarty_tpl->tpl_vars['resume']->value['description']!=''||$_smarty_tpl->tpl_vars['resume']->value['arrayTag']!='') {?> state_done resume_resume<?php }?>"><a href="javascript:;" onclick="showMore('description','550','<?php if (count($_smarty_tpl->tpl_vars['resume']->value['arrayTag'])>3) {?>500<?php } else { ?>485<?php }?>','自我评价');"><em class="integrity_degree_name">自我评价</em><i class="yun_yt_icon"></i><i class="yun_jl_tj">添加</i></a></li>
    
    <li class="<?php if (count($_smarty_tpl->tpl_vars['show']->value)>=1) {?> state_done resume_show<?php }?>"><a href="index.php?c=show&eid=<?php echo $_GET['e'];?>
" ><em class="integrity_degree_name">上传作品案例</em><i class="yun_yt_icon"></i><i class="yun_jl_tj">上传</i></a></li>
  </ul>
   <div class="yun_resume_operation_r"><a href="<?php ob_start();?><?php echo $_GET['e'];?>
<?php $_tmp1=ob_get_clean();?><?php echo smarty_function_url(array('m'=>'resume','c'=>'show','id'=>$_tmp1),$_smarty_tpl);?>
" target="_blank" class="yun_resume_operation_preview ">预览简历</a>
   <a href="index.php" class="yun_resume_fh ">返回个人中心</a>
   </div>
</div>
<div class="yun_integrity_box" style="display:block;display:none" id="resume_template">
<ul class="yun_template_box">
<li <?php if ($_smarty_tpl->tpl_vars['row']->value['tmpid']==''||$_smarty_tpl->tpl_vars['row']->value['tmpid']=='d') {?>class="yun_template_cur"<?php }?>>
<a href="javascript:;" onclick="changeModel('<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/resume/index.php?c=show&tmp=2&see=member&look=admin&id=<?php echo $_GET['e'];?>
','默认模板','900')">

<img src="<?php echo $_smarty_tpl->tpl_vars['user_style']->value;?>
/images/mr.png">
<div class="yun_template_box_yl">默认模板</div>
</a>
</li>
<?php  $_smarty_tpl->tpl_vars['style'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['style']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['style']->key => $_smarty_tpl->tpl_vars['style']->value) {
$_smarty_tpl->tpl_vars['style']->_loop = true;
?> 
<li <?php if ($_smarty_tpl->tpl_vars['statis']->value['tpl']==$_smarty_tpl->tpl_vars['style']->value['id']) {?>class="yun_template_cur "<?php }?>>
<a href="javascript:;" onclick="changeModel('<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/resume/index.php?c=show&tmp=<?php echo $_smarty_tpl->tpl_vars['style']->value['id'];?>
&see=member&look=admin&id=<?php echo $_GET['e'];?>
','<?php echo $_smarty_tpl->tpl_vars['style']->value['name'];?>
','900')">

<img src="<?php echo $_smarty_tpl->tpl_vars['style']->value['pic'];?>
">
<div class="yun_template_box_yl"><?php echo $_smarty_tpl->tpl_vars['style']->value['name'];?>
</div>
</a></li>
<?php } ?> 

 
</ul>

</div>


 
</div></div></div>
<!--  右侧结束-->

</div>
  <!--  基本信息-->
    <div id="saveinfo" style="background:#fff;display:none">
      <form name="MyForm" method="post" action="index.php?c=info&act=save" target="supportiframe" autocomplete="off" onsubmit="return CheckPost();" enctype="multipart/form-data" class="layui-form">
      <div class="yun_resume_popup_box" style="width: 100%; position: relative; ">
        <ul>
          <li class="yun_resume_popup">
            <div class="yun_resume_popup_list" style="margin-top:0px;"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>姓名：</span>
				<input type="text" name="name" id="name" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['name'];?>
" <?php if ($_smarty_tpl->tpl_vars['resume']->value['idcard_status']==1) {?>readonly<?php }?> class="yun_resume_popup_infotext  <?php if ($_smarty_tpl->tpl_vars['resume']->value['idcard_status']==1) {?>yun_m_info_text_name_box_notext<?php }?>">
				<span class="yun_resume_popup_infoname"><i class="yun_resume_popup_bt">*</i>性别：</span>
				
				<input type="hidden" id="sex" name="sex" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['sex'];?>
" />
				<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['user_sex']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
				<span class="yun_info_sex <?php if ($_smarty_tpl->tpl_vars['j']->value==$_smarty_tpl->tpl_vars['row']->value['sex']) {?>yun_info_sex_cur<?php }?>" id="sex<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
" onclick="checksex('<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
')"><i class="usericon_sex usericon_sex<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
"></i><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</span>                     
				<?php } ?>
           
            </div>
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>出生年月：</span>
               <input type="text" id="birthday" name="birthday" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['birthday'];?>
" class="yun_resume_popup_infotext"/> 
           <span class="yun_resume_popup_infoname"><i class="yun_resume_popup_bt">*</i>现居住地：</span>
              <input type="text" id="living" name="living" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['living'];?>
" class="yun_resume_popup_infotext">
            </div>
             <div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>最高学历：</span>        
             <div class="yun_resume_popup_info_box  "> 
             	<div class="layui-form-item">
                  <div class="layui-input-inline">
                    <select name="edu" lay-filter="" id="educid">
                      <option value="">请选择最高学历</option>
                      <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_edu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                      <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['row']->value['edu']==$_smarty_tpl->tpl_vars['v']->value) {?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
             </div>
           <span class="yun_resume_popup_infoname"><i class="yun_resume_popup_bt">*</i>工作经验：</span><div class="yun_resume_popup_info_box  yun_resume_zindex10"> 
             	<div class="layui-form-item">
                  <div class="layui-input-inline">
                    <select name="exp" lay-filter="" id="expid">
                      <option value="">请选择工作经验</option>
                      <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_word']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                      <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['resume']->value['exp']==$_smarty_tpl->tpl_vars['v']->value) {?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
             </div>
            </div>      <div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>手机：</span>
              <?php if ($_smarty_tpl->tpl_vars['resume']->value['moblie_status']==1) {?>
               <span class="info_phe_ok" style="width:188px; float:left; position:relative"><?php echo $_smarty_tpl->tpl_vars['resume']->value['telphone'];?>
 <a href="index.php?c=passwd"  style="color:#1178c3; position:absolute;right:-35px;top:0px;">修改</a></span>
               <input type="hidden" name="telphone" id="telphone" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['telphone'];?>
">
              <?php } else { ?>
              <input type="text" name="telphone" id="telphone" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['telphone'];?>
" onkeyup="this.value=this.value.replace(/[^0-9.]/g,'')" class="yun_resume_popup_infotext">
              <?php }?>
           <span class="yun_resume_popup_infoname">邮箱：</span>
              <?php if ($_smarty_tpl->tpl_vars['resume']->value['email_status']==1) {?>
              <span class="info_email_ok" style="width:188px; float:left; position:relative">
               <?php echo $_smarty_tpl->tpl_vars['resume']->value['email'];?>

               <a href="index.php?c=passwd" style="color:#1178c3; position:absolute;right:-35px;top:0px;">修改</a></span>
               <input type="hidden" id="email" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['email'];?>
">
               <?php } else { ?>
              <input type="text" name="email" id="email" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['email'];?>
" class="yun_resume_popup_infotext">
              <?php }?>
            </div>
          <div class="yun_resume_popup_list"><span class="yun_resume_popup_name">QQ：</span><input type="text" name="qq" id="qq" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['qq'];?>
" class="yun_resume_popup_infotext" onkeyup="this.value=this.value.replace(/[^0-9-.]/g,'')"><span class="yun_resume_popup_infoname">个人二维码：</span>
		   <button type="button" style="float:left" class="yun_bth_pic adminupload" lay-data="{imgid: 'ewm',path: 'user',parentid:'imgparent'}">上传二维码</button>
          <div id="imgparent" class="<?php if (!$_smarty_tpl->tpl_vars['resume']->value['wxewm']) {?>none<?php }?>" style="width:38px; padding-left:18px;float:left;"><img src="<?php echo $_smarty_tpl->tpl_vars['resume']->value['wxewm'];?>
" id="ewm" width="38" height="38"/></div>
          </div>
                  
           <div class="yun_resume_popup_list"><span class="yun_resume_popup_name">户籍所在地：</span> <input type="text" name="domicile" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['domicile'];?>
" class="yun_resume_popup_infotext"><span class="yun_resume_popup_infoname">个人主页：</span><input type="text" name="homepage" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['homepage'];?>
" class="yun_resume_popup_infotext"></div> 
           
           
           <div class="yun_resume_popup_list_mz"><span class="yun_resume_popup_name">民族：</span><input type="text" name="nationality" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['nationality'];?>
" class="yun_resume_popup_infotext "></div>
           <div class="yun_resume_popup_list_sg"><span class="yun_resume_popup_infoname">身高：</span> <input type="text" name="height" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['height'];?>
" class="yun_resume_popup_text yun_resume_popup_textw150" onkeyup="this.value=this.value.replace(/[^0-9-.]/g,'')" placeholder="CM"><span class="yun_resume_popudw">体重：</span><input type="text" name="weight" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['weight'];?>
" class="yun_resume_popup_text yun_resume_popup_textw150" onkeyup="this.value=this.value.replace(/[^0-9-.]/g,'')" placeholder="KG"></div>
           <div class="yun_resume_popup_list" style="margin-top:10px;"><span class="yun_resume_popup_name">婚姻： </span><div class="yun_resume_popup_chose_box  yun_resume_zindex9" style="height:34px;"> 
             	<div class="layui-form-item">
                 
                    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_marriage']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                    <input type="radio" id="marriage<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
" name="marriage" value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['resume']->value['marriage']==$_smarty_tpl->tpl_vars['v']->value) {?>checked="checked"<?php }?> title="<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
" />
                    <?php } ?>
                  
                </div>
             </div>
           </div>
          </li>
        </ul>
      </div>
      <div class="yun_resume_popup_infobot">
        <input type="hidden" id="getinfoid" value="<?php if ($_smarty_tpl->tpl_vars['resume']->value['name']!=" ") {?>1<?php }?>">
      
        <input type="submit" name="submitBtn" value="保存" class="expect_test_bth">
          <a href="javascript:;" onclick="hideMore('info')" class="expect_test_bth_qx">取消</a>
      </div>
      </form>
    </div> 
     <!-- 基本信息出框 end-->
       <!--求职意向-->
    <div id="saveexpect" style="background:#fff;display:none;background: #fff; overflow: hidden;">
      <form class="layui-form">
      <div class="yun_resume_popup_box" style="width: 100%; position: relative; ">
        <ul>
           <li class="yun_resume_popup">
		   
		   	<div class="yun_resume_popup_list" style="margin-top:0px;">
		   		<span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>期望职位：</span>        
            	<div class="yun_resume_popup_chose_box yun_resume_zindex10"> 
             		<input type="text" name="name" id="nameid" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
" class="yun_resume_popup_text" style="width:382px;">
             	</div>
         	</div>
             
            <div class="yun_resume_popup_list" >
            	<span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>工作职能：</span>        
            	<div class="yun_resume_popup_chose_box news_expect_text_new  news_expect_text_re10" style="width:384px;"> 
			        <select id="jobclass_search" name="jobclass_search" xm-select-type="jobclass" xm-select="jobclass_search" xm-select-search="" xm-select-max="5" xm-select-skin="default" xm-select-direction="down">
			        	<option value="">输入搜索，最多选5项</option>
			        </select>
			        <?php if ($_smarty_tpl->tpl_vars['jionly']->value!='1') {?>
			        <div onclick="index_job_new(5,'#workadds_job','#job_class','left:100px;top:100px; position:absolute;','1');" class="news_expect_text_new_nth" title="选择职位类别"></div>
			        <?php }?>
					<input type="hidden" name="job_class" id="job_class" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['job_classid'];?>
"/>
	             </div>
             </div>
         
			<div class="yun_resume_popup_list">
				<span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>工作地点：</span>        
            	<div class="yun_resume_popup_chose_box news_expect_text_new  news_expect_text_re9" style="width:384px;">  
             		<select id="cityclass_search" name="cityclass_search" xm-select-type="cityclass" xm-select="cityclass_search" xm-select-search="" xm-select-max="5" xm-select-skin="default" xm-select-direction="down">
             			<option value="">输入搜索，最多选5项</option>
             		</select>
             		<?php if ($_smarty_tpl->tpl_vars['cionly']->value!='1') {?>
             		<div onclick="index_city_new(5,'#workadds_job','#city_class','left:100px;top:100px; position:absolute;')" class="news_expect_text_new_nth" title="选择城市"></div>
             		<?php }?>
             		<input type="hidden" name="city_class" id="city_class" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['city_classid'];?>
"/>
             	</div>
          	</div>
             <div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i> 求职状态：</span>        
               <div class="yun_resume_popup_chose_box">  
             	<div class="layui-form-item">
                  <div class="layui-input-inline" style="width:384px; height:30px;">
                    <select name="jobstatus" lay-filter="" id="statusid">
                      <option value="">请选择求职状态</option>
                      <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_jobstatus']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                      <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['row']->value['jobstatus']==$_smarty_tpl->tpl_vars['v']->value) {?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
             </div>
            </div>
  			<div class="yun_resume_popup_list"><span class="yun_resume_popup_name">从事行业：</span>        
           	<div class="yun_resume_popup_chose_box "> 
             	<div class="layui-form-item">
                  <div class="layui-input-inline" style="width:384px; height:30px;">
                    <select name="hy" lay-filter="" id="hyid">
                 	  <option value="0">不限</option>
                      <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['industry_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                      <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['row']->value['hy']==$_smarty_tpl->tpl_vars['v']->value) {?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['industry_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
             </div>
            </div>
             <div class="yun_resume_popup_list" style=" margin-top:10px;"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>到岗时间：</span>        
         <div class="yun_resume_popup_chose_box">  
             	<div class="layui-form-item">
                  <div class="layui-input-inline" style="width:384px; height:30px;">
                    <select name="report" lay-filter="" id="reportid">
                      <option value="">请选择到岗时间</option>
                      <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_report']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                      <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['row']->value['report']==$_smarty_tpl->tpl_vars['v']->value) {?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
             </div>
            </div>
            
           <div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>期望薪资：</span>        
           <div class="yun_resume_popup_chose_box"> 
           
             <input type="text" class="expect_qwxz_text" id="minsalary" name="minsalary" size="6" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['minsalary'];?>
" onkeyup="checkmoney(this)" />
                <span class="expect_xz_dw">元/月</span>
         
             <span class="expect_xzline">-</span>
             
             <input type="text" class="expect_qwxz_text" id="maxsalary" name="maxsalary" size="6" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['maxsalary'];?>
" onkeyup="checkmoney(this)" />
                <span class="expect_xz_dw">元/月</span>
          
             </div>
            </div>
           <div class="yun_resume_popup_list" style="margin-top:10px;"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>工作性质：</span>        
           <input type="hidden" id="typeid" <?php if ($_smarty_tpl->tpl_vars['row']->value['type']) {?> value="<?php echo $_smarty_tpl->tpl_vars['row']->value['type'];?>
" <?php }?> />       
           <div class="yun_resume_popup_chose_box" style="width:550px;">  
               <div class="layui-form-item" style="margin-bottom:0px;">
                  <div class="layui-input-inline" style="width:100%;">
                    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_type']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                    <input type="radio" id="type<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
" name="type" value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['row']->value['type']==$_smarty_tpl->tpl_vars['v']->value) {?>checked="checked"<?php }?> title="<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
" />
                    <?php } ?>
                  </div>
                </div>
               </div>
            </div>
        
			</li>
        </ul>
      </div>
      <div class="yun_resume_popup_infobot" style="padding-bottom:10px;">
        
        <input type="button" name="submit" value="<?php if ($_GET['e']) {?>修改<?php } else { ?>保存<?php }?>" onclick="saveexpect();" class="expect_test_bth">
          <a href="javascript:;" onclick="hideMore('expect')" class="expect_test_bth_qx">取消</a>
    
      </div></form>
    </div> 
     <!--  求职意向弹出框 end-->
     
  <!--  工作经历弹出框-->
    <div id="savework" style="background:#fff;display:none">
      <form  method="post" action="index.php?c=expect&act=saveall" target="tanchukuang" autocomplete="off" onsubmit="return eload()">
      <div class="yun_resume_popup_box" style="width:100%; max-height: 391px; overflow: auto; overflow-x:hidden ;position: relative; " id="work_div">
        <ul id="addwork">
        <?php if ($_smarty_tpl->tpl_vars['work']->value) {?>
        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['work']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
          <li class="yun_resume_popup" id="wh<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
            
			<i class="yun_resume_popup_del showworknum" id="iw<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" onclick="deleteupbox('wh<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','iw<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','showworknum','work')">删除</i>
            <input type="hidden" class="wh<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name="id[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
            <input type="hidden" name="timeid[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
            <input type="hidden" name="nameid[]" value="n<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
            <input type="hidden" name="titleid[]" value="t<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
            <input type="hidden" name="sdateid[]" value="s<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
			<input type="hidden" name="edateid[]" value="ed<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>公司名称：</span>
              <div class="yun_resume_popup_qyname"><input type="text" name="name[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" onfocus="hidemsg('mworkn<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" onblur="hidemsg('mworkn<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" placeholder="必填" class="yun_resume_popup_text">
                <i class="yun_resume_popup_qyname_tip" id="mworkn<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="display:none">请填写公司名称</i>
                </div>
            </div>
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>担任职位：</span>
            <div class="yun_resume_popup_qyname">  <input type="text" name="title[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
" placeholder="必填" class="yun_resume_popup_text" onfocus="hidemsg('mworkt<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" onblur="hidemsg('mworkt<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')">
              <i class="yun_resume_popup_qytitle_tip" id="mworkt<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="display:none">请填写担任职位</i></div>
            </div>
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>工作时间：</span>
            <div class="yun_resume_popup_list_box">
              <input type="text" id="work_sdate<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name="sdate[]" value="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['sdate'],'%Y-%m');?>
" onfocus="hidemsg('mwork<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','mworks<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" onblur="hidemsg('mwork<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','mworks<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" class="yun_resume_popup_text yun_resume_popup_textw90 worksdate">
             <?php echo '<script'; ?>
>
			    layui.use(['laydate'], function(){var laydate = layui.laydate;monthclick(laydate,'#work_sdate<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');monthclick(laydate,'#work_edate<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');});
			  <?php echo '</script'; ?>
>
			  <i class="yun_resume_popup_list_box_tip" id="mworks<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="display:none">请选择开始日期</i>
            </div>
              <span class="yun_resume_popup_time">-</span>
              <div class="yun_resume_popup_list_box">
               <input type="text" id="work_edate<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name="edate[]" value="<?php if ($_smarty_tpl->tpl_vars['v']->value['edate']) {
echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['edate'],'%Y-%m');
} else { ?>至今<?php }?>" onfocus="hidemsg('mwork<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','mworked<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" onblur="hidemsg('mwork<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','mworked<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" class="yun_resume_popup_text yun_resume_popup_textw90 workedate" <?php if (!$_smarty_tpl->tpl_vars['v']->value['edate']) {?>disabled="disabled"<?php }?>/>
			   <input id="work_edate<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
un" type="hidden" name="edate[]" value="至今" <?php if ($_smarty_tpl->tpl_vars['v']->value['edate']) {?>disabled="disabled"<?php }?>/>
              <i class="yun_resume_popup_list_box_tip" id="mwork<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="display:none">请确认日期先后顺序</i>
			  <i class="yun_resume_popup_list_box_tip" id="mworked<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="display:none">请选择结束日期</i>
               </div>
               <input type="hidden" id="to<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name="totoday[]" value="<?php if (!$_smarty_tpl->tpl_vars['v']->value['edate']) {?>2<?php } else { ?>1<?php }?>">
               <input type='checkbox' value='1' onclick="untiltoday('totoday<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','work_edate<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','mwork<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','to<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','mworked<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" id='totoday<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
' <?php if ($_smarty_tpl->tpl_vars['v']->value['edate']==0) {?>checked<?php }?> class="yun_resume_popup_checkbox"><label for='totoday'><span class="yun_resume_popup_checkbox_s">至今</span></label>
           </div>
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt"></i>工作内容：</span>
              <textarea rows="5" cols="50" name="content[]" class="infor_textarea "placeholder="请描述你在职期间的职责范围、工作内容和工作业绩，为保护个人隐私，请不要填写手机号、QQ、微信等联系方式" ><?php echo $_smarty_tpl->tpl_vars['v']->value['content'];?>
</textarea>
            </div>
          </li>
          <?php } ?>
          <?php } else { ?>
          <li class="yun_resume_popup" id="wh">
            <i class="yun_resume_popup_del hidepic showworknum" id="iwork" onclick="deleteupbox('wh','iwork','showworknum','work')">删除</i>
            <input type="hidden" class="wh" name="id[]" value="">
            <input type="hidden" name="timeid[]" value="wh">
            <input type="hidden" name="nameid[]" value="nwh">
            <input type="hidden" name="titleid[]" value="twh">
            <input type="hidden" name="sdateid[]" value="swh">
			<input type="hidden" name="edateid[]" value="edwh">
            <input type="hidden" class="usedwork" name="usedid[]" value="">
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>公司名称：</span>
            <div class="yun_resume_popup_qyname">
              <input type="text" name="name[]" value="" onfocus="hidemsg('mworknwh')" onblur="hidemsg('mworknwh')" placeholder="必填" class="yun_resume_popup_text work_name">
               <i class="yun_resume_popup_qyname_tip" id="mworknwh" style="display:none">请填写公司名称</i>
               </div>
            </div>
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>担任职位：</span>
           <div class="yun_resume_popup_qyname">   <input type="text" name="title[]" value="" class="yun_resume_popup_text work_itle"placeholder="必填" onfocus="hidemsg('mworktwh')" onblur="hidemsg('mworktwh')">
              <i class="yun_resume_popup_qytitle_tip" id="mworktwh" style="display:none">请填写担任职位</i></div>
            </div>
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>工作时间：</span>
            <div class="yun_resume_popup_list_box">
              <input type="text" id="work_sdate" name="sdate[]" value="" onfocus="hidemsg('mworkwh','mworkswh')" onblur="hidemsg('mworkwh','mworkswh')" class="yun_resume_popup_text yun_resume_popup_textw90 work_sdate">
             <?php echo '<script'; ?>
>
			    layui.use(['laydate'], function(){var laydate = layui.laydate;monthclick(laydate,'#work_sdate');monthclick(laydate,'#work_edate');});
			  <?php echo '</script'; ?>
>
			  <i class="yun_resume_popup_list_box_tip" id="mworkswh" style="display:none">请选择开始日期</i>
            </div>
              <span class="yun_resume_popup_time">-</span>
              <div class="yun_resume_popup_list_box">
               <input type="text" id="work_edate" name="edate[]" value="" onfocus="hidemsg('mworkwh','mworkedwh')" onblur="hidemsg('mworkwh','mworkedwh')" class="yun_resume_popup_text yun_resume_popup_textw90 work_edate">
			   <input id="work_edateun" type="hidden" name="edate[]" value="至今" disabled="disabled"/>
			  <i class="yun_resume_popup_list_box_tip" id="mworkwh" style="display:none">请确认日期先后顺序</i>
			  <i class="yun_resume_popup_list_box_tip" id="mworkedwh" style="display:none">请选择结束日期</i>
               </div>
               <input type="hidden" id="towork" name="totoday[]" value="1">
              <input type='checkbox' value='1' onclick="untiltoday('totoday','work_edate','mworkwh','towork','mworkedwh')" id='totoday' class="yun_resume_popup_checkbox"><label for='totoday'><span class="yun_resume_popup_checkbox_s">至今</span></label> </div>
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt"></i>工作内容：</span>
              <textarea rows="5" cols="50" name="content[]" placeholder="请描述你在职期间的职责范围、工作内容和工作业绩，为保护个人隐私，请不要填写手机号、QQ、微信等联系方式" class="infor_textarea work_content"></textarea>
            </div>
          </li>
          <?php }?>
        </ul>
        <div class="yun_resume_add_to"><a href="javascript:;" onclick="addWork();">+ 添加工作经历</a></div>
      </div>
      <div class="yun_resume_popup_bot">
        <input name="eid" type="hidden" value="<?php echo $_GET['e'];?>
" />
        <input type="hidden" name="table" value="work">
        
         <input type="submit" name="submit" value="保存" class="expect_test_bth" >
         <a href="javascript:;" onclick="hideMore('work')" class="expect_test_bth_qx" >取消</a>
      </div>
      </form>
    </div> 
     <!--  工作经历弹出框 end-->
      <!--  教育经历弹出框-->
    <div id="saveedu" style="background:#fff ;display:none">
     <form  method="post" action="index.php?c=expect&act=saveall" target="tanchukuang" autocomplete="off" class="layui-form" onsubmit="return eload()">
      <div class="yun_resume_popup_box" style="width: 100%; max-height: 355px; overflow: auto; overflow-x:hidden ;position: relative; " id="edu_div">
        <ul id="addedu">
       <?php if ($_smarty_tpl->tpl_vars['edu']->value) {?>
        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['edu']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
          <li class="yun_resume_popup" id="eh<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
          <?php if ($_smarty_tpl->tpl_vars['resume_row']->value['edu']==1) {?>
		   <i class="yun_resume_popup_del showedunum" id="ie<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" onclick="deleteupbox('eh<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','ie<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','showedunum','edu')">删除</i>
		   <?php } else { ?>
		   <i class="yun_resume_popup_del showedunum" id="ie<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" onclick="deleteupbox('eh<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','ie<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','showedunum','edu')">删除</i>
		   <?php }?>
            <input type="hidden" class="eh<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name="id[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
            <input type="hidden" name="timeid[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
            <input type="hidden" name="nameid[]" value="n<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
            <input type="hidden" name="eduid[]" value="e<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
            <input type="hidden" name="specid[]" value="sp<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
            <input type="hidden" name="sdateid[]" value="s<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
			<input type="hidden" name="edateid[]" value="ed<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
			
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>学校名称：</span>
               <div class="yun_resume_popup_qyname"><input type="text" name="name[]" id="edu_name" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
"placeholder="必填"  onfocus="hidemsg('medun<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" onblur="hidemsg('medun<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" class="yun_resume_popup_text">
              <i class="yun_resume_popup_qyname_tip" id="medun<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="display:none">请填写学校名称</i></div>
            </div>
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>在校时间：</span>
            <div class="yun_resume_popup_list_box">
              <input type="text" id="edu_sdate<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name="sdate[]" value="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['sdate'],'%Y-%m');?>
" onfocus="hidemsg('medu<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','medus<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" onblur="hidemsg('medu<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','medus<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" class="yun_resume_popup_text yun_resume_popup_textw90">
             <?php echo '<script'; ?>
>
			   layui.use(['laydate'], function(){var laydate = layui.laydate;monthclick(laydate,'#edu_sdate<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');monthclick(laydate,'#edu_edate<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');});
			  <?php echo '</script'; ?>
>
			  <i class="yun_resume_popup_list_box_tip" id="medus<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="display:none">请选择开始日期</i>
            </div>
              <span class="yun_resume_popup_time">至</span>
              <div class="yun_resume_popup_list_box">
               <input type="text" id="edu_edate<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name="edate[]" value="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['edate'],'%Y-%m');?>
" onfocus="hidemsg('medu<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','medued<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" onblur="hidemsg('medu<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','medued<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" class="yun_resume_popup_text yun_resume_popup_textw90">
			  <i class="yun_resume_popup_list_box_tip" id="medu<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="display:none">请确认日期先后顺序</i>
			  <i class="yun_resume_popup_list_box_tip" id="medued<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="display:none">请选择结束日期</i>
               </div>
             </div>  <div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>学历：</span>
             <div class="yun_resume_popup_chose_box "> 
             	<div class="layui-form-item">
                  <div class="layui-input-inline" style="width:384px; height:30px;">
                    <select name="education[]" lay-filter="education" data-id="medue<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" id="educationc<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
id">
                      <option value="">请选择最高学历</option>
                      <?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['data']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_edu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value) {
$_smarty_tpl->tpl_vars['data']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['data']->key;
?>
                      <option value="<?php echo $_smarty_tpl->tpl_vars['data']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['v']->value['education']==$_smarty_tpl->tpl_vars['data']->value) {?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['data']->value];?>
</option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <i class="yun_resume_popup_qyname_tip" id="medue<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="display:none">请选择最高学历</i>
             </div>
            </div>
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name">所学专业：</span>
              <div class='yun_resume_popup_qyname'><input type="text" name="specialty[]" id="edu_specialty" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['specialty'];?>
" class="yun_resume_popup_text" placeholder="请填写所学专业"  onfocus="hidemsg('medusp<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" onblur="hidemsg('medusp<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" >
              <i class="yun_resume_popup_qyname_tip" id="medusp<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="display:none">请填写所学专业</i></div>
            </div>
             
          </li>
          <?php } ?>
         <?php } else { ?>
          <li class="yun_resume_popup" id="eh">
            <i class="yun_resume_popup_del hidepic showedunum" id="iedu" onclick="deleteupbox('eh','iedu','showedunum','edu')">删除</i>
             <input type="hidden" class="eh" name="id[]" value="">
             <input type="hidden" name="timeid[]" value="eh">
             <input type="hidden" name="nameid[]" value="neh">
             <input type="hidden" name="sdateid[]" value="seh">
			 <input type="hidden" name="edateid[]" value="edeh">
			 <input type="hidden" name="eduid[]" value="eeh">
             <input type="hidden" name="specid[]" value="spech">
             <input type="hidden" class="usededu" name="usedid[]" value="">
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>学校名称：</span>
               <div class="yun_resume_popup_qyname"><input type="text" name="name[]" id="edu_name" value="" onfocus="hidemsg('meduneh')" onblur="hidemsg('meduneh')" class="yun_resume_popup_text">
              <i class="yun_resume_popup_qyname_tip" id="meduneh" style="display:none">请填写学校名称</i></div>
            </div>
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>在校时间：</span>
            <div class="yun_resume_popup_list_box">
              <input type="text" id="edu_sdate" name="sdate[]" value="" onfocus="hidemsg('medueh','meduseh')" onblur="hidemsg('medueh','meduseh')" class="yun_resume_popup_text yun_resume_popup_textw90">
             <?php echo '<script'; ?>
>
			    layui.use(['laydate'], function(){var laydate = layui.laydate;monthclick(laydate,'#edu_sdate');monthclick(laydate,'#edu_edate');});
			  <?php echo '</script'; ?>
>
			  <i class="yun_resume_popup_list_box_tip" id="meduseh" style="display:none">请选择开始日期</i>
            </div>
              <span class="yun_resume_popup_time">至</span>
              <div class="yun_resume_popup_list_box">
               <input type="text" id="edu_edate" name="edate[]" value="" onfocus="hidemsg('medueh','meduedeh')" onblur="hidemsg('medueh','meduedeh')" class="yun_resume_popup_text yun_resume_popup_textw90">
			  <i class="yun_resume_popup_list_box_tip" id="medueh" style="display:none">请确认日期先后顺序</i>
			  <i class="yun_resume_popup_list_box_tip" id="meduedeh" style="display:none">请选择结束日期</i>
               </div>
             </div><div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>学历：</span>
             <div class="yun_resume_popup_chose_box"> 
             	<div class="layui-form-item">
                  <div class="layui-input-inline" style="width:384px; height:30px;">
                    <select name="education[]" lay-filter="education" data-id="medueeh" id="educationcid">
                      <option value="">请选择最高学历</option>
                      <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_edu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                      <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <i class="yun_resume_popup_qyname_tip" id="medueeh" style="display:none">请选择最高学历</i>
             </div>
            </div>
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>所学专业：</span>
              <div class='yun_resume_popup_qyname'><input type="text" name="specialty[]" id="edu_specialty" value="" class="yun_resume_popup_text" onfocus="hidemsg('meduspech')" onblur="hidemsg('meduspech')">
              <i class="yun_resume_popup_qyname_tip" id="meduspech" style="display:none">请填写所学专业</i></div>
            </div>
            
          </li> 
         <?php }?>
        </ul>
        <div class="yun_resume_add_to"><a href="javascript:;" onclick="addEdu();">+ 添加教育经历</a></div>
      </div>
      <div class="yun_resume_popup_bot">
        <input name="eid" type="hidden" value="<?php echo $_GET['e'];?>
" />
        <input type="hidden" name="table" value="edu">
        <input type="submit" name="submit" value="保存"  class="expect_test_bth" >
        <a href="javascript:;" onclick="hideMore('edu')" class="expect_test_bth_qx">取消</a>
      </div>
      </form>
    </div> 
     <!--  教育经历弹出框 end-->
     <!--  培训经历弹出框-->
    <div id="savetraining" style="background:#fff ;display:none">
    <form  method="post" action="index.php?c=expect&act=saveall" target="tanchukuang" autocomplete="off" onsubmit="return eload()">
      <div class="yun_resume_popup_box" style="width: 100%; max-height: 389px; overflow: auto; overflow-x:hidden ;position: relative; " id="training_div">
        <ul id="addtraining">
        <?php if ($_smarty_tpl->tpl_vars['training']->value) {?>
        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['training']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
          <li class="yun_resume_popup" id="th<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
          <?php if ($_smarty_tpl->tpl_vars['resume_row']->value['training']==1) {?>
		  <i class="yun_resume_popup_del hidepic showtrainingnum" id="it<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" onclick="deleteupbox('th<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','it<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','showtrainingnum','training')">删除</i>
		  <?php } else { ?>
		  <i class="yun_resume_popup_del showtrainingnum" id="it<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" onclick="deleteupbox('th<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','it<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','showtrainingnum','training')">删除</i>
		  <?php }?>
            <input type="hidden" class="th<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name="id[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
            <input type="hidden" name="timeid[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
            <input type="hidden" name="nameid[]" value="n<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
            <input type="hidden" name="sdateid[]" value="s<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
			<input type="hidden" name="edateid[]" value="ed<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>培训中心：</span>
               <div class="yun_resume_popup_qyname"><input type="text" name="name[]" id="training_name" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" onfocus="hidemsg('mtrainingn<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" onblur="hidemsg('mtrainingn<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" placeholder="必填"class="yun_resume_popup_text">
              <i class="yun_resume_popup_qyname_tip" id="mtrainingn<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="display:none">请填写培训中心名称</i></div>
            </div>
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name">培训方向：</span>
              <input type="text" name="title[]" id="training_title" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
" class="yun_resume_popup_text">
            </div>
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>培训时间：</span>
             <div class="yun_resume_popup_list_box">
              <input type="text" id="training_sdate<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name="sdate[]" value="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['sdate'],'%Y-%m');?>
" onfocus="hidemsg('mtraining<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','mtrainings<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" onblur="hidemsg('mtraining<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','mtrainings<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')"placeholder='选择开始时间' class="yun_resume_popup_text yun_resume_popup_textw90">
             <?php echo '<script'; ?>
>
			    layui.use(['laydate'], function(){var laydate = layui.laydate;monthclick(laydate,'#training_sdate<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');monthclick(laydate,'#training_edate<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')});
			  <?php echo '</script'; ?>
>
			  <i class="yun_resume_popup_list_box_tip" id="mtrainings<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="display:none">请选择开始日期</i>
            </div>
              <span class="yun_resume_popup_time">至</span>
              <div class="yun_resume_popup_list_box">
               <input type="text" id="training_edate<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name="edate[]" value="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['edate'],'%Y-%m');?>
" onfocus="hidemsg('mtraining<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','mtraininged<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" onblur="hidemsg('mtraining<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','mtraininged<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" placeholder='选择结束时间'class="yun_resume_popup_text yun_resume_popup_textw90">
			  <i class="yun_resume_popup_list_box_tip" id="mtraining<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="display:none">请确认日期先后顺序</i>
			  <i class="yun_resume_popup_list_box_tip" id="mtraininged<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="display:none">请选择结束日期</i>
               </div>
             </div>
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name">培训内容：</span>
              <textarea rows="5" cols="50" name="content[]" id="training_content" class="infor_textarea "><?php echo $_smarty_tpl->tpl_vars['v']->value['content'];?>
</textarea>
            </div>
          </li>
          <?php } ?>
          <?php } else { ?>
          <li class="yun_resume_popup" id="th">
           <i class="yun_resume_popup_del hidepic showtrainingnum" id="itraining" onclick="deleteupbox('th','itraining','showtrainingnum','training')">删除</i>
            <input type="hidden" class="th" name="id[]" value="">
            <input type="hidden" name="timeid[]" value="th">
            <input type="hidden" name="nameid[]" value="nth">
             <input type="hidden" name="sdateid[]" value="sth">
			 <input type="hidden" name="edateid[]" value="edth">
            <input type="hidden" class="usedtraining" name="usedid[]" value="">
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>培训中心：</span>
             <div class="yun_resume_popup_qyname">
              <input type="text" name="name[]" id="training_name" value="" placeholder="必填" onfocus="hidemsg('mtrainingnth')" onblur="hidemsg('mtrainingnth')" class="yun_resume_popup_text">
              <i class="yun_resume_popup_qyname_tip" id="mtrainingnth" style="display:none">请填写培训中心名称</i>
              </div>
            </div>
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name">培训方向：</span>
              <input type="text" name="title[]" id="training_title" value="" class="yun_resume_popup_text">
            </div>
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>培训时间：</span>
             <div class="yun_resume_popup_list_box">
              <input type="text" id="training_sdate" name="sdate[]" value="" onfocus="hidemsg('mtrainingth','mtrainingsth')" placeholder="选择开始时间" onblur="hidemsg('mtrainingth','mtrainingsth')" class="yun_resume_popup_text yun_resume_popup_textw90">
             <?php echo '<script'; ?>
>
			    layui.use(['laydate'], function(){var laydate = layui.laydate;monthclick(laydate,'#training_sdate');monthclick(laydate,'#training_edate');});
			  <?php echo '</script'; ?>
>
			   <i class="yun_resume_popup_list_box_tip" id="mtrainingsth" style="display:none">请选择开始日期</i>
            </div>
              <span class="yun_resume_popup_time">至</span>
              <div class="yun_resume_popup_list_box">
               <input type="text" id="training_edate" name="edate[]" value="" placeholder="选择结束时间" onfocus="hidemsg('mtrainingth','mtrainingedth')" onblur="hidemsg('mtrainingth','mtrainingedth')" class="yun_resume_popup_text yun_resume_popup_textw90">
			  <i class="yun_resume_popup_list_box_tip" id="mtrainingth" style="display:none">请确认日期先后顺序</i>
			  <i class="yun_resume_popup_list_box_tip" id="mtrainingedth" style="display:none">请选择结束日期</i>
               </div>
             </div>
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name">培训内容：</span>
              <textarea rows="5" cols="50" name="content[]" id="training_content" class="infor_textarea "  placeholder="为保护个人隐私，请不要填写手机号、QQ、微信等联系方式" ></textarea>
            </div>
          </li>
          <?php }?>
        </ul>
        <div class="yun_resume_add_to"><a href="javascript:;" onclick="addTraining();">+ 添加培训经历</a></div>
      </div>
      <div class="yun_resume_popup_bot">
        <input name="eid" type="hidden" value="<?php echo $_GET['e'];?>
" />
        <input type="hidden" name="table" value="training">
       
        <input type="submit" name="submit" value="保存" class="expect_test_bth" >   
         <a href="javascript:;" onclick="hideMore('training')" class="expect_test_bth_qx">取消</a>
      </div>
      </form>
    </div> 
     <!--  培训经历弹出框 end-->
    <!--  技能弹出框-->
    <div id="saveskill" style="background:#fff ;display:none">
    <form class="layui-form"  method="post" action="index.php?c=expect&act=saveall" target="tanchukuang" enctype="multipart/form-data" autocomplete="off" onsubmit="return eload()">
      <div class="yun_resume_popup_box" style="width: 100%; max-height: 258px; overflow: auto; overflow-x:hidden ;position: relative; " id="skill_div">
        <ul id="addskill">
            <span style="padding: 12px; background: #f0ad4e; color: #fff1f0; font-size: 12px; float: left;">为了您的个人信息安全，请不要公开您的电话号码、身份证号、证件号等个人证件信息；</span>
            <?php if ($_smarty_tpl->tpl_vars['skill']->value) {?>
				<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['skill']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
				<li class="yun_resume_popup" id="sh<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
				<?php if ($_smarty_tpl->tpl_vars['resume_row']->value['skill']==1) {?>
				<i class="yun_resume_popup_del hidepic showskillnum" id="is<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" onclick="deleteupbox('sh<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','is<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','showskillnum','skill')">删除</i>
				<?php } else { ?>
				<i class="yun_resume_popup_del showskillnum" id="is<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" onclick="deleteupbox('sh<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','is<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','showskillnum','skill')">删除</i>
				<?php }?>
				<input type="hidden" class="sh<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name="id[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
				<input type="hidden" name="nameid[]" value="n<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
				<input type="hidden" name="timeid[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
				<input type="hidden" name="ingid[]" value="i<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
				<div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>技能名称：</span>
				   <div class="yun_resume_popup_qyname"><input type="text" name="name[]" id="skill_name" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" placeholder="必填" onfocus="hidemsg('mskilln<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" onblur="hidemsg('mskilln<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" class="yun_resume_popup_text">
				  <i class="yun_resume_popup_qyname_tip" id="mskilln<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="display:none">请填写技能名称</i>
				</div></div>
				<div class="yun_resume_popup_list" style="line-height:30px;"><span class="yun_resume_popup_name">掌握时间：</span>
				  <input type="text" name="longtime[]" id="skill_longtime" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['longtime'];?>
" onkeyup="this.value=this.value.replace(/[^0-9.]/g,'')" class="yun_resume_popup_text yun_resume_popup_text_w80">年
				</div>
				<div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>熟练程度：</span>        
					 <div class="yun_resume_popup_chose_box "> 
						<div class="layui-form-item">
						  <div class="layui-input-inline" style='width:170px; height:32px;'>
							<select name="ing[]" lay-filter="ingid" id="ing<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
id" data-id="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
							  <option value="">请选择熟练程度</option>
							  <?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['data']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_ing']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value) {
$_smarty_tpl->tpl_vars['data']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['data']->key;
?>
							  <option value="<?php echo $_smarty_tpl->tpl_vars['data']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['v']->value['ing']==$_smarty_tpl->tpl_vars['data']->value) {?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['data']->value];?>
</option>
							  <?php } ?>
							</select>
							<i class="yun_resume_popup_qyname_tip" id="mskilli<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="display:none">请选择熟练程度</i>
						  </div>
						</div>
					 </div>
				</div>
				<div class="yun_resume_popup_list"><span class="yun_resume_popup_name" style="line-height:38px;">上传证书：</span>
				<div class="photo_submit fl">
					<button type="button" id="skillupload<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="yun_bth_pic resumeupload" lay-data="{fileid: 'sfile<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
',imgid: 'simg<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
',parentid: 'sparent<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
'}">上传图片</button>
					<input id="sfile<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" type="hidden" name="cert[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['pic'];?>
"/>
					<div id="sparent<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="photo_submit_pic <?php if (!$_smarty_tpl->tpl_vars['v']->value['pic']) {?>none<?php }?>"> 
				  <img id="simg<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" src="<?php echo $_smarty_tpl->tpl_vars['v']->value['pic'];?>
" width="38" height="38">
				</div>

					</div>
				 </div>
				</li>
				<?php } ?>
          <?php } else { ?>
          <li class="yun_resume_popup" id="skillhide">
          <i class="yun_resume_popup_del hidepic showskillnum" id="iskill" onclick="deleteupbox('skillhide','iskill','showskillnum','skill')">删除</i>
            <input type="hidden" class="skillhide" name="id[]" value="">
            <input type="hidden" name="nameid[]" value="nsh">
            <input type="hidden" name="timeid[]" value="skillhide">
            <input type="hidden" class="usedskill" name="usedid[]" value="">
            <input type="hidden" name="ingid[]" value="sld">
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>技能名称：</span>
               <div class="yun_resume_popup_qyname"><input style="width:240px;" type="text" name="name[]" id="skill_name" value="" placeholder="必填"onfocus="hidemsg('mskillnsh')" onblur="hidemsg('mskillnsh')" class="yun_resume_popup_text">
              <i class="yun_resume_popup_qyname_tip" id="mskillnsh" style="display:none">请填写技能名称</i></div>
            </div>
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name">掌握时间：</span>
              <input style="width:240px;" type="text" name="longtime[]" id="skill_longtime" value="" onkeyup="this.value=this.value.replace(/[^0-9.]/g,'')" class="yun_resume_popup_text"> <span style="line-height:30px;padding-left:10px;">年</span>
            </div>
			<div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>熟练程度：</span>        
				 <div class="yun_resume_popup_chose_box"> 
					<div class="layui-form-item">
					  <div class="layui-input-inline" style='width:170px; height:32px;'>
						<select name="ing[]" lay-filter="ing" id="ingid">
						  <option value="">请选择熟练程度</option>
						  <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_ing']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
						  <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</option>
						  <?php } ?>
						</select>
						<i class="yun_resume_popup_qyname_tip" id="mskillsld" style="display:none">请选择熟练程度</i>
					  </div>
					</div>
				 </div>
            </div>
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name" style="line-height:38px;">上传证书：</span>
              <div class="photo_submit fl">
				<button type="button" id="skillupload" class="yun_bth_pic resumeupload" lay-data="{fileid: 'sfile',imgid: 'simg',parentid: 'sparent'}">上传图片</button>
				<input id="sfile" type="hidden" name="cert[]" value=""/>
				<div id="sparent" class="photo_submit_pic none"> <img id="simg" src="" width="38" height="38"></div>
        
			  </div>
            </div>
          </li>
          <?php }?>
        </ul>
        <div class="yun_resume_add_to"><a href="javascript:;" onclick="addSkill();">+ 添加职业技能</a></div>
      </div>
      <div class="yun_resume_popup_bot">
        <input name="eid" type="hidden" value="<?php echo $_GET['e'];?>
" />
        <input type="hidden" name="table" value="skill">
       
        <input type="submit" name="submit" value="保存"  class="expect_test_bth">
         <a href="javascript:;" onclick="hideMore('skill')" class="expect_test_bth_qx">取消</a>
      </div>
      </form>
    </div> 
     <!--  技能历弹出框 end-->
        <!--  项目经历弹出框-->
    <div id="saveproject" style="background:#fff ;display:none">
    <form  method="post" action="index.php?c=expect&act=saveall" target="tanchukuang" autocomplete="off" onsubmit="return eload()">
      <div class="yun_resume_popup_box" style="width: 100%; max-height: 389px; overflow: auto; overflow-x:hidden ;position: relative; " id="project_div">
        <ul id="addproject">
        <?php if ($_smarty_tpl->tpl_vars['project']->value) {?>
        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['project']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
         <li class="yun_resume_popup" id="ph<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
         <?php if ($_smarty_tpl->tpl_vars['resume_row']->value['project']==1) {?>
		 <i class="yun_resume_popup_del hidepic showprojectnum" id="ip<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" onclick="deleteupbox('ph<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','ip<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','showprojectnum','project')">删除</i>
		 <?php } else { ?>
		 <i class="yun_resume_popup_del showprojectnum" id="ip<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" onclick="deleteupbox('ph<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','ip<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','showprojectnum','project')">删除</i>
		 <?php }?>
          <input type="hidden" class="ph<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name="id[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"> 
          <input type="hidden" name="nameid[]" value="n<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
          <input type="hidden" name="timeid[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
		  <input type="hidden" name="sdateid[]" value="s<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
		  <input type="hidden" name="edateid[]" value="ed<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>项目名称：</span>
             <div class="yun_resume_popup_qyname">
              <input type="text" name="name[]" id="project_name" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" onfocus="hidemsg('mprojectn<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')"  placeholder="必填" onblur="hidemsg('mprojectn<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" class="yun_resume_popup_text">
              <i class="yun_resume_popup_qyname_tip" id="mprojectn<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="display:none">请填写项目名称</i></div>
            </div>
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name">担任职位：</span>
              <input type="text" name="title[]" id="project_title" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
" class="yun_resume_popup_text">
            </div>
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>项目时间：</span>
            <div class="yun_resume_popup_list_box">
              <input type="text" id="project_sdate<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name="sdate[]" value="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['sdate'],'%Y-%m');?>
" onblur="hidemsg('mproject<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','mprojects<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" onfocus="hidemsg('mproject<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','mprojects<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" class="yun_resume_popup_text yun_resume_popup_textw90">
             <?php echo '<script'; ?>
>
			    layui.use(['laydate'], function(){var laydate = layui.laydate;monthclick(laydate,'#project_sdate<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');monthclick(laydate,'#project_edate<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');}); 
			  <?php echo '</script'; ?>
>
			  <i class="yun_resume_popup_list_box_tip" id="mprojects<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="display:none">请选择开始日期</i>
            </div>
              <span class="yun_resume_popup_time">至</span>
              <div class="yun_resume_popup_list_box">
               <input type="text" id="project_edate<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name="edate[]" value="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['edate'],'%Y-%m');?>
" onblur="hidemsg('mproject<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','mprojected<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" onfocus="hidemsg('mproject<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','mprojected<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" class="yun_resume_popup_text yun_resume_popup_textw90">
			  <i class="yun_resume_popup_list_box_tip" id="mproject<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="display:none">请确认日期先后顺序</i>
			  <i class="yun_resume_popup_list_box_tip" id="mprojected<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="display:none">请选择结束日期</i>
               </div>
              </div>
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name">项目内容：</span>
              <textarea rows="5" cols="50" name="content[]" id="project_content" class="infor_textarea "  placeholder="为保护个人隐私，请不要填写手机号、QQ、微信等联系方式" ><?php echo $_smarty_tpl->tpl_vars['v']->value['content'];?>
</textarea>
            </div>
          </li>
          <?php } ?>
          <?php } else { ?>
          <li class="yun_resume_popup" id="ph">
          <i class="yun_resume_popup_del hidepic showprojectnum" id="iproject" onclick="deleteupbox('ph','iproject','showprojectnum','project')">删除</i>
             <input type="hidden" class="ph" name="id[]" value="">
            <input type="hidden" name="timeid[]" value="ph">
            <input type="hidden" name="nameid[]" value="nph">
             <input type="hidden" name="sdateid[]" value="sph">
			 <input type="hidden" name="edateid[]" value="edph">
            <input type="hidden" class="usedproject" name="usedid[]" value="">
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>项目名称：</span> <div class="yun_resume_popup_qyname">
              <input type="text" name="name[]" id="project_name" value="" onfocus="hidemsg('mprojectnph')" onblur="hidemsg('mprojectnph')" class="yun_resume_popup_text">
              <i class="yun_resume_popup_qyname_tip" id="mprojectnph" style="display:none">请填写项目名称</i>
              </div>
            </div>
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name">担任职位：</span>
              <input type="text" name="title[]" id="project_title" value="" class="yun_resume_popup_text">
            </div>
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>项目时间：</span>
            <div class="yun_resume_popup_list_box">
              <input type="text" id="project_sdate" name="sdate[]" value="" onfocus="hidemsg('mprojectph','mprojectsph')" onblur="hidemsg('mprojectph','mprojectsph')" class="yun_resume_popup_text yun_resume_popup_textw90">
             <?php echo '<script'; ?>
>
			    layui.use(['laydate'], function(){var laydate = layui.laydate;monthclick(laydate,'#project_sdate');monthclick(laydate,'#project_edate');}); 
			  <?php echo '</script'; ?>
>
			  <i class="yun_resume_popup_list_box_tip" id="mprojectsph" style="display:none">请选择开始日期</i>
            </div>
              <span class="yun_resume_popup_time">至</span>
              <div class="yun_resume_popup_list_box">
               <input type="text" id="project_edate" name="edate[]" value="" onfocus="hidemsg('mprojectph','mprojectedph')" onblur="hidemsg('mprojectph','mprojectedph')" class="yun_resume_popup_text yun_resume_popup_textw90">
			  <i class="yun_resume_popup_list_box_tip" id="mprojectph" style="display:none">请确认日期先后顺序</i>
			  <i class="yun_resume_popup_list_box_tip" id="mprojectedph" style="display:none">请选择结束日期</i>
               </div>
              </div>
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name">项目内容：</span>
              <textarea rows="5" cols="50" name="content[]" id="project_content" class="infor_textarea "  placeholder="为保护个人隐私，请不要填写手机号、QQ、微信等联系方式" ></textarea>
            </div>
          </li>
          <?php }?>
        </ul>
        <div class="yun_resume_add_to"><a href="javascript:;" onclick="addProject();">+ 添加项目经历</a></div>
      </div>
      <div class="yun_resume_popup_bot">
        <input name="eid" type="hidden" value="<?php echo $_GET['e'];?>
" />
        <input type="hidden" name="table" value="project">
      
        <input type="submit" name="submit" value="保存" class="expect_test_bth">
          <a href="javascript:;" onclick="hideMore('project')" class="expect_test_bth_qx">取消</a>
      </div>
      </form>
    </div> 
     <!--  项目经历弹出框 end-->
    <!--  附加信息弹出框-->
    <div id="saveother" style="background:#fff ;display:none">
    <form  method="post" action="index.php?c=expect&act=saveall" target="tanchukuang" autocomplete="off" onsubmit="return eload()">
      <div class="yun_resume_popup_box" style="width: 100%; max-height: 290px; overflow: auto; overflow-x:hidden ;position: relative; " id="other_div">
        <ul id="addother">
        <?php if ($_smarty_tpl->tpl_vars['other']->value) {?>
        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['other']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
         <li class="yun_resume_popup" id="oh<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
         <?php if ($_smarty_tpl->tpl_vars['resume_row']->value['other']==1) {?>
		 <i class="yun_resume_popup_del hidepic showothernum" id="io<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" onclick="deleteupbox('oh<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','io<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','showothernum','other')">删除</i>
		 <?php } else { ?>
		 <i class="yun_resume_popup_del showothernum" id="io<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" onclick="deleteupbox('oh<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','io<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','showothernum','other')">删除</i>
		 <?php }?>
            <input type="hidden" class="oh<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name="id[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"> 
            <input type="hidden" name="nameid[]" value="n<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
            <input type="hidden" name="contentid[]" value="noh1<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
            <input type="hidden" name="timeid[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>标题：</span>
              <div class="yun_resume_popup_qyname"> <input type="text" name="name[]" id="other_title" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" placeholder="必填"  onfocus="hidemsg('mothern<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" onblur="hidemsg('mothern<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" class="yun_resume_popup_text">
              <i class="yun_resume_popup_qyname_tip" id="mothern<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="display:none">请填写标题</i></div>
            </div>
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>内容：</span>
              <textarea rows="5" cols="50" name="content[]" id="other_content"  value="<?php echo $_smarty_tpl->tpl_vars['v']->value['content'];?>
" onfocus="hidemsg('mothernoh1<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" onblur="hidemsg('mothernoh1<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" class="infor_textarea infor_textarea_h80"  placeholder="必填，为保护个人隐私，请不要填写手机号、QQ、微信等联系方式" ><?php echo $_smarty_tpl->tpl_vars['v']->value['content'];?>
</textarea>
               <i class="yun_resume_popup_qyname_tip yun_resume_popup_tip_pj" id="mothernoh1<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="display:none">请填写内容</i>
            </div>
          </li>
          <?php } ?>
          <?php } else { ?>
          <li class="yun_resume_popup" id="otherhide">
          <i class="yun_resume_popup_del hidepic showothernum" id="iother" onclick="deleteupbox('otherhide','iother','showothernum','other')">删除</i>
            <input type="hidden" class="otherhide" name="id[]" value="">
            <input type="hidden" name="nameid[]" value="noh">
            <input type="hidden" name="contentid[]" value="noh1">
            <input type="hidden" name="timeid[]" value="otherhide">
            <input type="hidden" class="usedother" name="usedid[]" value="">
            <div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>标题：</span>
              <div class="yun_resume_popup_qyname"> <input type="text" name="name[]" id="other_title" value=""  placeholder="必填" onfocus="hidemsg('mothernoh')" onblur="hidemsg('mothernoh')" class="yun_resume_popup_text">
              <i class="yun_resume_popup_qyname_tip" id="mothernoh" style="display:none">请填写标题</i></div>
            </div>
			<div class="yun_resume_popup_list"><span class="yun_resume_popup_name"><i class="yun_resume_popup_bt">*</i>内容：</span>
				<div class="yun_resume_popup_qyname"> 
					<textarea rows="5" cols="50" name="content[]" id="other_content" class="infor_textarea infor_textarea_h80" onfocus="hidemsg('mothernoh1')" onblur="hidemsg('mothernoh1')" placeholder="必填，为保护个人隐私，请不要填写手机号、QQ、微信等联系方式" ></textarea>

					<i class="yun_resume_popup_qyname_tip" id="mothernoh1" style="display:none;margin-top:45px;">请填写内容</i>
				</div>
            </div>
          </li>
          <?php }?>
        </ul>
        <div class="yun_resume_add_to"><a href="javascript:;" onclick="addOther();">+ 添加其他信息</a></div>
      </div>
      <div class="yun_resume_popup_bot">
        <input name="eid" type="hidden" value="<?php echo $_GET['e'];?>
" />
        <input type="hidden" name="table" value="other">
       
         <input type="submit" name="submit" value="保存" class="expect_test_bth">
          <a href="javascript:;" onclick="hideMore('other')" class="expect_test_bth_qx">取消</a>
      </div>
      </form>
    </div> 
     <!-- 附加信息弹出框 end-->
               
        <!-- 自我评价弹出框-->
    <div id="savedescription" style="background:#fff ;display:none">
    <form  method="post" action="index.php?c=expect&act=saveall" target="tanchukuang" onsubmit="return checkdes()" autocomplete="off">
      <div class="yun_resume_popup_box" style="width: 100%;position: relative; ">
      <div class="resume_pj_my_cont">
        <div class="resume_pj_my_left"><i class="yun_resume_popup_bt">*</i>自我评价：</div>
		 <div class="resume_pj_my_right"> 
		 <textarea rows="5" cols="50" name="description" id="check_des" class="resume_pj_my_conttextarea " placeholder="必填，建议您对自己做一个简短评价，简明扼要地描述您的职业优势，让用人单位快速地了解您！优秀的自我评价可以吸引招聘人员的眼球，为您的简历增色不少！为保护个人隐私，请不要填写手机号、QQ、微信等联系方式" onfocus="hidemsg('des_show')" onblur="hidemsg('des_show')"><?php echo $_smarty_tpl->tpl_vars['resume']->value['description'];?>
</textarea>
		 <i class="yun_resume_popup_qyname_tip yun_resume_popup_tip_pj" id="des_show" style="display:none">请填写评价内容</i>
		
        <div class="look_other"><a href="javascript:void(0);" onclick="opendiv();">看看别人怎么写</a></div>
                <div class="eva_ex_list" style="display: none;" id="divopen"> </div>
         </div>
		
      
         
			<div class="resume_pj_my_left">职业优势：</div>
			<div class="resume_pj_my_right"> 
				<div class="resume_pop_bq fl">
					<ul id="newtag">
						<?php  $_smarty_tpl->tpl_vars['tv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tv']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['resume']->value['arrayTag']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tv']->key => $_smarty_tpl->tpl_vars['tv']->value) {
$_smarty_tpl->tpl_vars['tv']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['tv']->key;
?>
							<li class="changetag resume_pop_bq_cur" data-tag="<?php echo $_smarty_tpl->tpl_vars['tv']->value;?>
" tag-class="2"><em><?php echo $_smarty_tpl->tpl_vars['tv']->value;?>
</em></li> 
						<?php } ?>
					</ul>
					<ul>
						<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_tag']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
							<?php if (!in_array($_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value],$_smarty_tpl->tpl_vars['resume']->value['arrayTag'])) {?>
								<li class="changetag " data-tag="<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
" tag-class="1"><em><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</em></li> 
							<?php }?>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
		 <div class="fl" style="margin-top:10px;">
		 <div class="resume_pj_my_left">&nbsp;</div>
		 <input class="yun_resume_bc" type="inputText" tabindex="1000" id="addfuli" placeholder="自定义职业优势" ><a class="checkboxAddBton">添加标签</a><span class="bq_tip">最多只能选择5项</span>
		 <input type="hidden" name="tag" id="tag" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['tag'];?>
">
		 </div>         
         
         
            </div>

            <div class="clear"></div>

         <div class="yun_resume_popup_bot" style="margin-top:15px;">
        <input name="eid" id="eid" type="hidden" value="<?php echo $_GET['e'];?>
" />
        <input type="hidden" name="table" value="description">
       
        <input type="submit" name="submit" value="保存"  class="expect_test_bth">
         <a href="javascript:;" onclick="hideMore('description')" class="expect_test_bth_qx">取消</a>
      </div>
      </form>
    </div> 
     <!-- 自我评价弹出框 end-->
<iframe id="tanchukuang" name="tanchukuang" onload="resumeFanhui('tanchukuang');" style="display:none"></iframe>
<?php echo '<script'; ?>
 language=javascript src='<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/data/plus/city.cache.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
'><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui.upload.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type='text/javascript'><?php echo '</script'; ?>
>
<link href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/css/formSelects-v4.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/formSelects-v4.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
	function checkmoney(obj) {
		obj.value = obj.value.replace(/[^0-9.]/g, '')
		obj.value = obj.value.replace(/[^\d.]/g, ""); //清除“数字”和“.”以外的字符  
		obj.value = obj.value.replace(/\.{2,}/g, "."); //只保留第一个. 清除多余的  
		obj.value = obj.value.replace(".", "$#$").replace(/\./g, "").replace("$#$", ".");
		obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/, '$1$2.$3'); //只能输入两个小数  
		if(obj.value.indexOf(".") < 0 && obj.value != "") { //以上已经过滤，此处控制的是如果没有小数点，首位不能为类似于 01、02的金额 
			obj.value = parseFloat(obj.value);
		}
	}

layui.use(['layer', 'form','laydate'], function(){
    var layer = layui.layer
    ,laydate = layui.laydate
    ,formSelects = layui.formSelects
    ,$ = layui.$;
    form = layui.form;
    form.on('select(ing)',function(data){
        if(data.value>0){
        $("#mskillsld").css('display','none');
      } 
    })
    form.on('select(ingid)',function(data){
      var randid  =data.elem.dataset.id;
      if(data.value>0){
        $("#mskilli"+randid).css('display','none');
      }
   });
    form.on('select(ingrand)', function(data){
      var rand  = data.elem.dataset.rand;
       if(data.value>0){
       
         $("#mskilli"+rand).css('display','none');
       }
    });
    form.on("select(education)", function(data){
    	
      var id  = data.elem.dataset.id;
       if(data.value>0){
       
         $("#"+id).css('display','none');
       }
    });
    formSelects.btns('cityclass_search', []);
    formSelects.btns('jobclass_search', []);
    //实时获取选中值
    formSelects.on('jobclass_search', function(id, vals, val, isAdd, isDisabled){
        var jobvalue = [];
        vals.forEach(function(item,index){
          jobvalue.push(item.value);
        })
        $('#job_class').val(jobvalue.join(','));
    }, true);
    formSelects.on('cityclass_search', function(id, vals, val, isAdd, isDisabled){
        var cityvalue = [];
        vals.forEach(function(item,index){
          cityvalue.push(item.value);
        })
        $('#city_class').val(cityvalue.join(','));
    }, true);
    //初始化职位类别选择
    '<?php if ($_smarty_tpl->tpl_vars['row']->value['job_classid']) {?>'
    jobSearchReset()
    '<?php }?>'
    //初始化城市类别选择
    '<?php if ($_smarty_tpl->tpl_vars['row']->value['city_classid']) {?>'
    citySearchReset();
    '<?php }?>'
    formSelects.maxTips('jobclass_search', function(id, vals, val, max){
        layer.msg('最多只能选择5个！', 2, 8);
    });
    formSelects.maxTips('cityclass_search', function(id, vals, val, max){
        layer.msg('最多只能选择5个！', 2, 8);
    });


    '<?php if (!$_smarty_tpl->tpl_vars['row']->value['birthday']) {?>'
		laydate.render({
			elem: '#birthday'
			,max: -5113,
			value: '1990-01-01'
		});
		'<?php } else { ?>'
		laydate.render({
			elem: '#birthday'
			,max: -5113,
		});
		'<?php }?>'
	$("input[name='type']").each(function(){
		$(this).next().click(function(){
			var val = $(this).prev().val();
			if(val){
				$("#typeid").val(val);
			}
		});
	});
});
function jobSearchReset(){

  var formSelects = layui.formSelects,
      jobclassArr= $("#job_class").val()!='' ? $("#job_class").val().split(",") : [],
      jarr = [];
    for(var i=0;i<jobclassArr.length;i++){
        jarr.push({"name":jn[jobclassArr[i]],"value":jobclassArr[i],"selected":'selected'});
    }
    
    formSelects.data('jobclass_search', 'local', {
        arr: jarr
    });
}
function citySearchReset(){

  var formSelects = layui.formSelects, 
    cityclassArr= $("#city_class").val()!='' ? $("#city_class").val().split(",") : [],
        carr = [];

    for(var i=0;i<cityclassArr.length;i++){
      carr.push({"name":cn[cityclassArr[i]],"value":cityclassArr[i],"selected":'selected'});
    }
    formSelects.data('cityclass_search', 'local', {
        arr: carr
    });
}
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['userstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
