<?php
/* *
* $Author ：PHPYUN开发团队
*
* 官网: http://www.phpyun.com
*
* 版权所有 2009-2018 宿迁鑫潮信息技术有限公司，并保留所有权利。
*
* 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
*/
class friendhelp_controller extends adminCommon{  
	//设置高级搜索功能
	function set_search(){
		include (APP_PATH."/config/db.data.php");
		
		
		
		$search_list[]	=	array("param"=>"help_state","name"=>'助力状态',"value"=>array("1"=>"助力中","2"=>"已结束"));
		
		$lo_time		=	array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$search_list[]	=	array("param"=>"time","name"=>'助力发布',"value"=>$lo_time);
		
		$this -> yunset("search_list",$search_list);
	}
	function index_action(){
		$this->yuntpl(array('admin/admin_friendhelp'));
	}
	function save_action()
	{
	    $configM	=	$this->MODEL('config');
	    
	    $_POST	=	$this->post_trim($_POST);

	    if ($_POST['sy_help_open'] == 'on'){
	        
	        $_POST['sy_help_open']			=	1;
	        
	    }else{
	        
	        $_POST['sy_help_open'] 			= 	2;
	        
	    }
		
	    unset($_POST['config']);
        unset($_POST['pytoken']);
	    
	    $configM->setConfig($_POST);
	    
	    $this->web_config();
	    
	    $this->ACT_layer_msg("助力设置成功！",9,$_SERVER['HTTP_REFERER'],2,1);
	}
	

	function list_action(){
		
		$this -> set_search();
		
		$helpM							=	$this -> MODEL('friendhelp');
		
		$where							=   array();
	    $urlarr							=   $_GET;
	    $keywordStr						=   trim($_GET['keyword']);
		
		if($_GET['help_state']){
			if($_GET['help_state'] == 2){
					$where['etime'][]	=	array('<',time());
				}else{
					$where['etime'][]	=	array('>=',time());
			}
			$urlarr['help_state']		=	$_GET['help_state'];
		}
		if($_GET['news_search']){

			if($keywordStr){
				if($_GET['typeca']==2){
					$where['comid']   	=   array('=', $keywordStr);
				}else{
					$listC          =   $ComM -> getList( array('name' => array('like', $keywordStr)),array('field'=>'uid'));
				    
	                $minfo          =   $listC['list'];
	                
	                $uids       =   array();
	                
	                if ($minfo){
				        
	                    foreach($minfo as $mv){
				            
	                        $uids[] =  $mv['uid'];
				        }
				    }
				    
				    $where['comid'] =   array('in', pylode(',', $uids));
				}
			}

			$urlarr['keyword']			=	$keywordStr;
			$urlarr['typeca']			=	$_GET['typeca'];
			$urlarr['news_search']		=	$_GET['news_search'];
		}
		if($_GET['time'] || $_GET['time_start1']!="" || $_GET['time_end1']!=""){
			$where['PHPYUNBTWSTART_B']    =   'AND';
			if($_GET['time']){
				if($_GET['time'] == 1){
					$where['stime'][]	=	array('>=',strtotime(date("Y-m-d 00:00:00")));
				}else{
					$where['stime'][]	=	array('>=',strtotime('-'.intval($_GET['time']).' day'));
				}
				$urlarr['time']				=	$_GET['time'];
			}
			if($_GET['time_start1']!=""){
				$where['stime'][]		=	array('>=',strtotime($_GET['time_start1']." 00:00:00"));

				$urlarr['time_start1']		=	$_GET['time_start1'];
			}
			if($_GET['time_end1']!=""){
				$where['stime'][]		=	array('<',strtotime($_GET['time_end1']." 23:59:59"));

				$urlarr['time_end1']		=	$_GET['time_end1'];
			}
			$where['PHPYUNBTWEND_B']	=	'';
		}
		if($_GET['hashelp']==1){
			$where['zlnum'] =   array('>', 0);
		}
		$urlarr['c']					=	"list";
		$urlarr['page']					=	"{{page}}";
		
		$pageurl						=	Url($_GET['m'],$urlarr,'admin');
		
		$pageM							=	$this  -> MODEL('page');
		
		$pages							=	$pageM -> pageList('friend_help',$where,$pageurl,$_GET['page']);
		
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
			
	        $rows    					=   $helpM -> getList($where);
			
	    }
        
		$this->yunset("rows",$rows['list']);
		$this->yuntpl(array('admin/admin_friend_helplist'));	
	}

	function helpSum_action(){
		$MsgNum=$this->MODEL('msgNum');
		echo $MsgNum->helpSum();
	}

	function loglist_action(){

		
		
		if($_POST['id']){
		
			$helpM		=	$this -> MODEL('friendhelp');
			$logList	=	$helpM -> getLogList(array('pid' => intval($_POST['id'])));
			if(!empty($logList)){
				echo json_encode($logList);
			}
			
		
		}
	
	}
	function del_action(){
	
		$this->check_token();
		
		$helpM	=	$this -> Model('friendhelp');
		
		$delID	=	$_GET['id'] ? intval($_GET['id']) : $_GET['del'];
		
		$addArr	=	$helpM -> delHelp($delID);
		
		$this   ->  layer_msg( $addArr['msg'],$addArr['errcode'],$addArr['layertype'],$_SERVER['HTTP_REFERER'],2,1);

	}
	function helptool_action(){
		$this->yuntpl(array('admin/admin_friend_helptool'));
	}
	function helptooladd_action(){
		$ratingM    =   $this -> MODEL('rating');
		$rating_list   =   $ratingM -> getList(array( 'category' => '1'), array('field'=>'`id`,`name`'));
		$this->yunset("rating_list",$rating_list);
		$this->yuntpl(array('admin/admin_friend_helptooladd'));
	}
	function helptoolgzh_action(){
		$type		=	$_POST['type'];
		$checkarr	=	$_POST['checkarr'];
		$sort		=	$_POST['sort'];
		$num		=	$_POST['num'];
		$JobM		=	$this->MODEL('job');
		$CompanyM	=	$this->MODEL('company');

		$where  =   $cwhere =   array();
        $html   =   "";

		if($type==1){
			$where['state']		=	1;
			$where['r_status']	=	1;
			$where['status']	=	0;
			if($checkarr && is_array($checkarr)){
				$where['rating']	=	array('in',pylode(',', $checkarr));
			}
			$where['limit']		=	$num;
			if($sort==2){
				$where['orderby']	=	'lastupdate,desc';
			}else{
				$where['orderby']	=	'id,desc';
			}
			$joblist	=	$JobM -> getList($where);
			$jobAll		=	$joblist['list'];

			if($jobAll && is_array($jobAll)){
				foreach($jobAll as $val){
					$html.="<li>";
					$html.=$val['name'];
					if($val['minsalary'] && $val['maxsalary']){
					    if($this ->config['resume_salarytype']==1){
					        $html.=$val['minsalary']."-".$val['maxsalary'];
					    }else{
					        if($val['maxsalary']<1000){
					            if($this->config['resume_salarytype']==2){
					                $html.= '1千以下';
					            }elseif($this->config['resume_salarytype']==3){
					                $html.= '1K以下';
					            }elseif($this->config['resume_salarytype']==4){
					                $html.= '1k以下';
					            }
					        }else if($val['minsalary']<1000){
					            $html.= changeSalary($val['maxsalary']);
					        }else{
					            $html.= changeSalary($val['minsalary']).'-'.changeSalary($val['maxsalary']);
					        }
					    }
					}elseif($val['minsalary']){ 
					    $html.= changeSalary($val['minsalary']);
					}else{
						$html.="面议";
					}
					$html.=$val['description'];
					$html.="</li>";
				}
			}
		}else{
			$cwhere['name']		=	array('<>','');
			$cwhere['r_status']	=	1;
			$comlist			=	$CompanyM -> getList($cwhere);
			$comall				=	$comlist['list'];
			if($comall && is_array($comall)){
				foreach($comall as $val){
					$html.="<li>";
					$html.=$val['name'];
					$html.=$val['rating_name'];
					$html.="</li>";
				}
			}
			
		}
		echo $html;die;
	}

}
?>