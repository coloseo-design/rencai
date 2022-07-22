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
class admin_jobtellog_controller extends adminCommon{

	function set_search(){
	    
	    include(CONFIG_PATH.'db.data.php');

        $ad_time        =   array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
        $source			=	array();
        foreach($arr_data['source'] as $sk=>$sv){
        	if(in_array($sk,array('2','3','13','19','22'))){
        		$source[$sk] = $sv;
        	}
        }
        $search_list    =   array();
        $search_list[]  =   array('param'=>'source','name'=>'操作平台','value'=>$source);
        $search_list[]  =   array('param'=>'end','name'=>'操作时间','value'=>$ad_time);
        
		$this->yunset('search_list',$search_list);
	}

	function index_action(){

		$this -> set_search();

 		if($_GET['keyword']){
		    
            $type           =   intval($_GET['type']);
		    
            $keyword        =   trim($_GET['keyword']);
		    
            if($type == 1){

            	$resumeM           =   $this->MODEL('resume');

                $where['uid']   =   array('like', $keyword);

                $resumelist = $resumeM->getResumeList(array('name' => array('like', $keyword)),array('field'=>'uid'));

                if ($resumelist){
			        
                    $uids       =   array();
			        
                    foreach($resumelist as $rv){
			            
                        $uids[] =  $rv['uid'];
			        }
			        
                    $where['uid']   =   array('in', pylode(',', $uids));
			    }

			}else if($type == 2){

				$jobM           =   $this->MODEL('job');

                
                $joblist = $jobM->getList(array('name' => array('like', $keyword)),array('field'=>'id'));

                if ($joblist['list']){
			        
                    $jobids       =   array();
			        
                    foreach($joblist['list'] as $jv){
			            
                        $jobids[] =  $jv['id'];
			        }
			        
                    $where['jobid']   =   array('in', pylode(',', $jobids));
			    }

			}else if($type == 3){
			    
                $ComM           =   $this->MODEL('company');
			    
                $listC          =   $ComM -> getList( array('name' => array('like', $keyword)),array('field'=>'uid'));
			    
                $minfo          =   $listC['list'];
                
                if ($minfo){
			        
                    $uids       =   array();
			        
                    foreach($minfo as $mv){
			            
                        $uids[] =  $mv['uid'];
			        }
			        
                    $where['comid']   =   array('in', pylode(',', $uids));
			    }
				
			}else if($type == 4){
			    
			    $where['ip']    =   array('like', $keyword);
				
			}
			
			$urlarr['type']      =   $type;
			$urlarr['keyword']   =   $keyword;
			
		}
		
		
		if($_GET['source']){
		    
            $where['source']         =   intval($_GET['source']);
		    
            $urlarr['source']        =   $_GET['source'];
		}
		
		

	    if($_GET['end']){
	        
	        if($_GET['end']=='1'){
	            
	            $where['ctime']  =   array('>=', strtotime(date("Y-m-d 00:00:00")));
	            
	        }else{
	            
	            $where['ctime']   =   array('>=', '-'.strtotime((int)$_GET['end'].'day'));
	            
	        }
	        
            $urlarr['end']          =   $_GET['end'];
	    }
	    if($_GET['time']){
	        
			$times  =  @explode('~',$_GET['time']);
			
			$where['PHPYUNBTWSTART']     =  '';
			$where['ctime'][]       =  array('>=',strtotime($times[0]));
			$where['ctime'][]       =  array('<=',strtotime($times[1].'23:59:59'));
			$where['PHPYUNBTWEND']  =  '';
			
	        $urlarr['time']  =  $_GET['time'];
	    }
		$urlarr        	=   $_GET;
        $urlarr['page'] =   "{{page}}";
	    
        $pageurl        =   Url($_GET['m'], $urlarr, 'admin');
	    
        //提取分页
        $pageM          =	$this  -> MODEL('page');
        $pages          =	$pageM -> pageList('job_tellog', $where, $pageurl, $_GET['page']);
        
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
            
            $where['limit']         =	$pages['limit'];
            
            $jobM       =   $this -> MODEL('job');
            
            $List       =   $jobM -> getTelLogs($where,array('utype'=>'admin'));
            
            $this -> yunset(array('rows' => $List));
        }

		$this -> yuntpl(array('admin/admin_jobtellog'));
	}
	function del_action(){

		if (is_array($_GET['del'])){
	        
	        $id        =   pylode(',', $_GET['del']);
	        
	        $where     =   array('id' => array('in', $id));
	        
	    }else{
	        
	        $this      ->  check_token();
	        
	        $where     =   array('id' => intval($_GET['del']));
	    }
	    
	    $jobM    =  $this -> MODEL('job');
	    
	    $return  =  $jobM -> delJobTelLog($where);
	    
	    $this  ->  layer_msg($return['msg'], $return['errcode'], $return['layertype'],$_SERVER['HTTP_REFERER']);
	}
}

?>