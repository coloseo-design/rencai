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

class cron_controller extends adminCommon
{
    function public_act()
    {
        $arrweek[] = "周一";
        $arrweek[] = "周二";
        $arrweek[] = "周三";
        $arrweek[] = "周四";
        $arrweek[] = "周五";
        $arrweek[] = "周六";
        $arrweek[] = "周日";

        for ($i = 1; $i <= 31; $i++) {
            $montharr[] = $i . "日";
        }
        for ($i = 0; $i <= 23; $i++) {
            $hourarr[] = $i . "时";
        }
        $this->yunset('hourarr', $hourarr);
        $this->yunset('montharr', $montharr);
        $this->yunset('arrweek', $arrweek);
    }

    function index_action()
    {

        $rows   =   $this->MODEL('cron')->getList();

        $this->yunset('rows', $rows);

        $this->yuntpl(array('admin/admin_cron_list'));
    }

    function add_action()
    {

        $this->public_act();

        if ($_GET["id"]) {

            $row    =   $this->MODEL('cron')->getInfo(array('id' => $_GET["id"]));

            $this->yunset("row", $row);
        }
        $this->yuntpl(array('admin/admin_cron_add'));
    }

    function save_action()
    {

        if ($_POST) {

            $CronM  =   $this->MODEL('cron');

            $return =   $CronM->addInfo($_POST);

            if ($return['errcode'] == '9') {

                $this->croncache();

                $this->ACT_layer_msg($return['msg'], $return['errcode'], "index.php?m=cron");
            } else {

                $this->ACT_layer_msg($return['msg'], $return['errcode']);
            }
        }
    }

    function del_action()
    {

        $this->check_token();

        if ($_GET["id"]) {

            $CronM  =   $this->MODEL('cron');

            $return =   $CronM->delInfo($_GET["id"]);

            $this->croncache();

            $this->layer_msg($return['msg'], $return['errcode'], 0, "index.php?m=cron");
        }
    }

    //生成计划任务缓存文件
    function croncache()
    {

        include(LIB_PATH . "cache.class.php");
        $cacheclass = new cache(PLUS_PATH, $this->obj);
        $cacheclass->cron_cache("cron.cache.php");
    }

    function run_action()
    {
        if ($_GET['id']) {

            include PLUS_PATH . 'cron.cache.php';
            $CronM  =   $this->MODEL('cron');
            $CronM->excron($cron, $_GET['id']);
        }

        $this->layer_msg('计划任务(ID:' . $_GET["id"] . ')执行成功！', 9, 0, "index.php?m=cron");
    }

    function cronLog_action(){

        $ad_time        =   array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
        $search_list    =   array();
        $search_list[]  =   array('param'=>'end','name'=>'执行时间','value'=>$ad_time);
        $this->yunset('search_list',$search_list);

        $CronM  =   $this->MODEL('cron');

        if($_GET['keyword']){
            
            
            $keyword        =   trim($_GET['keyword']);
                
            $cronwhere  = array(
                'name'=>array('like',$keyword)
            );
            $crons = $CronM->getList($cronwhere);

            $cids = array();

            foreach ($crons as $key => $value) {
                $cids[] = $value['id'];
            }

            $where['cid'] = array('in',pylode(',',$cids));

            $urlarr['keyword']   =   $keyword;
            
        }
        
        
        if($_GET['end']){
            
            if($_GET['end']=='1'){
                
                $where['ctime']  =   array('>=', strtotime(date("Y-m-d 00:00:00")));
                
            }else{
                
                $where['ctime']   =   array('>=', '-'.strtotime((int)$_GET['end'].'day'));
                
            }
            
            $urlarr['end']          =   $_GET['end'];
        }
        if($_GET['time']){
            
            $times  =  @explode('~',$_GET['time']);
            
            $where['PHPYUNBTWSTART']     =  '';
            $where['ctime'][]       =  array('>=',strtotime($times[0]));
            $where['ctime'][]       =  array('<=',strtotime($times[1].'23:59:59'));
            $where['PHPYUNBTWEND']  =  '';
            
            $urlarr['time']  =  $_GET['time'];
        }
        $urlarr        	=   $_GET;
        $urlarr['page'] =   "{{page}}";
        $urlarr['c']    =   $_GET['c'];
        
        $pageurl        =   Url($_GET['m'], $urlarr, 'admin');
        
        //提取分页
        $pageM          =   $this  -> MODEL('page');
        $pages          =   $pageM -> pageList('cron_log', $where, $pageurl, $_GET['page']);
        
        //分页数大于0的情况下 执行列表查询
        if($pages['total'] > 0){
            
            //limit order 只有在列表查询时才需要
            if($_GET['order']){
                
                $where['orderby']       =   $_GET['t'].','.$_GET['order'];
                $urlarr['order']        =   $_GET['order'];
                $urlarr['t']            =   $_GET['t'];
                
            }else{
                
                $where['orderby']       =   array('id,desc');
                
            }
            
            $where['limit']         =   $pages['limit'];
            
            
            
            $List       =   $CronM -> getCronLogs($where,array('utype'=>'admin'));
            
            $this -> yunset(array('rows' => $List));
        }

        $this -> yuntpl(array('admin/admin_cronlog'));
    }
    function delLog_action(){

        if (is_array($_GET['del'])){
            
            $id        =   pylode(',', $_GET['del']);
            
            $where     =   array('id' => array('in', $id));
            
        }else{
            
            $this      ->  check_token();
            
            $where     =   array('id' => intval($_GET['del']));
        }
        
        $CronM  =   $this->MODEL('cron');
        
        $return  =  $CronM -> delCronlLog($where);
        
        $this  ->  layer_msg($return['msg'], $return['errcode'], $return['layertype'],$_SERVER['HTTP_REFERER']);
    }
}

?>