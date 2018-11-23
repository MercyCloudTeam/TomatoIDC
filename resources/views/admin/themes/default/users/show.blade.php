@extends('admin.themes.default.layouts.app')

@section('content')
    @include('admin.themes.default.layouts.card')
@endsection

@section('container-fluid')
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">用户管理</h3>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">用户</th>
                            <th scope="col">余额</th>
                            <th scope="col">状态</th>
                            <th scope="col">订单</th>
                            <th scope="col">创建日期</th>
                            <th scope="col">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <a href="#" class="avatar rounded-circle mr-3">
                                            <img alt="Image placeholder" src="{{$user->avatar}}">
                                        </a>
                                        <div class="media-body">
                                            <span class="mb-0 text-sm">{{$user->name}}</span>
                                        </div>
                                    </div>
                                </th>
                                <td>
                                    {{$user->account}} {{$currencyUnit}}
                                </td>

                                <td>
                      <span class="badge badge-dot mr-4">
                          @if($user->status)
                              <i class="bg-success"></i>正常
                          @endif
                      </span>
                                </td>
                                <td>
                                    {{$user->order->count()}}
                                </td>

                                <td>
                                    {{$user->created_at}}
                                </td>
                                <td class="text-left">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <a class="dropdown-item" href="{{route('admin.user.edit',['id'=>$user->id])}}">编辑</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    @if(!empty($users))
                        <nav aria-label="..." class="justify-content-end ">
                            {{ $users->links() }}
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
