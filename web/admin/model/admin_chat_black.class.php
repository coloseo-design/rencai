<?php
/*
* $Author ：PHPYUN开发团队
*
* 官网: http://www.phpyun.com
*
* 版权所有 2009-2018 宿迁鑫潮信息技术有限公司，并保留所有权利。
*
* 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
 */
class admin_chat_black_controller extends adminCommon{

	function index_action(){
	    
	    $where['state']  =  '2';
	    
		if($_GET['end']){
		    if($_GET['end']=='1'){
		        $where['ctime']  =  array('>=',strtotime('today'));
		    }else{
		        $where['ctime']  =  array('>=',strtotime('-'.(int)$_GET['end'].'day'));
		    }
		    $urlarr['end']  =  $_GET['end'];
		}
		
		if ($_GET['keyword']){
		    
		    $keyword  =  trim($_GET['keyword']);
		    
		    if ($_GET['f_type'] == 1 || $_GET['f_type'] == 2){
		        
		        $userInfoM  =  $this->MODEL('userinfo');
		        $member  =  $userInfoM->getList(array('username'=>array('like',$keyword)),array('field'=>'`uid`'));
		        if (!empty($member)){
		            
		            $muids  =  array();
		            foreach ($member as $v){
		                
		                $muids[] = $v['uid'];
		            }
		            if ($_GET['f_type'] == 1){
		                
		                $where['uid']  =  array('in',pylode(',', $muids));
		                
		            }elseif ($_GET['f_type'] == 2){
		                
		                $where['fid']  =  array('in',pylode(',', $muids));
		            }
		        }
		        
		    }elseif ($_GET['f_type'] == 3){
		        
		        $where['uid']  =  $keyword;
		        
		    }elseif ($_GET['f_type'] == 4){
		        
		        $where['fid']  =  $keyword;
		    }
		    $urlarr['f_type']   =  $_GET['f_type'];   
		    $urlarr['keyword']  =  $_GET['keyword'];
		}
		$urlarr['page']  =  '{{page}}';
		
		$pageurl  =  Url('admin_chat_black',$urlarr,'admin');
		//提取分页
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('chat_friend', $where, $pageurl, $_GET['page']);
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
		    
		    $chatM  =  $this->MODEL('chat');
		    $rows   =  $chatM->getFriendList($where,array('utype'=>'admin'));
		}
		
		$this->yunset('rows',$rows);
		$this->yuntpl(array('admin/admin_chat_black'));
	}
	function del_action(){
	    
		$this->check_token(); 
		
	    if($_GET['del']){
	    	$del=$_GET['del'];
	    	if($del){
	    		if(is_array($del)){
					$layer_type  =  1;
					$del  =  pylode(',',$del);
		    	}else{
					$layer_type  =  0;
		    	}
		    	$chatM  =  $this->MODEL('chat');
		    	$chatM->upFriend(array('id'=>array('in',$del)),array('state'=>1));
		    	
				$this->layer_msg('屏蔽(ID:'.$del.')解除成功！',9,$layer_type,$_SERVER['HTTP_REFERER']);
	    	}else{
				$this->layer_msg('请选择您要解除的信息！',8,0,$_SERVER['HTTP_REFERER']);
	    	}
	    }
	}
}

?>