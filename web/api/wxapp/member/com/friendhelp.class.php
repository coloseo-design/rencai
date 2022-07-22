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
class friendhelp_controller extends com_controller{
	
	function index_action()
	{
	    if($this -> config['sy_help_open'] !='1'){
	        $this->render_json(1,'好友助力功能已关闭');
	    }
	    $helpM			=   $this -> MODEL('friendhelp');
	    
	    $uid			=	$this -> member['uid'];
	    $where['comid']	=	$uid;
	    $where['etime']	=	array('<',time());
	    $page           =	$_POST['page'];
	    if ($_POST['limit']){
	        $limit		        =   $_POST['limit'];
	        if($page){
	            $pagenav	    =   ($page-1)*$limit;
	            $where['limit'] =   array($pagenav,$limit);
	        }else{
	            $where['limit'] =   $limit;
	        }
	    }
	    $where['orderby']	    =	array('etime,desc');
	    $rows				    =	$helpM -> getList($where);

	    $return['total']        =   $helpM->getNum(array('comid' => $uid, 'etime' => array('<', time())));

	    //获取当前执行中的任务
	    $helpinfo	            =	$helpM -> getInfo(array('comid'=>$uid,'etime'=>array('>=',time())));
	    
	    if(!empty($helpinfo)){
	        
	        $loglist	        =	$helpM -> getLogList(array('pid' => $helpinfo['id'],'orderby'=>'id,desc','limit'=>'5'));
	        
	        $return['helping']  =   true;
	        $return['loglist']  =   !empty($loglist) ? $loglist : array();
	        $return['helpinfo'] =   $helpinfo;
	    }else{
	        $return['helping']  =   false;
	    }
	    $return['list']	        =   count($rows['list']) > 0 ? $rows['list'] : array();
	    $this->render_json(0,'ok',$return);
	}
	//发布好友助力任务
	function addfriendhelp_action(){
	    
	    if($this -> config['sy_help_open'] !='1'){
	        
	        $this->render_json(1,'好友助力功能已关闭');
	    }
	    
	    $helpM	=	$this->MODEL('friendhelp');
	    
	    $return	=	$helpM->addHelp($this->member['uid']);
	    
	    if($return['error'] == '0'){
	        
	        $this->render_json(1,$return['msg']);
	        
	    }else{
	        
	        $this->render_json(0,'ok',$return);
	    }
	}
	//查看助力好友
	function getlog_action(){
	    
	    if($_POST['id']){
	        $helpM		=	$this -> MODEL('friendhelp');
	        $logList	=	$helpM -> getLogList(array('pid' => intval($_POST['id']),'comid'=>$this->member['uid'],'orderby'=>'id'),array('field'=>'`wxpic`'));
	        
	        $data['loglist']  =  !empty($logList) ? $logList : array();
	        
	        $this->render_json(0,'ok',$data);
	    }
	}
	// 领取权益
	function getpackage_action(){
	    
	    if($this -> config['sy_help_open'] !='1'){
	        $this->render_json(1,'好友助力功能已关闭');
	    }
	    
	    if($_POST['id']){
	        $helpM	=	$this -> MODEL('friendhelp');
	        
	        $return	=	$helpM -> givePackage($_POST['id'],$this->member['uid']);
	        
	        $error  =  $return['error'] == '1' ? 0 : 1;
	        
	        $this->render_json($error,$return['msg']);
	    }
	}
}
?>