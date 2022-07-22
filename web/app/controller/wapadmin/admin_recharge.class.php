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
class admin_recharge_controller extends adminCommon{
	function index_action(){
		$OrderM		=	$this -> MODEL('companyorder');
		$RatingM	=	$this -> MODEL('rating');
		if(isset($_POST['insert'])){
			$userarr	=	str_replace('，', ',', trim($_POST['userarr']));
			$userarr	=	@explode(',',trim($userarr));
			$post		=	array(
				'fs'			=>  intval($_POST['fs']),
				'price_int'		=>  trim($_POST['price_int']),
				'remark'		=>  trim($_POST['remark'])
			);
			$return			=	$OrderM -> PayMember($userarr,$post);
			$data['msg']	=	$return['msg'];
			$data['url']	=	$_SERVER['HTTP_REFERER'];
			$this->yunset("layer",$data);
		}
        $this->yunset("headertitle","会员充值");
		$this->yuntpl(array('wapadmin/admin_recharge'));
	}
	
}
?>