<?php

/*
 * $Author ：PHPYUN开发团队
 *
 * 官网: http://www.phpyun.com
 *
 * 版权所有 2009-2021 宿迁鑫潮信息技术有限公司，并保留所有权利。
 *
 * 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
 *
 */


/**
 * 功能性通用函数库
 */

/**
 * @desc 检测手机号格式
 * @param $mobile
 * @return bool
 */
function CheckMobile($mobile)
{
    // if (!preg_match("/1[3456789]{1}\d{9}$/", trim($mobile))) {
    //     return false;
    // } else {
    //     return true;
    // }
    return true;
}

function CheckRegUser($str)
{

    if (!preg_match("/^[\x{4e00}-\x{9fa5}A-Za-z0-9\-@#.\$_!]+$/u", $str)) {
        return false;
    } else {
        return true;
    }
}

function CheckTell($str)
{

    if (preg_match("/^[0-9-]+?$/", $str) == 0) {
        return false;
    } else {
        return true;
    }
}

/**
 * 检测邮箱
 * @param $email
 * @return bool
 */
function CheckRegEmail($email)
{
    if (!preg_match('/^([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9\-]+@([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,4}$/', $email)) {
        return false;
    } else {
        return true;
    }
}

/**
 * 用户名注册复杂度判断
 * @param $name
 * @return string
 */
function regUserNameComplex($name)
{

    $msg = '';

    if ($name) {

        global $config;

        $reg_namemaxlen =   $config['sy_reg_namemaxlen'];//用户名长度最大值
        $reg_nameminlen =   $config['sy_reg_nameminlen'];//用户名长度最小值
        $reg_name_sp    =   $config['reg_name_sp'];//是否必须包含其它字符@!#.$-_
        $reg_name_zm    =   $config['reg_name_zm'];//是否必须包含字母
        $reg_name_num   =   $config['reg_name_num'];//是否必须包含数字

        $namelen        =   mb_strlen($name);
        //长度
        if ($namelen < $reg_nameminlen || $namelen > $reg_namemaxlen) {

            $msg    = '用户名应在' . $reg_nameminlen . '-' . $reg_namemaxlen . '位字符之间！';
        } else {

            $smsg   =   $zmsg   =   $nmsg   =   $douhao =   '';

            //数字
            if ($reg_name_num == 1) {
                if (!preg_match("/[0-9]+/u", $name)) {

                    $nmsg   =   '数字';
                    $douhao =   '，';
                }
            }
            //字母
            if ($reg_name_zm == 1) {
                if (!preg_match('/[a-zA-Z]+/u', $name)) {

                    $zmsg   =   $douhao . '字母';
                    $douhao =   '，';
                }
            }
            //其它字符
            if ($reg_name_sp == 1) {
                if (!preg_match('/[-@#.$_!]+/u', $name)) {

                    $smsg   =   $douhao . '其它字符@!#.$-_';
                }
            }

            if ($nmsg || $zmsg || $smsg) {

                $msg        =   '用户名必须包含' . $nmsg . $zmsg . $smsg;
            }
        }
    }
    return $msg;
}

/**
 * 验证密码复杂度
 * @param $name
 * @return string
 */
function regPassWordComplex($name)
{

    $msg    =   '';

    if ($name) {

        global $config;

        $reg_pw_sp  =   $config['reg_pw_sp'];   //  是否必须包含其它字符@!#.$-_
        $reg_pw_zm  =   $config['reg_pw_zm'];   //  是否必须包含字母
        $reg_pw_num =   $config['reg_pw_num'];  //  是否必须包含数字

        $smsg   =   $zmsg   =   $nmsg   =   $douhao =   '';
        //数字
        if ($reg_pw_num == 1) {
            if (!preg_match("/[0-9]+/u", $name)) {

                $nmsg   =   '数字';
                $douhao =   '，';
            }
        }
        //字母
        if ($reg_pw_zm == 1) {
            if (!preg_match('/[a-zA-Z]+/u', $name)) {

                $zmsg   =   $douhao . '字母';
                $douhao =   '，';
            }
        }
        //其它字符
        if ($reg_pw_sp == 1) {
            if (!preg_match('/[-@#.$_!]+/u', $name)) {

                $smsg   =   $douhao . '其它字符@!#.$-_';
            }
        }
        if ($nmsg || $zmsg || $smsg) {

            $msg        =   '密码必须包含' . $nmsg . $zmsg . $smsg;
        }
    }
    return $msg;
}

/**
 * 把数组生成字符串
 * @param $obj
 * @param bool $withKey
 * @param bool $two
 * @return array|string
 */
function ArrayToString($obj, $withKey = true, $two = false)
{
    if (empty($obj)) return array();

    $objType    =   gettype($obj);

    if ($objType == 'array') {

        $objString  =   "array(";
        foreach ($obj as $objkey => $objv) {

            if ($withKey) $objString .= "\"$objkey\"=>";

            $vtype  =   gettype($objv);

            if ($vtype == 'integer') {

                $objString  .=  "$objv,";
            } else if ($vtype == 'double') {

                $objString  .=  "$objv,";
            } else if ($vtype == 'string') {

                $objv       =   str_replace('"', "\\\"", $objv);
                $objString  .=  "\"" . $objv . "\",";
            } else if ($vtype == 'array') {

                $objString  .=  "" . ArrayToString($objv, $withKey, $two) . ",";
            } else if ($vtype == 'object') {

                $objString  .=  "" . ArrayToString($objv, $withKey, $two) . ",";
            } else {

                $objString  .=  "\"" . $objv . "\",";
            }
        }
        $objString  =   substr($objString, 0, -1) . "";
        return $objString . ")\n";
    }
}

/**
 * 获取真实IP地址否则返回Unknown
 */
function fun_ip_get()
{

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {

        return is_ip($_SERVER['HTTP_CLIENT_IP']);
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {

        return is_ip($_SERVER['HTTP_X_FORWARDED_FOR']);
    } else {

        return is_ip($_SERVER['REMOTE_ADDR']);
    }
}

/**
 * @param $str
 * @return string
 */
function is_ip($str)
{

    if (stripos($str, ',') !== false) {

        $strArr =   explode(',', $str);
        $ip     =   $strArr[0];
    } else {

        $ip     =   $str;
    }

    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {

        return  $ip;
    } elseif (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {

        return  $ip;
    } else {

        return  '未知IP';
    }
}


/**
 * 获取城市当前处于第几级
 * @param $id
 * @param $parent
 * @param int $lev
 * @return int
 */
function getLev($id, $parent, $lev = 1)
{

    $lhead  =   0;
    if ($parent[$id] > $lhead) {   //存在父ID 则继续向下探寻 直到父ID 为一级类别

        return getLev($parent[$id], $parent, ($lev + 1));
    } else {

        return $lev;
    }
}

/**
 * 返回当前城市
 */
function getLocalCity()
{
    $ip         =   fun_ip_get();
    $cityInfo   =   array();
    $url        =   "http://user.58.com/userdata/getlocal/";
    $curl       =   curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    if ($ip != "127.0.0.1") {

        curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:' . $ip, 'CLIENT-IP:' . $ip));
    }

    curl_setopt($curl, CURLOPT_TIMEOUT, 1);
    $ret        =   curl_exec($curl);

    if (false !== $ret) {

        $ret    =   str_replace('list', '"list"', $ret);
        $ret    =   str_replace('local', '"local"', $ret);
        $ret    =   str_replace('ishome', '"ishome"', $ret);
        $ret    =   str_replace("'", '"', $ret);
        $output =   json_decode($ret, true);

        curl_close($curl);

        $local  =   $output['local'];
        include(PLUS_PATH . "domain_cache.php");
        $i      =   0;

        include(PLUS_PATH . "city.cache.php");
        include(PLUS_PATH . "cityparent.cache.php");

        $provinceid =   $cityid =   '';

        foreach ($city_name as $tck => $cn) {

            if (strpos($cn, $local) !== false) {

                $lev    =   getLev($tck, $city_parent);

                if ($lev == 3) {

                    $threecityid    =   $tck;
                    $cityid         =   $city_parent[$tck];
                    $provinceid     =   $city_parent[$cityid];

                } elseif ($lev == 2) {

                    $cityid         =   $tck;
                    $provinceid     =   $city_parent[$tck];
                } elseif ($lev == 1) {

                    $provinceid     =   $tck;
                }
            }
        }

        //当前IP三级地区
        if ($lev == 3) {
            foreach ($site_domain as $key => $value) {
                if ($value['three_cityid'] && $value['three_cityid'] == $threecityid) {//查找分站缓存中的该三级城市

                    $cityInfo   =   $value;
                    break;
                }
            }
        }
        //当前IP二级地区 或 未匹配到三级分站
        if ($lev != 1 && !$cityInfo) {
            foreach ($site_domain as $key => $value) {
                if ($value['cityid'] && $value['cityid'] == $cityid) {//查找分站缓存中的该三级城市

                    $cityInfo   =   $value;
                    break;
                }
            }
        }
        //当前IP
        if ($lev == 1 || !$cityInfo) {
            foreach ($site_domain as $key => $value) {
                if ($value['provinceid'] && $value['provinceid'] == $provinceid) {//查找分站缓存中的该三级城市

                    $cityInfo   =   $value;
                    break;
                }
            }
        }
    }
    return $cityInfo;
}

function go_to_city($config)
{

    $city   =   getLocalCity();

    SetCookie("gotocity", '1', time() + 3600, "/");//一个小时内不再判断

    if (!empty($city)) {
        if ($city['mode'] == '1') {

            header('Location: http://' . $city['host']);
        } else {

            header('Location: ' . $config['sy_weburl'] . '/' . $city['indexdir'] . '/');
        }
        exit();//停止执行
    }
}

/**
 * 判断来路
 * @param string $default
 * @return mixed|string
 */
function dreferer($default = '')
{

    $referer        =   isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

    if (strpos('a' . $referer, Url('user', 'login'))) {

        $referer    =   $default;
    } else {

        $referer    =   substr($referer, -1) == '?' ? substr($referer, 0, -1) : $referer;
    }
    return $referer;
}

/**
 * 判断是否是手机或PC客户端来路
 */
function UserAgent()
{
    $user_agent =   (!isset($_SERVER['HTTP_USER_AGENT'])) ? FALSE : $_SERVER['HTTP_USER_AGENT'];

    if ((preg_match("/(iphone|ipod|android)/i", strtolower($user_agent))) and strstr(strtolower($user_agent), 'webkit')) {

        return true;
    } else if (trim($user_agent) == '' or preg_match("/(nokia|sony|ericsson|mot|htc|samsung|sgh|lg|philips|lenovo|ucweb|opera mobi|windows mobile|blackberry)/i", strtolower($user_agent))) {

        return true;
    } else {

        return true;
    }
}

/**
 * 获取顶级域名
 * @param $host
 * @return mixed
 */
function get_domain($host)
{

    $host       =   strtolower($host);

    if (strpos($host, '/') !== false) {
        $parse  =   @parse_url($host);
        $host   =   $parse['host'];
    }
    $topDomain  =   array('com', 'edu', 'gov', 'int', 'mil', 'net', 'org', 'biz', 'info', 'pro', 'name', 'museum', 'coop', 'aero', 'xxx', 'idv', 'mobi', 'cc', 'me');
    $str        =   '';
    foreach ($topDomain as $v) {
        $str    .=  ($str ? '|' : '') . $v;
    }
    $matchStr   =   "[^\.]+\.(?:(" . $str . ")|\w{2}|((" . $str . ")\.\w{2}))$";
    if (preg_match("/" . $matchStr . "/is", $host, $matchS)) {

        $domain =   $matchS['0'];
    } else {

        $domain =   $host;
    }
    return $domain;
}

/**
 * 配置文件生成方法可定义数组名
 * @param $dir
 * @param $array
 * @param $config
 */
function made_web($dir, $array, $config)
{

    $content    =   "<?php \n";
    $content    .=  "\$$config=" . $array . ";";
    $content    .=  " \n";
    $content    .=  "?>";
    $fpIndex    =   @fopen($dir, "w+");
    @fwrite($fpIndex, $content);
    @fclose($fpIndex);
}

/**
 * 配置文件生成方法，数组遍历打印
 * @param $dir
 * @param $array
 * @return
 */
function made_web_array($dir, $array)
{

    $content    =   "<?php \n";

    if (is_array($array)) {
        foreach ($array as $key => $v) {
            if (is_array($v)) {

                $content    .=  "\$$key=array(";
                $content    .=  made_string($v);
                $content    .=  ");";
            } else {

                $v  =   str_replace("'", "\\'", $v);
                $v  =   str_replace("\"", "'", $v);
                $v  =   str_replace("\$", "", $v);
                $content    .=  "\$$key=" . $v . ";";
            }
            $content        .=  " \n";
        }
    }
    $content    .=  "?>";

    $fpIndex    =   @fopen($dir, "w+");
    $fw         =   @fwrite($fpIndex, $content);
    @fclose($fpIndex);
    return $fw;
}

/**
 * 字符串生成方法，可拼接
 * @param $array
 * @param string $string
 * @return string
 */
function made_string($array, $string = '')
{

    if (is_array($array) && !empty($array)) {
        $i  =   0;
        foreach ($array as $key => $value) {
            if ($i > 0) {

                $string .=  ',';
            }
            if (is_array($value)) {

                $string .=  "'" . $key . "'=>array(" . made_string($value) . ")";
            } else {

                $string .=  "'" . $key . "'=>'" . str_replace('\$', '', $value) . "'";
            }
            $i++;
        }
    }
    return $string;
}

/**
 * 删除文件方法
 * @param $delFiles
 * @return bool
 */
function delfiledir($delFiles)
{
    $delFiles   =   stripslashes($delFiles);
    $delFiles   =   str_replace("../", "", $delFiles);
    $delFiles   =   str_replace("./", "", $delFiles);
    $delFiles   =   "../" . $delFiles;
    $p_delFiles =   path_tidy($delFiles);
    if ($p_delFiles != $delFiles) {
        die;
    }
    if (is_file($delFiles)) {
        @unlink($delFiles);
    } else {
        $dh = @opendir($delFiles);
        while ($file = @readdir($dh)) {
            if ($file != "." && $file != "..") {
                $fullpath = $delFiles . "/" . $file;
                if (@is_dir($fullpath)) {
                    delfiledir($fullpath);
                } else {
                    @unlink($fullpath);
                }
            }
        }
        @closedir($dh);
        if (@rmdir($delFiles)) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * 路径'//'处理成'/'
 * @param $path
 * @return string
 */
function path_tidy($path)
{
    $tidy   =   array();
    $path   =   strtr($path, '\\', '/');
    foreach (explode('/', $path) as $i => $item) {
        if ($item == '' || $item == '.') {
            continue;
        }
        if ($item == '..' && end($tidy) != '..' && $i > 0) {
            array_pop($tidy);
            continue;
        }
        $tidy[] = $item;
    }
    return ($path[0] == '/' ? '/' : '') . implode('/', $tidy);
}

/**
 * 图片删除
 * 索引 2 给出的是图像的类型，返回的是数字
 * 其中 1 = GIF，2 = JPG，3 = PNG，4 = SWF，5 = PSD，6 = BMP，7 = TIFF(intel byte order)，8 = TIFF(motorola byte order)，9 = JPC，10 = JP2，11 = JPX，12 = JB2，13 = SWC，14 = IFF，15 = WBMP，16 = XBM
 * @param $pic
 */
function unlink_pic($pic)
{
    $picType    =   getimagesize($pic);
    if ($picType[2] == '1' || $picType[2] == '2' || $picType[2] == '3') {

        @unlink($pic);
    }
}

/**
 * 批量操作中的ID检查，只能是数字字母与系统内置的分隔符
 *
 * @param $string
 * @param $array
 * @return int
 */
function pylode($string, $array)
{
    if (is_array($array)) {

        $str    =   @implode($string, $array);
    } else {

        $str    =   $array;
    }
    if (!preg_match("/^[0-9a-zA-Z" . $string . "]+$/", $str)) {
        $str = 0;
    }
    return $str;
}

/**
 * 获取微信 TOKEN
 * @return mixed
 */
function getToken()
{

    $config     =   '';
    include(PLUS_PATH . 'configcache.php');

    if (isset($configcache)){

        $Token      =   $configcache['token'];
        $TokenTime  =   $configcache['token_time'];
        $NowTime    =   time();

        if (($NowTime - $TokenTime) > 7000 || !$Token) {

            include(PLUS_PATH.'config.php');
            $Appid      =   $config['wx_appid'];
            $Appsecert  =   $config['wx_appsecret'];
            $Url        =   'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $Appid . '&secret=' . $Appsecert;
            $CurlReturn =   CurlPost($Url);

            $Token      =   json_decode($CurlReturn);

            $configcache['token']       =   $Token->access_token;
            $configcache['token_time']  =   time();
            if ($configcache['token']) {

                made_web(PLUS_PATH . "configcache.php", ArrayToString($configcache), "configcache");
            }
            return $configcache['token'];
        } else {

            return $Token;
        }
    }
}

/**
 * 获取企业微信 TOKEN
 * @return mixed
 */
function getWxQyToken()
{

    $config =   '';

    include(PLUS_PATH . 'configcache.php');

    if (isset($configcache)) {

        $Token      =   $configcache['wxqy_token'];
        $TokenTime  =   $configcache['wxqy_token_time'];
        $NowTime    =   time();

        if (($NowTime - $TokenTime) > 7000 || !$Token) {

            include(PLUS_PATH . 'config.php');

            $corpid     =   $config['wx_qy_corpid'];
            $secert     =   $config['wx_qy_secret'];
            $Url        =   'https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=' . $corpid . '&corpsecret=' . $secert;
            $CurlReturn =   CurlPost($Url);

            $Token      =   json_decode($CurlReturn);

            $configcache['wxqy_token']      =   $Token->access_token;
            $configcache['wxqy_token_time'] =   time();
            if ($configcache['token']) {
                made_web(PLUS_PATH . "configcache.php", ArrayToString($configcache), "configcache");
            }

            return $configcache['wxqy_token'];
        } else {

            return $Token;
        }
    }
}

/**
 * 获取微信 JS TOKEN
 */
function getWxTicket()
{

    include(PLUS_PATH.'configcache.php');

    if (isset($configcache)) {

        $Ticket     =   $configcache['ticket'];
        $TicketTime =   $configcache['ticket_time'];
        $NowTime    =   time();
        if (($NowTime - $TicketTime) > 7000 || !$Ticket) {

            $Url        =   'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=' . getToken() . '&type=jsapi';
            $CurlReturn =   CurlPost($Url);
            $Ticket     =   json_decode($CurlReturn);

            $configcache['ticket']      =   $Ticket->ticket;
            $configcache['ticket_time'] =   time();
            if ($configcache['ticket']) {
                made_web(PLUS_PATH . "configcache.php", ArrayToString($configcache), "configcache");
            }
            return $configcache['ticket'];
        } else {
            return $Ticket;
        }
    }
}

/**
 * 初始化微信SDK参数
 * @param string $url
 * @return array
 */
function getWxJsSdk($url = '')
{
    include(PLUS_PATH.'config.php');

    $Ticket =   getWxTicket();

    if (empty($url)) {
        if (!empty($config['sy_wapdomain'])) {
            if ($config['sy_wapssl'] == '1') {

                $protocol   =   'https://';
            } else {

                $protocol   =   'http://';
            }
        } else {
            $protocol       =   getprotocol($config['sy_weburl']);
        }

        $url    =   $protocol . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI];
    }
    $timestamp  =   time();
    $chars      =   "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $nonceStr   =   "";
    for ($i = 0; $i < 16; $i++) {

        $nonceStr   .=  substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    // 这里参数的顺序要按照 key 值 ASCII 码升序排序
    $string     =   "jsapi_ticket=" . $Ticket . "&noncestr=" . $nonceStr . "&timestamp=" . $timestamp . "&url=" . $url;

    $signature  =   sha1($string);

    $signPackage    =   array(

        "appId"         =>  $config['wx_appid'],
        "nonceStr"      =>  $nonceStr,
        "timestamp"     =>  $timestamp,
        "url"           =>  $url,
        "signature"     =>  $signature,
        "rawString"     =>  $string
    );
    return $signPackage;
}

/**
 * CURL POST提交
 *
 * @param $url
 * @param string $data
 * @param int $multiple
 * @param string $headers
 * @return
 */
function CurlPost($url, $data = '', $multiple = 1, $headers = '')
{

    $ch =   curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    if ($headers) {

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }
    if ($data != '') {

        curl_setopt($ch, CURLOPT_POST, 1);
        if ($multiple == 1) {

            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        } elseif ($multiple == 2) {

            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $Return = curl_exec($ch);
    if (curl_errno($ch)) {
        //echo 'Errno'.curl_error($ch);
    }
    curl_close($ch);
    return $Return;
}

/**
 * CURL GET提交
 * @param $url
 * @return
 */
function CurlGet($url)
{
    $ch         =   curl_init();
    $timeout    =   20;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 跳过证书检查
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);  // 从证书中检查SSL加密算法是否存在
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $Return     =   curl_exec($ch);
    if (curl_errno($ch)) {
        //echo 'Errno' . curl_error($ch);
    }
    curl_close($ch);
    return $Return;
}

/**
 * 跳转手机页面
 * @param $config
 * @return string
 */
function wapJump($config)
{

    global $ModuleName;
    $Loaction   =   '';
    $mArray     =   array('qqconnect', 'sinaconnect', 'call', 'datav');
    $cArray     =   array('clickhits', 'wjump');

    if ($config['sy_wap_jump'] == '1' && !in_array($ModuleName, $mArray) && !in_array($_GET['c'], $cArray)) {

        if (isMobileUser() && !strpos(strtolower($_SERVER['REQUEST_URI']), 'wap') && $_SERVER['HTTP_HOST'] != $config['sy_wapdomain']) {

            include(PLUS_PATH . "jump.cache.php");

            if ($_GET['c']) {
                if ($ModuleName =='article' && $_GET['c'] == 'list'){

                }else{
                    $_GET['a']  =   $_GET['c'];
                }
            }
            if ($ModuleName && $ModuleName != 'index') {
                $_GET['c']  =   $ModuleName;
                if (isset($wapA) && $wapA[$ModuleName][$_GET['a']]) {

                    $_GET['a']  =   $wapA[$ModuleName][$_GET['a']];
                }
            }
            if ($_GET['c']) {
                $jumpGet['c']   =   $_GET['c'];
                unset($_GET['c']);
            }
            if ($_GET['a']) {
                $jumpGet['a']   =   $_GET['a'];
                unset($_GET['a']);
            }

            if (!empty($_GET)) {

                foreach ($_GET as $key => $value) {

                    if ($key == 'keyword') {
                        $jumpGet[$key] = $value;
                    }

                    if ($key == 'code') {
                        $jumpGet[$key] = $value;
                    }

                    if ($value != 0 && !empty($value)) {

                        $jumpGet[$key] = $value;
                    }
                }
            }

            $Loaction   =   Url('wap', $jumpGet);

            // 处理分站目录跳转
            if (isset($_GET['indexdir'])) {

                $indexDir   =   $_GET['indexdir'];

                unset($_GET['indexdir']);

                if (strpos($Loaction, $config['sy_wapdomain'])) {

                    $Loaction   =   $Loaction . $indexDir;
                } else {

                    $Loaction   =   str_replace('/indexdir_' . $indexDir . '.html', '/' . $indexDir . '/', $Loaction);
                }
            }
        }
    }
    return $Loaction;
}

/**
 * 使用终端是否手机判断方法
 * @return bool
 */
function isMobileUser()
{

    $uachar =   '/(nokia|sony|ericsson|mot|samsung|sgh|lg|philips|panasonic|alcatel|lenovo|cldc|midp|mobile|phone|iphone|ipad|ipod|android|symbian|smartphone)/i';

    $ua     =   strtolower($_SERVER['HTTP_USER_AGENT']);

    if (preg_match($uachar, $ua)) {

        return true;
    } else {

        return false;
    }
}

/**
 * 获取随机数
 * @param int $length
 * @return
 */
function gt_Generate_code($length = 6)
{
    return rand(pow(10, ($length - 1)), pow(10, $length) - 1);
}

/**
 * @param $config
 * @return string[]
 */
function verifytoken($config)
{

    if ($config['code_kind'] == '3') {

        $check  =   gtGeetest($config);
    } elseif ($config['code_kind'] == '4') {

        $check  =   dxauthcode($config);
    } elseif ($config['code_kind'] == '5') {

        $check  =   vaptchacode($config);
    }
    if ($check) {
        return array('code' => '200');
    } else {
        switch ($config['code_kind']) {
            case '3' :
                $msg = '请滑动滑块进行验证！';
                break;
            case '4' :
                $msg = '请拖动滑块进行验证';
                break;
            case '5' :
                $msg = '请绘制图中手势按钮进行验证';
                break;
        }

        return array('code' => '0', 'msg' => $msg);
    }

}

/**
 * 手势验证码
 * @param array $config
 * @return bool
 */
function vaptchacode($config = array())
{

    if (empty($config)) {

        include(PLUS_PATH . 'config.php');
    }

    $url                =   'http://0.vaptcha.com/verify';
    $data['id']         =   $config['sy_vaptcha_vid'];
    $data['secretkey']  =   $config['sy_vaptcha_key'];
    $data['scene']      =   0;
    $data['token']      =   $_POST['verify_token'];
    $data['ip']         =   fun_ip_get();

    $CurlReturn         =   CurlPost($url, $data);

    $vaptchaReturn      =   json_decode($CurlReturn);
    if ($vaptchaReturn->success == '1') {

        return true;
    } else {

        return false;
    }
}

/**
 * 获取极验验码
 * @param array $config
 * @return bool
 */
function gtGeetest($config = array())
{

    if ($_POST['verify_token']) {

        $token  =   @explode('*', $_POST['verify_token']);

        $_POST['geetest_challenge'] =   $token[0];
        $_POST['geetest_validate']  =   $token[1];
        $_POST['geetest_seccode']   =   $token[2];
    }

    if ($_POST['geetest_challenge'] && $_POST['geetest_validate'] && $_POST['geetest_seccode']) {
        if (!isset($_SESSION)) {
            session_start();
        }
        require_once LIB_PATH . '/class.geetestlib.php';
        if (!$config) {
            include(PLUS_PATH . 'config.php');
        }
        $GtSdk      =   new GeetestLib($config['sy_geetestid'], $config['sy_geetestkey']);
        $user_id    =   $_SESSION['user_id'];
        $data       =   array(
            "user_id"       =>  $user_id, # 网站用户id
            "client_type"   =>  "web", #web:电脑上的浏览器；h5:手机上的浏览器
            "ip_address"    =>  "127.0.0.1" # 请在此处传输用户请求验证时所携带的IP
        );

        if ($_SESSION['gtserver'] == 1) {   //服务器正常
            $result =   $GtSdk->success_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode'], $data);
            if ($result) {
                return true;
            } else {
                return false;
            }
        } else {  //服务器宕机,走failback模式
            if ($GtSdk->fail_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode'])) {
                return true;
            } else {
                return false;
            }
        }
    } else {
        return false;
    }
}

/**
 * 检验顶象验证码
 * @param array $config
 * @return bool
 */
function dxauthcode($config = array())
{
    include(LIB_PATH . "dxCaptchaClient.class.php");

    /**
     *  构造入参为appId和appSecret :
     *      appId和前端验证码的appId保持一致，appId可公开
     *      appSecret为秘钥，请勿公开
     *
     *      token在前端完成验证后可以获取到，随业务请求发送到后台，token有效期为两分钟
     */
    $appId      =   $config['sy_dxappid'];
    $appSecret  =   $config['sy_dxappsecret'];
    $client     =   new CaptchaClient($appId, $appSecret);
    $client->setTimeOut(2);      //设置超时时间，默认2秒
    # $client->setCaptchaUrl("http://cap.dingxiang-inc.com/api/tokenVerify");

    //特殊情况可以额外指定服务器，默认情况下不需要设置
    $response   =   $client->verifyToken($_POST['verify_token']);

    //确保验证状态是SERVER_SUCCESS，SDK中有容错机制，在网络出现异常的情况会返回通过
    if($response->serverStatus == 'SERVER_SUCCESS'){
        return true;
        /**token验证通过，继续其他流程**/
    } else {
        return false;
        /**token验证失败**/
    }
}

/**
 * 获取数字验码
 */
function gtverify()
{
    if (md5(strtolower($_POST['authcode'])) != $_SESSION['authcode'] || empty($_SESSION['authcode'])) {
        unset($_SESSION['authcode']);
        return false;
    }
    return true;
}

/**
 * @return bool
 */
function is_weixin()
{
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
        return true;
    }
    return false;
}

/**
 * @param array $parseDate
 * @param $time
 * @param $domain
 */
function setcookies($parseDate = array(), $time, $domain)
{

    $domain =   get_domain($domain);
    if (is_array($parseDate)) {
        foreach ($parseDate as $key => $value) {
            SetCookie($key, $value, $time, "/", $domain);
        }
    }
}

// 上面方法得到的密文太长，不适合放入承载信息有限的二维码中
// 加密
function yunEncrypt($str, $key)
{
    $key    =   md5($key);
    $k      =   md5(rand(0, 100)); // 相当于动态密钥
    $k      =   substr($k, 0, 3);
    $tmp    =   "";
    for ($i = 0; $i < strlen($str); $i++) {
        $tmp .= substr($str, $i, 1) ^ substr($key, $i, 1);
    }
    return base64_encode($k . $tmp);
}

// 解密
function yunDecrypt($str, $key)
{
    $len    =   strlen($str);
    $key    =   md5($key);
    $str    =   base64_decode($str);
    $str    =   substr($str, 3, $len - 3);
    $tmp    =   "";
    for ($i = 0; $i < strlen($str); $i++) {
        $tmp .= substr($str, $i, 1) ^ substr($key, $i, 1);
    }
    return $tmp;
}

/**
 * 数组排序
 */
function my_sort($prev, $next)
{
    if ($prev['value'] == $next['value']) return 0;
    return ($prev['value'] < $next['value']) ? 1 : -1;
}
/**
 * @param $prev
 * @param $next
 * @return int
 */
function t_sort($prev, $next)
{
    $p  =   strtotime($prev);
    $n  =   strtotime($next);
    if ($p == $n) return 0;
    return ($p > $n) ? 1 : -1;
}


/**
 * 判断当前服务器是windows系统还是其他系统
 */
function isServerOsWindows()
{
    return stristr(php_uname('s'), 'window') ? true : false;
}

/**
 * @param $serial_str
 * @return mixed
 */
function mb_unserialize($serial_str)
{
    $serial_str = str_replace("\r", "", $serial_str);
    $serial_str = preg_replace_callback('/s:\d+:"(.+?)";/s', 'checkunserialize', $serial_str);
    return unserialize($serial_str);
}

/**
 * @param $r
 * @return string
 */
function checkunserialize($r)
{
    $n = strlen($r[1]);
    return "s:$n:\"$r[1]\";";
}

/**
 * 隐藏部分用户名：手机号或者邮箱
 * @param $str
 * @return string
 */
function sub_string($str)
{

    $length     =   mb_strlen($str);
    if ($length > 5 && (CheckMobile($str) || CheckRegEmail($str))) {

        $str    =   mb_substr($str, 0, 3) . '****' . mb_substr($str, $length - 4, 4);
    }
    return $str;
}

/**
 * 检查图片路径，该路径是否有图片，没有图片替换指定图片
 * @param string $post 默认图片路径
 * @param string $url 现有路径
 * @return string
 */
function checkpic($url = '', $post = '')
{

    global $config;

    if (isset($config['sy_oss']) && $config['sy_oss'] == 1) {
        $curl = $config['sy_ossurl'];
    } else {
        $curl = $config['sy_weburl'];
    }

    $picurl = '';

    if ($url != '') {

        if (strstr($url, 'http') !== false || strstr($url, 'https') !== false) {

            $picurl = $url;

        } else {

            if (strstr($url, '../data') !== false) {

                $picurl = str_replace('../data', $curl . '/data', $url);

            } elseif (strstr($url, './data') !== false) {

                $picurl = str_replace('./data', $curl . '/data', $url);

            } elseif (strstr($url, '/data') !== false) {

                $picurl = str_replace('/data', $curl . '/data', $url);
            } elseif (strstr($url, '.data') !== false) {

                $picurl = str_replace('.data', $curl . '/data', $url);

            } else {

                $picurl = $curl . '/' . $url;
            }
        }
    } else {

        if ($post != '') {

            if (strstr($post, 'http') !== false || strstr($url, 'https') !== false) {

                $picurl = $post;
            } else {
                $picurl = $curl . '/' . $post;

            }
        }
    }
    return $picurl;
}

/**
 * 全局密码生成函数
 * @param $pass
 * @param string $salt
 * @param string $oldpass
 * @return bool
 */
function passCheck($pass, $salt = '', $oldpass = '')
{

    include_once(LIB_PATH . "pwdtype/phpyunpass.php");
    return passwordCheck($pass, $salt, $oldpass);
}

/**
 * @param string $weburl
 * @return string
 */
function getprotocol($weburl = '')
{

    if ($weburl) {
        if (strpos($weburl, 'https://') !== false) {

            $protocol   =   'https://';
        } else {

            $protocol   =   'http://';
        }
    } else {

        $protocol       =   ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
    }
    return $protocol;
}

/**
 * @desc 时间日期格式化为多少天前/后
 *
 * @param sting/int $date_time
 * @param int $type 1、'Y-m-d H:i:s' 2、时间戳
 * @param int $before 1、前 2、后 3、剩余多少天 4、过期多少天
 * @param string $format
 * @return string
 */
function format_datetime($date_time, $type = 1, $before = 1, $format = '')
{
    if ($type == 1) {

        $timestamp  =   strtotime($date_time);
    } elseif ($type == 2) {

        $timestamp  =   $date_time;
    }

    if (!empty($format)) {

        return date($format, $timestamp);
    }

    if ($before == 1) {

        $difference =   time() - $timestamp;

        $today      =   strtotime('today');

        if ($timestamp > $today) {

            return '今天';
        } elseif ($timestamp > ($today - 86400) ) {

            return '昨天';
        } else {

            return ceil($difference / 86400) . '天前';
        }

    } else if ($before == 2) {

        $today      =   strtotime(date('Y-m-d'));
        $tomorrow   =   $today + 86400;
        if ($timestamp < $tomorrow) {

            return '今天';
        } elseif ($timestamp < ($tomorrow + 86400)) {

            return '明天';
        } elseif ($timestamp < ($tomorrow + 172800)) {

            return '后天';
        } elseif ($timestamp < ($tomorrow + 604800)) {

            return '一周后';
        } elseif ($timestamp < ($tomorrow + 2952000)) {

            return '一月后';
        }else{
            
            $difference =   $timestamp - time();
            return ceil($difference / 86400) . '天后';
        }
    }else if($before == 3){

        $difference =   $timestamp - time();
        return "剩余 ". ceil($difference / 86400) . ' 天';
    }else if($before == 4){

        $difference =   time() - $timestamp;
        return '过期 '.ceil($difference / 86400) . ' 天';
    }
}

/**
 * @desc 刷新时间日期格式化为多少分钟前；int $type 1、多少分钟前 2、多少小时前 3、'i:s'
 *
 * @param sting/int $date_time
 * @return string
 */
function lastupdateStyle($date_time)
{
    global $config;

    $type           =   $config['sy_updates_set'];
    $updateTime     =   floor((time() - $date_time) / 3600);
    if ($date_time < time() && $date_time > strtotime('today')) {

        if ($type == 1) {

            return date('H:i', $date_time);
        } elseif ($type == 2) {
            if ($updateTime >= 1) {

                return $updateTime . '小时前';
            } else {

                return ceil((time() - $date_time) / 60) . '分钟前';
            }
        }
    } else {
        return date('Y-m-d', $date_time);
    }
}
/**
 * 时间格式化：今天（时.分） 今年（月.日） 其他（年-月-日）
 * @param string $time
 */
function timeForYear($time){
    
    if($time > strtotime('today')){
        
        $str  =  '今天 '.date('H:i', $time);
        
    }else if($time > mktime(0,0,0,1,1,date('Y'))){
        
        $str  =  date('m月d日', $time);
        
    }else{
        
        $str  =  date('Y-m-d', $time);
    }
    return $str;
}
/**
 * 处理掉二维数组中值为空的参数
 * @param $arr
 * @return mixed
 */
function removeEmpty($arr)
{

    foreach ($arr as $k => $v) {
        foreach ($v as $mk => $mv) {
            if (empty($mv)) {
                unset($arr[$k][$mk]);
            }
        }
    }
    return $arr;
}

/**
 * 判断会员是否到期
 * @param int $endtime
 * @return boolean
 */
function isVip($endtime = 0)
{

    if ($endtime >= strtotime('today') || $endtime == 0) {

        return true;
    } else {

        return false;
    }
}

function changeSalary($salary)
{
    global $config;
    if ($salary > 0) {
        if ($config['resume_salarytype'] == 2) {
            $result = floor($salary / 1000 * 10) / 10 . '千';
        } elseif ($config['resume_salarytype'] == 3) {
            $result = floor($salary / 1000 * 10) / 10 . 'K';
        } elseif ($config['resume_salarytype'] == 4) {
            $result = floor($salary / 1000 * 10) / 10 . 'k';
        }
    }

    return $result;
}

/**
 * 产生随机字符串
 */
function createstr($length = 10)
{

    $chars = "abfghijklmprtvwyz0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
        $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
}

function checkMsgOpen($config)
{

    if ($config["sy_msg_appkey"] == "" || $config["sy_msg_appsecret"] == "" || $config['sy_msg_isopen'] != '1') {

        return false;
    } else {

        return true;
    }
}

/**
 * @desc    时间戳 转化 为具体时间格式
 *          1：当天时间（09：30）
 *          2：当年时间（5月20日）
 *          3：今年之前（2020.05.20）
 * @param   $time
 * @return  false|string
 */
function formatTime($time){

    if ($time > strtotime(date('Y-m-d'))) {

        $time_n =   '今天 '.date('H:i', $time);
    } else if ($time > mktime(0, 0, 0, 1, 1, date('Y'))) {

        $time_n =   date('m月d日', $time);
    } else {

        $time_n =   date('Y-m-d', $time);
    }

    return  $time_n;
}

/**
 * 简历工作经历平均时间 XX月 调整  X年X 月
 * @param $long
 * @return string
 */
function avgToYm($long)
{
    if ($long >= 12) {

        if (bcmod($long, 12) > 0) {

            $return = floor($long / 12) . '年' . bcmod($long, 12);
        } else {

            $return = floor($long / 12) . '年';
        }

    } else {

        $return = $long;
    }

    return $return;
}

?>