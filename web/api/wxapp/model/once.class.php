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
class once_controller extends wxapp_controller{
	//wxapp招聘店铺列表
	function list_action(){

		$onceM		=	$this->MODEL('once');
		$keyword	=	$this->stringfilter($_POST['keyword']);
		$provinceid			=	(int)$_POST['provinceid'];
		$cityid				=	(int)$_POST['cityid'];
		$three_cityid		=	(int)$_POST['three_cityid'];
		$page		=	$_POST['page'];
		$limit		=	$_POST['limit'];
		$order		=	$_POST['order'];
		$nodata		=	$_POST['nodata'];
		$limit		=	!$limit?10:$limit;
		$where['status']	=	'1';
		$where['pay']		=	array('<>',1);
		$where['edate']		=	array('>',time());
		
		if ($_POST['keyword']!='undefined'){
		    $keyword		=	$this->stringfilter($_POST['keyword']);
		}

		if($nodata){
			$nodataarr	=	explode(",",$nodata);
			foreach($nodataarr as $v){
				$where[$v]	=	array('<>','');
			}
		}
		if($order){
			$where['orderby']	=	$order.',desc';
		}else{
			$where['orderby']	=	'ctime,desc';
		}
		if($page){
			$pagenav	=	($page-1)*$limit;
			$where['limit']	=	array($pagenav,$limit);
		}else{
			$where['limit']	=	array('',$limit);
		}
		if($provinceid){//类别ID
			$where['provinceid']=	$provinceid;
		}
		if($cityid){//类别ID
			$where['cityid']	=	$cityid;
		}
		if($three_cityid){//类别ID
			$where['three_cityid']	=	$three_cityid;
		}
		if($keyword){//关键字
			

			$where['PHPYUNBTWSTART_A']	=	'';
            $where['companyname']		=	array('like',$keyword);
            $where['title']				=	array('like',$keyword,'OR');
            
            $where['PHPYUNBTWEND_A']	=	'';
		}
		// 处理分站查询条件
		if (!empty($_POST['did'])){
		    
		    $domain  =  $this->getDomain($_POST['did'], true);
		    
		    if (isset($domain['didcity'])){
		        
		        $data['didcity']    =  $domain['didcity'];
		        
		        if (!empty($_POST['provinceid'])){
		            // 分站下，再次选择城市，查询按选择的来
		            $where['provinceid']  =  $_POST['provinceid'];
		            $data['didcity']      =  $domain['city_name'][$_POST['provinceid']];
		        }elseif (!empty($domain['provinceid'])){
		            $where['provinceid']  =  $domain['provinceid'];
		        }
		        if (!empty($_POST['cityid'])){
		            // 分站下，再次选择城市，查询按选择的来
		            $where['cityid']  =  $_POST['cityid'];
		            $data['didcity']  =  $domain['city_name'][$_POST['cityid']];
		        }elseif (!empty($domain['cityid'])){
		            $where['cityid']  =  $domain['cityid'];
		        }
		        if (!empty($_POST['three_cityid'])){
		            // 分站下，再次选择城市，查询按选择的来
		            $where['three_cityid']  =  $_POST['three_cityid'];
		            $data['didcity']        =  $domain['city_name'][$_POST['three_cityid']];
		        }elseif (!empty($domain['three_cityid'])){
		            $where['three_cityid']  =  $domain['three_cityid'];
		        }
		        
		        $data['cityone']    =  $domain['cityone'];
		        $data['citytwo']    =  $domain['citytwo'];
		        $data['citythree']  =  $domain['citythree'];
		        $data['provinceid']    =  !empty($where['provinceid']) ? intval($where['provinceid']) : 0;
		        $data['cityid']        =  !empty($where['cityid']) ? intval($where['cityid']) : 0;
		        $data['three_cityid']  =  !empty($where['three_cityid']) ? intval($where['three_cityid']) : 0;
		    }
		}else{
		    // 没有已选择的城市，按后台设置的列表页区域默认设置来（后台-页面设置-列表页区域默认设置）
		    // 设置了一级城市，后面的搜索，不再展示其他一级城市
		    if (empty($_POST['provinceid']) && empty($_POST['cityid']) && empty($_POST['three_cityid']) || (!empty($_POST['provinceid']) && $_POST['provinceid'] == $this->config['sy_web_city_one'])){
		        
		        $list_cityid      = isset($where['cityid']) ? $where['cityid'] : 0;
		        $list_threecityid = isset($where['three_cityid']) ? $where['three_cityid'] : 0;
		        
		        $listback = $this->listCity($list_cityid, $list_threecityid);
		        if (!empty($listback)) {
		            if (isset($listback['provinceid'])){
		                $where['provinceid']  =  $listback['provinceid'];
		            }
		            if (isset($listback['cityid'])){
		                $where['cityid']  =  $listback['cityid'];
		            }
		            if (isset($listback['listcity'])){
		                $data['listcity']   =  $listback['listcity'];
		                $data['cityone']    =  $listback['cityone'];
		                $data['citytwo']    =  $listback['citytwo'];
		                $data['citythree']  =  $listback['citythree'];
		                
		                $data['provinceid']    =  !empty($where['provinceid']) ? intval($where['provinceid']) : 0;
		                $data['cityid']        =  $list_cityid;
		                $data['three_cityid']  =  $list_threecityid;
		            }
		        }
		    }
		}
		$rows	=	$onceM->getOnceList($where);		
		if(is_array($rows)&&!empty($rows)){
			$data['user_wzp_link']	=	$this->config['user_wzp_link'];
			$data['list']	=	count($rows)?$rows:array();
			$error	=	1;
		}else{
			$error	=	2;
		}
		$data['iosfk']		=	$this->config['sy_iospay'] ;			
		// 小程序用seo
		if (isset($_POST['provider'])){
            if ($_POST['provider'] == 'baidu' || $_POST['provider'] == 'weixin' || $_POST['provider'] == 'toutiao'){
                $seo            =  $this->seo('once','','','',false, true);
                $data['seo']    =  $seo;
            }
		}
		
		$this -> render_json($error,'',$data);
	}
	
	//wxapp招聘店铺详情页
	function show_action(){//职位内容页
		$id	=	(int)$_POST['id'];
		
		$onceM	=	$this->MODEL('once');
		
		$onceM->upOnce(array('hits'=>array('+',1)),array('id'=>$id));
		$row	=	$onceM->getOnceInfo(array('id'=>$id));
		
		if($row['status']<1  && !$_POST['fk']){
			
			$data['msg']	=	'店铺正在审核！';
			$error	=	4;
			
		}elseif($row['pay']=='1' && !$_POST['fk']){
			
			$data['msg']	=	'店铺招聘付费中！';
			$error	=	5;
			
		}else{
			
			$data['user_wzp_link']	=	$this->config['user_wzp_link'];
			
			if (!empty($row['require'])){
			    
			    $row['require'] = $this->preghtml($row['require']);
			}
			
			$data['list']	=	count($row)?$row:array();
			$error	=	1;
			// 小程序用seo
			if (isset($_POST['provider'])){
			    // app用分享数据
			    if ($_POST['provider'] == 'app'){
			        $data['shareData']  =  array(
			            'url'       =>  Url('wap',array('c'=>'once','a'=>'show','id'=>$id)),
			            'title'     =>  $row['title'],
			            'summary'   =>  mb_substr(strip_tags($row['require']), 0,30,'UTF8'),
			            'imageUrl'  =>  checkpic($row['pic'],$this->config['sy_once_icon'])
			        );
			    }
			    if ($_POST['provider'] == 'baidu' || $_POST['provider'] == 'weixin' || $_POST['provider'] == 'toutiao'){
			        $data['once_job']	=	$row['title'];
			        $data['once_name']	=	$row['companyname'];
			        $description		=	$row['require_n'];
			        $data['once_desc']	=	$this->GET_content_desc($description);
			        $this->data			=	$data;
                    $seo                =  $this->seo('once_show','','','',false, true);
                    $data['seo']        =  $seo;
			    }
			}
		}
		$this -> render_json($error,$data['msg'],$data);
	}
    function sendmsg_action()
    {
        $moblie			=		$_POST['moblie'];
        
        $this->checkMcsdk($moblie);
        
        $noticeM 		= 		$this->MODEL('notice');

        $port	=	$this->plat == 'mini' ? '3' : '4';	// 短信发送端口$port : 3-小程序  4-APP
        $result	=	$noticeM->sendCode($moblie, 'cert', $port, array(), 6, 120, 'msg');
        if($result['error']==1){
            $errcode	=	1;
            $msg = '发送成功';
        }else{
            $errcode	=	2;
            $msg		=	$result['msg'];
        }

        $this->render_json($errcode,$msg);
    }
	//wxapp招聘店铺添加修改
	function add_action()
	{
		$error		=	1;
		$msg		=	'';
		if($this->config['sy_once_web']=="2"){
			$msg	=	'很抱歉！该模块已关闭！';
			$error	=	2;
			
		}
		if($error==1){
			
			$onceM	=	$this->MODEL('once');
			if((int)$_POST['id']){
				$id				=	(int)$_POST['id'];
				$row			=	$onceM->getOnceInfo(array('id'=>$id));
				$data['row']	=	count($row) ? 	$row : array();
			}else{
				if($this->config['once_pay_price']!="0" && $this->config['once_pay_price']!="" && $_POST['fast']){
					//未付款订单
					$companyorderM	=	$this->MODEL('companyorder');
					$orderNum 		= 	$companyorderM->getCompanyOrderNum(array('order_state'=>1,'type'=>25,'fast'=>$_POST['fast']));
					$data['orderNum']	=	$orderNum;
				}
			}
		}
 		
 		$data['onceprice'] = $this->config['once_pay_price']!="0" ? $this->config['once_pay_price'].'元/天' : '';
 		$data['ismoblie_code'] = $this->config['sy_msg_isopen'];

		$this -> render_json($error,$msg,$data);
	}
	function save_action()
	{
	    $_POST	=	$this->post_trim($_POST);
	    
	    $onceM		=	$this->MODEL('once');
	    
	    if($_POST['edate']){
	        $edate	=	strtotime("+".(int)$_POST['edate']." days");
	    }
	    
	    $post		=   array(
	        'title' 		=>  $_POST['title'],
	        'companyname'	=>  $_POST['companyname'],
	        'linkman'		=>	$_POST['linkman'],
	        'phone' 		=>  $_POST['phone'],
	        'provinceid' 	=>  $_POST['provinceid'],
	        'cityid' 		=>  $_POST['cityid'],
	        'three_cityid'	=>  $_POST['three_cityid'],
	        'address' 		=>  $_POST['address'],
	        'require' 		=>  $_POST['requires'],
	        'base'			=>	$_POST['preview'],
	        'edate'			=>	$edate,
	        'salary'		=>	$_POST['salary'],
	        'password'		=>	$_POST['password'],
	        'status' 		=>  $this->config['com_fast_status'],
	        'ctime'			=>	time(),
			'file' 			=> 	$_FILES['photos'], 
	        'did'			=>	$this->config['did'],
	        'login_ip'		=>	$_POST['login_ip']
	    );
	    $addData		=	array(
	        'id'				=>	(int)$_POST['id'],
	        'post'				=>	$post,
	        'fast'				=>	$_POST['fast'],
	        'moblie_code'				=>	$_POST['moblie_code'],
	        'type'				=>	'wxapp'
	    );
	    
	    $return  	= 	$onceM  ->  addOnceInfo($addData,'wxapp');
	    
	    $this -> render_json($return['errcode'],$return['msg'],array('id'=>$return['id']));
	}
	function pass_action(){
		$id	=	(int)$_POST['id'];
		if(!$_POST['password'] || !$id){
			$error	=	3;
		}else{
			$onceM	=	$this->MODEL('once');
			$sdata	=	array(
			   // 'code'		=>	$_POST['checkcode'],
				'id'		=>	(int)$_POST['id'],
				'password'	=>	$_POST['password'],
				'type'		=>	2
			);
			$return		=	$onceM -> setOncePassword($sdata);
			if($return['errcode']==9){
				$error	=	1;
			}else{
				$error	=	2;
			}
		}
		$this -> render_json($error,$return['msg']);
	}

	//wxapp招聘店铺删除
	function del_action(){
		$id		=	(int)$_POST['id'];
		if(!$_POST['password'] || !$id){
			$error	=	3;
		}else{
			$onceM	=	$this->MODEL('once');
			$sdata	=	array(
				// 'code'		=>	$_POST['checkcode'],
				'id'		=>	(int)$_POST['id'],
				'password'	=>	$_POST['password'],
				'type'		=>	3
			);
			$return		=	$onceM -> setOncePassword($sdata);
			if($return['errcode']==9){
				$error	=	1;
			}else{
				$error	=	2;
			}
		}
		$this -> render_json($error,$return['msg']);
	}
	//wxapp招聘店铺刷新
	function editctime_action(){
		$id=(int)$_POST['id'];
		if(!$_POST['password'] || !$id){
			$error	=	3;
		}else{
			$onceM	=	$this->MODEL('once');
			$data	=	array(
				// 'code'		=>	$_POST['checkcode'],
				'id'		=>	(int)$_POST['id'],
				'password'	=>	$_POST['password'],
				'type'		=>	1
			);
			$return		=	$onceM -> setOncePassword($data);
			if($return['errcode']==9){
				$error	=	1;
			}else{
				$error	=	2;
			}
		}
		$this->render_json($error,$return['msg']);
	}
	function isadd_action(){
		$onceM	=	$this->MODEL('once');
	    
		$data['sy_once']	=	$this->config['sy_once'];
	    $start_time			=	strtotime('today');
	    $login_ip			=	fun_ip_get();
        $totalMessNum       =   $onceM->getOnceNum(array('ctime'=>array('>',$start_time)));//当天总的已发布量
	    $oncenum			=	$onceM->getOnceNum(array('login_ip'=>$login_ip,'ctime'=>array('>',$start_time)));//当天该ip已发布总量
	    $data['num']		=	$this->config['sy_once'] - $oncenum;
        if(($this->config['sy_once_totalnum'] >= $totalMessNum) || $this->config['sy_once_totalnum'] == 0){
            if($this->config['sy_once']>$oncenum||$this->config['sy_once']<1){
                $data['isadd']	=	true;
            }else{
                $data['isadd']	=	false;
            }
        }else{
            $data['isadd'] = false;
        }

		$this->render_json(0,'',$data);
	}
	
	//删除未付款的店铺招聘
	function delfklog_action(){
		$orderM	=	$this->MODEL('companyorder');
		$id		=	$_POST['id'];
		$return	=	$orderM->del($id,array('utype'=>'once'));
		$error	=	$return['errcode']==9 ? 1 : 2;
		$msg	=	$return['msg'];
		$this->render_json($error,$msg);
	}
	
	function fk_action(){
		$error		=	1;
		$msg		=	1;
		if($this->config['sy_once_web']=="2"){
			$this->render_json(2,'很抱歉！该模块已关闭！');
		}
		$onceM		=	$this->MODEL('once');
		$row		=	$onceM->getOnceInfo(array('id'=>(int)$_POST['id']));
		if($_POST['id']){
			if(!$row){
				$msg	=	'店铺信息不存在！';
				$error	=	2;
				$this->render_json($error,$msg);
			}
		}
		
		$day  =   ceil(($row['edate'] - strtotime(date('Y-m-d')))/86400) - 1;
		
		
		$data['fktype']	 =  $this->fktype();
		$data['once_fk_price']=$this->config['once_pay_price'] * $day;
		$data['sy_freewebtel']=$this->config['sy_freewebtel'];
		$this->render_json($error,$msg,$data);
	}
	function tofk_action()
	{
		$data  =  array();
		
		if ($_POST['fktype'] == 'fkwx'){
		    $paytype  =  'wxh5';
		}elseif ($_POST['fktype'] == 'fkal'){
		    $paytype  =  'alipay';
		}elseif ($_POST['fktype'] == 'wxxcx'){
		    $paytype  =  'wxxcx';
		}elseif ($_POST['fktype'] == 'baidu'){
		    $paytype  =  'baidu';
		}elseif ($_POST['fktype'] == 'toutiao'){
		    $paytype  =  'toutiao';
		}
		
		$onceM	=	$this->MODEL('once');
		$data	=	array(
		    'id'		=>	$_POST['id'],
		    'did'		=>	$this->config['did'],
		    'pay_type'	=>	$paytype,
		    'once_price'=>	$_POST['once_price'],
		    'from'		=>	'wxapp'
		);
		$return	=	$onceM->payOnce($data);
		if($return['error'] == 0){
		    
		    $msg           =  'ok';
		    $data['id']    =  $return['oid'];
		    $data['fast']  =  $return['fast'];
		}else{
		    $msg  =  $return['msg'];
		}
		$this->render_json($return['error'],$msg,$data);
	}
	function fklog_action()
	{
		$companyorderM	=	$this->MODEL('companyorder');
		$rows 			= 	$companyorderM->getList(array('order_state'=>1,'type'=>25,'fast'=>$_POST['fast']));
		include (CONFIG_PATH.'db.data.php');
		foreach ($rows as $k => $v) {
			$rows[$k]['dingdan_id']			=	$v['order_id'];
			$rows[$k]['dingdan_price']		=	$v['order_price'];
			$rows[$k]['dingdan_time']		=	date('Y-m-d H:i:s',$v['order_time']);
			$rows[$k]['dingdan_remark']		=	$v['order_remark'];
			$rows[$k]['dingdan_type']	=	$v['order_type'];
			$rows[$k]['dingdan_state']	=	$v['order_state'];
			$rows[$k]['dingdan_type_n']	=	$v['order_type'] ? strip_tags($arr_data['pay'][$v['order_type']]) : '手动';
		}

		$data['list']	=	count($rows) ? $rows : array();

		$data['fast_status']		=	$this->config['com_fast_status'];
		$this->render_json(0,'',$data);
	}
}
?>