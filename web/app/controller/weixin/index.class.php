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

class index_controller extends common
{

    function index_action()
    {

        $M  =   $this->MODEL('weixin');

        if ($_GET["echostr"]) {

            $M->valid($_GET['echostr'], $_GET['signature'], $_GET['timestamp'], $_GET['nonce']);
        } else {

            $postStr    =   file_get_contents("php://input");

            if (!empty($postStr)) {

                libxml_disable_entity_loader(true);

                $postObj        =   simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername   =   $this->gpc2sql($postObj->FromUserName);
                $toUsername     =   $this->gpc2sql($postObj->ToUserName);
                $keyword        =   trim($this->gpc2sql($postObj->Content));
                $times          =   time();
                $MsgType        =   $postObj->MsgType;

                $topTpl         =   "<xml>
				   <ToUserName><![CDATA[%s]]></ToUserName>
				   <FromUserName><![CDATA[%s]]></FromUserName>
				   <CreateTime>%s</CreateTime>
				   <MsgType><![CDATA[%s]]></MsgType>
				   ";

                $bottomStr      =   "<FuncFlag>0</FuncFlag></xml>";

                //默认定义
                $this->MsgType  =   'text';
                $centerStr      =   "<Content><![CDATA[未找到相关数据]]></Content>";

                if ($MsgType == 'event') {

                    $MsgEvent   =   $postObj->Event;

                    if ($MsgEvent == 'subscribe') {

                        //判断是否为带参数扫码登录
                        if (!empty($postObj->EventKey)) {

                            //取出场景值
                            $wxloginid  =   str_replace('qrscene_', '', $postObj->EventKey);

                            //判断场景来源
                            if (strpos($wxloginid, 'weixin_') !== false) {

                                //场景码回复图文消息
                                $Return         =   $M->sendPubLink($wxloginid);
                                $centerStr      =   $Return['centerStr'];
                                $this->MsgType  =   $Return['MsgType'];

                                //调用客服消息发送关注欢迎语
                                $M->sendCustom($fromUsername, 'text');

                                //调用客服消息发送增量欢迎方式 图片/小程序
                                if ($this->config['wx_welcom_type'] == 'wxcompic') {

                                    $M->sendCustom($fromUsername, 'image');
                                } elseif ($this->config['wx_welcom_type'] == 'wxcomxcx') {

                                    $M->sendCustom($fromUsername, 'miniprogrampage');
                                }
                            } elseif (strpos($wxloginid, 'xcx_') !== false) {

                                //获取场景码对应小程序卡片数据
                                $xcxInfo    =   $M->getXcxPubLink($wxloginid);

                                //调用客服消息发送欢迎语
                                $M->sendCustom($fromUsername);

                                //如果有增量欢迎方式 只发送图片 小程序不发送与下方重复
                                if ($this->config['wx_welcom_type'] == 'wxcompic') {

                                    $M->sendCustom($fromUsername, 'image', array());
                                }

                                //调用客服消息发送场景码对应小程序卡片
                                $M->sendCustom($fromUsername, 'miniprogrampage', $xcxInfo);

                                //返回success
                                echo "success";
                                exit();
                            } else {

                                $loginType  =   $M->isWxlogin($fromUsername, $wxloginid);

                                if (is_array($loginType)) {

                                    $result = $loginType['result'];
                                    $utype = $loginType['type'];
                                } else {

                                    $result = $loginType;
                                }
                                if (!$result) {
                                    if (isset($utype) && $utype == 'amminwxbind') {

                                        $centerStr = "<Content><![CDATA[要绑定的管理员账号不存在！]]></Content>";
                                    } else {
                                        if (isset($utype) && $utype == 'regbindacount') {

                                            $centerStr = "<Content><![CDATA[扫码成功,请绑定已有账号或直接创建新账号！]]></Content>";
                                        } else if ($utype == 'regphone') {

                                            $centerStr = "<Content><![CDATA[扫码成功，基于安全需要，请绑定手机号，绑定后可以使用该手机号快速登录]]></Content>";
                                        } else {

                                            $centerStr = "<Content><![CDATA[扫码关注成功！]]></Content>";
                                        }
                                    }
                                } else {
                                    if (isset($utype) && $utype == 'amminwxbind' || $utype == 'userwxbind') {

                                        $centerStr = "<Content><![CDATA[扫码绑定成功！]]></Content>";
                                    } else {

                                        $centerStr = "<Content><![CDATA[扫码登录成功！]]></Content>";
                                    }
                                }
                                $this->MsgType = 'text';
                            }

                        } else {

                            if (!$this->config['wx_welcom_type'] || $this->config['wx_welcom_type'] == 'nowxcom') {

                                if ($this->config['wx_welcom']) {

                                    $centerStr = "<Content><![CDATA[" . $this->config['wx_welcom']."]]></Content>";
                                } else {

                                    $centerStr = "<Content><![CDATA[欢迎您关注" . $this->config['sy_webname'] . "！\n 1：您可以直接回复关键字如【销售】、【销售 XX公司】查找您想要的职位\n绑定您的账户体验更多精彩功能\n感谢您的关注！"."]]></Content>";
                                }
                                //发送红包
                                $wxRedPackM = $this->MODEL('wxredpack');
                                $wxRedPackM->sendRedPack(array('type' => '1', 'openid' => $fromUsername));
                                $this->MsgType = 'text';
                            } else {

                                //调用客服消息发送关注欢迎语
                                $M->sendCustom($fromUsername, 'text');

                                //调用客服消息发送增量欢迎方式 图片/小程序
                                if ($this->config['wx_welcom_type'] == 'wxcompic') {

                                    $M->sendCustom($fromUsername, 'image', array());
                                } elseif ($this->config['wx_welcom_type'] == 'wxcomxcx') {

                                    $M->sendCustom($fromUsername, 'miniprogrampage');
                                }

                                //发送红包
                                $wxRedPackM = $this->MODEL('wxredpack');
                                $wxRedPackM->sendRedPack(array('type' => '1', 'openid' => $fromUsername));

                                echo "success";
                                exit();
                            }
                        }
                    } else if ($MsgEvent == 'SCAN'){ //已关注二维码待参数事件

                        //判断是否为带参数扫码登录

                        $wxloginid  =   $postObj->EventKey;

                        //判断场景来源
                        if (strpos($wxloginid, 'weixin_') !== false) {

                            //场景码回复图文消息
                            $Return         =   $M->sendPubLink($wxloginid);
                            $centerStr      =   $Return['centerStr'];
                            $this->MsgType  =   $Return['MsgType'];

                        } elseif (strpos($wxloginid, 'xcx_') !== false) {

                            //获取场景码对应小程序卡片数据
                            $xcxInfo        =   $M->getXcxPubLink($wxloginid);

                            //调用客服消息发送场景码对应小程序卡片
                            $M->sendCustom($fromUsername, 'miniprogrampage', $xcxInfo);

                            //返回success
                            echo "success";
                            exit();
                        } else {

                            //未绑定则提示
                            $loginType      =   $M->isWxlogin($fromUsername, $wxloginid);
                            if (is_array($loginType)) {

                                $result     =   $loginType['result'];
                                $utype      =   $loginType['type'];
                            } else {

                                $result     =   $loginType;
                            }
                            if (!$result) {
                                if (isset($utype) && $utype == 'amminwxbind') {

                                    $centerStr      =   "<Content><![CDATA[要绑定的管理员账号不存在！]]></Content>";
                                } else {
                                    if (isset($utype) && $utype == 'regbindacount') {

                                        $centerStr  =   "<Content><![CDATA[扫码成功,请绑定已有账号或直接创建新账号！]]></Content>";
                                    } else if ($utype == 'regphone') {

                                        $centerStr  =   "<Content><![CDATA[扫码成功，基于安全需要，请绑定手机号，绑定后可以使用该手机号快速登录！]]></Content>";
                                    } else {
                                        $centerStr  =   "<Content><![CDATA[扫码关注成功！]]></Content>";
                                    }
                                }
                            } else {
                                if (isset($utype) && $utype == 'amminwxbind' || $utype == 'userwxbind') {

                                    $centerStr      =   "<Content><![CDATA[扫码绑定成功！]]></Content>";
                                } else {

                                    $centerStr      =   "<Content><![CDATA[扫码登录成功！]]></Content>";
                                }
                            }
                            $this->MsgType = 'text';
                        }
                    } else if ($MsgEvent == 'CLICK') {

                        $ismatch    =   true;
                        $EventKey   =   $postObj->EventKey;

                        if ($EventKey == '我的帐号') {

                            $Return =   $M->bindUser($fromUsername);
                        } elseif ($EventKey == '我的消息') {

                            $Return =   $M->myMsg($fromUsername);
                        } elseif ($EventKey == '面试邀请') {

                            $Return =   $M->Audition($fromUsername);
                        } elseif ($EventKey == '简历浏览') {

                            $Return =   $M->lookResume($fromUsername);
                        } elseif ($EventKey == '刷新简历') {

                            $Return =   $M->refResume($fromUsername);
                        } elseif ($EventKey == '推荐职位') {

                            $Return =   $M->recJob($fromUsername);
                        } elseif ($EventKey == '刷新职位') {

                            $Return =   $M->refJob($fromUsername);
                        } elseif ($EventKey == '职位浏览') {

                            $Return =   $M->lookJob($fromUsername);
                        } elseif ($EventKey == '简历投递') {

                            $Return =   $M->ApplyJob($fromUsername);
                        } elseif ($EventKey == '兼职报名') {

                            $Return =   $M->PartApply($fromUsername);
                        } elseif ($EventKey == '职位搜索') {

                            if ($this->config['wx_search']) {

                                $Return['centerStr']    =   "<Content><![CDATA[" . $this->config['wx_search'] . "]]></Content>";
                            } else {

                                $Return['centerStr']    =   "<Content><![CDATA[直接回复城市、职位、公司名称等关键字搜索您需要的职位信息。\n 如：【经理】、【xx公司】]]></Content>";
                            }

                            $Return['MsgType']          =   'text';

                        } elseif ($EventKey == '周边职位') {

                            $Return['centerStr']        =   "<Content><![CDATA[/可怜 亲，把您的位置先发我一下。\n\n方法：点屏幕左下角输入框旁的“+”，选择“位置”，点“发送”。]]></Content>";
                            $Return['MsgType']          =   'text';
                        }else{
                            $ismatch  =  false;
                        }
                        if ($ismatch){
                            // 按照已有程序，匹配到的，回复匹配到的内容
                            $centerStr      =   $Return['centerStr'];
                            $this->MsgType  =   $Return['MsgType'];
                        }else{
                            // 没有匹配到的，按自动回复处理
                            $Returnone      =   $M->searchKeyword($EventKey);
                            $centerStr      =   $Returnone['centerStr'];
                            $this->MsgType  =   $Returnone['MsgType'];
                        }
                    }
                } elseif ($MsgType == 'LOCATION') {

                    $latitude   =   $postObj->Location_X;
                    $longitude  =   $postObj->Location_Y;
                    $url        =   "http://api.map.baidu.com/geocoder/v2/?ak=42966293429086ba859198a2a69bedad&callback=renderReverse&location=" . $latitude . "," . $longitude . "&output=json";
                    $mapinfo    =   file_get_contents($url);
                    $mapinfo    =   str_replace(array('renderReverse&&renderReverse(', ')'), '', $mapinfo);
                    $map_info   =   json_decode($mapinfo, true);

                    if ($map_info['result']['addressComponent']['district']) {

                        $Return         =   $M->searchJob($map_info['result']['addressComponent']['district'], 1);
                        $centerStr      =   $Return['centerStr'];
                        $this->MsgType  =   $Return['MsgType'];
                    } else {

                        $Return['centerStr']    =   "<Content><![CDATA[未找到相关数据]]></Content>";
                        $Return['MsgType']      =   'text';
                    }

                } else if ($MsgType == 'text') {

                    if ($keyword) {

                        $Returnone      =   $M->searchKeyword($keyword);
                        $centerStr      =   $Returnone['centerStr'];
                        $this->MsgType  =   $Returnone['MsgType'];
                    }
                    if ($Returnone['centerStr'] == "") {

                        $Returntwo      =   $M->searchJob($keyword);
                        $centerStr      =   $Returntwo['centerStr'];
                        $this->MsgType  =   $Returntwo['MsgType'];
                    }
                }

                $topStr = sprintf($topTpl, $fromUsername, $toUsername, $times, $this->MsgType);
                echo $topStr . $centerStr . $bottomStr;
            }
        }
    }

    function gpc2sql($str)
    {

        $arr    =   array("sleep" => "Ｓleep", " and " => " an d ", " or " => " Ｏr ", "xor" => "xＯr", "%20" => " ", "select" => "Ｓelect", "update" => "Ｕpdate", "count" => "Ｃount", "chr" => "Ｃhr", "truncate" => "Ｔruncate", "union" => "Ｕnion", "delete" => "Ｄelete", "insert" => "Ｉnsert", "\"" => "“", "'" => "“", "--" => "- -", "\(" => "（", "\)" => "）", "00000000" => "OOOOOOOO", "0x" => "Ox", "0b" => "Ob");
        foreach ($arr as $key => $v) {
            $str = preg_replace('/' . $key . '/isU', $v, $str);
        }
        return $str;
    }

    /**
     * 处理公众号绑定微信开放平台之前关注公众号绑定微信用户，获取unionid
     */
    function pcwxbdAll_action()
    {

        $userInfoM  =   $this->MODEL('userinfo');
        $count      =   $userInfoM->getMemberNum(array('wxid' => array('<>', '')));

        $size       =   30;
        //循环次数
        $num        =   ceil($count / $size);

        if (!$_GET['num']) {

            $i      =   0;
        } else {

            $i      =   $_GET['num'];
        }

        $rows       =   $userInfoM->getList(array('wxid' => array('<>', ''), 'limit' => array($i * $size, $size), 'orderby' => 'uid,asc'), array('field' => '`uid`,`wxid`,`unionid`'));

        $weixinM    =   $this->MODEL('weixin');

        foreach ($rows as $v) {

            if (empty($v['unionid'])) {

                $info   =   $weixinM->getWxUser($v['wxid']);

                if (!empty($info['unionid'])) {

                    $userInfoM->upInfo(array('uid' => $v['uid']), array('unionid' => $info['unionid']));
                }
            }
        }

        if (($i + 1) >= $num) {

            echo "完成";
        } else {

            $getnum =   $i + 1;

            echo "<script>location.href='" . $this->config['sy_weburl'] . "/weixin/index.php?c=pcwxbdAll&num=" . $getnum . "';</script>";
        }
    }

    /**
     * 处理微信小程序绑定微信开放平台之前在小程序内绑定微信用户，获取unionid
     */
    function wxappbdAll_action()
    {

        $userInfoM  =   $this->MODEL('userinfo');
        $count      =   $userInfoM->getMemberNum(array('wxopenid' => array('<>', '')));

        $size       =   30;
        //循环次数
        $num        =   ceil($count / $size);

        if (!$_GET['num']) {
            $i      =   0;
        } else {
            $i      =   $_GET['num'];
        }

        $rows       =   $userInfoM->getList(array('wxopenid' => array('<>', ''), 'limit' => array($i * $size, $size), 'orderby' => 'uid,asc'), array('field' => '`uid`,`wxopenid`,`unionid`'));

        $weixinM    =   $this->MODEL('weixin');

        foreach ($rows as $v) {

            if (empty($v['unionid'])) {

                $info   =   $weixinM->getWxUser($v['wxopenid']);

                if (!empty($info['unionid'])) {

                    $userInfoM->upInfo(array('uid' => $v['uid']), array('unionid' => $info['unionid']));
                }
            }
        }

        if (($i + 1) >= $num) {

            echo "完成";
        } else {

            $getnum =   $i + 1;
            echo "<script>location.href='" . $this->config['sy_weburl'] . "/weixin/index.php?c=wxappbdAll&num=" . $getnum . "';</script>";
        }
    }
}

?>