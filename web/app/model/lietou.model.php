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
class lietou_model extends model{
    /**
     * @desc   获取缓存数据
     *
     * @param   array $options
     * @return  array $cache
     */
    private function getClass($options)
    {
             
        include_once ('cache.model.php');
        
        $cacheM     =   new cache_model($this->db, $this->def);
        
        $cache      =   $cacheM -> GetCache($options);
        
        return $cache;
     
    }
    
    /**
     * @desc   引用log类，添加用户日志   
     */
    private function addMemberLog($uid,$usertype,$content,$opera='',$type='') {
        require_once ('log.model.php');
        $LogM = new log_model($this->db, $this->def);
        return  $LogM -> addMemberLog($uid,$usertype,$content,$opera,$type); 
    }
    /**
     * 获取lt_info      列表
     * $whereData       查询条件
     * $data            自定义处理数组
     */
    public function getList($whereData, $data = array()) {
        $data['field']  =	empty($data['field']) ? '*' : $data['field'];
        $List           =   $this -> select_all('lt_info', $whereData, $data['field']); 
		if (!empty($List)) {

            $cache                  =   $this   ->  getClass(array('city','ltjob','lthy','lt'));
            foreach ($List  as  $k  =>  $v){
				if($v['photo_big']){
                   $List[$k]['photo_big']              =    checkpic($v['photo_big'] , $this->config['sy_lt_icon']);
                }
				
				if($v['provinceid']){
					$List[$k]['job_city_one']          =	$cache['city_name'][$v['provinceid']];
				}
				if($v['cityid']){
					$List[$k]['job_city_two']          =	$cache['city_name'][$v['cityid']];
				}
				if($v['three_cityid']){
					$List[$k]['job_city_three']        =	$cache['city_name'][$v['three_cityid']];
				}
                if($v['title']){
                    $List[$k]['title_n']               =    $cache['ltclass_name'][$v['title']];
                }
				if($v['exp']){
                    $List[$k]['exp_n']                 =    $cache['ltclass_name'][$v['exp']];
                }
			}
		}
        return $List;    
    }
    /**
     * 获取lt_info      详情
     * $whereData       查询条件
     * $data            自定义处理数组
     */
    public function getInfo($whereData, $data = array()) {
        $data['field']  =	empty($data['field']) ? '*' : $data['field'];
        $ltInfo         =   $this -> select_once('lt_info', $whereData, $data['field']);        
        
		$ltInfo['photo_n']           =	$ltInfo['photo_big'];
		if (!empty($ltInfo['photo_big'])  && $ltInfo['photo_status']==0||$data['utype'] == 'user'&&!empty($ltInfo['photo_big'])){
			$ltInfo['photo_big']	=	checkpic($ltInfo['photo_big'] , $this->config['sy_lt_icon']);
		}else{
			$ltInfo['photo_big']	=	checkpic($this->config['sy_lt_icon']);
		}
        if($data['datatype']=='moreinfo'){
            
            $cache                  =   $this   ->  getClass(array('city','ltjob','lthy','lt'));
            if($ltInfo['title']){
                $ltInfo['title_n']  =   $cache['ltclass_name'][$ltInfo['title']];
            }
            if($ltInfo['exp']){
                $ltInfo['exp_n']    =   $cache['ltclass_name'][$ltInfo['exp']];
            }
            if($ltInfo['hy']!=''){
                $hy                 =   @explode(",",$ltInfo['hy']);
                $hylist             =   array();
                foreach($hy as $v){
                    $hylist[]       =   $cache['lthy_name'][$v];
                }
                $ltInfo['hy_n']     =   @implode(",",$hylist);
            }
            if($ltInfo['job']!=""){
                $job                =   @explode(",",$ltInfo['job']);
                $joblist            =   array();
                foreach($job as $v){
                    $joblist[]      =   $cache['ltjob_name'][$v];
                }
                $ltInfo['job_n']    =   @implode(",",$joblist);
            }
            if($ltInfo['client']!=""){
                $ltInfo['client']   =   @explode(",",$ltInfo['client']);
            }
             
        }
        
        if($data['info'] == 1){
            
            $cache          =   $this -> getClass(array('city','ltjob','lthy','lt'));
            
            $job            =   @explode(',', $ltInfo['job']);
            $ltInfo['job']  =   $job;
            
            $hy             =   @explode(',', $ltInfo['hy']);
            $ltInfo['hy']   =   $hy;
            
            $jobnameA   =   $hynameA    =   array();
            
            foreach ($job as $v){
                $jobnameA[] =   $cache['ltjob_name'][$v];
            }
            $ltInfo['jobname']  =   @implode(',', $jobnameA);
            
            foreach ($hy as $v){
                $hynameA[]  =   $cache['lthy_name'][$v];
            }
            $ltInfo['hyname']   =   @implode(',', $hynameA);
            
            $ltInfo['member']   =   $this->select_once('member', array('uid' =>$ltInfo['uid']),'`login_date`');
            
            $ltInfo['user']     =   array(
                'email_status'  =>  $ltInfo['email_status'],
                'moblie_status' =>  $ltInfo['moblie_status'],
                'yyzz_status'   =>  $ltInfo['yyzz_status']
            );
            
            $ltInfo['statis']   =   $this->getLtStatisInfo(array('uid' => $ltInfo['uid']), array('field' => '`integral`,`packpay`'));
            
            $ltInfo['giverebatenum']    =   $this->getRebatesNum(array('job_uid' => $ltInfo['uid']));
        }
        
		return $ltInfo;    
    }

    /**
     * 修改lt_info      详情
     * 此方法只为修改一下简单的字段操作，如需编辑操作，需访问upLtInfo方法
     *
     * @param array $whereData  修改条件数据
     * @param array $upData 修改的数据
     * @param array $data   自定义处理数组
     * @return bool|int
     */
	public function upInfo($whereData = array(), $upData = array(), $data = array()){
        $nid        =   0;
	    if (!empty($upData) && !empty($whereData)){        
	        $nid    =	$this -> update_once('lt_info', $upData, $whereData);
        }
        return $nid;
	}

    /**
     * 添加lt_info
     *
     * @param array $addData
     * @param array $data
     * @return bool|int
     */
    public function addInfo($addData = array()){
        $nid        =   0;
        if (!empty($addData)){        
            $nid    =   $this -> insert_into('lt_info',$addData);
        }
        return $nid;
    }

    /**
     * 获取lt_statis    列表
     *
     * @param array $whereData    查询条件
     * @param array $data   自定义处理数组
     * @return array|bool|false|string|void
     */
    public function getLtStatisList($whereData, $data = array()) {
        $data['field']  =	empty($data['field']) ? '*' : $data['field'];
        $List           =   $this -> select_all('lt_statis', $whereData, $data['field']);
        if(!empty($data['index'])){
            $tmpList = array();
            foreach ($List as $ListV) {
                if(isset($ListV[$data['index']])){
                    $tmpList[$ListV[$data['index']]] = $ListV;
                }
            }
            $List       =   $tmpList;
        }
        return $List;    
    }
    /**
     * 获取rebates      列表
     * $whereData 	    查询条件
     * $data 		    自定义处理数组
     */
    public function getRebatesList($whereData, $data = array()) {
        $data['field']  =	empty($data['field']) ? '*' : $data['field'];
        $List           =   $this -> select_all('rebates', $whereData, $data['field']);
		if(!empty($List)){
		    $jobids = $uids = $ids = array();
			foreach($List as $v){
				if($v['job_id'] && !in_array($v['job_id'],$jobids)){
					$jobids[]	=	$v['job_id'];
				}
				if($v['uid'] && !in_array($v['uid'],$uids)){
					$uids[]	=	$v['uid'];
				}
				if($v['id'] && !in_array($v['id'],$ids)){
					$ids[]	=	$v['id'];
				}
			}
			require_once ('lietoujob.model.php');
			$ltjobM = new lietoujob_model($this->db, $this->def);
			require_once ('cache.model.php');
			$cacheM = new cache_model($this->db, $this->def);
			
			$ltjobWhere['id']		=	array('in',pylode(',',$jobids));
			$ltjobData['field']		=	'`id`,`job_name`,`com_name`,`rebates`,`usertype`';
			$ltjob		=	$ltjobM -> getList($ltjobWhere,$ltjobData); 
			
			$temporary	=	$this->select_all('temporary_resume',array('rid'=>array('in',pylode(',',$ids))));
			
			$user		=	$this->select_all('member',array('uid'=>array('in',pylode(',',$uids))),'`uid`,`username`');
			
			foreach($List as $k=>$v){
				foreach($ltjob as $val){
					if($v['job_id']==$val['id']){
						$List[$k]['job_name']=$val['job_name'];
						$List[$k]['com_name']=$val['com_name'];
						$List[$k]['rebates']=$val['rebates'];
						if($val['usertype']==2){
							$List[$k]['type']=2;
						}else{
							$List[$k]['type']=3;
						}									
					}
					$List[$k]['wapjob_url'] = Url('wap',array('c'=>'post','a'=>'jobshow','id'=>$v['job_id']));
                    $List[$k]['wapcom_url'] = Url('wap',array('c'=>'post','a'=>'headhunter','uid'=>$v['job_uid']));
				}
				foreach($user as $val){
					if($v['uid']==$val['uid']){
						$List[$k]['username']=$val['username'];
					}
				}
				$List[$k]['lastupdate_n']=date('Y-m-d',$v['datetime']);

                $cache  =   $this->getClass(array('city','ltjob','lthy','lt'));

				foreach($temporary as $val){
					if($v['id']==$val['rid']){
						$List[$k]['email']  =   $val['email'];
						$List[$k]['hyname'] =   $cache['industry_name'][$val['hy']];
						if($cache['city_name'][$val['provinceid']]){
						    $List[$k]['cityname']   .=  $cache['city_name'][$val['provinceid']];
						}
						if($cache['city_name'][$val['cityid']]){
						    $List[$k]['cityname']   .=  '-'.$cache['city_name'][$val['cityid']];
						}
						if($cache['city_name'][$val['three_cityid']]){
						    $List[$k]['cityname']   .=  '-'.$cache['city_name'][$val['three_cityid']];
						}
						if($val['job_classid']!=''){

							$job    =   @explode(',',$val['job_classid']);
							$joblist=   array();

							foreach($job as $va){
							    $joblist[]  =   $cache['job_name'][$va];
							}
							$List[$k]['jobclassname']   =   $joblist['0'];
						}
					}
				}
			}
		}
        return $List;    
    }
    /**
     * 获取rebates      详情
     * $whereData       查询条件
     * $data            自定义处理数组 scene 场景值，定制不同场景返回的数据
     */
    public function getRebatesInfo($whereData, $data = array()) {
        $data['field']  =	empty($data['field']) ? '*' : $data['field'];
        $Info  			=   $this -> select_once('rebates', $whereData, $data['field']);
		$id				=	intval($whereData['id']);
		
		if($data['show'] && $id){
			if(!intval($data['type'])){
				$this -> upRebates(array('status'=>'1'),array('id'=>$id));
			}
			include_once ('resume.model.php');
			
			$resumeM     =   new resume_model($this->db, $this->def);
			
			$resume	=	$resumeM -> getTempResumeInfo(array('rid'=>$id),array('field'=>'uname,sex,edu,exp,birthday,telphone,email,hy,job_classid,provinceid,cityid,three_cityid,minsalary,maxsalary,type,report','scene'=>'detail'));
			
			
			$Info['uname']		=	$resume['uname'];
			
			$Info['sex']		=	$resume['sex'];
			
			$Info['birthday']	=	$resume['birthday'];
			
			$Info['edu']		=	$resume['job_edu'];
			
			$Info['exp']		=	$resume['job_exp'];
			
			$Info['telphone']	=	$resume['telphone'];
			
			if ($resume['email']){
				
				$Info['email']	=	$resume['email'];
			}else{
				
				$Info['email']	=	'无';
			}
			$Info['hy']			=	$resume['job_hy'];
			
			$Info['job_classid']=	$resume['jobname'];
			
			$Info['city']		=	$resume['city'];
			
			$Info['salary']		=	$resume['rsalary'];
			
			$Info['type']		=	$resume['job_type'];
			
			$Info['report']		=	$resume['job_report'];
		}
        return $Info;    
    }
    /**
     * 更新rebates      详情
     * $whereData       查询条件
     */
    public function upRebates($upData,$whereData) {
        $nid  =   $this -> update_once('rebates', $upData, $whereData);
        return $nid;
    }
    /**
     * 添加rebates      详情
     * $rdata       rebate数据,
     * $tdata       temporaryresume临时简历数据
     * $data        自定义数组
     */
    public function addRebates($rdata=array(),$tdata=array(),$data=array()) {
        $nid    =   0;
        if(!empty($rdata)){
            if($rdata['name']==''){
                $return =   array('msg'=>"好友姓名不能为空！",'cod'=>8,'error'=>3);
            }elseif($rdata['phone']==''){
                $return =   array('msg'=>"好友手机不能为空！",'cod'=>8,'error'=>4);
            }elseif($rdata['phone']&&!CheckMobile($rdata['phone'])){
                $return =   array('msg'=>"手机格式不正确！",'cod'=>8,'error'=>5);
            }elseif($rdata['content']==''){
                $return =   array('msg'=>"推荐描述不能为空！",'cod'=>8,'error'=>6);
            }else{    
                $nid  =   $this -> insert_into('rebates', $rdata);
                if(!empty($tdata)){//猎头职位推荐，插入temporaryresume
                    if($nid){
                        $tdata['rid']           =   $nid;
                        
                        $id                     =   $this -> insert_into('temporary_resume',$tdata);
                        $this                   ->  addMemberLog($data['uid'],$data['usertype'],"为悬赏职位推荐人才",25,1);//会员日志
                        $return =   array('msg'=>"发布成功！",'cod'=>9,'error'=>1,'url'=>$_SERVER['HTTP_REFERER']);
                    }else{
                        $return =   array('msg'=>"发布失败！",'cod'=>8,'error'=>2);
                    }
                }
            }
            if(!empty($return)){
                $nid    =   $return;
            }
        }
        
        return $nid;
    }
    /**
     * 删除rebates      详情
     * $id       查询条件
     */
	function delRebates($id = null , $data = array()) {
        
        $return         =       array();
        
        if(!empty($id) || !empty($data['where'])){
            
            $where      =       array();
            
            if (!empty($id)) {
            
                if(is_array($id)){
                    
                    $ids    =	$id;
                    
                    $return['layertype']	=	1;
                    
                }else{
                    
                    $ids        =   @explode(',', $id);
    				$return['layertype']	=	0;
                    
                }
                
                $ids            =   pylode(',', $ids);
                
                $where['id']    =   array('in', $ids);
				if($data['uid'] && $data['type']==1){//我推荐的人才
				
					$where['uid']=$data['uid'];
				}
				if($data['uid'] && $data['type']==2){//推荐给我的人才
					
					$where['job_uid']=$data['uid'];
				}
            }
            
            if (!empty($data['where'])) {
                
                $where          =   array_merge($where, $data['where']);
                
            }
            
            $return['id']	=	$this -> delete_all('rebates', $where, '');
			
			if($return['id']){

				$this -> delete_all('temporary_resume', array('rid'=>array('in',$ids)), '');
			}

			if($data['uid']){
				if($data['type']==1){
				
					$this -> addMemberLog($data['uid'],$data['usertype'],'删除我推荐的人才',25,3);
				}
				if($data['type']==2){
					
					$this -> addMemberLog($data['uid'],$data['usertype'],'删除推荐给我的人才',25,3);
				}
			}else{
				$return['msg']		=	'猎头悬赏(ID:'.pylode(',', $id).')';
			}
			
            $return['errcode']	=	$return['id'] ? '9' :'8';
            $return['msg']		=	$return['id'] ? $return['msg'].'删除成功！' : $return['msg'].'删除失败！';
            
        }else{
            $return['msg']		=	'请选择您要删除的数据！';
            $return['errcode']	=	8;
        }
        
        return	$return;
    }
    /**
     * 获取rebate数量   详情
     * $whereData       查询条件
     */
    public function getRebatesNum($whereData) {
        
        $ltrebatesInfo  =   $this -> select_num('rebates', $whereData);
        
        return $ltrebatesInfo;
    }
    /**
     * 添加lt_statis    详情 
     * $addData         添加数据
     */
	public function addStatis($addData){
        $nid            =   0;
	    if (!empty($addData)){        
	        $nid	    =	$this -> insert_into('lt_statis', $addData);
        }
        return $nid;
	}
    /**
     * 修改lt_statis    详情 
     * $whereData       修改条件数据
     * $upData          修改的数据
     * $data 		    自定义处理数组
     */
	public function upStatis($whereData = array(), $upData = array(), $data = array()){
        $nid            =   0;
	    if (!empty($upData) && !empty($whereData)){        
	        $nid        =	$this -> update_once('lt_statis', $upData, $whereData);
        }
        return $nid;
	}
    /**
     * 获取lt_statis    详情
     * $whereData 	    查询条件
     * $data 		    自定义处理数组
     */
    public function getLtStatisInfo($whereData, $data = array()) {
        $data['field']  =	empty($data['field']) ? '*' : $data['field'];
        $Info           =   $this -> select_once('lt_statis', $whereData, $data['field']);
        return $Info;    
    }
		
	/**
     * 后台修改猎头基本信息时，对猎头会员等级和操作数量处理
     */
    public function setStatisInfo($uid, $data = array()){
        
		$sData	=	$data['sData'];

        if (!empty($sData['rating'])) {
            
            require_once 'statis.model.php';
            
            $statisM    =  new statis_model($this->db, $this->def);
            
            $ltRating	=  $this -> select_once('lt_statis',array('uid' => $uid),'`rating`');

            //企业会员等级做出了修改
            if ($sData['rating'] != $ltRating['rating']){
                
                require_once 'rating.model.php';
                $ratingM	=	new rating_model($this->db, $this->def);
                $rvalue		=   $ratingM -> ltratingInfo($sData['rating'], $uid);
				
				$rvalue['lt_job_num']		=	$rvalue['lt_job_num'] == $sData['lt_job_num'] ? $rvalue['lt_job_num'] : $sData['lt_job_num'];
				$rvalue['lt_breakjob_num']	=	$rvalue['lt_breakjob_num'] == $sData['lt_breakjob_num'] ? $rvalue['lt_breakjob_num'] : $sData['lt_breakjob_num'];
				$rvalue['lt_down_resume']	=	$rvalue['lt_down_resume'] == $sData['lt_down_resume'] ? $rvalue['lt_down_resume'] : $sData['lt_down_resume'];
				$rvalue['chat_num']			=	$rvalue['chat_num'] == $sData['chat_num'] ? $rvalue['chat_num'] : $sData['chat_num'];
				$rvalue['vip_etime']		=	$rvalue['vip_etime'] == $sData['vip_etime'] ? $rvalue['vip_etime'] : $sData['vip_etime'];

                $rinfo      =   $ratingM -> getInfo(array('id'=>$sData['rating']),array('field'=>'`name`,`time_start`,`time_end`,`yh_price`,`service_price`'));
                $result	=	$statisM->upInfo($rvalue, array('uid' => $uid, 'usertype' => 3, 'adminedit' => '1', 'info' => $rinfo));
            } else {
                
                $result		=	$this->update_once('lt_statis', $sData, array('uid' => $uid));
            }

			$return	=	array(
				'errcode'	=>	$result ? '9' : '8',
				'msg'		=>	$result ? '套餐信息更新成功！' : '套餐信息更新失败！'
			);
        }else{
			
			$return	=	array(
				
				'errcode'	=>	'8',
				'msg'		=>	'参数错误，请重试！'
			);
		}

		return $return;
    }

    /**
     * 获取lt_service   列表
     * $whereData 	    查询条件
     * $data 		    自定义处理数组
     */
    public function getLtserviceList($whereData, $data = array()) {
        $data['field']  =	empty($data['field']) ? '*' : $data['field'];
        $List           =   $this -> select_all('lt_service', $whereData, $data['field']);
		
		if (isset($data['detail']) && $data['detail'] == 'yes') {
            
            $detailList =   $this->getLtservicedetailList(array('orderby' => 'sort,desc'));
            
            if (!empty($detailList) && is_array($detailList)) {
                
                foreach ($List as $key => $value) {
                    
                    foreach ($detailList as $val){
                        
                        if ($value['id'] == $val['type']) {
                            
                            $List[$key]['detail'][] =   $val;
                        }
                    }
                }
            }
            
        }

        return $List;    
    }
    /**
     * 获取lt_service   详情
     * $whereData 	    查询条件
     * $data 		    自定义处理数组
     */
    public function getLtserviceInfo($whereData, $data = array()) {
        $data['field']  =	empty($data['field']) ? '*' : $data['field'];
        $List           =   $this -> select_once('lt_service', $whereData, $data['field']);
        return $List;    
    }
    /**
     * 添加lt_service   详情 
     * $addData         添加数据
     */
	public function addLtservice($addData){
        $nid            =   0;
	    if (!empty($addData)){
	        $nid	    =	$this -> insert_into('lt_service', $addData);
        }
        return $nid;
	}
    /**
     * 修改lt_service   详情
     * $whereData       修改条件数据
     * $upData          修改的数据
     * $data 		    自定义处理数组
     */
	public function upLtservice($whereData = array(), $upData = array(), $data = array()){
        $nid            =   0;
	    if (!empty($upData) && !empty($whereData)){        
	        $nid        =	$this -> update_once('lt_service', $upData, $whereData);
        }
        return $nid;
    }
    /**
     * 删除lt_service      详情
     * $whereData       查询条件
     */
    public function delLtservice($whereData) {

        $nid            =   0;
        $data['field']  =	empty($data['field']) ? '*' : $data['field'];
		 
		$ls	=	$this -> select_all('lt_service', $whereData);

		if(!empty($ls)){

			$typeIds	=	array();

			foreach($ls as $v){

				$typeIds[]	=	$v['id'];
			}
			
			$nid	=	$this -> delete_all('lt_service', $whereData, '');

			if($nid){

				$this->delete_all('lt_service_detail', array('type' => array('in', pylode(',', $typeIds))), '');
			}

			return $nid;    
		}
    }
    /**
     * 获取lt_service_detail    列表
     * $whereData 	            查询条件
     * $data 		            自定义处理数组
     */
    public function getLtservicedetailList($whereData, $data = array()) {
        $data['field']  =	empty($data['field']) ? '*' : $data['field'];

        $List           =   $this -> select_all('lt_service_detail', $whereData, $data['field']);
        
        if($data['pack'] == '1'){
        
			$List		=   $this->subLtSerDetailList($List);
        }
        return $List;    
    }
    
    /**
     * @desc   增值服务包详情添加名称
     * @param  array $List
     */
    private function subLtSerDetailList($List) {
        
        $packList  =   $this->getLtserviceList(array('display' => '1', 'orderby' => 'sort'), array('field'=> '`id`,`name`'));
        
        foreach ($List as $k => $v){
            
            foreach ($packList as $pv){
                
                if ($v['type']== $pv['id']) {
                    $List[$k]['name']  =   $pv['name'];
                }
                
            }
            
        }
        
        
        
        return $List;
    }
    
    /**
     * 获取lt_service_detail    详情
     * $whereData 	            查询条件
     * $data 		            自定义处理数组
     */
    public function getLtservicedetailInfo($whereData, $data = array()) {
        $data['field']  =	empty($data['field']) ? '*' : $data['field'];
        $Info           =   $this -> select_once('lt_service_detail', $whereData, $data['field']);
        return $Info;    
    }
    /**
     * 添加lt_service_detail    详情 
     * $addData                 添加数据
     */
	public function addLtservicedetail($addData){
        $nid            =   0;
	    if (!empty($addData)){
	        $nid	    =	$this -> insert_into('lt_service_detail', $addData);
        }
        return $nid;
	}
    /**
     * 修改lt_service_detail    详情
     * $whereData               修改条件数据
     * $upData                  修改的数据
     * $data 		            自定义处理数组
     */
	public function upLtservicedetail($whereData = array(), $upData = array(), $data = array()){
        $nid            =   0;
	    if (!empty($upData) && !empty($whereData)){        
	        $nid        =	$this -> update_once('lt_service_detail', $upData, $whereData);
        }
        return $nid;
    }
    /**
     * 删除lt_service_detail    详情
     * $whereData               查询条件
     */
    public function delLtservicedetail($whereData) 
	{
    
		$nid	=   0;
        
		$data['field']	=	empty($data['field']) ? '*' : $data['field'];
		 

        $nid	=   $this -> delete_all('lt_service_detail', $whereData, '');
        return $nid;    
    }

    /**
     * 修改猎头基本信息
     *
     * @param $whereData    修改条件
     * @param null[] $data  | mData member表要修改数据;  ltData lt_info表要修改数据(简单的修改只需要带此参数);  sData 后台修改操作数量数据;  utype 修改操作类型：admin-后台，user-会员中心
     * @return array|string[]
     */
	public function upLtInfo($whereData, $data=array('mData'=>null, 'ltData'=>null, 'sData'=>null, 'utype'=>null)) {
	    
	    $return  =  array();
	    
	    if(is_array($whereData) && !empty($whereData)){
		    //会员操作的修改，需要判断手机号、邮件是否已绑定，绑定的不能修改
		    if ($data['utype'] == 'user'){
		        
		        $lt  =  $this -> select_once('lt_info',array('uid'=>$whereData['uid']),'`moblie_status`,`email_status`');
		        
		        if (!empty($lt)){
		            
		            if ($lt['moblie_status'] == '1'){
		                
		                if (!empty($data['mData']) && $data['mData']['moblie']){
		                    
		                    unset($data['mData']['moblie']);
		                }
		                if (!empty($data['ltData']) && $data['ltData']['moblie']){
		                    
		                    unset($data['ltData']['moblie']);
		                }
		            }
		            if ($lt['email_status'] == '1'){
		                
		                if (!empty($data['mData']) && $data['mData']['email']){
		                    
		                    unset($data['mData']['email']);
		                }
		                if (!empty($data['ltData']) && $data['ltData']['email']){
		                    
		                    unset($data['ltData']['email']);
		                }
		            }
		        }
		    }

		    // 处理会员基本信息
		    if (!empty($data['mData'])){
		        
		        require_once ('userinfo.model.php');
		        
		        $UserinfoM	=	new userinfo_model($this->db, $this->def);
		        
		        $ckresult   =	$UserinfoM -> addMemberCheck($data['mData'], $whereData['uid'], $data['utype']);
		        
		        if (isset($ckresult) && $ckresult['msg']){
		            
		            $ckresult['errcode']	=  8;
		            
		            return $ckresult;
		        }
		    }

		    // 管理员操作的，有操作数量或会员等级，对其进行处理
		    if ($data['utype'] == 'admin' && !empty($data['sData'])){
		        
		        $this -> update_once('lt_statis', $data['sData'],array('uid'=>$whereData['uid']));
		    }

		    // 处理猎头基本信息
		    if (!empty($data['ltData'])){
		        
		        if(!empty($data['ltData']['phone'])){
		            
		            $ltphone   =   $this -> select_once('lt_info', array('phone' => $data['ltData']['phone']),'`uid`');
		            
		            if(!empty($ltphone) && $ltphone['uid'] != $whereData['uid']){
		                
		                $return['msg']      =  '座机已存在！';
		                $return['errcode']	=  8;
		                return	$return;
		            }
		        }
		        
		        $return['id']  =  $this -> update_once('lt_info', $data['ltData'], $whereData);
		        // 如传了猎头公司名称，需要同步修改猎头职位中相应的数据
		        if (!empty($data['ltData']['com_name'])){
		            
		            $this->update_once('lt_job',array('com_name'=>$data['ltData']['com_name']),array('uid'=>$whereData['uid']));
		        }
		        if ($return['id']){
		            // 会员操作的要记录会员日志
		            if ($data['utype'] == 'user'){
		                
		                $this -> addMemberLog($whereData['uid'], 3, '修改基本信息', 7);
		                // 如是第一次完善，需要进行积分处理
		                if(!empty($lt)  && $lt['com_name'] == ''){
		                    
		                    require_once ('integral.model.php');
		                    
		                    $IntegralM  =  new integral_model($this->db, $this->def);
		                    
		                    $IntegralM -> invtalCheck($whereData['uid'],3,'integral_userinfo','完善基本资料');
		                }
		            }
		            $return['msg']		=  $data['utype'] == 'user' ? '基本资料修改成功' : '猎头会员(ID:'.$whereData['uid'].')基本资料修改成功';
		            $return['errcode']	=  9;
		            $return['url']	=  $_SERVER['HTTP_REFERER'];
		        }else{
		            $return['msg']		=  $data['utype'] == 'user' ? '基本资料修改失败' :'猎头会员(ID:'.$whereData['uid'].')基本资料修改失败';
		            $return['errcode']	=  8;
		            $return['url']	=  $_SERVER['HTTP_REFERER'];
		        }
		    }
		}
		return $return;
	}
    /**
     * 修改猎头头像
     * @param array $whereData
     * @param array $data   photo/需上传的图片文件;   thumb/已处理好的缩略图;  utype/操作的用户类型;  base/需上传的base4图片;  preview/pc预览即上传
     */
    public function upLogo($whereData = array(),$data=array('photo'=>null,'thumb'=>null,'utype'=>null,'base'=>null,'preview'=>null))
    {
        if (!empty($whereData['uid'])){
            
            $uid  =  $whereData['uid'];
            // 头像还需上传的
            if ($data['photo'] || $data['base']){
                
                $upArr   =  array(
                    'file'     =>  $data['photo'],
                    'dir'      =>  'lietou',
                    'type'     =>  'logo',
                    'base'     =>  $data['base'],
                    'preview'  =>  $data['preview']
                );
                
                $result  =  $this -> upload($upArr);
                if (!empty($result['msg'])){
                    
                    $return['msg']      =  $result['msg'];
                    $return['errcode']  =  '8';
                    
                    return $return;
                    
                }elseif (!empty($result['picurl'])){
                    
                    $photo_big  =  $result['picurl'];
                        
                }
            }
            // 已处理好的头像缩略图
            if ($data['thumb']){
                
                $photo_big      =   str_replace('../data','./data',$data['thumb'][1]);
                
            }
            
            if (!empty($photo_big)){
                // 用户操作，且后台设置用户头像需要审核的
                $ltinfo	=	$this -> getInfo(array('uid'=>$uid),array('field'=>'r_status'));
				if(empty($ltinfo)){

					include_once('userinfo.model.php');
          
					$userinfoM  =  new userinfo_model($this->db, $this->def);
					$userinfoM -> activUser($uid,3);
				}
                if ($data['utype'] == 'user' && $this -> config['lt_logo_status'] == 1){
                    $photo_status  =  1;
                }else{
                    $photo_status  =  $ltinfo['r_status']==0?1:0;
                }
                
                $return['id']  =  $this -> update_once('lt_info',array('photo_big'=>$photo_big,'photo_status'=>$photo_status),array('uid'=>$uid));
            }
            
            if (isset($return['id'])) {
                // 用户操作的，判断处理头像上传积分
                if ($data['utype'] == 'user'){
                    
                    require_once ('integral.model.php');
                    
                    $IntegralM  =   new integral_model($this -> db, $this -> def);
                    $IntegralM  ->  invtalCheck($uid,3,'integral_avatar','上传头像');
                    
                    $this -> addMemberLog($uid, 3, '上传头像', 16, 1);
                    
                    if ($this -> config['lt_logo_status'] == 1){
                        $return['errcode']  =  '9';
                        $return['msg']      =  '上传成功，管理员审核后对其他用户开放显示';
                    }else{
                        $return['errcode']  =  '9';
                        $return['msg']      =  '上传成功';
                    }
                    // pc会员中心预览即上传，处理预览图
                    if ($data['preview']){
                        
                        $return['picurl']  =  checkpic($photo_big);
                    }
                }else{
                    $return['msg']      =  '猎头头像(ID:'.$uid.')修改成功';
                    $return['errcode']  =  '9';
                }
            }else{
                
                $return['msg']      =  '猎头头像(ID:'.$uid.')修改失败';
                $return['errcode']  =  '8';
            }
        }else{
            
            $return['msg']      =  '请选择需要修改的用户';
            $return['errcode']  =  '8';
        }
        
        return $return;
    }
	/**
   * 处理单个图片上传
   * @param file/需上传文件; dir/上传目录; type/上传图片类型; base/需上传base64; preview/pc预览即上传
   */
    private function upload($data = array('file'=>null,'dir'=>null,'type'=>null,'base'=>null,'preview'=>null)){
          
        include_once('upload.model.php');
          
        $UploadM  =  new upload_model($this->db, $this->def);
          
        $upArr  =  array(
            'file'     =>  $data['file'],
            'dir'      =>  $data['dir'],
            'type'     =>  $data['type'],
            'base'     =>  $data['base'],
            'preview'  =>  $data['preview']
        );
        $return  =  $UploadM -> newUpload($upArr);
          
        return $return;
    }

      /**
     * 后台猎头logo审核
     * @param string $id    格式：单个，如1 ; 批量，如1,2,3
     * @param array $data
     */
    public function statusLogo($uid,$data = array()){
        
        $uid  =  @explode(',',$uid);
        
        foreach($uid as $v){
            
            if($v){
                
                $uids[]  =  $v;
            }
        }
        if (!empty($uids)){
            
            $uidstr  =  pylode(',', $uids);
            
            $post    =  $data['post'];
            
            if ($post['photo_status'] == 2){
                //审核不通过删除图片
                $post['photo']	='';
            }
            
            $result  =  $this -> update_once('lt_info', $post, array('uid'=>array('in',$uidstr)));
            if ($result){
                
                if ($post['photo_status'] == 2){
                    
                    // 审核不通过，相关表头像删除
                    $this -> update_once('answer',array('pic'=>''),array('uid'=>array('in',$uidstr)));
                    $this -> update_once('question',array('pic'=>''),array('uid'=>array('in',$uidstr)));
                    
                    $statusInfo  =  '您的LOGO';
                    
                    foreach ($uids as $k=>$v){
                        
                        /* 处理审核信息 */
                        if($post['photo_statusbody']){
                            
                            $statusInfo  .=  ' , 因为'.$post['photo_statusbody'].' , ';
                        }
                        
                        $statusInfo  .=  '已被管理员删除';
                        
                        $msg[$v]  =  $statusInfo;
                    }
                    
                    //发送系统通知
                    include_once('sysmsg.model.php');
                    
                    $sysmsgM  =  new sysmsg_model($this->db, $this->def);
                    
                    $sysmsgM -> addInfo(array('uid'=>$uids,'usertype'=>3,'content'=>$msg));
                    
                }else{
                    // 审核通过，修改相关表logo
                    $ltInfo  =  $this->select_all('lt_info',array('uid'=>array('in',$uidstr)),'`uid`,`photo`');
                    foreach ($ltInfo as $k=>$v){
                        
                        $newlogo[$v['uid']]   =  $v['photo'];
                    }

                    $this -> update_once('answer',array('pic'=>array('CASE','uid',$newlogo)),array('uid'=>array('in',$uidstr)));
                    $this -> update_once('question',array('pic'=>array('CASE','uid',$newlogo)),array('uid'=>array('in',$uidstr)));
                }

                $return['msg']      =  '猎头LOGO审核(ID:'.$uidstr.')设置成功';
                $return['errcode']  =  '9';
            }else{
                $return['msg']      =  '猎头LOGO审核(ID:'.$uidstr.')设置失败';
                $return['errcode']  =  '8';
            }
        }else{
            $return['msg']      =  '请选择要审核的猎头LOGO';
            $return['errcode']  =  '8';
        }
        return $return;
    }
}
?>