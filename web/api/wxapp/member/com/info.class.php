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
class info_controller extends com_controller{

    /**
     * 获取企业信息
     */
    function getinfo_action()
    {

        $companyM  =  $this->MODEL('company');
        $resumeM  =  $this->MODEL('resume');
        $info      =  $companyM->getInfo($this->member['uid'],array('edit'=>'1','logo'=>'1','utype'=>'user','setname'=>'1'));

        if (!empty($_POST['source']) && $_POST['source'] == 'wap') { // WAP站百度坐标系，不需要转
        } else {
            if($info['x'] && $info['y']){
                $newxy  =  $this->Convert_BD09_To_GCJ02($info['x'], $info['y']);
                $info['x']  =  $newxy['lng'];
                $info['y']  =  $newxy['lat'];
            }
        }

        $comcert   =  $companyM->getCertInfo(array('uid'=>$this->member['uid'],'type'=>3));

        $info['cert_pic']   =  $comcert['check'];

        if(!empty($info['content'])){
            $info['content_t']  =  strip_tags($info['content']);
        }

        $cacheM    =  $this->MODEL('cache');
        $cache     =  $cacheM->GetCache('com');
        //福利缓存数据
        if(is_array($cache['comdata']['job_welfare'])){
            foreach($cache['comdata']['job_welfare'] as $k=>$v){
                $welfareData[]	=	$cache['comclass_name'][$v];
				$welfaresy[]	=	array('name'=>$cache['comclass_name'][$v],'ischecked'=>0);
            }
        }
        $welfareArr	 =	array_unique(array_merge($info['arraywelfare'],$welfareData));

        $welfareAll  =  $w  =  array();

        foreach($welfareArr as $k=>$v){
            $w['name']  =  $v;
            if(in_array($v,$info['arraywelfare'])){
                $w['ischecked']	 =	1;
            }else{
                $w['ischecked']	 =	0;
            }
            $welfareAll[]  =  $w;
        }
		if($welfareAll){
			$info['welfareAll']  =  $welfareAll;
        }else{
			$info['welfareAll']  =  $welfaresy;
		}

		$usernum	=	$resumeM->getResumeNum(array('uid'=>$this->member['uid']));
		$info['usernum']		=	$usernum;

		$info['cuswitch']   =  $this->config['sy_user_change'];
		$info['setPosition']=  $this->config['com_enforce_setposition'];

		include(CONFIG_PATH.'db.data.php');
		// 根据是否有猎头模块，来确定是否有子账号功能
		$info['sy_son']     =  isset($arr_data['modelconfig']['lietou']) ? 1 : 2;
		$info['app_push']   =  $this->member['app_push'];
		$info['usertype'] = $this->usertype;
        $info['sy_lietou_web'] = $this->config['sy_lietou_web'];
        $info['sy_train_web'] = $this->config['sy_train_web'];
        
        if (isset($_POST['provider']) && ($_POST['provider'] == 'weixin' || $_POST['provider'] == 'baidu')) {
            // 小程序关联登录入口判断
            if ($_POST['provider'] == 'weixin'){
                @include(DATA_PATH.'api/wxpay/wxpay_data.php');
                if (isset($wxpaydata)){
                    if($wxpaydata['sy_xcxappid'] == '' || $wxpaydata['sy_xcxsecret'] ==''){
                        $info['isWxopen'] = false;
                    }else{
                        $info['isWxopen'] = true;
                    }
                }
            }
            if ($_POST['provider'] == 'baidu'){
                @include(DATA_PATH . 'api/baidu/baidu_data.php');
                if (isset($baiduData)) {
                    if($baiduData['sy_bdlogin_appKey'] == '' || $baiduData['sy_bdlogin_appSecret'] == ''){
                        $info['isBdopen'] = false;
                    }else{
                        $info['isBdopen'] = true;
                    }
                }
            }
        }

        $this->render_json(0, 'ok', $info);
    }

	function saveinfo_action()
	{
		$companyM 	=   $this->MODEL('company');

		if(isset($this->comInfo['r_status'])){
		    $rstaus  =  $this->comInfo['r_status'];
		}else{
		    $rstaus  =  $this->config['com_status'];
		}

		$mData     =  array(
			'moblie'        =>  $_POST['linktel'],
			'email'         =>  $_POST['linkmail']
		);
        $x = $_POST['x'];
        $y = $_POST['y'];
        $source = $_POST['source'];
        if (!empty($_POST['source']) && $_POST['source'] == 'wap') { // WAP站百度坐标系，不需要转
            $source = 2;
        } else {
            if($x && $y){
                $bd09 = $this->Convert_GCJ02_To_BD09($x, $y);
                $x = $bd09['lng'];
                $y = $bd09['lat'];
            }
        }
		$setData	=	array(
			'name' 			=> 	$_POST['name'],
			'shortname' 	=> 	$_POST['shortname'],
			'hy' 			=> 	$_POST['hy'],
			'pr' 			=> 	$_POST['pr'],
			'mun' 			=> 	$_POST['mun'],
			'provinceid' 	=>	$_POST['provinceid'],
			'cityid' 		=> 	$_POST['cityid'],
			'three_cityid' 	=> 	$_POST['three_cityid'],
			'address' 		=>	$_POST['address'],
			'x' 			=>	$x,
			'y' 			=>	$y,
			'linkman'		=> 	$_POST['linkman'],
			'linktel'		=>	$_POST['linktel'],
			'linkphone' 	=> 	$_POST['linkphone'],
			'linkmail' 		=> 	$_POST['linkmail'],
			'sdate' 		=> 	$_POST['sdate'],
			'moneytype' 	=> 	$_POST['moneytype'],
			'money' 		=>	$_POST['money'],
			'linkjob' 		=> 	$_POST['linkjob'],
			'linkqq' 		=> 	$_POST['linkqq'],
			'website' 		=> 	$_POST['website'],
			'busstops' 		=> 	$_POST['busstops'],
			'infostatus' 	=> 	$_POST['infostatus'],
			'welfare' 		=> 	$_POST['welfare'],
		    'photos' 		=> 	$_FILES['photos'],
			'preview'       =>  $_POST['preview'],
			'lastupdate'	=>  time(),
		    'r_status' 		=> 	$rstaus,
			'content'		=> 	str_replace(array('&amp;','background-color:#ffffff','background-color:#fff','white-space:nowrap;'),array('&','background-color:','background-color:','white-space:'),$_POST['content'])
		);

		$userinfoM    =   $this->MODEL("userinfo");
		if(empty($this -> comInfo['uid'])){

		    $userinfoM -> activUser($this->member['uid'],2);
		}

		$return =  $companyM -> setCompany(array('uid'=>$this->member['uid']),array('mData'=>$mData,'comData'=>$setData,'utype'=>'user','wap'=>1,'source'=>$source));

		//根据后台设置 修改企业资料重新审核
		if($this -> config['com_revise_status'] == '0'){


			$userinfoM -> status(array('uid' => $this ->member['uid'],'usertype'=>2), array('post' => array('status' => 0)));

		}

		if($return['errcode'] == 9){
			$error	=  1;
		}else{
		    $error	=  2;
		}
		$msg  =  preg_replace('/\([^\)]+?\)/x','',$return['msg']);
		$this->render_json($error, $msg);
	}

	function savephoto_action()
	{
		$companyM	=	$this->MODEL('company');

		if(empty($this->member['uid'])){
		    $error	=	3;
		    $msg	=	'参数不正确';
		}else{
		    if(empty($this -> comInfo['uid'])){
		        $userinfoM  =  $this->MODEL("userinfo");
		        $userinfoM -> activUser($this->member['uid'],2);
		    }

		    $data['utype'] = 'user';
            $data['source'] = $_POST['source'];
		    if($_POST['source'] == 'wap'){
                $data['source'] = 2;
                $data['base'] = $_POST['uimage'];
            }else{
                $data['photo'] = $_FILES['photos'];
            }

		    $return	=  $companyM -> upLogo(array('uid'=>$this->member['uid']), $data);
			$msg    =  preg_replace('/\([^\)]+?\)/x','',$return['msg']);
		}
		$this->render_json(1, $msg);
	}

    function show_action()
    {
        $companyM	=	$this->MODEL('company');

        if(empty($this->member['uid'])){
            $this->render_json(3, '参数不正确');
        }else{
            $where['uid']	=	$this->member['uid'];
            !empty($_GET['pageSize']) && $where['limit'] = $_GET['pageSize'];
            $where['orderby']		=	'sort,desc';

            $List					=	$companyM->getCompanyShowList($where,array('field'=>'`title`,`id`,`picurl`'));

            $this->render_json(0, 'ok', array('list' => $List));
        }
    }

    function showsave_action()
    {
        $companyM	=	$this->MODEL('company');

        if(empty($this->member['uid'])){
            $error	=	3;
            $msg	=	'参数不正确';
        }else{
            if($_POST['wappic']==1){
                $data['base'] = $_POST['uimage'];
            }else {
                $data['file'] = $_FILES['pic'];
            }
            $data['uid'] = $this->member['uid'];

            $data['r_status'] = $this->comInfo['info']['r_status'];

            $return = $companyM->setShow($data);
            if ($return['errcode'] == '9') {
                $error = 1;
            } else {
                $error = 2;
            }
            $msg = preg_replace('/\([^\)]+?\)/x', '', $return['msg']);
        }

        $this->render_json($error, $msg, array('id' => !empty($return['id']) ? $return['id'] : ''));
    }

    function showdel_action(){
        $companyM	=	$this->MODEL('company');
        $logM		=	$this->MODEL('log');

        if(empty($this->member['uid']) || empty($_POST['id'])){
            $error	=	3;
            $msg	=	'参数不正确';
        }else{
            $oid	=	$companyM->delCompanyShow(is_array($_POST['id']) ? $_POST['id'] : explode(',', $_POST['id']),array('uid'=>$this->member['uid']));

            if($oid){
                $logM->member_log("删除企业环境展示",16,3);//会员日志

                $error	=	1;
                $msg	=	'删除成功';
            }else{
                $error	=	2;
                $msg	=	'删除失败';
            }
        }
        $this->render_json($error, $msg);
    }
}
?>