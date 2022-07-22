<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-08 16:11:25
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\default\reward\index.htm" */ ?>
<?php /*%%SmartyHeaderCode:1111762c7e6ad928cf7-82657585%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e01cc8e8f4c5f986d20aafbeb774977b0f69171f' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\default\\reward\\index.htm',
      1 => 1634883842,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1111762c7e6ad928cf7-82657585',
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
    'ishtml' => 0,
    'maplist' => 0,
    'navlist_app' => 0,
    'rlist' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c7e6ada6de33_25040242',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c7e6ada6de33_25040242')) {function content_62c7e6ada6de33_25040242($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.url.php';
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
<link href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/style/css.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
<link href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/style/reward.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
<?php if ($_smarty_tpl->tpl_vars['ishtml']->value) {?>
<?php echo '<script'; ?>
 src="<?php echo smarty_function_url(array('m'=>'ajax','c'=>'wjump'),$_smarty_tpl);?>
" language="javascript"><?php echo '</script'; ?>
>
<?php }?>
</head>
<body style="background:#f8f8f8">
<?php echo '<script'; ?>
>
var weburl="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
",integral_pricename='<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
',pricename='<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
',code_web='<?php echo $_smarty_tpl->tpl_vars['config']->value['code_web'];?>
',code_kind='<?php echo $_smarty_tpl->tpl_vars['config']->value['code_kind'];?>
';<?php echo '</script'; ?>
>

<div class="yun_new_top">
<div class="yun_new_cont">
<div class="yun_new_left"> 
<?php if ($_smarty_tpl->tpl_vars['config']->value['sy_web_site']=='1') {?>
         <span class="yun_new_left_city">
               <?php echo '<script'; ?>
 language='JavaScript' src='<?php echo smarty_function_url(array('m'=>'ajax','c'=>'Site'),$_smarty_tpl);?>
'><?php echo '</script'; ?>
>
          </span>
          <?php }?>
         热线电话：<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_freewebtel'];?>
</div>
<div class="yun_new_right"  id = "login_head_div">

        
          <div class="yun_topNav fr"> 
		  <a class="yun_navMore" href="javascript:;">网站导航</a>
            <div class="yun_webMoredown none">
              <div class="yun_top_nav_box"> 
			  <ul class="yun_top_nav_box_l">
             <?php  $_smarty_tpl->tpl_vars['maplist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['maplist']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
global $db,$db_config,$config;$paramer=array("key"=>"'key'","item"=>"'maplist'","nocache"=>"")
;
		include(PLUS_PATH."/navmap.cache.php");$Navlist=array();
		if(is_array($navmap)){
			$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
			$paramer = $ParamerArr[arr];
			$Purl =  $ParamerArr[purl];
		}
		//默认调用头部导航
		$Navlist =$navmap[0];
		if(is_array($navmap)){
			foreach($navmap as $k=>$v){
				foreach($Navlist as $key=>$val){
					if($k==$val[id]){
						foreach($v as $kk=>$value){
							if($value[type]=='1'){
								if($config[sy_seo_rewrite]=="1" && $value[furl]!=''){
									$v[$kk][url] = $config[sy_weburl]."/".$value[furl];
								}else{
									$v[$kk][url] = $config[sy_weburl]."/".$value[url];
								}
							}
						}
						$Navlist[$key]['list'][]=$v;
					}
				}
			}
			foreach($Navlist as $key=>$value){
				if($value[type]=='1'){
					if($config[sy_seo_rewrite]=="1" && $value[furl]!=''){
						$Navlist[$key][url] = $config[sy_weburl]."/".$value[furl];
					}else{
						$Navlist[$key][url] = $config[sy_weburl]."/".$value[url];
					}
				}
			}
		}$Navlist = $Navlist; if (!is_array($Navlist) && !is_object($Navlist)) { settype($Navlist, 'array');}
foreach ($Navlist as $_smarty_tpl->tpl_vars['maplist']->key => $_smarty_tpl->tpl_vars['maplist']->value) {
$_smarty_tpl->tpl_vars['maplist']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['maplist']->key;
?>
                  <li><a href="<?php echo $_smarty_tpl->tpl_vars['maplist']->value['url'];?>
" <?php if ($_smarty_tpl->tpl_vars['maplist']->value['eject']) {?> target="_blank"<?php }?>><?php echo $_smarty_tpl->tpl_vars['maplist']->value['name'];?>
</a></li>
                <?php } ?>
                 </ul>
                <ul class="yun_top_nav_box_wx">
               <?php  $_smarty_tpl->tpl_vars['navlist_app'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['navlist_app']->_loop = false;
global $db,$db_config,$config;include(PLUS_PATH."/menu.cache.php");$Navlist=array();
		if(is_array($menu_name)){
            $paramer=array("item"=>"'navlist_app'","hovclass"=>"'nav_list_hover'","nid"=>"11","nocache"=>"")
;
			$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
			$paramer = $ParamerArr[arr];
			$Purl =  $ParamerArr[purl];

			foreach($menu_name[12] as $key=>$val){
				
				if($val['type']=='2'){
					if($config['sy_seo_rewrite']=="1" && $val[furl]!=''){
						$menu_name[12][$key]['url'] = $val[furl];
					}else{
						$menu_name[12][$key]['url'] = $val['url'];
					}
					$menu_name[12][$key][navclass] = navcalss($val,$paramer[hovclass]);
				}
			}
			foreach($menu_name[1] as $key=>$value){
				if($value['url']=="/"){
					$value['url']="";
				}
				if($value['type']=='1'){
					if($config['sy_seo_rewrite']=="1" && $value['furl']!=''){
						$menu_name[1][$key]['url'] = $config[sy_weburl]."/".$value['furl'];
					}else{
						$menu_name[1][$key]['url'] = $config[sy_weburl]."/".$value['url'];
					}
					$menu_name[1][$key][navclass] = navcalss($value,$paramer[hovclass]);
				}
			}
			foreach($menu_name[2] as $key=>$value){
                if($value['url']=="/"){
					$value['url']="";
				}
				if($value['type']=='1'){
					if($config['sy_seo_rewrite']=="1" && $value['furl']!=''){
						$menu_name[2][$key]['url'] = $config[sy_weburl]."/".$value['furl'];
					}else{
						$menu_name[2][$key]['url'] = $config[sy_weburl]."/".$value['url'];
					}
					$menu_name[2][$key][navclass] = navcalss($value,$paramer[hovclass]);
				}
			}
            $isCurrentFind=false;
			foreach($menu_name[4] as $key=>$value){
                if($value['url']=="/"){
					$value['url']="";
				}
				if($value['type']=='1' && $value['furl']!=''){
					if($config['sy_seo_rewrite']=="1"){
						$menu_name[4][$key]['url'] = $config[sy_weburl]."/".$value['furl'];
					}else{
						$menu_name[4][$key]['url'] = $config[sy_weburl]."/".$value['url'];
					}
				}
                if($isCurrentFind==false){
				    $menu_name[4][$key][navclass] = navcalss($value,$paramer[hovclass]);
                }
                if($menu_name[4][$key][navclass]){
                    $isCurrentFind=true;
                }
			}
			foreach($menu_name[5] as $key=>$value){
                if($value['url']=="/"){
					$value['url']="";
				}
				if($value['type']=='1'){
					if($config['sy_seo_rewrite']=="1" && $value['furl']!=''){
						$menu_name[5][$key]['url'] = $config[sy_weburl]."/".$value['furl'];
					}else{
						$menu_name[5][$key]['url'] = $config[sy_weburl]."/".$value['url'];
					}
					$menu_name[5][$key][navclass] = navcalss($value,$paramer[hovclass]);
				}
			}
		}
		//默认调用头部导航
		if($paramer[nid]){
			$Navlist =$menu_name[$paramer[nid]];
		}else{
			$Navlist =$menu_name[1];
		}$Navlist = $Navlist; if (!is_array($Navlist) && !is_object($Navlist)) { settype($Navlist, 'array');}
foreach ($Navlist as $_smarty_tpl->tpl_vars['navlist_app']->key => $_smarty_tpl->tpl_vars['navlist_app']->value) {
$_smarty_tpl->tpl_vars['navlist_app']->_loop = true;
?>          
            <li> <a class="move_0<?php echo $_smarty_tpl->tpl_vars['navlist_app']->value['sort'];?>
"<?php if ($_smarty_tpl->tpl_vars['navlist_app']->value['eject']) {?> target="_blank"<?php }?> href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['navlist_app']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['navlist_app']->value['name'];?>
</a> </li>
          <?php } ?>
                </ul>
                
                </div>
            </div>
          </div> 
          
<span class="yun_new_right_we">欢迎来到<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
！</span>
<a href="<?php echo smarty_function_url(array('m'=>'index','c'=>'wap'),$_smarty_tpl);?>
" class="yun_new_right_wap">手机版</a>
<a href="<?php echo smarty_function_url(array('m'=>'index','c'=>'weixin'),$_smarty_tpl);?>
" class="yun_new_right_wx">微信版</a>
<span class="yun_new_right_dy"><a href="<?php echo smarty_function_url(array('m'=>'subscribe'),$_smarty_tpl);?>
" target="_blank" class="top_dy">订阅</a></span>

 <?php echo '<script'; ?>
 language='JavaScript' src='<?php echo smarty_function_url(array('m'=>'ajax','c'=>'RedLoginHead'),$_smarty_tpl);?>
'><?php echo '</script'; ?>
> 


</div>
</div>
</div>
<!--top end--><div class="reward_header">
<div class="w1200">
<div class="reward_header_logo"><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
最新招聘求职信息"><img  src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_logo'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
"/></a>
</div>
<div class="reward_header_nav">
<ul class="reward_header_nav_list">
<li class="reward_header_nav_list_cur"><a href="<?php echo smarty_function_url(array('m'=>'reward'),$_smarty_tpl);?>
">首页</a></li>
<li><a href="<?php echo smarty_function_url(array('m'=>'reward','c'=>'job'),$_smarty_tpl);?>
">悬赏职位</a></li>

</ul>
</div>
<div class="reward_header_tel"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_freewebtel'];?>
</div>
</div>
</div>
<div class="reward_header_banner">

  <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_reward_sharelogo']) {?>
  <div class="reward_header_banner_cont">
  <div class="reward_header_fx">
  <div class="reward_header_img"><img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_reward_sharelogo'];?>
" width="110" height="110"></div>
  <div class="reward_header_p">扫一扫分享到朋友圈领取红包</div></div>
  </div>
<?php }?>
</div>

<div class="job_reward_content">
<div class="w1200">
<div class="job_reward_tit"><i class="job_reward_tit_icon"></i>悬赏职位<span class="job_reward_tit_p">投递简历领赏金！<a href="<?php echo smarty_function_url(array('m'=>'reward','c'=>'job'),$_smarty_tpl);?>
" class="job_reward_tit_p_a">查看更多职位</a></span></div>
<div class="index_job_red">
<ul class="index_job_red_list">
<?php  $_smarty_tpl->tpl_vars['rlist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['rlist']->_loop = false;
global $db,$db_config,$config;
		$time = time();
		
		
		//可以做缓存
        $paramer=array("limit"=>"12","reward"=>"1","item"=>"'rlist'","nocache"=>"")
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

		if($paramer[reward]=='1'){
			$where="`rewardpack`='1'";

		}elseif($paramer[share]=='1'){
		
			$where="`sharepack`='1'";
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
			 
		
		$where .= " AND `r_status`='1' AND `state`=1 and `status`='0' ";
		
		
		//按照职位名称匹配
		if($paramer[keyword]){
			$where1[]="`name` LIKE '%".$paramer[keyword]."%'";
			$where1[]="`com_name` LIKE '%".$paramer[keyword]."%'";

			$where.=" AND (".@implode(" or ",$where1).")";
		}

		//筛除重复
		if($paramer[noids]==1 && !empty($noids)){
			$where.=" AND `id` NOT IN (".@implode(',',$noids).")";
		}
	

		//查询条数
		if($paramer[limit]){
			$limit = " limit ".$paramer[limit];
		}

		if($paramer[ispage]){
			$limit = PageNav($paramer,$_GET,"company_job",$where,$Purl,"",$paramer[islt]?$paramer[islt]:"6",$_smarty_tpl);
          
		} 
		//排序字段默认为更新时间
		if($paramer[order] && $paramer[order]!="lastdate"){
			$order = " ORDER BY ".str_replace("'","",$paramer[order])."  ";
		}else{
			$order = " ORDER BY `lastupdate` ";
		}
		//排序规则 默认为倒序
		if($paramer[sort]){
			$sort = $paramer[sort];
		}else{
			$sort = " DESC";
		} 
		$where.=$order.$sort;  
		 
		$rlist = $db->select_all("company_job",$where.$limit);
		if(is_array($rlist)){
			//处理类别字段
			$cache_array = $db->cacheget();
			$comuid=$jobid=array();
			foreach($rlist as $key=>$value){
				$comuid[] = $value['uid'];
				$jobid[] = $value['id'];
			}
			$comuids = @implode(',',$comuid);
			$jobids = @implode(',',$jobid);
			$r_uid = array();
			
			if($comuids){
				$r_uids=$db->select_all("company","`uid` IN (".$comuids.")","`name`,`uid`,`shortname`,`yyzz_status`,`logo`,`pr`,`hy`,`mun`");
				if(is_array($r_uids)){
					foreach($r_uids as $key=>$value){
						if($value['shortname']){
    						$value['name'] =$value['shortname'];
    					}
						$value['logo']= checkpic($value['logo'],$config['sy_unit_icon']);
						$value['pr_n'] = $cache_array['comclass_name'][$value[pr]];
						$value['hy_n'] = $cache_array['industry_name'][$value[hy]];
						$value['mun_n'] = $cache_array['comclass_name'][$value[mun]];
						$r_uid[$value['uid']] = $value;
					}
				}
			}
			
			if($jobids){
			
			    //$db -> update_all("company_job", "`jobexpoure` = `jobexpoure` + 1", "`id` IN ($jobids)");
			
				if($paramer[reward]=='1'){
					
					$rewardList=$db->select_all("company_job_reward","`jobid` IN (".$jobids.")");
					
				}elseif($paramer[share]=='1'){ 

					$rewardList=$db->select_all("company_job_share","`jobid` IN (".$jobids.")","`jobid`,`packmoney`,`packprice`,`packnum`");
				
				}
				if(is_array($rewardList)){
						foreach($rewardList as $key=>$value){
							
							$rewadArr[$value['jobid']] = $value;
						}
					}
			}
			    
			
			$noids=array();
			foreach($rlist as $key=>$value){
				if($paramer[bid]){
					$noids[] = $value[id];
				}
				$rlist[$key] = $db->array_action($value,$cache_array);
				$rlist[$key][stime] = date("Y-m-d",$value[sdate]);
				$rlist[$key][etime] = date("Y-m-d",$value[edate]);
				if($arr_data['sex'][$value['sex']]){
    				$rlist[$key][sex_n]=$arr_data['sex'][$value['sex']];
    			}
				$rlist[$key][lastupdate] = date("Y-m-d",$value[lastupdate]);

				if($value[minsalary] && $value[maxsalary]){
					if($config['resume_salarytype']==1){
						$rlist[$key][job_salary] =$value[minsalary]."~".$value[maxsalary]."元";
					}else{
						if($value[maxsalary]<1000){
							if($config['resume_salarytype']==2){
								$rlist[$key][job_salary] = "1千以下";
							}elseif($config['resume_salarytype']==3){
								$rlist[$key][job_salary] = "1K以下";
							}elseif($config['resume_salarytype']==4){
								$rlist[$key][job_salary] = "1k以下";
							}

						}else{
							$rlist[$key][job_salary] =changeSalary($value[minsalary])."~".changeSalary($value[maxsalary]);
						}
					}
				}elseif($value[minsalary]){
					if($config['resume_salarytype']==1){
						$rlist[$key][job_salary] =$value[minsalary];
					}else{
						$rlist[$key][job_salary] =changeSalary($value[minsalary]);
					}
				}else{
                    $rlist[$key][job_salary] ="面议";
                }
				//if($r_uid[$value['uid']][shortname]){
    				$rlist[$key][com_name] =$r_uid[$value['uid']][name];
    			//}
				$rlist[$key][yyzz_status] =$r_uid[$value['com_id']][yyzz_status];
				$rlist[$key][logo] =$r_uid[$value['uid']][logo];
				$rlist[$key][pr_n] =$r_uid[$value['uid']][pr_n];
				$rlist[$key][hy_n] =$r_uid[$value['uid']][hy_n];
				$rlist[$key][mun_n] =$r_uid[$value['uid']][mun_n];
				
				if($paramer[reward]=='1'){
					$rlist[$key][sqmoney] =floatval( $rewadArr[$value['id']][sqmoney]);
					$rlist[$key][invitemoney] =floatval( $rewadArr[$value['id']][invitemoney]);
					$rlist[$key][offermoney] =floatval( $rewadArr[$value['id']][offermoney]);
					$rlist[$key][money] =floatval( $rewadArr[$value['id']][money]);
					$rlist[$key][r_exp] = $rewadArr[$value['id']][exp];
					$rlist[$key][r_edu] = $rewadArr[$value['id']][edu];
					$rlist[$key][r_project] = $rewadArr[$value['id']][project];
					$rlist[$key][r_skill] = $rewadArr[$value['id']][skill];
				}

				if($paramer[share]=='1'){
					$rlist[$key][packmoney] = $rewadArr[$value['id']][packmoney];
					$rlist[$key][packnum] = $rewadArr[$value['id']][packnum];
					$rlist[$key][packprice] = $rewadArr[$value['id']][packprice];
					
				}
				

				$time=$value['lastupdate'];
				//今天开始时间戳
				$beginToday=time(0,0,0,date('m'),date('d'),date('Y'));
				//昨天开始时间戳
				$beginYesterday=time(0,0,0,date('m'),date('d')-1,date('Y'));
				if($time>$beginYesterday && $time<$beginToday){
					$rlist[$key]['time'] ="昨天";
				}elseif($time>$beginToday){	
					$rlist[$key]['time'] = date("H:i",$value['lastupdate']);
					$rlist[$key]['redtime'] =1;
				}else{
					$rlist[$key]['time'] = date("Y-m-d",$value['lastupdate']);
				}
				//获得福利待遇名称
				if(is_array($rlist[$key]['welfare'])&&$rlist[$key]['welfare']){
					foreach($rlist[$key]['welfare'] as $val){
						//$rlist[$key]['welfarename'][]=$cache_array['comclass_name'][$val];
						$rlist[$key]['welfarename'][]=$val;
					}

				}
				//截取公司名称
				if($paramer[comlen]){
					if($r_uid[$value['com_id']][shortname]){
    					$rlist[$key][com_n] = mb_substr($r_uid[$value['com_id']][shortname],0,$paramer[comlen],"utf-8");
    				}else{
    					$rlist[$key][com_n] = mb_substr($value['com_name'],0,$paramer[comlen],"utf-8");
    				}
					
				}
				//截取职位名称
				if($paramer[namelen]){
					if($value['rec_time']>time()){
						$rlist[$key][name_n] = "<font color='red'>".mb_substr($value['name'],0,$paramer[namelen],"utf-8")."</font>";
					}else{
						$rlist[$key][name_n] = mb_substr($value['name'],0,$paramer[namelen],"utf-8");
					}
				}else{
					if($value['rec_time']>time()){
						$rlist[$key]['name_n'] = "<font color='red'>".$value['name']."</font>";
					}else{
						$rlist[$key]['name_n'] = $value['name'];
					}
				}
				//构建职位伪静态URL
				$rlist[$key][job_url] = Url("job",array("c"=>"comapply","id"=>$value[id]),"1");
				$rlist[$key][job_wapurl] = Url("wap",array("c"=>"job","a"=>"comapply","id"=>$value[id]),"1");
				//构建企业伪静态URL
				$rlist[$key][com_url] = Url("company",array("c"=>"show","id"=>$value[uid]));
				foreach($comrat as $k=>$v){
					if($value[rating]==$v[id]){
						$rlist[$key][color] = str_replace("#","",$v[com_color]);
						$rlist[$key][ratlogo] = $v[com_pic];
						$rlist[$key][ratname] = $v[name];
					}
				}
				if($paramer[keyword]){
					$rlist[$key][name]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$value[name]);
					$rlist[$key][com_name]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$value[com_name]);
					$rlist[$key][name_n]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$rlist[$key][name_n]);
					$rlist[$key][com_n]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$rlist[$key][com_n]);
				}
			}

			if(is_array($rlist)){
				if($paramer[keyword]!=""&&!empty($rlist)){
					addkeywords('3',$paramer[keyword]);
				}
			}
		}$rlist = $rlist; if (!is_array($rlist) && !is_object($rlist)) { settype($rlist, 'array');}
foreach ($rlist as $_smarty_tpl->tpl_vars['rlist']->key => $_smarty_tpl->tpl_vars['rlist']->value) {
$_smarty_tpl->tpl_vars['rlist']->_loop = true;
?>

  <li>
        <div class="index_job_red_momey">
          <div class="index_job_red_momey_n">￥<?php echo $_smarty_tpl->tpl_vars['rlist']->value['money'];?>
</div>
        </div>
        <div >
          <div class="reward_hb_list"> <i class="reward_hb_list_line"></i> <span class="reward_hb_fonttd">￥<?php echo $_smarty_tpl->tpl_vars['rlist']->value['sqmoney'];?>
</span>
            <div class="reward_hb_list_P">投递简历</div>
          </div>
          <div class="reward_hb_list"> <i class="reward_hb_list_line"></i> <span class="reward_hb_fontms">￥<?php echo $_smarty_tpl->tpl_vars['rlist']->value['invitemoney'];?>
</span>
            <div class="reward_hb_list_P">面试职位</div>
          </div>
          <div class="reward_hb_list"><span class="reward_hb_fontrz">￥<?php echo $_smarty_tpl->tpl_vars['rlist']->value['offermoney'];?>
</span>
            <div class="reward_hb_list_P">入职成功</div>
          </div>
          <a href="<?php echo $_smarty_tpl->tpl_vars['rlist']->value['job_url'];?>
" class="reward_hb_ls">领赏</a> </div>
        <div class="reward_hb_listjobname">
          <div class="reward_hb_listjobname_l"><a href="<?php echo $_smarty_tpl->tpl_vars['rlist']->value['job_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['rlist']->value['name'];?>
</a></div>
          <div class="reward_hb_listjobinfo"> <?php if ($_smarty_tpl->tpl_vars['rlist']->value['job_salary']!='面议') {?>￥<?php }
echo $_smarty_tpl->tpl_vars['rlist']->value['job_salary'];?>
 <span class="index_job_line">|</span><?php echo mb_substr($_smarty_tpl->tpl_vars['rlist']->value['job_city_two'],0,4,"utf-8");?>
 <?php echo mb_substr($_smarty_tpl->tpl_vars['rlist']->value['job_city_three'],0,4,"utf-8");?>
<span class="index_job_line">|</span><?php echo $_smarty_tpl->tpl_vars['rlist']->value['job_exp'];?>
经验<span class="index_job_line">|</span><?php echo $_smarty_tpl->tpl_vars['rlist']->value['job_edu'];?>
学历</div>
        </div>
      </li>
      

<?php } ?>

</ul>
</div>



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
" rel="stylesheet" type="text/css" /><?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/layui.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
><?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/phpyun_layer.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/public_search/login.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</body><?php }} ?>
