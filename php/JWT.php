<?php
/**
 */
class JWT {
	private $salt = 'jsiwj23sad8';

	/**
	 * 为兼容以前的代码使用，所有方法都没变
	 */
	function __construct() {
	}

	
	//一次插入多行数据
	public function create($data,$encrypt='')
	{
		$encrypt = $this->_getEncrypt($encrypt);
		$header = json_encode(['type'=> 'JWT','encrypt'=>$encrypt]);
		$payload = json_encode($data);
		$signature = $this->_ecrypt($header.$payload,$encrypt);
		return base64_encode($header).'.'.base64_encode($payload).'.'.base64_encode($signature);
	}

	//jwt验证
	public function auth($jwt)
	{
		$res = ['code'=>200,'data'=>[]];
		$_jwt = explode('.', $jwt);
		$_header = base64_decode($_jwt[0]);
		$header = json_decode($_header,true);

		$encrypt = $header['encrypt'];

		$_payload = base64_decode($_jwt[1]);
		$payload = json_decode($_payload,true);

		$_signature = base64_decode($_jwt[2]);
		$signature = $this->_ecrypt($_header.$_payload,$encrypt);

		if($signature === $_signature){
			return ['code'=>200,'data'=>$payload];
		}else{
			return ['code'=>300,'data'=>[]];
		}
	}


	private function _getEncrypt($encrypt='')
	{
		$algos = hash_algos();
		if( $encrypt && in_array($encrypt, $algos)){
			$encrypt = $encrypt;
		}else if($encrypt){
			$encrypt = '';
		}else{
			$key = array_rand($algos,1);
			$encrypt = $algos[$key];
		}
		return $encrypt;
	}
	private function _ecrypt($Input,$encrypt){
		if($encrypt){
			return hash($encrypt,$Input.$this->salt);
		}else{
			return '';
		}
	}
}