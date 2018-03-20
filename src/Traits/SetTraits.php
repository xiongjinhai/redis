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
    public function sadd($key, array $members){

        return $this->connection()->sadd($this->prefix . $key,$members);
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

}