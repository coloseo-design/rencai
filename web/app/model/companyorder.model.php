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
class companyorder_model extends model{
	/**
     * @desc   引用log类，添加用户日志   
     */
    private function addMemberLog($uid,$usertype,$content,$opera='',$type='') {
        require_once ('log.model.php');
        $LogM = new log_model($this->db, $this->def);
        return  $LogM -> addMemberLog($uid,$usertype,$content,$opera='',$type=''); 
    }
	/**
     * @desc   引用userinfo类，查询member列表信息   
     */
    private function getMemberList($whereData = array(), $data = array()) {
        require_once ('userinfo.model.php');
        $MemberM = new userinfo_model($this->db, $this->def);
        return  $MemberM -> getList($whereData , $data); 
    }
	/**
     * @desc   引用userinfo类，根据用户类型，直接查找用户信息   
     */
    private function getUserInfo($whereData = array(), $data = array()) {
        require_once ('userinfo.model.php');
        $MemberM = new userinfo_model($this->db, $this->def);
        return  $MemberM -> getUserInfo($whereData , $data); 
    }
	/**
     * @desc   获取用户姓名、企业名称   
     */
    private function getUserList($where = array()) {
        require_once ('userinfo.model.php');
        $userinfoM = new userinfo_model($this->db, $this->def);
        return  $userinfoM -> getUserList($where); 
    }
	/**
     * @desc   引用once类，查询once_job单条信息   
     */
    private function getOnceInfo($id = array(), $data = array()) {
        require_once ('once.model.php');
        $OnceM = new once_model($this->db, $this->def);
        return  $OnceM -> getOnceInfo($id , $data); 
    }
	/**
     * @desc   引用once类，查询once_job列表信息   
     */
    private function getOnceList($whereData = array(), $data = array()) {
        require_once ('once.model.php');
        $OnceM = new once_model($this->db, $this->def);
        return  $OnceM -> getOnceList($whereData , $data); 
    }
	/**
     * @desc   引用cache类
     */
    private function getCache($whereData = array()) {
        require_once ('cache.model.php');
        $CacheM = new cache_model($this->db, $this->def);
		
        return  $CacheM -> GetCache($whereData); 
    }

	/**
     * @desc   引用qrorder类，upuser_statis确认订单操作
     */
    private function upuserStatis($data)
    {

        require_once('qrorder.model.php');
        $QrorderM   =   new qrorder_model($this->db, $this->def);
        return $QrorderM->upuser_statis($data);
    }
	/**
     * 获取company_order      订单详情
     * $whereData       查询条件
     * $data            自定义处理数组
     */
	public function getInfo($where,$data=array('bank'=>'')){
	    
	    $field		=	empty($data['field']) ? '*' : $data['field'];
		
	    $info	=	$this -> select_once('company_order',$where, $field);
		
		if($info && is_array($info)){
		
		    if(!empty($data['bank'])){
		        
				$orderbank	=	@explode('@%',$info['order_bank']);
				if(is_array($orderbank)){
					foreach($orderbank as $key){
						$orderbank[]	=	$key;
					}
					$info['bank_name']	=	$orderbank[0];
					$info['bank_fname']	=	$orderbank[1];
					$info['bank_number']=	$orderbank[2];
				}
				
			}else{
				//显示用户名和姓名
				if($info['uid']){
					$member		=	$this -> select_once('member',array('uid'=>$info['uid']),'uid,username,usertype');
					$info['username']=$member['username'];
					
					if($member['usertype']=='1' || $member['usertype']=='2'){
						$user	=	$this -> getUserInfo(array('uid'=>$member['uid']),array('usertype'=>$member['usertype'],'field'=>'uid,name'));
					}elseif($member['usertype']=='3'){
						$user	=	$this -> getUserInfo(array('uid'=>$member['uid']),array('usertype'=>$member['usertype'],'field'=>'uid,realname as name'));
					}
					
					$info['comname']		=	$user['name'];					
				}elseif($info['once_id']){
					$once		=	$this -> getOnceInfo(array('id'=>$info['once_id']),array('field'=>'id,companyname,linkman'));
					$info['username']	=	$once['linkman'];
					$info['comname']	=	$once['companyname']; 
				}
				//显示银行转账信息
				$orderbank				=	@explode('@%',$info['order_bank']);
				if(is_array($orderbank)){
					foreach($orderbank as $key){
						$orderbank[]	=	$key;
					}
					$info['bankname']	=	$orderbank[0];
					$info['bankid']		=	$orderbank[1];
				}
				
				$info['order_pic']		=	checkpic($info['order_pic']);
				
				include (APP_PATH.'config/db.data.php');
				$info['type_n']			=	$arr_data['ordertype'][$info['type']];
			}
			//是否可以申请发票
			if($info['order_time'] > strtotime('-7 day')){
				$info['invoice']	=	'1';
			}
			return $info;
	    } 
	}

    /**
     * @desc 查询全部信息
     * @param 表：company_order
     * @param 功能说明：获取company_order表里面所有订单信息
     * @param 引用字段： $whereData：条件 2:$data:查询字段
     *
     * @return array|bool|false|string|void
     */
	 public function getList($whereData, $data = array()) {
	     
	     $data['field']  =	empty($data['field']) ? '*' : $data['field'];

         $List			=	$this -> select_all('company_order', $whereData, $data['field']);
         
         include (CONFIG_PATH.'db.data.php');
      
         if (!empty($List)) {
			
            /* 处理后台所需数据 */
            if ($data['utype']=='admin') {
                $List	=	$this -> getDataList($List);
            } 
			
            /* 处理后台crm查账助手所需数据 */
			if ($data['utype']=='crmaduit') {
                $List	=	$this -> getCrmAduitList($List);
            }
            
            /* 处理后台crm订单审批所需数据 */
            if ($data['utype']=='crmdealsp') {
                $List	=	$this -> getCrmDealsp($List);
            }

             /* 处理后台crm订单分配所需数据 */
             if ($data['utype']=='crmdealfp') {
                 $List	=	$this -> getCrmDealfp($List);
             }


             /* 处理后台crm成交订单数据 */
            if ($data['utype']=='crmdeal') {
                $List	=	$this -> getCrmDeal($List);
            } 
            
            /* 订单是否具备开具发票条件 */
            if ($data['invoice']==1) {
                if($this->config['sy_com_invoice']=='1'){
					$last_days	=	strtotime('-7 day');
					foreach($List as $key=>$val){
						if($val['order_time'] >= $last_days && $val['order_remark']!='使用充值卡' && $val['order_price'] >= $this->config['sy_com_invoice_money']){
							$List[$key]['invoice']	=	'1';
						}
					}
				}
            }
            
			/* 处理猎头所需数据 */
            if ($data['utype']=='lietou') {
                foreach($List as $key=>$val){
                    $List[$key]['sname']	=	$arr_data['paystate'][$val['order_state']];
                    $List[$key]['zf_type']	=	$arr_data['pay'][$val['order_type']];
                }
            } 
            
			/* 处理个人所需数据 */
            if ($data['utype']=='member') {
                
                foreach($List as $key=>$val){
                    $ord[]  =   $val['order_id'];
                }
                $order      =   $this->select_all('invoice_record',array('uid'=>$data['uid'], 'order_id'=>array('in', pylode(',',$ord))), '`status`,`order_id`');
				
                if($this->config['sy_com_invoice']=='1'){
					
				    foreach($List as $key=>$val){
                        
					    $List[$key]['order_time_n']    =   date('Y-m-d H:i:s',$val['order_time']);
					    $List[$key]['order_type_n']    =   $arr_data['pay'][$val['order_type']];
					    $List[$key]['order_state_n']   =   $arr_data['paystate'][$val['order_state']];
						
						foreach($order as $k=>$v){
					
						    if($val['order_id']==$v['order_id']){
							
						        $List[$key]['status']	=	$v['status'];
							}
						}
					}
           
				}
			}
			
			/* 处理企业所需数据 */
            if ($data['utype']=='com') {
				include (CONFIG_PATH.'db.data.php');
				$arr_data['ordertype'][2]  =  $this->config['integral_pricename'].'充值';
              
                foreach($List as $key=>$val){
                    $List[$key]['type_n']			=	$arr_data['ordertype'][$val['type']];
					$List[$key]['dingdan_id']		=	$val['order_id'];
					$List[$key]['dingdan_state_n']	=	strip_tags($arr_data['paystate'][$val['order_state']]);
					$List[$key]['dingdan_type_n']	=	$val['order_type']?strip_tags($arr_data['pay'][$val['order_type']]):'手动';
					$List[$key]['dingdan_time_n']	=	date('Y-m-d H:i:s',$val['order_time']);
					$List[$key]['dingdan_price']	=	$val['order_price'];
					$List[$key]['dingdan_remark']	=	$val['order_remark'];
                }
            }
        }
        return $List;
    }

    /**
     * @desc    查询company_order表内没有的数据，引用相关类，查询关联表，提取列表数据所需信息
     * @param array $List
     * @return array
     */
    private function getDataList($List) 
    {
        $uids  =  $onceid  =  $crm_uids =   array();
        
        foreach ($List as $v){
			if ($v['uid'] && !in_array($v['uid'],$uids)) {
                $uids[$v['uid']]		= 	$v['uid'];
            }
            if ($v['once_id'] && !in_array($v['once_id'],$onceid)) {
                $onceid[$v['once_id']]	= 	$v['once_id'];
            }
            if ((int)$v['crm_uid'] > 0 && !in_array($v['crm_uid'], $crm_uids)){
                $crm_uids[$v['crm_uid']]=   $v['crm_uid'];
            }
        }

        if($uids){
			//  查询用户名
		    $mList              =   $this -> select_all('member', array('uid'=>array('in', pylode(',', $uids))), '`uid`,`username`');
			
			//  查询企业名称、姓名
			$uWhere['uid']      =   array('in', pylode(',', $uids));
			$UList              =   $this -> getUserList($uWhere);
		}
		if($onceid){
			 //  查询once_job企业名称、联系人作为企业名称、用户名显示
			$oWhere['id']      	=   array('in', pylode(',', $onceid));
			$oData['field']     =   '`id`,`companyname`,`linkman`';
			$OList              =   $this -> getOnceList($oWhere, $oData);
		}

		if (!empty($crm_uids)){
		    $crmUsers           =   $this->select_all('admin_user', array('uid' => array('in', pylode(',', $crm_uids))), 'uid,username,name');
        }

		include (CONFIG_PATH.'db.data.php');
		
        foreach ($List  as  $k  =>  $v){
            //  分站did字段为空的数据
            if($v['did']    ==  ''){
                $List[$k]['did']  =   '0';
            }
			//状态
            $List[$k]['order_state_n']			=	$arr_data['paystate'][$v['order_state']];
			//支付类型
			$List[$k]['order_type_n']			=	$arr_data['pay'][$v['order_type']];
			//订单类型
			$List[$k]['type_n']					=	$arr_data['ordertype'][$v['type']];
			
            //  用户名
            if (!empty($mList)) {
                foreach ($mList as $va){
                    if ($v['uid']	==	$va['uid']) {
                        $List[$k]['username']	=	$va['username'];
                    }
                }
            }
            
            //	企业名称（姓名）
            if (!empty($UList)) {
                foreach ($UList as $va){
                    if ($v['uid']	==	$va['uid'] ) {
						$List[$k]['comname']	=	$va['name'];
                    }
                }
            }
			//店铺招聘时的企业名称、用户名
			if (!empty($OList)) {
				$CList=$OList;
                foreach ($CList as $va){
                    if ($v['once_id']	==	$va['id']) {
						$List[$k]['comname']	=	$va['companyname'];
						$List[$k]['username']	=	$va['linkman'];
                    }
                }
            }
			
			if (!empty($crmUsers)){
                foreach ($crmUsers as $va) {
                    if ($v['crm_uid'] == $va['uid']){
                        $List[$k]['crm_name']   =   $va['name'] ? $va['name'] : $va['username'];
                    }
			    }
            }
        }
        return $List;
	}

    /**
     * @desc    查询company_order表内没有的数据，引用相关类，查询关联表，提取列表数据所需信息
     * @param array $List
     * @return array
     */
    private function getCrmAduitList($List) {
        
        $uids   =   $crmuids    =   $ratings   =   array();
        
        foreach ($List as $v){
		
            if ($v['uid'] && !in_array($v['uid'],$uids)) {
                $uids[$v['uid']]		= 	$v['uid'];
            }
            
            if ($v['crm_uid'] && !in_array($v['crm_uid'],$crmuids)) {
                $crmuids[$v['crm_uid']]	= 	$v['crm_uid'];
			}
			
			if ($v['rating'] && !in_array($v['rating'],$ratings)) {
                $ratings[$v['rating']]		= 	$v['rating'];
            }
		}
		
		// 企业name
		if ($uids) { 
            $company    =   $this->select_all('company', array('uid' => array('in', pylode(',', $uids))), '`name`,uid');
        }
        // vip
        if ($ratings) { 
            $vip        =   $this->select_all('company_rating', array('id' => array('in', pylode(',', $ratings))), '`id`,`name`');
        }
        
        // 业务员name
        if ($crmuids) { 
            $salesman   =   $this->select_all('admin_user', array('uid' => array('in', pylode(',', $crmuids))), 'uid, `name`');
        }
        include (CONFIG_PATH.'db.data.php');
        foreach ($List  as  $k  =>  $v){
            $List[$k]['order_type_n']    =   $arr_data['pay'][$v['order_type']];
            $List[$k]['date']           =   date('Y-m-d', $v['order_time']);
            if (!empty($company)) {
                foreach ($company as $val){
                    if ($v['uid']	==	$val['uid']) {
                        $List[$k]['name']   =	$val['name'];
                    }
                }
            }
            if (!empty($vip)) {
                foreach ($vip as $val){
                    if ($v['rating']	==	$val['id'] ) {
						$List[$k]['vip']	=	$val['name'];
                    }
                }
            }
			if (!empty($salesman)) {
                foreach ($salesman as $val){
                    if ($v['crm_uid']	==	$val['uid']) {
						$List[$k]['crm_name']	=	$val['name'];
                    }
                }
            }
		}
        return $List;
    }
    /**
     * CRM 订单审批所需数据
     * @param array $List
     * @return array
     */
    private function getCrmDealsp($List){
        
        if (is_array($List)) {

            include CONFIG_PATH.'db.data.php';
            
            $uids   =   $auids  =   array();
            
            foreach ($List as $key => $val) {
                $uids[$val['uid']]      =   $val['uid'];
                $auids[$val['crm_uid']] =   $val['crm_uid'];
            }
            
            $company    =   $this->select_all('company', array('uid' => array('in', pylode(',', $uids))), '`uid`,`name`');
            
            $adminuser  =   $this->select_all('admin_user', array('uid' => array('in', pylode(',', $auids))), '`uid`,`name`');
            
            $ratingList =   $this->select_all('company_rating', array('category' => 1, 'service_price' => array('>', '0')), '`id`, `name`');
            
            foreach ($List as $k => $v) {
                
                foreach ($company as $v1) {
                    if ($v['uid'] == $v1['uid']) {
                        $List[$k]['comname']      =   $v1['name'];
                    }
                }
                foreach ($adminuser as $v2) {
                    if ($v['crm_uid'] == $v2['uid']) {
                        $List[$k]['aname']        =   $v2['name'];
                    }
                }
                foreach ($ratingList as $v3) {
                    if ($v['rating'] == $v3['id']) {
                        $List[$k]['rating_name']  =   $v3['name'];
                    }
                }
                
                $List[$k]['order_type_n']    =   $arr_data['pay'][$v['order_type']];
                $List[$k]['order_state_n']   =   $arr_data['paystate'][$v['order_state']];
                
            }
        }
        return $List;
    }

    /**
     * CRM 订单分配所需数据
     * @param array $List
     * @return array
     */
    private function getCrmDealfp($List){

        if (is_array($List)) {

            include CONFIG_PATH.'db.data.php';

            $uids   =   $auids  =   array();

            foreach ($List as $key => $val) {
                $uids[$val['uid']]      =   $val['uid'];
            }

            $company    =   $this->select_all('company', array('uid' => array('in', pylode(',', $uids))), '`uid`,`name`');

            foreach ($List as $k => $v) {

                foreach ($company as $v1) {
                    if ($v['uid'] == $v1['uid']) {
                        $List[$k]['comname']      =   $v1['name'];
                    }
                }

                $List[$k]['order_type_n']    =   $arr_data['pay'][$v['order_type']];
                $List[$k]['order_state_n']   =   $arr_data['paystate'][$v['order_state']];
            }
        }
        return $List;
    }

    /**
     * CRM 成交订单数据
     * @param array $List
     * @return array
     */
    private function getCrmDeal($List){
        
        if (is_array($List)) {
            
            $uids   =   array();
            
            foreach ($List as $key => $val) {
                $uids[$val['uid']]      =   $val['uid'];
                $auids[$val['crm_uid']] =   $val['crm_uid'];
            }
            
            $company    =   $this->select_all('company', array('uid' => array('in', pylode(',', $uids))), '`uid`,`name`,`linkman`,`rating_name`,`vipstime`,`vipetime`');
            
            $ausers     =   $this->select_all('admin_user', array('uid' => array('in', pylode(',', $auids))));
            
            $weekarray  =   array('日','一','二','三','四','五','六');
            
            $time       =   date('Y-m-d') - 86400 * 7;
            
            foreach ($List as $k => $v) {
                
                if($v['order_time']!=''){
                    
                    $ortime =	date('n月j日',$v['order_time']).'(周'.$weekarray[date("w",$v['order_time'])].')';
                    
                    $List[$k]['ortime_n']  =   $ortime;
                    
                    if ($v['order_time'] >= strtotime(date('Y-m-d'))) {
                        
                        $List[$k]['orTDay'] =   format_datetime($v['order_time'], 2, 2, '');
                    }else{
                        
                        $List[$k]['orTDay'] =   format_datetime($v['order_time'], 2, 1, '');
                    }
                    
                }
                
                foreach ($ausers as $dv){
                    if ($v['crm_uid'] == $dv['uid']) {
                        $List[$k]['aname']  =   $dv['name'];
                    }
                }
                
                
                foreach ($company as $cv) {
                    if ($v['uid'] == $cv['uid']) {
                        $List[$k]['linkman']    =   $cv['linkman'];
                        $List[$k]['comname']    =   $cv['name'];
                        $List[$k]['rating_name']=   $cv['rating_name'];
                        
                        if($cv['vipstime']!=''){
                            
                            $stime		=	date('n月j日',$cv['vipstime']).'(周'.$weekarray[date("w",$cv['vipstime'])].')';
                            
                            $List[$k]['vipstime_n']   =   $stime;
                            
                            if ($cv['vipstime'] >= strtotime(date('Y-m-d'))) {
                                
                                $List[$k]['vipSDay']    =   format_datetime($cv['vipstime'], 2, 2, '');
                            }else{
                                $List[$k]['vipSDay']    =   format_datetime($cv['vipstime'], 2, 1, '');
                            }
                            
                        }
                        
                        if($cv['vipetime']!=''){
                            
                            $etime		=	date('n月j日',$cv['vipetime']).'(周'.$weekarray[date("w",$cv['vipetime'])].')';

                            $List[$k]['vipetime_n']   =   $etime;
                            
                            if ($cv['vipetime'] >= strtotime(date('Y-m-d'))) {
                                
                                $List[$k]['vipEDay']    =   format_datetime($cv['vipetime'], 2, 2, '');
                            }else{
                                $List[$k]['vipEDay']    =   format_datetime($cv['vipetime'], 2, 1, '');
                            }
                            
                            if($cv['vipetime'] < $time){
                                $List[$key]['dealNew']  =   '1';
                            }
                            
                        }
                        
                    }
                }
            }
        }
        return $List;
    }
    
	/**
     * @desc 更新数据
     * @param int/array     $id
     * @param array         $data
     */
    public function upInfo( $id ,$Data = array(),$uid='') {

        if (!empty($id)) {            
            if (is_array($id)) {  
                $where['id']   =   array('in' , pylode(',' ,  $id));
            } else {
                $where['id']   =   intval($id);
            }
			if($uid){
				$where['uid']   =   intval($uid);
			}
            $nid    =   $this -> update_once('company_order', $Data, $where);
            if($nid){
				return array('errcode'=>'9','msg'=>'充值记录(ID:'.$id.')修改成功！');
			}else{
				return array('errcode'=>'8','msg'=>'充值记录(ID:'.$id.')修改失败！');
			}
        }
    }

    /**
     * @desc 确认付款
     * @param int $id
     * @return string[]
     */
    public function setPay($id)
    {

        if (!empty($id)) {

            $row    =   $this->getInfo(array('id' => $id));

            if ($row['order_state'] == '1' || $row['order_state'] == '3') {

                $nid    =   $this->upuserStatis($row);

                if ($nid) {

                    return array('errcode' => '9', 'msg' => '充值记录(ID:' . $id . ')确认成功！');
                } else {

                    return array('errcode' => '8', 'msg' => '确认失败,请稍后再试！');
                }
            } else {

                return array('errcode' => '8', 'msg' => '订单已确认，请勿重复操作！');
            }
        }
    }
    
	/**
      * 删除订单记录
      * @param 表：company_order
      * @param 功能说明：删除company_order表里面记录
      * @param 引用字段：$id:删除记录
      *
     */
	public function del($id,$data=array()){
	    
		if($data['utype']=='once'){
		
		    $oid		=	$this->getInfo(array('id'=>$id,'order_state'=>1),array('field'=>'`id`,`once_id`'));
			$id			=	$oid['id'];
			$onceid		=	$oid['once_id'];
			$getWhere	=	array();
		}elseif($data['utype']=='admin'){
			
			$getWhere	=	array();
		
		}else{
			//非后台操作 必须验证UID
			$getWhere	=	array('uid'=>$data['uid']);
		
		}
		
		$return     =   array();
		
		if(!empty($id)){
		
		    if(is_array($id)){
			
		        $ids    				=	$id;
				$return['layertype']	=	1;
			}else{
				
			    $ids   				 	=   @explode(',', $id);
				$return['layertype']	=	0;
			}
			
			$id							=   pylode(',', $ids);
			$getWhere['id']				=	array('in',$id);
			$order						=	$this -> getList($getWhere,array('field'=>'`id`,`order_id`,`order_pic`,`order_state`,`uid`,`usertype`,`order_dkjf`,`coupon`'));
			
			if(!empty($order)){
			    
			    $order_ids = $chekcids =   $couponIds   =  array();   
			    
			    foreach($order as $v){
			        
					if($v['order_id']){
						$order_ids[]       =	$v['order_id'];
					}
					
					$chekcids[]			=	$v['id'];
					if ($v['order_state'] == '1' && !empty($v['coupon'])) {
    			        $couponIds[]   =   $v['coupon'];
					}
				}
				$id = pylode(',', $chekcids);
								
			}else{

				$return['msg']		=  '非法操作！';
				$return['errcode']	=  '8';
				return $return;  
			
			}
			
			$return['id']	=	$this -> delete_all('company_order',array('id' => array('in',$id)),'');
			
			if($return['id']){
				
				$this -> delete_all('invoice_record',array('order_id' => array('in',pylode(',',$order_ids))),'');

				if($data['utype']=='once' && $onceid){
				    
					$this->delete_all('once_job',array('id'=>$onceid), '');
				}
				
				/* 未付款订单删除，返还优惠券  */
				if (!empty($couponIds)) {
				   
				    $this -> update_once('coupon_list', array('status' => 1), array('id' => array('in', pylode(',', $couponIds))));
				}
				
				require_once ('integral.model.php');
				
				$integralM  = new integral_model($this->db, $this->def);
				
				/* 未付款订单删除，返还积分  */
				foreach ($order as $v){
				    if (!empty($v['order_dkjf']) && $v['order_state'] == '1' && $v['order_dkjf']>0) {
				        $integralM -> company_invtal($v['uid'], $v['usertype'], $v['order_dkjf'], true, '取消订单，返还'.$this->config['integral_pricename'], true, 2, 'integral', 66);
				    }
				}
				 
				//取消因跨端支付时产生的新订单，把原订单也删除
				if (!empty($order_ids)){
				    
				    $oldwhere           =   array();
			
				    foreach ($order_ids as $v){
				        if($v != ''){
							$oldwhere['order_remark'][] = array('like',$v,'or');
						}
				    }
				    if(!empty($oldwhere)){
						$this -> delete_all('company_order',$oldwhere,'');
					}
				    
				}
				
				$return['msg']      	=  '充值记录(ID:'.$id.')删除成功';
				$return['errcode']  	=  '9';
				
			}else{
			    
				$return['msg']      	=  '充值记录(ID:'.$id.')删除失败';
				$return['errcode']  	=  '8';
			}
			
		}else{
		    
			$return['msg']      		=  '请选择要删除的记录';
			$return['errcode']  		=  '8';
		}
		return $return;  
	}
	/**
      * @desc 查询全部消费记录信息
      * @param 表：company_pay
      * @param 功能说明：获取company_pay表里面所有信息
      * @param 引用字段：$whereData：条件  2:$data:查询字段
      *
     */
	public function getPayList($whereData, $data = array()) {
		$data['field']	=	empty($data['field']) ? '*' : $data['field'];
        $List			=	$this -> select_all('company_pay', $whereData, $data['field']);
		if (!empty($List)) {
            /* 处理后台所需数据 */
            if ($data['utype']=='admin') {
                $uids   =   array();
                foreach ($List as $v){
					if ($v['com_id'] && !in_array($v['com_id'],$uids)) {
						$uids[$v['com_id']]		= 	$v['com_id'];
					}
				}
				if($uids){
					//  查询用户名
					$mWhere['uid']      =   array('in', pylode(',', $uids));
					$mData['field']     =   '`uid`,`username`';
					$mList              =   $this -> getMemberList($mWhere, $mData);
					
					//  查询企业名称、姓名
					$uWhere['uid']      =   array('in', pylode(',', $uids));
					$UList              =   $this -> getUserList($uWhere);
				}
				include (APP_PATH.'/config/db.data.php');
				
				foreach ($List  as  $k  =>  $v){
					//  分站did字段为空的数据
					if($v['did']    ==  ''){
						$List[$k][did]  =   '0';
					}
					//状态
					$List[$k]['pay_state_n']=$arr_data['paystate'][$v['pay_state']];
					//  用户名
					if (!empty($mList)) {
						foreach ($mList as $va){
							if ($v['com_id']	==	$va['uid']) {
								$List[$k]['username']	=	$va['username'];
							}
						}
					}
					//	企业名称（姓名）
					if (!empty($UList)) {
						foreach ($UList as $va){
							if ($v['com_id']	==	$va['uid'] ) {
								$List[$k]['comname']	=	$va['name'];
							}
						}
					}
				}
			}elseif($data['utype']=='paylog'){	
                include (APP_PATH.'/config/db.data.php');
				foreach ($List  as  $k  =>  $v){
					$List[$k]['pay_time']			=	date('Y-m-d H:i:s',$v['pay_time']);
					$List[$k]['pay_state_n']        = 	$arr_data['paystate'][$v['pay_state']];
					if($v['type']=='1'){
						$List[$k]['order_price'] 	=	intval($v['order_price']);						
					}
				}	
			}elseif($data['utype']=='consume'){	
				include (APP_PATH.'/config/db.data.php');
				foreach ($List  as  $k  =>  $v){
					$List[$k]['sname']			=	$arr_data['paystate'][$v['order_state']];
					$List[$k]['order_type']		=	$arr_data['pay'][$v['order_type']];
				}		
			}else{
				include (APP_PATH.'/config/db.data.php');
				foreach($List as $k=>$v){
					$ptag						=	$v['type']==1?$this->config['integral_priceunit'].$this->config['integral_pricename'] : '元';
					$List[$k]['pricename']   	= 	$this->config['integral_pricename'];
         			$List[$k]['pay_time_n']		=	date('Y-m-d H:i:s',$v['pay_time']);
					$List[$k]['order_price_n']	=	str_replace('.00','',$v['order_price']);
					$List[$k]['consume_remark'] =	$v['pay_remark'];
					$List[$k]['consume_time_n']	=	date('Y-m-d H:i:s',$v['pay_time']);
					$List[$k]['consume_id']		=	$v['order_id'];
					$List[$k]['consume_state_n']=	strip_tags($arr_data['paystate'][$v['pay_state']]);
					$List[$k]['consume_price_n']=	str_replace('.00','',$v['order_price']).$ptag;
				}
            } 

        }
        return $List;
	}
	/**
      * 删除消费记录
      * @param 表：company_pay
      * @param 功能说明：删除company_pay表里面记录
      * @param 引用字段：$id:删除记录
      *
     */
	public function delPay($id){
	    
		if(!empty($id)){
		
		    if(is_array($id)){
				$ids    				=	$id;
				$return['layertype']	=	1;
			}else{
				$ids   				 	=   @explode(',', $id);
				$return['layertype']	=	0;
			}
			
			$id							=   pylode(',', $ids);
			 
			$return['id']				=	$this -> delete_all('company_pay',array('id' => array('in',$id)),'');
			
			if($return['id']){
				$return['msg']      	=  '消费记录(ID:'.$id.')删除成功';
				$return['errcode']  	=  '9';
			}else{
				$return['msg']      	=  '消费记录(ID:'.$id.')删除失败';
				$return['errcode']  	=  '8';
			}
		}else{
			$return['msg']      		=  '请选择要删除的记录';
			$return['errcode']  		=  '8';
		}
		return $return;  
	}
	/**
      * 查询消费值的和
      * @param 表：company_pay
      */
     function getCompanyPaySumPrice($whereData){
      
        $list		=	$this	->	getPayList($whereData);
        $pricearr	=	array();
        $sumprice	=	0;
        foreach($list as $k=>$v){
        	if($v['order_price']){
        		$pricearr[]	=	$v['order_price'];
        	}
        }
        if(is_array($pricearr)){
        	$sumprice	=	array_sum($pricearr);
        }
        
        return $sumprice;
      
     }
	/**
     * @desc    后台充值
     * @param   array   $userarr 充值用户名
     * @param   array   $data
     */
	 
    public function PayMember($userarr,$data) {
        if (!empty($userarr)) {
			$num								=	$data['price_int'];
			$msg								=	$num.$this -> config['integral_pricename']; 
			$fsmsg								=	$data['fs']==1?'充值':'扣除';
			
			if(is_array($userarr)){
				$uidarr							=	array();
				$snum							=	$fnum	=	0;
				foreach($userarr as $k=>$v){
					$member						=	$this -> select_once('member',array('username'=>$v),'uid,usertype');
					if(is_array($member)){
						$snum++;
						$uidarr[$k]['uid']		=	$member['uid'];
						$uidarr[$k]['usertype']	=	$member['usertype'];
						$uids[]					=	$member['uid'];
					}else{
						$fnum++;
						$fname[]				=	$v;
					}
				}
			}
			if(is_array($uidarr)){
				foreach($uidarr as $v){ 
					if($v['usertype']=='1'){
						$table					=	'member_statis';
					}elseif($v['usertype']=='2'){
						$table					=	'company_statis';
					}elseif($v['usertype']=='3'){
						$table					=	'lt_statis';
					}
					
					$nid						=	$this -> pay_member($table,$v['uid'],$num,$data['remark'],$v['usertype'],$data['fs']);
				}
			}
			
			if($nid){
				if($fnum){
					$nummsg						=	'，'.$fnum.'个用户名('.pylode(',',$fname).')不存在';
				}
				return array('errcode'=>'9','msg'=>$snum.'个会员(ID:'.pylode(',',$uids).')'.$fsmsg.$msg.'成功'.$nummsg.'！','url'=>$_SERVER['HTTP_REFERER']);
			}else{
				if($fnum){
					$fmsg						=	'用户名(:'.pylode(',',$userarr).')不存在，';
				}
				return array('errcode'=>'8','msg'=>$fmsg.$fsmsg.'失败！');
			}
        }
    }
	/**
     * @desc 后台充值生成订单
     */
	private function pay_member($table,$uid='',$num,$remark,$usertype,$fs){
		require_once ('statis.model.php');
		$StatisM    				=   new statis_model($this->db, $this->def);
		if($fs==2){
			$statis					=	$StatisM -> getInfo($uid,array('usertype'=>$usertype,'field'=>'pay,integral'));
			if($statis['integral']<$num){
				$num				=	$statis['integral'];
			} 
		}
					
		$dingdan					=	time().rand(10000,99999);
		if($fs==1){//增加  
			$type					=	true;
			$data['integral']		=	array('+',$num);
			$wheres['order_type']	=	'adminpay';
		}else{//扣除  
			$type=false;
			$data['integral']		=	array('-',$num);
			$wheres['order_type']	=	'admincut';
		}
		$wheres['order_id']			=	$dingdan;
		$wheres['order_price']		=	$num/$this->config['integral_proportion'];
		$wheres['order_time']		=	time();
		$wheres['order_state']		=	'2';
		$wheres['order_remark']		=	$remark;
		$wheres['uid']				=	$uid; 
		$wheres['usertype']			=	$usertype; 
		$wheres['type']				=	2; 
		$wheres['integral']			=	$num;

		$nid						=	$StatisM -> upInfo($data,array('uid'=>$uid,'usertype'=>$usertype)); 
		
		if($fs==2)$wheres['type']	=	5;
		if($nid){
			require_once ('integral.model.php');
			$IntegralM 				=	new integral_model($this->db, $this->def);
			$IntegralM -> insert_company_pay($num,2,$uid,$usertype,$remark,1,'',$type);
			
			$nid					=	$this -> insert_into('company_order',$wheres);
		}
		return $nid;
	}
	/**
     * @desc 广告订单
     */
	function adOrder($addData){
		$nid	=	null;
		if($addData['uid']&&$addData['order_id']){
			$nid	=	$this -> addOrder($addData);
		}
		
		
		return $nid;
	}

    /**
     * @desc 生成订单
     * @param $addData
     * @return bool
     */
	public function addOrder($addData){    
		

	    if (!empty($addData) && is_array($addData)) {
            
	        if (!empty($addData['uid'])) {
	            
    	        $where =   array(
    	           
    	            'uid'			=>  intval($addData['uid']),
    	            'order_dkjf'	=>  '0',
    	            'order_price'	=>  $addData['order_price'],
    	            'order_state'	=>  1,
    	            'order_remark'	=>  $addData['order_remark'] ? $addData['order_remark'] : '',
    	            'type'			=>  $addData['type'],
    	            'rating'		=>  $addData['rating'],
    	            'integral'		=>  $addData['integral'] ? $addData['integral'] : '',
    	            'coupon'		=>  0?0:'',
    	            'sid'			=>  '',
    	            'order_info'	=>  '',
    	            'rewardid'		=>  '',
    	            'crm_uid'		=>  '',
    	            'once_id'		=>  '',
    	            'usertype'		=>  $addData['usertype']
    	        );
    	        
    	        $this->delete_all('company_order', $where,'');
	        }
	    }
	    $addData['order_dkjf'] = $addData['order_dkjf']>0 ? $addData['order_dkjf'] : 0;
		$nid	=	$this -> insert_into('company_order',$addData);
		
		return $nid;
	}

    /**
     * @desc 生成dingdan，充值，购买会员，增值服务，
     * @param array $data
     * @return array
     */
	function addComOrder($data = array())
	{

	    if($data['order_price'] || $data['comvip'] || $data['comservice'] || (!empty($data['price_int']) && $data['price_int'] > 0)){
	        
			$data['dkjf'] = $data['dkjf']>0 ? $data['dkjf'] : 0;

			include_once('cookie.model.php');
	        
		    $cookieM  =  new cookie_model($this->db, $this->def);
			$cookieM ->	SetCookie('delay', '', time() - 60);
			
			$oData    =  array();
			
			if($data['comvip']){
			    
			    $msg      =  '购买会员';
			    $breturn  =  $this -> buyVip($data);
			    $oData    =  $breturn;
			    
			    $oData['rating']  =	 $data['comvip'];
			    
			}elseif($data['comservice']){
			    
			    require_once 'statis.model.php';
			    $statisM  =  new statis_model($this->db, $this->def);
			    $statis   =  $statisM -> getInfo($data['uid'],array('usertype' =>$data['usertype']));
			    if (!isVip($statis['vip_etime'])) {
                    
			        return array('msg'=>'你的会员已经到期，请先购买会员！','errcode'=>8);
                }else{
                    
    			    $msg      =  '购买增值服务';
    			    $breturn  =  $this -> buyZzb($data);
    			    $oData    =  $breturn;
    			    
    			    $oData['rating']  =  $data['comservice'];
                }
			}elseif($data['price_int']){
			    
			    $msg      =  '充值'.$this->config['integral_pricename'];
			    $breturn  =  $this -> buyIntegral($data);
			    $oData    =  $breturn;
			}
			$oData['order_id']	    =  time().rand(10000,99999);
			$oData['order_type']	=  $data['paytype'];
			$oData['order_time']    =  time();
			$oData['uid']			=  $data['uid'];
			$oData['usertype']		=  $data['usertype'];
			$oData['did']			=  $data['did'];
			if (!empty($data['order_remark'])){
			    
			    $oData['order_remark'] =  trim($data['order_remark']);
			}
			if(!empty($data['dkjf'])){
			    
			    $oData['order_dkjf']    =  (int)$data['dkjf'];
			    
			    $dkjm                   =  round(($oData['order_dkjf'] / $this->config['integral_proportion']), 2);
			}
			//wap银行支付需要传递一下参数
			if($data['order_type'] == 'bank'){
			    
			    $oData['order_state']	=	'3';
			    $oData['order_type']	=	'bank';
			    $oData['order_pic']		=	$data['order_pic'];
			    $oData['order_bank']	=	$data['order_bank'];
			    $oData['bank_time']		=	$data['bank_time'];
			}else{
			    $oData['order_state']	=	'1';
			}
			//wap使用优惠券时(pc的优惠券是在订单生成之后使用的)
			if($data['coupon']){
				
			    $cData  =  array(
					'uid'       =>  $data['uid'],
					'usertype'  =>  $data['usertype'],
					'coupon'    =>  $data['coupon'],
					'type'      =>  'wap'
				);
			    
			    $creturn  =  $this -> useCoupon($cData, $oData, $msg);
			    
			    if (!empty($creturn) && isset($creturn['errcode'])){
			        
			        return $creturn;
			    }else{
			        $oData['coupon']        =  $creturn['coupon'];
			        $oData['order_price']   =  $creturn['order_price'];
			    }
			}

			if ($data['crm_uid']){
			    $oData['crm_uid']   =   $data['crm_uid'];
            }

			$nid  =  $this -> insert_into('company_order',$oData);
			
			if($nid){
			    // 处理抵扣积分
			    if ($oData['order_dkjf'] > 0){
			        
			        include_once('integral.model.php');
			        $integralM  =  new integral_model($this->db, $this->def);
			        
			        $integralM -> company_invtal($data['uid'],$data['usertype'],$oData['order_dkjf'],false,$msg,true,2,'integral',11);
			    }
			    
			    $msg  .= ',订单ID'.$oData['order_id'];
				$this -> addMemberLog($data['uid'],$data['usertype'],$msg,88);//会员日志

				$return  =  array('msg'=>'下单成功，请付款！','errcode'=>9);
				//pc,wap返回区分
				if($data['type'] == 'wap'){
				    
				    if($data['paytype'] == 'alipay'){
				        
				        $url  =	 $this->config['sy_weburl'].'/api/wapalipay/alipayto.php?dingdan='.$oData['order_id'].'&dingdanname='.$oData['order_id'].'&alimoney='.$oData['order_price'];
				    
				    }elseif($data['paytype'] == 'wxh5'){
				        
				        $url  =  'index.php?c=wxpay&paytype=wxh5&id='.$nid;
				    }
				    $return['url']  =  $url;
				    
				}else{
				    
				    $return['url']  =  'index.php?c=payment&id='.$nid;
				}
				$return['id']  =  $nid;
				
				return $return;
				
			}else{
				$return  =	array('msg'=>'提交失败，请重新提交订单！','errcode'=>8,'url'=>$_SERVER['HTTP_REFERER']);
				return $return;
			}
		}else{
			$return	 =  array('msg'=>'提交失败，请正确提交订单！','errcode'=>8,'url'=>$_SERVER['HTTP_REFERER']);
			return $return;
		}
	}
	/**
	*   银行转账支付，
	*	data内必传参数uid,id：订单id,
	*	wap端需要传递参数wap=1，上传的图片需要preview,如果wap端使用银行卡支付，需要传递isbank=1参数给上面的生成订单方法addComOrder
	*/
	function payComOrderByBank($data = array()){
		
		//数据判断
		if($data['bank_name']==''){
		    
			$return  =  array('msg'=>'请填写汇款银行', 'errcode'=>'8');
			
		}elseif($data['bank_number']==''){
		    
			$return  =  array('msg'=>'请填写汇入账号', 'errcode'=>'8');
			
		}elseif($data['bank_price']==''){
		    
			$return  =  array('msg'=>'请填写汇款金额', 'errcode'=>'8');
			
		}elseif($data['bank_time']==''){
		    
			$return  =  array('msg'=>'请填写汇款时间', 'errcode'=>'8');
			
		}else{
		    
		    $order  =  $this ->	select_once('company_order', array('id'=>$data['id']));
		    
			if ($data['file']['tmp_name'] || $data['base']){
                
                $upArr   =  array(
                    'file'     =>  $data['file'],
                    'dir'      =>  'order',
                    'base'     =>  $data['base'],
                    'preview'  =>  $data['preview']
                );
                
                $result  =  $this -> upload($upArr);
                
                if (!empty($result['msg'])){
                    
                    $return['msg']      =  $result['msg'];
                    $return['errcode']  =  '8';
                    
                    return $return;
                    
                }elseif (!empty($result['picurl'])){
                    
                    $pictures  =  $result['picurl'];
                }
               
            }
		  	unset($data['file']);
		  	unset($data['base']);
		  	unset($data['preview']);
		    if(!isset($pictures)){
		    	$pictures	=	$order['order_pic'];
		    }
		    $orderbank		=	$data['bank_name'].'@%'.$data['bank_number'].'@%'.$data['bank_price'];
		    if($data['bank_time']){
		        $banktime	=	strtotime($data['bank_time']);
		    }else{
		        $banktime	=	'';
		    }
		    $company_order	=	array(
		        'order_type'	=>	'bank',
		        'order_state'	=>	'3',
		        'order_remark'	=>	$data['order_remark'],
		        'order_pic'		=>	$pictures,
		        'order_bank'	=>	$orderbank,
		        'bank_time'		=>	$banktime
		    );
            
            require_once('userinfo.model.php');
            $userinfoM  =   new userinfo_model($this->db,$this->def);
            $userinfo   =   $userinfoM->getUserInfo(array('uid'=>$order['uid']),array('usertype'=>$order['usertype']));
            
            $wxtempMsg  =   '有新的银行转账需要审核';

            switch ($order['usertype']) {
                case '1':
                    $wxtempMsg .= '，个人用户《'.$userinfo['name'].'》 银行转账支付'.$data['bank_price'].'元，请及时查看。';
                    break;
                case '2':
                    $wxtempMsg .= '，企业用户《'.$userinfo['name'].'》 银行转账支付'.$data['bank_price'].'元，请及时查看。';
                    break;
                case '3':
                    $wxtempMsg .= '，猎头用户《'.$userinfo['realname'].'》 银行转账支付'.$data['bank_price'].'元，请及时查看。';
                    break;
                case '4':
                    $wxtempMsg .= '，培训用户《'.$userinfo['name'].'》 银行转账支付'.$data['bank_price'].'元，请及时查看。';
                    break;
                case '5':
                    $wxtempMsg .= '，供求用户《'.$userinfo['name'].'》 银行转账支付'.$data['bank_price'].'元，请及时查看。';
                    break;
                
                
            }

		    // wap端等    (银行转账pc端是先生成订单，然后存入转账数据; wap端生成订单时可能会选择银行转账，有所区别)
		    if($data['wap']){
		        
		        $data	 =  array_merge($data,$company_order);
		        $return  =  $this -> addComOrder($data);
		        
		        if($return['errcode']==9){
                    require_once('admin.model.php');
                    $adminM =   new admin_model($this->db,$this->def);
                    $adminM->sendAdminMsg(array('first'=>$wxtempMsg,'type'=>22));

		            $return['msg']  =   '操作成功，请等待管理员审核！';
		            $return['url']  =   'index.php?c=paylog';

		        }else{
		            $return['url']  =   $_SERVER['HTTP_REFERER'];
		        }
		    }else{
		        // pc端
		        if($order['id']){
		            //pc端提交订单使用优惠券时
		            if($data['coupon']){
		                
		                $cData  =  array(
		                    'uid'       =>  $data['uid'],
		                    'usertype'  =>  $data['usertype'],
		                    'coupon'    =>  $data['coupon'],
						    'type'      =>  'pc'
		                );
		                
		                $creturn  =  $this->useCoupon($cData, $order);
						
                        if (!empty($creturn) && isset($creturn['errcode'])){

                             return $creturn;
                        }else{

                             $company_order['coupon']          =  $creturn['coupon'];
                             $company_order['order_price']     =  $creturn['order_price'];
                        }
                    }

		            $this->upInfo($order['id'],$company_order);
		            $return =   array('msg'=>'操作成功，请等待管理员审核！','errcode'=>9,'url'=>'index.php?c=paylog');

		            require_once('admin.model.php');
                    $adminM =   new admin_model($this->db,$this->def);
                    $adminM->sendAdminMsg(array('first'=>$wxtempMsg,'type'=>22));
		        }else{
		            $return =   array('msg'=>'非法操作！','errcode'=>8,'url'=>$_SERVER['HTTP_REFERER']);
		        }
		    }
			if($order['usertype']==2){
				require_once('company.model.php');
				require_once('crm.model.php');
				$comM     = new company_model($this->db,$this->def);     
				$crmM     = new crm_model($this->db,$this->def); 
				$company  = $comM->getInfo($order['uid'],array('field'=>'`name`,`crm_uid`'));
			  
				if($company['crm_uid'] != '0'){
					$wxcontent  = '您的客户 '.$company['name'].' 银行转账支付'.$data['bank_price'].'元,请及时查看。';
					$crmM ->  sendCrmWxMsg($company['crm_uid'],array('first'=>$wxcontent,'type'=>1));
				}
			}
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
     * @desc 后台充值模块，企业会员开通套餐
     *
     * @param array $data
     * @return array
     */
    public function ComVip($data)
    {
        if ($data['username'] == '' && $data['comname'] == '') {
            return array('errcode' => 8, 'msg' => '用户名和企业名称不能全为空');
        }
        if ($data['ratingid'] == '') {
            return array('errcode' => 8, 'msg' => '请选择开通等级');
        }
        if ($data['vipprice'] == '') {
            return array('errcode' => 8, 'msg' => '请填写开通价格');
        }
        if ($data['username'] != '') {
            $member =   $this->select_once('member', array('username' => $data['username']), 'uid');
            if (!$member) {
                return array('errcode' => 8, 'msg' => '企业用户名(' . $data['username'] . ')不存在');
            }else{
                $comInfo    =   $this->select_once('company', array('uid' => $member['uid']), 'uid,crm_uid');
            }
        } elseif ($data['comname'] != '') {
            $comInfo        =   $this->select_once('company', array('name' => $data['comname']), 'uid,crm_uid');
            if (!$comInfo) {
                return array('errcode' => 8, 'msg' => '企业名称(' . $data['comname'] . ')不存在');
            }
        }

        require_once('rating.model.php');
        $ratingM    =   new rating_model($this->db, $this->def);
        $rating     =   $ratingM->getInfo(array('id' => $data['ratingid']));

        $leijia     =   $data['leijia'];

        $newstatis  =   $ratingM->ratingInfo($rating['id'], $member['uid'], $leijia);

        require_once('statis.model.php');
        $StatisM    =   new statis_model($this->db, $this->def);
        $nid        =   $StatisM->upInfo($newstatis, array('uid' => $member['uid'], 'usertype' => 2));

        if ($nid) {

            $dingdan                =   time() . rand(10000, 99999);
            $order['order_id']      =   $dingdan;
            $order['order_price']   =   $data['vipprice'];
            $order['type']          =   '1';
            $order['order_time']    =   time();
            $order['order_state']   =   '2';
            $order['order_remark']  =   '管理员开通会员套餐';
            $order['uid']           =   $member['uid'];
            $order['usertype']      =   2;
            $order['did']           =   $this->config['did'];
            $order['rating']        =   $rating['id'];
            $order['order_type']    =   'adminpay';
            if (isset($comInfo['crm_uid']) && (int)$comInfo['crm_uid'] > 0){
                $order['crm_uid']   =   $comInfo['crm_uid'];
            }
            $this->insert_into('company_order', $order);

            if (isset($newstatis['integral'])){

                require_once 'integral.model.php';
                $IntegralM  =   new integral_model($this->db, $this->def);
                $addJF      =   $newstatis['integral'][1];
                $IntegralM->insert_company_pay($addJF,2,$member['uid'], 2,'开通会员赠送积分',1,2,true);
            }

            return array('errcode' => 9, 'msg' => '企业会员(ID' . $member['uid'] . ')开通会员套餐【' . $rating['name'] . '】成功', 'url' => $_SERVER['HTTP_REFERER']);
        } else {
            return array('errcode' => 8, 'msg' => '开通会员套餐失败', 'url' => $_SERVER['HTTP_REFERER']);
        }
    }

	/**
     * @desc 后台充值模块，验证开通用户名
     */
	public function SearchName($name){
		if($name){
			$member 									=	$this -> getMemberList(array('usertype'=>2,'username'=>array('like',$name)),array('field'=>'uid,username','limit'=>10));
			if ($member){
				foreach ($member as $v){
					$comid[]							=	$v['uid'];
				}
				require_once ('company.model.php');
				$ComM									=	new company_model($this->db, $this->def);
				$company 								=	$ComM -> getList(array('uid'=>array('in',pylode(',',$comid))),array('field'=>'uid,name','limit'=>10));
				
				foreach ($member as $k=>$v){
					$namelist[$k]['username']			=	$v['username'];
					foreach ($company['list'] as $val){
						if ($v['uid']==$val['uid']){
							$namelist[$k]['comname']	=	$val['name'];
						}
					}
				}
				$data['error']							=	0;
				$data['namelist']						=	$namelist;
			}else{
				$data['error']							=	-1;
			}
		}else{
			$data['error']								=	-1;
		}
		return $data;
	}
	/**
     * @desc 后台充值模块，验证开通企业名
     */	
	public function SearchCom($name){
		if($name){
			require_once ('company.model.php');
			$ComM										=	new company_model($this->db, $this->def);
			$company 									=	$ComM -> getList(array('name'=>array('like',$name)),array('field'=>'uid,name','limit'=>10));
			$company									=	$company['list'];
			if ($company){
				foreach ($company as $v){
					$comid[]							=	$v['uid'];
				}
				$member 								=	$this -> getMemberList(array('uid'=>array('in',pylode(',',$comid))),array('field'=>'uid,username','limit'=>10));
				
				foreach ($company as $k=>$v){
					$namelist[$k]['comname']			=	$v['name'];
					foreach ($member as $val){
						if ($v['uid']==$val['uid']){
							$namelist[$k]['username']	=	$val['username'];
						}
					}
				}
				$data['error']							=	0;
				$data['namelist']						=	$namelist;
			}else{
				$data['error']							=	-1;
			}
		}else{
			$data['error']								=	-1;
		}
		
		return $data;
	}
	/**
      * @desc 查询消费记录（条数）
      * @param 表：company_pay
      * @param 功能说明：查询company_pay表里面记录
      * @param 引用字段：$id:查询记录
      *
      */
    function getCompanyPayNum($whereData){
      
        $companypaynum    =   $this->select_num('company_pay',$whereData);
        
        return $companypaynum;
      
    }
    /**
      * @desc 查询订单条数
      * @param 表：company_order
      * @param 功能说明：查询whereData条件下company_order表条数
      * @param 参数：whereData:查询条件
      *
      */
    function getCompanyOrderNum($whereData){
      
        $companyordernum    =   $this->select_num('company_order',$whereData);
        
        return $companyordernum;
      
    }
    /**
     * @desc 使用充值卡充值
     * @param 表：prepaid_card
     * @param 功能说明：修改prepaid_card，生成订单
     * @param 参数：data:充值卡参数
     *
     */
	function cardOrder($data=array()){
		require_once ('integral.model.php');
		$IntegralM 	=	new integral_model($this->db, $this->def);
		$info		=	$this->select_once('prepaid_card', array('card'=>$data['card'], 'password'=>$data['password']));
		$return 	=	array();
		
		if($data['card']==''){
			
			$return['msg']		=	'请输入卡号！';
			
			$return['errcode']	=	8;
			
		}elseif($data['password']==''){
			
			$return['msg']		=	'请输入密码！';
			
			$return['errcode']	=	8;
			
		}elseif(empty($info)){
			
			$return['msg']		=	'卡号或密码错误！';
			
			$return['errcode']	=	8;
			
		}elseif($info['uid']>0){
			
			$return['msg']		=	'该充值卡已使用！';
			
			$return['errcode']	=	8;
			
		}elseif($info['type']=='2'){
			
			$return['msg']		=	'该充值卡不可用！';
			
			$return['errcode']	=	8;
			
		}elseif($info['stime']>time()){
			
			$return['msg']		=	'该充值卡还未到使用时间！';
			
			$return['errcode']	=	8;
			
		}elseif($info['etime']<time()){
			
			$return['msg']		=	'该充值卡已过期！';
			
			$return['errcode']	=	8;
			
		}else{
			
			$dingdan	=	time().rand(10000,99999);
			$integral	=	$info['quota']*$this->config['integral_proportion'];
			
			$odata['order_id']		=	$dingdan;
			$odata['order_price']	=	$info['quota'];
			$odata['order_time']	=	time();
			$odata['order_state']	=	'2';
			$odata['order_remark']	=	'使用充值卡';
			$odata['uid']			=	$data['uid'];
			$odata['usertype']		=	$data['usertype'];
			$odata['did']			=	$data['did'];
			$odata['integral']		=	$integral;
			$odata['type']			=	'2';
			
			$nid		=	$this->addOrder($odata);
			
			if($nid){
				$IntegralM	->	company_invtal($data['uid'],$data['usertype'],$integral,true,'充值卡充值',true,$pay_state=2,'integral');
				
				$this		->	update_once('prepaid_card',array('uid'=>$data['uid'], 'username'=>$data['username'], 'utime'=>time()), array('id'=>$info['id'])); 
				
				$return['msg']		=	'充值卡使用成功！';
			
				$return['errcode']	=	9;
			}else{
				
				$return['msg']		=	'充值卡使用失败！';
			
				$return['errcode']	=	8;
			}
		}
		
		return $return;
	}
	
	
	/**
	* 取消dingdan
	*/
	function cancelOrder($data){
		
		$return	=	array();
		
		if($data['id']){
			
			$order 	= 	$this->getInfo(array('id'=>$data['id'],'uid'=>$data['uid']),	array('field'=>'`id`,`order_id`'));
			
			if(empty($order)){
				
				$return['msg']		=	'订单不存在！';
				
				$return['errcode']	=	8;
				
				$return['url']		=	$_SERVER['HTTP_REFERER'];
				
			}else{
				require_once ('log.model.php');
				$logM 	= 	new log_model($this->db, $this->def);
				$nid	=	$this->del($data['id'],array('uid'=>$data['uid']));
				
				if($nid){
					$logM->member_log('取消订单',88,3);
					
					$return['msg']		=	'订单取消成功！';
				
					$return['errcode']	=	9;
					
					$return['url']		=	'index.php?c=paylist';
				}else{
					
					$return['msg']		=	'订单取消失败！';
				
					$return['errcode']	=	8;
				
					$return['url']		=	$_SERVER['HTTP_REFERER'];
				}
			}
		}else{
			$return['msg']		=	'系统超时！';
				
			$return['errcode']	=	8;
		
			$return['url']		=	$_SERVER['HTTP_REFERER'];
			
		}
		
		return $return;
		
	}
	
	/**
	* 微信支付--PC
	*/
	function payComOrderByWXPC($data = array())
	{
		$return		=	array();
		
		if(!empty($data) && $data['orderId']){
		    
		    $order	=	$this->select_once('company_order',array('id'=>$data['orderId']));
		    if (!empty($order)){
		        
		        if ($order['order_state'] == '1'){
		            
		            if($data['coupon'] && $order['coupon']==''){
		                
		                $cData  =  array(
		                    'uid'       =>  $data['uid'],
		                    'usertype'  =>  $data['usertype'],
		                    'coupon'    =>  $data['coupon'],
		                    'type'      =>  'pc'
		                );
		                
		                $creturn  =  $this->useCoupon($cData, $order);
		                
		                if (!empty($creturn) && isset($creturn['errcode'])){
		                    
		                    return $creturn;
		                }else{
		                    
		                    $oData['coupon']       =  $creturn['coupon'];
		                    $oData['order_price']  =  $creturn['order_price'];
		                }
		            }
		            // 订单未被关闭
		            if ($order['order_state'] != 4){
		                
		                // 微信h5或微信小程序生成的订单，需要将原订单关闭，然后重新生成订单
		                if ($order['order_type'] == 'wxh5' || $order['order_type'] == 'wxxcx'){
		                    
		                    $order  =  $this -> wxPayChange($order['id'], array('paytype'=>'wxpay','port'=>'1'));
		                    
		                }else{
		                    // 非h5和小程序支付的，修改订单支付类型为微信扫码支付
		                    $oData['order_type']  =  'wxpay';
		                }
		            }
		            
		            if (!empty($oData)){
		                
		                $this->update_once('company_order', $oData, array('id'=>$order['id']));
		            }
		            if($order['order_price'] > 0){
		                if($this->config['wxpay']=='1'){
		                    require_once(LIB_PATH.'wxOrder.function.php');
		                    $wxUrl	=	wxOrder(array('body'=>'充值','id'=>$order['order_id'],'url'=>$this->config['sy_weburl'],'total_fee'=>$order['order_price']));
		                }
		            }
		            if(isset($wxUrl)){
		                $return['msg']	    =  "<img src=\"".$this->config['sy_weburl']."/index.php?m=ajax&c=wxpaycode&data=".$wxUrl."\" width=\"210\" height=\"210\">";
		                $return['msg']	    .=  '<input type="hidden" id="new_order_id" value="'.$order['id'].'" />';
		                $return['errcode']  =  1;
		            }else{
		                $return['msg']	    =  '二维码生成失败<br>请联系客服 '.$this->config['sy_freewebtel'];
		                $return['errcode']  =  8;
		            }
		        }else {
		            
		            $return['msg']  =  '订单已付款';
		            $return['errcode']  =  8;
		        }
		    }else {
		        
		        $return['msg']      =  '订单不存在';
		        $return['errcode']  =  8;
		    }
		}else{
			$return['msg']	    =  '参数不正确，请正确填写！';
			$return['errcode']  =  8;
		}
		
		return $return;
	}
	
	/**
	* 微信支付--WAP
	*/
	function payComOrderByWXWAP($data = array()){
	    
		$return		=	array();
		
		if(!empty($data)){
		    
		    $order	=	$this->select_once('company_order',array('id'=>$data['orderId']));
			
			if(!empty($order)){
				
                // 订单未被关闭
			    if ($order['order_state'] != 4){
			        // 微信扫码或微信小程序生成的订单，需要将原订单关闭，然后重新生成订单
			        if ($order['order_type'] == 'wxpay' || $order['order_type'] == 'wxxcx'){
			            
			            $order  =  $this -> wxPayChange($order['id'], array('paytype'=>'wxh5','port'=>'1'));
			            
			            return array('newOrderId'=>$order['id']);
			        }else{
			            // 手机提交的订单，修改订单支付类型为微信h5支付
			            $this -> upInfo($order['id'],array('order_type'=>'wxh5'));
			        }
			    }
			    
				require_once(LIB_PATH.'wxOrder.function.php');

				if(!is_weixin()){
					$jsApiParameters	=	wxWapOrderMweb(array('body'=>'充值','id'=>$order['order_id'],'url'=>$this->config['sy_weburl'],'total_fee'=>$order['order_price']));

					if($jsApiParameters['mweb_url']){
					    
					    $user_agent  =  (!isset($_SERVER['HTTP_USER_AGENT'])) ? FALSE : $_SERVER['HTTP_USER_AGENT'];
					    if (isset($data['source']) && (!empty($user_agent) && !preg_match("/(huaweibrowser)/i", strtolower($user_agent)))){
					        // 有来源参数，并且不是华为浏览器的
					        $return['header']	=	'Location: '.$jsApiParameters['mweb_url'];
					        $return['id']	    =	$order['id'];
					    }else{
					        $return['header']	=	'Location: '.$jsApiParameters['mweb_url'].'&redirect_url='.urlencode($this->config['sy_wapdomain'].'/member/index.php?c=pay&id='.$order['id']);
					    }
					
					}else{
						
						if($jsApiParameters['err_code_des']){
							$return['msg']	=	$jsApiParameters['err_code_des'];
							
						}elseif($jsApiParameters['return_msg']){
							$return['msg']	=	$jsApiParameters['return_msg'];
						}else{
							$return['msg']	=	'支付失败';
							
						}
						$return['url']		=	'index.php';
					}
				}else{
					$jsApiParameters  =  wxWapOrder(array('body'=>'充值','id'=>$order['order_id'],'url'=>$this->config['sy_weburl'],'total_fee'=>$order['order_price']));

					if($jsApiParameters){
						
						$return['jsApiParameters']  =	$jsApiParameters;

					}else{
						$return['msg']				=	'支付失败，请重新支付！';
						$return['url']				=	$_SERVER['HTTP_REFERER'];
						
					}
				}
				
			}else{
				$return['msg']	=	'参数不正确，请正确填写！';
				$return['url']	=	$_SERVER['HTTP_REFERER'];
			}
			
		}else{
			$return['msg']	=	'参数不正确，请正确填写！';
			$return['url']	=	$_SERVER['HTTP_REFERER'];
		}
		
		return $return;
	}
	
	/**
	* 生成培训报名订单
	*/
	function addBaomingOrder($data=array()){
		
		$return 								=		array('cod'=>8 , 'url'=>$_SERVER['HTTP_REFERER']);
		
		
		if(!empty($data)){
			
			require_once ('train.model.php');
					
			$trainM 							= 		new train_model($this->db, $this->def);
			
			/* 获取课程 */	
			$info								=		$trainM->getSubInfo(array('id'=>(int)$data['sid']));
			
			if(!$data['uid']){
				
				$return['msg']					=		'您还没有登录，请先登录！';	
				
				return	$return;
				
			}elseif($data['usertype']==4){
				
				$return['msg']					=		'只有个人用户和hr才可以报名！';	
				
				return	$return;
				
			}elseif($info['status']!='1'){
				
				$return['msg']					=		'该课程还未通过审核！';	
				
				return	$return;
				
			}else if($info['pause_status']=='2'){
				
				$return['msg']					=		'该课程已下架！';	
				
				return	$return;
				
			}
				
			/* 获取报名 */	
			$row								=		$trainM->getBmInfo(array('uid'=>$data['uid'],'sid'=>$data['sid']));
			
			if(empty($row)){
			
				$baomingid						=		$trainM->addBaoming(array('uid'=>$data['uid'],'sid'=>$data['sid'],'s_uid'=>$data['s_uid'],'name'=>$data['name'],'phone'=>$data['phone'],'content'=>$data['content'],'ctime'=>time(),'did'=>$data['did'],'usertype'=>$data['usertype']));
				
				$member							=		$this -> select_once('member',array('uid'=>$data['uid']) , '`username`');
				
				if($data['isprice']==1){
					$dingdan					=		time().rand(10000,99999);
					$odata['order_id']			=		$dingdan;
					$odata['order_price']		=		$data['price'];
					$odata['order_time']		=		time();
					$odata['order_state']		=		'1';
					$odata['order_remark']		=		$data['content'];
					$odata['uid']				=		$data['uid'];
					$odata['usertype']			=		$data['usertype'];
					$odata['did']				=		$data['did'];
					$odata['type']				=		6;
					$odata['sid']				=		$baomingid;
					
					$id							=		$this->insert_into('company_order',$odata);
					
					if($id){
						
						$this->addMemberLog($data['uid'],$data['usertype'],'培训报名，订单ID'.$dingdan,88);
						
						$this->insert_into('sysmsg',array('fa_uid'=>$data['uid'],'content'=>'用户 '.sub_string($member['username']).' 报名课程：'.$info['name'].'提交订单成功','username'=>$member['username'],'usertype'=>$data['usertype'],'ctime'=>time(),'remind_status'=>0));
						
						$return['msg']			=		'下单成功，请付款！';
						
						$return['cod']			=		9;
						
						if($data['utype']=='wap'){
							
							$return['url']		=		Url('wap',array('c'=>'payment','id'=>$id),'member');
							
						}else{
							
							$return['url']		=		$this->config['sy_weburl'].'/member/index.php?c=payment&id='.$id;
							
						}
						
					}else{
						
						$return['msg']			=		'提交失败，请重新报名课程！';
						
					}
				}else{
					$this->insert_into('sysmsg',array('fa_uid'=>$data['uid'],'content'=>'用户 '.sub_string($member['username']).' 报名课程：'.$info['name'].'提交订单成功','username'=>$member['username'],'usertype'=>$data['usertype'],'ctime'=>time(),'remind_status'=>0));
						
					$return['msg']				=		'报名成功！';
							
					$return['cod']				=		9;
				}
				
			}else{
				  $return['msg']				=		'请不要重复报名！';
			}
		
		}else{
			$return['msg']						=		'提交失败，请重新报名课程！';
			
		}
		
		return $return ;
		
	}	
	/**
	 * 处理微信支付跨端，将原订单关闭，重新生成订单
	 * $oid 原订单ID;  paytype 现支付方式; port : 端口1-PC 2-WAP
	 */
	public function wxPayChange($oid, $data = array('paytype'=>null,'port'=>null))
	{
	    
	    if (!empty($oid)){
	        
	        $order  =  $this->select_once('company_order',array('id'=>$oid));
	        
	        if (!empty($order)){
	            
	            unset($order['id']);
	            
	            $newOrder                  =  $order;
	            $newOrder['order_time']		=  time();
	            $newOrder['order_id']		=  time().rand(10000,99999);
	            $newOrder['order_type']		=  $data['paytype'];
	            $newOrder['order_remark']	=  '微信跨端支付生成新订单，原充值单号('.$order['order_id'].')';
				$newOrder['port']			=	$data['port'];
	            $nid  =  $this->insert_into('company_order',$newOrder);

	            //新订单生成成功返回新订单数据，生成失败返回原有数据
	            if ($nid){
	                
	                // 将原订单关闭并且把优惠券清空，优惠价格加上，防止出现优惠券多次使用
	                $up  =  array(
	                    'order_state'   =>  4,
	                    'coupon'        =>  '',
	                    'order_remark'  =>  $order['order_remark'].' 用户微信支付跨端，本订单关闭，新充值单号('.$newOrder['order_id'].')'
	                );
	                
	                $coupon  =  $this -> select_once('coupon_list',array('id'=>$order['coupon']),'`coupon_amount`');
	                
	                if (!empty($coupon)){
	                    
	                    $up['order_price']  =  $order['order_price'] + $coupon['coupon_amount'];
	                }
	                
	                $this -> update_once('company_order', $up, array('id'=>$oid));
	                
	                $newOrder['id']  =  $nid;
	                
	                return $newOrder;
	                
	            }else{
	                $order['id']  =  $oid;
	                
	                return $order;
	            }
	        }
	    }
	}
	/**
	 * 生成订单积分充值处理
	 * @param $data (price_int | integralid)
	 * @return  $return (type | price | integral)
	 */
	private function buyIntegral($data = array())
	{
	    $return      =  array();
	    
	    if(!empty($data['price_int'])){
	        
	        $integral	   =  $data['price_int'];
	        $min_recharge  =  $this->config['integral_min_recharge'];
	        // 最低充值积分非无限，且充值积分小于最低限制，积分自动为最低充值积分
	        if (!empty($min_recharge) &&  $min_recharge > 0 && $integral < $min_recharge){
	            
	            $integral  =  $this->config['integral_min_recharge'];
	        }
	        
	        // 选择已有充值类别
	        if (!empty($data['integralid'])){
	            
				//优惠折扣类别
	            $integralid	   =  $data['integralid'];

	            $CacheMclass   =  $this -> getCache(array('integralclass'));

				//验证购买积分是否与折扣对应积分相符
				$integralNum	=  $CacheMclass['integralclass_name'][$integralid];

				if($integral >= $integralNum){

					$discount      =  $CacheMclass['integralclass_discount'][$integralid]/100;
					if ($discount > 0){//充值优惠
						$price 	   =  $integral/$this->config['integral_proportion'] * $discount;
					}else{
						$price	   =  $integral/$this->config['integral_proportion'];
					}
				}else{
				
					$price	   =  $integral/$this->config['integral_proportion'];
				}
	            
	        }else{
	            
	            // 手动填写充值数量
	            $price	   =  $integral/$this->config['integral_proportion'];
	            
	        }
	        
	        $return['type']          =  2;
	        $return['integral']      =  $integral;
	        $return['order_price']   =  round($price,2);
			
	    }
	    return $return;
	}
	/**
	 * 生成订单购买会员套餐处理
	 * @param $data (uid | comvip | dkjf)
	 * @return  $return (type | price)
	 */
	private function buyVip($data = array())
	{
	    $return  =  array();
	    
	    if(!empty($data['comvip']) && !empty($data['uid'])){
	        
	        $rating     =  $this -> select_once('company_rating',array('id'=>(int)$data['comvip']));
	        
	        if($rating['time_start']<time() && $rating['time_end']>time()){
	            $price	=  $rating['yh_price'];
	        }else{
	            $price	=  $rating['service_price'];
	        }
	        
	        $dkjf		=	(int)$data['dkjf'];
	        
	        $statis = $this	->	select_once('company_statis',array('uid'=>(int)$data['uid']),'`integral`');
	        
	        if(!empty($statis) && ($dkjf >= (int)$statis['integral'])){
	            $dkjf	=	$statis['integral'];
	        }
	        
	        if($dkjf){
	            $dkprice	=	$dkjf / $this->config['integral_proportion'];
	            $price		=	$price - $dkprice;
	        }
	        $return['type']	         =  1;
	        $return['order_price']   =  round($price,2);
	    }
	    return $return;
	}
	/**
	 * @desc 生成订单购买增值包
	 * @param $data (uid | comservice | dkjf)
	 * @return $return (type | price)
	 */
	private function buyZzb($data = array())
	{
	    
	    $return  =  array();
	    
	    if(!empty($data['comservice']) && !empty($data['uid'])){
	        
	        $id		  =  (int)$data['comservice'];
	        $dkjf	  =  (int)$data['dkjf'];
	        
	        $statis   =  $this -> select_once('company_statis',array('uid'=>(int)$data['uid']),'`integral`,`rating`,`vip_etime`');
	        $rating   =  $this -> select_once('company_rating',array('id'=>$statis['rating']));
	        $detail   =  $this -> select_once('company_service_detail',array('id'=>$id));
	        $service  =  $this -> select_once('company_service',array('id'=>$detail['type']));
	        
	        if($rating['service_discount']>0 && $rating['service_discount']<100){
	            
	            $price	=  round($detail['service_price']*($rating['service_discount']/100),2);
	            
	        }else{
	            
	            $price	=	$detail['service_price'];
	        }
	        if(!empty($statis) && ($dkjf >= (int)$statis['integral'])){
	            $dkjf	=	(int)$statis['integral'];
	        }
	        if($dkjf){
	            $dkprice	=	$dkjf / $this->config['integral_proportion'];
	            $price		=	$price - $dkprice;
	        }
	        $return['type']	        =  5;
	        $return['order_price']  =  round($price,2);
	    }
	    return $return;
	}

    /**
     * @desc 生成订单使用优惠券
     * @param array $data (uid | usertype)
     * @param array $oData "订单参数"
     * @param string $msg
     * @return array (coupon | order_price) | (msg | url)
     */
	public function useCoupon($data = array(), $oData = array(), $msg = '')
	{
	    $return  =  array();
	    // pc使用优惠券，查询订单数据(wap使用优惠券时，订单还未生成，传入$oData数组)
	    if (!empty($data['id']) && empty($oData)){
	        
	        $oData  =  $this -> select_once('company_order', array('id'=>$data['id']));
	    }
	    if (!empty($data['uid']) && !empty($data['coupon']) && !empty($oData['order_price'])){
	        
	        //订单使用优惠券
	        $cwhere  =  array(
	            'id'   =>  $data['coupon'],
	            'uid'  =>  $data['uid']
	        );

	        $coupon = $this	-> select_once('coupon_list', $cwhere);
	        
	        if (!empty($coupon)){
	            
	            if ($coupon['validity'] > time()){
	                
	                if ($coupon['status'] == 1){
	                    
	                    if ((int)$coupon['coupon_scope'] <= (int)$oData['order_price']){
	                        
	                        if ((int)$coupon['coupon_amount'] < (int)$oData['order_price']){
	                            // 使用优惠券后价格依然大于0
	                            $return['coupon']       =  $coupon['id'];
	                            $return['coupon_name']  =  $coupon['coupon_name'];
	                            $return['order_price']	=	sprintf('%.2f', $oData['order_price'] - $coupon['coupon_amount']);
	                            
	                            $this -> update_once('coupon_list',array('status'=>'2','xf_time'=>time()),array('id'=>$coupon['id']));
	                            
	                        }elseif ((int)$oData['order_price'] <=(int)$coupon['coupon_amount']){
	                            
	                            //使用优惠券后价格为0时
	                            require_once('qrorder.model.php');
	                            
	                            $qrorderM  =  new qrorder_model($this->db, $this->def);
	                            
	                            $status    =  $qrorderM -> upuser_statis($oData);
	                            
	                            if($status){
	                                
	                                $oData['coupon']        =  $coupon['id'];
	                                $oData['order_price']   =  0;
	                                $oData['order_state']   =  2;
	                                $oData['order_type']    =  'balance';
	                                $oData['order_remark'] .=  '使用'.$coupon['coupon_name'];
	                                
	                                if ($oData['id']){
	                                    
	                                    unset($oData['id']);
	                                    
	                                    $nid  =  $this -> update_once('company_order', $oData, array('id'=>$oData['id']));
	                                    
	                                }else{
	                                    
	                                    $nid  =  $this -> insert_into('company_order', $oData);
	                                }
	                                
	                                if ($nid){
	                                    // 处理抵扣积分，pc订单结算之前已经处理了抵扣积分，此处只有wap需要处理
	                                    if ($data['type'] == 'wap' && $oData['order_dkjf'] > 0){
	                                        
	                                        include_once('integral.model.php');
	                                        $integralM  =  new integral_model($this->db, $this->def);
	                                        
	                                        $integralM -> company_invtal($data['uid'],$data['usertype'],$oData['order_dkjf'],false,$msg,true,2,'integral',11);
	                                    }
	                                    
	                                    $msg  .= ',订单ID'.$oData['order_id'];
	                                    
	                                    $this -> addMemberLog($data['uid'],$data['usertype'],$msg,88);//会员日志
	                                    $this -> update_once('coupon_list',array('status'=>'2','xf_time'=>time()),array('id'=>$coupon['id']));
	                                }
	                                
	                                $return['msg']	    =  '购买成功';
	                                $return['errcode']	=  9;
	                                
	                                if ($data['type'] == 'pc'){
	                                    
	                                    $return['url']	    =  Url('member',array('c'=>'paylog'));
	                                    
	                                }elseif ($data['type'] == 'wap'){
	                                    
	                                    $return['url']	    =  Url('wap',array('c'=>'paylog'),'member');
	                                }
	                                $status  =  '1';
	                            }else{
	                                $return['msg']	    =  '购买失败！';
	                                $return['errcode']	=  8;
	                                $return['url']	    =  $_SERVER['HTTP_REFERER'];
	                                
	                                $status	 =  '2';
	                            }
	                        }
	                    }else {
	                        
	                        $return['msg']	    =  '没有达到优惠券使用条件';
	                        $return['errcode']	=  8;
	                        $return['url']	    =  $_SERVER['HTTP_REFERER'];
	                    }
	                }else{
	                    
	                    $return['msg']	    =  '优惠券已被使用';
	                    $return['errcode']	=  8;
	                    $return['url']	    =  $_SERVER['HTTP_REFERER'];
	                }
	            }else {
	                
	                $return['msg']	    =  '优惠券已过期';
	                $return['errcode']	=  8;
	                $return['url']	    =  $_SERVER['HTTP_REFERER'];
	            }
	        }else {
	            $return['msg']	    =  '优惠券使用错误';
	            $return['errcode']	=  8;
	            $return['url']	    =  $_SERVER['HTTP_REFERER'];
	        }
	    }
	    return $return;
	}

    /**
     * @desc 分配到业务员
     * @param array $upData
     * @param array $data
     * @return array
     */
    function setCrm($upData = array(), $data = array())
    {

        $return         =   array();

        if (!empty($data) && !empty($upData)) {

            $ID         =   $data['id'];
            $crm_uid    =   $upData['crm_uid'];
            $adminUser  =   $this->select_once('admin_user', array('uid' => $crm_uid), '`name`');

            $where['PHPYUNBTWSTART_A']  =   '';
            $where['crm_uid'][]         =   array('=', 0, '');
            $where['crm_uid'][]         =   array('isnull', '', 'or');
            $where['PHPYUNBTWEND_A']    =   '';

            $where['id']                =   array('in', $ID);

            $result     =   $this->update_once('company_order', $upData, $where);

            if ($result) {

                require_once ('log.model.php');
                $logM	    =	new log_model($this->db, $this->def);
                $msgContent	=	'管理员将订单（ID：'.$ID.'）分配给了业务员：' . $adminUser['name'];
                $logM -> addAdminLog($msgContent);
            }

            $return['errcode']  =   $result ? '9' : '8';
            $return['msg']      =   $result ? '订单分配成功！' : '订单分配失败！';
        }

        return $return;
    }
}
?>