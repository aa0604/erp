<?php
/**
 * Created by PhpStorm.
 * User: xing.chen
 * Date: 2017/11/20
 * Time: 14:31
 */

namespace xing\erp\core;


interface ERPInterface
{

    public static function config($config = []);

    public function getOrderInfo($orderSn);

    public function getOrderStatus($orderSn);

    public function addOrder($params);
}