@extends('admin.themes.default.layouts.app')

@section('content')
    @include('admin.themes.default.layouts.card')
@endsection

@section('container-fluid')
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">工单管理</h3>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">用户</th>
                            <th scope="col">标题</th>
                            <th scope="col">状态</th>
                            <th scope="col">优先级</th>
                            <th scope="col">上次更新</th>
                            <th scope="col">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($workOrder))
                            @foreach($workOrder as $item)
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
                                        {{$item->title}}
                                    </td>
                                    <td>
                      <span class="badge badge-dot mr-4">
                          @switch($item->status)
                              @case(1)
                              <i class="bg-warning"></i> 待管理员处理
                              @break
                              @case(2)
                              <i class="bg-success"></i> 待用户回复
                              @break
                              @case(3)
                              <i class="bg-danger"></i> 待管理回复
                              @break
                              @case(4)
                              <i class="bg-danger"></i> 已关闭
                              @break
                          @endswitch
                      </span>
                                    </td>
                                    <td>
                                        @switch($item->priority)
                                            @case(1)
                                            低
                                            @break
                                            @case(2)
                                            中
                                            @break
                                            @case(3)
                                            高
                                            @break
                                        @endswitch
                                    </td>
                                    <td>
                                        {{$item->updated_at->format('M d , Y')}}
                                    </td>
                                    <td>
                                        @switch($item->status)
                                            @case(1)
                                            <a href="{{route('admin.work.order.detailed',['id'=>$item->id])}}"
                                               class="btn btn-primary btn-sm">回复</a>
                                            @break
                                            @default
                                            <a href="{{route('admin.work.order.detailed',['id'=>$item->id])}}"
                                               class="btn btn-primary btn-sm">详细</a>
                                            @break
                                        @endswitch
                                        @if($item->status != 4)
                                            <a href="" onclick="event.preventDefault();
                                                     document.getElementById('close-work-order').submit();"
                                               class="btn btn-danger btn-sm">关闭</a>
                                            <form id="close-work-order" action="{{ route('admin.work.order.close') }}"
                                                  method="POST" style="display: none;">
                                                {{csrf_field()}}
                                                <input type="hidden" name="id" value="{{$item->id}}">
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    @if(!empty($workOrder))
                        <nav aria-label="">
                            {{ $workOrder->links() }}
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
