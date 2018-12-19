@extends('admin.themes.default.layouts.app')

@section('content')
    <!-- Header -->
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
        <div class="container-fluid">
            <div class="header-body">
                <!-- Card stats -->
                <div class="row">
                    <div class="col-xl-3 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">订单数量</h5>
                                        <span class="h2 font-weight-bold mb-0">{{$orderCount}}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                            <i class="fas fa-chart-bar"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-nowrap">生成的订单</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">工单数量</h5>
                                        <span class="h2 font-weight-bold mb-0">{{$workOrderCount}}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                            <i class="fas fa-chart-pie"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-nowrap">用户提交的工单</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">用户数量</h5>
                                        <span class="h2 font-weight-bold mb-0">{{$userCount}}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-nowrap">注册用户</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">主机数量</h5>
                                        <span class="h2 font-weight-bold mb-0">{{$hostCount}}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                            <i class="fas fa-building"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-nowrap">已开通的主机</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('container-fluid')
    <div class="row">
    </div>
    <div class="row mt-5">
        <div class="col-xl-12">

        </div>
        <div class="col-xl-8 mb-5 mb-xl-0">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">服务器状态</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{route('admin.server.show')}}" class="btn btn-sm btn-primary">查看更多</a>
                            <a href="" onclick="
var ajax = new XMLHttpRequest();
ajax.open('get','/temp/cron');
ajax.send();
ajax.onreadystatechange = function () {
   if (ajax.readyState==4 &&ajax.status==200) {
    swal({
    type: 'success',
    title: 'Success',
    content: '成功',
    timeout: 200
    })
  　　}
}
" class="btn btn-sm btn-warning">手动监控</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">服务器名称</th>
                            <th scope="col">服务器IP</th>
                            <th scope="col">状态</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($servers))
                            @foreach($servers as $server)
                                <tr>
                                    <th scope="row">
                                        {{$server->title}}
                                    </th>
                                    <td>s
                                        {{$server->ip}}
                                    </td>
                                    <td>
                                   <span class="badge badge-dot mr-4">
                          @switch($server->status)
                                           @case(1)
                                           <i class="bg-success"></i> 正常
                                           @break
                                       @endswitch
                      </span>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">新版本开发</h3>
                        </div>
                        <div class="col text-right">
                            <a href="http://TomatoIDC.com" class="btn btn-sm btn-primary">查看更多</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">功能</th>
                            <th scope="col">预计更新版本</th>
                            <th scope="col">开发进度</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">
                                正式版
                            </th>
                            <td>
                                V1.0.0
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="mr-2">16%</span>
                                    <div>
                                        <div class="progress">
                                            <div class="progress-bar bg-gradient-success" role="progressbar"
                                                 aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"
                                                 style="width: 16%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
