<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-08 16:12:11
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\default\resume\topfour_list.htm" */ ?>
<?php /*%%SmartyHeaderCode:212262c7e6db57e847-39848620%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1b2cdefe6e57f28b30da47207c782f555626116a' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\default\\resume\\topfour_list.htm',
      1 => 1634883836,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '212262c7e6db57e847-39848620',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'key' => 0,
    'user3' => 0,
    'config' => 0,
    'uid' => 0,
    'style' => 0,
    'talentpool' => 0,
    'useridmsg' => 0,
    'eid' => 0,
    'v' => 0,
    'user' => 0,
    'lookResumeIds' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c7e6db62a7c7_22657940',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c7e6db62a7c7_22657940')) {function content_62c7e6db62a7c7_22657940($_smarty_tpl) {?><?php  $_smarty_tpl->tpl_vars['user3'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['user3']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
$user3=array();global $db,$db_config,$config;
		if(is_array($_GET)){
			foreach($_GET as $key=>$value){
				if($value=='0'){
					unset($_GET[$key]);
				}
			}
		}
		$paramer=array("limit"=>"4","post_len"=>"14","order"=>"'topdate'","item"=>"'user3'","workexp"=>"1","key"=>"'key'","name"=>"'userlist3'","nocache"=>"")
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
			$user3 = array();
		}else{
			
			$select="a.`id`,a.`uid`,a.`name`,a.`hy`,a.`job_classid`,a.`city_classid`,a.`jobstatus`,a.`type`,a.`report`,a.`lastupdate`,a.`rec`,a.`top`,a.`topdate`,a.`rec_resume`,a.`ctime`,a.`uname`,a.`idcard_status`,a.`minsalary`,a.`maxsalary`";
			if($pagewhere!=""){

				$sql = "select ".$select." from `".$db_config[def]."resume_expect` a ".$pagewhere." where ".$joinwhere." and ".$where.$order.$sort.$limit;

				$user3=$db->DB_query_all($sql,"all");

			}else{
				$sql = "select ".$select." from `".$db_config[def]."resume_expect` a where ".$where.$order.$sort.$limit;
				
				$user3=$db->DB_query_all($sql,"all");
			}
		}
        
		if(!empty($user3) && is_array($user3)){
			
			//如果存在top，则说明请求来自排行榜页面
			if($paramer['top']){
				$uids=$m_name=array();
				foreach($user3 as $k=>$v){
					$uids[]=$v[uid];
				}

				$member=$db->select_all($db_config[def]."member","`uid` in(".@implode(',',$uids).")","uid,username");
				foreach($member as $val){
					$m_name[$val[uid]]=$val['username'];
				}
			}
			$uid = $eid = array();
			foreach($user3 as $key=>$value){
				
				$uid[] = $value['uid'];
				$eid[] = $value['id'];
			}
			$eids = @implode(',',$eid);
			$uids = @implode(',',$uid);
            $resume=$db->select_all("resume","`uid` in(".$uids.")","uid,name,nametype,tag,sex,moblie_status,edu,exp,defphoto,photo,phototype,photo_status,birthday");
			foreach($resume as $v){
				$ruids[] = $v['uid'];
			}
			foreach($user3 as $k=>$v){
				if(!in_array($v['uid'],$ruids)){
					unset($user3[$k]);
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
			foreach($user3 as $k=>$v){
				if($paramer[topdate]){
					$noids[] = $v[id];
				}
				//筛除重复
				if($paramer[noid]=='1' && !empty($noids) && in_array($v['id'],$noids)){
					unset($user3[$k]);
					continue;
				}
			    foreach($resume as $val){
			        if($v['uid']==$val['uid']){
			    		$user3[$k]['edu_n']=$userclass_name[$val['edu']];
				        $user3[$k]['exp_n']=$userclass_name[$val['exp']];
			            if($val['birthday']){
							$year = date("Y",strtotime($val['birthday']));
							$user3[$k]['age'] =date("Y")-$year;
						}
						if($val['sex']==152){
							$val['sex']='1';
						}elseif ($val['sex']==153){
							$val['sex']='2';
						}
						$user3[$k]['sex'] =$arr_data[sex][$val['sex']];
		                $user3[$k]['phototype']=$val[phototype];
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
						$user3[$k]['photo']=checkpic($photo,$icon);
						if($val['tag']){
                            $user3[$k]['tag']=explode(',',$val['tag']);
	                    }
                        $user3[$k]['nametype']=$val[nametype];
                        $user3[$k]['moblie_status']=$val[moblie_status];
                        //名称显示处理
						if($config['user_name']==1 || !$config['user_name']){
    						if($val['nametype']==3){
    						    if($val['sex']==1){
    						        $user3[$k]['username_n'] = mb_substr($val['name'],0,1,'utf-8')."先生";
    						    }else{
    						        $user3[$k]['username_n'] = mb_substr($val['name'],0,1,'utf-8')."女士";
    						    }
    						}elseif($val['nametype']==2){
    						    $user3[$k]['username_n'] = "NO.".$v['id'];
    						}else{
    							$user3[$k]['username_n'] = $val['name'];
    						}
						}elseif($config['user_name']==3){
							if($val['sex']==1){
								$user3[$k]['username_n'] = mb_substr($val['name'],0,1,'utf-8')."先生";
							}else{
								$user3[$k]['username_n'] = mb_substr($val['name'],0,1,'utf-8')."女士";
							}
						}elseif($config['user_name']==2){
							$user3[$k]['username_n'] = "NO.".$v['id'];
						}elseif($config['user_name']==4){
							$user3[$k]['username_n'] = $val['name'];
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
					$user3[$k]['time'] = "昨天";
				}elseif($time>$beginToday){
					$user3[$k]['time'] = lastupdateStyle($v['lastupdate']);
					$user3[$k]['redtime'] =1;
				}else{
					$user3[$k]['time'] = date("Y-m-d",$v['lastupdate']);
				} 
                
                // 前天
				$beforeYesterday=mktime(0,0,0,date('m'),date('d')-2,date('Y'));

				if($v['ctime']>$beforeYesterday){
					$user3[$k]['newtime'] =1;
				}
				$user3[$k]['user_jobstatus_n']=$userclass_name[$v['jobstatus']];
// 				$user3[$k]['job_city_one']=$city_name[$v['provinceid']];
// 				$user3[$k]['job_city_two']=$city_name[$v['cityid']];
// 				$user3[$k]['job_city_three']=$city_name[$v['three_cityid']];
				if($v['minsalary']&&$v['maxsalary']){
					if($config['resume_salarytype']==1){
						$user3[$k]["salary_n"] = $v['minsalary']."-".$v['maxsalary'];    
					}else{
						if($v[maxsalary]<1000){
							if($config['resume_salarytype']==2){
								$user3[$k]["salary_n"] = "1千以下";    
							}elseif($config['resume_salarytype']==3){
								$user3[$k]["salary_n"] = "1K以下";    
							}elseif($config['resume_salarytype']==4){
								$user3[$k]["salary_n"] = "1k以下";    
							}
						}else{
							$user3[$k]["salary_n"] = changeSalary($v['minsalary'])."-".changeSalary($v['maxsalary']);    
						}
					}
                }else if($v['minsalary']){
                	if($config['resume_salarytype']==1){
                		$user3[$k]["salary_n"] = $v['minsalary'];  
            		}else{
            			$user3[$k]["salary_n"] = changeSalary($v['minsalary']);  
            		}
                }else{
    				$user3[$k]["salary_n"] = "面议";
    			}
				$user3[$k]['report_n']=$userclass_name[$v['report']];
				$user3[$k]['type_n']=$userclass_name[$v['type']];
				$user3[$k]['lastupdate']=date("Y-m-d",$v['lastupdate']);
					
				$user3[$k]['user_url']=Url("resume",array("c"=>"show","id"=>$v['id']),"1");
				$user3[$k]["hy_info"]=$industry_name[$v['hy']];
				if($paramer['top']){
					$user3[$k]['m_name']=$m_name[$v['uid']];
					$user3[$k]['user_url']=Url("ask",array("c"=>"friend","a"=>"myquestion","uid"=>$v['uid']));
				}
				$user3[$k]['work_content']=$workexpList[$v['id']]['work_content'];
				$user3[$k]['edu_content']=$workexpList[$v['id']]['edu_content'];

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
				//$user3[$k]['job_post']=@implode(",",$jobname);
				$user3[$k]['expectjob']=$jobname;
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
                //$user3[$k]['citylist']=@implode("/",$cityname);
				$user3[$k]['expectcity']=$cityname;
				//截取标题
				if($paramer['post_len']){
					$postname[$k]=@implode(",",$jobname);
					$user3[$k]['job_post_n']=mb_substr($postname[$k],0,$paramer[post_len],"utf-8");
				}
                if($paramer['city_len']){
					$scityname[$k]=@implode("/",$cityname);
					$user3[$k]['city_name_n']=mb_substr($scityname[$k],0,$paramer[city_len],"utf-8");
				}
			}
			foreach($user3 as $k=>$v){
               if($paramer['keyword']){
					$user3[$k]['username_n']=str_replace($paramer['keyword'],"<font color=#FF6600 >".$paramer['keyword']."</font>",$v['username_n']);
					$user3[$k]['job_post']=str_replace($paramer['keyword'],"<font color=#FF6600 >".$paramer['keyword']."</font>",$user3[$k]['job_post']);
					$user3[$k]['job_post_n']=str_replace($paramer['keyword'],"<font color=#FF6600 >".$paramer['keyword']."</font>",$user3[$k]['job_post_n']);
					$user3[$k]['city_name_n']=str_replace($paramer['keyword'],"<font color=#FF6600 >".$paramer['keyword']."</font>",$user3[$k]['city_name_n']);
				}
            }

			
			if($paramer['keyword']!=""&&!empty($user3)){
				addkeywords('5',$paramer['keyword']);
			}
		}$user3 = $user3; if (!is_array($user3) && !is_object($user3)) { settype($user3, 'array');}
foreach ($user3 as $_smarty_tpl->tpl_vars['user3']->key => $_smarty_tpl->tpl_vars['user3']->value) {
$_smarty_tpl->tpl_vars['user3']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['user3']->key;
?>
<div class="search_job_list <?php if ($_smarty_tpl->tpl_vars['key']->value%2!='0') {
}?>">

	
	<div class="resume_newlist"><?php if ($_smarty_tpl->tpl_vars['user3']->value['newtime']==1) {?><i class="yunjoblist_newicon" title="新简历"> </i><?php }?>
		<div class="resume_newlist_jobname">
			<?php if ($_smarty_tpl->tpl_vars['config']->value['com_search']==1&&!$_smarty_tpl->tpl_vars['uid']->value) {?>
				<a href="javascript:void(0);" onclick="showlogin('2');" class="resume_newlist_job"><?php echo $_smarty_tpl->tpl_vars['user3']->value['name'];?>
</a>
			<?php } else { ?>
				<a href="<?php echo $_smarty_tpl->tpl_vars['user3']->value['user_url'];?>
" target="_blank" class="resume_newlist_job"><?php echo $_smarty_tpl->tpl_vars['user3']->value['name'];?>
</a>
			<?php }?>

			<?php if ($_smarty_tpl->tpl_vars['user3']->value['idcard_status']=='1') {?><img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/sf.png" title="身份已认证" class="user_rz_img png fl" /><?php }?>
			<?php if ($_smarty_tpl->tpl_vars['user3']->value['ispic']) {?><img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/profile.png" title="有形象照" class="user_rz_img png fl" /><?php }?>

			<?php if (in_array($_smarty_tpl->tpl_vars['user3']->value['id'],$_smarty_tpl->tpl_vars['talentpool']->value)) {?><span class="co_fav">已收藏</span><?php }?>
			<?php if (in_array($_smarty_tpl->tpl_vars['user3']->value['uid'],$_smarty_tpl->tpl_vars['useridmsg']->value)) {?><span class="co_fav">已邀请</span><?php }?>
			<?php if ($_smarty_tpl->tpl_vars['user3']->value['rec_resume']) {?>
				<img  src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/jobtj.png" title="站长推荐" class="user_rz_img png fl" width="16"/>
			<?php }?>&nbsp;
		</div>
		<div class="resume_newlist_user">
			<?php if ($_smarty_tpl->tpl_vars['config']->value['com_search']==1&&!$_smarty_tpl->tpl_vars['uid']->value) {?>
				<a href="javascript:void(0);" onclick="showlogin('2');" class="resume_newlist_username"><?php if (in_array($_smarty_tpl->tpl_vars['user3']->value['id'],$_smarty_tpl->tpl_vars['eid']->value)) {
echo $_smarty_tpl->tpl_vars['user3']->value['uname'];
} else {
echo $_smarty_tpl->tpl_vars['user3']->value['username_n'];
}?></a>
			<?php } else { ?>
				<a href="<?php echo $_smarty_tpl->tpl_vars['user3']->value['user_url'];?>
" target="_blank" class="resume_newlist_username"><?php if (in_array($_smarty_tpl->tpl_vars['user3']->value['id'],$_smarty_tpl->tpl_vars['eid']->value)) {
echo $_smarty_tpl->tpl_vars['user3']->value['uname'];
} else {
echo $_smarty_tpl->tpl_vars['user3']->value['username_n'];
}?></a>
			<?php }?>
			<span class="user_listinfo">
				<?php if ($_smarty_tpl->tpl_vars['user3']->value['age']==0) {?>保密<?php } else {
echo $_smarty_tpl->tpl_vars['user3']->value['age'];?>
岁<?php }?>
				 · 
				<?php echo $_smarty_tpl->tpl_vars['user3']->value['exp_n'];?>
经验
				 · 
				<?php echo $_smarty_tpl->tpl_vars['user3']->value['edu_n'];?>
学历&nbsp;
			</span>
			
		</div>

		<div class="resume_newlist_city">
			<?php if ($_smarty_tpl->tpl_vars['user3']->value['expectcity']) {?>
				<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['user3']->value['expectcity']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
				<?php if ($_smarty_tpl->tpl_vars['key']->value<5) {?>
					<span class="user_tag"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</span>
				<?php }?>
				<?php } ?>
			<?php }?>
		</div>
		<?php if ($_smarty_tpl->tpl_vars['user3']->value['top']==1) {?>
			<div class="resume_newlist_date"><img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/Top.gif"/></div>
		<?php } else { ?>
		<div class="resume_newlist_date">
			<?php if ($_smarty_tpl->tpl_vars['user3']->value['redtime']==1||$_smarty_tpl->tpl_vars['user']->value['time']=='昨天') {?>
				<span style="color:red;"><?php echo $_smarty_tpl->tpl_vars['user3']->value['time'];?>
</span>
			<?php } else { ?>
				<?php echo $_smarty_tpl->tpl_vars['user3']->value['time'];?>

			<?php }?>&nbsp;
		</div>
		<?php }?>
		
		<a href="javascript:;" pid="<?php echo $_smarty_tpl->tpl_vars['user3']->value['id'];?>
" class="yunjoblist_new_icon <?php if ($_GET['rtype']!='1') {?>yunjoblist_new_icon_cur<?php }?>" title="<?php if ($_GET['rtype']!='1') {?>收起<?php } else { ?>展开<?php }?>"></a>
	</div>

	<div class="resumeshow <?php if ($_GET['rtype']=='1') {?>none<?php }?>" id="resumeshow<?php echo $_smarty_tpl->tpl_vars['user3']->value['id'];?>
">
		<div class="user_photo_left">

			<?php if ($_smarty_tpl->tpl_vars['config']->value['com_search']==1&&!$_smarty_tpl->tpl_vars['uid']->value) {?>
				<a href="javascript:void(0);" onclick="showlogin('2');"><img src="<?php echo $_smarty_tpl->tpl_vars['user3']->value['photo'];?>
" width="60" height="60" onerror="showImgDelay(this,'<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_member_icon'];?>
',2);" /></a>
			<?php } else { ?>
				<a href="<?php echo $_smarty_tpl->tpl_vars['user3']->value['user_url'];?>
" target="_blank" ><img src="<?php echo $_smarty_tpl->tpl_vars['user3']->value['photo'];?>
" width="60" height="60" onerror="showImgDelay(this,'<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_member_icon'];?>
',2);" /></a>
			<?php }?>

			<i class="resume_list_xb resume_list_xb <?php if ($_smarty_tpl->tpl_vars['user3']->value['sex']=='女') {?>resume_list_xb_nv<?php }?>"></i>
		</div>

		<div class="usersearch_job_left_siaber">

			<div class="user_listinfo_job">工作职能：
				<?php if ($_smarty_tpl->tpl_vars['user3']->value['expectjob']) {?>
					<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['user3']->value['expectjob']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
					<?php if ($_smarty_tpl->tpl_vars['key']->value<5) {?>
						<span class="user_tag"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</span>
					<?php }?>
					<?php } ?>
				<?php }?>
			</div>

			<?php if ($_smarty_tpl->tpl_vars['user3']->value['tag']) {?>
				<ul class="user_tag_user">
					<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['user3']->value['tag']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
						<?php if ($_smarty_tpl->tpl_vars['key']->value<5) {?> <li class="user_tag_user_a"><i class="user_tag_user_icon"></i><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</li><?php }?>
					<?php } ?>
				</ul>
			<?php } else { ?>
				<div class="user_tag_user_p"><?php echo $_smarty_tpl->tpl_vars['user3']->value['user_jobstatus_n'];?>
</div>
			<?php }?>

		</div>
		<div class="user_want">
			<!-- 填的情况 -->
			<?php if ($_smarty_tpl->tpl_vars['user3']->value['work_content']||$_smarty_tpl->tpl_vars['user3']->value['edu_content']) {?>
				<?php if ($_smarty_tpl->tpl_vars['user3']->value['edu_content']) {?>
					<div class="user_undergo"><?php echo $_smarty_tpl->tpl_vars['user3']->value['edu_content'];?>
  </div>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['user3']->value['work_content']) {?>
					<div class="user_undergo"><?php echo $_smarty_tpl->tpl_vars['user3']->value['work_content'];?>
  </div>
				<?php }?>
			<?php } else { ?>
				<div class="user_undergo">到岗时间：<?php echo $_smarty_tpl->tpl_vars['user3']->value['report_n'];?>
</div>
				<div class=" user_undergo">期望薪资：<?php echo $_smarty_tpl->tpl_vars['user3']->value['salary_n'];?>
</div>
			<?php }?>
			<!--填的情况 end-->
		</div>
		<div class="yun_look_right">
			<?php if ($_smarty_tpl->tpl_vars['config']->value['com_search']==1&&!$_smarty_tpl->tpl_vars['uid']->value) {?>
				<a href="javascript:void(0);" onclick="showlogin('2');" class="yun_look_bth">查看</a>
			<?php } else { ?>
				<a href="<?php echo $_smarty_tpl->tpl_vars['user3']->value['user_url'];?>
" target="_blank" class="yun_look_bth">查看</a>
			<?php }?>
		</div>
	</div>
	
	<?php if (in_array($_smarty_tpl->tpl_vars['user3']->value['id'],$_smarty_tpl->tpl_vars['lookResumeIds']->value)) {?><div class="look_user">浏览过</div><?php }?>
</div>
<?php } ?><?php }} ?>
