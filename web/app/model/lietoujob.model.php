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
class lietoujob_model extends model{

	 /**
     *  @desc   获取缓存数据
     */
    private function getClass($options){
        
        if (!empty($options)){
            
            include_once ('cache.model.php');
            
            $cacheM     =   new cache_model($this->db, $this->def);
            
            $cache      =   $cacheM -> GetCache($options);
            
            return $cache;
        }
    }
    /**
     * @desc 获取lt_job  列表
     * $whereData       查询条件
     * $data            自定义处理数组
     */
    public function getList($whereData, $data = array()) 
    {
        $data['field']  =	empty($data['field']) ? '*' : $data['field'];
        $List           =   $this -> select_all('lt_job', $whereData, $data['field']);
		
		$options		=   array('city','lt');
            
        $cache			=   $this -> getClass($options);
			
		if(!empty($List)){
			foreach ($List  as  $k  =>  $v) {
			    $List[$k]['wapurl']            =  Url('wap', array('c'=>'post','a'=>'jobcomshow','id'=>$v['id']));
				if($v['provinceid']){
					$List[$k]['city_one_n']    =  $cache['city_name'][$v['provinceid']];
					$List[$k]['citystr']       =  $cache['city_name'][$v['provinceid']];
				}
				if($v['cityid']){
					$List[$k]['city_two_n']    =  $cache['city_name'][$v['cityid']];
					if (isset($List[$k]['citystr'])){
					    $List[$k]['citystr']  .=  '-'.$cache['city_name'][$v['cityid']];
					}else{
					    $List[$k]['citystr']   =  $cache['city_name'][$v['cityid']];
					}
				}
				if($v['three_cityid']){
					$List[$k]['city_three_n']  =  $cache['city_name'][$v['three_cityid']];
				}
				if ($v['exp']){
				    $List[$k]['exp_n']         =  $cache['ltclass_name'][$v['exp']];
				}
				if ($v['edu']){
				    $List[$k]['edu_n']         =  $cache['ltclass_name'][$v['edu']];
				}
				if ($v['minsalary'] || $v['maxsalary']) {
                     
                    if($v['minsalary'] && $v['maxsalary']>0){
                        
                        $List[$k]['salary']    =  floatval($v['minsalary']).'-'.floatval($v['maxsalary']).'万元';
						
                    }elseif ($v['minsalary'] && $v['maxsalary']==0){
                        
                        $List[$k]['salary']    =  floatval($v['minsalary']).'万元';
                    }else{
                        
                        $List[$k]['salary']    =  '面议';
                    }
                }
                if (isset($v['lastupdate'])){
                    $List[$k]['lastupdate_n'] = lastupdateStyle($v['lastupdate']);
                }
			}
		}
        return $List;    
    }
    /**
     * 获取lt_job       详情
     * $whereData       查询条件
     * $data            自定义处理数组
     */
    public function getInfo($whereData, $data = array()) {
        $data['field']  =	empty($data['field']) ? '*' : $data['field'];
        $ltInfo         =   $this -> select_once('lt_job', $whereData, $data['field']);
        if ($ltInfo && is_array($ltInfo)) {
            $CacheList                  =   $this   ->  getClass(array('city','job','user','com','hy','lt','ltjob','lthy'));
            if($data['cache']){//页面是否需要缓存数据
                $ltInfo['cache']        =   $CacheList;
            }
			$ltInfo['constitutev']      =   $ltInfo['constitute'];
			
			if($ltInfo['constitute']!=""){
			
				$ltInfo['constitute']	=	@explode(",",$ltInfo['constitute']);
                foreach($ltInfo['constitute'] as $v){
                     $const[]       =   $CacheList['ltclass_name'][$v];
                }
                $ltInfo['constitute_n']  =   @implode(",",$const);
			}
			$ltInfo['welfarev']=$ltInfo['welfare'];
			
			if($ltInfo['welfare']!=""){
				
				$ltInfo['welfare']		=	@explode(",",$ltInfo['welfare']);
                foreach($ltInfo['welfare'] as $k=>$v){
                   if(!$v){
                    unset($ltInfo['welfare'][$k]);
                   }
                }
                foreach($ltInfo['welfare'] as $v){
                    $welfare_arr[]  =   $CacheList['ltclass_name'][$v];
                }
                $ltInfo['welfare_n']     =   @implode(",",$welfare_arr); 
			}
			$ltInfo['languagev']=$ltInfo['language'];
			
			if($ltInfo['language']!=""){
				
				$ltInfo['language']	    =	@explode(",",$ltInfo['language']);
                foreach($ltInfo['language'] as $v){
                    $language_arr[] =   $CacheList['ltclass_name'][$v];
                }
                $ltInfo['language_n']    =   @implode(",",$language_arr);
			}
            if($data['datatype']=='moreinfo'){//详细信息，涉及到类别信息
                $ltInfo['mun_n']            =   $CacheList['ltclass_name'][$ltInfo['mun']];
                $ltInfo['pr_n']             =   $CacheList['ltclass_name'][$ltInfo['pr']];
                $ltInfo['hy_n']             =   $CacheList['industry_name'][$ltInfo['hy']];
                $ltInfo['salary_n']         =   $CacheList['ltclass_name'][$ltInfo['salary']];
                $ltInfo['jobone_n']         =   $CacheList['ltjob_name'][$ltInfo['jobone']];
                $ltInfo['jobtwo_n']         =   $CacheList['ltjob_name'][$ltInfo['jobtwo']];
                $ltInfo['age_n']            =   $CacheList['ltclass_name'][$ltInfo['age']];
                $ltInfo['sex_n']			=	$CacheList['com_sex'][$ltInfo['sex']];
                $ltInfo['exp_n']			=	$CacheList['ltclass_name'][$ltInfo['exp']];
                $ltInfo['full_n']		    =	$CacheList['ltclass_name'][$ltInfo['full']];
                $ltInfo['minsalary']        =   floatval($ltInfo['minsalary']);
                $ltInfo['maxsalary']        =   floatval($ltInfo['maxsalary']);
                $ltInfo['provinceid_n']     =   $CacheList['city_name'][$ltInfo['provinceid']];
                $ltInfo['cityid_n']         =   $CacheList['city_name'][$ltInfo['cityid']];
                $ltInfo['three_cityid_n']   =   $CacheList['city_name'][$ltInfo['three_cityid']];
                $ltInfo['edu_n']            =   $CacheList['ltclass_name'][$ltInfo['edu']];
            }
			$ltInfo['job_desc_t']    = strip_tags($ltInfo['job_desc']);
			
			$ltInfo['eligible_t']    = strip_tags($ltInfo['eligible']);
			
			$ltInfo['other_t']       = strip_tags($ltInfo['other']);

			//解决通过Editor上传的图片路径问题
            $ltInfo['desc']         =   str_replace(array("ti<x>tle","“","”"),array("title"," "," "),$ltInfo['desc']);
            $ltInfo['desc']         =   htmlspecialchars_decode($ltInfo['desc']);
            preg_match_all('/<img(.*?)src=("|\'|\s)?(.*?)(?="|\'|\s)/',$ltInfo['desc'],$res);
            if(!empty($res[3])){
                foreach($res[3] as $v){
                    if(strpos($v,'http:')===false && strpos($v,'https:')===false){
                        $ltInfo['desc'] = str_replace($v,$this->config['sy_ossurl'].$v,$ltInfo['desc']);
                    }
                }
            }
            //解决通过Editor上传的图片路径问题
            $ltInfo['job_desc']     =   str_replace(array("ti<x>tle","“","”"),array("title"," "," "),$ltInfo['job_desc']);
            $ltInfo['job_desc']     =   htmlspecialchars_decode($ltInfo['job_desc']);
            preg_match_all('/<img(.*?)src=("|\'|\s)?(.*?)(?="|\'|\s)/',$ltInfo['job_desc'],$res);
            if(!empty($res[3])){
                foreach($res[3] as $v){
                    if(strpos($v,'http:')===false && strpos($v,'https:')===false){
                        $ltInfo['job_desc'] = str_replace($v,$this->config['sy_ossurl'].$v,$ltInfo['job_desc']);
                    }
                }
            }
            //解决通过Editor上传的图片路径问题
            $ltInfo['eligible']     =   str_replace(array("ti<x>tle","“","”"),array("title"," "," "),$ltInfo['eligible']);
            $ltInfo['eligible']     =   htmlspecialchars_decode($ltInfo['eligible']);
            preg_match_all('/<img(.*?)src=("|\'|\s)?(.*?)(?="|\'|\s)/',$ltInfo['eligible'],$res);
            if(!empty($res[3])){
                foreach($res[3] as $v){
                    if(strpos($v,'http:')===false && strpos($v,'https:')===false){
                        $ltInfo['eligible'] = str_replace($v,$this->config['sy_ossurl'].$v,$ltInfo['eligible']);
                    }
                }
            }
            //解决通过Editor上传的图片路径问题
            $job['ltInfo']          =   str_replace(array("ti<x>tle","“","”"),array("title"," "," "),$ltInfo['other']);
            $job['ltInfo']          =   htmlspecialchars_decode($ltInfo['other']);
            preg_match_all('/<img(.*?)src=("|\'|\s)?(.*?)(?="|\'|\s)/',$ltInfo['other'],$res);
            if(!empty($res[3])){
                foreach($res[3] as $v){
                    if(strpos($v,'http:')===false && strpos($v,'https:')===false){
                        $ltInfo['other'] = str_replace($v,$this->config['sy_ossurl'].$v,$ltInfo['other']);
                    }
                }
            }
			$ltInfo['days']  = ceil(($ltInfo['edate']-$ltInfo['sdate'])/86400);
		}
        return $ltInfo;    
    }
    /**
     * 修改lt_job       详情 
     * $whereData       修改条件数据
     * $upData          修改的数据
     * $data 		    自定义处理数组
     */
	public function upInfo($whereData = array(), $upData = array(), $data = array()){
        $nid            =   0;
	    if (!empty($upData) && !empty($whereData)){
	        $nid	    =	$this -> update_once('lt_job', $upData, $whereData);
        }
        return $nid;
	}

	/**
	 * @desc  添加猎头职位
	 * @param array $data
	 * @return number
	 */
    public function addLtJobInfo($data = array())
    {
        $post   =   $data['post'];
        $id     =   $data['id'];

        $uid    =   intval($post['uid']);
        $spid   =   intval($post['spid']);

        $usertype   =   intval($post['usertype']);

        if ($usertype == 2) {

            $com    =   $this->select_once('company', array('uid' => $uid ), 'name,pr,hy,mun,content');

            if (! empty($com)) {
                $post['com_name']   =   $com['name'];
                $post['pr']         =   $com['pr'];
                $post['hy']         =   $com['hy'];
                $post['mun']        =   $com['mun'];
                $post['content']    =   $com['content'];
            }
        }

        $member =   $this->select_once('member', array('uid' => $uid), '`status`');

        $status =   $member['status'] != 1 ? 0 : $this->config['lt_job_status'];

        $post['status'] =   $status;

        if (empty($id)) {

            require_once ('statis.model.php');
            $statisM    =   new statis_model($this->db, $this->def);

            
            if ($usertype == 2) {

                $suid   =   !empty($spid) ? $spid : $uid;
                $return =   $statisM -> getCom(array('uid' => $suid, 'usertype' => $usertype));
            } else {

                $return =   $statisM -> getLtCom(1, array('uid' => $uid, 'usertype' => $usertype));
            }
            $post['uid']    =   $uid;
            
            unset($post['spid']);
            
            $post['sdate']  =   time(); //  添加发布时间
            $nid    = $this->insert_into('lt_job', $post);
            
            if ($nid) {
                
                require_once ('warning.model.php');
                
                $warningM = new warning_model($this->db, $this->def);
                
                $warningM -> warning(1, $uid);//预警提醒
            }

            $name   = "添加猎头职位";
            $type   = '1';
        } else {
            
            unset($post['spid']);
            
            $nid    =   $this->update_once('lt_job', $post, array('id' => $id,  'uid' => $uid));

            $this -> update_once('fav_job',array('job_name'=>$post['job_name']),array('job_id'=>$id)); 

            $name   =   "更新猎头职位";
            $type   =   '2';
            
        }

        if ($nid) {
            
            require_once ('log.model.php');
            $logM   =   new log_model($this->db, $this->def);

            $wxtempMsg  =   '有新的猎头职位需要审核';

            if ($usertype == 2) {
                $this -> update_once('company', array('jobtime' => time(), 'uid'=>$uid));

                $com = $this -> select_once('company',array('uid'=>$uid),'`name`');

                $wxtempMsg .= '，企业《'.$com['name'].'》'.$name . "《" . $post['job_name'] . "》成功，等待审核。";

                $logM -> addMemberLog($uid, $usertype, $name . "《" . $post['job_name'] . "》", 1, $type);
            } else {

                $ltinfo = $this -> select_once('lt_info',array('uid'=>$uid),'`realname`');

                $wxtempMsg .= '，猎头《'.$ltinfo['realname'].'》'.$name . "《" . $post['job_name'] . "》成功，等待审核。";

                $logM -> addMemberLog($uid, $usertype, $name . "《" . $post['job_name'] . "》", 10, $type);
            }
            if ($post['status'] == 1) {
                
                $return['msg'] = $name . '成功！';
                $return['url'] = 'index.php?c=job&s=1';
            } else {
                
                require_once ('admin.model.php');
                $adminM = new admin_model($this->db, $this->def);
                $adminM->sendAdminMsg(array('first'=>$wxtempMsg,'type'=>15));

                $return['msg'] = $name . '成功，等待审核！';
                $return['url'] = 'index.php?c=job&s=0';
            }
            
            $return['errcode'] = 9;
        } else {
            
            $return['msg'] = $name . '失败！';
            $return['errcode'] = 8;
        }
        
        return $return;
    }
    /**
     * 添加lt_job       详情
     * $data            自定义处理数组
     */
    public function addInfo($data = array()){

	    $nid	    =	$this -> insert_into('lt_job', $data);
      
        return $nid;
    }
    
    /**
     * 删除猎头用户的职位
     * $delId 	        职位id
     */
    public function delLietouJob($delId,$data = array()) {
             
        $return = array(
            'errcode'   => 8,
            'layertype' => 0,
            'msg'       => ''
        );
        if(empty($delId)){
            $return['msg']          =   '请选择您要删除的职位！';
            return	$return;
        }
        $del = $delId;
        if(is_array($del)){
            $return['layertype']    =   1;
            $del                    =   pylode(",",$del);
        }else{
            $return['layertype']    =   0;
        }
		if($data['utype'] != 'admin'){
			
			$delWhere = array('id' => array('in', $del),'uid'=>$data['uid']);
		}else{
			$delWhere = array('id' => array('in', $del));
		}
        $list   =   $this -> getList($delWhere, array('field' => '`id`,`uid`,`job_name`'));
 
        if(empty($list)){
			$return['errcode']		=   8;
            $return['msg']          =   '职位数据错误！';
            return	$return;
        }else{
			$checkdelId = array();
			foreach($list as $key=>$value){
				
				$checkdelId[] = $value['id'];
			
			}
			$del = pylode(',',$checkdelId);
		}
 

        //	删除关联的数据
        $return['id']	=	$this -> delete_all('lt_job', array('id' => array('in', $del)), '');

		if($return['id']){

			$this -> delete_all("rebates", array('job_id' => array('in', $del)), '');
			$this -> delete_all("fav_job", array('job_id' => array('in', $del)), '');
            if($data['utype'] != 'admin'){
                $this -> update_once('userid_job',array('isdel'=>3),array('job_id' => array('in', $del)));
            }else{
                $this -> delete_all('userid_job', array('job_id' => array('in', $del)), '');
            }
			
		}

        //记录系统日志
        require_once('sysmsg.model.php');
        $sysmsg	=	new sysmsg_model($this->db, $this->def);
        foreach($list as $v){
            $sysmsg -> addInfo(array('content'=>"管理员操作：删除职位《".$v['job_name']."》",'uid'=> $v['uid'],'usertype' => $v['usertype']));
        }
        if($return['id']){
            $return['errcode']  =   9;
            $return['msg']      =   '猎头职位(ID:'.$del.')删除成功！';
        }else{
            $return['errcode']  =   8;
            $return['msg']      =   '猎头职位(ID:'.$del.')删除失败！';
        }
        return	$return;
    }
    
    /**
     * 获取lt_job数量       详情
     * $whereData       查询条件
     */
    public function getLtjobNum($whereData) {
        
        $ltnum = $this -> select_num('lt_job', $whereData); 
        
        return $ltnum;
    }
    /**
     * @desc    后台审核猎头职位
     * @param   string $id (1 | 1,2,3)
     * @param   array $data
     */
    public function statusLtjob($id, $upData = array())
    {

        $ids    =   @explode(',', trim($id));
        
        $return =   array('msg' => '非法操作！', 'errcode' =>  8);
        
        if (!empty($id)) {
            
            $idstr      =   pylode(',', $ids);
            
            $upData     =   array(
                
                'status'    =>  intval($upData['status']),
                'statusbody'=>  trim($upData['statusbody']),
                'lastupdate'=>  time()
            );
            
            $result     =   $this -> update_once('lt_job', $upData, array('id' => array('in', $idstr),'r_status'=>1));
            
            if ($result) {
                
                if($upData['status'] == 1 || $upData['status'] == 3){
                    
                    $msg    =   array();
                    $uids   =   array();
                    
                    $jobs   =   $this->getList(array('id' => array('in', $idstr),'r_status'=>1), array('field' => '`id`,`uid`,`job_name`,`usertype`'));
                    
                    foreach ($jobs as $v){
                        
                        $uids[]                =  $v['uid'];
                        $usertypes[$v['uid']]  =  $v['usertype'];
                    }
                    
                    require_once 'notice.model.php';
                    $noticeM    =   new notice_model($this->db, $this->def);
                    
                    $member     =   $this -> select_all('member', array('uid' => array('in', pylode(',', $uids))), '`uid`,`email`,`moblie`');
                    
                    foreach ($jobs as $k => $v){
                        
                        if ($upData['status'] == 3) {
                            
                            $statusInfo         =   '您的猎头职位《'.$v['job_name'].'》审核未通过';
                            
                            if ($upData['statusbody']) {
                                $statusInfo     .=  '，原因：'.$upData['statusbody'];
                            }
                            
                            $msg[$v['uid']][]   =   $statusInfo;
                            
                        }elseif ($upData['status'] == 1){
                            
                            $msg[$v['uid']][]   =  '您的猎头职位《'.$v['job_name'].'》审核通过';
                        }
                        
                        
                        foreach ($member as $mv){
                            
                            $sendData  =  array();
                            
                            if ($v['uid'] == $mv['uid']) {
                                
                                $sendData['type']         =  $upData['status'] == 3 ? 'zzshwtg' : 'zzshtg';
                                
                                $sendData['uid']          =  $v['uid'];
                                $sendData['email']        =  $mv['email'];
                                $sendData['moblie']       =  $mv['moblie'];
                                
                                $sendData['jobname']      =  $v['job_name'];
                                $sendData['date']         =  date('Y-m-d H:i:s');
                                $sendData['status_info']  =  $upData['statusbody'];

                                //邮箱短信通知
                                $noticeM -> sendEmailType($sendData);
								$sendData['port']	=	'5';
                                $noticeM -> sendSMSType($sendData);
                            }
                        }
                    }
                    
                    
                    //发送系统通知
                    require_once 'sysmsg.model.php';
                    $sysmsgM    =   new sysmsg_model($this->db, $this->def);
                    $sysmsgM -> addInfo(array('uid' => $uids,'usertype'=>$usertypes,'content'=>$msg));
                }
                //查询当前信息
                //查询当前条数
                $jobwhere['id']      =     array('in',$idstr);
                $jobnum              =     $this->getLtjobNum($jobwhere);
                
                if($jobnum>1){
                    
                    $jobtwhere['id']        =   array('in',$idstr);
                    $jobtwhere['r_status']  =   1;
                    $jobtnum                =   $this->getLtjobNum($jobtwhere);
                    
                    $jobwwhere['id']        =   array('in',$idstr);
                    $jobwwhere['r_status']  =   array('<>',1);
                    $jobwnum                =   $this->getLtjobNum($jobwwhere);
                    
                    if($jobwnum>0){
                        $return['msg']      =   '猎头职位批量审核成功'.$jobtnum.'条，失败'.$jobwnum.'条。原因:账户未审核';
                    }else{
                        $return['msg']      =   '猎头职位批量审核成功(ID:'.$idstr.')';
                    }
                    
                    $return['errcode']  =  9;
                }else{
                    
                    $jobwwhere['id']           =     array('in',$idstr);
                    $jobwwhere['r_status']     =     array('<>',1);
                    $jobtnum                   =     $this->getLtjobNum($jobwwhere);
                    if($jobtnum>0){
                        $return['msg']      =  '审核猎头职位(ID:'.$idstr.')失败，原因:账户未审核';
                        $return['errcode']  =  8;
                    }else{
                        $return['msg']      =  '审核猎头职位(ID:'.$idstr.')设置成功';
                        $return['errcode']  =  9;
                    }
                    
                }
                
            }else{
                
                $return['msg']      =  '审核猎头职位(ID:'.$idstr.')设置失败';
                $return['errcode']  =  8;
            }
            
        }else {
            
            $return['msg']          =   '请选择需要审核的职位操作！';
            $return['errcode']      =   8;
        }
        
        return $return;
    }
    /**
     * @desc 猎头职位审核，企业/猎头不是已审核状态，弹出同步操作状态审核
     * @param int $id
     * @param array $data|status statusbody
     */
    public function status($id, $data = array()){
        
        if (!$id){
            
            $return     =   array(
                'errcode' => 8,
                'msg'     => '参数错误！'
            );
            return $return;
        }else{
             
            $job        =   $this->getInfo(array('id' => $id), array('field' => '`id`,`uid`,`usertype`,`job_name`'));
            
            $upData     =   array(
                
                'status'    =>  intval($data['status']),
                'statusbody'=>  trim($data['statusbody']),
                'lastupdate'=>  time()
            );
            
            $uid        =   $data['uid'];
            
            $result     =   $this -> update_once('lt_job', $upData, array('id' => $id, 'uid' => $uid));
            
            if ($result) {
                
                if ($data['status'] == '1') {
                    require_once 'userinfo.model.php';
                    $userinfoM  =   new userinfo_model($this->db, $this->def);
                    
                    $post   =   array(
                        'id'        =>  $id,
                        'status'    =>  1
                    );
                    $userinfoM -> status(array('uid' => $uid, 'usertype' => $job['usertype']), array('post' => $post));
                }
                
                //发送系统通知
                require_once 'sysmsg.model.php';
                $sysmsgM    =   new sysmsg_model($this->db, $this->def);
                $msg        =   $data['status'] == 3 ? '您的职位《'.$job['job_name'].'》审核未通过；原因：'.$data['statusbody'] : '您的职位《'.$job['job_name'].'》审核通过';
                $sysmsgM -> addInfo(array('uid' => $uid,'usertype'=>$job['usertype'],'content'=>$msg));
                
                require_once 'notice.model.php';
                $noticeM    =   new notice_model($this->db, $this->def);
                
                $member     =   $this -> select_once('member', array('uid' => $uid), '`uid`,`email`,`moblie`');
                $sendData   =   array();
                
                if (!empty($member)) {
                    
                    $sendData['type']		=	$data['status'] == 3 ? 'zzshwtg' : 'zzshtg';
                    $sendData['uid']		=	$uid;
                    $sendData['email']		=	$member['email'];
                    $sendData['moblie']		=	$member['moblie'];
                    $sendData['jobname']	=	$job['name'];
                    $sendData['date']		=	date('Y-m-d H:i:s');
                    $sendData['status_info']=	$data['statusbody'];
                    //邮箱短信通知
                    $noticeM -> sendEmailType($sendData);
					$sendData['port']	=	'5';
                    $noticeM -> sendSMSType($sendData);
                }
                
                $return = array(
                    'errcode' => 9,
                    'msg'     => '猎头职位(ID:'.$id.')审核设置成功！'
                );
                
            }else{
                $return = array(
                    'errcode' => 8,
                    'msg'     => '猎头职位(ID:'.$id.')审核设置失败！'
                );
            }
            
            return $return;
        }
    }
    
}
?>