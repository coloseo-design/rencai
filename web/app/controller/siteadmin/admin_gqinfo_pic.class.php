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
class admin_gqinfo_pic_controller extends siteadmin_controller{

	function set_search(){
	   
		$search_list[]  = array("param"=> "status","name"=> '审核状态',"value" => array('1'=>'待审核','0' => '已审核','2' => '未通过'));
		
		$this->yunset("search_list", $search_list);

    }
    /**
     * 会员-供求-图片管理：个人头像（列表）
     */
	function index_action(){

		$this							->		set_search();
		
		$gqdemandM    			    	=  		$this -> MODEL('gqdemand');

	    $where['photo']  				=  		array('<>','');
	    
	    if($_GET['keyword']){
	        
	        $keytype  					=   	intval($_GET['type']);
	        
	        $keyword  					=   	trim($_GET['keyword']);
	        
	        if ($keytype == 1){
	            
	            $where['name']      	=  		array('like',$keyword);
	            
	        }elseif ($keytype == 2){
	            
	            $where['uid']       	=  		array('like',$keyword);
			}
			
	        $urlarr['keytype']	   		=  		$keytype;
	        
			$urlarr['keyword']	    	=  		$keyword;
			
	    }
	    if(isset($_GET['status'])){
	        
	        $status                 	=   	intval($_GET['status']);
	        
	        $where['photo_status']  	=  		$status;
	        
	        $urlarr['status']       	=  		$status;
		}
		
	    $urlarr['page']					=		'{{page}}';
	    
	    $pageurl						=		 Url($_GET['m'],$urlarr,'admin');
	    
	    //提取分页
		$pageM							=		$this  -> MODEL('page');
		
	    $pages							=		$pageM -> pageList('gq_info',$where,$pageurl,$_GET['page']);
	    //分页数大于0的情况下 执行列表查询
	    if($pages['total'] > 0){
	        //limit order 只有在列表查询时才需要
			$where['orderby']			=		array('photo_status,desc','uid,desc');
			
	        $where['limit']				=		$pages['limit'];
	    
	        $List						=		$gqdemandM->getGqinfoList($where,array('field'=>'`photo`,`uid`,`photo_status`,`name`'));
			
			$this -> yunset('rows',$List);
			
	    }
		$this->siteadmin_tpl(array('admin_gqinfo_pic'));


	}
	/**
	 * 会员-供求-图片管理：用户头像（获取审核说明）
	 */
	function getStatusBody_action(){
	    
		$gqdemandM    		 	=  		$this -> MODEL('gqdemand');
		

		$where['uid']		 	=		intval($_GET['uid']);

	    
	    $return  		 		= 		$gqdemandM -> getInfo($where,array('field'=>'`photo_statusbody`','type'=>1));
	    
	    echo trim($return['photo_statusbody']);die;
	}
	/**
	 * 会员-个人-图片管理：个人头像（审核）
	 */
	function status_action(){
	    
		$gqdemandM    			    	=  		$this -> MODEL('gqdemand');
		
		$uid							=		@explode(',', $_POST['uid']);
		

		if($_POST['status']  ==""){

            $this->ACT_layer_msg("请选择审核状态",8);return false;

        }

		if($uid){

			if(is_array($uid)){

				$where['uid']                =              array('in', pylode(',', $uid));

			}else{

				$where['uid']                =              intval($uid);

			}
			
			if($_POST['status']  ==2){
				
				//头像不通过审核

				$data							 =				array(

					'photo'    			 		=>  			'',

					'photo_status'    			 =>  			intval($_POST['status']),
	
					'photo_statusbody' 		     =>  			$_POST['statusbody']
	
				);

			}else{
				//头像通过审核

				$data							 =				array(

					'photo_status'    			 =>  			intval($_POST['status']),
	
					'photo_statusbody' 		     =>  			$_POST['statusbody']
	
	
				);

			}
			
			$return  =  $gqdemandM -> upGqInfoStatus($where,$data);

			if($_POST['status']		==		2){

				foreach($uid  as $k=>$v){

						//发送短信通知功能
					$statusInfo			=		'您的头像';

					if($_POST['statusbody']){

						$statusInfo  .=		' , 因为'.$_POST['photo_statusbody'].' , ';

					}

					$statusInfo  .=  '已被系统删除';

					$msg[$v]  =  $statusInfo;

				}

				include_once('sysmsg.model.php');
	                
				$sysmsgM  =  new sysmsg_model($this->db, $this->def);
				
				$sysmsgM -> addInfo(array('uid'=>$uid,'usertype'=>5, 'content'=>$msg));
			
			}
	    
			$this -> ACT_layer_msg($return['msg'],$return['errcode'],$_SERVER['HTTP_REFERER'],2,1);

		}else{

			$this->ACT_layer_msg('非法操作！',8,$_SERVER['HTTP_REFERER']);

		}

	}

	
	/**
	 * 会员-个人-图片管理：个人头像（修改）
	 */
	function savePhoto_action(){

		$gqdemandM    			    	=  		$this -> MODEL('gqdemand');
	    
	    $file     						=  		$_FILES['file'];
	    
		$where['uid']					=		intval($_POST['id']);

		$data							=		array(

			'file'						=>		$file,

			'photo_status'				=>		0,

			'photo_statusbody'			=>		'',


		);
	    
	    $return   =  $gqdemandM -> upaddGqinfo($where,$data,2);
	    
	    $this -> ACT_layer_msg($return['msg'],$return['errcode'],$_SERVER['HTTP_REFERER'],2,1);
	}

	
	/**
	 * 会员-个人-图片管理：个人头像（删除）
	 */
	function delPhoto_action(){

		$gqdemandM    			    	=  		$this -> MODEL('gqdemand');
	    
	    if ($_GET['del']){
	        
	        $this -> check_token();
	        
			$uid          				=  		intval($_GET['del']);
			
			$layertype					=		0;
	        
	    }elseif ($_POST['del']){
	        
			$uid          				=  		$_POST['del'];

			$layertype					=		1;
	        
			
	    }
		
		$where['uid']                	=              array('in', pylode(',', $uid));

		$data							=				array(

			'photo'    			 		=>  			'',

			'photo_status'    			=>  			1,

			'photo_statusbody'    		=>  			''


		);
		
	    $return   =  $gqdemandM -> upaddGqinfo($where,$data,1);
	    
	    $this->layer_msg($return['msg'],$return['errcode'],$layertype,$_SERVER['HTTP_REFERER']);
	}

}
?>