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
class index_controller extends user_controller{
    
	function getInfo_action()
	{
        
	    $resumeM	=  $this->MODEL('resume');
	    $companyM	=  $this->MODEL('company');
		$UserinfoM  =  $this->MODEL('userinfo');
        $M          =  $this->MODEL('msgNum');

	    $resume		=	$resumeM->getResumeInfo(array('uid'=>$this->member['uid']),array('logo'=>1,'setname'=>1,'field'=>'`name`,`exp`,`edu`,`birthday`,`status`,`sex`,`telphone`,`moblie_status`,`email`,`email_status`,`idcard_pic`,`idcard_status`,`photo`,`def_job`'));

        if(empty($resume['name'])){
			
			$resume['name']	=	$this->member['username'];
		}

	    if($this->config['resume_sx']!=1){

            $refewhere['id']        =   $resume['def_job'];
            $refewhere['r_status']  =   1;
            $refewhere['lastupdate']=   array('<', strtotime('today'));
            $resume['refreshnum']   =   $resumeM->getExpectNum($refewhere);
        }
		$expect    =  $resumeM->getExpectByUid($this->member['uid'],array('field'=>'id,lastupdate,state,top,topdate,integrity,name,statusbody'));
		if(!empty($expect)){
		    $resume['integrity']	    =	$expect['integrity'];
		    $resume['lastupdate']	    =	$expect['lastupdate'];
			$resume['expect_top']		= 	$expect['top'];
			$resume['rnums']			=	1;
            $resume['expect_state']		= 	$expect['state'];
            $resume['resume_name']		= 	$expect['name'];
            $resume['statusbody']		= 	$expect['statusbody'];

			if($expect['topdate']>1){
				$resume['topdatetime']	=	$expect['topdate'] - time();
				$resume['topdate']		=	date("Y-m-d",$expect['topdate']);
				$top_day = (int)(($expect['topdate'] - strtotime(date('Y-m-d')))/86400);
				$resume['top_day']      =   $top_day>0?$top_day:0;
			}
            // 根据简历完成情况，提示完善简历
            if ($expect['integrity'] > 0 && $expect['integrity'] < 100){
                $ur  =  $resumeM->getUserResumeInfo(array('uid' => $this->member['uid'],'eid'=>$expect['id']));
                if ($ur['expect'] == 0){
                    $resume['wstitle'] = '求职意向';
                    $resume['wsappurl']= '/pson/pages/usermember/addexpect/index?id='.$expect['id'];
                    $resume['wswapurl']= 'index.php?c=addexpect&eid=' .$expect['id'];
                    $resume['wsts'] = 1;
                }elseif ($ur['work'] == 0){
                    $resume['wstitle'] ='工作经历';
                    $resume['wsappurl']= '/pson/pages/usermember/addresume/addresumeson?type=work&eid=' .$expect['id'];
                    $resume['wswapurl']= 'index.php?c=addresumeson&type=work&eid=' .$expect['id'];
                    $resume['wsts'] = 1;
                }elseif ($ur['edu'] == 0){
                    $resume['wstitle'] ='教育经历';
                    $resume['wsappurl']= '/pson/pages/usermember/addresume/addresumeson?type=edu&eid=' .$expect['id'];
                    $resume['wswapurl']= 'index.php?c=addresumeson&type=edu&eid=' .$expect['id'];
                    $resume['wsts'] = 1;
                }elseif ($ur['project'] == 0){
                    $resume['wstitle'] ='项目经历';
                    $resume['wsappurl']= '/pson/pages/usermember/addresume/addresumeson?type=project&eid=' .$expect['id'];
                    $resume['wswapurl']= 'index.php?c=addresumeson&type=project&eid=' .$expect['id'];
                    $resume['wsts'] = 2;
                }elseif ($ur['training'] == 0){
                    $resume['wstitle'] ='培训经历';
                    $resume['wsappurl']= '/pson/pages/usermember/addresume/addresumeson?type=training&eid=' .$expect['id'];
                    $resume['wswapurl']= 'index.php?c=addresumeson&type=training&eid=' .$expect['id'];
                    $resume['wsts'] = 2;
                }elseif ($ur['skill'] == 0){
                    $resume['wstitle'] ='职业技能';
                    $resume['wsappurl']= '/pson/pages/usermember/addresume/addresumeson?type=skill&eid=' .$expect['id'];
                    $resume['wswapurl']= 'index.php?c=addresumeson&type=skill&eid=' .$expect['id'];
                    $resume['wsts'] = 2;
                }
            }
		}else{
		    $resume['rnums']	=	0;
		}
		
		$msgNumM  =  $this->MODEL('msgNum');
	    $allMsgs  =  $msgNumM->getmsgNum($this->member['uid'],1,array('type'=>1));
		$msgs	  =  $allMsgs;
		$data	  =  array_merge($msgs,$this->member,$resume);
		
		$reg		=	$UserinfoM->getMemberregInfo(array('uid'=>$this->member['uid'],'usertype'=>$this->member['usertype'],'date'=>date("Ymd")));
		$signstate  =  !empty($reg) ? 1 : 0;
        $arr        =  $M->getmsgNum($this->member['uid'], $this->member['usertype']);

	 	$comnum		=	$companyM->getCompanyNum(array('uid'=>$this->member['uid']));
		
		//对我感兴趣 总数

	 	$looknum	=	$this->MODEL('lookresume')->getLookNum(array('uid'=>$this->member['uid'],'status'=> 0, 'usertype' => '2'));
	 	$data['looknum']	=	$looknum;
        $data['fav_jobnum'] =   $arr['fav_jobnum'];
        $data['yqnum']      =   $arr['yqnum'];
        $data['sq_jobnum']  =   $arr['sq_jobnum'];
	 	$data['comnum']		=	$comnum;
		$data['signstate']	=	$signstate;
		$data['cuswitch']   =	$this->config['sy_user_change'];
		$data['iosfk']		=	$this->config['sy_iospay'] ;
		$data['webtel']	    =	!empty($this->config['sy_freewebtel']) ? $this->config['sy_freewebtel'] : '';
		$data['worktime']	=	!empty($this->config['sy_worktime']) ? $this->config['sy_worktime'] : '';
		
		include(CONFIG_PATH.'db.data.php');
		$spview_web =  isset($arr_data['modelconfig']['spview']) && isset($this->config['sy_spview_web']) ? $this->config['sy_spview_web'] : 2;
		if ($this->platform == 'ios' && $_POST['provider'] == 'app'){
		    // IOS APP 不支持视频面试
		    $spview_web = 2;
		}
		$data['config']  =  array(
		    'part'     =>  isset($this->config['sy_part_web']) ? $this->config['sy_part_web'] : 2,
		    'reward'   =>  isset($this->config['sy_reward_web']) ? $this->config['sy_reward_web'] : 2,
		    'special'  =>  isset($this->config['sy_special_web']) ? $this->config['sy_special_web'] : 2,
		    'spview'   =>  $spview_web,
		    'top_price'=>  $this->config['integral_resume_top'],
		    'xjhlive'  =>  isset($arr_data['modelconfig']['xjhlive']) && isset($this->config['sy_xjhlive_web']) ? $this->config['sy_xjhlive_web'] : 2,
		    'ask'      =>  isset($this->config['sy_ask_web']) ? $this->config['sy_ask_web'] : 2,
		    'train'    =>  isset($arr_data['modelconfig']['train']) && isset($this->config['sy_train_web']) ? $this->config['sy_train_web'] : 2
		);
		$data['qqdt']       =  !empty($this->config['sy_qqdt']) ? $this->config['sy_qqdt'] : 2;
		$data['wxlogin']    =  !empty($this->config['sy_app_wxlogin']) ? $this->config['sy_app_wxlogin'] : 2;
		$data['qqlogin']    =  !empty($this->config['sy_app_qqlogin']) ? $this->config['sy_app_qqlogin'] : 2;
		$data['fktype']     =   $this->fktype();
		if ($data['spview_web'] == 1){
		    // 有可以参加的视频面试
		    $spviewM  =  $this->MODEL('spview');
		    $canroom  =  $spviewM -> canRoom(array('uid'=>$this->uid,'status'=>0));
		}
		if ($this->config['user_resume_status'] == 1) {
		    
		    if(empty($expect)){
		        
		        if ($this->config['sy_user_change'] == 1) {
		            
		            $data['remind'] = 2;
		        } else {
		            
		            $data['remind'] = 1;
		        }
		    }
		}
		
	    $this -> render_json(0, 'ok', $data);
	}
	//签到，TODO:会员中心
	function sign_action(){
		
		$IntegralM	=	$this -> MODEL('integral');
		$userinfoM	=	$this -> MODEL('userinfo');
		
		$date		=	date("Ymd");
		
		$member		=	$userinfoM -> getInfo(array('uid'=>$this->member['uid'],'usertype'=>$this->member['usertype']),array('field'=>"`signday`,`signdays`"));
		
		$lastreg	=	$userinfoM -> getMemberregInfo(array('uid'=>$this->member['uid'],'usertype'=>$this->member['usertype'],'orderby'=>'id,desc'));
		
		$lastregdate=	date("Ymd",$lastreg['ctime']);
		
		if($lastregdate!=$date){
			
			$yesterday	=	date("Ymd",strtotime("-1 day"));
			
			if($lastregdate==$yesterday&&intval(date("d"))>1){
				
				if($member['signday']>=5){
					$integral	=	$this->config['integral_signin']*2;
				}else{
					$integral	=	$this->config['integral_signin'];
				}
				$signday	=	$member['signday']+1;
				$msg		=	'连续签到'.$signday."天";
			}else{
				$signday	=	'1';
				$integral	=	$this->config['integral_signin'];
				$msg		=	'第一次签到';
			}
			$arr	=	array();
			
			$nid	=	$userinfoM -> addMemberreg(array('uid'=>$this->member['uid'],'usertype'=>$this->member['usertype'],'date'=>$date,"ctime"=>time(),'ip'=>fun_ip_get()));
			
			if($nid){
				
				$IntegralM->company_invtal($this->member['uid'],$this->member['usertype'],$integral,true,$msg,true,2,'integral');
				
				$userinfoM -> upInfo(array('uid'=>$this->member['uid']),array('signday'=>$signday,'signdays'=>array('+','1')));
				
				$data['msg']	=	'签到成功！+'.$integral.$this->config['integral_pricename'];
				$data['error']	=	1;
				
			}else{
				$data['msg']	=	'签到失败！';
				$data['error']	=	2;
			}
		}else{
			$data['msg']	=	'签到失败！';
			$data['error']	=	2;
		}
		$this->render_json($data['error'],$data['msg'],$data);
	}


}
?>