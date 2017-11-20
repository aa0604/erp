<?php
/**
 * Created by PhpStorm.
 * User: xing.chen
 * Date: 2017/11/20
 * Time: 14:34
 */

namespace xing\erp\core;


class ERPBaseService
{
    protected $erpBaseUrl;

    /**
     * @param $methodUrl
     * @param array $post
     * @return string
     */
    protected function query($methodUrl, $post = [])
    {
        $url = $this->erpBaseUrl . $methodUrl;

        return \xing\helper\resource\HttpHelper::post($url, $post);
    }
}