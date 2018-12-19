@extends('themes.default.layouts.home')
@section('content')
    @include('themes.default.layouts.header')
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
                            <th scope="col">商品名称</th>
                            <th scope="col">订单号</th>
                            <th scope="col">状态</th>
                            <th scope="col">面板</th>
                            <th scope="col">到期时间</th>
                            <th scope="col">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($hosts))
                            @foreach($hosts as $host)
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="mb-0 text-sm">{{$host->order->good->title}}</span>
                                            </div>
                                        </div>
                                    </th>
                                    <td>
                                        {{$host->order->no}}
                                    </td>
                                    <td>
                      <span class="badge badge-dot mr-4">
                          @switch($host->status)
                              @case(1)
                              <i class="bg-success"></i> 运行中
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
                                    <td>
                                        {{$host->host_panel}}
                                    </td>
                                    <td>
                                        @if(empty($host->deadline))
                                            永久
                                        @else
                                            {{substr($host->deadline,0,11)}}
                                        @endif
                                    </td>
                                    <td class="text-left">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            @if($host->status == 1 )
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item" href="{{route('host.detailed',['id'=>$host->id])}}">信息/管理</a>
                                                <a class="dropdown-item" href="{{route('host.renew',['id'=>$host->id])}}">续费</a>
                                                <button class="dropdown-item" onclick="event.preventDefault();
                                                        document.getElementById('host-panel-{{$host->id}}').submit();" >主机面板</button>
                                            </div>
                                            <form id="host-panel-{{$host->id}}"
                                                  action="{{ route('host.panel.login') }}" method="POST"
                                                  style="display: none;">
                                                {{csrf_field()}}
                                                <input type="hidden" name="id" value="{{$host->id}}">
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                        @endforeach
                        @endif
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
