<?php
/* *
* $Author ：PHPYUN开发团队
*
* 官网: http://www.phpyun.com
*
* 版权所有 2009-2021 宿迁鑫潮信息技术有限公司，并保留所有权利。
*
* 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
*/
class lietou_controller extends wap_controller{
    
	function waptpl($tpname){
		$this->yuntpl(array('wap/member/lietou/'.$tpname));
	}
	
	function index_action(){
		$ltM		=	$this -> MODEL('lietou');
		$userinfoM	=	$this -> MODEL('userinfo');
		
		$user		=	$ltM -> getInfo(array('uid'=>$this->uid),array('utype'=>'user'));
		$this->yunset("user",$user);
		
		$date		=	date("Ymd");
		$reg		=	$userinfoM -> getMemberregInfo(array('uid'=>$this->uid,'usertype'=>$this->usertype,'date'=>$date));
		
		if($reg['id']){
			$signstate	=	1;
		}else{
			$signstate	=	0;
		}
		$this->yunset("signstate",$signstate);
		
		$backurl	=	Url('wap',array());
		$this->yunset('backurl',$backurl);
		
		$this->seo("ltindex");
		$this->yunset('membernav', 1);
		$this->waptpl('index');
	}
	//基本信息
	function info_action(){
		$CacheList	=	$this -> MODEL('cache')->GetCache(array('lt','lthy','ltjob','city'));
		$this->yunset($CacheList);
		
		$LietouM	=	$this -> MODEL('lietou');
		$row		=	$LietouM -> getInfo(array('uid'=>$this->uid),array('utype'=>'user'));
		if($row['job']){
			$job	=	@explode(",",$row['job']);
			foreach ($job as $v){
				$jobname[]	=	$CacheList['ltjob_name'][$v];
			}
		}
		$jobname	=	@implode(",",$jobname);
		$this->yunset("jobname",$jobname);
		if($row['hy']){
			$hy=@explode(",",$row['hy']);
			foreach ($hy as $v){
				$hyname[]	=	$CacheList['lthy_name'][$v];
			}
		}
		$hyname		=	@implode(",",$hyname);
		$this->yunset("hyname",$hyname);
		$this->yunset("row",$row);
	    if($_POST['submit']){
			if($_POST['realname']==''){
				$data['msg']	=	'请输入真实姓名！';
			}elseif($_POST['com_name']==''){
				$data['msg']	=	'请输入所在公司！';
			}elseif($_POST['phone']==''){
				$data['msg']	=	'请输入公司座机！';
			}elseif($_POST['email']&&CheckRegEmail($_POST['email'])==false){
				$data['msg']	=	'联系邮箱格式错误！';
			}elseif($_POST['moblie']==''){
				$data['msg']	=	'请输入手机号码！';
			}elseif($_POST['moblie']&&CheckMobile($_POST['moblie'])==false){
				$data['msg']	=	'手机号码格式错误！';
			}elseif($_POST['cityid']==''){
				$data['msg']	=	'请输入所在地！';
			}elseif($_POST['exp']==''){
				$data['msg']	=	'请选择工作经验！';
			}elseif($_POST['title']==''){
				$data['msg']	=	'请选择目前头衔！';
			}elseif($_POST['qw_hy']==''){
				$data['msg']	=	'请选择擅长行业！';
			}elseif($_POST['job']==''){
				$data['msg']	=	'请选择擅长职位！';
			}elseif($_POST['content']==''){
				$data['msg']	=	'请输入顾问介绍！';
			}
			if($data['msg']==""){
				
				$lt		=			$this -> ltInfo;
				if($lt){
					$rstaus     =   $lt['r_status'];
				}else{
					$rstaus		=	$this->config['lt_status'];
				}
	
			    $mData   =  array(
			        'email'			=>	$_POST['email'],
			        'moblie'		=>	$_POST['moblie'],
			    );
			    
			    $ltData  =  array(
			        'realname'		=>	$_POST['realname'],
			        'com_name'		=>	$_POST['com_name'],
			        'phone'			=>	$_POST['phone'],
			        'email'			=>	$_POST['email'],
			        'moblie'		=>	$_POST['moblie'],
			        'provinceid'	=>	$_POST['provinceid'],
			        'cityid'		=>	$_POST['cityid'],
			        'three_cityid'	=>	$_POST['three_cityid'],
			        'exp'			=>	$_POST['exp'],
			        'title'			=>	$_POST['title'],
			        'hy'			=>	$_POST['qw_hy'],
			        'job'			=>	$_POST['job'],
			        'content'		=>	$_POST['content'],
			        'client'		=>	$_POST['client'],
			    );
			    if(!$this -> ltInfo['uid']){
					$userinfoM    =   $this->MODEL("userinfo");
					$userinfoM -> activUser($this->uid,3);
				}
			    $return       =  $LietouM -> upLtInfo(array('uid'=>$this->uid),array('mData'=>$mData,'ltData'=>$ltData,'utype'=>'user'));
          $data['msg']  =  $return['msg'];
         if($return['url']){
            $data['url']  =  'index.php';//当修改成功 跳转到这个链接
          }else{
            $data['url']='';//防止在保存数据 出现座机存在或者其他存在，跳转到首页
          }
			}
			echo json_encode($data);die;
		}
		$backurl	=	Url('wap',array('c'=>'set'),'member');
		$this->yunset('backurl',$backurl);
		$this->yunset('header_title',"基本资料");
		$this->waptpl('info');
	}
	//上传头像
	function uppic_action(){
		$LietouM	=	$this -> MODEL('lietou');
		if($_POST['submit']){

			if(!$this -> ltInfo['uid']){
				$userinfoM    =   $this->MODEL("userinfo");
				$userinfoM -> activUser($this->uid,3);
			}
			$return   =  $LietouM -> upLogo(array('uid'=>$this->uid),array('utype'=>'user','base'=>$_POST['uimage']));

			$this->layer_msg($return['msg'],$return['errcode']);
		}else{
			$row	=	$LietouM -> getInfo(array('uid'=>$this->uid),array('utype'=>'user'));
			$this->yunset("row",$row);	
		}
		$backurl	=	Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		
		$this->yunset('header_title',"上传头像");
		$this->waptpl('uppic');
	}
	
	//充值
	function pay_action(){
	    
	    $orderM		=	$this	->	MODEL('companyorder');
	    $paytype	=	array(
	        'wxpay'		=>	$this->config['wxpay']=='1' ? '1' :	'',
	        'alipay'	=>	$this->config['alipay']=='1' && $this->config['alipaytype']=='1' ? '1' : ''
	    );
	    
	    $couponM		=	$this	->	MODEL('coupon');
	    $coupons		=	$couponM->	getCouponList(array(
	        'uid'			=>	$this->uid,
	        'validity'		=>	array('>',time()),
	        'status'		=>	'1'
	    ));
	    
	    if($paytype){
	        $this -> yunset("paytype",$paytype);
	        $this -> yunset("js_def",4);
	    }else{
	        $data['msg']	=	"暂未开通手机支付，请移步至电脑端充值！";
	        $data['url']	=	$_SERVER['HTTP_REFERER'];
	        $this -> yunset("layer",$data);
	    }
	    $nopayorder	=	$orderM	->	getCompanyOrderNum(array('uid'=>$this->uid,'usertype' => $this->usertype,'order_state'=>'1'));
	    $this -> yunset('nopayorder',$nopayorder);
	    $this -> yunset("coupons",$coupons);
	    $this -> yunset($this->MODEL('cache')->GetCache(array('integralclass')));
	    $this -> yunset('header_title',"充值".$this->config['integral_pricename']);
	    $this -> waptpl('pay');
	}
	/**
	 * 充值、购买会员、购买增值包生成订单
	 */
	function dingdan_action()
	{
	    
	    $rdata['price']			=  $_POST['price'];
	    $rdata['comvip']		=  $_POST['comvip'];
	    $rdata['comservice']	=  $_POST['comservice'];
	    $rdata['dkjf']			=  $_POST['dkjf'];
	    $rdata['price_int']		=  $_POST['price_int'];
	    $rdata['integralid']	=  $_POST['integralid'];
	    $rdata['coupon']		=  $_POST['coupon'];
	    $rdata['uid']			=  $this->uid;
	    $rdata['usertype']		=  $this->usertype;
	    $rdata['did']			=  $this->userdid;
	    $rdata['paytype']	    =  $_POST['paytype'] == 'wxpay' ? 'wxh5' : $_POST['paytype'];
	    $rdata['type']		    =  'wap';
	    $orderM	 =  $this	->	MODEL('companyorder');
	    $return	 =  $orderM	->	addComOrder($rdata);
	    
	    //微信支付、支付宝支付，跳转到相应的链接
	    if($return['errcode'] == 9 && !empty($return['url'])){
	        
	        header('Location: '.$return['url']);exit();
	    }else{
	        $this->yunset("layer",$return);
	    }
	    
	    $backurl  =  Url('wap',array(),'member');
	    $this -> yunset('backurl',$backurl);
	    $this -> yunset('headertitle','订单');
	    $this -> waptpl('pay');
	}
	/**
	 *  微信支付
	 */
	function wxpay_action(){
	    
	    $comorderM	=	$this->MODEL('companyorder');
	    
	    $data['orderId']  =  (int)$_GET['id'];
	    
	    $return  =  $comorderM->payComOrderByWXWAP($data);
	    
	    if (!empty($return['newOrderId'])){
	        
	        header('Location: index.php?c=wxpay&type=wxh5&id='.$return['newOrderId']);
	        
	        exit();
	    }
	    
	    if($_GET['id']){
	        
	        if($return['header']){
	            
	            header($return['header']);
	            
	            exit();
	        }elseif($return['msg']){
	            
	            $this->yunset("layer",$return);
	            
	        }else{
	            
	            $this->yunset('jsApiParameters',$return['jsApiParameters']);
	            
	        }
	        
	        $this->yunset('id',(int)$_GET['id']);
	        $this -> yunset('headertitle','微信支付');
	        $this->waptpl('wxpay');
	        
	    }else{
	        $this->ACT_msg_wap(Url('wap'),'请求参数异常');
	    }
	}
	/**
	 * 订单确认
	 */
	function payment_action(){
		$orderM		=	$this->MODEL('companyorder');
		$couponM	=	$this->MODEL('coupon');
		
		if($this->config['wxpay']=='1'){
			$paytype['wxpay']	=	'1';
		}
		
		if($this->config['alipay']=='1' &&  $this->config['alipaytype']=='1'){
			$paytype['alipay']	=	'1';
		}
		if($paytype){
			if($_GET['id']){
				$order	=	$orderM->getInfo(array('id'=>(int)$_GET['id']));
				if(empty($order)){ 
					$this->ACT_msg_wap($_SERVER['HTTP_REFERER'],"订单不存在！",2,5); 
				}elseif($order['order_state']!='1'){ 
					header("Location:index.php?c=paylog"); 
				}else{
					$this->yunset("order",$order);
				}
			}
			
			$this->yunset("paytype",$paytype);
			
		}else{
			
			$data['msg']	=	"暂未开通手机支付，请移步至电脑端充值！";
			$data['url']	=	$_SERVER['HTTP_REFERER'];
			$this->yunset("layer",$data);
				
		}
	
		$this->yunset('header_title',"订单确认");
		$this->waptpl('payment');
	}
	//修改密码
	function passwd_action(){
		 
		$backurl=Url('wap',array('c'=>'set'),'member');
		$this->yunset('backurl',$backurl);
		
		$this->yunset('header_title',"安全密码");
		$this->waptpl('passwd');
	}
	//职位管理
	function job_action(){
		
		$jobM = $this -> MODEL('lietoujob');
		
		$rows = $jobM -> getList(array('uid'=>$this->uid, 'usertype' => $this->usertype, 'orderby'=>'`lastupdate`'));
		
		$zp=$sh=$xj=0;
		if(is_array($rows)){
		    foreach($rows as $value){
		        if($value['status']==1 && $value['zp_status']==0){
		            $zp +=1;
		        }
		        if($value['status']!='1'){
		            $sh +=1;
		        }
		        if($value['zp_status']=='1'){
		            $xj +=1;
		        }
		    }
		}
		$this->yunset(array('zp'=>$zp,'sh'=>$sh,'xj'=>$xj));
		$this->yunset("rows",$rows);
		$this->lt_satic();
 
		$CacheList=$this->MODEL('cache')->GetCache(array('lt','city'));
		$this->yunset($CacheList);
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		
		$this->yunset('header_title',"职位管理");
		$this->waptpl('job');
	}
	//删除职位
	function jobdel_action(){
		if($_GET['id']){
			$del	=	(int)$_GET['id'];
			
			$logM 	=	$this -> MODEL('log');
			
			$ltjobM =	$this -> MODEL('lietoujob');
			
			$did	=	$ltjobM -> delLietouJob($del,array('uid'=>$this->uid));
			
			if($did){
				
				$logM -> addMemberLog($this->uid,$this->usertype,"删除猎头职位",10,3);//会员日志
				
				$this -> waplayer_msg('删除成功！');
				
			}else{
				
				$this -> waplayer_msg('删除失败！');
				
			}
		}
	}

	
	function getserver_action()
    {
	    
        $paytype   =   array();

        if ($this->config['wxpay'] == '1') {
            $paytype['wxpay'] = '1';
        }
        
        if ($this->config['alipay'] == '1' && $this->config['alipaytype'] == '1') {
            $paytype['alipay'] = '1';
        }
        
        if ($paytype) {
            $this->yunset('paytype', $paytype);
        }

        $jobid  =   intval($_GET['id']);
        $server =   intval($_GET['server']);

        $statisM    =   $this->MODEL('statis');

        $statis     =   $statisM->getInfo($this->uid, array('usertype' => '3'));

        $this->yunset('statis', $statis);

        $ltjobM     =   $this->MODEL('lietoujob');

        $info       =   $ltjobM->getInfo(array('uid' => $this->uid, 'id' => $jobid), array('field' => "`id`"));

        $this->yunset('info', $info);

        $backurl    =   Url('wap', array(), 'member');
        $this->yunset('backurl', $backurl);

        $server     =   intval($_GET['server']);
        
        switch ($server) {
            case 1:
                $header_title = "刷新职位";
                break;
            case 7:
                $header_title = "简历下载";
                
                $resumeM    =   $this->MODEL('resume');
                $id         =   intval($_GET['id']);
                $price      =   $resumeM -> setDayprice($id);
                $this->yunset('resume_price', $price);
                
                break;
            case 8:
                $header_title = "发布职位";
                break;
        }
        $this->yunset('header_title', $header_title);
        
        $this->waptpl('getserver');
    }

	/**
	 * @desc 下单购买
	 */
    function getOrder_action(){
        
        $_POST				=	$this -> post_trim($_POST);
        
        if (empty($_POST)) {
            echo json_encode(array('error' => 1, 'msg' => '参数错误，请重试！'));die();
        }
        if ($_POST['paytype'] == 'wxpay'){
            $_POST['paytype'] = 'wxh5';
        }
        
        $data				=	$_POST;
        $data['uid']		=   $this -> uid;
        $data['username']	=   $this -> username;
        $data['usertype']	=   $this -> usertype;
        $data['did']		=   $this -> userdid;
        
        
        $compayM            =   $this->MODEL('compay');
        $return				=	$compayM->orderBuy($data);
        
        if($return['error'] == 0){
            $dingdan	=	$return['orderid'];
            $price		=	$return['order_price'];
            $id			=	$return['id'];
            
            //多种支付方式并存 进行选择
            if($_POST['paytype']=='alipay'){
                
                $url = $this->config['sy_weburl'].'/api/wapalipay/alipayto.php?dingdan='.$dingdan.'&dingdanname='.$dingdan.'&alimoney='.$price;
            }elseif($_POST['paytype']=='wxh5'){
                
                $url='index.php?c=wxpay&type=wxh5&id='.$id;
            }
            echo json_encode(array(
                'error' => 0,
                'url'   => $url,
                'msg'   =>  '下单成功，请付款！'
            ));
            
        }else{
            echo json_encode($return);
        }
    }


	/**
	 * @desc 积分抵扣，购买
	 */
	function dkzf_action()
    {
        $data				=	$_POST;
        $data['uid']		=	$this	->	uid;
        $data['username']	=	$this	->	username;
        $data['usertype']	=	$this	->	usertype;
        
        $jfdkM				=	$this	->	MODEL('jfdk');
        $return				=	$jfdkM	->	dkBuy($data);
        echo json_encode($return);
    }
	
	function jobset_action(){
		if($_GET['id']){//设置猎头招聘状态
			$where['id']	=	(int)$_GET['id'];
			
			$where['uid']	=	$this->uid;
			
			$logM 	=	$this -> MODEL('log');
			
			$ltjobM =	$this -> MODEL('lietoujob');
			
			$did	=	$ltjobM -> upInfo($where,array("zp_status"=>(int)$_GET['status']));
			
			if($did){
				
				$logM -> addMemberLog($this->uid,$this->usertype,"设置猎头职位招聘状态",10,2);//会员日志
				
				$this->waplayer_msg('操作成功！');
				
			}else{
				
				$this->waplayer_msg('操作失败！');
				
			}
		}
		 
	}

 	function ajax_refresh_job_action() {
		
		if(!isset($_POST['jobid'])){
			exit;
		}

		$jobid	=	$_POST['jobid'];
		
		$statis =	$this -> lt_satic();
		
		if($statis['rating_type'] == '2'){
		    
		    $companyM =   $this->MODEL('company');
		    
		    $result   =   $companyM->comVipDayActionCheck('refreshjob',$this->uid);
		    
		    if($result['status']!=1){
		        
		        echo json_encode($result);
		        exit;
		    }
		}
		
 		$comtcM  =   $this -> MODEL('comtc');
		
 		$_POST['uid']         =	  $this->uid;
 		$_POST['usertype']    =	  $this->usertype;
 		
 		$return	 =   $comtcM -> ltRefreshJob($_POST);
		
 		if($return['status']==1){//职位刷新成功
			
			$data['msg']	=	$return['msg'];
			$data['error']	=	1;
		}else if($return['status']==2){//套餐不足，金额消费
			
			$data['msg']	=	$return['msg'];
			$data['error']	=	2;
		}else{
			//职位刷新失败
			if($return['url']){
				$data['url']=	$return['url'];
			}
			$data['msg']	=	$return['msg'];
			$data['error']	=	3;
		}
		echo json_encode($data);exit;
	}

	//会员统计信息调用
	function lt_satic(){
		$statisM  =	  $this -> MODEL('statis');
		$statis	  =	  $statisM -> vipLtOver($this->uid);
		
		$this->yunset("statis",$statis); 
		$this->yunset("addltjobnum",$statis['addltjobnum']);

		return $statis;
	}
	
	function jobCheck_action(){
	    
	    $jobM   =   $this->MODEL('job');
	    $statisM=   $this->MODEL('statis');
	    
	    $uid    =   $this->uid;
	    
	    $statis =   $statisM -> getInfo($uid, array('usertype' => 3, 'field' => '`integral`'));
	    
	    $result =   $jobM -> getAddJobNeedLtInfo($uid, 1, 'wap');
	    
	    $ltSingle	=	@explode(',', $this->config['lt_single_can']);

	    $single	=	in_array('issuejob', $ltSingle)? '1' : '2';

	    $return =   array(
	        'singlecan'	=>	$single,
	        'msgList'   =>  $result['wap'],
	        'integral'  =>  (int)$statis['integral']
		);
	    
	    echo json_encode($return);
	    
	    die();
	    
	}
	
	//添加职位
	function jobadd_action(){
		
		$CacheList=$this->MODEL('cache')->GetCache(array('lt','lthy','ltjob','city','com','hy'));
		$this->yunset($CacheList);
		$ltM	=	$this -> MODEL('lietou');
		$comM	=	$this -> MODEL('company');
		$ltjobM	=	$this -> MODEL('lietoujob');
		
		$rows	=	$comM -> getCertList(array('uid'=>$this->uid,'groupby'=>'type','orderby'=>'id,desc'));
		
		foreach($rows as $v){
			
			$row[$v["type"]]=$v;
		}
		$info	=	$ltM -> getInfo(array('uid'=>$this->uid),array('field'=>'`com_name`,`r_status`,`email_status`,`moblie_status`,`yyzz_status`'));
		if($info['com_name']==''){
			$data['msg']	=	"请先完善基本资料！";
			$data['url']	=	'index.php?c=info';
			$this->yunset("layer",$data);
		}
    	$this->yunset("info",$info);
		$statics 	= 	$this->lt_satic();
		if(!$_GET['id']){
			if($statics['addltjobnum']==0){ 
				$data['msg']	=	"您的会员已到期！";
				$data['url']	=	'index.php?c=rating';
				$this->yunset("layer",$data);
			}
			if($statics['addltjobnum']==2){ 
				if($this->config['integral_job']!='0'){
					$data['msg']	=	"您的套餐已用完！";
					$data['url']	=	'index.php?c=rating';
					$this->yunset("layer",$data);
				}else{
					$ltM -> upStatis(array('uid'=>$this->uid),array('job_num'=>'1'));
				}
			}
		}

		$msg=array();
		$isallow_addjob="1";
		if($this->config['lt_enforce_emailcert']=="1"){
			if($row['1']['status']!="1"){
				$isallow_addjob="0";
				$msg[]="邮箱认证";
			}
		}
		if($this->config['lt_enforce_mobilecert']=="1"){
			if($row['2']['status']!="1"){
				$isallow_addjob="0";
				$msg[]="手机认证";
			}
		}
		if($this->config['lt_enforce_licensecert']=="1"){

            $comM   =   $this->MODEL('company');
            $cert   =   $comM -> getCertInfo(array('uid'=>$this->uid,'type'=>4), array('field' => 'uid,status'));

            if($row['4']['status']!="1" && (empty($cert) || $cert['status'] == 2)){
				$isallow_addjob="0";
				$msg[]="职业资格认证";
			}
		}
		$data['url']='index.php?c=set';
		if($isallow_addjob=="0"){
			$data['msg']="请先完成".implode(",",$msg)."！";
			$this->yunset("layer",$data);
		}
		
		if($_GET['id']){
			$row	=	$ltjobM -> getInfo(array('id'=>(int)$_GET['id'],'uid'=>$this->uid));
		}else{
			$row	=	$ltM -> getInfo(array('uid'=>$this->uid),array('field'=>'com_name,r_status'));
		}
		if($_GET['id']){
			
			
			if($row['id']){
				if($row['job']){
					$job=@explode(",",$row['job']);
					foreach ($job as $v){
						$jobname[]=$CacheList['ltjob_name'][$v];
					}
				}
				$jobname=@implode(",",$jobname);
				$this->yunset("jobname",$jobname);
				if($row['qw_hy']){
					$hy=@explode(",",$row['qw_hy']);
					foreach ($hy as $v){
						$hyname[]=$CacheList['lthy_name'][$v];
					}
				}
				 
				$hyname=@implode(",",$hyname);
				$this->yunset("hyname",$hyname);
				
			}else{
				$data['msg']='职位不存在！';
				$data['url']='index.php?c=job&s=1';
				$this->yunset("layer",$data);
			}
		}
		if($_POST['submit']){

			$_POST=$this->post_trim($_POST);
			$post	= 	array(
				'job_name'    	=>	$_POST['job_name'],
				
				'jobone'       	=>	$_POST['jobone'],
				'jobtwo'       	=>	$_POST['jobtwo'],
				
				'department'   	=>	$_POST['department'],
				'report'       	=>	$_POST['report'],

				'provinceid'  	=>	$_POST['provinceid'],
				'cityid'       	=>	$_POST['cityid'],
				'three_cityid'	=>	$_POST['three_cityid'],

				'minsalary'  	=>	$_POST['minsalary'],
				'maxsalary'    	=>	$_POST['maxsalary'],

				'constitute'   	=>	pylode(',',$_POST['constitute']),
				'job_desc'    	=>	$_POST['job_desc'],
				'age'         	=>	$_POST['age'],
				'sex'         	=>	$_POST['sex'],
				'exp'         	=>	$_POST['exp'],
				'edu'         	=>	$_POST['edu'],
				'eligible'    	=>	$_POST['eligible'],
				'welfare'      	=>	pylode(',',$_POST['welfare']),
				'language'     	=>	pylode(',',$_POST['language']),
				'rebates'     	=>	$_POST['rebates'],
				'other'      	=>	$_POST['other'],

				'com_name'		=>	$_POST['com_name'],
				'real_name'		=>	$_POST['real_name'],
				'pr'			=>	$_POST['pr'],
				'hy'			=>	$_POST['hy'],
				'mun'			=>	$_POST['mun'],
				'desc'			=>	$_POST['desc'],
				'r_status'      =>	$info['r_status'],
				'lastupdate'  	=>	time(),
				'uid'       	=>	$this->uid,
				'usertype'		=>	$this->usertype,
				'did'			=>	$this->userdid
			);
            $data	=	array(
				'post'	=>	$post,
				'id'	=>	(int)$_POST['id']
			);

			$return	=	$ltjobM->addLtJobInfo($data);

          	if($return['errcode']==9){
				  $return['url']='index.php?c=job';
			}
			echo json_encode($return);die;
		}
		
		$this->yunset("row",$row);
		$this->yunset('header_title',"职位发布");
		$this->waptpl('jobadd');
	}
	
	/**
	 * @desc 认证管理
	 */
	function binding_action(){

	    $comM  =   $this -> MODEL('company');
	    
	    //手机绑定
	    if($_POST['moblie']){
		    
		    $data     =   array(
		        
		        'uid'         =>	$this->uid,
		        
		        'usertype'    =>	$this->usertype,
		        
		        'moblie'      =>	$_POST['moblie']
		    );
		    
		    $errCode  =   $comM -> upCertInfo(array('uid'=>$this->uid, 'check2'=>$_POST['code']), array('status'=>'1'), $data);
			 
		    echo $errCode; die;
		}

	    
	    //解除绑定
		if($_GET['type']){
		    
		    $return   =	$comM -> delBd($this->uid, array('type'=>$_GET['type'], 'usertype'=> intval($this->usertype)));
		    
		    $this->waplayer_msg($return['msg']);
		    
		}
		
		$UserinfoM    =   $this -> MODEL('userinfo');
		
		$member       =   $UserinfoM -> getInfo(array('uid'=> $this->uid));
		
		$this -> yunset('member', $member);
		
		$ltM          =   $this -> MODEL('lietou');
		
		$ltinfo       =   $ltM -> getInfo(array('uid' => $this -> uid));
		
		$this         ->  yunset('lt', $ltinfo);
		
		$cert         =   $comM -> getCertInfo(array('uid' => $this -> uid, 'type' => '4'));
		
		$this         ->  yunset('cert', $cert);
		
		$backurl      =   Url('wap',array('c'=>'set'),'member');
		
		$this         ->  yunset('backurl',$backurl);
		
		
		$this->yunset('header_title', '社交账号绑定');
		$this->waptpl('binding');
	}
	
	/**
	 * @desc 手机、邮箱绑定
	 */
	function bindingbox_action(){
	    
	    $UserinfoM =   $this -> MODEL('userinfo');
	    
	    $member    =   $UserinfoM -> getInfo(array('uid'=>intval($this -> uid)));
	    
	    $this      ->  yunset('member', $member);
	    
	    $backurl   =   Url('wap', array('c' => 'set'), 'member');
	    
 		// $this -> yunset('backurl',$backurl);
		
		if($_GET['type'] == 'email'){
		    
			$this -> yunset('header_title' , '邮箱绑定');
			
		}else if($_GET['type']=='moblie'){
		    
			$this->yunset('header_title','手机认证');
			
		}
		
		$this->waptpl('bindingbox');
	}
	
	/**
	 * @desc 猎头职业资格认证
	 */
	function ltcert_action(){
	    
	    $uid       =   intval($this -> uid);
	    
	    $ltM       =   $this -> MODEL('lietou');
	    
	    $ltinfo    =   $ltM -> getInfo(array('uid' => $uid));
	    
	    $this      ->  yunset('ltinfo', $ltinfo);
        
	    $comM      =   $this -> MODEL('company');
	    
	    $cert      =   $comM -> getCertInfo(array('uid' => $uid, 'type' => '4'), array('field' => '`check`, `status`, `statusbody`,`type`,`ctime`'));

	    $this      ->  yunset('cert',  $cert);
	    
	    
		if($_POST['submit']){
		    
		    $usertype =   intval($this->usertype);
		    
		    $data     =   array(
		        
		        'msg' =>  ''
		        
		    ) ;

		    if($ltinfo['r_status']==0){
		        
		        $status	=	$ltinfo['r_status'];
		        
		    }else{
		        
		        $status	=	$this -> config['lt_cert_status'] == '1' ? 0 : 1;
		        
		    }
		    
		    $upData   =   array(
		        
		        'status'     => $status,
		        
		        'ctime'      => time()
		        
		    );
		    if($_POST['preview']){
		        
		        $upData['base']	 =	 $_POST['preview'];
		        
		    } else{
		        
		        $data['msg']     =   '请上传新的职业资格证书！';
		        
		    }
		    
			if($data['msg'] == ''){
			    if (!empty($cert) && is_array($cert) && $cert['ctime']) {
			        
			        $err   =   $comM -> upCertInfo(array('id'=>intval($cert['id']), 'uid' => $uid), $upData, array('yyzz' => '1', 'usertype' => $usertype));
			        
			    }else{
			        
			        $postData    =   array(
			            
			            'uid'        =>  $uid,
			            'type'       =>  '4',
			            'step'       =>  '1',
			            'did'        =>  $this ->userdid,
			            'usertype'   =>  $usertype
			            
			        );
			        
			        $postData    =   array_merge($postData, $upData);
			        
			        $err         =   $comM -> addCertInfo($postData);
			        
			    }
			    
			    $data['msg']    =   $err['msg'];
			    $data['url']    =   'index.php?c=ltcert';
			    
			}else{
			    
				$data['msg']    =   $data['msg'];
				$data['url']    =   'index.php?c=ltcert';
				
			}
			
			$this->yunset("layer",$data);
		}
		
		$backurl  =   Url('wap',array('c'=>'set'),'member');
		$this     ->  yunset('backurl',$backurl);
		$this     ->  yunset('header_title','资格证书');
		$this     ->  waptpl('ltcert');
		
	}
	
	//修改用户名
	function setname_action(){
		$UserinfoM=$this->MODEL('userinfo');
		if($_POST['username']){
			$data	=	array(
				'username'	=>  trim($_POST['username']),
				'password'	=>  trim($_POST['password']),
				'uid'		=>  intval($this->uid),
				'usertype'	=>  intval($this->usertype),
				'restname'	=>  '1'
			);
			if (!empty($data['username'])) {
				$err=$UserinfoM  -> saveUserName($data);
				if($err['errcode'] != '1'){
	                
	                echo $err['msg'];
	                die();
	                
	            }else{
	                $this->cookie->unset_cookie();
	                echo 1;
	                die();
	                
	            }
			}
		}
		$backurl=Url('wap',array('c'=>'set'),'member');
		$this->yunset('backurl',$backurl);
		
		$this->yunset('header_title',"修改用户名");
		$this->waptpl('setname');
	}

	//浏览过的简历
	function look_resume_action()
	{
		$where['com_id']      =  $this -> uid;
		$where['usertype']    =  3;
		$where['com_status']  =  0;
		$urlarr['c']	=	$_GET['c'];
		$urlarr['page']	=	'{{page}}';
	    $pageurl		=	Url('wap',$urlarr,'member');

	    $pageM			=	$this   ->  MODEL('page');
	    $pages			=	$pageM  ->  pageList('look_resume',$where,$pageurl,$_GET['page']);
	    
	    if($pages['total'] > 0){
	        $where['orderby']		=	'datetime';
	        $where['limit']			=	$pages['limit'];
	        
	        $lookresumeM  =  $this -> MODEL('lookresume');
	        
	        $List   =  $lookresumeM  ->  getList($where,array('uid'=>$this->uid, 'usertype' => $this->usertype));
			$this->yunset("list",$List['list']);
	    }
		
		$backurl=Url('wap',array('c'=>'resumecolumn'),'member');
		$this->yunset('backurl',$backurl);
		
		$this->yunset('header_title',"浏览的简历");
		$this->waptpl('look_resume');
	}
	function lookdel_action(){
		if($_GET['del']){
			$id				=  intval($_GET['del']);
			$lookresumeM    =  $this->MODEL('lookresume');
			$return         =  $lookresumeM -> delInfo(array('id'=>$id,'uid'=>$this->uid,'usertype'=>3));
			
			$this -> waplayer_msg($return['msg']);
		}
	}
	
	//下载过的简历
	function down_resume_action(){
		$where['comid']				=  $this -> uid;
		$where['usertype']			=  $this -> usertype;
		$where['isdel']				=  9;
	    $urlarr['c']	=	$_GET['c'];
		$urlarr['page']	=	'{{page}}';
	    $pageurl		=	Url('wap',$urlarr,'member');

	    $pageM			=	$this   ->  MODEL('page');
	    $pages			=	$pageM  ->  pageList('down_resume',$where,$pageurl,$_GET['page']);
	    
	    if($pages['total'] > 0){
	        $where['orderby']		=	'id';
	        $where['limit']			=	$pages['limit'];
	        
	        $downM  =  $this -> MODEL('downresume');
	        
	        $List   =  $downM  ->  getList($where,array('utype'=>'lietou'));
			$this->yunset("list",$List['list']);
	    }
		
		$backurl=Url('wap',array('c'=>'resumecolumn'),'member');
		$this->yunset('backurl',$backurl);
		
		$this->yunset('header_title',"下载的简历");
		$this->waptpl('down_resume');
	}
	function downdel_action(){
		if($_GET['del']){
			$id			=  intval($_GET['del']);
			$downM		=  $this->MODEL('downresume');
			$return		=  $downM -> delInfo($id,array('uid'=>$this->uid,'usertype'=>$this->usertype));
			$this -> waplayer_msg($return['msg']);
 		}
	}
	
	//应聘来的简历
	function yp_resume_action(){
        $JobM       	 =   $this -> MODEL('job');
		
        $where['com_id'] =  $this -> uid;
        $where['isdel']  =  9;
        $where['type'] =  3;	
        //分页链接
        $urlarr['c']	=	$_GET['c'];
        $urlarr['page']	=	'{{page}}';
        $pageurl		=	Url('wap',$urlarr,'member');

        $pageM			=	$this  -> MODEL('page');
        $pages			=	$pageM -> pageList('userid_job',$where,$pageurl,$_GET['page']);

        if($pages['total'] > 0){
			
            if($_GET['order']){
                
                $where['orderby']		=	$_GET['t'].','.$_GET['order'];
                $urlarr['order']		=	$_GET['order'];
                $urlarr['t']			=	$_GET['t'];
                
            }else{
                
                $where['orderby']		=	array('id,desc');
            }
            
            $where['limit']				=	$pages['limit'];
            
            $rows    =   $JobM -> getSqJobList($where,array('utype'=>'lietou'));
			$this->yunset("list",$rows);
        }
		if (!isset($_GET['chat'])){
		    $backurl=Url('wap',array('c'=>'resumecolumn'),'member');
		    $this->yunset('backurl',$backurl);
		}
		
		$this->yunset('header_title',"应聘简历");
		$this->waptpl('yp_resume');
	}
	function ypdel_action(){
		if($_GET['del']){
			$JobM   =   $this -> MODEL('job');
			$id =   intval($_GET['del']);
			$arr    =   $JobM -> delSqJob($id,array('utype'=>'lietou','uid'=>$this->uid,'usertype'=>$this->usertype));
			
			$this ->  waplayer_msg($arr['msg']);
 		}
	}
	//委托来的简历
	function entrust_resume_action(){
		$entrustM			=   $this -> MODEL('entrust');
		
		$where['lt_uid']	=  $this -> uid;
		
		 //分页链接
		$urlarr['c']	=	$_GET['c'];
        $urlarr['page']	=	'{{page}}';
        $pageurl		=	Url('wap',$urlarr,'member');

        $pageM			=	$this  -> MODEL('page');
        $pages			=	$pageM -> pageList('entrust',$where,$pageurl,$_GET['page']);

        if($pages['total'] > 0){
			
            if($_GET['order']){
                
                $where['orderby']		=	$_GET['t'].','.$_GET['order'];
                $urlarr['order']		=	$_GET['order'];
                $urlarr['t']			=	$_GET['t'];
                
            }else{
                
                $where['orderby']		=	array('id,desc');
            }
            
            $where['limit']				=	$pages['limit'];
            
            $rows    =   $entrustM -> getList($where);
			$this->yunset("list",$rows);
        }
		
		$entrustM -> upInfo(array('remind_status'=>1),array('lt_uid'=>$this->uid,'remind_status'=>0));
		
		if (!isset($_GET['chat'])){
		    $backurl=Url('wap',array('c'=>'resumecolumn'),'member');
		    $this->yunset('backurl',$backurl);
		}
		
		$this->yunset('header_title',"委托简历");
		$this->waptpl('entrust_resume');
	}
	function entrustdel_action(){
		if($_GET['del']){
			$entrustM	=   $this -> MODEL('entrust');
			$id 		=   intval($_GET['del']);
			$arr    	=   $entrustM -> delInfo($id,array('uid'=>$this->uid,'usertype'=>$this->usertype));
			
			$this ->  waplayer_msg($arr['msg']);
		}
	}
	
	//兑换记录
	function reward_list_action(){
		$redeemM		=	$this->MODEL('redeem');
		$where['uid']	=	$this->uid;
		$where['usertype']    =	$this->usertype;
		//分页链接
		$urlarr['page']	=	'{{page}}';
		$urlarr['c']	=	"reward_list";
		$pageurl		=	Url('wap',$urlarr,'member');
		
		//提取分页
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('change',$where,$pageurl,$_GET['page']);
		
		//分页数大于0的情况下 执行列表查询
		if($pages['total'] > 0){
			
			$where['orderby']		=	'id,desc';
		    $where['limit']			=	$pages['limit'];
			
		    $List					=	$redeemM->getChangeList($where,array('utype'=>'wap'));
			
			$this->yunset("rows",$List['list']);
			
			$this->yunset(array('dh'=>$List['dh'],'sh'=>$List['sh'],'wtg'=>$List['wtg']));
		}
		$backurl	=	Url('wap',array('c'=>'integral','type'=>1),'member');
		$this->getStatis('reward_list');
		$this->yunset('backurl',$backurl);
		
		$this->yunset('header_title',"兑换记录");
		$this->waptpl('reward_list');
	}
	//去掉兑换
	function rewarddel_action(){
		if(empty($_GET['id'])){
			$this->waplayer_msg('参数异常！');
		}else{
			$redeemM	=	$this->MODEL('redeem');
		
			$data		=	array(
			    'member'=>'lietou',
			    'uid'=>$this->uid,
			    'id'=>(int)$_GET['id'],
			    'usertype'=>$this->usertype
			);
			$whereData = ['uid'=>$this->uid, 'id'=>(int)$_GET['id'], 'usertype'=>$this->usertype]; 

			$return		=	$redeemM->delChange($whereData, $data);
			
			$this->waplayer_msg($return['msg']);
		}
	}

    // 套餐模式
    function rating_action()
    {

        $orderM     =   $this -> MODEL('companyorder');
        $couponM    =   $this -> MODEL('coupon');
        $ratingM    =   $this -> MODEL('rating');

        $orderM		=	$this -> MODEL('companyorder');
        $coupons    =   $couponM -> getCouponList(array('uid' => $this->uid, 'validity' => array('>', time()), 'status' => '1'));
        $this->yunset('coupons', $coupons);

        $where      =   array(
            
            'category'      =>  '2',
            'display'       =>  '1',
            'service_price' =>  array('>', 0),
            'orderby'       =>  array('type,asc', 'sort,asc'),
            'type'          =>  $this->config['com_vip_type'] == 1 ? 2: 1
        );
        
        $rows       =   $ratingM -> getList($where, array('coupon' => 1, 'utype' => 'lietou'));
        
        if($rows&&is_array($rows)){
        
            foreach ($rows as $k=>$v){
            
                $rname=array();
                
                if($v['lt_job_num']>0){
                    $rname[]	=	'发布职位:'.$v['lt_job_num'].'份';
                }
                if($v['lt_breakjob_num']>0){
                    $rname[]	=	'刷新职位:'.$v['lt_breakjob_num'].'份';
                }
                if($v['lt_resume']>0){
                    $rname[]	=	'下载简历:'.$v['lt_resume'].'份';
                }
                
                if($this->config['com_vip_type'] == 1){
                    
                    $rows[$k]['rname'] 	=	'时间模式会员，有效时间内，发布职位、下载简历等操作不受限制！';
                }else{
                    
                    $rows[$k]['rname']	=	@implode('+',$rname);
                }
            }
        }
        $this->yunset('row', $rows['0']);
        $this->yunset('rows', $rows);
        
        $this->getStatis();
        $this->yunset('header_title', '会员套餐');

        $sy_only_price  =   @explode(',',$this->config['sy_only_price']);
        if (in_array('vip', $sy_only_price)){
            $this->yunset('meal_vip',1);
        }

        if ($this->config['com_vip_type'] == 2 || $this->config['com_vip_type'] == 0) {
            
            $this->waptpl('lietou_rating');
        } else if ($this->config['com_vip_type'] == 1) {
            
            $this->waptpl('lietou_time');
        }
    }

    // 套餐模式
    function time_action()
    {
        $orderM     =   $this->MODEL('companyorder');
        $couponM    =   $this->MODEL('coupon');
        $ratingM    =   $this->MODEL('rating');

        $orderM		=	$this -> MODEL('companyorder');
        
        $coupons    =   $couponM -> getCouponList(array('uid' => $this->uid, 'validity' => array('>', time()), 'status' => '1'));
        $this->yunset('coupons', $coupons);
        
        $where      =   array(
            
            'category'      =>  '2',
            'display'       =>  '1',
            'service_price' =>  array('>', 0),
            'orderby'       =>  array('type,asc', 'sort,asc'),
            'type'          =>  $this->config['com_vip_type'] == 2 ? 1: 2
        );
        
        $rows       =   $ratingM -> getList($where, array('coupon' => 1, 'utype' => 'lietou'));

        if($rows&&is_array($rows)){
            
            foreach ($rows as $k=>$v){
                
                $rname=array();
                
                if($v['lt_job_num']>0){
                    $rname[]	=	'发布职位:'.$v['lt_job_num'].'份';
                }
                if($v['lt_breakjob_num']>0){
                    $rname[]	=	'刷新职位:'.$v['lt_breakjob_num'].'份';
                }
                if($v['lt_resume']>0){
                    $rname[]	=	'下载简历:'.$v['lt_resume'].'份';
                }
                    
                $rows[$k]['rname']	=	@implode('+',$rname);
            }
        }
        
        $this->yunset('row', $rows['0']);
        $this->yunset('rows', $rows);

        $this->getStatis();

        $sy_only_price  =   @explode(',',$this->config['sy_only_price']);
        if (in_array('vip', $sy_only_price)){
            $this->yunset('meal_vip',1);
        }

        $this->yunset('header_title', "会员套餐");
        $this->waptpl('lietou_time');
    }
	
	function added_action()
    {
        $id         =   intval($_GET['id']);

        $StatisM    =   $this->MODEL('statis');
        $statis     =   $StatisM -> getInfo($this->uid, array('usertype' => 3)); // 查询会员信息

        if ($statis['rating_type'] == '2') {
            
            $this->ACT_msg_wap(Url('wap', array('c' => 'right'), 'member'), '时间会员无需购买增值服务！', 2, 5);
        }

		$orderM		=	$this -> MODEL('companyorder');
        $couponM    =   $this->MODEL('coupon');
        $coupons    =   $couponM->getCouponList(array('uid' => $this->uid,  'validity' => array('>', time()), 'status' => '1'));
        $ltM        =   $this->MODEL('lietou');
        $rows       =   $ltM -> getLtserviceList(array('display' => '1', 'orderby' => 'sort,desc'));

        if (empty($id)) {
            
            $row    =   $ltM -> getLtserviceInfo(array('display' => '1', 'orderby' => 'sort,desc'), array('field' => 'id'));
            $id     =   $row['id'];
        }
        
        $info       =   $ltM -> getLtservicedetailList(array('type' => $id, 'orderby' => 'sort,desc'));

        if ($statis) {
            
            $ratingM    =   $this->MODEL('rating');
            $discount   =   $ratingM -> getInfo(array('id' => $statis['rating']));
            $this->yunset('discount', $discount);
        }
        
        $this->yunset('statis', $statis);
        $this->yunset('coupons', $coupons);
        $this->yunset('info', $info);
        $this->yunset('p_once', $info[0]);

        $this->yunset('rows', $rows);

        $sy_only_price  =   @explode(',',$this->config['sy_only_price']);
        if (in_array('pack', $sy_only_price)){
            $this->yunset('meal_pack',1);
        }

        $this->yunset('header_title', "增值服务");
        $this->waptpl('added');
    }
	
	
	//账户管理
	function mypay_action(){
		
		$lietouM	=	$this->MODEL('lietou');
		$statis		=	$lietouM->getLtStatisInfo(array('uid'=>$this->uid));
		
		$statis['integral_format']	=	number_format($statis['integral']);
		$this->yunset("statis",$statis);
		
		$backurl	=	Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		
		
		$this->waptpl('mypay');
	}
	function give_rebates_action(){
		$lietouM			=	$this -> MODEL('lietou');
		
		$where['job_uid']	=	$this -> uid;
		
		$urlarr		=	array("c"=>$_GET['c'],"page"=>"{{page}}");
		
		$pageurl	=	Url('wap',$urlarr,'member');
		
		$pageM		=	$this  -> MODEL('page');
		
		$pages		=	$pageM -> pageList('rebates',$where,$pageurl,$_GET['page'],$this->config['sy_listnum']);
		
		if($pages['total'] > 0){
			if($_GET['order'])
			{
				$where['orderby']		=	$_GET['t'].','.$_GET['order'];
				$urlarr['order']		=	$_GET['order'];
				$urlarr['t']			=	$_GET['t'];
			}else{
				$where['orderby']		=	'id';
			}
			$where['limit']	=	$pages['limit'];
			
			$List	=	$lietouM -> getRebatesList($where,array('isjob'=>'yes'));
			
			$this->yunset("rows" , $List);
		}
		
		$backurl=Url('wap',array('c'=>'resumecolumn'),'member');
		$this->yunset('backurl',$backurl);
		
		
		$this->yunset('header_title',"推荐给我的人才");
		$this->waptpl('give_rebates');
	}
	function save_give_rebates_action(){
		if($_POST){
			$data['reply']		=	$_POST['reply'];
			
			$data['reply_time']	=	time();
			
			$data['status']		=	"1";
			
			$where['id']		=	(int)$_POST['id'];
			
			$where['job_uid']	=	$this->uid;
			
			$this -> MODEL('lietou') -> upRebates($data,$where);
			
			$this -> MODEL('log') -> addMemberLog($this->uid,$this->usertype,"回复推荐给我的返利",18,2);
			echo 1;die;
		}
	}	
	function rebates_set_action(){
		if($_POST['id']){
			$where['id']		=	(int)$_POST['id'];
			
			$where['job_uid']	=	$this->uid;
			
			$nid = $this -> MODEL('lietou') -> upRebates(array("status"=>intval($_POST['status'])),$where);
			
			echo 1;die;
		}
	}
	function my_rebates_action(){
		$lietouM		=	$this -> MODEL('lietou');
		
		$where['uid']	=	$this -> uid;
		
		$urlarr		=	array("c"=>$_GET['c'],"page"=>"{{page}}");
		
		$pageurl	=	Url('wap',$urlarr,'member');
		
		$pageM		=	$this -> MODEL('page');
		
		$pages		=	$pageM -> pageList('rebates',$where,$pageurl,$_GET['page'],$this->config['sy_listnum']);
		
		if($pages['total'] > 0){
			if($_GET['order'])
			{
				$where['orderby']		=	$_GET['t'].','.$_GET['order'];
				$urlarr['order']		=	$_GET['order'];
				$urlarr['t']			=	$_GET['t'];
			}else{
				$where['orderby']		=	'id';
			}
			$where['limit']	=	$pages['limit'];
			
			$List	=	$lietouM -> getRebatesList($where,array('isjob'=>'yes'));
			
			$this->yunset("rows" , $List);
			
		}
		
		$backurl=Url('wap',array('c'=>'resumecolumn'),'member');
		$this->yunset('backurl',$backurl);
		
		
		$this->yunset('header_title',"我推荐的悬赏");
		$this->waptpl('my_rebates');
	}
	function delrebate_action(){
		if($_GET['id']){
			$id			=	(int)$_GET['id'];
			if($_GET['type']==1){
				$type	=	2;//推荐给我的人才
			}else{
				$type	=	1;//我推荐的人才
			}
			$ltM		=	$this -> MODEL('lietou');
			$result		=	$ltM -> delRebates($id,array('uid'=>$this->uid,'usertype'=>$this->usertype,'type'=>$type));
			$this -> waplayer_msg($result['msg']);
		}
	}
	function rebateshow_action(){
		$lietouM	=	$this -> MODEL('lietou');
		$data		=	$lietouM -> getRebatesInfo(array('id'=>intval($_GET['id'])),array('type'=>$_GET['type'],'show'=>1));
		
		$this->yunset("resume",$data);
		
		if($_GET['type']){
			$backurl=Url('wap',array('c'=>'my_rebates'),'member');
		}else{
			$backurl=Url('wap',array('c'=>'give_rebates'),'member');
		}
		$this->yunset('backurl',$backurl);
		
		$this->yunset('header_title',"人才信息");
		
		$this->waptpl('rebateshow');
	}
	
	//订单管理
	function paylog_action(){
		include(CONFIG_PATH."db.data.php");
		$this->yunset("arr_data",$arr_data);
		
		$orderM					=	$this->MODEL('companyorder');
		
		$where['uid']			=	$this->uid;
		$where['usertype']		=	$this->usertype;
		$where['order_price']	=	array('>',0);
		
		//分页链接
		$urlarr['page']	=	'{{page}}';
		$urlarr['c']	=	"paylog";
		$pageurl		=	Url('wap',$urlarr,'member');
		
		//提取分页
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('company_order',$where,$pageurl,$_GET['page']);
		
		//分页数大于0的情况下 执行列表查询
		if($pages['total'] > 0){
			
			$where['orderby']	=	'order_time,desc';
		    $where['limit']		=	$pages['limit'];
			
			$List				=	$orderM->getList($where, array('utype'=>'lietou'));
			
			$this->yunset("rows",$List);
		}
		
		$this->yunset('header_title',"订单管理");
		$this->waptpl('paylog');
	}
	
	function delpaylog_action(){
		$orderM		=	$this->MODEL('companyorder');
		$invoiceM	=	$this->MODEL('invoice');
		$logM		=	$this->MODEL('log');
		
		if($this->usertype!='3' || $this->uid==''){
			
			$this->waplayer_msg('登录超时！');
			
		}else{
			
			$oid	=	$orderM->del((int)$_GET['id'],array('uid'=>$this->uid));
			
			$return	=	$invoiceM->del('',array('oid'=>(int)$_GET['id'],'uid'=>$this->uid));
			
			if($oid){
				$logM->member_log("取消订单",88,3);
				
				$this->waplayer_msg('取消成功！');
			}else{
				
				$this->waplayer_msg('取消失败！');
			}
		}
		
	}
	
	function consume_action(){
		include(CONFIG_PATH."db.data.php");
		$orderM				=	$this->MODEL('companyorder');
		$where['com_id']	=	$this->uid;
		$where['usertype']	=	$this->usertype;
		
		$urlarr['page']	=	'{{page}}';
		$urlarr['c']	=	"consume";
		$pageurl		=	Url('wap',$urlarr,'member');
		
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('company_pay',$where,$pageurl,$_GET['page']);
		
		if($pages['total'] > 0){
			
			$where['orderby']	=	'pay_time,desc';
		    $where['limit']		=	$pages['limit'];
			
		    $List				=	$orderM->getPayList($where);
			
			$this->yunset("rows",$List);
		}
		
		$this->yunset('header_title',"财务明细");
		$this->waptpl('consume');
	}
	
	function integral_reduce_action(){
		$backurl	=	Url('wap',array('c'=>'integral'),'member');
		
		$this->yunset('backurl',$backurl);
		$this->yunset('header_title',"消费规则");
		$this->waptpl('integral_reduce');
	}
	
	function loglist_action(){
		$packM		=	$this->MODEL('pack');
		
		$where['uid']	=	$this->uid;
		$urlarr['page']	=	'{{page}}';
		$urlarr['c']	=	$_GET['c'];
		$pageurl		=	Url('wap',$urlarr,'member');
		
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('company_job_sharelog',$where,$pageurl,$_GET['page']);
		
		if($pages['total'] > 0){
			
			$where['orderby']		=	'time,desc';
		    $where['limit']			=	$pages['limit'];
			
		    $List					=	$packM->getShareLogList($where);
			$this->yunset("rows",$List);
		}
		
		$backurl	=	Url('wap',array('c'=>'finance'),'member');
		
		$this->getStatis('loglist');
		$this->yunset('header_title',"赏金收益明细");
		$this->yunset('backurl',$backurl);
		$this->waptpl('loglist');
	}
	function change_action(){
		
	    $orderM		=	$this->MODEL('companyorder');
	    $where		=	array(
	        'com_id'		=>	$this->uid,
	        'usertype'		=>	$this->usertype,
	        'pay_remark'	=>	array('like','转换'.$this->config['integral_pricename'])
	    );
	    $changeNum 	=	$orderM->getCompanyPayNum($where);
	    
		$backurl	=	Url('wap',array('c'=>'loglist'),'member');
		
		$this->getStatis();
		$this->yunset('backurl',$backurl);
		$this->yunset('header_title',"赏金转换".$this->config['integral_pricename']);
		$this->yunset("changeNum",$changeNum);
		$this->waptpl('change');
	}
	/**
	 * 执行转换积分
	 */
	function saveChange_action(){
	    
	    if($_POST){
	        $data['changeprice']	=	$_POST['changeprice'];
	        $data['changeintegral']	=	$_POST['changeintegral'];
	        $data['uid']			=	$this	->	uid;
	        $data['usertype']		=	$this	->	usertype;
	        $packM					=	$this	->	MODEL('pack');
	        $return					=	$packM	->	saveChange($data);
	        
	        echo json_encode($return);
	    }
	}
	function changelist_action(){
		$orderM			=	$this->MODEL('companyorder');
		
		$where['com_id']		=	$this->uid;
		$where['usertype']		=	$this->usertype;
		$where['pay_remark']	=	array('like','转换'.$this->config['integral_pricename']);
		
		//分页链接
		$urlarr['page']	=	'{{page}}';
		$urlarr['c']	=	"changelist";
		$pageurl		=	Url('wap',$urlarr,'member');
		
		//提取分页
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('company_pay',$where,$pageurl,$_GET['page']);
		
		//分页数大于0的情况下 执行列表查询
		if($pages['total'] > 0){
			
			$where['orderby']	=	'pay_time,desc';
		    $where['limit']		=	$pages['limit'];
			
		    $List				=	$orderM->getPayList($where);
			$this->yunset("rows",$List);
		}
		
		$this->getStatis();
		$this->yunset('header_title',"赏金转换".$this->config['integral_pricename']."明细");
		$this->waptpl('changelist');
	}
	
	//提现
	function withdraw_action(){

		$this->yunset('header_title',"提现");
		
		if($_POST['price']	&&	$_POST['real_name']){
			$packM	=	$this->MODEL('pack');
			
			$return	=	$packM->withDraw($this->uid,$this->usertype,$_POST['price'],$_POST['real_name']);

			if($return['errcode'] == 1){
				
				$data['msg']	=	'提现成功，请关注微信账户提醒！';
				$data['url']	=	'index.php?c=withdrawlist';
				
			}else{
				
				$data['msg']	=	$return['msg'];
				$data['url']	=	$_SERVER['HTTP_REFERER'];
				
			}
			// $this->yunset("layer",$data);
			echo json_encode($data);exit;
			
		}else{
			
			$this->getStatis();
			
		}
		$backurl	=	Url('wap',array('c'=>'loglist'),'member');
		$this->yunset('backurl',$backurl);
		$this->waptpl('withdraw');
	}
	
	function withdrawlist_action(){
		$packM			=	$this->MODEL('pack');
		
		$where['uid']	=	$this->uid;
		
		$urlarr['page']	=	'{{page}}';
		$urlarr['c']	=	"withdrawlist";
		$pageurl		=	Url('wap',$urlarr,'member');
		
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('member_withdraw',$where,$pageurl,$_GET['page']);
		
		if($pages['total'] > 0){
			
			$where['orderby']		=	'id,desc';
		    $where['limit']			=	$pages['limit'];
			
		    $List					=	$packM->getList($where);
			$this->yunset("rows",$List);
		}
		$this->getStatis();
		$this->yunset('header_title',"提现明细");
		$this->waptpl('withdrawlist');
	}
	function rewardlog_action(){	

		$packM					=	$this->MODEL('pack');
		
		$where['uid']			=	$this->uid;
		
		if($_GET['state']){
			
			$where['status']	=	array('in',pylode(',',$arr_data['rewardstate'][$_GET['state']]['state']));
			
			$urlarr['state']	=	$_GET['state'];
		}
		$urlarr=array('c'=>'rewardlog',"page"=>"{{page}}");
		$pageurl=Url('wap',$urlarr,'member');
 
		$pageM		=	$this  -> MODEL('page');
		$pages		=	$pageM -> pageList('company_job_rewardlist',$where,$pageurl,$_GET['page'],$this->config['sy_listnum']);
		
		if($pages['total'] > 0){
			
			$where['orderby']	=	'datetime';
			$where['limit']		=	$pages['limit'];
			 
			$List	=	$packM -> getJobRewardList($where,array('utype'=>'lietou'));
			
			$this->yunset("rows" , $List);
		}
		$backurl=Url('wap',array('c'=>'jobcolumn'),'member');
		$this->yunset('backurl',$backurl);
		$this->yunset('header_title',"赏金职位");
		$this->waptpl('jobrewardlog');
	}
	
	function logstatus_action(){
		if($_POST){
				
			$M		=	$this->MODEL('pack');
			$_POST['port']	=	'2';
			$return	=	$M->logStatus((int)$_POST['rewardid'],(int)$_POST['status'],$this->uid,'1',$_POST);
				
			 if($return['error']==''){
				//悬赏职位设定成功
				 echo json_encode(array('error'=>'ok'));
					
			 }else{
				 //生成失败 返回具体原因
			
				 echo json_encode(array('error'=>$return['error']));
			 }
		}
	}
	function arb_action(){
		$this->yunset('headertitle',"申请仲裁");
		if($_POST){

			if(!$_POST['rewardid']){
				$this->ACT_layer_msg("请选择需要仲裁的赏单！",8,$_SERVER['HTTP_REFERER']);
			}
			if(!$_POST['content']){
				$this->ACT_layer_msg("请填写仲裁原因！",8,$_SERVER['HTTP_REFERER']);
			}else{
				$data['content'] = $_POST['content'];
			}

			
			
			$data['base']   =  $_POST['privew'];
			$M				=	$this->MODEL('pack');
			$data['port']	=	'2';
			$return	=	$M->logStatus((int)$_POST['rewardid'],26,$this->uid,'1',$data);
				
			if($return['error']==''){
				//悬赏职位设定成功
				$data['msg']='仲裁提交成功！';
				$data['url']='index.php?c=rewardlog';
			
				$this->yunset("layer",$data);
					
			}else{
				 //生成失败 返回具体原因
				 $data['msg']=$return['error'];
				$data['url']='index.php?c=rewardlog';
			
				$this->yunset("layer",$data);
			}
		}elseif($_GET['rewardid']){
		
			
			
		}
	
		$this->waptpl('jobrewardarb');
	}

	function talent_action(){
		
		$where['uid']	=  $this->uid;
		$urlarr['c']	=	$_GET['c'];
		$urlarr['page']	=	'{{page}}';
	    $pageurl		=	Url('wap',$urlarr,'member');

	    $pageM			=	$this->MODEL('page');
	    $pages			=	$pageM->pageList('lt_talent',$where,$pageurl,$_GET['page']);
	    
	    if($pages['total'] > 0){
	        $where['orderby']		=	'id';
	        $where['limit']			=	$pages['limit'];
	        
	        $talentM  =  $this->MODEL('talent');
	        
	        $List   	=  $talentM->getList($where,array('scene'=>'detail'));
	    }
		$this->yunset("rows",$List);
		
		$this->yunset('header_title',"简历库");
		$this->waptpl('talent');
	}

	function talentexpect_action(){
		
		$talentM = $this->MODEL('talent');

		if($_GET['id']){
			$expectInfo	=	$talentM -> getInfo(array('id'=>intval($_GET['id'])));
			
			$this->yunset("resume",$expectInfo);
		}
		$this->yunset($this->MODEL('cache')->GetCache(array('city','user','hy')));
		
		$this->yunset('header_title',"充实简历库");
		$this->waptpl('talent_expect');
		
	}
	function savetalentexpect_action(){

		if($_POST){
			$talentM = $this->MODEL('talent');
			$_POST['uid']	=	$this->uid;
			$_POST['did']	=	$this->userdid;
			$return  = $talentM->addTalent($_POST);
			echo json_encode($return);
		}
	}
	function telstatus_action(){

		$talentM	= 	$this->MODEL('talent');
		$logM 		= 	$this->MODEL('log');
		if($_GET['id']){

			$Info = $talentM->getInfo($_GET['id']);
			$this->yunset("Info",$Info);
			$this->yunset('header_title',"简历库授权认证");
			$this->waptpl('telstatus');
		}elseif($_POST['id'] && $_POST['linktel'] && $_POST['code']){

			$return  = $talentM->telStatus($_POST['id'],$this->uid,$_POST['linktel'],$_POST['code']);
			if($return['error']=='1'){
				$logM->addMemberLog($this->uid,$this->usertype,'简历库授权认证',13,1);
			}
			echo json_encode($return);
		}
	}
	
	//赏金推荐
	function talentreward_action(){
		
		//获取赏金职位信息 
		$packM = $this->MODEL('pack');
		$job = $packM->getRewardJobInfo((int)$_GET['jobid'],array('uid'=>$this->uid,'isjob'=>1));
		
		$this->yunset('job',$job);
		//查询简历库
		$where['uid']	=  $this->uid;
		$urlarr['c']	=	$_GET['c'];
		$urlarr['page']	=	'{{page}}';
	    $pageurl		=	Url('wap',$urlarr,'member');

	    $pageM			=	$this->MODEL('page');
	    $pages			=	$pageM->pageList('lt_talent',$where,$pageurl,$_GET['page']);
	    
	    if($pages['total'] > 0){
	        $where['orderby']		=	'id';
	        $where['limit']			=	$pages['limit'];
	        
	        $talentM  =  $this->MODEL('talent');
	        
	        $List   	=  $talentM->getList($where,array('scene'=>'detail'));
	    }
		$this->yunset("rows",$List);
		
		$this->yunset('header_title',"赏金投递");
		$this->waptpl('talentreward');
	}
	
	function talentsqjob_action(){
		
		
		$packM = $this->MODEL('pack');
	
		$return  = $packM->sqRewardJob($_POST['jobid'],$this->uid,$this->usertype,$_POST['eid']);
		
		echo json_encode($return);
	}
	 
	function sysnews_action(){
	    
		//应聘简历
		$JobM		=	$this -> MODEL('job');
		$userid_jobnum	=	$JobM -> getSqJobNum(array('com_id'=>$this->uid,'type'=>3,'is_browse'=>'1','isdel'=>9));
		$this->yunset('userid_jobnum',$userid_jobnum);
		
		//职位咨询
		$MsgM		=	$this -> MODEL('msg');
		$jobnum		=	$MsgM->getMsgNum(array('job_uid'=>$this->uid,'status'=>1,'type'=>3,'com_remind_status'=>'0'));
		$this->yunset('jobnum',$jobnum);
		
		//委托简历
		$EntrustM	=	$this -> MODEL('entrust');
		$entrustnum	=	$EntrustM -> getEntrustNum(array('lt_uid'=>$this->uid,'remind_status'=>'0'));
		$this->yunset('entrustnum',$entrustnum);
		//私信
		$SysmsgM	=	$this -> MODEL('sysmsg');
		$sxnum		=	$SysmsgM -> getSysmsgNum(array('fa_uid'=>$this->uid,'usertype'=>$this->usertype,'remind_status'=>'0'));
		$this->yunset('sxnum',$sxnum);
		
    	$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->yunset('header_title',"消息");
		$this->waptpl('sysnews');
	}

    // 求职咨询
    function msg_action()
    {
        $MsgM   =   $this->MODEL('msg');
        
        $where  =   $urlarr =   array();
        $where['job_uid']   =   $this->uid;
        $where['status']   =   1;
        $urlarr['c']        =   $_GET['c'];
        $urlarr['page']     =   '{{page}}';
        $pageurl            =   Url('wap', $urlarr, 'member');
        
        $pageM              =   $this->MODEL('page');
        $pages              =   $pageM -> pageList('msg', $where, $pageurl, $_GET['page']);

        if ($pages['total'] > 0) {
        
            $where['orderby']   =   'id';
            $where['limit']     =   $pages['limit'];
            
            $rows               =   $MsgM->getList($where);
            $this->yunset('rows', $rows['list']);
        }
        
        if ($_POST['submit']) {
            
            $data                       =   array();
            $data['reply']              =   $_POST['reply'];
            $data['reply_time']         =   time();
            $data['user_remind_status'] =   '0';
            $where['id']                =   (int) $_POST['id'];
            $where['job_uid']           =   $this->uid;
            
            $nid    =   $MsgM -> upReplyInfo($where, $data);
            
            if ($nid) {
                
                $LogM   =   $this->MODEL('log');
                $LogM -> addMemberLog($this->uid, $this->usertype, "回复企业评论", 18, 1);
                
                $data['msg'] = '回复成功';
                $data['url'] = 'index.php?c=msg';
            } else {
                
                $data['msg'] = '添加失败';
            }
            
            $this->yunset('layer', $data);
        }
        if (!isset($_GET['chat'])){
            $backurl    =   Url('wap', array('c' => 'sysnews' ), 'member');
            $this->yunset('backurl', $backurl);
        }
        $this->yunset('header_title', "求职咨询");
        $this->waptpl('msg');
    }
	
	function delmsg_action(){
		$MsgM	=	$this -> MODEL('msg');
		if($_GET['id']){
			$nid	=	$MsgM -> delMsg($_GET['id'],array('job_uid'=>$this->uid));
			if($nid){	
				$LogM		=	$this -> MODEL('log');
				$LogM->addMemberLog($this->uid,$this->usertype,"删除求职咨询",18,3);
				$this->waplayer_msg('删除成功！');
			}else{
				$this->waplayer_msg('删除失败！');
			}
		}		
	}
	//职位管理
	function jobcolumn_action(){
        $backurl=Url('wap',array(),'member');
		
		$this->yunset('backurl',$backurl);
		
		$this->yunset('header_title',"职位管理");
		
		$this->waptpl('jobcolumn');
	}
	//设置
	function set_action(){
		$LietouM	=	$this -> MODEL('lietou');
		$CompanyM	=	$this -> MODEL('company');
		$UserinfoM	=	$this -> MODEL('userinfo');
		$lt			=	$LietouM -> getInfo(array('uid'=>$this->uid),array('utype'=>'user'));
		$this -> yunset("lt",$lt);
		$cert		=	$CompanyM -> getCertInfo(array('uid'=>$this->uid,'type'=>'4'));
		$this -> yunset("cert",$cert);
		$info		=	$UserinfoM -> getInfo(array('uid'=>$this->uid),array('setname'=>'1'));
		if($info['setname']=='1'){
			$this -> yunset("setname",1);
		}
		$backurl	=	Url('wap',array(),'member');
		$this -> yunset('backurl',$backurl);
		$this -> yunset('header_title',"账户设置");
		
		$this -> waptpl('set');
	}
	//财务
	function finance_action(){
		$backurl	=	Url('wap',array(),'member');
		
		$this->getStatis();
		$this->yunset('backurl',$backurl);
		$this->yunset('header_title',"财务管理");
		$this->waptpl('finance');
	}
	
	//优惠卡卷
	function coupon_list_action(){
		$couponM	=	$this->MODEL('coupon');
		
		$updata['status']		=	'3';
		
		$upwhere['uid']			=	$this->uid;
		
		$upwhere['validity']	=	array('<', time());
		
		$upwhere['status']		=	'1';
		
		$couponM->upCouponList($upwhere,$updata);
		
		
		$where['uid']			=	$this->uid;
		
		$urlarr['page']	=	'{{page}}';
		$urlarr['c']	=	"coupon_list";
		$pageurl		=	Url('wap',$urlarr,'member');
		
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('coupon_list',$where,$pageurl,$_GET['page']);
		
		//分页数大于0的情况下 执行列表查询
		if($pages['total'] > 0){
			
			$where['orderby']		=	'id,desc';
		    $where['limit']			=	$pages['limit'];
			
		    $List					=	$couponM->getCouponList($where);
			$this->yunset("rows",$List);
		}
		$backurl	=	Url('wap',array('c'=>'finance'),'member');
		$this->yunset('backurl',$backurl);
		$this->yunset('header_title',"优惠卡券");
		$this->waptpl('coupon_list');
	}
	
	function delcoupon_action(){
		$couponM	=	$this->MODEL('coupon');
		
		if($_GET['id']){
		    $data['uid'] 		=	$this->uid;
		    $data['usertype']	=	$this->usertype;
			$return	=	$couponM->delCouponList(array('id'=>intval($_GET['id']), 'uid'=>$this->uid));
			$this->waplayer_msg($return['msg']);
		}
	}
		//积分管理
	function integral_action(){
		$integralM	=	$this->MODEL('integral');
		
		$statusList	=	$integralM	->	integralMission(array('type'=>'lietou','uid'=>$this->uid,'usertype'=>$this->usertype));
		
		$statis		=	$this->getStatis();
		
		$reg_url	= 	Url('wap',array('c'=>'register','uid'=>$this->uid));
		
		$backurl	=	Url('wap',array('c'=>'finance'),'member');
		
		$this->yunset("statusList",$statusList);
		$this->yunset('reg_url', $reg_url);
		$this->yunset('backurl',$backurl);
		$this->yunset('header_title',$this->config['integral_pricename']."管理");
		$this->waptpl('integral');
	}
	
	//我的服务
	function com_action(){
		$backurl	=	Url('wap',array('c'=>'finance'),'member');
		
		$this->getStatis();
		$this->yunset('backurl',$backurl);
		$this->yunset('header_title',"我的会员");
		$this->waptpl('com');
	}
	
	//简历栏目
	function resumecolumn_action(){
		$jobM			=	$this->MODEL('job');
		$entrustM		=	$this->MODEL('entrust');
		$lookresumeM	=	$this->MODEL('lookresume');
		$resumeM		=	$this->MODEL('resume');
		$talentM		=	$this->MODEL('talent');
		$lietouM		=	$this->MODEL('lietou');
		$downM		    =	$this->MODEL('downresume');
		//应聘来的简历
		$yp_resume			=	$jobM->getSqJobNum(array('com_id'=>$this->uid,'type'=>3,'isdel'=>9));
 		$this->yunset("yp_resume",$yp_resume);
		
		//委托来的简历
		$entrust_resume		=	$entrustM->getEntrustNum(array('lt_uid'=>$this->uid));
 		$this->yunset("entrust_resume",$entrust_resume);
		
		$entrust_resumeno	=	$entrustM->getEntrustNum(array('lt_uid'=>$this->uid,'remind_status'=>0));
 		$this->yunset("entrust_resumeno",$entrust_resumeno);
		
		//已下载的简历
 		$down_resume		=	$downM->getDownNum(array('comid'=>$this->uid,'usertype'=>3,'isdel'=>9));
 		$this->yunset("down_resume",$down_resume);
		//浏览过的简历
		$look_resume		=	$lookresumeM->getLookNum(array('com_id'=>$this->uid,'usertype'=>3, 'com_status'=>0));
 		$this->yunset("look_resume",$look_resume);
		//简历库talent
		$talent				=	$talentM->getTalentNum(array('uid'=>$this->uid));
 		$this->yunset("talent",$talent);
		//我推荐的悬赏
		$my_rebates			=	$lietouM->getRebatesNum(array('uid'=>$this->uid));
 		$this->yunset("my_rebates",$my_rebates);
		$my_rebatesno		=	$lietouM->getRebatesNum(array('uid'=>$this->uid,'status'=>array('<>',0)));
   
 		$this->yunset("my_rebatesno",$my_rebatesno);
		//推荐给我的人才
		$give_rebates		=	$lietouM->getRebatesNum(array('job_uid'=>$this->uid));
 		$this->yunset("give_rebates",$give_rebates);
		
		$give_rebatesno		=	$lietouM->getRebatesNum(array('job_uid'=>$this->uid,'status'=>0));
 		$this->yunset("c",$give_rebatesno);
		
        $backurl	=	Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		
		$this->yunset('header_title',"简历管理");
		$this->waptpl('resumecolumn');
	}
	
	//私信
	function sxnews_action(){
		$SysmsgM			=	$this -> MODEL('sysmsg');
		$where['fa_uid']	=	$this->uid;
		$where['usertype']	=	$this->usertype;
		$urlarr["c"] 		= 	$_GET["c"];
		$urlarr["page"] 	= 	"{{page}}";
		$pageurl			=	Url('wap',$urlarr,'member');
		$pageM				=	$this->MODEL('page');
		$pages				=	$pageM->pageList('sysmsg',$where,$pageurl,$_GET['page']);
		if($pages['total'] > 0){
	        $where['orderby']	 =	'id';
	        $where['limit']		 =	$pages['limit'];
	        $rows	=	$SysmsgM -> getList($where, array('from' => 'wap_member'));
	    }
		$this->yunset("rows",$rows);
        $backurl=Url('wap',array('c'=>'sysnews'),'member');
		$this->yunset('backurl',$backurl);
		$this->yunset('header_title',"系统消息");
		$this->waptpl('sxnews');
	}
    function sxnewsset_action(){
    	$SysmsgM		=	$this -> MODEL('sysmsg');
    	$id				=	(int)$_POST['id'];
		$remind_status	=	(int)$_POST['remind_status'];
		if($id&&$remind_status){
			$nid		=	$SysmsgM -> upSysmsg(array('fa_uid'=>$this->uid,'id'=>$id,'remind_status'=>'0'),array('remind_status'=>$remind_status));
			$LogM		=	$this -> MODEL('log');
			$LogM -> addMemberLog($this->uid,$this->usertype,"更改系统消息状态（ID:".$id."）",18,2);
		}
		$nid?$this->waplayer_msg("操作成功！"):$this->waplayer_msg("操作失败！");
    }
	
	function delsxnews_action(){
		$SysmsgM  =	 $this -> MODEL('sysmsg');
		if($_GET['id']){
			$return  =	 $SysmsgM->delSysmsg($_GET['id'],array('fa_uid'=>$this->uid));
			$LogM	 =	 $this -> MODEL('log');
			$LogM -> addMemberLog($this->uid,$this->usertype,"删除系统消息",18,3);
			$this -> waplayer_msg($return['msg']);
	    } 
	}
	
	function getStatis($type=''){
		$statisM  	= 	$this->MODEL('statis');
		
		$statis		= 	$statisM->getInfo($this->uid,array('usertype'=>3));
		
		if($type=='reward_list'){
			$statis['integral']	=	number_format($statis['integral']);
		}
		if($type=='loglist'){
			$statis['packpay'] 	= sprintf("%.2f", $statis['packpay']);
			$statis['freeze'] 	= sprintf("%.2f", $statis['freeze']);
		}
		$this->yunset("statis",$statis);
	}

	 /**
     * @desc 会员套餐、增值服务、单项购买页面
     */
    function server_action(){
        
        $paytype       =   array();
        
        if($this->config['wxpay']=='1'){
            $paytype['wxpay']='1';
        }
        if($this->config['alipay']=='1' &&  $this->config['alipaytype']=='1'){
            $paytype['alipay']='1';
        }
        if($paytype){
            $this->yunset('paytype',$paytype);
        }
      
        $ratingM    =   $this->MODEL('rating');
        $ratingList =   $ratingM -> getList(array('display' => 1, 'orderby' => array('type,asc', 'sort,desc')));
        
		
        $rating_1   =   $rating_2   =   $raV    =   array();
        

        if (!empty($ratingList)) {
        
            foreach ($ratingList as $ratingV) {
                
                $raV[$ratingV['id']]    =   $ratingV;
                
                if ($ratingV['category'] == 2 && $ratingV['service_price'] > 0) {
                    
                    if ($ratingV['type'] == 1) {
                        
                        $rating_1[]     =   $ratingV;
                    } elseif ($ratingV['type'] == 2) {
                        
                        $rating_2[]     =   $ratingV;
                    }
                }
            }
        }

        $this->yunset('rating_1', $rating_1);
        $this->yunset('rating_2', $rating_2);
        
        $statis     =   $this->lt_satic();
		
		$ltM		=	$this->MODEL('lietou');
		$add        =   $ltM->getLtserviceList(array('display' => 1 , 'orderby' => array('sort,desc')), array('detail' => 'yes'));
		$this->yunset('add', $add);

 		if(!empty($statis)){
            
            $discount           =   isset($raV[$statis['rating']]) ? $raV[$statis['rating']] : array();
            if($discount['service_discount'] > 0){
                $statis['zk']       =   $discount['service_discount'] * 0.01 ;
                $statis['zk_n']     =   $discount['service_discount'] * 0.1 ;
            }
        }
        
        $this->yunset('statis', $statis);
        
        $server =   trim($_GET['server']);
        $lt_single_can = explode(',', $this->config['lt_single_can']);

        if($server && !in_array($server,$lt_single_can)){
        	$this->yunset('noSingle', '1');
        }
        switch($server){
            case 'issuejob':
                $this->yunset('single_price', $this->config['integral_job']);
                $this->yunset('single_msg', '本次职位发布');
                break;
            case 'sxjob':
                $this->yunset('single_price', $this->config['integral_jobefresh']);
                $this->yunset('single_msg', '本次刷新职位');
                break;
            case 'downresume':
                $resumeM    =   $this->MODEL('resume');
                $id         =   intval($_GET['id']);
                $price      =   $resumeM -> setDayprice($id);
                $this->yunset('single_price', $price);
                $this->yunset('single_msg', '本次下载简历');
                break;
            case 'chat':
                $this->yunset('single_price', $this->config['integral_chat_num']);
                $this->yunset('single_msg', '本次购买'.$this->config['sy_chat_name']);
                break;
            default:
                $this->yunset('noSingle', '1');
                break;
        }
        
        $this->yunset('server_id', $_GET['id']);
        $this->yunset('server', $server);
        
        if (!isVip($statis['vip_etime']) && $server != 'downresume') {   //  过期会员
            
            $this->yunset('vipIsDown', '1');
        }
        $sy_only_price  =   @explode(',',$this->config['sy_only_price']);
        $this->yunset('sy_only_price', $sy_only_price);

        if (in_array('vip', $sy_only_price)){
            $this->yunset('meal_vip',1);
        }
        if (in_array('pack', $sy_only_price)){
            $this->yunset('meal_pack',1);
        }
        $this->yunset('header_title', '优选服务');
        $this->waptpl('server');
    }

    /**
     * @desc 获取优惠券
     */
    function getCouponList_action(){
        
        if ($_POST) {
            
            $price      =   $_POST['price'];
            
            $couponM    =   $this->MODEL('coupon');
            $couponList =   $couponM -> getCouponList(array('uid' => $this->uid, 'orderby' => array('coupon_amount,desc', 'coupon_scope,asc')));
            
            $cid        =   intval($_POST['cid']);
            
            if (!empty($couponList) && is_array($couponList)) {
                
                $html1  =   $html2  =   '';
                
                foreach ($couponList as $v){
                    
                    if ($v['coupon_scope'] <= $price && $v['status'] == 1 && $v['validity'] > time()) {
                        
                        if ($v['id'] == $cid) {
                            
                            $html1   .=  "<li data-id='".$v['id']."' data-price='".$v['coupon_amount']."' data-name='".$v['coupon_name']."' class='yhq_xz_list_cur'>".$v['coupon_name']."（满".$v['coupon_scope']."元可用）<span class='yhq_xz_list_xz'></span></li>";
                        }else{
                            
                            $html1   .=  "<li data-id='".$v['id']."' data-price='".$v['coupon_amount']."' data-name='".$v['coupon_name']."'>".$v['coupon_name']."（满".$v['coupon_scope']."元可用）<span class='yhq_xz_list_xz'></span></li>";
                        }
                        
                    }
                }
            }
            
            $arr        =   array(
                'h1'    =>  empty($html1) ? '<li><div class="yhq_no"><div class="yhq_no_p">很遗憾</div><div class="yhq_no_pp">您暂无可使用的优惠券</div></div></li>' : $html1.'<li>不使用优惠券<span class="yhq_xz_list_xz"></span></li>'
            );
            
            echo json_encode($arr);die;
        }
    }
    
    /**
     * @desc 优惠券支付
     */
    function couponBuy_action(){
        
        $data				=	$_POST;
        $data['uid']		=	$this	->	uid;
        $data['username']	=	$this	->	username;
        $data['usertype']	=	$this	->	usertype;
        
        $M					=	$this	->	MODEL('coupon');
        $return				=	$M		->	couponBuy($data);
        echo json_encode($return);
        
    }
}
?>