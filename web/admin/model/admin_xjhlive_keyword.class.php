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
class admin_xjhlive_keyword_controller extends adminCommon
{
    function index_action(){
        
        $where['id']	=	array('>',0);
        
        if ($_GET['keyword']) {
            
            $keyword            =   trim($_GET['keyword']);
            
            $where['name']     =   array('like', $keyword);
            
            $urlarr['keyword']  =   $keyword;
        }
        $urlarr        	=   $_GET;
        $urlarr['page']	=	'{{page}}';
        
        $urlarr['c']	=	$_GET['c'];
        
        $pageurl	=	Url($_GET['m'], $urlarr, 'admin');
        
        $pageM	=	$this->MODEL('page');
        
        $pages	=	$pageM->pageList('xjhlive_keyword', $where, $pageurl, $_GET['page']);
        
        if ($pages['total'] > 0) {
            
            $where['orderby']	=	'id,desc';
            
            $where['limit']		=	$pages['limit'];
            
            $xjhM  =  $this -> MODEL('xjhlive');
            $rows  =  $xjhM -> getXjhkeywordList($where,array('utype'=>'admin'));
            
            $this->yunset('rows', $rows);
        }
        
        $this->yuntpl(array('admin/admin_xjhlive_keyword'));
    }
    
    function add_action(){
        
        $_POST	   =  $this->post_trim($_POST);
        $position  =  explode('-', $_POST['name']);
        
        $name  =  array_unique($position);
        
        $xjhM  =  $this->MODEL('xjhlive');
        
        $result  =  $xjhM -> addXjhkeyword($name);
        if($result['errcode']==9){
            $msg = 2;
        }else if($result['code']==7){
            $msg = 1;
        }else{
            $msg = 3;
        }
        
        echo $msg;die;
    }
    
    function del_action(){
        
        if($_GET['id']){
            
            $delID   =  $_GET['id'];
            
        }else{
            
            $delID   =  $_POST['del'];
        }
        
        $xjhM    =  $this -> MODEL('xjhlive');
        $return  =  $xjhM -> delXjhkeyword($delID,array('utype'=>'admin'));
        
        $this -> layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
    }
}
?>