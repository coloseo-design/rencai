<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 17:25:51
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\lietou\index.htm" */ ?>
<?php /*%%SmartyHeaderCode:1725462d91b9f308235-89085598%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '597586959073c52c590ec6e25b68178ac0907367' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\lietou\\index.htm',
      1 => 1634883835,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1725462d91b9f308235-89085598',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'postkeyword' => 0,
    'keylist' => 0,
    'ad_l' => 0,
    'jlist' => 0,
    'tlist' => 0,
    'ltjoblist' => 0,
    'ltlist' => 0,
    'uid' => 0,
    'linklist' => 0,
    'linklist2' => 0,
    'lietou_style' => 0,
    'style' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d91b9f4b8213_73923238',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d91b9f4b8213_73923238')) {function content_62d91b9f4b8213_73923238($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.url.php';
?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lietoustyle']->value)."/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<div class="clear"></div>

<div class="lt_w1200">
	<div class="lt_kh">
		
		<div class="lt_kh_cj">高端资源，快速拓宽候选人群</div>
		<div class="lt_kh_cjs">领先的中高级人才招聘求职平台</div>
		
		<div class="lt_search_box">
			<div class="lt_search">
			
				<form action="index.php" method="get" id="lietou_login_form" onsubmit="return search_keyword(this,'输入职位关键词：如销售总监等');">
					
					<?php if (!$_smarty_tpl->tpl_vars['config']->value['sy_lietoudir']) {?><input type="hidden" value="lietou" name="m" /><?php }?>
					<input type="hidden" value="post" name="c" id="search_type" />
					
					<div class="index_hunter_search_con fl">
						<div class="index_search_name f16 fl">
							<span id="search_type_name">职位</span>
							<ul class="index_search_name_list none">
								<li><a href="javascript:;" search_type="famous">公司</a></li>
								<li><a href="javascript:;" search_type="post">职位</a></li>
								<li><a href="javascript:;" search_type="service">猎头</a></li>
							</ul>
						</div>
						<div class="sindex_earch_keyword fl">
							<input class="hunter_search_text fl" type="text" value="输入职位关键词：如销售总监等" onClick="if(this.value=='输入职位关键词：如销售总监等'){this.value=''}" onBlur="if(this.value==''){this.value='输入职位关键词：如销售总监等'}" name="keyword" id="search" />
						</div>
					</div>
					<input class="index_search_bth f16  fl" type="submit" value="搜 索" />
				</form>
        	</div>
		    
		    <?php if ($_smarty_tpl->tpl_vars['postkeyword']->value) {?>
				<div class="index_hunter_search_tag">
				热门搜索：
					<?php  $_smarty_tpl->tpl_vars['keylist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['keylist']->_loop = false;
global $config;$paramer=array("limit"=>"9","tuijian"=>"1","type"=>"7","item"=>"'keylist'","nocache"=>"")
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
					<a href="<?php echo $_smarty_tpl->tpl_vars['keylist']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['keylist']->value['key_title'];?>
</a>
					<?php } ?>
				</div>
		    <?php } else { ?>
				<div class="index_hunter_search_tag fl">&nbsp;</div>
			<?php }?>
		</div>
	</div>
</div>

<div class="hunter_bar">
	<div class="hunter_bar_bg"></div>
	<div class="layui-carousel" id="test1" lay-filter="test1">
		  <div carousel-item="">
		  	<?php  $_smarty_tpl->tpl_vars['ad_l'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['ad_l']->_loop = false;
global $db,$db_config,$config;$AdArr=array();$paramer=array();$attr=array("classid"=>"9","name"=>"'foo'","item"=>"'ad_l'","nocache"=>"")
;
			include(PLUS_PATH.'pimg_cache.php');$add_arr = $ad_label[9];if(is_array($add_arr) && !empty($add_arr)){
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
foreach ($AdArr as $_smarty_tpl->tpl_vars['ad_l']->key => $_smarty_tpl->tpl_vars['ad_l']->value) {
$_smarty_tpl->tpl_vars['ad_l']->_loop = true;
?> 
		      <div><a href="<?php echo $_smarty_tpl->tpl_vars['ad_l']->value['src'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['ad_l']->value['pic'];?>
" /></a></div>
		    <?php } ?>
		  </div>
	</div>
</div>


<?php if ($_smarty_tpl->tpl_vars['config']->value['lt_rec_rebates']=='1') {?>
<div class="clear"></div>
<!--职位-->
<div class="lt_w1200">
	<div class="lt_index_tit">
		
		<span class="lt_index_tit_s"> 悬赏招聘</span>
		
		<div class="lt_index_tit_p">
			<span class="lt_index_tit_span"><i class="lt_index_tit_linel"></i><i class="lt_index_tit_liner"></i>新鲜职位火速推荐，获得相应赏金</span>
		</div>
	</div>
	
	<div class="lt_index_job_box">
		<div class="lt_index_job_c">
			<ul class="lt_index_rewardjob">
				<?php  $_smarty_tpl->tpl_vars['jlist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['jlist']->_loop = false;
global $db,$db_config,$config;$paramer=array("rebates"=>"1","order"=>"'lastupdate'","ispage"=>"1","limit"=>"6","item"=>"'jlist'","nocache"=>"")
;$jlist=array();
        include_once  PLUS_PATH."/ltjob.cache.php";
		include_once  PLUS_PATH."/lthy.cache.php";
		//处理传入参数，并且构造分页参数
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
		$Purl =  $ParamerArr[purl];
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }
        $cache_array = $db->cacheget();
        $industry_name	= $cache_array["industry_name"];
		$where = " `status`='1' and `zp_status`='0' and `r_status`='1'";
		//是否属于分站下
		if($config[sy_web_site]=="1"){
			if($config[province]>0 && $config[province]!=""){
				$paramer[provinceid] = $config[province];
			}
			if($config[cityid]>0 && $config[cityid]!=""){
				$paramer[cityid]=$config[cityid];
			}
			if($config[three_cityid]>0 && $config[three_cityid]!=""){
				$paramer[three_cityid] = $config[three_cityid];
			}
		}
		//关键字
		if($paramer["keyword"]){
			$where.=" AND (`com_name` like '%".$paramer["keyword"]."%' or `job_name` like '%".$paramer["keyword"]."%')";
		}
		/*//期望行业大类
		if($paramer["hyclass"]){
			$hyid=$lthy_type[$paramer["hyclass"]];
			foreach($hyid as $v)
			{
				$hyarr[]= "FIND_IN_SET('".$v."',qw_hy)";
			}
			$hyarr=@implode(" or ",$hyarr);
			$where.=" AND ($hyarr)";
		}
		//期望行业子类
		if($paramer["qw_hy"]){
			$where.= " AND FIND_IN_SET('".$paramer["qw_hy"]."',qw_hy)";
		}
		//期望行业
		if($paramer["hyid"]){
			$hyid=@explode(",",$paramer["hyid"]);
			foreach($hyid as $v){
				$hyall[].= "FIND_IN_SET('".$v."',qw_hy)";
			}
			$where .= " and (".@implode(" or ",$hyall).")";
		}*/

		//擅长职位
		if($paramer["jobid"]){
			$jobid=@explode(",",$paramer["jobid"]);
			foreach($jobid as $v){
				$joball[].= "`jobone`='".$v."'";
				$joball[].= "`jobtwo`='".$v."'";
			}
			$where .= " and (".@implode(" or ",$joball).")";
		}
		 
		if($paramer["citys"]){
			$citys=@explode(",",$paramer["citys"]);
			foreach($citys as $v){
				$cityall[].= "`provinceid`='".$v."'";
				$cityall[].= "`cityid`='".$v."'";
				$cityall[].= "`three_cityid`='".$v."'";
			}
			$where .= " and (".@implode(" or ",$cityall).")";
		}
		//职位大类
		if($paramer["jobone"]){
			$where.=" AND `jobone`='".$paramer["jobone"]."'";
		}
		//职位子类
		if($paramer["jobtwo"]){
			$where.=" AND `jobtwo`='".$paramer["jobtwo"]."'";
		}
		//年薪
		if($paramer["salary"]){
			$where.=" AND `salary`='".$paramer["salary"]."'";
		}
		if($paramer[minsalary]&&$paramer[maxsalary]){
			$where.= "AND `minsalary`>=".intval($paramer[minsalary])." and `maxsalary`<=".intval($paramer[maxsalary])."";
		}elseif($paramer[minsalary]&&!$paramer[maxsalary]){
			$where.= " AND `minsalary`>=".intval($paramer[minsalary])."";
		}elseif(!$paramer[minsalary]&&$paramer[maxsalary]){
			$where.= " AND `maxsalary`<=".intval($paramer[maxsalary])."";
		}
        //公司所属行业
		if($paramer["hy"]){
			$where.=" AND `hy`='".$paramer["hy"]."'";
		}
        //公司性质
		if($paramer["pr"]){
			$where.=" AND `pr`='".$paramer["pr"]."'";
		}
        //公司规模
		if($paramer["mun"]){
			$where.=" AND `mun`='".$paramer["mun"]."'";
		}
        //工作经验
		if($paramer["exp"]){
			$where.=" AND `exp`='".$paramer["exp"]."'";
		}
        //学历要求
		if($paramer["edu"]){
			$where.=" AND `edu`='".$paramer["edu"]."'";
		}
		//发布时间
		if($paramer["uptime"]){
			if($paramer["uptime"]>0){
				$time=time()-86400*30*$paramer["uptime"];
				$where.=" AND `lastupdate`>$time";
			}else{
				$time=time()-86400*30*12;
				$where.=" AND `lastupdate`<$time";
			}
		}
		//推荐
		if($paramer["rec"]){
			$where.=" AND `rec`='".$paramer["rec"]."'";
		}
		//城市
		if($paramer["provinceid"]){
			$where.=" AND `provinceid`='".$paramer["provinceid"]."'";
		}
		if($paramer["cityid"]){
			$where.=" AND `cityid`='".$paramer["cityid"]."'";
		}
		if($paramer["three_cityid"]){
			$where.=" AND `three_cityid`='".$paramer["three_cityid"]."'";
		}
		//用户uid
		if($paramer["uid"]){
			$where.=" AND `uid`='".$paramer["uid"]."'";
		}
		if($paramer["rebates"]=='1'){
			$where.=" AND `rebates`<>''";
		}
		if($paramer["limit"]){
			$limit= " limit $paramer[limit]";
		}
		if($paramer[ispage]){
			$limit = PageNav($paramer,$_GET,"lt_job",$where,$Purl,"",$paramer[islt]?$paramer[islt]:"1",$_smarty_tpl);
         
		}
		//排序字段（默认按照uid排序）
		if($paramer[order]){
			$where .= " ORDER BY $paramer[order]";
		}else{
			$where .= " ORDER BY  `lastupdate`  ";
		}
		//排序规则（默认按照开始时间排序倒序）
		if($paramer["sort"]){
			$where .= " $paramer[sort]";
		}else{
			$where .= " DESC ";
		}
		 
		$jlist=$db->select_all("lt_job",$where.$limit);
		if(!$paramer[ispage]){
			$_smarty_tpl->tpl_vars["t_count"]->value=count($jlist);
		}
		
		if(is_array($jlist)){
			foreach($jlist as $v){
				if($v['usertype']==2){
					$comuid[]=$v['uid'];
    			}
                if($v['usertype']==3){
					$comuid[]=$v['uid'];
    			}
    		}
    	}
    	$comlist = array();
    	$ltlist = array();
    	if(is_array($comuid) && count($comuid)){
    		$comlist=$db->select_all("company","`uid` IN (".@implode(',',$comuid).")","`uid`,`name`,`hy`,`logo`");
        	$ltlist=$db->select_all("lt_info","`uid` IN (".@implode(',',$comuid).")","`uid`,`hy`,`photo_big`");
		}
		
		
		if(is_array($jlist)){
			$uid = array();
			foreach($jlist as $k=>$v){
				if(is_array($jlist)){
					foreach($atn as $val){
						if($v[uid]==$val[sc_uid]){
							$jlist[$k][atn]=1;
						}
					}
				}
				$uid[]=$v[uid];
			}
			$ratings = array();
			$joblist = array();
			if(count($uid)){
				$ratings=$db->DB_query_all("select a.uid,b.com_pic from $db_config[def]company_statis a left join $db_config[def]company_rating b on a.rating = b.id WHERE a.uid in (".@implode(",",$uid).")","all");
				$joblist=$db->select_all("lt_job","`status`='1' and `uid` in (".@implode(",",$uid).") and `r_status`='1' order by `lastupdate` desc");
			}
			foreach($jlist as $k=>$v){
				foreach($ratings as $val)
				{//猎头图标
					if($v[uid]==$val[uid] && $v[usertype]==2){
						if($val["com_pic"]){
							$jlist[$k]["com_pic"]=$val["com_pic"];
						}
                        
					}
				}
				
			}
		}
		if(is_array($jlist)){
			foreach($jlist as $k=>$v){
				$jlist[$k] = $db->lt_array_action($v);
				//对job_name 截取
				if(intval($paramer['t_len'])>0){
					$len = intval($paramer['t_len']);
					$jlist[$k]['job_name'] = mb_substr($v['job_name'],0,$len,"utf-8");
				}
				if($v['usertype']==3){
                    $jlist[$k]["lt_url"] = Url("lietou",array("c"=>"headhunter","uid"=>$v[uid]));
					$jlist[$k]["job_url"] = Url("lietou",array("c"=>"jobshow","id"=>$v['id']));
					 $jlist[$k]["wap_lt_url"] = Url("wap",array("c"=>"ltjob","a"=>"headhunter","uid"=>$v[uid]));
				}else{
                    $jlist[$k]["lt_url"] = Url("company",array("c"=>"show","id"=>$v['uid']));
					$jlist[$k]["job_url"] = Url("lietou",array("c"=>"jobcomshow","id"=>$v['id']));
					$jlist[$k]["wap_lt_url"] = Url("wap",array("c"=>"company","a"=>"show","id"=>$v['uid']));
				}		
				if($v['minsalary']>0&&$v['maxsalary']>0){
					$jlist[$k]["salary_info"] = floatval($v['minsalary'])."-".floatval($v['maxsalary'])."万";    
                }else if($v['minsalary']>0){
                    $jlist[$k]["salary_info"] = floatval($v['minsalary'])."万";  
                }else{
    				$jlist[$k]["salary_info"] = "面议";
    			}
                
				$jlist[$k]["lastupdate"] = date("Y-m-d",$v["lastupdate"]);
				  if($v['usertype']==3){
              foreach($ltlist as $val){

                if($v['uid']==$val['uid']  && $v[usertype]==3){

                              if($val[hy]!=""){

                                 $hy="";

                                 $hyarr=@explode(",",$val[hy]);

                                  foreach($hyarr as $vall){

                                      $hy.=$lthy_name[$vall]." ";

                                  }

                                  $jlist[$k][hy_n] = mb_substr($hy,0,$paramer[comlen],"utf-8");

                              }

                  $jlist[$k]['logo_n'] = checkpic($val['photo_big'],$config['sy_lt_icon']);

                  }

              }
          }else{
              foreach($comlist as $val){

                if($v['uid']==$val['uid']&&$val['name']){

                    $jlist[$k]["com_name"]=$val['name'];
                    $jlist[$k]["hy_n"]=$industry_name[$val['hy']];
                    $jlist[$k]['logo_n'] = checkpic($val['logo'],$config['sy_unit_icon']);

                  }

              }
          }
			}
		} 
		if($paramer['keyword']!=""&&!empty($jlist)){
			addkeywords('7',$paramer['keyword']);
		}$jlist = $jlist; if (!is_array($jlist) && !is_object($jlist)) { settype($jlist, 'array');}
foreach ($jlist as $_smarty_tpl->tpl_vars['jlist']->key => $_smarty_tpl->tpl_vars['jlist']->value) {
$_smarty_tpl->tpl_vars['jlist']->_loop = true;
?>        
				<li>
					<div class="lt_index_rewardjob_sj">
						<div class="lt_index_rewardjob_sj_name">赏金</div>
						<?php if ($_smarty_tpl->tpl_vars['jlist']->value['rebates']>'9999') {?>
							<?php echo $_smarty_tpl->tpl_vars['jlist']->value['rebates'];?>

						<?php } else { ?>
							￥<?php echo $_smarty_tpl->tpl_vars['jlist']->value['rebates'];?>

						<?php }?>
						<?php if ($_smarty_tpl->tpl_vars['config']->value['lt_rebates_name']) {?>
                        	<?php } else { ?>
                        <?php }?>
                 	</div>
					<div class="lt_index_rewardjob_c">
						<div class="lt_index_rewardjob_jobname"> <a href="<?php echo $_smarty_tpl->tpl_vars['jlist']->value['job_url'];?>
" target="_blank" title="<?php echo $_smarty_tpl->tpl_vars['jlist']->value['job_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['jlist']->value['job_name'];?>
</a></div>
						<div class="lt_index_rewardjob_info">
						<span class="lt_index_rewardjob_info_xz"><?php echo $_smarty_tpl->tpl_vars['jlist']->value['salary_info'];?>
</span><?php echo $_smarty_tpl->tpl_vars['jlist']->value['cityid_info'];?>
<span class="lt_index_job_line">|</span><?php echo $_smarty_tpl->tpl_vars['jlist']->value['edu_info'];?>
学历<span class="lt_index_job_line">|</span><?php echo $_smarty_tpl->tpl_vars['jlist']->value['exp_info'];?>
经验</div>
						<div class="lt_index_rewardjob_time">更新：<?php echo $_smarty_tpl->tpl_vars['jlist']->value['lastupdate'];?>
</div>
					</div>
					<a href="<?php echo $_smarty_tpl->tpl_vars['jlist']->value['job_url'];?>
" target="_blank" class="lt_index_rewardjob_tj">推荐<i class="lt_index_rewardjob_tjicon"></i></a>
				</li>
				<?php } ?>
			</ul>
		</div>
		<div class="lt_index_job_more">	<a href="<?php echo smarty_function_url(array('m'=>'lietou','c'=>'post','rebates'=>1),$_smarty_tpl);?>
" class="lt_index_job_more_a">+ 查看更多</a></div>
	</div>
</div>
<?php }?>

<div class="clear"></div>

<div class="lt_index_tit" >
	<span class="lt_index_tit_s" > 推荐职位</span>
	<div class="lt_index_tit_p">
		<span class="lt_index_tit_span"><i class="lt_index_tit_linel"></i><i class="lt_index_tit_liner"></i>精选职位任您挑选，快速解决就业难题</span>
	</div>
</div>

<div style="width:100%; background:#fff;-webkit-box-shadow: 0 0 10px 0 rgba(56,81,76,.12);box-shadow: 0 0 10px 0 rgba(56,81,76,.12);">
	<div class="lt_w1200">
		<div class="lt_index_job_box">
			<div class="lt_index_job_c">
				<div class="hotjob_box">
					<ul>
						<?php  $_smarty_tpl->tpl_vars['tlist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tlist']->_loop = false;
global $db,$db_config,$config;$paramer=array("rec"=>"1","order"=>"'lastupdate'","ispage"=>"1","limit"=>"8","item"=>"'tlist'","nocache"=>"")
;$tlist=array();
        include_once  PLUS_PATH."/ltjob.cache.php";
		include_once  PLUS_PATH."/lthy.cache.php";
		//处理传入参数，并且构造分页参数
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
		$Purl =  $ParamerArr[purl];
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }
        $cache_array = $db->cacheget();
        $industry_name	= $cache_array["industry_name"];
		$where = " `status`='1' and `zp_status`='0' and `r_status`='1'";
		//是否属于分站下
		if($config[sy_web_site]=="1"){
			if($config[province]>0 && $config[province]!=""){
				$paramer[provinceid] = $config[province];
			}
			if($config[cityid]>0 && $config[cityid]!=""){
				$paramer[cityid]=$config[cityid];
			}
			if($config[three_cityid]>0 && $config[three_cityid]!=""){
				$paramer[three_cityid] = $config[three_cityid];
			}
		}
		//关键字
		if($paramer["keyword"]){
			$where.=" AND (`com_name` like '%".$paramer["keyword"]."%' or `job_name` like '%".$paramer["keyword"]."%')";
		}
		/*//期望行业大类
		if($paramer["hyclass"]){
			$hyid=$lthy_type[$paramer["hyclass"]];
			foreach($hyid as $v)
			{
				$hyarr[]= "FIND_IN_SET('".$v."',qw_hy)";
			}
			$hyarr=@implode(" or ",$hyarr);
			$where.=" AND ($hyarr)";
		}
		//期望行业子类
		if($paramer["qw_hy"]){
			$where.= " AND FIND_IN_SET('".$paramer["qw_hy"]."',qw_hy)";
		}
		//期望行业
		if($paramer["hyid"]){
			$hyid=@explode(",",$paramer["hyid"]);
			foreach($hyid as $v){
				$hyall[].= "FIND_IN_SET('".$v."',qw_hy)";
			}
			$where .= " and (".@implode(" or ",$hyall).")";
		}*/

		//擅长职位
		if($paramer["jobid"]){
			$jobid=@explode(",",$paramer["jobid"]);
			foreach($jobid as $v){
				$joball[].= "`jobone`='".$v."'";
				$joball[].= "`jobtwo`='".$v."'";
			}
			$where .= " and (".@implode(" or ",$joball).")";
		}
		 
		if($paramer["citys"]){
			$citys=@explode(",",$paramer["citys"]);
			foreach($citys as $v){
				$cityall[].= "`provinceid`='".$v."'";
				$cityall[].= "`cityid`='".$v."'";
				$cityall[].= "`three_cityid`='".$v."'";
			}
			$where .= " and (".@implode(" or ",$cityall).")";
		}
		//职位大类
		if($paramer["jobone"]){
			$where.=" AND `jobone`='".$paramer["jobone"]."'";
		}
		//职位子类
		if($paramer["jobtwo"]){
			$where.=" AND `jobtwo`='".$paramer["jobtwo"]."'";
		}
		//年薪
		if($paramer["salary"]){
			$where.=" AND `salary`='".$paramer["salary"]."'";
		}
		if($paramer[minsalary]&&$paramer[maxsalary]){
			$where.= "AND `minsalary`>=".intval($paramer[minsalary])." and `maxsalary`<=".intval($paramer[maxsalary])."";
		}elseif($paramer[minsalary]&&!$paramer[maxsalary]){
			$where.= " AND `minsalary`>=".intval($paramer[minsalary])."";
		}elseif(!$paramer[minsalary]&&$paramer[maxsalary]){
			$where.= " AND `maxsalary`<=".intval($paramer[maxsalary])."";
		}
        //公司所属行业
		if($paramer["hy"]){
			$where.=" AND `hy`='".$paramer["hy"]."'";
		}
        //公司性质
		if($paramer["pr"]){
			$where.=" AND `pr`='".$paramer["pr"]."'";
		}
        //公司规模
		if($paramer["mun"]){
			$where.=" AND `mun`='".$paramer["mun"]."'";
		}
        //工作经验
		if($paramer["exp"]){
			$where.=" AND `exp`='".$paramer["exp"]."'";
		}
        //学历要求
		if($paramer["edu"]){
			$where.=" AND `edu`='".$paramer["edu"]."'";
		}
		//发布时间
		if($paramer["uptime"]){
			if($paramer["uptime"]>0){
				$time=time()-86400*30*$paramer["uptime"];
				$where.=" AND `lastupdate`>$time";
			}else{
				$time=time()-86400*30*12;
				$where.=" AND `lastupdate`<$time";
			}
		}
		//推荐
		if($paramer["rec"]){
			$where.=" AND `rec`='".$paramer["rec"]."'";
		}
		//城市
		if($paramer["provinceid"]){
			$where.=" AND `provinceid`='".$paramer["provinceid"]."'";
		}
		if($paramer["cityid"]){
			$where.=" AND `cityid`='".$paramer["cityid"]."'";
		}
		if($paramer["three_cityid"]){
			$where.=" AND `three_cityid`='".$paramer["three_cityid"]."'";
		}
		//用户uid
		if($paramer["uid"]){
			$where.=" AND `uid`='".$paramer["uid"]."'";
		}
		if($paramer["rebates"]=='1'){
			$where.=" AND `rebates`<>''";
		}
		if($paramer["limit"]){
			$limit= " limit $paramer[limit]";
		}
		if($paramer[ispage]){
			$limit = PageNav($paramer,$_GET,"lt_job",$where,$Purl,"",$paramer[islt]?$paramer[islt]:"1",$_smarty_tpl);
         
		}
		//排序字段（默认按照uid排序）
		if($paramer[order]){
			$where .= " ORDER BY $paramer[order]";
		}else{
			$where .= " ORDER BY  `lastupdate`  ";
		}
		//排序规则（默认按照开始时间排序倒序）
		if($paramer["sort"]){
			$where .= " $paramer[sort]";
		}else{
			$where .= " DESC ";
		}
		 
		$tlist=$db->select_all("lt_job",$where.$limit);
		if(!$paramer[ispage]){
			$_smarty_tpl->tpl_vars["t_count"]->value=count($tlist);
		}
		
		if(is_array($tlist)){
			foreach($tlist as $v){
				if($v['usertype']==2){
					$comuid[]=$v['uid'];
    			}
                if($v['usertype']==3){
					$comuid[]=$v['uid'];
    			}
    		}
    	}
    	$comlist = array();
    	$ltlist = array();
    	if(is_array($comuid) && count($comuid)){
    		$comlist=$db->select_all("company","`uid` IN (".@implode(',',$comuid).")","`uid`,`name`,`hy`,`logo`");
        	$ltlist=$db->select_all("lt_info","`uid` IN (".@implode(',',$comuid).")","`uid`,`hy`,`photo_big`");
		}
		
		
		if(is_array($tlist)){
			$uid = array();
			foreach($tlist as $k=>$v){
				if(is_array($tlist)){
					foreach($atn as $val){
						if($v[uid]==$val[sc_uid]){
							$tlist[$k][atn]=1;
						}
					}
				}
				$uid[]=$v[uid];
			}
			$ratings = array();
			$joblist = array();
			if(count($uid)){
				$ratings=$db->DB_query_all("select a.uid,b.com_pic from $db_config[def]company_statis a left join $db_config[def]company_rating b on a.rating = b.id WHERE a.uid in (".@implode(",",$uid).")","all");
				$joblist=$db->select_all("lt_job","`status`='1' and `uid` in (".@implode(",",$uid).") and `r_status`='1' order by `lastupdate` desc");
			}
			foreach($tlist as $k=>$v){
				foreach($ratings as $val)
				{//猎头图标
					if($v[uid]==$val[uid] && $v[usertype]==2){
						if($val["com_pic"]){
							$tlist[$k]["com_pic"]=$val["com_pic"];
						}
                        
					}
				}
				
			}
		}
		if(is_array($tlist)){
			foreach($tlist as $k=>$v){
				$tlist[$k] = $db->lt_array_action($v);
				//对job_name 截取
				if(intval($paramer['t_len'])>0){
					$len = intval($paramer['t_len']);
					$tlist[$k]['job_name'] = mb_substr($v['job_name'],0,$len,"utf-8");
				}
				if($v['usertype']==3){
                    $tlist[$k]["lt_url"] = Url("lietou",array("c"=>"headhunter","uid"=>$v[uid]));
					$tlist[$k]["job_url"] = Url("lietou",array("c"=>"jobshow","id"=>$v['id']));
					 $tlist[$k]["wap_lt_url"] = Url("wap",array("c"=>"ltjob","a"=>"headhunter","uid"=>$v[uid]));
				}else{
                    $tlist[$k]["lt_url"] = Url("company",array("c"=>"show","id"=>$v['uid']));
					$tlist[$k]["job_url"] = Url("lietou",array("c"=>"jobcomshow","id"=>$v['id']));
					$tlist[$k]["wap_lt_url"] = Url("wap",array("c"=>"company","a"=>"show","id"=>$v['uid']));
				}		
				if($v['minsalary']>0&&$v['maxsalary']>0){
					$tlist[$k]["salary_info"] = floatval($v['minsalary'])."-".floatval($v['maxsalary'])."万";    
                }else if($v['minsalary']>0){
                    $tlist[$k]["salary_info"] = floatval($v['minsalary'])."万";  
                }else{
    				$tlist[$k]["salary_info"] = "面议";
    			}
                
				$tlist[$k]["lastupdate"] = date("Y-m-d",$v["lastupdate"]);
				  if($v['usertype']==3){
              foreach($ltlist as $val){

                if($v['uid']==$val['uid']  && $v[usertype]==3){

                              if($val[hy]!=""){

                                 $hy="";

                                 $hyarr=@explode(",",$val[hy]);

                                  foreach($hyarr as $vall){

                                      $hy.=$lthy_name[$vall]." ";

                                  }

                                  $tlist[$k][hy_n] = mb_substr($hy,0,$paramer[comlen],"utf-8");

                              }

                  $tlist[$k]['logo_n'] = checkpic($val['photo_big'],$config['sy_lt_icon']);

                  }

              }
          }else{
              foreach($comlist as $val){

                if($v['uid']==$val['uid']&&$val['name']){

                    $tlist[$k]["com_name"]=$val['name'];
                    $tlist[$k]["hy_n"]=$industry_name[$val['hy']];
                    $tlist[$k]['logo_n'] = checkpic($val['logo'],$config['sy_unit_icon']);

                  }

              }
          }
			}
		} 
		if($paramer['keyword']!=""&&!empty($tlist)){
			addkeywords('7',$paramer['keyword']);
		}$tlist = $tlist; if (!is_array($tlist) && !is_object($tlist)) { settype($tlist, 'array');}
foreach ($tlist as $_smarty_tpl->tpl_vars['tlist']->key => $_smarty_tpl->tpl_vars['tlist']->value) {
$_smarty_tpl->tpl_vars['tlist']->_loop = true;
?> 
						<li class="hotjob_list">
							<div class="hotjob_logo">
								<div class="hotjob_name"><a href="<?php echo $_smarty_tpl->tpl_vars['tlist']->value['job_url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['tlist']->value['job_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['tlist']->value['job_name'];?>
</a></div>
								<i class="hotjob_nameicon"></i>
							</div>
							<div class="hotjob_infobox">
								<div class="hotjob_xz"><?php echo $_smarty_tpl->tpl_vars['tlist']->value['salary_info'];?>
</div>
								<div class="hotjob_info"><?php echo $_smarty_tpl->tpl_vars['tlist']->value['cityid_info'];?>
 / <?php echo $_smarty_tpl->tpl_vars['tlist']->value['exp_info'];?>
经验 / <?php echo $_smarty_tpl->tpl_vars['tlist']->value['edu_info'];?>
学历</div>
								<div class="hotjob_time"><?php echo $_smarty_tpl->tpl_vars['tlist']->value['lastupdate'];?>
发布</div>
							</div>
						</li>
						<?php } ?>
					</ul>
				</div>
			</div>
			<div class="lt_index_job_more">	<a href="<?php echo smarty_function_url(array('m'=>'lietou','c'=>'post','rec'=>1),$_smarty_tpl);?>
" class="lt_index_job_more_a" style="background:#f60;color:#fff">+ 查看更多</a></div>
		</div>
	</div>
</div>

<div class="lt_w1200">
	
	<div class="clear"></div>
	
	<div class="lt_index_tit">
		<span class="lt_index_tit_s"> 最新职位</span>
		<div class="lt_index_tit_p">
			<span class="lt_index_tit_span"><i class="lt_index_tit_linel"></i><i class="lt_index_tit_liner"></i>每日精选优质职位，满足你的个性要求</span>
		</div>
	</div>
	
	<div class="lt_index_job_box">
		<div class="lt_index_job_c">
		
			<ul class="lt_index_job_box_ul">
				<?php  $_smarty_tpl->tpl_vars['ltjoblist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['ltjoblist']->_loop = false;
global $db,$db_config,$config;$paramer=array("comlen"=>"10","item"=>"'ltjoblist'","ispage"=>"1","limit"=>"16","nocache"=>"")
;$ltjoblist=array();
        include_once  PLUS_PATH."/ltjob.cache.php";
		include_once  PLUS_PATH."/lthy.cache.php";
		//处理传入参数，并且构造分页参数
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
		$Purl =  $ParamerArr[purl];
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }
        $cache_array = $db->cacheget();
        $industry_name	= $cache_array["industry_name"];
		$where = " `status`='1' and `zp_status`='0' and `r_status`='1'";
		//是否属于分站下
		if($config[sy_web_site]=="1"){
			if($config[province]>0 && $config[province]!=""){
				$paramer[provinceid] = $config[province];
			}
			if($config[cityid]>0 && $config[cityid]!=""){
				$paramer[cityid]=$config[cityid];
			}
			if($config[three_cityid]>0 && $config[three_cityid]!=""){
				$paramer[three_cityid] = $config[three_cityid];
			}
		}
		//关键字
		if($paramer["keyword"]){
			$where.=" AND (`com_name` like '%".$paramer["keyword"]."%' or `job_name` like '%".$paramer["keyword"]."%')";
		}
		/*//期望行业大类
		if($paramer["hyclass"]){
			$hyid=$lthy_type[$paramer["hyclass"]];
			foreach($hyid as $v)
			{
				$hyarr[]= "FIND_IN_SET('".$v."',qw_hy)";
			}
			$hyarr=@implode(" or ",$hyarr);
			$where.=" AND ($hyarr)";
		}
		//期望行业子类
		if($paramer["qw_hy"]){
			$where.= " AND FIND_IN_SET('".$paramer["qw_hy"]."',qw_hy)";
		}
		//期望行业
		if($paramer["hyid"]){
			$hyid=@explode(",",$paramer["hyid"]);
			foreach($hyid as $v){
				$hyall[].= "FIND_IN_SET('".$v."',qw_hy)";
			}
			$where .= " and (".@implode(" or ",$hyall).")";
		}*/

		//擅长职位
		if($paramer["jobid"]){
			$jobid=@explode(",",$paramer["jobid"]);
			foreach($jobid as $v){
				$joball[].= "`jobone`='".$v."'";
				$joball[].= "`jobtwo`='".$v."'";
			}
			$where .= " and (".@implode(" or ",$joball).")";
		}
		 
		if($paramer["citys"]){
			$citys=@explode(",",$paramer["citys"]);
			foreach($citys as $v){
				$cityall[].= "`provinceid`='".$v."'";
				$cityall[].= "`cityid`='".$v."'";
				$cityall[].= "`three_cityid`='".$v."'";
			}
			$where .= " and (".@implode(" or ",$cityall).")";
		}
		//职位大类
		if($paramer["jobone"]){
			$where.=" AND `jobone`='".$paramer["jobone"]."'";
		}
		//职位子类
		if($paramer["jobtwo"]){
			$where.=" AND `jobtwo`='".$paramer["jobtwo"]."'";
		}
		//年薪
		if($paramer["salary"]){
			$where.=" AND `salary`='".$paramer["salary"]."'";
		}
		if($paramer[minsalary]&&$paramer[maxsalary]){
			$where.= "AND `minsalary`>=".intval($paramer[minsalary])." and `maxsalary`<=".intval($paramer[maxsalary])."";
		}elseif($paramer[minsalary]&&!$paramer[maxsalary]){
			$where.= " AND `minsalary`>=".intval($paramer[minsalary])."";
		}elseif(!$paramer[minsalary]&&$paramer[maxsalary]){
			$where.= " AND `maxsalary`<=".intval($paramer[maxsalary])."";
		}
        //公司所属行业
		if($paramer["hy"]){
			$where.=" AND `hy`='".$paramer["hy"]."'";
		}
        //公司性质
		if($paramer["pr"]){
			$where.=" AND `pr`='".$paramer["pr"]."'";
		}
        //公司规模
		if($paramer["mun"]){
			$where.=" AND `mun`='".$paramer["mun"]."'";
		}
        //工作经验
		if($paramer["exp"]){
			$where.=" AND `exp`='".$paramer["exp"]."'";
		}
        //学历要求
		if($paramer["edu"]){
			$where.=" AND `edu`='".$paramer["edu"]."'";
		}
		//发布时间
		if($paramer["uptime"]){
			if($paramer["uptime"]>0){
				$time=time()-86400*30*$paramer["uptime"];
				$where.=" AND `lastupdate`>$time";
			}else{
				$time=time()-86400*30*12;
				$where.=" AND `lastupdate`<$time";
			}
		}
		//推荐
		if($paramer["rec"]){
			$where.=" AND `rec`='".$paramer["rec"]."'";
		}
		//城市
		if($paramer["provinceid"]){
			$where.=" AND `provinceid`='".$paramer["provinceid"]."'";
		}
		if($paramer["cityid"]){
			$where.=" AND `cityid`='".$paramer["cityid"]."'";
		}
		if($paramer["three_cityid"]){
			$where.=" AND `three_cityid`='".$paramer["three_cityid"]."'";
		}
		//用户uid
		if($paramer["uid"]){
			$where.=" AND `uid`='".$paramer["uid"]."'";
		}
		if($paramer["rebates"]=='1'){
			$where.=" AND `rebates`<>''";
		}
		if($paramer["limit"]){
			$limit= " limit $paramer[limit]";
		}
		if($paramer[ispage]){
			$limit = PageNav($paramer,$_GET,"lt_job",$where,$Purl,"",$paramer[islt]?$paramer[islt]:"1",$_smarty_tpl);
         
		}
		//排序字段（默认按照uid排序）
		if($paramer[order]){
			$where .= " ORDER BY $paramer[order]";
		}else{
			$where .= " ORDER BY  `lastupdate`  ";
		}
		//排序规则（默认按照开始时间排序倒序）
		if($paramer["sort"]){
			$where .= " $paramer[sort]";
		}else{
			$where .= " DESC ";
		}
		 
		$ltjoblist=$db->select_all("lt_job",$where.$limit);
		if(!$paramer[ispage]){
			$_smarty_tpl->tpl_vars["t_count"]->value=count($ltjoblist);
		}
		
		if(is_array($ltjoblist)){
			foreach($ltjoblist as $v){
				if($v['usertype']==2){
					$comuid[]=$v['uid'];
    			}
                if($v['usertype']==3){
					$comuid[]=$v['uid'];
    			}
    		}
    	}
    	$comlist = array();
    	$ltlist = array();
    	if(is_array($comuid) && count($comuid)){
    		$comlist=$db->select_all("company","`uid` IN (".@implode(',',$comuid).")","`uid`,`name`,`hy`,`logo`");
        	$ltlist=$db->select_all("lt_info","`uid` IN (".@implode(',',$comuid).")","`uid`,`hy`,`photo_big`");
		}
		
		
		if(is_array($ltjoblist)){
			$uid = array();
			foreach($ltjoblist as $k=>$v){
				if(is_array($ltjoblist)){
					foreach($atn as $val){
						if($v[uid]==$val[sc_uid]){
							$ltjoblist[$k][atn]=1;
						}
					}
				}
				$uid[]=$v[uid];
			}
			$ratings = array();
			$joblist = array();
			if(count($uid)){
				$ratings=$db->DB_query_all("select a.uid,b.com_pic from $db_config[def]company_statis a left join $db_config[def]company_rating b on a.rating = b.id WHERE a.uid in (".@implode(",",$uid).")","all");
				$joblist=$db->select_all("lt_job","`status`='1' and `uid` in (".@implode(",",$uid).") and `r_status`='1' order by `lastupdate` desc");
			}
			foreach($ltjoblist as $k=>$v){
				foreach($ratings as $val)
				{//猎头图标
					if($v[uid]==$val[uid] && $v[usertype]==2){
						if($val["com_pic"]){
							$ltjoblist[$k]["com_pic"]=$val["com_pic"];
						}
                        
					}
				}
				
			}
		}
		if(is_array($ltjoblist)){
			foreach($ltjoblist as $k=>$v){
				$ltjoblist[$k] = $db->lt_array_action($v);
				//对job_name 截取
				if(intval($paramer['t_len'])>0){
					$len = intval($paramer['t_len']);
					$ltjoblist[$k]['job_name'] = mb_substr($v['job_name'],0,$len,"utf-8");
				}
				if($v['usertype']==3){
                    $ltjoblist[$k]["lt_url"] = Url("lietou",array("c"=>"headhunter","uid"=>$v[uid]));
					$ltjoblist[$k]["job_url"] = Url("lietou",array("c"=>"jobshow","id"=>$v['id']));
					 $ltjoblist[$k]["wap_lt_url"] = Url("wap",array("c"=>"ltjob","a"=>"headhunter","uid"=>$v[uid]));
				}else{
                    $ltjoblist[$k]["lt_url"] = Url("company",array("c"=>"show","id"=>$v['uid']));
					$ltjoblist[$k]["job_url"] = Url("lietou",array("c"=>"jobcomshow","id"=>$v['id']));
					$ltjoblist[$k]["wap_lt_url"] = Url("wap",array("c"=>"company","a"=>"show","id"=>$v['uid']));
				}		
				if($v['minsalary']>0&&$v['maxsalary']>0){
					$ltjoblist[$k]["salary_info"] = floatval($v['minsalary'])."-".floatval($v['maxsalary'])."万";    
                }else if($v['minsalary']>0){
                    $ltjoblist[$k]["salary_info"] = floatval($v['minsalary'])."万";  
                }else{
    				$ltjoblist[$k]["salary_info"] = "面议";
    			}
                
				$ltjoblist[$k]["lastupdate"] = date("Y-m-d",$v["lastupdate"]);
				  if($v['usertype']==3){
              foreach($ltlist as $val){

                if($v['uid']==$val['uid']  && $v[usertype]==3){

                              if($val[hy]!=""){

                                 $hy="";

                                 $hyarr=@explode(",",$val[hy]);

                                  foreach($hyarr as $vall){

                                      $hy.=$lthy_name[$vall]." ";

                                  }

                                  $ltjoblist[$k][hy_n] = mb_substr($hy,0,$paramer[comlen],"utf-8");

                              }

                  $ltjoblist[$k]['logo_n'] = checkpic($val['photo_big'],$config['sy_lt_icon']);

                  }

              }
          }else{
              foreach($comlist as $val){

                if($v['uid']==$val['uid']&&$val['name']){

                    $ltjoblist[$k]["com_name"]=$val['name'];
                    $ltjoblist[$k]["hy_n"]=$industry_name[$val['hy']];
                    $ltjoblist[$k]['logo_n'] = checkpic($val['logo'],$config['sy_unit_icon']);

                  }

              }
          }
			}
		} 
		if($paramer['keyword']!=""&&!empty($ltjoblist)){
			addkeywords('7',$paramer['keyword']);
		}$ltjoblist = $ltjoblist; if (!is_array($ltjoblist) && !is_object($ltjoblist)) { settype($ltjoblist, 'array');}
foreach ($ltjoblist as $_smarty_tpl->tpl_vars['ltjoblist']->key => $_smarty_tpl->tpl_vars['ltjoblist']->value) {
$_smarty_tpl->tpl_vars['ltjoblist']->_loop = true;
?>
				<li>
					<i class="lt_index_job_box_ulline"></i>
					<div class="lt_index_job_name"><a href="<?php echo $_smarty_tpl->tpl_vars['ltjoblist']->value['job_url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['ltjoblist']->value['job_name'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['ltjoblist']->value['job_name'];?>
</a></div><div class="lt_index_job_yq"><span class="lt_index_job_xz"><?php echo $_smarty_tpl->tpl_vars['ltjoblist']->value['salary_info'];?>
</span><span class="lt_index_job_line"><?php if ($_smarty_tpl->tpl_vars['ltjoblist']->value['edu_info']) {?>|<?php }?></span><?php echo $_smarty_tpl->tpl_vars['ltjoblist']->value['edu_info'];?>
</div>
					<div class="lt_index_job_com">
						<div class="lt_index_job_comlogo"><img src="<?php echo $_smarty_tpl->tpl_vars['ltjoblist']->value['logo_n'];?>
" width="50" height="50"></div>
						<div class="lt_index_job_comname"><a href="<?php echo $_smarty_tpl->tpl_vars['ltjoblist']->value['lt_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['ltjoblist']->value['com_name'];?>
</a></div>
						<div class="lt_index_job_comhy"><?php echo $_smarty_tpl->tpl_vars['ltjoblist']->value['hy_n'];?>
/<?php echo $_smarty_tpl->tpl_vars['ltjoblist']->value['cityid_info'];?>
</div>
					</div>
				</li>
				<?php } ?>
			</ul>
		</div>
		<div class="lt_index_job_more">	<a href="<?php echo smarty_function_url(array('m'=>'lietou','c'=>'post'),$_smarty_tpl);?>
" class="lt_index_job_more_a">+ 查看更多</a></div>
	</div>
	
	<div class="lt_index_tit">
		<span class="lt_index_tit_s"> 委托求职</span>
		<div class="lt_index_tit_p">
			<span class="lt_index_tit_span"><i class="lt_index_tit_linel"></i><i class="lt_index_tit_liner"></i>找工作不随便，这里是野心与实力的汇聚</span>
		</div>
	</div>
	
	<div class="lt_index_job_box">
		<div class="lt_index_job_c">
			<ul class="lt_index_h">
				<?php  $_smarty_tpl->tpl_vars['ltlist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['ltlist']->_loop = false;
global $db,$db_config,$config;$paramer=array("ispage"=>"1","limit"=>"8","item"=>"'ltlist'","nocache"=>"")
;$ltlist=array();
		include PLUS_PATH."/ltjob.cache.php";
		include PLUS_PATH."/city.cache.php";
		include PLUS_PATH."/lthy.cache.php";
        include PLUS_PATH."/lt.cache.php";
		//处理传入参数，并且构造分页参数
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
		$Purl =  $ParamerArr[purl];
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }
		$where="`yyzz_status`='1' and `r_status`='1' and `com_name`<>''";
		//是否属于分站下
		if($config[sy_web_site]=="1"){
			if($config[province]>0 && $config[province]!=""){
				$paramer[provinceid] = $config[province];
			}
			if($config[cityid]>0 && $config[cityid]!=""){
				$paramer[cityid]=$config[cityid];
			}
			if($config[three_cityid]>0 && $config[three_cityid]!=""){
				$paramer[three_cityid] = $config[three_cityid];
			}
		}
		//关键字
		if($paramer["keyword"]){
			$where1[]="`realname` LIKE '%".$paramer[keyword]."%'";
			foreach($ltjob_name as $k=>$v){
				if(strpos($v,$paramer[keyword])!==false){
					$jobid[]=$k;
				}
			}
			if(is_array($jobid)){
				foreach($jobid as $value){
					$class[]="FIND_IN_SET('".$value."',job)";
				}
				$where1[]=@implode(" or ",$class);
			}
			foreach($lthy_name as $k=>$v){
				if(strpos($v,$paramer[keyword])!==false){
					$hyid[]=$k;
				}
			}
			if(is_array($hyid)){
				foreach($hyid as $value){
					$class[]="FIND_IN_SET('".$value."',hy)";
				}
				$where1[]=@implode(" or ",$class);
			}
			$where.=" AND (".@implode(" or ",$where1).")";
		}
		//认证ID
		if($paramer["rzid"]){
			$where.=" AND `rzid`='".$paramer["rzid"]."'";
		}
		//推荐
		if($paramer["rec"]){
			$where.=" AND `rec`='".$paramer["rec"]."'";
		}
		//擅长行业大类
		if($paramer["hyclass"]){
			$hyid=$lthy_type[$paramer["hyclass"]];
			foreach($hyid as $v){
				$hyarr[]= "FIND_IN_SET('".$v."',hy)";
			}
			$hyarr=@implode(" or ",$hyarr);
			$where.=" AND ($hyarr)";
		}
		//城市
		if($paramer["provinceid"]){
			$where.= " AND `provinceid`=$paramer[provinceid]";
		}
		if($paramer["cityid"]){
			$where.= " AND `cityid`=$paramer[cityid]";
		}
		if($paramer["three_cityid"]){
			$where.= " AND `three_cityid`=$paramer[three_cityid]";
		}
		//擅长行业子类
		if($paramer["hy"]){
			$where.= " AND FIND_IN_SET('".$paramer["hy"]."',hy)";
		}
		//擅长职位大类
		if($paramer["jobclass"]){
			$jobid=$ltjob_type[$paramer["jobclass"]];
			foreach($jobid as $v){
				$jobarr[]= "FIND_IN_SET('".$v."',job)";
			}
			$jobarr=@implode(" or ",$jobarr);
			$where.=" AND ($jobarr)";
		}
		//擅长职位子类
		if($paramer["job"]){
			$where.= " AND FIND_IN_SET('".$paramer["job"]."',job)";
		}
		//擅长行业
		if($paramer["hyid"]){
			$hyid=@explode(",",$paramer["hyid"]);
			foreach($hyid as $v){
				$hyall[].= "FIND_IN_SET('".$v."',hy)";
			}
			$where .= " and (".@implode(" or ",$hyall).")";
		}
		//擅长职位
		if($paramer["jobid"]){
			$jobid=@explode(",",$paramer["jobid"]);
			foreach($jobid as $v){
				$joball[].= "FIND_IN_SET('".$v."',job)";
			}
			$where .= " and (".@implode(" or ",$joball).")";
		}
		
		if($paramer[ispage]){
			$limit = PageNav($paramer,$_GET,"lt_info",$where,$Purl,"",$paramer[islt]?$paramer[islt]:"1",$_smarty_tpl);
		}
		//排序字段（默认按照uid排序）
		if($paramer[order]){
			if($paramer[order]=="rztime"){
				$where .= " ORDER BY rz_time ";
			}else{
				$where .= " ORDER BY $paramer[order] ";
			}
		}else{
			$where .= " ORDER BY `uid` ";
		}
		//排序规则（默认按照开始时间排序倒序）
		if($paramer["sort"]){
			$where .= " $paramer[sort]";
		}else{
			$where .= " DESC ";
		}
		$ltlist=$db->select_all("lt_info",$where.$limit);
		if($_COOKIE[usertype]==1){
			$atn=$db->select_all("atn","`uid`='".$_COOKIE[uid]."' and `sc_usertype`='3'");
		}
		if(is_array($ltlist)){
			foreach($ltlist as $k=>$v){
                $ltlist[$k][exp_info]=$ltclass_name[$v[exp]];
				$ltlist[$k][cityone_info]=$city_name[$v[provinceid]];
				$ltlist[$k][citytwo_info]=$city_name[$v[cityid]];
				if(is_array($ltlist)){
					foreach($atn as $val){
						if($v[uid]==$val[sc_uid]){
							$ltlist[$k][atn]=1;
						}
					}
				}
				$uid[]=$v[uid];
			}
			$ratings=$db->DB_query_all("select a.uid,b.com_pic from $db_config[def]lt_statis a left join $db_config[def]company_rating b on a.rating = b.id WHERE a.uid in (".@implode(",",$uid).")","all");
			$joblist=$db->select_all("lt_job","`status`='1' and `uid` in (".@implode(",",$uid).") and `r_status`='1' order by `lastupdate` desc");
			foreach($ltlist as $k=>$v){
				foreach($ratings as $val)
				{//猎头图标
					if($v[uid]==$val[uid]){
						$ltlist[$k]["com_pic"]=checkpic($val['com_pic']);
                    }
				}
				$i=0;$job="";
				foreach($joblist as $val)
				{//猎头最新职位
					if($v[uid]==$val[uid]){
						$job_url = Url("lietou",array("c"=>"jobshow","id"=>$val[id]));
						$job.="<a href='".$job_url."'>".$val[job_name]."</a> ";
						$i++;$val[job_url]=$job_url;
                        $ltlist[$k]["ltjoblist"][]=$val;
					}
				}
				$ltlist[$k]["jobnum"]=$i;
				$ltlist[$k]["joblist"]=$job;
				$jobsc="";
				if($v[job]!=""){//擅长职位
					$job=@explode(",",$v[job]);
					foreach($job as $val){
						$jobsc.=$ltjob_name[$val]." ";
					}
				}
				$ltlist[$k]["job"]=$jobsc;
				$hy="";
				if($v[hy]!=""){//擅长行业
					$hyarr=@explode(",",$v[hy]);
					foreach($hyarr as $val){
						$hy.=$lthy_name[$val]." ";
					}
				}
				$ltlist[$k]["hy"]=$hy;
				$ltlist[$k]["name_url"] = Url("lietou",array("c"=>"headhunter","uid"=>$v[uid]));//猎头链接
				if($v[photo_status]==0){
					$ltlist[$k]['photo_big'] = checkpic($v['photo_big'],$config['sy_lt_icon']);
				}else{
					$ltlist[$k]['photo_big'] = checkpic('',$config['sy_lt_icon']);
				}
			}
		}
		if($paramer[keyword]!=""&&!empty($ltlist))
		{
			addkeywords('6',$paramer[keyword]);
		}$ltlist = $ltlist; if (!is_array($ltlist) && !is_object($ltlist)) { settype($ltlist, 'array');}
foreach ($ltlist as $_smarty_tpl->tpl_vars['ltlist']->key => $_smarty_tpl->tpl_vars['ltlist']->value) {
$_smarty_tpl->tpl_vars['ltlist']->_loop = true;
?>
                <li>
					<div class="lt_photo"><img src="<?php echo $_smarty_tpl->tpl_vars['ltlist']->value['photo_big'];?>
" width="70" height="70"></div>
					<div class="lt_name"><a href="<?php echo $_smarty_tpl->tpl_vars['ltlist']->value['name_url'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['ltlist']->value['realname'];?>
</a></div>
					<div class="lt_city"><?php echo $_smarty_tpl->tpl_vars['ltlist']->value['cityone_info'];?>
-<?php echo $_smarty_tpl->tpl_vars['ltlist']->value['citytwo_info'];?>
</div>
					<div class="lt_index_h_sc"><?php echo mb_substr($_smarty_tpl->tpl_vars['ltlist']->value['hy'],0,16,'utf-8');?>
</div>
					<div class="lt_index_h_n">
					<div class="lt_index_p"><span class="lt_n"><?php echo count($_smarty_tpl->tpl_vars['ltlist']->value['ltjoblist']);?>
</span> 在招职位<i class="lt_index_pline"></i></div>
					<div class="lt_index_p"><span class="lt_n"><?php echo $_smarty_tpl->tpl_vars['ltlist']->value['ant_num'];?>
</span> 关注人数<i class="lt_index_pline"></i></div>
					<div class="lt_index_p"><span class="lt_n"><?php echo $_smarty_tpl->tpl_vars['ltlist']->value['exp_info'];?>
</span> 从业年限</div>
					</div>
					<div class="clear"></div>
					<div class="lt_index_p_wt_bot">
						<a <?php if ($_smarty_tpl->tpl_vars['uid']->value) {?>href="javascript:ltatn('<?php echo $_smarty_tpl->tpl_vars['ltlist']->value['uid'];?>
','3');"<?php } else { ?>href="javascript:void(0)" onclick="showlogin('1');"<?php }?> id="guanzhu<?php echo $_smarty_tpl->tpl_vars['ltlist']->value['uid'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['ltlist']->value['atn'];?>
" class="lt_gz_bth1"> 
						<?php if ($_smarty_tpl->tpl_vars['ltlist']->value['atn']=='1') {?>取消关注<?php } else { ?>+ 关注<?php }?>
						</a>
						<a href="<?php echo $_smarty_tpl->tpl_vars['ltlist']->value['name_url'];?>
" target="_blank" class="lt_index_p_wt">委托简历</a>   
					</div>
				</li>
				<?php } ?>
    		</ul>
		</div>
	</div>
	
	<div class="lt_index_job_more"><a  href="<?php echo smarty_function_url(array('m'=>'lietou','c'=>'service'),$_smarty_tpl);?>
" target="_blank"class="lt_index_job_more_a">+ 查看更多</a></div>
	
	<div class="lt_index_tit"><span class="lt_index_tit_s"> 友情链接</span></div>
	
	<div class="links_con_img fl">
    	<?php  $_smarty_tpl->tpl_vars['linklist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['linklist']->_loop = false;
global $config;
		//跨域名使用范围
		$domain='';
		if($config["cityid"]!="" || $config["hyclass"]!=""){
			include(PLUS_PATH."/domain_cache.php");
			$host_url=$_SERVER['HTTP_HOST'];
			foreach($site_domain as $v){
				if($v['host']==$host_url){
					$domain=$v['id'];
				}
			}
		}$tem_type = 2;
        include PLUS_PATH."/link.cache.php";
		if(is_array($link)){$linkList=array();
			$i=0;
			foreach($link as $key=>$value)
			{
				if($config["did"]!=0 && $value["did"]!=-1 && $config["did"]!=-1 && $config["did"]!=$value["did"])
				{
					continue;
				}elseif(is_numeric('2') && $value['tem_type']!='2' && $value['tem_type']!='1'){
					continue;

				}elseif((!is_numeric('2') || '2'=='1') && $value['tem_type']!='1'){

					continue;
				}elseif(!$config["did"] && $value["did"]>0){
					continue;
				}
				if(is_numeric('2') && $value['link_type']!='2')
				{
					continue;
				}
				if(is_numeric('') && intval('')<=$i)
				{
					break;
				}
				if($value['pic']&&$value['img_type']==1){
					$value[pic] = checkpic($value['pic']);
				}
				$linkList[] = $value;
				$i++;
			}
		}$linkList = $linkList; if (!is_array($linkList) && !is_object($linkList)) { settype($linkList, 'array');}
foreach ($linkList as $_smarty_tpl->tpl_vars['linklist']->key => $_smarty_tpl->tpl_vars['linklist']->value) {
$_smarty_tpl->tpl_vars['linklist']->_loop = true;
?>
        	<a href="<?php echo $_smarty_tpl->tpl_vars['linklist']->value['link_url'];?>
" target="_blank"><img class="png" src="<?php echo $_smarty_tpl->tpl_vars['linklist']->value['pic'];?>
" width="120" height="35" alt="<?php echo $_smarty_tpl->tpl_vars['linklist']->value['link_name'];?>
" /></a>
       	<?php } ?>
	</div>
	<div class="links_con fl">
		<?php  $_smarty_tpl->tpl_vars['linklist2'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['linklist2']->_loop = false;
global $config;
		//跨域名使用范围
		$domain='';
		if($config["cityid"]!="" || $config["hyclass"]!=""){
			include(PLUS_PATH."/domain_cache.php");
			$host_url=$_SERVER['HTTP_HOST'];
			foreach($site_domain as $v){
				if($v['host']==$host_url){
					$domain=$v['id'];
				}
			}
		}$tem_type = 3;
        include PLUS_PATH."/link.cache.php";
		if(is_array($link)){$linkList=array();
			$i=0;
			foreach($link as $key=>$value)
			{
				if($config["did"]!=0 && $value["did"]!=-1 && $config["did"]!=-1 && $config["did"]!=$value["did"])
				{
					continue;
				}elseif(is_numeric('3') && $value['tem_type']!='3' && $value['tem_type']!='1'){
					continue;

				}elseif((!is_numeric('3') || '3'=='1') && $value['tem_type']!='1'){

					continue;
				}elseif(!$config["did"] && $value["did"]>0){
					continue;
				}
				if(is_numeric('1') && $value['link_type']!='1')
				{
					continue;
				}
				if(is_numeric('') && intval('')<=$i)
				{
					break;
				}
				if($value['pic']&&$value['img_type']==1){
					$value[pic] = checkpic($value['pic']);
				}
				$linkList[] = $value;
				$i++;
			}
		}$linkList = $linkList; if (!is_array($linkList) && !is_object($linkList)) { settype($linkList, 'array');}
foreach ($linkList as $_smarty_tpl->tpl_vars['linklist2']->key => $_smarty_tpl->tpl_vars['linklist2']->value) {
$_smarty_tpl->tpl_vars['linklist2']->_loop = true;
?>
			<a href="<?php echo $_smarty_tpl->tpl_vars['linklist2']->value['link_url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['linklist2']->value['link_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['linklist2']->value['link_name'];?>
</a>
		<?php } ?>
	</div>
</div>
<!--[if IE 6]>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/png.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
  DD_belatedPNG.fix('.png,.New_post,.box_bot,.new_post_box_h1 span,.icon,.ser_cz a,.Strat-list ,.logoin_su2,.logoin_after_su2,.logoin_after em,.logoin_after_tx dt,.service_filter_fot,.Strat-list .s,.nav_exit span,.company_focus');
<?php echo '</script'; ?>
>
<![endif]-->
<?php echo '<script'; ?>
>var webname = "<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
";<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['lietou_style']->value;?>
/js/public_lt.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['lietou_style']->value;?>
/js/jquery.flexslider.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/javascript"><?php echo '</script'; ?>
> 
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/js/jcarousellite.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/javascript"><?php echo '</script'; ?>
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
>
	$(window).load(function() {
		$('.flexslider').flexslider({
			directionNav: true,
			pauseOnAction: false,
			animation:'slide'
		});
	});
	layui.use(['carousel'], function(){
	  	var carousel = layui.carousel;
	  	carousel.render({
	    	elem: '#test1'
	    	,width: '100%'
	    	,height: '400px'
	  	});
	});
	
	$(function(){ 
		$('.index_search_name_list li').delegate('a','click',function(){
			$(this).parent().parent().hide();
			$('#search_type_name').html($(this).html());
			$('#search_type').val($(this).attr('search_type'));
			var search_text_all='|输入职位关键词：如公司等|输入职位关键词：如职位等|输入职位关键词：如猎头等|';
			var search_text_list=search_text_all.split('|');
			var search_text_index=$(this).parent().index()+1;
			if(search_text_all.indexOf('|'+$('#search').val()+'|')>=0){
				$('#search').val(search_text_list[search_text_index]);
			}
			$('#search').attr('placeholder',search_text_list[search_text_index]);
		});
		$('.index_search_name').hover(function(){
			$(".index_search_name_list ").show();
		},function(){
			$(".index_search_name_list ").hide();
		});  
		$('.reward_items').hover(function(){
			$(this).addClass('reward_items_hover');
		},function(){
			$(this).removeClass('reward_items_hover');
		});  
	});

<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/public_search/login.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lietoustyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
