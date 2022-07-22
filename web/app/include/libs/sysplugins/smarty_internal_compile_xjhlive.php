<?php
class Smarty_Internal_Compile_Xjhlive extends Smarty_Internal_CompileBase{
    public $required_attributes = array('item');
    public $optional_attributes = array('name', 'key', 'len', 'limit', 'ispage','state','order','sort','status','playback','livestatus','ishot','keyword');
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
        $OutputStr=''.$name.'=array();$time=time();$paramer='.ArrayToString($_attr,true).';
		global $db,$db_config,$config;
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
		$Purl =  $ParamerArr[purl];
        global $ModuleName;

        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }

		$where = "`state`<>3 AND `statetime`<".time();
        
        if($config[\'did\']){
			$where.=" and `did`=\'".$config[\'did\']."\'";
		}

        if($paramer[status]){
            $where.=" and `status`=\'".$paramer[status]."\'";
        }else{
            $where.=" and `status`=1";
        }
        if($paramer[ishot]){
            $where.=" and `livestatus` <> 2";
        }
        if($paramer[livestatus]){
            $where.=" and `livestatus`=\'".$paramer[livestatus]."\'";
        }
        if($paramer[playback]){
            $where.=" and `playback`=\'".$paramer[playback]."\'";
            $where.=" and `livestatus`=2";
        }

        if($paramer[keyword]){
            $where.=" and `name` LIKE \'%$paramer[keyword]%\'";
            
        }
		//查询条数
		if($paramer[limit]){
			$limit=" LIMIT ".$paramer[limit];
		}else{
			$limit=" LIMIT 20";
		}
		if($paramer[ispage]){
			$limit = PageNav($paramer,$_GET,"xjhlive",$where,$Purl,"",6,$_smarty_tpl);
		}
        
        $select = "*";
        // 查询招聘列表，判断有没有未结束的宣讲会，确定排序
        $awhere =   $where." AND `livestatus`<>2";
        
        $xjhlist  =  $db->DB_select_once("xjhlive",$awhere,"`id`");

        if(!empty($xjhlist)){
            $select .= ",CASE WHEN `livestatus`<>2  THEN `stime`";
            $select .= " WHEN `livestatus`=2 THEN -1*`stime` END AS `xjh_px`";

            $where .= " ORDER BY CASE";
            $where .= " WHEN `livestatus`=3 THEN 0";
            $where .= " WHEN `livestatus`=1 THEN 1";
            $where .= " WHEN `livestatus`=2 THEN 2";
            $where .= " END, `xjh_px` ASC";
            
        }else{
            // 全部结束。按时间开始时间倒序排列
            $where .= " ORDER BY `stime` DESC";
        }
		
		'.$name.'=$db->select_all("xjhlive", $where.$limit, $select);
		
		
		if(is_array('.$name.')){
            $time = time();
            foreach('.$name.' as $xkey=>$xval){
                
                $xids[]   =   $xval[id];
            }
            if($paramer[livestatus]==1){
                $nliveids=array();
                foreach('.$name.' as $ke=>$va){
                    if($va[livestatus]==1 && ($va[stime] + (3600 * $va[playtime])) < $time){
                        $nliveids[]=$va[id];
                        unset('.$name.'[$ke]);
                    }
					$xjhids[]	=	$va[id];
                }

                if(!empty($nliveids)){
                    
                    $db->update_all("xjhlive","`livestatus`=2","`id` IN (".@implode(",",$nliveids).")");
                }
				
            }
            $subed  =   array();
            if($_COOKIE[uid] && $_COOKIE[usertype]==1){
                foreach('.$name.' as $xk=>$xv){
                    $xidarr[]   =   $xv[id];
                }
                if(!empty($xidarr)){
                    $xidstr =   pylode(",",$xidarr);
                    $xsub   =   $db->select_all("xjhlive_yy","`uid`=".$_COOKIE[uid]." AND `xid` IN(".$xidstr.")");
                    foreach($xsub as $sk=>$sb){
                        $subed[]=   $sb[xid];
                    }
                    
                }
            }

            $xjhpic   =   $db->select_all("xjhlive_pic","`xid` IN(".pylode(",",$xids).") ORDER BY `id` ASC");
            $picarr   =   array();
            if(!empty($xjhpic)){

                foreach($xjhpic as $pk=>$pv){
                    $picarr[$pv["xid"]][] = $pv["picurl"];
                }
            }

            foreach('.$name.' as $key=>$v){
				'.$name.'[$key]["stime_n"]=date(\'Y-m-d H:i\',$v[stime]);
                '.$name.'[$key]["etime_n"]=date(\'H:i\',$v[stime]+$v[playtime]*3600);
                
                if(in_array($v[id],$subed)){
                    '.$name.'[$key][substatus]  =  2;
                }else{
                    '.$name.'[$key][substatus]  =  1;
                }
				if($paramer[len]){
					'.$name.'[$key]["name"]=mb_substr($v[\'name\'],0,$paramer[len],"utf-8");
				}
				'.$name.'[$key]["url"]=Url("xjhlive",array("c"=>\'show\',"id"=>$v[\'id\']),"1");
                
                $picurl    =   $picarr[$v[\'id\']][0] ? $picarr[$v[\'id\']][0] : "";
				
				'.$name.'[$key][\'pic\'] = checkpic($picurl);

                if($v[livestatus]==1){
                        
                    if (!empty($v[playtime])){
                        
                        '.$name.'[$key][livestatus_n]   = "未开始";
                        
                    }else{
                        '.$name.'[$key][livestatus_n]   = "未开始";
                    }
                }else if($v[livestatus]==2){
                    
                    '.$name.'[$key][livestatus_n]   = "已结束";
                }else if($v[livestatus]==3){
                    
                    '.$name.'[$key][livestatus_n]   = "直播中";
                }
			}
			if(!empty($xjhids)){
				
				$subList=$db->select_all("xjhlive_yy", "`xjhid` IN (".pylode(",",$xjhids).")","*");
				if(!empty($subList)){
					foreach($subList as $item) {
						$res[$item[xid]][] = $item;
					}
				}
				
				
				foreach('.$name.' as $key=>$val) {
					foreach($res as $k=>$v) {
						
						if($val[id]==$k){
							'.$name.'[$key][subnum]	=	count($v);
						}
					}
					'.$name.'[$key][subnum]	=	'.$name.'[$key][subnum]>0?'.$name.'[$key][subnum]:0;
				}
			}
		}';
        //自定义标签 END
        return SmartyOutputStr($this,$compiler,$_attr,'xjhlive',$name,$OutputStr,$name);
    }
}
class Smarty_Internal_Compile_Xjhliveelse extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('xjhlive'));
        $this->openTag($compiler, 'xjhliveelse', array('xjhliveelse', $nocache, $item, $key));

        return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
    }
}
class Smarty_Internal_Compile_Xjhliveclose extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('xjhlive', 'xjhliveelse'));

        return "<?php } ?>";
    }
}
