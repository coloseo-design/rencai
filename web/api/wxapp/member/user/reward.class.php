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
class reward_controller extends user_controller{
    //参与悬赏记录
    function look_reward_action(){
      	$packM = $this->MODEL('pack');
        $where['uid']		=	$this->member['uid'];
      	$total = $packM->getrewardNum($where);
      	$page				=	$_POST['page'];
      	$limit				=	$_POST['limit'];
     	$limit				=	!$limit?20:$limit;

      	if($page){
       		$pagenav		=	($page-1)*$limit;
        	$where['limit']	=	array($pagenav,$limit);
      	}else{
        	$where['limit']	=	array('',$limit);
     	}
     	$where['orderby']	=	array('id,desc');
      	$List	=	$packM -> getJobRewardList($where,array('utype'=>'user'));
     	if($List && is_array($List)){
        	$data['error']=1;
      	}
      	$this -> render_json($data['error'], 'ok', $List,$total);
    }
    /**
     * 我推荐的悬赏
    */
    function rebates_reward_action(){
        $lietouM  =  $this->MODEL('lietou');
        $where['uid']		=	$this->member['uid'];
        $total = $lietouM->getRebatesNum($where);
        $page				=	$_POST['page'];
        $limit				=	$_POST['limit'];
        $limit				=	!$limit?20:$limit;


        if($page){
            $pagenav		=	($page-1)*$limit;
            $where['limit']	=	array($pagenav,$limit);
        }else{
            $where['limit']	=	array('',$limit);
        }
        $where['orderby']	=	array('id,desc');
        $List   	=  $lietouM->getRebatesList($where);
        if($List && is_array($List)){
            $data['error']=1;
        }
        $this -> render_json($data['error'], 'ok', $List,$total);
    }
    //悬赏职位设定
    function logstatus_action(){    
      	if($_POST){
         	$packM	=  $this->MODEL('pack');
         	$_POST['port']	=	$this->plat == 'mini' ? '3' : '4';
			$return	=  $packM->logStatus((int)$_POST['rewardid'],(int)$_POST['status'],$this->member['uid'],'1',$_POST);
         	$log	=  array();
          if($return['error']==''){
         	 	//悬赏职位设定成功
           		$data['error']  = 1;
              $log            = $packM -> getStatusInfo((int)$_POST['rewardid'], 1, (int)$_POST['status']);
         	}else{
           		//生成失败 返回具体原因
            	$data['error']  = $return['error'];
        	}
      	}else{
         	$data['error']  = '参数不正确';
      	}
      	$this -> render_json($data['error'],'',$log);
	}
	//悬赏职位仲裁
	function arb_action(){
		if(!$_POST['rewardid']){
			$data['msg']='请选择需要仲裁的赏单';
		}
		if(!$_POST['content']){
			$data['msg']='请填写仲裁原因！';
		}else{
			$data['content'] = $_POST['content'];
		}
		
		$data['file']	=	$_FILES['photos'];
		
		$packM			=	$this->MODEL('pack');
	
		$return			=  $packM->logStatus((int)$_POST['rewardid'],26,$this->member['uid'],'1',$data);
			
		if($return['error']==''){
			//悬赏职位设定成功
			$data['msg']='仲裁提交成功！';
			$data['error']=1;
				
		}else{
			//生成失败 返回具体原因
			$data['msg']=$return['error'];
			$data['error']=1;
		}

		$this -> render_json($data['error'],$data['msg']);
	
	}

	/**
     * 兑换记录列表
	*/
	function changeList_action(){
	    $redeemM = $this->MODEL('redeem');
        $statisM		=	$this->MODEL('statis');
        $where['uid']		=	$this->member['uid'];

        if($_POST['type']!='all'){
            $where['status'] = $_POST['type'];
        }
        $total = $redeemM->getChangeNum($where);
        $page				=	$_POST['page'];
        $limit				=	$_POST['limit'];
        $limit				=	!$limit?20:$limit;

        if($page){
            $pagenav		=	($page-1)*$limit;
            $where['limit']	=	array($pagenav,$limit);
        }else{
            $where['limit']	=	array('',$limit);
        }
        $where['orderby']	=	array('id,desc');
        $List	=	$redeemM -> getChangeList($where);
        $statis				=	$statisM->getInfo($this->member['uid'],array('usertype'=>1));

        $statis['integral']	=	number_format($statis['integral']);
        if($List['list'] && is_array($List['list'])){
            $data['error']=1;
        }else{
            $List['list'] = $List;
        }
        $List['statis'] = $statis;
        $this -> render_json($data['error'], 'ok', $List,$total);
    }
    //删除兑换记录
    function delChange_action(){
        $redeemM    			=       $this->MODEL('redeem');

        $uid 				=		$this->member['uid'];

        $id					=		intval($_POST['id']);

        $where['id'] = $id;
        $data['member'] = 'user';
        $data['usertype'] = 1;
        $data['uid'] = $uid;
        $data['type'] = 'one';
        $data['id'] = $id;

        $return  			=  		$redeemM -> delChange($id,$data);

        if($return['cod']==9){

            $error			=		1;

        }else{

            $error			=		2;
        }
        $this -> render_json($error,$return['msg']);
    }
    //删除我推荐的悬赏
    function rebatesdel_action(){
        $id			=	(int)$_POST['id'];
        $ltM		=	$this -> MODEL('lietou');
        $result		=	$ltM -> delRebates($id,array('uid'=>$this->uid,'usertype'=>$this->usertype,'type'=>1));//type==1我推荐的人才
        if($result['errcode']==9){
            $error = 1;
        }else{
            $error = 0;
        }
        $this -> render_json($error,$result['msg']);
    }
}