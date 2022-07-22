<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-06 17:13:25
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\default\job\search.htm" */ ?>
<?php /*%%SmartyHeaderCode:2353462c552357b6cf0-30467621%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '395eff9667bb351eb4ec34b4400e06e4c5d8a412' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\default\\job\\search.htm',
      1 => 1640333832,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2353462c552357b6cf0-30467621',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'keywords' => 0,
    'description' => 0,
    'style' => 0,
    'config' => 0,
    'lunbo' => 0,
    'finder' => 0,
    'key' => 0,
    'v' => 0,
    'uid' => 0,
    'usertype' => 0,
    'paras' => 0,
    'jobkeyword' => 0,
    'keylist' => 0,
    'job_index' => 0,
    'job_name' => 0,
    'job_type' => 0,
    'city_name' => 0,
    'city_type' => 0,
    'tid' => 0,
    'city_index' => 0,
    'pid' => 0,
    'cid' => 0,
    'comdata' => 0,
    'comclass_name' => 0,
    'com_sex' => 0,
    'j' => 0,
    'industry_name' => 0,
    'industry_index' => 0,
    'uptime' => 0,
    'member' => 0,
    'wxtz_tips' => 0,
    'zd_list' => 0,
    'useridjob' => 0,
    'waflist' => 0,
    'lookJobIds' => 0,
    'job_list' => 0,
    'favjob' => 0,
    'total' => 0,
    'pagenav' => 0,
    'totalshow' => 0,
    'adlist_7' => 0,
    'recNum' => 0,
    'blist' => 0,
    'hotjoblist' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c55235bebcd3_03270160',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c55235bebcd3_03270160')) {function content_62c55235bebcd3_03270160($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.url.php';
if (!is_callable('smarty_function_listurl')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.listurl.php';
if (!is_callable('smarty_function_formatpicurl')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.formatpicurl.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
	<meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
" />
	<meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['description']->value;?>
" />
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/style/job.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/css" />
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/style/css.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/css" />
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/style/class.public.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/css" />
</head>

<body class="body_bg">
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	<div class="yun_jobbody">
		<div class="yun_content">
			<div class="current_Location com_current_Location png none">
				<div class="fl">您当前的位置： <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
">首页</a> > <span>找工作</span> </div>
			</div>
			
			<div class="clear"></div>
			<!-- 广告位放这-->
			<?php  $_smarty_tpl->tpl_vars["lunbo"] = new Smarty_Variable; $_smarty_tpl->tpl_vars["lunbo"]->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
global $db,$db_config,$config;$AdArr=array();$paramer=array();$attr=array("classid"=>"507","item"=>"\"lunbo\"","key"=>"'key'","random"=>"1","nocache"=>"")
;
			include(PLUS_PATH.'pimg_cache.php');$add_arr = $ad_label[507];if(is_array($add_arr) && !empty($add_arr)){
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
			<div class="yun_jobbanner"><?php echo $_smarty_tpl->tpl_vars['lunbo']->value['html'];?>
</div>
			<?php } ?>
			<!-- 广告位放这 end-->
			<div class="clear"></div>
			<form action="<?php if (!$_smarty_tpl->tpl_vars['config']->value['sy_jobdir']) {?>index.php<?php } else {
echo smarty_function_url(array('m'=>'job'),$_smarty_tpl);
}?>" method="get" id="form" onsubmit="return search_keyword(this,'请输入职位名称或公司，例如：销售');">
				<div class="jobsearch_newbox">
					
					<?php if (!$_smarty_tpl->tpl_vars['config']->value['sy_jobdir']) {?>
					<input type="hidden" name="m" value="job" id="m" />
					<?php }?>
					<input type="hidden" name="c" value="search" />
					
					<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['finder']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
						<input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" />
					<?php } ?>

					<div class="yun_job_search">

						<div class="yun_job_search_cont">
							
							<div class="yun_job_search_textcont">
								<input type="text" name="keyword" value="<?php if ($_GET['keyword']) {
echo $_GET['keyword'];
}?>" placeholder="请输入职位名称或公司，例如：销售" class="Search_jobs_text " />
							</div>
							
							<input type="submit" value="搜索" class="Search_jobs_submit yun_bg_color" />
<!--
							<div class="Search_jobs_sub_text_bc"> 
								<?php if ($_smarty_tpl->tpl_vars['uid']->value&&$_smarty_tpl->tpl_vars['usertype']->value=='1') {?> 
									<a href="javascript:void(0)" class="Search_jobs_scq" onclick="addfinder('<?php echo $_smarty_tpl->tpl_vars['paras']->value;?>
','1','0')">+ 保存为职位搜索器</a> 
								<?php } elseif ($_smarty_tpl->tpl_vars['uid']->value&&$_smarty_tpl->tpl_vars['usertype']->value!='1') {?> 
									<a href="javascript:void(0)" class="Search_jobs_scq" onclick="layer.msg('只有个人会员才可保存！', 2,8);return false;">+ 保存为职位搜索器</a> 
								<?php } else { ?> 
									<a href="javascript:void(0)" class="Search_jobs_scq" onclick="showlogin('1');">+ 保存为职位搜索器</a> 
								<?php }?> 
							</div>-->
						</div>

						<?php if ($_smarty_tpl->tpl_vars['jobkeyword']->value) {?>
							<div class="jobs_tag"> 热门搜索：
								<?php  $_smarty_tpl->tpl_vars['keylist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['keylist']->_loop = false;
global $config;$paramer=array("limit"=>"12","recom"=>"1","type"=>"3","item"=>"'keylist'","nocache"=>"")
;$list=array();
        
        $ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
		//是否推荐
		if($paramer[recom]){
			$tuijian = 1;
		}
		//类别
		if($paramer[type]){
			$type = $paramer[type];
		}
		//查询条数
		if($paramer[limit]){
			$limit=$paramer[limit];
		}else{
			$limit=5;
		}
		include PLUS_PATH."/keyword.cache.php";
		if($paramer[iswap]){
			$wap = "/wap";
		}else{
			$index =1;
		}
		if(is_array($keyword)){
			if($paramer[iswap]){
				$i=0;
				foreach($keyword as $k=>$v){
					if($tuijian && $v[tuijian]!=1){
						continue;
					}
					if($type && $v[type]!=$type){
						continue;
					}

					$i++;
					if($v[type]=="1"){
						$v[url] = Url("wap",array("c"=>"once","keyword"=>$v['key_name']));
						$v[type_name]='店铺招聘';
					}elseif($v['type']=="13"){
						$v['url'] = Url("wap",array("c"=>"tiny","keyword"=>$v['key_name']));
						$v['type_name']='普工简历';
					}elseif($v[type]=="3"){
						$v[url] = Url("wap",array("c"=>"job","keyword"=>$v['key_name']));
						$v[type_name]='职位';
					}elseif($v['type']=="4"){
						$v['url'] = Url("wap",array("c"=>"company","keyword"=>$v['key_name']));
						$v['type_name']='公司';
					}elseif($v['type']=="5"){
						$v['url'] = Url("wap",array("c"=>"resume","keyword"=>$v['key_name']));
						$v['type_name']='人才';
					}
					$v['key_title']=$v['key_name'];
					if($v['color']){
						$v['key_name']="<font color='".$v['color']."'>".$v['key_name']."</font>";
					}
					$list[] = $v;
					if($i==$limit){
						break;
					}
				}
			}else{
				$i=0;
				foreach($keyword as $k=>$v){
					if($tuijian && $v['tuijian']!=1){
						continue;
					}
					if($type && $v['type']!=$type){
						continue;
					}
					$i++;
					if($v['type']=="1"){
						$v['url'] = Url("once",array("keyword"=>$v['key_name']));
						$v['type_name']='店铺招聘';
					}elseif($v['type']=="2"){
						$v['url'] = Url("part",array("keyword"=>$v['key_name']));
						$v['type_name']='兼职';
					}elseif($v['type']=="13"){
						$v['url'] = Url("tiny",array("keyword"=>$v['key_name']));
						$v['type_name']='普工简历';
					}elseif($v['type']=="3"){
						$v['url'] = Url("job",array("c"=>"search","keyword"=>$v['key_name']));
						$v['type_name']='职位';
					}elseif($v['type']=="4"){
						$v['url'] = Url("company",array("keyword"=>$v['key_name']));
						$v['type_name']='公司';
					}elseif($v['type']=="5"){
						$v['url'] = Url("resume",array("c"=>"search","keyword"=>$v['key_name']));
						$v['type_name']='人才';
					}elseif($v['type']=="6"){
						$v['url'] = Url("lietou",array("c"=>"service","keyword"=>$v['key_name']));
						$v['type_name']='猎头';
					}elseif($v['type']=="7"){
						$v['url'] = Url("lietou",array("c"=>"post","keyword"=>$v['key_name']));
						$v['type_name']='猎头职位';
					}else if($v['type']=="9"){
						$v['url'] = Url("train",array("c"=>"subject","keyword"=>$v['key_name']));
						$v['type_name']='培训课程';
					}else if($v['type']=="10"){
						$v['url'] = Url("train",array("c"=>"agency","keyword"=>$v['key_name']));
						$v['type_name']='培训机构';
					}else if($v['type']=="11"){
						$v['url'] = Url("train",array("c"=>"teacher","keyword"=>$v['key_name']));
						$v['type_name']='培训师';
					}else if($v['type']=="12"){
						$v['url'] = Url("ask",array("c"=>"search","keyword"=>$v['key_name']));
						$v['type_name']='问答';
					}
					$v['key_title']=$v['key_name'];
					if($v['color']){
						$v['key_name']="<font color='".$v['color']."'>".$v['key_name']."</font>";
					}

					$list[] = $v;
					if($i==$limit){
						break;
					}
				}
			}
		}$list = $list; if (!is_array($list) && !is_object($list)) { settype($list, 'array');}
foreach ($list as $_smarty_tpl->tpl_vars['keylist']->key => $_smarty_tpl->tpl_vars['keylist']->value) {
$_smarty_tpl->tpl_vars['keylist']->_loop = true;
?> 
									<a href="<?php echo smarty_function_listurl(array('type'=>'keyword','v'=>$_smarty_tpl->tpl_vars['keylist']->value['key_title']),$_smarty_tpl);?>
" class="jos_tag_a" title="<?php echo $_smarty_tpl->tpl_vars['keylist']->value['key_title'];?>
"><?php echo $_smarty_tpl->tpl_vars['keylist']->value['key_name'];?>
</a> 
								<?php } ?> 
							</div>
						<?php }?> 
					</div>
				</div>

				<div class="clear"></div>

				<div class="Search_jobs_box"> 
					
					<?php if (!$_GET['job1']) {?>
						<div class="Search_jobs_form_list">
							<div class="Search_jobs_name"> 职位：</div>
							<div class="Search_jobs_sub ">
								<div class="Search_jobs_sub_Box "> 
									<a href="<?php echo smarty_function_listurl(array('type'=>'job1','v'=>0),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['job1']=='') {?>Search_jobs_sub_cur<?php }?>">全部</a> 
									<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['job_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?> 
										<a href="<?php echo smarty_function_listurl(array('type'=>'job1','v'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['job1']==$_smarty_tpl->tpl_vars['v']->value) {?>Search_jobs_sub_cur<?php } elseif ($_smarty_tpl->tpl_vars['key']->value>6) {?>job1list none<?php }?>"><?php echo $_smarty_tpl->tpl_vars['job_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> 
									<?php } ?> 
								</div>
							</div>
							<div class="zh_more"> <a href="javascript:checkmore('job1list');" id="job1list" rel="nofollow">更多</a> </div>
						</div>
					<?php }?> 
        
					<?php if ($_GET['job1']&&!$_GET['job1_son']) {?>
						<div class="Search_jobs_form_list">
							<div class="Search_jobs_name"> 子类：</div>
							<div class="Search_jobs_sub "> 
								<a href="<?php echo smarty_function_listurl(array('type'=>'job1_son'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['job1_son']=='') {?>Search_jobs_sub_cur<?php }?>">全部</a> 
								<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['job_type']->value[$_GET['job1']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?> 
									<a href="<?php echo smarty_function_listurl(array('type'=>'job1_son','v'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['job1_son']==$_smarty_tpl->tpl_vars['v']->value) {?>Search_jobs_sub_cur<?php }?>"><?php echo $_smarty_tpl->tpl_vars['job_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> 
								<?php } ?> 
							</div>
						</div>
					<?php }?> 
        
					<?php if ($_GET['job1_son']&&is_array($_smarty_tpl->tpl_vars['job_type']->value[$_GET['job1_son']])) {?>
						<div class="Search_jobs_form_list">
							<div class="Search_jobs_name"> 类别：</div>
							<div class="Search_jobs_sub "> 
								<a href="<?php echo smarty_function_listurl(array('type'=>'job1_son','v'=>$_GET['job1_son']),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['job_post']=='') {?>Search_jobs_sub_cur<?php }?>">全部</a> 
								<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['job_type']->value[$_GET['job1_son']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?> 
									<a href="<?php echo smarty_function_listurl(array('type'=>'job_post','v'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['job_post']==$_smarty_tpl->tpl_vars['v']->value) {?>Search_jobs_sub_cur<?php }?>"><?php echo $_smarty_tpl->tpl_vars['job_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> 
								<?php } ?> 
							</div>
						</div>
					<?php }?> 

					<!-- city--> 
					<?php if ($_smarty_tpl->tpl_vars['config']->value['sy_web_site']==1&&$_smarty_tpl->tpl_vars['config']->value['cityname']&&$_smarty_tpl->tpl_vars['config']->value['cityname']!=$_smarty_tpl->tpl_vars['config']->value['sy_indexcity']&&$_GET['provinceid']) {?>
					<div class="Search_citybox">
						<div class="Search_cityboxname"> 地点：</div>
						<div class="Search_citybox_right">
							<div class="Search_cityboxright">
								<div class="search_city_list search_city_listw1100"> 
									<?php if (!$_GET['cityid']&&$_GET['three_cityid']) {?> 
										<a class="city_name city_name_active" style="text-decoration:none;cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['three_cityid']];?>
</a> 
									<?php } else { ?> 
										<?php if ($_GET['cityid']) {?> 
											<?php if (is_array($_smarty_tpl->tpl_vars['city_type']->value[$_GET['cityid']])) {?> 
												<a href="<?php echo smarty_function_listurl(array('untype'=>'three_cityid'),$_smarty_tpl);?>
" class="city_name <?php if (!$_GET['three_cityid']) {?>city_name_active<?php }?>">不限</a> 
											
												<?php  $_smarty_tpl->tpl_vars['tid'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tid']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_GET['cityid']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tid']->key => $_smarty_tpl->tpl_vars['tid']->value) {
$_smarty_tpl->tpl_vars['tid']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['tid']->key;
?> 
													<a href="<?php echo smarty_function_listurl(array('type'=>'three_cityid','v'=>$_smarty_tpl->tpl_vars['tid']->value),$_smarty_tpl);?>
" class="city_name <?php if ($_GET['three_cityid']==$_smarty_tpl->tpl_vars['tid']->value) {?>city_name_active<?php }?>"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['tid']->value];?>
</a> 
												<?php } ?>
											 
											<?php } else { ?> 
												
												<a class="city_name city_name_active" style="text-decoration:none;cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['cityid']];?>
</a> 
											<?php }?> 
										<?php } else { ?> 
											
											<?php if (is_array($_smarty_tpl->tpl_vars['city_type']->value[$_GET['provinceid']])) {?> 
												
												<a href="<?php echo smarty_function_listurl(array('untype'=>'cityid'),$_smarty_tpl);?>
" class="city_name <?php if (!$_GET['cityid']) {?>city_name_active<?php }?>">不限</a> 
												
												<?php  $_smarty_tpl->tpl_vars['tid'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tid']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_GET['provinceid']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tid']->key => $_smarty_tpl->tpl_vars['tid']->value) {
$_smarty_tpl->tpl_vars['tid']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['tid']->key;
?> 
													<a href="<?php echo smarty_function_listurl(array('type'=>'cityid','v'=>$_smarty_tpl->tpl_vars['tid']->value),$_smarty_tpl);?>
" class="city_name <?php if ($_GET['cityid']==$_smarty_tpl->tpl_vars['tid']->value) {?>city_name_active<?php }?>"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['tid']->value];?>
</a> 
												<?php } ?>
												 
											<?php } else { ?> 
											
												<a class="city_name city_name_active" style="text-decoration:none;cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['provinceid']];?>
</a> 
											<?php }?>
											 
										<?php }?> 
									<?php }?> 
								</div>
							</div>
						</div>
					</div>
					<?php } elseif ($_smarty_tpl->tpl_vars['config']->value['sy_web_city_one']) {?>
					<div class="Search_citybox">
						<div class="Search_cityboxname"> 地点：</div>
						<div class="Search_citybox_right">
							<div class="Search_cityboxright">
								<div class="search_city_list search_city_listw1100"> 
									<?php if (!$_GET['cityid']&&$_GET['three_cityid']) {?> 
										<a class="city_name city_name_active" style="text-decoration:none;cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['three_cityid']];?>
</a> 
									<?php } else { ?> 
										<?php if ($_GET['cityid']) {?> 
											<?php if (is_array($_smarty_tpl->tpl_vars['city_type']->value[$_GET['cityid']])) {?> 
												<a href="<?php echo smarty_function_listurl(array('untype'=>'three_cityid'),$_smarty_tpl);?>
" class="city_name <?php if (!$_GET['three_cityid']) {?>city_name_active<?php }?>">不限</a> 
											
												<?php  $_smarty_tpl->tpl_vars['tid'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tid']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_GET['cityid']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tid']->key => $_smarty_tpl->tpl_vars['tid']->value) {
$_smarty_tpl->tpl_vars['tid']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['tid']->key;
?> 
													<a href="<?php echo smarty_function_listurl(array('type'=>'three_cityid','v'=>$_smarty_tpl->tpl_vars['tid']->value),$_smarty_tpl);?>
" class="city_name <?php if ($_GET['three_cityid']==$_smarty_tpl->tpl_vars['tid']->value) {?>city_name_active<?php }?>"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['tid']->value];?>
</a> 
												<?php } ?>
											 
											<?php } else { ?> 
												
												<a class="city_name city_name_active" style="text-decoration:none;cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['cityid']];?>
</a> 
											<?php }?> 
										<?php } else { ?> 
											
											<?php if (is_array($_smarty_tpl->tpl_vars['city_type']->value[$_GET['provinceid']])) {?> 
												
												<a href="<?php echo smarty_function_listurl(array('untype'=>'cityid'),$_smarty_tpl);?>
" class="city_name <?php if (!$_GET['cityid']) {?>city_name_active<?php }?>">不限</a> 
												
												<?php  $_smarty_tpl->tpl_vars['tid'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tid']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_GET['provinceid']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tid']->key => $_smarty_tpl->tpl_vars['tid']->value) {
$_smarty_tpl->tpl_vars['tid']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['tid']->key;
?> 
													<a href="<?php echo smarty_function_listurl(array('type'=>'cityid','v'=>$_smarty_tpl->tpl_vars['tid']->value),$_smarty_tpl);?>
" class="city_name <?php if ($_GET['cityid']==$_smarty_tpl->tpl_vars['tid']->value) {?>city_name_active<?php }?>"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['tid']->value];?>
</a> 
												<?php } ?>
												 
											<?php } else { ?> 
											
												<a class="city_name city_name_active" style="text-decoration:none;cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['provinceid']];?>
</a> 
											<?php }?>
											 
										<?php }?> 
									<?php }?> 
								</div>
							</div>
						</div>
					</div>
					<?php } else { ?>
					<div class="Search_citybox">
						<div class="Search_cityboxname"> 地点：</div>
						<div class="Search_citybox_right">
							<div class="Search_cityall none"> 
								<a href="<?php echo smarty_function_listurl(array('type'=>'provinceid','v'=>0),$_smarty_tpl);?>
" class="city_name">全部</a> 
								<?php  $_smarty_tpl->tpl_vars['pid'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['pid']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['pid']->key => $_smarty_tpl->tpl_vars['pid']->value) {
$_smarty_tpl->tpl_vars['pid']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['pid']->key;
?> 
									<a href="<?php echo smarty_function_listurl(array('type'=>'provinceid','v'=>$_smarty_tpl->tpl_vars['pid']->value),$_smarty_tpl);?>
" class="city_name <?php if ($_GET['provinceid']==$_smarty_tpl->tpl_vars['pid']->value) {?>city_name_active<?php }?>"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['pid']->value];?>
</a> 
								<?php } ?> 
							</div>
							<div class="Search_cityboxright"> 
								<a href="javascript:;" onclick="acityshow('1')" class="search_city_list_cur <?php if ($_GET['provinceid']&&!$_GET['cityid']||!is_array($_smarty_tpl->tpl_vars['city_type']->value[$_GET['cityid']])) {?>search_city_active<?php }?> <?php if (!$_GET['provinceid']) {?>none<?php }?> acity_two" style="text-decoration:none;cursor:pointer;">
									<span class="search_city_p"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['provinceid']];?>
</span>
									<i class="search_city_p_jt"></i>
									<i class="search_city_list_line"></i>
								</a> 
								<a href="javascript:;" <?php if ($_GET['cityid']) {?>onclick="acityshow('2')" <?php }?> class="search_city_list_cur <?php if ($_GET['cityid']&&is_array($_smarty_tpl->tpl_vars['city_type']->value[$_GET['cityid']])) {?>search_city_active<?php }?> <?php if (!$_GET['provinceid']||!$_GET['cityid']||!is_array($_smarty_tpl->tpl_vars['city_type']->value[$_GET['cityid']])) {?>none<?php }?> acity_three" style="text-decoration:none;cursor:pointer;">
									<span class="search_city_p"><?php if (!$_GET['cityid']) {?>不限<?php } else {
echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['cityid']];
}?></span>
									<i class="search_city_list_line"></i>
								</a> 
								<a href="<?php echo smarty_function_listurl(array('type'=>'provinceid','v'=>0),$_smarty_tpl);?>
" class="search_city_list_all <?php if (!$_GET['provinceid']) {?>city_name_active<?php }?>">全部</a>
								<div class="search_city_list"> 
									<?php  $_smarty_tpl->tpl_vars['pid'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['pid']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['pid']->key => $_smarty_tpl->tpl_vars['pid']->value) {
$_smarty_tpl->tpl_vars['pid']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['pid']->key;
?> 
										<a href="<?php echo smarty_function_listurl(array('type'=>'provinceid','v'=>$_smarty_tpl->tpl_vars['pid']->value),$_smarty_tpl);?>
" class="city_name <?php if ($_GET['provinceid']&&!$_GET['cityid']) {
if ($_smarty_tpl->tpl_vars['key']->value>13) {?>none<?php }
} elseif ($_GET['cityid']) {
if ($_smarty_tpl->tpl_vars['key']->value>12) {?>none<?php }
} else {
if ($_smarty_tpl->tpl_vars['key']->value>14) {?>none<?php }
}?> <?php if ($_GET['provinceid']==$_smarty_tpl->tpl_vars['pid']->value) {?>city_name_active<?php }?>"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['pid']->value];?>
</a> 
									<?php } ?> 
								</div>
								<a href="javascript:;" class="search_city_list_more" id="acity">更多</a> 
							</div>
							
							<div class="Search_cityboxclose <?php if (!$_GET['provinceid']||($_GET['provinceid']&&$_GET['cityid']&&is_array($_smarty_tpl->tpl_vars['city_type']->value[$_GET['cityid']]))) {?>none<?php }?>" id="acity_two"> <a href="<?php echo smarty_function_listurl(array('untype'=>'cityid'),$_smarty_tpl);?>
" class="city_name <?php if ($_GET['provinceid']&&!$_GET['cityid']&&!$_GET['three_cityid']) {?>city_name_active<?php }?>">不限</a> <?php  $_smarty_tpl->tpl_vars['cid'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cid']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_GET['provinceid']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cid']->key => $_smarty_tpl->tpl_vars['cid']->value) {
$_smarty_tpl->tpl_vars['cid']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['cid']->key;
?> <a href="<?php echo smarty_function_listurl(array('type'=>'cityid','v'=>$_smarty_tpl->tpl_vars['cid']->value),$_smarty_tpl);?>
" class="city_name <?php if ($_GET['cityid']==$_smarty_tpl->tpl_vars['cid']->value) {?>city_name_active<?php }?>"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['cid']->value];?>
</a> <?php } ?> </div>
							<div class="Search_cityboxclose <?php if (!$_GET['cityid']||!is_array($_smarty_tpl->tpl_vars['city_type']->value[$_GET['cityid']])) {?>none<?php }?>" id="acity_three"> <a href="<?php echo smarty_function_listurl(array('untype'=>'three_cityid'),$_smarty_tpl);?>
" class="city_name <?php if ($_GET['provinceid']&&$_GET['cityid']&&!$_GET['three_cityid']) {?>city_name_active<?php }?>">不限</a> <?php  $_smarty_tpl->tpl_vars['tid'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tid']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_GET['cityid']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tid']->key => $_smarty_tpl->tpl_vars['tid']->value) {
$_smarty_tpl->tpl_vars['tid']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['tid']->key;
?> <a href="<?php echo smarty_function_listurl(array('type'=>'three_cityid','v'=>$_smarty_tpl->tpl_vars['tid']->value),$_smarty_tpl);?>
" class="city_name <?php if ($_GET['three_cityid']==$_smarty_tpl->tpl_vars['tid']->value) {?>city_name_active<?php }?>"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['tid']->value];?>
</a> <?php } ?> </div>
					  </div>
					</div>
					<?php }?> 
					<!-- city end-->
        
					<div class="Search_jobs_form_list search_more">
						<div class="Search_jobs_name"> 薪资：</div>
						<div> 
							<a href="<?php echo smarty_function_listurl(array('type'=>'salary','v'=>0),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['minsalary']==''&&$_GET['maxsalary']=='') {?>Search_jobs_sub_cur<?php }?>">全部</a> 
							<a href="<?php echo smarty_function_listurl(array('type'=>'salary','v'=>'2000_4000'),$_smarty_tpl);?>
" class="Search_jobs_cxz <?php if ($_GET['minsalary']==2000&&$_GET['maxsalary']==4000) {?>Search_jobs_sub_cur<?php }?>">2000-4000</a>
							<a href="<?php echo smarty_function_listurl(array('type'=>'salary','v'=>'4000_6000'),$_smarty_tpl);?>
" class="Search_jobs_cxz <?php if ($_GET['minsalary']==4000&&$_GET['maxsalary']==6000) {?>Search_jobs_sub_cur<?php }?>">4000-6000</a> 
							<a href="<?php echo smarty_function_listurl(array('type'=>'salary','v'=>'6000_8000'),$_smarty_tpl);?>
" class="Search_jobs_cxz <?php if ($_GET['minsalary']==6000&&$_GET['maxsalary']==8000) {?>Search_jobs_sub_cur<?php }?>">6000-8000</a> 
							<a href="<?php echo smarty_function_listurl(array('type'=>'salary','v'=>'8000_10000'),$_smarty_tpl);?>
" class="Search_jobs_cxz <?php if ($_GET['minsalary']==8000&&$_GET['maxsalary']==10000) {?>Search_jobs_sub_cur<?php }?>">8000-10000</a> 
							<a href="<?php echo smarty_function_listurl(array('type'=>'salary','v'=>'10000'),$_smarty_tpl);?>
" class="Search_jobs_cxz <?php if ($_GET['minsalary']==10000) {?>Search_jobs_sub_cur<?php }?>">10000以上</a> 
						</div>
						<input type="text" name="minsalary" id="min" value="<?php if ($_GET['minsalary']) {
echo $_GET['minsalary'];
} else {
if ($_GET['maxsalary']) {?>0<?php }
}?>" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" class="job_xz_text" />
						<span class="job_xz_line">-</span>
						<input type="text" name="maxsalary" id="max" value="<?php if ($_GET['maxsalary']) {
echo $_GET['maxsalary'];
}?>" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" class="job_xz_text" />
						<input type="submit" value="确定" class="job_xz_bth" />
					</div>

					<div class="searchmorelist ">

					<!--	<?php if ($_smarty_tpl->tpl_vars['comdata']->value['job_welfare']) {?>
							<div class="Search_jobs_form_list search_more ">
								<div class="Search_jobs_name">福利：</div>
								<div class="Search_jobs_sub"> 
									<a href="<?php echo smarty_function_listurl(array('type'=>'welfare','v'=>0),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['welfare']=='0'||$_GET['welfare']=='') {?>Search_jobs_sub_cur<?php }?>">全部</a> 
									<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['comdata']->value['job_welfare']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?> 
									<a href="<?php echo smarty_function_listurl(array('type'=>'welfare','v'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_smarty_tpl->tpl_vars['key']->value>9) {?>none<?php }?> <?php if ($_smarty_tpl->tpl_vars['key']->value>9) {?>welfarelist<?php }?> <?php if ($_GET['welfare']==$_smarty_tpl->tpl_vars['v']->value) {?>Search_jobs_sub_cur<?php }?>"><?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> 
									<?php } ?> 
								</div>
								<?php if (count($_smarty_tpl->tpl_vars['comdata']->value['job_welfare'])>10) {?>
								<div class="zh_more"> 
									<a href="javascript:checkmore('welfarelist');" id="welfarelist" rel="nofollow">更多</a> 
								</div>
								<?php }?> 
							</div>
						<?php }?>-->
               
						<div class="Search_jobs_form_list search_more">
							<div class="Search_jobs_name"> 更多：</div>
							<div class="Search_jobs_sub" style="width:1090px;">
								<?php if ($_smarty_tpl->tpl_vars['comdata']->value['job_welfare']) {?>
								<div class="Search_jobs_more_chlose">
									<span class="Search_jobs_more_chlose_s">公司福利</span> <i class=""></i>
									<div class="Search_jobs_more_chlose_list none">
										<ul>
											<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['comdata']->value['job_welfare']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?> 
												<li> <a href="<?php echo smarty_function_listurl(array('type'=>'welfare','v'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
 "><?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a>  </li>
											<?php } ?>
										</ul>
									</div>
								</div>
									<?php }?>
							

								<div class="Search_jobs_more_chlose"> 
									<span class="Search_jobs_more_chlose_s"> <?php if ($_GET['edu']) {
echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_GET['edu']];
} else { ?>学历要求<?php }?> </span> <i class=""></i>
									<div class="Search_jobs_more_chlose_list none">
										<ul>
											<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['comdata']->value['job_edu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
												<li> <a href="javascript:;" onclick="showurl('<?php echo smarty_function_listurl(array('type'=>'edu','v'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
')"><?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> </li>
											<?php } ?>
										</ul>
									</div>
								</div>

								<div class="Search_jobs_more_chlose">
									<span class="Search_jobs_more_chlose_s"><?php if ($_GET['exp']) {
echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_GET['exp']];
} else { ?>经验要求<?php }?></span><i class=""></i>
									<div class="Search_jobs_more_chlose_list none">
										<ul>
											<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['comdata']->value['job_exp']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
												<li> <a href="javascript:;" onclick="showurl('<?php echo smarty_function_listurl(array('type'=>'exp','v'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
')"><?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> </li>
											<?php } ?>
										</ul>
									</div>
								</div>

								<div class="Search_jobs_more_chlose">
									<span class="Search_jobs_more_chlose_s"><?php if ($_GET['sex']) {
echo $_smarty_tpl->tpl_vars['com_sex']->value[$_GET['sex']];
} else { ?>性别要求<?php }?></span><i class=""></i>
									<div class="Search_jobs_more_chlose_list none">
										<ul>
											<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['com_sex']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
												<li> <a href="javascript:;" onclick="showurl('<?php echo smarty_function_listurl(array('type'=>'sex','v'=>$_smarty_tpl->tpl_vars['j']->value),$_smarty_tpl);?>
')"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</a> </li>
											<?php } ?>
										</ul>
									</div>
								</div>

								<div class="Search_jobs_more_chlose">
									<span class="Search_jobs_more_chlose_s"><?php if ($_GET['report']) {
echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_GET['report']];
} else { ?>到岗时间<?php }?></span><i class=""></i>
									<div class="Search_jobs_more_chlose_list none">
										<ul>
											<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['comdata']->value['job_report']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
												<li> <a href="javascript:;" onclick="showurl('<?php echo smarty_function_listurl(array('type'=>'report','v'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
')"><?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> </li>
											<?php } ?>
										</ul>
									</div>
								</div>
<div class="Search_jobs_more_chlose">
									<span class="Search_jobs_more_chlose_s"><?php if ($_GET['hy']) {
echo $_smarty_tpl->tpl_vars['industry_name']->value[$_GET['hy']];
} else { ?>公司行业<?php }?></span><i class=""></i>
									
									<div class="Search_jobs_more_chlose_hylist none">
										<ul>
											<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['industry_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
												<li> <a href="javascript:;" onclick="showurl('<?php echo smarty_function_listurl(array('type'=>'hy','v'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
')"><?php echo $_smarty_tpl->tpl_vars['industry_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> </li>
											<?php } ?>
										</ul>
									</div>
								</div>
								<div class="Search_jobs_more_chlose">
									<span class="Search_jobs_more_chlose_s"><?php if ($_smarty_tpl->tpl_vars['uptime']->value[$_GET['uptime']]) {
echo $_smarty_tpl->tpl_vars['uptime']->value[$_GET['uptime']];
} else { ?>更新时间<?php }?></span><i class=""></i>
									<div class="Search_jobs_more_chlose_list none">
										<ul>
											<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['uptime']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
												<li> <a href="javascript:;" onclick="showurl('<?php echo smarty_function_listurl(array('type'=>'uptime','v'=>$_smarty_tpl->tpl_vars['key']->value),$_smarty_tpl);?>
')"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</a> </li>
											<?php } ?>
										</ul>
									</div>
								</div>
								
							</div>
						</div>  
					</div>

					<?php if ($_GET['job1']||$_GET['job1_son']||$_GET['job_post']||($_GET['provinceid']&&!$_smarty_tpl->tpl_vars['config']->value['sy_web_city_one'])||($_GET['cityid']&&!$_smarty_tpl->tpl_vars['config']->value['sy_web_city_two'])||$_GET['three_cityid']||$_GET['hy']||$_GET['edu']||$_GET['exp']||$_GET['sex']||$_GET['report']||$_GET['uptime']||$_GET['minsalary']||$_GET['maxsalary']||$_GET['keyword']||$_GET['cert']||$_GET['welfare']) {?>
						<div class="Search_close_box">
							<div>
								<div class="Search_clear"> 
									<?php if ($_smarty_tpl->tpl_vars['config']->value['sy_default_comclass']==1) {?> 
										<a href="<?php echo smarty_function_url(array('m'=>'job','c'=>'search'),$_smarty_tpl);?>
"> 清除所选</a> 
									<?php } else { ?> 
										<a href="<?php echo smarty_function_url(array('m'=>'job'),$_smarty_tpl);?>
"> 清除所选</a> 
									<?php }?> 
								</div>
								<span class="Search_close_box_s">已选条件：</span> 
							</div>

							<?php if ($_GET['job1']) {?> 
								<a href="<?php echo smarty_function_listurl(array('untype'=>'job1'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">职位分类：<?php echo $_smarty_tpl->tpl_vars['job_name']->value[$_GET['job1']];?>
</a> 
							<?php }?>

							<?php if ($_GET['job1_son']) {?> 
								<a href="<?php echo smarty_function_listurl(array('untype'=>'job1_son'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac"><?php echo $_smarty_tpl->tpl_vars['job_name']->value[$_GET['job1_son']];?>
</a> 
							<?php }?> 

							<?php if ($_GET['job_post']) {?> 
								<a href="<?php echo smarty_function_listurl(array('untype'=>'job_post'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac"><?php echo $_smarty_tpl->tpl_vars['job_name']->value[$_GET['job_post']];?>
</a> 
							<?php }?> 
						  
							<?php if ($_smarty_tpl->tpl_vars['config']->value['cityid']==''&&$_smarty_tpl->tpl_vars['config']->value['three_cityid']=='') {?> 
								<?php if ($_GET['provinceid']&&!$_smarty_tpl->tpl_vars['config']->value['sy_web_city_one']) {?> 
									<a href="<?php echo smarty_function_listurl(array('untype'=>'provinceid'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">工作地点：<?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['provinceid']];?>
</a> 
								<?php }?> 
						  
								<?php if ($_GET['cityid']&&!$_smarty_tpl->tpl_vars['config']->value['sy_web_city_two']) {?> 
									<a href="<?php echo smarty_function_listurl(array('untype'=>'cityid'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['cityid']];?>
</a> 
								<?php }?> 
							<?php }?> 
						  
							<?php if ($_GET['three_cityid']) {?> 
								<a href="<?php echo smarty_function_listurl(array('untype'=>'three_cityid'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['three_cityid']];?>
</a> 
							<?php }?> 
							
							<?php if ($_smarty_tpl->tpl_vars['industry_name']->value[$_GET['hy']]) {?> 
								<a href="<?php echo smarty_function_listurl(array('untype'=>'hy'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">行业：<?php echo $_smarty_tpl->tpl_vars['industry_name']->value[$_GET['hy']];?>
</a> 
							<?php }?> 

							<?php if ($_GET['edu']) {?> 
								<a href="<?php echo smarty_function_listurl(array('untype'=>'edu'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">学历：<?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_GET['edu']];?>
</a> 
							<?php }?> 
						  
							<?php if ($_GET['exp']) {?> 
								<a href="<?php echo smarty_function_listurl(array('untype'=>'exp'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">工作经验：<?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_GET['exp']];?>
</a> 
							<?php }?> 
						  
							<?php if ($_GET['sex']) {?> 
								<a href="<?php echo smarty_function_listurl(array('untype'=>'sex'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">性别：<?php echo $_smarty_tpl->tpl_vars['com_sex']->value[$_GET['sex']];?>
</a> 
							<?php }?> 

							<?php if ($_GET['report']) {?> 
								<a href="<?php echo smarty_function_listurl(array('untype'=>'report'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">到岗时间：<?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_GET['report']];?>
</a> 
							<?php }?>
							
							<?php if ($_GET['uptime']) {?> 
								<a href="<?php echo smarty_function_listurl(array('untype'=>'uptime'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">更新时间：<?php echo $_smarty_tpl->tpl_vars['uptime']->value[$_GET['uptime']];?>
</a> 
							<?php }?> 
							
							<?php if ($_GET['minsalary']&&$_GET['maxsalary']) {?> 
								<a href="<?php echo smarty_function_listurl(array('untype'=>'salary'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">薪资：<?php echo $_GET['minsalary'];?>
-<?php echo $_GET['maxsalary'];?>
</a> 
							<?php } elseif ($_GET['minsalary']&&!$_GET['maxsalary']) {?> 
								<a href="<?php echo smarty_function_listurl(array('untype'=>'salary'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">薪资：<?php echo $_GET['minsalary'];?>
及以上</a> 
							<?php } elseif (!$_GET['minsalary']&&$_GET['maxsalary']) {?> 
								<a href="<?php echo smarty_function_listurl(array('untype'=>'salary'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">薪资：<?php echo $_GET['maxsalary'];?>
及以下</a> 
							<?php }?> 
							
							<?php if ($_GET['keyword']) {?> 
								<a href="<?php echo smarty_function_listurl(array('untype'=>'keyword'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac"><?php echo $_GET['keyword'];?>
</a> 
							<?php }?> 
							
							<?php if ($_GET['cert']) {?> 
								<a href="<?php echo smarty_function_listurl(array('untype'=>'cert'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">资质已认证</a>
							<?php }?> 
							
							<?php if ($_GET['welfare']) {?> 
								<a href="<?php echo smarty_function_listurl(array('untype'=>'welfare'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">福利待遇：<?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_GET['welfare']];?>
</a> 
							<?php }?> &nbsp; 
						</div>
					<?php }?>
					
					<div class="clear"></div>
					
				
				</div>
			</form>

			<div class="search_h1_box">
				<div class="search_h1_box_title">

					<ul class="search_h1_box_list">
						<li <?php if ($_GET['urgent']==''&&$_GET['rec']=='') {?>class="search_job_all " <?php }?> class="search_job_all"> <a href="<?php echo smarty_function_listurl(array('type'=>'tp','v'=>0),$_smarty_tpl);?>
">所有职位</a><i class="search_h1_box_list_icon"></i></li>
					<li <?php if ($_GET['order']=='lastdate') {?>class="search_Filter_current" <?php }?>> <a href="<?php echo smarty_function_listurl(array('type'=>'order','v'=>'lastdate'),$_smarty_tpl);?>
"><span>更新时间</span><i class="search_Filter_icon"></i></a></li>
					<li <?php if ($_GET['order']=='sdate') {?>class="search_Filter_current" <?php }?>> <a href="<?php echo smarty_function_listurl(array('type'=>'order','v'=>'sdate'),$_smarty_tpl);?>
"><span>发布时间</span><i class="search_Filter_icon"></i></a></li>
					<li class="<?php if ($_GET['urgent']) {?>search_h1_box_cur<?php }?> job_jp_t"> <a href="<?php if ($_GET['urgent']) {
echo smarty_function_listurl(array('type'=>'tp','v'=>0),$_smarty_tpl);
} else {
echo smarty_function_listurl(array('type'=>'tp','v'=>1),$_smarty_tpl);
}?>"class="job_zt"> 紧急职位 <i class="job_jp_chk"></i>  </a> </li>
					<li class="<?php if ($_GET['rec']) {?>search_h1_box_cur<?php }?> job_tj_t"> <a href="<?php if ($_GET['rec']) {
echo smarty_function_listurl(array('type'=>'tp','v'=>0),$_smarty_tpl);
} else {
echo smarty_function_listurl(array('type'=>'tp','v'=>2),$_smarty_tpl);
}?>"class="job_zt"> 推荐职位 <i class="job_tj_chk"></i> </a> </li>
						<li class=" <?php if ($_GET['cert']) {?>search_h1_box_cur<?php }?>">
							<a href="<?php if ($_GET['cert']) {
echo smarty_function_listurl(array('type'=>'cert','v'=>0),$_smarty_tpl);
} else {
echo smarty_function_listurl(array('type'=>'cert','v'=>3),$_smarty_tpl);
}?>" class="job_zt"><i class="job_tj_chk"></i><em>资质认证</em> </a> 
					</li></ul>
<div class="search_mxbox"> 
							<a href="<?php echo smarty_function_listurl(array('untype'=>'jobtype'),$_smarty_tpl);?>
" class="search_mx <?php if ($_GET['jobtype']!='1') {?>search_mxcur<?php }?>"><i class="search_mx_a"></i></a> <a href="<?php echo smarty_function_listurl(array('type'=>'jobtype','v'=>1),$_smarty_tpl);?>
" class="search_mx <?php if ($_GET['jobtype']=='1') {?>search_mxcur<?php }?>"><i class="search_mx_b"></i></a> 
						</div>
					
					<div class="search_h1_box_t fr">提升招聘效果，请致电：<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_freewebtel'];?>
</div>
			  </div>

			</div>

    <div class="left_job_all fl">

		<div class="job_left_sidebar">
		<?php if (!empty($_smarty_tpl->tpl_vars['member']->value)&&$_smarty_tpl->tpl_vars['member']->value['usertype']==1&&$_smarty_tpl->tpl_vars['member']->value['unionid']==''&&$_smarty_tpl->tpl_vars['member']->value['wxid']==''&&$_smarty_tpl->tpl_vars['wxtz_tips']->value==0) {?>
			 <!-----微信通知---------->
			 <div class="wxtz_box" id="wxtz_tips">
				 <div class="wxtz_box_c">
					 <div class="wxtz_box_name">新职位发布时通知我</div>
					 <div class="wxtz_box_p">订阅相关岗位，新岗位上线实时通知，求职快人一步</div>
					 <div class="wxtz_box_s">
						 <div class="wxtz_box_ewm">
							 <img src="<?php if ($_smarty_tpl->tpl_vars['config']->value['sy_wx_qcode']) {
echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_wx_qcode'];
}?>"  >
						 </div>微信扫一扫
					 </div>
			 	 </div>
				 <a href="javascript:void(0);" onclick="closeWxtzTips()" class="wxtz_box_close"></a>
			 </div>
	  	<?php }?>
		 
        <!-----竞价置顶----------> 
        
        <?php if ($_GET['page']<2) {?>
        <?php  $_smarty_tpl->tpl_vars['zd_list'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['zd_list']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
global $db,$db_config,$config;
		$time = time();
		
		
		//可以做缓存
        $paramer=array("namelen"=>"30","comlen"=>"30","report"=>"'auto.report'","hy"=>"'auto.hy'","job1"=>"'auto.job1'","welfare"=>"'auto.welfare'","job1_son"=>"'auto.job1_son'","job_post"=>"'auto.job_post'","jobids"=>"'auto.jobids'","pr"=>"'auto.pr'","mun"=>"'auto.mun'","provinceid"=>"'auto.provinceid'","cityid"=>"'auto.cityid'","three_cityid"=>"'auto.three_cityid'","type"=>"'auto.type'","edu"=>"'auto.edu'","exp"=>"'auto.exp'","sex"=>"'auto.sex'","minsalary"=>"'auto.minsalary'","maxsalary"=>"'auto.maxsalary'","keyword"=>"'auto.keyword'","cert"=>"'auto.cert'","urgent"=>"'auto.urgent'","rec"=>"'auto.rec'","bid"=>"1","uptime"=>"'auto.uptime'","key"=>"'key'","item"=>"'zd_list'","name"=>"'zdlist1'","nocache"=>"")
;
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
        $Purl =  $ParamerArr[purl];
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }
		include_once  PLUS_PATH."/comrating.cache.php";
		include(CONFIG_PATH."db.data.php"); 
		if($config[sy_web_site]=="1"){
			if($config[province]>0 && $config[province]!=""){
				$paramer[provinceid] = $config[province];
			}
			if($config[cityid]>0 && $config[cityid]!=""){
				$paramer[cityid] = $config[cityid];
			}
			if($config[three_cityid]>0 && $config[three_cityid]!=""){
				$paramer[three_cityid] = $config[three_cityid];
			}
			if($config[hyclass]>0 && $config[hyclass]!=""){
				$paramer[hy]=$config[hyclass];
			}
		}

		
		if($paramer[sdate]){
			$where = "`sdate`>".strtotime("-".intval($paramer[sdate])." day",time())." and `state`=1";
		}else{
			$where = "`state`=1";
		}
		
		//按照UID来查询（按公司地址查询可用GET[id]获取当前公司ID）
		if($paramer[uid]){
			$where .= " AND `uid` = '$paramer[uid]'";
		}
		if($paramer[com_id]){
			$where .= " AND `uid` = '$paramer[com_id]'";
		}

		//是否推荐职位
		if($paramer[rec]){
			
			$where.=" AND `rec_time`>=".time();
			
		}
		//企业认证条件
		if($paramer['cert']){
			$job_uid=array();
			$company=$db->select_all("company","`yyzz_status`=1","`uid`");
			if(is_array($company)){
				foreach($company as $v){
					$job_uid[]=$v['uid'];
				}
			}
			$where.=" and `uid` in (".@implode(",",$job_uid).")";
		}
		//取不包含当前企业的职位
		if($paramer[nouid]){
			$where.= " and `uid`<>$paramer[nouid]";
		}
		//取不包含当前id的职位
		if($paramer[noid]){
			$where.= " and `id`<>$paramer[noid]";
		}
		//是否被锁定
		if($paramer[r_status]){
			$where.= " and `r_status`=2";
		}else{
			$where.= " and `r_status`=1";
		}
		//是否下架职位
		if($paramer[status]){
			$where.= " and `status`='1'";
		}else{
			$where.= " and `status`='0'";
		}
		//公司体制
		if($paramer[pr]){
			$where .= " AND `pr` =$paramer[pr]";
		}
		//公司行业分类
		if($paramer['hy']){
			$where .= " AND `hy` = $paramer[hy]";
		} 
		//职位大类
		if($paramer[job1]){
			$where .= " AND `job1` = $paramer[job1]";
		}
		//职位子类
		if($paramer[job1_son]){
			$where .= " AND `job1_son` = $paramer[job1_son]";
		}
		//职位三级分类
		if($paramer[job_post]){
			$where .= " AND (`job_post` IN ($paramer[job_post]))";
		}
		//您可能感兴趣的职位--个人会员中心
		if($paramer['jobwhere']){
			$where .=" and ".$paramer['jobwhere'];
		}
		//职位分类综合查询
		if($paramer['jobids']){
			$where.= " AND (`job1` = '$paramer[jobids]' OR `job1_son`= '$paramer[jobids]' OR `job_post`='$paramer[jobids]')";
		}
		//职位分类区间,不建议执行该查询
		if($paramer['jobin']){
			$where .= " AND (`job1` IN ($paramer[jobin]) OR `job1_son` IN ($paramer[jobin]) OR `job_post` IN ($paramer[jobin]))";
		}
		//城市大类
		if($paramer[provinceid]){
			$where .= " AND `provinceid` = $paramer[provinceid]";
		}
		//城市子类
		if($paramer['cityid']){
			$where .= " AND (`cityid` IN ($paramer[cityid]))";
		}
		//城市三级子类
		if($paramer['three_cityid']){
			$where .= " AND (`three_cityid` IN ($paramer[three_cityid]))";
		}
		if($paramer['cityin']){
			$where .= " AND `three_cityid` IN ($paramer[cityin])";
		}
		//学历
		if($paramer[edu]){
		    
		    $eduKey =   $db->DB_select_once("comclass", "`variable` = 'job_edu'", "`id`");
		    $eduReq =   $db->DB_select_once("comclass", "`id` = $paramer[edu]", "`sort`,`name`");
		    if($eduReq[name] != "不限"){
		    
                $eduArr =   $db->select_all("comclass", "`keyid` = $eduKey[id] AND `sort` <= $eduReq[sort]", "`id`");
                $eduIds =   array();
                foreach($eduArr as $v){
                    $eduIds[]   =   $v[id];
                }
                
                $where .= " AND `edu` in (".@implode(",",$eduIds).")";
			}
		}
		//工作经验
		if($paramer[exp]){
		
		    $expKey =   $db->DB_select_once("comclass", "`variable` = 'job_exp'", "`id`");
		    $expReq =   $db->DB_select_once("comclass",  "`id` = $paramer[exp]", "`sort`,`name`");
		    if($expReq[name] != "不限"){
		    
                $expArr =   $db->select_all("comclass", "`keyid` = $expKey[id] AND `sort` <= $expReq[sort]", "`id`");
                $expIds =   array();
                foreach($expArr as $v){
                    $expIds[]   =   $v[id];
                }
			    $where .= " AND `exp` in (".@implode(",",$expIds).")";
	        }
		}
		//到岗时间
		if($paramer[report]){
			$where .= " AND `report` = $paramer[report]";
		}
		//职位性质
		if($paramer[type]){
			$where .= " AND `type` = $paramer[type]";
		}
		//性别
		if($paramer[sex]){
			$where .= " AND `sex` = $paramer[sex]";
		}
		//应届生
		if($paramer[is_graduate]){
			$where .= " AND `is_graduate` = $paramer[is_graduate]";
		}
		//公司规模
		if($paramer[mun]){
			$where .= " AND `mun` = $paramer[mun]";
		}
		 
		if($paramer[minsalary] && $paramer[maxsalary]){
			$where.= " AND (`minsalary`>=".intval($paramer[minsalary])." and `minsalary`<=".intval($paramer[maxsalary])." and `maxsalary`<=".intval($paramer[maxsalary]).") ";

		}elseif($paramer[minsalary]&&!$paramer[maxsalary]){
			$where.= " AND (`minsalary`>=".intval($paramer[minsalary]).") ";

		}elseif(!$paramer[minsalary]&&$paramer[maxsalary]){
			$where.= " AND (`minsalary`<=".intval($paramer[maxsalary])." and `maxsalary`<=".intval($paramer[maxsalary]).") ";
		}

	    //福利待遇
	    $cache_array = $db->cacheget();
		$comclass_name = $cache_array["comclass_name"];
		if($paramer[welfare]){
			$welfarename=$comclass_name[$paramer[welfare]];
            $where .=" AND `welfare` LIKE '%".$welfarename."%' ";
		}
		
		//城市区间,不建议执行该查询
		if($paramer[cityin]){
			$where .= " AND (`provinceid` IN ($paramer[cityin]) OR `cityid` IN ($paramer[cityin]) OR `three_cityid` IN ($paramer[cityin]))";
		}
		//紧急招聘urgent
		if($paramer[urgent]){
			$where.=" AND `urgent_time`>".time();
		}
		//更新时间区间
		if($paramer[uptime]){
			if($paramer[uptime]==1){
				$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
				$where.=" AND lastupdate>$beginToday";
			}else{
				$time=time();
				$uptime = $time-($paramer[uptime]*86400);
				$where.=" AND lastupdate>$uptime";
			}
		}else{
		    if($config[sy_datacycle]>0){	
                // 后台-页面设置-数据周期	        
				$uptime = strtotime('-'.$config[sy_datacycle].' day');
				$where.=" AND lastupdate>$uptime";
		    }
		}		
		//按类似公司名称,不建议进行大数据量操作
		if($paramer[comname]){
			$where.=" AND `com_name` LIKE '%".$paramer[comname]."%'";
		}
		//按公司归属地,只适合查询一级城市分类
		if($paramer[com_pro]){
			$where.=" AND `com_provinceid` ='".$paramer[com_pro]."'";
		}
		//按照职位名称匹配
		if($paramer[keyword]){
			$where1[]="`name` LIKE '%".$paramer[keyword]."%'";
			$where1[]="`com_name` LIKE '%".$paramer[keyword]."%'";
			include  PLUS_PATH."/city.cache.php";
			foreach($city_name as $k=>$v){
				if(strpos($v,$paramer[keyword])!==false){
					$cityid[]=$k;
				}
			}
			if(is_array($cityid)){
				foreach($cityid as $value){
					$class[]= "(provinceid = '".$value."' or cityid = '".$value."')";
				}
				$where1[]=@implode(" or ",$class);
			}
			$where.=" AND (".@implode(" or ",$where1).")";
		}

		//多选职位
		if($paramer["job"]){
			$where.=" AND `job_post` in ($paramer[job])";
		}
		//置顶招聘
		if($paramer[bid]){
			if($config[joblist_top]!=1){
				$paramer[limit] = 5;
			}
			$where.="  and `xsdate`>'".time()."'";
		} 
		
		//自定义查询条件，默认取代上面任何参数直接使用该语句
		if($paramer[where]){
			$where = $paramer[where];
		}

		//查询条数
		$limit = '';
		if($paramer[limit]){

			$limit = " limit ".$paramer[limit];
		}
		if($paramer[ispage]){
			$limit = PageNav($paramer,$_GET,"company_job",$where,$Purl,"",$paramer[islt]?$paramer[islt]:"6",$_smarty_tpl);        
		}

		//排序字段默认为更新时间
		//置顶设置为随机5条时，随机查询
		if($paramer[bid] && $paramer[limit]){
			$order = " ORDER BY rand() ";
		}else{
			if($paramer[order] && $paramer[order]!="lastdate"){
				$order = " ORDER BY ".str_replace("'","",$paramer[order])."  ";
			}else{
				$order = " ORDER BY `lastupdate` ";
			}
		}
		//排序规则 默认为倒序
		if($paramer[sort]){
			$sort = $paramer[sort];
		}else{
			$sort = " DESC";
		} 
		$where.=$order.$sort;
		
		$zd_list = $db->select_all("company_job",$where.$limit);

		if(is_array($zd_list) && !empty($zd_list)){
			//处理类别字段
			$cache_array = $db->cacheget();
			$comuid=$jobid=array();
			foreach($zd_list as $key=>$value){
				if(in_array($value['uid'],$comuid)==false){$comuid[] = $value['uid'];}
				if(in_array($value['id'],$jobid)==false){$jobid[] = $value['id'];} 
			}
			$comuids = @implode(',',$comuid);
			$jobids = @implode(',',$jobid);
			//减少曝光量统计维度 只有列表才统计
			if($paramer[ispage]){
				$db->update_all("company_job", "`jobexpoure` = `jobexpoure` + 1", "`id` in ($jobids)");
			}
			

			if($comuids){
				$r_uids=$db->select_all("company","`uid` IN (".$comuids.")","`uid`,`yyzz_status`,`logo`,`logo_status`,`pr`,`hy`,`mun`,`shortname`,`welfare`,`hotstart`,`hottime`");
				if(is_array($r_uids)){
					foreach($r_uids as $key=>$value){
						if($value[shortname]){
    						$value['shortname_n'] = $value[shortname];
    					}
						if(!$value['logo'] || $value['logo_status']!=0){
							$value['logo'] = checkpic("",$config['sy_unit_icon']);
						}else{
							$value['logo']= checkpic($value['logo']);
						}
						$value['pr_n'] = $cache_array['comclass_name'][$value[pr]];
						$value['hy_n'] = $cache_array['industry_name'][$value[hy]];
						$value['mun_n'] = $cache_array['comclass_name'][$value[mun]];
						if($value['hotstart']<=time() && $value['hottime']>=time()){
							$value['hotlogo'] = 1;
						}
						$r_uid[$value['uid']] = $value;
					}
				}
			}
			
 			if($paramer[bid]){
				$noids=array();
			}	
			foreach($zd_list as $key=>$value){

				if($paramer[bid]){
					$noids[] = $value[id];
				}
				//筛除重复
				if($paramer[noids]==1 && !empty($noids) && in_array($value['id'],$noids)){
					unset($zd_list[$key]);
					continue;
				}else{
					$zd_list[$key] = $db->array_action($value,$cache_array);
					$zd_list[$key][stime] = date("Y-m-d",$value[sdate]);
					$zd_list[$key][etime] = date("Y-m-d",$value[edate]);
					if($arr_data['sex'][$value['sex']]){
						$zd_list[$key][sex_n]=$arr_data['sex'][$value['sex']];
					}
					$zd_list[$key][lastupdate] =lastupdateStyle($value[lastupdate]);
					if($value[minsalary]&&$value[maxsalary]){
						if($config['resume_salarytype']==1){
								$zd_list[$key][job_salary] =$value[minsalary]."-".$value[maxsalary];
						}else{
							if($value[maxsalary]<1000){
								if($config['resume_salarytype']==2){
									$zd_list[$key][job_salary] = "1千以下";
								}elseif($config['resume_salarytype']==3){
								$zd_list[$key][job_salary] = "1K以下";
								}elseif($config['resume_salarytype']==4){
								$zd_list[$key][job_salary] = "1k以下";
								}
							}else if($value[minsalary]<1000){
								$zd_list[$key][job_salary] =changeSalary($value[maxsalary]);
							}else{
								$zd_list[$key][job_salary] =changeSalary($value[minsalary])."-".changeSalary($value[maxsalary]);
							}
						}
					}elseif($value[minsalary]){
						if($config['resume_salarytype']==1){
						    $zd_list[$key][job_salary] =$value[minsalary]."以上";
						}else{
							$zd_list[$key][job_salary] =changeSalary($value[minsalary])."以上";
						}
					}else{
						$zd_list[$key][job_salary] ="面议";
					}
					
					if($r_uid[$value['uid']][shortname]){
						$zd_list[$key][com_name] =$r_uid[$value['uid']][shortname];
					}
					if(!empty($value[zp_minage]) && !empty($value[zp_maxage])){					   
					    if($value[zp_minage]==$value[zp_maxage]){
					        $zd_list[$key][job_age] = $value[zp_minage]."周岁以上";
					    }else{
					        $zd_list[$key][job_age] = $value[zp_minage]."-".$value[zp_maxage]."周岁";
					    }
					}else if(!empty($value[zp_minage]) && empty($value[zp_maxage])){
					    $zd_list[$key][job_age] = $value[zp_minage]."周岁以上";
					}else{
					     $zd_list[$key][job_age] = 0;
					}
					if($value[zp_num]==0){
					    $zd_list[$key][job_number] = "";
					}else{
					    $zd_list[$key][job_number] = $value[zp_num]." 人";
					}			
					$zd_list[$key][yyzz_status] =$r_uid[$value['uid']][yyzz_status];
					$zd_list[$key][logo] =$r_uid[$value['uid']][logo];
					$zd_list[$key][pr_n] =$r_uid[$value['uid']][pr_n];
					$zd_list[$key][hy_n] =$r_uid[$value['uid']][hy_n];
					$zd_list[$key][mun_n] =$r_uid[$value['uid']][mun_n];
					$zd_list[$key][hotlogo] =$r_uid[$value['uid']][hotlogo];
					$time=$value['lastupdate'];
					//今天开始时间戳
					$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
					//昨天开始时间戳
					$beginYesterday=mktime(0,0,0,date('m'),date('d')-1,date('Y'));
					
					if($time>$beginYesterday && $time<$beginToday){
						$zd_list[$key]['time'] ="昨天";
					}elseif($time>$beginToday){	
						$zd_list[$key]['time'] = $zd_list[$key]['lastupdate'];
						$zd_list[$key]['redtime'] =1;
					}else{
						$zd_list[$key]['time'] = date("Y-m-d",$value['lastupdate']);
					}
    
                     // 前天
    				$beforeYesterday=mktime(0,0,0,date('m'),date('d')-2,date('Y'));

					if($value['sdate']>$beforeYesterday){
						$zd_list[$key]['newtime'] =1;
					}
					//获得福利待遇名称
					if($value[welfare]){
					    $value[welfare] = str_replace(' ', '',$value[welfare]);
						$welfareList = @explode(',',trim($value[welfare]));

						if(!empty($welfareList)){
							$zd_list[$key][welfarename] =array_filter($welfareList);
						}
					}
					//截取公司名称
					if($paramer[comlen]){
						if($r_uid[$value['uid']][shortname]){
							$zd_list[$key][com_n] = mb_substr($r_uid[$value['uid']][shortname],0,$paramer[comlen],"utf-8");
						}else{
							$zd_list[$key][com_n] = mb_substr($value['com_name'],0,$paramer[comlen],"utf-8");
						}
					}
					//截取职位名称
					if($paramer[namelen]){
						if($value['rec_time']>time()){
							$zd_list[$key][name_n] = "<font color='red'>".mb_substr($value['name'],0,$paramer[namelen],"utf-8")."</font>";
						}else{
							$zd_list[$key][name_n] = mb_substr($value['name'],0,$paramer[namelen],"utf-8");
						}
					}else{
						if($value['rec_time']>time()){
							$zd_list[$key]['name_n'] = "<font color='red'>".$value['name']."</font>";
						}else{
							$zd_list[$key][name_n] = $value['name'];
						}
					}
					//构建职位伪静态URL
					$zd_list[$key][job_url] = Url("job",array("c"=>"comapply","id"=>$value[id]),"1");
					//构建企业伪静态URL
					$zd_list[$key][com_url] = Url("company",array("c"=>"show","id"=>$value[uid]));
					
					foreach($comrat as $k=>$v){
						if($value[rating]==$v[id]){
							$zd_list[$key][color] = str_replace("#","",$v[com_color]);
							if($v[com_pic]){
								$zd_list[$key][ratlogo] = checkpic($v[com_pic]);
							}
							$zd_list[$key][ratname] = $v[name];
						}
					}
					if($paramer[keyword]){
						$zd_list[$key][name]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$value[name]);
						$zd_list[$key][name_n]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$zd_list[$key][name_n]);
						$zd_list[$key][com_n]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$zd_list[$key][com_n]);
						$zd_list[$key][job_city_one]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$city_name[$value[provinceid]]);
						$zd_list[$key][job_city_two]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$city_name[$value[cityid]]);
					}
				}
			}
			if(is_array($zd_list)){
				if($paramer[keyword]!=""&&!empty($zd_list)){
					addkeywords('3',$paramer[keyword]);
				}
			}
		}$zd_list = $zd_list; if (!is_array($zd_list) && !is_object($zd_list)) { settype($zd_list, 'array');}
foreach ($zd_list as $_smarty_tpl->tpl_vars['zd_list']->key => $_smarty_tpl->tpl_vars['zd_list']->value) {
$_smarty_tpl->tpl_vars['zd_list']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['zd_list']->key;
?>
        <div class="search_job_list <?php if ($_smarty_tpl->tpl_vars['key']->value%2!='0') {
}?>">
			<?php if ($_smarty_tpl->tpl_vars['zd_list']->value['newtime']==1) {?><i class="yunjoblist_newicon" title="新职位"> </i><?php }?>
          <div class="yunjoblist_new">
            <div class="yunjoblist_newname"> <a href="<?php echo $_smarty_tpl->tpl_vars['zd_list']->value['job_url'];?>
" class="yunjoblist_newname_a " target="_blank" title="<?php echo $_smarty_tpl->tpl_vars['zd_list']->value['name'];?>
"><?php echo $_smarty_tpl->tpl_vars['zd_list']->value['name_n'];?>
</a><?php if ($_smarty_tpl->tpl_vars['zd_list']->value['urgent_time']>time()) {?><img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/jobjp.png" alt="紧急招聘" class="co_zzjp png" /><?php }?> <?php if ($_smarty_tpl->tpl_vars['zd_list']->value['rec_time']>time()) {?><img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/jobtj.png" alt="站长推荐" class="co_zzjp png" /><?php }?>   </div>
         
            <div class="yunjoblist_newcomename"><a href="<?php echo $_smarty_tpl->tpl_vars['zd_list']->value['com_url'];?>
" target="_blank" class="search_job_com_name" title="<?php echo $_smarty_tpl->tpl_vars['zd_list']->value['com_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['zd_list']->value['com_n'];?>
</a><?php if ($_smarty_tpl->tpl_vars['zd_list']->value['hotlogo']==1) {?> <img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/firm_icon.png" alt="名企" class="png"><?php }?> <?php if ($_smarty_tpl->tpl_vars['zd_list']->value['ratlogo']!=''&&$_smarty_tpl->tpl_vars['zd_list']->value['ratlogo']!="0") {?><img src="<?php echo $_smarty_tpl->tpl_vars['zd_list']->value['ratlogo'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['zd_list']->value['ratname'];?>
" width="16"  /><?php }
if ($_smarty_tpl->tpl_vars['zd_list']->value['yyzz_status']=='1') {?> <img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/disc_icon10.png" alt="企业资质已审核" class="png" width="16"> <?php }?></div>
       <a href="javascript:;" pid="<?php echo $_smarty_tpl->tpl_vars['zd_list']->value['id'];?>
" class="yunjoblist_new_icon <?php if ($_GET['jobtype']!='1') {?>yunjoblist_new_icon_cur<?php }?>" title="<?php if ($_GET['jobtype']!='1') {?>收起<?php } else { ?>展开<?php }?>"></a> </div>
            <!-----详细部分----------> 
          <div class="jobshow <?php if ($_GET['jobtype']=='1') {?>none<?php }?>" id="jobshow<?php echo $_smarty_tpl->tpl_vars['zd_list']->value['id'];?>
">
            <div class="search_job_left_siaber">
              <div class="company_det">    <span class="search_job_l_xz"><?php echo $_smarty_tpl->tpl_vars['zd_list']->value['job_salary'];?>
</span><span class="search_job_list_box_line">|</span><span class="search_job_list_box_s"><em class="com_search_job_em"><?php echo $_smarty_tpl->tpl_vars['zd_list']->value['job_city_one'];?>
-<?php echo $_smarty_tpl->tpl_vars['zd_list']->value['job_city_two'];?>
</em></span>  <?php if ($_smarty_tpl->tpl_vars['zd_list']->value['job_exp']) {?><span class="search_job_list_box_line">|</span><span class="search_job_list_box_s"><em class="com_search_job_em"><?php echo $_smarty_tpl->tpl_vars['zd_list']->value['job_exp'];?>
经验</em> </span> <span class="search_job_list_box_line">|</span><?php }?>
                <?php if ($_smarty_tpl->tpl_vars['zd_list']->value['job_edu']) {?><span class="search_job_list_box_s"><em class="com_search_job_em"><?php echo $_smarty_tpl->tpl_vars['zd_list']->value['job_edu'];?>
学历 </em></span> <?php }?>  </div>
            
              
              </div>
            <div class="company_det_c_name">
              <div class="company_det_hy">
                <div class=""><?php echo $_smarty_tpl->tpl_vars['zd_list']->value['hy_n'];?>
<i class="company_det_hy_line">|</i><?php echo $_smarty_tpl->tpl_vars['zd_list']->value['pr_n'];?>
<i class="company_det_hy_line">|</i><?php echo $_smarty_tpl->tpl_vars['zd_list']->value['mun_n'];?>
</div>
              </div>
        </div>
            <div class="yun_joblist_ope"> <?php if (in_array($_smarty_tpl->tpl_vars['zd_list']->value['id'],$_smarty_tpl->tpl_vars['useridjob']->value)) {?> <a href="<?php echo smarty_function_url(array('m'=>'job','c'=>'comapply','id'=>'`$zd_list.id`'),$_smarty_tpl);?>
" target="_blank" class="search_job_Apply_fast_ysq">已申请</a> <?php } else { ?> <a href="<?php echo smarty_function_url(array('m'=>'job','c'=>'comapply','id'=>'`$zd_list.id`'),$_smarty_tpl);?>
" target="_blank" class="search_job_Apply_fast">申请</a> <?php }?>
            
            </div>
          <div class="job_bottom">
          				  <div class="job_bottomleft">
          			            <?php if ($_smarty_tpl->tpl_vars['zd_list']->value['welfarename']) {?>
          			            <div class="job_welfare_tag"> <?php  $_smarty_tpl->tpl_vars['waflist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['waflist']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['zd_list']->value['welfarename']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['waflist']->key => $_smarty_tpl->tpl_vars['waflist']->value) {
$_smarty_tpl->tpl_vars['waflist']->_loop = true;
?> <span class="job_welfare_tag_s"><?php echo $_smarty_tpl->tpl_vars['waflist']->value;?>
</span> <?php } ?> </div>
          			            <?php } else { ?>
          			            <div class="job_describe_p"> <?php if ($_smarty_tpl->tpl_vars['zd_list']->value['job_number']) {?><span class="job_describe_p_s">招聘<?php echo $_smarty_tpl->tpl_vars['zd_list']->value['job_number'];?>
</span><?php }?> <?php if ($_smarty_tpl->tpl_vars['zd_list']->value['job_age']) {?> <span class="job_describe_p_s">年龄<?php echo $_smarty_tpl->tpl_vars['zd_list']->value['job_age'];?>
</span><?php }?> <?php if ($_smarty_tpl->tpl_vars['zd_list']->value['sex_n']) {?><span class="job_describe_p_s">性别<?php echo $_smarty_tpl->tpl_vars['zd_list']->value['sex_n'];?>
</span><?php }?> </div>
          			            <?php }?> 
                        </div>	
          			   <div class="job_bottomcont">
          								<?php if ($_smarty_tpl->tpl_vars['config']->value['sy_h5_share']==1) {?>
          												<a href="javascript:;" purl="<?php echo smarty_function_url(array('m'=>'ajax','c'=>'pubqrcode','toc'=>'job','toa'=>'share','toid'=>$_smarty_tpl->tpl_vars['zd_list']->value['id']),$_smarty_tpl);?>
" class="yunjoblist_newwxbth">微信扫一扫快速求职</a></div>
          								<?php } else { ?>
          												<a href="javascript:;" purl="<?php echo smarty_function_url(array('m'=>'ajax','c'=>'pubqrcode','toc'=>'job','toa'=>'view','toid'=>$_smarty_tpl->tpl_vars['zd_list']->value['id']),$_smarty_tpl);?>
" class="yunjoblist_newwxbth">微信扫一扫快速求职</a></div>
          								<?php }?>
          							
          			
          			    <span class="yunjoblist_new_time">  <span style="color:#2778f8;">置顶</span> </span>
          			   
          			   
          			   </div>
          </div>
            <!-----详细部分 end----------> 
               <?php if (in_array($_smarty_tpl->tpl_vars['zd_list']->value['id'],$_smarty_tpl->tpl_vars['lookJobIds']->value)) {?>
              <div class="lookjob">浏览过</div>
              <?php }?>
        </div>
        <?php } ?> 
        <?php }?> 
        
        <!-----竞价置顶end----------> 
        
        <?php  $_smarty_tpl->tpl_vars['job_list'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['job_list']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
global $db,$db_config,$config;
		$time = time();
		
		
		//可以做缓存
        $paramer=array("namelen"=>"30","comlen"=>"30","noids"=>"1","ispage"=>"1","report"=>"'auto.report'","welfare"=>"'auto.welfare'","rec"=>"'auto.rec'","hy"=>"'auto.hy'","job1"=>"'auto.job1'","job1_son"=>"'auto.job1_son'","job_post"=>"'auto.job_post'","jobids"=>"'auto.jobids'","pr"=>"'auto.pr'","mun"=>"'auto.mun'","provinceid"=>"'auto.provinceid'","cityid"=>"'auto.cityid'","ltype"=>"'auto.ltype'","three_cityid"=>"'auto.three_cityid'","type"=>"'auto.type'","edu"=>"'auto.edu'","exp"=>"'auto.exp'","sex"=>"'auto.sex'","minsalary"=>"'auto.minsalary'","maxsalary"=>"'auto.maxsalary'","keyword"=>"'auto.keyword'","key"=>"'key'","sdate"=>"'auto.sdate'","cert"=>"'auto.cert'","urgent"=>"'auto.urgent'","uptime"=>"'auto.uptime'","order"=>"'auto.order'","limit"=>"20","item"=>"'job_list'","name"=>"'joblist1'","nocache"=>"")
;
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
        $Purl =  $ParamerArr[purl];
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }
		include_once  PLUS_PATH."/comrating.cache.php";
		include(CONFIG_PATH."db.data.php"); 
		if($config[sy_web_site]=="1"){
			if($config[province]>0 && $config[province]!=""){
				$paramer[provinceid] = $config[province];
			}
			if($config[cityid]>0 && $config[cityid]!=""){
				$paramer[cityid] = $config[cityid];
			}
			if($config[three_cityid]>0 && $config[three_cityid]!=""){
				$paramer[three_cityid] = $config[three_cityid];
			}
			if($config[hyclass]>0 && $config[hyclass]!=""){
				$paramer[hy]=$config[hyclass];
			}
		}

		
		if($paramer[sdate]){
			$where = "`sdate`>".strtotime("-".intval($paramer[sdate])." day",time())." and `state`=1";
		}else{
			$where = "`state`=1";
		}
		
		//按照UID来查询（按公司地址查询可用GET[id]获取当前公司ID）
		if($paramer[uid]){
			$where .= " AND `uid` = '$paramer[uid]'";
		}
		if($paramer[com_id]){
			$where .= " AND `uid` = '$paramer[com_id]'";
		}

		//是否推荐职位
		if($paramer[rec]){
			
			$where.=" AND `rec_time`>=".time();
			
		}
		//企业认证条件
		if($paramer['cert']){
			$job_uid=array();
			$company=$db->select_all("company","`yyzz_status`=1","`uid`");
			if(is_array($company)){
				foreach($company as $v){
					$job_uid[]=$v['uid'];
				}
			}
			$where.=" and `uid` in (".@implode(",",$job_uid).")";
		}
		//取不包含当前企业的职位
		if($paramer[nouid]){
			$where.= " and `uid`<>$paramer[nouid]";
		}
		//取不包含当前id的职位
		if($paramer[noid]){
			$where.= " and `id`<>$paramer[noid]";
		}
		//是否被锁定
		if($paramer[r_status]){
			$where.= " and `r_status`=2";
		}else{
			$where.= " and `r_status`=1";
		}
		//是否下架职位
		if($paramer[status]){
			$where.= " and `status`='1'";
		}else{
			$where.= " and `status`='0'";
		}
		//公司体制
		if($paramer[pr]){
			$where .= " AND `pr` =$paramer[pr]";
		}
		//公司行业分类
		if($paramer['hy']){
			$where .= " AND `hy` = $paramer[hy]";
		} 
		//职位大类
		if($paramer[job1]){
			$where .= " AND `job1` = $paramer[job1]";
		}
		//职位子类
		if($paramer[job1_son]){
			$where .= " AND `job1_son` = $paramer[job1_son]";
		}
		//职位三级分类
		if($paramer[job_post]){
			$where .= " AND (`job_post` IN ($paramer[job_post]))";
		}
		//您可能感兴趣的职位--个人会员中心
		if($paramer['jobwhere']){
			$where .=" and ".$paramer['jobwhere'];
		}
		//职位分类综合查询
		if($paramer['jobids']){
			$where.= " AND (`job1` = '$paramer[jobids]' OR `job1_son`= '$paramer[jobids]' OR `job_post`='$paramer[jobids]')";
		}
		//职位分类区间,不建议执行该查询
		if($paramer['jobin']){
			$where .= " AND (`job1` IN ($paramer[jobin]) OR `job1_son` IN ($paramer[jobin]) OR `job_post` IN ($paramer[jobin]))";
		}
		//城市大类
		if($paramer[provinceid]){
			$where .= " AND `provinceid` = $paramer[provinceid]";
		}
		//城市子类
		if($paramer['cityid']){
			$where .= " AND (`cityid` IN ($paramer[cityid]))";
		}
		//城市三级子类
		if($paramer['three_cityid']){
			$where .= " AND (`three_cityid` IN ($paramer[three_cityid]))";
		}
		if($paramer['cityin']){
			$where .= " AND `three_cityid` IN ($paramer[cityin])";
		}
		//学历
		if($paramer[edu]){
		    
		    $eduKey =   $db->DB_select_once("comclass", "`variable` = 'job_edu'", "`id`");
		    $eduReq =   $db->DB_select_once("comclass", "`id` = $paramer[edu]", "`sort`,`name`");
		    if($eduReq[name] != "不限"){
		    
                $eduArr =   $db->select_all("comclass", "`keyid` = $eduKey[id] AND `sort` <= $eduReq[sort]", "`id`");
                $eduIds =   array();
                foreach($eduArr as $v){
                    $eduIds[]   =   $v[id];
                }
                
                $where .= " AND `edu` in (".@implode(",",$eduIds).")";
			}
		}
		//工作经验
		if($paramer[exp]){
		
		    $expKey =   $db->DB_select_once("comclass", "`variable` = 'job_exp'", "`id`");
		    $expReq =   $db->DB_select_once("comclass",  "`id` = $paramer[exp]", "`sort`,`name`");
		    if($expReq[name] != "不限"){
		    
                $expArr =   $db->select_all("comclass", "`keyid` = $expKey[id] AND `sort` <= $expReq[sort]", "`id`");
                $expIds =   array();
                foreach($expArr as $v){
                    $expIds[]   =   $v[id];
                }
			    $where .= " AND `exp` in (".@implode(",",$expIds).")";
	        }
		}
		//到岗时间
		if($paramer[report]){
			$where .= " AND `report` = $paramer[report]";
		}
		//职位性质
		if($paramer[type]){
			$where .= " AND `type` = $paramer[type]";
		}
		//性别
		if($paramer[sex]){
			$where .= " AND `sex` = $paramer[sex]";
		}
		//应届生
		if($paramer[is_graduate]){
			$where .= " AND `is_graduate` = $paramer[is_graduate]";
		}
		//公司规模
		if($paramer[mun]){
			$where .= " AND `mun` = $paramer[mun]";
		}
		 
		if($paramer[minsalary] && $paramer[maxsalary]){
			$where.= " AND (`minsalary`>=".intval($paramer[minsalary])." and `minsalary`<=".intval($paramer[maxsalary])." and `maxsalary`<=".intval($paramer[maxsalary]).") ";

		}elseif($paramer[minsalary]&&!$paramer[maxsalary]){
			$where.= " AND (`minsalary`>=".intval($paramer[minsalary]).") ";

		}elseif(!$paramer[minsalary]&&$paramer[maxsalary]){
			$where.= " AND (`minsalary`<=".intval($paramer[maxsalary])." and `maxsalary`<=".intval($paramer[maxsalary]).") ";
		}

	    //福利待遇
	    $cache_array = $db->cacheget();
		$comclass_name = $cache_array["comclass_name"];
		if($paramer[welfare]){
			$welfarename=$comclass_name[$paramer[welfare]];
            $where .=" AND `welfare` LIKE '%".$welfarename."%' ";
		}
		
		//城市区间,不建议执行该查询
		if($paramer[cityin]){
			$where .= " AND (`provinceid` IN ($paramer[cityin]) OR `cityid` IN ($paramer[cityin]) OR `three_cityid` IN ($paramer[cityin]))";
		}
		//紧急招聘urgent
		if($paramer[urgent]){
			$where.=" AND `urgent_time`>".time();
		}
		//更新时间区间
		if($paramer[uptime]){
			if($paramer[uptime]==1){
				$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
				$where.=" AND lastupdate>$beginToday";
			}else{
				$time=time();
				$uptime = $time-($paramer[uptime]*86400);
				$where.=" AND lastupdate>$uptime";
			}
		}else{
		    if($config[sy_datacycle]>0){	
                // 后台-页面设置-数据周期	        
				$uptime = strtotime('-'.$config[sy_datacycle].' day');
				$where.=" AND lastupdate>$uptime";
		    }
		}		
		//按类似公司名称,不建议进行大数据量操作
		if($paramer[comname]){
			$where.=" AND `com_name` LIKE '%".$paramer[comname]."%'";
		}
		//按公司归属地,只适合查询一级城市分类
		if($paramer[com_pro]){
			$where.=" AND `com_provinceid` ='".$paramer[com_pro]."'";
		}
		//按照职位名称匹配
		if($paramer[keyword]){
			$where1[]="`name` LIKE '%".$paramer[keyword]."%'";
			$where1[]="`com_name` LIKE '%".$paramer[keyword]."%'";
			include  PLUS_PATH."/city.cache.php";
			foreach($city_name as $k=>$v){
				if(strpos($v,$paramer[keyword])!==false){
					$cityid[]=$k;
				}
			}
			if(is_array($cityid)){
				foreach($cityid as $value){
					$class[]= "(provinceid = '".$value."' or cityid = '".$value."')";
				}
				$where1[]=@implode(" or ",$class);
			}
			$where.=" AND (".@implode(" or ",$where1).")";
		}

		//多选职位
		if($paramer["job"]){
			$where.=" AND `job_post` in ($paramer[job])";
		}
		//置顶招聘
		if($paramer[bid]){
			if($config[joblist_top]!=1){
				$paramer[limit] = 5;
			}
			$where.="  and `xsdate`>'".time()."'";
		} 
		
		//自定义查询条件，默认取代上面任何参数直接使用该语句
		if($paramer[where]){
			$where = $paramer[where];
		}

		//查询条数
		$limit = '';
		if($paramer[limit]){

			$limit = " limit ".$paramer[limit];
		}
		if($paramer[ispage]){
			$limit = PageNav($paramer,$_GET,"company_job",$where,$Purl,"",$paramer[islt]?$paramer[islt]:"6",$_smarty_tpl);        
		}

		//排序字段默认为更新时间
		//置顶设置为随机5条时，随机查询
		if($paramer[bid] && $paramer[limit]){
			$order = " ORDER BY rand() ";
		}else{
			if($paramer[order] && $paramer[order]!="lastdate"){
				$order = " ORDER BY ".str_replace("'","",$paramer[order])."  ";
			}else{
				$order = " ORDER BY `lastupdate` ";
			}
		}
		//排序规则 默认为倒序
		if($paramer[sort]){
			$sort = $paramer[sort];
		}else{
			$sort = " DESC";
		} 
		$where.=$order.$sort;
		
		$job_list = $db->select_all("company_job",$where.$limit);

		if(is_array($job_list) && !empty($job_list)){
			//处理类别字段
			$cache_array = $db->cacheget();
			$comuid=$jobid=array();
			foreach($job_list as $key=>$value){
				if(in_array($value['uid'],$comuid)==false){$comuid[] = $value['uid'];}
				if(in_array($value['id'],$jobid)==false){$jobid[] = $value['id'];} 
			}
			$comuids = @implode(',',$comuid);
			$jobids = @implode(',',$jobid);
			//减少曝光量统计维度 只有列表才统计
			if($paramer[ispage]){
				$db->update_all("company_job", "`jobexpoure` = `jobexpoure` + 1", "`id` in ($jobids)");
			}
			

			if($comuids){
				$r_uids=$db->select_all("company","`uid` IN (".$comuids.")","`uid`,`yyzz_status`,`logo`,`logo_status`,`pr`,`hy`,`mun`,`shortname`,`welfare`,`hotstart`,`hottime`");
				if(is_array($r_uids)){
					foreach($r_uids as $key=>$value){
						if($value[shortname]){
    						$value['shortname_n'] = $value[shortname];
    					}
						if(!$value['logo'] || $value['logo_status']!=0){
							$value['logo'] = checkpic("",$config['sy_unit_icon']);
						}else{
							$value['logo']= checkpic($value['logo']);
						}
						$value['pr_n'] = $cache_array['comclass_name'][$value[pr]];
						$value['hy_n'] = $cache_array['industry_name'][$value[hy]];
						$value['mun_n'] = $cache_array['comclass_name'][$value[mun]];
						if($value['hotstart']<=time() && $value['hottime']>=time()){
							$value['hotlogo'] = 1;
						}
						$r_uid[$value['uid']] = $value;
					}
				}
			}
			
 			if($paramer[bid]){
				$noids=array();
			}	
			foreach($job_list as $key=>$value){

				if($paramer[bid]){
					$noids[] = $value[id];
				}
				//筛除重复
				if($paramer[noids]==1 && !empty($noids) && in_array($value['id'],$noids)){
					unset($job_list[$key]);
					continue;
				}else{
					$job_list[$key] = $db->array_action($value,$cache_array);
					$job_list[$key][stime] = date("Y-m-d",$value[sdate]);
					$job_list[$key][etime] = date("Y-m-d",$value[edate]);
					if($arr_data['sex'][$value['sex']]){
						$job_list[$key][sex_n]=$arr_data['sex'][$value['sex']];
					}
					$job_list[$key][lastupdate] =lastupdateStyle($value[lastupdate]);
					if($value[minsalary]&&$value[maxsalary]){
						if($config['resume_salarytype']==1){
								$job_list[$key][job_salary] =$value[minsalary]."-".$value[maxsalary];
						}else{
							if($value[maxsalary]<1000){
								if($config['resume_salarytype']==2){
									$job_list[$key][job_salary] = "1千以下";
								}elseif($config['resume_salarytype']==3){
								$job_list[$key][job_salary] = "1K以下";
								}elseif($config['resume_salarytype']==4){
								$job_list[$key][job_salary] = "1k以下";
								}
							}else if($value[minsalary]<1000){
								$job_list[$key][job_salary] =changeSalary($value[maxsalary]);
							}else{
								$job_list[$key][job_salary] =changeSalary($value[minsalary])."-".changeSalary($value[maxsalary]);
							}
						}
					}elseif($value[minsalary]){
						if($config['resume_salarytype']==1){
						    $job_list[$key][job_salary] =$value[minsalary]."以上";
						}else{
							$job_list[$key][job_salary] =changeSalary($value[minsalary])."以上";
						}
					}else{
						$job_list[$key][job_salary] ="面议";
					}
					
					if($r_uid[$value['uid']][shortname]){
						$job_list[$key][com_name] =$r_uid[$value['uid']][shortname];
					}
					if(!empty($value[zp_minage]) && !empty($value[zp_maxage])){					   
					    if($value[zp_minage]==$value[zp_maxage]){
					        $job_list[$key][job_age] = $value[zp_minage]."周岁以上";
					    }else{
					        $job_list[$key][job_age] = $value[zp_minage]."-".$value[zp_maxage]."周岁";
					    }
					}else if(!empty($value[zp_minage]) && empty($value[zp_maxage])){
					    $job_list[$key][job_age] = $value[zp_minage]."周岁以上";
					}else{
					     $job_list[$key][job_age] = 0;
					}
					if($value[zp_num]==0){
					    $job_list[$key][job_number] = "";
					}else{
					    $job_list[$key][job_number] = $value[zp_num]." 人";
					}			
					$job_list[$key][yyzz_status] =$r_uid[$value['uid']][yyzz_status];
					$job_list[$key][logo] =$r_uid[$value['uid']][logo];
					$job_list[$key][pr_n] =$r_uid[$value['uid']][pr_n];
					$job_list[$key][hy_n] =$r_uid[$value['uid']][hy_n];
					$job_list[$key][mun_n] =$r_uid[$value['uid']][mun_n];
					$job_list[$key][hotlogo] =$r_uid[$value['uid']][hotlogo];
					$time=$value['lastupdate'];
					//今天开始时间戳
					$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
					//昨天开始时间戳
					$beginYesterday=mktime(0,0,0,date('m'),date('d')-1,date('Y'));
					
					if($time>$beginYesterday && $time<$beginToday){
						$job_list[$key]['time'] ="昨天";
					}elseif($time>$beginToday){	
						$job_list[$key]['time'] = $job_list[$key]['lastupdate'];
						$job_list[$key]['redtime'] =1;
					}else{
						$job_list[$key]['time'] = date("Y-m-d",$value['lastupdate']);
					}
    
                     // 前天
    				$beforeYesterday=mktime(0,0,0,date('m'),date('d')-2,date('Y'));

					if($value['sdate']>$beforeYesterday){
						$job_list[$key]['newtime'] =1;
					}
					//获得福利待遇名称
					if($value[welfare]){
					    $value[welfare] = str_replace(' ', '',$value[welfare]);
						$welfareList = @explode(',',trim($value[welfare]));

						if(!empty($welfareList)){
							$job_list[$key][welfarename] =array_filter($welfareList);
						}
					}
					//截取公司名称
					if($paramer[comlen]){
						if($r_uid[$value['uid']][shortname]){
							$job_list[$key][com_n] = mb_substr($r_uid[$value['uid']][shortname],0,$paramer[comlen],"utf-8");
						}else{
							$job_list[$key][com_n] = mb_substr($value['com_name'],0,$paramer[comlen],"utf-8");
						}
					}
					//截取职位名称
					if($paramer[namelen]){
						if($value['rec_time']>time()){
							$job_list[$key][name_n] = "<font color='red'>".mb_substr($value['name'],0,$paramer[namelen],"utf-8")."</font>";
						}else{
							$job_list[$key][name_n] = mb_substr($value['name'],0,$paramer[namelen],"utf-8");
						}
					}else{
						if($value['rec_time']>time()){
							$job_list[$key]['name_n'] = "<font color='red'>".$value['name']."</font>";
						}else{
							$job_list[$key][name_n] = $value['name'];
						}
					}
					//构建职位伪静态URL
					$job_list[$key][job_url] = Url("job",array("c"=>"comapply","id"=>$value[id]),"1");
					//构建企业伪静态URL
					$job_list[$key][com_url] = Url("company",array("c"=>"show","id"=>$value[uid]));
					
					foreach($comrat as $k=>$v){
						if($value[rating]==$v[id]){
							$job_list[$key][color] = str_replace("#","",$v[com_color]);
							if($v[com_pic]){
								$job_list[$key][ratlogo] = checkpic($v[com_pic]);
							}
							$job_list[$key][ratname] = $v[name];
						}
					}
					if($paramer[keyword]){
						$job_list[$key][name]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$value[name]);
						$job_list[$key][name_n]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$job_list[$key][name_n]);
						$job_list[$key][com_n]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$job_list[$key][com_n]);
						$job_list[$key][job_city_one]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$city_name[$value[provinceid]]);
						$job_list[$key][job_city_two]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$city_name[$value[cityid]]);
					}
				}
			}
			if(is_array($job_list)){
				if($paramer[keyword]!=""&&!empty($job_list)){
					addkeywords('3',$paramer[keyword]);
				}
			}
		}$job_list = $job_list; if (!is_array($job_list) && !is_object($job_list)) { settype($job_list, 'array');}
foreach ($job_list as $_smarty_tpl->tpl_vars['job_list']->key => $_smarty_tpl->tpl_vars['job_list']->value) {
$_smarty_tpl->tpl_vars['job_list']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['job_list']->key;
?>
        <div class="search_job_list <?php if ($_smarty_tpl->tpl_vars['key']->value%2!='0') {
}?>"> 
         <?php if ($_smarty_tpl->tpl_vars['job_list']->value['newtime']==1) {?><i class="yunjoblist_newicon" title="新职位"> </i><?php }?>
          <div class="yunjoblist_new">
            <div class="yunjoblist_newname"><a href="<?php echo $_smarty_tpl->tpl_vars['job_list']->value['job_url'];?>
" class="yunjoblist_newname_a" target="_blank" title="<?php echo $_smarty_tpl->tpl_vars['job_list']->value['name'];?>
"><?php echo $_smarty_tpl->tpl_vars['job_list']->value['name_n'];?>
</a> <?php if ($_smarty_tpl->tpl_vars['job_list']->value['urgent_time']>time()) {?><img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/jobjp.png" alt="紧急招聘" class="co_zzjp png" /><?php }?> <?php if ($_smarty_tpl->tpl_vars['job_list']->value['rec_time']>time()) {?><img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/jobtj.png" alt="站长推荐" class="co_zzjp png" /><?php }?> </div>
           
            <div class="yunjoblist_newcomename"><a href="<?php echo $_smarty_tpl->tpl_vars['job_list']->value['com_url'];?>
" target="_blank" class="search_job_com_name" title="<?php echo $_smarty_tpl->tpl_vars['job_list']->value['com_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['job_list']->value['com_n'];?>
</a><?php if ($_smarty_tpl->tpl_vars['job_list']->value['hotlogo']==1) {?> <img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/firm_icon.png" alt="名企" class="png"><?php }?> <?php if ($_smarty_tpl->tpl_vars['job_list']->value['ratlogo']!=''&&$_smarty_tpl->tpl_vars['job_list']->value['ratlogo']!="0") {?><img src="<?php echo $_smarty_tpl->tpl_vars['job_list']->value['ratlogo'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['job_list']->value['ratname'];?>
" width="16" /><?php }?> <?php if ($_smarty_tpl->tpl_vars['job_list']->value['yyzz_status']=='1') {?> <img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/disc_icon10.png" alt="企业资质已审核" class="png" width="16"> <?php }?></div>
            <a href="javascript:;" pid="<?php echo $_smarty_tpl->tpl_vars['job_list']->value['id'];?>
" class="yunjoblist_new_icon <?php if ($_GET['jobtype']!='1') {?>yunjoblist_new_icon_cur<?php }?>" title="<?php if ($_GET['jobtype']!='1') {?>收起<?php } else { ?>展开<?php }?>"></a></div>
               <!-----详细部分----------> 
          <div class="jobshow <?php if ($_GET['jobtype']=='1') {?>none<?php }?>" id="jobshow<?php echo $_smarty_tpl->tpl_vars['job_list']->value['id'];?>
">
            <div class="search_job_left_siaber">
              <div class="company_det">  <span class="search_job_l_xz"><?php echo $_smarty_tpl->tpl_vars['job_list']->value['job_salary'];?>
</span><span class="search_job_list_box_line">|</span><span class="search_job_list_box_s"><em class="com_search_job_em"><?php echo $_smarty_tpl->tpl_vars['job_list']->value['job_city_one'];?>
-<?php echo $_smarty_tpl->tpl_vars['job_list']->value['job_city_two'];?>
</em></span><?php if ($_smarty_tpl->tpl_vars['job_list']->value['job_exp']) {?> <span class="search_job_list_box_line">|</span> <span class="search_job_list_box_s"><em class="com_search_job_em"><?php echo $_smarty_tpl->tpl_vars['job_list']->value['job_exp'];?>
经验</em> </span><span class="search_job_list_box_line">|</span><?php }?>
                <?php if ($_smarty_tpl->tpl_vars['job_list']->value['job_edu']) {?><span class="search_job_list_box_s"><em class="com_search_job_em"><?php echo $_smarty_tpl->tpl_vars['job_list']->value['job_edu'];?>
学历 </em></span> <?php }?>  
          </div>
             
            
               </div>
            <div class="company_det_c_name">
              <div class="company_det_hy">
                <div class=""><?php echo $_smarty_tpl->tpl_vars['job_list']->value['hy_n'];
if ($_smarty_tpl->tpl_vars['job_list']->value['pr_n']) {?><i class="company_det_hy_line">|</i><?php echo $_smarty_tpl->tpl_vars['job_list']->value['pr_n'];
}
if ($_smarty_tpl->tpl_vars['job_list']->value['mun_n']) {?><i class="company_det_hy_line">|</i><?php echo $_smarty_tpl->tpl_vars['job_list']->value['mun_n'];
}?></div>
              </div>
             
            </div>
            <div class="yun_joblist_ope"> <?php if (in_array($_smarty_tpl->tpl_vars['job_list']->value['id'],$_smarty_tpl->tpl_vars['useridjob']->value)) {?> <a href="<?php echo smarty_function_url(array('m'=>'job','c'=>'comapply','id'=>'`$job_list.id`'),$_smarty_tpl);?>
" target="_blank" class="search_job_Apply_fast_ysq">已申请</a> <?php } else { ?> <a href="<?php echo smarty_function_url(array('m'=>'job','c'=>'comapply','id'=>'`$job_list.id`'),$_smarty_tpl);?>
" target="_blank" class="search_job_Apply_fast ">申请</a> <?php }?>
            <!--   <div class="yun_job_operation_d"> <?php if ($_smarty_tpl->tpl_vars['uid']->value) {?>
                <?php if ($_smarty_tpl->tpl_vars['usertype']->value==1) {?> 
               <?php if (in_array($_smarty_tpl->tpl_vars['job_list']->value['id'],$_smarty_tpl->tpl_vars['favjob']->value)) {?> <a href="javascript:fav_job('<?php echo $_smarty_tpl->tpl_vars['job_list']->value['id'];?>
','1');" class="yun_job_operation_ysc">已收藏</a> <?php } else { ?> <a href="javascript:fav_job('<?php echo $_smarty_tpl->tpl_vars['job_list']->value['id'];?>
','1');" class="yun_job_operation_sc scjobid<?php echo $_smarty_tpl->tpl_vars['job_list']->value['id'];?>
">收藏</a> <?php }?>
                <?php } else { ?> 
                  <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_user_change']==1) {?>
                    <a href="javascript:void(0);" onclick="layer.msg('请先申请个人用户才能收藏职位', 2, 8)" class="yun_job_operation_sc" rel="nofollow">收藏</a> 
                  <?php } else { ?> 
                    <a href="javascript:void(0);" onclick="layer.msg('只有个人用户才能收藏', 2, 8)" class="yun_job_operation_sc" rel="nofollow">收藏</a> 
                  <?php }?>
                
                <?php }?>
                <?php } else { ?> <a href="javascript:void(0);" onclick="showlogin('1');" class="yun_job_operation_sc" rel="nofollow">收藏</a> <?php }?>
				
				 </div> -->
            </div>
              <?php if (in_array($_smarty_tpl->tpl_vars['job_list']->value['id'],$_smarty_tpl->tpl_vars['lookJobIds']->value)) {?>
              <div class="lookjob">浏览过</div>
              <?php }?>
			  <div class="job_bottom">
				  <div class="job_bottomleft">
			  <?php if ($_smarty_tpl->tpl_vars['job_list']->value['welfarename']) {?>
              <div class="job_welfare_tag"> <?php  $_smarty_tpl->tpl_vars['waflist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['waflist']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['job_list']->value['welfarename']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['waflist']->key => $_smarty_tpl->tpl_vars['waflist']->value) {
$_smarty_tpl->tpl_vars['waflist']->_loop = true;
?> <span class="job_welfare_tag_s"><?php echo $_smarty_tpl->tpl_vars['waflist']->value;?>
</span> <?php } ?> </div>
              <?php } else { ?>
             
			   <div class="job_welfare_tag">
			   <?php if ($_smarty_tpl->tpl_vars['job_list']->value['job_number']) {?><span class="job_welfare_tag_s">招聘<?php echo $_smarty_tpl->tpl_vars['job_list']->value['job_number'];?>
</span><?php }?> <?php if ($_smarty_tpl->tpl_vars['job_list']->value['job_age']) {?> <span class="job_welfare_tag_s">年龄<?php echo $_smarty_tpl->tpl_vars['job_list']->value['job_age'];?>
</span><?php }?> <?php if ($_smarty_tpl->tpl_vars['job_list']->value['sex_n']) {?> <span class="job_welfare_tag_s">性别<?php echo $_smarty_tpl->tpl_vars['job_list']->value['sex_n'];?>
</span><?php }?> </div>
              <?php }?></div>	
			   <div class="job_bottomcont">
				<?php if ($_smarty_tpl->tpl_vars['config']->value['sy_h5_share']==1) {?>
					<a href="javascript:;" purl="<?php echo smarty_function_url(array('m'=>'ajax','c'=>'pubqrcode','toc'=>'job','toa'=>'share','toid'=>$_smarty_tpl->tpl_vars['job_list']->value['id']),$_smarty_tpl);?>
" class="yunjoblist_newwxbth">微信扫一扫快速求职</a>
				<?php } else { ?>
					<a href="javascript:;" purl="<?php echo smarty_function_url(array('m'=>'ajax','c'=>'pubqrcode','toc'=>'job','toa'=>'view','toid'=>$_smarty_tpl->tpl_vars['job_list']->value['id']),$_smarty_tpl);?>
" class="yunjoblist_newwxbth">微信扫一扫快速求职</a>
				<?php }?>
			
			   </div>
			    <span class="yunjoblist_new_time"> <?php if ($_smarty_tpl->tpl_vars['job_list']->value['time']=='昨天'||$_smarty_tpl->tpl_vars['job_list']->value['redtime']=='1') {?> <span style="color:red;"><?php echo $_smarty_tpl->tpl_vars['job_list']->value['time'];?>
</span> <?php } else { ?> <?php echo $_smarty_tpl->tpl_vars['job_list']->value['time'];?>
 <?php }?></span>
			   
			   
			   </div>
			 
			  
			  
          </div>
             <!-----详细部分 end----------> 
        </div>
        <?php } ?> 
        
        <?php if ($_smarty_tpl->tpl_vars['total']->value!=0||is_array($_smarty_tpl->tpl_vars['zd_list']->value)) {?>
        <div class="clear"></div>
        <div class="search_pages">
          <div class="pages"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;
echo $_smarty_tpl->tpl_vars['totalshow']->value;?>
</div>
        </div>
        <input value='<?php echo $_GET['ltype'];?>
' type='hidden' id='ltype' />
        <?php } else { ?> 
        <!--没搜索到-->
        <div class=" new_notip">
          <div class="new_notip_img"><img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/notip.png"  ></div>
          <div class="new_notip_tit">很抱歉，没有找到满足条件的职位</div> 
		  <div class="new_notip_p">建议您适当减少已选择的条件或适当删减或更改搜索关键字</div> 

        </div>
        <?php }?> </div>
    </div>
    <div class="yun_job_list_right">
      <div class="yun_job_list_right_banner"> 
      	<?php  $_smarty_tpl->tpl_vars['adlist_7'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['adlist_7']->_loop = false;
global $db,$db_config,$config;$AdArr=array();$paramer=array();$attr=array("classid"=>"7","limit"=>"5","item"=>"'adlist_7'","nocache"=>"")
;
			include(PLUS_PATH.'pimg_cache.php');$add_arr = $ad_label[7];if(is_array($add_arr) && !empty($add_arr)){
				$i=0;$limit = 5;$length = 0;
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
foreach ($AdArr as $_smarty_tpl->tpl_vars['adlist_7']->key => $_smarty_tpl->tpl_vars['adlist_7']->value) {
$_smarty_tpl->tpl_vars['adlist_7']->_loop = true;
?>
        <?php echo $_smarty_tpl->tpl_vars['adlist_7']->value['html'];?>

        <?php } ?> </div>
      <div class="job_recommendation">
        <div class="job_recommendation_title"><span class="job_recommendation_span"><i class="job_recommendation_span_line"></i>精选职位推荐</span> <?php if ($_smarty_tpl->tpl_vars['recNum']->value>10) {?><a href="javascript:void(0)" onclick="exchange();" class="job_right_box_more png" rel="nofollow">换一组</a><?php }?> </div>
        <ul class="job_recommendation_list">
          <input type="hidden" value='2' id='exchangep' />
          <?php  $_smarty_tpl->tpl_vars['blist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['blist']->_loop = false;
global $db,$db_config,$config;
		$time = time();
		
		
		//可以做缓存
        $paramer=array("namelen"=>"15","comlen"=>"19","rec"=>"1","limit"=>"10","item"=>"'blist'","nocache"=>"")
;
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
        $Purl =  $ParamerArr[purl];
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }
		include_once  PLUS_PATH."/comrating.cache.php";
		include(CONFIG_PATH."db.data.php"); 
		if($config[sy_web_site]=="1"){
			if($config[province]>0 && $config[province]!=""){
				$paramer[provinceid] = $config[province];
			}
			if($config[cityid]>0 && $config[cityid]!=""){
				$paramer[cityid] = $config[cityid];
			}
			if($config[three_cityid]>0 && $config[three_cityid]!=""){
				$paramer[three_cityid] = $config[three_cityid];
			}
			if($config[hyclass]>0 && $config[hyclass]!=""){
				$paramer[hy]=$config[hyclass];
			}
		}

		
		if($paramer[sdate]){
			$where = "`sdate`>".strtotime("-".intval($paramer[sdate])." day",time())." and `state`=1";
		}else{
			$where = "`state`=1";
		}
		
		//按照UID来查询（按公司地址查询可用GET[id]获取当前公司ID）
		if($paramer[uid]){
			$where .= " AND `uid` = '$paramer[uid]'";
		}
		if($paramer[com_id]){
			$where .= " AND `uid` = '$paramer[com_id]'";
		}

		//是否推荐职位
		if($paramer[rec]){
			
			$where.=" AND `rec_time`>=".time();
			
		}
		//企业认证条件
		if($paramer['cert']){
			$job_uid=array();
			$company=$db->select_all("company","`yyzz_status`=1","`uid`");
			if(is_array($company)){
				foreach($company as $v){
					$job_uid[]=$v['uid'];
				}
			}
			$where.=" and `uid` in (".@implode(",",$job_uid).")";
		}
		//取不包含当前企业的职位
		if($paramer[nouid]){
			$where.= " and `uid`<>$paramer[nouid]";
		}
		//取不包含当前id的职位
		if($paramer[noid]){
			$where.= " and `id`<>$paramer[noid]";
		}
		//是否被锁定
		if($paramer[r_status]){
			$where.= " and `r_status`=2";
		}else{
			$where.= " and `r_status`=1";
		}
		//是否下架职位
		if($paramer[status]){
			$where.= " and `status`='1'";
		}else{
			$where.= " and `status`='0'";
		}
		//公司体制
		if($paramer[pr]){
			$where .= " AND `pr` =$paramer[pr]";
		}
		//公司行业分类
		if($paramer['hy']){
			$where .= " AND `hy` = $paramer[hy]";
		} 
		//职位大类
		if($paramer[job1]){
			$where .= " AND `job1` = $paramer[job1]";
		}
		//职位子类
		if($paramer[job1_son]){
			$where .= " AND `job1_son` = $paramer[job1_son]";
		}
		//职位三级分类
		if($paramer[job_post]){
			$where .= " AND (`job_post` IN ($paramer[job_post]))";
		}
		//您可能感兴趣的职位--个人会员中心
		if($paramer['jobwhere']){
			$where .=" and ".$paramer['jobwhere'];
		}
		//职位分类综合查询
		if($paramer['jobids']){
			$where.= " AND (`job1` = '$paramer[jobids]' OR `job1_son`= '$paramer[jobids]' OR `job_post`='$paramer[jobids]')";
		}
		//职位分类区间,不建议执行该查询
		if($paramer['jobin']){
			$where .= " AND (`job1` IN ($paramer[jobin]) OR `job1_son` IN ($paramer[jobin]) OR `job_post` IN ($paramer[jobin]))";
		}
		//城市大类
		if($paramer[provinceid]){
			$where .= " AND `provinceid` = $paramer[provinceid]";
		}
		//城市子类
		if($paramer['cityid']){
			$where .= " AND (`cityid` IN ($paramer[cityid]))";
		}
		//城市三级子类
		if($paramer['three_cityid']){
			$where .= " AND (`three_cityid` IN ($paramer[three_cityid]))";
		}
		if($paramer['cityin']){
			$where .= " AND `three_cityid` IN ($paramer[cityin])";
		}
		//学历
		if($paramer[edu]){
		    
		    $eduKey =   $db->DB_select_once("comclass", "`variable` = 'job_edu'", "`id`");
		    $eduReq =   $db->DB_select_once("comclass", "`id` = $paramer[edu]", "`sort`,`name`");
		    if($eduReq[name] != "不限"){
		    
                $eduArr =   $db->select_all("comclass", "`keyid` = $eduKey[id] AND `sort` <= $eduReq[sort]", "`id`");
                $eduIds =   array();
                foreach($eduArr as $v){
                    $eduIds[]   =   $v[id];
                }
                
                $where .= " AND `edu` in (".@implode(",",$eduIds).")";
			}
		}
		//工作经验
		if($paramer[exp]){
		
		    $expKey =   $db->DB_select_once("comclass", "`variable` = 'job_exp'", "`id`");
		    $expReq =   $db->DB_select_once("comclass",  "`id` = $paramer[exp]", "`sort`,`name`");
		    if($expReq[name] != "不限"){
		    
                $expArr =   $db->select_all("comclass", "`keyid` = $expKey[id] AND `sort` <= $expReq[sort]", "`id`");
                $expIds =   array();
                foreach($expArr as $v){
                    $expIds[]   =   $v[id];
                }
			    $where .= " AND `exp` in (".@implode(",",$expIds).")";
	        }
		}
		//到岗时间
		if($paramer[report]){
			$where .= " AND `report` = $paramer[report]";
		}
		//职位性质
		if($paramer[type]){
			$where .= " AND `type` = $paramer[type]";
		}
		//性别
		if($paramer[sex]){
			$where .= " AND `sex` = $paramer[sex]";
		}
		//应届生
		if($paramer[is_graduate]){
			$where .= " AND `is_graduate` = $paramer[is_graduate]";
		}
		//公司规模
		if($paramer[mun]){
			$where .= " AND `mun` = $paramer[mun]";
		}
		 
		if($paramer[minsalary] && $paramer[maxsalary]){
			$where.= " AND (`minsalary`>=".intval($paramer[minsalary])." and `minsalary`<=".intval($paramer[maxsalary])." and `maxsalary`<=".intval($paramer[maxsalary]).") ";

		}elseif($paramer[minsalary]&&!$paramer[maxsalary]){
			$where.= " AND (`minsalary`>=".intval($paramer[minsalary]).") ";

		}elseif(!$paramer[minsalary]&&$paramer[maxsalary]){
			$where.= " AND (`minsalary`<=".intval($paramer[maxsalary])." and `maxsalary`<=".intval($paramer[maxsalary]).") ";
		}

	    //福利待遇
	    $cache_array = $db->cacheget();
		$comclass_name = $cache_array["comclass_name"];
		if($paramer[welfare]){
			$welfarename=$comclass_name[$paramer[welfare]];
            $where .=" AND `welfare` LIKE '%".$welfarename."%' ";
		}
		
		//城市区间,不建议执行该查询
		if($paramer[cityin]){
			$where .= " AND (`provinceid` IN ($paramer[cityin]) OR `cityid` IN ($paramer[cityin]) OR `three_cityid` IN ($paramer[cityin]))";
		}
		//紧急招聘urgent
		if($paramer[urgent]){
			$where.=" AND `urgent_time`>".time();
		}
		//更新时间区间
		if($paramer[uptime]){
			if($paramer[uptime]==1){
				$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
				$where.=" AND lastupdate>$beginToday";
			}else{
				$time=time();
				$uptime = $time-($paramer[uptime]*86400);
				$where.=" AND lastupdate>$uptime";
			}
		}else{
		    if($config[sy_datacycle]>0){	
                // 后台-页面设置-数据周期	        
				$uptime = strtotime('-'.$config[sy_datacycle].' day');
				$where.=" AND lastupdate>$uptime";
		    }
		}		
		//按类似公司名称,不建议进行大数据量操作
		if($paramer[comname]){
			$where.=" AND `com_name` LIKE '%".$paramer[comname]."%'";
		}
		//按公司归属地,只适合查询一级城市分类
		if($paramer[com_pro]){
			$where.=" AND `com_provinceid` ='".$paramer[com_pro]."'";
		}
		//按照职位名称匹配
		if($paramer[keyword]){
			$where1[]="`name` LIKE '%".$paramer[keyword]."%'";
			$where1[]="`com_name` LIKE '%".$paramer[keyword]."%'";
			include  PLUS_PATH."/city.cache.php";
			foreach($city_name as $k=>$v){
				if(strpos($v,$paramer[keyword])!==false){
					$cityid[]=$k;
				}
			}
			if(is_array($cityid)){
				foreach($cityid as $value){
					$class[]= "(provinceid = '".$value."' or cityid = '".$value."')";
				}
				$where1[]=@implode(" or ",$class);
			}
			$where.=" AND (".@implode(" or ",$where1).")";
		}

		//多选职位
		if($paramer["job"]){
			$where.=" AND `job_post` in ($paramer[job])";
		}
		//置顶招聘
		if($paramer[bid]){
			if($config[joblist_top]!=1){
				$paramer[limit] = 5;
			}
			$where.="  and `xsdate`>'".time()."'";
		} 
		
		//自定义查询条件，默认取代上面任何参数直接使用该语句
		if($paramer[where]){
			$where = $paramer[where];
		}

		//查询条数
		$limit = '';
		if($paramer[limit]){

			$limit = " limit ".$paramer[limit];
		}
		if($paramer[ispage]){
			$limit = PageNav($paramer,$_GET,"company_job",$where,$Purl,"",$paramer[islt]?$paramer[islt]:"6",$_smarty_tpl);        
		}

		//排序字段默认为更新时间
		//置顶设置为随机5条时，随机查询
		if($paramer[bid] && $paramer[limit]){
			$order = " ORDER BY rand() ";
		}else{
			if($paramer[order] && $paramer[order]!="lastdate"){
				$order = " ORDER BY ".str_replace("'","",$paramer[order])."  ";
			}else{
				$order = " ORDER BY `lastupdate` ";
			}
		}
		//排序规则 默认为倒序
		if($paramer[sort]){
			$sort = $paramer[sort];
		}else{
			$sort = " DESC";
		} 
		$where.=$order.$sort;
		
		$blist = $db->select_all("company_job",$where.$limit);

		if(is_array($blist) && !empty($blist)){
			//处理类别字段
			$cache_array = $db->cacheget();
			$comuid=$jobid=array();
			foreach($blist as $key=>$value){
				if(in_array($value['uid'],$comuid)==false){$comuid[] = $value['uid'];}
				if(in_array($value['id'],$jobid)==false){$jobid[] = $value['id'];} 
			}
			$comuids = @implode(',',$comuid);
			$jobids = @implode(',',$jobid);
			//减少曝光量统计维度 只有列表才统计
			if($paramer[ispage]){
				$db->update_all("company_job", "`jobexpoure` = `jobexpoure` + 1", "`id` in ($jobids)");
			}
			

			if($comuids){
				$r_uids=$db->select_all("company","`uid` IN (".$comuids.")","`uid`,`yyzz_status`,`logo`,`logo_status`,`pr`,`hy`,`mun`,`shortname`,`welfare`,`hotstart`,`hottime`");
				if(is_array($r_uids)){
					foreach($r_uids as $key=>$value){
						if($value[shortname]){
    						$value['shortname_n'] = $value[shortname];
    					}
						if(!$value['logo'] || $value['logo_status']!=0){
							$value['logo'] = checkpic("",$config['sy_unit_icon']);
						}else{
							$value['logo']= checkpic($value['logo']);
						}
						$value['pr_n'] = $cache_array['comclass_name'][$value[pr]];
						$value['hy_n'] = $cache_array['industry_name'][$value[hy]];
						$value['mun_n'] = $cache_array['comclass_name'][$value[mun]];
						if($value['hotstart']<=time() && $value['hottime']>=time()){
							$value['hotlogo'] = 1;
						}
						$r_uid[$value['uid']] = $value;
					}
				}
			}
			
 			if($paramer[bid]){
				$noids=array();
			}	
			foreach($blist as $key=>$value){

				if($paramer[bid]){
					$noids[] = $value[id];
				}
				//筛除重复
				if($paramer[noids]==1 && !empty($noids) && in_array($value['id'],$noids)){
					unset($blist[$key]);
					continue;
				}else{
					$blist[$key] = $db->array_action($value,$cache_array);
					$blist[$key][stime] = date("Y-m-d",$value[sdate]);
					$blist[$key][etime] = date("Y-m-d",$value[edate]);
					if($arr_data['sex'][$value['sex']]){
						$blist[$key][sex_n]=$arr_data['sex'][$value['sex']];
					}
					$blist[$key][lastupdate] =lastupdateStyle($value[lastupdate]);
					if($value[minsalary]&&$value[maxsalary]){
						if($config['resume_salarytype']==1){
								$blist[$key][job_salary] =$value[minsalary]."-".$value[maxsalary];
						}else{
							if($value[maxsalary]<1000){
								if($config['resume_salarytype']==2){
									$blist[$key][job_salary] = "1千以下";
								}elseif($config['resume_salarytype']==3){
								$blist[$key][job_salary] = "1K以下";
								}elseif($config['resume_salarytype']==4){
								$blist[$key][job_salary] = "1k以下";
								}
							}else if($value[minsalary]<1000){
								$blist[$key][job_salary] =changeSalary($value[maxsalary]);
							}else{
								$blist[$key][job_salary] =changeSalary($value[minsalary])."-".changeSalary($value[maxsalary]);
							}
						}
					}elseif($value[minsalary]){
						if($config['resume_salarytype']==1){
						    $blist[$key][job_salary] =$value[minsalary]."以上";
						}else{
							$blist[$key][job_salary] =changeSalary($value[minsalary])."以上";
						}
					}else{
						$blist[$key][job_salary] ="面议";
					}
					
					if($r_uid[$value['uid']][shortname]){
						$blist[$key][com_name] =$r_uid[$value['uid']][shortname];
					}
					if(!empty($value[zp_minage]) && !empty($value[zp_maxage])){					   
					    if($value[zp_minage]==$value[zp_maxage]){
					        $blist[$key][job_age] = $value[zp_minage]."周岁以上";
					    }else{
					        $blist[$key][job_age] = $value[zp_minage]."-".$value[zp_maxage]."周岁";
					    }
					}else if(!empty($value[zp_minage]) && empty($value[zp_maxage])){
					    $blist[$key][job_age] = $value[zp_minage]."周岁以上";
					}else{
					     $blist[$key][job_age] = 0;
					}
					if($value[zp_num]==0){
					    $blist[$key][job_number] = "";
					}else{
					    $blist[$key][job_number] = $value[zp_num]." 人";
					}			
					$blist[$key][yyzz_status] =$r_uid[$value['uid']][yyzz_status];
					$blist[$key][logo] =$r_uid[$value['uid']][logo];
					$blist[$key][pr_n] =$r_uid[$value['uid']][pr_n];
					$blist[$key][hy_n] =$r_uid[$value['uid']][hy_n];
					$blist[$key][mun_n] =$r_uid[$value['uid']][mun_n];
					$blist[$key][hotlogo] =$r_uid[$value['uid']][hotlogo];
					$time=$value['lastupdate'];
					//今天开始时间戳
					$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
					//昨天开始时间戳
					$beginYesterday=mktime(0,0,0,date('m'),date('d')-1,date('Y'));
					
					if($time>$beginYesterday && $time<$beginToday){
						$blist[$key]['time'] ="昨天";
					}elseif($time>$beginToday){	
						$blist[$key]['time'] = $blist[$key]['lastupdate'];
						$blist[$key]['redtime'] =1;
					}else{
						$blist[$key]['time'] = date("Y-m-d",$value['lastupdate']);
					}
    
                     // 前天
    				$beforeYesterday=mktime(0,0,0,date('m'),date('d')-2,date('Y'));

					if($value['sdate']>$beforeYesterday){
						$blist[$key]['newtime'] =1;
					}
					//获得福利待遇名称
					if($value[welfare]){
					    $value[welfare] = str_replace(' ', '',$value[welfare]);
						$welfareList = @explode(',',trim($value[welfare]));

						if(!empty($welfareList)){
							$blist[$key][welfarename] =array_filter($welfareList);
						}
					}
					//截取公司名称
					if($paramer[comlen]){
						if($r_uid[$value['uid']][shortname]){
							$blist[$key][com_n] = mb_substr($r_uid[$value['uid']][shortname],0,$paramer[comlen],"utf-8");
						}else{
							$blist[$key][com_n] = mb_substr($value['com_name'],0,$paramer[comlen],"utf-8");
						}
					}
					//截取职位名称
					if($paramer[namelen]){
						if($value['rec_time']>time()){
							$blist[$key][name_n] = "<font color='red'>".mb_substr($value['name'],0,$paramer[namelen],"utf-8")."</font>";
						}else{
							$blist[$key][name_n] = mb_substr($value['name'],0,$paramer[namelen],"utf-8");
						}
					}else{
						if($value['rec_time']>time()){
							$blist[$key]['name_n'] = "<font color='red'>".$value['name']."</font>";
						}else{
							$blist[$key][name_n] = $value['name'];
						}
					}
					//构建职位伪静态URL
					$blist[$key][job_url] = Url("job",array("c"=>"comapply","id"=>$value[id]),"1");
					//构建企业伪静态URL
					$blist[$key][com_url] = Url("company",array("c"=>"show","id"=>$value[uid]));
					
					foreach($comrat as $k=>$v){
						if($value[rating]==$v[id]){
							$blist[$key][color] = str_replace("#","",$v[com_color]);
							if($v[com_pic]){
								$blist[$key][ratlogo] = checkpic($v[com_pic]);
							}
							$blist[$key][ratname] = $v[name];
						}
					}
					if($paramer[keyword]){
						$blist[$key][name]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$value[name]);
						$blist[$key][name_n]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$blist[$key][name_n]);
						$blist[$key][com_n]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$blist[$key][com_n]);
						$blist[$key][job_city_one]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$city_name[$value[provinceid]]);
						$blist[$key][job_city_two]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$city_name[$value[cityid]]);
					}
				}
			}
			if(is_array($blist)){
				if($paramer[keyword]!=""&&!empty($blist)){
					addkeywords('3',$paramer[keyword]);
				}
			}
		}$blist = $blist; if (!is_array($blist) && !is_object($blist)) { settype($blist, 'array');}
foreach ($blist as $_smarty_tpl->tpl_vars['blist']->key => $_smarty_tpl->tpl_vars['blist']->value) {
$_smarty_tpl->tpl_vars['blist']->_loop = true;
?>
          <li> <a href="<?php echo $_smarty_tpl->tpl_vars['blist']->value['job_url'];?>
" class="job_recommendation_jobname" title="<?php echo $_smarty_tpl->tpl_vars['blist']->value['name'];?>
"><?php echo $_smarty_tpl->tpl_vars['blist']->value['name_n'];?>
</a> <a href="<?php echo $_smarty_tpl->tpl_vars['blist']->value['com_url'];?>
" class="job_recommendation_Comname" title="<?php echo $_smarty_tpl->tpl_vars['blist']->value['com_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['blist']->value['com_n'];?>
</a>
            <div class="job_recommendation_msg"> <span class=""><em class="job_right_box_list_c"><?php echo $_smarty_tpl->tpl_vars['blist']->value['job_salary'];?>
 </em></span> </div>
          </li>
          <?php } ?>
        </ul>
      </div>
	   <div class="job_recommendation">
		    <div class="job_recommendation_title"><span class="job_recommendation_span"><i class="job_recommendation_span_line"></i>推荐企业</span> </div>
	  <ul class="job_mq_box">
	   <?php  $_smarty_tpl->tpl_vars['hotjoblist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['hotjoblist']->_loop = false;
global $db,$db_config,$config;$paramer=array("item"=>"'hotjoblist'","limit"=>"8","nocache"=>"")
;$hotjoblist=array();
		
		$time = time();
		//处理传入参数，并且构造分页参数
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr['arr'];
		$Purl =  $ParamerArr['purl'];
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }
		//是否属于分站下
		if($config[sy_web_site]=="1"){
			$jobwheres="";
			if($config[province]>0 && $config[province]!=""){
				$jobwheres.=" and `provinceid`='$config[province]'";
			}
			if($config[cityid]>0 && $config[cityid]!=""){
				$jobwheres.=" and `cityid`='$config[cityid]'";
			}
			if($config[three_cityid]>0 && $config[three_cityid]!=""){
				$jobwheres.=" and `three_cityid`='$config[three_cityid]'";
			}
			if($config[hyclass]>0 && $config[hyclass]!=""){
				$jobwheres.=" and `hy`='".$config[hyclass]."'";
			} 
			if($jobwheres){
				$comlist=$db->select_all("company","`hottime`>$time ".$jobwheres,"`uid`");
				if(is_array($comlist)){
					foreach($comlist as $v){
						$cuid[]=$v[uid];
					}
				}
				$hotwhere=" and `uid` in (".@implode(",",$cuid).")";
			} 
		}
        if($paramer['limit']){
			$limit=" limit ".$paramer['limit'];
		}
		$where = "`time_start`<$time AND `time_end`>$time".$hotwhere;

        if($config['hotcom_top'] == 1){
            // 职位更新时间(职位修改时，会更新名企表lastupdate字段)
            $order = " ORDER BY `lastupdate` DESC ";
        }elseif($config['hotcom_top'] == 2){
            // 随机
            $order = " ORDER BY rand() ";
        }else{
            // 后台手动设置
            $order = " ORDER BY `sort` DESC ";
        }$where.=$order;
        $Query = $db->query("SELECT * FROM $db_config[def]hotjob where ".$where.$limit); 
		while($rs = $db->fetch_array($Query)){
			$hotjoblist[] = $rs;
			$ListId[] =  $rs[uid];
		}
        
		//是否需要查询对应职位
		$ComId  =   @implode(",",$ListId);
		$comList=   $db->select_all("company","`uid` IN ($ComId)","`shortname`,`uid`,`hy`,`mun`,`provinceid`,`cityid`,`three_cityid`, `r_status`");
		
		if($config[sy_datacycle]>0){
			    
		    $uptime =   strtotime('-'.$config[sy_datacycle].' day');
		    $JobList=   $db->select_all("company_job","`uid` IN ($ComId) and state=1 and r_status=1 and status=0 and lastupdate > $uptime $jobwheres","`id`,`uid`,`name`");
	    }else{
	    
	        $JobList=   $db->select_all("company_job","`uid` IN ($ComId) and state=1 and r_status=1 and status=0 $jobwheres","`id`,`uid`,`name`");
	    }
		
		$statis=$db->select_all("company_statis","`uid` IN ($ComId)","`uid`,`comtpl`");
		if(is_array($ListId)){
		    
		    foreach($hotjoblist as $key=>$value){
				foreach($comList as $v){
					if($v['uid'] == $value['uid']){
					    if($v['r_status'] != 1){ 
					        unset($hotjoblist[$key]);
					    }
					}
				}
			}
		    $JobIds =   array();
			//处理类别字段
			$cache_array = $db->cacheget();
			foreach($hotjoblist as $key=>$value){
				$hotjoblist[$key]["hot_pic"]=checkpic($value[hot_pic],$config[sy_unit_icon]);
				foreach($comList as $v){
				 
					if($value['uid']==$v['uid']){
						if($v['shortname']){
							$hotjoblist[$key]["username"]= $v[shortname];
						}
						$hotjoblist[$key]["hy"]= $cache_array[industry_name][$v[hy]];
						$hotjoblist[$key]["mun_n"]= $cache_array[comclass_name][$v[mun]];
						$hotjoblist[$key]["job_city_one"]= $cache_array[city_name][$v[provinceid]];
						$hotjoblist[$key]["job_city_two"]= $cache_array[city_name][$v[cityid]];
					}
				}
				$i=0;$j=0;
				$hotjoblist[$key]["num"]=0;
				if(is_array($JobList)){
					foreach($JobList as $ke=>$va){ 
						if($value[uid]==$va[uid]){
							if($j<3){
								$hotjob_url = Url("job",array("c"=>"comapply","id"=>"$va[id]"),"1");
								$curl=  Url("company",array("c"=>"show","id"=>$value[uid]));
								$va[name] = mb_substr($va[name],0,8,"utf-8");
								$hotjoblist[$key]["hotjob"].="<div class='index_mq_box_cont_showjoblist'><a href=\"$hotjob_url\">".$va[name]."</a></div>";
						        $JobIds[] = $va['id'];
							}else{
                                if($j==3){
                                    $hotjoblist[$key]["hotjob"].="<div class='index_mq_box_cont_showjobmore'><a href=\"$curl\">更多职位</a></div>";
							     }
							}
                            $j++;
						}
					}

					
					$hotjoblist[$key]["job"].="<div class=\"area_left\"> ";
					
					foreach($JobList as $k=>$v){
						if($value[uid]==$v[uid] && $i<5){
							$job_url = Url("job",array("c"=>"comapply","id"=>"$v[id]"),"1");
							$v[name] = mb_substr($v[name],0,10,"utf-8");
							$hotjoblist[$key]["job"].="<a href='".$job_url."'>".$v[name]."</a>";
							$i++;
						}
						if($value[uid]==$v[uid]){
							$hotjoblist[$key]["num"]=$hotjoblist[$key]["num"]+1;
						}
					}

					foreach($statis as $v){
						if($value['uid']==$v['uid']){
							if($v['comtpl'] && $v['comtpl']!="default"){
								$jobs_url = Url("company",array("c"=>"show","id"=>$value[uid]))."#job";
							}else{
								$jobs_url = Url("company",array("c"=>"show","id"=>$value[uid]));
							}
						}
					}
					$com_url = Url("company",array("c"=>"show","id"=>$value[uid]));
					$hotjoblist[$key]["job"].="</div><div class=\"area_right\"><a href='".$com_url."'>".$value["username"]."</a></div>";
					$hotjoblist[$key]["url"]=$com_url;
				}
			}
			if(!empty($JobIds)){
			    //$db -> update_all("company_job", "`jobexpoure` = `jobexpoure` + 1", "`id` IN (".@implode(',',$JobIds).")");
			}
		}$hotjoblist = $hotjoblist; if (!is_array($hotjoblist) && !is_object($hotjoblist)) { settype($hotjoblist, 'array');}
foreach ($hotjoblist as $_smarty_tpl->tpl_vars['hotjoblist']->key => $_smarty_tpl->tpl_vars['hotjoblist']->value) {
$_smarty_tpl->tpl_vars['hotjoblist']->_loop = true;
?>
	    <li> <a href="<?php echo $_smarty_tpl->tpl_vars['hotjoblist']->value['url'];?>
" target="_blank" title="<?php echo $_smarty_tpl->tpl_vars['hotjoblist']->value['username'];?>
">
	      <div class="co_recom_imgbox"><img src="<?php echo smarty_function_formatpicurl(array('path'=>$_smarty_tpl->tpl_vars['hotjoblist']->value['hot_pic'],'type'=>'comlogo'),$_smarty_tpl);?>
" onerror="showImgDelay(this,'<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_unit_icon'];?>
',2);" width="100" height="100" /> </div>
	      <p><?php echo mb_substr($_smarty_tpl->tpl_vars['hotjoblist']->value['username'],0,13,'utf-8');?>
</p>
	      </a> </li>
	    <?php }
if (!$_smarty_tpl->tpl_vars['hotjoblist']->_loop) {
?>
	    <div class="pc_notip">暂无推荐企业</div>
	     <?php } ?>
	  </ul>
	     </div>
    </div>

  </div>
</div>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
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
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/lazyload.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
> 
<?php echo '<script'; ?>
>
            var weburl = "<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
",
                integral_pricename = '<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
';
        <?php echo '</script'; ?>
> 
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
> 
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/class.public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/javascript"><?php echo '</script'; ?>
> 
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/js/com_index.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
> 
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/search.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/javascript"><?php echo '</script'; ?>
> 
<!--[if IE 6]>
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/png.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
>
		DD_belatedPNG.fix('.png,.search_job_data,.yun_job_operation_sc');
		<?php echo '</script'; ?>
>
		<![endif]--> 
<?php echo '<script'; ?>
>
            $(document).ready(function() {
                $("#form").submit(function(e) {
                    var min = $("#min").val();
                    var max = $("#max").val();
                    if(min && max && parseInt(max) < parseInt(min)) {
                        $("#min").val(max);
                        $("#max").val(min);
                    }
                });
				$('.yunjoblist_newwxbth').hover(function(){
					var purl=$(this).attr('purl');
					layer.tips("<img src="+purl+" style='max-width:120px'>", this, {
						guide:3,
						time:0,
						style: ['background-color:#5EA7DC;', '#5EA7DC']
					});
				},function() {
					layer.closeAll('tips');
				});
				$('.yunjoblist_new_icon').click(function(){
					var pid=$(this).attr('pid');
					if($(this).attr('title')=='展开'){
						$(this).addClass('yunjoblist_new_icon_cur');
						$(this).attr('title','收起');
						$('#jobshow'+pid).show();
					}else{
						$(this).removeClass('yunjoblist_new_icon_cur');
						$(this).attr('title','展开');
						$('#jobshow'+pid).hide();
					}
				});
            });

			function closeWxtzTips(){
				$.post('index.php?c=closeWxtzTips', {}, function (data) {
					$("#wxtz_tips").addClass("none")
				}, 'json')
			}
        <?php echo '</script'; ?>
> 
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/public_search/login.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/public_search/index_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }} ?>
