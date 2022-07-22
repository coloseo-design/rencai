<?php
/*
 * $Author ：沭云智鑫
 *
 * 官网: http://www.douxu.com
 *
 * 版权所有 2020-2020 南京沭云智鑫科技有限公司，并保留所有权利。
 *
 * 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
 */

class concheck_model extends model
{
    private function addErrorLog($uid,$type='',$content) {

        require_once ('errlog.model.php');

        $ErrlogM = new errlog_model($this->db, $this->def);

        return  $ErrlogM -> addErrorLog($uid, $type, $content);

    }
    
    /**
     * 内容检测
     * @param string content 检测文本内容数组，或图片地址字符串
     * @param array  data 其他传参，type=pic为检测图片 ,source 来源
     * @return array
     */
    public function checkContent($content, array $data)
    {
        $return = [];
        $content_v = $content;
        $source = isset($data['source'])?$data['source']:'';
        $action = $data['action'];
        
        
        $open       =   $this->config['sy_concheck_open'];    
        $appkey     =   $this->config['sy_concheck_appkey'];
        $appsecret  =   $this->config['sy_concheck_appsecret'];
        
        if($open==1 && $appkey && $appsecret){


            if($source==11){
                $source = 1;
            }else if($source==12){
                $source = 2;
            }else if($source==14){
                $source = 13;
            }else if($source==15){
                $source = 3;
            }

            if (isset($data['type']) && $data['type'] == 'pic') {

                $url    =   'https://u.phpyun.com/imagecensor';

                $con_str = $content[0];
                
            } else {

                $url    =   'https://u.phpyun.com/textcensor';

                $con_str = '';

                foreach ($content as $key => $value) {
                    $con_str    .=  $value;
                }
            }

            $content_v = serialize($content_v);
            
            $search     =   array(" ", "　", "\n", "\r", "\t");
            $replace    =   array("", "", "", "", "");
            $con_str    =   str_replace($search, $replace, $con_str);
            
            if($source == 13 && $action=='chatlog'){
                //微信小程序的聊天走微信的内容检测
                require_once('xcx.model.php');
                $xcxM  =  new xcx_model($this->db,$this->def);
                $access_token = $xcxM->getWxxcxToken();
                
                if(isset($data['type']) && $data['type'] == 'pic'){
                    $url    =   'https://api.weixin.qq.com/wxa/img_sec_check?access_token='.$access_token;

                    $img = file_get_contents($con_str);
            
                    $filename  =  time().rand(1000,9999).'.jpeg';
                    //自定义目录名称
                    $dirName = APP_PATH.'data/upload/'. '/chat/' . date('Ymd');
                    //定义新名称以及目录
                    if (!file_exists($dirName)){
                        mkdir($dirName, 0777, true);
                    }
                    $filePath= $dirName . '/' . $filename;
                    
                    file_put_contents($filePath, $img);

                    $fobj    = new \CURLFile(realpath($filePath));
                    $fobj->setMimeType("image/jpeg");
                    $postdata['media'] = $fobj;
                }else{

                    $url    =   'https://api.weixin.qq.com/wxa/msg_sec_check?access_token='.$access_token;
                    $postdata   =   array(
                        'openid'    =>  $data['openid'],
                        'scene'     =>  4,
                        'version'   =>  2,
                        'content'   =>  $con_str
                    );
                    $postdata = json_encode($postdata);
                }
                
                $file_contents  =   CurlPost($url,$postdata);

                $res    =   json_decode($file_contents, true);
            
                $file_contents=[];
                
                $file_contents['code'] = $res['errcode'];
                $file_contents['msg'] = $res['errmsg'];
                
                if($res['errcode']==0){//内容正常
                    $file_contents['code'] = 200;
                    $file_contents['data']['conclusion_type']= 1;
                    $file_contents['data']['msg']= $res['errmsg'];
                    
                }
                
                $file_contents= json_encode($file_contents);

            }else{
                //其余走百度检测接口
                $url        .=  '?app_secret=' . $appsecret . '&app_key=' . $appkey . '&content=' . $con_str;
                
                $file_contents  =  CurlGet($url);

            }
            
            

            if ($file_contents) {
                if (isset($file_contents['curlerror'])) {
                    if ($file_contents['curlerror'] == 28) {

                        $return['code'] = 0;
                        $return['msg'] = '检测请求超时';
                    } else {

                        $return['code'] = 0;
                        $return['msg'] = '检测请求失败';
                    }
                    $errorLog = true;
                } else {

                    $res    =   json_decode($file_contents, true);

                    if ($res) {
                        if ($res['code'] == 200) {

                            $return['code'] =   isset($res['data']['conclusion_type']) ? $res['data']['conclusion_type'] : 0;
                            $return['msg']  =   isset($res['data']['msg']) ? $res['data']['msg'] : '';
                        } else {
                            $errorLog = true;
                            $return['code'] =   $res['code'];
                            $return['msg']  =   isset($res['msg']) ? $res['msg'] : '';
                        }
                    } else {
                        $errorLog = true;
                        $return['code']     =   0;
                        $return['msg']      =   '检测请求失败';
                    }
                }
            } else {
                $errorLog = true;
                $return['code']     =   0;
                $return['msg']      =   '检测请求失败';
            }


            $insertData = array(
                'uid'       =>  $data['uid'],
                'usertype'  =>  $data['usertype'],
                'type'      =>  $data['type'] == 'pic'?2:1,
                'ctype'     =>  $data['ctype'],
                'cid'       =>  $data['cid'],
                'content'   =>  $content_v,
                'source'    =>  $source ? $source : 1,
                'url'       =>  $_SERVER['REQUEST_URI'],
                'ctime'     =>  time(),
                'result'    =>  $return['code']=='1'?1:0,
                'message'   =>  $return['msg'],
                'status'    =>  $return['code']=='1'?2:0
            );

            $cid = $this->addLog($insertData);
            $return['cid'] = $cid;
            if($errorLog){
                $this->addErrorLog($data['uid'],11, $return['msg']);
            }
        }else{
            $return['code'] = 1;
        }

        return $return;
    }

    private function addLog($data=array()){

        $nid    =   $this -> insert_into("concheck_log", $data);
        
        return $nid;
    }
    public function upLog($whereData = array(), $upData = array(), $data = array()){
        $nid                        =   0;
        if (!empty($upData) && !empty($whereData)){
            $nid                    =   $this -> update_once('concheck_log', $upData, $whereData);
        }
        return $nid;
    }
    public function getLogList($whereData, $data = array()){

        $field  =  empty($data['field']) ? '*' : $data['field'];
        
        $List   =  $this -> select_all('concheck_log', $whereData, $field);

        if(!empty($List)){
            $uid_arr  = array();
            $ruid_arr = array();
            $cuid_arr = array();
            foreach ($List as $key => $val) {

                if($val['uid'] && $val['usertype']==1 && !in_array($val['uid'],$ruid_arr)){
                    $ruid_arr[] = $val['uid'];
                }

                if($val['uid'] && $val['usertype']==2 && !in_array($val['uid'],$cuid_arr)){
                    $cuid_arr[] = $val['uid'];
                }

                if($val['uid'] && !in_array($val['uid'],$uid_arr)){
                    $uid_arr[]  = $val['uid'];
                }

            }

            $rname_arr = array();
            $cname_arr = array();
            $mname_arr = array();

            if(!empty($ruid_arr)){

                $ResumeList =   $this -> select_all(
                    'resume',
                    array(
                        'uid'=>array('in',pylode(',',$ruid_arr))
                    ),
                    '`uid`,`name`'
                    );

                foreach ($ResumeList as $rk => $rv) {
                    $rname_arr[$rv['uid']] = $rv['name'];
                }
            }

            if(!empty($cuid_arr)){

                $ComList    =   $this -> select_all(
                    'company',
                    array(
                        'uid'=>array('in',pylode(',',$cuid_arr))
                    ),
                    '`uid`,`name`'
                    );

                foreach ($ComList as $ck => $cv) {
                    $cname_arr[$cv['uid']] = $cv['name'];
                }
            }

            if(!empty($uid_arr)){

                $MemList    =   $this -> select_all(
                    'member',
                    array(
                        'uid'=>array('in',pylode(',',$uid_arr))
                    ),
                    '`uid`,`username`'
                    );

                foreach ($MemList as $mk => $mv) {
                    $mname_arr[$mv['uid']] = $mv['username'];
                }
            }

            include(CONFIG_PATH."db.data.php");

            foreach ($List as $k => $v) {

                if($v['uid']){

                    $List[$k]['username'] = isset($mname_arr[$v['uid']]) ? $mname_arr[$v['uid']] : '<span style="color:red;">账号已删除</sapn>';

                    if($v['usertype']==1){
                        $List[$k]['name'] = isset($rname_arr[$v['uid']]) ? $rname_arr[$v['uid']] : '';
                    }
                    if($v['usertype']==2){
                        $List[$k]['name'] = isset($cname_arr[$v['uid']]) ? $cname_arr[$v['uid']] : '';
                    }
                }

                if($v['ctype']==1){
                    $List[$k]['ctype_n'] = '修改简历，简历ID（'.$v['cid'].'）';
                }elseif($v['ctype']==2){
                    $List[$k]['ctype_n'] = '修改职位，职位ID（'.$v['cid'].'）';
                }elseif($v['ctype']==3){
                    $List[$k]['ctype_n'] = '修改个人基本信息';
                }elseif($v['ctype']==4){
                    $List[$k]['ctype_n'] = '修改企业基本信息';
                }elseif($v['ctype']==5){
                    $List[$k]['ctype_n'] = $this->config['sy_chat_name'];
                }

                $con_arr = unserialize($v['content']);

                if($v['type']==1){//文字
                    
                    $body_html                  =   '';

                    foreach($con_arr as $conk=>$conv){
                        $con_html = '';
                        if(is_numeric($conk)){
                            $con_html = $conv.'</br>';
                        }else{
                            $con_html = $conk.':'.$conv.'</br>';
                        }
                        $body_html .= $con_html;
                    }
                    $List[$k]['content_n']     =   $body_html;
                }else if($v['type']==2){//图片
                    $List[$k]['content_n'] = checkpic($con_arr[0]);
                }

                if($v['ctime']){
                    $List[$k]['ctime_n']     =   date('Y-m-d H:i:s');
                }
                if($v['source']){
                    
                    $List[$k]['source_n'] = $arr_data['source'][$v['source']];
                }
            }
        }

        return $List;
    }
    function getInfo($whereData,$data=array()){
        
        $field  =   empty($data['field']) ? '*' : $data['field'];
        if (!empty($whereData)) {
            
            $List  =  $this -> select_once('concheck_log',$whereData, $field);
            return $List;
        }
    }

    public function delConCheck($id,$data=array()){
        if(!empty($id)){
            if(is_array($id)){

                $ids                    =   $id;    
                $return['layertype']    =   1;   
            }else{

                $ids                    =   @explode(',', $id);
                $return['layertype']    =   0;
            }
            $id             =   pylode(',', $ids);

            $return['id']   =   $this -> delete_all('concheck_log',array('id' => array('in',$id)),'');
            
            if($return['id']){

                $return['msg']      =  '内容安全检测(ID:'.$id.')删除成功';
                $return['errcode']  =  '9';
            }else{
                
                $return['msg']      =  '内容安全检测(ID:'.$id.')删除失败';
                $return['errcode']  =  '8';
            }
        }else{
            
            $return['msg']          =  '系统繁忙';
            $return['errcode']      =  '8';
            $return['layertype']    =   0;
        }

        return $return;
    }
    public function statusConCheck($id, $upData = array())
    {

        $ids    =   @explode(',', trim($id));

        $return =   array('msg' => '非法操作！', 'errcode' =>  8);

        if (!empty($id)) {

            $idstr      =   pylode(',', $ids);

            $upData     =   array(

                'status'        =>  intval($upData['status']),
                'statusbody'    =>  trim($upData['statusbody']),
            );

            $result     =   $this -> update_once('concheck_log', $upData, array('id' => array('in', $idstr)));

            if ($result) {

                $return['msg']      =  '内容检测处理状态(ID:'.$idstr.')设置成功';
                $return['errcode']  =  9;

            }else{

                $return['msg']      =  '内容检测处理状态(ID:'.$idstr.')设置失败';
                $return['errcode']  =  8;
            }

        }else {

            $return['msg']          =   '请选择需要处理的内容检测！';
            $return['errcode']      =   8;
        }

        return $return;
    }
}