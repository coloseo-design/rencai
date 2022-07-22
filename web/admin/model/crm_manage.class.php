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

class crm_manage_controller extends adminCommon
{

    function index_action()
    {

        $crmM   =   $this->MODEL('crm');

        $where['PHPYUNBTWSTART_A']  =   '';
        $where['did'][]             =   array('=', 0, '');
        $where['did'][]             =   array('isnull', '', 'or');
        $where['PHPYUNBTWEND_A']    =   '';

        $where['is_crm']        =   1;

        if (isset($_GET['order']) && isset($_GET['t'])) {

            $where['orderby']   =   $_GET['t'].','.$_GET['order'];
            $urlarr['order']    =   $_GET['order'];
            $urlarr['t']        =   $_GET['t'];
        } else {

            $where['orderby']   =   array('uid,desc');
        }

        $rows   =   $crmM->getCrmList($where);
        $this->yunset(array('rows' => $rows));
        $this->yuntpl(array('admin/crm_manage'));
    }


    function getData_action()
    {


        $crmM   =   $this->MODEL('crm');

        $return =   $crmM->getManageData();

        echo json_encode($return);
        die();
    }


}

?>