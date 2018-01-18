<?php
/**
 * @File: Predis.php
 * @Author: xiongjinhai
 * @Email:562740366@qq.com
 * @Date: 2017/12/12上午11:17
 * @Version:Version:1.1 2017 by www.dsweixin.com All Rights Reserver
 */

namespace Redis\Facades;

use Illuminate\Support\Facades\Facade;

class Predis extends  Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'predis';
    }
}