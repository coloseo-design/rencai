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
class admin_trust_controller extends adminCommon{
	function set_search(){
		$search[]=array('param'=>'status','name'=>'审核状态','value'=>array('1'=>'已接受','3'=>'未审核','2'=>'未接受'));
		
		$lo_time=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		
		$search[]=array('param'=>'time','name'=>'发布时间','value'=>$lo_time);
		
		$this->yunset('search_list',$search);
	}
	/**
	 * 会员-个人-委托简历管理: 委托列表
	 */
	function index_action(){
	    
		$this -> set_search();
		
		if($_GET['keyword']){
		    
		    $keytype                  =   intval($_GET['type']);
		    
		    $keyword                  =   trim($_GET['keyword']);
		    
		    if ($keytype == 1){
		        
		        $resumeM              =   $this -> MODEL('resume');
		        $rwhere['name']       =   array('like', $keyword);
		        $rlist                =   $resumeM -> getResumeList($rwhere, array('field'=>'`uid`'));
		        if (is_array($rlist)) {
		            
		            foreach ($rlist as $v) {
		                
		                $muids[]      =   $v['uid'];
		            }
		        }
		        
		        $where['uid']         =   array('in', pylode(',', $muids));
		        
		    }elseif ($keytype == 2){
		        
		        $resumeM              =  $this -> MODEL('resume');
		        
		        $expect               =  $resumeM -> getExpect(array('name'=>array('like',$keyword)),array('field'=>'uid'));
		        
		        if ($expect){
		            
		            foreach($expect as $v){
		                
		                $uids[]       =  $v['uid'];
		            }
		            $where['uid']     =  array('in',pylode(',', $uids));
		        }
		    }
		    $urlarr['keytype']	      =  $keytype;
		    
		    $urlarr['keyword']	      =  $keyword;
		}
		if($_GET['status']){
		    
		    $status                   =   intval($_GET['status']);
		    
		    $where['status']          =  $status == 3 ? 0 : $status;
		    
		    $urlarr['status']         =  $status;
		}
		if($_GET['time']){
		    
		    if($_GET['time']=='1'){
		        
		        $where['add_time']	  =  array('>',strtotime('today'));
		        
		    }else{
		        
		        $where['add_time']	  =  array('>',strtotime('-'.intval($_GET['time']).' day'));
		    }
		    
		    $urlarr['time']           =  $_GET['time'];
		}
		$urlarr        	=   $_GET;
		$urlarr['page']	=	'{{page}}';
		
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');
		
		//提取分页
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('user_entrust',$where,$pageurl,$_GET['page']);
		
		//分页数大于0的情况下 执行列表查询
		if($pages['total'] > 0){
		    //limit order 只有在列表查询时才需要
		    if($_GET['order']){
		        
		        $where['orderby']  =  $_GET['t'].','.$_GET['order'];
		        $urlarr['order']   =  $_GET['order'];
		        $urlarr['t']	   =  $_GET['t'];
		    }else{
		        $where['orderby']  =  'uid';
		    }
		    $where['limit']		   =  $pages['limit'];
		    
		    $userEntrustM          =  $this -> MODEL('userEntrust');
		    
		    $List                  =  $userEntrustM -> getList($where,array('utype'=>'admin'));
		    
		    $this -> yunset('rows',$List);
		}
		$this->yuntpl(array('admin/admin_trust'));
	}
	/**
	 * 会员-个人-委托简历管理: 审核
	 */
	function status_action(){
	    
	    $userEntrustM  =  $this -> MODEL('userEntrust');
	    
	    $return  =  $userEntrustM -> statusEntrust(array('id'=>intval($_POST['pid'])),array('post'=>array('status'=>intval($_POST['status']))));
	    
	    $this->ACT_layer_msg($return['msg'],$return['errcode'],$_SERVER['HTTP_REFERER'],2,1);
	}
	/**
	 * 会员-个人-委托简历管理: 推荐列表
	 */
	function recom_action(){
	    $userEntrustM  =  $this -> MODEL('userEntrust');
	    $where['state']     =  1;
	    $where['status']    =  0;
	    $where['r_status']  = array('<>',2);
	    
	    if($_GET['keyword']){
	        
	        $keytype                  =   intval($_GET['type']);
	        
	        $keyword                  =   trim($_GET['keyword']);
	        
	        if ($keytype == 1){
	            
	            $where['com_name']    =  array('like',$keyword);
	            
	        }elseif ($keytype == 2){
	            
	            $where['name']        =  array('like',$keyword);
	        }
	        $urlarr['keytype']	      =  $keytype;
	        
	        $urlarr['keyword']	      =  $keyword;
	    }
	   
	    
	    $rwhere  =  $userEntrustM -> getRecordWhere(intval($_GET['eid']));
	    
	    $where   =  array_merge($where,$rwhere);
	    
	    $urlarr['c']    =   'recom';
	    $urlarr['eid']  =   $_GET['eid'];
		$urlarr['id']  	=   $_GET['id'];
		$urlarr        	=   $_GET;
	    $urlarr['page']	=	'{{page}}';
	    
	    $pageurl		=	Url($_GET['m'],$urlarr,'admin');
	    
	    //提取分页
	    $pageM			=	$this  -> MODEL('page');
	    $pages			=	$pageM -> pageList('company_job',$where,$pageurl,$_GET['page']);
	    
	    //分页数大于0的情况下 执行列表查询
	    if($pages['total'] > 0){
	        //limit order 只有在列表查询时才需要
	        if($_GET['order']){
	            
	            $where['orderby']  =  $_GET['t'].','.$_GET['order'];
	            $urlarr['order']   =  $_GET['order'];
	            $urlarr['t']	   =  $_GET['t'];
	        }else{
	            $where['orderby']  =  'lastupdate';
	        }
	        $where['limit']		   =  $pages['limit'];
	        
	        $jobM                  =  $this -> MODEL('job');
	        
	        $List                  =  $jobM -> getList($where);

	        $this -> yunset('rows',$List['list']);
	    }
	    
	    
		$this -> yunset($this -> MODEL('cache') -> GetCache(array('city','job')));
		
		$this -> yuntpl(array('admin/admin_trust_recom'));
	}
	/**
	 * 会员-个人-委托简历管理: 推荐简历
	 */
	function directrecom_action(){ 
	    
       $userEntrustM  =  $this -> MODEL('userEntrust');
      
	    $where  =  array(
	        'eid'  =>  intval($_GET['eid']),
	        'jobid'=>intval($_GET['jobid']),
	        'comid'=>intval($_GET['comid'])
	    );
	   
	    $return  =  $userEntrustM -> sendRecord($where);
	    
	    $this->layer_msg($return['msg'],$return['errcode']);
	}
	/**
	 * 会员-个人-委托简历管理: 删除委托
	 */
	function del_action(){
       
       $userEntrustM  =  $this -> MODEL('userEntrust'); 
      
	    if ($_GET['id']){
	        
	        $this -> check_token();
	        
	        $id  =  intval($_GET['id']);
	        
	    }elseif ($_POST['del']){
	        
	        $id  =  $_POST['del'];
	    }
	    
	    $return   =  $userEntrustM -> delInfo($id, array('utype'=>'admin'));
	    
	    $this -> layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
	}
	/**
	 * 会员-个人-委托简历管理: 委托列表数据查询
	 */
	function trustNum_action(){
		$MsgNum  =  $this -> MODEL('msgNum');
		
		echo $MsgNum -> trustNum();
	}
}

?>