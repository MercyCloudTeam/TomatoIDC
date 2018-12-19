@extends('admin.themes.default.layouts.app')

@section('content')
    @include('admin.themes.default.layouts.card')
@endsection

@section('container-fluid')
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h3 class="mb-0">编辑主机</h3>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form method="post"  action="{{action('HostController@hostEditAction')}}">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$host->id}}">
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group"
                                         onclick="window.location.href='{{route('admin.order.edit',['no'=>$host->order->no])}}'">
                                        <label class="form-control-label" for="input-username">商品订单号</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="订单号" value="{{$host->order->no}}" disabled>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">主机账户名（现只更改本地显示）</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="主机账户名" value="{{$host->host_name}}" name="host_name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">主机密码（现只更改本地显示）</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="主机密码" value="{{$host->host_pass}}" name="host_pass">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">到期时间</label>
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                            class="ni ni-calendar-grid-58"></i></span>
                                            </div>
                                            <input class="form-control datepicker" placeholder="到期时间" name="deadline"
                                                   type="text"
                                                   value="{{$host->deadline?
                                                   substr($host->deadline,5,2)."/".
                                                   substr($host->deadline,8,2)."/".
                                                   substr($host->deadline,0,4)
                                                   :$host->deadline}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('admin.themes.default.layouts.errors')
                        <input type="submit" class="btn btn-primary" value="更新">
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
