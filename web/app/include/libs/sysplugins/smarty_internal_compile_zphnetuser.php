<?php
class Smarty_Internal_Compile_Zphnetuser extends Smarty_Internal_CompileBase{
	public $required_attributes = array('item');
	public $optional_attributes = array('name','post_len', 'limit', 'city_len', 'ispage','id','keyword');
	public $shorttag_order = array('from', 'item', 'key', 'name');
	public function compile($args, $compiler, $parameter){
		$_attr = $this->getAttributes($compiler, $args);

		$from = $_attr['from'];
		$item = $_attr['item'];
		$name = $_attr['item'];
		$name=str_replace('\'','',$name);
		$name=$name?$name:'list';$name='$'.$name;
		if (!strncmp("\$_smarty_tpl->tpl_vars[$item]", $from, strlen($item) + 24)) {
			$compiler->trigger_template_error("item variable {$item} may not be the same variable as at 'from'", $compiler->lex->taglineno);
		}

		//自定义标签START
		$OutputStr=''.$name.'=array();global $db,$db_config,$config;

		$paramer='.ArrayToString($_attr,true).';
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
		$Purl =  $ParamerArr[purl];
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }

	    //处理类别字段
		$cache_array = $db->cacheget();
		$userclass_name = $cache_array["user_classname"];

		$where = "a.zid=".$paramer[id]." AND a.`usertype`=1 AND a.`uid`=b.`uid` AND b.`defaults`=\'1\' AND b.`state`=\'1\' AND b.`status`=\'1\' AND b.`r_status`=\'1\'";

		//关键字
		if($paramer[keyword]){
           
            $where.=" AND b.`name` LIKE \'%$paramer[keyword]%\'";
		}
        $order = " ORDER BY a.`ctime` ";
		//排序规则 默认为倒序
		$sort = \'DESC\';
		//查询条数
		$limit = PageNav($paramer,$_GET,"zphnet_user",$where,$Purl,"resume_expect","0",$_smarty_tpl);

        $select="b.`id`,b.`uid`,b.`name`";
		
        $sql = "select ".$select." from `".$db_config[def]."zphnet_user` a , `".$db_config[def]."resume_expect` b where ".$where.$order.$sort.$limit;
		
        '.$name.'=$db->DB_query_all($sql,"all");
            
        include(CONFIG_PATH."db.data.php");		

		if(!empty('.$name.') && is_array('.$name.')){
			
			$uids = array();
			foreach('.$name.' as $v){
				
				$uids[] = $v[\'uid\'];
			}
            $resume=$db->select_all("resume","`uid` in(".@implode(\',\',$uids).")","uid,name,nametype,sex,edu,exp,photo,phototype,photo_status,birthday");

            foreach('.$name.' as $k=>$v){
			    foreach($resume as $val){
			        if($v[\'uid\']==$val[\'uid\']){
			    		'.$name.'[$k][\'edu_n\']=$userclass_name[$val[\'edu\']];
				        '.$name.'[$k][\'exp_n\']=$userclass_name[$val[\'exp\']];
			            if($val[\'birthday\']){
							$year = date("Y",strtotime($val[\'birthday\']));
							'.$name.'[$k][\'age_n\'] =date("Y")-$year;
						}
						if($val[\'sex\']==152){
							$val[\'sex\']=\'1\';
						}elseif ($val[\'sex\']==153){
							$val[\'sex\']=\'2\';
						}
						'.$name.'[$k][\'sex_n\'] =$arr_data[sex][$val[\'sex\']];
		                $photo=$icon="";
						if($config[\'user_pic\']==1 || empty($config[\'user_pic\'])){
			                if($val[\'photo\'] && $val[\'photo_status\']==0 && $val[\'phototype\']!=1){
	            				$photo=$val[\'photo\'];
	            			}else{
	            				if($val[\'sex\']==1){
	            					$icon=$config[\'sy_member_icon\'];
	            				}else{
	            					$icon=$config[\'sy_member_iconv\'];
	            				}
	            			}
	            			
						}elseif($config[\'user_pic\']==2){
							if($val[\'photo\']&& $val[\'photo_status\']==0){
								$photo=$val[\'photo\'];
							}else{
								if($val[\'sex\']==1){
									$icon=$config[\'sy_member_icon\'];
								}else{
									$icon=$config[\'sy_member_iconv\'];
								}
							}
						}elseif($config[\'user_pic\']==3){
							if($val[\'sex\']==1){
								$icon=$config[\'sy_member_icon\'];
							}else{
								$icon=$config[\'sy_member_iconv\'];
							}
						}
						'.$name.'[$k][\'photo_n\']=checkpic($photo,$icon);
                        //名称显示处理
						if($config[\'user_name\']==1 || !$config[\'user_name\']){
    						if($val[\'nametype\']==3){
    						    if($val[\'sex\']==1){
    						        '.$name.'[$k][\'uname_n\'] = mb_substr($val[\'name\'],0,1,\'utf-8\')."先生";
    						    }else{
    						        '.$name.'[$k][\'uname_n\'] = mb_substr($val[\'name\'],0,1,\'utf-8\')."女士";
    						    }
    						}elseif($val[\'nametype\']==2){
    						    '.$name.'[$k][\'uname_n\'] = "NO.".$v[\'id\'];
    						}else{
    							'.$name.'[$k][\'uname_n\'] = $val[\'name\'];
    						}
						}elseif($config[\'user_name\']==3){
							if($val[\'sex\']==1){
								'.$name.'[$k][\'uname_n\'] = mb_substr($val[\'name\'],0,1,\'utf-8\')."先生";
							}else{
								'.$name.'[$k][\'uname_n\'] = mb_substr($val[\'name\'],0,1,\'utf-8\')."女士";
							}
						}elseif($config[\'user_name\']==2){
							'.$name.'[$k][\'uname_n\'] = "NO.".$v[\'id\'];
						}elseif($config[\'user_name\']==4){
							'.$name.'[$k][\'uname_n\'] = $val[\'name\'];
						}
                    }
                }
			}
		}';
		return SmartyOutputStr($this,$compiler,$_attr,'zphnetuser',$name,$OutputStr,$name);
	}
}
class Smarty_Internal_Compile_Zphnetuserelse extends Smarty_Internal_CompileBase{
	public function compile($args, $compiler, $parameter){
		$_attr = $this->getAttributes($compiler, $args);

		list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('zphnetuser'));
		$this->openTag($compiler, 'zphnetuserelse', array('zphnetuserelse', $nocache, $item, $key));

		return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
	}
}
class Smarty_Internal_Compile_Zphnetuserclose extends Smarty_Internal_CompileBase{
	public function compile($args, $compiler, $parameter){
		$_attr = $this->getAttributes($compiler, $args);
		if ($compiler->nocache) {
			$compiler->tag_nocache = true;
		}

		list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('zphnetuser', 'zphnetuserelse'));

		return "<?php } ?>";
	}
}
