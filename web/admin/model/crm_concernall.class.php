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

class crm_concernall_controller extends adminCommon
{

    function index_action()
    {

        $crmM               =   $this -> MODEL('crm');

        $where              =   array();

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

		if($_GET['day']){

		    unset($_GET['stime']);
		    unset($_GET['etime']);

            $time		    =	intval($_GET['day']);

			if($time == 1){//今天
			    
			    $startTime   =   mktime(0,0,0,date('m'),date('d'),date('y'));
			    $endTime     =   time();  
			}else if($time == 2){//昨天
			    
			    $startTime   =   mktime(0, 0, 0, date('m'), date('d'), date('Y'))  - 86400;
			    $endTime     =   mktime(23, 59, 59, date('m'), date('d'), date('Y')) - 86400;
			}else if($time == 3){//本周
			    
			    $startTime   =	strtotime(date('Y-m-d', strtotime("this week Monday", time())));
			    $endTime     =	strtotime(date('Y-m-d', strtotime("this week Sunday", time()))) + 24 * 3600 - 1;
			}else if($time == 4){//本月
			    
			    $startTime   =	mktime(0, 0, 0, date('m'), 1, date('Y'));
			    $endTime     =	mktime(23, 59, 59, date('m'), date('t'), date('Y'));
			}
			$where['PHPYUNBTWSTART_A_DOUBLE']  =  '';
			
			$where['ftime'][]             =   array('>', $startTime, 'AND');
			$where['ftime'][]             =   array('<', $endTime,'AND');
			
			$where['PHPYUNBTWEND_A']      =   '';
			
			$where['PHPYUNBTWSTART_B']    =   'OR';
			
			$where['atime'][]             =   array('>', $startTime, 'AND');
			$where['atime'][]             =   array('<', $endTime,'AND');
			
			$where['PHPYUNBTWEND_B_DOUBLE']  =  '';
			
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
		
        if($_GET['uid']){
        
            $where['auid']  =   $_GET['uid'];
            $urlarr['uid']  =   $_GET['uid'];
        }

        $urlarr        		=   $_GET;
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
            $this -> yunset(array('rows' => $list));
        }

        $adminM =   $this -> MODEL('admin');
        $auser  =   $adminM -> getList(array(),array('field'=>'`uid`,`name`'));
        $this->yunset('auser',$auser);

        $cacheM =   $this->MODEL('cache');
        $cache  =   $cacheM -> GetCache(array('crm'));
        $this -> yunset('cache', $cache);

        $this->yuntpl(array('admin/crm_concernall'));
    }

    function del_action()
    {

        $this->check_token();

        $crmM   =   $this->Model('crm');
        $delID  =   $_GET['id'] ? intval($_GET['id']) : $_GET['del'];
        $err    =   $crmM->delConcern($delID);
        $this->layer_msg($err['msg'], $err['errcode'], $err['layertype'], $_SERVER['HTTP_REFERER'], 2, 1);
    }
}

?>