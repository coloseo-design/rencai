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
class index_controller extends common{

	function index_action(){

		$CacheM       =   $this -> MODEL('cache');

		$CacheList    =   $CacheM -> GetCache(array('city','com','hy','job'));

		$this         ->  yunset($CacheList);

		if($_GET['city']){//城市匹配

		    $city					=	explode("_",$_GET['city']);

		    $_GET['provinceid']		=	$city[0];
		    $_GET['cityid']			=	$city[1];
		    $_GET['three_cityid']	=	$city[2];
		}

		if ($this->config['sy_web_city_one']) {
	        $_GET['provinceid'] = 	$this->config['sy_web_city_one'];
	    }
	    if ($this->config['sy_web_city_two']) {
	        $_GET['cityid'] 	= 	$this->config['sy_web_city_two'];
	    }

	    if($this->config['province']){
			$_GET['provinceid'] 	= 	$this->config['province'];
		}
		if($this->config['cityid']){
			$_GET['cityid'] 		= 	$this->config['cityid'];
		}
		if($this->config['three_cityid']){
			$_GET['three_cityid']	= 	$this->config['three_cityid'];
		}

		$this->yunset(array('gettype' => $_SERVER['QUERY_STRING'], 'getinfo' => $_GET));


		$this->seo('spview');
		$this->yun_tpl(array('index'));
	}

    function show_action(){

    	if($_GET['id']){
			
    		$spviewM	=	$this->MODEL('spview');
			
    		$userinfoM	=	$this->MODEL('userinfo');
			
			$spviewM -> upSpviewHits($_GET['id']);			

    		$spview		=	$spviewM->getInfo(array('id'=>$_GET['id']));
			
			$this->yunset("spview",$spview);
			
    		if(empty($spview)){

    			$this->ACT_msg($this->config['sy_weburl'],"没有找到该视频面试！");

    		}else {
    		    $look = isset($_GET['look']) && $_GET['look'] == 'admin' && !empty($_SESSION['auid']) ? 'admin' : '';
    		    if($spview['status']!=1 && $look != 'admin'){
    		        $this->ACT_msg($this->config['sy_weburl'],"该视频面试尚未审核！");
    		    }
    		}

    		$comid				=	$spview['uid'];
    		$CompanyM			=   $this -> MODEL('company');
    		$company     		=   $CompanyM -> getInfo($comid, array('logo' => '1'));
    		
    		if ($company['r_status'] == 0 || $company['r_status'] == 3) {
    		    $this->ACT_msg($this->config['sy_weburl'], '企业暂未通过审核！');
    		} elseif ($company['r_status'] == 2 || $company['r_status'] == 4) {
    		    $this->ACT_msg($this->config['sy_weburl'], '企业已被锁定！');
    		}

			$jobM				=   $this -> MODEL('job');

			$spjobs				=	$jobM -> getList(array('id'=>array('in',$spview['jobid']),'uid'=>$comid,'status'=>'0','state'=>'1','r_status'=>1));

			$spview_sub			=	$spviewM -> getSubinfo(array('sid'=>$_GET['id'],'uid'=>$this->uid), array('job'=>1));

			$stopTime			=	$spview['starttime'] - ($this->config['sy_spview_yytime'] * 3600);
			$this->yunset("stopTime",$stopTime);
			
			if($spview_sub){
				// 已预约
				if(time()>$spview['starttime']){
					
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
			
			if($this->uid && $this->usertype==1){

				$ResumeM    =   $this->MODEL('resume');
	            $resumenum  =   $ResumeM->getExpectNum(array('uid'=>$this->uid,'status'=>1,'state'=>1,'r_status'=>1));
	            $this->yunset('resumenum', $resumenum);

			}

			$this->yunset("issub",$issub);
			
			$week	=	$this->get_week($spview['starttime']);
			
			$this->yunset("week",$week);
			
			$this->yunset("comid",$comid);

			$this->yunset("com",$company);
			
			$this->yunset("spjobs",$spjobs['list']);

			$this->yunset(array("com_style"=>$this->config['sy_weburl']."/app/template/company/default/","comstyle"=>TPL_PATH."company/default/"));

			$data	=   array('company_name' =>  $company['name']);
			$this->data = $data;
		}
        
		$this->seo('spview_show');
    	$this->yun_tpl(array('spview'));

    }
    /**
     * 个人有多简历，预约时要选择简历
     */
    function ajaxResume_action(){
        
        if(!$this->uid || !$this->username || $this->usertype != 1){
            
            $arr['msg']		=	'请登录个人用户！';
            $arr['login']	=	1;
        }else{
            
            $spviewM 		=	$this->MODEL('spview');
            
            $sid			=	intval($_POST['sid']);
            
            $subNum			=	$spviewM -> getSubinfo(array('uid' => $this -> uid, 'sid' => $sid));
            
            
            if($subNum > 0){	//已投递过
                
                $arr['msg']	=	'您已预约过该视频面试！';
            }else{
                
                $ResumeM	=	$this -> MODEL('resume');
                
                $resumeList	=	$ResumeM -> getSimpleList(array('uid' => $this -> uid, 'r_status' => 1, 'state' => 1, 'orderby' => 'defaults, desc'), array('field' => '`id`,`name`,`defaults`'));
                
                if(!empty($resumeList)){
                    $data   =   '';
                    foreach($resumeList as $v){
                        
                        if($v['defaults'] == 1){
                            
                            $data.='<div class="job_prompt_sendresume_list job_prompt_sendresume_list_cur" id="resume_'.$v['id'].'" data_did="'.$v['id'].'" onclick="subviewclic('.$v['id'].');"><i class="job_prompt_sendresume_radio"></i><i class="job_prompt_sendresume_radio_q"></i>'.$v['name'].'(默认简历)</div>';
                            
                        }else{
                            
                            $data.='<div class="job_prompt_sendresume_list " id="resume_'.$v['id'].'" data_did="'.$v['id'].'" onclick="subviewclic('.$v['id'].');"><i class="job_prompt_sendresume_radio"></i><i class="job_prompt_sendresume_radio_q"></i>'.$v['name'].'</div>';
                            
                        }
                    }
                    
                    $arr['status']		=	1;
                    $arr['resumeList']	=	$data;
                    
                }else{
                    
                    $resuemNum		=	$ResumeM -> getExpectNum(array('uid' => $this -> uid));
                    
                    if(intval($resuemNum) > 0){
                        
                        $arr['msg']	=	'您的简历尚未完成审核，请联系管理员加快审核进度！';
                    }else{
                        $arr['alert']	=	1;
                        $arr['msg']		=	'您还没有合适的简历，是否先添加简历？';
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
				'comid'		=>	$_POST['comid'],
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
	// 进入面试房间，变为待面试
    function goRoom_action(){
        
        $where  =  array(
            'uid'  =>  $this->uid,
            'sid'  =>  $_POST['sid']
        );
        
        $spviewM  =  $this->MODEL('spview');
        
        $row  =  $spviewM->getSubinfo($where, array('field'=>'`rtime`'));
        
        if (empty($row['rtime'])){
            
            $spviewM->updateSubcribe($where, array('rtime'=>time()));
        }
    }
}
?>