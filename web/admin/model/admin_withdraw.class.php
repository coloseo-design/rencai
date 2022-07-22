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
class admin_withdraw_controller extends adminCommon{
	function set_search(){
		$search_list[]	=	array("param"=>"order_state","name"=>'提现状态',"value"=>array("0"=>"等待审核","1"=>"提现成功","2"=>"提现失败"));
		
		$lo_time		=	array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$search_list[]	=	array("param"=>"time","name"=>'提现时间',"value"=>$lo_time);
		
		$this -> yunset("search_list",$search_list);
	}
	function index_action(){
		$this -> set_search();
		$packM							=	$this -> MODEL('pack');
		
		$where							=   array();
	    $urlarr							=   $_GET;
	    $keywordStr						=   trim($_GET['keyword']);
		if($_GET['news_search']){
			if (!empty($keywordStr) && $_GET['typeca']=='1') {
				
				$where['order_id']		=	array('like', $keywordStr);
				
			}elseif(!empty($keywordStr) && $_GET['typeca']=='2'){
				
				$UserinfoM				=	$this -> MODEL('userinfo');
				$orderinfo				=	$UserinfoM -> getList(array('username'=>array('like',$keywordStr)),array('field'=>'uid'));
				
				if (is_array($orderinfo)){
					foreach ($orderinfo as $val){
						$orderuids[]	=	$val['uid'];
					}
					$where['uid']		=	array('in', pylode(",",$orderuids));
				}
			}
			$urlarr['keyword']			=	$keywordStr;
			$urlarr['typeca']			=	$_GET['typeca'];
			$urlarr['news_search']		=	$_GET['news_search'];
		}
		if($_GET['order_state']!=""){
			$where['order_state']		=	$_GET['order_state'];

			$urlarr['order_state']		=	$_GET['order_state'];
		}
		if($_GET['time']){
			if($_GET['time'] == 1){
				$where['time']	=	array('>=',strtotime(date("Y-m-d 00:00:00")));
			}else{
				$where['time']	=	array('>=',strtotime('-'.intval($_GET['time']).' day'));
			}
			$urlarr['time']				=	$_GET['time'];
		}
		
		$urlarr['page']					=	"{{page}}";
		
		$pageurl						=	Url($_GET['m'],$urlarr,'admin');
		
		$pageM							=	$this  -> MODEL('page');
		
		$pages							=	$pageM -> pageList('member_withdraw',$where,$pageurl,$_GET['page']);

		if($pages['total'] > 0){
	        //limit order 只有在列表查询时才需要
	        if($_GET['order']){
	            $where['orderby']		=	$_GET['t'].','.$_GET['order'];

	            $urlarr['order']		=	$_GET['order'];
	            $urlarr['t']			=	$_GET['t'];
	        }else{
	            $where['orderby']		=	array('id,desc');
	        }
	        $where['limit']				=	$pages['limit'];

	        $rows    					=   $packM -> getList($where,array('utype'=>'admin'));
	    }
        $this->yunset("get_type", $_GET);
		$this->yunset("rows",$rows);
		$this->yuntpl(array('admin/admin_withdraw'));
	}
	function setpay_action(){
		$this -> check_token();
		$id			=	intval($_GET['id']);
		$packM		=	$this -> MODEL('pack');
		$return		=	$packM -> setPay($id);
		$this -> layer_msg($return['msg'],$return['errcode'],0,$_SERVER['HTTP_REFERER']);
	}
	function del_action(){
		$this -> check_token();
		$packM		=	$this -> MODEL('pack');
		$id			=	intval($_GET['id']);
		$return		=	$packM -> delWithDraw($id);
		$this -> layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
	}
}
?>