<?php
class Wx_js_api_pay {
	public $KEY = null;
    public function __construct($setting){
        $this->KEY = $setting['pem_key'];
    }
	public function GetJsApiParameters($UnifiedOrderResult)
	{
		if(!array_key_exists("appid", $UnifiedOrderResult)
		|| !array_key_exists("prepay_id", $UnifiedOrderResult)
		|| $UnifiedOrderResult['prepay_id'] == "")
		{
			die("参数错误");
		}
		$jsapi = array();
		$jsapi['appId'] = $UnifiedOrderResult["appid"];
		$timeStamp = time();
		$jsapi['timeStamp'] = "$timeStamp";
		$jsapi['nonceStr'] = $this->getNonceStr();
		$jsapi['package'] = 'prepay_id=' . $UnifiedOrderResult['prepay_id'];
		$jsapi['signType'] = 'MD5';
		$jsapi['paySign'] = $this->MakeSign($jsapi);
		$parameters = json_encode($jsapi);
		return $parameters;
	}
	public function unifiedOrder($order) {
		$url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
		$xml = $this->ToXml($order);
		$http = new Http;
        $return = $http->post($url,$xml);
        libxml_disable_entity_loader(true);
        $result = json_decode(json_encode(simplexml_load_string($return, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		return $result;
	}
    public function orderQuery($order) {
		$url = "https://api.mch.weixin.qq.com/pay/orderquery";
		$xml = $this->ToXml($order);
		$http = new Http;
        $return = $http->post($url,$xml);
        libxml_disable_entity_loader(true);
        $result = json_decode(json_encode(simplexml_load_string($return, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			return true;
		}
		return false;
	}
	/**
	 * 
	 * 产生随机字符串，不长于32位
	 * @param int $length
	 * @return 产生的随机字符串
	 */
	public function getNonceStr($length = 32) {
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789";  
		$str ="";
		for ( $i = 0; $i < $length; $i++ )  {  
			$str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
		} 
		return $str;
	}
    /**
	 * 生成签名
	 * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
	 */
    public function MakeSign($values) {
		ksort($values);
		$string = $this->ToUrlParams($values);
		$string = $string . "&key=".$this->KEY;
		$string = md5($string);
		$result = strtoupper($string);
		return $result;
	}
    /**
	 * 格式化参数格式化成url参数
	 */
	public function ToUrlParams($values) {
		$buff = "";
		foreach ($values as $k => $v) {
			if($k != "sign" && $v != "" && !is_array($v)){
				$buff .= $k . "=" . $v . "&";
			}
		}
		$buff = trim($buff, "&");
		return $buff;
	}
    public function ToXml($values) {
		if(!is_array($values) || count($values) <= 0) {
    		return '';
    	}
    	$xml = "<xml>";
    	foreach ($values as $key=>$val) {
    		if (is_numeric($val)){
    			$xml.="<".$key.">".$val."</".$key.">";
    		}else{
    			$xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
    		}
        }
        $xml.="</xml>";
        return $xml; 
	}
}