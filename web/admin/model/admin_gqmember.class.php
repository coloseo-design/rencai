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
class admin_gqmember_controller extends adminCommon{
    /**
     * 个人用户列表高级搜索功能
     */
	private function set_search(){
			
		$search_list[]  		=  		array('param'=>'status','name'=>'审核状态','value'=>array('1'=>'已审核','2'=>'已锁定','3'=>'未通过','4'=>'未审核'));
		
		$this->yunset('search_list',$search_list);

	}
	/**
	 * 会员
	 */
	function index_action(){
	    
		$this -> set_search();
		
		$userinfoM  			      			=  			$this -> MODEL('userinfo');

		$gqdemandM    			  	  			=  			$this -> MODEL('gqdemand');
		
		$where['state']							=			1;

		if($_GET['keyword']){
		    
		    $keytype  							=   		intval($_GET['type']);
		    
		    $keyword  							=   		trim($_GET['keyword']);
		    
		   if ($keytype == 2){

				$where['moblie']      			=  			array('like',$keyword);

		    }elseif ($keytype == 3){
		        
				$where['uid']         			=  			array('=',$keyword);
				
		    }else{

				$where['name']					=			array('like',$keyword);	
			}

		    $urlarr['keytype']	      			=  			$keytype;
		    
		    $urlarr['keyword']	     		 	=  			$keyword;
		}

		if($_GET['status']){
		    
		    $status                   			=   		intval($_GET['status']);
		    
		    $where['status']          			=  			$status == 4 ? 0 : $status;
		    
			$urlarr['status']         			=  			$status;
			
		}
		if($_GET['adtime']){
		    
		    if($_GET['adtime']=='1'){
		        
		        $where['reg_date']	  			=  			array('>',strtotime('today'));
		        
		    }else{
		        
		        $where['reg_date']	  			=  			array('>',strtotime('-'.intval($_GET['adtime']).' day'));
		    }
		    
		    $urlarr['adtime']         			=  			$_GET['adtime'];
		}
		$urlarr        							=   		$_GET;
		$urlarr['page']			  	  			=			'{{page}}';
		
		$pageurl				      			=			Url($_GET['m'],$urlarr,'admin');
		
		//提取分页
		$pageM					      			=			$this  -> MODEL('page');

		$pages					      			=			$pageM -> pageList('gq_info',$where,$pageurl,$_GET['page']);
		//分页数大于0的情况下 执行列表查询
		if($pages['total'] > 0){
		    //limit order 只有在列表查询时才需要
		    if($_GET['order']){
		        
		        if($_GET['t']=='time'){
		            
		            $where['orderby']			=		 'lastupdate,'.$_GET['order'];
		            
		        }else{
		            
		            $where['orderby']			=		  $_GET['t'].','.$_GET['order'];
		        }
		        
				$urlarr['order']				=		  $_GET['order'];
				
				$urlarr['t']					=		  $_GET['t'];
				
		    }else{

				$where['orderby']				=		  array('uid,desc');
				
			}
			
		    $where['limit']						=		 $pages['limit'];

			$row								=		 $gqdemandM->getGqinfoList($where,array('field'=>'`uid`,`status`,`r_status`,`name`,`moblie`,`sex`,`salary`,`provinceid`,`cityid`,`three_cityid`'));

			$this -> yunset('rows',$row);
			
		}
    
    	$cacheM					         =	$this -> MODEL('cache');
    
	  	$domain					         =	$cacheM	-> GetCache('domain');
	    
	  	$this -> yunset('Dname', $domain['Dname']);

		$this->yuntpl(array('admin/admin_member_gqlist'));

	}
 	
	//浏览相关页面

	public  function details_action(){

		$gqdemandM        			=  			$this -> MODEL('gqdemand');

		$userinfoM        			=  			$this -> MODEL('userinfo');
		
		$cacheM           			=     		$this->MODEL('cache');
		
		$options          			=     		array('city','user');
			
		$cache            			=    		$cacheM -> GetCache($options);
		
		$this       ->  yunset('cache',  $cache);
		
		$user_sex         			=     		$cache['user_sex'];
		
    	$this       ->  yunset('user_sex',  $user_sex);

		$uid       					=			intval($_GET['uid']);

		$where['uid']				=			$uid;

		$row						=			$gqdemandM->getGqInfo($where);
      
		$member						=			$userinfoM->getInfo(array('uid'=> $uid));
 
		$this->yunset('member',$member); 

		$this->yunset('row',$row); 
      
		$this->yuntpl(array('admin/admin_gqmember_details'));

	}
	/***
	 * 添加和修浏览页面
	 * 
	 */
	public  function edit_action(){

		$gqdemandM        			=  			$this -> MODEL('gqdemand');

		$userinfoM        			=  			$this -> MODEL('userinfo');
		
		$cacheM           			=     		$this->MODEL('cache');
		
		$options          			=     		array('city','user');
			
		$cache            			=    		$cacheM -> GetCache($options);
		
		$this       ->  yunset('cache',  $cache);
		
		$user_sex         			=     		$cache['user_sex'];
		
    	$this       ->  yunset('user_sex',  $user_sex);

		if($_GET['uid']){
			
			$uid       				=			intval($_GET['uid']);

			$where['uid']			=			$uid;

			$row					=			$gqdemandM->getGqInfo($where);
      
			$this->yunset('row',$row); 
      
      		$this ->yunset('lasturl',   $_SERVER['HTTP_REFERER']);

		}
		
		$this->yuntpl(array('admin/admin_gqmember_edit'));

	}

	/**
	 * 保存信息除了功能 
	 * 
	*/
	public function savegqInfo_action(){

		$userinfoM  		  		=  			$this -> MODEL('userinfo');

		$gqdemandM      			=  			$this -> MODEL('gqdemand');

		$_POST  			    	=  			$this->post_trim($_POST);

		$lasturl			    	=		  	$_POST['lasturl'];

		if($_POST['submit']){
	
			$uid    				=  			intval($_POST['uid']);

			$gData  				=  			array(

				'name'         	  	=>  		$_POST['name'],
				
				'mobile'          	=>  		$_POST['mobile'],
				
				'sex'     		  	=>  		$_POST['sex'],
				
				'provinceid'      	=>  		$_POST['provinceid'],
				
				'cityid'          	=>  		$_POST['cityid'],
				
				'three_cityid'    	=>  		$_POST['three_cityid'],
				
				'services'        	=>  		str_replace(array('&amp;','background-color:#ffffff','background-color:#fff','white-space:nowrap;'),array('&','background-color:','background-color:','white-space:'),$_POST['services']),
				
				'salary'     	  	=>    		$_POST['salary'],
				
				'content'        	=>   		str_replace(array('&amp;','background-color:#ffffff','background-color:#fff','white-space:nowrap;'),array('&','background-color:','background-color:','white-space:'),$_POST['content']),
				
				'lastupdate'      	=>  		time(),
			
				'speciality'		=>			$_POST['speciality'],

				'file'				=>			$_FILES['file'],

			);
			
			$where['uid']			=			$uid;
						
			$return 				=			$gqdemandM->upaddGqinfo($where,$gData);

			$this -> ACT_layer_msg($return['msg'],$return['errcode'],$lasturl);

		}

	}
	/**
	 * @desc  删除供求会员信息
	 */
	public function delqgInfo_action(){

		$gqdemandM	=	$this -> MODEL('gqdemand');

		if ($_GET['del']){
	        
	        $this -> check_token();
	        
	        $uid	=	intval($_GET['del']);
	        
	    }elseif ($_POST['del']){
	        
        	$uid	=	$_POST['del'];
			
	    }
	    
	    $return		=	$gqdemandM -> delInfo($uid);
	    
	    $this -> layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);

	}
	/**
	 * 审核功能
	 * 
	 */
	public function statis_action(){

		$gqdemandM  				=  			$this -> MODEL('gqdemand');
    
    	if($_POST['status']  ==""){
        
      		$this->ACT_layer_msg("请选择审核状态",8);return false;
          
     	}
    
		$post						=			array(

			'status'     			=>  		intval($_POST['status']),

	     	'lock_info'  			=>  		trim($_POST['statusbody'])

		);	

		$return     				=  			$gqdemandM -> upGqtatus(intval($_POST['uid']),$post);

		$this->ACT_layer_msg($return['msg'],$return['errcode'],$_SERVER['HTTP_REFERER'],2,1);

	}


	
	/**
	 * 会员-供求-供求用户列表: 全部供求（页面统计数量）
	 */
	function gqNum_action(){

		$MsgNum						=			$this->MODEL('msgNum');

		echo $MsgNum->gqNum();
	}

		/**
	 * 会员-供求-供求用户列表:全部供求（获取锁定、审核未通过原因）
	 */
	function lockinfo_action(){
	    
		$gqdemandM    				=  			$this -> MODEL('gqdemand');
		
		$where['uid']				=			$_GET['uid'];
	    
	    $gqmember     				=  			$gqdemandM -> getGqInfo($_GET['uid'],array('field'=>'statusbody'));
	    
	    echo trim($gqmember['statusbody']);die;
	}
  
  	/**
	 * 会员-供求-供求用户列表: 全部供求（重置密码）
	 */
	function reset_pw_action(){
	    
	    $this -> check_token();
	    
	    $userinfoM  				=  			$this->MODEL('userinfo');
	    
	    $userinfoM -> upInfo(array('uid'=>intval($_GET['uid'])),array('password'=>'123456'));
	    
		echo '1';
		
	}

	/**
	 * @desc 日志高级搜索
	 */
	function log_search(){
	    
		$parr           			=  			array('1'=>'增加','3'=>'删除','4'=>'刷新');
	   
		$ad_time        			=   		array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
        
		$search_list[]  			=   		array('param'=>'parrs','name'=>'操作内容','value'=>$parr);
	   
		$search_list[]  			=   		array('param'=>'end','name'=>'操作时间','value'=>$ad_time);
        
		$this->yunset('search_list',$search_list);
	}

		/**
	 * @desc 供求会员日志
	 */
	function member_log_action(){
	    
		$this->log_search();
		
        $where['usertype']  		=   		'5';
		
 		if(intval($_GET['uid']) > 0){
 		    
            $where['uid']   		=   		intval($_GET['uid']);
 		    
            $UserinfoM      		=   		$this -> MODEL('userinfo');
            
            $uinfo          		=   		$UserinfoM -> getInfo(array('uid'=> $where['uid']) , array('field' => 'username'));
 		    
            $this -> yunset('uinfo',$uinfo);
			
            $urlarr['uid']  		=   		intval($_GET['uid']);
			
		}

		if($_GET['keyword']){
		    
            $type           		=   		intval($_GET['type']);
		    
            $keyword        		=   		trim($_GET['keyword']);
		    
            if($type == 1){
                
                $where['uid']   	=   		array('=', $keyword);
                
			}else if($type == 2){

				$gqdemandM    		=  			$this -> MODEL('gqdemand');
	            
	            $infogq     		=   		$gqdemandM -> getGqinfoList(array('name'=>array('like',$keyword)),array('field'=>'uid'));
	            
	            foreach($infogq as $val){
	                    
	                $muids[] 	=  			$val['uid'];
	            }
	                
	            $where['uid']  	=  			array('in',pylode(',', $muids));
	     
			}else if($type == 3){
			    
			    $where['content']   =   		array('like', $keyword);
				
			}
			
			$urlarr['type']      	=   		$type;

			$urlarr['keyword']   	=  	 		$keyword;
			
		}
		
		if($_GET['parrs']){
		    
            $where['type']          =   		intval($_GET['parrs']);
		    
            $urlarr['parrs']        =   		$_GET['parrs'];
		}
		
	    if($_GET['end']){
	        
	        if($_GET['end']=='1'){
	            
	            $where['ctime']   =   		array('>=', strtotime(date("Y-m-d 00:00:00")));
	        }else{
	            
	            $where['ctime']   	=  		 array('>=', '-'.strtotime((int)$_GET['end'].'day'));
	            
	        }
	        
            $urlarr['end']          	=   	$_GET['end'];
	    }
         
        $urlarr['c']    				=   	'member_log';
		$urlarr        					=   	$_GET;
        $urlarr['page'] 				=   	"{{page}}";
	    
        $pageurl        				=   	Url($_GET['m'], $urlarr, 'admin');
	    
        //提取分页
		$pageM          				=		$this  -> MODEL('page');
		
        $pages          				=		$pageM -> pageList('member_log', $where, $pageurl, $_GET['page']);
        
        //分页数大于0的情况下 执行列表查询
        if($pages['total'] > 0){
            
            //limit order 只有在列表查询时才需要
            if($_GET['order']){
                
				$where['orderby']		=	  $_GET['t'].','.$_GET['order'];
				
				$urlarr['order']		=	  $_GET['order'];
				
				$urlarr['t']			=	  $_GET['t'];
				
                
            }else{
                
                $where['orderby']		=	  array('uid,desc');
                
            }
            
            $where['limit']         	=	  $pages['limit'];
            
            $logM       				=    $this -> MODEL('log');
            
            $List       				=   $logM -> getMemlogList($where,array('utype'=>'admin'));
            
            $this -> yunset(array('rows' => $List));
        }
        
	    $this->yuntpl(array('admin/admin_gq_member_log'));
	}
    
	/**
	 * @desc 会员日志删除操作
	 */
	function memberlogdel_action(){
	    
	    if (is_array($_GET['del'])){
	        
	        $id        		=	   		pylode(',', $_GET['del']);
	        
	        $where     		=   		array('id' => array('in', $id));
	        
	    }else{
	        
	        $this      ->  check_token();
	        
	        $where     		=   		array('id' => intval($_GET['del']));
	    }
	    
	    $logM    			=  			$this -> MODEL('log');
	    
	    $return  			=  			$logM -> delMemlog($where);
	    
	    $this  ->  layer_msg($return['msg'], $return['errcode'], $return['layertype'],$_SERVER['HTTP_REFERER']);
	    
	}
	/**
	 * @desc  供求会员分站  分站设置
	 */
	function checksitedid_action(){
	    
	    $uid		 =	trim($_POST['uid']);
	    $did		 =	intval($_POST['did']);
	    
	    if(empty($uid)){
	        
	        $this -> ACT_layer_msg('参数不全请重试！', 8);
	    }
	    
	    $uids		 =	@explode(',',$_POST['uid']);
	    $uid 		 =	pylode(',',$uids);
	    
	    if(empty($uid)){
	        
	        $this -> ACT_layer_msg('请正确选择需分配用户！', 8);
	    }
	    
	    $siteM       =  $this->MODEL('site');
	    
	    $didData	 =    array('did' => $did);
	   
	    $Table = array(
            'member',
            'gq_info',
            'gq_browse',
            'gq_task',
            'company_order',
        );

	    $siteM -> updDid($Table,array('uid'=>array('in', $uid)),$didData);
	    
	    $this->ACT_layer_msg('会员(ID:'.$uid.')分配站点成功！', 9, $_SERVER['HTTP_REFERER'],2,1);
	    
	}

}

?>