<?php
class Smarty_Internal_Compile_Ltjoblist extends Smarty_Internal_CompileBase{
    public $required_attributes = array('item');
    public $optional_attributes = array('name', 'key','comlen', 'limit', 'order', 'rebates', 't_len', 'hyclass', 'jobone', 'jobtwo', 'minsalary','maxsalary', 'uptime', 'provinceid', 'cityid', 'three_cityid', 'keyword', 'uid', 'order', 'jobtwo', 'rec','salary', 'hyid','jobid','citys','ispage','hy','pr','mun','edu','exp','islt');
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
        include_once  PLUS_PATH."/ltjob.cache.php";
		include_once  PLUS_PATH."/lthy.cache.php";
		//处理传入参数，并且构造分页参数
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
		$Purl =  $ParamerArr[purl];
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }
        $cache_array = $db->cacheget();
        $industry_name	= $cache_array["industry_name"];
		$where = " `status`=\'1\' and `zp_status`=\'0\' and `r_status`=\'1\'";
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
			$where.=" AND (`com_name` like \'%".$paramer["keyword"]."%\' or `job_name` like \'%".$paramer["keyword"]."%\')";
		}
		/*//期望行业大类
		if($paramer["hyclass"]){
			$hyid=$lthy_type[$paramer["hyclass"]];
			foreach($hyid as $v)
			{
				$hyarr[]= "FIND_IN_SET(\'".$v."\',qw_hy)";
			}
			$hyarr=@implode(" or ",$hyarr);
			$where.=" AND ($hyarr)";
		}
		//期望行业子类
		if($paramer["qw_hy"]){
			$where.= " AND FIND_IN_SET(\'".$paramer["qw_hy"]."\',qw_hy)";
		}
		//期望行业
		if($paramer["hyid"]){
			$hyid=@explode(",",$paramer["hyid"]);
			foreach($hyid as $v){
				$hyall[].= "FIND_IN_SET(\'".$v."\',qw_hy)";
			}
			$where .= " and (".@implode(" or ",$hyall).")";
		}*/

		//擅长职位
		if($paramer["jobid"]){
			$jobid=@explode(",",$paramer["jobid"]);
			foreach($jobid as $v){
				$joball[].= "`jobone`=\'".$v."\'";
				$joball[].= "`jobtwo`=\'".$v."\'";
			}
			$where .= " and (".@implode(" or ",$joball).")";
		}
		 
		if($paramer["citys"]){
			$citys=@explode(",",$paramer["citys"]);
			foreach($citys as $v){
				$cityall[].= "`provinceid`=\'".$v."\'";
				$cityall[].= "`cityid`=\'".$v."\'";
				$cityall[].= "`three_cityid`=\'".$v."\'";
			}
			$where .= " and (".@implode(" or ",$cityall).")";
		}
		//职位大类
		if($paramer["jobone"]){
			$where.=" AND `jobone`=\'".$paramer["jobone"]."\'";
		}
		//职位子类
		if($paramer["jobtwo"]){
			$where.=" AND `jobtwo`=\'".$paramer["jobtwo"]."\'";
		}
		//年薪
		if($paramer["salary"]){
			$where.=" AND `salary`=\'".$paramer["salary"]."\'";
		}
		if($paramer[minsalary]&&$paramer[maxsalary]){
			$where.= "AND `minsalary`>=".intval($paramer[minsalary])." and `maxsalary`<=".intval($paramer[maxsalary])."";
		}elseif($paramer[minsalary]&&!$paramer[maxsalary]){
			$where.= " AND `minsalary`>=".intval($paramer[minsalary])."";
		}elseif(!$paramer[minsalary]&&$paramer[maxsalary]){
			$where.= " AND `maxsalary`<=".intval($paramer[maxsalary])."";
		}
        //公司所属行业
		if($paramer["hy"]){
			$where.=" AND `hy`=\'".$paramer["hy"]."\'";
		}
        //公司性质
		if($paramer["pr"]){
			$where.=" AND `pr`=\'".$paramer["pr"]."\'";
		}
        //公司规模
		if($paramer["mun"]){
			$where.=" AND `mun`=\'".$paramer["mun"]."\'";
		}
        //工作经验
		if($paramer["exp"]){
			$where.=" AND `exp`=\'".$paramer["exp"]."\'";
		}
        //学历要求
		if($paramer["edu"]){
			$where.=" AND `edu`=\'".$paramer["edu"]."\'";
		}
		//发布时间
		if($paramer["uptime"]){
			if($paramer["uptime"]>0){
				$time=time()-86400*30*$paramer["uptime"];
				$where.=" AND `lastupdate`>$time";
			}else{
				$time=time()-86400*30*12;
				$where.=" AND `lastupdate`<$time";
			}
		}
		//推荐
		if($paramer["rec"]){
			$where.=" AND `rec`=\'".$paramer["rec"]."\'";
		}
		//城市
		if($paramer["provinceid"]){
			$where.=" AND `provinceid`=\'".$paramer["provinceid"]."\'";
		}
		if($paramer["cityid"]){
			$where.=" AND `cityid`=\'".$paramer["cityid"]."\'";
		}
		if($paramer["three_cityid"]){
			$where.=" AND `three_cityid`=\'".$paramer["three_cityid"]."\'";
		}
		//用户uid
		if($paramer["uid"]){
			$where.=" AND `uid`=\'".$paramer["uid"]."\'";
		}
		if($paramer["rebates"]==\'1\'){
			$where.=" AND `rebates`<>\'\'";
		}
		if($paramer["limit"]){
			$limit= " limit $paramer[limit]";
		}
		if($paramer[ispage]){
			$limit = PageNav($paramer,$_GET,"lt_job",$where,$Purl,"",$paramer[islt]?$paramer[islt]:"1",$_smarty_tpl);
         
		}
		//排序字段（默认按照uid排序）
		if($paramer[order]){
			$where .= " ORDER BY $paramer[order]";
		}else{
			$where .= " ORDER BY  `lastupdate`  ";
		}
		//排序规则（默认按照开始时间排序倒序）
		if($paramer["sort"]){
			$where .= " $paramer[sort]";
		}else{
			$where .= " DESC ";
		}
		 
		'.$name.'=$db->select_all("lt_job",$where.$limit);
		if(!$paramer[ispage]){
			$_smarty_tpl->tpl_vars["t_count"]->value=count('.$name.');
		}
		
		if(is_array('.$name.')){
			foreach('.$name.' as $v){
				if($v[\'usertype\']==2){
					$comuid[]=$v[\'uid\'];
    			}
                if($v[\'usertype\']==3){
					$comuid[]=$v[\'uid\'];
    			}
    		}
    	}
    	$comlist = array();
    	$ltlist = array();
    	if(is_array($comuid) && count($comuid)){
    		$comlist=$db->select_all("company","`uid` IN (".@implode(\',\',$comuid).")","`uid`,`name`,`hy`,`logo`");
        	$ltlist=$db->select_all("lt_info","`uid` IN (".@implode(\',\',$comuid).")","`uid`,`hy`,`photo_big`");
		}
		
		
		if(is_array('.$name.')){
			$uid = array();
			foreach('.$name.' as $k=>$v){
				if(is_array('.$name.')){
					foreach($atn as $val){
						if($v[uid]==$val[sc_uid]){
							'.$name.'[$k][atn]=1;
						}
					}
				}
				$uid[]=$v[uid];
			}
			$ratings = array();
			$joblist = array();
			if(count($uid)){
				$ratings=$db->DB_query_all("select a.uid,b.com_pic from $db_config[def]company_statis a left join $db_config[def]company_rating b on a.rating = b.id WHERE a.uid in (".@implode(",",$uid).")","all");
				$joblist=$db->select_all("lt_job","`status`=\'1\' and `uid` in (".@implode(",",$uid).") and `r_status`=\'1\' order by `lastupdate` desc");
			}
			foreach('.$name.' as $k=>$v){
				foreach($ratings as $val)
				{//猎头图标
					if($v[uid]==$val[uid] && $v[usertype]==2){
						if($val["com_pic"]){
							'.$name.'[$k]["com_pic"]=$val["com_pic"];
						}
                        
					}
				}
				
			}
		}
		if(is_array('.$name.')){
			foreach('.$name.' as $k=>$v){
				'.$name.'[$k] = $db->lt_array_action($v);
				//对job_name 截取
				if(intval($paramer[\'t_len\'])>0){
					$len = intval($paramer[\'t_len\']);
					'.$name.'[$k][\'job_name\'] = mb_substr($v[\'job_name\'],0,$len,"utf-8");
				}
				if($v[\'usertype\']==3){
                    '.$name.'[$k]["lt_url"] = Url("lietou",array("c"=>"headhunter","uid"=>$v[uid]));
					'.$name.'[$k]["job_url"] = Url("lietou",array("c"=>"jobshow","id"=>$v[\'id\']));
					 '.$name.'[$k]["wap_lt_url"] = Url("wap",array("c"=>"ltjob","a"=>"headhunter","uid"=>$v[uid]));
				}else{
                    '.$name.'[$k]["lt_url"] = Url("company",array("c"=>"show","id"=>$v[\'uid\']));
					'.$name.'[$k]["job_url"] = Url("lietou",array("c"=>"jobcomshow","id"=>$v[\'id\']));
					'.$name.'[$k]["wap_lt_url"] = Url("wap",array("c"=>"company","a"=>"show","id"=>$v[\'uid\']));
				}		
				if($v[\'minsalary\']>0&&$v[\'maxsalary\']>0){
					'.$name.'[$k]["salary_info"] = floatval($v[\'minsalary\'])."-".floatval($v[\'maxsalary\'])."万";    
                }else if($v[\'minsalary\']>0){
                    '.$name.'[$k]["salary_info"] = floatval($v[\'minsalary\'])."万";  
                }else{
    				'.$name.'[$k]["salary_info"] = "面议";
    			}
                
				'.$name.'[$k]["lastupdate"] = date("Y-m-d",$v["lastupdate"]);
				  if($v[\'usertype\']==3){
              foreach($ltlist as $val){

                if($v[\'uid\']==$val[\'uid\']  && $v[usertype]==3){

                              if($val[hy]!=""){

                                 $hy="";

                                 $hyarr=@explode(",",$val[hy]);

                                  foreach($hyarr as $vall){

                                      $hy.=$lthy_name[$vall]." ";

                                  }

                                  '.$name.'[$k][hy_n] = mb_substr($hy,0,$paramer[comlen],"utf-8");

                              }

                  '.$name.'[$k][\'logo_n\'] = checkpic($val[\'photo_big\'],$config[\'sy_lt_icon\']);

                  }

              }
          }else{
              foreach($comlist as $val){

                if($v[\'uid\']==$val[\'uid\']&&$val[\'name\']){

                    '.$name.'[$k]["com_name"]=$val[\'name\'];
                    '.$name.'[$k]["hy_n"]=$industry_name[$val[\'hy\']];
                    '.$name.'[$k][\'logo_n\'] = checkpic($val[\'logo\'],$config[\'sy_unit_icon\']);

                  }

              }
          }
			}
		} 
		if($paramer[\'keyword\']!=""&&!empty('.$name.')){
			addkeywords(\'7\',$paramer[\'keyword\']);
		}';
        //自定义标签 END
        //global $DiyTagOutputStr;
       // $DiyTagOutputStr[]=$OutputStr;
        return SmartyOutputStr($this,$compiler,$_attr,'ltjoblist',$name,$OutputStr,$name);
    }
}
class Smarty_Internal_Compile_Ltjoblistelse extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('ltjoblist'));
        $this->openTag($compiler, 'ltjoblistelse', array('ltjoblistelse', $nocache, $item, $key));

        return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
    }
}
class Smarty_Internal_Compile_Ltjoblistclose extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('ltjoblist', 'ltjoblistelse'));

        return "<?php } ?>";
    }
}
