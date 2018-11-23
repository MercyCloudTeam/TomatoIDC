@extends('admin.themes.default.layouts.app')

@section('content')
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
                                        <h5 class="card-title text-uppercase text-muted mb-0">版本</h5>
                                        <span class="h2 font-weight-bold mb-0">{{empty($result['version'])?:$result['version']}}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                            <i class="fas fa-chart-bar"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-nowrap">版本 : {{empty($result['type'])?:$result['type']}}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">当前连接数</h5>
                                        <span class="h2 font-weight-bold mb-0">{{empty($result['connect'])?:$result['connect']}}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                            <i class="fas fa-chart-pie"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-nowrap">当前连接数</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">硬盘空间</h5>
                                        <span class="h2 font-weight-bold mb-0">{{ empty($result['disk_free'])?:round($result['disk_free']/1024/1024/1024,3)}}
                                            G</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-nowrap">剩余硬盘大小</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">系统</h5>
                                        <span class="h2 font-weight-bold mb-0">{{empty($result['os'])?:$result['os']}}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                            <i class="fas fa-percent"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-nowrap">运行了{{empty($result['total_run'])?:round($result['total_run']/60/60,3)}}
                                        小时</span>
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
    {{--<div class="row">--}}
    {{--<div class="col">--}}
    {{--<div class="card shadow">--}}
    {{--<div class="card-header border-0">--}}
    {{--<h3 class="mb-0">主机订单</h3>--}}
    {{--</div>--}}
    {{--<div class="table-responsive">--}}
    {{--<table class="table align-items-center table-flush">--}}
    {{--<thead class="thead-light">--}}
    {{--<tr>--}}
    {{--<th scope="col">服务器</th>--}}
    {{--<th scope="col">订单号</th>--}}
    {{--<th scope="col">状态</th>--}}
    {{--<th scope="col">主机ID</th>--}}
    {{--<th scope="col">操作</th>--}}
    {{--</tr>--}}
    {{--</thead>--}}
    {{--<tbody>--}}
    {{--@if(!empty($orders))--}}
    {{--@foreach($orders as $item)--}}
    {{--<tr>--}}
    {{--<th scope="row">--}}
    {{--<div class="media align-items-center">--}}
    {{--<a href="#" class="avatar rounded-circle mr-3">--}}
    {{--<img alt="Image placeholder" src="{{$item->user->avatar}}">--}}
    {{--</a>--}}
    {{--<div class="media-body">--}}
    {{--<span class="mb-0 text-sm">{{$user->user->name}}</span>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</th>--}}
    {{--<td>--}}
    {{--{{$item->no}}--}}
    {{--</td>--}}
    {{--<td>--}}
    {{--<span class="badge badge-dot mr-4">--}}
    {{--@switch($item->status)--}}
    {{--@case(1)--}}
    {{--<i class="bg-warning"></i> 未支付--}}
    {{--@break--}}
    {{--@case(2)--}}
    {{--<i class="bg-success"></i> 已支付--}}
    {{--@break--}}
    {{--@endswitch--}}
    {{--</span>--}}
    {{--</td>--}}
    {{--<td>--}}
    {{--{{$item->host_id}}--}}
    {{--</td>--}}
    {{--<td class="text-left">--}}
    {{--<div class="dropdown">--}}
    {{--<a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
    {{--<i class="fas fa-ellipsis-v"></i>--}}
    {{--</a>--}}
    {{--<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">--}}
    {{--<a class="dropdown-item" href="#">编辑</a>--}}
    {{--<a class="dropdown-item" href="#">删除</a>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</td>--}}
    {{--</tr>--}}
    {{--@endforeach--}}
    {{--@endif--}}
    {{--</tbody>--}}
    {{--</table>--}}
    {{--</div>--}}
    {{--<div class="card-footer py-4">--}}
    {{--<a href="{{route('admin.server.add')}}" class="btn btn-primary">新增服务器</a>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
@endsection
