@extends('admin.themes.default.layouts.app')

@section('content')
    @include('admin.themes.default.layouts.card')
@endsection

@section('container-fluid')
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">服务器管理</h3>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">服务器名称</th>
                            <th scope="col">服务器IP</th>
                            <th scope="col">状态</th>
                            <th scope="col">插件</th>
                            <th scope="col">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($servers))
                            @foreach($servers as $item)
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <a href="{{route('admin.server.status',['id'=>$item->id])}}"
                                                   class="mb-0 text-sm">{{$item->title}}</a>
                                            </div>
                                        </div>
                                    </th>
                                    <td>
                                        {{$item->ip}}
                                    </td>
                                    <td>
                                                                           <span class="badge badge-dot mr-4">
                                        @switch($item->status)
                                                                                   @case(1)
                                                                                   <i class="bg-success"></i> 正常
                                                                                   @break
                                                                               @endswitch
                                                              </span>
                                    </td>
                                    <td>
                                        {{$item->plugin}}
                                    </td>
                                    <td class="text-left">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item"
                                                   href="{{route('admin.server.edit',['id'=>$item->id])}}">编辑</a>
                                                <a class="dropdown-item" onclick="event.preventDefault();
                                                        document.getElementById('del-server-{{$item->id}}').submit();"
                                                   href="">删除</a>
                                                <form id="del-server-{{$item->id}}"
                                                      action="{{ route('admin.server.del') }}" method="POST"
                                                      style="display: none;">
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="id" value="{{$item->id}}">
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <a href="{{route('admin.server.add')}}" class="btn btn-primary">新增服务器</a>
                </div>
            </div>
        </div>
    </div>
@endsection
