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
class company_controller extends wxapp_controller{
	/**
	 * 企业列表
	 */
	function list_action(){

		$where['name']		=	array('<>','');
		$where['r_status']	=	1;
	    if ($_POST['keyword']!='undefined'){
		    $keyword		=	$this->stringfilter($_POST['keyword']);
		}
		$page				=	$_POST['page'];
		$limit				=	$_POST['limit'];
		$order				=	$_POST['order'];
		$nodata				=	$_POST['nodata'];
		$provinceid			=	(int)$_POST['provinceid'];
		$cityid				=	(int)$_POST['cityid'];
		$three_cityid		=	(int)$_POST['three_cityid'];
		$hy					=	(int)$_POST['hy'];
		$pr					=	(int)$_POST['pr'];
		$mun				=	(int)$_POST['mun'];
		$rec				=	(int)$_POST['rec'];
		
		$limit	=	!$limit ? 10 : $limit;
		if($hy){//类别ID
			$where['hy']			=	$hy;
		}
		if($provinceid){//类别ID
			$where['provinceid']	=	$provinceid;
		}
		if($cityid){//类别ID
			$where['cityid']		=	$cityid;
		}
		if($three_cityid){//类别ID
			$where['three_cityid']	=	$three_cityid;
		}
		if($keyword){//关键字
			$where['name']			=	array('like',$keyword);
		}
		if($rec==1){//名企
			$where['rec']			=	1;
			$where['hottime']		=	array('>',time());
		}
		if($pr){//企业性质
			$where['pr']			=	$pr;
		}
		if($mun){//企业规模
			$where['mun']			=	$mun;
		}
		if($nodata){//排除没有值的字段
			$nodataarr				=	explode(",",$nodata);
			foreach($nodataarr as $v){
				$where[$v]			=	array('<>','');
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
		        $data['didhy']  =  $domain['didhy'];
		        $data['hy']     =  !empty($domain['hyclass']) ? $domain['hyclass'] : 0;
		        $data['hydata'] =  $domain['hydata'];
		    }
		}else{
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
		if($order){//排序
			$where['orderby']		=	$order;
		}else{
			$where['orderby']		=	'`lastupdate`,desc';
		}
		if($page){//分页
			$pagenav				=	($page-1)*$limit;
			$where['limit']			=	array($pagenav,$limit);
		}else{
			$where['limit']			=	$limit;
		}

		$ComM    =   $this -> MODEL('company');
		
		$field   =  '`uid`,`name`,`shortname`,`logo`,`logo_status`,`yyzz_status`,`hotstart`,`hottime`,`provinceid`,`cityid`,`three_cityid`,`pr`,`rating`,`mun`';
		
		$rows    =  $ComM -> getList($where,array('field'=>$field,'utype'=>'wxapp','logo'=>1));
		
		$list	 =	 $rows['list'];
		$data['list']	 =	 count($list) ? $list : array();
		// 小程序用seo
		if (isset($_POST['provider'])){
			if ($_POST['provider'] == 'baidu' || $_POST['provider'] == 'weixin' || $_POST['provider'] == 'toutiao'){
				$seo            =  $this->seo('firm','','','',false, true);
				$data['seo']    =  $seo;
			}
		}
		$this	->	render_json(0,'',$data);	
		
	}
	//获取企业信息
	function show_action()
	{
	    
		$cuid		=	(int)$_POST['id'];
		
        $companyM   =   $this -> MODEL('company');
        $row        =   $companyM -> getInfo($cuid, array('logo' => '1','utype'=>'wxapp'));

        $msg		=	'';
        if (empty($_POST['uid']) || (!empty($_POST['uid']) && $_POST['uid'] != $cuid)){
            
            if (!is_array($row)) {
                
                $msg	=	'没有找到该企业！';
                
            } elseif ($row['r_status'] == 0) {
                
                $msg	=	'该企业正在审核中，请稍后查看！';
                
            } elseif ($row['r_status'] == 3) {
                
                $msg	=	'该企业未通过审核！';
                
            } elseif ($row['r_status'] == 2) {
                
                $msg	=	'该企业暂被锁定，请稍后查看！';
            }
        }

        if($msg!=''){
        	$this->render_json(2,$msg);
        }


        $linkphone  =   explode('-', $row['linkphone']);
        
        if (strlen($linkphone[0]) == 4) {
            
            $row['callphone']   =   $linkphone[0] . $linkphone[1];
            
        } else if (strlen($linkphone[0] > 8)) {
            
            $row['callphone']   =   substr($row['linkphone'], 0, 12);
            
        } else {
            
            $row['callphone']   =   $row['linkphone'];
            
        }
        
		if ($row['infostatus'] == '2') {
            
            $row['linkphone'] = $row['linktel'] = $row['linkmail'] = $row['linkqq'] = '';
            
        }

        
        if(!empty($row['x']) && !empty($row['y'])){
            $coordinates		=	$this->Convert_BD09_To_GCJ02($row['x'],$row['y']);
            $row['x']			=	$coordinates['lng'];
            $row['y']			=	$coordinates['lat'];
        }
        if (!empty($row['content'])){
            
            $row['content'] = $this->preghtml($row['content']);
        }
        
		$data['info']		=	count($row) ? $row : array();
		
		if (isset($_POST['provider'])){
		    // app用分享数据
		    if ($_POST['provider'] == 'app'){
		        
		        $data['shareData']  =  array(
		            'url'       =>  Url('wap',array('c'=>'company','a'=>'show','id'=>$cuid)),
		            'title'     =>  $row['name'],
		            'summary'   =>  mb_substr(strip_tags($row['content']), 0,30,'UTF8'),
		            'imageUrl'  =>  $row['logo']
		        );
		    }
		    // 小程序用seo
		    if ($_POST['provider'] == 'baidu' || $_POST['provider'] == 'weixin' || $_POST['provider'] == 'toutiao'){
		        $seodata['company_name']       =   $row['name'];
		        $seodata['company_name_desc']  =   $row['content'];
		        $this->data		=   $seodata;
				$seo            =  	$this->seo('company_index','','','',false, true);
				$data['seo']    =  	$seo;
		    }

			if ($_POST['provider'] != 'baidu' && $_POST['provider'] != 'toutiao' && $this->config['sy_haibao_isopen'] == 1){
				$WhbM       =   $this->MODEL('whb');
				$JobM       =   $this -> MODEL('job');
				$maxNum     =   $JobM->getJobNum(array('state' => 1, 'status' => 0, 'r_status' => 1, 'uid' => $cuid));
				$syComHb    =   $WhbM->getWhbList(array('type' => 2, 'isopen' => '1', 'num' => array('<=', $maxNum)));
				if(!empty($syComHb)){
					$hbids = array();
					foreach ($syComHb as $ck => $cv) {
						$hbids[] = $cv['id'];
					}
					$data['hbids'] = $hbids;
				}
			}
			$data['hbids']  =  !empty($hbids) ? $hbids : array();
			$data['hbNum']  =  count($data['hbids']);
			$data['ishb']  	=  $this->config['sy_haibao_isopen'] == 1 ? true : false;
            $data['com_msg_status'] = $this->config['com_msg_status'];
		}
		$this->render_json(0,'',$data);
	}
	/**
	 * 企业详情页-其他数据
	 */
	function comShowOther_action(){

	    $info  =  array();
	    $uid   =  $usertype  =  '';
	    $cuid  =  (int)$_POST['id'];
	    
	    if (!empty($_POST['uid']) && !empty($_POST['token'])){
	        
	        $member    	=  	$this->yzToken($_POST['uid'], $_POST['token']);
	        $uid	    =	$member['uid'];
	        $usertype	=	$member['usertype'];
	        if ($member['usertype'] == 1){
	            
	            $atnM   =   $this -> MODEL('atn');
	            $isatn  =   $atnM -> getAtnInfo(array('uid' => $uid, 'sc_uid' => $cuid , 'sc_usertype'=>2));
	            
	            $data['isatn']	= !empty($isatn) ? 1 : 0;
	        }
	    }
	    $companyM	=	$this -> MODEL('company');

		$companyM  -> upInfo($cuid, '', array('hits'=>array('+',1), 'expoure' => array('+', 1)));
	    // 企业环境
	    $show		=   $companyM -> getCompanyShowList(array('uid'=>$cuid,'status'=>0));
	    
	    $info['show']  =  count($show) > 0 ? $show : array();
	    //联系方式
	    $jobM       =  $this -> MODEL('job');
	    $link		=  $jobM->getCompanyTel(array('com_id'=>$cuid,'uid'=>$uid,'usertype'=>$usertype));
	    
	    $info['link']  =  $link;
	    // 会员等级图标
	    $statisM    =   $this -> MODEL('statis');
	    $statis     =   $statisM -> getInfo($cuid, array('usertype' => '2', 'field' => '`rating`'));
	    $ratingM    =   $this -> MODEL('rating');
	    $comrat     =   $ratingM -> getInfo(array('id'=> intval($statis['rating'])), array('pic'=>'1'));
	    
	    if ($comrat['com_pic']!="0" && $comrat['com_pic']!=""){
	        $info['com_pic']	=	$comrat['com_pic'];
	    }else{
	        $info['com_pic']  =  '';
	    }
	    //面试评价
	    $pjlist = $avgArr = array();
	    if ($this->config['com_msg_status'] == 1){
	        $msgwhere['status']	=	1;
	        $msgwhere['cuid']	=	$cuid;
	        $msgwhere['limit']	=   3;
	        $msgwhere['orderby']	=	'ctime,desc';
	        $msglist			=	$companyM->getCompanyMsgList($msgwhere);
	        $avg				=	$companyM->getCompanyMsgInfo(array('cuid'=>$cuid,'status'=>1),array('field'=>'count(*) as num,AVG(score) as score,AVG(desscore) as desscore,AVG(comscore) as comscore,AVG(hrscore) as hrscore'));
	        $avgArr 			= 	array('num'=>$avg['num'],'score'=>round($avg['score'],1),'desscore'=>round($avg['desscore'],1),'hrscore'=>round($avg['hrscore'],1),'comscore'=>round($avg['comscore'],1));
	    }
	    $data['avgArr']		=	count($avgArr) ? $avgArr : array();
	    $data['msglist']	=	count($msglist) ? $msglist : array();
	    $data['chatOpen']	=	$this->config['sy_chat_open'];
	    $data['chat_name']  =   $this->config['sy_chat_name'] ? $this->config['sy_chat_name'] : '';
	    $data['info']       =   $info;

	    include(CONFIG_PATH.'db.data.php');
	    // 根据是否有猎头模块，来确定是否有子账号功能
	    $sy_son = isset($arr_data['modelconfig']['lietou']) ? 1 : 2;
	    //部门数据/子账号
	    if ($sy_son == 1){
	        $CompanyaccountM	=   $this -> MODEL('companyaccount');
	        
	        $departmentList		=	$CompanyaccountM -> getList(array('comid'=>$cuid),array('field'=>'`name`,`uid`'));
	        $departments		=	array();
	        $zuids				=	array();
	        $departmentjobs		=	$jobM -> getList(array('uid'=>intval($cuid),'status'=>'0','state'=>'1','r_status'=>1),array('field'=>'`zuid`'));
	        foreach($departmentjobs['list'] as $dk=>$dv){
	            if($dv['zuid']){
	                $zuids[]	=	$dv['zuid'];
	            }
	        }
	        
	        foreach($departmentList as $key=>$v){
	            if(in_array($v['uid'], $zuids)){
	                $departments[$key]['name']	=	$v['name'];
	                $departments[$key]['uid']	=	$v['uid'];
	            }
	        }
	        $data['departments'] = $departments;
	    }
	    
	    if(!empty($tycres['content'])){
	        $data['comGsInfo'] = $tycres['content'];
	    }
	    $data['ishb']  	=  $this->config['sy_haibao_isopen'] == 1 ? true : false;
	    $data['iosfk']	=  $this->config['sy_iospay'] ;
	    
	    $this->render_json(0,'',$data);
	}

	/**
	 * 企业详情-获取天严查数据
	 */
	function getBusinessInfo_action(){
		$cuid  =  (int)$_POST['id'];

		// 天眼查
		$companyM	=	$this -> MODEL('company');
		$comInfo  =  $companyM -> getInfo($cuid, array('field'=>'`name`'));
		$noticeM  =  $this->MODEL('notice');
		$tycres   =  $noticeM->getBusinessInfo($comInfo['name']);
		$data['comGsInfo'] = '';
		if(!empty($tycres['content'])){
			$data['comGsInfo'] = $tycres['content'];
		}

		$this->render_json(0,'',$data);
	}

	/**
	 * 面试评价列表
	 */
	function msg_action(){
		$companyM   =   $this -> MODEL('company');
		$msgwhere['status']	=	1;
		$msgwhere['cuid']	=	$_POST['id'];
		$page				=	$_POST['page'];
		if($_POST['limit']){
			$limit			=	$_POST['limit'];
			if($page){
				$pagenav		=	($page-1)*$limit;
				$msgwhere['limit']	=	array($pagenav,$limit);
			}else{
				$msgwhere['limit']	=	$limit;
			}
		}
		$msgwhere['orderby']	=	array('ctime,desc');
		$msglist			=	$companyM->getCompanyMsgList($msgwhere);
		$avg				=	$companyM->getCompanyMsgInfo(array('cuid'=>$_POST['id'],'status'=>1),array('field'=>'count(*) as num,AVG(score) as score,AVG(desscore) as desscore,AVG(comscore) as comscore,AVG(hrscore) as hrscore'));
		$avgArr 			= 	array('num'=>$avg['num'],'score'=>round($avg['score'],1),'desscore'=>round($avg['desscore'],1),'hrscore'=>round($avg['hrscore'],1),'comscore'=>round($avg['comscore'],1));
		$data['avgArr']		=	count($avgArr) ? $avgArr : array();
		$data['list']	=	$msglist;
		if(is_array($msglist) && !empty($msglist)){
			$data['msglist']	=	$msglist;
			$this->render_json(0,'ok',$data);
		}else{
			$error	=	2;
			$this->render_json($error);
		}
	}
    
}
?>
