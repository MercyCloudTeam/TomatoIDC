@extends('admin.themes.default.layouts.app')

@section('content')
    @include('admin.themes.default.layouts.header')
@endsection

@section('container-fluid')
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h3 class="mb-0">编辑系统配置</h3>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form method="post" id="add-form" action="{{route('admin.setting.index')}}">
                        {{csrf_field()}}
                        <h6 class="heading-small text-muted mb-4">网站全局配置信息</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">网站名称</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="网站名称"
                                               value="{{old('title')? old('title'):$setting->where('name','setting.website.title')->first()->value }}"
                                               name="title">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">网站副标题</label>
                                        <input type="text" name="subtitle" class="form-control form-control-alternative"
                                               value="{{old('subtitle')? old('subtitle'):$setting->where('name','setting.website.subtitle')->first()->value }}"
                                               placeholder="网站副标题">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">关键词</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="关键词"
                                               value="{{old('website_keyword')? old('website_keyword'):$setting->where('name','setting.website.index.keyword')->first()->value }}"
                                               name="website_keyword">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">主题</label>
                                        <select class="custom-select" id="inputGroupSelect2102" name="theme">
                                            @if(!empty($themes))
                                                @foreach($themes as $theme)
                                                    <option
                                                            value="{{$theme}}"
                                                            {{old('theme') ? (old('theme') == $theme ? "selected" : "") : ($setting->where('name','setting.website.theme')->first()->value == $theme ? "selected" : "")}}
                                                    >{{$theme}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">管理面板主题</label>
                                        <select class="custom-select" id="inputGroupSelect302" name="admintheme">
                                            @if(!empty($adminThemes))
                                                @foreach($adminThemes as $adminTheme)
                                                    <option
                                                            value="{{$adminTheme}}"
                                                            {{old('admintheme') ? (old('admintheme') == $adminTheme ? "selected" : "") : ($setting->where('name','setting.website.admin.theme')->first()->value == $adminTheme ? "selected" : "")}}
                                                    >{{$adminTheme}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">支付宝支付插件
                                            @if(!empty($setting->where('name','setting.website.payment.alipay')->first()->value))
                                                <a href="{{route('admin.setting.pay',['payment'=>'alipay'])}}">插件配置</a>
                                            @endif
                                        </label>
                                        <select class="custom-select" id="inputGroupSelect102" name="alipayplugin">
                                            @if(!empty($payPlugins))
                                                @foreach($payPlugins as $items)
                                                    @foreach($items as $key =>$value)
                                                        <option
                                                                value="{{$value}}"
                                                                {{old('alipayplugin') ? (old('alipayplugin') == $value ? "selected" : "") : ($setting->where('name','setting.website.payment.alipay')->first()->value == $value ? "selected" : "")}}
                                                        >{{$key}}</option>
                                                    @endforeach
                                                @endforeach
                                            @endif
                                            @if(empty($setting->where('name','setting.website.payment.alipay')->first()->value))
                                                <option value="" selected>未配置插件</option>
                                            @endif
                                            <option value="">不配置插件</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">微信支付插件
                                            @if(!empty($setting->where('name','setting.website.payment.wechat')->first()->value))
                                                <a href="{{route('admin.setting.pay',['payment'=>'wechat'])}}">插件配置</a>
                                            @endif
                                        </label>
                                        <select class="custom-select" id="inputGroupSelect062" name="wechatplugin">
                                            @if(!empty($payPlugins))
                                                @foreach($payPlugins as $items)
                                                    @foreach($items as $key =>$value)
                                                        <option
                                                                value="{{$value}}"
                                                                {{old('wechatplugin') ? (old('wechatplugin') == $value ? "selected" : "") : ($setting->where('name','setting.website.payment.wechat')->first()->value == $value ? "selected" : "")}}
                                                        >{{$key}}</option>
                                                    @endforeach
                                                @endforeach
                                            @endif
                                            @if(empty($setting->where('name','setting.website.payment.wechat')->first()->value))
                                                <option value="" selected>未配置插件</option>
                                            @else
                                                <option value="">不配置插件</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">QQ支付插件
                                            @if(!empty($setting->where('name','setting.website.payment.qqpay')->first()->value))
                                                <a href="{{route('admin.setting.pay',['payment'=>'qqpay'])}}">插件配置</a>
                                            @endif
                                        </label>
                                        <select class="custom-select" id="inputGroupSelect10232" name="qqpayplugin">
                                            @if(!empty($payPlugins))
                                                @foreach($payPlugins as $items)
                                                    @foreach($items as $key =>$value)
                                                        <option
                                                                value="{{$value}}"
                                                                {{old('qqpayplugin') ? (old('qqpayplugin') == $value ? "selected" : "") : ($setting->where('name','setting.website.payment.qqpay')->first()->value == $value ? "selected" : "")}}
                                                        >{{$key}}</option>
                                                    @endforeach
                                                @endforeach
                                            @endif
                                            @if(empty($setting->where('name','setting.website.payment.qqpay')->first()->value))
                                                <option value="" selected>未配置插件</option>
                                            @else
                                                <option value="">不配置插件</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">自定义支付插件（第三方）
                                            @if(!empty($setting->where('name','setting.website.payment.diy')->first()->value))
                                                <a href="{{route('admin.setting.pay',['payment'=>'diy'])}}">插件配置</a>
                                            @endif
                                        </label>
                                        <select class="custom-select" id="inputGroupSelect0152" name="diyplugin">
                                            @if(!empty($payPlugins))
                                                @foreach($payPlugins as $items)
                                                    @foreach($items as $key =>$value)
                                                        <option
                                                                value="{{$value}}"
                                                                {{old('diyplugin') ? (old('diyplugin') == $value ? "selected" : "") : ($setting->where('name','setting.website.payment.diy')->first()->value == $value ? "selected" : "")}}
                                                        >{{$key}}</option>
                                                    @endforeach
                                                @endforeach
                                            @endif
                                            @if(empty($setting->where('name','setting.website.payment.diy')->first()->value))
                                                <option value="" selected>未配置插件</option>
                                            @else
                                                <option value="">不配置插件</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">网站版权</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               value="{{old('copyright')? old('copyright'):$setting->where('name','setting.website.copyright')->first()->value }}"
                                               name="copyright">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">货币单位</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               value="{{old('currencyunit')? old('currencyunit'):$setting->where('name','setting.website.currency.unit')->first()->value }}"
                                               name="currencyunit">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">网站LOGO文字</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               value="{{old('logo')? old('logo'):$setting->where('name','setting.website.logo')->first()->value }}"
                                               name="logo">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">网站LOGO图片</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               value="{{old('logourl')? old('logourl'):$setting->where('name','setting.website.logo.url')->first()->value }}"
                                               name="logourl">
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--<div class="pl-lg-4">--}}
                        {{--<div class="row">--}}
                        {{--<div class="col-lg-6">--}}
                        {{--<div class="form-group">--}}
                        {{--<label class="form-control-label" for="input-username">SMTP服务器</label>--}}
                        {{--<input type="text" class="form-control form-control-alternative"--}}
                        {{--value="{{old('smtpurl')? old('smtpurl'):$setting->where('name','setting.mail.smtp.url')->first()->value }}"--}}
                        {{--name="smtpurl">--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-lg-6">--}}
                        {{--<div class="form-group">--}}
                        {{--<label class="form-control-label" for="input-username">SMTP端口</label>--}}
                        {{--<input type="text" class="form-control form-control-alternative"--}}
                        {{--value="{{old('smtpport')? old('smtpport'):$setting->where('name','setting.mail.smtp.port')->first()->value }}"--}}
                        {{--name="smtpport">--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="pl-lg-4">--}}
                        {{--<div class="row">--}}
                        {{--<div class="col-lg-6">--}}
                        {{--<div class="form-group">--}}
                        {{--<label class="form-control-label" for="input-username">SMTP用户</label>--}}
                        {{--<input type="text" class="form-control form-control-alternative"--}}
                        {{--value="{{old('smtpuser')? old('smtpuser'):$setting->where('name','setting.mail.smtp.user')->first()->value }}"--}}
                        {{--name="smtpuser">--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-lg-6">--}}
                        {{--<div class="form-group">--}}
                        {{--<label class="form-control-label" for="input-username">SMTP密码</label>--}}
                        {{--<input type="text" class="form-control form-control-alternative"--}}
                        {{--value="{{old('smtppassowrd')? old('smtppassowrd'):$setting->where('name','setting.mail.smtp.passowrd')->first()->value }}"--}}
                        {{--name="smtppassowrd">--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">SPA模式（使用SPA模板请开启）</label>
                                        <select class="custom-select" id="inputGroupSelect0622" name="spa">
                                            <option value="1" {{ (old('spa') ? old('spa'): $setting->where('name','setting.website.spa.status')->first()->value) == 1 ? 'selected' :"" }} >
                                                启用
                                            </option>
                                            <option value="0" {{ (old('spa') ? old('spa'): $setting->where('name','setting.website.spa.status')->first()->value) == 0 ? 'selected' :"" }} >
                                                关闭
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">注册邮箱验证(请先配置邮箱驱动)</label>
                                        <select class="custom-select" id="inputGroupSelect0312" name="email_validate">
                                            <option value="2" {{ (old('email_validate') ? old('email_validate'): $setting->where('name','setting.website.user.email.validate')->first()->value) == 2 ? 'selected' :"" }} >
                                                强制验证
                                            </option>
                                            <option value="1" {{ (old('email_validate') ? old('email_validate'): $setting->where('name','setting.website.user.email.validate')->first()->value) == 1 ? 'selected' :"" }} >
                                                验证
                                            </option>
                                            <option value="0" {{ (old('email_validate') ? old('email_validate'): $setting->where('name','setting.website.user.email.validate')->first()->value) == 0 ? 'selected' :"" }} >
                                                不验证
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">管理员销售情况邮件通知</label>
                                        <select class="custom-select" id="inputGroupSelect02142" name="sales_notice">
                                            <option value="1" {{ (old('sales_notice') ? old('sales_notice'): $setting->where('name','setting.website.admin.sales.notice')->first()->value) == 1 ? 'selected' :"" }} >
                                                启用
                                            </option>
                                            <option value="0" {{ (old('sales_notice') ? old('sales_notice'): $setting->where('name','setting.website.admin.sales.notice')->first()->value) == 0 ? 'selected' :"" }} >
                                                关闭
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                {{--<div class="col-lg-6">--}}
                                {{--<div class="form-group">--}}
                                {{--<label class="form-control-label" for="input-email">手机验证</label>--}}
                                {{--<select class="custom-select" id="inputGroupSelect02" name="display">--}}
                                {{--<option value="1" selected="{{ (old('spa') ? old('spa'): $setting->where('name','setting.website.user.phone.validate')->first()->value) == 1 ? 'selected' :"" }}">--}}
                                {{--启用--}}
                                {{--</option>--}}
                                {{--<option value="0" selected="{{ (old('spa') ? old('spa'): $setting->where('name','setting.website.user.phone.validate')->first()->value) == 0 ? 'selected' :"" }}">--}}
                                {{--关闭--}}
                                {{--</option>--}}
                                {{--</select>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">用户购买邮件通知</label>
                                        <select class="custom-select" id="inputGroupSelect0412" name="email_notice">
                                            <option value="1" {{ (old('email_notice') ? old('email_notice'): $setting->where('name','setting.website.user.email.notice')->first()->value) == 1 ? 'selected' :"" }} >
                                                启用
                                            </option>
                                            <option value="0" {{ (old('email_notice') ? old('email_notice'): $setting->where('name','setting.website.user.email.notice')->first()->value) == 0 ? 'selected' :"" }} >
                                                关闭
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">手机号注册</label>
                                        <select class="custom-select" id="inputGroupSelect02s142" name="sales_notice">
                                            <option value="1" {{ (old('sales_notice') ? old('sales_notice'): $setting->where('name','setting.website.admin.sales.notice')->first()->value) == 1 ? 'selected' :"" }} >
                                                启用
                                            </option>
                                            <option value="0" {{ (old('sales_notice') ? old('sales_notice'): $setting->where('name','setting.website.admin.sales.notice')->first()->value) == 0 ? 'selected' :"" }} >
                                                关闭
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">短信发送驱动配置</label>
                                        <select class="custom-select" id="inputGroupSele2ct0412" name="email_notice">
                                            <option value="1" {{ (old('email_notice') ? old('email_notice'): $setting->where('name','setting.website.user.email.notice')->first()->value) == 1 ? 'selected' :"" }} >
                                                启用
                                            </option>
                                            <option value="0" {{ (old('email_notice') ? old('email_notice'): $setting->where('name','setting.website.user.email.notice')->first()->value) == 0 ? 'selected' :"" }} >
                                                关闭
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">微信功能
                                        @if(!empty($setting->where('name','setting.wechat.service.status')->first()->value))
                                            <a href="{{route('admin.setting.wechat')}}">微信配置</a>
                                        @endif
                                        </label>
                                        <select class="custom-select" id="inputGroupSelect02s142" name="wechat_service">
                                            <option value="1" {{ (old('wechat_service') ? old('wechat_service'): $setting->where('name','setting.wechat.service.status')->first()->value) == 1 ? 'selected' :"" }} >
                                                启用
                                            </option>
                                            <option value="0" {{ (old('wechat_service') ? old('wechat_service'): $setting->where('name','setting.wechat.service.status')->first()->value) == 0 ? 'selected' :"" }} >
                                                关闭
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">短信发送驱动配置</label>
                                        <select class="custom-select" id="inputGroupSele2ct0412" name="email_notice">
                                            <option value="1" {{ (old('email_notice') ? old('email_notice'): $setting->where('name','setting.website.user.email.notice')->first()->value) == 1 ? 'selected' :"" }} >
                                                启用
                                            </option>
                                            <option value="0" {{ (old('email_notice') ? old('email_notice'): $setting->where('name','setting.website.user.email.notice')->first()->value) == 0 ? 'selected' :"" }} >
                                                关闭
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">联系客服URL</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               value="{{old('kfurl')? old('kfurl'):$setting->where('name','setting.website.kf.url')->first()->value }}"
                                               name="kfurl">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">隐私策略URL</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               value="{{old('privacy_policy')? old('privacy_policy'):$setting->where('name','setting.website.privacy.policy')->first()->value }}"
                                               name="privacy_policy">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">到期多久后永久删除主机</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               value="{{old('terminate_host_data')? old('terminate_host_data'):$setting->where('name','setting.expire.terminate.host.data')->first()->value }}"
                                               name="terminate_host_data">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">异步开通主机</label>
                                        <select class="custom-select" id="inputGroupSelect02s1422" name="async_create_host">
                                            <option value="1" {{ (old('async_create_host') ? old('async_create_host'): $setting->where('name','setting.async.create.host')->first()->value) == 1 ? 'selected' :"" }} >
                                                启用
                                            </option>
                                            <option value="0" {{ (old('async_create_host') ? old('async_create_host'): $setting->where('name','setting.async.create.host')->first()->value) == 0 ? 'selected' :"" }} >
                                                关闭
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">用户条款URL</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               value="{{old('user_agreements')? old('user_agreements'):$setting->where('name','setting.website.user.agreements')->first()->value }}"
                                               name="user_agreements">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">隐私策略URL</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               value="{{old('privacy_policy')? old('privacy_policy'):$setting->where('name','setting.website.privacy.policy')->first()->value }}"
                                               name="privacy_policy">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">邮件驱动（发送邮件配置）
                                            @if(!empty($setting->where('name','setting.mail.drive')->first()->value))
                                                <a href="{{route('admin.setting.mail')}}">驱动配置</a>
                                            @endif
                                        </label>
                                        <select class="custom-select" id="inputGroupSelect0232" name="mailDrive">
                                            @if(!empty($mailDrive))
                                                @foreach($mailDrive as $key => $value)
                                                    <option
                                                            value="{{$value}}"
                                                            {{old('mailDrive') ? (old('mailDrive') == $value ? "selected" : "") : ($setting->where('name','setting.mail.drive')->first()->value == $value ? "selected" : "")}}
                                                    >{{$key}}</option>
                                                @endforeach
                                            @endif
                                            @if(empty($setting->where('name','setting.mail.drive')->first()->value))
                                                <option value="" selected>未配置插件</option>
                                            @else
                                                <option value="">不配置插件</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">AFF推广系统（未完成）</label>
                                        <select class="custom-select" id="inputGroupSelect0123" name="aff_status">
                                            <option value="1" {{ (old('aff_status') ? old('aff_status'): $setting->where('name','setting.website.aff.status')->first()->value) == 1 ? 'selected' :"" }} >
                                                启用
                                            </option>
                                            <option value="0" {{ (old('aff_status') ? old('aff_status'): $setting->where('name','setting.website.aff.status')->first()->value) == 0 ? 'selected' :"" }} >
                                                关闭
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @include('admin.themes.default.layouts.errors')
                        <input type="submit" class="btn btn-primary" value="保存">
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
