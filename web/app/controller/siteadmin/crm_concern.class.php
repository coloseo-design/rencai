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

class crm_concern_controller extends siteadmin_controller
{

    function index_action()
    {
        $crmM               =   $this -> MODEL('crm');
        
        $where              =   array();
        $where['uid']       =   $_SESSION['auid'];
		$time				=	intval($_GET['day']);
		
		if(!empty($time)){

			if($time == 1){ //今天
			    
			    $startTime   =   mktime(0,0,0,date('m'),date('d'),date('y'));
			    $endTime     =   time();  

			}else if($time == 2){//昨天
			    
			    $startTime   =   mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'));
			    $endTime     =   mktime(23, 59, 59, date('m'), date('d') - 1, date('Y'));
			
			}else if($time == 3){//本周
			    
			    $startTime   =	strtotime(date('Y-m-d', strtotime("this week Monday", time())));
			    $endTime     =	strtotime(date('Y-m-d', strtotime("this week Sunday", time()))) + 24 * 3600 - 1;
			
			}else if($time == 4){//本月
			    
			    $startTime   =	mktime(0, 0, 0, date('m'), 1, date('Y'));
			    $endTime     =	mktime(23, 59, 59, date('m'), date('t'), date('Y'));

			}
			
			$where['PHPYUNBTWSTART_A']   =   '';
			
			$where['time'][]             =   array('>=', $startTime, 'AND');
			$where['time'][]             =   array('<=', $endTime,'AND');
			
			$where['PHPYUNBTWEND_A']     =   '';
			
			
			$urlarr['day']  =   $time;
		}
		 
        
        $urlarr['page']	    =	'{{page}}';
        
        $pageurl            =	Url($_GET['m'], $urlarr, 'admin');
        
        $pageM              =	$this  -> MODEL('page');
        
        $pages              =	$pageM -> pageList('crmnew_concern', $where, $pageurl, $_GET['page']);
        
        if ($pages['total'] > 0) {
            
            if ($_GET['order']) {
                
                $where['orderby']   =   $_GET['t'].','.$_GET['order'];
                $urlarr['order']    =   $_GET['order'];
                $urlarr['t']        =   $_GET['t'];
                
            }else{
                
                $where['orderby']   =   'time';
                
            }
            
            $where['limit']         =   $pages['limit'];
            
            $list                   =   $crmM -> getConcernList($where, array('utype' => 'crm'));
            
            $this -> yunset(array('rows' => $list, 'auid' => intval($_SESSION['auid'])));
            
        }
        $this ->  siteadmin_tpl(array('crm_concern'));
    }

    function add_action()
    {
        $id     =   intval($_GET['id']);
        
        if (!empty($id)) {
            
            $crmM   =   $this -> MODEL('crm');
            
            $cInfo  =   $crmM -> getConcernInfo(array('id' => $id));
            $cInfo['time']  =   $cInfo['time'] * 1000;
            
            if (!empty($cInfo['taskid'])) {
                
                $tInfo  =   $crmM   ->  getTaskInfo(array('id' => intval($cInfo['taskid'])));
                $tInfo['stime'] =   $tInfo['stime'] * 1000;
                $this   ->  yunset('tinfo', $tInfo);
            }
            $this   ->  yunset('row', $cInfo);
        }
        
        
        $comid  =   intval($_GET['comid']);
        
        $comM   =   $this -> MODEL('company');
        
        if (!empty($comid)) {
        
            $com    =   $comM -> getInfo($comid, array('field' => '`uid`, `name`,`crm_status`'));
            
            $this   ->  yunset('com', $com);
            
        }else {
            
            $coms   =   $comM -> getList(array('crm_uid' => intval($_SESSION['auid'])), array('field' => '`uid`, `name`'));
            
            $this   ->  yunset('coms', $coms['list']);
        }
        
        $cacheM =   $this -> MODEL('cache');
        
        $cache  =   $cacheM -> GetCache(array('crm'));
        
        $this   ->  yunset('cache', $cache);
        
        $ratingM   =   $this -> MODEL('rating');
        
        $rating    =   $ratingM -> getList(array('category' => '1', 'orderby' => 'sort,asc'), array('field' => '`id`,`name`'));
        
        $this  ->  yunset('rating_list',$rating);
        
        $this->yuntpl(array('admin/crm_concern_add'));
    }
    
    function save_action() {
           
        if ($_POST['submit']) {
            
            $comid      =   intval($_POST['comid']);
            
            $status     =   intval($_POST['status']);

            $c_status	=   intval($_POST['c_status']);
            
            $comM       =   $this -> MODEL('company');
            
            $cominfo    =   $comM -> getInfo($comid, array('field' => '`crm_status`'));
            
            if ($c_status != $cominfo['crm_status']) {
                
                $comM   -> upInfo($comid, '', array('crm_status' => $c_status));
                
            }
            
            $crmM       =   $this -> MODEL('crm');
            
            /* 新增跟进记录数据 */
            $conData    =   array(
                
                'uid'       =>  intval($_SESSION['auid']),
                'comid'     =>  intval($_POST['comid']),
                'time'      =>  $_POST['time'],
                'type'      =>  intval($_POST['type']),
                'content'   =>  $_POST['content'],
                'status'    =>  $status,
                'note'      =>  $_POST['note']
                
            );
            
            $nid        =   $crmM -> addConcern($conData);
            
            if ($nid) {
    
                
                $comM -> upInfo($comid, array('isfollow' => '1')); // 更细跟进字段
                    
                if ($_POST['c_status'] == '9' && !empty($_POST['rating_name'])) {   // 成单客户，新建订单（待审核）
                    
                    $dealData  =   array(
                        
                        'uid'      =>  $comid,
                        'rating'   =>  intval($_POST['rating_name']),
                        'crm_uid'  =>  $_SESSION['auid']
                        
                    );
                    
                    $crmM  -> addDeal($dealData);
                    
                }
                
                if ($_POST['is_task'] == 'on') {   // 新建待办任务
                    
                    $taskData      =   array(
                        
                        'title'    =>  $_POST['title'],
                        'stime'    =>  $_POST['stime'],
                        'content'  =>  $_POST['task_content'],
                        'comid'    =>  $comid,
                        'uid'      =>  $_SESSION['auid'],
                        'cid'      =>  $nid,
                        'auid'     =>  $_SESSION['auid']
                        
                    );
                    
                    $crmM -> addWaitingTask($taskData);
                    
                }
                
            }
            
            $msg        =   $nid ? '跟进记录（ID：'.$nid.'）添加成功！' : '跟进记录添加失败，请重试！';
            
            $layType    =   $nid ? 9 : 8 ;
            
            $url        =   'index.php?m=crm_concern';
            
            $this  -> ACT_layer_msg($msg, $layType, $url);
            
        }
        
    }
    
    function show_action()
    {
        $id     =   intval($_POST['id']);
        
        if (!empty($id)) {
            
            $cacheM    =   $this->MODEL('cache');
             
            $cache     =   $cacheM -> GetCache(array('crm'));
             
            
            $crmM   =   $this -> MODEL('crm');
            
            $cInfo  =   $crmM -> getConcernInfo(array('id' => $id));
            
            if ($cInfo) {
                
                $cInfo['time']      =   date('Y-m-d H:i:s', $cInfo['time']);
                $cInfo['atime']     =   date('Y-m-d H:i:s', $cInfo['atime']);
                
                $cInfo['uptime']    =   $cInfo['uptime']? date('Y-m-d H:i:s', $cInfo['uptime']) : '';
                
                $cInfo['type']      =   $cache['crmclass_name'][$cInfo['type']];
                $cInfo['status']    =   $cache['crmclass_name'][$cInfo['status']];
                
                $comM   =   $this -> MODEL('company');
                $com    =   $comM -> getInfo($cInfo['comid'], array('field'=>'`name`,`crm_status`'));
                
                $cInfo['name']      =   $com['name'];
                
                $cInfo['c_status']  =   $cache['crmclass_name'][$com['crm_status']];
                
            }
            
            echo json_encode($cInfo);die;
            
        }
      
    }

	function del_action(){
	
		$this	->	check_token();
		
		$crmM	=	$this -> Model('crm');
		
		$delID	=	$_GET['id'] ? intval($_GET['id']) : $_GET['del'];
		
		$err	=	$crmM -> delConcern($delID);
		
		$this   ->  layer_msg( $err['msg'],$err['errcode'],$err['layertype'],$_SERVER['HTTP_REFERER'],2,1);

	}
}

?>