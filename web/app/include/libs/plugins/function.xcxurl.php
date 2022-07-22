<?php
function smarty_function_xcxurl($paramer,&$smarty){
		global $config,$db_config,$db,$views;
		
		include_once(APP_PATH.'app/model/xcx.model.php');
          
        $xcxM  =  new xcx_model($db,$db_config['def']);
        
        $xcxdata = array(
        	'type'=>$paramer['type'],
        	'id'=>$paramer['id']
        );

		$url = $xcxM->getUrlLink($xcxdata);
		
		return $url;

	}
?>