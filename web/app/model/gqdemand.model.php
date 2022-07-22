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
class gqdemand_model extends model{
    /**
     * @desc   引用log类，添加用户日志   
     */
    private function addMemberLog($uid,$usertype,$content,$opera='',$type='') {
        require_once ('log.model.php');
        $LogM   =    new log_model($this->db, $this->def);
        return  $LogM -> addMemberLog($uid, $usertype, $content, $opera, $type); 
    }
    
    /**
     * @desc 订单生成
     * @param array $data
     */
    private function addOrder($data = array()){
        require_once 'companyorder.model.php';
        $orderM     =   new companyorder_model($this->db, $this->def);
        return $orderM -> addOrder($data);
    }

    private function getClass($options){

	    if (!empty($options)){
	        
	        include_once('cache.model.php');
	        
	        $cacheM            =        new cache_model($this->def, $this->db);
	        
	        $cache             =        $cacheM -> GetCache($options);
	        
            return $cache;
            
        }
	}
     
    /**
     *  @desc   供求平台详情(个人资料详情)，单条查询
     *  @param  int     $id:职位id
     *  @param  array   $data：自定义查询数组（eg:查询条件数据：where=>array ，参数处理条件：joblen=>'10'）
     */
    public function getGqInfo($whereData, $data = array()){

        $cache                          =       $this -> getClass(array('city'));

        $select                         =       $data['field'] ? $data['field'] : '*';
            
        $row                            =       $this -> select_once('gq_info', $whereData, $select);
		
        if($data['type']!=1){

            if($row['photo']){
            
                $row['photo_n']		    =	    checkpic($row['photo'],$this->config['gq_photo']);

            }

            $row['cityid_n']	        =	    $cache['city_name'][$row['cityid']];

            $row['three_cityid_n']	    .=	    '-'.$cache['city_name'][$row['three_cityid']];

        }
		
        return $row;
    }


    /**
     * @desc   供求平台详情(个人资料):列表
     * @param  array   $whereData:查询条件
     * @param  array   $data:自定义处理数组  (例：后台数据：utype->admin)
     */
    public function getGqinfoList($whereData,$data=array()) {
     

        $cache                                          =       $this -> getClass(array('user','city'));
        
        $select                                         =       $data['field'] ? $data['field'] : '*';
        
        $gqinfoList                                     =       $this   ->  select_all('gq_info',$whereData, $select);

        if($data['type']!=1){

            foreach($gqinfoList as $val){

                $uids[]=$val['uid'];
                
            }
            
            foreach($gqinfoList         as      $k      =>      $v){
            
                $gqinfoList[$k]['uid']		            =       $v['uid'];
    
                $gqinfoList[$k]['name']		            =       $v['name'];
    
                $gqinfoList[$k]['mobile']		        =       $v['mobile'];
    
                $gqinfoList[$k]['salary']		        =       $v['salary'];
    
                $gqinfoList[$k]['lastupdate']		    =       $v['lastupdate'];
                
                $gqinfoList[$k]['sex_n']		        =       $cache['user_sex'][$v['sex']];
    
                $gqinfoList[$k]['provinceid_n']			=       $cache['city_name'][$v['provinceid']];
    
                $gqinfoList[$k]['cityid_n']				=       $cache['city_name'][$v['cityid']];
    
                $gqinfoList[$k]['three_cityid_n']		=       $cache['city_name'][$v['three_cityid']];
                
				if($v['photo']){

                    $gqinfoList[$k]['photo_n']			=       checkpic($v['photo'],$this->config['gq_photo']);
                    
				}
				
            }

        }

        return $gqinfoList;
        
    }

	/**
     * 审核功能
     * 表：gq_info图片详情
     * $data:字段名称
     * $whereData:条件名称
     */ 
    public function addGqInfo($data=array()){

        $nid	=	$this -> insert_into('gq_info', $data);
        return $nid;
    }

    //添加和修改功能 整合
    public function upaddGqinfo($whereData,$data=array(),$type=null){

        if($data['file']['tmp_name'] || $data['base']){
            $upArr    =  array(
            
                'file'      =>  $data['file'],
                
                'dir'       =>  'user',

                'base'      =>  $data['base'],

                'preview'   =>  $data['preview']
            );
            //缩率图参数
            
            $pic            =  $this->upload($upArr);
            
            if (!empty($pic['msg'])){

                $return['msg']          =       $pic['msg'];
                $return['errcode']      =       '8';
                return $return;

            }elseif (!empty($pic['picurl'])){

                $pictures   =   $pic['picurl'];
            }
        }

        unset($data['file']);
        unset($data['base']);
        unset($data['preview']);

        if(isset($pictures)){

            $data['photo']  =   $pictures;

        }else{
            if($type==2){
                $return['msg']          =       '请上传头像';
                $return['errcode']      =       '8';
                return $return;
            }
        }
        unset($data['uid']);

        $nid                        =       $this -> update_once('gq_info', $data,$whereData);

        $return['msger']		    =	    '供求用户';

        if($type==1){

            $return['msg']		    =	    $nid ? $return['msger'].'头像删除成功！' : $return['msger'].'头像删除失败！';

         }elseif($type==2){

            $return['msg']		    =	    $nid ? $return['msger'].'头像修改成功！' : $return['msger'].'头像修改失败！';
        }else{
            
            $return['msg']		    =	    $nid ? $return['msger'].'信息更新成功！' : $return['msger'].'信息更新失败！';

        }

        $return['errcode']	        =	    $nid ? '9' :'8';
            
        return $return;
        
    }
    
	/**
     * 审核功能
     * 表：gq_info
     * $data:字段名称
     * $whereData:条件名称
     */ 
    public function upGqInfoStatus($whereData,$data=array()){

        $nid				=	$this -> update_once('gq_info', $data,$whereData);
        $return['msger']	=	'供求用户(ID:'.$nid.')';
        $return['errcode']	=	$nid ? '9' :'8';
        $return['msg']		=	$nid ? $return['msger'].'头像审核成功！' : $return['msger'].'头像审核失败！';
        return $return;
    }

    /**
     * 根据发布任务（自由就业信息）查询  发布者信息（单条）
     * $data:字段名称
     * $whereData:条件名称
     */
    public function getGqtaskInfo($whereData=array(), $data=array())
	{
    
		//查询发布任务
        $select                         =               $data['field'] ? $data['field'] : '*';
        $once                           =               $this -> select_once('gq_task', $whereData, $select);

         //存在  执行下一步操作

        if($data['type']!=1){

            $where['uid']               =               $once['uid'];

            $return                     =               $this->getGqInfo($where);

            $once['name']               =               $return['name'];

            $once['mobile']             =               $return['mobile'];

            $once['sex']                =               $return['sex'];

            $once['provinceid']         =               $return['provinceid'];

            $once['cityid']             =               $return['cityid_n'];

            $once['three_cityid']       =               $return['three_cityid_n'];

            $once['salary']             =               $return['salary']; 

        }
      
        return $once;

    }
    //添加统计
    public function getGqtaskhits($id){

        $hits       =       1;
        $nid        =       $this -> update_once('gq_task', array('hits' => array('+', $hits)), array('id' => $id));
        return $nid;
    }

     /***
     * 根据发布任务（自由就业信息）查询  发布者信息(列表)
     * $data:字段名称
     * $whereData:条件名称
     */
    public function getGqtaskList($whereData,$data=array()){
     
        $select                     =          $data['field'] ? $data['field'] : '*';

        $list                       =          $this -> select_all('gq_task', $whereData, $select);
       
        if($data['type']!=1){
            
            foreach($list  as $val){

                $uids[]             =          $val['uid'];

            }
        
            $where['uid']           =           array('in',pylode(',',$uids));

            $gqlist                 =          $this->getGqinfoList($where,array('field'=>'`uid`,`name`,`moblie`,`sex`,`provinceid`,`cityid`,`three_cityid`,`salary`,`photo`'));
           
            if(is_array($list) && $list){

                foreach ($list as $k => $v) {

                    foreach($gqlist as $val){

                        if($v['uid']    ==      $val['uid']){

                            $list[$k]['gqname']                =           $val['name'];

                            $list[$k]['mobile']                =           $val['mobile'];

                            $list[$k]['sex']                   =           $val['sex'];

                            $list[$k]['provinceid']            =           $val['provinceid'];

                            $list[$k]['cityid']                =           $val['cityid'];

                            $list[$k]['three_cityid']          =           $val['three_cityid'];

                            $list[$k]['salary']                =           $val['salary'];
							
                            $list[$k]['photo_n']			   =           checkpic($val['photo'],$this->config['gq_photo']);

                        }

                    }

                }

            }

        }
       
        return $list;

    }

    //删除基本信息
    public function delInfo($uid)
	{
        if (!empty($uid)) {
            
            if(is_array($uid)){
                    
                $ids	=	$uid;
                    
                $return['layertype']	=	1;
				 
            }else{
                    
                $ids	=	@explode(',', $uid);
                    
    			$return['layertype']	=	0;
                    
            }
            
            $nid	=	$this -> delete_all('gq_info', array('uid' => array('in', pylode(',', $ids))), '');

            $msg	=	'技能信息';

			$return['errcode']	=	$nid ? 9 : 8;
			$return['msg']		=	$nid ? $msg.'删除成功！' : $msg.'删除失败！';
        }else{

            $return['msg']		=	'请选择您要删除的数据！';
            $return['errcode']	=	8;
        }

        return $return;
    }

     /***
     * 删除发布任务 并且同时删除浏览记录
     * 表： gq_task：发布任务表  gq_browse浏览记录  
     * $data:字段名称
     * $whereData:条件名称
     */ 
    public  function deltask($id,$data=array()){
      
        if (!empty($id)) {
            
            if(is_array($id)){
                    
                $ids	=	$id;
                $layT	=	1;
            }else{
                    
                $ids	=	@explode(',', $id);
                $layT	=	0;    
            }

			$return['layertype']=	$layT;        
                       
            $where['id']		=	array('in', pylode(',', $ids));
            $gqwhere['task_id']	=	array('in', pylode(',', $ids));

			if($data['utype'] !='admin'){

				$where['uid']	=	$data['uid'];
				$gqwhere['uid']	=	$data['uid'];
			}
			 
            $result	=	$this -> delete_all('gq_task', $where, '');

            if($result){

				$this -> delete_all('gq_browse', $gqwhere, '');
			}

            $msg	=	'项目任务(ID:'.pylode(',', $id).')';
			
			$return['errcode']	=	$result	? 9 : 8;
            $return['msg']		=	$result ? $msg."删除成功！" : $msg."删除失败！";
        }else{

            $return['msg']		=	'请选择您要删除的数据！';
            $return['errcode']	=	8;
        }
        return $return;
    }

    /***
     * 添加发布任务和更新(单条查询)
     * 表：gq_task
	 * $data:字段名称
     * $whereData:条件名称
     * $type==1表是不走发送通知功能
     * $type!=1表是走发送功能
     * $type:可有可无  但是不发送通知必须要用到
     */ 
	public function upaddGqtask($whereData, $data=array(), $type)
	{

		if($data['name']==''){

            return array('msg'=>'请填写项目名称！','errcode'=>8);
        }
        
		if($data['salary']==''){

            return array('msg'=>'请填写价格预算！','errcode'=>8);
		}
		if($data['edate']==''){

            return array('msg'=>'请填写预计工期！','errcode'=>8);
		}
		if($data['etime']==''){

            return array('msg'=>'请填写接单截止时间！','errcode'=>8);
		}
		if($data['content']==''){

            return array('msg'=>'请填写项目需求！','errcode'=>8);
		}
		if($data['link_man']==''){

            return array('msg'=>'请填写联系人！','errcode'=>8);
		}
		if($data['link_moblie']==''){

            return array('msg'=>'请填写联系电话！','errcode'=>8);
		}elseif(!CheckMobile($data['link_moblie'])){

            return array('msg'=>'联系电话格式错误！','errcode'=>8);
        }

        if(!empty($whereData)){
            
            $nid	=	$this -> update_once('gq_task', $data,$whereData);

			if($type!=1){
                
                if($nid){

                    if($this->config['gq_task_status']=="0"){
                        $gqinfo = $this->select_once('gq_task',$whereData);
                        require_once('admin.model.php');
                        $adminM	=	new admin_model($this->db,$this->def);
                        $adminM->sendAdminMsg(array('first'=>'有新的供求任务需要审核，供求任务《'.$gqinfo['name'].'》更新成功，等待审核！','type'=>14));
                        $msg	=	"更新成功，等待审核！";
                    }else{

                        $msg	=	"更新成功!";
                    }
                }else{
					
					$msg	=	"更新失败!";
				}
            }else{

                $msg	=	"更新成功!";
            }
			
            $return['msger']	=	'供求任务信息';
            $return['errcode']	=	$nid ? '9' :'8';
            $return['msg']		=	$return['msger'].$msg;
            return $return;
            
        }else{

			$nid	=	$this -> insert_into('gq_task',$data);
                
			if($nid){

				if($this->config['gq_pay_price'] != "0" && $this->config['gq_pay_price'] != ""){

					$return['msg']		=	'订单生成，请付款';
					$return['errcode']	=	'10';
					$return['url']		=	Url('wap',array('c'=>'free','a'=>'pay','id'=>$nid));
				}else{

					if($this->config['gq_task_status']=="0"){

						require_once('admin.model.php');
						$adminM	=	new admin_model($this->db,$this->def);
						$adminM->sendAdminMsg(array('first'=>'有新的供求任务需要审核，供求任务《'.$data['name'].'》发布成功，等待审核！','type'=>14));
						$msg	=	"发布成功，等待审核！";
					}else{

						$msg	=	"发布成功!";
					}
					$return['id']		=	$nid;
					$return['errcode']	=	'9';
					$return['msg']		=	'供求任务信息'.$msg;
				}
			}else{

				$return['msg']		=	'供求任务信息保存失败！';
				$return['errcode']	=	'8';
			}

            return $return;
        }
    }

    public function upGqtatus($uid,$data=array()){

        $whereData['uid']              =       $uid;

        $nid                            =       $this -> update_once('gq_info', $data,$whereData);
       

        $return['msger']		        =	    '供求用户(ID:'.$nid.')';
        
        $return['errcode']	            =	     $nid ? '9' :'8';
        
        $return['msg']		            =	     $nid ? $return['msger'].'审核成功！' : $return['msger'].'审核失败！';
        
        return $return;
    }

	/**
     * 审核功能
     * 表：gq_task
     * $data:字段名称
     * $whereData:条件名称
     */ 
	public function upGqtaskStatus($id,$data=array())
	{
		

		$nid				=	$this -> update_once('gq_task', $data, array('id' => array('in', pylode(',', $id))));
        
		$return['msger']	=	'供求任务';
        
        $return['errcode']	=	$nid ? '9' :'8';
        
        $return['msg']		=	$nid ? $return['msger'].'审核成功！' : $return['msger'].'审核失败！';
        
        return $return;
	}
       
	/**
     * 根据浏览查询相关详情页面(单条查询)
     * 表：gq_browse浏览详情
     * $data:字段名称
     * $whereData:条件名称
     */ 
    public  function  gqbrowseInfo($data=array(),$whereData){
        //查询相关
        $select                     =               $data['field'] ? $data['field'] : '*';

        $browseInfo                 =               $this->select_once("gq_browse",$whereData,$data);

        if($data['type']!=1){

            $where['uid']           =               $browseInfo['gq_id'];//任务发布id
        
            $gqInfo                 =               $this->getGqInfo($where,array('type'=>1));
            
            $taskwhere['uid']       =               $browseInfo['task_id'];//任务id
            
            $taskInfo               =               $this->getGqtaskInfo($where,array('type'=>1));
    
            $liulanwhere['uid']     =               $browseInfo['uid'];//浏览uid
            
            $liulangqInfo           =               $this->getGqInfo($liulanwhere,array('type'=>1));
    
            $treturn                =               array($browseInfo,$gqInfo,$taskInfo,$liulangqInfo);
            
            return $treturn;

        }else{

            return $browseInfo;

        }
          
    }
      /***
     * 根据浏览查询相关列表页面(多条查询)
     * 表：gq_browse浏览列表
     * $data:字段名称
     * $whereData:条件名称
     */ 
    public function gqbrowseList($whereData,$data=array()){

        $select                     =               $data['field'] ? $data['field'] : '*';

        $browseList                 =               $this->select_all("gq_browse",$whereData,$select);
   
        foreach ($browseList as  $v) {

            $uids[]                 =           $v['uid'];//任务发布id
            # code...
            $gqids[]                =           $v['gq_id'];//任务发布id

            $taskids[]              =           $v['task_id'];//任务id
        
        }

        $memberwhere['uid']         =           array('in',pylode(',',$uids));
        $member                     =           $this->select_all('member',$memberwhere,'`username`,`uid`');

        $gqwhere['uid']             =           array('in',pylode(',',$gqids));//浏览者

        $gqlist                     =          $this->getGqinfoList($gqwhere,array('field'=>'`uid`,`name`','type'=>1));//任务发布者

        $taskwhere['id']            =           array('in',pylode(',',$taskids));

        $tasklist                   =          $this->getGqtaskList($taskwhere,array('field'=>'`id`,`name`,`link_man`,`link_moblie`','type'=>1));//任务名称

        foreach ($browseList as $k => $v) {
            # code...循环操作
            foreach($gqlist   as $val){

                if($v['gq_id']        ==          $val['uid']){

                    $browseList[$k]['gqname']     =           $val['name'];//任务发布者
                   

                }

            }

            foreach($member   as $val){

                if($v['uid']         ==          $val['uid']){//浏览者

                    $browseList[$k]['gquname']     =           $val['username'];

                }
            }
            foreach($tasklist as  $val){//任务名称

                if($v['task_id']      ==          $val['id']){

                    $browseList[$k]['taskname']        =          $val['name'];

                    $browseList[$k]['link_man']        =           $val['link_man'];

                    $browseList[$k]['link_moblie']     =           $val['link_moblie'];

                }

            }

        }

        return $browseList;
    } 
    //添加任务浏览记和更新浏览记录
    public function  addbrowertask($whereData,$updata=array(),$data=array()){
         //查询相关
        $select                         =               $data['field'] ? $data['field'] : '*';

        $browsetask                     =               $this->select_once("gq_browse",$whereData,$select);
  
        if($browsetask){
            //存在
            $browswhere['id']           =               $browsetask['id'];

            $browswhere['uid']          =               $browsetask['uid'];

            $this -> update_once('gq_browse', array('ctime'=>time()),$browswhere);

        }else{
            //不存在
            $this -> insert_into('gq_browse',$updata);

        }

    }


    /**
     * @desc     删除浏览供求任务记录
     * @param    $id
     * @param    array $data
     * @return   $return
     */
    function delbrower($id,$data=array()) 
	{
        
        $return	=	array();
        $where	=	array();
            
        if (!empty($id)) {
            
            if(is_array($id)){
                    
                $ids	=	$id;
                $layT	=	1;
            }else{
                    
                $ids	=	@explode(',', $id);
				$layT	=	0;
            }

			$return['layertype']=	$layT;
                
            $ids				=	pylode(',', $ids);
                
            $where['id']		=	array('in', $ids);

			if($data['utype'] !='admin')
			{
				$where['uid']	=	$data['uid'];
			}

            $result	=	$this -> delete_all('gq_browse', $where, '');

            $msg	=	'浏览任务(ID:'.pylode(',', $id).')';

			$return['errcode']	=	$result ? 9 : 8;
			$return['msg']		=	$result ? $msg."删除成功！" : $msg."删除失败！"; 
        }else{

            $return['msg']		=	'请选择您要删除的数据！';
            $return['errcode']	=	8;
        }
        return $return;     
    }

	function getTaskNum($whereData=array()){

        return $this->select_num('gq_task',$whereData);
        
	}
	//发布供求任务付款
	public function payTask($data=array()){

		$id	=	intval($data['id']);
		if(!empty($id)){

            $ordernum	=	$this -> select_num('company_order',array('uid'=>$data['uid'],'type'=>'29','order_state'=>1));
            
			if($ordernum){

                $this -> delete_all('company_order',array('uid'=>$data['uid'],'type'=>'29'),'');
            }
            
            $row	=	$this->getGqInfo(array('id'=>$id,'pay'=>1));
            
			if(is_array($row)){

				//生成相关订单
                $dingdan	=	time().rand(10000,99999);
                
				$orderData	=	array(

                    'type'			=>	29,
                    'order_id'		=>	$dingdan,
                    'order_price'	=>	$this->config['gq_pay_price'],
                    'order_time'	=>	time(),
                    'order_type'	=>	$data['pay_type'],
                    'order_state'	=>	1,
                    'order_remark'	=>	'供求任务收费',
                    'uid'			=>	$data['uid'],
                    'usertype'		=>	5,
                    'did'			=>	$data['did'],
                    'order_info'	=>	serialize(array('gqid'=>$id,'price'=>$this->config['gq_pay_price'],'uid'=>$data['uid']))
                );
                
                $nid	=	$this -> addOrder($orderData);
                
				if($nid && $dingdan){//订单生成成功
					
                    return  array('error'=>0,'orderid'=>$dingdan,'id'=>$nid);
				}else{//生成失败 返回具体原因

                    return array('error'=>1,'msg'=>"下单失败");
                }
			}else{

                return array('error'=>1,'msg'=>"供求任务数据不存在");
            }
        }
    }

	//供求任务刷新付款
	public function payTaskRefresh($data=array()){

		$id	=	intval($data['id']);
		if(!empty($id)){

            $ordernum	=	$this -> select_num('company_order',array('uid'=>$data['uid'],'type'=>30,'order_state'=>1));
            
			if($ordernum){

                $this -> delete_all('company_order',array('uid'=>$data['uid'],'type'=>30),'');
            }
            
            $row	=	$this->getGqInfo(array('id'=>$id,'pay'=>1));
            
			if(is_array($row)){

				//生成相关订单
                $dingdan	=	time().rand(10000,99999);
                
				$orderData	=	array(

                    'type'			=>	30,
                    'order_id'		=>	$dingdan,
                    'order_price'	=>	$this->config['gq_refrsh_pay'],
                    'order_time'	=>	time(),
                    'order_type'	=>	$data['pay_type'],
                    'order_state'	=>	1,
                    'order_remark'	=>	'供求任务刷新收费',
                    'uid'			=>	$data['uid'],
                    'usertype'		=>	5,
                    'did'			=>	$data['did'],
                    'order_info'	=>	serialize(array('gqid'=>$id,'price'=>$this->config['gq_refrsh_pay'],'uid'=>$data['uid']))
                    
                );
                
                $nid	=	$this -> addOrder($orderData);
                
				if($nid && $dingdan){//订单生成成功
					
                    return  array('error'=>0,'orderid'=>$dingdan,'id'=>$nid);
				}else{//生成失败 返回具体原因
                    
                    return array('error'=>1,'msg'=>"下单失败");
                }
			}else{

                return array('error'=>1,'msg'=>"供求任务数据不存在");
                
            }
        }
    }

    //处理头像
    public function upPhoto($whereData = array(),$data=array('photo'=>null,'thumb'=>null,'utype'=>null,'base'=>null,'preview'=>null)){
        
        if (!empty($whereData['uid'])){

	        $uid                        =           $whereData['uid'];
	        // 头像还需上传的
	        if ($data['photo'] || $data['base']){
	            
	            $upArr                  =           array(

                    'file'              =>          $data['photo'],
                    
                    'dir'               =>          'free',
                    
                    'type'              =>          'logo',
                    
                    'base'              =>          $data['base'],
                    
                    'preview'           =>          $data['preview']
                    
                );
                
	            $result                 =           $this -> upload($upArr);
	            
	            if (!empty($result['msg'])){
	                
                    $return['msg']      =           $result['msg'];
                    
	                $return['errcode']  =           '8';
	                
	                return $return;
	                
	            }elseif (!empty($result['picurl'])){
	                
	                
	                $photo              =           $result['picurl'];
	                    
	            }
                
	        }
	        // 已处理好的头像缩略图
	        if ($data['thumb']){
	            
                $photo			        =	        str_replace('../data','./data',$data['thumb'][1]);
            }
	        
	        if (!empty($photo)){
	            // 用户操作，且后台设置用户头像需要审核的
	            if ($data['utype'] == 'gq' && $this -> config['gq_photo_status'] == 1){

	                $photo_status       =           1;
                
                }else{

                    $photo_status       =           0;
                    
                }
                
                $nid                    =           $this->update_once('gq_info',array('photo'=>$photo,'photo_status'=>$photo_status),array('uid'=>$uid));
	           
	        }
	        
	        if (isset($nid)) {
	            // 用户操作的，判断处理头像上传积分
	            if ($data['utype'] == 'gq'){
	                    
	                if ($this -> config['gq_photo_status'] == 1){

                        $return['errcode']  =  '9';
                        $return['msg']      =  '上传成功，请等待审核';
                        
	                }else{

                        $return['errcode']  =       '9';
                        $return['msg']      =       '上传成功';
                    }
                    
	                // pc会员中心预览即上传，处理预览图
	                if ($data['preview']){
	                    
	                    $return['picurl']   =       checkpic($photo);
                    }
                    
	            }else{
                    $return['msg']          =       '自由头像(ID:'.$uid.')修改成功';
                    $return['errcode']      =       '9';
                }
                
	        }else{
	            
                $return['msg']              =       '自由头像(ID:'.$uid.')修改失败';
                $return['errcode']          =       '8';
            }
	    }else{
	        
            $return['msg']                  =       '请选择需要修改的用户';
            $return['errcode']              =       '8';
        }
        return $return;
    }
    
	/**
	 * 处理单个图片上传
	 * @param file/需上传文件; dir/上传目录; type/上传图片类型; base/需上传base64; preview/pc预览即上传
	 */
	private function upload($data = array('file'=>null,'dir'=>null,'type'=>null,'base'=>null,'preview'=>null)){
	    
	    include_once('upload.model.php');
	    
	    $UploadM                =               new upload_model($this->db, $this->def);
	    
	    $upArr                  =               array(

            'file'              =>              $data['file'],
            
            'dir'               =>              $data['dir'],
            
            'type'              =>              $data['type'],
            
            'base'              =>              $data['base'],
            
            'preview'           =>              $data['preview']
            
        );
        
	    $return                 =               $UploadM -> newUpload($upArr);
	    
        return $return;
        
    }
          /**
     * 修改自由头像
     * @param array $whereData
     * @param array $data   photo/需上传的图片文件;   thumb/已处理好的缩略图;  utype/操作的用户类型;  base/需上传的base4图片;  preview/pc预览即上传
     */
    public function upLogo($whereData = array(),$data=array('photo'=>null,'thumb'=>null,'utype'=>null,'base'=>null,'preview'=>null)){
       
		if (!empty($whereData['uid'])){
            
            $uid                        =               $whereData['uid'];
            // 头像还需上传的
            if ($data['photo'] || $data['base']){
                
                $upArr                  =                array(

					'file'              =>               $data['photo'],
					
					'dir'               =>              'free',
					
					'type'              =>              'logo',
					
					'base'              =>               $data['base'],
					
					'preview'           =>               $data['preview']
					
                );

                $result                 =               $this -> upload($upArr);
                
                if (!empty($result['msg'])){
                    
                    $return['msg']      =               $result['msg'];

                    $return['errcode']  =               '8';
                    
                    return $return;
                    
                }elseif (!empty($result['picurl'])){
                    
                    $photo          =               $result['picurl'];
                        
                }
            }
            // 已处理好的头像缩略图
            if ($data['thumb']){
                
                $photo                          =         str_replace('../data','./data',$data['thumb'][1]);
            }
         
            if (!empty($photo)){
                
 				
				$return['id']                   =        $this->update_once('gq_info',array('photo'=>$photo,'photo_status'=>0),array('uid'=>$uid));
                      
            }
           
            if (isset($return['id'])) {

                    if ($data['preview']){
                            
                        $return['picurl']       =       checkpic($photo);

                    }
                    $return['msg']              =       '自由头像(ID:'.$uid.')修改成功';

                    $return['errcode']          =       '9';
            }else{
                
                $return['msg']                  =       '自由头像(ID:'.$uid.')修改失败';

                $return['errcode']              =       '8';

            }
        }else{
            
            $return['msg']                      =       '请选择需要修改的用户';

            $return['errcode']                  =       '8';

        }

        return $return;

    }
     //添加统计
     public function upGqtaskpay($where,$data=array()){

        $nid        =       $this -> update_once('gq_task', $data,$where);

        return $nid;
    }

}
?>