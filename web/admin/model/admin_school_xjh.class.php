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
class admin_school_xjh_controller extends adminCommon{
	//设置高级搜索功能
	function set_search(){
		$search_list[]	=	array("param"=>"status","name"=>'审核状态',"value"=>array("3"=>"未审核","1"=>"已审核","2"=>"未通过","4"=>"已锁定"));
		$search_list[]	=	array("param"=>"state","name"=>'举办状态',"value"=>array("1"=>"待举办","2"=>"开讲中","3"=>"已结束"));
		$search_list[]	=	array("param"=>"adtime","name"=>'发布时间',"value"=>array("1"=>"今天","3"=>"最近三天","7"=>"最近七天","15"=>"最近半月","30"=>"最近一个月"));
		$this->yunset("search_list",$search_list);
	}
	function index_action(){
    
		$schoolM   =   $this->MODEL('school');
    
		$this->set_search();
		
		if($_GET['keyword']){

			$keyword  			=   trim($_GET['keyword']);
			$where['address'] 	= 	array('like',$keyword);		
			$urlarr['keyword']	=	$_GET['keyword'];

		}
		if($_GET['status']){
      
			$status   			=   intval($_GET['status']);
      if($status==4){
        $where['r_status']			=	  array('>', 1);
      }else{
        $where['status']	=  	$status == 3 ? 0 : $status;
        $where['r_status']			=	  array('=', 1);
      }
			$urlarr['status']	=  	$status;
		}
		if($_GET['state']){
      
			$state  =   intval($_GET['state']);
      
			if($state==1){
        
				$where['stime']		= 	array(">",time());
          
			}else if($state==2){
        
				 $where['stime']	= 	array("<",time());
				 $where['etime']	= 	array(">",time());
        
        
			}else if($state==3){
        
				$where['etime']		= 	array("<",time());
        
			}
			$urlarr['state']		=	$state;
		}
		if($_GET['adtime']){
      
			if($_GET['adtime']=='1'){
        
				 $where['ctime']	=  	array('>=',strtotime('today'));
         
			}else{
        
				$where['ctime']		=  	array('>=',strtotime('-'.intval($_GET['adtime']).' day'));
         
			}
			$urlarr['adtime']		=	$_GET['adtime'];
		}
		$urlarr        	=   $_GET;
		$urlarr['page'] = 	'{{page}}';
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('school_xjh',$where,$pageurl,$_GET['page']);
    
		if($pages['total']  > 0){
		   //limit order 只有在列表查询时才需要
		   if($_GET['order']){
			  if($_GET['t']=='atnnum'){
					$atnM		=   $this->MODEL('atn');
					$atnwhere['xjhid']		=	array('<>',0);
					$atnwhere['groupby']	=	'xjhid';
					$atnwhere['orderby']	=	array('count(xjhid),'.$_GET['order']);
					$alist		=	$atnM ->getatnList($atnwhere,array('field'=>'`xjhid`'));
					
					foreach($alist as $val){
						$auid[]	=	$val['xjhid'];
					}
					$clist		=	$atnM ->getatnList(1,array('field'=>'`id`'));
					if($clist && is_array($clist)){
						foreach($clist as $val){
							if(in_array($val['id'],$auid)==false){
								$lxjh[]		=	$val['id'];
							}
						}
					}
					if($_GET['order']=="desc"){
						
						$xid	=	pylode(',',$auid).','.pylode(',',$lxjh);
						
					}elseif($_GET['order']=="asc"){
						
						$xid	=	pylode(',',$lxjh).','.pylode(',',$auid);
					}
					$where['id']			=	array('in',$xid);
				}else{
					$where['orderby']		=	$_GET['t'].','.$_GET['order'];
				}
				$urlarr['order']	=	$_GET['order'];
				$urlarr['t']		=	$_GET['t'];
			}else{
				$where['orderby']		=	array('r_status,asc','ctime,desc');
			}
		}
		$where['limit'] 	=   $pages['limit'];
		$List  				=   $schoolM -> getSchoolXjhList($where);
		
		$this -> yunset(array('rows'=>$List));

		$this->yuntpl(array('admin/admin_school_xjh'));
	}
  
  
	function listxjh_action(){
    
		$atnM	=	$this -> MODEL('atn');
		
		if($_GET['id']){
			
			$where['xjhid']         =   intval($_GET['id']);
			$where['sc_usertype']   =   2;
			
		}
		$urlarr        	=   $_GET;
		$urlarr['page']	= 	'{{page}}';
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('atn',$where,$pageurl,$_GET['page']);
		
		if($pages['total']  > 0){
		   //limit order 只有在列表查询时才需要
			if($_GET['order']){
			 
				$where['orderby']	=	$_GET['t'].','.$_GET['order'];
				$urlarr['order']	=	$_GET['order'];
				$urlarr['t']		=	$_GET['t'];
			 
			}else{
			  
			  $where['orderby']		=	array('id,desc');
			}
		}
		$where['limit']	= 	$pages['limit'];
		
		$atnlist		=	$atnM -> getatnList($where,array('utype'=>'xjh'));
		$this -> yunset('rows',$atnlist);
    
		$this->yuntpl(array('admin/admin_school_listxjh'));
	}


	function add_action(){
		$schoolM		=   $this->MODEL('school');
		$companyM		=	$this->MODEL('company');
     
		if($_GET['id']){
       
			$id			=	intval($_GET['id']);
			$return		=	$schoolM -> getSchoolXjhInfo($id, array('cache'=>'1'));
			$this -> yunset('row',$return['info']);

			$company	=		$companyM->getInfo($return['info']['uid'],array('field'=>'`uid`,r_status'));
			$this->yunset('company',$company);

			$this -> yunset($return['cache']);
       
			$school		=	$schoolM -> getSchoolAcademyList('',array('field'=>'`id`,`schoolname`'));
			$this -> yunset('school',$school['list']);
		}
		$this -> yuntpl(array('admin/admin_school_xjhadd'));
	}
	//详情及修改
	function save_action(){
    
		$schoolM	= 	$this ->  MODEL('school');
		
		if($_POST['r_status']==1){
			$status  		=  1;
		}else{
			$status  		=	0;	
		}

		$post		=	array(
			'provinceid' 	=>  $_POST['provinceid'],
			'cityid'    	=>  $_POST['cityid'],
			'schoolid'   	=>  $_POST['schoolid'],
			'address'  		=>  $_POST['address'],
			'status'  		=>  $status,
			'r_status'  	=>  $_POST['r_status'],
		);
		$data		=	array(
			'post'		=>	$post,
			'id'		=>	$_POST['id'],
			'datetime'	=>	$_POST['datetime'],
			'stime'     =>  $_POST['stime'],
			'etime'     =>  $_POST['etime'],
		);
		$return		=	$schoolM -> addSchoolXjh($data);
		
		if($return['errcode']==9){
			
			$this->ACT_layer_msg($return['msg'],$return['errcode'],'index.php?m=admin_school_xjh');
			
		}else{
			$this->ACT_layer_msg($return['msg'],$return['errcode']);
		}
	}
    //删除用户关注宣讲会
	function dellsit_action(){
      
		$atnM	=	$this -> Model('atn');
		$delID	=	is_array($_POST['del']) ? $_POST['del'] : $_GET['id'];
		$return	=	$atnM -> delAtnAll($delID,array('type'=>'admin'));
		$this->layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
     
	}
	function del_action(){
    
		$schoolM	=	$this -> Model('school');
		$delID		=	is_array($_POST['del']) ? $_POST['del'] : $_GET['id'];
		$return		=	$schoolM -> delSchoolxjh($delID,array('utype'=>'admin'));
		
		$this->layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
	}
	function lockinfo_action(){
		$schoolM	=   $this ->  MODEL('school');
		$id         =   intval($_GET['id']);
		$info		= 	$schoolM->getSchoolXjhInfo($id,array('field'=>'statusbody'));
    
		echo $info['info']['statusbody'];die;
    
	}
	function status_action(){
    
		$schoolM    		=   $this->MODEL('school');
    
		$data['statusbody']	=   trim($_POST['lock_info']);
    
		$data['lock_info']	=   trim($_POST['lock_info']);
		
		$data['status']     =   $_POST['status'];
   
		$pid				=   intval($_POST['pid']);
    
		$id                 =   $schoolM     ->  upSchoolxjh($pid,$data);
		
		$info               =   $schoolM     ->  getSchoolXjhInfo($pid,array('field'=>'uid'));		
    
		if(!empty($info)){
			/* 消息前缀 */		
			$tagName  			=	'校招宣讲会';
			/* 处理审核信息 */
			if ($_POST['status'] == 2){
				$pid            	=  	intval($_POST['pid']);
				$id                 =   $schoolM -> upSchoolxjh($pid,$data);
				$list               =   $schoolM -> getSchoolXjhInfo($id,array('field'=>'uid'));
				$info				=	$list['info'];

				$statusInfo  =  $tagName.':审核未通过';
				
				if($_POST['lock_info']){
					
					$statusInfo  .=  ' , 原因：'.$_POST['lock_info'];
					
				}
				
				$msg  =  $statusInfo;
				
			}elseif($_POST['status'] == 1){
				
				$msg  =  $tagName.':已审核通过';
				
			}
			//发送系统通知
			$sysmsgM	=	$this->MODEL('sysmsg');
			
			$sysmsgM -> addInfo(array('uid'=>$info['uid'],'usertype'=>4, 'content'=>$msg));
			
		}
 		$id?$this->ACT_layer_msg("校招宣讲会审核(ID:".$id.")设置成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg( "设置失败！",8,$_SERVER['HTTP_REFERER']);
	}

	function xjhNum_action(){
    
		$MsgNum = $this->MODEL('msgNum');
		echo $MsgNum->xjhNum();
	}
}
?>