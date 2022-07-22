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
class admin_school_graduate_controller extends adminCommon{
	//设置高级搜索功能
	function set_search(){
 
		include(CONFIG_PATH."db.data.php");
    
		$source=$arr_data['source'];
    
		$this->yunset('source',$source);
    
		$search_list[]=array("param"=>"state","name"=>'审核状态',"value"=>array("1"=>"已审核","4"=>"未审核","3"=>"未通过","2"=>"已锁定"));
    
		$search_list[]=array("param"=>"status","name"=>'招聘状态',"value"=>array("1"=>"已下架","2"=>"发布中"));
    
		$search_list[]=array("param"=>"jtype","name"=>'职位类型',"value"=>array("urgent"=>"紧急职位","xuanshang"=>"置顶职位","rec"=>"推荐职位"));
    
		$search_list[]=array("param"=>"source","name"=>'数据来源',"value"=>$source);
    
		$search_list[]=array("param"=>"adtime","name"=>'发布时间',"value"=>array("1"=>"今天","3"=>"最近三天","7"=>"最近七天","15"=>"最近半月","30"=>"最近一个月"));
    
 		$this->yunset("search_list",$search_list);
	}

	function index_action(){
    
		$this->set_search();
    
		$jobM		=	$this->MODEL('job');
		$resumeM	=	$this->MODEL('resume');
		
		$where['is_graduate']	=   1;
		$urlarr['is_graduate']  =   1;
    
		if ($_GET['keyword']){
        
			$keytype	=	intval($_GET['type']);
			$keyword	=   trim($_GET['keyword']);
        
			if($keytype    ==    1){
          
				$where['com_name']	=	array('like',$keyword);
			}else{
          
				$where['name']		=	array('like',$keyword);
			}
			$urlarr['keytype']		=   $keytype;
			$urlarr['keyword']		=   $keyword;
        
		}

		if($_GET['source']){
      
			$source					=   intval($_GET['source']);
			$where['source']		=   $source;
			$urlarr['source']		=   $source;
		}

		if ($_GET['job_type']){
      
			$jobtype				=   intval($_GET['job_type']);
			$where['type']			=   $jobtype;
			$urlarr['type']			=   $jobtype;

		}
		if($_GET['adtime']){
      
			if($_GET['adtime']=='1'){
        
				$where['sdate']		=	array('>',strtotime('today'));
       
			}else{
        
				$where['sdate']		=	array('>',strtotime('-'.intval($_GET['adtime']).' day'));
				
			}
			$urlarr['adtime']		=	$_GET['adtime'];
		}
		if($_GET['state']){
      
			$state					=   intval($_GET['state']);
			if($state==2){
				$where['r_status']	=	array('>', 1);
			}else{
				$where['state']		=	$state == 4 ? 0 : $state;
			}
			$urlarr['state']		=	$state;
      
		}
		if($_GET['status']){
        
			$status					=   intval($_GET['status']);
			$where['status']		=   $status ;
			$urlarr['status']		=   $status;
		}

		if($_GET['jtype']){
      
			if($_GET['jtype']=='rec'){
        
				$where['rec_time']		=	array('>',time());
			
			}else if($_GET['jtype']=='urgent'){
        
				$where['urgent_time']	=	array('>',time());
       
			}else if($_GET['jtype']=='xuanshang'){
				
				$where['xsdate']		=	array('>',time());
			}
			$urlarr['jtype']			=   $_GET['jtype'];
		}
		$urlarr        				=   $_GET;
		$urlarr['page']				=	'{{page}}';
		$pageurl					=	Url($_GET['m'],$urlarr,'admin');
		$pageM						=	$this  -> MODEL('page');
		$pages						=	$pageM -> pageList('company_job',$where,$pageurl,$_GET['page']);
		 if($pages['total'] > 0){
            
            //limit order 只有在列表查询时才需要
            if($_GET['order']){
                
                $where['orderby']		=	$_GET['t'].','.$_GET['order'];
                $urlarr['order']		=	$_GET['order'];
                $urlarr['t']			=	$_GET['t'];
                
            }else{
                
                $where['orderby']		=	array('r_status,asc','state,asc','lastupdate,desc');
                
            }
            
            $where['limit']				=	$pages['limit'];
            
            $ListJob    =   $jobM -> getList($where,array('utype'=>'admin','cache'=>'1','isurl'=>'yes'));
            
            $this -> yunset('rows',$ListJob['list']);
              
        }

        $cacheM     =   $this->MODEL('cache');
		$options    =   array('job','com','city','hy');
		$cache      =   $cacheM -> GetCache($options);
		$this -> yunset($cache);
		
		$this->yuntpl(array('admin/admin_school_graduate'));
	}

    //职位详情及修改
	function show_action(){
    
		$cacheM     =   $this->MODEL('cache');
		$options    =   array('job','com','city','hy');
		$cache      =   $cacheM -> GetCache($options);
		$this -> yunset('cache',$cache);

		$JobM       =   $this->MODEL('job');
		
		if($_GET['id']){
		  
			$id   =   intval($_GET['id']);
			$info =   $JobM   ->  getInfo(array('id' => $id));

			$info['lang']=@explode(',',$info['lang']);
			$this ->  yunset('show',  $info);
			$this ->  yunset('lasturl',   $_SERVER['HTTP_REFERER']);
		}
		
		if($_POST['update']){
			
			$lasturl =   $_POST['lasturl'];

      		$postData   =   array(
                'name'          =>  trim($_POST['name']),
                'hy'            =>  intval($_POST['hy']),
                'job1'          =>  intval($_POST['job1']),
                'job1_son'      =>  intval($_POST['job1_son']),
                'job_post'      =>  intval($_POST['job_post']),
                'provinceid'    =>  intval($_POST['provinceid']),
                'cityid'        =>  intval($_POST['cityid']),
                'three_cityid'  =>  intval($_POST['three_cityid']),
                'minsalary'     =>  intval($_POST['salary_tpy'])==1?0:intval($_POST['minsalary']),
                'maxsalary'     =>  intval($_POST['salary_tpy'])==1?0:intval($_POST['maxsalary']),
                'number'        =>  intval($_POST['number']),
                'exp'           =>  intval($_POST['exp']),
                'report'        =>  intval($_POST['report']),
                'age'           =>  intval($_POST['age']),
                'sex'           =>  intval($_POST['sex']),
                'edu'           =>  intval($_POST['edu']),
                'is_graduate'   =>  intval($_POST['is_graduate']),
                'marriage'      =>  intval($_POST['marriage']),
                'lang'          =>  trim(pylode(',', $_POST['lang'])),
                'description'   =>  str_replace('&amp;','&',$_POST['content']),
                'jobhits'       =>  intval($_POST['jobhits']),
                'lastupdate'    =>  time()
            );
            
				$where['id']             =   	intval($_POST['id']);
              
             	$where['uid']            =   	intval($info['uid']);
				

				$return         =   $JobM -> upInfo($postData,$where);
				if($return){
					$this->ACT_layer_msg('职位更新成功',9,$lasturl,2,1);
				}else{
					$this->ACT_layer_msg('职位更新失败',8,$lasturl,2,1);
				}
				

		}          
		$this->yunset('uid',$_GET['uid']);

		$this->yuntpl(array('admin/admin_company_job_show'));
	}
	function lockinfo_action(){
    
		$jobM       =       $this   ->    MODEL("job");
		$id         =       intval($_POST['id']);
		$info       =       $jobM->getInfo(array('id' => $id),array('field'=>'statusbody'));
		echo $info['statusbody'];die;
    
	}
	function status_action(){
     
		$JobM  =   $this -> MODEL('job');
     
		if($_POST['pid']){
       
        $id                    =   @explode(',',$_POST['pid']);
        
        $data['state']         =   $_POST['status'];
	        
        $data['statusbody']    =   $_POST['statusbody'];
	       
        $data['lastupdate']    =   time();
        
        $nid                   =   $JobM -> upInfo($data, array('id' => array('in', pylode(',', $id))));
		
		$List					=	$JobM->getList(array('id'=>array('in',$_POST['pid'])) , array('field'=>'`id`,`uid`,`name`'));
		/* 消息前缀 */		
		$tagName  				=	'职位';
		
		foreach($List as $v){
			
			 $uids[]  =  $v['uid'];
						
			/* 处理审核信息 */
			if ($_POST['status'] == 3){
				
				$statusInfo  =  $tagName.':<a href="comjobtpl,'.$v['id'].'">'.$v['name'].'</a>审核未通过';
				
				if($_POST['statusbody']){
					
					$statusInfo  .=  ' , 原因：'.$_POST['statusbody'];
					
				}
				
				$msg[$v['uid']][]  =  $statusInfo;
				
			}elseif($_POST['status'] == 1){
				
				$msg[$v['uid']][]  =  $tagName.':<a href="comjobtpl,'.$v['id'].'">'.$v['name'].'</a>已审核通过';
				
			}
		}
		//发送系统通知
		
		$sysmsgM	=	$this->MODEL('sysmsg');
		
		$sysmsgM -> addInfo(array('uid'=>$uids,'usertype'=>4, 'content'=>$msg));
		
        
        $nid?$this->ACT_layer_msg("职位审核(ID:".pylode(',', $id).")设置成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg("设置失败！",8,$_SERVER['HTTP_REFERER']);
       
		}else{
			$this->ACT_layer_msg("非法操作！",8,$_SERVER['HTTP_REFERER']);
		}
	}
    function cjobstatus_action(){
      $userinfoM  =  $this -> MODEL('userinfo');

	    $post       =  array(

          'status'     =>  intval($_POST['r_status']),
			
	        'lock_info'  =>  trim($_POST['statusbody'])
	    );

      $return        =   $userinfoM -> status(array('uid' =>$_POST['cuid'],'usertype'=>2),array('post'=>$post));
      
      if($_POST['r_status']==1){
        
        $jobM       =   $this->MODEL('job');
        
        $statusData = array(
            'state'         =>  1,
            'statusbody'    =>  trim($_POST['statusbody'])
        );
        
         $jobM -> statusJob($_POST['cid'], $statusData);
      
      }
		
      if($return['errcode']==9){
        
        $this  ->  ACT_layer_msg('审核成功',9,$_SERVER['HTTP_REFERER'],2,1);
    
      }else{
        
        $this  ->  ACT_layer_msg('审核失败',8);
      
      } 
    }
		// 转移类别
    function saveclass_action(){
        
		$JobM   =   $this -> MODEL('job');
 		
		if($_POST['hy']   ==  ''){
			$this -> ACT_layer_msg('请选择行业类别！',8,$_SERVER['HTTP_REFERER']);
		}
		if($_POST['job1'] ==  ''){
			$this -> ACT_layer_msg('请选择职位类别！',8,$_SERVER['HTTP_REFERER']);
		}
		$data['hy']       =   $_POST['hy'];
		$data['job1']     =   $_POST['job1'];
		$data['job1_son'] =   $_POST['job1_son'];
		$data['job_post'] =   $_POST['job_post'];
		$id               =   @explode(',',$_POST['jobid']);

		$listA            =   $JobM -> getList(array('id' => array('in',pylode(',',$id))), array('cache'=>'1','field'=>'id,uid,name'));

		$nid              =   $JobM -> upInfo($data, array('id' => array('in',pylode(',',$id))));

		$job              =   $listA['list'];
		$cache            =   $listA['cache'];
      
		if($job){
			$msg          =   array();
			$uids         =   array();
          
			//  提取职位uid 和职位名称
			foreach ($job   as  $k => $v){
				  
				$uids[] =  $v['uid'];

				$msg[$v['uid']][]	=  	'您的职位<a href="comjobtpl,'.$v['id'].'">《'.$v['name'].'》</a>管理员已修改，行业类别为：'.$cache['industry_name'][$_POST['hy']].'，职位类别为：'.$cache['job_name'][$_POST['job1']];

				if($_POST['job1_son']){
				  $msg[$v['uid']][]	.= 	''.$cache[job_name][$_POST['job1_son']];
				}
				if($_POST['job_post']){
				  $msg[$v['uid']][]	.= 	''.$cache[job_name][$_POST['job_post']];
				}
			}
			   
			$sysmsgM    =   $this -> MODEL('sysmsg');
			$sysmsgM    ->  addInfo(array('uid'=>$uids,'usertype'=>4, 'content'=>$msg));
		}
		$nid?$this->ACT_layer_msg('职位类别(ID:'.$_POST['jobid'].')修改成功！',9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg('修改失败！',8,$_SERVER['HTTP_REFERER']);
	}
	// 	职位置顶
	function xuanshang_action(){
    
        $id     =   trim($_POST['pid']);
        $data   =   array(
            'top'   =>  intval($_POST['s']),
            'days'  =>  intval($_POST['xsdays'])
        );
        $JobM   =   $this -> MODEL('job');
        $arr    =   $JobM -> addTopJob($id, $data);
        $this  ->  ACT_layer_msg( $arr['msg'],$arr['errcode'],$_SERVER['HTTP_REFERER'],2,1);
        
	}
	//  职位推荐
	function recommend_action(){
	    
	    $id     =   trim($_POST['pid']);
	    $data   =   array(
	        'rec'   =>  intval($_POST['s']),
	        'days'  =>  intval($_POST['addday'])
	    );
	    $JobM   =   $this -> MODEL('job');
	    $arr    =   $JobM -> addRecJob($id, $data);
	    $this  ->  ACT_layer_msg( $arr['msg'],$arr['errcode'],$_SERVER['HTTP_REFERER'],2,1);
	}
	//  职位紧急招聘
	function urgent_action(){
	    
	    $id     =   trim($_POST['pid']);
	    $data   =   array(
	        'urgent'   =>  intval($_POST['s']),
	        'days'     =>  intval($_POST['addday'])
	    );
	    
	    $JobM   =   $this -> MODEL('job');
	    $arr    =   $JobM -> addUrgentJob($id, $data);
	    $this  ->  ACT_layer_msg( $arr['msg'],$arr['errcode'],$_SERVER['HTTP_REFERER'],2,1);
	}
	function del_action(){
    
		$this->check_token();
    
		$JobM	=	$this -> Model('job');
		$delID	=	is_array($_GET['del']) ? $_GET['del'] : $_GET['id'];
		$addArr	=	$JobM -> delJob($delID,array('utype'=>'admin'));
		$this   ->  layer_msg( $addArr['msg'],$addArr['errcode'],$addArr['layertype'],$_SERVER['HTTP_REFERER'],2,1);
	}
	function refresh_action(){
    
		$JobM      =   $this -> MODEL('job');		
		$ids       =   @explode(',', $_POST['ids']);	
		$return    =   $JobM -> upInfo(array('lastupdate'=>time()), array('id' => array('in',pylode(',',$ids))));
		$this->MODEL('log')->addAdminLog("职位(ID".$_POST['ids']."刷新成功");
	}
	function xls_action(){
    
		session_start();
    
		$where = $_SESSION['jobXls'] ? $_SESSION['jobXls'] : array('orderby'=>'id');
      
		if(!empty($_POST['type'])){
      
			foreach($_POST['type'] as $v){
	            
	            if($v == 'lastdate'){
	                
	                $type[]  =  'lastupdate';
	            }else{
	                $type[]  =  $v;
	            }
	        }
           $field  =  @implode(',', $type).',uid';
		}else{
			$field  =  'uid';
		}
      
		if($_POST['pid']){
	        
	        $ids          =  @explode(',',$_POST['pid']);
	        $where['id']  =  array('in',pylode(',',$ids));
 	    }
      
		if($_POST['limit']){
	        
	        $where['limit']  =  intval($_POST['limit']);
	    }
	    
	    $jobM      =   $this -> MODEL('job');
	    $listNew   =   $jobM -> getList($where,array('cache'=>1,'field'=>$field));
	    
	    $jobs      =   $listNew['list'];
	    $cache     =   $listNew['cache'];
      
		if (!empty($jobs)){
	        
	        foreach($jobs as $k => $v){
	            
	            $langs = array();
	            
	            if($v['lang']!=""){
	                
 	                $lang =   @explode(",",$v['lang']);
	                foreach($lang as $val){
	                
	                    $langs[]   =   $cache['comclass_name'][$val];
	                }
	                $jobs[$k]['lang_info'] = @implode(",",$langs);
	            } 
	        }	        
 	        $this->yunset("cache",$cache);          
	        $this->yunset("list",$jobs);         
	        $this->yunset("type",$_POST['type']);
	        
	        $this->MODEL('log')->addAdminLog("导出职位信息");          
	        header("Content-Type: application/vnd.ms-excel");          
	        header("Content-Disposition: attachment; filename=job.xls");
	        $this->yuntpl(array('admin/admin_job_xls'));
	    }
	}
	function checkstate_action(){
    
		$JobM	=   $this -> MODEL('job');
     
		if($_POST['id'] && $_POST['state']){
      
			$id	=	intval($_POST['id']);
			if($_POST['state']  ==2 ){

				$_POST['state']	=   0;
			}
			$data['status']     = 	$_POST['state'];
			$nid             	=   $JobM -> upInfo($data, array('id' => $id));
		}
		echo 1;
	}
	function matching_action(){
        
        $JobM       =   $this -> MODEL('job');
        $ResumeM    =   $this -> MODEL('resume');
        $blackM    =   $this -> MODEL('black');
        
        if($_GET['id']){
	      
              $id  =   intval($_GET['id']);
              
              $where['defaults']        =   '1';
              $where['status']             =   array('<>','2');
              $where['r_status']           =   array('<>','2');
              $where['defaults']           =  '1';
              
              $jobinfo                   =   $JobM -> getInfo(array('id' => $id), array('field'=>'uid,job1,job1_son,job_post,provinceid,cityid,three_cityid'));
           
              $this->yunset('comid',$jobinfo['uid']);
	      
            if($jobinfo){
				
                $where['PHPYUNBTWSTART_A']  	=    '';
                $where['city_classid'][]  	=   array('findin', $jobinfo['provinceid'],'OR');
                $where['city_classid'][]  	=   array('findin', $jobinfo['cityid'], 'OR');
                $where['city_classid'][]  	=   array('findin', $jobinfo['three_cityid'], 'OR');
                $where['PHPYUNBTWEND_A']   	=   '';
				
                $where['PHPYUNBTWSTART_B']	=   '';
                $where['job_classid'][]   	=   array('findin', $jobinfo['job1'],'OR');
                $where['job_classid'][]   	=   array('findin', $jobinfo['job1_son'], 'OR');
                $where['job_classid'][]   	=   array('findin', $jobinfo['job_post'], 'OR');
                $where['PHPYUNBTWEND_B'] 		=   '';
                
			}
			$record    =   $ResumeM -> getResTsList(array('jobid'=>$id),array('field'=>'eid'));
        
			if(!empty($record)){
	             
				foreach($record as $v){
						
				  $eids[] =   $v['eid'];
				}
				$where['id']          =   array('notin', pylode(',', $eids));
			}
            $black              =   $blackM -> getBlackList(array('p_uid'=>$jobinfo['uid']));
			if(!empty($black)){
                    
				foreach($black as $v){
                  
					$buids[] =   $v['c_uid'];
				}  
				$where['uid']         =   array('notin', pylode(',', $buids)); 
            }
			$urlarr        		=   $_GET;
            $urlarr['page']	    =	'{{page}}';
            $pageurl            =   Url('admin_school_graduate&c=matching&id='.$id.'',$urlarr,'admin');
            $pageM              =	$this  -> MODEL('page');
            $pages              =	$pageM -> pageList('resume_expect',$where,$pageurl,$_GET['page']);
   
            if($pages['total'] > 0){
				
                $where['orderby']       =   'lastupdate';
                $where['limit']         =	$pages['limit'];
				
                $List                   =	$ResumeM -> getList($where,array('cache'=>1));
                $CacheList    =   $List['cache'];
                $this -> yunset(array('resumes'=>$List['list']));
            }
           $this->yuntpl(array('admin/admin_matching'));
	    }
	}

	function sjobNum_action(){
    
		$MsgNum = $this->MODEL('msgNum');
		echo $MsgNum->sjobNum();
	}
}
?>