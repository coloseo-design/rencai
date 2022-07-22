<?php
class Smarty_Internal_Compile_Lietoulist extends Smarty_Internal_CompileBase{
    public $required_attributes = array('item');
    public $optional_attributes = array('name', 'key', 'rec', 'limit', 'keyword', 'hy', 'hyclass', 'job', 'jobclass', 'jobid', 'hyid', 'rzid', 'order', 'ispage','islt','provinceid','cityid','three_cityid');
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

        //自定义标签 START
        $OutputStr='global $db,$db_config,$config;$paramer='.ArrayToString($_attr,true).';'.$name.'=array();
		include PLUS_PATH."/ltjob.cache.php";
		include PLUS_PATH."/city.cache.php";
		include PLUS_PATH."/lthy.cache.php";
        include PLUS_PATH."/lt.cache.php";
		//处理传入参数，并且构造分页参数
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
		$Purl =  $ParamerArr[purl];
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }
		$where="`yyzz_status`=\'1\' and `r_status`=\'1\' and `com_name`<>\'\'";
		//是否属于分站下
		if($config[sy_web_site]=="1"){
			if($config[province]>0 && $config[province]!=""){
				$paramer[provinceid] = $config[province];
			}
			if($config[cityid]>0 && $config[cityid]!=""){
				$paramer[cityid]=$config[cityid];
			}
			if($config[three_cityid]>0 && $config[three_cityid]!=""){
				$paramer[three_cityid] = $config[three_cityid];
			}
		}
		//关键字
		if($paramer["keyword"]){
			$where1[]="`realname` LIKE \'%".$paramer[keyword]."%\'";
			foreach($ltjob_name as $k=>$v){
				if(strpos($v,$paramer[keyword])!==false){
					$jobid[]=$k;
				}
			}
			if(is_array($jobid)){
				foreach($jobid as $value){
					$class[]="FIND_IN_SET(\'".$value."\',job)";
				}
				$where1[]=@implode(" or ",$class);
			}
			foreach($lthy_name as $k=>$v){
				if(strpos($v,$paramer[keyword])!==false){
					$hyid[]=$k;
				}
			}
			if(is_array($hyid)){
				foreach($hyid as $value){
					$class[]="FIND_IN_SET(\'".$value."\',hy)";
				}
				$where1[]=@implode(" or ",$class);
			}
			$where.=" AND (".@implode(" or ",$where1).")";
		}
		//认证ID
		if($paramer["rzid"]){
			$where.=" AND `rzid`=\'".$paramer["rzid"]."\'";
		}
		//推荐
		if($paramer["rec"]){
			$where.=" AND `rec`=\'".$paramer["rec"]."\'";
		}
		//擅长行业大类
		if($paramer["hyclass"]){
			$hyid=$lthy_type[$paramer["hyclass"]];
			foreach($hyid as $v){
				$hyarr[]= "FIND_IN_SET(\'".$v."\',hy)";
			}
			$hyarr=@implode(" or ",$hyarr);
			$where.=" AND ($hyarr)";
		}
		//城市
		if($paramer["provinceid"]){
			$where.= " AND `provinceid`=$paramer[provinceid]";
		}
		if($paramer["cityid"]){
			$where.= " AND `cityid`=$paramer[cityid]";
		}
		if($paramer["three_cityid"]){
			$where.= " AND `three_cityid`=$paramer[three_cityid]";
		}
		//擅长行业子类
		if($paramer["hy"]){
			$where.= " AND FIND_IN_SET(\'".$paramer["hy"]."\',hy)";
		}
		//擅长职位大类
		if($paramer["jobclass"]){
			$jobid=$ltjob_type[$paramer["jobclass"]];
			foreach($jobid as $v){
				$jobarr[]= "FIND_IN_SET(\'".$v."\',job)";
			}
			$jobarr=@implode(" or ",$jobarr);
			$where.=" AND ($jobarr)";
		}
		//擅长职位子类
		if($paramer["job"]){
			$where.= " AND FIND_IN_SET(\'".$paramer["job"]."\',job)";
		}
		//擅长行业
		if($paramer["hyid"]){
			$hyid=@explode(",",$paramer["hyid"]);
			foreach($hyid as $v){
				$hyall[].= "FIND_IN_SET(\'".$v."\',hy)";
			}
			$where .= " and (".@implode(" or ",$hyall).")";
		}
		//擅长职位
		if($paramer["jobid"]){
			$jobid=@explode(",",$paramer["jobid"]);
			foreach($jobid as $v){
				$joball[].= "FIND_IN_SET(\'".$v."\',job)";
			}
			$where .= " and (".@implode(" or ",$joball).")";
		}
		
		if($paramer[ispage]){
			$limit = PageNav($paramer,$_GET,"lt_info",$where,$Purl,"",$paramer[islt]?$paramer[islt]:"1",$_smarty_tpl);
		}
		//排序字段（默认按照uid排序）
		if($paramer[order]){
			if($paramer[order]=="rztime"){
				$where .= " ORDER BY rz_time ";
			}else{
				$where .= " ORDER BY $paramer[order] ";
			}
		}else{
			$where .= " ORDER BY `uid` ";
		}
		//排序规则（默认按照开始时间排序倒序）
		if($paramer["sort"]){
			$where .= " $paramer[sort]";
		}else{
			$where .= " DESC ";
		}
		'.$name.'=$db->select_all("lt_info",$where.$limit);
		if($_COOKIE[usertype]==1){
			$atn=$db->select_all("atn","`uid`=\'".$_COOKIE[uid]."\' and `sc_usertype`=\'3\'");
		}
		if(is_array('.$name.')){
			foreach('.$name.' as $k=>$v){
                '.$name.'[$k][exp_info]=$ltclass_name[$v[exp]];
				'.$name.'[$k][cityone_info]=$city_name[$v[provinceid]];
				'.$name.'[$k][citytwo_info]=$city_name[$v[cityid]];
				if(is_array('.$name.')){
					foreach($atn as $val){
						if($v[uid]==$val[sc_uid]){
							'.$name.'[$k][atn]=1;
						}
					}
				}
				$uid[]=$v[uid];
			}
			$ratings=$db->DB_query_all("select a.uid,b.com_pic from $db_config[def]lt_statis a left join $db_config[def]company_rating b on a.rating = b.id WHERE a.uid in (".@implode(",",$uid).")","all");
			$joblist=$db->select_all("lt_job","`status`=\'1\' and `uid` in (".@implode(",",$uid).") and `r_status`=\'1\' order by `lastupdate` desc");
			foreach('.$name.' as $k=>$v){
				foreach($ratings as $val)
				{//猎头图标
					if($v[uid]==$val[uid]){
						'.$name.'[$k]["com_pic"]=checkpic($val[\'com_pic\']);
                    }
				}
				$i=0;$job="";
				foreach($joblist as $val)
				{//猎头最新职位
					if($v[uid]==$val[uid]){
						$job_url = Url("lietou",array("c"=>"jobshow","id"=>$val[id]));
						$job.="<a href=\'".$job_url."\'>".$val[job_name]."</a> ";
						$i++;$val[job_url]=$job_url;
                        '.$name.'[$k]["ltjoblist"][]=$val;
					}
				}
				'.$name.'[$k]["jobnum"]=$i;
				'.$name.'[$k]["joblist"]=$job;
				$jobsc="";
				if($v[job]!=""){//擅长职位
					$job=@explode(",",$v[job]);
					foreach($job as $val){
						$jobsc.=$ltjob_name[$val]." ";
					}
				}
				'.$name.'[$k]["job"]=$jobsc;
				$hy="";
				if($v[hy]!=""){//擅长行业
					$hyarr=@explode(",",$v[hy]);
					foreach($hyarr as $val){
						$hy.=$lthy_name[$val]." ";
					}
				}
				'.$name.'[$k]["hy"]=$hy;
				'.$name.'[$k]["name_url"] = Url("lietou",array("c"=>"headhunter","uid"=>$v[uid]));//猎头链接
				if($v[photo_status]==0){
					'.$name.'[$k][\'photo_big\'] = checkpic($v[\'photo_big\'],$config[\'sy_lt_icon\']);
				}else{
					'.$name.'[$k][\'photo_big\'] = checkpic(\'\',$config[\'sy_lt_icon\']);
				}
			}
		}
		if($paramer[keyword]!=""&&!empty('.$name.'))
		{
			addkeywords(\'6\',$paramer[keyword]);
		}';
        //自定义标签 END
       // global $DiyTagOutputStr;
        //$DiyTagOutputStr[]=$OutputStr;
        return SmartyOutputStr($this,$compiler,$_attr,'lietoulist',$name,$OutputStr,$name);
    }
}
class Smarty_Internal_Compile_Lietoulistelse extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('lietoulist'));
        $this->openTag($compiler, 'lietoulistelse', array('lietoulistelse', $nocache, $item, $key));

        return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
    }
}
class Smarty_Internal_Compile_Lietoulistclose extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('lietoulist', 'lietoulistelse'));

        return "<?php } ?>";
    }
}
