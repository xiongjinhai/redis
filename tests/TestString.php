<?php
/**
 * @File: TestString.php
 * @Author: xiongjinhai
 * @Email:562740366@qq.com
 * @Date: 2017/12/15上午9:42
 * @Version:Version:1.1 2017 by www.dsweixin.com All Rights Reserver
 */

use Redis\Facades\Predis;

class TestString
{
    /**
     * 用户在线状态
     */
    public function setOnline(){

        $range = range(1,6000);

        /*foreach ($range as $uid){

            Predis::setbit('online',$uid,$uid%2);
        }*/

        $startTime = microtime(true);

        /*foreach ($range as $uid){

            echo  Predis::getbit('online',$uid).PHP_EOL;
        }*/

        echo Predis::bitpos('online',0,1).PHP_EOL;

        $endTime  = microtime(true);

        echo "total:" . ($endTime - $startTime) . "s";

    }

    /**
     * 统计活跃用户
     */
    public function setActiveUsers(){

        //日期对应的活跃用户

        $data  = array(
            "2017-12-10" => array(1,2,3,4,5,6,7,8,9,10),
            "2017-12-11" => array(1,2,3,4,5,6,7,8),
            "2017-12-12" => array(1,2,3,4,5,6),
            "2017-12-13" => array(1,2,3,4),
            "2017-12-14" => array(1,2),
        );

        //批量设置活跃状态

        foreach ($data as $key => $value){

            $cacheKey  = sprintf("stat_%s",$key);

            foreach ($value as $k => $v){

                Predis::setbit($cacheKey,$v,1);
            }
        }


        $array  = array(
            'plain:stat_2017-12-10','plain:stat_2017-12-11','plain:stat_2017-12-12'
        );

        Predis::bitop('and','stat',$array);

        //总活跃用户：6 

        $bitcount = Predis::bitcount('stat');

        echo "总活跃用户：" . $bitcount . PHP_EOL;

        Predis::bitop('or','stat',$array);//取最大

        $bitcount2 = Predis::bitcount('stat');

        echo "总活跃用户：" . $bitcount2 . PHP_EOL;

        Predis::bitop('XOR','stat',$array);//取最第二大

        $bitcount3 = Predis::bitcount('stat');

        echo "总活跃用户：" . $bitcount3 . PHP_EOL;

        Predis::bitop('NOT','stat',"plain:stat_2017-12-15");//这个有点特别,key必须不存在 否则报错

        $bitcount4 = Predis::bitcount('stat');

        echo "总活跃用户：" . $bitcount4 . PHP_EOL;

        $array1  = array(
            'plain:stat_2017-12-10','plain:stat_2017-12-11','plain:stat_2017-12-14'
        );

        Predis::bitop('AND', 'stat1',$array1) . PHP_EOL;
        //总活跃用户：2 
        echo "总活跃用户：" .  Predis::bitcount('stat1') . PHP_EOL;

        $array2  = array(
            'plain:stat_2017-12-10','plain:stat_2017-12-11'
        );

        Predis::bitop('AND', 'stat2',$array2) . PHP_EOL;
        //总活跃用户：2 
        echo "总活跃用户：" .  Predis::bitcount('stat2') . PHP_EOL;
    }
    /**
     * 产品评论总数
     */
    public function setCommentaries(){

        $data  = array(
            'uid' => 1001,//用户id
            'products_id' => 12,
        );

        $key = 'comment:'.$data['products_id'];

        $uid  = $data['uid'];

        Predis::setbit($key,$uid,1);

        echo Predis::getbit($key,$uid).PHP_EOL;

        echo '总评论次数为：' . Predis::bitcount($key);
    }

    /*sprintf函数
    %% - 返回一个百分号 %
    %b - 二进制数
    %c - ASCII 值对应的字符
    %d - 包含正负号的十进制数（负数、0、正数）
    %e - 使用小写的科学计数法（例如 1.2e+2）
    %E - 使用大写的科学计数法（例如 1.2E+2）
    %u - 不包含正负号的十进制数（大于等于 0）
    %f - 浮点数（本地设置）
    %F - 浮点数（非本地设置）
    %g - 较短的 %e 和 %f
    %G - 较短的 %E 和 %f
    %o - 八进制数
    %s - 字符串
    %x - 十六进制数（小写字母）
    %X - 十六进制数（大写字母）*/
    /**
     *
     * 用户签到
     */
    public function userSign(){

        $uid  = 1; //用户uid

        $cacheKey = sprintf("sign_%d",$uid); //记录有uid的key

        //开始有签到功能的日期

        $startDate = "2017-12-01";

        //今天的日期

        $todayDate  = "2017-12-12";

        //$todayDate  = "2017-12-13";

        //$todayDate  = "2017-12-14";

        //计算offset

        $startTime  = strtotime($startDate);

        $todayTime  = strtotime($todayDate);

        $offset  = floor(($todayTime-$startTime)/86400);

        echo "今天是第".$offset."天".PHP_EOL;//PHP_EOL=换行

        //签到
        Predis::setbit($cacheKey,$offset,1);

        //查询签到情况
        $bitStatus = Predis::getbit($cacheKey, $offset);

        echo 1 == $bitStatus ? '今天已经签到啦' : '还没有签到呢';

        echo PHP_EOL;

        //计算总签到次数
        echo  Predis::bitcount($cacheKey) . PHP_EOL;
    }
    /**
     * 设置用户某天登录过
     */
    public function setActiveDate($userId, $time = null)
    {

        $key = "user_active_".$userId.'_'.date('Y-m',$time);

        $offset = intval(date('d',$time))-1;

        return Predis::setbit($key,$offset,1);

    }
    /**
     * 得到用户本月登录天数
     * redis >= 2.6.0 才可以
     */
    public function getActiveDatesCount($userId, $time = null){

        $key = "user_active_".$userId.'_'.date('Y-m',$time);

        return  Predis::bitcount($key);
    }
    /**
     * 得到用户某月所有的登录过日期
     */
    public function getActiveDates($userId, $time = null)
    {

        $result  = array();

        $key     = "user_active_".$userId.'_'.date('Y-m',$time);

        $strData = Predis::get($key);

        if (empty($strData)){

            return $strData;

        }

        $monthFirstDay = mktime(0, 0, 0, date("m", $time), 1, date("Y", $time));


        $maxDay = cal_days_in_month(CAL_GREGORIAN, date("m", $time), date("Y", $time));//返回某个历法中某年中某月的天数


        $charData = unpack("C*", $strData); //unpack() 函数从二进制字符串对数据进行解包。 无符号字符


        for ($index =1;$index <= count($charData);$index++){

            for ($bit = 0;$bit < 8;$bit++){

                if ($charData[$index] & 1 << $bit){  // & And（按位与） << 将 $a 中的位向左移动 $b 次（每一次移动都表示“乘以 2”）。
                    //print_r($bit);
                    //echo "<br>";
                    //$intervalDay = ($index - 1) * 8 + 8-$bit;
                    $intervalDay = $index * 8 -$bit;

                    //print_r($intervalDay);
                    //echo "<br>";
                    //如果数据有大于当月最大天数的时候

                    if ($intervalDay > $maxDay) {

                        return $result;

                    }

                    $result [] = date('Y-m-d', $monthFirstDay + ($intervalDay-1) * 86400);
                }
            }
        }
        return $result;
    }
}