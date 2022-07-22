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
class trtc_model extends model{

    /**
     * 获取进视频面试房间参数
     */
    function getUserSig($data = array()){
        
        $return  =  array();
        
        if (!empty($data['uid'])){
            
            $trtc  =  $this->select_once('trtc', array('uid'=>$data['uid']));
            
            if(!empty($trtc) && $trtc['extime'] > 0 && $trtc['extime'] > time()){
                
                if (!empty($trtc['roomid']) && $data['usertype'] == 2){
                    // 企业用户有自己的房间号
                    $roomid  =  $trtc['roomid'];
                    $wid     =  $trtc['wid'];
                }else{
                    // 个人用户要查对方的房间号
                    $fuser   =  $this->select_once('trtc', array('uid'=>$data['fuid']));
                    
                    if (!empty($fuser)){
                        
                        $roomid  =  $fuser['roomid'];
                        $wid     =  $fuser['wid'];
                        
                    }else{
                        
                        // 对方没有数据，需重新查询
                        $ndata['uid']       =  $data['fuid'];
                        $ndata['usertype']  =  2;
                        
                        $result  =  $this->getRoomInfo($ndata);
                        
                        if (!empty($result['errcode'])){
                            
                            return $result;
                        }
                        $roomid  =  $result['roomid'];
                        $wid     =  $result['sarr']['wid'];
                    }
                }
                
                $return  =  array('usersig'=>$trtc['usersig'], 'appid'=> $trtc['appid'], 'roomid'=>$roomid, 'csroomid'=>$trtc['roomid'], 'wid'=>$wid);
                
            }else{
                
                $result  =  $this->getRoomInfo($data);
                
                if (!empty($result['errcode'])){
                    
                    return $result;
                }
                $sarr    =  $result['sarr'];
                
                $return  =  array('usersig'=>$sarr['usersig'],'appid'=>$sarr['appid'], 'roomid'=>$result['roomid'], 'csroomid'=>$sarr['roomid'], 'wid'=>$sarr['wid']);
            }
        }
        return $return;
    }
    /**
     * 从都需上查询视频面试房间信息
     */
    private function getRoomInfo($data = array()){
        
        if (!empty($this->config['sy_spview_appkey']) && !empty($this->config['sy_spview_appsecret'])){
            
            $postjson['buid']       =  $data['uid'];
            $postjson['appKey']     =  $this->config['sy_spview_appkey'];
            $postjson['appSecret']  =  $this->config['sy_spview_appsecret'];
            
            $url  =  'https://trtc.phpyun.com/zphnetv/index.php?m=trtc&c=getUserSig';
            
            $result	  =	 CurlPost($url,$postjson);
            $reponse  =	 json_decode($result, true);
            
            if (empty($reponse['data'])){
                
                return array('errcode'=>8,'msg'=>$reponse['msg']);
            }
            $douxu    =  $reponse['data'];
            
        }else{
            
            return array('errcode'=>8,'msg'=>'视频面试秘钥未配置');
        }
        
        $sarr     =  array(
            'uid'      =>  $data['uid'],
            'usersig'  =>  $douxu['code'],
            'extime'   =>  $douxu['expire'],
            'appid'    =>  $douxu['appid'],
            'roomid'   =>  $douxu['roomid'],
            'wid'      =>  $douxu['wid']
        );
        
        if ($data['usertype'] == 2){
            // 企业用户有自己的房间号
            $roomid  =  $douxu['roomid'];
            
        }else{
            // 个人用户要查对方的房间号
            $fuser   =  $this->select_once('trtc', array('uid'=>$data['fuid']));
            
            if (!empty($fuser)){
                // 对方已有数据
                $roomid  =  $fuser['roomid'];
                
            }else{
                // 对方没有数据，需重新查询
                $ndata['uid']       =  $data['fuid'];
                $ndata['usertype']  =  2;
                
                $result  =  $this->getRoomInfo($ndata);
                
                if (!empty($result['errcode'])){
                    
                    return $result;
                }
                $roomid  =  $result['roomid'];
            }
        }
        
        if (!empty($trtc)){
            
            $this->update_once('trtc', $sarr, array('id'=>$trtc['id']));
            
        }else{
            
            $this->insert_into('trtc', $sarr);
        }
        return array('sarr'=>$sarr, 'roomid'=>$roomid);
    }
    /**
     * 查询视频面试房间所需参数
     * @param array $data
     * @param string $codePlat
     */
    function getTrcInfo($data = array(), $needRtc = false, $codePlat = ''){
        
        // 查询对方数据
        if ($data['usertype'] == 1){
            
            $info  =  $this->select_once('company', array('uid'=>$data['fuid']), '`uid`,`name`,`shortname`,`logo`');
            
            $return  =  array(
                'name'    =>  !empty($info['shortname']) ? $info['shortname'] : $info['name'],
                'logo'    =>  checkpic($info['logo'], $this->config['sy_unit_icon'])
            );
        }else{
            
            $info  =  $this->select_once('resume', array('uid'=>$data['fuid']), '`uid`,`name`,`sex`,`photo`');
            
            $base    =  $info['sex'] == 1 ? $this->config['sy_member_icon'] : $this->config['sy_member_iconv'];
            $return  =  array(
                'name'    =>  $info['name'],
                'logo'    =>  checkpic($info['photo'], $base)
            );
        }
        
        // app 里面还要查自己的数据
        if ($codePlat == 'app'){
            
            // 查询对方信息
            if ($data['usertype'] == 2){
                
                $minfo  =  $this->select_once('company', array('uid'=>$data['uid']), '`name`,`shortname`,`logo`');
                
                $return['myname']  =  !empty($minfo['shortname']) ? $minfo['shortname'] : $minfo['name'];
                $return['mylogo']  =  checkpic($minfo['logo'], $this->config['sy_unit_icon']);
                
            }else{
                
                $minfo  =  $this->select_once('resume', array('uid'=>$data['uid']), '`name`,`sex`,`photo`');
                
                $mbase  =  $minfo['sex'] == 1 ? $this->config['sy_member_icon'] : $this->config['sy_member_iconv'];
                $return['myname']  =  $minfo['name'];
                $return['mylogo']  =  checkpic($minfo['photo'], $mbase);
            }
        }
        if ($needRtc){
            
            $trtc   =  $this->getUserSig(array('uid'=>$data['uid'], 'fuid'=>$info['uid'], 'usertype'=>$data['usertype']));
            
            if (!empty($trtc['appid'])){
                
                $return['sdkAppId']   =  $trtc['appid'];
                $return['userSig']    =  $trtc['usersig'];
                $return['roomId']     =  $trtc['roomid'];
                $return['commentID']  =  $trtc['wid'] .'_'.$info['uid'];
                $return['userId']     =  $trtc['wid'] .'_'.$data['uid'];
                $return['spWait']     =  $this->config['sy_spview_wait'];
                $return['spLong']     =  $this->config['sy_spview_time'];
                
            }else{
                
                $return  =  $trtc;
            }
        }
        
        return $return;
    }
    /**
     * 通过接口查询是否可以视频面试
     */
    function trtcCanAdd(){
        
        if (!empty($this->config['sy_spview_appkey']) && !empty($this->config['sy_spview_appsecret'])){
            
            $postjson['appKey']     =  $this->config['sy_spview_appkey'];
            $postjson['appSecret']  =  $this->config['sy_spview_appsecret'];
            
            $url  =  'https://trtc.phpyun.com/zphnetv/index.php?m=trtc&c=canAdd';
            
            $result	  =	 CurlPost($url,$postjson);
            $reponse  =	 json_decode($result, true);
            
            if (empty($reponse['data'])){
                
                return array('errcode'=>8,'msg'=>$reponse['msg']);
            }
            return $reponse['data'];
            
        }else{
            
            return array('errcode'=>8,'msg'=>'视频面试秘钥未配置');
        }
    }
}
?>