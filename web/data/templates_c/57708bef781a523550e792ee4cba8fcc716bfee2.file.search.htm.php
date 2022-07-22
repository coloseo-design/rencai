<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-08 16:12:10
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\default\resume\search.htm" */ ?>
<?php /*%%SmartyHeaderCode:763162c7e6da50b676-64336136%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '57708bef781a523550e792ee4cba8fcc716bfee2' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\default\\resume\\search.htm',
      1 => 1643012866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '763162c7e6da50b676-64336136',
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
    'resumekeyword' => 0,
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
    'userdata' => 0,
    'userclass_name' => 0,
    'integrity_name' => 0,
    'k' => 0,
    'industry_name' => 0,
    'industry_index' => 0,
    'user_sex' => 0,
    'j' => 0,
    'uptime' => 0,
    'uid' => 0,
    'usertype' => 0,
    'r_status' => 0,
    'adlist_36' => 0,
    'userrec' => 0,
    'eid' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c7e6da9f3510_13337525',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c7e6da9f3510_13337525')) {function content_62c7e6da9f3510_13337525($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.url.php';
if (!is_callable('smarty_function_listurl')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.listurl.php';
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
    <link href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/css/layui.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
</head>

<body class="body_bg">
    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <div class="yun_jobbody">
        <div class="yun_content">
            <div class="current_Location com_current_Location png none">
                <div class="fl">您当前的位置：
                    <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
">首页</a> > <span>找人才</span>
                </div>
            </div>

            <div class="clear"></div>

            <!-- 广告位放这-->
            <?php  $_smarty_tpl->tpl_vars["lunbo"] = new Smarty_Variable; $_smarty_tpl->tpl_vars["lunbo"]->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
global $db,$db_config,$config;$AdArr=array();$paramer=array();$attr=array("classid"=>"508","item"=>"\"lunbo\"","key"=>"'key'","random"=>"1","nocache"=>"")
;
			include(PLUS_PATH.'pimg_cache.php');$add_arr = $ad_label[508];if(is_array($add_arr) && !empty($add_arr)){
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

            <form method="get" id="form" action="<?php if (!$_smarty_tpl->tpl_vars['config']->value['sy_resumedir']) {?>index.php<?php } else {
echo smarty_function_url(array('m'=>'resume'),$_smarty_tpl);
}?>" onsubmit="return search_keyword(this,'请输入关键字');">
                <div class="jobsearch_newbox">

                    <?php if (!$_smarty_tpl->tpl_vars['config']->value['sy_resumedir']) {?><input type="hidden" name="m" value="resume" /> <?php }?>

                    <input type="hidden" name="c" value="search" /> <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['finder']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                    <input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" /> <?php } ?>

                    <div class="yun_job_search">
                        <div class="yun_job_search_cont">
                            <div class="yun_job_search_textcont">
                                <input type="text" name="keyword" value="<?php if ($_GET['keyword']!='') {
echo $_GET['keyword'];
} else { ?>请输入关键字<?php }?>" onclick="if(this.value=='请输入关键字'){this.value=''}" onblur="if(this.value==''){this.value='请输入关键字'}" class="Search_jobs_text" />
                            </div>
                            <input type="submit" value="搜索" class="Search_jobs_submit yun_bg_color" />
                        </div>

                        <?php if ($_smarty_tpl->tpl_vars['resumekeyword']->value) {?>
                        <div class="jobs_tag">
                            热门搜索： <?php  $_smarty_tpl->tpl_vars['keylist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['keylist']->_loop = false;
global $config;$paramer=array("limit"=>"14","recom"=>"1","type"=>"5","item"=>"'keylist'","nocache"=>"")
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
                            <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'keyword','v'=>$_smarty_tpl->tpl_vars['keylist']->value['key_title']),$_smarty_tpl);?>
" title="<?php echo $_smarty_tpl->tpl_vars['keylist']->value['key_title'];?>
" class="jos_tag_a"><?php echo $_smarty_tpl->tpl_vars['keylist']->value['key_name'];?>
</a>
                            <?php } ?>
                        </div>
                        <?php } else { ?>
                            <div class="jobs_tag">&nbsp;</div>
                        <?php }?>
                    </div>
                </div>

                <div class="Search_jobs_box">
                    <?php if (!$_GET['job1']) {?>
                    <div class="Search_jobs_form_list">
                        <div class="Search_jobs_name"> 职位：</div>
                        <div class="Search_jobs_sub ">
                            <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'job1','v'=>0),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['job1']=='') {?>Search_jobs_sub_cur<?php }?>">全部</a> <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['job_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                            <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'job1','v'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['job1']==$_smarty_tpl->tpl_vars['v']->value) {?>Search_jobs_sub_cur<?php }?> <?php if ($_smarty_tpl->tpl_vars['key']->value>6) {?>job1list<?php }?> <?php if ($_smarty_tpl->tpl_vars['key']->value>6) {?>none<?php }?>"><?php echo $_smarty_tpl->tpl_vars['job_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> <?php } ?></div>
                        <div class="zh_more">
                            <a href="javascript:checkmore('job1list');" id="job1list" rel="nofollow">更多</a>
                        </div>
                    </div>
                    <?php }?> <?php if ($_GET['job1']&&!$_GET['job1_son']) {?>
                    <div class="Search_jobs_form_list">
                        <div class="Search_jobs_name"> 子类：</div>
                        <div class="Search_jobs_sub ">
                            <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'job1_son'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['job1_son']=='') {?>Search_jobs_sub_cur<?php }?>">全部</a> <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['job_type']->value[$_GET['job1']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                            <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'job1_son','v'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['job1_son']==$_smarty_tpl->tpl_vars['v']->value) {?>Search_jobs_sub_cur<?php }?>"><?php echo $_smarty_tpl->tpl_vars['job_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> <?php } ?>
                        </div>
                    </div>
                    <?php }?> <?php if ($_GET['job1_son']) {?>
                    <div class="Search_jobs_form_list">
                        <div class="Search_jobs_name"> 类别：</div>
                        <div class="Search_jobs_sub ">
                            <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'job1_son','v'=>$_GET['job1_son']),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['job_post']=='') {?>Search_jobs_sub_cur<?php }?>">全部</a>
                            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['job_type']->value[$_GET['job1_son']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                            <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'job_post','v'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['job_post']==$_smarty_tpl->tpl_vars['v']->value) {?>Search_jobs_sub_cur<?php }?>"><?php echo $_smarty_tpl->tpl_vars['job_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a>
                            <?php } ?>
                        </div>
                    </div>
                    <?php }?>

                    <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_web_site']==1&&$_smarty_tpl->tpl_vars['config']->value['cityname']&&$_smarty_tpl->tpl_vars['config']->value['cityname']!=$_smarty_tpl->tpl_vars['config']->value['sy_indexcity']) {?>
                    <div class="Search_citybox">
                        <div class="Search_cityboxname"> 地点：</div>
                        <div class="Search_citybox_right">
                            <div class="Search_cityboxright">
                                <div class="search_city_list">
                                    <?php if (!$_GET['cityid']&&$_GET['three_cityid']) {?>
                                    <a class="city_name city_name_active" style="text-decoration:none;cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['three_cityid']];?>
</a>
                                    <?php } else { ?> <?php if (is_array($_smarty_tpl->tpl_vars['city_type']->value[$_GET['cityid']])) {?>
                                    <a href="<?php echo smarty_function_listurl(array('m'=>'resume','untype'=>'three_cityid'),$_smarty_tpl);?>
" class="city_name <?php if (!$_GET['three_cityid']) {?>city_name_active<?php }?>">不限</a>
                                    <?php  $_smarty_tpl->tpl_vars['tid'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tid']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_GET['cityid']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tid']->key => $_smarty_tpl->tpl_vars['tid']->value) {
$_smarty_tpl->tpl_vars['tid']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['tid']->key;
?>
                                    <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'three_cityid','v'=>$_smarty_tpl->tpl_vars['tid']->value),$_smarty_tpl);?>
" class="city_name <?php if ($_GET['three_cityid']==$_smarty_tpl->tpl_vars['tid']->value) {?>city_name_active<?php }?>"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['tid']->value];?>
</a>
                                    <?php } ?> <?php } else { ?>
                                    <?php if (is_array($_smarty_tpl->tpl_vars['city_type']->value[$_GET['provinceid']])) {?>
                                            <a href="<?php echo smarty_function_listurl(array('m'=>'resume','untype'=>'cityid'),$_smarty_tpl);?>
" class="city_name <?php if (!$_GET['cityid']) {?>city_name_active<?php }?>">不限</a>
                                            <?php  $_smarty_tpl->tpl_vars['tid'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tid']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_GET['provinceid']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tid']->key => $_smarty_tpl->tpl_vars['tid']->value) {
$_smarty_tpl->tpl_vars['tid']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['tid']->key;
?>
                                                <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'cityid','v'=>$_smarty_tpl->tpl_vars['tid']->value),$_smarty_tpl);?>
" class="city_name <?php if ($_GET['cityid']==$_smarty_tpl->tpl_vars['tid']->value) {?>city_name_active<?php }?>"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['tid']->value];?>
</a>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <a class="city_name city_name_active" style="text-decoration:none;cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['provinceid']];?>
</a>
                                        <?php }?>
                                    <?php }?> <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } elseif ($_smarty_tpl->tpl_vars['config']->value['sy_web_city_one']) {?>
                    <div class="Search_citybox">
                        <div class="Search_cityboxname"> 地点：</div>
                        <div class="Search_citybox_right">
                            <div class="Search_cityboxright">
                                <div class="search_city_list">
                                    <?php if (!$_GET['cityid']&&$_GET['three_cityid']) {?>
                                    <a class="city_name city_name_active" style="text-decoration:none;cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['three_cityid']];?>
</a>
                                    <?php } else { ?> <?php if (is_array($_smarty_tpl->tpl_vars['city_type']->value[$_GET['cityid']])) {?>
                                    <a href="<?php echo smarty_function_listurl(array('m'=>'resume','untype'=>'three_cityid'),$_smarty_tpl);?>
" class="city_name <?php if (!$_GET['three_cityid']) {?>city_name_active<?php }?>">不限</a>
                                    <?php  $_smarty_tpl->tpl_vars['tid'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tid']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_GET['cityid']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tid']->key => $_smarty_tpl->tpl_vars['tid']->value) {
$_smarty_tpl->tpl_vars['tid']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['tid']->key;
?>
                                    <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'three_cityid','v'=>$_smarty_tpl->tpl_vars['tid']->value),$_smarty_tpl);?>
" class="city_name <?php if ($_GET['three_cityid']==$_smarty_tpl->tpl_vars['tid']->value) {?>city_name_active<?php }?>"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['tid']->value];?>
</a>
                                    <?php } ?> <?php } else { ?>
                                    <?php if (is_array($_smarty_tpl->tpl_vars['city_type']->value[$_GET['provinceid']])) {?>
                                            <a href="<?php echo smarty_function_listurl(array('m'=>'resume','untype'=>'cityid'),$_smarty_tpl);?>
" class="city_name <?php if (!$_GET['cityid']) {?>city_name_active<?php }?>">不限</a>
                                            <?php  $_smarty_tpl->tpl_vars['tid'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tid']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_GET['provinceid']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tid']->key => $_smarty_tpl->tpl_vars['tid']->value) {
$_smarty_tpl->tpl_vars['tid']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['tid']->key;
?>
                                                <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'cityid','v'=>$_smarty_tpl->tpl_vars['tid']->value),$_smarty_tpl);?>
" class="city_name <?php if ($_GET['cityid']==$_smarty_tpl->tpl_vars['tid']->value) {?>city_name_active<?php }?>"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['tid']->value];?>
</a>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <a class="city_name city_name_active" style="text-decoration:none;cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['provinceid']];?>
</a>
                                        <?php }?>
                                    <?php }?> <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div class="Search_citybox">
                        <div class="Search_cityboxname"> 地点：</div>
                        <div class="Search_citybox_right">
                            <div class="Search_cityall none">
                                <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'provinceid','v'=>0),$_smarty_tpl);?>
" class="city_name">全部</a>
                                <?php  $_smarty_tpl->tpl_vars['pid'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['pid']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['pid']->key => $_smarty_tpl->tpl_vars['pid']->value) {
$_smarty_tpl->tpl_vars['pid']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['pid']->key;
?>
                                <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'provinceid','v'=>$_smarty_tpl->tpl_vars['pid']->value),$_smarty_tpl);?>
" class="city_name <?php if ($_GET['provinceid']==$_smarty_tpl->tpl_vars['pid']->value) {?>city_name_active<?php }?>"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['pid']->value];?>
</a>
                                <?php } ?>
                            </div>
                            <div class="Search_cityboxright">
                                <a href="javascript:;" onclick="acityshow('1')" class="search_city_list_cur <?php if ($_GET['provinceid']&&!$_GET['cityid']||!is_array($_smarty_tpl->tpl_vars['city_type']->value[$_GET['cityid']])) {?>search_city_active<?php }?> <?php if (!$_GET['provinceid']) {?>none<?php }?> acity_two" style="text-decoration:none;cursor:pointer;"><span class="search_city_p"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['provinceid']];?>
</span><i class="search_city_p_jt"></i><i class="search_city_list_line"></i></a>
                                <a href="javascript:;" <?php if ($_GET['cityid']) {?>onclick="acityshow('2')" <?php }?> class="search_city_list_cur <?php if ($_GET['cityid']&&is_array($_smarty_tpl->tpl_vars['city_type']->value[$_GET['cityid']])) {?>search_city_active<?php }?> <?php if (!$_GET['provinceid']||!$_GET['cityid']||!is_array($_smarty_tpl->tpl_vars['city_type']->value[$_GET['cityid']])) {?>none<?php }?> acity_three" style="text-decoration:none;cursor:pointer;"><span class="search_city_p"><?php if (!$_GET['cityid']) {?>不限<?php } else {
echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['cityid']];
}?></span><i class="search_city_list_line"></i></a>
                                <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'provinceid','v'=>0),$_smarty_tpl);?>
" class="search_city_list_all <?php if (!$_GET['provinceid']) {?>city_name_active<?php }?>">全部</a>
                                <div class="search_city_list">
                                    <?php  $_smarty_tpl->tpl_vars['pid'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['pid']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['pid']->key => $_smarty_tpl->tpl_vars['pid']->value) {
$_smarty_tpl->tpl_vars['pid']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['pid']->key;
?>
                                    <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'provinceid','v'=>$_smarty_tpl->tpl_vars['pid']->value),$_smarty_tpl);?>
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
                            <div class="Search_cityboxclose <?php if (!$_GET['provinceid']||($_GET['provinceid']&&$_GET['cityid']&&is_array($_smarty_tpl->tpl_vars['city_type']->value[$_GET['cityid']]))) {?>none<?php }?>" id="acity_two">
                                <a href="<?php echo smarty_function_listurl(array('m'=>'resume','untype'=>'cityid'),$_smarty_tpl);?>
" class="city_name <?php if ($_GET['provinceid']&&!$_GET['cityid']&&!$_GET['three_cityid']) {?>city_name_active<?php }?>">不限</a>
                                <?php  $_smarty_tpl->tpl_vars['cid'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cid']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_GET['provinceid']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cid']->key => $_smarty_tpl->tpl_vars['cid']->value) {
$_smarty_tpl->tpl_vars['cid']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['cid']->key;
?>
                                <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'cityid','v'=>$_smarty_tpl->tpl_vars['cid']->value),$_smarty_tpl);?>
" class="city_name <?php if ($_GET['cityid']==$_smarty_tpl->tpl_vars['cid']->value) {?>city_name_active<?php }?>"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['cid']->value];?>
</a>
                                <?php } ?>
                            </div>
                            <div class="Search_cityboxclose <?php if (!$_GET['cityid']||!is_array($_smarty_tpl->tpl_vars['city_type']->value[$_GET['cityid']])) {?>none<?php }?>" id="acity_three">
                                <a href="<?php echo smarty_function_listurl(array('m'=>'resume','untype'=>'three_cityid'),$_smarty_tpl);?>
" class="city_name <?php if ($_GET['provinceid']&&$_GET['cityid']&&!$_GET['three_cityid']) {?>city_name_active<?php }?>">不限</a>
                                <?php  $_smarty_tpl->tpl_vars['tid'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tid']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_GET['cityid']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tid']->key => $_smarty_tpl->tpl_vars['tid']->value) {
$_smarty_tpl->tpl_vars['tid']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['tid']->key;
?>
                                <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'three_cityid','v'=>$_smarty_tpl->tpl_vars['tid']->value),$_smarty_tpl);?>
" class="city_name <?php if ($_GET['three_cityid']==$_smarty_tpl->tpl_vars['tid']->value) {?>city_name_active<?php }?>"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['tid']->value];?>
</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php }?>

                    <?php if ($_smarty_tpl->tpl_vars['userdata']->value['user_tag']) {?>
                    <div class="Search_jobs_form_list search_more">
                        <div class="Search_jobs_name"> 标签：</div>
                        <div class="Search_jobs_sub">
                            <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'tag','v'=>0),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if (!$_GET['tag']) {?>Search_jobs_sub_cur<?php }?>">全部</a>
                            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_tag']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                            <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'tag','v'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_smarty_tpl->tpl_vars['key']->value>9) {?>none<?php }?> <?php if ($_smarty_tpl->tpl_vars['key']->value>9) {?>taglist<?php }?> <?php if ($_GET['tag']==$_smarty_tpl->tpl_vars['v']->value) {?>Search_jobs_sub_cur<?php }?>"><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a>
                            <?php } ?>
                        </div>
                        <?php if (count($_smarty_tpl->tpl_vars['userdata']->value['user_tag'])>10) {?>
                        <div class="zh_more">
                            <a href="javascript:checkmore('taglist');" id="taglist" rel="nofollow">更多</a>
                        </div>
                        <?php }?>
                    </div>
                    <?php }?>
                    <div class="searchmorelist none">
                        <div class="Search_jobs_form_list search_more">
                            <div class="Search_jobs_name"> 薪资：</div>
                            <div>
                                <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'salary','v'=>0),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['minsalary']==''&&$_GET['maxsalary']=='') {?>Search_jobs_sub_cur<?php }?>">全部</a>
                                <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'salary','v'=>'2000_4000'),$_smarty_tpl);?>
" class="Search_jobs_cxz <?php if ($_GET['minsalary']==2000&&$_GET['maxsalary']==4000) {?>Search_jobs_sub_cur<?php }?>">2000-4000</a>
                                <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'salary','v'=>'4000_6000'),$_smarty_tpl);?>
" class="Search_jobs_cxz <?php if ($_GET['minsalary']==4000&&$_GET['maxsalary']==6000) {?>Search_jobs_sub_cur<?php }?>">4000-6000</a>
                                <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'salary','v'=>'6000_8000'),$_smarty_tpl);?>
" class="Search_jobs_cxz <?php if ($_GET['minsalary']==6000&&$_GET['maxsalary']==8000) {?>Search_jobs_sub_cur<?php }?>">6000-8000</a>
                                <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'salary','v'=>'8000_10000'),$_smarty_tpl);?>
" class="Search_jobs_cxz <?php if ($_GET['minsalary']==8000&&$_GET['maxsalary']==10000) {?>Search_jobs_sub_cur<?php }?>">8000-10000</a>
                                <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'salary','v'=>'10000'),$_smarty_tpl);?>
" class="Search_jobs_cxz <?php if ($_GET['minsalary']==10000) {?>Search_jobs_sub_cur<?php }?>">10000以上</a>
                            </div>
                            <div>
                                <input type="text" name="minsalary" id="min" value="<?php if ($_GET['minsalary']) {
echo $_GET['minsalary'];
}?>" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" class="job_xz_text" />
                                <span class="job_xz_line">-</span>
                                <input type="text" name="maxsalary" id="max" value="<?php if ($_GET['maxsalary']) {
echo $_GET['maxsalary'];
}?>" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" class="job_xz_text" />
                                <input type="submit" value="确定" class="job_xz_bth" />
                            </div>
                        </div>
                        <div class="Search_jobs_form_list search_more">
                            <div class="Search_jobs_name"> 年龄：</div>
                            <div class=" ">
                                <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'age','v'=>0),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['minage']==''&&$_GET['maxage']=='') {?>Search_jobs_sub_cur<?php }?>">全部</a>
                                <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'age','v'=>'16_20'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['minage']==16&&$_GET['maxage']==20) {?>Search_jobs_sub_cur<?php }?>">16-20岁</a>
                                <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'age','v'=>'21_30'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['minage']==21&&$_GET['maxage']==30) {?>Search_jobs_sub_cur<?php }?>">21-30岁</a>
                                <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'age','v'=>'31_40'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['minage']==31&&$_GET['maxage']==40) {?>Search_jobs_sub_cur<?php }?>">31-40岁</a>
                                <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'age','v'=>'41_50'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['minage']==41&&$_GET['maxage']==50) {?>Search_jobs_sub_cur<?php }?>">41-50岁</a>
                                <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'age','v'=>'50'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['minage']==50) {?>Search_jobs_sub_cur<?php }?>">50岁以上</a>
                            </div>
                            <div>
                                <input type="text" name="minage" id="mina" value="<?php if ($_GET['minage']) {
echo $_GET['minage'];
}?>" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" class="job_xz_text" />
                                <span class="job_xz_line">-</span>
                                <input type="text" name="maxage" id="maxa" value="<?php if ($_GET['maxage']) {
echo $_GET['maxage'];
}?>" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" class="job_xz_text" />
                                <input type="submit" value="确定" class="job_xz_bth" />
                            </div>
                        </div>
                        <div class="Search_jobs_form_list search_more">
                            <div class="Search_jobs_name"> 完整度：</div>
                            <div class="Search_jobs_sub">
                                <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'integrity','v'=>0),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if (!$_GET['integrity']) {?>Search_jobs_sub_cur<?php }?>">全部</a>
                                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['integrity_name']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                                <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'integrity','v'=>$_smarty_tpl->tpl_vars['k']->value),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['integrity']==$_smarty_tpl->tpl_vars['k']->value) {?>Search_jobs_sub_cur<?php }?>"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</a>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="Search_jobs_form_list search_more">
                            <div class="Search_jobs_name"> 更多：</div>

                            <div class="Search_jobs_sub" style="width:1090px;">

                                <div class="Search_jobs_more_chlose">
                                    <span class="Search_jobs_more_chlose_s"><?php if ($_GET['hy']) {
echo $_smarty_tpl->tpl_vars['industry_name']->value[$_GET['hy']];
} else { ?>工作行业<?php }?></span><i class=""></i>
                                    <div class="Search_jobs_more_chlose_hylist none">
                                        <ul>
                                            <?php if ($_smarty_tpl->tpl_vars['config']->value['fz_type']!='2'&&$_smarty_tpl->tpl_vars['config']->value['hyclass']=='') {?>
                                            <div class="Search_jobs_form_list">
                                                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['industry_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                                                <li>
                                                    <a href="javascript:;" onclick="showurl('<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'hy','v'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
')"><?php echo $_smarty_tpl->tpl_vars['industry_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a>
                                                </li>
                                                <?php } ?>
                                            </div>
                                            <?php }?>
                                        </ul>
                                    </div>
                                </div>

                                <div class="Search_jobs_more_chlose"><span class="Search_jobs_more_chlose_s"><?php if ($_GET['edu']) {
echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_GET['edu']];
} else { ?>学历要求<?php }?></span><i class=""></i>
                                    <div class="Search_jobs_more_chlose_list none">
                                        <ul>
                                            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_edu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                                            <li>
                                                <a href="javascript:;" onclick="showurl('<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'edu','v'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
')"><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>

                                <div class="Search_jobs_more_chlose"><span class="Search_jobs_more_chlose_s"><?php if ($_GET['exp']) {
echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_GET['exp']];
} else { ?>工作经验<?php }?></span><i class=""></i>
                                    <div class="Search_jobs_more_chlose_list none">
                                        <ul>
                                            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_word']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                                            <li>
                                                <a href="javascript:;" onclick="showurl('<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'exp','v'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
')"><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>

                                <div class="Search_jobs_more_chlose"><span class="Search_jobs_more_chlose_s"><?php if ($_GET['sex']) {
echo $_smarty_tpl->tpl_vars['user_sex']->value[$_GET['sex']];
} else { ?>性别要求<?php }?></span><i class=""></i>
                                    <div class="Search_jobs_more_chlose_list none">
                                        <ul>
                                            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['user_sex']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                                            <li>
                                                <a href="javascript:;" onclick="showurl('<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'sex','v'=>$_smarty_tpl->tpl_vars['j']->value),$_smarty_tpl);?>
')"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</a>
                                            </li>
                                            <?php } ?>

                                        </ul>
                                    </div>
                                </div>

                                <div class="Search_jobs_more_chlose"><span class="Search_jobs_more_chlose_s"><?php if ($_GET['report']) {
echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_GET['report']];
} else { ?>到岗时间<?php }?></span><i class=""></i>
                                    <div class="Search_jobs_more_chlose_list none">
                                        <ul>
                                            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_report']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                                            <li>
                                                <a href="javascript:;" onclick="showurl('<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'report','v'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
')"><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>

                                <div class="Search_jobs_more_chlose"><span class="Search_jobs_more_chlose_s"><?php if ($_smarty_tpl->tpl_vars['uptime']->value[$_GET['uptime']]) {
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
                                            <li>
                                                <a href="javascript:;" onclick="showurl('<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'uptime','v'=>$_smarty_tpl->tpl_vars['key']->value),$_smarty_tpl);?>
')"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</a>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>

                                <div class="Search_jobs_more_chlose"><span class="Search_jobs_more_chlose_s"><?php if ($_GET['type']) {
echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_GET['type']];
} else { ?>工作性质<?php }?></span><i class=""></i>
                                    <div class="Search_jobs_more_chlose_list none">
                                        <ul>
                                            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_type']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                                            <li>
                                                <a href="javascript:;" onclick="showurl('<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'type','v'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
')"><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <?php if ($_GET['job1']||$_GET['job1_son']||$_GET['job_post']||($_GET['provinceid']&&!$_smarty_tpl->tpl_vars['config']->value['sy_web_city_one'])||($_GET['cityid']&&!$_smarty_tpl->tpl_vars['config']->value['sy_web_city_two'])||$_GET['three_cityid']||$_GET['hy']||$_GET['minsalary']||$_GET['maxsalary']||$_GET['minage']||$_GET['maxage']||$_GET['edu']||$_GET['exp']||$_GET['tag']||$_GET['sex']||$_GET['type']||$_GET['report']||$_GET['uptime']||$_GET['keyword']||$_GET['idcard']||$_GET['work']||$_GET['integrity']) {?>
                    <div class="Search_close_box">
                        <div>
                            <div class="Search_clear">
                                <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_default_userclass']==1) {?>
                                <a href="<?php echo smarty_function_url(array('m'=>'resume','c'=>'search'),$_smarty_tpl);?>
"> 清除所选</a>
                                <?php } else { ?>
                                <a href="<?php echo smarty_function_url(array('m'=>'resume'),$_smarty_tpl);?>
"> 清除所选</a>
                                <?php }?>
                            </div>
                            <span class="Search_close_box_s">已选条件：</span>
                        </div>
                        <?php if ($_GET['job1']) {?>
                        <a href="<?php echo smarty_function_listurl(array('m'=>'resume','untype'=>'job1'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">职位分类：<?php echo $_smarty_tpl->tpl_vars['job_name']->value[$_GET['job1']];?>
</a>
                        <?php }?>
                        <?php if ($_GET['job1_son']) {?>
                        <a href="<?php echo smarty_function_listurl(array('m'=>'resume','untype'=>'job1_son'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac"><?php echo $_smarty_tpl->tpl_vars['job_name']->value[$_GET['job1_son']];?>
</a>
                        <?php }?>
                        <?php if ($_GET['job_post']) {?>
                        <a href="<?php echo smarty_function_listurl(array('m'=>'resume','untype'=>'job_post'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac"><?php echo $_smarty_tpl->tpl_vars['job_name']->value[$_GET['job_post']];?>
</a>
                        <?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['config']->value['cityid']==''&&$_smarty_tpl->tpl_vars['config']->value['three_cityid']=='') {?>
                            <?php if ($_GET['provinceid']&&!$_smarty_tpl->tpl_vars['config']->value['sy_web_city_one']) {?>
                            <a href="<?php echo smarty_function_listurl(array('m'=>'resume','untype'=>'provinceid'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">工作地点：<?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['provinceid']];?>
</a>
                            <?php }?>
                            <?php if ($_GET['cityid']&&!$_smarty_tpl->tpl_vars['config']->value['sy_web_city_two']) {?>
                            <a href="<?php echo smarty_function_listurl(array('m'=>'resume','untype'=>'cityid'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['cityid']];?>
</a>
                            <?php }?>
                            <?php if ($_GET['three_cityid']) {?>
                            <a href="<?php echo smarty_function_listurl(array('m'=>'resume','untype'=>'three_cityid'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['three_cityid']];?>
</a>
                            <?php }?>
                        <?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['industry_name']->value[$_GET['hy']]) {?>
                        <a href="<?php echo smarty_function_listurl(array('m'=>'resume','untype'=>'hy'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">行业：<?php echo $_smarty_tpl->tpl_vars['industry_name']->value[$_GET['hy']];?>
</a>
                        <?php }?>

                        <?php if ($_GET['minsalary']&&$_GET['maxsalary']) {?>
                        <a href="<?php echo smarty_function_listurl(array('m'=>'resume','untype'=>'salary'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">薪资：<?php echo $_GET['minsalary'];?>
-<?php echo $_GET['maxsalary'];?>
</a>
                        <?php } elseif ($_GET['minsalary']&&!$_GET['maxsalary']) {?>
                        <a href="<?php echo smarty_function_listurl(array('m'=>'resume','untype'=>'salary'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">薪资：<?php echo $_GET['minsalary'];?>
及以上</a>
                        <?php } elseif (!$_GET['minsalary']&&$_GET['maxsalary']) {?>
                        <a href="<?php echo smarty_function_listurl(array('m'=>'resume','untype'=>'salary'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">薪资：<?php echo $_GET['maxsalary'];?>
及以下</a>
                        <?php }?>

                        <?php if ($_GET['minage']&&$_GET['maxage']) {?>
                        <a href="<?php echo smarty_function_listurl(array('m'=>'resume','untype'=>'age'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">年龄：<?php echo $_GET['minage'];?>
-<?php echo $_GET['maxage'];?>
</a>
                        <?php } elseif ($_GET['minage']&&!$_GET['maxage']) {?>
                        <a href="<?php echo smarty_function_listurl(array('m'=>'resume','untype'=>'age'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">年龄：<?php echo $_GET['minage'];?>
及以上</a>
                        <?php }?>

                        <?php if ($_GET['integrity']) {?>
                        <a href="<?php echo smarty_function_listurl(array('m'=>'resume','untype'=>'integrity'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">简历完整度：<?php echo $_smarty_tpl->tpl_vars['integrity_name']->value[$_GET['integrity']];?>
</a>
                        <?php }?>

                        <?php if ($_GET['edu']) {?>
                        <a href="<?php echo smarty_function_listurl(array('m'=>'resume','untype'=>'edu'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">学历：<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_GET['edu']];?>
</a>
                        <?php }?>
                         <?php if ($_GET['exp']) {?>
                        <a href="<?php echo smarty_function_listurl(array('m'=>'resume','untype'=>'exp'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">工作经验：<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_GET['exp']];?>
</a>
                        <?php }?>
                        <?php if ($_GET['tag']) {?>
                        <a href="<?php echo smarty_function_listurl(array('m'=>'resume','untype'=>'tag'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">个人标签：<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_GET['tag']];?>
</a>
                        <?php }?>
                        <?php if ($_GET['sex']) {?>
                        <a href="<?php echo smarty_function_listurl(array('m'=>'resume','untype'=>'sex'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">性别：<?php echo $_smarty_tpl->tpl_vars['user_sex']->value[$_GET['sex']];?>
</a>
                        <?php }?>
                        <?php if ($_GET['type']) {?>
                        <a href="<?php echo smarty_function_listurl(array('m'=>'resume','untype'=>'type'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">工作类型：<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_GET['type']];?>
</a>
                        <?php }?>
                        <?php if ($_GET['report']) {?>
                        <a href="<?php echo smarty_function_listurl(array('m'=>'resume','untype'=>'report'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">到岗时间：<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_GET['report']];?>
</a>
                        <?php }?>
                        <?php if ($_GET['uptime']) {?>
                        <a href="<?php echo smarty_function_listurl(array('m'=>'resume','untype'=>'uptime'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">更新时间：<?php echo $_smarty_tpl->tpl_vars['uptime']->value[$_GET['uptime']];?>
</a>
                        <?php }?>
                        <?php if ($_GET['keyword']) {?>
                        <a href="<?php echo smarty_function_listurl(array('m'=>'resume','untype'=>'keyword'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac"><?php echo $_GET['keyword'];?>
</a>
                        <?php }?>
                        <?php if ($_GET['idcard']) {?>
                        <a href="<?php echo smarty_function_listurl(array('m'=>'resume','untype'=>'idcard'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">有身份验证</a>
                        <?php }?>
                        <?php if ($_GET['work']) {?>
                        <a href="<?php echo smarty_function_listurl(array('m'=>'resume','untype'=>'work'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">有作品</a>
                        <?php }?> &nbsp;
                    </div>
                    <?php }?>
                </div>
                <div class="clear"></div>
                <div class="user_zk"> <a href="javascript:;" onclick="$('.searchmorelist').toggle()" class="user_zk_b "></a></div>
            </form>

            <div class="search_h1_box">
                <div class="search_h1_box_title">
                    <ul class="search_h1_box_list">
                        <li <?php if ($_GET['pic']=='') {?>class="search_job_all " <?php }?> class="search_job_all ">
                            <a href="<?php echo smarty_function_url(array('m'=>'resume','c'=>'search'),$_smarty_tpl);?>
">所有人才</a><i class="search_h1_box_list_icon"></i>
                        </li>
                        <li <?php if ($_GET['order']=='lastdate') {?>class="search_Filter_current" <?php }?>>
                            <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'order','v'=>'lastdate'),$_smarty_tpl);?>
"><span>更新时间</span><i class="search_Filter_icon"></i></a>
                        </li>
                        <li <?php if ($_GET['order']=='ctime') {?>class="search_Filter_current" <?php }?>>
                            <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'order','v'=>'ctime'),$_smarty_tpl);?>
"><span>发布时间</span><i class="search_Filter_icon"></i></a>
                        </li>
                        <li class="<?php if ($_GET['pic']) {?>search_h1_box_cur<?php }?> job_tj_t">
                            <a href="<?php if ($_GET['pic']) {
echo smarty_function_listurl(array('m'=>'resume','type'=>'tp','v'=>0),$_smarty_tpl);
} else {
echo smarty_function_listurl(array('m'=>'resume','type'=>'tp','v'=>1),$_smarty_tpl);
}?>" class="job_zt">有照片<i class="job_tj_chk"></i></a>
                        </li>
                         <li class="<?php if ($_GET['idcard']) {?>search_h1_box_cur<?php }?>">
                            <a href="<?php if ($_GET['idcard']) {
echo smarty_function_listurl(array('m'=>'resume','type'=>'idcard','v'=>0),$_smarty_tpl);
} else {
echo smarty_function_listurl(array('m'=>'resume','type'=>'idcard','v'=>1),$_smarty_tpl);
}?>" class="job_zt">实名认证<i class="job_tj_chk"></i></a>
                        </li>
                        <li class="<?php if ($_GET['work']) {?>search_h1_box_cur<?php }?>">
                            <a href="<?php if ($_GET['work']) {
echo smarty_function_listurl(array('m'=>'resume','type'=>'work','v'=>0),$_smarty_tpl);
} else {
echo smarty_function_listurl(array('m'=>'resume','type'=>'work','v'=>1),$_smarty_tpl);
}?>" class="job_zt">有作品<i class="job_tj_chk"></i></a>
                        </li>
                    </ul>

                    <div class="search_mxbox"> <a href="<?php echo smarty_function_listurl(array('m'=>'resume','untype'=>'rtype'),$_smarty_tpl);?>
" class="search_mx <?php if ($_GET['rtype']!='1') {?>search_mxcur<?php }?>"><i class="search_mx_a"></i></a> <a href="<?php echo smarty_function_listurl(array('m'=>'resume','type'=>'rtype','v'=>1),$_smarty_tpl);?>
" class="search_mx <?php if ($_GET['rtype']=='1') {?>search_mxcur<?php }?>"><i class="search_mx_b"></i></a> </div>
                    <div class="search_h1_box_t fr">提升招聘效果，请致电：<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_freewebtel'];?>
</div>
                </div>
            </div>

            <div class="user_left_sidebar">

                <?php if ($_smarty_tpl->tpl_vars['config']->value['com_search']==1&&$_smarty_tpl->tpl_vars['config']->value['com_status_search']==1) {?>

                    <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_user_visit_resume']==0) {?>
                        <?php if (!$_smarty_tpl->tpl_vars['uid']->value||$_smarty_tpl->tpl_vars['usertype']->value==1||$_smarty_tpl->tpl_vars['r_status']->value!=1) {?>

                            <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/resume/topfour_list.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


                            <?php if (!$_smarty_tpl->tpl_vars['uid']->value||$_smarty_tpl->tpl_vars['usertype']->value==1) {?>

                            <div class=" search_nologin_user_bg">

                                <div class="search_nologin_tip_t">成为企业会员，高效挑选人才！</div>

                                <?php if (!$_smarty_tpl->tpl_vars['uid']->value) {?>
                                    <div class="search_nologin_tip_p"> 登录或注册后可以查看更多简历信息~</div>
                                <?php } else { ?>
                                    <div class="search_nologin_tip_p"></div>
                                <?php }?>

                                <dl class="search_nologin_tip_wx">
                                    <dt><img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_wx_qcode'];?>
"  width="130" height="130"></dt>
                                    <dd>扫一扫，让招聘更轻松</dd>
                                </dl>

                                <div class="search_nologin_tip_bth">
                                    <?php if ($_smarty_tpl->tpl_vars['usertype']->value==1) {?>
                                        <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_user_change']==1) {?>
                                            <a href="javascript:void(0)" onclick="changeutype()">身份切换</a>
                                        <?php } else { ?>
                                        <a href="javascript:void(0)" onclick="logoutUser('<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/index.php?c=logout', '<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/login')">登录企业</a>
                                        <?php }?>
                                    <?php } else { ?>
                                        <a href="<?php echo smarty_function_url(array('m'=>'register'),$_smarty_tpl);?>
">注册会员</a>
                                        <a href="javascript:void(0);" onclick="showlogin('2');" class="search_nologin_tip_bth_have">登录账号</a>
                                    <?php }?>
                                </div>
                                <div class="search_nologin_tip_tel">如有需要任何贴心的服务：<span class="search_nologin_tip_tel_n"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_freewebtel'];?>
</span></div>
                            </div>
                            <?php } else { ?>

                            <div class=" search_nologin_user_bg">
                                <div class="search_nologin_tip_t">账户正在审核中，无法挑选人才！</div>
                                <div class="search_nologin_tip_p"></div>
                                <dl class="search_nologin_tip_wx">
                                    <dt><img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_wx_qcode'];?>
"  width="130" height="130"></dt>
                                    <dd>扫一扫，让招聘更轻松</dd>
                                </dl>
                                <div class="search_nologin_tip_p">联系客服，加快审核，高效挑选人才</div>
                                <div class="search_nologin_tip_tel">贴心服务热线：<span class="search_nologin_tip_tel_n"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_freewebtel'];?>
</span></div>
                            </div>
                            <?php }?>

                        <?php } else { ?>

                            <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/resume/normal_list.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


                        <?php }?>
                    <?php } elseif ($_smarty_tpl->tpl_vars['config']->value['sy_user_visit_resume']==1) {?>
                        <?php if ($_smarty_tpl->tpl_vars['usertype']->value!=1) {?>

                            <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/resume/topfour_list.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


                            <?php if (!$_smarty_tpl->tpl_vars['uid']->value) {?>

                                <div class=" search_nologin_user_bg">

                                <div class="search_nologin_tip_t">成为企业会员，高效挑选人才！</div>

                                <?php if (!$_smarty_tpl->tpl_vars['uid']->value) {?>
                                <div class="search_nologin_tip_p"> 登录或注册后可以查看更多简历信息~</div>
                                <?php } else { ?>
                                <div class="search_nologin_tip_p"></div>
                                <?php }?>

                                <dl class="search_nologin_tip_wx">
                                    <dt><img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_wx_qcode'];?>
"  width="130" height="130"></dt>
                                    <dd>扫一扫，让招聘更轻松</dd>
                                </dl>

                                <div class="search_nologin_tip_bth">
                                    <?php if ($_smarty_tpl->tpl_vars['usertype']->value==1) {?>
                                    <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_user_change']==1) {?>
                                    <a href="javascript:void(0)" onclick="changeutype()">身份切换</a>
                                    <?php } else { ?>
                                    <a href="javascript:void(0)" onclick="logoutUser('<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/index.php?c=logout', '<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/login')">登录企业</a>
                                    <?php }?>
                                    <?php } else { ?>
                                    <a href="<?php echo smarty_function_url(array('m'=>'register'),$_smarty_tpl);?>
">注册会员</a>
                                    <a href="javascript:void(0);" onclick="showlogin('2');" class="search_nologin_tip_bth_have">登录账号</a>
                                    <?php }?>
                                </div>
                                <div class="search_nologin_tip_tel">如有需要任何贴心的服务：<span class="search_nologin_tip_tel_n"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_freewebtel'];?>
</span></div>
                            </div>
                            <?php } elseif ($_smarty_tpl->tpl_vars['r_status']->value!=1) {?>

                                <div class=" search_nologin_user_bg">
                                    <div class="search_nologin_tip_t">账户正在审核中，无法挑选人才！</div>
                                    <div class="search_nologin_tip_p"></div>
                                    <dl class="search_nologin_tip_wx">
                                        <dt><img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_wx_qcode'];?>
"  width="130" height="130"></dt>
                                        <dd>扫一扫，让招聘更轻松</dd>
                                    </dl>
                                    <div class="search_nologin_tip_p">联系客服，加快审核，高效挑选人才</div>
                                    <div class="search_nologin_tip_tel">贴心服务热线：<span class="search_nologin_tip_tel_n"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_freewebtel'];?>
</span></div>
                                </div>
                            <?php } else { ?>

                                <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/resume/normal_list.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

                            <?php }?>

                        <?php } else { ?>

                            <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/resume/normal_list.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


                        <?php }?>

                    <?php }?>

                <?php } elseif ($_smarty_tpl->tpl_vars['config']->value['com_search']==1&&$_smarty_tpl->tpl_vars['config']->value['com_status_search']!=1) {?>

                    <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_user_visit_resume']==0) {?>
                        <?php if (!$_smarty_tpl->tpl_vars['uid']->value||$_smarty_tpl->tpl_vars['usertype']->value==1) {?>

                            <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/resume/topfour_list.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


                            <div class=" search_nologin_user_bg">

                                <div class="search_nologin_tip_t">成为企业会员，高效挑选人才！</div>

                                <?php if (!$_smarty_tpl->tpl_vars['uid']->value) {?>
                                    <div class="search_nologin_tip_p"> 登录或注册后可以查看更多简历信息~</div>
                                <?php } else { ?>
                                    <div class="search_nologin_tip_p"></div>
                                <?php }?>

                                <dl class="search_nologin_tip_wx">
                                    <dt><img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_wx_qcode'];?>
"  width="130" height="130"></dt>
                                    <dd>扫一扫，让招聘更轻松</dd>
                                </dl>

                                <div class="search_nologin_tip_bth">
                                    <?php if ($_smarty_tpl->tpl_vars['usertype']->value==1) {?>
                                        <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_user_change']==1) {?>
                                            <a href="javascript:void(0)" onclick="changeutype()">身份切换</a>
                                        <?php } else { ?>
                                        <a href="javascript:void(0)" onclick="logoutUser('<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/index.php?c=logout', '<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/login')">登录企业</a>
                                        <?php }?>
                                    <?php } else { ?>
                                        <a href="<?php echo smarty_function_url(array('m'=>'register'),$_smarty_tpl);?>
">注册会员</a>
                                        <a href="javascript:void(0);" onclick="showlogin('2');" class="search_nologin_tip_bth_have">登录账号</a>
                                    <?php }?>
                                </div>
                                <div class="search_nologin_tip_tel">如有需要任何贴心的服务：<span class="search_nologin_tip_tel_n"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_freewebtel'];?>
</span></div>
                            </div>
                        <?php } else { ?>

                            <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/resume/normal_list.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


                        <?php }?>

                    <?php } elseif ($_smarty_tpl->tpl_vars['config']->value['sy_user_visit_resume']==1) {?>
                        <?php if (!'uid') {?>

                            <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/resume/topfour_list.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


                            <div class=" search_nologin_user_bg">

                            <div class="search_nologin_tip_t">成为企业会员，高效挑选人才！</div>

                            <?php if (!$_smarty_tpl->tpl_vars['uid']->value) {?>
                            <div class="search_nologin_tip_p"> 登录或注册后可以查看更多简历信息~</div>
                            <?php } else { ?>
                            <div class="search_nologin_tip_p"></div>
                            <?php }?>

                            <dl class="search_nologin_tip_wx">
                                <dt><img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_wx_qcode'];?>
"  width="130" height="130"></dt>
                                <dd>扫一扫，让招聘更轻松</dd>
                            </dl>

                            <div class="search_nologin_tip_bth">
                                <?php if ($_smarty_tpl->tpl_vars['usertype']->value==1) {?>
                                <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_user_change']==1) {?>
                                <a href="javascript:void(0)" onclick="changeutype()">身份切换</a>
                                <?php } else { ?>
                                <a href="javascript:void(0)" onclick="logoutUser('<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/index.php?c=logout', '<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/login')">登录企业</a>
                                <?php }?>
                                <?php } else { ?>
                                <a href="<?php echo smarty_function_url(array('m'=>'register'),$_smarty_tpl);?>
">注册会员</a>
                                <a href="javascript:void(0);" onclick="showlogin('2');" class="search_nologin_tip_bth_have">登录账号</a>
                                <?php }?>
                            </div>
                            <div class="search_nologin_tip_tel">如有需要任何贴心的服务：<span class="search_nologin_tip_tel_n"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_freewebtel'];?>
</span></div>
                        </div>
                        <?php } else { ?>

                            <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/resume/normal_list.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


                        <?php }?>
                    <?php }?>
                <?php } elseif ($_smarty_tpl->tpl_vars['config']->value['com_search']!=1&&$_smarty_tpl->tpl_vars['config']->value['com_status_search']==1) {?>
                    <!-- 不存在这种情况 -->
                <?php } elseif ($_smarty_tpl->tpl_vars['config']->value['sy_user_visit_resume']==0) {?>

                    <?php if (!$_smarty_tpl->tpl_vars['uid']->value||$_smarty_tpl->tpl_vars['usertype']->value==1) {?>

                        <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/resume/topfour_list.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


                        <div class=" search_nologin_user_bg">

                        <div class="search_nologin_tip_t">成为企业会员，高效挑选人才！</div>

                        <?php if (!$_smarty_tpl->tpl_vars['uid']->value) {?>
                            <div class="search_nologin_tip_p"> 登录或注册后可以查看更多简历信息~</div>
                        <?php } else { ?>
                            <div class="search_nologin_tip_p"></div>
                        <?php }?>

                        <dl class="search_nologin_tip_wx">
                            <dt><img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_wx_qcode'];?>
"  width="130" height="130"></dt>
                            <dd>扫一扫，让招聘更轻松</dd>
                        </dl>

                        <div class="search_nologin_tip_bth">
                            <?php if ($_smarty_tpl->tpl_vars['usertype']->value==1) {?>
                                <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_user_change']==1) {?>
                                    <a href="javascript:void(0)" onclick="changeutype()">身份切换</a>
                                <?php } else { ?>
                                <a href="javascript:void(0)" onclick="logoutUser('<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/index.php?c=logout', '<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/login')">登录企业</a>
                                <?php }?>
                            <?php } else { ?>
                                <a href="<?php echo smarty_function_url(array('m'=>'register'),$_smarty_tpl);?>
">注册会员</a>
                                <a href="javascript:void(0);" onclick="showlogin('2');" class="search_nologin_tip_bth_have">登录账号</a>
                            <?php }?>
                        </div>
                        <div class="search_nologin_tip_tel">如有需要任何贴心的服务：<span class="search_nologin_tip_tel_n"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_freewebtel'];?>
</span></div>
                    </div>
                    <?php } else { ?>

                        <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/resume/normal_list.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


                    <?php }?>
                <?php } elseif ($_smarty_tpl->tpl_vars['config']->value['sy_user_visit_resume']==1) {?>

                    <?php if (!$_smarty_tpl->tpl_vars['uid']->value) {?>
                        <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/resume/topfour_list.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

                        <div class=" search_nologin_user_bg">
                            <div class="search_nologin_tip_t">成为企业会员，高效挑选人才！</div>
                            <div class="search_nologin_tip_p"> 登录或注册后可以查看更多简历信息~</div>
                            <dl class="search_nologin_tip_wx">
                                <dt><img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_wx_qcode'];?>
"  width="130" height="130"></dt>
                                <dd>扫一扫，让招聘更轻松</dd>
                            </dl>
                            <div class="search_nologin_tip_bth">
                                <a href="<?php echo smarty_function_url(array('m'=>'register'),$_smarty_tpl);?>
">注册会员</a>
                                <a href="javascript:void(0);" onclick="showlogin('2');" class="search_nologin_tip_bth_have">登录账号</a>
                            </div>
                            <div class="search_nologin_tip_tel">如有需要任何贴心的服务：<span class="search_nologin_tip_tel_n"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_freewebtel'];?>
</span></div>
                        </div>
                    <?php } else { ?>

                        <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/resume/normal_list.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


                    <?php }?>
                <?php }?>

            </div>
                <div class="yun_job_list_right">
         <div class="yun_job_list_right_banner">
                <?php  $_smarty_tpl->tpl_vars['adlist_36'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['adlist_36']->_loop = false;
global $db,$db_config,$config;$AdArr=array();$paramer=array();$attr=array("classid"=>"36","limit"=>"5","item"=>"'adlist_36'","nocache"=>"")
;
			include(PLUS_PATH.'pimg_cache.php');$add_arr = $ad_label[36];if(is_array($add_arr) && !empty($add_arr)){
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
foreach ($AdArr as $_smarty_tpl->tpl_vars['adlist_36']->key => $_smarty_tpl->tpl_vars['adlist_36']->value) {
$_smarty_tpl->tpl_vars['adlist_36']->_loop = true;
?>
                <?php echo $_smarty_tpl->tpl_vars['adlist_36']->value['html'];?>

                <?php } ?>
            </div>
            <div class="user_recommendation">

                <div class="job_recommendation_title"><span class="job_recommendation_span"><i class="job_recommendation_span_line"></i>简历推荐</span></div>
                <div class="userresume_recommendation">
                    <ul>
                        <?php  $_smarty_tpl->tpl_vars['userrec'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['userrec']->_loop = false;
$userrec=array();global $db,$db_config,$config;
		if(is_array($_GET)){
			foreach($_GET as $key=>$value){
				if($value=='0'){
					unset($_GET[$key]);
				}
			}
		}
		$paramer=array("limit"=>"18","post_len"=>"18","rec_resume"=>"1","item"=>"'userrec'","nocache"=>"")
;
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
		$Purl =  $ParamerArr[purl];
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }

	    //处理类别字段
	    include(CONFIG_PATH."db.data.php");	
		$cache_array = $db->cacheget();
        $fscache_array = $db->fscacheget();
		$userclass_name = $cache_array["user_classname"];
		$city_name      = $cache_array["city_name"];
        $city_index     = $cache_array["city_index"];
		$job_name		= $cache_array["job_name"];
        $job_index		= $cache_array["job_index"];
		$job_type		= $cache_array["job_type"];
		$industry_name	= $cache_array["industry_name"];
        $city_parent    = $fscache_array["city_parent"];
        $job_parent     = $fscache_array["job_parent"];

		//是否属于分站下
		if($config['sy_web_site']=="1"){
			if($config[province]>0 && $config[province]!=""){
				$paramer[provinceid] = $config[province];
			}
			if($config['cityid']>0 && $config['cityid']!=""){
				$paramer['cityid']=$config['cityid'];
			}
			if($config['three_cityid']>0 && $config['three_cityid']!=""){
				$paramer['three_cityid']=$config['three_cityid'];
			}
			if($config['hyclass']>0 && $config['hyclass']!=""){
				$paramer['hy']=$config['hyclass'];
			}
		}

		
		$where = "a.`defaults`=1 and a.`state`=1 and a.`r_status`=1 AND a.`status`=1";

        //关注我公司的人才--条件
		if($paramer[where_uid]){
			$where .=" AND a.`uid` in (".$paramer['where_uid'].")";
		}
		//黑名单不能查看已拉黑的个人用户简历
		if($_COOKIE['uid']&&$_COOKIE['usertype']=="2"){
			$blacklist=$db->select_all("blacklist","`p_uid`='".$_COOKIE['uid']."'","c_uid");
			if(is_array($blacklist)&&$blacklist){
				foreach($blacklist as $v){
					$buid[]=$v['c_uid'];
				}
			    $where .=" AND a.`uid` NOT IN (".@implode(",",$buid).")";
			}
		}

        //置顶
		if($paramer[topdate]){
			$where .=" AND a.`top`=1 AND a.`topdate`>'".time()."'";
		}
		if($paramer[top]){
			$where .=" AND a.`top`=1 AND a.`topdate`>'".time()."'";
		}
        //身份认证
		if($paramer[idcard]){
			$where .=" AND a.`idcard_status`=1";
		}
		//优质人才
		if($paramer[height_status]){
			$where .=" AND a.`height_status`=".$paramer[height_status];
		}
		//优质人才推荐
		if($paramer[rec]){
			$where .=" AND a.`rec`=1";
		}
		//普通推荐
		if($paramer[rec_resume]){
			$where .=" AND a.`rec_resume`=1";
		}
		//作品
		if($paramer[work]){
			$show=$db->select_all("resume_show","1 group by eid","`eid`");
			if(is_array($show)){
				foreach($show as $v){
					$eid[]=$v['eid'];
				}
			}
			$where .=" AND a.`id` in (".@implode(",",$eid).")";
		}
		//标签
		if($paramer[tag]){
		    $tagname=$userclass_name[$paramer[tag]];
			$tag=$db->select_all("resume","`def_job`>0 and `r_status`=1 and `status`=1 and FIND_IN_SET('".$tagname."',`tag`)","`def_job`");
			if(is_array($tag)){
				foreach($tag as $v){
					$tagid[]=$v['def_job'];
				}
			}
			$where .=" AND a.`id` in (".@implode(",",$tagid).")";
		}
		//更新时间区间
		if($paramer[uptime]){
			if($paramer[uptime]==1){
				$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
    			$where.=" AND a.`lastupdate`>$beginToday";
    		}else{
    			$time=time();
				$uptime = $time-($paramer[uptime]*86400);
				$where.=" AND a.`lastupdate`>$uptime";
    		}
		}else{
		    if($config[sy_datacycle]>0){
                // 后台-页面设置-数据周期
		        $uptime = strtotime('-'.$config[sy_datacycle].' day');
				$where.=" AND a.`lastupdate`>$uptime";
		    }
		}		
		//添加时间区间，即审核时间
		if($paramer[adtime]){
			$time=time();
			$adtime = $time-($paramer[adtime]*86400);
			$where.=" AND a.`status_time`>$adtime";
		}
		//是否有照片
		if($paramer[pic]=="1"){
			$where .=" AND a.`photo`<>'' AND a.`phototype`!=1 AND a.`defphoto` = 1";
		}
        //行业
		if($paramer['hy']!=""){
			$where .= " AND a.`hy` IN (".$paramer['hy'].")";
		}


        $job_col = $city_col = "";
        $cjwhere = "";
		if($paramer[three_cityid]){
		    $city_col = "three_cityid";
		    $cjwhere .= " AND cj.`$city_col`= $paramer[three_cityid]";
		}elseif($paramer[cityid]){
		    $city_col = "cityid";
		    $cjwhere .= " AND cj.`$city_col`= $paramer[cityid]";
		}elseif($paramer[provinceid]){
		    $city_col = "provinceid";
		    $cjwhere .= " AND cj.`$city_col`= $paramer[provinceid]";
		}
        //城市区间,不建议执行该查询
		if($paramer[cityin]){
            if($city_parent[$paramer[cityin]]=='0'){
		        $city_col = "provinceid";
				$cjwhere .= " AND cj.`$city_col` = $paramer[cityin]";
			}elseif(in_array($city_parent[$paramer[cityin]],$city_index)){
		        $city_col = "cityid";
				$cjwhere .= " AND cj.`$city_col` = $paramer[cityin]";
			}elseif($city_parent[$paramer[cityin]]>0){
		        $city_col = "three_cityid";
				$cjwhere .= " AND cj.`$city_col` = $paramer[cityin]";
			}
		}
		if($paramer[job_post]){
		    $job_col = "job_post";
		    $cjwhere .= " AND cj.`$job_col`= $paramer[job_post]";
		}elseif($paramer[job1_son]){
		    $job_col = "job1_son";
		    $cjwhere .= " AND cj.`$job_col`= $paramer[job1_son]";
		}elseif($paramer[job1]){
		    $job_col = "job1";
		    $cjwhere .= " AND cj.`$job_col`= $paramer[job1]";
		}
        //职位区间,不建议执行该查询
		if($paramer[jobin]){
            if($job_parent[$paramer[jobin]]=='0'){
		        $job_col = "job1";
				$cjwhere .=" AND cj.`$job_col`= $paramer[jobin]";
			}elseif(in_array($job_parent[$paramer[jobin]],$job_index)){
		        $job_col = "job1_son";
				$cjwhere .=" AND cj.`$job_col`= $paramer[jobin]";
			}elseif($job_parent[$paramer[jobin]]>0){
		        $job_col = "job_post";
				$cjwhere .=" AND cj.`$job_col`= $paramer[jobin]";
			}
		}
		// 拼接唯一标识字段
		if($city_col || $job_col){
		    if($city_col && $job_col){
		        $cjwhere .= " AND cj.`{$city_col}_{$job_col}_num`= 1";
		    }elseif($city_col){
		        $cjwhere .= " AND cj.`{$city_col}_num`= 1";
		    }elseif($job_col){
		        $cjwhere .= " AND cj.`{$job_col}_num`= 1";
		    }
		}
		
		//工作经验
		if($paramer[exp]){
		    
		    $expKey =   $db->DB_select_once("userclass", "`variable` = 'user_word'", "`id`");
		    $expReq =   $db->DB_select_once("userclass",  "`id` = $paramer[exp]", "`sort`,`name`");
		    if($expReq[name] != "不限"){
		     
                $expArr =   $db->select_all("userclass", "`keyid` = $expKey[id] AND `sort` >= $expReq[sort]", "`id`");
                $expIds =   array();
                foreach($expArr as $v){
                    $expIds[]   =   $v[id];
                }
			    $where .= " AND a.`exp` in (".@implode(",",$expIds).")";
	        }
		}
		//学历
		if($paramer[edu]){
		
		    $eduKey =   $db->DB_select_once("userclass", "`variable` = 'user_edu'", "`id`");
		    $eduReq =   $db->DB_select_once("userclass", "`id` = $paramer[edu]", "`sort`,`name`");
		    if($eduReq[name] != "不限"){
		    
                $eduArr =   $db->select_all("userclass", "`keyid` = $eduKey[id] AND `sort` >= $eduReq[sort]", "`id`");
                $eduIds =   array();
                foreach($eduArr as $v){
                    $eduIds[]   =   $v[id];
                }
                
                $where .= " AND a.`edu` in (".@implode(",",$eduIds).")";
			}
		}
		//性别
		if($paramer[sex]){
			$where .=" AND a.`sex`=$paramer[sex]";
		}
		//到岗时间
		if($paramer[report]){
			$where .=" AND a.`report`=$paramer[report]";
		}
		//工作性质
		if($paramer[type]){
			$where .= " AND a.`type`=$paramer[type]";
		}
		if($paramer[notid]){
			$where.= " and `id`<>$paramer[notid]";
		}
		//简历完整度
		

		if($paramer[integrity]){
		 	$integrityR	=	$arr_data["integrity_val"];
		 	
		 	$where.= " AND a.`integrity`>='".$integrityR[$paramer[integrity]]."'";

		}

		//关键字
		if($paramer[keyword]){
			$where1 = array();
			$where1[]="a.`name` LIKE '%$paramer[keyword]%'";
			$where1[]="a.`uname` LIKE '%$paramer[keyword]%'";
			
			//搜索工作经历 
			$workList = $db->select_all('resume_work',"`title` LIKE '%$paramer[keyword]%' OR `content` LIKE '%$paramer[keyword]%' ORDER BY id DESC limit 500","`eid`");
			if(!empty($workList)){
				$workId = array();
				foreach($workList as $value){
					$workId[] = $value['eid'];
				}
				$where1[]	=	"a.id IN (".implode(',',$workId).")";
			}
           
            $where.=" AND (".@implode(" or ",$where1).")";
		}
		//薪资待遇
		if($paramer[minsalary]&&$paramer[maxsalary]){
			$where.= " AND ((a.`minsalary`<=".intval($paramer[minsalary])." and a.`maxsalary`>=".intval($paramer[minsalary]).") 
						or (a.`minsalary`<=".intval($paramer[maxsalary])." and a.`maxsalary`>=".intval($paramer[maxsalary])."))";
		}elseif($paramer[minsalary]&&!$paramer[maxsalary]){
			$where.= " AND ((a.`minsalary`<=".intval($paramer[minsalary])." and a.`maxsalary`>=".intval($paramer[minsalary]).") 
						or (a.`minsalary`>=".intval($paramer[minsalary])." and a.`maxsalary`>=".intval($paramer[minsalary]).")
						or (a.`minsalary`!=0 and  a.`maxsalary`=0))";
		}elseif(!$paramer[minsalary]&&$paramer[maxsalary]){
			$where.= " AND ((a.`minsalary`<=".intval($paramer[maxsalary])." and a.`maxsalary`>=".intval($paramer[maxsalary]).")
						or (a.`minsalary`<=".intval($paramer[maxsalary])." and a.`maxsalary`<=".intval($paramer[maxsalary]).")  
						or (a.`minsalary`<=".intval($paramer[maxsalary])." and a.`maxsalary`=0) 
						or (a.`minsalary`=0 and a.`maxsalary`!=0)
						)";
		}
		//年龄
		if($paramer[minage]&&$paramer[maxage]){
			$mintime=date("Y-m-d",strtotime("-".$paramer[minage]." year"));
			$maxtime=date("Y-m-d",strtotime("-".$paramer[maxage]." year"));
			$where.= " AND a.`birthday`>= '".$maxtime."' and a.`birthday`<='".$mintime."'";
		}elseif($paramer[minage]&&!$paramer[maxage]){
			$mintime=date("Y-m-d",strtotime("-".$paramer[minage]." year"));
			$where.= " AND a.`birthday`<='".$mintime."'";
		}elseif(!$paramer[minage]&&$paramer[maxage]){
			$maxtime=date("Y-m-d",strtotime("-".$paramer[maxage]." year"));
			$where.= " AND a.`birthday`>='".$maxtime."'";
		}
        //排序字段默认为更新时间
		if($paramer[order] && $paramer[order]!="lastdate"){
			if($paramer[order]=='topdate'){
				$nowtime=time();
				$order = " ORDER BY if(a.`topdate`>$nowtime,a.`topdate`,a.`lastupdate`) ";
			}else{
				$order = " ORDER BY a.`".$paramer[order]."` ";
			}
		}else{
			$order = " ORDER BY a.`lastupdate` ";
		}
		//排序规则 默认为倒序
		$sort = $paramer[sort]?$paramer[sort]:"DESC";
		//查询条数
		if($paramer[limit]){
			$limit=" LIMIT ".$paramer[limit];
		}
		//自定义查询条件，默认取代上面任何参数直接使用该语句
		if($paramer[where]){
			$where = $paramer[where];
		}
        $pagewhere = "";$joinwhere = "";
        if($cjwhere){
            $pagewhere.=" ,`".$db_config[def]."resume_city_job_class`  cj ";
            $joinwhere .= " a.`id`=cj.`eid` " . $cjwhere;
        }
        
		if($paramer[ispage]){
            // 查询分页
			if($paramer["height_status"]){
				$limit = PageNav($paramer,$_GET,"resume_expect",$where,$Purl,"",$paramer[islt]?$paramer[islt]:"3",$_smarty_tpl,$pagewhere,$joinwhere);
			}else{
				$limit = PageNav($paramer,$_GET,"resume_expect",$where,$Purl,"","0",$_smarty_tpl,$pagewhere,$joinwhere);
			}
		}

		if($paramer[topdate] && $_GET[page]>1){
			$userrec = array();
		}else{
			
			$select="a.`id`,a.`uid`,a.`name`,a.`hy`,a.`job_classid`,a.`city_classid`,a.`jobstatus`,a.`type`,a.`report`,a.`lastupdate`,a.`rec`,a.`top`,a.`topdate`,a.`rec_resume`,a.`ctime`,a.`uname`,a.`idcard_status`,a.`minsalary`,a.`maxsalary`";
			if($pagewhere!=""){

				$sql = "select ".$select." from `".$db_config[def]."resume_expect` a ".$pagewhere." where ".$joinwhere." and ".$where.$order.$sort.$limit;

				$userrec=$db->DB_query_all($sql,"all");

			}else{
				$sql = "select ".$select." from `".$db_config[def]."resume_expect` a where ".$where.$order.$sort.$limit;
				
				$userrec=$db->DB_query_all($sql,"all");
			}
		}
        
		if(!empty($userrec) && is_array($userrec)){
			
			//如果存在top，则说明请求来自排行榜页面
			if($paramer['top']){
				$uids=$m_name=array();
				foreach($userrec as $k=>$v){
					$uids[]=$v[uid];
				}

				$member=$db->select_all($db_config[def]."member","`uid` in(".@implode(',',$uids).")","uid,username");
				foreach($member as $val){
					$m_name[$val[uid]]=$val['username'];
				}
			}
			$uid = $eid = array();
			foreach($userrec as $key=>$value){
				
				$uid[] = $value['uid'];
				$eid[] = $value['id'];
			}
			$eids = @implode(',',$eid);
			$uids = @implode(',',$uid);
            $resume=$db->select_all("resume","`uid` in(".$uids.")","uid,name,nametype,tag,sex,moblie_status,edu,exp,defphoto,photo,phototype,photo_status,birthday");
			foreach($resume as $v){
				$ruids[] = $v['uid'];
			}
			foreach($userrec as $k=>$v){
				if(!in_array($v['uid'],$ruids)){
					unset($userrec[$k]);
					continue;
				}
			}
			if($paramer[topdate]){
				$noids=array();
			}

			if($paramer[workexp] == 1){
				$eduList  = $db -> select_all("resume_edu","`eid` in(".$eids.")");
				if(!empty($eduList)){
					foreach($eduList as $key=>$value){
						$eduListNew[$value['eid']][] = $value;
					}
					foreach($eduListNew as $k=>$eduv){
						$edumin				=		0;
						$edumax				=		0;
						$edutitle			=	array();
						$education			=	array();
						foreach($eduv as $v){
							if($v['sdate']>0 && $edumin==0){
								$edumin		=		$v['sdate'];
							}elseif($edumin>$v['sdate']){
								$edumin		=		$v['sdate'];
							}
							if($v['edate']==0 ){
								$edumax		=		0;
							}elseif($edumax<$v['edate']){
								$edumax		=		$v['edate'];
							}
						
							$education[]	=		$userclass_name[$v['education']];

							$edutitle[]		=		$v['specialty'];
						}
						$return =array();
						$return['edumin']		=		date('Y-m',$edumin);
						$return['edumax']		=		$edumax  == 0 ?  '至今': date('Y',$edumax);
						$return['education']	=		@implode(',',$education);
						$return['eduspecialty']		=		@implode('、',$edutitle);
						
						$return['edu_time']		=		$return['edumin']."-".$return['edumax'];
						
						if($return['eduspecialty']){
						    $workexpList[$k]['edu_content']	=	$return['education'].'学历 ▪ '.$return['eduspecialty'].' ▪ 毕业于'.$return['edumax'].'年';
						}else{
						    $workexpList[$k]['edu_content']	=	$return['education'].'学历 ▪ 毕业于'.$return['edumax'].'年';
						}
					}
					
				}

				$workList  = $db -> select_all("resume_work","`eid` in(".$eids.")");
				if(!empty($workList)){
					foreach($workList as $key=>$value){
						$workListNew[$value['eid']][] = $value;
					}
					foreach($workListNew as $k=>$workv){
						
						$whour     		=   0;
						$hour     	 	=   array();
						$time      		=   time();
						$workmin		=	0;
						$workmax		=	0;
						$worknum		=	count($workv);
						$wtitle			=	array();
						foreach($workv as $v){
							/* 计算每份工作时长(按月) */
							
							if($v['sdate']>0 && $workmin==0){
								$workmin		=		$v['sdate'];
							}elseif($workmin>$v['sdate']){
								$workmin		=		$v['sdate'];
							}
							
							if($v['edate']==0 ){
								$workmax		=		0;
							}elseif($workmax<$v['edate']){
								$workmax		=		$v['edate'];
							}
			
							$wtitle[]			=		$v['title'];
							
							$hour[]   			=		$workTime;
							$whour    			+=   	$workTime;
						}
						
						$workavg   =   ceil($whour/count($hour));
						$return = array();
						$return['worknum']		=		$worknum  > 0 ?  $worknum:0;
						$return['workavg']		=		$workavg  > 0 ?  $workavg:0;
						$return['workmin']		=		date('Y-m',$workmin);
						$return['workmax']		=		$workmax  == 0 ?  '至今': date('Y-m',$workmax);
						$return['worktit']		=		@implode(',',$wtitle);
						
						$return['work_time']	=		$return['workmin'].'-'.$return['workmax'];
						
						if($return['worktit']!=''){
							$workexpList[$k]['work_content']	=	' 参加过'.$return['worknum'].'份工作 ▪ 涉及'.$return['worktit'].'等岗位';
						}else{
							$workexpList[$k]['work_content']	=	' 参加过'.$return['worknum'].'份工作';
						}
					}
				}
			}
			foreach($userrec as $k=>$v){
				if($paramer[topdate]){
					$noids[] = $v[id];
				}
				//筛除重复
				if($paramer[noid]=='1' && !empty($noids) && in_array($v['id'],$noids)){
					unset($userrec[$k]);
					continue;
				}
			    foreach($resume as $val){
			        if($v['uid']==$val['uid']){
			    		$userrec[$k]['edu_n']=$userclass_name[$val['edu']];
				        $userrec[$k]['exp_n']=$userclass_name[$val['exp']];
			            if($val['birthday']){
							$year = date("Y",strtotime($val['birthday']));
							$userrec[$k]['age'] =date("Y")-$year;
						}
						if($val['sex']==152){
							$val['sex']='1';
						}elseif ($val['sex']==153){
							$val['sex']='2';
						}
						$userrec[$k]['sex'] =$arr_data[sex][$val['sex']];
		                $userrec[$k]['phototype']=$val[phototype];
		                $photo=$icon="";
						if($val['defphoto']==2){
		                	$photo=$val['photo'];
		                }else{
							if($config['user_pic']==1 || empty($config['user_pic'])){
				                if($val['photo'] && $val['photo_status']==0 && $val['phototype']!=1){
		            				$photo=$val['photo'];
		            			}else{
		            				if($val['sex']==1){
		            					$icon=$config['sy_member_icon'];
		            				}else{
		            					$icon=$config['sy_member_iconv'];
		            				}
		            			}
		            			
							}elseif($config['user_pic']==2){
								if($val['photo']&& $val['photo_status']==0){
									$photo=$val['photo'];
								}else{
									if($val['sex']==1){
										$icon=$config['sy_member_icon'];
									}else{
										$icon=$config['sy_member_iconv'];
									}
								}
							}elseif($config['user_pic']==3){
								if($val['sex']==1){
									$icon=$config['sy_member_icon'];
								}else{
									$icon=$config['sy_member_iconv'];
								}
							}
						}
						$userrec[$k]['photo']=checkpic($photo,$icon);
						if($val['tag']){
                            $userrec[$k]['tag']=explode(',',$val['tag']);
	                    }
                        $userrec[$k]['nametype']=$val[nametype];
                        $userrec[$k]['moblie_status']=$val[moblie_status];
                        //名称显示处理
						if($config['user_name']==1 || !$config['user_name']){
    						if($val['nametype']==3){
    						    if($val['sex']==1){
    						        $userrec[$k]['username_n'] = mb_substr($val['name'],0,1,'utf-8')."先生";
    						    }else{
    						        $userrec[$k]['username_n'] = mb_substr($val['name'],0,1,'utf-8')."女士";
    						    }
    						}elseif($val['nametype']==2){
    						    $userrec[$k]['username_n'] = "NO.".$v['id'];
    						}else{
    							$userrec[$k]['username_n'] = $val['name'];
    						}
						}elseif($config['user_name']==3){
							if($val['sex']==1){
								$userrec[$k]['username_n'] = mb_substr($val['name'],0,1,'utf-8')."先生";
							}else{
								$userrec[$k]['username_n'] = mb_substr($val['name'],0,1,'utf-8')."女士";
							}
						}elseif($config['user_name']==2){
							$userrec[$k]['username_n'] = "NO.".$v['id'];
						}elseif($config['user_name']==4){
							$userrec[$k]['username_n'] = $val['name'];
						}
                    }
                }
				//更新时间显示方式
				$time=$v['lastupdate'];
				//今天开始时间戳
				$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
				//昨天开始时间戳
				$beginYesterday=mktime(0,0,0,date('m'),date('d')-1,date('Y'));
				if($time>$beginYesterday && $time<$beginToday){
					$userrec[$k]['time'] = "昨天";
				}elseif($time>$beginToday){
					$userrec[$k]['time'] = lastupdateStyle($v['lastupdate']);
					$userrec[$k]['redtime'] =1;
				}else{
					$userrec[$k]['time'] = date("Y-m-d",$v['lastupdate']);
				} 
                
                // 前天
				$beforeYesterday=mktime(0,0,0,date('m'),date('d')-2,date('Y'));

				if($v['ctime']>$beforeYesterday){
					$userrec[$k]['newtime'] =1;
				}
				$userrec[$k]['user_jobstatus_n']=$userclass_name[$v['jobstatus']];
// 				$userrec[$k]['job_city_one']=$city_name[$v['provinceid']];
// 				$userrec[$k]['job_city_two']=$city_name[$v['cityid']];
// 				$userrec[$k]['job_city_three']=$city_name[$v['three_cityid']];
				if($v['minsalary']&&$v['maxsalary']){
					if($config['resume_salarytype']==1){
						$userrec[$k]["salary_n"] = $v['minsalary']."-".$v['maxsalary'];    
					}else{
						if($v[maxsalary]<1000){
							if($config['resume_salarytype']==2){
								$userrec[$k]["salary_n"] = "1千以下";    
							}elseif($config['resume_salarytype']==3){
								$userrec[$k]["salary_n"] = "1K以下";    
							}elseif($config['resume_salarytype']==4){
								$userrec[$k]["salary_n"] = "1k以下";    
							}
						}else{
							$userrec[$k]["salary_n"] = changeSalary($v['minsalary'])."-".changeSalary($v['maxsalary']);    
						}
					}
                }else if($v['minsalary']){
                	if($config['resume_salarytype']==1){
                		$userrec[$k]["salary_n"] = $v['minsalary'];  
            		}else{
            			$userrec[$k]["salary_n"] = changeSalary($v['minsalary']);  
            		}
                }else{
    				$userrec[$k]["salary_n"] = "面议";
    			}
				$userrec[$k]['report_n']=$userclass_name[$v['report']];
				$userrec[$k]['type_n']=$userclass_name[$v['type']];
				$userrec[$k]['lastupdate']=date("Y-m-d",$v['lastupdate']);
					
				$userrec[$k]['user_url']=Url("resume",array("c"=>"show","id"=>$v['id']),"1");
				$userrec[$k]["hy_info"]=$industry_name[$v['hy']];
				if($paramer['top']){
					$userrec[$k]['m_name']=$m_name[$v['uid']];
					$userrec[$k]['user_url']=Url("ask",array("c"=>"friend","a"=>"myquestion","uid"=>$v['uid']));
				}
				$userrec[$k]['work_content']=$workexpList[$v['id']]['work_content'];
				$userrec[$k]['edu_content']=$workexpList[$v['id']]['edu_content'];

				$kjob_classid=@explode(",",$v['job_classid']);
				$kjob_classid=array_unique($kjob_classid);	
				$jobname=array();
				if(is_array($kjob_classid)){
					foreach($kjob_classid as $val){
					    if($val!=''){
					        if($paramer['keyword']){
                               $jobname[]=str_replace($paramer['keyword'],"<font color=#FF6600 >".$paramer['keyword']."</font>",$job_name[$val]);
                            }else{
                               $jobname[]=$job_name[$val];
                            }
                        }
					}
				}
				//$userrec[$k]['job_post']=@implode(",",$jobname);
				$userrec[$k]['expectjob']=$jobname;
				$kcity_classid=@explode(",",$v['city_classid']);
				$kcity_classid=array_unique($kcity_classid);	
				$cityname=array();
				if(is_array($kcity_classid)){
					foreach($kcity_classid as $val){
					    if($val!=''){
					       
                            $cityname[]=$city_name[$val];
                            
                        }
					}
				}
                //$userrec[$k]['citylist']=@implode("/",$cityname);
				$userrec[$k]['expectcity']=$cityname;
				//截取标题
				if($paramer['post_len']){
					$postname[$k]=@implode(",",$jobname);
					$userrec[$k]['job_post_n']=mb_substr($postname[$k],0,$paramer[post_len],"utf-8");
				}
                if($paramer['city_len']){
					$scityname[$k]=@implode("/",$cityname);
					$userrec[$k]['city_name_n']=mb_substr($scityname[$k],0,$paramer[city_len],"utf-8");
				}
			}
			foreach($userrec as $k=>$v){
               if($paramer['keyword']){
					$userrec[$k]['username_n']=str_replace($paramer['keyword'],"<font color=#FF6600 >".$paramer['keyword']."</font>",$v['username_n']);
					$userrec[$k]['job_post']=str_replace($paramer['keyword'],"<font color=#FF6600 >".$paramer['keyword']."</font>",$userrec[$k]['job_post']);
					$userrec[$k]['job_post_n']=str_replace($paramer['keyword'],"<font color=#FF6600 >".$paramer['keyword']."</font>",$userrec[$k]['job_post_n']);
					$userrec[$k]['city_name_n']=str_replace($paramer['keyword'],"<font color=#FF6600 >".$paramer['keyword']."</font>",$userrec[$k]['city_name_n']);
				}
            }

			
			if($paramer['keyword']!=""&&!empty($userrec)){
				addkeywords('5',$paramer['keyword']);
			}
		}$userrec = $userrec; if (!is_array($userrec) && !is_object($userrec)) { settype($userrec, 'array');}
foreach ($userrec as $_smarty_tpl->tpl_vars['userrec']->key => $_smarty_tpl->tpl_vars['userrec']->value) {
$_smarty_tpl->tpl_vars['userrec']->_loop = true;
?>
                        <li>
                            <div class="userresume_people_box">
                                <div class="userresume_people_box_rt fl">

                                    <?php if ($_smarty_tpl->tpl_vars['config']->value['com_search']==1&&!$_smarty_tpl->tpl_vars['uid']->value) {?>
                                        <a href="javascript:;" onClick="showlogin('2');">
                                    <?php } else { ?>
                                        <a href="<?php echo $_smarty_tpl->tpl_vars['userrec']->value['user_url'];?>
" target="_blank">
                                    <?php }?>
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['userrec']->value['photo'];?>
" width="50" height="50" onerror="showImgDelay(this,'<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_member_icon'];?>
',2);" />
                                    </a><i class="userresume_people_box_rt_tj"></i></div>
                                <div class="userresume_people_box_ft fl">
                                    <div class="userresume_people_box_ft_nm">

                                        <?php if ($_smarty_tpl->tpl_vars['config']->value['com_search']==1&&!$_smarty_tpl->tpl_vars['uid']->value) {?>
                                            <a href="javascript:;" onClick="showlogin('2');">
                                        <?php } else { ?>
                                            <a href="<?php echo $_smarty_tpl->tpl_vars['userrec']->value['user_url'];?>
" target="_blank">
                                        <?php }?>
                                            <?php if (in_array($_smarty_tpl->tpl_vars['userrec']->value['id'],$_smarty_tpl->tpl_vars['eid']->value)) {?>
                                                <?php echo $_smarty_tpl->tpl_vars['userrec']->value['uname'];?>

                                            <?php } else { ?>
                                                <?php echo $_smarty_tpl->tpl_vars['userrec']->value['username_n'];?>

                                            <?php }?>
                                        </a>
                                    </div>
                                    <div class="userresume_people_box_ft_v"><?php echo $_smarty_tpl->tpl_vars['userrec']->value['exp_n'];?>
经验<i class="userresume_line">|</i><?php echo $_smarty_tpl->tpl_vars['userrec']->value['edu_n'];?>
学历</div>
                                    <div class="userresume_people_box_ft_y"><?php echo $_smarty_tpl->tpl_vars['userrec']->value['job_post_n'];?>
</div>
                                </div>

                            </div>
                        </li>
                        <?php } ?>
                    </ul>

                </div>
            </div>

        </div>
    </div>     </div>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
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
    DD_belatedPNG.fix('.png,.user_photo_bg');
    <?php echo '</script'; ?>
>
    <![endif]-->
    <?php echo '<script'; ?>
>
        $(function() {

            $("#form").submit(function(e) {
                var min = $("#min").val();
                var max = $("#max").val();
                if(min && max && parseInt(max) < parseInt(min)) {
                    $("#min").val(max);
                    $("#max").val(min);
                }
                var mina = $("#mina").val();
                var maxa = $("#maxa").val();
                if(mina && maxa && parseInt(maxa) < parseInt(mina)) {
                    $("#mina").val(maxa);
                    $("#maxa").val(mina);
                }
            });
            $('.yunjoblist_new_icon').click(function(){
                var pid=$(this).attr('pid');
                if($(this).attr('title')=='展开'){
                    $(this).addClass('yunjoblist_new_icon_cur');
                    $(this).attr('title','收起');
                    $('#resumeshow'+pid).show();
                }else{
                    $(this).removeClass('yunjoblist_new_icon_cur');
                    $(this).attr('title','展开');
                    $('#resumeshow'+pid).hide();
                }
            });
        });
    <?php echo '</script'; ?>
>
    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/public_search/login.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['temstyle']->value)."/member/public/changeutype.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
