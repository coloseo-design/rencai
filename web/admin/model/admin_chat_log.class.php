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
class admin_chat_log_controller extends adminCommon{  
	function index_action(){
		$chatM = $this->MODEL('chat');
		$where = array();
		$noUsername = true;
		if($_GET['keyword']){
			
			$keyword	=	trim($_GET['keyword']);
			
			$type		=	intval($_GET['type']);
			
			if ($type==1 || $type==2){
				
			    $userInfoM  =  $this->MODEL('userinfo');
			    $member  =  $userInfoM->getList(array('username'=>array('like',$keyword)),array('field'=>'`uid`'));
			    if (!empty($member)){
			        
			        $muids  =  array();
			        foreach ($member as $v){
			            
			            $muids[] = $v['uid'];
			        }
			        if ($type == 1){
			            
			            $where['from']  =  array('in',pylode(',', $muids));
			            
			        }elseif ($type == 2){
			            
			            $where['to']  =  array('in',pylode(',', $muids));
			        }
			    }else{
			        $noUsername = false;
			    }
			}elseif($type=='3'){
				
				$where['content']	=	array('like',$keyword);
			}
			$urlarr['type']			=	"".$type."";
			
			$urlarr['keyword']		=	"".$keyword."";
		}
		if(($_GET['date'])){
			
			$times=@explode('~',$_GET['date']);
			
			$where['PHPYUNBTWSTART']=   '';
			$where['sendTime'][]	=	array('>=',strtotime($times[0]." 00:00:00")*1000);
			$where['sendTime'][]	=	array('<',strtotime($times[1]." 23:59:59")*1000);
			$where['PHPYUNBTWEND']  =   '';
			
			$urlarr['date']		=	$_GET['date'];
		}
		// 用户名没搜到的，不查询
		if ($noUsername){
			$urlarr        	=   $_GET;
		    $urlarr['page']	=	"{{page}}";
		    
		    $pageurl		=	Url($_GET['m'],$urlarr,'admin');
		    
		    $pageM			=	$this  -> MODEL('page');
		    
		    $pages			=	$pageM -> pageList('chat_log',$where,$pageurl,$_GET['page']);
		    
		    //分页数大于0的情况下 执行列表查询
		    if($pages['total'] > 0){
		        
		        if($_GET['order'])
		        {
		            $where['orderby']	=	$_GET['t'].','.$_GET['order'];
		            
		            $urlarr['order']	=	$_GET['order'];
		            
		            $urlarr['t']		=	$_GET['t'];
		        }else{
		            
		            $where['orderby']	=	'id';
		        }
		        
		        $where['limit']	=	$pages['limit'];
		        
		        $chatList		=	$chatM -> getChatLogList($where,array('admin'=>1));
		        
		        if ($chatList && is_array($chatList)){
		            
		            foreach ($chatList as $k=>$v){
		                
		                $chatList[$k]['sendTime'] = ceil($v['sendTime']/1000);
		                
		            }
		        }
		    }
		    
		    $this->yunset('rows',$chatList);
		}
		
		$this->yuntpl(array('admin/admin_chat_log'));
	}
	function del_action(){
		
		$chatM	=	$this -> Model('chat');
		
		if(is_array($_POST['del'])){
			
			$delid		=	@implode(',',$_POST['del']);
			
			$layer_type	=	1;
		}else{
			$this -> check_token();
			
			$delid		=	(int)$_GET['id'];
			
			$layer_type	=	0;
		}
		
		$where['id']	=	array('in',$delid);
		
		$del	=	$chatM -> delChatLog(array('where'=>$where));
		
		$del?$this -> layer_msg('聊天记录(ID:'.$delid.')删除成功！',9,$layer_type,$_SERVER['HTTP_REFERER']):$this -> layer_msg('删除失败！',8,$layer_type,$_SERVER['HTTP_REFERER']);
		
	}
	function clean_action(){
		$month	=	intval($_POST['month']);
		
		$chatM	=	$this -> MODEL('chat');
		
		$where['sendTime']	=	array('<',strtotime("-".$month." month")*1000);
		
		$del	=	$chatM -> delChatLog(array('where'=>$where));
		
		$del?$this -> layer_msg('聊天记录清理成功！',9):$this -> layer_msg('清理失败！',8);
	}
	/**
	 * 按聊天记录id，查询双方聊天记录
	 */
	function userchat_action(){
	    
	    $chatM	=	$this -> MODEL('chat');
	    $log = $chatM->getChatLog(array('id'=>(intval($_POST['id']))));
	    
	    $arr    =  array(
	        'toid'       =>  $log['to'],
	        'tusertype'  =>  $log['tusertype'],
	        'fromid'     =>  $log['from'],
	        'fusertype'  =>  $log['fusertype'],
	        'page'       =>  $_POST['page'],
	        'lastid'     =>  ''
	    );
	    $return  =  $chatM -> getChatPage($arr);

	    $pArr   =  array(
            'uid'       =>  intval($log['from']),
            'usertype'  =>  intval($log['fusertype']),
            'toid'      =>  intval($log['to']),
            'totype'    =>  intval($log['tusertype'])
        );

	    $list   =  $chatM -> getPrepare($pArr);

	    $return['joblist'] =  !empty($list['joblist'])?$list['joblist']:array(); 
	    $return['expect'] =  !empty($list['expect'])?$list['expect']:array(); 


    	$canwx  =   $chatM->getFriendCan(array('type'=>'wx','uid'=>$this->uid,'usertype'=>$this->usertype,'fid'=>$uid,'fusertype'=>$_GET['type']));
        $cantel =   $chatM->getFriendCan(array('type'=>'tel','uid'=>$this->uid,'usertype'=>$this->usertype,'fid'=>$uid,'fusertype'=>$_GET['type']));

        $return['cantel'] =  $cantel; 
        $return['canwx'] =  $canwx;   
        
	    echo  json_encode($return);die;
	}
}

?>