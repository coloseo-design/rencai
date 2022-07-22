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

class ad_controller extends company
{
    /*
    查看购买广告位页面
    **/
    function index_action()
    {
        $this->public_action();
        $this->company_satic();

        $adM    =   $this->MODEL('ad');
        $rows   =   $adM->getAdClassList(array('type' => '1'));

        $this->yunset("rows", $rows['list']);
        $this->com_tpl('ad');
    }
    /*
    新增购买广告位页面
    **/
    function adinfo_action()
    {
        if ($_GET['id']) {

            $adM    =   $this->MODEL('ad');
            $row    =   $adM->getAdClassInfo(array('id' => (int)$_GET['id'], 'type' => '1'));
            if ($row['id']) {

                $this->public_action();
                $this->company_satic();
                $this->yunset("row", $row);
                $this->com_tpl('buyad');
            } else {

                $this->ACT_msg("index.php?c=ad", "非法操作！");
            }
        }
    }
}

?>