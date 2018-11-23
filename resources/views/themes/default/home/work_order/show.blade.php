@extends('themes.default.layouts.home')
@section('content')
    @include('themes.default.layouts.header')
@endsection

@section('container-fluid')
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">工单列表</h3>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">标题</th>
                            <th scope="col">编号</th>
                            <th scope="col">状态</th>
                            <th scope="col">更新日期</th>
                            <th scope="col">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($workOrder))
                            @foreach($workOrder as $item)
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="mb-0 text-sm">{{$item->title}}</span>
                                            </div>
                                        </div>
                                    </th>
                                    <td>
                                        {{$item->id}}
                                    </td>
                                    <td>
                      <span class="badge badge-dot mr-4">
                          @switch($item->status)
                              @case(1)
                              <i class="bg-success"></i> 处理中
                              @break
                              @case(2)
                              <i class="bg-warning"></i> 待回复
                              @break
                              @case(4)
                              <i class="bg-danger"></i> 已关闭
                              @break
                          @endswitch
                      </span>
                                    </td>
                                    <td>
                                        {{$item->updated_at->format('M d , Y')}}
                                    </td>
                                    <td class="text-left">
                                        @switch($item->status)
                                            @case(2)
                                            <a href="{{route('work.order.detailed',['id'=>$item->id])}}"
                                               class="btn btn-primary btn-sm">回复</a>
                                            @break
                                            @default
                                            <a href="{{route('work.order.detailed',['id'=>$item->id])}}"
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
                    <a href="{{route('work.order.add')}}" class="btn btn-primary">发起工单</a>
                    @if(!empty($workOrder))
                        <nav aria-label="" class="mt-5">
                            {{ $workOrder->links() }}
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
