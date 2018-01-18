<?php
/**
 * @File: StringTrait.php
 * @Author: xiongjinhai
 * @Email:562740366@qq.com
 * @Date: 2017/12/12下午2:36
 * @Version:Version:1.1 2017 by www.dsweixin.com All Rights Reserver
 */

namespace Redis\Traits;


trait StringTraits
{
    /**
     *
     * @param $key
     * @param string $value
     * @return mixed
     */
    public function append($key, $value)
    {
        return $this->connection()->append($this->prefix . $key, $value);
    }

    /**
     * 暂时没有好的案例
     * @param $key
     * @param $subcommand
     * @param array ...$subcommandArg PHP5.6 新特性-PHP 可变参数和参数解包
     * @return mixed
     */
    public function bitfield($key, $subcommand, ...$subcommandArg){

        return $this->connection()->bitfield($this->prefix . $key,$subcommand,$subcommandArg);
    }

    /**
     * 在多个键（包含字符串值）之间执行按位操作并将结果存储在目标键中。
     * 该BITOP命令支持四个位运算：AND，OR，XOR 和NOT，从而有效形式调用命
     * 正如你可以看到，NOT是特殊的，因为它只需要一个输入键，因为它执行位反转，所以它只作为一元运算符有意义。
     * 操作的结果总是存储在destkey。
     * @param $operation
     * @param $destkey
     * @param $key
     * @return mixed 存储在目标键中的字符串的大小，即等于最长输入字符串的大小。
     */
    public function  bitop($operation, $destkey, $key){

        return $this->connection()->bitop($operation,$this->prefix . $destkey,$key);
    }

    /**
     * 将字符串中第一位的位置返回为1或0。
     * @param $key
     * @param $start
     * @param $end
     * @return mixed 返回位置，将字符串视为从左到右的位数组，其中第一个字节的最高有效位位于0，第二个字节的最高有效位位于第8个位置，依此类推。
     */
    public function bitpos($key, $start, $end){

        return $this->connection()->bitpos($key,$start,$end);
    }
    /**
     * 计算字符串中设置的位数（计数）。
     * 默认情况下，检查字符串中包含的所有字节。只有在传递附加参数start和end的时间间隔中才可以指定计数操作。
     * @param $key
     * @return mixed 位数设置为1。
     */
    public function bitcount($key)
    {

        return $this->connection()->bitcount($this->prefix . $key);
    }
    /**
     * 将key中储存的数字值减一。
     * 如果key不存在，以0为key的初始值，然后执行DECR操作。
     * 如果值包含错误的类型，或字符串类型的值不能表示为数字，那么返回一个错误。
     * 本操作的值限制在64位(bit)有符号数字表示之内。
     * @param $key
     * @return mixed 执行DECR命令之后key的值。
     */
    public function decr($key)
    {
        return $this->connection()->decr($this->prefix . $key);
    }
    /**
     * 将key所储存的值减去减量decrement。
     * 如果key不存在，以0为key的初始值，然后执行DECRBY操作。
     * 如果值包含错误的类型，或字符串类型的值不能表示为数字，那么返回一个错误。
     * 本操作的值限制在64位(bit)有符号数字表示之内。
     * @param $key
     * @param int $decrement
     * @return mixed 减去decrement之后，key的值。
     */
    public function decrby($key, $decrement = 1)
    {
        return $this->connection()->decrby($this->prefix . $key, $decrement);
    }

    /**
     * 返回key所关联的字符串值。
     * 如果key不存在则返回特殊值nil。
     * 假如key储存的值不是字符串类型，返回一个错误，因为GET只能用于处理字符串值。
     * @param $key
     * @return mixed key的值。如果key不存在，返回nil。
     */
    public function get_unserialize($key)
    {

        $value = $this->connection()->get($this->prefix . $key);

        return !is_null($value) ? $this->unserialize($value) : null;
    }
    /**
     * 返回key所关联的字符串值。
     * 如果key不存在则返回特殊值nil。
     * 假如key储存的值不是字符串类型，返回一个错误，因为GET只能用于处理字符串值。
     * @param $key
     * @return mixed key的值。如果key不存在，返回nil。
     */
    public function get($key)
    {

        $value = $this->connection()->get($this->prefix . $key);

        return !is_null($value) ? $value : null;
    }
    /**
     * 对key所储存的字符串值，获取指定偏移量上的位(bit)。
     * 当offset比字符串值的长度大，或者key不存在时，返回0。
     * @param $key
     * @param $offset
     * @return mixed 字符串值指定偏移量上的位(bit)。
     */
    public function getbit($key, $offset)
    {

        return $this->connection()->getbit($this->prefix . $key, $offset);
    }
    /**
     * 返回key中字符串值的子字符串，字符串的截取范围由start和end两个偏移量决定(包括start和end在内)。
     * 负数偏移量表示从字符串最后开始计数，-1表示最后一个字符，-2表示倒数第二个，以此类推。
     * GETRANGE通过保证子字符串的值域(range)不超过实际字符串的值域来处理超出范围的值域请求。
     * @param $key
     * @param $start
     * @param $end
     * @return mixed 截取得出的子字符串。
     */
    public function getrange($key, $start, $end)
    {

        return $this->connection()->getrange($this->prefix . $key, $start, $end);
    }
    /**
     * 将给定key的值设为value，并返回key的旧值。
     * 当key存在但不是字符串类型时，返回一个错误。
     * @param $key
     * @param $value
     * @return mixed 返回给定key的旧值(old value)。当key没有旧值时，返回nil。
     */
    public function getset($key, $value){

        return $this->connection()->getset($this->prefix . $key,$value);
    }
    /**
     * 将key中储存的数字值增一。
     * 如果key不存在，以0为key的初始值，然后执行INCR操作。
     * 如果值包含错误的类型，或字符串类型的值不能表示为数字，那么返回一个错误。
     * 本操作的值限制在64位(bit)有符号数字表示之内。
     * @param $key
     * @return mixed 执行INCR命令之后key的值。
     */
    public function incr($key)
    {

        return $this->connection()->incr($this->prefix . $key);
    }
    /**
     * 将key所储存的值加上增量increment。
     * 如果key不存在，以0为key的初始值，然后执行INCRBY命令。
     * 如果值包含错误的类型，或字符串类型的值不能表示为数字，那么返回一个错误。
     * 本操作的值限制在64位(bit)有符号数字表示之内。
     * @param $key
     * @param int $increment
     * @return mixed 加上increment之后，key的值。
     */
    public function incrby($key, $increment = 1)
    {

        return $this->connection()->incrby($this->prefix . $key, $increment);
    }
    /**
     * 将key所储存的值加上指定的浮点数增量值。
     * 如果 key 不存在，那么 INCRBYFLOAT 会先将 key 的值设为 0 ，再执行加法操作。
     * @param $key
     * @param int $increment
     * @return mixed
     */
    public function incrbyfloat($key, $increment = 1)
    {

        return $this->connection()->incrbyfloat($this->prefix . $key, $increment);
    }
    /**
     * 返回所有(一个或多个)给定key的值。
     * 如果某个指定key不存在，那么返回特殊值nil。因此，该命令永不失败。
     * @param array $keys
     * @return mixed 一个包含所有给定key的值的列表。
     */
    public function mget(array $keys)
    {
        $array = array();

        if (!empty($this->prefix)){

            if (is_array($keys)){

                foreach ($keys as  $key => $value){

                    $array[$key] = $this->prefix.$value;
                }
            }
        }else{
            $array = $keys;
        }

        return $this->connection()->mget($array);
    }
    /**
     * 同时设置一个或多个key-value对。
     * 当发现同名的key存在时，MSET会用新值覆盖旧值，如果你不希望覆盖同名key，请使用MSETNX命令。
     * MSET是一个原子性(atomic)操作，所有给定key都在同一时间内被设置，某些给定key被更新而另一些给定key没有改变的情况，不可能发生。
     * @param array $dictionary
     * @return mixed 总是返回OK(因为MSET不可能失败)
     */
    public function mset(array $dictionary)
    {
        $array = array();

        if (!empty($this->prefix)){
            if (is_array($dictionary)){

                foreach ($dictionary as $key => $value){

                    $array[$this->prefix.$key] = $value;
                }
            }
        }else{

            $array = $dictionary;
        }

        return $this->connection()->mset($array);
    }
    /**
     * 同时设置一个或多个key-value对，当且仅当key不存在。
     * 即使只有一个key已存在，MSETNX也会拒绝所有传入key的设置操作
     * MSETNX是原子性的，因此它可以用作设置多个不同key表示不同字段(field)的唯一性逻辑对象(unique logic object)，所有字段要么全被设置，要么全不被设置。
     * @param array $dictionary
     * @return mixed 当所有key都成功设置，返回1。如果所有key都设置失败(最少有一个key已经存在)，那么返回0。
     */
    public function msetnx(array $dictionary){

        $array = array();

        if (!empty($this->prefix)){
            if (is_array($dictionary)){

                foreach ($dictionary as $key => $value){

                    $array[$this->prefix.$key] = $value;
                }
            }
        }else{

            $array = $dictionary;
        }

        return $this->connection()->msetnx($array);
    }
    /**
     * 这个命令和 SETEX 命令相似，但它以毫秒为单位设置 key 的生存时间，而不是像 SETEX 命令那样，以秒为单位。
     * @param $key
     * @param $milliseconds
     * @param $value
     * @return mixed 设置成功时返回 OK 。
     */
    public function  psetex($key, $milliseconds, $value){

        return $this->connection()->psetex($this->prefix . $key, $milliseconds,$value);
    }
    /**
     * 将字符串值value关联到key。
     * 如果key已经持有其他值，SET就覆写旧值，无视类型。
     * @param $key
     * @param $value
     * @return mixed 总是返回OK(TRUE)，因为SET不可能失败。
     */
    public function set_serialize($key, $value)
    {

        return $this->connection()->set($this->prefix . $key, $this->serialize($value));
    }
    /**
     * 将字符串值value关联到key。
     * 如果key已经持有其他值，SET就覆写旧值，无视类型。
     * @param $key
     * @param $value
     * @return mixed 总是返回OK(TRUE)，因为SET不可能失败。
     */
    public function set($key, $value)
    {

        return $this->connection()->set($this->prefix . $key, $value);
    }

    /**
     * 对key所储存的字符串值，设置或清除指定偏移量上的位(bit)。
     * 位的设置或清除取决于value参数，可以是0也可以是1。
     * 当key不存在时，自动生成一个新的字符串值。
     * 字符串会增长(grown)以确保它可以将value保存在指定的偏移量上。
     * 当字符串值增长时，空白位置以0填充。
     * offset参数必须大于或等于0，小于2^32(bit映射被限制在512MB内)。
     * @param $key
     * @param $offset
     * @param $value
     * @return mixed
     */
    public function setbit($key, $offset, $value)
    {

        return $this->connection()->setbit($this->prefix . $key, $offset, $value);
    }
    /**
     * 将值value关联到key，并将key的生存时间设为seconds(以秒为单位)。
     * 如果key 已经存在，SETEX命令将覆写旧值。
     * @param $key
     * @param $seconds
     * @param $value
     * @return mixed 设置成功时返回OK。当seconds参数不合法时，返回一个错误。
     */
    public function  setex($key, $seconds, $value){

        return $this->connection()->setex($this->prefix . $key, $seconds,$value);
    }
    /**
     * 将key的值设为value，当且仅当key不存在。
     * 若给定的key已经存在，则SETNX不做任何动作。
     * SETNX是”SET if Not eXists”(如果不存在，则SET)的简写。
     * @param $key
     * @param $value
     * @return mixed 设置成功，返回1。设置失败，返回0。
     */
    public function setnx($key, $value)
    {

        return $this->connection()->setnx($this->prefix . $key, $value);
    }
    /**
     * 用value参数覆写(Overwrite)给定key所储存的字符串值，从偏移量offset开始。
     * 不存在的key当作空白字符串处理。
     * SETRANGE命令会确保字符串足够长以便将value设置在指定的偏移量上，如果给定key原来储存的字符串长度比偏移量小(比如字符串只有5个字符长，但你设置的offset是10)，那么原字符和偏移量之间的空白将用零比特(zerobytes,"\x00")来填充。
     * 注意你能使用的最大偏移量是2^29-1(536870911)，因为Redis的字符串被限制在512兆(megabytes)内。如果你需要使用比这更大的空间，你得使用多个key。
     * @param $key
     * @param $offset
     * @param $value
     * @return mixed 被SETRANGE修改之后，字符串的长度。
     */
    public function setrange($key, $offset, $value)
    {

        return $this->connection()->setrange($this->prefix . $key, $offset, $value);
    }

    /**
     * 返回key所储存的字符串值的长度。
     * 当key储存的不是字符串值时，返回一个错误。
     * @param $key
     * @return mixed 字符串值的长度。当 key不存在时，返回0。
     */
    public function strlen($key)
    {

        return $this->connection()->strlen($this->prefix . $key);
    }
}