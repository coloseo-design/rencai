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
class crm_my_performance_depart_controller extends adminCommon{
    
	
	private function getAuser(){
		
		$AdminM			=	$this -> MODEL('admin');
		
		$adminUserInfo	=	$AdminM -> getAdminUser(array('uid' => $_SESSION['auid']),array('field'=>'org,power,spower'));
		
		if($adminUserInfo['org'] > 0){
			
        	$crmM		=	$this->MODEL('crm');	
        	$orgInfo	=	$crmM -> getOrgInfo(array('id' => $adminUserInfo['org']));
        	
        	$oIds	=	$orgIds	=	$orgIdss	=	$orgIdsss	=	array();
        	 
        	if ($adminUserInfo['power'] == '1'){	// 同级部门权限
        		$oList	=	$crmM -> getOrgList(array('level' => $orgInfo['level']));
        		
        		foreach ($oList as $k => $v) {
        			$orgIds[]	=	$v['id'];
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
    		return $uids;
    	}
	}
	
	private $chartType = 'line';
    
    private function getTotal($timeBegin = '', $timeEnd = ''){
    	
    	$uids	=	$this->getAuser();
//    	$this->yunset('adminUserList',$pData['auser']);
    	
        $comM               =   $this->MODEL('company');
        $where              =   array();
		if($_GET['crmmanager']){
			$where['crm_uid']	=	$_GET['crmmanager'];
		}else{
		    $where['PHPYUNBTWSTART_A']  =   '';
		    $where['crm_uid'][]	        =	array('<>',0,'AND');
		    $where['crm_uid'][]	        =	array('in',pylode(',',$uids),'AND');
		    $where['PHPYUNBTWEND_A']    =   '';
		}
        if ($timeBegin != '') {
            $where['crm_time'][]    =   array('>=', $timeBegin);
            $where['crm_time'][]    =   array('<=', $timeEnd);
        }
        $comlist            =   $comM->getList($where, array('field' => 'count(uid) as `num`'));
        $row                =   $comlist['list'];
        $all                =   isset($row[0]['num']) && $row[0]['num'] > 0 ? $row[0]['num'] : 0;   //  所有客户
        $cwhere             =   array();
		if($_GET['crmmanager']){
			$cwhere['crm_uid']	=	$_GET['crmmanager'];
		}else{
		    $cwhere['PHPYUNBTWSTART_A']  =   '';
		    $cwhere['crm_uid'][]	     =	array('<>',0,'AND');
		    $cwhere['crm_uid'][]	     =	array('in',pylode(',',$uids),'AND');
		    $cwhere['PHPYUNBTWEND_A']    =   '';
		}
        
		$cwhere['isfollow'] =   '0';
        
        if ($timeBegin != '') {
            $cwhere['crm_time'][] = array('>=', $timeBegin);
            $cwhere['crm_time'][] = array('<=', $timeEnd);
        }
        $comlist            =   $comM->getList($cwhere, array('field' => 'count(uid) as `num`'));
        $row                =   $comlist['list'];
        $new                =   isset($row[0]['num']) && $row[0]['num'] > 0 ? $row[0]['num'] : 0;   //  待跟进客户
        $attention          =   $all - $new;    //  已近跟进客户
        return array( $all, $new, $attention);
    }

    public function index_action()
    {
         
    	$uids	=	$this->getAuser();
    	
        list ($all, $new, $attention) = $this->getTotal(strtotime(date('Y-m-01 00:00:00', time())), time());
        $data[]     =   array('time' => '本月', 'all' => $all, 'new' => $new, 'attention' => $attention);

        $timeEnd    =   strtotime(date('Y-m-d 00:00:00', time()));
        $week       =   date('w');
        if ($week == 0)
            $week = 7;
        $week --;
        $monday     =   strtotime("-{$week} day", $timeEnd);
        list ($all, $new, $attention)   =   $this->getTotal($monday, $timeEnd);
        $data[]     =   array('time' => '本周', 'all' => $all, 'new' => $new, 'attention' => $attention);
        $all        =   $this->getTotal($monday, $timeEnd);
        
        list ($all, $new, $attention)   =   $this->getTotal(strtotime('-1 day', $timeEnd), $timeEnd);
        $data[]     =   array('time' => '昨日', 'all' => $all, 'new' => $new, 'attention' => $attention);

        list ($all, $new, $attention) = $this->getTotal();
        $data[]     = array('time' => '累计', 'all' => $all, 'new' => $new, 'attention' => $attention);

        $this->yunset('data', $data);

        if ($_GET['time'] || $_GET['stime'] || $_GET['etime']) {
            if ($_GET['time']) {
                if ($_GET['time'] == - 1) {
                    
                    $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('y'));
                    $timeEnd    =   time();
                    $title      =   "客户统计 - 今天";
                } elseif ($_GET['time'] == 1) {
                    
                    $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('y'))- 86400;
                    $timeEnd    =   mktime(23, 59, 59, date('m'), date('d'), date('Y')) - 86400;
                    $title      =   "客户统计 - 昨天";
                } else {
                    
                    $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('Y')) - $_GET['time'] * 86400;
                    $timeEnd    =   mktime(23, 59, 59, date('m'), date('d'), date('Y'));
                    $title      =   "客户统计 - {$_GET['time']}天内";
                }
            }
            
            if ($_GET['stime']) {
                $stime          =   explode('-', $_GET['stime']);
                $etime          =   explode('-', $_GET['etime']);

                $timeBegin      =   mktime(0, 0, 0, $stime[1], $stime[2], $stime[0]);
                $timeEnd        =   mktime(23, 59, 59, $etime[1], $etime[2], $etime[0]);
                $title          =   "客户统计 - {$_GET['stime']}~{$_GET['etime']}";
            }
            
        } else {
            
            $title              =   "客户统计 - 全部数据";
        }

        $names  =   $values =   $dataGroupNames =   array();
        $where  =   array();
         
		
		if($_GET['crmmanager']){
			$where['crm_uid']	=	$_GET['crmmanager'];
		}else{
		    $where['PHPYUNBTWSTART_A']  =   '';
		    $where['crm_uid'][]	        =	array('<>',0,'AND');
		    $where['crm_uid'][]	        =	array('in',pylode(',',$uids),'AND');
		    $where['PHPYUNBTWEND_A']    =   '';
 		}
        if ($timeBegin != '') {
            $where['crm_time'][]    =   array('>=', $timeBegin);
            $where['crm_time'][]    =   array('<=', $timeEnd);
        }
        
        $where['groupby']   =   'date';
        $where['orderby']   =   'date';
        
        $companyM   =   $this->MODEL('company');
        
        $comlist    =   $companyM -> getList($where, array('field' => "count(uid) as `num`, from_unixtime(crm_time,'%Y-%m-%d') as `date`"));
        
        $row        =   $comlist['list'];
        
        $totalAll   =   0;
        
        if (count($row) < 1) {
            $all    =   array(
                'names'     =>  array(),
                'values'    =>  array()
            );
        } else {
            
            $allNames   =   array();
            $allValues  =    array();
            
            foreach ($row as $r) {
                $allNames[]     =   $r['date'];
                $allValues[]    =   $r['num'];

                $totalAll += $r['num'];
            }
            $all = array(
                'names'     =>  $allNames,
                'values'    =>  $allValues
            );
        }
        
        $cwhere                 =   array();
        
        if($_GET['crmmanager']){
			$cwhere['crm_uid']	=	$_GET['crmmanager'];
		}else{
		    $cwhere['PHPYUNBTWSTART_A']  =   '';
		    $cwhere['crm_uid'][]	     =	array('<>',0,'AND');
		    $cwhere['crm_uid'][]	     =	array('in',pylode(',',$uids),'AND');
		    $cwhere['PHPYUNBTWEND_A']    =   '';
		}
        $cwhere['isfollow']     =   '0';
        
        if ($timeBegin != '') {
            $cwhere['crm_time'][]   =   array('>=', $timeBegin);
            $cwhere['crm_time'][]   =   array('<=', $timeEnd);
        }
        
        $cwhere['groupby']      =   'date';
        $cwhere['orderby']      =   'date';
        
        $comlist    =   $companyM -> getList($cwhere, array('field' => "count(uid) as `num`, from_unixtime(crm_time,'%Y-%m-%d') as `date`"));
        $row        =   $comlist['list'];
        $totalNew   =   0;
        
        if (count($row) < 1) {
            $new    =   array(
                'names'     =>  array(),
                'values'    =>  array()
            );
        } else {
            
            $newNames   =   array();
            $newValues  =   array();
            
            foreach ($row as $r) {
                
                $newNames[]     =   $r['date'];
                $newValues[]    =   $r['num'];

                $totalNew += $r['num'];
            }
            $new    =   array(
                'names'     =>  $newNames,
                'values'    =>  $newValues
            );
        }
        $names  =   array_merge($all['names'], $new['names']);
        $names  =   array_unique($names);
        
        usort($names, 'usortS');

        $allValues  =   $newValues  =   array();
        $allK       =   $newK       =   0;
        
        foreach ($names as $n) {
            if (in_array($n, $all['names'])) {
                
                $allValues[]    =   $all['values'][$allK];
                $allK ++;
            } else {
                
                $allValues[]    =   0;
            }

            if (in_array($n, $new['names'])) {
                
                $newValues[]    =   $new['values'][$newK];
                $newK ++;
            } else {
            
                $newValues[] = 0;
            }
            
            $attentionValues[] = end($allValues) - end($newValues);
        }

        $all['values']  =   $allValues;
        $new['values']  =   $newValues;

        $dataGroupNames[]   =   '客户总数';
        $dataGroupNames[]   =   '未跟进';
        $dataGroupNames[]   =   '已跟进';

        $values[]   =   array(
            'name' =>   '客户总数',
            'type' =>   $this->chartType,
            'data' =>   $all['values']
        );
        $values[]   =   array(
            'name' =>   '未跟进',
            'type' =>   $this->chartType,
            'data' =>   $new['values']
        );

        $values[]   =   array(
            'name' =>   '已跟进',
            'type' =>   $this->chartType,
            'data' =>   $attentionValues
        );
        $data       =   array(
            'title'             =>  $title,
            'names'             =>  $names,
            'values'            =>  $values,
            'dataGroupNames'    =>  $dataGroupNames
        );
        $this->yunset($data);

        $this->yunset(array('totalAll'  => $totalAll, 'totalNew' => $totalNew, 'totalAttention' => ($totalAll - $totalNew)));

        $this->yuntpl(array('admin/crm_my_performance_depart'));
    }

    function usortS($prev, $next)
    {
        $p  =   strtotime($prev);
        $n  =   strtotime($next);
        if ($p == $n)
            return 0;

        return ($p > $n) ? 1 : - 1;
    }

    function concern_action(){
        if ($_GET['time'] || $_GET['stime'] || $_GET['etime']) {
            if ($_GET['time']) {
                if ($_GET['time'] == - 1) {
                    
                    $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('y'));
                    $timeEnd    =   time();
                    $title      =   "客户统计 - 今天";
                } elseif ($_GET['time'] == 1) {
                    
                    $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('y')) - 86400;
                    $timeEnd    =   mktime(23, 59, 59, date('m'), date('d'), date('Y')) - 86400;
                    $title      =   "客户统计 - 昨天";
                } else {
                    
                    $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('Y')) - $_GET['time'] * 86400;
                    $timeEnd    =   mktime(23, 59, 59, date('m'), date('d'), date('Y'));
                    $title      =   "客户统计 - {$_GET['time']}天内";
                }
            }
            if ($_GET['stime']) {
                
                $stime          =   explode('-', $_GET['stime']);
                $etime          =   explode('-', $_GET['etime']);

                $timeBegin      =   mktime(0, 0, 0, $stime[1], $stime[2], $stime[0]);
                $timeEnd        =   mktime(23, 59, 59, $etime[1], $etime[2], $etime[0]);
                $title          =   "跟进记录统计 - {$_GET['stime']}~{$_GET['etime']}";
            }
        } else {
            
            $title = "跟进记录统计 - 全部数据";
        }
        
        $names  =   $values =   $where  =   array();
        
        $uids	=	$this->getAuser();
		if($_GET['crmmanager']){
			$where['auid']	=	$_GET['crmmanager'];
		}else{
			$where['auid']  =   array('in',pylode(',',$uids));
        }
        if ($timeBegin != '') {
            $where['atime'][]   =   array('>=', $timeBegin);
            $where['atime'][]   =   array('<=', $timeEnd);
        }
        $where['groupby']   =   'type';
        $where['orderby']   =   'type';
        
        $crmM   =   $this->MODEL('crm');
        $row    =   $crmM->getConcernList($where, array('field' => 'count(id) as `num`, `type`'));

        $total  =   0;
        
        foreach ($row as $r) {
            $names[]        =   $r['type'];
            $rr['value']    =   $r['num'];
            $rr['name']     =   $r['type'];
            $values[]       =   $rr;
            $total += $r['num'];
        }
        $data   =   array(
            'title'     =>  $title,
            'names'     =>  $names,
            'values'    =>  $values
        );
        $this->yunset($data);
        $this->yunset('total', $total);
        
        include (PLUS_PATH . "crm.cache.php");
        $this->yunset('crmclass_name', $crmclass_name);
        $this->yuntpl(array('admin/crm_my_concern_depart'));
    }

    private function getAmountTotal($timeBegin = '', $timeEnd = '')
    {
        
        $where  =   array();
        $uids	=	$this->getAuser();
		if($_GET['crmmanager']){
			$where['crm_uid']	=	$_GET['crmmanager'];
		}else{
		    $where['PHPYUNBTWSTART_A']  =   '';
		    $where['crm_uid'][]	        =	array('<>',0,'AND');
		    $where['crm_uid'][]	        =	array('in',pylode(',',$uids),'AND');
		    $where['PHPYUNBTWEND_A']    =   '';
		}
        $where['order_state']       =   '2';
        if ($timeBegin != '') {
            
            $where['order_time'][]  =   array('>=', $timeBegin);
            $where['order_time'][]  =   array('<=', $timeEnd);
        }

        $companyorderM  =   $this->MODEL('companyorder');
        $row            =   $companyorderM->getList($where, array('field' => 'sum(order_price) as `num`'));

        $all            =   isset($row[0]['num']) && $row[0]['num'] > 0 ? $row[0]['num'] : 0;

        return array($all);
    }

    public function amount_action()
    {
        list ($all) =   $this->getAmountTotal(strtotime(date('Y-m-01 00:00:00', time())), time());
        $data[]     =   array('time' => '本月', 'all' => $all);

        $timeEnd    =   strtotime(date('Y-m-d 00:00:00', time()));
        $week       = date('w');
        if ($week == 0)
            $week   =   7;
        $week --;
        $monday     =   strtotime("-{$week} day", $timeEnd);
        list ($all) =   $this->getAmountTotal($monday, $timeEnd);
        $data[] = array('time' => '本周', 'all' => $all);

        $all        =   $this->getAmountTotal($monday, $timeEnd);
        list ($all) =   $this->getAmountTotal(strtotime('-1 day', $timeEnd), $timeEnd);
        $data[]     =   array('time' => '昨日', 'all' => $all);

        list ($all) =   $this->getAmountTotal();
        $data[]     =   array('time' => '累计','all' => $all);
        $this->yunset('data', $data);

        if ($_GET['time'] || $_GET['stime'] || $_GET['etime']) {
            if ($_GET['time']) {
                if ($_GET['time'] == - 1) {
                    
                    $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('y'));
                    $timeEnd    =   time();
                    $title      =   "客户统计 - 今天";
                } elseif ($_GET['time'] == 1) {
                    
                    $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('y')) - 86400;
                    $timeEnd    =   mktime(23, 59, 59, date('m'), date('d'), date('Y')) - 86400;
                    $title      =   "客户统计 - 昨天";
                } else {
                    
                    $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('Y'))  - $_GET['time'] * 86400;
                    $timeEnd    =   mktime(23, 59, 59, date('m'), date('d'), date('Y'));
                    $title      =   "客户统计 - {$_GET['time']}天内";
                }
            }
            if ($_GET['stime']) {
                $stime          =   explode('-', $_GET['stime']);
                $etime          =   explode('-', $_GET['etime']);

                $timeBegin      =   mktime(0, 0, 0, $stime[1], $stime[2], $stime[0]);
                $timeEnd        =   mktime(23, 59, 59, $etime[1], $etime[2], $etime[0]);
                $title          =   "成交金额统计 - {$_GET['stime']}~{$_GET['etime']}";
            }
        } else {
            
            $title = "成交金额统计 - 全部数据";
        }

        $names  =   $values =   $dataGroupNames =   array();
        
        $where  =   array();
        
         $uids	=	$this->getAuser();
		
        if($_GET['crmmanager']){
			$where['crm_uid']	=	$_GET['crmmanager'];
		}else{
		    $where['PHPYUNBTWSTART_A']  =   '';
		    $where['crm_uid'][]	        =	array('<>',0,'AND');
		    $where['crm_uid'][]	        =	array('in',pylode(',',$uids),'AND');
		    $where['PHPYUNBTWEND_A']    =   '';
		}
		$where['order_state']       =   '2';
        if ($timeBegin != '') {
            $where['order_time'][]  =   array('>=', $timeBegin);
            $where['order_time'][]  =   array('<=', $timeEnd);
        }
        $where['groupby']   =   'date';
        $where['orderby']   =   'date';
        $companyorderM      =   $this->MODEL('companyorder');
        $row                =   $companyorderM->getList($where, array('field' => "sum(order_price) as `num`, from_unixtime(order_time,'%Y-%m-%d') as `date`"));

        $totalAll   =   0;
        
        if (count($row) < 1) {
            $in =   array(
                'names'     =>  array(),
                'values'    =>  array()
            );
        } else {
            $inNames    =   array();
            $inValues   =   array();
            foreach ($row as $r) {
                $inNames[]  =   $r['date'];
                $inValues[] =   $r['num'];

                $totalAll += $r['num'];
            }
            $in =   array(
                'names'     =>  $inNames,
                'values'    =>  $inValues
            );
        }
        $names  =   array_merge($in['names']);
        $names  =   array_unique($names);
        
        usort($names, 'usortS');

        $inValues   =   array();
        $inK        =   0;
        
        foreach ($names as $n) {
            if (in_array($n, $in['names'])) {
                
                $inValues[] =   $in['values'][$inK];
                $inK ++;
            } else {
                
                $inValues[] =   0;
            }
        }

        $in['values']       =   $inValues;

        $dataGroupNames[]   =   '成交金额';

        $values[]   =   array(
            'name' =>   '成交金额',
            'type' =>   $this->chartType,
            'data' =>   $in['values']
        );

        $data   =   array(
            'title'     =>  $title,
            'names'     =>  $names,
            'values'    =>  $values,
            'dataGroupNames'    =>  $dataGroupNames
        );
        $this -> yunset($data);
        $this -> yunset(array('totalAll' => $totalAll));

        $this -> yuntpl(array('admin/crm_my_amount_depart'));
    }
}
?>