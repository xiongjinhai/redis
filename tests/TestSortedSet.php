<?php
/**
 * @File: TestSortedSet.php
 * @Author: xiongjinhai
 * @Email:562740366@qq.com
 * @Date: 2018/5/4上午11:23
 * @Version:Version:1.1 2017 by www.dsweixin.com All Rights Reserver
 */

class TestSortedSet
{
    //有序集合
    public function scoreSet(){

        $strkey  = "Test_xiong_score";

        $str = array(
            json_encode(array('name' => "Tom")) => 50,
            json_encode(array('name' => "Jerry")) => 70,
            json_encode(array('name' => "John")) => 90,
            json_encode(array('name' => "Job")) => 30,
            json_encode(array('name' => "LiMing")) => 100,
        );

        Predis::zadd($strkey,$str);

        $dataOne = Predis::zrevrange($strkey);

        echo "---- ".$strkey."由大到小的排序 ---- ";
        print_r($dataOne);

        echo "<br>";

        $dataTwo = Predis::zrange($strkey);

        echo "---- ".$strkey."由小到大的排序 ---- ";
        print_r($dataTwo);

        echo "<br>";


        $abc  = Predis::zincrby($strkey,5,json_encode(array('name' => "Tom")));

        print_r($abc);

    }

}