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
class crm_out_controller extends adminCommon
{

    function index_action()
    {
        $cacheM     =   $this -> MODEL('cache');
        
        $crmCache   =   $cacheM -> GetCache(array('crm'));
        
        $this->yunset(array('crmClassName' => $crmCache['crmclass_name'], 'crmType' => $crmCache['crmdata']['client_type'], 'outClass' => $crmCache['crmdata']['crm_outclass'],'followWay' => $crmCache['crmdata']['follow_way']));

        $where      =   $urlarr =   array();
        
        $crmM       =   $this->MODEL('crm');
        
        $where['auid']  =   $_SESSION['auid'];
        
        if ($_GET['otime']) {
            
            $otime      =   intval($_GET['otime']);
            
            $startTime  =	time();
            
            if ($otime == 1) {      // 3天内
                
                $endTime    =	strtotime('+ 3 day');
                
            }else if($otime == 2){  // 一周内
                
                $endTime    =	strtotime('+ 7 day');
                
            }else if($otime == 3){  // 一月内
                
                $endTime    =	strtotime('+ 30 day');
                
            }
            
            $where['PHPYUNBTWSTART_A']  =   '';
            $where['stime'][]           =   array('>=', $startTime, 'AND');
            $where['stime'][]           =   array('<=', $endTime,'AND');
            $where['PHPYUNBTWEND_A']    =   '';
            
            $urlarr['otime']    =   $otime;
        }
        
        if ($_GET['oreason']) {
            
            $oreason            =   intval($_GET['oreason']);
            $where['reason']    =   $oreason;
            $urlarr['oreason']  =   $oreason;
        }
		$urlarr        		=   $_GET;
        $urlarr['page'] =   '{{page}}';

        
        $pageurl        =   Url($_GET['m'], $urlarr, 'admin');
        $pageM          =   $this->MODEL('page');
        $pages          =   $pageM->pageList('crm_out', $where, $pageurl, $_GET['page']);
        
        if ($pages['total'] > 0) {
            if ($_GET['order']) {

                $where['orderby']   =   $_GET['t'].','.$_GET['order'];
                $urlarr['order']    =   $_GET['order'];
                $urlarr['t']        =   $_GET['t'];
            } else {
                
                $where['orderby']   =   'ctime,desc';
            }
            
            $where['limit']     =   $pages['limit'];

            $list   =   $crmM -> getOutList($where);

            $this->yunset(array('tasks' => $list));
        }
        $this->yuntpl(array('admin/crm_out'));
    }

    function add_action()
    {
        if ($_POST) {
            $crmM   = $this->MODEL('crm');

            $_POST['auid'] = $_SESSION['auid'];

            $return = $crmM->addOut($_POST);

            echo json_encode($return);
            die();
        }
    }

    function del_action()
    {
        $crmM	=	$this -> MODEL('crm');

        $return	=	$crmM -> delOut((int) $_GET['id'], array('auid' => $_SESSION['auid']));

        $this->layer_msg($return['msg'], $return['errcode'], $return['layertype'], $_SERVER['HTTP_REFERER']);
    }
}

?>