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
class admin_comjob_controller extends adminCommon{
	function index_action(){ 
		$JobM	=	$this -> MODEL('job');
		if(trim($_GET['keyword'])){
			$where['name']		=	array('like',trim($_GET['keyword']));
			$urlarr['keyword']	=	$_GET['keyword'];
		}
		if ($_GET['state']) {
			$state		=	intval($_GET['state']);
			if ($state == 2) {
				$where['r_status']	=	2;
			} else {
				$where['state']		=	$state == 4 ? 0 : $state;
			}
			$urlarr['state']		=	$state;
		}
		$urlarr['c']	=	$_GET['c'];
		$urlarr['page']	=	"{{page}}";
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');
		$pageM	=	$this  -> MODEL('page');
		$pages	=	$pageM -> pageList('company_job',$where,$pageurl,$_GET['page']);
		if($pages['total'] > 0){
			$where['orderby']	=	array('state,asc','lastupdate,desc');
			$where['limit']		=	$pages['limit'];
			$rows				=	$JobM -> getList($where);
		}
		$this->yunset("rows",$rows['list']);	
		$this->yunset('backurl', basename($_SERVER['HTTP_REFERER']));
		$this->yunset("headertitle","职位管理");
		$this->yuntpl(array('wapadmin/admin_comjob'));
	}
	function show_action(){
		$JobM	=	$this -> MODEL('job');
		if($_GET['id']){
			$row	=	$JobM -> getInfo(array('id'=>intval($_GET['id'])));
			$this->yunset("row",$row);
		}
		$this->yunset($this->MODEL('cache')->GetCache(array('city','job','hy')));
		include(CONFIG_PATH."db.data.php");
		$source		=	$arr_data['source'];
		$this->yunset('source',$source);
		$lasturl	=	$_SERVER['HTTP_REFERER'];
		if(strpos($lasturl, 'a=show')===false){
		    if(strpos($lasturl, 'c=admin_comjob')!==false){
		        $this->cookie->setcookie('lasturl',$lasturl,time()+300);
		        $_COOKIE['lasturl']		=	$lasturl;
		    }
		}
		$this->yunset('lasturl',$_COOKIE['lasturl']);
		$this->yunset("headertitle","职位详情");
		$this->yuntpl(array('wapadmin/admin_comjob_show'));
	}
	function edit_action(){
		include(CONFIG_PATH."db.data.php");		
		$this->yunset("arr_data",$arr_data);
		$this->yunset($this->MODEL('cache')->GetCache(array('city','hy','com','job')));
		$JobM		=	$this -> MODEL('job');
		$CompanyM	=	$this -> MODEL('company');
		if($_GET['id']){
			$row	=	$JobM -> getInfo(array('id'=>intval($_GET['id'])),array('add'=>'yes'));
			$this->yunset("row",$row);
			$this->yunset("lasturl",$_SERVER['HTTP_REFERER']);
			$uid	=	$row['uid'];
		}
		if(intval($_GET['uid'])){ 
          $uid		=	intval($_GET['uid']);	
        }
		$company	=	$CompanyM->getInfo($uid,array('field'=>'`uid`,r_status'));
		$this->yunset('company',$company);
		$this->yunset('uid',$uid);
		if($_POST['update']){
			$postData	=	array(
				'name'			=>	$_POST['name'],
				'hy'            =>  intval($_POST['hy']),
				'job1'          =>  intval($_POST['job1']),
                'job1_son'      =>  intval($_POST['job1_son']),
                'job_post'      =>  intval($_POST['job_post']),
				'provinceid'    =>  intval($_POST['provinceid']),
                'cityid'        =>  intval($_POST['cityid']),
				'three_cityid'  =>  intval($_POST['three_cityid']),
				'minsalary'     =>  intval($_POST['salary_type']) == 1 ? 0 : intval($_POST['minsalary']),
				'maxsalary'     =>  intval($_POST['salary_type']) == 1 ? 0 : intval($_POST['maxsalary']),
				'number'        =>  intval($_POST['number']),
				'exp'           =>  intval($_POST['exp']),
                'report'        =>  intval($_POST['report']),
				'sex'           =>  intval($_POST['sex']),
				'edu'           =>  intval($_POST['edu']),
				'marriage'      =>  intval($_POST['marriage']),
				'lang'          =>  trim(pylode(',', $_POST['lang'])),
				'description'	=>	str_replace("&amp;","&",html_entity_decode($_POST['description'],ENT_QUOTES)),
				'r_status'      =>	$company['r_status'],
				'state'      	=> 	$company['r_status']==1 ? 1:0
			);
			$data=array(
				'post'			=>	$postData,
				'id'			=>	intval($_POST['id']),
				'uid'			=>	intval($_POST['uid']),
				'utype'			=>	'admin'
			);
			$return		=	$JobM -> addJobInfo($data);
			if($return['errcode']==9){
				$data['msg']	=	$return['msg'];
				$data['url']	=	'index.php?c=admin_comjob';
				$this->yunset("layer",$data);
			}
		}
		$this->yunset("headertitle","职位操作");
		$this->yuntpl(array('wapadmin/admin_comjob_edit'));
	}
	function status_action(){
		$JobM	=	$this->MODEL('job');
		if ($_POST['lasturl']!=''){
		    $lasturl	=	$this->post_trim($_POST['lasturl']);
		}else{
		    $lasturl	=	$_SERVER['HTTP_REFERER'];
		}
        $statusData		=	array(
            'state'			=>  intval($_POST['status']),
            'statusbody'    =>  trim($_POST['statusbody'])
        );
        $return		=	$JobM -> statusJob($_POST['id'], $statusData);
		$this->layer_msg($return['msg'],$return['errcode'],0,$lasturl);
	}
	function del_action(){
		$JobM	=	$this -> Model('job');
		$PackM	=	$this->Model('pack');
	    if($_GET['del']||$_GET['id']){
			$delID	=	is_array($_GET['del']) ? $_GET['del'] : $_GET['id'];
    		if(is_array($_GET['del'])){
    			$layer_type	=	1;
	    	}else{
	    		$layer_type	=	0;
	    	}
			$rewardList	=	$PackM -> getRewardJobList(array('jobid'=>array('in',pylode(',', $delID))));
			$shareList	=   $PackM -> getShareJobList(array('jobid'=>array('in',pylode(',', $delID))),array('utype'=>'admin'));
			if($rewardList ||  $shareList){
				if($rewardList){
					foreach($rewardList as $val){
						$rjobids[]	=	$val['jobid']; 
					}
				}
				if($shareList){
					foreach($shareList as $val){
						$sjobids[]	=	$val['jobid']; 
					}
				}
				if($rjobids && $sjobids){
					$input	=	array_merge($rjobids,$sjobids);//先组合一个$uid;
				}else{
					if($rjobids){
						$input	=	$rjobids;
					}else{
						$input	=	$sjobids;
					}
				}
				$jobid     =  array_merge(array_diff($input,$delID),array_diff($delID,$input));
				$numjobid  =  array_diff_assoc($input,$delID);//获取到重复的值
				$jobnum    =  count($jobid);//删除id
				$rewanum   =  count($numjobid);//无法删除id
				 if($jobnum>0){
				     $addArr	=	$JobM -> delJob($jobid, array('utype'=>'admin'));
                if($rewanum>0){
						$msg	=	"删除成功职位".$jobnum.",删除失败".$rewanum.",原因：还有赏金未处理";
						$this->layer_msg($msg,$addArr['errcode'],$addArr['layertype'],$_SERVER['HTTP_REFERER'],2,1);
					}else{   
						$this->layer_msg( $addArr['msg'],$addArr['errcode'],$addArr['layertype'],$_SERVER['HTTP_REFERER'],2,1);
					}
				}else{
					$this->layer_msg('该职位还有赏金未处理,无法删除！',8,$layer_type,$_SERVER['HTTP_REFERER'],2,1);
				}
			}else{
			    $addArr		=	$JobM -> delJob($delID, array('utype'=>'admin'));
				$this->layer_msg($addArr['msg'],$addArr['errcode'],$addArr['layertype'],'index.php?c=admin_comjob',2,1);
			}
    	}else{
			$this->layer_msg("请选择您要删除的信息！",8);
    	}
	}
	function xuanshang_action(){
		$id		=   trim($_POST['pid']);
        $data   =   array(       
            'top'   =>  intval($_POST['s']),
            'days'  =>  intval($_POST['xsdays'])   
        );
        $JobM   =   $this -> MODEL('job'); 
        $return =	$JobM -> addTopJob($id, $data);
	    $this->layer_msg($return['msg'],2);	
	}
}
?>