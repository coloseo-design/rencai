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
class sysnews_controller extends adminCommon{
	function set_search(){
		$ad_time=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		
		$search_list[]=array("param"=>"end","name"=>'发布时间',"value"=>$ad_time);
		
		$this->yunset("search_list",$search_list);
	}
	function index_action()
	{
		$this->set_search();
		
		$sysmsgM=$this->MODEL('sysmsg');
		
		if(trim($_GET['keyword']))
		{
			if($_GET['type']=="1")
			{
				$where['username']	=	array('like',trim($_GET['keyword']));
			}else{
				
				$where['content']	=	array('like',trim($_GET['keyword']));
			}
			$urlarr['keyword']		=	$_GET['keyword'];
			
			$urlarr['type']			=	$_GET['type'];
		}
		if($_GET['end']){
			if($_GET['end']=='1'){
				
				$where['ctime']		=	array('>=',strtotime(date("Y-m-d 00:00:00")));
			}else{
				
				$where['ctime']		=	array('>=',strtotime('-'.$_GET['end'].'day'));
			}
			$urlarr['end']			=	$_GET['end'];
		}
		$urlarr        		=   $_GET;
		$urlarr['page']="{{page}}";
		
		$pageurl=Url($_GET['m'],$urlarr,'admin');
		
		$pageM			=	$this  -> MODEL('page');
		
		$pages			=	$pageM -> pageList('sysmsg',$where,$pageurl,$_GET['page']);
		
		//分页数大于0的情况下 执行列表查询
		
		if($pages['total'] > 0){
			
			if($_GET['order'])
			{
				$where['orderby']	=	$_GET['t'].','.$_GET['order'];
				
				$urlarr['order']	=	$_GET['order'];
				
				$urlarr['t']		=	$_GET['t'];
			}else{
				
				$where['orderby']	=	'id,desc';
			}
			
			$where['limit']	=	$pages['limit'];
		
			$List		=	$sysmsgM -> getList($where);
			
		}
		
        $this->yunset('rows',$List);
		
		$this->yuntpl(array('admin/sysnews'));
	}
    function add_action(){
		$this->yuntpl(array('admin/sysnews_add'));
	}
	//发送系统消息
	function sendSys_action(){
	    
	    if($_POST['content']=="")
	    {
	        $return = array('msg'=>'请填写发送内容', 'status'=>2);
	        echo json_encode($return);die;
	    }
	    $userinfoM = $this -> MODEL('userinfo');
	    if($_POST['all']=="5")
	    {
	        $userarr=@explode(",",$_POST['userarr']);
	        
	        $where['PHPYUNBTWSTART']	=	'OR';
	        
	        foreach($userarr as $v)
	        {
	            $where['username'][]    =   array('=', $v, 'OR');
	        }
	        $where['PHPYUNBTWEND']		=	'';
	    }else{
	        
	        $where = array('usertype'=>$_POST['all']);
	        
	        $count = $userinfoM->getMemberNum($where);
	        // 每次发送1000条;
	        $size = 1000;
	        //循环次数
	        $num = ceil($count/$size);
	        $page = $_POST['page'];
	        
	        $where['limit'] = array(($page - 1) * $size, $size);
	    }
	    
	    $member	=	$userinfoM -> getList($where,array('field'=>"`uid`,`username`"));
	    if(!empty($member))
	    {
	        $data['content']			=	$_POST['content'];
	        
	        foreach($member as $v)
	        {
	            $uid[]					=	$v['uid'];
	        }
	        $data['uid']				=	$uid;
	        
	        $this -> MODEL('sysmsg') -> addInfo($data);
	        
	        if (isset($num)){
	            // 按用户类型分批发送的
	            if ($num > $page){
	                $return = array(
	                    'msg'=>'共'.$count.'条，已发送'.$page * $size.'条',
	                    'status'=> 3,
	                    'page'=>$page + 1
	                );
	                echo json_encode($return);die;
	            }
	        }
	        $return = array(
	            'msg'=>'发送完成',
	            'status'=> 1
	        );
	    }else{
	        $return = array(
	            'msg'=>'用户不存在',
	            'status'=> 2
	        );
	    }
	    echo json_encode($return);die;
	}
	function del_action()
	{
		$this->check_token();

	    $del=$_GET['del'];
			
	    if($del){
			
	    	$return	=	$this -> MODEL('sysmsg') -> delInfo($_GET['del'],'');
				
	    	$this->layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
	    }else{
	    		$this->layer_msg("请选择您要删除的信息！",8,1,$_SERVER['HTTP_REFERER']);
	    }
	}
}