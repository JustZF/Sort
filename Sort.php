<?php

declare(strict_types=1);

//封装排序类 学习向
class Sort
{
    //快速排序开始
    public function quickSort(array $arr)
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
        $left  = $this->quickSort($left);
        $right = $this->quickSort($right);
        //合并排序后的数据，别忘了合并中间值
        return array_merge($left, array($middle), $right);
    }

    //冒泡
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
        return $arr;
    }

    //选择
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
        return $arr;
    }

    //插入  
    //9 8 2 1 3 7
    //8 9   2 1 3 7
    //2 8 9   1 3 7
    public function insertSort(array $arr)
    {
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

        return $arr;
    }

    //交换
    protected function swap(&$data, $i, $j)
    {
        $temp = $data[$i];
        $data[$i] = $data[$j];
        $data[$j] = $temp;
    }
}

// $arr = ['20', '2', '1', '8', '6', '7', '11', '16'];
$arr = ['1', '2', '20', '8', '6', '7', '11', '16'];
// $arr = ['1', '2', '3', '4', '5', '6', '7', '8'];
$returnQuickSort = (new Sort)->insertSort($arr);


var_dump($returnQuickSort);
