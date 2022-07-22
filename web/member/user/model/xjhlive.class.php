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
class xjhlive_controller extends user{
    //预约直播列表
    function index_action(){
		$xjhM		=	$this->MODEL('xjhlive');
		
		$where			=	$urlarr =   array();
        
        $where['uid']   =   $this->uid;

        $urlarr['c']    =   $_GET['c'];
        $urlarr['page'] =   '{{page}}';
        $pageurl        =   Url('member', $urlarr);

        $pageM          =   $this -> MODEL('page');
        $pages          =   $pageM -> pageList('xjhlive_yy', $where, $pageurl, $_GET['page']);

        if ($pages['total'] > 0) {
            $where['orderby']   =   'ctime,desc';
            $where['limit']     =   $pages['limit'];
			
			$List	=	$xjhM -> getyyList($where);
        }
        $this -> yunset('rows', $List);
		$this->public_action();
		$this->user_tpl('xjhlive');
    }
    
	//删除预约直播
	function delXjhLiveyy_action(){
		
		if($_GET['del']){
			
			$xjhM	    =	$this->MODEL('xjhlive');
			
			$id			=   intval($_GET['del']);
			
			$arr		=   $xjhM -> delyy($id, array('uid' => $this->uid, 'usertype' => $this->usertype));
			
			$this ->  layer_msg($arr['msg'], $arr['errcode'], $arr['layertype'],$_SERVER['HTTP_REFERER']);
		}
    }
    
}
?>