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
class child_controller extends company
{

    /**
     * @desc 子账号列表
     * 2019-06-28
     */
    public function index_action()
    {
        
        // 企业账号通用信息
        $this   ->  public_action();
        $this   ->  company_satic();
       
        $comaM          =   $this -> MODEL('companyaccount');
  
        $where          =   array('comid' => $this -> uid);
        
        $urlarr         =   array('c' => 'child', 'page' => '{{page}}');

        $pageurl        =   Url('member', $urlarr);

        $pageM          =   $this -> MODEL('page');
        
        $pages          =   $pageM -> pageList('company_account', $where, $pageurl, $_GET['page']);
        
        // 子账号列表
        if ($pages['total'] > 0) {
            
            $where['orderby']   =   'uid';
            $where['limit']     =   $pages['limit'];
            $rows               =   $comaM -> getWorkList($where);
        }
       
        $this -> yunset('totalNum', $pages['total']);
        $this -> yunset('rows', $rows);
        $this -> com_tpl('child');
    }

    /**
     * @desc 添加 修改子账号
     * 2019-06-28
     */
    public function editSave_action()
    {
        $_POST  =   $this -> post_trim($_POST);
        $rurl   =   'index.php?c=child';

        // 参数判断
        if (empty($this->uid)) {
            
            $this -> ACT_layer_msg('非法操作！', 8, $rurl);
        }
        if (empty($_POST['submit'])) {
            
            $this -> ACT_layer_msg('参数错误！', 8, $rurl);
        }
        
        $memberM    =   $this -> MODEL('userinfo');
        $cuid       =   intval($_POST['cuid']);
        

        unset($_POST['submit']);
        unset($_POST['cuid']);
        
        if (empty($cuid)) {
            
            $res    =   $memberM -> addChildInfo(array('uid' => $this->uid, 'cdata' => $_POST, 'paytype' => 'vip'));
        } else {
            
            $res    =   $memberM -> updChildInfo(array('uid' => $cuid), $_POST);
        }

        // 返回值
        if ($res['ecode'] == 9) {
            
            $this->ACT_layer_msg($res['msg'], 9, $rurl);
        } else {
            
            $this->ACT_layer_msg($res['msg'], 8);
        }
    }

    /**
     * 绑定 解绑子账号
     * 2019-06-28
     */
    public function del_action()
    {
        $_POST  =   $this -> post_trim($_POST);

        $comaM  =   $this -> MODEL('companyaccount');

        $res    =   $comaM -> delChild(array('pid' => $this->uid, 'uid' => $_POST['uid']));

        echo json_encode($res);
        
        die();
    }

    /**
     * 分配套餐，获取目前的套餐
     */
    public function getstatis_action()
    {
        $cuid   =   intval($_POST['uid']);
        
        if (empty($cuid)) {
            
            echo json_encode(array('ecode' => 8, 'msg' => '参数错误'));
            die();
        }
        $inids  =   $this->uid.','. $cuid;

        $statisM    =   $this -> MODEL('statis');
        $statisList =   $statisM -> getList(array('uid' => array('in', $inids)));
        
        if (empty($statisList)) {
            
            echo json_encode(array('ecode' => 8, 'msg' => '主账号套餐不存在'));
            die();
        }

        $fatherS    =   $sonS   =   array();
        
        foreach ($statisList as $sv) {
        
            if ($sv['uid'] == $this->uid) {
            
                $fatherS    =   $sv;
            } elseif ($sv['uid'] == $cuid) {
                
                $sonS       =   $sv;
            }
        }
        
        $res    = array('fathers' => $fatherS,'sons' => $sonS);
        
        echo json_encode(array('ecode' => 9, 'msg' => 'ok', 'data' => $res));
        die();
    }

    /**
     * 保存分配的套餐
     * 2019-07-01
     */
    public function assignsave_action()
    {
        $_POST  =   $this->post_trim($_POST);
        
        $rurl   =   'index.php?c=child';

        if (empty($this->uid)) {
            $this -> ACT_layer_msg('请重新登录！', 8, $rurl);
        }

        // 参数判断
        if (empty($_POST['submit'])) {
            
            $this -> ACT_layer_msg('参数错误！', 8, $rurl);
        }
        
        $cuid   =   intval($_POST['cuid']);
        
        if (empty($cuid)) {
            
            $this -> ACT_layer_msg('非法操作！', 8, $rurl);
        }
        
        unset($_POST['submit']);
        unset($_POST['cuid']);

        $_POST['uid']   =   $this->uid;
        $_POST['spid']  =   $cuid;
        
        $statisM        =   $this->MODEL('statis');
        $res            =   $statisM->assignChildStatis($_POST);

        // 返回值
        if ($res['ecode'] == 9) {
            
            $this->ACT_layer_msg($res['msg'], 9, $rurl);
        } else {
            
            $this->ACT_layer_msg($res['msg'], 8);
        }
    }

    /**
     * @desc 创建 / 激活 子账号判断
     */
    function checkStatis_action()
    {
        if (empty($this->uid)) {
            
            echo json_encode(array('ecode' => 8, 'msg' => '非法操作！'));
            die();
        }

        // 检查是否可以套餐足够
        $statisM    =   $this -> MODEL('statis');
        $res        =   $statisM -> getItemUseCondition(array('uid' => $this->uid, 'spid' => $_GET['spid'], 'item' => 'sons_num'));
              
        echo json_encode($res);
        die();
    }
}
?>