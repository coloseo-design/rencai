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
class admin_gqbrower_controller extends adminCommon{

    private  function set_search(){

        $search_list[]                  =       array('param'=>'ctime','name'=>'浏览时间','value'=>array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月'));
        
        $this->yunset("search_list", $search_list);
    }
    
    /**
     * @desc 后台供求任务 -- 浏览记录
     */

    function index_action(){

        $this->set_search();

        $gqdemandM    			        =  		$this -> MODEL('gqdemand');
        //查询时间
        if ($_GET['ctime']) {
	        
	        $ctime                      =       intval($_GET['ctime']);
	        
	        if($ctime == 1){
	        
                $where['ctime']         =       array('>',strtotime(date("Y-m-d 00:00:00")));
	        
	        }else {
                $where['ctime']		    =	    array('>',strtotime('-'.$ctime.'day'));	            
	        }
	        
	        $urlarr['ctime']            =       $ctime;
	        
        }

        //根据条件查询

        $typeStr                        =       intval($_GET['type']);

        $keywordStr                     =       trim($_GET['keyword']);
        
        if (!empty($keywordStr)) {
            
            if ($typeStr == 2) {
                
                $mwhere['name']          =       array('like',$keywordStr);

                $gqfbz                   =       $gqdemandM->getGqinfoList($mwhere,array('field'=>'`uid`','type'=>1));

                foreach($gqfbz as $v){
	                
	                $guids[]	         =	    $v['uid'];
	                
                }
                
                $where['gq_id']          =     array('in',pylode(',',$guids));
                               
            } else{
                
                $mwhere['name']         =       array('like',$keywordStr);

                $task                   =       $gqdemandM->getGqtaskList($mwhere,array('field'=>'`id`','type'=>1));
                
                foreach($task as $v){
	                
	                $taskuids[]	        =	    $v['id'];
	                
                }
                
                $where['task_id']       =       array('in',pylode(',',$taskuids));
                
            }
            $urlarr['type']             =       $typeStr;

            $urlarr['keyword']          =       $keywordStr;
        }
        
        //分页链接
		$urlarr        					=   	$_GET;
        $urlarr['page']	                =	   '{{page}}';
        
        $pageurl		                =	    Url($_GET['m'],$urlarr,'admin');
        
        //提取分页
        $pageM			                =	    $this  -> MODEL('page');

        $pages			                =	    $pageM -> pageList('gq_browse',$where,$pageurl,$_GET['page']);
        
        //分页数大于0的情况下 执行列表查询
        if($pages['total'] > 0){
            
            //limit order 只有在列表查询时才需要
            if($_GET['order']){
                
                $where['orderby']		=	    $_GET['t'].','.$_GET['order'];

                $urlarr['order']		=	    $_GET['order'];

                $urlarr['t']			=	    $_GET['t'];
                
            }else{
                
                $where['orderby']		=	    array('id,desc');
                
            }
            
            $where['limit']				=	    $pages['limit'];
            
            $rows                       =       $gqdemandM->gqbrowseList($where,array('field'=>'`uid`,`id`,`gq_id`,`ctime`,`task_id`'));

            $this -> yunset('rows',$rows);
            
        }
        
        $this->yuntpl(array('admin/admin_gqbrower'));
        
    }

    /**
     * @desc  删除供求浏览记录
     */
    function delgqbrower_action(){
        
        $gqdemandM    			    =  		$this -> MODEL('gqdemand');

        $this->check_token();
        
        if(is_array($_GET['del'])){
            
            $id                     =       $_GET['del'];
            
        }else{
            
            $id                     =       intval($_GET['del']);
            
        }
        
        $arr                        =       $gqdemandM -> delbrower($id,array('utype'=>'admin'));
        
        $this ->  layer_msg($arr['msg'], $arr['errcode'], $arr['layertype'],$_SERVER['HTTP_REFERER']);
        
    }
    
}
?>