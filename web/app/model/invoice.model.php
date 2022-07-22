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
class invoice_model extends model{
	/**
      * 查询发票信息
      * @param 表：invoice_info
      * @param 功能说明：获取invoice_info表里面所有申请发票记录信息
      * @param 引用字段：$whereData：条件  2:$data:查询字段
      *
     */
	function getInvoiceInfo($whereData , $data=array() ) {
        $select		=   $data['field'] ? $data['field'] : '*';
        $List		=   $this -> select_once('invoice_info', $whereData, $select);
        
        return $List;
    }
    /**
      * 添加或更新发票信息
      * @param 表：invoice_info
      * @param 功能说明：获取invoice_info表里面所有申请发票记录信息
      * @param 引用字段：$whereData：条件  2:$addData:添加字段，3:$data自定义
      *
     */
    function addInvoiceInfo($whereData=array(),$addData=array(),$data=array()){
    	if($addData['invoicetitle']==""){
			$return	=	array('msg'=>"发票抬头不能为空！",'cod'=>8);
		}
		if($addData['invoicetype']==''){
			$return	=	array('msg'=>"请选择发票类型！",'cod'=>8);
		}
		
		if($addData['registerno']==""){
			$return	=	array('msg'=>"请填写企业税号！",'cod'=>8);
		} 
		
		if($addData['invoicetype'] == 2){//专用增值税票，必填项，普票选填
			
			if($addData['bank']==""){
				$return	=	array('msg'=>"请填写开户银行名称！",'cod'=>8);
			}
			if($addData['bankno']==""){
				$return	=	array('msg'=>"请填写开户账号！",'cod'=>8);
			}
			if($addData['opaddress']==""){
				$return	=	array('msg'=>"注册场所在地不能为空！",'cod'=>8);
			}
			if($addData['opphone']==""){
				$return	=	array('msg'=>"注册固定电话不能为空！",'cod'=>8);
		 	}
		}
		
		if($addData['invoicestyle']==''){
			$return	=	array('msg'=>"请选择发票开票性质！",'cod'=>8);
		}
		
		if($addData['linkman']==""){
			$return	=	array('msg'=>"联系人不能为空！",'cod'=>8);
		}
		if($addData['invoicestyle']=='1'){
			if($addData['street']==""){
				$return	=	array('msg'=>"邮寄地址不能为空！",'cod'=>8);
			}
			if($addData['phone']==""){
				$return	=	array('msg'=>"请填写联系人手机号码！",'cod'=>8);
			}elseif(!CheckMobile($addData['phone'])){
				$return	=	array('msg'=>"手机号码格式错误！",'cod'=>8);
		      	
		   	}
		}else if($addData['invoicestyle']=='2'){
			if($addData['email']==""){
				$return	=	array('msg'=>"请填写电子邮箱！",'cod'=>8);
			}
		}
	 	
	   	if(empty($return)){
			if(!count($whereData)){
		   		$nid	=	$this	->	insert_into("invoice_info",$addData);
		   		$name	=	"添加发票信息";
				$type	=	'1';
		   	}else{
		   		$nid	=	$this	->	update_once("invoice_info",$addData,$whereData);
		   		$name	=	"更新发票信息";
				$type	=	'2';
		   	}
		   	if($nid){
				$return	=	array('msg'=>$name."成功！",'cod'=>9,'url'=>$_SERVER['HTTP_REFERER']);
			}else{
				$return	=	array('msg'=>$name."失败！",'cod'=>8,'url'=>$_SERVER['HTTP_REFERER']);
			}
		}
	   	
	   	return $return;
    }
	 /**
     * 获取invoice_record      申请发票记录详情
     * $whereData       查询条件
     * $data            自定义处理数组
     */
	public function getRecordInfo($id,$data=array()){
	    $field		=	empty($data['field']) ? '*' : $data['field'];
	    if (!empty($id)) {
	        $info	=	$this -> select_once('invoice_record',array('id'=>intval($id)), $field);
	        if($info && is_array($info)){
				if($info['price']==''){
					//发票金额为空时，调用订单里的金额
					require_once ('companyorder.model.php');
					$ComOrderM 		=	new companyorder_model($this->db, $this->def);
					$order			=	$ComOrderM -> getInfo(array('id'=>$info['oid']), array('field'=>'order_price'));
					
					$info['price']	=	$order['order_price'];
				}
	            return $info;
            }
	    } 
	}
    /**
     * 获取invoice_record      申请发票记录条数
     * $whereData       查询条件
     */
    public function getRecordNum($whereData){
        $num = $this -> select_num('invoice_record', $whereData);
        return $num;
    }
	/**
      * 查询全部信息
      * @param 表：invoice_record
      * @param 功能说明：获取invoice_record表里面所有申请发票记录信息
      * @param 引用字段：$whereData：条件  2:$data:查询字段
      *
     */
	public function getRecordList($whereData , $data=array() ) {
        $select		=   $data['field'] ? $data['field'] : '*';
        $List		=   $this -> select_all('invoice_record', $whereData, $select);
        if (!empty($List)) {
            /* 处理后台所需数据 */
            if ($data['utype']=='admin') {
                $List	=	$this -> getDataList($List);
            } 
            /* 处理会员中心所需数据 */
            if ($data['utype']=='member') {
                
				foreach($List as $k=>$v){
					$orderId[] = $v['order_id'];
				}
				$oWhere['id']      	=   array('in', pylode(',', $orderId));
       			$oData['field']     =   '`order_id`,`order_price`';
       			$oList              =   $this -> getOrderList($oWhere, $oData);

				foreach($List as $k=>$v){
					foreach($oList as $val){
						if((int)$v['order_id']==(int)$val['order_id'] && $v['price']==""){
							$List[$k]['price']=$val['order_price'];
						}
					}
					$List[$k]['addtime_n']=date('Y-m-d H:i:s',$v['addtime']);
				}
				
            }
        }
        return $List;
    }
    /**
      * 申请发票
      * @param 表：invoice_record
      * @param $addData:添加字段，3:$data自定义,uid为必要参数
      *
     */
    function addRecord($addData=array(),$data=array()){
    	$info	=	$this	->	getInvoiceInfo(array('uid'=>$data['uid']));
    	if(empty($info)){
    		$return	=	array('msg'=>"请先完善发票信息！",'cod'=>8,'error'=>10);
    	}elseif($addData['price']	<	$this->config['sy_com_invoice_money']){
    		$return	=	array('msg'=>'超过'.$this->config['sy_com_invoice_money'].'元才能申请发票','cod'=>8,'error'=>11);
		}
    	
		if(empty($return)){
			$nid	=	$this	->	insert_into("invoice_record",$addData);
			if($nid){
				$this	->	update_once("company_order",array('is_invoice'=>'1'),array('order_id'=>array('in',$addData['order_id']),'uid'=>$data['uid']));
				$return	=	array('msg'=>"申请成功！",'cod'=>9,'error'=>1);
			}else{
				$return	=	array('msg'=>"申请失败！",'cod'=>8,'error'=>12);
			}
		}
	 	return $return;
    }
	 /**
      * 审核申请发票
      * @param  表：invoice_record
      * @param 功能说明：根据条件$id 审核invoice_record表里面信息
      * @param 引用字段：$id :条件 2:$data['status']:审核状态
      *
     */
	public function setStatus($whereData,$data = array('post'=>null)){
	    if (!empty($whereData)){
	        
	        $post	=	$data['post'];
	        $nid	=	$this -> update_once('invoice_record',$post,$whereData);
	        
	        if ($nid){
				 
				$List			=   $this -> getRecordList($whereData, array('field' => '`uid`'));
				/* 消息前缀 */		
				$tagName  				=	'您申请的发票';

				if(!empty($List)){

					foreach($List as $v){
						
						 $uids[]  =  $v['uid'];
									
						/* 处理审核信息 */
						if ($post['status'] == 2){
							
							$statusInfo  =  $tagName.':审核未通过';
							
							if($post['statusbody']){
								
								$statusInfo  .=  ' , 原因：'.$post['statusbody'];
								
							}
							
							$msg[$v['uid']][]  =  $statusInfo;
							
						}elseif($post['status'] == 1){
							
							$msg[$v['uid']][]  =  $tagName.':已审核通过';
							
						}elseif($post['status'] == 3){
							
							$msg[$v['uid']][]  =   $tagName.':已打印';
						}elseif($post['status'] == 4){
							
							$msg[$v['uid']][]  =   $tagName.':已邮寄';	
						}
					}
					//发送系统通知
					include_once('sysmsg.model.php');
	                
	                $sysmsgM  =  new sysmsg_model($this->db, $this->def);
					
					$sysmsgM -> addInfo(array('uid'=>$uids,'usertype'=>2, 'content'=>$msg));

				}
				
	            $return['msg']      =  '发票审核设置成功';
	            $return['errcode']  =  '9';
	            
	        }else{
	            $return['msg']      =  '发票审核设置失败';
	            $return['errcode']  =  '8';
	        }
	    }else{
	        $return['msg']      =  '请选择要审核的记录';
	        $return['errcode']  =  '8';
	    }

	    return $return;
	}
	/**
      * 删除申请记录
      * @param 表：invoice_record
      * @param 功能说明：删除invoice_record表里面记录
      * @param 引用字段：$id：删除记录
      */
	public function del($id,$whereData=array())
	{
	
		if(!empty($id) || !empty($whereData)){
			

			if(!empty($whereData)){
			
				$return['layertype']	=	0;
				$return['id']			=	$this -> delete_all('invoice_record',$whereData,'');
			}else{

				if(is_array($id)){
					$ids				=	$id;
					$return['layertype']=	1;
				}else{
					$ids				=   @explode(',', $id);
					$return['layertype']=	0;
				}
				
				$id	=	pylode(',', $ids);
				
				$return['id']	=	$this -> delete_all('invoice_record',array('id' => array('in',$id)),'');
			}
			
			if($return['id']){
				
				$return['msg']		=  '发票记录(ID:'.$id.')删除成功';
				$return['errcode']	=  '9';
			}else{

				$return['msg']		=  '发票记录(ID:'.$id.')删除失败';
				$return['errcode']	=  '8';
			}
		}else{
			$return['msg']			=  '请选择要删除的记录';
			$return['errcode']		=  '8';
		}
		return $return;  
	}
	/**
     * @desc    查询invoice_record表内没有的数据，引用相关类，查询关联表，提取列表数据所需信息
     * @param   array $List 
     */
    private function getDataList($List) {
        $uids   =   $oid    =   array();
        foreach ($List as $v){
			if ($v['uid'] && !in_array($v['uid'],$uids)) {
                $uids[$v['uid']]	= 	$v['uid'];
            }
            if ($v['oid'] && !in_array($v['oid'],$oid)) {
                $oid[$v['oid']]		= 	$v['oid'];
            }
        }
        //  查询company_order订单金额
        $oWhere['id']      	=   array('in', pylode(',', $oid));
        $oData['field']     =   '`order_price`,`id`';
        $oList              =   $this -> getOrderList($oWhere, $oData);
        
        //  查询company企业名称
        $cWhere['uid']      =   array('in', pylode(',', $uids));
        $cData['field']     =   '`uid`,`name`';
        $cList              =   $this -> getComList($cWhere, $cData);
        
        //  查询lt_info真实姓名
        $lWhere['uid']      =   array('in', pylode(',', $uids));
        $lData['field']     =   '`uid`,`realname` as name';
        $lList              =   $this -> getLtList($lWhere, $lData);

        //合并company、lt_info查询数组
		$mList=array_merge($cList,$lList);
		
        foreach ($List  as  $k  =>  $v){
            //  分站did字段为空的数据
            if($v['did']    ==  ''){
                $List[$k][did]  =   '0';
            }
            
            //  提取发票申请人姓名查询数据
            if (!empty($mList)) {
				$clList    =   $mList['list'];
                foreach ($clList as $mv){
                    if ($v['uid']	==	$mv['uid']) {
                        $List[$k]['comname']	=	$mv['name'];
                    }
                }
            }
            
            //	若开票总额为空，则提取company_order查询数据，开票总额
            if (!empty($oList)) {
                foreach ($oList as $ov){
                    if ($v['oid']	==	$ov['id'] && $v['price']=='') {
						$List[$k]['price']		=	$ov['order_price'];
                    }
                }
            }
        }
        return $List;
    }

	/**
     * @desc   引用companyorder类，查询company_order列表信息   
     */
    private function getOrderList($whereData = array(), $data = array()) {
        require_once ('companyorder.model.php');
        $ComOrderM = new companyorder_model($this->db, $this->def);
        return  $ComOrderM -> getList($whereData , $data);
    }
	/**
     * @desc   引用company类，查询company列表信息   
     */
    
    private function getComList($whereData = array(), $data = array()) {
        require_once ('company.model.php');
        $ComM = new company_model($this->db, $this->def);
        return  $ComM   ->  getList($whereData , $data);
    }
	/**
     * @desc   引用lietou类，查询lt_info列表信息   
     */
    private function getLtList($whereData = array(), $data = array()) {
        require_once ('lietou.model.php');
        $LietouM = new lietou_model($this->db, $this->def);
        return  $LietouM -> getList($whereData , $data); 
    }
	/**
     * @desc   引用system类，添加系统消息  
     */
    private function addSystem($data) {
		include_once('sysmsg.model.php');
        $sysmsgM  =  new sysmsg_model($this->db, $this->def);
        $sysmsgM -> addInfo($data);
    }
}
?>