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
class xjhlive_controller extends user_controller{
    //宣讲会记录
    function index_action(){

    	$xjhM			=	$this -> MODEL('xjhlive');
		$where['uid']		=	$this->member['uid'];
		$page				=	$_POST['page'];
		
		$limit				=	$_POST['limit'] ? $_POST['limit'] : 10;
		if($page){
			$pagenav		=	($page-1)*$limit;
			$where['limit']	=	array($pagenav,$limit);
		}else{
			$where['limit']	=	$limit;
		}         
		
		$where['orderby']	=	'ctime,desc';
		$rows				=	$xjhM -> getyyList($where);

		$data	=	array();

		if(is_array($rows) && !empty($rows)){
			
			$error	=	0;
		}else{
			$error	=	2;
		}
		$data['list']	=	count($rows) ? $rows : array();
		$this->render_json($error,'',$data);

    }
    //删除宣讲会记录
	function delXjhLiveyy_action(){

		if($_POST['id']){
			
			$id			=	intval($_POST['id']);
			
			$xjhM		=	$this -> MODEL('xjhlive');

	        $return		=	$xjhM -> delyy($id, array('uid'=>$this->member['uid'],'usertype'=>$this->member['usertype']));

	        
	        $error 		= 	$return['errcode']=='9' ? 1 : 2;
	        $msg		=	$return['msg'];
	    }else{
	    	$error 		= 	2;
	        $msg		=	'数据异常，请重试';
	    }

	    $this->render_json($error,$msg);

	}
	//进入宣讲会房间
	function sproom_action(){
	    
	    $id 	  =  $_POST['sid'];
	    $spviewM  =  $this->MODEL('spview');
	    $subnum   =  $spviewM->getSubNum(array('sid'=>$id));
	    $linenum  =  $spviewM->getSubNum(array('sid'=>$id,'status'=>0,'rtime'=>array('>',0)));
	    $msnum    =  $spviewM->getSubNum(array('sid'=>$id,'status'=>2));
	    
	    $return   =  array(
	        'room' => array(
	            'subnum'   =>  $subnum,
	            'linenum'  =>  $linenum,
	            'msnum'    =>  $msnum
	        ),
	    );
	    
	    $this->render_json(0, 'ok', $return);
	}
}