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
class index_controller extends zphnet_controller{
	function index_action()
	{
	    $this->seo('zphnet');
	    $this->yun_tpl(array('index'));
	}


	function show_action()
	{
	    $zid      =  intval($_GET['id']);
	    $zphnetM  =  $this->MODEL('zphnet');
	    // 网络招聘会信息
	    $row      =  $zphnetM->getInfo(array('id'=>$zid));
	    $this->yunset('row',$row);
	    //用户进入记录
	    if ($this->uid && $this->usertype){
	        //招聘会进行中记录用户进入记录
	        if ($row['etime'] > 0){
	            
	            $zphnetM->addZphnetUser(array('zid'=>$zid,'uid'=>$this->uid,'usertype'=>$this->usertype));
	        }
	        
	        if ($this->usertype == 1){
	            
	            $resumeM  =  $this->MODEL('resume');
	            $enum     =  $resumeM->getExpectNum(array('uid'=>$this->uid));
	            
	            $this->yunset('enum',$enum);
	        }
	    }

	    $jkeyword  =  $rkeyword  =  '';
	    if ($_GET['ztype'] == 'job'){
	        
	        $jkeyword  =  trim($_GET['keyword']);
	        
	    }elseif ($_GET['ztype'] == 'resume'){
	        
	        $rkeyword  =  trim($_GET['keyword']);
	    }
	    //进入大厅滚动展示
	    $horn    =  $zphnetM->getZphnetUser(array('zid'=>$zid,'orderby'=>'ctime','limit'=>10));
	    $this->yunset('horn',$horn);
	    // 底部数量统计
	    $allnum  =  $zphnetM->getZphnetAllNum(array('zid'=>$zid, 'status'=>1));
	    $this->yunset('allnum',$allnum);
	    // 查看职位记录
	    $look    =  $zphnetM->getZphnetLook(array('zid'=>$zid,'orderby'=>'ctime','limit'=>15));
	    $this->yunset('look',$look);
	    
	    // 企业列表展示，招聘会绑定了展示区域，按区分分类查
	    if(!empty($row['zw'])){
	        
	        $zphArea  =  $zphnetM->getClass(array('id'=>$row['zw']));
	        $this->yunset('zphArea',$zphArea);

	        $area   =  $zphnetM->getClassList(array('keyid'=>$row['zw'],'orderby'=>'sort,asc'));
	        $this->yunset('area',$area);
	    }

	    if ($_GET['zw']){
            $zw  =  intval($_GET['zw']);
        }elseif ($_GET['zw'] == 'other'){
            $zw  =  0;
        }

        $areaCom    =   $zphnetM->getAreaComList(array('zid'=>$row['id'],'limit'=>21),array('zw'=>$zw,'keyword'=>$jkeyword));
        $this->yunset('areaCom',$areaCom);

	    //报名时用到套餐相关数据
	    if ($this->usertype == 2) {
	        
	        $ratingM    =   $this->MODEL('rating');
	        $ratingList =   $ratingM->getList(array('display' => 1, 'orderby' => array('type,asc', 'sort,desc')));
	        
	        $rating_1 = $rating_2 = $raV = array();
	        
	        if (! empty($ratingList)) {
	            
	            foreach ($ratingList as $ratingV) {
	                
	                $raV[$ratingV['id']] = $ratingV;
	                
	                if ($ratingV['category'] == 1 && $ratingV['service_price'] > 0) {
	                    
	                    if ($ratingV['type'] == 1) {
	                        
	                        $rating_1[] = $ratingV;
	                    } elseif ($ratingV['type'] == 2) {
	                        
	                        $rating_2[] = $ratingV;
	                    }
	                }
	            }
	        }
	        $this->yunset('rating_1', $rating_1);
	        $this->yunset('rating_2', $rating_2);
	        
	        $statisM    =   $this->MODEL('statis');
	        $statis     =   $statisM->getInfo($this->uid, array( 'usertype' => 2));
	        
	        if (! empty($statis)) {
	            $discount   =   isset($raV[$statis['rating']]) ? $raV[$statis['rating']] : array();
	            $this -> yunset('discount', $discount);
	            $this -> yunset('statis', $statis);
	        }
	        
	        $add    =   $ratingM->getComSerDetailList(array('orderby' => array('type,asc', 'sort,desc')), array('pack' => '1'));
	        $this -> yunset('add', $add);
	        
	        $couponM    =   $this->MODEL('coupon');
	        $couponList =   $couponM->getCouponList(array('uid' => $this->uid, 'status' => 1, 'validity' => array('>', time()), 'orderby'=>array('coupon_amount,asc','coupon_scope,asc')));
	        $this->yunset('couponList', $couponList);
	    }
        $CacheM		=	$this -> MODEL('cache');
        $CacheList	=	$CacheM -> GetCache(array('hy','com'));
        $this->yunset($CacheList);
	    if($_GET['boxtype']){
			
			 $this->yunset('boxtype', $_GET['boxtype']);
		}
		// 增加浏览数
		$zphnetM->addZphnetHits($row['id']);
		
	    $data['zph_title']  =   $row['title'];
	    $data['zph_desc']   =   $this -> GET_content_desc($row['body']);
	    $this -> data       =   $data;
	    
	    $this->seo('zphnet_show');
	    $this->yun_tpl(array('show'));
	}


	/**网络招聘详情页 默认加载招聘岗位*/
 	function getComList_action()
    {
        $zid      =  intval($_POST['zid']);
        $zphnetM  =  $this->MODEL('zphnet');
        $row      =  $zphnetM->getInfo(array('id'=>$zid));
        // 关键词搜索/已分配展位时，一页全部加载，不需要分页
        if ($_POST['keyword'] == ''){
            $page     =  intval($_POST['page']);
            $limit    =  21;
            
            $where['zid']      =  $zid;
            if($page > 0){
                
                $pagenav  =  ($page - 1) * $limit;
                $where['limit']  =  array($pagenav,$limit);
                
            }else{
                
                $where['limit']  =  $limit;
            }
            if ($_POST['zw']){
                $zw  =  intval($_POST['zw']);
            }elseif ($_POST['zw'] == 'other'){
                $zw  =  0;
            }
            $areaCom			  =  $zphnetM->getAreaComList($where,array('zw'=>$zw,'keyword'=>$_POST['keyword']));
			
            $areaCom['spOpen']    =  $this->config['sy_spview_web'];
            $areaCom['usertype']  =  $this->usertype;
            echo json_encode($areaCom);
        }
    }

	/**
	 * 保存查看企业、职位记录
	 */
	function setLook_action()
	{
	    
	    $zid    =  intval($_POST['id']);
	    $jobid  =  intval($_POST['jobid']);
	    $comid  =  intval($_POST['comid']);
	    
	    $zphnetM  =  $this->MODEL('zphnet');
	    $row      =  $zphnetM->getInfo(array('id'=>$zid));
	    
	    //招聘会进行中才保存
	    if ($row['stime'] < 0 && $row['etime'] > 0){
	        
	        $data   =  array(
	            'uid'       =>  $this->uid,
	            'usertype'  =>  $this->usertype,
	            'zid'       =>  $zid,
	            'jobid'     =>  $jobid,
	            'comid'     =>  $comid,
	            'ctime'     =>  time()
	        );
	        
	        $zphnetM->addZphnetLook($data);
	    }
	}
	/**
	 * 报名网络招聘会条件判断
	 */
	function ajaxZphnet_action(){
	    $data	=	array(
	        'usertype'	=>	$this->usertype,
	        'uid'		=>	$this->uid,
	        'spid'		=>	$this->spid,
	        'did'		=>	$this->config['did'],
			'jobid'		=>	$_POST['jobid'],
	        'zid'		=>	intval($_POST['zid']),
	    );
	    $zphnetM  =  $this->MODEL('zphnet');
	    $arr	  =  $zphnetM->ajaxZphnet($data);
	    
	    echo json_encode($arr);die;
	}
	/**
	 * 检查参会情况
	 */
	function isJoin_action(){
	    
	    if ($this->uid){
	        
	        $zphnetM  =  $this->MODEL('zphnet');
	        
	        $row	  =	 $zphnetM->getZphnetCom(array('uid'=>$this->uid,'zid'=>$_POST['zid']),array('field'=>'`status`'));
	        if(!empty($row)) {
	            
	            $row['code'] = 1;
	            
	        }else{
	            $row['code'] = 2;
	        }
	        
            echo json_encode($row);
	    }
	}
}
?>