@component('mail::message')
# 激活你的账户
欢迎你创建我们的账户!
@component('mail::button', ['color' => 'success','url' => $url])
激活
@endcomponent
Thanks. <br>
{{ $websiteName }}
@endcomponent