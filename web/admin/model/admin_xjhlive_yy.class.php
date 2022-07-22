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
class admin_xjhlive_yy_controller extends adminCommon
{
	function index_action(){
		
		$xjhM  = $this->MODEL('xjhlive');
		
		$where          =   array();
		
        if($_GET['keyword']){
        
            $keyword    =   trim($_GET['keyword']);
        
            $type       =   intval($_GET['type']);
        
            if ($type=='1'){
				
                $where['uid']     =   $keyword;
				
            }else if($type=='2'){
				
				$xjh	=	$xjhM -> getList(array('name'=>array('like',$keyword)),array('field'=>'id'));
                
				foreach($xjh as $key=>$val){
					
					$ids[]	=	$val['id'];
				}
				
				$where['id']     =   array('in',pylode(',',$ids));
            }

            $urlarr['type']         =   "".$type."";
            
            $urlarr['keyword']      =   "".$keyword."";
        }
		$urlarr        	=   $_GET;
        $urlarr['page'] = '{{page}}';
		
		$urlarr['c'] = $_GET['c'];
		
        $pageurl = Url($_GET['m'], $urlarr, 'admin');

        // 提取分页
        $pageM = $this->MODEL('page');
        

        $pages = $pageM->pageList('xjhlive_yy', $where, $pageurl, $_GET['page']);

        // 分页数大于0的情况下 执行列表查询

        if ($pages['total'] > 0) {
            // limit order 只有在列表查询时才需要
            if ($_GET['order']) {

                $where['orderby']   =   $_GET['t'] . ',' . $_GET['order'];
                $urlarr['order']    =   $_GET['order'];
                $urlarr['t']        =   $_GET['t'];
                
            } else {

                $where['orderby']   =   array('ctime,desc','id,desc');
                
            }
            
            $where['limit']         =   $pages['limit'];
            
            $rows   =   $xjhM -> getyyList($where);

            $this->yunset('rows', $rows);
        }

        $this->yuntpl(array('admin/admin_xjhlive_yy'));
	}
	
	function del_action()
    {
        $this->check_token();

        $xjhM  =   $this -> Model('xjhlive');

		if($_GET['del']){
			$return =   $xjhM -> delyy($_GET['del'],array('utype'=>'admin'));
			
			$this->layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
		}else{
			$this->layer_msg("请选择您要删除的信息！",8,1,$_SERVER['HTTP_REFERER']);
		}
    }
}
?>