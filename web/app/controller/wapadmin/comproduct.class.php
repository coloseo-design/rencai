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
class comproduct_controller extends adminCommon{ 
	function index_action(){ 
		$CompanyM		=	$this -> MODEL('company');
		$where			=	array();
		if ($_GET['status']) {
			$status		=	intval($_GET['status']);
			$where['status']	=	$status==3 ? 0 : $status;
			$urlarr['status']	=	$status;
		}
		$urlarr['c']	=	$_GET['c'];
		$urlarr['page']	=	"{{page}}";
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');
		$pageM	=	$this -> MODEL('page');
		$pages	=	$pageM -> pageList('company_product',$where,$pageurl,$_GET['page']);
		if($pages['total'] > 0){
			$where['orderby']	=	'id';
			$where['limit']		=	$pages['limit'];
			$rows				=	$CompanyM -> getCompanyProductList($where);
		}
		$this->yunset("rows",$rows); 
		$this->yunset("headertitle","企业产品");
		$this->yuntpl(array('wapadmin/admin_comproduct'));
	}  
	function show_action(){
		$CompanyM	=	$this -> MODEL('company');
		$row		=	$CompanyM -> getComProductInfo(array('id'=>intval($_GET['id'])));
		$com		=	$CompanyM -> getInfo($row['uid'],array('field'=>'`name`'));
		$row['name']=	$com['name'];
		$this->yunset('row',$row);
		$this->yunset("headertitle","企业产品");
		$this->yuntpl(array('wapadmin/admin_comproduct_show'));
	}
	function status_action(){	
		$CompanyM	=	$this -> MODEL('company');
		if($_POST['id']){
			$statusData		=	array(
				'status'		=>	intval($_POST['status']),
				'statusbody'	=>	trim($_POST['statusbody']),
			);
			$nid	=	$CompanyM -> upCompanyProductStatus(intval($_POST['id']),$statusData);
			if($nid){
	            $this->layer_msg('企业产品审核成功！',9,0,"index.php?c=comproduct");
	        }else{
	            $this->layer_msg('企业产品审核失败！',8);
	        }
		}
	}
	function del_action(){ 
		$CompanyM	=	$this -> MODEL('company');
		if(intval($_GET['id'])){
			$return	=	$CompanyM -> delCompanyProduct(intval($_GET['id']));
			if($return['errcode']==9){
				$this->layer_msg($return['msg'],$return['errcode'],$return['layertype'],"index.php?c=comproduct");
			}else{
				$this->layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
			}
		}
	} 
}
?>