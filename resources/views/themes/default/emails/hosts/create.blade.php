@component('mail::message')
# 你的主机创建成功
你的主机创建成功，感谢你的购买! <br>
## 主机信息
@component('mail::table')
| 名称　　   | 信息              |
| --------- |:----------------:|
| 商品      |  {{$goodTitle}}  |
| 价格      |  {{$orderPrice}} {{$currencyUnit}}   |
| 服务器IP  |  {{$hostIp}}     |
| 管理账户   | {{$hostName}}   |
| 管理密码   | {{$hostPass}}   |
| 管理面板   | {{$hostPanel}}  |
| 管理地址   | {{$hostUrl}}    |
| 到期时间   | {{$deadline}} 　 |
@endcomponent
Thanks. <br>
{{ $websiteName }}
@endcomponent