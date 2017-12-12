<?php
/**
 * @File: Predis.php
 * @Author: xiongjinhai
 * @Email:562740366@qq.com
 * @Date: 2017/12/12上午10:42
 * @Version:Version:1.1 2017 by www.dsweixin.com All Rights Reserver
 */

namespace Redis;

use Redis\Traits\StringTrait;

class Predis
{
    use StringTrait;

    protected $prefix;

    public function __construct($prefix = "")
    {

        $this->setPrefix($prefix);
    }
    /**
     * Get the cache key prefix.
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }
    /**
     * Set the cache key prefix.
     *
     * @param  string  $prefix
     * @return void
     */
    public function setPrefix($prefix = ""){

        $this->prefix = empty($prefix) ? config('cache.prefix').":" : $prefix;
    }
}