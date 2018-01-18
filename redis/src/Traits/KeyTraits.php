<?php
/**
 * @File: KeyTraits.php
 * @Author: xiongjinhai
 * @Email:562740366@qq.com
 * @Date: 2017/12/15下午2:47
 * @Version:Version:1.1 2017 by www.dsweixin.com All Rights Reserver
 */

namespace Redis\Traits;


trait KeyTraits
{
    /**
     * 移除给定的一个或多个key。
     * 如果key不存在，则忽略该命令。
     * @param array $keys
     * @return mixed 被移除key的数量。
     */
    public function del(array $keys)
    {
        $data = array();

        if (is_array($keys)) {

            foreach ($keys as $value) {

                $data[] = $this->prefix . $value;
            }
        }

        return $this->connection()->del($data);
    }

    /**
     * 序列化给定 key ，并返回被序列化的值
     * @param $key
     * @return mixed 如果 key 不存在，那么返回 nil。</br> 否则，返回序列化之后的值。
     */
    public function dump($key)
    {

        return $this->connection()->dump($this->prefix . $key);
    }

    /**
     * 检查给定key是否存在。
     * @param $key
     * @return mixed 若key存在，返回1，否则返回0。
     */
    public function exists($key)
    {

        return $this->connection()->exists($this->prefix . $key);
    }

    /**
     * 为给定key设置生存时间。
     * 当key过期时，它会被自动删除。
     * @param $key
     * @param int $seconds
     * @return mixed 设置成功返回1。当key不存在或者不能为key设置生存时间时(比如在低于2.1.3中你尝试更新key的生存时间)，返回0。
     */
    public function expire($key, $seconds = 0)
    {

        return $this->connection()->expire($this->prefix . $key, $seconds);
    }

    /**
     * 令接受的时间参数是UNIX时间戳(unix timestamp)。
     * @param $key
     * @param $timestamp
     * @return mixed 如果生存时间设置成功，返回1。当key不存在或没办法设置生存时间，返回0。
     */
    public function expireat($key, $timestamp)
    {

        return $this->connection()->expireat($this->prefix . $key, $timestamp);
    }

    /**
     * 查找符合给定模式的key。
     * KEYS *命中数据库中所有key。
     * KEYS h?llo命中hello， hallo and hxllo等。
     * KEYS h*llo命中hllo和heeeeello等。
     * KEYS h[ae]llo命中hello和hallo，但不命中hillo。
     * @param $pattern
     * @return mixed     符合给定模式的key列表。
     * 警告 :KEYS的速度非常快，但在一个大的数据库中使用它仍然可能造成性能问题，如果你需要从一个数据集中查找特定的key，你最好还是用集合(Set)。
     */
    public function keys($pattern)
    {
        return $this->connection()->keys($this->prefix . $pattern);
    }
    /**
     * 将当前数据库(默认为0)的key移动到给定的数据库db当中。
     * 如果当前数据库(源数据库)和给定数据库(目标数据库)有相同名字的给定key，或者key不存在于当前数据库，那么MOVE没有任何效果。
     * 因此，也可以利用这一特性，将MOVE当作锁(locking)原语。
     * @param $key
     * @param $db
     * @return mixed 移动成功返回1，失败则返回0。
     */
    public function move($key, $db)
    {

        return $this->connection()->move($this->prefix . $key, $db);

    }

    /*OBJECT命令有多个子命令：
    OBJECT REFCOUNT <key>返回给定key引用所储存的值的次数。此命令主要用于除错。
    OBJECT ENCODING <key>返回给定key锁储存的值所使用的内部表示(representation)。
    OBJECT IDLETIME <key>返回给定key自储存以来的空转时间(idle， 没有被读取也没有被写入)，以秒为单位。
    对象可以以多种方式编码：
    字符串可以被编码为raw(一般字符串)或int(用字符串表示64位数字是为了节约空间)。
    列表可以被编码为ziplist或linkedlist。ziplist是为节约大小较小的列表空间而作的特殊表示。
    集合可以被编码为intset或者hashtable。intset是只储存数字的小集合的特殊表示。
    哈希表可以编码为zipmap或者hashtable。zipmap是小哈希表的特殊表示。
    有序集合可以被编码为ziplist或者skiplist格式。ziplist用于表示小的有序集合，而skiplist则用于表示任何大小的有序集合。
    假如你做了什么让Redis没办法再使用节省空间的编码时(比如将一个只有1个元素的集合扩展为一个有100万个元素的集合)，特殊编码类型(specially encoded types)会自动转换成通用类型(general type)。*/
    /**
     * OBJECT命令允许从内部察看给定key的Redis对象。
     * 它通常用在除错(debugging)或者了解为了节省空间而对key使用特殊编码的情况。
     * 当将Redis用作缓存程序时，你也可以通过OBJECT命令中的信息，决定key的驱逐策略(eviction policies)。
     * @param $subcommand
     * @param $key
     * @return mixed REFCOUNT和IDLETIME返回数字。ENCODING返回相应的编码类型。
     */
    public function object($subcommand, $key)
    {

        return $this->connection()->object($subcommand, $this->prefix . $key);
    }

    /**
     * 移除给定key的生存时间。
     * @param $key
     * @return mixed 当生存时间移除成功时，返回1.如果key不存在或key没有设置生存时间，返回0。
     */
    public function persist($key)
    {

        return $this->connection()->persist($this->prefix . $key);
    }

    /**
     * 命令和EXPIRE命令的作用类似，但是它以毫秒为单位设置 key 的生存时间，而不像EXPIRE命令那样，以秒为单位。
     * @param $key
     * @param $milliseconds
     * @return mixed 设置成功，返回 1 key 不存在或设置失败，返回 0
     */
    public function pexpire($key, $milliseconds = 0)
    {

        return $this->connection()->pexpire($this->prefix . $key, $milliseconds);
    }

    /**
     * 命令和EXPIREAT命令类似，但它以毫秒为单位设置 key 的过期 unix 时间戳，而不是像EXPIREAT那样，以秒为单位。
     * @param $key
     * @param $timestamp
     * @return mixed 设置成功，返回 1 key 不存在或设置失败，返回 0
     */
    public function pexpireat($key, $timestamp)
    {

        return $this->connection()->pexpireat($this->prefix . $key, $timestamp);
    }

    /**
     * 这个命令类似于TTL命令，但它以毫秒为单位返回 key 的剩余生存时间，而不是像TTL命令那样，以秒为单位。
     * @param $key
     * @return mixed 如果key不存在返回-2 如果key存在且无过期时间返回-1 TTL以毫秒为单位
     */
    public function pttl($key)
    {

        return $this->connection()->pttl($this->prefix . $key);
    }

    /**
     * 从当前数据库中随机返回(不删除)一个key。
     * @return mixed 当数据库不为空时，返回一个key。当数据库为空时，返回nil。
     */
    public function randomkey()
    {

        return $this->connection()->randomkey();
    }

    /**
     * 将key改名为newkey。
     * 当key和newkey相同或者key不存在时，返回一个错误。
     * 当newkey已经存在时，RENAME命令将覆盖旧值。
     * @param $key
     * @param $target
     * @return mixed 改名成功时提示OK，失败时候返回一个错误
     */
    public function rename($key, $target)
    {

        return $this->connection()->rename($this->prefix . $key, $this->prefix . $target);
    }

    /**
     * 当且仅当newkey不存在时，将key改为newkey。
     * 出错的情况和RENAME一样(key不存在时报错)。
     * @param $key
     * @param $target
     * @return mixed 修改成功时，返回1。如果newkey已经存在，返回0
     */
    public function renamenx($key, $target)
    {

        return $this->connection()->renamenx($this->prefix . $key, $this->prefix . $target);
    }

    /**
     * 创建与通过反序列化提供的序列化值（通过DUMP获取）获得的值关联的键。
     * 如果ttl为0，则密钥创建时不会过期，否则设置指定的过期时间（以毫秒为单位）。
     * @param $key
     * @param $milliseconds
     * @param $serialized_value
     * @return mixed 该命令成功返回OK。
     */
    public function restore($key, $milliseconds = 0, $serialized_value)
    {

        return $this->connection()->restore($this->prefix . $key, $milliseconds, $serialized_value);
    }

    /**
     * SCAN命令是一个基于游标的迭代器。这意味着命令每次被调用都需要使用上一次这个调用返回的游标作为该次调用的游标参数，以此来延续之前的迭代过程
     * 当SCAN命令的游标参数被设置为 0 时， 服务器将开始一次新的迭代， 而当服务器向用户返回值为 0 的游标时， 表示迭代已结束。
     * Predis::scan(0,array('count' => ''));
     * @param $cursor
     * @param array|null $options
     * @return mixed
     */
    public function scan($cursor, array $options = null)
    {
        return $this->connection()->scan($cursor, $options);
    }

    /**
     * [BY pattern] [LIMIT offset count] [GET pattern [GET pattern ...]] [ASC|DESC] [ALPHA] [STORE destination]
     * 最简单的SORT使用方法是SORT key。
     * 假设today_cost是一个保存数字的列表，SORT命令默认会返回该列表值的递增(从小到大)排序结果。
     * @param $key
     * @param array|null $options
     * @return mixed
     */
    public function sort($key, array $options = null){

        return $this->connection()->sort($this->prefix . $key, $options);
    }

    /**
     * 返回给定key的剩余生存时间(time to live)(以秒为单位)。
     * @param $key
     * @return mixed key的剩余生存时间(以秒为单位)。当key不存在或没有设置生存时间时，返回-1 。
     */
    public function ttl($key){

        return $this->connection()->ttl($this->prefix . $key);
    }

    /**
     * 返回key所储存的值的类型。
     * @param $key
     * @return mixed
     * none(key不存在) int(0) string(字符串) int(1) list(列表) int(3) et(集合) int(2) zset(有序集) int(4) hash(哈希表) int(5)
     */
    public function type($key){

        return $this->connection()->type($this->prefix . $key);
    }

    /**
     * 自4.0.0起可用。
     * 这个命令非常类似于DEL：它删除指定的键。就像DEL键一样，如果它不存在，它将被忽略。
     * 但是，该命令在不同的线程中执行实际的内存回收，所以它不会阻塞，而DEL是。这是命令名称的来源：命令只是将键与键空间断开连接。
     * 实际删除将在以后异步发生。
     * @param $key
     * @return mixed
     */
    public function unlink($key){

        return $this->connection()->unlink($this->prefix . $key);
    }

    /*此命令阻塞当前客户端，直到所有以前的写命令都成功的传输和指定的slaves确认。如果超时，指定以毫秒为单位，即使指定的slaves还没有到达，命令任然返回。
    命令始终返回之前写命令发送的slaves的数量，无论是在指定slaves的情况还是达到超时。
    注意点:
    当’WAIT’返回时，所有之前的写命令保证接收由WAIT返回的slaves的数量。
    如果命令呗当做事务的一部分发送，该命令不阻塞，而是只尽快返回先前写命令的slaves的数量。
    如果timeout是0那意味着永远阻塞。
    由于WAIT返回的是在失败和成功的情况下的slaves的数量。客户端应该检查返回的slaves的数量是等于或更大的复制水平。*/
    /**
     * @param $numslaves
     * @param $timeout
     * @return mixed 该命令返回在当前连接的上下文中执行的所有写操作所达到的从服务器的数量。
     */
    public function wait($numslaves, $timeout){

        return $this->connection()->wait($numslaves,$timeout);
    }
}