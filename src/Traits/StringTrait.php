<?php
/**
 * @File: StringTrait.php
 * @Author: xiongjinhai
 * @Email:562740366@qq.com
 * @Date: 2017/12/12下午2:36
 * @Version:Version:1.1 2017 by www.dsweixin.com All Rights Reserver
 */

namespace Redis\Traits;

use Illuminate\Support\Facades\Redis;

trait StringTraits
{
    /**
     * 将字符串值value关联到key。
     * 如果key已经持有其他值，SET就覆写旧值，无视类型。
     * @param $key
     * @param $value
     * @param null $expireResolution
     * @param null $expireTTL
     * @param null $flag
     * @return mixed 总是返回OK(TRUE)，因为SET不可能失败。
     */
    public function set($key, $value, $expireResolution = null, $expireTTL = null, $flag = null){

        return Redis::set($this->prefix.$key,$value);
    }

    /**
     * 返回key所关联的字符串值。
     * 如果key不存在则返回特殊值nil。
     * 假如key储存的值不是字符串类型，返回一个错误，因为GET只能用于处理字符串值。
     * @param $key
     * @return mixed key的值。如果key不存在，返回nil。
     */
    public function get($key){

        return Redis::get($this->prefix.$key);
    }
}