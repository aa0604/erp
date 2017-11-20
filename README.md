# erp
erp 服务插件 目前支持通途

### 查询订单
```php
<?php

$erp = \xing\erp\ERP::getInstance([
        'driveName' => 'tongTu',
        'token' => '通途给的token',
        'merchantId' => '通途给的merchantId',]);

$result = $erp->getOrderInfo('订单号');

$lastSynResult = 'errorCode: ' . $result['errorCode'] . ' errorMessage：' . $result['errorMessage'];
print_r($result);
if ($result['ack'] == 'Success') {

    $orderStatus = $result['data']['array']['orderStatus'] ?? '';

    switch ($orderStatus) {
        // 订单不存在： 增加订单
        case '':
            // 增加订单到erp业务代码 ....
            $result = $erp->addOrder($info);
            break;
        // 已发货： 修改订单状态，并设置为同步完成
        case 'despatched':
            // 已发货，修改我们的订单状态为已发货业务代码 ....
    }
} else {
    // 本次同步失败 业务
    exit('查询订单失败');
}
```

### 向ERP增加新订单
```php
<?php

// 将我们的数据转为通途需要数据
function formatOrderInfo($order)
{
    

        $transactions = [];
        foreach ($order->storeOrderGoods as $goods)
        {
            $transactions[] = [
//                'shippingFeeIncome' => null,
//                'shipType' => null,
//                'shippingFeeIncomeCurrency' => null,
//                'productsTotalPriceCurrency' => null,
                'productsTotalPrice' => $goods->price,
                'quantity' => $goods->buyNumber,
                'sku' => $goods->sku,
                'orderTransactionNum' => $goods->id,
            ];
        }

        $params = [
            'order' => [
                'buyerInfo' => [
                    'buyerCountryCode' => $country->countryCode,
                    'buyerPostalCode' => $order->zipCode,
                    'buyerState' => $order->area_1,
                    'buyerCity' => $order->area_2,
                    'buyerPhone' => $order->tel,
                    'buyerAddress1' => $order->address,
                    'buyerEmail' => $user->email,
                    'buyerAccount' => $user->username,
                    'buyerName' => $order->firstname.($order->lastname??' '.$order->lastname),
                ],
                'transactions' => $transactions,
//                'taxIncome' => 0,
                'saleRecordNum' => $order->orderSn,
                'sellerAccountCode' => '',
                'taxIncomeCurrency' => 'USD',
                'platformCode' => 'Caseier',
                'currency' => '',
//                'insuranceIncome' => '',
//                'insuranceIncomeCurrency' => '',
                'totalPriceCurrency' => 'USD',
                'notes' => '',
                'ordercurrency' => 'USD',
                'totalPrice' => $order->payMoney,
            ],
        ];
        return $params;
}
$info = formatOrderInfo([]);
$erp = \xing\erp\ERP::getInstance([
        'driveName' => 'tongTu',
        'token' => '通途给的token',
        'merchantId' => '通途给的merchantId',]);
$result = $erp->addOrder($info);
```