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
class atn_model extends model{
	//获取简历信息列表resume_expect
    private function getResumeExpectList($whereData, $data = array()){
        
        require_once ('resume.model.php');
        
        $resumeM    =   new resume_model($this->db, $this->def);
        
        return  $resumeM   ->  getList($whereData , $data);
    }
	//获取简历信息列表resume
    private function getResumeList($whereData, $data = array()){
        
        require_once ('resume.model.php');
        
        $resumeM    =   new resume_model($this->db, $this->def);
        
        return  $resumeM   ->  getResumeList($whereData , $data);
    }
    /**
     * 设置简历头像展示
     */
    private function setResumePhotoShow($data = array()){
        require_once ('resume.model.php');

        $resumeM    =   new resume_model($this->db, $this->def);

        return  $resumeM   ->  setResumePhotoShow($data);
    }
	//获取职位信息列表company_job
    private function getJobList($whereData, $data = array()){
        
        require_once ('job.model.php');
        
        $jobM    =   new job_model($this->db, $this->def);
        
        return  $jobM   ->  getList($whereData , $data);
    }
	//获取职位信息列表company
    private function getComList($whereData, $data = array()){
        
        require_once ('company.model.php');
        
        $companyM    =   new company_model($this->db, $this->def);
        
        return  $companyM   ->  getList($whereData , $data);
    }
	//获取职位信息列表school_academy
    private function getSchoolAcademyList($whereData, $data = array()){
        
        require_once ('school.model.php');
        
        $schoolM    =   new school_model($this->db, $this->def);
        
        return  $schoolM   ->  getSchoolAcademyList($whereData , $data);
    }
	//获取职位信息列表school_xjh
    private function getSchoolXjhList($whereData, $data = array()){
        
        require_once ('school.model.php');
        
        $schoolM    =   new school_model($this->db, $this->def);
        
        return  $schoolM   ->  getSchoolXjhList($whereData , $data);
    }
	/**
     * @desc   引用log类，添加用户日志   
     */
    private function addMemberLog($uid,$usertype,$content,$opera='',$type='') {
        require_once ('log.model.php');
        $LogM = new log_model($this->db, $this->def);
        return  $LogM -> addMemberLog($uid,$usertype,$content,$opera='',$type=''); 
    }
    /**
     * 关注总数
    */
    public function getantnNum($whereData){
        return $this->select_num('atn',$whereData);
    }
     /**
      * 查询全部信息
      * @param 表：atn
      * @param 功能说明：获取atn表里面信息
      * @param 引用字段：$whereData：条件  2:$data:查询字段
      *
     */
    public function getatnList($whereData,$data=array()){
        $field              =   $data['field'] ? $data['field'] : '*';
        
        $atnlist            =   $this   ->  select_all('atn', $whereData, $field);
        
        foreach($atnlist as $k=>$v){
        	if($v['time']){
        		$atnlist[$k]['time_n']	=	date('Y-m-d',$v['time']);
        	}
        }
        if(is_array($atnlist) && $atnlist){
          if($data['utype']=='user'){
            //关注企业
            $atnlist	=	$this -> getAtnUserDataList($atnlist,$data);
            
          }
          if($data['utype']=='company'){
            //关注企业
            $atnlist	=	$this -> getAtnComDataList($atnlist,$data);
          }
          if($data['utype']=='lietou'){
            //关注猎头
            $atnlist	=	$this -> getAtnLtDataList($atnlist,$data);
          }
          if($data['utype']=='xjh'){
            //关注宣讲会
            $atnlist	=	$this -> getAtnXjhDataList($atnlist,$data);
          }
          if($data['utype']=='academy'){
            //关注宣讲会
            $atnlist	=	$this -> getAtnAcademyDataList($atnlist,$data);
          }
          if($data['utype']=='antagency'){
            //关注培训机构
            $atnlist	=	$this -> getAtnAgencyDataList($atnlist,$data);
          }
          
          if($data['utype']=='antteacher'){
            //关注培训讲师
            $atnlist	=	$this -> getAtnTeacherDataList($atnlist,$data);
          }
        }
		
        return $atnlist; 
    }
	/**
     * @desc    关注我的人才，查询school_academy相关数据
     *
     * @param   array $List
     */
    private function getAtnUserDataList($List,$data=array()) {
        $uids   =   array();
        foreach($List as $v){
			if($v['uid'] && !in_array($v['uid'],$uids)){
				$uids[]	=	$v['uid'];
			}
		}
		//  查询个人姓名
		$rWhere['uid']            	=   array('in', pylode(',', $uids));
		$rData['field']             =   '`uid`,`name`,`nametype`,`sex`,`telphone`,`def_job`, `photo_status`,`defphoto`,`phototype`';

		$resumeList                	=   $this -> getResumeList($rWhere, $rData);

		//  查询个人简历
		$reWhere['uid']             =   array('in', pylode(',', $uids));
		$reWhere['defaults']        =   '1';
		$reData['field']            =   '`id`,`uid`,`name`,`job_classid`,`minsalary`,`maxsalary`,`height_status`,`exp`,`edu`,`birthday`';

		$expectList                 =   $this -> getResumeExpectList($reWhere, $reData);
		
		$userid_msg		=	$this -> select_all("userid_msg",array('fid'=>$data['uid'],'uid'=>array('in', pylode(',', $uids))),"uid");
		
		$userid_job		=   $this -> select_all('userid_job',array('com_id'=>$data['uid'],'uid'=>array('in',pylode(',',$uids))),'`uid`,`is_browse`');
				
		foreach($List  as $k=>$v){
			foreach($resumeList as $val){
					
				if($v['uid'] == $val['uid']){
					$List[$k]['name_n']		=   $val['name'];
					$List[$k]['telphone_n']	=   $val['telphone'];
					$List[$k]['username']    =	$val['name_n'];
					$List[$k]['telphone']    =	$val['telphone'];
                    $List[$k]['photo']		=   $this -> setResumePhotoShow(array(
                        'photo' => $val['photo'],
                        'photo_status'=>$val['photo_status'],
                        'phototype' => $val['phototype'],
                        'sex' => $val['sex']
                    ));
				}
			}
			foreach ($expectList['list'] as $val){
				
				if ($v['uid']   ==  $val['uid']) {
                    $List[$k]['waprurl']	=   Url('wap',array('c'=>'resume','a'=>'show','id'=>$val['id']));
                    $List[$k]['eid']		=   $val['id'];
					$List[$k]['exp']		=   $val['exp_n'];
					$List[$k]['edu']		=   $val['edu_n'];
					$List[$k]['age']		=   $val['age_n'];
					if ($val['job_classid'] != "") {
						$List[$k]['jobname'] = $val['job_classname'];
					}
				}
			}
			foreach($userid_msg as $val)
			{
				if($val['uid']==$v['uid'])
				{
					$List[$k]['userid_msg']=1;
				}
			}
			
			foreach($userid_job as $val){
			    
				if($v['uid']==$val['uid']){
					$List[$k]['is_browse']		=	$val['is_browse'];
				}
			}
		}
        return $List;
    }

    /**
     * @desc    关注培训讲师，查询school_academy相关数据
     *
     * @param array $List
     * @return array
     */
    private function getAtnTeacherDataList($List,$data=array()) {
        
        $tids  =  array();
        foreach($List as $v){
			if($v['tid'] && !in_array($v['tid'],$tids)){
				$tids[]	=	$v['tid'];
			}
		}
		//  查询培训教师		
		$teWhere['id']              =   array('in', pylode(',', $tids));
		$teWhere['status']			=   '1';
		$teWhere['r_status']		=   1;
		$teData['field']            =   '`id`,`pic`,`name`,`hy`';
		$teacher				   	=	$this->select_all("px_teacher",$teWhere,$teData['field']);
		if(!empty($teacher)){
			foreach ($teacher as $v){
				$teacherids[]=$v['id'];
			}
		}
		include_once('cache.model.php');
		$cacheM						=	new cache_model($this->db, $this->def);
		$CacheList					=	$cacheM -> GetCache(array('hy'));
		//  查询培训课程	
		foreach ($tids as $k=>$v){
			$swhere['teachid'][]	=	array('findin',$v,'OR') ;
		}
		$sWhere['status']			=   '1';
		$sWhere['r_status']			=   1;
		$sWhere['pause_status']		=   1;
		//$sWhere['groupby']			=   'teachid';
		$sData['field']            	=   '`uid`,`name`,`id`,`teachid`';
		$subject				   	=	$this->select_all("px_subject",$sWhere,$sData['field']);
		if(!empty($subject)){
			foreach($subject as $v){
				if($data['wap']){
					$url		=	Url('wap',array("c"=>"train",'a'=>'subshow',"id"=>$v['id']));
				}else{
					$url		=	Url('train',array("c"=>"subshow","id"=>$v['id']));
				}
				
				$teachids	=	explode(',', $v['teachid']);
				if (!empty($teachids)){
					if (count($teachids)>1){
					   foreach ($teachids as $val){
						   $sname[$val][]="<a href='".$url."' target='_bank'>".$v['name']."</a>";
					   }
					}else{
						$sname[$v['teachid']][]="<a href='".$url."' target='_bank'>".$v['name']."</a>";
					}
				}
			}
		}
		
		foreach($List  as $k=>$v){
			//去除讲师审核中、未通过、不存在的情况
			if(!in_array($v['tid'], $teacherids)){
				unset($List[$k]);
			}
			
			foreach($teacher as $tv){
				if($v['tid']==$tv['id']){
					
					$List[$k]['teacher']	=	$tv['name'];
					
					$List[$k]['pic'] 		=	checkpic($tv['pic'], $this->config['sy_pxteacher_icon']);
					
					$List[$k]['sname']		=	implode(',',$sname[$tv['id']]);
					
					$List[$k]['hy_n']		=	$CacheList['industry_name'][$tv['hy']];
					
				}
			}
			
			foreach($sname as $key=>$sv){
				if($v['tid']==$key){
					$List[$k]['snum']	=	count($sv);
				}
			}
		}
        return $List;
    }
	/**
     * @desc    关注培训机构，查询px_train、px_subject相关数据
     *
     * @param   array $List
     */
    private function getAtnAgencyDataList($List,$data=array()) 
    {
        $sids  =  array();
        foreach($List as $v){
			if($v['sc_uid'] && !in_array($v['sc_uid'],$sids)){
				$sids[]	=	$v['sc_uid'];
			}
		}
    
		//  查询培训
		$trWhere['uid']             =   array('in', pylode(',', $sids));
		$trData['field']          	=   '`uid`,`logo`,`name`,`provinceid`,`cityid`';
		$train				   		=	$this->select_all('px_train',$trWhere,$trData['field']);
		include_once('cache.model.php');
		$cacheM						=	new cache_model($this->db, $this->def);
		$CacheList					=	$cacheM -> GetCache(array('city'));
		//  查询培训课程	
		$sWhere['uid']				=	array('in', pylode(',', $sids));
		$sWhere['status']			=   '1';
		$sWhere['r_status']			=   1;
		$sWhere['pause_status']		=   1;
    	$sWhere['groupby']			=   'uid';
		$sData['field']            	=   '`uid`,`name`,`id`,count(*) as num';
		$subject				   	=	$this->select_all("px_subject",$sWhere,$sData['field']);
		foreach($subject as $v){
			if($data['wap']){
				$url				=	Url('wap',array("c"=>"train",'a'=>'subshow',"id"=>$v['id']));
			}else{
				$url				=	Url('train',array("c"=>"subshow","id"=>$v['id']));
			}
			
			$subname[$v['uid']][]	=	"<a href='".$url."' target='_bank'>".$v['name']."</a>";
		}
		
		foreach($List  as $k=>$v){
			foreach($train as $tv){
				if($v['sc_uid']==$tv['uid']){
					$List[$k]['name']		=	$tv['name'];
					
					$List[$k]['logo']		=	checkpic($tv['logo'], $this->config['sy_px_icon']);
					
					$List[$k]['city_n']		=	$CacheList['city_name'][$tv['provinceid']];
					
					if (!empty($CacheList['city_name'][$tv['cityid']])){
					    $List[$k]['city_n']	.=	'-'.$CacheList['city_name'][$tv['cityid']];
					}
					
					$List[$k]['subname']	=	implode(',',$subname[$tv['uid']]);
					
				}
			}
			foreach($subject as $key=>$sv){
				if($v['sc_uid']==$sv['uid']){
					$List[$k]['num']			=	$sv['num'];
				}
			}
		}
        return $List;
    }
	/**
     * @desc    关注院校，查询school_academy相关数据
     *
     * @param   array $List
     */
    private function getAtnAcademyDataList($List,$data=array()) {
        
        $sids  =  array();
        foreach($List as $v){
			if($v['sc_uid'] && !in_array($v['sc_uid'],$sids)){
				$sids[]	=	$v['sc_uid'];
			}
		}
		$academyWhere['id']			=	array('in', pylode(',', $sids));
				
		$academyData['field']       =   '`id`,`schoolname`,`provinceid`,`cityid`,`photo`';
		$academy	=	$this -> getSchoolAcademyList($academyWhere,$academyData);
		foreach($List  as $k=>$v){
			foreach($academy['list'] as $val){
				if($v['sc_uid']==$val['id']){
					$List[$k]['schoolname_n']	=	$val['schoolname'];
					$List[$k]['provinceid_n']	=	$val['provinceid_n'];
					$List[$k]['cityid_n']		=	$val['cityid_n'];
					$List[$k]['photo_n']		=	$val['photo_n'];
				}
			}
            $List[$k]['wapcom_url'] = Url('wap',array('c'=>'school','a'=>'schoolacademyshow','uid'=>$v['sc_uid']));
		}
        return $List;
    }
	
	/**
     * @desc    关注宣讲会，查询school_xjh、company相关数据
     *
     * @param   array $List
     */
    private function getAtnXjhDataList($List,$data=array()) {
        
        $sids  =  $xjhids  =  $uids =   array();
        foreach($List as $v){
			if($v['sc_uid'] && !in_array($v['sc_uid'],$sids)){
				$sids[]		=	$v['sc_uid'];
			}
			if($v['xjhid'] && !in_array($v['xjhid'],$xjhids)){
				$xjhids[]	=	$v['xjhid'];
			}
			if($v['uid'] && !in_array($v['uid'],$uids)){
				$uids[]		=	$v['uid'];
			}
		}
		//  school_xjh
		$xjhWhere['id']           	=   array('in', pylode(',', $xjhids));
		$xjhData['field']          	=   '`stime`,`etime`,`id`,`provinceid`,`cityid`,`schoolid`,`address`';
		$xjhlist				   	=	$this->getSchoolXjhList($xjhWhere,$xjhData);
		
		//  查询企业	
		$comWhere['uid']			=	array('in', pylode(',', $sids));
		$comData['field']           =   '`uid`,`name`';
		$comlist				   	=	$this->getComList($comWhere,$comData);
		
		$resumelist					=	$this->select_all("resume",array('uid'=>array('in', pylode(',', $uids))),'`uid`,`name`,`telphone`');
		foreach($List  as $k=>$v){
			foreach($xjhlist as $val){
				if($v['xjhid']==$val['id']){
					$List[$k]['schoolid']=$val['schoolid'];
					$List[$k]['stime']=$val['stime'];
                    $List[$k]['stime_n'] = date('Y-m-d',$val['stime']);
					$List[$k]['etime']=$val['etime'];
                    $List[$k]['etime_n'] = date('Y-m-d',$val['etime']);
					$List[$k]['address_n']=$val['address'];
					$List[$k]['provinceid_n']=$val['provinceid_n'];
					$List[$k]['cityid_n']=$val['cityid_n'];
					$List[$k]['schoolname']=$val['sch_name'];
                    $List[$k]['wapschool_url'] = Url('wap',array('c'=>'school','a'=>'schoolacademyshow','id'=>$val['schoolid']));
				}
			}
			
			foreach($comlist['list'] as $val){
				if($v['sc_uid']==$val['uid']){
					$List[$k]['comname_n']=$val['name'];
                    $List[$k]['wapcom_url'] = Url('wap',array('c'=>'company','a'=>'show','id'=>$val['uid']));
				}
			}
			foreach($xjhlist as $val){
				if($v['sc_uid']==$val['id']){
					$List[$k]['schoolname_n']		=	$val['schoolname_n'];
					$List[$k]['provinceid_n']	=	$val['provinceid_n'];
					$List[$k]['cityid_n']		=	$val['cityid_n'];
				}
			}
			foreach($resumelist as $val){
				if($v['uid']==$val['uid']){
					$List[$k]['name_n']		=	$val['name'];
					$List[$k]['telphone_n']	=	$val['telphone'];
				}
			}
		}
        return $List;
    }
	/**
     * @desc    关注猎头，查询lt_info、lt_job相关数据
     *
     * @param   array $List
     */
    private function getAtnLtDataList($List,$data=array()) {
        
        $sids  =  array();
        foreach($List as $v){
			if($v['sc_uid'] && !in_array($v['sc_uid'],$sids)){
				$sids[]	=	$v['sc_uid'];
			}
		}
		$ltjobWhere['uid']			=	array('in', pylode(',', $sids));
		$ltjobWhere['status']		=	1;
		$ltjobWhere['zp_status']	=	array('<>', 1);
		
		$ltjobData['field']         =   '`uid`,`job_name`,`id`';
		$ltjob	=	$this -> select_all("lt_job",$ltjobWhere,$ltjobData['field']);
		
		$ltWhere['uid']				=	array('in', pylode(',', $sids));
		$ltData['field']        	=   '`uid`,`realname`,`exp`,`title`,`photo_big`';

		include_once ('lietou.model.php');
        $ltM    =   new lietou_model($this->db, $this->def);
        $lt		=	$ltM->getList($ltWhere,$ltData);

		foreach($ltjob as $v){
			if($data['wap']){
				$url				=	Url('wap',array("c"=>"ltjob",'a'=>'show',"id"=>$v['id']));
			}else{
				$url				=	Url('lietou',array("c"=>"jobshow","id"=>$v['id']));
			}
			
			$ltjobname[$v['uid']][]	=	"<a href='".$url."' target='_bank'>".$v['job_name']."</a>";
		}
		foreach($List  as $k=>$v){
			foreach($lt as $val){
				if($v['sc_uid']==$val['uid']){
					$List[$k]['com_name']	=	$val['realname'];
					$List[$k]['photo_big']	=	$val['photo_big'];
					$List[$k]['title_n']	=	$val['title_n'];
					$List[$k]['exp_n']		=	$val['exp_n'];
					
					$sdate						=	explode('-',$val['sdate']);
					$List[$k]['com_sdate']	=	$sdate[0];
				}
			}		
			foreach($ltjobname as $kk=>$val){
				if($v['sc_uid']==$kk){
					$List[$k]['jobnum']		=	count($val);
					$i=0;
					foreach($val as $value){
						if($i<2){
							$joblist[$kk][]		=	$value;
						}
						$i++;
					}
					$List[$k]['jobname']		=	@implode(",",$joblist[$kk]);
				}
			}
			$List[$k]['wapcom_url'] = Url('wap',array('c'=>'post','a'=>'headhunter','uid'=>$v['sc_uid']));
		}
        return $List;
    }
	/**
     * @desc    关注企业，查询company、company_job相关数据
     *
     * @param   array $List
     */
    private function getAtnComDataList($List,$data=array()) {
        
        $sids  =  array();
        foreach($List as $v){
			if($v['sc_uid'] && !in_array($v['sc_uid'],$sids)){
				$sids[]	=	$v['sc_uid'];
			}
		}
		//  职位信息company_job
		$jobWhere['uid']            =   array('in', pylode(',', $sids));
        $jobWhere['status']         =   array('<>', 1);
        $jobWhere['state']          =   1;
		$jobData['field']          	=   '`uid`,`name`,`id`,`pr`,`mun`';
		$joblist				   	=	$this->getJobList($jobWhere,$jobData);
		foreach($joblist['list'] as $v){
			if($data['wap']){
				$url					=	Url('wap',array("c"=>"job",'a'=>'comapply',"id"=>$v['id']));
			}else{
				$url					=	Url('job',array("c"=>"comapply","id"=>$v['id']));
			}
			
			$jobname[$v['uid']][]	=	"<a href='".$url."' target='_bank'>".$v['name']."</a>";
		}
		//  查询企业company	
		$comWhere['uid']			=	array('in', pylode(',', $sids));
		$comData['field']           =   '`uid`,`name`,`sdate`,`ant_num`,`logo`,`hy`,`pr`,`mun`,`logo_status`,`provinceid`,`cityid`,`three_cityid`';
		$comData['logo']           	=   '1';
		$comlist				   	=	$this->getComList($comWhere,$comData);

		foreach($List  as $k=>$v){
			
			$List[$k]['time_n']		=	date('Y-m-d H:i',$v['time']);
			
			foreach($comlist['list'] as $val){
				if($v['sc_uid']==$val['uid']){
					$List[$k]['com_name']	=	$val['name'];
					$List[$k]['hy_n']		=	$val['hy_n'];
					$List[$k]['pr_n']		=	$val['pr_n'];
					$List[$k]['mun_n']		=	$val['mun_n'];
                    $List[$k]['logo']		=	$val['logo'];
                    $List[$k]['city_n']		=	$val['citystr'];

					$sdate					=	explode('-',$val['sdate']);
					$List[$k]['com_sdate']	=	$sdate[0];
                    $List[$k]['wapcom_url'] = Url('wap',array('c'=>'company','a'=>'show','id'=>$v['sc_uid']));
				}
			}
			
			foreach($joblist['list'] as $val){
				if($v['sc_uid']==$val['uid']){
					$List[$k]['com_pr']		=	$val['job_pr'];
					$List[$k]['com_mun']	=	$val['job_mun'];
					
					$List[$k]['joblist_wx'][$val['id']]	=	$val['name'];
				}
			}		
			foreach($jobname as $kk=>$val){
				if($v['sc_uid']==$kk){
					$List[$k]['jobnum']		=	count($val);
					$i=0;
					foreach($val as $value){
						if($i<2){
							$joblist[$kk][]		=	$value;
						}
						$i++;
					}
					$List[$k]['jobname']		=	@implode(",",$joblist[$kk]);
				}
			}
			
		}
        return $List;
    }
	
	/**
     * @desc 取消关注企业、宣讲会、猎头、院校、培训机构、讲师
     * @param 表：atn
     * @param 引用字段：$data:字段 sc_usertype : 1个人、2企业/宣讲会（xjh，id为宣讲会id）、3猎头 、4培训/讲师（tid 讲师id） 、5院校
     */
	public function delAtnAll($id,$data=array()){
     
		if(!empty($id)){
 
		    $return   =   array();
		    
		    if ($data['type'] == 'admin') {   // 后台删除院校关注人
		        
		        if(is_array($id)){
		        
		            $ids    				=	$id;
		            $return['layertype']	=	1;
		        }else{
		            
		            $ids    				=   @explode(',', $id);
		            $return['layertype']	=	0;
		        }
		        $id       =   pylode(',', $ids);
				
		        
		        $return['id']     =   $this->delete_all('atn', array('id' => array('in', $id)),'');
		        
		        $return['msg']    =   $return['id'] ? '删除成功' : '删除失败';
		        $return['errcode']=   $return['id'] ? 9 : 8;
		        
		        return $return;
		        
		    }else{
		        
		        $return['layertype']	=	0;
		        
		        $id       =   intval($id);
		        $uid      =   intval($data['uid']);
		        $usertype =   intval($data['usertype']);
		        $type     =   intval($data['sc_usertype']);
		        
		        if($type == 5){
		            
		            $where    =   array(
		                'uid'         =>  $uid,
		                'id'          =>  $id,
		                'usertype'    =>  $usertype,
		                'sc_usertype' =>  5
		            );
		        }elseif($type==4){
		            
		            $where    =   array(
		                'id'          =>  $id,
		                'uid'         =>  $uid,
		                'usertype'    =>  $usertype,
		                'sc_usertype' =>  4,
		                'tid'         =>  $data['tid'] ? intval($data['tid']) : 0
		            );
		        }elseif($type==3){
		            
		            $where    =   array(
		                'id'          =>  $id,
		                'uid'         =>  $uid,
		                'usertype'    =>  $usertype,
		                'sc_usertype' =>  3
		            );
		        }elseif($type==2){
		            
	                $where    =   array(
	                    'id'          =>  $id,
	                    'uid'         =>  $uid,
	                    'usertype'    =>  $usertype,
	                    'sc_usertype' =>  2
	                );
		        }
		        
		        $return['id']     =   $this -> delete_all('atn', $where, '');
		        
		        if($return['id']){
		            
		            //取消关注宣讲会
		            if($type==2 && $data['xjh']){
		                $this -> addMemberLog($data['uid'],$data['usertype'],'取消关注校招宣讲会',5,3);
		            }
		            //取消关注企业
		            if($type==2 && !$data['xjh']){
		                $this -> update_once('company', array('ant_num' => array('-',1)),array('uid' => intval($data['cuid'])));
		                $this -> addMemberLog($data['uid'], $data['usertype'], '取消关注企业',5,3);
		            }
		            //取消关注猎头
		            if($type==3){
		                $this -> update_once("lt_info",array('ant_num'=>array('-',1)),array('uid'=>intval($data['cuid'])));
		                $this -> addMemberLog($data['uid'],$data['usertype'],'取消关注猎头',5,3);
		            }
		            //取消关注讲师
		            if($type==4 && $data['tid']){
		                $this -> update_once("px_teacher",array('ant_num'=>array('-',1)),array('id'=>intval($data['tid'])));
		                $this -> addMemberLog($data['uid'],$data['usertype'],'取消关注讲师',5,3);
		            }
		            //取消关注机构
		            if($type==4 && !$data['tid']){
		                $this -> addMemberLog($data['uid'],$data['usertype'],'取消关注的培训机构',5,3);
		            }
		            //取消关注院校
		            if($type==5){
		                $this -> addMemberLog($data['uid'],$data['usertype'],'取消关注院校',5,3);
		            }
		            
		            $return['msg']      =  '取消成功';
		            $return['errcode']  =  '9';
		        } else{
		            $return['msg']      =  '取消失败';
		            $return['errcode']  =  '8';
		        }
		    }
			
		}else{

			$return['msg']      	=  '系统繁忙';
			$return['errcode']  	=  '8';
			$return['layertype']	=	0;
		}
		return $return;  
	}
	
    public  function getatnInfo($where=array(),$data=array()){
       
          $select     =   $data['field'] ? $data['field'] : '*';
               
          $atnInfo    =   $this -> select_once('atn', $where, $select);
               
          return $atnInfo;
     }
    /**
     * @desc 添加信息
     * @param 表：atn
     * @param 引用字段：$data:字段
     */
    public  function addAtnInfo($data=array()){
        
        $nid    =   $this -> insert_into("atn", $data);
        
        return $nid;
    }
	/**
	 * @desc 关注数量
	 */
    function getAtnNum($whereData = array()) {
	    
	    return $this -> select_num('atn',$whereData);
	}
	
	/**
	 * @desc 关注
	 * @param array $data
	 * @return array
	 */
	public function addAtnLt($data = array())
    {
        $return     =   array();
        $id         =   (int) $data['id'];

        if ($id > 0) {
            
            if ($data['uid'] && $data['username']) {
                
                if ($data['utype'] == 'agency' || $data['utype'] == 'teacher') {
                    
                    if ($data['usertype'] == '4') {
                        $return['msg']      =   '只有个人用户和hr才能关注';
                        $return['errcode']  =   2;
                    }
                } else {
                    if ($data['usertype'] != '1') {
                        $return['msg']      =   '只有个人用户才可以关注！';
                        $return['errcode']  =   2;
                    }
                }

                if ($_POST['id'] == $data['uid']) {
                    $return['msg']      =   '自己不能关注自己！';
                    $return['errcode']  =   2;
                }
                
                $where                  =   array();
                $where['uid']           =   $data['uid'];   // 关注人UID
                $where['sc_uid']        =   $id;            // 被关注人UID
                
                $where['sc_usertype']   =   $data['sc_usertype'];
                
                if ($data['utype'] == 'agency') {
                    $table          =   'px_train';
                    $where['tid']   =   '';
                    $train          =   $this->select_once('px_train', array('uid' => $id), "`name`");
                    $name           =   $train['name'];
                    $utype          =   4;
                } elseif ($data['utype'] == 'teacher') {
                    
                    if ($data['tid']) { // 关注讲师
                        $table          =   'px_teacher';
                        $where['tid']   =   $data['tid'];
                        $teacher        =   $this->select_once('px_teacher', array('uid' => $id, 'id' => $data['tid']), '`name`');
                        $name           =   $teacher['name'];
                        $utype          =   4;
                    } else {
                        $table          =   'company';
                        $where['xjhid'] =   '0';
                        $company        =   $this->select_once('company', array('uid' => $id), "`name`");
                        $name           =   $company['name'];
                        $utype          =   2;
                    }
                } elseif ($data['utype'] == 'academy') {
                    
                    $academy    =   $this->select_once('school_academy', array('id' => $id), "`schoolname`");
                    $name       =   '院校' . $academy['name'];
                } else {
                    $table      =   'lt_info';
                    $row        =   $this->select_once('lt_info', array('uid' => $id), "realname");
                    $name       =   $row['realname'];
                    $utype      =   3;
                }

                $atninfo    =   $this->select_once('atn', $where, '`id`');  // 查询已关注信息
                 
                if (is_array($atninfo) && ! empty($atninfo)) {
 
                    $this -> delete_all('atn', $where, '');
                    
                    if (!empty($table)) {
                        $this -> update_once($table, array('ant_num' => array('-', 1)), array('uid' => $id));
                    }
                    
                    if (!empty($utype)) {
                        include_once ('sysmsg.model.php');
                        $sysmsgM    =   new sysmsg_model($this->db, $this->def);
                        
                        $userurl    =   '<a href="usertpl,' . $data['uid'] . '">' . sub_string($data['username']) . '</a>';
                        $content    =   "用户 " . $userurl . " 取消了对你(" . $name . ")的关注！";
                        $sysmsgM -> addInfo(array('uid' => $id, 'usertype' => $utype, 'content' => $content));
                    }
                    $this->addMemberLog($data['uid'], $data['usertype'], "取消了对" . $name . "的关注！", 5, 3);
                    $return['msg']      =   '取消关注成功！';
                    $return['cancel']   =   1;
                    $return['errcode']  =   1;
                } else {
                    
                    $adata  = array(
                        'uid'       =>  $data['uid'],
                        'sc_uid'    =>  $id,
                        'usertype'  =>  $data['usertype'],
                        'time'      => time()
                    );

                    if ($data['utype'] == 'teacher') {
                        if ($data['tid']) {
                            $adata['tid']   =   $data['tid'];
                        } else {
                            $adata['xjhid'] =   0;
                        }
                    }
                    $adata['sc_usertype']   =   $data['sc_usertype'];

                    $this -> insert_into('atn', $adata);
                    
                    if (!empty($table)) {
                        $this -> update_once($table, array('ant_num' => array('+', 1)), array('uid' => $id));
                    }
                    
                    if (!empty($utype)) {
                        include_once ('sysmsg.model.php');
                        $sysmsgM    =   new sysmsg_model($this->db, $this->def);
                        
                        $userurl    =   '<a href="usertpl,' . $data['uid'] . '">' . sub_string($data['username']) . '</a>';
                        $content    =   "用户 " . $userurl . " 关注了你(".$name.")";
                        $sysmsgM -> addInfo(array('uid' => $id, 'usertype' => $utype, 'content' => $content));
                    }
                    
                    $this -> addMemberLog($data['uid'], $data['usertype'], "关注了" . $name, 5, 1);
                    
                    $return['msg']      =   '关注成功！';
                    $return['errcode']  =   1;
                }
            } else {
                
                $return['msg']      =   '您还没有登录！';
                $return['errcode']  =   2;
            }
        }
        return $return;
    }
}
?>