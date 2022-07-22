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
class ad_order_controller extends siteadmin_controller{

	function index_action(){
		$adM		=	$this->MODEL('ad');
		$userInfoM	=	$this->MODEL('userinfo');
		$companyM	=	$this->MODEL('company');
		
		if(trim($_GET['keyword'])!=""){
            if ($_GET['type']=='1'){
				$oWhere['username']		=	array('like',trim($_GET['keyword']));
            	$orderinfo	=	$userInfoM->getInfo($oWhere,array('field'=>'`uid`'));
            	if (is_array($orderinfo)){
            		foreach ($orderinfo as $val){
            			$orderuids[]	=	$val['uid'];
            		}
            	}
				$where['comid']			=	array('in',pylode(",",$orderuids));
            }elseif ($_GET['type']=='2'){
				$where['order_id']		=	array('like',trim($_GET['keyword']));
            }elseif($_GET['type']=='3'){
				$where['adname']		=	array('like',trim($_GET['keyword']));
            }elseif($_GET['type']=='4'){
				$gWhere['name']			=	array('like',trim($_GET['keyword']));
            	$g_com					=	$companyM->getList($gWhere,array('field'=>'`uid`'));
            	if(is_array($g_com) && !empty($g_com)){
            		foreach($g_com['list'] as $v){
            		   $g_uid[]			=	$v['uid'];
            		}
            	}
				$where['comid']			=	array('in',pylode(",",$g_uid));
            }
            $urlarr['type']				=	$_GET['type'];
			$urlarr['keyword']			=	$_GET['keyword'];
		}
		
		if($_GET['end']){
			if($_GET['end']=='1'){
				$where['datetime']		=	array('>=',strtotime(date("Y-m-d 00:00:00")));
			}else{
				$where['datetime']		=	array('>=',strtotime('-'.$_GET['end'].'day'));
			}
			$urlarr['end']				=	$_GET['end'];
		}
		if($_GET['status']){
			if($_GET['status']=="-1"){
				$where['status']		=	'0';
			}else{
				$where['status']		=	$_GET['status'];
			}
			$urlarr['status']			=	$_GET['status'];
		}
		
		//分页链接
		$urlarr['page']	=	'{{page}}';
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');
		
		//提取分页
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('ad_order',$where,$pageurl,$_GET['page']);
		
		//分页数大于0的情况下 执行列表查询
		if($pages['total'] > 0){
			
		    //limit order 只有在列表查询时才需要
			if($_GET['order']){
				$where['orderby']	=	$_GET['t'].','.$_GET['order'];
				
			}else{
				$where['orderby']	=	array('status,asc','id,desc');
			
			}
		    $where['limit']			=	$pages['limit'];
			
			$urlarr['order']		=	$_GET['order'];
				
			$urlarr['t']			=	$_GET['t'];
		    
		    $List	=	$adM->getAdOrderList($where,array('utype'=>'admin'));
			$this->yunset("rows",$List['list']);
		}
		
		$search_list[]	=	array("param"=>"status","name"=>'审核状态',"value"=>array("1"=>"已审核","2"=>"未通过","-1"=>"未审核"));
		$ad_time		=	array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$search_list[]	=	array("param"=>"end","name"=>'订单时间',"value"=>$ad_time);
		$this->yunset("search_list",$search_list);
		$this->yunset("get_type", $_GET);
		$this->siteadmin_tpl(array('admin_ad_order'));
	}
	function sbody_action(){
		$adM			=	$this->MODEL('ad');
		$where['id']	=	$_GET['pid'];
		$row			=	$adM->getAdOrderInfo($where,array('field'=>'`statusbody`'));
		echo $row['statusbody'];die;
	}
	function status_action(){
		$adM		=	$this->MODEL('ad');
		$companyM	=	$this->MODEL('company');
		$row		=	$adM->getAdOrderInfo(array('id'=>$_POST['pid']));
		$com		=	$companyM->getInfo($row['uid'],array('field'=>'did'));
		$IntegralM	=	$this->MODEL('integral');
		
		if($_POST['status']=="1"){
			$value['did']			=	$com['did'];
			$value['ad_name']		=	$row['ad_name'];
			$value['time_start']	=	date("Y-m-d");
			$value['time_end']		=	date("Y-m-d",time()+3600*24*30*$row['buy_time']);
			$value['ad_type']		=	'pic';
			$value['pic_url']		=	$row['pic_url'];
			$value['pic_src']		=	$row['pic_src'];
			$value['class_id']		=	$row['aid'];
			$value['is_check']		=	'1';
			$value['is_open']		=	'1';
			$id		=	$adM->addAd($value);
			$adM->upOrderAd(array('id'=>$_POST['pid']),array('ad_id'=>$id));
			$_POST['id']			=	$id;
			$adM->model_ad_arr();
		}else if($_POST['status']=="2"){
			
			if($row['buytype']=="2"){
				if($row['order_state']==2){
					$IntegralM->company_invtal($row['comid'],2,$row['price'],true,"广告订单未通过审核，退还现金",true,2,'packpay');
				}
			}elseif($row['buytype']=="1"){
				$IntegralM->company_invtal($row['comid'],2,$row['integral'],true,"广告订单未通过审核，退还".$this->config['integral_pricename'],true,2,'integral');
			}
		}
		
		/* 消息前缀 */		
		$tagName  				=	'广告订单';
		
		/* 处理审核信息 */
		if ($_POST['status'] == 2){
			
			$statusInfo  =  $tagName.':'.$row['order_id'].',审核未通过';
			
			if($_POST['statusbody']){
				
				$statusInfo  .=  ' , 原因：'.$row['statusbody'];
				
			}
			
			$msg  =  $statusInfo;
			
		}elseif($_POST['status'] == 1){
			
			$msg  =  $tagName.':'.$row['order_id'].',已审核通过';
			
		}

		if(!empty($msg)){
			
			//发送系统通知
			
			$sysmsgM	=	$this->MODEL('sysmsg');
			
			$sysmsgM -> addInfo(array('uid'=>$row['uid'],'usertype'=>2, 'content'=>$msg));

		}
		$id		=	$adM->upOrderAd(array('id'=>$_POST['pid']),array('status'=>$_POST['status'],'statusbody'=>$_POST['statusbody']));
		$id?$this->ACT_layer_msg("广告订单(ID:".$_POST['pid'].")设置成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg("设置失败！",8,$_SERVER['HTTP_REFERER']);
	}
	function del_action(){
		$adM	=	$this->MODEL('ad');
		$this	->	check_token();
	    if($_GET['del']){
	    	$del=$_GET['del'];
	    	if($del){
	    		if(is_array($del)){
					$puWhere['id']		=	array('in',pylode(',',$del));
					$puWhere['status']	=	array('<>',0);
					$data['type']		=	'all';
				}else{
					$puWhere['id']		=	$del;
					$puWhere['status']	=	array('<>',0);
					$data['type']		=	'one';
		    	}
				$adM->delAdOrder($puWhere,$data);
				$this->layer_msg('广告订单(ID:'.pylode(',',$del).')删除成功！',9,1,$_SERVER['HTTP_REFERER']);
	    	}else{
				$this->layer_msg('请选择您要删除的订单！',8,1,$_SERVER['HTTP_REFERER']);
	    	}
	    }
	    if(isset($_GET['id'])){
			$where['id']		=	$_GET['id'];
			$where['status']	=	array('<>',0);
			$result				=	$adM->delAdOrder($where,array('type'=>'one'));
			isset($result)?$this->layer_msg('订单(ID:'.$_GET['id'].')删除成功！',9,0,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,0,$_SERVER['HTTP_REFERER']);
		}else{
			$this->layer_msg('非法操作！',8,1,$_SERVER['HTTP_REFERER']);
		}
	}
}
?>