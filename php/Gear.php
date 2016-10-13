<?php
/**
* 
*/
class Gear
{
	
	function __construct(argument)
	{
		# code...
	}
	/**
	 * @功能:判断是否移动端访问
	 * @Author:Unknow
	 * @DateTime:2016-05-04T11:38:33+0800
	 * @return boolean
	 */
	public function isMobile()
	{
		// 如果有HTTP_X_WAP_PROFILE则一定是移动设备
		if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
		{
			return true;
		}
		// 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
		if (isset ($_SERVER['HTTP_VIA']))
		{
			// 找不到为flase,否则为true
			return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
		}
		// 脑残法，判断手机发送的客户端标志,兼容性有待提高
		if (isset ($_SERVER['HTTP_USER_AGENT']))
		{
			$clientkeywords = array ('nokia',
				'sony',
				'ericsson',
				'mot',
				'samsung',
				'htc',
				'sgh',
				'lg',
				'sharp',
				'sie-',
				'philips',
				'panasonic',
				'alcatel',
				'lenovo',
				'iphone',
				'ipod',
				'blackberry',
				'meizu',
				'android',
				'netfront',
				'symbian',
				'ucweb',
				'windowsce',
				'palm',
				'operamini',
				'operamobi',
				'openwave',
				'nexusone',
				'cldc',
				'midp',
				'wap',
				'mobile'
			);
			// 从HTTP_USER_AGENT中查找手机浏览器的关键字
			if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
			{
				return true;
			}
		}
		// 协议法，因为有可能不准确，放到最后判断
		if (isset ($_SERVER['HTTP_ACCEPT']))
		{
			// 如果只支持wml并且不支持html那一定是移动设备
			// 如果支持wml和html但是wml在html之前则是移动设备
			if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
			{
				return true;
			}
		}
		return false;
	}


	/**
	* PHP获取字符串中英文混合长度 
	* @Author:pan
	* @param $str string 字符串
	* @param $$charset string 编码
	* @return 返回长度
	*/
	static function strLength($str,$charset='utf-8')
	{
	    if($charset=='utf-8')
	    {
	        $str = iconv('utf-8','GBK',$str);
	    }
	    $num = strlen($str);
	    $cnNum = 0;
	    for($i=0;$i<$num;$i++)
	    {
	        if(ord(substr($str,$i+1,1))>127)
	        {
	            $cnNum++;
	            $i++;
	        }
	    }
	    $enNum = $num-($cnNum*2);

	    $number = $enNum+$cnNum;
	    //var_dump($number);
	    return $number;
	}

	/**
	 * 获取字符串 
	 * @Author:pan
	 *
	 * @param   string
	 * @return  string
	 */

	static function cut_str($string, $sublen, $start = 0, $code = 'UTF-8')
	{
	    if($code == 'UTF-8')
	    {
	        $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
	        preg_match_all($pa, $string, $t_string);
	        if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen));
	        return join('', array_slice($t_string[0], $start, $sublen));
	    }
	    else
	    {
	        $start = $start*2;
	        $sublen = $sublen*2;
	        $strlen = strlen($string);
	        $tmpstr = '';
	        for($i=0; $i< $strlen; $i++)
	        {
	            if($i>=$start && $i< ($start+$sublen))
	            {
	                if(ord(substr($string, $i, 1))>129)
	                {
	                    $tmpstr.= substr($string, $i, 2);
	                }
	                else
	                {
	                    $tmpstr.= substr($string, $i, 1);
	                }
	            }
	            if(ord(substr($string, $i, 1))>129) $i++;
	        }
	        //if(strlen($tmpstr)< $strlen ) $tmpstr.= "...";
	        return $tmpstr;
	    }
	}


	/**
	* 检查当前打开的终端
	* $Auther:pan
	*
	*
	*
	**/
	static function checkTerminal()
	{
	    //微信
	    if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {  
	        return 'weixin';  
	    } 

	    return 'unknown';   
	}


	static function php_write($val = '',$file = '/tmp/php_write.log',$mode = 'a+')
	{
	    $fp = fopen($file, $mode);
	    fwrite($fp,$val);
	    fclose($fp);
	}

}