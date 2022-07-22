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

class xcx_model extends model
{

    //获取微信小程序 TOKEN
    public function getWxxcxToken()
    {
        $configcache    =   array();
        include(PLUS_PATH.'configcache.php');

        $Token          =   $configcache['wxxcx_token'];
        $TokenTime      =   $configcache['wxxcx_token_time'];

        $NowTime        =   time();

        if (($NowTime - $TokenTime) > 7000 || empty($Token)) {

            @include(DATA_PATH.'api/wxpay/wxpay_data.php');
            if($wxpaydata['sy_xcxappid'] && $wxpaydata['sy_xcxsecret']){

                $Appid      =   $wxpaydata['sy_xcxappid'];
                $Appsecert  =   $wxpaydata['sy_xcxsecret'];
                $Url        =   'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $Appid . '&secret=' . $Appsecert;
                $CurlReturn =   CurlPost($Url);

                $Token      =   json_decode($CurlReturn);

                $configcache['wxxcx_token']         =   $Token->access_token;
                $configcache['wxxcx_token_time']    =   time();

                made_web(PLUS_PATH.'configcache.php', ArrayToString($configcache), 'configcache');
            }
            return $configcache['wxxcx_token'];

        } else {

            return $Token;
        }
    }

    public function getQrcode($data = array())
    {
        $token  =   $this->getWxxcxToken();
        if($token){
            $post   =   array(
                'scene' => 'id=' . $data['id'],
                'width' => '280'
            );
            if ($data['type'] == 'job') {

                $post['page'] = 'pages/job/show';

            } elseif ($data['type'] == 'company') {

                $post['page'] = 'pages/company/show';
            }

            $Url        =   'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=' . $token;
            $CurlReturn =   CurlPost($Url, json_encode($post));
            $qrcode     =   json_decode($CurlReturn, true);

            header("Content-type: image/png");
            echo $CurlReturn;
        }
        
    }

	public function getUrlLink($data = array())
    {

        $token  =   $this->getWxxcxToken();
        if($token){
            $post   =   array(
                'query' => 'id=' . $data['id'],
            );

            if ($data['type'] == 'job') {

                $post['path'] = 'pages/job/show';

            } elseif ($data['type'] == 'company') {

                $post['path'] = 'pages/company/show';

            } elseif ($data['type'] == 'resume') {

                $post['path'] = 'pages/resume/show';
            }
            
            $post['is_expire']      = true;
            
            $post['expire_type']    = 0;

            $post['expire_time']    = time() + '2591000';
            
            $scene_str = $post['path'].'/'.$post['query'];
            //查询识别ID对应的url是否存在或失效
            $wxqrcode   =   $this->select_once('wxqrcode', array('wxloginid' => $scene_str));
        
            if(!empty($wxqrcode)){
            
                if($wxqrcode['time'] >= (time()- 86400)){//留出容错时间,一天内不重复生成
                    $ticket =  $wxqrcode['ticket'];
                    return $ticket;
                }else{
                    $this   ->  delete_all('wxqrcode',array('wxloginid'=>$scene_str), '', '', 1);
                }
            }

            $Url        =   'https://api.weixin.qq.com/wxa/generate_urllink?access_token=' . $token;
            $CurlReturn =   CurlPost($Url, json_encode($post));
            $urlCode     =   json_decode($CurlReturn, true);
        
            //插入数据库
            if($urlCode['url_link']){
                
                $warr    =   array('wxloginid' => $scene_str, 'ticket' => $urlCode['url_link'], 'time' => time(), 'status' => 0);
                
                $this->insert_into('wxqrcode', $warr);
                
                $ticket = $urlCode['url_link'];
            }
        }
        

        return $ticket;
    }
}

?>