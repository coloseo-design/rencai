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
class admin_resume_controller extends adminCommon{
	function index_action(){  
	    $resumeM    =   $this -> MODEL('resume');
		if(trim($_GET['keyword'])){
			$where['name']		=	array('like',trim($_GET['keyword']));
			$urlarr['keyword']	=	$_GET['keyword'];
		}
		if($_GET['status']){
			$status				=	intval($_GET['status']);
			if($status==2){
				$where['r_status']	=	2;
			}else{
				$where['state']	=	$status == 4 ? 0 : $status;
			}
			$urlarr['status']	=	$status;
		}
		$urlarr['c']	=	$_GET['c'];
		$urlarr['page']	=	"{{page}}";
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');
		$pageM	=	$this  -> MODEL('page');
		$pages	=	$pageM -> pageList('resume_expect',$where,$pageurl,$_GET['page']);
	    if($pages['total'] > 0){
			$where['orderby']	=	'lastupdate';
			$where['limit']		=	$pages['limit'];
			$rows				=	$resumeM -> getList($where);
		}
		$CacheM=$this->MODEL('cache');
		$CacheList=$CacheM->GetCache(array('city','job','user'));
        $this->yunset($CacheList);
		extract($CacheList);
		if(is_array($rows)){
			foreach($rows['list'] as $k=>$v){			   
				$city_classid=@explode(",",$v['city_classid']);
				$city_class_name=array();
				if(is_array($city_classid)){
				    $i=0;
				    foreach($city_classid as $key=>$val){
				        if($city_name[$val]){
				            $cityname[$key]=$val;
				            if($val!=""){
				                $i=$i+1;
				            }
				            $city_class_name[]=$city_name[$val];
				        }
				    }
				    $rows['list'][$k]['citynum']=$i;
				    $rows['list'][$k]['cityid_n']=$city_name[$cityname[0]];
				}

				$job_classid=@explode(",",$v['job_classid']);
				$job_class_name=array();
				if(is_array($job_classid)){
					$i=0;
					foreach($job_classid as $key=>$val){
						$jobname[$key]=$val;
						if($val!=""){
							$i=$i+1;
						}
						$job_class_name[]=$job_name[$val];
					}
					$rows['list'][$k]['jobnum']=$i;
					$rows['list'][$k]['job_post_n']=$job_name[$jobname[0]];
				}				
				$rows['list'][$k]['job_class_name']=@implode('、',$job_class_name);
			}
		}
		$this -> yunset('rows',$rows['list']);
		$this->yunset("headertitle","简历管理");
		$this->yunset('backurl','index.php?c=user');
		$this->yuntpl(array('wapadmin/admin_resume'));
	}
	function saveresume_action(){
		$ResumeM	=	$this->MODEL('resume');
		if($_GET['e']){
			$eid	=	(int)$_GET['e'];
			$return	=	$ResumeM->getInfo(array('eid'=>$eid,'uid'=>$_GET['uid'],'tb'=>'all','needCache'=>1));
			$setarr =	array(
		    'row'             =>   $return['expect'],
		    'edu'             =>   $return['edu'],
		    'other'           =>   $return['other'],
		    'project'         =>   $return['project'],
		    'skill'           =>   $return['skill'],
		    'training'        =>   $return['training'],
		    'work'            =>   $return['work'],
			'resume'          =>   $return['resume'],
		    'industry_index'  =>   $return['cache']['industry_index'],
		    'industry_name'   =>   $return['cache']['industry_name'],
		    'userdata'        =>   $return['cache']['userdata'],
		    'userclass_name'  =>   $return['cache']['userclass_name'],
			);
			$this->yunset($setarr);
		}
		$this->yunset($this->MODEL('cache')->GetCache(array('job','city','user')));
		$this->yunset("uid",$_GET['uid']);
		$this->yunset("eid",$_GET['e']);
		if($_GET['return_url']){
			$this->yunset("return_url",'myresume');
		}else{
			$this->yunset("return_url",'resume');
		}				
		$this->yunset("headertitle","简历管理");
		$this->yunset('backurl','index.php?c=admin_resume');
		$this->yuntpl(array('wapadmin/admin_saveresume'));
	}
	function saveinfo_action(){
		$resumeM	=	$this->MODEL('resume');
		$uid   		=  intval($_POST['uid']);
	    $rData  	=  array(
	        'name'         => 	 $_POST['name'],
	        'sex'          =>  	$_POST['sex'],
	        'edu'          =>  	$_POST['edu'],
	        'living'       =>  	$_POST['living'],
	        'exp'          =>  	$_POST['exp'],
	        'birthday'     =>  	$_POST['birthday'],
	        'telphone'     =>  	$_POST['telphone'],
	        'telhome'     =>  	$_POST['telhome'],
	        'email'        =>  	$_POST['email'],
	    );    
	    $return   =  $resumeM -> upResumeInfo(array('uid'=>$uid),array('rData'=>$rData));
		if($return['errcode']==9){
			$arr	=	$resumeM -> getResumeInfo(array('uid'=>$uid));
		 	echo json_encode($arr);die;
		}else{
			echo 0;die;
		}	
	}
	function saveexpect_action(){
		$resumeM	=	$this->MODEL('resume');
		if($_POST['submit']){
			$eid	=	intval($_POST['eid']);
	        $uid	=	intval($_POST['uid']);
			if($eid){
				$expectDate	=	array(
					'name'			=>	$_POST['name'],
					"hy"			=>	$_POST['hy'],
					"job_classid"	=>	$_POST['job_classid'],
					"minsalary"		=>	$_POST['minsalary'],
					"maxsalary"		=>	$_POST['maxsalary'],
					"city_classid"	=>	$_POST['city_classid'],
					"report"		=>	$_POST['report'],
					"type"			=>	$_POST['type'],
					"jobstatus"		=>	$_POST['jobstatus'],
					"lastupdate"	=>	time(),
				);
			}
			$return   =  $resumeM -> upInfo(array('id'=>$eid), array('eData'=>$expectDate,'utype'=>'admin'));
			if($return['id']){
				$arr  =  $resumeM -> getExpect(array('id'=>$eid),array('needCache'=>1));	
				echo json_encode($arr);die;
			}else{
				echo 0;die;
			}
		}
	}
	function skill_action(){
		$resumeM    =   $this -> MODEL('resume');
		if($_POST['submit']){
			$id    		=   intval($_POST['id']);
			if($_FILES['pic']['tmp_name']){
				$upArr    =  array(
					'file'  	=>  $_FILES['pic'],
					'dir'   	=>  'user',	
				);
				$uploadM	=  $this -> MODEL('upload');
				$pic		=  $uploadM -> newUpload($upArr);
				if (!empty($pic['msg'])){
					$this->ACT_layer_msg($pic['msg'],8);
				}elseif (!empty($pic['picurl'])){
					$pictures	=	$pic['picurl'];
				}
			}
			if(isset($pictures)){
				$_POST['pic']	=	$pictures;
			}
			$postData	=	array(
				'uid'		=>	intval($_POST['uid']),
				'eid'		=>	intval($_POST['eid']),
				'name'		=>	$_POST['name'],
				'longtime'	=>	$_POST['longtime'],
				'ing'		=>	$_POST['user_ing_name'],
				'pic'		=>	$_POST['pic'],
			);
			if(intval($_POST['id'])){
				$row	=	$resumeM -> getResumeSkill(array(id=>$_POST['id']));
				if($row['pic'] && $_POST['pic']==''){
					$postData['pic']	=	$row['pic'];
				}
				$return	 =	$resumeM -> addResumeSkill($postData,array('where'=>array('id'=>intval($_POST['id'])),'utype'=>'admin'));
			}else{
				$return  =  $resumeM -> addResumeSkill($postData,array('utype'=>'admin'));
				$id      =  $return['id'];
			}
			$skill	=	$resumeM -> getResumeSkill(array('id'=>$id));
			$data['msg']=$return['msg'];
			$data['url']='index.php?c=admin_resume&a=saveresume&uid='.$_POST['uid'].'&e='.$_POST['eid'].'';
			$this->yunset("layer",$data);
		}
		$this->yuntpl(array('wapadmin/admin_saveresume'));
	}
	function work_action(){
		$resumeM    =   $this -> MODEL('resume');
		$id    		=   intval($_POST['id']);
		$postData	=	array(
			'uid'		=>	intval($_POST['uid']),
			'eid'		=>	intval($_POST['eid']),
			'name'		=>  $_POST['name'],
			'sdate'		=>	strtotime($_POST['sdate']),
	        'edate'		=>  strtotime($_POST['edate']),
			'title'		=>  $_POST['title'],
			'content'	=>	trim($_POST['content'])
		);
		if(intval($_POST['id'])){
			$return	 =	$resumeM -> addResumeWork($postData,array('where'=>array('id'=>intval($_POST['id'])),'utype'=>'admin'));
		}else{
			$return  =  $resumeM -> addResumeWork($postData,array('utype'=>'admin'));
			$id      =  $return['id'];
		}
		$work	=	$resumeM -> getResumeWork(array('id'=>$id));
		echo json_encode($work);die;
	}
	function project_action(){
		$resumeM    =   $this -> MODEL('resume');
		$id    		=   intval($_POST['id']);
		$postData	=	array(
			'uid'		=>	intval($_POST['uid']),
			'eid'		=>	intval($_POST['eid']),
			'name'		=>  $_POST['name'],
			'sdate'		=>	strtotime($_POST['sdate']),
	        'edate'		=>  strtotime($_POST['edate']),
			'title'		=>  $_POST['title'],
			'content'	=>	trim($_POST['content'])
		);
		if(intval($_POST['id'])){
			$return	 =	$resumeM -> addResumeProject($postData,array('where'=>array('id'=>intval($_POST['id'])),'utype'=>'admin'));
		}else{
			$return  =  $resumeM -> addResumeProject($postData,array('utype'=>'admin'));
			$id      =  $return['id'];
		}
		$project	 =	$resumeM -> getResumeProject(array('id'=>$id));
		echo json_encode($project);die;
	}
	function edu_action(){
		$resumeM    =   $this -> MODEL('resume');
		$id    		=   intval($_POST['id']);
		$postData	=	array(
			'uid'		=>	intval($_POST['uid']),
			'eid'		=>	intval($_POST['eid']),
			'name'		=>  $_POST['name'],
			'sdate'		=>	strtotime($_POST['sdate']),
	        'edate'		=>  strtotime($_POST['edate']),
			'title'		=>  $_POST['title'],
			'education'	=>	$_POST['education'],
	        'specialty' =>  $_POST['specialty'],
		);
		if(intval($_POST['id'])){
			$return	 =	$resumeM -> addResumeEdu($postData,array('where'=>array('id'=>intval($_POST['id'])),'utype'=>'admin'));
		}else{
			$return  =  $resumeM -> addResumeEdu($postData,array('utype'=>'admin'));
			$id      =  $return['id'];
		}
		$edu	=	$resumeM -> getResumeEdu(array('id'=>$id));
		echo json_encode($edu);die;
	}
	function training_action(){
		$resumeM    =   $this -> MODEL('resume');
		$id    		=   intval($_POST['id']);
		$postData	=	array(
			'uid'		=>	intval($_POST['uid']),
			'eid'		=>	intval($_POST['eid']),
			'name'		=>  $_POST['name'],
			'sdate'		=>	strtotime($_POST['sdate']),
	        'edate'		=>  strtotime($_POST['edate']),
			'title'		=>  $_POST['title'],
			'content'	=>	trim($_POST['content'])
		);
		if(intval($_POST['id'])){
			$return	 =	$resumeM -> addResumeTrain($postData,array('where'=>array('id'=>intval($_POST['id'])),'utype'=>'admin'));
		}else{
			$return  =  $resumeM -> addResumeTrain($postData,array('utype'=>'admin'));
			$id      =  $return['id'];
		}
		$train	=	$resumeM -> getResumeTrain(array('id'=>$id));
		echo json_encode($train);die;
	}
	function other_action()
	{
		$resumeM    =   $this -> MODEL('resume');
		$id    		=   intval($_POST['id']);
		$postData	=	array(
			'uid'		=>	intval($_POST['uid']),
			'eid'		=>	intval($_POST['eid']),
			'name'		=>  $_POST['name'],
			'content'	=>	trim($_POST['content'])
		);
		if(intval($_POST['id'])){
			$return	 =	$resumeM -> addResumeOther($postData,array('where'=>array('id'=>intval($_POST['id'])),'utype'=>'admin'));
		}else{
			$return  =  $resumeM -> addResumeOther($postData,array('utype'=>'admin'));
			$id      =  $return['id'];
		}
		$other	=	$resumeM -> getResumeOther(array('id'=>$id));
		echo json_encode($other);die;
	}
	
	function evalute_action(){
		$resumeM   =   $this -> MODEL('resume');
		if($_POST["submit"]){	
			$eid	=	(int)$_POST['eid'];
			$id		=	(int)$_POST['id'];
			$uid	=	$_POST['uid'];					
			if(!$id){					   		
				$nid	=	$resumeM -> upResumeInfo(array('uid'=>$uid),array('rData'=>array('description'=>$_POST['evalute_content'])));
				if($nid){		   				   
					$data['msg']="自我评价添加成功！";
					$data['url']='index.php?c=admin_resume&a=saveresume&uid='.$uid.'&e='.$eid.'';
					$this->yunset("layer",$data);
				}else{
					$data['msg']="自我评价添加失败！";
					$data['url']='index.php?c=admin_resume&a=saveresume&uid='.$uid.'&e='.$eid.'';
					$this->yunset("layer",$data);				       
				}		
			}   								
		}
		$this->yuntpl(array('wapadmin/admin_saveresume'));
	}
	function resume_ajax_action(){
		$resumeM   =   $this -> MODEL('resume');
	    $id    	   =   intval($_POST['id']);
	    $table 	   =   'resume_'.$_POST['type'];
	    $info      =   $resumeM -> getFb($table,$id);
	    echo json_encode($info);die;
	}
	function resume_del_action(){
		$resumeM  =  $this -> MODEL('resume');
		$table    =  trim($_GET['type']);
		$tables   =  array('skill','work','project','edu','training','other');
		if(in_array($table,$tables)){   
	        $id       =  (int)$_GET['id'];  
	        $eid      =  (int)$_GET['e'];
	        $return   =  $resumeM -> delFb($table,array('id'=>$id,'eid'=>$eid));
	        $return?$this->layer_msg('删除成功！',9):$this->layer_msg('删除失败！',8);
	    }		
	}
	function logout_action(){
		$this->adminlogout();
		$this->layer_msg("您已成功退出！",9,0,"index.php");
	}

	function status_action(){//简历审核
		$resumeM   =   $this -> MODEL('resume');
		$postData      =   array(
	        'state'        =>  intval($_POST['status']),
	        'statusbody'   =>  trim($_POST['statusbody'])
	    );
		$return  =  $resumeM -> statusResume($_POST['id'],array('post'=>$postData));
		if ($_POST['lasturl']!=''){
	        $lasturl	=	$this->post_trim($_POST['lasturl']);
	    }else{
	        $lasturl	=	$_SERVER['HTTP_REFERER'];
	    }
	    if($return){
	        $this->layer_msg('操作(ID:'.$_POST['id'].')设置成功！',9,0,$lasturl);
	    }else{
	        $this->layer_msg('设置失败！',8);
	    }
	}
}
?>