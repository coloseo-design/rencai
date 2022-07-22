<?php
/* *
* $Author ：PHPYUN开发团队
*
* 官网: http://www.phpyun.com
*
* 版权所有 2009-2021 宿迁鑫潮信息技术有限公司，并保留所有权利。
*
* 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
*/
class spview_controller extends company{
	//招聘会
	function index_action(){
		$this->public_action();
		
		$spviewM   =   $this->MODEL('spview');
        
		$urlarr['c']	=	'spview';
		$urlarr['page']	=	'{{page}}';
		$pageurl		=	Url('member',$urlarr);
		$where['uid']	=	$this ->uid;
		
		$pageM	=	$this  -> MODEL('page');
		$pages	=	$pageM -> pageList('spview',$where,$pageurl,$_GET['page'],$this->config['sy_listnum']);
		
		if($pages['total'] > 0){
			if($_GET['order'])
			{
				$where['orderby']		=	$_GET['t'].','.$_GET['order'];
				$urlarr['order']		=	$_GET['order'];
				$urlarr['t']			=	$_GET['t'];
			}else{
				$where['orderby']		=	'id';
			}
			$where['limit']	=	$pages['limit'];
			
			$List	=	$spviewM -> getList($where);
			
			$this->yunset('rows' , $List);
		}
		$this->com_tpl('splist');
	}
    /**
     * 企业发布视频面试/视频面试房间
     */
	function sproom_action(){

	    if (empty($this->config['sy_spview_appkey']) || empty($this->config['sy_spview_appsecret'])){
	        
	        $this->ACT_msg('index.php', '网站未配置视频面试功能');
	    }
	    if (strpos($this->config['sy_weburl'], 'https') === false) {
	        
	        $this->ACT_msg('index.php', '网站未配置HTTPS，无法使用视频面试功能');
	    }
	    
	    if ($_GET['id']){
	        
	        $id 		=	$_GET['id'];
	        
	        $spviewM	=	$this->MODEL('spview');
	        
	        $spview		=	$spviewM->getInfo(array('id'=>$id,'uid'=>$this->uid));
	        
	        if(empty($spview)){
	            
	            $this->ACT_msg("index.php?c=spview","该面试间不存在！",8);
	            
	        }else if($spview['status']!=1){
	            
	            $this->ACT_msg("index.php?c=spview","该面试间尚未通过审核！",8);
	            
	        }else if($spview['roomstatus']==1){
	            
	            $this->ACT_msg("index.php?c=spview","该面试间已关闭！",8);
	            
	        }
	        
	        $this->yunset('spview',$spview);
	    }
		
		$trtcM  =  $this->MODEL('trtc');
		$trtc   =  $trtcM->getUserSig(array('uid'=>$this->uid, 'usertype'=>2));
		
		if (!empty($trtc['errcode'])){
		    
		    $this->ACT_msg('index.php', $trtc['msg']);
		}
		
		$trtcConfig  =  array(
		    'userId'      =>  $trtc['wid'] .'_'.$this->uid,
            'roomId'      =>  $trtc['roomid'],
            'sdkAppId'    =>  $trtc['appid'],
            'userSig'     =>  $trtc['usersig'],
		    'csRoomId'    =>  $trtc['csroomid'],
            'spWait'      =>  $this->config['sy_spview_wait'] * 1,
            'spLong'      =>  $this->config['sy_spview_time'] * 1
        );
		
		$this->yunset('trtcConfig',$trtcConfig);
		
		$this->public_action();
		
		$this->com_tpl('sproom');
	}
	//获取面试列表和当前面试人信息
	function getLineData_action(){

		$data = array(
			'sid'	=>	$_POST['sid'],
			'uid'	=>	$this->uid,
			'nowuid'=>	$_POST['nowuid']
		);

		$spviewM	=	$this->MODEL('spview');

		$res 		=	$spviewM->getLineData($data);

		echo json_encode($res);die;
	}
	function getResumeDtail_action(){
		
		$ruid			=	intval($_POST['uid']);

		$sid			=	intval($_POST['sid']);
		
		$spviewM		=	$this->MODEL('spview');

		$resumeM		=	$this->MODEL('resume');

		$subinfo		=	$spviewM->getSubinfo(array('sid'=>$sid,'uid'=>$ruid,'comid'=>$this->uid));

		if($subinfo['eid']){

			$eid 		=	$subinfo['eid'];

		}else{

		    $expect     =	$resumeM -> getExpectByUid($ruid,array('field'=>'id'));
			$eid		=	$expect['id'];
		}
		
		$resume 		=	$resumeM -> getInfoByEid(array('uid'=>$this->uid,'eid'=>$eid,'usertype'=>$this->usertype));

		if(!empty($resume)){
			// 查询黑名单
        	$blackM         =   $this->MODEL('black'); 
        	$blackInfo      =   $blackM -> getBlackInfo(array('p_uid' => $this->uid, 'c_uid'=> $resume['uid']));
        
		}

		if(empty($resume)){

            $data['msg']        =   '没有找到该人才！';
            $data['error']		=	2;
            
        }elseif($resume['state'] == 0){
            
            $data['msg']        =   '简历正在审核中！';
            $data['error']		=	2;
            
        }elseif($resume['r_status'] == 2){
            
            $data['msg']        =   '简历暂被锁定，请稍后查看！';
            $data['error']		=	2;
        
        }elseif($resume['state'] == 3){

        	$data['msg']        =   '简历审核暂未通过！';
            $data['error']		=	2;
        
        }elseif(!empty($blackInfo)){

        	$data['msg']        =   '该用户已关闭简历!';
            $data['error']		=	2;

        }else{

        	$data['resume']		=	count($resume) ? $resume : array();
        	$data['error']		=	1;

        }
       	
       	echo json_encode($data);die;
	}
	//面试暂停
	function spviewPause_action(){

		$spviewM	=	$this->MODEL('spview');

		$res 		=	$spviewM->spviewPause(array('sid'=>(int)$_POST['sid'],'uid'=>$this->uid));

		echo json_encode($res);die;

	}
	//下一位
	function spviewNext_action(){

		$spviewM	=	$this->MODEL('spview');

		$res 		=	$spviewM->spviewNext(array('sid'=>(int)$_POST['sid'],'uid'=>$this->uid,'nowuid'=>$_POST['nowuid']));

		echo json_encode($res);die;
	}	
	//关闭面试房间
	function spviewFinish_action(){

		$spviewM	=	$this->MODEL('spview');

		$res 		=	$spviewM->spviewFinish(array('sid'=>(int)$_POST['sid'],'uid'=>$this->uid));

		echo json_encode($res);die;
	}
	// 记录视频面试备注
	function spviewRemark_action(){
	    
	    $data       =  array(
	        'content'  =>  $_POST['content']
	    );
	    
	    $spviewM	=	$this->MODEL('spview');
	    $res 		=	$spviewM->updateSubcribe(array('sid'=>(int)$_POST['sid'],'uid'=>(int)$_POST['uid']), $data);
	}
	// 查询单条预约信息
	function getSub_action(){
	    
	    $spviewM  =  $this->MODEL('spview');
	    $row      =  $spviewM->getSubinfo(array('sid'=>$_POST['sid'],'uid'=>$_POST['msuid']), array('job'=>1,'resume'=>1));
	    
	    echo json_encode($row);die;
	}
	function delSp_action(){
		
		$spviewM   	=	$this -> MODEL('spview');

		if($_POST['delid']||$_GET['id']){
			
			if ($_GET['id']){
				
				$id   =  intval($_GET['id']);
			}elseif ($_POST['delid']){
				
				$id   =  $_POST['delid'];
			}
			
			$return	=	$spviewM -> delSpview($id, array('uid' => $this->uid));
			$this -> layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
		}
	}
	// 视频面试预约简历
	function spresume_action(){
	    
	    $this -> public_action();
	    
	    $spviewM	=   $this -> MODEL('spview');
	    
	    $where		=	array('comid' => $this->uid);
	    
	    if($_GET['sid']){
	        
	        $where['sid']	=	$_GET['sid'];
	        $this->yunset('sid',$_GET['sid']);
	        
	    }else{
	        
	        $this->ACT_msg('index.php?c=spview','参数异常');
	    }
	    if(!empty($_GET['jobid'])){
	        
	        $where['jobid']	=	$_GET['jobid'];
	        $this->yunset('cjobid',$_GET['jobid']);
	        
	    }
	    //分页链接
	    $urlarr['c']	=	$_GET['c'];
	    $urlarr['act']	=	$_GET['act'];
	    $urlarr['page']	=	'{{page}}';
	    
	    $pageurl		=	Url('member',$urlarr);
	    
	    //提取分页
	    $pageM			=	$this  -> MODEL('page');
	    $pages			=	$pageM -> pageList('spview_subscribe', $where, $pageurl,$_GET['page']);
	    
	    //分页数大于0的情况下 执行列表查询
	    if($pages['total'] > 0){
	        
	        $where['orderby']	=	'ctime';
	        $where['limit']		=	$pages['limit'];
	        $rows				=	$spviewM -> getSublist($where, array('resume'=>1,'job'=>1));
	    }
	    
	    $spview   =	$spviewM -> getInfo(array('id'=>intval($_GET['sid'])),array('field'=>'jobid'));
	    $jids     =  @explode(",",$spview["jobid"]);
	    
	    $jobM 	  =  $this->MODEL('job');
	    $JobList  =  $jobM->getList(array('id'=>array('in',pylode(',',$jids))),array('field'=>'id,name'));
	    
	    $this -> yunset(array('rows' => $rows));
	    $this -> yunset('JobList',$JobList['list']);
	    $this -> com_tpl('spresume');
	}
	// 删除预约
	function delSub_action(){
	    
	    if($_POST['delid']||$_GET['delid']){
	        
	        if(is_array($_POST['delid'])){
	            $id  =   $_POST['delid'];
	        }else{
	            $id  =   intval($_GET['delid']);
	        }
	        
	        $spviewM  =  $this -> MODEL('spview');
	        $return	  =  $spviewM -> delSub($id, array('comid' => $this->uid));
	        $this ->  layer_msg($return['msg'], $return['errcode'], $return['layertype'],$_SERVER['HTTP_REFERER']);
	        
	    }
	}
	// 预约备注
	function setContent_action(){
	    
	    $spviewM	=	$this->MODEL('spview');
	    $data		=	array(
	        'content'	=>	$_POST['content'],
	        'id'		=>	$_POST['id'],
	        'comid'		=>	$this->uid
	    );
	    $return		=	$spviewM -> setContent($data);
	    $this -> ACT_layer_msg($return['msg'],$return['errcode'],$_SERVER['HTTP_REFERER']);
	}
	/**
	 * 网络招聘会视频面试、普通单对单视频面试
	 */
	function webrtc_action(){
	    
	    if (empty($this->config['sy_spview_appkey']) || empty($this->config['sy_spview_appsecret'])){
	        
	        $this->ACT_msg('index.php', '网站未配置视频面试功能');
	    }
	    if (strpos($this->config['sy_weburl'], 'https') === false) {

	        $this->ACT_msg('index.php', '网站未配置HTTPS，无法使用视频面试功能');
	    }
	    
	    $trtcM  =  $this->MODEL('trtc');
	    $trtc   =  $trtcM->getUserSig(array('uid'=>$this->uid, 'usertype'=>2));
	    
	    if (!empty($trtc['errcode'])){
	        
	        $this->ACT_msg('index.php', $trtc['msg']);
	    }
	    
	    $trtcConfig  =  array(
	        'userId'      =>  $trtc['wid'] .'_'.$this->uid,
	        'commentID'   =>  $_GET['fuid'],
	        'roomId'      =>  $trtc['roomid'],
	        'sdkAppId'    =>  $trtc['appid'],
	        'userSig'     =>  $trtc['usersig'],
	        'csRoomId'    =>  $trtc['csroomid'],
	        'spWait'      =>  $this->config['sy_spview_wait'] * 1,
	        'spLong'      =>  $this->config['sy_spview_time'] * 1
	    );

	    
	    $this->yunset('trtcConfig',$trtcConfig);
	    
	    $this->public_action();
	    
	    $this->com_tpl('webrtc');
	}
	function webrtcRemark_action(){

		$zid 		= $_POST['zid'];
        $uid 		= $_POST['uid'];
        $content 	= trim($_POST['content']);
        $splogid 	= $_POST['splogid'];
		
		if ($splogid && $uid && $zid){
	        
	        if($content){

	        	$spviewM	=	$this->MODEL('spview');

	        	$spwhere  	=	array(
	        		'id'	=>	$splogid,
	        		'comid'	=>	$this->uid,
	        		'uid'	=>	$uid,
	        		'zid'	=>	$zid
				);
	        	$spviewM->updateSpviewLog($spwhere, array('remark'=>$content));

	        	$return['error'] = 1;
	    		$return['msg']   = '保存成功';

	        }else{

	        	$return['error'] = -1;
	    		$return['msg']   = '请填写备注内容';

	        }

	    }else{

	    	$return['error'] = -1;
	    	$return['msg']   = '参数错误，请重试';

	    }
		
	    echo json_encode($return);
	}
	/**
	 * 视频面试接通
	 */
	function spSuccess_action(){
	    
	    $arr  =  array(
	        'uid'     =>  $_POST['uid'],
	        'comid'   =>  $this->uid,
	        'roomId'  =>  $_POST['roomId'],
	        'jobid'   =>  $_POST['jobid'],
	        'sid'     =>  $_POST['sid'],
	        'zid'     =>  $_POST['zid']
	    );
	    
	    $spviewM  =  $this->MODEL('spview');
	    $splogid  =  $spviewM->addSpviewLog($arr);
	    
	    echo $splogid;
	}
	/**
	 * 记录视频面试时长
	 */
	function splog_action(){
	    
	    $return['error'] = 0;
	    $return['msg']   = 'ok';
	    
	    if (!empty($_POST['splogid'])){
	        
	        $sptime   =  round(($_POST['endTime'] - $_POST['startTime'])/1000);
	        
	        $spviewM  =  $this->MODEL('spview');
	        $spviewM->updateSpviewLog(array('id'=>$_POST['splogid'],'comid'=>$this->uid), array('sptime'=>$sptime));
	        
	        $time  =  $this->config['sy_spview_time'] * 60;
	        
	        if ($sptime >= $time){
	            
	            $return['error'] = 2;
	            $return['msg'] = '单次视频面试最长'.$this->config['sy_spview_time'].'分钟';
	            
	        }elseif ($sptime + 120 >= $time && $sptime + 90 < $time && $this->config['sy_spview_time'] > 2){
	            
	            $return['error'] = 1;
	            $return['msg'] = '本次视频面试还剩2分钟';
	            
	        }elseif ($sptime + 60 >= $time && $sptime + 30 < $time){
	            
	            $return['error'] = 1;
	            $return['msg'] = '本次视频面试还剩1分钟';
	        }
	        // 视频面试结束，记录面试成功聊天记录
	        if (!empty($_POST['spend'])){
	            
	            $splog  =  $spviewM->getSpviewLog(array('id'=>$_POST['splogid']), array('field'=>'`uid`,`comid`'));
	            
	            $arr['msgtype']    =  'spview';
	            $arr['timestamp']  =  time() * 1000;
	            
	            if ($_POST['roomer'] != ''){
	                // 主动邀请方
	                $arr['toid']       =  $splog['uid'];
	                $arr['tusertype']  =  1;
	                $arr['fromid']     =  $this->uid;
	                $arr['fusertype']  =  2;
	                $arr['nowid']      =  $this->uid;
	                $arr['nowtype']    =  2;
	                
	            }else{
	                
	                $arr['toid']       =  $splog['comid'];
	                $arr['tusertype']  =  2;
	                $arr['fromid']     =  $splog['uid'];
	                $arr['fusertype']  =  1;
	                $arr['nowid']      =  $splog['uid'];
	                $arr['nowtype']    =  1;
	            }
	            // 计算整数面试分钟
	            $sptime   =  round(($_POST['endTime'] - $_POST['startTime'])/1000);
	            $f = intval($sptime/60);
	            $m = $sptime%60;
	            
	            if (strlen($f) == 1){
	                $f = '0' . $f;
	            }
	            if (strlen($m) == 1){
	                $m = '0' . $m;
	            }
	            
	            $arr['content'] = '视频时长  ' . $f .':'. $m;
	            
	            $chatM   =  $this -> MODEL('chat');
	            
	            $chatM -> chatLog($arr);
	        }
	    }
	    echo json_encode($return);
	}
	
	function setSplogContent_action(){

		$spviewM	=	$this->MODEL('spview');
	    $data		=	array(
	        'content'	=>	$_POST['content'],
	        'id'		=>	$_POST['id'],
	        'comid'		=>	$this->uid
	    );
	    
	    $return		=	$spviewM -> setSpContent($data);
	    $this -> ACT_layer_msg($return['msg'],$return['errcode'],$_SERVER['HTTP_REFERER']);

	}
}
?>