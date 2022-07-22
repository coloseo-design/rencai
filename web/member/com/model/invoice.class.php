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
class invoice_controller extends company
{
	function index_action(){
		include(CONFIG_PATH."db.data.php");
		$this	->	yunset("arr_data",$arr_data);
		$this	->	public_action();
		$this	->	company_satic();
		$urlarr	=	array("c"=>"invoice","page"=>"{{page}}");
		$pageurl=	Url('member',$urlarr);
		$where['uid']		=	$this	->	uid;
		$where['orderby']	=	'addtime,desc';

		$pageM		=	$this  -> MODEL('page');
		$pages		=	$pageM -> pageList('invoice_record',$where,$pageurl,$_GET['page']);

		if($pages['total'] > 0){
		    $invoiceM			=	$this  -> MODEL('invoice');
		    $where['limit']		=	$pages['limit'];
		    $rows				=	$invoiceM	->	getRecordList($where,array('utype'=>'member'));
		    $this	->	yunset("rows",$rows);
		}

		$this	->	com_tpl('invoice');
	}
	//发票索取列表页
	function apply_action(){
		
 		include(CONFIG_PATH."db.data.php");
		$this	->	yunset("arr_data",$arr_data);
		$this	->	public_action();
		$urlarr	=	array("c"=>"invoice","act"=>"apply","page"=>"{{page}}");
		$pageurl=	Url('member',$urlarr);
		$where	=	array(
			'uid'			=>	$this	->	uid,
			'usertype'		=>	$this	->	usertype,
			'order_state'	=>	2,
			'is_invoice'	=>	'0',
		);
		if($this->config['sy_com_invoice_money']){
			$where['order_price']	=	array('>=',$this->config['sy_com_invoice_money']);
		}else{
			$where['order_price']	=	array('>',0);
		}
		$where['orderby']		=	'order_time,desc';
		$invoiceM	=	$this  -> MODEL('invoice');
		$pageM		=	$this  -> MODEL('page');
		$pages		=	$pageM -> pageList('company_order',$where,$pageurl,$_GET['page']);

		if($pages['total'] > 0){
		    $orderM				=	$this  -> MODEL('companyorder');
		    $where['limit']		=	$pages['limit'];
		    $rows				=	$orderM	->	getList($where,array('invoice'=>1));
		    $this	->	yunset("rows",$rows);
		}

		$invoice	=	$invoiceM	->	getInvoiceInfo(array('uid'=>$this->uid));
		$this		->	yunset("invoice",$invoice);
		
		if($_POST['submit']){
			$orderIds				=	@explode(',',$_POST['order_id']);
			$orderIds 				= 	pylode(',',$orderIds);
			$value['order_id']		=	$orderIds;
			
			$value['price']			=	$_POST['order_price'];
			$value['uid']			=	$this->uid;
			$value['did']			=	$this->userdid;
			
			$value['title']			=	trim($invoice['invoicetitle']);
			$value['type']			=	trim($invoice['invoicetype']);
			$value['invoice_id']	=	trim($invoice['registerno']);
			
			$value['bankno']		=	trim($invoice['bankno']);
			$value['bank']			=	trim($invoice['bank']);
			$value['opaddress']		=	trim($invoice['opaddress']);
			$value['opphone']		=	trim($invoice['opphone']);
			
			$value['style']			=	trim($invoice['invoicestyle']);
			
			$value['link_man']		=	trim($invoice['linkman']);
			$value['link_moblie']	=	trim($invoice['phone']);
			$value['address']		=	trim($invoice['street']);
			$value['email']			=	trim($invoice['email']);
			$value['status']		=	'0';
			$value['addtime']		=	time();
			$return	=	$invoiceM	->	addRecord($value,array('uid'=>$this->uid));
			
			$this	->	ACT_layer_msg($return['msg'],$return['cod'],$_SERVER['HTTP_REFERER']);
		}
		
		
		$this	->	com_tpl('invoice_sq');
	}
	//查看/保存发票信息
	function info_action(){
		$this		->	public_action();
		$invoiceM	=	$this	->	MODEL('invoice');
		if($_POST['submit']){
			$id			=	intval($_POST['id']);
			
			$_POST		=	$this	->	post_trim($_POST);
			$whereData	=	array();
 			$addData	=	array(
 				'uid'			=>	$this	->	uid,
 				'invoicetitle'	=>	$_POST['invoicetitle'],
 				'invoicetype'	=>	$_POST['invoicetype'],
 				'registerno'	=>	$_POST['registerno'],
 				'bank'			=>	$_POST['bank'],
 				'bankno'		=>	$_POST['bankno'],
 				'opaddress'		=>	$_POST['opaddress'],
 				'opphone'		=>	$_POST['opphone'],
 				'invoicestyle'	=>	$_POST['invoicestyle'],
 				'linkman'		=>	$_POST['linkman']
 			);
			if($_POST['invoicestyle']=='1'){
				$addData['street']	=	$_POST['street'];
				$addData['phone']	=	$_POST['phone'];
				
			}else if($_POST['invoicestyle']=='2'){
				$addData['email']	=	$_POST['email'];
			}
			if($id){
				$whereData['id']	=	$id;
				$whereData['uid']	=	$this	->	uid;
			}
			$return		=	$invoiceM	->	addInvoiceInfo($whereData,$addData);

			$this		->	ACT_layer_msg($return['msg'],$return['cod'],$return['url']);
		}
		$row	=	$invoiceM	->	getInvoiceInfo(array('uid'=>$this->uid));
		$this	->	yunset("row",$row);
		$this	->	com_tpl('invoice_info');
	}
}
?>