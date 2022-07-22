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
class pl_controller extends company{
	//企业评论
	function index_action(){
		
		$CompanyM	=	$this -> MODEL('company');
		
		$where['cuid']		=	$this->uid;
		
		$where['status']	=	'1';
		
		$urlarr		=	array("c" => "pl","page" => "{{page}}");
		
		$pageurl	=	Url('member',$urlarr);
		
		$pageM		=	$this  -> MODEL('page');
		
		$pages		=	$pageM -> pageList('company_msg',$where,$pageurl,$_GET['page'],$this->config['sy_listnum']);
		
		if($pages['total'] > 0){
			
			$where['limit']		=	$pages['limit'];
			
			$rows	=	$CompanyM -> getCompanyMsgList($where);
		}
		$this -> yunset("rows",$rows);
		
		$this -> company_satic();
		
		$this -> public_action();
		
		$this -> com_tpl('pl');
	
	}
	
	function save_action(){
		
		$CompanyM	=	$this -> MODEL('company');
		
		if($_POST['submit']){
			
			$data['reply']					=	$_POST['reply'];
			
			$data['reply_time']				=	time();
			
			$id		=	$CompanyM -> upReplyCompanymsgInfo(array('id' => $_POST['id'], 'cuid' => $this -> uid),$data);
			
			if($id){
				
				$this ->MODEL('log')-> addMemberLog($this -> uid, 2,"回复企业评论",18,1);//会员日志
 				
				$this->ACT_layer_msg("回复成功！",9,"index.php?c=".$_GET['c']);
 			
			}else{
 				
				$this->ACT_layer_msg("添加失败！",8,"index.php?c=".$_GET['c']);
 			
			}
		
		}
	
	}
	
}
?>