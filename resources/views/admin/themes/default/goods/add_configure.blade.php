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
                            <h3 class="mb-0">添加商品分组</h3>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form method="post" id="add-form" action="{{url('/admin/good/configure/add')}}">
                        {{csrf_field()}}
                        <h6 class="heading-small text-muted mb-4">根据服务器插件不同需要填写内容不同，若配置不正确，可能会出现问题</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">配置标题</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="配置标题" value="{{old('title')}}" name="title">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">QPS</label>
                                        <input type="text" name="qps" class="form-control form-control-alternative"
                                               value="{{old('qps')}}" placeholder="根据不同服务器插件填写（可为空）">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">PHP版本</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="根据不同服务器插件填写（可为空）" value="{{old('php_version')}}"
                                               name="php_version">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">mysql版本</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               value="{{old('mysql_version')}}" placeholder="根据不同服务器插件填写（可为空）"
                                               name="mysql_version">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">数据库大小</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="根据不同服务器插件填写（可为空）" value="{{old('db_quota')}}"
                                               name="db_quota">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Web空间大小</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               value="{{old('web_quota')}}" placeholder="根据不同服务器插件填写（可为空）"
                                               name="web_quota">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">模块</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="根据不同服务器插件填写（可为空）" value="{{old('module')}}"
                                               name="module">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">类型</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               value="{{old('type')}}" placeholder="根据不同服务器插件填写（可为空）"
                                               name="type">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">速度限制</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="根据不同服务器插件填写（可为空）" value="{{old('speed_limit')}}"
                                               name="speed_limit">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">最大连接数</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               value="{{old('max_connect')}}" placeholder="根据不同服务器插件填写（可为空）"
                                               name="max_connect">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">域名</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="根据不同服务器插件填写（可为空）" value="{{old('domain')}}" name="domain">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">主机主目录</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               value="{{old('doc_root')}}" placeholder="根据不同服务器插件填写（可为空）"
                                               name="doc_root">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">是否开启日记分析</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="根据不同服务器插件填写（可为空）" value="{{old('log_handle')}}"
                                               name="log_handle">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">流量限制</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               value="{{old('flow_limit')}}" placeholder="根据不同服务器插件填写（可为空）"
                                               name="flow_limit">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">默认绑定目录</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="根据不同服务器插件填写（可为空）" value="{{old('subdir')}}" name="subdir">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">最多工作者</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               value="{{old('max_worker')}}" placeholder="根据不同服务器插件填写（可为空）"
                                               name="max_worker">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">是否允许绑定子目录</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="根据不同服务器插件填写（可为空）" value="{{old('subdir_flag')}}"
                                               name="subdir_flag">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">最多子目录数</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               value="{{old('max_subdir')}}" placeholder="根据不同服务器插件填写（可为空）"
                                               name="max_subdir">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">开启FTP</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="根据不同服务器插件填写（可为空）" value="{{old('ftp')}}" name="ftp">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">时长（天）</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               value="{{old('time')}}" placeholder="根据不同服务器插件填写（可为空）" name="time">
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
