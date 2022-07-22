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
class subject_add_controller extends train{
  
	function index_action(){

		$UserinfoM	=	$this->MODEL('userinfo');
		$TrainM		=	$this->MODEL('train');


		$train	=	$UserinfoM->getUserInfo(array('uid'=>$this->uid),array('usertype'=>'4','field'=>'name,r_status'));
    	if($train['name']==""){
			$this->ACT_msg("index.php?c=info","请先完善基本资料！");
		}
		$teach	=	$TrainM->getPxTeacherNum(array('uid'=>$this->uid,'status'=>1));
		$this->yunset("teach",$teach);
		
		$tinfo	=	$TrainM->getTeaList(array('uid'=>$this->uid,'status'=>1),array('field'=>'id,name'));
		$this->yunset("teachinfo",$tinfo);
		
		$row	=	$TrainM->getSubInfo(array('uid'=>$this->uid,'id'=>(int)$_GET['id']));
		$row['type']=@explode(",",$row['type']);
		$row['teachid']=@explode(',',$row['teachid']);
		$this->yunset("row",$row);
    	$this->yunset("train",$train);
		$this->yunset($this->MODEL('cache')->GetCache(array('city','subject','subjecttype')));

		$this->train_satic();

		$this->train_tpl('subject_add');
	}
	function save_action(){

		$TrainM		=	$this->MODEL('train');

		$pinfo		=	$this->pxInfo;
		
		$rstatus	=	$pinfo['r_status'];
		
		$post	=	array(
			'name'			=>	$_POST['name'],
			'nid'			=>	$_POST['nid'],
			'tnid'			=>	$_POST['tnid'],
			'provinceid'	=>	$_POST['provinceid'],
			'cityid'		=>	$_POST['cityid'],
			'threecityid'	=>	$_POST['threecityid'],
			'address'		=>	$_POST['address'],
			'hours'			=>	$_POST['hours'],
			'price'			=>	$_POST['price'],
			'isprice'		=>	$_POST['isprice'],
			'moblie'		=>	$_POST['moblie'],
			'crowd'			=>	$_POST['crowd'],
			'superiority'	=>	$_POST['superiority'],
			'content'		=>	$_POST['content'],
			'r_status'		=>	$rstatus,
			'type'			=>	pylode(',',$_POST['type']),
			'teachid'		=>	pylode(',',$_POST['teachid']),
			'file'			=>	$_FILES['file'],
			'status'		=>	0
		);
		$row	=	$TrainM->getSubInfo(array('uid'=>$this->uid,'id'=>(int)$_POST['id'],'pic'=>array('<>','')));
		
		$data=array(
			'post'		=>	$post,
			'id'		=>	(int)$_POST['id'],
			'uid'		=>	$this->uid,
			'usertype'	=>	$this->usertype,
			'did'		=>	$this->userdid
		);

		$return	=	$TrainM->addSubjectInfo($data);
		$this->ACT_layer_msg($return['msg'],$return['errcode'],$return['url']);
	}
}
?>