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

class crm_concern_controller extends adminCommon
{

    function index_action()
    {
        $crmM               =   $this -> MODEL('crm');
        $adminM             =   $this -> MODEL('admin');
        $where              =   array();
        $where['auid']      =   $_SESSION['auid'];

        if ($_GET['type'] && $_GET['keyword']){

            if ($_GET['type'] == '1'){

                $comM               =   $this->MODEL('company');
                $companyA           =   $comM->getList(array('name' => array('like', trim($_GET['keyword']))), array('field' => 'uid'));

                if (!empty($companyA['list']))
                {

                    $uids           =   array();
                    foreach ($companyA['list'] as $ck => $cv) {
                        $uids[]     =   $cv['uid'];
                    }

                    $where['uid']   =   array('in', pylode(',', $uids));
                }

            }elseif ($_GET['type'] == '2'){

                $where['content']   =   array('like', trim($_GET['keyword']));
            }

            $urlarr['type']         =   $_GET['type'];
            $urlarr['keyword']      =   $_GET['keyword'];
        }

        if ($_GET['day']) {

            unset($_GET['stime']);
            unset($_GET['etime']);

            $time           =   intval($_GET['day']);

            if ($time == 1) { //今天

                $startTime  =   mktime(0, 0, 0, date('m'), date('d'), date('y'));
                $endTime    =   time();
            } else if ($time == 2) {//昨天

                $startTime  =   mktime(0, 0, 0, date('m'), date('d'), date('Y')) - 86400;
                $endTime    =   mktime(23, 59, 59, date('m'), date('d'), date('Y')) - 86400;
            } else if ($time == 3) {//本周

                $startTime  =   strtotime(date('Y-m-d', strtotime("this week Monday", time())));
                $endTime    =   strtotime(date('Y-m-d', strtotime("this week Sunday", time()))) + 24 * 3600 - 1;
            } else if ($time == 4) {//本月

                $startTime  =   mktime(0, 0, 0, date('m'), 1, date('Y'));
                $endTime    =   mktime(23, 59, 59, date('m'), date('t'), date('Y'));
            }
            $where['PHPYUNBTWSTART_A_DOUBLE']   =   '';
            $where['ftime'][]   =   array('>', $startTime, 'AND');
            $where['ftime'][]   =   array('<', $endTime, 'AND');
            $where['PHPYUNBTWEND_A']            =   '';

            $where['PHPYUNBTWSTART_B']          =   'OR';
            $where['atime'][]   =   array('>', $startTime, 'AND');
            $where['atime'][]   =   array('<', $endTime, 'AND');
            $where['PHPYUNBTWEND_B_DOUBLE']     =   '';

            $urlarr['day'] = $time;
        }else if ($_GET['stime']) {

            unset($_GET['day']);

            $stime      =   explode('-', $_GET['stime']);
            $etime      =   explode('-', $_GET['etime']);

            $timeBegin  =   mktime(0, 0, 0, $stime[1], $stime[2], $stime[0]);
            $timeEnd    =   mktime(23, 59, 59, $etime[1], $etime[2], $etime[0]);

            $where['PHPYUNBTWSTART_A_DOUBLE']   =  '';
            $where['ftime'][]                   =   array('>=', $timeBegin, 'AND');
            $where['ftime'][]                   =   array('<=', $timeEnd, 'AND');
            $where['PHPYUNBTWEND_A']            =   '';

            $where['PHPYUNBTWSTART_B']          =   'OR';
            $where['atime'][]                   =   array('>', $timeBegin, 'AND');
            $where['atime'][]                   =   array('<', $timeEnd,'AND');
            $where['PHPYUNBTWEND_B_DOUBLE']     =  '';

            $urlarr['stime']    =   urlencode($_GET['stime']);
            $urlarr['etime']    =   urlencode($_GET['etime']);
        }

        if(!empty($_GET['linktype'])){
            $where['type']		=	$_GET['linktype'];
            $urlarr['linktype']	=	$_GET['linktype'];
        }

        $urlarr        	    =   $_GET;
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
                
                $where['orderby']   =   'atime';
            }
            
            $where['limit']         =   $pages['limit'];
            $list                   =   $crmM -> getConcernList($where, array('utype' => 'crm'));
            $this -> yunset(array('rows' => $list, 'auid' => intval($_SESSION['auid'])));
        }

        $cacheM =   $this->MODEL('cache');
        $cache  =   $cacheM -> GetCache(array('crm'));
        $this -> yunset('cache', $cache);

        $power  =   $adminM -> getPower(array('uid'=>$_SESSION['auid']));
        $this->yunset('power', $power['power']);

        $this->yuntpl(array('admin/crm_concern'));
    }

	function depart_action()
    {

		$AdminM			=	$this -> MODEL('admin');
		$crmM       	=   $this -> MODEL('crm');
		$cacheM 		=   $this -> MODEL('cache');
		$adminUserInfo	=	$AdminM -> getAdminUser(array('uid' => $_SESSION['auid']),array('field'=>'org,power,spower'));
		
		if($adminUserInfo['org'] > 0){
        	
        	$orgInfo	=	$crmM -> getOrgInfo(array('id' => $adminUserInfo['org']));
        	
        	$oIds	=	$orgIds	=	$orgIdss	=	$orgIdsss	=	array();
        	 
        	if ($adminUserInfo['power'] == '1'){	// 同级部门权限
        		$oList				=	$crmM -> getOrgList(array('level' => $orgInfo['level']));
        		
        		foreach ($oList as $k => $v) {
        			$orgIds[]		=	$v['id'];
        		}	
        	}
        	
        	if ($adminUserInfo['power'] == '1'){	// 子部门权限
	        	if ($orgInfo['level'] == '1'){
	        		 
	        		$orgList			=	$crmM -> getOrgList(array('fid' => $adminUserInfo['org']));
	        		
	        		foreach ($orgList as $ok => $ov) {
	        			$orgIdss[]		=	$ov['id'];	
	        		}
	        		
	        		$orgLists			=	$crmM -> getOrgList(array('fid' => array('in', pylode(',', $orgIdss))));
	        		
	        		foreach ($orgLists as $ook => $oov) {
	        			$orgIdsss[]		=	$oov['id'];
	        		}
	        		
	        	}elseif ($orgInfo['level'] == '2'){
	        		 
	        		$orgList			=	$crmM -> getOrgList(array('fid' => $adminUserInfo['org']));
	        		foreach ($orgList as $ok => $ov) {
	        			$orgIdss[]		=	$ov['id'];	
	        		}
	        		
	        	} 
        	}
        	$oIds			=	array_merge($orgIds, $orgIdss, $orgIdsss);
        	
            $adminUserList	=	$AdminM -> getList(array('uid'=>array('<>',$_SESSION['auid']),'org'=>array('in', pylode(',', $oIds))),array('field'=>'`uid`,`name`,`username`'));
    		foreach($adminUserList as $v){
    			$uids[]		=	$v['uid'];
    		}
    		$this->yunset('adminUserList',$adminUserList);
        }

        if ($_GET['type'] && $_GET['keyword']){

            if ($_GET['type'] == '1'){

                $comM               =   $this->MODEL('company');
                $companyA           =   $comM->getList(array('name' => array('like', trim($_GET['keyword']))), array('field' => 'uid'));

                if (!empty($companyA['list']))
                {

                    $uidss          =   array();
                    foreach ($companyA['list'] as $ck => $cv) {
                        $uidss[]    =   $cv['uid'];
                    }

                    $where['uid']   =   array('in', pylode(',', $uidss));
                }

            }elseif ($_GET['type'] == '2'){

                $where['content']   =   array('like', trim($_GET['keyword']));
            }

            $urlarr['type']         =   $_GET['type'];
            $urlarr['keyword']      =   $_GET['keyword'];
        }

        if ($_GET['day']) {

            unset($_GET['stime']);
            unset($_GET['etime']);

            $time       =   intval($_GET['day']);
            if ($time == 1) { //今天

                $startTime  =   mktime(0, 0, 0, date('m'), date('d'), date('y'));
                $endTime    =   time();
            } else if ($time == 2) {//昨天

                $startTime  =   mktime(0, 0, 0, date('m'), date('d'), date('Y')) - 86400;
                $endTime    =   mktime(23, 59, 59, date('m'), date('d'), date('Y')) - 86400;
            } else if ($time == 3) {//本周

                $startTime  =   strtotime(date('Y-m-d', strtotime("this week Monday", time())));
                $endTime    =   strtotime(date('Y-m-d', strtotime("this week Sunday", time()))) + 24 * 3600 - 1;
            } else if ($time == 4) {//本月

                $startTime  =   mktime(0, 0, 0, date('m'), 1, date('Y'));
                $endTime    =   mktime(23, 59, 59, date('m'), date('t'), date('Y'));
            }
            $where['PHPYUNBTWSTART_A_DOUBLE'] = '';
            $where['ftime'][]   =   array('>', $startTime, 'AND');
            $where['ftime'][]   =   array('<', $endTime, 'AND');
            $where['PHPYUNBTWEND_A'] = '';
            $where['PHPYUNBTWSTART_B'] = 'OR';
            $where['atime'][]   =   array('>', $startTime, 'AND');
            $where['atime'][]   =   array('<', $endTime, 'AND');
            $where['PHPYUNBTWEND_B_DOUBLE'] = '';

            $urlarr['day']  =   $time;
        }else if ($_GET['stime']) {

            unset($_GET['day']);

            $stime      =   explode('-', $_GET['stime']);
            $etime      =   explode('-', $_GET['etime']);

            $timeBegin  =   mktime(0, 0, 0, $stime[1], $stime[2], $stime[0]);
            $timeEnd    =   mktime(23, 59, 59, $etime[1], $etime[2], $etime[0]);

            $where['PHPYUNBTWSTART_A_DOUBLE']   =  '';
            $where['ftime'][]                   =   array('>=', $timeBegin, 'AND');
            $where['ftime'][]                   =   array('<=', $timeEnd, 'AND');
            $where['PHPYUNBTWEND_A']            =   '';

            $where['PHPYUNBTWSTART_B']          =   'OR';
            $where['atime'][]                   =   array('>', $timeBegin, 'AND');
            $where['atime'][]                   =   array('<', $timeEnd,'AND');
            $where['PHPYUNBTWEND_B_DOUBLE']     =  '';

            $urlarr['stime']    =   urlencode($_GET['stime']);
            $urlarr['etime']    =   urlencode($_GET['etime']);
        }
		if(!empty($_GET['linktype'])){
			$where['type']		=	$_GET['linktype'];
			$urlarr['linktype']	=	$_GET['linktype'];
		}
		if(!empty($_GET['crmmanager'])) {
			$where['auid']			=	$_GET['crmmanager'];
            $urlarr['crmmanager']	=   $_GET['crmmanager'];
		}else{
			$where['auid']	=	array('in',pylode(',',$uids));
		}

		$urlarr        		=   $_GET;
		$urlarr['page']	    =	'{{page}}';    
        $pageurl            =	Url('crm_concern&c=depart', $urlarr, 'admin');    
        $pageM              =	$this  -> MODEL('page');      
        $pages              =	$pageM -> pageList('crmnew_concern', $where, $pageurl, $_GET['page']);  
		if ($pages['total'] > 0) {   
            if ($_GET['order']) {

                $where['orderby']   =   $_GET['t'].','.$_GET['order'];
                $urlarr['order']    =   $_GET['order'];
                $urlarr['t']        =   $_GET['t'];    
            }else{ 
                $where['orderby']   =   'atime';
            }
            $where['limit']         =   $pages['limit'];
            $list                   =   $crmM -> getConcernList($where, array('utype' => 'crm')); 
            $this -> yunset('rows',$list);
            
        }
        $cache  =   $cacheM -> GetCache(array('crm'));
        $this -> yunset('cache', $cache);
		$this -> yuntpl(array('admin/crm_concern_depart'));
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
		
		$err	=	$crmM -> delConcern($delID, array('auid' => $_SESSION['auid']));
		
		$this   ->  layer_msg( $err['msg'],$err['errcode'],$err['layertype'],$_SERVER['HTTP_REFERER'],2,1);

	}
}

?>