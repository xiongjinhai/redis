<?php
/**
 * @File: Base.php
 * @Author: xiongjinhai
 * @Email:562740366@qq.com
 * @Date: 2017/12/13下午2:30
 * @Version:Version:1.1 2017 by www.dsweixin.com All Rights Reserver
 */

namespace Redis\Command;

use Redis\Traits\HasheTraits;
use Redis\Traits\KeyTraits;
use Redis\Traits\StringTraits;

class Base
{
    use StringTraits,KeyTraits,HasheTraits;
    /**
     * Serialize the value.
     * @param  mixed  $value
     * @return mixed
     */
    protected function serialize($value)
    {
        return is_numeric($value) ? $value : serialize($value);
    }
    /**
     * Unserialize the value.
     * @param  mixed  $value
     * @return mixed
     */
    protected function unserialize($value)
    {
        return is_numeric($value) ? $value : unserialize($value);
    }
}