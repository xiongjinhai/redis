<?php
/**
 * @File: SetTraits.php
 * @Author: xiongjinhai
 * @Email:562740366@qq.com
 * @Date: 2018/3/20上午10:48
 * @Version:Version:1.1 2017 by www.dsweixin.com All Rights Reserver
 */

namespace Redis\Traits;


trait SetTraits
{
    /**
     * 移除集合key中的一个或多个member元素，不存在的member元素会被忽略。当key不是集合类型，返回一个错误。
     * @param $key
     * @param $member
     * @return mixed 被成功移除的元素的数量，不包括被忽略的元素。
     */
    public function srem($key, $member){

        return $this->connection()->srem($this->prefix . $key,$member);
    }
    /**
     * 将一个或多个member元素加入到集合key当中，已经存在于集合的member元素将被忽略。
     * 假如key不存在，则创建一个只包含member元素作成员的集合。
     * 当key不是集合类型时，返回一个错误。
     * @param $key
     * @param array $members
     * @return mixed 被添加到集合中的新元素的数量，不包括被忽略的元素。
     */
    public function sadd($key,$members){

        return $this->connection()->sadd($this->prefix . $key,$members);
    }

    /**
     * 返回集合key中的所有成员。
     * @param $key
     * @return mixed 集合中的所有成员。
     */
    public function  smembers($key){

        return $this->connection()->smembers($this->prefix . $key);
    }

    /**
     * 判断member元素是否是集合key的成员。
     * @param $key
     * @param $member
     * @return mixed 如果member元素是集合的成员，返回1。如果member元素不是集合的成员，或key不存在，返回0。
     */
    public function  sismember($key, $member){

        return $this->connection()->sismember($this->prefix . $key,$member);
    }

    /**
     * 返回集合key的基数(集合中元素的数量)。
     * @param $key
     * @return mixed 当key不存在时，返回0。
     */
    public function  scard($key){

        return $this->connection()->scard($this->prefix . $key);
    }

    /**
     * 将member元素从source集合移动到destination集合。
     * SMOVE是原子性操作。
     * 如果source集合不存在或不包含指定的member元素，则SMOVE命令不执行任何操作，仅返回0。
     * 否则，member元素从source集合中被移除，并添加到destination集合中去。
     * 当destination集合已经包含member元素时，SMOVE命令只是简单地将source集合中的member元素删除。
     * 当source或destination不是集合类型时，返回一个错误。
     * @param $source
     * @param $destination
     * @param $member
     * @return mixed 如果member元素被成功移除，返回1。 如果member元素不是source集合的成员，并且没有任何操作对destination集合执行，那么返回0。
     */
    public function  smove($source, $destination, $member){

        return $this->connection()->smove($this->prefix . $source,$this->prefix.$destination,$member);
    }

    /**
     * 移除并返回集合中的一个随机元素。
     * @param $key
     * @param null $count
     * @return mixed 被移除的随机元素。当key不存在或key是空集时，返回nil。
     */
    public function spop($key, $count = null){

        return $this->connection()->spop($this->prefix . $key,$count);
    }
    /**
     * 返回集合中的一个随机元素。
     * 该操作和SPOP相似，但SPOP将随机元素从集合中移除并返回，而SRANDMEMBER则仅仅返回随机元素，而不对集合进行任何改动。
     * @param $key
     * @param null $count
     * @return mixed 被选中的随机元素。 当key不存在或key是空集时，返回nil。
     */
    public function srandmember($key, $count = null){

        return $this->connection()->srandmember($this->prefix . $key,$count);
    }


    /**
     * 返回一个集合的全部成员，该集合是所有给定集合的交集。
     * 不存在的key被视为空集。
     * 当给定集合当中有一个空集时，结果也为空集(根据集合运算定律)。
     * @param $keys
     * @return mixed 交集成员的列表。
     */
    public function  sinter($keys){

        if (is_array($keys) && isset($keys)){
            foreach ($keys as $key => $value){
                $arr[] = $this->prefix . $value;
            }
        }else{

            $arr = $this->prefix . $keys;
        }
        return $this->connection()->sinter($arr);
    }

    /**
     * 此命令等同于SINTER，但它将结果保存到destination集合，而不是简单地返回结果集。
     * 如果destination集合已经存在，则将其覆盖。destination可以是key本身,不存在删除destination可以是key本身值
     * @param $destination
     * @param $keys
     * @return mixed 结果集中的成员数量。
     */
    public function  sinterstore($destination, $keys){

        if (is_array($keys) && isset($keys)){
            foreach ($keys as $key => $value){
                $arr[] = $this->prefix . $value;
            }
        }else{

            $arr = $this->prefix . $keys;
        }

        return $this->connection()->sinterstore($this->prefix . $destination,$arr);
    }

    /**
     * 返回一个集合的全部成员，该集合是所有给定集合的并集。
     * 不存在的key被视为空集。
     * @param $keys
     * @return mixed 并集成员的列表。
     */
    public function  sunion($keys){

        if (is_array($keys) && isset($keys)){
            foreach ($keys as $key => $value){
                $arr[] = $this->prefix . $value;
            }
        }else{

            $arr = $this->prefix . $keys;
        }

        return $this->connection()->sunion($arr);
    }

    /**
     * 此命令等同于SUNION，但它将结果保存到destination集合，而不是简单地返回结果集。
     * 如果destination已经存在，则将其覆盖。
     * destination可以是key本身。
     * @param $destination
     * @param $keys
     * @return mixed 结果集中的元素数量。
     */
    public function  sunionstore($destination, $keys){

        if (is_array($keys) && isset($keys)){
            foreach ($keys as $key => $value){
                $arr[] = $this->prefix . $value;
            }
        }else{

            $arr = $this->prefix . $keys;
        }

        return $this->connection()->sunionstore($this->prefix . $destination,$arr);
    }

    /**
     * 返回一个集合的全部成员，该集合是所有给定集合的差集 。
     * 不存在的key被视为空集。
     * @param $keys
     * @return mixed 交集成员的列表
     */
    public function  sdiff($keys){

        if (is_array($keys) && isset($keys)){
            foreach ($keys as $key => $value){
                $arr[] = $this->prefix . $value;
            }
        }else{

            $arr = $this->prefix . $keys;
        }

        return $this->connection()->sdiff($arr);
    }

    /**
     * 此命令等同于SDIFF，但它将结果保存到destination集合，而不是简单地返回结果集。
     * 如果destination集合已经存在，则将其覆盖。
     * destination可以是key本身。
     * @param $destination
     * @param $keys
     * @return mixed 结果集中的元素数量
     */
    public function  sdiffstore($destination, $keys){

        if (is_array($keys) && isset($keys)){
            foreach ($keys as $key => $value){
                $arr[] = $this->prefix . $value;
            }
        }else{

            $arr = $this->prefix . $keys;
        }

        return $this->connection()->sdiffstore($this->prefix . $destination,$arr);
    }
}