<?php

/**
 * $Author ：PHPYUN开发团队
 *
 * 官网: http://www.phpyun.com
 *
 * 版权所有 2009-2021 宿迁鑫潮信息技术有限公司，并保留所有权利。
 *
 * 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
 */
class friendhelp_model extends model{

    function getNum($whereData)
    {

        return $this->select_num('friend_help', $whereData);
    }
	
	function getList($whereData,$data=array()){
		$ListNew		=	array();
		
		$data['field']  =	empty($data['field']) ? '*' : $data['field'];
		
		$List			=	$this->select_all("friend_help",$whereData,$data['field']);
		
		if(!empty( $List )){
            $List	=	$this -> getDataList($List);
			$ListNew['list']	=	$List;
			
		}
		
		return $ListNew;
	}
	function getLogList($whereData,$data=array()){
		$ListNew		=	array();
		
		$data['field']  =	empty($data['field']) ? '*' : $data['field'];
		
		$List			=	$this->select_all("friend_help_log",$whereData,$data['field']);

		if(!empty($List)){
			
			foreach($List as $key=>$value){
			    if ($value['time']) {
			        $List[$key]['time']	    =	date('Y-m-d H:i:s',$value['time']);
			    }
			}
		}

		return $List;
	}
	/**
     * @desc    查询company_order表内没有的数据，引用相关类，查询关联表，提取列表数据所需信息
     * @param   array $List 
     */
    private function getDataList($List) 
    {
        $uids  =  $onceid  =  array();
        
        foreach ($List as $k=>$v){
			//对相关权益进行整合

            $comid[]				= 	$v['comid'];
			//约定权益
			$List[$k]['package']	=	$this -> packageList($v);
			//已达标权益
			$List[$k]['getpackage']	=	$this -> getPackage($v,$List[$k]['package']);
			if ($v['stime']) {
			    $List[$k]['stime_n']	=	date('Y.m.d H:i',$v['stime']);
			}
			if ($v['etime']) {
			    $List[$k]['etime_n']	=	date('Y.m.d H:i',$v['etime']);
			}

        }
		if($comid){
			//  查询用户名
		    $mList              =   $this -> select_all('company', array('uid'=>array('in', pylode(',', $comid))), '`uid`,`name`');

		}

		
        foreach ($List  as  $k  =>  $v){
           
            //	企业名称
            if (!empty($mList)) {
                foreach ($mList as $va){
                    if ($v['comid']	==	$va['uid'] ) {
						$List[$k]['comname']	=	$va['name'];
                    }
                }
            }
			
        }
        return $List;
	}
	function packageList($data){
	
		if($data['job_num']>0 && $data['job_num_zl']>0){
			$packData['job_num']['num']				=	$data['job_num'];
			$packData['job_num']['zl']				=	$data['job_num_zl'];
			$packData['job_num']['name']			=	'发布职位';
			$zl[]	=	$data['job_num_zl'];
		}
		if($data['breakjob_num']>0 && $data['breakjob_num_zl']>0){
			$packData['breakjob_num']['num']		=	$data['breakjob_num'];
			$packData['breakjob_num']['zl']			=	$data['breakjob_num_zl'];
			$packData['breakjob_num']['name']		=	'刷新职位';
			$zl[]	=	$data['breakjob_num_zl'];
		}
		if($data['top_num']>0 && $data['top_num_zl']>0){
			$packData['top_num']['num']				=	$data['top_num'];
			$packData['top_num']['zl']				=	$data['top_num_zl'];
			$packData['top_num']['name']			=	'置顶职位';
			$zl[]	=	$data['top_num_zl'];
		}
		if($data['urgent_num']>0 && $data['urgent_num_zl']>0){
			$packData['urgent_num']['num']			=	$data['urgent_num'];
			$packData['urgent_num']['zl']			=	$data['urgent_num_zl'];
			$packData['urgent_num']['name']			=	'紧急职位';
			$zl[]	=	$data['urgent_num_zl'];
		}
		if($data['rec_num']>0 && $data['rec_num_zl']>0){
			$packData['rec_num']['num']				=	$data['rec_num'];
			$packData['rec_num']['zl']				=	$data['rec_num_zl'];
			$packData['rec_num']['name']			=	'推荐职位';
			$zl[]	=	$data['rec_num_zl'];
		}
		if($data['invite_resume']>0 && $data['invite_resume_zl']>0){
			$packData['invite_resume']['num']		=	$data['invite_resume'];
			$packData['invite_resume']['zl']		=	$data['invite_resume_zl'];
			$packData['invite_resume']['name']		=	'邀请面试';
			$zl[]	=	$data['invite_resume_zl'];
		}
		if($data['down_resume']>0 && $data['down_resume_zl']>0){
			$packData['down_resume']['num']			=	$data['down_resume'];
			$packData['down_resume']['zl']			=	$data['down_resume_zl'];
			$packData['down_resume']['name']		=	'下载简历';
			$zl[]	=	$data['down_resume_zl'];

		}
		//按照助力指标进行排序
		
		array_multisort($zl,SORT_ASC,SORT_REGULAR,$packData);
		return $packData;
	}
	//检测已达标的权益
	function getPackage($helpInfo,$package){
		if($helpInfo['zlnum']>0){
			foreach($package as $key=>$value){
				
				if($value['zl'] > $helpInfo['zlnum']){
					unset($package[$key]);
				}
			
			}

			return $package;
		}else{
			return array();
		}

		
	
	}
	function addInfo($setData){

		if(!empty($setData)){
			
			$nid	=	$this -> insert_into('friend_help',$setData);
			
		}

		return $nid;
	}
	
	function getInfo($whereData, $data = array()){
		
		if($whereData){
			$data['field']  =	empty($data['field']) ? '*' : $data['field'];
		
			$Info	=	$this -> select_once('friend_help',$whereData,$data['field']);
			if (!empty($Info)){

                $Info['stime_n']    =   date('Y.m.d H.i', $Info['stime']);
                $Info['etime_n']    =   date('Y.m.d H.i', $Info['etime']);
            }
		}

		return $Info;
	}

	function getHelpNum($whereData, $data = array()){
		
		if($whereData){
			$data['field']  =	empty($data['field']) ? '*' : $data['field'];
		
			$num	=	$this -> select_num('friend_help_log',$whereData);
		}

		return $num;
	}
	
	function upInfo($whereData, $data = array()){

		if(!empty($whereData)){
			
			$nid	=	$this -> update_once('friend_help',$data,$whereData);
			
		}

		return $nid;
	
	}
	
	function delHelp($delId){
		if(empty($delId)){
           
			return	array(
              
			  'errcode' => 8,
               
			  'msg' 	=> '请选择要删除的数据！',                
            );
        
		}else{
			if(is_array($delId)){
				
				$delId	=	pylode(',',$delId);
				
				$return['layertype']	=	1;
			
			}else{
				
				$return['layertype']	=	0;
			}
			 
			$nid	=	$this -> delete_all('friend_help',array('id' => array('in',$delId)),'');
			
			if($nid){
				//同时删除 助力记录、领取记录
				$this -> delete_all('friend_help_log',array('pid' => array('in',$delId)),'');

				$this -> delete_all('friend_help_receive',array('pid' => array('in',$delId)),'');

				$return['msg']		=	'好友助力任务(ID:'.$delId.')';
				
				$return['errcode']	=	$nid ? '9' :'8';
				
				$return['msg']		=	$nid ? $return['msg'].'删除成功！' : $return['msg'].'删除失败！';
			
			}
		}
		return	$return;
		
	}

	//发布任务
	function addHelp($uid){
		
		$uid	=	intval($uid);
		if($this -> config['sy_help_open']!='1'){
			$return['error']	=	'0';
			$return['msg']		=	'系统暂未开启好友助力！';
			return $return;
		}
		//检测企业是否能开启助力任务，有正在招聘中职位
		include_once ('job.model.php');
        $jobM       =   new job_model($this->db, $this->def);
		
		$jobs  =  $jobM->getJobNum(array('uid'=>$uid,'state'=>1,'r_status'=>1,'status'=>0));
		
		if ($jobs>0) {
			//检测当前企业是否已发布任务 一个企业同时只能发布一个任务
			
			$Info	=	$this -> getInfo(array('comid' => $uid,'etime' => array('>',time())));
			
			//已经有执行发布中的任务 更新职位ID后 返回相关链接
			if(!empty($Info)){
				
				
				//返回相关链接
				$scriptToken		=	rawurlencode(openssl_encrypt($Info['id'].'+'.$Info['comid'], 'DES-ECB', $Info['token'], 0));
				$return['error']	=	'1';
				$return['id']		=	$Info['id'];
				$return['token']	=	$scriptToken;
				$return['url']		=	Url('wap').'index.php?c=friendhelp&a=share&id='.$Info['id'].'&token='.$scriptToken;
			}else{
				//根据当前职位 发布新任务
				//生成随机加密串 用于后面所有的token解密

				$token =   md5(time().rand(1000,9999));
				$helpData['comid']	=	intval($uid);
				$helpData['state']	=	0;
				$helpData['token']	=	$token;
				$helpData['stime']	=	time();
				$helpData['etime']	=	time()+$this->config['sy_help_time']*3600;
				if($this -> config['sy_help_jobnum']>0 && $this -> config['sy_help_jobnum_zl']>0){
					$helpData['job_num']		=	$this -> config['sy_help_jobnum'];
					$helpData['job_num_zl']		=	$this -> config['sy_help_jobnum_zl'];
				}
				if($this -> config['sy_help_breakjobnum']>0 && $this -> config['sy_help_breakjobnum_zl']>0){
					$helpData['breakjob_num']		=	$this -> config['sy_help_breakjobnum'];
					$helpData['breakjob_num_zl']	=	$this -> config['sy_help_breakjobnum_zl'];
				}
				if($this -> config['sy_help_downresume']>0 && $this -> config['sy_help_downresume_zl']>0){
					$helpData['down_resume']	=	$this -> config['sy_help_downresume'];
					$helpData['down_resume_zl']	=	$this -> config['sy_help_downresume_zl'];
				}
				if($this -> config['sy_help_inviteresume']>0 && $this -> config['sy_help_inviteresume_zl']>0){
					$helpData['invite_resume']		=	$this -> config['sy_help_inviteresume'];
					$helpData['invite_resume_zl']	=	$this -> config['sy_help_inviteresume_zl'];
				}
				if($this -> config['sy_help_topnum']>0 && $this -> config['sy_help_topnum_zl']>0){
					$helpData['top_num']	=	$this -> config['sy_help_topnum'];
					$helpData['top_num_zl']	=	$this -> config['sy_help_topnum_zl'];
				}
				if($this -> config['sy_help_urgentnum']>0 && $this -> config['sy_help_urgentnum_zl']>0){
					$helpData['urgent_num']	=	$this -> config['sy_help_urgentnum'];
					$helpData['urgent_num_zl']	=	$this -> config['sy_help_urgentnum_zl'];
				}
				if($this -> config['sy_help_recnum']>0 && $this -> config['sy_help_recnum_zl']>0){
					$helpData['rec_num']	=	$this -> config['sy_help_recnum'];
					$helpData['rec_num_zl']	=	$this -> config['sy_help_recnum_zl'];
				}
				
				$id	=	$this -> addInfo($helpData);
				if($id){
					$scriptToken		=	openssl_encrypt($id.'+'.$uid, 'DES-ECB', $token, 0);
					$return['error']	=	'1';
					$return['id']		=	$id;
					$return['token']	=	rawurlencode($scriptToken);
					$return['url']		=	Url('wap').'index.php?c=friendhelp&a=share&id='.$id.'&token='.rawurlencode($scriptToken);
				}else{
					$return['error']	=	'0';
					$return['msg']		=	'发布失败，请稍后重试！';
				}
			}
		
		}else{
			$return['error']	=	'0';
			$return['msg']		=	'您没有正在招聘中的职位！';
		}

	
		return $return;
	}
	//token解密验证 
	function desToken($id,$token)
	{
		if($id && $token){
			
			$Info	=	$this -> getInfo(array('id' => $id));
			
			if($Info['token']){
				
				//对token进行解密
				$tokenInfo	=	openssl_decrypt($token, 'DES-ECB', $Info['token'], 0);
			
				if($tokenInfo){

					$tokenInfoList	=	explode('+',$tokenInfo);
					
					//对比解密数据
					if($Info['id'] == $tokenInfoList['0'] && $Info['comid'] == $tokenInfoList['1']){

						$Info['tokeninfo']	=	$tokenInfoList;

						$helpInfo			=	$Info;
					}
				}
			}
		}
		return $helpInfo;
	}
	//根据加密token 验证读取相关分享数据
	function getTokenInfo($id,$token,$data = array()){
		
		$return['error']	=	'0';
		//token验证
		$Info	=	$this -> desToken($id,$token);
		
		if(!empty($Info)){
			if($data['num']){
				$Info['num']	=	$this -> getHelpNum(array('pid' => $id));
			}
			$return['helpinfo']	=	$Info;			
			$return['error']	=	'1';
		}
					
		return $return;
		
	}
	//读取对应的微信分享任务
	function getShareInfo($whereData, $data = array()){
		
		if($whereData){
			$data['field']  =	empty($data['field']) ? '*' : $data['field'];
		
			$List	=	$this -> select_once('friend_helpshare',$whereData,$data['field']);
		}

		return $List;
	}

	function addShareInfo($setData){

		if(!empty($setData)){
			
			$nid	=	$this -> insert_into('friend_helpshare',$setData);
			
		}

		return $nid;
	}

	//读取对应的微信分享任务
	function getSharelogInfo($whereData, $data = array()){
		
		if($whereData){
			$data['field']  =	empty($data['field']) ? '*' : $data['field'];
		
			$List	=	$this -> select_once('friend_help_log',$whereData,$data['field']);
		}

		return $List;
	}
	function addHelpLog($setData){
		
		
		if(!empty($setData)){
			
			$nid	=	$this -> insert_into('friend_help_log',$setData);
			
		}

		return $nid;
	}
	//根据微信用户点击记录 对应调整助力任务奖励
	
	function checkHelp($helpinfo,$wxuser){
		
		if($this -> config['sy_help_open']!='1'){
			$return['error']	=	'0';
			$return['msg']		=	'系统已关闭好友助力！';
			return $return;
		}

		//检测当前活动是否已结束
		$Info	=	$this -> getInfo(array('comid' => $helpinfo['comid'],'etime' => array('>',time())));

		if($Info['etime'] >0 && $Info['etime']<time()){
			$return['error']	=	'0';
			$return['msg']		=	'任务已结束！';
			return $return;
		
		}
		//同一用户 只记录一次
		if (!empty($wxuser['unionid'])){
		    
		    $logInfo	=	$this -> getSharelogInfo(array('pid'=>$helpinfo['id'],'unionid'=>$wxuser['unionid']));
		    
		}else{
		    
		    $logInfo	=	$this -> getSharelogInfo(array('pid'=>$helpinfo['id'],'wxid'=>$wxuser['openid']));
		}
	
		if(empty($logInfo) && $wxuser['openid']){
			
			//生成新的助力记录
			$sharelogData['pid']		=	$helpinfo['id'];
			$sharelogData['comid']		=	$helpinfo['comid'];
			$sharelogData['wxid']		=	$wxuser['openid'];
			$sharelogData['wxname']		=	preg_replace("/[\x{1F600}-\x{1F64F}\x{1F300}-\x{1F5FF}\x{1F680}-\x{1F6FF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}]/u","",$wxuser['nickname']);
			$sharelogData['city']		=	$wxuser['province'].$wxuser['city'];
			$sharelogData['wxpic']		=	$wxuser['headimgurl'];
			$sharelogData['time']		=	time();
			if (!empty($wxuser['unionid'])){
			    $sharelogData['unionid']  =  $wxuser['unionid'];
			}
			
			$id  =  $this -> addHelpLog($sharelogData);
			if($id){
				
				$this -> upInfo(array('id'=>$helpinfo['id']),array('zlnum'=>array('+',1)));
			}
			
			
			$return['error']	=	'1';
			return $return;
			
		}else{
			$return['error']	=	'0';
			$return['msg']		=	'您已为好友助力！';
			return $return;
		}
	}
	
	

	//领取助力权益
	function givePackage($id,$uid){
		

		$return['error']	=	'0';

		$id = intval($id);

		$helpInfo	=	$this -> getInfo(array('id'=>$id,'comid'=>$uid));
		//检测是否有可领取权益
		if(!empty($helpInfo)){
			//约定权益
			$package	=	$this -> packageList($helpInfo);
			
			//已达标权益
			$getpackage	=	$this -> getPackage($helpInfo,$package);
			//将已达标权益 与 已领取权益进行比对 
			if($helpInfo['receive']){
				$receivePackage	=	@explode(',',$helpInfo['receive']);
				$canPackage	=	$this -> checkPackage($getpackage,$receivePackage);
			}else{
				$canPackage	=	$getpackage;
			}
			
			if(!empty($canPackage)){
				
				foreach($canPackage as $key => $value){
					$receivePackage[]	=	$key;
					$statis[$key]		=	array('+',$value['num']);
					$log[]				=	$value['name'].':'.$value['num'];	
				}
				
				//进行权益发放
				$nid	=	$this -> update_once('company_statis',$statis,array('uid'=>$uid));
				
				if($nid){
					foreach($canPackage as $key => $value){
						$this -> addHelpReceive(array('pid'=>$id,'name'=>$key,'num'=>$value['num'],'time'=>time()));
					}
				}
				//进行权益领取记录 
				$this -> update_once('friend_help',array('receive' => implode(',',$receivePackage)),array('id'=>$id));
				
				//记录会员领取日志
				require_once ('log.model.php');
                
				$logM 		= 	new log_model($this->db, $this->def);
					
				$logM		->	member_log('领取助力权益(ID:'.$id.')：'.implode(',',$log),15,$uid);//会员日志

				$return['error']		=	'1';
				$return['msg']			=	'领取成功！';
				$return['canPackage']	=	$canPackage;

				//权益是否已领取完成
				
				$allPackage	=	$this -> checkPackage($package,$receivePackage);
				
				if(empty($allPackage)){
					
					$this -> upInfo(array('id'=>$id),array('state'=>1));
				}

			}else{

				//如果任务已结束 并且还无可领取权益 直接结束
				if($helpInfo['etime']<time()){
					//权益是否已领取完成
				
					$this -> upInfo(array('id'=>$id),array('state'=>1));
				
				}
				$return['msg']		=	'暂无可领取权益！';
			}
		
		}else{
		
			$return['msg']		=	'参数错误！';
		}

		return $return;
	}
	//领取权益记录
	function addHelpReceive($setData){

		if(!empty($setData)){
			
			$nid	=	$this -> insert_into('friend_help_receive',$setData);
			
		}

		return $nid;
	}
	/*
	* 领取权益比对 
	* $package 已达标权益
	* $receivePackage 已领取权益
	*/

	function checkPackage($getPackage,$receivePackage){
	
	
		if(!empty($getPackage)){
			
			foreach($getPackage as $key=>$value){
				
				if(in_array($key,$receivePackage)){
					//已领取的删除
					unset($getPackage[$key]);
				}
			}
		}

		return $getPackage;
	
	}

	//查询当前系统权益 登录用户优先查询是否有执行任务
	function getPackageInfo($uid =''){


		// uid存在 优先查询执行中的任务
		if($uid){
			$Info	=	$this -> getInfo(array('comid' => $uid,'etime' => array('>',time())));
		}
		if(!empty($Info)){
			
			$package	=	$this -> packageList($Info);
			
		}else{
			
			if($this -> config['sy_help_jobnum']>0 && $this -> config['sy_help_jobnum_zl']>0){
				$helpData['job_num']		=	$this -> config['sy_help_jobnum'];
				$helpData['job_num_zl']		=	$this -> config['sy_help_jobnum_zl'];
			}
			if($this -> config['sy_help_breakjobnum']>0 && $this -> config['sy_help_breakjobnum_zl']>0){
				$helpData['breakjob_num']		=	$this -> config['sy_help_breakjobnum'];
				$helpData['breakjob_num_zl']	=	$this -> config['sy_help_breakjobnum_zl'];
			}
			if($this -> config['sy_help_downresume']>0 && $this -> config['sy_help_downresume_zl']>0){
				$helpData['down_resume']	=	$this -> config['sy_help_downresume'];
				$helpData['down_resume_zl']	=	$this -> config['sy_help_downresume_zl'];
			}
			if($this -> config['sy_help_inviteresume']>0 && $this -> config['sy_help_inviteresume_zl']>0){
				$helpData['invite_resume']		=	$this -> config['sy_help_inviteresume'];
				$helpData['invite_resume_zl']	=	$this -> config['sy_help_inviteresume_zl'];
			}
			if($this -> config['sy_help_topnum']>0 && $this -> config['sy_help_topnum_zl']>0){
				$helpData['top_num']	=	$this -> config['sy_help_topnum'];
				$helpData['top_num_zl']	=	$this -> config['sy_help_topnum_zl'];
			}
			if($this -> config['sy_help_urgentnum']>0 && $this -> config['sy_help_urgentnum_zl']>0){
				$helpData['urgent_num']	=	$this -> config['sy_help_urgentnum'];
				$helpData['urgent_num_zl']	=	$this -> config['sy_help_urgentnum_zl'];
			}
			if($this -> config['sy_help_recnum']>0 && $this -> config['sy_help_recnum_zl']>0){
				$helpData['rec_num']	=	$this -> config['sy_help_recnum'];
				$helpData['rec_num_zl']	=	$this -> config['sy_help_recnum_zl'];
			}

			$package	=	$this -> packageList($helpData);
			
		}

		return $package;
	
	}
	
}
?>