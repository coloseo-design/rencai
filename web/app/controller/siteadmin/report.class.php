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
class report_controller extends siteadmin_controller{
	
	function index_action(){
	    
	    $reportM       =   $this->MODEL('report');
	    
	    $where         =   array();    
	    
	    $type          =   intval($_GET['type']);
	    
	    $ut            =   intval($_GET['ut']);
	    
	    $keywordStr    =   trim($_GET['keyword']);
	    
	    $ftypeStr      =   intval($_GET['f_type']);
	    
	    $ptypeStr      =   intval($_GET['p_type']);
	    
	    if($type == 0){
	        
	        $where['usertype']     =   $ut==2 ? 2 : 1;
	        
	        $where['type']         =   $type;
			
			if (!empty($keywordStr)){
			    
				if ($ftypeStr == 1){
				    
					$where['r_name']	=	array('like', $keywordStr);
					
				}elseif ($ftypeStr == 2){
				    
				    $where['username']	=	array('like', $keywordStr);
					
				}elseif ($ftypeStr == 3){
				    
				    $where['r_reason']	=	array('like', $keywordStr);
					
				}
				
				$urlarr['ut']			=	$ut;
				$urlarr['f_type']		=	$ftypeStr;
				$urlarr['keyword']      =	$keywordStr;
 				
			}
			
			$type		=	0;
			
			$rowName	=	'userrows';
			
			$this->yunset('ut', $ut);
			
	    }else if($type > 0){
	        
	        $where['type']     =   $type;

	        $status            =   intval($_GET['status']);
	        
	        $where['status']   =   $status == 1 ? 1 : 0;
	        
	        $urlarr['status']  =   $status;
		
			if (!empty($keywordStr)){
				
				if ($ptypeStr == 1){
				    
					$where['r_name']		=	array('like', $keywordStr);	
				
				}else{
				    
					$where['username']		=	array('like', $keywordStr);	
				}
				
				$urlarr['p_type']			=	$ptypeStr;
				$urlarr['keyword']			=	$keywordStr;
			}
			
 			$rowName			=	'q_report';
 		}
 		
		
		//分页链接
		$urlarr['page']   =	  '{{page}}';
		$pageurl          =	  Url($_GET['m'],$urlarr,'admin');
		
		//提取分页
		$pageM            =	  $this  -> MODEL('page');
		$pages            =	  $pageM -> pageList('report',$where,$pageurl,$_GET['page']);
		
		//分页数大于0的情况下 执行列表查询
		if($pages['total'] > 0){
			
			if($_GET['order']){
				$where['orderby']	=	$_GET['t'].",".$_GET['order'];
				
			}else{
				$where['orderby']	=	'id,desc';
			}
			
			$where['limit']			=	$pages['limit'];
			
			$urlarr['order']		=	$_GET['order'];
			
			$urlarr['t']			=	$_GET['t'];
			
			$List					=	$reportM -> getReportList($where,array('utype'=>'admin','type'=>$type));
			
			$this->yunset($rowName,$List['list']);
		}
		
		$adminM   =   $this -> MODEL('admin');
		
		$return   =   $adminM -> getPower(array('uid' => intval($_SESSION['aui'])));
		
		$power    =   $return['power'];
		
		if(in_array('141',$power)){
		    
			$this->yunset('email_promiss', '1');
			
		}
		
		$back_url	=	$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
		
		$this->yunset('get_type', $_GET);
		$this->yunset('type',$type);
		$this->yunset('back_url',$back_url);
		
		$this->siteadmin_tpl(array('admin_report_userlist'));
	}
	
	function recommend_action(){
		$reportM	=	$this->MODEL('report');
		$logM		=	$this->MODEL('log');
		
		$data[$_GET['type']]	=	$_GET['rec'];
		$where['id']			=	$_GET['id'];
		$where['type']			=	'1';
		$nid		=	$reportM->upReport($where,$data);
		
		$logM->addAdminLog("举报问答(ID:".$_GET['id'].")设置是否处理");
		echo $nid?1:0;die;
	}
	function result_action(){
		$reportM	=	$this->MODEL('report');
		$adminM		=	$this->MODEL('admin');
		
		$info		=	$reportM->getReportOne(array('id'=>intval($_POST['id'])),array('field'=>'`result`,`rtime`,`admin`'));
		if($info['admin']){
			$adminname		=	$adminM->getAdminUser(array('uid'=>$info['admin']),array('field'=>'`name`'));
			$info['admin']	=	$adminname['name'];
			$info['rtime']	=	date('Y-m-d H:i',$info['rtime']);
		}
		echo json_encode($info);die;
	}
	function  saveresult_action(){
		$reportM	=	$this->MODEL('report');
		
		$data['result']		=	trim($_POST['result']);
		$data['admin']		=	$_SESSION['auid'];
		$data['rtime']		=	time() ;
		
		$where['id']		=	intval($_POST['pid']);
		
		$nid		=	$reportM->upReport($where,$data);
		$this->ACT_layer_msg("操作成功！",9,$_SERVER['HTTP_REFERER']);
	}
	
    
	/**
	 * @desc 删除举报简历
	 */
	function delresume_action(){
	    
	    $reportM   =   $this->MODEL('report');
	    $resumeM   =   $this->MODEL('resume');
	    $statisM   =   $this->MODEL('statis');
	    
	    $integralM =   $this->MODEL('integral');
	    $orderM    =   $this->MODEL('companyorder');
	    $downM     =   $this->MODEL('down_resume');
	    
	    $eid       =   intval($_GET['eid']);
	    $id        =   intval($_GET['id']);
	    $uid       =   intval($_GET['uid']);
	    
	    $report    =   $reportM -> getReportOne(array('id' => $id), array('field'=> '`p_uid`'));
	    $comid     =   intval($report['p_uid']);
	    
	    $dresume   =   $downM -> getDownResumeInfo(array('eid' => $eid, 'uid' => $uid, 'comid' => $comid),array('field'=>'`eid`'));
	    
	    if (!empty($dresume)) {
	         
	        
	        $order     =   $orderM -> getInfo(array('type' => 19, 'sid' => $eid, 'order_remark' => array('like', '下载简历'), 'uid' => $comid), array('field' => '`order_price`'));
	        
	        $compay    =   $integralM -> getInfo(array('type' => 1 ,'eid', 'pay_type' => '12', 'pay_remark' => array('like', '下载简历'), 'com_id' => $comid), array('field' => '`order_price`'));
	        
	    }
 	    
	    $result    =   $resumeM -> delResume($eid,array('utype'=>'admin'));
		
	    if ($result) {
	        
	        if (!empty($order) && is_array($order)) {
                
	            $integralM -> company_invtal($comid,2,$order['order_price'],true,'举报简历返还金额',true,2,'packpay',99);
	            
	        }
	        if (!empty($compay) && is_array($compay)) {
	            
	            $integralM -> company_invtal($comid,2,abs($compay['order_price']),true,'举报简历返还积分',true,2,'integral',99);
	            
	        }
	        if (empty($order) && empty($compay)) {
	            
	            $statisM   ->  upInfo(array('down_resume' => array('+', 1)), array('usertype' => 2, 'uid' => $comid));
	            
	        }
	        
	        $statisM   ->  upInfo(array('resume_num' => array('-' , 1)), array('usertype'=>1,'uid'=>$uid));
	        
	        $return    =   $reportM -> delReport(array('id' => $id),array('title'=>'简历'));
	        
	        $this->layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER'],2,1);
	        
	    }
	}
	
	function deljob_action(){
		$reportM	=	$this->MODEL('report');
		$jobM		=	$this->MODEL('job');
		$jobM		->	delJob(array('id'=>$_GET['eid']), array('utype'=>'admin'));
		$return 	=	$reportM->delReport(array('id'=>$_GET['id']),array('title'=>'职位'));
		
		$this->layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER'],2,1);
	}
	
	function del_action(){
		$reportM	=	$this->MODEL('report');
		$this->check_token(); 
		
		$return 	=	$reportM->delReport(array('id'=>$_GET['del']),array('title'=>'举报'));
		$this	->	layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER'],2,1);
	}
	function delquestion_action(){		
		if($_GET['del']){
			$askM	=	$this->MODEL('ask');
			$askM->DeleteQuestion($_GET['del']);
			$this->layer_msg('问答(ID:'.$_GET['del'].')删除成功！',9,0,$_SERVER['HTTP_REFERER']);		
		}
	}
	
	function show_action(){
		if($_POST['id']){
			$reportM			=	$this->MODEL('report');
			$row				=	$reportM->getReportOne(array('id'=>$_POST['id']),array('field'=>'`r_reason`'));
			$data['r_reason']	=	$row['r_reason'];
			
			echo json_encode($data);die;
		}
	}
	
	function showxjh_action(){
		if($_POST['id']){
			$reportM			=	$this->MODEL('report');
			$row				=	$reportM->getReportOne(array('id'=>$_POST['id'],'type'=>'3'),array('field'=>'`r_reason`'));
			$reason				=	explode('@',$row['r_reason']);
			if($_POST['type']=='error'){
				
				$data['r_reason']	=	$reason[0];
				
			}elseif($_POST['type']=='right'){
				
				$data['r_reason']	=	$reason[1];
			}
			
			echo json_encode($data);die;
		}
	}
}

?>