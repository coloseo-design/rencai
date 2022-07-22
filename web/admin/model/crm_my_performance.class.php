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
class crm_my_performance_controller extends adminCommon
{

    private $chartType = 'line';

    private function getTotal($timeBegin = '', $timeEnd = '')
    {
        $comM               =   $this->MODEL('company');
        
        $where              =   array();
        $where['crm_uid']   =   $_SESSION["auid"];
        if ($timeBegin != '') {
            $where['crm_time'][]    =   array('>=', $timeBegin);
            $where['crm_time'][]    =   array('<=', $timeEnd);
        }
        
        $comlist            =   $comM->getList($where, array('field' => 'count(uid) as `num`'));
        $row                =   $comlist['list'];
        $all                =   isset($row[0]['num']) && $row[0]['num'] > 0 ? $row[0]['num'] : 0;   //  所有客户

        $cwhere             =   array();
        $cwhere['crm_uid']  =   $_SESSION["auid"];
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
                    
                    $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('y'))  - 86400;
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
        
        $where['crm_uid']       =   $_SESSION["auid"];
        
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
        $cwhere['crm_uid']      =   $_SESSION["auid"];
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

        $this->yuntpl(array('admin/crm_my_performance'));
    }

    function usortS($prev, $next)
    {
        $p  =   strtotime($prev);
        $n  =   strtotime($next);
        if ($p == $n)
            return 0;

        return ($p > $n) ? 1 : - 1;
    }

    function concern_action()
    {
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
        
        $where['auid']  =   $_SESSION["auid"];
        
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
        $this->yuntpl(array('admin/crm_my_concern'));
    }

    private function getAmountTotal($timeBegin = '', $timeEnd = '')
    {
        
        $where  =   array();
        
        $where['crm_uid']       =   $_SESSION["auid"];
        $where['order_state']   =   '2';
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
                $title          =   "成交金额统计 - {$_GET['stime']}~{$_GET['etime']}";
            }
        } else {
            
            $title = "成交金额统计 - 全部数据";
        }

        $names  =   $values =   $dataGroupNames =   array();
        
        $where  =   array();
        
        $where['crm_uid']   =   $_SESSION["auid"];
        
        if ($timeBegin != '') {
            $where['order_time'][]  =   array('>=', $timeBegin);
            $where['order_time'][]  =   array('<=', $timeEnd);
        }
        
        $where['order_state']   =   '2';
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

        $this -> yuntpl(array('admin/crm_my_amount'));
    }
}
?>