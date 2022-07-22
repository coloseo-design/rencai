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
class spview_controller extends wxapp_controller{
    /**
     * 获取用户信息，并组装面试房间参数
     */
	function uinfo_action()
	{
	    $member  =  $this->yzToken($_POST['uid'], $_POST['token']);
	    
	    $trtcM   =  $this->MODEL('trtc');
	    $return  =  $trtcM->getTrcInfo(array('uid'=>$member['uid'], 'usertype'=>$member['usertype'], 'fuid'=>$_POST['fuid']), true, $_POST['provider']);
	    
	    $this->render_json(0, 'ok', $return);
	}

	//视频面试企业列表
	function list_action(){

		$_POST				=	$this -> post_trim($_POST);
		$spviewM			=	$this -> MODEL('spview');
		$page				=	$_POST['page'];
		$limit				=	$_POST['limit'] ? $_POST['limit'] : 10;
        
		$search['keyword']  =   $this->stringfilter($_POST['keyword']);
		$search['provinceid']=	(int)$_POST['provinceid'];
		$search['cityid']	=	(int)$_POST['cityid'];
		$search['three_cityid']=(int)$_POST['three_cityid'];
		$search['hy']		=	(int)$_POST['hy'];
		$search['pr']		=	(int)$_POST['pr'];
		$search['page']		=	$page;
		$search['limit']	=	$limit;
		$search['starttime']=	$_POST['starttime'];
		$search['order']	=	'1';
        
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
		            $search['hy']  =  $domain['hyclass'];
		        }
		        $data['didhy']  =  $domain['didhy'];
		        $data['hy']     =  !empty($domain['hyclass']) ? $domain['hyclass'] : 0;
		        $data['hydata'] =  $domain['hydata'];
		    }
		}
		
		$rows				=	$spviewM -> getList(array(),array('search'=>$search));
		
		if(is_array($rows) && !empty($rows)){
			
			$error	=	0;
		}else{
			$error	=	2;
		}
		$data['list']	=	count($rows) ? $rows : array();
		if (isset($_POST['provider'])){
		    // 小程序用seo
            if ($_POST['provider'] == 'baidu' || $_POST['provider'] == 'weixin' || $_POST['provider'] == 'toutiao'){
                $seo            =  $this->seo('spview','','','',false, true);
                $data['seo']    =  $seo;
            }
		}
		$this->render_json($error,'',$data);

	}

	//视频面试详情页
	function show_action(){

		if($_POST['id']){

			$id = (int)$_POST['id'];

			if($_POST['token']){
				$user		=	$this->yzToken((int)$_POST['uid'],$_POST['token']);
				$uid		=	$user['uid'];
				$usertype	=	$user['usertype'];
			}
			

    		$spviewM	=	$this->MODEL('spview');
			
			$spviewM -> upSpviewHits($id);

    		$spview		=	$spviewM->getInfo(array('id'=>$id));

    		$userinfoM	=	$this->MODEL('userinfo');

    		if(empty($spview)){

    			$msg	=	'没有找到该视频面试！';
    			$error	=	2;

			}else if($spview['status']!=1){

				$msg	=	'该视频面试尚未审核！';
    			$error	=	2;

			}else{

				$comid				=	$spview['uid'];
	    		$CompanyM			=   $this -> MODEL('company');
	    		$company     		=   $CompanyM -> getInfo($comid, array('logo' => '1'));
	    		
	    		if ($company['r_status'] == 0 || $company['r_status'] == 3) {
	    		    $msg	=	'企业暂未通过审核！';
	    		    $error	=	2;
	    		} elseif ($company['r_status'] == 2 || $company['r_status'] == 4) {
	    		    $msg	=	'企业已被锁定！';
	    		    $error	=	2;
	    		}else{
	    		    $jobM				=   $this -> MODEL('job');
	    		    
	    		    $spjobs				=	$jobM -> getList(array('id'=>array('in',$spview['jobid']),'uid'=>$comid,'status'=>'0','state'=>'1','r_status'=>1));
	    		    
	    		    $spview_sub			=	$spviewM -> getSubinfo(array('sid'=>$id,'uid'=>$uid), array('job'=>1));
	    		    
	    		    $stopTime			=	$spview['starttime'] - ($this->config['sy_spview_yytime'] * 3600);
	    		    
	    		    $data['stopTime']	=	$stopTime;
	    		    
	    		    $time				=	time();
	    		    
	    		    if($stopTime > 	$time){
	    		        
	    		        $second         	=   $stopTime-$time;
	    		        
	    		        $spview['day']     	=   floor($second/(3600*24));
	    		        
	    		        $second         	=   $second%(3600*24);
	    		        
	    		        $spview['hour']    	=   floor($second/3600);
	    		        
	    		        $second         	=   $second%3600;
	    		        
	    		        $spview['minute']  	=   floor($second/60);
	    		        
	    		        $spview['second']  	=   $second%60;
	    		        
	    		    }
	    		    
	    		    if($spview_sub){
	    		        // 已预约
	    		        if(time()>$spview['starttime']){
	    		            
	    		            $issub		=	2;
	    		            // 已面试
	    		            $mswhere		=	array(
	    		                'status'	=>	2,
	    		                'sid'		=>	$id
	    		            );
	    		            
	    		            $msnum		=	$spviewM -> getSubNum($mswhere);
	    		            
	    		        }else{
	    		            
	    		            $issub		=	1;
	    		            // 未开始
	    		        }
	    		        
	    		        $lineData		=	array(
	    		            'status'	=>	0,
	    		            'sid'		=>	$id,
	    		            'rtime'		=>	array('>',0)
	    		        );
	    		        
	    		        $linenum		=	$spviewM -> getSubNum($lineData);
	    		        
	    		    }else{
	    		        // 未预约
	    		        if(time()<=$stopTime){
	    		            
	    		            $issub		=	3;
	    		            // 可以预约
	    		        }elseif (time() <= $spview['starttime']){
	    		            // 停止预约，但未开始
	    		            $issub		=	4;
	    		            
	    		        }else{
	    		            // 已开始
	    		            $issub		=	5;
	    		        }
	    		        
	    		        $subnum	=	$spviewM -> getSubNum(array('sid'=>$id));
	    		        
	    		    }
	    		    
	    		    if($uid && $usertype==1){
	    		        
	    		        $ResumeM    =   $this->MODEL('resume');
	    		        $resumenum  =   $ResumeM->getExpectNum(array('uid'=>$uid,'status'=>1,'state'=>1,'r_status'=>1));
	    		        
	    		    }
	    		    
	    		    $week	=	$this->get_week($spview['starttime']);
	    		    
	    		    $data['issub']		=	$issub ? $issub : 1;
	    		    
	    		    $data['rnum']		=	$resumenum ? $resumenum : 0;
	    		    
	    		    $data['msnum']		=	$msnum ? $msnum : 0;
	    		    
	    		    $data['subnum']		=	$subnum ? $subnum : 0;
	    		    
	    		    $data['linenum']	=	$linenum ? $linenum : 0;
	    		    
	    		    $data['subinfo']	=	$spview_sub ? $spview_sub :array();
	    		    
	    		    $data['week']		=	$week;
	    		    
	    		    $data['spview']		=	$spview;
	    		    
	    		    $data['comname']	=	$company['name'];
	    		    
	    		    $data['spjobs']		=	count($spjobs['list']) ? $spjobs['list'] : array();
	    		    
	    		    if (isset($_POST['provider'])){
	    		        // app用分享数据
	    		        if ($_POST['provider'] == 'app'){
	    		            
	    		            $data['shareData']  =  array(
	    		                'url'       =>  Url('wap',array('c'=>'spview','a'=>'show','id'=>$id)),
	    		                'title'     =>  $company['name'],
	    		                'summary'   =>  '',
	    		                'imageUrl'  =>  $company['logo']
	    		            );
	    		        }
	    		        // 小程序用seo
	    		        if ($_POST['provider'] == 'baidu' || $_POST['provider'] == 'weixin' || $_POST['provider'] == 'toutiao'){
	    		            $seodata['company_name']       =   $company['name'];
	    		            $this->data		=   $seodata;
	    		            $seo            =  $this->seo('spview_show','','','',false, true);
	    		            $data['seo']    =  $seo;
	    		        }
	    		    }
	    		    $error				=	1;
	    		}
			}
    	}else{

    		$msg	=	'参数错误！';
    		$error	=	2;
		}

		$data['wx_qcode']  =  checkpic($this->config['sy_wx_qcode']);

		$this->render_json($error,$msg, $data);
	}
	//点击预约视频面试获取用户简历列表
	function index_ajaxspview_action(){

        $JobM	=	$this->MODEL('job');

		$arr	=	array();
		
		$error	=	2;
		
		$member =  	$this -> yzToken($_POST['uid'],$_POST['token']);

		if($member['usertype'] != 1){
			
			$msg		=	'请登录个人用户！';

		}else{
			
			$spviewM 		=	$this->MODEL('spview'); 

			$sid			=	intval($_POST['sid']);
			 
			$subNum			=	$spviewM -> getSubinfo(array('uid' => $member['uid'], 'sid' => $sid));
			
			
			if($subNum > 0){	//已投递过

				$msg	=	'您已预约过该面试！';
			}else{

				
				$ResumeM	=	$this -> MODEL('resume');
		
				$resumeList	=	$ResumeM -> getSimpleList(array('uid' => $member['uid'], 'r_status' => 1,'state' => 1, 'orderby' => 'defaults, desc'), array('field' => '`id`,`name`,`defaults`'));
				
				if(!empty($resumeList)){

					$error		=	1;
					
					$arr['resumeList']	=	$resumeList;

				}else{
					
					$resuemNum		=	$ResumeM -> getExpectNum(array('uid' => $member['uid']));

					if(intval($resuemNum) > 0){
						$msg		=	'您的简历尚未完成审核，请联系管理员加快审核进度！';
					}else{
						$msg		=	'您还没有合适的简历，请先添加简历';
					}
				}
				
			}
		}
		$this->render_json($error,$msg,$arr['resumeList']);
	}
	//视频面试预约
	function viewSub_action(){
		
		$user			=	$this->yzToken((int)$_POST['uid'],$_POST['token']);

		if(!empty($_POST['jobid'])){
			$spviewM	=	$this->MODEL('spview');
			
			$subData	=	array(
				'uid'		=>  $user['uid'],
				'usertype'	=>  $user['usertype'],
				'sid'		=>  $_POST['sid'],
				'did'		=>	$user['did'],
				'jobid'		=>	$_POST['jobid'],
				'port'		=>	$_POST['port']
			);
			
			$return		=	$spviewM->viewSub($subData);

		}else{
			
			$return['errcode']	=	1;
			
			$return['msg']		=	'请选择职位';
		}
		
		$this->render_json($return['errcode'],$return['msg'], $return);
		
	}
	//进入面试间
	function goRoom_action(){
        
        $user		=	$this->yzToken((int)$_POST['uid'],$_POST['token']);

        if($_POST['sid']){

			$where  =  array(
	            'uid'  =>  $user['uid'],
	            'sid'  =>  $_POST['sid']
	        );
	        
	        $spviewM=  $this->MODEL('spview');
	        $spviewM->updateSubcribe($where, array('rtime'=>time()));

	        $error	=	1;

        }else{

        	$error	=	2;
			$msg	=	'数据异常，请重试';
        }

        $this->render_json($error,$msg);
    }
	
    function get_week($date){
		//强制转换日期格式
		$date_str=date('Y-m-d',$date);
		//封装成数组
		$arr=explode("-", $date_str);
		//参数赋值
		//年
		$year=$arr[0];
		//月，输出2位整型，不够2位右对齐
		$month=sprintf('%02d',$arr[1]);
		//日，输出2位整型，不够2位右对齐
		$day=sprintf('%02d',$arr[2]);
		//时分秒默认赋值为0；
		$hour = $minute = $second = 0;
		//转换成时间戳
		$strap = mktime($hour,$minute,$second,$month,$day,$year);
		//获取数字型星期几
		$number_wk=date("w",$strap);
		//自定义星期数组
		$weekArr=array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
		//获取数字对应的星期
		return $weekArr[$number_wk];
	}
}
?>