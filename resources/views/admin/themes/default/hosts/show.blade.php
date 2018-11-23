@extends('admin.themes.default.layouts.app')

@section('content')
    @include('admin.themes.default.layouts.card')
@endsection

@section('container-fluid')
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">主机列表</h3>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">用户</th>
                            <th scope="col">订单号</th>
                            <th scope="col">面板</th>
                            <th scope="col">服务器名称-服务器IP</th>
                            <th scope="col">到期时间</th>
                            <th scope="col">状态</th>
                            <th scope="col">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($hosts))
                            @foreach($hosts as $item)
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <a href="#" class="avatar rounded-circle mr-3">
                                                <img alt="Image placeholder" src="{{$item->user->avatar}}">
                                            </a>
                                            <div class="media-body">
                                                <span class="mb-0 text-sm">{{$item->user->name}}</span>
                                            </div>
                                        </div>
                                    </th>
                                    <td>
                                        {{$item->order->no}}
                                    </td>
                                    <td>
                                        {{$item->host_panel}}
                                    </td>
                                    <td>
                                        {{$item->order->good->server->title}}-{{$item->order->good->server->ip}}
                                    </td>
                                    <td>
                                        @if(empty($item->deadline))
                                            永久
                                        @else
                                            {{substr($item->deadline,0,11)}}
                                        @endif
                                    </td>
                                    <td>
                      <span class="badge badge-dot mr-4">
                          @switch($item->status)
                              @case(1)
                              <i class="bg-success"></i> 正常
                              @break
                              @case(2)
                              <i class="bg-warning"></i> 已过期
                              @break
                              @default
                              <i class="bg-danger"></i> 未定义
                              @break
                          @endswitch
                      </span>
                                    </td>
                                    <td class="text-left">
                                        <div class="dropdown">
                                            <a href="" class="btn btn-info btn-sm">管理</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    @if(!empty($hosts))
                        <nav aria-label="">
                            {{ $hosts->links() }}
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
