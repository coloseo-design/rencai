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
class admin_sync_controller extends adminCommon{
	function index_action(){
	    //查询可同步有效用户数据
	    $resumeM		=	$this -> MODEL('resume');
	    $resumeCount	=	$resumeM -> getExpectNum(array('defaults'=>1,'status'=>1,'r_status'=>1));
	    $jobM			=	$this -> MODEL('job');
	    $jobCount		=	$jobM -> getJobNum(array('state'=>1,'r_status'=>1,'status'=>0));
	    $this->yunset("resCount",$resumeCount);
	    $this->yunset("jobCount",$jobCount);
	    $this->yunset('syncsign',time().rand(1000,9999));
		$this->yuntpl(array('admin/admin_sync'));
	}
	function save_action(){
 		if($_POST['config']){
		    unset($_POST['config']);
			
		    $this -> MODEL('config') -> setConfig($_POST);
			
			$this->web_config();
			
			$this->ACT_layer_msg("数据同步设置修改成功！",9,1,2,1);
		}
	}
	
	//用户同步传输
	function resume_action(){
	    if (!$this->config['yptuser'] && !$this->config['yptkey']){
	        $this->layer_msg('请先设置云平台同步账号信息',8);
	    }
	    if($_POST['count'] && $_POST['limit']){
	        $page = ceil($_POST['count']/$_POST['limit']);
	        if(!$_POST['page']){
	            $_POST['page'] = 0;
	        }
	        //$_POST['limit'] = 1;
	        $pageSize	=	intval($_POST['page'])*intval($_POST['limit']);
	        //查询符合条件的数据
	        $resumeM	=	$this -> MODEL('resume');
	        $expectAll	=	$resumeM -> getSimpleList(array('defaults'=>1,'status'=>1,'r_status'=>1,'limit'=>array($pageSize,$_POST['limit']),'orderby'=>'id,desc'));
	        //清除用户UID
	        if(is_array($expectAll)){
	            foreach($expectAll as $key=>$value){
	                $uid[]	= $value['uid'];
	                $exceptList[$value['uid']] = $value;
	                $expectid[] = $value['id'];
	                
	            }
	            $uids = array_unique($uid);
	            //查询关联企业信息
				$rwhere['uid']	=	array('in',pylode(',',$uids));
				
	            $resumeList		=	$resumeM->getResumeList($rwhere);
				
	            $where['eid']	=	array('in',pylode(',',$expectid));
				
	            //查询关联工作经历
	            $workList		=	$resumeM -> getResumeWorks($where);
	            //教育经历
	            $eduList		=	$resumeM -> getResumeEdus($where);
	            //培训经历
	            $trainList		=	$resumeM -> getResumeTrains($where);
	            //职业技能
	            $skillList		=	$resumeM -> getResumeSkills($where);
	            //项目经历
	            $projectList	=	$resumeM -> getResumeProjects($where);
	            //其他
	            $otherList		=	$resumeM -> getResumeOthers($where);
	        }
	        
	        if(is_array($resumeList)){
	            include PLUS_PATH."/job.cache.php";
	            include PLUS_PATH."/user.cache.php";
	            include PLUS_PATH."/city.cache.php";
	            
	            $cacheM=$this->MODEL('cache');
	            $cacheList=$cacheM->GetCache('user');

	            foreach($resumeList as $key=>$value){
	                $jsonvalue = array();
	                $jsonvalue['uid'] 			=	$value['uid'];//原始UID
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
	                $exceptValue				=	$exceptList[$value['uid']];
	                $resumevalue				=	array();
	                $resumevalue['id']			=	$exceptValue['id'];
	                $resumevalue['name']		=	$exceptValue['name'];//简历名称
	                if($exceptValue['job_classid']){
	                    $jobclassid_name=array();
	                    foreach(@explode(',',$exceptValue['job_classid']) as $k=>$v){
	                        $jobclassid_name[]	=	$job_name[$v];
	                    }
	                    $resumevalue['job_classid'] = @implode(',',$classid_name);
	                }
	                if($exceptValue['city_classid']){
	                    $cityclassid_name=array();
	                    foreach(@explode(',',$exceptValue['city_classid']) as $k=>$v){
	                        $cityclassid_name[]	=	$city_name[$v];
	                    }
	                    $resumevalue['city_classid'] = @implode(',',$cityclassid_name);
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
	            $Crmjson['yptuser']		=	$this->config['yptuser'];
	            $Crmjson['yptkey']		=	$this->config['yptkey'];
	            $Crmjson['syncsign']	=	$_POST['syncsign'];
	            //CURL POST 数据
	            $url 		=	'http://api.ypt.com/sync/?c=resume';//接收地址
	            
	            $return		=	CurlPost($url,json_encode($Crmjson));
	            
	            $response	=	json_decode($return);
	            
	            if($response->state == '1'){
	                if($response->uids){
						$ewhere['id']	=	array('in',$response->uids);
	                    $resumeM -> upInfo($ewhere,array('eData'=>array('sync'=>'1')));
	                    $nowcount 		=	count(explode(',',$response->uids));
	                }
	                
	                if(($_POST['page']+1)>=$page){//转换结束
	                    echo json_encode(array('error'=>'2'));
	                }else{
	                    //当前批次结束 继续下一批次转换
	                    echo json_encode(array('error'=>'1','readynum'=>$response->readynum,'page'=>($_POST['page']+1),'count'=>($_POST['page']+1)*$_POST['limit']));
	                }
	                die;
	            }else{
	                echo json_encode(array('error'=>'0','msg'=>$response->errmsg));
	            }
	        }
	    }else{
	        echo json_encode(array('error'=>'0'));
	    }
	}
	function job_action(){
	    set_time_limit(0);
	    if($_POST['count'] && $_POST['limit']){
	        $page = ceil($_POST['count']/$_POST['limit']);
	        if(!$_POST['page']){
	            
	            $_POST['page'] = 0;
	        }
	        //$_POST['limit'] = 10;
	        $pageSize	=	intval($_POST['page'])*intval($_POST['limit']);
	        //查询符合条件的数据
	        $jobM		=	$this -> MODEL('job');
	        $joblist	=	$jobM -> getList(array('state'=>1,'r_status'=>1,'status'=>0,'limit'=>array($pageSize,$_POST['limit']),'orderby'=>'id,desc'));
			$jobAll=$joblist['list'];
	        //清除企业UID
	        if(is_array($jobAll)){
	            foreach($jobAll as $key=>$value){
	                $uid[] = $value['uid'];
	                $jobList[$value['uid']][] = $value;
	            }
	            $uids = array_unique($uid);
	            //查询关联企业信息
	            $comM			=	$this -> MODEL('company');
				$comwhere['uid']=	array('IN',pylode(',',$uids));
	            $comList		=	$comM -> getList($comwhere);
	            
	        }
	        if(is_array($comList)){
	            include PLUS_PATH."/job.cache.php";
	            include PLUS_PATH."/com.cache.php";
	            include PLUS_PATH."/city.cache.php";
	            include PLUS_PATH."/industry.cache.php";
	            $cacheM=$this->MODEL('cache');
	            $cacheList=$cacheM->GetCache('user');
	            foreach($comList as $key=>$value){
	                $jsonvalue = array();
	                $jsonvalue['uid']			=	$value['uid'];//原始UID
	                $jsonvalue['name']			=	$value['name'];//企业名称
	                $jsonvalue['hy']			=	$industry_name[$value['hy']];//企业行业
	                $jsonvalue['comnum']		=	$comclass_name[$value['mun']];//企业规模
	                $jsonvalue['province']		=	$city_name[$value['provinceid']];//所在地区
	                $jsonvalue['city']			=	$city_name[$value['cityid']];//所在地区
	                $jsonvalue['three_city']	=	$city_name[$value['three_cityid']];//所在地区
	                $jsonvalue['address']		=	$value['address'];
	                $jsonvalue['website']		=	$value['website'];//企业网址
	                $jsonvalue['sdate']			=	$value['sdate'];//企业注册日期
	                $jsonvalue['linkman']		=	$value['linkman'];//联系人
	                $jsonvalue['content']		=	$value['content'];//联系人
	                $jsonvalue['x']				=	$value['x'];//企业地图标注
	                $jsonvalue['y']				=	$value['y'];//企业地图标注
	                $jsonvalue['bustops']		=	$value['bustops'];//公交路线
	                $jsonvalue['linktel']		=	$value['linktel'];//联系电话
	                $jsonvalue['linkphone']		=	$value['linkphone'];//固定电话
	                $jsonvalue['linkmail']		=	$value['linkmail'];//联系邮件
	                $jsonvalue['welfare']		=	$value['welfare'];//福利待遇
	                //企业职位
	                if(is_array($jobList[$value['uid']])){
	                    foreach($jobList[$value['uid']] as $k=>$v){
	                        $jobvalue					=	array();
	                        $jobvalue['id']				=	$v['id'];
	                        $jobvalue['name']			=	$v['name'];//职位名称
	                        
	                        $jobvalue['job1']			=	$job_name[$v['job1']];
	                        $jobvalue['job1_son']		=	$job_name[$v['job1_son']];
	                        $jobvalue['job_post']		=	$job_name[$v['job_post']];
	                        $jobvalue['province']		=	$city_name[$v['provinceid']];//所在地区
	                        $jobvalue['cityid']			=	$city_name[$v['cityid']];//所在地区
	                        $jobvalue['three_cityid']	=	$city_name[$v['three_cityid']];//所在地区
	                        
	                        $jobvalue['salary']			=	$v['minsalary'].'-'.$v['maxsalary'];//薪资待遇
	                        $jobvalue['number']			=	$comclass_name[$v['number']];//类型
	                        $jobvalue['exp']			=	$comclass_name[$v['exp']];//工作经验
	                        $jobvalue['report']			=	$comclass_name[$v['report']];//到岗时间
	                        $jobvalue['sex']			=	$cacheList['user_sex'][$v['sex']];//性别
	                        $jobvalue['edu']			=	$comclass_name[$v['edu']];//学历
	                        $jobvalue['marriage']		=	$comclass_name[$v['marriage']];//婚姻
	                        $jobvalue['description']	=	$v['description'];//岗位要求
	                        $jobvalue['sdate']			=	$v['sdate'];//发布日期
	                        $jobvalue['lastupdate']		=	$v['lastupdate'];//发布日期
	                        if($v['lang']){
	                            $langList				=	array();
	                            $lang					=	@explode(',',$v['lang']);
	                            foreach($lang as $lv){
	                                $langList[]			=	$comclass_name[$lv];
	                            }
	                            $jobvalue['lang']		=	@implode(',',$langList);//语言要求
	                        }
	                        $jsonvalue['joblist'][]		=	$jobvalue;
	                    }
	                }
	                $Arr[] = $jsonvalue;
	            }
	            //转化JSON
	            $Crmjson['syncjson']	=	$Arr;
	            $Crmjson['yptuser']		=	$this->config['yptuser'];
	            $Crmjson['yptkey']		=	$this->config['yptkey'];
	            $Crmjson['syncsign']	=	$_POST['syncsign'];
	            //CURL POST 数据
	            $url		=	'http://api.ypt.com/sync/?c=job';//接收地址
	            
	            $return		=	CurlPost($url,json_encode($Crmjson));
	            
	            $response	=	json_decode($return);
	            
	            if($response->state == '1'){
	                if($response->uids){
	                    $jobM -> upInfo(array('sync'=>'1'), array('uid' => array('in', $response->uids)));
	                    $nowcount = count(explode(',',$response->uids));
	                }
	                
	                if(($_POST['page']+1)>=$page){//转换结束
	                    echo json_encode(array('error'=>'2'));
	                }else{
	                    //当前批次结束 继续下一批次转换
	                    echo json_encode(array('error'=>'1','readynum'=>$response->readynum,'page'=>($_POST['page']+1),'count'=>($_POST['page']+1)*$_POST['limit']));
	                }
	                die;
	            }else{
	                echo json_encode(array('error'=>'0','msg'=>$response->errmsg));
	            }
	        }
	    }else{
	        echo json_encode(array('error'=>'0'));
	    }
	}
	function getList($table,$expectid){
	    $List = $this->MODEL('resume')->getFbList($table,array('eid'=>array('in',pylode(',',$expectid))));
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