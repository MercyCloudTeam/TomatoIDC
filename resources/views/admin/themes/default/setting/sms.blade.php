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
                            <h3 class="mb-0">编辑插件配置</h3>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form method="post" id="add-form" action="{{route('admin.setting.mail')}}">
                        {{csrf_field()}}
                        <h6 class="heading-small text-muted mb-4">邮件驱动配置信息</h6>
                        @if(!empty($form))
                            @foreach($form as $title=>$value)
                                <div class="pl-lg-4">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="form-control-label"
                                                       for="input-username">{{$title}}</label>
                                                <input type="text" class="form-control form-control-alternative"
                                                       value="{{old($title)? old($title):$setting->where('name',$value)->first()->value }}"
                                                       name={{$title}} >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        @include('admin.themes.default.layouts.errors')
                        <input type="submit" class="btn btn-primary" value="保存">
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
