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
class yp_resume_controller extends lietou
{
 	function index_action()
	{
		$JobM       		=   $this -> MODEL('job');
		
		$where['com_id']	=  $this -> uid;
		$where['type']	  =  3;
		$where['isdel']	  =  9;
		 //分页链接
		$urlarr['c']	=	$_GET['c'];
        $urlarr['page']	=	'{{page}}';
        $pageurl		=	Url('member',$urlarr);

        $pageM			=	$this  -> MODEL('page');
        $pages			=	$pageM -> pageList('userid_job',$where,$pageurl,$_GET['page']);

        if($pages['total'] > 0){
			
            if($_GET['order']){
                
                $where['orderby']		=	$_GET['t'].','.$_GET['order'];
                $urlarr['order']		=	$_GET['order'];
                $urlarr['t']			=	$_GET['t'];
                
            }else{
                
                $where['orderby']		=	array('id,desc');
            }
            
            $where['limit']				=	$pages['limit'];
            
            $rows    =   $JobM -> getSqJobList($where,array('utype'=>'lietou'));
			$this->yunset("list",$rows);
        }
		$this -> public_action();
		$this -> lietou_tpl('yp_resume');
 	}
 	function del_action(){
 		if($_POST['delid'] || $_GET['del'])
 		{
			$JobM   =   $this -> MODEL('job');
			if(is_array($_POST['delid'])){
				$id =   $_POST['delid'];
			}else{
				$id =   intval($_GET['del']);
			}
			$arr    =   $JobM -> delSqJob($id,array('utype'=>'lietou','uid'=>$this->uid,'usertype'=>$this->usertype));
			
			$this ->  layer_msg($arr['msg'], $arr['errcode'], $arr['layertype'],$_SERVER['HTTP_REFERER']);
 		}
 	}
}
?>