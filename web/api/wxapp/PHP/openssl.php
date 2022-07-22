<?php
class OpensslCrypt{
	private $key;
	private $iv;
	public function OpensslCrypt($key,$iv = ''){
		$this->key = $key;
		$this->iv  = $iv;
	}
	/**
	 * 加密
	 */
	public function encrypt($id){
		$id=serialize($id);
		$data['iv']=base64_encode(substr('phpyun45;rencaiwangxcx',0,16));
		$data['value']=openssl_encrypt($id, 'AES-256-CBC',$this->key,0,base64_decode($data['iv']));
		$encrypt=base64_encode(json_encode($data));
		return $encrypt;
	}
	/**
	 * 解密
	 */
	public function decrypt($encrypt){
		$encrypt = json_decode(base64_decode($encrypt), true);
		$iv = base64_decode($encrypt['iv']);
		$decrypt = openssl_decrypt($encrypt['value'], 'AES-256-CBC', $this->key, 0, $iv);
		$id = unserialize($decrypt);
		if($id){
			return $id;
		}else{
			return 0;
		}
	}
	/**
	 * 解密 AES-128-CBC
	 */
	public function miniDecrypt($encrypt)
	{
	    $decrypt = openssl_decrypt($encrypt,'AES-128-CBC',$this->key,0,$this->iv);
	    if($decrypt){
	        return $decrypt;
	    }else{
	        return 0;
	    }
	}
}
?>