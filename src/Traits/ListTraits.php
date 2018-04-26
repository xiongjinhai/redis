<?php
/**
 * @File: ListTraits.php
 * @Author: xiongjinhai
 * @Email:562740366@qq.com
 * @Date: 2018/3/20上午10:48
 * @Version:Version:1.1 2017 by www.dsweixin.com All Rights Reserver
 */

namespace Redis\Traits;


trait ListTraits
{
    /**
     * 将一个或多个值value插入到列表key的表头。
     * 如果有多个value值，那么各个value值按从左到右的顺序依次插入到表头：比如对一个空列表(mylist)执行LPUSH mylist a b c，则结果列表为c b a，等同于执行执行命令LPUSH mylist a、LPUSH mylist b、LPUSH mylist c。
     * 如果key不存在，一个空列表会被创建并执行LPUSH操作。
     * 当key存在但不是列表类型时，返回一个错误。
     * @param $key
     * @param array $values 注解:在Redis 2.4版本以前的LPUSH命令，都只接受单个value值。
     * @return mixed 执行LPUSH命令后，列表的长度。
     */
    public function lpush($key, $values)
    {

        return $this->connection()->lpush($this->prefix . $key, $values);
    }

    /**
     * 将值value插入到列表key的表头，当且仅当key存在并且是一个列表。
     * 和LPUSH命令相反，当key不存在时，LPUSHX命令什么也不做。
     * @param $key
     * @param $value
     * @return mixed LPUSHX命令执行之后，表的长度。
     */
    public function lpushx($key, $value)
    {

        return $this->connection()->lpushx($this->prefix . $key, $value);
    }

    /**
     * 将一个或多个值value插入到列表key的表尾。
     * 如果有多个value值，那么各个value值按从左到右的顺序依次插入到表尾：比如对一个空列表(mylist)执行RPUSH mylist a b c，则结果列表为a b c，等同于执行命令RPUSHmylist a、RPUSH mylist b、RPUSH mylist c。
     * 如果key不存在，一个空列表会被创建并执行RPUSH操作。
     * 当key存在但不是列表类型时，返回一个错误。
     * @param $key
     * @param array $values
     * @return mixed 执行RPUSH操作后，表的长度。
     */
    public function rpush($key,  $values)
    {

        return $this->connection()->rpush($this->prefix . $key, $values);

    }

    /**
     * 将值value插入到列表key的表尾，当且仅当key存在并且是一个列表。
     * 和RPUSH命令相反，当key不存在时，RPUSHX命令什么也不做。
     * @param $key
     * @param $value
     * @return mixed RPUSHX命令执行之后，表的长度。
     */
    public function rpushx($key, $value)
    {

        return $this->connection()->rpush($this->prefix . $key, $value);
    }

    /**
     * 移除并返回列表key的头元素。
     * @param $key
     * @return mixed 列表的头元素。当key不存在时，返回nil。
     */
    public function lpop($key)
    {

        return $this->connection()->lpop($this->prefix . $key);
    }

    /**
     * 移除并返回列表key的尾元素。
     * @param $key
     * @return mixed 当key不存在时，返回nil。
     */
    public function rpop($key){

        return $this->connection()->rpop($this->prefix . $key);
    }

    /**
     * 它是LPOP命令的阻塞版本，当给定列表内没有任何元素可供弹出的时候，连接将被BLPOP命令阻塞，直到等待超时或发现可弹出元素为止。
     * 当给定多个key参数时，按参数key的先后顺序依次检查各个列表，弹出第一个非空列表的头元素。
     * @param array $keys
     * @param $timeout
     * @return mixed 如果列表为空，返回一个nil。反之，返回一个含有两个元素的列表，第一个元素是被弹出元素所属的key，第二个元素是被弹出元素的值。
     */
    public function blpop($keys, $timeout=0){

        if (is_array($keys) && isset($keys)){
            foreach ($keys as $key => $value){
                $arr[] = $this->prefix . $value;
            }
        }else{

            $arr = $this->prefix . $keys;
        }
        return $this->connection()->blpop($arr,$timeout);
    }

    /**
     * BRPOP是列表的阻塞式(blocking)弹出原语。
     * 它是RPOP命令的阻塞版本，当给定列表内没有任何元素可供弹出的时候，连接将被BRPOP命令阻塞，直到等待超时或发现可弹出元素为止。
     * 当给定多个key参数时，按参数key的先后顺序依次检查各个列表，弹出第一个非空列表的尾部元素。
     * 关于阻塞操作的更多信息，请查看BLPOP命令，BRPOP除了弹出元素的位置和BLPOP不同之外，其他表现一致。
     * @param $keys
     * @param int $timeout
     * @return mixed假如在指定时间内没有任何元素被弹出，则返回一个nil和等待时长。反之，返回一个含有两个元素的列表，第一个元素是被弹出元素所属的key，第二个元素是被弹出元素的值。
     */
    public function brpop($keys, $timeout=0){

        if (is_array($keys) && isset($keys)){
            foreach ($keys as $key => $value){
                $arr[] = $this->prefix . $value;
            }
        }else{

            $arr = $this->prefix . $keys;
        }
        return $this->connection()->brpop($arr,$timeout);
    }

    /**
     * 返回列表key的长度。
     * 如果key不存在，则key被解释为一个空列表，返回0.
     * 如果key不是列表类型，返回一个错误。
     * @param $key
     * @return mixed 列表key的长度。
     */
    public function llen($key){

        return $this->connection()->llen($this->prefix . $key);
    }

    /**
     *
     * 返回列表key中指定区间内的元素，区间以偏移量start和stop指定。
     * 下标(index)参数start和stop都以0为底，也就是说，以0表示列表的第一个元素，以1表示列表的第二个元素，以此类推。
     * 你也可以使用负数下标，以-1表示列表的最后一个元素，-2表示列表的倒数第二个元素，以此类推。
     * @param $key
     * @param int $start
     * @param int $stop
     * @return mixed 一个列表，包含指定区间内的元素。
     */
    public function lrange($key, $start=0, $stop=-1){

        return $this->connection()->lrange($this->prefix . $key,$start,$stop);
    }

    /**
     *
     * 根据参数count的值，移除列表中与参数value相等的元素。
     * count的值可以是以下几种：
     * count > 0: 从表头开始向表尾搜索，移除与value相等的元素，数量为count。
     * count < 0: 从表尾开始向表头搜索，移除与value相等的元素，数量为count的绝对值。
     * count = 0: 移除表中所有与value相等的值。
     * @param $key
     * @param $count
     * @param $value
     * @return mixed 被移除元素的数量。因为不存在的key被视作空表(empty list)，所以当key不存在时，LREM命令总是返回0。
     */
    public function lrem($key, $count, $value){

        return $this->connection()->lrem($this->prefix . $key,$count,$value);
    }

    /**
     * 将列表key下标为index的元素的值甚至为value。
     * 更多信息请参考LINDEX操作。当index参数超出范围，
     * 或对一个空列表(key不存在)进行LSET时，返回一个错误。
     * @param $key
     * @param $index
     * @param $value
     * @return mixed 操作成功返回ok，否则返回错误信息
     */
    public function lset($key, $index, $value){

        return $this->connection()->lset($this->prefix . $key,$index,$value);
    }

    /**
     * 对一个列表进行修剪(trim)，就是说，让列表只保留指定区间内的元素，不在指定区间之内的元素都将被删除。
     * 举个例子，执行命令LTRIM list 0 2，表示只保留列表list的前三个元素，其余元素全部删除。
     * 下标(index)参数start和stop都以0为底，也就是说，以0表示列表的第一个元素，以1表示列表的第二个元素，以此类推。
     * 你也可以使用负数下标，以-1表示列表的最后一个元素，-2表示列表的倒数第二个元素，以此类推。
     * 当key不是列表类型时，返回一个错误。
     * @param $key
     * @param int $start
     * @param int $stop
     * @return mixed 命令执行成功时，返回ok。
     */
    public function ltrim($key, $start=0, $stop=-1){

        return $this->connection()->ltrim($this->prefix . $key,$start,$stop);
    }

    /**
     * 返回列表key中，下标为index的元素。
     * 下标(index)参数start和stop都以0为底，也就是说，以0表示列表的第一个元素，以1表示列表的第二个元素，以此类推。
     * 你也可以使用负数下标，以-1表示列表的最后一个元素，-2表示列表的倒数第二个元素，以此类推。
     * 如果key不是列表类型，返回一个错误。
     * @param $key
     * @param int $index
     * @return mixed 列表中下标为index的元素。如果index参数的值不在列表的区间范围内(out of range)，返回nil。
     */
    public function lindex($key, $index=0){

        return $this->connection()->lindex($this->prefix . $key,$index);
    }

    /**
     * 将值value插入到列表key当中，位于值pivot之前或之后。
     * 当pivot不存在于列表key时，不执行任何操作。
     * 当key不存在时，key被视为空列表，不执行任何操作。
     * 如果key不是列表类型，返回一个错误。
     * @param $key
     * @param $pivot
     * @param $value
     * @param string $whence = BEFORE|AFTER
     * @return mixed如果命令执行成功，返回插入操作完成之后，列表的长度。如果没有找到pivot，返回-1。如果key不存在或为空列表，返回0。
     */
    public function  linsert($key,$pivot, $value,$whence="BEFORE"){

        return $this->connection()->linsert($this->prefix . $key,$whence,$pivot,$value);
    }

    /**
     * 如果source不存在，值nil被返回，并且不执行其他动作。
     * 如果source和destination相同，则列表中的表尾元素被移动到表头，并返回该元素，可以把这种特殊情况视作列表的旋转(rotation)操作。
     * @param $source
     * @param $destination
     * @return mixed 被弹出的元素。
     */
    public function rpoplpush($source, $destination){

        return $this->connection()->rpoplpush($this->prefix . $source,$this->prefix . $destination);
    }

    /**
     * 当列表source为空时，BRPOPLPUSH命令将阻塞连接，直到等待超时，或有另一个客户端对source执行LPUSH或RPUSH命令为止。
     * 超时参数timeout接受一个以秒为单位的数字作为值。超时参数设为0表示阻塞时间可以无限期延长(block indefinitely) 。
     * @param $source
     * @param $destination
     * @param int $timeout
     * @return mixed 假如在指定时间内没有任何元素被弹出，则返回一个nil和等待时长。反之，返回一个含有两个元素的列表，第一个元素是被弹出元素的值，第二个元素是等待时长。
     */
    public function brpoplpush($source, $destination, $timeout=0){

        return $this->connection()->brpoplpush($this->prefix . $source,$this->prefix . $destination,$timeout);

    }
}









