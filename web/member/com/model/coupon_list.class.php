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
class coupon_list_controller extends company
{	
	//优惠券列表
	function index_action(){

		$couponM	=	$this	->	MODEL('coupon');
		$couponM	->	upCouponList(array('uid'=>$this->uid,'validity'=>array('<',time()),'status'=>'1'),array('status'=>'3'));
		$this		->	public_action();
		$this		->	company_satic();
		$urlarr['c']	=	'coupon_list';
		$urlarr["page"]	=	"{{page}}";
		$pageurl		=	Url('member',$urlarr);
		$where		=	array('uid'=>$this->uid,'orderby'=>'id,desc');
		$pageM		=	$this  -> MODEL('page');
		$pages		=	$pageM -> pageList('coupon_list',$where,$pageurl,$_GET['page']);

		if($pages['total'] > 0){
		    
		    $where['limit']		=	$pages['limit'];
		    $rows				=	$couponM	->	getCouponList($where,array('source'=>1));
		    $this	->	yunset("rows",$rows);
		}
		 
		$this	->	com_tpl('coupon_list');
	}
	//赠送优惠券搜索企业
	function searchcomname_action(){
		$name	=	trim($_POST['username']);
		if($name){
			$companyM	=	$this	->	MODEL('company');
			$where		=	array(
				'name'		=>	array('like',$name),
				'uid'		=>	array('<>',$this->uid),
				'orderby'	=>	'lastupdate,desc',
				'limit'		=>	100
			);
			$company	=	$companyM	->	getList($where,array('field'=>'`uid`,`name`','url'=>1));

			echo json_encode($company['list']);die;
		
		}
	}
	//赠送优惠券给指定企业
	function save_action(){
		$data['coupon']		=	intval($_POST['coupon']);
		$data['send']		=	1;
		$addData['uid']		=	intval($_POST['buid']);
		$addData['source']	=	$this	->	uid;
		
		$where['uid']		=	$this	->	uid;
		$couponM			=	$this	->	MODEL('coupon');
		$return				=	$couponM->	upCouponList($where,$addData,$data);
		$this	->	ACT_layer_msg($return['msg'],$return['cod'],$_SERVER['HTTP_REFERER']);
	}
	//删除优惠券
	function del_action(){
		if($_GET['id']){
			$data['uid'] 		=	$this	->	uid;
			$data['usertype']	=	$this	->	usertype;
			$where['uid']		=	$this	->	uid;
			$where['id']		=	intval($_GET['id']);
			$where['status']	=	array('in',pylode(',',array('2','3')));
			$couponM			=	$this	->	MODEL('coupon');
			$return				=	$couponM->	delCouponList($where,$data);
			
			$this	->	layer_msg($return['msg'],$return['cod'],0,"index.php?c=coupon_list");
		}
	}
	//暂不确定
	function getCouponList_action() {
	    
	    if ($_POST) {
	        
	        $price      =   $_POST['price'];
	        $type       =   $_POST['type'];
	        $couponM    =   $this->MODEL('coupon');
	        $couponList =   $couponM -> getCouponList(array('uid' => $this->uid));
	        
	        if (!empty($couponList) && is_array($couponList)) {
	            
	            $html  =   '';
	            
	            foreach ($couponList as $v){
	                
	                if ($v['coupon_scope'] <= $price && $v['status'] == 1 && $v['validity'] > time()) {
	                     
	                   $html   .=  "<li data-id='".$v['id']."' data-price='".$v['coupon_amount']."' data-name='".$v['coupon_name']."' data-type='".$type."'><span class='yun_purchase_yhq_xz'></span>".$v['coupon_name']."（满".$v['coupon_scope']."元可用）</li>";
	                      
	                } 
	            }
	            
	            $html  .=  '<li><span class="yun_purchase_yhq_xz"></span>不使用优惠券</li>';
	        }else{
	            
	            $html   =  '<li><span class="yun_purchase_yhq_xz"></span>暂无可用优惠券</li>';
	        }
	        
	        echo $html;die; 
	    }
	}
}
?>