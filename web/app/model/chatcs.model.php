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
class chatcs_model extends model{
    /**
     *  未登录用户获取聊天登录参数
     */
    function getUnloginToken($ct = '', $data = array())
    {
        $return    =  array();
        $appkey    = trim($this->config['sy_chat_appkey']);
        $appsecret = trim($this->config['sy_chat_appsecret']);
        
        if (!empty($appkey) && !empty($appsecret)){
            // 后台和前台进行区分
            if ($ct == 'admin'){
                // 后台
                $u =  'a'.$data['auid'];
                $return['mine'] = array(
                    'id' => $u,
                    'linkman' => '官方客服',
                    'username' => '求职助手',
                    'usertype' => 9,
                    'avatar' => checkpic($this->config['sy_chat_logo'])
                );
            }else{
                if (isset($data['chat_u'])){
                    // 移动端
                    $u  =  $data['chat_u'];
                }elseif (isset($_COOKIE['chat_u'])){
                    // pc/wap
                    $u  =  $_COOKIE['chat_u'];
                }else{
                    $time = time();
                    $u  =  'u'. $time . mt_rand(100000, 999999);
                    
                    require_once ('cookie.model.php');
                    $cookieM  =  new cookie_model($this->db, $this->def);
                    $cookieM->SetCookie('chat_u', $u, $time + 86400);
                }
                $return['mine'] = array(
                    'id' => $u,
                    'uname' => '匿名',
                    'avatar' => checkpic($this->config['sy_chat_logo'])
                );
            }
            
            $return['data']  =  array(
                'uid'       =>  $u,
                'webKey'    =>  $appkey,
                'yuntoken'  =>  md5($appkey . $u . $appsecret)
            );
        }
        
        return $return;
    }
}
?>