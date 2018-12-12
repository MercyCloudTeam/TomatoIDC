@extends('themes.default.layouts.home')
@section('content')
    @include('themes.default.layouts.header')
@endsection

@section('container-fluid')
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">订单列表</h3>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">商品名称</th>
                            <th scope="col">订单号</th>
                            <th scope="col">类型</th>
                            <th scope="col">状态</th>
                            <th scope="col">价格</th>
                            <th scope="col">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($orders))
                            @foreach($orders as $order)
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="mb-0 text-sm">{{$order->good->title}}</span>
                                            </div>
                                        </div>
                                    </th>
                                    <td>
                                        {{$order->no}}
                                    </td>
                                    <td>
                                        @if(!empty($order->type))
                                            @switch($order->type)
                                                @case("new")
                                                新购
                                                @break
                                                @case('renew')
                                                续费
                                                @break
                                            @endswitch
                                        @endif
                                    </td>
                                    <td>
                      <span class="badge badge-dot mr-4">
                          @switch($order->status)
                              @case(1)
                              <i class="bg-warning"></i> 未支付
                              @break
                              @case(2)
                              <i class="bg-success"></i> 已支付
                              @break
                              @case(3)
                              <i class="bg-primary"></i> 审核中
                              @break
                          @endswitch
                      </span>
                                    </td>
                                    <td>
                                        {{$order->price}} {{$currencyUnit}}
                                    </td>
                                    <td class="text-left">
                                        @switch($order->status)
                                            @case(1)
                                            <a href="{{route('order.pay.no',['no'=>$order->no])}}"
                                               class="btn btn-primary btn-sm">支付</a>
                                            @break
                                            @default
                                            <a href="{{route('order.detailed',['no'=>$order->no])}}"
                                               class="btn btn-info btn-sm">详细</a>
                                            @break
                                        @endswitch
                                    </td>
                                </tr>
                        @endforeach
                        @endif
                    </table>
                </div>
                <div class="card-footer py-4">
                    @if(!empty($orders))
                        <nav aria-label="" class="mt-5">
                            {{ $orders->links() }}
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
