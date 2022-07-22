<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 17:31:06
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_tongji_resume.htm" */ ?>
<?php /*%%SmartyHeaderCode:1681262d91cda7e46a8-09019770%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e549882bf8e99109360c40ff2dcdd5f25c061d04' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_tongji_resume.htm',
      1 => 1636510354,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1681262d91cda7e46a8-09019770',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'AllNum' => 0,
    'name' => 0,
    'list' => 0,
    'daylist' => 0,
    'lists' => 0,
    'counttj' => 0,
    'job1list' => 0,
    'citylist' => 0,
    'edulist' => 0,
    'salarylist' => 0,
    'explist' => 0,
    'sexlist' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d91cda9275f6_27261128',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d91cda9275f6_27261128')) {function content_62d91cda9275f6_27261128($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
<?php echo '<script'; ?>
 src="js/echarts_plain.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
<title>后台管理</title>
</head>
<body class="body_ifm">

<div class="infoboxp">
    <?php echo $_smarty_tpl->getSubTemplate ("admin/admin_tongji_top.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <div class="clear"></div>
	<div class="admin_tj_show">
        <div class="admin_statistics">
            <span class="tty_sjtj_color">数据统计：</span>
            <em class="admin_statistics_s">发布简历数据：
                <span class="ajaxall"><?php echo $_smarty_tpl->tpl_vars['AllNum']->value['all'];?>
</span>
            </em>
        </div>
        <div class="admin_tongji_box">
            <div class="admin_atatic_chart" id="main2" style="width:100%;height:300px;"></div>
            <div class="clear"></div>
            <div class="admin_udbox_table_bor">
                <div class="admin_udbox_table_box">
                <div class="admin_udbox_right_fx">简历数据分析：</div>
                    <table cellpadding="0" cellspacing="0" width="100%" class="admin_udbox_table">
                        <tr>
                            <td> 
                            <div class="admin_atatic_chart" id="hytj" style="width:500px;height:300px; margin:0 auto"></div></td>
                            <td class="admin_atatic_chart_tdbor">
                            <div class="admin_atatic_chart" id="citytj" style="width:500px;height:300px; margin:0 auto"></div></td>
                        </tr>
                        <tr>
                            <td>	 
                            <div class="admin_atatic_chart" id="salarytj" style="width:500px;height:300px; margin:0 auto"></div></td>
                            <td class="admin_atatic_chart_tdbor"> 
                            <div class="admin_atatic_chart" id="edutj" style="width:500px;height:300px; margin:0 auto"></div></td>
                        </tr>
                        <tr>
                            <td>	 
                            <div class="admin_atatic_chart" id="exptj" style="width:500px;height:300px; margin:0 auto"></div></td>
                            <td class="admin_atatic_chart_tdbor">
                            <div class="admin_atatic_chart" id="sextj" style="width:500px;height:300px; margin:0 auto"></div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div> 
</div> 
<?php echo '<script'; ?>
 type="text/javascript">
        // 基于准备好的dom，初始化echarts图表
        var myChart = echarts.init(document.getElementById('main2'));
		option = null;
       option = {
    title: {
        text: '<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
'
    },
    tooltip : {
        trigger: 'axis'
    },
    legend: {
        data:[<?php  $_smarty_tpl->tpl_vars['daylist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['daylist']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['daylist']->key => $_smarty_tpl->tpl_vars['daylist']->value) {
$_smarty_tpl->tpl_vars['daylist']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo']['index']++;
if ($_smarty_tpl->getVariable('smarty')->value['foreach']['foo']['index']>0) {?>,<?php }?>'<?php echo $_smarty_tpl->tpl_vars['daylist']->value['date'];?>
'<?php } ?>]
    },
    grid: {
        left: '3%',
        right: '4%',
        bottom: '3%',
        containLabel: true
    },
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
            data : [
			<?php  $_smarty_tpl->tpl_vars['lists'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['lists']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo1']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['lists']->key => $_smarty_tpl->tpl_vars['lists']->value) {
$_smarty_tpl->tpl_vars['lists']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo1']['index']++;
?>
			<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['foo1']['index']<1) {?>
			<?php  $_smarty_tpl->tpl_vars['daylist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['daylist']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['lists']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo2']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['daylist']->key => $_smarty_tpl->tpl_vars['daylist']->value) {
$_smarty_tpl->tpl_vars['daylist']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo2']['index']++;
if ($_smarty_tpl->getVariable('smarty')->value['foreach']['foo2']['index']>0) {?>,<?php }?>'<?php echo $_smarty_tpl->tpl_vars['daylist']->value['date'];?>
'<?php } ?>
			<?php }?>
			<?php } ?>
			
			]
        }
    ],
    yAxis : [
        {
            type : 'value'
        }
    ],
    series : [
        <?php  $_smarty_tpl->tpl_vars['lists'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['lists']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo1']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['lists']->key => $_smarty_tpl->tpl_vars['lists']->value) {
$_smarty_tpl->tpl_vars['lists']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo1']['index']++;
?>
		
		<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['foo1']['index']>0) {?>,<?php }?>{
            name:'<?php echo $_smarty_tpl->tpl_vars['lists']->value['name'];?>
',
            type:'line',
            areaStyle: {normal: {}},
            data:[<?php  $_smarty_tpl->tpl_vars['daylist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['daylist']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['lists']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo2']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['daylist']->key => $_smarty_tpl->tpl_vars['daylist']->value) {
$_smarty_tpl->tpl_vars['daylist']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo2']['index']++;
if ($_smarty_tpl->getVariable('smarty')->value['foreach']['foo2']['index']>0) {?>,<?php }
echo $_smarty_tpl->tpl_vars['daylist']->value['count'];
} ?>]
        }
		<?php } ?>
    ]
};
        myChart.setOption(option); // 为echarts对象加载数据 

		//招聘需求行业统计
		var myChartHy = echarts.init(document.getElementById('hytj'));
		optionhy = null;
		optionhy = {
    title : {
        text: '求职热门行业',
        subtext: '',
        x:'center'
    },
    tooltip : {
        trigger: 'item',
        formatter: "{a} <br/>{b} : {c} ({d}%)"
    },
    legend: {
        orient: 'vertical',
        left: 'left',
		top:'20%',
        data: [<?php  $_smarty_tpl->tpl_vars['job1list'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['job1list']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['counttj']->value['job1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['job1list']->key => $_smarty_tpl->tpl_vars['job1list']->value) {
$_smarty_tpl->tpl_vars['job1list']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo']['index']++;
if ($_smarty_tpl->getVariable('smarty')->value['foreach']['foo']['index']>0) {?>,<?php }?>'<?php echo $_smarty_tpl->tpl_vars['job1list']->value['name'];?>
'<?php } ?>]
    },
    series : [
        {
            name: '占比分析',
            type: 'pie',
            radius : '55%',
            center: ['70%', '60%'],
            data:[
			<?php  $_smarty_tpl->tpl_vars['job1list'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['job1list']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['counttj']->value['job1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['job1list']->key => $_smarty_tpl->tpl_vars['job1list']->value) {
$_smarty_tpl->tpl_vars['job1list']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo']['index']++;
?>

			<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['foo']['index']>0) {?>,<?php }?>
			{value:'<?php echo $_smarty_tpl->tpl_vars['job1list']->value['count'];?>
', name:'<?php echo $_smarty_tpl->tpl_vars['job1list']->value['name'];?>
'}
			
			
			
			<?php } ?>
            ],
            itemStyle: {
                emphasis: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                }
            }
        }
    ]
};
 myChartHy.setOption(optionhy); // 为echarts对象加载数据 

 //招聘需求区域统计
		var myChartCity = echarts.init(document.getElementById('citytj'));
		optioncity = null;
		optioncity = {
    title : {
        text: '求职热门区域',
        subtext: '',
        x:'center'
    },
    tooltip : {
        trigger: 'item',
        formatter: "{a} <br/>{b} : {c} ({d}%)"
    },
    legend: {
        orient: 'vertical',
        left: 'left',
		top:'20%',
        data: [<?php  $_smarty_tpl->tpl_vars['citylist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['citylist']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['counttj']->value['provinceid']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['citylist']->key => $_smarty_tpl->tpl_vars['citylist']->value) {
$_smarty_tpl->tpl_vars['citylist']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo']['index']++;
if ($_smarty_tpl->getVariable('smarty')->value['foreach']['foo']['index']>0) {?>,<?php }?>'<?php echo $_smarty_tpl->tpl_vars['citylist']->value['name'];?>
'<?php } ?>]
    },
    series : [
        {
            name: '占比分析',
            type: 'pie',
            radius : '55%',
            center: ['60%', '60%'],
            data:[
			<?php  $_smarty_tpl->tpl_vars['citylist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['citylist']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['counttj']->value['provinceid']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['citylist']->key => $_smarty_tpl->tpl_vars['citylist']->value) {
$_smarty_tpl->tpl_vars['citylist']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo']['index']++;
?>

			<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['foo']['index']>0) {?>,<?php }?>
			{value:'<?php echo $_smarty_tpl->tpl_vars['citylist']->value['count'];?>
', name:'<?php echo $_smarty_tpl->tpl_vars['citylist']->value['name'];?>
'}
			
			
			
			<?php } ?>
            ],
            itemStyle: {
                emphasis: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                }
            }
        }
    ]
};
 myChartCity.setOption(optioncity); // 为echarts对象加载数据 

 //招聘需求学历统计
		var myChartEdu = echarts.init(document.getElementById('edutj'));
		optionedu = null;
		optionedu = {
    title : {
        text: '求职学历区间',
        subtext: '',
        x:'center'
    },
    tooltip : {
        trigger: 'item',
        formatter: "{a} <br/>{b} : {c} ({d}%)"
    },
    legend: {
        orient: 'vertical',
        left: 'left',
		top:'20%',
        data: [<?php  $_smarty_tpl->tpl_vars['edulist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['edulist']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['counttj']->value['edu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['edulist']->key => $_smarty_tpl->tpl_vars['edulist']->value) {
$_smarty_tpl->tpl_vars['edulist']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo']['index']++;
if ($_smarty_tpl->getVariable('smarty')->value['foreach']['foo']['index']>0) {?>,<?php }?>'<?php echo $_smarty_tpl->tpl_vars['edulist']->value['name'];?>
'<?php } ?>]
    },
    series : [
        {
            name: '占比分析',
            type: 'pie',
            radius : '55%',
            center: ['60%', '60%'],
            data:[
			<?php  $_smarty_tpl->tpl_vars['edulist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['edulist']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['counttj']->value['edu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['edulist']->key => $_smarty_tpl->tpl_vars['edulist']->value) {
$_smarty_tpl->tpl_vars['edulist']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo']['index']++;
?>

			<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['foo']['index']>0) {?>,<?php }?>
			{value:'<?php echo $_smarty_tpl->tpl_vars['edulist']->value['count'];?>
', name:'<?php echo $_smarty_tpl->tpl_vars['edulist']->value['name'];?>
'}
			
			
			
			<?php } ?>
            ],
            itemStyle: {
                emphasis: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                }
            }
        }
    ]
};
 myChartEdu.setOption(optionedu); // 为echarts对象加载数据 

//招聘需求薪资统计
		var myChartSalary = echarts.init(document.getElementById('salarytj'));
		optionsalary = null;
		optionsalary = {
    title : {
        text: '期望薪资统计',
        subtext: '',
        x:'center'
    },
    tooltip : {
        trigger: 'item',
        formatter: "{a} <br/>{b} : {c} ({d}%)"
    },
    legend: {
        orient: 'vertical',
        left: 'left',
		top:'20%',
        data: [<?php  $_smarty_tpl->tpl_vars['salarylist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['salarylist']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['counttj']->value['salary']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['salarylist']->key => $_smarty_tpl->tpl_vars['salarylist']->value) {
$_smarty_tpl->tpl_vars['salarylist']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo']['index']++;
if ($_smarty_tpl->getVariable('smarty')->value['foreach']['foo']['index']>0) {?>,<?php }?>'<?php echo $_smarty_tpl->tpl_vars['salarylist']->value['name'];?>
'<?php } ?>]
    },
    series : [
        {
            name: '占比分析',
            type: 'pie',
            radius : '55%',
            center: ['70%', '60%'],
            data:[
			<?php  $_smarty_tpl->tpl_vars['salarylist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['salarylist']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['counttj']->value['salary']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['salarylist']->key => $_smarty_tpl->tpl_vars['salarylist']->value) {
$_smarty_tpl->tpl_vars['salarylist']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo']['index']++;
?>

			<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['foo']['index']>0) {?>,<?php }?>
			{value:'<?php echo $_smarty_tpl->tpl_vars['salarylist']->value['count'];?>
', name:'<?php echo $_smarty_tpl->tpl_vars['salarylist']->value['name'];?>
'}
			
			
			
			<?php } ?>
            ],
            itemStyle: {
                emphasis: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                }
            }
        }
    ]
};
 myChartSalary.setOption(optionsalary); // 为echarts对象加载数据 



 //招聘需求工作经验统计
		var myChartExp = echarts.init(document.getElementById('exptj'));
		optionexp = null;
		optionexp = {
    title : {
        text: '求职工作经验',
        subtext: '',
        x:'center'
    },
    tooltip : {
        trigger: 'item',
        formatter: "{a} <br/>{b} : {c} ({d}%)"
    },
    legend: {
        orient: 'vertical',
        left: 'left',
		top: '20%',
        data: [<?php  $_smarty_tpl->tpl_vars['explist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['explist']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['counttj']->value['exp']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['explist']->key => $_smarty_tpl->tpl_vars['explist']->value) {
$_smarty_tpl->tpl_vars['explist']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo']['index']++;
if ($_smarty_tpl->getVariable('smarty')->value['foreach']['foo']['index']>0) {?>,<?php }?>'<?php echo $_smarty_tpl->tpl_vars['explist']->value['name'];?>
'<?php } ?>]
    },
    series : [
        {
            name: '占比分析',
            type: 'pie',
            radius : '55%',
            center: ['70%', '60%'],
            data:[
			<?php  $_smarty_tpl->tpl_vars['explist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['explist']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['counttj']->value['exp']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['explist']->key => $_smarty_tpl->tpl_vars['explist']->value) {
$_smarty_tpl->tpl_vars['explist']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo']['index']++;
?>

			<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['foo']['index']>0) {?>,<?php }?>
			{value:'<?php echo $_smarty_tpl->tpl_vars['explist']->value['count'];?>
', name:'<?php echo $_smarty_tpl->tpl_vars['explist']->value['name'];?>
'}
			
			
			
			<?php } ?>
            ],
            itemStyle: {
                emphasis: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                }
            }
        }
    ]
};
 myChartExp.setOption(optionexp); // 为echarts对象加载数据 

 //招聘需求工作经验统计
		var myChartSex = echarts.init(document.getElementById('sextj'));
		optionsex = null;
		optionsex = {
    title : {
        text: '男女比例',
        subtext: '',
        x:'center'
    },
    tooltip : {
        trigger: 'item',
        formatter: "{a} <br/>{b} : {c} ({d}%)"
    },
    legend: {
        orient: 'vertical',
        left: 'left',
		top: '20%',
        data: [<?php  $_smarty_tpl->tpl_vars['sexlist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['sexlist']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['counttj']->value['sex']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['sexlist']->key => $_smarty_tpl->tpl_vars['sexlist']->value) {
$_smarty_tpl->tpl_vars['sexlist']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo']['index']++;
if ($_smarty_tpl->getVariable('smarty')->value['foreach']['foo']['index']>0) {?>,<?php }?>'<?php echo $_smarty_tpl->tpl_vars['sexlist']->value['name'];?>
'<?php } ?>]
    },
    series : [
        {
            name: '占比分析',
            type: 'pie',
            radius : '55%',
            center: ['60%', '60%'],
            data:[
			<?php  $_smarty_tpl->tpl_vars['sexlist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['sexlist']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['counttj']->value['sex']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['sexlist']->key => $_smarty_tpl->tpl_vars['sexlist']->value) {
$_smarty_tpl->tpl_vars['sexlist']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo']['index']++;
?>

			<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['foo']['index']>0) {?>,<?php }?>
			{value:'<?php echo $_smarty_tpl->tpl_vars['sexlist']->value['count'];?>
', name:'<?php echo $_smarty_tpl->tpl_vars['sexlist']->value['name'];?>
'}
			
			
			
			<?php } ?>
            ],
            itemStyle: {
                emphasis: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                }
            }
        }
    ]
};
 myChartSex.setOption(optionsex); // 为echarts对象加载数据 
    <?php echo '</script'; ?>
>
</body>
</html><?php }} ?>
