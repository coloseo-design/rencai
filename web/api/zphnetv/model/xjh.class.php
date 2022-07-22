<?php
/* *
* $Author ：PHPYUN开发团队
*
* 官网: http://www.phpyun.com
*
* 版权所有 2009-2021 宿迁鑫潮信息技术有限公司，并保留所有权利。
*
* 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
*/
class xjh_controller extends zphnetv_controller{
    /**
     * 直播开启、关闭通知，修改状态
     */
    function livetz_action(){
        
        $post  =  str_replace('“','"',stripslashes($_POST['postdata']));
        
        $patterns     = array("｛", "｝");
        $replacements = array("{", "}");
        
        $post  =  str_replace($patterns,$replacements,$post);
        $post  =  json_decode($post,true);
        
        if ($_POST['appKey']  ==  $this->config['sy_xjhlive_appkey']){
            
            $xjhM  =  $this->MODEL('xjhlive');
            
            $data  =  array();
            
            if (isset($post['livestatus'])){
                // 直播状态
                $data['livestatus']  =  $post['livestatus'];
                
                if ($post['livestatus'] == 2){
                    
                    $data['recordurl']  =  $post['recordurl'];
                    
                    $info	=	$xjhM->getInfo(array('id'=>$post['xid']), array('field'=>'`caster`'));
                    if ($info['caster'] == 2){
                        
                        $data['caster']  =  1;
                    }
                }
            }
            $nid  =  $xjhM->upXjh(array('id'=>$post['xid']), $data);
        }
        
        $error  =  isset($nid) ? 0: 1;
        
        $this -> render_json($error, 'ok');
    }
    /**
     * 超过30分钟未直播，关闭导播台通知，修改状态
     */
    function castertz_action(){
        
        $post  =  str_replace('“','"',stripslashes($_POST['postdata']));
        
        $patterns     = array("｛", "｝");
        $replacements = array("{", "}");
        
        $post  =  str_replace($patterns,$replacements,$post);
        $post  =  json_decode($post,true);
        
        if ($_POST['appKey']  ==  $this->config['sy_xjhlive_appkey']){
            
            $xjhM  =  $this->MODEL('xjhlive');
            
            $data  =  array(
                'caster' => $post['state']
            );
            
            $nid   =  $xjhM->upXjh(array('id'=>$post['xid']), $data);
        }
        
        $error  =  isset($nid) ? 0: 1;
        
        $this -> render_json($error, 'ok');
    }
}
?>