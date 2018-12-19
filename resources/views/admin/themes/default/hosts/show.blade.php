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
                            <th scope="col">账户名-密码</th>
                            <th scope="col">面板</th>
                            <th scope="col">服务器名称</th>
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
                                        {{$item->host_name}}-{{$item->host_pass}}
                                    </td>
                                    <td>
                                        {{$item->host_panel}}
                                    </td>
                                    <td>
                                        {{$item->order->good->server->title}}
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
                                            <a href="{{route('admin.host.detailed',['id'=>$item->id])}}" class="btn btn-info btn-sm">管理</a>
                                            @switch($item->status)
                                                @case(1)
                                                <button onclick="closehost(this,{{$item->id}})" class="btn btn-danger btn-sm">停用主机</button>
                                                @break
                                                @case(2)
                                                <button onclick="openhost(this,{{$item->id}})" class="btn btn-success btn-sm">开启主机</button>
                                                @break
                                            @endswitch

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>

                <script>
                    function openhost(obj,id) {
                        // var thisObj=$(obj);
                        obj.setAttribute('disabled',true);
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'POST',
                            url: '{{route('admin.host.open')}}',
                            dataType: 'json',
                            async: true,
                            data:"id="+id,
                            success: function (data) {
                                // obj.removeAttribute("disabled");
                                obj.innerHTML = "开启成功";
                                console.log(data);
                                swal('成功','操作成功','success')
                            },
                            error: function (data) {
                                if (data.status !=200) {
                                    swal('失败','出现奇怪的错误了','error');
                                    console.log(data);
                                    obj.removeAttribute("disabled");
                                }
                                // console.log(data);
                            }
                        });
                    }

                    function closehost(obj,id) {
                        // var thisObj=$(obj);
                        obj.setAttribute('disabled',true);
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'POST',
                            url: '{{route('admin.host.close')}}',
                            dataType: 'json',
                            async: true,
                            data:"id="+id,
                            success: function (data) {
                                // obj.removeAttribute("disabled");
                                obj.innerHTML = "停用成功";
                                console.log(data);
                                swal('成功','操作成功','success')
                            },
                            error: function (data) {
                                if (data.status !=200) {
                                    swal('失败','出现奇怪的错误了','error');
                                    console.log(data);
                                    obj.removeAttribute("disabled");
                                }
                                // console.log(data);
                            }
                        });
                    }
                </script>

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
