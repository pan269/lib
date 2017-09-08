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
	static public function create($data,$encrypt='')
	{
		$header = json_encode(['type'=> 'JWT','encrypt'=>$encrypt]);
		$payload = json_encode($data);
		$signature = $this->_ecrypt($header.$payload);
		return base64_encode($header).'.'.base64_encode($payload).'.'.base64_encode($signature);
	}

	//jwt验证
	static public function auth($jwt)
	{
		$_jwt = explode('.', $jwt);
		$header = base64_decode($_jwt[0]);
		$payload = base64_decode($_jwt[1]);
		$signature = base64_decode($_jwt[2]);
		$_signature = $this->_ecrypt($header.$payload);
		if($signature === $_signature){
			return true;
		}else{
			return false;
		}
	}


	private function _ecrypt($Input,$encrypt=''){
		$algos = hash_algos();
		if( $encrypt && in_array($encrypt, $algos)){
			return hash($encrypt,$Input.$this->salt);
		}else if($encrypt){
			return '';
		}else{
			$encrypt = array_rand($algos);
			return hash($encrypt,$Input.$this->salt);
		}
	}
}

?>