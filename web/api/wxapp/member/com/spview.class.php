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
class spview_controller extends com_controller{
	
	function info_action(){
		$sid			=	intval($_POST['id']);
		$spviewM		=	$this -> MODEL('spview');
		$row 			=   $spviewM->getInfo(array('id' => $sid,'uid'=>$this->member['uid']),array('wxapp'=>1));

		$jobM   		=   $this->MODEL('job');
		$jobwhere   	=   array(
            'uid'       =>  $this->member['uid'],
            'state'     =>  1,
            'status'    =>  0,
            'r_status'  =>  1
        );
        $List    		=   $jobM->getList($jobwhere,array('field'=>'`name`,`id`'));

        $jobid          =   !empty($row['jobid']) ? explode(',', $row['jobid']) : array();
        foreach ($List['list'] as $key => $value) {

        	$jobArr[$key]['id'] 		=	$value['id'];
            $jobArr[$key]['name'] 		=	$value['name'];
            if (in_array($value['id'], $jobid)){
                $jobArr[$key]['checked'] 	=	true;
            }else{
                $jobArr[$key]['checked'] 	=	false;
            }
        }

		$data['info']	=	$row;
		$data['jobarr']	=	count($jobArr) ? $jobArr : array();
		// 简历要求
		$otherarr  =  array(
		    1 => array('id'=>1,'name'=>'工作经历','checked'=>false),
		    2 => array('id'=>2,'name'=>'教育经历','checked'=>false),
		    3 => array('id'=>3,'name'=>'项目经历','checked'=>false),
		);
		
		$other_varr = $row['other'] ? @explode(',', $row['other']) : array();
		foreach($otherarr as $k=>$v){
		    if(in_array($v['id'],$other_varr)){
		        $otherarr[$k]['checked']=true;
		    }
		}
		$data['otherarr'] = $otherarr;
		
		$this->render_json(1,'',$data);
	}

	function saveSpview_action(){

		if(isset($_POST)){
			$spviewM = $this->MODEL('spview');
			$post  =  array(
				'id'			=>	intval($_POST['id']),
				'uid'    		=>  $this->member['uid'],
				'starttime'		=>	strtotime($_POST['starttime']),
				'jobid'         =>  $_POST['jobid'],
				'exp'			=>	$_POST['exp'],
				'edu'			=>	$_POST['edu'],
				
				'remark'		=>	strip_tags($_POST['remark']),
			    'other'			=>	$_POST['other']

			);

            $return =   $spviewM->addInfo($post);

		}else{

			$return['errcode']	=	8;
			$return['msg']		=	'数据错误,请重试';
		}
		$this->render_json($return['errcode'],$return['msg']);
	}

	function spviewList_action(){
		$spviewM					=	$this -> MODEL('spview');
		$where['uid']				=	$this -> member['uid'];
        $total = $spviewM->getNum($where);
		$page						=		$_POST['page'];
		if ($_POST['limit']){
			$limit					=		$_POST['limit'];
			if($page){
				$pagenav			=		($page-1)*$limit;
				$where['limit']		=		array($pagenav,$limit);
			}else{
				$where['limit']		=		$limit;
			}         
		}
		$where['orderby']	=	array('id,desc');
		$rows				=	$spviewM -> getList($where);

		$data	=	array();
		
		if(is_array($rows) && !empty($rows)){
			$data['list']	=	$rows;
			$error	=	0;
		}else{
			$error	=	2;
		}
		$data['iosfk']	=	$this->config['sy_iospay'];
		$this->render_json($error,'',$data,$total);
	}
	
	function delSpview_action(){
		$spviewM=	$this -> MODEL('spview');
		$id   	= 	intval($_POST['id']);
		$return	=	$spviewM -> delSpview($id,array('uid'=>$this->member['uid']));
		if($return['errcode']==9){
			$error	=	1;
		}else{
			$error	=	2;
		}
		$this->render_json($error,$return['msg']);
	}

	function spresume_action(){
		$spviewM					=	$this -> MODEL('spview');
		$where['sid']				=	$_POST['sid'];
		$where['comid']             =   $this->member['uid'];
		
		$data['total']              =   $spviewM->getSubNum($where);
		
		$page						=	$_POST['page'];
		if ($_POST['limit']){
			$limit					=	$_POST['limit'];
			if($page){
				$pagenav			=	($page-1)*$limit;
				$where['limit']		=	array($pagenav,$limit);
			}else{
				$where['limit']		=	$limit;
			}         
		}
		$where['orderby']	=	array('id,desc');
		$rows				=	$spviewM -> getSubList($where, array('resume'=>1,'job'=>1));

		$data	=	array();
		if(is_array($rows) && !empty($rows)){
			$data['list']	=	$rows;
			$error	=	0;
		}else{
			$error	=	2;
		}
		$this->render_json($error,'',$data);
	}

	function delSub_action(){

		$spviewM=	$this -> MODEL('spview');
		$id   	= 	intval($_POST['id']);
		$return	=	$spviewM -> delSub($id,array('comid'=>$this->member['uid']));
		if($return['errcode']==9){
			$error	=	1;
		}else{
			$error	=	2;
		}
		$this->render_json($error,$return['msg']);
	}
	//获取面试列表和当前面试人信息
	function getLineData_action(){
	    
	    $data = array(
	        'sid'	=>	$_POST['sid'],
	        'uid'	=>	$this->member['uid'],
	        'nowuid'=>	$_POST['nowuid']
	    );
	    
	    $spviewM	=	$this->MODEL('spview');
	    
	    $res 		=	$spviewM->getLineData($data, 'wap');
	    
	    $trtcM  =  $this->MODEL('trtc');
	    $trtc   =  $trtcM->getUserSig(array('uid'=>$this->member['uid'], 'usertype'=>2));
	    
	    $return  =  array(
	        'room' => array(
	            'subnum'   =>  !empty($res['subnum']) ? $res['subnum'] : 0,
	            'linenum'  =>  !empty($res['linenum']) ? $res['linenum'] : 0,
	            'msnum'    =>  !empty($res['msnum']) ? $res['msnum'] : 0
	        ),
	        'list'    =>  !empty($res['expects']) ? $res['expects'] : array(),
	        'nowuid'  =>  !empty($res['nowuid']) ? $res['nowuid'] : 0,
	        'status'  =>  0,
	        'roomId'  =>  $trtc['roomid']
	    );
	    
	    $this->render_json($res['errorcode'],$res['msg'],$return);
	}
	// 视频面试房间查看具体简历
	function getResume_action(){
	    
	    $resumeM  =  $this->MODEL('resume');
	    $resume   =  $resumeM -> getInfoByEid(array('uid'=>$this->member['uid'],'eid'=>$_POST['eid'],'usertype'=>2));
	    
	    $this->render_json(0, 'ok', $resume);
	}
	// 查询单条预约信息
	function getSub_action(){
	    
	    $spviewM  =  $this->MODEL('spview');
	    $row      =  $spviewM->getSubinfo(array('sid'=>$_POST['sid'],'uid'=>$_POST['msuid']), array('job'=>1,'resume'=>1));
	    
	    $this->render_json(0, '', $row);
	}
	// 视频面试，结束当前面试
	function spviewPause_action(){
	    
	    $spviewM  =  $this->MODEL('spview');
	    
	    $res 	  =  $spviewM->spviewPause(array('sid'=>(int)$_POST['sid'],'uid'=>$this->member['uid']));
	    
	    $this->render_json(0, '', $res);
	}
	/**
	 * 视频面试成功，修改视频请求状态
	 */
	function spSuccess_action(){
	    
	    $comment  =  explode('_', $_POST['commentID']);
	    $userid   =  $comment[1];
	    
	    $arr  =  array(
	        'uid'     =>  $userid,
	        'comid'   =>  $this->member['uid'],
	        'roomId'  =>  $_POST['roomId'],
	        'jobid'   =>  $_POST['jobid'],
	        'sid'     =>  $_POST['sid'],
	        'zid'     =>  $_POST['zid']
	    );
	    
	    $spviewM  =  $this->MODEL('spview');
	    $splogid  =  $spviewM->addSpviewLog($arr);
	    
	    $return   =  array('splogid'=>$splogid);
	    
	    $this->render_json(0,'ok',$return);
	}
	/**
	 * 记录视频面试时长
	 */
	function splog_action(){
	    
	    $return   =  array('error'=>0);
	    
	    if(!empty($_POST['splogID'])){
	        
	        $sptime   =  round(($_POST['endTime'] - $_POST['startTime'])/1000);
	        
	        $spviewM  =  $this->MODEL('spview');
	        $spviewM->updateSpviewLog(array('id'=>$_POST['splogID']), array('sptime'=>$sptime));
	        
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
	            
	            $splog  =  $spviewM->getSpviewLog(array('id'=>$_POST['splogID']), array('field'=>'`uid`,`comid`'));
	            
	            $arr['msgtype']    =  'spview';
	            $arr['timestamp']  =  time() * 1000;
	            $arr['fromid']     =  $this->member['uid'];
	            $arr['fusertype']  =  $this->member['usertype'];
	            $arr['nowid']      =  $this->member['uid'];
	            $arr['nowtype']    =  $this->member['usertype'];
	            
	            if ($this->member['usertype'] == 1){
	                
	                $arr['toid']       =  $splog['comid'];
	                $arr['tusertype']  =  2;
	                
	            }elseif ($this->member['usertype'] == 2){
	                
	                $arr['toid']       =  $splog['uid'];
	                $arr['tusertype']  =  1;
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
	    
	    $this->render_json(0,'ok',$return);
	}
}