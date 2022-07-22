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
class admin_gqmember_controller extends siteadmin_controller{
    /**
     * 个人用户列表高级搜索功能
     */
	private function set_search(){
		
		$search_list[]  		=  		array('param'=>'lotime','name'=>'最近登录','value'=>array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月'));
		
		$search_list[]  		=  		array('param'=>'adtime','name'=>'最近注册','value'=>array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月'));
		
		$search_list[]  		=  		array('param'=>'status','name'=>'审核状态','value'=>array('1'=>'已审核','2'=>'已锁定','3'=>'未通过','4'=>'未审核'));
		
		$this->yunset('search_list',$search_list);

	}
	/**
	 * 会员-个人-个人用户列表：全部个人
	 */
	function index_action(){
    
		$this -> set_search();
		
		$userinfoM  			      			=  			$this -> MODEL('userinfo');

		$gqdemandM    			  	  			=  			$this -> MODEL('gqdemand');
		
		$where['usertype']  		  			=  			5;

     
		
		if($_GET['keyword']){
		    
		    $keytype  							=   		intval($_GET['type']);
		    
		    $keyword  							=   		trim($_GET['keyword']);
		    
		   if ($keytype == 2){

				$where['moblie']      			=  			array('like',$keyword);

		    }elseif ($keytype == 3){
		        
				$where['uid']         			=  			array('like',$keyword);
				
		    }else{

				$gwhere['name']					=			array('like',$keyword);	

				$gqlist							=			$gqdemandM->getGqinfoList($gwhere,array('type'=>1,'field'=>'`uid`'));
				
				foreach($gqlist  as $val){

					$gquids[]					=			$val['uid'];

				}

				$where['uid']             		=     		array('in',pylode(',',$gquids));

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
		if($_GET['lotime']){
		    
		    if($_GET['lotime']=='1'){
		        
		        $where['login_date']  			= 			array('>',strtotime('today'));
		        
		    }else{
		        
		        $where['login_date']  			= 			array('>',strtotime('-'.intval($_GET['lotime']).' day'));
			
			}

			$urlarr['lotime']        	 		=  			$_GET['lotime'];
			
		}

		$urlarr['page']			  	  			=			'{{page}}';
		
		$pageurl				      			=			Url($_GET['m'],$urlarr,'admin');
		
		//提取分页
		$pageM					      			=			$this  -> MODEL('page');

		$pages					      			=			$pageM -> pageList('member',$where,$pageurl,$_GET['page']);
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
		    
			$List  								=  		 $userinfoM -> getList($where,array(),'admin');

			foreach($List  as $val){

				$gquids[]						=		$val['uid'];
				
			}
			
			$gqinfowhere['uid']					=		array('in', pylode(',',$gquids));

			$row								=		$gqdemandM->getGqinfoList($gqinfowhere,array('field'=>'`uid`,`name`,`moblie`,`sex`,`salary`,`provinceid`,`cityid`,`three_cityid`'));

			if(is_array($List) && $List){

				foreach($List as $k=>$v){

					foreach($row  as $val){

						if($v['uid']==$val['uid']){

							$List[$k]['name']		            =       $val['name'];

							$List[$k]['mobile']		            =       $val['mobile'];
				
							$List[$k]['salary']		            =       $val['salary'];

							$List[$k]['sex_n']					=		$val['sex_n'];

							$List[$k]['provinceid_n']			=		$val['provinceid_n'];

							$List[$k]['cityid_n']				=		$val['cityid_n'];

							$List[$k]['three_cityid_n']			=		$val['three_cityid_n'];

						}

					}

				}
				
			}
    
			$this -> yunset('rows',$List);
      
      
			
		}
    
    $this->siteadmin_tpl(array('admin_member_gqlist'));



	}
 	 //添加相关页面
  	public function add_action(){
    
		$cacheM           		=     $this->MODEL('cache');
			
		$options          		=     array('city','user');
			
		$cache            		=    	$cacheM -> GetCache($options);
      
		$this       ->  yunset('cache',  $cache);
		
		$user_sex         		=     $cache['user_sex'];

		$this       ->  yunset('user_sex',  $user_sex);
		
    $this->siteadmin_tpl(array('admin_gqmember_add'));
	
		
	}
	  
	  /**
	   * 保存添加
	   * 
	   *  */
	public function saveadd_action(){

		$gqdemandM        			=  		$this -> MODEL('gqdemand');

		$userinfoM        			=  		$this -> MODEL('userinfo');

		if($_POST['password']==''||mb_strlen($_POST['password'])<6||mb_strlen($_POST['password'])>20){

			$this -> ACT_layer_msg('密码格式错误',8);

		} 
		$pass						=			$_POST['password'];

		$pwdRes    					=   		$userinfoM -> generatePwd(array('password' => $pass));

		$salt      					= 	 		$pwdRes['salt'];
				
	    $password  					=  			$pwdRes['pwd'];

		$mData  					=  			array(

			'username'  			=> 			$_POST['moblie'],

			'password'  			=>  		$password,

			'usertype'  			=>  		5,

			'salt'      			=>  		$salt,
				
			'moblie'    			=>  		$_POST['moblie'],
				
			'status'    			=>  		1,

			'reg_date'    			=>  		time()
		
		);

		$gData  					=  			array(

			'name'         	  		=>  		trim($_POST['name']),
			
			'moblie'          		=>  		$_POST['moblie'],
			
			'sex'     		  		=>  		$_POST['sex'],
			
			'provinceid'      		=>  		$_POST['provinceid'],
			
			'cityid'          		=>  		$_POST['cityid'],
			
			'three_cityid'    		=>  		$_POST['three_cityid'],
			
			'services'        		=>  		str_replace(array('&amp;','background-color:#ffffff','background-color:#fff','white-space:nowrap;'),array('&','background-color:','background-color:','white-space:'),$_POST['services']),
			
			'salary'     	  		=>    		$_POST['salary'],
			
			'content'        		=>   		str_replace(array('&amp;','background-color:#ffffff','background-color:#fff','white-space:nowrap;'),array('&','background-color:','background-color:','white-space:'),$_POST['content']),
			
			'lastupdate'      		=>  		time(),
			
			'r_status'     	  		=>  		1,

			'speciality'			=>			$_POST['speciality'],

			'state'     	  		=>  		2,

			'moblie_status'    	 	=>  		1,

			'status'    		 	=>  		1
			
		);

		$nid  						=  			$userinfoM -> addInfo(array('mdata' => $mData,'udata' => $gData));

		if($nid > 0){
	            
			$this->ACT_layer_msg('会员(ID:'.$nid.')添加成功！',9,'index.php?m=admin_gqmember');
			
		}else{
			
			$this->ACT_layer_msg('会员添加失败，请重试！',8);
		}

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
      
     $this->siteadmin_tpl(array('admin_gqmember_details'));  


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
      
			$member					=			$userinfoM->getInfo(array('uid'=> $uid));

			$this->yunset('member',$member); 

			$this->yunset('row',$row); 
      
      		$this ->yunset('lasturl',   $_SERVER['HTTP_REFERER']);

		}
		$this->siteadmin_tpl(array('admin_gqmember_edit'));
	
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

			if($_POST['password']){

				$pass 	 			=  			$_POST['password'];

				$pwdRes    			=   		$userinfoM -> generatePwd(array('password' => $pass));
	            
				$salt      			= 	 		$pwdRes['salt'];
				
	            $password  			=  			$pwdRes['pwd'];
				
				$mData  			=  			array(

					'username'  	=> 			$_POST['moblie'],
					
					'password'  	=>  		$password,

					'salt'      	=>  		$salt,
					
					'moblie'    	=>  		$_POST['moblie'],
					
					'status'    	=>  		$_POST['status']
				);

			}else{

				$mData  			=  			array(

					'username'  	=>  		$_POST['moblie'],
					
					'moblie'    	=>  		$_POST['moblie'],
					
					'status'    	=>  		$_POST['status']

				);

			}

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
				
				'r_status'     	  	=>  		$_POST['status'],

				'speciality'		=>			$_POST['speciality'],

				'state'     	  	=>  		2
				
			);
			
			$where['uid']			=			$uid;
			
			$userinfoM->upInfo($where,$mData);

			$gData['file']			=			$_FILES['file'];
			
			$return 				=			$gqdemandM->upaddGqinfo($where,$gData);

			$this -> ACT_layer_msg($return['msg'],$return['errcode'],$lasturl);

		}

	}
	/**
	 * //删除功能
	 * 
	 */
	public function delqgInfo_action(){

		if ($_GET['del']){
	        
	        $this -> check_token();
	        
	        $uid  					=  			intval($_GET['del']);
	        
	    }elseif ($_POST['del']){
	        
        	$uid  					=  			$_POST['del'];
			
	    }
	    
	    $userinfoM  				=  			$this -> MODEL('userinfo');
	    
	    $return     				=  			$userinfoM -> delInfo($uid, 5);
	    
	    $this -> layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);

	}
	/**
	 * 审核功能
	 * 
	 */
	public function statis_action(){

		$userinfoM  				=  			$this -> MODEL('userinfo');
    
    	if($_POST['status']  ==""){
        
      		$this->ACT_layer_msg("请选择审核状态",8);return false;
          
     	}
    
		$post						=			array(

			'status'     			=>  		intval($_POST['status']),

	     	'lock_info'  			=>  		trim($_POST['statusbody'])

		);	

		$return     				=  			$userinfoM -> status(array('uid'=>intval($_POST['uid']),'usertype'=>5),array('post'=>$post));

		$this->ACT_layer_msg($return['msg'],$return['errcode'],$_SERVER['HTTP_REFERER'],2,1);

	}


	/**
	 * 锁定功能
	 */
	function lock_action(){
	    
		$userinfoM  				=  			$this -> MODEL('userinfo');
		
	    if($_POST['status']  ==""){
        
          	$this->ACT_layer_msg("请选择锁定操作",8);return false;
          
      	}
	    $post       				=  			array(

			'status'     			=>  		intval($_POST['status']),
			
			'lock_info'  			=>  		trim($_POST['lock_info'])
			
	    );
	    
	    $return     				=  			$userinfoM -> lock(array('uid'=>intval($_POST['uid']),'usertype'=>5),array('post'=>$post));
	    
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
	    
        $opera          			=   		array('7'=>'基本信息','8'=>'修改密码','13'=>'认证绑定','16'=>'上传图片','26'=>'浏览/屏蔽','29'=>'项目任务');
	   
		$parr           			=  			array('1'=>'增加','2'=>'变更','3'=>'删除','4'=>'刷新');
	   
		$ad_time        			=   		array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
        
		$search_list[]  			=   		array('param'=>'operas','name'=>'操作类型','value'=>$opera);
	   
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
                
                $where['uid']   	=   		array('like', $keyword);
                
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
		
		if($_GET['operas']){
		    
			$operas  				=  			 intval($_GET['operas']);
			
			$where['operas']   		=   		 $operas;
		   
		    
            $urlarr['operas']       =  			 $operas;
		    
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
        $this->siteadmin_tpl(array('admin_gq_member_log'));
	  
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


}

?>