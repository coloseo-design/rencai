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
class crm_audit_controller extends adminCommon
{

    function index_action()
    {

        $companyorderM  =   $this->MODEL('companyorder');

        $where = $urlarr = array();

        $where['order_state']   =   2;
        $where['order_price']   =   array('>', 0);

        if (isset($_GET['iscrm']) && $_GET['iscrm'] == 1){

            $where['crm_uid']   =   array('>', 0);
            $urlarr['iscrm']    =   $_GET['iscrm'];
        }

        if ($_GET['time']) {
            if ($_GET['time'] == -1) {

                $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('y'));
                $timeEnd    =   time();
            } elseif ($_GET['time'] == 1) {

                $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('y')) - 86400;
                $timeEnd    =   mktime(23, 59, 59, date('m'), date('d'), date('Y')) - 86400;
            } else {

                $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('Y')) - $_GET['time'] * 86400;
                $timeEnd    =   mktime(23, 59, 59, date('m'), date('d'), date('Y'));
            }
            $where['PHPYUNBTWSTART_A']  =  '';
            $where['order_time'][]      =   array('>=', $timeBegin, '');
            $where['order_time'][]      =   array('<=', $timeEnd, '');
            $where['PHPYUNBTWEND_A']    =  '';
            $urlarr['time']             =   urlencode($_GET['time']);
        }
        if ($_GET['stime']) {

            $stime  =   explode('-', $_GET['stime']);
            $etime  =   explode('-', $_GET['etime']);

            $timeBegin  =   mktime(0, 0, 0, $stime[1], $stime[2], $stime[0]);
            $timeEnd    =   mktime(23, 59, 59, $etime[1], $etime[2], $etime[0]);
            $where['PHPYUNBTWSTART_A']  =  '';
            $where['order_time'][]      =   array('>=', $timeBegin, '');
            $where['order_time'][]      =   array('<=', $timeEnd, '');
            $where['PHPYUNBTWEND_A']    =  '';

            $urlarr['stime']    =   urlencode($_GET['stime']);
            $urlarr['etime']    =   urlencode($_GET['etime']);
        }

        $where['groupby']   =   'date';
        $urlarr             =   $_GET;
        $urlarr['page']     =   '{{page}}';
        $pageurl            =   Url($_GET['m'], $urlarr, 'admin');

        $limit  =   10;
        $page   =   $_GET['page'] < 1 ? 1 : $_GET['page'];

        $rows   =   $companyorderM->getList($where, array('field' => "sum(order_price) as `num`,FROM_UNIXTIME(order_time,'%Y-%m-%d') as `date`"));
        $num    =   count($rows);
        $pages['total'] =   $num;

        if ($num > $limit) {

            $pagenav        =   Page($page, $num, $limit, $pageurl, $notpl = false, $this->tpl, 'pagenav');
            $pages['pages'] =   ceil($num / $limit);
            $this->yunset('pagenav', $pagenav);
        }

        if ($pages['total'] > 0) {
            if ($_GET['order']) {

                $where['orderby']   =   $_GET['t'] . ',' . $_GET['order'];
                $urlarr['order']    =   $_GET['order'];
                $urlarr['t']        =   $_GET['t'];
            } else {

                $where['orderby']   =   'date';
            }

            $where['limit'] =   array(($page - 1) * $limit, $page * $limit);
            $orderRows      =   $companyorderM->getList($where, array('field' => "sum(order_price) as `num`,FROM_UNIXTIME(order_time,'%Y-%m-%d') as `date`, FROM_UNIXTIME(order_time,'%d') as `day`, FROM_UNIXTIME(order_time,'%m') as `month`, FROM_UNIXTIME(order_time,'%Y') as `year`"));
        }

        //支出
        $owhere['order_state']  =   1;

        if ($_GET['time']) {
            if ($_GET['time'] == -1) {

                $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('y'));
                $timeEnd    =   time();
            } elseif ($_GET['time'] == 1) {

                $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('y')) - 86400;
                $timeEnd    =   mktime(23, 59, 59, date('m'), date('d'), date('Y')) - 86400;
            } else {

                $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('Y')) - $_GET['time'] * 86400;
                $timeEnd    =   mktime(23, 59, 59, date('m'), date('d'), date('Y'));
            }
            $owhere['PHPYUNBTWSTART_A'] =  '';
            $owhere['time'][]           =   array('>=', $timeBegin, '');
            $owhere['time'][]           =   array('<=', $timeEnd, '');
            $owhere['PHPYUNBTWEND_A']   =  '';
        }

        if ($_GET['stime']) {

            $stime  =   explode('-', $_GET['stime']);
            $etime  =   explode('-', $_GET['etime']);

            $timeBegin  =   mktime(0, 0, 0, $stime[1], $stime[2], $stime[0]);
            $timeEnd    =   mktime(23, 59, 59, $etime[1], $etime[2], $etime[0]);
            $owhere['PHPYUNBTWSTART_A'] =  '';
            $owhere['time'][]           =   array('>=', $timeBegin, '');
            $owhere['time'][]           =   array('<=', $timeEnd, '');
            $owhere['PHPYUNBTWEND_A']   =  '';
        }

        $owhere['groupby']      =   'date';

        $fieldo =   "sum(order_price) as `num`,from_unixtime(`time`,'%Y-%m-%d') as `date`";
        $packM  =   $this->MODEL('pack');
        $out    =   $packM->getList($owhere, array('field' => $fieldo));
        $outArr =   array();
        foreach ($out as $r) {
            $outArr [$r['date']]    =   $r['num'];
        }

        $swhere['order_state']      =   2;
        $swhere['crm_uid']          =   array('>', 0);
        if ($_GET['time']) {
            if ($_GET['time'] == -1) {

                $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('y'));
                $timeEnd    =   time();
            } elseif ($_GET['time'] == 1) {

                $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('y')) - 86400;
                $timeEnd    =   mktime(23, 59, 59, date('m'), date('d'), date('Y')) - 86400;
            } else {

                $timeBegin  =   mktime(0, 0, 0, date('m'), date('d'), date('Y')) - $_GET['time'] * 86400;
                $timeEnd    =   mktime(23, 59, 59, date('m'), date('d'), date('Y'));
            }
            $swhere['PHPYUNBTWSTART_A']     =  '';
            $swhere['order_time'][]         =   array('>=', $timeBegin, '');
            $swhere['order_time'][]         =   array('<=', $timeEnd, '');
            $swhere['PHPYUNBTWEND_A']       =  '';
        }
        if ($_GET['stime']) {

            $stime  =   explode('-', $_GET['stime']);
            $etime  =   explode('-', $_GET['etime']);

            $timeBegin  =   mktime(0, 0, 0, $stime[1], $stime[2], $stime[0]);
            $timeEnd    =   mktime(23, 59, 59, $etime[1], $etime[2], $etime[0]);
            $swhere['PHPYUNBTWSTART_A']     =  '';
            $swhere['order_time'][]         =   array('>=', $timeBegin, '');
            $swhere['order_time'][]         =   array('<=', $timeEnd, '');
            $swhere['PHPYUNBTWEND_A']       =  '';
        }
        $swhere['groupby']  =   'date';
        $fields             =   "sum(order_price) as `num`, from_unixtime(`order_time`,'%Y-%m-%d') as `date`";
        $salesmanOrder      =   $companyorderM->getList($swhere, array('field' => $fields));
        $salesmanOrderArr   =   array();
        foreach ($salesmanOrder as $r) {
            $salesmanOrderArr[$r['date']]   =   $r['num'];
        }

        foreach ($orderRows as &$r) {
            if (!isset($outArr[$r['date']])) {

                $r['out']   =   0.00;
                $r['total'] =   $r['num'];
            } else {

                $r['out']   =   $outArr[$r['date']];
                $r['total'] =   $r['num'] - $r['out'];
            }
            $r['salesmanNum']   =   isset($salesmanOrderArr[$r['date']]) ? $salesmanOrderArr[$r['date']] : 0;
        }

        $orderRows  =   $this->getDetail($orderRows);

        $this->yunset('order', $orderRows);
        $this->yuntpl(array('admin/crm_audit'));
    }

    private function getDetail($rows){

        $dateArr    =   array();
        foreach ($rows as $k => $v) {
            $dateArr[]  =   $v['date'];
        }
        $timeBegin  =   strtotime($dateArr[9]);
        $timeEnd    =   strtotime($dateArr[0]);
        $timeEnd    =   strtotime('+1 day', $timeEnd);

        $orderM     =   $this->MODEL('companyorder');

        if (isset($_GET['iscrm']) && $_GET['iscrm'] == 1){

            $where['crm_uid']       =   array('>', 0);
        }

        $where['order_state']       =   2;
        $where['PHPYUNBTWSTART_A']  =   '';
        $where['order_time'][]      =   array('>=', $timeBegin, 'AND');
        $where['order_time'][]      =   array('<=', $timeEnd, 'AND');
        $where['PHPYUNBTWEND_A']    =   '';
        $where['orderby']           =   'order_time';


        $orders     =   $orderM->getList($where, array('field' => '`id`,`uid`,`order_id`, order_price, order_type, order_time,`crm_uid`', 'utype' => 'crmaduit'));

        foreach ($rows as $k => $v) {
            foreach ($orders as $ok => $ov) {
                if ($v['date'] == $ov['date']){
                    $rows[$k]['orders'][]   =   $ov;
                }
            }
        }
        return $rows;
    }

    public function detail_action()
    {

        $orderM =   $this->MODEL('companyorder');
        $where  =   $urlarr =   array();

        $where['type']          =   1;
        $where['order_state']   =   2;
        $where['crm_uid']       =   array('>', 0);

        if ($_GET['date']) {

            $timeBegin  =   strtotime($_GET['date']);
            $timeEnd    =   strtotime('+1 day', $timeBegin);

            $where['PHPYUNBTWSTART_A']  =   '';
            $where['order_time'][]      =   array('>=', $timeBegin, 'AND');
            $where['order_time'][]      =   array('<=', $timeEnd, 'AND');
            $where['PHPYUNBTWEND_A']    =   '';
            $urlarr['date']             =   $_GET['date'];
        }

        $urlarr['c']        =   $_GET['c'];
        $urlarr             =   $_GET;
        $urlarr['page']     =   '{{page}}';
        $pageurl            =   Url($_GET['m'], $urlarr, 'admin');

        $pageM              =   $this->MODEL('page');
        $pages              =   $pageM->pageList('company_order', $where, $pageurl, $_GET['page']);

        if ($pages['total'] > 0) {
            if ($_GET['order']) {

                $where['orderby']   =   $_GET['t'] . ',' . $_GET['order'];
                $urlarr['order']    =   $_GET['order'];
                $urlarr['t']        =   $_GET['t'];
            } else {

                $where['orderby']   =   'order_time';
            }
            $where['limit']         =   $pages['limit'];

            $list   =   $orderM->getList($where, array('field' => '`id`,`uid`,`order_id`, order_price, order_time, `rating`,`crm_uid`', 'utype' => 'crmaduit'));
            $this->yunset(array('order' => $list));
        }
        $this->yuntpl(array('admin/crm_audit_detail'));
    }
}

