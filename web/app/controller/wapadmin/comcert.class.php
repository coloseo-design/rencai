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
class comcert_controller extends adminCommon{ 
	function index_action(){
		$CompanyM       =   $this->MODEL('company');
		$where['type']  =   3;
		if($_GET['status']){
			$status		=	intval($_GET['status']);
			$where['status']	=	$status == 3 ? 0 : $status;
			$urlarr['status']	=	$status;
		}
		$urlarr['c']	=	$_GET['c'];
		$urlarr['page']	=	"{{page}}";
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');
		$pageM	=	$this  -> MODEL('page');
		$pages	=	$pageM -> pageList('company_cert',$where,$pageurl,$_GET['page']);
		if($pages['total'] > 0){
			$where['orderby']	=	'id';
			$where['limit']		=	$pages['limit'];
			$rows				=	$CompanyM -> getCertList($where, array('utype'=>'comcert'));
		}
		$this->yunset("rows",$rows); 
		$this->yunset("backurl", 'index.php?c=company');
		$this->yunset("headertitle","企业认证");
		$this->yuntpl(array('wapadmin/admin_comcert'));
	}
	function show_action(){
		$CompanyM	=	$this -> MODEL('company');
		if(intval($_GET['id'])){
			$row	=	$CompanyM -> getCertInfo(array('id'=>intval($_GET['id']),'type'=>'3'));
			$com	=	$CompanyM -> getInfo($row['uid'],array('field'=>'`name`'));
			$this->yunset("com",$com); 
		}	
		$lasturl	=	$_SERVER['HTTP_REFERER'];
		if(strpos($lasturl, 'a=show')===false){
		    if(strpos($lasturl, 'c=comcert')!==false){
		        $this->cookie->setcookie('lasturl',$lasturl,time()+300);
		        $_COOKIE['lasturl']	=	$lasturl;
		    }
		}
		$this->yunset('lasturl',$_COOKIE['lasturl']);
		$this->yunset("row",$row); 
		$this->yunset("headertitle","企业认证设置");
		$this->yuntpl(array('wapadmin/admin_comcertshow'));
	} 
	function status_action(){ 
		$CompanyM		=	$this -> MODEL('company');
		$Companyorder   =   $this -> MODEL('companyorder');
		if($_POST['id']){
			$row	=	$CompanyM -> getCertInfo(array('id'=>$_POST['id']));
			$uid	=	$row['uid'];
			if($_POST['status']!="1"){
				$yyzz_status	=	2;
			}else{
				$yyzz_status	=	1;
				// 如果是“审核通过”，判断之前是否有过“审核通过的记录”，没有则增加企业资质审核通过的积分（只有第一次审核通过才加积分） 
				$num	=	$Companyorder -> getCompanyPayNum(array('com_id'=>$uid,'pay_remark'=>'认证企业资质'));
				if($num<1){
					$this->MODEL('integral')->invtalCheck($uid,2, 'integral_comcert', '认证企业资质');
				}
			}
			$CompanyM -> upInfo($uid,'',array('yyzz_status'=>$yyzz_status));
			$id		  	=	$CompanyM -> upCertInfo(array('uid'=>$uid,'type'=>'3'),array('status'=>$_POST['status'],'statusbody'=>$_POST['statusbody']),array('utype'=>'admin'));
			$company	=	$CompanyM -> getInfo($uid,array('field'=>'`uid`,`name`,`linkmail`'));
			if($this->config['sy_email_comcert']=='1' && $_POST['status']>0){
				if($_POST['status']=='1'){
					$_POST['statusbody']	=	'企业资质审核通过！';
				}else{
					$_POST['statusbody']	=	'企业资质审核未通过！';
				}
				$Notice	=	$this -> MODEL('notice');
				$Notice	->sendEmailType(array(
					'email'		=>	$company['linkmail'],
					'certinfo'	=>	$_POST['statusbody'],
					'comname'	=>	$company['name'],
					'uid'		=>	$company['uid'],
					'name'		=>	$company['name'],
					'type'		=>	'comcert',
				));
			}
		}
		if ($_POST['lasturl']!=''){
		    $lasturl=$this->post_trim($_POST['lasturl']);
		}else{
		    $lasturl=$_SERVER['HTTP_REFERER'];
		}
		if($id){
		    $this->layer_msg('企业认证审核(ID:'.$_POST['id'].')设置成功！',9,0,$lasturl);
		}else{
		    $this->layer_msg('设置失败！',8);
		}
	}
	function del_action(){
		$CompanyM	=	$this -> MODEL('company');
		if(intval($_GET['id'])){
			$company	=	$CompanyM -> getCertInfo(array('id'=>intval($_GET['id']),'type'=>'3'),array('field'=>'`uid`'));
			$CompanyM -> upInfo($company['uid'],'',array('yyzz_status'=>'0'));
			$delid		=	$CompanyM -> delCert(intval($_GET['id']),array('type'=>'3'));
			$delid?$this->layer_msg($delid['msg'],$delid['errcode'],$delid['layertype'],'index.php?c=comcert'):$this->layer_msg($delid['msg'],$delid['errcode'],$delid['layertype'],$_SERVER['HTTP_REFERER']);
		}
	}
}

?>