<?php
/**
 * Created by PhpStorm.
 * User: xing.chen
 * Date: 2017/11/20
 * Time: 14:30
 */

namespace xing\erp\drive\tongTu;


class ERPTongTuService extends \xing\erp\core\ERPBaseService implements \xing\erp\core\ERPInterface
{

    public $config;
    public $erpBaseUrl = 'https://openapi.tongtool.com/';


    /**
     * 初始化配置
     * @param array $config
     * @return ERPTongTuService
     */
    public static function config($config = [])
    {
        $class = new self;
        $class->config = $config;
        $class->token = $config['token'];
        $class->merchantId = $config['merchantId'];
        return $class;
    }

    /**
     * 获取订单详情
     * @param $orderSn
     * @return mixed
     */
    public function getOrderInfo($orderSn)
    {
        /*$this->erpBaseUrl = 'http://api.local-caseier.com/';
        $method = 'store/test?test=1';
        er($this->query($method, ['orderId' => $orderSn]));*/
        $method = 'process/resume/openapi/tongtool/ordersQuery';
        $result = $this->query($method, ['orderId' => $this->config['prefixOrderSn'] . $orderSn]);
        return $result;
    }

    /**
     * 获取订单状态
     * @param $orderSn
     * @return string
     */
    public function getOrderStatus($orderSn)
    {
        $order = $this->getOrderInfo($orderSn);
        return $order['orderStatus'] ?? '';
    }

    /**
     * 增加订单
     * @param $params
     * @return array
     */
    public function addOrder($params)
    {
        $method = 'process/resume/openapi/tongtool/addorder';
        $result = $this->query($method, $params);
        return $result;
    }

    /**
     * 查询一个物流信息
     * @param $orderSn
     * @return array
     */
    public function getOrderExpres($orderSn)
    {
        $method = 'process/resume/openapi/tongtool/trackingNumberQuery';
        $result = $this->query($method, ['orderIds' => [$this->config['prefixOrderSn'] . $orderSn]]);
        return $result['data']['array'][0] ?? [];
    }

    /**
     * @param $method
     * @param array $params
     * @return array
     */
    protected function query($method, $params= [])
    {
        $params['merchantId'] = $this->config['merchantId'];
        $post = [
            'token' => $this->config['token'],
            'data' => $params,
        ];
        $result = parent::query($method, ['q'=> json_encode($post)]);
        $result = json_decode($result, 1);
        return $result;
    }
}