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
class index_controller extends wap_controller{

	function waptpl($tpname)
	{
		$this->yuntpl(array('wap/member/user/'.$tpname));
	}

	function get_user()
	{
		$ResumeM   =  $this->MODEL('resume');
		$isresume  =  $ResumeM->getResumeInfo(array('uid'=>$this->uid));

		if (! $isresume['name']) {

		    $this->ACT_msg_wap(Url('wap', array('c' => 'info'), 'member'), '请先完善个人资料', 2, 3);
		}
	}
    //会员中心
	function index_action()
	{
		$this->cookie->SetCookie("exprefresh",'1',time() + 86400);

		$backurl  =  Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$resumeM		=	$this -> MODEL('resume');
		if ($this->config['sy_spview_web'] == 1){
		    $this -> cookie -> SetCookie("spview",'1',time() + 86400);
		}
		//判断我是否有简历
		$eData    =   array(
		    'field'   => '`lastupdate`,`jobstatus`,`id`,`name`'
		);
		$rlist  =  $resumeM -> getExpectByUid($this->uid,$eData);
        if($this -> config['resume_sx']==1  && $_COOKIE['amtype'] != '1'){//登录自动简历刷新,在后台配置、管理员登录的，不需要刷新

		    if($rlist['id']){
		        
		        $resumeM -> upInfo(array('id'=>$rlist['id'],'uid'=>$this->uid),array('eData'=>array('lastupdate'=>time())));
		        
		        $resumeM -> upResumeInfo(array('uid'=>$this->uid),array('rData'=>array('lastupdate'=>time()), 'port' => 2));
		    }
		}
		$this->yunset('membernav', 1);
		$this->waptpl('index');
	}
	// 不常用的服务，例如问答等
	function otherservice_action(){

        $backurl  =  Url('wap',array(),'member');
        $this->yunset('backurl',$backurl);
	    $this->yunset('headertitle','其他服务');
	    $this->waptpl('other_service');
	}
	//上传形象照
	function photo_action(){

	    $backurl  =  Url('wap',array(),'member');
	    $this->yunset('backurl',$backurl);
	    
	    $this->yunset('headertitle',"上传形象照");
	    $this->waptpl('photo');
	}
    //申请的职位
	function sq_action(){
		if(!isset($_GET['chat'])){
		    $backurl	=	Url('wap',array(),'member');
		    $this->yunset('backurl',$backurl);
		}
		$this->yunset('headertitle',"申请的职位");
		$this->waptpl('sq');
	}

    function partapply_action()
    {

        $backurl    =   Url('wap', array('c' => 'otherservice'), 'member');
        $this->yunset('backurl', $backurl);
        $this->yunset('headertitle', "兼职管理");
        $this->waptpl('partapply');
    }

	function collect_action(){

		$backurl	=	Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->yunset('headertitle',"收藏/关注");
		$this->waptpl('collect');
	}
	
	function password_action(){

		$this->yunset('backurl',Url('wap',array('c'=>'set'),'member'));

		$this->yunset('headertitle',"密码设置");
		$this->waptpl('password');
	}
	function invitecont_action(){

		$this -> yunset('headertitle',"面试详情");
		$this -> waptpl('invitecont');
	}

	function invite_action(){

		if(!isset($_GET['chat'])){
		    $backurl	=	Url('wap',array(),'member');
		    $this->yunset('backurl',$backurl);
		}

		$this->yunset('headertitle',"面试通知");
		$this->waptpl('invite');
	}
    // 谁看了我/我的足迹
	function look_action(){
        if(!isset($_GET['chat'])){
            $backurl	=	Url('wap',array(),'member');
            $this->yunset('backurl',$backurl);
        }
		$this->yunset('headertitle',"记录");
		$this->waptpl('look');
	}
	// 创建简历
	function addresume_action(){

	    $cacheM	=	$this->MODEL('cache');
	    $cache	=	$cacheM -> GetCache(array('city','job'));
	    
	    $this->yunset($cache);
	    $this->yunset('backurl',Url('wap',array(),'member'));
		$this->waptpl('addresume');
	}
    // 简历附表添加、修改
	function addresumeson_action(){

		switch($_GET['type']){

			case 'work':		$headertitle='工作经历';  break;
			case 'edu':			$headertitle='教育经历';  break;
			case 'project':		$headertitle='项目经历';  break;
			case 'training':	$headertitle='培训经历';  break;
			case 'skill':		$headertitle='职业技能';  break;
			case 'other':		$headertitle='其他信息';  break;
			case 'desc':		$headertitle='自我评价';  break;
			case 'show':		$headertitle='作品案例';  break;
			case 'doc':	        $headertitle='粘贴简历';  break;
		}
		$this->yunset('headertitle',$headertitle);
		$this->waptpl('addresumeson');
	}
	// 基本信息页面
	function info_action(){
		$this->yunset('headertitle',"基本信息");
 		$this->waptpl('info');
	}
	
    function addexpect_action()
    {
        $cacheM	=	$this->MODEL('cache');
        $cache	=	$cacheM -> GetCache(array('city','job'));
        
        $this -> yunset($cache);
        
		$this->yunset('headertitle','意向职位修改');
		$this->waptpl('addexpect');
	}
	function rcomplete_action(){
		$this->yunset('headertitle',"发布成功");
		$backurl	=	Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
        $this->yunset('url',Url('wap',array('c'=>'resume','a'=>'show','id'=>$_GET['id'])));
		$this->waptpl('rcomplete');
	}
	function resume_action(){

		$backurl		=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->yunset('headertitle',"我的简历");
		$this->waptpl('resume');
	}
	function optimize_action(){
        $this->yunset('headertitle',"优化简历");
        
        if (isset($_GET['add'])){
            $backurl  =  Url('wap',array(),'member');
            $this->yunset('backurl',$backurl);
        }

        $this->waptpl('optimize');
    }
	// 简历管理。设置顶部隐私显示cookie
	function setPrivacyCookie_action(){
	    $this->cookie->setcookie('privacy', 1, time() + 3600 * 6);
	}

	function binding_action()
	{

		$this->yunset('headertitle',"社交账号绑定");
		$this->yunset("backurl",Url('wap',array('c'=>'set'),'member'));
		$this->waptpl('binding');
	}
	function idcard_action(){
		$this->yunset('headertitle',"身份证认证");

		$backurl	=	Url('wap',array('c'=>'set'),'member');
		$this->yunset('backurl',$backurl);
		$this->waptpl('idcard');
	}
	function bindingbox_action(){
		switch($_GET['type']){
			case 'moblie':$headertitle="手机认证";
			break;
			case 'email':$headertitle="邮箱认证";
			break;
		}
		$this->yunset('headertitle',$headertitle);

		$backurl	=	Url('wap',array('c'=>'set'),'member');
		$this->yunset('backurl',$backurl);

		$this->waptpl('bindingbox');
	}
	function setname_action(){

		$backurl	=	Url('wap',array('c'=>'set'),'member');
		$this->yunset('backurl',$backurl);
		$this->yunset('headertitle',"修改用户名");
		$this->waptpl('setname');
	}
	function reward_list_action(){
		$this->yunset('headertitle',"兑换记录");
		if($_GET['back']){
			$backurl		=	Url('wap',array('c'=>'redeem'));
		}else{
			$backurl		=	Url('wap',array('c'=>'finance'),'member');
		}
		$this->yunset('backurl',$backurl);
		$this->waptpl('reward_list');
	}

	function privacy_action(){
		$this->yunset('headertitle',"隐私设置");

		$this->waptpl('privacy');
	}

	function getOrder_action(){

		if($_POST){

		    $M	=	$this->MODEL('userpay');

			$_POST['uid']		=	$this->uid;
			$_POST['usertype']	=	$this->usertype;
			$_POST['did']		=	$this->userdid;

			if ($_POST['paytype'] == 'wxpay'){
			    $_POST['paytype'] = 'wxh5';
			}

			if($_POST['server']=='zdresume'){

				$return = $M->buyZdresume($_POST);
				$msg="简历置顶";
			}elseif ($_POST['server']=='wtresume'){

				$return = $M->wtResume($_POST);
				$msg="委托简历";
			}

			if($return['order']['order_id'] && $return['order']['id']){

				$dingdan	= $return['order']['order_id'];
				$price 		= $return['order']['order_price'];
				$id 		= $return['order']['id'];

				$this ->MODEL('log')-> addMemberLog($this -> uid, $this->usertype,$msg.",订单ID".$dingdan,88,2);//会员日志

				$_POST['dingdan']		=	$dingdan;
				$_POST['dingdanname']	=	$dingdan;
				$_POST['alimoney']		=	$price;
				$data['msg']			=	"下单成功，请付款！";
				//多种支付方式并存 进行选择
				if($_POST['paytype']=='alipay'){

					$url	=	$this->config['sy_weburl'].'/api/wapalipay/alipayto.php?dingdan='.$dingdan.'&dingdanname='.$dingdan.'&alimoney='.$price;

				}elseif($_POST['paytype']=='wxh5'){

					$url	=	'index.php?c=wxpay&type=wxh5&id='.$id;
 				}

 				echo json_encode(array(
 				    'error' => 0,
 				    'url'   => $url,
 				    'msg'   =>  '下单成功，请付款！'
 				));

			}else{
			    echo json_encode(array(
			        'error' => 1,
			        'msg' => '提交失败，请重新提交订单！'
			    ));
			}
 		}else{
 		    echo json_encode(array(
 		        'error' => 1,
 		        'msg' => '参数错误，请重试！'
 		    ));

		}
	}

	function fav_subject_action(){
		$this->yunset('headertitle',"职业培训");
		$trainM			=	$this->MODEL('train');

		if($_GET['del']){
			$return		=	$trainM->delFavSub((int)$_GET['del'],array('uid'=>$this->uid,'usertype'=>$this->usertype));

			$this -> waplayer_msg($return['msg']);
		}

		$where['uid']		=	$this->uid;
		$where['usertype']	=	$this->usertype;

		//分页链接
		$urlarr['page']	=	'{{page}}';
		$urlarr['c']	=	$_GET['c'];
		$pageurl		=	Url('wap',$urlarr,'member');

		//提取分页
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('px_subject_collect',$where,$pageurl,$_GET['page']);

		//分页数大于0的情况下 执行列表查询
		if($pages['total'] > 0){

			$where['orderby']	=	'id,desc';

		    $where['limit']		=	$pages['limit'];

		    $List				=	$trainM->getFavSubList($where,array('scene'=>'detail'));

			$this->yunset("rows",$List);
		}
		$backurl	=	Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);

		$this->get_user();
		$this->waptpl('fav_subject');
	}
	function baoming_subject_action(){
		$this->yunset('headertitle',"职业培训");

		$trainM			=	$this->MODEL('train');

		if($_GET['del']){
			$return	=	$trainM -> delBm(array('id'=>$_GET['del']),array('usertype'=>$this->usertype,'uid'=>$this->uid));

			if($return['errcode']==9){

				$msg	=	'取消成功';
			}else{

				$msg	=	'取消失败';
			}
			$this -> waplayer_msg($msg);
		}

		$where['uid']		=	$this->uid;
		$where['usertype']	=	$this->usertype;

		$urlarr['page']	=	'{{page}}';

		$urlarr['c']	=	$_GET['c'];

		$pageurl		=	Url('wap',$urlarr,'member');

		$pageM			=	$this -> MODEL('page');

		$pages			=	$pageM -> pageList('px_baoming',$where,$pageurl,$_GET['page']);

		if($pages['total'] > 0){

			$where['orderby']	=	'id,desc';

		    $where['limit']		=	$pages['limit'];

		    $List				=	$trainM->getBmList($where,array('scene'=>'detail'));
			$this -> yunset("rows",$List);

		}

		include(CONFIG_PATH."db.data.php");
		$this -> yunset("arr_data",$arr_data);

		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);

		$this->get_user();
		$this->waptpl('baoming_subject');
	}

	function atn_teacher_action(){
		$this->yunset('headertitle',"职业培训");
		$atnM	=	$this->MODEL('atn');

		if($_GET['del']){
			$return	=	$atnM->delAtnAll(intval($_GET['del']),array('sc_usertype'=>4,'tid'=>intval($_GET['tid']),'uid'=>$this->uid,'usertype'=>$this->usertype));

			$this->waplayer_msg($return['msg']);
		}

		$where['uid']			=	$this->uid;
		$where['tid']			=	array('<>','');
		$where['sc_usertype']	=	'4';

		//分页链接
		$urlarr['page']	=	'{{page}}';
		$urlarr['c']	=	$_GET['c'];
		$pageurl		=	Url('wap',$urlarr,'member');

		//提取分页
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('atn',$where,$pageurl,$_GET['page']);

		//分页数大于0的情况下 执行列表查询
		if($pages['total'] > 0){


			$where['orderby']	=	'id,desc';

		    $where['limit']		=	$pages['limit'];

		    $List				=	$atnM->getatnList($where,array('utype'=>'antteacher','wap'=>1));

			$this->yunset("rows",$List);
		}
		$this->get_user();
		$this->waptpl('atn_teacher');
	}
	function pay_action(){
		$this->yunset('headertitle',"充值");
		$this->waptpl('pay');
	}

	function payment_action(){
		$orderM		=	$this->MODEL('companyorder');

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

		$this->get_user();
		$this->yunset('headertitle',"收银台");
		$this->waptpl('payment');
	}
	/**
	 * 生成订单
	 */
	function dingdan_action(){

		$data['price_int']	   =  intval($_POST['price_int']);
		$data['integralid']	   =  intval($_POST['integralid']);
		$data['uid']		   =  $this->uid;
		$data['did']		   =  $this->userdid;
		$data['usertype']	   =  $this->usertype;
		$data['paytype']	   =  $_POST['paytype'] == 'wxpay' ? 'wxh5' : $_POST['paytype'];
		$data['type']		   =  'wap';

		$orderM   =  $this->MODEL('companyorder');
		$return   =  $orderM->addComOrder($data);

		//微信支付、支付宝支付，跳转到相应的链接
		if($return['errcode'] == 9 && !empty($return['url'])){

			header('Location: '.$return['url']);exit();
		}else{
			$this->yunset("layer",$return);
		}

		$backurl  =  Url('wap',array(),'member');
		$this->get_user();
		$this->yunset('backurl',$backurl);
		$this->yunset('headertitle',"订单");

		$this->waptpl('pay');
	}

	function wxpay_action(){
	    
		$comorderM	=	$this->MODEL('companyorder');
        
		$data['source']   =  'user';
		$data['orderId']  =	 (int)$_GET['id'];

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

    function paylog_action(){
        $this->yunset('headertitle',"明细");
        $backurl	=	Url('wap',array('c'=>'finance'),'member');
        $this		->	yunset('backurl',$backurl);
        $this->waptpl('paylog');
    }

	function comment_action(){

	    $this->yunset('headertitle','面试评价');
	    $this->waptpl('comment');
	}
	function likejob_action(){

		$backurl	=	Url('wap',array('c'=>'resume','eid'=>$_GET['id']),'member');
		$this		->	yunset('backurl',$backurl);
		$this		->	yunset('headertitle',"匹配职位");

		$this		->	waptpl('likejob');
	}

	function loglist_action(){
		$this->yunset('headertitle',"赏金明细");

		$backurl	=	Url('wap',array('c'=>'finance'),'member');

		$this->yunset('backurl',$backurl);

		$this->waptpl('loglist');
	}
    /**
     * 赏金转换积分
     */
	function change_action(){
	    
		$backurl  =  Url('wap',array('c'=>'loglist'),'member');
		$this->yunset('backurl',$backurl);
		$this->yunset('headertitle',"赏金转换".$this->config['integral_pricename']);
  		$this->waptpl('change');
	}
	//提现
	function withdraw_action(){
		$this->yunset('headertitle',"提现");
		$backurl	=	Url('wap',array('c'=>'loglist'),'member');
		$this->yunset('backurl',$backurl);
		$this->waptpl('withdraw');
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

	function set_action(){
		$this->yunset('headertitle',"账户设置");
		
		$backurl	=	Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->waptpl('set');
	}
	function subject_zixun_action(){
		$this->yunset('headertitle',"职业培训");
		$trainM			=	$this->MODEL('train');

		$where['uid']		=	$this->uid;
		$where['usertype']	=	$this->usertype;

		//分页链接
		$urlarr['page']	=	'{{page}}';
		$urlarr['c']	=	$_GET['c'];
		$pageurl		=	Url('wap',$urlarr,'member');

		//提取分页
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('px_zixun',$where,$pageurl,$_GET['page']);

		//分页数大于0的情况下 执行列表查询
		if($pages['total'] > 0){

			$where['orderby']	=	'id,desc';

		    $where['limit']		=	$pages['limit'];

		    $List				=	$trainM->getPxzxList($where,array('utype'=>'zixun','wap'=>1));

			$this->yunset("rows",$List);
		}
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);

		$this->waptpl('subject_zixun');
	}

	function delsubject_zixun_action(){
		if($_GET['id']){
            $TrainM		=	$this->MODEL('train');
			$return		=	$TrainM -> delPxzx((int)$_GET['id'],array('uid'=>$this->uid,'usertype'=>$this->usertype));
			$this->layer_msg($return['msg']);
		}
	}

	function fav_agency_action(){
		$this->yunset('headertitle',"职业培训");
		$atnM					=	$this->MODEL('atn');

		$where['uid']			=	$this->uid;
		$where['tid']			=	'';
		$where['sc_usertype']	=	'4';

		//分页链接
		$urlarr['page']	=	'{{page}}';
		$urlarr['c']	=	$_GET['c'];
		$pageurl		=	Url('wap',$urlarr,'member');

		//提取分页
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('atn',$where,$pageurl,$_GET['page']);

		//分页数大于0的情况下 执行列表查询
		if($pages['total'] > 0){

			$where['orderby']	=	'id,desc';

		    $where['limit']		=	$pages['limit'];

			$List				=	$atnM->getatnList($where,array('utype'=>'antagency','wap'=>1));

			$this->yunset("rows",$List);
		}

		$backurl	=	Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);

		$this->waptpl('fav_agency');
	}

	function delagency_action(){
		if($_GET['id']){
			$atnM		=	$this->MODEL('atn');
			$return		=	$atnM->delAtnAll((int)$_GET['id'],array('sc_usertype'=>4,'uid'=>$this->uid,'usertype'=>$this->usertype));

			$this->waplayer_msg($return['msg']);
		}
	}

	function rebates_action(){
		$this->yunset('headertitle',"赏金职位");
		
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->waptpl('rebates');
	}

	function rebates_info_action(){

		$lietouM	=	$this -> MODEL('lietou');
		$data		=	$lietouM -> getRebatesInfo(array('id'=>intval($_GET['id'])),array('type'=>$_GET['type'],'show'=>1));

		$this->yunset("row",$data);

		$backurl	=	Url('wap',array('c'=>'rebates'),'member');
		$this->yunset('backurl',$backurl);

		$this->get_user();

		$this->yunset('headertitle',"悬赏详情");
		$this->waptpl('rebates_info');
	}

	function sysnews_action(){

		$this->yunset('headertitle',"消息");
		$this->waptpl('sysnews');

	}
	//私信
	function sxnews_action(){
		$this->yunset('headertitle',"系统消息");

		$backurl	=	Url('wap',array('c'=>'sysnews'),'member');
		$this->yunset('backurl',$backurl);
		$this->waptpl('sxnews');
	}

	function commsg_action(){
		$this->yunset('headertitle',"求职咨询");

		$backurl=Url('wap',array('c'=>'sysnews'),'member');
		$this->yunset('backurl',$backurl);
		$this->waptpl('commsg');
	}
	function finance_action(){

		$this->yunset('headertitle',"财务管理");
        $reg_url = Url('wap',array('c'=>'register','uid'=>$this->uid));
        $this->yunset('reg_url', $reg_url);
		$backurl	=	Url('wap',array(),'member');

		$this->yunset('backurl',$backurl);
		$this->waptpl('finance');
	}
	function integral_action(){
        $this->yunset('headertitle',"全部任务");
        $reg_url = Url('wap',array('c'=>'register','uid'=>$this->uid));
        $this->yunset('reg_url', $reg_url);
        $this->waptpl('alltask');
    }

    function blacklist_action()
    {

        $backurl	=	Url('wap',array(),'member');

        $this->yunset('backurl',$backurl);
        $this->yunset('headertitle', '屏蔽企业');
        $this->waptpl('blacklist');
    }
	function blacklistadd_action(){

		$this->yunset('headertitle',"添加屏蔽");
        $backurl	=	Url('wap',array('c'=>'blacklist'),'member');

        $this->yunset('backurl',$backurl);
		$this->waptpl('blacklistadd');
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

            $data['base']	=	$_POST['preview'];

			$M				=	$this->MODEL('pack');
			$data['port']	=	'2';
			$return			=  $M->logStatus((int)$_POST['rewardid'],26,$this->uid,'1',$data);

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


	function getStatis($type=''){
		$statisM  	= 	$this->MODEL('statis');

		$statis		= 	$statisM->getInfo($this->uid,array('usertype'=>1));

		if($type=='finance'){
			$orderM		=	$this->MODEL('companyorder');
			$orders		=	$orderM->getPayList(array('com_id'=>$this->uid, 'usertype' =>$this->usertype, 'type'=>'1'),array('field'=>'`order_price`'));
            $allprice   =   0;
            foreach($orders as $key=>$val){
				$allprice	+=	$val['order_price'];
			}
			if($allprice<0){
				$statis['allprice']		=	number_format(str_replace('-','', $allprice));
			}else{
				$statis['allprice']		=	'0';
			}

			$statis['freeze'] = sprintf("%.2f", $statis['freeze']);
		}

		if($type=='loglist'){
			$statis['freeze'] = sprintf("%.2f", $statis['freeze']);
		}

		$this->yunset("statis",$statis);
	}

	function transfer_action(){
		$this->yunset('headertitle',"账户分离");
		$this->waptpl('transfer');
	}
    // 视频面试预约列表
	function spview_action(){


		$backurl	=	Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);

		$this->get_user();

		$this->yunset('headertitle',"视频面试");
		$this->waptpl('spview');
	}
	// 视频面试房间
	function sproom_action(){
	    
	    if (empty($this->config['sy_spview_appkey']) || empty($this->config['sy_spview_appsecret'])){
	        
	        $this->ACT_msg_wap('index.php', '网站未配置视频面试功能');
	    }
	    if (strpos($this->config['sy_weburl'], 'https') === false) {
	        
	        $this->ACT_msg_wap('index.php', '网站未配置HTTPS，无法使用视频面试功能');
	    }
	    
	    $id 		=	$_GET['id'];
	    
	    $spviewM	=	$this->MODEL('spview');
	    
	    $spview		=	$spviewM->getInfo(array('id'=>$id));
	    
	    $CompanyM			 =  $this -> MODEL('company');
	    $company     		 =  $CompanyM -> getInfo($spview['uid'], array('field'=>'`name`,`logo`,`logo_status`,`provinceid`,`cityid`,`hy`,`mun`,`content`,`address`','logo' => '1'));
	    $company['content']  =  mb_substr(strip_tags($company['content']), 0, 300);
	    
	    $jobM				 =  $this -> MODEL('job');
	    $job                 =  $jobM -> getInfo(array('id'=>$spview['jobid']));
	    $job['description']  =  mb_substr(strip_tags($job['description']), 0, 200);
	    
	    $subnum   =  $spviewM->getSubNum(array('sid'=>$id));
	    $linenum  =  $spviewM->getSubNum(array('sid'=>$id,'status'=>0,'rtime'=>array('>',0)));
	    $msnum    =  $spviewM->getSubNum(array('sid'=>$id,'status'=>2));
	    
	    $this->yunset(array('company'=>$company,'job'=>$job,'subnum'=>$subnum,'linenum'=>$linenum,'msnum'=>$msnum));
	    
	    $trtcM  =  $this->MODEL('trtc');
	    $trtc   =  $trtcM->getUserSig(array('uid'=>$this->uid, 'fuid'=>$spview['uid'],'usertype'=>1));
	    
	    if (!empty($trtc['errcode'])){
	        
	        $this->ACT_msg_wap('index.php', $trtc['msg']);
	    }
	    
	    $trtcConfig  =  array(
	        'userId'      =>  $trtc['wid'] .'_'.$this->uid,
	        'commentID'   =>  $spview['uid'],
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
	/*
	 * 网络招聘会视频面试、普通单对单视频面试
	 */
	function webrtc_action(){
	    
	    if (empty($this->config['sy_spview_appkey']) || empty($this->config['sy_spview_appsecret'])){
	        
	        $this->ACT_msg_wap('index.php', '网站未配置视频面试功能');
	    }
        if (strpos($this->config['sy_weburl'], 'https') === false) {

            $this->ACT_msg_wap('index.php', '网站未配置HTTPS，无法使用视频面试功能');
        }
	    
	    $CompanyM			 =  $this -> MODEL('company');
	    $company     		 =  $CompanyM->getInfo($_GET['fuid'], array('field'=>'`name`,`logo`,`logo_status`,`provinceid`,`cityid`,`hy`,`mun`,`content`,`address`','logo' => '1'));
	    $company['content']  =  mb_substr(strip_tags($company['content']), 0, 300);
	    
	    $this->yunset('company',$company);
	    
	    $trtcM  =  $this->MODEL('trtc');
	    $trtc   =  $trtcM->getUserSig(array('uid'=>$this->uid,'usertype'=>1,'fuid'=>$_GET['fuid']));
	    
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
	// 视频面试预约列表
	function xjhLive_action(){


		$backurl	=	Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);

		$this->yunset('headertitle',"直播宣讲会");
		$this->waptpl('xjhlive');
	}

	function logout_action()
    {

        $backurl	=	Url('wap',array('c' => 'set'),'member');
        $this->yunset('backurl',$backurl);

        $this->yunset('headertitle',"账号注销");
        $this->waptpl('logout');
    }
}
?>