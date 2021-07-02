<?php

declare(strict_types=1);

//封装排序类 学习向
class Sort
{
    /**
     * 开始时间戳
     * @var startTime
     */
    protected $startTime;

    /**
     * 构造方法
     * @access public
     */
    public function __construct()
    {
        $this->startTime = microtime(true);
    }

    /**
     * 交换数组两个参数
     * @param $data 原数组
     * @param $i    key值
     * @param $j    key值
     **/
    protected function swap(&$data, $i, $j)
    {
        $temp = $data[$i];
        $data[$i] = $data[$j];
        $data[$j] = $temp;
    }

    /**
     * 返回格式
     * @param $data 处理好的数组
     **/
    protected function outPut($data = array())
    {
        
        $res['cost'] = ((microtime(true) - $this->startTime) * 1000) . 'ms';
        $res['data'] = $data;
        return json_encode($res);
    }
    
    /**
     * 快速排序
     * 平均时间复杂度 O(N*lgN)
     * 稳定性 不稳
     * @param $data 需要处理的数组
     **/
    public function quickSort(array $arr)
    {
        $quickSortArr = $this->quickSortBase($arr);
        return $this->outPut($quickSortArr);
    }

    //快速排序基础
    protected function quickSortBase(array $arr)
    {
        $arr_length = count($arr);
        //临界点 数组只剩1个 返回
        if ($arr_length <= 1) {
            return $arr;
        }
        //接收小于中间值
        $left   = array();
        //接收大于中间值
        $right  = array();
        //中间值
        $middle = $arr[0];
        //循环比较
        for ($i = 1; $i < count($arr); $i++) {
            if ($middle < $arr[$i]) {
                //大于中间值
                $right[] = $arr[$i];
            } else {
                //小于中间值
                $left[] = $arr[$i];
            }
        }
        //递归排序划分好的2边
        $left  = $this->quickSortBase($left);
        $right = $this->quickSortBase($right);
        //合并排序后的数据，别忘了合并中间值
        return array_merge($left, array($middle), $right);
    }

    /**
     * 冒泡排序
     * 平均时间复杂度 O(N*N)
     * 稳定性 稳
     * @param $data 需要处理的数组
     **/
    public function topSort(array $arr)
    {
        $arr_length = count($arr);
        for ($i = $arr_length - 1; $i > 0; $i--) {

            //标识记录 内循环结束后 重新赋予新的标识
            $flagOff = true;
            for ($j = 0; $j < $i; $j++) {
                if ($arr[$j] > $arr[$j + 1]) {
                    //数值互换
                    $this->swap($arr, $j, $j + 1);
                    $flagOff = false;
                }
            }

            //测试输出
            // echo 1;
            // echo '</br>';

            //当内循环结束 标识还没有更改为false的时候 表示数组已经排序完毕 无需再多循环 最快O(1)
            if ($flagOff)
                break;
        }
        return $this->outPut($arr);
    }

    /**
     * 选择排序
     * 平均时间复杂度 O(N*N)
     * 稳定性 不稳
     * @param $data 需要处理的数组
     **/
    public function selectSort(array $arr)
    {
        $arr_length = count($arr);
        for ($i = 0; $i < $arr_length - 1; $i++) {
            $arr_min = $i;
            for ($j = $i + 1; $j < $arr_length; $j++) {
                //获取最小值
                $arr_min = ($arr[$arr_min] > $arr[$j]) ? $j : $arr_min;
            }
            //数值互换
            $this->swap($arr, $i, $arr_min);

            //测试输出
            // var_dump($arr);
            // echo '<br>';
        }
        return $this->outPut($arr);
    }

    /**
     * 插入排序 
     * 平均时间复杂度 O(N*N)
     * 稳定性 稳
     * @param $data 需要处理的数组
     **/
    public function insertSort(array $arr)
    {
        //第一次 A = [9 8 2 1 3 7]     $temp = 8
        //第二次 A = [8 9   2 1 3 7]   $temp = 2
        //第三次 A = [8 2   9 1 3 7]   $temp = 2
        //第四次 A = [2 8 9   1 3 7]   $temp = 1
        //如此类推...
        $arr_length = count($arr);
        for ($i = 1; $i < $arr_length; $i++) {
            $temp = $arr[$i];
            for ($j = $i - 1; $j >= 0; $j--) {
                if ($arr[$j] > $temp) {
                    $arr[$j + 1] = $arr[$j];
                    $arr[$j] = $temp;
                } else {
                    break;
                }
            }
        }

        return $this->outPut($arr);
    }
    
    /**
     * 归并排序 
     * 平均时间复杂度 O(N*lgN)
     * 稳定性 稳
     * @param $data 需要处理的数组
     **/
    public function mergeSort(array $arr)
    {
        $mergeSortArr = $this->mergeSortBase($arr);
        return $this->outPut($mergeSortArr);
    }

    //归并排序主程序
    protected function mergeSortBase(array $arr) 
    {
        $len = count($arr);
        //递归结束条件,数组只剩一个元素
        if ($len <= 1) {
            return $arr;
        } 
        
        //取数组中间
        $mid = intval($len / 2);
        //拆分数组0-mid这部分给左边left
        $left = array_slice($arr, 0, $mid);
        //拆分数组mid-末尾这部分给右边right
        $right = array_slice($arr, $mid);
        //左边拆分完后开始递归合并往回走
        $left = $this->mergeSortBase($left);
        //右边拆分完毕开始递归往回走
        $right = $this->mergeSortBase($right);
        //合并两个数组,继续递归
        $arr = $this->merge($left, $right);

        return $arr;
    }

    //归并排序次合并
    protected function merge($arrA, $arrB) 
    {
        $arrC = array();
        //当其中一方数组已被删除完毕
        while (count($arrA) && count($arrB)) 
        {

            //不停地将最小值赋入于数组C
            //例：   A = [2 4 8] B = [3 6 9 10] C = []
            //第一次 A = [4 8]   B = [3 6 9 10] C = [2]
            //第二次 A = [4 8]   B = [6 9 10]   C = [2 3]
            //第三次 A = [8]     B = [6 9 10]   C = [2 3 4]
            //第四次 A = [8]     B = [9 10]     C = [2 3 4 6]
            //第五次 A = []      B = [9 10]     C = [2 3 4 6 8]

            $arrC[] = $arrA[0] <= $arrB[0] ? array_shift($arrA) : array_shift($arrB);
            //注: $arrA[0] <= $arrB[0]? 小于等于为了排序的稳定性
            //...   A = [8-A]     B = [8-B 9 10]     C = [2 3 4 6]
            //如果是 $arrA[0] < $arrB[0] 结果就改变了 
            //...   A = [8-A]     B = [9 10]         C = [2 3 4 6 8-B]
            //两个8的先后顺序就改变了
        }
        return array_merge($arrC, $arrA, $arrB);
    }


    //希尔排序(对直接插入排序的改进)
    public function ShellSort(array &$arr)
    {
        $count = count($arr);
        $inc = $count;    //增量
        do {
            //计算增量
            //$inc = floor($inc / 3) + 1;
            $inc = ceil($inc / 2);
            for ($i = $inc; $i < $count; $i++) {
                $temp = $arr[$i];    //设置哨兵
                //需将$temp插入有序增量子表
                for ($j = $i - $inc; $j >= 0 && $arr[$j + $inc] < $arr[$j]; $j -= $inc) {
                    $arr[$j + $inc] = $arr[$j]; //记录后移
                }
                //插入
                $arr[$j + $inc] = $temp;
            }
            //增量为1时停止循环
        } while ($inc > 1);
    }
}

//创建数据
// $data = [];
// for($i = 0; $i < 1000;) {
//     $val = ceil( rand(1, 1000000) );
//     if(!in_array($val, $data)) {
//         $data[] = $val;
//         $i++;
//     }
// }


// $returnQuickSort   = (new Sort)->quickSort($data);
// $returnTopSort     = (new Sort)->topSort($data);
// $returnSelectSort  = (new Sort)->selectSort($data);
// $returnInsertSort  = (new Sort)->insertSort($data);
// $returnMergeSort   = (new Sort)->mergeSort($data);

// echo $returnQuickSort;
// echo $returnTopSort;
// echo $returnSelectSort;
// echo $returnInsertSort;
// echo $returnMergeSort;

// 6 - √10 = a + b;
