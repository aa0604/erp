<?php
/**
 * Created by PhpStorm.
 * User: xing.chen
 * Date: 2017/11/20
 * Time: 14:49
 */

namespace xing\erp;


class ERP
{

    /**
     * @param array $config
     * @return drive\tongTu\ERPTongTuService
     */
    public static function getInstance($config = [])
    {
        switch ($config['driveName']) {
            case 'tongTu':
                $class = \xing\erp\drive\tongTu\ERPTongTuService::config($config);
                break;
            default:
                throw new \Exception('请在 config 里指定 driveName 为存在的驱动，如 tongTu');
        }
        return $class;
    }
}