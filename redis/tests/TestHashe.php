<?php
/**
 * @File: TestHashe.php
 * @Author: xiongjinhai
 * @Email:562740366@qq.com
 * @Date: 2018/1/10下午5:14
 * @Version:Version:1.1 2017 by www.dsweixin.com All Rights Reserver
 */

class TestHashe
{
    /**
     * hash 数据类型在存储上述类型的数据时具有比 string 类型更灵活、更快的优势，具体的说，
     * 使用 string 类型存储，必然需要转换和解析 json 格式的字符串，即便不需要转换，在内存开销方面，还是 hash 占优势。
     * hash 类型十分适合存储对象类数据，相对于在 string 中介绍的把对象转化为 json 字符串存储，
     * hash 的结构可以任意添加或删除‘字段名’，更加高效灵活。
     */
    public function redis(){

        //$this->cart();

        //$this->msgSend();

        // $this->userFans();

        // $hget = Predis::hgetall($key);
    }

    public function cart(){
        // 插入一条hash数据到redis库中
        $uid = 1000;
        $key = "cart:user".$uid;
        Predis::hset($key,"macbook pro","3");
        //一次性往已经存在的这条hash数据(购物车)中添加多个field-value对
        $array = array("thinkpad" => 2,"ml" => 1);

        Predis::hmset($key,$array);

        $all = Predis::hgetAll($key);

        print_r($all);

        echo "<br>";

        $hkeys = Predis::hkeys($key);

        print_r($hkeys);
    }

    /**
     * 消息通知
     */
    public function msgSend(){

        $uid  =100;

        $key  = "user:".$uid.":message:ur";

        if (Predis::hexists($key,'system')){
            Predis::hincrby($key,'system',1);//未读系统消息+1
        }else{
            Predis::hset($key,'system',1);//1条未读系统消息
        }
        //Predis::hset($key,'system',0);//设为系统消息已读

        if (Predis::hexists($key,'comment')){
            Predis::hincrby($key,'comment',1);//未读评论消息+1
        }else{
            Predis::hset($key,'comment',1);//1条未读评论消息
        }
    }
    //Hash（哈希表）: 用户粉丝列表, 用户点赞列表, 用户收藏列表, 用户关注列表等
    public function userFans(){

        $uid = "2000";
        $key = "user:".$uid.":fans";

        $from_uid = 1001;

        $array = array('id'=>11,'name'=>'ddd','url'=>'http://www.baidu.com');

        $value = json_encode($array);

        Predis::hset($key,$from_uid,$value);

        $hget = Predis::hgetall($key);

        print_r($hget);
    }
    //配置文件
    public function systemConfig(){

    }
}