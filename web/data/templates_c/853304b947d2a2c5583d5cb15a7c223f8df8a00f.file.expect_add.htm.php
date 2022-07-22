<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:10:02
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\member\user\expect_add.htm" */ ?>
<?php /*%%SmartyHeaderCode:3028462d8fbca943371-74688464%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '853304b947d2a2c5583d5cb15a7c223f8df8a00f' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\member\\user\\expect_add.htm',
      1 => 1635405861,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3028462d8fbca943371-74688464',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'style' => 0,
    'config' => 0,
    'userdata' => 0,
    'v' => 0,
    'userclass_name' => 0,
    'resume' => 0,
    'jionly' => 0,
    'cionly' => 0,
    'industry_index' => 0,
    'industry_name' => 0,
    'user_sex' => 0,
    'j' => 0,
    'user_style' => 0,
    'isremind' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d8fbcab0abd6_04660793',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d8fbcab0abd6_04660793')) {function content_62d8fbcab0abd6_04660793($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['userstyle']->value)."/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/public_search/index_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/style/newclass.public.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/css"/>
<?php echo '<script'; ?>
 type="text/javascript">
	function addWork(){
		$("#addwork").append(function(){
			var randnum='w'+parseInt(Math.random()*1000); 
			var html="";

			html+="<div class='news_expect_n_box' id='"+randnum+"'><div class='news_expect_list news_expect_listtj'>";
			html+="		<span class='news_expect_list_span'><i class='news_expectfont'>*</i>公司名称：</span>";	
			html+="		<div class='news_expect_list_rbox'><input type='text' value='' name='workname[]' id='workname"+randnum+"' class='news_expect_text_t1' onBlur=\"checkonblur('workname"+randnum+"','rand');\" placeholder='请填写公司名称'/><span class='news_expect_name'></span><div class='resume_tip'><span class='none' id='hidworkname"+randnum+"'></span></div></div><i class='yun_resume_popup_del showedunum news_expect_listqx' id='"+randnum+"' onclick=\"deletebox('"+randnum+"')\">删除</i></div>";
			html+="		<div class='news_expect_list news_expect_w1000'><span class='news_expect_list_span'><i class='news_expectfont'>*</i>担任职位：</span><div class='news_expect_list_rbox'><input type='text' value='' name='worktitle[]' id='worktitle"+randnum+"' class='news_expect_text_t1' onBlur=\"checkonblur('worktitle"+randnum+"','rand');\" placeholder='请填写担任职位'/><span class='news_expect_name'></span><div class='resume_tip'><span class='none' id='hidworktitle"+randnum+"'></span></div></div></div>";					
			html+="		<div class='news_expect_list news_expect_listw100'><span class='news_expect_list_span'><i class='news_expectfont'>*</i>在职时间：</span><div class='news_expect_list_rbox'><input name='worksdate[]' id='worksdate"+randnum+"' type='text' onfocus=\"showblurmsg('worksdate"+randnum+"',1,'')\" value=''placeholder='请选择入职时间'  class='news_expectadd_text' style='width:105px'><span class='news_expect_text_xzline'>-</span><input name='workedate[]' id='workedate"+randnum+"' type='text' value=''placeholder='请选择离职时间' onfocus=\"showblurmsg('workedate"+randnum+"',1,'')\"    class='news_expectadd_text' style='width:105px'><div class='news_expect_listtody'><input type='checkbox' value='1' id='stopdate"+randnum+"' data-random='"+randnum+"' name='stopdate[]' lay-filter='stopdate' title='至今' lay-skin='primary'><input type='hidden' id='totoday"+randnum+"' name='totoday[]' value='0' /></div><?php echo '<script'; ?>
>layui.use(['laydate'], function(){var laydate = layui.laydate;monthclick(laydate,'#worksdate"+randnum+"');monthclick(laydate,'#workedate"+randnum+"');});<\/script><span class='news_expect_name'></span><div class='resume_tip'><span class='none' id='hidworksdate"+randnum+"'></span></div></div></div>"	;
			html+="		<div class='news_expect_textarea'><span class='news_expect_list_span'>工作内容：</span><div class='news_expect_list_rbox'><div class='news_expect_textarea_box'><textarea rows='5' cols='50' name='workcontent[]' id='workcontent"+randnum+"' class='news_expect_n_boxtextarea 'placeholder='请简述一下岗位职责和工作业绩，让用人单位对更多了解你！'></textarea></div><span class='news_expect_name'></span><div class='resume_tip'><span class='none' id='hidworkcontent"+randnum+"'></span></div></div></div></div>";						
			return html;
	    });
	    layui.use(['form'], function(){
	      layui.form.render();
	    });
	}
	function addEdu(){
		$("#addedu").append(function(){
			 var randnum='e'+parseInt(Math.random()*1000); 
			 var html="";
			 html	+="<div id='"+randnum+"' class='news_expect_n_box'><div class='news_expect_list'><span class='news_expect_list_span'><i class='news_expectfont'>*</i>学校名称：</span><div class='news_expect_list_rbox'><input type='text' value='' name='eduname[]' id='eduname"+randnum+"' class='news_expect_text_t1' onBlur=\"checkonblur('eduname"+randnum+"','rand');\" placeholder='请填写学校名称'/><span class='news_expect_name'></span><div class='resume_tip'><span class='none' id='hideduname"+randnum+"'></span></div></div><i class='yun_resume_popup_del showedunum news_expect_listqx' id='"+randnum+"' onclick=\"deletebox('"+randnum+"')\">删除</i></div>";

			 html	+="<div class='news_expect_list news_expect_w1000'><span class='news_expect_list_span'><i class='news_expectfont'>*</i>在校时间：</span><div class='news_expect_list_rbox'><input name='edusdate[]' id='edusdate"+randnum+"' type='text' value='' onfocus=\"showblurmsg('edusdate"+randnum+"',1,'')\" class='news_expectadd_text'placeholder='请选择入校时间' /><span class='news_expect_text_xzline'>-</span><input name='eduedate[]' id='eduedate"+randnum+"' onfocus=\"showblurmsg('eduedate"+randnum+"',1,'')\" type='text' value=''placeholder='请选择毕业时间' class='news_expectadd_text' /><span class='news_expect_name'></span><div class='resume_tip resume_tipw160'><span class='none' id='hidedusdate"+randnum+"'></span></div></div></div><?php echo '<script'; ?>
>layui.use(['laydate'], function(){var laydate = layui.laydate;monthclick(laydate,'#edusdate"+randnum+"');monthclick(laydate,'#eduedate"+randnum+"');});<\/script>";

			 html	+="<div class='news_expect_list'><span class='news_expect_list_span'><i class='news_expectfont'>*</i>最高学历：</span><div class='news_expect_text_big'><div class='layui-form-item'><div class='layui-input-inline' style='width:330px;'><select name='education[]' lay-filter='' id='education"+randnum+"'><option value=''>请选择学历</option><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_edu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?><option value='<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
'><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</option><?php } ?></select></div></div><div class='resume_tip'><span class='none' id='hideducation"+randnum+"'></span></div></div></div>";
			 html	+="<div class='news_expect_list news_expect_w1000'><span class='news_expect_list_span'>所学专业：</span><div class='news_expect_list_rbox'><input type='text' value='' name='eduspec[]' id='eduspec"+randnum+"' class='news_expect_text_t1' onBlur=\"checkonblur('eduspec"+randnum+"','rand');\" placeholder='请填写所学专业'/><span class='news_expect_name'></span><div class='resume_tip'><span class='none' id='hideduspec"+randnum+"'></span></div></div>	</div></div>";
					
			 return html;
	    });

	    layui.use(['form'], function(){
	      layui.form.render();
	    });
	}
	function addProject(){
		$("#addproject").append(function(){
			var randnum='e'+parseInt(Math.random()*1000); 
			var html="";

			html	+="<div id='"+randnum+"' class='news_expect_n_box'><div class='news_expect_list'><span class='news_expect_list_span'><i class='news_expectfont'>*</i>项目名称：</span><div class='news_expect_list_rbox'><input type='text' value='' name='proname[]' id='proname"+randnum+"'placeholder='请填写项目名称'  class='news_expect_text_t1' onBlur=\"checkonblur('proname"+randnum+"','rand');\" /><span class='news_expect_name'></span><div class='resume_tip'><span class='none' id='hidproname"+randnum+"'></span></div></div><i class='yun_resume_popup_del showedunum news_expect_listqx' id='"+randnum+"' onclick=\"deletebox('"+randnum+"')\">删除</i></div>";
			html	+="<div class='news_expect_list news_expect_w1000'><span class='news_expect_list_span'><i class='news_expectfont'>*</i>担任职位：</span><div class='news_expect_list_rbox'><input type='text' value='' name='protitle[]' id='protitle"+randnum+"'placeholder='请填写担任职位'  class='news_expect_text_t1' onBlur=\"checkonblur('protitle"+randnum+"','rand');\" /><span class='news_expect_name'></span><div class='resume_tip'><span class='none' id='hidprotitle"+randnum+"'></span></div></div></div>";

			html	+="<div class='news_expect_list'><span class='news_expect_list_span'><i class='news_expectfont'>*</i>项目时间：</span><div class='news_expect_list_rbox'><input name='prosdate[]' id='prosdate"+randnum+"' type='text' value='' onfocus=\"showblurmsg('prosdate"+randnum+"',1,'')\" placeholder='请选择项目开始时间' class='news_expectadd_text' /><span class='news_expect_text_xzline'>-</span><input name='proedate[]' id='proedate"+randnum+"' type='text' value=''  onfocus=\"showblurmsg('eduedate"+randnum+"',1,'')\" placeholder='请选择项目结束时间'  class='news_expectadd_text' /><span class='news_expect_name'></span><div class='resume_tip resume_tipw140'><span class='none' id='hidprosdate"+randnum+"'></span></div></div><?php echo '<script'; ?>
>layui.use(['laydate'], function(){var laydate = layui.laydate;monthclick(laydate,'#prosdate"+randnum+"');monthclick(laydate,'#proedate"+randnum+"');});<\/script></div>";

			html	+="<div class='news_expect_textarea'><span class='news_expect_list_span'>项目内容：</span><div class='news_expect_list_rbox'><div class='news_expect_textarea_box'><textarea rows='5' cols='50' name='procontent[]' id='procontent"+randnum+"' class='news_expect_n_boxtextarea'></textarea></div><span class='news_expect_name'></span><div class='resume_tip'><span class='none' id='hidprocontent"+randnum+"'></span></div></div></div></div>"

			 return html;
	    });

	    layui.use(['form'], function(){
	      layui.form.render();
	    });
	}
	function deletebox(id,type){
		$("#"+id).remove();
	}
<?php echo '</script'; ?>
>
<form action="index.php?c=expect&act=addsave" name="MyForm" method="post" target="expectiframe" onsubmit="return checkexpect();" autocomplete="off" class="layui-form">
	<div class="news_expect_body">
		<div class="news_expect">
		
				<div class="news_expect_cont_h1">
					<div class="news_expect_cont_h1_box">
						<span class="news_expect_cont_h1_s">您正在创建简历</span>
						<div class="news_expect_cont_h1_p">简历是求职第一步，优质的简历才能更快找到满意工作！</div>
					</div>
				

                <?php if ($_smarty_tpl->tpl_vars['config']->value['resume_create_exp']=='1'||$_smarty_tpl->tpl_vars['config']->value['resume_create_edu']=='1'||$_smarty_tpl->tpl_vars['config']->value['resume_create_project']=='1') {?>
				<div class="fill_in_process" style="width:710px;">
                  <span class="fill_add_color"><i>1</i>求职意向<em>……</em></span>
                  <?php if ($_smarty_tpl->tpl_vars['config']->value['resume_create_exp']=='1') {?><span id="worktype"><i>2</i>工作经历<em>……</em></span><?php }?>
                  <?php if ($_smarty_tpl->tpl_vars['config']->value['resume_create_edu']=='1') {?><span id="edutype"><i><?php if ($_smarty_tpl->tpl_vars['config']->value['resume_create_exp']=='1') {?>3<?php } else { ?>2<?php }?></i>教育经历<em>……</em></span><?php }?>
                  <?php if ($_smarty_tpl->tpl_vars['config']->value['resume_create_project']=='1') {?><span id="projecttype"><i><?php if ($_smarty_tpl->tpl_vars['config']->value['resume_create_exp']=='1'&&$_smarty_tpl->tpl_vars['config']->value['resume_create_edu']=='1') {?>4<?php } elseif ($_smarty_tpl->tpl_vars['config']->value['resume_create_exp']=='1'||$_smarty_tpl->tpl_vars['config']->value['resume_create_edu']=='1') {?>3<?php } else { ?>2<?php }?></i>项目经历<em>……</em></span><?php }?>
                  <span><i class="fill_add_color_cg"></i>填写成功</span> 
                </div>
				<?php }?></div>
					<div class="news_expect_cont"><div class="news_expect_content" id="expect" style="display: block">
          
            					<div class="news_expect_tit"><span class="news_expect_tit_s"><i class="news_expect_tit_yx_icon"></i>求职意向</span></div>

					<div class="news_expect_n_box">
                     <div class="news_expect_new_left">
						<div class="news_expect_list">
							<span class="news_expect_list_span"><i class="news_expectfont">*</i>期望职位：</span>
							<div class="news_expect_list_rbox">
                            <input type="text" value="" name="name" id="name" class="news_expect_text_t1" onBlur="checkonblur('name');" placeholder="具体岗位 如：销售主管" />
							<span class="resume_tip" style="position:absolute;left: 340px;top: 10px;width: 150px;"><span class="none" id="hidname"></span></span>
                            </div>
						</div>
        
						<div class="news_expect_list">
							<span class="news_expect_list_span "><i class="news_expectfont">*</i>工作职能：</span>
							<div class="news_expect_text_new  news_expect_text_re20" style="width:330px;">
								<input name='job_class' id='job_class' value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['job_classid'];?>
" type='hidden'/>
								<select id="jobclass_search" name="jobclass_search" xm-select-type="jobclass" xm-select="jobclass_search" xm-select-search="" xm-select-max="5" xm-select-skin="default"  xm-select-direction="down">
								<option value="">输入搜索，最多选5项</option>
								</select>
								<?php if ($_smarty_tpl->tpl_vars['jionly']->value!='1') {?>
								<div onclick="index_job_new(5,'#workadds_job','#job_class','left:100px;top:100px; position:absolute;','1');" class="news_expect_text_new_nth" title="选择职位类别"></div>
								<?php }?>
								<div class="resume_tip" style="position:absolute;left: 340px;top: 10px;width: 150px;"><span class="none" id="hidjob_class"></span></div>
							</div>
						</div>
						
						<div class="news_expect_list">
							<span class="news_expect_list_span "><i class="news_expectfont">*</i>期望城市：</span>
							<div class="news_expect_text_new  news_expect_text_re10" style="width:330px;">
								<input name='city_class' id='city_class' value="" type='hidden' />
								<select id="cityclass_search" name="cityclass_search" xm-select-type="cityclass" xm-select="cityclass_search" xm-select-search="" xm-select-max="5" xm-select-skin="default"  xm-select-direction="down">
								<option value="">输入搜索，最多选5项</option>
								</select>
								<?php if ($_smarty_tpl->tpl_vars['cionly']->value!='1') {?>
								<div onclick="index_city_new(5,'#cityadds_job','#city_class','left:100px;top:100px; position:absolute;')" class="news_expect_text_new_nth" title="选择城市"></div>
								<?php }?>
								<div class="resume_tip" style="position:absolute;left: 340px;top: 10px;width: 150px;"><span class="none" id="hidcity_class"></span></div>
							</div>
						</div>
					
				

						<div class="news_expect_list">
							<span class="news_expect_list_span"><i class="news_expectfont">*</i>到岗时间：</span>
							<div class="news_expect_text_big  ">
								<div class="layui-form-item">
									<div class="layui-input-inline" style="width:330px;">
										<select name="report" lay-filter="" id="reportid">
											<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_report']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
											<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['resume']->value['report']==$_smarty_tpl->tpl_vars['v']->value) {?>selected="selected" <?php }?>><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</option>
											<?php } ?>
										</select>
									</div>
								</div>
							
							<div class="resume_tip" style="position:absolute;left: 340px;top: 10px;width: 150px;"><span class="none" id="hidreportid"></span></div>
						</div>
</div>
				</div>
                <div class="news_expect_new_right">
              			
						<div class="news_expect_list">
							<span class="news_expect_list_span news_expect_list_spanw160"><i class="news_expectfont">*</i>期望薪资：</span>
                            <div class="news_expect_list_rbox">
							<div class="news_expect_xztext_box">
								<input type="text" id="minsalary" name="minsalary" size="5" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['minsalary'];?>
" onkeyup="checkmoney(this)" class="news_expect_xztext " onBlur="checkonblur('minsalary');" placeholder="最低薪资" />
								<span class="job_expectxz_dw">元/月</span>
							</div>
							<span class="news_expect_text_xzline">-</span>
							<div class="news_expect_xztext_box">
								<input type="text" id="maxsalary" name="maxsalary" size="5" placeholder="最高薪资" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['maxsalary'];?>
" onkeyup="checkmoney(this)" class="news_expect_xztext" />
								<span class="job_expectxz_dw">元/月</span>
							</div>
							<div class="resume_tip"><span class="none" id="hidminsalary"></span></div>
						</div></div><div class="news_expect_list">
							<span class="news_expect_list_span news_expect_list_spanw160"><i class="news_expectfont">*</i>工作性质：</span>
							<div class="news_expect_text_big  news_expect_text_re6">
								<div class="layui-form-item">
									<div class="layui-input-inline" style="width:330px;">
										<select name="type" lay-filter="" id="typeid">
											<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_type']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
											<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['resume']->value['type']==$_smarty_tpl->tpl_vars['v']->value) {?>selected="selected" <?php }?>><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</option>
											<?php } ?>
										</select>
									</div>
								</div>
							
							<div class="resume_tip"><span class="none" id="hidtypeid"></span></div>
						</div></div>
                        	<div class="news_expect_list">
							<span class="news_expect_list_span news_expect_list_spanw160">从事行业：</span>
							<div class="news_expect_text_big  ">
								<div class="layui-form-item">
									<div class="layui-input-inline" style="width:330px;">
										<select name="hy" lay-filter="" id="hyid">
											<option value="0" >不限</option>
											<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['industry_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
												<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['resume']->value['hy']==$_smarty_tpl->tpl_vars['v']->value) {?>selected="selected" <?php }?>><?php echo $_smarty_tpl->tpl_vars['industry_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</option>
											<?php } ?>
										</select>
									</div>
								</div>
								
							
							<div class="resume_tip"><span class="none" id="hidhyid"></span></div>
						</div></div>
						
                      
						
						<div class="news_expect_list">
							<span class="news_expect_list_span news_expect_list_spanw160"><i class="news_expectfont">*</i>求职状态：</span>
							<div class="news_expect_text_big  ">
								<div class="layui-form-item">
									<div class="layui-input-inline" style="width:330px;">
										<select name="jobstatus" lay-filter="" id="statusid">
											<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_jobstatus']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
											<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['resume']->value['jobstatus']==$_smarty_tpl->tpl_vars['v']->value) {?>selected="selected" <?php }?>><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</option>
											<?php } ?>
										</select>
									</div>
								</div>
							
							<div class="resume_tip"><span class="none" id="hidstatusid"></span></div>
						</div></div>
					</div>  </div>
        
					<div class="news_expect_tit"><span class="news_expect_tit_s"><i class="news_expect_tit_s_icon"></i>基本信息</span></div>
					<div class="news_expect_n_box">

						<div class="news_expect_list">
							<span class="news_expect_list_span"><i class="news_expectfont">*</i>姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名：</span>
                            <div class="news_expect_list_rbox">
							<input type="text" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['name'];?>
" <?php if ($_smarty_tpl->tpl_vars['resume']->value['idcard_status']==1) {?>readonly<?php }?> name="uname" id="uname" class="news_expect_text_t1" onBlur="checkonblur('uname');"/>
							
							<?php if ($_smarty_tpl->tpl_vars['resume']->value['idcard_status']==1) {?>
								<a href="index.php?c=passwd" class="news_ok_rz">已实名认证，重新认证？</a>
							<?php } else { ?>
							<div class="resume_tip">	<span class="none" id="hiduname"></span></div>
							<?php }?>
							
							
						</div></div>

						<div class="news_expect_list" style="height:38px;">
							<span class="news_expect_list_span news_expect_list_spanw160"><i class="news_expectfont">*</i>性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别：</span>
							<div class="news_expect_list_rbox">
                            <input type="hidden" id="sex" name="sex" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['sex'];?>
" /> 
							<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['user_sex']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
								<span class="news_expect_sex_t news_expect_sex <?php if ($_smarty_tpl->tpl_vars['j']->value==$_smarty_tpl->tpl_vars['resume']->value['sex']) {?>news_expect_sex_cur<?php }?>" id="<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
sex" onclick="checksex('<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
')"><i class="news_expect_icon_sex news_expect_icon_sex<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
"></i><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</span> 
							<?php } ?>
							<div class="resume_tip"><span class="none" id="hidsex"></span></div>
						</div></div>

						<div class="news_expect_list">
							<span class="news_expect_list_span"><i class="news_expectfont">*</i>出生年月：</span>
							<div class="news_expect_text_big_box ">
								<input name="birthday" id="birthday" type="text" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['birthday'];?>
" class="news_expect_text_time" readonly />
						
							<div class="resume_tip"><span class="none" id="hidbirthday"></span> </div>
						</div>	</div>

						<div class="news_expect_list">
							<span class="news_expect_list_span news_expect_list_spanw160"><i class="news_expectfont">*</i>现居住地：</span><div class="news_expect_list_rbox">
							<input type="text" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['living'];?>
" name="living" class="news_expect_text_t1" id="living" onBlur="checkonblur('living');" />
							<div class="resume_tip"><span class="none" id="hidliving"></span></div>
						</div></div>

						<div class="news_expect_list">
							<span class="news_expect_list_span"><i class="news_expectfont">*</i>最高学历：</span>
							<div class="news_expect_text_big ">
								<div class="layui-form-item">
									<div class="layui-input-inline" style="width:330px;">
										<select name="edu" lay-filter="edu" id="educid">
											<option value="">请选择最高学历</option>
											<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_edu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
												<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['resume']->value['edu']==$_smarty_tpl->tpl_vars['v']->value) {?>selected="selected" <?php }?>><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</option>
											<?php } ?>
										</select>
									</div>
								</div>
							
							<div class="resume_tip"><span class="none" id="hideducid"></span></div>
						</div></div>

						

						<div class="news_expect_list">
							<span class="news_expect_list_span news_expect_list_spanw160"><i class="news_expectfont">*</i>手机号码：</span> <div class="news_expect_list_rbox">
							<?php if ($_smarty_tpl->tpl_vars['resume']->value['moblie_status']==1) {?>
								<span class="news_phe_ok"><?php echo $_smarty_tpl->tpl_vars['resume']->value['telphone'];?>
 <a href="index.php?c=passwd" class="news_ok_rz">重新认证</a></span>
								
								<input type="hidden" id="telphone" name="telphone" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['telphone'];?>
"> 
							<?php } else { ?>
								<input name="telphone" id="telphone" type="text" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['telphone'];?>
" onkeyup="this.value=this.value.replace(/[^0-9.]/g,'')" class="news_expect_text_t1" onBlur="checkonblur('telphone');" />
								<span id="by_telphone" style="display:none">请正确填写手机号码</span> 
							<?php }?>
							<div class="resume_tip"><span class="none" id="hidtelphone"></span></div>
						</div>
                        </div>
						<div class="news_expect_list">
							<span class="news_expect_list_span"><i class="news_expectfont">*</i>工作经验：</span>
							<div class="news_expect_text_big   news_expect_text_re1">
								<div class="layui-form-item">
									<div class="layui-input-inline" style="width:330px;">
										<select name="exp" lay-filter="exp" id="expid">
											<option value="">请选择工作经验</option>
											<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_word']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
												<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['resume']->value['exp']==$_smarty_tpl->tpl_vars['v']->value) {?>selected="selected" <?php }?>><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</option>
											<?php } ?>
										</select>
									</div>
								</div>
							
							<div class="resume_tip"><span class="none" id="hidexpid"></span></div>
						</div></div>
						<div class="news_expect_list">
							<span class="news_expect_list_span news_expect_list_spanw160">联系邮箱：</span> 
							<div class="news_expect_list_rbox"><?php if ($_smarty_tpl->tpl_vars['resume']->value['email_status']==1) {?>
								<span class="news_email_ok"><?php echo $_smarty_tpl->tpl_vars['resume']->value['email'];?>
</span>
								<a href="index.php?c=passwd" class="news_ok_rz">重新认证</a>
								<input type="hidden" id="email" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['email'];?>
"> 
							<?php } else { ?>
								<input name="email" id="email" type="text" size="30" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['email'];?>
" class="news_expect_text_t1" onBlur="checkonblur('email');" />
								<span id="by_email" class="errordisplay">邮件格式错误</span> 
							<?php }?>
							<div class="resume_tip"><span class="none" id="hidemail"></span></div>
						</div></div>
					</div>
          
          <div class="news_expect_fotbox">
					<div class="news_expect_nbth">
						<?php if ($_smarty_tpl->tpl_vars['config']->value['resume_create_exp']!='1'&&$_smarty_tpl->tpl_vars['config']->value['resume_create_edu']!='1'&&$_smarty_tpl->tpl_vars['config']->value['resume_create_project']!='1') {?>
						<input type="submit" class="news_expect_list_sub" value="保存" name="submit">
						<?php } else { ?>
						<input type="button" class="news_expect_list_sub" value="下一步" name="submit" onclick="checknext('expect')">
						<?php }?>
					</div></div>
				</div>



					<?php if ($_smarty_tpl->tpl_vars['config']->value['resume_create_exp']=='1') {?>
					<!---工作经历start---->
					<div class="news_expect_content" id="work" style="display:none;">
							<div class="news_expect_tit">
								<span class="news_expect_tit_s"><i class="news_expect_tit_yx_icon"></i>工作经历</span>
								<span id="isexpshow" style="top: -35px;left:200px; position:relative; display:none;">
									<input type="radio" name="iscreateexp" checked="checked" id="iscreateexp1" lay-filter="iscreateexp" value="1" title="有">
									<input type="radio" name="iscreateexp" id="iscreateexp2" lay-filter="iscreateexp" value="2" title="无">
								</span>
							</div>
							<div id="addwork">
								<div class="news_expect_n_box">

									<div class="news_expect_list">
										<span class="news_expect_list_span"><i class="news_expectfont">*</i>公司名称：</span><div class="news_expect_list_rbox">
										<input type="text" value="" name="workname[]" id="workname" class="news_expect_text_t1" onBlur="checkonblur('workname','rand');" placeholder="请填写公司名称"/>
										<span class="news_expect_name"></span>
										<div class="resume_tip"><span class="none" id="hidworkname"></span></div>
									</div></div>

									<div class="news_expect_list news_expect_w1000">
										<span class="news_expect_list_span"><i class="news_expectfont">*</i>担任职位：</span><div class="news_expect_list_rbox">
										<input type="text" value="" name="worktitle[]" id="worktitle" class="news_expect_text_t1" onBlur="checkonblur('worktitle','rand');" placeholder="请填写担任职位"/>
										<span class="news_expect_name"></span>
										<div class="resume_tip"><span class="none" id="hidworktitle"></span></div>
									</div></div>

									<div class="news_expect_list news_expect_listw100">
										<span class="news_expect_list_span"><i class="news_expectfont">*</i>在职时间：</span><div class="news_expect_list_rbox">
										<input name="worksdate[]" id="worksdate" type="text" value="" onfocus="showblurmsg('worksdate',1,'')"  placeholder="请选择入职时间"class="news_expectadd_text" style="width:105px">
										<span class="news_expect_text_xzline">-</span>
										<input name="workedate[]" id="workedate" type="text" value="" onfocus="showblurmsg('workedate',1,'')" class="news_expectadd_text" placeholder="请选择离职时间"style="width:105px">
										<div class="news_expect_listtody">
											<input type="checkbox" value='1' data-random='' id="stopdate" name="stopdate[]" lay-filter="stopdate" title="至今" lay-skin="primary"> 
											<input type="hidden" id="totoday" name="totoday[]" value='0' />
										</div>
										<?php echo '<script'; ?>
>
										    layui.use(['laydate'], function(){var laydate = layui.laydate;monthclick(laydate,'#worksdate');monthclick(laydate,'#workedate');});
										<?php echo '</script'; ?>
>
										<span class="news_expect_name"></span>
										<div class="resume_tip"><span class="none" id="hidworksdate"></span></div>
									</div>
	                                </div>

									<div class="news_expect_textarea">
										<span class="news_expect_list_span">工作内容：</span>
	                                    <div class="news_expect_list_rbox">
										<div class="news_expect_textarea_box">
											<textarea rows="5" cols="50" name="workcontent[]" id="workcontent" class="news_expect_n_boxtextarea " placeholder="请简述一下岗位职责和工作业绩，让用人单位对更多了解你！"></textarea>
										</div>
										<span class="news_expect_name"></span>
										<div class="resume_tip"><span class="none" id="hidworkcontent"></span></div>
									</div></div>
                                     <div class="wsexpect_tip"> 80%的企业通过工作经历来了解您的真实情况，您可添加多个工作经历~
                                     <div class="wsexpect_tip_bth"><a href="javascript:;" onclick="addWork();" class="wsexpect_tip_tj">+ 添加工作经历</a></div></div>
								</div>
							</div>

                           
	                        <div class="news_expect_fotbox">
	                        
								<div class="news_expect_nbth">
									
									<?php if ($_smarty_tpl->tpl_vars['config']->value['resume_create_edu']!='1'&&$_smarty_tpl->tpl_vars['config']->value['resume_create_project']!='1') {?>
									<input type="submit" class="news_expect_list_sub" value="保存" name="submit">
									<?php } else { ?>
									<input type="button" class="news_expect_list_sub" value="下一步" name="submit" onclick="checknext('work')">
									<?php }?><input type="button" class="layui-btn layui-btn-primary" value="返回上一步" name="submit" onclick="checkback('expect','work')" style="margin-left:20px">
								</div>
							</div>
							</div>
							<!--end-->
						<?php }?> 

						<?php if ($_smarty_tpl->tpl_vars['config']->value['resume_create_edu']=='1') {?>
							<!--教育经历start-->
						<div class="news_expect_content" id="edu" style="display:none;">
							<div class="news_expect_tit">
								<span class="news_expect_tit_s"><i class="news_expect_tit_yx_icon"></i>毕业院校</span>
								<span id="isedushow" style="top: -35px;left:200px; position:relative; display:none;"><input type="radio" name="iscreateedu" checked="checked" id="iscreateedu1" lay-filter="iscreateedu" value="1" title="有"><input type="radio" name="iscreateedu" id="iscreateedu2" lay-filter="iscreateedu" value="2" title="无"></span>
							</div>
							<div id="addedu">
								<div class="news_expect_n_box">
									<div class="news_expect_list">
										<span class="news_expect_list_span"><i class="news_expectfont">*</i>学校名称：</span>
		                                <div class="news_expect_list_rbox">
											<input type="text" value="" name="eduname[]" id="eduname" class="news_expect_text_t1" onBlur="checkonblur('eduname','rand');" placeholder="请填写学校名称"/>
											<span class="news_expect_name"></span>
											<div class="resume_tip"><span class="none" id="hideduname"></span></div>
										</div>
	                                </div>

									<div class="news_expect_list news_expect_w1000">
										<span class="news_expect_list_span"><i class="news_expectfont">*</i>在校时间：</span>
		                                <div class="news_expect_list_rbox">
											<input name="edusdate[]" id="edusdate" onfocus="showblurmsg('edusdate',1,'')" type="text" value=""placeholder="请选择入校时间"  class="news_expectadd_text" />
											<span class="news_expect_text_xzline">-</span>
											<input name="eduedate[]" id="eduedate" type="text" onfocus="showblurmsg('eduedate',1,'')" value="" placeholder="请选择毕业时间" class="news_expectadd_text" />
											<span class="news_expect_name"></span>
											<div class="resume_tip resume_tipw160"><span class="none" id="hidedusdate"></span></div>
										</div>
									</div>
									<?php echo '<script'; ?>
>
									    layui.use(['laydate'], function(){var laydate = layui.laydate;monthclick(laydate,'#edusdate');monthclick(laydate,'#eduedate');});
									<?php echo '</script'; ?>
>
									<div class="news_expect_list news_expect_w1000">
										<span class="news_expect_list_span"><i class="news_expectfont">*</i>最高学历：</span>
										<div class="news_expect_text_big">
											<div class="layui-form-item">
												<div class="layui-input-inline" style="width:330px;">
													<select name="education[]" lay-filter="" id="education">
														<option value="">请选择学历</option>
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
										
											<div class="resume_tip"><span class="none" id="hideducation"></span></div>
										</div>
									</div>
									<div class="news_expect_list news_expect_w1000">
										<span class="news_expect_list_span">所学专业：</span>
		                                <div class="news_expect_list_rbox">
											<input type="text" value="" name="eduspec[]" id="eduspec" class="news_expect_text_t1" onBlur="checkonblur('eduspec','rand');" placeholder="请填写所学专业"/>
											<span class="news_expect_name"></span>
		                                    
											<div class="resume_tip"><span class="none" id="hideduspec"></span></div>
										</div>	
									</div>
									
                                     <div class="wsexpect_tip"> 企业需要了解您的教育经历，请认真填写！您可添加多个教育经历~
                                     <div class="wsexpect_tip_bth"><a href="javascript:;" onclick="addEdu();" class="wsexpect_tip_tj">+ 添加教育经历</a></div></div>
								</div>
							</div>
	                        <div class="news_expect_fotbox">
	                     
								<div class="news_expect_nbth">
									
									<?php if ($_smarty_tpl->tpl_vars['config']->value['resume_create_project']!='1') {?>
									<input type="submit" class="news_expect_list_sub" value="保存" name="submit">
									<?php } else { ?>
									<input type="button" class="news_expect_list_sub" value="下一步" name="submit" onclick="checknext('edu')">
									<?php }?><input type="button" class="layui-btn layui-btn-primary" value="返回上一步" name="submit" onclick="checkback('<?php if ($_smarty_tpl->tpl_vars['config']->value['resume_create_exp']==1) {?>work<?php } else { ?>expect<?php }?>','edu')" style="margin-left:20px">
								</div>
							</div>
						</div>
							<!---end--->
						<?php }?>
								
						<?php if ($_smarty_tpl->tpl_vars['config']->value['resume_create_project']=='1') {?>
							<!---项目经历start---->
						<div class="news_expect_content" id="project" style="display:none;">
							<div class="news_expect_tit">
								<span class="news_expect_tit_s"><i class="news_expect_tit_yx_icon"></i>项目经历：</span>
								<span id="isproshow" style="top: -35px;left:200px; position:relative; display:none;"><input type="radio" name="iscreatepro" checked="checked" id="iscreatepro1" lay-filter="iscreatepro" value="1" title="有"><input type="radio" name="iscreatepro" id="iscreatepro2" lay-filter="iscreatepro" value="2" title="无"></span>
							</div>
							<div id="addproject">
								<div class="news_expect_n_box">
									<div class="news_expect_list"><span class="news_expect_list_span"><i class="news_expectfont">*</i>项目名称：</span>
		                                <div class="news_expect_list_rbox">
											<input type="text" value="" name="proname[]" id="proname" class="news_expect_text_t1"placeholder="请填写项目名称" onBlur="checkonblur('proname','rand');" />
											<span class="news_expect_name"></span>
											<div class="resume_tip"><span class="none" id="hidproname"></span></div>
										</div>
									</div>
									<div class="news_expect_list news_expect_w1000"><span class="news_expect_list_span"><i class="news_expectfont">*</i>担任职位：</span>
		                                <div class="news_expect_list_rbox">
											<input type="text" value="" name="protitle[]" id="protitle" class="news_expect_text_t1"placeholder="请填写担任职位" onBlur="checkonblur('protitle','rand');" />
											<span class="news_expect_name"></span>
											<div class="resume_tip"><span class="none" id="hidprotitle"></span></div>
										</div>
	                                </div>

									<div class="news_expect_list"><span class="news_expect_list_span"><i class="news_expectfont">*</i>项目时间：</span>
		                                <div class="news_expect_list_rbox">
											<input name="prosdate[]" id="prosdate" onfocus="showblurmsg('prosdate',1,'')" type="text" value="" class="news_expectadd_text"  placeholder="请选择项目开始时间"/>
											<span class="news_expect_text_xzline">-</span>
											<input name="proedate[]" id="proedate" onfocus="showblurmsg('proedate',1,'')" type="text" value="" class="news_expectadd_text"  placeholder="请选择项目结束时间"/>
											<span class="news_expect_name"></span>
											<div class="resume_tip resume_tipw140"><span class="none" id="hidprosdate"></span></div>
										</div>
										<?php echo '<script'; ?>
>
									    layui.use(['laydate'], function(){var laydate = layui.laydate;monthclick(laydate,'#prosdate');monthclick(laydate,'#proedate');});
										<?php echo '</script'; ?>
>
									</div>

									<div class="news_expect_textarea"><span class="news_expect_list_span">项目内容：</span>
										<div class="news_expect_list_rbox">
											<div class="news_expect_textarea_box">
												<textarea rows="5" cols="50" name="procontent[]" id="procontent" placeholder="你在项目中承担了哪些工作？创造了什么业绩？" class="news_expect_n_boxtextarea"></textarea>
											</div>
											<span class="news_expect_name"></span>
											<div class="resume_tip"><span class="none" id="hidprocontent"></span></div>
										</div>
									</div>
									
                                     <div class="wsexpect_tip"> 请描述您主导或参与过项目，以便企业更加了解您的能力！您可添加多个项目经历~
                                     <div class="wsexpect_tip_bth"><a href="javascript:;"onclick="addProject();"class="wsexpect_tip_tj">+ 添加项目经历</a></div></div>
	                            </div>
	                        </div>
	                        <div class="news_expect_fotbox">
	                 
								<div class="news_expect_nbth">
									
									<input type="submit" class="news_expect_list_sub" value="保存" name="submit"><input type="button" class="layui-btn layui-btn-primary" value="返回上一步" name="submit" onclick="checkback('<?php if ($_smarty_tpl->tpl_vars['config']->value['resume_create_edu']==1) {?>edu<?php } elseif ($_smarty_tpl->tpl_vars['config']->value['resume_create_exp']==1) {?>work<?php } else { ?>expect<?php }?>','project')" style="margin-left:20px">
								</div>
							</div>
							
						</div>
							<!--end-->
						<?php }?>

						<input id="addtype" value="addexpect" type="hidden" />
					</div>
				</div>
			</div>
		</div>
	</div>
 	<input type='hidden' id='resume_edu' value='<?php echo $_smarty_tpl->tpl_vars['config']->value['resume_create_edu'];?>
'>
	<input type='hidden' id='resume_exp' value='<?php echo $_smarty_tpl->tpl_vars['config']->value['resume_create_exp'];?>
'>
	<input type='hidden' id='resume_pro' value='<?php echo $_smarty_tpl->tpl_vars['config']->value['resume_create_project'];?>
'>
</form>

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
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/newclass.public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/javascript"><?php echo '</script'; ?>
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

	layui.use(['layer', 'form', 'laydate'], function() {
		var layer = layui.layer,
			form = layui.form,
			formSelects = layui.formSelects,
			laydate = layui.laydate,
			$ = layui.$;

		'<?php if (!$_smarty_tpl->tpl_vars['resume']->value['birthday']) {?>'
		laydate.render({
			elem: '#birthday',
			max: -5113,
			value: '1990-01-01'
		});
		'<?php } else { ?>'
		laydate.render({
			elem: '#birthday',
			max: -5113
		});
		'<?php }?>'

		$("input[name='type']").each(function() {
			$(this).next().click(function() {
				var val = $(this).prev().val();
				if(val) {
					$("#typeid").val(val);
				}

			});

		});
	
		form.on('checkbox(stopdate)', function(data) {
			var random = data.elem.dataset.random;
			if(data.elem.checked) {
 				$('#workedate'+random).attr('disabled', 'disabled');
 				var date = new Date();
 				var y = date.getFullYear();
 				var m = date.getMonth()+1;
 				var time = y+"-"+m;
				$('#workedate'+random).val(time);
				$('#workedate'+random+'un').removeAttr('disabled');
				$('#totoday'+random).val(1);
			} else {
				$('#workedate'+random).val('');
				$('#workedate'+random).removeAttr('disabled');
				$('#workedate'+random+'un').attr('disabled', 'disabled');
				$('#totoday'+random).val(0);
			}
			showblurmsg('worksdate'+random,1,'');
			showblurmsg('workedate'+random,1,'');
			form.render('checkbox');

		});
		form.on('radio', function(data) {

			msg = '';
			showblurmsg('typeid', "1", msg);

		});
		form.on('select', function(data) {

			var selid = data.elem.id;
			checkonblur(selid,'rand');

		});
		form.on('radio(iscreateedu)', function(data) {
			if(data.value==1){
				$('#addedu').show();
			}else{
				$('#addedu').hide();
			}
		});
		form.on('radio(iscreateexp)', function(data) {
			if(data.value==1){
				$('#addwork').show();
			}else{
				$('#addwork').hide();
			}
		});
		form.on('radio(iscreatepro)', function(data) {
			if(data.value==1){
				$('#addproject').show();
			}else{
				$('#addproject').hide();
			}
		});
		formSelects.btns('jobclass_search', []);
		formSelects.btns('cityclass_search', []);
		//实时获取选中值
		formSelects.on('jobclass_search', function(id, vals, val, isAdd, isDisabled){
			var jobvalue = [];
            vals.forEach(function(item,index){
            	jobvalue.push(item.value);
            })
            $('#job_class').val(jobvalue.join(','));
            checkonblur('job_class');
        }, true);
        formSelects.on('cityclass_search', function(id, vals, val, isAdd, isDisabled){
			var cityvalue = [];
			var living	=	$('#living').val();
            vals.forEach(function(item,index){
            	cityvalue.push(item.value);
            	if(index==0 && living==''){
		    		$('#living').val(item.name);
		    		checkonblur('living');
		    	}
            })
            $('#city_class').val(cityvalue.join(','));
            checkonblur('city_class');
        }, true);
        //重设职位类别数据
	    '<?php if ($_smarty_tpl->tpl_vars['resume']->value['job_classid']) {?>'
	    jobSearchReset();
	    '<?php }?>'
	    //重设城市类别数据
	    '<?php if ($_smarty_tpl->tpl_vars['resume']->value['city_classid']) {?>'
	    citySearchReset();
	    '<?php }?>'
	    formSelects.maxTips('jobclass_search', function(id, vals, val, max){
		    layer.msg('最多只能选择5个！', 2, 8);
		});
		formSelects.maxTips('cityclass_search', function(id, vals, val, max){
		    layer.msg('最多只能选择5个！', 2, 8);
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
	    var living=$('#living').val();
	    for(var i=0;i<cityclassArr.length;i++){
	    	if(i==0 && living==''){
	    		$('#living').val(cn[cityclassArr[i]]);
	    		checkonblur('living');
	    	}
	    	carr.push({"name":cn[cityclassArr[i]],"value":cityclassArr[i],"selected":'selected'});
	    }
	    formSelects.data('cityclass_search', 'local', {
	        arr: carr
	    });

	}
	var userstyle = '<?php echo $_smarty_tpl->tpl_vars['user_style']->value;?>
';

	function checkback(type,nexttype){
		window.scrollTo(0,0);
		$(".news_expect_content").hide();
		$("#"+type).show();
		$("#"+nexttype+"type").removeAttr('class','fill_add_color');
	}
	
	function checknext(type){
		var resume_exp = $('#resume_exp').val();//工作经历
		var resume_edu = $('#resume_edu').val();//教育经历
		var resume_pro = $('#resume_pro').val();//项目经历
		var educreate='<?php echo $_smarty_tpl->tpl_vars['config']->value['educreate'];?>
';
		var expcreate='<?php echo $_smarty_tpl->tpl_vars['config']->value['expcreate'];?>
';
		var nexttype;
		var r_id='';
		var result = true;
		
		if(type=='expect'){
			window.scrollTo(0,0);
			if(resume_exp==1){
				nexttype='work';
				var expid = $('#expid').val();
				if(expcreate.indexOf(expid)>-1){
					$('#isexpshow').show();
				}else{
					$('#isexpshow').hide();
					$('#addwork').show();
					$("#iscreateexp1").attr("checked", true);
					layui.use([ 'form' ], function() {
						var form = layui.form;
						form.render();
					});
				}
			}else if(resume_edu==1){
				nexttype='edu';
				var educid = $('#educid').val();
				if(educreate.indexOf(educid)>-1){
					$('#isedushow').show();
				}else{
					$('#isedushow').hide();
					$('#addedu').show();
					$("#iscreateedu1").attr("checked", true);
					layui.use([ 'form' ], function() {
						var form = layui.form;
						form.render();
					});
				}
			}else if(resume_pro==1){
				nexttype='project';
				var expid = $('#expid').val();
				if(expcreate.indexOf(expid)>-1){
					$('#isproshow').show();
				}else{
					$('#isproshow').hide();
					$('#addproject').show();
					$("#iscreatepro1").attr("checked", true);
					layui.use([ 'form' ], function() {
						var form = layui.form;
						form.render();
					});
				}
			}
			var arrayObj = new Array('name', 'hyid', 'job_class', 'maxsalary', 'minsalary', 'city_class', 'typeid', 'reportid', 'statusid', 'uname', 'sex', 'birthday', 'educid', 'expid', 'telphone', 'email', 'living');
			
			for(i = 0; i < arrayObj.length; i++) {
				checkonblur(arrayObj[i]);
			}
			for(i = 0; i < arrayObj.length; i++) {
				if(exitsdate(arrayObj[i]) == false) {
					return false;
				}
			}
			
			$("#"+type).hide();
			$("#"+nexttype).show();
			$("#"+nexttype+"type").attr('class','fill_add_color');
		}else if(type=='work'){
			window.scrollTo(0,0);
			if(resume_edu==1){
				nexttype='edu';
				var educid = $('#educid').val();
				if(educreate.indexOf(educid)>-1){
					$('#isedushow').show();
				}else{
					$('#isedushow').hide();
					$('#addedu').show();
					$("#iscreateedu1").attr("checked", true);
					layui.use([ 'form' ], function() {
						var form = layui.form;
						form.render();
					});
				}
			}else if(resume_pro==1){
				nexttype='project';
				var expid = $('#expid').val();
				if(expcreate.indexOf(expid)>-1){
					$('#isproshow').show();
				}else{
					$('#isproshow').hide();
					$('#addproject').show();
					$("#iscreatepro1").attr("checked", true);
					layui.use([ 'form' ], function() {
						var form = layui.form;
						form.render();
					});
				}
			}
			if($('input[name=iscreateexp]:checked').val()!='2'){
			var arrayObj = new Array('workname', 'worktitle', 'worksdate', 'workedate');
			
			for(i = 0; i < arrayObj.length; i++) {
				checkonblur(arrayObj[i]);
			}
			
			for(i = 0; i < arrayObj.length; i++) {
				$("[id^='"+arrayObj[i]+"']").each(function(){
					r_id = $(this).attr('id');
					if(exitsdate(r_id) == false){
						result = false;
						return false;
					}
				});
				
			}

			if(result == false){
				return false;
			}
			}

			$("#"+type).hide();
			$("#"+nexttype).show();
			$("#"+nexttype+"type").attr('class','fill_add_color');
		}else if(type=='edu'){
			window.scrollTo(0,0);
			if(resume_pro==1){
				nexttype='project';
				var expid = $('#expid').val();
				if(expcreate.indexOf(expid)>-1){
					$('#isproshow').show();
				}else{
					$('#isproshow').hide();
					$('#addproject').show();
					$("#iscreatepro1").attr("checked", true);
					layui.use([ 'form' ], function() {
						var form = layui.form;
						form.render();
					});
				}
			}
			if($('input[name=iscreateedu]:checked').val()!='2'){
			var arrayObj = new Array('eduname', 'edusdate', 'eduedate', 'education');
			for(i = 0; i < arrayObj.length; i++) {
				checkonblur(arrayObj[i]);
			}
			for(i = 0; i < arrayObj.length; i++) {
				$("[id^='"+arrayObj[i]+"']").each(function(){
					r_id = $(this).attr('id');
					if(exitsdate(r_id) == false){
						result = false;
						return false;
					}
				});
				
			}
			if(result == false){
				return false;
			}
			}
			$("#"+type).hide();
			$("#"+nexttype).show();
			$("#"+nexttype+"type").attr('class','fill_add_color');
			
		}else if(type=='project'){
			window.scrollTo(0,0);
			var arrayObj = new Array('proname', 'protitle', 'prosdate', 'proedate');
			for(i = 0; i < arrayObj.length; i++) {
				checkonblur(arrayObj[i]);
			}
			for(i = 0; i < arrayObj.length; i++) {
				$("[id^='"+arrayObj[i]+"']").each(function(){
					r_id = $(this).attr('id');
					if(exitsdate(r_id) == false){
						result = false;
						return false;
					}
				});
				
			}
			if(result == false){
				return false;
			}
			$("#"+type).hide();
			$("#"+nexttype).show();
			$("#"+nexttype+"type").attr('class','fill_add_color');
		}
		
	}
	
	
	function checkexpect() {

		var resume_edu = $('#resume_edu').val();
		var resume_exp = $('#resume_exp').val();
		var resume_pro = $('#resume_pro').val();
		var result = true;
		var r_id = '';
		var arrayObj = new Array();
		var arrayObj = new Array('name', 'hyid', 'job_class', 'maxsalary', 'minsalary', 'city_class', 'typeid', 'reportid', 'statusid', 'uname', 'sex', 'birthday', 'educid', 'expid', 'telphone', 'email', 'living');
		if(resume_exp == '1'&&$('input[name=iscreateexp]:checked').val()!='2') {
			var arrayExp = new Array('workname', 'worktitle', 'worksdate', 'workedate');
			arrayObj = arrayObj.concat(arrayExp);
		}

		if(resume_edu == '1'&&$('input[name=iscreateedu]:checked').val()!='2') {
			var arrayEdu = new Array('eduname', 'edusdate', 'eduedate', 'education');
			arrayObj = arrayObj.concat(arrayEdu);
		}
		if(resume_pro == '1'&&$('input[name=iscreatepro]:checked').val()!='2') {
			var arrayPro = new Array('proname', 'protitle', 'prosdate', 'proedate');
			arrayObj = arrayObj.concat(arrayPro);
		}

		for(i = 0; i < arrayObj.length; i++) {

			checkonblur(arrayObj[i]);
		}

		for(i = 0; i < arrayObj.length; i++) {
			for(i = 0; i < arrayObj.length; i++) {
				$("[id^='"+arrayObj[i]+"']").each(function(){
					r_id = $(this).attr('id');
					if(exitsdate(r_id) == false){
						result = false;
						return false;
					}
				});
			}
			if(result == false){
				return false;
			}
			if(exitsdate(arrayObj[i]) == false) {

				return false;
			}
		}
		var loadi = layer.load('保存中，请稍候...', 0);
	}

	function checkonblur(id,type) {
		var obj = $.trim($("#" + id).val());
		var msg;

		if(id == "name") {
			var r_l = '<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_rname_num'];?>
';
			if(obj == "") {
				msg = '请填写期望职位！';
				showblurmsg(id, "0", msg);
			} else if(parseInt(obj.length) > parseInt(r_l) && parseInt(r_l) > 0){
				msg = '最多输入'+r_l+'个文字';
				showblurmsg(id, "0", msg);
			}else{
				msg = '';
				showblurmsg(id, "1", msg);
			}
		}
		if(id == "hyid") {
			if(obj == '') {
				msg = '请选择从事行业！';
				showblurmsg(id, "0", msg);
			} else {
				msg = '';
				showblurmsg(id, "1", msg);
			}
		}
		if(id == "job_class") {
			if(obj == "") {
				msg = '请选择期望职位！';
				showblurmsg(id, "0", msg);
			} else {
				msg = '';
				showblurmsg(id, "1", msg);
			}
		}
		if(id == "maxsalary") {
			var minsalary = parseInt($('#minsalary').val());
			if(parseInt(obj) > 0 && parseInt(obj) < minsalary) {
				msg = '最高薪资必须大于最低薪资！';
				showblurmsg('minsalary', "0", msg);
			} else {
				msg = '';
				showblurmsg('minsalary', "1", msg);
				$("#" + id).attr('date', '1');
			}
		}
		if(id == "minsalary") {
			var maxsalary = parseInt($('#maxsalary').val());
			if(obj == 0 || obj == "" || obj == "最低薪资") {
				msg = '请填写期望薪资！';
				showblurmsg(id, "0", msg);
			} else if(parseInt(obj) > maxsalary && maxsalary>0) {
				msg = '最高薪资必须大于最低薪资！';
				showblurmsg(id, "0", msg);
			} else {
				msg = '';
				showblurmsg(id, "1", msg);
			}
		}
		if(id == "city_class") {
			if(obj == "") {
				msg = '请选择工作地区！';
				showblurmsg(id, "0", msg);
			} else {
				msg = '';
				showblurmsg(id, "1", msg);
			}
		}
		if(id == "typeid") {
			if(obj == "") {
				msg = '请选择工作性质！';
				showblurmsg(id, "0", msg);
			} else {
				msg = '';
				showblurmsg(id, "1", msg);
			}
		}
		if(id == "reportid") {
			if(obj == "") {
				msg = '请选择到岗时间！';
				showblurmsg(id, "0", msg);
			} else {
				msg = '';
				showblurmsg(id, "1", msg);
			}
		}
		if(id == "statusid") {
			if(obj == "") {
				msg = '请选择求职状态！';
				showblurmsg(id, "0", msg);
			} else {
				msg = '';
				showblurmsg(id, "1", msg);
			}
		}
		if(id == "uname") {
			var uname = $('#uname').val();
			if(obj == "") {
				msg = '请输入真实姓名！';
				showblurmsg(id, "0", msg);
			} else {
				var resumename = '<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_resumename_num'];?>
';
				msg = '';
				if(resumename == '1' && !isChinaName(uname)){
					msg = '姓名请输入2-6位汉字';
					showblurmsg(id, "0", msg);
				} else {
					showblurmsg(id, "1", msg);
				}
			}
		}
		if(id == "sex") {
			if(obj == "") {
				msg = '请选择性别！';
				showblurmsg(id, "0", msg);
			} else {
				msg = '';
				showblurmsg(id, "1", msg);
			}
		}
		if(id == "birthday") {
			if(obj == "") {
				msg = '请选择出生年月！';
				showblurmsg(id, "0", msg);
			} else {
				msg = '';
				showblurmsg(id, "1", msg);
			}
		}
		if(id == "educid") {
			if(obj == "") {
				msg = '请选择最高学历！';
				showblurmsg(id, "0", msg);
			} else {
				msg = '';
				showblurmsg(id, "1", msg);
			}
		}
		if(id == "expid") {
			if(obj == "") {
				msg = '请选择工作经验！';
				showblurmsg(id, "0", msg);
			} else {
				msg = '';
				showblurmsg(id, "1", msg);
			}
		}
		if(id == "telphone") {
			if(obj == '') {
				msg = "请输入手机号码！";
				showblurmsg(id, "0", msg);
			} else if(!isjsMobile(obj)) {
				msg = "手机号码格式错误！";
				showblurmsg(id, "0", msg);
			} else {
				$.ajax({
					type: "POST",
					url: weburl + "/member/index.php?c=expect&act=regmoblie",
					data: {
						telphone: obj
					},
					dataType: "text",
					async: false,
					success: function(data) {
						if(data == 0) {
							msg = '';
							showblurmsg(id, "1", msg);
							return true;
							
						} else {
							msg = "号码已存在！";
							showblurmsg(id, "0", msg);
						}
					}
				});
			}
		}
		
		if(id == "email") {
			var myreg = /^([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9\-]+@([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
			if(obj != "") {

				if(!myreg.test(obj)) {
					msg = "邮箱格式错误！";
					showblurmsg(id, "0", msg);
				} else {
					$.ajax({
						type: "POST",
						url: weburl+"/member/index.php?c=expect&act=regemail",
						data: {
							email: obj
						},
						dataType: "text",
						async: false,
						success: function(data) {
							if(data == 0) {
								msg = '';
								showblurmsg(id, "1", msg);
							} else {
								msg = "邮箱已被使用！";
								showblurmsg(id, "0", msg);
							}
						}
					});

				}
			} else {
				msg = '';
				showblurmsg(id, "1", msg);

			}
		}
		
		if(id == "living") {
			if(obj == "") {
				msg = '请输入现居住地！';
				showblurmsg(id, "0", msg);
			} else {
				msg = '';
				showblurmsg(id, "1", msg);
			}
		}

		if(id=="workname" || id.indexOf("workname") != -1) {
			
			if(type=='rand'){

				if(obj == "") {
					msg = '请填写公司名称！';
					showblurmsg(id, "0", msg);
				} else {
					msg = '';
					showblurmsg(id, "1", msg);
				}
			}else{
				$("[id^='workname']").each(function(){
					obj = $(this).val();
					id = $(this).attr('id');
					if(obj == "") {
						msg = '请填写公司名称！';
						showblurmsg(id, "0", msg);
					} else {
						msg = '';
						showblurmsg(id, "1", msg);
					}
				});
			}
		}
		
		if(id=="worktitle" || id.indexOf("worktitle") != -1) {
			if(type=='rand'){

				if(obj == "") {
					msg = '请填写担任职位！';
					showblurmsg(id, "0", msg);
				} else {
					msg = '';
					showblurmsg(id, "1", msg);
				}
			}else{
				$("[id^='worktitle']").each(function(){
					obj = $(this).val();
					id = $(this).attr('id');
					if(obj == "") {
						msg = '请填写担任职位！';
						showblurmsg(id, "0", msg);
					} else {
						msg = '';
						showblurmsg(id, "1", msg);
					}
				});
			}
			
		}
		
		if(id=="worksdate" || id.indexOf("worksdate") != -1) {
			$("[id^='worksdate']").each(function(){
				obj = $(this).val();
				id = $(this).attr('id');
				eid=id.replace('worksdate','workedate');
				if(obj == "") {
					msg = '请填写工作时间！';
					showblurmsg(id, "0", msg);
				} else {
					var ed = toDate($("#"+eid).val());
					var st = toDate(obj);
					if(st > ed) {
						msg = '离职时间不合理';
						showblurmsg(id, "0", msg);
					} else{
						msg = '';
						showblurmsg(id, "1", msg);
					}
					
				}
			});
			
		}
		
		if(id=="workedate" || id.indexOf("workedate") != -1) {
			$("[id^='workedate']").each(function(){
				obj = $(this).val();
				id = $(this).attr('id');
				wid=id.replace('workedate','worksdate');
				if(obj == "") {
					msg = '请填写离职时间！';
					showblurmsg(wid, "0", msg);
				}
			});
			
		}

		if(id=="eduname" || id.indexOf("eduname") != -1) {
			if(type=='rand'){

				if(obj == "") {
					msg = '请填写学校名称！';
					showblurmsg(id, "0", msg);
				} else {
					msg = '';
					showblurmsg(id, "1", msg);
				}
			}else{
				$("[id^='eduname']").each(function(){
					obj = $(this).val();
					id = $(this).attr('id');
					if(obj == "") {
						msg = '请填写学校名称！';
						showblurmsg(id, "0", msg);
					} else {
						msg = '';
						showblurmsg(id, "1", msg);
					}
				});
			}
			
			
		}
	
		if(id=="edusdate") {
			$("[id^='edusdate']").each(function(){
				obj = $(this).val();
				id = $(this).attr('id');
				if(obj == "") {
					msg = '请填写在校时间！';
					showblurmsg(id, "0", msg);
				} else {
					msg = '';
					showblurmsg(id, "1", msg);
				}
			});
			
		}

		if(id=="eduedate") {
			var sid='';
			$("[id^='eduedate']").each(function(){
				obj = $(this).val();
				id = $(this).attr('id');
				sid=id.replace('eduedate','edusdate');
				if(obj == "") {
					msg = '请填写离校或预计离校时间！';
					showblurmsg(sid, "0", msg);
					showblurmsg(id, "0", msg);
				} else {
					
					var st = toDate($("#"+sid).val());
					var ed = toDate(obj);
					if(st > ed) {
						msg = '离校时间不合理';
						showblurmsg(sid, "0", msg);
						showblurmsg(id, "0", msg);
					} else {
						msg = '';
						showblurmsg(sid, "1", msg);
						showblurmsg(id, "1", msg);
					}
				}
			});
			
		}

		if(id=="education" || id.indexOf("education") != -1) {
			if(type=='rand'){

				if(obj == "") {
					msg = '请选择相关学历！';
					showblurmsg(id, "0", msg);
				} else {
					msg = '';
					showblurmsg(id, "1", msg);
				}
			}else{
				$("[id^='education']").each(function(){
					obj = $(this).val();
					id = $(this).attr('id');
					if(obj == "") {
						msg = '请选择相关学历！';
						showblurmsg(id, "0", msg);
					} else {
						msg = '';
						showblurmsg(id, "1", msg);
					}
				});
			}
			
		}
		
		
		
		if(id=="proname" || id.indexOf("proname") != -1) {
			if(type=='rand'){

				if(obj == "") {
					msg = '请填写项目名称！';
					showblurmsg(id, "0", msg);
				} else {
					msg = '';
					showblurmsg(id, "1", msg);
				}
			}else{
				$("[id^='proname']").each(function(){
					obj = $(this).val();
					id = $(this).attr('id');
					if(obj == "") {
						msg = '请填写项目名称！';
						showblurmsg(id, "0", msg);
					} else {
						msg = '';
						showblurmsg(id, "1", msg);
					}
				});
			}
			
			
		}
		
		if(id=="protitle" || id.indexOf("protitle") != -1) {
			if(type=='rand'){

				if(obj == "") {
					msg = '请填写项目职位！';
					showblurmsg(id, "0", msg);
				} else {
					msg = '';
					showblurmsg(id, "1", msg);
				}
			}else{
				$("[id^='protitle']").each(function(){
					obj = $(this).val();
					id = $(this).attr('id');
					if(obj == "") {
						msg = '请填写项目职位！';
						showblurmsg(id, "0", msg);
					} else {
						msg = '';
						showblurmsg(id, "1", msg);
					}
				});
			}
			
			
		}
		
		if(id=="prosdate") {
			$("[id^='prosdate']").each(function(){
				obj = $(this).val();
				id = $(this).attr('id');
				if(obj == "") {
					msg = '请选择项目时间！';
					showblurmsg(id, "0", msg);
				} else {
					msg = '';
					showblurmsg(id, "1", msg);
				}
			});
			
		}
		
		if(id=="proedate") {
			var sid='';
			$("[id^='proedate']").each(function(){
				obj = $(this).val();
				id = $(this).attr('id');
				sid=id.replace('proedate','prosdate');
				if(obj == "") {
					msg = '请选择项目结束时间！';
					showblurmsg(sid, "0", msg);
					showblurmsg(id, "0", msg);
				} else {
					var st = toDate($('#'+sid).val());
					var ed = toDate(obj);

					if(st > ed) {

						msg = '项目结束时间不合理';
						showblurmsg(sid, "0", msg);
						showblurmsg(id, "0", msg);
					} else {
						msg = '';
						showblurmsg(sid, "1", msg);
						showblurmsg(id, "1", msg);
					}

				}
			});
			
		}
		

	}

	function toDate(str) {
		var sd = str.split("-");
		return new Date(sd[0], sd[1]);
	}

	function showblurmsg(id, type, msg) {
		$("#hid_" + id).show();
		$("#hid" + id).html(msg);
		if(type == "0") {
			$("#hid" + id).attr("class", "");
			$("#" + id).removeClass("resume_tipfalse");
			$("#" + id).attr('date', '0');
			return false;
		} else {
			$("#hid" + id).attr("class", "resume_tipok");
			$("#" + id).addClass("resume_tipfalse");
			$("#" + id).attr('date', '1');
		}
	}

	function exitsdate(id) {
		if(document.getElementById(id)) {
			if($('#' + id).attr('date') != '1') {
				return false;
			} else {
				return true;
			}
		} else {
			return true;
		}
	}

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
	
	function checksex(id) {
		$(".news_expect_sex").removeClass('news_expect_sex_cur');
		$("#"+id+'sex').addClass('news_expect_sex_cur');
		$("#sex").val(id);
		checkonblur('sex');
	}
	function expectmessage(frame_id){ 
		if(frame_id==''||frame_id==undefined){
			frame_id='supportiframe';
		}
		var url=$(window.frames[frame_id].document).find("#layer_url").val();
		if(url){
			window.event.returnValue = false;
			window.location.href = url;return false;
		}
	}
	
	
<?php echo '</script'; ?>
>

<iframe id="expectiframe" name="expectiframe" onload="expectmessage('expectiframe');" style="display:none"></iframe>
<?php if ($_smarty_tpl->tpl_vars['isremind']->value==1) {?>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['temstyle']->value)."/member/public/remind.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['userstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
