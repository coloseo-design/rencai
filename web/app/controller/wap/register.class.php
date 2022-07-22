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
class register_controller extends common
{

    function index_action()
    {
        //马甲app注册
        $this->magbind();

        // 判断来源是否为千帆云APP
        $this->isqfy();

        if ($_COOKIE['wxid']) {
            $this->yunset('wxid', $_COOKIE['wxid']);
            $this->yunset('wxnickname', $_COOKIE['wxnickname']);
            $this->yunset('wxpic', $_COOKIE['wxpic']);
        }
        if ($this->config['reg_user_stop'] != 1) {//关闭会员注册

            $this->ACT_msg_wap('index.php', '网站已关闭注册！', 2, 5);

        } else {
            if ($this->uid) {
                $this->ACT_msg_wap('index.php', '您已经登录了！', 2, 5);
            }
            $type = $_GET['type'];
            if ($type) {
                switch ($type) {
                    case 1:
                        if ($this->config['reg_user'] != 1) {
                            $this->ACT_msg_wap('index.php', '用户名注册已关闭！', 2, 5);
                        }
                        break;
                    case 2:
                        if ($this->config['reg_moblie'] != 1) {
                            $this->ACT_msg_wap('index.php', '手机号注册已关闭！', 2, 5);
                        }
                        break;
                    case 3:
                        if ($this->config['reg_email'] != 1) {
                            $this->ACT_msg_wap('index.php', 'email注册已关闭！', 2, 5);
                        }
                    default:
                        break;
                }
            } else {
                if ($this->config['reg_moblie']) {
                    $type = '2';
                } else if ($this->config['reg_email']) {
                    $type = '3';
                } else {
                    $type = '1';
                }
            }
            $this->yunset('type', $type);
        }
        $this->get_moblie();

        $descM = $this->MODEL('description');
        $xieyi = $descM->getDes(array('id' => '5'), array('field' => 'content'));
        $this->yunset('xieyi', $xieyi);

        $yinsi = $descM->getDes(array('name' => array('like', '隐私政策')), array('field' => 'content'));
        $this->yunset('yinsi', $yinsi);

        if ($this->uid != '' && $this->username != '') {
            $this->logout(false);
        }
        if ((int)$_GET['uid']) {//邀请注册生成
            $time = time() + 3600;
            $this->cookie->setcookie('regcode', (int)$_GET['uid'], $time);
        }

        //注册提交
        if ($_POST) {
            session_start();

            $Member = $this->MODEL('userinfo');
            $data['usertype'] = $_POST['usertype'];
            $data['uid'] = $this->uid;
            $data['username'] = $_POST['username'];
            $data['codeid'] = $_POST['regway'];
            $data['moblie'] = $_POST['moblie'];
            $data['moblie_code'] = $_POST['moblie_code'];
            $data['code'] = $_POST['checkcode'];
            $data['email'] = $_POST['email'];
            $data['password'] = $_POST['password'];
            $data['source'] = 2;
            $data['did'] = $this->config['did'];
            $data['port'] = 2;
            $data['qfyuid'] = $_POST['qfyuid'];

            if ($this->config['sy_reg_type'] == 2){

                if (!empty($_COOKIE['reg_bind'])) {

                    if ($_COOKIE['reg_bind'] == 1) {

                        if ($_SESSION['wx']['openid']) {
                            $data['reg_weixin'] = array(
                                'openid' => $_SESSION['wx']['openid'],
                                'unionid' => $_SESSION['wx']['unionid'],
                            );
                        }
                    } elseif ($_COOKIE['reg_bind'] == 3) {

                        if ($_SESSION['sina']['openid']) {
                            $data['reg_sina'] = array(
                                'openid' => $_SESSION['sina']['openid']
                            );
                        }
                    } elseif ($_COOKIE['reg_bind'] == 2) {

                        if ($_SESSION['qq']['openid']) {
                            $data['reg_qq'] = array(
                                'openid' => $_SESSION['qq']['openid'],
                                'unionid' => $_SESSION['qq']['unionid']
                            );
                        }
                    }
                }

                $data['reg_name']   =   $_POST['reg_name'];
                $data['reg_link']   =   $_POST['reg_link'];
                $data['reg_type']   =   $_POST['reg_type'];
            }

            $return = $Member->userRegSave($data);

            if ($return['errcode'] != 8) {
                if ($return['reg_type'] == 2){

                    $this->layer_msg($return['msg'], 9, 0, $return['url'], 2);
                }else {

                    $this->layer_msg($return['msg'], 9, 0, Url('wap', array('c' => 'register', 'a' => 'ident')), 2);
                }
            } else {
                $this->layer_msg($return['msg'], 9, 0, '', 2);
            }
        }

        $this->seo('register');

        if ($this->config['sy_reg_type'] == 2){

            if (isset($_GET['bind']) && !empty($_GET['bind'])){
                $this->cookie->setcookie("reg_bind", $_GET['bind'], time() + 86400);
            }

            if ($_GET['step'] == 2){

                $this->yunset('usertype', $_GET['usertype']);
                $this->yunset('backurl', Url('wap', array('c' => 'register')));
                $this->yunset('headertitle', '创建账户');
                $this->yuntpl(array('wap/reg_create'));
            }else{

                $this->yunset('headertitle', '选择注册身份');
                $this->yuntpl(array('wap/reg_new'));
            }
        }else{

            $this->yunset('headertitle', '选择注册类型');
            $this->yuntpl(array('wap/register'));
        }
    }

    function checkComName_action()
    {

        $registerM  =   $this->MODEL('register');
        $return     =   $registerM->checkRegFirst(array('c_name' => $_POST['c_name']));
        echo json_encode($return);
    }


    function ident_action()
    {

        if (!$this->uid) {

            header('Location: ' . Url('wap', array('c' => 'register')));
            exit();

        } elseif ($this->usertype) {
            $this->wapheader('member/');
            exit();
        }

        if ($_GET['usertype']) {

            $Member = $this->MODEL('userinfo');

            $info = $Member->upUserType(array('uid' => $this->uid, 'usertype' => $_GET['usertype'], 'iswap' => 1));

            if ($info['errcode'] == 1) {

                header('Location: ' . $info['url']);
                exit();

            } else {

                $this->ACT_msg_wap(Url('register', array('c' => 'ident')), $info['msg'], 2, 5);

            }

        }
        $this->seo('register');
        $this->yuntpl(array('wap/ident'));
    }

    function regemail($post)
    {
        if ($post['username']) {
            $username = $post['username'];
        } else {
            if ($post['moblie']) {
                $username = $post['moblie'];
            } else {
                $username = $post['email'];
            }
        }
        $notice = $this->MODEL('notice');
        if ($this->config['sy_email_set'] == '1') {
            $notice->sendEmailType(array('username' => $username, 'password' => $post['password'], 'email' => $post['email'], 'cname' => $username, 'type' => 'reg', 'uid' => $post['uid']));
        }
        if (checkMsgOpen($this->config)) {
            $notice->sendSMSType(array('username' => $username, 'password' => $post['password'], 'moblie' => $post['moblie'], 'type' => 'reg', 'uid' => $post['uid'], 'port' => '2'));
        }
    }

    function regok_action()
    {
        $this->yunset('headertitle', '会员注册');
        $this->seo('register');
        $this->yuntpl(array('wap/registerok'));
    }

    function ajaxreg_action()
    {
        //验证用户名、邮箱
        $post = array(
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'password' => $_POST['password']
        );
        $data = array(
            'post' => $post
        );
        $registerM = $this->MODEL('register');
        $return = $registerM->ajaxReg($data);
        echo json_encode($return);
    }

    function regmoblie_action()
    {
        $data = array(
            'moblie' => $_POST['moblie'],
        );
        $registerM = $this->MODEL('register');
        $return = $registerM->regMoblie($data);
        if ($return['errcode'] == 9) {
            echo json_encode($return['data']);
        } else {
            echo $return['errcode'];
        }
    }

    function regemail_action()
    {
        $data = array(
            'email' => $_POST['email'],
        );
        $registerM = $this->MODEL('register');
        $return = $registerM->regMoblie($data);
        if ($return['errcode'] == 9) {
            echo json_encode($return['data']);
        } else {
            echo $return['errcode'];
        }
    }

    function writtenoff_action()
    {
        $data = array(
            'zyuid' => $_POST['zyuid'],
            'pw' => $_POST['pw'],
            'mobile' => $_POST['mobile'],
            'email' => $_POST['email'],
        );
        $registerM = $this->MODEL('register');
        $return = $registerM->writtenOff($data);

        echo $return['errcode'];
    }

    //查询马甲绑定
    function magbind()
    {
        if ($this->config['sy_maglogin'] == 1 && !$_POST) {
            session_start();
            if (!$_SESSION['mag']['user_id']) {
                $this->getMag();
            }
            if ($_SESSION['mag']['user_id']) {
                $userinfoM = $this->MODEL('userinfo');
                $userinfo = $userinfoM->getInfo(array('maguid' => $_SESSION['mag']['user_id']), array('field' => '`uid`,`usertype`,`username`,`email`,`password`,`salt`,`status`,`did`'));
                $time = time();
                if (!$userinfo['uid']) {
                    $this->yunset('maglogin', 1);
                } else {
                    //锁定
                    if ($userinfo['status'] == '2') {
                        header('Location: ' . Url('wap', array('c' => 'login', 'a' => 'loginlock', 'type' => 1)));
                        exit();
                    }
                    $ip = fun_ip_get();
                    $logdate = date('Ymd', $userinfo['login_date']);
                    $nowdate = date('Ymd', $time);
                    if ($logdate != $nowdate) {
                        $this->MODEL('integral')->invtalCheck($userinfo['uid'], $userinfo['usertype'], 'integral_login', '会员登录', 22);
                    }
                    $userinfoM->upInfo(array('uid' => $userinfo['uid']), array('login_ip' => $ip, 'login_date' => $time, '`login_hits`=`login_hits`+1'));
                    $this->cookie->add_cookie($userinfo['uid'], $userinfo['username'], $userinfo['salt'], $userinfo['email'], $userinfo['password'], $userinfo['usertype'], $this->config['sy_logintime'], $userinfo['did']);
                    $this->wapheader('member/index.php');
                }
            }
        }
    }

    function getMag()
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $info = strstr($userAgent, 'MAGAPPX');
        $info = explode('|', $info);
        $agent = array('token' => $info[7]);
        if ($agent['token']) {
            $Url = $this->config['sy_magweburl'] . '/mag/cloud/cloud/getUserInfo?token=' . $agent['token'] . '&secret=' . $this->config['sy_magsecret'];
            $CurlReturn = CurlGet($Url);
            $result = json_decode($CurlReturn, true);
            if ($result['success'] == true) {
                //获取马甲用户头像
                if (strpos($result['data']['head'], $this->config['sy_magimgurl']) === false) {
                    $headData = @explode('?', $result['data']['head']);
                    $head = $this->getImage($headData[0], 'user');
                } else {
                    $head = $result['data']['head'];
                }
                $_SESSION['mag']['user_id'] = $result['data']['user_id'];
                $_SESSION['mag']['name'] = $result['data']['name'];
                $_SESSION['mag']['head'] = $head;
            }
        }
    }

    //获取马甲用户头像
    function getImage($url, $path)
    {
        $CurlReturn = CurlGet($url);
        $time = time();
        $filename = $time . '.jpg';
        $picDir = date('Ymd', $time);
        $dirName = APP_PATH . '/data/upload/' . $path . '/' . $picDir;
        if (!file_exists($dirName)) {
            mkdir($dirName, 0777, true);
        }
        $res = fopen($dirName . '/' . $filename, 'a');
        fwrite($res, $CurlReturn);
        fclose($res);
        return $this->config['sy_weburl'] . '/data/upload/' . $path . '/' . $picDir . '/' . $filename;
    }

    // 判断运行环境是否为千帆云APP
    function isqfy()
    {
        $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
        if (stripos($userAgent, 'qianfan') !== false && $this->config['sy_qfylogin'] == 1) {
            $this->yunset('qfylogin', 1);
        }
    }

    /**
     * 供求保存
     */
    function gqsave_action()
    {
        if ($_POST['submit']) {
            $userinfoM = $this->MODEL('userinfo');
            $data['usertype'] = $_POST['usertype'];
            $data['username'] = $_POST['moblie'];
            $data['uid'] = $this->uid;
            $data['moblie'] = $_POST['moblie'];
            $data['password'] = $_POST['password'];
            $data['passconfirm'] = $_POST['passconfirm'];
            $data['codeid'] = $_POST['regway'];
            $data['moblie_code'] = $_POST['moblie_code'];
            $data['code'] = $_POST['checkcode'];
            $data['name'] = $_POST['name'];
            $data['port'] = 2;
            $return = $userinfoM->userRegSave($data);
            if ($return['errcode'] != 8) {
                $this->layer_msg($return['msg'], 9, 0, 'member/index.php?c=info', 2);
            } else {
                $this->layer_msg($return['msg'], 9, 0, '', 2);
            }
        }
    }
}

?>