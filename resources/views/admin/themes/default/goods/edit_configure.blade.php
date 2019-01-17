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
                            <h3 class="mb-0">编辑商品配置</h3>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form method="post" id="add-form" action="{{url('/admin/good/configure/edit')}}">
                        <input type="hidden" name="id" value="{{$configure->id}}">
                        {{csrf_field()}}
                        <h6 class="heading-small text-muted ">根据服务器插件不同需要填写内容不同，若配置不正确，可能会出现问题</h6>
                        <h6 class="heading-small text-muted mb-4">具体填写请查阅插件文档，或提问，目前官方插件只有EP DA CP 支持除
                            面板配置模板（重点）以外的配置填写，全部服务器插件推荐在面板配置模板（重点）填写套餐名字即可</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">配置标题</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="配置标题"
                                               value="{{old('title')?old('title'):$configure->title}}" name="title">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">面板配置模板（重点）</label>
                                        <input type="text" name="config_template"
                                               class="form-control form-control-alternative"
                                               value="{{old('config_template')?old('config_template'):$configure->config_template}}"
                                               placeholder="填写服务器控制面板的资源包/套餐，根据服务器插件配置-可为空">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" onclick="add_form()" class="btn btn-success" id="add_form_button">加载更多配置
                        </button>
                        <div class="pl-lg-4" style="display: none" id="configure">
                            <div class="row">
                                @if(!empty($input))
                                    @foreach($input as $key=>$value)
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label"
                                                       for="input-username">{{$value}}</label>
                                                <input type="text" class="form-control form-control-alternative"
                                                       placeholder="根据服务器插件配置-可为空"
                                                       value="{{old($key)?old($key):$configure->$key}}" name="{{$key}}">
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        @include('admin.themes.default.layouts.errors')
                        <input type="submit" class="btn btn-primary" value="编辑">
                    </form>
                </div>
                <script>
                    function add_form() {
                        var obj = document.getElementById('configure');
                        obj.style.display = "block";
                        document.getElementById('add_form_button').style.display = "none"
                    }
                </script>


            </div>
        </div>
    </div>
@endsection
