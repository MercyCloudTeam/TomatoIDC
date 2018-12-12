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
                            <h3 class="mb-0">编辑订单</h3>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form method="post" id="add-form" action="{{action('OrderController@orderEditAction')}}">
                        {{csrf_field()}}
                        <input type="hidden" name="no" value="{{$order->no}}">
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">订单号</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="订单号" value="{{$order->no}}" disabled>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">商品</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="商品" value="{{$order->good->title}}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">推荐者</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="推荐者编号" value="{{$order->aff_no}}"  name="aff_no">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">价格</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="价格" value="{{$order->price}}" name="price">
                                    </div>
                                </div>
                            </div>
                            @if(!empty($order->domain))
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">域名</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="域名" value="{{$order->domain}}"  name="domain">
                                    </div>
                                </div>
                            </div>
                                @endif
                        </div>
                        @include('admin.themes.default.layouts.errors')
                        <input type="submit" class="btn btn-primary" value="确认">
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
