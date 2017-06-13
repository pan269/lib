<?php

/**
* 
*/
class Gear
{
	
	function __construct()
	{
		# code...
	}
	/**
	 * @功能:判断是否移动端访问
	 * @Author:Unknow
	 * @DateTime:2016-05-04T11:38:33+0800
	 * @return boolean
	 */
	public static function isMobile()
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
	 * [write description]
	 * @功能: 写文件
	 * @Author:pz
	 * @DateTime:2016-06-29T10:57:28+0800
	 * @param                             string $val  [description]
	 * @param                             string $file [description]
	 * @param                             string $mode [description]
	 * @return                            [type]       [description]
	 */
	public static function write($val = '',$file = '/tmp/php_write.log',$mode = 'a+')
	{
		$fp = fopen($file, $mode);
		fwrite($fp,$val);
		fclose($fp);
	}

	/**
	 * [getClientIp description]
	 * @功能: 获取客户端IP
	 * @Author:pz
	 * @DateTime:2016-06-29T11:00:03+0800
	 * @return                            [type] [description]
	 */
	public static function getClientIp()
	{
		if(getenv("REMOTE_ADDR")) {
			$ip = getenv("REMOTE_ADDR");
		}elseif (getenv("HTTP_CLIENT_IP")){ 
			$ip = getenv("HTTP_CLIENT_IP"); 
		}else if(getenv("HTTP_X_FORWARDED_FOR")){ 
			$ip = getenv("HTTP_X_FORWARDED_FOR"); 
		}else {
			$ip = "Unknow"; 
		}
		return $ip; 
	}


	/**
    * PHP获取字符串中英文混合长度 
    * @param $str string 字符串
    * @param $$charset string 编码
    * @return 返回长度
    */
    public static function strLength($str,$charset='utf-8')
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
     *
     * @param   string
     * @return  string
     */

    public static function cut_str($string, $sublen, $start = 0, $code = 'UTF-8')
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

    // 重定向
    public static function redirect($url,$code='')
    {
    	switch ($code) {
    		case 301:
		    	header('HTTP/1.1 301 Moved Permanently');//发出301头部
				header('Location:'.$url);//跳转到带www的网址
		   		break;
		   	case 302:
		   		header("Location: ".$url); 
		   		break;
		   	case 404:
		    	header('HTTP/1.1 404 Not Found'); 
				header('status: 404 Not Found');
				echo "404 NOT FOUND!";
		   		break;
    		default:
		   		header("Location: ".$url); 
		   		break;
    	}
    }

    // 获取html内容
    public static function getHtmlContent($str,$start='',$end='')
    {
    	if(!$start){
            return substr($str, 0,strpos($str, $end));
    	}
        if(!$end){
            $c = strlen($start);
            return substr($str, strpos($str, $start)+$c);
        }
        $c = strlen($start);
        return substr($str, strpos($str, $start)+$c,strpos($str, $end,strpos($str, $start))-strpos($str, $start)-$c);
        # code...
    }



    /*
	* 功能: 成对匹配html标签对, 跟javascript的$.getElementById() 方法 一样.
	* 实现方法: 成对匹配html标签对(多层嵌套也能完整匹配)
	            ( 没有用到递归, 而是通过位置回退方法、顺序进行匹配 )
	* 参数: 
	    @string: $content: 输入内容; 
	    @string: $id 标签的id; 
	    @string: $return_type   设定返回值的类型,
	                可选返回 'endpos'(结束位置) 或者 'substr'(截取结果). 
	* 返回:  数字 或 字符串 , 取决于 $return_type的设置. 
	* @author: 王奇疏 

	*/
	public static function getElementById( $content , $id , $return_type='substr' ) {
	// 匹配唯一标记的标签对
	    if ( preg_match( '@<([a-z]+)[^>]*id=[\"\']?'.$id.'[\"\']?[^>]*>@i' , $content , $res ) ){
	        
	        $start = $next_pos = strpos( $content , $res[0] );
	        ++$next_pos;

	        $start_tag = '<'.$res[1]; // 开始标签
	        $end_tag = '</'.$res[1].'>'; // 结束标签
	        $i = 1;
	        $j = 0; // 防死循环　　　　  
	        
	        // 只要计数大于0, 就继续查,查到计数器为0为止, 就是最终的关闭标签.
	        while ( $i > 0 && $j < 1024 ){
	             $p_start = stripos( $content , $start_tag , $next_pos );
	            $p_end = stripos( $content , $end_tag , $next_pos );
	            if ( false === $p_start && false !== $p_end ){

	                $next_pos = $p_end + 1;

	                break;

	           }            
	            // 如果
	            elseif ( $p_start > $p_end ){
	                $next_pos = $p_end + 1;
	                --$i;
	            }
	            else{
	                $next_pos = $p_start + 1;
	                ++$i;
	            }
	        }
	        if ( $j == 1024 ){
	            exit( '调用getElementById时出现错误::<font color="red">您的标签'.htmlspecialchars( "{$start_tag} id='{$id}'>" ).' 在使用时根本没有闭合,不符合xhtml,系统强制停止匹配</font>.' ); 
	        }
	        // 返回结果
	        if ( 'substr' == $return_type ){
	            return substr( $content , $start , $next_pos-$start + strlen( $end_tag ) );
	        }
	        elseif ( 'endpos' == $return_type ){
	            return $next_pos + strlen( $end_tag ) - 1 ;
	        }
	        else{
	            return false;
	        }
	    }
	    else{
	        return false;
	    }
	}



	/*
	* 功能: 成对匹配html标签对, 跟javascript的$.getElementById() 方法 一样.
	* 实现方法: 成对匹配html标签对(多层嵌套也能完整匹配)
	            ( 没有用到递归, 而是通过位置回退方法、顺序进行匹配 )
	* 参数: 
	    @string: $content: 输入内容; 
	    @string: $id 标签的id; 
	    @string: $return_type   设定返回值的类型,
	                可选返回 'endpos'(结束位置) 或者 'substr'(截取结果). 
	* 返回:  数字 或 字符串 , 取决于 $return_type的设置. 
	* @author: 王奇疏 

	*/
	public static function getElementByClass( $content , $class , $return_type='substr' ) {
	// 匹配唯一标记的标签对
	    if ( preg_match( '@<([a-z]+)[^>]*class=[\"\']?'.$class.'[\"\']?[^>]*>@i' , $content , $res ) ){
	        
	        $start = $next_pos = strpos( $content , $res[0] );
	        ++$next_pos;

	        $start_tag = '<'.$res[1]; // 开始标签
	        $end_tag = '</'.$res[1].'>'; // 结束标签
	        $i = 1;
	        $j = 0; // 防死循环　　　　  
	        
	        // 只要计数大于0, 就继续查,查到计数器为0为止, 就是最终的关闭标签.
	        while ( $i > 0 && $j < 1024 ){
	             $p_start = stripos( $content , $start_tag , $next_pos );
	            $p_end = stripos( $content , $end_tag , $next_pos );
	            if ( false === $p_start && false !== $p_end ){

	                $next_pos = $p_end + 1;

	                break;

	           }            
	            // 如果
	            elseif ( $p_start > $p_end ){
	                $next_pos = $p_end + 1;
	                --$i;
	            }
	            else{
	                $next_pos = $p_start + 1;
	                ++$i;
	            }
	        }
	        if ( $j == 1024 ){
	            exit( '调用getElementById时出现错误::<font color="red">您的标签'.htmlspecialchars( "{$start_tag} id='{$id}'>" ).' 在使用时根本没有闭合,不符合xhtml,系统强制停止匹配</font>.' ); 
	        }
	        // 返回结果
	        if ( 'substr' == $return_type ){
	            return substr( $content , $start , $next_pos-$start + strlen( $end_tag ) );
	        }
	        elseif ( 'endpos' == $return_type ){
	            return $next_pos + strlen( $end_tag ) - 1 ;
	        }
	        else{
	            return false;
	        }
	    }
	    else{
	        return false;
	    }
	}


	/** utf8和unicode 互转 **/
	public static function utf8_unicode($c) {  
	   switch(strlen($c)) {  
	     case 1:  
	       return ord($c);  
	     case 2:  
	       $n = (ord($c[0]) & 0x3f) << 6;  
	       $n += ord($c[1]) & 0x3f;  
	       return $n;  
	     case 3:  
	       $n = (ord($c[0]) & 0x1f) << 12;  
	       $n += (ord($c[1]) & 0x3f) << 6;  
	       $n += ord($c[2]) & 0x3f;  
	       return $n;  
	     case 4:  
	       $n = (ord($c[0]) & 0x0f) << 18;  
	       $n += (ord($c[1]) & 0x3f) << 12;  
	       $n += (ord($c[2]) & 0x3f) << 6;  
	       $n += ord($c[3]) & 0x3f;  
	       return $n;  
	   }  
	}  

	/** 编码转换为utf8 互转 **/
	public static function charsetToUTF8($mixed)
	{
	    if (is_array($mixed)) {
	        foreach ($mixed as $k => $v) {
	            if (is_array($v)) {
	                $mixed[$k] = charsetToUTF8($v);
	            } else {
	                $encode = strtoupper( mb_detect_encoding($v, array('ASCII', 'UTF-8', 'GB2312', 'GBK', 'BIG5')));

	                if ($encode == 'EUC-CN' || 'CP936' == $encode) {
	                    $mixed[$k] = iconv('GBK', 'UTF-8', $v);
	                }
	            }
	        }
	    } else {
	        $encode = strtoupper(mb_detect_encoding($mixed, array('ASCII', 'UTF-8', 'GB2312', 'GBK', 'BIG5')));
	        if ($encode == 'EUC-CN' || $encode == 'SJIS' || $encode == 'BIG5' || $encode == 'CP936' || $encode == 'CP949' || $encode == 'GB18030') {
	        	// echo 1111;die;
	            $mixed = iconv('GBK', 'UTF-8//TRANSLIT//IGNORE', $mixed);
	        }
	    }
	    return $mixed;
	}

	// 创建文件夹
	public static function pathGen($prefix, $path)
    {
        $arr = explode('/', $path);
        $dir = '/' == substr($prefix,-1) ? $prefix : $prefix . '/';
        foreach ($arr as $p)
        {
            if (!empty($p))
            {
                $dir .= $p . '/';
                if (!is_dir($dir))
                {
                	chown($dir, 'www');
                    if (!mkdir($dir, 0755)) return false;
                }
            }
        }
        return array('pre'=>$prefix,'path'=>$path);
    }

    // 获取html中的图片地址
    public static function tookImg($str)
    {
    	preg_match_all("/(src)=[\"|'| ]{0,}([^>]*\.(gif|jpg|bmp|png))/isU",$str,$img_array); 
    	// var_dump($img_array);die;
		return $img_array[0];
    }

    // 获取扩展文件名
    public static function getExtension($file)
	{
		return pathinfo($file, PATHINFO_EXTENSION);
	}

	// 数组转对象
	public static function arrayToObject($e){
	    if( gettype($e)!='array' ) return;
	    foreach($e as $k=>$v){
	        if( gettype($v)=='array' || getType($v)=='object' )
	            $e[$k]=(object)Gear::arrayToObject($v);
	    }
	    return (object)$e;
	}
	 
	// 对象转数组
	public static function objectToArray($e){
	    $e=(array)$e;
	    foreach($e as $k=>$v){
	        if( gettype($v)=='resource' ) return;
	        if( gettype($v)=='object' || gettype($v)=='array' )
	            $e[$k]=(array)Gear::objectToArray($v);
	    }
	    return $e;
	}


	public static function resizeImage($im, $maxwidth, $maxheight, $name)
	{
	    $pic_width = imagesx($im);
	    $pic_height = imagesy($im);
	    if ($maxwidth && $pic_width > $maxwidth || $maxheight && $pic_height > $maxheight) {
	        if ($maxwidth && $pic_width > $maxwidth) {
	            $widthratio = $maxwidth / $pic_width;
	            $resizewidth_tag = true;
	        }
	        if ($maxheight && $pic_height > $maxheight) {
	            $heightratio = $maxheight / $pic_height;
	            $resizeheight_tag = true;
	        }
	        if ($resizewidth_tag && $resizeheight_tag) {
	            if ($widthratio < $heightratio) {
	                $ratio = $widthratio;
	            } else {
	                $ratio = $heightratio;
	            }
	        }
	        if ($resizewidth_tag && !$resizeheight_tag) {
	            $ratio = $widthratio;
	        }
	        if ($resizeheight_tag && !$resizewidth_tag) {
	            $ratio = $heightratio;
	        }
	        $newwidth = $pic_width * $ratio;
	        $newheight = $pic_height * $ratio;
	        if (function_exists("imagecopyresampled")) {
	            $newim = imagecreatetruecolor($newwidth, $newheight);
	            //PHP系统函数
	            imagecopyresampled($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $pic_width, $pic_height);
	            //PHP系统函数
	        } else {
	            $newim = imagecreate($newwidth, $newheight);
	            imagecopyresized($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $pic_width, $pic_height);
	        }
	        $name = $name ;
	        imagejpeg($newim, $name);
	        imagedestroy($newim);
	    } else {
	        $name = $name ;
	        imagejpeg($im, $name);
	    }
	}

	// 随机字符串
	public static function getRandChar($length = 10){
	   	$str = null;
	   	$strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
	   	$max = strlen($strPol)-1;

	   	for($i=0;$i<$length;$i++){
	    	$str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
	   	}

	   return $str;
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



	/**
	* 订单号生成
	* 作者: unknow
	**/
	static function orderNumCreate1($start=2016)
	{
		$yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
		$orderSn = $yCode[intval(date('Y')) - $start] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
	}

	/**
	* 订单号生成
	* 作者: unknow
	**/
	static function orderNumCreate2()
	{
		return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
	}

	/**
	* 大整数相加
	* 作者: unknow
	**/
	static function strAdd($str1,$str2)
	{
	    $res = array();
	    if(strlen($str1) > strlen($str2)){
	        $str2 = str_pad($str2,strlen($str1),'0',STR_PAD_LEFT);
	    }
	    else{
	        $str1 = str_pad($str1,strlen($str2),'0',STR_PAD_LEFT);
	    }
	    for($i = strlen($str1)-1; $i>=0; $i--){
	        $tmp = $str1[$i] + $str2[$i];
	        $res[$i] += $tmp;
	        if($res[$i] >= 10) {
	            $res[$i] -= 10;
	            $res[$i-1] += 1;
	        }
	    }
	    ksort($res);
	    $res = implode('',$res);
	    return $res;
	}

	/**
	* html 标签补全
	* 作者: unknow
	**/
	function CloseTags($html)
	{
		// strip fraction of open or close tag from end (e.g. if we take first x characters, we might cut off a tag at the end!)
		$html = preg_replace('/<[^>]*$/','',$html); // ending with fraction of open tag
		// put open tags into an array
		preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
		$opentags = $result[1];
		// put all closed tags into an array
		preg_match_all('#</([a-z]+)>#iU', $html, $result);
		$closetags = $result[1];
		$len_opened = count($opentags);
		// if all tags are closed, we can return
		if (count($closetags) == $len_opened) {
			return $html;
		}
		// close tags in reverse order that they were opened
		$opentags = array_reverse($opentags);
		// self closing tags
		$sc = array('br','input','img','hr','meta','link');
		// ,'frame','iframe','param','area','base','basefont','col'
		// should not skip tags that can have content inside!
		for ($i=0; $i < $len_opened; $i++){
			$ot = strtolower($opentags[$i]);
			if (!in_array($opentags[$i], $closetags) && !in_array($ot,$sc)){
				$html .= '</'.$opentags[$i].'>';
			}
			else{
				unset($closetags[array_search($opentags[$i], $closetags)]);
			}
		}
		return $html;
	}

	public static function create_uuid(){
	    if (function_exists('com_create_guid')){
	        return com_create_guid();
	    }else{
	        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
	        $charid = strtoupper(md5(uniqid(rand(), true)));
	        $hyphen = chr(45);// "-"
	        $uuid = chr(123)// "{"
	                .substr($charid, 0, 8).$hyphen
	                .substr($charid, 8, 4).$hyphen
	                .substr($charid,12, 4).$hyphen
	                .substr($charid,16, 4).$hyphen
	                .substr($charid,20,12)
	                .chr(125);// "}"
	        return $uuid;
	    }
	}

	public static function create_guid(){ 
	    $microTime = microtime(); 
	    list($a_dec, $a_sec) = explode(" ", $microTime); 
	    $dec_hex = dechex($a_dec* 1000000); 
	    $sec_hex = dechex($a_sec); 
	    Gear::ensure_length($dec_hex, 5); 
	    Gear::ensure_length($sec_hex, 6); 
	    $guid = ""; 
	    $guid .= $dec_hex; 
	    $guid .= Gear::create_guid_section(3); 
	    $guid .= '-'; 
	    $guid .= Gear::create_guid_section(4); 
	    $guid .= '-'; 
	    $guid .= Gear::create_guid_section(4); 
	    $guid .= '-'; 
	    $guid .= Gear::create_guid_section(4); 
	    $guid .= '-'; 
	    $guid .= $sec_hex; 
	    $guid .= Gear::create_guid_section(6); 
	    return $guid; 
	} 

	public static function ensure_length(&$string, $length){    
	    $strlen = strlen($string);    
	    if($strlen < $length)    
	    {    
	        $string = str_pad($string,$length,"0");    
	    }    
	    else if($strlen > $length)    
	    {    
	        $string = substr($string, 0, $length);    
	    }   
	 } 

	public static function create_guid_section($characters){ 
	    $return = ""; 
	    for($i=0; $i<$characters; $i++) 
	    { 
	        $return .= dechex(mt_rand(0,15)); 
	    } 
	    return $return; 
	} 

	/** 
     *  
    * 返回一定位数的时间戳，多少位由参数决定 
    * 
    * @author 陈博 
    * @param type 多少位的时间戳 
    * @return 时间戳 
     */  
    public static function getTimestamp($digits = false) {  
        $digits = $digits > 10 ? $digits : 10;  
        $digits = $digits - 10;  
        if ((!$digits) || ($digits == 10))  
        {  
            return time();  
        }  
        else  
        {  
            return number_format(microtime(true),$digits,'','');  
        }  
    }  

    public static function time_tran($the_time) {  
	    $now_time = date("Y-m-d H:i:s", time());  
	    //echo $now_time;  
	    $now_time = strtotime($now_time);  
	    $show_time = strtotime($the_time);  
	    $dur = $now_time - $show_time;  
	    if ($dur < 0) {  
	        return $the_time;  
	    } else {  
	        if ($dur < 60) {  
	            return $dur . '秒前';  
	        } else {  
	            if ($dur < 3600) {  
	                return floor($dur / 60) . '分钟前';  
	            } else {  
	                if ($dur < 86400) {  
	                    return floor($dur / 3600) . '小时前';  
	                } else {  
	                    if ($dur < 259200) {//3天内  
	                        return floor($dur / 86400) . '天前';  
	                    } else {  
	                        return $the_time;  
	                    }  
	                }  
	            }  
	        }  
	    }  
	}  
}