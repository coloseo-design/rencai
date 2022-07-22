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
class index_controller extends wxapp_controller{
    /**
     * 首页
     */
    function index_action()
    {
        $time       = time();
        $firstHome  = $_POST['firstHome'];
        $data       = array();
        $navurl     = array();
        $navsort    = array();
        $gy         = array();

        if ($firstHome == 1){
            //首页自定义设置
            include(DATA_PATH.'api/wxapp/tplapp.cache.php');
            include(DATA_PATH.'api/wxapp/tplappmodel.cache.php');

            foreach($tplappmodel as $uk=>$uv){
                $navurl[$uv['id']] = $uv['url'];
            }
            //导航
            include_once(CONFIG_PATH.'db.data.php');
            $zphnet_web   =  isset($arr_data['modelconfig']['zphnet']) && isset($this->config['sy_zphnet_web']) ? $this->config['sy_zphnet_web'] : 2;
            $spview_web   =  isset($arr_data['modelconfig']['spview']) && isset($this->config['sy_spview_web']) ? $this->config['sy_spview_web'] : 2;
            if ($this->platform == 'ios' && $_POST['provider'] == 'app'){
                // IOS APP 不支持视频面试
                $spview_web = 2;
            }
            $xjhlive_web  =  isset($arr_data['modelconfig']['xjhlive']) && isset($this->config['sy_xjhlive_web']) ? $this->config['sy_xjhlive_web'] : 2;
            // 是否是小程序端
            if ($_POST['provider'] == 'weixin' || $_POST['provider'] == 'baidu' || $_POST['provider'] == 'toutiao'){
                $is_mini = true;
            }else{
                $is_mini = false;
            }
            foreach ($nav as $nk => $nv) {
                if ($this->config['sy_iospay'] == 2 && ($nv['url']=='14'||$nv['url']=='8')){
                    unset($nav[$nk]);
                }elseif ($is_mini && ($nv['url']=='8' || $nv['url']=='14')){
                    // 小程序内屏蔽赏金职位、红包职位
                    unset($nav[$nk]);
                }elseif ($zphnet_web == 2 && $nv['url']=='18'){
                    // 网络招聘会模块未开启，需屏蔽
                    unset($nav[$nk]);
                }elseif (($xjhlive_web == 2 || $_POST['provider'] == 'baidu' || $_POST['provider'] == 'toutiao') && $nv['url']=='19'){
                    // 直播宣讲会模块未开启，需屏蔽。百度小程序、头条小程序不支持观看直播
                    unset($nav[$nk]);
                }elseif (($spview_web == 2 || $_POST['provider'] == 'baidu' || $_POST['provider'] == 'toutiao') && $nv['url']=='20'){
                    // 视频面试模块未开启，需屏蔽。百度小程序、头条小程序不支持视频面试
                    unset($nav[$nk]);
                }else{
                    if($nv['display']!=1){
                        unset($nav[$nk]);
                    }else{
                        $nav[$nk]['url']	 =	$navurl[$nv['url']];
                        $nav[$nk]['pic']	 =	checkpic($nv['pic']);
                        $navsort[]  =  $nv['navsort'];
                    }
                }
            }

            array_multisort($navsort,SORT_ASC,SORT_NUMERIC,$nav);
            $navarr			 =	array_chunk($nav,4);
            $data['navArr']	 =	$navarr;
            if (!empty($navarr)){
                $tplapp['nav']  =  '1';
            }else{
                $tplapp['nav']  =  '2';
            }
            $data['tplapp']	 	 =	$tplapp;

            $data['diysort']	 =	@explode(',',$tplapp['sort']);

            $data['contact'] = 0;
            if ($tplapp['cshow'] == '1'){
                $data['contact'] = 1;
            }
            //首页自定义关于我们等
            if ($tplapp['private'] == '1'){
                $gy[] = array('name'=>$tplappgy[1]['name'],'url'=>$tplappgy[1]['url']);
            }
            if ($tplapp['advice'] == '1'){
                $gy[] = array('name'=>$tplappgy[2]['name'],'url'=>$tplappgy[2]['url']);
            }
            if ($tplapp['advice'] == '1'){
                $gy[] = array('name'=>$tplappgy[3]['name'],'url'=>$tplappgy[3]['url']);
            }
            $data['gy']  =  $gy;

            $data['webname']  =  $this->config['sy_webname'];
            if (!empty($this->config['sy_wapdomain'])){
                $data['wapurl']  =  $this->config['sy_wapdomain'];
            }
            // 根据职位是否为最后一项，判断是否可以上拉加载
            $data['joblast'] = $this->isJobShowLast($tplapp);
        }
        // 默认分站
        $data['indexcity']  =  $this->config['sy_web_site'] == 1 ? $this->config['sy_indexcity'] : '';
	    // 小程序用seo
        if (isset($_POST['provider'])){
            if ($_POST['provider'] == 'baidu' || $_POST['provider'] == 'weixin' || $_POST['provider'] == 'toutiao'){
                $seo            =  $this->seo('index','','','',false, true);
                $data['seo']    =  $seo;
            }
	    }
        $this->render_json(0,'ok',$data);
    }
    // 首页其他内容处理
    function homeOther_action()
    {
        include(DATA_PATH.'api/wxapp/tplapp.cache.php');
        // 处理分站查询条件
        if (!empty($_POST['did'])){

            $domain  =  $this->getDomain($_POST['did']);
        }

        $time  =  time();
        include_once(PLUS_PATH.'pimg_cache.php');
        // 广告
        if($tplapp['membershow']=='1'){
            $adid   = $tplapp['hdid'] ? $tplapp['hdid'] : 50;
            $did    = isset($_POST['did']) ? $_POST['did'] : 0;
            $adpics = $this->getPimg($ad_label[$adid], $did, $_POST);
            $data['ad']  =  $adpics;
        }
        // 广告
        if($tplapp['adshow']=='1'){
            $classId = !empty($tplapp['adhdid']) ? $tplapp['adhdid'] : 503;
            $did     = isset($_POST['did']) ? $_POST['did'] : 0;
            $banner = $this->getPimg($ad_label[$classId], $did, $_POST);

            $random = isset($_POST['random']) ? $_POST['random'] : 0; // 判断是否取随机条数
            if ($random && count($banner) > $random) {
                if ($adpics && $random) {
                    $banner = $this->randomArr($banner, $random);
                }
            }

            $data['adBanner']  =  $banner;
        }

        // 小程序首页弹出广告
        $ejectid   = isset($_POST['eject_id']) ? $_POST['eject_id'] : 502;
        $did       = isset($_POST['did']) ? $_POST['did'] : 0;

        $ejectBanner = $this->getPimg($ad_label[$ejectid], $did, $_POST);
        $data['ejectBanner']  =  $ejectBanner;

        // 搜索关键字
        $key_name  = array();
        if ($tplapp['searchshow'] == 1){

            $hotKeyM  =  $this->MODEL('hotkey');
            $rows = $hotKeyM->getList(array('type'=>3,'limit'=>20,'orderby'=>'num'),array('field'=>'`key_name`'));

            foreach($rows as $k=>$v) {
                $key_name[]  =  $v['key_name'];
            }
        }
        $data['hotkey'] = $key_name;
        // 公告
        $ggList  = array();
        if ($tplapp['notice'] == 1){

            $ggM    =  $this->MODEL('announcement');

            if (!empty($_POST['did'])){
                $gwhere['did']  =  $_POST['did'];
            }
            //公告开始时间
            $gwhere['PHPYUNBTWSTART_A'] = array();
            $gwhere['startime'][]  =  array('<=',$time,'OR');
            $gwhere['startime'][]  =  array('=',0,'OR');
            $gwhere['startime'][]  =  array('isnull','','OR');
            $gwhere['PHPYUNBTWEND_A'] = array();

            $gwhere['PHPYUNBTWSTART_B'] = array();
            $gwhere['endtime'][]  =  array('>',$time,'AND');
            $gwhere['endtime'][]  =  array('=',0,'OR');
            $gwhere['endtime'][]  =  array('isnull','','OR');
            $gwhere['PHPYUNBTWEND_B'] = array();

            $gwhere['limit']    =  5;
            $gwhere['orderby']  =  'startime,desc';

            $gg  =  $ggM->getList($gwhere,array('field'=>'`id`,`title`,`startime`,`datetime`','utype'=>'wxapp'));

            if (!empty($gg['list'])){
                $ggList =   $gg['list'];
            }
        }
        $data['ggList'] =   $ggList;
        //首页名企
        if ($tplapp['hotcom'] == '1') {

            $companyM   =   $this->MODEL('company');

            if (!empty($_POST['did'])) {

                if (isset($domain['provinceid']) && !empty($domain['provinceid'])) {
                    $hotcomwhere['provinceid']  =   $domain['provinceid'];
                }
                if (isset($domain['cityid']) && !empty($domain['cityid'])) {
                    $hotcomwhere['cityid']      =   $domain['cityid'];
                }
                if (isset($domain['three_cityid']) && !empty($domain['three_cityid'])) {
                    $hotcomwhere['three_cityid']=   $domain['three_cityid'];
                }
                if (isset($domain['hyclass']) && !empty($domain['hyclass'])) {
                    $hotcomwhere['hy']          =   $domain['hyclass'];
                }
            }

            $hotcomwhere['hottime']     =   array('>', $time);
            $hotcomwhere['r_status']    =   1;

            $hcom                       =   $companyM->getChCompanyList($hotcomwhere, array('field' => '`uid`'));

            if (!empty($hcom)) {
                foreach ($hcom as $v) {
                    $hcuid[]    =   $v['uid'];
                }
                $hcwhere['uid'] =   array('in', pylode(',', $hcuid));
                $hcwhere['time_start']  =   array('<', $time);
                $hcwhere['time_end']    =   array('>', $time);
                $hcwhere['orderby']     =   'sort';
                $hcwhere['limit']       =   $tplapp['hotcomnum'] ? $tplapp['hotcomnum'] : 10;

                $hotcom = $companyM->getHotJobList($hcwhere, array('utype' => 'wxapp', 'field' => '`uid`,`hot_pic`'));
            }else{
                $hotcom = array();
            }
        }

        $data['comlist']    =  count($hotcom) > 0 ? $hotcom : array();
        //首页自定义招聘会
        if($tplapp['zphshow']=='1'){

            $zphM   =  $this->MODEL('zph');
            $zphone =  $zphM->getInfo(array('unix_timestamp(`endtime`)'=>array('>',$time)),array('field'=>'`id`'));

            $field  =  '`id`,`title`,`starttime`,`endtime`,`address`';

            $zwhere =   array();

            if (!empty($zphone)){
                $field  .=  ',CASE WHEN unix_timestamp(`endtime`)>'.$time.' THEN unix_timestamp(`starttime`)';
                $field  .=  ' WHEN unix_timestamp(`endtime`)<'.$time.' THEN -1*unix_timestamp(`starttime`) END AS `zph_px`';

                $zwhere['orderby'] .=  ' CASE WHEN unix_timestamp(`starttime`)<"'.$time.'" AND unix_timestamp(`endtime`)>"'.$time.'" THEN 0';
                $zwhere['orderby'] .=  ' WHEN unix_timestamp(`starttime`)>"'.$time.'" THEN 1';
                $zwhere['orderby'] .=  ' WHEN unix_timestamp(`endtime`)<"'.$time.'" THEN 2';
                $zwhere['orderby'] .=  ' END,`zph_px` ASC';
            }else{

                $zwhere['orderby'] .=  'unix_timestamp(`starttime`)';
            }
            if (!empty($_POST['did'])){
                $zwhere['did']  =  $_POST['did'];
            }
            $zwhere['is_open'] = 1;
            $zwhere['limit'] 	=  $tplapp['zphnum'] ? $tplapp['zphnum']:5;

            $zphrows        =  $zphM -> getList($zwhere, array('field'=>$field));
        }
        $data['zphlist']    =  count($zphrows)>0 ? $zphrows : array();
        //首页自定义资讯
        if($tplapp['articleshow']=='1'){

            if ($tplapp['articletype']=='1' || $tplapp['articletype']=='2') {//app首页自定义-咨询类型如果是图文则只查询有图的
                $awhere['newsphoto']   =  array('<>','');
            }

            if (!empty($_POST['did'])){
                $awhere['did']  =  $_POST['did'];
            }
            //新闻资讯开始时间
            $awhere['PHPYUNBTWSTART_A'] = array();
            $awhere['starttime'][]  =  array('<=',$time,'OR');
            $awhere['starttime'][]  =  array('=',0,'OR');
            $awhere['starttime'][]  =  array('isnull','','OR');
            $awhere['PHPYUNBTWEND_A'] = array();
            //结束时间
            $awhere['PHPYUNBTWSTART_B'] = array();
            $awhere['endtime'][]  =  array('>',$time,'AND');
            $awhere['endtime'][]  =  array('=',0,'OR');
            $awhere['endtime'][]  =  array('isnull','','OR');
            $awhere['PHPYUNBTWEND_B'] = array();

            $awhere['orderby']  =  'starttime,desc';

            $awhere['limit']  =  $tplapp['articlenum'] ? $tplapp['articlenum']:5;

            $articleM     =  $this->MODEL('article');
            $articlerows  =  $articleM->getList($awhere,array('field'=>'`id`,`title`,`newsphoto`,`description`'));
        }
        $data['articlelist']    =  count($articlerows['list'])>0 ? $articlerows['list'] :array();

        $data['qqdt']     =  !empty($this->config['sy_qqdt']) ? $this->config['sy_qqdt'] : 2;
        $data['wxlogin']  =  !empty($this->config['sy_app_wxlogin']) ? $this->config['sy_app_wxlogin'] : 2;
        $data['qqlogin']  =  !empty($this->config['sy_app_qqlogin']) ? $this->config['sy_app_qqlogin'] : 2;
        $data['kfurl']    =  $tplapp['kfurl'] ? $tplapp['kfurl'] :  '';
        $data['kfcomid']  =  $tplapp['kfcomid'] ? $tplapp['kfcomid'] :  '';
        $data['app_wxkf'] =  !empty($this->config['sy_app_wxkf']) ? $this->config['sy_app_wxkf'] : 2;
        // 微信小程序视频号id
        if ($_POST['provider'] == 'weixin'){
            include(DATA_PATH.'api/wxpay/wxpay_data.php');
            if (!empty($wxpaydata['sy_sphid'])){
                $data['sphid'] = $wxpaydata['sy_sphid'];
            }
        }

        $this->render_json(0,'ok',$data);
    }

    function getPimg($adArr = array(), $did = 0, $post = []){

        $time  =  time();
        $adpics =   array();

        if (!empty($adArr)){
            foreach ($adArr as $v){
                // 图片广告、没过期、全站使用或者与分站对应
                if($v['type']=='pic' && $v['start']<$time && $v['end']>$time && ($v['did'] == -1 || $v['did'] == $did)){
                    if (isset($post['appad'])){
                        $appad['src']  =  $v['pic'];
                        if (!empty($v['appurl'])){
                            // 处理跳转链接路径，开头没有/的，加上/
                            $appad['appurl']  =  stripos($v['appurl'],'/') == 0 ? $v['appurl'] : '/'.$v['appurl'];
                        }else{
                            $appad['appurl']  =  '';
                        }
                    }else{
                        $appad = $v['pic'];
                    }
                    $adpics[]  =  $appad;
                }
            }
        }

        return $adpics;
    }
    // 底部导航查询
    function getFoot_action()
    {
        include(DATA_PATH.'api/wxapp/tplapp.cache.php');
    	// 消息
        if (!empty($_POST['uid']) && !empty($_POST['token'])){

            $member   =  $this->yzToken($_POST['uid'], $_POST['token']);
            $msgNumM  =  $this->MODEL('msgNum');
            $msg      =  $msgNumM->getmsgNum($member['uid'],$member['usertype'],array('from' => 'wxapp'));
            $sysnum   =  $msg['msgNum'];

            if($member['usertype']==2 && $_POST['couponOT']){//查询即将过期的优惠券
                $couponM        =   $this -> MODEL('coupon');
                $couponNum      =   $couponM->getCouponNum(
                    array(
                        'uid'       => $member['uid'],
                        'status'    => 1,
                        'validity'  => array(array('>', time(),'AND'),array('<', strtotime('+ '.$this->config['sy_couponday'].' days'),'AND'))
                    )
                );
            }
            if (isset($this -> config['sy_chat_open'])){
                if ($this -> config['sy_chat_open'] == 1){

                    $chatM  =  $this->MODEL('chat');
                    $chat   =  $chatM->userinfo(array('uid'=>$member['uid'],'usertype'=>$member['usertype']));

                    $data['mine']      =  $chat['mine'];
                    $data['yuntoken']  =  $chatM->chatToken($member['uid']);
                }
            }
            if($this -> config['sy_iospay']=='2'){
            	$sysnum -=$msg['jobpackNum'];
            }

        }else{
            $sysnum   =  0;
        }
        if($_POST['firstFoot']=='1'){
        	foreach ($footnav as $k=>$v){
        	    $arr = explode(',', $v['pic']);
        	    $footnav[$k]['pic'] = checkpic($arr[0]);
        	    if (count($arr) > 1){
        	        $footnav[$k]['curpic'] = checkpic($arr[1]);
        	    }
		    }
		    $footnav = count($footnav) ? $footnav : array();

	        $data['footnav']  =  $footnav;
        }
        $data['iosfk']    =  isset($this->config['sy_iospay']) ? $this->config['sy_iospay'] : 2;
        $data['fkstr']    =  array('fkal'=>'支付宝','fkwx'=>'微信支付');
        $data['sysnum']   =  $sysnum;
        $data['couponNum']=  $couponNum ? $couponNum : 0;
        $this->render_json(0,'',$data);
    }
	/**
	 * 身份切换申请相关数据获取和校验
	 */
    function applytype_action(){
        $user           =   $this->yzToken((int)$_POST['uid'],$_POST['token']);
        $memberM        =   $this -> MODEL('userinfo');
        $uid            =   $user['uid'];
        $usertype       =   $user['usertype'];

        $applyusertype  =   $usertype==1 ? 2 : 1;

        $applyContent   =   trim($_POST['applyContent']) ? trim($_POST['applyContent']) : '';

        $res            =   $memberM->checkChangeApply($uid,$applyusertype,$applyContent);

        $wxqcode        =   checkpic($this->config['sy_wx_qcode']);

        if($res['errcode']==6){

            $res['errcode']  =   2;

        }

        $data           =   array(
            'msg'       =>  $res['msg'],
            'errcode'   =>  $res['errcode'],
            'user'      =>  !empty($res['user']) ? $res['user'] :array(),
            'wxqcode'   =>  $wxqcode,
            'webtel'    =>  $this->config['sy_freewebtel']
        );

        $this           ->  render_json(0,'',$data);
    }

    /**
     * 意见反馈
     */
    function advice_action(){

        $data       =   array(
            'webtel'  =>  $this->config['sy_freewebtel'],

        );

        $user           =   $this->yzToken((int)$_POST['uid'],$_POST['token']);
        if($user['uid']){
            $userinfoM  = $this->MODEL('userinfo');
            $meminfo    = $userinfoM->getUserInfo(array('uid'=>$user['uid']),array('usertype'=>$user['usertype']));
            $username = $mobile = '';
            if($user['usertype']==1){
                $username = $meminfo['name'];
                $mobile = $meminfo['telphone'];
            }else if($user['usertype']==2){
                $username = $meminfo['name'];
                $mobile = $meminfo['linktel'];
            }else if($user['usertype']==3){
                $username = $meminfo['realname'];
                $mobile = $meminfo['moblie'];
            }else if($user['usertype']==4){
                $username = $meminfo['name'];
                $mobile = $meminfo['linktel'];
            }
            $data['advice_name'] = $username;
            $data['advice_mobile'] = $mobile;
        }

        $data['sy_advice_mobilecode'] = $this->config['sy_advice_mobilecode'];
        $data['sy_msg_isopen'] = $this->config['sy_msg_isopen'];
        $data['sy_msg_cert'] = $this->config['sy_msg_cert'];

        $this->render_json(1,'',$data);
    }

    /**
     * 意见反馈-发送动态码
     */
    function sendAdviceMsg_action()
    {
        $moblie			=		$_POST['moblie'];

        $this->checkMcsdk($moblie);

        $noticeM        =       $this->MODEL('notice');

        $port   =   $this->plat == 'mini' ? '3' : '4';  // 短信发送端口$port : 3-小程序  4-APP
        $result =   $noticeM->sendCode($moblie, 'cert', $port,array(), 6, 90, 'msg');
        if($result['error']==1){
            $errcode    =   1;
        }else{
            $errcode    =   2;
            $msg        =   $result['msg'];
        }
        $this->render_json($errcode,$msg);
    }
	/**
	 * 意见反馈-保存
	 */
	function saveadvice_action()
	{
		$data		=	array(
			'username'	=>	$_POST['username'],
			'infotype'	=>	$_POST['infotype'],
			'content'	=>	$_POST['content'],
			'mobile'	=>	$_POST['mobile'],
            'advice_code'=> $_POST['code'],
			'utype'		=>	'wxapp'
		);
		$adviceM	=	$this->MODEL('advice');
		$return		=	$adviceM->addInfo($data);
		if($return['errcode'] == 9){
			$errcode	=	1;
		}else{
			$errcode	=	2;
		}
		$this->render_json($errcode,$return['msg']);
	}
	/**
	 * 首页首次进入app提示
	 */
	function getXybox_action()
	{
	    include(DATA_PATH.'api/wxapp/app.config.php');

	    $data['title']    =  $appconfig['xyboxtitle'];
	    $data['content']  =  $appconfig['xyboxcontent'];

	    $this->render_json(0, 'ok', $data);
	}
	/**
	 * app退出登录，清除推送标识
	 */
	public function tc_action(){
	    $userInfoM  =  $this->MODEL('userinfo');
	    $userInfoM -> upInfo(array('uid'=>intval($_POST['uid'])), array('clientid'=>'','deviceToken'=>''));
	    $this->render_json(0, 'ok');
	}

    //小程序我的 查询广告位
    public function getAd_action()
    {
        $flag = isset($_POST['flag']) ? $_POST['flag'] : '';
        $flagArray = [
            'resume'      => 505,
            'job'         => 504,
            'user_center' => 500,
            'com_center'  => 501
        ];
        if ($flag && isset($flagArray[$flag])) {
            $adid = $flagArray[$flag];
        } else {
            $adid           =  (int)$_POST['class_id'];
        }

        include PLUS_PATH.'pimg_cache.php';
        $adpics =   array();

        $time  =  time();
        foreach ($ad_label[$adid] as $k=>$v){
            // 图片广告、没过期、全站使用或者与分站对应
            if($v['type']=='pic' && $v['start']<$time && $v['end']>$time){
                if (isset($_POST['appad'])){
                    $appad['pic_url']  =  $v['pic'];
                    if (!empty($v['appurl'])){
                        // 处理跳转链接路径，开头没有/的，加上/
                        $appad['appurl']  =  stripos($v['appurl'],'/') == 0 ? $v['appurl'] : '/'.$v['appurl'];
                    }else{
                        $appad['appurl']  =  '';
                    }
                }else{
                    $appad = $v['pic'];
                }

                $adpics[]  =  $appad;
            }
        }

        $random = isset($_POST['random']) ? $_POST['random'] : 0; // 判断是否取随机条数
        if ($adpics && $random) {
            $adpics = $this->randomArr($adpics, $random);
        }
        $data['list']  =  $adpics;

        $this -> render_json(0, 'ok', $data);
    }
    /**
     * 职位列表是否显示且在自定义排序最下方
     */
    function isJobShowLast($tplapp){
        $customizeSort = array();// 自定义模板排序
        if (isset($tplapp)) {
            $rt = 1;
            if ($tplapp['job'] != 1) {// 隐藏职位列表
                $rt = 0;
            } else {// 职位列表为显示状态
                if ($tplapp['sort']) {
                    $sort = explode(',', $tplapp['sort']);
                } else {
                    $sort = 'search,member,nav,notice,login,hotcom,ad,job,zph,article,connect,foot';
                    $sort = explode(',', $sort);
                }
                foreach ($sort as $v) {
                    in_array($v, ['hotcom', 'login', 'ad', 'job', 'zph', 'article']) && array_push($customizeSort, $v);
                }
                $jobIndex = array_search('job', $customizeSort);
                $showAble = array('hotcom' => 'hotcom', 'login' => 'login', 'ad' => 'adshow', 'job' => 'job', 'zph' => 'zphshow', 'article' => 'articleshow');
                if ($jobIndex < 5) {// 职位列表非最后一个
                    for($i = $jobIndex + 1; $i < count($customizeSort); $i++){
                        if ($tplapp[$showAble[$customizeSort[$i]]] == 1) {// 职位列表后有其他显示项
                            $rt = 0;
                            break;
                        }
                    }
                }
            }
        }
        return $rt;
    }
}
?>
