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

/**
 * 行为日志操作类
 */
class weblog_model extends model
{

    public $modelType = array(

        'admin'             =>  '后台',
        'index'             =>  'PC端',
        'wap'               =>  'WAP端',
        'app'               =>  'APP',
        'weixin'            =>  '微信小程序',
        'baidu'             =>  '百度小程序',
        'toutiao'           =>  '抖音小程序',

        'member'            =>  'PC会员中心',

        'wap_member'        =>  'WAP会员中心',
        'wapapp_member'     =>  'WAP会员中心',

        'app_member'        =>  'APP会员中心',
        'weixin_member'     =>  '微信小程序会员中心',
        'baidu_member'      =>  '百度小程序会员中心',
        'toutiao_member'    =>  '头条会员中心'
    );

    public $userType    =   array('1' => '个人' , '2' => '企业', '3' => '猎头', '4' => '培训机构');

    /**
     * 添加行为日志
     * @param string $model
     * @param array $data
     */
    public function addWebLog($model, $data = array())
    {

        $webData = array(
            'uid'       =>  $data['uid'],
            'usertype'  =>  $data['usertype'],
            'uri'       =>  $_SERVER['REQUEST_URI'],
            'type'      =>  $_SERVER['REQUEST_METHOD'],
            'is_ajax'   =>  isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest" ? 1 : 0
        );

        if ($this->config['sy_seo_rewrite'] == 1) {

            if (preg_match("/yunurl/i", $_SERVER['QUERY_STRING'])) {

                $mcArr  =   @explode('=', $_SERVER['QUERY_STRING']);
                $mcArr  =   @explode('-', $mcArr[1]);
                $isRe   =   1;
            } else {

                $mcArr  =   @explode('&', $_SERVER['QUERY_STRING']);
            }
        } else {

            $mcArr      =   @explode('&', $_SERVER['QUERY_STRING']);
        }

        $webData['model']   =   $model;

        if ($model == 'wxapp'){                             //   接口

            if ($data['provider'] == 'app') {

                $webData['model'] = 'app';                  //  APP
            } else if ($data['provider'] == 'weixin') {

                $webData['model'] = 'weixin';               //  微信小程序
            } else if ($data['provider'] == 'baidu') {

                $webData['model'] = 'baidu';                //  百度小程序
            } else if ($data['provider'] == 'toutiao') {

                $webData['model'] = 'toutiao';              //  抖音小程序
            } else {

                $webData['model'] = 'wap';                  //  h5（WAP）
            }

            foreach ($mcArr as $k => $v) {

                $mcA    =   @explode('=', $v);

                if ($mcA[0] == 'h') {

                    if ($data['provider'] == 'app') {

                        $webData['model']   =   'app_member';       //  APP 会员中心
                    } else if ($data['provider'] == 'weixin') {

                        $webData['model']   =   'weixin_member';    //  微信小程序会员中心
                    } else if ($data['provider'] == 'baidu') {

                        $webData['model']   =   'baidu_member';     //  百度小程序会员中心
                    } else if ($data['provider'] == 'toutiao') {

                        $webData['model']   =   'toutiao_member';   //  抖音小程序会员中心
                    }else{

                        $webData['model']   =   'wapapp_member';        //  WAP会员中心
                    }
                }

                if ($mcA[0] == 'm') {
                    $webData['m']       =   $mcA[1];
                }
                if ($mcA[0] == 'c') {
                    $webData['c']       =   $mcA[1];
                }
            }

        } else if ($model == 'wap') {                          
            //   wap模块
            foreach ($mcArr as $k => $v) {
                if ($this->config['sy_seo_rewrite'] == 1) {
                    if ($isRe == 1) {

                        $mcA    =   @explode('_', $v);
                    } else {

                        $mcA    =   @explode('=', $v);
                    }
                } else {

                    $mcA        =   @explode('=', $v);
                }
                if ($mcA[0] == 'c') {
                    $webData['m']   =   $mcA[1];
                }
                if ($mcA[0] == 'a') {
                    $webData['c']   =   $mcA[1];
                }
            }
        } else if ($model == 'wap_member') {                   
            //  wap会员中心
            if ($data['usertype'] == 1) {

                $webData['m']   =   'user';

            } else if ($data['usertype'] == 2) {

                $webData['m']   =   'com';
            } else if ($data['usertype'] == 3) {

                $webData['m']   =   'lt';
            } else if ($data['usertype'] == 4) {

                $webData['m']   =   'px';
            }
            foreach ($mcArr as $k => $v) {
                if ($this->config['sy_seo_rewrite'] == 1) {
                    if ($isRe == 1) {

                        $mcA    =   @explode('_', $v);
                    } else {

                        $mcA    =   @explode('=', $v);
                    }
                } else {

                    $mcA        =   @explode('=', $v);
                }
                if ($mcA[0] == 'c') {
                    $webData['c']   =   $mcA[1];
                }
            }
        } else if ($model == 'member') {                       
            //   PC端会员中心
            if ($data['usertype'] == 1) {

                $webData['m']   =   'user';
            } else if ($data['usertype'] == 2) {

                $webData['m']   =   'com';
            } else if ($data['usertype'] == 3) {

                $webData['m']   =   'lt';
            } else if ($data['usertype'] == 4) {

                $webData['m']   =   'px';
            }

            foreach ($mcArr as $k => $v) {
                if ($this->config['sy_seo_rewrite'] == 1) {
                    if ($isRe == 1) {

                        $mcA    =   @explode('_', $v);
                    } else {

                        $mcA    =   @explode('=', $v);
                    }
                } else {

                    $mcA        =   @explode('=', $v);
                }

                if ($mcA[0] == 'c') {

                    $webData['c']   =   $mcA[1];
                }
                if ($mcA[0] == 'act'){

                    $webData['a']   =   $mcA[1];
                }
            }
        } else if ($model == 'admin') {                       
            //  后台
            $webData['uid']         =   $data['auid'];
            $webData['usertype']    =   0;
            $webData['m']           =   'index';
            foreach ($mcArr as $k => $v) {

                if ($this->config['sy_seo_rewrite'] == 1) {
                    if ($isRe == 1) {

                        $mcA    =   @explode('_', $v);
                    } else {

                        $mcA    =   @explode('=', $v);
                    }
                } else {

                    $mcA        =   @explode('=', $v);
                }

                if ($mcA[0] == 'm') {
                    $webData['m']   =   $mcA[1];
                }
                if ($mcA[0] == 'c') {
                    $webData['c']   =   $mcA[1];
                }
            }
        } else if ($model == 'index') {                       
            //  前台
            $modelArr   =   array('job', 'resume', 'part', 'company', 'article', 'announcement', 'hr', 'zph', 'ask', 'train', 'lietou', 'school', 'evaluate', 'once', 'tiny', 'redeem', 'map', 'special', 'reward', 'zphnet', 'redeem', 'spview', 'datav', 'gongzhao');

            foreach ($modelArr as $k => $v) {
                if (preg_match("/" . $v . "/i", $_SERVER['SCRIPT_NAME'])) {

                    $webData['m']   =   $v;
                }
            }

            foreach ($mcArr as $k => $v) {

                if ($this->config['sy_seo_rewrite'] == 1) {
                    if ($isRe == 1) {

                        $mcA    =   @explode('_', $v);
                    } else {

                        $mcA    =   @explode('=', $v);
                    }
                } else {

                    $mcA        =   @explode('=', $v);
                }
                if ($mcA[0] == 'm') {
                    $webData['m']   =   $mcA[1];
                }
                if ($mcA[0] == 'c') {
                    $webData['c']   =   $mcA[1];
                }
                if ($mcA[0] == 'a'){
                    $webData['a']   =   $mcA[1];
                }
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $webData['params']  =   serialize($_POST);
        } elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {

            $webData['params']  =   serialize($_GET);
        }

        $webData['ip']          =   fun_ip_get();
        $webData['time']        =   time();

        if ($model!='admin' && isset($data['auid'])){
            $webData['m']       =   'nolog';
        }

        $noAddArr   =   array('cron', 'geetest', 'nolog');

        if (!in_array($webData['m'], $noAddArr) && $model){

            $this->insert_into('web_log', $webData);
        }
    }

    /**
     * 查询行为日志
     * @param array $whereData
     * @param array $data
     * @return array|bool|false|string|void
     */
    public function getWebLog($whereData = array(), $data = array())
    {

        return $this->select_once('web_log', $whereData);
    }

    /**
     * 查询行为日志
     * @param array $whereData
     * @param array $data
     * @return array|bool|false|string|void
     */
    public function getWebLogList($whereData = array(), $data = array())
    {

        $data['field']  =   empty($data['field']) ? '*' : $data['field'];

        $List           =   $this->select_all('web_log', $whereData, $data['field']);

        if (!empty($List)) {

            $List       =   $this->getDataList($List);
        }

        return $List;
    }

    //会员日志后台列表数据处理
    private function getDataList($List)
    {

        foreach ($List as $v) {

            $uids[] =   $v['uid'];
        }
        //$adminuser  =   $this->select_all('admin_user', array('uid' => array('in', pylode(',', $uids))), '`uid`,`username`,`name`');

        $member     =   $this->select_all('member', array('uid' => array('in', pylode(',', $uids))), '`uid`,`username`');

        $resume     =   $this->select_all('resume', array('uid' => array('in', pylode(',', $uids))), '`uid`,`name`,`def_job`');
        $company    =   $this->select_all('company', array('uid' => array('in', pylode(',', $uids))), '`uid`,`name`');

        //$ltinfo     =   $this->select_all('lt_info', array('uid' => array('in', pylode(',', $uids))), '`uid`,`realname`');
        //$pxtrain    =   $this->select_all('px_train', array('uid' => array('in', pylode(',', $uids))), '`uid`,`name`');

        include PLUS_PATH.'route.php';

        foreach ($List as $k => $v) {

            $List[$k]['model_n']    =   $this->modelType[$v['model']];
            $List[$k]['usertype_n'] =   $this->userType[$v['usertype']];
            if ($v['model'] == 'app_member' || $v['model'] == 'weixin_member' || $v['model'] == 'baidu_member' || $v['model'] == 'toutioa_member'){
                $v['model'] =   'wapapp_member';
            }

            if ($v['model'] == 'app' || $v['model'] == 'weixin' || $v['model'] == 'baidu' || $v['model'] == 'toutioa'){
                $v['model'] =   'wxapp';
            }

            if ($v['model'] == 'member'){
                if ($v['usertype'] == 1){

                    if ($v['a']){

                        $List[$k]['action_name']    =   $logTypeUserM[$v['model']][$v['c']][$v['a']]['name'];
                    }elseif ($v['c']){

                        $List[$k]['action_name']    =   $logTypeUserM[$v['model']][$v['c']]['name'];
                    }elseif ($v['m']){

                        $List[$k]['action_name']    =   $logTypeUserM[$v['model']]['name'];
                    }
                }elseif ($v['usertype'] == 2){

                    if ($v['a']){

                        $List[$k]['action_name']    =   $logTypeComM[$v['model']][$v['c']][$v['a']]['name'];
                    }elseif ($v['c']){

                        $List[$k]['action_name']    =   $logTypeComM[$v['model']][$v['c']]['name'];
                    }elseif ($v['m']){

                        $List[$k]['action_name']    =   $logTypeComM[$v['model']]['name'];
                    }
                }
            }else if ($v['model'] == 'wap_member' || $v['model'] == 'wapapp_member'){
                if ($v['usertype'] == 1){

                    if ($v['a']){

                        $List[$k]['action_name']    =   $logTypeUserM[$v['model']][$v['m']][$v['c']][$v['a']]['name'];
                    }elseif ($v['c']){

                        $List[$k]['action_name']    =   $logTypeUserM[$v['model']][$v['m']][$v['c']]['name'];
                    }elseif ($v['m']){

                        $List[$k]['action_name']    =   $logTypeUserM[$v['model']][$v['m']]['name'];
                    }
                }elseif ($v['usertype'] == 2){

                    if ($v['a']){

                        $List[$k]['action_name']    =   $logTypeComM[$v['model']][$v['m']][$v['c']][$v['a']]['name'];
                    }elseif ($v['c']){

                        $List[$k]['action_name']    =   $logTypeComM[$v['model']][$v['m']][$v['c']]['name'];
                    }elseif ($v['m']){

                        $List[$k]['action_name']    =   $logTypeComM[$v['model']][$v['m']]['name'];
                    }
                }
            }else{

                if ($v['a']){

                    $List[$k]['action_name']    =   $logTypeM[$v['model']][$v['m']][$v['c']][$v['a']]['name'];
                }elseif ($v['c']){

                    $List[$k]['action_name']    =   $logTypeM[$v['model']][$v['m']][$v['c']]['name'];
                }elseif ($v['m']){

                    $List[$k]['action_name']    =   $logTypeM[$v['model']][$v['m']]['name'];
                }else{

                    $List[$k]['action_name']    =   $logTypeM[$v['model']]['name'];
                }
            }
			

            $List[$k]['time_n']     =   date('Y-m-d H:i:s', $v['time']);
            $List[$k]['timeymd_n']  =   date('Y-m-d', $v['time']);
            $List[$k]['timehis_n']  =   date('H:i:s', $v['time']);
            $List[$k]['ip']         =   $v['ip'];

            //行为说明

            $List[$k]['info']       =   $List[$k]['model_n'] .' ' . $List[$k]['action_name'];
            foreach ($member as $val) {
                if ($val['uid'] == $v['uid']) {

                    $List[$k]['username']   =   $val['username'];
                }
            }
            
            foreach ($resume as $val) {
                if ($v['uid'] == $val['uid']) {

                    $List[$k]['name_n']     =   $val['name'];
                }
            }
            foreach ($company as $val) {
                if ($v['uid'] == $val['uid']) {

                    $List[$k]['name_n']     =   $val['name'];
                }
            }
			/*
			foreach ($adminuser as $val) {
                if ($val['uid'] == $v['uid']) {

                    $List[$k]['username']   =   $val['username'];
                    $List[$k]['name_n']     =   $val['name'];
                }
            }
            foreach ($ltinfo as $val) {
                if ($v['uid'] == $val['uid']) {

                    $List[$k]['name_n']     =   $val['realname'];
                }
            }
            foreach ($pxtrain as $val) {
                if ($v['uid'] == $val['uid']) {

                    $List[$k]['name_n']     =   $val['name'];
                }
            }
			*/
        }
        return $List;
    }

    public function delWeblog($whereData = array(), $data = array())
    {

        $return['layertype'] = 0;

        if (!empty($whereData)) {
            if (!empty($whereData['id']) && $whereData['id'][0] == 'in') {
                $return['layertype']    =   1;
            }
            if ($data['norecycle'] == '1') {    //	数据库清理，不插入回收站

                $return['id']   =   $this->delete_all('web_log', $whereData, '', '', '1');
            } else {

                $return['id']   =   $this->delete_all('web_log', $whereData, '');
            }

            $return['msg']      =   '行为日志';
            $return['errcode']  =   $return['id'] ? '9' : '8';
            $return['msg']      =   $return['id'] ? $return['msg'] . '删除成功！' : $return['msg'] . '删除失败！';
        } else {

            $return['msg']      =   '请选择您要删除的行为日志！';
            $return['errcode']  =   8;
        }
        return $return;
    }

    /**
     * @param $datas
     * @return mixed
     */
    function logCount($datas)
    {

        $where['uid']   =   intval($datas['uid']);

        //默认取当天数据
        $today          =   strtotime(date('Y-m-d'));
        if ($datas['time'] == 1) {

            $where['time']  =   array('>=', $today, 'AND');
        } else if ($datas['time'] == 2) {

            $where['PHPYUNBTWSTART_A']  =   '';
            $where['time'][]            =   array('>=', strtotime('-1 day', $today), 'AND');
            $where['time'][]            =   array('<', $today, 'AND');
            $where['PHPYUNBTWEND_A']    =   '';
        } else if ($datas['time'] == 3) {

            $where['time']  =   array('>=', strtotime('-3 day', $today), 'AND');
        } else if ($datas['time'] == 4) {

            $where['time']  =   array('>=', strtotime('-7 day', $today), 'AND');
        }

        if ($datas['times']) {
            $times              =   @explode('~', $datas['times']);
            $where['PHPYUNBTWSTART_B']  =   '';
            $where['time'][]    =   array('>=', strtotime($times[0] . "00:00:00"), 'AND');
            $where['time'][]    =   array('<=', strtotime($times[1] . "23:59:59"), 'AND');
            $where['PHPYUNBTWEND_B']  =   '';
        }

        $count  =   $this->select_num('web_log', $where);
        $size   =   1000;
        $num    =   ceil($count / $size);

        $data['lognum'] = $data['lookjob'] = $data['searchjob'] = $data['sqjob'] = $data['chat'] = $data['lookresume'] = $data['downresume'] = $data['inviteresume'] = $data['addjob'] = $data['promote'] = $data['reserve'] = $data['pay'] = 0;

        $uInfo  =   $this->select_once('member', array('uid' => $datas['uid']), 'uid,username,moblie');

        if ($datas['usertype'] == 1){

            $sInfo  =   $this->select_once('resume', array('uid' => $datas['uid']), 'uid,name');
        }else if ($datas['usertype'] == 2){

            $sInfo  =   $this->select_once('company', array('uid' => $datas['uid']), 'uid,name');
        }

        $userInfo   =   array('uid' => $datas['uid'], 'username' => $uInfo['username'], 's_name' => $sInfo['name'], 'mobile' => $uInfo['moblie']);

        for ($i = 0; $i < $num; $i++) {

            $where['limit']     =   array($i * $size, $size);

            $where['orderby']   =   'id,asc';

            $list   =   $this->select_all('web_log', $where);

            if (!empty($list)) {

                foreach ($list as $key => $value) {

                    $data['lognum']++;

                    if ($key == 0) {
                        $data['startlog']   =   date('Y-m-d H:i:s', $value['time']);
                        $data['user_info']  =   'UID：'.$userInfo['uid']. '，账号：'.$userInfo['username']. '，名称：'.$userInfo['s_name']. '，手机：'.$userInfo['mobile'];
                    }
                    if ($datas['usertype'] == '1') {

                        //浏览职位详情
                        if ($value['c'] == 'comapply' || ($value['m'] == 'job' && $value['c'] == 'show')) {
                            $data['lookjob']++;
                        }
                        //职位搜索
                        if ($value['m'] == 'job' && ($value['c'] == '' || $value['c'] == 'search' || $value['c'] == 'list')) {
                            $data['searchjob']++;
                        }
                        //职位申请
                        if ($value['c'] == 'sq_job' || ($value['c'] == 'comapply' && $value['isajax'] == '1')) {
                            $data['sqjob']++;
                        }

                        //聊天统计
                        if ($value['m'] == 'com' && $value['c'] == 'chat') {
                            $data['chat']++;
                        }

                    } elseif ($datas['usertype'] == '2') {

                        //浏览简历
                        if ($value['m'] == 'resume' && $value['c'] == 'show' && $value['a'] == '') {
                            $data['lookresume']++;
                        }

                        //邀请面试
                        if ($value['c'] == 'indexajaxresume' || $value['c'] == 'invite') {
                            $data['inviteresume']++;
                        }

                        //聊天统计
                        if (($value['m'] == 'chat' && $value['c'] == 'getdown') || ($value['m'] == 'com' && $value['c'] == 'chat')) {
                            $data['chat']++;
                        }

                        //简历下载
                        if (($value['c'] == 'forlink' || $value['c'] == 'for_link') || ($value['m'] == 'resume' && $value['m'] == 'down')) {
                            $data['downresume']++;
                        }

                        //发布修改职位
                        if (($value['c'] == 'jobadd' && $value['a'] == 'save') || ($value['m'] == 'job' && $value['c'] == 'saveJob')) {
                            $data['addjob']++;
                        }

                        //推广服务 置顶 推荐 紧急 预约刷新
                        if ($value['c'] == 'job' && ($value['a'] == 'jobPromote' || $value['a'] == 'reserveUp')) {
                            $data['promote']++;
                        }

                        if ($value['m'] == 'fk' && ($value['c'] == 'getOrder' || $value['c'] == 'dkzf' || $value['c'] == 'coupongm')){

                            $params =   unserialize($value['params']);
                            if (in_array($params['server'], ['jobtop', 'jobrec', 'joburgent', 'autojob'])){
                                $data['promote']++;
                            }
                        }

                        //浏览套餐 增值包
                        if (($value['m'] == 'com' && $value['c'] == 'right') || ($value['m'] == 'fk' && $value['c'] == 'server')) {
                            $data['pay']++;
                        }
                    }
                }
            }
        }

        return $data;

    }

    /**
     * 计划任务：删除行为日志
     */
    public function delLogByCron()
    {

        $this->delete_all('web_log', array('time' => array('<', strtotime('-1 month'))), '', '', '1');
    }

}

?>