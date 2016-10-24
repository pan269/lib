<?php
/**
* 加密
*/
class Encrypt
{
	private $php_key_a = 'pan123'; 

	private $php_key_b = 'pan123'; 

	private $des3_iv = 'iv123223'; // 3des iv 长度为8  
	private $des3_key = 'key12333333sss';   

	private $des_iv = 'iv123223'; // des iv 长度为8  
	private $des_key = 'key12345';  //des key 长度为8 

	private $aes_cipher = MCRYPT_RIJNDAEL_128;   
    private $aes_mode = MCRYPT_MODE_ECB;  
    private $aes_key = 'key11133key11133';  //key 长度16, 24 or 32 


    private $rsa_priv = '-----BEGIN RSA PRIVATE KEY-----  
MIICXQIBAAKBgQC3//sR2tXw0wrC2DySx8vNGlqt3Y7ldU9+LBLI6e1KS5lfc5jl  
TGF7KBTSkCHBM3ouEHWqp1ZJ85iJe59aF5gIB2klBd6h4wrbbHA2XE1sq21ykja/  
Gqx7/IRia3zQfxGv/qEkyGOx+XALVoOlZqDwh76o2n1vP1D+tD3amHsK7QIDAQAB  
AoGBAKH14bMitESqD4PYwODWmy7rrrvyFPEnJJTECLjvKB7IkrVxVDkp1XiJnGKH  
2h5syHQ5qslPSGYJ1M/XkDnGINwaLVHVD3BoKKgKg1bZn7ao5pXT+herqxaVwWs6  
ga63yVSIC8jcODxiuvxJnUMQRLaqoF6aUb/2VWc2T5MDmxLhAkEA3pwGpvXgLiWL  
3h7QLYZLrLrbFRuRN4CYl4UYaAKokkAvZly04Glle8ycgOc2DzL4eiL4l/+x/gaq  
deJU/cHLRQJBANOZY0mEoVkwhU4bScSdnfM6usQowYBEwHYYh/OTv1a3SqcCE1f+  
qbAclCqeNiHajCcDmgYJ53LfIgyv0wCS54kCQAXaPkaHclRkQlAdqUV5IWYyJ25f  
oiq+Y8SgCCs73qixrU1YpJy9yKA/meG9smsl4Oh9IOIGI+zUygh9YdSmEq0CQQC2  
4G3IP2G3lNDRdZIm5NZ7PfnmyRabxk/UgVUWdk47IwTZHFkdhxKfC8QepUhBsAHL  
QjifGXY4eJKUBm3FpDGJAkAFwUxYssiJjvrHwnHFbg0rFkvvY63OSmnRxiL4X6EY  
yI9lblCsyfpl25l7l5zmJrAHn45zAiOoBrWqpM5edu7c  
-----END RSA PRIVATE KEY-----';  
  
 	private $rsa_pub = '-----BEGIN PUBLIC KEY-----  
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC3//sR2tXw0wrC2DySx8vNGlqt  
3Y7ldU9+LBLI6e1KS5lfc5jlTGF7KBTSkCHBM3ouEHWqp1ZJ85iJe59aF5gIB2kl  
Bd6h4wrbbHA2XE1sq21ykja/Gqx7/IRia3zQfxGv/qEkyGOx+XALVoOlZqDwh76o  
2n1vP1D+tD3amHsK7QIDAQAB  
-----END PUBLIC KEY-----';  
	
	function __construct()
	{
		
	}
	
	/**
	 * [phpEncryptA description]
	 * @功能: php 加密
	 * @Author:未知
	 * @DateTime:2016-07-02T09:43:46+0800
	 * @param                             [type] $data [description]
	 * @return                            [type]       [description]
	 */
	public function phpEncryptA($data)  
	{  
	    $key    = md5($this->php_key_a);  
	    $x      = 0;  
	    $len    = strlen($data);  
	    $l      = strlen($key); 
	    $char 	= ''; 
	    $str 	= '';
	    for ($i = 0; $i < $len; $i++)  
	    {  
	        if ($x == $l)   
	        {  
	            $x = 0;  
	        }  
	        $char .= $key{$x};  
	        $x++;  
	    }  
	    for ($i = 0; $i < $len; $i++)  
	    {  
	        $str .= chr(ord($data{$i}) + (ord($char{$i})) % 256);  
	    }  
	    return base64_encode($str);  
	}  

	/**
	 * [phpDecryptA description]
	 * @功能: php解密
	 * @Author:未知
	 * @DateTime:2016-07-02T09:44:04+0800
	 * @param                             [type] $data [description]
	 * @return                            [type]       [description]
	 */
	public static function phpDecryptA($data)  
	{  
	    $key    = md5($this->php_key_a);  
	    $x 		= 0;  
	    $data 	= base64_decode($data);  
	    $len 	= strlen($data);  
	    $l 		= strlen($key); 
	    $char 	= ''; 
	    $str 	= '';
	    for ($i = 0; $i < $len; $i++)  
	    {  
	        if ($x == $l)   
	        {  
	            $x = 0;  
	        }  
	        $char .= substr($key, $x, 1);  
	        $x++;  
	    }  
	    for ($i = 0; $i < $len; $i++)  
	    {  
	        if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1)))  
	        {  
	            $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));  
	        }  
	        else  
	        {  
	            $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));  
	        }  
	    }  
	    return $str;  
	} 

	/**
	 * [phpEncryptB description]
	 * @功能: php 加密
	 * @Author:pz
	 * @DateTime:2016-07-02T11:21:46+0800
	 * @param                             [type] $str [description]
	 * @return                            [type]      [description]
	 */
	public function phpEncryptB($str){ //加密函数
		srand((double)microtime() * 1000000);
		$encrypt_key=md5(rand(0, 32000));
		$ctr=0;
		$tmp='';
		for($i=0;$i<strlen($str);$i++){
			$ctr=$ctr==strlen($encrypt_key)?0:$ctr;
			$tmp.=$encrypt_key[$ctr].($str[$i] ^ $encrypt_key[$ctr++]);
		}
		return base64_encode($this->_phpBKey($tmp,$php_key_b));
	} 

	/**
	 * [passport_decrypt description]
	 * @功能:php解密函数
	 * @Author:pz
	 * @DateTime:2016-07-02T11:22:08+0800
	 * @param                             [type] $str [description]
	 * @param                             [type] $key [description]
	 * @return                            [type]      [description]
	 */
	public function phpDecryptB($str){ 
		$str=$this->_phpBKey(base64_decode($str),$php_key_b);
		$tmp='';
		for($i=0;$i<strlen($str);$i++){
			$md5=$str[$i];
			$tmp.=$str[++$i] ^ $md5;
		}
		return $tmp;
	}

	private function _phpBKey($str,$encrypt_key){
		$encrypt_key=md5($encrypt_key);
		$ctr=0;
		$tmp='';
		for($i=0;$i<strlen($str);$i++){
			$ctr=$ctr==strlen($encrypt_key)?0:$ctr;
			$tmp.=$str[$i] ^ $encrypt_key[$ctr++];
		}
		return $tmp;
	}

	/**
	 * [des3Encrypt description]
	 * @功能: 3des 加密
	 * @Author:幻想曲.NET
	 * @DateTime:2016-07-02T09:46:42+0800
	 */
	public function des3Encrypt($value)
	{
		$td = mcrypt_module_open(MCRYPT_3DES, '', MCRYPT_MODE_CBC, '');  
        $iv = $this->des3_iv;  
        $key = $this->des3_key;  
        $value = $this->_desPaddingPKCS7($value);  
        mcrypt_generic_init($td, $key, $iv);  
        $ret = base64_encode(mcrypt_generic($td, $value));  
        mcrypt_generic_deinit($td);  
        mcrypt_module_close($td);  
        return $ret;  
		# code...
	}

	/**
	 * [des3Decrypt description]
	 * @功能: 3des 加密
	 * @Author:幻想曲.NET
	 * @DateTime:2016-07-02T09:46:42+0800
	 */
    public function des3Decrypt($value)  
    {  
        $td = mcrypt_module_open(MCRYPT_3DES, '', MCRYPT_MODE_CBC, '');  
        $iv = $this->des3_iv;  
        $key = $this->des3_key;  
        mcrypt_generic_init($td, $key, $iv);  
        $ret = trim(mdecrypt_generic($td, base64_decode($value)));  
        $ret = $this->_UnPaddingPKCS7($ret);  
        mcrypt_generic_deinit($td);  
        mcrypt_module_close($td);  
        return $ret;  
    }  

    /**
     * [_desPaddingPKCS7 description]
     * @功能:辅助3des 加密
     * @Author:pz
     * @DateTime:2016-07-02T11:26:08+0800
     * @param                             [type] $data [description]
     * @return                            [type]       [description]
     */
	private function _desPaddingPKCS7($data)  
    {  
        $block_size = mcrypt_get_block_size('tripledes', 'cbc');  
        $padding_char = $block_size - (strlen($data) % $block_size);  
        $data .= str_repeat(chr($padding_char), $padding_char);  
        return $data;  
    }  
  	
  	/**
  	 * [_UnPaddingPKCS7 description]
  	 * @功能: 辅助3des解密
  	 * @Author:pz
  	 * @DateTime:2016-07-02T11:26:45+0800
  	 * @param                             [type] $text [description]
  	 * @return                            [type]       [description]
  	 */
    private function _UnPaddingPKCS7($text)  
    {  
        $pad = ord($text{strlen($text) - 1});  
        if ($pad > strlen($text)) {  
            return false;  
        }  
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {  
            return false;  
        }  
        return substr($text, 0, -1 * $pad);  
    }  


    /**
     * [desEncrypt description]
     * @功能:des加密
     * @Author:pz
     * @DateTime:2016-07-02T11:30:03+0800
     * @param                             [type] $str [description]
     * @return                            [type]      [description]
     */
	function desEncrypt($str) {
		//加密，返回大写十六进制字符串
		$size = mcrypt_get_block_size ( MCRYPT_DES, MCRYPT_MODE_CBC );
		$str = $this->_pkcs5Pad ( $str, $size );
		return strtoupper( bin2hex( mcrypt_cbc(MCRYPT_DES, $this->des_key, $str, MCRYPT_ENCRYPT, $this->des_iv ) ) );
	}

	/**
	 * [desDecrypt description]
	 * @功能:des解密
	 * @Author:pz
	 * @DateTime:2016-07-02T11:30:11+0800
	 * @param                             [type] $str [description]
	 * @return                            [type]      [description]
	 */
	function desDecrypt($str) {
		//解密
		$strBin = $this->_hex2bin( strtolower( $str ) );
		$str = mcrypt_cbc( MCRYPT_DES, $this->des_key, $strBin, MCRYPT_DECRYPT, $this->des_iv );
		$str = $this->_pkcs5Unpad( $str );
		return $str;
	}

	/**
	 * [_hex2bin description]
	 * @功能:辅助des解密
	 * @Author:pz
	 * @DateTime:2016-07-02T11:30:38+0800
	 * @param                             [type] $hexData [description]
	 * @return                            [type]          [description]
	 */
	private function _hex2bin($hexData) {
		$binData = "";
		for($i = 0; $i < strlen ( $hexData ); $i += 2) {
			$binData .= chr ( hexdec ( substr ( $hexData, $i, 2 ) ) );
		}
		return $binData;
	}

	/**
	 * [_pkcs5Pad description]
	 * @功能:辅助des加密
	 * @Author:pz
	 * @DateTime:2016-07-02T11:31:04+0800
	 * @param                             [type] $text      [description]
	 * @param                             [type] $blocksize [description]
	 * @return                            [type]            [description]
	 */
	function _pkcs5Pad($text, $blocksize) {
		$pad = $blocksize - (strlen ( $text ) % $blocksize);
		return $text . str_repeat ( chr ( $pad ), $pad );
	}

	/**
	 * [_pkcs5Unpad description]
	 * @功能:辅助des解密
	 * @Author:pz
	 * @DateTime:2016-07-02T11:31:35+0800
	 * @param                             [type] $text [description]
	 * @return                            [type]       [description]
	 */
	function _pkcs5Unpad($text) {
		$pad = ord ( $text {strlen ( $text ) - 1} );
		if ($pad > strlen ( $text )){
			return false;
		}
		if (strspn ( $text, chr ( $pad ), strlen ( $text ) - $pad ) != $pad){
			return false;
		}
		return substr ( $text, 0, - 1 * $pad );
	}




	/**
	 * [aesEncrypt description]
	 * @功能:aes加密
	 * @Author:pz
	 * @DateTime:2016-07-02T11:35:50+0800
	 * @param                             [type] $str [description]
	 * @return                            [type]      [description]
	 */
    public function aesEncrypt($str){  
        $iv = mcrypt_create_iv(mcrypt_get_iv_size($this->aes_cipher,$this->aes_mode),MCRYPT_RAND);  
        return mcrypt_encrypt($this->aes_cipher, $this->aes_key, $str, $this->aes_mode, $iv);  
    }  
      
    /**
     * [decode description]
     * @功能:aes解密
     * @Author:pz
     * @DateTime:2016-07-02T11:36:15+0800
     * @param                             [type] $str [description]
     * @return                            [type]      [description]
     */
    public function aesDecrypt($str){  
        $iv = mcrypt_create_iv(mcrypt_get_iv_size($this->aes_cipher,$this->aes_mode),MCRYPT_RAND);  
        return mcrypt_decrypt($this->aes_cipher, $this->aes_key, $str, $this->aes_mode, $iv);  
    }  


    public function rsaEncrypt($str){
    	openssl_private_encrypt($str,$encrypted,$this->rsa_priv);
    	return base64_encode($encrypted);
    }


    public function rsaDecrypt($str){
    	# code...
    	openssl_public_decrypt(base64_decode($str),$decrypted,$this->rsa_pub);
    	return $decrypted;
    }

    private function _rsaPrivKey(){
    	return openssl_pkey_get_private($this->rsa_priv);
    }

    private function _rsaPubKey(){
    	return openssl_pkey_get_public($this->rsa_pub);
    }
}