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
class zixun_controller extends lietou{	
	
	function index_action(){
		
		$MsgM	=	$this -> MODEL('msg');
		
		$where['job_uid']		=	$this -> uid;

		$where['status']		=	1;

		$urlarr		=	array("c" => "msg","page" => "{{page}}");
		
		$pageurl	=	Url('member',$urlarr);
		
		$pageM		=	$this -> MODEL('page');
		
		$pages		=	$pageM -> pageList('msg',$where,$pageurl,$_GET['page'],$this->config['sy_listnum']);
		
		if($pages['total'] > 0){
			
			
			$where['orderby']	=	'id';
			
			
			$where['limit']		=	$pages['limit'];
			
			
			$rows	=	$MsgM -> getList($where);
			
		}
		
		$this->yunset("rows",$rows['list']);
		
		$this->public_action();
	    
		$this->yunset("class",24);
		
		$this->lietou_tpl('zixun');
	
	}
	
	function del_action(){
		
		$SysmsgM	=	$this->MODEL('sysmsg');
		
		if($_POST['delid'] || $_GET['id']){
			
			if($_GET['id']){
				
				$id		=	intval($_GET['id']);
			
			}elseif($_POST['delid']){
				
				$id		=	$_POST['delid'];
			
			}
			
			$return		=	$SysmsgM -> delMsg($id,array('job_uid'=>$this->uid));
			
			$this -> layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
		
		}
	
	}
	
	function sreplys_action(){
		
		$MsgM	=	$this -> MODEL('msg');
		
		if($_POST['submit']){
			
			$data['reply']					=	$_POST['reply'];
			
			$data['reply_time']				=	time();
			
			$data['user_remind_status']		=	'0';
			
			$where['id']					=	(int)$_POST['id'];
			
			$where['job_uid']				=	$this->uid;
			
			$id		=	$MsgM -> upReplyInfo(array('id' => $_POST['id'], 'job_uid' => $this -> uid),$data);
			
			if($id){
 				
				$this ->MODEL('log')-> addMemberLog($this -> uid, 3,"回复求职咨询",18,1);//会员日志
 				
				$this->ACT_layer_msg("回复成功！",9,"index.php?c=zixun");
 			
			}else{
 				
				$this->ACT_layer_msg("添加失败！",8,"index.php?c=zixun");
 			
			}
		}
	}
	
	function replys_action(){
		
		$MsgM	=	$this -> MODEL('msg');
		
		$reply	=	$MsgM->getInfo(array('id'=>$_GET['id'],'job_uid'=>$this -> uid));
		
		$this->yunset("reply",$reply);
		
		$this->yunset("id",$_GET['id']);
		
		$this->public_action();
		
		$this->yunset("class",41);
		
		$this->lietou_tpl('replyss');
	
	}
	
}
?>