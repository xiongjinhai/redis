<?php
/**
 * @File: SortedSetTraits.php
 * @Author: xiongjinhai
 * @Email:562740366@qq.com
 * @Date: 2018/3/20上午10:48
 * @Version:Version:1.1 2017 by www.dsweixin.com All Rights Reserver
 */

namespace Redis\Traits;


trait SortedSetTraits
{
    //有序集合
    /**
     * 将一个或多个member元素及其score值加入到有序集key当中。
     * 如果某个member已经是有序集的成员，那么更新这个member的score值，并通过重新插入这个member元素，来保证该member在正确的位置上。
     * score值可以是整数值或双精度浮点数。
     * 如果key不存在，则创建一个空的有序集并执行ZADD操作。
     * 当key存在但不是有序集类型时，返回一个错误。
     * 对有序集的更多介绍请参见sorted set。
     * @param $key
     * @param array $membersAndScoresDictionary
     * @return mixed 被成功添加的新成员的数量，不包括那些被更新的、已经存在的成员。
     */
    public function zadd($key, array $membersAndScoresDictionary){

        return $this->connection()->zadd($this->prefix . $key,$membersAndScoresDictionary);
    }

    /**
     *
     * 有序集key的成员member的score值加上增量increment。
     * 你也可以通过传递一个负数值increment，让score减去相应的值，比如ZINCRBY key -5 member，就是让member的score值减去5。
     * 当key不存在，或member不是key的成员时，ZINCRBY key increment member等同于ZADD key increment member。
     * @param $key
     * @param $increment
     * @param $member
     * @return mixed member成员的新score值，以字符串形式表示。
     */
    public function zincrby($key, $increment, $member){

        return $this->connection()->zincrby($this->prefix . $key,$increment,$member);
    }
}