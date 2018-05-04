<?php
/**
 * @File: SortedSetTraits.php
 * @Author: xiongjinhai
 * @Email:562740366@qq.com
 * @Date: 2018/3/20上午10:48
 * @Version:Version:1.1 2017 by www.dsweixin.com All Rights Reserver
 */

namespace Redis\Traits;

//有序集
trait SortedSetTraits
{
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
     * 移除有序集key中的一个或多个成员，不存在的成员将被忽略。当key存在但不是有序集类型时，返回一个错误。
     * @param $key
     * @param $member
     * @return mixed 被成功移除的成员的数量，不包括被忽略的成员。
     */
    public function zrem($key, $member){

        return $this->connection()->zrem($this->prefix . $key,$member);
    }

    /**
     * 返回有序集key的基数。
     * @param $key
     * @return mixed 当key存在且是有序集类型时，返回有序集的基数。当key不存在时，返回0。
     */
    public function zcard($key){

        return $this->connection()->zcard($this->prefix . $key);
    }

    /**
     * 返回有序集key中，score值在min和max之间(默认包括score值等于min或max)的成员。
     * @param $key
     * @param int $min
     * @param int $max
     * @return mixed score值在min和max之间的成员的数量。
     */
    public function zcount($key, $min=0, $max=0){

        return $this->connection()->zcount($this->prefix . $key,$min,$max);
    }

    /**
     * 成员名称前需要加 [ 符号作为开头, [ 符号与成员之间不能有空格
     * 可以使用 - 和 + 表示得分最小值和最大值
     * @param $key
     * @param string $min
     * @param string $max
     * @return mixed 有序集合中成员名称 min 和 max 之间的成员数量; Integer类型。
     */
    public function  zlexcount($key, $min='-', $max='+'){

        return $this->connection()->zlexcount($this->prefix . $key,$min,$max);
    }
    /**
     * 返回有序集key中，成员member的score值。
     * 如果member元素不是有序集key的成员，或key不存在，返回nil。
     * @param $key
     * @param $member
     * @return mixed member成员的score值，以字符串形式表示。
     */
    public function zscore($key, $member){

        return $this->connection()->zscore($this->prefix . $key,$member);
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

    /**
     * 返回有序集key中，指定区间内的成员。
     * 其中成员的位置按score值递增(从小到大)来排序。
     * @param $key
     * @param int $start
     * @param int $stop
     * @param array $options
     * @return mixed 指定区间内，带有score值(可选)的有序集成员的列表。
     */
    public function zrange($key, $start=0, $stop=-1, $options = array('WITHSCORES')){

        return $this->connection()->zrange($this->prefix . $key,$start,$stop,$options);
    }

    /**
     *
     * @param $key
     * @param string $start
     * @param string $stop
     * @param array $options
     * @return mixed 指定成员范围的元素列表。
     */
    public function zrangebylex($key, $start='-', $stop='+', $options = array('WITHSCORES')){

        return $this->connection()->zrangebylex($this->prefix . $key,$start,$stop,$options);
    }

    /**
     * 未实现
     * @param $key
     * @param string $start
     * @param string $stop
     * @param array $options
     * @return mixed
     */
    public function zrevrangebylex($key, $start='-', $stop='+', $options = array('WITHSCORES')){

        return $this->connection()->zrevrangebylex($this->prefix . $key,$start,$stop,$options);
    }
    /**
     * 其中成员的位置按score值递减(从大到小)来排列。
     * @param $key
     * @param int $start
     * @param int $stop
     * @param array $options
     * @return mixed 指定区间内，带有score值(可选)的有序集成员的列表。
     */
    public function zrevrange($key, $start=0, $stop=-1, $options = array('WITHSCORES')){

        return $this->connection()->zrevrange($this->prefix . $key,$start,$stop,$options);
    }


    /**
     * 返回有序集key中，所有score值介于min和max之间(包括等于min或max)的成员。有序集成员按score值递增(从小到大)次序排列。
     * @param $key
     * @param int $min
     * @param int $max
     * @param array $options
     * @return mixed 指定区间内，带有score值(可选)的有序集成员的列表。
     */
    public function  zrangebyscore($key, $min=0, $max=0, $options = array('WITHSCORES')){

        return $this->connection()->zrangebyscore($this->prefix . $key,$min,$max,$options);
    }

    /**
     * 返回有序集key中，score值介于max和min之间(默认包括等于max或min)的所有的成员。有序集成员按score值递减(从大到小)的次序排列。
     * @param $key
     * @param int $max
     * @param int $min
     * @param array $options
     * @return mixed 指定区间内，带有score值(可选)的有序集成员的列表。
     */
    public function zrevrangebyscore($key, $max=0, $min=0, $options = array('WITHSCORES')){

        return $this->connection()->zrevrangebyscore($this->prefix . $key,$min,$max,$options);
    }

    /**
     * 返回有序集key中成员member的排名。其中有序集成员按score值递增(从小到大)顺序排列。
     * 排名以0为底，也就是说，score值最小的成员排名为0。
     * 使用ZREVRANK命令可以获得成员按score值递减(从大到小)排列的排名。
     * @param $key
     * @param $member
     * @return mixed 如果member是有序集key的成员，返回member的排名。如果member不是有序集key的成员，返回nil
     */
    public function  zrank($key, $member){

        return $this->connection()->zrank($this->prefix . $key,$member);
    }

    /**
     * 返回有序集key中成员member的排名。其中有序集成员按score值递减(从大到小)排序。
     * 排名以0为底，也就是说，score值最大的成员排名为0。
     * 使用ZRANK命令可以获得成员按score值递增(从小到大)排列的排名。
     * @param $key
     * @param $member
     * @return mixed 如果member是有序集key的成员，返回member的排名。如果member不是有序集key的成员，返回nil。
     */
    public function zrevrank($key, $member){

        return $this->connection()->zrevrank($this->prefix . $key,$member);
    }

    /**
     * ZREMRANGEBYLEX 删除名称按字典由低到高排序成员之间所有成员。
     * 不要在成员分数不同的有序集合中使用此命令, 因为它是基于分数一致的有序集合设计的,如果使用,会导致删除的结果不正确。
     * 待删除的有序集合中,分数最好相同,否则删除结果会不正常。
     * @param $key
     * @param string $min
     * @param string $max
     * @return mixed 删除元素的个数。
     */
    public function zremrangebylex($key, $min='-', $max='+'){

        return $this->connection()->zremrangebylex($this->prefix . $key,$min,$max);
    }
    /**
     * 移除有序集key中，指定排名(rank)区间内的所有成员
     *下标参数start和stop都以0为底，也就是说，以0表示有序集第一个成员，以1表示有序集第二个成员，以此类推。
     * 你也可以使用负数下标，以-1表示最后一个成员，-2表示倒数第二个成员，以此类推。
     * @param $key
     * @param int $start
     * @param int $stop
     * @return mixed 被移除成员的数量。
     */
    public function  zremrangebyrank($key, $start=0, $stop=-1){

        return $this->connection()->zremrangebyrank($this->prefix . $key,$start,$stop);
    }

    /**
     * 移除有序集key中，所有score值介于min和max之间(包括等于min或max)的成员。
     * @param $key
     * @param int $min
     * @param int $max
     * @return mixed 被移除成员的数量。
     */
    public function  zremrangebyscore($key, $min=0, $max=1){

        return $this->connection()->zremrangebyscore($this->prefix . $key,$min,$max);
    }

    /**
     * 计算给定的一个或多个有序集的交集，其中给定key的数量必须以numkeys参数指定，并将该交集(结果集)储存到destination。默认情况下，结果集中某个成员的score值是所有给定集下该成员score值之和。
     * @param $destination
     * @param array $keys
     * @param array $options
     * @return mixed 保存到destination的结果集的基数。
     */
    public function zinterstore($destination, array  $keys, $options = array('WEIGHTS')){

        if (is_array($keys) && isset($keys)){
            foreach ($keys as $key => $value){
                $arr[] = $this->prefix . $value;
            }
        }
        return $this->connection()->zinterstore($this->prefix.$destination,$arr,$options);
    }

    /**
     * 计算给定的一个或多个有序集的并集，其中给定key的数量必须以numkeys参数指定，并将该并集(结果集)储存到destination。默认情况下，结果集中某个成员的score值是所有给定集下该成员score值之和。
     * @param $destination
     * @param array $keys
     * @param array $options
     * @return mixed 保存到destination的结果集的基数。
     */
    public function  zunionstore($destination, array $keys,$options = array('WEIGHTS')){

        if (is_array($keys) && isset($keys)){
            foreach ($keys as $key => $value){
                $arr[] = $this->prefix . $value;
            }
        }
        return $this->connection()->zunionstore($this->prefix.$destination,$arr,$options);
    }
}