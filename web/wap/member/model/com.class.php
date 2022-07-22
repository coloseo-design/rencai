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

class com_controller extends wap_controller
{

    function get_user()
    {
        if (!$_GET['c']) {
            if ($this->comInfo['hy'] == '') {
                if ($_COOKIE['indextip'] == '1') {

                    $indextip   =   0;
                } else {

                    $this->cookie->SetCookie('indextip', '1', (strtotime('today') + 86400));
                    $indextip   =   1;
                }
                $this->comInfo['base']   =   0;
                $this->yunset('indextip', $indextip);
            } else {

                $this->comInfo['base']   =   1;
                $this->cookie->SetCookie('indextip', '', (strtotime('today') - 86400));
            }
        }
        $this->yunset('company', $this->comInfo);
        return $this->comInfo;
    }

	function waptpl($tpname){

        $this->yuntpl(array('wap/member/com/'.$tpname));
	}

	function index_action(){
		
        $this->yunset('backurl',Url('wap',array()));
        $this->yunset('membernav', 1);
 		$this->waptpl('index');
	}


	function com_action()
    {

		$backurl  =   Url('wap', array('c'=>'finance'), 'member');
		$this -> yunset('backurl',$backurl);
		$this->yunset('spid',$this->spid);
		$this -> yunset('header_title', '我的服务');
		$this -> waptpl('com');
	}

	function reportlist_action()
    {
		$backurl  =   Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->yunset('header_title',"举报简历");
		$this->waptpl('reportlist');
	}

	function info_action()
    {
		$this -> yunset('header_title','基本信息');
		$this -> waptpl('info');
	}

	function jobadd_action(){

		$this -> yunset('header_title',"发布职位");
		$this -> waptpl('jobadd');
	}

	function job_action()
    {
        $backurl = Url('wap', array(), 'member');
        $this -> yunset('backurl', $backurl);
        $this -> yunset('header_title', '职位管理');

        $this -> waptpl('job');
    }
	/**
	 * @desc 兼职报名
	 */
	function partapply_action(){

        $backurl  =  Url('wap', array('c' => 'part'), 'member');
        $this->yunset('backurl', $backurl);
        $this->yunset('header_title', '兼职报名');
        $this->waptpl('partapply');
    }

	function hr_action(){

		$this->yunset('header_title',"应聘简历");
		$this->get_user();
		$this->waptpl('hr');
	}

	function password_action(){
		$backurl=Url('wap',array('c'=>'set'),'member');
		$this->yunset('backurl',$backurl);
		$this->yunset('header_title',"修改密码");
		$this->waptpl('password');
	}

	function pay_action(){

	    $orderM		=	$this	->	MODEL('companyorder');
	    $paytype	=	array(
	        'wxpay'		=>	$this->config['wxpay']=='1'	?	'1'	:	'',
	        'alipay'	=>	$this->config['alipay']=='1' && $this->config['alipaytype']=='1'	?	'1'	:	''
	    );

	    $couponM		=	$this	->	MODEL('coupon');
	    $coupons		=	$couponM->	getCouponList(array(
	        'uid'			=>	$this->uid,
	        'validity'		=>	array('>',time()),
	        'status'		=>	'1'
	    ));

	    if($paytype){
	        $this	->	yunset("paytype",$paytype);
	        $this	->	yunset("js_def",4);
	    }else{
	        $data['msg']	=	"暂未开通手机支付，请移步至电脑端充值！";
	        $data['url']	=	$_SERVER['HTTP_REFERER'];
	        $this	->	yunset("layer",$data);
	    }
	    $nopayorder	=	$orderM	->	getCompanyOrderNum(array('uid'=>$this->uid,'usertype' => $this->usertype,'order_state'=>'1'));
	    $this		->	yunset('nopayorder',$nopayorder);
	    $this		->	yunset("coupons",$coupons);
	    $this		->	yunset($this->MODEL('cache')->GetCache(array('integralclass')));
	    $this		->	yunset('header_title',"充值".$this->config['integral_pricename']);
	    $this		->	waptpl('pay');
	}

	function payment_action(){
 		if($this->config['wxpay']=='1'){
			$paytype['wxpay']	=	'1';
		}
		if($this->config['alipay']=='1' &&  $this->config['alipaytype']=='1'){
			$paytype['alipay']	=	'1';
		}

		if($paytype){
			if($_GET['id']){//订单
				$orderM	=	$this	->	MODEL('companyorder');
				$order	=	$orderM	->	getInfo(array('uid'=>$this->uid,'id'=>(int)$_GET['id']),array('bank'=>1));
				if(empty($order)){
					$this->ACT_msg_wap($_SERVER['HTTP_REFERER'],"订单不存在！",2,5);
				}elseif($order['order_state']!='1'){
					header("Location:index.php?c=paylog");
				}else{
					$this	->	yunset("order",$order);
				}
			}
 			$this	->	yunset("paytype",$paytype);
 			$this	->	yunset("js_def",4);
		}else{
			$data['msg']	=	"暂未开通手机支付，请移步至电脑端充值！";
			$data['url']	=	$_SERVER['HTTP_REFERER'];
			$this	->	yunset("layer",$data);
		}
		$this	->	yunset('header_title',"订单确认");
		$this	->	waptpl('payment');
	}

	//会员统计信息调用
	function company_satic(){

		$statisM  =  $this->MODEL('statis');
		// 会员套餐过期检测，并处理

		$suid     =   $this->spid ? $this->spid : $this->uid;
		$statis   =  $statisM -> vipOver($suid, 2);

		$this->yunset('addjobnum', $statis['addjobnum']);
		$this->yunset('spviewNum', $statis['spviewNum']);

		if($statis['integral'] == ''){
		    $statis['integral']   =   0;
		}
		$this->yunset('statis',$statis);

		return $statis;
	}

	function getOrder_action()
    {

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
	    if ($this->comInfo['crm_uid']){

	        $data['crm_uid']=   $this->comInfo['crm_uid'];
        }

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
		$rdata['port']		    =  '2';

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
		$this -> get_user();
		$this -> waptpl('pay');
	}
	/**
	 *  微信支付
	 */
	function wxpay_action(){
	    $comorderM	=	$this->MODEL('companyorder');

	    $data['source']   =  'com';
	    $data['orderId']  =  (int)$_GET['id'];

	    $return  =  $comorderM->payComOrderByWXWAP($data);

	    if (!empty($return['newOrderId'])){

	        header('Location: index.php?c=wxpay&type=wxh5&id='.$return['newOrderId']);

	        exit();
	    }
	    if($_GET['id']){

	        if($return['header']){
	            // 设置订单id
	            if (!empty($return['id'])){
	                $this->cookie->setcookie('orderid',$return['id'],time()+3600);
	            }
	            
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
	
	function look_job_action(){

		$this->yunset('header_title',"谁看过我");
		$this->get_user();
		$this->waptpl('look_job');
	}

	function atn_teacher_action(){

		$atnM			=	$this->MODEL('atn');

		$uid			=	$this -> uid;

		if($_GET['del']){

			$return		=	$atnM->delAtnAll($_GET['del'],array('type'=>4,'tid'=>intval($_GET['tid']),'uid'=>$uid,'usertype'=>$this->usertype));

			$this->waplayer_msg($return['msg']);
		}

		$where['uid']			=	$uid;
		$where['tid']			=	array('<>', '');
		$where['sc_usertype']	=	'4';

		$urlarr['page']	=	'{{page}}';
		$urlarr['c']	=	"atn_teacher";
		$pageurl		=	Url('wap',$urlarr,'member');

		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('atn',$where,$pageurl,$_GET['page']);

		if($pages['total'] > 0){

			$where['orderby']	=	'id,desc';

		    $where['limit']		=	$pages['limit'];

		    $List				=	$atnM->getatnList($where,array('utype'=>'antteacher'));

			$this->yunset("rows",$List);
		}

		$backurl		=	Url('wap',array('c' => 'jobcolumn'),'member');

		$this->get_user();
		$this->yunset("js_def",7);
		$this->yunset('backurl',$backurl);
		$this->yunset('header_title',"职业培训");
		$this->waptpl('atn_teacher');
	}

	function atn_teacherdel_action(){
        $atnM	=	$this->MODEL('atn');

        $return	=	$atnM->delAtnAll(intval($_GET['id']),array('sc_usertype'=>4,'tid'=>intval($_GET['tid']),'uid'=>$this->uid,'usertype'=>$this->usertype));

        $this->waplayer_msg($return['msg']);
    }

	function fav_subject_action(){
		$trainM			=	$this->MODEL('train');

		$where['uid']		=	$this->uid;
		$where['usertype']	=	$this->usertype;

		$urlarr['page']	=	'{{page}}';
		$urlarr['c']	=	"fav_subject";
		$pageurl		=	Url('wap',$urlarr,'member');

		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('px_subject_collect',$where,$pageurl,$_GET['page']);

		if($pages['total'] > 0){

			$where['orderby']	=	'id,desc';
		    $where['limit']		=	$pages['limit'];

			$List				=	$trainM->getFavSubList($where,array('scene'=>'detail'));
			$this->yunset("rows",$List);
		}

		$backurl		=	Url('wap',array('c' => 'jobcolumn'),'member');

		$this->get_user();
		$this->yunset("js_def",7);
		$this->yunset('backurl',$backurl);
		$this->yunset('header_title',"职业培训");
		$this->waptpl('fav_subject');
	}

	function fav_subjectdel_action(){
		if($_GET['id']){
			$trainM		=	$this->MODEL('train');

			$return		=	$trainM->delFavSub((int)$_GET['id'],array('uid'=>$this->uid,'usertype'=>$this->usertype));

			$this->waplayer_msg($return['msg']);
		}
	}

	function baoming_subject_action(){
		$trainM		=	$this->MODEL('train');
		//删除
		if($_GET['del']){

			$return	=	$trainM -> delBm(array('id'=>(int)$_GET['del']),array('usertype'=>$this->usertype,'uid'=>$this->uid));

			if($return['errcode']==9){
				$msg	=	'取消成功！';
			}else{
				$msg	=	'取消失败！';
			}
			$this->waplayer_msg($msg);
		}
		//列表
		include(CONFIG_PATH."db.data.php");
		$this->yunset("arr_data",$arr_data);

		$where['uid']		=	$this->uid;
		$where['usertype']	=	$this->usertype;

		$urlarr['page']	=	'{{page}}';
		$urlarr['c']	=	"baoming_subject";
		$pageurl		=	Url('wap',$urlarr,'member');
		$pageM			=	$this -> MODEL('page');
		$pages			=	$pageM -> pageList('px_baoming',$where,$pageurl,$_GET['page']);

		if($pages['total'] > 0){

			$where['orderby']	=	'id,desc';

		    $where['limit']		=	$pages['limit'];

		    $List				=	$trainM->getBmList($where,array('scene'=>'detail'));

			$this->yunset("rows",$List);
		}

		$backurl	=	Url('wap',array('c' => 'jobcolumn'),'member');

		$this->get_user();
		$this->yunset("js_def",7);
		$this->yunset('backurl',$backurl);
		$this->yunset('header_title',"职业培训");
		$this->waptpl('baoming_subject');

	}

	function subject_zixun_action(){
		$trainM			=	$this->MODEL('train');

		$where['uid']		=	$this->uid;
		$where['usertype']	=	$this->usertype;

		$urlarr['page']	=	'{{page}}';
		$urlarr['c']	=	'subject_zixun';
		$pageurl		=	Url('wap',$urlarr,'member');
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('px_zixun',$where,$pageurl,$_GET['page']);

		if($pages['total'] > 0){

			$where['orderby']	=	'id,desc';

		    $where['limit']		=	$pages['limit'];

		    $List				=	$trainM->getPxzxList($where,array('utype'=>'zixun', 'wap'=>'1'));

			$this->yunset("rows",$List);
		}

		$backurl	=	Url('wap',array('c' => 'jobcolumn'),'member');

		$this->get_user();
		$this->yunset("js_def",7);
		$this->yunset('backurl',$backurl);
		$this->yunset('header_title',"职业培训");
		$this->waptpl('subject_zixun');

	}

	function subject_zixundel_action(){
		if($_GET['id']){
			$trainM		=	$this->MODEL('train');

			$return		=	$trainM -> delPxzx((int)$_GET['id'],array('uid'=>$this->uid,'usertype'=>$this->usertype));

			$this->waplayer_msg($return['msg']);
		}
	}

	function invite_action(){
		$this->yunset('header_title',"面试邀请");
		$this->waptpl('invite');
	}

	/**
	 * @desc 兼职列表
	 */
	function part_action()
    {
        $backurl = Url('wap', array('c' => 'jobcolumn'), 'member');
        $this -> yunset('backurl', $backurl);
        $this -> yunset('header_title', '兼职管理');
        $this -> waptpl('part');
    }

    // 发布兼职
	function partadd_action()
    {
        $this->yunset('header_title', "发布兼职");
        $this->waptpl('partadd');
    }

	function photo_action(){
		
	    if($_GET['t']){
	        $backurl	=	Url('wap',array(),'member');
	    }else if($_GET['type']){
	        $backurl	=	Url('wap',array('c'=>'integral'),'member');
	    }else{
	        $backurl	=	Url('wap',array('c'=>'info'),'member');
	    }
	    
	    $this->yunset('backurl',$backurl);
	    $this->yunset('header_title',"企业LOGO");
	    $this->waptpl('photo');
	}
	
	function comcert_action(){

		if(empty($this->spid) && !isset($_GET['certbox'])){
			$backurl = Url('wap',array('c'=>'set'),'member');
			$this->yunset('backurl',$backurl);
		}

		$this->yunset('header_title', '企业资质');
		$this->waptpl('comcert');
	}

	function binding_action(){

        if (!isset($_GET['certbox'])){
            $backurl = Url('wap',array('c'=>'set'),'member');
            $this->yunset('backurl',$backurl);
        }
		$this->yunset('header_title',"社交账号绑定");
		$this->waptpl('binding');
	}

	/**
	 * 子账号列表
	 */
	function child_action(){
	    
		$backurl  =  Url('wap',array('c'=>'set'), 'member');
		$this->yunset('backurl', $backurl);
		$this->yunset('header_title', '管理子账号');
		$this->waptpl('child');
	}

	/**
	 * 创建子账号
	 */
	function childedit_action(){

		$backurl  =  Url('wap',array('c' => 'child'), 'member');
		$this -> yunset('backurl', $backurl);
		$this -> yunset('header_title', '创建子账号');
		$this -> waptpl('childedit');
	}
	/**
	 * 分配子账号
	 * 2019-07-09
	 */
	public function childassign_action(){

		$backurl = Url('wap',array('c' => 'child'), 'member');
		$this->yunset('backurl', $backurl);
		$this->yunset('header_title', '分配套餐');
		$this->waptpl('childassign');
	}
	/**
	 * @desc 手机绑定页面
	 */
	function bindingbox_action(){

	    if (!isset($_GET['certbox'])){
	        $backurl = Url('wap', array('c' => 'set'), 'member');
	        $this->yunset('backurl', $backurl);
	    }
        $this->yunset('header_title', "账户绑定");
        $this->waptpl('bindingbox');
    }

    function setname_action()
    {
        $backurl = Url('wap', array('c' => 'set'), 'member');
        $this->yunset('backurl', $backurl);
        $this->yunset('header_title', "修改用户名");
        $this->waptpl('setname');
    }

    function reward_list_action()
    {

		$backurl	=	Url('wap',array('c'=>'integral'),'member');
		$this		->	yunset('backurl',$backurl);
		$this		->	yunset('header_title',"兑换记录");

		$this		->	waptpl('reward_list');
	}

	function delreward_action(){
		$redeemM	=	$this		->	MODEL('redeem');
		$return		=	$redeemM	->	delChange(
			array(
				'uid'		=>	$this->uid,
				'id'		=>	(int)$_GET['id']
			),
			array(
				'member'	=>	'com',
				'uid'		=>	$this->uid,
				'usertype'	=>	$this->usertype,
				'id'		=>	(int)$_GET['id']
			)
		);
		$this		->	waplayer_msg($return['msg']);

	}
	function paylog_action(){
	    
		$this	->	yunset('header_title',"明细");
		$this   ->yunset('spid',$this->spid);
        $backurl  =  Url('wap',array('c'=>'finance'),'member');
        $this->yunset('backurl',$backurl);
		$this	->	waptpl('paylog');
	}
	function jobpack_action(){
		if($_GET['t']=='r'){//悬赏职位
			$this->rewardjob();
		}else{//分享职位
			$this->sharejob();
		}
	}
	function sharejob(){
	    
		$backurl=Url('wap',array('c' => 'jobcolumn'),'member');
 		$this->yunset("backurl",$backurl);
 		$this->yunset("header_title","赏金推广职位");
		$this->waptpl('jobshrelist');
	}

	function lt_jobadd_action(){

		$companyM 	=	$this -> MODEL('company');
		$ltjobM    	=	$this -> MODEL('lietoujob');
		$statisM	=	$this -> MODEL('statis');

		$uid		=	$this->uid;

		$CacheList	=	$this->MODEL('cache')->GetCache(array('lt','lthy','ltjob','city','com','hy'));
		$this->yunset($CacheList);

		$company	=	$companyM->getInfo($uid);

		if($company['lastupdate']<1){

		    $this->ACT_msg_wap(Url('wap', array('c' => 'info'), 'member'), '请先完善基本资料！', '2', 5);

		}
		$statics	=	$this->company_satic();

		if(!$_GET['id']){

			if($statics['addjobnum']==0){

			    if($this->spid){

			        $this->ACT_msg_wap(Url('wap', array(), 'member'), '当前账号会员已到期，请联系主账号进行升级！', '2', 5);

			    }else{

			        $this->ACT_msg_wap(Url('wap', array('c' => 'rating'), 'member'), '您的会员已到期！', '2', 5);
			    }
			}

			if($statics['addjobnum']==2){

				if($this->config['integral_job']!='0'){
				    if($this->spid){

				        $this->ACT_msg_wap(Url('wap', array(), 'member'), '您的套餐已用完，请联系主账号进行升级！', '2', 5);
				    }else{

				        $this->ACT_msg_wap(Url('wap', array('c' => 'rating'), 'member'), '您的套餐已用完！', '2', 5);
				    }
				}else{
					 if($this->spid){

						$statisM->upInfo(array('job_num'=>1),array('uid'=>$this->spid,'usertype'=>$this->usertype));
					 }else{
						$statisM->upInfo(array('job_num'=>1),array('uid'=>$this->uid,'usertype'=>$this->usertype));
					 }

				}
			}
		}

		$msg			=	array();
		$isallow_addjob	=	"1";

		if($this->config['com_enforce_emailcert']=="1"){

			if($company['email_status']!="1"){

				$isallow_addjob	=	"0";
				$msg[]			=	"邮箱认证";
				$data['url']	=	'index.php?c=set';
			}
		}
		if($this->config['com_enforce_mobilecert']=="1"){

			if($company['moblie_status']!="1"){

				$data['msg']	=	"请先完成手机认证";
				$data['url']	=	'index.php?c=set';
			}
		}
		if($this->config['com_enforce_licensecert']=="1"){

            $comM   =   $this->MODEL('company');
            $cert   =   $comM -> getCertInfo(array('uid'=>$this->uid,'type'=>3), array('field' => 'uid,status'));

            if($company['yyzz_status']!='1' && (empty($cert) || $cert['status'] == 2)){

				$data['msg']	=	"请先完成企业资质认证";
				$data['url']	=	'index.php?c=set';
			}
		}
		if($this->config['com_enforce_setposition']=="1"){

			if(empty($company['x'])||empty($company['y'])){

				$isallow_addjob	=	"0";
				$msg[]			=	"设置企业地图";
				$data['url']	=	"index.php?c=info";
			}
		}
		if($isallow_addjob=="0"){

			$data['msg']		=	"请先完成".implode(",",$msg)."！";

		}else if($_GET['id']){

			$id           		=	(int)$_GET['id'];

			$row	= 	$ltjobM->getInfo(array('id'=>$id,'uid'=>$this->uid));
			if($row['id']){

				if($row['job']){
					$job			=	@explode(",",$row['job']);
					foreach ($job as $v){
						$jobname[]	=	$CacheList['ltjob_name'][$v];
					}
				}
				$jobname			=	@implode(",",$jobname);
				$this->yunset("jobname",$jobname);

				if($row['qw_hy']){
					$hy				=	@explode(",",$row['qw_hy']);
					foreach ($hy as $v){
						$hyname[]	=	$CacheList['lthy_name'][$v];
					}
				}
				$hyname				=	@implode(",",$hyname);
				$this->yunset("hyname",$hyname);

				$this->yunset("row",$row);
			}else{
				$data['msg']	=	'职位不存在！';
				$data['url']	=	'index.php?c=job&s=1';
			}
		}
		if($_POST['submit']){

			$cinfo				=	$this->comInfo;

			$rstatus			=	$cinfo['r_status'];

			$_POST = $this->post_trim($_POST);

			if($_POST['maxsalary'] == 0){

				$_POST['maxsalary'] = '';
			}

			$post	= 	array(
				'job_name'    	=>	$_POST['job_name'],

				'jobone'       	=>	$_POST['jobone'],
				'jobtwo'       	=>	$_POST['jobtwo'],

				'department'   	=>	$_POST['department'],
				'report'       	=>	$_POST['report'],

				'provinceid'  	=>	$_POST['provinceid'],
				'cityid'       	=>	$_POST['cityid'],

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
				'other'       	=>	$_POST['other'],
        		'r_status'      =>	$rstatus,
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
				$return['url']	=	'index.php?c=lt_job';
			}
			echo json_encode($return);die;
		}
		$this->yunset("layer",$data);
		$this->get_user();

		$this->yunset('header_title',"发布猎头职位");
		$this->waptpl('lt_jobadd');
	}
	function lt_job_action(){

		$backurl	=	Url('wap',array('c' => 'jobcolumn'),'member');
		$this->yunset('backurl',$backurl);

		$this->yunset('header_title',"猎头职位管理");
		$this->waptpl('lt_job');
	}

	function rewardjob()
    {

		$backurl=Url('wap',array('c' => 'jobcolumn'),'member');
 		$this->yunset("backurl",$backurl);
 		$this->yunset("header_title","赏金推广职位");
		$this->waptpl('jobrewardlist');
	}

	function rewardlog_action(){
		$this->yunset('header_title',"应聘悬赏简历");

		$this->waptpl('jobrewardlog');
	}
	function rewardpay_action(){
	
	    if($_GET['id']){
	        
	        if($this->config['wxpay']=='1'){
	            $paytype['wxpay']='1';
	        }
	        if($this->config['alipay']=='1' &&  $this->config['alipaytype']=='1'){
	            $paytype['alipay']='1';
	        }
	        if($paytype){
	            $this->yunset("paytype",$paytype);
	        }
	        $rewardJob = $this->MODEL('pack')->getReward($_GET['id'],$this->uid);
	        
	        $this->yunset("rewardJob",$rewardJob);
	    }
	    
		$this->yunset('header_title',"赏金支付");

		$this->waptpl('rewardpay');
	}

	function lookresume_action(){

		if($_GET['id']){

			$M			=	$this->MODEL('pack');

			$reward		=	$M->getReward((int)$_GET['id'],$this->uid);

			if(empty($reward)){

				$this->ACT_msg_wap('index.php?c=jobpack&t=r', '未找到相关数据！',2,5);

			}elseif($reward['status']=='0'){

				$this->ACT_msg_wap('index.php?c=jobpack&act=rewardlog&jobid='.$reward['jobid'], '请先支付职位赏金！',2,5);

			}else{
				//根据赏单数据 判断是用户自荐还是第三方推荐
				if($reward['usertype']=='3'){
					$talentM	=	$this -> MODEL('talent');

					$Info		=	$talentM -> getList(array('uid'=>$reward['uid'],'id'=>$reward['eid']));

				}else{
					$resumeM	=	$this -> MODEL('resume');

					$cacheM		=	$this -> MODEL('cache');

					$cache		=	$cacheM->GetCache('user');

					$Info		=	$resumeM -> getInfoByEid(array('uid'=>$reward['uid'],'eid'=>$reward['eid']));

					$Info['sex']=$cache['user_sex'][$Info['sex']];
				}

				$this->yunset(array("resumestyle"=>$this->config['sy_weburl']."/app/template/resume"));

				$this->yunset("Info",$Info);

 				$this->yunset("reward",$reward);

			}
			$this->yunset('header_title',"简历详情");
			$this->waptpl('lookresume');
		}
	}
	function rewardinvite_action(){
		if($_GET['rewardid']){
			$jobM		=	$this -> MODEL('job');

			$packM		=	$this -> MODEL('pack');

			$comM		=	$this -> MODEL('company');

			$resumeM	=	$this -> MODEL('resume');

			$reward 	=	$packM -> getPackInfo(array('comid'=>$this->uid,'id'=>(int)$_GET['rewardid']));

			$company	=	$comM -> getInfo($this->uid,array('field'=>"`address`,`linktel`,`linkphone`,`linkman`"));

			if($reward['jobid']){

				$job	=	$jobM -> getInfo(array('id' => $reward['jobid']));

				if(is_array($job)){

					if($job['is_link'] == 1){

						$job['link_man']      =	  $company['linkman'];
						$job['link_moblie']   =	  $company['linktel'] ? $company['linktel'] : $company['linkphone'];
						$job['address']       =	  $company['address'];
					}elseif($job['is_link'] == 2){

					    $job_link	=	$jobM -> getComJobLinkInfo(array('uid'=>$this->uid,'jobid'=>$reward['jobid']));
						$job['link_man']      =	  $job_link['link_man'];
						$job['link_moblie']   =	  $job_link['link_moblie'];
						$job['address']       =	  $job_link['address'];
					}

					$job['address'] 			=	$company['address'];
				}
				$this->yunset("job",$job);
			}
			if($reward['eid'] && $reward['uid']){

				$resume	=	$resumeM -> getResumeInfo(array('uid'=>$reward['uid'],'r_status'=>1),array('field'=>"`name`,`photo`",'logo'=>2));

				$expect	=	$resumeM -> getExpect(array('id'=>$reward['eid']),array('field'=>"`job_classid`"));

				$resume['job_classname']  =  $expect['job_classname'];

				$this->yunset("resume",$resume);
			}
			$this->yunset("reward",$reward);
		}

        $this->yunset('header_title',"邀请面试");
		$this->waptpl('rewardinvite');
	}
	function loglist_action(){

		$this	->	yunset('header_title',"赏金收益明细");
		$this	->	waptpl('loglist');
	}
	function change_action(){
	    
		$this->yunset('header_title',"赏金转换".$this->config['integral_pricename']);
 		$this->waptpl('change');
	}

	//提现
	function withdraw_action(){
		//查询账户余额信息
		$this->yunset('header_title',"提现");
		$this->waptpl('withdraw');
	}


	function addreward_action(){

		$backurl=Url('wap',array('c'=>'jobcolumn'),'member');
		$this->yunset('backurl',$backurl);
		$this->yunset('header_title',"职位推广");
		$this->waptpl('addreward');
	}
	function addrewardjob_action(){
		
		$this->waptpl('addreward');
	}

    function special_action(){
        
		$backurl=Url('wap',array('c' => 'jobcolumn'),'member');
		$this->yunset('backurl',$backurl);
		$this->yunset("header_title","专题招聘");
        $this->waptpl('special');
    }
    
	function zhaopinhui_action(){
		
		$backurl=Url('wap',array('c' => 'jobcolumn'),'member');
		$this->yunset('backurl',$backurl);
		$this->yunset("header_title","招聘会记录");
		$this->waptpl('zhaopinhui');
	}
	
	function xjh_action(){

		$schoolM        	 =  	$this -> MODEL('school');

		$companyM      		 =     $this -> MODEL('company');

		$where['uid']   	 =   	$this->uid;

		$urlarr["c"]         =     "xjh";

		$urlarr["page"]   	 =     "{{page}}";

		$pageurl			 =		Url('wap',$urlarr,'member');

		$pageM			     =	  	$this  -> MODEL('page');

		$pages			     =	 	$pageM -> pageList('school_xjh',$where,$pageurl,$_GET['page']);

		$where['limit']   	=   	$pages['limit'];

		$rows       		= 		$schoolM->getSchoolXjhList($where);

		$this->yunset("rows",$rows);

		$certwhere['type']    =   3;

    	$certwhere['uid']     =   $this->uid;

    	$cert                 =    $companyM->getCertList($certwhere);
		$this->yunset("cert",$cert);

		$backurl=Url('wap',array('c' => 'jobcolumn'),'member');
		$this->yunset('backurl',$backurl);

		$this->get_user();

		$this->yunset('header_title',"校招宣讲会");

		$this->waptpl('xjh');

	}
	function delxjh_action(){

		$schoolM				=			$this -> Model('school');

		$logM					=			$this -> Model('log');

		$delID	    			=			(int)$_GET['id'];

		$return	  =	$schoolM -> delSchoolxjh($delID,array('uid'=>$this -> uid));

		$this->layer_msg($return['msg'],$return['errcode'],0,$_SERVER['HTTP_REFERER']);

	}

	function set_action(){

	    $backurl  =  Url('wap', array(), 'member');
	    $this->yunset('backurl', $backurl);
	    $this->yunset('header_title', '账户设置');
	    $this->waptpl('set');
	}

	function sysnews_action(){

        $this->yunset('header_title',"消息");
		$this->waptpl('sysnews');
	}
	//求职咨询
	function msg_action(){
		
        $backurl = Url('wap',array('c'=>'sysnews'),'member');
		$this->yunset('backurl',$backurl);
		$this->yunset('header_title',"求职咨询");
        $this->waptpl('msg');
	}
    //私信
	function sxnews_action(){

		$backurl = Url('wap',array('c'=>'sysnews'),'member');
		$this->yunset('backurl',$backurl);
		$this->yunset('header_title',"系统消息");
		$this->waptpl('sxnews');
	}

	function attention_me_action(){
	    
	    $backurl=Url('wap',array('c'=>'sysnews'),'member');
	    $this->yunset('backurl',$backurl);

		$this->yunset('header_title',"对我感兴趣");
	    $this->waptpl('attention_me');
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

	    $backurl=Url('wap',array('c'=>'jobcolumn'),'member');
	    $this->yunset('backurl',$backurl);

		$this->yunset('header_title',"推荐给我的人才");
	    $this->waptpl('give_rebates');
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
	    $backurl=Url('wap',array('c'=>'jobcolumn'),'member');
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
		$this->yunset('headertitle',"悬赏详情");
		$this->get_user();
		$lietouM	=	$this -> MODEL('lietou');
		$data		=	$lietouM -> getRebatesInfo(array('id'=>intval($_GET['id'])),array('type'=>$_GET['type'],'show'=>1));

		$this->yunset("row",$data);

		$this->waptpl('rebates_info');
	}
	function save_give_rebates_action(){
		if($_POST){
			$data['reply']		=	$_POST['reply'];

			$data['reply_time']	=	time();

			$data['status']		=	"1";

			$where['id']		=	(int)$_POST['id'];

			$where['job_uid']	=	$this->uid;

			$this -> MODEL('lietou') -> upRebates($data,$where);

			$this -> MODEL('log') -> addMemberLog($this->uid,$this->usertype,"回复推荐给我的返利",18,1);

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
	//优惠券
	function coupon_list_action(){
	
		$this->yunset('header_title',"优惠卡券");
	    $this->waptpl('coupon_list');
	}

	//我的发票
	function invoice_action(){
	    
	    $backurl = Url('wap',array('c'=>'finance'),'member');
	    $this->yunset('backurl',$backurl);
		$this->yunset('header_title',"我的发票");
	    $this->waptpl('invoice');
	}

	function sqinvoice_action(){

	    $backurl = Url('wap',array('c'=>'finance'),'member');
	    $this->yunset('backurl',$backurl);
		$this->yunset('header_title',"发票索取");
	    $this->waptpl('invoice_apply');
	}

	function invoice_info_action(){
		
	    $backurl = Url('wap',array('c'=>'finance'),'member');
	    $this->yunset('backurl',$backurl);
		$this->yunset('header_title',"发票信息");
	    $this->waptpl('invoice_info');
	}

	function finance_action(){
        $reg_url =Url('wap',array('c'=>'register','uid'=>$this->uid));
        $this->yunset('reg_url', $reg_url);
		$backurl =	Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->yunset('header_title',"财务管理");
		$this->waptpl('finance');
	}
	function integral_action(){

		if($_GET['type']){
			$backurl	=	Url('wap',array('c'=>'finance'),'member');
		}else{
			$backurl	=	Url('wap',array(),'member');
		}

		$reg_url = Url('wap',array('c'=>'register','uid'=>$this->uid));
		$this->yunset('reg_url', $reg_url);
		$this->yunset('backurl',$backurl);
		$this->yunset('header_title',"全部任务");
		$this->waptpl('integral');
	}

	function resumecolumn_action(){

		$backurl=Url('wap',array(),'member');

		$this->yunset('backurl',$backurl);

		$this->yunset('header_title',"简历管理");

		$this->waptpl('resumecolumn');
	}

    function jobcolumn_action(){

		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
 		$this->yunset("header_title","其他服务");
		$this->waptpl('jobcolumn');
	}

	function integral_reduce_action(){
		$backurl	=	Url('wap',array('c'=>'integral'),'member');
		$this		->	yunset('backurl',$backurl);
		$this		->	yunset('header_title',"消费规则");
		$this		->	waptpl('integral_reduce');
	}

	function xjhadd_action(){
		$schoolM	=	$this -> MODEL('school');
		$companyM	=	$this -> MODEL('company');

		$company	=	$companyM -> getInfo($this->uid);
		if($_POST['submit']){
			$post	=	array(
				'provinceid' 	=>  $_POST['provinceid'],
				'cityid'    	=>  $_POST['cityid'],
				'schoolid'   	=>  $_POST['schoolid'],
				'address'  		=>  $_POST['address'],
				'uid'           =>	$this->uid,
				'status'		=>	0,
				'r_status'  	=>  $_POST['r_status']
			);
			$data	=	array(
				'post'		=>	$post,
				'id'		=>	$_POST['id'],
				'datetime'	=>	$_POST['datetime'],
				'stime'     =>  $_POST['stime'],
				'etime'     =>  $_POST['etime'],
			);
			$return	=	$schoolM -> addSchoolXjh($data);

			if($return['errcode']==9){
				$return['url']='index.php?c=xjh';
			}else{
				$return['url']=$_SERVER['HTTP_REFERER'];
			}
			echo json_encode($return);die;
		}

		$this->yunset($this->MODEL('cache')->GetCache(array('city')));

		$schoolList		= 	$schoolM->getSchoolAcademyList(1,array('field'=>'id,schoolname,cityid'));
		$school			  = 	$schoolList['list'];
		$this->yunset("school",$school);

		if($_GET['id']){

			$id			=	intval($_GET['id']);
			$row		=	$schoolM->getSchoolXjhInfo($id,array('uid'=>$this->uid));
            $where['provinceid']=   $row['info']['provinceid'];
            $where['cityid']    =   $row['info']['cityid'];
            $schooltwoList		  = 	$schoolM->getSchoolAcademyList($where,array('field'=>'id,schoolname,cityid'));
            $schooltwo			    = 	  $schooltwoList['list'];
            $this->yunset("school",$school);
			$this->yunset("row",$row['info']);
			$this->yunset("schooltwo",$schooltwo);
		}
		$backurl=Url('wap',array('c'=>'xjh'),'member');
		$this->yunset('company',$company);
		$this->yunset('backurl',$backurl);

		$this->yunset('header_title',"新增校招宣讲会");

		$this->waptpl('xjhadd');

	}
  function xjhcity_action(){
    $schoolM	=	$this -> MODEL('school');
    $id       = $_POST['id'];
    $row		  =	$schoolM->getSchoolXjhInfo($id,array('uid'=>$this->uid));
    $row      = $row['info'];
    if($row['provinceid'] ==  $_POST['provinceid'] && $row['cityid']==$_POST['cityid']){
      echo 1;die;
    }else{
      $where['provinceid']=   $_POST['provinceid'];
      $where['cityid']    =   $_POST['cityid'];
      $schoolList		      = 	$schoolM->getSchoolAcademyInfo($where);
      $school		          = 	$schoolList['info'];
      if($school){
        echo 2;die;
      }else{
        echo 3;die;
      }
    }

  }

	function banner_action(){

		$companyM	=	$this -> MODEL('company');

		if($_POST['submit']){

			$data			=	array(

				'base'	=>	$_POST['preview'],

				'uid'		=>	$this->uid,

				'usertype'	=>	$this->usertype

			);

			$row			 =	$companyM-> getBannerInfo('',array('where'=>array('uid'=>$this->uid)));

			if($row['id']){

				$data['type']='update';

			}else{

				$data['type']='add';

			}

			$return			 =	$companyM	->	setBanner($data);

		}

		$banner		=	$companyM-> getBannerInfo('',array('where'=>array('uid'=>$this->uid)));

		$backurl	=	Url('wap',array('c'=>'integral'),'member');

		$this->yunset("layer",$return);
		$this->yunset("banner",$banner);
		$this->yunset("backurl",$backurl);
		$this->yunset('header_title',"企业横幅");
		$this->waptpl('banner');
	}



	function usecard_action(){
	
		$backurl	=	Url('wap',array('c'=>'finance'),'member');
		$this		->	yunset('backurl',$backurl);
		$this		->	yunset('header_title',"充值卡充值");
		$this		->	waptpl('usecard');
	}

	function show_action(){

		$backurl = Url('wap',array('c'=>'set'),'member');
		$this->yunset('backurl',$backurl);
		$this->yunset('header_title',"企业环境");
		$this->waptpl('show');
	}
    // 面试评价列表
	function pl_action(){
		
		$this->yunset('header_title',"面试评价");
		$this->waptpl('pl');
	}

	/**
     * @desc 职位竞争力
     */
    function compete_action()
    {
        $this->yunset('header_title', '职位竞争力');
        $this->waptpl('compete');
    }

    /**
     * @desc 会员套餐、增值服务、单项购买页面
     */
    function server_action(){

        $this->yunset('header_title', '优选服务');
        $this->waptpl('server');
    }

	//好友助力
	function friendhelp_action(){

		$this->yunset('header_title',"好友助力");
		$this->waptpl('friendhelp');
	}

	function zphnet_action()
	{
	    
	    $backurl=Url('wap',array('c' => 'jobcolumn'),'member');
	    $this->yunset('backurl',$backurl);
	    $this->yunset("header_title","网络招聘会记录");
	    $this->waptpl('zphnet');
	}
	function spviewLog_action(){

	    $this->yunset("header_title","网络招聘会视频记录");
	    $this -> waptpl('splog');

	}
	/**
	 * 邀请模板列表
	 */
	function yqmb_action(){

		$backurl	=   Url('wap',array('c'=>'set'), 'member');
		$this -> yunset('backurl', $backurl);
		$this -> yunset('header_title', '管理邀请模板');
		$this -> waptpl('yqmb');
	}

	/**
	 * 创建邀请模板
	 */
	function yqmbedit_action(){

		$backurl	=   Url('wap',array('c' => 'yqmb'), 'member');
		$this -> yunset('backurl', $backurl);
		$this -> yunset('header_title', '创建修改模板');
		$this -> waptpl('yqmbedit');
	}
	
    function spview_action(){

		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this -> yunset('header_title', '视频面试管理');
    	$this -> waptpl('splist');
    }
    function spviewadd_action(){

    	$this -> yunset('header_title', '发布视频面试');
    	$this -> waptpl('spshow');
    }

	function spresume_action(){

		$backurl=Url('wap',array('c'=>'spview'),'member');
		$this->yunset('backurl',$backurl);

		$this->yunset('header_title',"预约面试");
		$this->waptpl('spresume');
	}
	//视频面试房间
	function sproom_action(){

	    if (empty($this->config['sy_spview_appkey']) || empty($this->config['sy_spview_appsecret'])){

	        $this->ACT_msg_wap('index.php', '网站未配置视频面试功能');
	    }
	    if (strpos($this->config['sy_weburl'], 'https') === false) {

	        $this->ACT_msg_wap('index.php', '网站未配置HTTPS，无法使用视频面试功能');
	    }

	    $id 		=	$_GET['id'];

	    $spviewM	=	$this->MODEL('spview');

	    $spview		=	$spviewM->getInfo(array('id'=>$id,'uid'=>$this->uid));

	    if(empty($spview)){

	        $this->ACT_msg_wap("index.php?c=spview","面试间不存在！");

	    }else if($spview['status']!=1){

	        $this->ACT_msg_wap("index.php?c=spview","面试间尚未通过审核！");

	    }else if($spview['roomstatus']==1){

	        $this->ACT_msg_wap("index.php?c=spview","面试间已关闭！");

	    }
	    $trtcM  =  $this->MODEL('trtc');
	    $trtc   =  $trtcM->getUserSig(array('uid'=>$this->uid, 'usertype'=>2));

	    if (!empty($trtc['errcode'])){

	        $this->ACT_msg_wap('index.php', $trtc['msg']);
	    }

	    $trtcConfig  =  array(
	        'userId'      =>  $trtc['wid'] .'_'.$this->uid,
	        'roomId'      =>  $trtc['roomid'],
	        'sdkAppId'    =>  $trtc['appid'],
	        'userSig'     =>  $trtc['usersig'],
	        'csRoomId'    =>  $trtc['csroomid'],
	        'spWait'      =>  $this->config['sy_spview_wait'] * 1,
	        'spLong'      =>  $this->config['sy_spview_time'] * 1
	    );

	    $this->yunset('trtcConfig',$trtcConfig);

	    $this->yunset('spview',$spview);

	    // 获取小程序原始ID
	    include(DATA_PATH.'api/wxpay/wxpay_data.php');
	    $this->yunset('wxpaydata',$wxpaydata);
	    if (is_weixin()){
	        // 拉取权限验证配置
	        if($this->config['wx_appid'] && $this->config['wx_appsecret']){
	            $signPackage = getWxJsSdk();
	            $this->yunset('signPackage',$signPackage);
	        }
	        $this->yunset('isweixin',1);
	    }

	    $this -> yuntpl(array('wap/chat/sproom'));
	}
	//获取面试列表和当前面试人信息
	function getLineData_action(){

	    $data = array(
	        'sid'	=>	$_POST['sid'],
	        'uid'	=>	$this->uid,
	        'nowuid'=>	$_POST['nowuid']
	    );

	    $spviewM	=	$this->MODEL('spview');

	    $res 		=	$spviewM->getLineData($data, 'wap');

	    echo json_encode($res);die;
	}
	/**
	 * 网络招聘会视频面试、普通单对单视频面试
	 */
	function webrtc_action(){

	    if (empty($this->config['sy_spview_appkey']) || empty($this->config['sy_spview_appsecret'])){

	        $this->ACT_msg_wap('index.php', '网站未配置视频面试功能');
	    }
	    if (strpos($this->config['sy_weburl'], 'https') === false) {

	        $this->ACT_msg_wap('index.php', '网站未配置HTTPS，无法使用视频面试功能');
	    }

	    $trtcM  =  $this->MODEL('trtc');
	    $trtc   =  $trtcM->getUserSig(array('uid'=>$this->uid, 'usertype'=>2));

	    if (!empty($trtc['errcode'])){

	        $this->ACT_msg_wap('index.php', $trtc['msg']);
	    }

	    $trtcConfig  =  array(
	        'userId'      =>  $trtc['wid'] .'_'.$this->uid,
	        'commentID'   =>  $_GET['fuid'],
	        'roomId'      =>  $trtc['roomid'],
	        'sdkAppId'    =>  $trtc['appid'],
	        'userSig'     =>  $trtc['usersig'],
	        'csRoomId'    =>  $trtc['csroomid'],
	        'spWait'      =>  $this->config['sy_spview_wait'] * 1,
	        'spLong'      =>  $this->config['sy_spview_time'] * 1
	    );

	    $this->yunset('trtcConfig',$trtcConfig);

	    // 获取小程序原始ID
	    include(DATA_PATH.'api/wxpay/wxpay_data.php');
	    $this->yunset('wxpaydata',$wxpaydata);
	    if (is_weixin()){
	        // 拉取权限验证配置
	        if($this->config['wx_appid'] && $this->config['wx_appsecret']){
	            $signPackage = getWxJsSdk();
	            $this->yunset('signPackage',$signPackage);
	        }
	        $this->yunset('isweixin',1);
	    }

	    $this -> yuntpl(array('wap/chat/webrtc'));
	}

    /**
     * 预约刷新
     */
    function reserveUp_action()
    {

        if ($_POST) {


            $jobM   =   $this->MODEL('job');

            $data   =   array(

                'job_id'    =>  $_POST['job_id'],
                'end_time'  =>  strtotime($_POST['end_time']),
                'interval'  =>  $_POST['interval'],
                'status'    =>  $_POST['status']
            );
            $return =   $jobM->reserveUpJob($data, array('uid' => $this->uid));

            echo json_encode($return);
            die;
        } else {

            echo json_encode(array('error' => 0, 'msg' => '参数错误'));
            die;
        }
    }

    function logout_action()
    {

        $backurl	=	Url('wap',array('c' => 'set'),'member');
        $this->yunset('backurl',$backurl);

        $this->yunset('header_title',"账号注销");
        $this->waptpl('logout');
    }

}

?>