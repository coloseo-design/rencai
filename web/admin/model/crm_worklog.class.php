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
class crm_worklog_controller extends adminCommon{
    function index_action() {
        $crmM   		=   $this -> MODEL('crm');
		
        $where['auid']   =   $_SESSION['auid'];
		$urlarr        		=   $_GET;
        $urlarr['page']	    =	'{{page}}';
        $pageurl            =	Url($_GET['m'], $urlarr, 'admin');
        $pageM              =	$this  -> MODEL('page');
        $pages              =	$pageM -> pageList('crm_work_log', $where, $pageurl, $_GET['page']);
        if ($pages['total'] > 0) {
            if ($_GET['order']) {
                
                $where['orderby']   =   $_GET['t'].','.$_GET['order'];
                $urlarr['order']    =   $_GET['order'];
                $urlarr['t']        =   $_GET['t'];
                
            }else{
                $where['orderby'] 	=   'ctime,desc';
            }
            $where['limit']         =   $pages['limit'];
            
            $list                   =   $crmM -> getWorkLogList($where);
            
            $this -> yunset(array('tasks' => $list));
        }
        $this->yuntpl(array('admin/crm_worklog'));
    }

	function add_action(){
		$crmM	=   $this -> MODEL('crm');
		
		$data	=   array(          
			'auid'     	=>  $_SESSION['auid'],
			'title'    	=>  $_POST['logtitle'],
			'content' 	=>  $_POST['logcontent']
        );
        
	   $return	=	$crmM -> addWorkLog($data);
       $this->ACT_layer_msg($return['msg'], $return['errcode'], $_SERVER['HTTP_REFERER']);
	}

	function detail_action()
	{
	
		$crmM	=   $this -> MODEL('crm');
		$info	=	$crmM -> getWorkLogInfo(array('id'=>intval($_POST['id'])));
		echo json_encode($info);
	}

	function del_action() 
	{
	
        $crmM	=	$this -> MODEL('crm');
		$return	=	$crmM->delWorkLog((int)$_GET['id'], array('auid' => $_SESSION['auid']));
		$this->layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
		
    }
}

?>