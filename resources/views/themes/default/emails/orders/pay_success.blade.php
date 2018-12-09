@component('mail::message')
# 你的订单支付成功
## 订单信息
订单号： {{$orderNo}} <br>
商品: {{$goodTitle}} <br>
金额: {{$orderPrice}} {{$currencyUnit}} <br>
Thanks. <br>
{{ $websiteName }}
@endcomponent