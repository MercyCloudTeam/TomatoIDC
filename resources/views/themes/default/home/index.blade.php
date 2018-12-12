@extends('themes.default.layouts.home')

@section('content')

    <!-- Header -->
    <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center"
         style="min-height: 600px; background-image: url({{asset('assets/themes/argon/img/computer-1149148.jpg')}}); background-size: cover; background-position: center top;">
        <!-- Mask -->
        <span class="mask bg-gradient-default opacity-8"></span>
        <!-- Header container -->
        <div class="container-fluid d-flex align-items-center">
            <div class="row">
                <div class="col-lg-7 col-md-10">
                    <p class="text-white" style="font-size: 1rem">欢迎回来</p>
                    <h1 class="display-2 text-white">{{Auth::user()->name}}</h1>
                    <p class="text-white mt-0 mb-5">祝你开心每一天！</p>
                    <a href="{{route('user.profile')}}" class="btn btn-info">个人设置</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
@endsection

@section('container-fluid')
    <div class="row">
        <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
            <div class="card card-profile shadow">
                <div class="row justify-content-center">
                    <div class="col-lg-3 order-lg-2">
                        <div class="card-profile-image">
                            <a href="https://gravatar.com/">
                                <img src="{{Auth::user()->avatar}}" class="rounded-circle">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                    <div class="d-flex justify-content-between">
                    </div>
                </div>
                <div class="card-body pt-0 pt-md-4">
                    <div class="row">
                        <div class="col">
                            <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                                <div>
                                    <span class="heading">{{Auth::user()->order->count()}}</span>
                                    <span class="description">订单</span>
                                </div>
                                <div>
                                    <span class="heading">{{Auth::user()->account}}</span>
                                    <span class="description">余额</span>
                                </div>
                                <div>
                                    <span class="heading">{{Auth::user()->workOrder->count()}}</span>
                                    <span class="description">工单</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <h3>
                            {{Auth::user()->name}}<span class="font-weight-light"></span>
                        </h3>
                        <div class="h5 font-weight-300">
                            <i class="ni location_pin mr-2"></i>{{Auth::user()->email}}
                        </div>
                        {{--<div class="h5 mt-4">--}}
                        {{--<i class="ni business_briefcase-24 mr-2"></i>Solution Manager - Creative Tim Officer--}}
                        {{--</div>--}}
                        {{--<div>--}}
                        {{--<i class="ni education_hat mr-2"></i>University of Computer Science--}}
                        {{--</div>--}}
                        {{--<hr class="my-4" />--}}
                        <p>{{Auth::user()->signature}}</p>
                        {{--<a href="#">Show more</a>--}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">订购的服务</h3>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">服务</th>
                            <th scope="col">价格</th>
                            <th scope="col">状态</th>
                            <th scope="col">到期时间</th>
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
                                        {{$order->price}} {{$currencyUnit}}
                                    </td>
                                    <td>
                      <span class="badge badge-dot mr-4">
                          @switch($order->status)
                              @case(2)
                              <i class="bg-success"></i> 正常
                              @break
                              @case(3)
                              <i class="bg-primary"></i> 审核中
                              @break
                          @endswitch
                      </span>
                                    </td>
                                    @if(!empty($order->host))
                                        <td>
                                            @if(empty($order->host->deadline))
                                                永久
                                            @else
                                                {{substr($order->host->deadline,0,11)}}
                                            @endif
                                        </td>
                                        <td class="text-left">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    @if($order->status == 2 && !empty($order->host_id))
                                                        <a class="dropdown-item"
                                                           href="{{route('host.detailed',['id'=>$order->host->id])}}">信息/管理</a>
                                                        <a class="dropdown-item"
                                                           href="{{$order->host->host_url}}">主机面板</a>
                                                    @endif
                                                    <a class="dropdown-item"
                                                       href="{{route('order.detailed',['no'=>$order->no])}}">订单详细</a>
                                                </div>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    @if(!empty($orders))
                        <nav aria-label="...">
                            {{ $orders->links() }}
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
