<?php
/**
sphinx 辅助类
*/
class sphinxhelper
{
  //生成sphinx.conf 文件
  public function generateConf()
  {
    global $config, $db_config;
    $config['sphinx_path'] = rtrim($config['sphinx_path'], '/');
    $config['sphinx_path'] = rtrim($config['sphinx_path'], "\\");

    $content = <<<str
source common
{
  type      = mysql
  sql_host    = {$db_config['dbhost']}
  sql_user    = {$db_config['dbuser']}
  sql_pass    = {$db_config['dbpass']}
  sql_db      = {$db_config['dbname']}
  sql_port    = 3306

  sql_query_pre   = SET NAMES utf8
  
  sql_ranged_throttle = 0
}

index common
{
  path      = {$config['sphinx_path']}/data/common

  #charset_type = utf-8
  
  charset_table = 0..9, A..Z->a..z, _, a..z, U+410..U+42F->U+430..U+44F, U+430..U+44F
  
  #一元分词
  ngram_len = 1
  
  #中文分词
  ngram_chars = U+3000..U+2FA1F
  
  docinfo     = extern

  dict      = keywords

  mlock     = 0

  #morphology   = none
  morphology    = stem_en
  
  min_word_len    = 1


  html_strip    = 0
  
  expand_keywords = 1
}

source company_job : common
{
  sql_query   = \
    SELECT id, name, com_name, \
      did, uid, edate, state, sdate, rec_time, r_status, status, pr, hy, job1, job1_son, job_post, \
      provinceid, cityid, three_cityid, edu, exp, report, type, sex, is_graduate, mun, \
      maxsalary, minsalary, urgent_time, lastupdate, \
      com_provinceid, xsdate \
      FROM {$db_config['def']}company_job
      
  sql_attr_uint = did
  sql_attr_uint = uid
  
  sql_attr_uint = job1  
  sql_attr_uint = job1_son
  sql_attr_uint = job_post
  
  sql_attr_uint = com_provinceid
  sql_attr_uint = provinceid
  sql_attr_uint = cityid
  sql_attr_uint = three_cityid
  
  sql_attr_uint = hy
  sql_attr_timestamp = sdate
  sql_attr_timestamp = rec_time
  sql_attr_uint = r_status
  sql_attr_uint = status
  sql_attr_uint = pr
  sql_attr_uint = edu
  sql_attr_uint = exp
  sql_attr_uint = report
  sql_attr_uint = type
  sql_attr_uint = sex
  sql_attr_uint = is_graduate
  sql_attr_uint = mun
  
  sql_attr_uint = minsalary
  sql_attr_uint = maxsalary
  
  sql_attr_timestamp = edate
  sql_attr_uint = state
  sql_attr_timestamp = xsdate
  sql_attr_timestamp = lastupdate
  sql_attr_uint = urgent_time
  
  # sql_attr_string = com_name
}

source company_job_add : company_job
{
  sql_query   = \
    SELECT id, name, com_name, \
      did, uid, edate, state, sdate, rec_time, r_status, status, pr, hy, job1, job1_son, job_post, \
      provinceid, cityid, three_cityid, edu, exp, report, type, sex, is_graduate, mun, \
      maxsalary, minsalary, urgent_time, lastupdate, \
      com_provinceid, xsdate \
      FROM {$db_config['def']}company_job \
      where id > (select config from {$db_config['def']}admin_config where name='company_job_max_id' limit 1)
}

index company_job : common
{
  source      = company_job
  path      = {$config['sphinx_path']}/data/company_job
}

index company_job_add : common
{
  source      = company_job_add
  path      = {$config['sphinx_path']}/data/company_job_add
}

source resume_expect : common
{
  sql_query   = \
    SELECT id, uid, name, hy, hy != '' as hy_not_empty, job_classid, provinceid, cityid, three_cityid, \
      salary, jobstatus, type, report, defaults, is_entrust, doc, \
      hits, lastupdate, cloudtype, integrity, height_status, \
      statusbody, status_time, rec, top, topdate, rec_resume, source, \
      tmpid, ctime, dnum, did, uname, uname != '' as uname_not_empty, idcard_status, \
      status, r_status, edu, exp, sex, photo != '' as photo_not_empty, phototype, birthday, minsalary, maxsalary, \
      whour, avghour, label \
      FROM {$db_config['def']}resume_expect

  sql_attr_uint = did
  sql_attr_uint = uid
  sql_attr_uint = hy
  sql_field_string = job_classid
  sql_attr_uint = provinceid
  sql_attr_uint = cityid
  sql_attr_uint = three_cityid
    
  sql_attr_uint = r_status
  sql_attr_uint = status
  
  sql_attr_uint = edu
  sql_attr_uint = exp
  sql_attr_uint = report
  sql_attr_uint = type
  sql_attr_uint = sex
  

  sql_attr_uint = defaults
  sql_attr_uint = height_status
  sql_attr_uint = topdate
  sql_attr_uint = rec_resume
  
  sql_attr_timestamp = lastupdate
  
  #sql_field_string = name
  #sql_attr_string  = name
  
  #sql_attr_multi = string job_classid_multi from field job_classid
  
  sql_attr_uint = photo_not_empty
  sql_attr_uint = uname_not_empty
  sql_attr_uint = hy_not_empty
  
  sql_attr_uint = minsalary
  sql_attr_uint = maxsalary
}


source resume_expect_add : resume_expect
{
  sql_query   = \
    SELECT id, uid, name, hy, hy != '' as hy_not_empty, job_classid, provinceid, cityid, three_cityid, \
      salary, jobstatus, type, report, defaults, is_entrust, doc, \
      hits, lastupdate, cloudtype, integrity, height_status, \
      statusbody, status_time, rec, top, topdate, rec_resume, source, \
      tmpid, ctime, dnum, did, uname, uname != '' as uname_not_empty, idcard_status, \
      status, r_status, edu, exp, sex, photo != '' as photo_not_empty, phototype, birthday, minsalary, maxsalary, \
      whour, avghour, label \
      FROM {$db_config['def']}resume_expect \
      where id > (select config from {$db_config['def']}admin_config where name='resume_expect_max_id' limit 1)
}

index resume_expect : common
{
  source      = resume_expect
  path      = {$config['sphinx_path']}/data/resume_expect
}
index resume_expect_add : common
{
  source      = resume_expect_add
  path      = {$config['sphinx_path']}/data/resume_expect_add
}

source once_job : common
{
  sql_query   = \
    SELECT id, did, status, edate, ctime, title, companyname \
      FROM {$db_config['def']}once_job

  sql_attr_uint = did
  sql_attr_uint = status
  sql_attr_uint = edate
  sql_attr_uint = ctime
}

source once_job_add : once_job
{
  sql_query   = \
    SELECT id, did, status, edate, ctime, title, companyname \
      FROM {$db_config['def']}once_job \
      where id > (select config from {$db_config['def']}admin_config where name='once_job_max_id' limit 1)
}

index once_job : common
{
  source      = once_job
  path      = {$config['sphinx_path']}/data/once_job
}
index once_job_add : common
{
  source      = once_job_add
  path      = {$config['sphinx_path']}/data/once_job_add
}

source resume_tiny : common
{
  sql_query   = \
    SELECT id, did, status, username, job, lastupdate \
      FROM {$db_config['def']}resume_tiny

  sql_attr_uint = did
  sql_attr_uint = status
  sql_attr_uint = lastupdate
}

source resume_tiny_add : resume_tiny
{
  sql_query   = \
    SELECT id, did, status, username, job, lastupdate \
      FROM {$db_config['def']}resume_tiny \
      where id > (select config from {$db_config['def']}admin_config where name='resume_tiny_max_id' limit 1)
}

index resume_tiny : common
{
  source      = resume_tiny
  path      = {$config['sphinx_path']}/data/resume_tiny
}
index resume_tiny_add : common
{
  source      = resume_tiny_add
  path      = {$config['sphinx_path']}/data/resume_tiny_add
}

source news_base : common
{
  sql_query   = \
    SELECT id, did, nid, \
      FIND_IN_SET('t', `describe`) as describe_t, \
      FIND_IN_SET('tj', `describe`) as describe_tj, \
      FIND_IN_SET('indextj', `describe`) as describe_indextj, \
      FIND_IN_SET('db', `describe`) as describe_db, \
      newsphoto != '' newsphoto_not_empty, \
      title, \
      datetime, hits \
      FROM {$db_config['def']}news_base

  sql_attr_uint = did
  sql_attr_uint = nid
  sql_attr_uint = describe_t
  sql_attr_uint = describe_tj
  sql_attr_uint = describe_indextj
  sql_attr_uint = describe_db
  sql_attr_uint = newsphoto_not_empty
  sql_attr_uint = datetime
  sql_attr_uint = hits
}

source news_base_add : news_base
{
  sql_query   = \
    SELECT id, did, nid, \
      FIND_IN_SET('t', `describe`) as describe_t, \
      FIND_IN_SET('tj', `describe`) as describe_tj, \
      FIND_IN_SET('indextj', `describe`) as describe_indextj, \
      FIND_IN_SET('db', `describe`) as describe_db, \
      newsphoto != '' newsphoto_not_empty, \
      title, \
      datetime, hits \
      FROM {$db_config['def']}news_base \
      where id > (select config from {$db_config['def']}admin_config where name='news_base_max_id' limit 1)
}

index news_base : common
{
  source      = news_base
  path      = {$config['sphinx_path']}/data/news_base
}
index news_base_add : common
{
  source      = news_base_add
  path      = {$config['sphinx_path']}/data/news_base_add
}

source partjob : common
{
  sql_query   = \
    SELECT id, did state, r_status, name, \
      provinceid, cityid, three_cityid, rec_time, type, \
      billing_cycle, lastupdate \
      FROM {$db_config['def']}partjob

  sql_attr_uint = did
  sql_attr_uint = state
  sql_attr_uint = r_status
  sql_attr_uint = rec_time
  sql_attr_uint = type
  sql_attr_uint = billing_cycle
  
  sql_attr_uint = provinceid
  sql_attr_uint = cityid
  sql_attr_uint = three_cityid
  sql_attr_uint = lastupdate
}

source partjob_add : partjob
{
  sql_query   = \
    SELECT id, did, state, r_status, name, \
      provinceid, cityid, three_cityid, rec_time, type, \
      billing_cycle, lastupdate \
      FROM {$db_config['def']}partjob \
      where id > (select config from {$db_config['def']}admin_config where name='partjob_max_id' limit 1)
}

index partjob : common
{
  source      = partjob
  path      = {$config['sphinx_path']}/data/partjob
}
index partjob_add : common
{
  source      = partjob_add
  path      = {$config['sphinx_path']}/data/partjob_add
}

source company : common
{
  sql_query   = \
    SELECT uid, did, name, hy, pr, mun, \
      provinceid, cityid, three_cityid, \
      r_status, yyzz_status, \
      lastupdate, jobtime, rec, hottime, \
      name != '' as name_not_empty, \
      hy != '' as hy_not_empty, \
      logo != '' as logo_not_empty, \
      linkman != '' as linkman_not_empty, \
      linktel != '' as linktel_not_empty, \
      linkmail != '' as linkmail_not_empty, \
      jobtime != '' as jobtime_not_empty \
      FROM {$db_config['def']}company

  sql_attr_uint = did
  sql_attr_uint = hy
  sql_attr_uint = pr
  sql_attr_uint = mun
  # sql_attr_uint = uid
  sql_attr_uint = provinceid
  sql_attr_uint = cityid
  sql_attr_uint = three_cityid
  sql_attr_uint = r_status
  sql_attr_uint = yyzz_status
  sql_attr_uint = lastupdate
  sql_attr_uint = jobtime
  sql_attr_uint = rec
  sql_attr_uint = hottime
  
  sql_attr_uint = name_not_empty
  sql_attr_uint = hy_not_empty
  sql_attr_uint = logo_not_empty
  sql_attr_uint = linkman_not_empty
  sql_attr_uint = linktel_not_empty
  sql_attr_uint = linkmail_not_empty
  sql_attr_uint = jobtime_not_empty
}

source company_add : company
{
  sql_query   = \
    SELECT uid, did, name, hy, pr, mun, \
      provinceid, cityid, three_cityid, \
      r_status, yyzz_status, \
      lastupdate, jobtime, rec, hottime, \
      name != '' as name_not_empty, \
      hy != '' as hy_not_empty, \
      logo != '' as logo_not_empty, \
      linkman != '' as linkman_not_empty, \
      linktel != '' as linktel_not_empty, \
      linkmail != '' as linkmail_not_empty, \
      jobtime != '' as jobtime_not_empty \
      FROM {$db_config['def']}company \
      where uid > (select config from {$db_config['def']}admin_config where name='company_max_id' limit 1)
}

index company : common
{
  source      = company
  path      = {$config['sphinx_path']}/data/company
}
index company_add : common
{
  source      = company_add
  path      = {$config['sphinx_path']}/data/company_add
}
#############################################################################
## indexer settings
#############################################################################
indexer
{
  mem_limit   = 128M
}

#############################################################################
## searchd settings
#############################################################################
searchd
{ 
  # expansion_limit = 1
  
  listen      = 9312
  listen      = 9306:mysql41

  log     = {$config['sphinx_path']}/log/searchd.log

  query_log   = {$config['sphinx_path']}/log/query.log

  # client read timeout, seconds
  # optional, default is 5
  read_timeout    = 5

  # request timeout, seconds
  # optional, default is 5 minutes
  client_timeout    = 300

  max_children    = 30

  persistent_connections_limit  = 30

  pid_file    = {$config['sphinx_path']}/log/searchd.pid

  seamless_rotate   = 1

  preopen_indexes   = 1

  unlink_old    = 1

  mva_updates_pool  = 1M

  max_packet_size   = 8M

  max_filters   = 256

  max_filter_values = 4096

  max_batch_queries = 32

  workers     = threads # for RT to work
}
str;
    
    //linux中涉及权限问题，不可在 /home/wwwroot/www.job.com/ 目录之外操作文件，所以利用sh文件来执行
    if(isServerOsWindows() === false){
      $content = str_replace("\r\n", PHP_EOL, $content);
      
      // file_put_contents($config['sphinx_path'] . '/sphinx.conf', $content);
      file_put_contents(APP_PATH . 'data/sphinx/sphinx.conf', $content);

      $shPath = APP_PATH . 'data/sphinx/mkdir.sh';
      $s0 = APP_PATH . 'data/sphinx/sphinx.conf';
      $s1 = $config['sphinx_path'] . '/sphinx.conf';
      exec("sh $shPath $s0 $s1");
    }
    else{
      file_put_contents($config['sphinx_path'] . '/bin/sphinx.conf', $content);
    }

    // if(!is_dir($config['sphinx_path'] . '/data/')){
    //   mkdir($config['sphinx_path'] . '/data/', 777, true);
    // }
    
    // if(!is_dir($config['sphinx_path'] . '/log/')){
    //   mkdir($config['sphinx_path'] . '/log/', 777, true);
    // }

    
  }
}