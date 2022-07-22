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

class crm_model extends model{

    /**
     * @desc   引用cache类
     * @param array $whereData
     * @return array|string|void
     */
    private function getCache($whereData = array())
    {
        require_once ('cache.model.php');
        $CacheM = new cache_model($this->db, $this->def);
        
        return  $CacheM -> GetCache($whereData); 
    }

    /**
     * @desc 新增业务员任务
     * @param array $data
     * @return array
     */
    public function addWaitingTask($data = array()) {
        
        if (!empty($data)) {
            
            if(empty($data['auid']) || empty($data['uid']) || empty($data['comid'])){
                $return = array(
                    'errcoder'  =>  8,
                    'msg'       =>  '参数错误，请重试！'
                );
            }
            
            if (empty($data['type'])) {
                $return = array(
                    'errcoder'  =>  8,
                    'msg'       =>  '请选择任务类型！'
                );
            }
            
            if (empty($data['stime']) && $data['type']=="22") {
                $return = array(
                    'errcoder'  =>  8,
                    'msg'       =>  '请填写任务时间！'
                );
            }
            
            if (empty($data['content'])) {
                $return = array(
                    'errcoder'  =>  8,
                    'msg'       =>  '请填写任务描述！'
                );
            }
            
            $auid   =   intval($data['auid']);
            $uid    =   intval($data['uid']);
            $comid  =   intval($data['comid']);
            
            $value  =   array(
                
                'auid'      =>  $auid,
                'uid'       =>  $uid,
                'comid'     =>  $comid,
                'type'      =>  intval($data['type']),
                'content'   =>  $data['content'],
                'ctime'     =>  time(),
                'status'    =>  '1',
            );

            if($data['stime']){
                $value['stime'] =   $data['stime'];
            }

            $cache          =   $this -> GetCache(array('crm'));

            $return['id']   =   $this->insert_into('crm_work_plan', $value);
            
            $lContent       =   '【添加计划任务】任务（ID：'.$return['id'].'），任务类型：'.$cache['crmclass_name'][$data['type']];
            $this->addCrmLog($lContent, '5', $comid, $auid);

            $return['errcode']  =   $return['id'] ? 9 : 8;
            $msg                =   $return['id'] ? '成功' : '失败';
            $return['msg']      =   '任务新建'.$msg;
            
            return $return;
        }
    }

    /**
     * @desc  查询任务数量
     * @param array $whereData
     * @return array|bool|false|string|void
     */
    function getTaskNum($whereData = array())
    {

        return $this -> select_num('crm_work_plan', $whereData);
    }

    /**
     * @desc 查询任务记录
     * @param array $where
     * @param array $data
     * @return array|bool|false|string|void
     */
    function  getTaskInfo($where = array(), $data = array())
    {
        
        $select =   $data['field'] ? $data['field'] : '*';
        
        $Info   =   $this -> select_once('crm_work_plan', $where, $select);
        if($Info['stime']){
            $Info['stime_n']   =  date('Y-m-d H:m:s',$Info['stime']);
        }
        return $Info;
        
    }


    /**
     * @desc 查询任务记录
     * @param array $where
     * @param array $data
     * @return array|bool|false|string|void
     */
    function  getTaskList($where = array(), $data = array())
    {
        
        $select     =   $data['field'] ? $data['field'] : '*';
        
        $taskList   =   $this -> select_all('crm_work_plan', $where, $select);
        
        $auids  =   $uids   =   $comids =   array();
        if (!empty($taskList) && isset($data['utype']) && $data['utype'] == 'crm') {
            
            foreach ($taskList as $value){
                
                $comids[]   =   $value['comid'];
                $uids[]     =   $value['uid'];
                $auids[]    =   $value['auid'];
            }
            
            $auids      =   array_unique(array_merge($auids, $uids));
            
            require_once 'company.model.php';
            $companyM   =   new company_model($this->db, $this->def);
            $list       =   $companyM -> getList(array('uid' => array('in', pylode(',', $comids))),array('field' => '`uid`, `name`'));
            $list       =   $list['list'];
            
            $awhere     =   array(
                'uid' => array('in', pylode(',', $auids)) 
            );
            
            $ausers     =   $this -> select_all('admin_user', $awhere, '`uid`,`name`,`crm_uid`');
            
            $weekarray  =   array('日','一','二','三','四','五','六');
            
            foreach ($taskList as $k => $v){
                
                if($v['stime']!=''){
                    
                    $stime      =   date('n月j日',$v['stime']).'(周'.$weekarray[date("w",$v['stime'])].')'.date('G点',$v['stime']);
                    $sfen       =   intval(date('i',$v['stime']));
                    
                    if($sfen){
                        $stime  .=  $sfen.'分';
                    }else{
                        $stime  .=  '整';
                    }
                    
                    $taskList[$k]['stime_n']   =   $stime;
                    
                    if ($v['stime'] >= strtotime(date('Y-m-d'))) {
                        
                        $taskList[$k]['taskDay']    =   format_datetime($v['stime'], 2, 2, '');
                    }else{
                        $taskList[$k]['taskDay']    =   format_datetime($v['stime'], 2, 1, '');
                    }
                    
                }
                
                if($v['ctime']){
                    $ctime      =   date('n月j日',$v['ctime']).'(周'.$weekarray[date("w",$v['ctime'])].')'.date('G点',$v['ctime']);
                    $cfen       =   intval(date('i',$v['ctime']));
                    if($cfen){
                        $ctime  .=  $cfen.'分';
                    }else{
                        $ctime  .=  '整';
                    }
                    $taskList[$k]['ctime_n']   =   $ctime;
                    
                    if ($v['ctime'] >= strtotime(date('Y-m-d'))) {
                        $taskList[$k]['addDay']    =   format_datetime($v['ctime'], 2, 2, '');
                    }else{
                        $taskList[$k]['addDay']    =   format_datetime($v['ctime'], 2, 1, '');
                    }
                    
                }
                foreach ($list as $uv){
                    
                    if ($v['comid'] == $uv['uid']) {
                        $taskList[$k]['name']   =   $uv['name'];
                        $taskList[$k]['crm_uid']    =   $uv['crm_uid'];
                    }
                }
                foreach ($ausers as $av){
                    
                    if ($v['uid'] == $av['uid']) {
                        $taskList[$k]['cname']   =   $av['name'];
                    }
                    if ($v['auid'] == $av['uid']) {
                        $taskList[$k]['aname']   =   $av['name'];
                    }
                }
            }
        }
        return $taskList;
    }

    /**
     * @desc 更新任务
     * @param array $data :tValue->更新数据 :auid 业务员uid
     * @param array $where
     * @return bool
     */
    function  upTask($data = array(), $where = array()) {
        
        if(!empty($data)){

            $tValue =   $data['tValue'];

            $result =   $this -> update_once('crm_work_plan', $tValue, $where);
            
            if($result){
        
                $auid   =   $data['auid'];

                $status_n   =   $tValue['status'] == '2' ? '完成' : $tValue['status'] == '3' ? '未完成 ' : '取消';
                            
                $lContent   =   "业务员（UID：".$auid."），标记任务ID：".$where['id']."状态 -> ".$status_n;
                $this->addCrmLog($lContent, '5', '', $auid);
            }
        }
        
        return  $result;
    }

    /**
     * @desc 删除任务
     * @param array $where
     * @param array $data
     * @return bool
     */
    function  delTask($where = array(), $data = array())
    {
        
        $result =   $this->delete_all('crm_work_plan', $where, '');      
        
        if($result){

            $lContent   =   "业务员（UID：".$data['auid']."）删除任务ID：".$where['id'];
            $this->addCrmLog($lContent, '5', '', $data['auid']);
        }

        return  $result;
    }

    /**
     * @desc    新增业务员跟进记录
     * @param array $data
     * @return bool
     */
    public function addConcern($data = array()) {
        
        if (!empty($data)) {
            
            $value  =   array(
                
                'uid'       =>  intval($data['uid']),
                'comid'     =>  intval($data['comid']),
                'time'      =>  strtotime($data['time']),
                'type'      =>  intval($data['type']),
                'content'   =>  $data['content'],
                'status'    =>  intval($data['status']),
                'note'      =>  $data['note'],
                'atime'     =>  time()
            );
            
            $nid    =   $this -> insert_into('crmnew_concern', $value);
            
            if ($nid) {
                $this->update_once('company', array('isfollow' => 1), array('uid' => $data['comid']));
            }
            return  $nid;
        }
    }

    /**
     * @desc  查询跟进记录数量
     * @param array $whereData
     * @return array|bool|false|string|void
     */
    function getConcernNum($whereData = array())
    {
        
        return $this -> select_num('crmnew_concern', $whereData);
        
    }

    /**
     * @desc 查询跟进记录
     * @param array $where
     * @param array $data
     * @return array|bool|false|string|void
     */
    function getConcernInfo($where = array(), $data = array())
    {
        
        $select         =   $data['field'] ? $data['field'] : '*';
        
        $concernInfo    =   $this -> select_once('crmnew_concern', $where, $select);
        
        return $concernInfo;
        
    }

    /**
     * @desc 查询跟进记录
     * @param array $where
     * @param array $data
     * @return array|bool|false|string|void
     */
    function getConcernList($where = array(), $data = array())
    {
        
        $select         =   $data['field'] ? $data['field'] : '*';
       
        $concernList    =   $this -> select_all('crmnew_concern', $where, $select);
       
        if (!empty($concernList)) {
            
            if(isset($data['utype']) && $data['utype'] == 'crm'){
                
                $cache      =   $this -> GetCache(array('crm'));
                
                $comids  =   $auids  =   array();
                
                foreach ($concernList as $value){
                    
                    $comids[]   =   $value['uid'];
                    $auids[]    =   $value['auid'];
                }
                
                $comList    =   $this->select_all('company', array('uid' => array('in', pylode(',', $comids))),'`uid`,`name`, `linkman`,`linktel`');
                
                $ausers     =   $this->select_all('admin_user', array('uid' => array('in', pylode(',', $auids))),'`uid`,`name`');
                 
                
                foreach ($concernList as $k => $v){
                    
                    if($v['type']){
                        $concernList[$k]['type_n']  =   $cache['crmclass_name'][$v['type']];
                    }
                    
                    if($v['ftime']){
                        $concernList[$k]['ftime_n'] =   date('Y-m-d H:i:s', $v['ftime']);
                    }else{
                        $concernList[$k]['ftime_n'] =   date('Y-m-d H:i:s', $v['atime']);
                    }

                    $concernList[$k]['atime_n']     =   date('Y-m-d H:i:s', $v['atime']);
                    
                    foreach ($comList as $cv){

                        if ($v['uid'] == $cv['uid']) {
                            $concernList[$k]['name']    =   $cv['name'];
                            $concernList[$k]['linkman'] =   $cv['linkman'];
                            $concernList[$k]['moblie']  =   $cv['linktel'];
                        }
                    }
                    foreach ($ausers as $av){
                        
                        if ($v['auid'] == $av['uid']) {
                            $concernList[$k]['aname']   =   $av['name'];
                        }
                    }
                }
            }
        }
        return $concernList;
    }

    /**
     * @desc    删除跟进记录
     * @param $delId
     * @param array $data
     * @return array
     */
    public function delConcern($delId, $data = array())
    {

        if (empty($delId)) {

            $return =   array(

                'errcode'   =>  8,
                'msg'       =>  '请选择要删除的数据！',
            );
        } else {
            if (is_array($delId)) {

                $delId                  =   pylode(',', $delId);
                $return['layertype']    =   1;
            } else {

                $return['layertype']    =   0;
            }

            $nid    =   $this->delete_all('crmnew_concern', array('id' => array('in', $delId)), '');

            //  同步跟新任务数据关联的跟进记录ID
            if ($nid) {

                $this->update_once('crm_work_plan', array('cid' => '0'), array('cid' => array('in', $delId)));

                if (!empty($data['auid'])) {

                    $lContent   =   "业务员（UID：" . $data['auid'] . "）删除跟进记录（ID：" . $delId . "）";
                    $this->addCrmLog($lContent, '3', '', $data['auid']);
                }
            }

            $return['msg']      =   '跟进记录';
            $return['errcode']  =   $nid ? '9' : '8';
            $return['msg']      .=  $nid ? '删除成功！' : '删除失败！';
        }

        return $return;
    }

    /**
     * @desc CRM 业务员  新开通客户会员等级  订单记录
     * @param array $data
     * @return array
     */
    public function addDeal($data = array())
    {

        if (!empty($data)) {
            
            if (empty($data['uid']) || empty($data['auid'])) {
                
                $return =   array(
                    'errcode'   =>  8,
                    'msg'       =>  '参数错误，请重试'
                );
            }
            
            if (empty($data['rating'])) {
                
                $return =   array(
                    'errcode'   =>  8,
                    'msg'       =>  '请选择会员套餐'
                );
            }else{
                
                $rating =   $this->select_once('company_rating', array('id' => intval($data['rating'])), '`name`');
                
                if (empty($rating)) {
                    
                    $return =   array(
                        'errcode'   =>  8,
                        'msg'       =>  '请选择正确的会员套餐'
                    );
                }
            }
            
            if (empty($data['order_type'])) {
                $return =   array(
                    'errcode'   =>  8,
                    'msg'       =>  '请选择支付方式'
                );
            }
            
            if (!empty($return)) {
                
                return $return;
            }
            
            
            $uid    =   intval($data['uid']);
            $auid   =   intval($data['auid']);
            
            if (!empty($data['order_price']) && round($data['order_price'], 2) > 0) {
                
                if (empty($data['id'])) {
                    $dingdan    =   time().rand(10000, 99999);
                    $orderData  =   array(
                        'uid'           =>  $uid,
                        'order_id'      =>  $dingdan,
                        'order_type'    =>  $data['order_type'],
                        'order_price'   =>  round($data['order_price'], 2),
                        'order_time'    =>  time(),
                        'order_state'   =>  '3',                    // 业务员开通订单
                        'order_remark'  =>  $data['order_remark'],
                        'type'          =>  1,
                        'rating'        =>  $data['rating'],
                        'crm_uid'       =>  $auid,
                        'usertype'      =>  2,
                        'did'           =>  $this->config['did']
                    );
                    
                    $return['id']       =   $this->insert_into('company_order', $orderData);
                }else{

                    $oldOrder   =   $this->select_once('company_order', array('id' => $data['id'], 'crm_uid' => $auid), '`rating`, `order_type`, `order_price`');
                    $oldrating  =   $this->select_once('company_rating', array('id' => intval($oldOrder['rating'])));
                     
                    $orderData  =   array(
                        
                        'order_type'    =>  $data['order_type'],
                        'order_price'   =>  round($data['order_price'], 2),
                        'order_time'    =>  time(),
                        'order_remark'  =>  $data['order_remark'],
                        'rating'        =>  $data['rating']
                    );
                    
                    $return['id']       =   $this->update_once('company_order', $orderData, array('id' => $data['id']));
                }
                
                if ($return['id']) {  
                    
                    if(empty($data['id'])){ //  修改订单，不记录

                        $logData    =   array(
                            'auid'      =>  $auid,
                            'uid'       =>  $uid,
                            'type'      =>  8,
                            'content'   =>  '开通会员【'.$rating['name'].'】, 录入订单【'.$dingdan.'】',
                            'remark'    =>  $data['order_remark'],
                            'ctime'     =>  time()
                        );
                        
                        $this->addCrmComLog($logData);
                    }
                    if(empty($data['id'])){

                        $lContent   =   '【录入订单】：开通会员《'.$rating['name'].'》, 订单：'.$dingdan;
                    }else{

                        $dingDan    =   $oldrating['order_id'];
                        $lContent   =   '【修改订单】';
                        if($data['rating'] != $oldOrder['rating']){
                            $lContent   .=  '会员等级：'.$oldrating['name'].' -> '.$rating['name'].'；';
                        }
                        if($data['order_type'] != $oldOrder['order_type']){
                            include(CONFIG_PATH.'db.data.php');
                            $lContent   .=  '支付方式：'.$arr_data['pay'][$oldOrder['order_type']].' -> '.$arr_data['pay'][$data['order_type']].'；';
                        }
                        if(round($data['order_price'], 2) != $oldOrder['order_price']){
                            $lContent   .=  '付款金额：'.$oldrating['order_price'].' -> '.$data['order_price'].'；';
                        }

                        $lContent   .=  '订单【'.$dingDan.'】';
                    }
                    
                    $this->addCrmLog($lContent, '4', $uid, $auid);
                }
                
                $return['errcode']  =   $return['id'] ? 9 : 8;
                $msg                =   $return['id'] ? '录入成功' : '录入失败，请重试！';
                $return['msg']      =   '客户订单'.$msg;
                
                return $return;
            }
        }
    }

    /**
     * @desc 查询数据，返回工作台简报数目
     * @param array $data
     * @return array
     */
    function getWorkReport($data = array())
    {

        if (!empty($data)) {

            $return =   array();

            $sdate  =   $data['sdate'];
            $edate  =   $data['edate'];
            $auid   =   intval($data['auid']);

            $timeArr    =   array(

                '0' =>  array('>', $sdate, 'AND'),
                '1' =>  array('<', $edate, 'AND')
            );

            $comWhere   =   array(

                'crm_time'  =>  $timeArr,
                'crm_uid'   =>  $auid
            );

            $return['khNum']    =   $this->select_num('company', $comWhere);


            $concernWhere   =   array(

                'atime' =>  $timeArr,
                'auid'  =>  $auid
            );

            $return['followNum']    =   $this->select_num('crmnew_concern', $concernWhere);

            $orderWhere =   array(

                'order_time'    =>   $timeArr,
                'crm_uid'       =>  $auid,
                'order_price'   =>  array('>', 0),
                'order_state'   =>  2
            );

            $orderAll   =   $this->select_all('company_order', $orderWhere, '`order_price`');

            $orderSum   =   0;

            foreach ($orderAll as $v) {
                $orderSum   +=  $v['order_price'];
            }
            if ($orderSum > 0) {

                $return['orderDealPrice']   =   floatval($orderSum);
            } else {

                $return['orderDealPrice']   =   0;
            }

            $return['orderNum'] =   $this->select_num('company_order', $orderWhere);
            return $return;
        }
    }

    public function getReleaseLogList($where = array(), $data = array()){
        $field  =   $data['field'] ? $data['field'] : '*';

        $List   =   $this->select_all('crm_release_log', $where, $field);
        if (!empty($List)) {
            foreach ($List as $v) {
                $auids[]    =   $v['auid'];
                $uids[] = $v['uid'];
            }
            $users  =   $this->select_all('admin_user', array('uid' => array('in', pylode(',', $auids))), '`uid`,`name`');
            foreach ($List as $k => $v) {
                foreach ($users as $val) {
                    if ($v['auid'] == $val['uid']) {

                        $List[$k]['name']   =   $val['name'];
                    }
                }
            }
            $companys  =   $this->select_all('company', array('uid' => array('in', pylode(',', $uids))), '`uid`,`name`');
            foreach ($List as $k => $v) {
                foreach ($companys as $val) {
                    if ($v['uid'] == $val['uid']) {

                        $List[$k]['comname']   =   $val['name'];
                    }
                }
            }
        }
        return $List;
    }

    public function delReleaseLog($delId, $data = array()){

        if(empty($delId)){

            $return  =   array(

                'errcode' => 8,

                'msg'   => '请选择要删除的数据！',
            );

        }else{

            if(is_array($delId)){

                $delId  =   pylode(',',$delId);

                $return['layertype']    =   1;

            }else{

                $return['layertype']    =   0;
            }

            $nid    =   $this -> delete_all('crm_release_log',array('id' => array('in',$delId)),'');

            if($nid && !empty($data['auid'])){
                $lContent   =   "业务员（UID：".$data['auid']."）删除释放记录（ID：".$delId."）";
                $this->addCrmLog($lContent, '6', '', $data['auid']);
            }

            $return['msg']      =   '释放记录';

            $return['errcode']  =   $nid ? '9' :'8';

            $return['msg']      .=  $nid ? '删除成功！' : '删除失败！';


        }
        return  $return;
    }

    /**
     * @desc 获取crm工作日志列表
     * @param array $where
     * @param array $data
     * @return array|bool|false|string|void
     */
    public function getWorkLogList($where = array(), $data = array())
    {

        $field  =   $data['field'] ? $data['field'] : '*';

        $List   =   $this->select_all('crm_work_log', $where, $field);
        if (!empty($List)) {
            foreach ($List as $v) {
                $auids[]    =   $v['auid'];
            }
            $users  =   $this->select_all('admin_user', array('uid' => array('in', pylode(',', $auids))), '`uid`,`name`');
            foreach ($List as $k => $v) {
                foreach ($users as $val) {
                    if ($v['auid'] == $val['uid']) {

                        $List[$k]['name']   =   $val['name'];
                    }
                }
            }
        }
        return $List;
    }

    /**
     * @desc    新增工作日志
     * @param array $data
     * @return array
     */
    public function addWorkLog($data = array())
    {

        if (!empty($data)) {

            $return =   array();

            $value  =   array(

                'auid'      =>  intval($data['auid']),
                'title'     =>  trim($data['title']),
                'content'   =>  $data['content'],
                'ctime'     =>  time()
            );
            $return['id']   =   $this->insert_into('crm_work_log', $value);
            $lContent       =   "【添加工作日志】 日志编号：" . $return['id'];
            $this->addCrmLog($lContent, '6', '', $data['auid']);

            if ($return['id']) {

                $return['errcode']  =   9;
                $return['msg']      =   '添加成功';
            } else {

                $return['errcode']  =   8;
                $return['msg']      =   '添加失败';
            }
            return $return;
        }
    }

    /**
     * @desc 查询任务记录
     * @param array $where
     * @param array $data
     * @return array|bool|false|string|void
     */
    function getWorkLogInfo($where = array(), $data = array())
    {

        $select =   $data['field'] ? $data['field'] : '*';

        return $this->select_once('crm_work_log', $where, $select);

    }

    /**
     * @desc  删除工作日志
     * @param $delId
     * @param array $data
     * @return array
     */
    public function delWorkLog($delId, $data = array()){
        
        if(empty($delId)){
           
            $return  =   array(
              
              'errcode' => 8,
               
              'msg'     => '请选择要删除的数据！',                
            );
        
        }else{
            
            if(is_array($delId)){
                
                $delId  =   pylode(',',$delId);
                
                $return['layertype']    =   1;
            
            }else{
                
                $return['layertype']    =   0;
            }
            
            $nid    =   $this -> delete_all('crm_work_log',array('id' => array('in',$delId)),'');

            if($nid && !empty($data['auid'])){
                $lContent   =   "业务员（UID：".$data['auid']."）删除工作日志（ID：".$delId."）";
                $this->addCrmLog($lContent, '6', '', $data['auid']);
            }

            $return['msg']      =   '工作日志';
            
            $return['errcode']  =   $nid ? '9' :'8';
            
            $return['msg']      .=  $nid ? '删除成功！' : '删除失败！';
         
        
        }
        return  $return;
    }

    /**
     * @desc    获取外出申请列表
     * @param array $where
     * @param array $data
     * @return array|bool|false|string|void
     */
    public function getOutList($where = array(), $data = array())
    {
        $field  =   $data['field'] ? $data['field'] : '*';
        
        $List   =   $this->select_all('crm_out', $where, $field);
        
        if (!empty($List)) {
            
            $uids   =   $comids =   array();
            
            foreach ($List as $v) {
                if ($v['auid'] && !in_array($v['auid'], $uids)) {
                    $uids[]     = $v['auid'];
                }
                if ($v['uid'] && !in_array($v['uid'], $comids)) {
                    $comids[]   = $v['uid'];
                }
            }

            $user   =   $this->select_all('admin_user', array('uid' => array('in', pylode(',', $uids))), '`uid`,`name`');
            
            $com    =   $this->select_all('company', array('uid' => array('in', pylode(',', $comids))), '`uid`,`name`,`linkman`,`linktel`');
            
            foreach ($List as $k => $v) {
            
                foreach ($user as $val) {
                    if ($v['auid'] == $val['uid']) {
                        $List[$k]['name'] = $val['name'];
                    }
                }
                
                foreach ($com as $value) {
                    if ($v['uid'] == $value['uid']) {
                        $List[$k]['comname'] = $value['name'];
                        $List[$k]['linkman'] = $value['linkman'];
                        $List[$k]['linktel'] = $value['linktel'];
                    }
                }
            }
        }
        return $List;
    }
    /**
     * @desc    新增外出申请
     * @param array $data
     */
    public function addOut($data = array()){
       
        if (!empty($data)) {
            
            $return =   array();
            
            $value  =   array(
                'auid'      =>  intval($data['auid']),
                'uid'       =>  intval($data['uid']),
                'reason'    =>  intval($data['reason']),
                'remark'    =>  $data['remark'],
                'stime'     =>  $data['stime'],
                'etime'     =>  $data['etime'],
                'status'    =>  1,
                'ctime'     =>  time()
            );
            
            $return['id']       =   $this -> insert_into('crm_out', $value);
            $lContent   =   "【外出申请】业务员（UID：".$data['auid']."）申请外出";
            $this->addCrmLog($lContent, '10', $data['uid'], $data['auid']);
             
            $return['errcode']  =   $return['id'] ? 9 : 8;
            $msg                =   $return['id'] ? '成功' : '失败';
            $return['msg']      =   '添加外出申请'.$msg;
            
            return $return;
        }
    }
    
    /**
     * @desc    更新外出记录
     */
    function  upOut($data = array(), $where = array()) {
        
        return  $this -> update_once('crm_out', $data, $where);
    }
    /**
     * @desc   删除外出申请
     */
    public function delOut($delId, $data = array()){
        
        if(empty($delId)){
           
            $return =   array(
                'errcode'   =>  8,
                'msg'       =>  '请选择要删除的数据！',                
            );
        }else{
            
            if(is_array($delId)){
                
                $delId  =   pylode(',',$delId);
                $return['layertype']    =   1;
            }else{
                
                $return['layertype']    =   0;
            }
            
            $nid    =   $this -> delete_all('crm_out',array('id' => array('in',$delId)),'');

            if($nid && !empty($data['auid'])){
                $lContent   =   "业务员（UID：".$data['auid']."）取消外出申请（ID：".$delId."）";
                $this -> addCrmLog($lContent, '10', '', $data['auid']);
            }

            $return['msg']      =   '外出申请';
            $return['errcode']  =   $nid ? '9' :'8';
            $return['msg']      .=  $nid ? '取消成功！' : '取消失败！';
        }

        return  $return;
    }

    /**
     * @desc CRM客户管理操作记录
     * @param array $data
     * @return bool
     */
    function addCrmComLog($data = array())
    {
        if (!empty($data)) {

            return $this->insert_into('crm_comlog', $data);
        }
    }

    /**
     * @desc 获取客户操作记录（顾问对客户的操作）
     * @param array $where
     * @param array $data
     */
    function getComLogList($where = array(), $data = array()){
        
        $field      =   $data['field'] ? $data['field'] : '*';

        $logList    =   array();
        
        if (!empty($where)) {
            
            $logList    =   $this->select_all('crm_comlog', $where, $field);
            
            $cache      =   $this -> GetCache(array('crm'));
            
            $comids  =   $auids  =   array();
            
            foreach ($logList as $value){
                
                $comids[]   =   $value['uid'];
                $auids[]    =   $value['auid'];
            }
            
            $comList    =   $this->select_all('company', array('uid' => array('in', pylode(',', $comids))),'`uid`,`name`, `linkman`,`linktel`');
            
            $ausers     =   $this->select_all('admin_user', array('uid' => array('in', pylode(',', $auids))),'`uid`,`name`');
            
            
            foreach ($logList as $k => $v){
                
                if($v['type'] == 1){
                    
                    $logList[$k]['type_n']  =   '【转交】 业务员：【】';
                    
                }else if($v['type'] == 2){
                    
                    $logList[$k]['type_n']  =   '【放弃】';
                    
                }else if($v['type'] == 3){
                    
                    $logList[$k]['type_n']  =   '【开通订单：金牌会员】';
                    
                }else if($v['type'] == 4){
                    
                    $logList[$k]['type_n']  =   '【跟进/访问】';
                    
                }else if($v['type'] == 5){
                    
                    $logList[$k]['type_n']  =   '【修改企业资料】';
                    
                }else if($v['type'] == 6){
                    
                    $logList[$k]['type_n']  =   '【修改联系方式】';
                    
                }else if($v['type'] == 7){
                    
                    $logList[$k]['type_n']  =   '【'.$v['content'].'】';
                }else if($v['type'] == 8){
                    
                    $logList[$k]['type_n']  =   '【最新反馈备注】';
                    
                }else if($v['type'] == 9){
                    
                    $logList[$k]['type_n']  =   $v['content'];
                }
                 
                foreach ($comList as $cv){
                    
                    if ($v['uid'] == $cv['uid']) {
                        $logList[$k]['name']    =   $cv['name'];
                        $logList[$k]['linkman'] =   $cv['linkman'];
                        $logList[$k]['moblie']  =   $cv['linktel'];
                    }
                }
                
                foreach ($ausers as $av){
                    
                    if ($v['auid'] == $av['uid']) {
                        $logList[$k]['aname']   =   $av['name'];
                    }
                }
            }
            
            
        }
        
        return $logList;
         
    }
    
    /**
     * @desc 转交客户
     * @param array $data|crm_uid 转移到顾问UID; uid 客户（企业）ID; auid 转移顾问本人UID
     */
    function deliverUser($data = array()){
        
        if (!empty($data)){

            if (empty($data['crm_uid'])) {
                 
                $return =   array(
                    'errcode'   =>  8,
                    'msg'       =>  '请选择转交客户顾问'
                );
                return $return;
            }
            
            if (empty($data['uid'])) {
                $return =   array(
                    'errcode'   =>  8,
                    'msg'       =>  '请选择需要转交的客户'
                );
                return $return;
            }
            
            $crm_uid    =   intval($data['crm_uid']);
            $crm_name   =   trim($data['crm_name']);
            
            $uid        =   explode(',', $data['uid']);
            
            $auid       =   intval($data['auid']);
            $remark     =   $data['remark'];

            $return['id']   =   $this->update_once('company', array('crm_uid' => $crm_uid), array('uid' => array('in', pylode(',', $uid))));
            
            if ($return['id']) {
                
                $logData    =   array();
                
                foreach ($uid as $k => $v){
                    $logData[$k]['auid']    =   $auid;
                    $logData[$k]['uid']     =   $v;
                    $logData[$k]['type']    =   1;
                    $logData[$k]['content'] =   '【售后转交客户】给【业务员：'.$crm_name.'】';
                    $logData[$k]['remark']  =   $remark;
                    $logData[$k]['ctime']   =   time();
                }
                
                $this->DB_insert_multi('crm_comlog', $logData);

                $lContent   =   "【转交客户】 业务员（UID：".$auid."）转交客户（UID：".pylode(',', $uid)."）给".$crm_name;
                $this->addCrmLog($lContent, '7', '', $auid);
            }
            
            $return['errcode']  =   $return['id'] ? 9 : 8;
            $msg                =   $return['id'] ? '成功' : '失败';
            $return['msg']      =   '客户转交'.$msg;
            return $return;
        }
    }
    
    /**
     * @desc 放弃客户
     * @param array $data|uid 客户（企业）ID; auid 操作人UID
     */
    function giveUpUser($data = array()){
        
        if (!empty($data)){
            
            if (empty($data['uid'])) {
                $return =   array(
                    'errcode'   =>  8,
                    'msg'       =>  '请选择需要放弃的客户'
                );
                return $return;
            }
            
            $uid        =   explode(',', $data['uid']);
            $auid       =   intval($data['auid']);
            $remark     =   $data['remark'];
            
            $return['id']   =   $this->update_once('company', array('crm_uid' => '0', 'crm_time' => '0', 'isfollow' => '0', 'f_time' => '', 'pcrmuid' => $auid, 'release_time' => time()), array('uid' => array('in', pylode(',', $uid))));
            
            if ($return['id']) {
                $this->delete_all('crm_work_plan', array('comid' => array('in', pylode(',', $uid))), '');
                $logData    =   array();
                
                foreach ($uid as $k => $v){
                    $logData[$k]['auid']    =   $auid;
                    $logData[$k]['uid']     =   $v;
                    $logData[$k]['type']    =   2;
                    $logData[$k]['content'] =   '【放弃客户】';
                    $logData[$k]['remark']  =   $remark;
                    $logData[$k]['ctime']   =   time();
                }
                
                $this->DB_insert_multi('crm_comlog', $logData);

                $lContent   =   "【放弃客户】 业务员（UID：".$auid."）放弃客户（UID：". pylode(',', $uid)."）";
                $this->addCrmLog($lContent, '8', '', $auid);
            }
            
            $return['errcode']  =   $return['id'] ? 9 : 8;
            $msg                =   $return['id'] ? '成功' : '失败';
            $return['msg']      =   '放弃客户'.$msg;
            
            return $return;
        }
    }
    
    /**
     * @desc 修改客户状态/等级
     * @param array $data|uid 客户（企业）ID; auid 操作人UID; st 客户状态/等级ID st_n 状态/等级名称
     */
    function upComST($data = array()){
        
        if (!empty($data)){
            
            if (empty($data['st'])) {
                $return =   array(
                    'errcode'   =>  8,
                    'msg'       =>  $data['isSt'] == 'status' ? '请选择客户状态' : '请选择客户等级'
                );
                return $return;
            }
            
            if (empty($data['uid'])) {
                $return =   array(
                    'errcode'   =>  8,
                    'msg'       =>  '请选择需要修改等级的客户'
                );
                return $return;
            }
            
            $uid    =   explode(',', $data['uid']);
            
            $auid   =   intval($data['auid']);
            $st     =   intval($data['st']);
            $st_n   =   $data['st_n'];
            $remark =   $data['remark'];

            $value  =   $data['isSt'] == 'status' ? array('crm_status' => $st) : array('crm_type' => $st);

            //$oCom =   $this->select_all('company',array('uid' => array('in', pylode(',', $uid))), '`uid`,`crm_status`, `crm_type`');
            
            $return['id']   =   $this->update_once('company', $value, array('uid' => array('in', pylode(',', $uid))));
            
            if ($return['id']) {
                
                $logData    =   array();
                
                $type       =   $data['isSt'] == 'status' ? 9 : 7;
                $content    =   $data['isSt'] == 'status' ? '【修改客户状态】为：【'.$st_n.'】' : '【标记客户等级】为：【'.$st_n.'】';
                
                foreach ($uid as $k => $v){
                    $logData[$k]['auid']    =   $auid;
                    $logData[$k]['uid']     =   $v;
                    $logData[$k]['type']    =   $type;
                    $logData[$k]['content'] =   $content;
                    $logData[$k]['remark']  =   $remark;
                    $logData[$k]['ctime']   =   time();
                }
                
                $this->DB_insert_multi('crm_comlog', $logData);
                
                $lContent   =   $data['isSt'] == 'status' ? '【修改客户状态】业务员（UDI：'.$auid.'）更新客户状态为：【'.$st_n.'】' : '【标记客户等级】业务员（UDI：'.$auid.'）更新客户等级为：【'.$st_n.'】';
                
                $this->addCrmLog($lContent, '9', '', $auid);
            }
            
            $return['errcode']  =   $return['id'] ? 9 : 8;
            $msg                =   $data['isSt'] == 'status' ?'客户状态修改' : '客户等级修改';
            $msg                .=   $return['id'] ? '成功' : '失败';
            $return['msg']      =   $msg;
            
            return $return;
        }
    }

    /**
     * @desc 客户管理 -> 联系跟进记录添加
     * @param array $data |uid 客户（企业）ID; auid 操作人UID;
     * @return array
     */
    function addFollow($data = array()){

        if (!empty($data)){
            
            if (empty($data['uid'])) {
                $return =   array(
                    'errcode'   =>  8,
                    'msg'       =>  '参数错误，请重试！'
                );
                return $return;
            }
            
            if (empty($data['type'])) {
                $return =   array(
                    'errcode'   =>  8,
                    'msg'       =>  '请选择跟进方式！'
                );
                return $return;
            }

            if (empty($data['ftime'])) {
                $return =   array(
                    'errcode'   =>  8,
                    'msg'       =>  '请填写跟进时间！'
                );
                return $return;
            }
            
            if (empty($data['remark'])) {
                $return =   array(
                    'errcode'   =>  8,
                    'msg'       =>  '请填写跟进描述！'
                );
                return $return;
            }
            
            require_once 'company.model.php';
            $comM   =   new company_model($this->db, $this->def);
            $uid    =   intval($data['uid']);
            $comInfo=   $comM -> getInfo($uid, array('field' => '`uid`, `crm_uid`, `linkman`, `linktel`'));

            $auid   =   intval($data['auid']);
            
            if ($auid != $comInfo['crm_uid']) {

                $crmInfo    =   $this->select_once('admin_user', array('uid' => $comInfo['crm_uid']), 'org');

                $auids      =   array();    //  有编辑跟进权限的UID

                $lastOrg    =   $this->select_once('crmorg', array('id' => $crmInfo['org']), 'id, level, fid');

                if ($lastOrg['level'] == 3){

                    $threeCrmArr    =   $this->select_all('admin_user', array('org' => $lastOrg['id'], 'power' => 1), 'uid');

                    $twoOrg         =   $this->select_once('crmorg', array('id' => $lastOrg['fid']), 'id, fid');

                    $twoCrmArr      =   $this->select_all('admin_user', array('org' => $twoOrg['id'], 'spower' => 1), 'uid');

                    $oneCrmArr      =   $this->select_all('admin_user', array('org' => 1, 'spower' => 1), 'uid');

                }else if ($lastOrg['level'] == 2){

                    $twoCrmArr      =   $this->select_all('admin_user', array('org' => $lastOrg['id'], 'power' => 1), 'uid');

                    $oneCrmArr      =   $this->select_all('admin_user', array('org' => 1, 'spower' => 1), 'uid');

                }else if ($lastOrg['level'] == 1){

                    $oneCrmArr      =   $this->select_all('admin_user', array('org' => 1, 'spower' => 1), 'uid');
                }

                if (isset($threeCrmArr)){
                    foreach ($threeCrmArr as $three) {
                        $auids[]    =   $three['uid'];
                    }
                }
                if (isset($twoCrmArr)){
                    foreach ($twoCrmArr as $two) {
                        $auids[]    =   $two['uid'];
                    }
                }
                if (isset($oneCrmArr)){
                    foreach ($oneCrmArr as $one) {
                        $auids[]    =   $one['uid'];
                    }
                }

                if (!in_array($auid, $auids)) {

                    $return = array(
                        'errcode' => 8,
                        'msg' => '非自己客户，暂无权限添加跟进！'
                    );
                    return $return;
                }
            }
            
            if (!empty($data['crmtid'])) {  // 完成任务，添加跟进反馈说明
                
                $data['remark'] =   '完成任务，添加跟进反馈：'.$data['remark'];
            }
            
            $value      =   array(

                'uid'       =>  $uid,
                'auid'      =>  $auid,
                'ftime'     =>  strtotime($data['ftime']),
                'type'      =>  intval($data['type']),
                'content'   =>  $data['remark'],
                'atime'     =>  time()
            );
            
            if ($data['follow'] == 1 && !empty($data['ptime'])) {
                $value['time']  =   strtotime($data['ptime']);
                if (strtotime($data['ptime']) < time()) {
                    $return =   array(
                        'errcode'   =>  8,
                        'msg'       =>  '跟进时间需在当前时间之后！'
                    );
                    return $return;
                }
                
                $taskValue  =   array(
                    
                    'auid'      =>  $auid,
                    'uid'       =>  $auid,
                    'comid'     =>  $uid,
                    'type'      =>  22, //  跟进任务类型字段  值22 跟进任务 
                    'content'   =>  $data['remark'].'；需要进一步跟进【'.$data['ptime'].'】',
                    'stime'     =>  strtotime($data['ptime']),
                    'ctime'     =>  time()
                );
            } 
            
            if ($data['id']) {  // 修改跟进

                $value['uptime']    =   time();
                
                $return['id']       =   $this -> update_once('crmnew_concern', $value, array('id' => intval($data['id'])));
                
                if(empty($data['taskid'])){

                    if (isset($taskValue) && !empty($taskValue)) {

                        $taskValue['cid'] = intval($data['id']);

                        $arr = $this->addWaitingTask($taskValue);

                        if ($arr['id']) {

                            $this->update_once('crmnew_concern', array('taskid' => $arr['id']), array('id' => intval($data['id'])));
                        }
                    }
                }else{
                    
                    $this -> upTask($taskValue, array('id' => intval($data['taskid'])));
                }

            }else{  // 新增跟进
                
                $return['id']   =   $this -> insert_into('crmnew_concern', $value);
                
                if(isset($taskValue) && !empty($taskValue)){
                    
                    $taskValue['cid']   =   $return['id'];
                    
                    $arr    =   $this -> addWaitingTask($taskValue);
                    
                    if ($arr['id']) {
                        
                        $this->update_once('crmnew_concern', array('taskid' => $arr['id']), array('id' => $return['id']));
                    }
                } 
            }
            
            if ($return['id']) {

                $mC =   '';
                if(isset($data['linkman']) && $data['linkman'] != $comInfo['linkman']){

                    $comValue['linkman']    =   $data['linkman'];
                    $mC .=   '联系人：'.$comInfo['linkman'].'→'.$data['linkman'];
                }
                if(isset($data['linktel']) && $data['linktel'] != $comInfo['linktel'] && CheckMobile($data['linktel'])){

                    $comValue['linktel']    =   $data['linktel'];
                    $mC .=   '联系电话：'.$comInfo['linktel'].'→'.$data['linktel'];
                }

                if (isset($comValue) && !empty($comValue)){

                    $this->update_once('company', $comValue, array('uid' => $comInfo['uid']));

                    $this->addCrmLog('跟进客户，修改联系方式；'.$mC, 11, $comInfo['uid'], $auid);
                }

                $pMsg       =   $data['follow'] == '1' && empty($data['taskid'])? '【添加新计划任务：跟进（'.$data["ptime"].'）】' : '';

                $content    =   $data['id'] ? '【跟进记录】业务员（UDI：'.$auid.'）更新跟进记录（ID：'.$data['id'].'）'.$pMsg  : '【跟进记录】业务员（UDI：'.$auid.'）新增跟进记录（ID：'.$return['id'].'）'.$pMsg;

                $logData    =   array(
                    'auid'      =>  intval($data['auid']),
                    'uid'       =>  $uid,
                    'type'      =>  4,
                    'content'   =>  $content,
                    'remark'    =>  $data['remark'],
                    'ctime'     =>  time()
                );
                
                $this->addCrmComLog($logData);
                
                $lContent   =   $content;


                $this->addCrmLog($lContent, 3, $uid, $data['auid']);
                
                if(!empty($data['crmtid'])){

                    $this->update_once('crm_work_plan',array('status' => 2, 'etime' => time()), array('id' => $data['crmtid']));
                }else if ($auid == $comInfo['crm_uid']){

                    $this->update_once('crm_work_plan',array('status' => 2, 'etime' => time()), array('stime' => array('<', strtotime(date('Y-m-d 23:59:59'))), 'uid' => $auid, 'comid' => $uid, 'type' => 22, 'status' => 1));
                }
                
                $this->update_once('company', array('isfollow' => 1, 'f_time' => time()), array('uid' => $uid));
            }
            
            $return['errcode']  =   $return['id'] ? 9 : 8;
            $msg                =   $data['id'] ? '修改' : '添加';
            $msg                .=   $return['id'] ? '成功' : '失败';
            $return['msg']      =   '客户跟进'.$msg;
            
            return $return;
        }
    }

    /**
     * @desc 修改客户联系方式
     * @param array $data |uid 客户（企业）ID; auid 操作人UID;
     * @return array
     */
    function upComLink($data = array()){
        
        if (!empty($data)){
            
            if (empty($data['linktel'])) {
                $return =   array(
                    'errcode'   =>  8,
                    'msg'       =>  '请填写客户联系手机'
                );
                return $return;
            }elseif(!CheckMobile($data['linktel'])){
                $return =   array(
                    'errcode'   =>  8,
                    'msg'       =>  '客户联系手机格式错误，请重新填写'
                );
                return $return;
            }
            
            if (!empty($data['linkphone']) && !CheckTell($data['linkphone'])) {
                $return =   array(
                    'errcode'   =>  8,
                    'msg'       =>  '客户固话格式错误，请重新填写'
                );
                return $return;
            }
            
            if (!empty($data['linkmail']) && !CheckRegEmail($data['linkmail'])) {
                $return =   array(
                    'errcode'   =>  8,
                    'msg'       =>  '客户邮箱格式错误，请重新填写'
                );
                return $return;
            }
            
            if (empty($data['uid'])) {
                $return =   array(
                    'errcode'   =>  8,
                    'msg'       =>  '参数错误，请重试'
                );
                return $return;
            }
            
            $uid    =   intval($data['uid']);
            $auid   =   intval($data['auid']);
            
            $upData         =   array(
                'linkman'   =>  $data['linkman'],
                'linkjob'   =>  $data['linkjob'],
                'linktel'   =>  $data['linktel'], 
                'linkphone' =>  $data['linkphone'], 
                'linkmail'  =>  $data['linkmail']
            );

            $comInfo        =   $this -> select_once('company', array('uid' => $uid), '`uid`,`linkman`,`linkjob`,`linktel`,`linkphone`,`linkmail`');

            $return['id']   =   $this -> update_once('company', $upData , array('uid' => $uid));
            
            if ($return['id']) {
                
                $logData    =   array(
                    'auid'      =>  $auid,
                    'uid'       =>  $uid,
                    'type'      =>  6,
                    'content'   =>  '【修改企业联系方式】',
                    'remark'    =>  '联系人：'.$data['linkman'].'，职称：'.$data['linkjob'].'，手机：'.$data['linktel'].'，固话：'.$data['linkphone'].'，邮箱：'.$data['linkmail'],
                    'ctime'     =>  time()
                );
                $this->addCrmComLog($logData);
                
                $keyArr     =   array('linkman','linkjob','linktel','linkphone','linkmail');    
                $nameArr    =   array('linkman' => '联系人', 'linkjob' => '职称', 'linktel' => '手机', 'linkphone' => '固话', 'linkmail' => '邮箱');   
                $lContent   =   "";
            
                foreach($comInfo as $ck => $cv){
                    if($cv != $data[$ck] && in_array($ck, $keyArr)){
                        $lContent   .=  $nameArr[$ck]."：".$cv." -> ".$data[$ck]."；";    
                    }       
                }           
                
                if($lContent!=""){
                    $this->addCrmLog("【联系方式】业务员（UID：".$auid."）更新企业联系方式：".$lContent, 11, $uid, $auid);
                }

            }   
            
            $return['errcode']  =   $return['id'] ? 9 : 8;
            $msg                =   $return['id'] ? '成功' : '失败';
            $return['msg']      =   '客户联系方式修改'.$msg;
            
            return $return;
        }
    }
    
    /**
     * @desc 联系反馈-》添加备注
     * @param array $data|uid 客户（企业）ID; auid 操作人UID;  
     */
    function remarkCom($data = array()){
        
        if (!empty($data)){
            
            if (empty($data['uid'])) {
                $return =   array(
                    'errcode'   =>  8,
                    'msg'       =>  '参数错误，请重试！'
                );
                return $return;
            }
            
            $uid        =   intval($data['uid']);
            $auid       =   intval($data['auid']);
            $remark     =   $data['crm_remark'];
            
            $return['id']   =   $this->update_once('company', array('crm_remark' => $remark), array('uid' => $uid));
            
            if ($return['id']) {
                
                $logData = array(
                    'auid'      =>  $auid,
                    'uid'       =>  $uid,
                    'type'      =>  8,
                    'content'   =>  '【添加备注反馈】',
                    'remark'    =>  $remark,
                    'ctime'     =>  time()
                );
                
                $this->addCrmComLog($logData);
            }
            
            $return['errcode']  =   $return['id'] ? 9 : 8;
            $msg                =   $return['id'] ? '成功' : '失败';
            $return['msg']      =   '客户备注'.$msg;
            
            return $return;
        }
    }
    
    /**
     * @desc 获取短信模板
     * @param array $data: uid, auid, tp;
     */
    function getMsgTpl($data = array()){
        
        if (!empty($data)) {
            
            if (empty($data['uid']) || empty($data['auid']) || empty($data['tp'])) {
                
                $return =   array(
                    'errcode'   =>  8,
                    'msg'       =>  '参数错误，请重试'   
                );
                
                return $return;
            }
            
            $uid    =   intval($data['uid']);
            $auid   =   intval($data['auid']);
            $tp     =   trim($data['tp']);
            
            $msgData=   array();
            
            $crm    =   $this->select_once('admin_user', array('uid' => $auid), '`name`,`moblie`');
            if (!empty($crm) && is_array($crm)) {
                $msgData['aname']   =   $crm['name'];
                $msgData['aphone']  =   $crm['moblie'];
            }
            
            if ($tp == 'crmreg') {
                
                $member     =   $this->select_once('member', array('uid' => $uid), '`username`');
                $msgData['username']    =   $member['username'];
            }
            
            $msgData['type']    =   $tp;
            
            require_once 'notice.model.php';
            $noticeM    =   new notice_model($this->db, $this->def);
            $msgTpl     =   $noticeM -> getTpl($msgData, 'msg');

            if ($msgTpl['status'] == '-1') {
                
                $return['errcode']  =   8;
                $return['msg']      =   $msgTpl['msg'];
                
            }else{
                $return['errcode']  =   9;
                $return['content']  =   $msgTpl['content'];
                $return['length']   =   mb_strlen($msgTpl['content'], 'UTF-8');
            }
            
            return  $return;
        }
        
    }
    
    /**
     * @desc    CRM管理客户，发送短信
     * @param array $data 
     */
    function sendCrmMsg($data = array()) {
        
        if (!empty($data)) {
            
            if (empty($data['uid']) || empty($data['auid']) || empty($data['tp']) || empty($data['mobile']) || empty($data['content'])) {
                
                $return  =   array(
                    'errcode'   =>  8,
                    'msg'       =>  '参数错误，请重试！'
                );
                return $return;
            }
            
            require_once 'notice.model.php';
            $noticeM    =   new notice_model($this->db, $this->def);
            
            $msgData    =   array(
                'mobile'    =>  $data['mobile'],
                'content'   =>  $data['content'],
                'uid'       =>  $data['uid'],
                'type'      =>  $data['tp'],
                'port'      =>  '5'
            );
            
            $arr    =   $noticeM ->sendSMSType($msgData, $data['content']);
            
            $return['errcode']  =   $arr['status'] == '1' ? 9 : 8;
            $return['msg']      =   $arr['msg'];
               
            return $return;
        }
    }
    
    /**
     * @desc 客户管理，修改密码
     * @param array $data
     */
    function upPassword($data = array()) {
        
        $return =   array();
        
        $uid            =   intval($data['uid']);
        $pass           =   trim($data['password']);
        
        require_once 'userinfo.model.php';
        $userinfoM      =   new userinfo_model($this->db, $this->def);
        
        $passA          =   $userinfoM -> generatePwd(array('password'=>$pass));
        $password       =   $passA['pwd'];
        $salt           =   $passA['salt'];
        
        $return['id']   =   $this -> update_once('member',array('password'=>$password, 'salt'=>$salt), array('uid'=>$uid));
        
        if ($return['id']) {
            
            require_once 'sysmsg.model.php';
            
            $sysmsgM    =   new sysmsg_model($this->db, $this->def);
            
            $sysmsgM    ->  addInfo(array('uid' => $uid, 'usertype'=>2, 'content' => '管理员为您修改密码：'.$pass));
            
        }
        
        $return['errcode']  =   $return['id'] ? 9 : 8 ;
        
        $return['msg']      =   $return['id'] ? '密码修改成功！': '密码修改失败！' ;
        
        return $return;
    }
    /**
     * @desc 公众号通知业务员 crm
     * @desc $this -> MODEL('admin')->sendCrmWxMsg();
     */
    public function sendCrmWxMsg($auid='',$data=array('type'=>'','first'=>'','title'=>''))
    {
        if ($auid && $data['first']) {
            if($auid!='' && $auid>0){
                $awhere   =   array('uid' => $auid);
            }else{
                //$awhere   =   array('m_id' => 1);
                if($data['type']){
                    $wmtype   =   $this->select_once('admin_wmtype', array('type' =>$data['type']), '`uid`');
                }
                if($wmtype['uid']){
                    $awhere   =   array('uid' => array('in',$wmtype['uid']));
                }
                
            }

            if(!empty($awhere)){
                $user   =   $this->select_all('admin_user', $awhere, '`uid`,`name`,`moblie`,`r_status`,`wxid`,`qy_userid`');
            }
            
            
            if (! empty($user)) {

                require_once ('weixin.model.php');
                $weixinM = new weixin_model($this->db, $this->def);

                if($this->config["sy_admin_wmtype"]==1){

                    foreach ($user as $v) {
                    
                        if ($v['wxid']) {
                            
                            $weixinM->sendWxAdmin(array(
                                'uid'   =>  $v['uid'],
                                'type'  =>  $data['type'],     
                                'first' =>  $data['first'],
                                'wxid'  =>  $v['wxid'],
                                'title' =>  $data['title'],
                            ));
                        }
                    }
                }else if($this->config["sy_admin_wmtype"]==2){

                    $uids = $userids = array();

                    foreach ($user as $v) {
                    
                        if ($v['qy_userid']) {
                            $uids[]    = $v['uid'];
                            $userids[] = $v['qy_userid'];

                        }
                    }

                    $weixinM->sendWxQyAdmin(array(
                        'type'  =>  $data['type'],     
                        'first' =>  $data['first'],
                        'userids'  =>  $userids,
                        'uids'  =>  $uids,
                        'title' =>  $data['title'],
                    ));
                }

                
            }
        }
    }

    /**
     * @desc 我的客户数量查询: 客户总数，待审核客户，未通过客户，锁定客户
     * @param array $data
     * @return string
     */
    function getMyCustomerNum($data = array())
    {

        $crmUid =   intval($data['crm_uid']);
        $arr    =   array();
        //企业总数
        $companyAllNum                  =   $this->select_num('company', array('crm_uid' => $crmUid));
        if ($companyAllNum > 0) {
            $arr['companyAllNum']       =   $companyAllNum;
        }

        //待审核企业
        $companyStatusNum1              =   $this->select_num('company', array('crm_uid' => $crmUid, 'r_status' => '0'));
        if ($companyStatusNum1 > 0) {
            $arr['companyStatusNum1']   =   $companyStatusNum1;
        }

        //未通过企业
        $companyStatusNum2              =   $this->select_num('company', array('crm_uid' => $crmUid, 'r_status' => '3'));
        if ($companyStatusNum2 > 0) {
            $arr['companyStatusNum2']   =   $companyStatusNum2;
        }

        //锁定企业
        $companyStatusNum3              =   $this->select_num('company', array('crm_uid' => $crmUid, 'r_status' => '2'));
        if ($companyStatusNum3 > 0) {
            $arr['companyStatusNum3']   =   $companyStatusNum3;
        }
        return json_encode($arr);
    }

    /**
     * @desc 认领客户
     * @param array $uids
     * @param null $auid
     * @return string[]
     */
    function claimCom($uids = array(), $auid = null){
        
        if(empty($uids) || empty($auid)){
            
            $return =   array(
                'errcode'   =>  '8',
                'msg'       =>  '领取失败，参数错误'
            );
        }else{

            $aInfo  =   $this->select_once('admin_user', array('uid' => $auid), '`num`,`name`');

            if ((int)$aInfo['num'] > 0){

                $khs    =   $this->select_num('company', array('crm_uid' => $auid));

                if ($khs >= (int)$aInfo['num']){
                    return array('errcode' => '8', 'msg' => '客户数量已达上限，暂时无法领取更多客户');
                }
            }


            // 释放资源，限定期限不能领取；
            $comAll =   $this->select_all('company', array('pcrmuid' => $auid, 'release_time' => array('>', '0') ,'uid' => array('in', pylode(',', $uids))), '`uid`,`rating`,`release_time`');
            $claim  =   $this->select_all('crmset', array('claim_day' => array('>', '0')));
            
            $cuids  =   array();
            foreach ($claim as $ck => $cv){
                foreach ($comAll as $cav) {
                    $cav['rating']  =   $cav['rating'] == '0' ? '999' : $cav['rating'];
                    if (in_array($cav['rating'], explode(',', $cv['rating'])) && $cav['release_time'] > strtotime("-".$cv['claim_day']." day")){
                        $cuids[]    =   $cav['uid'];
                    }
                }
            }

            if(!empty($cuids)){
                 
                $uids   =   array_diff($uids, $cuids);
            }
            
            if(!empty($uids)){
                
                $result =   $this->update_once('company', array('crm_uid' => $auid, 'crm_time' => time(), 'release_time' => ''), array('uid' => array('in', pylode(',', $uids))));


                if ($result) {

                    $logData    =   array();

                    foreach ($uids as $k => $v){
                        $logData[$k]['auid']    =   $auid;
                        $logData[$k]['uid']     =   $v;
                        $logData[$k]['type']    =   12;
                        $logData[$k]['content'] =   '业务员：'.$aInfo["name"].'【领取客户】';
                        $logData[$k]['ctime']   =   time();
                    }

                    $this->DB_insert_multi('crm_comlog', $logData);

                    $lContent   =   "【领取客户】 业务员".$aInfo['name']."（UID：".$auid."）领取客户（UID：".pylode(',', $uids)."）";
                    $this->addCrmLog($lContent, '12', '', $auid);
                }

                $return =   array(
                    'errcode'   =>  $result ? '9' : '8',
                    'msg'       =>  $result ? '客户领取成功！' : '客户领取失败！'
                );

            }else{

                $return =    array(
                    'errcode'   =>  '8',
                    'msg'       =>  '刚释放资源客户，近期无法领取'
                );
            }
        }

        return $return;
    }

    /**
     *  计划任务
     *
     *  CRM资源释放：1 未跟进客户  2 会员未变动客户
     */
    function releaseCom(){

        $crmSet =   $this->select_all('crmset', array('release_day' => array('>', '0')));
     
        foreach ($crmSet as $k => $v) {
            
            if((int)$v['release_day'] > 0){

                /* 周期内，未跟进客户进行释放 */
                $fWhere[$k]['crm_uid']          =   array('>', '0');
                // 暂停的用户不释放
                $fWhere[$k]['r_status']			=   array('<>', '4');
                $fWhere[$k]['rating']           =   array('in', $v['rating']);
                
                $fWhere[$k]['PHPYUNBTWSTART']   =   '';
                
                $fWhere[$k]['uid']              =   array('>', '0');

                $fWhere[$k]['PHPYUNBTWSTART_A'] =   '';
                $fWhere[$k]['isfollow']         =   array('=', '0');
                $fWhere[$k]['crm_time']         =   array('<', strtotime('-'.$v["release_day"].' days'),'');
                $fWhere[$k]['PHPYUNBTWEND_A']   =   '';

                $fWhere[$k]['PHPYUNBTWSTART_B'] =   'or';
                $fWhere[$k]['f_time'][]         =   array('<', strtotime('-'.$v["release_day"].' days'),'AND');
                $fWhere[$k]['f_time'][]         =   array('>', '0','AND');
                $fWhere[$k]['PHPYUNBTWEND_B']   =   '';
                $fWhere[$k]['PHPYUNBTWEND'] =   '';
                
                $fComs  =   $this->select_all('company', $fWhere[$k], '`uid`,`crm_uid`');
                
                 
                if(!empty($fComs)){
                    foreach($fComs as $fk => $fv){
                        $this->update_once('company', array('crm_uid' => '0', 'crm_time' => '0', 'isfollow' => '0', 'f_time' => '', 'pcrmuid' => $fv['crm_uid'], 'release_time' => time()), array('uid' => $fv['uid']));
                        $this->insert_into('crm_release_log',array('auid'=>$fv['crm_uid'],'uid'=>$fv['uid'],'ctime'=>time(),'content'=>'释放计划任务'));
                    }
                }
            }
        }

        $crmDealSet =   $this->select_all('crmset', array('deal_day' => array('>', '0')));
        
        foreach ($crmDealSet as $k1 => $v1) {

            if ((int)$v1['deal_day'] > 0) {

                /* 周期内，会员未变动释放 */
                $fWhere[$k1]['crm_uid']         = array('<>', '0');
                // 暂停的用户不释放
                $fWhere[$k1]['r_status']		= array('<>', '4');

                if (!strpos($v1['rating'], '999')) {

                    $fWhere[$k1]['PHPYUNBTWSTART_A']=   '';
                    $fWhere[$k1]['vipetime'][]      =   array('<', time(), '');
                    $fWhere[$k1]['vipetime'][]      =   array('<', strtotime('-' . $v1["deal_day"] . ' days'), '');
                    $fWhere[$k1]['PHPYUNBTWEND_A']  =   '';
                } else {

                    $fWhere[$k1]['rating']          =   array('in', $v1['rating']);
                    $fWhere[$k1]['vipstime']        =   array('<', strtotime('-' . $v1["deal_day"] . ' days'), '');
                }

                $fWhere[$k1]['crm_time']            =   array('<', strtotime('-' . $v1["deal_day"] . ' days'), '');

                $RComs = $this->select_all('company', $fWhere[$k1], '`uid`,`crm_uid`');

                if (!empty($RComs)) {
                    foreach ($RComs as $Rk => $Rv) {

                        $this->update_once('company', array('crm_uid' => '0', 'crm_time' => '0', 'isfollow' => '0', 'f_time' => '', 'pcrmuid' => $Rv['crm_uid'], 'release_time' => time()), array('uid' => $Rv['uid']));
                        $this->insert_into('crm_release_log', array('auid' => $Rv['crm_uid'], 'uid' => $Rv['uid'], 'ctime' => time(), 'content' => '释放计划任务'));
                    }
                }
            }
        }
    }

    /**
     *  添加CRM操作日志
     *
     * @param $content      内容
     * @param string $type  1-录入客户，2- ,3- ,4- ,5- ,6- ,7- ,8- ,9- ,10- ,11-
     * @param string $uid   操作对象，客户uid
     * @param string $auid  业务员UID
     */
    function addCrmLog($content, $type='', $uid='', $auid = ''){
        
        if ($auid && $type && $content){
            
            $data   =   array(
                'uid'       =>  $uid,
                'content'   =>  $content,
                'type'      =>  $type,
                'auid'      =>  $auid,
                'ctime'     =>  time()
            );
            
            $this -> insert_into('crm_log', $data);
        }               
    }

    /**
     *  查询CRM操作日志
     * @param array $where  查询条件
     * @param array $data
     * @return array|bool|false|string|void
     */
    function getCrmLogList($where = array(), $data = array()){
        
        $field      =   $data['field'] ? $data['field'] : '*';

        $logList    =   array();
        
        if (!empty($where)) {

            $typeArr    =   array('1' => '用户录入', '2' => '客户信息', '3' => '跟进记录' , '4' => '订单数据', '5' => '工作任务', '6' => '工作日志', '7' => '转交客户', '8' => '放弃客户', '9' => '等级状态', '10' => '外出申请', '11' => '联系方式', '12' => '领取客户');
            
            $logList    =   $this->select_all('crm_log', $where, $field);
            
            $auids      =   array();
            
            foreach ($logList as $value){
                
                $auids[]    =   $value['auid'];
            }
            
            $ausers     =   $this->select_all('admin_user', array('uid' => array('in', pylode(',', $auids))),'`uid`,`name`');
            
            foreach ($logList as $k => $v){
                
                $logList[$k]['type_n']  =   $typeArr[$v['type']];
                foreach ($ausers as $av){
                    
                    if ($v['auid'] == $av['uid']) {
                        $logList[$k]['aname']   =   $av['name'];
                    }
                }
            }
        }
        
        return $logList;
    }

    /**
     *  删除CRM操作日志
     * @param $delId
     * @param array $data
     * @return array
     */
    function delCrmLog($delId, $data=array()){

        if (empty($delId)) {

            $return     =   array( 'errcode' => 8, 'msg' => '请选择要删除的数据！');
        } else {

            if (is_array($delId)) {

                $delId  =   pylode(',', $delId);

                $return['layertype']    =   1;
            } else {

                $return['layertype']    =   0;
            }
             
            $result             =   $this -> delete_all('crm_log', array('id' => array('in', $delId)), '');

            $return['msg']      =   'CRM 操作记录';
            $return['errcode']  =   $result ? '9' : '8';
            $return['msg']      =   $result ? $return['msg'].'删除成功！' : $return['msg'].'删除失败！';
        }

        return $return;
    }
     
    /**
     * 
     * @desc 查询资源配置数据
     * @param $where
     * @param $data
     */
    function getCrmsetList($where = array(), $data = array()){
        
        $data['field']  =   empty($data['field']) ? '*' : $data['field'];
        
        $List           =   $this -> select_all('crmset', $where, $data['field']);
        
        if (!empty($List)){
            
            require_once 'rating.model.php';
            $ratingM    =   new rating_model($this->db, $this->def);
            
            $ratings    =   $ratingM -> getList(array('category' => '1'), '`id`, `name`');
            
            $ratingArr  =   array();
            foreach ($ratings as $v) {
                $ratingArr[$v['id']]    =   $v['name'];
            }
            $ratingArr['999']   =   '过期会员';
            
            foreach ($List as $key => $value) {
                
                $ratingIDArr    =   @explode(',', $value['rating']);
                $ratingName     =   array();
                foreach ($ratingIDArr as $rv){
                    $ratingName[]   =   $ratingArr[$rv];    
                }
                
                $List[$key]['rating_name']  =   @implode('，', $ratingName);
            }
            
        }
        
        return  $List;
    }

    /**
     *
     * @desc 查询资源配置数据
     * @param $where
     * @param $data
     * @return array|bool|false|string|void
     */
    function getCrmsetInfo($where = array(), $data = array())
     {
        
        $data['field']  =   empty($data['field']) ? '*' : $data['field'];

        return $this -> select_once('crmset', $where, $data['field']);
    }

    /**
     * @desc 添加资源配置数据
     * @param $data
     * @return string[]
     */
    function addCrmset($data = array()){
        
        if (!empty($data)){
            
            $id     =   $data['id'];            
            $value  =   $data['value'];
            
            if (!empty($id)){
                
                $return['id']   =   $this->update_once('crmset', $value, array('id' => $id));
            }else{
                
                $return['id']   =   $this -> insert_into('crmset', $value);
            }
            
            $return['errcode']  =   $return['id'] ? '9' : '8';
            $return['msg']      =   $return['id'] ? '资源配置成功！' : '资源配置失败！';
        }else{
            
            $return =   array('errcode' => '8', 'msg' => '参数错误！');
        }
        
        return $return;
    }

    /**
     * @desc 删除CRM资源池配置数据
     * @param $delId
     * @return string[]
     */
    function delCrmset($delId = null)
    {

        if ($delId == null) {

            $return =   array(

                'errcode'   =>  '8',
                'msg'       =>  '参数错误'
            );
        } else {

            $result =   $this->delete_all('crmset', array('id' => $delId), '');

            $return['errcode']  =   $result ? '9' : '8';
            $return['msg']      =   $result ? '配置数据删除成功！' : '配置数据删除失败！';
        }

        return $return;
    }

    function addCrmOrg($data = array()){
        
        if (!empty($data)){
            
            $vData  =   array(

                'name'  =>  $data['name'],
                'level' =>  $data['level'],
                'fid'   =>  $data['fid'] ? $data['fid'] : '0',
                'sort'  =>  $data['sort']
            );
            
            $return['id']       =   $this->insert_into('crmorg', $vData);
            $return['errcode']  =   $return['id'] ? '9' : '8';
            $return['msg']      =   $return['id'] ? '添加成功！' : '添加失败！';
        }else{
            
            $return['errcode']  =   '8';
            $return['msg']      =   '参数错误！';
        }
        
        return $return;
    }
    
    function upCrmOrg($id, $data = array()){
        
        if (!empty($id) && !empty($data)){
            
            $result =   $this->update_once('crmorg', $data, array('id' => $id));
            $return['errcode']  =   $result ? '9' : '8';
            $return['msg']      =   $result ? '更新成功！' : '更新失败！';
        }else{
            
            $return['errcode']  =   '8';
            $return['msg']      =   '参数错误！';
        }
        
        return $return;
    }
    
    function getOrgInfo($where = array(), $data = array()){
        
        $select =   $data['field'] ? $data['field'] : '*';
        
        if (!empty($where)){
            
            $orgInfo    =   $this->select_once('crmorg', $where, $select);
            
            if ($orgInfo['level'] == '3'){
                
                $fOrg   =   $this->select_once('crmorg', array('id' => $orgInfo['fid']));   // 二级
                
                $ffOrg  =   $this->select_once('crmorg', array('id' => $fOrg['fid']));      //  一级
                
                $orgInfo['fname']   =   $fOrg['name'];
                $orgInfo['ffname']  =   $ffOrg['name'];
                $orgInfo['ffid']    =   $ffOrg['id'];
                
            }elseif ($orgInfo['level'] == '2'){
                
                $fOrg   =   $this->select_once('crmorg', array('id' => $orgInfo['fid']));   //  一级
                $orgInfo['fname']   =   $fOrg['name'];
            }
            
            if ((int)$orgInfo['level']<3){
                 
                $orgSList       =   $this->select_all('crmorg', array('fid' => $orgInfo['id']), $select);
                foreach ($orgSList as $ok => $ov) {
                    $orgSList[$ok]['num']   =   $this->select_num('admin_user', array('org' => $ov['id']));
                }
                $orgInfo['list']=   $orgSList;
            }
            
            // 部门成员
            $musers             =   $this -> select_all('admin_user', array('org' => $orgInfo['id']));
            foreach ($musers as $mv) {
                $muserids[]     =   $mv['uid'];
            }
            $aWhere             =   array(
                'is_crm'            =>  '1',
                'PHPYUNBTWSTART_A'  =>  '',
                'org'               =>  array(
                    '0' =>  array('=', $orgInfo['id'], 'OR'),
                    '1' =>  array('isnull', '', 'OR'),
                    '2' =>  array('=', '0', 'OR')
                ),
                'PHPYUNBTWEND_A'    =>  ''  
            );
            $ausers             =   $this -> select_all('admin_user', $aWhere, '`uid`,`name`');
            
            $orgInfo['musers']  =   $musers;
            $orgInfo['muserids']=   $muserids;
            $orgInfo['ausers']  =   $ausers;
        }
        
        return $orgInfo;
    }
    
    function getOrgList($where = array(), $type=null){
        
        $data['field']  =   empty($data['field']) ? '*' : $data['field'];
        
        $orgList        =   $this -> select_all('crmorg', $where, $data['field']);
        
        if ($type == 'org'){
            
            $oneArr =   $twoArr = $threeArr = array();
            
            foreach ($orgList as $ok => $ov) {
                $orgList[$ok]['num']    =   $this->select_num('admin_user', array('org' => $ov['id']));
            }
            foreach ($orgList as $k => $v) {
                
                
                if ($v['level'] == '1'){
                    
                    $Arr[$v['level']][]     =   $v;
                     
                }else if ($v['level'] == '2'){
                    
                    $Arr[$v['level']][]     =   $v;
                }else if ($v['level'] == '3'){
                    
                    $Arr[$v['level']][]     =   $v;
                }
                
                
            }
            
            foreach ($Arr[2] as $k => $v) {
                foreach ($Arr[3] as $vv) {
                    if ($v['id'] == $vv['fid']){
                        $Arr[2][$k]['num'] += $vv['num'];
                        $Arr[2][$k]['part'][]   =   $vv;
                    }
                }
            }
            
            foreach ($Arr[1] as $k => $v) {
                foreach ($Arr[2] as $vv) {
                    if ($v['id'] == $vv['fid']){
                        $Arr[1][$k]['num'] += $vv['num'];
                        $Arr[1][$k]['part'][]   =   $vv;
                    }
                }
            }
            
            $orgList['orgArr']  =   $Arr[1];
        }
        
        return $orgList;
    }
    
    function configCrmOrg($data = array()){
        
        if (!empty($data)){
            
            $id         =   intval($data['id']);
            
            $puser      =   $this->select_all('admin_user', array('org' => $id), '`uid`');  //  部门成员
            
            if ($puser){
                
                $puids  =   array();
                
                foreach ($puser as $pv) {

                    $puids[]    =   $pv['uid'];
                }
                
                $this->update_once('admin_user', array('org' => ''), array('uid' => array('in', pylode(',', $puids))));
            }
            
            $result =   $this->update_once('admin_user', array('org' => $id), array('uid' => array('in', pylode(',', $data['uids']))));
            
            $code   =   $result ? 1 : 2;
            
        }else{
            
            $code   =   3;
        }
        
        return $code;
    }
    
    function delOrgUser($delId, $data=array()){

        if (empty($delId)) {

            $return     =   array( 'errcode' => 8, 'msg' => '请选择要删除的成员数据！');
        } else {

            if (is_array($delId)) {

                $delId  =   pylode(',', $delId);

                $return['layertype']    =   1;

            } else {

                $return['layertype']    =   0;
            }
             
            $result =   $this -> update_once('admin_user', array('org' => '', 'power' => '', 'spower' => ''), array('uid' => array('in', $delId)));

            $return['msg']      =   '部门成员';

            $return['errcode']  =   $result ? '9' : '8';

            $return['msg']      =   $result ? $return['msg'].'删除成功！' : $return['msg'].'删除失败！';
        }

        return $return;
    }
    
    function delOrg($delId){

        if (empty($delId)) {

            $return =   array( 'errcode' => 8, 'msg' => '参数错误，请重试！');
        } else {

            $return['layertype']    =   0;
            
            $org    =   $this -> select_once('crmorg', array('id' => $delId));
            
            $result =   $this -> delete_all('crmorg', array('id' => $delId), '');
            
            if ($result){
                
                $this -> update_once('admin_user', array('org' => '', 'power' => '', 'spower' => ''), array('org' => $delId));
                
                if ($org['level'] == '2'){
                    
                    $orgS   =   $this->select_all('crmorg', array('fid' => $delId), '`id`');
                    foreach ($orgS as $v) {
                        $oid[]  =   $v['id'];
                    }
                    $this->delete_all('crmorg', array('fid' => $delId), '');
                    $this->update_once('admin_user', array('org' => '', 'power' => '', 'spower' => ''), array('org' => array('in', pylode(',', $oid))));
                }
            }
            
            $return['msg']      =   'CRM部门';
            $return['org']      =   $result ? $org['fid'] : $delId;
            $return['errcode']  =   $result ? '9' : '8';
            $return['msg']      =   $result ? $return['msg'].'删除成功！' : $return['msg'].'删除失败！';
        }

        return $return;
    }

    function configCrmPower($uid = null, $data = array()){
        
        if ($uid!=null && !empty($data)) {
            
            $result =   $this->update_once('admin_user', $data, array('uid' => $uid));
            
            $code   =   $result ? 1 : 2;
        }else{
            $code   =   3;
        }
        
        return $code;
    }

    /**
     * @param $crmId
     * @return false|string
     */
    function getNotice($crmId)
    {

        $comList            =   $this->select_all('company', array('crm_uid' => $crmId), '`uid`,`f_time`,`rating`,`rating_name`,`vipstime`,`vipetime`');

        include PLUS_PATH.'comrating.cache.php';

        $ratingArr          =   array();
        foreach ($comrat as $k => $v) {
            $ratingArr[$v['id']]    =   $v['name'];
        }
        $ratingArr['999']   =   '过期会员';

        if (isset($comList) && !empty($comList)){

            $ids            =   array();
            foreach ($comList as $k1 => $v1){
                $ids[]      =   $v1['uid'];
            }

            $toFollowList   =   $this->select_all('crm_work_plan', array('uid' => $crmId, 'type' => '22', 'status' => '1', 'stime' => array('<', strtotime(date('Y-m-d 23:59:59'))), 'comid' => array('in', pylode(',', $ids))),'`comid`');
            $toFUids        =   array();
            foreach ($toFollowList as $toV) {
                $toFUids[$toV['comid']]  =   $toV['comid'];
            }

            //  今天需要跟进数量
            $todayFollowNum =   count($toFUids) > 0 ? count($toFUids) : 0;

            //  到期未续费
            $endWhere       =   array(
                'uid'               =>  array('in', pylode(',', $ids)),
                'PHPYUNBTWSTART_A'  =>  '',
                'vipetime'          =>  array(
                    '0' =>  array('>', '0', ''),
                    '1' =>  array('<', time(), '')
                ),
                'PHPYUNBTWEND_A' => ''
            );
            $vipedNum       =   $this->select_num('company', $endWhere);

            //  15天内到期客户
            $willWhere      =   array(
                'uid'               =>  array('in', pylode(',', $ids)),
                'PHPYUNBTWSTART_A'  =>  '',
                'vipetime'          =>  array(
                    '0' =>  array('>', time(), ''),
                    '1' =>  array('<', strtotime('+15 days'), '')
                ),
                'PHPYUNBTWEND_A' => ''
            );
            $willDoneNum    =   $this->select_num('company', $willWhere);

            //  从未跟进客户
            $noWhere        =   array(
                'uid'               =>  array('in', pylode(',', $ids)),
                'PHPYUNBTWSTART_A'  =>  '',
                'f_time'            =>  array('=', '', 'or'),
                'isfollow'          =>  array('=', '0', 'or'),
                'PHPYUNBTWEND_A'    =>  ''
            );
            $noFollowNum    =   $this->select_num('company', $noWhere);

            $html           =   '';
            //  CRM设置：X天未跟进，提醒跟进
            $followSet      =   $this->select_all('crmset', array('follow_day' => array('>', '0')));
            $followData     =   array();
            foreach ($followSet as $ck => $cv) {
                foreach ($comList as $k => $v) {

                    $v['rating']    =   $v['rating'] == '0'  ? '999' : $v['rating'];

                    if (in_array($v['rating'], @explode(',', $cv['rating'])) && $v['f_time'] < strtotime("-" . $cv['follow_day'] . " days")) {

                        $followData[$ratingArr[$v['rating']]]['num']++;
                        $followData[$ratingArr[$v['rating']]]['day'] = $cv['follow_day'];
                        $followData[$ratingArr[$v['rating']]]['rating'] = $v['rating'] == '999' ? '0' : $v['rating'];
                    }
                }
            }

            foreach ($followData as $fk => $fv) {

                $html .=    "<div class='sflist'>您有 <span style='color:#2D8CF0'>".$fv['num']."个</span> ".$fk."，超过<span style='color: #2D8CF0'> ".$fv['day']."天</span> 未跟进，需要您及时跟进哦<div class='crm_mytx_a'> <a href='index.php?m=crm_customer&self=1&rating=".$fv['rating']."&lastFtime=".$fv['day']."' >查看</a></div> </div>";
            }

            //  CRM设置：X天未跟进，释放提醒
            $releaseSet     =   $this->select_all('crmset', array('release_day' => array('>', '0')));
            $releaseData    =   array();
            foreach ($releaseSet as $ck => $cv) {
                foreach ($comList as $k => $v) {

                    $v['rating']    =   $v['rating'] == '0'  ? '999' : $v['rating'];


                    if (in_array($v['rating'], @explode(',', $cv['rating'])) && $v['f_time'] < strtotime("-" . $cv['release_day'] . " days")) {

                        $releaseData[$ratingArr[$v['rating']]]['num']++;
                        $releaseData[$ratingArr[$v['rating']]]['day'] = $cv['release_day'];
                        $releaseData[$ratingArr[$v['rating']]]['rating'] = $v['rating'] == '999' ? '0' : $v['rating'];
                    }
                }
            }

            foreach ($releaseData as $rk => $rv) {

                $html .=    "<div class='sflist'>您有 <span style='color:#2D8CF0'>".$rv['num']."个</span> ".$rk."，超过<span style='color:#2D8CF0'> ".$rv['day']."天</span> 未跟进，即将释放  <div class='crm_mytx_a'><a href='index.php?m=crm_customer&self=1&rating=".$rv['rating']."&lastFtime=".$rv['day']."'>查看</a></div> </div>";
            }

            //  CRM设置：X天会员未变更，释放提醒
            $dealSet        =   $this->select_all('crmset', array('deal_day' => array('>', '0')));
            $dealData       =   array();
            foreach ($dealSet as $ck => $cv) {
                foreach ($comList as $k => $v) {

                    $v['rating']    =   $v['rating'] == '0'  ? '999' : $v['rating'];

                    if($v['rating'] == '999' && in_array('999', @explode(',', $cv['rating']))){
                        if($v['vipetime'] < strtotime("-" . $cv['deal_day'] . " days")) {

                            $dealData[$ratingArr[$v['rating']]]['num']++;
                            $dealData[$ratingArr[$v['rating']]]['day'] = $cv['deal_day'];
                            $dealData[$ratingArr[$v['rating']]]['rating'] = '0';
                        }
                    }else if (in_array($v['rating'], @explode(',', $cv['rating']))){
                        if ($v['vipstime'] < strtotime("-" . $cv['deal_day'] . " days")){

                            $dealData[$ratingArr[$v['rating']]]['num']++;
                            $dealData[$ratingArr[$v['rating']]]['day'] = $cv['deal_day'];
                            $dealData[$ratingArr[$v['rating']]]['rating'] = $v['rating'];
                        }
                    }
                }
            }

            foreach ($dealData as $dk => $dv) {

                $html .=    "<div class='sflist'>您有 <span style='color:#2D8CF0'>".$dv['num']."个</span> ".$dk."，超过<span style='color:#2D8CF0'> ".$dv['day']."天</span> 未变更会员，即将释放 <div class='crm_mytx_a'><a href='index.php?m=crm_customer&self=1&rating=".$dv['rating']."&vipstime=".$dv['day']."'>查看</a></div></div>";
            }

            return json_encode(array('todayFollowNum' => $todayFollowNum, 'vipedNum' => (int)$vipedNum, 'willDoneNum' => (int)$willDoneNum, 'noFollowNum' => (int)$noFollowNum, 'html' => $html, 'followData' => $followData, 'releaseData' => $releaseData, 'dealData' => $dealData));
        }
    }

    function getMyCom($crmId){

        $comList            =   $this->select_all('company', array('crm_uid' => $crmId), '`uid`,`f_time`,`rating`,`rating_name`,`vipstime`,`vipetime`');
        include PLUS_PATH.'comrating.cache.php';

        $ratingArr          =   array();
        foreach ($comrat as $k => $v) {
            $ratingArr[$v['id']]    =   $v['name'];
        }
        $ratingArr['999']   =   '过期会员';

        if (isset($comList) && !empty($comList)){

            $ids            =   array();
            foreach ($comList as $k => $v){
                $ids[]      =   $v['uid'];
            }

            $toFollowList   =   $this->select_all('crm_work_plan', array('uid' => $crmId, 'type' => '22', 'status' => '1', 'stime' => array('<', strtotime(date('Y-m-d 23:59:59'))), 'comid' => array('in', pylode(',', $ids))),'`comid`');
            $toFUids        =   array();
            foreach ($toFollowList as $toV) {
                $toFUids[$toV['comid']]  =   $toV['comid'];
            }
            $html           =   '';

            //  今日需要跟进数量
            $todayNum       =   count($toFUids) > 0 ? count($toFUids) : 0;

            $html           .=  "<div class='sflist'>今天需要您立即跟进的客户有 <font color='red'>".$todayNum."</font> 位</div>";

            $followSet      =   $this->select_all('crmset', array('follow_day' => array('>', '0')));
            $followData     =   array();
            foreach ($followSet as $ck => $cv) {
                foreach ($comList as $k=> $v) {

                    $v['rating']    =   $v['rating'] == '0' ? '999' : $v['rating'];

                    if (in_array($v['rating'], @explode(',', $cv['rating'])) && $v['f_time'] < strtotime("-".$cv['follow_day']." days")){

                        $followData[$ratingArr[$v['rating']]]['num']++;
                        $followData[$ratingArr[$v['rating']]]['day'] =   $cv['follow_day'];
                    }
                }
            }

            foreach ($followData as $fk => $fv) {

                $html .=    "<div class='sflist'>您有 <span style='color:#2D8CF0'>".$fv['num']."个</span> ".$fk."，超过<span style='color: blue'> ".$fv['day']."天</span> 未跟进，需要您及时跟进哦</div>";
            }

            $releaseSet     =   $this->select_all('crmset', array('release_day' => array('>', '0')));
            $releaseData    =   array();
            foreach ($releaseSet as $ck => $cv) {
                foreach ($comList as $k=> $v) {

                    $v['rating']    =   $v['rating'] == '0' ? '999' : $v['rating'];

                    if (in_array($v['rating'], @explode(',', $cv['rating'])) && $v['f_time'] < strtotime("-".$cv['release_day']." days")){

                        $releaseData[$ratingArr[$v['rating']]]['num']++;
                        $releaseData[$ratingArr[$v['rating']]]['day']  =   $cv['release_day'];
                    }
                }
            }

            foreach ($releaseData as $rk => $rv) {

                $html .=    "<div class='sflist'>您有 <span style='color:#2D8CF0'>".$rv['num']."个</span> ".$rk."，超过<span style='color:#2D8CF0'> ".$rv['day']."天</span> 未跟进，即将释放</div>";
            }

            return json_encode(array('html' => $html));
        }
    }


    function getKhbList($time){

        $timeA  =   explode('-', $time);
        $month  =   (int)$timeA[1];

        $sTime  =   mktime(0, 0, 0, $month, 1, $timeA[0]);
        $eTime  =   mktime(23, 59, 59, $month+1, 0, $timeA[0]);

        $where  =   array(
            'crm_uid'           =>  array('>', 0),
            'PHPYUNBTWSTART_A'  =>  '',
            'crm_time'          =>  array(
                0   =>  array('>=', $sTime, ''),
                1   =>  array('<', $eTime, ''),
            ),
            'PHPYUNBTWEND_A'    =>  '',
            'groupby'           =>  'crm_uid',
            'orderby'           =>  'khnum, desc'
        );
        $khb    =   $this->select_all('company', $where, '`crm_uid`, count(`uid`) as khnum');

        $nWhere =   array(
            'crm_uid'           =>  array('>', 0),
            'PHPYUNBTWSTART_A'  =>  '',
            'crm_time'          =>  array(
                '0'   =>  array('>=', $sTime, ''),
                '1'   =>  array('<', $eTime, ''),
            ),
            'PHPYUNBTWEND_A'    =>  ''
        );
        $kbNUm  =   $this->select_num('company', $nWhere);

        if (!empty($khb)){

            $crmUids    =   array();
            foreach ($khb as $k => $v) {
                $crmUids[]  =   $v['crm_uid'];
            }

            $crmUsers   =   $this->select_all('admin_user', array('uid' => array('in', pylode(',', $crmUids))), '`name`,`uid`');

            foreach ($khb as $k => $v) {
                foreach ($crmUsers as $ck => $cv) {
                    if ($v['crm_uid'] ==   $cv['uid']){

                        $khb[$k]['name']    =   $cv['name'];
                        $khb[$k]['per']     =   round($v['khnum'] / $kbNUm * 100,2)."%";
                        $khb[$k]['url']     =   'index.php?m=crm_salesman_list&c=customer_list&auid='.$cv['uid'].'&crm_time='.$time;
                    }
                }
            }
        }

        $result['data']  = $khb;
        $result['total'] = $kbNUm;

        return  $result;

    }

    function getJebList($time){

        $timeA  =   explode('-', $time);
        $month  =   (int)$timeA[1];

        $sTime  =   mktime(0, 0, 0, $month, 1, $timeA[0]);
        $eTime  =   mktime(23, 59, 59, $month+1, 0, $timeA[0]);

        $where  =   array(
            'order_state'       =>  2,
            'PHPYUNBTWSTART_A'  =>  '',
            'order_time'        =>  array(
                '0' =>  array('>=', $sTime, ''),
                '1' =>  array('<', $eTime, '')
            ),
            'PHPYUNBTWEND_A'    =>  '',
            'groupby'           =>  'crm_uid',
            'orderby'           =>  'total, desc'
        );

        $jeb    =   $this->select_all('company_order', $where, '`crm_uid`, sum(`order_price`) as total');

        $nWhere =   array(
            'order_state'       =>  2,
            'PHPYUNBTWSTART_A'  =>  '',
            'order_time'        =>  array(
                '0' =>  array('>=', $sTime, ''),
                '1' =>  array('<', $eTime, '')
            ),
            'PHPYUNBTWEND_A'    =>  ''
        );
        $jeArr  =   $this->select_all('company_order', $nWhere, 'sum(`order_price`) as total');
        if (!empty($jeb)){

            $crmUids    =   array();
            foreach ($jeb as $k => $v) {
                if ($v['crm_uid'] > 0){
                    $crmUids[]  =   $v['crm_uid'];
                }
            }

            $crmUsers   =   $this->select_all('admin_user', array('uid' => array('in', pylode(',', $crmUids))), '`name`,`uid`');
            foreach ($jeb as $k => $v) {
                if ($v['crm_uid'] > 0) {
                    foreach ($crmUsers as $ck => $cv) {
                        if ($v['crm_uid'] == $cv['uid']) {

                            $jeb[$k]['name'] = $cv['name'];
                            $jeb[$k]['per'] = round($v['total'] / $jeArr[0]['total'] * 100, 2) . "%";
                            $jeb[$k]['url'] = 'index.php?m=crm_statis&c=amount&uid=' . $cv['uid'] . '&stime=' . date('Y-m-01') . '&etime=' . date('Y-m-d');
                        }
                    }
                }else{

                    $jeb[$k]['name']    =   '系统';
                    $jeb[$k]['per']     =   round($v['total'] / $jeArr[0]['total'] * 100,2)."%";
                    $jeb[$k]['url']     =   'index.php?m=crm_audit&stime='.date('Y-m-01').'&etime='.date('Y-m-d');
                }
            }
        }
        $result['data']  = $jeb;
        $result['total'] = isset($jeArr[0]['total']) ? $jeArr[0]['total'] : 0;

        return  $result;
    }

    /**
     * @desc CRM - 数据看板
     * @param array $where
     * @return array|bool|false|string|void
     */
    function getCrmList($where = array())
    {

        $rows   =   $this->select_all('admin_user', $where);

        if (!empty($rows)){

            $allKh      =   $this->select_all('company', array('crm_uid' => array('>', 0)), '`crm_uid`');
            $newList    =   $this->select_all('member', array('usertype' => 2, 'reg_date' => array('>', strtotime(date('Y-m-d')))), '`uid`');

            $newUids    =   array();
            foreach ($newList as $nk=>$nv) {
                $newUids[]  =   $nv['uid'];
            }
            $newKh      =   $this->select_all('company', array('crm_uid' => array('>', 0), 'uid' => array('in', pylode(',', $newUids))), '`crm_uid`');

            $newFollow  =   $this->select_all('company', array('crm_uid' => array('>', 0), 'f_time' => array('>', strtotime(date('Y-m-d')))),'`crm_uid`');

            $willWhere  =   array(
                'crm_uid' => array('>', 0),
                'PHPYUNBTWSTART_A'  =>  '',
                'vipetime' => array(
                    '0'   =>  array('<', strtotime('+15 days'), 'and'),
                    '1'   =>  array('>', time(), 'and'),
                ),
                'PHPYUNBTWEND_A'  =>  ''
            );
            $willDoneKh =   $this->select_all('company', $willWhere, '`crm_uid`');
            $recentFollowKh =   $this->select_all('company', array('crm_uid' => array('>', 0), 'f_time' => array('>', strtotime('-7 days'))), '`crm_uid`');

            $vipWhere   =   array(
                'crm_uid'           =>  array('>', 0),
                'PHPYUNBTWSTART_A'  =>  '',
                'rating'    => array(
                    '0' =>  array('>', 0),
                    '1' =>  array('<>', $this->config['sy_free_id'])
                ),
                'PHPYUNBTWEND_A'  =>  ''
            );
            $vipKh  =   $this->select_all('company', $vipWhere, '`crm_uid`');

            $freeKh =   $this->select_all('company', array('crm_uid' => array('>', 0), 'rating' => $this->config['sy_free_id']), '`crm_uid`');

            $vipDoneWhere   =   array(
                'crm_uid'           =>  array('>', 0),
                'PHPYUNBTWSTART_A'  =>  '',
                'vipetime'    => array(
                    '0' =>  array('>', 0, ''),
                    '1' =>  array('<', time(), '')
                ),
                'PHPYUNBTWEND_A'  =>  ''
            );

            $vipDoneKh =   $this->select_all('company', $vipDoneWhere);

            foreach ($rows as $k => $v) {

                $rows[$k]['allNum']             =   0;
                $rows[$k]['newNum']             =   0;
                $rows[$k]['newFollowNum']       =   0;
                $rows[$k]['willDoneNum']        =   0;
                $rows[$k]['recentFollowNum']    =   0;
                $rows[$k]['vipNum']             =   0;
                $rows[$k]['freeNum']            =   0;
                $rows[$k]['vipDoneNum']         =   0;

                foreach ($allKh as $val){
                    if ($v['uid'] == $val['crm_uid']){
                        $rows[$k]['allNum']++;
                    }
                }
                foreach ($newKh as $val){
                    if ($v['uid'] == $val['crm_uid']){
                        $rows[$k]['newNum']++;
                    }
                }
                foreach ($newFollow as $val){
                    if ($v['uid'] == $val['crm_uid']){
                        $rows[$k]['newFollowNum']++;
                    }
                }
                foreach ($willDoneKh as $val){
                    if ($v['uid'] == $val['crm_uid']){
                        $rows[$k]['willDoneNum']++;
                    }
                }
                foreach ($recentFollowKh as $val){
                    if ($v['uid'] == $val['crm_uid']){
                        $rows[$k]['recentFollowNum']++;
                    }
                }
                foreach ($vipKh as $val){
                    if ($v['uid'] == $val['crm_uid']){
                        $rows[$k]['vipNum']++;
                    }
                }
                foreach ($freeKh as $val){
                    if ($v['uid'] == $val['crm_uid']){
                        $rows[$k]['freeNum']++;
                    }
                }
                foreach ($vipDoneKh as $val){
                    if ($v['uid'] == $val['crm_uid']){

                        $rows[$k]['vipDoneNum']++;
                    }
                }
            }
        }

        return $rows;
    }

    function getManageData()
    {

        $allNum     =   $this->select_num('company');
        $newNum     =   $this->select_num('member', array('usertype' => 2, 'reg_date' => array('>', strtotime(date('Y-m-d')))));

        $crmNum     =   $this->select_num('company', array('crm_uid' => array('>', 0)));
        $noCrmNum   =   $this->select_num('company', array('crm_uid' => 0));

        $orderAllPrice  =   $this->select_once('company_order', array('order_price' => array('>', '0'), 'order_state' => 2, 'crm_uid' => array('>', 0)), 'sum(`order_price`) as `pricesum`');
        if (floatval($orderAllPrice['pricesum']) > 0) {
            $allPrice   =   floatval($orderAllPrice['pricesum']);
        }

        $orderNewPrice  =   $this->select_once('company_order', array('order_price' => array('>', '0'), 'order_state' => 2, 'crm_uid' => array('>', 0), 'order_time' => array('>', strtotime(date('Y-m-d')))), 'sum(`order_price`) as `pricesum`');
        if (floatval($orderNewPrice['pricesum']) > 0) {
            $newPrice   =   floatval($orderNewPrice['pricesum']);
        }

        $newFollow = $this->select_num('crmnew_concern', array('ftime' => array('>', strtotime(date('Y-m-d')))));


        //  15天内到期客户
        $willWhere      =   array(

            'PHPYUNBTWSTART_A'  =>  '',
            'vipetime'          =>  array(
                '0' =>  array('>', time(), ''),
                '1' =>  array('<', strtotime('+15 days'), '')
            ),
            'PHPYUNBTWEND_A' => ''
        );
        $willDone   =   $this->select_num('company', $willWhere);

        //  到期未续费
        $endWhere       =   array(
            'PHPYUNBTWSTART_A'  =>  '',
            'vipetime'          =>  array(
                '0' =>  array('>', '0', ''),
                '1' =>  array('<', time(), '')
            ),
            'PHPYUNBTWEND_A' => ''
        );
        $vipDone        =   $this->select_num('company', $endWhere);


        //  30天未跟进
        $needFollow     =   $this->select_num('company', array('isfollow' => 1,'f_time' => array('<' , strtotime('-30 days'))));

        //  从未跟进
        $noFollow       =   $this->select_num('company', array('isfollow' => '0'));


        $arr    =   array(
            'allNum'    =>  $allNum,
            'newNum'    =>  $newNum,
            'crmNum'    =>  $crmNum,
            'noCrmNum'  =>  $noCrmNum,
            'allPrice'  =>  $allPrice,
            'newPrice'  =>  $newPrice,
            'newFollow' =>  $newFollow,

            'willDone'  =>  $willDone,
            'vipDone'   =>  $vipDone,
            'needFollow'=>  $needFollow,
            'noFollow'  =>  $noFollow
        );

        return  $arr;
    }

    function getStatisData($data = array())
    {

        $timeBegin  =   $data['timeBegin'];
        $timeEnd    =   $data['timeEnd'];

        if (!empty($data['timeBegin'])){
            $allWhere   =   array(
                'crm_uid'       => array('>', 0),
                'PHPYUNBTWSTART_A' =>  '',
                'crm_time'      =>  array(
                    0   =>  array('>=', $timeBegin, ''),
                    1   =>  array('<=', $timeEnd, '')
                ),
                'PHPYUNBTWEND_A'   =>  ''
            );
        }else{
            $allWhere   =   array('crm_uid' => array('>', 0));
        }
        $allNum     =   $this->select_num('company', $allWhere);

        if (!empty($data['timeBegin'])) {
            $concernWhere = array(
                'crm_uid' => array('>', 0),
                'isfollow' => '0'
            );
        }else{
            $concernWhere   =   array('crm_uid' => array('>', 0), 'isfollow' => '0');
        }

        $concernNum =   $this->select_num('company', $concernWhere);

        if (!empty($data['timeBegin'])) {
            $concernedWhere = array(
                'crm_uid' => array('>', 0),
                'isfollow' => '1',
                'PHPYUNBTWSTART_A' => '',
                'f_time' => array(
                    0 => array('>=', $timeBegin, ''),
                    1 => array('<=', $timeEnd, '')
                ),
                'PHPYUNBTWEND_A' => ''
            );
        }else{
            $concernedWhere =   array('crm_uid' => array('>', 0), 'isfollow' => '1');
        }
        $concernedNum =   $this->select_num('company', $concernedWhere);

        if (!empty($timeBegin)) {

            $endT           =   mktime(23, 59, 59, date('m'), date('d'), date('Y'));
            if ($timeBegin == $endT || $timeEnd <= $endT){

                $vitWhere   =   array(
                    'type'      =>  22,
                    'status'    =>  1,
                    'PHPYUNBTWSTART_A' => '',
                    'stime' => array(
                        0 => array('<=', $timeEnd, ''),
                        1 => array('isnull','','OR')
                    ),
                    'PHPYUNBTWEND_A' => ''
                );
            }else{

                $vitWhere   =   array(
                    'type'      =>  22,
                    'status'    =>  1,
                    'PHPYUNBTWSTART_A' => '',
                    'stime' => array(
                        0 => array('>=', $timeBegin, ''),
                        1 => array('<=', $timeEnd, '')
                    ),
                    'PHPYUNBTWEND_A' => ''
                );
            }
        }else{

            $vitWhere =   array('type' => 22, 'status' => 1);
        }
        $visitNum   =   $this->select_num('crm_work_plan', $vitWhere);

        if (!empty($timeBegin)) {
            $orderWhere = array(
                'crm_uid' => array('>', 0),
                'order_state' => 2,
                'PHPYUNBTWSTART_A' => '',
                'order_time' => array(
                    0 => array('>=', $timeBegin, ''),
                    1 => array('<=', $timeEnd, '')
                ),
                'PHPYUNBTWEND_A' => ''
            );
        }else{
            $orderWhere =   array( 'crm_uid' => array('>', 0), 'order_state' => 2);
        }
        $orderNum   =   $this->select_num('company_order', $orderWhere);

        $orderPrice =   $this->select_once('company_order', $orderWhere, 'sum(`order_price`) as `pricesum`');

        $arr        =   array(
            'allNum'        =>  $allNum,
            'concernNum'    =>  $concernNum,
            'concernedNum'  =>  $concernedNum,
            'visitNum'      =>  $visitNum,
            'orderNum'      =>  $orderNum,
            'orderPrice'    =>  $orderPrice['pricesum']
        );

        return  $arr;
    }

}
?>