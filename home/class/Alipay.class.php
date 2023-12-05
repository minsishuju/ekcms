<?php
$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
$uachar = "/(nokia|sony|ericsson|mot|samsung|sgh|lg|philips|panasonic|alcatel|lenovo|cldc|midp|mobile)/i";
if(($ua == '' || preg_match($uachar, $ua)) && !strpos(strtolower($_SERVER['REQUEST_URI']),'wap')){
	class Alipay{
		public function get_pay_code($order) {
			$charset = 'utf-8';
			$gateway = 'http://wappaygw.alipay.com/service/rest.htm?';
			$req_data = '<direct_trade_create_req>'
					. '<subject>'. $order['trade_no'] .'</subject>'
					. '<out_trade_no>'. $order['trade_no'] . getRandID(4) .'</out_trade_no>'
					. '<total_fee>'. $order['price'] .'</total_fee>'
					. '<seller_account_name>'. config('alipay_account') .'</seller_account_name>'
					. '<call_back_url>'. config('SITE_URL').'notify.php' .'</call_back_url>'
					. '<notify_url>'. config('SITE_URL').'notify.php' .'</notify_url>'
					. '<merchant_url>'. config('SITE_URL') .'</merchant_url>'
					. '<pay_expire>3600</pay_expire>'
					. '</direct_trade_create_req>';
			$parameter = array(
				'service'           => 'alipay.wap.trade.create.direct', //接口名称
				'format'            => 'xml', //请求参数格式
				'v'                 => '2.0', //接口版本号
				'partner'           => config('alipay_partner'), //合作者身份ID
				'req_id'            => date('Ymdhis').rand(1000,9999), //请求号，唯一
				'sec_id'            => 'MD5', //签名方式
				'req_data'          => $req_data, //请求业务数据
				"_input_charset"	=> $charset
			);
	
			ksort($parameter);
			reset($parameter);
			$param = '';
			$sign  = '';
			foreach ($parameter AS $key => $val){
				$param .= "$key=" .urlencode($val). "&";
				$sign  .= "$key=$val&";
			}
			$param = substr($param, 0, -1);
			$sign  = substr($sign, 0, -1). config('alipay_key');
			//请求授权接口
			$result = $this->post($gateway, $param . '&sign='.md5($sign));
			$result = urldecode($result); //URL转码
			$result_array = explode('&', $result); //根据 & 符号拆分
			//重构数组
			$new_result_array = $temp_item = array();
			if(is_array($result_array)){
				foreach ($result_array as $vo){
					$temp_item = explode('=', $vo, 2); //根据 & 符号拆分
					$new_result_array[$temp_item[0]] = $temp_item[1];
				}
			}
			$xml = simplexml_load_string($new_result_array['res_data']);
			$request_token = (array)$xml->request_token;
			//请求交易接口
			$parameter = array(
				'service'           => 'alipay.wap.auth.authAndExecute', //接口名称
				'format'            => 'xml', //请求参数格式
				'v'                 => $new_result_array['v'], //接口版本号
				'partner'           => $new_result_array['partner'], //合作者身份ID
				'sec_id'            => $new_result_array['sec_id'],
				'req_data'          => '<auth_and_execute_req><request_token>'. $request_token[0] .'</request_token></auth_and_execute_req>',
				'request_token'     => $request_token[0],
				'_input_charset'    => $charset
			);
	
			ksort($parameter);
			reset($parameter);
	
			$param = '';
			$sign  = '';
			foreach ($parameter AS $key => $val)
			{
				$param .= "$key=" .urlencode($val). "&";
				$sign  .= "$key=$val&";
			}
			$param = substr($param, 0, -1);
			$sign  = substr($sign, 0, -1). config('alipay_key');
			$button = '<input type="button" onclick="window.open(\''.$gateway.$param. '&sign='.md5($sign).'\')" value="去付款" />';
			return $button;
		}
	
		public function respond() {
			if (!empty($_POST)) {
				foreach($_POST as $key => $data) {
					$_GET[$key] = $data;
				}
			}
			$order_sn = $_GET['out_trade_no'];
            $order_sn = trim($order_sn);
			$order_sn = substr($order_sn,-4);
			ksort($_GET);
			reset($_GET);
			$sign = '';
			foreach ($_GET AS $key=>$val){
				if ($key != 'sign' && $key != 'sign_type' && $key != 'code'){
					$sign .= "$key=$val&";
				}
			}
			$sign = substr($sign, 0, -1) . config('alipay_key');
			if (md5($sign) != $_GET['sign']){
				return array('','');
			}
			if ($_GET['result'] == 'success'){
				return array($order_sn,'success');
			}else{
				return array('','');
			}
		}
	}
}else{
	class alipay{
		public function get_pay_code($order){
            $charset = 'utf-8';
			$real_method = config('alipay_pay_method');
			switch ($real_method){
				case '3':
					$service = 'trade_create_by_buyer';
					break;
				case '2':
					$service = 'create_partner_trade_by_buyer';
					break;
				case '1':
					$service = 'create_direct_pay_by_user';
					break;
			}
			$extend_param = 'isv^sh22';
			$parameter = array(
				'extend_param'      => $extend_param,
				'service'           => $service,
				'partner'           => config('alipay_partner'),
				'_input_charset'    => $charset,
				'notify_url'        => config('SITE_URL').'notify.php',
				'return_url'        => config('SITE_URL').'notify.php',
				'subject'           => $order['trade_no'],
				'out_trade_no'      => $order['trade_no'] .getRandID(4),
				'price'             => $order['price'],
				'quantity'          => 1,
				'payment_type'      => 1,
				'logistics_type'    => 'EXPRESS',
				'logistics_fee'     => 0,
				'logistics_payment' => 'BUYER_PAY_AFTER_RECEIVE',
				'seller_email'      => config('alipay_account')
			);
	
			ksort($parameter);
			reset($parameter);
	
			$param = '';
			$sign  = '';
	
			foreach ($parameter AS $key => $val){
				$param .= "$key=" .urlencode($val). "&";
				$sign  .= "$key=$val&";
			}
	
			$param = substr($param, 0, -1);
			$sign  = substr($sign, 0, -1). config('alipay_key');
			$button = '<input type="button" onclick="window.open(\'https://mapi.alipay.com/gateway.do?'.$param. '&sign='.md5($sign).'&sign_type=MD5\')" value="去付款" />';
			return $button;
		}
	
		public function respond() {
			if (!empty($_POST)) {
				foreach($_POST as $key => $data) {
					$_GET[$key] = $data;
				}
			}
			$seller_email = rawurldecode($_GET['seller_email']);
			$order_sn = $_GET['out_trade_no'];
			$order_sn = trim($order_sn);
			$order_sn = substr($order_sn,-4);
			ksort($_GET);
			reset($_GET);
			$sign = '';
			foreach ($_GET AS $key=>$val){
				if ($key != 'sign' && $key != 'sign_type' && $key != 'code'){
					$sign .= "$key=$val&";
				}
			}
			$sign = substr($sign, 0, -1) . config('alipay_key');
			if (md5($sign) != $_GET['sign']){
				return array('','');
			}
	
			if ($_GET['trade_status'] == 'WAIT_SELLER_SEND_GOODS'){
				return array($order_sn,'success');
			} elseif ($_GET['trade_status'] == 'TRADE_FINISHED') {
				return array($order_sn,'success');
			} elseif ($_GET['trade_status'] == 'TRADE_SUCCESS') {
				return array($order_sn,'success');
			} else {
				return array('','');
			}
		}
	}
}