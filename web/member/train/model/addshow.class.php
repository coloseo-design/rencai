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
class addshow_controller extends train{
	function index_action(){

		$this	->	train_tpl('addshow');
	}
	function save_action(){

	    $UploadM	=	$this	->	MODEL("upload");

	    if (!empty($_FILES)){
	        
	        
	        $data=array(
	            'uid'	=>	$this->uid,
	            'title' =>  $this->stringfilter($_FILES['file']['name']),
	            'status'=>	$this ->pxInfo['r_status']==0?1:$this->config['px_show_status'],
	            'ctime'	=>	time(),
	            'file'	=>	$_FILES['file']
	        );
	        $trainM	=	$this	->	MODEL('train');

	        $id		=	$trainM	->	addPxshowInfo($data,
	        	array(
	        		'member'	=>	'train',
	        		'uid'		=>	$this->uid,
	        		'usertype'	=>	$this->usertype
	        	)
	        );
	        $arr	=	array(
	            'jsonrpc'	=>	'2.0',
	            'id'		=>	$id
	        );
	        echo json_encode($arr);die;
	    }
	}
}
?>