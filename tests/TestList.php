<?php
/**
 * @File: TestList.php
 * @Author: xiongjinhai
 * @Email:562740366@qq.com
 * @Date: 2018/5/4上午10:52
 * @Version:Version:1.1 2017 by www.dsweixin.com All Rights Reserver
 */

class TestList
{
    //列表队列
    public function list(){

        $strQueueName = "Test_xiong_queue";

        //进队列

        $str1 = json_encode(array("uid" => 1,"name" => "job"));
        $str2 = json_encode(array("uid" => 2,"name" => "tom"));
        $str3 = json_encode(array("uid" => 3,"name" => "john"));

        $abc = array($str1,$str2,$str3);

        Predis::rpush($strQueueName,$abc);

        //查看队列

        $strCount  = Predis::lrange($strQueueName);

        print_r($strCount);

        echo "<br>";
        //出队列

        $lpop  = Predis::lpop($strQueueName);

        print_r($lpop);

        echo "<br>";

        $strCount2  = Predis::lrange($strQueueName);

        print_r($strCount2);

    }
}