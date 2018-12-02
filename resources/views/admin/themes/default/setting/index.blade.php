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
                                        <label class="form-control-label" for="input-email">主题</label>
                                        <select class="custom-select" id="inputGroupSelect02" name="theme">
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
                                        <select class="custom-select" id="inputGroupSelect02" name="admintheme">
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
                                        <select class="custom-select" id="inputGroupSelect02" name="alipayplugin">
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
                                        <select class="custom-select" id="inputGroupSelect02" name="wechatplugin">
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
                                            @endif
                                                <option value="">不配置插件</option>
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
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">SMTP服务器</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               value="{{old('smtpurl')? old('smtpurl'):$setting->where('name','setting.mail.smtp.url')->first()->value }}"
                                               name="smtpurl">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">SMTP端口</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               value="{{old('smtpport')? old('smtpport'):$setting->where('name','setting.mail.smtp.port')->first()->value }}"
                                               name="smtpport">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">SMTP用户</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               value="{{old('smtpuser')? old('smtpuser'):$setting->where('name','setting.mail.smtp.user')->first()->value }}"
                                               name="smtpuser">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">SMTP密码</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               value="{{old('smtppassowrd')? old('smtppassowrd'):$setting->where('name','setting.mail.smtp.passowrd')->first()->value }}"
                                               name="smtppassowrd">
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
