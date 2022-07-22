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
class admin_sync_resume_controller extends adminCommon{
	//设置高级搜索功能
	function set_search(){
        include(CONFIG_PATH."db.data.php");
        $source=$arr_data['source'];
        $this->yunset('source',$source);
		$uptime=array('30'=>'一个月','60'=>'两个月','90'=>'三个月');
		$datetime=array('30'=>'一个月','60'=>'两个月','90'=>'三个月');
		$search_list[]=array("param"=>"uptime","name"=>'更新时间',"value"=>$uptime);
		$search_list[]=array("param"=>"datetime","name"=>'最新投递',"value"=>$datetime);
		$this->yunset("search_list",$search_list);
	}
	
	function index_action(){
		$this->set_search();
		
		if($_GET['sync']){
		    $where['sync']	=	intval($_GET['sync']);
		    $urlarr['sync']	=	$_GET['sync'];
		}else{
		    $where['sync']	=	'1';
		}
        if(trim($_GET['keyword'])){
			if($_GET['keytype']=="1"){
				$where['name']	=	array('like',trim($_GET['keyword']));
			}elseif($_GET['keytype']=="2"){
				$where['uname']	=	array('like',trim($_GET['keyword']));
		    }elseif($_GET['keytype']=="3"){
				$where['id']	=	trim($_GET['keyword']);
		    }
			$urlarr['keyword']	=	$_GET['keyword'];
			$urlarr['keytype']	=	$_GET['keytype'];
		}

		if($_GET['uptime']){
			$where['lastupdate']	=	array('>',strtotime('-'.intval($_GET['uptime']).' day'));
			$urlarr['uptime']		=	$_GET['uptime'];
		}else{
			$where['lastupdate']	=	array('>',strtotime('-90 day'));
		}

		if($_GET['edu']){
			if(is_array($_GET['edu'])){
    			$where['edu']	=	array('in',pylode(',',$_GET['edu']));
    			$urlarr['edu']	=	pylode(',',$_GET['edu']);
			}else{
    			$where['edu']	=	$_GET['edu'];
    			$urlarr['edu']	=	$_GET['edu'];
			}
		}
	
		if($_GET['exp']){
			if(is_array($_GET['exp'])){
    			$where['exp']	=	array('in',pylode(',',$_GET['exp']));
    			$urlarr['exp']	=	pylode(',',$_GET['exp']);
			}else{
    			$where['exp']	=	$_GET['exp'];
    			$urlarr['exp']	=	$_GET['exp'];
			}
		}
		//用于查询两个月之内登录的uid
		$jobM		=	$this->MODEL('job');
		$resumeM	=	$this->MODEL('resume');
		$userinfoM	=	$this->MODEL('userinfo');
		$mlogin		=	$userinfoM->getList(array('login_date'=>array('>',strtotime('-60 day')),'usertype'=>1),array('field'=>"`uid`"));
		if ($mlogin && is_array($mlogin)){
		    foreach($mlogin as $key=>$value){
		        $mloginids[]=	$value['uid'];
		    }
		    //最新投递
		    if($_GET['datetime']){
		        $datetime	=	strtotime('-'.intval($_GET['datetime']).' day');
		    }else{
		        $datetime	=	strtotime('-90 day');
		    }
		    $userid	=	$jobM->getSqJobList(array('uid'=>array('in',pylode(',',$mloginids)),'datetime'=>array('>',$datetime)),array('field'=>"`uid`"));
		    $urlarr['datetime']	=	$_GET['datetime']?$_GET['datetime']:90;
		    if ($userid && is_array($userid)){
		        foreach($userid as $key=>$value){
		            $mids[]		=	$value['uid'];
		        }
		        $where['uid']	=	array('in',pylode(',',$mids));
		    }else{
		        $where['uid']	=	array('in',pylode(',',$mloginids));
		    }
			$where['orderby']	=	'id,desc';
			$urlarr        	=   $_GET;
		    $urlarr['page']	=	"{{page}}";
		    $pageurl		=	Url($_GET['m'],$urlarr,'admin');
			$pageM			=	$this  -> MODEL('page');
			$pages			=	$pageM -> pageList('resume_expect',$where,$pageurl,$_GET['page']);
			if($pages['total'] > 0){
				$where['limit']	=	$pages['limit'];
				$rows	=	$resumeM->getList($where,array('cache'=>'1','utype'=>'admin'));
				unset($where['limit']);
				session_start();
				$_SESSION['syncResume'] = $where;
			}
		}
	    $this->yunset($this->MODEL('cache')->GetCache(array('user')));
		$this->yunset(array('get_type'=>$_GET,'rows'=>$rows['list']));
		$this->yunset('syncsign',time().rand(1000,9999));
		$this->yuntpl(array('admin/admin_sync_resume'));
	}
	function resumeNum_action(){
	    $where['sync']			=	$_POST['sync'];
	    $where['lastupdate']	=	array('>',strtotime('-90 day'));
		$userinfoM	=	$this->MODEL('userinfo');
	    $mlogin		=	$userinfoM->getList(array('login_date'=>array('>',strtotime('-60 day')),'usertype'=>1),array('field'=>"`uid`"));
	    if ($mlogin && is_array($mlogin)){
	        foreach($mlogin as $key=>$value){
	            $mloginids[] = $value['uid'];
	        }
			$jobM	=	$this->MODEL('job');
	        $userid =	$jobM->getSqJobList(array('uid'=>array('in',pylode(',',$mloginids)),'datetime'=>array('>',strtotime('-90 day'))),array('field'=>"`uid`"));
	        if ($userid && is_array($userid)){
	            foreach($userid as $key=>$value){
	                $mids[] = $value['uid'];
	            }
	            $where['uid']	=	array('in',pylode(',',$mids));
	        }else{
	            $where['uid']	=	array('in',pylode(',',$mloginids));
	        }
			$resumeM	=	$this->MODEL('resume');
	        $num		= 	$resumeM->getExpectNum($where);
	        echo json_encode(array('num'=>$num));
	    }else{
	        echo json_encode(array('num'=>0));
	    }
	}
	//用户同步传输
	function resume_action(){
	    if (!$this->config['yptappid'] && !$this->config['yptsecret']){
	        $this->layer_msg('请先配置云平台同步秘钥',8);
	    }
	    if($_POST['count'] && $_POST['limit']){
	        $limit=intval($_POST['limit']);
	        $count=intval($_POST['count']);
	        $page=$_POST['page'];
	        if(!$page){
	            $page = 0;
	        }
	        if ($limit>100){
	            $this->layer_msg('同步基数不能超过100',8);
	        }
	        if($count<$limit){
	            $limit=$count;
	        }
	        $pageSize = $page*$limit;
	        //查询符合条件的数据
	        $resumeM = $this->MODEL('resume');
	        session_start();
	        if ($_SESSION['syncResume']){
	            //$where=str_replace(array('[',']','an d','lastＵpdate',"\&acute;","\\"),array('(',')','and','lastupdate',"'",""),$_POST['where']);
	            $where	=	$_SESSION['syncResume'] ? $_SESSION['syncResume'] : array('orderby'=>'id');
				$where['limit']	=	$pageSize.','.$limit;
	            $expectAll		=	$resumeM->getSimpleList($where);
	        }else{
	            $this->layer_msg('系统正忙',8);
	        }
	        //清除用户UID
	        if(is_array($expectAll)){
	            foreach($expectAll as $key=>$value){
	                $uid[] = $value['uid'];
	                $exceptList[$value['uid']] = $value;
	                $expectid[] = $value['id'];  
	            }
	            $uids = array_unique($uid);
	            //查询关联企业信息
	            $resumeList		=	$resumeM->getResumeList(array('uid'=>array('in',pylode(',',$uids))));
	            
	            //查询关联工作经历
	            $workList		=	$this->getList('resume_work',$expectid);
	            //教育经历
	            $eduList		=	$this->getList('resume_edu',$expectid);
	            //培训经历
	            $trainList		=	$this->getList('resume_train',$expectid);
	            //职业技能
	            $skillList		=	$this->getList('resume_skill',$expectid);
	            //项目经历
	            $projectList	=	$this->getList('resume_project',$expectid);
	            //其他
	            $otherList		=	$this->getList('resume_other',$expectid);
	        }
	        
	        if(is_array($resumeList)){
	            include PLUS_PATH."/job.cache.php";
	            include PLUS_PATH."/user.cache.php";
	            include PLUS_PATH."/city.cache.php";
	            $cacheM=$this->MODEL('cache');
	            $cacheList=$cacheM->GetCache('user');
	            $this->yunset("arr_data",$cacheList);
	            foreach($resumeList as $key=>$value){
	                $jsonvalue = array();
	                $jsonvalue['sync']			=	$value['sync'];//原始UID
	                $jsonvalue['uid']			=	$value['uid'];//原始UID
	                $jsonvalue['uname']			=	$value['name'];//用户姓名
	                $jsonvalue['address']		=	$value['address'];//现居住地址
	                $jsonvalue['birthday']		=	$value['birthday'];//生日
	                $jsonvalue['height']		=	$value['height'];//身高
	                $jsonvalue['weight']		=	$value['weight'];//体重
	                $jsonvalue['idcard']		=	$value['idcard'];//身份证
	                $jsonvalue['nationality']	=	$value['nationality'];//民族
	                $jsonvalue['description']	=	$value['description'];//个人简介
	                $jsonvalue['living']		=	$value['living'];//现居住地
	                $jsonvalue['domicile']		=	$value['domicile'];//户籍地址
	                $jsonvalue['telphone']		=	$value['telphone'];//联系电话
	                $jsonvalue['telhome']		=	$value['telhome'];//家庭电话
	                $jsonvalue['email']			=	$value['email'];//联系邮件
	                $jsonvalue['homepage']		=	$value['homepage'];//个人主页
	                $jsonvalue['sex']			=	$cacheList['user_sex'][$value['sex']];//性别
	                $jsonvalue['marriage']		=	$userclass_name[$value['marriage']];//婚姻
	                $jsonvalue['edu']			=	$userclass_name[$value['edu']];//学历
	                $jsonvalue['exp']			=	$userclass_name[$value['exp']];//工作经验
	                
	                /****************************求职意向*******************************/
	                $exceptValue	=	$exceptList[$value['uid']];
	                $resumevalue	=	array();
	                $resumevalue['id']		=	$exceptValue['id'];
	                $resumevalue['name']	=	$exceptValue['name'];//简历名称
	                if($exceptValue['job_classid']){
	                    $jobclassid_name=array();
	                    foreach(@explode(',',$exceptValue['job_classid']) as $k=>$v){
	                        $jobclassid_name[]		=	$job_name[$v];
	                    }
	                    $resumevalue['job_classid'] =	@implode(',',$classid_name);
	                }
	                if($exceptValue['city_classid']){
	                    $cityclassid_name=array();
	                    foreach(@explode(',',$exceptValue['city_classid']) as $k=>$v){
	                        $cityclassid_name[]		=	$city_name[$v];
	                    }
	                    $resumevalue['city_classid']=	@implode(',',$cityclassid_name);
	                }
	                if ($exceptValue['minsalary']>0 || $exceptValue['maxsalary']>0){
	                    $resumevalue['salary']	=	$exceptValue['minsalary'].'-'.$exceptValue['maxsalary'];//薪资待遇
	                }
	                $resumevalue['jobstatus']	=	$userclass_name[$exceptValue['jobstatus']];//求职状态
	                $resumevalue['type']		=	$userclass_name[$exceptValue['type']];//工作性质
	                $resumevalue['exp']			=	$userclass_name[$exceptValue['exp']];//工作经验
	                $resumevalue['edu']			=	$userclass_name[$exceptValue['edu']];//最高学历
	                $resumevalue['report']		=	$userclass_name[$exceptValue['report']];//到岗时间
	                $resumevalue['lastupdate']	=	$exceptValue['lastupdate'];//更新日期
	                $jsonvalue['expect']		=	$resumevalue;
	                
	                
	                /*************************************工作经历**************************************/
	                $jsonvalue['worklist']		=	$workList[$exceptValue['id']];
	                $jsonvalue['edulist']		=	$eduList[$exceptValue['id']];
	                $jsonvalue['projectlist']	=	$projectList[$exceptValue['id']];
	                $jsonvalue['otherlist']		=	$otherList[$exceptValue['id']];
	                $jsonvalue['trainlist']		=	$trainList[$exceptValue['id']];
	                
	                $Arr[] = $jsonvalue;
	            }
	            //转化JSON
	            $Crmjson['syncjson']	=	$Arr;
	            $Crmjson['appid']		=	$this->config['yptappid'];
	            $Crmjson['secret']		=	$this->config['yptsecret'];
	            $Crmjson['syncsign']	=	$_POST['syncsign'];
	            //CURL POST 数据
	            $url = 'http://api.ypt.com/sync/';//接收地址
	            if ($_POST['sync']==1){
	                $url.='?c=newresume';
	            }elseif ($_POST['sync']==2){
	                $url.='?c=oldresume';
	            }
	            
	            $return		=	CurlPost($url,json_encode($Crmjson));
	            
	            $response	=	json_decode($return);
	            if($response->state == '1'){
	                if($response->eids != ''){
	                    //已同步的简历，处理返回简历id
	                    $eids = @explode(',', $response->eids);
	                    $synceids = array();
	                    foreach ($eids as $v){
	                        if (is_numeric($v)){
	                            $synceids[]=$v;
	                        }
	                    }
	                    if (count($synceids)>0){
	                        $resumeM -> upInfo(array('id'=>array('in',pylode(',', $synceids))),array('eData'=>array('sync'=>'2')));
	                    }
	                }
	                
	                if(($_POST['page']+1)>=$page){//转换结束
	                    echo json_encode(array('error'=>'2'));
	                }else{
	                    //当前批次结束 继续下一批次转换
	                    echo json_encode(array('error'=>'1','reptelnum'=>$response->reptelnum,'page'=>($_POST['page']+1),'count'=>($_POST['page']+1)*$_POST['limit']));
	                }
	                die;
	            }else{
	                echo json_encode(array('error'=>'0','msg'=>$response->errmsg));die;
	            }
	        }
	    }else{
	        echo json_encode(array('error'=>'0'));die;
	    }
	}
	function getList($table,$expectid){
	    $resumeM	=	$this->MODEL('resume');
	    $List		=	$resumeM->getFbList($table,array('eid'=>array('in',pylode(',',$expectid))));
	    if(is_array($List)){
	        foreach($List as $key=>$value){
	            if(is_array($value)){
	                foreach($value as $k=>$v){
	                    $value[$k] = $v;
	                }
	            }
	            $newkList[$value['eid']][] = $value;
	        }
	    }
	    return $newkList;
	}
}
?>