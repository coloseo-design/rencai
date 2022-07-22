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

class index_controller extends common
{
    /**
     * 首页
     */
    function index_action()
    {
        if (!$this->config['did'] && $this->config['sy_gotocity'] == '1' && !$_COOKIE['gotocity']) {
            go_to_city($this->config);
        }
        if ($this->uid && $this->usertype == '1') {

            $resumeM    =   $this->MODEL('resume');

            $expect     =   $resumeM->getExpectByUid($this->uid, array('field' => 'id,status'));
            if (!empty($expect)) {

                $user_resume    =   $resumeM->getUserResumeInfo(array('uid' => $this->uid, 'eid' => $expect['id']), array('field' => '`skill`,`work`,`project`,`edu`,`training`'));
                $resume_yhnum   =   0;
                foreach ($user_resume as $rk => $rv) {
                    if ($rv == 0) {
                        $resume_yhnum++;
                    }
                }
                $this->yunset('resume_yhnum', $resume_yhnum);
            }
            $this->yunset('expect', $expect);
        }

        include PLUS_PATH.'/tplmoblie.cache.php';

        if ($tplmoblie['wapdiy'] == 1 || $_GET['type'] == 1) {

            $this->get_moblie();

            $tplM   =   $this->MODEL('tpl');

            $nav    =   $tplM->getTplmobliepicList(array('type' => 'nav', 'orderby' => 'sort,asc'));
            $this->yunset(array('nav' => $nav));

            $hd     =   $tplM->getTplmobliepicList(array('type' => 'hd'));
            $this->yunset('hd', $hd);

            $indexnav   =   $tplM->getTplmobliepicList(array('type' => 'indexnav', 'orderby' => 'id,asc'));
            foreach ($indexnav as $k => $v) {

                $indexnav[$k]['indexnavurl']    =   $v['url'];
                if ($k == 0) {
                    $indexnav1  =   $v;
                }
                if ($k == 1) {
                    $indexnav2  =   $v;
                }
                if ($k == 2) {
                    $indexnav3  =   $v;
                }
            }
            $this->yunset('indexnav1', $indexnav1);
            $this->yunset('indexnav2', $indexnav2);
            $this->yunset('indexnav3', $indexnav3);

            $adlist =   $tplM->getTplmobliepicList(array('type' => 'ad'));
            $this->yunset('adlist', $adlist);

            if ($tplmoblie['rewardjobnum'] < 1) {
                $tplmoblie['rewardjobnum'] = 5;
            }
            if ($tplmoblie['hotjobnum'] < 1) {
                $tplmoblie['hotjobnum'] = 8;
            }
            if ($tplmoblie['newjobnum'] < 1) {
                $tplmoblie['newjobnum'] = 5;
            }
            if ($tplmoblie['hotcomnum'] < 1) {
                $tplmoblie['hotcomnum'] = 5;
            }
            if ($tplmoblie['articlenum'] < 1) {
                $tplmoblie['articlenum'] = 5;
            }
            if ($tplmoblie['resumenum'] < 1) {
                $tplmoblie['resumenum'] = 5;
            }
            if ($tplmoblie['urgentjobnum'] < 1) {
                $tplmoblie['urgentjobnum'] = 5;
            }
            if ($tplmoblie['recjobnum'] < 1) {
                $tplmoblie['recjobnum'] = 5;
            }
            if ($tplmoblie['zphnum'] < 1) {
                $tplmoblie['zphnum'] = 5;
            }
            $this->yunset('tplmoblie', $tplmoblie);

            //显示顺序
            if ($tplmoblie['sort']) {

                $sort   =   explode(',', $tplmoblie['sort']);
            } else {

                $sort   =   'hearder,hd,search,nav,indexnav,notice,reglogin,ad,rewardjob,hotjob,newjob,hotcom,recjob,urgentjob,resume,article,zph,jobclass';
                $sort   =   explode(',', $sort);
            }
            $this->yunset('sort', $sort);
            //搜索类型
            $searchurl  =   array(

                array('id' => 1, 'c' => 'job', 'name' => '找工作'),
                array('id' => 2, 'c' => 'resume', 'name' => '找人才'),
                array('id' => 3, 'c' => 'company', 'name' => '找企业'),
                array('id' => 4, 'c' => 'part', 'name' => '找兼职'),
                array('id' => 5, 'c' => 'tiny', 'name' => '普工专区'),
                array('id' => 6, 'c' => 'once', 'name' => '店铺招聘'),
                array('id' => 7, 'c' => 'ltjob', 'name' => '猎头职位'),
                array('id' => 8, 'c' => 'ltjob', 'a' => 'service', 'name' => '委托求职'),
                array('id' => 9, 'c' => 'train', 'name' => '培训课程'),
                array('id' => 10, 'c' => 'train', 'a' => 'agency', 'name' => '培训机构'),
                array('id' => 11, 'c' => 'train', 'a' => 'teacher', 'name' => '培训讲师'),
                array('id' => 12, 'c' => 'ask', 'a' => 'list', 'name' => '互动问答')
            );
            $this->yunset('searchurl', $searchurl);
            $this->yunset($this->MODEL('cache')->GetCache(array('job')));
            if ($this->config["did"]) {

                $this->seo("index", $this->config['sy_webtitle'], $this->config['sy_webkeyword'], $this->config['sy_webmeta']);
            } else {

                $this->seo('index');
            }
            $this->yunset('indexnav', 1);
            $this->yuntpl(array('wap/wap_diy'));
        } else {

            $this->get_moblie();

            if ($this->config["did"]) {

                $this->seo("index", $this->config['sy_webtitle'], $this->config['sy_webkeyword'], $this->config['sy_webmeta']);
            } else {

                $this->seo('index');
            }
            $this->yunset('indexnav', 1);

            $xjhM       =   $this->MODEL('xjhlive');

            $xjh        =   $xjhM->getInfo(array('status' => 1, 'livestatus' => 3, 'orderby' => 'stime,desc'));

            if (empty($xjh)){
                $xjh    =   $xjhM->getInfo(array('status' => 1, 'livestatus' => 1, 'orderby' => 'stime,asc'));
            }


            if (!empty($xjh)){
                if (!empty($xjh['picarr'])){
                    $xjh['pic']  =  $xjh['picarr'][0]['url'];
                    unset($xjh['picarr']);
                }
                $this->yunset('xjh', $xjh);
            }
            $annM = $this->MODEL('announcement');
            $annum = $annM->getNum();
            $this->yunset('annum', $annum);
            include DATA_PATH.'api/wxapp/tplapp.cache.php';
            if($tplapp['cshow']==1){
				$this->yunset('kfurl', $tplapp['kfurl']);
			}
            //首页弹框广告记录
            $bannerFlag   =   $_COOKIE['wap_bannerFlag'];
            if (!$bannerFlag) {
                $this->cookie->setcookie('wap_bannerFlag', 1, time() + 3600);
            }
            $this->yunset("bannerFlag", $bannerFlag);
            
            $this->yuntpl(array('wap/index'));
        }
    }

    /**
     * 退出登录
     */
    function loginout_action()
    {
        $this->cookie->unset_cookie();
        $this->wapheader('');
    }

    // 关于我们
    function about_action()
    {

        $descM      =   $this->MODEL('description');
        $content    =   $descM->getDes(array('name' => '关于我们'), array('field' => 'content'));
        $this->yunset('content', $content);
        if ($_GET['fr'] == 'wxapp') {
            $this->yunset('wxapp', 1);
        }
        $this->yunset('headertitle', '关于我们');
        $this->yunset('title', '关于我们');
        $this->yuntpl(array('wap/about'));
    }

    // 联系我们
    function contact_action()
    {
        $descM      =   $this->MODEL('description');
        $content    =   $descM->getDes(array('name' => '联系我们'), array('field' => 'content'));
        $this->yunset('content', $content);
        if ($_GET['fr'] == 'wxapp') {
            $this->yunset('wxapp', 1);
        }
        $this->yunset('headertitle', '联系我们');
        $this->yunset('title', '联系我们');
        $this->yuntpl(array('wap/about'));
    }

    //下载app
    function appDown_action()
    {
        if (preg_match("/(iphone|ipod|ipad)/i", strtolower($_SERVER['HTTP_USER_AGENT']))){
            // 苹果
            $down = array(
                'qrcode' => $this->config['sy_ossurl'] .'/' .$this->config['sy_iosu_qcode']
            );
            
            include(DATA_PATH . 'api/wxapp/app.config.php');
            if (!empty($appconfig['iosurl']) && !is_weixin()) {
                // 苹果微信内不支持链接直接打开appstore
                $down['url'] = $appconfig['iosurl'];
            }
        }else{
            // 安卓
            $down = array(
                'qrcode' => $this->config['sy_ossurl'] .'/' .$this->config['sy_androidu_qcode']
            );
            
            include(DATA_PATH . 'api/wxapp/app.config.php');
            if (!empty($appconfig['androidurl'])) {
                $down['url'] = $appconfig['androidurl'];
            }
        }
        $this->yunset('down', $down);
        $this->yunset('headertitle', '下载APP');
        $this->yuntpl(array('wap/appdown'));
    }

    // 隐私政策
    function privacy_action()
    {
        $descM      =   $this->MODEL('description');
        $content    =   $descM->getDes(array('name' => '隐私政策'), array('field' => 'content'));
        $this->yunset('content', $content);
        if ($_GET['fr'] == 'wxapp') {
            $this->yunset('wxapp', 1);
        }
        $this->yunset('headertitle', '隐私政策');
        $this->yunset('title', '隐私政策');
        $this->yuntpl(array('wap/about'));
    }

    // 用户协议
    function protocol_action()
    {
        $descM      =   $this->MODEL('description');
        $content    =   $descM->getDes(array('name' => '注册协议'), array('field' => 'content'));
        $this->yunset('content', $content);
        if ($_GET['fr'] == 'wxapp') {
            $this->yunset('wxapp', 1);
        }
        $this->yunset('headertitle', '服务协议');
        $this->yunset('title', '服务协议');
        $this->yuntpl(array('wap/about'));
    }

    // 小程序浮动客服
    function miniContact_action()
    {
        $descM      =   $this->MODEL('description');
        $content    =   $descM->getDes(array('name' => '小程序浮动客服'), array('field' => 'content'));
        $this->yunset('content', $content);
        if ($_GET['fr'] == 'wxapp') {
            $this->yunset('wxapp', 1);
        }
        $this->yunset('headertitle', '在线客服');
        $this->yunset('title', '在线客服');
        $this->yuntpl(array('wap/about'));
    }

}

?>