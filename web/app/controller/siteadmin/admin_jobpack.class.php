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
class admin_jobpack_controller extends siteadmin_controller{
    
    
    /**
     * @desc 后台红包推广管理首页
     */
    function index_action(){
 		
	    $comM      =   $this -> MODEL('company');
	    $packM     =   $this -> MODEL('pack');
	    
		if($_GET['uid']){
		    
            $where['uid']       =   intval($_GET['uid']);
            $urlarr['uid']      =   intval($_GET['uid']);
            
            $ccom               =   $comM -> getInfo(intval($_GET['uid']), array('field'=>'`name`'));
            
			$this -> yunset("ccname", $ccom['name']);

		}
		
		//分页链接
		$urlarr['page']	=	'{{page}}';
		
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');
		
		//提取分页
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('company_job_share',$where,$pageurl,$_GET['page']);
		
		
		//分页数大于0的情况下 执行列表查询
		if($pages['total'] > 0){
		    
		    //limit order 只有在列表查询时才需要
		    if($_GET['order']){
		        
		        $where['orderby']		=	$_GET['t'].','.$_GET['order'];
		        $urlarr['order']		=	$_GET['order'];
		        $urlarr['t']			=	$_GET['t'];
		        
		    }else{
		        
		        $where['orderby']		=	array('id,desc');
		        
		    }
		    
		    $where['limit']				=	$pages['limit'];
		    
		    $shareList    =   $packM -> getShareJobList($where,array('utype'=>'admin'));
		    
		    $this -> yunset('rows', $shareList);
		    
		}
 		$this->siteadmin_tpl(array('admin_jobpack'));
	}
    
	/**
	 * @desc 后台赏金职位管理  --  悬赏职位
	 */
	function reward_action(){
		
	    $comM      =   $this -> MODEL('company');
	    $packM     =   $this -> MODEL('pack');
	    
        if($_GET['uid']){
 		    
            $where['uid']   =   intval($_GET['uid']);
            
 			$urlarr['uid']  =   intval($_GET['uid']);
            
 			$ccom           =   $comM -> getInfo(intval($_GET['uid']), array('field'=>'`name`'));
 			
			$this -> yunset("ccname", $ccom['name']);

		}
		
		//分页链接
		$urlarr['c']	=	'reward';
		$urlarr['page']	=	'{{page}}';
		
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');
		
		//提取分页
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('company_job_reward',$where,$pageurl,$_GET['page']);
		
		
		//分页数大于0的情况下 执行列表查询
		if($pages['total'] > 0){
		    
		    //limit order 只有在列表查询时才需要
		    if($_GET['order']){
		        
		        $where['orderby']		=	$_GET['t'].','.$_GET['order'];
		        $urlarr['order']		=	$_GET['order'];
		        $urlarr['t']			=	$_GET['t'];
		        
		    }else{
		        
		        $where['orderby']		=	array('uid,desc');
		        
		    }
		    
		    $where['limit']				=	$pages['limit'];
		    
            $rewardList                 =   $packM -> getRewardJobList($where, array('utype'=>'admin'));
		    
            $this -> yunset('rows', $rewardList);
		    
		}
		
 		$this->siteadmin_tpl(array('admin_jobrewardpack'));
	}
	
	
	/**
	 * @desc 后台赏金职位管理  -- 悬赏管理 -- 应聘列表
	 */
	function rewardlog_action(){
	    
	    $packM     =   $this -> MODEL('pack');
	    
		if($_GET['jobid']){
		    
            $where['jobid']     =   intval($_GET['jobid']);
            $urlarr['jobid']    =   intval($_GET['jobid']);
            
		}
		
		//分页链接
		$urlarr['c']	=	'rewardlog';
		$urlarr['page']	=	'{{page}}';
		
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');
		
		//提取分页
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('company_job_rewardlist',$where,$pageurl,$_GET['page']);
		
		//分页数大于0的情况下 执行列表查询
		if($pages['total'] > 0){
		    
            $where['orderby']		=	array('datetime,desc');
		        
            $where['limit']         =	$pages['limit'];
		    
            $jobRewardList          =   $packM -> getJobRewardList($where, array('utype'=>'admin'));
  		    
            $this -> yunset('rows', $jobRewardList);
		    
		}
		
 		$this->siteadmin_tpl(array('admin_jobrewardlog'));
	}

	/**
	 * @desc 获取相关职位企业等信息
	 */
	function getreward_action(){
		if($_POST){
			$M	=	$this->MODEL('pack');
			$Info = $M->getRewardAll($_POST['rewardid'],26);
			echo json_encode($Info);
		}
	}

	function getarb_action(){
		if($_POST){

			$M	=	$this->MODEL('pack');
			//获取相关职位企业等信息

			$return	=  $M -> logStatus((int)$_POST['rewardid'],(int)$_POST['status'],$_SESSION['auid'],'admin',array('content'=>$_POST['content'], 'port' => '5'));
				
			 if($return['error']==''){
				//仲裁操作成功
				 echo json_encode(array('error'=>'ok'));
					
			 }else{
				 //仲裁操作失败
				 
				 echo json_encode(array('error'=>$return['error']));
			 }
		}
	}
	
	/**
	 * @desc 删除分享职位
	 */
	function delshare_action(){
	    
	    if (intval($_GET['delid'])) {
	        
	        $this -> check_token();
 	        
	        $M         =   $this -> MODEL('pack');
	        
	        $addArr    =   $M ->delShareJob('', intval($_GET['delid']),array('utype'=>'admin'));
	        
	        $this   ->  layer_msg( $addArr['msg'],$addArr['errcode'],0,$_SERVER['HTTP_REFERER'],2,1);
	    }
	     
	}

	/**
	 * @desc 删除悬赏职位
	 */
	function delreward_action(){
		
	    if(intval($_GET['delid'])){
		    
		    $this -> check_token();
		    
		    $M         =   $this -> MODEL('pack');
		    
		    $addArr    =   $M ->delrewardJob('', intval($_GET['delid']),array('utype'=>'admin'));
		   
		    $this   ->  layer_msg( $addArr['msg'],$addArr['errcode'],0,$_SERVER['HTTP_REFERER'],2,1);
		}
		
	}
}
