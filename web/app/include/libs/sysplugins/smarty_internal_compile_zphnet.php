<?php
class Smarty_Internal_Compile_Zphnet extends Smarty_Internal_CompileBase{
    public $required_attributes = array('item');
    public $optional_attributes = array('name', 'key', 'len', 'limit', 'ispage','state', 'type');
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
		$where = "1";
        //根据后台设置开启/隐藏
        $where .=" and `is_open`=1";
		if($config[\'did\']){
			$where.=" and `did`=\'".$config[\'did\']."\'";
		}
		//查询条数
		if($paramer[limit]){
			$limit=" LIMIT ".$paramer[limit];
		}else{
			$limit=" LIMIT 20";
		}
		if($paramer[ispage]){
            if(isset($paramer["type"])) {
               $Purl["type"] = $paramer["type"]; 
            }
			$limit = PageNav($paramer,$_GET,"zphnet",$where,$Purl,"",6,$_smarty_tpl);
		}

        $select = "*";

        // 查询招聘列表，判断有没有未结束的招聘会，确定排序
        $zphlist  =  $db->DB_select_once("zphnet","unix_timestamp(`endtime`)>\'$time\'","`id`");
        $where .= " ORDER BY";
        // 有未结束的，条件查询
        if(!empty($zphlist)){
            // 条件排序，进行中在最上面，接着是未开始，最后是已结束

            $select .= ",CASE WHEN unix_timestamp(`endtime`)>\'$time\' THEN unix_timestamp(`starttime`)";
    		$select .= " WHEN unix_timestamp(`endtime`)<\'$time\' THEN -1*unix_timestamp(`starttime`) END AS `zph_px`";

    		$where .= " CASE";
            $where .= " WHEN unix_timestamp(`starttime`)<\'$time\' AND unix_timestamp(`endtime`)>\'$time\' THEN 0";
            $where .= " WHEN unix_timestamp(`starttime`)>\'$time\' THEN 1";
            $where .= " WHEN unix_timestamp(`endtime`)<\'$time\' THEN 2";
            $where .= " END, `zph_px` ASC";
        }else{
            // 全部结束。按时间开始时间倒序排列
            $where .= " unix_timestamp(`starttime`) DESC";
        }

		'.$name.'=$db->select_all("zphnet", $where.$limit, $select);

        if(is_array('.$name.')){

            $zids = array();
            
            foreach('.$name.' as $k=>$v){
                $zids[] = $v["id"];
            }

            $usercount = $db->select_all("zphnet_user","`zid` in (".implode(\',\',$zids).") and `usertype`=1 GROUP BY `zid`","`zid`,count(*) as `num`");

            $comlist = $db->select_all("zphnet_com","`zid` in (".implode(\',\',$zids).") and `status`=1","`zid`,`uid`,`jobid`");
            $cuids = array();
            $job_ids=array();
            foreach($comlist as $comk=>$comv){
                $cuids[] =  $comv["uid"];

                if($comv[jobid]){

                    $job_ids = array_unique(array_merge($job_ids,@explode(",",$comv[jobid])));

                }
            }
            $jobarr = array();
            if(!empty($cuids)){
                $cuids  =  array_unique($cuids);
                $jobs = $db->select_all("company_job","`uid` in (".@implode(",",$cuids).") AND `state`=1 AND `r_status`=1 AND `status`=\'0\' GROUP BY `uid`","count(*) as num,sum(`zp_num`) `zp_num`,uid");

                foreach($jobs as $jk=>$jv){

                    $jobarr[$jv["uid"]]["jobnum"] = $jv["num"];
                    $jobarr[$jv["uid"]]["zpnum"] = $jv["zp_num"];
                }
  
                $jobidlist = $db->select_all("company_job","`id` in (".implode(\',\',$job_ids).") and `state`=1 and `status`=0 and `r_status`=1","`id`");

                $jidarr =   array();

                foreach($jobidlist as $jidv){
                    $jidarr[] = $jidv[id];
                }
            }
             
            foreach($comlist as $clk=>$clv){
                
                $comlist[$clk][jobnum] = 0;
                $comlist[$clk][zpnum]  =  isset($jobarr[$clv[uid]][zpnum]) ? $jobarr[$clv[uid]][zpnum] : 0;
                if($clv["jobid"]){

                    $jobidarr = @explode(",",$clv["jobid"]);

                    foreach($jobidarr as $jv){

                        if(in_array($jv,$jidarr)){

                            $comlist[$clk][jobnum]++;
                        }
                    }
                }else{
                    $comlist[$clk][jobnum]  =  $jobarr[$clv[uid]][jobnum]; 
                }
            }
            
            $comsql = "select a.`zid`,count(*) as `num` from `".$db_config[def]."zphnet_com` a , `".$db_config[def]."company` b where a.`zid` in (".implode(\',\',$zids).") AND a.`status`=1 AND a.`uid`=b.`uid`  AND b.`r_status`=\'1\' GROUP BY a.`zid`";
        
            $comcount = $db->DB_query_all($comsql,"all");

			foreach('.$name.' as $key=>$v){

                '.$name.'[$key]["usernum"] = 0;
                '.$name.'[$key]["comnum"] = 0;
                '.$name.'[$key]["jobnum"] = 0;
                '.$name.'[$key]["zpnum"] = 0;
                foreach($comlist as $val){
                    if($v[id] == $val[zid]){
                        '.$name.'[$key]["jobnum"]+=$val[jobnum];
                        '.$name.'[$key]["zpnum"] +=$val[zpnum];
                    }
                }

                foreach($usercount as $uk=>$uv){
                    
                    if($uv["zid"] == $v["id"]){
                        '.$name.'[$key]["usernum"] = $uv["num"];
                    }

                }

                foreach($comcount as $ck=>$cv){
                    
                    if($cv["zid"] == $v["id"]){

                        '.$name.'[$key]["comnum"] = $cv["num"];

                    }

                }
                
                if($v["pnum"] > 0){
                    '.$name.'[$key]["comnum"] = $v["pnum"] + '.$name.'[$key]["comnum"];
                }   
                if($v["zpnum"] > 0){
                    '.$name.'[$key]["zpnum"] = $v["zpnum"] + '.$name.'[$key]["zpnum"] ;
                }  
                if($v["jnum"] > 0){
                    '.$name.'[$key]["jobnum"] = $v["jnum"] + '.$name.'[$key]["jobnum"];
                }
                if($v["unum"] > 0){
                    '.$name.'[$key]["usernum"] = $v["unum"] + '.$name.'[$key]["usernum"];
                }

                if($v["hits"] > 0){
				    '.$name.'[$key]["hits"] = $v["hits"];
				}else{
				    '.$name.'[$key]["hits"] = '.$name.'[$key]["comnum"] + '.$name.'[$key]["usernum"];
				}
                
				'.$name.'[$key]["starttime_n"]=date(\'Y-m-d H:i\',strtotime($v[starttime]));
                '.$name.'[$key]["endtime_n"]=date(\'Y-m-d H:i\',strtotime($v[endtime]));
				'.$name.'[$key]["stime"]=strtotime($v[starttime])-time();
				'.$name.'[$key]["etime"]=strtotime($v[endtime])-time();
				if($paramer[len]){
					'.$name.'[$key]["title"]=mb_substr($v[\'title\'],0,$paramer[len],"utf-8");
				}
				'.$name.'[$key]["url"]=Url("zphnet",array("c"=>\'show\',"id"=>$v[\'id\']),"1");

				'.$name.'[$key][\'pic\'] = checkpic($v[\'pic\'],$config[\'sy_zph_icon\']);
                '.$name.'[$key][\'pic_wap\'] = checkpic($v[\'pic_wap\'],$config[\'sy_zph_icon\']);
                '.$name.'[$key][\'banner_wap\'] = checkpic($v[\'banner_wap\'],$config[\'sy_zph_icon\']);
			}
		}';
        //自定义标签 END
        return SmartyOutputStr($this,$compiler,$_attr,'zphnet',$name,$OutputStr,$name);
    }
}
class Smarty_Internal_Compile_Zphnetselse extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('zphnet'));
        $this->openTag($compiler, 'zphnetelse', array('zphnetelse', $nocache, $item, $key));

        return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
    }
}
class Smarty_Internal_Compile_Zphnetclose extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('zphnet', 'zphnetelse'));

        return "<?php } ?>";
    }
}
