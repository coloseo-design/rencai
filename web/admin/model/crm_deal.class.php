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
class crm_deal_controller extends adminCommon
{

    function index_action()
    {
                
        $adminM =   $this->MODEL('admin');
        
        $orderM =   $this->MODEL('companyorder');
        
        $power  =  $adminM -> getPower(array('uid'=>$_SESSION['auid']));
        
        $this ->  yunset('power', $power['power']);
        
        $where  =   $urlarr =   array();

        $where['order_state']   =   2;
        
        $auid   =   intval($_SESSION['auid']);
        
        $auser  =   $adminM -> getAdminUser(array('uid' => $auid));
   
        if ($_GET['depart'] == '1') {
            
            if($auser['org'] > 0){
            	
            	$crmM	=	$this->MODEL('crm');
                $orgInfo	=	$crmM -> getOrgInfo(array('id' => $auser['org']));
        	
	        	$oIds	=	$orgIds	=	$orgIdss	=	$orgIdsss	=	array();
	        	 
	        	if ($auser['power'] == '1'){	// 同级部门权限
	        		$oList				=	$crmM -> getOrgList(array('level' => $orgInfo['level']));
	        		
	        		foreach ($oList as $k => $v) {
	        			$orgIds[]		=	$v['id'];
	        		}	
	        	}
	        	
	        	if ($auser['power'] == '1'){	// 子部门权限
		        	if ($orgInfo['level'] == '1'){
		        		 
		        		$orgList			=	$crmM -> getOrgList(array('fid' => $auser['org']));
		        		
		        		foreach ($orgList as $ok => $ov) {
		        			$orgIdss[]		=	$ov['id'];	
		        		}
		        		
		        		$orgLists			=	$crmM -> getOrgList(array('fid' => array('in', pylode(',', $orgIdss))));
		        		
		        		foreach ($orgLists as $ook => $oov) {
		        			$orgIdsss[]		=	$oov['id'];
		        		}
		        		
		        	}elseif ($orgInfo['level'] == '2'){
		        		 
		        		$orgList			=	$crmM -> getOrgList(array('fid' => $auser['org']));
		        		foreach ($orgList as $ok => $ov) {
		        			$orgIdss[]		=	$ov['id'];	
		        		}
		        		
		        	} 
	        	}
	        	$oIds	=	array_merge($orgIds, $orgIdss, $orgIdsss);
	        	
	            $ausers	=	$adminM -> getList(array('uid'=>array('<>',$_SESSION['auid']),'org'=>array('in', pylode(',', $oIds))),array('field'=>'`uid`,`name`,`username`'));
    			
	            foreach ($ausers as $av) {
	            	$auids[]	=	$av['uid'];
	            }
            }
            
            if ($_GET['auid']) {
            
                $where['crm_uid']   =   $_GET['auid'];
                $urlarr['auid']     =   $_GET['auid'];
            }else{
                
                $where['PHPYUNBTWSTART_A']  =   '';
                $where['crm_uid'][]	        =	array('<>',0,'AND');
                $where['crm_uid'][]	        =	array('in',pylode(',',$auids),'AND');
                $where['PHPYUNBTWEND_A']    =   '';
            }
            
            $this->yunset(array('depart' => 1, 'ausers' => $ausers));
        }else{
            
            $where['crm_uid']   =   $auid;
        }
        
        if ($_GET['orDay']) {
            
            $orDay  =   intval($_GET['orDay']);
            
            if ($orDay == 1) {
                
                $where['order_time']        =   array('>', strtotime(date('Y-m-d')));
            }else if($orDay == 2){
                
                $where['PHPYUNBTWSTART_A']  =   '';
                $where['order_time'][]      =   array('>=', strtotime(date('Y-m-d')) - 86400, 'AND');
                $where['order_time'][]      =   array('<=', strtotime(date('Y-m-d')), 'AND');
                $where['PHPYUNBTWEND_A']    =   '';
            }
            
            $urlarr['orDay']    =   $orDay;
        }
        
        if ($_GET['rating']) {
            
            $rating =   intval($_GET['rating']);
            
            $where['rating']    =   $rating;
            $urlarr['rating']   =   $rating;
        }
        
        if ($_GET['keyword']) {
            
            $TypeStr    =   intval($_GET['or_type']);
            $KeywordStr =   trim($_GET['keyword']);
            
            if ($TypeStr == 1) {
                
                $cWhere['name']     =   array('like', $KeywordStr);
            }elseif ($TypeStr == 2){
                
                $cWhere['linkman']  =   array('like', $KeywordStr);
            }
            
            $comM       =   $this -> MODEL('company');
            
            $comList    =   $comM -> getList($cWhere, array('field' => '`uid`'));

            foreach ($comList['list'] as $cv) {
                $uids[] =   $cv['uid'];
            }
            
            $where['uid']   =   array('in', pylode(',', $uids));
            
            
            $urlarr['keyword']  =   $KeywordStr;
            $urlarr['or_type']  =   $TypeStr;
        }
        
        $urlarr        		=   $_GET;
        $urlarr['page']     =   '{{page}}';
        $pageurl            =   Url($_GET['m'], $urlarr, 'admin');
        
         
        $pageM              =   $this -> MODEL('page');
        $pages              =   $pageM -> pageList('company_order', $where, $pageurl, $_GET['page']);
        
        if ($pages['total'] > 0) {
            
            
            if ($_GET['order'] && $_GET['t']) {

                $where['orderby']   =   $_GET['t'].','.$_GET['order'];
                $urlarr['order']    =   $_GET['order'];
                $urlarr['t']        =   $_GET['t'];
            } else {

                $where['orderby']   =   'id, DESC';
            }

            $where['limit']         =   $pages['limit'];
            
            $orders                 =   $orderM -> getList($where, array('utype' => 'crmdeal'));
         
        }
        
        $ratingM    =	$this -> MODEL('rating');
        $ratinglist	=	$ratingM -> getList(array('category' => '1', 'service_price' => array('>', '0')), array('field'=>'`id`,`name`'));
        
        $this->yunset(array('orders' => $orders, 'auser' => $auser, 'ausers' => $ausers, 'ratinglist' => $ratinglist));
        $this->yuntpl(array('admin/crm_deal_list'));
    }
     
}
?>