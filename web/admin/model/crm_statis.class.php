<?php

/**
 * $Author ：PHPYUN开发团队
 *
 * 官网: http://www.phpyun.com
 *
 * 版权所有 2009-2021 宿迁鑫潮信息技术有限公司，并保留所有权利。
 *
 * 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
 */
class crm_statis_controller extends adminCommon
{

	/**
	 * @desc 业务统计页面；
	 */
    function index_action()
    {

        $adminM     =   $this->MODEL('admin');
        $adminGroup =   $adminM->getAdminGroupList(array('group_power' => array('like', '220')), array('field' => '`id`'));

        if ($adminGroup) {
            foreach ($adminGroup as $v) {
                $mIds[]     =   $v['id'];
            }
            $where['m_id']  =   array('in', pylode(',', $mIds));
        }

        $where['did']       =   0;
        $where['status']    =   1;

        if ($_GET['uid']) {

            $where['uid']   =   $_GET['uid'];
            $urlarr['uid']  =   $_GET['uid'];
        }

        if ($_GET['order']) {

            $where['orderby']   =   $_GET['t'] . ',' . $_GET['order'];
            $urlarr['order']    =   $_GET['order'];
            $urlarr['t']        =   $_GET['t'];
        } else {

            $where['orderby']   =   array('uid,desc');
        }

        if ($_GET['time']) {

            unset($_GET['stime']);
            unset($_GET['etime']);

            if ($_GET['time'] == -1) {

                $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                $timeEnd    =   time();
            } elseif ($_GET['time'] == 1) {

                $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('Y')) - 86400;
                $timeEnd    =   mktime(23, 59, 59, date('m'), date('d'), date('Y')) - 86400;
            } else {

                $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('Y')) - $_GET['time'] * 86400;
                $timeEnd    =   mktime(23, 59, 59, date('m'), date('d'), date('Y'));
            }
            $urlarr['time'] =   $_GET['time'];
        }else if ($_GET['stime']) {

            unset($_GET['time']);

            $stime      =   explode('-', $_GET['stime']);
            $etime      =   explode('-', $_GET['etime']);

            $timeBegin  =   mktime(0, 0, 0, $stime[1], $stime[2], $stime[0]);
            $timeEnd    =   mktime(23, 59, 59, $etime[1], $etime[2], $etime[0]);

            $urlarr['stime']    =   urlencode($_GET['stime']);
            $urlarr['etime']    =   urlencode($_GET['etime']);
        }

        $comdata        =   array(
            'utype'     =>  'crm',
            'crmstatis' =>  1,
            'timeBegin' =>  $timeBegin,
            'timeEnd'   =>  $timeEnd,
            'field'     =>  '`uid`,`name`,`status`,`username`,`did`'
        );
        $rows           =   $adminM->getList($where, $comdata);
        $this->yunset('userrows', $rows);

        $adminM         =   $this->MODEL('admin');
        $auser          =   $adminM->getList(array(), array('field' => '`uid`,`name`'));
        $this->yunset('auser', $auser);

        $this->yuntpl(array('admin/crm_statis'));
    }

	//图表类型 bar 柱形图，line折线图，pie饼形图
	private $chartType = 'line';

    //查询n天内客户总数
    private function getTotal($timeBegin = '', $timeEnd = '', $uid)
    {

        $companyM           =   $this->MODEL('company');

        //业务员客户总数
        $where              =   array();
        $where['crm_uid']   =   $uid;

        if ($timeBegin != '') {

            $where['crm_time'][]    =   array('>=', $timeBegin);
            $where['crm_time'][]    =   array('<=', $timeEnd);
        }

        $comList    =   $companyM->getList($where, array('field' => "count(uid) as `num`"));
        $row        =   $comList['list'];
        $all        =   isset($row[0]['num']) && $row[0]['num'] > 0 ? $row[0]['num'] : 0;

        //业务员待怀客户
        $cnWhere['crm_uid'] =   $uid;
        $cnWhere['isfollow']=   0;
        if (isset($timeBegin) && $timeBegin != '') {
            $cnWhere['f_time']  =   array('<', $timeBegin);
        }

        $cnComList  =   $companyM->getList($cnWhere, array('field' => "count(uid) as `num`"));
        $row        =   $cnComList['list'];
        $new        =   isset($row[0]['num']) && $row[0]['num'] > 0 ? $row[0]['num'] : 0;

        //业务员已跟进客户
        $cndWhere['crm_uid']    =   $uid;
        $cndWhere['isfollow']   =   1;
        if (isset($timeBegin) && $timeBegin != '') {
            $cndWhere['f_time'][]   =   array('>=', $timeBegin, '');
            $cndWhere['f_time'][]   =   array('<=', $timeEnd, '');
        }

        $cndComList =   $companyM->getList($cndWhere, array('field' => "count(uid) as `num`"));
        $row        =   $cndComList['list'];
        $attention  =   isset($row[0]['num']) && $row[0]['num'] > 0 ? $row[0]['num'] : 0;

        return array($all, $new, $attention);
    }

    function performance_action()
    {

        //查询总的信息，展示到页面第一屏
        $uid        =   $_GET['uid'] ? $_GET['uid'] : '';
        $adminM     =   $this->MODEL('admin');
        $adminuser  =   $adminM->getAdminUser(array('uid' => $uid), array('field' => '`uid`,`name`'));

        list($all, $new, $attention) = $this->getTotal(strtotime(date('Y-m-01 00:00:00', time())), time(), $uid);
        $data []    =   array('time' => '本月', 'all' => $all, 'new' => $new, 'attention' => $attention);

        $timeEnd    =   strtotime(date('Y-m-d 00:00:00', time()));
        $week       =   date('w');
        if ($week == 0) $week = 7;
        $week--;
        $monday     =   strtotime("-{$week} day", $timeEnd);
        list($all, $new, $attention) = $this->getTotal($monday, $timeEnd, $uid);
        $data []    =   array('time' => '本周', 'all' => $all, 'new' => $new, 'attention' => $attention);

        list($all, $new, $attention) = $this->getTotal(strtotime('-1 day', $timeEnd), $timeEnd, $uid);
        $data []    =   array('time' => '昨日', 'all' => $all, 'new' => $new, 'attention' => $attention);

        list($all, $new, $attention) = $this->getTotal('', '', $uid);
        $data []    =   array('time' => '累计', 'all' => $all, 'new' => $new, 'attention' => $attention);

        $this->yunset('data', $data);

        //查询报表数据
        if ($_GET['time'] || $_GET['stime'] || $_GET['etime']) {
            if ($_GET['time']) {
                if ($_GET['time'] == -1) {
                    $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                    $timeEnd    =   time();
                    $title      =   "客户统计 - 今天";
                } elseif ($_GET['time'] == 1) {
                    $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('Y')) - 86400;
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

        //客户总计 查询：all所有客户，new待跟进客户
        $names          =   array();//横坐标名称（时间日期）
        $values         =   array();//纵坐标的值
        $dataGroupNames =   array();//柱行代表数据的名称


        $companyM           =   $this->MODEL('company');
        //所有客户
        $where['crm_uid']   =   $uid;
        if (isset($timeBegin) && $timeBegin != '') {
            $where['crm_time'][]    =   array('>=', $timeBegin);
            $where['crm_time'][]    =   array('<=', $timeEnd);
        }
        $where['groupby']   =   'date';
        $where['orderby']   =   'date';

        $comList            =   $companyM->getList($where, array('field' => "count(uid) as `num`, from_unixtime(crm_time,'%Y-%m-%d') as `date`"));
        $row                =   $comList['list'];

        $totalAll           =   0;//客户总计
        if (count($row) < 1) {
            $all            =   array('names' => array(), 'values' => array());
        } else {
            $allNames       =   array();
            $allValues      =   array();
            foreach ($row as $r) {
                $allNames []    =   $r['date'];
                $allValues []   =   $r['num'];
                $totalAll       +=  $r['num'];
            }
            $all                =   array('names' => $allNames, 'values' => $allValues);
        }

        //待跟进客户
        $cnWhere['crm_uid']     =   $uid;
        $cnWhere['isfollow']    =   0;
        if (isset($timeBegin) && $timeBegin != '') {
            $cnWhere['f_time']  =   array('<', $timeBegin);
        }
        $cnWhere['groupby']     =   'date';
        $cnWhere['orderby']     =   'date';
        $cmComList              =   $companyM->getList($cnWhere, array('field' => "count(uid) as `num`"));
        $row                    =   $cmComList['list'];
        $totalNew               =   0;
        if (count($row) < 1) {
            $new                =   array('names' => array(), 'values' => array());
        } else {
            $newNames           =   array();
            $newValues          =   array();
            foreach ($row as $r) {
                $newNames []    =   $r['date'];
                $newValues []   =   $r['num'];
                $totalNew       +=  $r['num'];
            }
            $new                =   array('names' => $newNames, 'values' => $newValues);
        }

        // 已经跟进客户
        $cndWhere['crm_uid']    =   $uid;
        $cndWhere['isfollow']   =   1;
        if (isset($timeBegin) && $timeBegin != '') {
            $cndWhere['f_time'][]   =   array('>=', $timeBegin, '');
            $cndWhere['f_time'][]   =   array('<=', $timeEnd, '');
        }
        $cndWhere['groupby']    =   'date';
        $cndWhere['orderby']    =   'date';
        $cndComList             =   $companyM->getList($cndWhere, array('field' => "count(uid) as `num`, from_unixtime(f_time,'%Y-%m-%d') as `date`"));
        $row                    =   $cndComList['list'];
        $totalAttention         =   0;
        if (count($row) < 1) {
            $attention          =   array('names' => array(), 'values' => array());
        } else {
            $attNames           =   array();
            $attValues          =   array();
            foreach ($row as $r) {
                $attNames[]     =   $r['date'];
                $attValues[]    =   $r['num'];
                $totalAttention +=  $r['num'];
            }
            $attention                =   array('names' => $attNames, 'values' => $attValues);
        }

        $names = array_merge($all['names'], $attention['names']);
        $names = array_unique($names);
        usort($names, function($prev, $next){
            $p = strtotime($prev);
            $n = strtotime($next);
            if ($p == $n) return 0;

            return ($p > $n) ? 1 : -1;
        });

        $dataGroupNames []  =   '客户总数';
        $dataGroupNames []  =   '未跟进';
        $dataGroupNames []  =   '已跟进';

        $values[]           =   array(
            'name'  =>  '客户总数',
            'type'  =>  $this->chartType,
            'data'  =>  $all['values']
        );

        $values[]           =   array(
            'name'  =>  '未跟进',
            'type'  =>  $this->chartType,
            'data'  =>  $new['values']
        );

        $values[]           =   array(
            'name'  =>  '已跟进',
            'type'  =>  $this->chartType,
            'data'  =>  $attention['values']
        );

        $data   =   array('title' => $title, 'names' => $names, 'values' => $values, 'dataGroupNames' => $dataGroupNames);
        $this->yunset($data);

        $this->yunset(array('totalAll' => $totalAll, 'totalNew' => $totalNew, 'totalAttention' => $totalAttention, 'ausername' => $adminuser['name']));

        $this->yuntpl(array('admin/crm_statis_performance'));

    }

	//消费渠道
	private $typeMapping = array(
		1 => '等待用户反馈',
		2 => '已付费（签单）',
		3 => '拒绝付费',
		4 => '可能付费，已增加回访提醒'
	);

	//业务员跟进记录
    function concern_action()
    {

        $uid    =   $_GET['uid'] ? $_GET['uid'] : '';
        //查询报表数据
        if ($_GET['time'] || $_GET['stime'] || $_GET['etime']) {
            if ($_GET['time']) {
                if ($_GET['time'] == -1) {

                    $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                    $timeEnd    =   time();
                    $title      =   "跟进记录统计 - 今天";
                } elseif ($_GET['time'] == 1) {
                    $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('Y')) - 86400;
                    $timeEnd    =   mktime(23, 59, 59, date('m'), date('d'), date('Y')) - 86400;
                    $title      =   "跟进记录统计 - 昨天";
                } else {
                    $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('Y')) - $_GET['time'] * 86400;
                    $timeEnd    =   mktime(23, 59, 59, date('m'), date('d'), date('Y'));
                    $title      =   "跟进记录统计 - {$_GET['time']}天内";
                }
            }
            if ($_GET['stime']) {
                $stime  =   explode('-', $_GET['stime']);
                $etime  =   explode('-', $_GET['etime']);

                $timeBegin  =   mktime(0, 0, 0, $stime[1], $stime[2], $stime[0]);
                $timeEnd    =   mktime(23, 59, 59, $etime[1], $etime[2], $etime[0]);
                $title      =   "跟进记录统计 - {$_GET['stime']}~{$_GET['etime']}";
            }
        } else {
            $title  =   "跟进记录统计 - 全部数据";
        }
        $names  =   array();//扇形每块的名称（跟进状态）
        $values =   array();//扇形每块的值

        //待跟进客户
        $where['auid'] = $uid;
        if (isset($timeBegin) && isset($timeEnd) && $timeBegin != '') {
            $where['atime'][]   =   array('>=', $timeBegin);
            $where['atime'][]   =   array('<=', $timeEnd);
        }
        $where['groupby']   =   'type';
        $where['orderby']   =   'type';
        $crmM   =   $this->MODEL('crm');
        $row    =   $crmM->getConcernList($where, array('field' => 'count(id) as `num`, `status`,`type`'));

        $total  =   0;

        foreach ($row as $r) {

            $names []   =   $r['type'];
            $rr['value']=   $r['num'];
            $rr['name'] =   $r['type'];
            $values []  =   $rr;
            $total      +=  $r['num'];
        }

        $data   =   array('title' => $title, 'names' => $names, 'values' => $values);
        $this->yunset($data);
        $this->yunset('total', $total);
        include(PLUS_PATH . "crm.cache.php");
        $this->yunset("crmclass_name", $crmclass_name);

        $adminM     =   $this->MODEL('admin');
        $adminuser  =   $adminM->getAdminUser(array('uid' => $uid), array('field' => '`uid`,`name`'));
        $this->yunset(array('ausername' => $adminuser['name'], 'cuid' => $uid));
        $this->yuntpl(array('admin/crm_statis_concern'));
    }

	//查询n天内业务员成交金额
	private function getAmountTotal($timeBegin = '', $timeEnd = '', $uid){
 
		$where['crm_uid']	=	$uid;
		if($timeBegin !=''){
			$where['order_time'][]	=	array('>=',$timeBegin);
			$where['order_time'][]	=	array('<=',$timeEnd);
		}
	
		$companyorderM	=	$this->MODEL('companyorder');
		$row 			= 	$companyorderM->getList($where,array('field'=>'sum(order_price) as `num`'));
		
		$all = isset($row[0]['num']) && $row[0]['num'] > 0 ? $row[0]['num'] : 0;

		return array($all);
	}

	//我的业绩页面：成交金额
	public function amount_action()
	{
	    $uid        =   $_GET['uid'] ? $_GET['uid'] : $_SESSION['uid'];
	    
		list($all)  =   $this->getAmountTotal( strtotime(date('Y-m-01 00:00:00', time())) , time(), $uid);
		
		$data []    =   array('time' => '本月', 'all' => $all);

		$timeEnd    =   strtotime(date('Y-m-d 00:00:00', time()));
		$week       =   date('w');

		if($week == 0) $week = 7;
		$week --;
		$monday     =   strtotime("-{$week} day", $timeEnd);
		list($all)  =   $this->getAmountTotal( $monday, $timeEnd, $uid);
		$data []    =   array('time' => '本周', 'all' => $all);

		$all        =   $this->getAmountTotal( $monday, $timeEnd, $uid);
		list($all)  =   $this->getAmountTotal( strtotime('-1 day', $timeEnd), $timeEnd, $uid );
		$data []    =   array('time' => '昨日', 'all' => $all);
		
		list($all)  =   $this->getAmountTotal('', '', $uid);
		$data []    =   array('time' => '累计', 'all' => $all);

		$this->yunset('data', $data);

		//查询报表数据
        if($_GET['time']||$_GET['stime'] || $_GET['etime']){
            if($_GET['time']){
                if($_GET['time']==-1){
                    $timeBegin   =   mktime(0,0,0,date('m'),date('d'),date('Y'));
                    $timeEnd     =   time();
                    $title 		= 	"成交金额 - 今天";
                }elseif($_GET['time']==1){
                    $timeBegin   =   mktime(0,0,0,date('m'),date('d'),date('Y'))  - 86400;
                    $timeEnd     =   mktime(23, 59, 59, date('m'), date('d'), date('Y'))  - 86400;
                    $title 		= 	"成交金额 - 昨天";
                }else{
                    $timeBegin   =   mktime(0, 0, 0, date('m'), date('d'), date('Y'))  - $_GET['time'] * 86400;
                    $timeEnd     =   mktime(23, 59, 59, date('m'), date('d') , date('Y'));
                    $title 		= 	"成交金额 - {$_GET['time']}天内";
                }
            }
            if($_GET['stime']){
                $stime		=	explode('-',$_GET['stime']);
                $etime		=	explode('-',$_GET['etime']);

                $timeBegin 	=   mktime(0, 0, 0, $stime[1], $stime[2] ,$stime[0]);
                $timeEnd   	=   mktime(23, 59, 59,$etime[1], $etime[2] ,$etime[0]);
                $title 		= 	"成交金额统计 - {$_GET['stime']}~{$_GET['etime']}";
            }
        }else{
            $title 		= 	"成交金额统计 - 全部数据";
        }

		//客户总计 查询：all成交金额
		$names  = array();//横坐标名称（时间日期）
		$values = array();//纵坐标的值
		$dataGroupNames = array();//柱行代表数据的名称
    		
		//所有客户
		$where['crm_uid']	=	$uid;

		if($timeBegin !=''){
			$where['order_time'][]	=	array('>=',$timeBegin);
			$where['order_time'][]	=	array('<=',$timeEnd);
		}
		$where['groupby']	=	'date';
		$where['orderby']	=	'date';
		$companyorderM		=	$this->MODEL('companyorder');
		$row 				= 	$companyorderM->getList($where,array('field'=>"sum(order_price) as `num`, from_unixtime(order_time,'%Y-%m-%d') as `date`"));
		
		$totalAll = 0;//客户总计
		if(count($row) < 1){
			$in = array('names' => array(), 'values' => array());
		}
		else{
			$inNames = array();
			$inValues = array();
			foreach($row as $r){
				$inNames [] = $r['date'];
				$inValues [] = $r['num'];

				$totalAll += $r['num'];
			}
			$in = array('names' => $inNames, 'values' => $inValues);
		}

		// 综合names、values
		$names = array_merge($in['names']);
		$names = array_unique($names);
		usort($names, function($prev, $next){
		  $p = strtotime($prev);
		  $n = strtotime($next);
		  if ($p == $n) return 0;

		  return ($p > $n) ? 1 : -1;
		});

		$inValues = array();
 		$inK = 0;
 		foreach($names as $n){
			if(in_array($n, $in['names'])){
				$inValues [] = $in['values'][$inK];
				$inK ++;
			}
			else{
				$inValues [] = 0;
			}
		}

		$in['values'] = $inValues;
 		
		$dataGroupNames [] = '成交金额';
 
		$values[] = array('name' => '成交金额',
				'type' => $this->chartType,
				'data' => $in['values']
			);

		$data = array('title' => $title,'names' => $names, 'values' => $values, 'dataGroupNames' => $dataGroupNames);
		$this->yunset($data);

		$this->yunset(array('totalAll'=> $totalAll));
		
		$adminM       =   $this->MODEL('admin');
		$adminuser    =   $adminM->getAdminUser(array('uid' => $uid), array('field' => '`uid`,`name`'));
		$this->yunset(array('ausername' => $adminuser['name'], 'cuid' => $uid));
 
		$this->yuntpl(array('admin/crm_statis_amount'));

	}

    public function getTjData_action()
    {

        $crmM   =   $this->MODEL('crm');

        if ($_POST['time']) {

            if ($_POST['time'] == - 1) {

                $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                $timeEnd    =   time();
            } elseif ($_POST['time'] == 1) {

                $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('Y')) - 86400;
                $timeEnd    =   mktime(23, 59, 59, date('m'), date('d'), date('Y')) - 86400;
            } else {

                $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('Y')) - $_POST['time'] * 86400;
                $timeEnd    =   mktime(23, 59, 59, date('m'), date('d'), date('Y'));
            }
        }
        if ($_POST['stime']) {

            $stime  =   explode('-', $_POST['stime']);
            $etime  =   explode('-', $_POST['etime']);

            $timeBegin  =   mktime(0, 0, 0, $stime[1], $stime[2], $stime[0]);
            $timeEnd    =   mktime(23, 59, 59, $etime[1], $etime[2], $etime[0]);
        }

        $return =   $crmM->getStatisData(array('timeBegin' => $timeBegin, 'timeEnd' => $timeEnd));

        echo json_encode($return);
        die();
    }
}

?>