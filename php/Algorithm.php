<?php
/**
 * curl Class
 *
 * class inferface of phpredis extension
 *
 * @version:  1.0
 * @author:   NULL
 * @license:  LGPL
 *
 */
class Algorithm
{
    
    /**
     * construct class
     */
    function __construct()
    {
    }

    /**
     * 冒泡排序
     */
    public function bubbleSort($arr)
    {
        for ( $i = 0; $i < count($arr); $i++)
        {
            for ( $j = $i; $j < count($arr); $j++)
            {
                if ($arr[$i] > $arr[$j])
                {
                     $temp = $arr[$i];
                    $arr[$i] = $arr[$j];
                    $arr[$j] = $temp;
                }
            }
        }
        return $arr;
    }


    /**
     * 快速排序
     */
    function quickSort($arr) {
        //先判断是否需要继续进行
        $length = count($arr);
        if($length <= 1) {
            return $arr;
        }
        //如果没有返回，说明数组内的元素个数 多余1个，需要排序
        //选择一个标尺
        //选择第一个元素
        $base_num = $arr[0];
        //遍历 除了标尺外的所有元素，按照大小关系放入两个数组内
        //初始化两个数组
        $left_array = array();//小于标尺的
        $right_array = array();//大于标尺的
        for($i=1; $i<$length; $i++) {
            if($base_num > $arr[$i]) {
                //放入左边数组
                $left_array[] = $arr[$i];
            } else {
                //放入右边
                $right_array[] = $arr[$i];
            }
        }
        //再分别对 左边 和 右边的数组进行相同的排序处理方式
        //递归调用这个函数,并记录结果
        $left_array = quickSort($left_array);
        $right_array = quickSort($right_array);
        //合并左边 标尺 右边
        return array_merge($left_array, array($base_num), $right_array);
    }

    /**
     * 选择排序
     */
    function selectSort($arr) {
    //实现思路 双重循环完成，外层控制轮数，当前的最小值。内层 控制的比较次数
        //$i 当前最小值的位置， 需要参与比较的元素
        for($i=0, $len=count($arr); $i<$len-1; $i++) {
            //先假设最小的值的位置
            $p = $i;
            //$j 当前都需要和哪些元素比较，$i 后边的。
            for($j=$i+1; $j<$len; $j++) {
                //$arr[$p] 是 当前已知的最小值
                if($arr[$p] > $arr[$j]) {
         //比较，发现更小的,记录下最小值的位置；并且在下次比较时，
     // 应该采用已知的最小值进行比较。
                    $p = $j;
                }
            }
            //已经确定了当前的最小值的位置，保存到$p中。
     //如果发现 最小值的位置与当前假设的位置$i不同，则位置互换即可
            if($p != $i) {
                $tmp = $arr[$p];
                $arr[$p] = $arr[$i];
                $arr[$i] = $tmp;
            }
        }
        //返回最终结果
        return $arr;
    }

    /**
     * 插入排序
     */

    function insertSort($arr) {
        //区分 哪部分是已经排序好的
        //哪部分是没有排序的
        //找到其中一个需要排序的元素
        //这个元素 就是从第二个元素开始，到最后一个元素都是这个需要排序的元素
        //利用循环就可以标志出来
        //i循环控制 每次需要插入的元素，一旦需要插入的元素控制好了，
        //间接已经将数组分成了2部分，下标小于当前的（左边的），是排序好的序列
        for($i=1, $len=count($arr); $i<$len; $i++) {
            //获得当前需要比较的元素值。
            $tmp = $arr[$i];
            //内层循环控制 比较 并 插入
            for($j=$i-1;$j>=0;$j--) {
       //$arr[$i];//需要插入的元素; $arr[$j];//需要比较的元素
                if($tmp < $arr[$j]) {
                    //发现插入的元素要小，交换位置
                    //将后边的元素与前面的元素互换
                    $arr[$j+1] = $arr[$j];
                    //将前面的数设置为 当前需要交换的数
                    $arr[$j] = $tmp;
                } else {
                    //如果碰到不需要移动的元素
               //由于是已经排序好是数组，则前面的就不需要再次比较了。
                    break;
                }
            }
        }
        //将这个元素 插入到已经排序好的序列内。
        //返回
        return $arr;
    }


    /**
     * 桶排序
     * 桶排序是稳定的
     * 桶排序是常见排序里最快的一种,比快排还要快…大多数情况下
     * 桶排序非常快,但是同时也非常耗空间,基本上是最耗空间的一种排序算法
     */
    function bucketSort($arr,$asc=false,$rangeStart=0,$rangeEnd=10){
        $buckets = array();
        $len = count($arr);
        $resultArr = array();
        //build some buckets
        for($i=$rangeStart;$i<=$rangeEnd;$i++){
            $buckets[] = 0;
        }
        foreach($arr as $item){
            if($rangeStart<$item&&$item<=$rangeEnd){
                $buckets[$item]++;
            }
        }
        if($asc){
            for($i=$rangeStart;$i<=$rangeEnd;$i++){
                for($j=0;$j<$buckets[$i];$j++){
                    $resultArr[] = $i;
                }   
            }
        }else{
            for($i=$rangeEnd;$i>=$rangeStart;$i--){
                for($j=0;$j<$buckets[$i];$j++){
                    $resultArr[] = $i;
                }   
            }
        }
        return $resultArr;
    }

     /**
     * 基数排序
     */
    function baseSort(&$arr){
        $len=count($arr);
        $max=0;
        $cnt=0;
        $arr_=array();
        for($i=0;$i<$len;$i++)        //获取数组中的最大值
            if($arr[$i]>$max)
                $max=$arr[$i];
        while($max/10!=0){        //获取最大值一共有多少位，以便于以后决定进行多少次入桶和出桶
            $max=(int)$max/10;
            $cnt++;
        }
        $cnt--;
        for($i=0;$i<$cnt;$i++){
            $temp=pow(10,$i);
            for($j=0;$j<$len;$j++){        //将每一个元素进行入桶
                $a=$arr[$j]/$temp%10;
                $arr_[$a][]=$arr[$j];
            }
            for($arr_index=0,$k=0;$k<10;$k++){        //将每一个元素进行出桶，并将他们进行合并
                for($j=0;$j<count($arr_[$k]);$j++){
                    if(!empty($arr_[$k])){
                        $arr[$arr_index++]=$arr_[$k][$j];
                    }
                }
            }
            unset($arr_);
        }
    }
}
