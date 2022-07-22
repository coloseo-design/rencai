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
class crm_worklogall_controller extends adminCommon{
    function index_action() {
        $crmM   		=   $this -> MODEL('crm');
		
        $where              =   array();
        	
		$time				=	intval($_GET['day']);
		
		if(!empty($time)){

			if($time == 1){ //今天
			    
			    $startTime   =   mktime(0,0,0,date('m'),date('d'),date('y'));
			    $endTime     =   time();  

			}else if($time == 2){//昨天
			    
			    $startTime   =   mktime(0, 0, 0, date('m'), date('d'), date('Y')) - 86400;
			    $endTime     =   mktime(23, 59, 59, date('m'), date('d'), date('Y')) - 86400;
			
			}else if($time == 3){//本周
			    
			    $startTime   =	strtotime(date('Y-m-d', strtotime("this week Monday", time())));
			    $endTime     =	strtotime(date('Y-m-d', strtotime("this week Sunday", time()))) + 24 * 3600 - 1;
			
			}else if($time == 4){//本月
			    
			    $startTime   =	mktime(0, 0, 0, date('m'), 1, date('Y'));
			    $endTime     =	mktime(23, 59, 59, date('m'), date('t'), date('Y'));

			}
			
			$where['PHPYUNBTWSTART_A']   =   '';
			
			$where['ctime'][]             =   array('>', $startTime, 'AND');
			$where['ctime'][]             =   array('<', $endTime,'AND');
			
			$where['PHPYUNBTWEND_A']     =   '';
			
			
			$urlarr['day']  =   $time;
		}
        if($_GET['uid']){
            $where['auid']   =   $_GET['uid'];
            $urlarr['uid']  =   $_GET['uid'];
        }
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
        $adminM =   $this -> MODEL('admin');
        $auser  =   $adminM -> getList(array(),array('field'=>'`uid`,`name`'));

        $this -> yunset('auser',$auser);

        $this->yuntpl(array('admin/crm_worklogall'));
    }
	function detail_action(){
		$crmM					=   $this -> MODEL('crm');
		$info					=	$crmM -> getWorkLogInfo(array('id'=>intval($_POST['id'])));
		echo json_encode($info);die;
	}
	function del_action() {
        $crmM   			=   $this -> MODEL('crm');
		$return				=	$crmM->delWorkLog((int)$_GET['id']);
		$this->layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
		
    }
}

?>