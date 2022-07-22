<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-06 16:37:47
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\wap\index.htm" */ ?>
<?php /*%%SmartyHeaderCode:559962c549db98f4b3-62565953%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e90ba5fb48fc08a6470b2831d24b4aafb59e498a' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\wap\\index.htm',
      1 => 1643012866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '559962c549db98f4b3-62565953',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'wap_style' => 0,
    'config' => 0,
    'uid' => 0,
    'expect' => 0,
    'tplmoblie' => 0,
    'username' => 0,
    'lunbo' => 0,
    'navlist' => 0,
    'key' => 0,
    'v' => 0,
    'annum' => 0,
    'alist' => 0,
    'xjh' => 0,
    'resume_yhnum' => 0,
    'hotjoblist' => 0,
    'newjob' => 0,
    'njk' => 0,
    'urgjob' => 0,
    'ujk' => 0,
    'recjob' => 0,
    'rjk' => 0,
    'kfurl' => 0,
    'isweixin' => 0,
    'bannerFlag' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c549dbab0a69_10262229',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c549dbab0a69_10262229')) {function content_62c549dbab0a69_10262229($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.url.php';
?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['wapstyle']->value)."/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<link href="<?php echo $_smarty_tpl->tpl_vars['wap_style']->value;?>
/js/swiper/swiper.min.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet"/>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['wap_style']->value;?>
/js/swiper/swiper.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
<div class="" id="app">
    
    <!-- 页面头部部分 -->

    <!--隐藏简历提示-->
    <?php if ($_smarty_tpl->tpl_vars['uid']->value&&$_smarty_tpl->tpl_vars['expect']->value['status']=='2') {?>
    <div id="privacyCtrl" class="hide_tip">
        <div class="resume_hint_eye_n">
            <img src="<?php echo $_smarty_tpl->tpl_vars['wap_style']->value;?>
/images/conceal_1.png" alt="" width="100%" height="100%">
        </div>
        <i class="resume_hint_word_color"> 简历已隐藏，</i>
       <i class="resume_hint_word_black"> 企业无法主动发现你</i>
        <a href="javascript:void(0);" onclick="privacy();" class="hide_tip_qx">取消隐藏</a>
        <i class="hide_tip_gb"></i>
    </div>
    <?php }?>

    <div class="clear"></div>

    <div class="yunTop">
        <div class="yunlogobox">
            <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['logo']==2) {?>
                <div class="header_p_z"> <?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
</div>
            <?php } else { ?>
                <img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_wap_logo'];?>
" alt=" " title=" " class="yunlogo">
            <?php }?>
			<!--
            <?php if (!$_smarty_tpl->tpl_vars['username']->value&&$_GET['c']=='') {?>
                <a href="<?php echo smarty_function_url(array('m'=>'wap','c'=>'login'),$_smarty_tpl);?>
" class="yunTopUp_right"> 发布简历</a>
            <?php } else { ?>
                <a href="<?php echo smarty_function_url(array('m'=>'wap'),$_smarty_tpl);?>
member" id="memberclick" class="yunTopUp_right">用户中心</a>
            <?php }?>-->
        </div>

        <div class="index_newedition_search_box">
            <div class="index_newedition_searchbg">
                <div class="index_newedition_search_c">

                    <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_web_site']=='1') {?>
                    <a href="<?php echo smarty_function_url(array('m'=>'wap','c'=>'site'),$_smarty_tpl);?>
" class="index_newedition_search_city"><?php if ($_smarty_tpl->tpl_vars['config']->value['cityname']) {
echo $_smarty_tpl->tpl_vars['config']->value['cityname'];
} else {
echo $_smarty_tpl->tpl_vars['config']->value['sy_indexcity'];
}?></a>
                    <?php }?>

                    <span class="index_newedition_search_p searchnew" style="<?php if ($_smarty_tpl->tpl_vars['config']->value['sy_web_site']=='1') {?>width:75%<?php } else { ?>width:95%<?php }?>">搜职位/公司</span>
                    <span class="index_newedition_searchbth"> </span>
                </div>
            </div>
        </div>
    </div>

    <div class="clear"></div>

    <!-- 页面主体部分 -->
    <div class="index_body">
        <!-- 轮播图部分 -->
        <div class="banner">
            <!-- 轮播图 -->
            <div class="roll">
                <div class="swiper-container" id="imgswiper" style="transform:translate3d(0,0,0);overflow:hidden;">
                    <div class="swiper-wrapper" >
                        <?php  $_smarty_tpl->tpl_vars["lunbo"] = new Smarty_Variable; $_smarty_tpl->tpl_vars["lunbo"]->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
global $db,$db_config,$config;$AdArr=array();$paramer=array();$attr=array("classid"=>"50","item"=>"\"lunbo\"","key"=>"'key'","nocache"=>"")
;
			include(PLUS_PATH.'pimg_cache.php');$add_arr = $ad_label[50];if(is_array($add_arr) && !empty($add_arr)){
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
                        <div class="swiper-slide" style="transform:translate3d(0,0,0);">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['lunbo']->value['src'];?>
">
                                <img src="<?php echo $_smarty_tpl->tpl_vars['lunbo']->value['pic'];?>
" width='100%' height="120" style="border-radius: 6px;"/>
                            </a>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="job">
                <!--金刚位 -->
                <div class="swiper-container navbox_jgw" id="navswiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['navlist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                            <?php if ($_smarty_tpl->tpl_vars['key']->value>0&&$_smarty_tpl->tpl_vars['key']->value%4==0) {?>
                        </div>
                        <div class="swiper-slide">
                            <?php }?>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['v']->value['url_n'];?>
">
                                <div class="full-time">
                                    <div class="full-time-logo">
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['v']->value['pic_n'];?>
" alt="" style="width: 100%;">
                                    </div>
                                    <div class="full-time-word"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</div>
                                </div>
                            </a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="swiper-pagination navbox_fyq"></div>
                </div>
            </div>
            <?php if ($_smarty_tpl->tpl_vars['annum']->value) {?>
            <div class="inform">
                <div class="inform-trumpet">
                    <a href="<?php echo smarty_function_url(array('m'=>'wap','c'=>'announcement'),$_smarty_tpl);?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['wap_style']->value;?>
/images/home_icon_notice.png" alt="" style="width: 100%;"></a>
                </div>
                <div class="swiper-container " id="ggswiper" style="margin-top:0.08rem">
                    <div class="swiper-wrapper">
                        <?php  $_smarty_tpl->tpl_vars['alist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['alist']->_loop = false;
$alist=array();$time=time();$paramer=array("limit"=>"10","item"=>"'alist'","t_len"=>"40","nocache"=>"")
;
		global $db,$db_config,$config;
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
		$Purl =  $ParamerArr[purl];
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }
		$where = 1;
		//分站
		if($config['did']){
			$where.=" and (`did`='".$config['did']."' or `did`=-1)";
		}else{
			$where.=" and (`did`=-1 OR `did`=0 OR did='')";
		}
        $where.=" and (`startime`<=".time()." or `startime`=0 or `startime` is null)";
        $where.=" and (`endtime`>".time()." or `endtime`=0 or `endtime` is null)";
		if($paramer[limit]){
			$limit=" LIMIT ".$paramer[limit];
		}else{
			$limit=" LIMIT 20";
		}
		if($paramer[ispage]){
			$limit = PageNav($paramer,$_GET,"admin_announcement",$where,$Purl,"",0,$_smarty_tpl);
		}
		//排序字段 默认按照xuanshang排序
		if($paramer[order]){
			$where.="  ORDER BY `".$paramer[order]."`";
		}else{
			$where.="  ORDER BY `startime`";
		}
		//排序方式默认倒序
		if($paramer[sort]){
			$where.=" ".$paramer[sort];
		}else{
			$where.=" DESC";
		}

		$alist=$db->select_all("admin_announcement",$where.$limit);
		if(is_array($alist)){
			foreach($alist as $key=>$value){
				//截取标题
				if($paramer[t_len]){
					$alist[$key][title_n] = mb_substr($value['title'],0,$paramer[t_len],"utf-8");
				}
				$alist[$key][time]=date("Y-m-d",$value[startime]);
				$alist[$key][url] = Url("announcement",array("id"=>$value[id]),"1");
			}
		}$alist = $alist; if (!is_array($alist) && !is_object($alist)) { settype($alist, 'array');}
foreach ($alist as $_smarty_tpl->tpl_vars['alist']->key => $_smarty_tpl->tpl_vars['alist']->value) {
$_smarty_tpl->tpl_vars['alist']->_loop = true;
?>
                        <div class="swiper-slide">
                            <a href="<?php echo smarty_function_url(array('m'=>'wap','c'=>'announcement','id'=>$_smarty_tpl->tpl_vars['alist']->value['id']),$_smarty_tpl);?>
" style="color:#666;height:0.64rem;"><i class="inform-word conceal_word" ><?php echo $_smarty_tpl->tpl_vars['alist']->value['title_n'];?>
</i></a>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php }?>
        </div>

        <!-- 直播招聘部分-->
        <?php if ($_smarty_tpl->tpl_vars['xjh']->value) {?>
        <div class="recruit">
            <i class="hint">直播招聘</i>
            <div class="prompt-content">
                <div class="img">
                    <img src="<?php echo $_smarty_tpl->tpl_vars['xjh']->value['pic'];?>
" alt="" style="width: 100%; height: 100%; border-radius:.16rem;">
                </div>
                <div class="words" onclick="location.href='<?php echo smarty_function_url(array('m'=>'wap','c'=>'xjhlive','a'=>'show','id'=>$_smarty_tpl->tpl_vars['xjh']->value['id']),$_smarty_tpl);?>
'">
                    <div class="wordage"><?php echo mb_substr($_smarty_tpl->tpl_vars['xjh']->value['name'],0,26,'utf-8');?>
</div>
                   <div class="home_live_box">
                    <span class="remind">直播时间 <?php echo $_smarty_tpl->tpl_vars['xjh']->value['stime_n'];?>
</span>
                    <button class="btn" >直播详情</button>
                   </div>
                </div>
            </div>
        </div>
        <?php }?>

        <!-- 简历优化提示 -->
        <?php if ($_smarty_tpl->tpl_vars['resume_yhnum']->value>0) {?>
        <div id="resume_yh" class="optimize_tip_box none">
            <div class="optimize_tip">
                <i class="optimize_tipicon"></i>
                <i class="optimize_tipgbicon" onclick="resume_yhhide();"></i>
                <div class="optimize_name">您的简历有<?php echo $_smarty_tpl->tpl_vars['resume_yhnum']->value;?>
个优化项</div>
                <div class="optimize_p">处理后可大幅提升求职成功率</div>
                <a class="optimize_tip_bth" href="<?php echo smarty_function_url(array('m'=>'wap'),$_smarty_tpl);?>
member/index.php?c=resume&eid=<?php echo $_smarty_tpl->tpl_vars['expect']->value['id'];?>
">去处理</a>
            </div>
        </div>
        <?php }?>
          <!-- 登陆注册 -->
		  <?php if (!$_smarty_tpl->tpl_vars['username']->value&&$_GET['c']=='') {?>
		   <div class="indexlogin_bth">
			   
			   <div class="indexlogin_bth_c">
		   <div class="indexlogin_list">
			     <a href="<?php echo smarty_function_url(array('m'=>'wap','c'=>'login'),$_smarty_tpl);?>
"  class="indexlogin_listc indexlogin_listcr">
			   <i class="indexlogin_icon"></i>
			   <div class="indexlogin_name">发布简历	  </div>
			   <div class="indexlogin_p">找喜欢的工作	  </div>
		  </a>
		  </div>
		     <div class="indexlogin_list">
				    <a href="<?php echo smarty_function_url(array('m'=>'wap','c'=>'login'),$_smarty_tpl);?>
" class="indexlogin_listc indexlogin_listcl">
				   <i class="indexlogin_icon indexlogin_icon2"></i>
		  <div class="indexlogin_name">发布职位	  </div>
		  <div class="indexlogin_p">招优秀人才	  </div>  </a> </div>
		 
		   </div>
		   </div>

              
            <?php } else { ?>
             
            <?php }?>
        <!-- 名企招聘 -->
        <div class="new_mq">
            <i class="new_mq_name">名企招聘</i>
            <a class="new_mq_more" href="<?php echo smarty_function_url(array('m'=>'wap','c'=>'company','rec'=>1),$_smarty_tpl);?>
">更多 ></a>
            <div class="">
                <div id="hotjob" class="swiper-container">
                    <div class="swiper-wrapper">
                        <?php  $_smarty_tpl->tpl_vars['hotjoblist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['hotjoblist']->_loop = false;
global $db,$db_config,$config;$paramer=array("item"=>"'hotjoblist'","limit"=>"10","nocache"=>"")
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
                        <div class="swiper-slide">
                            <div class="new_mq_box">
                                <a href="<?php echo smarty_function_url(array('m'=>'wap','c'=>'company','a'=>'show','id'=>$_smarty_tpl->tpl_vars['hotjoblist']->value['uid']),$_smarty_tpl);?>
">
                                    <div class="new_mq_list">
                                        <div class="new_mq_c">
                                            <div class="new_mq_logo">
                                                <img src="<?php echo $_smarty_tpl->tpl_vars['hotjoblist']->value['hot_pic'];?>
" alt="" style="width: 100%;">
                                            </div>
                                            <div class="new_mq_comname">
                                                <?php echo mb_substr($_smarty_tpl->tpl_vars['hotjoblist']->value['username'],0,12,'utf-8');?>

                                            </div>
                                        </div>
                                        <div class="new_mq_bth">
                                            <?php echo $_smarty_tpl->tpl_vars['hotjoblist']->value['num'];?>
个岗位
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- 广告 随机取一条 -->
        <?php  $_smarty_tpl->tpl_vars["lunbo"] = new Smarty_Variable; $_smarty_tpl->tpl_vars["lunbo"]->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
global $db,$db_config,$config;$AdArr=array();$paramer=array();$attr=array("classid"=>"503","item"=>"\"lunbo\"","key"=>"'key'","random"=>"1","nocache"=>"")
;
			include(PLUS_PATH.'pimg_cache.php');$add_arr = $ad_label[503];if(is_array($add_arr) && !empty($add_arr)){
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
        <div class="zd_banner"><?php echo $_smarty_tpl->tpl_vars['lunbo']->value['html'];?>
</div>
        <?php } ?>
        <!-- tab栏切换部分 -->
        <div id="yunvue" class="tab none">
            <van-tabs color="#2778F8" @click="chooseTab">
                <van-tab title="最新">
                    <?php  $_smarty_tpl->tpl_vars['newjob'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['newjob']->_loop = false;
 $_smarty_tpl->tpl_vars['njk'] = new Smarty_Variable;
global $db,$db_config,$config;
		$time = time();
		
		
		//可以做缓存
        $paramer=array("limit"=>"15","key"=>"'njk'","item"=>"'newjob'","nocache"=>"")
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
		
		$newjob = $db->select_all("company_job",$where.$limit);

		if(is_array($newjob) && !empty($newjob)){
			//处理类别字段
			$cache_array = $db->cacheget();
			$comuid=$jobid=array();
			foreach($newjob as $key=>$value){
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
			foreach($newjob as $key=>$value){

				if($paramer[bid]){
					$noids[] = $value[id];
				}
				//筛除重复
				if($paramer[noids]==1 && !empty($noids) && in_array($value['id'],$noids)){
					unset($newjob[$key]);
					continue;
				}else{
					$newjob[$key] = $db->array_action($value,$cache_array);
					$newjob[$key][stime] = date("Y-m-d",$value[sdate]);
					$newjob[$key][etime] = date("Y-m-d",$value[edate]);
					if($arr_data['sex'][$value['sex']]){
						$newjob[$key][sex_n]=$arr_data['sex'][$value['sex']];
					}
					$newjob[$key][lastupdate] =lastupdateStyle($value[lastupdate]);
					if($value[minsalary]&&$value[maxsalary]){
						if($config['resume_salarytype']==1){
								$newjob[$key][job_salary] =$value[minsalary]."-".$value[maxsalary];
						}else{
							if($value[maxsalary]<1000){
								if($config['resume_salarytype']==2){
									$newjob[$key][job_salary] = "1千以下";
								}elseif($config['resume_salarytype']==3){
								$newjob[$key][job_salary] = "1K以下";
								}elseif($config['resume_salarytype']==4){
								$newjob[$key][job_salary] = "1k以下";
								}
							}else if($value[minsalary]<1000){
								$newjob[$key][job_salary] =changeSalary($value[maxsalary]);
							}else{
								$newjob[$key][job_salary] =changeSalary($value[minsalary])."-".changeSalary($value[maxsalary]);
							}
						}
					}elseif($value[minsalary]){
						if($config['resume_salarytype']==1){
						    $newjob[$key][job_salary] =$value[minsalary]."以上";
						}else{
							$newjob[$key][job_salary] =changeSalary($value[minsalary])."以上";
						}
					}else{
						$newjob[$key][job_salary] ="面议";
					}
					
					if($r_uid[$value['uid']][shortname]){
						$newjob[$key][com_name] =$r_uid[$value['uid']][shortname];
					}
					if(!empty($value[zp_minage]) && !empty($value[zp_maxage])){					   
					    if($value[zp_minage]==$value[zp_maxage]){
					        $newjob[$key][job_age] = $value[zp_minage]."周岁以上";
					    }else{
					        $newjob[$key][job_age] = $value[zp_minage]."-".$value[zp_maxage]."周岁";
					    }
					}else if(!empty($value[zp_minage]) && empty($value[zp_maxage])){
					    $newjob[$key][job_age] = $value[zp_minage]."周岁以上";
					}else{
					     $newjob[$key][job_age] = 0;
					}
					if($value[zp_num]==0){
					    $newjob[$key][job_number] = "";
					}else{
					    $newjob[$key][job_number] = $value[zp_num]." 人";
					}			
					$newjob[$key][yyzz_status] =$r_uid[$value['uid']][yyzz_status];
					$newjob[$key][logo] =$r_uid[$value['uid']][logo];
					$newjob[$key][pr_n] =$r_uid[$value['uid']][pr_n];
					$newjob[$key][hy_n] =$r_uid[$value['uid']][hy_n];
					$newjob[$key][mun_n] =$r_uid[$value['uid']][mun_n];
					$newjob[$key][hotlogo] =$r_uid[$value['uid']][hotlogo];
					$time=$value['lastupdate'];
					//今天开始时间戳
					$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
					//昨天开始时间戳
					$beginYesterday=mktime(0,0,0,date('m'),date('d')-1,date('Y'));
					
					if($time>$beginYesterday && $time<$beginToday){
						$newjob[$key]['time'] ="昨天";
					}elseif($time>$beginToday){	
						$newjob[$key]['time'] = $newjob[$key]['lastupdate'];
						$newjob[$key]['redtime'] =1;
					}else{
						$newjob[$key]['time'] = date("Y-m-d",$value['lastupdate']);
					}
    
                     // 前天
    				$beforeYesterday=mktime(0,0,0,date('m'),date('d')-2,date('Y'));

					if($value['sdate']>$beforeYesterday){
						$newjob[$key]['newtime'] =1;
					}
					//获得福利待遇名称
					if($value[welfare]){
					    $value[welfare] = str_replace(' ', '',$value[welfare]);
						$welfareList = @explode(',',trim($value[welfare]));

						if(!empty($welfareList)){
							$newjob[$key][welfarename] =array_filter($welfareList);
						}
					}
					//截取公司名称
					if($paramer[comlen]){
						if($r_uid[$value['uid']][shortname]){
							$newjob[$key][com_n] = mb_substr($r_uid[$value['uid']][shortname],0,$paramer[comlen],"utf-8");
						}else{
							$newjob[$key][com_n] = mb_substr($value['com_name'],0,$paramer[comlen],"utf-8");
						}
					}
					//截取职位名称
					if($paramer[namelen]){
						if($value['rec_time']>time()){
							$newjob[$key][name_n] = "<font color='red'>".mb_substr($value['name'],0,$paramer[namelen],"utf-8")."</font>";
						}else{
							$newjob[$key][name_n] = mb_substr($value['name'],0,$paramer[namelen],"utf-8");
						}
					}else{
						if($value['rec_time']>time()){
							$newjob[$key]['name_n'] = "<font color='red'>".$value['name']."</font>";
						}else{
							$newjob[$key][name_n] = $value['name'];
						}
					}
					//构建职位伪静态URL
					$newjob[$key][job_url] = Url("job",array("c"=>"comapply","id"=>$value[id]),"1");
					//构建企业伪静态URL
					$newjob[$key][com_url] = Url("company",array("c"=>"show","id"=>$value[uid]));
					
					foreach($comrat as $k=>$v){
						if($value[rating]==$v[id]){
							$newjob[$key][color] = str_replace("#","",$v[com_color]);
							if($v[com_pic]){
								$newjob[$key][ratlogo] = checkpic($v[com_pic]);
							}
							$newjob[$key][ratname] = $v[name];
						}
					}
					if($paramer[keyword]){
						$newjob[$key][name]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$value[name]);
						$newjob[$key][name_n]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$newjob[$key][name_n]);
						$newjob[$key][com_n]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$newjob[$key][com_n]);
						$newjob[$key][job_city_one]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$city_name[$value[provinceid]]);
						$newjob[$key][job_city_two]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$city_name[$value[cityid]]);
					}
				}
			}
			if(is_array($newjob)){
				if($paramer[keyword]!=""&&!empty($newjob)){
					addkeywords('3',$paramer[keyword]);
				}
			}
		}$newjob = $newjob; if (!is_array($newjob) && !is_object($newjob)) { settype($newjob, 'array');}
foreach ($newjob as $_smarty_tpl->tpl_vars['newjob']->key => $_smarty_tpl->tpl_vars['newjob']->value) {
$_smarty_tpl->tpl_vars['newjob']->_loop = true;
 $_smarty_tpl->tpl_vars['njk']->value = $_smarty_tpl->tpl_vars['newjob']->key;
?>
                    <a href="<?php echo smarty_function_url(array('m'=>'wap','c'=>'job','a'=>'comapply','id'=>$_smarty_tpl->tpl_vars['newjob']->value['id']),$_smarty_tpl);?>
" title="<?php echo $_smarty_tpl->tpl_vars['newjob']->value['name'];?>
">

                        <div class="table-card" style="<?php if ($_smarty_tpl->tpl_vars['njk']->value==0) {?>margin-top: .3rem;<?php }?>">
                            <div class="card_post">
                                <i class="table-card-word"><?php echo $_smarty_tpl->tpl_vars['newjob']->value['name'];?>
</i>
                                <i class="table-card-salary"><?php echo $_smarty_tpl->tpl_vars['newjob']->value['job_salary'];?>
</i>
                            </div>
                            <div class="table-card-require">
                                <i class="requir-area"><?php echo $_smarty_tpl->tpl_vars['newjob']->value['job_city_one'];?>
-<?php echo $_smarty_tpl->tpl_vars['newjob']->value['job_city_two'];?>
</i>
                                <i class="requir_area_parting_line"></i>
                                <?php if ($_smarty_tpl->tpl_vars['newjob']->value['job_edu']) {?><i class="requir-area"><?php echo $_smarty_tpl->tpl_vars['newjob']->value['job_edu'];?>
学历</i><?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['newjob']->value['job_exp']) {?> <i class="requir_area_parting_line"></i><i class="requir-area"><?php echo $_smarty_tpl->tpl_vars['newjob']->value['job_exp'];?>
经验</i><?php }?>
                            </div>
                            <?php if ($_smarty_tpl->tpl_vars['newjob']->value['welfarename']) {?>
                            <div class="welfare">
                                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['newjob']->value['welfarename']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                                <span class="welfare_n"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</span>
                                <?php } ?>
                            </div>
                            <?php }?>
                            <div class="index_company">
                                <i class="index_company-logo">
                                    <img src="<?php echo $_smarty_tpl->tpl_vars['newjob']->value['logo'];?>
" alt="" style="width: 100%;">
                                </i>
                                <i class="index_company-name"><?php echo mb_substr(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['newjob']->value['com_name']),0,20,"utf-8");?>
</i>
                                <i class="index_company-status"><?php echo $_smarty_tpl->tpl_vars['newjob']->value['time'];?>
</i>
                            </div>
                        </div>
                    </a>
                    <?php } ?>
                </van-tab>

                <van-tab title="紧急">
                    <?php  $_smarty_tpl->tpl_vars['urgjob'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['urgjob']->_loop = false;
 $_smarty_tpl->tpl_vars['ujk'] = new Smarty_Variable;
global $db,$db_config,$config;
		$time = time();
		
		
		//可以做缓存
        $paramer=array("limit"=>"15","key"=>"'ujk'","item"=>"'urgjob'","urgent"=>"1","nocache"=>"")
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
		
		$urgjob = $db->select_all("company_job",$where.$limit);

		if(is_array($urgjob) && !empty($urgjob)){
			//处理类别字段
			$cache_array = $db->cacheget();
			$comuid=$jobid=array();
			foreach($urgjob as $key=>$value){
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
			foreach($urgjob as $key=>$value){

				if($paramer[bid]){
					$noids[] = $value[id];
				}
				//筛除重复
				if($paramer[noids]==1 && !empty($noids) && in_array($value['id'],$noids)){
					unset($urgjob[$key]);
					continue;
				}else{
					$urgjob[$key] = $db->array_action($value,$cache_array);
					$urgjob[$key][stime] = date("Y-m-d",$value[sdate]);
					$urgjob[$key][etime] = date("Y-m-d",$value[edate]);
					if($arr_data['sex'][$value['sex']]){
						$urgjob[$key][sex_n]=$arr_data['sex'][$value['sex']];
					}
					$urgjob[$key][lastupdate] =lastupdateStyle($value[lastupdate]);
					if($value[minsalary]&&$value[maxsalary]){
						if($config['resume_salarytype']==1){
								$urgjob[$key][job_salary] =$value[minsalary]."-".$value[maxsalary];
						}else{
							if($value[maxsalary]<1000){
								if($config['resume_salarytype']==2){
									$urgjob[$key][job_salary] = "1千以下";
								}elseif($config['resume_salarytype']==3){
								$urgjob[$key][job_salary] = "1K以下";
								}elseif($config['resume_salarytype']==4){
								$urgjob[$key][job_salary] = "1k以下";
								}
							}else if($value[minsalary]<1000){
								$urgjob[$key][job_salary] =changeSalary($value[maxsalary]);
							}else{
								$urgjob[$key][job_salary] =changeSalary($value[minsalary])."-".changeSalary($value[maxsalary]);
							}
						}
					}elseif($value[minsalary]){
						if($config['resume_salarytype']==1){
						    $urgjob[$key][job_salary] =$value[minsalary]."以上";
						}else{
							$urgjob[$key][job_salary] =changeSalary($value[minsalary])."以上";
						}
					}else{
						$urgjob[$key][job_salary] ="面议";
					}
					
					if($r_uid[$value['uid']][shortname]){
						$urgjob[$key][com_name] =$r_uid[$value['uid']][shortname];
					}
					if(!empty($value[zp_minage]) && !empty($value[zp_maxage])){					   
					    if($value[zp_minage]==$value[zp_maxage]){
					        $urgjob[$key][job_age] = $value[zp_minage]."周岁以上";
					    }else{
					        $urgjob[$key][job_age] = $value[zp_minage]."-".$value[zp_maxage]."周岁";
					    }
					}else if(!empty($value[zp_minage]) && empty($value[zp_maxage])){
					    $urgjob[$key][job_age] = $value[zp_minage]."周岁以上";
					}else{
					     $urgjob[$key][job_age] = 0;
					}
					if($value[zp_num]==0){
					    $urgjob[$key][job_number] = "";
					}else{
					    $urgjob[$key][job_number] = $value[zp_num]." 人";
					}			
					$urgjob[$key][yyzz_status] =$r_uid[$value['uid']][yyzz_status];
					$urgjob[$key][logo] =$r_uid[$value['uid']][logo];
					$urgjob[$key][pr_n] =$r_uid[$value['uid']][pr_n];
					$urgjob[$key][hy_n] =$r_uid[$value['uid']][hy_n];
					$urgjob[$key][mun_n] =$r_uid[$value['uid']][mun_n];
					$urgjob[$key][hotlogo] =$r_uid[$value['uid']][hotlogo];
					$time=$value['lastupdate'];
					//今天开始时间戳
					$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
					//昨天开始时间戳
					$beginYesterday=mktime(0,0,0,date('m'),date('d')-1,date('Y'));
					
					if($time>$beginYesterday && $time<$beginToday){
						$urgjob[$key]['time'] ="昨天";
					}elseif($time>$beginToday){	
						$urgjob[$key]['time'] = $urgjob[$key]['lastupdate'];
						$urgjob[$key]['redtime'] =1;
					}else{
						$urgjob[$key]['time'] = date("Y-m-d",$value['lastupdate']);
					}
    
                     // 前天
    				$beforeYesterday=mktime(0,0,0,date('m'),date('d')-2,date('Y'));

					if($value['sdate']>$beforeYesterday){
						$urgjob[$key]['newtime'] =1;
					}
					//获得福利待遇名称
					if($value[welfare]){
					    $value[welfare] = str_replace(' ', '',$value[welfare]);
						$welfareList = @explode(',',trim($value[welfare]));

						if(!empty($welfareList)){
							$urgjob[$key][welfarename] =array_filter($welfareList);
						}
					}
					//截取公司名称
					if($paramer[comlen]){
						if($r_uid[$value['uid']][shortname]){
							$urgjob[$key][com_n] = mb_substr($r_uid[$value['uid']][shortname],0,$paramer[comlen],"utf-8");
						}else{
							$urgjob[$key][com_n] = mb_substr($value['com_name'],0,$paramer[comlen],"utf-8");
						}
					}
					//截取职位名称
					if($paramer[namelen]){
						if($value['rec_time']>time()){
							$urgjob[$key][name_n] = "<font color='red'>".mb_substr($value['name'],0,$paramer[namelen],"utf-8")."</font>";
						}else{
							$urgjob[$key][name_n] = mb_substr($value['name'],0,$paramer[namelen],"utf-8");
						}
					}else{
						if($value['rec_time']>time()){
							$urgjob[$key]['name_n'] = "<font color='red'>".$value['name']."</font>";
						}else{
							$urgjob[$key][name_n] = $value['name'];
						}
					}
					//构建职位伪静态URL
					$urgjob[$key][job_url] = Url("job",array("c"=>"comapply","id"=>$value[id]),"1");
					//构建企业伪静态URL
					$urgjob[$key][com_url] = Url("company",array("c"=>"show","id"=>$value[uid]));
					
					foreach($comrat as $k=>$v){
						if($value[rating]==$v[id]){
							$urgjob[$key][color] = str_replace("#","",$v[com_color]);
							if($v[com_pic]){
								$urgjob[$key][ratlogo] = checkpic($v[com_pic]);
							}
							$urgjob[$key][ratname] = $v[name];
						}
					}
					if($paramer[keyword]){
						$urgjob[$key][name]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$value[name]);
						$urgjob[$key][name_n]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$urgjob[$key][name_n]);
						$urgjob[$key][com_n]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$urgjob[$key][com_n]);
						$urgjob[$key][job_city_one]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$city_name[$value[provinceid]]);
						$urgjob[$key][job_city_two]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$city_name[$value[cityid]]);
					}
				}
			}
			if(is_array($urgjob)){
				if($paramer[keyword]!=""&&!empty($urgjob)){
					addkeywords('3',$paramer[keyword]);
				}
			}
		}$urgjob = $urgjob; if (!is_array($urgjob) && !is_object($urgjob)) { settype($urgjob, 'array');}
foreach ($urgjob as $_smarty_tpl->tpl_vars['urgjob']->key => $_smarty_tpl->tpl_vars['urgjob']->value) {
$_smarty_tpl->tpl_vars['urgjob']->_loop = true;
 $_smarty_tpl->tpl_vars['ujk']->value = $_smarty_tpl->tpl_vars['urgjob']->key;
?>
                    <a href="<?php echo smarty_function_url(array('m'=>'wap','c'=>'job','a'=>'comapply','id'=>$_smarty_tpl->tpl_vars['urgjob']->value['id']),$_smarty_tpl);?>
" title="<?php echo $_smarty_tpl->tpl_vars['urgjob']->value['name'];?>
">

                        <div class="table-card" style="<?php if ($_smarty_tpl->tpl_vars['ujk']->value==0) {?>margin-top: .3rem;<?php }?>">
                            <div class="card_post">
                                <i class="table-card-word"><?php echo $_smarty_tpl->tpl_vars['urgjob']->value['name'];?>
</i>
                                <i class="table-card-salary"><?php echo $_smarty_tpl->tpl_vars['urgjob']->value['job_salary'];?>
</i>
                            </div>
                            <div class="table-card-require">
                                <i class="requir-area"><?php echo $_smarty_tpl->tpl_vars['urgjob']->value['job_city_one'];?>
-<?php echo $_smarty_tpl->tpl_vars['urgjob']->value['job_city_two'];?>
</i>
                                <i class="requir_area_parting_line"></i>
                                <?php if ($_smarty_tpl->tpl_vars['urgjob']->value['job_edu']) {?><i class="requir-area"><?php echo $_smarty_tpl->tpl_vars['urgjob']->value['job_edu'];?>
学历</i><?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['urgjob']->value['job_exp']) {?>  <i class="requir_area_parting_line"></i><i class="requir-area"><?php echo $_smarty_tpl->tpl_vars['urgjob']->value['job_exp'];?>
经验</i><?php }?>
                            </div>
                            <?php if ($_smarty_tpl->tpl_vars['urgjob']->value['welfarename']) {?>
                            <div class="welfare">
                                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['urgjob']->value['welfarename']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                                <span class="welfare_n"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</span>
                                <?php } ?>
                            </div>
                            <?php }?>
                            <div class="index_company">
                                <i class="index_company-logo">
                                    <img src="<?php echo $_smarty_tpl->tpl_vars['urgjob']->value['logo'];?>
" alt="" style="width: 100%;">
                                </i>
                                <i class="index_company-name"><?php echo mb_substr(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['urgjob']->value['com_name']),0,20,"utf-8");?>
</i>
                                <i class="index_company-status">
                                    <?php echo $_smarty_tpl->tpl_vars['urgjob']->value['time'];?>

                                </i>
                            </div>
                        </div>
                    </a>
                    <?php } ?>
                </van-tab>

                <van-tab title="推荐">
                    <?php  $_smarty_tpl->tpl_vars['recjob'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['recjob']->_loop = false;
 $_smarty_tpl->tpl_vars['rjk'] = new Smarty_Variable;
global $db,$db_config,$config;
		$time = time();
		
		
		//可以做缓存
        $paramer=array("limit"=>"15","key"=>"'rjk'","item"=>"'recjob'","rec"=>"1","nocache"=>"")
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
		
		$recjob = $db->select_all("company_job",$where.$limit);

		if(is_array($recjob) && !empty($recjob)){
			//处理类别字段
			$cache_array = $db->cacheget();
			$comuid=$jobid=array();
			foreach($recjob as $key=>$value){
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
			foreach($recjob as $key=>$value){

				if($paramer[bid]){
					$noids[] = $value[id];
				}
				//筛除重复
				if($paramer[noids]==1 && !empty($noids) && in_array($value['id'],$noids)){
					unset($recjob[$key]);
					continue;
				}else{
					$recjob[$key] = $db->array_action($value,$cache_array);
					$recjob[$key][stime] = date("Y-m-d",$value[sdate]);
					$recjob[$key][etime] = date("Y-m-d",$value[edate]);
					if($arr_data['sex'][$value['sex']]){
						$recjob[$key][sex_n]=$arr_data['sex'][$value['sex']];
					}
					$recjob[$key][lastupdate] =lastupdateStyle($value[lastupdate]);
					if($value[minsalary]&&$value[maxsalary]){
						if($config['resume_salarytype']==1){
								$recjob[$key][job_salary] =$value[minsalary]."-".$value[maxsalary];
						}else{
							if($value[maxsalary]<1000){
								if($config['resume_salarytype']==2){
									$recjob[$key][job_salary] = "1千以下";
								}elseif($config['resume_salarytype']==3){
								$recjob[$key][job_salary] = "1K以下";
								}elseif($config['resume_salarytype']==4){
								$recjob[$key][job_salary] = "1k以下";
								}
							}else if($value[minsalary]<1000){
								$recjob[$key][job_salary] =changeSalary($value[maxsalary]);
							}else{
								$recjob[$key][job_salary] =changeSalary($value[minsalary])."-".changeSalary($value[maxsalary]);
							}
						}
					}elseif($value[minsalary]){
						if($config['resume_salarytype']==1){
						    $recjob[$key][job_salary] =$value[minsalary]."以上";
						}else{
							$recjob[$key][job_salary] =changeSalary($value[minsalary])."以上";
						}
					}else{
						$recjob[$key][job_salary] ="面议";
					}
					
					if($r_uid[$value['uid']][shortname]){
						$recjob[$key][com_name] =$r_uid[$value['uid']][shortname];
					}
					if(!empty($value[zp_minage]) && !empty($value[zp_maxage])){					   
					    if($value[zp_minage]==$value[zp_maxage]){
					        $recjob[$key][job_age] = $value[zp_minage]."周岁以上";
					    }else{
					        $recjob[$key][job_age] = $value[zp_minage]."-".$value[zp_maxage]."周岁";
					    }
					}else if(!empty($value[zp_minage]) && empty($value[zp_maxage])){
					    $recjob[$key][job_age] = $value[zp_minage]."周岁以上";
					}else{
					     $recjob[$key][job_age] = 0;
					}
					if($value[zp_num]==0){
					    $recjob[$key][job_number] = "";
					}else{
					    $recjob[$key][job_number] = $value[zp_num]." 人";
					}			
					$recjob[$key][yyzz_status] =$r_uid[$value['uid']][yyzz_status];
					$recjob[$key][logo] =$r_uid[$value['uid']][logo];
					$recjob[$key][pr_n] =$r_uid[$value['uid']][pr_n];
					$recjob[$key][hy_n] =$r_uid[$value['uid']][hy_n];
					$recjob[$key][mun_n] =$r_uid[$value['uid']][mun_n];
					$recjob[$key][hotlogo] =$r_uid[$value['uid']][hotlogo];
					$time=$value['lastupdate'];
					//今天开始时间戳
					$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
					//昨天开始时间戳
					$beginYesterday=mktime(0,0,0,date('m'),date('d')-1,date('Y'));
					
					if($time>$beginYesterday && $time<$beginToday){
						$recjob[$key]['time'] ="昨天";
					}elseif($time>$beginToday){	
						$recjob[$key]['time'] = $recjob[$key]['lastupdate'];
						$recjob[$key]['redtime'] =1;
					}else{
						$recjob[$key]['time'] = date("Y-m-d",$value['lastupdate']);
					}
    
                     // 前天
    				$beforeYesterday=mktime(0,0,0,date('m'),date('d')-2,date('Y'));

					if($value['sdate']>$beforeYesterday){
						$recjob[$key]['newtime'] =1;
					}
					//获得福利待遇名称
					if($value[welfare]){
					    $value[welfare] = str_replace(' ', '',$value[welfare]);
						$welfareList = @explode(',',trim($value[welfare]));

						if(!empty($welfareList)){
							$recjob[$key][welfarename] =array_filter($welfareList);
						}
					}
					//截取公司名称
					if($paramer[comlen]){
						if($r_uid[$value['uid']][shortname]){
							$recjob[$key][com_n] = mb_substr($r_uid[$value['uid']][shortname],0,$paramer[comlen],"utf-8");
						}else{
							$recjob[$key][com_n] = mb_substr($value['com_name'],0,$paramer[comlen],"utf-8");
						}
					}
					//截取职位名称
					if($paramer[namelen]){
						if($value['rec_time']>time()){
							$recjob[$key][name_n] = "<font color='red'>".mb_substr($value['name'],0,$paramer[namelen],"utf-8")."</font>";
						}else{
							$recjob[$key][name_n] = mb_substr($value['name'],0,$paramer[namelen],"utf-8");
						}
					}else{
						if($value['rec_time']>time()){
							$recjob[$key]['name_n'] = "<font color='red'>".$value['name']."</font>";
						}else{
							$recjob[$key][name_n] = $value['name'];
						}
					}
					//构建职位伪静态URL
					$recjob[$key][job_url] = Url("job",array("c"=>"comapply","id"=>$value[id]),"1");
					//构建企业伪静态URL
					$recjob[$key][com_url] = Url("company",array("c"=>"show","id"=>$value[uid]));
					
					foreach($comrat as $k=>$v){
						if($value[rating]==$v[id]){
							$recjob[$key][color] = str_replace("#","",$v[com_color]);
							if($v[com_pic]){
								$recjob[$key][ratlogo] = checkpic($v[com_pic]);
							}
							$recjob[$key][ratname] = $v[name];
						}
					}
					if($paramer[keyword]){
						$recjob[$key][name]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$value[name]);
						$recjob[$key][name_n]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$recjob[$key][name_n]);
						$recjob[$key][com_n]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$recjob[$key][com_n]);
						$recjob[$key][job_city_one]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$city_name[$value[provinceid]]);
						$recjob[$key][job_city_two]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$city_name[$value[cityid]]);
					}
				}
			}
			if(is_array($recjob)){
				if($paramer[keyword]!=""&&!empty($recjob)){
					addkeywords('3',$paramer[keyword]);
				}
			}
		}$recjob = $recjob; if (!is_array($recjob) && !is_object($recjob)) { settype($recjob, 'array');}
foreach ($recjob as $_smarty_tpl->tpl_vars['recjob']->key => $_smarty_tpl->tpl_vars['recjob']->value) {
$_smarty_tpl->tpl_vars['recjob']->_loop = true;
 $_smarty_tpl->tpl_vars['rjk']->value = $_smarty_tpl->tpl_vars['recjob']->key;
?>
                    <a href="<?php echo smarty_function_url(array('m'=>'wap','c'=>'job','a'=>'comapply','id'=>$_smarty_tpl->tpl_vars['recjob']->value['id']),$_smarty_tpl);?>
" title="<?php echo $_smarty_tpl->tpl_vars['recjob']->value['name'];?>
">

                        <div class="table-card" style="<?php if ($_smarty_tpl->tpl_vars['rjk']->value==0) {?>margin-top: .3rem;<?php }?>">
                            <div class="card_post">
                                <i class="table-card-word"><?php echo $_smarty_tpl->tpl_vars['recjob']->value['name'];?>
</i>
                                <i class="table-card-salary"><?php echo $_smarty_tpl->tpl_vars['recjob']->value['job_salary'];?>
</i>
                            </div>
                            <div class="table-card-require">
                                <i class="requir-area"><?php echo $_smarty_tpl->tpl_vars['recjob']->value['job_city_one'];?>
-<?php echo $_smarty_tpl->tpl_vars['recjob']->value['job_city_two'];?>
</i>
                                <i class="requir_area_parting_line"></i>
                                <?php if ($_smarty_tpl->tpl_vars['recjob']->value['job_edu']) {?><i class="requir-area"><?php echo $_smarty_tpl->tpl_vars['recjob']->value['job_edu'];?>
学历</i><?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['recjob']->value['job_exp']) {?>  <i class="requir_area_parting_line"></i><i class="requir-area"><?php echo $_smarty_tpl->tpl_vars['recjob']->value['job_exp'];?>
经验</i><?php }?>
                            </div>
                            <?php if ($_smarty_tpl->tpl_vars['recjob']->value['welfarename']) {?>
                            <div class="welfare">
                                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['recjob']->value['welfarename']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                                <span class="welfare_n"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</span>
                                <?php } ?>
                            </div>
                            <?php }?>
                            <div class="index_company">
                                <i class="index_company-logo">
                                    <img src="<?php echo $_smarty_tpl->tpl_vars['recjob']->value['logo'];?>
" alt="" style="width: 100%;">
                                </i>
                                <i class="index_company-name"><?php echo mb_substr(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['recjob']->value['com_name']),0,20,"utf-8");?>
</i>
                                <i class="index_company-status">
                                    <?php echo $_smarty_tpl->tpl_vars['recjob']->value['time'];?>

                                </i>
                            </div>
                        </div>
                    </a>
                    <?php } ?>
                </van-tab>
                
                <van-tab title="附近">
                    <div v-if="skeletonLoading">
                        <div class="map_job_list" v-for="(item,skeletonKey) in skeletonLen" :key="skeletonKey">
                            <div class="map_job_list_box">
                                <van-skeleton :row-width="['100%', '50%', '100%']" :row="3"></van-skeleton>
                            </div>
                        </div>
                    </div>
                    <div v-else>
                        <div v-if="nearbyJob">
                            <div v-for="(item,nkey) in nearbyJobList" :key="nkey" class="map_job_list">
                                <div class="map_job_list_box">
                                    <div class="map_job_top">
                                        <div class="neighbouring_top">
                                            <div class="map_job_topname">
                                                <a :href="item.joburl">{{item.name}}</a>
                                            </div>
                                            <span class="map_job_xz">{{item.salary_n}}</span>
                                        </div>
                                        <div class="map_job_list_welfare">
                                            <ul>
                                                <li>{{item.job_city_one}}-{{item.job_city_two}}</li>
                                                <i class="requir_area_parting_line"></i>
                                                <li v-if="item.job_edu">{{item.job_edu}}学历</li>
                                                <i class="requir_area_parting_line"></i>
                                                <li v-if="item.job_exp">{{item.job_exp}}经验</li>
                                            </ul>
                                        </div>
                                        <div v-if="item.welfare" class="welfare">
                                        <span v-for="(witem,wkey) in item.welfare" :key="wkey" class="welfare_n">
                                            {{witem}}
                                        </span>
                                        </div>
                                    </div>
                                    <div class="com_map">
                                        <div class="map_job_com">
                                            <a :href="item.comurl">
                                                <div class="map_job_com_logo">
                                                    <img :src="item.logo" alt="" width="100%" height="100%">
                                                </div>
                                                <div class="map_job_com_name">{{item.com_name}}</div>
                                            </a>
                                        </div>
                                        <div class="com_map_name">
                                            <a :href="item.addressurl">
                                                <div class="com_map_name_address">{{item.address}}</div>
                                                <div class="com_map_distance">{{item.dis}}</div>
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-else class="no_data">
                            <div class="no_data_img">
                                <img src="<?php echo $_smarty_tpl->tpl_vars['wap_style']->value;?>
/images/home_emptygraph.png" alt=""style="width: 100%;">
                            </div>
                            <i class="no_data_word">当前没有职位数据哦~</i>
                        </div>
                    </div>
                </van-tab>
            </van-tabs>
			<!--弹窗广告-->
            <van-popup v-model="adBanner" position="center" :style="{ width:'90%',background:'none'}" closeable>
				<?php  $_smarty_tpl->tpl_vars["lunbo"] = new Smarty_Variable; $_smarty_tpl->tpl_vars["lunbo"]->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
global $db,$db_config,$config;$AdArr=array();$paramer=array();$attr=array("classid"=>"502","item"=>"\"lunbo\"","key"=>"'key'","random"=>"1","nocache"=>"")
;
			include(PLUS_PATH.'pimg_cache.php');$add_arr = $ad_label[502];if(is_array($add_arr) && !empty($add_arr)){
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
				<div class="zd_userbanner"><?php echo $_smarty_tpl->tpl_vars['lunbo']->value['html'];?>
</div>
				<?php } ?>
            </van-popup>
			<!--弹窗广告-->
        </div>
    </div>
    <div class="yun_newedition_jobmore"><a href="<?php echo smarty_function_url(array('m'=>'wap','c'=>'job'),$_smarty_tpl);?>
">查看更多</a></div>

    <div class="yun_newedition_footer">
        <div class="">
            <a href="<?php echo smarty_function_url(array('m'=>'wap','c'=>'contact'),$_smarty_tpl);?>
">联系我们</a>
            <span class="yun_newedition_footer_line">|</span>
            <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_app_open']==1) {?>
            <a href="<?php echo smarty_function_url(array('m'=>'wap','c'=>'appdown'),$_smarty_tpl);?>
">下载APP</a>
            <span class="yun_newedition_footer_line">|</span>
            <?php }?>
            <a href="<?php echo smarty_function_url(array('m'=>'wap','c'=>'advice'),$_smarty_tpl);?>
">意见反馈</a>
            <span class="yun_newedition_footer_line">|</span>
            <a href="<?php echo smarty_function_url(array('m'=>'wap','c'=>'about'),$_smarty_tpl);?>
">关于我们</a>
        </div>
    </div>
	<?php if (!empty($_smarty_tpl->tpl_vars['kfurl']->value)&&$_smarty_tpl->tpl_vars['isweixin']->value) {?>
	<!--企业微信浮动客服-->
    <a href="<?php echo $_smarty_tpl->tpl_vars['kfurl']->value;?>
" class="zxkf"> </a>
    <?php }?>
</div>

<style>
    .van-tabs__nav {
        background-color: #f4f4f4;
        font-size: 0.8rem;
    }

    .van-tab__text {
        font-size: 0.426666rem;
    }

    .van-tab--active {
        font-weight: bold;
    }

    .van-skeleton__row:not(:first-child) {
        margin-top: 22px;
    }
</style>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['wapstyle']->value)."/publichtm/public_js.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['mapurl'];?>
"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
    // 轮播图
    new Swiper('#imgswiper', {
        direction: 'horizontal',
        autoplay: {
            disableOnInteraction: false
        },
        loop: true
    });
    // 金刚位
    new Swiper('#navswiper', {
        direction: 'horizontal',
        pagination: {
            el: '.swiper-pagination'
        }
    });
    // 公告
    new Swiper('#ggswiper', {
        direction: 'vertical',
        autoplay: {
            disableOnInteraction: false
        },
        loop: true,
		height: 40,
        autoHeight: true
    });
    // 名企
    new Swiper('#hotjob', {
        slidesPerView: 2.25,
        spaceBetween: 1,
        autoplay: {
            disableOnInteraction: false
        },
        loop: true
    });

    var yunvue = new Vue({
        el: '#yunvue',
        data() {
            return {
                skeletonLoading: true,
                skeletonLen: new Array(15).fill(''),
                nearbyJob: false,
                nearbyJobList: [],
                x: '',
                y: '',
                adBanner:false,
            };
        },
        created() {
			$('#yunvue').css('display','block');
            this.adShow();
        },
        methods: {

            chooseTab: function(name, title){
                let that = this;
                if (name==3 && title=='附近'){

                    setTimeout(() => {
                        that.getCurrentLoaction();
                    }, 1000)
                }
            },
            getCurrentLoaction: function () {
                let that = this;
                var geolocation = new BMap.Geolocation();
                geolocation.getCurrentPosition(function (r) {
                    if (this.getStatus() == BMAP_STATUS_SUCCESS) {
                        that.x = r.point.lng;
                        that.y = r.point.lat;
                        $.post(wapurl + 'index.php?c=job&a=distance', {
                            x: r.point.lng,
                            y: r.point.lat
                        }, function (data) {
                            that.getNearbyJob();
                        })
                    } else {
                        console.log('获取定位异常' + this.getStatus())
                        that.getNearbyJob();
                    }
                }, {
                    enableHighAccuracy: true
                });
            },
            getNearbyJob: function () {
                let that = this;
                let paramer = {
                    x: that.x,
                    y: that.y,
                    limit: 15
                }
                $.post('index.php?c=map&a=joblist', paramer, function (data) {
                    if (data.list.length > 0) {
                        that.nearbyJobList = data.list
                        that.nearbyJob = true;
                    }
                    that.skeletonLoading = false;
                }, 'json');
            },
            adShow: function () { // 首页弹出广告
				if($('.zd_userbanner').length > 0){
					var bannerFlag = "<?php echo $_smarty_tpl->tpl_vars['bannerFlag']->value;?>
";
					if (bannerFlag) {
						this.adBanner = false;
					} else{
						this.adBanner = true;
					}
				}
            },
        }
    });
    function privacy(){
        var paramer = {                   
            status: 1,
        };
        showLoading('设置中...');
        $.post('<?php echo smarty_function_url(array('d'=>'wxapp','h'=>'user','m'=>'privacy','c'=>'up'),$_smarty_tpl);?>
', paramer, function(data){
            hideLoading();
            location.reload();
        },'json');
        
    }
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['wapstyle']->value)."/publichtm/search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['wapstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }} ?>
