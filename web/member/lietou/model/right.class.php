<?php
/* *
* $Author ：PHPYUN开发团队
*
* 官网: http://www.phpyun.com
*
* 版权所有 2009-2021 宿迁鑫潮信息技术有限公司，并保留所有权利。
*
* 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
*/
class right_controller extends lietou{
	function index_action(){

        $sy_only_price  =   @explode(',',$this->config['sy_only_price']);
        if (in_array('vip', $sy_only_price)){
            $this->yunset('meal',1);
        }

		$ratingM	=	$this->MODEL('rating');
		
		$where['display']		=	'1';
		$where['category']		=	'2';
		$where['type']			=	'1';
		$where['service_price']	=	array('>', 0);
		$where['orderby']		=	array('type,asc', 'sort,asc');
		
		$rows		=	$ratingM->getList($where,array('coupon'=>1));
		
		$this->public_action();
		$this->yunset("rows",$rows);
		$this->yunset("class","29");
		$this->lietou_tpl('member_right');
	}
	function time_action(){

        $sy_only_price  =   @explode(',',$this->config['sy_only_price']);
        if (in_array('vip', $sy_only_price)){
            $this->yunset('meal',1);
        }

		$ratingM	=	$this->MODEL('rating');
		
		$where['display']		=	'1';
		$where['category']		=	'2';
		$where['type']			=	'2';
		$where['service_price']	=	array('>', 0);
		$where['orderby']		=	array('type,asc', 'sort,asc');
		
		$rows		=	$ratingM->getList($where,array('coupon'=>1));
		
		$this->public_action();
		$this->yunset("rows",$rows);
		$this->yunset("class","29");
		$this->lietou_tpl('member_time');
	}
	function added_action(){
		$lietouM	=	$this->MODEL('lietou');
		$ratingM	=	$this->MODEL('rating');
		
		$rows		=	$lietouM->getLtserviceList(array('display'=>'1','orderby'=>'id,desc'));
		
		$id			=	intval($_GET['id']);
		
		if ($id){
			
			$info	=	$lietouM->getLtservicedetailList(array('type'=>$id,'orderby'=>'service_price,asc'));
			
		}else{
			
			$row	=	$lietouM->getLtserviceInfo(array('display'=>'1'),array('field'=>'id'));
			
			$info	=	$lietouM->getLtservicedetailList(array('type'=>$row['id'],'orderby'=>'service_price,asc'));
			
		}
		
		$statis		=	$lietouM->getLtStatisInfo(array('uid'=>$this->uid));
		
		if ($statis){
			$rating		=	$statis['rating'];
			$discount	=	$ratingM->getInfo(array('id'=>$rating));
			$this->yunset("discount",$discount);
		}
		
		$this->public_action();
		$this->yunset("statis",$statis);
		$this->yunset("info",$info);
		$this->yunset("rows",$rows);
		$this->lietou_tpl('added');
	}
}
?>