<?php
/**
 * 文件流 Class
 *
 * class inferface of phpredis extension
 *
 * @version:  1.0
 * @author:   NULL
 * @license:  LGPL
 *
 */
class StreamFile
{
    
    /** php 发送流文件 
    * @param  String  $url  接收的路径 
    * @param  String  $file 要发送的文件 
    * @return boolean 
    */  
    public function send($url, $file){  
        if(file_exists($file)){  
            $opts = array(  
                'http' => array(  
                    'method' => 'POST',  
                    'header' => 'content-type:application/x-www-form-urlencoded',  
                    'content' => array('name'=>11,'data'=>'sss')  
                )  
            );  
            $context = stream_context_create($opts);  
            $response = file_get_contents($url, false, $context);  
            $ret = json_decode($response, true);  
            return $ret['success'];  
        }else{  
            return false;  
        }  
    }  


    /** php 接收流文件 
    * @param  String  $file 接收后保存的文件名 
    * @return boolean 
    */  
    public function receiveStreamFile($receiveFile){  
        $streamData = file_get_contents('php://input');  
      
        if($streamData!=''){  
            $ret = file_put_contents($receiveFile, $streamData, true);
        }else{  
            $ret = false;  
        }  
        return $ret;  
    }  

}
