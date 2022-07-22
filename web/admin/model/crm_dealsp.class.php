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

class crm_dealsp_controller extends adminCommon
{

    function index_action()
    {

        $orderM =   $this->MODEL('companyorder');

        $where  =   $urlarr =   array();

        $where['crm_uid']       =   array('<>', '');
        $where['order_state']   =   3;

        if (isset($_GET['order_id']) && !empty($_GET['order_id'])) {

            $where['order_id']  =   trim($_GET['order_id']);
            $urlarr['order_id'] =   $_GET['order_id'];
        }

        if (isset($_GET['comname']) && !empty($_GET['comname'])){

            $comList    =   $this->obj->select_all('company', array('like', $_GET['comname']),'`uid`');

            if (!empty($comList)){
                $comIds =   array();
                foreach ($comIds as $v) {

                    $comIds[$v['uid']]  =   $v['uid'];
                }

                $where['uid']   =   array('in', pylode(',', $comIds));
            }
        }
        $urlarr        	=   $_GET;
        $urlarr['page'] =   "{{page}}";
        $pageurl        =   Url($_GET['m'], $urlarr, 'admin');

        $pageM          =   $this->MODEL('page');
        $pages          =   $pageM->pageList('company_order', $where, $pageurl, $_GET['page']);

        if ($pages['total'] > 0) {

            if ($_GET['order']) {

                $where['orderby']   =   $_GET['t'] . ',' . $_GET['order'];
                $urlarr['order']    =   $_GET['order'];
                $urlarr['t']        =   $_GET['t'];
            } else {

                $where['orderby']   =   array('order_state, ASC', 'id, DESC');
            }

            $where['limit']         =   $pages['limit'];
            $orders                 =   $orderM->getList($where, array('utype' => 'crmdealsp'));
        }

        $ratingM    =   $this->MODEL('rating');
        $ratingList =   $ratingM->getList(array('category' => '1'), array('field' => '`id`,`name`'));

        $cacheM     =   $this->MODEL('cache');
        $cache      =   $cacheM->GetCache(array('crm'));

        $this->yunset(array('orders' => $orders, 'ratinglist' => $ratingList, 'cache' => $cache));
        $this->yuntpl(array('admin/crm_dealsp_list'));
    }

    /**
     * @desc 审批订单详细
     */
    function getOrderInfo_action()
    {

        $orderM     =   $this->MODEL('companyorder');

        $id         =   $_GET['id'];
        $orderInfo  =   $orderM->getInfo(array('id' => $id));

        $adminM     =   $this->MODEL('admin');
        $auser      =   $adminM->getAdminUser(array('uid' => $orderInfo['crm_uid']));

        $ratingM    =   $this->MODEL('rating');
        $ratingArr  =   $ratingM->getInfo(array('id' => $orderInfo['rating']), array('field' => '`id`,`name`'));

        $this->yunset(array('orderInfo' => $orderInfo, 'aname' => $auser['name'], 'ratingName' => $ratingArr['name']));
        $this->yuntpl(array('admin/crm_order_info'));
    }

    /**
     * @desc 确认订单，收款
     */
    function spDeal_action()
    {

        $this->check_token();
        $id     =   intval($_GET['id']);
        $OrderM =   $this->MODEL('companyorder');
        $return =   $OrderM->setPay($id);
        $this->layer_msg($return['msg'], $return['errcode'], 0, $_SERVER['HTTP_REFERER']);
    }

    /**
     * @desc 订单删除
     */
    function del_action()
    {
        $this -> check_token();

        $OrderM		=	$this -> MODEL('companyorder');
        $delID		=	is_array($_GET['del']) ? $_GET['del'] : $_GET['id'];

        $return     =   $OrderM->del($delID, array('utype' => 'admin'));
        $this -> layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
    }

    function getOrders_action(){

        $orderM =   $this->MODEL('companyorder');

        $where  =   $urlarr =   array();


        $where['PHPYUNBTWSTART_A']  =   '';
        $where['crm_uid'][]         =   array('=', 0, '');
        $where['crm_uid'][]         =   array('isnull', '', 'or');
        $where['PHPYUNBTWEND_A']    =   '';

        $where['usertype']      =   2;
        $where['order_state']   =   2;

        if (isset($_GET['order_id']) && !empty($_GET['order_id'])) {

            $where['order_id']  =   trim($_GET['order_id']);
            $urlarr['order_id'] =   $_GET['order_id'];
        }

        if (isset($_GET['comname']) && !empty($_GET['comname'])){

            $comList    =   $this->obj->select_all('company', array('name' => array('like', $_GET['comname'])),'`uid`');

            if (!empty($comList)){
                $comIds =   array();
                foreach ($comList as $v) {

                    $comIds[$v['uid']]  =   $v['uid'];
                }

                $where['uid']   =   array('in', pylode(',', $comIds));
            }
        }
        $urlarr        	=   $_GET;
        $urlarr['page'] =   "{{page}}";
        $urlarr['c']    =   "getOrders";

        $pageurl        =   Url($_GET['m'], $urlarr, 'admin');

        $pageM          =   $this->MODEL('page');
        $pages          =   $pageM->pageList('company_order', $where, $pageurl, $_GET['page']);

        if ($pages['total'] > 0) {

            if (isset($_GET['order'])) {

                $where['orderby']   =   $_GET['t'] . ',' . $_GET['order'];
                $urlarr['order']    =   $_GET['order'];
                $urlarr['t']        =   $_GET['t'];
            } else {

                $where['orderby']   =   array('order_state, ASC', 'id, DESC');
            }

            $where['limit']         =   $pages['limit'];
            $orders                 =   $orderM->getList($where, array('utype' => 'crmdealfp'));
            $this->yunset(array('orders' => $orders));
        }

        $adminM             =   $this->MODEL('admin');
        $GwInfo             =   $adminM -> getList(array('is_crm' => 1));
        $this -> yunset('GwInfo',$GwInfo);

        $this->yuntpl(array('admin/crm_dealfp_list'));
    }

    function setCrm_action()
    {

        $orderM     =   $this->MODEL('companyorder');
        $adminM     =   $this->MODEL('admin');

        $gid        =   intval($_POST['gid']);
        $oid        =   trim($_POST['oid']);

        $crmUser    =   $adminM->getAdminUser(array( 'uid' => $gid ));

        if (! is_array($crmUser)) {
            $this -> ACT_layer_msg('请选择业务员！', 8, $_SERVER['HTTP_REFERER']);
        }

        $return     =   $orderM->setCrm(array('crm_uid' => $gid), array('id' => $oid));

        $this->ACT_layer_msg($return['msg'], $return['errcode'], $_SERVER['HTTP_REFERER'], 2, 1);
    }
}

?>