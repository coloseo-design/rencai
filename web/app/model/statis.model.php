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

class statis_model extends model{

	/**
	 * @desc   获取账户套餐数据信息
	 * 
	 * @param int $uid
	 * @param array $data
	 * @return $statis
	 */
	function getInfo($uid, $data = array())
    {
        if (! empty($uid)) {
            
            $uid    =   intval($uid);

            $uType  =   intval($data['usertype']);

            $TBList = array(
                1 => 'member_statis',
                2 => 'company_statis',
                3 => 'lt_statis',
                4 => 'px_train_statis'
            );

            $tb = $TBList[$uType];

            $select = $data['field'] ? $data['field'] : '*';
            $statis = $this -> select_once($tb, array('uid' => $uid), $select);
            if ($statis && is_array($statis)) {
				$statis['packfk'] 		=   sprintf('%.2f', $statis['packpay']);
                $statis['freeze_n']		=   sprintf('%.2f', $statis['freeze']);
                $statis['vip_stime_n']	=   date('Y-m-d', $statis['vip_stime']);
                $statis['vip_etime_n']	=   $statis['vip_etime'] > 0 ? date('Y-m-d', $statis['vip_etime']): '不限';
                return $statis;
            }
        }
    }
	
	/**
	 * @desc   获取账户套餐数据信息列表
	 * 
	 * @param array $whereData
	 * @param array $data
	 * @return $statis
	 */
	function getList($whereData = array(), $data = array())
    {
        if (! empty($whereData)) {

            $uType = $data['usertype'] ? intval($data['usertype']) : 2;

            $TBList = array(
                1 => 'member_statis',
                2 => 'company_statis',
                3 => 'lt_statis',
                4 => 'px_train_statis'
            );

            $tb = $TBList[$uType];

            $select = $data['field'] ? $data['field'] : '*';

            $statis = $this -> select_all($tb, $whereData, $select);

            if ($statis && is_array($statis)) {
                if(in_array($uType, array(2, 3))){
                    foreach ($statis as $sk => $sv) {
                        if(isset($sv['vip_stime']) && $sv['vip_stime'] > 0){
                            $statis[$sk]['vip_stime_str']    =   date('Y-m-d', $sv['vip_stime']);
                        }
                        if($sv['vip_etime'] > 0){
                            
                            $statis[$sk]['vip_etime_str']    =   date('Y-m-d', $sv['vip_etime']);
                        }else{
                            
                            $statis[$sk]['vip_etime_str']    =   '永久';
                        }
                        if($sv['rating_type'] == 1){
                            
                            $statis[$sk]['rating_type_name'] =   '套餐模式';
                        }elseif ($sv['rating_type'] == 2) {
                            
                            $statis[$sk]['rating_type_name'] =   '时间模式';
                        }
                    }
                }

                return $statis;
            }
        }
    }

    /**
     * @desc   更新账户套餐数据信息
     *
     * @param array $data 更新数据
     * @param array $whereData
     * @return bool
     */
	function upInfo($data = array(), $whereData = array())
    {
        if (!empty($data) && $whereData) {

            $uid        = intval($whereData['uid']);
            $uType      = intval($whereData['usertype']);
            $ratingid   = intval($data['rating']);
            
            $TBList = array(
                1 => 'member_statis',
                2 => 'company_statis',
                3 => 'lt_statis',
                4 => 'px_train_statis'
            );

            $tb = $TBList[$uType];

            /* 更新职位表会员等级字段，名企数据  */
            if($uType == 2 && $ratingid){
                
                if (empty($data['rating_name']) || empty($data['vip_etime'])) {

                    require_once 'rating.model.php';
                    $ratingM    =   new rating_model($this->db, $this->def);
                    $ratingInfo =   $ratingM -> ratingInfo($ratingid, $uid);
                    
                    $data['rating_name']    =   $ratingInfo['rating_name'];

                    $data['vip_etime']      =   $ratingInfo['vip_etime'];
                    
                }
                $this -> update_once('company_job', array('rating' => $ratingid), array('uid' => $uid));
				$this -> update_once('company', array('rating' => $ratingid,'rating_name'=>$data['rating_name'],'vipstime'=>time(),'vipetime'=>$data['vip_etime']), array('uid' => $uid));
                
            }
            
            /* 管理员修改企业，变更会员等级，记录订单数据 */
            if (isset($whereData['adminedit']) && isset($whereData['info'])) {
                
                $rinfo  =   $whereData['info'];
                
                if($rinfo['time_start'] < time() && $rinfo['time_end'] > time()){
                    $price = $rinfo['yh_price'];
                }else{
                    $price = $rinfo['service_price'];
                }
                
                if($price > 0 && ($uType == 2||$uType == 3)){
                    
                    $statisInfo =   $this -> select_once($tb, array('uid' => $uid));
                    
                    if ($statisInfo['rating'] != $rinfo['id']) {
                        
                        $rinfo['usertype']	=	$uType;
                        $this -> addComOrder($rinfo, $uid, $ratingid);
                    }
                }
                
                $hData = array(
                    
                    'rating_id'     =>  $ratingid,
                    'rating'        =>  $data['name'],
                    'servide_price' =>  $price,
                    'time_start'    =>  time(),
                    'time_end'      =>  $rinfo['service_time']
                );
                
                $this -> update_once('hotjob', $hData, array('uid' => $uid));
            }

            $nid = $this -> update_once($tb, $data, array('uid'=>$uid));
            
			return $nid;
        }
    }
    
    /**
     * @desc   管理员修改会员等级，记录订单 
     * 
     * @param array $data
     * @param int $uid 
     * @param int $rating 会员等级
     */
    private function addComOrder($data = array(), $uid = null, $rating = null) {
        
        if($data['time_start'] < time() && $data['time_end'] > time()){
            
            $price  =   floatval($data['yh_price']);
        }else{
            
            $price  =   floatval($data['service_price']);
        }

        $comInfo    =   $this->select_once('company', array('uid' => $uid), '`crm_uid`');
        
        $dingdan    =   time().rand(10000,99999);
        
        $order      =   array(
            'order_id'      =>  $dingdan,
            'order_price'   =>  $price,
            'type'          =>  1,
            'order_time'    =>  time(),
            'order_state'   =>  '2',
            'order_remark'  =>  '管理员修改会员套餐',
            'uid'           =>  intval($uid),
			'usertype'      =>  $data['usertype'],
            'did'           =>  $this->config['did'],
            'rating'        =>  intval($rating),
            'order_type'    =>  'adminpay'
        );
        if ((int)$comInfo['crm_uid'] > 0){
            $order['crm_uid']   =   $comInfo['crm_uid'];
        }
        
        $this ->insert_into('company_order', $order);
        
    }
	
	/**
	 * @desc   新增账户，添加账户套餐数据信息
	 * 
	 * @param array $data
	 * @param array $where
	 */ 
	function addInfo($data = array(), $where = array())
    {
        if (!empty($data)) {

            $uType = intval($where['usertype']);

            $TBList = array(
                1 => 'member_statis',
                2 => 'company_statis',
                3 => 'lt_statis',
                4 => 'px_train_statis'
            );

            $tb = $TBList[$uType];

            return $this -> insert_into($tb, $data);
        }
    }
    /**
     * @desc 企业 会员套餐过期检测，并处理
     */
    public function vipOver($uid, $usertype = null){
    	
        $statis     =   $this -> getInfo($uid, array('usertype' => $usertype));//查询会员信息
        
        $cominfo    =   $this -> select_once('company',array('uid'=>$uid));

        if($usertype==2){

        	$time	=	time();
            
        	if($this->config['sy_maturityday']>0){

        		$endtimevip	=	$time+$this->config['sy_maturityday']*86400;
            }else{
                
            	$endtimevip	=	$time+30*86400;
            }
            
            if(!isVip($statis['vip_etime'])){

            	$statis['remind']=1;
            }
        }
        
        $sonList    =   $this -> select_all('company_account', array('comid' => $uid), '`uid`');    // 查询是否有子账号
        
        if (!empty($sonList) && is_array($sonList)) { // 子账号
            
            $spids  =   array();

            foreach ($sonList as $v){
                $spids[]    =   $v['uid'];
            }
        }

        if($statis['vip_etime'] && !isVip($statis['vip_etime']) && $cominfo['r_status']!=4){ //已过期非暂停会员
            //会员到期，变为过期会员
            if($this->config['com_vip_done'] == '0'){
                // 会员等级未清0的才需要处理，不加此判断，过期的企业，调用会重复处理
                if ($statis['rating'] > 0){
                    $data = array(
                        'job_num'       =>  '0',
                        'breakjob_num'  =>  '0',
                        'down_resume'   =>  '0',
                        'invite_resume' =>  '0',
                        'zph_num'       =>  '0',
                        'top_num'       =>  '0',
                        'rec_num'       =>  '0',
                        'urgent_num'    =>  '0',
                        'sons_num'      =>  '0',
                        'chat_num'      =>  '0',
                        'spview_num'    =>  '0',
                        'oldrating_name'=>  $statis['rating_name'],
                        'rating_name'   =>  '过期会员',
                        'rating_type'   =>  '0',
                        'rating'        =>  '0'
                    );
                    $this -> upInfo($data, array('uid' => $uid,'usertype' => $usertype));
                    
                    $this -> update_once('company', array('rating'=>$data['rating'], 'rating_name'=>$data['rating_name']), array('uid' => $uid));
                    $upJobArr['rating'] = 0;
                    
                    //会员到期职位下架
                    if($this -> config['jobunder'] == '1'){
                        
                        $upJobArr['status'] = 1;
                    }
                    $this -> update_once('company_job', $upJobArr, array('uid' => $uid));
                    
                    // 清空子账号套餐数据
                    if(!empty($spids)){
                        
                        $this -> update_once('company_statis', $data, array('uid' => array('in', pylode(',', $spids))));
                        
                        $this -> update_once('member', array('status'=>2, 'lock_info'=>'会员主体到期，子账号锁定'), array('uid' => array('in', pylode(',', $spids)), 'usertype' => 2));
                    }
                }
                //  过期会员，会员模式、会员等级清0
                $statis['rating_name']  =   '过期会员';
                $statis['rating_type']  =   '0';
                $statis['rating']       =   '0';
                
            }else{
                //会员到期，会员等级保留
                //修改会员等级
                require_once 'rating.model.php';
                $ratingM    =  new rating_model($this->db, $this->def);
                $rat_value  =  $ratingM -> ratingInfo($this->config['com_vip_done'], $uid);
                
                $this -> upInfo($rat_value,array('uid' => $uid, 'usertype' => $usertype));
                
                $this -> update_once('company_job', array('rating' => $this->config['com_vip_done']), array('uid' => $uid));
                $this -> update_once('company', array('rating' => $this->config['com_vip_done'],'rating_name' => $rat_value['rating_name']), array('uid' => $uid));
                
                // 清空子账号套餐数据
                if(!empty($spids)){
                    
                    $sData  =   array(
                        
                        'job_num'       =>  0,
                        'breakjob_num'  =>  0,
                        'down_resume'   =>  0,
                        'invite_resume' =>  0,
                        'zph_num'       =>  0,
                        'top_num'       =>  0,
                        'rec_num'       =>  0,
                        'urgent_num'    =>  0,
                        'sons_num'      =>  0,
                        'chat_num'      =>  0,
                    	'spview_num'   	=>  0,
                        'rating_name'   =>  $rat_value['rating_name'],
                        'rating_type'   =>  $rat_value['rating_type'],
                        'rating'        =>  $rat_value['rating']
                    );
                    
                    $this -> update_once('company_statis', $sData, array('uid' => array('in', pylode(',', $spids))));
                    
                    $this -> update_once('member', array('status' => 2, 'lock_info' => '会员主体到期，子账号锁定'), array('uid' => array('in', pylode(',', $spids)), 'usertype' => 2));
                }
            }
        }
        
        //会员未到期，永久会员（含过期会员）
        if(isVip($statis['vip_etime'])){
            
            if($statis['rating_type'] == '2'){//时间会员
            
                $addjobnum      =  '1';
                $spviewNum      =  '1';
                
            }else if($statis['rating_type'] == '1'){//套餐会员
                
				$addjobnum		=	$statis['job_num'] > 0 ? '1' : '2';
				$spviewNum		=	$statis['spview_num'] > 0 ? '1' : '2';
            }else{  //  过期
                
                $addjobnum      =  '0';
                $spviewNum		=  '0';
            }
        }else { //  过期
            
            $addjobnum          =  '0';
            $spviewNum			=  '0';
        }
        
        if($statis['rating'] > 0){
            if($statis['vip_etime'] && isVip($statis['vip_etime'])){

                $statis['days']     =  round(($statis['vip_etime']-time())/3600/24) ;
            }
        }
        $statis['addjobnum']        =  $addjobnum;
        $statis['spviewNum']        =  $spviewNum;
        $statis['pay_format']       =  number_format($statis['pay'],2);
        $statis['integral_format']  =  number_format($statis['integral']);
        
        return $statis;
    }

    function vipLtOver($uid, $usertype = null){
        
        $statis	    =	$this -> select_once('lt_statis',array('uid'=>$uid));
        
		if($statis['rating']){
		    
			$rating =   $this->select_once('company_rating',array('id'=>$statis['rating'],'category'=>'2'));
		}
		
		if($statis['vip_etime'] && !isVip($statis['vip_etime'])){//过期会员

		    if($this->config['lt_vip_done']=='0'){//会员到期，变为过期会员
		        // 会员等级未清0的才需要处理，不加此判断，过期的猎头，调用会重复处理
		        if ($statis['rating'] > 0){
		            $data = array(
		                'lt_job_num'      => 0,
		                'lt_breakjob_num' => 0,
		                'lt_down_resume'  => 0,
		                'chat_num'        => 0,
		                'rating_name'     => '过期会员',
		                'rating_type'     => 0,
		                'rating'          => 0
		            );
		            $this -> update_once('lt_statis',$data,array('uid'=>$uid));
		        }
		        //  过期会员，会员模式、会员等级清0
		        $statis['rating_name']  =   '过期会员';
		        $statis['rating_type']  =   '0';
		        $statis['rating']       =   '0';
		        
		    }else{//会员到期，--变为系统默认会员
		        //修改会员等级
		        require_once 'rating.model.php';
		        $ratingM    =  new rating_model($this->db, $this->def);
		        $rat_value	=	$ratingM->ltratingInfo($this->config['lt_vip_done'],$uid);
		        $this -> update_once('lt_statis',$rat_value,array('uid'=>$uid));
		    }
		}
		if(isVip($statis['vip_etime'])){
		    
			if($statis['rating_type'] =='2'){
			
			    $addltjobnum        =   '1';
			    
			}else if($statis['rating_type']=='1'){
				
			    if($statis['lt_job_num'] > 0){
				
			        $addltjobnum    =   '1';
				}else{
					
				    $addltjobnum    =   '2';
				}
   			}else{
   			    
				$addltjobnum        =   '0';
			}
		}else {
			$addltjobnum            =   '0';
		}

 		$statis['integral_format']  =   number_format($statis['integral']);
		$statis['addltjobnum']      =   $addltjobnum;
		
		return $statis;
	}
	/*
	*
    */
    
    function getCom($data=array())
    {
        
        $uid        =   intval($data['uid']);
        
        $usertype   =   intval($data['usertype']);

        $jobnum   =   intval($data['jobnum'])?intval($data['jobnum']):1;
        
        $statis		=	$this -> getInfo($uid,array('usertype' =>$usertype));
        
        if ($statis['uid'] == '') {
            
            $statis =   $this->vipOver($uid, 2);
        }
        
        if ($statis['rating_type'] == '' && $statis['rating']) {
            
            $rating =   $this -> select_once('company_rating',array('id'=>$statis['rating']),'`type`');

            $this -> upInfo(array('rating_type' => $rating['type']), array('usertype' => $usertype, 'uid' => $uid));
            
            $statis['rating_type']  =   $rating['type'];
        }
        
        if ($statis['rating_type'] && $statis['rating']) {
            
            if ($statis['rating_type'] == '1' && $statis['job_num'] >= $jobnum && isVip($statis['vip_etime'])) {
                
                $arr    =   array(
                    'job_num' => array('-', $jobnum)
                );
                
            } elseif ($statis['rating_type'] == '2' && isVip($statis['vip_etime'])) {
                
                if($data['upstatus']==1){//上架职位专用判断

                    require_once ('company.model.php');
                    $companyM = new company_model($this->db, $this->def);
                    $dcReturn = $companyM->comVipDayActionCheck('jobnum',$uid);

                    if($dcReturn['status']==-1){

                        return array('msg'=>$dcReturn['msg'],'errcode' => 8);

                    }else if($dcReturn['status']==1){

                        if($dcReturn['restnum']<$jobnum){
                            return array('msg'=>'您当天发布职位数量还剩'.$dcReturn['restnum'].'个，不足以上架'.$jobnum.'个职位！','errcode' => 8);
                        }else{
                            return array('rating_type'=>'2','errcode' => 9);
                        }

                    }

                }else{
                    $arr    =   null;
                }
                
            } else {
                
                return array('msg'=>'你的套餐已用完！','errcode' => 8);
            }
            
            if ($arr) {
                
                $this -> upInfo($arr, array('uid' => $uid, 'usertype' => $usertype));
            }
            
        } else {
            
            return array('msg'=>'你的会员已经到期，请先购买会员！','errcode'=>8);
        }
    }
    
    function getLtCom($type,$data=array()){
		$statis =   $this->vipLtOver($data['uid']);
		if($statis['rating_type']&&$statis['rating']){
			$arr    =   array();
			if($type==1){

			    if($statis['rating_type']=='1' && $statis['lt_job_num']>0 && isVip($statis['vip_etime'])){

                    $arr['lt_job_num']		=	array('-','1');
                    
			    }elseif($statis['rating_type']=='2' && isVip($statis['vip_etime'])){
                    //未过期或者永久时间会员
					$value=null;
				}else{
                    return array('msg'=>'会员套餐已用完!','errcode'=>8);
				} 
			}elseif($type==3){
			    if($statis['rating_type']=='1' && $statis['lt_breakjob_num']>0 && isVip($statis['vip_etime'])){
					$arr['lt_breakjob_num']=	array('-','1');
			    }elseif($statis['rating_type']=='2' && isVip($statis['vip_etime'])){//未过期或者永久时间会员
					$value=null;
				}else{
					return array('msg'=>'会员套餐已用完!','errcode'=>8);
				} 
			}
			if($arr){
                $this->update_once('lt_statis',$arr,array('uid'=>$data['uid']));
			}
		}else{
            return array('msg'=>'会员已到期！','errcode'=>8);
		}
	}
    /**
     * @desc    分配子账号的套餐数据
     * @param   int $data['uid'] 主账号
     * @param   int $data['spid'] 子账号
     * @param   其他分配的参数   job_num:发布职位数 resume:下载简历数 interview:邀请人才面试数 
     *                      breakjob_num:刷新职位数 part_num:发布兼职职位 breakpart_num:刷新兼职职位 
     *                      lt_job_num:发布猎头职位 lt_breakjob_num:刷新猎头职位  lt_resume:下载优质简历
     *                      zph_num:招聘会报名次数
     *                        
     * 2019-06-27 暂时只支持企业主账号分配给子账号套餐
     */
    public function assignChildStatis($data = array()){
		
        $res				=	array(
			'ecode'			=>	0,
			'msg'			=>	''
        );
		
        if(empty($data['spid']) || empty($data['uid'])){
			$res			=	array(
				'ecode'		=>	1,
				'msg'		=>	'缺少uid'
			);
			return $res;
        }

        $accountInfo        =   $this -> select_once('company_account', array('uid' => $data['spid']), '`uid`');
        
        if(empty($accountInfo)){
            $res			=	array(
				'ecode'		=>	2,
				'msg'		=>	'子账号信息错误'
			);
			return $res;
        }

        //获取主账号的套餐数据
        $fatherData         =   $this -> getInfo($data['uid'], array('usertype' => 2));
        
        if(empty($fatherData)){
            $res			=	array(
				'ecode'		=>	2,
				'msg'		=>	'主账号套餐信息错误'
			);
			return $res;
        }

        //获取子账号的套餐数据
        $oldSonData         =   $this -> getInfo($data['spid'], array('usertype' => 2));
        if(empty($oldSonData)){
            $res			=	array(
				'ecode'		=>	2,
				'msg'		=>	'子账号套餐信息错误'
			);
			return $res;
        }

        //分配的套餐字段
        if($fatherData['rating_type'] == 1){
            $assignField        =   array(
                'job_num', 'breakjob_num', 'down_resume',
                'invite_resume', 'zph_num', 'top_num',
                'urgent_num', 'rec_num', 'sons_num', 'chat_num'
            );
        }else if($fatherData['rating_type'] == 2){
            
            $assignField        =   array(
                'top_num', 'urgent_num', 'rec_num', 'sons_num', 'chat_num'
            );
        }
        

        //主账号的数量大于分配的数量
        $fatherRemain = $errorfield = $sonData  =   array();
        
        foreach ($assignField as $assV) {
            
            $data[$assV]    =   floor($data[$assV]);
            //if(bccomp($fatherData[$assV], bcadd($data[$assV], $oldSonData[$assV]), 2) != -1){
            
            if(bccomp($fatherData[$assV], $data[$assV], 2) != -1){
                    
                $fatherRemain[$assV]    =   bcsub($fatherData[$assV], $data[$assV]);
                $sonData[$assV]         =   array('+', $data[$assV]);
                
            }else{
                
                $errorfield[]           =   $assV;
            }
            
        }
        
        if(!empty($errorfield) || empty($fatherRemain)){
            $res			=	array(
				'ecode'		=>	3,
				'msg'		=>	'分配的数量大于主账号的数量无法分配'
            );
            return $res;
        }

        //修改主账号的套餐数量
        $updId              =   $this -> update_once('company_statis', $fatherRemain, array('uid' => $data['uid']));
        if(empty($updId)){
            $res			=	array(
				'ecode'		=>	4,
				'msg'		=>	'修改主账号数量错误'
            );
            return $res;
        }

        //此会员为时间模式时，如果子账号分配的数量为0，则以主账号的数据为准
        if($fatherData['rating_type'] == 2){
            $timeField      =   array(
                'job_num', 'breakjob_num', 'down_resume', 'invite_resume', 'zph_num'
            );
            foreach ($timeField as $timeV) {
                if(empty($data[$timeV])){
                    $sonData[$timeV]         =   $fatherData[$timeV];
                }
            }
        }

        //补充主账号的信息
        $sonData['rating']      =   $fatherData['rating'];
        $sonData['rating_name'] =   $fatherData['rating_name'];
        $sonData['rating_type'] =   $fatherData['rating_type'];
        $sonData['vip_stime']   =   $fatherData['vip_stime'];
        $sonData['vip_etime']   =   $fatherData['vip_etime'];

        //修改子账号数据
        $sonId                  =   $this -> update_once('company_statis', $sonData, array('uid' => $data['spid']));

        //返回数据
        if(empty($sonId)){
            $res			=	array(
				'ecode'		=>	8,
				'msg'		=>	'分配失败'
            );
        }else{
            $res			=	array(
				'ecode'		=>	9,
				'msg'		=>	'分配成功'
            );
            //增加会员日志
            require_once ('log.model.php');
            $LogM = new log_model($this->db, $this->def);
            $LogM -> addMemberLog($data['pid'], 2, '子账号uid:'.$data['uid'].'分配套餐成功', 27, 1);
        }
        return $res;
    }
	/**
     * 计划任务：会员到期自动下架职位
     * data['unit'] all  传入此值时，更新全部会员
     */
	function setVipedupjob($data = array()){
		$time		=	date('Y-m-d',strtotime('-7 day'));
		
        $endtime	=	strtotime($time.' 23:59:59');

        $statisWhere['PHPYUNBTWSTART_A']    =   '';

        if(isset($data['unit']) && $data['unit'] == 'all'){
            $statisWhere['vip_etime'][]     =   array('>', 0, 'AND');
        }else{
            $statisWhere['vip_etime'][]     =   array('>=', $endtime, 'AND');
        }
        
        $statisWhere['vip_etime'][]         =   array('<=', strtotime('today'), 'AND');
        
        $statisWhere['PHPYUNBTWEND_A']      =   '';

		$num = $this -> select_num('company_statis', $statisWhere);
        
		if ($num>0){
			
			$comstatis = $this -> select_all('company_statis', $statisWhere ,'`uid`,`vip_etime`,`rating_name`');

			if(is_array($comstatis)){
				
				foreach($comstatis as $key=>$value){					
					$uid[] 			=	$value['uid'];
                }
                $where              =   array();
				$where['uid']		=	array('in',pylode(',', $uid));
				$where['status']	=	array('<>', 1);
                $where['r_status']  =   array('<>', 4);
				
				$jobnum = $this -> select_num('company_job', $where);

				for($i=1; $i<=ceil($jobnum/500); $i++){
					
                    $where['limit']	=	array((($i-1)*500),($i*500));
					$jobids = array();
					$joblist = $this -> select_all('company_job', $where, '`id`,`uid`,`name`');
					foreach($joblist as $k=>$v){
						$jobids[]=$v['id'];
                    }
					$this -> update_once('company_job', array('status' => 1), array('id'=>array('in', pylode(',',$jobids))));
				}
			}
		}
    }
    
    /**
     * @desc 获取某一个参数是否可用；激活子账号
     * 
     * @param int $data['uid']
     * @param int $data['spid']  激活子账号UID
     * @param string $data['item']
     *        item值  job_num：职位数  breakjob_num:刷新职位数  down_resume:下载简历数  invite_resume:邀请面试数 zph_num:邀请面试数 sons_num:子账号数量  top_num:置顶数 urgent_num:紧急数 rec_num:推荐数
     * 
     */
    public function getItemUseCondition($data = array()){

        $res    =   array(
            'ecode'   =>  8,
            'msg'       =>  ''
        );
        
        $uid    =   intval($data['uid']);
        
        $spid   =   intval($data['spid']);
        
        if(empty($uid)){
            $res['msg'] =   '缺少uid';
            return $res;
        }
         
        if(empty($data['item'])){
            $res['msg'] =   '缺少参数项';
            return $res;
        }

        //参数项对应单独购买时的参数
        $buyItems       =   array(
            'sons_num'   =>  'integral_sons_num'
        );

        //时间模式时需要计算每日最大数量的参数项
        $dayItems       =   array(
            'job_num', 'breakjob_num', 'down_resume', 'invite_resume', 'zph_num'
        );
        //按次数统计的参数项
        $numItems       =   array(
            'top_num', 'urgent_num', 'rec_num', 'sons_num'
        );

        //获取uid的statis数据
        $statis =   $this -> getInfo($uid, array('usertype' => 2));
        if(empty($statis) || !isset($statis[$data['item']])){
            $res['msg'] =   '数据错误';
            return $res;
        }

        //判断使用支付的模式
        $payType        =   'normal';
        if($this -> config['com_integral_online'] == 4){
            $payType    =   'vip';
        }elseif ($this -> config['com_integral_online'] == 3) {
            $payType    =   !in_array('createson', explode(',', $this->config['sy_only_price'])) ? 'integral' : 'money';
        }elseif ($this -> config['com_integral_online'] == 2) {
            $payType    =   'money';
        }

        $res['ecode']   =   55;
        $res['data']['paytype'] =   $payType;
        $res['data']['payunit'] =   $payType == 'integral' ? $this -> config['integral_pricename'] : '元';

        $payMoney       =   0;
        if(array_key_exists($data['item'], $buyItems)){
            $payMoney   =   $this -> config[$buyItems[$data['item']]];
        }

        //过期会员
        if(!isVip($statis['vip_etime'])){
            $res['msg']     =   '您的会员已到期';
            $res['data']['paymoney'] =   $this -> calculateMoney($payMoney, $payType);
            return $res;
        }
        
        $remainNum      =   $statis[$data['item']];
        
        //判断后台是否开启该单项购买
        $single_can     =   @explode(',', $this->config['com_single_can']);
        $serverOpen     =   1;
        if(!in_array('createson',$single_can)){
            $serverOpen =   0;
        }

        //没有过期时数量判断，1为套餐模式，2为时间模式
        if($statis['rating_type'] == 1 || in_array($data['item'], $numItems)){
            if($statis[$data['item']] < 1){
                
                $res['data']['paymoney'] =   $this -> calculateMoney($payMoney, $payType);

                if($serverOpen){
                    $res['msg']     =   '很抱歉，您的套餐数量已用完，继续操作将会消费 '.$res['data']['paymoney'].' '.$res['data']['payunit'];
                }else{
                    $res['msg']     =   '您的套餐数量已用完,请前往购买会员';
                }
                return $res;
            }
        }elseif ($statis['rating_type'] == 2) {
            //参数项的值大于0时，需要去计算每日已经使用的数量,$dayUsedNum 需要去对应的方法去计算
            if(in_array($data['item'], $dayItems) && $statis[$data['item']] > 0){
                $dayUsedNum     =   0;
                if($dayUsedNum >= $statis[$data['item']]){
                    $res['msg']     =   '已超过每日最大操作次数';
                    $res['data']['paymoney'] =   $this -> calculateMoney($payMoney, $payType);
                    return $res;
                }
            }
        }
        
        if (!empty($spid)) {
            
            $this->update_once('member', array('status' => '1', 'lock_info' => ''), array('uid' => $spid));
            $staisInfo = $this->getInfo($uid, array('usertype' => 2, 'field' => '`sons_num`'));
            if(!empty($staisInfo) && $staisInfo['sons_num'] > 0){
                $this -> upInfo(array('sons_num' => array('-', 1)), array('usertype' => 2, 'uid' => $uid));
            }
            $res    =   array(
                'ecode' => 9,
                'msg'   => '子账号激活成功'
            );
        }else {
            
            $res    =   array(
                'ecode' =>  9,
                'msg'   =>  'ok',
                'data'  =>  array('remain' => $remainNum)
            );
        }
        return $res;
    }


    /**
     * 计算金额
     */
    private function calculateMoney($payMoney, $payType){
        if($payType == 'integral'){
            $payMoney   =   bcmul($payMoney, $this -> config['integral_proportion'], 2);
        }
        return floatval($payMoney);
    }
    
    public function getStatisTotal($timeBegin, $timeEnd,$userType){
      
        //调用MODEL
        require_once ('companyorder.model.php');

        $CompanyorderM          =           new companyorder_model($this->db, $this->def);

        require_once ('pack.model.php');

        $PackM                  =           new pack_model($this->db, $this->def);
 
        if($userType){

            require_once ('userinfo.model.php');

            $UserinfoM                    =           new userinfo_model($this->db, $this->def);

            $memberwhere['usertype']      =           $userType;

            $member                       =           $UserinfoM->getList($memberwhere,array('field'=>'`uid`'));
          
            foreach($member  as $val){
                
                $uidArr[]              =           $val['uid'];

            }

            $uidStr 				    = 			implode(',', $uidArr);

            $where['uid']				=			array('in',pylode(',',$uidStr));
    
            $mwhere['uid']				=			array('in',pylode(',',$uidStr));
           

        }

        $where['order_state']   =           2;

        if($timeBegin !=''){

			$where['order_time'][]         		=   			array('>=', $timeBegin);
		
			$where['order_time'][]         		=           	array('<=', $timeEnd,'AND');
        }
       
        $field 			= 				'sum(order_price) as `num`';

        $row		    =				$CompanyorderM->getList($where,array('field'=>$field));

        $in             =               isset($row[0]['num']) && $row[0]['num'] > 0 ? $row[0]['num'] : 0;

        $mwhere['order_state']					=				1;
       
        if($timeBegin != ''){

			$mwhere['time'][]         			=   			array('>=', $timeBegin);
			
			$mwhere['time'][]         			=           	array('<=', $timeEnd,'AND');

        }
        
        $mfield 								= 				'sum(order_price) as `num`';

        $mrow									=				$PackM->getList($mwhere,array('field'=>$mfield));
        
        $out 									= 				isset($mrow[0]['num']) && $mrow[0]['num'] > 0 ? $mrow[0]['num'] : 0;

        $net_income 							= 				$in - $out;
        
        return array($in, $out, $net_income);
      
    }
    /**
     * 计划任务：会员到期自动变更会员等级
     * data['unit'] all  传入此值时，更新全部会员
     */
    function setViped(){
        
        $statisWhere['PHPYUNBTWSTART_A']  =   '';
        $statisWhere['vip_etime'][]       =   array('>', 0, 'AND');
        $statisWhere['vip_etime'][]       =   array('<=', strtotime('today'));
        $statisWhere['PHPYUNBTWEND_A']    =   '';
        
        $statisWhere['rating']            =  array('>', 0);
        
        $num = $this -> select_num('company_statis', $statisWhere);
        
        if ($num>0){
            
            $comstatis = $this -> select_all('company_statis', $statisWhere ,'`uid`');
            
            if(is_array($comstatis)){
                
                foreach($comstatis as $value){
                    $uid[]  =  $value['uid'];
                }
                // 查询并清掉暂停的企业
                $cuid     =  array();
                $comList  =  $this -> select_all('company', array('uid' => array('in',pylode(',', $uid))), '`uid`,`r_status`');
                foreach ($comList as $v){
                    if ($v['r_status'] == 4){
                        $cuid[] = $v['uid'];
                    }
                }
                if (!empty($cuid)){
                    foreach($comstatis as $key=>$value){
                        if (in_array($value['uid'], $cuid)){
                            unset($comstatis[$key]);
                        }
                    }
                }
                
                // 查询并清掉暂停的企业 end
                if (!empty($comstatis)){
                    $euid  =  array();
                    foreach($comstatis as $value){
                        $euid[]  =  $value['uid'];
                    }
                    // 提前获取要批量设置的会员等级
                    if($this->config['com_vip_done'] != '0'){
                        $rating  =  $this->select_once('company_rating', array('id'=>$this->config['com_vip_done'],'category' => 1));
                    }
                    $cnum   =  count($comstatis);
                    $limit  =  200;
                    $where = array(
                        'uid' => array('in',pylode(',', $euid))
                    );
                    for($i=1; $i<=ceil($cnum/$limit); $i++){
                        
                        $where['limit']  =  array((($i-1)*$limit),($i*$limit));
                        
                        $suids = array();
                        $statislist = $this -> select_all('company_statis', $where, '`uid`,`rating_name`');
                        
                        foreach($statislist as $val){
                            $suids[] = $val['uid'];
                        }
                        
                        // 查询是否有子账号
                        $spids    =  array();
                        $sonList  =  $this -> select_all('company_account', array('comid' => array('in',pylode(',', $suids))), '`uid`');
                        if (!empty($sonList) && is_array($sonList)) {
                            foreach ($sonList as $v){
                                $spids[]  =  $v['uid'];
                            }
                        }
                        // 过期会员清空批量处理
                        if($this->config['com_vip_done'] == '0'){
                            
                            $data = array(
                                'job_num'       =>  '0',
                                'breakjob_num'  =>  '0',
                                'down_resume'   =>  '0',
                                'invite_resume' =>  '0',
                                'zph_num'       =>  '0',
                                'top_num'       =>  '0',
                                'rec_num'       =>  '0',
                                'urgent_num'    =>  '0',
                                'sons_num'      =>  '0',
                                'chat_num'      =>  '0',
                                'spview_num'    =>  '0',
                                'rating_name'   =>  '过期会员',
                                'rating_type'   =>  '0',
                                'rating'        =>  '0'
                            );
                            $this -> update_once('company_statis', $data, array('uid' => array('in',pylode(',', $suids))));
                            $this -> update_once('company', array('rating'=>$data['rating'], 'rating_name'=>$data['rating_name']), array('uid' => array('in',pylode(',', $suids))));
                            
                            $upJobArr = array('rating'=>0);
                            //会员到期职位下架
                            if($this -> config['jobunder'] == '1'){
                                
                                $upJobArr['status'] = 1;
                            }
                            $this -> update_once('company_job', $upJobArr, array('uid' => array('in',pylode(',', $suids))));
                            
                            // 清空子账号套餐数据
                            if(!empty($spids)){
                                $this -> update_once('company_statis', $data, array('uid' => array('in', pylode(',', $spids))));
                                $this -> update_once('member', array('status'=>2, 'lock_info'=>'会员主体到期，子账号锁定'), array('uid' => array('in', pylode(',', $spids)), 'usertype' => 2));
                            }
                        }elseif (!empty($rating)){
                            $rat_value  =  array(
                                'job_num'       =>  $rating['job_num'],
                                'breakjob_num'  =>  $rating['breakjob_num'],
                                'down_resume'   =>  $rating['resume'],
                                'invite_resume' =>  $rating['interview'],
                                'zph_num'       =>  $rating['zph_num'],
                                'top_num'       =>  $rating['top_num'],
                                'rec_num'       =>  $rating['rec_num'],
                                'urgent_num'    =>  $rating['urgent_num'],
                                'sons_num'      =>  $rating['sons_num'],
                                'chat_num'      =>  $rating['chat_num'],
                                'spview_num'   	=>  $rating['spview_num'],
                                'rating_name'   =>  $rating['name'],
                                'rating_type'   =>  $rating['type'],
                                'rating'        =>  $rating['id'],
                                'vip_stime'		=>	time()
                            );
                            // 会员等级到期时间。服务有效时间为0的是永久，不需要到期时间
                            if ($rating['service_time'] > 0){
                                $rat_value['vip_etime'] = time() + 86400 * $rating['service_time'];
                            }else{
                                $rat_value['vip_etime'] = 0;
                            }
                            $this -> update_once('company_statis', $rat_value, array('uid' => array('in',pylode(',', $suids))));
                            $this -> update_once('company_job', array('rating' => $rating['id'], 'uid' => array('in',pylode(',', $suids))));
                            $this -> update_once('company', array('rating' => $rating['id'],'rating_name' => $rating['name']), array('uid' => array('in',pylode(',', $suids))));
                            
                            // 清空子账号套餐数据
                            if(!empty($spids)){
                                
                                $sData  =   array(
                                    'job_num'       =>  0,
                                    'breakjob_num'  =>  0,
                                    'down_resume'   =>  0,
                                    'invite_resume' =>  0,
                                    'zph_num'       =>  0,
                                    'top_num'       =>  0,
                                    'rec_num'       =>  0,
                                    'urgent_num'    =>  0,
                                    'sons_num'      =>  0,
                                    'chat_num'      =>  0,
                                    'spview_num'   	=>  0,
                                    'rating_name'   =>  $rating['name'],
                                    'rating_type'   =>  $rating['type'],
                                    'rating'        =>  $rating['id']
                                );
                                
                                $this -> update_once('company_statis', $sData, array('uid' => array('in', pylode(',', $spids))));
                                
                                $this -> update_once('member', array('status' => 2, 'lock_info' => '会员主体到期，子账号锁定'), array('uid' => array('in', pylode(',', $spids)), 'usertype' => 2));
                            }
                        }
                    }
                }
            }
        }
        // 处理猎头
        $lwhere = array(
            'vip_etime' => array('<', strtotime('today')),
            'rating'    => array('>', 0)
        );
        $num  =  $this->select_num('lt_statis', $lwhere);
        
        if ($num > 0){
            
            $ltStatis  =  $this->select_all('lt_statis', $lwhere ,'`uid`');
            
            $uid  =  array();
            
            foreach ($ltStatis as $v){
                $uid[] = $v['uid'];
            }
            //会员到期，变为过期会员
            if($this->config['lt_vip_done']=='0'){
                
                $data = array(
                    'lt_job_num'      => 0,
                    'lt_breakjob_num' => 0,
                    'lt_down_resume'  => 0,
                    'chat_num'        => 0,
                    'rating_name'     => '过期会员',
                    'rating_type'     => 0,
                    'rating'          => 0
                );
                $this -> update_once('lt_statis',$data,array('uid'=>array('in',pylode(',', $uid))));
            }else{
                $ltrating  =  $this->select_once('company_rating', array('id'=>$this->config['lt_vip_done'],'category' => 2));
                if (!empty($ltrating)){
                    $rat_value = array(
                        'lt_job_num'      => $ltrating['lt_job_num'],
                        'lt_breakjob_num' => $ltrating['lt_breakjob_num'],
                        'lt_down_resume'  => $ltrating['lt_resume'],
                        'chat_num'        => $ltrating['chat_num'],
                        'rating_name'     => $ltrating['name'],
                        'rating_type'     => $ltrating['type'],
                        'rating'          => $ltrating['id'],
                        'vip_etime'		  => time() + 86400 * $ltrating['service_time'],
                        'vip_stime'		  => time()
                    );
                    $this -> update_once('lt_statis',$rat_value,array('uid'=>array('in',pylode(',', $uid))));
                }
            }
        }
    }
}
?>