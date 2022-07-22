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
class crm_waitingtaskall_controller extends adminCommon{

    function index_action() {

        $crmM   		=   $this -> MODEL('crm');
        $adminM         =   $this -> MODEL('admin');

        $adminUserList  =   $adminM -> getList(array('uid' => array('<>', '')), array('field' => '`uid`,`name`,`username`'));
        $this->yunset('adminUserList', $adminUserList);

        if ($_GET['time']) {

            $time		=	intval($_GET['time']);

            if($_GET['time']!=4){
                if($time==1){//明天

                    $sDate  =   mktime(0, 0, 0, date('m'), date('d'), date('Y'))  +  86400;
                    $eDate  =   mktime(23, 59, 59, date('m'), date('d'), date('Y')) + 86400;

                }elseif($time==2){//后天

                    $sDate  =   mktime(0, 0, 0, date('m'), date('d'), date('Y')) + 2 * 86400;
                    $eDate  =   mktime(23, 59, 59, date('m'), date('d'), date('Y')) + 2 * 86400;

                }elseif($time==3){//一周内
                    $sDate  =   mktime(0,0,0,date('m'),date('d'),date('y'));
                    $eDate  =   mktime(23, 59, 59, date('m'), date('d'), date('Y'))  + 7 * 86400;
                }

                $where['PHPYUNBTWSTART_A']	=	'' ;
                $where['stime'][]   		=   array('>=',$sDate,'and');
                $where['stime'][]			=	array('<=',$eDate,'and') ;
                $where['stime'][]			=	array('isnull','','OR') ;
                $where['PHPYUNBTWEND_A']	=	'' ;
            }
            $urlarr['time']				=   intval($_GET['time']);

        }elseif (!$_GET['time']) {//今天
            $eDate  =   mktime(23, 59, 59,date('m'),date('d'),date('y'));
            $where['PHPYUNBTWSTART_A']	=	'' ;
            $where['stime'][]			=	array('<=',$eDate,'and') ;
            $where['stime'][]			=	array('isnull','','OR') ;
            $where['PHPYUNBTWEND_A']	=	'' ;
        }

        if ($_GET['status']) {

            $status =   intval($_GET['status']);

            if ($status != 5) {

                $where['status']    =   $status;
            }
            $urlarr['status']       =   $status;
        }else {

            $urlarr['status']       =   1;
            $where['status']        =   1;
        }

        if ($_GET['type']) {

            $type           =   intval($_GET['type']);
            $where['type']  =   $type;
            $urlarr['type'] =   $type;
        }

        if ($_GET['keyword']) {

            $KeywordStr =   trim($_GET['keyword']);

            $comM               =   $this->MODEL('company');
            $coms               =   $comM->getList(array('name' => array('like', $KeywordStr)), '`uid`');
            if (!empty($coms)){

                $comUids        =   array();
                foreach ($coms['list'] as $ck => $cv) {
                    $comUids[$cv['uid']]   =   $cv['uid'];
                }
            }

            if (!empty($comUids)){

                $where['PHPYUNBTWSTART_B']  =   '';
                $where['content']           =   array('like', $KeywordStr, '');
                $where['comid']             =   array('in', pylode(',', $comUids), 'or');
                $where['PHPYUNBTWEND_B']    =   '';
            }else{

                $where['content']   =   array('like', $KeywordStr);
            }

            $urlarr['keyword']  =   $KeywordStr;
        }

        if(!empty($_GET['crmuid'])) {
            $where['uid']		=	$_GET['crmuid'];
            $urlarr['crmuid']	=   $_GET['crmuid'];
        }

        $urlarr        		=   $_GET;
        $urlarr['page']	    =	'{{page}}';
        $pageurl            =	Url($_GET['m'], $urlarr, 'admin');
        $pageM              =	$this  -> MODEL('page');
        $pages              =	$pageM -> pageList('crm_work_plan', $where, $pageurl, $_GET['page']);
        if ($pages['total'] > 0) {
            if ($_GET['order']) {

                $where['orderby']   =   $_GET['t'].','.$_GET['order'];
                $urlarr['order']    =   $_GET['order'];
                $urlarr['t']        =   $_GET['t'];

            }else{
                $where['orderby'] 	=   array('stime,desc','type,asc','ctime,desc');
            }
            $where['limit']         =   $pages['limit'];

            $list                   =   $crmM -> getTaskList($where, array('utype' => 'crm'));

            $this -> yunset(array('tasks' => $list));
        }
        $cacheM         =   $this->MODEL('cache');
        $cache          =   $cacheM->GetCache(array('crm'));
        $this->yunset('cache', $cache);
        $this->yuntpl(array('admin/crm_waitingtaskall'));
    }

    function setStatus_action() {

        $crmM =   $this -> MODEL('crm');

        if((int)$_POST['type']==1){

            if((int)$_POST['status']==3){//未完成

                $data['reason']	=	$_POST['reason'];
            }
            $data['status']		=	(int)$_POST['status'];

            $nid				=	$crmM->upTask($data,array('id'=>(int)$_POST['id']));

        }else{

            $nid				=	$crmM->delTask(array('id'=>(int)$_POST['id'],array('utype'=>'admin')));
        }
        if($nid){
            echo 1;die;
        }
    }

    function add_action(){
        $crmM	=   $this -> MODEL('crm');

        $Data	=   array(
            'id'		=>	intval($_POST['id']),
            'auid'     	=>  $_SESSION['auid'],
            'uid'      	=>  $_SESSION['auid'],
            'comid'    	=>  intval($_POST['com_uid']),
            'title'    	=>  $_POST['title'],
            'content' 	=>  $_POST['content'],
            'stime'   	=>  $_POST['stime'],

        );
        $return	=	$crmM -> addWaitingTask($Data);
        if(intval($_POST['id'])){
            $msg='修改';
        }else{
            $msg='添加';
        }
        if($return['id']){
            $this->ACT_layer_msg($msg.'成功！', 9, $_SERVER['HTTP_REFERER'],2,1);
        }else{
            $this->ACT_layer_msg($msg.'失败，请重新'.$msg.'！', 8, $_SERVER['HTTP_REFERER']);
        }
    }
    function detail_action(){
        $crmM					=   $this -> MODEL('crm');
        $info					=	$crmM -> getTaskInfo(array('id'=>intval($_POST['id'])));

        $companyM				=   $this -> MODEL('company');
        $cominfo				=   $companyM -> getInfo($info['comid'],array('field' => '`uid`,`name`'));
        $info['comname']		=$cominfo['name'];
        echo json_encode($info);
    }
    function ComDetail_action(){

        $companyM	=   $this -> MODEL('company');
        $info		=   $companyM -> getInfo((int)$_POST['uid'],array('field' => '`uid`,`name`,`linktel`,`linkphone`,`provinceid`,`cityid`,`three_cityid`,`linkman`'));
        $info['uid']	=	$_POST['uid'];
        $info['cityname']	=	$info['job_city_one'].' '.$info['job_city_two']. ' '.$info['job_city_three'];
        if($info['linktel']){
            $info['moblie']	=	$info['linktel'];
        }else{
            $info['moblie']	=	$info['linkphone'];
        }

        $statisM	=   $this -> MODEL('statis');
        $statis		=   $statisM -> getInfo((int)$_POST['uid'],array('usertype'=>2,'field' => '`rating_name`,`vip_etime`'));
        if($statis){
            $info['ratingname']		=	$statis['rating_name'];
            if($statis['vip_etime']){
                $info['ratingtime']	=	date('Y-m-d',$statis['vip_etime']);
            }else{
                $info['ratingtime']	=	'永久会员';
            }
        }
        echo json_encode($info);
    }
    function reason_action(){
        $crmM	=   $this -> MODEL('crm');
        $info	=	$crmM -> getTaskInfo(array('id'=>intval($_POST['id'])),array('field'=>'`reason`'));
        echo $info['reason'];
    }
}

?>