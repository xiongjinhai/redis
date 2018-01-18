<?php
/**
 * @File: HasheTraits.php
 * @Author: xiongjinhai
 * @Email:562740366@qq.com
 * @Date: 2018/1/10下午1:29
 * @Version:Version:1.1 2017 by www.dsweixin.com All Rights Reserver
 */

namespace Redis\Traits;


trait HasheTraits
{
    /**
     * 删除哈希表key中的一个或多个指定域，不存在的域将被忽略。
     * @param $key
     * @param array $fields
     * @return mixed 被成功移除的域的数量，不包括被忽略的域。
     */
    public function hdel($key, array $fields){

        return $this->connection()->hdel($this->prefix . $key,$fields);
    }

    /**
     * 查看哈希表key中，给定域field是否存在。
     * @param $key
     * @param $field
     * @return mixed 如果哈希表含有给定域，返回1。如果哈希表不含有给定域，或key不存在，返回0。
     */
    public function hexists($key, $field){

        return $this->connection()->hexists($this->prefix . $key,$field);
    }
    /**
     * 返回哈希表key中给定域field的值。
     * @param $key
     * @param $field
     * @return mixed 给定域的值。当给定域不存在或是给定key不存在时，返回nil。
     */
    public function hget($key, $field){

        return $this->connection()->hget($this->prefix . $key,$field);
    }

    /**
     * 返回哈希表key中，所有的域和值。
     * 在返回值里，紧跟每个域名(field name)之后是域的值(value)，所以返回值的长度是哈希表大小的两倍。
     * @param $key
     * @return mixed 以列表形式返回哈希表的域和域的值。 若key不存在，返回空列表。
     */
    public function hgetall($key){

        return $this->connection()->hgetall($this->prefix . $key);
    }

    /**
     * 为哈希表key中的域field的值加上增量increment。增量也可以为负数，相当于对给定域进行减法操作。
     * 如果key不存在，一个新的哈希表被创建并执行HINCRBY命令。如果域field不存在，那么在执行命令前，域的值被初始化为0。
     * 对一个储存字符串值的域field执行HINCRBY命令将造成一个错误。本操作的值限制在64位(bit)有符号数字表示之内。
     * @param $key
     * @param $field
     * @param $increment
     * @return mixed 执行HINCRBY命令之后，哈希表key中域field的值。
     */
    public function hincrby($key, $field, $increment){

        return $this->connection()->hincrby($this->prefix . $key,$field,$increment);
    }
    /**
     * 为哈希表key中的域field的值加上增量increment。增量也可以为负数，相当于对给定域进行减法操作。
     * 如果key不存在，一个新的哈希表被创建并执行HINCRBY命令。如果域field不存在，那么在执行命令前，域的值被初始化为0。
     * 对一个储存字符串值的域field执行HINCRBY命令将造成一个错误。本操作的值限制在64位(bit)有符号数字表示之内。
     * @param $key
     * @param $field
     * @param $increment
     * @return mixed 执行HINCRBY命令之后，哈希表key中域field的值。
     */
    public function hincrbyfloat($key, $field, $increment){

        return $this->connection()->hincrbyfloat($this->prefix . $key,$field,$increment);
    }
    /**
     * 返回哈希表key中的所有域。
     * @param $key
     * @return mixed 一个包含哈希表中所有域的表。当key不存在时，返回一个空表。
     */
    public function hkeys($key){

        return $this->connection()->hkeys($this->prefix . $key);
    }

    /**
     * 返回哈希表key中域的数量。
     * @param $key
     * @return mixed 哈希表中域的数量。当key不存在时，返回0。
     */
    public function hlen($key){

        return $this->connection()->hlen($this->prefix . $key);
    }
    /**
     * 返回哈希表key中，一个或多个给定域的值。
     * 如果给定的域不存在于哈希表，那么返回一个nil值。
     * 因为不存在的key被当作一个空哈希表来处理，所以对一个不存在的key进行HMGET操作将返回一个只带有nil值的表。
     * @param $key
     * @param array $fields
     * @return mixed 一个包含多个给定域的关联值的表，表值的排列顺序和给定域参数的请求顺序一样。
     */
    public function hmget($key, array $fields){

        return $this->connection()->hmget($this->prefix . $key,$fields);
    }
    /**
     * 同时将多个field - value(域-值)对设置到哈希表key中。
     * 此命令会覆盖哈希表中已存在的域。
     * 如果key不存在，一个空哈希表被创建并执行HMSET操作。
     * @param $key
     * @param array $dictionary
     * @return mixed 如果命令执行成功，返回OK。当key不是哈希表(hash)类型时，返回一个错误。
     */
    public function hmset($key, array $dictionary){

        return $this->connection()->hmset($this->prefix . $key,$dictionary);
    }

    /**
     * SCAN命令是一个基于游标的迭代器。这意味着命令每次被调用都需要使用上一次这个调用返回的游标作为该次调用的游标参数，以此来延续之前的迭代过程
     * 当SCAN命令的游标参数被设置为 0 时， 服务器将开始一次新的迭代， 而当服务器向用户返回值为 0 的游标时， 表示迭代已结束。
     * Predis::hscan(0,array('count' => ''));
     * @param $key
     * @param $cursor
     * @param array|null $options
     * @return mixed
     */
    public function hscan($key, $cursor, array $options = null){

        return $this->connection()->hscan($this->prefix . $key,$cursor, $options);
    }
    /**
     * 将哈希表key中的域field的值设为value。
     * 如果key不存在，一个新的哈希表被创建并进行HSET操作。
     * 如果域field已经存在于哈希表中，旧值将被覆盖。
     * @param $key
     * @param string $field
     * @param string $value
     * @return mixed
     * 如果field是哈希表中的一个新建域，并且值设置成功，返回1。
     * 如果哈希表中域field已经存在且旧值已被新值覆盖，返回0。
     */
    public function hset($key,$field,$value)
    {
        return $this->connection()->hset($this->prefix . $key,$field, $value);
    }

    /**
     * 将哈希表key中的域field的值设置为value，当且仅当域field不存在。
     * 若域field已经存在，该操作无效。
     * 如果key不存在，一个新哈希表被创建并执行HSETNX命令。
     * @param $key
     * @param $field
     * @param $value
     * @return mixed 设置成功，返回1。如果给定域已经存在且没有操作被执行，返回0。
     */
    public function hsetnx($key, $field, $value){

        return $this->connection()->hsetnx($this->prefix . $key,$field, $value);
    }

    /**
     * 返回field存储在哈希上的值的字符串长度key。如果key或者field不存在，则返回0。
     * @param $key
     * @param $field
     * @return mixed 与之相关联的值的字符串长度field，或者field在散列key中不存在时为零，或根本不存在。
     */
    public function hstrlen($key, $field){

        return $this->connection()->hstrlen($this->prefix . $key,$field);
    }
    /**
     * 返回哈希表key中的所有值。
     * @param $key
     * @return mixed 一个包含哈希表中所有值的表。当key不存在时，返回一个空表。
     */
    public function hvals($key){

        return $this->connection()->hvals($this->prefix . $key);
    }
}