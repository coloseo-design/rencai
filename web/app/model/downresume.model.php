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

class downresume_model extends model
{

    /**
     * @desc   引用log类，添加用户日志
     *
     * @param $uid
     * @param $usertype
     * @param $content
     * @param string $opera
     * @param string $type
     * @return void
     */
    private function addMemberLog($uid, $usertype, $content, $opera = '', $type = '')
    {

        require_once('log.model.php');
        $LogM   =   new log_model($this->db, $this->def);
        return $LogM->addMemberLog($uid, $usertype, $content, $opera = '', $type = '');
    }

    /**
     * 添加错误日志
     *
     * @param $uid
     * @param string $type
     * @param $content
     */
    private function addErrorLog($uid, $type = '', $content)
    {

        require_once('errlog.model.php');
        $ErrLogM    =   new errlog_model($this->db, $this->def);
        return $ErrLogM->addErrorLog($uid, $type, $content);
    }

    /**
     * 获取简历信息列表resume_expect
     *
     * @param $whereData
     * @param array $data
     * @return array
     */
    private function getResumeExpectList($whereData, $data = array())
    {

        require_once('resume.model.php');
        $resumeM    =   new resume_model($this->db, $this->def);
        return $resumeM->getList($whereData, $data);
    }

    /**
     * 获取简历信息列表resume
     *
     * @param $whereData
     * @param array $data
     * @return array|bool|false|string|void
     */
    private function getResumeList($whereData, $data = array())
    {

        require_once('resume.model.php');
        $resumeM    =   new resume_model($this->db, $this->def);
        return $resumeM->getResumeList($whereData, $data);
    }

    /**
     * 获取缓存数据
     *
     * @param $options
     * @return array|string|void
     */
    private function getClass($options)
    {

        include_once('cache.model.php');
        $cacheM =   new cache_model($this->def, $this->db);
        return $cacheM->GetCache($options);
    }

    /**
     * 查询简历下载
     *
     * @param array $whereData
     * @param array $data
     * @return array|bool|false|string|void
     */
    function getDownResumeInfo($whereData = array(), $data = array())
    {

        $data['field']  =   empty($data['field']) ? '*' : $data['field'];
        return $this->select_once('down_resume', $whereData, $data['field']);
    }

    /**
     * 添加down_resume    详情
     *
     * @param $addData  添加数据
     * @return bool|int
     */
    public function addInfo($addData)
    {

        $nid    =   0;

        if (!empty($addData)) {
            $nid    =   $this->insert_into('down_resume', $addData);
            if (!$nid) {

                $this->addErrorLog($addData['comid'], 6, '下载简历失败！');
            }
        }

        return $nid;
    }

    /**
     * 获取下载简历列表 （注：详细的用下面的方法 getList）
     *
     * @param $whereData    查询条件
     * @param array $data   自定义处理数组
     * @return array|bool|false|string|void
     */
    public function getSimpleList($whereData, $data = array())
    {

        $data['field'] = empty($data['field']) ? '*' : $data['field'];
        return $this->select_all('down_resume', $whereData, $data['field']);
    }

    /**
     * 获取下载简历列表
     *
     * @param $whereData    查询条件
     * @param array $data   自定义处理数组
     * @return array
     */
    public function getList($whereData, $data = array())
    {

        $ListNew                =   array();
        $List                   =   $this->select_all('down_resume', $whereData);

        if (isset($List) && !empty($List)) {

            $List               =   $this->getDataList($List, $data);

            $ListNew['list']    =   $List;
        }
        return $ListNew;
    }

    /**
     * 后台简历下载列表处理数据
     *
     * @param $List
     * @param array $data
     * @return
     */
    private function getDataList($List, $data = array())
    {
        $utype  =  isset($data['utype']) ? $data['utype'] : '';
        $eid    =   $ltid   =   $comid  =   $uid    =   $ruid   =   array();

        foreach ($List as $v) {

            $uid[]          =   $v['uid'];
            $uid[]          =   $v['comid'];

            $ruid[]         =   $v['uid'];
            $eid[]          =   $v['eid'];

            if ($v['usertype'] == '3') {

                $ltid[]     =   $v['comid'];
            } else {

                $comid[]    =   $v['comid'];
            }

        }
        // 后台
        if ($utype == 'admin'){
            $member         =   $this->select_all('member', array('uid' => array('in', pylode(',', $uid))), '`uid`,`username`,`usertype`,`moblie`');
            $com            =   $this->select_all('company', array('uid' => array('in', pylode(',', $comid))), '`uid`,`name`,`linkman`');
            if (!empty($ltid)){
                $lt         =   $this->select_all('lt_info', array('uid' => array('in', pylode(',', $ltid))), '`uid`,`realname`,`com_name`');
            }
        }
        //  查询个人简历名称
        $reWhere['id']      =   array('in', pylode(',', $eid));
        $reData['utype']    =   'user';
        $reData['field']    =   '`id`,`name`,`uname`,`job_classid`,`minsalary`,`maxsalary`,`height_status`,`exp`,`hy`,`lastupdate`,`city_classid`,`edu`,`sex`,`birthday`,`photo`';
        $expect             =   $this->getResumeExpectList($reWhere, $reData);
        
        // PC端
        if ($utype == 'pc'){
            $userid_msg     =   $this->select_all("userid_msg", array('fid' => $data['uid'], 'uid' => array('in', pylode(",", $ruid))), '`uid`');
            
            $userid_job     =   $this->select_all('userid_job', array('com_id' => $data['uid'], 'uid' => array('in', pylode(',', $ruid))), '`uid`,`is_browse`');
            
            $cache          =   $this->getClass(array('com'));
        }

        foreach ($List as $k => $v) {
            
            $List[$k]['wapurl']         =   Url('wap', array('c'=>'resume','a'=>'show','id'=>$v['eid']));
            $List[$k]['datetime_n']     =   timeForYear($v['downtime']);
            
            if($v['isdel']==3){
                $List[$k]['isdel_n']    =   '猎头用户删除';
            }else if($v['isdel']==2){
                $List[$k]['isdel_n']    =   '企业用户删除';
            }else{
                $List[$k]['isdel_n']    =   '正常';
            }
            if (isset($cache)){
                $List[$k]['status_n']     =    $cache['comclass_name'][$v['status']];
            }
            
            if (!empty($member)){
                foreach ($member as $val) {
                    if ($v['uid'] == $val['uid']) {
                        
                        $List[$k]['telMob'] =   $val['moblie'];
                    }
                    if ($v['comid'] == $val['uid']) {
                        
                        $List[$k]['telPho'] =   $val['moblie'];
                    }
                }
            }
            if (!empty($com)){
                foreach ($com as $val) {
                    if ($v['comid'] == $val['uid'] && $v['usertype'] == '2') {
                        
                        $List[$k]['com_username']   =   $val['linkman'];
                        $List[$k]['com_name']       =   $val['name'];
                    }
                }
            }
            if (!empty($lt)){
                foreach ($lt as $val) {
                    if ($v['comid'] == $val['uid'] && $v['usertype'] == '3') {
                        
                        $List[$k]['com_username']   =   $val['realname'];
                        $List[$k]['com_name']       =   $val['com_name'];
                    }
                }
            }
            foreach ($expect['list'] as $val) {
                if ($v['eid'] == $val['id']) {

                    $List[$k]['salary']         =   $val['salary'];
                    $List[$k]['height_status']  =   $val['height_status'];
                    $List[$k]['jobname']        =   $val['job_classname'];
                    $List[$k]['exp']            =   $val['exp_n'];
                    $List[$k]['edu']            =   $val['edu_n'];
                    $List[$k]['sex']            =   $val['sex_n'];
                    $List[$k]['age']            =   $val['age_n'];
                    $List[$k]['resume']         =   $val['name'];
                    $List[$k]['username']       =   $val['uname'];
                    $List[$k]['photo']          =   $val['photo_n'];
                }
            }
            if(!empty($userid_msg)){
                foreach ($userid_msg as $val) {
                    if ($v['uid'] == $val['uid']) {

                        $List[$k]['userid_msg'] =   1;
                    }
                }
            }

            if(!empty($val)){
                foreach ($userid_job as $val) {
                    if ($v['uid'] == $val['uid']) {

                        $List[$k]['is_browse']  =   $val['is_browse'];
                    }
                }
            }

            if ($data['utype'] == 'lietou') {
                foreach ($expect['list'] as $val) {
                    if ($v['eid'] == $val['id']) {
                        $List[$k]['hy']         =   $val['hy_n'];
                        $List[$k]['cityname']   =   $val['city_classname'];
                        $List[$k]['lastupdate'] =   $val['lastupdate'];
                    }
                }
            }
        }
        return $List;
    }

    /**
     * 删除下载简历
     *
     * @param $id       删除下载简历ID
     * @param $data     自定义处理数组
     * @return bool
     */
    public function delInfo($id, $data)
    {

        $limit                          =   'limit 1';
        $return['layertype']            =   0;

        if (!empty($id)) {
            if (is_array($id)) {

                $id                     =   pylode(',', $id);
                $return['layertype']    =   1;
                $limit                  =   '';
            }
            if ($data['utype'] == 'admin') {

                $delWhere               =   array('id' => array('in', $id));
                $result                 =   $this->delete_all('down_resume', $delWhere, $limit);
            } else {

                $delWhere               =   array('comid' => $data['uid'], 'id' => array('in', $id));
                $result                 =   $this->update_once('down_resume', array('isdel' => $data['usertype']),$delWhere);
            }

            if ($result) {

                $this->addMemberLog($data['uid'], $data['usertype'], "删除已下载简历记录（ID:" . $id . "）", 3, 3);

                $return['msg']          =   '下载记录(ID:' . $id . ')删除成功';
                $return['errcode']      =   '9';
            } else {

                $return['msg']          =   '下载记录(ID:' . $id . ')删除失败';
                $return['errcode']      =   '8';
            }
        } elseif ($data['where']) {

            $where                      =   $data['where'];

            if ($data['norecycle'] == '1') {    //	数据库清理，不插入回收站

                $result                 =   $this->delete_all('down_resume', $where, '', '', '1');
            } else {

                $result                 =   $this->delete_all('down_resume', $where, '');
            }

            return $result;
        } else {

            $return['msg']              =   '请选择您要删除的下载记录';
            $return['errcode']          =   '8';
        }
        return $return;
    }

    /**
     * 备注下载简历
     *
     * @param array $data
     * @return mixed
     */
    public function Remark($data = array())
    {
        if ($data['remark'] == "") {

            $return['msg']      =   '备注内容不能为空！';
            $return['errcode']  =   8;
        }

        $result                 =   $this->update_once('down_resume', array('remark' => $data['remark'], 'status' => $data['status']), array('id' => intval($data['remarkid']), 'comid' => $data['uid']));

        if ($result) {

            $this->addMemberLog($data['uid'], $data['usertype'], "备注人才" . $data['rname'], 5, 1);
            $return['msg']      =   '备注成功！';
            $return['errcode']  =   '9';
        } else {

            $return['msg']      =   '备注失败！';
            $return['errcode']  =   '8';
        }
        return $return;
    }


    /**
     * @desc   下载简历
     * @param array $data
     * @return array $res
     */
    public function downResume($data = array())
    {

        require_once('resume.model.php');
        $resumeM    =   new resume_model($this->db, $this->def);

        require_once('job.model.php');
        $jobM       =   new job_model($this->db, $this->def);

        require_once('statis.model.php');
        $statisM    =   new statis_model($this->db, $this->def);

        $res        =   array('status' => -1);
        $eid        =   intval($data['eid']);
        $uid        =   intval($data['uid']);
        $spid       =   intval($data['spid']);
        $usertype   =   intval($data['usertype']);
        $did        =   $data['did'] ? intval($data['did']) : $this->config['did'];

        /* 简历信息：用户UID 、简历ID、简历类型（普通/优质） */
        $user       =   $resumeM->getExpect(array('id' => $eid), array('field' => '`id`, `uid`, `height_status`'));

        /* 登录状态判断 */
        if (empty($uid)) {

            $res['msg']     =   '请先登录！';
            $res['login']   =   $user['height_status'] == 2 ? 3 : 2;
            return $res;
        }

        $tag        =   $data['utype'] == 'wap' || $data['utype'] == 'wxapp' ? '查看' : '下载';

        /* 会员类型判断 */
        if ($usertype == 1) { //  个人会员

            if ($user['uid'] == $uid) { // 用户自己下载自己的简历

                $res['status']  =   3;  //  直接下载
                return $res;
            } else {

                $res['msg']     =   '个人用户无法'.$tag.'简历！';
                return $res;
            }
        } else if ($usertype == 2 || $usertype == 3) {    //  企业或者猎头

            if ($usertype == 2) {

                require_once('userinfo.model.php');
                $userinfoM      =   new userinfo_model($this->db, $this->def);
                $member         =   $userinfoM->getInfo(array('uid' => $uid), array('field' => '`status`'));

                if ($member['status'] != 1) { // 企业用户尚未审核

                    $res['msg'] =   '您的帐号未通过审核，请联系客服加快审核进度！';
                    return $res;
                }

                //是否在黑名单中
                include_once('black.model.php');
                $blackM         =   new black_model($this->db, $this->def);

                $black          =   $blackM->getBlackNum(array('c_uid' => $user['uid'], 'p_uid' => $uid));
                if (!empty($black)) {

                    $res['msg'] =   '该简历暂时无法' . $tag . '，您可以先浏览其他简历信息！';
                    return $res;
                }

                //判断当天是否已达到最大下载简历次数
                require_once('company.model.php');
                $companyM       =   new company_model($this->db, $this->def);
                $result         =   $companyM->comVipDayActionCheck('resume', $uid);
                if ($result['status'] != 1) {
                    return $result;
                }

                $single_can     =   $this->config['com_single_can'];

            } else if ($usertype == 3) {

                $single_can     =   $this->config['lt_single_can'];
            }

            //判断后台是否开启该单项购买
            $single_can         =   @explode(',', $single_can);

            $serverOpen         =   1;

            if (!in_array('downresume', $single_can)) {

                $serverOpen     =   0;
            }

            /* 简历账户信息查询 */
            $resumeField        =   array('field' => '`name`, `basic_info`, `telphone`, `telhome`, `email`, `r_status`,`middlenumber`');
            $resumeArr          =   $resumeM->getResumeInfo(array('uid' => $user['uid']), $resumeField);
            if ($resumeArr['r_status'] == '0') {

                $res['msg']     =   '个人用户账号未审核！';
                return $res;
            }else if($resumeArr['r_status'] == '2'){

                $res['msg']     =   '个人用户账号已锁定！';
                return $res;
            }else if($resumeArr['r_status'] == '3'){

                $res['msg']     =   '个人用户账号未通过审核！';
                return $res;
            }

            $user               =   array_merge($user, $resumeArr);
            if (empty($user)) {

                $res['msg']     =   '数据错误！';
                return $res;
            }

            /* 如果联系方式都是空的，给以提醒，不能扣除企业用户的积分、套餐等 */
            if (empty($user['telhome']) && empty($user['telphone']) && empty($user['email'])) {
                $res['msg']     =   '该简历暂无联系方式';
                return $res;
            }

            /* 如果已下载过，直接下载 */
            $isDown             =   $this->getDownResumeInfo(array('eid' => $eid, 'comid' => $uid, 'usertype' => $usertype));

            if (!empty($isDown)) {
                $res['status']      =   3;
                $res['usertype']    =   $usertype;

                $resArr             =   $this->getResumePhone($user, $uid, $eid);

                if (isset($resArr['msg']) && !empty($resArr['msg'])){

                    $res['msg']     =   $resArr['msg'];
                }else{

                    $res['html']          =	  $resArr['html'];
                    $res['waphtml']       =	  $resArr['waphtml'];
                    $res['privatePhone']  =   $resArr['privatePhone'];
                    $res['prvusertel']    =   $resArr['prvusertel'];
                }
                return $res;
            }

            if ($usertype == 2) {

                $tmpField           =   '`rating`,`vip_etime`,`down_resume`,`rating_type`,`integral`';
                $suid               =   $spid ? $spid : $uid;
            } elseif ($usertype == 3) {

                $tmpField           =   '`vip_etime`, `lt_down_resume` AS down_resume, `rating_type`,`integral`';
                $suid               =   $uid;
            }

            $statis                 =   $statisM->getInfo($suid, array('usertype' => $usertype, 'field' => $tmpField));

            /*发布职位才能下载简历*/
            if ($this->config['com_lietou_job'] == 1 && isVip($statis['vip_etime'])) {

                require_once('lietoujob.model.php');
                $ltjobM             =   new lietoujob_model($this->db, $this->def);

                if ($usertype == 2) {

                    $jobNum         =   $jobM->getJobNum(array('uid' => $uid, 'state' => 1, 'r_status' => 1, 'status' => 0));
                    $ltJobNum       =   $ltjobM->getLtjobNum(array('uid' => $uid, 'zp_status' => 0, 'status' => 1, 'r_status' => 1));
                    $listNum        =   $jobNum + $ltJobNum;

                    if (intval($listNum) == 0) {

                        $msgList    =   $jobM->getAddJobNeedInfo($uid);

                        if (!empty($msgList)) {
                            $res['msgList'] =   $msgList;
                        }
                        $res['down']        =   1;
                        $res['status']      =   1;
                        $res['msg']         =   '还未发布职位,无法' . $tag . '简历！';
                        $res['type']        =   intval($user['height_status']);
                        return $res;
                    }
                }
                if ($usertype == 3) {

                    $listNum        =   $ltjobM->getLtjobNum(array('uid' => $uid, 'zp_status' => 0, 'status' => 1, 'r_status' => 1));

                    if (intval($listNum) == 0) {

                        $msgList    =   $jobM->getAddJobNeedLtInfo($uid);

                        if (isset($msgList) && !empty($msgList)) {
                            $res['msgList'] =   $msgList;
                        }
                        
                        $res['down']        =   1;
                        $res['status']      =   1;
                        $res['msg']         =   '还未发布职位,无法' . $tag . '简历！';
                        $res['type']        =   intval($user['height_status']);

                        return $res;
                    }
                }
            }

            $downData               =   array();
            $downData['eid']        =   $user['id'];
            $downData['uid']        =   $user['uid'];
            $downData['comid']      =   $uid;
            $downData['comusertype']=   $usertype;
            $downData['did']        =   $did;
            $downData['downtime']   =   time();
            $downData['type']       =   $user['height_status'] == 2 ? 2 : 0;

            /* 已投递简历并且免费查看联系方式 */
            $userid_job             =   $jobM->getSqJobInfo(array('com_id' => $uid, 'eid' => $eid,'isdel'=>9));

            if ($usertype == 2 && !empty($userid_job) && in_array($statis['rating'], @explode(',', $this->config['com_look']))) {
                if (empty($isDown)) {
                    $this->_downResume($downData, $eid, $user, $data['uid']);
                }
                $res['status']      =   3;

                $resArr             =   $this->getResumePhone($user, $uid, $eid);

                if (isset($resArr['msg']) && !empty($resArr['msg'])){

                    $res['msg']     =   $resArr['msg'];
                }else{

                    $res['html']          =	  $resArr['html'];
                    $res['waphtml']       =	  $resArr['waphtml'];
                    $res['privatePhone']  =   $resArr['privatePhone'];
                    $res['prvusertel']    =   $resArr['prvusertel'];
                }
                return $res;
            }

            $online                 =   (int)$this->config['com_integral_online'];

            $price                  =   $resumeM->setDayprice($eid);

            if ($price == 0 && $statis['down_resume'] == 0) {

                $this->_downResume($downData, $eid, $user, $data['uid']);
                $res['status']      =   3;

                $resArr             =   $this->getResumePhone($user, $uid, $eid);

                if (isset($resArr['msg']) && !empty($resArr['msg'])){

                    $res['msg']     =   $resArr['msg'];
                }else{

                    $res['html']            =   $resArr['html'];
                    $res['waphtml']         =   $resArr['waphtml'];
                    $res['privatePhone']    =   $resArr['privatePhone'];
                    $res['prvusertel']      =   $resArr['prvusertel'];
                }

                return $res;
            }

            /* 会员信息查询 */
            if (isVip($statis['vip_etime'])) {

                if ($statis['rating_type'] == 1) {  // 套餐模式

                    /* 收费会员下载简历已用完 */
                    if ((int)$statis['down_resume'] <= 0) { // 弹出购买提示

                        if (!empty($spid)) {

                            $res['msg']             =   '当前账户套餐余量不足，请联系主账户增配！';

                            return $res;
                        } else {
                            $tmpYuan                =   $resumeM->setDayprice($eid);
                            if ($online != 4) { // 非套餐消费模式

                                if ($online == 3 && !in_array('downresume', explode(',', $this->config['sy_only_price']))) { // 积分消费

                                    $tmpJifen       =   $resumeM->setDayprice($eid, array('integral' => 'yes'));

                                    if ($serverOpen) {

                                        $res['msg'] =   "你的等级特权已经用完，继续" . $tag . "将消费 <span style=color:red;>" . $tmpJifen . "</span> " . $this->config['integral_pricename'] . "，是否" . $tag . "？";
                                    } else {

                                        $res['msg'] =   "你的套餐已经用完，你可以<a href=\"" . $this->config['sy_weburl'] . "/wap/member/index.php?c=rating\" style=\"color:red;cursor:pointer;\">购买会员</a>！";
                                    }

                                    /* 积分模式，是否需要充值判断 */
                                    $res['jifen']   =   $tmpJifen;
                                    $res['integral']=   intval($statis['integral']);
                                    $res['pro']     =   $this->config['integral_proportion'];
                                } else {

                                    if ($serverOpen) {

                                        $res['msg'] =   "你的等级特权已经用完,继续" . $tag . "将消费 <span style=color:red;>" . $tmpYuan . "</span> 元，是否" . $tag . "?";
                                    } else {

                                        $res['msg'] =   "你的套餐已经用完，你可以<a href=\"" . $this->config['sy_weburl'] . "/wap/member/index.php?c=rating\" style=\"color:red;cursor:pointer;\">购买会员</a>！";
                                    }
                                    $res['price']   =   $tmpYuan;
                                }

                                $res['type']        =   $user['height_status'];

                            } else { // 套餐消费模式

                                $res['price']       =   $tmpYuan;
                                $res['msg']         =   "你的套餐已经用完，你可以<a href=\"" . $this->config['sy_weburl'] . "/wap/member/index.php?c=rating\" style=\"color:red;cursor:pointer;\">购买会员</a>！";
                            }

                            $res['status']          =   2;
                            $res['online']          =   $online;
                            $res['uid']             =   $user['uid'];
                            return $res;
                        }
                    } else {

                        //收费会员简历没有用完的状态,直接下载
                        if ($usertype == 2) {

                            $suid                   =   $spid ? $spid : $uid;
                            $statisM->upInfo(array('down_resume' => array('-', 1)), array('uid' => $suid, 'usertype' => $usertype));
                        } else {

                            $statisM->upInfo(array('lt_down_resume' => array('-', 1)), array('uid' => $uid, 'usertype' => $usertype));
                        }

                        $this->_downResume($downData, $eid, $user, $data['uid']);

                        $res['status']              =   3;

                        $resArr                     =   $this->getResumePhone($user, $uid, $eid);

                        if (isset($resArr['msg']) && !empty($resArr['msg'])){

                            $res['msg']             =   $resArr['msg'];
                        }else{

                            $res['html']            =   $resArr['html'];
                            $res['waphtml']         =   $resArr['waphtml'];
                            $res['privatePhone']    =   $resArr['privatePhone'];
                            $res['prvusertel']      =   $resArr['prvusertel'];
                        }

                        return $res;
                    }
                } else if ($statis['rating_type'] == 2) {    //时间会员

                    $this->_downResume($downData, $eid, $user, $uid);

                    $res['status']                  =   3;

                    $resArr                         =   $this->getResumePhone($user, $uid, $eid);

                    if (isset($resArr['msg']) && !empty($resArr['msg'])){

                        $res['msg']                 =   $resArr['msg'];
                    }else{

                        $res['html']                =   $resArr['html'];
                        $res['waphtml']             =   $resArr['waphtml'];
                        $res['privatePhone']        =   $resArr['privatePhone'];
                        $res['prvusertel']          =   $resArr['prvusertel'];
                    }

                    return $res;
                } else {

                    $res['msg']                     =   '当前账户会员已过期，请联系网站管理员！';

                    return $res;
                }
            } else { // 过期会员

                if (empty($spid)) {

                    if ($online != 4) {    // 非套餐模式消费

                        $res['type']                =   $user['height_status'];

                        if ($online == 3 && !in_array('downresume', explode(',', $this->config['sy_only_price']))) {

                            $tmpJifen2              =   $resumeM->setDayprice($eid, array('integral' => 'yes'));
                            $res['msg']             =   '你的会员已到期，请先购买会员！';
                            $res['jifen']           =   $tmpJifen2;
                            $res['integral']        =   intval($statis['integral']);
                            $res['pro']             =   $this->config['integral_proportion'];
                        } else {

                            $tmpYuan2               =   $resumeM->setDayprice($eid);
                            $res['msg']             =   '你的会员已到期，请先购买会员！';
                            $res['price']           =   $tmpYuan2;
                        }
                    } else {

                        $res['msg']                 =   "你的会员已到期，你可以<a href='" . $this->config['sy_weburl'] . "/wap/member/index.php?c=rating' style='color:red;cursor:pointer;'>购买会员</a>！";
                    }
                    $res['online']                  =   $online;
                    $res['status']                  =   2;

                } else {

                    $res['msg']                     =   '当前账户会员已到期，请联系主账户升级！';
                }

                return $res;
            }
        }
    }

    /**
     * 私有方法 - 获取隐私号并记录
     * @param $user
     * @param $uid
     * @param $eid
     * @return array
     */
    private function getResumePhone($user, $uid, $eid)
    {

        $privatePhone  =  '';
        $isPrivate     =  false;

        //隐私号模式开启
        if ($this->config['sy_privacy_open'] == '1') {
            
            if($this->config['sy_privacy_type'] == '2') {
                // 隐私号设置未投递简历。查下有没有投递记录
                $tdnum  =  $this->select_num('userid_job',array('com_id' => $uid,'isdel'=>9,'eid' => $eid));
                if ($tdnum == 0){
                    $isPrivate = true;
                }
            }else{
                // 隐私号设置全部简历
                $isPrivate = true;
            }
        } 
        if ($isPrivate){

			//AXN模式 需要绑定双方号码 查询企业联系手机号
			$comInfo			=	$this ->select_once('company',array('uid'=>$uid),'linktel'); 
			
			$priData['NumberA']	=	$comInfo['linktel'];//主叫电话 企业联系电话	 

			$priData['NumberB']	=	$user['telphone'];//被叫电话 简历联系电话
			
			$priData['comid']	=	$uid;
			$priData['uid']		=	$user['uid'];
			$priData['eid']		=	$eid;
			$priData['type']	=	'1';

            // 绑定隐私号
            include_once('privacy.model.php');
            $noticeM    =   new privacy_model($this->db, $this->def);
			
            $prvReturn		=   $noticeM->setPrivacy($priData);
            $telphone		=	$prvReturn['middleNumber'];
			$prvtime		=	$prvReturn['prvtime'];
            if (isset($telphone)) {
                $privatePhone   =   $telphone;
                $prvusertel     =   $this->setContactHide($comInfo['linktel']);
                //PC弹出框
                $html           =   '<div class="tel_new">
						                <div class="tel_new_pd">
						                    <div class="tel_new_hmbox"><div class="tel_new_n" id="tel_new_n">' . $telphone . '</div></div>
						                    <div class=""><span class="tel_new_time" id="tel_new_time">电话将在<span id ="privacytime">' . $prvtime . '</span>s后过期，请尽快拨打</span></div>
                                            <div class=""><span class="tel_new_t">请使用手机号<span class="tel_new_p">'.$prvusertel.'</span>拨打电话</span></div>
						                    <div class="tel_new_ly">拨通后请说明<span class="tel_new_ly_p">来自 ' . $this->config['sy_webname'] . '</span></div>
						                </div>
						             </div>
						             <script>
							            var privacytime = ' . $this->config['sy_privacy_time'] . ';
							                
                                        function prvtime() {
                                            privacytime--;
                                            document.getElementById("privacytime").innerHTML = privacytime;
                                            if(privacytime <= 0) {
                                                document.getElementById("tel_new_n").innerHTML = "***********";
                                                document.getElementById("tel_new_time").innerHTML = "联系电话已过期，请刷新页面重新获取";
                                                clearInterval(prvinter);
                                            }
                                        }
                                        var prvinter = setInterval("prvtime()", 1000);
                                    </script>';
            } else {
                
                $res['msg'] = '号码获取失败，请稍后再试！';
            }
        }else {
            /* 返回联系方式信息数据 */
            $html   =   '<div class="tcktouch_box">';
            $html   .=  '<div class="tcktouch_box_tip">联系我时请说是在' . $this->config['sy_webname'] . '上看到的</div>';
            $html   .=  '<div class="tcktouch_box_p">手机：<span class="tcktouch_box_p_sj">' . $user['telphone'] . '</span></div>';
            if ($user['email']) {
                $html   .=  '<div class="tcktouch_box_p">邮箱：' . $user['email'] . '</div>';
            }
            if ($user['qq']) {
                $html   .=  '<div class="tcktouch_box_p">Q Q：' . $user['qq'] . '</div>';
            }
            if ($user['homepage']) {
                $html   .=  '<div class="tcktouch_box_p">主页：' . $user['homepage'] . '</div>';
            }
            if ($user['wxewm']) {
                $html   .=  '<div class="tcktouch_box_ewm"><img src=".' . $user['wxewm'] . '" width="100" height="100"><div class="tcktouch_box_ewm_p">个人二维码</div></div>';
            }
            $html   .=  '</div>';
        }

        return  array('privatePhone' => $privatePhone, 'html' => $html, 'msg' => $res['msg'], 'prvusertel'=>$prvusertel);
    }

    /**
     * 下载简历（私有方法）
     *
     * @param $data
     * @param $eid
     * @param $user
     * @param $uid
     */
    private function _downResume($data, $eid, $user, $uid)
    {

        $usertype           =   $data['comusertype'];
        $data['usertype']   =   $data['comusertype'];
        unset($data['comusertype']);

        // 增加下载简历记录
        $this->addInfo($data);

        // 增加下载简历数量
        $this->update_once('resume_expect', array('dnum' => array('+', 1)), array('id' => $eid));

        // 记录会员日志
        $this->addMemberLog($uid, $usertype, '下载了简历：' . $user['name'], 3, 1);

        // 发送私信
        require_once('sysmsg.model.php');
        $sysmsgM            =   new sysmsg_model($this->db, $this->def);

        if ($usertype == 3) {

            $uinfo          =   $this->select_once('member', array('uid' => $data['comid']), "`username`");
            $content        =   '猎头 <a href="comtpl,' . $data['comid'] . '">' . $uinfo['username'] . '</a> 下载了您('.$user['name'].')的简历';
        } else {

            $uinfo          =   $this->select_once('company', array('uid' => $data['comid']), '`name`');
            $content        =   '企业 <a href="comtpl,' . $data['comid'] . '">' . $uinfo['name'] . '</a> 下载了您('.$user['name'].')的简历';
        }

        $sysmsgM->addInfo(array('uid' => $user['uid'], 'usertype' => 1, 'content' => $content));

        // 预警 提示
        require_once('warning.model.php');
        $warningM           =   new warning_model($this->db, $this->def);
        $warningM->warning(2, $uid);
    }

    /**
     *导出下载简历
     *
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function Xls($id, $data = array())
    {
        require_once('resume.model.php');
        $ResumeM    =   new resume_model($this->db, $this->def);

        $cache      =   $this->getClass(array('user'));

        $down       =   $this->getList(array('comid' => $data['uid'], 'id' => array('in', pylode(',', $id))), array('field' => '`eid`'));
        if (is_array($down['list'])) {

            $eid    =   array();
            foreach ($down['list'] as $v) {
                if ($v['eid'] && !in_array($v['eid'], $eid)) {

                    $eid[]  =   $v['eid'];
                }
            }
        }
        if (isset($eid) && !empty($eid)) {
            $list   =   $ResumeM->getList(array('id' => array('in', pylode(',', $eid))), array('field' => 'id,uid,name,sex,edu,exp,hy,job_classid,city_classid,minsalary,maxsalary,type,report,lastupdate'));
            $list   =   $list['list'];

            $user_edu       =   $ResumeM->getResumeEdus(array('eid' => array('in', pylode(',', $eid))));
            $user_training  =   $ResumeM->getResumeTrains(array('eid' => array('in', pylode(',', $eid))));
            $user_skill     =   $ResumeM->getResumeSkills(array('eid' => array('in', pylode(',', $eid))));
            $user_work      =   $ResumeM->getResumeWorks(array('eid' => array('in', pylode(',', $eid))));
            $user_project   =   $ResumeM->getResumeProjects(array('eid' => array('in', pylode(',', $eid))));
            $user_other     =   $ResumeM->getResumeOthers(array('eid' => array('in', pylode(',', $eid))));
            if (isset($user_edu) && is_array($user_edu)) {
                foreach ($user_edu as $v) {

                    $time                   =   date("Y-m", $v['sdate']) . "-" . date("Y-m", $v['edate']);
                    $useredu[$v['eid']][]   =   $v['name'] . "##" . $time . "##" . $v['specialty'] . "##" . $v['title'] . "##" . $v['content'] . "##" . $cache['userclass_name'][$v['education']];
                }
            }
            if (isset($user_training) && is_array($user_training)) {
                foreach ($user_training as $v) {

                    $time                       =   date("Y-m", $v['sdate']) . "-" . date("Y-m", $v['edate']);
                    $usertraining[$v['eid']][]  =   $v['name'] . "##" . $time . "##" . $v['title'] . "##" . $v['content'];
                }
            }
            if (isset($user_skill) && is_array($user_skill)) {
                foreach ($user_skill as $v) {

                    $userskill[$v['eid']][]     =   $v['name'] . "##" . $v['longtime'] . '年';
                }
            }
            if (isset($user_work) && is_array($user_work)) {
                foreach ($user_work as $v) {
                    if ($v['edate'] > 0) {

                        $time                   =   date("Y-m", $v['sdate']) . "-" . date("Y-m", $v['edate']);
                    } else {

                        $time                   =   date("Y-m", $v['sdate']) . "-至今 ";
                    }
                    $userwork[$v['eid']][]      =   $v['name'] . "##" . $time . "##" . $v['department'] . "##" . $v['title'] . "##" . $v['content'];
                }
            }
            if (isset($user_project) && is_array($user_project)) {
                foreach ($user_project as $v) {

                    $time                       =   date("Y-m", $v['sdate']) . "-" . date("Y-m", $v['edate']);
                    $userproject[$v['eid']][]   =   $v['name'] . "##" . $time . "##" . $v['title'] . "##" . $v['content'];
                }
            }
            if (isset($user_other) && is_array($user_other)) {
                foreach ($user_other as $v) {

                    $userother[$v['eid']][]     =   $v['name'] . "##" . $v['content'];
                }
            }

            if (!empty($list)) {
                foreach ($list as $v) {
                    $uid[]  =   $v['uid'];
                }
                $resume     =   $ResumeM->getResumeList(array('uid' => array('in', pylode(',', $uid))), array("field" => 'uid,name,nametype,sex,birthday,marriage,height,weight,nationality,idcard,telphone,telhome,email,edu,homepage,address,exp,domicile,living,description'));

                foreach ($list as $k => $v) {
                    if ($v['job_classid'] != "") {
                        $list[$k]['job_classid']    =   $v['job_classname'];
                    }
                    if ($v['city_classid'] != "") {
                        $list[$k]['city_classid']   =   $v['city_classname'];
                    }
                    foreach ($resume as $val) {
                        if ($v['uid'] == $val['uid']) {
                            $list[$k]['resume']         =   $val;
                        }
                    }
                    foreach ($useredu as $key => $val) {
                        if ($v['id'] == $key) {
                            $list[$k]['user_edu']       =   @implode("||", $val);
                        }
                    }
                    foreach ($usertraining as $key => $val) {
                        if ($v['id'] == $key) {
                            $list[$k]['user_training']  =   @implode("||", $val);
                        }
                    }
                    foreach ($userskill as $key => $val) {
                        if ($v['id'] == $key) {
                            $list[$k]['user_skill']     =   @implode("||", $val);
                        }
                    }
                    foreach ($userwork as $key => $val) {
                        if ($v['id'] == $key) {
                            $list[$k]['user_work']      =   @implode("||", $val);
                        }
                    }
                    foreach ($userproject as $key => $val) {
                        if ($v['id'] == $key) {
                            $list[$k]['user_project']   =   @implode("||", $val);
                        }
                    }
                    foreach ($userother as $key => $val) {
                        if ($v['id'] == $key) {
                            $list[$k]['user_other']     =   @implode("||", $val);
                        }
                    }
                }
                $this->addMemberLog($data['uid'], $data['usertype'], "导出已下载简历信息", 3, 1);
            }
        }
        return $list;
    }

    /**
     * 下载简历数目
     * @param array $Where
     * @return array|bool|false|string|void
     */
    function getDownNum($Where = array())
    {

        return $this->select_num('down_resume', $Where);
    }
    /**
     * 设置联系方式为保密格式
     */
    private function setContactHide($tel){
        
        $tmpTel	=   '';
        $tmpTel	=   $this -> getNumbers($tel);
        $tel	=   sub_string($tmpTel);
        
        return $tel;
        
    }
    
    /**
     * 获取数字
     */
    private function getNumbers($phoneStr){
        
        $resNum                     =   '';
        
        preg_match_all('/\d+/', $phoneStr, $pregArr);
        
        if(!empty($pregArr) && !empty($pregArr[0])){
            foreach($pregArr[0] as $pv){
                $resNum             .=  $pv.' ';
            }
        }
        return mb_substr(trim($resNum), 0, 13);
    }
}

?>