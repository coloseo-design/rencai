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
class spview_controller extends common{
	function index_action(){

		$CacheM       =   $this -> MODEL('cache');

		$CacheList    =   $CacheM -> GetCache(array('city','com','hy','job'));

		$this         ->  yunset($CacheList);

		if (intval($_GET['three_cityid'])) {
            
            $this   ->   yunset('cityname', $CacheList['city_name'][intval($_GET['three_cityid'])]);
        }
        $searchUrlObj = array();
        foreach ($_GET as $k => $v) {
            
            if ($k != '') {
                
                $searchurl[] = $k.'='.$v;
                $searchUrlObj[$k]    = $v;
            }
        }
        
        $searchurl  =   @implode('&', $searchurl);
        $this->yunset('searchUrlObj',json_encode($searchUrlObj));
        $this -> yunset('searchurl', $searchurl);
        $this->yunset('topplaceholder', '请输入公司名称');
		$this->yunset("headertitle","视频面试");
		$this->seo("spview");
		$this->yuntpl(array('wap/spview'));
	}
	function show_action(){
		
		$this -> get_moblie();

		if($_GET['id']){

    		$spviewM	=	$this->MODEL('spview');
			
			$spviewM -> upSpviewHits($_GET['id']);

    		$spview		=	$spviewM->getInfo(array('id'=>$_GET['id']));

    		$userinfoM	=	$this->MODEL('userinfo');

    		if(empty($spview)){

    			$this -> ACT_msg_wap($_SERVER['HTTP_REFERER'], '没有找到该视频面试！');
			}else if($spview['status']!=1){

				$this -> ACT_msg_wap($_SERVER['HTTP_REFERER'], '该视频面试尚未审核！');
			}

    		$comid				=	$spview['uid'];
    		$CompanyM			=   $this -> MODEL('company');
    		$company     		=   $CompanyM -> getInfo($comid, array('logo' => '1'));
    		
    		if ($company['r_status'] == 0 || $company['r_status'] == 3) {
    		    $this->ACT_msg_wap($_SERVER['HTTP_REFERER'], '企业暂未通过审核！');
    		} elseif ($company['r_status'] == 2 || $company['r_status'] == 4) {
    		    $this->ACT_msg_wap($_SERVER['HTTP_REFERER'], '企业已被锁定！');
    		}
    		
			$jobM				=   $this -> MODEL('job');

			$spjobs				=	$jobM -> getList(array('id'=>array('in',$spview['jobid']),'uid'=>$comid,'status'=>'0','state'=>'1','r_status'=>1));

			$spview_sub			=	$spviewM -> getSubinfo(array('sid'=>$_GET['id'],'uid'=>$this->uid), array('job'=>1));

			$stopTime			=	$spview['starttime'] - ($this->config['sy_spview_yytime'] * 3600);
			$this->yunset("stopTime",$stopTime);
			if($spview_sub){
				// 已预约
			    if(time() > $spview['starttime'] || $spview_sub['status'] != 0){
					
					$issub		=	2;
					// 已面试
					$mswhere		=	array(
					    'status'	=>	2,
					    'sid'		=>	$_GET['id']
					);
					
					$msnum		=	$spviewM -> getSubNum($mswhere);
					$this->yunset("msnum",$msnum);
					
				}else{
					
					$issub		=	1;
					// 未开始
				}
				
				$lineData		=	array(
					'status'	=>	0,
					'sid'		=>	$_GET['id'],
				    'rtime'		=>	array('>',0)
				);
				
				$linenum		=	$spviewM -> getSubNum($lineData);
				
				$this->yunset("linenum",$linenum);
				
				$this->yunset("subinfo",$spview_sub);
				
			}else{
			    // 未预约
			    if(time()<=$stopTime){
			        // 可以预约
			        $issub		=	3;
			        
			    }elseif (time() <= $spview['starttime']){
			        // 停止预约，但未开始
			        $issub		=	4;
			        
			    }else{
			        // 已开始
			        $issub		=	5;
			    }
				$subnum	=	$spviewM -> getSubNum(array('sid'=>$_GET['id']));
				
				$this->yunset("subnum",$subnum);
			}
			
			$this->yunset("issub",$issub);
			$countDown  =  ($stopTime - time()) * 1000;
			$this->yunset('countDown',$countDown);
			
			if($this->uid && $this->usertype==1){

				$ResumeM    =   $this->MODEL('resume');
	            $resumenum  =   $ResumeM->getExpectNum(array('uid'=>$this->uid,'status'=>1,'state'=>1,'r_status'=>1));
	            $this->yunset('resumenum', $resumenum);

			}

			$week	=	$this->get_week($spview['starttime']);
			
			$this->yunset("week",$week);

			$this->yunset("spview",$spview);

			$this->yunset("comid",$comid);

			$this->yunset("com",$company);

			$this->yunset("spjobs",$spjobs['list']);

			$data	=   array('company_name'	=>	$company['name']);

			$this->data = $data;
		}
		
		$this->yunset("headertitle","视频面试详情");
		$this->seo("spview_show");
		$this->yuntpl(array('wap/spview_show'));
	}
	/**
	 * 个人有多简历，预约时要选择简历
	 */
	function ajaxResume_action(){
	    
	    $JobM	=	$this->MODEL('job');
	    
	    $arr	=	array();
	    
	    $arr['status'] = 2;
	    
	    if(!$this->uid || !$this->username || $this->usertype != 1){
	        
	        $arr['msg']		=	'请登录个人用户！';
	        
	    }else{
	        
	        $sid			=	intval($_POST['sid']);
	        
	        $spviewM 		=	$this->MODEL('spview');
	        $subNum			=	$spviewM -> getSubinfo(array('uid' => $this -> uid, 'sid' => $sid));
	        
	        if($subNum > 0){	//已投递过
	            
	            $arr['msg']	=	'您已预约过该视频面试！';
	            
	        }else{
	            
	            $ResumeM	=	$this -> MODEL('resume');
	            $resumeList	=	$ResumeM -> getSimpleList(array('uid' => $this -> uid, 'r_status' => 1, 'state' => 1, 'orderby' => 'defaults, desc'), array('field' => '`id`,`name`,`defaults`'));
	            
	            if(!empty($resumeList)){
	                
	                $arr['status']		=	1;
	                
	                $html  =  '';
	                
	                foreach($resumeList as $key=>$val){
	                    if($val['defaults']==1){
	                        $html .=  "<div class='job_prompt_sendresume_list job_prompt_sendresume_list_cur' id='resume_$val[id]' data_did='$val[id]' onclick='viewsubclic($val[id]);'><i class='job_prompt_sendresume_radio'></i><i class='job_prompt_sendresume_radio_q'></i>$val[name](默认简历)</div>";
	                    }else{
	                        $html .=  "<div class='job_prompt_sendresume_list' id='resume_$val[id]' data_did='$val[id]' onclick='viewsubclic($val[id]);'><i class='job_prompt_sendresume_radio'></i><i class='job_prompt_sendresume_radio_q'></i>$val[name]</div>";
	                    }
	                }
	                
	                $arr['html']  =  $html;
	                
	            }else{
	                
	                $resuemNum    =	 $ResumeM -> getExpectNum(array('uid' => $this -> uid));
	                
	                if(intval($resuemNum) > 0){
	                    
	                    $arr['msg']  =  '您的简历尚未完成审核，请联系管理员加快审核进度！';
	                }else{
	                    $arr['msg']  =  '您还没有合适的简历';
	                }
	            }
	        }
	    }
	    echo json_encode($arr);die;
	}
	//视频面试预约
	function viewSub_action(){
		
		if(!empty($_POST['jobid'])){
			$spviewM	=	$this->MODEL('spview');
			
			$subData	=	array(
				'uid'		=>  $this->uid,
				'usertype'	=>  $this->usertype,
				'sid'		=>  $_POST['sid'],
				'did'		=>	$this->did,
				'jobid'		=>	$_POST['jobid'],
				'eid'		=>	intval($_POST['eid']),
				'port'		=>	1
			);
			
			$return		=	$spviewM->viewSub($subData);
			
		}else{
			
			$return['errcode']	=	1;
			
			$return['msg']		=	'请选择职位';
		}
		
		echo json_encode($return);die;
		
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
	function goRoom_action(){
        
        $where  =  array(
            'uid'  =>  $this->uid,
            'sid'  =>  $_POST['sid']
        );
        
        $spviewM  =  $this->MODEL('spview');
        $spviewM->updateSubcribe($where, array('rtime'=>time()));
        echo 1;
    }
    /**
     * 获取用户信息，并组装面试房间参数
     */
    function uinfo_action()
    {
        if ($this->uid && $this->usertype){
            
            $trtcM   =  $this->MODEL('trtc');
            $return  =  $trtcM->getTrcInfo(array('uid'=>$this->uid, 'usertype'=>$this->usertype,'fuid'=>$_POST['fuid']));
            
            echo json_encode($return);
        }
    }
}
?>