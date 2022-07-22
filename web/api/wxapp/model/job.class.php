<?php
/*
* $Author ：PHPYUN开发团队
*
* 官网: http://www.phpyun.com
*
* 版权所有 2009-2021 宿迁鑫潮信息技术有限公司，并保留所有权利。
*
* 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
 */
class job_controller extends wxapp_controller{
	function list_action(){//职位列表
	    $jobM  =  $this->MODEL('job');
	    $cacheM = $this->MODEL('cache');
	    $search             =   false;
		$where['state']		=	1;
		$where['status']	=	0;
		$where['r_status']	=	1;
		$provinceid			=	(int)$_POST['provinceid'];
		$cityid				=	(int)$_POST['cityid'];
		$three_cityid		=	(int)$_POST['three_cityid'];
		$job1				=	(int)$_POST['job1'];
		$job1_son			=	(int)$_POST['job1_son'];
		$job_post			=	(int)$_POST['job_post'];
		$exp				=	(int)$_POST['exp'];
		$hy					=	(int)$_POST['hy'];
		$pr					=	(int)$_POST['pr'];
		$mun				=	(int)$_POST['mun'];
		$edu				=	$_POST['edu'];
		$notinids			=	$_POST['zdids'];
		
		$sdate				=	$_POST['sdate'];
		$edate				=	$_POST['edate'];

		if ($_POST['keyword']!='undefined'){
		    $keyword		=	$this->stringfilter($_POST['keyword']);
		}
		$order				=	$_POST['order'];
		$nodata				=	$_POST['nodata'];
		$uid				=	(int)$_POST['uid'];
		$state				=	(int)$_POST['state'];
		$rec 				=	(int)$_POST['rec'];
		
		if($_POST['state']){
			if($_POST['state']==2){
				$where['edate']	=	array('<',time());
			}elseif($_POST['state']==4){
				$where['state']	=	'0';
			}else{
				$where['state']	=	$_POST['state'];
			}
		}
		if($_POST['cuid']){
		    $where['uid']		=	$_POST['cuid'];
		}
		if($_POST['urgent']){
			$where['urgent_time']=	array('>',time());
		}
		if($edu){            
            $CacheArr   =   $cacheM->GetCache(array('com'));
			$eduArr = $CacheArr['comdata']['job_edu'];
			$eduIds = [];
            foreach ($eduArr as $key => $value) {
                if ($value <= $edu) {
                    $eduIds[] = $value;
                }
            }
            if ($eduIds) {
            	$where['edu'] = array('in', pylode(',', $eduIds));
            }
 		}

		if($_POST['r_status']){
			$where['r_status']	=	(int)$_POST['r_status'];
		}
		if($_POST['status']){
			$where['status']	=	(int)$_POST['status'];
		}
		if($rec==1){
		    //老版的推荐排序为 优先排会员且按rec_time排序，此处暂时参照wap
			$where['rec_time']	=	array('>=',time());
		}
		if($hy){//类别ID
			$where['hy']		=	$hy;
		}
		if($pr){//类别ID
			$where['pr']		=	$pr;
		}
		if($mun){//类别ID
			$where['mun']		=	$mun;
		}
		if($exp){
            $CacheArr   =   $cacheM->GetCache(array('com'));
			$expArr = $CacheArr['comdata']['job_exp'];
			$expIds = [];
            foreach ($expArr as $key => $value) {
                if ($value <= $exp) {
                    $expIds[] = $value;
                }
            }
            if ($expIds) {
            	$where['exp'] = array('in', pylode(',', $expIds));
            }
		}
		if($provinceid){//类别ID
			$where['provinceid']=	$provinceid;
		}
		if($cityid){//类别ID
			$where['cityid']	=	$cityid;
		}
		if($three_cityid){//类别ID
			$where['three_cityid']	=	$three_cityid;
		}
		
		if($job1){//类别ID
			$where['job1']		=	$job1;
		}
		if($job1_son){//类别ID
			$where['job1_son']	=	$job1_son;
		}
		if($job_post){//类别ID
			$where['job_post']	=	$job_post;
		}
		if($sdate){//开始时间
			$where['lastupdate']=	array('>',strtotime($sdate));
		}
		if($edate){//结束时间
		    $where['lastupdate']=	array('<',strtotime($edate));
		}
		if($_POST['sex']){
			$where['sex']		=	$_POST['sex'];
		}
		if($_POST['uptime']){//更新时间
			if($_POST['uptime']==1){
				$where['lastupdate']=	array('>',strtotime(date('Y-m-d 00:00:00')));
			}else{
				$where['lastupdate']=	array('>',strtotime('-'.$_POST['uptime'].' day'));
			}
		}else{
		    if($this->config['sy_datacycle']>0){
		        // 后台-页面设置-数据周期
                $where['lastupdate']=	array('>',strtotime('-'.$this->config['sy_datacycle'].' day'));
            }
        }
		if($keyword){//关键字
			$cache	=	$cacheM->GetCache('city');
			$cityid	=	array();
			foreach($cache['city_name'] as $k=>$v){
				if(strpos($v,$keyword)!==false){
					$cityid[]	=	$k;
				}
			}
			

			$where['PHPYUNBTWSTART_A']	=	'';
            $where['name']				=	array('like',$keyword);
            $where['com_name']			=	array('like',$keyword,'OR');
            if (!empty($cityid)){
                $where['provinceid']	=	array('in',pylode(',',$cityid),'OR');
                $where['cityid']		=	array('in',pylode(',',$cityid),'OR');
            }
            $where['PHPYUNBTWEND_A']	=	'';
		}
        if ($_POST['salary']){
            $salaryArr  =  $this->salaryArr(true);
            $salary     =  $salaryArr[$_POST['salary']];
            
            if ($salary['minsalary'] > 0 && $salary['maxsalary'] > 0){
                
                $where['PHPYUNBTWSTART_A']  =  '';
                $where['minsalary'][]       =  array('>=', $salary['minsalary']);
                $where['minsalary'][]       =  array('<=', $salary['maxsalary']);
                $where['maxsalary']         =  array('<=', $salary['maxsalary']);
                $where['PHPYUNBTWEND_A']	=	'';
                
            } elseif ($salary['minsalary'] > 0 && $salary['maxsalary'] == 0){
                
                $where['minsalary']         =  array('>=', $salary['minsalary']);
                
            } elseif ($salary['minsalary'] == 0 && $salary['maxsalary'] > 0){
                
                $where['minsalary']         =  array('<=', $salary['maxsalary']);
                $where['maxsalary']         =  array('<=', $salary['maxsalary']);
            }
        }
        if(!empty($_POST['welfare'])){
            $CacheArr  =  $cacheM->GetCache('com');
            $wname     =  $CacheArr['comclass_name'][$_POST['welfare']];
            
            $wel = array(
                'state'    => 1,
                'status'   => 0,
                'r_status' => 1,
                'welfare'  => array('findin',$wname)
            );
            $wlist  =  $jobM->getList($wel,array('field'=>'id'));
            if(!empty($wlist['list'])){
                foreach($wlist['list'] as $v){
                    $wid[] = $v['id'];
                }
                $where['id']  =  array('in', pylode(',', $wid));
            }
        }
        // 处理分站查询条件
        if (!empty($_POST['did'])){
            
            $domain  =  $this->getDomain($_POST['did'], true);
            
            if (isset($domain['didcity'])){
                
                $data['didcity']    =  $domain['didcity'];
                
                if (!empty($_POST['provinceid'])){
                    // 分站下，再次选择城市，查询按选择的来
                    $where['provinceid']  =  $_POST['provinceid'];
                    $data['didcity']      =  $domain['city_name'][$_POST['provinceid']];
                }elseif (!empty($domain['provinceid'])){
                    $where['provinceid']  =  $domain['provinceid'];
                }
                if (!empty($_POST['cityid'])){
                    // 分站下，再次选择城市，查询按选择的来
                    $where['cityid']  =  $_POST['cityid'];
                    $data['didcity']  =  $domain['city_name'][$_POST['cityid']];
                }elseif (!empty($domain['cityid'])){
                    $where['cityid']  =  $domain['cityid'];
                }
                if (!empty($_POST['three_cityid'])){
                    // 分站下，再次选择城市，查询按选择的来
                    $where['three_cityid']  =  $_POST['three_cityid'];
                    $data['didcity']        =  $domain['city_name'][$_POST['three_cityid']];
                }elseif (!empty($domain['three_cityid'])){
                    $where['three_cityid']  =  $domain['three_cityid'];
                }
                
                $data['cityone']    =  $domain['cityone'];
                $data['citytwo']    =  $domain['citytwo'];
                $data['citythree']  =  $domain['citythree'];
                $data['provinceid']    =  !empty($where['provinceid']) ? intval($where['provinceid']) : 0;
                $data['cityid']        =  !empty($where['cityid']) ? intval($where['cityid']) : 0;
                $data['three_cityid']  =  !empty($where['three_cityid']) ? intval($where['three_cityid']) : 0;
            }
            if (isset($domain['didhy'])){
                
                if (!empty($domain['hyclass'])){
                    $where['hy']  =  $domain['hyclass'];
                }
            }
        }else {
            // 没有已选择的城市，按后台设置的列表页区域默认设置来（后台-页面设置-列表页区域默认设置）
            // 设置了一级城市，后面的搜索，不再展示其他一级城市
            if (empty($_POST['provinceid']) && empty($_POST['cityid']) && empty($_POST['three_cityid']) || (!empty($_POST['provinceid']) && $_POST['provinceid'] == $this->config['sy_web_city_one'])){
                
                $list_cityid      = isset($where['cityid']) ? $where['cityid'] : 0;
                $list_threecityid = isset($where['three_cityid']) ? $where['three_cityid'] : 0;
                
                $listback = $this->listCity($list_cityid, $list_threecityid);
                if (!empty($listback)) {
                    if (isset($listback['provinceid'])){
                        $where['provinceid']  =  $listback['provinceid'];
                    }
                    if (isset($listback['cityid'])){
                        $where['cityid']  =  $listback['cityid'];
                    }
                    if (isset($listback['listcity'])){
                        $data['listcity']   =  $listback['listcity'];
                        $data['cityone']    =  $listback['cityone'];
                        $data['citytwo']    =  $listback['citytwo'];
                        $data['citythree']  =  $listback['citythree'];
                        
                        $data['provinceid']    =  !empty($where['provinceid']) ? intval($where['provinceid']) : 0;
                        $data['cityid']        =  $list_cityid;
                        $data['three_cityid']  =  $list_threecityid;
                    }
                }
            }
        }
        
		$page  =  $_POST['page'];

		$jfield   =  '`id`,`uid`,`name`,`provinceid`,`cityid`,`exp`,`edu`,`welfare`,`minsalary`,`maxsalary`,`lastupdate`,`com_name`,`sdate`,`rec`,`rec_time`,`urgent`,`urgent_time`,`xsdate`,`rating`,`zuid`';

		if(!$_POST['mapjob']){
			if ($page==1 && isset($_POST['joblist'])){
				$xswhere	=	$where;
			    if ($this->config['joblist_top']==1){

			    	$xswhere['xsdate']	=	array('>',time());
			    	$xswhere['orderby']	=	'`lastupdate`,asc';
			        
			    }else{
			    	$xswhere['xsdate']	=	array('>',time());
			    	$xswhere['orderby']	=	'rand(),desc';
			    	$xswhere['limit']	=	'5';

			    }
			}
		}

		if($_POST['mapjob'] && $_POST['x'] && $_POST['y']){

			$coordinates	=	$this->Convert_GCJ02_To_BD09($_POST['x'],$_POST['y']);
			
			$where['x'] = array('>', 0);
			$where['y'] = array('>', 0);
			$order = 'distance, asc';

		    $x	=	$coordinates['lng'];
		    $y	=	$coordinates['lat'];
		    // 根据sql距离计算公式计算距离并排序
	        $jfield .=   ",`x`,`y`, 6371 * acos(cos(radians(" . $y . ")) * cos(radians(`y`)) * cos(radians(`x`) - radians(" . $x . ")) + sin(radians(" . $y . ")) * sin(radians(`y`))) AS `distance`";
		}

		if($order){//排序
			$where['orderby']	=	$order;
		}else{
			$where['orderby']	=	'lastupdate,desc';
		}
		if ($_POST['limit']){
		    $limit				=	$_POST['limit'];
		    if($page){//分页
		        $pagenav		=	($page-1)*$limit;
		        $where['limit']	=	array($pagenav,$limit);
		    }else{
		    	$where['limit']	=	$limit;
		    }
		}
		
		
		
		if(!empty($xswhere)){
		    $xsjobrows 	=   $jobM->getList($xswhere,array('field'=>$jfield,'utype'=>'wxapp'));
			
			$xsrows		=	$xsjobrows['list'];
			if ($xsrows){
				$notinids 		= $zdids	=	array();
				foreach ($xsrows as $v){
					$notinids[] = $zdids[]	=	$v['id'];
		        }
	    	}
		}

		if(isset($notinids)){//其他职位
			$where['id']=	array('notin',pylode(',',$notinids));
		}
		$jobrows    	=   $jobM	->	getList($where,array('field'=>$jfield,'utype'=>'wxapp'));
		$rows			=	$jobrows['list'];
		
		if(is_array($rows)&&$rows){
		    // 清除置顶下面列表数据的置顶参数
		    foreach($rows as $k=>$v){
		        if (isset($v['xs']) && $v['xs'] == 1){
		            unset($rows[$k]['xs']);
		        }
		    }
		    if ($xsrows){
		    	
		        foreach($rows as $k=>$v){
		            foreach ($xsrows as $val){
		            	
		                if($v['id']==$val['id']){
		                    unset($rows[$k]);
		                }
		            }
		        }
		        foreach ($xsrows as $v){
		            // 置顶职位，清除职位更新时间
		            $v['lastupdate_date']  =  '';
		        	array_unshift($rows,$v);
		        }
		    }
		}elseif ($page==1 && isset($_POST['joblist']) && !$_POST['mapjob']){
			$rows  =  $xsrows;
		}
        foreach($rows as $k=>$v){

        	if($_POST['mapjob']){
        		if ($v['distance'] <= 1) {
	                $rows[$k]['dis']    =   ceil($v['distance'] * 1000) . 'm';
	            } else {
	                $rows[$k]['dis']    =   round($v['distance'], 2) . 'km';
	            }
        	}
        	
            if (!empty($v['lastupdate']) && !empty($v['lastupdate_n'])){
                $beginToday  =  strtotime('today');//今天开始时间戳
                if($v['lastupdate']>$beginToday){
                    $rows[$k]['lastupdate_n']  =  lastupdateStyle($v['lastupdate']);
                }
            }
        }

		$list	=	count($rows) > 0 ? $rows : array();

		$data['list']		=	$list;
		$data['zdids']		=	$zdids;
		// 小程序用seo
		if (isset($_POST['provider'])){
            if ($_POST['provider'] == 'baidu' || $_POST['provider'] == 'weixin' || $_POST['provider'] == 'toutiao'){
                $seo            =  $this->seo('com_search','','','',false, true);
                $data['seo']    =  $seo;
            }
		}
		$this->render_json(0,'',$data);
	}

    /**
     * 职位详情
     */
	function show_action()
	{
		$id		   =  (int)$_POST['id'];
		$JobM		=	$this -> MODEL('job');	
		$job		=   $JobM -> getInfo(array('id' => $id ,'r_status' => array('<>', 2)), array('utype'=>'wxapp','com' => 'yes'));
		if($job && is_array($job)){
			
			// 投递数量
	        $allnum     =   $JobM->getSqJobNum(array('job_id' => $id,'isdel'=>9));
	        
	        $job['snum'] = $allnum;
        	
			if (!empty($job['description'])){
			    
			    $job['description'] = $this->preghtml($job['description']);
			}
			if (!empty($job['job_lang'])){
			    
			    $job['job_lang'] = implode(',', $job['job_lang']);
			}
			// 复制文本用职位简介
			$job['desc_n']  =   mb_substr(strip_tags($job['description']), 0, 200);
			$job['job_url'] =   Url('wap', array('c' => 'job', 'a' => 'comapply', 'id' => $id));
			$error			=	1;
			$msg			=	'';
			$data['list']	=	count($job)?$job:array();

			if (isset($_POST['provider'])){
			    // 百度小程序用seo
			    if ($_POST['provider'] == 'baidu' || $_POST['provider'] == 'weixin'){
			        // 获取seo使用的数据
			        $seodata['job_name']       =   $job['jobname']; // 职位名称
			        $seodata['company_name']   =   $job['com_name']; // 公司名称
			        $seodata['industry_class'] =   $job['hy_n']; // 所属行业
			        $seodata['job_class']      =   $job['job_one'] . ',' . $job['job_two'] . ',' . $job['job_three']; // 职位名称
			        $seodata['job_salary']     =   $job['job_salary']; // 职位薪资
			        $seodata['job_desc']       =   $this->GET_content_desc($job['description']); // 描述
			        $this->data = $seodata;
                    if ($_POST['provider'] == 'baidu' || $_POST['provider'] == 'weixin' || $_POST['provider'] == 'toutiao'){
                        $seo            =  $this->seo('comapply','','','',false, true);
                        $data['seo']    =  $seo;
                    }
			    }
			}
            $data['chatOpen']	=  $this->config['sy_chat_open'];
            $data['chat_name']  =  $this->config['sy_chat_name'] ? $this->config['sy_chat_name'] : '';

            $data['iosfk']	=	$this->config['sy_iospay'] ;
		}else{
			$msg			=	'职位不存在!';
			$error			=	0;
			$data['list']	=	array();
		}
		
		$this->render_json($error,$msg,$data);
	}
	/**
	 * 职位详情页-推荐职位、简历列表等其他数据(通过分开查询，提高页面显示速度)
	 */
	function jobShowOther_action(){
	    
	    $info  =  array(); 
	    include_once(CONFIG_PATH.'db.data.php');
	    
	    $JobM  =  $this -> MODEL('job');
	    $job   =  $JobM -> getInfo(array('id' => $_POST['id'] ,'r_status' => array('<>', 2)), array('field'=>'`id`,`uid`,`name`,`job1`,`x`,`y`,`rewardpack`,`zuid`,`state`,`status`,`r_status`,`com_logo`'));
	    
	    if (!empty($job)){
	        // 查询企业近期活跃情况
	        $logM		=	$this -> MODEL('log');
	        $wtime		=	time()-3600*24*7;
	        $loginlog	=	$logM->getLoginLog(array('uid'=>$job['uid'],'usertype'=>2,'ctime'=>array('<',$wtime)));
	        
	        if(!empty($loginlog)){
	            $info['isloginlog']	=	1;
	        }
	        
	        $uid  =  $usertype  =  '';
	        
	        if (!empty($_POST['uid']) && !empty($_POST['token'])){
	            
	            $member    =  $this->yzToken($_POST['uid'], $_POST['token']);
	            $uid       =  $member['uid'];
	            $usertype  =  $member['usertype'];
	        }
	        if(empty($uid) || (!empty($uid) && $uid != $job['uid'])){
	            if($job['r_status']==0||$job['r_status']==3){
	                $msg= '企业暂未通过审核！';
	            }elseif($job['r_status']==2||$job['r_status']==4){
	                $msg= '企业已被锁定！';
	            }elseif($job['state'] == 0){
	                $msg= '职位审核中！';
	            }elseif($job['state'] == 3){
	                $msg= '该职位未通过审核！';
	            }elseif($job['status'] == 1){
	                $msg= '该职位已下架！';
	            }
	            if(isset($msg)){
	                $this->render_json(0, $msg);
	            }
	        }
	        
	        $hbids = array();
	        if (isset($_POST['provider'])){
	            // app用分享数据
	            if ($_POST['provider'] == 'app'){
	                $data['shareData']  =  array(
	                    'url'       =>  Url('wap',array('c'=>'job','a'=>'comapply','id'=>$job['id'])),
	                    'title'     =>  $job['name'],
	                    'summary'   =>  mb_substr(strip_tags($job['content']), 0,30,'UTF8'),
	                    'imageUrl'  =>  checkpic($job['com_logo'], $this->config['sy_unit_icon'])
	                );
	            }
	            if ($_POST['provider'] != 'baidu' && $_POST['provider'] != 'toutiao' && $this->config['sy_haibao_isopen'] == 1){
	                $WhbM       =   $this->MODEL('whb');
	                $syJobHb    =   $WhbM->getWhbList(array('type' => 1, 'isopen'=>'1'));
	                if(!empty($syJobHb)){
	                    $hbids = array();
	                    foreach ($syJobHb as $hk => $hv) {
	                        $hbids[] = $hv['id'];
	                    }
	                    $data['hbids'] = $hbids;
	                }
	            }
	        }
	        $data['hbids']  =  !empty($hbids) ? $hbids : array();
	        $data['hbNum']  =  count($data['hbids']);
	        $data['ishb']  	=  $this->config['sy_haibao_isopen'] == 1 ? true : false;
	        
	        //联系方式
	        $link		   =  $JobM->getCompanyJobTel(array('id'=>$job['id'],'uid'=>$uid,'usertype'=>$usertype));
	        $info['link']  =  $link;
	        
	        $JobM->addJobHits($job['id']);
	        
	        if(!empty($job['x']) && !empty($job['y'])){
	            $coordinates		=	$this->Convert_BD09_To_GCJ02($job['x'],$job['y']);
	            $info['x']			=	$coordinates['lng'];
	            $info['y']			=	$coordinates['lat'];
	            $info['staticimg']	=	$job['staticimg'];
	        }
	        
	        //赏金职位
	        if($job['rewardpack']==1){
	            $packM				  =	 $this -> MODEL('pack');
	            $reward				  =	 $packM -> getRewardJobInfo($job['id']);
	            $info['money']		  =	 floatval($reward['money']);
	            $info['sqmoney']	  =	 floatval($reward['sqmoney']);
	            $info['invitemoney']  =	 floatval($reward['invitemoney']);
	            $info['offermoney']	  =	 floatval($reward['offermoney']);
	            
	        }
	        // 根据是否有猎头模块，来确定是否有子账号功能
	        $sy_son = isset($arr_data['modelconfig']['lietou']) ? 1 : 2;
	        // 子账号部门
	        if ($sy_son == 1){
	            $CompanyaccountM  	=   $this->MODEL('companyaccount');
	            $department			=	$CompanyaccountM ->getInfo(array('uid'=>$job['zuid']),array('field'=>'`uid`,`name`'));
	            $info['department']	=	$department['name'];
	        }
	        //查询推荐职位
	        $recwhere  =  array(
	            'job1'      =>  $job['job1'],
	            'id'        =>  array('<>',$job['id']),
	            'uid'       =>  array('<>',$job['uid']),
	            'r_status'  =>  1,
	            'state'     =>  1,
	            'status'    =>  0,
	            'limit'     =>  5,
	            'orderby'   =>  'lastupdate,desc'
	        );
	        // 处理分站查询条件
	        if (!empty($_POST['did'])){
	            
	            $domain  =  $this->getDomain($_POST['did']);
	            
	            if (!empty($domain['provinceid'])){
	                $recwhere['provinceid']  =  $domain['provinceid'];
	            }
	            if (!empty($domain['cityid'])){
	                $recwhere['cityid']  =  $domain['cityid'];
	            }
	            if (!empty($domain['three_cityid'])){
	                $recwhere['three_cityid']  =  $domain['three_cityid'];
	            }
	            if (!empty($domain['hyclass'])){
	                $recwhere['hy']  =  $domain['hyclass'];
	            }
	        }
	        $recjob                 =  $JobM->getList($recwhere);
	        $data['recjob']	        =  count($recjob['list'])?$recjob['list']:array();
	        
	        //面试评价
	        $pjlist = $avgArr = array();
	        if ($this->config['com_msg_status'] == 1){
	            $msgwhere['status']	=	1;
	            $msgwhere['jobid']	=	$_POST['id'];
	            $msgwhere['limit']	=   2;
	            $msgwhere['orderby']	=	'ctime,desc';
	            
	            $companyM=  $this->MODEL('company');
	            $pjlist  =	$companyM->getCompanyMsgList($msgwhere);
	            $avg	 =	$companyM->getCompanyMsgInfo(array('jobid'=>$_POST['id'],'status'=>1),array('field'=>'count(*) as num,AVG(score) as score,AVG(desscore) as desscore,AVG(comscore) as comscore,AVG(hrscore) as hrscore'));
	            $avgArr  = 	array('num'=>$avg['num'],'score'=>round($avg['score'],1),'desscore'=>round($avg['desscore'],1),'hrscore'=>round($avg['hrscore'],1),'comscore'=>round($avg['comscore'],1));
	        }
	        
	        // 查询咨询记录
	        $msgList = array();
	        if ($this->config['com_message'] == 1){
	            $msgM	  =	 $this -> MODEL('msg');
	            $msgList  =	 $msgM -> getList(array('jobid' => $job['id'],'status'=>1, 'job_uid' => $job['uid'],'reply' => array('<>',''), 'orderby' => 'datetime,desc', 'limit' => 5));
	        }
	    }
	    
	    if(!empty($uid)){
	        
	        if($usertype == 1){
	            // 当前个人的简历
	            $resumeM	=	$this->MODEL('resume');
	            $resumelist	=	$resumeM->getSimpleList(array('uid'=>$uid,'r_status'=>1,'status' => 1, 'state' => 1, 'orderby' => 'defaults, desc'),array('field'=>'`id`,`defaults`'));
	            foreach($resumelist as $key=>$val){
	                if($val['defaults']==1){
	                    $defaults	=	$val['id'];
	                }
	            }
	            $data['rnum']	    =	count($resumelist);
	            $data['defaults']	=	$defaults;
	            
	            if (!empty($job)){
	                // 增加职位浏览记录
	                $JobM -> addLookJob(array('uid' => $uid, 'jobid' => $job['id'], 'com_id' => $job['uid'], 'datetime' => time(), 'jobname'=>$job['name']));
	                
	                //投递数量
	                $UJWhere['uid']   		=   $uid;
	                $UJWhere['job_id']		=   $job['id'];
	                $UJWhere['isdel']   	=   9;
	                $userid_job    			=   $JobM -> getSqJobNum($UJWhere);
	                $data['useridjob']		=	$userid_job ? 1 : 0;
	                //收藏数量
	                $FJWhere['uid']   		=   $uid;
	                $FJWhere['job_id']		=   $job['id'];
	                $FJWhere['type']  		=   '1';
	                $fav_job				=	$JobM -> getFavJobNum($FJWhere);
	                $data['favjob']			=	$fav_job ? 1 : 0;
	            }
	        }
	    }
	    
	    if (isset($arr_data['modelconfig']['spview']) && $this->config['sy_spview_web'] == 1 && $_POST['provider'] == 'weixin'){
	        // IOS APP 不支持视频面试
	        //包含此职位且可预约的视频面试
	        $spviewM        =   $this->MODEL('spview');
	        
	        $yytime         =   time()+($this->config['sy_spview_yytime']*3600);
	        
	        $spviewWhere    =   array(
	            
	            'starttime' =>  array('>',$yytime),
	            'status'    =>  1,
	            'jobid'     =>  array('findin',$job['id']),
	            'roomstatus'=>  0
	        );
	        
	        $spview         =   $spviewM->getInfo($spviewWhere,array('field'=>'id'));
	        
	        $data['spviewid']	=	$spview['id'];
	    }
	    
	    $data['avgArr']		=	count($avgArr) ? $avgArr : array();
	    $data['pjlist']	    =	count($pjlist) ? $pjlist : array();
	    $data['msgList']	=   count($msgList['list'])?$msgList['list']:array();
	    
	    $data['sy_shenming']=  $this->config['sy_shenming'];
	    $data['iosfk']		=  $this->config['sy_iospay'];
	    $data['wqy']		=  $this->config['com_message'];
	    $data['info']       =  $info;
	    $data['jzl']        =  isset($this->config['sy_job_lookfx']) ? $this->config['sy_job_lookfx'] : 0;
	    

	    //切换身份是否开启
        $data['sy_user_change'] =$this->config['sy_user_change'];

	    $wxpubtempM =   $this->MODEL('wxpubtemp');

        $wxpubtemp_html = $wxpubtempM->getOneJob($job['id'],$_POST['provider']);
	    
	    $data['wxpubtemp_html'] = $wxpubtemp_html;
        // 职位详情广告
	    include PLUS_PATH.'pimg_cache.php';
	    $adid    =  512;
	    $adpics  =  array();
	    if (!empty($ad_label[$adid])){
	        foreach ($ad_label[$adid] as $k=>$v){
	            // 图片广告、没过期、全站使用或者与分站对应
	            if($v['type']=='pic' && $v['start']<time() && $v['end']>time()){
	                $appad = array(
	                    'pic_url' => $v['pic']
	                );
	                if (!empty($v['appurl'])){
	                    // 处理跳转链接路径，开头没有/的，加上/
	                    $appad['appurl']  =  stripos($v['appurl'],'/') == 0 ? $v['appurl'] : '/'.$v['appurl'];
	                }else{
	                    $appad['appurl']  =  '';
	                }
	                $adpics[]  =  $appad;
	            }
	        }
	        $adpics = $this->randomArr($adpics, 1);
	        $data['ad'] = $adpics[0];
	    }
	    
	    $this->render_json(1, 'ok', $data);
	}

    /**
     *
     */
	function addJobTelLog_action(){

		if($_POST['jobid'] || $_POST['comid']){

			$jobM = $this->MODEL('job');

			$uid = 	$usertype = 0;

			if($_POST['uid'] && $_POST['token']){

				$member		=	$this->yzToken((int)$_POST['uid'],$_POST['token']);
				$uid        =  	$member['uid'];
				$usertype   =  	$member['usertype'];
			}
			
			$jobM->addTelLog(
				array(
					'uid'		=>	$uid,
					'usertype'	=>	$usertype,
					'source'	=>	$_POST['source'],
					'jobid'		=>	intval($_POST['jobid']),
					'comid'		=>	intval($_POST['comid'])
				)
			);
		}
		
	}
    /**
     * 申请职位
     */
	function apply_action()
	{
		$member		=	$this->yzToken((int)$_POST['uid'],$_POST['token']);
		$uid        =  $member['uid'];
		$usertype   =  $member['usertype'];
		$jobid 		=	(int)$_POST['jobid'];
		$eid 		=	(int)$_POST['eid'];
		$JobM		=	$this -> MODEL('job');
		$data		=	array(
			'uid'		=>	$uid,
			'usertype'	=>	$usertype,
			'eid'		=>	$eid,
			'job_id'	=>	$jobid,
		    'port'		=>	$this->plat == 'mini' ? '3' : '4'
		);
		
		$res	=	$JobM -> applyJob($data);
        
		if ($res['errorcode'] == 9){
		    $data['error']	=1;
		}elseif ($res['errorcode'] == 7){
		    $data['error']	=3;
		}elseif($res['errorcode'] == 10){
			$data['error']	=4;
		}else{
		    $data['error']	=2;
		}
		$data['msg']	=	$res['msg'];
		$this->render_json($data['error'],$data['msg']);
	}
	/**
	 * 收藏职位
	 */
	function fav_action()
	{
		$member		=	$this->yzToken((int)$_POST['uid'],$_POST['token']);
		$uid        =   $member['uid'];
		$usertype   =   $member['usertype'];
		$jobid 		=	(int)$_POST['jobid'];
		$JobM		=	$this -> MODEL('job');
		$data		=	array(
			'uid'		=>	$uid,
			'usertype'	=>	$usertype,
			'job_id'	=>	$jobid
		);
		$res		=	$JobM -> collectJob($data);
		$data['error']	=	$res['errorcode']==9 ? 1 : 2;
		$data['msg']	=	$res['msg'];
		$this->render_json($data['error'],$data['msg']);
	
	}
 	 //举报职位
  	function repostlist_action(){
	
		$reportM	  			=	  	$this->MODEL('report');
	
		$jobM					=		$this->MODEL('job');
	
		$member		  			=	  	$this->yzToken((int)$_POST['uid'],$_POST['token']);
	
		$uid        			=   	$member['uid'];
	
		$usertype   			=  		$member['usertype'];
	
		$row					=		$reportM->getReportOne(array('p_uid'=>$uid,'eid'=>(int)$_POST['jobid'],'c_uid'=>(int)$_POST['jobuid'],'usertype'=>$usertype));	
		
		$data['error']			=		$row? 1		:	2;

		$this->render_json($data['error']);
	}
	//保存举报职位
	function savereport_action(){
		//先判断是否登录
		$reportM  =  $this->MODEL('report');
		$jobM     =  $this->MODEL('job');
		$member   =  $this->yzToken($_POST['uid'],$_POST['token']);
		if($member['usertype']==1){
			//同时查询
		    $row	=		$reportM->getReportOne(array('p_uid'=>$member['uid'],'eid'=>(int)$_POST['jobid'],'c_uid'=>(int)$_POST['jobuid'],'usertype'=>$member['usertype']));
			if($row && is_array($row)){
				$data['error']	='2';	
				$data['msg']	='已举报该职位';
			}else{
				//查询名称
				$job	=	$jobM->getInfo(array('id' => intval($_POST['jobid'])),array('field'=>'`uid`,`com_name`'));
				if($job['uid']==$member['uid']){
					$data['error']	='2';	
					$data['msg']	='自己不能举报自己发布职位';
				}else{		
					$data	=	array(
						'c_uid'		=>	$job['uid'],
						'inputtime'	=>	time(),
					    'p_uid'		=>	$member['uid'],
						'usertype'	=>	$member['usertype'],
						'eid'		=>	(int)$_POST['jobid'],
						'r_name'	=>	$job['com_name'],
						'username'	=>	$member['username'],
						'r_reason'	=>	$_POST['r_reason'],
						'did'		=>	$member['did']
					);
					
					$nid	=	$reportM->addJobReport($data);
					if($nid){
						$data['error']	='1';	
						$data['msg']	=	'举报成功！';
						
					}else{
						$data['error']	='2';	
						$data['msg']	=	'举报失败！';
					}
				}
			}
		}else{
			$data['error']	='2';	
			$data['msg']	='只有个人用户才能举报职位';
		}
		$this->render_json($data['error'],$data['msg']);
	}
	
	//申请赏金职位
	function rewardshare_action(){
		$packM 			= 		$this->MODEL('pack');
		$resumeM		=		$this->MODEL('resume');
		if(!$_POST['jobid']){
			$data['error']	=	2;
			$data['msg']	=	'参数不正确';
		}else{
			$member					=	  	$this->yzToken((int)$_POST['uid'],$_POST['token']);
			$where['uid']			=		$member['uid'];
			$where['defaults']		=		1;
			$where['state']			=		1;
			$rexpect				=		$resumeM->getExpect($where);
			if($rexpect){
				//判断是否已申请职位
				$expectwhere['uid']			=			$member['uid'];
				$expectwhere['eid']			=			$rexpect['id'];
				$expectwhere['comid']		=			$_POST['comid'];
				$expectwhere['jobid']		=			$_POST['jobid'];
				$packnum					=			$packM->getPackNum($expectwhere);
				if($packnum>0){
					$data['error']	=	1;
					
				}else{
					$data['error']	=	3;
				}
			}else{
				$data['error']	=	2;
				$data['msg']	=	'您的简历审核中，无法申请赏金职位';
			}
		}

		$this->render_json($data['error'],$data['msg']);
	}
	//保存赏金列表申请
	function saverewardshare_action(){
		$member			=	  	$this->yzToken((int)$_POST['uid'],$_POST['token']);
		$packM 			= 		$this->MODEL('pack');
		$uid			=		$member['uid'];
		$usertype		=		$member['usertype'];
		$jobid			=		(int)$_POST['jobid'];
		$comid			=		(int)$_POST['comid'];
		$return			=		$packM->sqRewardJob($jobid,$uid,1,'');
		
		$this->render_json($return['error'],$return['msg'],$return['tid']);
		
	}
	// 申请赏金职位，前置条件查询
	function rewardsharelist_action(){
		//查询职位列表
		$member			=	  	$this->yzToken((int)$_POST['uid'],$_POST['token']);
		$packM 			= 		$this->MODEL('pack');
		$resumeM		=		$this->MODEL('resume');
		if(!$_POST['jobid']){
			$data['error']	=	2;
			$data['msg']	=	'参数不正确';
		}else{
			//查找当前赏金职位是否存在
			$jobid						=		(int)$_POST['jobid'];
			$rewardjob					=		$packM->getRewardJobInfo($jobid);
			if($rewardjob){
				//判断简历是否匹配
				$where['uid']			=		$member['uid'];
				$where['defaults']		=		1;
				$where['state']			=		1;
				$rexpect				=		$resumeM->getExpect($where);
				
        //工作经历
				$checkwhere['uid']	=		$member['uid'];
				$checkwhere['eid']	=		$rexpect['id'];
				$work		=		$resumeM->getResumeWork($checkwhere);
				$rewardjob['eid']	=		$rexpect['id'];
				if($rewardjob['exp']==1 ){
					if($work){
						$rewardjob['worknum']		=		1;
						$rewardjob['workname']		=		'符合';
					}else{
						$rewardjob['worknum']		=		0;
						$rewardjob['workname']		=		'不符合';
					}
					
				}else{
					$rewardjob['worknum']		=		1;
					$rewardjob['workname']		=		'不限';
				}
				//教育经历
				$edu		=		$resumeM->getResumeEdu($checkwhere);
				if($rewardjob['edu']==1 ){
					if($edu){
						$rewardjob['edunum']		=		1;
						$rewardjob['eduname']		=		'符合';
					}else{
						$rewardjob['edunum']		=		0;
						$rewardjob['eduname']		=		'不符合';
					}
					
				}else{
					$rewardjob['edunum']		=		1;
					$rewardjob['eduname']		=		'不限';
				}
				//项目经历
				$project	=		$resumeM->getResumeProject($checkwhere);
				if($rewardjob['project']==1){
					if($project){
						$rewardjob['projectnum']		=		1;
						$rewardjob['projectname']		=		'符合';
					}else{
						$rewardjob['projectnum']		=		0;
						$rewardjob['projectname']		=		'不符合';
					}
					
				}else{
					$rewardjob['projectnum']		=		1;
					$rewardjob['projectname']		=		'不限';
				}
				//技能证书
     
				$skill		=	$resumeM->getResumeSkill($checkwhere);
			
				if($rewardjob['skill']==1){
					if($skill&&$skill['pic']){
						$rewardjob['skillnum']		=		1;
						$rewardjob['skillname']		=		'符合';
					}else{
						$rewardjob['skillnum']		=		0;
						$rewardjob['skillname']		=		'不符合';
					}
					
				}else{
					$rewardjob['skillnum']		=		1;
					$rewardjob['skillname']		=		'不限';
				}
			}else{
				$data['error']	=	2;
				$data['msg']	=	'相关职位不存在';
			}
		}
		$this->render_json($data['error'],$data['msg'],$rewardjob);
	}

    /**
     * 赏金职位列表
     */
	function rewardList_action(){
        
        $_POST['keyword']	=   $this->stringfilter($_POST['keyword']);
		
		$limit				=	$_POST['limit']?$_POST['limit']:20;
		
		$page  				=  	$_POST['page'];
		
		$where	=	array(
			'rewardpack'=>	'1',
			'r_status'	=>	'1',
			'state'		=>	'1',
			'status'	=>	'0',
			'name'		=>	array('like',$_POST['keyword']),
			'orderby' 	=> 	'lastupdate,desc'
		);
		// 处理分站查询条件
		if (!empty($_POST['did'])){
		    
		    $domain  =  $this->getDomain($_POST['did'], true);
		    
		    if (isset($domain['didcity'])){
		        
		        if (!empty($domain['provinceid'])){
		            $where['provinceid']  =  $domain['provinceid'];
		        }
		        if (!empty($domain['cityid'])){
		            $where['cityid']  =  $domain['cityid'];
		        }
		        if (!empty($domain['three_cityid'])){
		            $where['three_cityid']  =  $domain['three_cityid'];
		        }
		    }
		    if (isset($domain['didhy'])){
		        
		        if (!empty($domain['hyclass'])){
		            $where['hy']  =  $domain['hyclass'];
		        }
		    }
		}
		if($page){
			$pagenav		=	($page-1)*$limit;
			
			$where['limit']	=	array($pagenav,$limit);
		}else{
			$where['limit']	=	$limit;
		}
        
        $packM 		= 	$this->MODEL('pack');
		
        $rows 		= 	$packM->getRewardJobWxList($where);
		
        if($rows&&is_array($rows)){
            
            $data['error']  =   1;
			
            $data['list']   =   count($rows) ? $rows : array();
			
        }else{
            
            $data['error']  =   2;
        }
        $this->render_json($data['error'],'',$data);
        
    }

    /**
     * 分享赚赏金职位列表
     */
    function share_action(){

		$where['orderby']	=	'lastupdate,desc';
		
		if ($_POST['limit']){
		    $limit				=	$_POST['limit'];
		    if($_POST['page']){//分页
		        $pagenav		=	($_POST['page']-1)*$limit;
		        $where['limit']	=	array($pagenav,$limit);
		    }else{
		    	$where['limit']	=	$limit;
		    }
		}
		
		$packM 		= $this->MODEL('pack');
		$shareJob 	= $packM->getShareJob($where);
		
		$this->render_json(0,'ok',$shareJob);
	}


    /**
     * 分享赚赏金职位详情
     */
    function shareshow_action()
    {
		
		$packM  = $this->MODEL('pack');
		$shareJobOne = $packM->getShareJobOne($_POST['id']);
		
		if(empty($shareJobOne)){
			$this->render_json(1,'没有红包职位信息');
		}else{
			
		    if (!empty($_POST['uid']) && !empty($_POST['token'])){
		        
		        $member    =  $this->yzToken($_POST['uid'], $_POST['token']);
		        
		    }
		    //分享赏金发放
		    if (!empty($_POST['fx'])){
		        $fx   =  $_POST['fx'];
		        $userInfoM  =  $this->MODEL('userinfo');
		        $fxm     =  $userInfoM->getInfo(array('uid'=>$fx['uid']),array('field'=>'`uid`,`username`,`usertype`,`password`,`salt`,`wxopenid`'));
		        $mdtoken  =  md5($fxm['username'].$fxm['password'].$fxm['salt'].$fxm['usertype']);
		        
		        if($fx['token'] == $mdtoken && !empty($fxm['wxopenid'])){
		            
		            $packM->shareJobLook($shareJobOne,$fxm['uid'],$fxm['wxopenid']);
		        }
		    }
		    
			$data['list']           =  count($shareJobOne) ? $shareJobOne : array();
			$data['job_name']		=  $shareJobOne['name'];//职位名称
			$data['company_name']	=  $shareJobOne['com_name'];//公司名称
			$data['job_desc']		=  $this->GET_content_desc($shareJobOne['description']);//描述
			// app用分享数据
			if (!empty($_POST['lsb'])){
			    
			    $data['wapurl']         =  Url('wap',array('c'=>'reward','a'=>'shareshow','id'=>$shareJobOne['id']));
			    
			    $companyM  =  $this->MODEL('company');
			    $com       =  $companyM->getInfo($shareJobOne['uid'],array('field'=>'`logo`,`logo_status`','logo'=>1));
			    $data['imageUrl']  =  $com['logo'];
			}
			$data['cuswitch']   =  $this->config['sy_user_change'];
			$this->render_json(0,'ok',$data);
		}
	}

    /**
     * 快速申请职位页面数据获取
     */
	function jobapply_action(){
		$data['resume_create_exp']		=	$this->config['resume_create_exp'];
		$data['resume_create_edu']		=	$this->config['resume_create_edu'];
		$data['resume_create_project']	=	$this->config['resume_create_project'];
		$data['expcreate']				=	$this->config['expcreate'];
		$data['educreate']				=	$this->config['educreate'];
		$data['reg_pw_sp']		        =	$this->config['reg_pw_sp'];
		$data['reg_pw_zm']		        =	$this->config['reg_pw_zm'];
		$data['reg_pw_num']	            =	$this->config['reg_pw_num'];
		$data['code_web']               =   strpos($this->config['code_web'],'注册会员')!==false ? true : false;
		$data['code_kind']              =   $this->config['code_kind'];

		if ($this->config['sy_msg_isopen'] == 1 && $this->config['reg_real_name_check'] == 1 && $this->config['sy_msg_regcode'] == 1){
		    $data['isSMSVer']           =   1;
        }else{
            $data['isSMSVer']           =   0;
        }
        $data['resumename'] = !empty($this->config['sy_resumename_num']) ? $this->config['sy_resumename_num'] : 0;
		$this->render_json(0,'',$data);
	}
	//快速申请职位入口
	function temporaryresume_action(){
		$userinfoM	=	$this->MODEL("userinfo");
		$companyM	=	$this->MODEL("company");
		$noticeM 	= 	$this->MODEL('notice');
		$jobM		=	$this->MODEL('job');
		$resumeM	=	$this->MODEL("resume");
		$ismoblie	= 	$userinfoM->getMemberNum(array("moblie"=>$_POST['telphone']));
		if($ismoblie>0){
			$this->render_json(2,'当前手机号已被使用，请更换其他手机号！');
		}else{
            $res = true;
            if ($this->config['sy_msg_isopen'] == 1 && $this->config['reg_real_name_check'] == 1 && $this->config['sy_msg_regcode'] == 1){

                if (!$_POST['checkcode']) {
                    $this->render_json(2, '请输入短信验证码！');
                }
                $cert_arr = $companyM->getCertInfo(array('check' => $_POST['telphone'], 'type' => 2, 'orderby' => 'ctime,desc'), array('`ctime`,`check2`'));
                if (is_array($cert_arr)) {
                    $checkTime = $noticeM->checkTime($cert_arr['ctime']);
                    if ($checkTime) {

                        if (trim($_POST['checkcode']) == $cert_arr['check2']) {
                            $res = true;
                        } else {
                            $this->render_json(6, '短信验证码错误！');
                        }
                        $udata['moblie_status'] = 1;
                    } else {
                        $data['error'] = 5;
                        $this->render_json(5, '验证码验证超时，请重新点击发送验证码！');
                    }
                } else {
                    $this->render_json(5, '验证码发送不成功，请重新点击发送验证码！');
                }
            }
    		$pwmsg = regPassWordComplex($_POST['password']);
			if($pwmsg){
				$this->render_json(5,$pwmsg);
			}
			
			if($res){
				$salt 	= 	substr(uniqid(rand()), -6);
				$pass 	= 	passCheck($_POST['password'],$salt);
				$ip		=	fun_ip_get();
				
				if ($_POST['provider'] == 'weixin'){
				    $source  =  14;
				}elseif ($_POST['provider'] == 'app'){
				    $source  =  15;
				}elseif ($_POST['provider'] == 'baidu'){
				    $source  =  19;
				}elseif ($_POST['provider'] == 'toutiao'){
				    $source  =  22;
				}
				$mdata	=	array(
					'username'	=>	$_POST['telphone'],
					'password'	=>	$pass,
					'usertype'	=>	1,
					'status'	=>	$this->config['user_state'],
					'salt'		=>	$salt,
					'reg_date'	=>	time(),
					'login_date'=>	time(),
					'reg_ip'	=>	$ip,
					'login_ip'	=>	$ip,
				    'source'	=>	$source,
					'moblie'	=>	$_POST['telphone'],
				    'did'		=>	!empty($_POST['did']) ? $_POST['did'] : $this->config['did'],
				    'clientid'  =>   isset($_POST['clientid']) ? $_POST['clientid'] : '',
				    'deviceToken'=>   isset($_POST['deviceToken']) ? $_POST['deviceToken'] : ''
				);
				// 手机号绑定同步member表
				if (!empty($udata['moblie_status'])){
				    $data['moblie_status']  =  $udata['moblie_status'];
				}
				$deflogo    =  $resumeM->deflogo(array('sex'=>$_POST['sex']));

	            if($deflogo!=''){
	                $udata['photo'] = $deflogo;
	                $udata['defphoto'] = 2;
	                $udata['photo_status'] = 1;
	            }
				$udata['lastupdate']	=	time();
				$sdata	=	array(
					"resume_num"	=>	"1",
				    "did"			=>	!empty($_POST['did']) ? $_POST['did'] : $this->config['did']
				);
				$udata['r_status']	=	$this->config['user_state'];
				$userid	=	$userinfoM->addInfo(array('mdata'=>$mdata,'udata'=>$udata,'sdata'=>$sdata));
				if($userid['error']){
					$data['msg']	=	$userid['msg'];
					$data['error']	=	2;
					$this->render_json($data['error'],$data['msg']);
				}
			}
			if(intval($userid)){
				$token 			=	md5($_POST['telphone'].$pass.$salt.'1');
				$data['user']	=	array('uid'=>$userid,'usertype'=>'1','token'=>$token);
				//简历基本信息数据
				$rData = array(
					'name' 		=> $_POST['uname'],
					'sex' 		=> $_POST['sex'],
					'birthday' 	=> $_POST['birthday'],
					'edu' 		=> $_POST['edu'],
					'exp' 		=> $_POST['exp'],
					'telphone' 	=> $_POST['telphone'],
					'login_date'=> time()
				);
				//简历求职意向数据
				include PLUS_PATH."user.cache.php";
				include PLUS_PATH."job.cache.php";
				
				$jobid	  =	(int)$_POST['jobid'];
				$jobfield = '`com_name`,`name`,`uid`,`is_link`,`is_email`,`hy`,`job1`,`job1_son`,`job_post`,`provinceid`,`cityid`,`three_cityid`,`minsalary`,`maxsalary`';
				$comjob	  =	$jobM->getInfo(array('id'=>$jobid),array('field'=>$jobfield));
				
				if ($comjob['job_post']) {
				    $job_classid	=	$comjob['job_post'];
				} elseif ($comjob['job1_son']) {
				    $job_classid	=	$comjob['job1_son'];
				} else {
				    $job_classid	=	$comjob['job1'];
				}
				if ($comjob['three_cityid']){
				    $city_classid	=	$comjob['three_cityid'];
				}elseif($comjob['cityid']){
				    $city_classid	=	$comjob['cityid'];
				}else{
				    $city_classid	=	$comjob['provinceid'];
				}
				
				$eData = array(
				    'lastupdate' 	=> time(),
				    'height_status' => 0,
				    'uid' 			=> $userid,
				    'ctime' 		=> time(),
				    'name' 			=> $job_name[$job_classid],
				    'hy' 			=> $comjob['hy'],
				    'job_classid' 	=> $job_classid,
				    'city_classid' 	=> $city_classid,
				    'minsalary' 	=> $comjob['minsalary'],
				    'maxsalary' 	=> $comjob['maxsalary'],
					'type' 			=> $userdata['user_type'][0],
					'report' 		=> $userdata['user_report'][0],
					'jobstatus' 	=> $userdata['user_jobstatus'][0],
					'state' 		=> $this->config['user_state']==1 ? $this->config['resume_status']:0,
					'r_status' 		=> $this->config['user_state'],
					'edu' 			=> $_POST['edu'],
					'exp' 			=> $_POST['exp'],
					'sex' 			=> $_POST['sex'],
					'birthday' 		=> $_POST['birthday'],
					'source' 		=> $source,
					'sq_jobid'		=> $jobid
				);

				$parr = array();
				foreach ($_POST as $pk => $pv) {
				    if(strpos($pk,'_')!=false){
				        $parr	=	@explode('_', $pk);
				        if(count($parr)>1){
				            $_POST[$parr[0]][$parr[1]]	=	$pv;
				        }
				    }
				}
				//简历工作经历数据
				$workData = array();
				if ($this->config['resume_create_exp'] == '1' && $_POST['iscreateexp'] ==1) {
				    for ($i=0; $i < count($_POST['workname']); $i++) {
				        $workData[$i]   =   array(
				            'uid'       =>  $userid,
				            'name'      =>  $_POST['workname'][$i],
				            'sdate'     =>  strtotime($_POST['worksdate'][$i]),
				            'edate'     =>  $_POST['totoday'][$i] ? 0 : $_POST['workedate'][$i] ? strtotime($_POST['workedate'][$i]) : 0,
				            'title'     =>  $_POST['worktitle'][$i],
				            'content'   =>  $_POST['workcontent'][$i]
				        );
				    }
				}
				//简历教育经历数据
				$eduData = array();
				if ($this->config['resume_create_edu'] == '1' && $_POST['iscreateedu'] == 1) {
				    for ($i=0; $i < count($_POST['eduname']); $i++) {
				        $eduData[$i]    =   array(
				            'uid'       =>  $userid,
				            'name'      =>  $_POST['eduname'][$i],
				            'sdate'     =>  strtotime($_POST['edusdate'][$i]),
				            'edate'     =>  strtotime($_POST['eduedate'][$i]),
				            'specialty'   =>  $_POST['specialty'][$i],
				            'education'   =>  $_POST['eduid'][$i]
				        );
				    }
				}
				//简历项目经历数据
				$proData = array();
				if ($this->config['resume_create_project'] == '1' && $_POST['iscreatepro'] == 1) {
				    for ($i=0; $i < count($_POST['projectname']); $i++) {
				        $proData[$i]    =   array(
				            'uid'       =>  $userid,
				            'name'      =>  $_POST['projectname'][$i],
				            'sdate'     =>  strtotime($_POST['projectsdate'][$i]),
				            'edate'     =>  strtotime($_POST['projectedate'][$i]),
				            'title'     =>  $_POST['projecttitle'][$i],
				            'content'   =>  $_POST['projectcontent'][$i]
				        );
				    }
				}
				$addArr	= 	array(
					'uid' 		=> $userid,
					'rData' 	=> $rData,
					'eData' 	=> $eData,
					'workData' 	=> $workData,
					'eduData' 	=> $eduData,
					'proData' 	=> $proData,
					'utype' 	=> 'user'
				);

				$return	= 	$resumeM->addInfo($addArr);
				if($return['errcode']!=9){
					$data['error']	=	2;
					$this->render_json($data['error'],$return['msg']);
				}

				$token                  =       md5($mdata['username'].$pass.$salt.'1');
    			$data['user']			=		array('uid'=>$userid,'usertype'=>1,'token'=>$token);

				if($return['id']){
					
					$eid	=	$return['id'];
					
					if($this->config['user_state']!="1" && $this->config['sy_shresume_applyjob']!=1){
						$data['msg']	=	'您的账号需要通过审核，才能投递简历哦！';
						$data['error']	=	3;
						$data['jobid']	=	(int)$_POST['jobid'];
						$this->render_json($data['error'],$data['msg'],$data);
					}
					if(!$this->config['resume_status'] && $this->config['sy_shresume_applyjob']!=1){
						$data['msg']	=	'您的简历需要通过审核，才能投递简历哦！';
						$data['error']	=	3;
						$data['jobid']	=	(int)$_POST['jobid'];
						$this->render_json($data['error'],$data['msg'],$data);
					}
					if($this->config['user_sqintegrity']){
						$expect	=	$resumeM->getExpect(array('id'=>$eid),array('field'=>'`integrity`'));
						if($this->config['user_sqintegrity']>$expect['integrity']){
							$data['msg']	=	'该简历完整度未达到'.$this->config['user_sqintegrity'].'%，请先完善简历！';
							$data['error']	=	4;
							$data['eid']	=	$eid;
							$this->render_json($data['error'],$data['msg'],$data);
						}
					}
					$value	=	array(
						'job_id'	=>	$jobid,
						'com_name'	=>	$comjob['com_name'],
						'job_name'	=>	$comjob['name'],
						'com_id'	=>	$comjob['uid'],
						'uid'		=>	$userid,
						'eid'		=>	$eid,
						'resume_state'=>$eData['state'],
						'datetime'	=>	time()
					);
					$nid  =  $jobM->addSqJob($value, array('comjob'=>$comjob));
					$resumeM->updateExpect(array('sq_jobid'=>''),array('id'=>$eid));
					$data['msg']	=	'申请成功！';
					$data['error']	=	1;
					$data['jobid']	=	$jobid;
					$this->render_json($data['error'],$data['msg'],$data);
				}else{
					$data['msg']	=	'保存失败！';
					$data['error']	=	7;
					$this->render_json($data['error'],$data['msg']);
				}
			}
		}
	}

    /**
     * 职位详情-我要提问
     */
  	function savereply_action(){
		$msgM				=	$this -> MODEL('msg');
		  
		$member   			=  	$this -> yzToken($_POST['uid'],$_POST['token']);
		  
		$_POST				=	$this -> post_trim($_POST);
		  
		$_POST['uid']		=	$member['uid'];
		
		$_POST['username']	=	$member['username'];
		
		$_POST['usertype']	=	$member['usertype'];

		
		$res				=	$msgM -> addMsg($_POST, 'auto');
		
		$this->render_json($res['error'],$res['msg']);
  	}

  	/**
  	 * 职位详情-投递简历
  	 */
	function index_ajaxjob_action(){

        $JobM	=	$this->MODEL('job');

		$arr	=	array();
		
		$error	=	2;
		
		$member =  	$this -> yzToken($_POST['uid'],$_POST['token']);

		if(empty($_POST['jobid'])){

			$msg		=	'参数错误，请重试！';

		}else if($member['usertype'] != 1){
			
			$msg		=	'请登录个人用户！';
		}else{
			
			 
			$jobid			=	intval($_POST['jobid']);
			 
			$sqJobNum		=	$JobM -> getSqJobNum(array('uid' => $member['uid'],'isdel'=>9,'job_id' => $jobid));
			
			
			if($sqJobNum > 0){	//已投递过

				$msg	=	'您已申请过该职位！';
			}else{

				$yqmsNum	=	$JobM -> getYqmsNum(array('uid' => $member['uid'], 'jobid' => $jobid,'isdel'=>9));
				
				if($yqmsNum > 0){
					
					$msg	=	'该职位已邀请您面试，无需再投简历！';
				}else{
					$ResumeM	=	$this -> MODEL('resume');
			
					$resumeWhere = array(
				 		'uid'	 	=> $member['uid'], 
				 		'r_status' 	=> 1, 
				 		'orderby' 	=> 'defaults, desc'
				 	);
				 	
					if($this->config['sy_shresume_applyjob']=='1'){
				 		$resumeWhere['PHPYUNBTWSTART']  =  '';
			            $resumeWhere['state'][]         =  array('=',1);
			            $resumeWhere['state'][]         =  array('=',0,'OR');
			            $resumeWhere['PHPYUNBTWEND']    =  '';
				 	}else{
				 		$resumeWhere['state'] = 1;
				 	}

					$resumeList	=	$ResumeM -> getSimpleList($resumeWhere, array('field' => '`id`,`name`,`defaults`'));

					if(!empty($resumeList)){

						$error		=	1;
						
						$arr['resumeList']	=	$resumeList;

					}else{

						$resuemNum		=	$ResumeM -> getExpectNum(array('uid' => $member['uid']));

						if(intval($resuemNum) > 0){
							$msg  =  '您的简历尚未完成审核，请联系管理员加快审核进度！';
						}else{
						    $msg  =  '您还没有简历，请先创建简历';
						}
					}
				}
			}
		}
		$this->render_json($error,$msg,$arr['resumeList']);
	}

    /**
     * 我要提问-热门问题
     */
	function getHotIssues_action(){
        $cacheM = $this->MODEL('cache');
        $com = $cacheM->GetCache('com');
        $data = [];
        if(!empty($com['comdata']['hot_issues'])){
            $hot_issues = $com['comdata']['hot_issues'];
            $comclass_name = $com['comclass_name'];
            foreach ($hot_issues as $val){
                $data['list'][] = $comclass_name[$val];
            }
        }
        $this->render_json(0, '', $data);
    }
    /**
     * 简历竞争力
     */
    function compete_action()
    {
        if (!empty($_POST['uid']) && !empty($_POST['token'])){
            
            $member    =  $this->yzToken($_POST['uid'], $_POST['token']);
        }
        if ($_POST['id']) {
            
            $competeM   =   $this->MODEL('compete');
            
            $List       =  $competeM->userJob($member['uid'], (int) $_POST['id'], $member['usertype']);
            
            $error		=	1;
            $msg		=	'';
            if($List['errcode'] == '2'){
                $error  =	0;
                $msg 	= 	'行业招聘较少，暂无足够样本用于数据分析！';
            }
            
            $this->render_json($error,$msg, $List);
        }
    }
    // 获取职位联系方式
    function getLink_action(){
        
        $member  =  $this->yzToken($_POST['uid'], $_POST['token']);
        
        $JobM    =  $this->MODEL('job');
        $link	 =  $JobM->getCompanyJobTel(array('id'=>$_POST['jobid'],'uid'=>$member['uid'],'usertype'=>$member['usertype'],'isgetprv'=>$this->config['sy_comprivacy_open']));
        
        $this->render_json(0,'ok', $link);
    }
}
?>