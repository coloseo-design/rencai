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
class coupon_list_controller extends adminCommon{
		//设置高级搜索功能
	function set_search(){
		$search_list[]=array("param"=>"status","name"=>'消费状态',"value"=>array("1"=>"未消费","2"=>"已消费","3"=>"已到期"));
		$search_list[]=array("param"=>"end","name"=>'到期时间',"value"=>array("1"=>"今天","3"=>"最近三天","7"=>"最近七天","15"=>"最近半月","30"=>"最近一个月"));
		$search_list[]=array("param"=>"change","name"=>'消费时间',"value"=>array("1"=>"今天","3"=>"最近三天","7"=>"最近七天","15"=>"最近半月","30"=>"最近一个月"));
		$search_list[]=array("param"=>"receive","name"=>'获赠时间',"value"=>array('1'=>'一天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月'));
		$this->yunset("search_list",$search_list);
	}
	function index_action()
	{
		$this->set_search();
		
		$couponM	=	$this->MODEL('coupon');
		
		$upwhere['validity']	=	array('<',time());
		
		$upwhere['status']		=	'1';
		
		$couponM -> upCouponList($upwhere,array('status'=>'3'));
		
		if($_GET['status']){
			
			$where['status']	=	$_GET['status'];
			
			$urlarr['status']	=	$_GET['status'];
		}
		if($_GET['change']){
			if($_GET['change']=='1'){
				
				$where['xf_time']	=	array('>=',strtotime(date("Y-m-d 00:00:00")));
				
			}else{
				
				$where['xf_time']	=	array('>=',strtotime('-'.$_GET['change'].'day'));
				
			}
			$urlarr['change']		=	$_GET['change'];
		}
		if($_GET['end']){
			if($_GET['end']=='1'){
				
				$where['validity'][]	=	array('<=',strtotime(date("Y-m-d 11:59:59")));
				
				$where['validity'][]	=	array('>=',strtotime(date("Y-m-d 00:00:00")));
				
			}else{
				
				$where['validity'][]	=	array('<=',strtotime('+'.$_GET['end'].'day'));
				
				$where['validity'][]	=	array('>=',time());
				
			}
			$urlarr['end']=$_GET['end'];
		}
		if($_GET['receive']){
			if($_GET['receive']=='1'){
				
				$where['ctime']			=	array('>=',strtotime(date("Y-m-d 00:00:00")));
				
			}else{
				
				$where['ctime']			=	array('>=',strtotime('-'.$_GET['receive'].'day'));
				
			}
			$urlarr['receive']			=	$_GET['receive'];
		}
		if(trim($_GET['keyword']))
		{
			if($_GET['type']=='1'){
				
				$userinfoM	=	$this->MODEL('userinfo');
				
				$m_uid		=	$userinfoM->getList(array('username'=>array('like',trim($_GET['keyword']))),array('field'=>'`uid`'));
				
				if(is_array($m_uid) && !empty($m_uid)){
					
					foreach($m_uid as $k){
						
						$m_id[]=$k['uid'];
						
					}
				}
				
				$where['uid']			=	array('in',pylode(',',$m_id));
				
			}elseif($_GET['type']=='2'){
				
				$where['number']		=	array('like',trim($_GET['keyword']));
				
			}elseif($_GET['type']=='3'){
				
				$where['coupon_name']	=	array('like',trim($_GET['keyword']));
				
			}
			$urlarr['type']				=	$_GET['type'];
			
			$urlarr['keyword']			=	$_GET['keyword'];
		}
		if($_GET['order'])
		{
			$where['orderby']		=	$_GET['t'].','.$_GET['order'];
			
			$urlarr['order']		=	$_GET['order'];
			
			$urlarr['t']			=	$_GET['t'];
		}else{
			
			$where['orderby']		=	'id';
		}
		$urlarr       	 	=   $_GET;
		$urlarr['page']		=	"{{page}}";
		
		$pageurl			=	Url($_GET['m'],$urlarr,'admin');
		
		$pageM				=	$this  -> MODEL('page');
		
		$pages				=	$pageM -> pageList('coupon_list',$where,$pageurl,$_GET['page']);
		
		if($pages['total'] > 0){
			
			$where['limit']	=	$pages['limit'];
			
			$rows			=	$couponM -> getCouponList($where,array('utype'=>'admin'));
			
			$this->yunset('rows',$rows);
		}
		
		$this->yunset("get_type",$_GET);
		
		$this->yuntpl(array('admin/coupon_list'));
	}
	function del_action()
	{
		if($_GET['del'])
		{
			$this->check_token();
			
			$couponM		=	$this->MODEL('coupon');
			
			$del=$_GET['del'];
			
			if(is_array($del)){
				
				$del=@implode(',',$del);
				
				$layer_type=1;
			}else{
				$layer_type=0;
			}
			$where['id']	=	array('in',$del);
			
			$return			=	$couponM->delCouponList($where);
			
			$this->layer_msg('优惠券记录(ID:'.$del.')'.$return['msg'],$return['cod'],$layer_type,$_SERVER['HTTP_REFERER']);
		}else{
			$this->layer_msg('请选择要删除的内容！',8,0,$_SERVER['HTTP_REFERER']);
		}
	}
}

?>