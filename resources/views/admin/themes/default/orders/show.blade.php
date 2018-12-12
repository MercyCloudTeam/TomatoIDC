@extends('admin.themes.default.layouts.app')

@section('content')
    @include('admin.themes.default.layouts.card')
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
                            <th scope="col">用户</th>
                            <th scope="col">订单号</th>
                            <th scope="col">类型</th>
                            <th scope="col">商品</th>
                            <th scope="col">价格</th>
                            <th scope="col">状态</th>
                            <th scope="col">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($orders))
                            @foreach($orders as $item)
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
                                        {{$item->no}}
                                    </td>
                                    <td>
                                        @if(!empty($item->type))
                                            @switch($item->type)
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
                                        {{$item->good->title}}
                                    </td>
                                    <td>
                                        {{$item->price}} {{$currencyUnit}}
                                    </td>
                                    <td>
                      <span class="badge badge-dot mr-4">
                          @switch($item->status)
                              @case(1)
                              <i class="bg-warning"></i> 未支付
                              @break
                              @case(2)
                              <i class="bg-success"></i> 已支付
                              @break
                              @case(3)
                              <i class="bg-primary"></i> 等待审核
                              @break
                          @endswitch
                      </span>
                                    </td>
                                    <td class="text-left">
                                        <div class="dropdown">
                                            @switch($item->status)
                                                @case(3)
                                                <a href="" onclick="event.preventDefault();
                                                        document.getElementById('re-create-host-{{$item->no}}').submit();"
                                                   class="btn btn-primary btn-sm">尝试开通</a>

                                                <form id="re-create-host-{{$item->no}}"
                                                      action="{{ action('HostController@reCreateHost') }}" method="POST"
                                                      style="display: none;">
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="no" value="{{$item->no}}">
                                                </form>
                                                @break
                                            @endswitch
                                                <a href="{{route('admin.order.edit',['no'=>$item->no])}}" class="btn btn-info btn-sm">详情</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    @if(!empty($orders))
                        <nav aria-label="" class="">
                            {{ $orders->links() }}
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
